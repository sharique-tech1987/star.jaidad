<?php
$ci = &get_instance();
$ci->load->model(ADMIN_DIR . 'm_customer_elections');
$rows = $ci->m_customer_elections->rows("AND member_id='{$row->id}'", 5);

$_color = ['', '#f29271', '#f29271', '#00A591', '#90a9b2', '#D5AE41', '#BE9EC9', '#F1EA7F', '#006E6D'];
?>
<div class="panel panel-default panel-election">
    <div class="panel-heading">Election 2018-19</div>
    <div class="panel-body">

        <?php
        if (count($rows) > 0) {
            foreach ($rows as $k => $item) {
                ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="rounded" style="background-color: <?php echo $_color[$k];?>">
                            <img src="<?php echo media_url('images/calender.png'); ?>">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h5><?php echo mysql2date($item->date); ?></h5>
                        <p><?php echo substr($item->description, 0, 80); ?></p>
                    </div>
                </div>
                <hr class="sm-hr">
                <?php
            }
        } else {
            echo '<hr>';
        }
        ?>

        <a href="<?php echo site_url('customer/account/elections/' . $row->id);?>">Read More</a>

    </div>
</div>