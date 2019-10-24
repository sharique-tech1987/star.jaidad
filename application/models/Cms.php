<?php
/**
 * Developed by Adnan Bashir.
 * Email: pisces_adnan@hotmail.com
 * Autour: Adnan Bashir
 * Date: 9/20/14
 * Time: 7:19 PM
 */
class Cms extends CI_Model {

    function __construct(){
        parent::__construct();
    }


    /**
     * @return mixed
     */
    function get_banners($where = ''){

        if(!empty($where)){
            $this->db->where($where);
        }
        return $this->db->order_by('ordering','ASC')->get_where('banner_management', array('status' => 'Active'))->result();
    }


    function get_block($identifier, $get_all = false){

        $_static_block = $this->db->select("*", false)->get_where('static_blocks', array('status' => 'Active', 'identifier' => $identifier), 1);
        if($_static_block->num_rows() > 0){
            $static_block = $_static_block->row();
            $static_block->content = replace_urls($static_block->content);

            if($get_all){
                $static_block->content = do_shortcode($static_block->content);
                return $static_block;
            }else{
                return do_shortcode($static_block->content);
            }
        }else{
            return false;
        }
    }


}