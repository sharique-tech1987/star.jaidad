<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Dashboard
 * @property m_cpanel $m_cpanel
 */
class Search_statistics extends CI_Controller
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
        $data = [];
        $this->admin_template->load('search_statistics/search_statistics', $data);
    }


    function teacher_registration(){
die('teacher_registration');
        $data = [];
        $this->admin_template->load('sms_teachers/teacher_form', $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */