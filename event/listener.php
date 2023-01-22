<?php

/**
 *
 * Chevereto API
 *
 * @copyright © 2017—2020, 2023 Lord Beaver
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License version 2
 *
 */

namespace lordbeaver\chevereto\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\files\factory */
	protected $factory;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \phpbb\cache\driver\driver_interface $cache
	 * @param \phpbb\config\config                 $config
	 * @param \phpbb\files\factory                 $factory
	 * @param \phpbb\log\log                       $log
	 * @param \phpbb\template\template             $template
	 * @param \phpbb\user                          $user
	 */
	public function __construct(
		\phpbb\cache\driver\driver_interface $cache,
		\phpbb\config\config $config,
		\phpbb\files\factory $factory,
		\phpbb\log\log $log,
		\phpbb\template\template $template,
		\phpbb\user $user
	) {
		$this->cache    = $cache;
		$this->config   = $config;
		$this->factory  = $factory;
		$this->log      = $log;
		$this->template = $template;
		$this->user     = $user;
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	public static function getSubscribedEvents()
	{
		return array(
			'core.message_parser_check_message' => 'chevereto',
			'core.page_header_after'            => 'template',
			'core.user_setup'                   => 'language',
		);
	}

	public function chevereto($event)
	{
		$allow_bbcode     = $event['allow_bbcode'];
		$allow_img_bbcode = $event['allow_img_bbcode'];
		$allow_url_bbcode = $event['allow_url_bbcode'];
		$images           = array();
		$message          = $event['message'];

		if (@extension_loaded('curl') && $allow_bbcode && $allow_img_bbcode)
		{
			preg_match_all('#\[img\](.*)\[/img\]#uisU', $message, $images, PREG_SET_ORDER);

			$curl     = false;
			$files    = $this->config['chevereto_api_files'] ? true : false;
			$handlers = array();
			$mh       = null;
			$options  = array(
				CURLOPT_HEADER         => false,
				CURLOPT_POST           => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT        => 10,
				CURLOPT_URL            => $this->config['chevereto_api_url'],
			);
			$type = 'bbcode-embed';

			if ($files)
			{
				$img_temp = array();
				$upload   = $this->factory->get('upload')
					->set_allowed_extensions(array('.+'))
					->set_max_filesize($this->config['chevereto_api_maxsize'] * 1048576)
					->set_disallowed_content(array());
			}
		}

		if (!empty($images[0]))
		{
			foreach ($images as $image)
			{
				$img_code   = $image[0];
				$img_source = false;
				$img_url    = str_replace(' ', '%20', trim($image[1]));

				if ($allow_url_bbcode && $this->config['chevereto_type_img'] != $type && !preg_match('#\[url(=(.*))?\](.*)?' . preg_quote($img_code) . '(.*)?\[/url\]#uisU', $message))
				{
					$type = $this->config['chevereto_type_img'];
				}

				if ($this->check($img_url))
				{
					$hash = $this->hash($img_url);

					if ($ok = $this->cache->get($hash))
					{
						$message = $this->replace($ok, $message, $img_code, $type);
					}
					else
					{
						if ($files && !isset($handlers['ch'][$hash]))
						{
							$img_temp[$hash] = $upload->handle_upload('files.types.remote', $img_url);

							if ($img_temp[$hash]->is_uploaded())
							{
								$img_source = curl_file_create($img_temp[$hash]->get('filename'), 'application/octet-stream', $img_temp[$hash]->get('realname'));
							}
							elseif ($this->config['chevereto_debug'])
							{
								$this->log->add('critical', $this->user->data['user_id'], $this->user->ip, 'LOG_CHV_ERROR', false, array(999, $img_temp[$hash]->error[0]));
							}
						}
						elseif (!isset($handlers['ch'][$hash]))
						{
							$img_source = $img_url;
						}

						if ($img_source)
						{
							if (!$curl)
							{
								$mh   = curl_multi_init();
								$curl = true;
							}

							$handlers['im'][$hash] = $img_code;
							$handlers['ch'][$hash] = curl_init();
							curl_setopt_array($handlers['ch'][$hash], $options);

							switch ($this->config['chevereto_api_version'])
							{
								case '1':
									curl_setopt($handlers['ch'][$hash], CURLOPT_POSTFIELDS, array(
										'key'    => $this->config['chevereto_api_key'],
										'source' => $img_source,
									));
									break;
								case '1.1':
									curl_setopt($handlers['ch'][$hash], CURLOPT_HTTPHEADER, array(
										'X-API-Key: ' . $this->config['chevereto_api_key'],
									));
									curl_setopt($handlers['ch'][$hash], CURLOPT_POSTFIELDS, array(
										'source' => $img_source,
									));
									break;
								default:
									if ($this->config['chevereto_debug'])
									{
										$this->log->add('critical', $this->user->data['user_id'], $this->user->ip, 'LOG_CHV_ERROR_API', false);
									}
							}

							curl_multi_add_handle($mh, $handlers['ch'][$hash]);
						}
					}
				}
			}

			if ($curl)
			{
				$running = null;

				do
				{
					curl_multi_exec($mh, $running);
				}
				while ($running > 0);

				foreach ($handlers['im'] as $hash => $img_code)
				{
					if ($ok = curl_multi_getcontent($handlers['ch'][$hash]))
					{
						curl_multi_remove_handle($mh, $handlers['ch'][$hash]);
						curl_close($handlers['ch'][$hash]);
						$ok = json_decode($ok, true);

						if (200 == $ok['status_code'])
						{
							$message = $this->replace($ok['image'], $message, $img_code, $type);
							$this->cache->put($hash, $ok['image'], 86400);
						}
						elseif ($this->config['chevereto_debug'])
						{
							$this->log->add('critical', $this->user->data['user_id'], $this->user->ip, 'LOG_CHV_ERROR', false, array(
								$ok['error']['code'],
								$ok['error']['message'],
							));
						}

						if (isset($img_temp[$hash]) && $img_temp[$hash]->is_uploaded())
						{
							@unlink($img_temp[$hash]->get('filename'));
						}
					}
				}

				curl_multi_close($mh);
			}

			$event['message'] = $message;
		}
	}

	public function language($event)
	{
		$lang_set_ext   = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'lordbeaver/chevereto',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function template($event)
	{
		$this->template->assign_vars(array(
			'CHV_PUP_COLOR'  => $this->config['chevereto_pup_color'],
			'CHV_PUP_ENABLE' => $this->config['chevereto_pup_enable'] ? true : false,
			'CHV_PUP_HOST'   => $this->host(),
			'CHV_PUP_MODE'   => $this->config['chevereto_pup_mode'],
			'CHV_PUP_TYPE'   => $this->config['allow_post_links'] ? $this->config['chevereto_type_pup'] : 'bbcode-embed',
		));
	}

	private function check($img_url)
	{
		$img_url = parse_url(strtolower($img_url));
		$hash    = $this->hash($img_url['host']);

		if ($ok = $this->cache->get($hash))
		{
			$result = $ok;
		}
		elseif ($this->config['chevereto_https'] && 'https' == $img_url['scheme'])
		{
			$result = false;
		}
		else
		{
			$exclude = array(
				strtolower($this->config['server_name']),
				$this->host(),
			);

			if (!empty($this->config['chevereto_exclude']))
			{
				$exclude = array_merge($exclude, explode(',', strtolower($this->config['chevereto_exclude'])));
			}

			$host   = $img_url['host'];
			$result = true;

			if (in_array($host, $exclude))
			{
				$result = false;
			}
			elseif ($this->config['chevereto_subdomain'])
			{
				while ($result && substr_count($host, '.') > 1)
				{
					$host   = substr(strstr($host, '.'), 1);
					$result = !in_array($host, $exclude);
				}
			}

			$this->cache->put($hash, $result, 3600);
		}

		return $result;
	}

	private function hash($url)
	{
		return '_chv_h_' . hash('sha256', $url);
	}

	private function host()
	{
		return parse_url(strtolower($this->config['chevereto_api_url']), PHP_URL_HOST);
	}

	private function replace($response, $message, $img_code, $type)
	{
		$url = null;

		if ('bbcode-embed' == $type)
		{
			$result = str_replace($img_code, '[img]' . $response['url'] . '[/img]', $message);
		}
		else
		{
			switch ($type)
			{
				case 'bbcode-embed-full':
					$url = $response['url'];
					break;
				case 'bbcode-embed-medium':
					$url = isset($response['medium']['url']) ? $response['medium']['url'] : $response['url'];
					break;
				case 'bbcode-embed-thumbnail':
					$url = isset($response['thumb']['url']) ? $response['thumb']['url'] : $response['url'];
					break;
				default:
					if ($this->config['chevereto_debug'])
					{
						$this->log->add('critical', $this->user->data['user_id'], $this->user->ip, 'LOG_CHV_ERROR_TYPE', false);
					}
			}

			$result = str_replace($img_code, '[url=' . $response['url_viewer'] . '][img]' . $url . '[/img][/url]', $message);
		}

		return $result;
	}
}
