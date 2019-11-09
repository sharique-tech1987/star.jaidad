<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_blog_posts extends CI_Model
{

    var $table = 'blog_posts';
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

    function validate(){
        $this->form_validation->set_rules('title', __('Title'), 'required');
        $this->form_validation->set_rules('description', __('Description'), 'required');
        $this->form_validation->set_rules('status', __('Status'), 'required');
        $this->form_validation->set_rules('category_id', __('Category'), 'required');
        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }


    function file_upload($file_name, $_config = array()){}

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

        $SQL = "SELECT SQL_CALC_FOUND_ROWS blog_posts.*,
			blog_categories.type as `Category`, blog_categories.image, blog_categories.status, blog_categories.ordering
			-- ,blog_tags_rel.tag_id, blog_tags.type
               
FROM blog_posts
       LEFT JOIN blog_categories ON(blog_categories.id = blog_posts.category_id)
	   -- LEFT JOIN blog_tags_rel ON(blog_posts.id = blog_tags_rel.blog_id)
	   -- LEFT JOIN blog_tags ON(blog_tags.id = blog_tags_rel.tag_id)
WHERE 1{$where}";

        if(!empty($order_by)){
            $SQL .= " ORDER BY {$order_by}";
        }
        if($limit > 0){
            $SQL .= " LIMIT {$offset}, {$limit}";
        }
        if(!empty($heaving)){
            $SQL .= " {$heaving}";
        }

        $RES = $this->db->query($SQL);

        if ($RES) {
            $rows = $RES->result();
            $this->num_rows = $RES->num_rows();
            $this->total_rows = $this->db->found_rows();
        }else{
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
    function insert($ow_db_data = []){

        $DbArray = getDbArray($this->table);
        $this->db_data = $DbArray['dbdata'];

        /** @var  $upload */
        $_file_column = 'image';
        if (isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
        if (!empty($_FILES[$_file_column]['name'])) {
            $upload = $this->file_upload($_file_column);
            if (!$upload['status']) {
                set_notification(strip_tags($upload['error']));
            } else {
                $this->db_data[$_file_column] = $upload['upload_data']['file_name'];
            }
        }

        $this->db_data['created'] = date('Y-m-d H:i:s');
        $this->db_data['created_by'] = user_info('id');
        $this->db_data['modified'] = date('Y-m-d H:i:s');
        $this->db_data['modified_by'] = user_info('id');
        $this->db_data = array_merge($this->db_data, $ow_db_data);


        if ($this->_id = save($this->table, $this->db_data)) {
            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | blog_tags_rel
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            $rel_table = 'blog_tags_rel';
            if($this->db->table_exists($rel_table)) {
                delete_rows($rel_table, "blog_id='{$this->_id}'");
                $tag_ids = getVar('tag_ids', false, false);
                if (count($tag_ids) > 0) {
                    foreach ($tag_ids as $tag_id) {
                        if(!is_numeric($tag_id)){
                            $_tag = $this->db->query("select id from blog_tags WHERE type='{$tag_id}'");
                            if($_tag->num_rows() > 0){
                                $tag_id = $_tag->row()->id;
                            }else {
                                //$city_id = $this->db->query("select id from cities WHERE city='".getVar('city')."'")->row()->id;
                                $tag_id = save('blog_tags', ['type' => $tag_id]);
                            }
                        }

                        save($rel_table, ['blog_id' => $this->_id, 'tag_id' => $tag_id]);
                    }
                }
            }

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
    function update($id, $ow_db_data = []){
        $this->_id = $id;

        $DbArray = getDbArray($this->table);
        $this->db_data = $DbArray['dbdata'];

        unset($this->db_data['tag_ids']);
        /** @var  $upload */
        $_file_column = 'image';
        if (isset($_POST[$_file_column . '--rm'])) $this->db_data[$_file_column] = '';
        if (!empty($_FILES[$_file_column]['name'])) {
            $upload = $this->file_upload($_file_column);
            if (!$upload['status']) {
                set_notification(strip_tags($upload['error']));
            } else {
                $this->db_data[$_file_column] = $upload['upload_data']['file_name'];
            }
        }

        $this->db_data['modified'] = date('Y-m-d H:i:s');
        $this->db_data['modified_by'] = user_info('id');

        $this->db_data = array_merge($this->db_data, $ow_db_data);

        if (save($this->table, $this->db_data, "{$this->id_field} = '{$this->_id}'")) {
            /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
             * | blog_tags_rel
             *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
            $rel_table = 'blog_tags_rel';
            if($this->db->table_exists($rel_table)) {
                delete_rows($rel_table, "blog_id='{$this->_id}'");
                $tag_ids = getVar('tag_ids', false, false);
                if (count($tag_ids) > 0) {
                    foreach ($tag_ids as $tag_id) {
                        if(!is_numeric($tag_id)){
                            $_tag = $this->db->query("select id from blog_tags WHERE type='{$tag_id}'");
                            if($_tag->num_rows() > 0){
                                $tag_id = $_tag->row()->id;
                            }else {
                                //$city_id = $this->db->query("select id from cities WHERE city='".getVar('city')."'")->row()->id;
                                $tag_id = save('blog_tags', ['type' => $tag_id]);
                            }
                        }

                        save($rel_table, ['blog_id' => $this->_id, 'tag_id' => $tag_id]);
                    }
                }
            }

            activity_log(getUri(3), $this->table, $this->_id);
            return $this->_id;
        }else {
            $this->db_error = $this->db->error()['message'];
            developer_log($this->table, $this->db_error);

            return false;
        }
    }



}