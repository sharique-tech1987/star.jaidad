<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Login
 * @property M_Modules $m_modules
 * @property M_Modules $module
 * @property M_cpanel $m_cpanel
 */
class Modules extends CI_Controller
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
     * @method m_modules __construct
     * @model M_modules | m_modules
     * *****************************************************************************************************************
     */
    function __construct()
    {
        parent::__construct();

        //TODO:: Check Login & Module
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
     * @method modules index | Grid | listing
     * *****************************************************************************************************************
     */
    public function index()
    {
        /** -------- Breadcrumb */
        $this->breadcrumb->add_item($this->_info->module_title, admin_url($this->_route));

        /** -------- Query */
        $where = $this->where;
        $query = "SELECT
            modules.id
            -- , modules.module
            , modules.module_title
            , IFNULL(p_modules.module_title, 'Main') AS parent
            -- , modules.show_on_menu
            , modules.actions
            , modules.icon
            , modules.created
            , modules.ordering
            , IF(modules.status = 1, 'Active', 'Inactive') AS status
        FROM modules
            LEFT JOIN modules AS p_modules ON (modules.parent_id = p_modules.id) 
        WHERE 1 
        {$where}";
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
            //$this->admin_template->load($this->module_name . '/ajax_grid', $data);
        }

    }

    /**
     * *****************************************************************************************************************
     * @method modules ajax_grid | AJAX Grid | AJAX listing
     * *****************************************************************************************************************
     */
    private function ajax_grid($query)
    {

        /*** -------- Ajax OR HTML */
        $grid = new ajax_grid();
        $grid->status_column_data = ['1', 'Active', '0' => 'Inactive'];
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
     * @method modules form
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
     * @method modules add | Insert
     * *****************************************************************************************************************
     */
    public function add()
    {

        if ($this->module->validate()) {

            if ($this->module->insert()) {
                set_notification(__('Record has been inserted'), 'success');
            } else {
                set_notification(__('Some error occurred'), 'error');
            }

            if ($this->session->userdata('user_type') == get_option('admin_user_type')) {
                save('user_type_module_rel', array('user_type_id' => get_option('admin_user_type'), 'module_id' => $this->module->_id, 'actions' => $this->module->db_data['actions']));
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
     * @method modules update
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

            if ($this->session->userdata('user_type') == get_option('admin_user_type')) {
                delete_rows('user_type_module_rel', "user_type_id='" . get_option('admin_user_type') . "' AND module_id='{$this->module->_id}'");
                save('user_type_module_rel', array('user_type_id' => get_option('admin_user_type'), 'module_id' => $this->module->_id, 'actions' => $this->module->db_data['actions']));
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
        $stat_key = ['Active' => '1', 'Inactive' => '0'];
        $data = array('status' => $stat_key[$status]);

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
     * @method modules delete
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
            'icon' => ASSETS_DIR . 'admin/img/icons/'
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


    function delete_extra_icons($table = 'modules'){

        $delete_files = array(
            'icon' => ASSETS_DIR . 'admin/uploads/icons/'
        );

        $skip_files['icon'] = ['logout.png'];

        $c = 0;
        $files = $skip_files;
        if (count($delete_files) > 0) {
            foreach ($delete_files as $field_name => $file_path) {
                $modules = $this->db->select($field_name)->get($table)->result();
                foreach ($modules as $row) {
                    $files[$field_name][] = $row->{$field_name};
                }

                foreach (glob($file_path . "*") as $filepath) {
                    $filename = end(explode('/', $filepath));
                    if(!in_array($filename, $files[$field_name])) {
                        $c++;
                        unlink($filepath);
                    }
                }
            }
        }
        set_notification(__("Extra Files({$c}) has been deleted."), 'success');
        redirect(admin_url($this->_route));
    }

    /**
     * *****************************************************************************************************************
     * @method modules view | Record
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

        activity_log(getUri(3), $this->table, $id);

        $data['title'] = $this->_info->module_title;
        $data['config']['buttons'] = ['new', 'edit', 'delete', 'refresh', 'print', 'back'];
        $data['config']['hidden_fields'] = ['created_by'];
        $data['config']['image_fields'] = ['icon' => ['path' => asset_url('uploads/icons/', true),  'size' => '128x128']];

        //$this->admin_template->load($this->module_name . '/view', $data);
        $this->admin_template->load('includes/record_view', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method modules AJAX actions
     * *****************************************************************************************************************
     */
    function AJAX($action, $id = 0)
    {
        $JSON = [];
        switch ($action) {
            case 'delete_img':
                $field = getUri(6);
                $del_img = array($field => ASSETS_DIR . "front/{$this->table}/");
                $JSON['status'] = delete_rows($this->table, "$this->id_field='{$id}'", false, '', key($del_img), $del_img);
                $JSON['message'] = ucwords($field) . ' has been deleted!';
                break;
            case 'ordering':
                $ordering = getVar('ordering');
                $JSON['status'] = save($this->table, ['ordering' => $ordering[$id]], "id='{$id}'");
                $JSON['message'] = 'updated!';
                break;
            case 'validate':
                $field = array_keys($_GET)[0];
                $value = getVar($field);
                $WHERE = "AND `{$field}`='{$value}'";
                if($id > 0){ $WHERE .= " AND `{$this->id_field}` != '{$id}'"; }

                $row = $this->module->row(0, $WHERE);
                if($row->id > 0){
                    exit('false');
                }
                exit('true');
                break;
        }

        echo json_encode($JSON);
    }


    /**
     * *****************************************************************************************************************
     * @method modules import
     * *****************************************************************************************************************
     */
    public function import()
    {

        $data = array();
        if (getVar('import')) {
            $path = dirname(__FILE__) . '/csv/';
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
     * @method modules export
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


        switch ($type) {
            case 'xml':
                $config = array(
                    'root' => 'rows',
                    'element' => 'row',
                    'newline' => "\n",
                    'tab' => "\t"
                );

                $xml = $this->dbutil->xml_from_result($query, $config);
                write_file($dir . $this->table . '.xml', $xml);
                fileDownload($dir . $this->table . '.xml');
                @unlink($dir . $this->table . '.xml');
                break;
            default:
                $csv = $this->dbutil->csv_from_result($query);
                write_file($dir . $this->table . '.csv', $csv);

                fileDownload($dir . $this->table . '.csv');
                @unlink($dir . $this->table . '.csv');
        }

        redirect(admin_url($this->_route));
    }

}

/* End of file modules.php */
/* Location: ./application/controllers/admin/modules.php */