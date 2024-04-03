<?php

if($_SERVER["HTTP_HOST"] == "attive.kr" || $_SERVER["HTTP_HOST"] == "m.attive.kr"){
	//운영서버
	define('FACEBOOK_APP_ID','800005160062496');
	define('FACEBOOK_SECRET','a7fb17d704948c398623361a9c90baeb');
}else{
	//개발서버
	define('FACEBOOK_APP_ID','169906073570661');
	define('FACEBOOK_SECRET','3388a20bfeac6aa7f04ecfefb7bd680a');
}

define('FACEBOOK_REGIST_URL',"http://".$_SERVER["HTTP_HOST"]."/openapi/facebookLogin/fbregister_process.php");
define('FACEBOOK_LOGIN_URL',"http://".$_SERVER["HTTP_HOST"]."/openapi/facebookLogin/fblogin_process.php");
//define('FACEBOOK_LOGOUT_URL',"http://".$_SERVER["HTTP_HOST"]."/openapi/facebookLogin/fblogout.php");
//define('FACEBOOK_LOGOUT_URL',"http://".$_SERVER["HTTP_HOST"]."/member/logout.php");

define('FACEBOOK_API_VERSION', 'v2.8');

?>