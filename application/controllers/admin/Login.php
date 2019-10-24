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
 * @property M_login $m_login
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        load_lang('login', true);

        $this->load->helper('cookie');
        $this->load->model(ADMIN_DIR . 'm_login');
        $this->load->model(ADMIN_DIR . 'm_users');
    }

    public function index()
    {
        if (_session(ADMIN_SESSION_ID)) {
            redirect(ADMIN_DIR . ('dashboard'));
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
        $this->load->view(ADMIN_DIR . 'login', $data);
    }

    public function do_login()
    {
        $JSON = ['status' => false];
        if ($this->m_login->validate()) {
            $username = getVar('username');
            $password = encryptPassword(getVar('password'));
            $remember = getVar('remember');

            $result = $this->m_login->chklogin($username, $password, " AND user_types.login IN('Backend', 'Both')");

            $logged_in_string = $username . '|' . $password;
            if ($remember) set_cookie('logged_in', $logged_in_string, time() + 60 * 60 * 24 * 30);
            else { set_cookie('logged_in', '', -70 + time());}

            if ($result) {
                $JSON['status'] = true;

                $this->session->set_userdata(array(
                    ADMIN_SESSION_ID => $result->id,
                    'username' => $result->username,
                    'email' => $result->email,
                    'user_type' => $result->user_type_id,
                    //'user_info' => $result,
                ));


                $REFERER = _session('REFERER');
                _session('REFERER', '');
                if (!empty($REFERER)) {
                    $JSON['redirect'] = $REFERER;
                } else
                $JSON['redirect'] = admin_url('dashboard');

            } else {
                set_notification(__('Incorrect username or password'));
            }
        }

        if($this->input->is_ajax_request()){
            $JSON['response'] = strip_tags(show_validation_errors(false));
            echo json_encode($JSON);
            exit;
        } else {
            redirect($JSON['redirect']);
        }
    }

    public function logout()
    {
        $this->session->unset_userdata(array(
            ADMIN_SESSION_ID,
            'username',
            'email',
            'user_type',
            'user_info',
        ));

        redirect(ADMIN_DIR);
    }


    public function forgot()
    {
        $data = array();

        $JSON = ['status' => false];
        if($this->input->is_ajax_request())
        {
            $email = getVar('email');

            if (!empty($email)) {
                $user = $this->m_users->row(0, " AND users.email = '{$email}' AND user_types.login IN('Backend', 'Both')");

                if ($user->id > 0) {
                    if ($user->status == 'Active') {
                        $this->load->helper('string');
                        $token_num = md5(random_string());
                        save('users', array('token_num' => $token_num), "id='{$user->id}'");
                        
                        # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        # Email notification
                        $reset_pass_url = admin_url('login/reset?token=' . $token_num);
                        $user->reset_url = $reset_pass_url;
                        unset($user->password);
                        $msg = get_email_template($user, 'Forgot Password - Admin');

                        if ($msg->status == 'Active') {
                            $emaildata = array(
                                'to' => $user->email,
                                //'cc' => get_option('admin_cc_email'),
                                'subject' => $msg->subject,
                                'message' => $msg->message
                            );
                            if (!send_mail($emaildata)) {
                                set_notification(__('Email sending failed!'));
                            } else {
                                $JSON['status'] = true;
                                set_notification(__('Please check your email'), 'success');
                            }
                        }


                    } else {
                        set_notification(__('Your account is blocked'));
                    }
                } else{
                    set_notification(__('Incorrect email address'));
                }
            }else{
                set_notification(__('Please enter your email address'));
            }

            $JSON['response'] = strip_tags(show_validation_errors(false));
            echo json_encode($JSON);
        } else {
            $this->load->view(ADMIN_DIR . 'forgot', $data);
        }
    }



    public function update_pass()
    {
        $user_id = _session(ADMIN_SESSION_ID);
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
        if (_session(ADMIN_SESSION_ID)) {
            redirect(ADMIN_DIR . 'dashboard');
        }


        $token_num = getVar('token');

        if (!$token_num) {
            $this->session->set_flashdata('error_msg', 'Password reset link is broken.');
            redirect(ADMIN_DIR . ('login'));
        }

        $user = $this->m_users->row(0, " AND users.token_num = '{$token_num}' AND status='Active' AND user_types.login IN('Backend', 'Both')");

        if ($user->id == 0) {
            set_notification('Password reset link is invalid or already used.', 'error');
            redirect(ADMIN_DIR . ('login'));
        }

        $data = [];
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $newpass = $this->input->post('newpass');
            $confpass = $this->input->post('confpass');

            if (!empty($newpass)) {
                if (!empty($confpass)) {
                    if($newpass == $confpass){
                        if (strlen($newpass) >= 6 && strlen($newpass) <= 12) {

                            save('users', array('password' => encryptPassword($newpass),'token_num' => ''), "id='" . $user->id . "'");
                            set_notification('Your password has been reset successfully.', 'success');
                            redirect(ADMIN_DIR . ('login'));
                        } else {
                            set_notification('Password should be 6 to 12 characters long.', 'error');
                        }
                    }else{
                        set_notification('Passwords do not match.', 'error');
                    }
                } else {
                    set_notification('Please confirm your new password.', 'error');
                }
            } else {
                set_notification('Please enter your new password.', 'error');
            }
        }

        $this->load->view(ADMIN_DIR . '/reset_login', $data);
    }


}