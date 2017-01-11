<?php
/**
*
* @package phpBB Extension - Form Maker/Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbreland.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\formcreator\acp;

class formcreator_info
{
	function module()
	{
		return array(
			'filename'	=> '\dmzx\formcreator\acp\formcreator_module',
			'title'		=> 'ACP_FORM_MAKER',
			'modes'		=> array(
				'manage' 	=> array('title' => 'ACP_FORM_MAKER_CONFIG', 'auth'	=> 'ext_dmzx/formcreator && acl_a_form_maker', 'cat' => array('ACP_FORM_MAKER')
			)),
		);
	}
}
