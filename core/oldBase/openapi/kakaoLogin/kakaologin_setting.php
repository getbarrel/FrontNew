<?php

if($_SERVER["HTTP_HOST"] == "attive.kr" || $_SERVER["HTTP_HOST"] == "m.attive.kr"){
	//운영서버
	define('KAKAO_REST_API_KEY','6c52a7f9221e083bee6974b4ab9cc2d1');
}else{
	//개발서버
	define('KAKAO_REST_API_KEY','6c52a7f9221e083bee6974b4ab9cc2d1');
}

define('KAKAO_REDIRECT_URL',"http://".$_SERVER["HTTP_HOST"]."/openapi/kakaoLogin/oauth.php");

?>