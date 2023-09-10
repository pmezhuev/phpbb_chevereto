<?php

/**
 *
 * Chevereto API [English]
 *
 * @copyright © 2017, 2019—2020, 2023 Lord Beaver
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License version 2
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
	'ACP_CHV_API_10'               => 'v1',
	'ACP_CHV_API_11'               => 'v1.1',
	'ACP_CHV_API_KEY'              => 'API key',
	'ACP_CHV_API_MAXSIZE'          => 'Maximum file size',
	'ACP_CHV_API_MAXSIZE_EXPLAIN'  => 'Only for the "Files" mode.',
	'ACP_CHV_API_OPTIONS'          => 'API options',
	'ACP_CHV_API_SOURCE'           => 'Send images as',
	'ACP_CHV_API_SOURCE_EXPLAIN'   => 'Using a URL requires additional configuration on Chevereto. Chevereto V4 requires administrator rights.',
	'ACP_CHV_API_SOURCE_FILES'     => 'Files',
	'ACP_CHV_API_SOURCE_URL'       => 'URL',
	'ACP_CHV_API_URL'              => 'Request URL',
	'ACP_CHV_API_VERSION'          => 'API version',
	'ACP_CHV_DEBUG'                => 'Enable error log',
	'ACP_CHV_EXCLUDE'              => 'Exclude options',
	'ACP_CHV_EXCLUDE_EXPLAIN'      => 'Recommended to purge cache after changing settings.',
	'ACP_CHV_EXCLUDE_HTTPS'        => 'Always ignore HTTPS',
	'ACP_CHV_EXCLUDE_LIST'         => 'Exclude list',
	'ACP_CHV_EXCLUDE_LIST_EXPLAIN' => 'Comma separate domains list.',
	'ACP_CHV_EXCLUDE_SUB'          => 'Ignore subdomains',
	'ACP_CHV_NO_CURL'              => 'Requires curl PHP extension to be loaded.',
	'ACP_CHV_PLUGIN_COLOR'         => 'Color palette',
	'ACP_CHV_PUP_COLOR_BLACK'      => 'Black',
	'ACP_CHV_PUP_COLOR_BLUE'       => 'Blue',
	'ACP_CHV_PUP_COLOR_CLEAR'      => 'Clear',
	'ACP_CHV_PUP_COLOR_DARKBLUE'   => 'Darkblue',
	'ACP_CHV_PUP_COLOR_DEFAULT'    => 'Default',
	'ACP_CHV_PUP_COLOR_GREEN'      => 'Green',
	'ACP_CHV_PUP_COLOR_GREY'       => 'Grey',
	'ACP_CHV_PUP_COLOR_ORANGE'     => 'Orange',
	'ACP_CHV_PUP_COLOR_PURPLE'     => 'Purple',
	'ACP_CHV_PUP_COLOR_RED'        => 'Red',
	'ACP_CHV_PUP_COLOR_TURQUOISE'  => 'Turquoise',
	'ACP_CHV_PUP_COLOR_YELLOW'     => 'Yellow',
	'ACP_CHV_PUP_ENABLE'           => 'Allow "Plugin"',
	'ACP_CHV_PUP_LANG'             => 'Button language',
	'ACP_CHV_PUP_LANG_AUTO'        => 'Auto',
	'ACP_CHV_PUP_LANG_EN'          => 'English',
	'ACP_CHV_PUP_LANG_RU'          => 'Русский',
	'ACP_CHV_PUP_MODE'             => 'Plugin mode',
	'ACP_CHV_PUP_MODE_DEFAULT'     => 'General',
	'ACP_CHV_PUP_MODE_PHPBB'       => 'phpBB',
	'ACP_CHV_PUP_OPTIONS'          => 'Plugin options',
	'ACP_CHV_TITLE'                => 'Chevereto API',
	'ACP_CHV_TYPE'                 => 'Embed codes',
	'ACP_CHV_TYPE_EMBED'           => 'BBCode full',
	'ACP_CHV_TYPE_FULL'            => 'BBCode full linked',
	'ACP_CHV_TYPE_MEDIUM'          => 'BBCode medium linked',
	'ACP_CHV_TYPE_THUMBNAIL'       => 'BBCode thumbnail linked',
));
