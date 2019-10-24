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
      id="area_reviews" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>

    <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id; ?>">
    <div class="m-portlet__body">

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Area'); ?>:</label>
            <div class="col-lg-6">
                <select name="area_id" id="area_id" class="form-control m-select2">
                    <option value="">Select Area</option>
                    <?php echo selectBox("SELECT id, `area` FROM `area`", ($row->area_id)); ?>
                </select>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Member'); ?>:</label>
            <div class="col-lg-6">
                <select name="user_id" id="user_id" class="form-control m-select2">
                    <option value="">Select Member</option>
                    <?php echo selectBox("SELECT id, CONCAT_WS(' ', first_name, last_name) AS full_name FROM users", ($row->user_id)); ?>
                </select>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Comment'); ?>:</label>
            <div class="col-lg-10">
                <textarea name="comment" id="comment" class="form-control" placeholder="<?php echo __('Comment'); ?>" cols="30" rows="5"><?php echo $row->comment; ?></textarea>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Name'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo __('Name'); ?>"
                       value="<?php echo htmlentities($row->name); ?>"/>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label"><?php echo __('Email'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="email" id="email" class="form-control" placeholder="<?php echo __('Email'); ?>"
                       value="<?php echo htmlentities($row->email); ?>"/>
            </div>
        </div>

        <div class="form-group m-form__group row">
            <label class="col-lg-2 control-label required"><?php echo __('Score'); ?>:</label>
            <div class="col-lg-6">
                <input type="text" name="score" id="score" class="form-control" placeholder="<?php echo __('Score'); ?>"
                       value="<?php echo htmlentities($row->score); ?>"/>
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

    $("form#area_reviews").validate({
        // define validation rules
        rules: {
            'area_id': {
                required: true,
            },
            'user_id': {
                required: true,
            },
            'comment': {
                required: true,
            },
            'score': {
                required: true, digits: true,
            },
        },
        /*messages: {
        'area_id' : {required: 'Area is required',},'user_id' : {required: 'Member is required',},'comment' : {required: 'Comment is required',},'score' : {required: 'Score is required',integer: 'Score is valid integer',},    },*/
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