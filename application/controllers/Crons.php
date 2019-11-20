<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Crons
 * @property M_booking $m_booking
 * @property M_project_properties $m_project_properties
 * @property M_members $m_members
 */
class Crons extends CI_Controller
{
    function __construct()
    {
        set_time_limit(60 * 60 * 60);
        parent::__construct();

        $this->load->model([
            ADMIN_DIR . 'm_booking',
            ADMIN_DIR . 'm_project_properties',
            ADMIN_DIR . 'm_members',
        ]);
    }

    function update_lat_lng(){
        $PARENT_AREA_SQL = "SELECT SQL_CALC_FOUND_ROWS `countries`.countryName
                , `cities`.`city`
                , `area`.*
                , CONCAT_WS(',',`area`.area, `cities`.`city`, `countries`.countryName) `FullAddress` 
                FROM `cities` 
                LEFT JOIN `area` ON (`cities`.`id` = `area`.`city_id`) 
                LEFT JOIN `countries` ON (`countries`.countryCode = `cities`.country) 
                WHERE 1 AND `area`.`parent_id` = 0 AND `area`.lat = 0 AND `area`.lng = 0 LIMIT 0,40";

        $when_lat_clause = "";
        $when_lng_clause = "";
        $ids_array = array();
        $parent_rows = $this->db->query($PARENT_AREA_SQL)->result();
        if (count($parent_rows) > 0) {
            foreach ($parent_rows as $row) {
                $latLng = getLatLng($row->FullAddress);
                if($latLng->lat != null && $latLng->lat != 0) {
                    array_push($ids_array, $row->id);
                    $when_lat_clause .= " WHEN " . $row->id . " THEN " . $latLng->lat;
                    $when_lng_clause .= " WHEN " . $row->id . " THEN " . $latLng->lng;
                }
            }

            if(count($ids_array)) {
                $UPDATE_LAT_SQL = "UPDATE area
                        SET lat = (CASE id " . $when_lat_clause .
                    " END)
                        WHERE id IN(" . join(",", $ids_array) . ");";

                $UPDATE_LNG_SQL = "UPDATE area
                        SET lng = (CASE id " . $when_lng_clause .
                    " END)
                        WHERE id IN(" . join(",", $ids_array) . ");";

//                echo $UPDATE_LAT_SQL;
//                echo "<br/>";
//                echo $UPDATE_LNG_SQL;
                echo "----- Modified Ids -----";
                var_dump($ids_array);

                //            Run Batch update
                $this->db->query($UPDATE_LAT_SQL);
                $this->db->query($UPDATE_LNG_SQL);
            }

        }


        $SUB_AREA_SQL = "SELECT SQL_CALC_FOUND_ROWS `countries`.countryName
                , `cities`.`city`
                , `area`.*
                , CONCAT_WS(',',`area`.area, `cities`.`city`, `countries`.countryName) `FullAddress` 
                FROM `cities` 
                LEFT JOIN `area` ON (`cities`.`id` = `area`.`city_id`) 
                LEFT JOIN `countries` ON (`countries`.countryCode = `cities`.country) 
                WHERE 1 AND `area`.`parent_id` != 0 AND `area`.lat = 0 AND `area`.lng = 0 LIMIT 0,25";

        $when_lat_clause = "";
        $when_lng_clause = "";
        $ids_array = array();
        $sub_rows = $this->db->query($SUB_AREA_SQL)->result();

        if (count($sub_rows) > 0) {
            foreach ($sub_rows as $row) {
                $latLng = getLatLng($row->FullAddress);
                if($latLng->lat != null && $latLng->lat != 0) {
                    array_push($ids_array, $row->id);
                    $when_lat_clause .= " WHEN " . $row->id . " THEN " . $latLng->lat;
                    $when_lng_clause .= " WHEN " . $row->id . " THEN " . $latLng->lng;
                }
            }

            if(count($ids_array)) {
                $UPDATE_SUB_AREA_LAT_SQL = "UPDATE area
                        SET lat = (CASE id " . $when_lat_clause .
                    " END)
                        WHERE id IN(" . join(",", $ids_array) . ");";

                $UPDATE_SUB_AREA_LNG_SQL = "UPDATE area
                        SET lng = (CASE id " . $when_lng_clause .
                    " END)
                        WHERE id IN(" . join(",", $ids_array) . ");";

                echo "<br/>";
//                echo $UPDATE_SUB_AREA_LAT_SQL;
//                echo "<br/>";
//                echo $UPDATE_SUB_AREA_LNG_SQL;
                echo "----- Modified Ids -----";
                var_dump($ids_array);

//            Run Batch update
                $this->db->query($UPDATE_SUB_AREA_LAT_SQL);
                $this->db->query($UPDATE_SUB_AREA_LNG_SQL);
            }
        }

        echo "<br/>";
        echo "Updated Lat Long";

    }

    function payment_reminders($reminder_days)
    {
        $reminder_days = ($reminder_days == 0 ? 15 : $reminder_days);
        $status = array();

        $_bookings = $this->m_booking->rows();
        if (count($_bookings) > 0) {
            foreach ($_bookings as $booking) {
                $data['row'] = $booking;
                $data['booking'] = $this->m_members->bookings($booking->member_id, "AND booking.id='{$booking->id}'")[0];
                $data['payments'] = $this->m_project_properties->booking_payments($booking);
                $data['member'] = $this->m_members->row($booking->member_id);

                $html = $this->load->view(admin_dir("booking/pdf"), $data, true);

                $options = new Dompdf\Options();
                $options->set('defaultFont', 'Courier');
                $options->set('isRemoteEnabled', true);
                $dompdf = new Dompdf\Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'landscape');
                $dompdf->render();
                $filename = $booking->id;
                file_put_contents(asset_dir("pdf/{$filename}.pdf"), $dompdf->output());
                echo '<pre>'; print_r("<a target='_blank' href='".asset_url("pdf/$filename")."'>".$filename." PDF</a>"); echo '</pre>';

                $email = $data['member']->email;

                # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                # Payment Reminders

                $msg = get_email_template($data['member'], "Payment Reminder {$reminder_days}");
                if ($msg->status == 'Active') {
                    $emaildata = array(
                        //'to' => $customer->email,
                        'to' => $email,
                        'subject' => $msg->subject,
                        'message' => $msg->message
                    );
                    $emaildata['attach'] = [$filename];
                    if (!send_mail($emaildata)) {
                        array_push($status['error'], "ERROR  - BID: {$booking->id} Email: $email");
                    } else {
                        array_push($status['success'], "SUCCESS - BID: {$booking->id} Email: $email");
                    }
                }
            }

            echo '<pre>'; print_r($status); echo '</pre>';
        }

        die('End');

    }

    function final_reminders()
    {

        $status = array();

        $types = ['membership', 'licensing'];
        foreach ($types as $type) {
            $SQL = "SELECT
              customers.id
              , customers.company_name
              , customers.company_logo
              , customers.first_name
              , customers.last_name
              , customers.designation
              , CONCAT(IFNULL(customers.first_name, ''),' ', IFNULL(customers.last_name, '')) as full_name
              , customers.email
              , customers.member_type
              , customers.renew_{$type}_date
              , DATE_ADD(customers.renew_{$type}_date, INTERVAL 1 YEAR) AS new_{$type}_date
              , DATE_SUB(customers.renew_{$type}_date,INTERVAL 1 DAY) AS reminder_{$type}_date
              , DATE(DATE_SUB(DATE_ADD(orders.created, INTERVAL 1 MONTH),INTERVAL 1 DAY)) AS reminder_date
              , DATE(orders.created) AS created_date
              , orders.id AS order_id
            FROM customers
            INNER JOIN orders ON (orders.customer_id = customers.id)
            WHERE 1 AND DATE(NOW()) = DATE(DATE_SUB(DATE_ADD(orders.created, INTERVAL 1 MONTH),INTERVAL 1 DAY))";


            $rows = $this->db->query($SQL)->result();
            if (count($rows) > 0) {
                foreach ($rows as $row) {

                    if($row->member_type == 'Standard' && $type == 'licensing'){
                        continue;
                    }

                    $cus_data = ['status' => $row->{'new_'.$type.'_date'}];
                    save('customers', $cus_data, 'id=' . $row->id);

                    # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                    # Final Payment Reminders
                    $msg = get_email_template($row, 'Final Payment Reminder - ' . ucwords($type));
                    if ($msg->status == 'Active') {
                        $emaildata = array(
                            //'to' => $customer->email,
                            'to' => $row->email,
                            'subject' => $msg->subject,
                            'message' => $msg->message
                        );
                        if (!send_mail($emaildata)) {
                            array_push($status['error'], "ERROR {$type} - ID: {$row->id} Email: $row->email");
                            //$this->session->set_flashdata('error', 'Email sending failed.');
                        } else {
                            array_push($status['success'], "SUCCESS {$type} - ID: {$row->id} Email: $row->email");
                            //$this->session->set_flashdata('success', 'Please check your email for username & password!');
                        }
                    }
                }
            }
            echo '<pre>'; print_r($status); echo '</pre>';
        }
    }

    function account_expiry()
    {

        $status = array();

        $types = ['membership', 'licensing'];
        foreach ($types as $type) {
            $SQL = "SELECT
              customers.id
              , customers.company_name
              , customers.company_logo
              , customers.first_name
              , customers.last_name
              , customers.designation
              , CONCAT(IFNULL(customers.first_name, ''),' ', IFNULL(customers.last_name, '')) as full_name
              , customers.email
              , customers.member_type
              , customers.renew_{$type}_date
              , DATE_ADD(customers.renew_{$type}_date, INTERVAL 1 YEAR) AS new_{$type}_date
              , DATE_SUB(customers.renew_{$type}_date,INTERVAL 1 DAY) AS reminder_{$type}_date
              , DATE(DATE_SUB(DATE_ADD(orders.created, INTERVAL 1 MONTH),INTERVAL 1 DAY)) AS reminder_date
              , DATE(orders.created) AS created_date
              , orders.id AS order_id
            FROM customers
            INNER JOIN orders ON (orders.customer_id = customers.id)
            WHERE 1 AND DATE(NOW()) = DATE(DATE_ADD(DATE_ADD(orders.created, INTERVAL 1 MONTH), INTERVAL orders.discount_days DAY))";

            /*echo '<pre>'; print_r($SQL); echo '</pre>';
            continue;*/
            $rows = $this->db->query($SQL)->result();
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    if($row->member_type == 'Standard' && $type == 'licensing'){
                        continue;
                    }

                    $cus_data = ['status' => $row->{'new_'.$type.'_date'}];
                    save('customers', $cus_data, 'id=' . $row->id);

                    # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                    # Final Payment Reminders
                    $msg = get_email_template($row, 'Account Expiry - ' . ucwords($type));
                    if ($msg->status == 'Active') {
                        $emaildata = array(
                            //'to' => $customer->email,
                            'to' => $row->email,
                            'subject' => $msg->subject,
                            'message' => $msg->message
                        );
                        if (!send_mail($emaildata)) {
                            array_push($status['error'], "ERROR {$type} - ID: {$row->id} Email: $row->email");
                            //$this->session->set_flashdata('error', 'Email sending failed.');
                        } else {
                            array_push($status['success'], "SUCCESS {$type} - ID: {$row->id} Email: $row->email");
                            //$this->session->set_flashdata('success', 'Please check your email for username & password!');
                        }
                    }
                }
            }
            echo '<pre>'; print_r($status); echo '</pre>';
        }
    }


    function test_mail(){

        $email = 'adnan@petrolsolution.com';
        $msg = new stdClass();
        $msg->subject = 'Engineering 360 Integrating Machine & Raw Material Manufacturers';
        $msg->message = $this->load->view('mail', [], true);

        $emaildata = array(
            //'to' => $customer->email,
            'to' => $email,
            'subject' => $msg->subject,
            'message' => $msg->message
        );
        if (!send_mail($emaildata)) {
            echo '<pre>'; print_r("ERROR - Email: $email"); echo '</pre>';
            //$this->session->set_flashdata('error', 'Email sending failed.');
        } else {
            echo '<pre>'; print_r("SUCCESS - Email: $email"); echo '</pre>';
        }
    }

}

/* End of file AJAX.php */
/* Location: ./application/controllers/AJAX.php */