<?php
/**
 * Adnan Bashir
 * Email: developer.adnan@gmail.com
 */

//////////////////////////////////////////////////////////////////
// Get Site URL
//////////////////////////////////////////////////////////////////
add_shortcode('site_url', 'site_url');
add_shortcode('asset_url', 'asset_url');
add_shortcode('template_url', 'template_url');
add_shortcode('base_url', 'base_url');

//////////////////////////////////////////////////////////////////
// Get Option
//////////////////////////////////////////////////////////////////
add_shortcode('option', 'get_option_value');
function get_option_value($atts, $content = null)
{

    $ci =& get_instance();
    extract(shortcode_atts(array(
        'name' => '',
        'number_format' => '',
    ), $atts));

    if ($atts['number_format'] == true) {
        $_option_val = number_format(get_option($atts['name']));
    } else {
        $_option_val = get_option($atts['name']);
    }
    $html = $_option_val;

    return $html;
}

//////////////////////////////////////////////////////////////////
// Include File
//////////////////////////////////////////////////////////////////
add_shortcode('include', 'shortcode_include_file');
function shortcode_include_file($atts, $content = null)
{
    $ci =& get_instance();

    if (file_exists(get_template_directory() . $atts['file'])) {

        $html = $ci->load->view(get_template_directory(true) . $atts['file'], array(), true);
    } else {
        $html = $atts['file'] . ' File not found';
    }

    $html .= do_shortcode($content);
    return $html;
}

//////////////////////////////////////////////////////////////////
// navigation
//////////////////////////////////////////////////////////////////
add_shortcode('navigation', 'get_navigation');
function get_navigation($atts, $content = null)
{
    $ci =& get_instance();

    $html = get_nav($atts['id']);

    $html .= do_shortcode($content);
    return $html;
}

//////////////////////////////////////////////////////////////////
// CMS Block
//////////////////////////////////////////////////////////////////
add_shortcode('cms_block', 'get_cms_block');
function get_cms_block($atts, $content = null)
{
    $ci =& get_instance();

    $html = $ci->cms->get_block($atts['identifier']);

    $html .= do_shortcode($content);
    return $html;
}


//////////////////////////////////////////////////////////////////
// Area's
//////////////////////////////////////////////////////////////////
add_shortcode('areas', 'get_areas');
function get_areas($atts, $content = null)
{
    $ci =& get_instance();

    $ci->load->model(ADMIN_DIR . 'm_area');

    $data['attr'] = shortcode_atts(array(
        'city' => '',
        'area' => '',
        'where' => '',
        'limit' => 0,
    ), $atts);

    $data['rows'] = $ci->m_area->rows($data['attr']['where'], $data['attr']['limit'], 0, $data['attr']['order_by'], '', 1);
    $html = '';

    $html .= $ci->load->view(theme_dir("shortcodes_temp/area_list", true), $data, true);

    //$html .= do_shortcode($content);
    return $html;
}

//////////////////////////////////////////////////////////////////
// Area Review's
//////////////////////////////////////////////////////////////////
add_shortcode('area_reviews', 'get_area_reviews');
function get_area_reviews($atts, $content = null)
{
    $ci =& get_instance();

    $ci->load->model(ADMIN_DIR . 'm_area');

    $data['attr'] = shortcode_atts(array(
        'area_id' => '0',
        'limit' => 0,
    ), $atts);

    $data['rows'] = $ci->m_area->get_reviews($data['attr']['area_id'], $data['attr']['limit']);
    //echo '<pre>'; print_r($data['rows']); echo '</pre>';
    $html = '';
    if (count($data['rows']['reviews']) > 0) {
        $html .= '<div class="property-block reviews-block">';
        $html .= '<div class="-image-box">';
        $html .= '<div class="single-item-carousel owl-carousel owl-theme owl-carousel-cust" data-plugin-options=\'{"autoplay": true, "nav": false, "responsive": {"0" : {"items" : 1, "margin": 0}}}\'>';
        foreach ($data['rows']['reviews'] as $row) {

            $full_name = $row->first_name . ' ' . $row->last_name;
            $user_name = (count($row->user_id) > 0) ? $full_name : $row->name;
            $comments = substr(strip_tags($row->comment), 0, 37);
            $comments_condition = strlen($row->comment) > 38 ? '<a href="' . site_url("property/area_reviews/{$data['attr']['area_id']}") . '" class="read_more_text"> View More</a>':'';

            $html .= '<div class="-image  image-cust">
                        <div class="thumb-box thumb-box-cust col-xs-4 col-sm-4 col-md-5">
                            <figure class="thumb thumb-cust"><img src="' . _img(asset_url("front/users/{$row->photo}"), 100, 100, USER_IMG_NA) . '" alt="' . $row->full_name . '"></figure>
                        </div>
                        <div class="align_css col-xs-8 col-sm-8 col-md-7">
							<p class="comment_name">' . $user_name . '</p>
							<p class="star_rating"><div class="rating_cust">'.$row->star_rating . '</div></p>   
							<p class="comment">' . $comments . '</p>
							<p class="read_more_div">' . $comments_condition . '</p>
                        </div>
                    </div>';
        }
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="row"><div class="col-lg-12 text-center"><a href="' . site_url("property/area_reviews/{$data['attr']['area_id']}") . '" class="theme-btn btn-style-one ">More Review\'s</a><br><br></div></div>';
    } else {
        $html .= '<div class="row"><div class="col-lg-12 text-center"><br>
            <div class="alert alert-danger">No reviews available.</div>    
            <a href="' . site_url("property/area_reviews/{$data['attr']['area_id']}") . '" class="theme-btn btn-style-one ">Submit a review</a><br><br></div></div>';
    }
    //$html .= do_shortcode($content);
    return $html;
}

//////////////////////////////////////////////////////////////////
// Starts
//////////////////////////////////////////////////////////////////
add_shortcode('top_stars', 'get_stars');
function get_stars($atts, $content = null)
{
    $ci =& get_instance();

    extract(shortcode_atts(array(
        'rows' => 3,
    ), $atts));

    $data['rows'] = $ci->db->order_by('id DESC')->get_where('stars', array('status' => 'Active'), $atts['rows'])->result();


    $html = $ci->load->view(theme_dir('shortcodes_temp/stars', true), $data, true);

    $html .= do_shortcode($content);
    return $html;
}

//////////////////////////////////////////////////////////////////
// Events
//////////////////////////////////////////////////////////////////
add_shortcode('top_events', 'get_events');
function get_events($atts, $content = null)
{
    $ci =& get_instance();

    extract(shortcode_atts(array(
        'rows' => 5,
    ), $atts));

    $data['rows'] = $ci->db->order_by('id DESC')->get_where('events', array('status' => 'Active'), $atts['rows'])->result();

    $html = $ci->load->view(theme_dir('shortcodes_temp/events', true), $data, true);

    $html .= do_shortcode($content);
    return $html;
}


/*------------------------------- Schortcodes------------------------------------------------*/
