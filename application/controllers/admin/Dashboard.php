<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Dashboard
 * @property m_cpanel $m_cpanel
 */
class Dashboard extends CI_Controller
{

    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $module_title;
    var $module_route;


    function __construct()
    {
        parent::__construct();

        //TODO:: Check Login & Module
        $this->m_cpanel->checkLogin();

        //TODO:: Module Name
        $this->module_name = getUri(2);

        /*$this->module = 'm_' . $this->module_name;
        $this->load->model(ADMIN_DIR . $this->module);
        $this->module = $this->{$this->module};

        $this->table = $this->module->table;
        $this->id_field = $this->module->id_field;*/

        $this->module_route = $this->router->class;
        $this->module_title = getModuleDetail()->module_title;

        //TODO:: Module Language
        load_lang($this->module_name, true);
    }


    public function index()
    {
        $query = "SELECT *, 
                IF(FIND_IN_SET(SUBSTRING_INDEX(icon, '.', -1), 'png,jpg,jpeg') > 0, 
                CONCAT('<img width=\"64\" height=\"64\" src=\"" . asset_url('uploads/icons', true) . "/', icon , '\" alt=\"',module_title,'\">'), 
                CONCAT('<i class=\"m-menu__link-icon',icon,'\"></i>')) as icon
                FROM `modules` WHERE `status`='1' AND `show_on_menu`=1 AND id IN (SELECT `module_id` FROM `user_type_module_rel` WHERE user_type_id='" . intval($this->session->userdata('user_type')) . "') ORDER BY parent_id,ordering ASC";
        $modules = $this->db->query($query)->result();

        $data['modules'] = $modules;

        $this->admin_template->load('dashboard/dashboard', $data);
    }


    function teacher_registration(){
die('teacher_registration');
        $data = [];
        $this->admin_template->load('sms_teachers/teacher_form', $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */