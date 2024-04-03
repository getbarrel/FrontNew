<?php

require './fblogin_setting.php';
require './common.php';
require './fblogin.php';

$request = new FacebookLogin( FACEBOOK_APP_ID, FACEBOOK_SECRET, FACEBOOK_REGIST_URL );

$request -> call_accesstoken();
$request -> get_user_profile();
$User = $request->get_userInfo();

$fblogin = new fblogin();

$successLocationScript = "location.href='/member/join_agreement.php';";
$cancelLocationScript = "location.href='/member/join_select.php';";
$loginLocationScript = "location.href='/member/login.php';";

if ($User) {
  try {

	if(!empty($User["userID"]) && !empty($User["nickname"])){
		//[S] 사이트에 등록된 아이디인지 체크
		session_unregister("fblogin");
		if($fblogin->idDupCheck($User["userID"])){

			$_SESSION["fblogin"]["userID"] = $User["userID"];
			$_SESSION["fblogin"]["nickname"] = $User["nickname"];

			//$msg = "정상적으로 인증되었습니다.";
			//$addScript = "opener.btn_facebook.classList.add('fb');";
			$addScript = $successLocationScript;

		}else{
			// 이미 등록된 facebook id라면
			$addScript = "alert('이미 연동되어있는 페이스북 아이디입니다.');".$loginLocationScript;
		}
	}else{
		//로그인 실패 처리
		$addScript = "alert('인증에 실패했습니다. 다시 시도해주시기 바랍니다.');".$cancelLocationScript;
	}
  } catch (FacebookApiException $e) {
    //error_log($e);
    //$fbUser = null;
	$addScript = $cancelLocationScript;
  }
}else{
	$addScript = $cancelLocationScript;
}

echo "
	<script type='text/javascript'>
		".$addScript."
	</script>
";
exit;

?>
