<?php
include(OLDBASE_ROOT."/class/blog.lib.php");
if (!function_exists('print_blog_bbs')){
	function print_blog_bbs($board,$mode, $act, $pgid="010001000000000", $admin_mode=false){
		global $ss_pgid, $article_no, $bbs_ix, $page, $P;
		
		global $HTTP_POST_VARS, $HTTP_GET_VARS , $HTTP_SESSION_VARS, $HTTP_POST_FILES;
		@extract($HTTP_POST_VARS); 
		@extract($HTTP_GET_VARS); 
		@extract($HTTP_SESSION_VARS); 
		//@extract($HTTP_POST_FILES); 
		
		if($ss_pgid){
			$pgid = $ss_pgid;
		}
		
		include($_SERVER["DOCUMENT_ROOT"]."/bbs/blogbbs.config.php");
		include($_SERVER["DOCUMENT_ROOT"]."/bbs/blogbbs.act.php");
		
		
		
		if($mode == "list" || $mode == ""){
			//$P = new msLayOut($page_code);
			//echo "aaa".$bbs_table_name."<br>";
			
			$msb = new Blog($bbs_table_name);
			$msb->MsBoardConfigration();
			$msb->bbs_admin_mode = $admin_mode;
			$msb->bbs_template_dir = $bbs_template_dir;  
			$msb->bbs_compile_dir  = $bbs_compile_dir;
			$msb->bbs_data_dir  = $bbs_data_dir;
			$msb->bbs_file_dir  = $bbs_file_dir;
			$msb->bbs_singlefilemode = true;
			$msb->site_template_src  = $P->Config[mall_templet_webpath];
			
			//$P = new layout();
			
			return $msb->PrintMsBoardList($bbs_div);
			exit;
			/*
			$tpl->assign('bbs_area',$msb->PrintMsBoardList($bbs_div));
			
			//echo $P->Config[this_templet_path];
			$tpl->define('bbs',$P->Config[this_templet_path]);
			
			//$P->Contents = ;
			$P->Contents = $tpl->fetch('bbs');
			
			$P->navi = $navi;
			$P->title_img = $title_img;
			
			
			
			echo $P->LoadLayOut();
			*/
		}else if($mode == "read"){
			$msb = new Blog($bbs_table_name);
			$msb->MsBoardConfigration();
			$msb->bbs_admin_mode = $admin_mode;
			$msb->bbs_template_dir = $bbs_template_dir;  
			$msb->bbs_compile_dir  = $bbs_compile_dir;
			$msb->bbs_data_dir  = $bbs_data_dir;
			$msb->bbs_file_dir  = $bbs_file_dir;
			$msb->bbs_table_name  = $bbs_table_name;
			$msb->bbs_singlefilemode = true;
			$msb->site_template_src  = $P->Config[mall_templet_webpath];
			//$msb->BoardAuth("read");
			
			//$P = new layout();
			//$P->Contents = $msb->PrintMsBoardRead($article_no, $bbs_ix, $page, $bbs_div);
			
			return $msb->PrintMsBoardRead($article_no, $bbs_ix, $page, $bbs_div);
			exit;
			/*
			$tpl->assign('bbs_area',$msb->PrintMsBoardRead($article_no, $bbs_ix, $page, $bbs_div));
			$tpl->define('bbs',$P->Config[this_templet_path]);
			$P->Contents = $tpl->fetch('bbs');
			
			
			echo $P->LoadLayOut();
			*/
		}else if($mode == "write"){	
			
			$msb = new Blog($bbs_table_name);
			$msb->MsBoardConfigration();
			$msb->bbs_admin_mode = $admin_mode;
			$msb->bbs_template_dir = $bbs_template_dir;  
			$msb->bbs_compile_dir  = $bbs_compile_dir;
			$msb->bbs_data_dir  = $bbs_data_dir;
			$msb->edit_data_dir  = $edit_data_dir;
			$msb->bbs_file_dir  = $bbs_file_dir;
			$msb->site_template_src  = $P->Config[mall_templet_webpath];
			//print_r($P->Config);
			//exit;
			//$P = new layout();
			//$P->Contents = $msb->PrintMsBoardWrite($bbs_div);
			return $msb->PrintMsBoardWrite($bbs_div);
			exit;
			/*
			$tpl->assign('bbs_area',$msb->PrintMsBoardWrite($bbs_div));
			
			$tpl->define('bbs',$P->Config[this_templet_path]);
			$P->Contents = $tpl->fetch('bbs');
			
			$P->navi = $navi;
			$P->title_img = $title_img;
			
			echo $P->LoadLayOut();
			*/
		}else if($mode == "modify"){		
		
			$msb = new Blog($bbs_table_name);
			$msb->MsBoardConfigration();
			$msb->bbs_admin_mode = $admin_mode;
			$msb->bbs_template_dir = $bbs_template_dir;  
			$msb->bbs_compile_dir  = $bbs_compile_dir;
			$msb->bbs_data_dir  = $bbs_data_dir;
			$msb->edit_data_dir  = $edit_data_dir;
			$msb->bbs_file_dir  = $bbs_file_dir;
			$msb->site_template_src  = $P->Config[mall_templet_webpath];
			
			//$P = new layout();
			//$P->Contents = $msb->PrintMsBoardModify($bbs_ix, $article_no, $page, $bbs_div);
			return $msb->PrintMsBoardModify($bbs_ix, $article_no, $page, $bbs_div);
			exit;
			/*
			$tpl->assign('bbs_area',$msb->PrintMsBoardModify($bbs_ix, $article_no, $page, $bbs_div));
			$tpl->define('bbs',$P->Config[this_templet_path]);
			$P->Contents = $tpl->fetch('bbs');
			
			echo $P->LoadLayOut();
			*/
		}else if($mode == "response"){		
				
			$msb = new Blog($bbs_table_name);
			$msb->MsBoardConfigration();
			$msb->bbs_admin_mode = $admin_mode;
			$msb->bbs_template_dir = $bbs_template_dir;  
			$msb->bbs_compile_dir  = $bbs_compile_dir;
			$msb->bbs_data_dir  = $bbs_data_dir;
			$msb->edit_data_dir  = $edit_data_dir;
			$msb->bbs_file_dir  = $bbs_file_dir;
			$msb->site_template_src  = $P->Config[mall_templet_webpath];
			
			//$P = new layout();
			return $msb->PrintMsBoardResponse($bbs_ix, $page, $bbs_div);
			exit;
			/*
			$P->Contents = $msb->PrintMsBoardResponse($bbs_ix, $page, $bbs_div);
			$P->navi = $navi;
			$P->title_img = $title_img;
			
			echo $P->LoadLayOut();
			*/
		}else if($mode == "category"){		
			include($_SERVER["DOCUMENT_ROOT"]."/bbs/category.load.php");
			exit;
		}else if($mode == "download"){
			
			$out = ob_get_clean();
			include($_SERVER["DOCUMENT_ROOT"]."/bbs/blogbbs_download.php");
			exit;
		}else{
			
		}
	
	}
}


function getBlogBBSList($bg_ix, $bgbg_ix){
	$mdb = new Database;
	
	$sql = "select * from blog_bbs_manage cbm where bg_ix = '$bg_ix' and bgbg_ix = '$bgbg_ix' order by vieworder asc , regdate asc";
	
	$mdb->query($sql);
	
	return $mdb->fetchall();
}

function CheckBlogOwner($bg_ix, $mem_ix){
	$mdb = new Database;
	
	$sql = "select * from blog_basicinfo cbm where bg_ix = '$bg_ix' and mem_ix = '$mem_ix'  ";	
	
	$mdb->query($sql);
	
	if($mdb->total){
		return true;
	}else{
		return false;
	}
	
}

function CheckBlogReg($cf_ix, $mem_ix){
	$mdb = new Database;
	/*
	$sql = "select * from blog_member cbm where bg_ix = '$bg_ix' and mem_ix = '$mem_ix' and status = 'C' ";	
	$mdb->query($sql);
	
	if($mdb->total){
		return true;
	}else{
		return false;
	}
	*/
}


function getMyBlog($mem_ix){
	//$mdb = new Database;
	
	//$sql = "select cm.cf_ix, cafename from cafe_member cm, cafe_basicinfo cb where cm.cf_ix = cb.cf_ix and cm.mem_ix = '$mem_ix' and status in ('R','C') order by cm.regdate asc";
	
	//$mdb->query($sql);
	
	//return $mdb->fetchall();
}


?>