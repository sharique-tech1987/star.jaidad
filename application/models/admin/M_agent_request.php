<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +923323103324
 * S: developer.adnan
 * @copyright 2014
 * @date 03-06-2014
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_agent_request extends CI_Model
{
    var $table = 'users';
    var $id_field = 'id';

    var $num_rows = 0;
    var $total_rows = 0;
    var $db_error = '';

    var $db_data = [];
    var $_id;

    function __construct()
    {
        $this->load->helper('cookie');

        parent::__construct();
        if (empty($this->table)) {
            $this->table = getUri(2);
        }
    }

    function validate($id = 0)
    {
        if ($id == 0) {
            $id = getUri(4);
            $row = $this->row($id);
        } else{
            $row = new stdClass();
            $row->social = '';
        }

        if (in_array(getUri(2), ['users'])) {
            $this->form_validation->set_rules('user_type_id', 'User Type', 'required');
        }

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|db_unique[users.email.id.' . $id . ']');
        if(empty($row->social)) {
            $this->form_validation->set_rules('username', 'Username', 'required|db_unique[users.username.id.' . $id . ']');
        }
        if ($id == 0) {
            $this->form_validation->set_rules('password', 'Password', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function file_upload($file_name, $_config = array())
    {

        $config['upload_path'] = ASSETS_DIR . "front/{$this->table}/";
        $config['allowed_types'] = 'gif|jpg|jpeg|png';

        $config = array_merge($config, $_config);

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path']);
        }

        $this->load->library('upload');
        $this->upload->initialize($config);

        $RES = $this->upload->upload_multi($file_name);

        if (count($RES['error']) > 0) {
            $return = $RES;
            $return['status'] = FALSE;
        } else {
            $return = $RES;
            $return['status'] = TRUE;
        }

        return $return;
    }

    /**
     * @param int $id
     * @param string $where
     * @return mixed
     */
    function row($id = 0, $where = '')
    {
        if ($id > 0) {
            $where .= " AND {$this->table}.{$this->id_field}='{$id}'";
        }
        $rows = $this->rows($where, 1);
        return $rows[0];
    }

    /**
     * @param string $where
     * @param int $limit
     * @param int $offset
     * @param string $order_by
     * @param string $heaving
     * @return array $rows
     */
    function rows($where = '', $limit = 0, $offset = 0, $order_by = '', $heaving = '')
    {

        $SQL = "SELECT SQL_CALC_FOUND_ROWS users.*
                , TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''))) as full_name
                -- , TRIM(CONCAT(IFNULL(users.address, ''), ', ', IFNULL(users.city, ''), ', ', IFNULL(users.country, ''))) as full_address
                -- , agent_request_rel.*
                , users.id AS id
        FROM {$this->table} AS users
        -- LEFT JOIN agent_request_rel ON (agent_request_rel.agent_id = users.id)
        WHERE 1 {$where}";

        if (!empty($order_by)) {
            $SQL .= " ORDER BY {$order_by}";
        }
        if ($limit > 0) {
            $SQL .= " LIMIT {$offset}, {$limit}";
        }
        if (!empty($heaving)) {
            $SQL .= " {$heaving}";
        }
        //echo '<pre>'; print_r($SQL); echo '</pre>';die('sad');
        $RES = $this->db->query($SQL);

        if ($RES) {
            $rows = $RES->result();
            $this->num_rows = $RES->num_rows();
            $this->total_rows = $this->db->found_rows();
        } else {
            $rows = false;

            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);
        }

        return $rows;
    }


    /**
     * @param array $ow_db_data
     * @return bool|string
     */
    function insert($ow_db_data = [])
    {

        $DbArray = getDbArray($this->table);
        $this->db_data = $DbArray['dbdata'];

        $this->db_data['password'] = encryptPassword($this->db_data['password']);
        $this->db_data['created'] = date('Y-m-d H:i:s');
        $this->db_data['modified'] = date('Y-m-d H:i:s');
        $this->db_data['created_by'] = user_info('id');
        /** @var  $upload */
        $_file_column = 'photo';
        if (isset($_POST['photo--rm'])) $this->db_data[$_file_column] = '';
        if (!empty($_FILES[$_file_column]['name'])) {
            $upload = $this->file_upload($_file_column);
            if (!$upload['status']) {
                set_notification(strip_tags($upload['error']));
            } else {
                $this->db_data[$_file_column] = $upload['upload_data']['file_name'];
            }
        }

        $this->db_data = array_merge($this->db_data, $ow_db_data);
        if ($this->_id = save($this->table, $this->db_data)) {
            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | agent_request_rel
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            $rel_table = 'agent_request_rel';
            if($this->db->table_exists($rel_table)) {
                delete_rows($rel_table, "agent_id='{$this->_id}'");

                $DbArray = getDbArray($rel_table, [], $this->input->post('rel'));
                $rel_db_data = $DbArray['dbdata'];
                $rel_db_data['agent_id'] = $this->_id;
                //$rel_db_data['campus_id'] = _session('sms_campus_id');

                /** @var  $upload */
                $_file_column = 'resume';
                if (isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
                if (!empty($_FILES[$_file_column]['name'])) {
                    $upload = $this->file_upload($_file_column, ['allowed_types' => 'pdf|doc|docx|rtf']);
                    if (!$upload['status']) {
                        set_notification(strip_tags($upload['error']));
                    } else {
                        $rel_db_data[$_file_column] = $upload['upload_data']['file_name'];
                    }
                }

                save($rel_table, $rel_db_data);
            }
            /**----------------------------------------------------------------------------------**/
            $act_name = (!empty(getUri(3)) ? getUri(3) : 'insert');
            activity_log($act_name, $this->table, $this->_id, $this->_id);
            return $this->_id;
        } else {
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);

            return false;
        }
    }

    /**
     * @param $id
     * @param array $ow_db_data
     * @return bool
     */
    function update($id, $ow_db_data = [])
    {
        $this->_id = $id;
        $DbArray = getDbArray($this->table);
        $this->db_data = $DbArray['dbdata'];

        unset($this->db_data['password']);
        if (getVar('password') != '') {
            $this->db_data['password'] = encryptPassword(getVar('password'));
        }
        /** @var  $upload */
        $_file_column = 'photo';
        if (isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
        if (!empty($_FILES[$_file_column]['name'])) {
            $upload = $this->file_upload($_file_column);
            if (!$upload['status']) {
                set_notification(strip_tags($upload['error']));
            } else {
                $this->db_data[$_file_column] = $upload['upload_data']['file_name'];
            }
        }
        $this->db_data['newsletter'] = getVar('newsletter');
        $this->db_data['modified'] = date('Y-m-d H:i:s');

        $this->db_data = array_merge($this->db_data, $ow_db_data);
        if (save($this->table, $this->db_data, "{$this->id_field} = '{$this->_id}'")) {
            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | agent_request_rel
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            $rel_table = 'agent_request_rel';
            if($this->db->table_exists($rel_table)) {
                delete_rows($rel_table, "agent_id='{$this->_id}'");

                $DbArray = getDbArray($rel_table, [], $this->input->post('rel'));
                $rel_db_data = $DbArray['dbdata'];
                $rel_db_data['agent_id'] = $this->_id;
                //$rel_db_data['campus_id'] = _session('sms_campus_id');

                /** @var  $upload */
                $_file_column = 'resume';
                if (isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
                if (!empty($_FILES[$_file_column]['name'])) {
                    $upload = $this->file_upload($_file_column, ['allowed_types' => 'pdf|doc|docx|rtf']);
                    if (!$upload['status']) {
                        set_notification(strip_tags($upload['error']));
                    } else {
                        $rel_db_data[$_file_column] = $upload['upload_data']['file_name'];
                    }
                }

                save($rel_table, $rel_db_data);
            }
            /**----------------------------------------------------------------------------------**/

            activity_log(getUri(3), $this->table, $this->_id);
            return $this->_id;
        } else {
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);

            return false;
        }
    }


}

/* End of file M_users.php */
/* Location: ./application/models/m_users.php */