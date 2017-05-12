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
			'core.message_parser_check_message' => 'chevereto',
		);
	}

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\config\config */
	protected $config;

	/**
	* Constructor
	*
	* @param \phpbb\cache\driver\driver_interface	$cache
	* @param \phpbb\config\config			$config
	*/
	public function __construct(\phpbb\cache\driver\driver_interface $cache, \phpbb\config\config $config)
	{
		$this->cache = $cache;
		$this->config = $config;
	}

	public function chevereto($event)
	{
		$allow_bbcode = $event['allow_bbcode'];
		$message = $event['message'];

		if ($allow_bbcode)
		{
			$matches = array();
			preg_match_all('#\[img\](.*)\[/img\]#uiU', $message, $matches[], PREG_SET_ORDER);
			$matches = $matches[0];

			foreach ($matches as $match)
			{
				$img = parse_url(strtolower($match[1]));
				$exclude = array(
					strtolower($this->config['server_name']),
					parse_url(strtolower($this->config['chevereto_url']), PHP_URL_HOST),
					($this->config['chevereto_https'] && $img['scheme'] == 'https') ? $img['host'] : null,
				);
				if (!empty($this->config['chevereto_exclude'])) $exclude = array_merge($exclude, explode(',', strtolower($this->config['chevereto_exclude'])));

				if (!in_array($img['host'], $exclude))
				{
					if ($result = $this->cache->get(md5($match[1])))
					{
						$message = str_replace($match[0], '[img]' . $result . '[/img]', $message);
					}
					else
					{
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_TIMEOUT, 10);
						curl_setopt($ch, CURLOPT_URL, $this->config['chevereto_url'] . '?key=' . $this->config['chevereto_key'] . '&source=' . $match[1]);
						if ($result = curl_exec($ch))
						{
							$result = json_decode($result, true);
							if ($result['status_code'] == 200)
							{
								$message = str_replace($match[0], '[img]' . $result['image']['url'] . '[/img]', $message);
								$this->cache->put(md5($match[1]), $result['image']['url'], 86400);
							}
						}
						curl_close($ch);
					}
				}
			}

			$event['message'] = $message;
		}
	}
}