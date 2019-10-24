<?php get_header('member');?>

<?php
$member_id = _session(FRONT_SESSION_ID);
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_properties');
$ci->load->model(ADMIN_DIR . 'm_amenities');

$area_attr['limit'] = 36;
$where = " AND properties.id IN(SELECT property_id FROM user_wishlist WHERE user_id='{$member_id}') ";
$limit = 16;
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

?>

<div class="dashboard">
    <div class="container-fluid">
        <div class="content-area">
            <div class="dashboard-content">
                <div class="dashboard-header clearfix">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 breadcrumb_member_cust"><h4>My Wishlist Properties</h4></div>
                        <div class="col-md-6 col-sm-12 breadcrumb_member_cust">
                            <?php include "breadcrumb.php"; ?>
                        </div>
                    </div>
                </div>
                <?php echo show_validation_errors();?>
                <div class="row">
                    <div class="column col-lg-12">
                        <div class="properties-box">
                            <div class="title"><h3>My Wishlist Properties</h3></div>
                            <div class="inner-container">

                        <?php
                        if (count($rows) > 0){
                            foreach ($rows as $row) {
                                $amenities_code = ['air-conditioning', 'kitchens'];
                                $amenities = $ci->m_amenities->amenities($row->id, '', 'Property', $amenities_code);
                                //echo '<pre>'; print_r($amenities); echo '</pre>';
                                ?>
                                <!-- Property Block -->
                                <div class="property-block">
                                    <div class="inner-box clearfix">
                                        <div class="image-box">
                                            <figure class="image">
                                            <?php
                                            $image = checkAltImg("assets/front/properties/{$row->image}");
                                            $img_url = _Image::open($image)->zoomCrop(370, 320);?>
                                            <img src="<?php echo base_url($img_url);?>" alt="<?php echo $row->title;?>">
                                            </figure>
                                        </div>
                                        <div class="content-box">
                                            <a href="<?php echo site_url('property/' . $row->id);?>"><h3><?php echo $row->title;?></h3></a>
                                            <div class="location"><i class="la la-map-marker"></i> <?php echo $row->full_address;?></div>
                                            <ul class="property-info clearfix">
                                                <li><i class="flaticon-dimension"></i> <?php echo number_format($row->area);?> <?php echo $row->area_unit;?></li>
                                                <li><i class="flaticon-bed"></i> <?php echo number_format($row->bedrooms);?> Bedrooms</li>
                                                <li><i class="flaticon-car"></i> <?php echo number_format(intval($amenities['kitchens']->value));?> Kitchen</li>
                                                <li><i class="flaticon-bathtub"></i> <?php echo number_format($row->bathrooms);?> Bathroom</li>
                                            </ul>
                                            <div class="price"><?php echo short_number($row->price);?></div>
                                        </div>
                                        <div class="option-box">
                                            <div class="expire-date"><?php echo mysql2date($row->created);?></div>
                                            <ul class="action-list">
                                                <li><a href="<?php echo site_url("member/wishlist/delete/{$row->id}");?>"><i class="la la-trash-o"></i> Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                    <?php
                                }
                            }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php get_footer();?>