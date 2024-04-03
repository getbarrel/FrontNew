<?
include_once($_SERVER["DOCUMENT_ROOT"]."/include/dir.manage.php");
//include_once($_SERVER["DOCUMENT_ROOT"]."/bbs/bbs.config.php");
include($_SERVER["DOCUMENT_ROOT"]."/admin/lib/imageResize.lib.php");
if($act){	
$msb = new Blog($bbs_table_name);
$msb->MsBoardConfigration();
$msb->bbs_admin_mode = $admin_mode;
$msb->BoardAuth($_POST["act"]);


	if(!eregi($_SERVER["HTTP_HOST"],$_SERVER["HTTP_REFERER"])) Error("정상적으로 글을 작성하여 주시기 바랍니다.");
	if(getenv("REQUEST_METHOD") == 'GET' ) Error("정상적으로 글을 쓰시기 바랍니다","");	
}
//session_start();
$db = new Database();
//$db->debug = true;
if($admin_mode){
	$bbs_user_code = $_SESSION[admininfo][company_id];
}else{
	$bbs_user_code = $user[code];
}

// 2009-03-19 스팸 차단을 위해 추가된 부분
if($act){
	$db->query("SELECT * FROM bbs_spam_config where spam_usable = 1 limit 1 ");
	$db->fetch();
	
	if($db->total){	
		$db->fetch();
	
		$spam_check_bool = false;
		$ip_check_bool = false;
		if($db->dt[spam_word] != ""){
			$spam_words = split(",",$db->dt[spam_word]);
		}else{
			$spam_words = "";
		}
		//$spam_words = $db->dt[spam_word];
		if($db->dt[block_ip] != ""){
			$block_ips = split(",",$db->dt[block_ip]);
		}else{
			$block_ips = "";
		}

		if($block_ips != ""){
			if(is_array($block_ips)){
				for($i=0;$i < count($block_ips);$i++){
					//echo $block_ips[$i];
					if(substr_count($_SERVER["REMOTE_ADDR"],substr_replace("*","",$block_ips[$i]))){
						$ip_check_bool = true;
					}
				}
			}
			if($ip_check_bool){
				echo "<Script>alert('차단된 IP 주소 입니다.  확인후 다시 시도해주세요 . 계속해서 문제가 될 경우 고객센타로 문의주시기 바랍니다.');document.location.href='?mode=list&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&bbs_div=$bbs_div';</Script>"; 
				exit;
			}
		}
		
		if($spam_words != ""){
			if(is_array($spam_words)){
				foreach ($_POST as $key => $val) {
					if($val){
						for($i=0;$i < count($spam_words);$i++){
							//echo $val;
							if(substr_count($val,str_replace("\r\n","",$spam_words[$i]))){
							//print "Key $key, Value $val\n";
							$spam_check_bool = true;
						}
					}
				  }
				}
			}

			if($spam_check_bool){
				echo "<Script>alert('스팸문자가 포함되어 글 등록이 차단되었습니다. 확인후 다시 시도해주세요 . 계속해서 문제가 될 경우 고객센타로 문의주시기 바랍니다.');document.location.href='?mode=list&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&bbs_div=$bbs_div';</Script>"; 
				exit;
			}
		}
	}
}
// 2009-03-19 스팸 차단을 위해 추가된 부분

//echo $_SESSION["security_code"];
//exit;
if($act == "insert"){
	if($antispam_yn == "Y"){
		if($_SESSION["security_code"] != $_POST["security_code2"]){
			echo "<script>alert('입력한 코드문자가 틀립니다. 다시한번 작성하시기 바랍니다.');</script>";
			exit;
		}
	}
	$bbs_file_1 = $HTTP_POST_FILES[bbs_file_1][tmp_name];
	$bbs_file_1_name = $HTTP_POST_FILES[bbs_file_1][name];
	$bbs_file_1_size = $HTTP_POST_FILES[bbs_file_1][size];
	$bbs_file_1_type = $HTTP_POST_FILES[bbs_file_1][type];
		
	$bbs_file_2 = $HTTP_POST_FILES[bbs_file_2][tmp_name];
	$bbs_file_2_name = $HTTP_POST_FILES[bbs_file_2][name];
	$bbs_file_2_size = $HTTP_POST_FILES[bbs_file_2][size];
	$bbs_file_2_type = $HTTP_POST_FILES[bbs_file_2][type];
	
	$bbs_file_3 = $HTTP_POST_FILES[bbs_file_3][tmp_name];
	$bbs_file_3_name = $HTTP_POST_FILES[bbs_file_3][name];
	$bbs_file_3_size = $HTTP_POST_FILES[bbs_file_3][size];
	$bbs_file_3_type = $HTTP_POST_FILES[bbs_file_3][type];
	
	
	$db->query("select IFNULL(max(bbs_ix),0) as bbs_ix from blog_bbs  ");
	if($db->total){
		$db->fetch();
		$bbs_ix = $db->dt[bbs_ix] + 1;
	}else{
		$bbs_ix = 0;
	}
	
	if ($bbs_parent_ix == ""){
		$bbs_parent_ix = 0;
	}	
	if ($bbs_ix_level == ""){
		$bbs_ix_level = 0;
	}
	
	
	/*$sql = "select IFNULL(max(bbs_ix_step )+1,1) as bbs_ix_step from blog_bbs where bbs_top_ix =  ". $bbs_parent_ix;
	$db->query($sql);
	if($db->total){
		$db->fetch();
		$bbs_ix_step = $db->dt[bbs_ix_step];
	}else{
		$bbs_ix_step = 0;
	}
	
	$sql = "select IFNULL(max(bbs_ix_level )+1,0) as bbs_ix_level from blog_bbs where bbs_top_ix = ". $bbs_parent_ix ." and bbs_ix_level = ".$bbs_ix_level;
	$db->query($sql);
	if($db->total){
		$db->fetch();
		$bbs_ix_level = $db->dt[bbs_ix_level];
	}else{
		$bbs_ix_level = 0;
	}*/

	/*스팸글 방지위해 만듬 시작*/
	$bbs_user = $_SERVER["REMOTE_ADDR"]."\t".$_SERVER["HTTP_USER_AGENT"]."\t".date("Y-m-d H:i:s")."\t".$_COOKIE["C_TOKEN"]."\t".$bbs_subject."\r\n";
	
	//print_r($_POST);	
	$fp = fopen($bbs_data_dir."/bbs_writer.txt","a+");
	fwrite($fp,$bbs_user);
	fclose($fp);

	if($focus_info != 'Y' || $_SERVER["HTTP_REFERER"] == ""){
		echo "<script>alert('스팸체크1');</script>";//history.go(-1);
		exit;
	}
	
	
	if($_COOKIE["C_TOKEN"] != $token || $_COOKIE["C_TOKEN"] == ""){
		echo "<script>alert('스팸체크2');</script>";//history.go(-1);
		exit;
	}
	/*스팸글 방지위해 만듬 끝*/
	
	if(!$is_html){
		$is_html = "Y";
	}

	$sql = "insert into blog_bbs (bbs_ix,bgbm_ix, bbs_div,sub_bbs_div, mem_ix,bbs_subject,bbs_name,bbs_pass,bbs_email,bbs_contents,bbs_top_ix, bbs_ix_level, bbs_ix_step, bbs_hidden, bbs_file_1,bbs_file_2,bbs_file_3, bbs_etc1,bbs_etc2,bbs_etc3,bbs_etc4,bbs_etc5,is_notice, is_html, ip_addr, regdate) 
			values 
			('$bbs_ix','$bgbm_ix','$bbs_div','$sub_bbs_div','".$bbs_user_code."','$bbs_subject','$bbs_name','$bbs_pass','$bbs_email','$bbs_contents','$bbs_ix','$bbs_ix_level','$bbs_ix_step','$bbs_hidden','$bbs_file_1_name','$bbs_file_2_name','$bbs_file_3_name','$bbs_etc1','$bbs_etc2','$bbs_etc3','$bbs_etc4','$bbs_etc5','$is_notice','$is_html','".$_SERVER["REMOTE_ADDR"]."',NOW())";

//	$sql = "insert into blog_bbs (bbs_ix,bbs_div,mem_ix,bbs_subject,bbs_name,bbs_pass,bbs_email,bbs_contents,bbs_hidden, bbs_file_1,bbs_file_2,bbs_file_3, bbs_etc1,bbs_etc2,bbs_etc3,bbs_etc4,bbs_etc5, regdate) 
//			values 
//			('','$bbs_div','".$bbs_user_code."','$bbs_subject','$bbs_name','$bbs_pass','$bbs_email','$bbs_contents','$bbs_hidden','$bbs_file_1_name','$bbs_file_2_name','$bbs_file_3_name','$bbs_etc1','$bbs_etc2','$bbs_etc3','$bbs_etc4','$bbs_etc5',NOW())";
	
	$db->query($sql);	
	//$db->query("Select bbs_ix from blog_bbs where bbs_ix = LAST_INSERT_ID()");	
	$db->query("Select bbs_ix from blog_bbs where bbs_ix = '$bbs_ix' ");	
	
	//echo "Select bbs_ix from blog_bbs where bbs_ix = $bbs_ix ";
	
	$db->fetch(0);
	$bbs_ix = $db->dt[bbs_ix];
	$path = $bbs_data_dir;
	
	if(!is_dir($path."/$bbs_table_name")){
		
		if(is_writable($path)){
			mkdir($path."/$bbs_table_name", 0777);
			chmod($path."/$bbs_table_name", 0777);	
		}
	}
	
	$path = $bbs_data_dir."/$bbs_table_name";
	if(!is_dir($path."/".$bbs_ix)){
		
		if(is_writable($path)){
			//echo $path."/".$bbs_ix;
			mkdir($path."/$bbs_ix", 0777);
			chmod($path."/$bbs_ix", 0777);	
		}
	}
	
	//$path = $bbs_data_dir."/$bbs_table_name/0012";
	$path = $bbs_data_dir."/$bbs_table_name/$bbs_ix";
//	echo $path;
//	exit;
	if(is_dir($path)){
		
		if ($bbs_file_1_size > 0){
			move_uploaded_file($bbs_file_1, $path."/".iconv("utf-8","CP949",$bbs_file_1_name));
		}
	
		if ($bbs_file_2_size > 0){
			move_uploaded_file($bbs_file_2, $path."/".iconv("utf-8","CP949",$bbs_file_2_name));
		}
		
		if ($bbs_file_3_size > 0){
			move_uploaded_file($bbs_file_3, $path."/".iconv("utf-8","CP949",$bbs_file_3_name));
		}
		/*썸네일 이미지 생성 시작*/
		$image_info = getimagesize ($path."/".iconv("utf-8","CP949",$bbs_file_1_name));
		$image_type = substr($image_info['mime'],-3);

		$db->query("select board_thumbnail_yn,thum_width,thum_height from bbs_manage_config where board_ename = '".$board."'");
		$db->fetch();
		$board_thumbnail_yn = $db->dt[board_thumbnail_yn];
		$thum_width = $db->dt[thum_width];
		$thum_height = $db->dt[thum_height];

		if($board_thumbnail_yn == "Y"){
			if($image_type == "gif" || $image_type == "GIF"){
				if($bbs_file_1_size > 0){
					MirrorGif($path."/".iconv("utf-8","CP949",$bbs_file_1_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_1_name), MIRROR_NONE);
					resize_gif($path."/s_".iconv("utf-8","CP949",$bbs_file_1_name),$thum_width,$thum_height);
				}
				if($bbs_file_2_size > 0){
					MirrorGif($path."/".iconv("utf-8","CP949",$bbs_file_2_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_2_name), MIRROR_NONE);
					resize_gif($path."/s_".iconv("utf-8","CP949",$bbs_file_2_name),$thum_width,$thum_height);
				}
				if($bbs_file_3_size > 0){
					MirrorGif($path."/".iconv("utf-8","CP949",$bbs_file_3_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_3_name), MIRROR_NONE);
					resize_gif($path."/s_".iconv("utf-8","CP949",$bbs_file_3_name),$thum_width,$thum_height);
				}
			}else{
				if($bbs_file_1_size > 0){
					Mirror($path."/".iconv("utf-8","CP949",$bbs_file_1_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_1_name), MIRROR_NONE);
					resize_jpg($path."/s_".iconv("utf-8","CP949",$bbs_file_1_name),$thum_width,$thum_height);
				}
				if($bbs_file_2_size > 0){
					Mirror($path."/".iconv("utf-8","CP949",$bbs_file_2_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_2_name), MIRROR_NONE);
					resize_jpg($path."/s_".iconv("utf-8","CP949",$bbs_file_2_name),$thum_width,$thum_height);
				}
				if($bbs_file_3_size > 0){
					Mirror($path."/".iconv("utf-8","CP949",$bbs_file_3_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_3_name), MIRROR_NONE);
					resize_jpg($path."/s_".iconv("utf-8","CP949",$bbs_file_3_name),$thum_width,$thum_height);
				}
			}
		}
		/*썸네일 이미지 생성 끝*/
	}
	/*
	$data_text = $popup_text;
	$data_text_convert = $popup_text;
	$data_text_convert = str_replace("\\","",$data_text_convert);
	preg_match_all("|<IMG .*src=\"(.*)\".*>|U",$data_text_convert,$out, PREG_PATTERN_ORDER);
	
	$LAST_ID = $popup_ix;
	//$path = $_SERVER["DOCUMENT_ROOT"]."".$admin_config[mall_data_root]."/images/popup/";
	


	for($i=0;$i < count($out);$i++){
		for($j=0;$j < count($out[$i]);$j++){
			
			$img = returnImagePath($out[$i][$j]);
			$img = ClearText($img);
			

			if(substr_count($img,$path) == 0){// 게시판 페이지에 있지 않으면 이미지를 복사한다 
				if(substr_count($img,"$HTTP_HOST")>0){	
					$local_img_path = str_replace("http://$HTTP_HOST",$_SERVER["DOCUMENT_ROOT"]."",$img);
					
					@copy($local_img_path,$path."/".returnFileName($img));
					if(substr_count($img,$admin_config[mall_data_root]."/images/upfile/") > 0){
						unlink($local_img_path);	
					}
					
					$data_text = str_replace($img,$admin_config[mall_data_root]."/images/popup/$LAST_ID/".returnFileName($img),$data_text);	 // 업로드된 파일들이 URL 에 관계 없이 보일수 있도록 URL 을  / 로 치환
				}else{
					if(copy($img,$_SERVER["DOCUMENT_ROOT"]."".$admin_config[mall_data_root]."/images/popup/$LAST_ID/".returnFileName($img))){
						$data_text = str_replace($img,$admin_config[mall_data_root]."/images/popup/$LAST_ID/".returnFileName($img),$data_text);	 // 업로드된 파일들이 URL 에 관계 없이 보일수 있도록 URL 을  / 로 치환	
					}
				}
			}			
		}
	}
	
	
	$db->query("UPDATE blog_bbs SET bbs_contents = '$data_text' WHERE bbs_ix='$bbs_ix'");
	*/

	//exit;
	echo "<Script>top.document.location.href='?mode=list&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&bbs_div=$bbs_div';</Script>"; 
}

if($act == "scrap"){
	if($antispam_yn == "Y"){
		if($_SESSION["security_code"] != $_POST["security_code2"]){
			echo "<script>alert('입력한 코드문자가 틀립니다. 다시한번 작성하시기 바랍니다.');</script>";
			exit;
		}
	}
	$bbs_file_1 = $HTTP_POST_FILES[bbs_file_1][tmp_name];
	$bbs_file_1_name = $HTTP_POST_FILES[bbs_file_1][name];
	$bbs_file_1_size = $HTTP_POST_FILES[bbs_file_1][size];
	$bbs_file_1_type = $HTTP_POST_FILES[bbs_file_1][type];
		
	$bbs_file_2 = $HTTP_POST_FILES[bbs_file_2][tmp_name];
	$bbs_file_2_name = $HTTP_POST_FILES[bbs_file_2][name];
	$bbs_file_2_size = $HTTP_POST_FILES[bbs_file_2][size];
	$bbs_file_2_type = $HTTP_POST_FILES[bbs_file_2][type];
	
	$bbs_file_3 = $HTTP_POST_FILES[bbs_file_3][tmp_name];
	$bbs_file_3_name = $HTTP_POST_FILES[bbs_file_3][name];
	$bbs_file_3_size = $HTTP_POST_FILES[bbs_file_3][size];
	$bbs_file_3_type = $HTTP_POST_FILES[bbs_file_3][type];
	
	//$scrap_bbs_ix = $bbs_ix;
	
	$db->query("select IFNULL(max(bbs_ix),0) as bbs_ix from blog_bbs  ");
	if($db->total){
		$db->fetch();
		$bbs_ix = $db->dt[bbs_ix] + 1;
	}else{
		$bbs_ix = 0;
	}
	
	if ($bbs_parent_ix == ""){
		$bbs_parent_ix = 0;
	}	
	if ($bbs_ix_level == ""){
		$bbs_ix_level = 0;
	}
	
	
	/*$sql = "select IFNULL(max(bbs_ix_step )+1,1) as bbs_ix_step from blog_bbs where bbs_top_ix =  ". $bbs_parent_ix;
	$db->query($sql);
	if($db->total){
		$db->fetch();
		$bbs_ix_step = $db->dt[bbs_ix_step];
	}else{
		$bbs_ix_step = 0;
	}
	
	$sql = "select IFNULL(max(bbs_ix_level )+1,0) as bbs_ix_level from blog_bbs where bbs_top_ix = ". $bbs_parent_ix ." and bbs_ix_level = ".$bbs_ix_level;
	$db->query($sql);
	if($db->total){
		$db->fetch();
		$bbs_ix_level = $db->dt[bbs_ix_level];
	}else{
		$bbs_ix_level = 0;
	}*/

	/*스팸글 방지위해 만듬 시작*/
	$bbs_user = $_SERVER["REMOTE_ADDR"]."\t".$_SERVER["HTTP_USER_AGENT"]."\t".date("Y-m-d H:i:s")."\t".$_COOKIE["C_TOKEN"]."\t".$bbs_subject."\r\n";
	
	//print_r($_POST);	
	$fp = fopen($bbs_data_dir."/bbs_writer.txt","a+");
	fwrite($fp,$bbs_user);
	fclose($fp);

	if($focus_info != 'Y' || $_SERVER["HTTP_REFERER"] == ""){
		echo "<script>alert('스팸체크1');</script>";//history.go(-1);
		exit;
	}
	
	/*
	if($_COOKIE["C_TOKEN"] != $token || $_COOKIE["C_TOKEN"] == ""){
		echo "<script>alert('스팸체크2');</script>";//history.go(-1);
		exit;
	}
	*/
	/*스팸글 방지위해 만듬 끝*/
	
	if(!$is_html){
		$is_html = "Y";
	}

	$sql = "insert into blog_bbs select '$bbs_ix' as bbs_ix,'$bgbm_ix' as bgbm_ix,bbs_div,sub_bbs_div,'".$bbs_user_code."' as mem_ix,concat('[스크랩]',bbs_subject) as bbs_subject,'' as bbs_name,bbs_pass,bbs_email,bbs_contents,bbs_hidden,bbs_top_ix,
					bbs_ix_level,bbs_ix_step,bbs_hit,bbs_down_cnt,bbs_re_cnt,bbs_file_1,bbs_file_2,bbs_file_3,'$bbs_etc1' as bbs_etc1,'$bbs_etc2' as bbs_etc2,'$bbs_etc3' as bbs_etc3, '$bbs_etc4' as  bbs_etc4, '$bbs_etc5' as bbs_etc5,is_notice,is_html,ip_addr,regdate 
					from blog_bbs where bbs_ix = '$scrap_bbs_ix'
			 ";
			
	//echo $sql;
	//exit;
	/*
	$sql = "insert into blog_bbs (bbs_ix,bgbm_ix, bbs_div,sub_bbs_div, mem_ix,bbs_subject,bbs_name,bbs_pass,bbs_email,bbs_contents,bbs_top_ix, bbs_ix_level, bbs_ix_step, bbs_hidden, bbs_file_1,bbs_file_2,bbs_file_3, bbs_etc1,bbs_etc2,bbs_etc3,bbs_etc4,bbs_etc5,is_notice, is_html, ip_addr, regdate) 
			values 
			('','$bgbm_ix','$bbs_div','$sub_bbs_div','".$bbs_user_code."','$bbs_subject','$bbs_name','$bbs_pass','$bbs_email','$bbs_contents','$bbs_ix','$bbs_ix_level','$bbs_ix_step','$bbs_hidden','$bbs_file_1_name','$bbs_file_2_name','$bbs_file_3_name','$bbs_etc1','$bbs_etc2','$bbs_etc3','$bbs_etc4','$bbs_etc5','$is_notice','$is_html','".$_SERVER["REMOTE_ADDR"]."',NOW())";
	*/
	$db->query($sql);	
	//$db->query("Select bbs_ix from blog_bbs where bbs_ix = LAST_INSERT_ID()");	
	$db->query("Select bbs_ix from blog_bbs where bbs_ix = '$bbs_ix' ");	
	
	//echo "Select bbs_ix from blog_bbs where bbs_ix = $bbs_ix ";
	
	$db->fetch(0);
	$bbs_ix = $db->dt[bbs_ix];
	$path = $bbs_data_dir;
	
	if(!is_dir($path."/$bbs_table_name")){
		
		if(is_writable($path)){
			mkdir($path."/$bbs_table_name", 0777);
			chmod($path."/$bbs_table_name", 0777);	
		}
	}
	
	$path = $bbs_data_dir."/$bbs_table_name";
	if(!is_dir($path."/".$bbs_ix)){
		
		if(is_writable($path)){
			//echo $path."/".$bbs_ix;
			mkdir($path."/$bbs_ix", 0777);
			chmod($path."/$bbs_ix", 0777);	
		}
	}
	
	//$path = $bbs_data_dir."/$bbs_table_name/0012";
	$path = $bbs_data_dir."/$bbs_table_name/$bbs_ix";
//	echo $path;
//	exit;
	if(is_dir($path)){
		
		if ($bbs_file_1_size > 0){
			move_uploaded_file($bbs_file_1, $path."/".iconv("utf-8","CP949",$bbs_file_1_name));
		}
	
		if ($bbs_file_2_size > 0){
			move_uploaded_file($bbs_file_2, $path."/".iconv("utf-8","CP949",$bbs_file_2_name));
		}
		
		if ($bbs_file_3_size > 0){
			move_uploaded_file($bbs_file_3, $path."/".iconv("utf-8","CP949",$bbs_file_3_name));
		}
		/*썸네일 이미지 생성 시작*/
		$image_info = getimagesize ($path."/".iconv("utf-8","CP949",$bbs_file_1_name));
		$image_type = substr($image_info['mime'],-3);

		$db->query("select board_thumbnail_yn,thum_width,thum_height from bbs_manage_config where board_ename = '".$board."'");
		$db->fetch();
		$board_thumbnail_yn = $db->dt[board_thumbnail_yn];
		$thum_width = $db->dt[thum_width];
		$thum_height = $db->dt[thum_height];

		if($board_thumbnail_yn == "Y"){
			if($image_type == "gif" || $image_type == "GIF"){
				if($bbs_file_1_size > 0){
					MirrorGif($path."/".iconv("utf-8","CP949",$bbs_file_1_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_1_name), MIRROR_NONE);
					resize_gif($path."/s_".iconv("utf-8","CP949",$bbs_file_1_name),$thum_width,$thum_height);
				}
				if($bbs_file_2_size > 0){
					MirrorGif($path."/".iconv("utf-8","CP949",$bbs_file_2_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_2_name), MIRROR_NONE);
					resize_gif($path."/s_".iconv("utf-8","CP949",$bbs_file_2_name),$thum_width,$thum_height);
				}
				if($bbs_file_3_size > 0){
					MirrorGif($path."/".iconv("utf-8","CP949",$bbs_file_3_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_3_name), MIRROR_NONE);
					resize_gif($path."/s_".iconv("utf-8","CP949",$bbs_file_3_name),$thum_width,$thum_height);
				}
			}else{
				if($bbs_file_1_size > 0){
					Mirror($path."/".iconv("utf-8","CP949",$bbs_file_1_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_1_name), MIRROR_NONE);
					resize_jpg($path."/s_".iconv("utf-8","CP949",$bbs_file_1_name),$thum_width,$thum_height);
				}
				if($bbs_file_2_size > 0){
					Mirror($path."/".iconv("utf-8","CP949",$bbs_file_2_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_2_name), MIRROR_NONE);
					resize_jpg($path."/s_".iconv("utf-8","CP949",$bbs_file_2_name),$thum_width,$thum_height);
				}
				if($bbs_file_3_size > 0){
					Mirror($path."/".iconv("utf-8","CP949",$bbs_file_3_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_3_name), MIRROR_NONE);
					resize_jpg($path."/s_".iconv("utf-8","CP949",$bbs_file_3_name),$thum_width,$thum_height);
				}
			}
		}
		/*썸네일 이미지 생성 끝*/
	}
	

	//exit;
	//echo "<Script>top.document.location.href='?mode=list&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&bbs_div=$bbs_div';</Script>"; 
	echo "<Script>self.close();</Script>"; 
}

if($act == "update"){

	$bbs_file_1 = $HTTP_POST_FILES[bbs_file_1][tmp_name];
	$bbs_file_1_name = $HTTP_POST_FILES[bbs_file_1][name];
	$bbs_file_1_size = $HTTP_POST_FILES[bbs_file_1][size];
	$bbs_file_1_type = $HTTP_POST_FILES[bbs_file_1][type];
		
	$bbs_file_2 = $HTTP_POST_FILES[bbs_file_2][tmp_name];
	$bbs_file_2_name = $HTTP_POST_FILES[bbs_file_2][name];
	$bbs_file_2_size = $HTTP_POST_FILES[bbs_file_2][size];
	$bbs_file_2_type = $HTTP_POST_FILES[bbs_file_2][type];
	
	$bbs_file_3 = $HTTP_POST_FILES[bbs_file_3][tmp_name];
	$bbs_file_3_name = $HTTP_POST_FILES[bbs_file_3][name];
	$bbs_file_3_size = $HTTP_POST_FILES[bbs_file_3][size];
	$bbs_file_3_type = $HTTP_POST_FILES[bbs_file_3][type];
	

	$path = $bbs_data_dir."/$bbs_table_name/";
	if(!is_dir($path)){
		if(is_writable($bbs_data_dir)){
			mkdir($path, 0777);
			chmod($path, 0777);	
		}
	}
	
	$path = $bbs_data_dir."/$bbs_table_name/".$bbs_ix."/";
	if(!is_dir($path)){
		if(is_writable($bbs_data_dir."/$bbs_table_name")){
			mkdir($path, 0777);
			chmod($path, 0777);	
		}
	}
	
	$db->query("select bbs_file_1,bbs_file_2,bbs_file_3 from blog_bbs where bbs_ix = '".$bbs_ix."'");
	$db->fetch();
//echo "select bbs_file_1,bbs_file_2,bbs_file_3 from blog_bbs where bbs_ix = '".$bbs_ix."'";
//exit;
	if ($bbs_file_1_size > 0){
		if($db->dt[bbs_file_1] != ""){
			unlink($path.$db->dt[bbs_file_1]);
			unlink($path."s_".$db->dt[bbs_file_1]);
		}
		move_uploaded_file($bbs_file_1, $path.iconv("utf-8","CP949",$bbs_file_1_name));
		$file_string = ", bbs_file_1 ='".$bbs_file_1_name."' ";
	}

	if ($bbs_file_2_size > 0){
		if($db->dt[bbs_file_2] != ""){
			unlink($path.$db->dt[bbs_file_2]);
			unlink($path."s_".$db->dt[bbs_file_2]);
		}
		move_uploaded_file($bbs_file_2, $path.iconv("utf-8","CP949",$bbs_file_2_name));
		$file_string .= ", bbs_file_2 ='".iconv("utf-8","CP949",$bbs_file_2_name)."' ";
	}
	
	if ($bbs_file_3_size > 0){
		if($db->dt[bbs_file_3] != ""){
			unlink($path.$db->dt[bbs_file_3]);
			unlink($path."s_".$db->dt[bbs_file_3]);
		}
		move_uploaded_file($bbs_file_3, $path.iconv("utf-8","CP949",$bbs_file_3_name));
		$file_string .= ", bbs_file_3 ='".$bbs_file_3_name."' ";
	}	
	/*썸네일 이미지 생성 시작*/
	$image_info = getimagesize ($path."/".iconv("utf-8","CP949",$bbs_file_1_name));
	$image_type = substr($image_info['mime'],-3);

	$db->query("select board_thumbnail_yn,thum_width,thum_height from bbs_manage_config where board_ename = '".$board."'");
	$db->fetch();
	$board_thumbnail_yn = $db->dt[board_thumbnail_yn];
	$thum_width = $db->dt[thum_width];
	$thum_height = $db->dt[thum_height];

	if($board_thumbnail_yn == "Y"){
		if($image_type == "gif" || $image_type == "GIF"){
			if($bbs_file_1_size > 0){
				MirrorGif($path."/".iconv("utf-8","CP949",$bbs_file_1_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_1_name), MIRROR_NONE);
				resize_gif($path."/s_".iconv("utf-8","CP949",$bbs_file_1_name),$thum_width,$thum_height);
			}
			if($bbs_file_2_size > 0){
				MirrorGif($path."/".iconv("utf-8","CP949",$bbs_file_2_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_2_name), MIRROR_NONE);
				resize_gif($path."/s_".iconv("utf-8","CP949",$bbs_file_2_name),$thum_width,$thum_height);
			}
			if($bbs_file_3_size > 0){
				MirrorGif($path."/".iconv("utf-8","CP949",$bbs_file_3_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_3_name), MIRROR_NONE);
				resize_gif($path."/s_".iconv("utf-8","CP949",$bbs_file_3_name),$thum_width,$thum_height);
			}
		}else{
			if($bbs_file_1_size > 0){
				Mirror($path."/".iconv("utf-8","CP949",$bbs_file_1_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_1_name), MIRROR_NONE);
				resize_jpg($path."/s_".iconv("utf-8","CP949",$bbs_file_1_name),$thum_width,$thum_height);
			}
			if($bbs_file_2_size > 0){
				Mirror($path."/".iconv("utf-8","CP949",$bbs_file_2_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_2_name), MIRROR_NONE);
				resize_jpg($path."/s_".iconv("utf-8","CP949",$bbs_file_2_name),$thum_width,$thum_height);
			}
			if($bbs_file_3_size > 0){
				Mirror($path."/".iconv("utf-8","CP949",$bbs_file_3_name), $path."/s_".iconv("utf-8","CP949",$bbs_file_3_name), MIRROR_NONE);
				resize_jpg($path."/s_".iconv("utf-8","CP949",$bbs_file_3_name),$thum_width,$thum_height);
			}
		}
	}
	/*썸네일 이미지 생성 끝*/
	if($regdate){
		$regdate_str = " , regdate = '$regdate' ";	
	}
	if(!$is_html){
		$is_html = "Y";
	}

	$sql ="	update blog_bbs set 
			bbs_subject='".trim($bbs_subject)."',bgbm_ix='$bgbm_ix',bbs_div='$bbs_div',sub_bbs_div='$sub_bbs_div',bbs_name='$bbs_name',bbs_pass='$bbs_pass',bbs_email='$bbs_email',bbs_contents='$bbs_contents', bbs_hidden ='$bbs_hidden', 
			bbs_etc1 ='$bbs_etc1', bbs_etc2 ='$bbs_etc2', bbs_etc3 ='$bbs_etc3', bbs_etc4 ='$bbs_etc4', bbs_etc5 ='$bbs_etc5',is_notice = '$is_notice' , is_html='$is_html', ip_addr = '".$_SERVER["REMOTE_ADDR"]."' $file_string $regdate_str
			where bbs_ix='$bbs_ix' ";
	
	//echo $sql;		 
	//exit;
	$db->query($sql);	
	
	if($bbs_mode == "slide"){
		echo "<Script>document.location.href='?mode=list&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&page=$page&bbs_ix=$bbs_ix&bbs_div=$bbs_div';</Script>";
	}else{
		echo "<Script>document.location.href='?mode=read&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&article_no=$article_no&bbs_ix=$bbs_ix&bbs_div=$bbs_div';</Script>";
	}
	
}


if($act == "delete"){
	
	if($admin_mode || ($_SESSION["user"]["code"] == $msb->bbs_config->dt[cafe_owner])){
		$db->query("Select * from blog_bbs where bbs_ix='$bbs_ix' ");
		
			$path = $bbs_data_dir."/$bbs_table_name/".$bbs_ix."/";
			
			if(is_dir($path)){
				rmdirr($path);
			}
			
			$sql ="	delete from blog_bbs where bbs_ix='$bbs_ix'";		
			$db->query($sql);
			$sql ="	delete from blog_bbs where bbs_top_ix=$bbs_ix ";		
			$db->query($sql);
			$sql ="delete from blog_bbs_comment where bbs_ix='$bbs_ix'";
			$db->query($sql);
			
			echo "<Script>document.location.href='?mode=list&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&bbs_div=$bbs_div';</Script>";
	
	}else if(($bbs_user_code != "") && !$admin_mode && ($_SESSION["user"]["code"] != $msb->bbs_config->dt[cafe_owner])){
		$db->query("Select * from blog_bbs where mem_ix = '".$bbs_user_code."' and bbs_ix='$bbs_ix' ");
		
		if($db->total){
			$path = $bbs_data_dir."/$bbs_table_name/".$bbs_ix."/";
			
			if(is_dir($path)){
				rmdirr($path);
			}
			
			$sql ="	delete from blog_bbs where bbs_ix='$bbs_ix'  and mem_ix = '".$bbs_user_code."' ";		
			$db->query($sql);
			$sql ="	delete from blog_bbs where bbs_top_ix=$bbs_ix ";		
			$db->query($sql);
			$sql ="delete from blog_bbs_comment where bbs_ix='$bbs_ix'";
			$db->query($sql);
			
			echo "<Script>document.location.href='?mode=list&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&bbs_div=$bbs_div';</Script>";
		}else{
			echo "<Script>alert('해당긁은 회원님의 글이 아닙니다. 확인후 다시 삭제해 주시기 바랍니다.');history.back();</Script>";
		}
	}else{
		$db->query("Select * from blog_bbs where bbs_pass = '$bbs_pass' and bbs_ix='$bbs_ix' ");
		
		if($db->total){
			$path = $bbs_data_dir."/$bbs_table_name/".$bbs_ix."/";
			
			if(is_dir($path)){
				rmdirr($path);
			}
			
			$sql ="	delete from blog_bbs where bbs_ix='$bbs_ix'  ";		
			$db->query($sql);
			
			$sql ="delete from blog_bbs_comment where bbs_ix='$bbs_ix'";
			$db->query($sql);
			
			echo "<Script>document.location.href='?mode=list&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&bbs_div=$bbs_div';</Script>";
		}else{
			echo "<Script>alert('비밀번호가 올바르지 않습니다.');history.back();</Script>";
		}
	}
	
}



if($act == "response"){

	/*스팸글 방지위해 만듬 시작*/
	$bbs_user = $_SERVER["REMOTE_ADDR"]."\t".$_SERVER["HTTP_USER_AGENT"]."\t".date("Y-m-d H:i:s")."\t".$_COOKIE["C_TOKEN"]."\t".$bbs_subject."\r\n";
	
	
	$fp = fopen($bbs_data_dir."/bbs_writer.txt","a+");
	fwrite($fp,$bbs_user);
	fclose($fp);
	
	if($_SERVER["HTTP_REFERER"] == ""){  //  || $focus_info != "Y"
		echo "레퍼러 오류";
		exit;
	}
	
	
	if($_COOKIE["C_TOKEN"] != $token || $_COOKIE["C_TOKEN"] == ""){
		echo "토큰 오류";
		exit;
	}
	/*스팸글 방지위해 만듬 끝*/
	
	$db->query("select IFNULL(max(bbs_ix),0) as bbs_ix from blog_bbs ");
	if($db->total){
		$db->fetch();
		$bbs_ix = $db->dt[bbs_ix] + 1;
	}else{
		$bbs_ix = 0;
	}
	
	if ($bbs_parent_ix == ""){
		$bbs_parent_ix = 0;
	}	
	if ($bbs_ix_level == ""){
		$bbs_ix_level = 0;
	}
	
	
	$sql = "select IFNULL(max(bbs_ix_step )+1,0) as bbs_ix_step from blog_bbs where bgbm_ix = '$bgbm_ix' and bbs_top_ix =  '". $bbs_top_ix."' ";
	
	$db->query($sql);
	if($db->total){
		$db->fetch();
		$bbs_ix_step = $db->dt[bbs_ix_step];
	}else{
		$bbs_ix_step = 0;
	}
	
	$sql = "select IFNULL(max(bbs_ix_level )+1,0) as bbs_ix_level from blog_bbs where bgbm_ix = '$bgbm_ix' and bbs_top_ix = ". $bbs_parent_ix ." and bbs_ix_level = ".$bbs_ix_level;
	$db->query($sql);
	if($db->total){
		$db->fetch();
		$bbs_ix_level = $db->dt[bbs_ix_level];
	}else{
		$bbs_ix_level = 0;
	}

	if(!$is_html){
		$is_html = "Y";
	}
	
	$sql = "insert into blog_bbs (bbs_ix,bgbm_ix,bbs_div,mem_ix,bbs_subject,bbs_name,bbs_pass,bbs_email,bbs_contents,bbs_top_ix, bbs_ix_level, bbs_ix_step, bbs_hidden, bbs_file_1,bbs_file_2,bbs_file_3, bbs_etc1,bbs_etc2,bbs_etc3,bbs_etc4,bbs_etc5, is_html, ip_addr, regdate)
			values 
			('$bbs_ix','$bgbm_ix','$bbs_div','".$bbs_user_code."','$bbs_subject','$bbs_name','$bbs_pass','$bbs_email','$bbs_contents','$bbs_parent_ix','$bbs_ix_level','$bbs_ix_step','$bbs_hidden','$bbs_file_1_name','$bbs_file_2_name','$bbs_file_3_name','$bbs_etc1','$bbs_etc2','$bbs_etc3','$bbs_etc4','$bbs_etc5','$is_html','".$_SERVER["REMOTE_ADDR"]."', NOW())";
	
	$db->query($sql);	
	$db->query("Select bbs_ix from blog_bbs where bbs_ix = LAST_INSERT_ID()");	
	$db->fetch();
	
	$path = $bbs_data_dir;
	
	if(!is_dir($path."/$bbs_table_name")){
		
		if(is_writable($path)){
			mkdir($path."/$bbs_table_name", 0777);
			chmod($path."/$bbs_table_name", 0777);	
		}
	}
	
	$path = $bbs_data_dir."/$bbs_table_name";
	if(!is_dir($path."/".$bbs_ix)){
		
		if(is_writable($path)){
			//echo $path."/".$bbs_ix;
			mkdir($path."/".$bbs_ix, 0777);
			chmod($path."/".$bbs_ix, 0777);	
		}
	}
	
	//$path = $bbs_data_dir."/$bbs_table_name/0012";
	$path = $bbs_data_dir."/$bbs_table_name/".$bbs_ix;
	//echo $path;
	if(is_dir($path)){
		
		if ($bbs_file_1_size > 0){
			move_uploaded_file($bbs_file_1, $path."/".iconv("utf-8","CP949",$bbs_file_1_name));
		}
	
		if ($bbs_file_2_size > 0){
			move_uploaded_file($bbs_file_2, $path."/".iconv("utf-8","CP949",$bbs_file_2_name));
		}
		
		if ($bbs_file_3_size > 0){
			move_uploaded_file($bbs_file_3, $path."/".iconv("utf-8","CP949",$bbs_file_3_name));
		}
	}

	//exit;
	echo "<Script>document.location.href='?mode=list&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&bbs_div=$bbs_div';</Script>"; 
}


if($act == "comment_insert"){

	/*스팸글 방지위해 만듬 시작*/
	$bbs_user = $_SERVER["REMOTE_ADDR"]."\t".$_SERVER["HTTP_USER_AGENT"]."\t".date("Y-m-d H:i:s")."\t".$_COOKIE["C_TOKEN"]."\t".$cmt_name."\r\n";
	
	
	$fp = fopen($bbs_data_dir."/bbs_comment_writer.txt","a+");
	fwrite($fp,$bbs_user);
	fclose($fp);

	if($focus_info != "Y" || $_SERVER["HTTP_REFERER"] == ""){
		exit;
	}
	
	
	/*if($_COOKIE["C_TOKEN"] != $token || $_COOKIE["C_TOKEN"] == ""){
		exit;
	}*/
	/*스팸글 방지위해 만듬 끝*/

	$sql = "insert into blog_bbs_comment
			(cmt_ix,bbs_ix,mem_ix,cmt_name,cmt_pass,cmt_email,cmt_contents, regdate) 
			values
			('','$bbs_ix','".$bbs_user_code."','$cmt_name','$cmt_pass','$cmt_email','$cmt_contents',NOW())";
	
	//echo $sql;		
	$db->query($sql);	
	
	$db->query("update blog_bbs set bbs_re_cnt = bbs_re_cnt + 1 where bbs_ix ='$bbs_ix'");
	if($_POST["bbs_pass"]){
		echo "<Script>document.location.href='?mode=read&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&article_no=$article_no&bbs_ix=$bbs_ix&bbs_div=$bbs_div&bbs_pass=".$_POST["bbs_pass"]."';</Script>";
	}else{
		echo "<Script>document.location.href='?mode=read&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&article_no=$article_no&bbs_ix=$bbs_ix&bbs_div=$bbs_div';</Script>";
	}
}



if($act == "comment_delete"){
	if($admin_mode){
		$sql ="select * from blog_bbs_comment where cmt_ix = '$cmt_ix' and bbs_ix='$bbs_ix'";
	}else{
		if($cmt_pass != ""){
			$sql ="select * from blog_bbs_comment where cmt_ix = '$cmt_ix' and bbs_ix='$bbs_ix' and cmt_pass ='$cmt_pass' ";
		}else{
			$sql ="select * from blog_bbs_comment where cmt_ix = '$cmt_ix' and bbs_ix='$bbs_ix' and mem_ix ='".$bbs_user_code."' ";
		}	
	}
	//echo $sql;
	$db->query($sql);
	
	if($db->total){
		$sql ="	delete from blog_bbs_comment where cmt_ix = '$cmt_ix' and bbs_ix='$bbs_ix' ";
	//	echo $sql;
		$db->query($sql);
		$db->query("update blog_bbs set bbs_re_cnt = bbs_re_cnt - 1 where bbs_ix ='$bbs_ix'");
		
		if($_POST["bbs_pass"]){
			echo "<Script>document.location.href='?mode=read&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&article_no=$article_no&bbs_ix=$bbs_ix&bbs_div=$bbs_div&bbs_pass=".$_POST["bbs_pass"]."';</Script>";
		}else{
			echo "<Script>document.location.href='?mode=read&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&article_no=$article_no&bbs_ix=$bbs_ix&bbs_div=$bbs_div';</Script>";
		}

		
	}else{
		if($cmt_pass != ""){
			echo "<Script>alert('비밀번호가 올바르지 않습니다.');history.back();</Script>";
		}else{
			echo "<Script>alert('자신의 글이 아닙니다.');history.back();</Script>";
		}
	}
	
	
	
}


if($act == "pass_check" || $act == "pass_check_for_read"){
	if($bbs_user_code != "" && $bbs_pass == ""){  //로그인 이고 자기글일때 바로 접근할때만 
		$db->query("Select * from blog_bbs where mem_ix = '".$bbs_user_code."' and bbs_ix='$bbs_ix' ");
	}else{                 
		$sql ="select * from blog_bbs where bbs_ix='$bbs_ix' and bbs_pass ='$bbs_pass' ";
	//	echo $sql;
		$db->query($sql);
	}
	
	if($db->total){
		if($act == "pass_check_for_read"){
			echo "<Script>document.location.href='?mode=read&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&bbs_ix=$bbs_ix&bbs_pass=$bbs_pass';</Script>";	
		}else{			
			echo "<Script>document.location.href='?mode=modify&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&bbs_ix=$bbs_ix&article_no=$article_no&page=$page&bbs_pass=$bbs_pass';</Script>";				
		}
	}else{
		echo "<Script>alert('비밀번호가 올바르지 않습니다.');</Script>";
	}
		
}

if($act == "faq_insert"){
	
	$sql = "insert into blog_bbs 
			(bbs_ix,bbs_div,sub_bbs_div, bbs_q,bbs_a,bbs_contents_type,regdate) 
			values
			('','$bbs_div','$sub_bbs_div','$bbs_q','$bbs_a','$bbs_contents_type',NOW())";
	
	//echo $sql;		
	$db->query($sql);	
	echo "<Script>document.location.href='?mode=list&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&bbs_div=$bbs_div';</Script>";
}


if($act == "faq_update"){
	
	$sql ="	update blog_bbs set 
			bbs_div='$bbs_div',sub_bbs_div='$sub_bbs_div', bbs_q='$bbs_q',bbs_a='$bbs_a',bbs_contents_type='$bbs_contents_type'
			where bbs_ix='$bbs_ix'";
	
	//echo $sql;		
	$db->query($sql);	

		
	echo "<Script>document.location.href='?bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&mode=list';</Script>";
	exit;
}

if($act == "faq_delete"){
	
	$sql ="delete from blog_bbs where bbs_ix='$bbs_ix'  ";		
	
	$db->query($sql);
	
	echo "<Script>document.location.href='?bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&mode=list';</Script>";
	exit;
	
}

if($act == "select_delete"){
	
	$cnt = count($bbs_ix);
	
	if($cnt > 0){
		for($i=0;$i<$cnt;$i++){
			$path = $bbs_data_dir."/$bbs_table_name/".$bbs_ix[$i]."/";
					
			if(is_dir($path)){
				rmdirr($path);
			}
			

			$sql ="	delete from blog_bbs where bbs_ix='".$bbs_ix[$i]."' ";
		
			$db->query($sql);
			
			$sql ="delete from blog_bbs_comment where bbs_ix='".$bbs_ix[$i]."'";
			$db->query($sql);
		}
	}	
	echo "<Script>document.location.href='?mode=list&bg_ix=$bg_ix&bgbm_ix=$bgbm_ix&bbs_div=$bbs_div';</Script>";
}

?>