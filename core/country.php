<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2018-2020 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\core;
use phpbb\config\config;
use phpbb\cache\driver\driver_interface as cache;
use phpbb\db\driver\driver_interface as db;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\language\language;
use phpbb\extension\manager;

class country
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\cache\driver\driver_interface */
	protected $cache;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\extension\manager */
	protected $ext_manager;

	/** @var string phpBB root path */
	protected $root_path;

	/** @var string phpEx */
	protected $php_ext;

	/** @var string ext path */
	protected $ext_path;

	/**
	 * The countryflag database table
	 *
	 * @var string */
	protected $countryflag_table;

	/**
	 * Constructor
	 */
	public function __construct(config $config, cache $cache, db $db, request $request, template $template, user $user, language $language, manager $ext_manager, $root_path, $php_ext, $countryflag_table)
	{
		$this->config = $config;
		$this->cache = $cache;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->ext_manager = $ext_manager;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->countryflag_table = $countryflag_table;
		$this->ext_path = generate_board_url() . '/ext/sylver35/countryflag/';
	}

	public function get_country_users_cache()
	{
		return $this->cache->get('_country_users');
	}

	public function destroy_country_users_cache()
	{
		$this->cache->destroy('_country_users');
	}

	public function cache_country_users()
	{
		$this->language->add_lang('countryflag', 'sylver35/countryflag');
		if ($this->cache->get('_country_users') === false)
		{
			$country = [];
			$country[0] = $this->get_version();
			$sql_ary = array(
				'SELECT'	=> 'u.user_id, u.user_country, c.*',
				'FROM'		=> array(USERS_TABLE => 'u'),
				'LEFT_JOIN'	=> array(
					array(
						'FROM'	=> array($this->countryflag_table => 'c'),
						'ON'	=> 'c.code_iso = u.user_country',
					),
				),
				'WHERE'		=> "u.user_type <> 2 AND u.user_country <> '0'",
				'ORDER_BY'	=> 'u.user_id ASC',
			);
			$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
			while ($row = $this->db->sql_fetchrow($result))
			{
				$country[$row['user_id']] = array(
					'user_id'		=> $row['user_id'],
					'code_iso'		=> $row['code_iso'],
					'country_en'	=> $row['country_en'],
					'country_fr'	=> $this->accent_in_country($row['code_iso'], $row['country_fr']),
				);
			}
			$this->db->sql_freeresult($result);
			// cache for 7 days
			$this->cache->put('_country_users', $country, 604800);
		}
	}

	public function get_version()
	{
		$md_manager = $this->ext_manager->create_extension_metadata_manager('sylver35/countryflag');
		$meta = $md_manager->get_metadata();

		return array(
			'version'	=> $meta['version'],
			'homepage'	=> $meta['homepage'],
		);
	}

	public function display_message()
	{
		// Display message choosing country
		if ($this->config['countryflag_message'])
		{
			$this->template->assign_vars(array(
				'S_COUNTRY_MESSAGE_DISPLAY'	=> true,
				'COUNTRY_PROFILE_GO_TO'		=> $this->language->lang('COUNTRY_REDIRECT_MSG', '<a href="' . append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=ucp_profile&amp;mode=profile_info') . '">', '</a>'),
			));
		}
	}

	public function redirect_to_profile()
	{
		// Redirect if needed
		if ($this->config['countryflag_redirect'])
		{
			$page_name = substr($this->user->page['page_name'], 0, strpos($this->user->page['page_name'], '.'));
			if ($page_name != 'ucp' && $page_name != 'posting')
			{
				redirect(append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=ucp_profile&amp;mode=profile_info'));
			}
		}
	}

	public function write_version()
	{
		if (!$this->user->data['is_registered'] || $this->user->data['is_bot'])
		{
			if ($version = $this->get_country_users_cache())
			{
				$this->template->assign_vars(array(
					'COUNTRYFLAG_COPY'	=> $this->language->lang('COUNTRYFLAG_COPY', $version[0]['homepage'], $version[0]['version']),
				));
			}
		}
	}

	public function get_country_img($username, $iso, $country, $force = 'none')
	{
		$position = (bool) $this->config['countryflag_position'];
		if ($force === 'none')
		{
			if ($this->user->data['is_registered'] && !$this->user->data['is_bot'])
			{
				if ($this->user->data['user_country_sort'] != 0)
				{
					$position = ($this->user->data['user_country_sort'] == 1) ? true : false;
				}
			}
		}
		else
		{
			$position = ($force === 'left') ? true : false;
		}

		$flag = sprintf($this->config['countryflag_img'], $this->ext_path . 'flags/' . $iso . '.png', $country, $country . ' (' . $iso . ')', 'flag-user flag-' . $this->config['countryflag_width'], $this->config['countryflag_width']);

		if ($position)
		{
			// Display the flag before username
			$username = $flag . $this->language->lang('COUNTRYFLAG_SEPARATE') . $username;
		}
		else
		{
			// Display the flag after username
			$username = $username . $this->language->lang('COUNTRYFLAG_SEPARATE') . $flag;
		}

		return $username;
	}

	/**
	 * Display anim flag
	 *
	 * @param int $id
	 * @return void
	 * @access public
	 */
	public function get_country_img_anim($id)
	{
		$country = $this->cache->get('_country_users');
		if (isset($country[$id]['user_id']))
		{
			$lang = $this->country_lang();
			$src = $this->ext_path . 'anim/' . $country[$id]['code_iso'] . '.gif';
			return array(
				'image'		=> sprintf($this->config['countryflag_img_anim'], $src, $country[$id]["country_{$lang}"], $country[$id]["country_{$lang}"] . ' (' . $country[$id]['code_iso'] . ')', $this->config['countryflag_width_anim']),
				'country'	=> $country[$id]["country_{$lang}"] . ' (' . $country[$id]['code_iso'] . ')',
			);
		}
		return false;
	}

	/**
	 * Select lang for country
	 *
	 * @param int $id
	 * @return string
	 * @access public
	 */
	public function country_lang()
	{
		if ($this->user->lang_name == 'fr')
		{
			$lang = 'fr';
		}
		else
		{
			$lang = 'en';
		}

		return $lang;
	}

	/**
	 * Add country select in member form
	 *
	 * @param array $event
	 * @param string $country
	 * @param bool $on_acp
	 * @param bool $on_profile
	 * @return void
	 * @access public
	 */
	public function add_country($event, $country, $on_acp, $on_profile)
	{
		$event['data'] = array_merge($event['data'], array(
			'user_country'	=> $this->request->variable('user_country', $country),
		));

		$this->on_select_flag($event['data']['user_country'], $on_acp, $on_profile);

		if (!$on_acp)
		{
			if (empty($event['data']['user_country']) && $this->config['countryflag_required'])
			{
				$this->template->assign_vars(array(
					'ERROR_COUNTRY'		=> $this->language->lang('COUNTRY_ERROR'),
				));
			}
		}

		$this->template->assign_vars(array(
			'COUNTRY_FLAG_REQUIRED'		=> $this->config['countryflag_required'] ? ' *' : '',
			'S_COUNTRY_FLAG_ACTIVE'		=> true,
		));
	}

	/**
	 * Build select country flag
	 *
	 * @param string $flag
	 * @param bool $on_acp
	 * @param bool $on_profile
	 * @return void
	 * @access private
	 */
	private function on_select_flag($flag = '', $on_acp = false, $on_profile = false)
	{
		$flag_image = '0';
		$title = $this->language->lang('COUNTRYFLAG_SORT_FLAG');
		$sort = ($this->user->lang_name == 'fr') ? 'fr' : 'en';
		$select = ($flag == '' && !$this->config['countryflag_default'] && !$on_acp) ? ' selected="selected"' : '';

		$flag_options = '<option value="0" title="' . $this->language->lang('COUNTRYFLAG_SORT_FLAG') . '"' . $select . '> ' . $this->language->lang('COUNTRYFLAG_SORT_FLAG') . "</option>\n";
		$sql = array(
			'SELECT'	=> 'id, code_iso, country_en, country_fr',
			'FROM'		=> array($this->countryflag_table => ''),
			'ORDER_BY'	=> 'country_' . $sort,
		);
		$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql));
		while ($row = $this->db->sql_fetchrow($result))
		{
			$selected = '';
			$row['country_fr'] = $this->accent_in_country($row['code_iso'], $row['country_fr']);
			$country = $row["country_{$sort}"] . ' (' . $row['code_iso'] . ')';
			if ($row['code_iso'] == $flag || !$flag && ($row['code_iso'] == $this->config['countryflag_default']) && !$on_acp && !$on_profile)
			{
				$selected = ' selected="selected"';
				$title = $country;
				$flag_image = $row['code_iso'];
			}
			$flag_options .= '<option value="' . $row['code_iso'] . '" title="' . $country . '"' . $selected . '>' . $row["country_{$sort}"] . "</option>\n";
		}
		$this->db->sql_freeresult($result);

		$this->template->assign_vars(array(
			'COUNTRY_FLAG_PATH'			=> $this->ext_path . 'flags/',
			'COUNTRY_FLAG_IMAGE'		=> $this->ext_path . 'flags/' . $flag_image . '.png',
			'COUNTRY_FLAG_TITLE'		=> $title,
			'S_COUNTRY_FLAG_OPTIONS'	=> $flag_options,
		));
	}

	/**
	 * Add accent for somes country
	 *
	 * @param string $iso
	 * @param string $country
	 * @return string
	 * @access public
	 */
	public function accent_in_country($iso, $country)
	{
		if (in_array($iso, array('ae', 'ec', 'eg', 'er', 'et', 'us')))
		{
			$country = str_replace('E', 'É', $country);
		}

		return $country;
	}

	/**
	 * Select position of flag
	 *
	 * @param int $value
	 * @return string
	 * @access public
	 */
	public function ucp_sort_select($value)
	{
		$select = '<option value="0" ' . (($value == 0) ? ' selected="selected"' : '') . '>' . $this->language->lang('COUNTRYFLAG_SELECT_DEFAULT') . '</option>';
		$select .= '<option value="1" ' . (($value == 1) ? ' selected="selected"' : '') . '>' . $this->language->lang('COUNTRYFLAG_SELECT_BEFORE') . '</option>';
		$select .= '<option value="2" ' . (($value == 2) ? ' selected="selected"' : '') . '>' . $this->language->lang('COUNTRYFLAG_SELECT_AFTER') . '</option>';

		return $select;
	}
}
