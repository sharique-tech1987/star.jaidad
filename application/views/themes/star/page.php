<?php get_header(get_option('header')); ?>

<div id="wrapper-content" class="clearfix ">
    <?php include "include/page_header.php";?>

    <div id="primary-content" class="page-wrap">
        <div class="container clearfix">
            <div class="page-inner">
                <article id="post-<?php echo $page->id;?>" class="pages post-<?php echo $page->id;?> page page-<?php echo $page->friendly_url;?> status-publish hentry">
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
                </article>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
<?php //include "popup_modal.php";?>