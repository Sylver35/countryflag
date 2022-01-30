<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2022 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\migrations;

use phpbb\db\migration\migration;

class countryflag_1_2_0 extends migration
{
	static public function depends_on()
	{
		return ['\sylver35\countryflag\migrations\countryflag_initial_schema'];
	}

	public function update_data()
	{
		return [
			['config.add', ['countryflag_img', '<img src="%1$s" alt="%2$s" title="%3$s" class="%4$s" width="%5$s" />', 0]],
			['config.add', ['countryflag_img_anim', '<img src="%1$s" alt="%2$s" title="%3$s" width="%4$s" />', 0]],
		];
	}
}
