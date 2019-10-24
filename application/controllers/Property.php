<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Index
 * @property Cms $cms
 * @property M_area $m_area
 * @property template $template
 * @property M_properties $m_properties
 * @property M_amenities $m_amenities
 * @property M_users $m_users
 * @property M_area_reviews $m_area_reviews
 */
class Property extends CI_Controller
{
    var $listing_url = '';

    function __construct()
    {
        parent::__construct();
        $this->load->helper('frontend');
        $this->load->model('cms');
        $this->load->model(ADMIN_DIR . 'm_properties');
        $this->load->model(ADMIN_DIR . 'm_amenities');
        $this->load->model(ADMIN_DIR . 'm_users');

        $this->load->library('pagination');

        $this->listing_url = 'properties';

    }


    public function index()
    {
        $id = intval(end(explode('-', getUri(2))));
        if($id == 0) {redirect($this->listing_url);}

        $data['row'] = $this->m_properties->row($id, " AND properties.status NOT IN('Deleted', 'Hidden')");
        if($data['row']->id == 0){
            $this->template->error_404();
        } else {
            $data['images'] = $this->m_properties->files($id, '', 0, 0, 'ordering ASC');

            $data['amenities'] = $this->m_amenities->amenities($id);
            $data['agent'] = get_member($data['row']->created_by);

            $this->template->set_site_title($data['row']->title);
            $this->template->meta('keywords', $data['row']->title);
            $this->template->meta('description', $data['row']->title);

            $this->breadcrumb->add_item('Properties', site_url($this->listing_url));
            $this->breadcrumb->add_item($id, '');

            $this->template->load('property_detail', $data);
        }
    }

    function properties(){
        $file_name = $link = 'properties';
        /*---------------------------------------------------------------------------------------*/
        $where = " AND friendly_url='" . dbEscape($link) . "'";
        $data['page'] = get_page(null, $where);
        $data['author'] = get_member($data['page']->created_by);

        $this->template->set_site_title($data['page']->meta_title);
        $this->template->meta('keywords', $data['page']->meta_keywords);
        $this->template->meta('description', $data['page']->meta_description);

        $this->breadcrumb->add_item($data['page']->title, get_permalink($data['page']->friendly_url));
        /*---------------------------------------------------------------------------------------*/
        if (file_exists(get_template_directory() . $file_name) != false) {
            $this->template->load($file_name, $data);
        } else if ($data['page']->password) {
            //
        } else if (is_object($data['page']) && $data['page']->id > 0) {
            $template = ($data['page']->template == 'default') ? 'page' : $data['page']->template;
            $this->template->load($template, $data);
        } else {
            $this->template->error_404();
        }
    }

    function update($id){
        $member_id = _session(FRONT_SESSION_ID);
        if($member_id == 0){
            redirect('login?redirect=' . current_url());
        }

        $this->add();
    }


    function add(){

        $id = intval(getVar('id'));
        if($id == 0){
            $id = intval(getUri(3));
        }

        if ($this->m_properties->validate() && $this->input->server('REQUEST_METHOD') == 'POST') {

            $member_id = _session(FRONT_SESSION_ID);
            $member_entry = getVar('member_entry');
            if($member_id == 0){
                if($member_entry == 'Existing'){
                    $this->load->model(ADMIN_DIR . 'm_login');

                    $username = getVar('email');
                    $password = encryptPassword(getVar('password'));
                    //$remember = getVar('remember');
                    $result = $this->m_login->chklogin($username, $password, " AND user_types.login IN('Frontend', 'Both')");
                    if ($result) {
                        $member_id = $result->id;
                        $this->session->set_userdata(array(
                            FRONT_SESSION_ID => $result->id,
                            'username' => $result->username,
                            'email' => $result->email,
                            'user_type_id' => $result->user_type_id,
                            //'user_info' => $result,
                        ));
                    } else {
                        set_notification(__('Incorrect username or password'));
                        redirectBack();
                    }
                } else {
                    $user_type_id = get_option('client_type_id');

                    $_POST['username'] = $_POST['email'];
                    if ($member_id = $this->m_users->insert(['user_type_id' => $user_type_id])) {
                        set_notification(__('User has been created!'), 'success');

                        activity_log('Registration', 'users', $member_id, $member_id);
                        # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        # registration_email
                        $member = $this->m_users->row($member_id);
                        $member->password = $_POST['password'];
                        $msg = get_email_template($member, 'New Account');
                        if ($msg->status == 'Active') {
                            $emaildata = array(
                                'to' => $member->email,
                                'subject' => $msg->subject,
                                'message' => $msg->message
                            );
                            if (!send_mail($emaildata)) {
                                set_notification('Email sending failed.', 'danger');
                            } else {
                                set_notification('Please check your email for username & password!','success');
                            }
                        }
                    } else {
                        set_notification(__('Some error occurred'), 'error');
                    }

                }
            }

            $db_data['created_by'] = $member_id;
            $db_data['modified_by'] = $member_id;
            if ($this->m_properties->update($id, $db_data) && $id > 0) {

                set_notification(__('Property has been updated'), 'success');
                $this->m_properties->update_files_DB($id);
                redirectBack();


            } else if ($id = $this->m_properties->insert($db_data)) {

                set_notification(__('Property has been submitted'), 'success');
                $this->m_properties->update_files_DB($id);
                redirect('member/account/properties');

            } else {
                set_notification(__('Some error occurred'), 'error');

                redirectBack();
            }


        }

        $data = [];

        if ($id > 0) {
            $where = $this->where;
            $data['row'] = $this->m_properties->row($id, $where);
            if ($data['row']->{$this->m_properties->id_field} == 0) {
                $this->template->error_404();
            }

            $data['files'] = $this->m_properties->files($id, '', 0, 0, 'ordering ASC');

            $data['page']->title = 'Edit Property';
        } else{
            $data['page']=get_page(NULL,'and pages.friendly_url="add-new-property"');
            //$data['page']->title = 'Add New Property';
        }

        $this->template->set_site_title($data['page']->title);
        $this->template->meta('keywords', $data['page']->title);
        $this->template->meta('description', $data['page']->title);

        $this->breadcrumb->add_item('Properties', site_url($this->listing_url));

        $this->template->load('property_form', $data);
    }


    function area_reviews($area_id = 0){
        $this->load->model([ADMIN_DIR . 'm_area', ADMIN_DIR . 'm_area_reviews']);

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            if ($this->m_area_reviews->validate()) {
                if ($id = $this->m_area_reviews->insert()) {
                    set_notification(__('Review has been submitted. It will be shown after approval!'), 'success');
                } else {
                    set_notification(__('Some error occurred'), 'error');
                }
                redirectBack();
            } else {
                $data['post_review'] = array2object($this->input->post());
            }
        }


        $data['row'] = $this->m_area->row($area_id);

        $limit = 30;
        $offset = 0;
        if (getVar('limit') > 0) {
            $limit = intval(getVar('limit'));
        }
        if (getVar('per_page') > 0) {
            $offset = intval(getVar('per_page'));
        }
        $data['limit'] = $limit;
        $data['offset'] = $offset;
        $data['reviews'] = $this->m_area->get_reviews($area_id, $limit, $offset);
        $data['total_rows'] = $data['reviews']['total_reviews'];


        $data['page']->show_title = true;
        $data['page']->title = $data['row']->area . " Review's";
        $data['page']->thumbnail = 'page-title.jpg';
        $this->template->set_site_title($data['row']->area);
        $this->template->meta('keywords', $data['row']->area);
        $this->template->meta('description', $data['row']->area);

        $this->breadcrumb->add_item($data['row']->city, site_url('properties/' . url_title($data['row']->city, '_')));
        $this->breadcrumb->add_item($data['row']->area, '');


        $this->template->load('area_reviews', $data);
    }

    function ajax($action){

        $JSON = [];
        switch ($action){
            case 'min_max_price':
                $purpose = getVar('purpose');
                $row = $this->db->query("SELECT MIN(price) AS `min` ,  MAX(price) AS `max` FROM `properties` WHERE `purpose`='{$purpose}'")->row_array();
                $JSON = $row;
                //$JSON['sql'] = $this->db->last_query();
                $_COOKIE['_price'] = $JSON;
                echo json_encode($JSON);
            break;
            case 'convert_area_unit':
                $_area = $this->db->query("SELECT MIN(square_meter) AS `min` ,  MAX(square_meter) AS `max` FROM `properties`")->row_array();
                $from = 'square meter';
                $to = (getVar('_area_unit'));//$_COOKIE['area_unit'];

                $JSON['min'] = number_format(area_conversion($_area['min'], $from, $to), 0, '', '');
                $JSON['max'] = number_format(area_conversion($_area['max'], $from, $to), 0, '', '');
                $JSON['short_area_unit'] = short_area_unit($to);

                $_COOKIE['_area'] = $JSON;
                $_COOKIE['area_unit'] = $to;
                echo json_encode($JSON);
            break;
            case 'show_number':
                $id = intval(getVar('id'));

                if($id > 0){
                    $data['row'] = $this->m_properties->row($id, " AND properties.status NOT IN('Deleted', 'Hidden')");
                    $data['agent'] = get_member($data['row']->created_by);

                    $JSON['phone'] = $data['agent']->phone;
                    echo json_encode($JSON);
                }
            break;
            case 'city_area':
                $_where = '';
                $city_id = intval(getVar('id'));
                if($city_id > 0){
                    $SQL = "SELECT id, `area` AS `text` FROM area WHERE city_id='{$city_id}' {$_where}";
                    echo '<option value="">- Select -</option>';
                    echo selectBox($SQL);
                    /*$rows = $this->db->query($SQL)->result();
                    $JSON['results'] = $rows;
                    echo json_encode($JSON);*/
                }
            break;
            case 'search_area':
                $q = getVar('q');
                $city_id = getVar('city_id');
                $_q = explode(' ', $q);

                $_where = '';
                //$_where .= " AND (area.area LIKE '%{$q}%')";
                if (count($_q) > 0) {
                    $_where .= " AND (";
                    foreach ($_q as $k => $item) {
                        if($k > 0){
                            $_where .= " AND ";
                        }
                        $_where .= " area.area LIKE '%{$item}%' ";
                    }
                    $_where .= " AND REPLACE(area.area, ' ', '') LIKE '%{$item}%' ";
                    $_where .= ")";
                }

                $SQL = "SELECT id, `area` AS `text` FROM area WHERE city_id='{$city_id}' {$_where}";

                $rows = $this->db->query($SQL)->result();
                $JSON['results'] = $rows;
                //$JSON['sql'] = $SQL;
                echo json_encode($JSON);
            break;
        }
    }


    public function file_upload()
    {

        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if (!empty($_FILES)) {
            /**
             * Directory
             */
            //$dir = "assets/front/properties/";
            $dir = 'assets/front/properties/';
            if (!is_dir($dir)) mkdir($dir);
            $id = intval(getVar('id'));
            /*if ($id > 0) { $dir .= $id . '/'; mkdir($dir); }*/

            $config['upload_path'] = './' . $dir;
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $fileinfo = $this->upload->data();
                $output['result']['filename'] = $fileinfo['file_name'];

                $thumb_file = _img(base_url(file_icon($dir . $fileinfo['file_name'], true)), 200, 200);

                $output['result']['thumb_url'] = $thumb_file;
                $output['result']['image_url'] = site_url($dir . $fileinfo['file_name']);
                $output['result']['title'] = substr(str_replace(array('-', '_'), array(' ', ' '), $fileinfo['file_name']), 0, -(strlen($fileinfo['file_ext'])));
                $output['result']['size'] = $fileinfo['file_size'];
                $output['result']['file_ext'] = $fileinfo['file_ext'];
            } else {
                $output['error']['filename'] = $_FILES['file']['name'];
                $output['error']['message'] = $this->upload->display_errors();
            }

            echo json_encode($output);
        } else {
            redirectBack();
        }
    }


}


/* End of file index.php */
/* Location: ./application/controllers/index.php */