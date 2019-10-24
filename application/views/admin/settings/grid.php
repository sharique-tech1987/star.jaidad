<?php include __DIR__ . "/../includes/module_header.php"; ?>
    <div class="m-portlet__body p-1">

    <form id="validate" class="form-horizontal validate" action="<?php echo admin_url($this->_route . '/update'); ?>" method="post" enctype="multipart/form-data">

        <div class="tabbable -tabs-left">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a href="#general-setting" class="nav-link active" data-toggle="tab"><i class="flaticon-settings"></i> General Settings</a></li>
                <li class="nav-item"><a href="#web-setting" class="nav-link" data-toggle="tab"><i class="flaticon-interface-2"></i> Website Settings</a></li>
                <li class="nav-item"><a href="#social-setting" class="nav-link" data-toggle="tab"><i class="flaticon-twitter-logo"></i> Social Settings</a></li>
                <li class="nav-item"><a href="#SMTP-setting" class="nav-link" data-toggle="tab"><i class="flaticon-multimedia-3"></i> SMTP Settings</a></li>
                <li class="nav-item"><a href="#recaptcha-setting" class="nav-link" data-toggle="tab"><i class="flaticon-map-location"></i> API Keys</a></li>
                <li class="nav-item"><a href="#price-setting" class="nav-link" data-toggle="tab"><i class="flaticon-coins"></i> Price/Area Config</a></li>
                <!--<li><a href="#app-labels" data-toggle="tab"><i class="icon-key"></i> APP Labels</a></li>-->
            </ul>
            <div class="tab-content pd-20">

                <div class="tab-pane active" id="general-setting">
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Site Title:</label>
                        <div class="col-lg-10">
                            <input type="text" name="setting[site_title]" class="form-control" value="<?php echo get_option('site_title'); ?>">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Tag Line:</label>
                        <div class="col-lg-10">
                            <input type="text" name="setting[tag_line]" class="form-control" value="<?php echo get_option('tag_line'); ?>">
                        </div>
                    </div>

                    <!--<div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">Top Text:</label>
                            <div class="col-lg-10">
                                <textarea name="setting[top_text]" cols="" rows="5" class="small_editor col-sm-12"><?php /*echo get_option('top_text'); */?></textarea>
                            </div>
                        </div>-->

                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Copyright Text:</label>
                        <div class="col-lg-10">
                            <textarea name="setting[copyright]" cols="" rows="5" class="form-control col-sm-12"><?php echo get_option('copyright'); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Email Address:</label>
                        <div class="col-lg-10">
                            <input type="text" name="setting[contact_email]" class="form-control" value="<?php echo get_option('contact_email'); ?>">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Email CC:</label>
                        <div class="col-lg-10">
                            <input type="text" name="setting[admin_cc_email]" class="form-control" value="<?php echo get_option('admin_cc_email'); ?>">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Phone Number:</label>
                        <div class="col-lg-10">
                            <input type="text" name="setting[phone_number]" class="form-control" value="<?php echo get_option('phone_number'); ?>">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Fax Number:</label>
                        <div class="col-lg-10">
                            <input type="text" name="setting[fax_number]" class="form-control" value="<?php echo get_option('fax_number'); ?>">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Address:</label>
                        <div class="col-lg-10">
                            <textarea name="setting[address]" cols="" rows="3" class="form-control col-sm-12"><?php echo get_option('address'); ?></textarea>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">GMAP Key:</label>
                        <div class="col-lg-10">
                            <input type="text" name="setting[gmap_key]" class="form-control" value="<?php echo get_option('gmap_key'); ?>">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Latitude:</label>
                        <div class="col-sm-4">
                            <input type="text" name="setting[latitude]" class="form-control" value="<?php echo get_option('latitude'); ?>">
                        </div>
                        <label class="col-sm-2 control-label">Longitude:</label>
                        <div class="col-sm-4">
                            <input type="text" name="setting[longitude]" class="form-control" value="<?php echo get_option('longitude'); ?>">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Agent Popup:</label>
                        <div class="col-lg-2">
                            <div class="input-group">
                                <input type="text" name="setting[popup_time]" class="form-control" value="<?php echo get_option('popup_time'); ?>">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">MINUTE</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Currency:</label>
                        <div class="col-lg-2">
                            <input type="text" name="setting[currency]" class="form-control" value="<?php /*echo get_option('currency'); */?>">
                        </div>
                    </div>-->

                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Weekend:</label>
                        <div class="col-lg-10">
                            <select id="weekend" name="setting[weekend][]" class="form-control m_select2-tags" multiple>
                                <?php
                                $weekend = unserialize(get_option('weekend'));
                                $OP = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                echo selectBox(array_combine($OP, $OP), $weekend);
                                ?>
                            </select>
                        </div>
                    </div>

                    <!--<div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Change Password:</label>
                        <div class="col-lg-2">
                            <div class="input-group">
                                <input type="text" name="setting[password_days]" class="form-control" value="<?php /*echo get_option('password_days'); */?>">
                                <div class="input-group-append">
                                    <span class="input-group-text">Days</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Recent Password Limit:</label>
                        <div class="col-lg-2">
                            <input type="text" name="setting[old_password_limit]" class="form-control" value="<?php /*echo get_option('old_password_limit'); */?>">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Password Limit MSG:</label>
                        <div class="col-lg-10">
                            <input type="text" name="setting[old_password_limit_msg]" class="form-control" value="<?php /*echo get_option('old_password_limit_msg'); */?>">
                        </div>
                    </div>-->
                </div>

                <div class="tab-pane fade" id="web-setting">
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Title Prefix:</label>
                        <div class="col-lg-10">
                            <input type="text" name="setting[title_prefix]" class="form-control" value="<?php echo get_option('title_prefix'); ?>">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Title Suffix:</label>
                        <div class="col-lg-10">
                            <input type="text" name="setting[title_suffix]" class="form-control" value="<?php echo get_option('title_suffix'); ?>">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Logo:</label>
                        <div class="col-sm-5">
                            <div class="custom-file">
                                <input type="file" name="setting[logo]" class="form-control custom-file-input" placeholder="Logo" />
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <?php
                        $_logo = get_option('logo');
                        if (!empty($_logo)) {
                            $thumb_url = asset_url('img/' . $_logo, true);
                            $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/logo/' . $_logo);
                            echo thumb_box($thumb_url, $delete_img_url);
                        }
                        ?>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Footer Logo:</label>
                        <div class="col-sm-5">
                            <div class="custom-file">
                                <input type="file" name="setting[footer_logo]" class="form-control custom-file-input" placeholder="Footer Logo" />
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <?php
                        $_logo = get_option('footer_logo');
                        if (!empty($_logo)) {
                            $thumb_url = asset_url('img/' . $_logo, true);
                            $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/footer_logo/' . $_logo);
                            echo thumb_box($thumb_url, $delete_img_url);
                        }
                        ?>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Watermark Logo:</label>
                        <div class="col-sm-5">
                            <div class="custom-file">
                                <input type="file" name="setting[wm_logo]" class="form-control custom-file-input" placeholder="Watermark Logo" />
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <?php
                        $_logo = get_option('wm_logo');
                        if (!empty($_logo)) {
                            $thumb_url = asset_url('img/' . $_logo, true);
                            $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/wm_logo/' . $_logo);
                            echo thumb_box($thumb_url, $delete_img_url);
                        }
                        ?>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Favicon Icon:</label>
                        <div class="col-sm-5">
                            <div class="custom-file">
                                <input type="file" name="setting[favicon]" class="form-control custom-file-input" placeholder="Favicon" />
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <?php
                        $_favicon = get_option('favicon');
                        if (!empty($_favicon)) {
                            $thumb_url = asset_url('img/' . $_favicon, true);
                            $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/favicon/' . $_favicon);
                            echo thumb_box($thumb_url, $delete_img_url);
                        }
                        ?>
                    </div>

                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Default Description:</label>
                        <div class="col-lg-10">
                            <textarea name="setting[meta_description]" id="meta_description" class="form-control" cols="30" rows="5"><?php echo get_option('meta_description'); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Default Keywords:</label>
                        <div class="col-lg-10">
                            <textarea name="setting[meta_keywords]" id="meta_keywords" class="form-control" cols="30" rows="5"><?php echo get_option('meta_keywords'); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Google analytics (JS):</label>
                        <div class="col-lg-10">
                            <textarea name="setting[google_analytics_js]" id="google_analytics_js" class="form-control" cols="30" rows="5"><?php echo get_option('google_analytics_js'); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Default Robots:</label>
                        <div class="col-lg-4">
                            <select id="robots" name="setting[robots]" class="form-control m-bootstrap-select m_selectpicker">
                                <?php
                                $_robots = array(
                                    'INDEX,FOLLOW'  => 'INDEX, FOLLOW',
                                    'NOINDEX, FOLLOW'  => 'NOINDEX, FOLLOW',
                                    'INDEX, NOFOLLOW'  => 'INDEX, NOFOLLOW',
                                    'NOINDEX, NOFOLLOW'  => 'NOINDEX, NOFOLLOW',
                                );
                                echo selectBox($_robots, get_option('robots'));
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Selected Theme:</label>
                        <div class="col-lg-4">
                            <select id="robots" name="setting[theme]" class="form-control m-bootstrap-select m_selectpicker">
                                <?php
                                foreach(array_filter(glob(dirname(__FILE__) . '/../../themes/*'), 'is_dir') as $_dir){
                                    $_theme_dir = end(explode('/', end(explode(DIRECTORY_SEPARATOR, $_dir))));
                                    $_theme_name = ucwords(str_replace(array('-','_'), ' ', end(explode('/', end(explode(DIRECTORY_SEPARATOR, $_dir))))));
                                    $_themes[$_theme_dir] = $_theme_name;
                                }

                                echo selectBox($_themes, get_option('theme'));
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Selected Header:</label>
                        <div class="col-lg-4">
                            <select name="setting[header]" id="header" class="m-select2" style="width: 100%;">
                                <?php
                                $template[''] = 'Default';
                                $headers = [];
                                if(function_exists('get_theme_templates')){
                                    $headers += get_theme_templates('header-');
                                }
                                foreach ($headers as $key => $val) {
                                    $template[str_replace('header-', '', $key)] = $val;
                                }
                                echo selectBox($template, get_option('header'));
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Site Loader:</label>
                        <div class="col-lg-2">
                            <select id="site_loader" name="setting[site_loader]" class="form-control m-bootstrap-select m_selectpicker">
                                <?php
                                $_OP = array(
                                    'On'  => 'On',
                                    'Off'  => 'Off',
                                );
                                echo selectBox($_OP, get_option('site_loader'));
                                ?>
                            </select>
                        </div>
                    </div>

                    <!--<div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">Front Page:</label>
                            <div class="col-lg-10">
                                <select id="front_page" name="setting[front_page]" class="form-control m-bootstrap-select m_selectpicker">
                                    <?php
                    /*                                    $_pages = "SELECT `id`,`title`  FROM `pages` WHERE `status`='published'";
                                                        echo selectBox($_pages, get_option('front_page'));
                                                        */?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">Blog Page:</label>
                            <div class="col-lg-10">
                                <select id="blog_page" name="setting[blog_page]" class="form-control m-bootstrap-select m_selectpicker">
                                    <?php
                    /*                                    $_pages = "SELECT `id`,`title`  FROM `pages` WHERE `status`='published'";
                                                        echo selectBox($_pages, get_option('blog_page'));
                                                        */?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">Posts Per Page:</label>
                            <div class="col-sm-2">
                                <input type="text" name="setting[posts_per_page]" class="form-control" value="<?php /*echo get_option('posts_per_page'); */?>">
                            </div>
                        </div>-->
                </div>
                <div class="tab-pane fade" id="social-setting">
                    <?php
                    $inputs = ['Facebook', 'Twitter', 'Youtube', 'google-plus' => 'Google+', 'instagram' => 'Instagram', 'pinterest', 'Linkedin', 'Skype'];
                    $values = json_decode(get_option('social'), true);

                    foreach ($inputs as $key => $title) {
                        $name = (is_int($key) ? url_title($title, '_', true) : $key);
                        ?>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label"><?php echo $title;?>:</label>
                            <div class="col-lg-10">
                                <input type="text" name="setting[social][<?php echo $name;?>]" class="form-control" value="<?php echo $values[$name]; ?>">
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <div class="tab-pane fade" id="SMTP-setting">
                    <?php
                    $values = json_decode(get_option('smtp'), true);
                    ?>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">SMTP:</label>
                        <div class="col-lg-2">
                            <select name="setting[smtp][status]" id="smtp" class="form-control m-bootstrap-select m_selectpicker">
                                <?php
                                $_OP = array(
                                    '1'  => 'Yes',
                                    '0'  => 'No'
                                );
                                echo selectBox($_OP, $values['status']);?>
                            </select>
                        </div>
                    </div>

                    <?php
                    $inputs = ['Host', 'User', 'Pass', 'port' => 'Port'];
                    foreach ($inputs as $key => $title) {
                        $name = (is_int($key) ? url_title($title, '_', true) : $key);
                        ?>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label"><?php echo $title;?>:</label>
                            <div class="col-lg-10">
                                <input type="text" name="setting[smtp][<?php echo $name;?>]" class="form-control" value="<?php echo $values[$name]; ?>">
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>

                <div class="tab-pane fade" id="contact-setting">
                    <!--<div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">Enable Contact Us:</label>
                            <div class="col-lg-10">
                                <select id="robots" name="setting[enable_contact]" class="select">
                                    <?php
                    /*                                    $_enable_contact = array(
                                                            '1'  => 'Yes',
                                                            '0'  => 'No'
                                                        );
                                                        echo selectBox($_enable_contact, get_option('enable_contact'));
                                                        */?>
                                </select>
                            </div>
                        </div>-->

                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Send Emails To:</label>
                        <div class="col-lg-10">
                            <input type="text" name="setting[recipient_email]" class="form-control" value="<?php echo get_option('recipient_email'); ?>">
                        </div>
                    </div>
                    <!--<div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Lat - Lng:</label>
                        <div class="col-sm-3">
                            <input type="text" name="setting[latitude]" placeholder="Latitude" class="form-control" value="<?php /*echo get_option('latitude'); */?>">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="setting[longitude]" placeholder="Longitude" class="form-control" value="<?php /*echo get_option('longitude'); */?>">
                        </div>
                    </div>-->

                    <!--<div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">Email Template:</label>
                            <div class="col-lg-10">
                                <input type="text" name="setting[contcat_email_template]" class="form-control" value="<?php /*echo get_option('contcat_email_template'); */?>">
                            </div>
                        </div>-->
                </div>

                <div class="tab-pane fade" id="recaptcha-setting">

                    <?php
                    $values = json_decode(get_option('recaptcha'), true);

                    $inputs = [
                        'recaptcha_public_key' => 'Re-captcha Public Key',
                        'recaptcha_private_key' => 'Re-captcha Private Key',
                    ];
                    foreach ($inputs as $key => $title) {
                        $name = (is_int($key) ? url_title($title, '_', true) : $key);
                        ?>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label"><?php echo $title;?>:</label>
                            <div class="col-lg-10">
                                <input type="text" name="setting[recaptcha][<?php echo $name;?>]" class="form-control" value="<?php echo $values[$name]; ?>">
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">Re-captcha Skin:</label>
                        <div class="col-lg-3">
                            <select name="setting[recaptcha][recaptcha_skin]" id="recaptcha_skin" class="form-control m-bootstrap-select m_selectpicker">
                                <?php
                                $_recaptcha_skins = array(
                                    'red' => 'Red (default theme)',
                                    'white' => 'White',
                                    'blackglass' => 'blackglass',
                                    'clean' => 'clean'
                                );
                                echo selectBox($_recaptcha_skins, $values['recaptcha_skin']);?>
                            </select>
                            <!--<input type="text" name="setting[recaptcha_skin]" class="form-control" value="<?php /*echo get_option('recaptcha_skin'); */?>">-->
                        </div>
                    </div>
                </div>

                <?php include "app_labels.php";?>
                <?php include "app_prices.php";?>

            </div>
        </div>

        <div class="well">
            <div class="form-actions text-right">
                <button type="submit" class="btn btn-danger" name="form_submit">Update</button>
                <a href="<?php echo admin_url(); ?>" class="btn btn-primary">Dashboard</a>
            </div>
        </div>
    </form>
    <div class="clear">
        <br/>
    </div>
</div>

<?php include __DIR__ . "/../includes/module_footer.php"; ?>