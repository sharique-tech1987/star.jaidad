<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Index
 * @property Cms $cms
 * @property Template $template
 * @property M_users $m_users
 *
 * @property M_newsletters $m_newsletters
 */
class Inbox extends CI_Controller
{

    var $table = 'newsletters';
    var $id_field = 'id';

    function __construct()
    {
        parent::__construct();
        $this->load->helper('frontend');
        $this->load->model('cms');
        $this->load->model(ADMIN_DIR . 'm_users');

        $this->load->helper('string');
    }

    private function MSGs($user_id, $where = '', $dir = 'inbox', $start = 0){

        $start = intval($start);
        if($dir == 'inbox'){
            $where .= " AND inbox.to_id='{$user_id}'";
        } else if($dir == 'sent'){
            $where .= " AND inbox.from_id='{$user_id}'";
        } else if($dir == 'all'){
            $where .= " AND (inbox.to_id='{$user_id}' OR inbox.from_id='{$user_id}')";
        }

        $total_unread = $this->db->query("SELECT COUNT(id) as total_unread FROM inbox WHERE `status`='Unread' {$where}")->row()->total_unread;

        $limit = 20;
        $SQL = "SELECT SQL_CALC_FOUND_ROWS inbox.*
                , inbox_labels.label
                , inbox_labels.color 
                , CONCAT_WS(' ', user_to.first_name, user_to.last_name) AS to_user
                , user_to.photo AS to_photo
                
                , CONCAT_WS(' ', user_from.first_name, user_from.last_name) AS from_user
                , user_from.photo AS from_photo
            FROM inbox 
            LEFT JOIN inbox_labels ON(inbox_labels.id = inbox.label_id) 
            LEFT JOIN users AS user_to ON(user_to.id = inbox.to_id) 
            LEFT JOIN users AS user_from ON(user_from.id = inbox.from_id) 
              WHERE 1 {$where} 
          ORDER BY inbox.created DESC
          LIMIT {$start}, {$limit}";

        $rows = $this->db->query($SQL)->result();
        if (count($rows) > 0) {
            foreach ($rows as $k => $row) {

                if($dir == 'sent'){
                    $row->photo = _img('assets/front/customers/' . $row->to_photo, 300, 300, USER_IMG_NA, 'zoomCrop');
                    $row->full_name = $row->to_user;
                } else {
                    $row->photo = _img('assets/front/customers/' . $row->from_photo, 300, 300, USER_IMG_NA, 'zoomCrop');
                    $row->full_name = $row->from_user;
                }
                $row->short_message = substr($row->message, 0, 30);
                $row->message = nl2br($row->message);
                $row->time_ago = get_date_diff($row->created, date('Y-m-d H:i:s'));


                $day = '';
                if (mysql2date($row->created, 'd') == date('d')) {
                    $day = 'Today ';
                }
                if (mysql2date($row->created, 'd') == (date('d') - 1)) {
                    $day = 'Yesterday ';
                }
                $date = $day . mysql2date($row->created, 'd F, Y');
                $row->date = $date;

                if($dir == 'msg'){
                    $JSON[$dir]['row'] = $row;
                } else {
                    unset($row->message);
                    $JSON[$dir]['rows'][mysql2date($row->created, 'Y-m-d')][] = $row;
                }
            }
        }

        $JSON[$dir]['total_rows'] = $this->db->found_rows();
        $JSON[$dir]['total_unread'] = number_format($total_unread);
        $JSON[$dir]['start'] = ($start + count($rows));
        $JSON[$dir]['q'] = $SQL;

        return $JSON;
    }

    function index()
    {
        $user_id = _session(FRONT_SESSION_ID);
        if ($user_id == 0) {
            redirect('login');
        }

        /*$data['member'] = $this->m_users->info("", FRONT_SESSION_ID);

        $where = " AND to.id='{$user_id}'";
        $data['messages'] = $this->m_newsletters->messages($where, 0, 0, 'messages.id DESC');
        $data['total_rows'] = $this->m_newsletters->total_rows;

        $this->template->load('messages', $data);*/
    }

    function ajax($action, $id = 0)
    {
        $user_id = _session(FRONT_SESSION_ID);
        if ($user_id == 0 && !in_array($action, ['send_msg'])) {
            $JSON['status'] = false;
            $JSON['message'] = 'Please login!';
            echo json_encode($JSON);
            exit;
        }


        switch ($action) {
            case 'message_list':
                $JSON = $this->MSGs($user_id, '', getVar('dir'), getVar('start'));
                break;
            case 'msg':
                save('inbox', ['status' => 'Read'], "id='{$id}'");

                $where = " AND inbox.id='{$id}'";
                $JSON = $this->MSGs($user_id, $where, 'msg')['msg'];

                $attachments = json_decode($JSON['row']->attachments);
                $attach = '';
                if (count($attachments) > 0) {
                    $attach .= '<table class="table">';
                    foreach ($attachments as $attachment) {
                        $thumb_icon = thumb_icon('assets/front/newsletters/' . $attachment, 60, 60);

                        $attach .= '<tr>';
                        $attach .= '<td width="60"><a target="_blank" href="' . asset_url('front/newsletters/' . $attachment) . '"><img src="' . $thumb_icon . '" alt="" class="pull-right"></a></td>
                        <td valign="middle"><a target="_blank" href="' . asset_url('front/newsletters/' . $attachment) . '"><b class="one-line">' . $attachment . '</b></a></td>
                        <td width="40"><img src="' . asset_url('admin/images/attachment.png') . '" alt="" class="pull-right"></td>';
                        $attach .= '</tr>';
                    }
                    $attach .= '</table>';
                }
                $JSON['attachments'] = $attach;

                break;
            case 'customer_info':
                if($id == 0){
                    $JSON['customer'] = new stdClass();
                    $JSON['customer']->id = 0;
                    $JSON['customer']->company_name = 'Admin';
                    $JSON['customer']->full_name = 'Admin';
                }else {
                    $customer = $this->m_customers->customer($id);
                    unset($customer->password);
                    $JSON['customer'] = $customer;
                }
                break;
            case 'reply':
                $this->form_validation->set_rules('subject', 'Subject', 'required');
                $this->form_validation->set_rules('message', 'Message', 'required');

                if ($this->form_validation->run() !== FALSE) {
                    $msg_id = getVar('reply_id');
                    $to_id = getVar('to_id');
                    $sender_type = getVar('sender_type');

                    $subject = getVar('subject');
                    $message = getVar('message', TRUE, TRUE);

                    if($sender_type == 'Guest'){
                        $to = $this->db->get_where('guest', ['id' => $to_id])->row();
                    }else{
                        $to = get_member($to_id);
                    }

                    $from_id = intval(_session(FRONT_SESSION_ID));

                    /** @var  $upload */
                    $db_data = [
                        'sender_type' => $sender_type,
                        'to_id' => $to_id,
                        'from_id' => $from_id,
                        'subject' => $subject,
                        'message' => $message,
                        'attachments' => json_encode(getVar('attachments', TRUE, FALSE)),
                        'status' => 'Sent',
                        'created' => date('Y-m-d H:i:s'),
                    ];

                    if ($msg_id > 0) {
                        $db_data['reply_id'] = $msg_id;
                    }

                    $emaildata = array(
                        'to' => $to->email,
                        'subject' => getVar('subject'),
                        'message' => getVar('message')
                    );

                    $JSON['message'] = '';
                    if (!send_mail($emaildata)) {
                        $JSON['message'] .= '<div class="alert alert-danger" role="alert">Email sending failed!</div>';
                    }

                    if ($id = save('inbox', $db_data) > 0) {
                        $JSON['status'] = true;
                        $JSON['message'] .= '<div class="alert alert-success" role="alert">Message sent successfully!</div>';
                    } else {
                        $JSON['status'] = false;
                        $JSON['message'] .= '<div class="alert alert-danger" role="alert">Some error occurred!</div>';
                    }

                }
                break;
            case 'send':
            case 'send_msg':

                $this->form_validation->set_rules('full_name', 'Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                $this->form_validation->set_rules('phone', 'Phone', 'required');
                $this->form_validation->set_rules('message', 'message', 'required');

                if ($this->form_validation->run() !== FALSE) {


                    $subject = getVar('subject');
                    $message = getVar('message', TRUE, TRUE);

                    $msg_id = intval(getVar('msg_id'));

                    $to_id = intval(getVar('agent_id'));
                    $property_id = intval(getVar('property_id'));
                    if ($property_id > 0 && empty($subject)) {
                        $subject = "Property ({$property_id}) message!";
                    }
                    if ($property_id > 0 && $this->db->get_where('properties', ['id' => $property_id, 'created_by' => $to_id])->num_rows() == 0) {
                        $JSON['status'] = false;
                        $JSON['message'] = '<div class="alert alert-danger" role="alert">Some error occurred!!</div>';
                        //$JSON['message'] = $this->db->last_query();
                        echo json_encode($JSON);
                        return;
                    }
                    $to = get_member($to_id);

                    $from_id = intval($user_id);
                    if ($from_id == 0) {
                        $from_id = $this->db->get_where('guest', ['email' => getVar('email')])->row()->id;
                        if ($from_id == 0) {
                            $guest_data = getDbArray('guest', ['id'])['dbdata'];
                            $guest_data['created'] = date('Y-m-d H:i:s');
                            $from_id = save('guest', $guest_data);
                        }

                        $sender_type = 'Guest';
                    } else {
                        //$from = get_member($from_id);
                        $sender_type = 'Member';
                    }

                    /** @var  $upload */
                    $db_data = [
                        'sender_type' => $sender_type,
                        'to_id' => $to_id,
                        'from_id' => $from_id,
                        'subject' => $subject,
                        'message' => $message,
                        'attachments' => json_encode(getVar('attachments', TRUE, FALSE)),
                        'status' => 'Sent',
                        'created' => date('Y-m-d H:i:s'),
                    ];

                    if ($msg_id > 0) {
                        $db_data['reply_id'] = $msg_id;
                    }

                    $emaildata = array(
                        'to' => $to->email,
                        'subject' => getVar('subject'),
                        'message' => getVar('message')
                    );

                    $JSON['message'] = '';
                    if (!send_mail($emaildata)) {
                        $JSON['message'] .= '<div class="alert alert-danger" role="alert">Email sending failed!</div>';
                    }

                    if ($id = save('inbox', $db_data) > 0) {
                        $JSON['status'] = true;
                        $JSON['message'] .= '<div class="alert alert-success" role="alert">Message sent successfully!</div>';
                    } else {
                        $JSON['status'] = false;
                        $JSON['message'] .= '<div class="alert alert-danger" role="alert">Some error occurred!</div>';
                    }
                } else{
                    $JSON['status'] = false;
                    $JSON['message'] .= show_validation_errors();
                }

            break;
        }

        echo json_encode($JSON);
    }


}


/* End of file inbox.php */
/* Location: ./application/controllers/inbox.php */