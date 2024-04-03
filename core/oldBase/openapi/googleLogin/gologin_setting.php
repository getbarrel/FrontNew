<?php

if($_SERVER["HTTP_HOST"] == "attive.kr" || $_SERVER["HTTP_HOST"] == "m.attive.kr"){
	//운영서버
	define('GOOGLE_CLIENT_ID','800005160062496');
	define('GOOGLE_CLIENT_SECRET','a7fb17d704948c398623361a9c90baeb');
}else{
	//개발서버
	define('GOOGLE_CLIENT_ID','276932627043-3up1o0jvp5op0iq9aun4544fhcdu33tc.apps.googleusercontent.com');
	define('GOOGLE_CLIENT_SECRET','uUJUdPdP0xGPqJgqegttc98M');
}

define('GOOGLE_REGISTER_URL',"http://".$_SERVER["HTTP_HOST"]."/openapi/googleLogin/goregister_process.php");
define('GOOGLE_LOGIN_URL',"http://".$_SERVER["HTTP_HOST"]."/openapi/googleLogin/gologin_process.php");

?>