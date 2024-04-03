<?php
include_once($_SERVER["DOCUMENT_ROOT"]."/class/blog.class");
//include_once($_SERVER["DOCUMENT_ROOT"]."/class/layout.class");
/*
echo "?<br>";
echo "cache_expire : ".ini_get("session.cache_expire");
echo "<br>";
echo "gc_maxlifetime : ".ini_get("session.gc_maxlifetime");
ini_set("session.cache_expire", "86400");
ini_set("session.gc_maxlifetime", "86400");
echo "<br><br>?<br>";
echo "cache_expire : ".ini_get("session.cache_expire");
echo "<br>";
echo "gc_maxlifetime : ".ini_get("session.gc_maxlifetime");
*/

session_start();

if($board){
	$bbs_table_name = $board;
}


//echo "bbs_templet_dir:".$db->dt[bbs_templet_dir];
$page_code = $pgid;
$bbs_templet = $bbs_templet_dir;
if(!$bbs_templet){
	$bbs_templet = "basic";
}
$page_path = getTempletPath($pgid, $db->dt[depth]);

//$P = new msLayOut($page_code);



//echo dirname($_SERVER["PHP_SELF"]);

if($admin_mode){
	//$bbs_template_dir = path_to_root($_SERVER["PHP_SELF"]).$layout_config[mall_data_root]."/bbs_templet/$bbs_templet";
	$bbs_template_dir = path_to_root($_SERVER["PHP_SELF"]).$layout_config[mall_data_root]."/bbs_templet/admin";
}else{
	$bbs_template_dir = path_to_root($_SERVER["PHP_SELF"]).$layout_config[mall_data_root]."/bbs_templet/blogbbs";
}
//echo path_to_root($_SERVER["PHP_SELF"]);
$bbs_compile_dir  = $_SERVER["DOCUMENT_ROOT"].$layout_config[mall_data_root]."/compile_/blog/blog_bbs/";
$bbs_data_dir = path_to_root($_SERVER["PHP_SELF"]).$layout_config[mall_data_root]."/blogbbs_data";
$edit_data_dir = "../../".$layout_config[mall_data_root]."/blogbbs_data";

$tpl = new Template_();
//echo $layout_config[mall_templet_path]."<br>";
$tpl->template_dir = $layout_config[mall_templet_path];
$tpl->compile_dir  = $_SERVER["DOCUMENT_ROOT"].$layout_config[mall_data_root]."/compile_/";
$tpl->assign('templet_src',$layout_config[mall_templet_webpath]);
$tpl->assign('product_src',$layout_config[mall_product_imgpath]);
$tpl->assign('images_src',$layout_config[mall_image_path]);

//if (!function_exists('path_to_root')){
	function path_to_root($path) {

	    $pathinfo = pathinfo($path);
	    //print_r($pathinfo);
	    $deep = substr_count($pathinfo[dirname], "/");

	    $path_to_root_str = "./";

	    for($i = 1; $i <= $deep; $i++) {
	        $path_to_root_str .= "../";
	    }

	    return $path_to_root_str;
	}
//}
//echo print_r(pathinfo($_SERVER["DOCUMENT_ROOT"].$layout_config[mall_data_root]."/bbs_templet/$bbs_templet"))."<br>";

?>
