<?php

/**
 *
 * Chevereto API [Russian]
 *
 * @copyright © 2017—2020, 2023 Lord Beaver
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
	'ACP_CHV_API_KEY'              => 'Ключ API',
	'ACP_CHV_API_MAXSIZE'          => 'Максимальный размер файла',
	'ACP_CHV_API_MAXSIZE_EXPLAIN'  => 'Только для режима «Файлы».',
	'ACP_CHV_API_OPTIONS'          => 'Параметры API',
	'ACP_CHV_API_SOURCE'           => 'Отправлять изображения как',
	'ACP_CHV_API_SOURCE_EXPLAIN'   => 'Использование URL требует дополнительной настройки на стороне Chevereto. Для Chevereto V4 требуются права администратора.',
	'ACP_CHV_API_SOURCE_FILES'     => 'Файлы',
	'ACP_CHV_API_SOURCE_URL'       => 'URL',
	'ACP_CHV_API_URL'              => 'URL запроса',
	'ACP_CHV_API_VERSION'          => 'Версия API',
	'ACP_CHV_DEBUG'                => 'Включить лог ошибок',
	'ACP_CHV_EXCLUDE'              => 'Параметры исключений',
	'ACP_CHV_EXCLUDE_EXPLAIN'      => 'Рекомендуется выполнить очистку кэша после изменения параметров.',
	'ACP_CHV_EXCLUDE_HTTPS'        => 'Всегда игнорировать HTTPS',
	'ACP_CHV_EXCLUDE_LIST'         => 'Список исключений',
	'ACP_CHV_EXCLUDE_LIST_EXPLAIN' => 'Список доменов через запятую. Изображения с этих доменов не будут загружаться на фотохостинг.<br />Домены форума и фотохостинга игнорируются независимо от заданных здесь настроек.',
	'ACP_CHV_EXCLUDE_SUB'          => 'Игнорировать поддомены',
	'ACP_CHV_NO_CURL'              => 'Требуется расширение PHP curl.',
	'ACP_CHV_PLUGIN_COLOR'         => 'Палитра цветов',
	'ACP_CHV_PUP_COLOR_BLACK'      => 'Чёрный',
	'ACP_CHV_PUP_COLOR_BLUE'       => 'Синий',
	'ACP_CHV_PUP_COLOR_CLEAR'      => 'Прозрачный',
	'ACP_CHV_PUP_COLOR_DARKBLUE'   => 'Тёмно-синий',
	'ACP_CHV_PUP_COLOR_DEFAULT'    => 'По умолчанию',
	'ACP_CHV_PUP_COLOR_GREEN'      => 'Зелёный',
	'ACP_CHV_PUP_COLOR_GREY'       => 'Серый',
	'ACP_CHV_PUP_COLOR_ORANGE'     => 'Оранжевый',
	'ACP_CHV_PUP_COLOR_PURPLE'     => 'Пурпурный',
	'ACP_CHV_PUP_COLOR_RED'        => 'Красный',
	'ACP_CHV_PUP_COLOR_TURQUOISE'  => 'Бирюзовый',
	'ACP_CHV_PUP_COLOR_YELLOW'     => 'Жёлтый',
	'ACP_CHV_PUP_ENABLE'           => 'Разрешить «Плагин»',
	'ACP_CHV_PUP_MODE'             => 'Режим плагина',
	'ACP_CHV_PUP_MODE_DEFAULT'     => 'Универсальный',
	'ACP_CHV_PUP_MODE_PHPBB'       => 'phpBB',
	'ACP_CHV_PUP_OPTIONS'          => 'Параметры плагина',
	'ACP_CHV_TITLE'                => 'Chevereto API',
	'ACP_CHV_TYPE'                 => 'Коды для встраивания',
	'ACP_CHV_TYPE_EMBED'           => 'BBCode полноразмерного',
	'ACP_CHV_TYPE_FULL'            => 'BBCode полноразмерного со ссылкой',
	'ACP_CHV_TYPE_MEDIUM'          => 'BBCode среднего размера со ссылкой',
	'ACP_CHV_TYPE_THUMBNAIL'       => 'BBCode миниатюры со ссылкой',
));
