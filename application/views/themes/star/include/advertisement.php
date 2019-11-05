<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'M_banner_management');
$limit = 20;
$offset = 0;
$order = 'id DESC';
$key = 0;
$where = " AND banner_management.status='Active' AND banner_management.type='Advertisement'";
$rows = $ci->M_banner_management->rows($where, $limit, $offset, $order);
?>
<div id="carousel-example-generic1" class="carousel page-wrap slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators pop-dismiss">
        <?php
        if (count($rows) > 0) {
            foreach ($rows as $key => $row) {
                ?>
                <li data-target="#carousel-example-generic1" data-slide-to="<?php echo $key; ?>"
                    class="<?php echo($key == 0 ? 'active' : ''); ?>"></li>
                <?php
            }
        } ?>

    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner pop-dismiss" role="listbox">
        <?php
        if (count($rows) > 0) {
            foreach ($rows as $key => $row) {
                ?>
                <div class="item <?php echo($key == 0 ? 'active' : ''); ?>">
                    <?php
                    if (!empty($row->link)) {
                        echo '<a href="' . $row->link . '">';
                    }
                    ?>
                    <img alt="<?php echo htmlentities($row->title);?>" src="<?php echo _img(asset_url('front/banner_management/' . $row->image), 1680) ?>"
                         class="img-fluid sj-no-animation">
                    <?php
                    if (!empty($row->link)) {
                        echo '</a>';
                    }
                    ?>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>