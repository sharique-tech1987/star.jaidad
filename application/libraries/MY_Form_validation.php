<?php
/**
 * Developed by Adnan Bashir.
 * Email: pisces_adnan@hotmail.com
 * Autour: Adnan Bashir
 * Date: 5/30/12
 * Time: 12:56 AM
 */


if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {


    protected $CI;

    public function __construct() {

        parent::__construct();

        $this->CI =& get_instance();

    }


    public function db_unique($str, $field)
    {
        $fields = explode('.', $field);

        $this->set_message('db_unique', '{field} is already exist');
        if(!empty($fields[3])){
            $this->CI->db->where($fields[2] . "!='{$fields[3]}'");
        }
        return ($this->CI->db->limit(1)->get_where($fields[0], array($fields[1] => $str))->num_rows() === 0);
    }
}

