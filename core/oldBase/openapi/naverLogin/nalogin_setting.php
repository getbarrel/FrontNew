<?php

if($_SERVER["HTTP_HOST"] == "attive.kr" || $_SERVER["HTTP_HOST"] == "m.attive.kr"){
	//운영서버
	define('NAVER_CLIENT_ID','800005160062496');
	define('NAVER_CLIENT_SECRET','a7fb17d704948c398623361a9c90baeb');
}else{
	//개발서버
	define('NAVER_CLIENT_ID','XTvrJi4sz9SPGDJSYXis');
	define('NAVER_CLIENT_SECRET','Gcq8F4NtfB');
}

define('NAVER_REGISTER_URL',"http://".$_SERVER["HTTP_HOST"]."/openapi/naverLogin/naregister_process.php");
define('NAVER_LOGIN_URL',"http://".$_SERVER["HTTP_HOST"]."/openapi/naverLogin/nalogin_process.php");


?>