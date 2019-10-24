<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_area extends CI_Model
{
    var $table = 'area';
    var $id_field = 'id';

    var $num_rows = 0;
    var $total_rows = 0;
    var $db_error = '';

    var $db_data = [];
    var $_id;

    private $_areas = [];

    function __construct()
    {
        parent::__construct();
        if (empty($this->table)) {
            $this->table = getUri(2);
        }
    }

    function validate()
    {
        $this->form_validation->set_rules('area', __('Area'), 'required');
        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }

    }


    function file_upload($file_name, $_config = array())
    {

        $config['upload_path'] = ASSETS_DIR . "front/{$this->table}/";
        $config['allowed_types'] = '';

        $config = array_merge($config, $_config);

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path']);
        }

        $this->load->library('upload');
        $this->upload->initialize($config);

        $RES = $this->upload->upload_multi($file_name);

        if (count($RES['error']) > 0) {
            $return = $RES;
            $return['status'] = FALSE;
        } else {
            $return = $RES;
            $return['status'] = TRUE;
        }

        return $return;
    }

    /**
     * @param int $id
     * @param string $where
     * @return mixed
     */
    function row($id = 0, $where = '')
    {
        if ($id > 0) {
            $where .= " AND {$this->table}.{$this->id_field}='{$id}'";
        }
        $rows = $this->rows($where, 1);
        return $rows[0];
    }

    /**
     * @param string $where
     * @param int $limit
     * @param int $offset
     * @param string $order_by
     * @param string $heaving
     * @return object $rows
     */
    function rows($where = '', $limit = 0, $offset = 0, $order_by = '', $heaving = '', $counter = false)
    {

        $SQL = "SELECT SQL_CALC_FOUND_ROWS {$this->table}.*
                , cities.city";
        if($counter)
        $SQL .= " , COUNT(DISTINCT properties.id) AS total_properties";

            $SQL .= " FROM `{$this->table}`
            LEFT JOIN cities ON(cities.id = area.city_id)";
        if($counter)
            $SQL .= " LEFT JOIN properties ON(properties.area_id = area.id)";

        $SQL .= " WHERE 1 {$where}";

        $SQL .= " GROUP BY {$this->table}.{$this->id_field}";

        if (!empty($order_by)) {
            $SQL .= " ORDER BY {$order_by}";
        }
        if ($limit > 0) {
            $SQL .= " LIMIT {$offset}, {$limit}";
        }
        if (!empty($heaving)) {
            $SQL .= " {$heaving}";
        }
        //echo '<pre>'; print_r($SQL); echo '</pre>';
        $RES = $this->db->query($SQL);

        if ($RES) {
            $rows = $RES->result();
            $this->num_rows = $RES->num_rows();
            $this->total_rows = $this->db->found_rows();
        } else {
            $rows = false;
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);
        }

        return $rows;
    }


    /**
     * @param array $ow_db_data
     * @return bool|string
     */
    function insert($ow_db_data = [])
    {

        $DbArray = getDbArray($this->table);
        $this->db_data = $DbArray['dbdata'];

        $this->db_data['created'] = date('Y-m-d H:i:s');
        $this->db_data['created_by'] = user_info('id');
        $this->db_data = array_merge($this->db_data, $ow_db_data);

        if ($this->_id = save($this->table, $this->db_data)) {
            activity_log(getUri(3), $this->table, $this->_id);
            return $this->_id;
        } else {
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);

            return false;
        }
    }

    /**
     * @param $id
     * @param array $ow_db_data
     * @return bool
     */
    function update($id, $ow_db_data = [])
    {
        $this->_id = $id;

        $DbArray = getDbArray($this->table);
        $this->db_data = $DbArray['dbdata'];

        $this->db_data = array_merge($this->db_data, $ow_db_data);

        if (save($this->table, $this->db_data, "{$this->id_field} = '{$this->_id}'")) {
            activity_log(getUri(3), $this->table, $this->_id);
            return $this->_id;
        } else {
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);

            return false;
        }
    }


    function get_areas($id)
    {
        $this->make_areas($id);
        return $this->_areas = array_reverse($this->_areas, true);
        $areas = [];
        foreach ($this->_areas as $k => $area) {
            if ($area->id) {
                $areas[$area->parent_id] = $this->_areas[$k];
            }
        }
        return $areas;
    }

    private function make_areas($id, $child_id = 0)
    {
        $row = $this->row($id);
        $this->_areas[($child_id == 0 ? $row->parent_id : $child_id)] = $row;
        if ($row->parent_id > 0) {
            $this->make_areas($row->parent_id, $row->id);
        }
    }


    function get_reviews($area_id, $limit = 0, $offset = 0, $counter = true)
    {

        $this->db->order_by('created', 'DESC');
        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $this->db->select("area_reviews.*
        , users.first_name
        , users.last_name
        , users.photo
        , users.email
        , users.phone
        , TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''))) as full_name
        , TRIM(CONCAT(IFNULL(users.address, ''), ', ', IFNULL(users.city, ''), ', ', IFNULL(users.country, ''))) as full_address
        ", false)
            ->join('users', 'users.id=area_reviews.user_id', 'left');

        $product_reviews = $this->db->get_where('area_reviews', array('area_reviews.area_id' => $area_id, 'area_reviews.status' => 'Approved'));
        $total_reviews = $product_reviews->num_rows();
        $total_review_points = 0;
        $data['reviews'] = $product_reviews->result();

        if ($total_reviews > 0) {
            foreach ($data['reviews'] as $reviews) {
                $reviews->star_rating = $this->rating_star($reviews->score);
                $total_review_points += $reviews->score;
            }
        }

        $rate = round(($total_review_points / ($total_reviews * 5)) * 5);
        $data['rate'] = $rate;
        $data['ratting_stars'] = $this->rating_star($rate);
        $product_ratting = '';
        if ($counter) {
            $product_ratting .= ' <span class="count count-reviews">' . $total_reviews . ' Review(s)</span>';
        }
        $data['ratting'] = $product_ratting;
        $data['total_reviews'] = $total_reviews;

        return $data;
    }

    function rating_star($rate, $out_of = 5)
    {

        $product_ratting = '<div class="rating">';
        for ($i = 1; $i <= $out_of; $i++) {
            if ($i <= $rate) {
                //$product_ratting .= '<img src="' . template_url('assets/img/small-star.png') . '" alt="' . $i . '"/>';
                $product_ratting .= '<i class="fa fa-star" aria-hidden="true"></i>';
            } else {
                //$product_ratting .= '<img src="' . template_url('assets/img/small-blank-star.png') . '" alt="' . $i . '"/>';
                $product_ratting .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
            }
        }
        $product_ratting .= '</div>';

        return $product_ratting;
    }

}

/* End of file M_area.php */
/* Location: ./application/models/M_area.php */
