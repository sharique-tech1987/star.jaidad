<style>
    .p-1 {
        padding: .25rem!important;
    }

    .m-portlet.m-portlet--half-height {
        height: 150px;
    }
    .m-portlet.m-portlet--border-bottom-brand {
        border-bottom: 3px solid #716aca;
    }
    .m-portlet.m-portlet--half-height {
        height: calc(50% - 2.2rem);
    }
    .m-portlet {
        -webkit-box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);
        box-shadow: 0 1px 15px 1px rgba(69,65,78,.08);
        background-color: #fff;
    }
    .m-portlet {
        margin-bottom: 2.2rem;
    }
    .m-portlet .m-portlet__body {
        color: #575962;
    }
    .m-portlet .m-portlet__body {
        padding: 2.2rem 2.2rem;
    }
    .p-2 {
        padding: .5rem!important;
    }
    .m-portlet .m-portlet__body {
        color: #575962;
    }
    .m-grid.m-grid--ver-desktop.m-grid--desktop {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
    }
    .m-grid.m-grid--hor:not(.m-grid--desktop):not(.m-grid--desktop-and-tablet):not(.m-grid--tablet):not(.m-grid--tablet-and-mobile):not(.m-grid--mobile) {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
    }
    .m-widget26 .m-widget26__number {
        color: #575962;
    }
    .m-widget26 .m-widget26__number {
        font-size: 2.5rem;
        font-weight: 600;
    }
    .m-widget26__number {
        text-align: center;
        margin-bottom: 8px;
    }
    .m-grid.m-grid--ver-desktop.m-grid--desktop {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
    }
    .m-grid.m-grid--ver-desktop.m-grid--desktop {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
    }
    .flaticon-map-location:before {
        content: "\f17f";
    }
    [class*=" flaticon-"]:before, [class^=flaticon-]:before {
        font-family: Flaticon;
        font-style: normal;
        font-weight: 400;
        font-variant: normal;
        line-height: 1;
        text-decoration: inherit;
        text-rendering: optimizeLegibility;
        text-transform: none;
        -moz-osx-font-smoothing: grayscale;
        -webkit-font-smoothing: antialiased;
        font-smoothing: antialiased;
    }

    .m-portlet.m-portlet--border-bottom-success {
        border-bottom: 3px solid #34bfa3;
    }

</style>
<?php

$dashboard_boxs[] = [
    'box_cls' => 'brand',
    'icon' => 'fa fa-building',
    'number' => $total_rows,
    'title' => "Views",
];

?>
<!--begin:: Widgets/Quick Stats-->
<div class="row dashboard-box -m-row--full-height justify-content-center">
    <?php
    if (count($dashboard_boxs) > 0) {
        foreach ($dashboard_boxs as $dashboard_box) {
            ?>
            <div class="col-sm-6 col-md-4 col-lg-2 p-1">
                <div class="m-portlet m-portlet--half-height m-portlet--border-bottom-<?php echo $dashboard_box['box_cls']; ?>">
                    <div class="m-portlet__body p-2">
                        <div class="m-widget26">
                            <div class="m-widget26__number">
                                <?php echo number_format($dashboard_box['number']); ?>
                                <small><?php echo $dashboard_box['title']; ?></small>
                            </div>
                            <div class="text-center">
                                <?php if(!empty($dashboard_box['link'])) { echo '<a href="'.$dashboard_box['link'].'">'; } ?>
                                <i class="m--font-<?php echo $dashboard_box['box_cls']; ?> <?php echo $dashboard_box['icon']; ?>"></i>
                                <?php if(!empty($dashboard_box['link'])) { echo '</a>'; } ?>
                            </div>
                            <!--<div class="m-widget26__chart">
                                <canvas id="m_chart_quick_stats_1"></canvas>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>


</div>
<!--end:: Widgets/Quick Stats-->