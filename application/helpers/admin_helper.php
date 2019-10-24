<?php
/**
 * Adnan Bashir
 * Email: developer.adnan@gmail.com
 */

function get_member($user_id, $where = '')
{
    $ci = &get_instance();
    $ci->load->model(ADMIN_DIR . 'm_users');
    $info = $ci->m_users->row($user_id, $where);
    return $info;
}


function mysql2date($date, $format = 'd F, Y')
{
    if (empty($date) || date('Y-m-d', strtotime($date)) == '1970-01-01') {
        return '0000-00-00';
    } else
        return date($format, strtotime($date));
}

function date2mysql($date, $format = 'Y-m-d')
{
    if (empty($date) || date('Y-m-d', strtotime($date)) == '1970-01-01') {
        return '0000-00-00';
    } else {
        return date($format, strtotime($date));
    }
}

function user_types()
{

    $types[1] = get_option('admin_user_type');
    //$types[2] = get_option('driver_type_id');
    $types[3] = get_option('client_type_id');

    $returns = array();
    $args = func_get_args();
    if (count($args) > 0) {
        foreach ($args as $k) {
            if (!empty($types[$k]))
                array_push($returns, $types[$k]);
        }
    } else {
        $returns = array_merge($types);
    }

    return $returns;
}


function replace_columns($content, $data)
{
    if (count($data) > 0) {
        foreach ($data as $key => $val) {
            $content = str_replace('{' . $key . '}', $val, $content);
        }
    }
    return $content;
}

function array_attributes($_attr)
{
    //$attr = str_replace("=", '="', http_build_query($_attr, null, '" ', PHP_QUERY_RFC3986)) . '"';
    $attr = str_replace("=", '="', http_build_query($_attr, null, '" ')) . '"';
    $attr = ($attr == '"' ? '' : $attr);
    return $attr;
}

function portlet_actions($actions = array('minimize', 'expand'))
{
    $HTML = '<div class="m-portlet__head-tools"><ul class="m-portlet__nav">';

    $minimize = '<li class="m-portlet__nav-item">
                        <a href="#" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                            <i class="la la-angle-down"></i>
                        </a>
                    </li>';
    $refresh = '<li class="m-portlet__nav-item">
                    <a href="#"  m-portlet-tool="reload" class="m-portlet__nav-link m-portlet__nav-link--icon">
                        <i class="la la-refresh"></i>
                    </a>
                </li>';
    $expand = '<li class="m-portlet__nav-item">
                    <a href="#"  m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
                        <i class="la la-expand"></i>
                    </a>
                </li>';
    $close = '<li class="m-portlet__nav-item">
                <a href="#" m-portlet-tool="remove" class="m-portlet__nav-link m-portlet__nav-link--icon">
                    <i class="la la-close"></i>
                </a>
            </li>';

    foreach ($actions as $action) {
        $HTML .= $$action;
    }

    $HTML .= '</ul></div>';
    return $HTML;
}

/**
 * @param string $table
 * @param string $description
 * @param int $rel_id
 * @param string $type
 * @param int $user_id
 */
function developer_log($table = '', $description = '', $type = 'db', $user_id = 0)
{

    $ci =& get_instance();

    if (getUri(1) == ADMIN_URL) {
        $table = (!empty($table) ? $table : getUri(2));
        $user_id = ($user_id > 0) ? $user_id : _session(ADMIN_SESSION_ID);
    } else {
        $table = (!empty($table) ? $table : getUri(1));
        $user_id = ($user_id > 0) ? $user_id : _session(FRONT_SESSION_ID);
    }
    $data = array(
        'datetime' => date('Y-m-d H:i:s'),
        'type' => $type,
        'table' => $table,
        'user_id' => $user_id,
        'user_ip' => $ci->input->ip_address(),
        'user_agent' => $ci->input->user_agent(),
        'current_URL' => current_url(),
        'description' => $description
    );
    if ($ci->db->table_exists('developer_log')) {
        $ci->db->insert('developer_log', $data);
    } else {
        set_notification('Table "developer_log" not exists!', 'error');
    }

}