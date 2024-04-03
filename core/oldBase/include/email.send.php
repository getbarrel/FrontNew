<?php
function charset_transform($content) {
	if($content!="") {
		$return_con="";
		$sub = imap_mime_header_decode($content);// $sub 디코딩된 데이터는 배열로 저장됩니다. 제목이 한종류이상의 코드로 인코딩되어있을수도 있지요.
		for($i=0;$i<count($sub);$i++){
			switch(strtolower($sub[$i]->charset)){
				case 'default': // 코드 지정안하고 들어오는 메일은 euc-kr 로 오는 경우가 많음. 좀 더 똘똘한 코드를 만들려면 메일원문에 지정된 charset 을 가져와서 쓰면 맞을 확율이 높습니다.
				case 'ks_c_5601-1987':
					$sub[$i]->charset='euc-kr'; // iconv에서는 euc-kr 로 지정해줍니다.
					$return_con .= iconv("utf-8",$sub[$i]->charset,$sub[$i]->text);
					break; // php의 switch문은 순차적으로 내려가니까 멈춰주시고
				case 'utf-8':
					$return_con .= $sub[$i]->text;
					break;
				default :
					$return_con .= $sub[$i]->text;
					break;
			}
		}
		return $return_con;
	} else {
		return "";
	}
}

function SendMail($minfo, $subject, $email_contents_basic="", $file_path="", $admin_send_yn="", $user_send_yn="Y"){//$user_send_yn="" 인 것을 $user_send_yn="Y" 로 변경함 kbk 13/09/17
	global $user, $DOCUMENT_ROOT, $install_path,$_SERVER;

	include_once($_SERVER["DOCUMENT_ROOT"]."/include/mail_smtp.php");

	$email_contents = str_replace("{oid}",$minfo[oid],$email_contents_basic);
	$email_contents = str_replace("{vb_info}",$minfo[vb_info],$email_contents);
	$email_contents = str_replace("{mem_id}",$minfo[mem_id],$email_contents);
	$email_contents = str_replace("{mem_name}",$minfo[mem_name],$email_contents);
	$email_contents = str_replace("{receive_name}",$minfo[receive_name],$email_contents);
	$email_contents = str_replace("{order_card_name}","&nbsp;:&nbsp;". $minfo[card_name],$email_contents);
	$email_contents = str_replace("{order_status}",$minfo[order_status],$email_contents);
	$email_contents = str_replace("{regist_date}",$minfo[rest_day],$email_contents);

	$email_contents = str_replace("{send_year}",date("Y"),$email_contents);
	$email_contents = str_replace("{send_month}",date("m"),$email_contents);
	$email_contents = str_replace("{send_day}",date("d"),$email_contents);
	$email_contents = str_replace("{send_hour}",date("H"),$email_contents);
	$email_contents = str_replace("{send_minute}",date("i"),$email_contents);
	$email_contents = str_replace("{send_second}",date("s"),$email_contents);

	$subject = str_replace("{mem_id}",$minfo[mem_id],$subject);
	$subject = str_replace("{mem_name}",$minfo[mem_name],$subject);
	$email_contents = str_replace("{mem_type}",$minfo[mem_type],$email_contents);
    
    $cominfo = getcominfo();
	$subject = str_replace("{shop_name}",$cominfo[com_name],$subject);


	$email_contents = str_replace("dev.forbiz.co.kr",$_SERVER["HTTP_HOST"],$email_contents);
	$email_contents = str_replace("/data/basic/images",$_SESSION["layout_config"]["mall_image_path"],$email_contents);
	$email_contents = str_replace("{shop_name}",$cominfo[com_name],$email_contents);
	$email_contents = str_replace("{contents}",$minfo[contents],$email_contents);

	$email_contents = str_replace("{bbs_div}",$minfo[bbs_div],$email_contents);//1:1문의 분류정보 kbk 12/06/28


/*
	$cominfo[com_name]
	$cominfo[com_addr]
	$cominfo[com_phone]
	$cominfo[com_ceo]
	$cominfo[charer_email]
*/

	/*if($admin_send_yn == "Y"){
		$recipients = $minfo[mem_mail].", ".$cominfo[com_email];		// 받는사람(An array or comma seperated string of recipients.)
	}else{
		$recipients = $minfo[mem_mail];		// 받는사람(An array or comma seperated string of recipients.)
	}*/
	//[Start] 사용자, 관리자 메일 발송 수정 kbk 13/08/12
	$recipients="";
	if($user_send_yn=="Y") $recipients = $minfo[mem_mail];
	if($admin_send_yn == "Y"){
		if($recipients=="") $recipients = $cominfo[com_email];
		else $recipients .= ", ".$cominfo[com_email];
	}
	//[End] 사용자, 관리자 메일 발송 수정 kbk 13/08/12

	if($minfo[mail_cc]){
		$recipients .= ",".$minfo[mail_cc];
	}
	//$recipients = "test_to@passkorea.net, test_to2@passkorea.net, test_to3@passkorea.net";		// An array or comma seperated string of recipients.
	$to =$minfo[mem_name]."<".$minfo[mem_mail].">";

	$from = "\"".$cominfo[shop_name]."\"<".$cominfo[com_email].">";

	$body = $email_contents;
	$body_type = "HTML";		// HTML, TXT

	if($file_path){
		$file = $file_path;		// 첨부파일 경로및 파일명
		$file_name = basename($file_path);		// 첨부파일명
	}else{
		$file = NULL;		// 첨부파일 경로및 파일명
		$file_name = NULL;		// 첨부파일명
	}
	$host = "localhost";		// SMTP Address

	//if($file){
		//echo $from." ".$cominfo[com_email]." $to 에게 정상적으로 메일이 발송 됐습니다 $recipients";


		$recipients = iconv('UTF-8','EUC-KR',$recipients);
		$to = iconv('UTF-8','EUC-KR',$to);
		$from = iconv('UTF-8','EUC-KR',$from);

		/*
		//20131112 Hong 인코딩시 변환할수 없는 문자를 만나면 뒤에 짤리는 현상 방지를 위하여 //IGNORE 추가
		$subject = iconv('UTF-8','EUC-KR//IGNORE',$subject);
		$body = iconv('UTF-8','EUC-KR//IGNORE',$body);
		*/

		//20141006 Hong 인코딩시 변환할수 없는 문자를 만나면 뒤에 짤리는 현상 방지를 위하여 //TRANSLIT 추가
		$subject = iconv('UTF-8','EUC-KR//TRANSLIT',$subject);
		$body = iconv('UTF-8','EUC-KR//TRANSLIT',$body);

		$body_type = iconv('UTF-8','EUC-KR',$body_type);

		/*$recipients = charset_transform($recipients);
		$to = charset_transform($to);
		$from = charset_transform($from);
		$subject = charset_transform($subject);
		$body = charset_transform($body);
		$body_type = charset_transform($body_type);*/

		if(substr_count($minfo[mem_mail],"@gmail")){
			//mail($to, $subject, $body, null, $from);
			//mail_utf8($to, $cominfo[shop_name], $cominfo[com_email], $subject, $body);

			$headers = "From: ".iconv('UTF-8','EUC-KR',$cominfo[shop_name])." <".$cominfo[com_email].">\r\n".
            	            "MIME-Version: 1.0" . "\r\n" .
             				"Content-type: text/html; " . "\r\n";

			if(mail($to, $subject, $body, $headers)){
                //if(mail('isntsheinfo<isnt-she_info@cchan.tv>', $subject, $body, $headers)){
                return true;
			}else{
				return false;
			}

			//echo "<script language='javascript'>alert('구글메일');</script>";
			//exit;
		}else{
			if(mail_smtp($recipients, $to, $from, $subject, $body, $body_type, $file, $file_name, $host)){
                // cchan 으로 같이 보낼 메일 추가 20170627 장세현
                //if(mail_smtp('isnt-she_info@cchan.tv', 'isntsheinfo<isnt-she_info@cchan.tv>', $from, $subject, $body, $body_type, $file, $file_name, $host)){
                return true;
			}else{
				return false;
			}
		}
	/*}else{
		if(shop_sendmail(1, $recipients, $minfo[mem_name], $cominfo[charger_email], $cominfo[com_name], $subject, $body)){
			return true;
		}else{
			return false;
		}
	}
	*/
}

function mail_utf8($to, $from_user, $from_email,
                                             $subject = '(No subject)', $message = '')
    {
      $from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
       $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

      $headers = "From: $from_user <$from_email>\r\n".
               "MIME-Version: 1.0" . "\r\n" .
               "Content-type: text/html; charset=UTF-8" . "\r\n";

     return mail($to, $subject, $message, $headers);
   }


// 메일 보내는 함수
function shop_sendmail($type, $to, $to_name, $from, $from_name, $subject, $comment, $cc="", $bcc="") {
	$recipient = "$to_name <$to>";

	//if($type==1) $comment = nl2br($comment);

	$headers = "From: $from_name <$from>\n";
	$headers .= "X-Sender: <$from>\n";
	$headers .= "X-Mailer: PHP ".phpversion()."\n";
	$headers .= "X-Priority: 1\n";
	$headers .= "Return-Path: <$from>\n";

	if(!$type) $headers .= "Content-Type: text/plain; ";
	else $headers .= "Content-Type: text/html; ";
	$headers .= "charset=utf-8\n";

	if($cc)  $headers .= "cc: $cc\n";
	if($bcc)  $headers .= "bcc: $bcc";

	$comment = stripslashes($comment);
	$comment = str_replace("\n\r","\n", $comment);

	return mail($recipient , $subject , $comment , $headers);

}

