<?php

include "./kakaologin.php";
include "./kakaologin_setting.php";
require_once ($_SERVER["DOCUMENT_ROOT"]."/openapi/kakaoLogin/common.php");


$processType = ($_GET["state"] == 1 ? "regist" : "login");

$request = new KakaoLogin( KAKAO_REST_API_KEY, KAKAO_REDIRECT_URL, $processType);

$request -> call_accesstoken();
$request -> get_user_profile();
$User = $request->get_userInfo();

$kalogin = new kalogin();

$successLocationScript = "location.href='/member/join_agreement.php';";
$cancelLocationScript = "location.href='/member/join_select.php';";
$loginLocationScript = "location.href='/member/login.php';";

if ($User) {
	if(!empty($User["userID"]) && !empty($User["nickname"])){
		
		session_unregister("kalogin"); // 세션 초기화
		
		if($processType == "regist"){
			//[S] 사이트에 등록된 아이디인지 체크
			if($kalogin->idDupCheck($User["userID"])){
				// 등록되지 않은 naver id라면 naver id 정보 세션 저장
				
				$_SESSION["kalogin"]["userID"] = $User["userID"];
				$_SESSION["kalogin"]["nickname"] = $User["nickname"];

				$addScript = $successLocationScript;

			}else{
				// 이미 등록된 naver id라면
				$addScript = "alert('이미 연동되어있는 카카오 아이디입니다.');".$loginLocationScript;
			}
			//[E] 사이트에 등록된 아이디인지 체크
		}else if($processType == "login"){
			$result = $kalogin->goLogin($User);

            $_SESSION["kalogin"]["userID"] = $User["userID"];
            $_SESSION["kalogin"]["nickname"] = $User["nickname"];

			if($result == true){

				//로그인 처리
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
						if(confirm('아직 가입되지 않은 카카오 ID입니다. SNS 회원가입을 진행하시겠습니까?')){
							location.href='/member/join_agreement.php';
						}else{
							location.href='/member/login.php';
						}
						//opener.document.getElementById('sns_type').value = 'naver';
						//opener.snsConnect();
						//window.close();
					</script>
				";
				exit;
			}
		}else{
			$addScript = "alert('잘못된 접근입니다.');".$cancelLocationScript;
		}
	}else{
        //로그인 실패 처리
        if($processType == "regist"){
            $addScript = "alert('인증에 실패했습니다. 다시 시도해주시기 바랍니다.');".$cancelLocationScript;
        }else{
            $addScript = "alert('인증에 실패했습니다. 다시 시도해주시기 바랍니다.');".$loginLocationScript;
        }
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
