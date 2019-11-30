<?php
/**
 * @param string $url
 * @return string
 */
function admin_url($url = '')
{
    return site_url(ADMIN_URL . '/' . $url);
}

function admin_dir($url = '', $view = true)
{
    if($view){
        return (ADMIN_DIR . $url);
    }
    return (VIEWPATH . ADMIN_DIR . $url);
}

/**
 * @param string $url
 * @return string
 */
function asset_url($url = '', $admin = false)
{
    if($admin){
        return base_url('assets/' . ADMIN_DIR . $url);
    }
    return base_url('assets/' . $url);
}

function asset_dir($url = '', $admin = false)
{
    if($admin){
        return ('assets/' . ADMIN_DIR . $url);
    }
    return ('assets/' . $url);
}
/**
 * @param string $uri
 * @return string
 */
function template_url($uri = '')
{
    if(!defined('TEMPLATE_NAME')){
        $template = get_option('theme');
        define('TEMPLATE_NAME', $template);
    }else{
        $template = TEMPLATE_NAME;
    }
    return base_url(APPPATH . 'views/themes/' . $template . '/' . $uri);
}
/**
 * @param string $uri
 * @return string
 */
function media_url($uri = '')
{
    if(!defined('TEMPLATE_NAME')){
        $template = get_option('theme');
        define('TEMPLATE_NAME', $template);
    }else{
        $template = TEMPLATE_NAME;
    }
    if(empty($uri)){
        return asset_url($template);
    }else
    return asset_url($template . '/' . $uri);
}

function media_dir($uri = ''){

    return 'assets/' . get_theme() . '/' . $uri;
}


/**
 * @param bool $view For load view
 * @return string
 */
function get_theme(){
    if (!defined('TEMPLATE_NAME')) {
        $template = get_option('theme');
        define('TEMPLATE_NAME', $template);
    } else {
        $template = TEMPLATE_NAME;
    }
    return $template;
}
function get_template_directory($view = false)
{
    $template = get_theme();
    if ($view) {
        return 'themes/' . $template . '/';
    } else {
        return APPPATH . 'views/themes/' . $template . '/';
    }
}

function theme_dir($uri = '', $view = false){
    return get_template_directory($view) . $uri;
}

function theme_url($uri = ''){

    return base_url("application/views/" . get_template_directory(true) . $uri);
}

/**
 * @param $value
 * @param string $replace_str
 * @param string $equal_str
 * @return string
 */
function if_null($value, $replace_str = 'N/A', $equal_str = ''){
    if(empty($value) || $value == $equal_str){
        $value = $replace_str;
    }
    return $value;
}

/**
 * @param $num
 * @return string
 */
function ordinal_suffix($num)
{
    if ($num < 11 || $num > 13) {
        switch ($num % 10) {
            case 1:
                return 'st';
            case 2:
                return 'nd';
            case 3:
                return 'rd';
        }
    }
    return 'th';
}

/**
 * @param $remove_param
 * @param string $url
 * @return string
 */
function generate_url($remove_param, $url = '')
{
    $ci =& get_instance();
    if (empty($url)) {
        $url = current_url() . '?' . $ci->input->server('QUERY_STRING');
    }
    $parse_url = parse_url($url);

    if (!empty($parse_url['query'])) {
        $QUERY_STRING = $parse_url['query'];
        $_QUERY_STRING = explode('&', $QUERY_STRING);

        if (count($_QUERY_STRING)) {
            foreach ($_QUERY_STRING as $k => $v) {
                $__QUERY_STRING = explode('=', $v);
                if ($__QUERY_STRING[0] == 'do') {
                    unset($_QUERY_STRING[$k]);
                }
                if (in_array($__QUERY_STRING[0], $remove_param) && is_array($remove_param)) {
                    unset($_QUERY_STRING[$k]);
                } else if ($__QUERY_STRING[0] == $remove_param && !is_array($remove_param)) {
                    unset($_QUERY_STRING[$k]);
                }
                if(empty($__QUERY_STRING[1])){
                    unset($_QUERY_STRING[$k]);
                }
            }
        }
    }

    if(ROOT_DIR != '' && ROOT_DIR != '/'){
        $curent_path = str_replace(ROOT_DIR, '', $parse_url['path']);
    }else{
        $curent_path = $parse_url['path'];
    }

    if (count($_QUERY_STRING) && is_array($_QUERY_STRING)) {
        $NEW_QUERY_STRING = "?" . join('&', $_QUERY_STRING);
    }else{
        $NEW_QUERY_STRING = "?do=1";
    }
    //return site_url($curent_path . '/' . $NEW_QUERY_STRING);
    return site_url($curent_path .  $NEW_QUERY_STRING);
}

/**
 * @param $activity_name
 * @param string $table
 * @param int $rel_id
 * @param int $user_id
 * @param null $description
 */
function activity_log($activity_name, $table = '', $rel_id = 0, $user_id = 0, $description = null)
{

    $CI =& get_instance();

    if(!is_array($rel_id)){
        $rel_id = array($rel_id);
    }

    if (is_array($rel_id) && count($rel_id) > 0) {

        foreach ($rel_id as $relid) {

            if (getUri(1) == ADMIN_URL) {
                $table = (!empty($table) ? $table : getUri(2));
                $user_id = ($user_id > 0) ? $user_id : _session(ADMIN_SESSION_ID);
            } else {
                $table = (!empty($table) ? $table : getUri(1));
                $user_id = ($user_id > 0) ? $user_id : _session(FRONT_SESSION_ID);
            }
            $data = array(
                'activity_datetime' => date('Y-m-d H:i:s'),
                'activity_name' => $activity_name,
                'table' => $table,
                'user_id' => $user_id,
                'user_ip' => $CI->input->ip_address(),
                'user_agent' => $CI->input->user_agent(),
                'rel_id' => $relid,
                'current_URL' => current_url(),
                'description' => $description
            );
            $CI->db->insert('activity_log', $data);
        }
    }

}



function get_permalink($page, $url_field = 'url', $external_url = '')
{
    $friendly_url = '';
    switch ($page) {
        case is_object($page) :
            $friendly_url = $page_obj->{$url_field};
            break;
        case is_array($page) :
            $friendly_url = $page_obj[$url_field];
            break;
        case is_string($page) :
            $friendly_url = $page;
            break;
    }


    preg_match('/((http|https|ftp|ftps)\:\/\/)+?/i', $friendly_url, $matches);
    if (count($matches) > 0) {
        return $friendly_url;
    } else if (!empty($external_url)) {
        return $external_url . $friendly_url;
    } else {
        return site_url($friendly_url);
    }
}

/**
 * @param $query
 * @param string $selected
 * @return string
 */
function selectBox($query, $selected = '', $template = '<option {selected} value="{key}">{val}</option>')
{
    $CI = & get_instance();
    $options = '';

    if (is_array($query)) {
        $array = $query;
        if (count($array) > 0) {
            foreach ($array as $key => $val) {
                if (is_array($selected)) {
                    $_selected = ((in_array($key, $selected)) ? 'selected' : '');
                    $options .= str_replace(array('{key}', '{val}', '{selected}'), array($key, $val, $_selected), $template);
                    //$options .= '<option value="' . $key . '" ' . ((in_array($key, $selected)) ? 'selected' : '') . '>' . $val . '</option>';
                } else {
                    $_selected = (($key == $selected) ? 'selected' : '');
                    $options .= str_replace(array('{key}', '{val}', '{selected}'), array($key, $val, $_selected), $template);
                    //$options .= '<option value="' . $key . '" ' . (($key == $selected) ? 'selected' : '') . '>' . $val . '</option>';
                }
            }
        }
    } else {
        $result = $CI->db->query($query);

        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $key_ar = array_keys($row);
                $row['key'] = $key = $row[$key_ar[0]];
                $row['val'] = $row[$key_ar[1]];

                $_option = $template;
                foreach($row as $k => $v){
                    $_option = str_replace('{'.$k.'}', stripslashes($v) , $_option);
                }

                if (is_array($selected)) {
                    $_selected = ((in_array($key, $selected)) ? 'selected' : '');
                    $options .= str_replace('{selected}', $_selected , $_option);
                } else {
                    $_selected = (($key == $selected) ? 'selected' : '');
                    $options .= str_replace('{selected}', $_selected , $_option);
                }
            }
        }
    }
    return $options;
}

/**
 * @param $query
 * @param $name
 * @param string $checked
 * @param string $label_position
 * @param array $attrs
 * @param string $type
 * @return string
 */
function checkBox($query, $name, $checked = '', $label_position = 'right', $attrs = '', $type = 'checkbox')
{
    $CI = & get_instance();
    $CI->load->database();


    $options = '';
    if (is_array($query)) {
        $array = $query;
        if (count($array) > 0) {
            foreach ($array as $key => $val) {

                if (is_array($checked)) {
                    $options .= '<li class="checkbox_li li_' . $key . '">' . (($label_position != 'right') ? $val : '');
                    $options .= '<input type="' . $type . '" value="' . $val . '" name="' . $name . '" ' . ((in_array($key, $checked)) ? 'checked' : '') . ' ' . $attrs . '> ';
                    $options .= (($label_position == 'right') ? $val : '') . "</li>";
                } else {
                    $options .= '<li class="checkbox_li li_' . $key . '">' . (($label_position != 'right') ? $val : '');
                    $options .= '<input type="' . $type . '" value="' . $val . '" name="' . $name . '" ' . (($key == $checked) ? 'checked' : '') . ' ' . $attrs . '> ';
                    $options .= (($label_position == 'right') ? $val : '') . "</li>";
                }
            }
        }
    } else {
        $result = $CI->db->query($query);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $key = array_keys($row);

                if (is_array($checked)) {
                    $options .= '<li class="checkbox_li li_' . $row[$key[0]] . '">' . (($label_position != 'right') ? $row[$key[1]] : '');
                    $options .= '<input type="' . $type . '" value="' . $row[$key[0]] . '" name="' . $name . '" ' . ((in_array($row[$key[0]], $checked)) ? 'checked' : '') . ' ' . $attrs . '> ';
                    $options .= (($label_position == 'right') ? $row[$key[1]] : '') . "</li>";
                } else {
                    $options .= '<li class="checkbox_li li_' . $row[$key[0]] . '">' . (($label_position != 'right') ? $row[$key[1]] : '');
                    $options .= '<input type="' . $type . '" value="' . $row[$key[0]] . '" name="' . $name . '" ' . (($row[$key[0]] == $checked) ? 'checked' : '') . ' ' . $attrs . '> ';
                    $options .= (($label_position == 'right') ? $row[$key[1]] : '') . "</li>";
                }
            }
        }
    }
    return $options;
}

/**
 * @param $name
 * @param bool $xss_clean
 * @return string
 */

function getVar($name, $xss_clean = TRUE, $escape_sql = TRUE)
{
    $CI = & get_instance();
    if ($escape_sql) {
        return $CI->db->escape_str($CI->input->get_post($name, $xss_clean));
    } else {
        return $CI->input->get_post($name, $xss_clean);
    }
}

function getVarDB($name, $xss_clean = TRUE)
{
    $CI = & get_instance();
    return $CI->db->escape_str($CI->input->get_post($name, $xss_clean));
}

function dbEscape($string)
{
    $CI = & get_instance();
    return $CI->db->escape_str($string);
}


/**
 * @param $table
 * @param $column
 * @param string $where
 * @return mixed
 */
function getVal($table, $column, $where = '')
{
    $CI = & get_instance();
    $CI->load->database();
    $q = "SELECT $column FROM `$table` " . $where . " LIMIT 1";
    return $CI->db->query($q)->row()->$column;

}

/**
 * @param $table
 * @param string $column
 * @param string $where
 * @return mixed
 */
function getValues($table, $column = '*', $where = '', $single = true)
{
    $CI = & get_instance();
    $CI->load->database();
    $RS = $CI->db->query("SELECT $column FROM `$table` " . $where);
    return (($single) ? $RS->row() : $RS->result());

}

/**
 * @deprecated
 * @param $name
 * @param bool $xss_clean
 * @return string
 */
function gerVar($name, $xss_clean = TRUE)
{
    return getVar($name, $xss_clean);
}

function encryptPassword($password)
{
    return md5('adnan87' . $password . 'MET786');
}

/**
 * @param $number
 * @return string
 */
function getUri($number)
{
    $CI = & get_instance();
    return $CI->uri->segment($number);
}


function cellNumber($cellnumber)
{
    if (!empty($cellnumber)) {
        $cellnumber = (substr($cellnumber, 0, 1) != '0' ? '0' . $cellnumber : $cellnumber);
    }
    return $cellnumber;
}

function removeZero($str)
{
    $str = (substr($str, 0, 1) === '0' ? substr($str, 1) : $str);
    return $str;
}


function replaceChar($string, $num = 3, $replacement = 'x')
{

    $newStr = '';
    $length = (strlen($string) - $num);
    for ($i = 1; $i <= $length; $i++) {
        $newStr .= $replacement;
    }
    return $newStr . substr($string, $length, $num);
}

/**
 * @param $page
 * @param $per_page
 * @return string
 */
function getLimit($page, $per_page)
{
    $offset = ($page > 0 ? $page : 0);
    return " LIMIT " . $offset . ", " . $per_page;
}

/**
 * @param $table
 * @param $data array() 'key' => 'value'
 * @param string $where (WHERE 1=1)
 * @return string insert_id | WHERE
 */
function save($table, $data, $where = '')
{
    $CI = & get_instance();
    $CI->load->database();

    if (empty($where)) {
        $SQL = $CI->db->insert_string($table, $data);

        if($CI->db->query($SQL))
            return $CI->db->insert_id();
        else
            return false;
    } else {
        $SQL = $CI->db->update_string($table, $data, $where);
        if($CI->db->query($SQL))
            return true;
        else
            return false;
    }
}


function saveDB2($table, $data, $where = '', $db = 'ivr')
{
    $CI = & get_instance();
    $db2 = $CI->load->database($db, TRUE);

    if (empty($where)) {
        $SQL = $db2->insert_string($table, $data);
        $db2->query($SQL);
        return $db2->insert_id();
    } else {
        $SQL = $db2->update_string($table, $data, $where);
        $db2->query($SQL);
        return true;
    }
}

/*-------------------------------------------------------*/
$SEARCH_Q = array();
function getWhereClause($SQL, $key = 'search'){
    global $SEARCH_Q;
    $CI = & get_instance();
    $search_REQ = $CI->input->get($key);

    $query_col_str = ',' . substr($SQL, 6, (stripos(trim($SQL), 'FROM') - 6));
    /**
    ,
    activity_log.id
    , activity_log.activity_name
    , activity_log.`table`
    , activity_log.activity_datetime
    , users.username
    , activity_log.rel_id
     */
    /**
     * $exp = "/(?:select|\\G)\\s+\\K(?:(?:.*?\\s+as\\s+([^,]+),?)|([^,]+),?)(?=.*?\\bfrom\\b)/si";
     * preg_match_all($exp, $SQL, $columns);
     */

    /**
     * OK
     * $query_col_str = ', ' . substr($SQL, (stripos($SQL, 'SQL_CALC_FOUND_ROWS') + 28), (stripos($SQL, 'FROM') - 35));
     */
    foreach ($search_REQ as $field => $search_v) {

        preg_match('/\,(.*)? (as|AS) ' . $field . '/i', $query_col_str, $table_alias);
        $column_alias = trim($table_alias[1]);

        if (empty($column_alias)) {
            preg_match('/\,(.*)?\.' . $field . '\b/i', $query_col_str, $table_alias);
            $column_alias = trim($table_alias[1] . '.' . $field);
            if (!isset($table_alias[1])) {
                $column_alias = $field;
            }
        }

        //echo '<pre>';print_r($field . ': ' .$column_alias);echo '</pre>';
        $SEARCH_Q[$key.'_q'][$field] = $column_alias;
    }
}

function getFindQuery($query, $key = 'search', $whereClaus = [])
{
    global $SEARCH_Q;
    $CI = & get_instance();
    getWhereClause($query);

    $search_REQ = $CI->input->get($key);
    //$search_QUERY = $CI->input->get($key . '_q');
    $search_QUERY = $SEARCH_Q[$key . '_q'];

    $filter = $CI->input->get('filter');
    $search_q = '';

    foreach ($search_REQ as $search_f => $search_v) {
        $search_arr = null;
        if (!empty($search_v)) {
            $search_arr = explode(':', $search_f);
            $_operator = $filter[$search_f];
            if(!empty($search_QUERY[$search_f])){
                $s_coulum = strip_tags($search_QUERY[$search_f]);
                if($whereClaus[$search_f]){
                    $s_coulum = $whereClaus[$search_f];
                }

                if(stripos($s_coulum, 'CONCAT')  === false && stripos($s_coulum, '->')  === false ) {
                    $__c = explode('.', $s_coulum);
                    if (count($__c) > 1) {
                        $s_coulum = ($__c[0] . '.`' . $__c[1] . '`');
                    } else {
                        $s_coulum = '`' . ($s_coulum) . '`';
                    }
                }
            }else if (count($search_arr) >= 2) {
                $s_coulum = (!empty($search_arr[0])) ? $search_arr[0] . '.`' . $search_arr[1] . '`' : '`' . $search_arr[1] . '`';
            } elseif (count($search_arr) == 1) {
                $s_coulum = '`' . $search_arr[0] . '`';
            }


            if(is_array($search_REQ[$search_f])){
                if($search_REQ[$search_f]['from_date'] != '' && $search_REQ[$search_f]['to_date'] != ''){
                    $from = date2mysql($search_REQ[$search_f]['from_date']);
                    $to = date2mysql($search_REQ[$search_f]['to_date']);

                    $search_q .= " AND DATE_FORMAT({$s_coulum}, '%Y-%m-%d') BETWEEN '{$from}' AND '{$to}'";
                }else if($search_REQ[$search_f]['from'] != '' && $search_REQ[$search_f]['to'] != ''){
                    $from = ($search_REQ[$search_f]['from']);
                    $to = ($search_REQ[$search_f]['to']);

                    $search_q .= " AND $s_coulum BETWEEN {$from} AND {$to}";
                }

            }else{

                switch ($_operator) {
                    case '%-%':
                        $search_q .= " AND {$s_coulum} LIKE '%{$CI->db->escape_like_str($search_v)}%'";
                        break;
                    case '%!-%':
                        $search_q .= " AND {$s_coulum} NOT LIKE '%{$CI->db->escape_like_str($search_v)}%'";
                        break;
                    case '-%':
                        $search_q .= " AND {$s_coulum} LIKE '{$CI->db->escape_like_str($search_v)}%'";
                        break;
                    case '%-':
                        $search_q .= " AND {$s_coulum} LIKE '%{$CI->db->escape_like_str($search_v)}'";
                        break;
                    case '=':
                        $search_q .= " AND {$s_coulum} = '".dbEscape($search_v)."'";
                        break;
                    case '!=':
                        $search_q .= " AND {$s_coulum} != '".dbEscape($search_v)."'";
                        break;
                    case '>':
                        $search_q .= " AND {$s_coulum} > '".dbEscape($search_v)."'";
                        break;
                    case '>=':
                        $search_q .= " AND {$s_coulum} >= '".dbEscape($search_v)."'";
                        break;
                    case '<':
                        $search_q .= " AND {$s_coulum} < '".dbEscape($search_v)."'";
                        break;
                    case '<=':
                        $search_q .= " AND {$s_coulum} <= '".dbEscape($search_v)."'";
                        break;
                    default:
                        $search_q .= " AND {$s_coulum} LIKE '%{$CI->db->escape_like_str($search_v)}%'";

                }
            }
        }
    }

    return $search_q;
}

/**
 * @param $field_alias
 * @param $org_filed_str
 * @param $where_query
 */
function replace_find_query($field_alias, $org_filed_str, &$where_query){
    $where_query = str_ireplace('AND ' . $field_alias, 'AND ' . $org_filed_str, $where_query);
}


function fileDownload($file)
{


    $rs = get_file_info($file);
    $file_name = explode('/', $rs['name']);

    header('Content-Description: File Transfer');
    header('Content-Type: ' . $type);
    header('Content-Disposition: attachment; filename=' . end($file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    // Send file headers
}

/**
 * @param $table
 * @param array $ignore
 * @return array dbdata | where
 */
function getDbArray($table, $ignore = array(), $post_data = array())
{
    $CI = & get_instance();
    $CI->load->database();

    $fields = $CI->db->field_data($table);

    $dbArray = array();
    foreach ($fields as $field) {
        if(count($post_data) > 0){
            if (!in_array($field->name, $ignore) && (isset($post_data[$field->name]))) {
                if ($field->primary_key && !empty($post_data[$field->name])) {
                    $dbArray['where'] = "`" . $field->name . "`= '" . dbEscape($post_data[$field->name]) . "'";
                } else {
                    $dbArray['dbdata'][$field->name] = ($post_data[$field->name]);
                }
            }
        }else {
            if (!in_array($field->name, $ignore) && (isset($_REQUEST[$field->name]) || isset($_POST[$field->name]) || isset($_GET[$field->name]))) {
                if ($field->primary_key) {
                    $dbArray['where'] = "`" . $field->name . "`= '" . getVar($field->name) . "'";
                } else {
                    $dbArray['dbdata'][$field->name] = getVar($field->name, TRUE, FALSE);
                }
            }
        }
    }

    return $dbArray;
}

function getActionsCheckBox($params, $selected)
{
    $CI = & get_instance();
    $CI->load->database();

    $component_id = $params['component_id'];
    $actions = explode(',', $params['actions']);

    if (count($actions) > 0 && !empty($actions[0])) {
        $userAction = explode(',', $params['user_actions']);
        $html .= '<br>' . nbs(6);
        foreach ($actions as $action) {
            $html .= '<input type="checkbox" ' . ((in_array($action, $userAction)) ? "checked" : "") . ' name="actions[' . $component_id . '][]" id="actions_' . $component_id . '" value="' . $action . '"> ';
            $html .= $action . nbs(3);
        }
        $html .= '<br><br>';
    }
    return $html;
}


function singleColArray($query, $column)
{
    $ci = & get_instance();

    $rows = $ci->db->query($query)->result();
    $rt_array = array();
    if (count($rows) > 0) {
        foreach ($rows as $row) {
            array_push($rt_array, $row->$column);
        }
    }
    return $rt_array;
}

function array2url($array, $keyName)
{
    $url = '';
    foreach ($array as $key => $val) {
        $url .= (($key == 0) ? '' : '&') . $keyName . '=' . $val;
    }
    return $url;
}

function show_validation_errors($button = true)
{
    $ci =& get_instance();

    $btn_html = $html = '';
    if($button){
        $btn_html = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>';
    }


    $html .= get_notification($button);

    if (validation_errors() != '') {
        $errors = validation_errors();
        $html .= '<div class="animated bounceIn delay-2s m-alert alert-dismissible alert alert-danger bg-danger m-alert m-alert--air" role="alert">' . $btn_html . '<i class="icon-cancel-circle"></i>';
        $html .= $errors . '</div>';
    }

    return $html;
}



function delete_rows($table, $where = '', $force_delete = TRUE, $delete_status = 'deleted', $status_column = 'status', $unlink_files = array())
{
    $CI = & get_instance();
    if (count($unlink_files) > 0) {
        foreach ($unlink_files as $field_name => $file_path) {
            $S_SQL = "SELECT `{$field_name}` FROM {$table} WHERE {$where}";
            $RS = $CI->db->query($S_SQL);
            foreach ($RS->result() as $row) {
                @unlink($file_path . $row->{$field_name});
            }
        }
    }
    if ($force_delete) {
        $SQL = "DELETE FROM {$table} WHERE {$where}";
    } else {
        $SQL = "UPDATE {$table} SET `$status_column` = '" . $delete_status . "' WHERE {$where}";
    }

    return $CI->db->query($SQL);

}

function _checkbox($value, $default = 1){
    if (is_array($value) && in_array($default, $value)) {
        return ' checked="checked" ';
    }elseif($value == $default){
        return ' checked="checked" ';
    }
}

function _radiobox($value, $default = 1){
    if (is_array($value) && in_array($default, $value)) {
        return ' checked="checked" ';
    } elseif ($value == $default) {
        return ' checked="checked" ';
    }
}

function _selectbox($value, $default = 1){
    if (is_array($value) && in_array($default, $value)) {
        return ' selected="selected" ';
    } elseif ($value == $default) {
        return ' selected="selected" ';
    }
}



function array2object($array)
{
    $object = new stdClass();
    foreach ($array as $key => $value) {
        $object->$key = $value;
    }
    return $object;
}

function get_enum_values($table, $field, $assoc = true)
{
    $CI = & get_instance();
    $CI->load->database();
    $type = $CI->db->query("SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'")->row()->Type;
    preg_match('/^enum\((.*)\)$/', $type, $matches);
    if(count($matches) > 0){
        foreach (explode(',', $matches[1]) as $value) {
            if ($assoc) {
                $enum[trim($value, "'")] = trim($value, "'");
            } else {
                $enum[] = trim($value, "'");
            }
        }
        return $enum;
    }
    return false;
}



function getFlash($key, $value = '')
{
    $CI = & get_instance();
    if(!empty($value)){
        return $CI->session->set_flashdata($key, $value);
    }else{
        return $CI->session->flashdata($key);
    }
}

function __redirect($redirect = '')
{
    $CI = & get_instance();
    $_redirect = $CI->input->server('HTTP_REFERER');
    if(!empty($redirect)){
        redirect($redirect);
    }else{
        return $_redirect;
    }
}

function redirectBack($redirect = true)
{
    $CI = & get_instance();
    $_redirect = $CI->input->server('HTTP_REFERER');
    if($redirect){
        redirect($_redirect);
    }else{
        return $_redirect;
    }
}

/**
 * @param $name
 * @param string $value null for unset session
 * @return bool|mixed|void
 */
function _session($name, $value = '')
{
    $ci = & get_instance();
    if($value === null){
        $ci->session->unset_userdata($name);
        return true;
    }else if(!empty($value)){
        return $ci->session->set_userdata($name, $value);
    }else {
        return $ci->session->userdata($name);
    }
}

function has_option($option)
{
    $CI = & get_instance();
    $CI->load->database();

    if ($CI->db->query("SELECT * FROM `options` WHERE option_name=" . $CI->db->escape($option))->num_rows()) {
        return true;
    } else
        return false;
}

$_options = array();
function get_option($option, $key = null)
{
    global $_options;
    if (in_array($option, $_options)) {
        if($key){
            $option_value = $_options[$option];
            $frontend_inputs = explode("\n", trim($option_value));
            foreach($frontend_inputs as $front_input){
                $front_inputs = explode('=', trim($front_input));
                if($front_inputs[1] == $key){
                    $option_value = trim($front_inputs[0]);
                }
                //$__frontend_inputs[trim($front_inputs[0])] = $front_inputs[1];
            }
            return $option_value;
        }else{
            return $_options[$option];
        }
    }

    $ci = & get_instance();
    $_option_vals = $ci->db->query("SELECT * FROM `options` WHERE 1 ")->result();

    if(count($_option_vals) > 0){
        foreach($_option_vals as $_val){
            $_options[$_val->option_name] = $_val->option_value;
        }
    }

    return $_options[$option];
}


function object2array($object)
{
    $return = NULL;
    if (is_array($object)) {
        foreach ($object as $key => $value)
            $return[$key] = object2array($value);
    } else {
        $var = get_object_vars($object);

        if ($var) {
            foreach ($var as $key => $value)
                $return[$key] = ($key && !$value) ? NULL : object2array($value);
        } else return $object;
    }

    return $return;
}


function getDays($date1, $date2)
{
    $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);
    $secondsDifference = abs($ts2 - $ts1);
    return $days = floor($secondsDifference / (60 * 60 * 24));
}


function doPlural($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals
function get_date_diff($start_date, $end_date)
{

    $datetime1 = new DateTime($start_date);
    $datetime2 = new DateTime($end_date);
    $interval = $datetime1->diff($datetime2);



    $format = array();
    if($interval->y !== 0) {
        $format[] = "%y ".doPlural($interval->y, "year");
    }
    if($interval->m !== 0) {
        $format[] = "%m ".doPlural($interval->m, "month");
    }
    if($interval->d !== 0) {
        $format[] = "%d ".doPlural($interval->d, "day");
    }
    if($interval->h !== 0) {
        $format[] = "%h ".doPlural($interval->h, "hour");
    }
    if($interval->i !== 0) {
        $format[] = "%i ".doPlural($interval->i, "minute");
    }
    if($interval->s !== 0) {
        if(!count($format)) {
            return "less than a minute";
        } else {
            $format[] = "%s ".doPlural($interval->s, "second");
        }
    }

    // We use the two biggest parts
    if(count($format) > 1) {
        $format = array_shift($format)." and ".array_shift($format);
    } else {
        $format = array_pop($format);
    }

    // Prepend 'since ' or whatever you like
    return $interval->format($format);
}

function create_date($date, $date_string = '+ 10 days'){
    return date('Y-m-d', strtotime("{$date} $date_string"));

    /*$date = date_create($date);
    date_add($date, date_interval_create_from_date_string($date_string));

    return date_format($date, 'Y-m-d');*/
}


function getModuleDetail($module = '', $where = '')
{

    $CI =& get_instance();
    $CI->load->database();

    if (empty($module)) {
        $module = $CI->uri->segment(2);
    };
    $sql = "SELECT *, IF(icon !='', icon, 'module.png') AS icon FROM modules WHERE module=" . $CI->db->escape($module) . $where;
    $row = $CI->db->query($sql)->row();
    if(strpos($row->icon,'icon-') !== false){
        $row->module_icon = '<i class="m-nav__link-icon '.$row->icon.'"></i>';
    }else{
        $row->module_icon = '<img width="22" src="'.asset_url('uploads/img/icons/22_' . $row->icon).'"/>';
    }
    return $row;
}

function getUserActions($module = NULL)
{

    $CI =& get_instance();

    if (!$module) {
        $module = $CI->uri->segment(2);
    }
    $user_actions = $CI->session->userdata('actions');
    return $user_actions = array_unique(explode('|', str_replace(array('update'), array('edit'), $user_actions[$module])));
}

function multiFileArray($inputName)
{

    foreach ($_FILES[$inputName] as $key => $files) {
        /*foreach ($files['name'] as $_fk => $file){
            $_FILES[$files_str . $i][$key] = $files[$_fk];
            if (!in_array($files_str . $key, $_MYFILES))
                $_MYFILES[] = $files_str . $key;
        }*/
        for ($i = 0; $i < count($files); $i++) {
            $_FILES[$inputName . $i][$key] = $files[$i];
            if (!in_array($inputName . $i, $_MYFILES))
                $_MYFILES[] = $inputName . $i;
        }
    }
    unset($_FILES[$inputName]);
    return $_MYFILES;
}

if (!function_exists('array_trim')) {

    function array_trim(&$data)
    {
        foreach ($data as &$a) {
            $a = addslashes(trim($a));
        }
    }
}


function _lang($var)
{

    $CI =& get_instance();
    $CI->load->helper('language');

    $lang = $CI->session->userdata('lang');
    $language = getVal('languages', 'language', "WHERE iso_code='" . dbEscape($lang) . "'");

    $CI->lang->load($lang, strtolower($language));

    return $CI->lang->line($var);
}


function saveLang($table, $id, $lang, $langFields = array())
{
    $CI =& get_instance();
    if (!($lang == 'en' || empty($lang))) {
        $del_SQL = "DELETE FROM `translations` WHERE `table`='" . dbEscape($table) . "' AND pri_id='" . dbEscape($id) . "' AND lang='" . dbEscape($lang) . "'";
        $CI->db->query($del_SQL);
        foreach ($langFields as $field) {
            if (getVar($field, 1, 0) != '') {
                $data = array(
                    'lang' => $lang,
                    'table' => $table,
                    'pri_id' => $id,
                    'column' => $field,
                    'value' => addslashes(getVar($field, 0, 0))
                    //'value' => addslashes($_POST[$field])
                );

                save('translations', $data);
            }
        }
    }
}

function langRecord($table, $id, $lang, $langFields = array(), $rowData = array(), $is_object = true)
{
    $CI =& get_instance();
    if (!($lang == 'en' || empty($lang))) {
        $SQL = "SELECT * FROM `translations` WHERE `table`='" . dbEscape($table) . "' AND pri_id='" . dbEscape($id) . "' AND lang='" . dbEscape($lang) . "' AND `column` IN ('" . join("','", $langFields) . "')";
        $result = $CI->db->query($SQL)->result();

        foreach ($langFields as $field) {
            if ($is_object) {
                $rowData->{$field} = '';
            } else {
                $rowData[$field] = '';
            }
        }
        foreach ($result as $row) {
            if ($is_object)
                $rowData->{$row->column} = $row->value;
            else {
                $rowData[$row->column] = $row->value;
            }
        }
    }

    return $rowData;
}

function updateLangRecord($lang, $langFields, &$rowData)
{

    if (!($lang == 'en' || empty($lang))) {

        foreach ($langFields as $field) {
            unset($rowData[$field]);
        }
    }
}



/**
 * @param $file
 */
function load_lang($file, $admin = false){
    $ci = & get_instance();
    $idiom = _session('language');
    if(empty($idiom)){
        $idiom = 'english';
    }
    if($admin && file_exists(ADMIN_DIR . $file)){
        $ci->lang->load(ADMIN_DIR . $file, $idiom);
    }else if(file_exists(ADMIN_DIR . $file)){
        $ci->lang->load($file, $idiom);
    } else {
        log_message('debug', $file . ' - Language File not found!');
    }

}

/**
 * @param $keyword
 * @return string
 */
function __($keyword)
{
    $word = lang($keyword);
    if (empty($word)) {
        $word = $keyword;
    }

    return $word;
}


function set_notification($message, $type = 'error')
{
    $notification = _session('notification');
    $notification[$type][] = $message;
    _session('notification', $notification);
}

function get_notification($button = true)
{
    $btn_html = '';
    if($button){
        $btn_html = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> </button>';
    }

    $notification_ar = _session('notification');
    _session('notification', null);
    $notification = '';
    if (count($notification_ar) > 0) {
        foreach ($notification_ar as $type => $message) {
            switch ($type){
                case 'error':
                    $type = 'danger';
                    break;
            }
            $notification .= '<div class="animated bounceIn delay-2s alert alert-' . $type . ' bg-' . $type . ' m-alert m-alert--air">' . $btn_html . join('<br/>', $message) . '</div>';
        }
    }
    return $notification;
}


function decode_content($val, $row)
{
    $val = unserialize($val);
    $str = '';
    $youtube_url = 'http://www.youtube.com/watch?v=';
    if (count($val) > 0) {
        foreach ($val as $k => $v) {
            if ($k == 'source') {
                $youtube_url .= substr(end(explode('/', $v)), 0, -4);
            }
            $str .= '<strong>' . $k . '</strong> : ' . $v . '<br>';
        }
        $str .= '<strong style="color:red;">Youtube URL </strong> : ' . $youtube_url . '<br>';
    }
    return $str;
}


/**
 * @param $source_image
 * @param $new_image
 * @param $width
 * @param null $height
 * @return mixed
 */
function generate_image($source_image, $new_image, $width, $height = null)
{

    $obj =& get_instance();

    $obj->load->helper('url');
    $obj->load->helper('thumb');

    if(function_exists('thumb')){
        return thumb($source_image, $new_image, $width, $height);

    }else {
        $obj->load->library('image_lib');

        $config['image_library'] = 'gd2';

        $config['source_image'] = $source_image;
        $config['new_image'] = $new_image;
        $config['width'] = $width;
        $config['quality'] = 100;
        $config['maintain_ratio'] = FALSE;

        if (!empty($height)) {
            $config['height'] = $height;
        } else {
            $config['maintain_ratio'] = TRUE;
        }

        $obj->image_lib->initialize($config);

        $obj->image_lib->resize();

    }
    return $config['new_image'];
}


function image_thumb($image_path, $width = '', $height = '', $zoom_crop = 1, $alt_image = './assets/front/uploads/404_image.png')
{
    if (!(file_exists('./' . $image_path) && is_file('./' . $image_path))) {
        $image_path = $alt_image;
    }

    $_image_path = explode('/', $image_path);
    $_file_name = end($_image_path);
    $image_path = str_replace($_file_name, urlencode($_file_name), $image_path);
    return site_url('thumbs/' . ($image_path) . '?w=' . $width . '&h=' . $height . '&zc=' . $zoom_crop . '&hash=' . md5($image_path));
}


/**
 * @param $image_path
 * @param null $width
 * @param null $height
 * @param string $alt_image
 * @param string $func resize, zoomCrop
 * @return string
 */
function _img($image_path, $width = null, $height = null, $alt_image = IMG_NA, $func = 'resize')
{
    $file = str_ireplace(base_url(), '', $image_path);
    if (!file_exists($file) || is_dir($file)) {
        $image_path = base_url($alt_image);
    }

    $img =  _Image::open($image_path)->{$func}($width, $height)->setFallback(FCPATH . $alt_image);

    return base_url($img);
}

function checkAltImg($image, $alt_image = 'assets/uploads/na.png')
{
    $file = str_ireplace(base_url(), '', $image);
    if (!file_exists($file) || is_dir($file)) {
        $image = base_url($alt_image);
    }
    return $image;
}

function getLatLng($address, $apiKey = '')
{
    if(empty($apiKey)){$apiKey = get_option('gmap_key');}

    $address = urlencode($address);
    $url     = "https://maps.googleapis.com/maps/api/geocode/json?&callback=initialize&address={$address}&key={$apiKey}";
    $resp    = json_decode(file_get_contents($url),true);

    if ( $resp['status'] === 'OK' ) {
        $formatted_address = $resp['results'][0]['formatted_address'] ? $resp['results'][0]['formatted_address'] : '';
        $lat               = $resp['results'][0]['geometry']['location']['lat'] ? $resp['results'][0]['geometry']['location']['lat'] : '';
        $long              = $resp['results'][0]['geometry']['location']['lng'] ? $resp['results'][0]['geometry']['location']['lng'] : '';

        $obj = new stdClass();
        $obj->address = $formatted_address;
        $obj->lat = $lat;
        $obj->lng = $long;
        return $obj;
    }

    return false;

}

function post_without_wait($url, $params)
{

    foreach ($params as $key => &$val) {
      if (is_array($val)) $val = implode(',', $val);
        $post_params[] = $key.'='.urlencode($val);
    }
    $post_string = implode('&', $post_params);

    $parts=parse_url($url);

    $fp = fsockopen($parts['host'],
        isset($parts['port'])?$parts['port']:80,
        $errno, $errstr, 30);

    $out = "POST ".$parts['path']." HTTP/1.1\r\n";
    $out.= "Host: ".$parts['host']."\r\n";
    $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out.= "Content-Length: ".strlen($post_string)."\r\n";
    $out.= "Connection: Close\r\n\r\n";
    if (isset($post_string)) $out.= $post_string;

    fwrite($fp, $out);
    fclose($fp);
}



function multiRequest($URLs, $options = array())
{

    // array of curl handles
    $curly = array();
    // data to be returned
    $result = array();

    // multi handle
    $mh = curl_multi_init();

    // loop through $data and create curl handles
    // then add them to the multi-handle
    foreach ($URLs as $id => $d) {

        $curly[$id] = curl_init();

        $url = (is_array($d) && !empty($d['url'])) ? $d['url'] : $d;
        curl_setopt($curly[$id], CURLOPT_URL, $url);
        curl_setopt($curly[$id], CURLOPT_HEADER, 0);
        curl_setopt($curly[$id], CURLOPT_RETURNTRANSFER, 1);

        // post?
        if (is_array($d)) {
            if (!empty($d['post'])) {
                curl_setopt($curly[$id], CURLOPT_POST, 1);
                curl_setopt($curly[$id], CURLOPT_POSTFIELDS, $d['post']);
            }
        }

        // extra options?
        if (!empty($options)) {
            curl_setopt_array($curly[$id], $options);
        }

        curl_multi_add_handle($mh, $curly[$id]);
    }

    // execute the handles
    $running = null;
    do {
        curl_multi_exec($mh, $running);
    } while ($running > 0);


    // get content and remove handles
    foreach ($curly as $id => $c) {
        $result[$id] = curl_multi_getcontent($c);
        curl_multi_remove_handle($mh, $c);
    }

    // all done
    curl_multi_close($mh);

    return $result;
}


function randomcode()
{
    $charsets = array();
    $charsets[] = array("count" => 5, "char" => "ABCDEFGHIJKLMNOPQRSTUVWXYZ");
    $charsets[] = array("count" => 5, "char" => "0123456789");
    $code = array();
    foreach ($charsets as $charset) {
        for ($i = 0; $i < $charset["count"]; $i++) {
            $code[] = $charset["char"][rand(0, strlen($charset["char"]) - 1)];
        }
    }
    shuffle($code);
    return implode("", $code);
}

/**
 * @param $var_data_query mixed query and data
 * @param $email_temp_name
 * @return mixed
 */
function get_email_template($var_data_query, $template_name, $message = '')
{
    $ci =& get_instance();

    if(!empty($template_name)){
        $template = $ci->db->query("SELECT *, REPLACE(message, '../../../', '" . base_url() . "/') AS message FROM email_templates WHERE name='{$template_name}'")->row();
    }else{
        $template = new stdClass();
        $template->message = $template->subject = $message;
    }

    if (is_object($var_data_query)) {
        $var_data_query = object2array($var_data_query);
    }

    if (!is_array($var_data_query)) {
        $var_data_query = $ci->db->query($var_data_query)->row_array();
    }
    
    $var_data_query['site_url'] = site_url();
    $var_data_query['current_url'] = current_url();
    $var_data_query['base_url'] = base_url();
    $var_data_query['admin_url'] = admin_url();
    $var_data_query['site_title'] = get_option('site_title');
    $var_data_query['contact_email'] = get_option('contact_email');
    $var_data_query['copyright'] = get_option('copyright');
    $var_data_query['logo_url'] = asset_url(ADMIN_DIR . 'img/' . get_option('logo'));


    foreach ($var_data_query as $col => $val) {
        $template->subject = stripslashes(str_ireplace('[' . $col . ']', $val, $template->subject));
        $template->message = stripslashes(str_ireplace('[' . $col . ']', $val, $template->message));
    }
    $template->subject = preg_replace('/\[(.*)\]/', '', $template->subject);
    $template->message = preg_replace('/\[(.*)\]/', '', $template->message);

    if(empty($template_name) && !empty($message)){
        return $template->message;
    }
    return $template;

}

function send_mail($emaildata = array())
{

    if(empty($emaildata['to'])){
        return false;
    }

    $ci =& get_instance();

    $ci->load->library('email');

    $from = (!empty($emaildata['from']) ? $emaildata['from'] : 'no-reply@' . $ci->input->server('SERVER_NAME'));
    $from_name = (!empty($emaildata['from_name']) ? $emaildata['from_name'] : get_option('site_title'));
    $ci->email->from($from, $from_name);

    $ci->email->to($emaildata['to']);

    if (isset($emaildata['cc'])) {
        $ci->email->cc($emaildata['cc']);
    }

    if (isset($emaildata['bcc'])) {
        $ci->email->bcc($emaildata['bcc']);
    }

    $ci->email->subject($emaildata['subject']);
    $ci->email->message($emaildata['message']);

    $ci->email->mailtype = 'html';

    if (isset($emaildata['attach'])) {
        foreach ($emaildata['attach'] as $attach) {
            if (!empty($attach))
                $ci->email->attach($attach);
        }
    }

    if (get_option('smtp')) {
        $ci->email->smtp_host = get_option('smtp_host');
        $ci->email->smtp_user = get_option('smtp_user');
        $ci->email->smtp_pass = get_option('smtp_pass');
        $ci->email->smtp_port = get_option('smtp_port');
    }

    if ($ci->email->send()){
        $ci->email->clear(true);
        return true;
    }else{
        return false;
    }
}

function send_sms($message, $number){
    return true;
}

function random_db_field_value($table, $field, $value, $where = '') {
    $ci = & get_instance();

    $_WHERE = " WHERE " . $field . "='".$value."'";
    $SQL = "SELECT " . $field . " FROM " . $table . $_WHERE . str_ireplace('WHERE', 'AND', $where);

    $query = $ci->db->query($SQL);
    if($query->num_rows() > 0) {
        $value .= random_string('numeric',4);
        random_db_field_value($table, $field, $value, $where);
    }else{
        return $value;
    }
}

function user_info($key = '')
{
    $ci = & get_instance();
    $ci->load->model(ADMIN_DIR . 'm_users');
    $info = $ci->m_users->info();

    if(!empty($key)){
        return $info->{$key};
    }else{
        return $info;
    }
}




function user_do_action($action, $module = '')
{
    $ci = & get_instance();

    $module = (!empty($module) ? $module : getUri(2));

    $user_actions = $ci->db->query("SELECT um.actions FROM users AS u INNER JOIN user_type_module_rel AS um ON (u.user_type_id = um.user_type_id) INNER JOIN modules AS m ON (m.id = um.module_id) WHERE u.id = '" . intval(_session(ADMIN_SESSION_ID)) . "' AND m.`module`='" . addslashes($module) . "'")->row()->actions;
    $user_actions = array_unique(explode('|', str_replace(array('update'), array('edit'), $user_actions)));
    if(in_array($action, $user_actions)){
        return true;
    } else {
        return false;
    }
}


function concat_array_keys($str, $array){
    $is_obj = false;
    $is_array = false;

    $new_array = array();
    if(is_array($array)){
        $is_array = true;
        $new_array = array();

        foreach($array as $key => $value){
            $new_array[$str . $key] = $value;
        }
    }else{
        $is_obj = true;
        $new_array = new stdClass();
        foreach($array as $key => $value){
            $new_array->{$str . $key} = $value;
        }
    }

    return $new_array;
}


function thumb_box($image_url, $delete_img_url = '', $caption = '', $col = 2, $attr = ['w' => 200, 'h' => 200, 'func' => 'resize']){
    if(count(explode('.', $image_url)) == 1) {
        return;
    };

    $ext = strtolower(end(explode('.', $image_url)));
    if(in_array($ext, explode('|', IMG_EXTS))) {

        $thumb_url = _img($image_url, $attr['w'], $attr['h'], IMG_NA, $attr['func']);

        $html = '<div class="'.(is_int($col) ? 'col-sm-' . $col : $col). '" style=""><div class="block">
            <div class="thumbnail thumbnail-boxed">
              <div class="thumb"><img alt="" class="img-fluid" src="' . $thumb_url . '">
                <div class="thumb-options"><span>';

        $html .= '<a href="' . $image_url . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill lightbox"><i class="flaticon-visible"></i></a>';
        if (!empty($delete_img_url)) {
            $html .= '<a href="' . $delete_img_url . '" class="btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" ajax-call="delete_img"><i class="la la-trash"></i></a>';
        }
        $html .= '</span> </div> </div>';
    }else {

        $icon_file = file_icon($image_url);//'admin/img/file_icons/' . $ext . '.png';
        $is_icon = is_file($icon_file);
        $html = '<div class="'.(is_int($col) ? 'col-sm-' . $col : $col). '" style=""><div class="block"><div class="'.($is_icon ? 'thumb' : '').'">';
        if($is_icon){
            $thumb_url = _img($icon_file, $attr['w'], $attr['h'], IMG_NA, $attr['func']);

            $html .= '<img alt="" src="' . base_url($thumb_url) . '" class="img-responsive img-fluid" width="100%">';
        }
        $html .= '<div class="'.($is_icon ? 'thumb-options' : '').'"><span>';
        $html .= '<a target="_blank" href="' . $image_url . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"><i class="flaticon-visible"></i></a>&nbsp;';
        if (!empty($delete_img_url)) {
            $html .= '<a href="' . $delete_img_url . '" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" ajax-call="delete_img"><i class="la la-trash"></i></a>';
        }
        $html .= '</span></div>';
    }
    if(!empty($caption)){
        $html .= '<div class="caption">'.$caption.'</div>';
    }
    $html .= '</div></div></div>';

    return $html;
}

function file_icon($filename, $img = false){
    $ext = strtolower(end(explode('.', $filename)));
    $icon_file = 'assets/admin/img/file_icons/' . $ext . '.png';
    //$is_icon = is_file(ASSETS_DIR . $icon_file);
    if(in_array($ext, explode('|', IMG_EXTS)) && $img) {
        $icon_file = $filename;
    }
    return $icon_file;
}


/**
 * @param $table
 * @param $id_field
 * @param $id
 * @param array $null_cols
 * @param array $replace_col
 * @return array
 */
function DuplicateMySQLRecord($table, $id_field, $id, $null_cols = array('id'), $replace_col = array())
{
    $ci = &get_instance();
    $ids = array();
    // load the original record into an array
    $table_rs = $ci->db->query("SELECT * FROM `{$table}` WHERE `{$id_field}`='{$id}'")->result_array();

    if(count($table_rs) > 0){
        foreach($table_rs as $row){
            if(count($null_cols) > 0){
                foreach ($null_cols as $col) {
                    unset($row[$col]);
                }
            }
            if(count($replace_col) > 0){
                foreach ($replace_col as $col => $val) {
                    $row[$col] = $val;
                }
            }
            $id = save($table, $row);
            array_push($ids, $id);
        }
    }

    // return the new id
    return $ids;
}

/**
 * @param string $needle
 * @param array $haystack
 * @param null $key
 * @return bool|int|string
 */
$keys = array();
function array_search_recursive($needle, $haystack, $key = null)
{
    global  $keys;
    if(is_object($haystack)) {
        $haystack = object2array($haystack);
    }
    foreach ($haystack as $_key => $value) {
        if(is_array($value) || is_object($value)){
            array_search_recursive($needle, $value, $key);
        }else if($needle == $value){
            if($key != null && $key == $_key){
                array_push($keys, $_key);
            }else{ array_push($keys, $key); }
        }
    }
    return $keys;
}

function thumb_icon($file, $width = 100, $height = 100){
    $ext = end(explode('.', $file));

    $thumb_file  = image_thumb(ADMIN_ASSETS_DIR . 'img/file_icons/' . $ext . '.png', $width, $height);
    if (in_array($ext, explode('|', IMG_EXTS))) {
        $thumb_file = image_thumb($file, $width, $height);
    }
    return $thumb_file;
}


function search_in_array($value, $key, $array)
{
    foreach ($array as $_key => $val) {
        if ($val[$key] === $value) {
            return $_key;
        }
    }
    return null;
}

function replace_urls($content){

    $search = ['[site_url]', '../../../../', '../../../'];
    $replace = [site_url(), site_url(), site_url()];

    $content = str_replace($search, $replace, $content);
    return $content;
}

function number_to_int($number){
    return intval(str_replace(',', '', $number));
}

function result_to_json($result, $col_name, $fetch_cols=array()){
    $json_result_arr = array();
    foreach ($result as $res) {
        $decoded_data = json_decode($res->{$col_name});
        array_push($json_result_arr, $decoded_data);
    }
    return $json_result_arr;
}