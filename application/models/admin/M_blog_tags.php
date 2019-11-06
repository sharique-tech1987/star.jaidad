<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_blog_tags extends CI_Model
{

    var $table = 'blog_tags';
    var $id_field = 'id';

    var $num_rows = 0;
    var $total_rows = 0;
    var $db_error = '';

    var $db_data = [];
    var $_id;

    function __construct()
    {
        parent::__construct();
        if (empty($this->table)) {
            $this->table = getUri(2);
        }
    }

    function validate(){
        $this->form_validation->set_rules('type', __('Type'), 'required');
        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }


    function file_upload($file_name, $_config = array()){}

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
     * @return object $rows
     */
    function rows($where = '', $limit = 0, $offset = 0, $order_by = '', $heaving = '')
    {

        $SQL = "SELECT SQL_CALC_FOUND_ROWS {$this->table}.*
                -- , blog_categories.parent_id
FROM {$this->table}
        -- LEFT JOIN blog_categories ON(blog_categories.id = blog_categories.parent_id)
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

        /** @var  $upload */
        $_file_column = 'image';
        if (isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
        if (!empty($_FILES[$_file_column]['name'])) {
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
        $this->db_data = $DbArray['dbdata'];

        /** @var  $upload */
        $_file_column = 'image';
        if (isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
        if (!empty($_FILES[$_file_column]['name'])) {
            $upload = $this->file_upload($_file_column);
            if (!$upload['status']) {
                set_notification(strip_tags($upload['error']));
            } else {
                $this->db_data[$_file_column] = $upload['upload_data']['file_name'];
            }
        }

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