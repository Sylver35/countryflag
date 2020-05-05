<?php

/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2018-2020 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\controller;

use sylver35\countryflag\core\country;
use phpbb\config\config;
use phpbb\request\request;
use phpbb\log\log;
use phpbb\template\template;
use phpbb\user;
use phpbb\language\language;

class controller
{
	/* @var \sylver35\countryflag\core\country */
	protected $country;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Controller constructor
	*/
	public function __construct(country $country, config $config, request $request, log $log, template $template, user $user, language $language)
	{
		$this->country 		= $country;
		$this->config 		= $config;
		$this->request		= $request;
		$this->log			= $log;
		$this->template 	= $template;
		$this->user			= $user;
		$this->language		= $language;
	}

	public function acp_config_countryflag()
	{
		$form_key = 'acp_countryflag';
		add_form_key($form_key);
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}
			$this->config->set('countryflag_required', $this->request->variable('countryflag_required', true));
			$this->config->set('countryflag_message', $this->request->variable('countryflag_message', true));
			$this->config->set('countryflag_redirect', $this->request->variable('countryflag_redirect', true));
			$this->config->set('countryflag_position', $this->request->variable('countryflag_position', true));
			$this->config->set('countryflag_default', $this->request->variable('countryflag_default', ''));
			$this->config->set('countryflag_width', $this->request->variable('countryflag_width', 12));
			$this->config->set('countryflag_width_anim', $this->request->variable('countryflag_width_anim', 48));
			$this->config->set('countryflag_display_topic', $this->request->variable('countryflag_display_topic', true));
			$this->config->set('countryflag_display_pm', $this->request->variable('countryflag_display_pm', true));
			$this->config->set('countryflag_display_memberlist', $this->request->variable('countryflag_display_memberlist', true));

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_CONFIG_COUNTRYFLAG', time());
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}
		else
		{
			$meta = $this->country->get_version();
			$this->country->config_select_flag();
			$this->template->assign_vars(array(
				'COUNTRYFLAG_REQUIRED'			=> $this->config['countryflag_required'] ? true : false,
				'COUNTRYFLAG_MESSAGE'			=> $this->config['countryflag_message'] ? true : false,
				'COUNTRYFLAG_REDIRECT'			=> $this->config['countryflag_redirect'] ? true : false,
				'COUNTRYFLAG_POSITION'			=> $this->config['countryflag_position'] ? true : false,
				'COUNTRYFLAG_WIDTH'				=> $this->config['countryflag_width'],
				'COUNTRYFLAG_WIDTH_ANIM'		=> $this->config['countryflag_width_anim'],
				'COUNTRYFLAG_DISPLAY_TOPIC'		=> $this->config['countryflag_display_topic'] ? true : false,
				'COUNTRYFLAG_DISPLAY_PM'		=> $this->config['countryflag_display_pm'] ? true : false,
				'COUNTRYFLAG_DISPLAY_MEMBERLIST'=> $this->config['countryflag_display_memberlist'] ? true : false,
				'COUNTRYFLAG_COPY'				=> $this->language->lang('COUNTRYFLAG_COPY', $meta['homepage'], $meta['version']),
			));
		}
	}

	/**
	 * Set page url
	 *
	 * @param string $u_action Custom form action
	 * @return void
	 * @access public
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
