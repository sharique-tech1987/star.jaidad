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

                    <div classparent_id="form-group m-form__group row">
                        <label class="col-sm-12 control-label text-center">
                            <?php echo __('Content');?>
                        </label>
                        <div class="col-lg-12">
                            <textarea name="description" id="description" placeholder="Content" class="editor form-control" cols="30" rows="10"><?php echo $row->description;?></textarea>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <label class="col-lg-2 control-label"><?php echo __('Excerpt');?>:</label>
                        <div class="col-lg-10">
                            <textarea name="excerpt" id="excerpt" placeholder="<?php echo __('Excerpt');?>" class="-simple_editor form-control" cols="30" rows="5"><?php echo $row->excerpt;?></textarea>
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
                                <?php echo selectBox(get_enum_values('blog_posts', 'status'), ($row->status));?>
                            </select>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="form-group m-form__group row">
                        <label class="-col-sm-2 control-label">
                            <?php echo __('Categories');?>
                        </label>
                        <div class="col-lg-12">
                            <select name="category_id" id="category_id" class="form-control m-select2">
                                <option value="">Select Type</option>
                                <?php
                                $this->multilevels->type = 'select';
                                $this->multilevels->id_Column = 'id';
                                $this->multilevels->title_Column = 'type';
                                $this->multilevels->link_Column = 'module';
                                $this->multilevels->type = 'select';
                                $this->multilevels->level_spacing = 7;
                                //$this->multilevels->spacing_str = '-';
                                $this->multilevels->selected = $row->category_id;
                                $this->multilevels->query = "SELECT * FROM `blog_categories` WHERE 1 ORDER BY ordering ASC";
                                echo $multiLevelComponents = $this->multilevels->build();
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <label class="-col-sm-2 control-label">
                            <?php echo __('Tags');?>
                        </label>
                        <div class="col-lg-12">
                            <?php
                            $tag_ids = singleColArray("SELECT tag_id FROM blog_tags_rel WHERE blog_id='{$row->id}'", 'tag_id');;
                            ?>
                            <select name="tag_ids[]" id="tag_ids" class="form-control m_select2-tags" multiple>
                                <!--<select name="area_id" id="area_id" class="form-control m-select2" load-url="<?php /*echo site_url('property/ajax/city_area');*/?>">-->
                                <option value="">- Select -</option>
                                <?php //echo selectBox("SELECT id, type FROM  blog_tags", $tag_ids)?>
                                <?php echo selectBox("SELECT id, type FROM  blog_tags", $tag_ids)?>
                            </select>

                        </div>
                    </div>

                    <!-- Start Featured Image Section -->

                    <!-- End Featured Image Section -->

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
                            <?php echo __('Discussion');?>
                        </label>
                        <div class="col-lg-12">
                            <input type="checkbox" name="comment_status" id="comment_status"
                                <?php if(empty($row->id)){echo 'checked';}
                                      elseif($row->comment_status == 'Open') {echo 'checked';} ?> />
                            <label>Allow Comments</label>
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
