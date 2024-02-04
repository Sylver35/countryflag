<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2024 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\migrations;

class countryflag_initial_schema extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'users', 'user_country') && $this->db_tools->sql_table_exists($this->table_prefix . 'country');
	}

	static public function depends_on()
	{
		return ['\phpbb\db\migration\data\v32x\v325'];
	}

	public function update_schema()
	{
		return [
			'add_columns'	=> [
				$this->table_prefix . 'users'	=> [
					'user_country'	=> ['VCHAR:2', '0'],
				],
			],
			'add_tables'	=> [
				$this->table_prefix . 'countryflag' => [
					'COLUMNS' => [
						'id'			=> ['UINT', null, 'auto_increment'],
						'code_iso'		=> ['VCHAR:2', ''],
						'country_en'	=> ['VCHAR:255', ''],
						'country_fr'	=> ['VCHAR:255', ''],
					],
					'PRIMARY_KEY'	=> ['id'],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns'	=> [
				$this->table_prefix . 'users'	=> [
					'user_country',
				],
			],
			'drop_tables'	=> [
				$this->table_prefix . 'countryflag',
			],
		];
	}
}
