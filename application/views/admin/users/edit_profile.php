<style>
    .user-left-side .m-nav .m-nav__item>.m-nav__link{
        height: auto;
    }
</style>
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="m-subheader__title m-subheader__title--separator">
                <img src="<?php echo _img(ADMIN_ASSETS_DIR . 'uploads/icons/' . $this->_info->icon, 32, 32);?>" alt="">&nbsp;
                <?php echo __($this->_info->module_title); ?>
            </h3>
            <?php echo $this->breadcrumb->display();?>
        </div>
    </div>
</div>

<div class="m-content">
    <?php echo show_validation_errors();?>

    <form id="profile" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" action="<?php echo admin_url($this->_route . '/update/'); ?>">

        <div class="row">
            <div class="col-xl-3 col-lg-4 user-left-side">
                <div class="m-portlet m-portlet--full-height  ">
                    <div class="m-portlet__body">
                        <div class="m-card-profile">
                            <div class="m-card-profile__title m--hide">
                                Your Profile
                            </div>
                            <div class="m-card-profile__pic">
                                <div class="m-card-profile__pic-wrapper">
                                    <img src="<?php echo _img("assets/front/{$this->table}/" . $row->photo, 200,200, USER_IMG_NA);?>" alt="">
                                </div>
                            </div>
                            <div class="m-card-profile__details">
                                <span class="m-card-profile__name"><?php echo $row->full_name;?></span>
                                <a href="" class="m-card-profile__email m-link"><?php echo $row->email;?></a>
                            </div>
                        </div>
                        <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                            <li class="m-nav__separator m-nav__separator--fit"></li>
                            <li class="m-nav__section m--hide">
                                <span class="m-nav__section-text">Section</span>
                            </li>
                            <li class="m-nav__item">
                                <a href="../header/profile&amp;demo=default.html" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-profile-1"></i>
                                    <span class="m-nav__link-title">
                                        <span class="m-nav__link-wrap">
                                            <span class="m-nav__link-text">My Profile</span>
                                            <span class="m-nav__link-badge">
                                                <span class="m-badge m-badge--success">2</span>
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="../header/profile&amp;demo=default.html" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-share"></i>
                                    <span class="m-nav__link-text">Activity</span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="../header/profile&amp;demo=default.html" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                    <span class="m-nav__link-text">Messages</span>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

                    <div class="m-portlet__head">
                        <div class="m-portlet__head-progress">
                            <!-- here can place a progress bar-->
                        </div>
                        <div class="m-portlet__head-wrapper">
                            <div class="m-portlet__head-tools">
                                <?php
                                $ci =& get_instance();
                                $ci->load->library('form_btn');

                                $form_buttons = ['update_profile'];

                                $params = [
                                    'title' => 'Update',
                                    'class' => 'btn btn-brand m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10 m-btn--pill m-btn--air',
                                    'href' => '#save',
                                    'icon_cls' => 'la la-floppy-o',
                                ];
                                $ci->form_btn->add_button('update_profile', $params, true);

                                echo $ci->form_btn->buttons($form_buttons);
                                ?>
                            </div>
                            <?php echo portlet_actions();?>
                        </div>
                    </div>

                    <!--begin::Form-->

                    <input type="hidden" name="id" class="form-control" placeholder="ID">
                    <div class="m-portlet__body">

                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label required">
                                <?php echo __('First Name');?>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?php echo ($row->first_name);?>" />

                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">
                                <?php echo __('Last Name');?>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="<?php echo ($row->last_name);?>" />

                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">
                                <?php echo __('Photo');?>
                            </label>
                            <div class="col-lg-4">
                                <input disabled type="hidden" name="photo--rm" value="<?php echo $row->photo;?>">
                                <label class="custom-file">
                                    <input type="file" name="photo" id="photo" class="form-control custom-file-input" placeholder="Photo" value="<?php echo ($row->photo);?>" />
                                    <label class="custom-file-label"></label>
                                </label>

                            </div>
                            <?php
                            if (!empty($row->photo)) {
                                $thumb_url = _img("assets/front/{$this->table}/" . $row->photo, 200,200, USER_IMG_NA);
                                $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/photo');
                                echo thumb_box($thumb_url, $delete_img_url);
                            }
                            ?>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">
                                <?php echo __('Email');?>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo ($row->email);?>" />

                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">
                                <?php echo __('Phone');?>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" value="<?php echo ($row->phone);?>" />
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">
                                <?php echo __('Address');?>
                            </label>
                            <div class="col-lg-10">
                                    <textarea name="address" id="address" class="form-control" placeholder="Address" cols="30" rows="3"><?php echo $row->address;?></textarea>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">
                                <?php echo __('City');?>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="city" id="city" class="form-control" placeholder="City" value="<?php echo ($row->city);?>" />

                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">
                                <?php echo __('Country');?>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="country" id="country" class="form-control" placeholder="Country" value="<?php echo ($row->country);?>" />

                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">
                                <?php echo __('Zip Code');?>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="zip_code" id="zip_code" class="form-control" placeholder="Zip Code" value="<?php echo ($row->zip_code);?>" />

                            </div>
                        </div>
                        <!--<div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label">
                                <?php /*echo __('Newsletter');*/?>
                            </label>
                            <div class="col-lg-6">
                                <div>
                                        <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                            <label>
                                <input type="checkbox" value="1" name="newsletter" id="newsletter" value="<?php /*echo ($row->newsletter);*/?>" <?php /*echo _checkbox($row->newsletter, 1);*/?>/>
                                <span></span>
                                        </label>
                                        </span>
                                </div>
                            </div>
                        </div>-->

                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label required">
                                <?php echo __('Username');?>
                            </label>
                            <div class="col-lg-6">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo ($row->username);?>" />

                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label required">
                                <?php echo __('Password');?>
                            </label>
                            <div class="col-lg-6">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="" />
                                <?php if ($row->id > 0) {
                                    echo '<span class="m-form__help m--font-danger">Note: If you would like to change the password type a new one. Otherwise leave this blank.</span>';
                                } ?>
                            </div>
                        </div>

                        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions--solid">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <input type="submit" class="btn btn-success m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit');?>">
                                        <input type="button" next-url="<?php echo admin_url($this->_route . '/form');?>" class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air" value="<?php echo __('Submit & New');?>">
                                        <button type="reset" class="btn btn-metal m-btn m-btn--icon m-btn--pill m-btn--air">
                                            <?php echo __('Cancel');?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
<!--end::Portlet-->
</div>

<script>

    $( "form#profile" ).validate({
        // define validation rules
        rules: {
            'first_name': {
                required: true,
            },
            'email': {
                required: true,email: true,
            },
            'user_type_id': {
                required: true,
            },
            'username': {
                required: true,
                remote: '<?php echo admin_url($this->_route . '/AJAX/validate/' . $row->id)?>',
            },
            'password': {
                required: true,
            },
        },
        messages: {
            'username': {/*required: 'Username is required', */remote: 'This username is already exist',},
            /*'password': {required: 'Password is required',},
            'first_name': {required: 'First Name is required',},
            'email': {required: 'Email is required', email: 'Email is not valid',},*/
        },
        //display error alert on form submit
        invalidHandler: function(event, validator) {
            /*var alert = $('#_msg');
            alert.removeClass('m--hide').show();*/
            mApp.scrollTo($(validator.errorList[0].element), -200);
        },

        submitHandler: function(form) {
            form.submit();
        }

    });

    <?php
    if($row->id > 0){
        echo '$("#password").rules("remove");';
    }
    ?>
</script>