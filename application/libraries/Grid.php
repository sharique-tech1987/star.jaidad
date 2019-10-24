<?php
/**
 * Developed by Adnan Bashir.
 * Email: pisces_adnan@hotmail.com
 * Autour: Adnan Bashir
 * Date: 12/10/17
 * Time: 1:58 PM
 */

class Grid
{

    var $title = '';
    var $query = '';
    var $url = '';

    var $start = 0;
    var $limit = 25;
    var $page = 1;

    var $id_field = 'id';

    var $module_uri = 2;

    var $form_buttons = array();
    var $grid_buttons = array();

    var $is_front = FALSE;
    var $selectAllCheckbox = TRUE;
    var $serial = FALSE;
    var $actionColumn = TRUE;
    var $sorting = TRUE;
    var $search_box = TRUE;
    var $search_fields_html = array();
    var $advance_search_html = '';
    var $show_validation_errors = false;

    var $filterable = TRUE;
    var $filter_options = array(
        '%-%' => 'Contain',
        '%!-%' => 'Not Contain',
        '-%' => 'Start With',
        '%-' => 'End With',
        '=' => 'Equal',
        '!=' => 'Not Equal',
        '>' => 'Greater Then',
        '>=' => 'Greater Then Equal',
        '<' => 'Less Then',
        '=<' => 'Less Then Equal',
    );

    var $show_paging_bar = TRUE;
    var $record_not_found = 'Record found.';

    var $show_entries = array(25, 50, 75, 100, ['all' => 'All']);

    var $order_by = '';// id DESC
    var $sort = '';
    var $order = 'DESC';
    var $group_by = '';
    var $having = '';


    var $grid_start = '<div class="widget">';
    var $grid_end = '</div>';

    var $dt_columns = array();
    var $db_fields = array();
    var $custom_func = array();

    var $rows = array();
    var $total_rows = 0;
    var $total_pages;

    var $status_column_data;

    var $form_method = 'GET';
    var $db_error;
    var $display_records = 'Displaying {start} - {show_limit} of {total} records';

    var $escape_tags = ['title', 'field', 'filterable', 'sortable', 'selector', 'search_input', 'overflow', 'input_options'];
    var $meta_column = ['search' => 'search', 'filter' => 'filter', 'sort' => 'sort', 'dir' => 'dir', 'page' => 'page', 'limit' => 'limit'];

    var $css_classes = [
        'checkbox' => 'm-checkbox--brand',
        'filter' => 'la la-filter',
        'filter_select' => 'm_selectpicker',
        'sort_arrow_up' => 'la la-arrow-up',
        'sort_arrow_down' => 'la la-arrow-down',
    ];
    private $show_columns = [];
    var $image_size = '60x60';
    var $alt_image = IMG_NA;


    function __construct() {

        $ci =& get_instance();
        if(empty($this->url)){
            $this->url = admin_url(getUri(2));
        }
        if(empty($this->sort)){
            $this->sort = $this->id_field;
        }

        //$ci->load->library('actions_btn');

        if(empty($this->status_column_data)){
            //$this->actions_btn->status_column_data = get_enum_values(getUri(2), 'status');
        }

    }


    function init($query = null, $offset = 0, $order_by = ''){

        if($this->is_front){
            $this->selectAllCheckbox = false;
            $this->search_box = false;
            $this->actionColumn = false;
        }

        $ci =& get_instance();

        if($query === null){ $query = $this->query;}

        if($this->selectAllCheckbox) {
            $_FIELD = [
                'title' => __('#'),
                'width' => '40',
                'align' => 'center',
                'sortable' => false,

            ];
            $this->dt_columns['ids'] = $_FIELD;
        }
        if($this->serial) {
            $_FIELD = [
                'title' => __('S.No'),
                'width' => '40',
                'sortable' => false,
                'filterable' => false,
                'search_input' => '',
                'align' => 'center',
                'th_align' => 'center',

            ];
            $this->dt_columns['serial'] = $_FIELD;
        }

        if (strpos($query, 'SQL_CALC_FOUND_ROWS') !== 7) {
            $query = "SELECT SQL_CALC_FOUND_ROWS " . substr($query, 6);
        }

        /** -------- User input limit */
        if(!in_array($this->limit, $this->show_entries)) {
            array_unshift($this->show_entries, $this->limit);
        }
        /** -------- GET data From Address */

        $page = getVar($this->meta_column['page']);
        $this->page = ($page > 0 ? $page : 1);

        $limit = getVar($this->meta_column['limit']);
        $this->limit = (!empty($limit) ? $limit : $this->limit);

        $sort = getVar($this->meta_column['sort']);
        $this->sort = (!empty($sort) ? $sort : $this->sort);

        $dir = getVar($this->meta_column['dir']);
        $this->order = (!empty($dir) ? $dir : $this->order);


        /** -------- ORDER BY */

        if(!empty($order_by)){
            $this->order_by = " $order_by";
        }else{
            $this->order_by = " {$this->sort} {$this->order}";
        }
        if(!empty($sort)){
            $this->order_by = " {$this->sort} {$this->order}";
        }

        if(!empty($this->group_by)){
            $query .= " GROUP BY {$this->group_by}";
        }


        $query .= " ORDER BY {$this->order_by}";

        if ($this->having != '') {
            $query .= $this->having;
        }

        /** ------- Pagination */
        if($offset == 0 && $this->page > 1){
            $this->start = (($this->page - 1) * $this->limit);
        }

        /** -------- LIMIT */
        if (strtolower($this->limit) != 'all') {
            $query .= " LIMIT {$this->start}, {$this->limit}";
        }

        $this->query = $query;
        /** ----- Final Query */

        $result = $ci->db->query($query);
        if(!$result){
            $data['status'] = false;
            $this->db_error = $ci->db->error()['message'];
        }
        //echo '<pre>';print_r($ci->db->last_query());echo '</pre>';
        $this->total_rows = $ci->db->found_rows();
        $this->total_pages = ceil($this->total_rows / $this->limit);

        /** list Fields */
        $list_fields = $result->list_fields();
        foreach ($list_fields as $field) {
            array_push($this->db_fields, $field);
            $this->dt_columns[$field] = $field;
        }


        $this->rows = [];
        foreach ($result->result_array() as $i => $row) {
            $_row = new stdClass();
            if($this->selectAllCheckbox) $_row->ids = $row['id'];
            if($this->serial) $_row->serial = ($this->start + ($i + 1));

            foreach ($row as $field => $value) {
                if (array_key_exists($field, $this->custom_func)) {
                    $value = call_user_func($this->custom_func[$field], $value, $row, $field, $this);
                    $_row->{$field} = $value;
                } else {
                    $_row->{$field} = $value;
                }
            }

            if($this->actionColumn) $_row->grid_actions = $ci->actions_btn->grid_buttons($row, $this->id_field, $this->grid_buttons);
            array_push($this->rows, $_row);
        }

        if($this->actionColumn) {
            $_FIELD = [
                'title' => __('Actions'),
                'sortable' => false,
                'align' => 'center',
                'width' => '120',
                'th_align' => 'center',
                'filterable' => false,
                'overflow' => 'initial',
            ];
            $this->dt_columns['grid_actions'] = $_FIELD;
        }

        return $this->query;
    }


    public function data()
    {
        if($this->total_rows){
            $JSON['status'] = true;
            //$JSON['data'] = $this->rows;
            $JSON['meta'] = [
                'total' => $this->total_rows,
                'page' => ($this->page),
                'pages' => $this->total_pages,
                'perpage' => $this->limit,
                'sort' => $this->order,
                'field' => $this->order_by,
            ];

        } else {
            $JSON['status'] = false;
            $JSON['message'] = $this->db_error;
        }

        return $JSON;
    }



    function dt_column($column){

        $field = key($column);
        if(in_array($field, $this->db_fields)){
            foreach ($this->db_fields as $field) {
                if(isset($column[$field])){
                    $this->dt_columns[$field] = $column[$field];
                }
            }
        }else if(isset($this->dt_columns[$field])){
            $this->dt_columns[$field] = array_merge($this->dt_columns[$field],$column[$field]);
        }
    }


    private function get_columns(){

        $JSON = [];

        foreach ($this->dt_columns as $column => $attrs) {
            $_FIELD = [];
            $_FIELD['field'] = $column;
            $_FIELD['title'] = __(ucwords(str_replace('_', ' ', $column)));
            $_FIELD['sortable'] = $this->sorting;
            $_FIELD['filterable'] = $this->filterable;

            foreach ($attrs as $attr => $val) {
                $_FIELD[$attr] = $val;
            }

            array_push($JSON, $_FIELD);
        }


        return $JSON;
    }


    public function showGrid()
    {

        $grid = '';
        if($this->show_validation_errors){
            $grid .= show_validation_errors();
        }

        $grid .= '<form action="' . $this->url . '" method="' . $this->form_method . '" enctype="multipart/form-data" class="grid_form print-me"  data-print-hide=".search-tr, .gth-ids, .gtd-ids,.gth-grid_actions, .gtd-grid_actions, tfoot">';
        if(!$this->is_front) {
            $grid .= $this->selection_box();
        }
        $grid .= $this->getAdvanceSearch();
        //$grid .= '<div class="">';
        $grid .= '<table class="table table-striped -table-bordered table-hover table-responsive grid-table">';
        $grid .= '<thead class="thead-default">';

        if($this->search_box){
            $grid .= $this->getSearch();
        }
        $grid .= $this->getTHead();
        $grid .= '</thead>';
        $grid .= '<tbody>';
        $grid .= $this->getTBody();
        $grid .= '</body>';
        if ($this->show_paging_bar) {
            $grid .= $this->getTFoot();
        }
        $grid .= '</table>';
        //$grid .= '</div>';
        $grid .= '</form>';

        return $grid;
    }

    /**
     * @return string
     */
    function gridHeader()
    {
        ob_start();
        if (!empty($this->title)) {
            echo '<div class="panel-heading">
                    <h6 class="panel-title"><i class="icon-insert-template"></i> ' . $this->title . '</h6>
                  </div>';
        }
        if (count($this->form_buttons) > 0) {
            echo get_form_actions($this->form_buttons, $this->module_uri, $this->form_action_privilege);
        }

        return ob_get_clean();
    }


    function getAdvanceSearch()
    {
        if (!empty($this->advance_search_html)) {
            return '<span class="x-print">' . $this->advance_search_html . '<span>';
        }
    }

    private function generate_attr($attrs){
        $_attr = '';
        foreach ($attrs as $attr => $val) {
            if (in_array($attr, $this->escape_tags)) continue;
            $_attr .= ' ' . $attr . '="' . $val . '"';
        }
        return $_attr;
    }

    function getTHead()
    {
        ob_start();
        $s_col = $this->meta_column['sort'];
        $dir_col = $this->meta_column['dir'];

        $_columns = $this->get_columns();

        echo '<tr class="tr-title">';
        foreach ($_columns as $column) {
            if($column['hide']) continue;
            array_push($this->show_columns, $column);
            switch($column['field']){
                case 'ids':
                    echo "<th class='gth-{$column['field']}' align='{$column['align']}' width='{$column['width']}'><label class='m-checkbox m-checkbox--solid {$this->css_classes['checkbox']}'> <input type='checkbox' class='check-all'><span></span> </label></th>" . "\n";
                    break;
                case 'grid_actions':
                    echo "<th class='gth-grid_actions' align='{$column['th_align']}' width='{$column['width']}'>{$column['title']}</th>" . "\n";
                    break;
                default:
                    if($column['sortable'] && $this->sorting){
                        $order_dir = 'DESC';
                        $order_icon = '';
                        if($this->sort == $column['field']) {
                            if ($this->order == $order_dir) {
                                $order_dir = 'ASC';
                                $order_icon = "<i class='{$this->css_classes['sort_arrow_down']}'></i>";
                            }else{
                                $order_icon = "<i class='{$this->css_classes['sort_arrow_up']}'></i>";
                            }
                        }
                        $_order_url = generate_url($s_col, $this->url);
                        $_order_url = generate_url($dir_col, $_order_url) . "&{$s_col}={$column['field']}&$dir_col={$order_dir}";
                        echo "<th class='gth-{$column['field']}' align='{$column['th_align']}' width='{$column['width']}'>";
                        echo "<a href='{$_order_url}'>{$column['title']} {$order_icon}</a>" . "\n";
                        echo "</th>" . "\n";
                    }else{
                        echo "<th align='{$column['th_align']}'>{$column['title']}</th>" . "\n";
                    }
                    break;
            }
        }
        echo '</tr>';
        $HTML = ob_get_clean();
        return $HTML;
    }


    function getSearch()
    {
        ob_start();
        $f_col = $this->meta_column['filter'];
        $filter_data = getVar($f_col);

        $s_col = $this->meta_column['search'];
        $search_data = getVar($s_col);
        $_columns = $this->get_columns();


        echo '<tr class="search-tr">';
        foreach ($_columns as $column) {
            if($column['hide']) continue;
            /** --------- Filter */
            $filter_value = $this->filter_options[0];
            if(!empty($column['filter_value'])){
                $filter_value = $column['filter_value'];
            }
            if(!empty($filter_data[$column['field']])) {
                $filter_value = $filter_data[$column['field']];
            }

            $filter_tag_open = $filter_tag_end = $filter_html = '';

            if($column['filterable']) {
                $filter_tag_open .= '<div class="m-input-icon m-input-icon--right">';
                $filter_tag_end .= '</div>';

                $filter_html .= '<span class="m-input-icon__icon m-input-icon__icon--right">';
                $filter_html .= "<span data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='{$this->css_classes['filter']}'></i>";
                $filter_html .= "<ul class='dropdown-menu icons-right dropdown-menu-right'><li>";
                $filter_html .= "<select name='{$f_col}[{$column['field']}]' id='{$f_col}-{$column['field']}' class='{$this->css_classes['filter_select']}'>" . selectBox($this->filter_options, $filter_value) . "</select>";
                $filter_html .= "</li></ul>";
                $filter_html .= "</span></span>";

                $filter_html = '<span class="filter-div m-input-icon__icon m-input-icon__icon--right">';
                $filter_html .= '<span class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-center" m-dropdown-toggle="click" m-dropdown-persistent="true">';
                $filter_html .= "<span class='m-dropdown__toggle'><i class='{$this->css_classes['filter']}'></i></span>";

                $filter_html .='<div class="m-dropdown__wrapper"><span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                <div class="m-dropdown__inner"><div class="m-dropdown__body">
                                <div class="m-dropdown__content">';
                $filter_html .= "<select name='{$f_col}[{$column['field']}]' id='{$f_col}-{$column['field']}' class='{$this->css_classes['filter_select']}'>" . selectBox($this->filter_options, $filter_value) . "</select>";
                $filter_html .='</div></div></div>
                                </span></span></span>';


            }
            /** --------- Filter */
            $input_value = htmlentities($search_data[$column['field']], ENT_QUOTES, "UTF-8");
            //$input_value = $search_data[$column]['field'];

            echo "<th width='{$column['width']}' align='center'>";
            switch($column['field']){
                case 'ids':
                    //echo "<th>&nbsp;</th>" . "\n";
                    break;
                case 'grid_actions':
                    echo "<button type='submit' class='btn m-btn--pill m-btn--air m-btn m-btn--gradient-from-primary m-btn--gradient-to-info'><i class='la la-search'></i></button>" . "\n";
                    break;
                default:
                    if(count($column['input_options']) && is_array($column['input_options'])){
                        $s_input = key($column['input_options']);
                        $s_class = $column['input_options']['class'];

                        switch ($s_input){
                            case 'options':
                                $onchange = $column['input_options']['onchange'];

                                $_cls = (!empty($s_class) ? $s_class: 'm-bootstrap-select m_selectpicker');
                                $options = $column['input_options']['options'];
                                if(!key_exists('',$column['input_options']['options'])){
                                    $options = ['' => $column['title']];
                                    $options += $column['input_options']['options'];
                                }

                                echo $filter_tag_open;
                                echo "<select name='{$s_col}[{$column['field']}]' id='{$column['field']}' class='form-control {$_cls}' ".($onchange ? 'onchange="$(this).closest(\'form\').submit();"' : '').">".selectBox($options, $input_value)."</select>" . "\n";
                                echo $filter_html;
                                echo $filter_tag_end;
                                break;
                            case 'date_range':
                                $_cls = (!empty($s_class) ? $s_class: 'datepicker');
                                echo "<input type='text' placeholder='From' class='form-control {$_cls}' name='{$s_col}[{$column['field']}][from]' value='{$input_value['from']}' />" . "\n";
                                echo "<input type='text' placeholder='To' class='form-control {$_cls}' name='{$s_col}[{$column['field']}][to]' value='{$input_value['to']}'/>" . "\n";
                                break;
                            default:
                                $_cls = (!empty($s_class) ? $s_class: '');
                                echo $filter_tag_open;
                                echo "<input type='text' class='form-control {$_cls}' name='{$s_col}[{$column['field']}]' placeholder='{$column['title']}' value='{$input_value}'>" . "\n";
                                echo $filter_html;
                                echo $filter_tag_end;
                                break;
                        }

                    }else if(isset($column['search_input'])){
                        echo $column['search_input'] . "\n";
                    } else{
                        echo $filter_tag_open;
                        echo "<input type='text' class='form-control' name='{$s_col}[{$column['field']}]' placeholder='{$column['title']}' value='{$input_value}'>" . "\n";
                        echo $filter_html;
                        echo $filter_tag_end;
                    }

                    break;
            }
            echo "</th>";
        }
        echo '</tr>';
        $HTML = ob_get_clean();
        return $HTML;
    }


    function getTBody()
    {
        ob_start();
        if ($this->total_rows > 0) {
            $_columns = $this->get_columns();
            foreach ($this->rows as $i => $row) {
                $O_E = ($i % 2 == 0) ? 'odd' : 'even';
                echo "<tr class='{$O_E}'>";
                $f_key = -1;
                foreach ($row as $field => $value) {
                    $f_key++;
                    $column = $_columns[$f_key];

                    $column['class'] .= ' gtd-' . $field;
                    $style = (!empty($column['width']) ? "max-width: {$column['width']}px;" : "");
                    $style .= (!empty($column['overflow']) ? "overflow: {$column['overflow']};" : "");

                    if($column['hide']) continue;
                    switch($field){
                        case 'ids':
                            echo "<td " . $this->generate_attr($column) . "><label class='m-checkbox m-checkbox--solid {$this->css_classes['checkbox']}'><input type='checkbox' name='{$column['field']}[]' value='{$value}' class='chk-id'><span></span></label></td>" . "\n";
                            break;
                        default:
                            if(isset($column['image_path']) && !empty($column['image_path'])){
                                echo "<td " . $this->generate_attr($column) . " style='{$style}'>";
                                if(empty($column['image_size'])) {
                                    $column['image_size'] = $this->image_size;
                                }
                                $image_size = explode('x', $column['image_size']);
                                $thumb_file = _img($column['image_path'] . $value, $image_size[0], $image_size[1], $this->alt_image, 'zoomCrop');

                                echo "<a href='" . $column['image_path'] . $value . "' class='lightbox'><img src='" . $thumb_file . "' alt='{$value}' title='{$value}' class='img-responsive img-fluid'></a>";
                                echo "</td>" . "\n";
                            }else {
                                echo "<td " . $this->generate_attr($column) . " style='{$style}'>{$value}</td>" . "\n";
                            }
                            break;
                    }
                }
                echo '</tr>';
            }

        } else {
            echo '<tr><td colspan="' . (count($this->show_columns)) . '" valign="middle" align="center">' . $this->record_not_found . '</td></tr>';
        }

        return $HTML = ob_get_clean();
    }

    function getTFoot()
    {
        $c_limit = $this->meta_column['limit'];
        $page = $this->page;
        $last       = ceil( $this->total_rows / $this->limit );
        ob_start();
        ?>
        <tfoot>
        <tr>
            <td colspan="<?php echo (count($this->show_columns));?>">
                <div class="row">
                    <div class="col-sm-8"><?php echo $this->createLinks($page, $last);?></div>
                    <div class="col-sm-4 text-right">

                        <select class="form-control m-bootstrap-select m-bootstrap-select--pill m_selectpicker" title="Limit" data-width="85px" onchange="window.location = '<?php echo generate_url('limit') . '&' . $c_limit . '=';?>' + this.value">
                            <?php
                            $_show_entries = [];
                            foreach ($this->show_entries as $k => $v) {
                                $_v = $_k = $v;
                                if(is_array($v)){
                                    $_k = key($v);
                                    $_v = $v[$_k];
                                }
                                $_show_entries[$_k] = $_v;
                            }
                            echo selectBox($_show_entries, $this->limit); ?>
                        </select>
                        <span class="m-datatable__pager-detail">
                            <?php
                            $total_limit = ($this->start + $this->limit);
                            $total_limit = ($total_limit == 0 ? $this->total_rows : $total_limit);
                            $data = new stdClass();
                            $data->start = number_format($this->start + 1);
                            $data->show_limit = number_format(($total_limit > $this->total_rows ? $this->total_rows : $total_limit));
                            $data->total = number_format($this->total_rows);
                            echo replace_columns($this->display_records, $data);
                            ?>
                        </span>

                    </div>
                </div>
            </td>
        </tr>
        </tfoot>
        <?php
        return ob_get_clean();
    }

    /**
     * @return string
     */

    public function createLinks($page, $last, $adjacents = 2, $ul_class = 'pagination')
    {
        $s_page = $this->meta_column['page'];

        $url = generate_url('page');

        if ( $this->limit == 'all' ) {
            return '';
        }

        $start = ($page < $adjacents ? 1 : $page - $adjacents);
        $start = ($start <= 0 ? 1 : $start);
        $end = ($page > $last - $adjacents ? $last : $page + $adjacents);

        $html       = '<ul class="' . $ul_class . '">';

        $class      = ( $this->page == 1 ) ? "disabled" : "";
        $html       .= '<li class="' . $class . ' page-item first"><a class="page-link" href="' . $url . '&' . $s_page . '=1"><i class="la la-angle-double-left"></i></a></li>';
        $html       .= '<li class="' . $class . ' page-item prev"><a class="page-link" href="' . $url . '&' . $s_page . '=' . ( $this->page - 1 ) . '"><i class="la la-angle-left"></i></a></li>';

        if ( $start > 1 ) {
            $html   .= '<li class="page-item"><a class="page-link" href="' . $url . '&' . $s_page . '=1">1</a></li>';
            $html   .= '<li class="page-item ellipsis disabled"><a class="page-link"><i class="la la-ellipsis-h"></i></a></li>';
        }

        for ( $i = $start ; $i <= $end; $i++ ) {
            $class  = ( $this->page == $i ) ? "active" : "";
            if(( $this->page == $i ))
                $html .= '<li class="' . $class . ' page-item"><input type="text" name="page" value="'.$i.'" class="form-control" size="1"> </li>';
            else
                $html .= '<li class="' . $class . ' page-item"><a class="page-link" href="' . $url . '&' . $s_page . '=' . $i . '">' . $i . '</a></li>';
        }

        if ($end < $last) {
            $html   .= '<li class="disabled ellipsis page-item"><a class="page-link"><i class="la la-ellipsis-h"></i></a></li>';
            $html   .= '<li class="page-item"><a class="page-link" href="' . $url . '&' . $s_page . '=' . $last . '">' . $last . '</a></li>';
        }

        $class      = ( $this->page == $last || $last == 0) ? "disabled" : "";
        $html       .= '<li class="' . $class . ' page-item last"><a class="page-link" href="' . $url . '&' . $s_page . '=' . ( $this->page + 1 ) . '"><i class="la la-angle-right"></i></a></li>';
        $html       .= '<li class="' . $class . ' page-item next"><a class="page-link" href="' . $url . '&' . $s_page . '=' . $last . '"><i class="la la-angle-double-right"></i></a></li>';



        $html       .= '</ul>';



        return $html;
    }


    function selection_box(){
        ob_start();
        ?>
        <div class="selection-box">
            <div class="row align-items-center">
                <div class="col-xl-12">
                    <div class="m-form__group m-form__group--inline">
                        <div class="m-form__label m-form__label-no-wrap">
                            <label class="m--font-bold m--font-danger-">
                                Selected
                                <span id="m_datatable_selected_number">10</span>
                                records:
                            </label>
                        </div>
                        <div class="m-form__control">
                            <div class="btn-toolbar">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-accent btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Update status
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                        <a class="dropdown-item" href="#">
                                            Pending
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            Delivered
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            Canceled
                                        </a>
                                    </div>
                                </div>
                                &nbsp;&nbsp;&nbsp;
                                <button class="btn btn-sm btn-danger" type="button" id="m_datatable_check_all">
                                    Delete All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

}
