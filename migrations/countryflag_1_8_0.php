<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2024 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\migrations;

use phpbb\db\migration\migration;

class countryflag_1_8_0 extends migration
{
	static public function depends_on()
	{
		return ['\sylver35\countryflag\migrations\countryflag_1_4_0'];
	}
	
	public function update_data()
	{
		return [
			['custom',
				[
					[&$this, 'update_country_flag'],
				],
			],
		];
	}

	public function update_country_flag()
	{
		$sql_ary = [
			'code_iso'		=> 'gf',
			'country_en'	=> 'French Guyana',
			'country_fr'	=> 'Guyane Française',
		];
		$this->db->sql_query('INSERT INTO ' . $this->table_prefix . 'countryflag ' . $this->db->sql_build_array('INSERT', $sql_ary));
	}
}
