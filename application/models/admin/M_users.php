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

class M_users extends CI_Model
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

    function validate($id = 0, $username = true)
    {
        if($id == 0){ $id = getUri(4); }

        if(in_array(getUri(2), ['users'])){
            $this->form_validation->set_rules('user_type_id', 'User Type', 'required');
        }

        if($id > 0){
            $member = get_member($id);
        }

        $this->form_validation->set_rules('first_name', 'Name', 'required');
        if(empty($member->social)) {
            if(!$username){
                $this->form_validation->set_rules('username', 'Email Address', 'required|db_unique[users.username.id.' . $id . ']');
            } else {
                $this->form_validation->set_rules('username', 'Username', 'required|db_unique[users.username.id.' . $id . ']');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|db_unique[users.email.id.' . $id . ']');
            }
        }else{
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        }

        $reserve_types = array_pop(_reserve_types());

        if(in_array($member->user_type_id, $reserve_types) || intval($member->user_type_id) == 0) {
            $this->form_validation->set_rules('phone', 'Phone', 'required|integer|db_unique[users.phone.id.' . $id . ']');
        }

        if($id == 0 || empty($member->social)){
            $this->form_validation->set_rules('password', 'Password', 'required');
        }

        //$this->form_validation->set_rules('last_name', 'Last Name', 'required');
        //$this->form_validation->set_rules('address', 'Address', 'required');
        //$this->form_validation->set_rules('city', 'City', 'required');
        //$this->form_validation->set_rules('country', 'Country', 'required');

        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function get_file($id = 0, $where = ''){

        $SQL = "SELECT
                user_files.*
                , GROUP_CONCAT(affiliate_type.id) AS affiliate_type_ids
                , GROUP_CONCAT(affiliate_type.title) AS affiliate_type
            FROM user_files
                LEFT JOIN user_file_affiliates ON (user_files.id = user_file_affiliates.file_id)
                LEFT JOIN affiliate_type ON (user_file_affiliates.affiliate_id = affiliate_type.id)
            WHERE 1 {$where}
            ";
        if($id > 0){
            $SQL .= " AND user_files.id='$id' ";
        }
        $SQL .= " GROUP BY user_files.id";

        $data = $this->db->query($SQL)->row();

        return $data;
    }


    function change_password($user_id) {
        $days = intval(get_option('password_days'));
        $SQL = "SELECT * FROM user_recent_passwords WHERE user_id='{$user_id}' 
        AND (DATEDIFF(NOW(), created)) >= {$days} 
        ORDER BY created DESC LIMIT 1";
        $Q = $this->db->query($SQL);
        if($Q->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function update_password($user_id, $pass) {
        $limit = intval(get_option('old_password_limit'));
        $SQL = "SELECT * FROM user_recent_passwords WHERE user_id='{$user_id}' AND password='{$pass}' ORDER BY created DESC LIMIT {$limit}";
        $Q = $this->db->query($SQL);
        if($Q->num_rows() > 0) {
            return false;
        } else {
            save('user_recent_passwords', array('user_id' => $user_id, 'password' => $pass));
            return true;
        }
    }

    function file_upload($file_name, $_config = array())
    {

        $config['upload_path'] = ASSETS_DIR . "front/{$this->table}/";
        $config['allowed_types'] = 'gif|jpg|jpeg|png';

        $config = array_merge($config, $_config);

        if(!is_dir($config['upload_path'])){ mkdir($config['upload_path']); }

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

    function info($where = '', $user_session = ADMIN_SESSION_ID)
    {
        $id = _session($user_session);
        $row = $this->row($id, $where);
        return $row;
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
                , user_types.user_type
                , user_types.login
                , TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''))) as full_name
                , TRIM(CONCAT(IFNULL(users.address, ''), ', ', IFNULL(users.city, ''))) as full_address
        FROM {$this->table} AS users
        LEFT JOIN user_types ON (user_types.id = users.user_type_id)
        WHERE 1 {$where}";

        if(!empty($order_by)){
            $SQL .= " ORDER BY {$order_by}";
        }
        if($limit > 0){
            $SQL .= " LIMIT {$offset}, {$limit}";
        }
        if(!empty($heaving)){
            $SQL .= " {$heaving}";
        }
        //echo '<pre>'; print_r($SQL); echo '</pre>';
        $RES = $this->db->query($SQL);

        if ($RES) {
            $rows = $RES->result();
            $this->num_rows = $RES->num_rows();
            $this->total_rows = $this->db->found_rows();
        }else{
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
    function insert($ow_db_data = []){

        $DbArray = getDbArray($this->table);
        $this->db_data = $DbArray['dbdata'];

        $this->db_data['password'] = encryptPassword($this->db_data['password']);
        $this->db_data['status'] = 'Active';
        $this->db_data['created'] = date('Y-m-d H:i:s');
        $this->db_data['modified'] = date('Y-m-d H:i:s');
        $this->db_data['created_by'] = user_info('id');
        /** @var  $upload */
        $_file_column = 'photo';
        if(isset($_POST['photo--rm'])) $this->db_data[$_file_column] = '';
        if(!empty($_FILES[$_file_column]['name'])) {
            $upload = $this->file_upload($_file_column);
            if (!$upload['status']) {
                set_notification(strip_tags($upload['error']));
            } else {
                $this->db_data[$_file_column] = $upload['upload_data']['file_name'];
            }
        }

        $this->db_data = array_merge($this->db_data, $ow_db_data);
        if($this->_id = save($this->table, $this->db_data)){
            activity_log(getUri(3), $this->table, $this->_id);
            return $this->_id;
        }else {
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
    function update($id, $ow_db_data = []){
        $this->_id = $id;

        $DbArray = getDbArray($this->table);
        $this->db_data += $DbArray['dbdata'];

        unset($this->db_data['password']);
        if(getVar('password') != ''){
            $this->db_data['password'] = encryptPassword(getVar('password'));
        }
        /** @var  $upload */
        $_file_column = 'photo';
        if(isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
        if(!empty($_FILES[$_file_column]['name'])) {
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
        if(save($this->table, $this->db_data, "{$this->id_field} = '{$this->_id}'")){
            activity_log(getUri(3), $this->table, $this->_id);
            return $this->_id;
        }else {
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);

            return false;
        }
    }



}

/* End of file M_users.php */
/* Location: ./application/models/m_users.php */