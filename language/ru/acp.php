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
	'ACP_CHV_COLOR_BLACK'		 => 'Чёрный',
	'ACP_CHV_COLOR_BLUE'		 => 'Синий',
	'ACP_CHV_COLOR_CLEAR'		 => 'Прозрачный',
	'ACP_CHV_COLOR_DARKBLUE'	 => 'Тёмно-синий',
	'ACP_CHV_COLOR_DEFAULT'		 => 'По умолчанию',
	'ACP_CHV_COLOR_GREEN'		 => 'Зелёный',
	'ACP_CHV_COLOR_GREY'		 => 'Серый',
	'ACP_CHV_COLOR_ORANGE'		 => 'Оранжевый',
	'ACP_CHV_COLOR_PURPLE'		 => 'Пурпурный',
	'ACP_CHV_COLOR_RED'			 => 'Красный',
	'ACP_CHV_COLOR_TURQUOISE'	 => 'Бирюзовый',
	'ACP_CHV_COLOR_YELLOW'		 => 'Жёлтый',
	'ACP_CHV_DEBUG'				 => 'Включить лог ошибок',
	'ACP_CHV_EXCLUDE'			 => 'Список исключений',
	'ACP_CHV_EXCLUDE_EXPLAIN'	 => 'Список доменов через запятую. Изображения с этих доменов не будут загружаться на фотохостинг.<br />Домены форума и фотохостинга игнорируются независимо от заданных здесь настроек.',
	'ACP_CHV_EXCLUDE_HTTPS'		 => 'Всегда игнорировать HTTPS',
	'ACP_CHV_EXCLUDE_OPTIONS'	 => 'Параметры исключений',
	'ACP_CHV_EXCLUDE_SUB'		 => 'Игнорировать поддомены',
	'ACP_CHV_KEY'				 => 'Ключ API v1',
	'ACP_CHV_PLUGIN'			 => 'Разрешить «Плагин»',
	'ACP_CHV_PLUGIN_COLOR'		 => 'Палитра цветов',
	'ACP_CHV_PLUGIN_OPTIONS'	 => 'Параметры плагина',
	'ACP_CHV_PLUGIN_TYPE'		 => 'Коды для встраивания',
	'ACP_CHV_TITLE'				 => 'Chevereto API',
	'ACP_CHV_TYPE_DEFAULT'		 => 'BB-код среднего размера со ссылкой',
	'ACP_CHV_TYPE_EMBED'		 => 'BB-код полноразмерного',
	'ACP_CHV_TYPE_FULL'			 => 'BB-код полноразмерного со ссылкой',
	'ACP_CHV_TYPE_THUMBNAIL'	 => 'BB-код миниатюры со ссылкой',
	'ACP_CHV_URL'				 => 'URL запроса',
	));
