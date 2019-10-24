<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_properties');
$ci->load->model(ADMIN_DIR . 'm_amenities');

$limit = 6;
$offset = 0;
$order = 'properties.id DESC';
$where = " AND properties.status='Active' ";

$rows = $ci->m_properties->rows($where, $limit, $offset, $order);
?>
<div class="vc_row wpb_row vc_row-fluid">
    <div class="wpb_column vc_column_container vc_col-sm-12">
        <div class="vc_column-inner">
            <div class="wpb_wrapper">
                <!--<div class="g5plus-space space-5cec5e37b24b5" data-id="5cec5e37b24b5" data-tablet="70" data-tablet-portrait="50" data-mobile="40" data-mobile-landscape="40" style="clear: both; display: block; height: 30px"></div>-->
                <div class="ere-property-wrap">
                    <div class="ere-property clearfix property-carousel ">
                        <div class="container">
                            <div class="ere-heading ere-item-wrap mg-bottom-20 sm-mg-bottom-40  ere-heading-sub">
                                <h2>HOT PROPERTIES</h2>
                                <p>FIND YOUR HOUSE IN YOUR CITY</p>
                            </div>
                        </div>
                        <div class="property-content owl-carousel manual" data-section-id="5cec5e37b3b4f" data-callback="owl_callback" data-plugin-options='{"dots": false, "nav": true, "autoplay": true, "autoplaySpeed": 5000, "responsive": {"0" : {"items" : 1, "margin": 0}, "480" : {"items" : 1, "margin": 0}, "768" : {"items" : 2, "margin": 30}, "992" : {"items" : 3, "margin": 30}, "1200" : {"items" : 3, "margin": 30}, "1820" : {"items" : 3, "margin": 30}}}'>
                            <?php
                            if (count($rows) > 0) {
                                foreach ($rows as $row) {

                                    $address_ = explode(",", $row->full_address);
                                    $path_url = $address_[0] . '-' . $row->city . '-' . $row->country_code . '-' . $row->title;
                                    $url = site_url("property/" . friendly_url($path_url,'-',true,$row->id));

                                    $amenities_code = ['air-conditioning', 'kitchens'];
                                    $amenities = $ci->m_amenities->amenities($row->id, '', 'Property', $amenities_code);
                                    //echo '<pre>'; print_r($amenities); echo '</pre>';

                                    //if(file_exists(ROOT . "assets/front/properties/{$row->image}"))
                                    {
                                        $image = checkAltImg("assets/front/properties/{$row->image}");
                                        if(!empty(get_option('wm_logo'))) {
                                            $wm_img = ADMIN_ASSETS_DIR . 'img/' . get_option('wm_logo');
                                            $img_url = base_url(_Image::wm($image, 340, 340, $wm_img));
                                        } else {
                                            $img_url = base_url(_Image::open($image)->zoomCrop(340, 340));
                                        }

                                    } /*else {
                                        $address = urlencode($row->full_address. ", Pakistan ");
                                        $img_url = "https://maps.googleapis.com/maps/api/staticmap?center={$address}&zoom=13&size=340x340&maptype=roadmap
                                    &markers=color:red%7Clabel:C%7C{$address}
                                    &key=" . get_option('gmap_key');
                                    }*/

                                    $row->videos = json_decode($row->videos);

                                    $address_=explode(",",$row->full_address);
                                    $path_url=$address_[0].'-'.$row->city.'-'.$row->country_code.'-'.$row->title;
                                    ?>

                                    <div class="property-item">
                                        <div class="property-inner">
                                            <div class="property-image ">
                                                <?php
                                                if(!empty($row->videos[0]) && !(file_exists(ROOT . "assets/front/properties/{$row->image}"))){
                                                    $image = "https://i1.ytimg.com/vi/".get_youtube_id($row->videos[0])."/0.jpg";
                                                    ?>
                                                    <div class="entry-thumb-wrap">
                                                        <div class="entry-thumbnail post-video">
                                                            <a class="entry-thumbnail-overlay" href="<?php echo $url;?>" title="<?php echo $row->title;?>">
                                                                <img width="340" height="340" src="<?php echo base_url(_Image::open($image)->resize(340, 340));?>" alt="<?php echo $row->title;?>">
                                                            </a> <a class="view-video zoomGallery" data-src="https://www.youtube.com/watch?v=<?php echo get_youtube_id($row->videos[0]);?>"><i class="fa fa-play"></i></a>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <img width="340" height="340" src="<?php echo $img_url; ?>" alt="<?php echo $row->title;?>" title="<?php echo $row->title;?>">
                                                <?php } ?>

                                                <div class="property-action block-center">
                                                    <div class="block-center-inner">
                                                        <div class="property-view-gallery-wrap" data-toggle="tooltip" title="View Images">
                                                            <a href="<?php echo $img_url;?>" class="lightbox-image" data-fancybox="property_<?php echo $row->id;?>"><i class="fa fa-camera"></i></a>
                                                        </div>
                                                        <a href="<?php echo site_url("member/wishlist/add/{$row->id}");?>" class="property-favorite" data-toggle="tooltip" title="Add to Favorite" data-title-not-favorite="Add to Favorite" data-title-favorited="It is my favorite" data-icon-not-favorite="fa fa-star-o" data-icon-favorited="fa fa-star"><i class="fa fa-star-o"></i></a>
                                                        <!--<a class="compare-property" href="<?php /*echo $url;*/?>" data-toggle="tooltip" title="Compare"> <i class="fa fa-plus"></i> </a>-->
                                                    </div>
                                                    <a class="property-link" href="<?php echo $url;?>" title="<?php echo $row->title;?>"></a>
                                                </div>
                                                <div class="property-label property-featured">
                                                    <p class="label-item"><span class="property-label-bg">Featured <span class="property-arrow"></span></span></p>
                                                </div>
                                                <div class="property-item-content-inner">
                                                    <div class="property-date"><i class="fa fa-calendar accent-color"></i> <?php echo get_date_diff($row->created, date('Y-m-d H:i:s'));?> ago</div>
                                                    <div class="property-agent">
                                                        <a href="javascript:;" title=""> <i class="fa fa-user accent-color"></i><span><?php echo $row->agent_name; ?></span> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="property-item-content ">
                                                <div class="property-type"><i class="fa fa-tag accent-color"></i>
                                                    <a href="javascript:;" title="<?php echo $row->type;?>"><span><?php echo $row->type;?> </span></a>
                                                </div>
                                                <div class="property-heading">
                                                    <h4 class="property-title fs-18"><a href="<?php echo $url;?>" title="<?php echo $row->title;?>"><?php echo $row->title;?></a></h4></div>
                                                <div class="property-location"><i class="fa fa-map-marker accent-color"></i>
                                                    <a target="_blank" href="javascript:;"><span><?php echo $row->full_address;?></span></a>
                                                </div>
                                                <div class="property-info">
                                                    <div class="property-info-inner clearfix">
                                                        <div class="property-area">
                                                            <div class="property-area-inner"><i class="icon-assembly-area"></i>
                                                                <span class="property-info-value"> <?php echo number_format($row->area);?> <?php echo short_area_unit($row->area_unit);?> </span></div>
                                                        </div>
                                                        <div class="property-bedrooms">
                                                            <div class="property-bedrooms-inner"><i class="icon-bed-1"></i>
                                                                <span class="property-info-value"><?php echo number_format($row->bedrooms);?> Bedrooms</span></div>
                                                        </div>
                                                        <div class="property-bathrooms">
                                                            <div class="property-bathrooms-inner"><i class="icon-bathtub-1"></i>
                                                                <span class="property-info-value"><?php echo number_format($row->bathrooms);?> Bathrooms</span></div>
                                                        </div>
                                                        <div class="property-garages">
                                                            <div class="property-garages-inner">
                                                                <!--<i class="icon-car-garage"></i>-->
                                                                <span class="fa -fa-hotel accent-color"><img src="<?php echo _img(media_url('images/kitchen.png'), 24, 24);?>" alt="Kitchens"></span>
                                                                <span class="property-info-value" style="line-height: 30px;"><?php echo number_format(intval($amenities['kitchens']->value));?> Kitchen</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="property-excerpt">
                                                    <p><?php echo substr(strip_tags($row->description), 0, 205);?></p>
                                                </div>
                                                <div class="property-status-price">
                                                    <div class="property-status">
                                                        <p class="status-item"><span class="property-status-bg">For <?php echo strtoupper($row->purpose);?> </span>
                                                        </p>
                                                    </div>
                                                    <div class="property-price">
                                                        <span> <?php echo short_number($row->price);?>
                                                            <?php if($row->purpose == 'Rent') { echo '<span class="property-price-postfix"> / Month</span>';} ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } }?>
                        </div>
                    </div>
                   <div class="trend_property_view_all"><a href="<?php echo site_url("properties/"); ?>" >View All</a></div>
                </div>
                <div class="g5plus-space space-5cec5e37ba70d" data-id="5cec5e37ba70d" data-tablet="80" data-tablet-portrait="60" data-mobile="40" data-mobile-landscape="40" style="clear: both; display: block; height: 100px"></div>
            </div>
        </div>
    </div>
</div>