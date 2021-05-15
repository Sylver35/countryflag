<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2021 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use sylver35\countryflag\core\country;
use phpbb\auth\auth;
use phpbb\config\config;
use phpbb\template\template;
use phpbb\user;
use phpbb\language\language;
use phpbb\request\request;

class listener implements EventSubscriberInterface
{
	/* @var \sylver35\countryflag\core\country */
	protected $country;

	/** @var \phpbb\auth\auth */
	protected $auth;

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

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	/**
	 * Listener constructor
	 */
	public function __construct(country $country, auth $auth, config $config, template $template, user $user, language $language, request $request, $root_path, $php_ext)
	{
		$this->country = $country;
		$this->auth = $auth;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->request = $request;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * Function that returns the subscribed events
	 *
	 * @return array Array with the subscribed events
	 */
	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup' 									=> 'load_countryflag',
			'core.page_header_after'							=> 'page_header_after',
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
			'core.ucp_register_agreement_modify_template_data' 	=> 'ucp_register_agreement_country',
			'core.ucp_prefs_personal_data'						=> 'ucp_prefs_personal_data',
			'core.ucp_prefs_personal_update_data'				=> 'ucp_prefs_personal_update_data',
			'core.acp_users_modify_profile'						=> 'acp_user_country_profile',
			'core.acp_users_profile_modify_sql_ary'				=> 'user_profile_sql_ary',
			'core.acp_users_profile_validate'					=> 'destroy_cache_country_users',
		];
	}

	/**
	 * Cache country users if needed
	 */
	public function load_countryflag()
	{
		$this->country->cache_country_users();
	}

	/**
	 * Create URL and display message to user if needed
	 */
	public function page_header_after()
	{
		$this->country->write_version();
		if ($this->user->data['is_registered'] && !$this->user->data['is_bot'] && !$this->user->data['user_country'])
		{
			if ($this->config['countryflag_required'] && $this->auth->acl_get('u_chgprofileinfo'))
			{
				// Display message choosing country
				$this->country->display_message();
				// Redirect if needed
				$this->country->redirect_to_profile();
			}
		}
	}

	/**
	 * Display flag with username
	 *
	 * @param array $event
	 */
	public function modify_username_string_flag($event)
	{
		if ($event['mode'] === 'full' || $event['mode'] === 'no_profile')
		{
			// Get the country users from cache
			$data = $this->country->get_country_users_cache();
			// Do this just for users who have country
			if (isset($data[$event['user_id']]['user_id']))
			{
				$lang = ($this->user->lang_name == 'fr') ? 'fr' : 'en';
				$event['username_string'] = $this->country->get_country_img($event['username_string'], $data[$event['user_id']]['code_iso'], $data[$event['user_id']]["country_{$lang}"]);
			}
		}
	}

	/**
	 * Destroy cache country users after validate profile
	 */
	public function destroy_cache_country_users()
	{
		$this->country->destroy_country_users_cache();
	}

	/**
	 * Add country select in profile
	 *
	 * @param array $event
	 */
	public function user_country_profile($event)
	{
		$event['data'] = array_merge($event['data'], [
			'user_country'	=> $this->request->variable('user_country', $country),
		]);
		$this->country->add_country($event, $this->user->data['user_country'], false, true);
	}

	/**
	 * Add country select in register form
	 *
	 * @param array $event
	 */
	public function user_country_profile_register($event)
	{
		$event['data'] = array_merge($event['data'], [
			'user_country'	=> $this->request->variable('user_country', $country),
		]);
		$this->country->add_country($event, $this->user->data['user_country'], false, false);
	}

	/**
	 * Add country select in acp profile
	 *
	 * @param array $event
	 */
	public function acp_user_country_profile($event)
	{
		$event['data'] = array_merge($event['data'], [
			'user_country'	=> $this->request->variable('user_country', $country),
		]);
		$this->country->add_country($event, $event['user_row']['user_country'], true, false);
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
			// Refresh the country users cache now
			$this->country->destroy_country_users_cache();
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
			// Refresh the country users cache now
			$this->country->destroy_country_users_cache();
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
		$this->country->destroy_country_users_cache();
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
	 * Add user_country_sort in prefs personal data
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
