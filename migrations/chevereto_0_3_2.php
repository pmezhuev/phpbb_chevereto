<?php

/**
 *
 * Chevereto API
 *
 * @copyright © 2017, 2023 Lord Beaver
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License version 2
 *
 */

namespace lordbeaver\chevereto\migrations;

class chevereto_0_3_2 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['chevereto_version']) && version_compare($this->config['chevereto_version'], '0.3.2', '>=');
	}

	public static function depends_on()
	{
		return array('\lordbeaver\chevereto\migrations\chevereto_0_3_1');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('chevereto_debug', '0')),
			array('config.add', array('chevereto_subdomain', '1')),
			array('config.update', array('chevereto_version', '0.3.2')),
		);
	}
}
