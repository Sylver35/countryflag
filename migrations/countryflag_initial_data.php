<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2022 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

namespace sylver35\countryflag\migrations;

class countryflag_initial_data extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return isset($this->config['countryflag_required']);
	}

	static public function depends_on()
	{
		return ['\sylver35\countryflag\migrations\countryflag_initial_schema'];
	}

	public function update_data()
	{
		return [
			['config.add', ['countryflag_required', true]],
			['config.add', ['countryflag_message', true]],
			['config.add', ['countryflag_redirect', true]],
			['config.add', ['countryflag_position', true]],
			['config.add', ['countryflag_default', '']],
			['config.add', ['countryflag_width', '12']],
			['config.add', ['countryflag_width_anim', '48']],
			['config.add', ['countryflag_display_topic', true]],
			['config.add', ['countryflag_display_pm', true]],
			['config.add', ['countryflag_display_memberlist', true]],

			[
				'module.add',
				[
					'acp',
					'ACP_CAT_DOT_MODS',
					[
						'module_langname'	=> 'ACP_COUNTRYFLAG_MODULE',
					],
				],
			],
			[
				'module.add',
				[
					'acp',
					'ACP_COUNTRYFLAG_MODULE',
					[
						'module_basename'	=> '\sylver35\countryflag\acp\main_module',
						'module_langname'	=> 'ACP_COUNTRYFLAG_CONFIG',
						'module_mode'		=> 'config',
						'module_auth'		=> 'ext_sylver35/countryflag && acl_a_board',
					],
				],
			],

			['custom',
				[
					[&$this, 'install_country_flag'],
				],
			],
		];
	}

	public function install_country_flag()
	{
		if ($this->db_tools->sql_table_exists($this->table_prefix . 'countryflag'))
		{
			$sql_ary = [
				[
					'code_iso'		=> 'ac',
					'country_en'	=> 'Ascension Island',
					'country_fr'	=> 'Ascension Îles'],
				[
					'code_iso'		=> 'ad',
					'country_en'	=> 'Andorra',
					'country_fr'	=> 'Andorre'],
				[
					'code_iso'		=> 'ae',
					'country_en'	=> 'United Arab Emirates',
					'country_fr'	=> 'Emirats Arabes Unis'],
				[
					'code_iso'		=> 'af',
					'country_en'	=> 'Afghanistan',
					'country_fr'	=> 'Afghanistan'],
				[
					'code_iso'		=> 'ag',
					'country_en'	=> 'Antigua and Barbuda',
					'country_fr'	=> 'Antigua et Barbuda'],
				[
					'code_iso'		=> 'ai',
					'country_en'	=> 'Anguilla',
					'country_fr'	=> 'Anguilla'],
				[
					'code_iso'		=> 'al',
					'country_en'	=> 'Albania',
					'country_fr'	=> 'Albanie'],
				[
					'code_iso'		=> 'am',
					'country_en'	=> 'Armenia',
					'country_fr'	=> 'Arménie'],
				[
					'code_iso'		=> 'an',
					'country_en'	=> 'Netherlands Antilles',
					'country_fr'	=> 'Antilles Néerlandaises'],
				[
					'code_iso'		=> 'ao',
					'country_en'	=> 'Angola',
					'country_fr'	=> 'Angola'],
				[
					'code_iso'		=> 'aq',
					'country_en'	=> 'Antarctica',
					'country_fr'	=> 'Antarctique'],
				[
					'code_iso'		=> 'ar',
					'country_en'	=> 'Argentina',
					'country_fr'	=> 'Argentine'],
				[
					'code_iso'		=> 'as',
					'country_en'	=> 'American Samoa',
					'country_fr'	=> 'Samoa Américaines'],
				[
					'code_iso'		=> 'at',
					'country_en'	=> 'Austria',
					'country_fr'	=> 'Autriche'],
				[
					'code_iso'		=> 'au',
					'country_en'	=> 'Australia',
					'country_fr'	=> 'Australie'],
				[
					'code_iso'		=> 'aw',
					'country_en'	=> 'Aruba',
					'country_fr'	=> 'Aruba'],
				[
					'code_iso'		=> 'ax',
					'country_en'	=> 'Aland Islands',
					'country_fr'	=> 'Aland Îles'],
				[
					'code_iso'		=> 'az',
					'country_en'	=> 'Azerbaijan',
					'country_fr'	=> 'Azerbaijan'],
				[
					'code_iso'		=> 'ba',
					'country_en'	=> 'Bosnia and Herzegowina',
					'country_fr'	=> 'Bosnie Herzegovine'],
				[
					'code_iso'		=> 'bb',
					'country_en'	=> 'Barbados',
					'country_fr'	=> 'Barbades'],
				[
					'code_iso'		=> 'bd',
					'country_en'	=> 'Bangladesh',
					'country_fr'	=> 'Bangladesh'],
				[
					'code_iso'		=> 'be',
					'country_en'	=> 'Belgium',
					'country_fr'	=> 'Belgique'],
				[
					'code_iso'		=> 'bf',
					'country_en'	=> 'Burkina Faso',
					'country_fr'	=> 'Burkina Faso'],
				[
					'code_iso'		=> 'bg',
					'country_en'	=> 'Bulgaria',
					'country_fr'	=> 'Bulgarie'],
				[
					'code_iso'		=> 'bh',
					'country_en'	=> 'Bahrain',
					'country_fr'	=> 'Bahreïn'],
				[
					'code_iso'		=> 'bi',
					'country_en'	=> 'Burundi',
					'country_fr'	=> 'Burundi'],
				[
					'code_iso'		=> 'bj',
					'country_en'	=> 'Benin',
					'country_fr'	=> 'Bénin'],
				[
					'code_iso'		=> 'bm',
					'country_en'	=> 'Bermuda',
					'country_fr'	=> 'Bermudes'],
				[
					'code_iso'		=> 'bn',
					'country_en'	=> 'Brunei',
					'country_fr'	=> 'Brunei'],
				[
					'code_iso'		=> 'bo',
					'country_en'	=> 'Bolivia',
					'country_fr'	=> 'Bolivie'],
				[
					'code_iso'		=> 'br',
					'country_en'	=> 'Brazil',
					'country_fr'	=> 'Brésil'],
				[
					'code_iso'		=> 'bs',
					'country_en'	=> 'Bahamas',
					'country_fr'	=> 'Bahamas'],
				[
					'code_iso'		=> 'bt',
					'country_en'	=> 'Bhutan',
					'country_fr'	=> 'Bhoutan'],
				[
					'code_iso'		=> 'bv',
					'country_en'	=> 'Bouvet Island',
					'country_fr'	=> 'Bouvet Îles'],
				[
					'code_iso'		=> 'bw',
					'country_en'	=> 'Botswana',
					'country_fr'	=> 'Botswana'],
				[
					'code_iso'		=> 'by',
					'country_en'	=> 'Belarus',
					'country_fr'	=> 'Biélorussie'],
				[
					'code_iso'		=> 'bz',
					'country_en'	=> 'Belize',
					'country_fr'	=> 'Bélize'],
				[
					'code_iso'		=> 'ca',
					'country_en'	=> 'Canada',
					'country_fr'	=> 'Canada'],
				[
					'code_iso'		=> 'cc',
					'country_en'	=> 'Cocos (Keeling) Islands',
					'country_fr'	=> 'Cocos Îles (Keeling)'],
				[
					'code_iso'		=> 'cd',
					'country_en'	=> 'Congo, Democratic Republic of',
					'country_fr'	=> 'Congo République Démocratique du'],
				[
					'code_iso'		=> 'cf',
					'country_en'	=> 'Central African Republic',
					'country_fr'	=> 'Centrafricaine République'],
				[
					'code_iso'		=> 'cg',
					'country_en'	=> 'Congo',
					'country_fr'	=> 'Congo'],
				[
					'code_iso'		=> 'ch',
					'country_en'	=> 'Switzerland',
					'country_fr'	=> 'Suisse'],
				[
					'code_iso'		=> 'ci',
					'country_en'	=> 'Cote d’Ivoire',
					'country_fr'	=> 'Côte d’Ivoire'],
				[
					'code_iso'		=> 'ck',
					'country_en'	=> 'Cook Islands',
					'country_fr'	=> 'Cook Îles'],
				[
					'code_iso'		=> 'cl',
					'country_en'	=> 'Chile',
					'country_fr'	=> 'Chili'],
				[
					'code_iso'		=> 'cm',
					'country_en'	=> 'Cameroon',
					'country_fr'	=> 'Cameroon'],
				[
					'code_iso'		=> 'cn',
					'country_en'	=> 'China',
					'country_fr'	=> 'Chine'],
				[
					'code_iso'		=> 'co',
					'country_en'	=> 'Colombia',
					'country_fr'	=> 'Colombie'],
				[
					'code_iso'		=> 'cp',
					'country_en'	=> 'Clipperton Island',
					'country_fr'	=> 'Clipperton Île'],
				[
					'code_iso'		=> 'cr',
					'country_en'	=> 'Costa Rica',
					'country_fr'	=> 'Costa Rica'],
				[
					'code_iso'		=> 'cu',
					'country_en'	=> 'Cuba',
					'country_fr'	=> 'Cuba'],
				[
					'code_iso'		=> 'cv',
					'country_en'	=> 'Cape Verde',
					'country_fr'	=> 'Cap Vert'],
				[
					'code_iso'		=> 'cx',
					'country_en'	=> 'Christmas Island',
					'country_fr'	=> 'Christmas Île'],
				[
					'code_iso'		=> 'cy',
					'country_en'	=> 'Cyprus',
					'country_fr'	=> 'Chypre'],
				[
					'code_iso'		=> 'cz',
					'country_en'	=> 'Czech Republic',
					'country_fr'	=> 'Tchèque République'],
				[
					'code_iso'		=> 'de',
					'country_en'	=> 'Germany',
					'country_fr'	=> 'Allemagne'],
				[
					'code_iso'		=> 'dj',
					'country_en'	=> 'Djibouti',
					'country_fr'	=> 'Djibouti'],
				[
					'code_iso'		=> 'dk',
					'country_en'	=> 'Denmark',
					'country_fr'	=> 'Danemark'],
				[
					'code_iso'		=> 'dm',
					'country_en'	=> 'Dominica',
					'country_fr'	=> 'Dominique'],
				[
					'code_iso'		=> 'do',
					'country_en'	=> 'Dominican Republic',
					'country_fr'	=> 'République Dominicaine'],
				[
					'code_iso'		=> 'dz',
					'country_en'	=> 'Algeria',
					'country_fr'	=> 'Algerie'],
				[
					'code_iso'		=> 'ea',
					'country_en'	=> 'Ceuta and Melilla',
					'country_fr'	=> 'Ceuta et Melilla'],
				[
					'code_iso'		=> 'ec',
					'country_en'	=> 'Ecuador',
					'country_fr'	=> 'Equateur'],
				[
					'code_iso'		=> 'ee',
					'country_en'	=> 'Estonia',
					'country_fr'	=> 'Estonie'],
				[
					'code_iso'		=> 'eg',
					'country_en'	=> 'Egypt',
					'country_fr'	=> 'Egypte'],
				[
					'code_iso'		=> 'eh',
					'country_en'	=> 'Western Sahara',
					'country_fr'	=> 'Sahara Occidental'],
				[
					'code_iso'		=> 'er',
					'country_en'	=> 'Eritrea',
					'country_fr'	=> 'Erythrée'],
				[
					'code_iso'		=> 'es',
					'country_en'	=> 'Spain',
					'country_fr'	=> 'Espagne'],
				[
					'code_iso'		=> 'et',
					'country_en'	=> 'Ethiopia',
					'country_fr'	=> 'Ethiopie'],
				[
					'code_iso'		=> 'fi',
					'country_en'	=> 'Finland',
					'country_fr'	=> 'Finlande'],
				[
					'code_iso'		=> 'fj',
					'country_en'	=> 'Fiji',
					'country_fr'	=> 'Fidji'],
				[
					'code_iso'		=> 'fk',
					'country_en'	=> 'Falkland Islands',
					'country_fr'	=> 'Malouines Îles'],
				[
					'code_iso'		=> 'fm',
					'country_en'	=> 'Micronesia',
					'country_fr'	=> 'Micronésie'],
				[
					'code_iso'		=> 'fo',
					'country_en'	=> 'Faroe Islands',
					'country_fr'	=> 'Féroé Îles'],
				[
					'code_iso'		=> 'fr',
					'country_en'	=> 'France',
					'country_fr'	=> 'France'],
				[
					'code_iso'		=> 'ga',
					'country_en'	=> 'Gabon',
					'country_fr'	=> 'Gabon'],
				[
					'code_iso'		=> 'gd',
					'country_en'	=> 'Grenada',
					'country_fr'	=> 'Grenade'],
				[
					'code_iso'		=> 'ge',
					'country_en'	=> 'Georgia',
					'country_fr'	=> 'Géorgie'],
				[
					'code_iso'		=> 'gf',
					'country_en'	=> 'French Guiana',
					'country_fr'	=> 'Guinée Française'],
				[
					'code_iso'		=> 'gg',
					'country_en'	=> 'Guernsey',
					'country_fr'	=> 'Guernesey'],
				[
					'code_iso'		=> 'gh',
					'country_en'	=> 'Ghana',
					'country_fr'	=> 'Ghana'],
				[
					'code_iso'		=> 'gi',
					'country_en'	=> 'Gibraltar',
					'country_fr'	=> 'Gibraltar'],
				[
					'code_iso'		=> 'gl',
					'country_en'	=> 'Greenland',
					'country_fr'	=> 'Groenland'],
				[
					'code_iso'		=> 'gm',
					'country_en'	=> 'Gambia',
					'country_fr'	=> 'Gambie'],
				[
					'code_iso'		=> 'gn',
					'country_en'	=> 'Guinea',
					'country_fr'	=> 'Guinée'],
				[
					'code_iso'		=> 'gp',
					'country_en'	=> 'Guadeloupe',
					'country_fr'	=> 'Guadeloupe'],
				[
					'code_iso'		=> 'gq',
					'country_en'	=> 'Equatorial Guinea',
					'country_fr'	=> 'Guinée Equatoriale'],
				[
					'code_iso'		=> 'gr',
					'country_en'	=> 'Greece',
					'country_fr'	=> 'Grèce'],
				[
					'code_iso'		=> 'gs',
					'country_en'	=> 'South Georgia and the South Sandwich Islands',
					'country_fr'	=> 'Georgie du Sud et les Îles Sandwich du Sud'],
				[
					'code_iso'		=> 'gt',
					'country_en'	=> 'Guatemala',
					'country_fr'	=> 'Guatemala'],
				[
					'code_iso'		=> 'gu',
					'country_en'	=> 'Guam',
					'country_fr'	=> 'Guam Île de'],
				[
					'code_iso'		=> 'gw',
					'country_en'	=> 'Guinea Bissau',
					'country_fr'	=> 'Guinée Bissau'],
				[
					'code_iso'		=> 'gy',
					'country_en'	=> 'Guyana',
					'country_fr'	=> 'Guyana'],
				[
					'code_iso'		=> 'hk',
					'country_en'	=> 'Hong Kong',
					'country_fr'	=> 'Hong Kong'],
				[
					'code_iso'		=> 'hm',
					'country_en'	=> 'Heard Island and McDonald Islands',
					'country_fr'	=> 'Heard et McDonald Îles'],
				[
					'code_iso'		=> 'hn',
					'country_en'	=> 'Honduras',
					'country_fr'	=> 'Honduras'],
				[
					'code_iso'		=> 'hr',
					'country_en'	=> 'Croatia',
					'country_fr'	=> 'Croatie'],
				[
					'code_iso'		=> 'ht',
					'country_en'	=> 'Haiti',
					'country_fr'	=> 'Haïti'],
				[
					'code_iso'		=> 'hu',
					'country_en'	=> 'Hungary',
					'country_fr'	=> 'Hongrie'],
				[
					'code_iso'		=> 'ic',
					'country_en'	=> 'Canary Islands',
					'country_fr'	=> 'Canaries Îles'],
				[
					'code_iso'		=> 'id',
					'country_en'	=> 'Indonesia',
					'country_fr'	=> 'Indonésie'],
				[
					'code_iso'		=> 'ie',
					'country_en'	=> 'Ireland',
					'country_fr'	=> 'Irlande'],
				[
					'code_iso'		=> 'il',
					'country_en'	=> 'Israel',
					'country_fr'	=> 'Israël'],
				[
					'code_iso'		=> 'im',
					'country_en'	=> 'Isle of Man',
					'country_fr'	=> 'Man Île de'],
				[
					'code_iso'		=> 'in',
					'country_en'	=> 'India',
					'country_fr'	=> 'Inde'],
				[
					'code_iso'		=> 'io',
					'country_en'	=> 'British Indian Ocean Territory',
					'country_fr'	=> 'Territoire Anglais Océan Indien'],
				[
					'code_iso'		=> 'iq',
					'country_en'	=> 'Iraq',
					'country_fr'	=> 'Iraq'],
				[
					'code_iso'		=> 'ir',
					'country_en'	=> 'Iran',
					'country_fr'	=> 'Iran'],
				[
					'code_iso'		=> 'is',
					'country_en'	=> 'Iceland',
					'country_fr'	=> 'Islande'],
				[
					'code_iso'		=> 'it',
					'country_en'	=> 'Italy',
					'country_fr'	=> 'Italie'],
				[
					'code_iso'		=> 'je',
					'country_en'	=> 'Jersey',
					'country_fr'	=> 'Jersey'],
				[
					'code_iso'		=> 'jm',
					'country_en'	=> 'Jamaica',
					'country_fr'	=> 'Jamaique'],
				[
					'code_iso'		=> 'jo',
					'country_en'	=> 'Jordan',
					'country_fr'	=> 'Jordanie'],
				[
					'code_iso'		=> 'jp',
					'country_en'	=> 'Japan',
					'country_fr'	=> 'Japon'],
				[
					'code_iso'		=> 'ke',
					'country_en'	=> 'Kenya',
					'country_fr'	=> 'Kenya'],
				[
					'code_iso'		=> 'kg',
					'country_en'	=> 'Kyrgyzstan',
					'country_fr'	=> 'Kyrgyzstan'],
				[
					'code_iso'		=> 'kh',
					'country_en'	=> 'Cambodia',
					'country_fr'	=> 'Cambodge'],
				[
					'code_iso'		=> 'ki',
					'country_en'	=> 'Kiribati',
					'country_fr'	=> 'Kiribati Îles'],
				[
					'code_iso'		=> 'km',
					'country_en'	=> 'Comoros',
					'country_fr'	=> 'Comores'],
				[
					'code_iso'		=> 'kn',
					'country_en'	=> 'Saint Kitts and Nevis',
					'country_fr'	=> 'Saint Kitts et Nevis'],
				[
					'code_iso'		=> 'kp',
					'country_en'	=> 'North Korea',
					'country_fr'	=> 'Corée du Nord'],
				[
					'code_iso'		=> 'kr',
					'country_en'	=> 'Korea, Republic of',
					'country_fr'	=> 'Corée République de'],
				[
					'code_iso'		=> 'kw',
					'country_en'	=> 'Kuwait',
					'country_fr'	=> 'Koweit'],
				[
					'code_iso'		=> 'ky',
					'country_en'	=> 'Cayman Islands',
					'country_fr'	=> 'Caiman Îles'],
				[
					'code_iso'		=> 'kz',
					'country_en'	=> 'Kazakhstan',
					'country_fr'	=> 'Kazakhstan'],
				[
					'code_iso'		=> 'la',
					'country_en'	=> 'Laos',
					'country_fr'	=> 'Laos'],
				[
					'code_iso'		=> 'lb',
					'country_en'	=> 'Lebanon',
					'country_fr'	=> 'Liban'],
				[
					'code_iso'		=> 'lc',
					'country_en'	=> 'Saint Lucia',
					'country_fr'	=> 'Sainte Lucie'],
				[
					'code_iso'		=> 'li',
					'country_en'	=> 'Liechtenstein',
					'country_fr'	=> 'Liechtenstein'],
				[
					'code_iso'		=> 'lk',
					'country_en'	=> 'Sri Lanka',
					'country_fr'	=> 'Sri Lanka'],
				[
					'code_iso'		=> 'lr',
					'country_en'	=> 'Liberia',
					'country_fr'	=> 'Libéria'],
				[
					'code_iso'		=> 'ls',
					'country_en'	=> 'Lesotho',
					'country_fr'	=> 'Lesotho'],
				[
					'code_iso'		=> 'lt',
					'country_en'	=> 'Lithuania',
					'country_fr'	=> 'Lithuanie'],
				[
					'code_iso'		=> 'lu',
					'country_en'	=> 'Luxembourg',
					'country_fr'	=> 'Luxembourg'],
				[
					'code_iso'		=> 'lv',
					'country_en'	=> 'Latvia',
					'country_fr'	=> 'Lettonie'],
				[
					'code_iso'		=> 'ly',
					'country_en'	=> 'Libyan Arab Jamahiriya',
					'country_fr'	=> 'Jamahiriya Arabe Libyenne'],
				[
					'code_iso'		=> 'ma',
					'country_en'	=> 'Morocco',
					'country_fr'	=> 'Maroc'],
				[
					'code_iso'		=> 'mc',
					'country_en'	=> 'Monaco',
					'country_fr'	=> 'Monaco'],
				[
					'code_iso'		=> 'md',
					'country_en'	=> 'Moldova',
					'country_fr'	=> 'Moldavie'],
				[
					'code_iso'		=> 'me',
					'country_en'	=> 'Montenegro',
					'country_fr'	=> 'Monténégro'],
				[
					'code_iso'		=> 'mg',
					'country_en'	=> 'Madagascar',
					'country_fr'	=> 'Madagascar'],
				[
					'code_iso'		=> 'mh',
					'country_en'	=> 'Marshall Island',
					'country_fr'	=> 'Marshall Îles'],
				[
					'code_iso'		=> 'mk',
					'country_en'	=> 'Macedonia',
					'country_fr'	=> 'Macédoine'],
				[
					'code_iso'		=> 'ml',
					'country_en'	=> 'Mali',
					'country_fr'	=> 'Mali'],
				[
					'code_iso'		=> 'mm',
					'country_en'	=> 'Myanmar',
					'country_fr'	=> 'Birmanie'],
				[
					'code_iso'		=> 'mn',
					'country_en'	=> 'Mongolia',
					'country_fr'	=> 'Mongolie'],
				[
					'code_iso'		=> 'mo',
					'country_en'	=> 'Macao',
					'country_fr'	=> 'Macao'],
				[
					'code_iso'		=> 'mp',
					'country_en'	=> 'Northern Mariana Islands',
					'country_fr'	=> 'Mariannes du Nord Îles'],
				[
					'code_iso'		=> 'mq',
					'country_en'	=> 'Martinique',
					'country_fr'	=> 'Martinique'],
				[
					'code_iso'		=> 'mr',
					'country_en'	=> 'Mauritania',
					'country_fr'	=> 'Mauritanie'],
				[
					'code_iso'		=> 'ms',
					'country_en'	=> 'Montserrat',
					'country_fr'	=> 'Montserrat'],
				[
					'code_iso'		=> 'mt',
					'country_en'	=> 'Malta',
					'country_fr'	=> 'Malte'],
				[
					'code_iso'		=> 'mu',
					'country_en'	=> 'Mauritius',
					'country_fr'	=> 'Maurice Île'],
				[
					'code_iso'		=> 'mv',
					'country_en'	=> 'Maldives',
					'country_fr'	=> 'Maldives Îles'],
				[
					'code_iso'		=> 'mw',
					'country_en'	=> 'Malawi',
					'country_fr'	=> 'Malawi'],
				[
					'code_iso'		=> 'mx',
					'country_en'	=> 'Mexico',
					'country_fr'	=> 'Mexique'],
				[
					'code_iso'		=> 'my',
					'country_en'	=> 'Malaysia',
					'country_fr'	=> 'Malaisie'],
				[
					'code_iso'		=> 'mz',
					'country_en'	=> 'Mozambique',
					'country_fr'	=> 'Mozambique'],
				[
					'code_iso'		=> 'na',
					'country_en'	=> 'Namibia',
					'country_fr'	=> 'Namibie'],
				[
					'code_iso'		=> 'nc',
					'country_en'	=> 'New Caledonia',
					'country_fr'	=> 'Nouvelle Calédonie'],
				[
					'code_iso'		=> 'ne',
					'country_en'	=> 'Niger',
					'country_fr'	=> 'Niger'],
				[
					'code_iso'		=> 'nf',
					'country_en'	=> 'Norfolk Island',
					'country_fr'	=> 'Norfolk Île'],
				[
					'code_iso'		=> 'ng',
					'country_en'	=> 'Nigeria',
					'country_fr'	=> 'Nigeria'],
				[
					'code_iso'		=> 'ni',
					'country_en'	=> 'Nicaragua',
					'country_fr'	=> 'Nicaragua'],
				[
					'code_iso'		=> 'nl',
					'country_en'	=> 'Netherlands',
					'country_fr'	=> 'Pays Bas'],
				[
					'code_iso'		=> 'no',
					'country_en'	=> 'Norway',
					'country_fr'	=> 'Norvège'],
				[
					'code_iso'		=> 'np',
					'country_en'	=> 'Nepal',
					'country_fr'	=> 'Nepal'],
				[
					'code_iso'		=> 'nr',
					'country_en'	=> 'Nauru Republic of',
					'country_fr'	=> 'Nauru République de'],
				[
					'code_iso'		=> 'nu',
					'country_en'	=> 'Niue Republic of',
					'country_fr'	=> 'Niue République de'],
				[
					'code_iso'		=> 'nz',
					'country_en'	=> 'New Zealand',
					'country_fr'	=> 'Nouvelle Zélande'],
				[
					'code_iso'		=> 'om',
					'country_en'	=> 'Oman',
					'country_fr'	=> 'Oman'],
				[
					'code_iso'		=> 'pa',
					'country_en'	=> 'Panama',
					'country_fr'	=> 'Panama'],
				[
					'code_iso'		=> 'pe',
					'country_en'	=> 'Peru',
					'country_fr'	=> 'Pérou'],
				[
					'code_iso'		=> 'pf',
					'country_en'	=> 'French Polynesia',
					'country_fr'	=> 'Polynésie Française'],
				[
					'code_iso'		=> 'pg',
					'country_en'	=> 'Papua New Guinea',
					'country_fr'	=> 'Papousie Nouvelle Guinée'],
				[
					'code_iso'		=> 'ph',
					'country_en'	=> 'Philippines',
					'country_fr'	=> 'Philippines'],
				[
					'code_iso'		=> 'pk',
					'country_en'	=> 'Pakistan',
					'country_fr'	=> 'Pakistan'],
				[
					'code_iso'		=> 'pl',
					'country_en'	=> 'Poland',
					'country_fr'	=> 'Pologne'],
				[
					'code_iso'		=> 'pm',
					'country_en'	=> 'Saint Pierre and Miquelon',
					'country_fr'	=> 'Saint Pierre et Miquelon'],
				[
					'code_iso'		=> 'pn',
					'country_en'	=> 'Pitcairn',
					'country_fr'	=> 'Pitcairn Îles'],
				[
					'code_iso'		=> 'pr',
					'country_en'	=> 'Puerto Rico',
					'country_fr'	=> 'Porto Rico'],
				[
					'code_iso'		=> 'ps',
					'country_en'	=> 'Palestine',
					'country_fr'	=> 'Palestine'],
				[
					'code_iso'		=> 'pt',
					'country_en'	=> 'Portugal',
					'country_fr'	=> 'Portugal'],
				[
					'code_iso'		=> 'pw',
					'country_en'	=> 'Palau Republic of',
					'country_fr'	=> 'Palau République de'],
				[
					'code_iso'		=> 'py',
					'country_en'	=> 'Paraguay',
					'country_fr'	=> 'Paraguay'],
				[
					'code_iso'		=> 'qa',
					'country_en'	=> 'Qatar',
					'country_fr'	=> 'Qatar'],
				[
					'code_iso'		=> 're',
					'country_en'	=> 'Reunion',
					'country_fr'	=> 'Réunion'],
				[
					'code_iso'		=> 'ro',
					'country_en'	=> 'Romania',
					'country_fr'	=> 'Roumanie'],
				[
					'code_iso'		=> 'rs',
					'country_en'	=> 'Serbia',
					'country_fr'	=> 'Serbie'],
				[
					'code_iso'		=> 'ru',
					'country_en'	=> 'Russia',
					'country_fr'	=> 'Russie'],
				[
					'code_iso'		=> 'rw',
					'country_en'	=> 'Rwanda',
					'country_fr'	=> 'Rwanda'],
				[
					'code_iso'		=> 'sa',
					'country_en'	=> 'Saudi Arabia',
					'country_fr'	=> 'Arabie Saoudite'],
				[
					'code_iso'		=> 'sb',
					'country_en'	=> 'Slomon Islands',
					'country_fr'	=> 'Salomon Îles'],
				[
					'code_iso'		=> 'sc',
					'country_en'	=> 'Seychelles',
					'country_fr'	=> 'Seychelles'],
				[
					'code_iso'		=> 'sd',
					'country_en'	=> 'Sudan',
					'country_fr'	=> 'Soudan'],
				[
					'code_iso'		=> 'se',
					'country_en'	=> 'Sweden',
					'country_fr'	=> 'Suède'],
				[
					'code_iso'		=> 'sg',
					'country_en'	=> 'Singapore',
					'country_fr'	=> 'Singapour'],
				[
					'code_iso'		=> 'sh',
					'country_en'	=> 'Saint Helena',
					'country_fr'	=> 'Sainte Hélène'],
				[
					'code_iso'		=> 'si',
					'country_en'	=> 'Slovenia',
					'country_fr'	=> 'Slovénie'],
				[
					'code_iso'		=> 'sj',
					'country_en'	=> 'Svalbard and Jan Mayen Islands',
					'country_fr'	=> 'Svalbard et Jan Mayen Îles'],
				[
					'code_iso'		=> 'sk',
					'country_en'	=> 'Slovakia',
					'country_fr'	=> 'Slovaquie'],
				[
					'code_iso'		=> 'sl',
					'country_en'	=> 'Sierra Leone',
					'country_fr'	=> 'Sierra Leone'],
				[
					'code_iso'		=> 'sm',
					'country_en'	=> 'San Marino',
					'country_fr'	=> 'Saint Marin'],
				[
					'code_iso'		=> 'sn',
					'country_en'	=> 'Senegal',
					'country_fr'	=> 'Sénégal'],
				[
					'code_iso'		=> 'so',
					'country_en'	=> 'Somalia',
					'country_fr'	=> 'Somalie'],
				[
					'code_iso'		=> 'sr',
					'country_en'	=> 'Suriname',
					'country_fr'	=> 'Suriname'],
				[
					'code_iso'		=> 'st',
					'country_en'	=> 'Sao Tome and Principe',
					'country_fr'	=> 'Sao Tomé et Principe'],
				[
					'code_iso'		=> 'sv',
					'country_en'	=> 'El Salvador',
					'country_fr'	=> 'El Salvador'],
				[
					'code_iso'		=> 'sy',
					'country_en'	=> 'Syria',
					'country_fr'	=> 'Syrie'],
				[
					'code_iso'		=> 'sz',
					'country_en'	=> 'Swaziland',
					'country_fr'	=> 'Swaziland'],
				[
					'code_iso'		=> 'ta',
					'country_en'	=> 'Tristan da Cunha',
					'country_fr'	=> 'Tristan da Cunha'],
				[
					'code_iso'		=> 'tc',
					'country_en'	=> 'Turks and Caicos Islands',
					'country_fr'	=> 'Turks et Caïques Îles'],
				[
					'code_iso'		=> 'td',
					'country_en'	=> 'Chad',
					'country_fr'	=> 'Tchad'],
				[
					'code_iso'		=> 'tf',
					'country_en'	=> 'French Southern Territories',
					'country_fr'	=> 'Terres Australes et Antartiques Françaises'],
				[
					'code_iso'		=> 'tg',
					'country_en'	=> 'Togo',
					'country_fr'	=> 'Togo'],
				[
					'code_iso'		=> 'th',
					'country_en'	=> 'Thailand',
					'country_fr'	=> 'Thaïlande'],
				[
					'code_iso'		=> 'tj',
					'country_en'	=> 'Tajikistan',
					'country_fr'	=> 'Tadjikistan'],
				[
					'code_iso'		=> 'tk',
					'country_en'	=> 'Tokelau',
					'country_fr'	=> 'Tokelau'],
				[
					'code_iso'		=> 'tl',
					'country_en'	=> 'Timor-Leste',
					'country_fr'	=> 'Timor est'],
				[
					'code_iso'		=> 'tm',
					'country_en'	=> 'Turkmenistan',
					'country_fr'	=> 'Turkménistan'],
				[
					'code_iso'		=> 'tn',
					'country_en'	=> 'Tunisia',
					'country_fr'	=> 'Tunisie'],
				[
					'code_iso'		=> 'to',
					'country_en'	=> 'Tonga',
					'country_fr'	=> 'Tonga Îles'],
				[
					'code_iso'		=> 'tr',
					'country_en'	=> 'Turkey',
					'country_fr'	=> 'Turquie'],
				[
					'code_iso'		=> 'tt',
					'country_en'	=> 'Trinidad and Tobago',
					'country_fr'	=> 'Trinidad et Tobago'],
				[
					'code_iso'		=> 'tv',
					'country_en'	=> 'Tuvalu',
					'country_fr'	=> 'Tuvalu'],
				[
					'code_iso'		=> 'tw',
					'country_en'	=> 'Taiwan',
					'country_fr'	=> 'Taiwan'],
				[
					'code_iso'		=> 'tz',
					'country_en'	=> 'Tanzania',
					'country_fr'	=> 'Tanzanie'],
				[
					'code_iso'		=> 'ua',
					'country_en'	=> 'Ukraine',
					'country_fr'	=> 'Ukraine'],
				[
					'code_iso'		=> 'ug',
					'country_en'	=> 'Uganda',
					'country_fr'	=> 'Ouganda'],
				[
					'code_iso'		=> 'uk',
					'country_en'	=> 'United Kingdom',
					'country_fr'	=> 'Royaume Uni'],
				[
					'code_iso'		=> 'um',
					'country_en'	=> 'United States Minor Outlying Islands',
					'country_fr'	=> 'Mineures Éloignées des États-Unis Îles'],
				[
					'code_iso'		=> 'us',
					'country_en'	=> 'United States of America',
					'country_fr'	=> 'Etats-Unis d’Amérique'],
				[
					'code_iso'		=> 'uy',
					'country_en'	=> 'Uruguay',
					'country_fr'	=> 'Uruguay'],
				[
					'code_iso'		=> 'uz',
					'country_en'	=> 'Uzbekistan',
					'country_fr'	=> 'Ouzbekistan'],
				[
					'code_iso'		=> 'va',
					'country_en'	=> 'Holy See (Vatican City State)',
					'country_fr'	=> 'Vatican'],
				[
					'code_iso'		=> 'vc',
					'country_en'	=> 'Saint Vincent and the Grenadines',
					'country_fr'	=> 'Saint-Vincent et les Grenadines'],
				[
					'code_iso'		=> 've',
					'country_en'	=> 'Venezuela',
					'country_fr'	=> 'Vénézuéla'],
				[
					'code_iso'		=> 'vg',
					'country_en'	=> 'Virgin Islands (British)',
					'country_fr'	=> 'Vierges britanniques Îles'],
				[
					'code_iso'		=> 'vi',
					'country_en'	=> 'Virgin Islands (US)',
					'country_fr'	=> 'Vierges Américaines Îles'],
				[
					'code_iso'		=> 'vn',
					'country_en'	=> 'Vietnam',
					'country_fr'	=> 'Viêtnam'],
				[
					'code_iso'		=> 'vu',
					'country_en'	=> 'Vanuatu',
					'country_fr'	=> 'Vanuatu'],
				[
					'code_iso'		=> 'wf',
					'country_en'	=> 'Wallis and Futuna',
					'country_fr'	=> 'Wallis et Futuna'],
				[
					'code_iso'		=> 'ws',
					'country_en'	=> 'Samoa',
					'country_fr'	=> 'Samoa'],
				[
					'code_iso'		=> 'ye',
					'country_en'	=> 'Yemen',
					'country_fr'	=> 'Yémen'],
				[
					'code_iso'		=> 'yt',
					'country_en'	=> 'Mayotte',
					'country_fr'	=> 'Mayotte'],
				[
					'code_iso'		=> 'za',
					'country_en'	=> 'South Africa',
					'country_fr'	=> 'Afrique du Sud'],
				[
					'code_iso'		=> 'zm',
					'country_en'	=> 'Zambia',
					'country_fr'	=> 'Zambie'],
				[
					'code_iso'		=> 'zw',
					'country_en'	=> 'Zimbabwe',
					'country_fr'	=> 'Zimbabwé'],
			];

			$this->db->sql_multi_insert($this->table_prefix . 'countryflag', $sql_ary);
		}
	}
}
