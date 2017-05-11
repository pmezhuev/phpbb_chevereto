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
	'ACP_CHEVERETO_KEY'		=> 'API v1 Key',
	'ACP_CHEVERETO_TITLE'		=> 'Chevereto API',
	'ACP_CHEVERETO_URL'		=> 'Request URL',
));