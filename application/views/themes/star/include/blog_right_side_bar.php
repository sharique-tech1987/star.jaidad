<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'm_blog_posts');
$ci->load->model(ADMIN_DIR . 'm_blog_categories');
$ci->load->model(ADMIN_DIR . 'm_blog_tags');
$order = 'blog_posts.id DESC';
$blog_categories_order = 'blog_categories.id DESC';
$blog_tags_order = 'blog_tags.id DESC';
$where = " AND blog_posts.status='Published' ";

$limit = 5;
$offset = 0;
$rows = $ci->m_blog_posts->rows($where, $limit, $offset, $order);
$blog_categories =  $ci->m_blog_categories->rows($where='', $limit, $offset, $blog_categories_order);
$blog_tags =  $ci->m_blog_tags->rows($where='', $limit=10, $offset, $blog_tags_order);
s?>

<div class="wrapper-sticky" style="display: block; height: 1134px; width: 25%; margin: auto; position: relative; float: left; left: auto; right: auto; top: auto; bottom: auto; vertical-align: top;">
    <div class="primary-sidebar sidebar col-md-3 sidebar-mobile-canvas gf-sticky" style="left: 0px; width: 300px; position: absolute; top: 0px;">
        <aside id="search-2" class="widget widget_search">
            <h4 class="widget-title"><span>Search</span></h4>
            <form role="search" class="search-form" method="get" id="searchform" action="<?php echo site_url('blogs'); ?>">
                <input type="text" value="" name="blog_search" id="blog_search" placeholder="ENTER YOUR  KEYWORD">
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

                <?php
                if (count($rows) > 0) {
                    foreach ($rows as $row) {
                        $url = site_url("blog/" . friendly_url($row->title,'-',true,$row->id));
                        ?>

                        <li>
                            <a href="<?php echo $url; ?>"><?php echo $row->title ?></a>
                        </li>
                    <?php
                    }
                }
                ?>

            </ul>
        </aside>
        <aside id="categories-2" class="widget widget_categories">
            <h4 class="widget-title">
                <span>Categories</span>
            </h4>
            <ul>
                <?php
                if (count($blog_categories) > 0) {
                    foreach ($blog_categories as $row) {
                        //$url = site_url("blog/" . friendly_url($row->title,'-',true,$row->id));
                        ?>
                        <li class="cat-item cat-item-2">
                            <a href="<?php echo site_url("blogs?cat_id=$row->id") ?>"><?php echo $row->type . " (" . $row->post_count . ")"; ?></a>
                        </li>
                     <?php
                    }
                }
                ?>

            </ul>
        </aside>
        <aside id="tag_cloud-2" class="widget widget_tag_cloud">
            <h4 class="widget-title"><span>Tags</span></h4>
            <div class="tagcloud">
                <?php
                if (count($blog_tags) > 0) {
                    foreach ($blog_tags as $row) {
                        //$url = site_url("blog/" . friendly_url($row->title,'-',true,$row->id));
                        ?>
                        <a href="<?php echo site_url("blogs?tag_id=$row->id") ?>" class="tag-cloud-link tag-link-8 tag-link-position-1" style="font-size: 8pt;" ><?php echo $row->type ?></a>
                <?php
                    }
                }
                ?>
            </div>
        </aside>
    </div>
</div>
