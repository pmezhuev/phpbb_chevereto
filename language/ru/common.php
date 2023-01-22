<?php

/**
 *
 * Chevereto API [Russian]
 *
 * @copyright © 2017, 2023 Lord Beaver
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
	'LOG_CHV_ERROR'      => '<strong>Ошибка Chevereto:</strong> %1$s <br />» %2$s',
	'LOG_CHV_ERROR_API'  => '<strong>Ошибка Chevereto:</strong> некорректное значение chevereto_api',
	'LOG_CHV_ERROR_TYPE' => '<strong>Ошибка Chevereto:</strong> некорректное значение chevereto_type_img',
));
