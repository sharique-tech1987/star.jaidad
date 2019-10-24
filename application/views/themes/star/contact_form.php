<style>
    .alert-div{
        padding-top: 10px;
    }
</style>
<div class="section mcb-section" style="padding-top:0px; background-image:url(<?php echo asset_url('eimg/event2-singleevent-bottombg.png')?>); background-repeat:no-repeat; background-position:center bottom">
    <div class="section_wrapper mcb-section-inner">

        <div class="row">
            <div class="col-sm-12 alert-div"><?php echo show_validation_errors();?></div>
            <div class="col-sm-6">
                <div class="wrap mcb-wrap one valign-top clearfix">
                    <div class="mcb-wrap-inner">
                        <div class="column mcb-column one column_column">
                            <div class="column_attr clearfix align_center">
                                <div class="no_line" style="margin: 0 auto 70px"></div>
                                <h2>Contact Information</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrap mcb-wrap one-third valign-top clearfix">
                    <div class="mcb-wrap-inner">
                        <div class="column mcb-column one column_icon_box ">
                            <div class="icon_box icon_position_left no_border">
                                <div class="desc_wrapper">
                                    <h4 class="title"><i class="fa fa-map-marker"></i> Address</h4>
                                    <div class="desc">
                                        <p><?php echo nl2br(get_option('address')) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wrap mcb-wrap one-third valign-top clearfix">
                    <div class="mcb-wrap-inner">
                        <div class="column mcb-column one column_icon_box ">
                            <div class="icon_box icon_position_left no_border">
                                <div class="desc_wrapper">
                                    <h4 class="title"><i class="fa fa-phone"></i> Phone</h4>
                                    <div class="desc">
                                        <p>
                                            <a href="tel:<?php echo get_option('phone_number'); ?>"><?php echo get_option('phone_number'); ?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wrap mcb-wrap one-third valign-top clearfix">
                    <div class="mcb-wrap-inner">
                        <div class="column mcb-column one column_icon_box ">
                            <div class="icon_box icon_position_left no_border">
                                <div class="desc_wrapper">
                                    <h4 class="title"><i class="fa fa-envelope-o"></i> Email</h4>
                                    <div class="desc">
                                        <p>
                                            <a href="mailto:<?php echo get_option('contact_email'); ?>"><?php echo get_option('contact_email'); ?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="wrap mcb-wrap one event2-customshadow valign-top move-up clearfix contactForm1">
                    <div class="mcb-wrap-inner">
                        <div class="column mcb-column one-fourth column_column">
                            <div class="column_attr clearfix">
                                <h2>Send us a Message</h2>
                            </div>
                        </div>
                        <div class="column mcb-column three-fourth column_column  column-margin-0px">
                            <div class="column_attr clearfix">
                                <div id="contactWrapper">
                                    <form id="contactform" method="post" action="<?php echo site_url('page/do_contact') ?>">
                                        <div class="column one-second">
                                            <input placeholder="Your name" type="text" name="name" id="name" size="40" aria-required="true" aria-invalid="false"/>
                                        </div>
                                        <div class="column one-second">
                                            <input placeholder="Your e-mail" type="email" name="email" id="email" size="40" aria-required="true" aria-invalid="false"/>
                                        </div>
                                        <div class="column one">
                                            <input placeholder="Subject" type="text" name="subject" id="subject" size="40" aria-invalid="false"/>
                                        </div>
                                        <div class="column one">
                                            <textarea placeholder="Message" name="message" id="message" style="width:100%;" rows="10" aria-invalid="false"></textarea>
                                        </div>
                                        <div class="column one">
                                            <input type="submit" value="Send A Message" id="submit">
                                        </div>
                                    </form>
                                    <script>
                                        $( "form#contactform" ).validate({
                                            rules: {
                                                'name': {
                                                    required: true,
                                                },
                                                'email': {
                                                    required: true,
                                                    email: true,
                                                },
                                                'subject': {
                                                    required: true,
                                                },
                                                'message': {
                                                    required: true,
                                                },
                                            },
                                            invalidHandler: function(event, validator) {
                                                validator.errorList[0].element.focus();
                                            },
                                            submitHandler: function(form) {
                                                form.submit();
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Ends -->

<div class="container-fluid">
    <div class="google-map" id="GoogleMap" style="width:100%;margin-bottom: 20px; height:350px">&nbsp;</div>
</div>

<!--<div id="GoogleMap"></div>-->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=<?php echo get_option('gmap_key');?>"></script>
<script>
    function initialize() {
        var lat = '<?php echo get_option('latitude');?>';
        var lng = '<?php echo get_option('longitude');?>';
        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 15,
            center: myLatlng
        }
        var map = new google.maps.Map(document.getElementById('GoogleMap'), mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: '<?php echo get_option('site_title');?>'
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);

</script>
