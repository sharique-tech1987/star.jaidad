<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_agents');

$limit = 18;
$offset = 0;
//$order = 'users.id DESC';
$order = 'total_properties DESC';
if (getVar('limit') > 0) {
    $limit = intval(getVar('limit'));
}
if (getVar('per_page') > 0) {
    $offset = intval(getVar('per_page'));
}


$where = " AND users.status='Active' AND users.user_type_id='" . get_option('agent_type_id') . "'";
if (getVar('city_id')) {
    $city_id = getVar('city_id');
    $where .= " AND area.city_id='{$city_id}'";
}

if (getVar('area_ids'))
{
    $area_ids = getVar('area_ids');
    $where .= "AND agent_area_list.area_id IN(" . join(',', $area_ids) . ")";
}


$ci->m_agents->property_count = true;
$rows = $ci->m_agents->rows($where, $limit, $offset, $order);
$num_rows = $ci->m_agents->num_rows;
$total_rows = $ci->m_agents->total_rows;
?>
<?php include "include/page_header.php"; ?>
<style>
    @media (max-width: 767px) {
        .benaa-class .ere-search-properties.style-mini-line .form-group{
            height: auto !important;
        }
        .benaa-class .ere-search-properties.style-mini-line .ere-advanced-search-btn{
            margin-top: 10px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            margin-top: 5px !important;
        }
        .benaa-class .ere-search-properties.style-mini-line .form-search-wrap input.select2-search__field{
            border-radius: 20px !important;
        }
        .area-form-input{
            margin-top: 10px;
        }
    }
</style>
<!-- Agents Section -->
<div id="primary-content" class="">
    <div class="container clearfix">
        <div class="archive-property-inner">
            <div id="container">
                <div id="content" role="main">
                    <div class="ere-archive-property-wrap ere-property-wrap">
                        <?php include(__DIR__ . '/agent_form.php'); ?>
                        <!--============== top filter    ==============-->
                        <div class="ere-archive-property archive-property">
                            <div class="above-archive-property">
                                <div class="ere-heading">
                                    <h2>MEET OUR AGENTS</h2>
                                </div>
                            </div>
                            <div class="ere-property clearfix property-grid col-gap-30 columns-4 columns-md-4 columns-sm-2 columns-xs-1 columns-mb-1">
                                <div class="ere-property clearfix property-grid col-gap-30 columns-4 columns-md-4 columns-sm-2 columns-xs-1 columns-mb-1">
                                    <?php
                                    if (count($rows) > 0) {
                                        foreach ($rows as $row) {
                                            //$total = $ci->db->query("SELECT count(DISTINCT id) AS total FROM properties WHERE created_by='{$row->id}' AND properties.status='Active'")->row()->total;
                                            ?>
                                            <div class="mg-bottom-30 ere-item-wrap">
                                                <div class="property-inner">
                                                    <div class="agent-item">
                                                        <div class="agent-item-inner" style="padding: 15px;">
                                                            <div class="agent-avatar">
                                                                <a title="<?php echo $row->full_name;?>" href="<?php echo site_url("agent/{$row->id}");?>">
                                                                    <img class="img-circle img-rounded" width="400" height="400" src="<?php echo _img("assets/front/users/{$row->photo}", 400, 400, USER_IMG_NA);?>" alt="<?php echo $row->full_name;?>" title="<?php echo $row->full_name;?>">
                                                                </a>
                                                            </div>
                                                            <div class="agent-content box-shade text-center">
                                                                <div class="agent-info">
                                                                    <h2 class="agent-name"><a title="<?php echo $row->full_name;?>" href="<?php echo site_url("agent/{$row->id}");?>"><?php echo $row->full_name;?></a></h2>
                                                                    <p><?php echo number_format($row->total_properties);?> Properties <br></p>
                                                                    <!--<p class="agent-address"><?php /*echo $row->full_address;*/?></p>-->
                                                                </div>
                                                                <div class="agent-social">
                                                                    <?php
                                                                    $socials = json_decode($row->social_network, true);
                                                                    foreach ($socials as $social => $social_link) {
                                                                        if(!empty($social_link)) {
                                                                            echo '<a target="_blank" href="' . $social_link . '"><i class="fa fa-' . $social . '"></i></a>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>

                            </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="vc_row-full-width vc_clearfix"></div>
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

    <!--<span aria-current='page' class='page-numbers current'>1</span>
    <a class='page-numbers' href=''>2</a>
    <a class='page-numbers' href=''>3</a>
    <a class="next page-numbers" href="">Next</a>-->
</div>
