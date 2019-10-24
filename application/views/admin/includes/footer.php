<?php //include __DIR__ ."/right_sidebar.php";?>

<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
    <i class="la la-arrow-up"></i>
</div>

<script src="<?php echo asset_url('default/base/scripts.bundle.js', true);?>" type="text/javascript"></script>
<script src="<?php echo asset_url('vendors/custom/fullcalendar/fullcalendar.bundle.js', true);?>" type="text/javascript"></script>
<script src="<?php echo asset_url('app/js/jquery.checkboxes.js', true);?>" type="text/javascript"></script>
<script src="<?php echo asset_url('fancybox/jquery.fancybox.min.js');?>" type="text/javascript"></script>
<script src="<?php echo asset_url('app/js/jquery-sortable-min.js', true);?>" type="text/javascript"></script>
<script src="<?php echo asset_url('app/js/dropify.min.js', true);?>" type="text/javascript"></script>

<!-- tiny_mce -->
<script type="text/javascript" src="<?php echo asset_url('tiny_mce/tiny_mce.js', true); ?>"></script>
<script type="text/javascript" src="<?php echo asset_url('tiny_mce/tiny_mce_setting.js', true); ?>"></script>
<!-- App Functions -->

<script src="<?php echo asset_url('app/js/app.js', true);?>" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {
        function parent_li(li) {
            var _li = li.closest('ul') .css('display', 'block')
                .closest('li') .addClass('m-menu__item--expanded m-menu__item--open');

            if (_li.length > 0) {
                parent_li(_li)
            }
        }
        parent_li($('.m-aside-menu .m-menu__nav li.m-menu__item--active'));
    });
</script>

</html>