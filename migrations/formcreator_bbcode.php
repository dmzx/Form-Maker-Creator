<?php
/**
*
* @package phpBB Extension - Form Maker/Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbreland.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\formcreator\migrations;

class formcreator_bbcode extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'install_formcreators'))),
		);
	}

	public function revert_data()
	{
		return array(
			array('custom', array(array(&$this, 'formcreators_behind'))),
		);
	}

	public function formcreators_behind($bbcode_tags)
	{
		$bbcode_tags = array('att', 'fbox', 'form');

		$sql = 'UPDATE ' . BBCODES_TABLE . '
			SET display_on_posting = 0
			WHERE ' . $this->db->sql_in_set('bbcode_tag', $bbcode_tags);
		$this->db->sql_query($sql);
	}

	public function install_formcreators($bbcode_data)
	{
		if (!class_exists('acp_bbcodes'))
		{
			include($this->phpbb_root_path . 'includes/acp/acp_bbcodes.' . $this->php_ext);
		}

		$bbcode_tool = new \acp_bbcodes();

		$bbcode_data = array(
			'att' => array(
				'bbcode_match'		=> '[att]{TEXT}[/att]',
				'bbcode_tpl'		=> '<div class="att">{TEXT}</div>',
				'bbcode_helpline'	=> '[att]{TEXT}[/att]',
				'display_on_posting'=> 0,
			),
			'fbox' => array(
				'bbcode_match'		=> '[fbox]{TEXT}[/fbox]',
				'bbcode_tpl'		=> '<div class="fbox">{TEXT}</div>',
				'bbcode_helpline'	=> '[fbox]{TEXT}[/fbox]',
				'display_on_posting'=> 0,
			),
			'form' => array(
				'bbcode_match'		=> '[form]{TEXT}[/form]',
				'bbcode_tpl'		=> '<pre>{TEXT}</pre>',
				'bbcode_helpline'	=> '[form]{TEXT}[/form]',
				'display_on_posting'=> 0,
			),
		);

		foreach ($bbcode_data as $bbcode_name => $bbcode_array)
		{
			$data = $bbcode_tool->build_regexp($bbcode_array['bbcode_match'], $bbcode_array['bbcode_tpl'], $bbcode_array['bbcode_helpline']);

			$bbcode_array += array(
				'bbcode_tag'			=> $data['bbcode_tag'],
				'first_pass_match'		=> $data['first_pass_match'],
				'first_pass_replace'	=> $data['first_pass_replace'],
				'second_pass_match'		=> $data['second_pass_match'],
				'second_pass_replace'	=> $data['second_pass_replace']
			);

			$sql = 'SELECT bbcode_id
				FROM ' . BBCODES_TABLE . "
				WHERE LOWER(bbcode_tag) = '" . strtolower($bbcode_name) . "'
				OR LOWER(bbcode_tag) = '" . strtolower($bbcode_array['bbcode_tag']) . "'";
			$result = $this->db->sql_query($sql);
			$row_exists = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($row_exists)
			{
				$bbcode_id = $row_exists['bbcode_id'];

				$sql = 'UPDATE ' . BBCODES_TABLE . '
					SET ' . $this->db->sql_build_array('UPDATE', $bbcode_array) . '
					WHERE bbcode_id = ' . $bbcode_id;
				$this->db->sql_query($sql);
			}
			else
			{
				$sql = 'SELECT MAX(bbcode_id) AS max_bbcode_id
					FROM ' . BBCODES_TABLE;
				$result = $this->db->sql_query($sql);
				$max_bbcode_id = $this->db->sql_fetchfield('max_bbcode_id');
				$this->db->sql_freeresult($result);

				if ($max_bbcode_id)
				{
					$bbcode_id = $max_bbcode_id + 1;

					if ($bbcode_id <= NUM_CORE_BBCODES)
					{
						$bbcode_id = NUM_CORE_BBCODES + 1;
					}
				}
				else
				{
					$bbcode_id = NUM_CORE_BBCODES + 1;
				}

				if ($bbcode_id <= BBCODE_LIMIT)
				{
					$bbcode_array['bbcode_id'] = (int) $bbcode_id;
					$bbcode_array['display_on_posting'] = ((int) $bbcode_array['display_on_posting']);
					$this->db->sql_query('INSERT INTO ' . BBCODES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $bbcode_array));
				}
			}
		}
	}
}
