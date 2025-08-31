<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2025 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\migrations;

use phpbb\db\migration\migration;

class countryflag_1_8_3 extends migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'countryflag', 'total');
	}

	static public function depends_on()
	{
		return ['\sylver35\countryflag\migrations\countryflag_1_8_2'];
	}

	public function update_schema()
	{
		return [
			'add_columns'	=> [
				$this->table_prefix . 'countryflag'	=> [
					'total'	=> ['UINT:4', 0],
				],
			],
		];
	}

	public function update_data()
	{
		return [
			// Set NEWLY_REGISTERED permission for add country in profile
			['permission.permission_set', ['NEWLY_REGISTERED', ['u_chgprofileinfo'], 'group']],

			// Custon function
			['custom', [[&$this, 'add_total_users']]],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns'	=> [
				$this->table_prefix . 'countryflag'	=> [
					'total',
				],
			],
		];
	}

	public function add_total_users()
	{
		$list = [];
		// Get the total of users by country
		$sql = $this->db->sql_build_query('SELECT', [
			'SELECT'	=> 'u.user_id, u.user_country, c.id',
			'FROM'		=> [USERS_TABLE => 'u'],
			'LEFT_JOIN'	=> [
				[
					'FROM'	=> [$this->table_prefix . 'countryflag' => 'c'],
					'ON'	=> 'c.code_iso = u.user_country',
				],
			],
			'WHERE'		=> "user_country <> '0'",
		]);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			// Initialise to 1 or increment
			$list[$row['id']] = (isset($list[$row['id']])) ? $list[$row['id']] + 1 : 1;
		}
		$this->db->sql_freeresult($result);

		// Add the total now
		foreach ($list as $id => $total)
		{
			$sql = 'UPDATE ' . $this->table_prefix . 'countryflag 
				SET total = ' . (int) $total . '
				WHERE id = ' . (int) $id;
			$this->db->sql_query($sql);
		}
	}
}
