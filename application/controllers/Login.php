<?php
/**
 * Developed by Adnan Bashir.
 * Email: pisces_adnan@hotmail.com
 * Autour: Adnan Bashir
 * Date: 5/26/12
 * Time: 10:35 AM
 */
/**
 * Class Login
 * @property M_users $m_users
 * @property M_agents $m_agents
 * @property M_login $m_login
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    var $redirect_module = 'member';
    var $user_type_id = 0;

    public function __construct()
    {
        parent::__construct();

        load_lang('login', true);

        $this->load->helper('cookie');
        $this->load->helper('frontend');
        $this->load->model(ADMIN_DIR . 'm_login');
        $this->load->model(ADMIN_DIR . 'm_users');
        $this->load->model(ADMIN_DIR . 'm_agents');

        $this->user_type_id = get_option('client_type_id');
    }


    public function index()
    {
        if (_session(FRONT_SESSION_ID)) {
            redirect($this->redirect_module);
        }

        $data = array();
        $cookie = explode('|', $this->input->cookie('logged_in'));
        if (count($cookie) > 0) {
            $data['username'] = stripslashes($cookie[0]);
            $data['password'] = $cookie[1];
            $data['remember'] = $cookie[2];

            $data['remember_data'] = $this->db->select('first_name, last_name, photo')->from('users')->where(array('username' => $data['username'], 'password' => encryptPassword($data['password'])))->get()->row();
        }

        //Load Login
        $this->load->view(theme_dir('login/login', true), $data);
    }

    function registration()
    {

        $module = 'm_users';
        $checkout = getVar('checkout');
        $edit = getVar('edit');
        $become_agent = getVar('become_agent', true, false);
        if($become_agent){
            $module = 'm_agents';
        }
        $change_pass = getVar('change_pass');

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $member_id = _session(FRONT_SESSION_ID);
            if ($edit) {
                if (!$member_id) {
                    redirect('member/login');


                }
                $member = get_member($member_id);
                if($member->user_type_id == get_option('agent_type_id')){
                    $module = 'm_agents';
                }
            }

            $_POST['username'] = $_POST['email'];
            $_POST['email'] = $_POST['username'];
            if ($this->{$module}->validate($member_id, false)) {

                if (!$edit && $member_id = $this->{$module}->insert(['user_type_id' => $this->user_type_id])) {
                    $JSON['success'] = $JSON['status'] = true;
                    $JSON['message'] = 'Member has been registered' . "\n";
                    set_notification(__($JSON['message']), 'success');

                    activity_log('Registration', 'users', $member_id, $member_id);
                    # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                    # registration_email
                    $member = $this->m_users->row($member_id);
                    $member->password = getVar('password');
                    $msg = get_email_template($member, 'New Account');
                    if ($msg->status == 'Active') {
                        $emaildata = array(
                            'to' => $member->email,
                            'subject' => $msg->subject,
                            'message' => $msg->message
                        );
                        if (!send_mail($emaildata)) {
                            set_notification('Email sending failed.', 'danger');
                        } else {
                            set_notification('Please check your email for username & password!','success');
                        }
                    }

                } else if ($this->{$module}->update($member_id) && $edit) {
                    set_notification(__('Request has been submitted!'), 'success');
                } else {
                    set_notification(__('Some error occurred!'), 'error');
                }

                $REFERER = _session('REFERER');
                _session('REFERER', '');
                if (!empty($REFERER)) {
                    $JSON['redirect'] = $REFERER;
                } else {
                    //$JSON['redirect'] = redirectBack();
                }
                //$JSON['redirect'] = site_url($this->redirect_module);

            }
        }
        if ($this->input->is_ajax_request()) {
            $JSON['message'] = $JSON['response'] = strip_tags(show_validation_errors(false), '<br><b>');
            echo json_encode($JSON);
            exit;
        } else {
            $JSON['message'] = '';
            //redirect($JSON['redirect']);
            $data['row'] = array2object($this->input->post());
            $data['redirect'] = getVar('redirect');
            if($edit){
                set_notification('Request has been sent!!','success');
                redirect('member/account');

                //redirectBack();
            }else{
                $this->template->load('login/login', $data);
            }
        }


    }


    public function login()
    {

        $JSON = ['status' => false];
        $_POST['username'] = $_POST['email'];
        if ($this->m_login->validate()) {
            $username = getVar('username');
            $password = encryptPassword(getVar('password'));
            $remember = getVar('remember');
            $result = $this->m_login->chklogin($username, $password, " AND user_types.login IN('Frontend', 'Both')");

            if ($result) {
                $JSON['success'] = $JSON['status'] = true;

                $logged_in_string = $username . '|' . $password;
                if ($remember) set_cookie(FRONT_SESSION_ID, $logged_in_string, time() + 60 * 60 * 24 * 30);
                else {
                    set_cookie(FRONT_SESSION_ID, '', -70 + time());
                }

                $this->m_login->set_login($result->id, 1);
                $this->session->set_userdata(array(
                    FRONT_SESSION_ID => $result->id,
                    'username' => $result->username,
                    'email' => $result->email,
                    'user_type_id' => $result->user_type_id,
                    //'user_info' => $result,
                ));

                if(!empty(getVar('redirect'))){
                    redirect(getVar('redirect'));
                }
                $REFERER = _session('REFERER');
                _session('REFERER', '');
                if (!empty($REFERER)) {
                    $JSON['redirect'] = $REFERER;
                }
                $JSON['redirect'] = site_url($this->redirect_module);

            } else {
                set_notification(__('Incorrect username or password'));
                //redirectBack();
            }
        }

        if ($this->input->is_ajax_request()) {
            $JSON['message'] = $JSON['response'] = strip_tags(show_validation_errors(false), '<br>');
            echo json_encode($JSON);
            exit;
        } else {
            $JSON['message'] = '';
            redirect($JSON['redirect']);
        }
    }

    public function logout()
    {
        $user_id = _session(FRONT_SESSION_ID);
        $this->m_login->set_login($user_id, 0);

        $this->session->unset_userdata(array(
            FRONT_SESSION_ID,
            'username',
            'email',
            'user_type_id',
            'user_info',
        ));

        redirect(site_url());
    }


    public function _forgot()
    {
        $data = array();

        $JSON = ['status' => false, 'success' => false];
        if ($this->input->is_ajax_request()) {
            $email = getVar('email');

            if (!empty($email)) {
                $user = $this->m_users->row(0, " AND users.username = '{$email}' AND user_types.login IN('Frontend', 'Both')");

                if ($user->id > 0) {
                    if ($user->status == 'Active') {
                        $this->load->helper('string');
                        $password = (random_string('alnum', 6));
                        save('users', array('password' => encryptPassword($password)), "id='{$user->id}'");
                        set_notification(__("Password <b>$password</b> has been updated!"), 'success');
                        # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        # Email notification
                        $user->password = $password;
                        $msg = get_email_template($user, 'Update Password');

                        if ($msg->status == 'Active') {
                            $emaildata = array(
                                'to' => $user->email,
                                //'cc' => get_option('admin_cc_email'),
                                'subject' => $msg->subject,
                                'message' => $msg->message
                            );
                            if (!send_mail($emaildata)) {
                                set_notification(__('Email sending failed'));
                            } else {
                                set_notification(__('Please check your email'), 'success');
                            }
                        }
                        $JSON['success'] = $JSON['status'] = true;

                    } else {
                        set_notification(__('Your account is blocked'));
                    }
                } else {
                    set_notification(__('Incorrect email address'));
                }
            } else {
                set_notification(__('Please enter your email address'));
            }

            $JSON['message'] = $JSON['response'] = str_replace('Username ', 'Email ', strip_tags(show_validation_errors(false), '<br><b>'));
            echo json_encode($JSON);
        } else {
            $this->load->view(theme_dir('login/forgot', true), $data);
        }
    }


    public function forgot()
    {
        $data = array();

        $JSON = ['status' => false, 'success' => false];
        if ($this->input->is_ajax_request()) {
            $email = getVar('email');

            if (!empty($email)) {
                //$user = $this->m_users->row(0, " AND users.email = '{$email}' AND user_types.login IN('Frontend', 'Both')");
                $user = $this->m_users->row(0, " AND users.username = '{$email}' AND user_types.login IN('Frontend', 'Both')");

                if ($user->id > 0) {
                    if ($user->status == 'Active') {
                        $this->load->helper('string');
                        $token_num = md5(random_string());
                        save('users', array('token_num' => $token_num), "id='{$user->id}'");

                        # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        # Email notification
                        $reset_pass_url = site_url('login/reset?token=' . $token_num);
                        $user->reset_url = $reset_pass_url;
                        unset($user->password);
                        $msg = get_email_template($user, 'Forgot Password');
                        $JSON['m'] = $msg->message;
                        if ($msg->status == 'Active') {
                            $emaildata = array(
                                'to' => $user->email,
                                //'cc' => get_option('admin_cc_email'),
                                'subject' => $msg->subject,
                                'message' => $msg->message
                            );
                            if (!send_mail($emaildata)) {
                                $JSON['success'] = $JSON['status'] = true;
                                set_notification(__('Email sending failed'));
                            } else {
                                set_notification(__('Please check your email'), 'success');
                            }
                        }


                    } else {
                        set_notification(__('Your account is blocked'));
                    }
                } else {
                    set_notification(__('Incorrect email address'));
                }
            } else {
                set_notification(__('Please enter your email address'));
            }

            $JSON['message'] = $JSON['response'] = strip_tags(show_validation_errors(false), '<br><b>');
            echo json_encode($JSON);
        } else {
            $this->load->view(theme_dir('login/forgot', true), $data);
        }
    }


    public function update_pass()
    {
        $user_id = _session(FRONT_SESSION_ID);
        $old_password = md5(getVar('old_password'));
        $password = md5(trim(getVar('password')));
        $sql = "SELECT * FROM users WHERE user_id={$user_id} AND `password`='{$old_password}'";
        $rs = $this->db->query($sql);
        if ($rs->num_rows() > 0) {
            $update_sql = "UPDATE users SET `password` = '{$password}' WHERE user_id = '{$user_id}'";
            $this->db->query($update_sql);
            echo 'Successfully Changed New Password';
        } else {
            echo 'Your old password is wrong...';
        }
    }


    /**
     * -----------------------------------------------------------------------------------------------------------------
     * Password Reset
     * -----------------------------------------------------------------------------------------------------------------
     */

    public function reset()
    {
        if (_session(FRONT_SESSION_ID)) {
            redirect($this->redirect_module);
        }


        $token_num = getVar('token');

        if (!$token_num) {
            $this->session->set_flashdata('error_msg', 'Password reset link is broken.');
            redirect('login');
        }

        $user = $this->m_users->row(0, " AND users.token_num = '{$token_num}' AND status='Active' AND user_types.login IN('Frontend', 'Both')");

        if ($user->id == 0) {
            set_notification('Password reset link is invalid or already used.', 'error');
            redirect('login');
        }

        $data = [];
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $newpass = $this->input->post('newpass');
            $confpass = $this->input->post('confpass');

            if (!empty($newpass)) {
                if (!empty($confpass)) {
                    if ($newpass == $confpass) {
                        if (strlen($newpass) >= 6 && strlen($newpass) <= 12) {

                            save('users', array('password' => encryptPassword($newpass), 'token_num' => ''), "id='" . $user->id . "'");
                            set_notification('Your password has been reset successfully.', 'success');
                            redirect('login');
                        } else {
                            set_notification('Password should be 6 to 12 characters long.', 'error');
                        }
                    } else {
                        set_notification('Passwords do not match.', 'error');
                    }
                } else {
                    set_notification('Please confirm your new password.', 'error');
                }
            } else {
                set_notification('Please enter your new password.', 'error');
            }
        }

        $this->load->view(theme_dir('login/reset_login', true), $data);
    }


    function ajax($action, $id = 0)
    {
        $JSON = [];
        switch ($action) {
            case 'validate':
                $field = array_keys($_GET)[0];
                $value = getVar($field);
                $WHERE = "AND `{$field}`='{$value}'";
                if($id > 0){ $WHERE .= " AND users.`id` != '{$id}'"; }

                $row = $this->m_users->row(0, $WHERE);
                if($row->id > 0){
                    exit('false');
                }
                exit('true');
                break;
        }

        echo json_encode($JSON);
    }

}