<?php

/**
 *
 * Chevereto API [English]
 *
 * @copyright © 2017, 2018 Lord Beaver
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
	'ACP_CHV_COLOR_BLACK'		 => 'Black',
	'ACP_CHV_COLOR_BLUE'		 => 'Blue',
	'ACP_CHV_COLOR_CLEAR'		 => 'Clear',
	'ACP_CHV_COLOR_DARKBLUE'	 => 'Darkblue',
	'ACP_CHV_COLOR_DEFAULT'		 => 'Default',
	'ACP_CHV_COLOR_GREEN'		 => 'Green',
	'ACP_CHV_COLOR_GREY'		 => 'Grey',
	'ACP_CHV_COLOR_ORANGE'		 => 'Orange',
	'ACP_CHV_COLOR_PURPLE'		 => 'Purple',
	'ACP_CHV_COLOR_RED'			 => 'Red',
	'ACP_CHV_COLOR_TURQUOISE'	 => 'Turquoise',
	'ACP_CHV_COLOR_YELLOW'		 => 'Yellow',
	'ACP_CHV_DEBUG'				 => 'Enable error log',
	'ACP_CHV_EXCLUDE'			 => 'Exclude list',
	'ACP_CHV_EXCLUDE_EXPLAIN'	 => 'Comma separate domains list.',
	'ACP_CHV_EXCLUDE_HTTPS'		 => 'Always ignore HTTPS',
	'ACP_CHV_EXCLUDE_OPTIONS'	 => 'Exclude options',
	'ACP_CHV_EXCLUDE_SUB'		 => 'Ignore subdomains',
	'ACP_CHV_KEY'				 => 'API v1 key',
	'ACP_CHV_PLUGIN'			 => 'Allow "Plugin"',
	'ACP_CHV_PLUGIN_COLOR'		 => 'Color palette',
	'ACP_CHV_PLUGIN_OPTIONS'	 => 'Plugin options',
	'ACP_CHV_PLUGIN_TYPE'		 => 'Embed codes',
	'ACP_CHV_TITLE'				 => 'Chevereto API',
	'ACP_CHV_TYPE_EMBED'		 => 'BBCode full',
	'ACP_CHV_TYPE_FULL'			 => 'BBCode full linked',
	'ACP_CHV_TYPE_MEDIUM'		 => 'BBCode medium linked',
	'ACP_CHV_TYPE_THUMBNAIL'	 => 'BBCode thumbnail linked',
	'ACP_CHV_URL'				 => 'Request URL',
));
