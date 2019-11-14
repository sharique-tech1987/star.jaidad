<!--============== footer ==============-->
<footer class="main-footer-wrapper ">
    <div id="wrapper-footer">
        <div class="container">
            <div data-vc-full-width="true" data-vc-full-width-init="false"
                 class="vc_row wpb_row vc_row-fluid vc_custom_1516762767064 vc_row-has-fill vc_row-background-overlay-wrap">
                <div class="vc_row-background-overlay" style="background-color: rgba(0,0,0,0.85)"></div>
                <!--<div class="xs-text-center wpb_column vc_column_container vc_col-sm-6">
               <div class="vc_column-inner vc_custom_1515120268956">
                   <div class="wpb_wrapper">
                       <div class="wpb_widgetised_column wpb_content_element">
                           <div class="wpb_wrapper">
                               <aside id="g5plus_logo-3" class="widget widget-logo">
                                   <a href="<?php /*echo site_url();*/ ?>">
                                       <img src="<?php /*echo _img(ADMIN_ASSETS_DIR . 'img/' . get_option('footer_logo'), 175);*/ ?>" alt="<?php /*echo get_option('site_title');*/ ?>" class="img-fluid">
                                   </a>
                               </aside>
                           </div>
                       </div>
                   </div>
               </div>
               </div>
               <div class="text-right xs-text-center wpb_column vc_column_container vc_col-sm-6">
               <div class="vc_column-inner vc_custom_1515120299780">
                   <div class="wpb_wrapper">
                       <div class="wpb_widgetised_column wpb_content_element">
                           <div class="wpb_wrapper">
                               <aside id="g5plus_social_profile-8" class="widget widget-social-profile">
                                   <div class="social-profiles circle dark icon-small">
                                       <?php
                /*                                                $socials = json_decode(get_option('social'), true);
                                                                foreach ($socials as $social => $social_link) {
                                                                    if(!empty($social_link)) {
                                                                        echo '<a target="_blank" href="' . $social_link . '"><i class="fa fa-' . $social . '"></i></a>';
                                                                    }
                                                                }
                                                                */ ?>
                                       <div class="clearfix"></div>
                                   </div>
                               </aside>
                           </div>
                       </div>
                   </div>
               </div>
               </div>
               <div class="wpb_column vc_column_container vc_col-sm-12">
               <div class="vc_column-inner vc_custom_1514903488437">
                   <div class="wpb_wrapper">
                       <div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text"><span class="vc_sep_holder vc_sep_holder_l"><span style="border-color:rgb(255,255,255);border-color:rgba(255,255,255,0.1);" class="vc_sep_line"></span></span><span class="vc_sep_holder vc_sep_holder_r"><span style="border-color:rgb(255,255,255);border-color:rgba(255,255,255,0.1);" class="vc_sep_line"></span></span>
                       </div>
                   </div>
               </div>
               </div>-->
                <div class="wpb_column vc_column_container vc_col-sm-3 vc_col-md-3">
                    <div class="vc_column-inner vc_custom_1521191698430">
                        <div class="wpb_wrapper">
                            <div class="wpb_widgetised_column wpb_content_element">
                                <div class="wpb_wrapper">
                                    <aside id="custom_html-5" class="widget_text widget widget_custom_html">
                                        <h4 class="widget-title"><span>About</span></h4>
                                        <div class="textwidget custom-html-widget">
                                            <p>
                                                <?php echo $this->cms->get_block('about-text'); ?>

                                            </p>
                                        </div>

                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wpb_column vc_column_container vc_col-sm-3 vc_col-md-2">
                    <div class="vc_column-inner vc_custom_1521191706459 mycss">
                        <div class="wpb_wrapper">
                            <div class="wpb_widgetised_column wpb_content_element">
                                <div class="wpb_wrapper">
                                    <aside id="ere_widget_listing_property_taxonomy-3"
                                           class="widget ere_widget ere_widget_listing_property_taxonomy">
                                        <h4 class="widget-title"><span>Quick LINKS</span></h4>
                                        <div class="ere-widget-listing-property-taxonomy widget_nav_menu clearfix scheme-dark taxonomy-2-columns">
                                            <?php echo $this->cms->get_block('footer-menu-2'); ?>
                                        </div>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wpb_column vc_column_container vc_col-sm-3 vc_col-md-2">
                    <div class="vc_column-inner vc_custom_1521191706459 mycss">
                        <div class="wpb_wrapper">
                            <div class="wpb_widgetised_column wpb_content_element">
                                <div class="wpb_wrapper">
                                    <aside id="ere_widget_listing_property_taxonomy-3"
                                           class="widget ere_widget ere_widget_listing_property_taxonomy">
                                        <h4 class="widget-title"><span>Star Jaidad</span></h4>
                                        <div class="ere-widget-listing-property-taxonomy widget_nav_menu clearfix scheme-dark taxonomy-2-columns">
                                            <?php echo $this->cms->get_block('footer-menu-1'); ?>
                                        </div>
                                    </aside>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wpb_column vc_column_container vc_col-sm-3 vc_col-md-3">
                    <div class="vc_column-inner vc_custom_1521191706459">
                        <div class="wpb_wrapper">
                            <div class="wpb_widgetised_column wpb_content_element">
                                <div class="wpb_wrapper">

                                    <aside id="custom_html-5" class="widget_text widget widget_custom_html">
                                        <h4 class="widget-title"><span>Get In Touch</span></h4>
                                        <div class="textwidget custom-html-widget">
                                            <ul class="custom-html-footer">
                                                <li>
                                                    <i class="text-color-accent fa fa-map-marker"></i><span><?php echo nl2br(get_option('address')); ?></span>
                                                </li>
                                                <li><i class="text-color-accent fa fa-phone"></i><span><a
                                                                href="tel:<?php echo get_option('phone_number'); ?>"><?php echo get_option('phone_number'); ?></a></span>
                                                </li>
                                                <li><i class="text-color-accent fa fa-envelope"></i><span><a
                                                                href="mailto:<?php echo get_option('contact_email'); ?>"><?php echo get_option('contact_email'); ?></a></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <br>
                                        <div class="social-profiles circle dark icon-small">
                                            <?php
                                            $socials = json_decode(get_option('social'), true);
                                            foreach ($socials as $social => $social_link) {
                                                if (!empty($social_link)) {
                                                    echo '<a target="_blank" href="' . $social_link . '"><i class="fa fa-' . $social . '"></i></a>';
                                                }
                                            }
                                            ?>
                                            <div class="clearfix"></div>
                                        </div>
                                    </aside>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wpb_column vc_column_container vc_col-sm-4 vc_col-md-2 col-sm-offset-1 col-md-offset-0">
                    <div class="vc_column-inner">
                        <div class="wpb_wrapper">
                            <div class="wpb_widgetised_column wpb_content_element">
                                <div class="wpb_wrapper">
                                    <aside id="media_image-2" class="widget widget_media_image text-center">
                                        <!--<h4 class="widget-title"><span>Branches</span></h4>-->
                                        <img width="242" height="157"
                                             src="<?php echo media_url('images/map-footer.png'); ?>"
                                             class="image wp-image-3733  text-center attachment-full size-full" alt=""
                                             style="max-width: 50%; height: auto;"/>
                                    </aside>
                                </div>
                                <br>
                                <div class="xs-text-center">
                                    <?php echo get_option('copyright'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wpb_column vc_column_container vc_col-sm-12">
                    <div class="vc_column-inner vc_custom_1515120367947">
                        <div class="wpb_wrapper">
                            <div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text">
                                <span class="vc_sep_holder vc_sep_holder_l"><span
                                            style="border-color:rgb(255,255,255);border-color:rgba(255,255,255,0.1);"
                                            class="vc_sep_line"></span></span><span
                                        class="vc_sep_holder vc_sep_holder_r"><span
                                            style="border-color:rgb(255,255,255);border-color:rgba(255,255,255,0.1);"
                                            class="vc_sep_line"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xs-text-center wpb_column vc_column_container vc_col-sm-4">
                    <div class="vc_column-inner vc_custom_1515120372123">
                        <div class="wpb_wrapper">
                            <div class="wpb_text_column wpb_content_element ">
                                <div class="wpb_wrapper">
                                    <h4 class="fs-24 fw-bold inline-block"><i
                                                class="icon-envelope-in-black-paper-with-a-white-letter-sheet-inside accent-color fs-34 inline-block mg-right-10"></i><span
                                                style="color: #ffffff;">OUR NEWSLETTER</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xs-text-center wpb_column vc_column_container vc_col-sm-8">
                    <div class="vc_column-inner vc_custom_1515120375453">
                        <div class="wpb_wrapper">
                            <div class="wpb_text_column wpb_content_element  mailchimp-button">
                                <div class="wpb_wrapper">
                                    <form id="subscriber-form" class="mc4wp-form mc4wp-form-2534" method="post"
                                          action="<?php echo site_url('member/subscribe'); ?>">
                                        <div class="mc4wp-form-fields">
                                            <div class="g5plus-mailchimp">
                                                <input type="email" name="email" class="form-control"
                                                       placeholder="E-mail Address" required/>
                                                <button type="submit" class="submit"><i class="fa fa-paper-plane"></i>
                                                </button>
                                                <button type="submit"
                                                        class="btn btn-xs btn-primary btn-outline btn-shape-round">
                                                    Subscribe Now
                                                </button>
                                                <div class="subscriber-response error"></div>
                                            </div>
                                        </div>
                                        <div class="mc4wp-response"></div>
                                    </form>
                                    <script>
                                        $(function () {
                                            $(document).on('submit', '#subscriber-form', function (e) {
                                                e.preventDefault();
                                                var _form = $('#subscriber-form');
                                                $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: _form.attr('action'),
                                                    data: _form.serialize(),
                                                }).done(function (json) {
                                                    $('.subscriber-response').html(json.message);
                                                })
                                                    .fail(function () {

                                                    });

                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wpb_column vc_column_container vc_col-sm-12">
                    <div class="vc_column-inner vc_custom_1515120019814">
                        <div class="wpb_wrapper">
                            <div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text">
                                <span class="vc_sep_holder vc_sep_holder_l"><span
                                            style="border-color:rgb(255,255,255);border-color:rgba(255,255,255,0.1);"
                                            class="vc_sep_line"></span></span><span
                                        class="vc_sep_holder vc_sep_holder_r"><span
                                            style="border-color:rgb(255,255,255);border-color:rgba(255,255,255,0.1);"
                                            class="vc_sep_line"></span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--                <div class="wpb_column vc_column_container vc_col-sm-12">-->
                <!--                    <div class="vc_column-inner">-->
                <!--                        <div class="wpb_wrapper">-->
                <!--                            <div class="vc_row wpb_row vc_inner vc_row-fluid bottom-bar-wrapper vc_custom_1521191034599 vc_row-has-fill vc_row-o-content-middle vc_row-flex">-->
                <!--                                <div class="xs-text-center wpb_column vc_column_container vc_col-sm-6 vc_col-md-4">-->
                <!--                                    <div class="vc_column-inner vc_custom_1516762284668">-->
                <!--                                        <div class="wpb_wrapper">-->
                <!--                                            <div class="wpb_widgetised_column wpb_content_element">-->
                <!--                                                  <div class="wpb_wrapper">-->
                <!--                                                    <aside id="custom_html-6" class="widget_text mg-top-3 widget widget_custom_html">-->
                <!--                                                        --><?php //echo get_option('copyright');?>
                <!--                                                    </aside>-->
                <!--                                                </div>-->
                <!--                                            </div>-->
                <!--                                        </div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                                <div class="sm-text-center text-right wpb_column vc_column_container vc_col-sm-6 vc_col-md-8">-->
                <!--                                    <div class="vc_column-inner vc_custom_1516762720590">-->
                <!--                                        <div class="wpb_wrapper">-->
                <!--                                            <div class="wpb_widgetised_column wpb_content_element">-->
                <!--                                                <div class="wpb_wrapper">-->
                <!--                                                    <aside id="nav_menu-3" class="widget widget_nav_menu">-->
                <!--                                                        <div class="menu-bottom-bar-right-container">-->
                <!--                                                            <ul id="menu-bottom-bar-right" class="menu">-->
                <!--                                                                --><?php
                //                                                                $main_nav_config = array(
                //                                                                    'parent_li_start' => "<li class='menu-item x-menu-item {active_class}'><a id='menu-{id}' class='x-menu-a-text menu-item-{id} menu-type-{menu_type}' href='{href}' data-description='{title}'><span class=\"x-menu-text\">{title}</span></a>",// <span class='glyphicon glyphicon-chevron-down'></span>
                //                                                                    'child_li_start' => "<li class='menu-item x-menu-item {active_class}'><a id='menu-{id}' class='x-menu-a-text menu-item-{id} menu-type-{menu_type}' href='{href}' data-description='{title}'><span class=\"x-menu-text\">{title}</span></a>",
                //                                                                    'child_li_end' => '</li>',
                //                                                                    //'child_ul_start' => '',
                //                                                                    'active_class' => 'current-menu-parent',
                //                                                                    //'call_func' => 'parse_menu_items',
                //                                                                );
                //                                                                $main_nav_config['default_active'] = getUri(1);
                //                                                                echo get_nav(1, $main_nav_config);
                //                                                                ?>
                <!--                                                            </ul>-->
                <!--                                                        </div>-->
                <!--                                                    </aside>-->
                <!--                                                </div>-->
                <!--                                            </div>-->
                <!--                                        </div>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
            </div>
            <div class="vc_row-full-width vc_clearfix"></div>
        </div>
    </div>
</footer>
</div>
<!--============== back to top ==============-->
<a class="back-to-top" href="javascript:;"> <i class="fa fa-angle-up"></i> </a>
<!--============== login modal ==============-->
<div class="modal modal-login fade" id="ere_signin_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <ul class="nav nav-tabs">
                <li class="active"><a id="ere_login_modal_tab" href="#login" data-toggle="tab">Log in</a></li>
                <li><a id="ere_register_modal_tab" href="#register" data-toggle="tab">Register</a></li>
                <li><a id="ere_agent_modal_tab" href="#agent" data-toggle="tab">Agent</a></li>
            </ul>
            <div class="tab-content ">
                <div class="tab-pane active" id="login">
                    <div class="ere-login-wrap">
                        <div class="ere_messages message"></div>
                        <form class="ere-login" method="post" enctype="multipart/form-data"
                              action="<?php echo site_url('login/login'); ?>">
                            <div class="form-group control-username">
                                <input class="form-control" type="text" placeholder="<?php echo __('Email'); ?>"
                                       name="email" id="email" autocomplete="off">
                            </div>
                            <div class="form-group control-password">
                                <input class="form-control m-login__form-input--last" type="password"
                                       placeholder="<?php echo __('Password'); ?>" name="password">
                            </div>
                            <!--<div class="checkbox">
                               <label>
                                   <input name="remember" type="checkbox"> Remember me
                               </label>
                               </div>-->
                            <input type="hidden" name="redirect" value="<?php echo getVar('redirect'); ?>">
                            <input type="hidden" name="action" value="ere_login_ajax"> <a href="javascript:void(0)"
                                                                                          class="ere-reset-password">Forgot
                                password?</a>
                            <button type="submit" data-redirect-url=""
                                    class="ere-login-button btn btn-primary btn-block">Login
                            </button>
                        </form>
                        <hr>
                        <div class="wp-social-login-widget">
                            <div class="wp-social-login-connect-with text-center" style="color: #797474;"><b>Connect
                                    with:</b></div>
                            <div class="wp-social-login-provider-list">
                                <div class="text-center social-btn">
                                    <a href="<?php echo site_url('hauth/login/Facebook'); ?>"
                                       class="btn btn-primary btn-block"><i class="fa fa-facebook"></i> Sign in with <b>Facebook</b></a>
                                    <!--<a href="<?php /*echo site_url('hauth/login/Twitter');*/ ?>" class="btn btn-info btn-block"><i class="fa fa-twitter"></i> Sign in with <b>Twitter</b></a>-->
                                    <a href="<?php echo site_url('hauth/login/Google'); ?>"
                                       class="btn btn-danger btn-block"><i class="fa fa-google"></i> Sign in with <b>Google</b></a>
                                </div>
                            </div>
                            <div class="wp-social-login-widget-clearing"></div>
                        </div>
                    </div>
                    <div class="ere-reset-password-wrap" style="display: none">
                        <div class="ere-resset-password-wrap">
                            <div class="ere_messages message ere_messages_reset_password"></div>
                            <form method="post" enctype="multipart/form-data"
                                  action="<?php echo site_url('login/forgot'); ?>">
                                <div class="form-group control-username">
                                    <input name="email" class="form-control control-icon reset_password_user_login"
                                           placeholder="Enter your username or email">
                                    <button type="submit" class="btn btn-primary btn-block ere_forgetpass">Get new
                                        password
                                    </button>
                                </div>
                            </form>
                        </div>
                        <a href="javascript:void(0)" class="ere-back-to-login">Back to Login</a>
                    </div>
                </div>
                <div class="tab-pane" id="register">
                    <div class="ere-register-wrap">
                        <div class="ere_messages message"></div>
                        <form class="ere-register" method="post" enctype="multipart/form-data"
                              action="<?php echo site_url('login/registration'); ?>">
                            <input type="hidden" name="redirect" value="<?php echo getVar('redirect'); ?>">
                            <div class="form-group control-username">
                                <input name="first_name" class="form-control control-icon" type="text"
                                       placeholder="Full name"/>
                            </div>
                            <div class="form-group control-phone">
                                <input class="form-control control-icon" type="text" placeholder="Phone" name="phone"
                                       data-inputmask="'mask': '+999999999999'">
                            </div>
                            <div class="form-group control-email">
                                <input name="email" type="email" class="form-control control-icon" placeholder="Email"/>
                            </div>
                            <div class="form-group control-password">
                                <input class="form-control" type="password" placeholder="Password" id="password"
                                       name="password">
                            </div>
                            <div class="form-group control-password">
                                <input class="form-control m-login__form-input--last" type="password"
                                       placeholder="Confirm Password" name="rpassword">
                            </div>
                            <div class="form-group control-term-condition">
                                <div class="checkbox">
                                    <label>
                                        <input name="agree" type="checkbox"> I agree with your <a target="_blank"
                                                                                                  href="<?php echo site_url('terms-conditions'); ?>">Terms
                                            &amp; Conditions</a>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group control-newsletter">
                                <div class="checkbox">
                                    <label>
                                        <input name="newsletter" id="newsletter" type="checkbox">
                                        <span>Subscribe To Our Newsletter</span>
                                    </label>
                                </div>
                            </div>





                            <button type="submit" data-redirect-url=""
                                    class="ere-register-button btn btn-primary btn-block">Register
                            </button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane" id="agent">
                    <div class="ere-register-wrap ere-agent-wrap">
                        <div class="ere_messages message"></div>
                        <form class="ere-agent" method="post" enctype="multipart/form-data"
                              action="<?php echo site_url('login/registration'); ?>">
                            <input type="hidden" name="redirect" value="<?php echo getVar('redirect'); ?>">
                            <input type="hidden" name="become_agent" value="1">
                            <div class="form-group control-username">
                                <input name="first_name" class="form-control control-icon" type="text"
                                       placeholder="Full name"/>
                            </div>
                            <div class="form-group control-phone">
                                <input class="form-control control-icon" type="text" placeholder="Phone" name="phone"
                                       data-inputmask="'mask': '+999999999999'">
                            </div>
                            <div class="form-group control-email">
                                <input name="email" type="email" class="form-control control-icon" placeholder="Email"/>
                            </div>
                            <div class="form-group control-password">
                                <input class="form-control" type="password" placeholder="Password" id="ag_password"
                                       name="password">
                            </div>
                            <div class="form-group control-password">
                                <input class="form-control m-login__form-input--last" type="password"
                                       placeholder="Confirm Password" name="rpassword">
                            </div>

                            <div class="">
                                <label class="control-label"><?php echo __('City');?></label><br>
                                <select  name="city" id="reg_agent_city" class="form-control control-password m-select2" load-select="#reg_agent_area_ids">
                                    <option value="">- Select -</option>
                                    <?php echo selectBox("SELECT id, city AS _city FROM cities")?>
                                </select>
                            </div>

                            <div class="">
                                <?php
                                $area_ids = array();
                                ?>
                                <label class="control-label"><?php echo __("Deals in Area's");?></label><br>
                                <select  name="area_ids[]" id="reg_agent_area_ids" class="form-control control-password m_select2-tags" multiple load-url="<?php echo site_url('property/ajax/city_area');?>">
                                    <option value="">- Select -</option>
                                </select>
                            </div>

                            <div class="form-group control-term-condition">
                                <div class="checkbox">
                                    <label>
                                        <input name="agree" type="checkbox"> I agree with your <a target="_blank"
                                                                                                  href="<?php echo site_url('terms-conditions'); ?>">Terms
                                            &amp; Conditions</a>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group control-newsletter">
                                <div class="checkbox">
                                    <label>
                                        <input name="newsletter" id="newsletter" type="checkbox">
                                        <span>Subscribe To Our Newsletter</span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit" data-redirect-url=""
                                    class="ere-agent-button btn btn-primary btn-block">Register
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--============== form modal ==============-->

<!--============== search popup ==============-->

<!--<div id="-search_popup_wrapper" class="dialog area_popup_wrapper">
    <div class="dialog__overlay"></div>
    <div class="dialog__content">
        <div class="morph-shape">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 520 280"
                 preserveAspectRatio="none">
                <rect x="3" y="3" fill="none" width="516" height="276"/>
            </svg>
        </div>
        <div class="dialog-title btn btn-primary">Change Area Unit</div>
        <div class="dialog-inner">

            <select name="_area_unit" id="_area_unit"  class="search-field select2">
                <?php
/*                $area_units = get_enum_values('properties', 'area_unit');
                foreach ($area_units as $item) {
                    echo '<option value="' . $item . '" ' . _selectbox($_COOKIE['area_unit'], $item) . '>' . $item . '</option>';
                }
                */ ?>
            </select>

            <div><a class="action prevent-default" data-dialog-close="close" href="#"><i
                            class="fa fa-close transition03"></i></a></div>
        </div>
    </div>
</div>-->

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content change_area">
            <div class="modal-header btn btn-primary">
                Change Area Unit
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="select_div">
                    <select name="_area_unit" id="_area_unit" class="search-field select2" style="width: 100%;">
                        <?php
                        $area_units = get_enum_values('properties', 'area_unit');
                        foreach ($area_units as $item) {
                            echo '<option value="' . $item . '" ' . _selectbox($_COOKIE['area_unit'], $item) . '>' . $item . '</option>';
                        }
                        ?>
                    </select>
                </div>

            </div>
        </div>

    </div>

</div>
</div>
</div>

<!--============== form popup ==============-->
<!--============== search popup ==============-->
<div id="search_popup_wrapper" class="dialog">
    <div class="dialog__overlay"></div>
    <div class="dialog__content">
        <div class="morph-shape">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 520 280"
                 preserveAspectRatio="none">
                <rect x="3" y="3" fill="none" width="516" height="276"/>
            </svg>
        </div>
        <div class="dialog-inner">
            <?php //include "search_form.php"?>
            <h2>Enter your keyword</h2>
            <form method="get" action="#/" class="search-popup-inner">
                <input type="text" name="s" placeholder="Type and hit enter...">
                <button class="bt bt-sm bt-background bt-primary" type="submit">Search</button>
            </form>
            <div><a class="action prevent-default" data-dialog-close="close" href="#"><i
                            class="fa fa-close transition03"></i></a></div>
        </div>
    </div>
</div>
<?php
$ci = &get_instance();
$member_id = intval(_session(FRONT_SESSION_ID));
$member = get_member($member_id);
$agent_type_id = intval(get_option('agent_type_id'));
$area_ids = getVar('area_ids', false, false);

$x_area = explode('-', getUri(3));
$area_id = end($x_area);
if ($area_id > 0) {
    $area_ids[] = $area_id;
}

$total_logedin = 0;
if (count($area_ids) > 0 && getUri(1) == 'properties') {
    $A_SQL = "SELECT COUNT(DISTINCT users.id) AS total FROM users
   INNER JOIN agent_area_list ON(agent_area_list.agent_id = users.id)
   WHERE users.id !='{$member_id}' AND users.user_type_id='{$agent_type_id}' 
   AND users.status='Active' AND users.logedin=1
   AND agent_area_list.area_id IN(" . join(',', array_map("intval", $area_ids)) . ")";

    //echo '<pre>'; print_r($A_SQL); echo '</pre>';
    $total_logedin = $ci->db->query($A_SQL)->row()->total;
}
if (!$member_id && $total_logedin > 0) {
    ?>
    <script type='text/javascript' src="<?php echo media_url('js/page.mindf0b.js'); ?>"></script>
    <div class="popup2 bounceIn animated infinite demoLabel mainDemo-17">
        <img src="<?php echo media_url('images/LOGO-12.png'); ?>" alt="">
    </div>
    <div class="userProfile agent-popup show" data-sm-init="true">
        <div class="popup_title">Do you want to contact property agent?</div>
        <a href="javascript:void(0)" class="login-link topbar-link" data-toggle="modal" data-target="#ere_signin_modal">
            <i class="fa fa-user"></i><span class="hidden-xs">Login or Register</span>
        </a>
    </div>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.agent-popup .login-link', function (e) {
                e.preventDefault();
                $('[data-sm-close]').trigger('click');
                //$('#ere_signin_modal').modal('show');
            });
        });
    </script>
    <?php
}
if ($total_logedin > 0) {
    ?>
    <script type='text/javascript' src="<?php echo media_url('js/page.mindf0b.js'); ?>"></script>
    <div class="popup2 bounceIn animated infinite demoLabel mainDemo-17">
        <img src="<?php echo media_url('images/LOGO-12.png'); ?>" alt="">
    </div>
    <div class="userProfile agent-popup show" data-sm-init="true">
        <div class="popup_title">Do you want to contact property agent?</div>
        <a href="#" class="popup_btn agent-yes">YES</a>
        <a href="#" class="popup_btn agent-no">NO</a>
    </div>
    <!--<div class="agent-popup show">
       <h4>Do you want to contact property agent?</h4>
       <a href="javascript: void(0);" class="popup_btn agent-yes">YES</a>
       <a href="javascript: void(0);" class="popup_btn agent-no">NO</a>
       </div>-->
    <script>
        $(document).ready(function () {
            $(document).on('click', '.agent-yes', function (e) {

                e.preventDefault();
                $('.agent-popup').html('<h4>Please wait for contact and any agent...?</h4>');
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: '<?php echo site_url('agent/ajax/contact_all');?>',
                    data: {area_ids: '<?php echo join(',', $area_ids);?>'},
                }).done(function (json) {
                    //$('.agent-popup').removeClass('show');
                    $('[data-sm-close]').trigger('click');
                })
                    .fail(function () {

                    });
            });
            $(document).on('click', '.agent-no', function (e) {
                e.preventDefault();
                //$.cookie('name', 'value', { expires: 1 });
                $('.agent-popup').removeClass('show');
                $('[data-sm-close]').trigger('click');
            });
        });
    </script>
<?php } ?>
<?php
if ($member->user_type_id == $agent_type_id) {
    ?>
    <script type='text/javascript' src="<?php echo media_url('js/page.mindf0b.js'); ?>"></script>
    <div class="popup2 bounceIn animated infinite demoLabel mainDemo-17 for-agent" style="display: none;">
        <img src="<?php echo media_url('images/LOGO-12.png'); ?>" alt="">
    </div>
    <div class="userProfile agent-popup  for-agent" data-sm-init="true">
        <!--<div class="agent-popup  for-agent">-->
        <h4>Do you want to contact?</h4>
        <?php //if(count($member_rows) > 0) {
        ?>
        <table class="table member-contact-list">
        </table>
        <?php //}
        ?>
        <table class="table member-call-list">
        </table>
    </div>
    <script>
        $(document).ready(function () {
            let num_agent = 0;

            function check_contact_list() {

                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: '<?php echo site_url('agent/ajax/check_contact');?>',
                    data: {},
                }).done(function (json) {
                    if (json.status) {
                        if (json.status > num_agent) {
                            let audio = new Audio('<?php echo media_url('to-the-point.mp3');?>');
                            audio.play();
                        }
                        num_agent = json.status;

                        $('.for-agent').addClass('show').find('.member-contact-list').html(json.html);
                    } else {
                        $('.for-agent').removeClass('show').find('.member-contact-list').html(json.html);
                        //$('[data-sm-close]').trigger('click');
                    }
                })
                    .fail(function () {

                    });
            }

            check_contact_list();

            setInterval(check_contact_list, 5000);


            $(document).on('click', '.call-now', function (e) {

                e.preventDefault();
                let _this = $(this);
                let _tr = _this.closest('tr').clone();
                let _data = _this.data();

                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: '<?php echo site_url('agent/ajax/contact_done');?>',
                    data: _data,
                }).done(function (json) {
                    check_contact_list();
                    if (json.status) {
                        _tr.find('.call-now').attr('href', 'tel:' + _data.phone).removeClass('call-now')
                            .removeClass('btn')
                            .removeClass('btn-sm')
                            .removeClass('btn-success')
                            .html(_data.phone);
                        $('.member-call-list').append(_tr);

                        //window.open('tel:' + _data.phone);
                        //$('[data-sm-close]').trigger('click');
                    }
                })
                    .fail(function () {

                    });
            });

        });
    </script>
<?php } ?>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".imgInp").change(function () {
        readURL(this);
    });


    $(document).ready(function () {

        var data = [];
        var menu_item;
        $('.menu-item').click(function () {
            menu_item = $(this).text();
            var custMenu = $.cookie('menu_item');

            if (custMenu == undefined) {
                data.push(menu_item);

            } else {

                if (custMenu != 'undefined' || custMenu != '') {
                    custMenu.split(",");
                    data.push(custMenu);
                }
            }

            if (data[0].includes(menu_item) === true) {
                $.cookie('last_menu_count', menu_item, {expires: 1});

            } else {

                data.push(menu_item);
                $.removeCookie('last_menu_count');
                ///  show_popup_modal();
            }
            $.cookie('menu_item', data, {expires: 1});

        });
        var cookies = $.cookie('menu_item');
        if (cookies === undefined || cookies === '') {
            show_popup_modal();
        }

        if (cookies) {
            var cookiesplit = cookies.split(",");
            if (cookiesplit) {
                var last_menu_count = $.cookie('last_menu_count');
                if (cookiesplit.includes(last_menu_count) === false) {
                    show_popup_modal();
                }

            }

        }

        $(document).on('click', '.sort-property a', function (e) {
            var url = $(this).data().href;

            $('.ere-property').html('<div class="cust-loader"></div>');
            $.ajax({
                url: url,
                success: function (result) {
                    $('.ere-property').html($(result).find('.ere-property').html());
                    //$('.archive-property-action').html($(result).find('.archive-property-action').html());
                }
            });
        });

        $(document).on('click', '.property-status-cust', function (e) {
            $('.property-status-cust').removeClass('active');
            $(this).addClass('active');
            var _a = $(this).find('a');
            var url = _a.data().href;

            $('.ere-property').html('<div class="cust-loader"></div>');
            $.ajax({
                url: url,
                success: function (result) {
                    $('.ere-property').html($(result).find('.ere-property').html());
                    //$('.archive-property-action').html($(result).find('.archive-property-action').html());
                }
            });

        });

        
        
        function show_popup_modal() {


            $('#popup-modal').on('show.bs.modal', function () {
                $('.popup-carousel').owlCarousel({
                    loop: true,
                    margin: 0,
                    dots: false,
                    nav: false,
                    smartSpeed: 700,
                    autoplay: true,
                    navText: ['<span class="la la-angle-left"></span>', '<span class="la la-angle-right"></span>'],
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 1
                        },
                        1024: {
                            items: 1
                        }
                    }
                });
            });

            $('#popup-modal').modal('show').addClass('fade show in');


            setInterval(function () {
                $('#popup-modal').modal('hide');
            }, 6000);
        }

        // tagging support
        $('.m_select2-tags').select2({
            placeholder: "Add a tag",
            tags: true
        });

        $('.m-select2').on('select2:select', function (e) {
            var data = e.params.data;
            if(data.id != ""){
                $('#reg_agent_city-error').hide();
            }
        });

        $('.m_select2-tags').on('select2:select', function (e) {
            var data = e.params.data;
            var selected_collection = $('.m_select2-tags').select2('data')
            if(selected_collection.length > 0){
                $('#reg_agent_area_ids-error').hide();
            }
        });


    });

</script>
<!--End pagewrapper-->
<?php include "footer_js.php" ?>
</body>
</html>
