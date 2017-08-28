<?php

/**
 *
 * @package phpBB Extension - Chevereto API
 * @copyright (c) 2017 Lord Beaver
 * @license https://opensource.org/licenses/BSD-3-Clause The 3-Clause BSD License
 *
 */

namespace lordbeaver\chevereto\acp;

class chevereto_module
{

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		global $phpbb_container;

		$this->container = $phpbb_container;
		$this->config	 = $this->container->get('config');
		$this->request	 = $this->container->get('request');
		$this->template	 = $this->container->get('template');
		$this->user		 = $this->container->get('user');

		$this->user->add_lang_ext('lordbeaver/chevereto', 'acp');
	}

	public function main($id, $mode)
	{
		$this->tpl_name		 = 'chevereto';
		$this->page_title	 = $this->user->lang['ACP_CHV_TITLE'];
		$form_key			 = 'acp_chevereto';
		add_form_key($form_key);

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error('FORM_INVALID');
			}
			$this->config->set('chevereto_debug', $this->request->variable('chv_debug', 0));
			$this->config->set('chevereto_exclude', str_replace(' ', '', $this->request->variable('chv_exclude', '', true)));
			$this->config->set('chevereto_https', $this->request->variable('chv_https', 0));
			$this->config->set('chevereto_key', $this->request->variable('chv_key', '', true));
			$this->config->set('chevereto_subdomain', $this->request->variable('chv_subdomain', 1));
			$this->config->set('chevereto_url', $this->request->variable('chv_url', '', true));
			trigger_error($this->user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
		}

		$this->template->assign_vars(array(
			'CHV_DEBUG'		 => $this->config['chevereto_debug'] ? true : false,
			'CHV_EXCLUDE'	 => $this->config['chevereto_exclude'],
			'CHV_HTTPS'		 => $this->config['chevereto_https'] ? true : false,
			'CHV_KEY'		 => $this->config['chevereto_key'],
			'CHV_SUBDOMAIN'	 => $this->config['chevereto_subdomain'] ? true : false,
			'CHV_URL'		 => $this->config['chevereto_url'],
			'U_ACTION'		 => $this->u_action,
		));
	}

}
