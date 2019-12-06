<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Index
 * @property Cms $cms
 * @property Template $template
 * @property Breadcrumb $breadcrumb
 * @property Jobs $jobs
 *
 */
class Page extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('frontend');
    }


    public function index()
    {
        //$page_name = uri_string();
        $pages = $this->uri->segments;
        $page_name = end($pages);

        if (!empty($page_name) && $page_name != 'index') {
            $class_method = array($this, str_replace('-', '_', $page_name));
            if (is_callable($class_method)) {
                call_user_func($class_method);
            } else {
                $this->page($page_name);
            }
        }else{
            $this->home();
        }
    }

    public function home()
    {
        $front_id = get_option('front_page');
        $data['index'] = true;
        $data['page'] = get_page($front_id);
        $data['author'] = get_member($data['page']->created_by);

		$this->template->set_meta_tags($data['page']->meta_title, $data['page']->meta_keywords, $data['page']->meta_description);

        $template = ($data['page']->template == 'default') ? 'index' : $data['page']->template;
        $this->template->load($template, $data);
    }

    public function page($menu_link = '')
    {
        $menu_link = (!empty($menu_link) ? $menu_link : end($this->uri->segment_array()));
        $link_ext = explode('.', $menu_link);
        $link = '';
        $ext = '';
        if (count($link_ext) > 1) {
            $ext = end($link_ext);
            $dot_ext = '.' . end($link_ext);
            $link = str_replace($dot_ext, '', $menu_link);
            $file_name = $link . '.php';
        } else {
            $link = $link_ext[0];
            $temp_name = $link;
            $file_name = $temp_name . '.php';
        }


        /*---------------------------------------------------------------------------------------*/
        $where = " AND friendly_url='" . dbEscape($link) . "'";
        $data['page'] = get_page(null, $where);
        $data['author'] = get_member($data['page']->created_by);

		$this->template->set_meta_tags($data['page']->meta_title, $data['page']->meta_keywords, $data['page']->meta_description);

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


    function do_contact()
    {
        /*if (empty($_SESSION['captcha']) || trim(strtolower($this->input->post('captcha'))) != $_SESSION['captcha']) {
            $mailmsg = "<p class='alert alert-error'>Invalid captcha, Please try again.</p>";
            $this->session->set_flashdata('contact_error', $mailmsg);
            redirect($this->input->server('HTTP_REFERER'));
        }*/

        $msg = "Name: " . getVar('name') . " \r\n";
        $msg .= "Email: " . getVar('email') . " \r\n";
        //$msg .= "Tel: " . getVar('phone') . " \r\n";
        //$msg .= "Country: " . getVar('country') . " \r\n";
        //$msg .= "City: " . getVar('city') . " \r\n\r\n";
        $msg .= "Subject: " . getVar('subject') . " \r\n";
        $msg .= "Message: " . (getVar('message', TRUE, FALSE)) . " \r\n";

        $from = getVar('email');
        $subject = 'Contact Form';


        //$to = get_option('email_cc');
        $contact_email = get_option('contact_email');

        $this->load->library('email');
        $this->email->from($from, getVar('name'));
        $this->email->to($contact_email);
        //$this->email->bcc('developer.adnan@gmail.com');
        $this->email->subject($subject);
        $this->email->message($msg);
        //echo $this->email->print_debugger();


        if (!$this->email->send()) {
            set_notification('Email sending failed, Please try again.');
        } else {
            set_notification('Message sent successfully!', 'success');
        }
        redirectBack();
    }


    /*function careers(){
        $this->load->model('jobs');
        $jobs = $this->jobs->get_jobs();
        echo '<pre>';print_r($jobs);echo '</pre>';
    }*/

}


/* End of file index.php */
/* Location: ./application/controllers/index.php */
