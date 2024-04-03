<?php

include "./gologin.php";
include "./gologin_setting.php";
require_once ($_SERVER["DOCUMENT_ROOT"]."/openapi/googleLogin/common.php");

$request = new GoogleLogin( GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REGISTER_URL);

$request -> call_accesstoken();
$request -> get_user_profile();
$User = $request->get_userInfo();
$gologin = new gologin();

$successLocationScript = "location.href='/member/join_agreement.php';";
$cancelLocationScript = "location.href='/member/join_select.php';";
$loginLocationScript = "location.href='/member/login.php';";

if ($User) {
	
	if(!empty($User["userID"]) && !empty($User["nickname"])){

		//[S] 사이트에 등록된 아이디인지 체크
		session_unregister("gologin"); // 세션 초기화
		
		if($gologin->idDupCheck($User["userID"])){
			// 등록되지 않은 naver id라면 naver id 정보 세션 저장

			$_SESSION["gologin"]["userID"] = $User["userID"];
			$_SESSION["gologin"]["nickname"] = $User["nickname"];

			$addScript = $successLocationScript;

		}else{
			// 이미 등록된 naver id라면
			$addScript = "alert('이미 연동되어있는 구글 아이디입니다.');".$loginLocationScript;
		}
		//[E] 사이트에 등록된 아이디인지 체크
	}else{
		//로그인 실패 처리
		$addScript = "alert('인증에 실패했습니다. 다시 시도해주시기 바랍니다.');".$cancelLocationScript;
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
