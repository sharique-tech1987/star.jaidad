<div class="cus-profile">
    <header id="header">
        <div class="slider">
            <!--
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            | File Upload
            |‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒‒
            -->
            <?php if($my_profile) { ?>
            <div class="upload-btn-wrapper right-side">
                <i class="la la-image"></i> 945 x 300
                <input type="file" name="company_banner" class="file-upload" data-thumb=".company_banner-img" data-url="<?php echo site_url('customer/ajax/upload');?>"/>
            </div>
            <?php } ?>

            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->

                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img class="company_banner-img" src="<?php echo (!empty($row->company_banner) ? $bg_url : asset_url('front/users/icons/Profilecoverplaceholder.jpg'));?>" style="height: 300px;">
                    </div>
                </div>

                <!-- Controls -->
                <!--<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="la la-angle-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="la la-angle-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>-->
            </div>
        </div><!--slider-->
        <?if(getVar('mob')): ?>
        <nav class="navbar navbar-default">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a style="margin-bottom: 15px;" href="#" data-toggle="modal" data-target="#compose-msg" class="btn btn-prim"><i class="la la-send"></i> Send Message</a>
            <?php if($row->id == _session(FRONT_SESSION_ID)) { ?>
                <a href="<?php echo site_url('message_center');?>" class="btn btn-devent"><i class="la la-commenting-o"></i> Messages</a>
            <?php }
            if($row->id != _session(FRONT_SESSION_ID) && _session(FRONT_SESSION_ID) > 0) {
                ?>
                <a href="#" data-toggle="modal" data-target="#compose-msg" class="btn btn-devent"><i class="la la-send"></i> Send Message</a>
            <?php } ?>
            </div>
        </nav>
        <?php else: ?>
        <nav class="navbar navbar-default">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNav2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="mainNav2" >
                <ul class="nav main-menu navbar-nav">
                    <?php if($row->falcon_profile_url): ?>
                    <li><a target="_blank" href="<?php echo $row->falcon_profile_url; ?>"><i class="la la-building"></i> Premium showcasing</a></li>
                    <?php endif; ?>
                    <?php //include "account_nav.php";?>
                    <?php if($row->id == _session(FRONT_SESSION_ID)) { ?>
                        <li><a class="pull-right btn-floating btn-large waves-effect waves-light red" title="Edit Profile" style="padding: 0 10px;" href="<?php echo site_url('customer/registration/?edit=' . $row->id); ?>">Edit Profile <i class="la la-edit"></i></a> </li>
                        <li><a class="pull-right btn-floating btn-large waves-effect waves-light red" title="Logout" style="padding: 0 10px;" href="<?php echo site_url('customer/logout'); ?>">Logout <i class="la la-lock"></i></a> </li>
                    <?php } ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                <?php if(count($step3) > 0) { ?>
                        <?php if(!empty($step3['facebook'])) { echo '<li><a target="_blank" href="'.$step3['facebook'].'"><i class="la la-facebook"></i></a></li>';}?>
                        <?php if(!empty($step3['twitter'])) { echo '<li><a target="_blank" href="'.$step3['twitter'].'"><i class="la la-twitter"></i></a></li>';}?>
                        <?php if(!empty($step3['linkedin'])) { echo '<li><a target="_blank" href="'.$step3['linkedin'].'"><i class="la la-linkedin"></i></a></li>';}?>
                        <?php if(!empty($step3['google-plus'])) { echo '<li><a target="_blank" href="'.$step3['google-plus'].'"><i class="la la-google-plus"></i></a></li>';}?>
                    
                <?php } ?>
                <?php if($row->id == _session(FRONT_SESSION_ID)) { ?>
                    <li class="send-message-list"><a href="<?php echo site_url('message_center');?>" class="btn btn-devent"><i class="la la-commenting-o"></i> Messages</a></li>
                    <?php }
                    if($row->id != _session(FRONT_SESSION_ID) && _session(FRONT_SESSION_ID) > 0) {
                    ?>
                    <li class="send-message-list"><a href="#" data-toggle="modal" data-target="#compose-msg" class="btn btn-devent"><i class="la la-send"></i> Send Message</a></li>
                    <?php } ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
        <?php endif; ?>
    </header>
</div>

