<?php
/**
 * Developed by Adnan Bashir.
 * Email: pisces_adnan@hotmail.com
 * Autour: Adnan Bashir
 * Date: 5/30/12
 * Time: 12:56 AM
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . "/class.xmlparser.php";
class Import extends SimpleLargeXMLParser
{

    var $DB;
    var $table;
    var $upload_path = '';
    var $skip_cols = array();
    var $add_cols_w_func = array();// array('db_field_name' => 'return value func')
    var $cols_custom_func = array();
    var $type = 'csv';
    var $file_field = '';

    var $full_path_file = '';
    private $skip_cols_keys = array();

    public function __construct()
    {

        parent::__construct();
    }


    public function do_import()
    {

        $CI =& get_instance();
        $CI->load->database();
        $this->DB = $CI->db;

        $CI->load->library('upload');

        $config['upload_path'] = $this->upload_path;
        $config['allowed_types'] = $this->type;
        $CI->upload->initialize($config);

        $CI->upload->do_upload($this->file_field);
        $data = $CI->upload->data();

        $full_path_file = $data['full_path'];

        if ($full_path_file) {
            switch ($this->type) {
                case 'xml':
                    $this->loadXML($this->full_path_file);
                    $XML = $this->parseXML();


                    foreach ($XML as $rows) {
                        $import = 'INSERT INTO {$this->table} SET ';
                        foreach ($rows as $col => $rows) {
                            if (!in_array($col, $this->skip_cols)) {
                                $import .= "`{$col}` = '{$this->DB->escape($rows[0])}' ";
                            }
                        }
                        $this->DB->query($import);
                    }

                    $return['total_records'] = count($XML);

                    break;
                default:

                    $handle = fopen($full_path_file, "r");

                    $i = -1;
                    $columns = array();
                    $db_columns = array();
                    $db_columns_dummy = array();
                    $list_fields_db = $this->DB->get($this->table)->list_fields();

                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $i++;

                        if ($i == 0) {
                            $columns = $data;
                            foreach ($columns as $k => $colum) {

                                if (!in_array($colum, $this->skip_cols)) {
                                    array_push($db_columns, $colum);
                                } else {
                                    array_push($this->skip_cols_keys, $k);
                                }

                            }
                            $db_columns_dummy = $db_columns;
                        } else {
                            $value_data = array();
                            foreach ($data as $key => $a) {
                                if (!in_array($key, $this->skip_cols_keys)) {
                                    if (array_key_exists($db_columns[$key], $this->cols_custom_func)) {

                                        $a = call_user_func($this->cols_custom_func[$db_columns[$key]], $a, $data, $this->selected);
                                        array_push($value_data, $a);
                                    } else {
                                        array_push($value_data, html_entity_decode($a));
                                    }

                                }
                            }

                            if (count($this->add_cols_w_func) > 0) {
                                foreach ($this->add_cols_w_func as $col_a => $cus_fun) {
                                    if (!in_array($col_a, $db_columns)) {
                                        array_push($db_columns, $col_a);
                                    }
                                    $col_val = call_user_func($cus_fun, $val, $row, $this->selected);
                                    array_push($value_data, $col_val);
                                }
                            }


                            foreach ($db_columns_dummy as $f_key => $field) {
                                if(!in_array($field,$list_fields_db)){
                                    unset($db_columns[$f_key]);
                                    unset($value_data[$f_key]);
                                }
                            }

                            $import = "INSERT INTO {$this->table} (`" . trim(join("`,`", $db_columns)) . "`)  VALUES ('" . trim(join('\',\'', $value_data)) . "')";
                            //echo '<pre>';print_r($import);echo '</pre>';
                            $this->DB->query($import);
                        }
                    }

                    $return['total_records'] = $i;
                    break;
            }

            return $return;
        } else {
            return $return['error'] = 'File Not Upload';
        }
    }
}

