<style>
    .right-side .col-lg-12{
        padding-left: 0;
        padding-right: 0;
    }
    .right-side{
        border-left: 1px dashed #ddd;
    }
    .right-side .control-label{
        width: 100%;
        text-align: left !important;
    }
</style>
<?php
$params = json_encode($row->icon);
?>
<form id="pages" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
    $form_buttons = ['save', 'back'];
    include __DIR__ . "/../includes/module_header.php"; ?>
    <!--begin::Form-->
        <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id?>">
        <div class="m-portlet__body p-0">

            <div class="row m-0">
                <div class="col-md-9">

                    <div class="form-group m-form__group row">

                        <label class="col-sm-2 control-label required">
                            <?php echo __('Title');?>:
                        </label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                                            <input type="checkbox" value="1" name="show_title" id="show_title" <?php echo _checkbox($row->show_title, 1);?>>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                                <input type="text" name="title" id="title" class="form-control m-input" placeholder="Title" value="<?php echo ($row->title);?>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">
                            <?php echo __('Friendly Url');?>:
                        </label>
                        <div class="col-lg-10">

                            <div class="input-group m-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><?php echo site_url();?></span>
                                </div>
                                <input type="text" name="friendly_url" id="friendly_url" class="form-control" placeholder="Friendly Url" value="<?php echo ($row->friendly_url);?>" />
                                <!--<div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon1">/</span>
                                </div>-->
                                <?php if($row->id > 0) { ?>
                                <div class="input-group-append">
                                    <span class="input-group-text"><a target="_blank" class="" href="<?php echo site_url($row->friendly_url)?>"><i class="la la-desktop"></i></a></span>
                                </div>
                                <?php } ?>
                            </div>



                            <span class="m-form__help">Only alphanumerics and hyphen ( - ) are allowed</span>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">
                            <?php echo __('Tagline');?>:
                        </label>
                        <div class="col-lg-10">
                            <input type="text" name="tagline" id="tagline" class="form-control" placeholder="Tagline" value="<?php echo ($row->tagline);?>" />

                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-12 control-label text-center">
                            <?php echo __('Content');?>
                        </label>
                        <div class="col-lg-12">
                            <textarea name="content" id="content" placeholder="Content" class="editor form-control" cols="30" rows="10"><?php echo $row->content;?></textarea>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">
                            <?php echo __('Meta Title');?>:
                        </label>
                        <div class="col-lg-10">
                            <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Meta Title" value="<?php echo ($row->meta_title);?>" />

                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">
                            <?php echo __('Meta Keywords');?>:
                        </label>
                        <div class="col-lg-10">
                            <textarea name="meta_keywords" id="meta_keywords" class="form-control" placeholder="Meta Keywords" cols="30" rows="5"><?php echo $row->meta_keywords;?></textarea>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-sm-2 control-label">
                            <?php echo __('Meta Description');?>:
                        </label>
                        <div class="col-lg-10">
                            <textarea name="meta_description" id="meta_description" class="form-control" placeholder="Meta Description" cols="30" rows="5"><?php echo $row->meta_description;?></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 right-side">

                    <?php
                    if(user_do_action('status')){
                    ?>
                    <div class="form-group m-form__group row">
                        <label class="-col-sm-2 control-label required">
                            <?php echo __('Status');?>
                        </label>
                        <div class="col-lg-12">
                            <select name="status" id="status" class="m_selectpicker" style="width: 100%;">
                                <?php echo selectBox(get_enum_values('pages', 'status'), ($row->status));?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form-group m-form__group row">
                        <label class="-col-sm-2 control-label">
                            <?php echo __('Parent Page');?>
                        </label>
                        <div class="col-lg-12">
                            <select name="parent_id" id="parent_id" class="m-select2" style="width: 100%;">
                                <option value="0" <?php echo _selectbox($row->parent_id, 0); ?>> /</option>
                                <?php
                                $this->multilevels->type = 'select';
                                $this->multilevels->id_Column = 'id';
                                $this->multilevels->title_Column = 'title';
                                $this->multilevels->link_Column = 'friendly_url';
                                $this->multilevels->level_spacing = 6;
                                $this->multilevels->selected = $row->parent_id;
                                $this->multilevels->query = "SELECT id,title,parent_id,friendly_url FROM pages WHERE 1 ORDER BY title ASC";
                                echo $multiLevelComponents = $this->multilevels->build();
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <label class="-col-sm-2 control-label">
                            <?php echo __('Thumbnail');?>
                        </label>
                        <div class="col-lg-12">
                            <input disabled type="hidden" name="thumbnail--rm" value="<?php echo $row->thumbnail;?>">

                            <div class="custom-file">
                                <input type="file" name="thumbnail" id="thumbnail" class="form-control custom-file-input" placeholder="Thumbnail" value="<?php echo ($row->thumbnail);?>" />
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>

                        <?php
                        if (!empty($row->thumbnail)) {
                            $thumb_url = asset_url("front/{$this->table}/" . $row->thumbnail);
                            $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/thumbnail');
                            echo thumb_box($thumb_url, $delete_img_url, '', '12-');
                        }
                        ?>
                    </div>

                    <div class="form-group m-form__group row">
                        <label class="-col-sm-2 control-label">
                            <?php echo __('Template');?>
                        </label>
                        <div class="col-lg-12">
                            <select name="template" id="template" class="m-select2" style="width: 100%;">
                                <?php
                                $template['default'] = 'Default';
                                if(function_exists('get_theme_templates')){
                                    $template += get_theme_templates();
                                }
                                echo selectBox($template, $row->template);
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="-col-sm-2 control-label">
                            <?php echo __('Ordering');?>
                        </label>
                        <div class="col-lg-12">
                            <input type="text" name="ordering" id="ordering" class="form-control" placeholder="Ordering" value="<?php echo ($row->ordering);?>" />

                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="-col-sm-2 control-label">
                            <?php echo __('Icon');?>
                        </label>
                        <div class="col-lg-12">
                            <div class="input-group m-input-group">
                                <input type="text" name="params[icon]" id="icon" class="form-control icon-class" placeholder="Icon" value="<?php echo ($params->icon);?>" />
                                <div class="input-group-append">
                                    <a class="input-group-text" data-toggle="modal" role="button"  data-toggle="modal" data-target="#icon_modal">
                                        <span class="icon-show">Pick</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
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
    </form>
    <!--end::Form-->
<?php include __DIR__ . "/../includes/module_footer.php";?>
<?php include __DIR__ . "/../includes/icons.php";?>
<script>
    $(function () {
        $(document).ready(function () {
            var friendly = $('#friendly_url').val();
            $(document).on('input', '#title', function (e) {
                e.preventDefault();
                var title = friendly_URL($(this).val());
                if(friendly == '' && $('[name=id]').val() == ''){
                    $('#friendly_url').val(title);
                }
            });
        });
    });
    $("form#pages").validate({
        // define validation rules
        rules: {
            'title': {
                required: true,
            },
            'friendly_url': {
                remote: '<?php echo admin_url($this->_route . '/AJAX/validate/' . $row->id)?>',
            },
        },
        messages: {
            'title': {required: 'Title is required',},
            'friendly_url': {remote: 'Friendly URL is already exist',},
        },
        //display error alert on form submit
        invalidHandler: function (event, validator) {
            /*var alert = $('#_msg');
            alert.removeClass('m--hide').show();
            mApp.scrollTo(alert, -200);*/
            mUtil.scrollTo(validator.errorList[0].element, -200);
        },

        submitHandler: function (form) {
            form.submit();
        }

    });
</script>
