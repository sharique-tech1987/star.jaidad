<?php include __DIR__ . "/../admin/includes/head.php";?>
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<div class="container">
    <p>&nbsp;</p>
    <?php echo show_validation_errors();?>
    <form method="get" action="<?php echo site_url('parse/property');?>" class="form-signin" enctype="multipart/form-data">
        <div class="text-center">
            <img class="mb-4 " src="<?php echo _img(ADMIN_ASSETS_DIR . 'img/' . get_option('logo'), 0,100);?>" alt="Star">
        </div>
        <!--<h1 class="h3 mb-3 text-center font-weight-normal">MOG</h1>-->
        <div class="form-group">
            <select name="type" id="type" class="form-control">
                <?php
                $OP = ['URL', 'Location'];
                foreach ($OP as $item) {
                    echo '<option value="'.$item.'">'.$item.'</option>';
                }
                ?>
            </select>
        </div>
        <div class="input-options">
            <div class="form-group URL-opt row">
                <div class="col-md-9">
                    <label for="">URL:</label>
                    <input type="text" class="form-control " name="url" placeholder="Enter URL" value="<?php echo $url; ?>">
                </div>
                <div class="col-md-3">
                    <label for="">Zameen.com Images:</label>
                    <div>
                        <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                            <label>
                                <input type="checkbox" name="images" checked id="images" value="1" <?php echo _checkbox($row->images, 1);?>/>
                                <span></span>
                            </label>
                        </span>
                    </div>
                </div>
                <!--<input type="file" class="form-control File-input" disabled style="display: none;" name="file" placeholder="Text file" value="">-->

            </div>

            <div class="Location-opt">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="exampleInputEmail1">City:</label>
                        <select name="city_id" id="city_id" class="form-control m-select2">
                            <?php echo selectBox("SELECT id, city AS _city FROM cities", getVar('city'));?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="exampleInputEmail1">Area:</label>
                        <select name="area_id" id="area" class="form-control m-select2-ajax m-select2" data-url="<?php echo site_url('property/ajax/search_area');?>" data-data_ele="#city_id">
                            <option value="">Select Area</option>
                            <?php echo selectBox("SELECT id, area FROM area WHERE city_id='{$row->city_id}' AND id='{$row->area_id}'", ($row->area_id));?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3 offset-md-2">
                        <label for="">Limit:</label>
                        <input type="text" class="form-control " name="limit" placeholder="Limit" value="20">
                    </div>
                    <!--<div class="col-md-3">
                        <label for="">Start:</label>
                        <input type="text" class="form-control " name="start" placeholder="Start" value="0">
                    </div>-->
                    <div class="col-md-2">
                        <label for="">Update Properties:</label>
                        <div>
                            <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                                <label>
                                    <input type="checkbox" name="update" id="update" value="1" <?php echo _checkbox($row->update, 1);?>/>
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="">Zameen.com Images:</label>
                        <div>
                            <span class="m-switch m-switch--outline m-switch--icon m-switch--success">
                                <label>
                                    <input type="checkbox" name="images" checked id="images" value="1" <?php echo _checkbox($row->images, 1);?>/>
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-3 offset-md-3">
                <button type="submit" class="btn btn-success btn-block">Submit</button>
            </div>
            <div class="col-md-3">
                <a href="<?php echo site_url('parse/fetch_areas');?>" class="btn btn-warning btn-block">Fetch Area's</a>
            </div>
        </div>
    </form>
    <script>
        $(function () {
            $(document).ready(function () {
                $(document).on('change', '#type', function (e) {
                    e.preventDefault();
                    var val = $(this).val();

                    $('.input-options [class*="-opt"]').hide(0).find('input,select,textarea').attr('disabled', true);
                    $('.input-options').find('.'+val+'-opt').show(0).find('input,select,textarea').show(0).attr('disabled', false);

                    if (val == 'File') {
                        $('.form-signin').attr('method', 'post');
                    } else {
                        $('.form-signin').attr('method', 'get');
                    }
                });
                $('#type').trigger('change')
            });
        });
    </script>
</div>
</body>
<?php include __DIR__ . "/../admin/includes/footer.php";?>


