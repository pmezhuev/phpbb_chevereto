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
	'ACP_CHV_DEBUG'			=> 'Включить лог ошибок',
	'ACP_CHV_EXCLUDE'		=> 'Список исключений',
	'ACP_CHV_EXCLUDE_EXPLAIN'	=> 'Список доменов через запятую. Изображения с этих доменов не будут загружаться на фотохостинг.<br />Домены форума и фотохостинга игнорируются независимо от заданных здесь настроек.',
	'ACP_CHV_EXCLUDE_OPTIONS'	=> 'Параметры исключений',
	'ACP_CHV_HTTPS'			=> 'Всегда игнорировать HTTPS',
	'ACP_CHV_KEY'			=> 'Ключ API v1',
	'ACP_CHV_SUBDOMAIN'		=> 'Игнорировать поддомены',
	'ACP_CHV_TITLE'			=> 'Chevereto API',
	'ACP_CHV_URL'			=> 'URL запроса',
));