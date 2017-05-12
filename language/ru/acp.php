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
	'ACP_CHEVERETO_EXCLUDE'		=> 'Список исключений',
	'ACP_CHEVERETO_EXCLUDE_EXPLAIN'	=> 'Список доменов через запятую. Изображения с этих доменов не будут загружаться на фотохостинг.<br />Домены форума и фотохостинга игнорируются независимо от заданных здесь настроек.',
	'ACP_CHEVERETO_HTTPS'		=> 'Всегда игнорировать HTTPS',
	'ACP_CHEVERETO_KEY'		=> 'Ключ API v1',
	'ACP_CHEVERETO_TITLE'		=> 'Chevereto API',
	'ACP_CHEVERETO_URL'		=> 'URL запроса',
));