<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2025 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use sylver35\countryflag\core\country;
use sylver35\countryflag\core\cache_country;
use phpbb\config\config;
use phpbb\template\template;
use phpbb\user;
use phpbb\language\language;
use phpbb\request\request;

class listener implements EventSubscriberInterface
{
	/* @var \sylver35\countryflag\core\country */
	protected $country;

	/** @var \sylver35\countryflag\core\cache_country */
	protected $cache_country;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/**
	 * Listener constructor
	 */
	public function __construct(country $country, cache_country $cache_country, config $config, template $template, user $user, language $language, request $request)
	{
		$this->country = $country;
		$this->cache_country = $cache_country;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->request = $request;
	}

	/**
	 * Function that returns the subscribed events
	 *
	 * @return array Array with the subscribed events
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup' 									=> 'load_language_on_setup',
			'core.page_header_after'							=> 'page_header_after',
			'core.index_modify_page_title'						=> 'index_modify_page_title',
			'core.modify_username_string' 						=> 'modify_username_string_flag',
			'core.memberlist_view_profile'						=> 'memberlist_view_profile_img_anim',
			'core.viewtopic_modify_post_row'					=> 'viewtopic_post_row_img_anim',
			'core.viewtopic_cache_user_data'					=> 'viewtopic_cache_user_data',
			'core.ucp_pm_view_messsage'							=> 'ucp_pm_view_messsage',
			'core.ucp_profile_modify_profile_info'				=> 'user_country_profile',
			'core.ucp_profile_validate_profile_info'			=> 'user_profile_validate',
			'core.ucp_profile_info_modify_sql_ary'				=> 'user_profile_sql_ary',
			'core.ucp_register_data_before'						=> 'user_country_profile_register',
			'core.ucp_register_data_after'						=> 'user_register_validate',
			'core.ucp_register_user_row_after'					=> 'ucp_register_user_row_after',
			'core.ucp_register_register_after'					=> 'update_config_refresh',
			'core.ucp_register_agreement_modify_template_data' 	=> 'ucp_register_agreement_country',
			'core.ucp_prefs_personal_data'						=> 'ucp_prefs_personal_data',
			'core.ucp_prefs_personal_update_data'				=> 'ucp_prefs_personal_update_data',
			'core.acp_users_modify_profile'						=> 'acp_user_country_profile',
			'core.acp_users_profile_modify_sql_ary'				=> 'user_profile_sql_ary',
			'core.acp_users_profile_validate'					=> 'update_config_refresh',
		];
	}

	/**
	 * @param array $event
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'sylver35/countryflag',
			'lang_set' => 'countryflag',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Automatic refresh the country users cache if needed
	 * Create URL and display message to user if needed
	 */
	public function page_header_after()
	{
		// If country users must be updated
		if ($this->config['countryflag_refresh_cache'])
		{
			// Refresh the country users cache now
			$this->cache_country->destroy_country_cache();
		}

		if ($this->user->data['is_registered'] && !$this->user->data['is_bot'])
		{
			if ($this->config['countryflag_required'] && !$this->user->data['user_country'])
			{
				// Display message choosing country
				$this->country->display_message();
				// Redirect if needed
				$this->country->redirect_to_profile();
			}
		}
		$this->country->write_version();
	}

	/**
	 * Display list of country users flag on index
	 */
	public function index_modify_page_title()
	{
		if ($this->config['countryflag_display_index'])
		{
			$this->country->display_list_on_index();
		}
	}

	/**
	 * Display flag with username
	 *
	 * @param array $event
	 */
	public function modify_username_string_flag($event)
	{
		if ($event['mode'] == 'full' || $event['mode'] == 'no_profile')
		{
			$id = $event['user_id'];
			// Get the country users from cache
			$country = $this->cache_country->country_users();
			// Do this just for users who have selected country
			if (isset($country[$id]['user_id']))
			{
				$lang = $this->country->get_lang();
				$event['username_string'] = $this->country->get_country_img($event['username_string'], $country[$id]['code_iso'], $country[$id]['country_' . $lang]);
			}
		}
	}

	/**
	 * Add country select in profile
	 *
	 * @param array $event
	 */
	public function user_country_profile($event)
	{
		$event['data'] = array_merge($event['data'], [
			'user_country'	=> $this->request->variable('user_country', $this->user->data['user_country']),
		]);
		$this->country->add_country($event, false, true);
	}

	/**
	 * Add country select in register form
	 *
	 * @param array $event
	 */
	public function user_country_profile_register($event)
	{
		$event['data'] = array_merge($event['data'], [
			'user_country'	=> $this->request->variable('user_country', ''),
		]);
		$this->country->add_country($event, false, false);
	}

	/**
	 * Add country select in acp profile
	 *
	 * @param array $event
	 */
	public function acp_user_country_profile($event)
	{
		$event['data'] = array_merge($event['data'], [
			'user_country'	=> $this->request->variable('user_country', $event['user_row']['user_country']),
		]);
		$this->country->add_country($event, true, false);
	}

	/**
	 * Add user country in sql ary
	 *
	 * @param array $event
	 */
	public function user_profile_sql_ary($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], [
			'user_country'	=> $event['data']['user_country'],
		]);
	}

	/**
	 * Validate country in profile
	 *
	 * @param array $event
	 */
	public function user_profile_validate($event)
	{
		if ($event['submit'] && empty($event['data']['user_country']) && $this->config['countryflag_required'])
		{
			$error = $event['error'];
			$error[] = $this->language->lang('COUNTRY_ERROR');
			$event['error'] = $error;
		}
		else if ($event['submit'])
		{
			// Say to refresh the country users cache after update
			$this->cache_country->update_config_refresh();
		}
	}

	/**
	 * Validate country in register form
	 *
	 * @param array $event
	 */
	public function user_register_validate($event)
	{
		if ($event['submit'] && empty($event['data']['user_country']) && $this->config['countryflag_required'])
		{
			$error = $event['error'];
			$error[] = $this->language->lang('COUNTRY_ERROR_REGISTER');
			$event['error'] = $error;
		}
		else if ($event['submit'])
		{
			// Say to refresh the country users cache after update
			$this->cache_country->update_config_refresh();
		}
	}

	/**
	 * Display country and flag in view profile
	 *
	 * @param array $event
	 */
	public function memberlist_view_profile_img_anim($event)
	{
		if ($this->config['countryflag_display_memberlist'] && isset($event['member']['user_id']))
		{
			$flag = $this->country->get_country_img_anim($event['member']['user_id']);
			if ($flag['image'] !== '')
			{
				$this->template->assign_vars([
					'COUNTRY_IMG_ANIM'		=> $flag['image'],
					'COUNTRY_USER'			=> $flag['country'],
					'S_COUNTRY_IMG_ANIM'	=> true,
				]);
			}
		}
	}

	/**
	 * Display country and flag in viewtopic
	 *
	 * @param array $event
	 */
	public function viewtopic_post_row_img_anim($event)
	{
		if ($this->config['countryflag_display_topic'] && isset($event['user_poster_data']['user_id']))
		{
			$flag = $this->country->get_country_img_anim($event['user_poster_data']['user_id']);
			if ($flag['image'] !== '')
			{
				$event['post_row'] = array_merge($event['post_row'], [
					'COUNTRY_IMG_ANIM'		=> $flag['image'],
					'COUNTRY_USER'			=> $flag['country'],
					'S_COUNTRY_IMG_ANIM'	=> true,
				]);
			}
		}
	}

	/**
	 * Add flag and country in pm
	 *
	 * @param array $event
	 */
	public function ucp_pm_view_messsage($event)
	{
		if ($this->config['countryflag_display_pm'] && isset($event['user_info']['user_id']))
		{
			$flag = $this->country->get_country_img_anim($event['user_info']['user_id']);
			if ($flag['image'] !== '')
			{
				$event['msg_data'] = array_merge($event['msg_data'], [
					'COUNTRY_IMG_ANIM'		=> $flag['image'],
					'COUNTRY_USER'			=> $flag['country'],
					'S_COUNTRY_IMG_ANIM'	=> true,
				]);
			}
		}
	}

	/**
	 * Add user id in viewtopic cache data
	 *
	 * @param array $event
	 */
	public function viewtopic_cache_user_data($event)
	{
		$event['user_cache_data'] = array_merge($event['user_cache_data'], [
			'user_id' => $event['row']['user_id'],
		]);
	}

	/**
	 * Update registration data
	 *
	 * @param array $event
	 */
	public function ucp_register_user_row_after($event)
	{
		$event['user_row'] = array_merge($event['user_row'], [
			'user_country'	=> $this->request->variable('user_country', ''),
		]);
	}

	/**
	 * Update cache after add or change country
	 */
	public function update_config_refresh()
	{
		// Say to refresh the country users cache after update
		$this->cache_country->update_config_refresh();
	}

	/**
	 * Add user country in hidden fields of registration form
	 *
	 * @param array $event
	 */
	public function ucp_register_agreement_country($event)
	{
		$event['s_hidden_fields'] = array_merge($event['s_hidden_fields'], [
			'user_country'	=> $this->request->variable('user_country', ''),
		]);
	}

	/**
	 * Add position of flag in prefs personal data
	 * Since 1.4.0 version
	 *
	 * @param array $event
	 */
	public function ucp_prefs_personal_data($event)
	{
		if ($data = $this->user->data['user_country'])
		{
			$username = '<span class="username-coloured" style="color: #' . $this->user->data['user_colour'] . ';">' . $this->user->data['username'] . '</span>';

			$event['data'] = array_merge($event['data'], [
				'user_country_sort'	=> $this->request->variable('user_country_sort', $this->user->data['user_country_sort']),
			]);

			$this->template->assign_vars([
				'COUNTRY_SELECT'	=> $this->country->ucp_sort_select((int) $event['data']['user_country_sort']),
				'COUNTRY_NAME_0'	=> $this->country->get_country_img($username, $data, $data, ($this->config['countryflag_position'] ? 'left' : 'right')),
				'COUNTRY_NAME_1'	=> $this->country->get_country_img($username, $data, $data, 'left'),
				'COUNTRY_NAME_2'	=> $this->country->get_country_img($username, $data, $data, 'right'),
				'COUNTRY_CHOICE'	=> $this->user->data['user_country_sort'],
			]);
		}
	}

	/**
	 * Update prefs personal data
	 * Since 1.4.0 version
	 *
	 * @param array $event
	 */
	public function ucp_prefs_personal_update_data($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], [
			'user_country_sort'	=> $event['data']['user_country_sort'],
		]);
	}
}
