<?php

/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2025 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\controller;

use sylver35\countryflag\core\country;
use phpbb\config\config;
use phpbb\request\request;
use phpbb\db\driver\driver_interface as db;
use phpbb\log\log;
use phpbb\template\template;
use phpbb\user;
use phpbb\language\language;
use phpbb\path_helper;
use phpbb\extension\manager;

class controller
{
	/* @var \sylver35\countryflag\core\country */
	protected $country;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/* @var \phpbb\path_helper */
	protected $path_helper;

	/** @var \phpbb\extension\manager */
	protected $ext_manager;

	/** @var string Custom form action */
	protected $u_action;

	/** @var string ext path */
	protected $ext_path;

	/** @var string ext path web */
	protected $ext_path_web;

	/**
	 * The countryflag database table
	 *
	 * @var string */
	protected $countryflag_table;

	/**
	 * Controller constructor
	 */
	public function __construct(country $country, config $config, request $request, db $db, log $log, template $template, user $user, language $language, path_helper $path_helper, manager $ext_manager, $countryflag_table)
	{
		$this->country = $country;
		$this->config = $config;
		$this->request = $request;
		$this->db = $db;
		$this->log = $log;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->path_helper = $path_helper;
		$this->ext_manager = $ext_manager;
		$this->countryflag_table = $countryflag_table;
		$this->ext_path = $this->ext_manager->get_extension_path('sylver35/countryflag', true);
		$this->ext_path_web = $this->path_helper->update_web_root_path($this->ext_path);
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

			$data = [
				'countryflag_required'			=> $this->request->variable('countryflag_required', true),
				'countryflag_message'			=> $this->request->variable('countryflag_message', true),
				'countryflag_redirect'			=> $this->request->variable('countryflag_redirect', true),
				'countryflag_position'			=> $this->request->variable('countryflag_position', true),
				'countryflag_default'			=> $this->request->variable('countryflag_default', ''),
				'countryflag_width'				=> $this->request->variable('countryflag_width', 12),
				'countryflag_width_anim'		=> $this->request->variable('countryflag_width_anim', 48),
				'countryflag_display_topic'		=> $this->request->variable('countryflag_display_topic', true),
				'countryflag_display_pm'		=> $this->request->variable('countryflag_display_pm', true),
				'countryflag_display_memberlist'=> $this->request->variable('countryflag_display_memberlist', true),
			];

			$this->update_config($data);

			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_CONFIG_COUNTRYFLAG', time());
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}
		else
		{
			$meta = $this->country->get_version();
			$this->config_select_flag();
			$this->template->assign_vars([
				'COUNTRYFLAG_REQUIRED'			=> (bool) $this->config['countryflag_required'],
				'COUNTRYFLAG_MESSAGE'			=> (bool) $this->config['countryflag_message'],
				'COUNTRYFLAG_REDIRECT'			=> (bool) $this->config['countryflag_redirect'],
				'COUNTRYFLAG_POSITION'			=> (bool) $this->config['countryflag_position'],
				'COUNTRYFLAG_WIDTH'				=> (int) $this->config['countryflag_width'],
				'COUNTRYFLAG_WIDTH_ANIM'		=> (int) $this->config['countryflag_width_anim'],
				'COUNTRYFLAG_DISPLAY_TOPIC'		=> (bool) $this->config['countryflag_display_topic'],
				'COUNTRYFLAG_DISPLAY_PM'		=> (bool) $this->config['countryflag_display_pm'],
				'COUNTRYFLAG_DISPLAY_MEMBERLIST'=> (bool) $this->config['countryflag_display_memberlist'],
				'COUNTRYFLAG_COPY'				=> $this->language->lang('COUNTRYFLAG_COPY', $meta['homepage'], $meta['version']),
			]);
		}
	}

	private function config_select_flag()
	{
		$flag_image = '0';
		$sort = $this->country->get_lang();
		$title = $this->language->lang('COUNTRYFLAG_SORT_FLAG');
		$select = (!$this->config['countryflag_default']) ? ' selected="selected"' : '';
		$flag_options = '<option value="0" title="' . $this->language->lang('COUNTRYFLAG_SORT_FLAG') . '"' . $select . '> ' . $this->language->lang('COUNTRYFLAG_SORT_FLAG') . "</option>\n";

		$sql = [
			'SELECT'	=> 'id, code_iso, country_en, country_fr',
			'FROM'		=> [$this->countryflag_table => ''],
			'ORDER_BY'	=> 'country_' . (string) $sort,
		];
		$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql));
		while ($row = $this->db->sql_fetchrow($result))
		{
			$selected = '';
			$row['country_fr'] = $this->country->accent_in_country($row['code_iso'], $row['country_fr']);
			$country = $row['country_' . $sort] . ' (' . $row['code_iso'] . ')';
			if ((string) $row['code_iso'] === (string) $this->config['countryflag_default'])
			{
				$selected = ' selected="selected"';
				$title = $country;
				$flag_image = $row['code_iso'];
			}
			$flag_options .= '<option value="' . $row['code_iso'] . '" title="' . $country . '"' . $selected . '>' . $row['country_' . $sort] . "</option>\n";
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_vars([
			'COUNTRY_FLAG_PATH'			=> $this->ext_path_web . 'flags/',
			'COUNTRY_FLAG_IMAGE'		=> $this->ext_path_web . 'flags/' . $flag_image . '.png',
			'COUNTRY_FLAG_TITLE'		=> $title,
			'S_COUNTRY_FLAG_OPTIONS'	=> $flag_options,
		]);
	}

	private function update_config($data)
	{
		foreach ($data as $key => $value)
		{
			$this->config->set($key, $value);
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
