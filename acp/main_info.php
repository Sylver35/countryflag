<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2021 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\acp;

class main_info
{
	public function module()
	{
		return [
			'filename'	=> '\sylver35\countryflag\acp\main_module',
			'title'		=> 'ACP_COUNTRYFLAG_MODULE',
			'modes'		=> [
				'config'		=> [
					'title'	=> 'ACP_COUNTRYFLAG_CONFIG',
					'auth'	=> 'ext_sylver35/countryflag && acl_a_board',
					'cat'	=> ['ACP_COUNTRYFLAG_MODULE'],
				],
			],
		];
	}
}
