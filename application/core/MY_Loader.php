<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Database Loader
     *
     * @access    public
     * @param    string    the DB credentials
     * @param    bool    whether to return the DB object
     * @param    bool    whether to enable active record (this allows us to override the config setting)
     * @return    object
     */
    function database($params = '', $return = FALSE, $query_builder = NULL)
    {
        // Do we even need to load the database class?
        if (class_exists('CI_DB') AND $return == FALSE AND $query_builder == NULL) {
            return FALSE;
        }

        require_once(BASEPATH . 'database/DB' . '.php');

        // Load the DB class
        $db =& DB($params, $query_builder);

        $my_driver = config_item('subclass_prefix') . 'DB_' . $db->dbdriver . '_driver';
        $my_driver_file = APPPATH . 'libraries/' . $my_driver . '.php';

        if (file_exists($my_driver_file))
        {
            require_once($my_driver_file);
            $db_obj = new $my_driver(get_object_vars($db));
            $db=& $db_obj;
        }

        if ($return === TRUE) {
            return $db;
        }
        // Grab the super object
        $CI =& get_instance();

        // Initialize the db variable.  Needed to prevent
        // reference errors with some configurations
        $CI->db = '';
        $CI->db = $db;


        // Assign the DB object to any existing models
        //$this->_ci_assign_to_models();
    }

}

/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */