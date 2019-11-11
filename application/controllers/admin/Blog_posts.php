<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class blog_categories * @property M_Modules $m_modules
 * @property M_cpanel $m_cpanel
 * @property M_blog_posts $module
 * @property M_blog_posts $m_blog_posts */
class Blog_posts extends CI_Controller
{
    var $table;
    var $id_field;
    var $module;
    var $module_name;
    var $_info;
    var $_route;
    var $AJAX_grid = false;
    var $where = '';

    /**
     * *****************************************************************************************************************
     * @method m_property_types __construct
     * @model M_property_types | m_property_types
     * *****************************************************************************************************************
     */
    function __construct()
    {
        parent::__construct();

        //TODO:: Check Login & Module -> property_types
        $this->m_cpanel->checkLogin();

        //TODO:: Module Name
        $this->module_name = getUri(2);

        $this->module = 'm_' . $this->module_name;
        $this->load->model(ADMIN_DIR . $this->module);
        $this->module = $this->{$this->module};

        $this->table = $this->module->table;
        $this->id_field = $this->module->id_field;

        $this->_route = $this->router->class;
        $this->_info = getModuleDetail();

        if (AJAX_GRID && $this->AJAX_grid) {
            $this->AJAX_grid = true;
        }
        //TODO:: Module Language
        load_lang($this->module_name, true);

        if(user_do_action('self_records')){
            $_user_id = user_info('id');
            $this->where = " AND {$this->table}.created_by = '{$_user_id}'";
        }

    }


    /**
     * *****************************************************************************************************************
     * @method property_types index | Grid | listing
     * *****************************************************************************************************************
     */
    public function index()
    {
        /** -------- Breadcrumb */
        $this->breadcrumb->add_item($this->_info->module_title, admin_url($this->_route));

        /** -------- Query */
        $where = $this->where;
        $query = "SELECT blog_posts.`id`
  , blog_posts.`title`
  , blog_posts.`status`
FROM blog_posts 
LEFT JOIN blog_categories ON(blog_categories.id = blog_posts.category_id)
WHERE 1 {$where}";
        $query .= getFindQuery($query);

        $data['query'] = $query;
        _session($this->module_name . '_export_query', $query);

        if ($this->AJAX_grid) {
            $response = $this->ajax_grid($query);
            $data['grid_script'] = $response['grid_script'];
        }

        if ($this->input->is_ajax_request() && $this->AJAX_grid) {
            echo json_encode($response['json']);
        } else {
            $this->admin_template->load($this->module_name . '/grid', $data);
        }

    }

    /**
     * *****************************************************************************************************************
     * @method property_types ajax_grid | AJAX Grid | AJAX listing
     * *****************************************************************************************************************
     */
    private function ajax_grid($query){}


    /**
     * *****************************************************************************************************************
     * @method property_types form
     * *****************************************************************************************************************
     */
    public function form()
    {
        $id = intval(getUri(4));
        $data = [];

        if ($id > 0) {
            $where = $this->where;
            $data['row'] = $this->module->row($id, $where);
            if ($data['row']->{$this->id_field} == 0) {
                $this->admin_template->not_found();
            }

        }

        $this->breadcrumb->add_item($this->_info->module_title, admin_url($this->_route));
        $this->breadcrumb->add_item(($id > 0) ? "Edit -> id:[$id]" : 'Add New');

        $this->admin_template->load($this->module_name . '/form', $data);
    }


    /**
     * *****************************************************************************************************************
     * @method property_types add | Insert
     * *****************************************************************************************************************
     */
    public function add()
    {
        if ($this->module->validate()) {
            if(isset($_POST['comment_status']) && $_POST['comment_status'] == 'on'){
                $_POST['comment_status'] = 'Open';
            }else{
                $_POST['comment_status'] = 'Closed';
            }

            if ($id = $this->module->insert()) {
                set_notification(__('Record has been inserted'), 'success');
            } else {
                set_notification(__('Some error occurred'), 'error');
            }

            $__redirect = (!empty(getVar('__redirect')) ? getVar('__redirect') : admin_url($this->_route . "/form/{$this->module->_id}"));
            redirect($__redirect);
        } else {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        }
    }


    /**
     * *****************************************************************************************************************
     * @method property_types update
     * *****************************************************************************************************************
     */
    public function update()
    {
        $id = intval(getUri(4));

        if ($this->module->validate()) {
            if(isset($_POST['comment_status']) && $_POST['comment_status'] == 'on'){
                $_POST['comment_status'] = 'Open';
            }else{
                $_POST['comment_status'] = 'Closed';
            }

            if ($this->module->update($id)) {
                set_notification(__('Record has been updated'), 'success');
            } else {
                set_notification(__('Some error occurred'), 'error');
            }

            $__redirect = (!empty(getVar('__redirect')) ? getVar('__redirect') : admin_url($this->_route . "/form/{$this->module->_id}"));
            redirect($__redirect);
        } else {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        }
    }


    /**
     * *****************************************************************************************************************
     * @method Status
     * @unlink Delete Files (unlink)
     * *****************************************************************************************************************
     */
    function status()
    {
        $IDs = intval(getUri(4));
        if (empty($IDs)) {
            $IDs = dbEscape(join(',', getVar('ids', false, false)));
        }

        $status = getVar('status');
        $data = array('status' => $status);

        $where = $this->id_field . " IN({$IDs}) " . $this->where;
        if (save($this->table, $data, $where)) {
            set_notification(__('Status has been updated'), 'success');

        } else {
            $db_error = $this->db->error()['message'];
            developer_log($this->table, $db_error);

            set_notification(__('Some error occurred'), 'error');
        }

        activity_log(getUri(3), $this->table, $IDs);

        redirect(admin_url($this->_route));
    }


    /**
     * *****************************************************************************************************************
     * @method property_types delete
     * *****************************************************************************************************************
     */
    public function delete()
    {
        $IDs = intval(getUri(4));
        if (empty($IDs)) {
            $IDs = dbEscape(join(',', getVar('ids', false, false)));
        }
        $where = $this->id_field . " IN({$IDs})";

        $delete_files = [
        ];
        if (delete_rows($this->table, $where, true, '', '', $delete_files)) {
            set_notification(__('Record\'s has been deleted'), 'success');
        } else {
            $db_error = $this->db->error()['message'];
            developer_log($this->table, $db_error);

            set_notification(__('Some error occurred!'), 'error');
        }

        activity_log(getUri(3), $this->table, $IDs);

        redirect(admin_url($this->_route));
    }


    /**
     * *****************************************************************************************************************
     * @method property_types view | Record
     * *****************************************************************************************************************
     */
    public function view(){}

    /**
     * *****************************************************************************************************************
     * @method property_types AJAX actions
     * *****************************************************************************************************************
     */
    function AJAX($action, $id){}


    /**
     * *****************************************************************************************************************
     * @method property_types import
     * *****************************************************************************************************************
     */
    public function import(){}

    /**
     * *****************************************************************************************************************
     * @method property_types export
     * @type csv & xml
     * *****************************************************************************************************************
     */
    function export(){}


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
            $dir = "assets/front/{$this->table}/";
            if (!is_dir($dir)) mkdir($dir);
            $id = intval(getVar('id'));
            /*if ($id > 0) { $dir .= $id . '/'; mkdir($dir); }*/

            $config['upload_path'] = './' . $dir;
            $config['allowed_types'] = '';

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $fileinfo = $this->upload->data();
                $output['result']['filename'] = $fileinfo['file_name'];


                $thumb_file = _img(base_url(file_icon($dir . $fileinfo['file_name'])), 200, 200);

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
            redirect(admin_url($this->_route));
        }
    }

    function duplicate(){}

}

/* End of file blog_categories.php */
/* Location: ./application/controllers/admin/blog_categories.php */