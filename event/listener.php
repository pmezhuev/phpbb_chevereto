<?php

/**
 *
 * @package phpBB Extension - Chevereto API
 * @copyright (c) 2017 Lord Beaver
 * @license https://opensource.org/licenses/BSD-3-Clause The 3-Clause BSD License
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
			'core.user_setup'					 => 'language'
		);
	}

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\log\log_interface */
	protected $log;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \phpbb\cache\driver\driver_interface	$cache
	 * @param \phpbb\config\config			$config
	 * @param \phpbb\log\log			$log
	 * @param \phpbb\user				$user
	 */
	public function __construct(\phpbb\cache\driver\driver_interface $cache, \phpbb\config\config $config, \phpbb\log\log_interface $log, \phpbb\user $user)
	{
		$this->cache	 = $cache;
		$this->config	 = $config;
		$this->log		 = $log;
		$this->user		 = $user;
	}

	public function chevereto($event)
	{
		$allow_bbcode		 = $event['allow_bbcode'];
		$allow_img_bbcode	 = $event['allow_img_bbcode'];
		$curl				 = false;
		$handlers			 = array();
		$message			 = $event['message'];
		$options			 = array(
			CURLOPT_HEADER			 => false,
			CURLOPT_POST			 => true,
			CURLOPT_RETURNTRANSFER	 => true,
			CURLOPT_TIMEOUT			 => 10,
			CURLOPT_URL				 => $this->config['chevereto_url'] . '?key=' . $this->config['chevereto_key'],
		);

		if ($allow_bbcode && $allow_img_bbcode)
		{
			$images	 = array();
			preg_match_all('#\[img\](.*)\[/img\]#uiU', $message, $images[], PREG_SET_ORDER);
			$images	 = $images[0];

			foreach ($images as $image)
			{
				if ($this->check($image[1]))
				{
					$hash	 = '_chv_i_' . md5($image[1]);
					if ($ok		 = $this->cache->get($hash))
					{
						$message = str_replace($image[0], '[img]' . $ok . '[/img]', $message);
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
							$handlers['im'][$hash]	 = $image[0];
							$handlers['ch'][$hash]	 = curl_init();
							curl_setopt_array($handlers['ch'][$hash], $options);
							curl_setopt($handlers['ch'][$hash], CURLOPT_POSTFIELDS, array('source' => $image[1]));
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

				foreach ($handlers['im'] as $hash => $image)
				{
					if ($ok = curl_multi_getcontent($handlers['ch'][$hash]))
					{
						curl_multi_remove_handle($mh, $handlers['ch'][$hash]);
						curl_close($handlers['ch'][$hash]);
						$ok = json_decode($ok, true);
						if ($ok['status_code'] == 200)
						{
							$message = str_replace($image, '[img]' . $ok['image']['url'] . '[/img]', $message);
							$this->cache->put($hash, $ok['image']['url'], 86400);
						}
						else if ($this->config['chevereto_debug'])
						{
							$this->log->add(critical, $this->user->data['user_id'], $this->user->ip, 'LOG_CHV_ERROR', false, array(
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

	private function check($image)
	{
		$image	 = parse_url(strtolower($image));
		$hash	 = '_chv_h_' . md5($image['host']);

		if ($result = $this->cache->get($hash))
		{
			return $result;
		}
		else if ($this->config['chevereto_https'] && $image['scheme'] == 'https')
		{
			$result = false;
		}
		else
		{
			$exclude = array(
				strtolower($this->config['server_name']),
				parse_url(strtolower($this->config['chevereto_url']), PHP_URL_HOST),
			);
			if (!empty($this->config['chevereto_exclude']))
				$exclude = array_merge($exclude, explode(',', strtolower($this->config['chevereto_exclude'])));
			$image	 = $image['host'];
			$result	 = true;

			if (in_array($image, $exclude))
			{
				$result = false;
			}
			else if ($this->config['chevereto_subdomain'])
			{
				while ($result && substr_count($image, '.') > 1)
				{
					$image	 = substr(strstr($image, '.'), 1);
					$result	 = !in_array($image, $exclude);
				}
			}
		}

		$this->cache->put($hash, $result, 3600);
		return $result;
	}

}
