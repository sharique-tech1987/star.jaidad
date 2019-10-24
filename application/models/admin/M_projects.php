<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_projects extends CI_Model
{
    var $table = 'projects';
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
        $this->form_validation->set_rules('area_id', __('Area'), 'required');
        $this->form_validation->set_rules('price_from', __('Price From'), 'required');
        $this->form_validation->set_rules('price_to', __('Price To'), 'required');
        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }

    }


    function file_upload($file_name, $_config = array())
    {

        $config['upload_path'] = ASSETS_DIR . "front/{$this->table}/";
        $config['allowed_types'] = 'gif|jpg|jpeg|png|gif';

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

        $SQL = "SELECT SQL_CALC_FOUND_ROWS {$this->table}.*
                -- , countries.country
, cities.city
, area.area
, CONCAT(area.area, ', ', cities.city) AS full_address
, _project_images.filename AS image

-- , user.developer_id
-- , TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''))) as created_by
FROM projects

LEFT JOIN (
SELECT project_images.filename,project_images.project_id FROM project_images WHERE 1 GROUP BY project_images.project_id ORDER BY project_images.ordering ASC
) AS _project_images ON( _project_images.project_id = projects.id)

        -- LEFT JOIN countries ON(countries.id = projects.country)
LEFT JOIN cities ON(cities.id = projects.city_id)
LEFT JOIN area ON(area.id = projects.area_id)
-- LEFT JOIN user ON(user.id = projects.developer_id)
-- LEFT JOIN users ON(users.id = projects.created_by)
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

        /** @var  $upload */
        $_file_column = 'logo';
        if (isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
        if (!empty($_FILES[$_file_column]['name'])) {
            $upload = $this->file_upload($_file_column);
            if (!$upload['status']) {
                set_notification(strip_tags($upload['error']));
            } else {
                $this->db_data[$_file_column] = $upload['upload_data']['file_name'];
            }
        }
        $this->db_data['short_description'] = getVar('short_description', FALSE, FALSE);
        $this->db_data['description'] = getVar('description', FALSE, FALSE);
        $this->db_data['created'] = date('Y-m-d H:i:s');
        $this->db_data['created_by'] = user_info('id');
        $this->db_data['floor_plans'] = json_encode(getVar('floor_plans', false, false));
        $this->db_data['payment_plans'] = json_encode(getVar('payment_plans', FALSE, FALSE));
        $this->db_data['project_map'] = json_encode(getVar('project_map', false, false));
        $this->db_data['videos'] = json_encode(getVar('videos', false, false));
        $this->db_data = array_merge($this->db_data, $ow_db_data);

        if ($this->_id = save($this->table, $this->db_data)) {

            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | Amenities
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            delete_rows('project_amenities', "project_id='{$this->_id}'");
            $amenities = getVar('amenities');
            if (count($amenities) > 0) {
                foreach ($amenities as $amenity_id => $amenity) {
                    $am_data['project_id'] = $this->_id;
                    $am_data['amenity_id'] = $amenity_id;
                    $am_data['amenity_value'] = $amenity;
                    save('project_amenities', $am_data);
                }
            }

            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | Videos
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/

            $file_path = asset_dir("front/{$this->table}/");
            $files_remove = getVar('videos_remove', true, false);
            if (count($files_remove) > 0) {
                foreach ($files_remove as $file) {
                    @unlink($file_path . $file);
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

        /** @var  $upload */
        $_file_column = 'logo';
        if (isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
        if (!empty($_FILES[$_file_column]['name'])) {
            $upload = $this->file_upload($_file_column);
            if (!$upload['status']) {
                set_notification(strip_tags($upload['error']));
            } else {
                $this->db_data[$_file_column] = $upload['upload_data']['file_name'];
            }
        }
        $this->db_data['short_description'] = getVar('short_description', FALSE, FALSE);
        $this->db_data['description'] = getVar('description', FALSE, FALSE);
        $this->db_data['floor_plans'] = json_encode(getVar('floor_plans', false, false));
        $this->db_data['payment_plans'] = json_encode(getVar('payment_plans', FALSE, FALSE));
        $this->db_data['project_map'] = json_encode(getVar('project_map', false, false));
        $this->db_data['videos'] = json_encode(getVar('videos', false, false));
        $this->db_data = array_merge($this->db_data, $ow_db_data);

        if (save($this->table, $this->db_data, "{$this->id_field} = '{$this->_id}'")) {

            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | Amenities
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            delete_rows('project_amenities', "project_id='{$this->_id}'");
            $amenities = getVar('amenities');
            if (count($amenities) > 0) {
                foreach ($amenities as $amenity_id => $amenity) {
                    $am_data['project_id'] = $this->_id;
                    $am_data['amenity_id'] = $amenity_id;
                    $am_data['amenity_value'] = $amenity;
                    save('project_amenities', $am_data);
                }
            }

            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | Videos
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/

            $file_path = asset_dir("front/{$this->table}/");
            $files_remove = getVar('videos_remove', true, false);
            if (count($files_remove) > 0) {
                foreach ($files_remove as $file) {
                    @unlink($file_path . $file);
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
        $table = 'project_images';

        $SQL = "SELECT SQL_CALC_FOUND_ROWS * FROM {$table} WHERE 1 {$where}";

        if ($rel_id > 0) {
            $SQL .= " AND `project_id`='{$rel_id}'";
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

        $table = 'project_images';
        $files_remove = getVar('files_remove', true, false);
        if (count($files_remove) > 0) {
            $delete_files = array(
                'filename' => './assets/front/projects/'
                //'filename' => asset_dir("front/{$this->table}/")
            );
            delete_rows($table, "id IN(" . join(',', $files_remove) . ") AND project_id='{$id}'", true, '', '', $delete_files);
        }

        //delete_rows($table, "project_id='{$id}'");

        $files = getVar('files');
        $files_data = getVar('files_data');

        if (count($files) > 0) {
            foreach ($files as $i => $f) {
                if (!empty($f)) {
                    $__file_db = array(
                        'project_id' => $id,
                        'filename' => $f,
                        'title' => $files_data['title'][$i],
                        //'created' => date('Y-m-d H:i:s'),
                        'ordering' => intval($files_data['ordering'][$i])
                        //'desc' => $img_data['desc'][$i],
                        //'default' => (getVar('default') == $img ? 1 : 0),
                        //'ordering' => ($i + 1)
                    );
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

/* End of file M_projects.php */
/* Location: ./application/models/M_projects.php */