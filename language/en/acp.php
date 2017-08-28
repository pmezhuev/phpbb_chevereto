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
	'ACP_CHV_DEBUG'				 => 'Enable error log',
	'ACP_CHV_EXCLUDE'			 => 'Exclude list',
	'ACP_CHV_EXCLUDE_EXPLAIN'	 => 'Comma separate domains list.',
	'ACP_CHV_EXCLUDE_OPTIONS'	 => 'Exclude options',
	'ACP_CHV_HTTPS'				 => 'Always ignore HTTPS',
	'ACP_CHV_KEY'				 => 'API v1 key',
	'ACP_CHV_SUBDOMAIN'			 => 'Ignore subdomains',
	'ACP_CHV_TITLE'				 => 'Chevereto API',
	'ACP_CHV_URL'				 => 'Request URL',
	));
