<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_uploader
{

    var $header_title = 'Files';
    var $header_icon = '<i class="icon-upload2"></i>';

    private $table_headers = array();
    private  $inputs = array();

    var $allow_extensions = 'pdf,png,jpg,jpeg,bmp,gif';
    var $max_file_size = '100mb';
    var $thumb_size = array(150, 150);
    var $icon_path = '';

    private $data_rows = array();
    var $file_name = 'files';
    var $upload_path = '';



    public function __construct()
    {
        $this->icon_path = ('assets/admin/img/file_icons/');

        $this->table_headers = array(
            //'Check All' => array('attr' => array('width' => '40')),
            'Preview' => array('attr' => array('width' => '120')),
            'Name' => array('attr' => array('width' => '30%')),
            'Size' => array('title' => 'File Size'),
            'Type' => array('title' => 'File Type'),
            'Modified',
            'Actions',
        );
        $this->inputs = array(
            'id' => array('attr' => array('type' => 'hidden'), 'append_column' => 'Name', 'db_column' => 'id'),
            'filename' => array('attr' => array('type' => 'hidden'), 'append_column' => 'Name', 'db_column' => 'filename'),
            'title' => array('attr' => array('type' => 'text'), 'append_column' => 'Name', 'db_column' => 'title'),
            //'description' => array('attr' => array('type' => 'textarea'), 'append_column' => 'Name', 'db_column' => 'description'),
            //'status' => array('attr' => array('type' => 'select'), 'options' => array('Active' => 'Active', 'Inactive' => 'Inactive'), 'append_column' => 'Name', 'db_column' => 'status'),
        );

        $this->upload_path = admin_url(getUri(2) . '/file_upload/');
    }


    /**
     * @param $rows
     * @param $file_path
     * @param array $column_fields
     */
    function data($rows, $file_path, $column_fields = array()) {
        $db_fields = array(
            'id' => 'id',
            'filename' => 'filename',
            'title' => 'title',
            'created' => 'created',
            'modified' => 'modified',
        );

        foreach ($db_fields as $k => $v) {
            $db_fields[$k] = (!empty($column_fields[$k]) ? $column_fields[$k] : $v);
        }
        /*foreach ($column_fields as $k => $v) {
            if(!$db_fields[$k])
                $db_fields[$k] = $v;
        }*/

        $data = array(
            'rows' => $rows,
            'path' => $file_path,
            'columns' => $db_fields,
        );
        array_push($this->data_rows, $data);
    }

    function get_table_headers() {
        return $this->table_headers;
    }

    /**
     * @param $_input array 'desc' => array('attr' => array('type' => 'textarea', 'class' => 'form-control'), 'append_column' => 'Name'),
     */
    function add_input($_input) {

        if(!$_input[key($_input)]['append_column']){
            $_input[key($_input)]['append_column'] = 'Name';
        }
        $this->inputs[key($_input)] = $_input[key($_input)];

    }
    /**
     * @param $col array 'Title' => array('attr' => array('width' => '140')),
     * @param string $before
     */
    function add_header($col, $before = 'end') {
        $table_headers = array();
        if($before == 'first'){
            array_push($table_headers, $col);
        }
        foreach ($this->table_headers as $key => $header){
            $table_headers[$key] = $header;
            if($key == $before){
                $table_headers[key($col)] = $col[key($col)];
            }
        }
        if($before == 'end'){
            $table_headers[key($col)] = $col[key($col)];
        }

        $this->table_headers = $table_headers;
    }

    /**
     * @param $col_name
     */
    function delete_header($col_name) {
        unset($this->table_headers[$col_name]);
    }


    function show_uploader(){
        ob_start();
        ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title"><?php echo $this->header_icon . $this->header_title;?></h6>
            </div>
            <div class="-panel-body">
                <table class="file-upload table table-bordered table-checks table-striped">
                    <thead>
                    <tr>
                        <?php
                        if (count($this->table_headers) > 0) {
                            foreach ($this->table_headers as $title => $th) {
                                if(!is_array($th)) {$title = $th;}
                                if($title == 'Check All'){
                                    echo '<th width="80" class="text-center"><input type="checkbox" name="checkRow" id="checkRow" class="selectAll -styled"></th>';
                                }else
                                    echo '<th ' . array_attributes($th['attr']) . '>' . ((!empty($th['title']) && is_array($th)) ? $th['title'] : $title) . '</th>' . "\n";
                            }
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody class="file-body">
                    <?php
                    $_files = $this->data_rows[0]['rows'];
                    $_path = $this->data_rows[0]['path'];
                    $file_data_attr = $this->data_rows[0]['columns'];

                    if(count($_files) == 0){
                        $_files[] = null;
                    }

                    foreach ($_files as $f => $file_row) {
                        $ext = strtolower(end(explode('.', $file_row->{$file_data_attr['filename']})));
                        $icon_file = base_url($this->icon_path . $ext . '.png');
                        //$is_icon = is_file(ROOR . '/' . $icon_file);

                        $file = $file_row->{$file_data_attr['filename']};
                        $file_full_path = $_path . $file;
                        if(in_array($ext, explode('|', IMG_EXTS))) {
                            $icon_file = image_thumb($file_full_path, $this->thumb_size[0], $this->thumb_size[1]);
                        }

                        echo '<tr class="file-row" style="' . ($file_row->{$file_data_attr['id']} > 0 && count($_files) > 0 ? '' : 'display: none;') . '">';
                        foreach ($this->table_headers as $title => $th) {
                            if(!is_array($th)) {$title = $th;}
                            echo '<td>';
                            switch ($title){
                                case 'Check All':
                                    echo '<td align="center"><input type="checkbox" name="check[]" class="" value="' . $file_row->{$file_data_attr['id']} . '"/></td>' . "\n";
                                    break;
                                case 'Name':
                                    //<input type="text" name="' . $this->file_name . '_data[title][]"  class="form-control" value="' . $file_row->{$file_data_attr['title']} . '"/>
                                    echo '<input type="hidden" name="' . $this->file_name . '[]"  class="img-val" value="' . $file . '"/>' . "\n";
                                    break;
                                case 'Size':
                                    //echo '' . human_filesize(filesize(ROOT . '/' . $file_full_path)) . '';
                                    break;
                                case 'Type':
                                    echo '' . (function_exists('mime_content_type') ? mime_content_type(ROOT . '/' . $file_full_path) : '') . '';
                                    break;
                                case 'Created':
                                case 'Modified':
                                    echo '' . mysql2date($file_row->$file_data_attr['modified'], 'd F, Y H:i') . '';
                                    break;
                                case 'Actions':
                                    ?>
                                    <div class="table-controls">
                                        <a href="#" class="btn btn-link btn-icon btn-xs tip remove-file" data-original-title="Delete"><i class="icon-remove4"></i></a>
                                    </div>
                                    <?php
                                    break;
                                case 'Preview':
                                    ?>
                                    <div class="thumbnail thumbnail-boxed">
                                        <div class="thumb">
                                            <img class="img-thumb img-responsive" src="<?php echo $icon_file;?>" alt="<?php echo htmlentities($file_row->$file_data_attr['title']);?>">
                                            <div class="thumb-options">
                                                <a href="<?php echo base_url($_path . $file_row->{$file_data_attr['filename']});?>" class="btn btn-icon btn-success lightbox"><i class="icon-eye2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    break;
                                default:

                                    break;
                            }
                            //echo '<pre>';print_r($this->inputs);echo '</pre>';
                            foreach ($this->inputs as $inp_k => $input) {
                                if($input['append_column'] != $title) continue;

                                $field_value = ($file_row->{$input['db_column']} ? $file_row->{$input['db_column']} : '');

                                $clone = $input['attr'];
                                unset($clone['name'], $clone['class'], $clone['append_column']);
                                $attr = array_attributes($clone);

                                echo '<div class="">';
                                if(!in_array($input['attr']['type'], array('hidden', 'value'))){
                                    echo '<label>'.ucwords(str_replace(array('-', '_'), ' ', (!empty($input['label']) ? $input['label'] : $inp_k))).'</label>';
                                }
                                switch ($input['attr']['type']){
                                    case 'value':
                                        echo $file_row->{strtolower($title)};
                                        break;
                                    case 'select':
                                        echo '<select name="' . $this->file_name . '_data[' . $inp_k . '][]" id="'.$inp_k.'" data-field="'.$inp_k.'" class="form-control ' . $input['attr']['class'] . '" ' . $attr . '>'.selectBox($input['options'], $field_value).'</select>';
                                        break;
                                    case 'textarea':
                                        echo '<textarea name="' . $this->file_name . '_data[' . $inp_k . '][]" id="'.$inp_k.'" data-field="'.$inp_k.'" class="form-control ' . $input['attr']['class'] . '" ' . $attr . '>'.$field_value.'</textarea>';
                                        break;
                                    default:
                                        echo '<input name="' . $this->file_name . '_data[' . $inp_k . '][]" data-field="'.$inp_k.'" value="' . htmlentities($field_value) . '" class="form-control ' . $input['attr']['class'] . '"  placeholder="' . $inp_k . '" ' . $attr . '>';
                                        break;
                                }
                                echo '</div>';
                            }
                            echo '</td>';
                        }
                        echo '</tr>';
                        ?>
                        <?php
                    }
                    ?></tbody>
                </table>
                <div class="clearfix"></div>
                <p>&nbsp;</p>

                <div class="">
                    <div class="images-uploader">Your browser doesn't support native upload.</div>
                </div>
            </div>
        </div>
        <script>

            var image_block_row = null;
            $(document).ready(function () {
                image_block_row = $('.file-body >tr:eq(0)').clone(true).css('display', 'table-row');
                console.log(image_block_row);
            });
            $(".images-uploader").pluploadQueue({
                runtimes: 'html5,html4',
                url: '<?php echo $this->upload_path;?>',
                max_file_size: '<?php echo $this->max_file_size;?>',
                unique_names: true,
                filters: [
                    {title: "Files", extensions: '<?php echo $this->allow_extensions;?>'}
                ],
                //resize : {width : 320, height : 240, quality : 90},
                init: {
                    FilesAdded: function (up, files) {
                        up.start();
                        console.log('FilesAdded');
                    },
                    UploadComplete: function (up, files) {
                        // Called when all files are either uploaded or failed
                        console.log('UploadComplete');
                        //$('.caption .options input.styled').uniform({ radioClass: 'choice', selectAutoWidth: false });

                    },
                    FileUploaded: function (up, file, info) {
                        // Called when file has finished uploading
                        var data = $.parseJSON(info.response);

                        var image_block = image_block_row.clone(true);
                        console.log(image_block);
                        console.log(data.result);
                        $('input,textarea,select', image_block).val('');

                        $('img.img-thumb', image_block).attr('src', data.result.thumb_url);
                        $('img.img-thumb', image_block).attr('alt', data.result.filename);

                        $('.img-val,[data-field="filename"]', image_block).prop('value', data.result.filename);
                        $('.file-title,[data-field="title"]', image_block).prop('value', data.result.title);
                        $('.lightbox', image_block).attr('href', data.result.image_url).removeAttr('p_id');
                        $('.remove-img', image_block).attr('href', '#').removeAttr('p_id');

                        $('input[type=radio]', image_block).attr('value', data.result.filename).removeAttr('checked')/*.addClass('styled')*/;
                        $('.file-body').append(image_block);


                    }
                }
            });


            $(document).on('click', '.remove-file', function (e) {
                e.preventDefault();
                var ele = $(this);
                console.log(ele);
                ele.parents('tr').remove();
            });
        </script>
        <?php
        return ob_get_clean();

    }

}
