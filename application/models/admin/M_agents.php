<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +923323103324
 * S: developer.adnan
 * @copyright 2014
 * @date 03-06-2014
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_agents extends CI_Model
{
    var $table = 'users';
    var $id_field = 'id';

    var $num_rows = 0;
    var $total_rows = 0;
    var $db_error = '';

    var $db_data = [];
    var $_id;
    var $property_count = false;

    function __construct()
    {
        $this->load->helper('cookie');

        parent::__construct();
        if (empty($this->table)) {
            $this->table = getUri(2);
        }
    }

    function validate($id = 0, $become = true)
    {


        if ($id == 0) {
            $id = getUri(4);
            $row = $this->row($id);
        } else{
            $row = new stdClass();
            $row->social = '';
        }

        if (in_array(getUri(2), ['users'])) {
            $this->form_validation->set_rules('user_type_id', 'User Type', 'required');
        }

        if($id > 0){
            $row = get_member($id);
        }

        $this->form_validation->set_rules('first_name', 'Name', 'required');
        if(empty($row->social)) {
            $this->form_validation->set_rules('username', 'Email', 'required|valid_email|db_unique[users.username.id.' . $id . ']');
        }
        if ($id == 0) {
            $this->form_validation->set_rules('password', 'Password', 'required');
        }
        $this->form_validation->set_rules('phone', 'Phone', 'required|db_unique[users.phone.id.' . $id . ']');
        $this->form_validation->set_rules('city', 'City', 'required');

        if ($this->form_validation->run() == FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


    function file_upload($file_name, $_config = array())
    {

        $config['upload_path'] = ASSETS_DIR . "front/{$this->table}/";
        $config['allowed_types'] = 'gif|jpg|jpeg|png';

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
     * @return array $rows
     */
    function rows($where = '', $limit = 0, $offset = 0, $order_by = '', $heaving = '')
    {

        $SQL = "SELECT SQL_CALC_FOUND_ROWS users.*
                , TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''))) as full_name
                , TRIM(CONCAT(IFNULL(users.address, ''), ', ', IFNULL(users.city, ''), ', ', IFNULL(users.country, ''))) as full_address
                -- , agents_rel.*
                -- , GROUP_CONCAT(agent_area_list.area_id SEPARATOR ',') AS area_ids
                , users.id AS id";
        if($this->property_count){
            $SQL .= ", count(DISTINCT properties.id) AS total_properties ";
        }

        $SQL .= " FROM {$this->table} AS users 
        LEFT JOIN agent_area_list ON (agent_area_list.agent_id = users.id)
        LEFT JOIN area ON (area.id = agent_area_list.area_id)";

        if($this->property_count){
            $SQL .= " LEFT JOIN properties ON (properties.created_by = users.id AND properties.status='Active')";
        }

        $SQL .= " WHERE 1 {$where} GROUP BY users.id";


        if (!empty($order_by)) {
            $SQL .= " ORDER BY {$order_by}";
        }
        if ($limit > 0) {
            $SQL .= " LIMIT {$offset}, {$limit}";
        }
        if (!empty($heaving)) {
            $SQL .= " {$heaving}";
        }
        //echo '<pre>'; print_r($SQL); echo '</pre>';die('sad');
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


    function get_agent_areas($agent_id = null, $area_ids = []){

        if($agent_id != null && $agent_id > 0){
            $SQL = "SELECT area.id
                , area.area
                , area.city_id
                , cities.city
                , cities.country
            FROM agent_area_list
              INNER JOIN area ON (agent_area_list.area_id = area.id)
              INNER JOIN cities ON (cities.id = area.city_id)
            WHERE agent_area_list.agent_id='{$agent_id}' ";

        }
        if(count($area_ids) > 0){
            $SQL = "SELECT area.*,cities.city,cities.country  FROM area 
            INNER JOIN cities ON (cities.id = area.city_id)
            WHERE area.id IN(".join(',', $area_ids).") ";

        }

        $rows = $this->db->query($SQL)->result();

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

        //$this->db_data['area_ids'] = join(',', getVar('area_ids', false, false));
        unset($this->db_data['area_ids']);
        if($_POST['city']){
            $this->db_data['city'] = $this->db->query("select city from cities WHERE id='".getVar('city')."'")->row()->city;
        }

        $this->db_data['password'] = encryptPassword($this->db_data['password']);
        $this->db_data['status'] = 'Active';
        $this->db_data['created'] = date('Y-m-d H:i:s');
        $this->db_data['modified'] = date('Y-m-d H:i:s');
        $this->db_data['created_by'] = user_info('id');
        if(isset($_POST['social_network'])){
            $this->db_data['social_network'] = json_encode($this->db_data['social_network']);
        }
        /** @var  $upload */
        $_file_column = 'photo';
        if (isset($_POST['photo--rm'])) $this->db_data[$_file_column] = '';
        if (!empty($_FILES[$_file_column]['name'])) {
            $upload = $this->file_upload($_file_column);
            if (!$upload['status']) {
                set_notification(strip_tags($upload['error']));
            } else {
                $this->db_data[$_file_column] = $upload['upload_data']['file_name'];
            }
        }
        /** @var  $upload */
        $_file_column = 'logo';
        if (isset($_POST[$_file_column . "--rm"])) $this->db_data[$_file_column] = '';
        if (!empty($_FILES[$_file_column]['name'])) {
            $upload = $this->file_upload($_file_column);
            if (!$upload['status']) {
                set_notification(strip_tags($upload['error']));
            } else {
                $this->db_data[$_file_column] = $upload['upload_data']['file_name'];
            }
        }

        $this->db_data = array_merge($this->db_data, $ow_db_data);
        if ($this->_id = save($this->table, $this->db_data)) {
            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | agent_area_rel
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            $rel_table = 'agent_area_list';
            if($this->db->table_exists($rel_table)) {
                delete_rows($rel_table, "agent_id='{$this->_id}'");
                $area_ids = getVar('area_ids', false, false);
                if (count($area_ids) > 0) {
                    foreach ($area_ids as $area_id) {
                        if(!is_numeric($area_id)){
                            $_area = $this->db->query("select id from area WHERE area='{$area_id}'");
                            if($_area->num_rows() > 0){
                                $area_id = $_area->row()->id;
                            }else {
                                //$city_id = $this->db->query("select id from cities WHERE city='".getVar('city')."'")->row()->id;
                                $city_id = intval(getVar('city'));
                                $area_id = save('area', ['area' => $area_id, 'city_id' => $city_id, 'parent_id' => 0]);
                            }
                        }

                        save($rel_table, ['agent_id' => $this->_id, 'area_id' => $area_id]);
                    }
                }
            }

            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | agents_rel
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            $rel_table = 'agents_rel';
            if($this->db->table_exists($rel_table)) {
                delete_rows($rel_table, "agent_id='{$this->_id}'");

                $DbArray = getDbArray($rel_table, [], $this->input->post('rel'));
                $rel_db_data = $DbArray['dbdata'];
                $rel_db_data['agent_id'] = $this->_id;
                //$rel_db_data['campus_id'] = _session('sms_campus_id');

                /** @var  $upload */
                $_file_column = 'resume';
                if (isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
                if (!empty($_FILES[$_file_column]['name'])) {
                    $upload = $this->file_upload($_file_column, ['allowed_types' => 'pdf|doc|docx|rtf']);
                    if (!$upload['status']) {
                        set_notification(strip_tags($upload['error']));
                    } else {
                        $rel_db_data[$_file_column] = $upload['upload_data']['file_name'];
                    }
                }

                save($rel_table, $rel_db_data);
            }
            /**----------------------------------------------------------------------------------**/
            $act_name = (!empty(getUri(3)) ? getUri(3) : 'insert');
            activity_log($act_name, $this->table, $this->_id, $this->_id);
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

        if(isset($_POST['social_network'])){
            $this->db_data['social_network'] = json_encode($this->db_data['social_network']);
        }

        unset($this->db_data['area_ids']);
        if($_POST['city']){
            $this->db_data['city'] = $this->db->query("select city from cities WHERE id='".getVar('city')."'")->row()->city;
        }

        unset($this->db_data['password']);
        if (getVar('password') != '') {
            $this->db_data['password'] = encryptPassword(getVar('password'));
        }
        /** @var  $upload */
        $_file_column = 'photo';
        if (isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
        if (!empty($_FILES[$_file_column]['name'])) {
            $upload = $this->file_upload($_file_column);
            if (!$upload['status']) {
                set_notification(strip_tags($upload['error']));
            } else {
                $this->db_data[$_file_column] = $upload['upload_data']['file_name'];
            }
        }

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
        $this->db_data['newsletter'] = getVar('newsletter');
        $this->db_data['modified'] = date('Y-m-d H:i:s');

        $this->db_data = array_merge($this->db_data, $ow_db_data);

        if (save($this->table, $this->db_data, "{$this->id_field} = '{$this->_id}'")) {
            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | agent_area_rel
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            $rel_table = 'agent_area_list';
            if($this->db->table_exists($rel_table)) {
                delete_rows($rel_table, "agent_id='{$this->_id}'");
                $area_ids = getVar('area_ids', false, false);
                if (count($area_ids) > 0) {
                    foreach ($area_ids as $area_id) {
                        if(!is_numeric($area_id)){
                            $_area = $this->db->query("select id from area WHERE area='{$area_id}'");
                            if($_area->num_rows() > 0){
                                $area_id = $_area->row()->id;
                            }else {
                                //$city_id = $this->db->query("select id from cities WHERE city='".getVar('city')."'")->row()->id;
                                $city_id = intval(getVar('city'));
                                $area_id = save('area', ['area' => $area_id, 'city_id' => $city_id, 'parent_id' => 0]);
                            }
                        }
                        save($rel_table, ['agent_id' => $this->_id, 'area_id' => $area_id]);
                        //echo '<pre>'; print_r($this->db->last_query()); echo '</pre>';
                    }
                }
            }

            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | agents_rel
            *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            $rel_table = 'agents_rel';
            if($this->db->table_exists($rel_table)) {
                delete_rows($rel_table, "agent_id='{$this->_id}'");

                $DbArray = getDbArray($rel_table, [], $this->input->post('rel'));
                $rel_db_data = $DbArray['dbdata'];
                $rel_db_data['agent_id'] = $this->_id;
                //$rel_db_data['campus_id'] = _session('sms_campus_id');

                /** @var  $upload */
                $_file_column = 'resume';
                if (isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
                if (!empty($_FILES[$_file_column]['name'])) {
                    $upload = $this->file_upload($_file_column, ['allowed_types' => 'pdf|doc|docx|rtf']);
                    if (!$upload['status']) {
                        set_notification(strip_tags($upload['error']));
                    } else {
                        $rel_db_data[$_file_column] = $upload['upload_data']['file_name'];
                    }
                }

                save($rel_table, $rel_db_data);
            }
            /**----------------------------------------------------------------------------------**/

            activity_log(getUri(3), $this->table, $this->_id);
            return $this->_id;
        } else {
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);

            return false;
        }
    }


}

/* End of file M_users.php */
/* Location: ./application/models/m_users.php */