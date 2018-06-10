<?php

/**
 *
 * Chevereto API
 *
 * @copyright © 2017 Lord Beaver
 * @license https://opensource.org/licenses/BSD-3-Clause The 3-Clause BSD License
 *
 */

namespace lordbeaver\chevereto\migrations;

class chevereto_0_3_2 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return (isset($this->config['chevereto_version']) && version_compare($this->config['chevereto_version'], '0.3.2', '>='));
	}

	static public function depends_on()
	{
		return array('\lordbeaver\chevereto\migrations\chevereto_0_3_1');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('chevereto_debug', '0')),
			array('config.add', array('chevereto_subdomain', '0')),
			array('config.update', array('chevereto_version', '0.3.2')),
		);
	}

}
