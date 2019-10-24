    <div class="mg-bottom-30 ere-item-wrap">
        <div class="property-inner">
            <div class="property-image">
                <?php
                $address_ = explode(",", $row->full_address);
                $path_url = $address_[0] . '-' . $row->city . '-' . $row->country_code . '-' . $row->title;
                $url = site_url("property/" . friendly_url($path_url,'-',true,$row->id));

                $row->videos = json_decode($row->videos);

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
                <?php
                if(!empty($row->videos[0]) && !(file_exists(ROOT . "assets/front/properties/{$row->image}"))){
                ?>
                <!--<div class="video video-has-thumb">
                    <div class="entry-thumb-wrap">
                        <div class="embed-responsive embed-responsive-16by9 embed-responsive-full">
                            <iframe width="500" height="281"
                                    src="https://www.youtube.com/embed/<?php /*echo get_youtube_id($row->videos[0]);*/?>"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                </div>-->
                    <div class="entry-thumb-wrap">
                    <div class="entry-thumbnail post-video">
                        <a class="entry-thumbnail-overlay" href="<?php echo $url;?>" title="<?php echo $row->title;?>">
                            <img class="img-responsive" src="https://i1.ytimg.com/vi/<?php echo get_youtube_id($row->videos[0]);?>/0.jpg" alt="<?php echo $row->title;?>">
                        </a> <a class="view-video zoomGallery" data-src="https://www.youtube.com/watch?v=<?php echo get_youtube_id($row->videos[0]);?>"><i class="fa fa-play"></i></a>
                    </div>
                    </div>
                <?php } else {
                    ?><img src="<?php echo ($img_url);?>" alt="<?php echo $row->title;?>"><?php
                } ?>


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

                    <a class="property-link" href="<?php echo $url; ?>"></a>
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
                                    echo number_format($_area_unit, (end(explode('.', number_format($_area_unit, 2))) > 0 ? 2 : 0));?> <?php echo short_area_unit($_COOKIE['area_unit']);?>
                                </span>
                            </div>
                        </div>
                        <?php if($row->bedrooms) { ?>
                        <div class="property-bedrooms">
                            <div class="property-bedrooms-inner">
                                <i class="icon-bed-1"></i>
                                <span class="property-info-value"><?php echo number_format($row->bedrooms);?> Bedroom(s)</span>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if($row->bathrooms) { ?>
                        <div class="property-bathrooms">
                            <div class="property-bathrooms-inner">
                                <i class="icon-bathtub-1"></i>
                                <span class="property-info-value"><?php echo number_format($row->bathrooms);?> Bathroom(s)</span>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if($amenities['kitchens']->value) { ?>
                        <div class="property-garages">
                            <div class="property-garages-inner">
                                <!--<i class="icon-car-garage"></i>-->
                                <span class="fa -fa-hotel accent-color"><img src="<?php echo _img(media_url('images/kitchen.png'), 24, 24);?>" alt="Kitchens"></span>
                                <span class="property-info-value"><?php echo number_format(intval($amenities['kitchens']->value));?> Kitchen</span>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
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
