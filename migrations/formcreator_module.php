<?php
/**
*
* @package phpBB Extension - Form Maker/Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbreland.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\formcreator\migrations;

class formcreator_module extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_FORM_MAKER')),
			array('module.add', array(
			'acp', 'ACP_FORM_MAKER', array(
					'module_basename'	=> '\dmzx\formcreator\acp\formcreator_module', 'modes' => array('manage'),
				),
			)),
		);
	}
}
