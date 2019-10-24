<?php /*
<ul class="breadcrumbs">
    <li><a href="<?php echo site_url(); ?>" class="home">Home</a></li>
    <?php
    $crumbs = $this->breadcrumb->get_items();
    $last_item = count($crumbs);
    foreach ($crumbs as $i => $item) {
        if ($last_item == $i) {
            echo '<li><span>' . $item['text'] . '</span></li>';
        } else {
            echo '<li><a href="' . $item['link'] . '"><span>' . $item['text'] . '</span></a></li>';
        }
    }
    ?>
</ul>