<?php get_header('member');?>
<div class="hidden-xs hidden-sm visible-md hidden-lg">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
<?php
$member_id = _session(FRONT_SESSION_ID);
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_properties');
$ci->load->model(ADMIN_DIR . 'm_amenities');


$action = getUri(4);
$id = getUri(5);
switch ($action){
    case 'delete':
    case 'status':
        $uri_status = getUri(6);
        if($action == 'delete'){
            $status = 'Deleted';
        } elseif ($action == 'status' && $uri_status == 'hide'){
            $status = 'Hidden';
        }

        $ow_data = ['status' => $status];
        save($ci->m_properties->table, $ow_data, "id='{$id}'");

        set_notification('Property has been ' . ($action == 'delete' ? 'deleted' : 'updated'), 'success');
        redirectBack();
    break;
}


$area_attr['limit'] = 36;
$where = " AND properties.created_by='{$member_id}' AND properties.status NOT IN('Deleted')";
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
                        <div class="col-md-6 col-sm-12 breadcrumb_member_cust"><h4>My Properties</h4></div>
                        <div class="col-md-6 col-sm-12 breadcrumb_member_cust ">
                            <?php include "breadcrumb.php"; ?>
                        </div>
                    </div>
                </div>
                <p>&nbsp;</p>
                <?php echo show_validation_errors();?>
                <div class="row">
                    <div class="column col-lg-12">
                        <div class="properties-box">
                            <div class="title"><h3>My Properties</h3></div>
                            <div class="inner-container">

                        <?php
                        if (count($rows) > 0){
                            foreach ($rows as $row) {
                                $amenities_code = ['air-conditioning', 'kitchens'];
                                $amenities = $ci->m_amenities->amenities($row->id, '', 'Property', $amenities_code);
                                $path_url = $row->area . '-' . $row->city . '-' . $row->country . '-' . $row->title;
                                //site_url("project/" . friendly_url($path_url, '-', true, $row->id));

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
                                            <a href="<?php echo site_url('property/' . friendly_url($path_url, '-', true, $row->id));?>"><h3><?php echo $row->title;?></h3></a>
                                            <div class="location"><i class="la la-map-marker"></i> <?php echo $row->full_address;?></div>
                                            <ul class="property-info clearfix">
                                                <li><i class="flaticon-dimension"></i> <?php echo number_format($row->area);?> <?php echo $row->area_unit;?></li>
                                                <li><i class="flaticon-bed"></i> <?php echo number_format($row->bedrooms);?> Bedrooms</li>
                                                <li><i class="flaticon-car"></i> <?php echo number_format(intval($amenities['kitchens']->value));?> Kitchen</li>
                                                <li><i class="flaticon-bathtub"></i> <?php echo number_format($row->bathrooms);?> Bathroom</li>
                                            </ul>
                                            <div class="price"><?php echo short_number($row->price);?></div>
                                        </div>
                                        <div class="hidden-xs hidden-sm visible-md visible-lg option-box">
                                            <div class="expire-date"><?php echo mysql2date($row->created);?></div>
                                            <ul class="action-list">
                                                <li><a href="<?php echo site_url('property/update/' .$row->id);?>"><i class="la la-edit"></i> Edit</a></li>
                                                <li><a href="<?php echo site_url('member/account/properties/status/' . $row->id . '/hide');?>"><i class="la la-eye-slash"></i> Hide</a></li>
                                                <li><a href="<?php echo site_url('member/account/properties/delete/' . $row->id);?>"><i class="la la-trash-o"></i> Delete</a></li>
                                            </ul>
                                        </div>

                                        <div class="hidden-md hidden-lg visible-xs visible-sm col-sm-12">
                                            <div class="expire-date"><?php echo mysql2date($row->created);?></div>
                                            <ul class="action-list">

                                                <li><a href="<?php echo site_url('property/update/' . $row->id);?>"><i class="la la-edit"></i> Edit</a></li>
                                                <li><a href="<?php echo site_url('member/account/properties/status/' . $row->id . '/hide');?>"><i class="la la-eye-slash"></i> Hide</a></li>
                                                <li><a href="<?php echo site_url('member/account/properties/delete/' . $row->id);?>"><i class="la la-trash-o"></i> Delete</a></li>
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