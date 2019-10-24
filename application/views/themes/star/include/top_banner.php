<?php
$ci =& get_instance();
$ci->load->model(ADMIN_DIR . 'M_banner_management');
$limit = 20;
$offset = 0;
$order = 'id DESC';
$key = 0;
$where = " AND banner_management.status='Active' AND banner_management.type='Static'";
$rows = $ci->M_banner_management->rows($where, $limit, $offset, $order);
?>
<div id="carousel-example-generic" class="carousel page-wrap slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators pop-dismiss">
        <?php
        if (count($rows) > 0) {
            foreach ($rows as $key => $row) {
                ?>
                <li data-target="#carousel-example-generic" data-slide-to="<?php echo $key; ?>"
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
                    <img alt="<?php echo htmlentities($row->title);?>" src="<?php echo _img(asset_url('front/banner_management/' . $row->image), 1680) ?>" class="img-fluid">
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
    <!-- kj moble banner -->
    <div class="mobile-banner">

        <div class="submit-btn-main">
            <div class="submit-property-btn">
                <a href="#" id="mbl-srch" data-toggle="modal" data-target="#mobile_search" title="Buy/Rent"><i class="icon-search"></i> Buy/Rent</a>
            </div>
            <div class="submit-property-btn">
                <?php
                $member_id = _session(FRONT_SESSION_ID);

                if ($member_id > 0) {
                    $_href = ' href="' . site_url('property/add') . '"';
                } else
                    $_href = 'href="#" data-toggle="modal" data-target="#ere_signin_modal"';
                ?>

                <a <?php echo $_href; ?> title="Submit Property"><i class="icon-office2"></i> Submit Property</a>
            </div>
        </div>

    </div>
    <!-- kj moble banner -->

    <!-- Controls -->
    <div class="carousel-header">
        <div class="wpb_wrapper">
            <?php echo $this->cms->get_block('top-banner'); ?>
        </div>
    </div>
    <div class="search mobile_none">
        <?php include(__DIR__ . '/../search_form.php'); ?>
    </div>
    <div class="search onmobile">
        <?php include(__DIR__ . '/../search_mobile.php'); ?>
    </div>
</div>