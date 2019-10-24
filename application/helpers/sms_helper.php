<?php
/**
 * Adnan Bashir
 * Email: developer.adnan@gmail.com
 */
function _reserve_types(){
    $reserve_types = [
        get_option('admin_user_type'), //Developer
        2, //Super Admin
        3, //Admin
        get_option('parent_type_id'),
        get_option('student_type_id'),
        get_option('teacher_type_id')
    ];

    return $reserve_types;
}

function _user_type_list(){
    $reserve_types = [
        get_option('admin_user_type'), //Developer
    ];

    $ci = &get_instance();
    $ci->db->where_not_in('id', $reserve_types);
    $rows = $ci->db->get('user_types')->result();

    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->user_type;
        }
    }
    return $RS;

    return $RS;
}

function _parent_list($where = '')
{
    $ci = &get_instance();
    $campus_id = _session('sms_campus_id');
    $user_type_id = get_option('parent_type_id');

    $SQL = "SELECT users.id
    , TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''), ' - ', sms_parents_rel.cnic)) as full_name
    FROM users 
    LEFT JOIN sms_parents_rel ON (sms_parents_rel.parent_id = users.id)
    WHERE user_type_id='{$user_type_id}' {$where}";

    $rows = $ci->db->query($SQL)->result();

    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->full_name;
        }
    }
    return $RS;
}

function _student_list($where = '')
{
    $ci = &get_instance();
    $campus_id = _session('sms_campus_id'); //AND campus_id='{$campus_id}'
    $user_type_id = get_option('student_type_id');
    $SQL = "SELECT users.id
    , TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''), ' - GR#: ', sms_students_rel.gr_number)) as full_name
    FROM users 
    LEFT JOIN sms_students_rel ON (sms_students_rel.student_id = users.id)
    WHERE user_type_id='{$user_type_id}' {$where}";

    $rows = $ci->db->query($SQL)->result();

    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->full_name;
        }
    }
    return $RS;
}

function _staff_list($where = '')
{
    $ci = &get_instance();
    $campus_id = _session('sms_campus_id');

    $SQL = "SELECT users.id
    , TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''), ' - ', sms_staff_rel.cnic)) as full_name
    FROM users 
    LEFT JOIN sms_staff_rel ON (sms_staff_rel.user_id = users.id)
    WHERE 1 {$where}";

    $rows = $ci->db->query($SQL)->result();

    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->full_name;
        }
    }
    return $RS;
}

function _teacher_list($where = '')
{
    $ci = &get_instance();
    $campus_id = _session('sms_campus_id');
    $user_type_id = get_option('teacher_type_id');
    $SQL = "SELECT users.id
    , TRIM(CONCAT(IFNULL(users.first_name, ''), ' ', IFNULL(users.last_name, ''), ' - ', sms_teachers_rel.cnic)) as full_name
    FROM users 
    LEFT JOIN sms_teachers_rel ON (sms_teachers_rel.teacher_id = users.id)
    WHERE user_type_id='{$user_type_id}' {$where}";

    $rows = $ci->db->query($SQL)->result();

    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->full_name;
        }
    }
    return $RS;
}

function _campus_list($where = '')
{
    $ci = &get_instance();
    $SQL = "SELECT id, campus FROM `sms_campus` WHERE 1 {$where}";
    $rows = $ci->db->query($SQL)->result();
    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->campus;
        }
    }
    return $RS;
}

function _class_list($campus_id = 0, $where = '')
{
    $ci = &get_instance();
    //$campus_id = _session('sms_campus_id');
    $wh = '';
    //if($campus_id > 0)
    {
        $wh .= " AND sms_classes.campus_id='{$campus_id}'";
    }

    $SQL = "SELECT sms_classes.id
-- , CONCAT(class , ' &nbsp;&nbsp;&nbsp;&nbsp; - [', sms_campus.campus ,']') AS class
, sms_classes.class 
FROM `sms_classes` 
    LEFT JOIN sms_campus ON (sms_campus.id = sms_classes.campus_id)
WHERE 1 {$wh} {$where}";
    $rows = $ci->db->query($SQL)->result();
    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->class;
        }
    }
    return $RS;
}

function _section_list($class_id = 0, $where = '')
{
    $ci = &get_instance();

    $wh = '';
    //if($class_id > 0)
    {
        $wh .= " AND class_id='{$class_id}'";
    }
    $SQL = "SELECT id, `section` FROM `sms_sections` WHERE 1 {$wh} {$where}";
    $rows = $ci->db->query($SQL)->result();
    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->section;
        }
    }
    return $RS;
}

function _subject_list($class_id = 0, $where = '')
{
    $ci = &get_instance();

    $wh = '';
    //if($class_id > 0)
    {
        $wh .= " AND class_id='{$class_id}'";
    }
    $SQL = "SELECT id, `subject` FROM `sms_subjects` WHERE 1 {$wh} {$where}";
    $rows = $ci->db->query($SQL)->result();
    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->subject;
        }
    }
    return $RS;
}



function _exam_term_list($campus_id = 0, $where = '')
{
    $ci = &get_instance();

    $wh = '';
    //if($campus_id > 0)
    {
        $wh .= " AND campus_id='{$campus_id}'";
    }
    $SQL = "SELECT id, `exam_title` FROM `sms_exam_term` WHERE 1 {$wh} {$where}";
    $rows = $ci->db->query($SQL)->result();
    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->exam_title;
        }
    }
    return $RS;
}



function _book_list($campus_id = 0, $where = '')
{
    $ci = &get_instance();

    $wh = '';
    //if($campus_id > 0)
    {
        $wh .= " AND campus_id='{$campus_id}'";
    }
    $SQL = "SELECT id, CONCAT(`book`, ' - ISBN[', isbn_no, ']') as book FROM `sms_library_books` WHERE 1 {$wh} {$where}";
    $rows = $ci->db->query($SQL)->result();
    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->book;
        }
    }
    return $RS;
}

function _vehicles_list($campus_id =0, $where = '')
{
    $ci = &get_instance();
    $wh = '';
    //if($campus_id > 0)
    {
        $wh .= " AND campus_id='{$campus_id}'";
    }
    $SQL = "SELECT id, CONCAT(vehicle_type, ' - ', number) AS vehicle FROM `sms_vehicles` WHERE 1 {$wh} {$where}";
    $rows = $ci->db->query($SQL)->result();
    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->vehicle;
        }
    }
    return $RS;
}

function _vehicles_routes_list($vehicle_id = 0, $where = '')
{
    $ci = &get_instance();
    $wh = '';
    //if($campus_id > 0)
    {
        $wh .= " AND vehicle_id='{$vehicle_id}'";
    }
    $SQL = "SELECT sms_vehicle_routes.id, sms_vehicle_routes.route
            FROM sms_vehicle_routes
                INNER JOIN sms_vehicle_route_rel ON(sms_vehicle_routes.id = sms_vehicle_route_rel.route_id)
            WHERE 1 {$wh} {$where}";

    $rows = $ci->db->query($SQL)->result();
    $RS = [];
    if (count($rows) > 0){
        foreach ($rows as $row) {
            $RS[$row->id] = $row->route;
        }
    }
    return $RS;
}


function sms_attendance_tick($value, $row, $field_name, $grid)
{
    $HTML = '<label class="m-radio m-radio--solid m-radio--success">';
    $HTML .= '<input type="radio" '._checkbox($value, $field_name).' name="attendance['.$row['id'].']" id="' . $field_name . '-'.$row['id'].'" class="form-control attendance-row attendance-tick" value="' . $field_name . '"/>';
    $HTML .= '<span></span> </label>';

    return $HTML;
}

function sms_attendance_textarea($value, $row, $field_name, $grid)
{
    $HTML = '<input type="hidden" name="attendance_id" class="attendance-row" value="'.$row['attendance_id'].'">';
    $HTML .= '<input type="hidden" name="user_id" class="attendance-row" value="'.$row['id'].'">';
    $HTML .= '<textarea name="'.$field_name.'" id="'.$field_name.'" class="form-control attendance-row" placeholder="'.$field_name.'">'.$value.'</textarea>';

    return $HTML;
}

function sms_library_books_qty($value, $row, $field_name, $grid)
{

    $HTML = '<span class="m-badge m-badge--primary" data-toggle="m-tooltip" data-original-title="Total Qty">'.$value.'</span> /&nbsp;';
    $HTML .= '<span class="m-badge m-badge--danger" data-toggle="m-tooltip" data-original-title="Issued Qty">'.$row['issued'].'</span>';
    return $HTML;
}


function _count_users($user_type_id = 0, $campus_id = 0, $_where = '')
{
    $ci = &get_instance();

    $where = $join = '';
    if($campus_id > 0){
        $where .= " AND campus_id='{$campus_id}'";
    }


    if($user_type_id > 0){
        $where .= " AND user_type_id='{$user_type_id}'";
        $where .= $_where;
        $SQL = "SELECT count(id) AS total FROM users WHERE 1 {$where}";

        $RS = $ci->db->query($SQL)->row();
    } else{
        $where .= $_where;
        $SQL = "SELECT user_types.user_type, count(users.id) AS total FROM user_types 
        LEFT JOIN users ON(users.user_type_id = user_types.id)
        WHERE 1 {$where} GROUP BY user_types.id";

        $RS = $ci->db->query($SQL)->result();
    }

    return $RS;
}

function get_select($name, $question_no, $selected = null, $param = []){
    $ci = &get_instance();
    $select = $ci->db->get_where('select_box', ['name' => $name], 1)->row();

    if (count($param) > 0) {
        foreach ($param as $key => $item) {
            if(!empty($item)){
                $select->{$key} = $item;
            }
        }
    }

    $HTML = '<h4 class="question-title-container">';
    if($select->required){
        $HTML .= '<span class="required-asterisk notranslate">*</span>';
    }
    $HTML .= ' <span class="question-number ">' . $question_no . '<span class="question-dot">.</span></span>';
    $HTML .= ' <span class="user-generated notranslate">' . $select->title . '</span>';
    $HTML .= '</h4>';

    $HTML .= '<div class="question-body clearfix notranslate">';
    if(!$select->view) {
        $HTML .= '<select name="' . $select->name . '" class="form-control m_selectpicker">';
        $HTML .= '<option value=""></option>';
    }
    $where = '';
    if($select->view && is_int($selected)) {
        $where = " AND id='".intval($selected)."'";
    }
    $DATA = $ci->db->query("SELECT id, `value` FROM select_values WHERE select_id='{$select->id}' {$where}")->result();
    $OPTIONS = [];
    foreach ($DATA as $DATUM) {
        $OPTIONS[$DATUM->id] = $DATUM->value;
    }
    if(!array_key_exists($selected, $OPTIONS) && !empty($selected)){
        $OPTIONS[$selected] = $selected;
    }
    if(!$select->view) {
        $HTML .= selectBox($OPTIONS, $selected);
        $HTML .= '</select>';
    } else {
        $HTML .= '<div class="value">'.$OPTIONS[$selected].'</div>';
    }

    $HTML .= '</div>';

    return $HTML;

}

function get_input($name, $question_no, $value, $title,  $required = true, $attr= '', $view = false){

    $HTML = '<h4 class="question-title-container">';
    if($required){
        $HTML .= '<span class="required-asterisk notranslate">*</span>';
    }
    $HTML .= ' <span class="question-number ">' . $question_no . '<span class="question-dot">.</span></span>';
    $HTML .= ' <span class="user-generated notranslate">' . $title . '</span>';
    $HTML .= '</h4>';

    $HTML .= '<div class="question-body clearfix notranslate">';
    if($view){
        $HTML .= $value;
    }else {
        $HTML .= '<input id="' . $name . '" name="' . $name . '" value="' . htmlentities($value) . '" type="text" class="form-control" ' . $attr . '>';
    }
    $HTML .= '</div>';

    return $HTML;

}