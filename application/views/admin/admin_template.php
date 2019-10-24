<?php include dirname(__FILE__) . "/includes/head.php"; ?>
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
        <div class="m-grid m-grid--hor m-grid--root m-page">

            <?php include dirname(__FILE__) . "/includes/header.php"; ?>

            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

                <?php include dirname(__FILE__) . "/includes/left_side_bar.php";?>

                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    <?php echo $content; ?>
                </div>
            </div>

            <footer class="m-grid__item		m-footer ">
                <div class="m-container m-container--fluid m-container--full-height m-page__container">
                    <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
                        <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                    <span class="m-footer__copyright">
                        <?php echo date('Y');?> &copy; <a href="#" class="m-link"><?php echo get_option('developer');?></a>

                    </span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
<?php
include dirname(__FILE__) . "/includes/footer.php"; ?>