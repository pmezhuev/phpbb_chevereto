<?php

/**
 *
 * Chevereto API
 *
 * @copyright © 2019, 2023 Lord Beaver
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License version 2
 *
 */

namespace lordbeaver\chevereto\migrations;

class chevereto_0_4_3 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['chevereto_version']) && version_compare($this->config['chevereto_version'], '0.4.3', '>=');
	}

	public static function depends_on()
	{
		return array('\lordbeaver\chevereto\migrations\chevereto_0_4_1');
	}

	public function update_data()
	{
		if (isset($this->config['chevereto_type']))
		{
			$type_pup = $this->config['chevereto_type'];
		}
		else
		{
			$type_pup = 'bbcode-embed-medium';
		}

		return array(
			array('config.add', array('chevereto_type_img', $type_pup)),
			array('config.update', array('chevereto_version', '0.4.3')),
		);
	}
}
