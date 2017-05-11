<?php
/**
*
* @package phpBB Extension - Chevereto API
* @copyright (c) 2017 Lord Beaver
* @license https://opensource.org/licenses/BSD-3-Clause The 3-Clause BSD License
*
*/
namespace lordbeaver\chevereto\acp;

class chevereto_info
{
	public function module()
	{
		return array(
			'filename'	=> '\lordbeaver\chevereto\acp\chevereto_module',
			'title'		=> 'ACP_CHEVERETO',
			'modes'		=> array('settings' => array(
				'title'	=> 'ACP_CHEVERETO_SETTING',
				'auth'	=> 'ext_lordbeaver/chevereto && acl_a_board',
				'cat'	=> array('ACP_CHEVERETO')),
			),
		);
	}
}