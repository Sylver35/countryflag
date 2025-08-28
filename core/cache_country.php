<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2025 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\core;

use phpbb\config\config;
use phpbb\cache\driver\driver_interface as cache;
use phpbb\db\driver\driver_interface as db;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\auth\auth;
use phpbb\language\language;
use phpbb\extension\manager;

class cache_country
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

	/** @var \phpbb\auth\auth */
	protected $auth;

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
	public function __construct(config $config, cache $cache, db $db, request $request, template $template, user $user, auth $auth, language $language, manager $ext_manager, $root_path, $php_ext, $countryflag_table)
	{
		$this->config = $config;
		$this->cache = $cache;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->auth = $auth;
		$this->language = $language;
		$this->ext_manager = $ext_manager;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		$this->countryflag_table = $countryflag_table;
		$this->ext_path = generate_board_url() . '/ext/sylver35/countryflag/';
	}

	public function update_config_refresh()
	{
		$this->config->set_atomic('countryflag_refresh_cache', 0, 1, false);
	}

	public function destroy_country_cache()
	{
		// First, destroy cache files
		$this->cache->destroy('_country_users');
		$this->cache->destroy('_country_list');
		$this->cache->destroy('_country_list_users');

		// Second, reload them
		$this->country_users(); 
		$this->country_list();
		$this->country_list_users();

		// And reset refresh_cache
		$this->config->set_atomic('countryflag_refresh_cache', 1, 0, false);
	}

	public function country_users()
	{
		if (($country = $this->cache->get('_country_users')) === false)
		{
			$pos = [];
			$sql = $this->db->sql_build_query('SELECT', [
				'SELECT'	=> 'u.user_country, c.id, c.code_iso',
				'FROM'		=> [USERS_TABLE => 'u'],
				'LEFT_JOIN'	=> [
					[
						'FROM'	=> [$this->countryflag_table => 'c'],
						'ON'	=> 'c.code_iso = u.user_country',
					],
				],
				'WHERE'		=> "u.user_country <> '0'",
			]);
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$pos[$row['id']] = (int) (isset($pos[$row['id']])) ? $pos[$row['id']] + 1 : 1;
			}
			$this->db->sql_freeresult($result);

			arsort($pos, SORT_NUMERIC);
			
			$data = [];
			$sql_ary = $this->db->sql_build_query('SELECT', [
				'SELECT'	=> 'u.user_id, u.user_country, c.id, c.code_iso, c.country_en, c.country_fr',
				'FROM'		=> [USERS_TABLE => 'u'],
				'LEFT_JOIN'	=> [
					[
						'FROM'	=> [$this->countryflag_table => 'c'],
						'ON'	=> 'c.code_iso = u.user_country',
					],
				],
				'WHERE'		=> "u.user_country <> '0'",
				'ORDER_BY'	=> 'u.user_id ASC',
			]);
			$result = $this->db->sql_query($sql_ary);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$data[$row['user_id']] = [
					'id'			=> (int) $row['id'],
					'total'			=> (isset($pos[$row['id']])) ? $pos[$row['id']] : 0,
					'user_id'		=> (int) $row['user_id'],
					'code_iso'		=> (string) $row['code_iso'],
					'country_en'	=> (string) $row['country_en'],
					'country_fr'	=> (string) $this->accent($row['code_iso'], $row['country_fr']),
				];
			}
			$this->db->sql_freeresult($result);

			// cache for 7 days
			$this->cache->put('_country_users', $data, 604800);
		}

		return $country;
	}

	public function country_list()
	{
		if (($list = $this->cache->get('_country_list')) === false)
		{
			$pos = $list = [];
			// Get the total of users by country
			$sql = $this->db->sql_build_query('SELECT', [
				'SELECT'	=> 'u.user_id, u.user_country, c.id',
				'FROM'		=> [USERS_TABLE => 'u'],
				'LEFT_JOIN'	=> [
					[
						'FROM'	=> [$this->countryflag_table => 'c'],
						'ON'	=> 'c.code_iso = u.user_country',
					],
				],
				'WHERE'		=> "user_country <> '0'",
			]);
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$pos[$row['id']] = (int) (isset($pos[$row['id']])) ? $pos[$row['id']] + 1 : 1;
			}
			$this->db->sql_freeresult($result);

			$sql = $this->db->sql_build_query('SELECT', [
				'SELECT'	=> 'id, code_iso, country_en, country_fr',
				'FROM'		=> [$this->countryflag_table => ''],
			]);
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$list[$row['id']] = [
					'id'			=> (int) $row['id'],
					'total'			=> (isset($pos[$row['id']])) ? $pos[$row['id']] : 0,
					'code_iso'		=> (string) $row['code_iso'],
					'country_en'	=> (string) $row['country_en'],
					'country_fr'	=> (string) $this->accent($row['code_iso'], $row['country_fr']),
				];
			}
			$this->db->sql_freeresult($result);

			// cache for 7 days
			$this->cache->put('_country_list', $list, 604800);
		}

		return $list;
	}

	public function country_list_users()
	{
		if (($list = $this->cache->get('_country_list_users')) === false)
		{
			$pos = [];
			$sql = $this->db->sql_build_query('SELECT', [
				'SELECT'	=> 'u.user_id, u.user_country, c.id',
				'FROM'		=> [USERS_TABLE => 'u'],
				'LEFT_JOIN'	=> [
					[
						'FROM'	=> [$this->countryflag_table => 'c'],
						'ON'	=> 'c.code_iso = u.user_country',
					],
				],
				'WHERE'		=> "user_country <> '0'",
			]);
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$pos[] = (int) $row['id'];
			}
			$this->db->sql_freeresult($result);
			
			$pos = array_unique($pos, SORT_NUMERIC);

			// cache for 7 days
			$this->cache->put('_country_list_users', $pos, 604800);
		}

		return $list;
	}

	/**
	 * Add accent for somes countries
	 *
	 * @param string $iso
	 * @param string $country
	 * @return string
	 * @access public
	 */
	public function accent($iso, $country)
	{
		if (in_array($iso, ['ae', 'ec', 'eg', 'er', 'et', 'us']))
		{
			$country = str_replace('E', 'É', $country);
		}

		return $country;
	}
}
