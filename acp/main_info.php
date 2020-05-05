<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2018-2020 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\sylver35\countryflag\acp\main_module',
			'title'		=> 'ACP_COUNTRYFLAG_MODULE',
			'modes'		=> array(
				'config'		=> array(
					'title'	=> 'ACP_COUNTRYFLAG_CONFIG',
					'auth'	=> 'ext_sylver35/countryflag && acl_a_board',
					'cat'	=> array('ACP_COUNTRYFLAG_MODULE'),
				),
			),
		);
	}
}
