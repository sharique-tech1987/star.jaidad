<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Class Index
 * @property Cms $cms
 * @property M_area $m_area
 * @property M_properties $m_properties
 * @property M_amenities $m_amenities
 */
include __DIR__ . "/../libraries/html_dom.php";

class Parse extends CI_Controller
{
    var $listing_url = '';
    var $number = 0;

    function __construct()
    {
        parent::__construct();
        $this->load->helper('frontend');
        $this->load->model('cms');
        $this->load->model(ADMIN_DIR . 'm_properties');
        $this->load->model(ADMIN_DIR . 'm_amenities');
        $this->load->model(ADMIN_DIR . 'm_area');

        $this->load->library('pagination');

    }


    public function index()
    {


    }


    function cities()
    {
        $url = "https://www.zameen.com/all-cities/pakistan-1-2.html";

        $json_file = 'parse/pakistan-cities.json';
        @unlink($json_file);
        $JSON = [];
        $html = file_get_html($url);
        if (!$html) {
            die("Can't Parse");
        }

        foreach ($html->find('#sub-location-list .line-list li') as $li) {
            $city = trim($li->find('a', 0)->plaintext);
            $city_link = trim($li->find('a', 0)->href);

            $json_data = ['city' => $city, 'url' => $city_link];
            echo '<pre>';print_r($json_data);echo '</pre>';
            array_push($JSON, $json_data);

            if ($this->db->get_where('cities', ['city' => $city], 1)->num_rows() == 0) {
                save('cities', ['city' => $city, 'country' => 'PK']);
            }
        }
        file_put_contents($json_file, json_encode($JSON));
    }

    function fetch_areas()
    {
        $type = getVar('type');
        $city_id = intval(getVar('city_id'));
        $area_id = intval(getVar('area_id'));

        if(!empty($type)) {
            if ($city_id > 0 && $type == 'Location' && $area_id == 0) {
                $_city = $this->db->get_where('cities', ['id' => $city_id], 1)->row();
                $city = $_city->city;
                $this->fetch_city($city);

            } else if ($city_id > 0 && $area_id > 0 && $type == 'Location') {
                $_city = $this->db->get_where('cities', ['id' => $city_id], 1)->row();
                $city = $_city->city;

                $_area = $this->db->get_where('area', ['id' => $area_id], 1)->row();
                $area = $_area->area;


                $file_name = url_title($city);
                $json_file = "parse/{$file_name}-area.json";

                if(!file_exists($json_file)){
                    $this->fetch_city($city);
                }

                $pick_rows = (json_decode(file_get_contents($json_file)));

                if(count($pick_rows) == 0){
                    set_notification('Area not found in ' . $city);
                    redirectBack();
                }

                $__area = $this->m_area->get_areas($_area->id);
                if (count($__area) > 0) {
                    foreach ($__area as $pid => $_area) {
                        $this->pick_parent_area($pick_rows, $_city->id, $_city->city, $_area->id, $_area->area);
                    }
                }

            }
        } else {
            $this->load->view('parse/areas');
        }
    }

    private function pick_parent_area($pick_rows, $city_id, $city, $parent_area_id = 0, $area = ''){
        foreach ($pick_rows as $pick_row) {
            if($area != $pick_row->area) continue;
            $url = str_replace(['Homes/', '.html'], ['all_locations/', '-1.html'], $pick_row->url);
            $this->city_area($url, $city_id, $city, $parent_area_id, $area, $pick_rows);
        }
    }


    function fetch_city($city)
    {
        $pick_json_file = 'parse/pakistan-cities.json';
        //echo '<pre>Pick File: ';print_r($pick_json_file);echo '</pre>';
        $pick_rows = json_decode(file_get_contents($pick_json_file));

        if (count($pick_rows) > 0) {
            foreach ($pick_rows as $i => $pick_row) {

                if ((!empty($city) && $city != $pick_row->city)) continue;

                $url = str_replace(['Homes/', '.html'], ['all_locations/', '-1.html'], $pick_row->url);

                $_city = $this->db->get_where('cities', ['city' => $pick_row->city], 1)->row();
                $this->city_area($url, $_city->id, $_city->city, 0, '', $pick_rows);

            }
        }
    }

    private function city_area($url, $city_id, $city, $parent_area_id = 0, $area = '', $OLD_JSON = [])
    {

        /*if ($parent_area_id > 0 && !empty($area)) {
            $file_name = $city . '__' . $area;
        } else */{
            $file_name = $city;
        }

        $file_name = url_title($file_name);
        $json_file = "parse/{$file_name}-area.json";
        //@unlink($json_file);

        $JSON = [];
        $html = file_get_html($url);
        if (!$html) {
            echo '<pre>';print_r(func_get_args());echo '</pre>';
            die("Can't Parse");
        }

        $__row = 0;
        foreach ($html->find('#sub-location-list .line-list li') as $li) {
            $__row++;

            $area = trim($li->find('a', 0)->plaintext);
            $_link = trim($li->find('a', 0)->href);

            if(array_column($OLD_JSON, 'area') != $area){
                $json_data = ['area' => $area, 'url' => $_link];
                array_push($JSON, $json_data);
            }

            if ($parent_area_id > 0) {
                $where['parent_id'] = $parent_area_id;
            }
            if ($city_id > 0) {
                $where['city_id'] = $city_id;
            }
            $where['area'] = $area;

            if ($this->db->get_where('area', $where, 1)->num_rows() == 0) {
                $id = save('area', ['area' => $area, 'city_id' => $city_id, 'parent_id' => $parent_area_id]);
                echo '<pre>ID: ' . $id . ' - ';echo($area);echo '</pre>';
            } else if ($parent_area_id > 0) {
                //echo '<pre>Area: ' . $area . ' - ';print_r($this->db->last_query());echo '</pre>';
                echo '<pre>Exist: ';echo($area);echo '</pre>';
            } else {
                echo '<pre>Exist: ';echo($area);echo '</pre>';
            }

        }


        file_put_contents($json_file, json_encode(array_merge($OLD_JSON,$JSON)));
        //var_dump($__row);
        /*if($__row > 0)
        $this->fetch_area($city, $json_file, true);*/

    }


    function fetch_properties($city, $area = '', $paging_url = '', $call = false)
    {
        $area = urldecode($area);
        if (empty($city) || empty($area)) {
            die('Type city name uni URI: fetch_properties/Karachi/DHA Defence');
        }
        $pick_json_file = "parse/{$city}-area.json";

        //echo '<pre>Pick File: ';print_r($pick_json_file);echo '</pre>';
        $pick_rows = json_decode(file_get_contents($pick_json_file));

        if (count($pick_rows) > 0) {
            foreach ($pick_rows as $i => $pick_row) {
                if (($area != $pick_row->area)) continue;

                $file_name = url_title($area);
                $file_name = "parse/{$city}/{$file_name}.txt";

                if (!is_dir(FCPATH . "/parse/{$city}")) mkdir(FCPATH . "/parse/{$city}");
                if (!file_exists(FCPATH . "/{$file_name}")) file_put_contents(FCPATH . "/{$file_name}", '');

                $lines = file($file_name);
                $url = $pick_row->url;
                if (!empty($paging_url)) {
                    $url = $paging_url;
                }

                //echo '<pre>Fetch Links: ';print_r($url);echo '</pre>';

                $html = file_get_html($url);
                if (!$html) {
                    echo '<pre>';print_r(func_get_args());echo '</pre>';
                    die("Can't Parse");
                }


                foreach ($html->find('.ba88a3b9 li.a1c9377c') as $li) {
                    $this->number++;
                    $area_url = 'https://www.zameen.com' . trim($li->find('a._7ac32433', 0)->href) . "\n";
                    $date_str = trim($li->find('.ae30f392 span', 0)->plaintext);
                    $date_str = str_replace(['Added: ', ' ago'], '', $date_str);
                    $date_str = preg_replace('/\((.*?)\)/', '', $date_str);
                    $date = date('Y-m-d', strtotime("-{$date_str}"));

                    $datetime1 = new DateTime($date);
                    $datetime2 = new DateTime(date('Y-m-d'));
                    $interval = $datetime1->diff($datetime2);


                    if ($interval->m <= 2 && !in_array($area_url, $lines)) {
                        file_put_contents($file_name, $area_url, FILE_APPEND);
                    }
                }
                //echo '<pre>'; print_r($this->number . '/' . 25 . ' + ' . 1); echo '</pre>';
                $page = (($this->number / 25) + 1);
                if ($page >= 5) {
                    if($call) return;
                    exit('5 Pages');
                }
                $paging_url = str_replace("-1.html", "-{$page}.html", $pick_row->url);
                $this->fetch_properties($city, $area, $paging_url);

                //echo '<pre>';print_r($this->number);echo '</pre>';
            }
        }
    }

    function property($city = '', $area = '', $update = 0){

        $type = getVar('type');
        $update = intval(getVar('update'));
        $city_id = intval(getVar('city_id'));
        $area_id = intval(getVar('area_id'));

        if(!empty($type)) {
            if ($city_id > 0 && $area_id > 0 && $type == 'Location') {
                $city = $this->db->get_where('cities', ['id' => $city_id], 1)->row()->city;
                $area = $this->db->get_where('area', ['id' => $area_id], 1)->row()->area;

                $this->fetch_property($city, $area, $update);
            } elseif ($type == 'URL' && !empty(getVar('url'))){
                $this->fetch_property();
            }
        } else {
            $this->load->view('parse/property');
        }

    }

    private function fetch_property($city = '', $area = '', $update = 0)
    {

        $types = singleColArray("SELECT CONCAT(' ', `type`) AS types FROM property_types", 'types');
        //$_REQUEST['url'] = 'https://www.zameen.com/Property/dha_phase_6_bukhari_commercial_area_bukhari_commercial_area_2nd_floor_flat_for_sale-11830450-6674-1.html';
        $start = intval(getVar('start'));
        $limit = intval(getVar('limit'));
        $z_images = intval(getVar('images'));

        if (!empty($_REQUEST['url'])) {
            $url = $_REQUEST['url'];//getVar('url');
            $url = urldecode($url);
            $lines[] = $url;

            $update = 1;
        } else if (!empty($city) && !empty($area)){
            $area = (urldecode($area));
            $_area = url_title(urldecode($area));
            $file_name = "parse/{$city}/{$_area}.txt";

            if(!file_exists($file_name)){
                $this->fetch_areas();
                $this->fetch_properties($city, $area, 0, true);
                set_notification("Generate ($file_name) file!", 'warning');
            }
            $lines = file($file_name);

        } else {
            die('Type city name uni URI: property/Karachi/DHA Defence');
        }

        $get_limit = -1;
        if (count($lines) > 0) {
            foreach ($lines as $i => $url) {
                if($get_limit >= $limit) continue;
                //echo '<pre>Pick From: ';print_r($url);echo '</pre>';
                /*if($start > 0){
                    if($get_limit <= $start) continue;
                }
                if($limit > 0){
                    if($get_limit >= ($start + $limit)) continue;
                }*/

                $p_row = $this->db->select('id')->get_where('properties', ['z_url' => $url], 1)->row();
                if($p_row->id > 0 && !$update) continue;
                $get_limit++;
                //file_put_contents('property-dtl.html', file_get_contents($url));
                //$url = 'property-dtl.html';

                $html = file_get_html($url);
                if (!$html) {
                    echo '<pre>';print_r(func_get_args());echo '</pre>';die("Can't Parse");
                }

                $zameen_propert_id = trim(end(explode(' ', trim($html->find('._75f200b9 span', -1)->plaintext))));
                $purpose = '';
                $city_id = $area_pid = 0;
                $i = -1;
                foreach ($html->find('._75f200b9 span') as $areas) {
                    $area = trim($areas->find('a span', 0)->plaintext);

                    if(!empty($area)) {
                        $i++;
                        if ($i == 1) {
                            $area = trim(str_replace($types, '', $area));
                            $city_id = $this->db->get_where('cities', ['city' => $area], 1)->row()->id;
                            if ($city_id == 0) {
                                $city_id = save('cities', ['city' => $area, 'country' => 'PK']);
                            }
                        } else if ($i > 1) {
                            $area_id = $this->db->get_where('area', ['area' => $area], 1)->row()->id;
                            $area_pid = ($area_pid > 0 ? $area_pid : intval($area_id));

                            if ($area_id == 0) {
                                $area_pid = save('area', ['parent_id' => $area_pid, 'area' => $area, 'city_id' => $city_id]);
                            }
                        }
                    }
                }


                $DB_data['title'] = trim($html->find('h1._64bb5b3b', 0)->plaintext);
                $DB_data['purpose'] = str_replace(['For '], '', trim($html->find('[aria-label*="purpose"] ._812aa185', 0)->plaintext));

                $type = trim($html->find('[aria-label*="type"] ._812aa185', 0)->plaintext);
                $type_id = $this->db->get_where('property_types', ['type' => $type], 1)->row()->id;
                if($type_id == 0){
                    $type_id = save('property_types', ['type' => $type, 'parent_id' => 0]);
                }
                $DB_data['type_id'] = $type_id;

                $DB_data['country_code'] = 'PK';
                $DB_data['city_id'] = $city_id;
                $DB_data['area_id'] = $area_pid;


                $DB_data['location'] = trim($html->find('[aria-label*="location"] ._812aa185', 0)->plaintext);
                $DB_data['description'] = trim($html->find('[aria-label*="Property description"]', 0)->innertext);

                $price = trim($html->find('.f9cca8de .f25915cc span', 0)->plaintext);
                $price = trim(str_replace(['PKR', ','], '', $price));
                $price = (is_int($price) ? $price : substr($price, 2));
                //echo '<pre>'; print_r($price); echo '</pre>';
                $DB_data['price'] = $price;

                $_area = trim($html->find('[aria-label*="area"] ._812aa185', 0)->plaintext);
                $_area = explode(' ', $_area);
                $DB_data['area'] = $_area[0];
                $DB_data['area_unit'] = $_area[1];
                $DB_data['square_meter'] = area_conversion(floatval($DB_data['area']), $DB_data['area_unit']);

                $DB_data['bedrooms'] = intval(trim($html->find('[aria-label*="detail beds"] ._812aa185', 0)->plaintext));
                $DB_data['bathrooms'] = intval(trim($html->find('[aria-label*="baths"] ._812aa185', 0)->plaintext));

                $DB_data['status'] = 'Inactive';
                $DB_data['z_url'] = $url;
                $DB_data['created'] = date('Y-m-d H:i:s');
                $DB_data['created_by'] = intval(_session(ADMIN_SESSION_ID));

                //echo '<pre>';print_r($DB_data);echo '</pre>';
                if($p_row->id == 0) {
                    $id = save('properties', $DB_data);
                }else{
                    $id = $p_row->id;
                    if($update){
                        save('properties', $DB_data, "id='{$id}'");
                    }
                }


                //echo '<pre>'; print_r('<a href="http://localhost/star_m/property/'.$id.'">'.$DB_data['title'].'</a>'); echo '</pre>';

                /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
                | Images
                *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
                if($z_images) {
                    $dir = "assets/front/properties/";
                    delete_rows('property_images', "property_id='{$id}'", true, ['filename' => $dir]);
                    $images = [];
                    foreach ($html->find('.image-gallery-slides .image-gallery-slide') as $i => $image) {
                        if ($image->find('img', 0)) {
                            $img_title = $image->find('img', 0)->title;
                            $img_src = $image->find('img', 0)->src;
                            array_push($images, $img_src);
                            $img_name = end(explode('/', str_replace(['-800x600'], '', $img_src)));

                            file_put_contents($dir . $img_name, file_get_contents($img_src));
                            save('property_images', ['property_id' => $id, 'filename' => $img_name, 'title' => $img_title]);
                        }
                    }
                }
                //echo '<pre>'; print_r($images); echo '</pre>';

                /**‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
                | Amenities
                *‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒*/
                delete_rows('property_amenities', "property_id='{$id}'");
                foreach ($html->find('.e475b606 > li') as $main_li) {

                    $amn_group = trim($main_li->find('._8d77b24d', 0)->plaintext);
                    $amn_group_id = 0;
                    if(!empty($amn_group)) {
                        $amn_group_id = $this->db->get_where('amenities_groups', ['title' => $amn_group], 1)->row()->id;
                        if ($amn_group_id == 0) {
                            $amn_group_id = save('amenities_groups', ['title' => $amn_group]);
                        }
                    }

                    $data_group[$amn_group] = [];

                    foreach ($main_li->find('ul li') as $li) {
                        $amnt = trim($li->find('._005a682a', 0)->plaintext);
                        $_amenity = explode(': ', $amnt);

                        $amenity = $_amenity[0];
                        $amenity_value = $_amenity[1];

                        if(in_array($_amenity[1], ['Bedrooms', 'Bathrooms']) || empty($amnt)) continue;

                        $amenity_id = $this->db->get_where('amenities', ['title' => $amenity, 'group_id' => $amn_group_id, 'for' => 'Property'], 1)->row()->id;

                        $DB_amn = ['title' => $amenity, 'code' => url_title($amenity, '-', true), 'group_id' => $amn_group_id, 'for' => 'Property'];
                        $DB_amn['input'] = 'Text';
                        if (empty($amenity_value)) {
                            $amenity_value = 'Yes';
                            $DB_amn['input'] = 'Yes / No';
                        }
                        if ($amenity_id == 0) {
                            $amenity_id = save('amenities', $DB_amn);
                        }

                        $DB_Property_Amn['property_id'] = $id;
                        $DB_Property_Amn['amenity_id'] = $amenity_id;
                        $DB_Property_Amn['amenity_value'] = $amenity_value;
                        if($id > 0) {
                            save('property_amenities', $DB_Property_Amn);
                        }
                        //echo '<pre>'; print_r($this->db->last_query()); echo '</pre>';

                        $data_group[$amn_group][] = ['name' => $amenity, 'value' => $amenity_value];
                    }
                }


                //$this->property_agent(['property_id' => $zameen_propert_id]);

                ?>
                <style>
                    .box{position:relative;height: 280px;margin: 5px;text-align: center; width: 200px;float: left;border: 1px solid #eae5e5;padding: 5px;border-radius: 3px;font-family: monospace;}
                    .box a{outline: none; text-decoration: none;}
                    .box img{width: 100%; height: 150px;}
                    .box b.Exist{color: red;}
                    .box b.New{color: #4CAF50;}
                    .box b{display: block;padding: 5px;background: rgba(0, 0, 0, 0.1); position: absolute;bottom: 5px;left: 5px;right: 5px;}
                </style>

                <div class="box">
                    <a href="<?php echo site_url("property/{$id}");?>" target="_blank">
                        <img src="<?php echo $images[0];?>" alt="">
                        <h4><?php echo $DB_data['title'];?></h4>
                        PKR <?php echo short_number($DB_data['price']);?>
                        <b class="<?php echo($p_row->id > 0 ? 'Exist' : 'New'); ?>"><?php echo($p_row->id > 0 ? 'Exist' : 'New'); ?></b>
                    </a>
                </div>

                <?php

            }
        }

        echo '<div style="clear: both">&nbsp;</div><hr><center><a href="'.site_url('parse/property').'">Back</a></center>';
    }


    function set_agent(){

        $json = json_decode($_GET['data'], true);
        $json['agent_name'] = $json['agent_name']['en'];

        $_json = json_decode(file_get_contents('numbers.json'), true);
        if($_json == null){
            $_json = [];
        }

        array_push($_json, $json);
        $_json = json_encode($_json);
        echo '<pre>UP JSON: '; print_r($_json); echo '</pre>';
        file_put_contents('numbers.json', $_json);
    }
    /**
     * @param array $data
     */
    function property_agent($data = [])
    {
        $data['property_id'] = '11830450';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.zameen.com/nfpage/async/show-numbers/");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, "property_id=11830450");

        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        if ($output == "OK") {
            echo '<pre>'; print_r($output); echo '</pre>';
        } else {
            echo '<pre>'; print_r('Fail'); echo '</pre>';
        }
    }


}


/* End of file index.php */
/* Location: ./application/controllers/index.php */