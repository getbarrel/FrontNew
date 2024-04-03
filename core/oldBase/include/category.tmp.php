<?php
function PrintCategory()
{
	global $db;
	$db->query("SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5");
	
	$total = $db->total;
	for ($i = 0; $i < $db->total; $i++)
	{
	
		$db->fetch($i);
		
		if ($db->dt["depth"] == 0){
			$mstring .= "[".$db->dt["cname"]."]";//,$db->dt["cid"],$db->dt["depth"]);
		}else if($db->dt["depth"] == 1){
			$mstring .=  "<span style='width:15px;'></span><a href='/shop/ms_product.list.php?cid=".$db->dt["cid"]."&depth=".$db->dt["depth"]."'>".$db->dt[cname]."</a>";
		}
	}
	
	return $mstring;
}

function LeftMenu()
{
	global $db;// = new Database;
	
	$db->query("SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where category_use = 1 order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5");
	
	$total = $db->total;
	$MenuString = "<table cellpadding=0 border=0 cellspacing=0 style='font-size:9pt;border:0px solid silver' width='100%'>
					<tr height=10><td></td></tr>
	";
	for ($i = 0; $i < $db->total; $i++)
	{
	
		$db->fetch($i);
		if ($db->dt[depth] == 0){
		//$MenuString = $MenuString."<tr><td style='padding-left:15px;color:#B3075C;' width='100%' ><a href='/shop/ms_product.list.php?cid=".$db->dt["cid"]."&depth=".$db->dt["depth"]."'><b style='font-size:17px;'>".$db->dt[cname]."</b></a></td></tr>";		
		$MenuString = $MenuString."<tr><td style='padding-left:0px;color:#B3075C;' width='100%' ><a href='/shop/ms_product.list.php?cid=".$db->dt["cid"]."&depth=".$db->dt["depth"]."'><img src='/image/category/".$db->dt[leftcatimg]."' border=0></a></td></tr>";	
		}else if($db->dt[depth] == 1){
		}
	}
	$MenuString = $MenuString."</table>";
	return $MenuString;
	
}

function LeftTextMenu_style1()
{
	global $db;// = new Database;
	
	$db->query("SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where category_use = 1 order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5");
	
	$total = $db->total;
	$MenuString = "<table cellpadding=0 border=0 cellspacing=0 style='font-size:9pt;border:0px solid silver' width='210'>
					<!--tr height=10><td colspan=7 align=center>category</td></tr-->
	";
	for ($i = 0; $i < $db->total; $i++)
	{
	
		$db->fetch($i);
		if ($db->dt[depth] == 0){
			$MenuString .= "<tr height=19><td style='padding-left:10px;color:#B3075C;' bgcolor='#efefef' width='100%' colspan=2><a href='/shop/ms_product.list.php?cid=".$db->dt["cid"]."&depth=".$db->dt["depth"]."'><!--img src='/shop_templete/basic/images/ico_arw01.gif' border=0 align=absmiddle--> <b style='font-size:11px;'>".$db->dt[cname]."</b></a></td></tr>";	
			$MenuString .= "<tr hegiht=1><td colspan=2 background='/manage/image/dot.gif'></td></tr>";	
		//$MenuString = $MenuString."<tr><td style='padding-left:0px;color:#B3075C;' width='100%' ><a href='/shop/ms_product.list.php?cid=".$db->dt["cid"]."&depth=".$db->dt["depth"]."'><img src='/image/category/".$db->dt[leftcatimg]."' border=0></a></td></tr>";	
		}else if($db->dt[depth] == 1){
			$MenuString .= "<tr height=19 bgcolor='#ffffff'><td width='10%'></td><td width='100%'><a href='/shop/ms_product.list.php?cid=".$db->dt["cid"]."&depth=".$db->dt["depth"]."'> ".$db->dt[cname]."</a></td></tr>";
			$MenuString .= "<tr hegiht=1><td></td><td colspan=8 background='/manage/image/dot.gif'></td></tr>";	
		}
	}
	
	$MenuString = $MenuString."</table>";
	return $MenuString;
	
}


function makeCategoryByTemplet($tmp_path="", $file_name="")
{
	global $db;
	
	$ms_template = $tmp_path."/category/".$file_name;
	

	
	$tcontent = load_template($ms_template);
	$page_tmp   = get_tags("<!--{LOOP_START}-->","<!--{LOOP_END}-->",$tcontent);
	$depth1_tmp   = get_tags("<!--{LOOP_START_DEPTH1}-->","<!--{LOOP_END_DEPTH1}-->",$tcontent);
	$depth2_tmp   = get_tags("<!--{LOOP_START_DEPTH2}-->","<!--{LOOP_END_DEPTH2}-->",$tcontent);
	$depth1_loop_tmp = $depth1_tmp["re-content"];
	$depth2_loop_tmp = $depth2_tmp["re-content"];
	
	$mdb = new Database;
	$mdb->query("SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where category_use = 1 order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5");
		
	
		for($i=0;$i < $mdb->total;$i++){
			$mdb->fetch($i);
			
			if($mdb->dt[depth] == 0){
				$loop_tmp_ing = $depth1_loop_tmp;
			}else if($mdb->dt[depth] == 1){
				$loop_tmp_ing = $depth2_loop_tmp;
			}else{
				$loop_tmp_ing = "";
			}
		        
		        $cname = $mdb->dt[cname];
		        $depth = $mdb->dt[depth];
		        $cid = $mdb->dt[cid];
		        $loop_tmp_ing = eregi_replace("@_","\$", $loop_tmp_ing);		        
		        $loop_tmp_ing = eregi_replace("\"","\\\"", $loop_tmp_ing);
		        
		        eval("\$loop_tmp_ing = \"".$loop_tmp_ing."\";");
		        
		        
			//$loop_tmp_ing = eregi_replace("@_cname",$mdb->dt[cname], $loop_tmp_ing);
			//$loop_tmp_ing = eregi_replace("{{MALLSTORY_BBS_MENU_ENGLISH_NAME}}",$mdb->dt[board_ename], $loop_tmp_ing);
			
			$loop_tmp_result .= $loop_tmp_ing;
		}
		
		$tcontent = substr($tcontent,0,$page_tmp["ab-begin"]).$loop_tmp_result.substr($tcontent,$page_tmp["ab-end"],strlen($tcontent));
		//$tcontent = eregi_replace("@_templet_path",$mP->ms_template_webpath, $tcontent);
		
		return $tcontent;
}


function LeftTextMenu()
{
	global $db, $layout_config, $DOCUMENT_ROOT;// = new Database;
	
	if($layout_config[mall_use_category_templet] != ""){
		//echo $layout_config[mall_use_category_templet]."<br>";
		return makeCategoryByTemplet($_SERVER["DOCUMENT_ROOT"]."".$layout_config[mall_data_root]."/templet/".$layout_config[mall_use_templete], $layout_config[mall_use_category_templet]);		
	}else{
		$db->query("SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where category_use = 1 order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5");
		
		$total = $db->total;
		$MenuString = "<table cellpadding=0 border=0 cellspacing=0 style='font-size:9pt;border:0px solid silver' width='180'>
					<tr height=10><td colspan=7 align=center><a href='/upimg/catalog.pdf'><img src='/data/simpleline/templet/basic/images/catalog_download.gif' border=0></a></td></tr>
					<tr height=30><td colspan=7 align=center><img src='/data/simpleline/templet/basic/images/category_dot.gif' align=absmiddle> <b style='color:#000000;font-size:11px;'>SIMPLELINE CATEGORY</b></td></tr>
					";
		
		$oMenu = new MenuLine;
		
		for ($i = 0; $i < $db->total; $i++)
		{
		
			$db->fetch($i);
			if ($db->dt[depth] == 0){
				$MenuString .= $oMenu->print_top_menu(substr($db->dt[cid],0,3));
				$MenuString .= "<tr height=20><td style='padding-left:10px;color:#B3075C;padding-top:3px;' bgcolor='#FEF2E4' width='100%' ><a href='/shop/ms_product.list.php?cid=".$db->dt["cid"]."&depth=".$db->dt["depth"]."'><!--img src='/shop_templete/basic/images/ico_arw01.gif' border=0 align=absmiddle--> <b style='font-size:11px;color:gray' class='ls1'>".$db->dt[cname]."</b></a></td></tr>";	
				$MenuString .= "<tr height=3><td colspan=2></td></tr>";	
			}else if($db->dt[depth] == 1){
				$MenuString .= $oMenu->printmenu($db->dt[cname],"/shop/ms_product.list.php?cid=".$db->dt["cid"]."&depth=".$db->dt["depth"], substr($db->dt[cid],0,3));	
			}
		}
		$MenuString .= $oMenu->print_top_menu(substr($db->dt[cid],0,3));
		$MenuString = $MenuString."</table>";
		return $MenuString;	
	}
		
	
}

function TopCategoryMenu()
{
	global $db;// = new Database;
	
	$db->query("SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5 limit 0,6");
	
	$total = $db->total;
	$MenuString = "<table cellpadding=0 border=0 cellspacing=0 style='font-size:9pt;border:0px solid silver' width='100%'>
					<tr>";
					
	for ($i = 0; $i < $db->total; $i++)
	{
	
		$db->fetch($i);
		if ($db->dt[depth] == 0){		
			$MenuString .= "<td style='padding-left:15px;color:#B3075C;'  ><a href='/shop/ms_product.list.php?cid=".$db->dt["cid"]."&depth=".$db->dt["depth"]."'><img src='/image/category/".$db->dt[catimg]."' border=0></a></td>";	
		}else if($db->dt[depth] == 1){
		//	$MenuString = $MenuString."<tr bgcolor='#ffffff'><td style='padding-left:25px' width='100%'><a href='/shop/ms_product.list.php?cid=".$db->dt["cid"]."&depth=".$db->dt["depth"]."'>".$db->dt[cname]."</a></td></tr>"
		}
		
		if($i % 3 == 2){
			$MenuString .= "</tr><tr>";
		}
	}
	

	$MenuString = $MenuString."</tr></table>";
	return $MenuString;
	
}