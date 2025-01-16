<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2025 Sylver35  https://breizhcode.com
 * @license		http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translator	Sylver35  https://breizhcode.com
 */

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_COUNTRYFLAG_MODULE'		=> 'Flags of countries',
	'ACP_COUNTRYFLAG_CONFIG'		=> 'Configuration',
	'COUNTRYFLAG_TITLE'				=> 'Country flags configuration',
	'COUNTRYFLAG_TITLE_EXPLAIN'		=> 'Adjust the settings of member’s flags',
	'COUNTRYFLAG_REQUIRE'			=> 'Require the flag of member',
	'COUNTRYFLAG_REQUIRE_EXPLAIN'	=> 'Require that users select their flag when registering.',
	'COUNTRYFLAG_MESSAGE'			=> 'Display a message',
	'COUNTRYFLAG_MESSAGE_EXPLAIN'	=> 'Show a message to registered members who do not have the country flag informed',
	'COUNTRYFLAG_REDIRECT'			=> 'Redirect automatically',
	'COUNTRYFLAG_REDIRECT_EXPLAIN'	=> 'Automatically redirect to the profile edit page registered members that do not have a country flag.',
	'COUNTRYFLAG_POSITION'			=> 'Position of the flags',
	'COUNTRYFLAG_POSITION_EXPLAIN'	=> 'Choose here where the flags should appear, before or after usernames',
	'COUNTRYFLAG_POSITION_EXP_2'	=> 'Note that all users can choose a particular setting in “Board preferences”',
	'COUNTRYFLAG_SELECT_DEFAULT'	=> 'Default setting selected',
	'COUNTRYFLAG_SELECT_BEFORE'		=> 'Before usernames',
	'COUNTRYFLAG_SELECT_AFTER'		=> 'After usernames',
	'COUNTRYFLAG_SEPARATE'			=> ' ', // Be careful : only non-breaking space here, don't touch
	'COUNTRYFLAG_CHGPROFILEINFO'	=> 'You do not have permission to edit your profile and therefore cannot enter your country.<br>Contact an administrator to fix this.',
	'COUNTRYFLAG_BEFORE'			=> 'before',
	'COUNTRYFLAG_AFTER'				=> 'after',
	'COUNTRYFLAG_ACTIVATE'			=> 'activate',
	'COUNTRYFLAG_DEACTIVATE'		=> 'deactivate',
	'COUNTRYFLAG_IMAGE'				=> 'Default country',
	'COUNTRYFLAG_IMAGE_EXPLAIN'		=> 'Choose the country that will be selected by default in the drop-down lists',
	'COUNTRYFLAG_WIDTH'				=> 'Width of the flags',
	'COUNTRYFLAG_WIDTH_EXPLAIN'		=> 'Indicate here in pixels the width of the flags that are displayed next to the usernames.',
	'COUNTRYFLAG_WIDTH_ANIM'		=> 'Width of floating flags',
	'COUNTRYFLAG_WIDTH_ANIM_EXPLAIN'=> 'Indicate here in pixels the width of floating flags.',
	'COUNTRYFLAG_ANIM'				=> 'Floating flags in subjects',
	'COUNTRYFLAG_ANIM_EXPLAIN'		=> 'You can enable or disable the display of floating flags in subject messages.',
	'COUNTRYFLAG_ANIM_PRIV'			=> 'Flags floating in private messages',
	'COUNTRYFLAG_ANIM_PRIV_EXPLAIN'	=> 'You can enable or disable the display of floating flags in private messaging.',
	'COUNTRYFLAG_ANIM_USER'			=> 'Floating flags in profiles',
	'COUNTRYFLAG_ANIM_USER_EXPLAIN'	=> 'You can enable or disable the display of floating flags in the profile view of members.',
	'COUNTRYFLAG_SORT_FLAG'			=> 'Country flag',
	'COUNTRYFLAG'					=> 'Country',
	'USER_COUNTRYFLAG'				=> 'User country flag',
	'COUNTRY_ERROR'					=> 'You <b>must</b> select your country flag to continue!',
	'COUNTRY_ERROR_REGISTER'		=> 'You <b>must</b> select your country flag to complete your registration!',
	'COUNTRY_REDIRECT_MSG'			=> 'You did not fill in your country flag.<br/>Thank you for taking the time to fill it %sOn this page%s.',
	'COUNTRYFLAG_COPY'				=> '<a href="%1$s" onclick="window.open(this.href);return false;" title="Breizh Country Flag">Breizh Country Flag by Sylver35</a> » V %2$s',
	'LOG_CONFIG_COUNTRYFLAG'		=> '<strong>Changing the flags settings</strong><br/> » Update of the general configuration of the flags of countries',
));
