<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property M_login $m_login
 */
use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;

class Hauth extends CI_Controller
{
    var $config;
    var $site_url;

    function __construct()
    {

        parent::__construct();

        $this->load->model(ADMIN_DIR . 'm_login');
        $this->site_url = site_url();

        $this->config = [
            //'base_url' => $this->site_url . "hauth/endpoint",
            //'callback' => HttpClient\Util::getCurrentUrl(),
            'callback' => current_url(),
            'debug_mode' => 1,
            //'callback' => site_url('hauth/endpoint'),
            'providers' => [
                'Google' => [
                    'enabled' => true,
                    'keys'    => [ 'id' => '70556162479-l688pm4fiqdcaoodfngvorn3nrq0bgad.apps.googleusercontent.com', 'secret' => 'hMfnLDyRE6jDWTTu0L0iwbhP' ],
                    //"approval_prompt" => "force",     // optional
                    //'redirect_uri' => 'https://starjaidad.com/hauth/?hauth.done=Google'
                ],
                'Facebook' => [
                    'enabled' => true,
                    'keys'    => [ 'id' => '404812900074336', 'secret' => '0f47189cd1acba96c57fc704e36da192' ],
                ],
                'Twitter' => [
                    'enabled' => true,
                    'keys'    => [ 'key' => '', 'secret' => '' ],
                ]
            ],
        ];
    }

    public function login($provider)
    {

        try {
            //$this->config['callback'] = $this->site_url . ("hauth/endpoint/{$provider}/?hauth.done={$provider}");
            /*if($provider == 'Facebook'){
                $this->config['callback'] = $this->site_url . ("hauth/?hauth_done={$provider}");
            }*/

            $hybridauth = new Hybridauth($this->config);
            $adapter = $hybridauth->authenticate($provider);

            $tokens = $adapter->getAccessToken();
            $userProfile = $adapter->getUserProfile();


            $data = ['identifier' => $userProfile->identifier, 'webSiteURL' => $userProfile->webSiteURL
                , 'profileURL' => $userProfile->profileURL
                , 'photoURL' => $userProfile->photoURL
                , 'data' => $userProfile->data
            ];

            $userProfile = object2array($userProfile);
            $userProfile['first_name'] = $userProfile['firstName'] . ' ' . $userProfile['lastName'];
            //$userProfile['last_name'] = $userProfile['lastName'];
            $userProfile['photo'] = $userProfile['identifier'] . '.jpg';
            $userProfile['data'] = json_encode($data);
            file_put_contents(asset_dir('front/users/' . $userProfile['photo']), file_get_contents($userProfile['photoURL']));

            $userProfile['username'] = $userProfile['email'];
            $userProfile['social'] = $provider;

            //$user = $this->db->query("SELECT id FROM users WHERE JSON_EXTRACT(data, '$.identifier') = '{$userProfile['identifier']}'")->row();
            //$user = $this->db->query("SELECT id FROM users WHERE (`data` IS NOT NULL AND `data` != '') AND JSON_EXTRACT(data, '$.identifier') = '{$userProfile['identifier']}'")->row();
            //$user = $this->db->query("SELECT * FROM users WHERE email='{$userProfile['email']}'")->row();
            $user = $this->db->query("SELECT * FROM users WHERE `identifier`='{$userProfile['identifier']}'")->row();
            if ($user->id == 0){
                $db_data = getDbArray('users', ['id'], $userProfile)['dbdata'];
                $db_data['status'] = 'Active';
                $userProfile['user_type_id'] = $db_data['user_type_id'] = get_option('client_type_id');
				$db_data['identifier'] = $userProfile['identifier'];
				$db_data['created'] = date('Y-m-d H:i:s');

                $id = save('users', $db_data);

                $redirect = "member/account/?edit=edit";
            } else {
                $id = $user->id;
                $db_data = getDbArray('users', ['id'], $userProfile);
                save('users', $db_data['dbdata'], "id='{$id}'");

                $userProfile['user_type_id'] = $user->user_type_id;

                $redirect = "member/account/";
                if(empty($user->phone)){
                    $redirect = "member/account/?edit=edit";
                }
            }

			$user = $this->db->query("SELECT * FROM users WHERE `identifier`='{$userProfile['identifier']}'")->row();
            if($user->status = 'Active') {

				$this->m_login->set_login($id, 1);

				$this->session->set_userdata([
					FRONT_SESSION_ID => $id,
					'username' => $userProfile['identifier'],
					'email' => $userProfile['email'],
					'user_type_id' => $userProfile['user_type_id'],
					//'user_info' => $result,
				]);

				// print_r( $tokens );
				// print_r( $userProfile );

				$adapter->disconnect();
				//redirect($redirect);
            	header('Location: ' . DOMAIN_URL . $redirect);
			} else {
				set_notification('Your account is deactivated! Contact support team.');
				header('Location: ' . DOMAIN_URL . 'login');
			}
        }
        catch (\Exception $e) {
            redirect($this->site_url, 'refresh');
            die();
            //echo '<pre>'; print_r($e->getMessage()); echo '</pre>';
        }
    }

    function logout($provider){

        $user_id = _session(FRONT_SESSION_ID);
        $this->m_login->set_login($user_id, 0);

		activity_log('Logout', 'users', $user_id, $user_id);

        $hybridauth = new Hybridauth($this->config);

        $adapter = $hybridauth->getAdapter($provider);
        $adapter->disconnect();

        $this->session->unset_userdata([
            FRONT_SESSION_ID,
            'username',
            'email',
            'user_type_id',
            'user_info',
        ]);
        redirect(DOMAIN_URL);
    }


    public function endpoint($provider)
    {
        $this->config['callback'] = $this->site_url . ("hauth/endpoint/{$provider}/?hauth.done={$provider}");

        log_message('debug', 'controllers.HAuth.endpoint called.');
        log_message('info', 'controllers.HAuth.endpoint: $_REQUEST: ' . print_r($_REQUEST, TRUE));
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            log_message('debug', 'controllers.HAuth.endpoint: the request method is GET, copying REQUEST array into GET array.');
            $_GET = $_REQUEST;
        }
        log_message('debug', 'controllers.HAuth.endpoint: loading the original HybridAuth endpoint script.');

        $hybridauth = new Hybridauth($this->config);
        $adapter = $hybridauth->authenticate($provider);

        $userProfile = $adapter->getUserProfile();
        echo '<pre>'; print_r($userProfile); echo '</pre>';
        die('endpoint');
    }
}
/* End of file hauth.php */
/* Location: ./application/controllers/hauth.php */
