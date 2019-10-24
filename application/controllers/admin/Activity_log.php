<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class activity_log * @property M_Modules $m_modules
 * @property M_cpanel $m_cpanel
 * @property M_activity_log $m_activity_log */
class Activity_log extends CI_Controller
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
     * @method m_activity_log __construct
     * @model M_activity_log | m_activity_log 
     * *****************************************************************************************************************
     */
    function __construct()
    {
        parent::__construct();

        //TODO:: Check Login & Module -> activity_log
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

        $this->where = "";

        if (AJAX_GRID && $this->AJAX_grid) {
            $this->AJAX_grid = true;
        }
        //TODO:: Module Language
        load_lang($this->module_name, true);
    }


    /**
     * *****************************************************************************************************************
     * @method activity_log index | Grid | listing
     * *****************************************************************************************************************
     */
    public function index()
    {
        /** -------- Breadcrumb */
        $this->breadcrumb->add_item($this->_info->module_title, admin_url($this->_route));

        /** -------- Query */
        $where = $this->where;
        $query = "SELECT
            activity_log.id
            , activity_log.activity_name
            , activity_log.`table` 
            , activity_log.activity_datetime
            , users.username
            , activity_log.rel_id
        FROM {$this->table} AS activity_log
        LEFT JOIN users ON (users.id = activity_log.user_id)
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
     * @method activity_log ajax_grid | AJAX Grid | AJAX listing
     * *****************************************************************************************************************
     */
    private function ajax_grid($query)
    {

        /*** -------- Ajax OR HTML */
        $grid = new ajax_grid();
        $grid->status_column_data = get_enum_values($this-table, 'status');
        $grid->grid_buttons = ['edit', 'delete', 'status' => ['status' => 'status']];
        $grid->custom_func = array('status' => 'status_field', 'ordering' => 'ordering_input');
        $grid->init($query);
        /** --------  Script Content */
        $grid->dt_column(['grid_actions' => ['locked' => "{right: 'xl'}", 'overflow' => 'visible']]);
        $grid->dt_column(['id' => ['title' => 'ID', 'width' => '20']]);
        $grid->dt_column(['ordering' => ['width' => '60', 'textAlign' => 'center']]);
        $data['record_selection'] = $grid->record_selection();
        $data['grid_script'] = $grid->generate_script();
        /** --------  End Script Content */
        $data['json'] = $grid->data();
        return $data;
    }


    /**
     * *****************************************************************************************************************
     * @method activity_log form
     * *****************************************************************************************************************
     */
    public function form()
    {
        $id = intval(getUri(4));
        $data = [];

        if ($id > 0) {
            $where = $this->where;
            $row = $data['row'] = $this->module->row($id, $where);
            if ($row->{$this->id_field} == 0) {
                $this->admin_template->not_found();
            }
        }

        $this->breadcrumb->add_item($this->_info->module_title, admin_url($this->_route));
        $this->breadcrumb->add_item(($id > 0) ? 'Edit' : 'Add New');

        $this->admin_template->load($this->module_name . '/form', $data);
    }


    /**
     * *****************************************************************************************************************
     * @method activity_log add | Insert
     * *****************************************************************************************************************
     */
    public function add()
    {

        if ($this->module->validate()) {

            if ($id = $this->module->insert()) {
                set_notification(__('Record has been inserted'), 'success');
            } else {
                set_notification(__('Some error occurred'), 'error');
            }

            redirect(admin_url($this->_route));
        } else {
            $data['row'] = array2object($this->input->post());
            $this->admin_template->load($this->module_name . '/form', $data);
        }
    }


    /**
     * *****************************************************************************************************************
     * @method activity_log update
     * *****************************************************************************************************************
     */
    public function update()
    {
        $id = intval(getUri(4));

        if ($this->module->validate()) {

            if ($this->module->update($id)) {
                set_notification(__('Record has been updated'), 'success');
            } else {
                set_notification(__('Some error occurred'), 'error');
            }

            redirect(admin_url($this->_route));
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

        $act_name = getUri(3) . ' ' . $this->table;
        activity_log($act_name, $this->table, $IDs);

        redirect(admin_url($this->_route));
    }


    /**
     * *****************************************************************************************************************
     * @method activity_log delete
     * *****************************************************************************************************************
     */
    public function delete()
    {
        $IDs = intval(getUri(4));
        if (empty($IDs)) {
            $IDs = dbEscape(join(',', getVar('ids', false, false)));
        }
        $where = $this->id_field . " IN({$IDs})";

        $delete_files = array(
            'icon' => ASSETS_DIR . 'front/activity_log/'
        );
        if (delete_rows($this->table, $where, true, '', '', $delete_files)) {
            set_notification(__('Record\'s has been deleted'), 'success');
        } else {
            $db_error = $this->db->error()['message'];
            developer_log($this->table, $db_error);

            set_notification(__('Some error occurred'), 'error');
        }

        $act_name = getUri(3) . ' ' . $this->table;
        activity_log($act_name, $this->table, $IDs);

        redirect(admin_url($this->_route));
    }


    /**
     * *****************************************************************************************************************
     * @method activity_log view | Record
     * *****************************************************************************************************************
     */
    public function view()
    {
        $id = intval(getUri(4));

        $this->breadcrumb->add_item($this->_info->module_title, admin_url($this->_route));
        $this->breadcrumb->add_item("View -> id:[$id]");

        if ($id > 0) {
            $where = $this->where;
            $data['row'] = $this->module->row($id, $where);

            if ($data['row']->{$this->id_field} == 0) {
                $this->admin_template->not_found();
            }

        }

        //activity_log(getUri(3), $this->table, $id);

        $data['title'] = $this->_info->module_title;
        $data['config']['buttons'] = ['new', 'edit', 'delete', 'refresh', 'print', 'back'];

        //$this->admin_template->load($this->module_name . '/view', $data);
        $this->admin_template->load('includes/record_view', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method activity_log AJAX actions
     * *****************************************************************************************************************
     */
    function AJAX($action, $id)
    {
        switch ($action) {
            case 'delete_img':
                $del_img = array('icon' => ASSETS_DIR . "front/{$this->table}/");
                delete_rows($this->table, "$this->id_field='{$id}'", false, '', key($del_img), $del_img);
                break;
            case 'ordering':
                $ordering = getVar('ordering');
                save($this->table, ['ordering' => $ordering[$id]], "id='{$id}'");
                break;
        }
    }


    /**
     * *****************************************************************************************************************
     * @method activity_log import
     * *****************************************************************************************************************
     */
    public function import()
    {

        $data = array();
        if (getVar('import')) {
            $path = ASSETS_DIR . 'csv/';
            if (!is_dir($path)) {
                mkdir($path);
            }

            $import = new Import();
            $import->type = getVar('type');
            $import->table = $this->table;
            $import->upload_path = $path;
            $import->file_field = 'file';
            $data_imp = $import->do_import();
            $data += $data_imp;

        }

        $this->breadcrumb->add_item($this->_info->module_title, admin_url($this->_route));
        $this->breadcrumb->add_item('Import');

        $this->admin_template->load('includes/import_view', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method activity_log export
     * @type csv & xml
     * *****************************************************************************************************************
     */
    function export()
    {

        $type = $this->uri->segment(4);
        $this->load->dbutil();
        $query = _session($this->module_name . '_export_query');
        if (!empty($query)) {
            _session($this->module_name . '_export_query', null);
        } else {
            $query = "SELECT * FROM {$this->table} WHERE 1 " . $this->where;
        }

        $query = $this->db->query($query);


        $dir = dirname(__FILE__) . "/";

        $filename = "{$dir}{$this->table}.{$type}";
        switch ($type) {
            case 'xml':
                $config = array(
                    'root' => 'rows',
                    'element' => 'row',
                    'newline' => "\n",
                    'tab' => "\t"
                );

                $xml = $this->dbutil->xml_from_result($query, $config);
                write_file($filename, $xml);
                break;
            default:
                $csv = $this->dbutil->csv_from_result($query);
                write_file($filename, $csv);
        }

        fileDownload($filename);
        @unlink($filename);

        redirect(admin_url($this->_route));
    }


    public function images_upload()
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
            $dir = 'assets/front/{$this->table}/';
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

                $ext = substr($fileinfo['file_ext'], 1);
                $thumb_file = $icon_file = ADMIN_ASSETS_DIR . 'img/file_icons/' . $ext . '.png';
                if (in_array($ext, explode('|', IMG_EXTS))) {
                    $thumb_file = image_thumb($dir . $fileinfo['file_name'], 200, 150);
                }
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

}

/* End of file activity_log.php */
/* Location: ./application/controllers/admin/activity_log.php */