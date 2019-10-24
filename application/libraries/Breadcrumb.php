<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Breadcrumb
{
    public $crumbs = array();

    public function set_home($text, $link = null)
    {
        $this->crumbs[0] = array('text' => $text, 'link' => $link);
    }

    public function add_item($text, $link = null)
    {
        $n = count($this->crumbs) + 1;
        $this->crumbs[$n] = array('text' => $text, 'link' => $link);
    }

    public function get_items()
    {
        ksort($this->crumbs);
        return $this->crumbs;
    }

    public function display($id = '', $class = '')
    {
        $ci = & get_instance();
        $data['crumbs'] = $this->get_items();
        return $ci->load->view(ADMIN_DIR . 'includes/breadcrumb', $data, true);
    }
}

/* End of file breadcrumb.php */
/* Location: ./application/libraries/breadcrumb.php */