<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_properties');
$ci->load->model(ADMIN_DIR . 'm_amenities');

//$agent_id = _session(FRONT_SESSION_ID);
$agent_id = intval(getUri(2));
$where = " AND properties.status='Active' AND properties.created_by='{$agent_id}'";

$limit = 24;
$offset = 0;
$order = 'properties.id DESC';
if (getVar('limit') > 0) {
    $limit = intval(getVar('limit'));
}
if (getVar('per_page') > 0) {
    $offset = intval(getVar('per_page'));
}

$rows = $ci->m_properties->rows($where, $limit, $offset, $order);
$num_rows = $ci->m_properties->num_rows;
$total_rows = $ci->m_properties->total_rows;

if($total_rows > 0){
?>

    <div class="single-property-element property-description">
    <div class="ere-heading-style2">
        <h2>Agent Properties</h2>
    </div>
    <div class="ere-property-element">
    <div class="ere-archive-property archive-property">
        

        <div class="ere-property clearfix property-grid col-gap-30 columns-3 columns-md-3 columns-sm-2 columns-xs-1 columns-mb-1">
            <?php
            if (count($rows) > 0){
                foreach ($rows as $row) {
                    $amenities_code = ['air-conditioning', 'kitchens'];
                    $amenities = $ci->m_amenities->amenities($row->id, '', 'Property', $amenities_code);
                    //echo '<pre>'; print_r($amenities); echo '</pre>';

                    $address_ = explode(",", $row->full_address);
                    $path_url = $address_[0] . '-' . $row->city . '-' . $row->country_code . '-' . $row->title;
                    $url = site_url("property/" . friendly_url($path_url,'-',true,$row->id));

                    ?>
                    <!-- Property Block -->

                    <div class="mg-bottom-30 ere-item-wrap">
                        <div class="property-inner">
                            <div class="property-image">
                                <?php


                                //if(file_exists(ROOT . "assets/front/properties/{$row->image}"))
                                {
                                    $image = checkAltImg("assets/front/properties/{$row->image}");
                                    if(!empty(get_option('wm_logo'))) {
                                        $wm_img = ADMIN_ASSETS_DIR . 'img/' . get_option('wm_logo');
                                        $img_url = base_url(_Image::wm($image, 340, 250, $wm_img));
                                    } else {
                                        $img_url = base_url(_Image::open($image)->zoomCrop(340, 250));
                                    }

                                }/* else {
                        $address = urlencode($row->full_address. ", Pakistan ");
                        $img_url = "https://maps.googleapis.com/maps/api/staticmap?center={$address}&zoom=13&size=340x250&maptype=roadmap
                        &markers=color:red%7Clabel:C%7C{$address}
                        &key=" . get_option('gmap_key');
                    }*/

                                ?>
                                <img src="<?php echo ($img_url);?>" alt="<?php echo $row->title;?>">

                                <div class="property-action block-center">
                                    <div class="block-center-inner">

                                        <div class="property-view-gallery-wrap" data-toggle="tooltip" title="View Images">
                                            <a href="<?php echo $img_url;?>" class="lightbox-image" data-fancybox="property_<?php echo $row->id;?>">
                                                <i class="fa fa-camera"></i>
                                            </a>
                                        </div>

                                        <a href="<?php echo site_url("member/wishlist/add/{$row->id}");?>" class="property-favorite" data-toggle="tooltip" title="Add to Favorite" data-title-not-favorite="Add to Favorite" data-icon-favorited="fa fa-star">
                                            <i class="fa fa-star-o"></i>
                                        </a>

                                        <!--<a class="compare-property" href="<?php /*echo site_url("property/{$row->id}");*/?>" data-toggle="tooltip" title="Compare">
                                <i class="fa fa-plus"></i>
                            </a>-->
                                    </div>
                                    <a class="property-link" href="<?php echo $url;?>"></a>
                                </div>
                                <div class="property-label property-featured">
                                    <p class="label-item">
                                        <span class="property-label-bg"> Featured <span class="property-arrow"></span></span>
                                    </p>
                                </div>
                                <div class="p_list property-item-content-inner">
                                    <div class="property-date">
                                        <i class="fa fa-calendar accent-color"></i>
                                        <?php echo get_date_diff($row->created, date('Y-m-d H:i:s'));?> ago
                                    </div>
                                    <!--<div class="property-agent">
                                        <a href="" title="Ghaly Marco">
                                            <i class="fa fa-user accent-color"></i>
                                            <span>Ghaly Marco</span>
                                        </a>
                                    </div>-->
                                </div>
                            </div>
                            <div class="property-item-content">
                                <div class="property-type">
                                    <i class="fa fa-tag accent-color"></i>
                                    <a href="#" title="<?php echo $row->type;?>"><span><?php echo $row->type;?> </span></a>
                                </div>
                                <div class="property-heading">
                                    <h4 class="property-title fs-18">
                                        <a href="<?php echo $url;?>"><?php echo $row->title;?></a>
                                    </h4>
                                </div>
                                <div class="property-location">
                                    <i class="fa fa-map-marker accent-color"></i>
                                    <a target="_blank" href="<?php echo $url;?>">
                                        <span><?php echo $row->full_address;?></span>
                                    </a>
                                </div>
                                <div class="property-info">
                                    <div class="property-info-inner clearfix">
                                        <div class="property-area">
                                            <div class="property-area-inner">
                                                <i class="icon-assembly-area"></i>
                                                <span class="property-info-value"><?php
                                                    $_area_unit = area_conversion(floatval($row->area), $row->area_unit, $_COOKIE['area_unit']);
                                                    echo number_format($_area_unit, (end(explode('.', number_format($_area_unit, 2))) > 0 ? 2 : 0));?> <?php echo $_COOKIE['area_unit'];?>
                                    </span>
                                            </div>
                                        </div>
                                        <div class="property-bedrooms">
                                            <div class="property-bedrooms-inner">
                                                <i class="icon-bed-1"></i>
                                                <span class="property-info-value"><?php echo number_format($row->bedrooms);?> Bedrooms</span>
                                            </div>
                                        </div>
                                        <div class="property-bathrooms">
                                            <div class="property-bathrooms-inner">
                                                <i class="icon-bathtub-1"></i>
                                                <span class="property-info-value"><?php echo number_format($row->bathrooms);?> Bathrooms</span>
                                            </div>
                                        </div>
                                        <div class="property-garages">
                                            <div class="property-garages-inner">
                                                <i class="icon-car-garage"></i>
                                                <span class="property-info-value"><?php echo number_format(intval($amenities['kitchens']->value));?> Kitchen</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="property-excerpt">
                                    <p>Solum vidisse eum ea. Ei solum essent delicata mei, ad quis
                                        quaerendum sit. Usu accumsan iudicabit cu, an his ferri
                                        legere habemus, cu fastidii consequat sit. Ne per augue
                                        munere, cibo doming persius ex sit.</p>
                                </div>-->
                                <div class="property-status-price">
                                    <div class="property-status">
                                        <p class="status-item">
                                <span class="property-status-bg"
                                      style="background-color: ">For <?php echo strtoupper($row->purpose);?> </span>
                                        </p>
                                    </div>
                                    <div class="property-price">
                                        <span><?php echo short_number($row->price);?><!--<span class="property-price-postfix"> / Month</span> --></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                }
            }
            ?>
            </div>


            <?php
            $config['base_url'] = generate_url('per_page');
            $config['total_rows'] = $total_rows;
            $config['per_page'] = $limit;
            $config['page_query_string'] = TRUE;
            $choice = $config["total_rows"] / $config["per_page"];
            $config["total_links"] = ceil($choice);
            $config["num_links"] = 6;


            $config['full_tag_open'] = ' <ul class="clearfix">';
            $config['full_tag_close'] = '</ul>';

            $config['first_tag_open'] = '<li class="prev">';
            $config['first_tag_close'] = '<li>';

            $config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            $config['prev_link'] = 'Prev';

            $config['next_link'] = 'Next';
            $config['next_tag_open'] = '<li class="next">';
            $config['next_tag_close'] = '</li>';

            $config['last_tag_open'] = '<li class="next">';
            $config['last_tag_close'] = '</li>';

            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active"><a href="#"><span>';
            $config['cur_tag_close'] = '</span></a></li>';

            $this->pagination->initialize($config);
            $pagination = $this->pagination->create_links();
            ?>
            <div class="paging-navigation clearfix">
                <?php echo $pagination;?>
            </div>

    </div>
    </div>
    </div>
<?php } ?>