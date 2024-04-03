<?

include "./gologin.php";
include "./gologin_setting.php";
require_once ($_SERVER["DOCUMENT_ROOT"]."/openapi/googleLogin/common.php");

$request = new GoogleLogin( GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_LOGIN_URL);

$request -> call_accesstoken();
$request -> get_user_profile();
$User = $request->get_userInfo();
$gologin = new gologin();

$cancelLocationScript = "location.href='/member/join_select.php';";
$loginLocationScript = "location.href='/member/login.php';";

if ($User) {
	
	if( ! empty($User["userID"]) ){

		session_unregister("gologin");
		//$accessToken = $_SESSION["accesstoken"];

		$result = $gologin->goLogin($User);

        $_SESSION["gologin"]["userID"] = $User["userID"];
        $_SESSION["gologin"]["nickname"] = $User["nickname"];

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
					if(confirm('아직 가입되지 않은 구글 ID입니다. SNS 회원가입을 진행하시겠습니까?')){
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
		//로그인 실패 처리
		echo "<script>alert('개인정보동의를 해야 서비스 이용이 가능합니다.')</script>";
		echo "<script>location.href='/member/login.php';</script>";
		exit;
	}
}else{
	echo "<script>alert('인증에 실패했습니다. 다시 시도해주시기 바랍니다.')</script>";
	echo "<script>location.href='/member/login.php';</script>";
	//echo "<script>window.close();</script>";
	exit;
}
?>
