<style>
    @media (min-width: 1025px) {

        .m-portlet.m-portlet--half-height {
            height: 150px;
        }
    }

    .m-widget26__number {
        text-align: center;
        margin-bottom: 8px;
    }
    .dashboard-box .m-widget26 i{
        font-size: 4rem;
    }
</style>
<?php
$dashboard_boxs[] = [
    'box_cls' => 'brand',
    'icon' => 'flaticon-map-location',
    'number' => $this->db->count_all_results('properties'),
    'title' => "Total Properties",
];
$dashboard_boxs[] = [
    'box_cls' => 'success',
    'icon' => 'flaticon-analytics',
    'number' => $this->db->count_all_results('projects'),
    'title' => "Total Projects",
];
/*$dashboard_boxs[] = [
    'box_cls' => 'danger',
    'icon' => 'flaticon-avatar',
    'number' => _count_users(get_option('teacher_type_id'))->total,
    'title' => "Total Teacher's",
];*/



//$other_types = _count_users(0, 0, "AND user_type_id NOT IN(".join(',', _reserve_types()).")");
$agent_type_id = intval(get_option('agent_type_id'));
$total_emp = _count_users(0, 0, "AND user_type_id='{$agent_type_id}'")[0]->total;

$dashboard_boxs[] = [
    'box_cls' => 'warning',
    'icon' => 'flaticon-user-add',
    'number' => $total_emp,
    'title' => "Total Agent's",
];

$total_emp = _count_users(0, 0, "AND users.logedin=1")[0]->total;
$dashboard_boxs[] = [
    'box_cls' => 'info',
    'icon' => 'flaticon-light',
    'number' => $total_emp,
    'title' => "Total Login's",
];

$total_emp = _count_users(0, 0, "AND users.become_agent=1")[0]->total;
$dashboard_boxs[] = [
    'box_cls' => 'danger',
    'icon' => 'flaticon-alert-2',
    'number' => $total_emp,
    'title' => "Become an agent",
    'link' => admin_url('agent_request'),
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

