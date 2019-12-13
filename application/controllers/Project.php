<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Index
 * @property Cms $cms
 * @property Template $template
 * @property M_projects $m_projects
 * @property M_project_properties $m_project_properties
 * @property M_amenities $m_amenities
 * @property M_members $m_members
 * @property M_booking $m_booking
 */
class Project extends CI_Controller
{
    var $listing_url = '';
    var $order_table = 'booking';

    function __construct()
    {
        parent::__construct();
        $this->load->helper('frontend');
        $this->load->model('cms');
        $this->load->model(ADMIN_DIR . 'm_projects');
        $this->load->model(ADMIN_DIR . 'm_project_properties');
        $this->load->model(ADMIN_DIR . 'm_amenities');
        $this->load->model(ADMIN_DIR . 'm_members');
        $this->load->model(ADMIN_DIR . 'm_booking');

        $this->load->library('pagination');

        $this->listing_url = 'projects';
    }


    public function index()
    {

        //$id = intval(getUri(2));
        $id = intval(end(explode('-', getUri(2))));
        if($id == 0) {redirect($this->listing_url);}

        $data['row'] = $this->m_projects->row($id);
        $data['images'] = $this->m_projects->files($id, '', 0, 0, 'ordering ASC');
        $data['amenities'] = $this->m_amenities->amenities($id, '', 'Project');
        $data['project_properties'] = $this->m_project_properties->rows("AND project_id='{$id}'");

        $data['agent'] = get_member($data['row']->created_by);

//            Update Project views
        $UPDATE_CLICKS_SQL = "UPDATE projects SET `clicks` = `clicks` + 1 where `id` = {$id}";
        $this->db->query($UPDATE_CLICKS_SQL);


        $image = checkAltImg("assets/front/projects/{$data['images'][0]->filename}");
		if(!empty(get_option('wm_logo'))) {
			$wm_img = ADMIN_ASSETS_DIR . 'img/' . get_option('wm_logo');
			$full_img_url = base_url(_Image::wm($image, null, null, $wm_img));
			//$img_url = base_url(_Image::wm($image, 770, 470, $wm_img));
		} else {
			$full_img_url = base_url($image);
			//$img_url = base_url(_Image::open($image)->resize(770, 470));
		}
		$this->template->set_meta_tags($data['row']->title, $data['row']->title, $data['row']->title, $full_img_url);

        $this->breadcrumb->add_item('Projects', site_url($this->listing_url));
        $this->breadcrumb->add_item($id, '');

        $this->template->load('project_detail', $data);

    }

    function booking($id){

        $user_id = _session(FRONT_SESSION_ID);
        if(!$user_id){
            redirect('login/?redirect=' . current_url());
        }

        //$cart_type = getVar('cart_type');
        //$order_id = _session(ORDER_SESSION_KEY);

        $orders_db = array(
            //'order_number' => $order_number,
            'property_id' => $id,
            'member_id' => $user_id,
            'booking_date' => date('Y-m-d'),
            'status' => 'Process',
            'created' => date('Y-m-d H:i:s'),
            'created_by' => $user_id,
        );

        $order_id = save($this->order_table, $orders_db);

        redirect('member/account/booking');

    }


    function ajax($action, $id)
    {
        $JSON = [];
        switch ($action) {
            case 'payment_schedule':
                $data = [];
                $JSON['row'] = $data['row'] = $this->m_project_properties->row($id);
                $data['_payments'] = $this->m_project_properties->payments($id);
                $JSON['html'] = $this->load->view(theme_dir('payment_schedule_popup', true) , $data, true);
                break;
            case 'booking':
                $user_id = _session(FRONT_SESSION_ID);
                $booking_id = getUri(5);

                if($user_id > 0) {
                    $data = [];
                    $JSON['row'] = $data['row'] = $this->m_booking->row($booking_id);
                    $data['booking'] = $this->m_members->bookings($user_id, "AND booking.id='{$data['row']->id}'")[0];
                    $data['payments'] = $this->m_project_properties->booking_payments($data['row']);
                    $data['member'] = $this->m_members->row($data['row']->member_id);

                    $html = $this->load->view(admin_dir("booking/pdf"), $data, true);
                    $JSON['html'] = $html;
                } else{
                    $JSON['html'] = '<a class="btn btn-info" href="'.site_url('login/login').'">Login please!</a>';
                }
                break;
        }

        echo json_encode($JSON);
    }


}


/* End of file index.php */
/* Location: ./application/controllers/index.php */
