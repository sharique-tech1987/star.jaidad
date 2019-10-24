<?php get_header(get_option('header')); ?>

<div class="slider-main"><?php include('include/top_banner.php');?></div>
<div class="hide-mini-search">
    <?php include "news_ticker.php";?>
    <div id="wrapper-content" class="clearfix pop-dismiss">
        <div id="primary-content" class="page-wrap">
            <div class="container clearfix">
                <div class="page-inner">
                    <article id="post-9" class="pro-jects pages post-9 page type-page status-publish hentry">
                        <div class="entry-content clearfix">
                            <div class="entry-content-inner clearfix">
                                <?php echo $this->cms->get_block('index-ad-1');?>
                                <div class="trnd_proj"> <?php include('include/hot_projects.php');?></div>
                                <?php //include('include/buy_sell.php');?>
                                <div class="-hot_proj"> <?php include('include/recent_properties.php');?></div>
                                <div class="brnd_logo"><?php include('include/brand_logos.php');?></div>
                                <div class="pop_cityproj">  <?php include('popular_cities.php');?></div>
                                <?php
                                /**
                                 * Pages Content
                                 */
                                echo do_shortcode(stripslashes($page->content)); ?>

                                <?php //include('include/our_services.php');?>
                                <?php// include('include/agents.php');?>
                                <?php// include('include/brand_logos.php');?>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
    <?php get_footer();?>
</div>
<?php include "popup_modal.php";?>