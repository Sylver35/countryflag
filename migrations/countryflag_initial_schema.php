<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2018-2020 Sylver35  https://breizhcode.com
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
		return array('\phpbb\db\migration\data\v32x\v325');
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_country'	=> array('VCHAR:2', '0'),
				),
			),
			'add_tables'	=> array(
				$this->table_prefix . 'countryflag' => array(
					'COLUMNS' => array(
						'id'			=> array('UINT', null, 'auto_increment'),
						'code_iso'		=> array('VCHAR:2', ''),
						'country_en'	=> array('VCHAR:255', ''),
						'country_fr'	=> array('VCHAR:255', ''),
					),
					'PRIMARY_KEY'	=> array('id'),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_country',
				),
			),
			'drop_tables'	=> array(
				$this->table_prefix . 'countryflag',
			),
		);
	}
}
