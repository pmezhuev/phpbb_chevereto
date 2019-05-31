<?php

/**
 *
 * Chevereto API [English]
 *
 * @copyright © 2017 Lord Beaver
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
	'LOG_CHV_ERROR' => '<strong>Chevereto error:</strong> %1$s <br />» %2$s (code: %3$s)',
));
