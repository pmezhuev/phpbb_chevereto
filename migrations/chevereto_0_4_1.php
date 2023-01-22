<?php

/**
 *
 * Chevereto API
 *
 * @copyright © 2017, 2019, 2023 Lord Beaver
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License version 2
 *
 */

namespace lordbeaver\chevereto\migrations;

class chevereto_0_4_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['chevereto_version']) && version_compare($this->config['chevereto_version'], '0.4.1', '>=');
	}

	public static function depends_on()
	{
		return array('\lordbeaver\chevereto\migrations\chevereto_0_3_2');
	}

	public function revert_data()
	{
		return array(
			array('if', array(
					!isset($this->config['onlyfriends_version']),
					array('module.remove', array('acp', false, 'ACP_ONLYFRIENDS_EXT')),
				)),
		);
	}

	public function update_data()
	{
		return array(
			array('if', array(
				array('module.exists', array('acp', false, 'ACP_CHEVERETO_SETTING')),
				array('module.remove', array('acp', false, 'ACP_CHEVERETO_SETTING')),
			)),
			array('if', array(
				array('module.exists', array('acp', false, 'ACP_CHEVERETO')),
				array('module.remove', array('acp', false, 'ACP_CHEVERETO')),
			)),
			array('if', array(
				isset($this->config['onlyfriends_version']) && version_compare($this->config['onlyfriends_version'], '1.3.0', '<'),
				array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_ONLYFRIENDS_EXT')),
			)),
			array('if', array(
				!isset($this->config['onlyfriends_version']),
				array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_ONLYFRIENDS_EXT')),
			)),
			array('module.add', array('acp', 'ACP_ONLYFRIENDS_EXT', array(
					'module_basename' => '\lordbeaver\chevereto\acp\chevereto_module',
					'module_mode'     => 'settings',
					'module_auth'     => 'ext_lordbeaver/chevereto && acl_a_board',
				),
			)),
			array('config.update', array('chevereto_version', '0.4.1')),
		);
	}
}
