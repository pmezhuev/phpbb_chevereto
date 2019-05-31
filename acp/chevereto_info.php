<?php

/**
 *
 * Chevereto API
 *
 * @copyright © 2017 Lord Beaver
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License version 2
 *
 */

namespace lordbeaver\chevereto\acp;

class chevereto_info
{

	public function module()
	{
		return array(
			'filename'	 => '\lordbeaver\chevereto\acp\chevereto_module',
			'title'		 => 'ACP_CHEVERETO_SETTING',
			'modes'		 => array('settings' => array(
					'title'	 => 'ACP_CHEVERETO_SETTING',
					'auth'	 => 'ext_lordbeaver/chevereto && acl_a_board',
					'cat'	 => array('ACP_ONLYFRIENDS_EXT')),
			),
		);
	}

}
