<?php

/**
 *
 * Chevereto API
 *
 * @copyright © 2017, 2019—2020, 2023 Lord Beaver
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License version 2
 *
 */

namespace lordbeaver\chevereto\acp;

class chevereto_module
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		global $phpbb_container;

		$this->container = $phpbb_container;
		$this->config    = $this->container->get('config');
		$this->language  = $this->container->get('language');
		$this->request   = $this->container->get('request');
		$this->template  = $this->container->get('template');
	}

	public function main()
	{
		$this->language->add_lang('acp', 'lordbeaver/chevereto');
		$this->tpl_name   = 'chevereto';
		$this->page_title = $this->language->lang('ACP_CHV_TITLE');
		$form_key         = 'acp_chevereto';
		add_form_key($form_key);

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error('FORM_INVALID');
			}

			$this->config->set('chevereto_api_files', $this->request->variable('chv_api_files', 1));
			$this->config->set('chevereto_api_key', $this->request->variable('chv_api_key', '', true));
			$this->config->set('chevereto_api_maxsize', $this->request->variable('chv_api_maxsize', 15));
			$this->config->set('chevereto_api_version', $this->request->variable('chv_api_version', '1'));
			$this->config->set('chevereto_api_url', trim($this->request->variable('chv_api_url', '', true), '/'));
			$this->config->set('chevereto_debug', $this->request->variable('chv_debug', 0));
			$this->config->set('chevereto_exclude', str_replace(' ', '', $this->request->variable('chv_exclude', '', true)));
			$this->config->set('chevereto_https', $this->request->variable('chv_https', 0));
			$this->config->set('chevereto_pup_color', $this->request->variable('chv_pup_color', 'default'));
			$this->config->set('chevereto_pup_enable', $this->request->variable('chv_pup_enable', 0));
			$this->config->set('chevereto_pup_lang', $this->request->variable('chv_pup_lang', 'auto'));
			$this->config->set('chevereto_pup_mode', $this->request->variable('chv_pup_mode', 'default'));
			$this->config->set('chevereto_subdomain', $this->request->variable('chv_subdomain', 1));
			$this->config->set('chevereto_type_img', $this->request->variable('chv_type_img', 'bbcode-embed'));
			$this->config->set('chevereto_type_pup', $this->request->variable('chv_type_pup', 'bbcode-embed-medium'));
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$this->template->assign_vars(array(
			'CHV_API_FILES'   => $this->config['chevereto_api_files'] ? true : false,
			'CHV_API_KEY'     => $this->config['chevereto_api_key'],
			'CHV_API_MAXSIZE' => $this->config['chevereto_api_maxsize'],
			'CHV_API_URL'     => $this->config['chevereto_api_url'],
			'CHV_API_VERSION' => $this->config['chevereto_api_version'],
			'CHV_DEBUG'       => $this->config['chevereto_debug'] ? true : false,
			'CHV_EXCLUDE'     => $this->config['chevereto_exclude'],
			'CHV_HTTPS'       => $this->config['chevereto_https'] ? true : false,
			'CHV_NO_CURL'     => @extension_loaded('curl') ? false : true,
			'CHV_PUP_COLOR'   => $this->config['chevereto_pup_color'],
			'CHV_PUP_ENABLE'  => $this->config['chevereto_pup_enable'] ? true : false,
			'CHV_PUP_LANG'    => $this->config['chevereto_pup_lang'],
			'CHV_PUP_MODE'    => $this->config['chevereto_pup_mode'],
			'CHV_SUBDOMAIN'   => $this->config['chevereto_subdomain'] ? true : false,
			'CHV_TYPE_IMG'    => $this->config['chevereto_type_img'],
			'CHV_TYPE_PUP'    => $this->config['chevereto_type_pup'],
			'U_ACTION'        => $this->u_action,
		));
	}
}
