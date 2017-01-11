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
	'MODE'						=> 'Mode',
	'ELEMENTS'					=> 'Elements',
	'FORM_NAME'					=> 'Forum Name',
	'FORUM_ID'					=> 'Forum ID',
	'ACP_FORM_CURRENT'		 	=> 'Current Form',
	'ACP_FORM_MAKER'			=> 'Form Maker',
	'ACP_FORM_MAKER_EXPLAIN'	=> 'With this tool you can create and manage forms for your forum.',
	'ACP_FORM_CURRENT'		 	=> 'Current Form',
	'ACP_FORM_MAKER'			=> 'Form Maker',
	'ACP_FORM_MAKER_EXPLAIN'	=> 'With this tool you can create and manage forms for your forum.',
	'ACP_FORM_MOD_MORE_INFO'	=> 'Click Me for More Info.',
	'ACP_FORM_MOD_NOTE'			=> '<br /><strong>Note:</strong> All actions are performed on the currently selected/displayed form, no confirm is implemented...',
	'ACP_FORM_MOD_MORE_INFO'	=> 'Click Me for More Info.',
	'ACP_FORM_MOD_NOTE'			=> '<br /><strong>Note:</strong> All actions are performed on the currently selected/displayed form, no confirm is implemented...',

	'ACP_FORM_MAKER_EXPLAIN_2' => 'How do I change the form?<br /> &nbsp; &bull; Select a new form from the <strong><i>Current Form</i></strong> dropdown box...<br /><br />
	How do I add a new form element?<br /> &nbsp; &bull; Use <strong><i>Add a new form element</i></strong>.<br /><br />
	How do I delete a form?<br /> &nbsp; &bull; Simply delete all form elements...<br /><br />
	<strong>&#8730;</strong> The checkmark character indicated an item is mandatory and cannot be empty.<br />',

	'CURRENT_FORM'			 	=> 'Current Form',
	'FORM_ADD_ITEM'				=> 'Add a new form element',
	'FORM_CHECKBOX'				=> 'Check Box',
	'FORM_DETAILS'			 	=> 'All forms use a generic template file: styles/prosilver/template/forms/form_maker.html',
	'FORM_ELEMENT'			 	=> 'Input Type',
	'FORM_ELEMENT_TYPE'			=> 'Element type',
	'FORM_ELEMENT_HINT'			=> 'Hint',
	'FORM_ELEMENT_NAME'			=> 'Entry Name',
	'FORM_ELEMENT_OPTIONS'		=> 'Options',
	'FORM_EMAILBOX'				=> 'Email',
	'FORM_INPUTBOX'				=> 'Text',
	'FORM_MAKER_ACP_DELETED'	=> 'Entry deleted',
	'FORM_MAKER_ACP_ERROR'	 	=> 'Error updating form maker database',
	'FORM_MAKER_ACP_MOVED'	 	=> 'Move completed...',
	'FORM_MAKER_ACP_RETURN'		=> 'Back to manage forms',
	'FORM_MANAGE'				=> 'Manage this form',
	'FORM_MANAGE_EXPLAIN'		=> 'Here you can modify all of the current form elements, simply edit fields and press the <strong>Update</strong> button...',
	'FORUM_NAME'				=> 'Forum Name',

	'FORM_NEW_ITEM_EXPLAIN_2'	=> '<pre style="font-size:11px; line-height: 100%;"><strong><u>Form Elements supported by the Form Mod</u></strong><br />
	<strong>Inputbox:</strong>		Up to 255 characters)<br />
	<strong>Textbox:</strong>	 	Multiple lines of text arranged as 3 rows by 76 columns.<br />
	<strong>Checkbox:</strong>		One or more options can be selected, if set to mandatory, each and every option in the checkbox group must be checked.<br />
	<strong>Radiobutton:</strong> 		Only one option can be selected.<br />
	<strong>Selectbox:</strong>		One option from a dropdown list.<br />
	<strong>Email:</strong>			Valid email address.<br />
	<strong>Password:</strong>		For test only...<br />
	<strong>URL:</strong>			A valid URL must be entered.<br />
	<strong>Attachment:</strong>		Add an image.<br /><br /></pre>',

	'FORM_NO_FORM'			 	=> 'There are no forms assigned to: <strong>%s</strong>...<br />To add a new form to this forum, simply add a form element below...',
	'FORM_RADIOBOX'				=> 'Radio Buttons',
	'FORM_PASSWORDBOX'			=> 'Password',
	'FORM_SELECTBOX'			=> 'Select Box',
	'FORM_SELECT_DB'			=> 'Available forms',
	'FORM_STATUS'				=> 'Status',
	'FORM_TXTBOX'				=> 'Text Box',
	'FORM_URLBOX'				=> 'URL',
	'FORM_ATTACH'				=> 'Attachment',
	'HIDE_FORM_INFO'			=> 'Hide info',
	'HIDE_PREVIEW'			 	=> 'Hide Preview',
	'HOW_TO'					=> '<strong>Additional Help...</strong>',
	'HOW_TO_MORE'				=> 'More info...',
	'HOW_TO_HIDE'				=> '<strong>Hide</strong>',
	'FORM_IMAGE_HERE'			=> ' (replace this text with inline image) ',
	'MOREINFO_MSG'			 	=> 'To add an attachment, simply click on the Browse button(s) and select the image.',
	'NDX'						=> 'NDX',
	'NDX_ORDER'					=> 'Index order (the order in which items appear on the form)',
	'NO_FOURM'				 	=> 'No forum associated with this form',
	'FORMS_MOD_SAMPLE'		 	=> 'Rendering the current form to assist visualisation only... not a working form.',
	'SELECT_FORM_TO_MANAGE'		=> 'Please select a forum to associate with this form',
	'SHOW_FORM_INFO'			=> 'More info on Element types',
	'SHOW_PREVIEW'			 	=> 'Preview the form',

	'CHECKBOX_NOTE'				=> '<strong>Note:</strong>???',
	'CHECKBOXE_NOTES'			=> 'Checkboxes!',
	'CHKNOTE'					=> 'Checkboxes with multiple items are rarely set as mandatory as doing so, require the user checks each and every item.',
));
