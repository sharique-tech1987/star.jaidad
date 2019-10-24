</div>
</div>
</div>
</div>
<?php echo get_footer(); ?>
<script src="<?php echo media_url('js/readmore.min.js');?>"></script>
<script>
    (function ($) {
        $(document).ready(function () {
            $('#company_profile').readmore({
                speed: 200,
                moreLink: '<div class="text-center"><a class="btn btn-default btn-sm" href="#">Read more</a></div>',
                lessLink: '<div class="text-center"><a class="btn btn-default btn-sm" href="#">Read less</a></div>',
            });
        });
    })(jQuery);
</script>