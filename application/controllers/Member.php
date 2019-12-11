<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

/**
 * Class Index
 * @property Cms $cms
 * @property M_users $m_users
 */
class Member extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('frontend');
        $this->load->model('cms');
        $this->load->model(ADMIN_DIR . 'm_users');
    }

    function login()
    {
        redirect('login');
    }

    function index()
    {
        $this->account();
    }

    function become_agent()
    {
        $user_id = _session(FRONT_SESSION_ID);
        if ($user_id == 0) {
            redirect('login');
        }

        /*$row = $this->m_users->row($user_id);
        $data = json_decode($row->data);
        $data->become_agent = true;
        save('users', ['data' => json_encode($data)], "id='{$user_id}'");*/

        //if ($edit == 'edit')
        {
            $data['row'] = $data['member'] = $this->m_users->info("", FRONT_SESSION_ID);
            $data['edit'] = true;
            $data['become_agent'] = true;
            $this->template->load('member/edit_profile', $data);
        }

        /*save('users', ['become_agent' => 1], "id='{$user_id}'");

        set_notification('Agent request has been sent!', 'success');
        redirect('member/account');*/
    }

    /**
     * void account
     */
    function account()
    {

        $user_id = _session(FRONT_SESSION_ID);
        if ($user_id == 0) {
            redirect('login');
        }

        $page = getUri(3);
        $edit = getVar('edit');//getUri(4);

        $data['row'] = $data['member'] = $this->m_users->info("", FRONT_SESSION_ID);

        $data['my_profile'] = false;
        if ($data['row']->id == $user_id) {
            $data['my_profile'] = true;
        }
        $this->template->set_site_title($data['row']->full_name . ' - ' . $page);

        //$edit = getUri(3);

        if ($edit == 'edit') {
            $data['edit'] = true;
            $this->template->load('member/edit_profile', $data);
        } else {
            if (!empty($page) && !in_array($page, ['home', 'account'])) {
                $this->template->load('member/dashboard/' . $page, $data);
            } else {
                $this->template->load('member/dashboard', $data);
            }
        }
    }

    /**
     * void account
     */
    function bookings()
    {
        $user_id = _session(FRONT_SESSION_ID);
        if (!$user_id) {
            redirect('member/login');
        }
        $action = getUri(3);

        switch ($action) {
            case 'view':
                $id = intval(getVar('id'));
                if ($id > 0) {
                    $query = "SELECT * FROM orders WHERE id='{$id}' AND member_id='{$user_id}' AND status !='Process'";
                    $data['order'] = $this->db->query($query)->row();
                    if ($data['order']->id == $id) {

                        $data['customer'] = $this->m_customers->customer($data['order']->member_id);
                        if (!SHIPPING_BILLING_ADD) {
                            $data['billing'] = $data['customer'];
                            $data['shipping'] = $data['customer'];
                        } else {
                            $billing = $this->m_customers->customer_address($data['order']->member_id, '', $data['order']->billing_add_id);
                            $shipping = $this->m_customers->customer_address($data['order']->member_id, '', $data['order']->shipment_add_id);
                            $data['billing'] = $billing[0];
                            $data['shipping'] = $shipping[0];
                        }

                        $data['order_detail'] = $this->catalog->order_detail($id);

                        /*$total_r = $this->catalog->total($id, true);
                        $total_amount = ($total_r->amount + $total_r->shipping_amount - $total_r->discount);
                        $data['shipping_amount'] = ($total_r->shipping_amount);
                        $data['discount'] = ($total_r->discount);
                        $data['total_amount'] = ($total_amount);*/

                        $this->template->load('member/order_view', $data);
                        return;
                    }
                }
                show_404();
                break;
        }


    }

    /**
     * void wishlist
     */
    function wishlist()
    {

        $member_id = _session(FRONT_SESSION_ID);
        if (!$member_id) {
            redirect('member/login');
        }
        $action = getUri(3);
        $product_id = getUri(4);

        if ($product_id > 0) {
            switch ($action) {
                case 'add':
                    save('user_wishlist', ['type' => 'Property', 'user_id' => $member_id, 'property_id' => $product_id, 'created' => date('Y-m-d H:i:s')]);
                    set_notification('Wishlist record has been added!');
                    redirectBack();
                    break;
                case 'delete':
                    delete_rows('user_wishlist', "user_id={$member_id} AND property_id='{$product_id}'");
                    set_notification('Wishlist record has been deleted!');
                    break;
                case 'add_project':
                    save('user_wishlist', ['type' => 'Project', 'user_id' => $member_id, 'project_id' => $product_id, 'created' => date('Y-m-d H:i:s')]);
                    set_notification('Wishlist record has been added!');
                    redirectBack();
                    break;
                case 'delete_project':
                    delete_rows('user_wishlist', "user_id={$member_id} AND project_id='{$product_id}'");
                    set_notification('Wishlist record has been deleted!');
                    break;
            }
            redirect('member/account/wishlist');
        }

        $data['customer'] = $this->m_customers->customer($member_id);

        $data['products'] = $this->m_customers->wishlist($member_id);

        $this->template->load('member/wishlist', $data);
    }

    /**
     * void wishlist
     */
    function orders()
    {

        $customer_login = _session('customer_login');
        if (!$customer_login) {
            redirect('member/login');
        }
        $member_id = _session('customer_user_id');

        $data['customer'] = $this->m_customers->customer($member_id);

        $data['orders'] = $this->m_customers->orders($member_id);

        $this->template->load('member/orders', $data);
    }


    function subscribe()
    {
        $email = getVar('email', true, false);

        if ($this->db->get_where('subscribers', ['email' => $email], 1)->num_rows() > 0) {
            set_notification('This email address is already subscribed.', 'error');
        } else {

            $db_data = array(
                'email' => $email,
                'created' => date('Y-m-d H:i:s'),
                'status' => 'Subscribe');
            $member_id = _session(FRONT_SESSION_ID);
            if ($member_id > 0) {
                $db_data['member_id'] = $member_id;
            }
            $id = save('subscribers', $db_data);
            set_notification('Successfully subscribe.', 'success');

            activity_log('Subscribe', 'subscribers', $id, $member_id);

            $msg = get_email_template($this->input->post(), 'New Subscriber');
            if ($msg->status == 'Active') {
                $emaildata = array(
                    'to' => $email,
                    'subject' => $msg->subject,
                    'message' => $msg->message
                );
                if (!send_mail($emaildata)) {
                    set_notification('Email sending failed.');
                } else {
                    set_notification('Please check your email.', 'success');
                }
            }
        }

        if ($this->input->is_ajax_request()) {
            $JSON['message'] = $JSON['response'] = strip_tags(show_validation_errors(false));
            echo json_encode($JSON);
            exit;
        } else {
            $JSON['message'] = '';
            redirectBack();
        }
    }

    function unsubscribe()
    {
        $email = getVar('email', true, false);

        $id = save('subscribers', ['status' => 'Unsubscribe'], "email='{$email}'");
        set_notification('Successfully unsubscribe.', 'success');

        activity_log('Unsubscribe', 'subscribers', $id);

        $msg = get_email_template($this->input->post(), 'Unsubscribe');
        if ($msg->status == 'Active') {
            $emaildata = array(
                'to' => $email,
                'subject' => $msg->subject,
                'message' => $msg->message
            );
            if (!send_mail($emaildata)) {
                set_notification('Email sending failed.');
            } else {
                set_notification('Please check your email.', 'success');
            }
        }

        if ($this->input->is_ajax_request()) {
            $JSON['message'] = $JSON['response'] = strip_tags(show_validation_errors(false));
            echo json_encode($JSON);
            exit;
        } else {
            $JSON['message'] = '';
            redirectBack();
        }
    }


    function ajax($action)
    {
        $RS = array();

        switch ($action) {
            case 'upload':
                $this->load->model(ADMIN_DIR . 'm_scheme_forms');
                $column = key($_FILES);
                $RS = $this->m_scheme_forms->file_upload($column);
                if ($RS['status']) {
                    $width = $height = 170;
                    $RS['thumb'] = _img(asset_url('front/scheme_forms/' . $RS['upload_data']['file_name']), $width, $height);
                }
                break;

            case 'chart':
                $_type =  getUri(4);
                switch ($_type) {
                    case 'properties-status-count':
                        $showed_status_column_data = ['Inactive','Sold'];
                        $showed_status_str = "'" . implode("','", $showed_status_column_data) . "'";
                        $where = "";
                        $user_id = _session(FRONT_SESSION_ID);
                        $SQL = "SELECT `status`, count(`status`) status_count FROM `properties` 
                                WHERE 1 {$where}
                                AND `created_by`={$user_id}
                                AND `status` IN ({$showed_status_str})
                                GROUP BY `status`";

                        $ch_rows = $this->db->query($SQL)->result();
                        $chart_data = [];
                        if (count($ch_rows) > 0) {
                            $found_status = array();
                            foreach ($ch_rows as $ch_row) {
                                $found_status[] = $ch_row->status;
                                $chart_data['legend_data'][] = $ch_row->status;
                                $chart_data['series_data_pie'][] = ['value' => $ch_row->status_count, 'name' => $ch_row->status];
                            }
                        }
                        foreach ($showed_status_column_data as $ssc) {
                            if(!in_array($ssc, $found_status)){
                                $chart_data['legend_data'][] = $ssc;
                                $chart_data['series_data_pie'][] = ['value' => "0", 'name' => $ssc];
                            }

                        }
                        $RS = $chart_data;
                        $RS['text'] = __('Properties Status Statistics');
                        $RS['subtext'] = __('');
                    break;
                    case 'properties-purpose-count':
                        $where = "";
                        $showed_purpose_column_data = ['Sale','Rent'];
                        $showed_purpose_str = "'" . implode("','", $showed_purpose_column_data) . "'";
                        $user_id = _session(FRONT_SESSION_ID);
                        $SQL = "SELECT purpose, count(purpose) AS purpose_count from properties
                                WHERE 1
                                AND created_by ={$user_id}
                                AND properties.status NOT IN('Deleted')
                                GROUP BY `purpose`";

                        $ch_rows = $this->db->query($SQL)->result();
                        $chart_data = [];
                        if (count($ch_rows) > 0) {
                            $found_purpose = array();
                            foreach ($ch_rows as $ch_row) {
                                $found_status[] = $ch_row->purpose;
                                $chart_data['legend_data'][] = $ch_row->purpose;
                                $chart_data['series_data_pie'][] = ['value' => $ch_row->purpose_count, 'name' => $ch_row->purpose];
                            }
                            foreach ($showed_purpose_column_data as $spc) {
                                if(!in_array($spc, $found_status)){
                                    $chart_data['legend_data'][] = $spc;
                                    $chart_data['series_data_pie'][] = ['value' => "0", 'name' => $spc];
                                }

                            }
                        }
                        $RS = $chart_data;
                        $RS['text'] = __('Purpose Status Statistics');
                        $RS['subtext'] = __('');
                    break;
                }

        }
        echo json_encode($RS);
    }

}


/* End of file cart.php */
/* Location: ./application/controllers/cart.php */