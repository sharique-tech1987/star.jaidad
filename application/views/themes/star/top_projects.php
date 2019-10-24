<?php $ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_projects');
$ci->load->model(ADMIN_DIR . 'm_amenities');
$ci->load->model(ADMIN_DIR . 'm_project_properties');

$limit = 6;
$offset = 0;
$order = 'projects.id DESC';
if (getVar('limit') > 0) {
    $limit = intval(getVar('limit'));
}
if (getVar('per_page') > 0) {
    $offset = intval(getVar('per_page'));
}
$where = " AND projects.status='Active' ";

$rows = $ci->m_projects->rows($where, $limit, $offset, $order);
$num_rows = $ci->m_projects->num_rows;
$total_rows = $ci->m_projects->total_rows;
?>
<section class="new-listing our-projects">
    <div class="container">
        <div class="new-listing__header">
            <h2 class="section__title section__title--b-margin">OUR HOT PROJECTS</h2>
            <!--<a href="<?php /*echo site_url('projects');*/?>" class="new-listing__all">View all region
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>-->
        </div>

        <div class="new-listing__wrapper row">
            <?php
            if (count($rows) > 0){
                foreach ($rows as $row) {
                    $amenities_code = ['air-conditioning', 'kitchens'];
                    $amenities = $ci->m_amenities->amenities($row->id, '', 'Project', $amenities_code);
                    $property = $ci->m_project_properties->row(0, " AND project_id='{$row->id}'");
                    //echo '<pre>'; print_r($amenities); echo '</pre>';
                    ?>
                    <!-- project Block -->
                    <div class="col-md-4">
                        <!--<div class="new-listing__bg"></div>-->
                        <div class="hovereffect">
                            <?php
                            $image = checkAltImg("assets/front/projects/{$row->image}");
                            $img_url = _Image::open($image)->zoomCrop(370, 320);?>
                            <img src="<?php echo base_url($img_url);?>" alt="<?php echo $row->title;?>" class="img-fluid">

                            <div class="overlay">
                                <h4><?php echo $row->title;?></h4>
                                <div class="text1"><?php echo $row->city;?></div>
                                <!--<div class="text2">3|4 LUXURY APARTMENTS</div>-->
                                <div class="text3"><?php echo $row->project_type;?></div>
                                <ul class="actions">
                                    <li><a href="<?php echo site_url('project/1');?>"><img src="<?php echo media_url('images/1.png');?>" class="img-trans0"></a></li>
                                    <!--<li><a href="#"><img src="<?php /*echo media_url('images/2.png');*/?>" class="img-trans1"></a></li>-->
                                    <li><a href="#share"><img src="<?php echo media_url('images/3.png');?>" class="img-trans2"></a></li>
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
</section>