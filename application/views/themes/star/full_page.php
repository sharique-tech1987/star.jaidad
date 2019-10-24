<?php get_header(get_option('header')); ?>
<div id="Content">
    <div class="content_wrapper clearfix">
        <div class="sections_group">
            <div class="entry-content">
                <?php if ($page->show_title) { ?>
                    <div class="section mcb-section bg-cover"
                         style="padding-top:200px; padding-bottom:125px; background-image:url('<?php echo asset_url('front/pages/' . $row->thumbnail) ?>'); background-repeat:no-repeat; background-position:right top">
                        <div class="section_wrapper mcb-section-inner">
                            <div class="wrap mcb-wrap one valign-top clearfix">
                                <div class="mcb-wrap-inner">
                                    <div class="column mcb-column two-third column_column">
                                        <div class="column_attr clearfix">
                                            <h2 style="font-size:60px; line-height:65px"><?php echo $page->title; ?></h2>
                                            <hr class="no_line" style="margin: 0 auto 50px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                    <?php
                    /**
                     * Pages Content
                     */
                    echo do_shortcode(stripslashes($page->content)); ?>

                    <?php
                    $tab_id = intval(getVar('tab_id'));
                    /***************************************************************************************************************
                     * Sub Pages
                     */

                    $sub_pages = get_page(0, "AND pages.parent_id='" . intval($page->id) . "'", true);
                    if (count($sub_pages) > 0 && $page->id > 0) {
                        foreach ($sub_pages

                                 as $k => $sub_page) {
                            echo '<div id="' . $sub_page->friendly_url . '">';
                            if ($sub_page->show_title == 1) { ?>
                                <h2 class="heading-30 text-center"><?php echo(!empty($sub_page->icon) ? '<i class="' . $sub_page->icon . '"></i>' : ''); ?><?php echo $sub_page->title; ?></h2>
                            <?php } ?>
                            <div class="inner-page-content page-uri-<?php echo $sub_page->friendly_url; ?>">
                                <?php echo do_shortcode(stripslashes($sub_page->content)); ?>
                            </div>
                            <?
                        }
                    }
                    ?>


            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
