<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_projects');
$ci->load->model(ADMIN_DIR . 'm_amenities');
$ci->load->model(ADMIN_DIR . 'm_project_properties');

$limit = 6;
$offset = 0;
$order = 'projects.id DESC';
$where = " AND projects.status='Active' ";

$rows = $ci->m_projects->rows($where, $limit, $offset, $order);
?>
<div class="vc_row wpb_row vc_row-fluid">
    <div class="wpb_column vc_column_container vc_col-sm-12">
        <div class="vc_column-inner">
            <div class="wpb_wrapper">
<!--                <div class="g5plus-space space-5cec5e37b24b5" data-id="5cec5e37b24b5" data-tablet="70" data-tablet-portrait="50" data-mobile="40" data-mobile-landscape="40" style="clear: both; display: block; height: 30px"></div>-->
                <div class="ere-property-wrap">
                    <div class="ere-property clearfix property-carousel ">
                        <div class="container">
                            <div class="ere-heading ere-item-wrap mg-bottom-20 sm-mg-bottom-10  ere-heading-sub">
                                <h2>TRENDING PROJECTS</h2>
                                <!--<p>FIND YOUR HOUSE IN YOUR CITY</p>-->
                            </div>
                        </div>
                        <div class="property-content owl-carousel manual" data-section-id="5cec5e37b3b4f" data-callback="owl_callback" data-plugin-options='{"dots": false, "nav": true, "autoplay": true, "autoplaySpeed": 5000, "responsive": {"0" : {"items" : 1, "margin": 0}, "480" : {"items" : 1, "margin": 0}, "768" : {"items" : 2, "margin": 30}, "992" : {"items" : 3, "margin": 30}, "1200" : {"items" : 3, "margin": 30}, "1820" : {"items" : 3, "margin": 30}}}'>
                            <?php
                            if (count($rows) > 0) {
                                foreach ($rows as $row) {
                                    $amenities_code = ['air-conditioning', 'kitchens'];
                                    $amenities = $ci->m_amenities->amenities($row->id, '', 'Project', $amenities_code);
                                    $property = $ci->m_project_properties->row(0, " AND project_id='{$row->id}'");

                                    //if(file_exists(ROOT . "assets/front/projects/{$row->image}"))
                                    {
                                        $image = checkAltImg("assets/front/projects/{$row->image}");
                                        if(!empty(get_option('wm_logo'))) {
                                            $wm_img = ADMIN_ASSETS_DIR . 'img/' . get_option('wm_logo');
                                            $img_url = base_url(_Image::wm($image, 370, 320, $wm_img));
                                        } else {
                                            $img_url = base_url(_Image::open($image)->zoomCrop(370, 320));
                                        }
                                    } /*else {
                                        $address = urlencode($row->full_address. ", Pakistan ");
                                        $img_url = "https://maps.googleapis.com/maps/api/staticmap?center={$address}&zoom=13&size=340x340&maptype=roadmap
                                    &markers=color:red%7Clabel:C%7C{$address}
                                    &key=" . get_option('gmap_key');
                                    }*/

                                     $path_url=$row->area.'-'.$row->city.'-'.$row->country.'-'.$row->title;

                                    ?>

                                    <div class="property-content">
                                        <div class="property-item mg-bottom-30">
                                            <div class="property-inner">
                                                <div class="property-image ">
                                                    <img src="<?php echo ($img_url); ?>" alt="<?php echo $row->title; ?>">
                                                    <div class="property-action block-center">
                                                        <div class="block-center-inner">
                                                            <div class="property-view-gallery-wrap" data-toggle="tooltip" title="" data-original-title="View Images">
                                                                <a href="<?php echo $img_url;?>" class="lightbox-image" data-fancybox="property"><i class="fa fa-camera"></i></a>
                                                            </div>
                                                            <a href="<?php echo site_url("member/wishlist/add/{$row->id}");?>" class="property-favorite" data-toggle="tooltip" title="" data-title-not-favorite="Add to Favorite" data-title-favorited="It is my favorite" data-icon-not-favorite="fa fa-star-o" data-icon-favorited="fa fa-star" data-original-title="Add to Favorite"><i class="fa fa-star-o"></i></a>
                                                            <!--<a href="<?php /*echo site_url("project/{$row->id}");*/?>" class="compare-property" data-toggle="tooltip" title="" data-original-title="Compare"> <i class="fa fa-plus"></i> </a>-->
                                                        </div>
                                                        <a class="property-link" href="<?php echo site_url("project/".friendly_url($path_url, '-', true, $row->id));?>" title=""></a>
                                                    </div>
                                                    <div class="property-label property-featured">
                                                        <p class="label-item"> <span class="property-label-bg">Featured <span class="property-arrow"></span></span>
                                                        </p>
                                                    </div>
                                                    <div class="property-item-content-inner">
                                                        <div class="property-date"><i class="fa fa-calendar accent-color"></i> <?php echo get_date_diff($row->created, date('Y-m-d H:i:s'));?> ago</div>
                                                        <!--<div class="property-agent">
                                                            <a href=""> <i class="fa fa-user accent-color"></i> <span>Ghaly Marco</span> </a>
                                                        </div>-->
                                                    </div>
                                                </div>
                                                <div class="property-item-content ">
                                                    <div class="property-type"> <i class="fa fa-tag accent-color"></i>
                                                        <p>&nbsp;</p>
                                                    </div>
                                                    <div class="property-heading">



                                                        <h4 class="property-title fs-18"><a href="<?php echo site_url("project/".friendly_url($path_url, '-', true, $row->id));?>" ><?php echo $row->title;?></a></h4></div>
                                                    <div class="property-location"> <i class="fa fa-map-marker accent-color"></i>
                                                        <a target="_blank" href="javascript:;"><span><?php echo $row->full_address;?></span></a></div>
                                                    <div class="property-info">
                                                        <div class="property-info-inner clearfix">
                                                            <div class="property-area">
                                                                <div class="property-area-inner"> <i class="icon-assembly-area"></i> <span class="property-info-value"> <?php echo number_format($property->area) . ' - ' . short_area_unit($property->area_unit);?> </span></div>
                                                            </div>
                                                            <!--<div class="property-bedrooms">
                                                                <div class="property-bedrooms-inner"> <i class="icon-bed-1"></i> <span class="property-info-value"><?php /*echo number_format($row->bedrooms);*/?> Bedrooms</span></div>
                                                            </div>
                                                            <div class="property-bathrooms">
                                                                <div class="property-bathrooms-inner"> <i class="icon-bathtub-1"></i> <span class="property-info-value"><?php /*echo number_format($row->bathrooms);*/?> Bathrooms</span></div>
                                                            </div>
                                                            <div class="property-garages">
                                                                <div class="property-garages-inner"> <i class="icon-car-garage"></i> <span class="property-info-value"><?php /*echo number_format(intval($amenities['kitchens']->value));*/?> Kitchen</span></div>
                                                            </div>-->
                                                        </div>
                                                    </div>
                                                    <div class="property-excerpt">
                                                        <p>&nbsp;</p>
                                                    </div>
                                                    <div class="property-status-price">
                                                        <div class="property-status">
                                                            <p class="status-item">
                                                                <a href="<?php echo site_url("project/".friendly_url($path_url, '-', true, $row->id));?>" style="color: #ffffff">
                                                                    <span class="property-status-bg">More Detail </span>
                                                                </a>
                                                            </p>
                                                        </div>
                                                        <div class="property-price">
                                                            <span>
                                                            <?php echo short_number($row->price_from) . ' - ' . short_number($row->price_to); ?></div>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                <?php } }?>
                        </div>
                    </div>
                    <div class="trend_project_view_div">
                        <div class="trend_project_view_all"><a href="<?php echo site_url("project/"); ?>" >View All</a></div>
                    </div>
                </div>
<!--                <div class="g5plus-space space-5cec5e37ba70d" data-id="5cec5e37ba70d" data-tablet="80" data-tablet-portrait="60" data-mobile="40" data-mobile-landscape="40" style="clear: both; display: block; height: 100px"></div>-->
            </div>
        </div>
    </div>
</div>