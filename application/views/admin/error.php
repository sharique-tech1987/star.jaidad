<style>
    .m-error-5 .m-error_container .m-error_title>h1{
        font-size: 14rem;
        margin-left: 5rem;
        margin-top: 0rem;
    }
    .m-error-5 .m-error_container .m-error_subtitle, .m-error-5 .m-error_container .m-error_description{
        margin-left: 5rem;
    }
</style>
<!-- begin:: Page -->
<div class="m-content">
    <div class="m-error-5" style="background-image: url('<?php echo asset_url('app/media/img/error/bg5.jpg', true)?>');">
        <div class="m-error_container" style="display: inline-block;">
            <span class="m-error_title">
                <h1>Oops!</h1>
            </span>
            <p class="m-error_subtitle"><?php echo $error_no; ?></p>
            <p class="m-error_description"><?php echo $error_message; ?>
                <br>
                <br>
                <br>
                <!--<a href="<?php /*echo admin_url(); */?>" class="btn btn-danger">Back to dashboard</a>-->
                <a href="javascript:window.history.back(0);" class="btn m-btn--pill m-btn--air         btn-secondary btn-lg" style="width: 300px;">Back</a>
                    <!--<div class="col-md-6"> <a href="<?php /*echo site_url(); */?>" class="btn btn-success btn-block">Back to the website</a> </div>-->
            </p>
        </div>
        <div style="height: 80px">&nbsp;</div>
    </div>
</div>

<!-- end:: Page -->
