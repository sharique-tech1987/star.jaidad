<?php get_header('member');?>
<div class="hidden-xs hidden-sm visible-md hidden-lg">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</div>
<?php
$member_id = _session(FRONT_SESSION_ID);
$member = get_member($member_id);
$agent_type_id = intval(get_option('agent_type_id'));
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_properties');
$ci->load->model(ADMIN_DIR . 'm_amenities');
$page = getUri(3);

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
        } elseif ($action == 'status' && $uri_status == 'sold'){
            $status = 'Sold';
        }

        $ow_data = ['status' => $status];
        if(save($ci->m_properties->table, $ow_data, "id='{$id}'")){
			set_notification('Property has been ' . ($action == 'delete' ? 'deleted' : 'updated'), 'success');

			# +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			# registration_email
			$property = $ci->m_properties->row($id);
			$property->property_id = $property->id;
			$member = get_member(_session(FRONT_SESSION_ID));

			$mail_data = array_merge((array)$property, (array)$member);
			$msg = get_email_template($mail_data, 'Property ' . $status);
			if ($msg->status == 'Active') {
				$admin_cc_email = get_option('admin_cc_email');
				$emaildata = array(
					'to' => $member->email,
					'subject' => $msg->subject,
					'message' => $msg->message
				);
				if(!empty($admin_cc_email)){
					$emaildata['cc'] = $admin_cc_email;
				}
				if (!send_mail($emaildata)) {
					set_notification('Email sending failed.', 'danger');
				} else {
					//set_notification('Please check your email for username & password!','success');
				}
			}

		} else {
			set_notification('Some error occurred!');
		}

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
<script src="<?php echo asset_url('app/js/echarts.min.js', true); ?>"></script>
<script>
    var basic_option = {
        title: {
            x: 'center'
        },
        tooltip: {
            trigger: 'item',
            extraCssText: 'border-radius: 2px;font-family: Poppins; font-size: 12px;',
            formatter: function (params, ticket, callback) {
                //console.log(params);
                return params.data.name + ' : ' + numeral(params.data.value).format('0,0');
            }
            //formatter: "{a} <br/>{b} : {c}"
        },
        legend: {
            x: 'center',
            y: 'bottom',
        },
        toolbox: {
            show: true,
            feature: {
                mark: {show: true},
                dataView: {
                    show: false,
                    readOnly: false,
                    title: 'Data View',
                    lang: ['Data View', 'Cancel', 'Reset']
                },
                magicType: {
                    show: true, title: {
                        line: 'Line',
                        bar: 'Bar',
                        stack: 'Stack',
                        tiled: 'Tiled',
                        force: 'Force',
                        chord: 'Chord',
                        pie: 'Pie',
                        funnel: 'Funnel'
                    },
                    type: ['pie']
                    //type: ['pie,', 'line', 'bar', 'stack', 'tiled']
                },
                // restore: {show: true, title: 'Reset'},
                // saveAsImage: {
                //     show: true, title: 'Save as Image',
                //     type: 'png',
                //     lang: ['Click to Save']
                // }
            }
        },
        color: ['#749f83', '#ca8622', '#bda29a', '#6e7074', '#546570', '#c4ccd3', '#f00b07', '#2f4554', '#0975a8', '#d48265', '#91c7ae'],
        calculable: true,

    };

    var property_purpose_option = Object.assign({}, basic_option);
    property_purpose_option.color = ['#d48265', '#546570', '#91c7ae', '#749f83', '#ca8622', '#bda29a', '#6e7074', '#c4ccd3', '#f00b07', '#2f4554', '#0975a8'];
</script>
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
                <?php
                if ($member->user_type_id == $agent_type_id && in_array($page, array("home")) ) {
                ?>
                <div class="row">
                    <div class="col-md-12 cus_font">
                        <h3>Total Properties : <?php echo $total_rows; ?></h3>
                    </div>
                </div>
                    <?php
                }
                ?>
                <?php echo show_validation_errors();?>
                <div class="row">
                    <?php
                    if ($member->user_type_id == $agent_type_id && in_array($page, array("home")) ) {
                        ?>
                        <div class="col-lg-6">
                            <div class="m-portlet" style="height: 420px;">
                                <div class="m-portlet__body p-1">
                                    <div id="properties-status-chart" class="custom-status"
                                         style="width: 100%;height:400px;"></div>
                                </div>

                                <script>
                                    var propertiesStatusChart = echarts.init(document.getElementById('properties-status-chart'));
                                    propertiesStatusChart.setOption(basic_option);
                                    propertiesStatusChart.showLoading();
                                    $(document).ready(function () {
                                        $.getJSON('<?php echo site_url('member/AJAX/chart/properties-status-count');?>').done(function (data) {
                                            console.log(data);
                                            propertiesStatusChart.hideLoading();
                                            propertiesStatusChart.setOption({
                                                title: {
                                                    text: data.text,
                                                    subtext: data.subtext
                                                },
                                                legend: {
                                                    data: data.legend_data
                                                },
                                                series: [{
                                                    name: 'Properties Status',
                                                    type: 'pie',
                                                    //roseType: 'area',
                                                    data: data.series_data_pie,
                                                    itemStyle: {
                                                        emphasis: {
                                                            shadowBlur: 10,
                                                            shadowOffsetX: 0,
                                                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                                                        }
                                                    }
                                                }]
                                            });
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="m-portlet" style="height: 420px;">
                                <div class="m-portlet__body p-1">
                                    <div id="properties-purpose-count" class="custom-status"
                                         style="width: 100%;height:400px;"></div>
                                </div>

                                <script>
                                    var propertiesPurposeChart = echarts.init(document.getElementById('properties-purpose-count'));
                                    propertiesPurposeChart.setOption(property_purpose_option);
                                    propertiesPurposeChart.showLoading();
                                    $(document).ready(function () {
                                        $.getJSON('<?php echo site_url('member/AJAX/chart/properties-purpose-count');?>').done(function (data) {
                                            console.log(data);
                                            propertiesPurposeChart.hideLoading();
                                            propertiesPurposeChart.setOption({
                                                title: {
                                                    text: data.text,
                                                    subtext: data.subtext
                                                },
                                                legend: {
                                                    data: data.legend_data
                                                },
                                                series: [{
                                                    name: 'Properties Purpose',
                                                    type: 'pie',
                                                    //roseType: 'area',
                                                    data: data.series_data_pie,
                                                    itemStyle: {
                                                        emphasis: {
                                                            shadowBlur: 10,
                                                            shadowOffsetX: 0,
                                                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                                                        }
                                                    }
                                                }]
                                            });
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

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
                                                <li><a href="<?php echo site_url('member/account/properties/status/' . $row->id . '/sold');?>"><i class="la la-bookmark"></i> Sold</a></li>
                                                <li><a href="<?php echo site_url('member/account/properties/delete/' . $row->id);?>"><i class="la la-trash-o"></i> Delete</a></li>
                                            </ul>
                                        </div>

                                        <div class="hidden-md hidden-lg visible-xs visible-sm col-sm-12">
                                            <div class="expire-date"><?php echo mysql2date($row->created);?></div>
                                            <ul class="action-list">

                                                <li><a href="<?php echo site_url('property/update/' . $row->id);?>"><i class="la la-edit"></i> Edit</a></li>
                                                <li><a href="<?php echo site_url('member/account/properties/status/' . $row->id . '/hide');?>"><i class="la la-eye-slash"></i> Hide</a></li>
                                                <li><a href="<?php echo site_url('member/account/properties/status/' . $row->id . '/sold');?>"><i class="la la-bookmark"></i> Sold</a></li>
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
