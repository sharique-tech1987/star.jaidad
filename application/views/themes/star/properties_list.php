<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_properties');
$ci->load->model(ADMIN_DIR . 'm_amenities');

if(empty($_COOKIE['area_unit'])){
    $_COOKIE['area_unit'] = 'Marla';
}

$area_attr['limit'] = 36;
$where = " AND properties.status='Active' ";
$where_different_range = " AND properties.status='Active' ";
/**------------------------------------------------------
 *  Searching
 *-----------------------------------------------------*/
$purpose = strtolower(getVar('purpose'));
$city_id = intval(getVar('city_id'));
$area_ids = getVar('area_ids');
$type_id = intval(getVar('type_id'));
$price = getVar('price');
$price['min'] = number_to_int($price['min']);
$price['max'] = number_to_int($price['max']);

$area = getVar('area');
$area['min'] = number_to_int($area['min']);
$area['max'] = number_to_int($area['max']);

$bedrooms = getVar('bedrooms');
$bathrooms = getVar('bathrooms');

if(!empty($purpose)){
    $where .= " AND LOWER(properties.purpose)='{$purpose}' ";
    $where_different_range .= " AND LOWER(properties.purpose)='{$purpose}' ";
}
if(!empty($city_id)){
    $_city = $this->db->where('id', $city_id)->get('cities')->row();
    $where .= " AND properties.city_id='{$city_id}' ";
    $where_different_range .= " AND properties.city_id='{$city_id}' ";
    $area_attr['where'] .= "AND area.city_id='{$city_id}'";
}

$_area_ids_ch = $_area_ids_int = [];
if(count($area_ids) > 0 && is_array($area_ids)){
    foreach ($area_ids as $area_id) {
        if(is_numeric($area_id)){
            $_area_ids_int[] = $area_id;
        } else if(is_string($area_id) && !is_numeric($area_id)){
            $_area_ids_ch[] = $area_id;
        }
    }

    if(count($_area_ids_ch) > 0){
        $where .= " AND area.area IN('".join("','", $_area_ids_ch)."') ";
        $where_different_range .= " AND area.area IN('".join("','", $_area_ids_ch)."') ";
    }

    if(count($_area_ids_int) > 0) {
        $_area = $this->db->where('id', intval($_area_ids_int[0]))->get('area')->row();
        $area_attr['where'] = " AND area.parent_id IN(" . join(',', array_map("intval", $_area_ids_int)) . ")";
        $where .= " AND properties.area_id IN(" . join(',', array_map("intval", $_area_ids_int)) . ") ";
        $where_different_range .= " AND properties.area_id IN(" . join(',', array_map("intval", $_area_ids_int)) . ") ";
    }
} else{
    $area_ids = [];
}

if(!empty($type_id)){
    $where .= " AND properties.type_id='{$type_id}' ";
    $where_different_range .= " AND properties.type_id='{$type_id}' ";
}
if($price['min'] > 0 && $price['max'] > 0){
    $where .= " AND properties.price BETWEEN '{$price['min']}' AND '{$price['max']}'";
} else if($price['min'] > 0){
    $where .= " AND properties.price >= '{$price['min']}' ";
} else if($price['max'] > 0){
    $where .= " AND properties.price <= '{$price['max']}' ";
}

$area_min = area_conversion(floatval($area['min']), $_COOKIE['area_unit']);
$area_max = area_conversion(floatval($area['max']), $_COOKIE['area_unit']);

if($area['min'] > 0 && $area['max'] > 0){
    $where .= " AND properties.square_meter BETWEEN '{$area_min}' AND '{$area_max}'";
    $where_different_range .= " AND properties.square_meter BETWEEN '{$area_min}' AND '{$area_max}'";
} else if($area['min'] > 0){
    $where .= " AND properties.square_meter >= '{$area_min}' ";
    $where_different_range .= " AND properties.square_meter >= '{$area_min}' ";
} else if($area['max'] > 0){
    $where .= " AND properties.square_meter <= '{$area_max}' ";
    $where_different_range .= " AND properties.square_meter <= '{$area_max}' ";
}
if($bedrooms > 0){
    if($bedrooms == 10) {
        $where .= " AND properties.bedrooms >= '{$bedrooms}'";
        $where_different_range .= " AND properties.bedrooms >= '{$bedrooms}'";
    }
    else {
        $where .= " AND properties.bedrooms = '{$bedrooms}'";
        $where_different_range .= " AND properties.bedrooms = '{$bedrooms}'";
    }
}
if($bathrooms > 0){
    if($bathrooms == 10) {
        $where .= " AND properties.bathrooms >= '{$bathrooms}'";
        $where_different_range .= " AND properties.bathrooms >= '{$bathrooms}'";
    }

    else {
        $where .= " AND properties.bathrooms = '{$bathrooms}'";
        $where_different_range .= " AND properties.bathrooms = '{$bathrooms}'";
    }
}

/**---------------------------------------------------------*/
$city = str_replace(['_'], [' '], getUri(2));
if(!empty($city)){
    $_city = $this->db->where('city', $city)->get('cities')->row();
    $city_id = $_city->id;
    $where .= " AND cities.id='{$city_id}'";
    $where_different_range .= " AND cities.id='{$city_id}'";
    $area_attr['where'] .= "AND area.city_id='{$city_id}'";
}
$x_area = explode('-', getUri(3));
$g_area_id = $area_id = end($x_area);
$__area = str_replace(['-' . end($x_area), '_'], ['', ' '], getUri(3));

if(!empty($__area)){
    $_area = $this->db->where('area', $__area)->get('area')->row();
    $area_id = $_area->id;
    $area_ids[] = $area_id;
    $_area_ids_int[] = $area_id;
//    array_push($area_ids, $area_id);
//    array_push($_area_ids_int, $area_id);
    $where .= " AND properties.area_id='{$area_id}'";
    $where_different_range .= " AND properties.area_id='{$area_id}'";
    $area_attr['where'] .= "AND area.parent_id='{$area_id}'";
    //$area_attr['where'] = " AND area.parent_id IN(".join(array_map('intval', $_area_ids_int)).") ";
}

if(count($_area_ids_int) == 0 && $city_id > 0){
    $area_attr['where'] = " AND area.parent_id='0' AND area.city_id='{$city_id}'";
}
$area_attr['city'] = $_city->city;
$area_attr['area'] = $_area->area;

/**------------------ End Searching ------------------------*/
$_is_order = '';
$order = 'properties.id DESC';
if(getVar('_price') == 'DESC'){
    $_is_order = 'Highest Price';
    $order = 'properties.price DESC';
} else if(getVar('_price') == 'ASC'){
    $_is_order = 'Lowest Price';
    $order = 'properties.price ASC';
} else if(getVar('_id') == 'DESC'){
    $_is_order = 'Newest';
    $order = 'properties.id DESC';
}

$limit = 18;
$offset = 0;
if (getVar('limit') > 0) {
    $limit = intval(getVar('limit'));
}
if (getVar('per_page') > 0) {
    $offset = intval(getVar('per_page'));
}
$rows = $ci->m_properties->rows($where, $limit, $offset, $order);
$num_rows = $ci->m_properties->num_rows;
$total_rows = $ci->m_properties->total_rows;


if( $num_rows == 0 && $price['max'] > 0){
    $percent = floatval(get_option('price_range_percent'));
    $price['max'] = $price['max'] + ($price['max'] * $percent);
    $where_different_range .= " AND properties.price <= '{$price['max']}' ";
    $recommend_rows = $ci->m_properties->rows($where_different_range, $limit, $offset, $order);
    $recommend_num_rows = $ci->m_properties->num_rows;
    $recommend_total_rows = $ci->m_properties->total_rows;
}


?>
<div><?php include "include/page_header.php";?></div>

<!--<div class="slider-main"><?php /*include('include/top_banner.php');*/?></div>-->


<!-- kj moble banner -->
<!--<div><?php /*include "news_ticker.php";*/?></div>-->
<div id="primary-content" class="-pd-top-100 pd-bottom-100 sm-pd-bottom-0">
    <div class="bg-gray">
        <div class="container clearfix">

    <div class="slider-main">
        <div id="carousel-example-generic" class="carousel page-wrap">


            <!-- Controls -->
            <div class="search mobile_none">
                <?php include(__DIR__ . '/search_form.php'); ?>
            </div>
            <div class="search onmobile nothriker" id="properties_nothriker">
                <?php include(__DIR__ . '/search_mobile.php'); ?>
            </div>
        </div>
    </div>

    <div class="container clearfix inner-container-wrap hide-mini-search">
        <div class="archive-property-inner">
            <div id="container">
                <div id="content" role="main">
                    <div class="ere-archive-property-wrap ere-property-wrap">
                        <div>
                        <?php echo get_areas($area_attr); ?>
                        </div>
                        <!--============== top filter    ==============-->
                        <div class="ere-archive-property archive-property">
                            <div class="above-archive-property">
                                <div class="ere-heading">
                                    <h2>Properties List</h2>
                                </div>
                                <div class="archive-property-action property-status-filter">
                                    <div class="archive-property-action-item">
                                        <div class="property-status property-filter">
                                            <ul>

                                                <!--<li class="<?php /*echo empty($purpose) ? 'active' : '';*/?>"><a data-status="all" href="" title="All">All</a></li>-->
                                                <li class="<?php echo ($purpose == 'Sale') ? 'active' : '';?> property-status-cust"><a href="javascript:void(0)" data-href="<?php echo generate_url('purpose');?>&purpose=Sale" title="For Sale">For Sale</a></li>
                                                <li class="<?php echo ($purpose == 'Rent') ? 'active' : '';?> property-status-cust"><a href="javascript:void(0)" data-href="<?php echo generate_url('purpose');?>&purpose=Rent" title="For Rent">For Rent</a></li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="archive-property-action-item sort-view-property">
                                        <div class="sort-property property-filter">
                                            <span class="property-filter-placeholder"><?php echo empty($_is_order) ? 'Sort By' : $_is_order;?></span>

                                              <ul class="property-filter-placeholder-custom">

                                                <li class="<?php echo ($_is_order == 'Newest') ? 'active' : '';?>"><a href="javascript:void(0)" data-href="<?php echo generate_url(['_id', '_price']);?>&_id=DESC">Newest</a></li>
                                                <li class="<?php echo ($_is_order == 'ASC') ? 'Lowest Price' : '';?>"><a href="javascript:void(0)" data-href="<?php echo generate_url(['_id', '_price']);?>&_price=ASC">Lowest Price</a></li>
                                                <li class="<?php echo ($_is_order == 'Highest Price') ? 'active' : '';?>"><a href="javascript:void(0)" data-href="<?php echo generate_url(['_id', '_price']);?>&_price=DESC">Highest Price</a></li>
                                            </ul>
                                        </div>
                                        <div class="view-as">
                                            <span data-view-as="property-list" class="view-as-list" title="View as List">
                                                <i class="fa fa-list-ul"></i>
                                            </span>
                                            <span class="view-as-grid" title="View as Grid">
                                                <i class="fa fa-th-large"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!--============== properties listing    ==============-->
                            <div class="ere-property clearfix property-grid col-gap-30 columns-3 columns-md-3 columns-sm-2 columns-xs-1 columns-mb-1">

                                <?php
                                if (count($rows) > 0) {
                                    foreach ($rows as $row) {
                                        $amenities_code = ['air-conditioning', 'kitchens'];
                                        $amenities = $ci->m_amenities->amenities($row->id, '', 'Property', $amenities_code);
                                        //echo '<pre>'; print_r($amenities); echo '</pre>';
                                        include('include/properties_listing.php');
                                        ?>
                                    <?php }
                                    ?>
                                    <div class="clearfix"></div>

                                    <!--============== pagination ==============-->
                                    <?php

                                    $config['base_url'] = generate_url('per_page');
                                    $config['total_rows'] = $total_rows;
                                    $config['per_page'] = $limit;
                                    $config['page_query_string'] = TRUE;
                                    $choice = $config["total_rows"] / $config["per_page"];
                                    $config["total_links"] = ceil($choice);
                                    $config["num_links"] = 6;

                                    $config['attributes'] = array('class' => 'page-numbers');
                                    $config['cur_tag_open'] = '<span class="page-numbers current">';
                                    $config['cur_tag_close'] = '</span>';

                                    $this->pagination->initialize($config);
                                    $pagination = $this->pagination->create_links();
                                    ?>
                                    <div class="paging-navigation clearfix">
                                        <?php echo $pagination; ?>
                                    </div>
                                <?php } else {
                                    ?>
                                    <div class="clearfix"></div>
                                    <div class="alert alert-danger">Properties not found.</div>
                                    <?php
                                } ?>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

            <!-- Recommended Listing -->
            <?php if($num_rows == 0 && $recommend_num_rows > 0) { ?>
                <div class="container clearfix inner-container-wrap hide-mini-search sj-recommended">
                <div class="archive-property-inner">
                    <div id="container">
                        <div id="content" role="main">
                            <div class="ere-archive-property-wrap ere-property-wrap">
                                <!--============== top filter    ==============-->
                                <div class="ere-archive-property archive-property">
                                    <?php include('include/properties_list_header.php'); ?>

                                    <!--============== recommended listing    ==============-->
                                    <div class="ere-property clearfix property-grid col-gap-30 columns-3 columns-md-3 columns-sm-2 columns-xs-1 columns-mb-1">

                                        <?php
                                        if (count($recommend_rows) > 0) {
                                            foreach ($recommend_rows as $row) {
                                                $amenities_code = ['air-conditioning', 'kitchens'];
                                                $amenities = $ci->m_amenities->amenities($row->id, '', 'Property', $amenities_code);
                                                //echo '<pre>'; print_r($amenities); echo '</pre>';
                                                include('include/recommended_listing.php');
                                                ?>
                                            <?php }
                                            ?>
                                            <div class="clearfix"></div>

                                            <!--============== pagination ==============-->
                                            <?php

                                            $config['base_url'] = generate_url('per_page');
                                            $config['total_rows'] = $recommend_total_rows;
                                            $config['per_page'] = $limit;
                                            $config['page_query_string'] = TRUE;
                                            $choice = $config["total_rows"] / $config["per_page"];
                                            $config["total_links"] = ceil($choice);
                                            $config["num_links"] = 6;

                                            $config['attributes'] = array('class' => 'page-numbers');
                                            $config['cur_tag_open'] = '<span class="page-numbers current">';
                                            $config['cur_tag_close'] = '</span>';

                                            $this->pagination->initialize($config);
                                            $pagination = $this->pagination->create_links();
                                            ?>
                                            <div class="paging-navigation clearfix">
                                                <?php echo $pagination; ?>
                                            </div>
                                        <?php } else {
                                            ?>
                                            <div class="clearfix"></div>
                                            <div class="alert alert-danger">Sorry No Recommendations Are Found.</div>
                                            <?php
                                        } ?>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
            else if($num_rows == 0 && $recommend_num_rows == 0) {
             ?>
                <div class="container clearfix inner-container-wrap hide-mini-search sj-recommended">
                    <div class="archive-property-inner">
                        <div id="container">
                            <div id="content" role="main">
                                <div class="ere-archive-property-wrap ere-property-wrap">
                                    <!--============== top filter    ==============-->
                                    <div class="ere-archive-property archive-property">
                                        <?php include('include/properties_list_header.php'); ?>

                                        <div class="ere-property clearfix property-grid col-gap-30 columns-3 columns-md-3 columns-sm-2 columns-xs-1 columns-mb-1">
                                            <div class="clearfix"></div>
                                            <div class="alert alert-danger">Sorry No Recommendations Are Found.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
</div>
<style>

     .cust-loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #800000; /* Blue */
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 2s linear infinite;
        margin-left: auto;
        margin-right: auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
