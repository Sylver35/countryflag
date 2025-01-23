<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2025 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\migrations;

use phpbb\db\migration\migration;

class countryflag_1_8_1 extends migration
{
	static public function depends_on()
	{
		return ['\sylver35\countryflag\migrations\countryflag_1_8_0'];
	}
	
	public function update_data()
	{
		return [
			['config.add', ['countryflag_display_index', '1', 0]],
			['config.add', ['countryflag_index_lines', '1', 0]],
		];
	}
}
