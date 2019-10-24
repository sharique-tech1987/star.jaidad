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

    <!--begin::Form-->
    <div class="row">
        <div class="col-lg-9">
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" id="email_templates" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
                <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

                    <div class="m-portlet__head sticky-head">
                        <div class="m-portlet__head-progress"><!-- here can place a progress bar--></div>
                        <div class="m-portlet__head-wrapper">

                            <div class="m-portlet__head-tools">
                                <?php
                                $ci =& get_instance();
                                $ci->load->library('form_btn');

                                $form_buttons = ['save', 'back'];
                                echo $ci->form_btn->buttons($form_buttons);
                                ?>
                            </div>
                            <?php echo portlet_actions();?>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">

                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label required">
                                <?php echo __('Name');?>:
                            </label>
                            <div class="col-lg-10">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="<?php echo ($row->name);?>" />
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label required">
                                <?php echo __('Subject');?>:
                            </label>
                            <div class="col-lg-10">
                                <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" value="<?php echo ($row->subject);?>" />
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-12 control-label text-center">
                                <?php echo __('Message');?>
                            </label>
                            <div class="col-lg-12">
                                <textarea name="message" id="message" placeholder="Message" class="editor form-control" cols="30" rows="20"><?php echo $row->message;?></textarea>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label required">
                                <?php echo __('From Name');?>:
                            </label>
                            <div class="col-lg-8">
                                <?php $row->from_name = (!empty($row->from_name) ? $row->from_name : get_option('site_title')); ?>
                                <input type="text" name="from_name" id="from_name" class="form-control" placeholder="From Name" value="<?php echo ($row->from_name);?>" />
                                <!--<span class="m-form__help"><?php /*echo get_option('site_title')*/?></span>-->
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-sm-2 control-label required">
                                <?php echo __('From Email');?>:
                            </label>
                            <div class="col-lg-8">
                                <?php $row->from_email = (!empty($row->from_email) ? $row->from_email : get_option('contact_email')); ?>
                                <input type="text" data-inputmask="'alias': 'email'" name="from_email" id="from_email" class="form-control" placeholder="From Email" value="<?php echo ($row->from_email);?>" />
                                <!--<span class="m-form__help"><?php /*echo get_option('contact_email');*/?></span>-->
                            </div>
                        </div>

                        <!--<div class="form-group m-form__group row">
                    <label class="col-sm-2 control-label">
                        <?php /*echo __('Sms Status');*/?>
                    </label>
                    <div class="col-lg-6">
                        <select name="sms_status" id="sms_status" class="form-control m_selectpicker">
                            <option value="">Select Sms Status</option>
                            <?php /*echo selectBox(get_enum_values('email_templates', 'sms_status'), ($row->sms_status));*/?>
                        </select>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-sm-2 control-label">
                        <?php /*echo __('Sms Message');*/?>
                    </label>
                    <div class="col-lg-10">
                        <textarea name="sms_message" id="sms_message" class="form-control m_maxlength" maxlength="256" placeholder="Sms Message" cols="30" rows="10"><?php /*echo $row->sms_message;*/?></textarea>
                    </div>
                </div>-->

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
            </form>
        </div>
        <div class="col-lg-3">

            <?php
            $_tags = array(
                'Basic Tags' => array(
                    'config' => array('title' => 'Basic Tags', 'icon' => 'la la-home'),

                    'site_title' => 'site_title',
                    'phone_number' => 'phone_number',
                    'contact_email' => 'contact_email',
                    'copyright' => 'copyright',
                    'site_url' => 'site_url',
                    'base_url' => 'base_url',
                    'admin_url' => 'admin_url',
                ),
                'Member Tags' => array(
                    'config' => array('title' => 'Member Tags', 'icon' => 'la la-user'),

                    'id' => 'id',
                    'username' => 'username',
                    'password' => 'password (Use only signup)',
                    'reset_link' => 'reset_link (Use only Password Reset)',
                    'first_name' => 'first_name',
                    'last_name' => 'last_name',
                    //'photo' => 'photo',
                    //'cnic' => 'cnic',
                    'email' => 'email',
                    'phone' => 'phone',
                    'address' => 'address',
                    //'city' => 'city',
                    'country' => 'country',
                    //'zip_code' => 'zip_code',
                    'created' => 'created',
                    'status' => 'status',

                ),

            );
            ?>

            <div class="m-accordion m-accordion--bordered" id="m_accordion_2" role="tablist">
                <?php
                $t = 0;
                foreach ($_tags as $tags) {
                    $t++;
                    $config = $tags['config'];
                    unset($tags['config']);
                    ?>
                    <div class="m-accordion__item">
                        <div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_2_item_<?php echo $t;?>_head" data-toggle="collapse" href="#m_accordion_2_item_<?php echo $t;?>_body" aria-expanded="false">
                            <span class="m-accordion__item-icon"><i class="<?php echo $config['icon'];?>"></i></span>
                            <span class="m-accordion__item-title"><?php echo $config['title'];?></span>
                            <span class="m-accordion__item-mode"></span>
                        </div>
                        <div class="m-accordion__item-body collapse <?php ($t == 1 ? 'collapse show' : 'collapse');?>" id="m_accordion_2_item_<?php echo $t;?>_body" role="tabpanel" aria-labelledby="m_accordion_2_item_<?php echo $t;?>_head" data-parent="#m_accordion_2">
                            <div class="m-accordion__item-content">
                                <?php
                                foreach($tags as $tag => $tag_value){
                                    echo '<p class="field-'.$tag.'"><a href="javascript: void(0);" onclick="tinymce.activeEditor.execCommand(\'mceInsertContent\', false, \'['.$tag.']\');">['.$tag_value.']</a></p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
<!--end::Portlet-->
</div>
<script>
    $("form#email_templates").validate({
        // define validation rules
        rules: {
            'name': {
                required: true,
                remote: '<?php echo admin_url($this->_route . '/AJAX/validate/' . $row->id)?>',
            },
            'from_name': {
                required: true,
            },
            'from_email': {
                required: true,
                email: true,
            },
            'subject': {
                required: true,
            },
        },
        messages: {
            'name': {required: 'Name is required', remote: 'This Name is already exist',},
            'from_name': {required: 'From Name is required',},
            'from_email': {required: 'From Email is required', email: 'From Email is not valid',},
            'subject': {required: 'Subject is required',},
        },
        //display error alert on form submit
        invalidHandler: function(event, validator) {
            validator.errorList[0].element.focus();
            /*var alert = $('#_msg');
            alert.removeClass('m--hide').show();
            mUtil.scrollTo(alert, -200);*/
            //mUtil.scrollTo(validator.errorList[0].element, -200);
        },

        submitHandler: function(form) {
            form.submit();
        }

    });
</script>