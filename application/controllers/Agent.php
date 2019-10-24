<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Index
 * @property Cms $cms
 * @property Template $template
 * @property M_properties $m_properties
 * @property M_amenities $m_amenities
 * @property M_users $m_users
 * @property M_members $m_members
 * @property M_agents $m_agents
 */
class Agent extends CI_Controller
{
    var $listing_url = '';
    var $order_table = 'booking';
    var $agent_type_id = 6;

    function __construct()
    {
        parent::__construct();
        $this->load->helper('frontend');
        $this->load->model('cms');
        $this->load->model(ADMIN_DIR . 'm_properties');
        $this->load->model(ADMIN_DIR . 'm_amenities');
        $this->load->model(ADMIN_DIR . 'm_members');
        $this->load->model(ADMIN_DIR . 'm_agents');

        $this->load->library('pagination');

        $this->listing_url = 'agent';

        $this->agent_type_id = intval(get_option('agent_type_id'));
    }


    public function index()
    {

        $id = intval(getUri(2));
        if($id == 0) {redirect($this->listing_url);}

        //$data['agent'] = get_member($id);
        $data['agent'] = $this->m_agents->row($id);
        $data['agent_areas'] = $this->m_agents->get_agent_areas($id);

        /*if(!empty($data['agent']->area_ids)){

        }*/

        $data['agent']->projects = $this->db->query("SELECT COUNT(projects.id) AS total FROM projects WHERE 1 AND projects.status='Active' AND projects.created_by='{$id}'")->row()->total;
        $sale_rent = $this->db->query("SELECT COUNT(DISTINCT properties.id) AS total, LOWER(purpose) AS purpose FROM properties WHERE 1 AND properties.status='Active' AND properties.created_by='{$id}' GROUP BY purpose")->result();
        if (count($sale_rent) > 0) {
            foreach ($sale_rent as $item) {
                $data['agent']->{$item->purpose . '_properties'} = $item->total;
            }
        }

        /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | Agent Properties
        *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
        $where = " AND properties.status='Active' AND properties.created_by='{$id}'";
        $limit = 16;
        $offset = 0;
        $order = 'properties.id DESC';
        if (getVar('limit') > 0) {
            $limit = intval(getVar('limit'));
        }
        if (getVar('per_page') > 0) {
            $offset = intval(getVar('per_page'));
        }

        $data['rows'] = $this->m_properties->rows($where, $limit, $offset, $order);
        $data['num_rows'] = $this->m_properties->num_rows;
        $data['total_rows'] = $this->m_properties->total_rows;
        /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
        | End
        *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/

        $this->template->set_site_title($data['agent']->title);
        $this->template->meta('keywords', $data['agent']->title);
        $this->template->meta('description', $data['agent']->title);

        $this->breadcrumb->add_item('Agent', site_url($this->listing_url));
        $this->breadcrumb->add_item($id, '');

        $this->template->load('agent_detail', $data);

    }




    function ajax($action, $id = 0)
    {
        $JSON = [];
        switch ($action) {
            case 'contact_all':
                $area_ids = (getVar('area_ids'));
                $member_id = intval(_session(FRONT_SESSION_ID));
                $agent_type_id = $this->agent_type_id;
                if($member_id > 0 && count($area_ids) > 0) {
                    $A_SQL = "SELECT users.id, users.phone, users.email, GROUP_CONCAT(agent_area_list.area_id SEPARATOR ',') AS area_ids
                                FROM users 
                                INNER JOIN agent_area_list ON(agent_area_list.agent_id = users.id)
                              WHERE users.user_type_id='{$agent_type_id}' 
                              AND users.status='Active' AND users.logedin=1
                              AND agent_area_list.area_id IN(".$area_ids.")
                              GROUP BY users.id";
                    //echo '<pre>'; print_r($A_SQL); echo '</pre>';
                    $rows = $this->db->query($A_SQL)->result();
                    $JSON['agents'] = count($rows);
                    if (count($rows) > 0) {
                        foreach ($rows as $row) {
                            foreach (explode(',', $area_ids) as $area_id) {
                                if (in_array($area_id, explode(',', $row->area_ids))) {
                                    $dbData = [
                                        'member_id' => $member_id,
                                        'agent_id' => $row->id,
                                        'area_id' => $area_id,
                                        'created' => date('Y-m-d H:i:s'),
                                    ];
                                    save('popup_contacts', $dbData);
                                }
                            }
                        }
                    }
                }
                break;
            case 'contact_done':
                $agent_id = _session(FRONT_SESSION_ID);
                $id = intval(getVar('id'));
                $row = $this->db->get_where('popup_contacts', ['id' => $id], 1)->row();


                $JSON['status'] = save('popup_contacts', ['status' => 'Inactive', 'contact_agent_id' => $agent_id, 'contact_datetime' => date('Y-m-d H:i:s')], "member_id='{$row->member_id}' AND area_id='{$row->area_id}'");

                break;
            case 'check_contact':
                $agent_id = intval(_session(FRONT_SESSION_ID));
                $agent = get_member($agent_id);

                $agent_type_id = $this->agent_type_id;
                if($agent->user_type_id == $agent_type_id){

                    $time = intval(get_option('popup_time'));

                    $SQL = "SELECT popup_contacts.id
                        , CONCAT_WS(' ', users.first_name, users.last_name) AS full_name
                        , users.photo    
                        , users.email
                        , users.phone
                        , CONCAT_WS(', ', area.area, cities.city) AS full_address
                        , area.area
                        , cities.city
                    FROM popup_contacts
                        INNER JOIN users  ON (popup_contacts.member_id = users.id)
                        INNER JOIN `area` ON (popup_contacts.area_id = area.id)
                        INNER JOIN cities  ON (area.city_id = cities.id)
                    WHERE popup_contacts.agent_id='{$agent_id}' 
                    AND popup_contacts.status='Active' 
                    AND NOW() < DATE_ADD(popup_contacts.created, INTERVAL {$time} MINUTE) 
                    GROUP BY popup_contacts.member_id, popup_contacts.agent_id, popup_contacts.area_id ";

                    //echo '<pre>'; print_r($SQL); echo '</pre>';
                    $member_rows = $this->db->query($SQL)->result();

                    $JSON['status'] = (count($member_rows));
                    ob_start();
                    foreach ($member_rows as $member_row) {
                        ?>
                        <tr>
                            <td><img src="<?php echo _img("assets/front/users/" . $member_row->photo, 48,48, USER_IMG_NA);?>" alt="<?php echo $member_row->full_name;?>"></td>
                            <td valign="middle"><?php echo $member_row->full_name;?></td>
                            <td valign="middle"><?php echo $member_row->full_address;?></td>
                            <td valign="middle" align="right"><a href="javascript: void(0);" data-id="<?php echo $member_row->id;?>" data-phone="<?php echo $member_row->phone;?>" class="btn btn-sm btn-success call-now"><i class="fa fa-phone"></i>&nbsp&nbsp;Call Now</a></td>
                        </tr>
                        <?php
                    }
                    $JSON['html'] = ob_get_clean();
                }
                break;
            case 'payment_schedule':

                break;
        }

        echo json_encode($JSON);
    }


}


/* End of file agent.php */
/* Location: ./application/controllers/agent.php */