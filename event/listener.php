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
			'core.message_parser_check_message'	=> 'chevereto',
			'core.user_setup'			=> 'language'
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
	* @param \phpbb\log\log				$log
	* @param \phpbb\user				$user
	*/
	public function __construct(
		\phpbb\cache\driver\driver_interface	$cache,
		\phpbb\config\config			$config,
		\phpbb\log\log_interface		$log,
		\phpbb\user				$user
	)
	{
		$this->cache	= $cache;
		$this->config	= $config;
		$this->log	= $log;
		$this->user	= $user;
	}

	public function chevereto($event)
	{
		$allow_bbcode = $event['allow_bbcode'];
		$allow_img_bbcode = $event['allow_img_bbcode'];
		$message = $event['message'];

		if ($allow_bbcode && $allow_img_bbcode)
		{
			$matches = array();
			preg_match_all('#\[img\](.*)\[/img\]#uiU', $message, $matches[], PREG_SET_ORDER);
			$matches = $matches[0];

			foreach ($matches as $match)
			{
				if ($this->check_host($match[1]))
				{
					$hash = 'chevereto_' . md5($match[1]);
					if ($result = $this->cache->get($hash))
					{
						$message = str_replace($match[0], '[img]' . $result . '[/img]', $message);
					}
					else
					{
						$ch = curl_init($this->config['chevereto_url'] . '?key=' . $this->config['chevereto_key']);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_POST, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS, array('source' => $match[1]));
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_TIMEOUT, 10);
						if ($result = curl_exec($ch))
						{
							$result = json_decode($result, true);
							if ($result['status_code'] == 200)
							{
								$message = str_replace($match[0], '[img]' . $result['image']['url'] . '[/img]', $message);
								$this->cache->put($hash, $result['image']['url'], 86400);
							}
							elseif ($this->config['chevereto_debug'])
							{
								$result = array(
									$result['error']['code'],
									$result['error']['message'],
								);
								$this->log->add(critical, $this->user->data['user_id'], $this->user->ip, 'LOG_CHEVERETO_ERROR', false, $result);
							}
						}
						curl_close($ch);
					}
				}
			}

			$event['message'] = $message;
		}
	}

	public function language($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'lordbeaver/chevereto',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	private function check_host($image)
	{
		$image = parse_url(strtolower($image));
		$hash = 'chevereto_' . $image['host'];

		if ($result = $this->cache->get($hash))
		{
			return $result;
		}
		elseif ($this->config['chevereto_https'] && $image['scheme'] == 'https')
		{
			$result = false;
		}
		else
		{
			$exclude = array(
				strtolower($this->config['server_name']),
				parse_url(strtolower($this->config['chevereto_url']), PHP_URL_HOST),
			);
			if (!empty($this->config['chevereto_exclude'])) $exclude = array_merge($exclude, explode(',', strtolower($this->config['chevereto_exclude'])));
			$image = $image['host'];
			$result = true;

			if (in_array($image, $exclude))
			{
				$result = false;
			}
			elseif ($this->config['chevereto_subdomain'])
			{
				while ($result && substr_count($image, '.') > 1)
				{
					$image = substr(strstr($image, '.'), 1);
					$result = !in_array($image, $exclude);
				}
			}
		}

		$this->cache->put($hash, $result, 3600);
		return $result;
	}
}