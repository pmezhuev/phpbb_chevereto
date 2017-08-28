<?php

/**
 *
 * @package phpBB Extension - Chevereto API [Russian]
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
	'ACP_CHEVERETO_SETTING'	 => 'Chevereto API',
	'ACP_ONLYFRIENDS_EXT'	 => 'Расширения OnlyFriends',
	));
