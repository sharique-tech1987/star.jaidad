<?php
/**
 * Adnan Bashir
 * E: developer.adnan@gmail.com
 * P: +92-332-3103324
 * S: developer.adnan
 */
?>
<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post"
      enctype="multipart/form-data"
      id="short_news" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>

    <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id; ?>">
    <div class="m-portlet__body">

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('News'); ?>:</label>
            <div class="col-lg-10">
                <textarea name="news" id="news" class="form-control m_maxlength" maxlength="300" placeholder="<?php echo __('News'); ?>" cols="30" rows="5"><?php echo $row->news; ?></textarea>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Link'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="link" id="link" class="form-control" placeholder="<?php echo __('Link'); ?>"
                       value="<?php echo htmlentities($row->link); ?>"/>
            </div>
        </div>

    </div>

    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <input type="submit" class="btn btn-success m-btn m-btn--icon m-btn--pill m-btn--air"
                           value="<?php echo __('Submit'); ?>">
                    <input type="button" next-url="<?php echo admin_url($this->_route . '/form'); ?>"
                           class="btn btn-accent m-btn m-btn--icon m-btn--pill m-btn--air"
                           value="<?php echo __('Submit & New'); ?>">
                    <button type="reset"
                            class="btn btn-metal m-btn m-btn--icon m-btn--pill m-btn--air"><?php echo __('Cancel'); ?></button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--end::Form-->
<?php include __DIR__ . "/../includes/module_footer.php"; ?>
<script>

    $("form#short_news").validate({
        // define validation rules
        rules: {
            'news': {
                required: true,
            },
        },
        /*messages: {
        'news' : {required: 'News is required',},    },*/
        //display error alert on form submit
        invalidHandler: function (event, validator) {
            validator.errorList[0].element.focus();

            /*var alert = $('#_msg');
            alert.removeClass('m--hide').show();
            mUtil.scrollTo(alert, -200);*/
            //mUtil.scrollTo(validator.errorList[0].element, -200);
        },

        submitHandler: function (form) {
            form.submit();
        }

    });
</script>