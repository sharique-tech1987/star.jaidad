<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Index
 * @property Cms $cms
 * @property template $template
 * @property M_blog_posts $m_blog_posts
 * @property M_users $m_users
 */


class Blog extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('frontend');
        $this->load->model('cms');
        $this->load->model(ADMIN_DIR . 'm_blog_posts');
        $this->load->model(ADMIN_DIR . 'm_users');

        $this->load->library('pagination');

        $this->listing_url = 'blogs';

    }


    public function index()
    {
        $id = intval(end(explode('-', getUri(2))));
        if($id == 0) {redirect($this->listing_url);}

        $data['row'] = $this->m_blog_posts->row($id, " AND blog_posts.status='Published'");
        if($data['row']->id == 0){
            $this->template->error_404();
        } else {
//            $data['images'] = $this->m_properties->files($id, '', 0, 0, 'ordering ASC');
//
//            $data['amenities'] = $this->m_amenities->amenities($id);
//            $data['agent'] = get_member($data['row']->created_by);

            $this->template->set_site_title($data['row']->title);
            $this->template->meta('keywords', $data['row']->title);
            $this->template->meta('description', $data['row']->title);

            $this->breadcrumb->add_item('Blogs', site_url($this->listing_url));
            $this->breadcrumb->add_item($id, '');

            $this->template->load('blog_detail', $data);
        }
    }

}