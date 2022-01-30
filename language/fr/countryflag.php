<?php
/**
 * @author		Sylver35 <webmaster@breizhcode.com>
 * @package		Breizh Country Flag Extension
 * @copyright	(c) 2019-2022 Sylver35  https://breizhcode.com
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
	'ACP_COUNTRYFLAG_MODULE'		=> 'Drapeaux des pays',
	'ACP_COUNTRYFLAG_CONFIG'		=> 'Configuration',
	'COUNTRYFLAG_TITLE'				=> 'Configuration des drapeaux des pays',
	'COUNTRYFLAG_TITLE_EXPLAIN'		=> 'Réglages des paramètres des drapeaux des membres',
	'COUNTRYFLAG_REQUIRE'			=> 'Exiger le drapeau du membre',
	'COUNTRYFLAG_REQUIRE_EXPLAIN'	=> 'Exiger que les utilisateurs sélectionnent leur drapeau lors de leur enregistrement.',
	'COUNTRYFLAG_MESSAGE'			=> 'Afficher un message',
	'COUNTRYFLAG_MESSAGE_EXPLAIN'	=> 'Afficher un message aux membres enregistrés n’ayant pas de drapeau du pays de renseigné',
	'COUNTRYFLAG_REDIRECT'			=> 'Rediriger automatiquement',
	'COUNTRYFLAG_REDIRECT_EXPLAIN'	=> 'Rediriger automatiquement vers la page de modification du profil les membres enregistrés n’ayant pas de drapeau du pays de renseigné',
	'COUNTRYFLAG_POSITION'			=> 'Position des drapeaux',
	'COUNTRYFLAG_POSITION_EXPLAIN'	=> 'Choisissez ici où les drapeaux doivent apparaître, avant ou après les noms d’utilisateurs',
	'COUNTRYFLAG_POSITION_EXP_2'	=> 'Notez que tous les utilisateurs peuvent choisir un réglage particulier dans les “Préférences du forum”',
	'COUNTRYFLAG_SELECT_DEFAULT'	=> 'Réglage sélectionné par défaut',
	'COUNTRYFLAG_SELECT_BEFORE'		=> 'Avant les noms d’utilisateurs',
	'COUNTRYFLAG_SELECT_AFTER'		=> 'Après les noms d’utilisateurs',
	'COUNTRYFLAG_SEPARATE'			=> ' ', // Be careful : only non-breaking space
	'COUNTRYFLAG_BEFORE'			=> 'avant',
	'COUNTRYFLAG_AFTER'				=> 'après',
	'COUNTRYFLAG_ACTIVATE'			=> 'activer',
	'COUNTRYFLAG_DEACTIVATE'		=> 'désactiver',
	'COUNTRYFLAG_IMAGE'				=> 'Pays par défaut',
	'COUNTRYFLAG_IMAGE_EXPLAIN'		=> 'Permet de choisir le pays qui sera sélectionné par défaut dans les listes déroulantes',
	'COUNTRYFLAG_WIDTH'				=> 'Largeur des drapeaux',
	'COUNTRYFLAG_WIDTH_EXPLAIN'		=> 'Indiquez ici en pixels la largeur des drapeaux qui sont affichés à coté des noms d’utilisateurs.',
	'COUNTRYFLAG_WIDTH_ANIM'		=> 'Largeur des drapeaux flottants',
	'COUNTRYFLAG_WIDTH_ANIM_EXPLAIN'=> 'Indiquez ici en pixels la largeur des drapeaux flottants.',
	'COUNTRYFLAG_ANIM'				=> 'Drapeaux flottants dans les sujets',
	'COUNTRYFLAG_ANIM_EXPLAIN'		=> 'Vous pouvez activer ou désactiver l’affichage des drapeaux flottants dans les messages des sujets.',
	'COUNTRYFLAG_ANIM_PRIV'			=> 'Drapeaux flottants dans les messages privés',
	'COUNTRYFLAG_ANIM_PRIV_EXPLAIN'	=> 'Vous pouvez activer ou désactiver l’affichage des drapeaux flottants dans la messagerie privée.',
	'COUNTRYFLAG_ANIM_USER'			=> 'Drapeaux flottants dans les profils',
	'COUNTRYFLAG_ANIM_USER_EXPLAIN'	=> 'Vous pouvez activer ou désactiver l’affichage des drapeaux flottants dans la vue des profils des membres.',
	'COUNTRYFLAG_SORT_FLAG'			=> 'Drapeau du pays',
	'COUNTRYFLAG'					=> 'Pays',
	'USER_COUNTRYFLAG'				=> 'Drapeau du pays de l’utilisateur',
	'COUNTRY_ERROR'					=> 'Vous <b>devez</b> sélectionner le drapeau de votre pays pour pouvoir continuer !',
	'COUNTRY_ERROR_REGISTER'		=> 'Vous <b>devez</b> sélectionner le drapeau de votre pays pour finaliser votre inscription !',
	'COUNTRY_REDIRECT_MSG'			=> 'Vous n’avez pas renseigné le drapeau de votre pays.<br />Merci de bien vouloir prendre le temps de le renseigner %sSur cette page%s. ',
	'COUNTRYFLAG_COPY'				=> '<a href="%1$s" onclick="window.open(this.href);return false;" title="Breizh Country Flag">Drapeaux des Pays par Sylver35</a> » V %2$s',
	'LOG_CONFIG_COUNTRYFLAG'		=> '<strong>Modification des paramètres des drapeaux</strong><br /> » Mise à jour de la configuration générale des drapeaux des pays',
));
