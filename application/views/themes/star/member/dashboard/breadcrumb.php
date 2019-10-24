<ul class="bread-crumb clearfix">
<!--    <li><a href="--><?php //echo site_url('account'); ?><!--">Account</a></li>-->
    <?php
    $crumbs = $this->breadcrumb->get_items();
    $last_item = count($crumbs);
    foreach ($crumbs as $i => $item) {
        if ($last_item == $i) {
            echo '<li class="active">' . $item['text'] . '</li>';
        } else {
            echo '<li><a href="' . $item['link'] . '">' . $item['text'] . '</a></li>';
        }
    }
    ?>
</ul>
