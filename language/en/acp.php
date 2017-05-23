<?php
/**
*
* @package phpBB Extension - Chevereto API [English]
* @copyright (c) 2017 Lord Beaver
* @license https://opensource.org/licenses/BSD-3-Clause The 3-Clause BSD License
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_CHEVERETO_DEBUG'		=> 'Enable error log',
	'ACP_CHEVERETO_EXCLUDE'		=> 'Exclude list',
	'ACP_CHEVERETO_EXCLUDE_EXPLAIN'	=> 'Comma separate domains list.',
	'ACP_CHEVERETO_HTTPS'		=> 'Always ignore HTTPS',
	'ACP_CHEVERETO_KEY'		=> 'API v1 key',
	'ACP_CHEVERETO_TITLE'		=> 'Chevereto API',
	'ACP_CHEVERETO_SUBDOMAIN'	=> 'Ignore subdomains',
	'ACP_CHEVERETO_URL'		=> 'Request URL',
));