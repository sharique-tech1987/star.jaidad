<?php
if ($this->db->table_exists('notifications')){
    $notifications = $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE)->order_by('id', 'DESC')->get_where('notifications', ['status' => 'Unread'], 10);
    $notifications = $notifications->result();
    $total = $this->db->found_rows();

?>
<li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
    <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
        <span class="m-nav__link-badge m-badge m-badge--danger"> <?php echo number_format($total);?> </span>
        <span class="m-nav__link-icon">
            <i class="flaticon-music-2"></i>
        </span>
    </a>
    <div class="m-dropdown__wrapper">
        <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
        <div class="m-dropdown__inner">
            <div class="m-dropdown__header m--align-center" id="notification-bg">
                <span class="m-dropdown__header-title">
                    <?php echo number_format($total);?> <?php echo __('New');?>
                </span>
                <span class="m-dropdown__header-subtitle">
                    <?php echo __('Notifications');?>
                </span>
            </div>
            <div class="m-dropdown__body">
                <div class="m-dropdown__content">
                    <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab">
                                <?php echo __('Alerts');?>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
                            <div class="m-scrollable" data-scrollable="true" data-max-height="250" data-mobile-max-height="200">
                                <div class="m-list-timeline m-list-timeline--skin-light">
                                    <div class="m-list-timeline__items">
                                        <?php
                                        if (count($notifications) > 0) {
                                            foreach ($notifications as $notification) {
                                                ?>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--<?php echo $notification->type;?>"></span>
                                                    <span class="m-list-timeline__text">
                                                        <?php
                                                        if(!empty($notification->module) && $notification->rel_id > 0){
                                                            echo '<a href="' . admin_url($notification->module . '/view/' . $notification->rel_id) . '">' . $notification->text . '</a>';
                                                        }else  if(!empty($notification->module)){
                                                            echo '<a href="' . admin_url($notification->module) . '">' . $notification->text . '</a>';
                                                        }else {
                                                            echo $notification->text;
                                                        }
                                                        ?>
                                                    </span>
                                                <span class="m-list-timeline__time">
                                                    <?php echo timespan(mysql_to_unix($notification->created), time(), 2);?></span>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>
<?php } ?>