<form id="validate" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" action="<?= admin_url($this->_route . '/import'); ?>" method="post"
      enctype="multipart/form-data">
    <?php
    $form_buttons = ['new', 'import', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>
    <div class="m-portlet__body p-1">
        <input type="hidden" name="import" value="1">
        <div class="form-group m-form__group row">
            <label class="col-sm-2 control-label required">File Type:</label>
            <div class="col-sm-4">
                <select name="type" id="type" class="form-control selectpicker">
                    <option value="csv">CSV</option>
                    <!--<option value="xml">XML</option>-->
                </select>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label class="col-sm-2 control-label required">File: </label>
            <div class="col-sm-4">
                <label class="custom-file">
                    <input disabled type="hidden" name="file--rm" value="<?php echo $row->file;?>">
                    <input type="file" name="file" id="file" class="form-control custom-file-input" placeholder="Filevalue="<?php echo ($row->file);?>" />
                    <label class="custom-file-label" for="file">Choose file</label>
                </label>
            </div>
        </div>
        <?php if ($total_records) { ?>
            <div class="form-group m-form__group row">
                <div class="col-sm-12">
                    <p align="center" style="color: red; font-weight: bold;"><?php echo number_format($total_records); ?> record's import.</p>
                </div>
            </div>
        <? } ?>
    </div>
</form>
<?php include __DIR__ . "/../includes/module_footer.php"; ?>
