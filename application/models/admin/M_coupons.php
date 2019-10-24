<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_coupons extends CI_Model
{
    var $table = 'coupons';
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
        $this->form_validation->set_rules('coupon_type', __('Coupon Type'), 'required');
        $this->form_validation->set_rules('coupon_name', __('Coupon Name'), 'required');
        $this->form_validation->set_rules('coupon_code', __('Coupon Code'), 'required');
        $this->form_validation->set_rules('discount_type', __('Discount Type'), 'required');
        $this->form_validation->set_rules('discount', __('Discount'), 'required');
        $this->form_validation->set_rules('total_amount', __('Total Amount'), 'required');
        $this->form_validation->set_rules('start_date', __('Start Date'), 'required');
        $this->form_validation->set_rules('end_date', __('End Date'), 'required');
        $this->form_validation->set_rules('usage_policy', __('Usage Policy'), 'required');
        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }

    }


    function file_upload($file_name, $_config = array())
    {

        $config['upload_path'] = ASSETS_DIR . "front/{$this->table}/";
        $config['allowed_types'] = '';

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
                -- , user_types.customer_type
FROM {$this->table}
        -- LEFT JOIN user_types ON(user_types.id = coupons.customer_type)
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

        $this->db_data['created'] = date('Y-m-d H:i:s');
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

/* End of file M_coupons.php */
/* Location: ./application/models/M_coupons.php */