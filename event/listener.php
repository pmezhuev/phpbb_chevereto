<?php

/**
 *
 * Chevereto API
 *
 * @copyright © 2017, 2018 Lord Beaver
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

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 * @static
	 * @access public
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.message_parser_check_message'	 => 'chevereto',
			'core.page_header_after'			 => 'template',
			'core.user_setup'					 => 'language',
		);
	}

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\log\log_interface */
	protected $log;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \phpbb\cache\driver\driver_interface	$cache
	 * @param \phpbb\config\config					$config
	 * @param \phpbb\log\log						$log
	 * @param \phpbb\user							$user
	 */
	public function __construct(\phpbb\cache\driver\driver_interface $cache, \phpbb\config\config $config,
			\phpbb\log\log_interface $log, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->cache	 = $cache;
		$this->config	 = $config;
		$this->log		 = $log;
		$this->template	 = $template;
		$this->user		 = $user;
	}

	public function chevereto($event)
	{
		$allow_bbcode		 = $event['allow_bbcode'];
		$allow_img_bbcode	 = $event['allow_img_bbcode'];
		$allow_url_bbcode	 = $event['allow_url_bbcode'];
		$curl				 = false;
		$handlers			 = array();
		$images				 = array();
		$message			 = $event['message'];
		$options			 = array(
			CURLOPT_HEADER			 => false,
			CURLOPT_POST			 => true,
			CURLOPT_RETURNTRANSFER	 => true,
			CURLOPT_TIMEOUT			 => 10,
			CURLOPT_URL				 => $this->config['chevereto_url'] . '?key=' . $this->config['chevereto_key'],
		);
		$type				 = 'bbcode-embed';

		if ($allow_bbcode && $allow_img_bbcode)
		{
			preg_match_all('#\[img\](.*)\[/img\]#uisU', $message, $images[], PREG_SET_ORDER);

			foreach ($images[0] as $image)
			{
				$img_code	 = $image[0];
				$img_url	 = str_replace(' ', '%20', trim($image[1]));

				if ($allow_url_bbcode && $this->config['chevereto_type_img'] != $type)
				{
					if (!preg_match('#\[url(=(.*))?\](.*)?' . preg_quote($img_code) . '(.*)?\[/url\]#uisU', $message))
					{
						$type = $this->config['chevereto_type_img'];
					}
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
						if (!$curl)
						{
							$mh		 = curl_multi_init();
							$curl	 = true;
						}

						if (!isset($handlers['ch'][$hash]))
						{
							$handlers['im'][$hash]	 = $img_code;
							$handlers['ch'][$hash]	 = curl_init();
							curl_setopt_array($handlers['ch'][$hash], $options);
							curl_setopt($handlers['ch'][$hash], CURLOPT_POSTFIELDS, array('source' => $img_url));
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
				} while ($running > 0);

				foreach ($handlers['im'] as $hash => $img_code)
				{
					if ($ok = curl_multi_getcontent($handlers['ch'][$hash]))
					{
						curl_multi_remove_handle($mh, $handlers['ch'][$hash]);
						curl_close($handlers['ch'][$hash]);
						$ok = json_decode($ok, true);

						if ($ok['status_code'] == 200)
						{
							$message = $this->replace($ok['image'], $message, $img_code, $type);
							$this->cache->put($hash, $ok['image'], 86400);
						}
						else if ($this->config['chevereto_debug'])
						{
							$this->log->add('critical', $this->user->data['user_id'], $this->user->ip, 'LOG_CHV_ERROR', false, array(
								$ok['error']['code'],
								$ok['error']['message'],
							));
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
		$lang_set_ext			 = $event['lang_set_ext'];
		$lang_set_ext[]			 = array(
			'ext_name'	 => 'lordbeaver/chevereto',
			'lang_set'	 => 'common',
		);
		$event['lang_set_ext']	 = $lang_set_ext;
	}

	public function template($event)
	{
		$this->template->assign_vars(array(
			'CHV_PLUGIN_COLOR'	 => $this->config['chevereto_color'],
			'CHV_PLUGIN_ENABLE'	 => $this->config['chevereto_plugin'] ? true : false,
			'CHV_PLUGIN_HOST'	 => $this->host(),
			'CHV_PLUGIN_TYPE'	 => $this->config['allow_post_links'] ? $this->config['chevereto_type_pup'] : 'bbcode-embed',
		));
	}

	private function check($img_url)
	{
		$img_url = parse_url(strtolower($img_url));
		$hash	 = $this->hash($img_url['host']);

		if ($result = $this->cache->get($hash))
		{
			return $result;
		}
		else if ($this->config['chevereto_https'] && $img_url['scheme'] == 'https')
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

			$host	 = $img_url['host'];
			$result	 = true;

			if (in_array($host, $exclude))
			{
				$result = false;
			}
			else if ($this->config['chevereto_subdomain'])
			{
				while ($result && substr_count($host, '.') > 1)
				{
					$host	 = substr(strstr($host, '.'), 1);
					$result	 = !in_array($host, $exclude);
				}
			}
		}

		$this->cache->put($hash, $result, 3600);

		return $result;
	}

	private function hash($url)
	{
		$result = '_chv_h_' . md5($url);

		return $result;
	}

	private function host()
	{
		$result = parse_url(strtolower($this->config['chevereto_url']), PHP_URL_HOST);

		return $result;
	}

	private function replace($response, $message, $img_code, $type)
	{
		if ($type == 'bbcode-embed')
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
			}

			$result = str_replace($img_code, '[url=' . $response['url_viewer'] . '][img]' . $url . '[/img][/url]', $message);
		}

		return $result;
	}

}
