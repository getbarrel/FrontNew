<?
function BrandList($brand, $return_type ="")
{
//global $db;

	$mdb = new Database;

	$mdb->query("SELECT * FROM brand");
	
	$bl = "<Select name='brand'>";	
	if ($mdb->total == 0)	{
		$bl = $bl."<Option>등록된 브랜드가 없습니다.</Option>";
	}else{
		if($return_type == ""){
			$bl = $bl."<Option value=''>브랜드 선택</Option>";
			for($i=0 ; $i <$mdb->total ; $i++)
			{
				$mdb->fetch($i);
				if ($brand == $mdb->dt[id])
				{
					$strSelected = "Selected";
				}else{
					$strSelected = "";
				}
				
				$bl = $bl."<Option value='".$mdb->dt[id]."' $strSelected>".$mdb->dt[brandname]."</Option>";
				
			}
		}else{
			for($i=0 ; $i <$mdb->total ; $i++)
			{
				$mdb->fetch($i);
				if ($brand == $mdb->dt[id]){
					return $mdb->dt[brandname];
				}
			}
		}
	}
	
	$bl = $bl."</Select>";
		
	return $bl;
}
function PrintBrand($brand)
{
global $db;

	$db->query("SELECT * FROM brand");
	
	
	if ($db->total == 0)	{
		$bl = $bl."-";
	}else{
		
		for($i=0 ; $i <$db->total ; $i++)
		{
			$db->fetch($i);
			if ($brand == $db->dt[id])
			{
				return $db->dt[brandname];
			}
			
			
		}		
	}
	
}

function CategoryList($vdepth,$category_id,$select_category="")
{
global $db;

	if($vdepth == 0){
		$nString = 3;
	}else if($vdepth == 1){
		$nString = 3;
	}else if($vdepth == 2){
		$nString = 6;
	}else if($vdepth == 3){
		$nString = 9;
	}else if($vdepth == 4){
		$nString = 12;
	}

	$db->query("SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where depth = '".($vdepth)."' and cid LIKE '".substr($category_id,0,$nString)."%'");
	//echo("SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where depth = '".($vdepth)."' and cid LIKE '".substr($category_id,0,$nString)."%'");
	
	$bl = "<Select name='category'>";	
	if ($db->total == 0)	{
		$bl = $bl."<Option>등록된 카테고리가 없습니다.</Option>";
	}else{
		$bl = $bl."<Option value=''>카테고리 선택</Option>";
		for($i=0 ; $i <$db->total ; $i++)
		{
			$db->fetch($i);
			if ($select_category == $db->dt[cid])
			{
				$strSelected = "Selected";
			}else{
				$strSelected = "";
			}
			
			$bl = $bl."<Option value='".$db->dt[cid]."' $strSelected>".$db->dt[cname]."</Option>";
		}		
	}
	
	$bl = $bl."</Select>";
		
		return $bl;
}

function PriceSelect($selectPrice)
{
$price  = "10000~100000:100000~500000:500000~1000000:1000000~2000000";

$pricearray = explode(":", $price);
$size = count($pricearray);

	if ($selectPrice == ""){
		$selectPrice = 0;
	}
	
		$m_string = "<select name='price' >";
		$m_string = $m_string."	<option>가격대</option>\n";
		for($i=0;$i < $size;$i++){
			$ary=explode("~",$pricearray[$i]);
			if ($selectPrice == $pricearray[$i]){//$numarray[$i]){
				$m_string = $m_string."	<option value='".$pricearray[$i]."' selected>".number_format($ary[0],0)." 원 ~ ".number_format($ary[1],0)." 원</option>\n";
			}else{
				$m_string = $m_string."	<option value='".$pricearray[$i]."'>".number_format($ary[0],0)." 원 ~ ".number_format($ary[1],0)." 원</option>\n";
			}
		
	}
	$m_string = $m_string."</select>";
	
	return $m_string;
}

function UseSelect($selectUse)
{
	global $db;

	$db->query("SELECT * FROM using_product");
	
	$bl = "<Select name='use'>";	
	if ($db->total == 0)	{
		$bl = $bl."<Option>등록된 카테고리가 없습니다.</Option>";
	}else{
		$bl = $bl."<Option value=0>용도 (가정용)</Option>";
		for($i=0 ; $i <$db->total ; $i++){
			$db->fetch($i);
			if ($selectUse == $db->dt[id])
			{
				$strSelected = "Selected";
			}else{
				$strSelected = "";
			}
			
			$bl = $bl."<Option value='".$db->dt[id]."' $strSelected>".$db->dt[using_desc]."</Option>";
		}		
	}
	
	$bl = $bl."</Select>";
		
	return $bl;
}

function AnnounceList($announce_type)
{
        global $db;	   
	$db->query("SELECT *, DATE_FORMAT(date,'%Y.%m.%d') AS day FROM news where div ='$announce_type' ORDER BY date DESC");
		$AL = "<table width='100%' border='0' cellspacing='0' cellpadding='0'>\n";		
		$AL = $AL."<tr height=2><td><a href='/shop/news.php'><img src='img/title_shopnotice.gif' border=0 align=absmiddle ></a></td></tr>\n";		
	for ($i = 0; $i < 5 && $i < $db->total; $i++)
	{
		$db->fetch($i);
            //    $AL = $AL."<tr height=26><td>".$db->dt[day]." - <a href='/news/news.php?showme=".$db->dt[no]."'>".CutStr($db->dt[subj], 40,"..")."</a></td></tr>\n";
                $AL = $AL."<tr height=26><td style='padding-left:5px;'>".$db->dt[day]." - <a href='/shop/news.php?showme=".$db->dt[no]."'>".cut_str($db->dt[subj],40)."</a></td></tr>\n";

		if ($i != 6)
		{
                      $AL = $AL."<tr height=1><td background='/img/dot.gif' colspan=2></td></tr>\n";
		}
	}
                    $AL = $AL."</table>	\n";
	return $AL;
	
}

function CutStr($str, $cnt, $tail='')
{
	if (strlen($str) <= $cnt)
	{
		return $str;
	}
	else
	{
		for ($p = 0; $p < $cnt; $p++)
		{
			if (ord($str[$p]) > 127)
			{
				$p++;
			}
		}
		return substr($str,0,$p).$tail;
	}
}


function GetThisCategory($this_cid,$this_depth)// 해당 카테고리 이름을 반환하는 함수 
{
	$mdb = new Database;
	
	$sql = "select c.cid,c.cname from ".TBL_SHOP_CATEGORY_INFO." c where cid LIKE '".substr($this_cid,0,($this_depth+1)*3)."%' and depth = '".$this_depth."'  ";
	
	$mdb->query($sql);
	
	$mdb->fetch(0);
	
	return $mdb->dt[cname];	
}

/*
function GetCategoryPath($this_cid,$this_depth)
{
	$mdb = new Database;
	
	$sql = "select c.cid,c.cname from ".TBL_SHOP_CATEGORY_INFO." c where cid = '".substr($this_cid,0,$this_depth*3).str_repeat("0",((5-$depth)*3))."' and depth = '".($this_depth-1)."' ";
	echo $sql;
	//$mdb->query($sql);
	
	//$mdb->fetch(0);
	
	//return $mdb->dt[cname];	
}
*/
function ReturnRelationCode($select_rid, $div) // ".TBL_SHOP_PRODUCT_RELATION." 아이디를 바탕으로 cid, pid 를 반환하는 함수
{
	
	$mdb = new Database;
	if ($div == "cid"){
		$sql = "select r.cid from ".TBL_SHOP_PRODUCT_RELATION." r where rid = $select_rid ";
	}else if($div == "pid"){
		$sql = "select r.pid from ".TBL_SHOP_PRODUCT_RELATION." r where rid = $select_rid ";	
	}
	$mdb->query($sql);	
	$mdb->fetch(0);
	
	return $mdb->dt[0];	
}

function ReturnRid($select_id,$select_cid) // ".TBL_SHOP_PRODUCT_RELATION." 아이디를 바탕으로 cid, pid 를 반환하는 함수
{
	
	$mdb = new Database;
	
	$sql = "select r.rid from ".TBL_SHOP_PRODUCT_RELATION." r where r.cid LIKE '".substr($select_cid,0,6)."%' and r.pid = '$select_id' ";	
	
	$mdb->query($sql);	
	$mdb->fetch(0);
	
	return $mdb->dt[0];	
}
?>