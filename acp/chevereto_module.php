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

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request $request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		global $phpbb_container;

		$this->container	= $phpbb_container;
		$this->config		= $this->container->get('config');
		$this->language		= $this->container->get('language');
		$this->request		= $this->container->get('request');
		$this->template		= $this->container->get('template');

		$this->language->add_lang('acp', 'lordbeaver/chevereto');
	}

	public function main($id, $mode)
	{
		$this->tpl_name = 'chevereto';
		$this->page_title = $this->language->lang('ACP_CHEVERETO_TITLE');
		$form_key = 'acp_chevereto';
		add_form_key($form_key);

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error('FORM_INVALID');
			}
			$this->config->set('chevereto_debug', $this->request->variable('chevereto_debug', 0));
			$this->config->set('chevereto_exclude', str_replace(' ', '', $this->request->variable('chevereto_exclude', '', true)));
			$this->config->set('chevereto_https', $this->request->variable('chevereto_https', 0));
			$this->config->set('chevereto_key', $this->request->variable('chevereto_key', '', true));
			$this->config->set('chevereto_subdomain', $this->request->variable('chevereto_subdomain', 0));
			$this->config->set('chevereto_url', $this->request->variable('chevereto_url', '', true));
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$this->template->assign_vars(array(
			'CHEVERETO_DEBUG'	=> $this->config['chevereto_debug'] ? true : false,
			'CHEVERETO_EXCLUDE'	=> $this->config['chevereto_exclude'],
			'CHEVERETO_HTTPS'	=> $this->config['chevereto_https'] ? true : false,
			'CHEVERETO_KEY'		=> $this->config['chevereto_key'],
			'CHEVERETO_SUBDOMAIN'	=> $this->config['chevereto_subdomain'] ? true : false,
			'CHEVERETO_URL'		=> $this->config['chevereto_url'],
			'U_ACTION'		=> $this->u_action,
		));
	}
}