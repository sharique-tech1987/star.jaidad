<?php
if ($this->db->table_exists('admin_quick_actions')){
    $rows = $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE)->order_by('ordering ASC, id DESC')->get_where('admin_quick_actions', ['status' => 'Active']);
    $rows = $rows->result();
    $total = $this->db->found_rows();

?>
    <li class="m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
        <a href="#" class="m-nav__link m-dropdown__toggle">
            <span class="m-nav__link-badge m-badge m-badge--dot m-badge--info m--hide"></span>
            <span class="m-nav__link-icon">
                <i class="flaticon-share"></i>
            </span>
        </a>
        <div class="m-dropdown__wrapper">
            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
            <div class="m-dropdown__inner">
                <div class="m-dropdown__header m--align-center" id="_quick_actions-bg">
                    <span class="m-dropdown__header-title">
                        <?php echo __('Quick Actions');?>
                    </span>
                    <span class="m-dropdown__header-subtitle">
                        <?php echo __('Shortcuts');?>
                    </span>
                </div>
                <div class="m-dropdown__body m-dropdown__body--paddingless">
                    <div class="m-dropdown__content">
                        <div class="m-scrollable" data-scrollable="false" data-max-height="380" data-mobile-max-height="200">
                            <div class="m-nav-grid m-nav-grid--skin-light">
                                <?php
                                if (count($rows) > 0) {
                                    $_2rows = array_chunk($rows, 2);
                                    foreach ($_2rows as $_rows) {
                                        echo '<div class="m-nav-grid__row">';
                                        foreach ($_rows as $row) {
                                            ?>
                                            <a href="<?php echo $row->link; ?>" class="m-nav-grid__item">
                                                <i class="m-nav-grid__icon <?php echo(!empty($row->icon) ? $row->icon : 'flaticon-file'); ?>"></i>
                                                <span class="m-nav-grid__text"> <?php echo $row->title; ?> </span>
                                            </a>
                                            <?php
                                        }
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>

<?php }?>