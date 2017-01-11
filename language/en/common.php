<?php
/**
*
* @package phpBB Extension - Form Maker/Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbreland.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
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
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'CLOSE_FORM'				=> 'Cancel',
	'OPEN_FORM'					=> 'Form Mode',
	'CLOSE_FORM_EXPLAIN'		=> 'Switch to Post Mode, copying Form data to the post',
	'CLOSE_FORM_EXPLAIN'		=> 'Switch back to Post Mode (data will not be posted)',
	'FORM_HELP_1'				=> 'Editing using <strong>Form Mode</strong> is not yet written...',
	'FORM_MOD_PREVIEW'		 	=> 'Switch to preview keeping the current form data...',
	'FORM_MOD_SUBMIT'			=> 'Add the form data to message and post...',
	'OPEN_FORM_EXPLAIN'			=> 'Switch to Form Mode...',
	'REFRESHING_FORM'			=> 'The current selected Forum is',
	'REQUIRED'				 	=> 'You have not entered all the required elements!',
	'SUBJECT_REQUIRED'		 	=> 'Please enter a subject',
	'CHECKBOX_MSG'				=> 'Checkboxes marked as Mandatory, require all elements to be checked (HTML5 Form Validation).',
	'MANDATORY'					=> 'Items marked with the asterisk are mandatory.',
));
