<?php
/**
*
* @package phpBB Extension - Form Maker/Creator
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbreland.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\formcreator\controller;

class admin_controller
{
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $table_formcreator;

	/**
	* Constructor
	*
	* @param \phpbb\user						$user
	* @param \phpbb\template\template			$template
	* @param \phpbb\db\driver\driver_interface	$db
	* @param \phpbb\request\request		 		$request
	* @param string								$root_path
	* @param string								$php_ext
	* @param string								$table_formcreator
	*
	*/
	public function __construct(
		\phpbb\user $user,
		\phpbb\template\template $template,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\request\request $request,
		$root_path,
		$php_ext,
		$table_formcreator)
	{
		$this->user					= $user;
		$this->template				= $template;
		$this->db					= $db;
		$this->request 				= $request;
		$this->root_path 			= $root_path;
		$this->php_ext 				= $php_ext;
		$this->table_formcreator 	= $table_formcreator;
	}

	public function display_options()
	{
		$this->user->add_lang_ext('dmzx/formcreator', 'formcreator_acp');

		$first_forum_id = 0;

		$form_key = md5(uniqid(rand(), true));
		add_form_key($form_key);

		$mode = $this->request->variable('mode', 'manage');
		$fname = $link = '';
		$elements = 0;

		if ($first_forum_id == 0)
		{
			$first_forum_id = $this->get_first_forum_id();
		}

		$form_id = (int) $this->request->variable('form_id', $first_forum_id);
		$id = $this->request->variable('id', 0);

		$fname = $this->get_forums($form_id);

		$link 		= '<br /><a href="' . append_sid("index.$this->php_ext", "i=form_maker&amp;mode=manage") . '">' . $this->user->lang['FORM_MAKER_ACP_RETURN'] . '</a>';
		$update 	= $this->request->is_set_post('update');
		$addnew 	= $this->request->is_set_post('add');
		$move_up 	= $this->request->variable('move_up', '');
		$move_down 	= $this->request->variable('move_down', '');
		$delete 	= $this->request->variable('delete', '');

		if ($update)
		{
			// ignore the rest if updating //
			$addnew = $move_down = $move_up = $delete = 0;
		}

		if ($move_down || $move_up)
		{
			$form_id = $this->request->variable('form_id', 0);
			$id = $this->request->variable('id', 0);

			$sql = 'SELECT ndx_order
				FROM ' . $this->table_formcreator . '
				WHERE id =	' . $id . '
				AND form_id = ' . $form_id;
			$result = $this->db->sql_query($sql);
			$current_order = (int) $this->db->sql_fetchfield('ndx_order', 0, $result);
			$this->db->sql_freeresult($result);

			if ($move_down)
			{
				$new_order = $current_order + 1;
			}
			else
			{
				$new_order = ($current_order > 1) ? $current_order - 1 : 1;
			}

			// find current id with new order and move that one notch, if any
			$sql = 'UPDATE	' . $this->table_formcreator . '
				SET ndx_order = ' . $current_order . '
				WHERE ndx_order = ' . $new_order . '
				AND form_id = ' . $form_id;
			$this->db->sql_query($sql);

			// now increase old order
			$sql = 'UPDATE	' . $this->table_formcreator . '
				SET ndx_order = ' . $new_order . '
				WHERE id = ' . $id . '
				AND form_id = ' . $form_id;
			$this->db->sql_query($sql);

			$move_down = $move_up = false;
		}

		if ($delete)
		{
			$sql = 'DELETE FROM ' . $this->table_formcreator . '
				WHERE id = ' . $id;
			$this->db->sql_query($sql);

			$form_id = $this->request->variable('form_id', 0);
		}

		//user pressed update contents
		if ($update)
		{
			$q_types		= $this->request->variable('q_type', array(0 => ''), true);
			$q_names		= $this->request->variable('q_name', array(0 => ''), true);
			$q_hint			= $this->request->variable('q_hint', array(0 => ''), true);
			$q_options		= $this->request->variable('q_options', array(0 => ''), true);
			$form_id		= $this->request->variable('form_id', 1);
			$q_ndx_order	= $this->request->variable('q_ndx_order', array(0 => ''), true);
			$post 			= $this->request->get_super_global(\phpbb\request\request::POST);

			foreach ($q_hint as $key => $form_values)
			{
				$data = array('mandatory' => isset($post['q_mandatory'][$key]) ? '1' : '0');

				$sql = 'UPDATE ' . $this->table_formcreator . '
					SET ' . $this->db->sql_build_array('UPDATE', $data) . '
					WHERE id = ' . $key;
				$this->db->sql_query($sql);

				// updating contents //
				$data = array(
					'type'		=> $q_types[$key] ,
					'name'		=> $q_names[$key] ,
					'hint'		=> $q_hint[$key] ,
					'options'	=> $q_options[$key],
					'ndx_order' => $q_ndx_order[$key]
				);

				$sql = 'UPDATE ' . $this->table_formcreator . '
					SET ' . $this->db->sql_build_array('UPDATE', $data) . '
					WHERE id = ' . $key . '
					AND form_id = ' . $form_id;
				$this->db->sql_query($sql);
			}

			$this->template->assign_var('L_FORM_NO_FORM', sprintf($this->user->lang['FORM_NO_FORM'], $fname));
		}

		if ($addnew)
		{
			$form_id = $this->request->variable('form_id', 0);

			$sql = 'SELECT max(ndx_order) + 1 as maxorder
				FROM ' . $this->table_formcreator . '
				WHERE form_id = ' . $form_id;
			$result = $this->db->sql_query($sql);

			$max_order = (int) $this->db->sql_fetchfield('maxorder', 0, $result);
			$this->db->sql_freeresult($result);

			$sql_ary = array(
				'ndx_order' => ($max_order > 0) ? $max_order : 1, // we don't use index 0 //
				'form_id'	=> $form_id,
				'name'		=> $this->request->variable('name', ' ', true),
				'hint'		=> $this->request->variable('hint', ' ', true),
				'options'	=> $this->request->variable('options', ' ', true),
				'type'		=> $this->request->variable('add_type', ' ', true),
				'mandatory' => ($this->request->is_set_post('mandatory') ? '1' : '0')
			);

			// insert new contents
			$sql = 'INSERT INTO ' . $this->table_formcreator . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$result = $this->db->sql_query($sql);

			if (!$result)
			{
				trigger_error($this->user->lang['FORM_MAKER_ACP_QUESTNOTADD'] . $link, E_USER_WARNING);
			}
		}

		// main sql //
		$sql = 'SELECT id, form_id, ndx_order, name, hint, type, mandatory, options, forum_name, forum_id
			FROM ' . $this->table_formcreator . ' m, ' . FORUMS_TABLE . " f
			WHERE m.form_id = $form_id
				AND m.form_id = f.forum_id
			ORDER BY ndx_order ASC";
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$disabled = '';
			$checked = '';

			if ($row['mandatory'])
			{
				$checked = 'checked="checked"';
			}

			$this->template->assign_block_vars('form_template', array(
				'FID'			=> $row['form_id'],
				'NDX_ORDER'		=> $row['ndx_order'] ,
				'NAME'			=> $row['name'],
				'TYPE'			=> $row['type'],
				'HINT'			=> $row['hint'],
				'MANDATORY'		=> $row['mandatory'] ,
				'OPTIONS'		=> $row['options'] ,
				'CHECKED'		=> $checked ,
				'ID'			=> $row['id'] ,
				'U_DELETE' 		=> append_sid($this->root_path . 'adm/index.' . $this->php_ext . '?sid=' . $this->user->session_id, "i=-dmzx-formcreator-acp-formcreator_module&mode=manage&amp;delete=1&amp;id={$row['id']}&amp;form_id={$row['form_id']}"),
				'U_MOVE_UP' 	=> append_sid($this->root_path . 'adm/index.' . $this->php_ext . '?sid=' . $this->user->session_id, "i=-dmzx-formcreator-acp-formcreator_module&mode=manage&amp;move_up=1&amp;id={$row['id']}&amp;form_id={$row['form_id']}") ,
				'U_MOVE_DOWN' 	=> append_sid($this->root_path . 'adm/index.' . $this->php_ext . '?sid=' . $this->user->session_id, "i=-dmzx-formcreator-acp-formcreator_module&mode=manage&amp;move_down=1&amp;id={$row['id']}&amp;form_id={$row['form_id']}")));

			$type = array(
				'text' ,
				'textbox' ,
				'selectbox' ,
				'radiobuttons' ,
				'checkbox',
				'password',
				'email',
				'url',
				'file'
			);

			foreach ($type as $t_name => $t_value)
			{
				$this->template->assign_block_vars('form_template.template_type', array(
					'TYPE'		=> $t_value,
					'SELECTED'	=> ($t_value == $row['type']) ? ' selected="selected"' : '' ,
					'DISABLED'	=> $disabled
				));
				$elements++;
			}
		}

		$this->template->assign_vars(array(
			'FID'			 => $form_id,
			'ELEMENTS'		=> $elements,
			'L_FORM_NO_FORM'	=> sprintf($this->user->lang['FORM_NO_FORM'], $fname),
		));

		$this->db->sql_freeresult($result);

		$this->template->assign_vars(array(
			'REPORT'	=> $this->user->lang['MODE'] . ' = [' . $mode . '] | ' . $this->user->lang['ELEMENTS'] . ' = [' . $elements . '] | ' . $this->user->lang['FORUM_ID'] . ' = [' . $form_id . '] | ' . $this->user->lang['FORM_NAME'] . ' = [' . $fname . ']',
			'LINK'	=> $link,
		));

		$this->build_preview($form_id, $form_id);
	}

	function get_forums($form_id)
	{
		$store = '';

		$sql = 'SELECT forum_id, forum_name
			FROM ' . FORUMS_TABLE . '
			WHERE forum_type = ' . FORUM_POST . '
			ORDER BY forum_id ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('forms', array(
				'FORUM_ID'	=> $row['forum_id'],
				'FORUM_NAME' => $row['forum_name'],
				'SELECT'	 => ($row['forum_id'] == $form_id) ? ' selected="selected"' : '',
			));

			if ($form_id == $row['forum_id'])
			{
				$store = $row['forum_name'];
			}
		}
		$this->db->sql_freeresult($result);

		return($store);
	}

	function get_first_forum_id()
	{
		$sql = 'SELECT forum_id
			FROM '. FORUMS_TABLE . '
			WHERE forum_type = ' . FORUM_POST . '
			ORDER BY forum_id ASC';
		$result = $this->db->sql_query($sql, 1);
		$row = $this->db->sql_fetchfield('forum_id');
		$this->db->sql_freeresult($result);

		return($row);
	}

	function build_preview($form_id, $form_id)
	{
		$sql = 'SELECT id, form_id, ndx_order, name, hint, type, mandatory, options, forum_name, forum_id
			FROM ' . $this->table_formcreator . ' m, ' . FORUMS_TABLE . " f
			WHERE m.form_id = $form_id
				AND m.form_id = f.forum_id
			ORDER BY ndx_order ASC";
		$result = $this->db->sql_query($sql);

		$file_count = -1;

		while ($row = $this->db->sql_fetchrow($result))
		{

			if ($row['type'] == 'file')
			{
				$file_count++;
			}

			switch (strtolower($row['type']))
			{
				case 'email':
				case 'password':
				case 'url':
				case 'text':
				case 'file':
					$type = '<input style="border-radius: 5px; width:300px" class="text" type="' . $row['type']. '" name="templatefield_' . $row['name'] . $file_count . '" placeholder="' . $row['hint'] . '" size="40" maxlength="255" tabindex="' . $row['ndx_order'] . '" />';
				break;

				case 'textbox':
					$type = '<textarea style="border-radius: 5px;" class="text" name="templatefield_' . $row['name'] . '" rows="3" cols="76" tabindex="' . $row['ndx_order'] . '" onselect="storeCaret(this);" onclick="storeCaret(this);" placeholder="' . $row['hint'] . '" onkeyup="storeCaret(this);"></textarea>';
				break;
				case 'selectbox':
					$type = '<select style="border-radius: 5px;" class="inputbox" name="templatefield_' . $row['name'] . '" tabindex="' . $row['ndx_order'] . '">';
					$type .= '<option value="">----------------</option>';
					$select_option = explode(',', $row['options']);
					foreach ($select_option as $value)
					{
						$type .='<option value="'. $value .'">'. $value .'</option>';
					}
					$type .= '</select>';
				break;
				case 'radiobuttons':
					$radio_option = explode(',', $row['options']);

					$type = '';
					foreach ($radio_option as $value)
					{
						$type .='<input type="radio" name="templatefield_'. $row['name'] .'" value="'. $value . '" />&nbsp;'. $value .'&nbsp;&nbsp;';
					}
				break;
				case 'checkbox':
					$check_option = explode(',', $row['options']);

					$type = '';
					foreach ($check_option as $value)
					{
						$type .='<input type="checkbox" name="templatefield_'. $row['name'].'[]" value="'. $value .'" />&nbsp;'. $value .'&nbsp;&nbsp;';
					}
				break;
			}

			$mandatory = '';

			if ($row['mandatory'] == '1')
			{
				$mandatory = '<span class="mandatory">*</span>';
			}
			$this->template->assign_block_vars('form_apptemplate', array(
				'NDX_ORDER' => $row['ndx_order'],
				'NAME'		=> $row['name'],
				'HINT'		=> $row['hint'],
				'OPTIONS'	=> $row['options'],
				'TYPE'		=> (isset($type)) ? $type : '',
				'MANDATORY' => $mandatory)
			);

		}
		$this->db->sql_freeresult($result);
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
