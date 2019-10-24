<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_properties');
$ci->load->model(ADMIN_DIR . 'm_amenities');

$limit = 3;
$offset = 0;
$order = 'properties.id DESC';
$where = " AND properties.status='Active' ";

$rows = $ci->m_properties->rows($where, $limit, $offset, $order);
?>
<!-- Recent Section -->
<section class="property-section">
    <div class="auto-container">
        <div class="sec-title">
            <span class="title">FIND YOUR HOUSE IN YOUR CITY</span>
            <h2>RECENT PROPERTIES</h2>
        </div>

        <div class="row">
            <?php
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    $address_ = explode(",", $row->full_address);
                    $path_url = $address_[0] . '-' . $row->city . '-' . $row->country_code . '-' . $row->title;
                    $url = site_url("property/" . friendly_url($path_url,'-',true,$row->id));


                    $amenities_code = ['air-conditioning', 'kitchens'];
                    $amenities = $ci->m_amenities->amenities($row->id, '', 'Property', $amenities_code);
                    //echo '<pre>'; print_r($amenities); echo '</pre>';

                    $image = checkAltImg("assets/front/properties/{$row->image}");
                    $img_url = _Image::open($image)->zoomCrop(370, 320);
                    ?>
                    <!-- Property Block -->
                    <div class="property-block col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="inner-box">
                            <div class="image-box">
                                <div class="single-item-carousel owl-carousel owl-theme">
                                    <figure class="image">
                                        <a href="<?php echo $url;?>">
                                        <img src="<?php echo $img_url;?>" alt="<?php echo $row->title;?>">
                                        </a>
                                    </figure>
                                </div>
                                <span class="for">FOR <?php echo strtoupper($row->purpose);?></span>
                                <span class="featured">FEATURED</span>
                                <ul class="info clearfix">
                                    <li><a href="<?php echo $url;?>"><i class="fa fa-calendar-minus-o"></i><?php echo get_date_diff($row->created, date('Y-m-d'));?> Ago</a></li>
                                    <!--<li><a href="<?php /*echo site_url("agent/profile/{$row->created_by}");*/?>"><i class="fa fa-user-secret"></i>Agent Name</a></li>-->
                                </ul>
                            </div>
                            <div class="lower-content">
                                <ul class="tags">
                                    <li><a href="<?php echo site_url("properties");?>"><?php echo $row->property_type;?></a></li>
                                </ul>
                                <h3><a href="<?php echo $url;?>"><?php echo $row->title;?></a></h3>
                                <div class="lucation"><i class="fa fa-map-marker"></i> <?php echo $row->full_address;?></div>
                                <ul class="property-info clearfix">
                                    <li><i class="flaticon-dimension"></i> <?php echo number_format($row->area);?> <?php echo $row->area_unit;?></li>
                                    <li><i class="flaticon-bed"></i> <?php echo number_format($row->bedrooms);?> Bedrooms</li>
                                    <li><i class="flaticon-car"></i> <?php echo number_format(intval($amenities['kitchens']->value));?> Kitchen</li>
                                    <li><i class="flaticon-bathtub"></i> <?php echo number_format($row->bathrooms);?> Bathroom</li>
                                </ul>
                                <div class="property-price clearfix">
                                    <div class="read-more"><a href="<?php echo $url;?>" class="theme-btn">More Detail</a></div>
                                    <div class="price"><?php echo short_number($row->price);?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            }?>

        </div>

        <!--<div class="load-more-btn text-center">
            <a href="#" class="theme-btn btn-style-two">Load More</a>
        </div>-->
    </div>
</section>
<!--End Property Section -->