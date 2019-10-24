<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_template
{
    private $tpl_data = array();
    private $ci;

    function __construct(){
        $this->ci =& get_instance();
    }


    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Assign Template Variable
     * -----------------------------------------------------------------------------------------------------------------
     */

	public function assign($name, $value)
    {
        $this->tpl_data[$name] = $value;
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Load Template
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function ajax($tpl_name, $data = array())
    {
        if(count($data) > 0) { $this->tpl_data = array_merge($this->tpl_data, $data); }
        $data['content'] = $this->ci->load->view(ADMIN_DIR . $tpl_name, $this->tpl_data, true);

        $this->ci->load->view(ADMIN_DIR . 'admin_ajax_template', $data);
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Load Template
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function load($tpl_name, $data = array())
    {

        if(count($data) > 0) { $this->tpl_data = array_merge($this->tpl_data, $data); }
        $data['content'] = $this->ci->load->view(ADMIN_DIR . $tpl_name, $this->tpl_data, true);

        $this->ci->load->view(ADMIN_DIR . 'admin_template', ($data));
    }

    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Error Templates
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function not_found()
    {
        $data['error_no'] = "Not Found";
        $data['error_title'] = "Record Not Found!";
        $data['error_message'] = "- Oops, an error has occurred. Record Not Found! -";

        $data['content'] = $this->ci->load->view(ADMIN_DIR . 'error', $data, true);
        $output = $this->ci->load->view(ADMIN_DIR . 'admin_template', ($data), true);
        exit($output);
        /*$output = $this->ci->load->view(ADMIN_DIR . 'error', $data, true);
        exit($output);*/
    }

    public function error_403()
    {
        $data['error_no'] = "403";
        $data['error_title'] = "403 Access Forbidden";
        $data['error_message'] = "Sorry, you do not have privileges to access this page.";
        $output = $this->ci->load->view(ADMIN_DIR . 'error', $data, true);
        exit($output);
    }

    public function error_404()
    {
        $data['error_no'] = "404";
        $data['error_title'] = "404 Page Not Found";
        $data['error_message'] = "The page you requested was not found.";
        $output = $this->ci->load->view(ADMIN_DIR . 'error', $data, true);
        exit($output);
    }
}

/* End of file admin_template.php */
