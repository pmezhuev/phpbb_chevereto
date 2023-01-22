<?php

/**
 *
 * Chevereto API
 *
 * @copyright © 2020, 2023 Lord Beaver
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License version 2
 *
 */

namespace lordbeaver\chevereto\migrations;

class chevereto_0_5_0 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['chevereto_version']) && version_compare($this->config['chevereto_version'], '0.5.0', '>=');
	}

	public static function depends_on()
	{
		return array('\lordbeaver\chevereto\migrations\chevereto_0_4_3');
	}

	public function update_data()
	{
		if (isset($this->config['chevereto_color']))
		{
			$pup_color = $this->config['chevereto_color'];
		}
		else
		{
			$pup_color = 'default';
		}

		if (isset($this->config['chevereto_key']) && 'qpLKcJU2PvD8oV5fQHjE9AYdRuwTFy' != $this->config['chevereto_key'])
		{
			$api_key = $this->config['chevereto_key'];
		}
		else
		{
			$api_key = 'chv_h_3307fa8ac1433ba4b8dbb5d5e02d718db0c1659c5b62246157ee9a209a813f2f468f6fd8f1fcc965eabd2b48491686d83bd47a5ec5fecd050fa79dfa70903e87';
		}

		if (isset($this->config['chevereto_plugin']))
		{
			$pup_enable = $this->config['chevereto_plugin'];
		}
		else
		{
			$pup_enable = '0';
		}

		if (isset($this->config['chevereto_url']))
		{
			$api_url = trim($this->config['chevereto_url'], '/');
		}
		else
		{
			$api_url = 'https://onlystorage.org/api/1/upload';
		}

		return array(
			array('if', array(
				isset($this->config['chevereto_color']),
				array('config.remove', array('chevereto_color')),
			)),
			array('if', array(
				isset($this->config['chevereto_key']),
				array('config.remove', array('chevereto_key')),
			)),
			array('if', array(
				isset($this->config['chevereto_plugin']),
				array('config.remove', array('chevereto_plugin')),
			)),
			array('if', array(
				isset($this->config['chevereto_url']),
				array('config.remove', array('chevereto_url')),
			)),
			array('config.add', array('chevereto_api_files', '1')),
			array('config.add', array('chevereto_api_key', $api_key)),
			array('config.add', array('chevereto_api_maxsize', '15')),
			array('config.add', array('chevereto_api_url', $api_url)),
			array('config.add', array('chevereto_api_version', '1')),
			array('config.add', array('chevereto_pup_color', $pup_color)),
			array('config.add', array('chevereto_pup_enable', $pup_enable)),
			array('config.add', array('chevereto_pup_mode', 'default')),
			array('config.update', array('chevereto_version', '0.5.0')),
		);
	}
}
