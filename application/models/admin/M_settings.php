<?php
/**
 * Adnan Bashir
 * E:  developer.adnan@gmail.com

 * P: +923323103324
 * S: developer.adnan
 * @copyright 2014 * @date 02-01-2014
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_settings extends CI_Model
{

    var $table = 'options';
    var $id_field = 'id';

    function __construct()
    {

        parent::__construct();
        if (empty($this->table)) {
            $this->table = getUri(2);
        }
    }

    function validate()
    {
        $this->form_validation->set_rules('option_name', 'option', 'required');
        //$this->form_validation->set_rules('option_value', 'Value', 'required');

        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function file_upload($file_name, $config = array())
    {

        if (count($config) == 0) {
            $config['upload_path'] = ASSETS_DIR . 'img/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
        }


        $this->load->library('upload');
        $this->upload->initialize($config);

        $rs = $this->upload->upload_multi($file_name);
        if (count($rs['error']) > 0) {
            $return['status'] = FALSE;
            $return['error'] = $rs;
        } else {
            $return['status'] = TRUE;
            $return['upload_data'] = $rs['upload_data'];
        }

        return $return;
    }


    function getayats($id = '', $where = '')
    {

        $sql = "SELECT * FROM " . $this->table . " WHERE 1  ";
        if ($id) {
            $sql .= " AND " . $this->id_field . "='{$id}'";
        }
        $result = $this->db->query($sql . $where);

        return $result->result();

    }
}



/* End of file m_ayats.php */
/* Location: ./application/models/m_ayats.php */