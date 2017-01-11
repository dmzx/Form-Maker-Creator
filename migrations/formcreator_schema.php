<?php
/**
*
* @package phpBB Extension - Form Maker/Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbreland.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\formcreator\migrations;

class formcreator_schema extends \phpbb\db\migration\migration
{
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'form_maker'	=> array(
					'COLUMNS'	=> array(
						'id'				=> array('UINT', null, 'auto_increment'),
						'form_id'			=> array('UINT', '0'),
						'ndx_order'			=> array('UINT', '0'),
						'name'				=> array('VCHAR', ''),
						'type'				=> array('VCHAR', ''),
						'hint'				=> array('VCHAR', ''),
						'options'			=> array('VCHAR', ''),
						'mandatory'			=> array('BOOL', '0'),
					),
					'PRIMARY_KEY'	=> 'id',
				),
			),
		);
	}

	public function revert_schema()
	{
		return 	array(
			'drop_tables' => array(
				$this->table_prefix . 'form_maker',
			),
		);
	}
}
