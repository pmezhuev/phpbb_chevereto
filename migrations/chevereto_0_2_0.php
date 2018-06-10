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

class chevereto_0_2_0 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return (isset($this->config['chevereto_version']) && version_compare($this->config['chevereto_version'], '0.2.0', '>='));
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('chevereto_key', 'qpLKcJU2PvD8oV5fQHjE9AYdRuwTFy')),
			array('config.add', array('chevereto_url', 'https://onlystorage.org/api/1/upload/')),
			array('config.add', array('chevereto_version', '0.2.0')),
		);
	}

}
