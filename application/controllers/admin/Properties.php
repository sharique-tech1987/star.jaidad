<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class properties * @property M_Modules $m_modules
 * @property M_cpanel $m_cpanel
 * @property M_properties $module
 * @property M_properties $m_properties
 */
class Properties extends CI_Controller
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
     * @method m_properties __construct
     * @model M_properties | m_properties
     * *****************************************************************************************************************
     */
    function __construct()
    {
        parent::__construct();

        //TODO:: Check Login & Module -> properties
        $this->m_cpanel->checkLogin();

        //TODO:: Module Name
        $this->module_name = getUri(2);

        $this->load->model(ADMIN_DIR . 'm_users');
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

        if (user_do_action('self_records')) {
            $_user_id = user_info('id');
            $this->where = " AND {$this->table}.created_by = '{$_user_id}'";
        }

		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
    }


    /**
     * *****************************************************************************************************************
     * @method properties index | Grid | listing
     * *****************************************************************************************************************
     */
    public function index()
    {
        /** -------- Breadcrumb */
        $this->breadcrumb->add_item($this->_info->module_title, admin_url($this->_route));

        /** -------- Query */
        $where = $this->where;
        $query = "SELECT properties.id
, properties.title
, TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''))) as full_name
, properties.purpose
-- , properties.type_id
, property_types.type
-- , properties.city_id
, cities.city
, properties.price
, CONCAT(properties.area, ' ', properties.area_unit) AS area
, properties.bedrooms
, properties.status

FROM properties
LEFT JOIN property_types ON(property_types.id = properties.type_id)
-- LEFT JOIN countries ON(countries.id = properties.country_code)
LEFT JOIN cities ON(cities.id = properties.city_id)
LEFT JOIN users ON(users.id = properties.created_by)
-- LEFT JOIN area ON(area.id = properties.area_id)
-- LEFT JOIN users ON(users.id = properties.created_by) 
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
     * @method properties ajax_grid | AJAX Grid | AJAX listing
     * *****************************************************************************************************************
     */
    private function ajax_grid($query)
    {

        /*** -------- Ajax OR HTML */
        $grid = new ajax_grid();
        $grid->status_column_data = get_enum_values($this->table, 'status');
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
     * @method properties form
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

            $data['files'] = $this->module->files($id, '', 0, 0, 'ordering ASC');
        }

        $this->breadcrumb->add_item($this->_info->module_title, admin_url($this->_route));
        $this->breadcrumb->add_item(($id > 0) ? "Edit -> id:[$id]" : 'Add New');

        $this->admin_template->load($this->module_name . '/form', $data);
    }


    /**
     * *****************************************************************************************************************
     * @method properties add | Insert
     * *****************************************************************************************************************
     */
    public function add()
    {

        if ($this->module->validate() && $this->input->server('REQUEST_METHOD') == 'POST') {

            if ($id = $this->module->insert()) {
                set_notification(__('Record has been inserted'), 'success');
                $this->module->update_files_DB($id);

				$this->cache->file->clean('recent_properties');
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
     * @method properties update
     * *****************************************************************************************************************
     */
    public function update()
    {
        $id = intval(getUri(4));

        if ($this->module->validate() && $this->input->server('REQUEST_METHOD') == 'POST') {

            if ($this->module->update($id)) {
                set_notification(__('Record has been updated'), 'success');
                $this->module->update_files_DB($id);
				$this->cache->file->clean('recent_properties');
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

			$this->cache->file->clean('recent_properties');

			$_IDS = getVar('ids', false, false);
			$ID = intval(getUri(4));
			if($ID > 0){ $_IDS[] = $ID; }
			# +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			# registration_email
			foreach ($_IDS as $id) {

				$property = $this->m_properties->row($id);
				$property->property_id = $property->id;
				$member = get_member($property->created_by);
				$member->property_title = $member->property_name = $property->title;

				$mail_data = array_merge((array)$property, (array)$member);
				$msg = get_email_template($mail_data, 'Property ' . $status);
				if ($msg->status == 'Active') {
					$admin_cc_email = get_option('admin_cc_email');
					$emaildata = array(
						'to' => $member->email,
						'subject' => $msg->subject,
						'message' => $msg->message
					);
					if (!empty($admin_cc_email)) {
						$emaildata['cc'] = $admin_cc_email;
					}
					if (!send_mail($emaildata)) {
						set_notification('Email sending failed.', 'danger');
					} else {
						set_notification("Send email to {$member->email}",'success');
					}
				}
			}

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
     * @method properties delete
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
     * @method properties view | Record
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
            //$data['files'] = $this->module->files($id);

        }

        activity_log(getUri(3), $this->table, $id);

        $data['title'] = $this->_info->module_title;
        $config['buttons'] = ['new', 'edit', 'delete', 'refresh', 'print', 'back'];
        $config['hidden_fields'] = ['created_by'];
        $config['image_fields'] = [
        ];
        $config['custom_func'] = ['status' => 'status_field'];
        $config['attributes'] = [
            'id' => ['title' => 'ID'],
        ];
        $data['config'] = $config;

        if (file_exists(VIEWPATH . ADMIN_DIR . $this->module_name . '/view.php')) {
            $this->admin_template->load($this->module_name . '/view', $data);
        } else {
            $this->admin_template->load('includes/record_view', $data);
        }
    }

    /**
     * *****************************************************************************************************************
     * @method properties AJAX actions
     * *****************************************************************************************************************
     */
    function AJAX($action, $id)
    {
        $JSON = [];
        switch ($action) {
            case 'delete_img':
                $field = getUri(6);
                $del_img = [$field => asset_dir("front/{$this->table}/")];
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
                if ($id > 0) {
                    $WHERE .= " AND {$this->table}.`{$this->id_field}` != '{$id}'";
                }

                $row = $this->module->row(0, $WHERE);
                if ($row->id > 0) {
                    exit('false');
                }
                exit('true');
                break;
        }

        echo json_encode($JSON);
    }


    /**
     * *****************************************************************************************************************
     * @method properties import
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

            activity_log(getUri(3), $this->table);
        }

        $this->breadcrumb->add_item($this->_info->module_title, admin_url($this->_route));
        $this->breadcrumb->add_item('Import');

        $this->admin_template->load('includes/import_view', $data);
    }

    /**
     * *****************************************************************************************************************
     * @method properties export
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

        activity_log(getUri(3), $this->table);

        fileDownload($filename);
        @unlink($filename);

        redirect(admin_url($this->_route));
    }


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
            $dir = 'assets/front/properties/';
            if (!is_dir($dir)) mkdir($dir);
            $id = intval(getVar('id'));
            /*if ($id > 0) { $dir .= $id . '/'; mkdir($dir); }*/

            $config['upload_path'] = './' . $dir;
            $config['allowed_types'] = 'jpg|jpeg|gif|png|bmp';

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $fileinfo = $this->upload->data();
                $output['result']['filename'] = $fileinfo['file_name'];

                $thumb_file = _img(base_url(file_icon($dir . $fileinfo['file_name'], true)), 200, 200);

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

    function duplicate()
    {
        $id = intval(getUri(4));
        if ($id == 0) {
            $this->admin_template->not_found();
            exit;
        }
        $new_ids = DuplicateMySQLRecord($this->table, $this->id_field, $id, [$this->id_field, 'created', 'modified', 'created_by', 'modified_by', 'friendly_url']);
        $new_id = $new_ids[0];

        $row = $this->module->row($id);

        $asset_dir = asset_dir("front/{$this->table}/");
        $files_column = [];
        if (count($files_column) > 0) {
            $files_data = [];
            foreach ($files_column as $field) {
                $file = $row->{$field};
                $new_file = $new_id . '-' . md5(rand()) . $file;
                copy($asset_dir . $file, $asset_dir . $new_file);
                $files_data[$field] = $new_file;
            }
            save($this->table, $files_data, "{$this->id_field}='{$id}'");
        }

        activity_log('duplicate', $this->table, $new_id);

        set_notification(__("Record id#: {$id} has been duplicated.!"), 'success');
        redirect(admin_url($this->_route . '/form/' . $new_id));
    }


    function convert_sm(){
        $SQL = "SELECT id, `area`, area_unit FROM {$this->table}";
        $rows = $this->db->query($SQL)->result();
        if (count($rows) > 0) {
            foreach ($rows as $row) {

                $db_data['square_meter'] = area_conversion($row->area, $row->area_unit);
                save($this->table, $db_data, "id='{$row->id}'");
                echo '<pre>'; print_r($this->db->last_query()); echo '</pre>';
            }
        }
    }

}

/* End of file properties.php */
/* Location: ./application/controllers/admin/properties.php */
