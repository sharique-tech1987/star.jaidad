<?php //get_header('member');?>
<?php get_header(get_option('header'));?>
<style>
    .m-btn--pill.lightbox{display: none;}
</style>
<div class="clearfix"></div>
<div class="dashboard">
    <div class="container-fluid">
        <div class="content-area">
            <div class="dashboard-content">
                <div class="dashboard-header clearfix">
                    <div class="row">
                        <!--                                <div class="col-md-6 col-sm-12 breadcrumb_member_cust"><h4>--><?php //echo ($become_agent ? 'Become an agent' : 'Edit My Profile')?><!--</h4></div>-->
                        <div class="col-md-6 col-sm-12 breadcrumb_member_cust">
                            <?php include "../include/breadcrumb.php"; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="column col-lg-12">
                        <div class="properties-box">
                            <div class="title"><h3><?php echo ($become_agent ? 'Become an agent' : 'Edit My Profile')?></h3></div>
                            <div class="inner-container">
                                <?php echo show_validation_errors();?>
                                <form class="" id="users" action="<?php echo site_url('login/registration');?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="redirect" value="<?php echo getVar('redirect');?>">
                                    <input type="hidden" name="become_agent" value="<?php echo $become_agent;?>">
<!--                                    <input type="hidden" name="edit" value="1">-->

                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label class="control-label required"><?php echo __('Agent Name');?></label>
                                            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name"  />
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="control-label"><?php echo __('Company');?></label>
                                            <input type="text" name="company" id="company" class="form-control" placeholder="Company" />
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label class="control-label required"><?php echo __('Email');?></label>
                                            <input type="text" name="username" id="username" class="form-control" placeholder="Email"  />
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="control-label "><?php echo __('Password');?></label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="" />

                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label class="control-label required"><?php echo __('Phone');?></label>
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" />
                                        </div>
                                    </div>

                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-6">
                                            <label class="control-label"><?php echo __('Address');?></label>
                                            <textarea name="address" id="address" class="form-control" placeholder="Address" cols="30" rows="3"></textarea>
                                        </div>
                                        <div class="col-lg-3">
                                            <label class="control-label required"><?php echo __('City');?></label><br>
                                            <select name="city" id="city" class="form-control m-select2" load-select="#area_ids">
                                                <option value="">- Select -</option>
                                                <?php echo selectBox("SELECT id, city AS _city FROM cities")?>
                                            </select>
                                        </div>
                                        <?php if($become_agent) { ?>
                                            <div class="col-lg-3">
                                                <label class="control-label required"><?php echo __("Deals in Area's");?></label><br>
                                                <select name="area_ids[]" id="area_ids" class="form-control m_select2-tags" multiple load-url="<?php echo site_url('property/ajax/city_area');?>">
                                                    <!--<select name="area_id" id="area_id" class="form-control m-select2" load-url="<?php /*echo site_url('property/ajax/city_area');*/?>">-->
                                                    <option value="">- Select -</option>
                                                    <?php echo selectBox("SELECT id, area FROM area")?>
                                                </select>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <div class="col-lg-5">
                                            <label class="control-label"><?php echo __('Photo');?></label><br>
                                            <input disabled type="hidden" name="photo--rm" >
                                            <label class="custom-file">
                                                <input type="file" name="photo" id="photo" class="form-control custom-file-input" placeholder="Photo"  />
                                                <!--<label class="custom-file-label" for="customFile">Choose file</label>-->
                                            </label>
                                        </div>
                                        <div class="col-lg-1"></div>

                                        <?php if($become_agent) { ?>
                                            <div class="col-lg-5 col-md-12">
                                                <label class="control-label"><?php echo __('Logo');?></label><br>
                                                <input disabled type="hidden" name="logo--rm" >
                                                <label class="custom-file">
                                                    <input type="file" name="logo" id="logo" class="form-control custom-file-input" placeholder="Logo"  />
                                                    <!--<label class="custom-file-label" for="customFile">Choose file</label>-->
                                                </label>
                                            </div>
                                            <div class="col-lg-1"></div>
                                        <?php } ?>
                                    </div>

                                    <?php if($become_agent) { ?>
                                        <div class="form-group m-form__group row">
                                            <div class="col-lg-12">
                                                <label class="control-label "><?php echo __('Description');?></label>
                                                <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
                                            </div>

                                        </div>

                                        <hr>
                                        <h4>Social Links</h4>
                                        <hr>
                                        <div class="form-group m-form__group row">
                                            <?php
                                            $inputs = ['Facebook', 'Twitter', 'Youtube', 'google-plus' => 'Google+', 'instagram' => 'Instagram', 'pinterest', 'Linkedin', 'Skype'];
                                            foreach ($inputs as $key => $title) {
                                                $name = (is_int($key) ? url_title($title, '_', true) : $key);
                                                ?>

                                                <div class="col-lg-4">
                                                    <label class="control-label"><?php echo $title;?>:</label>
                                                    <input type="text" name="social_network[<?php echo $name;?>]" class="form-control" value="<?php echo $values[$name]; ?>">
                                                </div>

                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <hr>
                                    <?php } ?>

                                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                                        <div class="m-form__actions m-form__actions--solid">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <button type="submit" class="theme-btn btn-style-four">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>




                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php get_footer();?>

<script>

    $(function () {

        function load_select(ele, select_ele){

            var url = select_ele.attr('load-url');
            var selected_val = select_ele.val();
            select_ele.html('<option value="">Loading...</option>');

            $.get(url, {id : ele.val(), selected: selected_val})
                .done(function (data) {
                    select_ele.html(data);
                })
                .fail(function () {
                    //var notify = $.notify('Record not found!', {type: 'danger', newest_on_top: true, allow_dismiss: true,});
                });
        }

        $(document).ready(function () {
            $(document).on('change', '[load-select]', function (e) {
                e.preventDefault();

                var _this = $(this);
                var next_select = $(_this.attr('load-select'));
                next_select.each(function (index, ele) {
                    load_select(_this, $(ele));
                });
            });



            // tagging support
            $('.m_select2-tags').select2({
                placeholder: "Add a tag",
                tags: true
            });
        });


        $("form#users").validate({
            rules: {
                'first_name': {
                    required: true,
                },
                'city': {
                    required: true,
                },
                'area_ids[]': {
                    required: true,
                },
                'phone': {
                    required: true,
                    phone: true,
                },
                'username': {
                    required: true,
                    email: true,
                }

            },
            messages: {
                'username': {/*required: 'Username is required', */remote: 'This username is already exist',},
                'phone': {/*required: 'Username is required', */remote: 'This phone is already exist',},
                /*'password': {required: 'Password is required',},
                'first_name': {required: 'First Name is required',},
                'email': {required: 'Email is required', email: 'Email is not valid',},*/
            },
            invalidHandler: function(event, validator) {
                validator.errorList[0].element.focus();
            },
            submitHandler: function(form) {
                form.submit();
            }

        });

    });
</script>
