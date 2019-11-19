<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_blog_posts');

if(empty($_COOKIE['area_unit'])){
    $_COOKIE['area_unit'] = 'Marla';
}

$where = " AND blog_posts.status='Published' ";
/**------------------------------------------------------
 *  Searching
 *-----------------------------------------------------*/
$blog_search = strtolower(getVar('blog_search'));
$cat_id = getVar('cat_id');
$tag_id = getVar('tag_id');

if(!empty($blog_search)){
    $where .= " AND blog_posts.title LIKE '%{$blog_search}%' ";
}

if(!empty($cat_id)){
    $where .= " AND blog_posts.category_id = '{$cat_id}' ";
}

if(!empty($tag_id)){
    $where .= " AND blog_tags_rel.tag_id = '{$tag_id}' ";
}

/**---------------------------------------------------------*/


/**------------------ End Searching ------------------------*/
$_is_order = '';
$order = 'blog_posts.id DESC';

$limit = 3;
$offset = 0;
if (getVar('limit') > 0) {
    $limit = intval(getVar('limit'));
}
if (getVar('per_page') > 0) {
    $offset = intval(getVar('per_page'));
}
if(!empty($tag_id)){
    $rows = $ci->m_blog_posts->rows($where, $limit, $offset, $order, '', true);
}
else{
    $rows = $ci->m_blog_posts->rows($where, $limit, $offset, $order);
}
$num_rows = $ci->m_blog_posts->num_rows;
$total_rows = $ci->m_blog_posts->total_rows;

?>
<div id="primary-content" class="page-wrap pd-top-100">
    <div class="container clearfix">
        <div class="page-inner">
            <div class="col-md-9" style="margin-bottom: 20px;">
<!--                <div class="blog-wrap clearfix">-->
                    <?php
                    if (count($rows) > 0) {
                    foreach ($rows as $row) {
                        include('include/blogs_listing.php');
                    ?>
                    <?php }
                    ?>
<!--                        <div class="clearfix"></div>-->

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
                        </div>
                    <?php } else {
                        ?>
                        <div class="clearfix"></div>
                        <div class="alert alert-danger">Blogs not found.</div>
                        <?php
                    } ?>
<!--                </div>-->
            </div>
<!--            <div class="sidebar-mobile-canvas-icon" title="Click to show Canvas Sidebar">-->
<!--                <i class="fa fa-sliders"></i>-->
<!--            </div>-->
            <?php include('include/blog_right_side_bar.php'); ?>
        </div>
    </div>
</div>
