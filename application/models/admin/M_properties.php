<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_properties extends CI_Model
{
    var $table = 'properties';
    var $id_field = 'id';

    var $num_rows = 0;
    var $total_rows = 0;
    var $db_error = '';

    var $db_data = [];
    var $_id;

    function __construct()
    {
        parent::__construct();
        if (empty($this->table)) {
            $this->table = getUri(2);
        }
    }

    function validate()
    {
        $this->form_validation->set_rules('title', __('Title'), 'required');
        $this->form_validation->set_rules('city_id', __('City'), 'required');
        if(empty(getVar('location'))) {
            $this->form_validation->set_rules('area_id', __('Area'), 'required');
        }
        $this->form_validation->set_rules('price', __('Price'), 'required|numeric');
        $this->form_validation->set_rules('area', __('Area'), 'required');
        //$this->form_validation->set_rules('bedrooms', __('Bedrooms'), 'required|integer');
        //$this->form_validation->set_rules('bathrooms', __('Bathrooms'), 'integer');
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
    function rows($where = '', $limit = 0, $offset = 0, $order_by = '', $heaving = '')
    {

        $SQL = "SELECT SQL_CALC_FOUND_ROWS properties.*
                , property_types.type
                -- , countries.country_code
                , cities.city
                , _property_images.filename AS image
                , CONCAT(area.area, ', ', cities.city) AS full_address
                
                -- , area.area_id
                -- , TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''))) as created_by
                FROM properties
                LEFT JOIN (
                SELECT property_images.filename,property_images.property_id FROM property_images WHERE 1 GROUP BY property_images.property_id ORDER BY property_images.ordering ASC
                ) AS _property_images ON( _property_images.property_id = properties.id)
                LEFT JOIN property_types ON(property_types.id = properties.type_id)
                -- LEFT JOIN countries ON(countries.id = properties.country_code)
                LEFT JOIN cities ON(cities.id = properties.city_id)
                LEFT JOIN area ON(area.id = properties.area_id)
                -- LEFT JOIN users ON(users.id = properties.created_by)
                WHERE 1 {$where}";

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

        $location = getVar('location');
        $city_id = intval(getVar('city_id'));
        if(!empty($location) && $city_id > 0){
            $area_id = $this->db->query("SELECT id FROM `area` WHERE area.area = '{$location}' AND city_id='{$city_id}'")->row()->id;
            if($area_id == 0){
                $area_id = save('area', ['area' => $location, 'city_id' => $city_id]);
            }
            $this->db_data['area_id'] = $area_id;
        }


        $this->db_data['description'] = getVar('description', FALSE, FALSE);
        $this->db_data['videos'] = json_encode(getVar('videos', FALSE, FALSE));
        $this->db_data['square_meter'] = area_conversion(floatval($this->db_data['area']), $this->db_data['area_unit']);

        $this->db_data['status'] = 'Active';
        $this->db_data['created'] = date('Y-m-d H:i:s');
        $this->db_data['created_by'] = user_info('id');
        $this->db_data['modified'] = date('Y-m-d H:i:s');
        $this->db_data['modified_by'] = user_info('id');
        $this->db_data = array_merge($this->db_data, $ow_db_data);

        if ($this->_id = save($this->table, $this->db_data)) {

            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | property_tags_rel
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            $rel_table = 'property_tags_rel';
            if($this->db->table_exists($rel_table)) {
                delete_rows($rel_table, "property_id='{$this->_id}'");
                $tag_ids = getVar('tag_ids', false, false);
                if (count($tag_ids) > 0) {
                    foreach ($tag_ids as $tag_id) {
                        if(!is_numeric($tag_id)){
                            $_tag = $this->db->query("select id from property_tags WHERE type='{$tag_id}'");
                            if($_tag->num_rows() > 0){
                                $tag_id = $_tag->row()->id;
                            }else {
                                //$city_id = $this->db->query("select id from cities WHERE city='".getVar('city')."'")->row()->id;
                                $tag_id = save('property_tags', ['type' => $tag_id]);
                            }
                        }

                        save($rel_table, ['property_id' => $this->_id, 'tag_id' => $tag_id]);
                    }
                }
            }


            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Amenities
            *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            delete_rows('property_amenities', "property_id='{$this->_id}'");
            $amenities = getVar('amenities');
            if (count($amenities) > 0 && $this->_id > 0) {
                foreach ($amenities as $amenity_id => $amenity) {
                    $am_data['property_id'] = $this->_id;
                    $am_data['amenity_id'] = $amenity_id;
                    $am_data['amenity_value'] = $amenity;
                    save('property_amenities', $am_data);
                }
            }

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

        $location = getVar('location');
        $city_id = intval(getVar('city_id'));

        if(!empty($location) && $city_id > 0){
            $area_id = $this->db->query("SELECT id FROM `area` WHERE area.area = '{$location}' AND city_id='{$city_id}'")->row()->id;
            if($area_id == 0){
                $area_id = save('area', ['area' => $location, 'city_id' => $city_id]);
            }
            $this->db_data['area_id'] = $area_id;
        }

        $this->db_data['description'] = getVar('description', FALSE, FALSE);
        $this->db_data['videos'] = json_encode(getVar('videos', FALSE, FALSE));
        $this->db_data['modified'] = date('Y-m-d H:i:s');
        $this->db_data['modified_by'] = user_info('id');

        $this->db_data['square_meter'] = area_conversion(floatval($this->db_data['area']), $this->db_data['area_unit']);

        $this->db_data = array_merge($this->db_data, $ow_db_data);

        if (save($this->table, $this->db_data, "{$this->id_field} = '{$this->_id}'")) {

            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | property_tags_rel
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            $rel_table = 'property_tags_rel';
            if($this->db->table_exists($rel_table)) {
                delete_rows($rel_table, "property_id='{$this->_id}'");
                $tag_ids = getVar('tag_ids', false, false);
                if (count($tag_ids) > 0) {
                    foreach ($tag_ids as $tag_id) {
                        if(!is_numeric($tag_id)){
                            $_tag = $this->db->query("select id from property_tags WHERE type='{$tag_id}'");
                            if($_tag->num_rows() > 0){
                                $tag_id = $_tag->row()->id;
                            }else {
                                //$city_id = $this->db->query("select id from cities WHERE city='".getVar('city')."'")->row()->id;
                                $tag_id = save('property_tags', ['type' => $tag_id]);
                            }
                        }

                        save($rel_table, ['property_id' => $this->_id, 'tag_id' => $tag_id]);
                    }
                }
            }

            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | Amenities
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            $amenities = getVar('amenities');
            delete_rows('property_amenities', "property_id='{$this->_id}'");
            if (count($amenities) > 0 && $this->_id > 0) {
                foreach ($amenities as $amenity_id => $amenity) {
                    $am_data['property_id'] = $this->_id;
                    $am_data['amenity_id'] = $amenity_id;
                    $am_data['amenity_value'] = $amenity;
                    save('property_amenities', $am_data);
                }
            }

            activity_log(getUri(3), $this->table, $this->_id);
            return $this->_id;
        } else {
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);

            return false;
        }
    }


    /**
     * @param int $rel_id
     * @param string $where
     * @param int $limit
     * @param int $offset
     * @param string $order_by
     * @param string $heaving
     * @return object $rows
     */
    function files($rel_id = 0, $where = '', $limit = 0, $offset = 0, $order_by = '', $heaving = '')
    {
        $table = 'property_images';

        $SQL = "SELECT SQL_CALC_FOUND_ROWS * FROM {$table} WHERE 1 {$where}";

        if ($rel_id > 0) {
            $SQL .= " AND `property_id`='{$rel_id}'";
        }

        if (!empty($order_by)) {
            $SQL .= " ORDER BY {$order_by}";
        }
        if ($limit > 0) {
            $SQL .= " LIMIT {$offset}, {$limit}";
        }
        if (!empty($heaving)) {
            $SQL .= " {$heaving}";
        }

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


    function update_files_DB($id)
    {

        $table = 'property_images';
        $files_remove = getVar('files_remove', true, false);
        if (count($files_remove) > 0) {
            $delete_files = array(
                'filename' => './assets/front/properties/'
                //'filename' => asset_dir("front/{$this->table}/")
            );
            delete_rows($table, "id IN(" . join(',', $files_remove) . ")  AND property_id='{$id}'", true, '', '', $delete_files);
        }

        //delete_rows($table, "property_id='{$id}'");

        $files = getVar('files');
        $files_data = getVar('files_data');

        if (count($files) > 0) {
            foreach ($files as $i => $f) {
                if (!empty($f)) {
                    $__file_db = [
                        'property_id' => $id,
                        'filename' => $f,
                        'title' => $files_data['title'][$i],
                        //'created' => date('Y-m-d H:i:s'),
                        'ordering' => intval($files_data['ordering'][$i])
                        //'desc' => $img_data['desc'][$i],
                        //'default' => (getVar('default') == $img ? 1 : 0),
                        //'ordering' => ($i + 1)
                    ];
                    $where = '';
                    if (!empty($files_data['id'][$i])) {
                        $where .= "id='{$files_data['id'][$i]}'";

                        unset($__file_db['created']);
                    }
                    save($table, $__file_db, $where);
                }
            }
        }
    }

}

/* End of file M_properties.php */
/* Location: ./application/models/M_properties.php */