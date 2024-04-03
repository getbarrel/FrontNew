<?php

include "./nalogin.php";
include "./nalogin_setting.php";
require_once ($_SERVER["DOCUMENT_ROOT"]."/openapi/naverLogin/common.php");

$request = new OAuthRequest( NAVER_CLIENT_ID, NAVER_CLIENT_SECRET, "");

$request -> call_accesstoken();
$request -> get_user_profile();
$naUser = $request->get_userInfo();
$nalogin = new nalogin();

$successLocationScript = "location.href='/member/join_agreement.php';";
$cancelLocationScript = "location.href='/member/join_select.php';";
$loginLocationScript = "location.href='/member/login.php';";

if ($naUser) {
	
	if(!empty($naUser["userID"]) && !empty($naUser["nickname"])){

		//[S] 사이트에 등록된 아이디인지 체크
		session_unregister("nalogin"); // 세션 초기화
		
		if($nalogin->idDupCheck($naUser["userID"])){
			// 등록되지 않은 naver id라면 naver id 정보 세션 저장

			$_SESSION["nalogin"]["userID"] = $naUser["userID"];
			$_SESSION["nalogin"]["nickname"] = $naUser["nickname"];

			$addScript = $successLocationScript;

		}else{
			// 이미 등록된 naver id라면
			$addScript = "alert('이미 연동되어있는 네이버 아이디입니다.');".$loginLocationScript;
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
