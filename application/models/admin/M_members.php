<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +923323103324
 * S: developer.adnan
 * @copyright 2014
 * @date 03-06-2014
 *
 * @property M_users $m_users
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_members extends CI_Model
{
    var $table = 'users';
    var $id_field = 'id';

    var $num_rows = 0;
    var $total_rows = 0;
    var $db_error = '';

    var $db_data = [];
    var $_id;

    function __construct()
    {
        $this->load->model(ADMIN_DIR . 'm_users');
        parent::__construct();
        if (empty($this->table)) {
            $this->table = getUri(2);
        }
    }

    function info($where = '', $user_session = ADMIN_SESSION_ID)
    {
        return $this->m_users->info($where, $user_session);
    }

    function row($id, $where = '')
    {
        return $this->m_users->row($id, $where);
    }

    function rows($where = '', $limit = 0, $offset = 0, $order_by = '', $heaving = '')
    {
        return $this->m_users->rows($where, $limit, $offset, $order_by, $heaving);
    }


    function bookings($member_id, $where = '')
    {
        $SQL = "SELECT
            booking.id
            , booking.booking_date
            , booking.member_id
            , booking.status
            , project_properties.*
            , property_types.type AS property_type
            , projects.title AS project
            , projects.logo
            
            , cities.city
            , area.area AS area_name
            , CONCAT(area.area, ', ', cities.city) AS full_address
        FROM booking
            INNER JOIN project_properties ON (booking.property_id = project_properties.id)
            INNER JOIN projects ON (project_properties.project_id = projects.id)
            INNER JOIN property_types ON (property_types.id = project_properties.type_id)
            
            LEFT JOIN cities ON(cities.id = projects.city_id)
            LEFT JOIN area ON(area.id = projects.area_id)
        WHERE booking.member_id='{$member_id}' {$where}";

        $rows = $this->db->query($SQL)->result();

        return $rows;
    }


}

/* End of file M_users.php */
/* Location: ./application/models/m_users.php */