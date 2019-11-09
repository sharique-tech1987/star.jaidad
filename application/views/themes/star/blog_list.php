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
$rows = $ci->m_blog_posts->rows($where, $limit, $offset, $order);
$num_rows = $ci->m_blog_posts->num_rows;
$total_rows = $ci->m_blog_posts->total_rows;

?>
<div id="primary-content" class="pd-top-100 pd-bottom-100 archive-wrap archive-large-image">
    <div class="container clearfix">
        <div class="row">
            <div class="col-md-9 archive-inner">
                <div class="blog-wrap clearfix">
                    <?php
                    if (count($rows) > 0) {
                    foreach ($rows as $row) {
                        include('include/blogs_listing.php');
                    ?>
                    <?php }
                    ?>
                        <div class="clearfix"></div>

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
                </div>
            </div>
            <div class="sidebar-mobile-canvas-icon" title="Click to show Canvas Sidebar">
                <i class="fa fa-sliders"></i>
            </div>
            <div class="wrapper-sticky" style="display: block; height: 1134px; width: 25%; margin: auto; position: relative; float: left; left: auto; right: auto; top: auto; bottom: auto; vertical-align: top;">
                <div class="primary-sidebar sidebar col-md-3 sidebar-mobile-canvas gf-sticky" style="left: 0px; width: 300px; position: absolute; top: 0px;">
                    <aside id="search-2" class="widget widget_search">
                        <h4 class="widget-title"><span>Search</span></h4>
                        <form role="search" class="search-form" method="get" id="searchform" action="http://themes.g5plus.net/benaa/">
                            <input type="text" value="" name="s" id="s" placeholder="ENTER YOUR  KEYWORD">
                            <button type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </aside>
                    <aside id="recent-posts-2" class="widget widget_recent_entries">
                        <h4 class="widget-title">
                            <span>Recent Posts</span>
                        </h4>
                        <ul>
                            <li>
                                <a href="#">We are Offering the Best Real Estate Deals</a>
                            </li>
                            <li>
                                <a href="#">Recent Trends in Story Telling 2017</a>
                            </li>
                            <li>
                                <a href="#">Construction You Can Count On</a>
                            </li>
                            <li>
                                <a href="#">Project Luxury Villa in Rego Park</a>
                            </li>
                            <li>
                                <a href="#">Boutique Space Greenville at 2017</a>
                            </li>
                        </ul>
                    </aside>
                    <aside id="categories-2" class="widget widget_categories">
                        <h4 class="widget-title">
                            <span>Categories</span>
                        </h4>
                        <ul>
                            <li class="cat-item cat-item-2">
                                <a href="#">Apartment (6)</a>
                            </li>
                            <li class="cat-item cat-item-3">
                                <a href="#">Clients (1)</a>
                            </li>
                            <li class="cat-item cat-item-4">
                                <a href="#">Green (3)</a>
                            </li>
                            <li class="cat-item cat-item-5">
                                <a href="#">Mountain (1)</a>
                            </li>
                            <li class="cat-item cat-item-6">
                                <a href="#">Real Estates (7)</a>
                            </li>
                            <li class="cat-item cat-item-7">
                                <a href="#">Villa (7)</a>
                            </li>
                        </ul>
                    </aside>
                    <aside id="tag_cloud-2" class="widget widget_tag_cloud">
                        <h4 class="widget-title"><span>Tags</span></h4>
                        <div class="tagcloud">
                            <a href="#" class="tag-cloud-link tag-link-8 tag-link-position-1" style="font-size: 8pt;" aria-label="agency (1 item)">agency</a>
                            <a href="#" class="tag-cloud-link tag-link-9 tag-link-position-2" style="font-size: 8pt;" aria-label="agent (1 item)">agent</a>
                            <a href="#" class="tag-cloud-link tag-link-10 tag-link-position-3" style="font-size: 8pt;" aria-label="Apartment (1 item)">Apartment</a>
                            <a href="#" class="tag-cloud-link tag-link-11 tag-link-position-4" style="font-size: 18.181818181818pt;" aria-label="Building (4 items)">Building</a>
                            <a href="#" class="tag-cloud-link tag-link-12 tag-link-position-5" style="font-size: 22pt;" aria-label="Building Construction (6 items)">Building Construction</a>
                            <a href="#" class="tag-cloud-link tag-link-13 tag-link-position-6" style="font-size: 18.181818181818pt;" aria-label="Construction (4 items)">Construction</a>
                            <a href="#" class="tag-cloud-link tag-link-14 tag-link-position-7" style="font-size: 8pt;" aria-label="Home (1 item)">Home</a>
                            <a href="#" class="tag-cloud-link tag-link-15 tag-link-position-8" style="font-size: 12.581818181818pt;" aria-label="homes (2 items)">homes</a>
                            <a href="#" class="tag-cloud-link tag-link-16 tag-link-position-9" style="font-size: 8pt;" aria-label="house (1 item)">house</a>
                            <a href="#" class="tag-cloud-link tag-link-17 tag-link-position-10" style="font-size: 8pt;" aria-label="listing (1 item)">listing</a>
                            <a href="#" class="tag-cloud-link tag-link-18 tag-link-position-11" style="font-size: 8pt;" aria-label="property (1 item)">property</a>
                            <a href="#" class="tag-cloud-link tag-link-19 tag-link-position-12" style="font-size: 8pt;" aria-label="realtor (1 item)">realtor</a>
                            <a href="#" class="tag-cloud-link tag-link-20 tag-link-position-13" style="font-size: 18.181818181818pt;" aria-label="villa (4 items)">villa</a>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>
