<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class M_login
 * @property  M_users $m_users
 */
class M_login extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->model(ADMIN_DIR . 'm_users');
    }

    function validate($options=array())
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if($options["chk_captcha"]) {
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }


    function chklogin($username, $password, $where = '')
    {
        $where .= " AND username='{$username}' AND password='{$password}' AND status='Active'";
        $row = $this->m_users->row(0, $where);
        if($row->id > 0){
            return $row;
        } else {
            return false;
        }
    }

    function set_login($id, $login = 1){
        save($this->m_users->table, ['logedin' => $login], "id={$id}");
    }
}

/* End of file m_events.php */
/* Location: ./application/models/m_events.php */