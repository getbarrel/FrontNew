<?php
	define( 'FACEBOOK_OAUTH_AUTHORIZE_URL', 'https://www.facebook.com/dialog/oauth' );
	define( 'FACEBOOK_OAUTH_TOKEN_URL', 'https://graph.facebook.com/'.FACEBOOK_API_VERSION.'/oauth/access_token' );
	define( 'FACEBOOK_GET_USERINFO_URL', 'https://graph.facebook.com/'.FACEBOOK_API_VERSION.'/me');
	class FacebookLogin{
		private $client_id;
		private $client_secret;
		private $redirect_url;
		private $state;
		private $session;
		private $authorize_url = FACEBOOK_OAUTH_AUTHORIZE_URL;
		private $accesstoken_url = FACEBOOK_OAUTH_TOKEN_URL;
		private $code;
		private $tokenArr; 
		private $userInfo;

		function __construct( $client_id, $client_secret, $redirect_url, $mode=NULL) {
			$this -> client_id = $client_id;
			$this -> client_secret = $client_secret;
			$this -> redirect_url = $redirect_url;

			if(!isset($_SESSION)) {
				session_start();
			}
		}
		private function generate_state(){
			$mt = microtime();
			$rand = mt_rand();
			$this -> state = md5( $mt . $rand );
		}
		public function set_state(){
			$this -> generate_state();
			return $this -> state;
		}
		private function get_code(){
			$this -> code = $_GET['code'];
		}
		private function get_state(){
			$this -> state = $_SESSION['state'];
			return $this -> state;
		}
		public function request_auth(){
			return $this -> get_request_url();
		}
		public function get_request_url(){
			return $this -> authorize_url . '?client_id=' . $this -> client_id . '&redirect_uri=' . urlencode($this -> redirect_url);
		}
		public function get_accesstoken_url(){
			//return $this -> accesstoken_url . '?grant_type=authorization_code&client_id=' . $this -> client_id . '&client_secret=' . $this -> client_secret . '&code=' . $this -> code . '&redirect_uri=' . urlencode($this -> redirect_url);
			return $this -> accesstoken_url;
		}
		public function call_accesstoken(){
			$this -> get_code();
			$this -> get_state();

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
			curl_setopt($ch, CURLOPT_URL, $this -> get_accesstoken_url() );
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch, CURLOPT_POST, TRUE );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, 'client_id=' . $this -> client_id . '&client_secret=' . $this -> client_secret . '&code=' . $this -> code . '&redirect_uri=' . urlencode($this -> redirect_url));
			$g = curl_exec($ch);
			curl_close($ch);
			$data = json_decode($g, true);
			
			$this -> tokenArr = $data['access_token'];
		}
		public function get_user_profile(){
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, FACEBOOK_GET_USERINFO_URL . '?access_token=' . $this -> tokenArr );
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt($ch, CURLOPT_COOKIE, '' );
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
			$g = curl_exec($ch);
			curl_close($ch);

			$data = json_decode($g, true);
			$this -> userInfo = array(
				'userID' => $data['id'],
				'nickname' => $data['name']
				/*,
				'age' => (string)$xml -> response -> age,
				'birth' => (string)$xml -> response -> birthday,
				'gender' => (string)$xml -> response -> gender,
				'profImg' => (string)$xml -> response -> profile_image
				*/
			);
		}
		public function get_userInfo(){
			return $this -> userInfo;
		}
	}
?>