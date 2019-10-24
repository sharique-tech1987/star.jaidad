<?php  $_SESSION['mob'] == 'true' ? get_head() : get_header(); ?>
<link rel="stylesheet" href="<?php echo media_url('css/member-dashboard.css');?>" />
<div class="bg-container member-dashboard" id="album">
    <div class="page-content container">

        <?php $step3 = unserialize($row->step3); ?>

        <div class="row">
            <div class="col-md-2 section_left">
                <?php include "profile_head.php";?>
            </div>
            <div class="col-md-10 mt-10">
                <?php echo show_validation_errors(); ?>
                <?php
                $_action = (getUri(MEMBER_FORM_URI));
                if(!(getVar('edit') || $_action)){
                    include "profile_DP.php";
                }
                ?>
