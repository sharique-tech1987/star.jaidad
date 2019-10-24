<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_scheme_forms extends CI_Model
{
    var $table = 'scheme_forms';
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

    function validate($id = 0)
    {
        if($id == 0){ $id = getUri(4); }

        //$this->form_validation->set_rules('form_type', __('Form Type'), 'required');
        $this->form_validation->set_rules('name', __('Name'), 'required');
        $this->form_validation->set_rules('father_name', __('Father Name'), 'required');
        $this->form_validation->set_rules('cnic', __('CNIC'), 'required|db_unique[scheme_forms.cnic.id.' . $id . ']');
        $this->form_validation->set_rules('dob', __('Date of birth'), 'required');
        //$this->form_validation->set_rules('address', __('Address'), 'required');
        $this->form_validation->set_rules('permanent_address', __('Permanent Address'), 'required');
        $this->form_validation->set_rules('telephone', __('Telephone'), 'required');
        $this->form_validation->set_rules('cell', __('Cell'), 'required|db_unique[scheme_forms.cell.id.' . $id . ']');
        $this->form_validation->set_rules('email', __('Email'), 'required|valid_email');
        $this->form_validation->set_rules('cities', __('Cities'), 'required|min_length[1]');
        $this->form_validation->set_rules('property_type', __('Property Type'), 'required');
        //$this->form_validation->set_rules('area', __('Area'), 'required');
        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }

    }


    function file_upload($file_name, $_config = array())
    {

        $config['upload_path'] = ASSETS_DIR . "front/{$this->table}/";
        $config['allowed_types'] = 'gif|jpg|jpeg|png|gif';

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
     * @return object $rows
     */
    function rows($where = '', $limit = 0, $offset = 0, $order_by = '', $heaving = '')
    {

        $SQL = "SELECT SQL_CALC_FOUND_ROWS {$this->table}.*
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

        $this->db_data['created'] = date('Y-m-d H:i:s');
        $this->db_data['modified'] = date('Y-m-d H:i:s');
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

        $this->db_data['cities'] = getVar('cities');
        $this->db_data['property_type'] = getVar('property_type');
        $this->db_data['area'] = getVar('area');
        $this->db_data['modified'] = date('Y-m-d H:i:s');
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

/* End of file M_scheme_forms.php */
/* Location: ./application/models/M_scheme_forms.php */