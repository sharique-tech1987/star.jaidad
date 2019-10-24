<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pages extends CI_Model
{
    var $table = 'pages';
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

    function validate()
    {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('friendly_url', 'Friendly URL', 'db_unique[pages.friendly_url.id.' . getVar($this->id_field) . ']');
        //$this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('ordering', 'Ordering', 'numeric');
        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
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
            $where .= " AND $this->id_field='{$id}'";
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
     */
    function rows($where = '', $limit = 0, $offset = 0, $order_by = '', $heaving = '')
    {

        $SQL = "SELECT SQL_CALC_FOUND_ROWS *
        FROM {$this->table} 
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

        $RES = $this->db->query($SQL);

        if ($RES) {
            $rows = $RES->result();
            $this->num_rows = $RES->num_rows();
            $this->total_rows = $this->db->found_rows();
        } else {
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);
        }

        return $rows;
    }


    function insert($ow_db_data = [])
    {

        $DbArray = getDbArray($this->table);
        $this->db_data = $DbArray['dbdata'];

        $this->db_data['content'] = getVar('content', FALSE, FALSE);
        $this->db_data['created'] = date('Y-m-d H:i:s');
        $this->db_data['params'] = json_encode($this->db_data['params']);

        /** @var  $upload */
        $_file_column = 'thumbnail';
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
        if ($this->_id = save($this->table, $this->db_data)) {
            activity_log(getUri(3), $this->table, $this->_id);
            return $this->_id;
        } else {
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);

            return false;
        }
    }

    function update($id, $ow_db_data = [])
    {
        $this->_id = $id;

        $DbArray = getDbArray($this->table);
        $this->db_data = $DbArray['dbdata'];

        $this->db_data['content'] = getVar('content', FALSE, FALSE);
        $this->db_data['params'] = json_encode($this->db_data['params']);

        /** @var  $upload */
        $_file_column = 'thumbnail';
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
        if (save($this->table, $this->db_data, "{$this->id_field} = '{$this->_id}'")) {
            activity_log(getUri(3), $this->table, $this->_id);
            return $this->_id;
        } else {
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);

            return false;
        }
    }


}

/* End of file M_pages.php */
/* Location: ./application/models/m_pages.php */