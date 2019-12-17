<?php
/**
 * Adnan Bashir
 * E:  developer.adnan@gmail.com
 * P: +923323103324
 * S: developer.adnan
 *
 * @property M_cpanel $m_cpanel
 * @copyright 2014
 * @date 02-01-2014
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller
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
     * @method settings __construct
     * @model settings main_model    | m_settings
     * *****************************************************************************************************************
     */

    function __construct()
    {
        parent::__construct();

        //TODO:: Check Login & Module -> settings
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
     * @method  index | Grid | listing
     * *****************************************************************************************************************
     */

    public function index()
    {
        /** -------- Breadcrumb */
        $this->breadcrumb->add_item($this->_info->module_title, admin_url($this->_route));

        /** -------- Query */
        $where = $this->where;
        $query = "SELECT * FROM {$this->table} WHERE 1 {$where}";
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


    public function update()
    {
        $settings = getVar('setting', false, false);
        if (count($settings) > 0) {
            foreach ($settings as $key => $setting) {
                if(is_array($setting)){
                    $setting = json_encode($setting);
                }
                $data = array(
                    'option_name' => $key,
                    'option_value' => (trim($setting))
                );

                if(has_option($key)){
                    save($this->table, $data, "option_name='" . $key . "'");
                }else{
                    save($this->table, $data);
                }
            }
        }

        $settings_files = $_FILES['setting'];

        unset($_FILES);
        if (count($settings_files) > 0) {
            foreach ($settings_files['name'] as $key => $file_name) {
                if (!empty($file_name)) {
                    $config['upload_path'] = ADMIN_ASSETS_DIR . 'img/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|xls|xlsx|doc|docx|pdf|html';
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    $_FILES[$key] = array(
                        'name' => $file_name,
                        'type' => $settings_files['type'][$key],
                        'tmp_name' => $settings_files['tmp_name'][$key],
                        'error' => $settings_files['error'][$key],
                        'size' => $settings_files['size'][$key],
                    );

                    $rs = $this->upload->upload_multi($key);
                    $file_name = $rs['upload_data']['file_name'];
                    if ($rs['error']) {
                        $this->session->set_flashdata('error', $rs['error']);
                    }

                    $data = array(
                        'option_name' => $key,
                        'option_value' => $file_name
                    );

                    if (has_option($key)) {
                        save($this->table, $data, "option_name='" . $key . "'");
                    } else {
                        save($this->table, $data);
                    }
                }
            }
        }

		$this->cache->file->delete('options');
        $this->session->set_flashdata('success', 'Record has been updated.');
        redirect(ADMIN_DIR . $this->module_name);

    }

}


/* End of file Settings.php */
/* Location: ./application/controllers/admin/Settings.php */