<div class="sidebar-widget agent-widget">
    <div class="widget-content">
        <div class="image-box">
            <figure class="image"><img src="<?php echo _img('html/images/resource/agent-img.jpg', 320, 400, USER_IMG_NA);?>" alt=""></figure>
        </div>
        <div class="info-box">
            <h4 class="name"><?php echo $agent->full_name;?></h4>
            <span class="designation">Real Estate Agent</span>
            <ul class="contact-info">
                <li><strong>Phone:</strong> <?php echo $agent->phone;?></li>
                <li><strong>Email:</strong> <?php echo $agent->email;?></li>
                <li><strong>Address:</strong> <?php echo $agent->full_address;?></li>
            </ul>
            <div class="follow-us">
                <ul class="social-links linkmk">
                    <li class="link">Follow Us:</li>
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                    <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                </ul>
            </div>
            <div class="btn-box">
                <a href="<?php echo site_url("agent/profile/{$agent->id}");?>" class="theme-btn btn-style-one">VIEW PROFILE</a>
                <a href="<?php echo site_url("agent/properties/{$agent->id}");?>" class="theme-btn btn-style-six">AGENT PROPERTIES</a>
            </div>
        </div>
    </div>
</div>