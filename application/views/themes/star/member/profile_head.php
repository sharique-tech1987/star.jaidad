<?php
$bg_url = _img('assets/front/customers/' . $row->company_banner, 945, 300);
$thumb_url = _img('assets/front/customers/' . $row->photo, 300, 300, USER_IMG_NA, 'zoomCrop');

$NAV = [
    'Dashboard' => ['url' => site_url('member/account/home/' . $id), 'icon' => ('Home.png')],
    'My Bookings' => ['url' => site_url('member/account/booking/' . $id), 'icon' => ('invoice.png')],
    'My Properties' => ['url' => site_url('member/account/properties/' . $id), 'icon' => ('property.png')],
    'Reports' => ['url' => site_url('member/account/reports/' . $id), 'icon' => ('News-Events.png')],
    //'Agency Staff' => ['url' => site_url('member/account/staff/' . $id), 'icon' => ('Managing-Committee.png')],
    //'Advertise' => ['url' => site_url('member/account/advertise/' . $id), 'icon' => ('job.png')],
    'Enquiry' => ['url' => site_url('member/account/enquiries/' . $id), 'icon' => ('Enquiry.png')],
    'Edit Profile' => ['url' => site_url('member/account/?edit=edit'), 'icon' => ('Edit-Profile.png')],
    'Logout' => ['url' => site_url('login/logout'), 'icon' => ('logout.png')],
];

$standard_NAV = ['Dashboard', 'My Bookings', 'My Properties', 'Reports', 'Advertise', 'Enquiry', 'Edit Profile', 'Logout'];

$edit = getVar('edit');


if(!$my_profile && !$edit){
    unset($NAV['Edit Profile'], $NAV['Logout'], $NAV['Super SEO']);
}

?>
<div style="display: inline-block;">
    <a class="brand_logo" href="<?php echo site_url('member/account/home/' . $row->id);?>">
        <?php if($my_profile) { ?>
        <div class="upload-btn-wrapper right-side">
            <i class="fa fa-image"></i>
            <input type="file" name="company_logo" class="file-upload" data-thumb=".company_logo-img" data-url="<?php echo site_url('member/ajax/upload');?>"/>
        </div>
        <?php } ?>
        <img class="img-responsive company_logo-img" src="<?php echo $thumb_url; ?>">
    </a>
    <ul>
        <li><span class="site-name"><?php echo strtoupper($row->company_name) ?></span></li>
        <!--<li><span class="site-description"><b><?php /*echo $row->membership_id; */?></b></span></li>-->
    </ul>
    <p>&nbsp;</p>
    <?if(getVar('mob')): ?>
    <nav class="navbar navbar-default mob-menu">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNavMenu">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>


            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="mainNavMenu" >
                <ul class="nav main-menu navbar-nav">
                    <?php
                    foreach ($NAV as $title => $item) {
                        if(!in_array($title, $standard_NAV) && $row->member_type == "Standard") continue;
                        echo "<li>
                        <a href='{$item['url']}?mob=true'>{$title}</a>
                </li>";
                }
               ?>
                </ul>
            </div><!-- /.navbar-collapse -->
    </nav>
    <?php endif; ?>


    <ul class="ul_tab" role="tablist">
        <?php
        foreach ($NAV as $title => $item) {
            if(!in_array($title, $standard_NAV) && $row->member_type == "Standard") continue;
            echo "<li>
                    <img src='"._img('assets/front/users/icons/' . $item['icon'], 24, 24)."' alt='' class='img-responsive icon-img'>
                    <a href='{$item['url']}'>{$title}</a>
                </li>";
        }
        ?>
    </ul>


</div>