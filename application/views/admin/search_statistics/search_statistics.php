<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title ">
                <?php echo __($this->module_title);?>
            </h3>
        </div>
        <div>
<!--            <span class="m-subheader__daterange" id="m_dashboard_daterangepicker">-->
<!--                <span class="m-subheader__daterange-label">-->
<!--                    <span class="m-subheader__daterange-title"></span>-->
<!--                    <span class="m-subheader__daterange-date m--font-brand"></span>-->
<!--                </span>-->
<!--                <a href="#" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">-->
<!--                    <i class="la la-angle-down"></i>-->
<!--                </a>-->
<!--            </span>-->
        </div>
    </div>
</div>
<!-- END: Subheader -->

<div class="m-content">
    <?php include dirname(__FILE__) . "/search_graphs.php";?>
</div>

<!--<script src="--><?php //echo asset_url('app/js/dashboard.js', true);?><!--" type="text/javascript"></script>-->