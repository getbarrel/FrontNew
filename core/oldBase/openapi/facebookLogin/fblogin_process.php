<?

require './fblogin_setting.php';
require './common.php';
require './fblogin.php';

$request = new FacebookLogin( FACEBOOK_APP_ID, FACEBOOK_SECRET, FACEBOOK_LOGIN_URL );

$request -> call_accesstoken();
$request -> get_user_profile();
$User = $request->get_userInfo();

$fblogin = new fblogin();

if ($User) {
  try {

	if(!empty($User["userID"]) && !empty($User["nickname"])){

		session_unregister("fblogin");
		$result = $fblogin->goLogin($User["userID"]);

        $_SESSION["fblogin"]["userID"] = $User["userID"];
        $_SESSION["fblogin"]["nickname"] = $User["nickname"];

		if($result == true){
			//로그인 처리

			//$_SESSION["fbLogoutUrl"] = $logoutUrl;
			//$_SESSION["accesstoken"] = $accessToken;
			//echo "<script>opener.document.location.href='/';window.close();</script>";

			echo "<form name='loginForm' method='post' action='/member/login.php'>
				<input type='hidden' name='act' value='verify' />
			</form>
			<script type='text/javascript'>document.loginForm.submit();</script>
			";
			exit;
		}else{
			// userId와 nickname이 있을경우 SNS 계정연동 시작
			//$accessToken = $_SESSION["accesstoken"];
			echo "
				<script type='text/javascript'>
					if(confirm('아직 가입되지 않은 페이스북 ID입니다. SNS 회원가입을 진행하시겠습니까?')){
						location.href='/member/join_agreement.php';
					}else{
						location.href='/member/login.php';
					}
					//opener.document.getElementById('sns_type').value = 'facebook';
					//opener.snsConnect();
					//window.close();
				</script>
			";
			exit;

		}
	}else{
		echo "<script type='text/javascript'>location.href='/member/login.php';</script>";
		exit;
	}    
  } catch (FacebookApiException $e) {
    //error_log($e);
    //$fbUser = null;
	echo "<script type='text/javascript'>location.href='/member/login.php';</script>";
	exit;
  }
}else{
	echo "<script type='text/javascript'>location.href='/member/login.php';</script>";
	exit;
}
?>
