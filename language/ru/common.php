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
	'LOG_CHEVERETO_ERROR'		=> '<strong>Ошибка Chevereto:</strong> %1$s <br />» %2$s',
));