
<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
    <li class="m-nav__item m-nav__item--home">
        <a href="<?php echo admin_url(); ?>" class="m-nav__link m-nav__link--icon">
            <i class="m-nav__link-icon la la-home"></i>
        </a>
    </li>
    <?php
    $total_item = count($crumbs);
    if ($total_item > 0) {
        echo '<li class="m-nav__separator"> -</li>';
        foreach ($crumbs as $i => $item) {
            if ($total_item == $i) {
                ?>
                <li class="m-nav__item">
                    <a href="<?php echo $item['link']; ?>" class="m-nav__link">
                        <span class="m-nav__link-text"><?php echo __($item['text']); ?></span>
                    </a>
                </li>
                <?php
            } else {
                ?>
                <li class="m-nav__item">
                    <a href="<?php echo $item['link']; ?>" class="m-nav__link">
                        <span class="m-nav__link-text"><?php echo __($item['text']); ?></span>
                    </a>
                </li>
                <li class="m-nav__separator"> -</li>
                <?php
            }
        }
    }
    ?>
</ul>