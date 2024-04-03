<?php
	define( 'KAKAO_OAUTH_AUTHORIZE_URL', 'https://kauth.kakao.com/oauth/authorize' );
	define( 'KAKAO_OAUTH_TOKEN_URL', 'https://kauth.kakao.com/oauth/token' );
	define( 'KAKAO_GET_USERINFO_URL', 'https://kapi.kakao.com/v1/user/me');
	class KakaoLogin{
		private $client_id;
		private $redirect_url;
		private $state;
		private $session;
		private $authorize_url = KAKAO_OAUTH_AUTHORIZE_URL;
		private $accesstoken_url = KAKAO_OAUTH_TOKEN_URL;
		private $code;
		private $tokenArr; 
		private $userInfo;

		function __construct( $client_id, $redirect_url, $mode=NULL) {
			$this -> client_id = $client_id;
			$this -> redirect_url = $redirect_url;
			
			if( $mode == "regist" ){
				$this -> state = 1;
			}else{
				$this -> state = 2;
			}

			if(!isset($_SESSION)) {
				session_start();
			}
		}
		/*
		private function generate_state(){
			$mt = microtime();
			$rand = mt_rand();
			$this -> state = md5( $mt . $rand );
		}
		public function set_state(){
			$this -> generate_state();
			return $this -> state;
		}
		*/
		private function get_code(){
			$this -> code = $_GET['code'];
		}
		private function get_state(){
			//$this -> state = $_SESSION['state'];
			return $this -> state;
		}
		public function request_auth(){
			return $this -> get_request_url();
		}
		public function get_request_url(){
			return $this -> authorize_url . '?response_type=code&client_id=' . $this -> client_id . '&state='.$this -> state.'&redirect_uri=' . urlencode($this -> redirect_url); 
		}
		public function get_accesstoken_url(){
			return $this -> accesstoken_url . '?grant_type=authorization_code&client_id=' . $this -> client_id . '&redirect_uri=' . urlencode($this -> redirect_url).'&code=' . $this -> code;
		}
		public function call_accesstoken(){
			$this -> get_code();
			$this -> get_state();
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $this -> get_accesstoken_url() );
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt($ch, CURLOPT_COOKIE, '' );
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
			$g = curl_exec($ch);
			curl_close($ch);
			$data = json_decode($g, true);
			$this -> tokenArr = array(
				 'Authorization: '.$data['token_type'].' '.$data['access_token']
			);
		}
		public function get_user_profile(){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, KAKAO_GET_USERINFO_URL );
			curl_setopt($ch, CURLOPT_HTTPHEADER, $this -> tokenArr );
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt($ch, CURLOPT_COOKIE, '' );
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
			$g = curl_exec($ch);
			curl_close($ch);
			
			$data = json_decode($g, true);

			$this -> userInfo = array(
				'userID' => $data['kaccount_email'] ,
				'nickname' => $data['properties']['nickname']
				/*
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