<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_project_properties extends CI_Model
{
    var $table = 'project_properties';
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
        $this->form_validation->set_rules('project_id', __('Project'), 'required');
        $this->form_validation->set_rules('type_id', __('Type'), 'required');
        $this->form_validation->set_rules('title', __('Title'), 'required');
        $this->form_validation->set_rules('area', __('Area'), 'required');
        $this->form_validation->set_rules('price', __('Price'), 'numeric');
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
                -- , project_properties.project_id
                , property_types.type
FROM {$this->table}
-- LEFT JOIN project_properties ON(project_properties.id = project_properties.project_id)
LEFT JOIN property_types ON(property_types.id = project_properties.type_id)
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

        $this->db_data['square_meter'] = area_conversion($this->db_data['area'], $this->db_data['area_unit']);

        $this->db_data['floor_plans'] = json_encode(getVar('floor_plans', false, false));
        /** @var  $upload */
        $_file_column = 'payment_plan';
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
            $file_path = asset_dir("front/{$this->table}/");
            $files_remove = getVar('floor_plans_remove', true, false);
            if (count($files_remove) > 0) {
                foreach ($files_remove as $file) {
                    @unlink($file_path . $file);
                }
            }

            /**
             * update_payment
             */
            $this->update_payment($this->_id);

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

        $this->db_data['square_meter'] = area_conversion($this->db_data['area'], $this->db_data['area_unit']);

        $this->db_data['floor_plans'] = json_encode(getVar('floor_plans', false, false));
        /** @var  $upload */
        $_file_column = 'payment_plan';
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
            $file_path = asset_dir("front/{$this->table}/");
            $files_remove = getVar('floor_plans_remove', true, false);
            if (count($files_remove) > 0) {
                foreach ($files_remove as $file) {
                    @unlink($file_path . $file);
                }
            }
            /**
             * update_payment
             */
            $this->update_payment($this->_id);

            activity_log(getUri(3), $this->table, $this->_id);
            return $this->_id;
        } else {
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);

            return false;
        }
    }


    function update_payment($property_id)
    {
        //$property_id = 2;
        delete_rows('payment_schedule', "property_id='{$property_id}'");
        $payment = getVar('payment');
        if (count($payment['particulars']) > 0) {
            foreach ($payment['amount'] as $i => $_amount) {
                foreach ($_amount as $k => $amount) {
                    if (empty($payment['particulars'][$k])) continue;
                    $data = [
                        'particulars' => $payment['particulars'][$k],
                        'payment_interval' => intval($payment['payment_interval'][$k]),
                        'interval_type' => $payment['interval_type'][$k],
                        'installment_duration' => $payment['installment_duration'][$k],
                        'installment_interval' => $payment['installment_interval'][$k],
                        'installment_interval_type' => $payment['installment_interval_type'][$k],
                        'property_id' => $property_id,
                        'floors' => join('-', $payment['floors'][$i]),
                        'amount' => $amount,
                        'status' => 'Active',
                    ];

                    save('payment_schedule', $data);

                }
            }
        }

    }

    function payments($property_id)
    {
        $_payments = $this->db->get_where('payment_schedule', ['property_id' => $property_id])->result();

        $data = [];
        if (count($_payments) > 0) {
            foreach ($_payments as $payment) {
                $data[$payment->floors][] = $payment;
            }
        }
        return $data;
    }

    /**
     * @param object $booking
     * @return array
     */
    function booking_payments($booking)
    {
        //$booking = $this->db->get_where('booking', ['id' => $booking->id])->row();
        $income = $this->db->get_where('income', ['booking_id' => $booking->id])->result();
        $_income = [];
        if (count($income) > 0) {
            foreach ($income as $item) {
                $_income[$item->income_head] = $item;
            }
        }

        $SQL = "SELECT * FROM `payment_schedule` WHERE 3 BETWEEN SPLIT_STRING(`floors`, '-', 1) AND SPLIT_STRING(`floors`, '-', 2) AND property_id='{$booking->property_id}'";
        $payments = $this->db->query($SQL)->result();

        $_payments = [];
        foreach ($payments as $k => $payment) {
            if ($payment->installment_duration > 0) {
                for ($l = 0; $l < $payment->installment_duration; $l++) {
                    $n_date = create_date($booking->booking_date, "+ " . ($payment->payment_interval) . " {$payment->interval_type}");
                    $n_date = create_date($n_date, "+ " . ($payment->installment_interval * ($l)) . " {$payment->installment_interval_type}");
                    $pk = strtotime($n_date);
                    if (key_exists($pk, $_payments)) {
                        $pk = ($pk + random_string('numeric', 3));
                    }
                    $particulars = $payment->particulars . " #" . ($l + 1);
                    $sch_payments = [
                        'particulars' => $particulars,
                        'amount' => $payment->amount,
                        'date' => $n_date,
                        'paid_amount' => $_income[$particulars]->amount,
                        'paid_date' => $_income[$particulars]->date,
                        'income_id' => $_income[$particulars]->id,
                        'balance' => ($payment->amount - $_income[$particulars]->amount),
                        'late_charges' => ($payment->late_charges),
                    ];
                    $_payments[$pk] = $sch_payments;
                    //array_push($_payments, $sch_payments);
                }
            } else {
                $n_date = create_date($booking->booking_date, "+ " . ($payment->payment_interval) . " {$payment->interval_type}");
                $pk = strtotime($n_date);
                if (key_exists($pk, $_payments)) {
                    $pk = ($pk + random_string('numeric', 3));
                }

                $sch_payments = [
                    'particulars' => $payment->particulars,
                    'amount' => $payment->amount,
                    'date' => $n_date,
                    'paid_amount' => $_income[$payment->particulars]->amount,
                    'paid_date' => $_income[$payment->particulars]->date,
                    'income_id' => $_income[$payment->particulars]->id,
                    'balance' => ($payment->amount - $_income[$payment->particulars]->amount),
                    'late_charges' => ($payment->late_charges),
                ];
                $_payments[$pk] = $sch_payments;
                //array_push($_payments, $sch_payments);
            }
        }

        ksort($_payments);

        return $_payments;
    }


}

/* End of file M_project_properties.php */
/* Location: ./application/models/M_project_properties.php */