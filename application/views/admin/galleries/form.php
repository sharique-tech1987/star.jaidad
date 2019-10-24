<!--begin::Form-->
<form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" method="post" enctype="multipart/form-data" id="galleries" action="<?php echo admin_url($this->_route . (!$row->id ? '/add' : '/update/' . $row->id)); ?>">
    <?php
        $form_buttons = ['save', 'back'];
        include __DIR__ . "/../includes/module_header.php"; ?>

        <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $row->id;?>">
        <div class="m-portlet__body">

            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required">
                    <?php echo __('Title');?>:</label>
                <div class="col-lg-6">
                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="<?php echo ($row->title);?>" />
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label">
                    <?php echo __('Description');?>:</label>
                <div class="col-lg-10">
                    <textarea name="description" id="description" placeholder="Description" class="editor form-control" cols="30" rows="10">
                        <?php echo $row->description;?>
                    </textarea>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label">
                    <?php echo __('Cover Image');?>:</label>
                <div class="col-lg-4">
                    <input disabled type="hidden" name="cover_image--rm" value="<?php echo $row->cover_image;?>">
                    <label class="custom-file">
                        <input type="file" name="cover_image" id="cover_image" class="form-control custom-file-input" placeholder="Cover Image" value="<?php echo ($row->cover_image);?>" />
                        <span class="custom-file-label"></span>
                    </label>
                </div>
                <?php
                if (!empty($row->cover_image)) {
                    $thumb_url = asset_url("front/{$this->table}/" . $row->cover_image);
                    $delete_img_url = admin_url($this->_route . '/AJAX/delete_img/' . $row->id . '/cover_image');
                    echo thumb_box($thumb_url, $delete_img_url);
                }
                ?>
            </div>
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required"><?php echo __('Date');?>:</label>
                <div class="col-lg-2">
                    <input type="text" readonly name="date" id="date" class="form-control m_datepicker" placeholder="Date" value="<?php echo ($row->date);?>" />
                </div>
            </div>
            <!--<div class="form-group m-form__group row">
                <label class="col-sm-2 control-label"><?php /*echo __('Customer');*/?>:</label>
                <div class="col-lg-6">
                    <select name="customer_id" id="customer_id" class="form-control m-select2">
                        <option value="">Select Customer</option>
                        <?php /*echo selectBox("SELECT id, CONCAT(first_name, ' ', IFNULL(last_name, '')) as full_name FROM users WHERE 1", ($row->customer_id));*/?>
                    </select>
                </div>
            </div>-->
            <div class="form-group m-form__group row">
                <label class="col-sm-2 control-label required">
                    <?php echo __('Parent Gallery');?>:</label>
                <div class="col-lg-6">
                    <select name="parent_id" id="parent_id" class="form-control m-select2">
                        <option value="0" <?php echo _selectbox($row->parent_id, 0); ?>> /</option>
                        <?php
                        $_where = '';
                        if($row->id > 0){
                            $_where .= ' AND id!=' . $row->id;
                        }

                        $this->multilevels->type = 'select';
                        $this->multilevels->id_Column = 'id';
                        $this->multilevels->title_Column = 'title';
                        $this->multilevels->link_Column = 'title';
                        $this->multilevels->level_spacing = 6;
                        $this->multilevels->selected = $row->parent_id;
                        $this->multilevels->query = "SELECT id,title,parent_id FROM galleries WHERE 1 {$_where} ORDER BY id DESC";
                        echo $multi_options = $this->multilevels->build();
                        ?>
                    </select>
                </div>
            </div>


            <?php
            if (count($files) > 0){
                echo '<div class="form-group m-form__group row">';
                foreach ($files as $k => $file) {
                    $thumb_file = _img(file_icon(asset_dir("front/{$this->table}/{$file->file}"), true), 400, 400);
                    ?>
                        <div class="col-lg-3 img-row">
                            <div class="block">
                                <div class="thumbnail thumbnail-boxed">
                                    <div class="thumb">
                                        <img src="<?php echo $thumb_file;?>" alt=" <?php echo $file->title;?>" class="img-responsive">
                                        <div class="thumb-options">
                                                <span>
                                                <a rel="group" title="<?php echo $file->title;?>" href="<?php echo asset_url("front/{$this->table}/{$file->file}");?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill lightbox"><i class="flaticon-visible"></i></a>
                                                <a href="#" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" remove-el="parent.img-row" data-rm-name="files_remove[]" data-rm-value="<?php echo $file->id;?>"><i class="la la-trash"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="img-input-fields">
                                        <input type="hidden" class="form-control" name="files[]" value="<?php echo $file->file;?>">

                                        <input type="hidden" class="form-control rm-id" name="files_data[id][]" value="<?php echo $file->id;?>">
                                        <input type="hidden" disabled placeholder="ordering" class="form-control" name="files_data[ordering][]" value="<?php echo $file->ordering;?>">

                                        <label for="" class="badge badge-danger">Title:</label>
                                        <input type="text" placeholder="Title" class="form-control" name="files_data[title][]" value="<?php echo $file->title;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                }
                echo '</div>';
            }
            ?>


            <div class="form-group m-form__group row">
                <div class="col-sm-12">
                    <div class="m-dropzone dropzone m-dropzone--success" action="<?php echo admin_url($this->_route . '/file_upload');?>" id="m-dropzone">
                        <div class="m-dropzone__msg dz-message needsclick">
                            <h3 class="m-dropzone__msg-title">Drop files here or click to upload.</h3>
                            <span class="m-dropzone__msg-desc">Only "jpg|jpeg|gif|png|bmp" files extension's are allowed for upload</span>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                Dropzone.options.mDropzone = {
                    paramName: "file",
                    //maxFiles:10,
                    //maxFilesize: 10, // MB
                    addRemoveLinks: !0,
                    acceptedFiles: ".jpg,.jpeg,.gif,.png,.bmp,.pdf", /* Update: ./application/models/m_galleries.php  $config['allowed_types'] = 'gif|jpg|jpeg|png';*/
                    thumbnailWidth: 150,
                    thumbnailHeight: 150,
                    success: function(file, response) {
                        var json = JSON.parse(response);
                        console.log(json);
                        var previewEl = file.previewElement;

                        $('.dz-image img', previewEl).attr('src', json.result.thumb_url);
                        $('.dz-image', previewEl).append('<input type="hidden" name="files[]" value="' + json.result.filename + '">');
                        $('.dz-filename', previewEl).append('<input type="text" placeholder="title" class="form-control" name="files_data[title][]" value="' + json.result.title + '">');
                    },
                    accept: function(e, o) {
                        "justinbieber.jpg" == e.name ? o("Naha, you don't.") : o()
                    }
                }
            </script>

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
    <script>
        $("form#galleries").validate({
            // define validation rules
            rules: {
                'title': {
                    required: true,
                },
                'date': {
                    required: true,
                },
                'parent_id': {
                    required: true,
                },
            },
            /*messages: {
            'title' : {required: 'Title is required',},'date' : {required: 'Date is required',},'parent_id' : {required: 'Parent ID is required',},    },*/
            //display error alert on form submit
            invalidHandler: function(event, validator) {
                /*var alert = $('#_msg');
                alert.removeClass('m--hide').show();
                mUtil.scrollTo(alert, -200);*/
                mUtil.scrollTo(validator.errorList[0].element, -200);
            },

            submitHandler: function(form) {
                form.submit();
            }

        });
    </script>