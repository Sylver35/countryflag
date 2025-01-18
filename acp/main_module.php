<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2025 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\acp;

class main_module
{
	/** @var string */
	public $u_action;

	/** @var string */
	public $page_title;

	/** @var string */
	public $tpl_name;

	public function main()
	{
		global $phpbb_container;

		/** @type \phpbb\language\language $language Language object */
		$language = $phpbb_container->get('language');

		/** @type \phpbb\template\template $template Template object */
		$template = $phpbb_container->get('template');

		// Get an instance of the admin controller
		/** @type \sylver35\countryflag\controller\controller $admin_controller */
		$admin_controller = $phpbb_container->get('sylver35.countryflag.controller');

		// Make the $u_action url available in the controller
		$admin_controller->set_page_url($this->u_action);

		$this->tpl_name = 'acp_countryflag';
		$this->page_title = $language->lang('COUNTRYFLAG_TITLE');

		$admin_controller->acp_config_countryflag();

		$template->assign_var('U_ACTION', $this->u_action);
	}
}
