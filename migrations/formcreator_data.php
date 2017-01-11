<?php
/**
*
* @package phpBB Extension - Form Maker/Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbreland.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\formcreator\migrations;

class formcreator_data extends \phpbb\db\migration\migration
{
	var $ext_version = '1.0.0';

	public function update_data()
	{
		return array(

			// Add config
			array('config.add', array('formcreator_version', $this->ext_version)),
			array('config.add', array('form_maker_enabled', 1)),

			// Add permission
			array('permission.add', array('a_form_maker', true)),

			// Set permission
			array('permission.permission_set', array('ADMINISTRATORS', 'a_form_maker', 'group')),
		);
	}
}
