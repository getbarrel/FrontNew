<?php

/**
 * simple xss clean
 * using strip_tags
 * @author bgh
 * @date 2014.5.19
 *
 * @param mixed $input
 *
 * @return mixed
 */
function fbzXssClean($input)
{
    if (is_array($input)) {
        $result = array();
        foreach ($input as $key => $value):
            $key = strip_tags($key);
            if (is_array($value)) {
                $result[$key] = fbzXssClean($value);
            } else {
                $result[$key] = strip_tags($value);
            }
        endforeach;
        return $result;
    } else {
        return strip_tags($input);
    }
}

//신청솔루션 종류
function ShopDiv($status)
{
    if ($status == "S") {
        return "몰스토리 소호형";
    } else {
        return "몰스토리 비즈니스형";
    }
}

function UserSellingType()
{
    //해당 회원의 도소매 구분 함수 2014-07-09 이학봉
    // R: 소매 W:도매

    if (sess_val("user", "selling_type") == "R") {
        return "R";
    } else if (sess_val("user", "selling_type") == "W") {
        return "W";
    } else {
        return "R";
    }
}

function UserProductPriceType()
{
    //해당 회원의 가격 노출 함수 2015-07-14 홍진영
    if (sess_val("user", "dc_standard_price") == "p") {
        return "P"; // 프리미엄가
    } elseif (sess_val("user", "dc_standard_price") == "l") {
        return "L"; // 정가노출
    } else {
        return false;
    }
}

function UserProductPriceColumn()
{
    if (UserSellingType() == 'W') {
        if (UserProductPriceType() == 'L') {
            return 'wholesale_price';
        } else {
            return 'wholesale_sellprice';
        }
    } else {
        if (UserProductPriceType() == 'P') {
            return 'premiumprice';
        } elseif (UserProductPriceType() == 'L') {
            return 'listprice';
        } else {
            return 'sellprice';
        }
    }
}
if (!function_exists('roundBetter')) {

    function roundBetter($number, $precision = 0, $mode = PHP_ROUND_HALF_UP, $direction = NULL)
    {

        if (!isset($direction) || is_null($direction)) {

            //return round($number, $precision, $mode);
            //echo (strlen($number) - 1).":::".$precision;
            if ((strlen($number) - 1) < $precision) {
                $precision = $precision - 1;
            }
            if ((strlen($number) - 1) < $precision) {
                $precision = $precision - 1;
            }
            if ((strlen($number) - 1) >= $precision) {

                if ($mode == 1) {
                    return round($number, $precision * -1);
                } else if ($mode == 3) {

                    if ($precision) {
                        return floor($number / pow(10, $precision)) * pow(10, $precision);
                    } else {
                        return floor($number);
                    }
                } else if ($mode == 4) {

                    //echo $precision;
                    if ($precision) {
                        //echo "1차 가격 : ".$number/pow(10,$precision);
                        return ceil($number / pow(10, $precision)) * pow(10, $precision);
                    } else {
                        return ceil($number);
                    }
                } else {
                    return $number;
                }
            } else {
                return $number;
            }
        } else {
            $factor = pow(10, -1 * $precision);

            return strtolower(substr($direction, 0, 1)) == 'd' ? floor($number / $factor) * $factor : ceil($number / $factor) * $factor;
        }
    }
}
// roundBetterUp(1999, -3) => 2000
// roundBetterUp(1001, -3) => 2000
if (!function_exists('roundBetterUp')) {

    function roundBetterUp($number, $precision = 0, $mode = PHP_ROUND_HALF_UP)
    {
        return roundBetter($number, $precision, $mode, 'up');
    }
}
if (!function_exists('roundBetterDown')) {

    function roundBetterDown($number, $precision = 0, $mode = PHP_ROUND_HALF_UP)
    {
        return roundBetter($number, $precision, $mode, 'down');
    }
}

function regist_cupon($publish_ix, $code)
{
    global $slave_mdb, $master_db;

    $sql        = "Select publish_ix,use_date_type,publish_date_differ,publish_type,publish_date_type , regist_date_type, regist_date_differ,date_format(use_sdate,'%Y%m%d') as use_sdate, date_format(use_edate,'%Y%m%d') as use_edate,date_format(regdate,'%Y%m%d') as regdate
						from ".TBL_SHOP_CUPON_PUBLISH."
						where publish_ix = '".$publish_ix."'";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();
    $publish_ix = $slave_mdb->dt['publish_ix'];

    $p_year  = substr($slave_mdb->dt["regdate"], 0, 4);
    $p_month = substr($slave_mdb->dt["regdate"], 4, 2);
    $p_day   = substr($slave_mdb->dt["regdate"], 6, 2);

    if ($slave_mdb->dt['use_date_type'] == 1) {
        if ($slave_mdb->dt['publish_date_type'] == 1) {
            $publish_year = $p_year + $slave_mdb->dt['publish_date_differ'];
        } else {
            $publish_year = $p_year;
        }
        if ($slave_mdb->dt['publish_date_type'] == 2) {
            $publish_month = $p_month + $slave_mdb->dt['publish_date_differ'];
        } else {
            $publish_month = $p_month;
        }
        if ($slave_mdb->dt['publish_date_type'] == 3) {
            $publish_day = $p_day + $slave_mdb->dt['publish_date_differ'];
        } else {
            $publish_day = $p_day;
        }
        $use_sdate      = mktime(0, 0, 0, $p_month, $p_day, $p_year);
        $use_date_limit = mktime(0, 0, 0, $publish_month, $publish_day, $publish_year);

        //$event_date = mktime(0,0,0,$event_meonth,$event_day+$order[end_date_differ],$evet_year);
    } else if ($slave_mdb->dt['use_date_type'] == 2) {
        if ($slave_mdb->dt['regist_date_type'] == 1) {
            $regist_year = date("Y") + $slave_mdb->dt['regist_date_differ'];
        } else {
            $regist_year = date("Y");
        }
        if ($slave_mdb->dt['regist_date_type'] == 2) {
            $regist_month = date("m") + $slave_mdb->dt['regist_date_differ'];
        } else {
            $regist_month = date("m");
        }
        if ($slave_mdb->dt['regist_date_type'] == 3) {
            $regist_day = date("d") + $slave_mdb->dt['regist_date_differ'];
        } else {
            $regist_day = date("d");
        }
        $use_sdate      = time();
        $use_date_limit = mktime(0, 0, 0, $regist_month, $regist_day, $regist_year);
    } else if ($slave_mdb->dt['use_date_type'] == 3) {
        $use_sdate      = mktime(0, 0, 0, substr($slave_mdb->dt['use_sdate'], 4, 2), substr($slave_mdb->dt['use_sdate'], 6, 2),
            substr($slave_mdb->dt['use_sdate'], 0, 4));
        $use_date_limit = mktime(0, 0, 0, substr($slave_mdb->dt['use_edate'], 4, 2), substr($slave_mdb->dt['use_edate'], 6, 2),
            substr($slave_mdb->dt['use_edate'], 0, 4));
    }


    if ($slave_mdb->dt['publish_type'] == "1" || $slave_mdb->dt['publish_type'] == "2") {
        $use_sdate      = date("Ymd", $use_sdate);
        $use_date_limit = date("Ymd", $use_date_limit);

        $slave_mdb->query("Select publish_ix from ".TBL_SHOP_CUPON_REGIST." where publish_ix='$publish_ix' and mem_ix = '".$code."' ");

        if (!$slave_mdb->total) {
            $sql2 = "insert into ".TBL_SHOP_CUPON_REGIST." (regist_ix,publish_ix,mem_ix,open_yn,use_yn,use_sdate, use_date_limit, regdate)
						values
						('','".$publish_ix."','".$code."','1','0','$use_sdate','$use_date_limit',NOW())";

            //echo $sql2;
            $master_db->query($sql2);

            return 'complete';
        } else {
            return 'registed';
        }
    } else {
        return 'error';
    }
}

function getSellerPromotionNotice($pid)
{ //셀러 상품상세페이지 공지사항 이미지 2014-08-26 이학봉
    global $slave_mdb;

    $sql = "select `admin`,delivery_type from shop_product where id = '".$pid."'";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    if ($slave_mdb->dt['delivery_type'] == '2') {
        $company_id = $slave_mdb->dt['admin'];
    } else {
        $sql        = "select company_id from common_company_detail where com_type = 'A'";
        $slave_mdb->query($sql);
        $slave_mdb->fetch();
        $company_id = $slave_mdb->dt['company_id'];
    }

    $sql = "select
					*
				from
					common_seller_promotion_notice
				where
					company_id = '".$company_id."'
					and is_use = '1'";

    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    if ($slave_mdb->total > 0) {
        $info_array = getimagesize($_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]['mall_data_root']."/images/basic/sellergroup/seller_promotion_".$slave_mdb->dt['pn_ix'].".jpg");
        $width      = $info_array[0];

        return "<img src='".$_SESSION["layout_config"]['mall_data_root']."/images/basic/sellergroup/seller_promotion_".$slave_mdb->dt['pn_ix'].".jpg' ".(is_mobile()
                ? "width='100%'" : ($width > '1050' ? "width='1050'" : ""))." style='vertical-align:middle'>";
    }
}

function order_history2($user_code)
{ //셀러 상품상세페이지 공지사항 이미지 2014-08-26 이학봉
    global $slave_mdb;

    $where = "WHERE od.status <> '' ";

    $sql = "SELECT o.oid
					FROM ".TBL_SHOP_ORDER." o, ".TBL_SHOP_ORDER_DETAIL." od
					$where and od.oid = o.oid and o.user_code = '".$user_code."' and o.status != 'SR' $status_str $date_str
					GROUP BY o.oid ";
    $slave_mdb->query($sql);

    $order_list = $slave_mdb->fetchall('object');

    return $order_list;
}

function getScheduleBannerInfo($banner_position, $display_cid = "", $bool_subcategory = false)
{

    //global $script_times;
    global $slave_mdb;

    //$slave_mdb = new MySQL;

    if ($bool_subcategory) {

        if ($display_cid != "") {
            $sub_cid = substr($display_cid, 0, 3);
            $sql     = "select depth, cid
							from shop_category_info where cid like '".substr($sub_cid, 0, 3)."%' ";

            $slave_mdb->query($sql);

            if ($slave_mdb->total) {

                $cid_list = array();
                for ($i = 0; $i < $slave_mdb->total; $i++) {
                    $slave_mdb->fetch($i);
                    $cid_list[$i] = $slave_mdb->dt['cid'];
                }

                $cid_list = implode(",", $cid_list);

                //$add_where = " and display_cid = '".substr($display_cid,0, ($slave_mdb->dt[depth]+1)*3)."' ";
                $add_where = " and display_cid in ( ".$cid_list." )";
            }
        }
    } else {

        if ($display_cid != "") {
            $sql = "select depth
							from shop_category_info where cid = '".$display_cid."' ";
            $slave_mdb->query($sql);
            if ($slave_mdb->total) {
                $slave_mdb->fetch();

                //$add_where = " and display_cid = '".substr($display_cid,0, ($slave_mdb->dt[depth]+1)*3)."' ";
                $add_where = " and display_cid = '".$display_cid."' ";
            }
        }
    }


    $sql = "select b.banner_ix , b.banner_kind , b.banner_name
						from shop_bannerinfo b
						where banner_position = '$banner_position '
						".$add_where."
						and NOW() between use_sdate and use_edate
						and mall_ix in (NULL,'','".$_SESSION['layout_config']['mall_ix']."')
						order by rand() limit 1 ";



    $slave_mdb->query($sql);

    if ($slave_mdb->total) {
        $slave_mdb->fetch();
        $script_times["banner_".$banner_position."_".$slave_mdb->dt['banner_ix']] = $slave_mdb->dt['banner_name'];
        //echo nl2br($sql);
        //echo "banner_ix:".$slave_mdb->dt[banner_ix];
        return getBannerInfo($slave_mdb->dt['banner_ix']);
    } else {
        return "";
    }
}
/* 원본
  function getScheduleBannerInfo($banner_position, $display_cid=""){

  //global $script_times;
  global $slave_mdb;

  $slave_mdb = new MySQL;

  if($display_cid != ""){
  $sql = "select depth
  from shop_category_info where cid = '".$display_cid."' ";
  $slave_mdb->query($sql);
  if($slave_mdb->total){
  $slave_mdb->fetch();

  //$add_where = " and display_cid = '".substr($display_cid,0, ($slave_mdb->dt[depth]+1)*3)."' ";
  $add_where = " and display_cid = '".$display_cid."' ";
  }
  }
  $sql = "select b.banner_ix , b.banner_kind , b.banner_name
  from shop_bannerinfo b
  where banner_position = '$banner_position'
  ".$add_where."
  and NOW() between use_sdate and use_edate
  and mall_ix in (NULL,'','".$_SESSION['layout_config']['mall_ix']."')
  order by rand() limit 1 ";

  $slave_mdb->query($sql);

  if($slave_mdb->total){
  $slave_mdb->fetch();
  $script_times["banner_".$banner_position."_".$slave_mdb->dt[banner_ix]] = $slave_mdb->dt[banner_name];
  //echo nl2br($sql);
  //echo "banner_ix:".$slave_mdb->dt[banner_ix];
  return getBannerInfo($slave_mdb->dt[banner_ix]);
  }else{
  return "";
  }
  }
 */

//기본 서치 텍스트
function getSearchText()
{
    global $slave_mdb;
    $today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
    $sql   = "SELECT
					st_text
				FROM
					shop_search_text
				WHERE
					disp = 1 AND st_edate > $today
				ORDER BY RAND()
				LIMIT 1
				";

    //$slave_mdb = new Database;
    $slave_mdb->query($sql);
    $slave_mdb->fetch();
    $search_text = $slave_mdb->dt['st_text'];

    return $search_text;
}

// 배너 이미지 정보
function getBannerInfo($banner_ix, $type = "image")
{
    // 밑에 코드가
    // 사실상 banner_kind 를 받은데가 없고(항상 공백)
    // 어떤 값을 넘겨도 getDisplayBanner 함수에서
    // 디비에서 banner_kind 값을 가져와서 처리하기 때문에
    // 항상 해당 값은 의미가 없음.
    // 즉 인자가 의미가 없는것임.
    //                                 2016. 11. 1 이철성

    return getDisplayBanner($banner_kind, $banner_ix);
    exit;
    global $layout_config, $viewtype, $vdate, $SelectReport;
    if (!$_GET["viewtype"]) {
        $viewtype = $_GET["viewtype"];
    }
    //	echo "viewtype : ".$viewtype ;

    $slave_mdb = new Database;
    $slave_mdb->slave_db_setting();
    if ($viewtype == "analysis") {
        if ($vdate == "") {
            $vdate       = date("Ymd", time());
            $vyesterday  = date("Ymd", time() - 84600);
            $voneweekago = date("Ymd", time() - 84600 * 7);
        } else {
            if ($SelectReport == 3) {
                $vdate = $vdate."01";
            }
            $vweekenddate = date("Ymd", mktime(0, 0, 0, substr($vdate, 4, 2), substr($vdate, 6, 2), substr($vdate, 0, 4)) + 60 * 60 * 24 * 6);
            $vyesterday   = date("Ymd", mktime(0, 0, 0, substr($vdate, 4, 2), substr($vdate, 6, 2), substr($vdate, 0, 4)) - 60 * 60 * 24);
            $voneweekago  = date("Ymd", mktime(0, 0, 0, substr($vdate, 4, 2), substr($vdate, 6, 2), substr($vdate, 0, 4)) - 60 * 60 * 24 * 7);
        }

        if ($SelectReport == 1) {
            $vdate_str = " and bc.vdate = '$vdate'";
        } else if ($SelectReport == 2) {
            $vdate_str = " and bc.vdate between '$vdate' and '$vweekenddate'";
        } else if ($SelectReport == 3) {
            $vdate_str = " and bc.vdate LIKE '".substr($vdate, 0, 6)."%'  ";
        }

        //$sql = 	"SELECT banner_img,banner_ix,banner_link,banner_target,banner_width,banner_height FROM shop_bannerinfo where banner_ix = '".$banner_ix."' ";
        $sql = "select b.banner_ix, b.banner_kind, banner_img,banner_link,banner_target,banner_width,banner_height,disp,banner_name,
				IFNULL(sum(bc.ncnt),0) as ncnt
				from shop_bannerinfo b left join logstory_banner_click bc
				on b.banner_ix = bc.banner_ix and b.banner_ix = '".$banner_ix."' ".$vdate_str."
				where b.banner_ix = '".$banner_ix."' and disp = '1'
				group by b.banner_ix, banner_img,banner_link,banner_target,banner_width,banner_height  ";
        //echo $sql;
    } else {
        $sql = "SELECT banner_img,banner_ix,banner_link,banner_target,banner_width,banner_height,disp,banner_name FROM shop_bannerinfo where banner_ix = '".$banner_ix."' and disp = '1' ";
    }
    //echo $sql;
    $slave_mdb->query($sql);
    $slave_mdb->fetch();
    if ($slave_mdb->dt["disp"] == "1") {
        if ($slave_mdb->dt['banner_target'] == "_SELF") {
            $target = "";
        } else {
            $target = $slave_mdb->dt['banner_target'];
        }

        if ($viewtype == "analysis") {

            //print_r($slave_mdb->dt);
            if ($type == "image") {

                if ($slave_mdb->dt['banner_link'] != "" && $slave_mdb->dt['banner_link'] != "#") {

                    if (substr_count($slave_mdb->dt['banner_img'], '.swf') > 0) {
                        return "<script language='javascript'>generate_flash('".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."', '".$slave_mdb->dt['banner_width']."', '".$slave_mdb->dt['banner_height']."');</script>";
                    } else {
                        exit;
                        //return "<a href='".$slave_mdb->dt[banner_link]."' target='".$target."'><img src='".$_SESSION["layout_config"][mall_data_root]."/images/banner/".$slave_mdb->dt[banner_ix]."/".$slave_mdb->dt[banner_img]."'></a>";
                        return "<div class='stats_index'><div><span>".$slave_mdb->dt['ncnt']."</span></div>
							<a href='/banner.link.php?banner_ix=".$slave_mdb->dt['banner_ix']."' target='".$target."'><img src='".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."'></a>
							</div>";
                    }
                } else {

                    if (substr_count($slave_mdb->dt['banner_img'], '.swf') > 0) {
                        return "<script language='javascript'>generate_flash('".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."', '".$slave_mdb->dt['banner_width']."', '".$slave_mdb->dt['banner_height']."');</script>";
                    } else {
                        return "<div class='stats_index'><div><span>".$slave_mdb->dt['ncnt']."</span></div><img src='".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."' style='vertical-align:middle'></div>";
                    }
                }
            } else {
                return $_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img'];
            }
        } else {
            exit;
            if ($type == "image") {
                if ($slave_mdb->dt['banner_link'] != "" && $slave_mdb->dt['banner_link'] != "#") {

                    if (substr_count($slave_mdb->dt['banner_img'], '.swf') > 0) {
                        return "<script language='javascript'>generate_flash('".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."', '".$slave_mdb->dt['banner_width']."', '".$slave_mdb->dt['banner_height']."');</script>";
                    } else {
                        return "<!--a href='".$slave_mdb->dt['banner_link']."' target='".$target."'--><a href='/banner.link.php?banner_ix=".$slave_mdb->dt['banner_ix']."' target='".$target."'><img src='".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."'></a>";
                        //return "<a href='/banner.link.php?banner_ix=".$slave_mdb->dt[banner_ix]."' target='".$target."'><img src='".$_SESSION["layout_config"][mall_data_root]."/images/banner/".$slave_mdb->dt[banner_ix]."/".$slave_mdb->dt[banner_img]."'></a>";
                    }
                } else {
                    if (substr_count($slave_mdb->dt['banner_img'], '.swf') > 0) {
                        return "<script language='javascript'>generate_flash('".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."', '".$slave_mdb->dt['banner_width']."', '".$slave_mdb->dt['banner_height']."');</script>";
                    } else {
                        return "<img src='".$_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img']."' style='vertical-align:middle'>";
                    }
                }
            } else {
                return $_SESSION["layout_config"]['mall_data_root']."/images/banner/".$slave_mdb->dt['banner_ix']."/".$slave_mdb->dt['banner_img'];
            }
        }
    } else {
        return "<div style='width:".$slave_mdb->dt['banner_width']."px;height:".$slave_mdb->dt['banner_height']."px;'></div>";
    }
}
if (!function_exists("getDisplayBanner")) {

    function getDisplayBanner($banner_kind, $banner_ix = false, $banner_width = false, $banner_height = false, $div_ix = false, $cid = false,
                              $class = false)
    {
        global $layout_config;
        global $slave_mdb;
        //$slave_mdb = new Database;

        $mall_data_root = IMAGE_SERVER_DOMAIN.$_SESSION["layout_config"]['mall_data_root'];

        $sql         = "select
						b.banner_page
					from
						shop_bannerinfo b
					where
						banner_ix = '$banner_ix'
						and disp ='1'
					limit 1";
        $slave_mdb->query($sql);
        $slave_mdb->fetch();
        $banner_page = $slave_mdb->dt['banner_page'] ?? '';

        if ($banner_page == '66') {
            $sql = "select
							b.banner_ix , b.banner_kind , b.banner_name
						from
							shop_bannerinfo b
						where
							banner_ix = '$banner_ix'
							and disp ='1'
						order by use_sdate asc , use_edate asc
						limit 1 ";

            $slave_mdb->query($sql);
            $slave_mdb->fetch();
        } else {
            $sql = "select
							b.banner_ix , b.banner_kind , b.banner_name
						from
							shop_bannerinfo b
						where
							banner_ix = '$banner_ix'
							and disp ='1'
							and NOW() between use_sdate and use_edate
						order by use_sdate asc , use_edate asc
						limit 1 ";

            $slave_mdb->query($sql);
            $slave_mdb->fetch();
        }

        $banner_kind = $slave_mdb->dt['banner_kind'] ?? '';

        $today_srch = date("YmdHi");

        $where = "WHERE bi.disp='1' AND b.sdate <= '".$today_srch."' AND b.edate >= '".$today_srch."' ";

        if ($banner_kind == 1) { // 일반배너
            if ($banner_ix) $where .= " AND bi.banner_ix = ".$banner_ix;
            if ($div_ix) $where .= " AND bd.div_ix = ".$div_ix;
            if ($cid) $where .= " AND b.cid = '".$cid."'";
            /*
              $sql = "SELECT * FROM shop_bannerinfo bi
              INNER JOIN shop_display_banner b ON bi.banner_ix = b.banner_ix AND b.banner_div = '$banner_kind'
              LEFT OUTER JOIN shop_banner_div bd ON b.div_ix=bd.div_ix
              ".$where;
             */
            $sql   = "select b.banner_ix, b.banner_kind, change_effect, banner_img,banner_img_on,banner_btn_position, banner_link,banner_target,banner_width,banner_height,disp,banner_name,
				IFNULL(sum(bc.ncnt),0) as ncnt
				from shop_bannerinfo b left join logstory_banner_click bc
				on b.banner_ix = bc.banner_ix and b.banner_ix = '".$banner_ix."' ".$vdate_str."
				where b.banner_ix = '".$banner_ix."' and disp ='1'
				group by b.banner_ix, banner_img,banner_link,banner_target,banner_width,banner_height  ";

            //echo nl2br($sql);
            //exit;
            $slave_mdb->query($sql);
            if ($slave_mdb->total) {
                for ($i = 0; $i < $slave_mdb->total; $i++) {
                    $slave_mdb->fetch($i);
                    $banner_ix     = $slave_mdb->dt['banner_ix'];
                    $banner_img    = $slave_mdb->dt['banner_img'];
                    $banner_width  = $slave_mdb->dt['banner_width'];
                    $banner_height = $slave_mdb->dt['banner_height'];
                    $banner_img_on = $slave_mdb->dt['banner_img_on'];
                    $banner_on_use = $slave_mdb->dt['banner_on_use'];
                    $banner_target = strtolower($slave_mdb->dt['banner_target']); //150907 strtolower 추가 [_SELF 대문자 일떄 인식을 못해서] by pyw
                    //150907 추가 모바일 iframe으로 수정되어서 _self가 아닌 _parent by pyw
                    if (is_mobile()) $banner_target = "_parent";

                    $imgPath = $mall_data_root."/images/banner/".$banner_ix."/";
                    if ($i > 0) $mString."<BR>";

                    if (substr_count($banner_img, '.swf') > 0) {
                        $mString .= "<script language='javascript'>generate_flash('".$layout_config['mall_data_root']."/images/banner/".$banner_ix."/".$banner_img."', '".$banner_width."', '".$banner_height."');</script>";
                    } else if ($banner_on_use == "Y" || $banner_img_on) { // 마우스오버시 바로 이미지가 바뀌는 오버기능 사용시
                        if ($_GET["viewtype"] == "analysis") {
                            $mString .= "<div class='stats_index'><div><span>".$slave_mdb->dt['ncnt']."</span></div>";
                        }
                        if ($slave_mdb->dt['banner_link'] != "" && $slave_mdb->dt['banner_link'] != "#") {

                            $mString .= "<a href='/banner.link.php?banner_ix=".$banner_ix."' target='".$banner_target."'><img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img."' width='".$banner_width."' height='".$banner_height."' onmouseover='this.src=\"".$imgPath.$banner_img_on."\"' onmouseout='this.src=\"".$imgPath.$banner_img."\"'></a>"; //<li ".$class."></li>
                        } else {
                            $mString .= "<img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img."' width='".$banner_width."' height='".$banner_height."' onmouseover='this.src=\"".$imgPath.$banner_img_on."\"' onmouseout='this.src=\"".$imgPath.$banner_img."\"'>"; //<li ".$class."></li>
                        }
                        if ($_GET["viewtype"] == "analysis") {
                            $mString .= "</div>";
                        }
                    } else if ($banner_img_on) { // 롤오버 이미지가 있으면
                        //$mString .= "<li>";
                        if ($_GET["viewtype"] == "analysis") {
                            $mString .= "<div><span>".$slave_mdb->dt['ncnt']."</span></div>";
                        }
                        if ($slave_mdb->dt['banner_link'] != "" && $slave_mdb->dt['banner_link'] != "#") {
                            $mString .= "<a href='/banner.link.php?banner_ix=".$banner_ix."' target='".$banner_target."'><img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img."' width='".$banner_width."' height='".$banner_height."'></a>";
                            $mString .= "<a href='/banner.link.php?banner_ix=".$banner_ix."' target='".$banner_target."'><img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img_on."'  width='".$banner_width."' height='".$banner_height."'></a>";
                        } else {
                            $mString .= "<img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img."' width='".$banner_width."' height='".$banner_height."'>
								<img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img_on."'  width='".$banner_width."' height='".$banner_height."'>";
                        }
                        if ($_GET["viewtype"] == "analysis") {
                            $mString .= "</div>";
                        }
                    } else {
                        if ($_GET["viewtype"] == "analysis") {
                            $mString .= "<div class='stats_index'><div><span>".$slave_mdb->dt['ncnt']."</span></div>";
                        }
                        if ($slave_mdb->dt['banner_link'] != "" && $slave_mdb->dt['banner_link'] != "#") {

                            $mString .= "<a href='".$slave_mdb->dt['banner_link']."' target='".$banner_target."'><img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img."'  width='".$banner_width."' height='".$banner_height."'></a>";
                        } else {
                            $mString .= "<img src='".$mall_data_root."/images/banner/".$banner_ix."/".$banner_img."'  width='".$banner_width."' height='".$banner_height."'>"; //<li ".$class."></li>
                        }
                        if ($_GET["viewtype"] == "analysis") {
                            $mString .= "</div>";
                        }
                    }
                }
            }
        } else if ($banner_kind == 2 || $banner_kind == 3) { // 플래시,슬라이드배너
            if ($banner_ix) $where .= " AND bi.bd_ix = ".$banner_ix;
            if ($div_ix) $where .= " AND bd.div_ix = ".$div_ix;
            /*
              $sql = "SELECT * FROM ".TBL_SHOP_MANAGE_FLASH." bi
              INNER JOIN shop_display_banner b ON bi.bd_ix = b.banner_ix AND b.banner_div = '$banner_kind'
              LEFT OUTER JOIN shop_banner_div bd ON b.div_ix=bd.div_ix
              LEFT OUTER JOIN shop_manage_flash_detail mfd on bi.bd_ix = mfd.bd_ix
              ".$where;
             */
            $sql   = "select b.banner_ix, b.banner_kind, change_effect, banner_img,banner_link,banner_target,banner_btn_position, banner_width,banner_height,disp,banner_name, bd.*,
				IFNULL(sum(bc.ncnt),0) as ncnt
				from shop_bannerinfo b left join shop_bannerinfo_detail bd on b.banner_ix = bd.banner_ix
				left join logstory_banner_click bc
				on b.banner_ix = bc.banner_ix and b.banner_ix = '".$banner_ix."' ".$vdate_str."
				where b.banner_ix = '".$banner_ix."' and disp ='1'
				group by b.banner_ix, bd.bd_ix, banner_img,banner_link,banner_target,banner_width,banner_height
				order by bd.vieworder";

            //echo nl2br($sql);
            //exit;
            $slave_mdb->query($sql);
            if ($banner_kind == 2) { // 플래시배너
                $i_no       = 0;
                $btn_no     = "";
                $printflash = $slave_mdb->fetchall();
                $banner_ix  = $printflash[0]['banner_ix'];

                $banner_btn_position = $printflash[0]['banner_btn_position'];
                $banner_width        = $printflash[0]['banner_width'];
                $banner_height       = $printflash[0]['banner_height'];
                $change_effect       = $printflash[0]['change_effect'];
                //echo "change_effect:".$change_effect;
                $banner_btn_left     = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_left.png";
                $banner_btn_left_on  = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_left_on.png";
                $banner_btn_right    = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_right.png";
                $banner_btn_right_on = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_right_on.png";

                if (is_array($printflash)) {
                    foreach ($printflash as $_key => $_val) {
                        if ($printflash[$_key]['bd_file'] != "") { //이미지값과 네비게이션 숫자 데이터를 담아둔다
                            $i_no++;
                            $imgPath = $mall_data_root."/images/banner/".$banner_ix."/"; //$printflash[$_key][bd_ix]

                            if ($printflash[$_key]['bd_link'] != "" && $printflash[$_key]['bd_link'] != "#") {
                                $imgString .= "<a class='slide' href='/banner.link.php?banner_ix=".$banner_ix."&bd_ix=".$printflash[$_key]['bd_ix']."' target='".$target."'><!--a href='".$printflash[$_key]['bd_link']."'--><img src='".$imgPath.$printflash[$_key]['bd_file']."' title='".$printflash[$_key]['bd_title']."' width='".$banner_width."' height='".$banner_height."'></a>";
                            } else {
                                $imgString .= "<img class='slide' src='".$imgPath.$printflash[$_key]['bd_file']."' title='".$printflash[$_key]['bd_title']."' width='".$banner_width."' height='".$banner_height."' style='z-index:-1000;'>";
                            }
                        }
                    }
                }
                //echo $imgString;
                //exit;
                $bd_ix = $printflash[0]['bd_ix'];


                $time_sec = $printflash[0]['time_sec'] * 1000;
                if (!$time_sec) $time_sec = 4000;


                $mString .= "

				<STYLE>
				#slider-wrapper {
					background:url(/images/slider.png) no-repeat;
					width:".$banner_width."px;
					height:".$banner_height."px;
					margin:0 auto;
					padding-top:74px;
					margin-top:50px;
				}
				.forbizSlider {
					position:relative;
					overflow:hidden;
				}
				.fzSliderWrapper {
					display:block;
					position:absolute;
					z-index:5;
					top:0;
					left:0;
				}
				.fzSliderWrapper .fzSlide {
					display:block;
					float:left;
				}
				.forbizSlider .fzSliderPrev {
					display:block;
					position:absolute;
					top:50%;
					left:0;
					z-index:10;
				}
				.forbizSlider .fzSliderNext {
					display:block;
					position:absolute;
					top:50%;
					right:0;
					z-index:10;
				}
				.forbizSlider .fzSliderPrev.disabled ,
				.forbizSlider .fzSliderNext.disabled {
					  cursor:default;
					  -ms-filter: 'progid:DXImageTransform.Microsoft.Alpha(Opacity=10)';
					  filter: alpha(opacity=10);
					  -moz-opacity: 0.1;
					  -khtml-opacity: 0.1;
					  opacity: 0.1;
				}
				.forbizSlider .fzSliderPager {
					position:absolute;
					top:10px;
					right:10px;
					z-index:99;
					display:none;
				}
				.forbizSlider .fzPagerLink {
					display:block;
					float:left;
					width:10px;
					height:10px;
					margin-left:5px;
					background-color:#a7a7a7;
				}
				.forbizSlider .fzPagerLink.active { background-color:#000000; }
				#slider {
					position:relative;
					width:".$banner_width."px;
					height:".$banner_height."px;
					margin-left:0px;
					margin-bottom:10px;
					background:url(/images/loading.gif) no-repeat 50% 50%;
				}

				</STYLE>
					";

                $mString .= "<div id='slider_".$banner_ix."' class='forbizSlider nivoSlider' style='width:".$banner_width."px;height:".$banner_height."px; display: none;'>";
                $mString .= "{$imgString}";
                $mString .= "</div>";
                if ($i_no > 1) {

                    $mString .= "
							<script>
							$(function() { $('.nivoSlider').css('display', '');";
                    if ($change_effect == "S") {

                        /** 	$mString .= "
                          $('#slider_".$banner_ix."').nivoSlider({
                          effect:'slideInLeft',
                          pauseTime:".$time_sec.",
                          pauseOnHover:true,";

                          if(file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_left) && file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_right)){
                          $mString .= "
                          prevText: '<img src=\'".$banner_btn_left."\' off_src=\'".$banner_btn_left."\' on_src=\'".$banner_btn_left_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />',
                          nextText: '<img src=\'".$banner_btn_right."\' off_src=\'".$banner_btn_right."\' on_src=\'".$banner_btn_right_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />'";
                          }else{
                          $mString .= "
                          prevText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveL.png' />\",
                          nextText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveR.png' />\"";

                          }
                          $mString .= "
                          });
                          "; */
                        $mString .= "
								$('#slider_".$banner_ix."').forbizSlider({
									pauseTime:".$time_sec.",
									pauseOnHover:true,";
                        if (file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_left) && file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_right)) {
                            $mString .= "
									prevText: '<img src=\'".$banner_btn_left."\' off_src=\'".$banner_btn_left."\' on_src=\'".$banner_btn_left_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />',
									nextText: '<img src=\'".$banner_btn_right."\' off_src=\'".$banner_btn_right."\' on_src=\'".$banner_btn_right_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />'";
                        } else {
                            $mString .= "
									prevText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveL.png' />\",
									nextText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveR.png' />\"";
                        }
                        $mString .= "
								});
							";
                    } else if ($change_effect == "F") {
                        $mString .= "
								$('#slider_".$banner_ix."').nivoSlider({
									effect:'fade',
									pauseTime:".$time_sec.",
									pauseOnHover:true,";

                        if (file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_left) && file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_right)) {
                            $mString .= "
									prevText: '<img src=\'".$banner_btn_left."\' off_src=\'".$banner_btn_left."\' on_src=\'".$banner_btn_left_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />',
									nextText: '<img src=\'".$banner_btn_right."\' off_src=\'".$banner_btn_right."\' on_src=\'".$banner_btn_right_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />'";
                        } else {
                            $mString .= "
									prevText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveL.png' />\",
									nextText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveR.png' />\"";
                        }
                        $mString .= "
								});";
                    } else if ($change_effect == "T") {
                        $mString .= "
								$('#slider_".$banner_ix."').nivoSlider({
									effect:'fold',
									pauseTime:".$time_sec.",
									pauseOnHover:true,";

                        if (file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_left) && file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_right)) {
                            $mString .= "
									prevText: '<img src=\'".$banner_btn_left."\' off_src=\'".$banner_btn_left."\' on_src=\'".$banner_btn_left_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />',
									nextText: '<img src=\'".$banner_btn_right."\' off_src=\'".$banner_btn_right."\' on_src=\'".$banner_btn_right_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />'";
                        } else {
                            $mString .= "
									prevText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveL.png' />\",
									nextText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveR.png' />\"";
                        }
                        $mString .= "
								});";
                    } else if ($change_effect == "R") {
                        $mString .= "
								$('#slider_".$banner_ix."').nivoSlider({
									effect:'random',
									animSpeed:1500,
									pauseTime:".$time_sec.",
									startSlide:2,
									directionNav:true,
									controlNav:true,
									keyboardNav:false,
									pauseOnHover:false,";

                        if (file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_left) && file_exists($_SERVER["DOCUMENT_ROOT"].$banner_btn_right)) {
                            $mString .= "
									prevText: '<img src=\'".$banner_btn_left."\' off_src=\'".$banner_btn_left."\' on_src=\'".$banner_btn_left_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />',
									nextText: '<img src=\'".$banner_btn_right."\' off_src=\'".$banner_btn_right."\' on_src=\'".$banner_btn_right_on."\' onmouseover=\"$(this).attr(\'src\',$(this).attr(\'on_src\'));\" onmouseout=\"$(this).attr(\'src\',$(this).attr(\'off_src\'));\"  />'";
                        } else {
                            $mString .= "
									prevText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveL.png' />\",
									nextText:\"<img src='/data/daiso_data/templet/daiso/images/btns/moveR.png' />\"";
                        }
                        $mString .= "
								});";
                    }
                    $mString .= "
						});
							</script>
							<script type='text/javascript' language=javascript src='".$_SESSION["layout_config"]["mall_data_root"]."/templet/".$_SESSION["layout_config"]["mall_use_templete"]."/js/jquery.nivo.slider.pack.js'></script>
							<script type='text/javascript' language=javascript src='".$_SESSION["layout_config"]["mall_data_root"]."/templet/".$_SESSION["layout_config"]["mall_use_templete"]."/js/jquery.forbiz.slider.js'></script>
							";
                }
            } else if ($banner_kind == 3) { // 슬라이드 배너
                $printflash          = $slave_mdb->fetchall();
                $banner_ix           = $printflash[0]['banner_ix'];
                $banner_btn_position = $printflash[0]['banner_btn_position'];
                $banner_width        = $printflash[0]['banner_width'];
                $banner_height       = $printflash[0]['banner_height'];
                $change_effect       = $printflash[0]['change_effect'];
                //echo "change_effect:".$change_effect;
                //print_r($printflash);
                if (is_array($printflash)) {
                    $html = '<div class="slide_banner_box" style="position:relative;float:left;width:'.$banner_width.'px;overflow:hidden;height:'.$banner_height.'px;z-index:9; " id="main_scroll_width1">
									<div id="slide_banner_'.$banner_ix.'" class="goods" style="float:left;width:'.$banner_width.';white-space:nowrap;margin:0; height:'.$banner_height.'px; overflow:hidden; z-index:-10;">';
                    foreach ($printflash as $_key => $_val) {
                        if ($printflash[$_key]['bd_file'] != "") { //이미지값과 네비게이션 숫자 데이터를 담아둔다
                            $i_no++;
                            $imgPath = $mall_data_root."/images/banner/".$banner_ix."/".$printflash[$_key]['bd_file']; //$printflash[$_key][bd_ix]

                            $_html .= "<ul class='banners' style='float:left;z-index:-5;'>";
                            if ($printflash[$_key]['bd_link'] != "" && $printflash[$_key]['bd_link'] != "#") {
                                $_html .= "	<li><a href='".$printflash[$_key]['bd_link']."'><img src='".$imgPath."' title='".$printflash[$_key]['bd_title']."' style='width:".$banner_width."' ></a></li>";
                            } else {
                                $_html .= "	<li><img src='".$imgPath."' title='".$printflash[$_key]['bd_title']."'  style='width:".$banner_width."'/></li>";
                            }
                            $_html .= "</ul>";
                        }
                    }
                    if (substr_count($imgPath, 'http') == 0) {
                        $imgPath = $_SERVER['DOCUMENT_ROOT'].$imgPath;
                    }
                    $img_size = getimagesize($imgPath);
                    $width    = $img_size[0];
                    $height   = $img_size[1];
                    //$_html .= $_html.$_html;
                    //	copy($banner_btn_left, $_SERVER["DOCUMENT_ROOT"]."".$mall_data_root."/images/banner/".$banner_ix."/banner_btn_left.jpg");
                    //echo $mall_data_root."/images/banner/".$banner_ix."/banner_btn_left.png";
                    //exit;

                    if (file_exists($_SERVER["DOCUMENT_ROOT"]."".$_SESSION["layout_config"]['mall_data_root']."/images/banner/$banner_ix/banner_btn_left.png")) {
                        $banner_btn_left = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_left.png";
                    } else {
                        $banner_btn_left = $_SESSION["layout_config"]['mall_templet_webpath']."/images/btns/moveL.png"; //"left.png";
                    }
                    if (file_exists($_SERVER["DOCUMENT_ROOT"]."".$_SESSION["layout_config"]['mall_data_root']."/images/banner/$banner_ix/banner_btn_left_on.png")) {
                        $banner_btn_left_on = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_left_on.png";
                    } else {
                        $banner_btn_left_on = $_SESSION["layout_config"]['mall_templet_webpath']."/images/btns/moveL_on.png"; //"left_on.png";
                    }

                    if (file_exists($_SERVER["DOCUMENT_ROOT"]."".$_SESSION["layout_config"]['mall_data_root']."/images/banner/$banner_ix/banner_btn_right.png")) {
                        $banner_btn_right = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_right.png";
                    } else {
                        $banner_btn_right = $_SESSION["layout_config"]['mall_templet_webpath']."/images/btns/moveR.png"; //"left.png";
                    }
                    if (file_exists($_SERVER["DOCUMENT_ROOT"]."".$_SESSION["layout_config"]['mall_data_root']."/images/banner/$banner_ix/banner_btn_right_on.png")) {
                        $banner_btn_right_on = $mall_data_root."/images/banner/".$banner_ix."/banner_btn_right_on.png";
                    } else {
                        $banner_btn_right_on = $_SESSION["layout_config"]['mall_templet_webpath']."/images/btns/moveR_on.png"; //"left_on.png";
                    }

                    $html .= $_html."</div>";
                    if ($banner_btn_position == 1) {
                        $html .= $_html."
							<div id='slide_banner_btn_".$banner_ix."' class='s_l_b' style='position:absolute;top:0;left:0;'>
								<ul>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
									</li>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
									</li>
								</ul>
							</div>";
                    } else if ($banner_btn_position == 2) {
                        $html .= $_html."
							<div id='slide_banner_btn_".$banner_ix."' class='s_l_b' style='position:absolute;top:0;left:50%;'>
								<ul style='margin-left:-50%;'>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
									</li>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
									</li>
								</ul>
							</div>";
                    } else if ($banner_btn_position == 3) {
                        $html .= $_html."
							<div id='slide_banner_btn_".$banner_ix."' class='s_l_b' style='position:absolute;top:0;right:0;'>
								<ul>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
									</li>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
									</li>
								</ul>
							</div>";
                    } else if ($banner_btn_position == 5) {
                        $html .= $_html."
							<div id='slide_banner_btn_".$banner_ix."' class='s_l_b' style='position:absolute;bottom:0;left:0;'>
								<ul>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
									</li>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
									</li>
								</ul>
							</div>";
                    } else if ($banner_btn_position == 6) {
                        $html .= $_html."
							<div id='slide_banner_btn_".$banner_ix."' class='s_l_b' style='position:absolute;bottom:0;left:50%;'>
								<ul style='margin-left:-50%;'>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
									</li>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
									</li>
								</ul>
							</div>";
                    } else if ($banner_btn_position == 7) {
                        $html .= $_html."
							<div id='slide_banner_btn_".$banner_ix."' class='s_l_b' style='position:absolute;bottom:0;right:0;'>
								<ul>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."'  nmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
									</li>
									<li>
										<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
									</li>
								</ul>
							</div>";
                    } else {
                        $html .= $_html."
							<div class='s_l_b' style='position:absolute; z-index:9; top:41%;right:0px;'>
								<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',-".$width.");\"><img src='".$banner_btn_right."' on_src='".$banner_btn_right_on."' out_src='".$banner_btn_right."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title='' /></a>
							</div>
							<div class='s_l_b' style='position:absolute; z-index:9; top:41%;left:0px;'>
								<a href=\"javascript:clickbannerScroll('slide_banner_".$banner_ix."',".$width.");\"><img src='".$banner_btn_left."' on_src='".$banner_btn_left_on."' out_src='".$banner_btn_left."' onmouseover=\"$(this).attr('src',$(this).attr('on_src'))\" onmouseout=\"$(this).attr('src',$(this).attr('out_src'))\"  alt='' title=''/></a>
							</div>";
                    }
                    $html .= $_html."</div>";
                }


                $html    .= "<script type='text/javascript' language=javascript src='".$_SESSION["layout_config"]["mall_data_root"]."/templet/".$_SESSION["layout_config"]["mall_use_templete"]."/js/jquery.nivo.slider.pack.js'></script>";
                $html    .= "<script type='text/javascript' language=javascript src='".$_SESSION["layout_config"]["mall_data_root"]."/templet/".$_SESSION["layout_config"]["mall_use_templete"]."/js/jquery.forbiz.slider.js'></script>";
                $html    .= "<script language='javascript'>
								<!--
									var slideBanner_".$banner_ix." = setInterval(\"clickbannerScroll('slide_banner_".$banner_ix."',-".$width.")\", 3000);
									$('div#slide_banner_".$banner_ix.",div#slide_banner_btn_".$banner_ix.", .s_l_b').hover(function()	{
										clearInterval(slideBanner_".$banner_ix.");
									}, function()
									{
										slideBanner_".$banner_ix." = setInterval(\"clickbannerScroll('slide_banner_".$banner_ix."',-".$width.")\", 3000);
									});
								//-->
								if ($.fn.forbizSlider) {
									$.fn.forbizSlider.setupTouchSlide($('#slide_banner_".$banner_ix." .banners'), function(direction) {
										switch(direction) {
											case -1:
												clickbannerScroll('slide_banner_".$banner_ix."', -".$width.", 400);
												break;

											case 1:
												clickbannerScroll('slide_banner_".$banner_ix."', ".$width.", 400);
												break;

											default:
												break;
										}
									});
								}
								</script>";
                $mString = $html;
            }
        } else if ($banner_kind == 4) { // 동영상 배너
            $sql = "select b.banner_ix, b.banner_kind, change_effect, banner_html,banner_img_on, banner_link,banner_target,banner_width,banner_height,disp,
				IFNULL(sum(bc.ncnt),0) as ncnt
				from shop_bannerinfo b left join logstory_banner_click bc
				on b.banner_ix = bc.banner_ix and b.banner_ix = '".$banner_ix."' ".$vdate_str."
				where b.banner_ix = '".$banner_ix."' and disp ='1'
				group by b.banner_ix, banner_img,banner_link,banner_target,banner_width,banner_height  ";

            //echo nl2br($sql);
            $slave_mdb->query($sql);
            $slave_mdb->fetch();
            $mString = $slave_mdb->dt['banner_html'];
        } else if ($banner_kind == 5) { // 사용자지정 배너
            $sql = "select
							b.banner_ix, b.banner_kind, b.use_sdate, b.use_edate, change_effect, banner_img,banner_link,banner_target,
							banner_width,banner_height,disp,banner_name, bd.*, IFNULL(sum(bc.ncnt),0) as ncnt
						from
							shop_bannerinfo b
							left join shop_bannerinfo_detail bd on b.banner_ix = bd.banner_ix
							left join logstory_banner_click bc on b.banner_ix = bc.banner_ix and b.banner_ix = '".$banner_ix."' ".$vdate_str."
						where
							b.banner_ix = '".$banner_ix."'
							and disp ='1'
						group by b.banner_ix, bd.bd_ix, banner_img,banner_link,banner_target,banner_width,banner_height
						order by bd.vieworder ";

            //echo nl2br($sql);
            //exit;
            //echo nl2br($sql);
            $slave_mdb->query($sql);
            $banner_infos = $slave_mdb->fetchall();
            //print_r($banner_infos);
            //exit;
            return $banner_infos;
        }

        // 배너유입수 Log Insert
        return $mString;
    }
}

//새로운 회원타입을 출력해준다.
function getMemType($mem_type)
{
    if ($mem_type == "M") {
        $mstring = "일반회원";
    } else if ($mem_type == "C") {
        $mstring = "기업회원";
    } else if ($mem_type == "F") {
        $mstring = "외국인회원";
    } else if ($mem_type == "S") {
        $mstring = "셀러회원";
    } else if ($mem_type == "A") {
        $mstring = "관리자";
    } else if ($mem_type == "MD") {
        $mstring = "MD회원";
    } else {
        $mstring = $mem_type;
    }
    return $mstring;
}

function getProductType($product_type)
{
    if ($product_type == "0") {
        $mstring = "일반";
    } else if ($product_type == "1") {
        $mstring = "사이트 주문";
    } else if ($product_type == "2") {
        $mstring = "선매입";
    } else if ($product_type == "6") {
        $mstring = "모바일등록상품";
    } else if ($product_type == "77") {
        $mstring = "사은품";
    } else if ($product_type == "88") {
        $mstring = "기획상품";
    } else if ($product_type == "99") {
        $mstring = "세트상품";
    } else {
        $mstring = $mem_type;
    }
    return $mstring;
}

// HTML Tag를 제거하는 함수
function del_html($str)
{
    $str = str_replace(">", "&gt;", $str);
    $str = str_replace("<", "&lt;", $str);
    return $str;
}

// 상품의 출고 형태 반환하는 함수
function getOrderStatus($status, $method = "")
{

    global $_LANGUAGE;

    if ($admininfo["language"] == "english") {
        if ($status == "SR") {
            if ($method == ORDER_METHOD_CARD) {
                $mstring = "<font color=#FF0000 class='p11 ls1'>카드결제중</font>";
            } elseif ($method == ORDER_METHOD_BANK) {
                $mstring = "<font color=#FF0000 class='p11 ls1'>계좌입금전</font>";
            } elseif ($method == ORDER_METHOD_PHONE) {
                $mstring = "<font color=#FF0000 class='p11 ls1'>전화결제중</font>";
            } elseif ($method == ORDER_METHOD_VBANK) {
                $mstring = "<font color=#FF0000 class='p11 ls1'>가상계좌입금전</font>";
            } elseif ($method == ORDER_METHOD_ICHE) {
                $mstring = "<font color=#FF0000 class='p11 ls1'>실시간<br>계좌이체중</font>";
            } elseif ($method == ORDER_METHOD_ASCROW) {
                $mstring = "<font color=#FF0000 class='p11 ls1'>에스크로결제중</font>";
            }
        } else if ($status == "IR") {
            $mstring = "<font color=#FF0000 class='p11 ls1'>Awating Payment</font>";
        } else if ($status == "IC") {
            $mstring = "<font class='p11 ls1'>Complete Payment</font>";
        } else if ($status == "DR") {
            $mstring = "<font color=green class='p11 ls1'>Ready for Delivery</font>"; //색깔 변경 kbk 13/06/12
        } else if ($status == "DI") {
            $mstring = "<font color=blue class='p11 ls1'>Shipped In</font>";
        } else if ($status == "DC") {
            $mstring = "<font color=red class='p11 ls1'>Delivery Complete</font>";
        } else if ($status == "EA") {
            $mstring = "Exchange Request";
        } else if ($status == "EI") {
            $mstring = "교환승인";
        } else if ($status == "ED") {
            $mstring = "<font color=blue class='p11 ls1'>교환상품배송중</font>";
        } else if ($status == "EC") {
            $mstring = "교환반품확정";
        } else if ($status == "FA") {
            $mstring = "Refund Request";
        } else if ($status == "FC") {
            $mstring = "Refund Complete";
        } else if ($status == "RA") {
            $mstring = "Return Request";
        } else if ($status == "RI") {
            $mstring = "반품승인";
        } else if ($status == "RD") {
            $mstring = "<font color=blue class='p11 ls1'>Exchange Progressing</font>";
        } else if ($status == "RT") {
            $mstring = "반품회수완료";
        } else if ($status == "CA") {
            $mstring = "Cancel Request";
        } else if ($status == "CI") {
            $mstring = "취소처리중";
        } else if ($status == "CC") {
            $mstring = "Cancel Complet";
        } else if ($status == "SC") {
            $mstring = "판매거부";
        } else if ($status == "AR") {
            $mstring = "정산확정";
        } else if ($status == "AC") {
            $mstring = "송금대기";
        } else if ($status == "AP") {
            $mstring = "송금완료";
        } else if ($status == "WS") {
            $mstring = "입고대기";
        } else if ($status == "BF") {
            $mstring = "<font color=#993333 class='p11 ls1'>Buy Finalized</font>";
        } else if ($status == "CD") {
            $mstring = "취소거부";
        } else if ($status == "RN") {
            $mstring = "반품취소";
        } else if ($status == "RF") {
            $mstring = "반품보류";
        } else if ($status == "RY") {
            $mstring = "반품거부";
        } else if ($status == "RE") {
            $mstring = "반품완료보류";
        } else if ($status == "RR") {
            $mstring = "재결제대기중";
        } else if ($status == "EN") {
            $mstring = "교환신청취소";
        } else if ($status == "EF") {
            $mstring = "교환보류";
        } else if ($status == "EY") {
            $mstring = "교환거부";
        } else if ($status == "ET") {
            $mstring = "교환회수완료";
        } else if ($status == "EG") {
            $mstring = "교환재배송중";
        } else if ($status == "OR") {
            $mstring = "해외프로세싱중";
        } else if ($status == "OI") {
            $mstring = "해외창고배송중";
        } else if ($status == "TR") {
            $mstring = "항공배송준비중";
        } else if ($status == "TI") {
            $mstring = "항공배송중";
        } else if ($status == "IB") {
            $mstring = "입금전취소";
        } else if ($status == "WDA") {
            $mstring = "출고요청";
        } else if ($status == "WDO") {
            $mstring = "출고요청확정";
        } else if ($status == "WDP") {
            $mstring = "포장대기";
        } else if ($status == "WDR") {
            $mstring = "출고대기";
        } else if ($status == "WDC") {
            $mstring = "출고완료";
        } else if ($status == "DD") {
            $mstring = "배송지연";
        } else if ($status == "EM") {
            $mstring = "교환불가";
        } else if ($status == "RC") {
            $mstring = "<font color=#993333 class='p11 ls1'>반품확정</font>";
        } else if ($status == "RM") {
            $mstring = "반품불가";
        } else if ($status == "DP") {
            $mstring = "후불(외상)";
        } else if ($status == "ER") {
            $mstring = "교환배송예정";
        } else if ($status == "LO") {
            $mstring = "손실";
        }
    } else {
        if (!empty($_SESSION['layout_config']['front_language']) && strpos($_SERVER['REQUEST_URI'], 'admin') == false) {
            if ($status == "SR") {
                if ($method == ORDER_METHOD_CARD) {
                    $mstring = "<font color=#FF0000 class='p11 ls1'>".getLanguageText('cc8480403594dee93ed0b50120bbbee2')."</font>";
                } elseif ($method == ORDER_METHOD_BANK) {
                    $mstring = "<font color=#FF0000 class='p11 ls1'>".getLanguageText('df81628cc0bc28547eaffa4f3edc45bb')."</font>";
                } elseif ($method == ORDER_METHOD_PHONE) {
                    $mstring = "<font color=#FF0000 class='p11 ls1'>".getLanguageText('84ee0a7c7d46e703d6dd8d58dfe739f3')."</font>";
                } elseif ($method == ORDER_METHOD_VBANK) {
                    $mstring = "<font color=#FF0000 class='p11 ls1'>".getLanguageText('385bf51e814bb3c830dd7cbd1164ef5f')."</font>";
                } elseif ($method == ORDER_METHOD_ICHE) {
                    $mstring = "<font color=#FF0000 class='p11 ls1'>".getLanguageText('598e097d4ec759f01b23c49220985d8a')."<br>".getLanguageText('08f3f7e96b3dac77b5b165d3636973a7')."</font>";
                } elseif ($method == ORDER_METHOD_ASCROW) {
                    $mstring = "<font color=#FF0000 class='p11 ls1'>에스크로결제중</font>";
                }
            } else if ($status == "IR") {
                $mstring = "<font>".getLanguageText('b51e5a2d654dcf295a7e53a3afc01ed6')."</font>";
            } else if ($status == "IC") {
                $mstring = "<font>".getLanguageText('865e38b36c8e51360d8a61f866250ecc')."</font>";
            } else if ($status == "DR") {
                $mstring = "<font>".getLanguageText('10adc13c89eb1c707853e2830beb3425')."</font>"; //색깔 변경 kbk 13/06/12
            } else if ($status == "DI") {
                $mstring = "<font>".getLanguageText('8003afa092e790c4c77df8dbcea1ee8b')."</font>";
            } else if ($status == "DC") {
                $mstring = "<font color='green' class='p11 ls1'>".getLanguageText('2d6202bd2fd277ec245e6352c25fd0c6')."</font>";
            } else if ($status == "EA") {
                $mstring = "<font color=blue class='p11 ls1'>".getLanguageText('0cff6f7ff4e6bf3287917ff871139ccd')."</font>";
            } else if ($status == "EI") {
                $mstring = "<font color=blue class='p11 ls1'>".getLanguageText('2c8b49b1379b977181abc675b785bab0')."</font>";
            } else if ($status == "ED") {
                $mstring = "<font color=blue class='p11 ls1'>".getLanguageText('e2154d70c7a0c3831b93275cf37a06f8')."</font>";
            } else if ($status == "EC") {
                $mstring = "<font color=blue class='p11 ls1'>".getLanguageText('c3a08f4a5b0348fb963fcc7c1f94e73d')."</font>";
            } else if ($status == "FA") {
                $mstring = "<font color='red' class='p11 ls1'>".getLanguageText('f5f6b5e65b60a62401dae139ebe942c9')."</font>";
            } else if ($status == "FC") {
                $mstring = "<font color='red' class='p11 ls1'>".getLanguageText('5dc567c06368db042bc26b4401c4246c')."</font>";
            } else if ($status == "RA") {
                $mstring = "<font color='#993333' class='p11 ls1'>".getLanguageText('d7149ae3136b3c17b59219ef0623ad86')."</font>";
            } else if ($status == "RI") {
                $mstring = "<font color='#993333' class='p11 ls1'>".getLanguageText('e261e193fbd05dfb2829cc191352e925')."</font>";
            } else if ($status == "RD") {
                $mstring = "<font color='#993333' class='p11 ls1'>".getLanguageText('8768fe6c457295ac3c16fefd78b43bb1')."</font>";
            } else if ($status == "RT") {
                $mstring = "<font color='#993333' class='p11 ls1'>".getLanguageText('6f91c3cace067af6fffe24089685669a')."</font>";
            } else if ($status == "CA") {
                $mstring = "<font color='red' class='p11 ls1'>".getLanguageText('b285b4d59d0162d82e0493637ead5091')."</font>";
            } else if ($status == "CI") {
                $mstring = getLanguageText('064481a469292de810c7afefc5567f22');
            } else if ($status == "CC") {
                $mstring = "<font color='red' class='p11 ls1'>".getLanguageText('3513667d7c8b7ecc077f5475fc7264ff')."</font>";
            } else if ($status == "SO") {
                $mstring = getLanguageText('4e77bd0a313d07e475f2ab4a2cd676a7');
            } else if ($status == "SC") {
                $mstring = getLanguageText('35140735dc1d3583759c69b3840fc027');
            } else if ($status == "AR") {
                $mstring = getLanguageText('47b7c53159867ebf8ccb0020de4afe2d');
            } else if ($status == "AC") {
                $mstring = getLanguageText('5789c37463dc6e4aa639b98011abd113');
            } else if ($status == "AP") {
                $mstring = getLanguageText('12a28a22baa44aea4da1dd4f58a98cf3');
            } else if ($status == "WS") {
                $mstring = getLanguageText('5b8278fc244d96b584f7d0d36c4e5de6');
            } else if ($status == "BF") {
                $mstring = "<font color='green' class='p11 ls1'>".getLanguageText('450a240ed34c98468154b670ada06f53')."</font>";
            } else if ($status == "CD") {
                $mstring = getLanguageText('631d4fff9da260076c007a9caf314baa');
            } else if ($status == "RN") {
                $mstring = getLanguageText('33b1039d8e49cd3b4930d5d27c9f7c7f');
            } else if ($status == "RF") {
                $mstring = "<font color='#993333' class='p11 ls1'>".getLanguageText('a64d073c7fbb7d5345618c7aedfe4207')."</font>";
            } else if ($status == "RY") {
                $mstring = "<font color='#993333' class='p11 ls1'>".getLanguageText('b3c0d090fe54d145e7b09c176d7e2fcd')."</font>";
            } else if ($status == "RE") {
                $mstring = getLanguageText('a2f7edcc66da7e963e65d3fb662ef5d2');
            } else if ($status == "RR") {
                $mstring = getLanguageText('5ccf85fe2651ce89d4102eddf50f4480');
            } else if ($status == "EN") {
                $mstring = getLanguageText('00d9f3b033863666962aa49b343fee66');
            } else if ($status == "EL") {
                $mstring = getLanguageText('2c8b49b1379b977181abc675b785bab0');
            } else if ($status == "EF") {
                $mstring = "<font color=blue class='p11 ls1'>".getLanguageText('761d8b6be6058f7f1e65db53ced8534c')."</font>";
            } else if ($status == "EY") {
                $mstring = "<font color=blue class='p11 ls1'>".getLanguageText('c74e5675d447a0176ee262bd00986a8e')."</font>";
            } else if ($status == "ET") {
                $mstring = "<font color=blue class='p11 ls1'>".getLanguageText('3bb0b493b3cd3ff8b470dc088f8d6419')."</font>";
            } else if ($status == "EG") {
                $mstring = getLanguageText('9050e6081d6357212d5bdec1adac75e9');
            } else if ($status == "OR") {
                $mstring = getLanguageText('7e8e2e1ac541554aa8356140d078f05e');
            } else if ($status == "OI") {
                $mstring = getLanguageText('da23202c413c6ff5d2cba2a908d0787e');
            } else if ($status == "TR") {
                $mstring = getLanguageText('536d99eee89059271dba47c3dfeee41c');
            } else if ($status == "TI") {
                $mstring = getLanguageText('ecd1cdac3e50018e7be9c3722b728212');
            } else if ($status == "IB") {
                $mstring = getLanguageText('1833162a59c6c39b8a3f777ba591ba78');
            } else if ($status == "WDA") {
                $mstring = getLanguageText('7cb5b78bfbbfeb5ef7e8bf4aa64f5d50');
            } else if ($status == "WDO") {
                $mstring = getLanguageText('901d93dbfcd48066456e578757fa5d47');
            } else if ($status == "WDP") {
                $mstring = getLanguageText('58b513186cae2960909b3af10e2f9a10');
            } else if ($status == "WDR") {
                $mstring = getLanguageText('7589c6737ad50a4794fd6db6cdd5073d');
            } else if ($status == "WDC") {
                $mstring = getLanguageText('4be7f7232c7386fc586f0a9c5203b74d');
            } else if ($status == "DD") {
                $mstring = getLanguageText('e2578860749195e178cb6dfd706f1bf8');
            } else if ($status == "EM") {
                $mstring = "<font color=blue class='p11 ls1'>".getLanguageText('685d76815d9937cab3bec1b408be0ea5')."</font>";
            } else if ($status == "RC") {
                $mstring = "<font color=#993333 class='p11 ls1'>".getLanguageText('22b862e03d849c4a50d99a3a67749838')."</font>";
            } else if ($status == "RM") {
                $mstring = "<font color='#993333' class='p11 ls1'>".getLanguageText('49b58ce104a513052764f38b14c3838c')."</font>";
            } else if ($status == "DP") {
                $mstring = "후불(외상)";
            } else if ($status == "ER") {
                $mstring = getLanguageText('60b6ee4989bd7b57dc1720a4a3a18046');
            } else if ($status == "LO") {
                $mstring = "손실";
            }
        } else {
            if ($status == "SR") {
                if ($method == ORDER_METHOD_CARD) {
                    $mstring = "<font color=#FF0000 class='p11 ls1'>카드결제중</font>";
                } elseif ($method == ORDER_METHOD_BANK) {
                    $mstring = "<font color=#FF0000 class='p11 ls1'>계좌입금전</font>";
                } elseif ($method == ORDER_METHOD_PHONE) {
                    $mstring = "<font color=#FF0000 class='p11 ls1'>전화결제중</font>";
                } elseif ($method == ORDER_METHOD_VBANK) {
                    $mstring = "<font color=#FF0000 class='p11 ls1'>가상계좌입금전</font>";
                } elseif ($method == ORDER_METHOD_ICHE) {
                    $mstring = "<font color=#FF0000 class='p11 ls1'>실시간<br>계좌이체중</font>";
                } elseif ($method == ORDER_METHOD_ASCROW) {
                    $mstring = "<font color=#FF0000 class='p11 ls1'>에스크로결제중</font>";
                }
            } else if ($status == "IR") {
                $mstring = "<font>입금예정</font>";
            } else if ($status == "IC") {
                $mstring = "<font>입금확인</font>";
            } else if ($status == "DR") {
                $mstring = "<font>배송준비중</font>"; //색깔 변경 kbk 13/06/12
            } else if ($status == "DI") {
                $mstring = "<font>배송중</font>";
            } else if ($status == "DC") {
                $mstring = "<font color='green' class='p11 ls1'>배송완료</font>";
            } else if ($status == "EA") {
                $mstring = "<font color=blue class='p11 ls1'>교환요청</font>";
            } else if ($status == "EI") {
                $mstring = "<font color=blue class='p11 ls1'>교환승인</font>";
            } else if ($status == "ED") {
                $mstring = "<font color=blue class='p11 ls1'>교환상품배송중</font>";
            } else if ($status == "EC") {
                $mstring = "<font color=blue class='p11 ls1'>교환반품확정</font>";
            } else if ($status == "FA") {
                $mstring = "<font color='red' class='p11 ls1'>환불신청</font>";
            } else if ($status == "FC") {
                $mstring = "<font color='red' class='p11 ls1'>환불완료</font>";
            } else if ($status == "RA") {
                $mstring = "<font color='#993333' class='p11 ls1'>반품요청</font>";
            } else if ($status == "RI") {
                $mstring = "<font color='#993333' class='p11 ls1'>반품승인</font>";
            } else if ($status == "RD") {
                $mstring = "<font color='#993333' class='p11 ls1'>반품상품배송중</font>";
            } else if ($status == "RT") {
                $mstring = "<font color='#993333' class='p11 ls1'>반품회수완료</font>";
            } else if ($status == "CA") {
                $mstring = "<font color='red' class='p11 ls1'>취소요청</font>";
            } else if ($status == "CI") {
                $mstring = "취소처리중";
            } else if ($status == "CC") {
                $mstring = "<font color='red' class='p11 ls1'>취소완료</font>";
            } else if ($status == "SO") {
                $mstring = "품절취소";
            } else if ($status == "SC") {
                $mstring = "판매거부";
            } else if ($status == "AR") {
                $mstring = "정산확정";
            } else if ($status == "AC") {
                $mstring = "송금대기";
            } else if ($status == "AP") {
                $mstring = "송금완료";
            } else if ($status == "WS") {
                $mstring = "입고대기";
            } else if ($status == "BF") {
                $mstring = "<font color='green' class='p11 ls1'>거래확정</font>";
            } else if ($status == "CD") {
                $mstring = "취소거부";
            } else if ($status == "RN") {
                $mstring = "반품취소";
            } else if ($status == "RF") {
                $mstring = "<font color='#993333' class='p11 ls1'>반품보류</font>";
            } else if ($status == "RY") {
                $mstring = "<font color='#993333' class='p11 ls1'>반품거부</font>";
            } else if ($status == "RE") {
                $mstring = "반품완료보류";
            } else if ($status == "RR") {
                $mstring = "재결제대기중";
            } else if ($status == "EN") {
                $mstring = "교환신청취소";
            } else if ($status == "EL") {
                $mstring = "교환승인";
            } else if ($status == "EF") {
                $mstring = "<font color=blue class='p11 ls1'>교환보류</font>";
            } else if ($status == "EY") {
                $mstring = "<font color=blue class='p11 ls1'>교환거부</font>";
            } else if ($status == "ET") {
                $mstring = "<font color=blue class='p11 ls1'>교환회수완료</font>";
            } else if ($status == "EG") {
                $mstring = "교환재배송중";
            } else if ($status == "OR") {
                $mstring = "해외프로세싱중";
            } else if ($status == "OI") {
                $mstring = "해외창고배송중";
            } else if ($status == "TR") {
                $mstring = "항공배송준비중";
            } else if ($status == "TI") {
                $mstring = "항공배송중";
            } else if ($status == "IB") {
                $mstring = "입금전취소";
            } else if ($status == "WDA") {
                $mstring = "출고요청";
            } else if ($status == "WDO") {
                $mstring = "출고요청확정";
            } else if ($status == "WDP") {
                $mstring = "포장대기";
            } else if ($status == "WDR") {
                $mstring = "출고대기";
            } else if ($status == "WDC") {
                $mstring = "출고완료";
            } else if ($status == "DD") {
                $mstring = "배송지연";
            } else if ($status == "EM") {
                $mstring = "<font color=blue class='p11 ls1'>교환불가</font>";
            } else if ($status == "RC") {
                $mstring = "<font color=#993333 class='p11 ls1'>반품확정</font>";
            } else if ($status == "RM") {
                $mstring = "<font color='#993333' class='p11 ls1'>반품불가</font>";
            } else if ($status == "DP") {
                $mstring = "후불(외상)";
            } else if ($status == "ER") {
                $mstring = "교환배송예정";
            } else if ($status == "LO") {
                $mstring = "손실";
            }
        }
    }
    //return $mstring ."($status)";
    return $mstring;
}

// 상품의 결제방법을 반환하는 함수
function getMethodStatus($sattle_method, $return_type = "text")
{
    global $admininfo;

    $return       = "";
    $method_str   = "";
    $method_array = explode('|', $sattle_method);

    foreach ($method_array as $key => $val) {

        if ($key != 0) $return .= " + ";

        if ($admininfo["language"] == "english") {
            if ($val == ORDER_METHOD_CARD) {
                $method_str = "Credit Card";
            } elseif ($val == ORDER_METHOD_BANK) {
                $method_str = "Cash";
            } elseif ($val == ORDER_METHOD_PHONE) {
                $method_str = "소액결제";
            } elseif ($val == ORDER_METHOD_AFTER) {
                $method_str = "후불결제";
            } elseif ($val == ORDER_METHOD_VBANK) {
                $method_str = "Virtual Account";
            } elseif ($val == ORDER_METHOD_ICHE) {
                $method_str = "Real-time Transfer";
            } elseif ($val == ORDER_METHOD_ASCROW) {
                $method_str = "ESCROW";
            } elseif ($val == ORDER_METHOD_CASH) {
                $method_str = "현금";
            } elseif ($val == ORDER_METHOD_BOX_ENCLOSE) {
                $method_str = "박스동봉";
            } elseif ($val == ORDER_METHOD_SAVEPRICE) {
                $method_str = "예치금";
            } elseif ($val == ORDER_METHOD_RESERVE) {
                $method_str = "적립금";
            } elseif ($val == ORDER_METHOD_CART_COUPON) {
                $method_str = "장바구니쿠폰";
            } elseif ($val == ORDER_METHOD_DELIVERY_COUPON) {
                $method_str = "배송비쿠폰";
            } elseif ($val == ORDER_METHOD_PAYCO) {
                $method_str = "PAYCO";
            } else {
                $method_str = "-";
            }
        } else {
            if ($val == ORDER_METHOD_CARD) {
                $method_str = "신용카드결제";
            } elseif ($val == ORDER_METHOD_BANK) {
                $method_str = "무통장입금";
            } elseif ($val == ORDER_METHOD_PHONE) {
                $method_str = "소액결제";
            } elseif ($val == ORDER_METHOD_AFTER) {
                $method_str = "후불결제";
            } elseif ($val == ORDER_METHOD_VBANK) {
                $method_str = "가상계좌";
            } elseif ($val == ORDER_METHOD_ICHE) {
                $method_str = "실시간 계좌이체";
            } elseif ($val == ORDER_METHOD_ASCROW) {
                $method_str = "가상계좌[에스크로]";
            } elseif ($val == ORDER_METHOD_CASH) {
                $method_str = "현금";
            } elseif ($val == ORDER_METHOD_BOX_ENCLOSE) {
                $method_str = "박스동봉";
            } elseif ($val == ORDER_METHOD_SAVEPRICE) {
                $method_str = "예치금";
            } elseif ($val == ORDER_METHOD_RESERVE) {
                $method_str = "적립금";
            } elseif ($val == ORDER_METHOD_CART_COUPON) {
                $method_str = "장바구니쿠폰";
            } elseif ($val == ORDER_METHOD_DELIVERY_COUPON) {
                $method_str = "배송비쿠폰";
            } elseif ($val == ORDER_METHOD_PAYCO) {
                $method_str = "PAYCO";
            } else {
                $method_str = "-";
            }
        }

        if ($return_type == "img") {
            if ($val == ORDER_METHOD_CARD) {
                $return .= "<img src='../images/".$admininfo['language']."/s_order_method_".ORDER_METHOD_CARD.".gif' align='absmiddle'>";
            } elseif ($val == ORDER_METHOD_BANK) {
                $return .= "<img src='../images/".$admininfo['language']."/s_order_method_".ORDER_METHOD_BANK.".gif' align='absmiddle'>";
            } elseif ($val == ORDER_METHOD_PHONE) {
                $return .= "<img src='../images/".$admininfo['language']."/s_order_method_".ORDER_METHOD_PHONE.".gif' align='absmiddle'>";
            } elseif ($val == ORDER_METHOD_AFTER) {
                $return .= "<img src='../images/".$admininfo['language']."/s_order_method_".ORDER_METHOD_AFTER.".gif' align='absmiddle'>";
            } elseif ($val == ORDER_METHOD_VBANK) {
                $return .= "<img src='../images/".$admininfo['language']."/s_order_method_".ORDER_METHOD_VBANK.".gif' align='absmiddle'>";
            } elseif ($val == ORDER_METHOD_ICHE) {
                $return .= "<img src='../images/".$admininfo['language']."/s_order_method_".ORDER_METHOD_ICHE.".gif' align='absmiddle'>";
            } elseif ($val == ORDER_METHOD_MOBILE) {
                $return .= "<img src='../images/".$admininfo['language']."/s_order_method_".ORDER_METHOD_MOBILE.".gif' align='absmiddle'>";
            } elseif ($val == ORDER_METHOD_ASCROW) {
                $return .= "가상계좌[에스크로]";
            } elseif ($val == ORDER_METHOD_NOPAY) {
                $return .= "무료결제";
            } elseif ($val == ORDER_METHOD_SAVEPRICE) {
                $return .= "<img src='../images/".$admininfo['language']."/s_order_method_".ORDER_METHOD_SAVEPRICE.".gif' align='absmiddle'>";
            } elseif ($val == ORDER_METHOD_CASH) {
                $return .= "<img src='../images/".$admininfo['language']."/s_order_method_".ORDER_METHOD_CASH.".gif' align='absmiddle'>";
            } elseif ($val == ORDER_METHOD_RESERVE) {
                $return .= "<img src='../images/".$admininfo['language']."/s_order_method_".ORDER_METHOD_RESERVE.".gif' align='absmiddle'>";
            } elseif ($val == ORDER_METHOD_CART_COUPON) {
                $return .= "<img src='../images/".$admininfo['language']."/s_order_method_".ORDER_METHOD_CART_COUPON.".gif' align='absmiddle'>";
            } elseif ($val == ORDER_METHOD_DELIVERY_COUPON) {
                $return .= "<img src='../images/".$admininfo['language']."/s_order_method_".ORDER_METHOD_DELIVERY_COUPON.".gif' align='absmiddle'>";
            } elseif ($val == ORDER_METHOD_PAYCO) {
                $return .= "PAYCO";
            }
        } else {
            $return .= $method_str;
        }
    }


    return $return;
}

// SNS 쿠폰의의 상태를 반환하는 함수
function getSnsCouponStatus($status)
{
    if ($status == SNS_COUPON_STATUS_READY) {
        $mstring = "사용대기";
    } else if ($status == SNS_COUPON_STATUS_EXPIRE) {
        $mstring = "기간만료";
    } else if ($status == SNS_COUPON_STATUS_COMPLETE) {
        $mstring = "사용완료";
    }
    return $mstring;
}

function Error($msg)
{
    echo "<script>alert('$msg');//history.back;</script>";
    exit;
}
/*
  function fecth_bbs($table="bbs_notice", $size=5)
  {
  global $slave_mdb;

  $slave_mdb->query("SELECT *, DATE_FORMAT(regdate,'%Y.%m.%d') AS day FROM $table ORDER BY regdate DESC limit 0,$size");

  return $slave_mdb->fetchall();
  exit;
  }
 */

function deliveryCompanyList($code_ix = "", $return_type = "list", $add_string = "", $company_id = "")
{
    global $slave_mdb;
    //$slave_mdb = new Database;

    if ($return_type == "list") {
        $slave_mdb->query("SELECT * FROM ".TBL_SHOP_CODE." where code_gubun = '02' ");

        $mstring = "<table width='170' cellpadding=0 cellspacing=0 border='0' align='left' $add_string>";

        if ($slave_mdb->total) {
            for ($i = 0; $i < $slave_mdb->total; $i++) {
                $slave_mdb->fetch($i);

                $mstring .= "<tr height=23 valign=middle>
								<td align=left><input type=hidden name='code_ix[]' value='".$slave_mdb->dt['code_ix']."'><a href=\"javascript:void(0)\" onclick=\"window.open('delivery_modify.php?code_ix=".$slave_mdb->dt['code_ix']."','win_category','width=450,height=400');\">".$slave_mdb->dt['code_name']."</a></td>
								<td align=right><input type=checkbox name='disp_".$slave_mdb->dt['code_ix']."' id='this_".$slave_mdb->dt['code_ix']."'  value=1 ".CompareReturnValue("1",
                        $slave_mdb->dt['disp'], "checked")."></td>
								<!--td><a href=\"JavaScript:DeleteCompany('".$slave_mdb->dt['code_ix']."')\"><img src='/admin/image/bt_del.gif' border=0></a></td-->
							</tr>
							<tr hegiht=1><td colspan=6 background='/admin/image/dot.gif'></td></tr>";
            }
        } else {
            $mstring .= "<tr hegiht=50><td colspan=6 align=center style='padding-top:10px;'>배송업체선택</td></tr>
							<tr hegiht=1><td colspan=6 background='/admin/image/dot.gif'></td></tr>";
        }



        $mstring .= "</table>";
    } else if ($return_type == "table") {
        $slave_mdb->query("SELECT * FROM ".TBL_SHOP_CODE." where code_gubun = '02' ");

        $mstring = "<table cellspacing=1 cellpadding=5 width=256 border=0 bgcolor='#c0c0c0' style='border-collapse:separate; border-spacing:1px;' align='left' $add_string >";

        if ($slave_mdb->total) {
            for ($i = 0; $i < $slave_mdb->total; $i++) {
                $slave_mdb->fetch($i);

                $mstring .= "<tr height=23 valign=middle bgcolor=#ffffff>
								<td align=left>".$slave_mdb->dt['code_name']."</td>
								<td align=center width=100> ".$slave_mdb->dt['code_ix']." </td>
							</tr>";
            }
        } else {
            $mstring .= "<tr hegiht=50><td colspan=6 align=center style='padding-top:10px;'>배송업체선택</td></tr>
							<tr hegiht=1><td colspan=6 background='/admin/image/dot.gif'></td></tr>";
        }



        $mstring .= "</table>";
    } else if ($return_type == "seller_list") {
        $arr_code_ix = explode(",", $code_ix);
        $slave_mdb->query("SELECT * FROM ".TBL_SHOP_CODE." where code_gubun = '02' ");

        $mstring = "<table width='170' cellpadding=0 cellspacing=0 border='0' align='left' $add_string>";

        if ($slave_mdb->total) {
            for ($i = 0; $i < $slave_mdb->total; $i++) {
                $slave_mdb->fetch($i);
                if (in_array($slave_mdb->dt['code_ix'], $arr_code_ix)) $check_txt = "checked";
                else $check_txt = "";
                $mstring   .= "<tr height=23 valign=middle>
								<td align=left><label for='code_ix_".$slave_mdb->dt['code_ix']."' ".($_SESSION["admininfo"]["charger_id"] == "forbiz" ? "onclick=\"window.open('delivery_modify.php?code_ix=".$slave_mdb->dt['code_ix']."','win_category','width=450,height=400');\""
                        : "")." />".$slave_mdb->dt['code_name']."</label></td>
								<td align=right><input type=checkbox name='code_ix[]' id='code_ix_".$slave_mdb->dt['code_ix']."' value='".$slave_mdb->dt['code_ix']."' ".$check_txt."></td>
							</tr>
							<tr hegiht=1><td colspan=6 background='/admin/image/dot.gif'></td></tr>";
            }
        }else {
            $mstring .= "<tr hegiht=50><td colspan=6 align=center style='padding-top:10px;'>배송업체선택</td></tr>
							<tr hegiht=1><td colspan=6 background='/admin/image/dot.gif'></td></tr>";
        }

        $mstring .= "</table>";
    } else if ($return_type == "overseas_seller_list") {
        $arr_code_ix = explode(",", $code_ix);
        $slave_mdb->query("SELECT * FROM ".TBL_SHOP_CODE." where code_gubun = '06' ");

        $mstring = "<table width='170' cellpadding=0 cellspacing=0 border='0' align='left' $add_string>";

        if ($slave_mdb->total) {
            for ($i = 0; $i < $slave_mdb->total; $i++) {
                $slave_mdb->fetch($i);
                if (in_array($slave_mdb->dt['code_ix'], $arr_code_ix)) $check_txt = "checked";
                else $check_txt = "";
                $mstring   .= "<tr height=23 valign=middle>
							<td align=left><label for='code_ix_".$slave_mdb->dt['code_ix']."' ".($_SESSION["admininfo"]["charger_id"] == "forbiz" ? "onclick=\"window.open('delivery_modify.php?code_ix=".$slave_mdb->dt['code_ix']."','win_category','width=450,height=400');\""
                        : "")." />".$slave_mdb->dt['code_name']."</label></td>
							<td align=right><input type=checkbox name='code_ix[]' id='code_ix_".$slave_mdb->dt['code_ix']."' value='".$slave_mdb->dt['code_ix']."' ".$check_txt." class='delivery_ix'></td>
						</tr>
						<tr hegiht=1><td colspan=6 background='/admin/image/dot.gif'></td></tr>";
            }
        }else {
            $mstring .= "<tr hegiht=50><td colspan=6 align=center style='padding-top:10px;'>배송업체선택</td></tr>
						<tr hegiht=1><td colspan=6 background='/admin/image/dot.gif'></td></tr>";
        }

        $mstring .= "</table>";
    } else if ($return_type == "SelectbySeller" || $return_type == "SelectbyAll") {
        if ($return_type == "SelectbySeller") {
            if ($code_ix == "") {
                $sql = "SELECT delivery_company FROM ".TBL_COMMON_SELLER_DELIVERY." where company_id = '$company_id'  ";

                $slave_mdb->query($sql);
                $slave_mdb->fetch();
                $code_ix = $slave_mdb->dt['delivery_company'];
                /**
                 * 빠른송장입력에서 셀러가 선택한 업체 이외에도 보이도록 수정 선택한 업체만 기본선택값으로 노출 12.08.08 bgh 이재일실장님 컨펌
                 *
                  if($code_ix != ""){
                  $sql = "SELECT * FROM ".TBL_SHOP_CODE." where code_gubun = '02' and code_ix = '$code_ix' ";
                  }else{
                  $sql = "SELECT * FROM ".TBL_SHOP_CODE." where code_gubun = '02' and disp = 1 ";
                  }
                 */
                $sql     = "SELECT * FROM ".TBL_SHOP_CODE." where code_gubun = '02' and disp = '1' ";
                //echo $sql."<br>";
            } else {
                $sql = "SELECT * FROM ".TBL_SHOP_CODE." where code_gubun = '02' and code_ix = '$code_ix' ";
            }
        } else if ($return_type == "SelectbyAll") { // 이건 왜 여기 껴있음? selected를 다 붙이겠다는 생각인가?
            $sql = "SELECT * FROM ".TBL_SHOP_CODE." where code_gubun = '02' ";
        }

        $slave_mdb->query($sql);
        //echo "aaa".$code_ix;
        $mstring = "<select name='delivery_company'  id='delivery_company'   $add_string>";
        $mstring .= "<option value=''>배송업체</option>";
        if ($slave_mdb->total) {
            for ($i = 0; $i < $slave_mdb->total; $i++) {
                $slave_mdb->fetch($i);

                $mstring .= "<option value='".$slave_mdb->dt['code_ix']."' ".CompareReturnValue($code_ix, $slave_mdb->dt['code_ix'], " selected").">".$slave_mdb->dt['code_name']."</option>";
            }
        } else {
            $mstring .= "<option value=''>배송업체선택</option>";
        }
        $mstring .= "</select>";
    } else if ($return_type == "select") {
        $slave_mdb->query("SELECT * FROM ".TBL_SHOP_CODE." where code_gubun = '02' and disp = '1'");

        $mstring = "<select name='quick'  $add_string>";
        $mstring .= "<option value=''>배송업체선택</option>";
        if ($slave_mdb->total) {
            for ($i = 0; $i < $slave_mdb->total; $i++) {
                $slave_mdb->fetch($i);

                $mstring .= "<option value='".$slave_mdb->dt['code_ix']."' ".($code_ix == $slave_mdb->dt['code_ix'] ? " selected" : "").">".$slave_mdb->dt['code_name']."</option>";
            }
        } else {
            $mstring .= "<option value=''>배송업체선택</option>";
        }
        $mstring .= "</select>";
    } else if ($return_type == "text") {
        $slave_mdb->query("SELECT code_name FROM ".TBL_SHOP_CODE." where code_gubun = '02' and code_ix ='$code_ix' ");

        if ($slave_mdb->total) {
            $slave_mdb->fetch();
            $mstring = $slave_mdb->dt['code_name'];
        } else {
            if ($code_ix == "") $mstring = "-";
            else $mstring = "해당되는 업체가 없습니다.";
        }
    }else if ($return_type == "excel_text") {
        if ($code_ix == "") {
            $mstring = "";
        } else {
            $slave_mdb->query("SELECT code_name FROM ".TBL_SHOP_CODE." where code_gubun = '02' and code_ix ='$code_ix' ");

            if ($slave_mdb->total) {
                $slave_mdb->fetch();
                $mstring = $slave_mdb->dt['code_name'];
            } else {
                $mstring = "";
            }
        }
    } else if ($return_type == "link") {
        $slave_mdb->query("SELECT code_etc1 FROM ".TBL_SHOP_CODE." where code_gubun = '02' and code_ix ='$code_ix' ");

        if ($slave_mdb->total) {
            $slave_mdb->fetch();
            $mstring = $slave_mdb->dt['code_etc1'];
        } else {
            $mstring = "#";
        }
    }
    return $mstring;
}

function deliveryCompanyList2($name, $add_string = "", $company_id = "", $code_ix = "")
{
    global $slave_mdb;
    //$slave_mdb = new Database;

    $sql          = "select company_id,delivery_company from common_seller_delivery where company_id = '".$company_id."'";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();
    $company_code = $slave_mdb->dt['delivery_company'];

    $code_array = explode(",", $company_code);
    $where      = implode("','", $code_array);
    $sql        = "select * FROM ".TBL_SHOP_CODE." where code_gubun ='02' and code_ix in ('".$where."')";

    $slave_mdb->query($sql);
    $tekbae_ix_array = $slave_mdb->fetchall();

    $mstring = "<select name='$name'  $add_string>";
    $mstring .= "<option value=''>배송업체선택</option>";

    if (count($tekbae_ix_array) > 0) {
        for ($i = 0; $i < count($tekbae_ix_array); $i++) {
            $mstring .= "<option value='".$tekbae_ix_array[$i]['code_ix']."' ".($tekbae_ix_array[$i]['code_ix'] == $code_ix ? 'selected' : '').">".$tekbae_ix_array[$i]['code_name']."</option>";
        }
    } else {
        $mstring .= "<option value=''>배송업체선택</option>";
    }
    $mstring .= "</select>";

    return $mstring;
}

function deliveryCompany($code_ix)
{
    global $slave_mdb;
    //$slave_mdb = new Database;

    $sql = "select * FROM ".TBL_SHOP_CODE." where code_gubun ='02' and code_ix = '".$code_ix."'";

    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    $code_name = $slave_mdb->dt['code_name'];

    return $code_name;
}

//read an especified file
function load_template($strfile, $ar_files = "")
{
    global $language_file, $func, $textout;

    if ($strfile == "" || !file_exists($strfile)) return;
    $thisfile = file($strfile);

    while (list($line, $value) = each($thisfile)) {
        $value  = ereg_replace("(\r|\n)", "", $value);
        $result .= "$value\r\n";
    }

    /*
      for($n=0;$n<count($ar_files);$n++) {

      $thisfile = $ar_files[$n].".txt";

      $lg = file("$language_file/$thisfile");
      while(list($line,$value) = each($lg)) {
      if(strpos(";#",$value[0]) === false && ($pos = strpos($value,"=")) != 0 && trim($value) != "") {
      $varname  = "<!--%".trim(substr($value,0,$pos))."%-->";
      $varvalue = trim(substr($value,$pos+1));
      $result = eregi_replace($varname,$varvalue,$result);
      }
      }

      }
      $func($textout);
     */
    return $result;
}

function get_tags($begin, $end, $template)
{
    $beglen               = strlen($begin);
    $endlen               = strlen($end);
    $beginpos             = strpos($template, $begin);
    $endpos               = strpos($template, $end);
    $result["ab-begin"]   = $beginpos;
    $result["ab-end"]     = $endpos + $endlen;
    $result["re-begin"]   = $beginpos + $beglen;
    $result["re-end"]     = $endpos;
    $result["ab-content"] = substr($template, $beginpos, ($endpos + $endlen) - $beginpos);
    $result["re-content"] = substr($template, $beginpos + $beglen, $endpos - $beginpos - $beglen);
    unset($beglen, $endlen, $beginpos, $endpos, $begin, $end, $template);
    return $result;
}

function price_trans($price)
{
    $trans_kor = array("", "일", "이", "삼", "사", "오", "육", "칠", "팔", "구");

    $price_unit = array("", "십", "백", "천", "만", "십만", "백만", "천만", "억", "십억", "백억", "천억", "조", "십조", "백조");

    $value = strlen($price);
    for ($i = 0; $i <= $value; $i++) {
        $str[$i] = substr($price, $i, 1);
    }
    $code = $value;

    for ($i = 0; $i <= $value; $i++) {
        $code = $code - 1;
        if ($trans_kor[$str[$i]] == "") {
            $price_unit[$code] = "";
        }
        if ($code > 4) {
            $two = $i + 1;
            if ($trans_kor[$str[$two]] != "") {
                $price_unit[$code] = mb_strimwidth($price_unit[$code], 0, 2, '', 'UTF-8');
            }
        }
        $mstr .= $trans_kor[$str[$i]].$price_unit[$code];
    }

    return $mstr;
}

function MakeOption($pid, $opn_ix = "", $select_option_id = "", $return_type = "select", $basic_text = "옵션을 선택해주세요")
{
    global $user;
    global $slave_mdb;
    //$slave_mdb = new Database;
    //$sql = "select id, option_div,option_price, option_m_price,option_d_price,option_a_price, option_stock, option_etc1  from ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." a where pid = '$pid' and opn_ix ='$opn_ix' order by id asc";
    $sql = "select id, option_div,option_price, option_stock, option_etc1  from ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." a where pid = '$pid' and opn_ix ='$opn_ix' order by id asc";
    $slave_mdb->query($sql);


    if ($slave_mdb->total == 0) {
        return "<input type=hidden name='option_standard' value=1>";
    } else {
        if ($return_type == "select") {
            $mString = "<Select name=option_standard onchange=\"ChangeOption('".$user['mem_level']."',this, this.selectedIndex);\">";
            $mString .= "<option value='0' stock='0' n_price='0' m_price='0' d_price='0' a_price='0' etc1='' >옵션을 선택해주세요</option>";

            $i = 0;
            for ($i = 0; $i < $slave_mdb->total; $i++) {
                $slave_mdb->fetch($i);

                if ($select_option_id == $slave_mdb->dt['id']) {
                    //$mString .= "<option value='".$slave_mdb->dt[id]."' stock='".$slave_mdb->dt[option_stock]."' n_price='".$slave_mdb->dt[option_price]."' m_price='".$slave_mdb->dt[option_m_price]."' d_price='".$slave_mdb->dt[option_d_price]."' a_price='".$slave_mdb->dt[option_a_price]."' etc1='".$slave_mdb->dt[option_etc1]."' selected>".$slave_mdb->dt[option_div]."</option>\n";
                    $mString .= "<option value='".$slave_mdb->dt['id']."' stock='".$slave_mdb->dt['option_stock']."' n_price='".$slave_mdb->dt['option_price']."' etc1='".$slave_mdb->dt['option_etc1']."' selected>".$slave_mdb->dt['option_div']."</option>\n";
                } else {
                    //$mString .= "<option value='".$slave_mdb->dt[id]."' stock='".$slave_mdb->dt[option_stock]."' n_price='".$slave_mdb->dt[option_price]."' m_price='".$slave_mdb->dt[option_m_price]."' d_price='".$slave_mdb->dt[option_d_price]."' a_price='".$slave_mdb->dt[option_a_price]."' etc1='".$slave_mdb->dt[option_etc1]."'>".$slave_mdb->dt[option_div]."</option>\n";
                    $mString .= "<option value='".$slave_mdb->dt['id']."' stock='".$slave_mdb->dt['option_stock']."' n_price='".$slave_mdb->dt['option_price']."' etc1='".$slave_mdb->dt['option_etc1']."'>".$slave_mdb->dt['option_div']."</option>\n";
                }
            }
            $mString .= "</select>";
        } else if ($return_type == "multiple") {
            $mString = "<Select name='option_standard_".$pid."'  style='height:70px;width:230px;' multiple>";
            $mString .= "<option value='0' stock='0' price='0'>옵션을 선택해주세요</option>";

            $i = 0;
            for ($i = 0; $i < $slave_mdb->total; $i++) {
                $slave_mdb->fetch($i);

                if ($select_option_id == $slave_mdb->dt['id']) {
                    //$mString .= "<option value='".$slave_mdb->dt[id]."' stock='".$slave_mdb->dt[option_stock]."' n_price='".$slave_mdb->dt[option_price]."' m_price='".$slave_mdb->dt[option_m_price]."' d_price='".$slave_mdb->dt[option_d_price]."' a_price='".$slave_mdb->dt[option_a_price]."' etc1='".$slave_mdb->dt[option_etc1]."' selected>".$slave_mdb->dt[option_div]."</option>\n";
                    $mString .= "<option value='".$slave_mdb->dt['id']."' stock='".$slave_mdb->dt['option_stock']."' n_price='".$slave_mdb->dt['option_price']."' etc1='".$slave_mdb->dt['option_etc1']."' selected>".$slave_mdb->dt['option_div']."</option>\n";
                } else {
                    //$mString .= "<option value='".$slave_mdb->dt[id]."' stock='".$slave_mdb->dt[option_stock]."' n_price='".$slave_mdb->dt[option_price]."' m_price='".$slave_mdb->dt[option_m_price]."' d_price='".$slave_mdb->dt[option_d_price]."' a_price='".$slave_mdb->dt[option_a_price]."' etc1='".$slave_mdb->dt[option_etc1]."'>".$slave_mdb->dt[option_div]."</option>\n";
                    $mString .= "<option value='".$slave_mdb->dt['id']."' stock='".$slave_mdb->dt['option_stock']."' n_price='".$slave_mdb->dt['option_price']."' etc1='".$slave_mdb->dt['option_etc1']."'>".$slave_mdb->dt['option_div']."</option>\n";
                }
            }
            $mString .= "</select>";
        } else {
            for ($i = 0; $i < $slave_mdb->total; $i++) {
                $slave_mdb->fetch($i);

                if ($select_option_id == $slave_mdb->dt['id']) {
                    return $slave_mdb->dt['option_div'];
                }
            }
        }
    }


    return $mString;
}

function getcominfo()
{
    $layout_config = gVal('layout_config');
    $slave_mdb     = gVal('slave_mdb');

    $sql = "select ccd.* , sd.shop_name
						from ".TBL_COMMON_COMPANY_DETAIL." ccd
						left join 	".TBL_COMMON_SELLER_DETAIL." sd on ccd.company_id = sd.company_id
						left join  ".TBL_COMMON_SELLER_DELIVERY." csd on ccd.company_id = csd.company_id
						where ccd.com_type = 'A' ";
    //echo $sql;
    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    $cominfo['com_name'] = $slave_mdb->dt['com_name'];
    if ($slave_mdb->dt['shop_name'] != "") {
        $cominfo['shop_name'] = $slave_mdb->dt['shop_name'];
    } else {
        $cominfo['shop_name'] = $slave_mdb->dt['com_name'];
    }
    $cominfo['com_addr']              = $slave_mdb->dt['com_addr1']." ".$slave_mdb->dt['com_addr2'];
    $cominfo['com_phone']             = $slave_mdb->dt['com_phone'];
    $cominfo['com_mobile']            = $slave_mdb->dt['com_mobile'];
    $cominfo['com_ceo']               = $slave_mdb->dt['com_ceo'];
    $cominfo['com_email']             = $slave_mdb->dt['com_email'];
    $cominfo['com_number']            = $slave_mdb->dt['com_number'];
    $cominfo['com_business_category'] = $slave_mdb->dt['com_business_category'];
    $cominfo['com_business_status']   = $slave_mdb->dt['com_business_status'];
    if ($_SESSION["layout_config"]['mall_domain_key']) {
        $cominfo['mall_domain_key'] = $_SESSION["layout_config"]['mall_domain_key'];
    } else {
        $slave_mdb->query("SELECT mall_domain_key FROM ".TBL_SHOP_SHOPINFO." where mall_div = 'B' limit 0,1");
        $slave_mdb->fetch();
        $cominfo['mall_domain_key'] = $slave_mdb->dt['mall_domain_key'];
    }

    /*     * ******* 도메인이 여러개인 경우 mall_domain_key 를 전부 불러오기 [S]******** *///kbk 13/03/13
    $slave_mdb->query("SELECT mall_domain_key FROM ".TBL_SHOP_SHOPINFO." ");
    $domain_key_fetch = $slave_mdb->fetchall();
    $arr_domain_key   = "";
    for ($i = 0; $i < count($domain_key_fetch); $i++) {
        if ($i == 0) $arr_domain_key = $domain_key_fetch[$i]["mall_domain_key"];
        else $arr_domain_key .= ",".$domain_key_fetch[$i]["mall_domain_key"];
    }
    $cominfo['arr_mall_domain_key'] = $arr_domain_key;
    /*     * ******* 도메인이 여러개인 경우 mall_domain_key 를 전부 불러오기 [E]******** */

    return $cominfo;
}

function getcominfo2()
{
    global $layout_config, $admininfo;
    global $slave_mdb;
    //$slave_mdb = new Database;
    $slave_mdb->query("SELECT * FROM ".TBL_COMMON_COMPANY_DETAIL." ccd, ".TBL_COMMON_SELLER_DETAIL." csd where ccd.company_id = csd.company_id and ccd.com_type = 'A' limit 0,1");
    $slave_mdb->fetch();

    $cominfo['com_name']      = $slave_mdb->dt['com_name'];
    $cominfo['shop_name']     = $slave_mdb->dt['com_name'];
    $cominfo['com_addr']      = $slave_mdb->dt['com_addr1']." ".$slave_mdb->dt['com_addr2'];
    $cominfo['com_phone']     = $slave_mdb->dt['com_phone'];
    $cominfo['com_mobile']    = $slave_mdb->dt['com_mobile'];
    $cominfo['com_ceo']       = $slave_mdb->dt['com_ceo'];
    $cominfo['charger_email'] = $slave_mdb->dt['com_email'];
    if ($_SESSION["layout_config"]['mall_domain_key']) {
        $cominfo['mall_domain_key'] = $_SESSION["layout_config"]['mall_domain_key'];
    } else {
        $slave_mdb->query("SELECT mall_domain_key FROM ".TBL_SHOP_SHOPINFO." where mall_div = 'B' limit 0,1");
        $slave_mdb->fetch();
        $cominfo['mall_domain_key'] = $slave_mdb->dt['mall_domain_key'];
    }

    /*     * ******* 도메인이 여러개인 경우 mall_domain_key 를 전부 불러오기 [S]******** *///kbk 13/03/13
    $slave_mdb->query("SELECT mall_domain_key FROM ".TBL_SHOP_SHOPINFO." ");
    $domain_key_fetch = $slave_mdb->fetchall();
    $arr_domain_key   = "";
    for ($i = 0; $i < count($domain_key_fetch); $i++) {
        if ($i == 0) $arr_domain_key = $domain_key_fetch[$i]["mall_domain_key"];
        else $arr_domain_key .= ",".$domain_key_fetch[$i]["mall_domain_key"];
    }
    $cominfo['arr_mall_domain_key'] = $arr_domain_key;
    /*     * ******* 도메인이 여러개인 경우 mall_domain_key 를 전부 불러오기 [E]******** */

    return $cominfo;
}

function ReturnStringAfterCompare($str1, $str2, $rstr = " checked")
{
    if ($str1 == $str2) {
        return $rstr;
    } else {
        return "";
    }
}

function auth($type = '1', $Page_URL = '/member/login.php')
{
    //session_start();

    global $user, $SELF_URL, $URL, $REQUEST_URI, $HTTP_REFERER, $PHP_SELF;

    if ($user['perm'] < $type) {
        $URL      = $REQUEST_URI;
        $SELF_URL = $PHP_SELF;

        session_register("URL");
        session_register("SELF_URL");


        //	header("Location:/login.php");


        echo("<script>");
        //	echo("oWindow = window.open('/member/login.php','', 'menubar=no,status=no,toolbar=no,resizable=no,width=360,height=220,titlebar=no,scrollbars=no,alwaysRaised=yes');");
        //	echo("location.href = '$HTTP_REFERER';");
        //	echo("location.href = '/';");
        echo("location.href = '$Page_URL';");
        echo("</script>");

        exit;
    }
}

function auth2($type = '1')
{
    session_start();

    global $user, $URL, $REQUEST_URI, $HTTP_REFERER;


    $URL = $REQUEST_URI;

    session_register("URL");

    //	echo("$URL");
}

function PrintMainPoll()
{
    global $slave_mdb;
    //$slave_mdb = new Database;
    $slave_mdb->query("SELECT * FROM ".TBL_SHOP_POLL_TITLE." where disp = '1' limit 0,1");
    $slave_mdb->fetch();
    $fieldsize = $slave_mdb->dt['fieldsize'];

    $mstring .= "<form name='field$pollnumber' action='/admin/marketting/poll.act.php' target='act'><input type='hidden' name='popurl' value='/company/research_popresult.php'><input type=hidden name=pollnumber value=".$slave_mdb->dt['id']."><input type=hidden name=act value=static>";
    $mstring .= "<table cellpadding=0 cellspaicng=0 border=0 width=200>";
    $mstring .= "<tr><td colspan=5><img src='/shop_templete/basic/images/poll_ex1.gif' border=0></td></tr>";
    $mstring .= "<tr><td colspan=5>".colorCirCleBox("#efefef", "100%", "<div align=center style='padding:3px;'>".$slave_mdb->dt['title']."</div>")."</td></tr>";
    $slave_mdb->query("SELECT * FROM ".TBL_SHOP_POLL_FIELD." where number = '".$slave_mdb->dt['id']."' order by fieldnumber");

    for ($i; $i < $slave_mdb->total; $i++) {
        $slave_mdb->fetch($i);
        $mstring .= "<tr><td><input type=radio name='field[]' size=40 value='".$slave_mdb->dt['fieldnumber']."' ></td><td>".$slave_mdb->dt['fielddesc']."</td></tr>";
    }
    /*
      $slave_mdb->fetch(1);
      $mstring .= "<td><input type=radio name='field[]' size=40 value='".$slave_mdb->dt[fieldnumber]."'></td><td>".$slave_mdb->dt[fielddesc]."</td></tr>";
      $slave_mdb->fetch(2);
      $mstring .= "<tr><td><input type=radio name='field[]' size=40 value='".$slave_mdb->dt[fieldnumber]."'></td><td>".$slave_mdb->dt[fielddesc]."</td>";
      $slave_mdb->fetch(3);
      $mstring .= "<td><input type=radio name='field[]' size=40 value='".$slave_mdb->dt[fieldnumber]."'></td><td>".$slave_mdb->dt[fielddesc]."</td>";
      $mstring .= "</tr>";
     */
    $mstring .= "<tr><td colspan=2 align=right style='padding-top:10px;'><input type=image src='/shop_templete/basic/images/btn_poll1.gif' > &nbsp;<img src='/shop_templete/basic/images/btn_poll2.gif' border=0></td></tr>";
    $mstring .= "</table></form></div>";

    return $mstring;
}

function myPoint()
{
    /*
      global $user;
      $slave_mdb = new Database;
      $slave_mdb->query("select sum(point) as point from pointinfo where uid = '".$user[code]."'");

      $slave_mdb->fetch();

      return $slave_mdb->dt[point];
     */
    return 0;
}
/*
  function PrintPoll(){

  $dbm = new Database;
  $dbm->query("SELECT * FROM ".TBL_SHOP_POLL_TITLE." where disp = '1' Limit 1");
  $dbm->fetch();
  $fieldsize = $dbm->dt[fieldsize];


  $mstring .="<form name='field$pollnumber' action='/admin/poll.act.php' target='act'><input type='hidden' name='popurl' value='/company/research_popresult.php'><input type=hidden name=pollnumber value=".$dbm->dt[id]."><input type=hidden name=act value=static>";
  $mstring .= "<table cellapdding=0 cellspaicng=0>";
  $mstring .= "<tr><td colspan=3>".$dbm->dt[title]."</td></tr>";
  $dbm->query("SELECT * FROM ".TBL_SHOP_POLL_FIELD." where number = '".$dbm->dt[id]."' order by fieldnumber");
  for($i=0;$i<$fieldsize;$i++){
  $dbm->fetch($i);
  if($i==0){
  $mstring .= "<tr><td><input type=radio name='field[]' size=40 value='".($i+1)."'></td><td>".$dbm->dt[fielddesc]."</td><td  valign=top style='padding-left:10px;' rowspan=10><input type='image' src='/main_img/search_go.gif'></td></tr>";
  }else{
  $mstring .= "<tr><td><input type=radio name='field[]' size=40 value='".($i+1)."'></td><td>".$dbm->dt[fielddesc]."</td></tr>";
  }
  }
  $mstring .= "</table></form></div>";

  return $mstring;

  }
 */

function PrintPoll($id)
{
    global $slave_mdb;
    //$pdb = new Database;
    //$slave_mdb = new Database;
    $slave_mdb->query("SELECT pt.id as id, title ,fieldsize,  sum(result) as total FROM ".TBL_SHOP_POLL_TITLE." pt, ".TBL_SHOP_POLL_FIELD." pf where pt.id = pf.number and disp = '1' and pt.g_id = $id group by id limit 0,3");
    $Polls   = $slave_mdb->fetchall();
    $mstring .= "<form name='field_frm' action='/admin/marketting/poll.act.php' onsubmit='return CheckFormValue(this)' target='act'>
					<input type='hidden' name='popurl' value='/company/research_popresult.php'>

					<input type=hidden name=group_id value=$id>
					<input type=hidden name=act value=static>";
    $mstring .= "<table cellapdding=0 width=100% cellspaicng=0 border=0>

					<col width=50>
					<col width=*>
					<col width=100>
					<col width=100>
		";

    for ($j = 0; $j < count($Polls); $j++) {
        //$pdb->fetch($j);
        $fieldsize = $Polls[$j]['fieldsize'];




        $mstring        .= "<tr><td colspan=3 nowrap> 질문 : ".$Polls[$j]['title']." <span style='width:40px;'></span>
		<input type=hidden name=pollnumber[] value=".$Polls[$j]['id']."><!-- <input type='image' src='/img/btn_ok2.gif' align=absmiddle> --> </td><td  valign=top style='padding-left:10px;' ></td></tr>";
        $slave_mdb->query("SELECT * FROM ".TBL_SHOP_POLL_FIELD." where number = '".$Polls[$j]['id']."' order by fieldnumber");
        $poll_questions = $slave_mdb->fetchall();

        for ($i = 0; $i < $fieldsize; $i++) {
            //$slave_mdb->fetch($i);

            if ($Polls[$j]['total'] == 0) {
                $poll_rate = 0;
            } else {
                $poll_rate = number_format($poll_questions['i']['result'] / $Polls[$j]['total'] * 100, 2);
            }

            if ($i == 0) {
                $mstring .= "<tr>
				<td>1 . <input type=radio name='field[".$poll_questions['i']['number']."]' validation=true title='설문항목' value='".$poll_questions['i']['fieldnumber']."'></td>
				<td>".$poll_questions['i']['fielddesc']."</td>
				<td align=right style='padding-right:10px;'>".($poll_rate)."% </td>
				<td width=200>
					<table height=15 width=100% border=0><tr>
					<td bgcolor=red width='".($poll_rate)."%'></td>
					<td width='".(100 - $poll_rate)."%'></td>
					</tr></table>
				</td>

				</tr>\n";
            } else {
                $mstring .= "<tr>
						<td>".($i + 1)." . <input type=radio name='field[".$poll_questions['i']['number']."]' validation=true title='설문항목' value='".$poll_questions['i']['fieldnumber']."'></td>
						<td>".$poll_questions['i']['fielddesc']."</td>
						<td align=right style='padding-right:10px;'>".($poll_rate)."% </td>
						<td width=200>
							<table height=15 width=100% border=0><tr>
							<td bgcolor=red width='".($poll_rate)."%'></td>
							<td width='".(100 - $poll_rate)."%'></td>
							</tr></table>
						</td>

						</tr>\n";
            }
        }
    }
    $mstring .= "<tr><td colspan='4' align='center' height='30'><input type='image' src='/img/btn_ok2.gif' align=absmiddle></td></tr>";
    $mstring .= "</table>";
    $mstring .= "</form>";
    return $mstring;
}

function MainOFPopUp($charger_ix)
{
    global $slave_mdb;
    global $master_db;

    $nowDate = date("Y-m-d H:i:s");

    $sql = "select * from seller_official_popup where popup_status = '2' and popup_use_sdate <= '".$nowDate."' and popup_use_edate >= '".$nowDate."' ";

    $slave_mdb->query($sql);
    $popup_total = $slave_mdb->total;
    $popup_data  = $slave_mdb->fetchall("object");

    if ($popup_total == 0) {
        return "";
    } else {
        $mstring .= "<script Language='JavaScript'>\n";

        for ($i = 0; $i < $popup_total; $i++) {

            $popup_data[$i];

            $sql2 = 'select * from seller_official_popup_result where charger_ix="'.$charger_ix.'" and popup_ix = "'.$popup_data[$i]['popup_ix'].'" and popup_confirm in ("1", "0")';
            $slave_mdb->query($sql2);

            //echo "<script>alert('".$slave_mdb->total."');</script>";

            if ($slave_mdb->total == 0) {

                if ($popup_data[$i]['popup_type'] == "W") {

                    $mstring .= "if(!readCookie('Notice".$popup_data[$i]['popup_ix']."')){\n";

                    $mstring .= "	MainPopUpWindow('./seller_official_document.pop.php?no=".$popup_data[$i]['popup_ix']."&popup_type=W',".$popup_data[$i]['popup_width'].",".$popup_data[$i]['popup_height'].",".$popup_data[$i]['popup_top'].",".$popup_data[$i]['popup_left'].",'pop".$popup_data[$i]['popup_ix']."' );\n";

                    $mstring .= "}\n";
                } else {

                    $mstring .= "if(!readCookie('Notice".$popup_data[$i]['popup_ix']."')){\n";
                    $mstring .= "document.write(\"<div id='divpop".$popup_data[$i]['popup_ix']."' style='position:absolute;left:".$popup_data[$i]['popup_left']."px;top:".$popup_data[$i]['popup_top']."px;z-index:200;visibility:visible;'>\");\n";
                    $mstring .= "document.write(\"<IFRAME id=popup".$popup_data[$i]['popup_ix']." name=popup".$popup_data[$i]['popup_ix']." src='./seller_official_document.pop.php?no=".$popup_data[$i]['popup_ix']."&popup_type=L' frameBorder=0 width=".$popup_data[$i]['popup_width']." height=".$popup_data[$i]['popup_height']."	scrolling=yes ></IFRAME>\");\n";
                    $mstring .= "document.write(\"</div>\");\n";
                    $mstring .= "}\n";
                }
            } else {

            }


            //팝업 실행시마다 시작, 종료날짜를 비교하여 상태 변경
            if ($popup_data[$i]['popup_use_sdate'] <= $nowDate && $popup_data[$i]['popup_use_edate'] >= $nowDate) {
                $popup_status = '2';
            } elseif ($popup_data[$i]['popup_use_sdate'] > $nowDate) {
                $popup_status = '1';
            } elseif ($popup_data[$i]['popup_use_edate'] < $nowDate) {
                $popup_status = '0';
            }

            $sql = "update seller_official_popup set
									popup_status='$popup_status'
									where popup_ix='".$popup_data[$i]['popup_ix']."'";

            $master_db->query($sql);
        }


        $mstring .= "</script>\n";
        return $mstring;
    }
}

function MainPopUp($display_position = 'M', $cid = '', $popup_position = "F")
{
    global $slave_mdb;

    $nowDate = date("Y-m-d H:i:s");

    if ($popup_position == "A") {
        $sql = "SELECT popup_ix,popup_text, popup_width, popup_height, popup_top, popup_left,popup_type
						FROM ".TBL_SHOP_POPUP." pp
						WHERE  disp = 1 and  pp.popup_position = '".$popup_position."'

						AND popup_use_sdate <= '".$nowDate."'
						AND popup_use_edate >= '".$nowDate."' ";
    } else {
        //$_SESSION["user"] 기존조건임 2014-08-18
        $sess["user"]["code"] = $_SESSION["user"]["code"] ?? '';

        if ($sess["user"]["code"]) {
            if ($display_position == 'M') {
                $sql = "SELECT pp.popup_ix,popup_text, popup_width, popup_height, popup_top, popup_left,popup_type
									FROM ".TBL_SHOP_POPUP." pp left join shop_popup_display_relation as pdr2 on (pp.popup_ix = pdr2.popup_ix and pdr2.pdr_div = 'T')
									WHERE  pp.popup_position = '".$popup_position."'
									and (

										pp.display_target='A'

										OR
										(
											pp.display_target='T' and pp.display_sub_target = 'M' and pdr2.pdr_sub_div = 'M' and pdr2.r_ix = '".$_SESSION["user"]["code"]."'
										)
										OR
										(
											pp.display_target='T' and pp.display_sub_target = 'G' and  pdr2.pdr_sub_div = 'G' and pdr2.r_ix = '".$_SESSION["user"]["gp_ix"]."'
										)
									)
									and disp = 1 and display_position = '$display_position'
									AND popup_use_sdate <= '".$nowDate."'
									AND popup_use_edate >= '".$nowDate."' ";
            } else if ($display_position == 'E') {
                $sql = "SELECT pp.popup_ix,popup_text, popup_width, popup_height, popup_top, popup_left,popup_type
									FROM ".TBL_SHOP_POPUP." as pp left join shop_popup_display_relation as pdr2 on (pp.popup_ix = pdr2.popup_ix and pdr2.pdr_div = 'T')
									WHERE pp.popup_position = '".$popup_position."'
									and (

										pp.display_target='A'

										OR
										(
											pp.display_target='T' and pp.display_sub_target = 'M' and pdr2.pdr_sub_div = 'M' and pdr2.r_ix = '".$_SESSION["user"]["code"]."'
										)
										OR
										(
											pp.display_target='T' and pp.display_sub_target = 'G' and  pdr2.pdr_sub_div = 'G' and pdr2.r_ix = '".$_SESSION["user"]["gp_ix"]."'
										)
									)
									and '".$_SERVER['REQUEST_URI']."' like concat(pp.display_url,'%') and disp = 1 and display_position = '$display_position'
									AND popup_use_sdate <= '".$nowDate."' AND popup_use_edate >= '".$nowDate."'";
            } else if ($display_position == 'C') {
                $sql = "SELECT pp.popup_ix,popup_text, popup_width, popup_height, popup_top, popup_left,popup_type
									FROM ".TBL_SHOP_POPUP." as pp left join shop_popup_display_relation as pdr2 on (pp.popup_ix = pdr2.popup_ix and pdr2.pdr_div = 'T')
									, shop_popup_display_relation as pdr
									WHERE pp.popup_ix = pdr.popup_ix and pdr.pdr_div = 'P'  and pdr.pdr_sub_div = 'C'
									and pp.popup_position = '".$popup_position."'
									and (

										pp.display_target='A'

										OR
										(
											pp.display_target='T' and pp.display_sub_target = 'M' and pdr2.pdr_sub_div = 'M' and pdr2.r_ix = '".$_SESSION["user"]["code"]."'
										)
										OR
										(
											pp.display_target='T' and pp.display_sub_target = 'G' and  pdr2.pdr_sub_div = 'G' and pdr2.r_ix = '".$_SESSION["user"]["gp_ix"]."'
										)
									)
									and pdr.r_ix = '$cid' and disp = 1 and display_position = '$display_position'
									AND popup_use_sdate <= '".$nowDate."' AND popup_use_edate >= '".$nowDate."'";
            }
        } else {
            if ($display_position == 'M') {
                $sql = "SELECT popup_ix,popup_text, popup_width, popup_height, popup_top, popup_left,popup_type
									FROM ".TBL_SHOP_POPUP." pp
									WHERE  disp = 1 and display_position = '$display_position' and pp.popup_position = '".$popup_position."'
									AND display_target='A'
									AND popup_use_sdate <= '".$nowDate."'
									AND popup_use_edate >= '".$nowDate."' ";
            } else if ($display_position == 'E') {
                $sql = "SELECT popup_ix,popup_text, popup_width, popup_height, popup_top, popup_left,popup_type
									FROM ".TBL_SHOP_POPUP." pp
									WHERE  disp = 1 and '".$_SERVER['REQUEST_URI']."' like concat(pp.display_url,'%')
									 and display_position = '$display_position' and pp.popup_position = '".$popup_position."'
									AND display_target='A'
									AND popup_use_sdate <= '".$nowDate."'
									AND popup_use_edate >= '".$nowDate."' ";
            } else if ($display_position == 'C') {
                $sql = "SELECT pp.popup_ix,popup_text, popup_width, popup_height, popup_top, popup_left,popup_type
									FROM ".TBL_SHOP_POPUP." as pp , shop_popup_display_relation as pdr
									WHERE pp.popup_ix = pdr.popup_ix and pdr_div = 'P'  and pdr_sub_div = 'C'
									and pdr.r_ix = '$cid' and disp = 1 and display_position = '$display_position' and pp.popup_position = '".$popup_position."'
									AND display_target='A'
									AND popup_use_sdate <= '".$nowDate."' AND popup_use_edate >= '".$nowDate."'";
            }
        }
    }

    //echo nl2br($sql);
    //exit;

    $slave_mdb->query($sql);

    if ($slave_mdb->total == 0) {
        return "";
    } else {
        $mstring .= "<script Language='JavaScript'>\n";
        for ($i = 0; $i < $slave_mdb->total; $i++) {
            $slave_mdb->fetch($i);
            if ($slave_mdb->dt['popup_type'] == "W") {
                $mstring .= "if(!readCookie('Notice".$slave_mdb->dt['popup_ix']."')){\n";

                $mstring .= "	MainPopUpWindow('/pop.php?no=".$slave_mdb->dt['popup_ix']."&popup_type=W',".$slave_mdb->dt['popup_width'].",".$slave_mdb->dt['popup_height'].",".$slave_mdb->dt['popup_top'].",".$slave_mdb->dt['popup_left'].",'pop".$slave_mdb->dt['popup_ix']."');\n";

                $mstring .= "}\n";
            } else {
                $mstring .= "if(!readCookie('Notice".$slave_mdb->dt['popup_ix']."')){\n";
                $mstring .= "document.write(\"<div id='divpop".$slave_mdb->dt['popup_ix']."' style='position:absolute;left:".$slave_mdb->dt['popup_left']."px;top:".$slave_mdb->dt['popup_top']."px;z-index:200;visibility:visible;'>\");\n";
                $mstring .= "document.write(\"<IFRAME id=popup".$slave_mdb->dt['popup_ix']." name=popup".$slave_mdb->dt['popup_ix']." src='/pop.php?no=".$slave_mdb->dt['popup_ix']."&popup_type=L' frameBorder=0 width=".$slave_mdb->dt['popup_width']." height=".$slave_mdb->dt['popup_height']." scrolling=no ></IFRAME>\");\n";

                $mstring .= "document.write(\"</div>\");\n";
                $mstring .= "}\n";
            }
        }
        $mstring .= "</script>\n";
        return $mstring;
    }
}

function MainMPopUp($display_position = 'M', $cid = '', $popup_position = "M")
{
    global $slave_mdb;

    $nowDate = date("Y-m-d H:i:s");

    if ($popup_position == "M") {
        $sql = "SELECT popup_ix,popup_text, popup_width, popup_height, popup_top, popup_left,popup_type
						FROM ".TBL_SHOP_POPUP." pp
						WHERE  disp = 1 and  pp.popup_position = '".$popup_position."'
						AND popup_use_sdate <= '".$nowDate."'
						AND popup_use_edate >= '".$nowDate."' ";
    } else {
        if ($_SESSION["user"]) {
            if ($display_position == 'M') {
                $sql = "SELECT pp.popup_ix,popup_text, popup_width, popup_height, popup_top, popup_left,popup_type
									FROM ".TBL_SHOP_POPUP." pp left join shop_popup_display_relation as pdr2 on (pp.popup_ix = pdr2.popup_ix and pdr2.pdr_div = 'T')
									WHERE pp.popup_position = '".$popup_position."'
									and (

										pp.display_target='A'

										OR
										(
											pp.display_target='T' and pp.display_sub_target = 'M' and pdr2.pdr_sub_div = 'M' and pdr2.r_ix = '".$_SESSION["user"]["code"]."'
										)
										OR
										(
											pp.display_target='T' and pp.display_sub_target = 'G' and  pdr2.pdr_sub_div = 'G' and pdr2.r_ix = '".$_SESSION["user"]["gp_ix"]."'
										)
									)
									and disp = 1 and display_position = '$display_position'
									AND popup_use_sdate <= '".$nowDate."'
									AND popup_use_edate >= '".$nowDate."' ";
            } else {
                $sql = "SELECT pp.popup_ix,popup_text, popup_width, popup_height, popup_top, popup_left,popup_type
									FROM ".TBL_SHOP_POPUP." as pp left join shop_popup_display_relation as pdr2 on (pp.popup_ix = pdr2.popup_ix and pdr2.pdr_div = 'T')
									, shop_popup_display_relation as pdr
									WHERE pp.popup_ix = pdr.popup_ix and pdr.pdr_div = 'P'  and pdr.pdr_sub_div = 'C'
									and pp.popup_position = '".$popup_position."'
									and (

										pp.display_target='A'

										OR
										(
											pp.display_target='T' and pp.display_sub_target = 'M' and pdr2.pdr_sub_div = 'M' and pdr2.r_ix = '".$_SESSION["user"]["code"]."'
										)
										OR
										(
											pp.display_target='T' and pp.display_sub_target = 'G' and  pdr2.pdr_sub_div = 'G' and pdr2.r_ix = '".$_SESSION["user"]["gp_ix"]."'
										)
									)
									and pdr.r_ix = '$cid' and disp = 1 and display_position = '$display_position'
									AND popup_use_sdate <= '".$nowDate."' AND popup_use_edate >= '".$nowDate."'";
            }
        } else {
            if ($display_position == 'M') {
                $sql = "SELECT popup_ix,popup_text, popup_width, popup_height, popup_top, popup_left,popup_type
									FROM ".TBL_SHOP_POPUP." pp
									WHERE  disp = 1 and display_position = '$display_position' and pp.popup_position = '".$popup_position."'
									AND display_target='A'
									AND popup_use_sdate <= '".$nowDate."'
									AND popup_use_edate >= '".$nowDate."' ";
            } else {
                $sql = "SELECT pp.popup_ix,popup_text, popup_width, popup_height, popup_top, popup_left,popup_type
									FROM ".TBL_SHOP_POPUP." as pp , shop_popup_display_relation as pdr
									WHERE pp.popup_ix = pdr.popup_ix and pdr_div = 'P'  and pdr_sub_div = 'C'
									and pdr.r_ix = '$cid' and disp = 1 and display_position = '$display_position' and pp.popup_position = '".$popup_position."'
									AND display_target='A'
									AND popup_use_sdate <= '".$nowDate."' AND popup_use_edate >= '".$nowDate."'";
            }
        }
    }

    //echo nl2br($sql);
    //exit;

    $slave_mdb->query($sql);

    if ($slave_mdb->total == 0) {
        return "";
    } else {
        $mstring .= "<script type='text/javascript'>\n";
        for ($i = 0; $i < $slave_mdb->total; $i++) {
            $slave_mdb->fetch($i);
            if ($slave_mdb->dt['popup_type'] == "W") {
                $mstring .= "if(!readCookie('Notice".$slave_mdb->dt['popup_ix']."')){\n";

                $mstring .= "	MainPopUpWindow('/pop_m.php?no=".$slave_mdb->dt['popup_ix']."&popup_type=W',".$slave_mdb->dt['popup_width'].",".$slave_mdb->dt['popup_height'].",".$slave_mdb->dt['popup_top'].",".$slave_mdb->dt['popup_left'].",'pop".$slave_mdb->dt['popup_ix']."');\n";

                $mstring .= "}\n";
            } else {
                $mstring .= "if(!readCookie('Notice".$slave_mdb->dt['popup_ix']."')){\n";
                $mstring .= "document.write(\"<div style='width:100%;  position:absolute; top:0px; z-index:9999;' class='pop_wrap_width' id='divpop".$slave_mdb->dt['popup_ix']."' style='position:absolute;top:".$slave_mdb->dt['popup_top']."px;z-index:200;visibility:visible;'>\");\n";
                $mstring .= "document.write(\"<IFRAME id=popup".$slave_mdb->dt['popup_ix']." class='pop_wrap_iframe' name=popup".$slave_mdb->dt['popup_ix']." src='/pop_m.php?no=".$slave_mdb->dt['popup_ix']."&popup_type=L' frameBorder=0 width='100%' height='500' scrolling=no ></IFRAME>\");\n";

                $mstring .= "document.write(\"</div>\");\n";
                $mstring .= "}\n";
            }
        }
        $mstring .= "</script>\n";
        return $mstring;
    }
}

function servicePopUp($popupinfo)
{

    if ($popupinfo[0] == "") {
        return "";
    } else {
        $mstring .= "<script type='text/javascript' language=javascript src='".$_SESSION["layout_config"]["mall_data_root"]."/templet/".$_SESSION["layout_config"]["mall_use_templete"]."/js/basic_head.js'></script>\n
									<script Language='JavaScript'>\n";

        for ($i = 0; $i < count($popupinfo); $i++) {

            if ($popupinfo[$i]->popup_type == "W") {
                $mstring .= "if(!readCookie('Notice_".$popupinfo[$i]->popup_ix."')){\n";
                $mstring .= "	MainPopUpWindow('/pop.php?no=".$popupinfo[$i]->popup_ix."&popup_type=W&popup_way=mallstory',".$popupinfo[$i]->popup_width.",".$popupinfo[$i]->popup_height.",".$popupinfo[$i]->popup_top.",".$popupinfo[$i]->popup_left.",'pop".$popupinfo[$i]->popup_ix."');\n";
                $mstring .= "}\n";
            } else {
                $mstring .= "if(!readCookie('Notice_".$popupinfo[$i]->popup_ix."')){\n";
                $mstring .= "document.write(\"<div id='divpop".$popupinfo[$i]->popup_ix."' style='position:absolute;left:".$popupinfo[$i]->popup_left."px;top:".$popupinfo[$i]->popup_top."px;z-index:200;visibility:visible;'>\");\n";
                $mstring .= "document.write(\"<IFRAME id=popup".$popupinfo[$i]->popup_ix." name=popup".$popupinfo[$i]->popup_ix." src='/pop.php?no=".$popupinfo[$i]->popup_ix."&popup_type=L&popup_way=mallstory' frameBorder=0 width=".$popupinfo[$i]->popup_width." height=".$popupinfo[$i]->popup_height." scrolling=no ></IFRAME>\");\n";

                $mstring .= "document.write(\"</div>\");\n";
                $mstring .= "}\n";
            }
        }
        $mstring .= "</script>\n";

        return $mstring;
    }
}

function getReserve($basic_return = "", $return_type = "", $reserve_type = "mileage")
{
    global $user;
    global $slave_mdb;

    if ($user['code'] == "") {
        return 0;
    }

    if ($reserve_type == "mileage") {
        $select_name = 'mileage';
    } else if ($reserve_type == "point") {
        $select_name = 'point';
    }

    $slave_mdb->query("SELECT $select_name as reserve FROM ".TBL_COMMON_USER." WHERE code = '".$user['code']."'");

    $slave_mdb->fetch();

    if ($slave_mdb->dt['reserve'] == 0) {
        if ($basic_return == 0) {
            return 0;
        } else {
            return $basic_return;
        }
    } else {
        if ($return_type == "number") {
            if ($slave_mdb->dt['reserve'] == '') {
                return 0;
            } else {
                return $slave_mdb->dt['reserve'];
            }
        } else {

            return number_format($slave_mdb->dt['reserve'], 0);
        }
    }
}

function get_state_reserve($state, $reserve_type = "mileage")
{
    global $user;
    global $slave_mdb;
    if (!$user['code']) {
        return '0';
    }

    if ($reserve_type == "mileage") {
        $select_table_add = 'shop_add_mileage';
        $select_table_use = 'shop_use_mileage';
    } else if ($reserve_type == "point") {
        $select_table_add = 'shop_use_point';
        $select_table_use = 'shop_add_point';
    }

    /* 20160425 pde 기존에는 shop_reserve를 사용했으나 변경되어 수정. member_batch.act.php 의 InsertMileageInfo 참조.
      $sql = "SELECT sum(reserve) as reserve FROM ".$select_table." WHERE uid = '".$user[code]."' and state = '".$state."'";
     */

    if ($state == '1') {
        $sql = "SELECT sum(am_mileage) as reserve FROM ".$select_table_add." WHERE uid = '".$user['code']."' and am_state = '1'";
        $slave_mdb->query($sql);
        $slave_mdb->fetch();
    } else {
        $sql = "SELECT sum(um_mileage) as reserve FROM ".$select_table_use." WHERE uid = '".$user['code']."' and um_state = '1'";
        $slave_mdb->query($sql);
        $slave_mdb->fetch();
    }


    return $slave_mdb->dt['reserve'];
}

function setReserve($slave_mdb, $code, $reserve_price, $message)
{
    if ($code && $reserve_price && $message) {
        $sql = "INSERT INTO ".TBL_SHOP_RESERVE_INFO." (id,uid,oid,pid,ptprice,payprice,reserve,state,etc,regdate)
				VALUES
				('','".$code."','','','0','0','".$reserve_price."','1','".$message."',NOW())";

        //$slave_mdb->query($sql);
    }
}

function getCoupon($basic_return = "", $cupon_div = "", $use_yn = "")
{
    global $user;
    global $slave_mdb;
    if ($user['code'] == "" || $_SESSION["user"]["use_coupon_yn"] == "N") {
        return "";
    }

    /*
      $sql = 	"SELECT cp.cupon_ix
      FROM ".TBL_SHOP_CUPON_PUBLISH." cp , ".TBL_SHOP_CUPON_REGIST." cr , ".TBL_SHOP_CUPON." c
      where cr.publish_ix = cp.publish_ix and c.cupon_ix = cp.cupon_ix
      and use_yn = 0 and ".date("Ymd")." between  cr.use_sdate and cr.use_date_limit
      and cr.mem_ix = '".$user[code]."' ";
      //and ((cp.use_date_type!='9' AND ".date("Ymd")." between cr.use_sdate and cr.use_date_limit) OR cp.use_date_type=9)
     */

    //[Start] 모바일은 모바일용, 전체용만 나오게 - 151118 pyw
    if (is_mobile()) {
        $where = " AND  c.cupon_use_div in ('A','M') ";
    } else {
        //PC는 PC와 전체만
        $where = " AND  c.cupon_use_div in ('A','G') ";
    }
    //[End]

    if ($use_yn == "1") {
        $status_str = "and (use_yn = '1' or (use_yn = '0' and cr.use_date_limit < ".date("Ymd")." and cp.use_date_type!='9')) ";
    } elseif ($use_yn == "all") {

    } else {
        $status_str = "and use_yn = '0' and ".date("Ymd")." <= cr.use_date_limit ";
    }

    $sql = "SELECT count(*) as total
				FROM ".TBL_SHOP_CUPON_PUBLISH." cp , ".TBL_SHOP_CUPON_REGIST." cr , ".TBL_COMMON_USER." cu , ".TBL_COMMON_MEMBER_DETAIL." cmd , ".TBL_SHOP_CUPON." c
				where cr.publish_ix = cp.publish_ix
				and cu.code = cr.mem_ix
				and cu.code = cmd.code
				and c.cupon_ix = cp.cupon_ix
				and cr.mem_ix = '".$user['code']."'
				$status_str $where
				";


    if ($cupon_div != "") {
        $sql .= "and cp.cupon_div = '".$cupon_div."'";
    } else {
        //PC 마이페이지 나의쿠폰에서 보유쿠폰 갯수와 쿠폰리스트에서 보여지는 갯수와 달라서 주석 처리
        //$sql .= "and cp.cupon_div not in ( 'D','C') ";
    }

    //[Start] 쿠폰 수 가져올때 기간이 지난것들을 걸러주기 위해서 -20151021 - pyw
    //아래 쿼리는 /shop/coupon_pop.php SelectCuponKind() 에서 가져옴
    $sql .= " AND
					((cp.use_date_type = '3' AND '".date("Y-m-d H:i:s")."' BETWEEN cp.use_sdate AND cp.use_edate)
					OR (cp.use_date_type = '1' AND '".date("Y-m-d H:i:s")."' BETWEEN cp.regdate AND
					CASE
					WHEN publish_date_type = '1' THEN DATE_ADD(cp.regdate, INTERVAL cp.publish_date_differ YEAR )
					WHEN publish_date_type = '2' THEN DATE_ADD(cp.regdate, INTERVAL cp.publish_date_differ MONTH )
					WHEN publish_date_type = '3' THEN DATE_ADD(cp.regdate, INTERVAL cp.publish_date_differ DAY)
					END)
					OR cp.use_date_type=9
					OR cp.use_date_type=2)";
    //[End]

    $slave_mdb->query($sql);
    $slave_mdb->fetch();
    $ptotal = $slave_mdb->dt['total'];

    if ($ptotal == 0) {
        return $basic_return;
    } else {
        return $ptotal;
    }
}
/* function getAsk($basic_return = "")
  {
  global $user;
  if($user[code] == ""){
  return "";
  }

  $slave_mdb = new Database;
  $sql = 	"SELECT bbs_ix
  FROM bbs_qna2
  where mem_ix = '".$user[code]."'
  ";

  $slave_mdb->query($sql);
  $ptotal = $slave_mdb->total;

  if($ptotal == 0){
  return $basic_return;
  }else{
  return $ptotal;
  }
  } */

function getOrder($basic_return = "")
{
    global $user;
    global $slave_mdb;
    if ($user['code'] == "") {
        return "";
    }


    //$slave_mdb = new Database;

    $sql = "SELECT od.oid
			FROM shop_order o , shop_order_detail od
			where o.oid=od.oid and user_code = '".$user['code']."' and od.status in ('IR','IC','DR','DI','EA','EC') group by od.oid
			";


    $slave_mdb->query($sql);
    $ptotal = $slave_mdb->total;

    if ($ptotal == 0) {
        return $basic_return;
    } else {
        return $ptotal;
    }
}

function getOrderCount_all_status($basic_return = "", $p_type = "")
{//모든 주문에 대한 카운트 kbk 13/06/28 //$p_type 인자값 추가 kbk 13/08/27
    global $user, $shop_product_type, $sns_product_type; //$shop_product_type, $sns_product_type 추가하여 상품군 불러오는 정보 구별함 kbk 13/08/27
    global $slave_mdb;

    if ($user['code'] == "") {
        return "";
    }

    if ($p_type == "sns") $add_query = " and od.product_type in (".implode(' , ', $sns_product_type).") ";
    else $add_query = " and od.product_type in (".implode(' , ', $shop_product_type).") ";
    //$slave_mdb = new Database;

    $sql = "SELECT COUNT(DISTINCT(od.oid)) AS cnt
			FROM shop_order o , shop_order_detail od
			where o.oid=od.oid and user_code = '".$user['code']."' and od.status != 'SR' $add_query
			";


    $slave_mdb->query($sql);
    $slave_mdb->fetch();
    $cnt = $slave_mdb->dt["cnt"];

    if ($cnt == 0) {
        return $basic_return;
    } else {
        return $slave_mdb->dt["cnt"];
    }
}

function getOrderProduct_count($basic_return = "", $p_type = "", $s_type = "")
{//총 구매 상품 수 kbk 13/07/14 //$p_type 인자값 추가 kbk 13/08/27
    global $shop_product_type, $sns_product_type; //$shop_product_type, $sns_product_type 추가하여 상품군 불러오는 정보 구별함 kbk 13/08/27
    global $slave_mdb;
    //$slave_mdb = new Database;

    if ($p_type == "sns") $add_query = " and od.product_type in (".implode(' , ', $sns_product_type).") ";
    else $add_query = " and od.product_type in (".implode(' , ', $shop_product_type).") ";


    if ($s_type == "delivery") {
        $add_query .= " and od.status in ('IC','DR','DD','DI') ";
    }

    $sql = "SELECT COUNT(od.od_ix) AS cnt
				FROM ".TBL_SHOP_ORDER." o LEFT JOIN ".TBL_SHOP_ORDER_DETAIL." od ON o.oid=od.oid and od.status NOT IN ('SR')
				where user_code = '".$_SESSION["user"]["code"]."' and od.status NOT IN ('SR') $add_query
				";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();
    $cnt = $slave_mdb->dt["cnt"];

    if ($cnt == 0) {
        return $basic_return;
    } else {
        return $slave_mdb->dt["cnt"];
    }
}

function getOrderPayment_price($basic_return = "", $p_type = "")
{//총 구매 금액 kbk 13/07/14 //$p_type 인자값 추가 kbk 13/08/27
    global $shop_product_type, $sns_product_type; //$shop_product_type, $sns_product_type 추가하여 상품군 불러오는 정보 구별함 kbk 13/08/27
    global $slave_mdb;
    //$slave_mdb = new Database;

    if ($p_type == "sns") $add_query = " and od.product_type in (".implode(' , ', $sns_product_type).") ";
    else $add_query = " and od.product_type in (".implode(' , ', $shop_product_type).") ";

    $sql = "SELECT SUM(od.ptprice) AS total_ptprice
				FROM ".TBL_SHOP_ORDER." o LEFT JOIN ".TBL_SHOP_ORDER_DETAIL." od ON o.oid=od.oid and od.status NOT IN ('SR')
				where user_code = '".$_SESSION["user"]["code"]."' and od.status NOT IN ('SR') $add_query
				";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    $total_ptprice = $slave_mdb->dt["total_ptprice"];

    if ($total_ptprice == 0) {
        return $basic_return;
    } else {
        return $slave_mdb->dt["total_ptprice"];
    }
}

function getCartCount($basic_return = "", $p_type = "")
{//$p_type 인자값 추가 kbk 13/08/27
    global $user, $shop_product_type, $sns_product_type; //$shop_product_type, $sns_product_type 추가하여 상품군 불러오는 정보 구별함 kbk 13/08/27
    global $slave_mdb;
    if ($user['code'] == "") {
        return "";
    }

    if ($p_type == "sns") $add_query = " and product_type in (".implode(' , ', $sns_product_type).") ";
    else $add_query = " and product_type in (".implode(' , ', $shop_product_type).") ";

    //$slave_mdb = new Database;
    $sql = "select cart_ix from shop_cart where mem_ix = '".$user['code']."' $add_query ";

    //return $sql;
    $slave_mdb->query($sql);
    $ptotal = $slave_mdb->total;

    if ($ptotal == 0) {
        return $basic_return;
    } else {
        return $ptotal;
    }
}

function getWishlist($basic_return = "")
{
    global $user;
    global $slave_mdb;
    if ($user['code'] == "") {
        return "";
    }

    //$slave_mdb = new Database;
    $sql = "select wid from shop_wishlist where mid = '".$user['code']."' ";

    //return $sql;
    $slave_mdb->query($sql);
    $ptotal = $slave_mdb->total;

    if ($ptotal == 0) {
        return $basic_return;
    } else {
        return $ptotal;
    }
}

function getRegistWishlistYn($id)
{
    global $user;
    global $slave_mdb;
    if ($user['code'] == "") {
        return "";
    }

    $sql    = "select wid from shop_wishlist where mid = '".$user['code']."' and pid='".$id."' ";
    $slave_mdb->query($sql);
    $ptotal = $slave_mdb->total;

    if ($ptotal == 0) {
        return 0;
    } else {
        return $ptotal;
    }
}

function getMinishop()
{
    global $slave_mdb;
    $sql = "SELECT count(*) as total FROM shop_minishop_favorite mf, common_seller_detail sd
				where sd.company_id = mf.company_id AND mf.ucode = '".$_SESSION['user']['code']."'";

    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    $total = $slave_mdb->dt['total'];
    return $total;
}

// 문자열 자르기
function cut_str($str, $len, $addstring = true)
{

    return mb_strimwidth($str, '0', $len, '...', 'utf-8');
    //	return strcut_utf8($str, $len);
    exit;
    if (strlen($str) < $len) return $str;

    $str = substr($str, 0, $len);
    $j   = 0;

    for ($i = strlen($str) - 1; $i >= 0; $i--) {
        if (ord($str[$i]) <= 127) break;
        $j++;
    }

    $str = ($j % 2) ? substr($str, 0, strlen($str) - 1) : $str;

    if ($addstring) $str .= "...";


    return $str;
}
/* * ****UTF-8 문자열 자르기 *************** */

function strcut_utf8($str, $len, $checkmb = false, $tail = '...')
{
    // global $str,$len,$checkmb,$tail;
    preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
    $m    = $match[0];
    $slen = strlen($str);  // length of source string
    $tlen = strlen($tail); // length of tail string
    $mlen = count($m);    // length of matched characters

    if ($slen <= $len) return $str;
    if (!$checkmb && $mlen <= $len) return $str;

    $ret   = array();
    $count = 0;

    for ($i = 0; $i < $len; $i++) {
        $count += ($checkmb && strlen($m[$i]) > 1) ? 2 : 1;
        if ($count + $tlen > $len) break;
        $ret[] = $m[$i];
    }
    return join('', $ret).$tail;
}

function strcut2_utf8($str, $size)
{
    $substr     = substr($str, 0, $size * 2);
    $multi_size = preg_match_all('/[\x80-\xff]/', $substr, $multi_chars);

    if ($multi_size > 0) $size = $size + intval($multi_size / 3) - 1;

    if (strlen($str) > $size) {
        $str = substr($str, 0, $size);
        $str = preg_replace('/(([\x80-\xff]{3})*?)([\x80-\xff]{0,2})$/', '$1', $str);
        $str .= '...';
    }

    return $str;
}

function cut_str_change($str, $len, $tail = '*')
{

    preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
    $m    = $match[0];
    $slen = strlen($str);  // length of source string
    $tlen = strlen($tail); // length of tail string
    $mlen = count($m);    // length of matched characters

    if ($slen <= $len) return $str;

    $ret   = array();
    $count = 0;

    $value = str_replace($m[$len - 1], $tail, $str);

    return $value;
}

function cut_id_change($str, $start)
{

    /*
      $str : 문구
      $start : 바꾸시 시작위치
     */

    $str_len = strlen($str);
    preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
    $m       = $match[0];

    for ($i = 0; $i < count($m); $i++) {
        if ($i > $start - 1 && is_int($i / 2)) {
            $data[$i] = str_replace($m[$i], '*', $m[$i]);
        } else {
            $data[$i] = $m[$i];
        }
    }

    $value = implode('', $data);

    return "$value";
}

//특정위치 이후 변경되는 문자로 치환
function cut_id_change_cnt($str, $start, $tail = '*')
{

    /*
      $str : 문구
      $start : 바꾸시 시작위치
     */

    $str_len = strlen($str);
    preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
    $m       = $match[0];

    for ($i = 0; $i < count($m); $i++) {
        if ($i > $start - 1) {
            $data[$i] = str_replace($m[$i], $tail, $m[$i]);
        } else {
            $data[$i] = $m[$i];
        }
    }

    $value = implode('', $data);

    return "$value";
}

function returnBannerType($vfile, $vtype, $w_size, $h_size, $link = '')
{
    if ($vtype == 0) {
        return "<a href='$link'><img src='/image/banner/".$vfile.".gif' width='$w_size' height='$h_size' border=0></a>";
    } else {
        return "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='".$w_size."' height='".$h_size."'>
					<param name='movie' value='/image/banner/".$vfile.".swf'>
					<param name='quality' value='high'>
					<embed src='/image/banner/".$vfile.".swf' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='".$w_size."' height='".$h_size."'></embed>
				</object>";
    }
}

function DispalyProductPrice($slave_mdb, $returnType = "text")
{
    global $user, $layout_config;

    $user['mem_level'] = $user['mem_level'] ?? '';

    if ($returnType == "text") {
        if ($user['mem_level'] == "M" && $slave_mdb->dt['prd_member_price'] != 0) {
            return number_format($slave_mdb->dt['prd_member_price'], 0)." 원<br><!--strike>".number_format($slave_mdb->dt['sellprice'], 0)." 원</strike-->";
        } else if ($user['mem_level'] == "D" && $slave_mdb->dt['prd_dealer_price'] != 0) {
            return number_format($slave_mdb->dt['prd_dealer_price'], 0)." 원<br><!--strike>".number_format($slave_mdb->dt['sellprice'], 0)." 원</strike-->";
        } else if ($user['mem_level'] == "A" && $slave_mdb->dt['prd_agent_price'] != 0) {
            return number_format($slave_mdb->dt['prd_agent_price'], 0)." 원<br><!--strike>".number_format($slave_mdb->dt['sellprice'], 0)." 원</strike-->";
        } else {
            if ($_SESSION["layout_config"]['mall_price_open']) {
                return number_format($slave_mdb->dt['sellprice'], 0)." 원";
            } else {
                return "";
            }
            //return number_format($slave_mdb->dt[sellprice],0)." 원";
        }
    } else {
        if ($user['mem_level'] == "M" && $slave_mdb->dt['prd_member_price'] != 0) {
            return $slave_mdb->dt['prd_member_price'];
        } else if ($user['mem_level'] == "D" && $slave_mdb->dt['prd_dealer_price'] != 0) {
            return $slave_mdb->dt['prd_dealer_price'];
        } else if ($user['mem_level'] == "A" && $slave_mdb->dt['prd_agent_price'] != 0) {
            return $slave_mdb->dt['prd_agent_price'];
        } else {
            return ($slave_mdb->dt['sellprice'] ?? '');
        }
    }
}

function DisplayRecommendPrice($sellprice, $saveprice)
{

    if (RecommendCheck()) {
        if ($saveprice == "" || $saveprice == 0) {
            return number_format($sellprice, 0);
        } else {
            return number_format($sellprice, 0);
        }
    } else {
        return number_format($sellprice, 0);
    }
}

function RecommendPrice($sellprice, $saveprice)
{

    //echo $sellprice ."::".$saveprice;
    if (RecommendCheck()) {
        if ($saveprice == "" || $saveprice == 0) {
            return $sellprice;
        } else {
            return ($sellprice - $saveprice);
        }
    } else {
        return $sellprice;
    }
}

function product_page_bar($total, $page, $max, $add_query = "", $target = false)
{

    global $cid, $depth, $category_load, $company_id;
    global $nset, $orderby, $layout_config;
    global $HTTP_URL;

    $templet_src = sess_val('layout_config', 'mall_templet_webpath');

    $total_page = ceil($total / $max);




    $total_nset = ceil($total_page / 10);
    $next_nset  = (($nset) * 10 + 1);
    $prev_nset  = (($nset - 2) * 10 + 1);

    $nset = ceil($page / 10);

    $first_page = ($nset - 1) * 10;

    if ($nset >= $total_nset) {
        $last_page = $total_page;
    } else {
        $last_page = $nset * 10;
    }



    // 10페이지 단위 이동버튼
    if ($total) {
        /* 이미지일 경우
          $prev_mark_1 = "<a href='".$HTTP_URL."?nset=1&page=1$add_query' ".($target ? "target='act'" : "")."><img src='".$templet_src."/images/arrowleft01.png' border=0 align=absmiddle style='margin:0 6px;vertical-align:middle;'/></a>";
          $prev_mark_end = "<a href='".$HTTP_URL."?nset=1&page=$total_page$add_query' ".($target ? "target='act'" : "")."><img src='".$templet_src."/images/arrowright01.png' border=0 align=absmiddle  style='margin:0 6px;vertical-align:middle;'/></a>";
          $prev_mark_10 = ($nset > 1) ? "<a href='".$HTTP_URL."?nset=1&page=".$first_page."$add_query' ".($target ? "target='act'" : "")."><img src='".$templet_src."/images/arrowleft02.png' border=0 style='margin:0 6px;vertical-align:middle;' align=absmiddle /></a>" : "<img src='".$templet_src."/images/arrowleft02.png' border=0 align=absmiddle style='margin:0 6px;vertical-align:middle;'/>";
          $next_mark_10 = ($nset < $total_nset) ? "<a href='".$HTTP_URL."?nset=1&page=".($last_page+1)."$add_query' ".($target ? "target='act'" : "")."><img src='".$templet_src."/images/arrowright02.png' border=0 align=absmiddle style='margin:0 6px;vertical-align:middle;'/></a>" :  "<img src='".$templet_src."/images/arrowright02.png' border=0 align=absmiddle style='margin:0 6px;vertical-align:middle;'>";
         */
        /* 텍스트일 경우 */
        $prev_mark_1   = "<a href='".$HTTP_URL."?nset=1&page=1$add_query' ".($target ? "target='act'" : "")." class='first-button'><i>paging first</i></a>";
        $prev_mark_end = "<a href='".$HTTP_URL."?nset=1&page=$total_page$add_query' ".($target ? "target='act'" : "")." class='last-button'><i>paging previous 10page</i></a>";
        $prev_mark_10  = ($nset > 1) ? "<a href='".$HTTP_URL."?nset=1&page=".$first_page."$add_query' ".($target ? "target='act'" : "")." class='prev-button'><i>paging previous 10page</i></a>"
                : "<span class='prev-button'><i>under 10page</i></span>";
        $next_mark_10  = ($nset < $total_nset) ? "<a href='".$HTTP_URL."?nset=1&page=".($last_page + 1)."$add_query' ".($target ? "target='act'" : "")." class='next-button'><i>paging next 10page</i></a>"
                : "<span class='next-button'><i>under 10page</i></span>";



        $prev_mark_10 = ($nset > 1) ? "<alick='location.href=".$HTTP_URL."?nset=1&page=".$first_page."$add_query' ".($target ? "target='act'" : "")."><em class='hidden'>preview 10 paging</em></button>"
                : "<button class='prev-button' disabled='disabled'><em class='hidden'>preview 5 paging</em></button>";
        $next_mark_10 = ($nset < $total_nset) ? "<button class='next-button' onclick='location.href=".$HTTP_URL."?nset=1&page=".($last_page + 1)."$add_query' ".($target
                ? "target='act'" : "")."><em class='hidden'>next 10 paging</em></button>" : "<button class='next-button' disabled='disabled'><em class='hidden'>preview 5 paging</em></button>";
    } else {
        $prev_mark_1   = gVal('prev_mark_1');
        $prev_mark_10  = gVal('prev_mark_10');
        $next_mark_10  = gVal('next_mark_10');
        $prev_mark_end = gVal('prev_mark_end');
    }
    // next, prev 버튼

    /*
      if ($total){
      $prev_mark = (($page-1) > 0) ? "<a href='".$HTTP_URL."?nset=$nset&page=".(($page-1))."$add_query'><img src='".$templet_src."/images/arrow_prev.gif' border=0 align=absmiddle></a>&nbsp; " : "<img src='".$templet_src."/images/arrow_prev.gif' border=0 align=absmiddle>&nbsp; ";
      $next_mark = ($total > ($page * $max)) ? "&nbsp;<a href='".$HTTP_URL."?nset=$nset&page=".($page+1)."$add_query' > <img src='".$templet_src."/images/arrow_next.gif' border=0 align=absmiddle></a>" :  "&nbsp;<img src='".$templet_src."/images/arrow_next.gif' border=0 align=absmiddle>";
      }
     */

    $page_string = ($prev_mark ?? '');

    for ($i = ($nset - 1) * 10 + 1; $i <= (($nset - 1) * 10 + 10); $i++) {
        if ($i > 0) {
            if ($i <= $total_page) {
                if ($i != $page) {
                    $page_string .= '<a href="javascript:void(0)" class="font-en" onclick="'.($target ? "window.frames['act']." : "").'location.href=\''.$HTTP_URL.'?nset='.$nset.'&page='.$i.$add_query.'\';">'.$i.'</a>';

                    /*
                      $page_string .= '<span onclick="'.($target ? "window.frames['act']." : "").'location.href=\''.$HTTP_URL.'?nset='.$nset.'&page='.$i.$add_query.'\';"  onmouseover="$(this).addClass(\'on\')"   onmouseout="$(this).removeClass(\'on\')" >'.$i.'</span>';
                     */
                    /*
                      if($i != (($nset-1)*10+1)){
                      $page_string = $page_string.("<font color='silver'>|</font> <a href='".$HTTP_URL."?nset=$nset&page=$i$add_query' style='font-weight:bold;color:gray' >$i</a> ");
                      }else{
                      $page_string = $page_string.(" <a href='".$HTTP_URL."?nset=$nset&page=$i$add_query' style='font-weight:bold;color:gray' >$i</a> ");
                      }
                     */
                } else {
                    $page_string .= '<em class="font-en on">'.$i.'</em>';
                    /*
                      if($i != (($nset-1)*10+1)){
                      $page_string = $page_string.("<font color='silver'>|</font> <font color=#ff7635 style='font-weight:bold'>$i</font> ");
                      }else{
                      $page_string = $page_string.("<font color=#ff7635 style='font-weight:bold'>$i</font> ");
                      }
                     */
                }
            }
        }
    }

    //$page_string = $page_string.$next_mark;

    $page_string = $prev_mark_1.$prev_mark_10.$page_string.$next_mark_10.$prev_mark_end;
    //$page_string = $prev_mark_10.$page_string.$next_mark_10;
    //return '<div style="padding-bottom:1px;">'.$page_string.'</div>';
    return $page_string;
}

function product_page_mobile($total, $page, $max, $add_query = "")
{

    global $cid, $depth, $category_load, $company_id;
    global $nset, $orderby, $layout_config;
    global $HTTP_URL, $_LANGUAGE;

    $templet_src = sess_val('layout_config', 'mall_templet_webpath');

    $total_page = ceil($total / $max);




    $total_nset = ceil($total_page / 10);
    $next_nset  = (($nset) * 10 + 1);
    $prev_nset  = (($nset - 2) * 10 + 1);

    $nset = ceil($page / 10);

    $first_page = ($nset - 1) * 10;

    if ($nset >= $total_nset) {
        $last_page = $total_page;
    } else {
        $last_page = $nset * 10;
    }

    // 10페이지 단위 이동버튼
    /*
      if ($total){
      $prev_mark_10 = ($nset > 1) ? "<a href='".$HTTP_URL."?page=$first_page$add_query'><img src='".$templet_src."/images/arrow_prev.gif' border=0 align=absmiddle onmouseover=\"this.src='".$templet_src."/images/arrow_prev_on.gif'\" onmouseout=\"this.src='".$templet_src."/images/arrow_prev.gif'\" /></a>&nbsp;" : "<img src='".$templet_src."/images/arrow_prev.gif' border=0 align=absmiddle>&nbsp;";
      $next_mark_10 = ($nset < $total_nset) ? "&nbsp;<a href='".$HTTP_URL."?page=".($last_page+1)."$add_query' > <img src='".$templet_src."/images/arrow_next.gif' border=0 align=absmiddle onmouseover=\"this.src='".$templet_src."/images/arrow_next_on.gif'\" onmouseout=\"this.src='".$templet_src."/images/arrow_next.gif'\" /></a>" :  "&nbsp;<img src='".$templet_src."/images/arrow_next.gif' border=0 align=absmiddle>";
      }
     */
    // next, prev 버튼
    if ($total) {
        $prev_mark = (($page - 1) > 0) ? "<a href='".$HTTP_URL."?nset=$nset&page=".(($page - 1))."$add_query'><img src='".$templet_src."/images/shop/befor_arrow.gif' border=0 align=absmiddle></a>  "
                : "<img src='".$templet_src."/images/shop/befor_arrow.gif' border=0 align=absmiddle> ";

        $next_mark = ($total > ($page * $max)) ? " <a href='".$HTTP_URL."?nset=$nset&page=".($page + 1)."$add_query' > <img src='".$templet_src."/images/shop/next_arrow.gif' border=0 align=absmiddle></a>"
                : " <img src='".$templet_src."/images/shop/next_arrow.gif' border=0 align=absmiddle>";
    }

    $prev_mark   = $prev_mark ?? '';
    $page_string = $prev_mark;

    if ($max * $page > $total) $curItem = $total;
    else $curItem = $max * $page;

    $page_string .= "<div class='page_class'>";
    $page_string .= "<span>";
    $page_string .= getLanguageText('b5e087f6f0fdabdc4c163a3882ab6eb6')."(<span class='paging_item'>".$curItem."</span>/<span class='paging_total'>".$total."</span>)";
    $page_string .= "</span>";
    /* for ($i = ($nset-1)*10+1 ; $i <= (($nset-1)*10 + 10); $i++)
      {
      if ($i > 0)
      {
      if ($i <= $total_page)
      {
      if ($i == $page){
      $page_string .= '<span>'.$i.'</span>';
      }
      }
      }
      }
      if ($total) $page_string .= '/'.$total_page; */


    $page_string .= '</div>';

    $next_mark   = $next_mark ?? '';
    $page_string = $page_string.$next_mark;

    $page_string = ($prev_mark_10 ?? '').$page_string.($next_mark_10 ?? '');

    return $page_string;
}

function product_page_bar2($total, $page, $max, $add_query = "")
{

    global $cid, $depth, $category_load, $company_id;
    global $nset, $orderby;
    global $HTTP_URL;

    if ($total % $max > 0) {
        $total_page = floor($total / $max) + 1;
    } else {
        $total_page = floor($total / $max);
    }



    if ($nset == "") {
        $nset = 1;
    }

    $next = (($nset) * 10 + 1);
    $prev = (($nset - 2) * 10 + 1);

    //	echo $total_page.":::".$next."::::".$prev."<br>";
    if ($total) {
        $prev_mark = ($page >= 2) ? "<a href='".$HTTP_URL."?nset=".($nset)."&page=".($page - 1)."$add_query' ><img src='/image/icon_pre.gif' border=0 align=absmiddle></a> &nbsp;&nbsp;"
                : "";
        $prev_mark .= ($page == -9) ? "<a href='".$HTTP_URL."?nset=".($nset - 1)."&page=".(($nset - 2) * 10 + 1)."$add_query' ><img src='/image/icon_tenpre.gif' border=0 align=absmiddle></a> &nbsp;&nbsp;"
                : "";
        $next_mark = ($total_page > 1) ? "&nbsp;&nbsp;<a href='".$HTTP_URL."?nset=".($nset)."&page=".($nset + 1)."$add_query' ><img src='/image/icon_next.gif' border=0 align=absmiddle></a>"
                : "";
        $next_mark .= ($total_page > 10) ? "&nbsp;&nbsp;<a href='".$HTTP_URL."?nset=".($nset + 1)."&page=".($nset * 10 + 1)."$add_query' ><img src='/image/icon_tennext.gif' border=0 align=absmiddle></a>"
                : "";
    }

    $page_string2 = $prev_mark;

    //	for ($i = $page - 10; $i <= $page + 10; $i++)

    for ($i = ($nset - 1) * 10 + 1; $i <= (($nset - 1) * 10 + 10); $i++) {
        if ($i > 0) {
            if ($i <= $total_page) {
                if ($i != $page) {
                    if ($i != (($nset - 1) * 10 + 1)) {
                        $page_string2 = $page_string2.(" <div class='w100' style='width:22px;height:19px;font-weight:bold;color:#292929;border:1px solid #d1d1d1'><a href='".$HTTP_URL."?nset=$nset&page=$i$add_query' >$i</a></div> ");
                    } else {
                        $page_string2 = $page_string2.(" <div class='w100' style='width:22px;height:19px;font-weight:bold;color:#292929;border:1px solid #d1d1d1'><a href='".$HTTP_URL."?nset=$nset&page=$i$add_query'>$i</a></div> ");
                    }
                } else {
                    if ($i != (($nset - 1) * 10 + 1)) {
                        $page_string2 = $page_string2.("<div class='w100' style='width:22px;height:19px;font-weight:bold;color:#2eb6b3;border:1px solid #2eb6b3;'>$i</div> ");
                    } else {
                        $page_string2 = $page_string2.("<div class='w100' style='width:22px;height:19px;font-weight:bold;FF:#2eb6b3;border:1px solid #2eb6b3;'>$i</div> ");
                    }
                }
            }
        }
    }
    if ($nset < (floor($total_page / 10) + 1)) {
        $last_page_string = "<b style='color:gray'>...</b> <a href='".$HTTP_URL."?nset=".(floor($total_page / 10) + 1)."&page=$total_page$add_query' style='font-weight:bold;color:gray' >$total_page</a> ";
    }
    $page_string2 = $page_string2.$last_page_string.$next_mark;

    return $page_string2;
}

function product_page_barx($total, $page, $max, $listtype = "", $search_str = "", $link_URL = "plist.php")
{
    if ($listtype == "search") {
        return "";
    }

    $page_string;
    global $cid, $depth;

    if ($total % $max > 0) {
        $total_page = floor($total / $max) + 1;
    } else {
        $total_page = floor($total / $max);
    }

    $next = $page + 1;
    $prev = $page - 1;

    if ($total) {
        $prev_mark = ($prev > 0) ? "<a href='$link_URL?page=$page&cid=$cid&depth=$depth&listtype=$listtype'><img src='/img/btn_pre.gif' border=0mg src='/img/btn_pre.gif' border=0mg src='/img/btn_pre.gif' border=0mg src='/img/btn_pre.gif' border=0mg src='/img/btn_pre.gif' border=0mg src='/img/btn_pre.gif' border=0mg src='/img/btn_pre.gif' border=0 align=absmiddle></a> "
                : "<img src='/img/btn_pre_off.gif' border=0 align=absmiddle> ";
        $next_mark = ($next <= $total_page) ? "<a href='$link_URL?page=$next&cid=$cid&depth=$depth&listtype=$listtype'><img src='/img/btn_next.gif' border=0 align=absmiddle></a>"
                : " <img src='/img/btn_next_off.gif' border=0 align=absmiddle>";
    }

    $page_string = $prev_mark;

    for ($i = $page - 5; $i <= $page + 5; $i++) {
        if ($i > 0) {
            if ($i <= $total_page) {
                if ($i != $page) {
                    $page_string = $page_string.(" <a href=$link_URL?page=$i&cid=$cid&depth=$depth&listtype=$listtype> $i </a> | ");
                } else {
                    $page_string = $page_string.("<font color=#FF0000>$i</font>");
                }
            }
        }
    }

    $page_string = $page_string.$next_mark;

    return $page_string; //." <a href=plist.php?page=$i&cid=$cid&depth=$depth&listtype=all>view all</a>";
}
/*
  function sendMessageByStep($mc_code, $mail_info, $P=null){

  global $DOCUMENT_ROOT, $CART, $order, $layout_config, $order_details,$bank_name,$bank_number,$depositor,$admininfo,$admin_config, $shopcfg,$vb_info;
  global $slave_mdb;
  //$slave_mdb = new Database;

  //$fp = fopen($_SERVER["DOCUMENT_ROOT"] . '/data/cowell_data/_logs/KYH_TEST_' . date('Ymd') . '.log', 'a');
  //$fh = '---------- START  [' . date('Y-m-d H:i:s') . '] ----------' . chr(13);

  $domain = str_replace('www.','',$_SERVER['HTTP_HOST']);
  $sql = "select * from ".TBL_SHOP_SHOPINFO." where mall_domain = '{$domain}'"; //mall_domain = 'B'
  $slave_mdb->query($sql);
  $slave_mdb->fetch();

  if(empty($_SESSION["layout_config"][mall_data_root])){
  $mall_data_root = $slave_mdb->dt[mall_data_root];
  }else{
  $mall_data_root = $_SESSION["layout_config"][mall_data_root];
  }

  if(empty($_SESSION["layout_config"][mall_use_templete])){
  $mall_use_templete = $slave_mdb->dt[mall_use_templete];
  }else{
  $mall_use_templete = $_SESSION["layout_config"][mall_use_templete];
  }

  $sql = "select * from ".TBL_SHOP_MAILSEND_CONFIG." where mc_code = '".$mc_code."' ";
  $slave_mdb->query($sql);

  if($slave_mdb->total){

  $email_info = $slave_mdb->fetch();

  if($admininfo[admin_level] == 8){
  $cominfo = getcominfo2();
  }else{
  $cominfo = getcominfo();
  }//메일 발송 선택을 안하면 $cominfo 정보를 못불러오게 되서 sms 발송이 안되었음 그래서 여기로 옮겨옴 kbk 13/04/15

  if($email_info[mc_mail_usersend_yn] == "Y" || $email_info[mc_mail_adminsend_yn] == "Y"){//킴수현 11.8.3
  include_once($_SERVER["DOCUMENT_ROOT"]."/include/email.send.php");
  include_once($_SERVER["DOCUMENT_ROOT"]."/class/Template_.class.php");

  if(!file_exists($_SERVER["DOCUMENT_ROOT"]."".$mall_data_root."/templet/".$mall_use_templete."/mail/ms_mail_".$slave_mdb->dt[mc_code].".htm")){
  return;
  }

  $tpl = new Template_();
  $tpl->template_dir = $_SERVER["DOCUMENT_ROOT"]."".$mall_data_root."/templet/".$mall_use_templete."/mail";
  $tpl->compile_dir  = $DOCUMENT_ROOT.$mall_data_root."/compile_/".$mall_use_templete."/mail";

  $tpl->define('mail',"ms_mail_".$mc_code.".htm");

  if(is_array($CART)){
  $tpl->assign('carts', $CART);
  }

  if(is_array($order_details)){
  $tpl->assign('carts', $order_details);
  }

  if(is_array($order)){
  $tpl->assign($order);
  }
  if(is_array($mail_info)){
  $tpl->assign($mail_info);
  }
  if(is_array($cominfo)){
  $tpl->assign($cominfo);
  }

  $tpl->assign('bank_name',$bank_name);
  $tpl->assign('bank_number',$bank_number);
  $tpl->assign('depositor',$depositor);
  $tpl->assign('vb_info',$vb_info);
  $mc_mail_text = $tpl->fetch('mail');

  SendMail($mail_info, $email_info[mc_mail_title],$mc_mail_text,"",$email_info[mc_mail_adminsend_yn],$email_info[mc_mail_usersend_yn]);//,$slave_mdb->dt[mc_mail_usersend_yn] 추가 kbk 13/08/12

  }

  if(($email_info[mc_sms_usersend_yn] == "Y" || $email_info[mc_sms_adminsend_yn] == "Y" ) && $mail_info[mem_mobile]){//킴수현 11.8.3
  include_once ($_SERVER["DOCUMENT_ROOT"]."/class/sms.class");
  $s = new SMS();
  $s->send_phone = $cominfo[com_phone];
  $s->send_name = $cominfo[com_name];

  //$order_total_price = number_format($order[product_total_price] - $order[reserve_price] - $order[use_cupon_price] - round($order[member_sale_price]) + $order[delivery_total_price]) ;
  $order_total_price = number_format($order[payment_price]) ;

  $mc_sms_text = str_replace("{mem_name}",$mail_info[mem_name],$email_info[mc_sms_text]);
  $mc_sms_text = str_replace("{mem_id}",$mail_info[mem_id],$mc_sms_text);//추가 kbk 13/03/14
  //$mc_sms_text = str_replace("{_shopcfg[shop_name]}",$shopcfg["shop_name"],$mc_sms_text);//추가 kbk 13/03/14
  $mc_sms_text = str_replace("{shop_name}",$shopcfg["shop_name"],$mc_sms_text);//수정 kbk 13/07/22

  $mc_sms_text = str_replace("{invoice}",$mail_info[invoice],$mc_sms_text);//추가 kbk 13/03/14
  $mc_sms_text = str_replace("{pname}",$mail_info[pname],$mc_sms_text);//추가 kbk 13/03/14
  $mc_sms_text = str_replace("{quick}",$mail_info[quick],$mc_sms_text);//추가 kbk 13/03/14

  if(is_array($order)){
  $mc_sms_text = str_replace("{bank}",$order[bank],$mc_sms_text);

  $mc_sms_text = str_replace("{oid}",$order[oid],$mc_sms_text);

  $mc_sms_text = str_replace("{order_total_price}",$order_total_price,$mc_sms_text);
  }

  if($mail_info[vb_info]!=""){
  $mc_sms_text = str_replace("{vb_info}",$mail_info[vb_info],$mc_sms_text);
  }

  if(is_array($order_details)){
  $mc_sms_text = str_replace("{carts.pname}",$order_details[0][pname],$mc_sms_text);

  if(count($order_details) > 1 ){
  $mc_sms_text = str_replace("{carts.options_text}",$order_details[0][options_text]." 외 ".(count($order_details)-1)."개",$mc_sms_text);
  }else{
  $mc_sms_text = str_replace("{carts.options_text}",$order_details[0][options_text],$mc_sms_text);
  }
  }

  $s->msg_code	=	$mail_info[msg_code];
  $s->dest_phone = str_replace("-","",$mail_info[mem_mobile]);
  $s->dest_name = $mail_info[mem_name];
  $s->msg_body =$mc_sms_text;
  $s->sendbyone($cominfo);
  //echo "sms 발송";
  //exit;
  if($email_info[mc_sms_adminsend_yn] == "Y"){

  $s->dest_phone = str_replace("-","",$cominfo[com_mobile]);
  $s->sendbyone($cominfo);

  }

  }
  }

  //$fh .= '---------------------  END  ---------------------' . chr(13) . chr(13);
  //fwrite($fp,$fh);
  //fclose($fp);
  }
 */

function sendMessageByStep($mc_code, $mail_info, $P = null)
{

    global $DOCUMENT_ROOT, $CART, $order, $layout_config, $order_details, $bank_name, $bank_number, $depositor, $admininfo, $admin_config, $shopcfg, $vb_info, $_LANGUAGE, $user_code;

    $slave_mdb = gVal('slave_mdb');

    $domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);
    $sql    = "select * from ".TBL_SHOP_SHOPINFO." where mall_domain = '{$domain}'"; //mall_domain = 'B'
    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    if (empty($_SESSION["layout_config"]['mall_data_root'])) {
        $mall_data_root = $slave_mdb->dt['mall_data_root'];
    } else {
        $mall_data_root = $_SESSION["layout_config"]['mall_data_root'];
    }

    if (empty($_SESSION["layout_config"]['mall_use_templete'])) {
        $mall_use_templete = $slave_mdb->dt['mall_use_templete'];
    } else {
        $mall_use_templete = $_SESSION["layout_config"]['mall_use_templete'];
    }

    //[S] 언어설정

    if (empty($_LANGUAGE)) {

        if (!empty($order_details)) {

            // 주문관련 메일은 mall_ix 기준으로 language 생성

            $order_mall_ix = $order_details[0]["mall_ix"];

            if ($order_mall_ix == "b71cdda7945b6579d7e6b874df66ccd1") {
                // CHINESS
                $language_code = "chinese";
            } else if ($order_mall_ix == "c53dcc8a261e2b02c5114a462eda59ee") {
                // ENGLISH
                $language_code = "english";
            } else {
                // 그 외는 KOREAN
                $language_code = "korean";
            }
        } else if (!empty($user_code)) {

            // user_code 가 있으면 common_member_detail 의 nationality 사용

            $sql         = "SELECT nationality FROM common_member_detail where code = '".$user_code."' LIMIT 1";
            $slave_mdb->query($sql);
            $slave_mdb->fetch();
            $nationality = $slave_mdb->dt["nationality"];

            if ($nationality == "C") {
                $language_code = "chinese";
            }if ($nationality == "E") {
                $language_code = "english";
            } else {
                $language_code = "korean";
            }
        }

        $include_language = $_SERVER["DOCUMENT_ROOT"].$mall_data_root."/_language/".$language_code."/common.php";

        if (!file_exists($include_language)) {
            // 해당 언어파일 없으면 한국어 파일 include
            $include_language = $_SERVER["DOCUMENT_ROOT"].$mall_data_root."/_language/korean/common.php";
        }

        include_once $include_language;

        if (empty($_SESSION["layout_config"]["front_language"])) {
            // front_language 가 설정 안되어 있으면 getExchangeNationPrice 함수 적용이 안됨
            $_SESSION["layout_config"]["front_language"] = $language_code;
        }
    }

    //[E] 언어설정

    $sql = "select * from ".TBL_SHOP_MAILSEND_CONFIG." where mc_code = '".$mc_code."' ";
    $slave_mdb->query($sql);

    if ($slave_mdb->total) {

        $email_info = $slave_mdb->fetch();

        if ($admininfo['admin_level'] == 8) {
            $cominfo = getcominfo2();
        } else {
            $cominfo = getcominfo();
        }//메일 발송 선택을 안하면 $cominfo 정보를 못불러오게 되서 sms 발송이 안되었음 그래서 여기로 옮겨옴 kbk 13/04/15

        if ($email_info['mc_mail_usersend_yn'] == "Y" || $email_info['mc_mail_adminsend_yn'] == "Y") {//킴수현 11.8.3
            if (!file_exists($_SERVER["DOCUMENT_ROOT"]."".$mall_data_root."/templet/".$mall_use_templete."/mail/ms_mail_".$mc_code.".htm")) {
                return;
            }

            $tpl               = new Template_();
            $tpl->template_dir = $_SERVER["DOCUMENT_ROOT"]."".$mall_data_root."/templet/".$mall_use_templete."/mail";
            $tpl->compile_dir  = $DOCUMENT_ROOT.$mall_data_root."/compile_/".$mall_use_templete."/mail";

            $tpl->define('mail', "ms_mail_".$mc_code.".htm");

            //[S] url 및 img path 치환
            $SITE_URL = (($_SERVER["HTTPS"] ?? '') == "on" ? "https://" : "http://").$_SERVER["HTTP_HOST"];
            if ($_SESSION["layout_config"]["mall_data_root"]) {
                $mall_data_root = $_SESSION["layout_config"]["mall_data_root"];
            } else if ($_SESSION["admininfo"]["mall_data_root"]) {
                $mall_data_root = $_SESSION["admininfo"]["mall_data_root"];
            } else {
                //
            }
            $IMG_PATH = $SITE_URL.$mall_data_root;
            //[E] url 및 img path 치환


            $LOGIN_URL = gVal('LOGIN_URL');
            $tpl->assign("SITE_URL", $SITE_URL);
            $tpl->assign("IMG_PATH", $IMG_PATH);
            $tpl->assign("LOGIN_URL", $LOGIN_URL);

            $tpl->assign("FACEBOOK", "https://www.facebook.com/AlandNews/");
            $tpl->assign("INSTA", "https://www.instagram.com/aland_store/");
            $tpl->assign("FACEBOOK_BEAUTY", "#");
            $tpl->assign("INSTA_BEAUTY", "https://www.instagram.com/aland_beauty/");
            $tpl->assign("GOOGLE", "https://play.google.com/store/apps/details?id=kr.co.aland");
            $tpl->assign("APPLE", "https://itunes.apple.com/kr/app/id1170012092?mt=8");
            $tpl->assign("QRCODE", $LOGIN_URL);

            if (is_array($mail_info)) {
                $tpl->assign($mail_info);
            }

            if (is_array($cominfo)) {
                $tpl->assign($cominfo);
            }

            if (is_array($CART)) {
                $order_details = $CART;
                //$tpl->assign('carts', $CART);
            }

            if (is_array($order_details)) {

                $oid = $order_details[0]["oid"];

                foreach ($order_details as $key => $val) {
                    if ($b_ori_company_id != $val["ori_company_id"]) {

                        $order_details[$key]["first_line"] = true;

                        $sql = "SELECT
										COUNT(od.od_ix) AS ori_cnt ,
										(SELECT IFNULL(delivery_dcprice,'0') AS delivery_dcprice
										FROM shop_order_delivery
										WHERE
											oid=od.oid
											AND ode_ix = od.ode_ix
										) as delivery_totalprice
									FROM shop_order_detail od
									WHERE
										ori_company_id = '".$val["ori_company_id"]."'
										AND od.oid = '".$oid."'
							";
                        $slave_mdb->query($sql);
                        $slave_mdb->fetch();

                        $order_details[$key]["ori_company_id_cnt"]  = $slave_mdb->dt["ori_cnt"];
                        $order_details[$key]["delivery_totalprice"] = $slave_mdb->dt["delivery_totalprice"];
                    } else {

                        $order_details[$key]["first_line"] = false;
                    }

                    // 총 배송배
                    $total_delivery_price += abs($order_details[$key]["delivery_totalprice"]);

                    // 할인금액 계산
                    $dc_price      = abs(($val["listprice"] - $val["pt_dcprice"]) * $val["pcnt"]);
                    $total_dcprice += abs($dc_price);

                    // 총 상품금액
                    $total_listprice += abs($val["listprice"]);

                    // 적립예정 금액
                    $expect_reserve += abs($val["reserve"]);

                    $b_ori_company_id = $val["ori_company_id"];

                    $sql  = "SELECT
									p.tax_price , d.* ,
									(SELECT exchange_rate FROM shop_order o WHERE o.oid = d.oid) AS exchange_rate
								FROM shop_order_detail_deliveryinfo d
								INNER JOIN shop_order_payment p
								ON d.oid = p.oid AND p.pay_type = 'G'
								WHERE d.oid = '".$oid."'
								ORDER BY d.odd_ix
								LIMIT 1
						";
                    $slave_mdb->query($sql);
                    $slave_mdb->fetch();
                    $info = $slave_mdb->dt;

                    $sql     = "SELECT *
								FROM shop_order_payment
								WHERE pay_type = 'G' AND method not in ('".ORDER_METHOD_CART_COUPON."','".ORDER_METHOD_RESERVE."') AND oid = '".$oid."'
								LIMIT 1
						";
                    $slave_mdb->query($sql);
                    $slave_mdb->fetch();
                    $account = $slave_mdb->dt;

                    $sql               = "SELECT payment_price
								FROM shop_order_payment
								WHERE pay_type = 'G' AND method='".ORDER_METHOD_CART_COUPON."' AND oid = '".$oid."'
								LIMIT 1
						";
                    $slave_mdb->query($sql);
                    $slave_mdb->fetch();
                    $cart_coupon_price = $slave_mdb->dt['payment_price'];
                }

                $tpl->assign('total_delivery_price', $total_delivery_price);
                $tpl->assign('total_dcprice', $total_dcprice);
                $tpl->assign('total_listprice', $total_listprice);
                $tpl->assign('expect_reserve', $expect_reserve);
                $tpl->assign('info', $info);
                $tpl->assign('account', $account);
                $tpl->assign('oid', $oid);
                $tpl->assign('carts', $order_details);
                $tpl->assign('exchange_rate', $info["exchange_rate"]);
                $tpl->assign('cart_coupon_price', $cart_coupon_price);
            }

            if (is_array($order)) {
                $tpl->assign($order);
            }

            $tpl->assign('bank_name', $bank_name);
            $tpl->assign('bank_number', $bank_number);
            $tpl->assign('depositor', $depositor);
            $tpl->assign('vb_info', $vb_info);
            $mc_mail_text = $tpl->fetch('mail');

            $mc_mail_title = str_replace("{oid}", $oid, $email_info['mc_mail_title']);

            @SendMail($mail_info, $mc_mail_title, $mc_mail_text, "", $email_info['mc_mail_adminsend_yn'], $email_info['mc_mail_usersend_yn']); //,$slave_mdb->dt[mc_mail_usersend_yn] 추가 kbk 13/08/12
        }

        if (($email_info['mc_sms_usersend_yn'] == "Y" || $email_info['mc_sms_adminsend_yn'] == "Y" || $email_info['mc_sms_usersend_yn'] == "K" || $email_info['mc_sms_adminsend_yn']
            == "K" ) && $mail_info['mem_mobile']) {//킴수현 11.8.3
            //$order_total_price = number_format($order[product_total_price] - $order[reserve_price] - $order[use_cupon_price] - round($order[member_sale_price]) + $order[delivery_total_price]) ;
            $order_total_price = number_format($order['payment_price']);

            $mc_sms_text = str_replace("{mem_name}", $mail_info['mem_name'], $email_info['mc_sms_text']);
            $mc_sms_text = str_replace("{mem_id}", $mail_info['mem_id'], $mc_sms_text); //추가 kbk 13/03/14
            //$mc_sms_text = str_replace("{_shopcfg[shop_name]}",$shopcfg["shop_name"],$mc_sms_text);//추가 kbk 13/03/14
            $mc_sms_text = str_replace("{shop_name}", $shopcfg["shop_name"], $mc_sms_text); //수정 kbk 13/07/22

            $mc_sms_text = str_replace("{invoice}", $mail_info['invoice'], $mc_sms_text); //추가 kbk 13/03/14
            $mc_sms_text = str_replace("{pname}", $mail_info['pname'], $mc_sms_text); //추가 kbk 13/03/14
            $mc_sms_text = str_replace("{quick}", $mail_info['quick'], $mc_sms_text); //추가 kbk 13/03/14

            if (is_array($order)) {
                $mc_sms_text = str_replace("{bank}", $order['bank'], $mc_sms_text);

                $mc_sms_text = str_replace("{oid}", $order['oid'], $mc_sms_text);

                $mc_sms_text = str_replace("{order_total_price}", $order_total_price, $mc_sms_text);
            }

            if ($mail_info['vb_info'] != "") {
                $mc_sms_text = str_replace("{vb_info}", $mail_info['vb_info'], $mc_sms_text);
            }

            $mc_sms_text = str_replace("{certification_num}", $mail_info['certification_num'], $mc_sms_text);

            if (is_array($order_details)) {
                $mc_sms_text = str_replace("{carts.pname}", $order_details[0]['pname'], $mc_sms_text);

                if (count($order_details) > 1) {
                    $mc_sms_text = str_replace("{carts.options_text}", $order_details[0]['options_text']." 외 ".(count($order_details) - 1)."개",
                        $mc_sms_text);
                } else {
                    $mc_sms_text = str_replace("{carts.options_text}", $order_details[0]['options_text'], $mc_sms_text);
                }
            }

            //카카오 알림톡 보내기
            if ($email_info['mc_sms_usersend_yn'] == "K" || $email_info['mc_sms_adminsend_yn'] == "K") {
                include_once($_SERVER["DOCUMENT_ROOT"]."/class/kakaoAlimTalk.class");
                //recipientNo			//(*)받는분 핸드폰번호
                //msgContent;			//(*)메시지 내용
                $datas = array();
                if ($email_info['mc_sms_usersend_yn'] == "K") {
                    array_push($datas,
                        array(
                        "recipientNo" => str_replace("-", "", $mail_info['mem_mobile'])
                        , "msgContent" => $mc_sms_text)
                    );
                }
                if ($email_info['mc_sms_adminsend_yn'] == "K" && $mail_info['com_mobile']) {
                    array_push($datas,
                        array(
                        "recipientNo" => str_replace("-", "", $mail_info['com_mobile'])
                        , "msgContent" => $mc_sms_text)
                    );
                }
                $kakaoAlimTalk = new KakaoAlimTalk($cominfo);
                $res           = $kakaoAlimTalk->send($mc_code, $datas);
                //print_r($res);
            } else {
                include_once ($_SERVER["DOCUMENT_ROOT"]."/class/sms.class");
                $s             = new SMS();
                $s->send_phone = $cominfo['com_phone'];
                $s->send_name  = $cominfo['com_name'];
                $s->msg_code   = $mail_info['msg_code'];
                $s->dest_phone = str_replace("-", "", $mail_info['mem_mobile']);
                $s->dest_name  = $mail_info['mem_name'];
                $s->msg_body   = $mc_sms_text;
                $s->sendbyone($cominfo);
                //echo "sms 발송";
                //exit;
                if ($email_info['mc_sms_adminsend_yn'] == "Y") {

                    $s->dest_phone = str_replace("-", "", $cominfo['com_mobile']);
                    $s->sendbyone($cominfo);
                }
            }
        }
    }

    //$fh .= '---------------------  END  ---------------------' . chr(13) . chr(13);
    //fwrite($fp,$fh);
    //fclose($fp);
}

function XsendMessageByStep($mc_code, $mail_info, $P = null)
{
    global $DOCUMENT_ROOT;
    global $slave_mdb;

    //$slave_mdb = new Database;

    $slave_mdb->query("select * from ".TBL_SHOP_MAILSEND_CONFIG." where mc_code = '".$mc_code."' ");

    if ($slave_mdb->total) {
        $slave_mdb->fetch();
        if ($slave_mdb->dt['mc_mail_usersend_yn'] == "Y") {
            include_once($_SERVER["DOCUMENT_ROOT"]."/include/email.send.php");
            SendMail($mail_info, $slave_mdb->dt['mc_mail_title'], $slave_mdb->dt['mc_mail_text'], "", $slave_mdb->dt['mc_mail_adminsend_yn']);
            //echo "메일발송";
        }

        if ($slave_mdb->dt['mc_sms_usersend_yn'] == "Y") {
            $cominfo = getcominfo();

            //print_r($cominfo);

            include($_SERVER["DOCUMENT_ROOT"]."/class/sms.class");
            $s             = new SMS();
            $s->send_phone = $cominfo['com_phone'];
            $s->send_name  = $cominfo['com_name'];

            $mc_sms_text = str_replace("{mem_name}", $mail_info['mem_name'], $slave_mdb->dt['mc_sms_text']);

            $s->dest_phone = str_replace("-", "", $mail_info['mem_mobile']);
            $s->dest_name  = $mail_info['mem_name'];
            $s->msg_body   = $mc_sms_text;

            $s->sendbyone($cominfo);
            //echo "sms 발송";

            if ($slave_mdb->dt['mc_sms_adminsend_yn'] == "Y") {
                $s->dest_phone = str_replace("-", "", $cominfo['com_phone']);
                $s->sendbyone($cominfo);

                //echo "sms 관리자 발송";
            }
        }
    }
}

function dictionary($word_basic, $language)
{
    $mdb = gVal('slave_db');

    if ($language == 'Japanese') {
        $language = 'japan';
    }
    $sql  = "select * from admin_dic where dic_type='WORD' and language_type='".$language."' and text_korea='".$word_basic."'";
    $mdb->query($sql);
    $mdb->fetch();
    $word = $mdb->dt['text_trans'] ?? '';

    if (!empty($word)) {
        $word = $mdb->dt['text_trans'];
    } else {
        $word = $word_basic;
    }

    return $word;
}

function subcategorysforgoodscount($cid, $depth = "1", $is_goods = false, $is_sale = false)
{
    global $slave_mdb; // = new Database;
    //$slave_mdb = new Database;
    /* if($depth == 1){
      $sql = "SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where depth in (2,3) and cid LIKE '".substr($cid,0,6)."%' and category_use = '1' order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5";
      //echo $sql;
      $slave_mdb->query($sql);
      }else{
      $sql = "SELECT *,".($depth+1)." FROM ".TBL_SHOP_CATEGORY_INFO." where depth in (".($depth+1).") and cid LIKE '".substr($cid,0,($depth+1)*3)."%' and category_use = '1' order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5";
      //echo $sql;
      $slave_mdb->query($sql);
      } */
    //echo $depth."<br>";

    if (!$depth) {
        $depth = 0;
    }
    if (is_mobile()) {
        $is_mobile_use_where = " and p.is_mobile_use in ('A','M')";
    } else {
        $is_mobile_use_where = " and p.is_mobile_use in ('A','W')";
    }
    if ($is_goods) {
        if ($is_sale) {
            $sql = "select cid, cname, depth, sum(goods_total) as goods_total from
							(SELECT c.*, sum(case when r.cid != '' then 1 else 0 end) as goods_total
							FROM ".TBL_SHOP_CATEGORY_INFO." c
							left join ".TBL_SHOP_PRODUCT_RELATION." r on c.cid = r.cid
							right join ".TBL_SHOP_PRODUCT." p on r.pid = p.id AND p.disp='1'
							right join ".TBL_SHOP_PRODUCT_OPTIONS." po on r.pid = po.pid and po.option_kind in ('x','x2','s2')
							where  c.cid LIKE '".substr($cid, 0, ($depth + 1) * 3)."%' and category_use = '1' ".$is_mobile_use_where."
							group by c.cid
							order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5
							) sc
							group by substr(cid,1,3)
							 "; // 조건절을 뺌 kbk 12/01/03 //,".($depth+1)." as r_depth 2012-10-29 신훈식 뺌
            //right join ".TBL_SHOP_PRODUCT." p on r.pid = p.id AND p.disp='1' 추가 kbk 13/07/22
        } else {
            $sql = "select cid, cname, depth, sum(goods_total) as goods_total from
							(SELECT c.*, sum(case when r.cid != '' then 1 else 0 end) as goods_total
							FROM ".TBL_SHOP_CATEGORY_INFO." c
							left join ".TBL_SHOP_PRODUCT_RELATION." r on c.cid = r.cid
							right join ".TBL_SHOP_PRODUCT." p on r.pid = p.id AND p.disp='1'
							where  c.cid LIKE '".substr($cid, 0, ($depth + 1) * 3)."%' and category_use = '1' ".$is_mobile_use_where."
							group by c.cid
							order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5
							) sc
							group by substr(cid,1,3)
							 "; // 조건절을 뺌 kbk 12/01/03 //,".($depth+1)." as r_depth 2012-10-29 신훈식 뺌
            //right join ".TBL_SHOP_PRODUCT." p on r.pid = p.id AND p.disp='1' 추가 kbk 13/07/22
        }
    } else {

        if ($_GET["b_ix"]) {
            $sql = "SELECT c.*, sum(case when r.cid != '' then 1 else 0 end) as goods_total
							FROM ".TBL_SHOP_CATEGORY_INFO." c
							left join ".TBL_SHOP_PRODUCT_RELATION." r on c.cid = r.cid
							right join ".TBL_SHOP_PRODUCT." p on r.pid = p.id AND p.disp='1'
							where  c.cid LIKE '".substr($cid, 0, ($depth + 1) * 3)."%' and category_use = '1' ".$is_mobile_use_where."
							and p.brand = '".$_GET["b_ix"]."'
							group by c.cid
							HAVING sum(case when r.cid != '' then 1 else 0 end) > 0
							order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5
							 "; // 조건절을 뺌 kbk 12/01/03 //,".($depth+1)." as r_depth 2012-10-29 신훈식 뺌
            // AND p.disp='1' 추가 kbk 13/07/22
        } else {
            $sql = "SELECT c.*, sum(case when r.cid != '' then 1 else 0 end) as goods_total
							FROM ".TBL_SHOP_CATEGORY_INFO." c
							left join ".TBL_SHOP_PRODUCT_RELATION." r on c.cid = r.cid
							right join ".TBL_SHOP_PRODUCT." p on r.pid = p.id AND p.disp='1'
							where c.depth in (".($depth + 1).") and c.cid LIKE '".substr($cid, 0, ($depth + 1) * 3)."%' and category_use = '1' ".$is_mobile_use_where."
							group by c.cid
							HAVING sum(case when r.cid != '' then 1 else 0 end) > 0
							order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5
							 "; // 조건절을 뺌 kbk 12/01/03 //,".($depth+1)." as r_depth 2012-10-29 신훈식 뺌
            //right join ".TBL_SHOP_PRODUCT." p on r.pid = p.id AND p.disp='1' 추가 kbk 13/07/22
        }
    }
    //echo nl2br($sql);
    $slave_mdb->query($sql);
    $categorys = $slave_mdb->fetchall();
    //print_r($categorys);
    return $categorys; //$slave_mdb->fetchall();
}

function subcategorys($cid, $depth = "")
{
    global $slave_mdb; // = new Database;
    //$slave_mdb = new Database;
    /* if($depth == 1){
      $sql = "SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where depth in (2,3) and cid LIKE '".substr($cid,0,6)."%' and category_use = '1' order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5";
      //echo $sql;
      $slave_mdb->query($sql);
      }else{
      $sql = "SELECT *,".($depth+1)." FROM ".TBL_SHOP_CATEGORY_INFO." where depth in (".($depth+1).") and cid LIKE '".substr($cid,0,($depth+1)*3)."%' and category_use = '1' order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5";
      //echo $sql;
      $slave_mdb->query($sql);
      } */
    //echo $depth."<br>";
    if ($depth == "") {
        $depth = 0;
    }

    // && 조건에서 || 로 조건 변경 => /goods_list.php?cid=000000000000000&depth=0 에서 카테고리 보이도록 처리
    if ($depth == "") { //substr($cid,0,3) == '000' 161122 한대철
        $where = "  c.depth = 0 "; //1=1
    } else {
        $where = "c.depth in (".($depth + 1).") and c.cid LIKE '".substr($cid, 0, ($depth + 1) * 3)."%'";
    }
    /*
      $sql = "SELECT *  FROM ".TBL_SHOP_CATEGORY_INFO." c
      where
      $where
      and category_use = '1'
      order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5";// 조건절을 뺌 kbk 12/01/03 //,".($depth+1)." as r_depth 2012-10-29 신훈식 뺌
     */
    $sql = "SELECT c.cid, c.cname, c.depth, sum(IF(sub_c.cid is null,0,1))  as subcategory_cnt
					FROM ".TBL_SHOP_CATEGORY_INFO." c
					left join ".TBL_SHOP_CATEGORY_INFO." sub_c on left(c.cid,3) = left(sub_c.cid,3) and sub_c.depth = ".($depth + 2)."
					where
					".$where."
					and c.category_use = '1'
					group by c.cid
					order by c.vlevel1, c.vlevel2, c.vlevel3, c.vlevel4, c.vlevel5";
    if ($_SERVER["REMOTE_ADDR"] == "221.151.188.11") {
        //	echo nl2br($sql);
    }
    //		echo nl2br($sql);
    $slave_mdb->query($sql);
    $categorys = $slave_mdb->fetchall();

    if (is_array($categorys)) {
        foreach ($categorys as $key => $val) {
            $categorys[$key]["cname"] = getGlobalTargetName($val["cname"], $val["global_cinfo"], 'cname');
        }
    }

    //print_r($categorys);
    return $categorys; //$slave_mdb->fetchall();
}

function category_design($cid)
{
    global $slave_mdb;
    //$slave_mdb = new Database;

    $sql = "SELECT * FROM shop_category_design
					where cid ='".$cid."'";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    $cname_style["on"]  = unserialize($slave_mdb->dt['cname_on_style']);
    $cname_style["off"] = unserialize($slave_mdb->dt['cname_style']);

    return $cname_style;
}

function get_cate_name($cid, $depth = 0)
{
    global $slave_mdb; // = new Database;

    $sql = "SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where cid like '".substr($cid, 0, 3 * ($depth + 1))."%' and depth='".$depth."' ";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();
    //echo nl2br($sql);

    $slave_mdb->dt["cname"] = getGlobalTargetName($slave_mdb->dt["cname"], $slave_mdb->dt["global_cinfo"], 'cname');

    return $slave_mdb->dt["cname"];
}

function get_this_categoryinfo($cid)
{
    global $slave_mdb; // = new Database;

    $sql        = "select * from ".TBL_SHOP_CATEGORY_INFO." where cid = '".$cid."'";
    $slave_mdb->query($sql);
    $data_array = $slave_mdb->fetchall();

    return $data_array;
}

function categorys()
{
    global $slave_mdb; // = new Database;
    $sql       = "SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where category_use = 1 and depth = 0 order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5";
    //echo $sql;
    //exit;
    $slave_mdb->query($sql);
    $categorys = $slave_mdb->fetchall();

    return $categorys;
}

// 상품 리스트 네비게이션 하위 select box 노출 되는곳에 사용
function navcategorys($cid = '', $depth = 0)
{
    global $slave_mdb;

    if ($depth == 0) {
        $where = '';
    } else {
        if ($cid) {
            $where = " and cid LIKE '".substr($cid, 0, ($depth) * 3)."%'";
        }
    }

    $sql = "SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where category_use = 1 and depth = ".$depth." $where order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5";

    $slave_mdb->query($sql);
    $categorys = $slave_mdb->fetchall();

    return $categorys;
}

function subcategorysCount($cid)
{
    global $slave_mdb;
    $slave_mdb->query("select a.id from shop_product a , shop_product_relation b where a.id = b.pid and b.cid = '".$cid."'");
    return $slave_mdb->total;
}

function getCardNm($card_no)
{
    if ($card_no == "100") {
        return "BC";
    } else if ($card_no == "200") {
        return "국민";
    } else if ($card_no == "300") {
        return "외환";
    } else if ($card_no == "400") {
        return "삼성";
    } else if ($card_no == "500") {
        return "LG";
    } else if ($card_no == "600") {
        return "신한";
    } else if ($card_no == "800") {
        return "현대";
    } else if ($card_no == "900") {
        return "롯데";
    }
}
if (!function_exists('ChangeDate')) {

    function ChangeDate($date = "", $format = "Y년m월d일")
    {
        if (empty($date)) {
            return "";
        } else {
            return date($format, mktime(0, 0, 0, substr($date, 4, 2), substr($date, 6, 2), substr($date, 0, 4)));
        }
    }
}

function CallHotCon($ucode, $oid, $pid, $event_id, $hotcon_id, $pcnt, $receive_mobile)
{

    $http   = new _Http;
    $Requrl = "http://public.heartcon.co.kr/lssend/lssend.hc";


    $http->setURL($Requrl);                              //요청 url
    $http->setParam("EVENT_ID", $event_id); // 고정
    $http->setParam("GOODS_ID", $hotcon_id);
    $http->setParam("ORDER_CNT", 1);
    $http->setParam("SMS_TYPE", "M");
    $http->setParam("RECEIVERMOBILE", str_replace("-", "", $receive_mobile));
    $http->setParam("USER_ID", $ucode);


    //echo "EVENT_ID=$event_id&GOODS_ID=$hotcon_id&ORDER_CNT=$pcnt&SMS_TYPE=M&RECEIVERMOBILE=".str_replace("-","",$receive_mobile)."&USER_ID=".$ucode."&UNQ_ID=".$oid."_".$pid."";
    for ($i = 1; $i <= $pcnt; $i++) {
        $http->setParam("UNQ_ID", $oid."_".$pid."_".$i);
        $send_result = $http->send("GET");
    }
    return $send_result;
    //exit;
}

function get_best_use_after()
{ // 오른쪽 베스트 인증샷
    global $slave_mdb, $sns_product_type;
    $product_type_txt = implode(",", $sns_product_type);
    $sql              = "select a.*, IFNULL(a.uf_valuation,0) as uf_valuation, b.sellprice from ".TBL_SHOP_BBS_USEAFTER." a left join ".TBL_SHOP_PRODUCT." b on a.pid=b.id where a.best=1 AND b.product_type IN (".$product_type_txt.") order by regdate desc limit 3";
    $slave_mdb->query($sql);
    $btotal           = $slave_mdb->total;
    if ($btotal == 0) {
        $sql        = "select a.*, IFNULL(a.uf_valuation,0) as uf_valuation, b.sellprice from ".TBL_SHOP_BBS_USEAFTER." a left join ".TBL_SHOP_PRODUCT." b on a.pid=b.id where b.product_type IN (".$product_type_txt.") order by regdate desc limit 3";
        $slave_mdb->query($sql);
        $best_after = $slave_mdb->fetchall();
    } else {
        $best_after = $slave_mdb->fetchall();
    }
    return $best_after;
}

function get_sp_coupon()
{ // 오른쪽 스페셜 쿠폰
    global $slave_mdb;
    $nowDate = date("Ymd");
    $sql     = "SELECT * FROM ".TBL_SHOP_SP_COUPON." WHERE disp=1 AND coupon_use_sdate <= {$nowDate} AND coupon_use_edate >= {$nowDate}";
    $slave_mdb->query($sql);
    $fetch   = $slave_mdb->fetchall();
    return $fetch;
}

function load_coupon_category($sel_cid = "")
{ // 쿠폰 지역 카테고리
    global $slave_mdb;
    $slave_mdb->query("SELECT * FROM ".TBL_SNS_CATEGORY_INFO." where depth in(0,1,2,3)  order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5");
    $fetch      = $slave_mdb->fetchall();
    $fetch_cnt  = count($fetch);
    $option_txt = "";
    for ($i = 0; $i < $fetch_cnt; $i++) {
        if ($fetch[$i]["cid"] == $sel_cid) $sel_txt    = "selected";
        else $sel_txt    = "";
        $option_txt .= "<option value='".$fetch[$i]["cid"]."' ".$sel_txt.">".$fetch[$i]["cname"]."</option>";
    }
    return $option_txt;
}

function load_coupon_category2($sel_cid, $sel_pid = "")
{ // 쿠폰 지역 카테고리 별 상품
    global $slave_mdb;
    $slave_mdb->query("SELECT p.* FROM (".TBL_SHOP_PRODUCT." p LEFT JOIN ".TBL_SNS_PRODUCT_RELATION." r ON p.id=r.pid LEFT JOIN ".TBL_SNS_PRODUCT_ETCINFO." e ON p.id=e.pid) INNER JOIN ".TBL_COMMON_COMPANY_DETAIL." ccd ON p.admin=ccd.company_id LEFT JOIN ".TBL_COMMON_SELLER_DELIVERY." csd ON ccd.company_id = csd.company_id WHERE p.product_type IN (4,5,6) AND r.cid='".$sel_cid."' ");
    $fetch      = $slave_mdb->fetchall();
    $fetch_cnt  = count($fetch);
    $option_txt = "";
    for ($i = 0; $i < $fetch_cnt; $i++) {
        if ($fetch[$i]["id"] == $sel_pid) $sel_txt    = "selected";
        else $sel_txt    = "";
        $option_txt .= "<option value='".$fetch[$i]["id"]."' ".$sel_txt.">".$fetch[$i]["pname"]."</option>";
    }
    return $option_txt;
}

function getDisplayProGoods($div_code)
{
    global $slave_mdb, $layout_config;
    include_once($_SERVER['DOCUMENT_ROOT'].'/admin/logstory/class/sharedmemory.class');
    $shmop           = new Shared("reserve_rule");
    $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]['mall_data_root']."/_shared/";
    $shmop->SetFilePath();
    $reserve_data    = $shmop->getObjectForKey("reserve_rule");
    $reserve_data    = unserialize(urldecode($reserve_data));

    if ($reserve_data['mileage_info_use'] == "Y") { // 개별상품 적립금 우선  적용 2013-07-17 이학봉
        if (UserSellingType() == "W") {
            if (UserProductPriceType() == 'L') {
                $reserve_sql = " ,case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' then floor(p.wholesale_price*(".$reserve_data['goods_mileage_rate']."/100)) else floor(p.wholesale_price*(p.wholesale_reserve_rate/100)) end as reserve,
					case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' then ".$reserve_data['goods_mileage_rate']." else p.wholesale_reserve_rate end as reserve_rate";
            } else {
                $reserve_sql = " ,case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' then floor(p.wholesale_sellprice*(".$reserve_data['goods_mileage_rate']."/100)) else floor(p.wholesale_sellprice*(p.wholesale_reserve_rate/100)) end as reserve,
					case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' then ".$reserve_data['goods_mileage_rate']." else p.wholesale_reserve_rate end as reserve_rate";
            }
        } else {
            if (UserProductPriceType() == 'P') {
                $reserve_sql = " ,case when p.reserve_yn = 'N' or p.reserve_yn = '' then floor(p.premiumprice*(".$reserve_data['goods_mileage_rate']."/100)) else floor(p.premiumprice*(p.reserve_rate/100)) end as reserve,
					case when p.reserve_yn = 'N' or p.reserve_yn = '' then ".$reserve_data['goods_mileage_rate']." else p.reserve_rate end as reserve_rate";
            } elseif (UserProductPriceType() == 'L') {
                $reserve_sql = " ,case when p.reserve_yn = 'N' or p.reserve_yn = '' then floor(p.listprice*(".$reserve_data['goods_mileage_rate']."/100)) else floor(p.listprice*(p.reserve_rate/100)) end as reserve,
					case when p.reserve_yn = 'N' or p.reserve_yn = '' then ".$reserve_data['goods_mileage_rate']." else p.reserve_rate end as reserve_rate";
            } else {
                $reserve_sql = " ,case when p.reserve_yn = 'N' or p.reserve_yn = '' then floor(p.sellprice*(".$reserve_data['goods_mileage_rate']."/100)) else floor(p.sellprice*(p.reserve_rate/100)) end as reserve,
					case when p.reserve_yn = 'N' or p.reserve_yn = '' then ".$reserve_data['goods_mileage_rate']." else p.reserve_rate end as reserve_rate";
            }
        }
    } elseif ($reserve_data['mileage_info_use'] == "P") { // 결제수단별 적립금 비율
        if (UserSellingType() == "W") {
            if (UserProductPriceType() == 'L') {
                $reserve_sql = " ,case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' then floor(p.wholesale_price*(".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]."/100)) else floor(p.wholesale_price*(p.wholesale_reserve_rate/100)) end as reserve,
					case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' ".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]." else p.wholesale_reserve_rate end as reserve_rate";
            } else {
                $reserve_sql = " ,case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' then floor(p.wholesale_sellprice*(".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]."/100)) else floor(p.wholesale_sellprice*(p.wholesale_reserve_rate/100)) end as reserve,
					case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' ".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]." else p.wholesale_reserve_rate end as reserve_rate";
            }
        } else {
            if (UserProductPriceType() == 'P') {
                $reserve_sql = " ,case when p.reserve_yn = 'N' or p.reserve_yn = '' then floor(p.premiumprice*(".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]."/100)) else floor(p.premiumprice*(p.reserve_rate/100)) end as reserve,
					case when p.reserve_yn = 'N' or p.reserve_yn = '' then ".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]." else p.reserve_rate end as reserve_rate";
            } elseif (UserProductPriceType() == 'L') {
                $reserve_sql = " ,case when p.reserve_yn = 'N' or p.reserve_yn = '' then floor(p.listprice*(".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]."/100)) else floor(p.listprice*(p.reserve_rate/100)) end as reserve,
					case when p.reserve_yn = 'N' or p.reserve_yn = '' then ".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]." else p.reserve_rate end as reserve_rate";
            } else {
                $reserve_sql = " ,case when p.reserve_yn = 'N' or p.reserve_yn = '' then floor(p.sellprice*(".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]."/100)) else floor(p.sellprice*(p.reserve_rate/100)) end as reserve,
					case when p.reserve_yn = 'N' or p.reserve_yn = '' then ".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]." else p.reserve_rate end as reserve_rate";
            }
        }
    } else {
        if (UserSellingType() == "W") { //기업회원일경우 도매가로 적립율 적용
            if (UserProductPriceType() == 'L') {
                $reserve_sql = " ,case when p.wholesale_reserve_yn = 'Y' then floor(p.wholesale_price*(p.wholesale_reserve_rate/100)) else 0 end as reserve,
					case when p.wholesale_reserve_yn = 'Y' then p.wholesale_reserve_rate else 0 end as reserve_rate";
            } else {
                $reserve_sql = " ,case when p.wholesale_reserve_yn = 'Y' then floor(p.wholesale_sellprice*(p.wholesale_reserve_rate/100)) else 0 end as reserve,
					case when p.wholesale_reserve_yn = 'Y' then p.wholesale_reserve_rate else 0 end as reserve_rate";
            }
        } else {
            if (UserProductPriceType() == 'P') {
                $reserve_sql = " ,case when p.reserve_yn = 'Y' then floor(p.premiumprice*(p.reserve_rate/100)) else 0 end as reserve,
					case when p.reserve_yn = 'Y' then p.reserve_rate else 0 end as reserve_rate";
            } elseif (UserProductPriceType() == 'L') {
                $reserve_sql = " ,case when p.reserve_yn = 'Y' then floor(p.listprice*(p.reserve_rate/100)) else 0 end as reserve,
					case when p.reserve_yn = 'Y' then p.reserve_rate else 0 end as reserve_rate";
            } else {
                $reserve_sql = " ,case when p.reserve_yn = 'Y' then floor(p.sellprice*(p.reserve_rate/100)) else 0 end as reserve,
					case when p.reserve_yn = 'Y' then p.reserve_rate else 0 end as reserve_rate";
            }
        }
    }
    //$now_date=date("Ymd");
    $now_date = time();
    $sql      = "SELECT pg.* , pd.div_code FROM shop_promotion_goods pg, shop_promotion_div pd
					where pd.div_code = '".$div_code."' and pg.div_ix = pd.div_ix and pg.disp ='1' and pg.pg_use_sdate <= '".$now_date."' and pg.pg_use_edate>='".$now_date."'
					ORDER BY div_ix asc ";
    //echo nl2br($sql);
    //return $sql;

    $slave_mdb->query($sql);
    $displayGoods = $slave_mdb->fetchall();
    //print_r($displayGoods);

    /**
     * 도매몰일때 도매가로 결제하도록 wholesale_price를 sellprice로 가져오기 bgh
     *
     * sellprice를 $select_price로 대체
     */
    if (UserSellingType() == 'W') {
        if (UserProductPriceType() == 'L') {
            $select_price = 'wholesale_price as listprice, wholesale_price as sellprice, sellprice AS ori_sellprice, 0 as sale_rate ,  (listprice-sellprice)/listprice*100 as b2c_sale_rate , pa.wholesale_free_delivery_yn as free_delivery_yn ';
        } else {
            $select_price = 'wholesale_price as listprice, wholesale_sellprice as sellprice, sellprice AS ori_sellprice, (wholesale_price-wholesale_sellprice)/wholesale_price*100 as sale_rate ,  (listprice-sellprice)/listprice*100 as b2c_sale_rate , pa.wholesale_free_delivery_yn as free_delivery_yn ';
        }
    } else {
        if (UserProductPriceType() == 'P') {
            $select_price = 'premiumprice as sellprice, listprice, (listprice-premiumprice)/listprice*100 as sale_rate , pa.free_delivery_yn as free_delivery_yn ';
        } elseif (UserProductPriceType() == 'L') {
            $select_price = 'listprice as sellprice, listprice, 0 as sale_rate , pa.free_delivery_yn as free_delivery_yn ';
        } else {
            $select_price = 'sellprice, listprice, (listprice-sellprice)/listprice*100 as sale_rate , pa.free_delivery_yn as free_delivery_yn ';
        }
    }

    if (is_mobile()) {
        $is_mobile_use_where = " and p.is_mobile_use in ('A','M')";
    } else {
        $is_mobile_use_where = " and p.is_mobile_use in ('A','W')";
    }
    for ($i = 0; $i < count($displayGoods); $i++) {
        if ($num > 0) $add_limit = " limit 0, $num";
        else $add_limit = "";
        switch ($displayGoods[$i]["display_type"]) {
            case ("0") : $goods_list_cnt = "5";
                break;
            case ("1") : $goods_list_cnt = "4";
                break;
            case ("2") : $goods_list_cnt = "3";
                break;
            case ("3") : $goods_list_cnt = "4";
                break;
            case ("4") : $goods_list_cnt = "7";
                break;
            case ("5") : $goods_list_cnt = "4";
                break;
            case ("6") : $goods_list_cnt = "6";
                break;
            default : $goods_list_cnt = "4";
                break;
        }

        $sql                       = "SELECT ".$goods_list_cnt." AS goods_list_cnt,p.id,p.pname, p.listprice, $select_price,  p.stock, p.stock_use_yn, p.brand_name, p.shotinfo, icons $reserve_sql
					FROM ".TBL_SHOP_PRODUCT." p
					left join shop_product_addinfo pa on p.id=pa.pid
					, shop_promotion_product_relation erp
					where p.id = erp.pid  and erp.pg_ix = '".$displayGoods[$i]['pg_ix']."' and p.disp = 1 and p.state = 1 and product_type != 2 ".$is_mobile_use_where."
					order by erp.vieworder asc
					".$add_limit;
        //and p.brand = b.b_ix 삭제 ,,".TBL_SHOP_BRAND." b 삭제 , b.brand_name --> p.brand_name 변경
        $slave_mdb->query($sql);
        $displayGoods[$i]['goods'] = $slave_mdb->fetchall();

        $cssML   = 'ml'.$displayGoods[$i]['display_type'];
        $cssType = 'type'.$displayGoods[$i]['display_type'];
        $imgType = 'ms';
        $noImg   = 'noimg_'.$imgType.'.gif';

        if (is_array($displayGoods[$i]['goods'])) {
            $cnt = 0;
            foreach ($displayGoods[$i]['goods'] as $key => $sub_array) {
                //if($key %
                $select_              = array("icons_list" => explode(";", $sub_array['icons']));
                array_insert($sub_array, 14, $select_);
                $sub_array['cssML']   = $cssML;
                $sub_array['cssType'] = $cssType;
                $sub_array['noImg']   = $noImg;
                $sub_array['imgType'] = $imgType;
                if ($displayGoods[$i]['display_type'] == 2) {
                    $sub_array['imgType'] = 'm';
                } elseif ($displayGoods[$i]['display_type'] == 4) {
                    if ($cnt % 7 == 0) {
                        $sub_array['addHTML1'] = '<div style="clear:both;float:left;padding:0 0 0 0px;">';
                        $sub_array['addHTML2'] = '</div><div class="type4-2">';
                        $sub_array['imgType']  = 'b';
                        $sub_array['noImg']    = 'noimg_'.$sub_array['imgType'].'.gif';
                    } else {
                        $sub_array['cssType'] = 'type4-1';
                    }
                } elseif ($displayGoods[$i]['display_type'] == 6) {
                    if ($cnt % 6 < 2) {
                        //$sub_array['addHTML1']	= '</div><div class="good_names" style="width:420px;padding:0 10px;">';
                        //$sub_array['addHTML2']	= '</div><div style="float:left;width:50%;">';
                        $sub_array['imgType'] = 'b';
                        $sub_array['noImg']   = 'noimg_'.$sub_array['imgType'].'.gif';
                    } else {
                        $sub_array['cssML']   = 'ml6-1';
                        $sub_array['cssType'] = 'type6-1';
                    }
                }
                $displayGoods[$i]['goods'][$key] = $sub_array;
                $cnt++;
            }
        }
    }
    return $displayGoods;
}

function getDisplayProGoods_event($div)
{
    global $slave_mdb, $layout_config;
    include_once($_SERVER['DOCUMENT_ROOT'].'/admin/logstory/class/sharedmemory.class');
    $shmop           = new Shared("reserve_rule");
    $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]['mall_data_root']."/_shared/";
    $shmop->SetFilePath();
    $reserve_data    = $shmop->getObjectForKey("reserve_rule");
    $reserve_data    = unserialize(urldecode($reserve_data));

    if ($reserve_data['reserve_use_yn'] == "Y") {
        $reserve_sql = " ,case when p.reserve_yn = 'N' then round(sellprice*(".$reserve_data['goods_reserve_rate']."/100)) else round(sellprice*(reserve_rate/100)) end as reserve";
    }
    $now_date = date("Ymd");
    $sql      = "SELECT * FROM shop_promotion_goods where div_ix='".$div."' and disp ='1' AND (pg_use_sdate<='".mktime(0, 0, 0, date('m'), date('d'),
            date('Y'))."' AND pg_use_edate>='".mktime(0, 0, 0, date('m'), date('d'), date('Y'))."') ORDER BY pg_ix asc ";
    //echo $sql;
    //return $sql;

    $slave_mdb->query($sql);
    $displayGoods = $slave_mdb->fetchall();

    /**
     * 도매몰일때 도매가로 결제하도록 wholesale_price를 sellprice로 가져오기 bgh
     *
     * sellprice를 $select_price로 대체
     */
    if ($_SESSION['layout_config']['mall_type'] == 'BW') {
        $select_price = 'p.wholesale_price as listprice, p.wholesale_sellprice as sellprice, p.sellprice AS ori_sellprice';
    } else {
        $select_price = 'p.sellprice, p.listprice';
    }

    if (is_mobile()) {
        $is_mobile_use_where = " and p.is_mobile_use in ('A','M')";
    } else {
        $is_mobile_use_where = " and p.is_mobile_use in ('A','W')";
    }

    for ($i = 0; $i < count($displayGoods); $i++) {
        /* if($num>0) $add_limit=" limit 0, $num";
          else $add_limit=""; */
        switch ($displayGoods[$i]["display_type"]) {
            case ("0") : $goods_list_cnt = "5";
                break;
            case ("1") : $goods_list_cnt = "4";
                break;
            case ("2") : $goods_list_cnt = "3";
                break;
            case ("3") : $goods_list_cnt = "4";
                break;
            case ("4") : $goods_list_cnt = "7";
                break;
            case ("5") : $goods_list_cnt = "4";
                break;
            case ("6") : $goods_list_cnt = "6";
                break;
            default : $goods_list_cnt = "4";
                break;
        }
        //판매기간 설정 조건 추가 2014-02-04 이학봉(조건추가하면서 쿼리 라인 정리 도저히 알아보기 힘듭니다.)
        $sql                       = "SELECT
						".$goods_list_cnt." AS goods_list_cnt,
						p.id,p.pname,
						p.listprice,
						$select_price,
						p.stock,
						p.stock_use_yn,
						p.brand_name,
						p.shotinfo,
						p.is_sell_date,
						p.sell_priod_sdate,
						p.sell_priod_edate,
						icons $reserve_sql
					FROM
						".TBL_SHOP_PRODUCT." p,
						shop_promotion_product_relation erp
					where
						p.id = erp.pid  and erp.pg_ix = '".$displayGoods[$i]['pg_ix']."'
						and if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')
						and p.disp = 1
						and p.state = 1
						and product_type != 2 ".$is_mobile_use_where."
						order by erp.vieworder asc
						".$add_limit;
        //and p.brand = b.b_ix 삭제 ,,".TBL_SHOP_BRAND." b 삭제 , b.brand_name --> p.brand_name 변경
        $slave_mdb->query($sql);
        $displayGoods[$i]['goods'] = $slave_mdb->fetchall();

        $cssML   = 'ml'.$displayGoods[$i]['display_type'];
        $cssType = 'type'.$displayGoods[$i]['display_type'];
        $imgType = 'ms';
        $noImg   = 'noimg_'.$imgType.'.gif';

        if (is_array($displayGoods[$i]['goods'])) {
            $cnt = 0;
            foreach ($displayGoods[$i]['goods'] as $key => $sub_array) {
                //if($key %
                $select_              = array("icons_list" => explode(";", $sub_array['icons']));
                array_insert($sub_array, 14, $select_);
                $sub_array['cssML']   = $cssML;
                $sub_array['cssType'] = $cssType;
                $sub_array['noImg']   = $noImg;
                $sub_array['imgType'] = $imgType;
                if ($displayGoods[$i]['display_type'] == 2) {
                    $sub_array['imgType'] = 'm';
                } elseif ($displayGoods[$i]['display_type'] == 4) {
                    if ($cnt % 7 == 0) {
                        $sub_array['addHTML1'] = '<div style="clear:both;float:left;padding:0 0 0 0px;">';
                        $sub_array['addHTML2'] = '</div><div class="type4-2">';
                        $sub_array['imgType']  = 'b';
                        $sub_array['noImg']    = 'noimg_'.$sub_array['imgType'].'.gif';
                    } else {
                        $sub_array['cssType'] = 'type4-1';
                    }
                } elseif ($displayGoods[$i]['display_type'] == 6) {
                    if ($cnt % 6 < 2) {
                        //$sub_array['addHTML1']	= '</div><div class="good_names" style="width:420px;padding:0 10px;">';
                        //$sub_array['addHTML2']	= '</div><div style="float:left;width:50%;">';
                        $sub_array['imgType'] = 'b';
                        $sub_array['noImg']   = 'noimg_'.$sub_array['imgType'].'.gif';
                    } else {
                        $sub_array['cssML']   = 'ml6-1';
                        $sub_array['cssType'] = 'type6-1';
                    }
                }
                $displayGoods[$i]['goods'][$key] = $sub_array;
                $cnt++;
            }
        }
    }
    return $displayGoods;
}

function getDisplayProMainGoods($cid, $depth = 0, $sub_display_code = "")
{
    global $slave_mdb, $layout_config, $shop_product_type;
    include_once($_SERVER['DOCUMENT_ROOT'].'/admin/logstory/class/sharedmemory.class');
    $shmop           = new Shared("reserve_rule");
    $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]['mall_data_root']."/_shared/";
    $shmop->SetFilePath();
    $reserve_data    = $shmop->getObjectForKey("reserve_rule");
    $reserve_data    = unserialize(urldecode($reserve_data));

    if ($reserve_data['reserve_use_yn'] == "Y") {
        $reserve_sql = " ,case when p.reserve_yn = 'N' then round(sellprice*(".$reserve_data['goods_reserve_rate']."/100)) else round(sellprice*(reserve_rate/100)) end as reserve";
    }
    //$now_date=date("Ymd");
    $now_date = time(); //mktime(0,0,0,date("m"),date("d"),date("Y"));
    //$sql = "SELECT * FROM shop_promotion_goods where cid1 LIKE '".substr($cid1,0,($depth+1)*3)."%' and disp ='1' AND (pg_use_sdate<='".$now_date."' AND pg_use_edate>='".$now_date."') ORDER BY div_ix asc ";
    /*
      $sql="select cmg.*,cmpg.group_name, cmpg.group_code,cmpg.display_type,cmpg.product_cnt,cmpg.goods_display_type,cmpg.display_auto_type
      from shop_category_main_div cmd
      left join shop_category_main_goods cmg on cmd.div_ix=cmg.div_ix
      left join shop_category_main_product_group cmpg on cmg.cmg_ix=cmpg.cmg_ix
      where cmd.cid like '".substr($cid,0,($depth+1)*3)."%' and cmg.disp=1
      AND (cmg.cmg_use_sdate<='".$now_date."' AND cmg.cmg_use_edate>='".$now_date."') AND cmpg.use_yn='Y' ";
     */
    $sql      = "select cmg.*,cmpg.group_name, cmpg.group_code,cmpg.display_type,cmpg.product_cnt,cmpg.goods_display_type,cmpg.display_auto_type,cmpg.basic_display_yn
				from shop_category_main_div cmd
				left join shop_category_main_goods cmg on cmd.div_ix=cmg.div_ix
				left join shop_category_main_product_group cmpg on cmg.cmg_ix=cmpg.cmg_ix
				where cmd.cid = '".$cid."' and cmg.disp=1 and cmg.display_position = '".$sub_display_code."'
				AND (cmg.cmg_use_sdate<='".$now_date."' AND cmg.cmg_use_edate>='".$now_date."') AND cmpg.use_yn='Y' ";
    //echo nl2br($sql);
    //return $sql;

    $slave_mdb->query($sql);
    $displayGoods = $slave_mdb->fetchall();

    /**
     * 도매몰일때 도매가로 결제하도록 wholesale_price를 sellprice로 가져오기 bgh
     *
     * sellprice를 $select_price로 대체
     */
    if ($_SESSION['layout_config']['mall_type'] == 'BW') {
        $select_price = 'p.wholesale_price as listprice, p.wholesale_sellprice as sellprice, p.sellprice AS ori_sellprice';
    } else {
        $select_price = 'p.sellprice, p.listprice';
    }

    for ($i = 0; $i < count($displayGoods); $i++) {
        if ($displayGoods[$i]["product_cnt"] > 0) $add_limit = " limit 0,".$displayGoods[$i]["product_cnt"]." ";
        else $add_limit = "";
        switch ($displayGoods[$i]["display_type"]) {
            case ("0") : $goods_list_cnt = "5";
                break;
            case ("1") : $goods_list_cnt = "4";
                break;
            case ("2") : $goods_list_cnt = "3";
                break;
            case ("3") : $goods_list_cnt = "4";
                break;
            case ("4") : $goods_list_cnt = "7";
                break;
            case ("5") : $goods_list_cnt = "4";
                break;
            case ("6") : $goods_list_cnt = "6";
                break;
            default : $goods_list_cnt = "4";
                break;
        }
        //$sql = "SELECT ".$goods_list_cnt." AS goods_list_cnt,p.id,p.pname, p.listprice, p.sellprice,  p.stock, p.stock_use_yn, p.brand_name, p.shotinfo, icons $reserve_sql FROM ".TBL_SHOP_PRODUCT." p, shop_promotion_product_relation erp	where p.id = erp.pid  and erp.pg_ix = '".$displayGoods[$i][pg_ix]."' and p.disp = 1 and p.state = 1 and product_type != 2 order by erp.vieworder asc ".$add_limit;
        //$sql = "SELECT ".$goods_list_cnt." AS goods_list_cnt,p.id, p.pcode, p.shotinfo, p.pname, p.sellprice,  p.reserve, cmpr_ix, cmpr.vieworder, cmpr.group_code, p.brand_name, p.shotinfo, icons $reserve_sql FROM ".TBL_SHOP_PRODUCT." p, shop_category_main_product_relation cmpr, shop_category_main_product_group cmpg where cmpg.cmg_ix ='".$displayGoods[$i]["cmg_ix"]."' and cmpg.cmg_ix = cmpr.cmg_ix and p.id = cmpr.pid and cmpr.group_code = '".$displayGoods[$i]["group_code"]."' and cmpr.group_code = cmpg.group_code and p.disp = 1 order by cmpr.vieworder asc ".$add_limit;
        if (is_mobile()) {
            $is_mobile_use_where = " and p.is_mobile_use in ('A','M')";
        } else {
            $is_mobile_use_where = " and p.is_mobile_use in ('A','W')";
        }

        if ($displayGoods[$i]['goods_display_type'] == "A") {
            if (is_array($group_codes)) {
                $sql = "SELECT cid FROM shop_category_main_category_relation where group_code in (".implode(",", $group_codes).") AND cmg_ix='".$displayGoods[$i]["cmg_ix"]."' and insert_yn ='Y' ORDER BY vieworder ASC ";
            } else {
                $sql = "SELECT cid FROM shop_category_main_category_relation where group_code is not null AND cmg_ix='".$displayGoods[$i]["cmg_ix"]."' and insert_yn ='Y' ORDER BY vieworder ASC ";
            }
            $slave_mdb->query($sql);
            $cateRelation = $slave_mdb->fetchall();
            if (is_array($cateRelation)) {
                $cids  = "";
                $cidNo = 0;
                foreach ($cateRelation as $_keys => $_values) {
                    if ($cidNo == 0) $cids .= "'".$_values['cid']."'";
                    else $cids .= ",'".$_values['cid']."'";
                    $cidNo++;
                }
            }
            if ($displayGoods[$i]['display_auto_type']) {
                $orderBy = "ORDER BY p.".$displayGoods[$i]['display_auto_type']." ";
                if ($displayGoods[$i]['display_auto_type'] == "sellprice") $orderBy .= "ASC";
                else $orderBy .= "DESC";
            } else {
                $orderBy = "";
            }
            if ($cids != "") {
                $add_cids = " and r.cid in (".$cids.") ";
            } else {
                $add_cids = "";
            }
            //판매기간 설정 조건 추가 2014-02-04 이학봉(조건추가하면서 쿼리 라인 정리 도저히 알아보기 힘듭니다.)
            $sql = "SELECT
							".$goods_list_cnt." AS goods_list_cnt,
							p.id,
							p.pname,
							p.listprice,
							$select_price,
							p.stock,
							p.stock_use_yn,
							p.brand_name,
							p.shotinfo,
							p.is_sell_date,
							p.sell_priod_sdate,
							p.sell_priod_edate,
							icons $reserve_sql
						FROM
							".TBL_SHOP_PRODUCT." p,
							".TBL_SHOP_PRODUCT_RELATION." r
						where
							p.id = r.pid and p.disp = 1 and p.state = 1
							and if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')
							and product_type in (".implode(' , ', $shop_product_type).")
							".$add_cids." ".$is_mobile_use_where."
							$orderBy limit 0, ".($displayGoods[$i]['product_cnt'] ? $displayGoods[$i]['product_cnt'] : 5)." ";
        } else {
            // 메인페이지 분석 모드일때 각 상품에 조회수를 이미지 위에 노출하기위해서 통계데이타와 연동
            if ($_GET["viewtype"] == "analysis" || $_SESSION["viewtype"] == "analysis") {
                if (!$vdate) {
                    $vdate = date("Ymd");
                }

                //$sql = "SELECT ".$goods_list_cnt." AS goods_list_cnt,p.id,p.pname, p.listprice, p.sellprice,  p.stock, p.stock_use_yn, p.brand_name, p.shotinfo, erp.mpr_ix, IFNULL(mc.ncnt,0) as ncnt, icons $reserve_sql FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_MAIN_PRODUCT_RELATION." erp left join logstory_maingoods_click mc on erp.mpr_ix = mc.mpr_ix and mc.vdate = '".$vdate."' where p.id = erp.pid  and group_code = '".$displayGoods[$i][group_code]."' and p.disp = 1 and p.state = 1 and product_type != 2 order by erp.vieworder asc  limit ".($displayGoods[$i][product_cnt] ? $displayGoods[$i][product_cnt]:5)." ";
                //판매기간 설정 조건 추가 2014-02-04 이학봉(조건추가하면서 쿼리 라인 정리 도저히 알아보기 힘듭니다.)
                $sql = "SELECT
								".$goods_list_cnt." AS goods_list_cnt,
								p.id,
								p.pcode,
								p.shotinfo,
								p.pname,
								$select_price,
								p.reserve,
								p.is_sell_date,
								p.sell_priod_sdate,
								p.sell_priod_edate,
								cmpr_ix,
								cmpr.vieworder,
								cmpr.group_code,
								p.brand_name,
								p.shotinfo,
								icons $reserve_sql
							FROM
								".TBL_SHOP_PRODUCT." p,
								shop_category_main_product_relation cmpr,
								shop_category_main_product_group cmpg
							where
								cmpg.cmg_ix ='".$displayGoods[$i]["cmg_ix"]."'
								and if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')
								and cmpg.cmg_ix = cmpr.cmg_ix and p.id = cmpr.pid
								and cmpr.group_code = '".$displayGoods[$i]["group_code"]."'
								and cmpr.group_code = cmpg.group_code
								and p.disp = 1 ".$is_mobile_use_where."
								order by cmpr.vieworder asc
								".$add_limit;
            } else {
                //$sql = "SELECT ".$goods_list_cnt." AS goods_list_cnt,p.id,p.pname, p.listprice, p.sellprice,  p.stock, p.stock_use_yn, p.brand_name, p.shotinfo, erp.mpr_ix, icons $reserve_sql FROM ".TBL_SHOP_PRODUCT." p, ".TBL_SHOP_MAIN_PRODUCT_RELATION." erp where p.id = erp.pid  and group_code = '".$displayGoods[$i][group_code]."' and p.disp = 1 and p.state = 1 and product_type != 2 order by erp.vieworder asc  limit ".($displayGoods[$i][product_cnt] ? $displayGoods[$i][product_cnt]:5)." ";
                //판매기간 설정 조건 추가 2014-02-04 이학봉(조건추가하면서 쿼리 라인 정리 도저히 알아보기 힘듭니다.)
                $sql = "SELECT
								".$goods_list_cnt." AS goods_list_cnt,
								p.id, p.pcode,
								p.shotinfo, p.pname,
								$select_price,
								p.reserve, cmpr_ix,
								p.is_sell_date,
								p.sell_priod_sdate,
								p.sell_priod_edate,
								cmpr.vieworder, cmpr.group_code,
								p.brand_name, p.shotinfo,
								icons $reserve_sql
							FROM
								".TBL_SHOP_PRODUCT." p,
								shop_category_main_product_relation cmpr,
								shop_category_main_product_group cmpg
							where
								cmpg.cmg_ix ='".$displayGoods[$i]["cmg_ix"]."'
								and if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')
								and cmpg.cmg_ix = cmpr.cmg_ix and p.id = cmpr.pid
								and cmpr.group_code = '".$displayGoods[$i]["group_code"]."'
								and cmpr.group_code = cmpg.group_code
								and p.disp = 1 ".$is_mobile_use_where."
								order by cmpr.vieworder asc ".$add_limit;
            }
        }

        $slave_mdb->query($sql);
        $displayGoods[$i]['goods'] = $slave_mdb->fetchall();

        $cssML   = 'ml'.$displayGoods[$i]['display_type'];
        $cssType = 'type'.$displayGoods[$i]['display_type'];
        $imgType = 'ms';
        $noImg   = 'noimg_'.$imgType.'.gif';

        if (is_array($displayGoods[$i]['goods'])) {
            $cnt = 0;
            foreach ($displayGoods[$i]['goods'] as $key => $sub_array) {
                //if($key %
                $select_              = array("icons_list" => explode(";", $sub_array['icons']));
                array_insert($sub_array, 14, $select_);
                $sub_array['cssML']   = $cssML;
                $sub_array['cssType'] = $cssType;
                $sub_array['noImg']   = $noImg;
                $sub_array['imgType'] = $imgType;
                if ($displayGoods[$i]['display_type'] == 2) {
                    $sub_array['imgType'] = 'm';
                } elseif ($displayGoods[$i]['display_type'] == 4) {
                    if ($cnt % 7 == 0) {
                        $sub_array['addHTML1'] = '<div style="clear:both;float:left;padding:0 0 0 0px;">';
                        $sub_array['addHTML2'] = '</div><div class="type4-2">';
                        $sub_array['imgType']  = 'b';
                        $sub_array['noImg']    = 'noimg_'.$sub_array['imgType'].'.gif';
                    } else {
                        $sub_array['cssType'] = 'type4-1';
                    }
                } elseif ($displayGoods[$i]['display_type'] == 6) {
                    if ($cnt % 6 < 2) {
                        //$sub_array['addHTML1']	= '</div><div class="good_names" style="width:420px;padding:0 10px;">';
                        //$sub_array['addHTML2']	= '</div><div style="float:left;width:50%;">';
                        $sub_array['imgType'] = 'b';
                        $sub_array['noImg']   = 'noimg_'.$sub_array['imgType'].'.gif';
                    } else {
                        $sub_array['cssML']   = 'ml6-1';
                        $sub_array['cssType'] = 'type6-1';
                    }
                }
                $displayGoods[$i]['goods'][$key] = $sub_array;
                $cnt++;
            }
        }
    }
    return $displayGoods;
}
/* function header_brand_menu() {
  global $slave_mdb,$layout_config,$admin_config,$DOCUMENT_ROOT;

  $templet_src = $_SESSION["layout_config"][mall_templet_webpath];

  if($_SESSION["layout_config"][mall_type] == "B"){// 입점형
  $add_table=" left join ".TBL_SHOP_CATEGORY_INFO." mc on mb.cid = mc.cid";
  }else if($_SESSION["layout_config"][mall_type] == "F" || $_SESSION["layout_config"][mall_type] == "R"){ // 무료형 , 임대형
  $add_table="";
  }

  $sql="SELECT mb.* FROM shop_brand mb ".$add_table." where disp=1 order by regdate desc ";
  $slave_mdb->query($sql);
  $total=$slave_mdb->total;

  $fetch=$slave_mdb->fetchall();
  $len=count($fetch);

  if($total>0) {
  if($total<=7) $multiply_num=$total;
  else $multiply_num=7;
  $h_width01="width:".((120*$multiply_num)+4)."px;";
  $h_width02="width:".(120*$multiply_num)."px;";
  $h_width03="width:".((120*$multiply_num)-20)."px;";

  $txt='
  <div id="h_menu_brand_box" style="'.$h_width01.'display:none;">
  <div style="width:100%;float:right;">
  <div class="h_menu_brand_on"><img src="'.$templet_src.'/images/h_menu_brand_on.gif" alt="" align="absmiddle" style="cursor:pointer;" onClick="view_brand_menu(0)" /></div>
  <div class="h_menu_brand_on2" id="h_menu_brand_on_id" style="'.$h_width02.'">
  <ul class="hmb_ul">';
  for($i=0;$i<$len;$i++) {
  if($i==0 || $i>($multiply_num-1)) $li_class="hmb_li";
  else $li_class="hmb_li2";

  $b_ix=$fetch[$i]["b_ix"];
  $brand_name=$fetch[$i]["brand_name"];
  $cid=$fetch[$i]["cid"];

  if($_SESSION["layout_config"][mall_type] == "B"){// 입점형
  $click_txt=' onClick="location.href=\'/event/goods_brand.php?cid='.$cid.'&b_ix='.$b_ix.'\'" ';
  }else if($_SESSION["layout_config"][mall_type] == "F" || $_SESSION["layout_config"][mall_type] == "R"){ // 무료형 , 임대형
  $click_txt=' onClick="location.href=\'/event/goods_brand.php?b_ix='.$b_ix.'\'" ';
  }

  if(file_exists($DOCUMENT_ROOT."/data/basic/images/brand/".$b_ix."/brand_".$b_ix.".gif")){
  $img_txt='<img src="/data/basic/images/brand/'.$b_ix.'/brand_'.$b_ix.'.gif" alt="'.$brand_name.'" title="'.$brand_name.'" align="absmiddle" style="cursor:pointer;" '.$click_txt.' />';
  }else{
  $img_txt='<span style="cursor:pointer;" '.$click_txt.'>'.$brand_name.'</span>';
  }
  $txt.='
  <li class="'.$li_class.'">
  <table cellpadding="0" cellspacing="0" border="0" width="100%" style="table-layout:fixed;">
  <tr>
  <td align="center" class="hmb_td_right_border">'.$img_txt.'</td>
  </tr>
  </table>
  </li>';
  if($i>0 && $i%$multiply_num==($multiply_num-1) && $i<($total-1)) {
  $txt.='
  <li class="hmb_line_li" style="'.$h_width03.'">
  <div class="hmb_line_line"></div>
  </li>
  ';
  }
  }

  $txt.='
  </ul>
  <div class="hmb_close"><img src="'.$templet_src.'/images/btn_menu_brand_close.gif" alt="닫기" title="닫기" align="absmiddle" style="cursor:pointer;" onClick="view_brand_menu(0)" /></div>
  </div>
  </div>
  </div>
  ';
  }
  return $txt;
  } */

function header_brand_menu_total($num = 7)
{
    global $slave_mdb, $layout_config, $admin_config, $DOCUMENT_ROOT;

    $templet_src = $_SESSION["layout_config"]['mall_templet_webpath'];

    if ($_SESSION["layout_config"]['mall_type'] == "B") {// 입점형
        $add_table = " left join ".TBL_SHOP_CATEGORY_INFO." mc on mb.cid = mc.cid";
    } else if ($_SESSION["layout_config"]['mall_type'] == "F" || $_SESSION["layout_config"]['mall_type'] == "R") { // 무료형 , 임대형
        $add_table = "";
    }

    $sql   = "SELECT mb.* FROM shop_brand mb ".$add_table." where disp=1 order by regdate desc ";
    $slave_mdb->query($sql);
    $total = $slave_mdb->total;

    if ($total > 0) {
        if ($total <= $num) $multiply_num = $total;
        else $multiply_num = $num;
        $arr_return   = array(array("total" => $total, "multiply_num" => $multiply_num));
        return $arr_return;
    } else {
        return false;
    }
}

function header_brand_menu($sort = "")
{ //브랜드네임 sort방식 추가 12.05.03 bgh
    global $slave_mdb, $layout_config, $admin_config, $DOCUMENT_ROOT;

    $templet_src = $_SESSION["layout_config"]['mall_templet_webpath'];

    if ($_SESSION["layout_config"]['mall_type'] == "B") {// 입점형
        $add_table = " left join ".TBL_SHOP_CATEGORY_INFO." mc on mb.cid = mc.cid";
    } else if ($_SESSION["layout_config"]['mall_type'] == "F" || $_SESSION["layout_config"]['mall_type'] == "R") { // 무료형 , 임대형
        $add_table = "";
    }
    if ($sort == "brand_name") {
        $sql = "SELECT mb.* FROM shop_brand mb ".$add_table." where disp=1 order by brand_name asc";
    } else {
        $sql = "SELECT mb.* FROM shop_brand mb ".$add_table." where disp=1 order by regdate desc";
    }
    $slave_mdb->query($sql);

    $fetch = $slave_mdb->fetchall();
    return $fetch;
}

//브랜드 이름 가져오기

function get_brand_name($b_ix)
{

    global $slave_mdb, $layout_config, $admin_config, $DOCUMENT_ROOT;

    $sql        = "SELECT brand_name , global_binfo FROM shop_brand where b_ix='".$b_ix."' ";
    $slave_mdb->query($sql);
    $brand_name = $slave_mdb->fetch();

    $brand_name = getGlobalTargetName($slave_mdb->dt['brand_name'], $slave_mdb->dt['global_binfo'], 'brand_name');

    return $brand_name;
}

//브랜드 상단 이미지 가져오기
function get_brand_img2($b_ix, $brand_name, $cid = "")
{

    global $layout_config, $admin_config, $DOCUMENT_ROOT;

    if ($_SESSION["layout_config"]['mall_type'] == "B") {// 입점형
        $click_txt = ' onClick="location.href=\'/event/goods_brand.php?cid='.$cid.'&b_ix='.$b_ix.'\'" ';
    } else if ($_SESSION["layout_config"]['mall_type'] == "F" || $_SESSION["layout_config"]['mall_type'] == "R") { // 무료형 , 임대형
        $click_txt = ' onClick="location.href=\'/event/goods_brand.php?b_ix='.$b_ix.'\'" ';
    }
    if (file_exists($DOCUMENT_ROOT.$_SESSION["layout_config"]["mall_data_root"]."/images/brand/".$b_ix."/b_brand_".$b_ix.".gif")) {
        $img_txt = '<p class="brand_top_banner"><img src="'.$_SESSION["layout_config"]["mall_data_root"].'/images/brand/'.$b_ix.'/b_brand_'.$b_ix.'.gif" alt="'.$brand_name.'" title="'.$brand_name.'" align="absmiddle" style="cursor:pointer;" '.$click_txt.' /></p>';
    } else {

    }

    return $img_txt;
}

function get_brand_img($b_ix, $brand_name, $cid = "")
{

    global $layout_config, $admin_config, $DOCUMENT_ROOT;

    if ($_SESSION["layout_config"]['mall_type'] == "B") {// 입점형
        $click_txt = ' onClick="location.href=\'/event/goods_brand.php?cid='.$cid.'&b_ix='.$b_ix.'\'" ';
    } else if ($_SESSION["layout_config"]['mall_type'] == "F" || $_SESSION["layout_config"]['mall_type'] == "R") { // 무료형 , 임대형
        $click_txt = ' onClick="location.href=\'/event/goods_brand.php?b_ix='.$b_ix.'\'" ';
    }
    if (file_exists($DOCUMENT_ROOT.$_SESSION["layout_config"]["mall_data_root"]."/images/brand/".$b_ix."/brand_".$b_ix.".gif")) {
        $img_txt = '<img src="'.$_SESSION["layout_config"]["mall_data_root"].'/images/brand/'.$b_ix.'/brand_'.$b_ix.'.gif" alt="'.$brand_name.'" title="'.$brand_name.'" align="absmiddle" style="cursor:pointer;" '.$click_txt.' />';
    } else {
        $img_txt = '<span style="cursor:pointer;" '.$click_txt.'>'.$brand_name.'</span>';
    }

    return $img_txt;
}

function get_b_brand_img($size = 4, $cid = "")
{

    global $layout_config, $admin_config, $DOCUMENT_ROOT;
    global $slave_mdb;
    //$slave_mdb = new MySQl;

    $sql       = "select b.*, sum(order_cnt) as total_cnt from shop_brand b
		left join shop_product p on b.b_ix = p.brand
		where brand !=''  group by p.brand order by total_cnt desc
		limit 0, $size";
    $slave_mdb->query($sql);
    //echo $sql;
    $fetch_all = $slave_mdb->fetchall();
    $fetch_cnt = count($fetch_all);
    $fetch_arr = array();
    for ($i = 0; $i < $fetch_cnt; $i++) {
        if ($_SESSION["layout_config"]['mall_type'] == "B") {// 입점형
            $click_txt = ' onClick="location.href=\'/event/goods_brand.php?cid='.$cid.'&b_ix='.$fetch_all[$i]["b_ix"].'\'" ';
        } else if ($_SESSION["layout_config"]['mall_type'] == "F" || $_SESSION["layout_config"]['mall_type'] == "R") { // 무료형 , 임대형
            $click_txt = ' onClick="location.href=\'/event/goods_brand.php?b_ix='.$fetch_all[$i]["b_ix"].'\'" ';
        }
        if (file_exists($DOCUMENT_ROOT.$_SESSION["layout_config"]["mall_data_root"]."/images/brand/".$fetch_all[$i]["b_ix"]."/b_brand_".$fetch_all[$i]["b_ix"].".gif")) {
            $img_txt = '<img src="'.$_SESSION["layout_config"]["mall_data_root"].'/images/brand/'.$fetch_all[$i]["b_ix"].'/b_brand_'.$fetch_all[$i]["b_ix"].'.gif" alt="'.$fetch_all[$i]["brand_name"].'" title="'.$fetch_all[$i]["brand_name"].'" align="absmiddle"
				style="cursor:pointer;" '.$click_txt.' />';
        } else {
            $img_txt = '<span style="cursor:pointer;" '.$click_txt.'>'.$fetch_all[$i]["brand_name"].'</span>';
        }
        $fetch_arr[$i] = $img_txt;
    }
    return $fetch_arr;
    //return $slave_mdb->fetchall();

    if ($_SESSION["layout_config"]['mall_type'] == "B") {// 입점형
        $click_txt = ' onClick="location.href=\'/event/goods_brand.php?cid='.$cid.'&b_ix='.$b_ix.'\'" ';
    } else if ($_SESSION["layout_config"]['mall_type'] == "F" || $_SESSION["layout_config"]['mall_type'] == "R") { // 무료형 , 임대형
        $click_txt = ' onClick="location.href=\'/event/goods_brand.php?b_ix='.$b_ix.'\'" ';
    }
    if (file_exists($DOCUMENT_ROOT.$_SESSION["layout_config"]["mall_data_root"]."/images/brand/".$b_ix."/b_brand_".$b_ix.".gif")) {
        $img_txt = '<img src="'.$_SESSION["layout_config"]["mall_data_root"].'/images/brand/'.$b_ix.'/b_brand_'.$b_ix.'.gif" alt="'.$brand_name.'" title="'.$brand_name.'" align="absmiddle" style="cursor:pointer;" '.$click_txt.' />';
    } else {
        $img_txt = '<span style="cursor:pointer;" '.$click_txt.'>'.$brand_name.'</span>';
    }

    return $img_txt;
}

/**
 * 외환은행에서 USD 환율정보 가져오기 12.5.21 bgh
 * sharedmemory사용해서 지정된 시간동안 캐시데이터 사용
 *
 */
function scrapeExrate()
{
    global $layout_config;
    $cache_data['reg_date'] = 0;
    $cache_time             = 300; // 초

    include_once $_SERVER["DOCUMENT_ROOT"]."/admin/logstory/class/sharedmemory.class";

    $shmop           = new Shared("exrate_Usd");
    $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]['mall_data_root']."/_shared/";
    $shmop->SetFilePath();
    if ($shmop->getObjectForKey("exrate_Usd")) {
        $cache_data = $shmop->getObjectForKey("exrate_Usd");
        $cache_data = unserialize(urldecode($cache_data));
    }
    /**
     * 캐시데이터가 시간이 만료되지 않았을 경우 캐시된 데이터를 리턴
     */
    if ($cache_data['reg_date'] + $cache_time > time()) {
        return $cache_data;
        exit;
    } else {
        /**
         * xml으로 제공되지 않기때문에 우선 USD만 가져옴 bgh 12.05.02
         */
        include_once $_SERVER["DOCUMENT_ROOT"]."/class/Snoopy.class.php";
        $url     = "http://community.fxkeb.com/fxportal/jsp/RS/DEPLOY_EXRATE/fxrate_all.html";
        $snoopy  = new Snoopy;
        $snoopy->fetch($url);
        $results = $snoopy->results;

        //$list = array('USD','GBP','CAD','CHF','HKD','SEK','AUD','DKK','NOK','SAR','KWD','BHD','AED','JPY','THB','SGD','INR','MYR','IDR','CNY','NZD','EUR');
        preg_match_all("|>\[(.*)\]<|U", $results, $date_tmp, PREG_PATTERN_ORDER);
        $date = iconv("EUC-KR", "UTF-8", $date_tmp[1][0]);

        preg_match_all("|<td align=\"right\" class=\"table_04\">(.*)</td>|U", $results, $exrate_tmp, PREG_PATTERN_ORDER);
        $exrate = $exrate_tmp[1][5]; // USD 매매기준율

        $exrate_array['ex_date']  = str_replace("&nbsp;", "_", str_replace("기준", "", $date));
        $exrate_array['exrate']   = $exrate;
        $exrate_array['reg_date'] = time();

        $data            = urlencode(serialize($exrate_array));
        $shmop           = new Shared("exrate_Usd");
        $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$_SESSION["layout_config"]['mall_data_root']."/_shared/";
        $shmop->SetFilePath();
        $shmop->setObjectForKey($data, "exrate_Usd");

        return $exrate_array;
    }
}

/**
 * USD 환율 가져오기 bgh 12.05.02
 */
function getUsdExrate()
{
    $exrate_array = scrapeExrate();
    return $exrate_array;
}

function getUsdExrate_only()
{
    $exrate_array = scrapeExrate();
    return $exrate_array['exrate'];
}

function getUsdExDate_only()
{
    $exrate_array = scrapeExrate();
    return $exrate_array['ex_date'];
}

/**
 * 원화->usd변환 bgh 12.05.02
 */
function krwToUsd($kr_price)
{
    $exrate_array = scrapeExrate();
    if ($exrate_array['exrate'] > 0) {
        $result = round(($kr_price / $exrate_array['exrate']), 2);
    } else {
        $result = "환율정보 조회실패";
    }
    return $result;
}

//리셀러----------------------------------------------------------------------------------
function total_common_incentive($basic_return = "")
{
    global $user;
    global $slave_mdb;
    if ($user['code'] == "") {
        return "";
    }

    //$slave_mdb = new Database;
    $sql = "SELECT sum(incentive)as sum_incentive FROM reseller_incentive WHERE incentive_type ='1' and ac_ix !='' and rsl_code='".$user['code']."'";

    $slave_mdb->query($sql);
    $ptotal = $slave_mdb->dt['sum_incentive'];

    if ($ptotal == 0) {
        return $basic_return;
    } else {
        return $ptotal;
    }
}

function total_order_incentive($basic_return = "")
{
    global $user;
    global $slave_mdb;
    if ($user['code'] == "") {
        return "";
    }

    //$slave_mdb = new Database;
    $sql = "SELECT sum(incentive)as sum_incentive FROM reseller_incentive WHERE incentive_type ='2' and ac_ix !='' and rsl_code='".$user['code']."'";

    $slave_mdb->query($sql);
    $ptotal = $slave_mdb->dt['sum_incentive'];

    if ($ptotal == 0) {
        return $basic_return;
    } else {
        return $ptotal;
    }
}

function total_accounts_incentive($basic_return = "")
{
    global $user;
    global $slave_mdb;
    if ($user['code'] == "") {
        return "";
    }

    //$slave_mdb = new Database;
    $sql = "SELECT sum(ac_price)as sum_ac_price FROM reseller_accounts WHERE rsl_code='".$user['code']."'";

    $slave_mdb->query($sql);
    $ptotal = $slave_mdb->dt['sum_ac_price'];

    if ($ptotal == 0) {
        return $basic_return;
    } else {
        return $ptotal;
    }
}

//리셀러 ------------------------------------------------------------------------------------
function get_shared_memory($name)
{
    static $result = [];

    if (isset($result[$name]) === false) {
        $shmop           = new Shared($name);
        $shmop->filepath = MALL_DATA_PATH."/_shared/";
        $shmop->SetFilePath();
        $data            = $shmop->getObjectForKey($name);
        $result[$name]   = unserialize(urldecode($data));
    }

    return $result[$name];
}

function naver_checkout_script($ncid, $inflow, $button_key, $type, $color, $count, $enable)
{
    $script = "
			<script type='text/javascript' >
			//<![CDATA[

			if(!wcs_add) var wcs_add = {};
			wcs_add['wa'] = '".$ncid."';

			// 유입 추적 함수 호출
			wcs.inflow('".$inflow."');
			// 로그 수집 함수 호출
			wcs_do();

				nhn.CheckoutButton.apply({
					BUTTON_KEY: '".$button_key."', // 체크아웃에서 제공받은 버튼 인증 키 입력
					TYPE: '".$type."', // 버튼 모음 종류 설정
					COLOR: ".$color.", // 버튼 모음의 색 설정
					COUNT: ".$count.", // 버튼 개수 설정. 구매하기 버튼만 있으면(장바구니 페이지) 1, 찜하기 버튼도 있으면(상품 상세 페이지) 2를 입력.
					ENABLE: '".$enable."', // 품절 등의 이유로 버튼 모음을 비활성화할 때에는 'N' 입력
					BUY_BUTTON_HANDLER: buyNC,
					BUY_BUTTON_LINK_URL:'./nc/order_nc.php',
					WISHLIST_BUTTON_HANDLER:wishlistNC, // 찜하기 버튼 이벤트 Handler 함수 등록
					WISHLIST_BUTTON_LINK_URL:'./nc/zzim_nc.php', // 찜하기 팝업 링크 주소
					'':''
				});

			//]]></script>";

    return $script;
}

function naver_checkout_script2($ncid, $inflow, $button_key, $type, $color, $count, $enable)
{
    $script = "
			<script type='text/javascript' >
			//<![CDATA[

				if(!wcs_add) var wcs_add = {};
				wcs_add['wa'] = '".$ncid."';

				// 유입 추적 함수 호출
				wcs.inflow('".$inflow."');
				// 로그 수집 함수 호출
				wcs_do();

				nhn.CheckoutButton.apply({
					BUTTON_KEY: '".$button_key."', // 체크아웃에서 제공받은 버튼 인증 키 입력
					TYPE: '".$type."', // 버튼 모음 종류 설정
					COLOR: ".$color.", // 버튼 모음의 색 설정
					COUNT: ".$count.", // 버튼 개수 설정. 구매하기 버튼만 있으면(장바구니 페이지) 1, 찜하기 버튼도 있으면(상품 상세 페이지) 2를 입력.
					ENABLE: '".$enable."', // 품절 등의 이유로 버튼 모음을 비활성화할 때에는 'N' 입력
					BUY_BUTTON_HANDLER: buyNC,
					BUY_BUTTON_LINK_URL:'./nc/cart_nc.php',
					'':''
				});
			//]]></script>";

    return $script;
}

/**
  적립금 , 포인트 관련 함수 통합용 2013-06-19 이학봉 시작
  InsertReserveInfo('사용자키값',$oid="주문번호",$od_ix="주문상세코드",$r_id="적립금 키값",$reserve="적립금",$state="0:대기, 1:적립완료, 2:사용, 9:취소 ",$use_state="status=2(20:주문반품, 21:자동소멸, 22:기타, 23:주문취소, 24:반품취소 ) status=1(1:상품구매, 2:주문취소, 3:주문반품, 4:마케팅, 5:기타) ",$etc="메모",$reserve_type="point, mileage",$admininfo="")

  2014-03-19 처리상태별 처리일자 추가

  $state = 0 (적립대기) : waiting_date
  9 (적립취소) : cancel_date
  1 (적립완료) : complete_date
  2 (적립사용) : use_date

  regdate : 데이타 쌓인 일자( 변하지 않는 일자)

  2014-09-12 입금전취소일경우 사용된 적립금 반환해주는 프로세스 수정
  $ori_status='' 추가후  = 'IB' 일경우 사용완료된 적립금 반환해준다.
 * */
function InsertReserveInfo($uid, $oid = "", $od_ix = "", $r_id = "", $reserve = "", $state, $use_state, $etc = "", $reserve_type, $admininfo = "",
                           $ori_status = '')
{ //마일리지 , 포인트 적립 함수
    //해당 마일리지 포인트 적립 기능 사용 안함 JK160421
    return false;
}

//////////////////적립금 , 포인트 관련 함수 통합용 2013-06-19 이학봉 끝/////////////////////////////////
//마일리지 , 포인트 관련 함수 재통합 JK 2016-03-22 [S]
//정책 - 모든 마일리지 관련 데이터는 UPDATE 하지 않는다
//     - 적립 대기 라는 항목은 사용하지 않는다
//     - 상품 구매에 따른 적립은 마일리지 정책에 의해 구매확정, 배송완료 시점에 주문데이터에 등록된 적립 금액을 적립한다
//     - 주문 시 마일리지를 사용할 경우 사용마일리지 테이블, 마스터(로그) 테이블에 기록 하며, 적립 테이블을 기준으로 과거 적립 항목을 대상으로 하는 차감 remove 테이블에 기록한다
//     - 주문 시 마일리지를 사용 후 해당 주문이 취소(환불) 될 경우 사용한 마일리지 만큼 적립 테이블에 추가 하고 remove 테이블에는 복원 값을 insert 한다
//     - 관리자에서 수동으로 등록 할경우 적립, 사용 두가지 타입만 사용한다
//InsertMileageInfo($uid,$type,$mileage,$message,$state_type,$oid='',$od_ix='',$pid='',$ptprice='',$payprice='')
function InsertMileageInfo($mileage_data)
{
    global $slave_mdb, $master_db;

    //넘어온 배열의 key 는 변수명 value 값이 변수 값으로 변환 JK
    $uid        = $mileage_data['uid'];
    $type       = $mileage_data['type'];
    $mileage    = $mileage_data['mileage'];
    $message    = $mileage_data['message'];
    $state_type = $mileage_data['state_type'];
    $save_type  = $mileage_data['save_type'];

    //마일리지 관리 신규 테이블 테스트 중 JK160322
    if ($save_type == 'point') {
        $add_table    = "shop_add_point";
        $use_table    = "shop_use_point";
        $remove_table = "shop_remove_point";
        $log_table    = "shop_point_log";
    } else {
        $add_table    = "shop_add_mileage";
        $use_table    = "shop_use_mileage";
        $remove_table = "shop_remove_mileage";
        $log_table    = "shop_mileage_log";
    }
    if ($uid && $mileage > 0) {
        $sql = "select mg.selling_type from ".TBL_COMMON_MEMBER_DETAIL." cmd left join ".TBL_SHOP_GROUPINFO." mg on cmd.gp_ix = mg.gp_ix where cmd.code = '".$uid."' ";
        $slave_mdb->query($sql);
        $slave_mdb->fetch();

        if ($save_type == "point") {

            if ($slave_mdb->dt['selling_type'] == 'R') {
                $Shared_file = "b2c_point_rule";
                $com_type    = 'b2c';
            } else if ($slave_mdb->dt['selling_type'] == 'W') {
                $Shared_file = "b2b_point_rule";
                $com_type    = 'b2b';
            } else {
                $Shared_file = "b2c_point_rule"; //마일리지 설정값 파일명
                $com_type    = 'b2c';
            }
        } else {

            if ($slave_mdb->dt['selling_type'] == 'R') {
                $Shared_file = "b2c_mileage_rule"; //마일리지 설정값 파일명
                $com_type    = 'b2c';
            } else if ($slave_mdb->dt['selling_type'] == 'W') {
                $Shared_file = "b2b_mileage_rule";
                $com_type    = 'b2b';
            } else {
                $Shared_file = "b2c_mileage_rule"; //마일리지 설정값 파일명
                $com_type    = 'b2c';
            }
        }

        $reserve_data = getBasicSellerSetup($Shared_file);

        if (($reserve_data['mileage_info_use'] == "Y" || $reserve_data['mileage_info_use'] == "P" || $reserve_data['point_use_yn'] == "Y") && $uid) {
            if ($state_type == 'add') {

                //신규 마일리지 관리 관련 내용 시작  JK160322
                //적립 완료는 * 회원가입 , 배송완료 or 구매확정 , 취소에 의한 재적립 또는 관리자에 의한 수동 적립일때 사용 따라서 state 값이 1 로 접수되면 무조건 마일리지 적립 테이블에 기록
                //마일리지 적립 범위가 본사 상품만 사용이며, 주문에 의한 적립 타입일 경우 아래 조건을 통해 충족 여부를 판단 한다.
                if ($reserve_data['mileage_use_yn'] == 'N' && $pid) {
                    $sql = "select * from ".TBL_SHOP_PRODUCT." where id = '".$pid."' and admin = '".$_SESSION['shopcfg']['company_id']."'";
                    $slave_mdb->query($sql);

                    //적립하고자 하는 상품이 본사 상품이 아닐경우 마일리지 정책에 따라 프로세스를 종료 시킨다.
                    if (empty($slave_mdb->total)) {
                        return;
                    }
                }

                //적립 당시 소멸 예정일에 따른 소멸 예정 일자 등록
                $extinction_date = mktime(date("h"), date("i"), date("s"), date("m") + $reserve_data['cancel_month'], date("d"),
                    date("Y") + $reserve_data['cancel_year']);

                //* 적립 테이블과 로그 테이블에 내용 등록
                //이미 동일한 주문건의 적립이 존재 할경우 프로세스 진행 하지 않고 return
                if (!empty($oid) && !empty($od_ix)) {
                    $sql = "select * from ".$add_table." where oid = '".$oid."' and od_ix = '".$od_ix."'";
                    $slave_mdb->query($sql);
                    if (!empty($slave_mdb->total)) {
                        return;
                    }
                }

                $sql = "insert into ".$add_table."
								(uid,add_type,oid,od_ix,pid,am_mileage,am_state,reserve_type,auto_cancel,message,date,regdate,extinction_date)
							values
								('".$uid."','".$type."','".$oid."','".$od_ix."','".$pid."','".$mileage."','1','".$com_type."','N','".$message."',NOW(),NOW(),'".date('Y-m-d',
                        $extinction_date)."') ";
                $master_db->query($sql);

                $add_type_ix = $master_db->insert_id();

                $sql = "select total_mileage from ".$log_table." where uid = '".$uid."' order by ml_ix desc limit 1";
                $master_db->query($sql);
                $master_db->fetch();

                $total_mileage = $master_db->dt['total_mileage'];

                if (empty($total_mileage)) {
                    $total_mileage = 0;
                }

                $new_total_mileage = $total_mileage + $mileage;

                $sql = "insert into ".$log_table."
								(uid,log_type,type_ix,oid,od_ix,pid,ptprice,payprice,ml_mileage,total_mileage,ml_state,message,date,regdate)
							values
								('".$uid."','".$state_type."','".$add_type_ix."','".$oid."','".$od_ix."','".$pid."','".$ptprice."','".$payprice."','".$mileage."','".$new_total_mileage."','1','".$message."',NOW(),NOW()) ";
                $master_db->query($sql);

                if ($save_type == 'point') {
                    $user_sql = "update ".TBL_COMMON_USER." set point = '".$new_total_mileage."' where code = '".$uid."'";
                } else {
                    $user_sql = "update ".TBL_COMMON_USER." set mileage = '".$new_total_mileage."' where code = '".$uid."'";
                }

                $master_db->query($user_sql);

                //취소에 의한 적립 상태로 들어올 경우에는 사용된 마일리지를 추가 했기때문에 기존에 차감 마일리지에도 값을 추가 해줘야 함
                if ($type == '4') {
                    $sql        = "select * from ".$use_table." where oid = '".$oid."'"; //고객이 주문시 사용한 마일리지 정보를 가져온다
                    $master_db->query($sql);
                    $master_db->fetch();
                    $um_ix      = $master_db->dt['um_ix'];
                    $um_mileage = $master_db->dt['um_mileage'];

                    // 차감 테이블에 고객이 사용한 마일리지에 대한 Key 값존재 여부 확인 및 차감된 마일리지 합계 확인
                    $sql = "select * from ".$remove_table." where um_ix = '".$um_ix."' and rm_state = '1' group by um_ix";
                    $master_db->query($sql);
                    if ($master_db->total) {
                        $rm_data = $master_db->fetchall();
                        foreach ($rm_data as $data) {

                            $remove_data['am_ix']       = $data['am_ix'];
                            $remove_data['use_type_ix'] = $data['um_ix'];
                            $remove_data['rm_mileage']  = $data['rm_mileage'];
                            $remove_data['rm_message']  = '주문취소에 따른 차감데이터 복구';
                            $remove_data['uid']         = $uid;
                            $remove_data['rm_state']    = 2;
                            $remove_data['save_type']   = $save_type;
                            InsertMileageRemove($remove_data);
                        }
                    }
                }
            } else if ($state_type == 'use') {

                $sql = "insert into ".$use_table."
							(uid,use_type,oid,um_mileage,um_state,message,date,regdate)
						values
							('".$uid."','".$type."','".$oid."','".$mileage."','1','".$message."',NOW(),NOW()) ";
                $master_db->query($sql);

                $use_type_ix = $master_db->insert_id();

                $sql = "select total_mileage from ".$log_table." where uid = '".$uid."' order by ml_ix desc limit 1";
                $master_db->query($sql);
                $master_db->fetch();

                $total_mileage = $master_db->dt['total_mileage'];

                if (empty($total_mileage)) {
                    $total_mileage = 0;
                }

                $new_total_mileage = $total_mileage - $mileage;

                $sql = "insert into ".$log_table."
								(uid,log_type,type_ix,oid,od_ix,pid,ptprice,payprice,ml_mileage,total_mileage,ml_state,message,date,regdate)
							values
								('".$uid."','".$state_type."','".$use_type_ix."','".$oid."','".$od_ix."','".$pid."','".$ptprice."','".$payprice."','".$mileage."','".$new_total_mileage."','2','".$message."',NOW(),NOW()) ";
                $master_db->query($sql);

                if ($save_type == 'point') {
                    $user_sql = "update ".TBL_COMMON_USER." set point = '".$new_total_mileage."' where code = '".$uid."'";
                } else {
                    $user_sql = "update ".TBL_COMMON_USER." set mileage = '".$new_total_mileage."' where code = '".$uid."'";
                }
                $master_db->query($user_sql);

                // 마일리지 차감 프로세스 시작 (사용된 마일리지를 순차적 차감을 위한 기능)
                //			if($reserve_data[date_asc] == "A"){
                //				$order_by = " order by regdate ASC ";		//마일리지,포인트 사용순서 ->과거적립일순
                //			}else if($reserve_data[date_asc] == "D"){
                //				$order_by = " order by regdate DESC ";		//마일리지,포인트 사용순서 ->최근적립일순
                //			}

                $rm_message = "마일리지 사용에 따른 순차적 차감";

                //적립 완료된 마일리지 중 차감 대상이 되는 마일리지 정보 가져오기
                $sql = "select
								ifnull(sum(case when rm_state = '2' then -rm_mileage else rm_mileage end),0) as remove_mileage,
								am_ix
							from
								".$remove_table." where uid = '".$uid."'  group by am_ix order by am_ix ASC";
                $master_db->query($sql);

                if ($master_db->total) {
                    $remove_data     = $master_db->fetchall();
                    $balance_mileage = 0;
                    for ($i = 0; $i < count($remove_data); $i++) {
                        $sql = "select * from ".$add_table." where  am_ix = '".$remove_data[$i]['am_ix']."' and uid = '".$uid."' ";
                        $master_db->query($sql);
                        $master_db->fetch();

                        $am_mileage = $master_db->dt['am_mileage'];

                        if ($am_mileage > ($remove_data[$i]['remove_mileage'] + $mileage)) {
                            $rm_mileage = $mileage;
                            $am_ix      = $remove_data[$i]['am_ix'];
                            break;
                        } else if ($am_mileage == ($remove_data[$i]['remove_mileage'] + $mileage)) {
                            $rm_mileage = $mileage;
                            $am_ix      = $remove_data[$i]['am_ix'];
                            break;
                        } else if ($am_mileage < ($remove_data[$i]['remove_mileage'] + $mileage)) {
                            $rm_mileage = $am_mileage - $remove_data[$i]['remove_mileage'];
                            $am_ix      = $remove_data[$i]['am_ix'];

                            $balance_mileage = abs($rm_mileage - $mileage);
                            break;
                        }
                    }

                    if ($balance_mileage == 0) {
                        $remove_data['am_ix']       = $am_ix;
                        $remove_data['use_type_ix'] = $use_type_ix;
                        $remove_data['rm_mileage']  = $rm_mileage;
                        $remove_data['rm_message']  = $rm_message;
                        $remove_data['uid']         = $uid;
                        $remove_data['rm_state']    = 1;
                        $remove_data['save_type']   = $save_type;
                        InsertMileageRemove($remove_data);
                    }
                    if ($balance_mileage > 0) {
                        $sql    = "select * from ".$add_table." where  am_ix > '".$am_ix."' and uid = '".$uid."' ORDER BY am_ix ASC";
                        $master_db->query($sql);
                        $result = $master_db->fetchall();

                        foreach ($result as $data) {

                            if ($data['am_mileage'] >= $balance_mileage) {
                                $rm_mileage = $balance_mileage;
                                $am_ix      = $data['am_ix'];


                                $remove_data['am_ix']       = $am_ix;
                                $remove_data['use_type_ix'] = $use_type_ix;
                                $remove_data['rm_mileage']  = $rm_mileage;
                                $remove_data['rm_message']  = $rm_message;
                                $remove_data['uid']         = $uid;
                                $remove_data['rm_state']    = 1;
                                $remove_data['save_type']   = $save_type;
                                InsertMileageRemove($remove_data);

                                break;
                            } else {
                                $rm_mileage = $data['am_mileage'];
                                $am_ix      = $data['am_ix'];


                                $remove_data['am_ix']       = $am_ix;
                                $remove_data['use_type_ix'] = $use_type_ix;
                                $remove_data['rm_mileage']  = $rm_mileage;
                                $remove_data['rm_message']  = $rm_message;
                                $remove_data['uid']         = $uid;
                                $remove_data['rm_state']    = 1;
                                $remove_data['save_type']   = $save_type;
                                InsertMileageRemove($remove_data);

                                $balance_mileage = $balance_mileage - $data['am_mileage'];
                            }
                        }
                    }
                } else {
                    $balance_mileage = $mileage;
                    $sql             = "select * from ".$add_table." where  uid = '".$uid."' ORDER BY am_ix ASC";
                    $master_db->query($sql);
                    $result          = $master_db->fetchall();

                    foreach ($result as $data) {

                        if ($data['am_mileage'] >= $balance_mileage) {
                            $rm_mileage = $balance_mileage;
                            $am_ix      = $data['am_ix'];

                            $remove_data['am_ix']       = $am_ix;
                            $remove_data['use_type_ix'] = $use_type_ix;
                            $remove_data['rm_mileage']  = $rm_mileage;
                            $remove_data['rm_message']  = $rm_message;
                            $remove_data['uid']         = $uid;
                            $remove_data['rm_state']    = 1;
                            $remove_data['save_type']   = $save_type;
                            InsertMileageRemove($remove_data);
                            break;
                        } else {
                            $rm_mileage = $data['am_mileage'];
                            $am_ix      = $data['am_ix'];

                            $remove_data['am_ix']       = $am_ix;
                            $remove_data['use_type_ix'] = $use_type_ix;
                            $remove_data['rm_mileage']  = $rm_mileage;
                            $remove_data['rm_message']  = $rm_message;
                            $remove_data['uid']         = $uid;
                            $remove_data['rm_state']    = 1;
                            $remove_data['save_type']   = $save_type;
                            InsertMileageRemove($remove_data);

                            $balance_mileage = $balance_mileage - $data['am_mileage'];
                        }
                    }
                }
            }
        }
    }
}

function InsertMileageRemove($remove_data)
{
    global $slave_mdb, $master_db;

    extract($remove_data, EXTR_SKIP); //넘어온 배열의 key 는 변수명 value 값이 변수 값으로 변환 JK

    if ($save_type == 'point') {
        $remove_table = "shop_remove_point";
    } else {
        $remove_table = "shop_remove_mileage";
    }
    $sql = "insert into ".$remove_table."
				(am_ix,um_ix,rm_mileage,message,uid,rm_state,date,regdate)
			values
				('".$am_ix."','".$use_type_ix."','".$rm_mileage."','".$rm_message."','".$uid."','".$rm_state."',NOW(),NOW()) ";
    $master_db->query($sql);
}

/**
 * XSS CLEAN
 * 코드 이그나이터 함수로 대체 2018-09-11
 * 2013-06-20 bgh
 */
//function xss_clean($data)
//{
//    // Fix &entity\n;
//    $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
//    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
//    $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
//    $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
//
//    // Remove any attribute starting with "on" or xmlns
//    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
//
//    // Remove javascript: and vbscript: protocols
//    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu',
//        '$1=$2nojavascript...', $data);
//    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu',
//        '$1=$2novbscript...', $data);
//    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
//
//    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
//    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
//    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
//    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu',
//        '$1>', $data);
//
//    // Remove namespaced elements (we do not need them)
//    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
//
//    do {
//        // Remove really unwanted tags
//        $old_data = $data;
//        $data     = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i',
//            '', $data);
//    } while ($old_data !== $data);
//
//    // we are done...
//    return $data;
//}

function fetch_order_status_div($stype = "IR", $ctype = "CA", $return_key = "title", $return_val = "all")
{//프론트 사용자 주문 상태 변경 분류를 뿌려줌 kbk 13/06/26
    global $order_select_status_div;

    if (substr_count($_SERVER["PHP_SELF"], "/admin/") || substr_count($_SERVER["PHP_SELF"], "/cron/")) {
        $p_type = "A";
    } else {
        $p_type = "F";
    }

    $arr_status_div = $order_select_status_div[$p_type][$stype][$ctype];

    if ($return_val == "all") {
        $sel_array = array();
        foreach ($arr_status_div AS $k1 => $v1) {
            $arr_status_div2 = $arr_status_div[$k1];
            foreach ($arr_status_div2 AS $k2 => $v2) {
                if ($k2 == $return_key) array_push($sel_array, array($k1 => $v2));
            }
        }
        return $sel_array;
    } else {
        foreach ($arr_status_div AS $k1 => $v1) {
            $arr_status_div2 = $arr_status_div[$k1];
            foreach ($arr_status_div2 AS $k2 => $v2) {
                if ($k1 == $return_val && $k2 == $return_key) return $v2;
            }
        }
    }
}

function table_order_price_data_creation($oid, $od_ix, $company_id, $payment_status, $price_div, $expect_price, $payment_price, $msg = "",
                                         $reserve = 0, $point = 0, $saveprice = 0, $claim_group = 0)
{
    global $admininfo;
    global $slave_mdb, $master_db;
    //payment_status 결제상태 G : 정상, F : 환불 , A : 추가
    //price_div 상품 : P, 배송비 :D
    //expect_price 예정금액
    //payment_price 실결제금액
    // *** 주의사항 ***/
    // shop_order_price_history 쌓인 데이터로 shop_order_price 에 업데이트!
    // 입금 예정일시 payment_price 는 0 , 입금예정 -> 입금확인 변경시 expect_price 는 0으로 데이터를 넣어야함!!
    // 문의사항은  -> 홍진영 20130712

    $expect_price  = abs($expect_price);
    $payment_price = abs($payment_price);

    if ($price_div == "P") {
        $expect_product_price  = $expect_price;
        $product_price         = $payment_price;
        $expect_delivery_price = 0;
        $delivery_price        = 0;
    } else if ($price_div == "D") {
        $expect_product_price  = 0;
        $product_price         = 0;
        $expect_delivery_price = $expect_price;
        $delivery_price        = $payment_price;
    } else {
        $expect_product_price  = 0;
        $product_price         = 0;
        $expect_delivery_price = 0;
        $delivery_price        = 0;
    }

    //$slave_mdb = new Database;

    $master_db->query("insert into shop_order_price_history (oph_ix,oid,od_ix,company_id,payment_status,price_div,expect_price,payment_price,reserve,point,saveprice,claim_group,msg,charger,charger_ix,regdate) values('','$oid','$od_ix','$company_id','$payment_status','$price_div','$expect_price','$payment_price','$reserve','$point','$saveprice','$claim_group','$msg','".$admininfo['charger']."','".$admininfo['charger_ix']."',NOW())");

    $master_db->query("select * from shop_order_price where oid='".$oid."' and payment_status='".$payment_status."' ");

    if ($master_db->total) {
        $master_db->fetch();
        $op_ix = $master_db->dt['op_ix'];

        $master_db->query("update shop_order_price set expect_product_price = expect_product_price + '".$expect_product_price."' , product_price = product_price + '".$product_price."' , expect_delivery_price = expect_delivery_price + '".$expect_delivery_price."' , delivery_price = delivery_price + '".$delivery_price."', reserve = reserve + '".$reserve."' , point = point + '".$point."' , saveprice = saveprice + '".$saveprice."' where op_ix='".$op_ix."' ");
    } else {
        $master_db->query("insert into shop_order_price (op_ix,oid,payment_status,expect_product_price,product_price,expect_delivery_price,delivery_price,reserve,point,saveprice) values('','$oid','$payment_status','$expect_product_price','$product_price','$expect_delivery_price','$delivery_price','$reserve','$point','$saveprice')");
    }
}

function table_order_payment_data_creation($oid, $pay_type, $pay_status, $method, $tax_price, $tax_free_price, $payment_price, $etc_info = "")
{
    global $master_db;
    //pay_type 결제타입 G : 정상, F : 환불 , A : 추가
    //pay_status 주문결제상태 : IR ,IC
    $tax_price      = abs($tax_price);
    $tax_free_price = abs($tax_free_price);
    $payment_price  = abs($payment_price);

    if ($pay_status == "IC") $ic_date = "NOW()";
    else $ic_date = "''";

    $etc_info["settle_module"]   = $etc_info["settle_module"] ?? '';
    $etc_info["tid"]             = $etc_info["tid"] ?? '';
    $etc_info["authcode"]        = $etc_info["authcode"] ?? '';
    $etc_info["vb_info"]         = $etc_info["vb_info"] ?? '';
    $etc_info["bank"]            = $etc_info["bank"] ?? '';
    $etc_info["bank_input_date"] = $etc_info["bank_input_date"] ?? '';
    $etc_info["bank_input_name"] = $etc_info["bank_input_name"] ?? '';
    $etc_info["card_info"]       = $etc_info["card_info"] ?? '';
    $etc_info["claim_type"]      = $etc_info["claim_type"] ?? '';
    $etc_info["claim_group"]     = $etc_info["claim_group"] ?? '';
    $etc_info["memo"]            = $etc_info["memo"] ?? '';

    $master_db->query("insert into shop_order_payment (opay_ix,oid,pay_type,pay_status,method,settle_module,tid,authcode,vb_info,bank,bank_input_date,bank_input_name,card_info,claim_type,claim_group,memo,tax_price,tax_free_price,payment_price,ic_date,regdate,exchange_rate_payment_price) values('','".$oid."','".$pay_type."','".$pay_status."','".$method."','".$etc_info["settle_module"]."','".$etc_info["tid"]."','".$etc_info["authcode"]."','".$etc_info["vb_info"]."','".$etc_info["bank"]."','".$etc_info["bank_input_date"]."','".$etc_info["bank_input_name"]."','".$etc_info["card_info"]."','".$etc_info["claim_type"]."','".$etc_info["claim_group"]."','".$etc_info["memo"]."','".$tax_price."','".$tax_free_price."','".$payment_price."',".$ic_date.",NOW(),'".$etc_info["exchange_rate_payment_price"]."')");
}

function getguide_estimate()
{ //견적 가이드 리스트 뽑아오기 2013-07-16 이학봉
    global $layout_config;
    global $slave_mdb;
    //$db = new Database;

    $sql = "select
				e.estimate_title,
				e.est_ix
			from
				shop_estimates_guide as eg
				inner join shop_estimates as e on (eg.est_ix = e.est_ix)
			where
				1
				and (e.mall_ix = '".$layout_config['mall_ix']."' )";

    $slave_mdb->query($sql);
    $guide_array = $slave_mdb->fetchall();

    return $guide_array;
}

function getestimate_product($cid)
{
    global $slave_mdb;
    //$slave_mdb = new Database;

    $sql = "select
					r.*,
					p.pname
				from
					shop_estimate_relation as r
					inner join shop_product as p on (r.pid = p.id)
				where
					r.ecid = '".$cid."'";

    $slave_mdb->query($sql);
    $product_array = $slave_mdb->fetchall();

    return $product_array;
}

function get_product_array($est_ix)
{
    global $slave_mdb;

    //$slave_mdb = new Database;
    $sql = "select
				*
			from
				shop_estimates_detail
			where
				est_ix = '".$est_ix."'";

    $slave_mdb->query($sql);
    $product_array = $slave_mdb->fetchall();

    return $product_array;
}

function change_erp_link($status = 'RC', $od_ix)
{
    global $slave_mdb;
    //$slave_mdb = new Database;


    if ($od_ix) {
        $sql           = "select
						*
					from
						".TBL_SHOP_ORDER_DETAIL."
					where
						od_ix='".$od_ix."'";
        $slave_mdb->query($sql);
        $slave_mdb->fetch();
        $is_basic_link = $slave_mdb->dt['is_basic_link'];

        if ($is_basic_link == "Y") { // 원주문이 ERP 에 반영됫을 경우 N
            $sql = "update ".TBL_SHOP_ORDER_DETAIL." set is_erp_seller = 'N' where od_ix='".$od_ix."'";
            $slave_mdb->query($sql);
        } else { // 원주문이 ERP에 반영이 안됫을경우 반영할 필요가없으므로 반품처리로 취급
            $sql = "update ".TBL_SHOP_ORDER_DETAIL." set is_erp_seller_return = 'Y',is_basic_link='Y' where od_ix='".$od_ix."'";
            $slave_mdb->query($sql);
        }
    } else {
        return false;
    }
}

function get_maindisplay_schedule($mp_ix = "")
{
    global $slave_mdb;
    //$slave_mdb = new Database;

    $sql = "select
					md.div_ix,
					md.div_code,
					mg.mg_title,
					mg.mg_ix,
					mg.mp_ix
				from
					shop_main_div  as md
					inner join shop_main_goods as mg on (md.div_ix = mg.div_ix)
				where
					md.disp = '1' AND mg.disp = '1' and mp_ix = '".$mp_ix."'
					and '".time()."' between mg.mg_use_sdate and mg.mg_use_edate
					order by mg_use_sdate asc limit 1 ";
    //echo nl2br($sql);
    $slave_mdb->query($sql);
    if ($slave_mdb->total) {
        $slave_mdb->fetch();

        $now_date = mktime(0, 0, 0, date("m"), date("d"), date("Y"));

        $sql        = "select
						md.div_ix,
						md.div_code,
						mg.mg_title,
						mg.mg_ix,
						mg.mp_ix
					from
						shop_main_div  as md
						inner join shop_main_goods as mg on (md.div_ix = mg.div_ix)
					where
						md.disp = '1' AND mg.disp = '1' AND mg.mg_ix='".$slave_mdb->dt['mg_ix']."'
						and '".time()."' between mg.mg_use_sdate and mg.mg_use_edate ";
        //echo nl2br($sql);
        $slave_mdb->query($sql);
        $data_array = $slave_mdb->fetchall();

        return $data_array;
        //return get_maingoods_list($slave_mdb->dt[div_code]);
    } else {
        return "";
    }
}

function get_maingoods_list($div_code = "")
{ // dev2 프론토 메인 전시  불러오기 2013-11-21 이학봉
    global $slave_mdb;
    //h$slave_mdb = new Database;

    $now_date   = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
    if ($div_code != "") $add_query  = " AND md.div_code='".$div_code."' ";
    $sql        = "select
						md.div_ix,
						md.div_code,
						mg.mg_title,
						mg.mg_ix,
						mg.mp_ix,
						mg.mg_link
					from
						shop_main_div  as md
						inner join shop_main_goods as mg on (md.div_ix = mg.div_ix)
					where
						md.disp = '1' AND mg.disp = '1' ".$add_query."
						and '".time()."' between mg.mg_use_sdate and mg.mg_use_edate ";
    //	echo nl2br($sql);
    //	echo $sql;
    //	exit;
    $slave_mdb->query($sql);
    $data_array = $slave_mdb->fetchall();
    //print_r($data_array);
    //exit;
    return $data_array;
}

function shop_main_div($agent_type = "W", $div_code = "")
{ // dev2 프론토 메인 전시  불러오기 2013-11-21 이학봉
    global $slave_mdb;
    //$slave_mdb = new Database;

    if (!empty($div_code)) {
        $where = " and div_code='".$div_code."' ";
    }

    $sql        = "select
					md.*
				from
					shop_main_div as md
				where
					md.disp = '1'
					and agent_type = '".$agent_type."'
					$where
				ORDER BY div_code ASC";
    //echo nl2br($sql)."<br><br><br>";
    $slave_mdb->query($sql);
    $data_array = $slave_mdb->fetchall();

    return $data_array;
}

function get_main_display($mpg_ix)
{
    global $slave_mdb;
    //$slave_mdb= new Database;

    $sql = "select mgd.* , dt.dt_ix, dt.dt_name, dt.dt_goods_num
					from shop_main_group_display mgd
					left join shop_display_templetinfo dt on mgd.display_type = dt.dt_ix
					where mgd.mpg_ix = '".$mpg_ix."'
					order by mgd.vieworder asc
					 ";

    //echo $sql."<br><br>";
    $slave_mdb->query($sql);
    $display_groups = $slave_mdb->fetchall();

    $x = 0;
    for ($i = 0; $i < $slave_mdb->total; $i++) {
        $slave_mdb->fetch($i);
        for ($j = 0; $j < $slave_mdb->dt['set_cnt']; $j++) {
            $_display_groups[$x]['egd_ix']       = $slave_mdb->dt['egd_ix'];
            $_display_groups[$x]['display_type'] = $slave_mdb->dt['display_type'];
            $_display_groups[$x]['dt_goods_num'] = $slave_mdb->dt['dt_goods_num'];
            $_display_groups[$x]['set_cnt']      = $slave_mdb->dt['set_cnt'];
            $x++;
        }
    }

    return $_display_groups;
}

function member_edit_history($code, $column_name, $column_text, $before_edit, $after_edit, $chager_ix, $chager_name, $reg_url)
{ //회원정보 수정 히스토리 쌓기 2013-11-28 이학봉
    global $slave_mdb, $master_db;
    if (!$code) {
        return false;
    }

    if (!$reg_url) {
        $reg_url = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
    }

    //$slave_mdb = new Database;
    $sql         = "select
					cmd.gp_ix,
					cu.mem_type,
					cu.mem_div,
					cu.id,
					AES_DECRYPT(UNHEX(cmd.name),'".$slave_mdb->ase_encrypt_key."') as name
				from
					common_user as cu
					inner join common_member_detail as cmd on (cu.code = cmd.code)
				where
					cu.code = '".$code."'";
    $slave_mdb->query($sql);
    $member_info = $slave_mdb->fetchall();

    $edit_date = date("Ymd");

    $sql = "insert into common_member_edit_history (edit_date,code,gp_ix,mem_type,mem_div,name,id,column_name,column_text,before_edit,after_edit,chager_ix,chager_name,regdate,reg_url,ip)
				values('".$edit_date."','".$code."','".$member_info[0]['gp_ix']."','".$member_info[0]['mem_type']."','".$member_info[0]['mem_div']."','".$member_info[0]['name']."','".$member_info[0]['id']."','".$column_name."','".$column_text."','".$before_edit."','".$after_edit."','".$chager_ix."','".$chager_name."',NOW(),'".$reg_url."','".$_SERVER["REMOTE_ADDR"]."')";
    $master_db->query($sql);
}

function get_product_delivery($mem_type, $column, $pid)
{
    global $slave_mdb;
    //$slave_mdb = new Database;

    if ($pid) {
        /*
          if($mem_type == "" || $mem_type == "M"){
          $type = 'R';
          }else{
          $type = 'W';
          } */

        $type = UserSellingType();

        $sql = "select
						*
					from
						shop_product_delivery
					where
						pid = '".$pid."'
						and is_wholesale = '".$type."'";
        $slave_mdb->query($sql);
        $slave_mdb->fetch();

        return $slave_mdb->dt[$column];
    } else {
        return false;
    }
}

function GetReserveRate()
{ //적립금 설정 불러오기
    global $_SESSION;

    if (UserSellingType() == 'R') {
        $Shared_file = "b2c_mileage_rule"; //마일리지 설정값 파일명
    } else if (UserSellingType() == 'W') {
        $Shared_file = "b2b_mileage_rule";
    } else {
        $Shared_file = "b2c_mileage_rule"; //마일리지 설정값 파일명
    }

    //적립금정보 가져옴
    $reserve_data = get_shared_memory($Shared_file);

    return $reserve_data;
}

function GetPointRate()
{ //포인트 설정 불러오기 2014-07-09 이학봉
    if (UserSellingType() == 'R') {
        $Shared_file = "b2c_point_rule"; //마일리지 설정값 파일명
    } else if (UserSellingType() == 'W') {
        $Shared_file = "b2b_point_rule";
    } else {
        $Shared_file = "b2c_point_rule"; //마일리지 설정값 파일명
    }

    //적립금정보 가져옴
    $reserve_data = get_shared_memory($Shared_file);

    return $reserve_data;
}

function getDisplayGoodsInfo($div_code = "BASIC", $mg_ixs = "", $group_codes = "", $display_goods_cnt = "", $limitStart = 0, $limitEnd = '')
{
    global $slave_mdb, $shop_product_type, $layout_config, $_SESSION;
    global $script_times;

    //$script_times["get_display_".$div_code."_".$group_codes."_start_".rand()] = time();
    $reserve_data = GetReserveRate(); //적립금 정보 가져오기 함수 생성 2014-06-04 이학봉

    if ($reserve_data['reserve_use_yn'] == "Y") {
        $reserve_sql = " ,case when p.reserve_yn = 'N' then round(sellprice*(".$reserve_data['goods_reserve_rate']."/100)) else round(sellprice*(reserve_rate/100)) end as reserve";
    }

    if (is_array($mg_ixs)) {
        $mg_ix_str = " and erp.mg_ix in (".implode(",", $mg_ixs).") ";
    } else if ($mg_ixs != "") {
        $mg_ix_str = " and erp.mg_ix = '".$mg_ixs."' ";
    }

    if (is_array($group_codes)) {
        $group_code_str = " and group_code in (".implode(",", $group_codes).") ";
    } else if ($group_codes != "") {
        //$group_code = $group_codes;
        $group_code_str = " and group_code = '".$group_codes."' ";
    }

    if (!empty($div_code)) {
        $sql = "SELECT
							*
						FROM
							shop_main_product_group erp
						where
							div_code = '".$div_code."'
							and use_yn ='Y'
							".$mg_ix_str."
							".$group_code_str."
						ORDER BY group_code ASC ";
    } else {
        $sql = "SELECT
							*
						FROM
							shop_main_product_group erp
						where
							group_code is not null
							and use_yn ='Y'
							".$mg_ix_str."
							".$group_code_str."
						ORDER BY group_code ASC "; //div_code = '".$div_code."' and
    }
    //echo nl2br($sql)."<br>";
    //$script_times["get_display_".$div_code."_".$group_codes."_query1_start_".rand()] = time();
    $slave_mdb->query($sql);
    $displayGoods = $slave_mdb->fetchall();
    //echo "<pre>";
    //print_r($displayGoods);
    //$script_times["get_display_".$div_code."_".$group_codes."_query1_end_".rand()] = time();

    /**
     * 도매몰일때 도매가로 결제하도록 wholesale_price를 sellprice로 가져오기 bgh
     *
     * sellprice를 $select_price로 대체
     */
    /*
      if(UserSellingType() == 'W'){
      $select_price = 'wholesale_price as listprice, wholesale_sellprice as sellprice, sellprice AS ori_sellprice , pa.wholesale_free_delivery_yn as free_delivery_yn ';
      }else{
      $select_price = 'sellprice, listprice , pa.free_delivery_yn as free_delivery_yn';
      }
     */
    if (UserSellingType() == 'W') {
        if (UserProductPriceType() == 'L') {
            $select_price = 'wholesale_price as listprice, wholesale_price as sellprice, sellprice AS ori_sellprice, 0 as sale_rate ,  (listprice-sellprice)/listprice*100 as b2c_sale_rate , pa.wholesale_free_delivery_yn as free_delivery_yn ';
        } else {
            $select_price = 'wholesale_price as listprice, wholesale_sellprice as sellprice, sellprice AS ori_sellprice, (wholesale_price-wholesale_sellprice)/wholesale_price*100 as sale_rate ,  (listprice-sellprice)/listprice*100 as b2c_sale_rate , pa.wholesale_free_delivery_yn as free_delivery_yn ';
        }
    } else {
        if (UserProductPriceType() == 'P') {
            $select_price = 'premiumprice as sellprice, listprice, (listprice-premiumprice)/listprice*100 as sale_rate , pa.free_delivery_yn as free_delivery_yn ';
        } elseif (UserProductPriceType() == 'L') {
            $select_price = 'listprice as sellprice, listprice, 0 as sale_rate , pa.free_delivery_yn as free_delivery_yn ';
        } else {
            $select_price = 'sellprice, listprice, (listprice-sellprice)/listprice*100 as sale_rate , pa.free_delivery_yn as free_delivery_yn ';
        }
    }

    $nowdate = date('Y-m-d 00:00:00');

    for ($i = 0; $i < count($displayGoods); $i++) {
        switch ($displayGoods[$i]["display_type"]) {
            case ("0") : $goods_list_cnt = "5";
                break;
            case ("1") : $goods_list_cnt = "4";
                break;
            case ("2") : $goods_list_cnt = "3";
                break;
            case ("3") : $goods_list_cnt = "4";
                break;
            case ("4") : $goods_list_cnt = "7";
                break;
            case ("5") : $goods_list_cnt = "4";
                break;
            case ("6") : $goods_list_cnt = "6";
                break;
            default : $goods_list_cnt = "4";
                break;
        }
        if ($display_goods_cnt == "") {
            $display_goods_cnt_query = $displayGoods[$i]['product_cnt'];
        } else {
            $display_goods_cnt_query = $display_goods_cnt;
        }
        if ($display_goods_cnt_query == "" || $display_goods_cnt_query == "0") {
            $display_goods_cnt_query = 5;
        }//$display_goods_cnt => $display_goods_cnt_query 로 변경함 kbk 13/02/15

        if (is_mobile()) {
            $is_mobile_use_where = " and p.is_mobile_use in ('A','M')";
        } else {
            $is_mobile_use_where = " and p.is_mobile_use in ('A','W')";
        }
        if ($displayGoods[$i]['goods_display_type'] == "A") {
            if ($displayGoods[$i]['display_auto_priod'] != "") {
                if ($displayGoods[$i]['display_auto_type'] == "order_cnt") {//구매순
                    //$select_str=", order_buy_cnt";
                    //$select_leftjoin_str=" left join (select pid, sum(pcnt) as order_buy_cnt from shop_order_detail od where   od.status not in ('".ORDER_STATUS_SETTLE_READY."','".ORDER_STATUS_REPAY_READY."','".ORDER_STATUS_EXCHANGE_COMPLETE."','".ORDER_STATUS_EXCHANGE_AGAIN_DELIVERY."') and od.regdate between DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY) group by pid ) od on od.pid=p.id ";
                    //$orderby_str = "order_buy_cnt desc";
                    $orderby_str = "pa.order_cnt_".$displayGoods[$i]['display_auto_priod']." desc";
                } elseif ($displayGoods[$i]['display_auto_type'] == "view_cnt") {//클릭순
                    //$select_str=", com_view_cnt";
                    //$select_leftjoin_str=" left join (select pid, sum(nview_cnt) as com_view_cnt from commerce_viewingview cv where   cv.vdate between date_format(DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY),'%Y%m%d')  and  date_format(DATE_SUB('".$nowdate."', INTERVAL 1 DAY),'%Y%m%d') group by pid ) od on od.pid=p.id  ";
                    //$orderby_str = "com_view_cnt desc";
                    $orderby_str = "pa.view_cnt_".$displayGoods[$i]['display_auto_priod']." desc";
                } elseif ($displayGoods[$i]['display_auto_type'] == "sellprice") {//최저가순
                    if ($layout_config['mall_type'] == 'BW') {
                        $order_select_price = 'p.wholesale_price';
                    } else {
                        $order_select_price = 'p.sellprice';
                    }
                    $orderby_str = " $order_select_price asc";

                    $priod_where = " and p.regdate between DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i]['display_auto_priod']." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY) ";
                } elseif ($displayGoods[$i]['display_auto_type'] == "regdate") {
                    $orderby_str = "p.id DESC";
                } elseif ($displayGoods[$i]['display_auto_type'] == "regdate_asc") {
                    $orderby_str = "p.id ASC";
                } elseif ($displayGoods[$i]['display_auto_type'] == "wish_cnt") {
                    //$select_str=", list_wish_cnt";
                    //$select_leftjoin_str=" left join (select pid, count(*) as list_wish_cnt from shop_wishlist w where  w.regdate between date_format(DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY),'%Y-%m-%d')  and  date_format(DATE_SUB('".$nowdate."', INTERVAL 1 DAY),'%Y-%m-%d') group by pid ) od on od.pid=p.id ";
                    //$orderby_str = "list_wish_cnt desc";
                    $orderby_str = "pa.wish_cnt_".$displayGoods[$i]['display_auto_priod']." desc";
                } elseif ($displayGoods[$i]['display_auto_type'] == "after_score") {
                    //$select_str=", avg_after_score ";
                    /*
                      $select_leftjoin_str=" left join (
                      select pid , avg(avg_after_score) as avg_after_score from (
                      select bbs_etc1 as pid, avg(valuation_goods+valuation_goods_info+valuation_delivery+valuation_package) as avg_after_score from bbs_after a where regdate between DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY)
                      union all
                      select bbs_etc1 as pid , avg(valuation_goods+valuation_goods_info+valuation_delivery+valuation_package) as avg_after_score from bbs_premium_after a where regdate between DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY)
                      ) od
                      group by pid
                      ) od2 on od2.pid=p.id ";
                     */
                    //$orderby_str = "avg_after_score desc";
                    $orderby_str = "pa.after_score_".$displayGoods[$i]['display_auto_priod']." desc";
                }
            } else {
                if ($displayGoods[$i]['display_auto_type'] == "regdate_asc") {
                    $orderby_str = " p.id ASC";
                } else {
                    $orderby_str = "  p.".$displayGoods[$i]['display_auto_type']." ";
                    if ($displayGoods[$i]['display_auto_type'] == "sellprice") {
                        $orderby_str .= "ASC";
                    } else {
                        $orderby_str .= "DESC";
                    }
                }
            }

            if ($displayGoods[$i]['goods_display_sub_type'] == "C") {//$goods_display_sub_type
                $sql                                                                           = "SELECT ci.cid, ci.depth
								FROM shop_main_category_relation mcr , shop_category_info ci
								where mcr.cid = ci.cid and mcr.mg_ix='".$displayGoods[$i]['mg_ix']."' and mcr.group_code='".$displayGoods[$i]['group_code']."'  and  mcr.insert_yn ='Y'
								ORDER BY vieworder ASC"; //div_code = '".$div_code."' and
                $script_times["get_display_".$div_code."_".$group_codes."_query1_end_".rand()] = time();
                $slave_mdb->query($sql);
                $cateRelation                                                                  = $slave_mdb->fetchall();
                $script_times["get_display_".$div_code."_".$group_codes."_query2_end_".rand()] = time();

                if (is_array($cateRelation)) {
                    $cidNo   = 0;
                    $cid_str = "";
                    foreach ($cateRelation as $_keys => $_values) {
                        if ($cidNo > 0) $cid_str .= " OR ";
                        $cid_str .= " r.cid LIKE '".substr($_values['cid'], 0, ($_values['depth'] + 1) * 3)."%' ";
                        $cidNo++;
                    }
                    if ($cid_str != "") $goods_display_sub_type_where = " and (".$cid_str.") ";
                }

                $sql = "select
									p.id,p.pname,p.product_color_chip,p.order_cnt,p.stock,p.stock_use_yn,p.brand,p.brand_name, r.cid,
									$select_price, p.shotinfo, p.is_sell_date, p.sell_priod_sdate,
									p.sell_priod_edate, icons,
									case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,
									'".$displayGoods[$i]['mg_ix']."' as mg_ix ".$reserve_sql."  ".$select_str."
								from
									".TBL_SHOP_PRODUCT." p
									inner join shop_product_addinfo pa on p.id=pa.pid
									inner join shop_product_relation r on r.pid = p.id
									".$select_leftjoin_str."
								where
									p.state =1
									and p.disp = 1
									and r.basic = 1
									".$goods_display_sub_type_where."
									".$priod_where."
									".$is_mobile_use_where."
								order by ".$orderby_str."
								limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)."";
            }else if ($displayGoods[$i]['goods_display_sub_type'] == "B") {
                $sql = "SELECT b_ix
								FROM shop_main_brand_relation mbr
								where mbr.group_code='".$displayGoods[$i]['group_code']."' and mbr.mg_ix='".$displayGoods[$i]['mg_ix']."' and  mbr.insert_yn ='Y'
								 "; //div_code = '".$div_code."' and

                if ($sql != "") $goods_display_sub_type_where = " and p.brand in (".$sql.") ";
                $sql                          = "select
										p.id,p.pname,p.product_color_chip,p.order_cnt,p.stock,p.stock_use_yn,p.brand,p.brand_name, r.cid,
										$select_price, p.shotinfo, p.is_sell_date, p.sell_priod_sdate,
										p.sell_priod_edate, icons ,
										case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,
										'".$displayGoods[$i]['mg_ix']."' as mg_ix ".$reserve_sql."  ".$select_str."
									from
										".TBL_SHOP_PRODUCT." p
										inner join shop_product_addinfo pa on p.id=pa.pid
										inner join shop_product_relation r on r.pid = p.id
										".$select_leftjoin_str."
									where
										p.state =1
										and p.disp = 1
										and r.basic = 1
										".$goods_display_sub_type_where."
										".$priod_where."
										".$is_mobile_use_where."
									order by ".$orderby_str."
									limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)."";
            }else if ($displayGoods[$i]['goods_display_sub_type'] == "S") {
                $sql = "SELECT company_id
								FROM shop_main_seller_relation msr
								where msr.group_code='".$displayGoods[$i]['group_code']."' and msr.mg_ix='".$displayGoods[$i]['mg_ix']."'  and  msr.insert_yn ='Y'
								 "; //div_code = '".$div_code."' and

                if ($sql != "") $goods_display_sub_type_where = " and p.admin in (".$sql.") ";
                $sql                          = "select
										p.id,p.pname,p.product_color_chip,p.order_cnt,p.stock,p.stock_use_yn,p.brand,p.brand_name, r.cid,
										$select_price, p.shotinfo, p.is_sell_date, p.sell_priod_sdate, p.sell_priod_edate, icons,
										case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,
										'".$displayGoods[$i]['mg_ix']."' as mg_ix ".$reserve_sql."  ".$select_str."
									from
										".TBL_SHOP_PRODUCT." p
										inner join shop_product_addinfo pa on p.id=pa.pid
										inner join shop_product_relation r on r.pid = p.id
										".$select_leftjoin_str."
									where
										p.state =1
										and p.disp = 1
										and r.basic = 1
										".$goods_display_sub_type_where."
										".$priod_where."
										".$is_mobile_use_where."
									order by ".$orderby_str."
									limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)."";
            }
        } else {// 메뉴얼일때
            // 메인페이지 분석 모드일때 각 상품에 조회수를 이미지 위에 노출하기위해서 통계데이타와 연동
            if ($_GET["viewtype"] == "analysis" || $_SESSION["viewtype"] == "analysis") {
                if (!$vdate) {
                    $vdate = date("Ymd");
                }
                //판매기간 설정 조건 추가 2014-02-04 이학봉(조건추가하면서 쿼리 라인 정리 도저히 알아보기 힘듭니다.)
                $sql = "SELECT
								".$goods_list_cnt." AS goods_list_cnt,
								p.id,p.pname,p.product_color_chip,
								$select_price,
								p.stock, p.stock_use_yn, p.brand, p.brand_name, p.shotinfo,p.admin,
								erp.mpr_ix, erp.mg_ix, p.order_cnt,
								IFNULL(mc.ncnt,0) as ncnt,
								p.is_sell_date,
								p.sell_priod_sdate,p.product_point,
								p.sell_priod_edate, r.cid, erp.div_code,
								case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,
								icons $reserve_sql
							FROM
								".TBL_SHOP_PRODUCT." p
								right join shop_product_addinfo pa on p.id=pa.pid
								left join shop_product_relation r on p.id = r.pid and r.basic = 1
								right join ".TBL_SHOP_MAIN_PRODUCT_RELATION." erp on p.id = erp.pid
								left join logstory_maingoods_click mc on erp.mpr_ix = mc.mpr_ix and mc.vdate = '".$vdate."'
							where
								1
								and if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')
								and erp.group_code = '".$displayGoods[$i]['group_code']."'
								and erp.div_code = '".$div_code."'
								".$mg_ix_str."
								and p.disp = 1 and p.state = 1 and p.product_type != 2 ".$is_mobile_use_where."
								order by ".(is_mobile() ? "erp.vieworder asc" : "p.product_point desc")."   limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)." ";

                //ci.depth,
                //left join shop_category_info ci on r.cid = ci.cid
            } else {
                $offsetLimit = $display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query;
                if ($limitEnd != '') {
                    $offsetLimit = $limitEnd;
                }
                $sql = "SELECT
									".$goods_list_cnt." AS goods_list_cnt,
									p.id,p.pname,p.product_color_chip,
									$select_price,
									p.stock, p.stock_use_yn, p.brand, p.brand_name,p.admin,
									p.shotinfo, erp.mpr_ix, erp.mg_ix, p.order_cnt,
									p.is_sell_date,
									p.sell_priod_sdate, p.product_point,
									p.sell_priod_edate, r.cid, ci.depth, erp.div_code, csd.shop_name,
									case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,
									icons $reserve_sql
								FROM
									".TBL_SHOP_PRODUCT." p
									right join shop_product_addinfo pa on p.id=pa.pid
									left join shop_product_relation r on p.id = r.pid and r.basic = 1
									left join shop_category_info ci on r.cid = ci.cid
									left join common_seller_detail csd on p.admin = csd.company_id
									right join ".TBL_SHOP_MAIN_PRODUCT_RELATION." erp on p.id = erp.pid
								where if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')
									and erp.group_code = '".$displayGoods[$i]['group_code']."'
									and erp.div_code = '".$div_code."'
									".$mg_ix_str."
									and p.disp = 1 and p.state = 1 and p.product_type != 2 ".$is_mobile_use_where."
									order by ".(is_mobile() ? "erp.vieworder asc" : "erp.vieworder asc")."
									limit ".$limitStart.", ".$offsetLimit." ";
                // p.product_point desc
                //and p.brand = b.b_ix 삭제 ,,".TBL_SHOP_BRAND." b 삭제 , b.brand_name --> p.brand_name 변경
            }
        }
        //echo nl2br($sql);
        //$script_times["get_display_".$div_code."_".$group_codes."_query3_start_".rand()] = time();
        //echo nl2br($sql)."<br><br><br><br><br><br><br><br><br>";
        //$script_times["get_display_".$div_code."_".$group_codes."_query3_sql_".rand()] = $sql;
        $slave_mdb->query($sql);
        $displayGoods[$i]['goods'] = $slave_mdb->fetchall();
        //$script_times["get_display_".$div_code."_".$group_codes."_query3_end_".rand()] = time();

        $cssML   = 'ml'.$displayGoods[$i]['display_type'];
        $cssType = 'type'.$displayGoods[$i]['display_type'];
        $imgType = 'ms';
        $noImg   = 'noimg_'.$imgType.'.gif';

        if (is_array($displayGoods[$i]['goods'])) {
            if ($_SESSION["user"]["code"]) {
                $slave_mdb->query("SELECT pid FROM shop_wishlist where mid = '".$_SESSION["user"]["code"]."' ");
                $favorite_goods = $slave_mdb->getrows();
                $favorite_goods = $favorite_goods[0];
                //print_r($favorite_goods);
            }

            $products = $displayGoods[$i]['goods'];
            for ($j = 0; $j < count($products); $j++) {
                $_array_pid[]                                                    = $products[$j]['id'];
                $goods_infos[$products[$j]['id']]['pid']                         = $products[$j]['id'];
                $goods_infos[$products[$j]['id']]
                    ['amount'] = $products[$j]['pcount'];
                $goods_infos[$products[$j]['id']]['cid']                         = $products[$j]['cid'];
                $goods_infos[$products[$j]['id']]['depth']                       = $products[$j]['depth'];
            }
            //$script_times["get_display_".$div_code."_".$group_codes."_discountresult_start_".rand()] = time();
            $discount_info = DiscountRult($goods_infos, $cid, $depth);
            //$script_times["get_display_".$div_code."_".$group_codes."_discountresult_end_".rand()] = time();

            $cnt = 0;
            foreach ($displayGoods[$i]['goods'] as $key => $sub_array) {
                //if($key %
                $select_ = array("icons_list" => explode(";", $sub_array['icons']));
                array_insert($sub_array, 14, $select_);

                $pcolor_ = array("colorchip_list" => explode(",", str_replace(" ", "", $sub_array['product_color_chip'])));
                array_insert($sub_array, 15, $pcolor_);

                $sub_array['is_favorite'] = false;
                if (is_array($favorite_goods)) {
                    if (in_array($sub_array['id'], $favorite_goods)) {
                        $sub_array['is_favorite'] = true;
                    }
                }

                $sub_array['sold_out'] = 'N';
                if (($sub_array['stock_use_yn'] == 'Y' || $sub_array['stock_use_yn'] == 'Q') && ($sub_array['stock'] + $sub_array['available_stock'] <= 0)) {
                    $sub_array['sold_out'] = 'Y';
                }

                $discount_item = $discount_info[$sub_array['id']];
                //print_r($discount_item);
                $_dcprice      = $sub_array['sellprice'];
                if (is_array($discount_item)) {
                    foreach ($discount_item as $_key => $_item) {
                        if ($_item['discount_value_type'] == "1") { // %
                            //echo $_item[discount_value]."<br>";
                            $_dcprice = roundBetter($_dcprice * (100 - $_item['discount_value']) / 100, $_item['round_position'], $_item['round_type']); //$_dcprice*(100 - $_item[discount_value])/100;
                        } else if ($_item['discount_value_type'] == "2") {// 원
                            $_dcprice = $_dcprice - $_item['discount_value'];
                        }

                        //$discount_desc[] = $_item[discount_type]."-".$_item[discount_value]." ".($_item[discount_value_type] == "1" ? "%":"원")."-".$_dcprice."원";
                        $discount_desc[] = $_item; //array("discount_type"=>$_item[discount_type], "haddoffice_value"=>$_item[discount_value], "discount_value"=>$_item[discount_value], "discount_value"=>$_item[discount_value], "discount_value_type"=>$_item[discount_value_type], "_dcprice"=>$_dcprice);
                    }
                }
                $_dcprice              = array("dcprice" => $_dcprice);
                array_insert($sub_array, 52, $_dcprice);
                $discount_desc         = array("discount_desc" => $discount_desc);
                array_insert($sub_array, 53, $discount_desc);
                unset($discount_desc);
                $sub_array['cssML']    = $cssML;
                $sub_array['cssType']  = $cssType;
                $sub_array['noImg']    = $noImg;
                $sub_array['imgType']  = $imgType;
                $sub_array['div_code'] = $div_code;
                if ($displayGoods[$i]['display_type'] == 2) {
                    $sub_array['imgType'] = 'm';
                } elseif ($displayGoods[$i]['display_type'] == 4) {
                    if ($cnt % 7 == 0) {
                        $sub_array['addHTML1'] = '<div style="clear:both;float:left;padding:0 0 0 0px;">';
                        $sub_array['addHTML2'] = '</div><div class="type4-2">';
                        $sub_array['imgType']  = 'b';
                        $sub_array['noImg']    = 'noimg_'.$sub_array['imgType'].'.gif';
                    } else {
                        $sub_array['cssType'] = 'type4-1';
                    }
                } elseif ($displayGoods[$i]['display_type'] == 6) {
                    if ($cnt % 6 < 2) {
                        //$sub_array['addHTML1']	= '</div><div class="good_names" style="width:420px;padding:0 10px;">';
                        //$sub_array['addHTML2']	= '</div><div style="float:left;width:50%;">';
                        $sub_array['imgType'] = 'b';
                        $sub_array['noImg']   = 'noimg_'.$sub_array['imgType'].'.gif';
                    } else {
                        $sub_array['cssML']   = 'ml6-1';
                        $sub_array['cssType'] = 'type6-1';
                    }
                }
                $remain_days              = dateDiff(date('Y-m-d H:i:s'), $sub_array['sell_priod_edate'], 'day');
                $sub_array['remain_days'] = ($remain_days > 0) ? $remain_days : 0;

                $displayGoods[$i]['goods'][$key] = $sub_array;
                $cnt++;
            }
        }
        unset($display_goods_cnt);
    }

    //$script_times["get_display_".$div_code."_".$group_codes."_end_".rand()] = time();
    //print_r($displayGoods)
    return $displayGoods;
}

function getDisplayPromotionGoodsInfo($div_code = "BASIC", $pg_ixs = "", $group_codes = "", $display_goods_cnt = "")
{
    global $slave_mdb, $shop_product_type, $layout_config, $_SESSION;

    $reserve_data = GetReserveRate(); //적립금 정보 가져오기 함수 생성 2014-06-04 이학봉

    if ($reserve_data['mileage_info_use'] == "Y") { // 개별상품 적립금 우선  적용 2013-07-17 이학봉
        if (UserSellingType() == "W") {
            if (UserProductPriceType() == 'L') {
                $reserve_sql = " ,case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' then floor(p.wholesale_price*(".$reserve_data['goods_mileage_rate']."/100)) else floor(p.wholesale_price*(p.wholesale_reserve_rate/100)) end as reserve,
					case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' then ".$reserve_data['goods_mileage_rate']." else p.wholesale_reserve_rate end as reserve_rate";
            } else {
                $reserve_sql = " ,case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' then floor(p.wholesale_sellprice*(".$reserve_data['goods_mileage_rate']."/100)) else floor(p.wholesale_sellprice*(p.wholesale_reserve_rate/100)) end as reserve,
					case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' then ".$reserve_data['goods_mileage_rate']." else p.wholesale_reserve_rate end as reserve_rate";
            }
        } else {
            if (UserProductPriceType() == 'P') {
                $reserve_sql = " ,case when p.reserve_yn = 'N' or p.reserve_yn = '' then floor(p.premiumprice*(".$reserve_data['goods_mileage_rate']."/100)) else floor(p.premiumprice*(p.reserve_rate/100)) end as reserve,
					case when p.reserve_yn = 'N' or p.reserve_yn = '' then ".$reserve_data['goods_mileage_rate']." else p.reserve_rate end as reserve_rate";
            } elseif (UserProductPriceType() == 'L') {
                $reserve_sql = " ,case when p.reserve_yn = 'N' or p.reserve_yn = '' then floor(p.listprice*(".$reserve_data['goods_mileage_rate']."/100)) else floor(p.listprice*(p.reserve_rate/100)) end as reserve,
					case when p.reserve_yn = 'N' or p.reserve_yn = '' then ".$reserve_data['goods_mileage_rate']." else p.reserve_rate end as reserve_rate";
            } else {
                $reserve_sql = " ,case when p.reserve_yn = 'N' or p.reserve_yn = '' then floor(p.sellprice*(".$reserve_data['goods_mileage_rate']."/100)) else floor(p.sellprice*(p.reserve_rate/100)) end as reserve,
					case when p.reserve_yn = 'N' or p.reserve_yn = '' then ".$reserve_data['goods_mileage_rate']." else p.reserve_rate end as reserve_rate";
            }
        }
    } elseif ($reserve_data['mileage_info_use'] == "P") { // 결제수단별 적립금 비율
        if (UserSellingType() == "W") {
            if (UserProductPriceType() == 'L') {
                $reserve_sql = " ,case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' then floor(p.wholesale_price*(".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]."/100)) else floor(p.wholesale_price*(p.wholesale_reserve_rate/100)) end as reserve,
					case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' ".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]." else p.wholesale_reserve_rate end as reserve_rate";
            } else {
                $reserve_sql = " ,case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' then floor(p.wholesale_sellprice*(".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]."/100)) else floor(p.wholesale_sellprice*(p.wholesale_reserve_rate/100)) end as reserve,
					case when p.wholesale_reserve_yn = 'N' or p.wholesale_reserve_yn = '' ".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]." else p.wholesale_reserve_rate end as reserve_rate";
            }
        } else {
            if (UserProductPriceType() == 'P') {
                $reserve_sql = " ,case when p.reserve_yn = 'N' or p.reserve_yn = '' then floor(p.premiumprice*(".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]."/100)) else floor(p.premiumprice*(p.reserve_rate/100)) end as reserve,
					case when p.reserve_yn = 'N' or p.reserve_yn = '' then ".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]." else p.reserve_rate end as reserve_rate";
            } elseif (UserProductPriceType() == 'L') {
                $reserve_sql = " ,case when p.reserve_yn = 'N' or p.reserve_yn = '' then floor(p.listprice*(".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]."/100)) else floor(p.listprice*(p.reserve_rate/100)) end as reserve,
					case when p.reserve_yn = 'N' or p.reserve_yn = '' then ".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]." else p.reserve_rate end as reserve_rate";
            } else {
                $reserve_sql = " ,case when p.reserve_yn = 'N' or p.reserve_yn = '' then floor(p.sellprice*(".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]."/100)) else floor(p.sellprice*(p.reserve_rate/100)) end as reserve,
					case when p.reserve_yn = 'N' or p.reserve_yn = '' then ".$reserve_data["goods_mileage_rate_".$reserve_data['basic_rate']]." else p.reserve_rate end as reserve_rate";
            }
        }
    } else {
        if (UserSellingType() == "W") { //기업회원일경우 도매가로 적립율 적용
            if (UserProductPriceType() == 'L') {
                $reserve_sql = " ,case when p.wholesale_reserve_yn = 'Y' then floor(p.wholesale_price*(p.wholesale_reserve_rate/100)) else 0 end as reserve,
					case when p.wholesale_reserve_yn = 'Y' then p.wholesale_reserve_rate else 0 end as reserve_rate";
            } else {
                $reserve_sql = " ,case when p.wholesale_reserve_yn = 'Y' then floor(p.wholesale_sellprice*(p.wholesale_reserve_rate/100)) else 0 end as reserve,
					case when p.wholesale_reserve_yn = 'Y' then p.wholesale_reserve_rate else 0 end as reserve_rate";
            }
        } else {
            if (UserProductPriceType() == 'P') {
                $reserve_sql = " ,case when p.reserve_yn = 'Y' then floor(p.premiumprice*(p.reserve_rate/100)) else 0 end as reserve,
					case when p.reserve_yn = 'Y' then p.reserve_rate else 0 end as reserve_rate";
            } elseif (UserProductPriceType() == 'L') {
                $reserve_sql = " ,case when p.reserve_yn = 'Y' then floor(p.listprice*(p.reserve_rate/100)) else 0 end as reserve,
					case when p.reserve_yn = 'Y' then p.reserve_rate else 0 end as reserve_rate";
            } else {
                $reserve_sql = " ,case when p.reserve_yn = 'Y' then floor(p.sellprice*(p.reserve_rate/100)) else 0 end as reserve,
					case when p.reserve_yn = 'Y' then p.reserve_rate else 0 end as reserve_rate";
            }
        }
    }

    if (is_array($pg_ixs)) {
        $pg_ix_str = " and pg_ix in (".implode(",", $pg_ixs).") ";
    } else if ($pg_ixs != "") {
        $pg_ix_str = " and pg_ix = '".$pg_ixs."' ";
    }

    if (is_array($group_codes)) {
        $group_code_str = " and group_code in (".implode(",", $group_codes).") ";
    } else if ($group_codes != "") {
        //$group_code = $group_codes;
        $group_code_str = " and group_code = '".$group_codes."' ";
    }

    if (!empty($div_code)) {
        $sql = "SELECT
						*
					FROM
						shop_promotion_product_group
					where
						div_code = '".$div_code."'
						and use_yn ='Y'
						".$pg_ix_str."
						".$group_code_str."
						ORDER BY group_code ASC ";
    } else {
        $sql = "SELECT
						*
					FROM
						shop_promotion_product_group
					where
						group_code is not null
						and use_yn ='Y'
						".$pg_ix_str."
						".$group_code_str."
						ORDER BY group_code ASC "; //div_code = '".$div_code."' and
    }
    //echo nl2br($sql);
    $slave_mdb->query($sql);
    $displayGoods = $slave_mdb->fetchall();

    /**
     * 도매몰일때 도매가로 결제하도록 wholesale_price를 sellprice로 가져오기 bgh
     *
     * sellprice를 $select_price로 대체
     */
    if (UserSellingType() == 'W') {
        if (UserProductPriceType() == 'L') {
            $select_price = 'wholesale_price as listprice, wholesale_price as sellprice, sellprice AS ori_sellprice, 0 as sale_rate ,  (listprice-sellprice)/listprice*100 as b2c_sale_rate , pa.wholesale_free_delivery_yn as free_delivery_yn ';
        } else {
            $select_price = 'wholesale_price as listprice, wholesale_sellprice as sellprice, sellprice AS ori_sellprice, (wholesale_price-wholesale_sellprice)/wholesale_price*100 as sale_rate ,  (listprice-sellprice)/listprice*100 as b2c_sale_rate , pa.wholesale_free_delivery_yn as free_delivery_yn ';
        }
    } else {
        if (UserProductPriceType() == 'P') {
            $select_price = 'premiumprice as sellprice, listprice, (listprice-premiumprice)/listprice*100 as sale_rate , pa.free_delivery_yn as free_delivery_yn ';
        } elseif (UserProductPriceType() == 'L') {
            $select_price = 'listprice as sellprice, listprice, 0 as sale_rate , pa.free_delivery_yn as free_delivery_yn ';
        } else {
            $select_price = 'sellprice, listprice, (listprice-sellprice)/listprice*100 as sale_rate , pa.free_delivery_yn as free_delivery_yn ';
        }
    }

    $nowdate = date('Y-m-d 00:00:00');

    for ($i = 0; $i < count($displayGoods); $i++) {
        switch ($displayGoods[$i]["display_type"]) {
            case ("0") : $goods_list_cnt = "5";
                break;
            case ("1") : $goods_list_cnt = "4";
                break;
            case ("2") : $goods_list_cnt = "3";
                break;
            case ("3") : $goods_list_cnt = "4";
                break;
            case ("4") : $goods_list_cnt = "7";
                break;
            case ("5") : $goods_list_cnt = "4";
                break;
            case ("6") : $goods_list_cnt = "6";
                break;
            default : $goods_list_cnt = "4";
                break;
        }
        if ($display_goods_cnt == "") {
            $display_goods_cnt_query = $displayGoods[$i]['product_cnt'];
        } else {
            $display_goods_cnt_query = $display_goods_cnt;
        }
        if ($display_goods_cnt_query == "" || $display_goods_cnt_query == "0") {
            $display_goods_cnt_query = 5;
        }//$display_goods_cnt => $display_goods_cnt_query 로 변경함 kbk 13/02/15

        if (is_mobile()) {
            $is_mobile_use_where = " and p.is_mobile_use in ('A','M')";
        } else {
            $is_mobile_use_where = " and p.is_mobile_use in ('A','W')";
        }

        if ($displayGoods[$i]['goods_display_type'] == "A") {
            if ($displayGoods[$i]['display_auto_priod'] != "") {
                if ($displayGoods[$i]['display_auto_type'] == "order_cnt") {//구매순
                    //$select_str=", order_buy_cnt";
                    //$select_leftjoin_str=" left join (select pid, sum(pcnt) as order_buy_cnt from shop_order_detail od where   od.status not in ('".ORDER_STATUS_SETTLE_READY."','".ORDER_STATUS_REPAY_READY."','".ORDER_STATUS_EXCHANGE_COMPLETE."','".ORDER_STATUS_EXCHANGE_AGAIN_DELIVERY."') and od.regdate between DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY) group by pid ) od on od.pid=p.id ";
                    //$orderby_str = "order_buy_cnt desc";
                    $orderby_str = "pa.order_cnt_".$displayGoods[$i]['display_auto_priod']." desc";
                } elseif ($displayGoods[$i]['display_auto_type'] == "view_cnt") {//클릭순
                    //$select_str=", com_view_cnt";
                    //$select_leftjoin_str=" left join (select pid, sum(nview_cnt) as com_view_cnt from commerce_viewingview cv where   cv.vdate between date_format(DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY),'%Y%m%d')  and  date_format(DATE_SUB('".$nowdate."', INTERVAL 1 DAY),'%Y%m%d') group by pid ) od on od.pid=p.id  ";
                    //$orderby_str = "com_view_cnt desc";
                    $orderby_str = "pa.view_cnt_".$displayGoods[$i]['display_auto_priod']." desc";
                } elseif ($displayGoods[$i]['display_auto_type'] == "sellprice") {//최저가순
                    if ($layout_config['mall_type'] == 'BW') {
                        $order_select_price = 'p.wholesale_price';
                    } else {
                        $order_select_price = 'p.sellprice';
                    }
                    $orderby_str = " $order_select_price asc";

                    $priod_where = " and p.regdate between DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i]['display_auto_priod']." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY) ";
                } elseif ($displayGoods[$i]['display_auto_type'] == "regdate") {
                    $orderby_str = "p.regdate_desc asc";
                } elseif ($displayGoods[$i]['display_auto_type'] == "regdate_asc") {
                    $orderby_str = "p.regdate asc";
                } elseif ($displayGoods[$i]['display_auto_type'] == "wish_cnt") {
                    //$select_str=", list_wish_cnt";
                    //$select_leftjoin_str=" left join (select pid, count(*) as list_wish_cnt from shop_wishlist w where  w.regdate between date_format(DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY),'%Y-%m-%d')  and  date_format(DATE_SUB('".$nowdate."', INTERVAL 1 DAY),'%Y-%m-%d') group by pid ) od on od.pid=p.id ";
                    //$orderby_str = "list_wish_cnt desc";
                    $orderby_str = "pa.wish_cnt_".$displayGoods[$i]['display_auto_priod']." desc";
                } elseif ($displayGoods[$i]['display_auto_type'] == "after_score") {
                    //$select_str=", avg_after_score ";
                    /* $select_leftjoin_str=" left join (
                      select pid , avg(avg_after_score) as avg_after_score from (
                      select bbs_etc1 as pid, avg(valuation_goods+valuation_goods_info+valuation_delivery+valuation_package) as avg_after_score from bbs_after a where regdate between DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY)
                      union all
                      select bbs_etc1 as pid , avg(valuation_goods+valuation_goods_info+valuation_delivery+valuation_package) as avg_after_score from bbs_premium_after a where regdate between DATE_SUB('".$nowdate."', INTERVAL ".$displayGoods[$i][display_auto_priod]." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY)
                      ) od
                      group by pid
                      ) od2 on od2.pid=p.id "; */
                    //$orderby_str = "avg_after_score desc";
                    $orderby_str = "pa.after_score_".$displayGoods[$i]['display_auto_priod']." desc";
                }
            } else {
                if ($displayGoods[$i]['display_auto_type'] == "regdate_asc") {
                    $orderby_str = " p.regdate ASC";
                } else {
                    $orderby_str = "  p.".$displayGoods[$i]['display_auto_type']." ";
                    if ($displayGoods[$i]['display_auto_type'] == "sellprice") {
                        $orderby_str .= "ASC";
                    } else {
                        $orderby_str .= "DESC";
                    }
                }
            }

            if ($displayGoods[$i]['goods_display_sub_type'] == "C" || $displayGoods[$i]['goods_display_sub_type'] == "") {//$goods_display_sub_type
                $sql = "SELECT ci.cid, ci.depth
								FROM shop_promotion_category_relation mcr , shop_category_info ci
								where mcr.cid = ci.cid and div_code = '".$div_code."' and mcr.group_code='".$displayGoods[$i]['group_code']."'  and  mcr.insert_yn ='Y'
								ORDER BY vieworder ASC"; //

                $slave_mdb->query($sql);
                $cateRelation = $slave_mdb->fetchall();

                if (is_array($cateRelation)) {
                    $cidNo   = 0;
                    $cid_str = "";
                    foreach ($cateRelation as $_keys => $_values) {
                        if ($cidNo > 0) $cid_str .= " OR ";
                        $cid_str .= " LEFT(r.cid,".(($_values['depth'] + 1) * 3).") = '".substr($_values['cid'], 0, ($_values['depth'] + 1) * 3)."' ";
                        $cidNo++;
                    }
                    if ($cid_str != "") $goods_display_sub_type_where = " and (".$cid_str.") ";
                }

                $sql = "select p.id,p.pcode,p.product_type,p.pname,p.product_color_chip,p.order_cnt,p.stock,p.stock_use_yn,p.brand,p.brand_name, r.cid, $select_price, p.shotinfo, p.is_sell_date, p.sell_priod_sdate, p.sell_priod_edate,  case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,csd.shop_name, icons ".$reserve_sql." ".$select_str."
							from ".TBL_SHOP_PRODUCT." p
							right join shop_product_addinfo pa on p.id=pa.pid
							left join shop_product_relation r on r.pid = p.id
							left join common_seller_detail  csd on p.admin = csd.company_id
							".$select_leftjoin_str."
							where if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1') and p.state =1 and p.disp = 1 and r.basic = 1
							".$goods_display_sub_type_where." ".$priod_where." ".$is_mobile_use_where."
							order by ".$orderby_str."
							limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)."";
            }else if ($displayGoods[$i]['goods_display_sub_type'] == "B") {
                $sql = "SELECT b_ix
								FROM shop_promotion_brand_relation mbr
								where mbr.group_code='".$displayGoods[$i]['group_code']."'  and  mbr.insert_yn ='Y'
								 "; //div_code = '".$div_code."' and

                if ($sql != "") $goods_display_sub_type_where = " and p.brand in (".$sql.") ";
                $sql                          = "select p.id,p.pcode,p.product_type,p.pname,p.product_color_chip,p.order_cnt,p.stock,p.stock_use_yn,p.brand,p.brand_name, r.cid, $select_price, p.shotinfo, p.is_sell_date, p.sell_priod_sdate, p.sell_priod_edate, case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new, csd.shop_name, icons ".$reserve_sql." ".$select_str."
								from ".TBL_SHOP_PRODUCT." p
								right join shop_product_addinfo pa on p.id=pa.pid
								left join shop_product_relation r on r.pid = p.id
								left join common_seller_detail  csd on p.admin = csd.company_id
								".$select_leftjoin_str."
								where if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1') and p.state =1 and p.disp = 1 and r.basic = 1
								".$goods_display_sub_type_where." ".$priod_where." ".$is_mobile_use_where."
								order by ".$orderby_str."
								limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)."";
            }else if ($displayGoods[$i]['goods_display_sub_type'] == "S") {
                $sql = "SELECT company_id
								FROM shop_promotion_seller_relation msr
								where msr.group_code='".$displayGoods[$i]['group_code']."'  and  msr.insert_yn ='Y'
								 "; //div_code = '".$div_code."' and

                if ($sql != "") $goods_display_sub_type_where = " and p.admin in (".$sql.") ";
                $sql                          = "select p.id,p.pcode,p.product_type,p.pname,p.product_color_chip,p.order_cnt,p.stock,p.stock_use_yn,p.brand,p.brand_name, r.cid, $select_price, p.shotinfo, p.is_sell_date, po.option_kind, p.sell_priod_sdate,case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new, p.sell_priod_edate,  csd.shop_name, icons ".$reserve_sql." ".$select_str."
								from ".TBL_SHOP_PRODUCT." p
								right join shop_product_addinfo pa on p.id=pa.pid
								left join shop_product_relation r on r.pid = p.id
								left join common_seller_detail  csd on p.admin = csd.company_id
								".$select_leftjoin_str."
								where if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1') and p.state =1 and p.disp = 1 and r.basic = 1
								".$goods_display_sub_type_where." ".$priod_where." ".$is_mobile_use_where."
								order by ".$orderby_str."
								limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)."";
            }
        } else {// 메뉴얼일때
            // 메인페이지 분석 모드일때 각 상품에 조회수를 이미지 위에 노출하기위해서 통계데이타와 연동
            if ($_GET["viewtype"] == "analysis" || $_SESSION["viewtype"] == "analysis") {
                if (!$vdate) {
                    $vdate = date("Ymd");
                }
                //판매기간 설정 조건 추가 2014-02-04 이학봉(조건추가하면서 쿼리 라인 정리 도저히 알아보기 힘듭니다.)
                $sql = "SELECT
								".$goods_list_cnt." AS goods_list_cnt,
								p.id,p.pname,p.product_color_chip,p.pcode,p.product_type,
								$select_price,
								p.stock, p.stock_use_yn, p.brand_name, p.brand, p.shotinfo,
								erp.ppr_ix, p.order_cnt,
								IFNULL(mc.ncnt,0) as ncnt,
								p.is_sell_date,
								p.sell_priod_sdate,
								p.sell_priod_edate, r.cid, ci.depth, csd.shop_name,case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,
								icons $reserve_sql
							FROM
								".TBL_SHOP_PRODUCT." p
								right join shop_product_addinfo pa on p.id=pa.pid
								left join shop_product_relation r on p.id = r.pid and r.basic = 1
								left join shop_category_info ci on r.cid = ci.cid
								left join common_seller_detail  csd on p.admin = csd.company_id
								right join shop_promotion_product_relation erp on p.id = erp.pid
								left join logstory_maingoods_click mc on erp.ppr_ix = mc.mpr_ix and mc.vdate = '".$vdate."'
							where
								1
								and if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')
								and erp.group_code = '".$displayGoods[$i]['group_code']."'
								and erp.div_code = '".$div_code."'
								".$pg_ix_str." ".$is_mobile_use_where."
								and p.disp = 1 and p.state = 1 and p.product_type != 2
								order by erp.vieworder asc  limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)." ";
                //and erp.div_code = '".$div_code."'
            } else {
                $sql = "SELECT
								".$goods_list_cnt." AS goods_list_cnt,
								p.id,p.pname,p.product_color_chip,p.pcode,p.product_type,
								$select_price,
								p.stock, p.stock_use_yn, p.brand_name, p.brand,case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new,
								p.shotinfo, erp.ppr_ix, p.order_cnt,
								p.is_sell_date,
								p.sell_priod_sdate,
								p.sell_priod_edate, r.cid, ci.depth,  csd.shop_name,
								icons $reserve_sql
							FROM
								".TBL_SHOP_PRODUCT." p
								right join shop_product_addinfo pa on p.id=pa.pid
								left join shop_product_relation r on p.id = r.pid and r.basic = 1
								left join shop_category_info ci on r.cid = ci.cid
								left join common_seller_detail  csd on p.admin = csd.company_id
								right join shop_promotion_product_relation erp on p.id = erp.pid
							where if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')
								and erp.group_code = '".$displayGoods[$i]['group_code']."'
								and erp.div_code = '".$div_code."'
								".$pg_ix_str." ".$is_mobile_use_where."
								and p.disp = 1 and p.state = 1 and p.product_type != 2
								order by erp.vieworder asc
								limit 0, ".($display_goods_cnt ? $display_goods_cnt : $display_goods_cnt_query)." ";
                //
                //and p.brand = b.b_ix 삭제 ,,".TBL_SHOP_BRAND." b 삭제 , b.brand_name --> p.brand_name 변경
            }
        }

        /*
          $sql = "select p.* ,
          (select count(*) as user_after_valuation  FROM bbs_after  where bbs_etc1 = p.id) as user_after_valuation,
          (select cp.cupon_ix
          from
          shop_cupon c
          join shop_cupon_publish cp
          join shop_cupon_relation_product crp
          join shop_product sp
          where
          c.cupon_ix = cp.cupon_ix and cp.use_product_type = 3 and sp.id = crp.pid and cp.publish_ix = crp.publish_ix and cp.publish_type = 2
          and ((cp.use_date_type!='9' AND '".date("Ymd")."' between date_format(cp.use_sdate,'%Y%m%d') and date_format(cp.use_edate,'%Y%m%d')) OR cp.use_date_type = 9 OR cp.use_date_type = 2)
          and cp.disp='1' and sp.coupon_use_yn='Y'
          and cp.use_date_type <> '9' and cp.publish_condition_price <= sp.sellprice  and sp.id = p.id)  as cupon_ix,
          (select
          count(dt.dt_ix) as cnt
          from
          shop_product as sp
          inner join shop_product_delivery as pd on (sp.id = pd.pid and pd.is_wholesale = 'R')
          inner join shop_delivery_template as dt on (pd.dt_ix = dt.dt_ix)
          where
          sp.id = p.id
          and dt.delivery_policy = '1') as free_delivery,
          (
          SELECT count(*) as event_cnt
          FROM shop_event e , shop_event_product_relation epr
          where e.event_ix = epr.event_ix and epr.pid = p.id and e.disp = 1 and kind='P'
          and  ".time()." between event_use_sdate and event_use_edate
          and (mall_ix is null or mall_ix in ('','".$_SESSION['layout_config']['mall_ix']."'))
          ) as event_cnt
          from (".$sql.") p ";
         */

        if ($displayGoods[$i]['goods_display_type'] == "M") {
            //echo nl2br($sql)."<br><br>";
        }
        //exit;
        $slave_mdb->query($sql);
        $displayGoods[$i]['goods'] = $slave_mdb->fetchall();
        //echo($sql);
        //exit;
        $cssML                     = 'ml'.$displayGoods[$i]['display_type'];
        $cssType                   = 'type'.$displayGoods[$i]['display_type'];
        $imgType                   = 'ms';
        $noImg                     = 'noimg_'.$imgType.'.gif';

        $sql = "SELECT condition_price FROM shop_card_promotion WHERE NOW() > sdate and NOW() < edate AND disp = 1";

        $slave_mdb->query($sql);
        $noInterestData  = $slave_mdb->fetchall();
        $noInterestPrice = $noInterestData[0]['condition_price'];

        if ($noInterestPrice == null) {
            $noInterestPrice = PHP_INT_MAX;
        }

        if (is_array($displayGoods[$i]['goods'])) {
            if ($_SESSION["user"]["code"]) {
                $slave_mdb->query("SELECT pid FROM shop_wishlist where mid = '".$_SESSION["user"]["code"]."' ");
                $favorite_goods = $slave_mdb->getrows();
                $favorite_goods = $favorite_goods[0];
                //print_r($favorite_goods);
            }

            $products = $displayGoods[$i]['goods'];
            for ($j = 0; $j < count($products); $j++) {
                $_array_pid[]                               = $products[$j]['id'];
                $goods_infos[$products[$j]['id']]['pid']    = $products[$j]['id'];
                $goods_infos[$products[$j]['id']]['amount'] = $products[$j]['pcount'];
                $goods_infos[$products[$j]['id']]['cid']    = $products[$j]['cid'];
                $goods_infos[$products[$j]['id']]['depth']  = $products[$j]['depth'];
            }
            $discount_info = DiscountRult($goods_infos, $cid, $depth);
            $cnt           = 0;
            foreach ($displayGoods[$i]['goods'] as $key => $sub_array) {
                //if($key %
                $select_ = array("icons_list" => explode(";", $sub_array['icons']));
                array_insert($sub_array, 14, $select_);

                $sub_array['is_favorite'] = false;
                if (is_array($favorite_goods)) {
                    if (in_array($sub_array['id'], $favorite_goods)) {
                        $sub_array['is_favorite'] = true;
                    }
                }

                $discount_item = $discount_info[$sub_array['id']];
                //print_r($discount_item);
                $_dcprice      = $sub_array['sellprice'];
                if (is_array($discount_item)) {
                    foreach ($discount_item as $_key => $_item) {
                        if ($_item['discount_value_type'] == "1") { // %
                            //echo $_item[discount_value]."<br>";
                            $_dcprice = roundBetter($_dcprice * (100 - $_item['discount_value']) / 100, $_item['round_position'], $_item['round_type']); //$_dcprice*(100 - $_item[discount_value])/100;
                        } else if ($_item['discount_value_type'] == "2") {// 원
                            $_dcprice = $_dcprice - $_item['discount_value'];
                        }
                        //$discount_desc[] = $_item[discount_type]."-".$_item[discount_value]." ".($_item[discount_value_type] == "1" ? "%":"원")."-".$_dcprice."원";
                        $discount_desc[] = $_item; //array("discount_type"=>$_item[discount_type], "haddoffice_value"=>$_item[discount_value], "discount_value"=>$_item[discount_value], "discount_value"=>$_item[discount_value], "discount_value_type"=>$_item[discount_value_type], "_dcprice"=>$_dcprice);
                    }
                }

                $_dcprice = array("dcprice" => $_dcprice);

                array_insert($sub_array, 52, $_dcprice);
                $discount_desc = array("discount_desc" => $discount_desc);
                array_insert($sub_array, 53, $discount_desc);

                if ($noInterestPrice <= $_dcprice['dcprice']) {
                    $noInterest = 'Y';
                } else {
                    $noInterest = 'N';
                }
                $noInterest = array("noInterest" => $noInterest);
                array_insert($sub_array, 54, $noInterest);
                unset($discount_desc);

                $sub_array['cssML']   = $cssML;
                $sub_array['cssType'] = $cssType;
                $sub_array['noImg']   = $noImg;
                $sub_array['imgType'] = $imgType;
                if ($displayGoods[$i]['display_type'] == 2) {
                    $sub_array['imgType'] = 'm';
                } elseif ($displayGoods[$i]['display_type'] == 4) {
                    if ($cnt % 7 == 0) {
                        $sub_array['addHTML1'] = '<div style="clear:both;float:left;padding:0 0 0 0px;">';
                        $sub_array['addHTML2'] = '</div><div class="type4-2">';
                        $sub_array['imgType']  = 'b';
                        $sub_array['noImg']    = 'noimg_'.$sub_array['imgType'].'.gif';
                    } else {
                        $sub_array['cssType'] = 'type4-1';
                    }
                } elseif ($displayGoods[$i]['display_type'] == 6) {
                    if ($cnt % 6 < 2) {
                        //$sub_array['addHTML1']	= '</div><div class="good_names" style="width:420px;padding:0 10px;">';
                        //$sub_array['addHTML2']	= '</div><div style="float:left;width:50%;">';
                        $sub_array['imgType'] = 'b';
                        $sub_array['noImg']   = 'noimg_'.$sub_array['imgType'].'.gif';
                    } else {
                        $sub_array['cssML']   = 'ml6-1';
                        $sub_array['cssType'] = 'type6-1';
                    }
                }
                $displayGoods[$i]['goods'][$key] = $sub_array;
                $cnt++;
            }
        }
        unset($display_goods_cnt);
    }
    //print_r($displayGoods);
    //exit;
    return $displayGoods;
}

function getRecommendedKeyword()
{
    $db      = New Database;
    $sql     = "SELECT keyword  FROM shop_search_keyword
								WHERE 1=1
								  AND recommend = 1
								  AND searchcnt = (	SELECT MAX(searchcnt)
													  FROM shop_search_keyword
													 WHERE recommend = 1)
												  ORDER BY regdate DESC";
    $db->query($sql);
    $results = $db->fetchall();

    return ($results[0]['keyword']);
}

function getBasicSellerSetup($Shared_file)
{

    if (!$Shared_file) {
        return false;
    }

    global $_SESSION, $slave_mdb;

    $shmop = new Shared($Shared_file);

    if (sess_val("admininfo", "mall_data_root")) {
        $mall_data_root = $_SESSION["admininfo"]["mall_data_root"];
    } else if (sess_val("layout_config", "mall_data_root")) {
        $mall_data_root = sess_val("layout_config", "mall_data_root");
    } else {
        $sql            = "select mall_data_root from shop_shopinfo where mall_div = 'B'";
        $slave_mdb->query($sql);
        $slave_mdb->fetch();
        $mall_data_root = $slave_mdb->dt['mall_data_root'];
    }

    $shmop->filepath = DOCUMENT_ROOT.$mall_data_root."/_shared/";

    $shmop->SetFilePath();
    $reserve_data = $shmop->getObjectForKey($Shared_file);
    $reserve_data = unserialize(urldecode($reserve_data));

    return $reserve_data;
}

function getSharedInfo($Shared_file)
{
    global $_SESSION;

    if (!$Shared_file) {
        return false;
    }

    if (sess_val("admininfo", "mall_data_root")) {
        $mall_data_root = sess_val("admininfo", "mall_data_root");
    } else if (sess_val("layout_config", "mall_data_root")) {
        $mall_data_root = sess_val("layout_config", "mall_data_root");
    }

    $shmop = new Shared($Shared_file);
    if ($_SESSION["layout_config"]["mall_data_root"]) {
        $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$mall_data_root."/_shared/";
    } else {
        $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$mall_data_root."/_shared/";
    }
    $shmop->SetFilePath();
    $get_data = $shmop->getObjectForKey($Shared_file);
    $get_data = unserialize(urldecode($get_data));

    return $get_data;
}

function setSharedInfo($sharedName, $setData)
{
    global $_SESSION;

    if (!$setData) {
        return false;
    }


    $data = urlencode(serialize($setData));
    if ($_SESSION["admininfo"]["mall_data_root"]) {
        $mall_data_root = $_SESSION["admininfo"]["mall_data_root"];
    } else if ($_SESSION["layout_config"]["mall_data_root"]) {
        $mall_data_root = $_SESSION["layout_config"]["mall_data_root"];
    }
    $path = $_SERVER["DOCUMENT_ROOT"].$mall_data_root."/_shared/";
    //echo $path;
    if (!is_dir($path)) {
        mkdir($path, 0777);
        chmod($path, 0777);
    } else {
        chmod($path, 0777);
    }
    include_once($_SERVER["DOCUMENT_ROOT"]."/admin/logstory/class/sharedmemory.class");
    $shmop           = new Shared($sharedName);
    $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$mall_data_root."/_shared/";
    $shmop->SetFilePath();
    $shmop->setObjectForKey($data, $sharedName);
}

function GetSharedInfo_daiso($Shared_file)
{ //다이소 협력사 신청용 //관리자 미로그인시 세션이 없으므로 지정해줘야함 2014-06-10 이학봉
    global $_SESSION;

    if (!$Shared_file) {
        return false;
    }


    include_once($_SERVER["DOCUMENT_ROOT"]."/admin/logstory/class/sharedmemory.class");

    if ($_SESSION["admininfo"]["mall_data_root"]) {
        $mall_data_root = $_SESSION["admininfo"]["mall_data_root"];
    } else if ($_SESSION["layout_config"]["mall_data_root"]) {
        $mall_data_root = $_SESSION["layout_config"]["mall_data_root"];
    }

    $shmop           = new Shared($Shared_file);
    $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$mall_data_root."/_shared/";
    $shmop->SetFilePath();
    $reserve_data    = $shmop->getObjectForKey($Shared_file);
    $reserve_data    = unserialize(urldecode($reserve_data));

    return $reserve_data;
}

function set_order_status($oid, $status, $status_message, $admin_message, $company_id, $od_ix = "", $pid = "", $reason_code = "", $quick = "",
                          $deliverycode = "", $c_type = "")
{
    global $master_db;

    if ($reason_code != "" && $c_type == "") {
        if ($_SESSION['admininfo']["mem_type"] == "A") {
            $c_type = "M";
        } elseif (!empty($_SESSION['admininfo']['code'])) {
            $c_type = "S";
        } else {
            $c_type = "B";
        }
    }

    if (substr_count($_SERVER['PHP_SELF'], '/admin/') > 0) {
        $data_channel = "2"; //백오피스
    } else {
        $data_channel = "1"; //프론트
    }

    $master_db->sequences = "SHOP_ORDER_STATUS_SEQ";
    $master_db->query("insert into ".TBL_SHOP_ORDER_STATUS." (os_ix, oid, od_ix, pid, status, status_message, admin_message, company_id, quick, invoice_no, reason_code, c_type, data_channel, regdate ) values ('','$oid','$od_ix','$pid','$status','$status_message','$admin_message','$company_id','$quick','$deliverycode','$reason_code','$c_type','$data_channel',NOW())");
}

//날짜검색 공용함수 이학봉 추가
/*
  $sdate_name : 시작날짜 input name	이 값을 기준으로 시,분,초 name 과 id 생성
  $edate_name : 마감날짜 input name
  $basic_sdate : 시작날짜 기본값
  $basic_edate : 마감날짜 기본값
  $use_time	: 시간사용시 Y 값을 넘김
 */
function template_search_date($sdate_name, $edate_name, $basic_sdate = '', $basic_edate = '', $use_time = '', $oneside = false)
{


    global $_LANGUAGE;
    global $_SESSION;

    $vdate        = date("Y-m-d", time());
    $today        = date("Y-m-d", time());
    $vyesterday   = date("Y-m-d", time() - 86400);
    $voneweekago  = date("Y-m-d", time() - 86400 * 7);
    $v15ago       = date("Y-m-d", time() - 86400 * 15);
    $vonemonthago = date("Y-m-d", mktime(0, 0, 0, substr($vdate, 5, 2) - 1, substr($vdate, 8, 2) + 1, substr($vdate, 0, 4)));
    $v2monthago   = date("Y-m-d", mktime(0, 0, 0, substr($vdate, 5, 2) - 2, substr($vdate, 8, 2) + 1, substr($vdate, 0, 4)));
    $v3monthago   = date("Y-m-d", mktime(0, 0, 0, substr($vdate, 5, 2) - 3, substr($vdate, 8, 2) + 1, substr($vdate, 0, 4)));

    $v6monthago  = date("Y-m-d", mktime(0, 0, 0, substr($vdate, 5, 2) - 6, substr($vdate, 8, 2) + 1, substr($vdate, 0, 4)));
    $v12monthago = date("Y-m-d", mktime(0, 0, 0, substr($vdate, 5, 2) - 12, substr($vdate, 8, 2) + 1, substr($vdate, 0, 4)));

    $basic_sdate_array = explode(" ", $basic_sdate); //넘어온값에 시간이 붙어잇을경우 짤라서 시간을 따로 변수에 담아둠
    $basic_sdate_ymd   = $basic_sdate_array[0];

    $basic_edate_array = explode(" ", $basic_edate); //넘어온값에 시간이 붙어잇을경우 짤라서 시간을 따로 변수에 담아둠
    $basic_edate_ymd   = $basic_edate_array[0];

    if ($use_time == 'Y') { //시 까지 사용할경우 처리
        if ($basic_sdate_array[1]) {
            $start_time_h = strftime('%H', strtotime($basic_sdate));
            $start_time_i = strftime('%M', strtotime($basic_sdate));
            $start_time_s = strftime('%S', strtotime($basic_sdate));
        }

        if ($basic_edate_array[1]) {
            $end_time_h = strftime('%H', strtotime($basic_edate));
            $end_time_i = strftime('%M', strtotime($basic_edate));
            $end_time_s = strftime('%S', strtotime($basic_edate));
        }

        $start_time_select = "<select name='".$sdate_name."_h' id='".$sdate_name."_h'>";
        for ($i = 0; $i < 24; $i++) {
            $start_time_select .= "<option value='".$i."' ".($start_time_h == $i ? 'selected' : '').">".$i."</option>";
        }
        $start_time_select .= "</select> 시";

        $start_time_select .= "<select name='".$sdate_name."_i' id='".$sdate_name."_i'>";
        for ($i = 1; $i < 60; $i++) {
            $start_time_select .= "<option value='".$i."' ".($start_time_i == $i ? 'selected' : '').">".$i."</option>";
        }
        $start_time_select .= "</select> 분";

        $start_time_select .= "<select name='".$sdate_name."_s' id='".$sdate_name."_s'>";
        for ($i = 1; $i < 60; $i++) {
            $start_time_select .= "<option value='".$i."' ".($start_time_s == $i ? 'selected' : '').">".$i."</option>";
        }
        $start_time_select .= "</select> 초";


        $end_time_select = "<select name='".$edate_name."_h' id='".$edate_name."_h'>";
        for ($i = 0; $i < 24; $i++) {
            $end_time_select .= "<option value='".$i."' ".($end_time_h == $i ? 'selected' : '').">".$i."</option>";
        }
        $end_time_select .= "</select> 시";

        $end_time_select .= "<select name='".$edate_name."_i' id='".$edate_name."_i'>";
        for ($i = 1; $i < 60; $i++) {
            $end_time_select .= "<option value='".$i."' ".($end_time_i == $i ? 'selected' : '').">".$i."</option>";
        }
        $end_time_select .= "</select> 분";

        $end_time_select .= "<select name='".$edate_name."_s' id='".$edate_name."_s'>";
        for ($i = 1; $i < 60; $i++) {
            $end_time_select .= "<option value='".$i."' ".($end_time_s == $i ? 'selected' : '').">".$i."</option>";
        }
        $end_time_select .= "</select> 초";
    }

    $Contents .= "
		<span>
			<span>
				<input type='text' id='".$sdate_name."' name='".$sdate_name."' value='".$basic_sdate_ymd."' style='width:65px;' class='date-pick inputbox_05 font-en' />
			</span>
			<span>
				<input type='text' id='".$edate_name."' name='".$edate_name."' value='".$basic_edate_ymd."' style='width:65px;' class='date-pick inputbox_05 font-en' />
			</span>
		</span>

				<div class='jq-radio'>
					<a href=\"javascript:".$sdate_name."('$today','$today',1);\" onFocus='this.blur();'class='btn_date today'>"
        .getLanguageText('e1e8a7b4021650c6fbad08d9088dcd69').
        "</a>
					";

    if (!$oneside) {
        $Contents .= "<a href=\"javascript:".$sdate_name."('$voneweekago','$today',1);\" onFocus='this.blur();'class='btn_date'>"
            .getLanguageText('50c63d30b6d77cb58a8d48629b57fe01').
            "</a>
					";
    }

    $Contents .= "<a href=\"javascript:".$sdate_name."('$vonemonthago','$today', 1);\" onFocus='this.blur();'class='btn_date'>"
        .getLanguageText('df140b9da555206ce88221bdb443cb0a').
        "</a>
					<a href=\"javascript:".$sdate_name."('$v6monthago','$today',1);\" onFocus='this.blur();'class='btn_date'>"
        .getLanguageText('2b3997b1d85897c1f361801ee64badef').
        "</a>
					<a href=\"javascript:".$sdate_name."('$v12monthago','$today',1);\" onFocus='this.blur();' class='btn_date'>"
        .getLanguageText('3d5bb6802bf417e31fe7d7a8b2410d82').
        "</a>
				</div>

		<script type='text/javascript'>
		<!--
		function ".$sdate_name."(FromDate,ToDate,dType) {
			var frm = document.search_frm;
			$('#".$sdate_name."').val(FromDate);
			$('#".$edate_name."').val(ToDate);
		}

		$(document).ready(function (){
			$('#".$sdate_name."').datepicker({
				//changeMonth: true,
				//changeYear: true,
				monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
				dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				showMonthAfterYear:true,
				dateFormat: 'yy-mm-dd',
				buttonImageOnly: true,
				buttonText: '달력',
				//prevText: '先月',
				//nextText: '来月',
				//currentText: '今日',
				//monthNames: ['年 1月','年 2月','年 3月','年 4月','年 5月','年 6月','年 7月','年 8月','年 9月','年 10月','年 11月','年 12月'],
				//monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
				//dayNames: ['日','月','火','水','木','金','土'],
				//dayNamesShort: ['日','月','火','水','木','金','土'],
				//dayNamesMin: ['日','月','火','水','木','金','土'],
				//weekHeader: 'Wk',
				//dateFormat: 'yy-mm-dd',
				//firstDay: 0,
				//isRTL: false,
				//showMonthAfterYear: true,
				//yearSuffix: '',

				onSelect: function(dateText, inst){
					if($('#".$edate_name."').val() != '' && $('#".$edate_name."').val() <= dateText){
						$('#".$edate_name."').val(dateText);
					}else{
						$('#".$edate_name."').datepicker('setDate','+0d');
					}
				}
			});

			$('#".$edate_name."').datepicker({
				//changeMonth: true,
				//changeYear: true,
				monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
				dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				showMonthAfterYear:true,
				dateFormat: 'yy-mm-dd',
				buttonImageOnly: true,
				buttonText: '달력',
//				prevText: '先月',
//				nextText: '来月',
//				currentText: '今日',
//				monthNames: ['年 1月','年 2月','年 3月','年 4月','年 5月','年 6月','年 7月','年 8月','年 9月','年 10月','年 11月','年 12月'],
//				monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
//				dayNames: ['日','月','火','水','木','金','土'],
//				dayNamesShort: ['日','月','火','水','木','金','土'],
//				dayNamesMin: ['日','月','火','水','木','金','土'],
//				weekHeader: 'Wk',
//				dateFormat: 'yy-mm-dd',
//				firstDay: 0,
//				isRTL: false,
//				showMonthAfterYear: true,
//				yearSuffix: '',

			});
		});
		//-->
		</script>
	";

    return $Contents;
}

function get_category_display($cid, $search, $search_type = "")
{
    global $slave_mdb;
    //$slave_mdb= new Database;
    $script_times["category_display_".$cid."_".$search."_start_".rand()] = time();
    //$where = " and cmd.cid='".$cid."' ";

    if ($cid) {
        $where = " and cmg.display_cid='".$cid."' ";
    }

    if ($search_type == "code") {
        $where .= " and cmg.display_position = '".$search."' ";
    }

    $sql                                                              = "select
						cmpg.*,
						cmd.*,
						cmg.display_position as goods_code,
						cmg.cmg_title
					from
						shop_category_main_goods cmg ,
						shop_category_main_product_group cmpg ,
						shop_category_main_div cmd
					where
						cmg.cmg_ix = cmpg.cmg_ix
						and cmpg.div_ix = cmd.div_ix
						and cmpg.use_yn = 'Y'
						and cmg.disp='1' ".$where."
					order by group_code asc ";
    //echo nl2br($sql);
    //exit;
    $slave_mdb->query($sql);
    $script_times["category_display_".$cid."_".$search."_end".rand()] = time();
    return $slave_mdb->fetchall();
}

function get_category_display2($cid, $search, $search_type = "")
{
    global $slave_mdb;
    //$slave_mdb= new Database;
    $script_times["category_display_".$cid."_".$search."_start_".rand()] = time();
    //$where = " and cmd.cid='".$cid."' ";
    $where                                                               = " and cmg.display_cid like '".substr($cid, 0, 3)."%' ";

    if ($search_type == "code") {
        $where .= " and cmg.display_position = '".$search."' ";
    }

    $sql                                                              = "select cmpg.*, cmd.*,cmg.display_position as goods_code,cmg.cmg_title
				from shop_category_main_goods cmg , shop_category_main_product_group cmpg , shop_category_main_div cmd
				where cmg.cmg_ix = cmpg.cmg_ix and cmpg.div_ix = cmd.div_ix and cmpg.use_yn = 'Y' and cmg.disp='1' ".$where."
				order by group_code asc ";
    //echo nl2br($sql);
    //exit;
    $slave_mdb->query($sql);
    $script_times["category_display_".$cid."_".$search."_end".rand()] = time();
    return $slave_mdb->fetchall();
}

function get_group_category_display($cmpg_ix)
{
    global $slave_mdb;
    //$slave_mdb= new Database;

    $sql = "select cmgd.* , dt.dt_ix, dt.dt_name, dt.dt_goods_num
					from shop_category_main_group_display cmgd
					left join shop_display_templetinfo dt on cmgd.display_type = dt.dt_ix
					where cmgd.cmpg_ix = '".$cmpg_ix."'
					order by cmgd.vieworder asc
					 ";

    //echo $sql."<br><br>";
    $slave_mdb->query($sql);
    $display_groups = $slave_mdb->fetchall();
    //print_r($display_groups);
    $x              = 0;
    for ($i = 0; $i < $slave_mdb->total; $i++) {
        $slave_mdb->fetch($i);
        for ($j = 0; $j < $slave_mdb->dt['set_cnt']; $j++) {
            $_display_groups[$x]['egd_ix']       = $slave_mdb->dt['egd_ix'];
            $_display_groups[$x]['display_type'] = $slave_mdb->dt['display_type'];
            $_display_groups[$x]['dt_goods_num'] = $slave_mdb->dt['dt_goods_num'];
            $x++;
        }
    }

    return $_display_groups;
}

//get_display_goods
function get_display_goods($cmg_ix, $group_code, $display_goods_type = "M", $goods_display_sub_type = "")
{
    global $orderby, $reserve_sql, $layout_config;
    global $script_times;
    global $slave_mdb;

    //$slave_mdb= new Database;

    $sql      = "select display_info_type, product_cnt, display_auto_type, IFNULL(display_auto_priod,7) as display_auto_priod from shop_category_main_product_group where cmg_ix='".$cmg_ix."' and group_code='".$group_code."'  ";
    //if($cmg_ix == 105 && $group_code == 1){
    //echo nl2br($sql);
    //exit;
    //}
    $slave_mdb->query($sql);
    $cmg_info = $slave_mdb->fetch();


    //echo "display_info_type:".$cmg_info[display_info_type];
    if ($cmg_info['display_info_type'] == "B") {
        if ($cmg_info['product_cnt'] != "" && $cmg_info['product_cnt'] > 0) {
            $limit = " limit 0,".$cmg_info['product_cnt'];
        } else {
            $limit = "";
        }

        $sql                = "select b.b_ix, b.brand_name
						from shop_category_main_product_group pg
						right join shop_category_main_brand_relation br on pg.cmg_ix = br.cmg_ix and pg.group_code = br.group_code and pg.use_yn = 'Y'
						right join shop_brand b on br.b_ix = b.b_ix
						where pg.cmg_ix = '".$cmg_ix."'
						and pg.group_code='$group_code' and b.disp = 1
						and pg.use_yn = 'Y'
						order by vieworder asc ".$limit."";
        //echo nl2br($sql);
        $slave_mdb->query($sql);
        $event_groups_goods = $slave_mdb->fetchall();
    } else {
        if ($display_goods_type == "M") {
            $orderby_str = "e.vieworder asc";
        } else {
            $nowdate = date('Y-m-d 00:00:00');


            if ($cmg_info['display_auto_type'] == "order_cnt") {//구매순
                if ($cmg_info['display_auto_priod'] != "") {

                    //$select_str=", order_buy_cnt ";
                    //$select_leftjoin_str=" left join (select pid, sum(pcnt) as order_buy_cnt from shop_order_detail od where   od.status not in ('".ORDER_STATUS_SETTLE_READY."','".ORDER_STATUS_REPAY_READY."','".ORDER_STATUS_EXCHANGE_COMPLETE."','".ORDER_STATUS_EXCHANGE_AGAIN_DELIVERY."') and od.regdate between DATE_SUB('".$nowdate."', INTERVAL ".$cmg_info[display_auto_priod]." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY) group by pid ) od on od.pid=p.id ";
                    //$orderby_str = "order_buy_cnt desc";
                    $orderby_str = "pa.order_cnt_".$cmg_info['display_auto_priod']." desc";
                    $index_str   = "order_cnt_".$cmg_info['display_auto_priod']."_desc";
                } else {
                    $orderby_str = "p.order_cnt desc";
                    $index_str   = "order_cnt_1";
                }
            } elseif ($cmg_info['display_auto_type'] == "view_cnt") {//클릭순
                if ($cmg_info['display_auto_priod'] != "") {
                    //$select_str=", com_view_cnt";
                    //$select_leftjoin_str=" left join (select pid, sum(nview_cnt) as com_view_cnt from commerce_viewingview cv where   cv.vdate between date_format(DATE_SUB('".$nowdate."', INTERVAL ".$cmg_info[display_auto_priod]." DAY),'%Y%m%d')  and  date_format(DATE_SUB('".$nowdate."', INTERVAL 1 DAY),'%Y%m%d') group by pid ) od on od.pid=p.id  ";
                    //$orderby_str = "com_view_cnt desc";
                    $orderby_str = "pa.view_cnt_".$cmg_info['display_auto_priod']." desc";
                    $index_str   = "view_cnt_".$cmg_info['display_auto_priod']."_desc";
                } else {
                    $orderby_str = "p.view_cnt desc";
                    $index_str   = "view_cnt_desc";
                }
            } elseif ($cmg_info['display_auto_type'] == "sellprice") {//최저가순
                if ($layout_config['mall_type'] == 'BW') {
                    $order_select_price = 'p.wholesale_price';
                } else {
                    $order_select_price = 'p.sellprice';
                }
                $orderby_str = " $order_select_price asc";
                if ($cmg_info['display_auto_priod'] != "") {
                    $priod_where = " and p.regdate between DATE_SUB('".$nowdate."', INTERVAL ".$cmg_info['display_auto_priod']." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY) ";
                }
            } elseif ($cmg_info['display_auto_type'] == "regdate") {
                $orderby_str = "p.regdate_desc asc";
            } elseif ($cmg_info['display_auto_type'] == "wish_cnt") {

                if ($cmg_info['display_auto_priod'] != "") {
                    //$select_str=", list_wish_cnt";
                    //$select_leftjoin_str=" left join (select pid, count(*) as list_wish_cnt from shop_wishlist w where  w.regdate between date_format(DATE_SUB('".$nowdate."', INTERVAL ".$cmg_info[display_auto_priod]." DAY),'%Y-%m-%d')  and  date_format(DATE_SUB('".$nowdate."', INTERVAL 1 DAY),'%Y-%m-%d') group by pid ) od on od.pid=p.id ";
                    //$orderby_str = "list_wish_cnt desc";
                    $orderby_str = "pa.wish_cnt_".$cmg_info['display_auto_priod']." desc";
                    $index_str   = "wish_cnt_".$cmg_info['display_auto_priod']."_desc";
                } else {
                    $orderby_str = "p.wish_cnt desc";
                    $index_str   = "wish_cnt_1";
                }
            } elseif ($cmg_info['display_auto_type'] == "after_score") {
                if ($cmg_info['display_auto_priod'] != "") {
                    //$select_str=", avg_after_score ";
                    /* $select_leftjoin_str=" left join (
                      select pid , avg(avg_after_score) as avg_after_score from (
                      select bbs_etc1 as pid, avg(valuation_goods+valuation_goods_info+valuation_delivery+valuation_package) as avg_after_score from bbs_after a where regdate between DATE_SUB('".$nowdate."', INTERVAL ".$cmg_info[display_auto_priod]." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY)
                      union all
                      select bbs_etc1 as pid , avg(valuation_goods+valuation_goods_info+valuation_delivery+valuation_package) as avg_after_score from bbs_premium_after a where regdate between DATE_SUB('".$nowdate."', INTERVAL ".$cmg_info[display_auto_priod]." DAY)  and  DATE_SUB('".$nowdate."', INTERVAL 1 DAY)
                      ) od
                      group by pid
                      ) od2 on od2.pid=p.id "; */
                    //$orderby_str = "avg_after_score desc";
                    $orderby_str = "pa.after_score_".$cmg_info['display_auto_priod']." desc";
                    $index_str   = "after_score_".$cmg_info['display_auto_priod']."_desc";
                } else {
                    $orderby_str = "p.after_score desc";
                    $index_str   = "after_score_1";
                }
            }
        }
        //echo $select_leftjoin_str;
        if ($cmg_info['product_cnt'] != "" && $cmg_info['product_cnt'] > 0) {
            $limit = " limit 0,".$cmg_info['product_cnt'];
        } else {
            $limit = " limit 100";
        }

        if (UserSellingType() == 'W') {
            $select_price = 'wholesale_price as listprice, wholesale_sellprice as sellprice, sellprice AS ori_sellprice , pa.wholesale_free_delivery_yn as free_delivery_yn ';
        } else {
            $select_price = 'sellprice, listprice , pa.free_delivery_yn as free_delivery_yn';
        }


        if ($display_goods_type == "M") {
            $sql = "select p.id,p.product_type, p.pname,p.stock,p.stock_use_yn,p.sell_priod_sdate,p.order_cnt, p.sell_priod_edate,p.brand,p.admin, $select_price, p.shotinfo, pa.use_coupon_yn, icons $reserve_sql $select_str
						,case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new
						from shop_category_main_product_group pg
						right join shop_category_main_product_relation e on pg.cmg_ix = e.cmg_ix and pg.group_code = e.group_code and pg.use_yn = 'Y'
						right join ".TBL_SHOP_PRODUCT." p on e.pid = p.id
						left join shop_product_addinfo pa  ".($index_str ? "USE INDEX FOR ORDER BY (".$index_str.")" : "")." on p.id=pa.pid
						where pg.cmg_ix = '$cmg_ix'
						and pg.group_code='$group_code'  and p.state =1 and p.disp = 1
						and pg.use_yn = 'Y'
						".(($index_str == "" && $orderby_str) ? "order by ".$orderby_str."" : "")."
						".$limit."
						"; //
            //r.cid,
            //right join shop_product_relation r on r.pid = e.pid
            // , and r.basic = 1
        } else {
            if ($goods_display_sub_type == "C") {

                $sql = "SELECT ci.cid, ci.depth
								FROM shop_category_main_category_relation mcr , shop_category_info ci
								where mcr.cid = ci.cid and mcr.group_code='".$group_code."'  and mcr.cmg_ix = '".$cmg_ix."' and  mcr.insert_yn ='Y'
								ORDER BY vieworder ASC"; //div_code = '".$div_code."' and

                $slave_mdb->query($sql);
                $cateRelation = $slave_mdb->fetchall();


                if (is_array($cateRelation)) {
                    $cidNo   = 0;
                    $cid_str = "";
                    foreach ($cateRelation as $_keys => $_values) {
                        if ($cidNo > 0) $cid_str .= " OR ";
                        //$cid_str .= " LEFT(r.cid,".(($_values[depth]+1)*3).") = '".substr($_values[cid],0,($_values[depth]+1)*3)."' ";
                        $cid_str .= " r.cid LIKE '".substr($_values['cid'], 0, ($_values['depth'] + 1) * 3)."%' ";
                        $cidNo++;
                    }
                    if ($cid_str != "") $goods_display_sub_type_where = " and (".$cid_str.") ";
                }

                $sql = "select p.id,p.pname,p.product_color_chip,p.stock,p.stock_use_yn,p.sell_priod_sdate,p.order_cnt, p.sell_priod_edate,p.brand,r.cid,p.admin, $select_price, p.shotinfo, icons ".$reserve_sql." ".$select_str."
							,case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new
							from ".TBL_SHOP_PRODUCT." p
							right join shop_product_addinfo pa ".($index_str ? "USE INDEX FOR ORDER BY (".$index_str.")" : "")." on p.id=pa.pid
							right join shop_product_relation r on r.pid = p.id
							".$select_leftjoin_str."
							where p.state =1 and p.disp = 1 and r.basic = 1
							".$goods_display_sub_type_where." ".$priod_where."
							".(($index_str == "" && $orderby_str) ? "order by ".$orderby_str."" : "")."
							".$limit."
							"; //order by ".$orderby_str." ".$limit."
                //echo $sql;
            }else if ($goods_display_sub_type == "B") {
                $sql = "SELECT b_ix
								FROM shop_category_main_brand_relation mbr
								where mbr.group_code='".$group_code."'  and mbr.cmg_ix = '".$cmg_ix."' and  mbr.insert_yn ='Y'  and relation_type = 'A'
								 "; //div_code = '".$div_code."' and
                //$slave_mdb->query($sql);

                if ($sql != "") $goods_display_sub_type_where = " and p.brand in (".$sql.") ";
                $sql                          = "select p.id,p.pname,p.product_color_chip,p.stock,p.stock_use_yn,p.sell_priod_sdate, p.order_cnt, p.sell_priod_edate,p.brand,p.admin, $select_price, p.shotinfo, icons ".$reserve_sql." ".$select_str."
								,case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new
								from ".TBL_SHOP_PRODUCT." p
								right join shop_product_addinfo pa ".($index_str ? "USE INDEX FOR ORDER BY (".$index_str.")" : "")." on p.id=pa.pid

								".$select_leftjoin_str."
								where  p.state =1 and p.disp = 1 and
								".$goods_display_sub_type_where." ".$priod_where."
								".(($index_str == "" && $orderby_str) ? "order by ".$orderby_str."" : "")."
								".$limit."
								"; //order by ".$orderby_str." ".$limit."
                //r.cid,
                //right join shop_product_relation r on r.pid = p.id
                // r.basic = 1
            }else if ($goods_display_sub_type == "S") {
                $sql = "SELECT company_id
								FROM shop_category_main_seller_relation msr
								where msr.group_code='".$group_code."'  and msr.cmg_ix = '".$cmg_ix."' and  msr.insert_yn ='Y'
								 "; //div_code = '".$div_code."' and
                //$slave_mdb->query($sql);

                if ($sql != "") $goods_display_sub_type_where = " and p.admin in (".$sql.") ";
                $sql                          = "select p.id,p.pname,p.product_color_chip,p.stock,p.stock_use_yn,p.sell_priod_sdate,p.sell_priod_edate, p.order_cnt, p.brand,p.admin, $select_price, p.shotinfo, icons ".$reserve_sql." ".$select_str."
								,case when date_sub(NOW(), INTERVAL 7 DAY) < p.regdate then 1 else 0 end as is_new
								from ".TBL_SHOP_PRODUCT." p
								right join shop_product_addinfo pa ".($index_str ? "USE INDEX FOR ORDER BY (".$index_str.")" : "")." on p.id=pa.pid
								".$select_leftjoin_str."
								where  p.state =1 and p.disp = 1
								".$goods_display_sub_type_where." ".$priod_where."
								".(($index_str == "" && $orderby_str) ? "order by ".$orderby_str."" : "")."
								".$limit."
								"; //order by ".$orderby_str." ".$limit."
                //r.cid,
                //right join shop_product_relation r on r.pid = p.id
                // r.basic = 1
            }
        }
        /*
          $sql = "select p.* ,
          (select count(*) as user_after_valuation  FROM bbs_after  where bbs_etc1 = p.id) as user_after_valuation,
          (select cp.cupon_ix
          from
          shop_cupon c
          join shop_cupon_publish cp
          join shop_cupon_relation_product crp
          join shop_product sp
          where
          c.cupon_ix = cp.cupon_ix and cp.use_product_type = 3 and sp.id = crp.pid and cp.publish_ix = crp.publish_ix and cp.publish_type = 2
          and ((cp.use_date_type!='9' AND '".date("Ymd")."' between date_format(cp.use_sdate,'%Y%m%d') and date_format(cp.use_edate,'%Y%m%d')) OR cp.use_date_type = 9 OR cp.use_date_type = 2)
          and cp.disp='1' and sp.coupon_use_yn='Y'
          and cp.use_date_type <> '9' and cp.publish_condition_price <= sp.sellprice  and sp.id = p.id)  as cupon_ix,
          (select
          count(dt.dt_ix) as cnt
          from
          shop_product as sp
          inner join shop_product_delivery as pd on (sp.id = pd.pid and pd.is_wholesale = 'R')
          inner join shop_delivery_template as dt on (pd.dt_ix = dt.dt_ix)
          where
          sp.id = p.id
          and dt.delivery_policy = '1') as free_delivery,
          (
          SELECT count(*) as event_cnt
          FROM shop_event e , shop_event_product_relation epr
          where e.event_ix = epr.event_ix and epr.pid = p.id and e.disp = 1 and kind='P'
          and  ".time()." between event_use_sdate and event_use_edate
          and (mall_ix is null or mall_ix in ('','".$_SESSION['layout_config']['mall_ix']."'))
          ) as event_cnt
          from (".$sql.") p ";
         */
        //echo $sql;
        //echo $goods_display_sub_type."<br><br>";
        //echo nl2br($sql);
        $script_times["display_goods_".$cmg_ix."_".$group_code."_".$display_goods_type."_".$goods_display_sub_type."_start_".rand()] = time();
        //if($cmg_ix == 105 && $group_code == 1){
        //echo nl2br($sql);
        $script_times["display_goods_".$cmg_ix."_".$group_code."_".$display_goods_type."_".$goods_display_sub_type."_sql_".rand()]   = $sql;
        //}
        $slave_mdb->query($sql);
        $event_groups_goods                                                                                                          = $slave_mdb->fetchall();
        $script_times["display_goods_".$cmg_ix."_".$group_code."_".$display_goods_type."_".$goods_display_sub_type."_end_".rand()]   = time();
        //print_r($event_groups_goods);


        if (is_array($event_groups_goods)) {
            if ($_SESSION["user"]["code"]) {
                $slave_mdb->query("SELECT pid FROM shop_wishlist where mid = '".$_SESSION["user"]["code"]."' ");
                $favorite_goods = $slave_mdb->getrows();
                $favorite_goods = $favorite_goods[0];
                //print_r($favorite_goods);
            }

            $script_times["display_goods_discount_".$cmg_ix."_".$group_code."_start_".rand()] = time();

            $products = $event_groups_goods;
            for ($j = 0; $j < count($products); $j++) {
                $_array_pid[]                               = $products[$j]['id'];
                $goods_infos[$products[$j]['id']]['pid']    = $products[$j]['id'];
                $goods_infos[$products[$j]['id']]['amount'] = $products[$j]['pcount'];
                $goods_infos[$products[$j]['id']]['cid']    = $products[$j]['cid'];
                $goods_infos[$products[$j]['id']]['depth']  = $products[$j]['depth'];
            }
            $script_times["display_goods_discount_function_".$cmg_ix."_".$group_code."_start_".rand()] = time();
            //$script_times["display_goods_discount_function_".$cmg_ix."_".$group_code."_count_".rand()] = count($goods_infos);
            //$script_times["display_goods_discount_function_".$cmg_ix."_".$group_code."_limit_".rand()] = $limit;
            $discount_info                                                                             = DiscountRult($goods_infos, $cid, $depth);
            $script_times["display_goods_discount_function_".$cmg_ix."_".$group_code."_end_".rand()]   = time();

            $cnt = 0;
            foreach ($event_groups_goods as $_key => $_val) {

                $select_             = array("icons_list" => explode(";", $_val['icons']));
                array_insert($_val, 14, $select_);
                $_val['is_favorite'] = false;
                if (is_array($favorite_goods)) {
                    if (in_array($_val['id'], $favorite_goods)) {
                        $_val['is_favorite'] = true;
                    }
                }

                $discount_item = $discount_info[$_val['id']];
                //print_r($discount_item);
                $_dcprice      = $_val['sellprice'];
                if (is_array($discount_item)) {
                    foreach ($discount_item as $_key => $_item) {
                        if ($_item['discount_value_type'] == "1") { // %
                            //echo $_item[discount_value]."<br>";
                            $_dcprice = roundBetter($_dcprice * (100 - $_item['discount_value']) / 100, $_item['round_position'], $_item['round_type']); //$_dcprice*(100 - $_item[discount_value])/100;
                        } else if ($_item['discount_value_type'] == "2") {// 원
                            $_dcprice = $_dcprice - $_item['discount_value'];
                        }
                        //$discount_desc[] = $_item[discount_type]."-".$_item[discount_value]." ".($_item[discount_value_type] == "1" ? "%":"원")."-".$_dcprice."원";
                        $discount_desc[] = $_item; //array("discount_type"=>$_item[discount_type], "haddoffice_value"=>$_item[discount_value], "discount_value"=>$_item[discount_value], "discount_value"=>$_item[discount_value], "discount_value_type"=>$_item[discount_value_type], "_dcprice"=>$_dcprice);
                    }
                }
                $_dcprice      = array("dcprice" => $_dcprice);
                array_insert($_val, 52, $_dcprice);
                $discount_desc = array("discount_desc" => $discount_desc);
                array_insert($_val, 53, $discount_desc);
                unset($discount_desc);

                $event_groups_goods[$cnt]            = $_val;
                $event_groups_goods[$cnt]['cssML']   = 'ml'.$display_type;
                $event_groups_goods[$cnt]['cssType'] = 'type'.$display_type;
                $event_groups_goods[$cnt]['imgType'] = 'ms';
                $event_groups_goods[$cnt]['noImg']   = 'noimg_'.$event_groups_goods[$cnt]['imgType'].'.gif';

                if ($display_type == 2) {
                    $event_groups_goods[$cnt]['imgType'] = 'm';
                } elseif ($display_type == 4) {
                    if ($cnt % 7 == 0) {
                        $event_groups_goods[$cnt]['addHTML1'] = '<div style="clear:both;float:left;padding:0 0 0 0px;">';
                        $event_groups_goods[$cnt]['addHTML2'] = '</div><div class="type4-2">';
                        $event_groups_goods[$cnt]['imgType']  = 'b';
                        $event_groups_goods[$cnt]['noImg']    = 'noimg_'.$event_groups_goods[$cnt]['imgType'].'.gif';
                    } else {
                        $event_groups_goods[$cnt]['cssType'] = 'type4-1';
                    }
                } elseif ($display_type == 6) {
                    if ($cnt % 6 < 2) {
                        //$event_groups_goods[$cnt]['addHTML1']	= '</div><div class="good_names" style="width:420px;padding:0 10px;">';
                        //$event_groups_goods[$cnt]['addHTML2']	= '</div><div style="float:left;width:50%;">';
                        $event_groups_goods[$cnt]['imgType'] = 'b';
                        $event_groups_goods[$cnt]['noImg']   = 'noimg_'.$event_groups_goods[$cnt]['imgType'].'.gif';
                    } else {
                        $event_groups_goods[$cnt]['cssML']   = 'ml6-1';
                        $event_groups_goods[$cnt]['cssType'] = 'type6-1';
                    }
                }
                $cnt++;
            }
            $script_times["display_goods_discount_".$cmg_ix."_".$group_code."_end_".rand()] = time();
        }
    }
    return $event_groups_goods;
}

//나만을 위한 추천상품
function personalization_recommend_goods($cid, $depth)
{
    global $shop_product_type;
    global $slave_mdb;
    //$slave_mdb= new Database;
    //키워드및 나만을 위한 추천상품에 대한 데이터가 없으면 해당 카테고리의 구매를 많이한 수부터 뿌려준다
    if (UserSellingType() == 'W') {
        $select_price = 'wholesale_price as listprice, wholesale_sellprice as sellprice, sellprice AS ori_sellprice, (wholesale_price-wholesale_sellprice)/wholesale_price*100 as sale_rate ,  (listprice-sellprice)/listprice*100 as b2c_sale_rate  ';
    } else {
        $select_price = 'sellprice, listprice, (listprice-sellprice)/listprice*100 as sale_rate ';
    }
    if (is_mobile()) {
        $is_mobile_use_where = " and p.is_mobile_use in ('A','M')";
    } else {
        $is_mobile_use_where = " and p.is_mobile_use in ('A','W')";
    }
    $sql = "select
						HIGH_PRIORITY distinct p.id ,
						p.*
					from
						(SELECT
							p.id, p.pcode,
							p.pname ,p.brand_name,
							p.shotinfo, p.state,
							p.company, p.admin,
							$depth as depth ,
							p.stock, p.stock_use_yn,
							case when state = 0 then convert(vieworder, SIGNED)-1000000 else vieworder end  as vieworder2,
							$select_price ,
							icons,
							reserve_yn,
							option_kind,
							p.is_sell_date,
							p.sell_priod_sdate,
							p.sell_priod_edate
						FROM
							".TBL_SHOP_PRODUCT." p force index(regdate_desc)
							right join ".TBL_SHOP_PRODUCT_RELATION." r on p.id = r.pid and r.cid LIKE '".substr($cid, 0, ($depth + 1) * 3)."%'
							right join ".TBL_SHOP_CATEGORY_INFO." c on r.cid = c.cid and category_use ='1'
							left join ".TBL_SHOP_PRODUCT_OPTIONS." po on p.id = po.pid and po.option_use = '1'  and po.option_kind in ('x','x2','s2')
						where
								p.id = r.pid and r.cid LIKE '".substr($cid, 0, ($depth + 1) * 3)."%'
								and p.disp in ('1','3')  and p.state in ('0','1')
								and product_type in (".implode(' , ', $shop_product_type).") ".$is_mobile_use_where."
								order by p.order_cnt desc
								limit 0,60
						) p
					where
						if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')
						limit 0,5";

    $slave_mdb->query($sql);
    return $slave_mdb->fetchall();
}

//예치금 관련 함수 추가 시작 2014-06-03 이학봉
function ToalmemberDeposit($uid, $type = 'A')
{
    global $slave_mdb;
    /*
      $type = A : 총보유예치금 = 입금완료 - 사용완료 - 송금완료
      $type = U : 사용가능예치금 금액 = 입금완료 - 사용완료 - 송금완료 - 출금확정
     */
    //$slave_mdb = new Database;

    $sql = "select
					sum(if(state = '3',deposit,0)) as total_deposit,
					sum(if(state = '4',deposit,0)) as use_deposit,
					sum(if(state = '8',deposit,0)) as widthdrawal_deposit,
					sum(if(state = '7',deposit,0)) as confirm_deposit
				from
					shop_deposit
				where
					uid = '".$uid."'";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    if ($type == 'A') {
        $use_deposit = ($slave_mdb->dt['total_deposit'] - $slave_mdb->dt['use_deposit'] - $slave_mdb->dt['widthdrawal_deposit']);
    } else {
        $use_deposit = ($slave_mdb->dt['total_deposit'] - $slave_mdb->dt['use_deposit'] - $slave_mdb->dt['widthdrawal_deposit'] - $slave_mdb->dt['confirm_deposit']);
    }

    return $use_deposit;
}

//예치금 관리 기능 변경 JK160804
function DepositManagement($deposit_data)
{
    global $slave_mdb, $master_db, $_SESSION;

    extract($deposit_data, EXTR_SKIP); //넘어온 배열의 key 는 변수명 value 값이 변수 값으로 변환 JK
    //예치금 관리 시스템 은 예치금의 입금 출금을 관리하는 shop_deposit_info 테이블과 예치금의 신청 정보 (로그성 데이터) 를 관리하는 shop_deposit_history 테이블로 구성 한다
    //예치금 충전 신청 시에는 shop_deposit_charge_info 에 신청정보를 입력 하고 신청이 완료 된 건에 한해서 shop_deposit_history 와 shop_deposit_info 에 등록 한다
    //모든 신청 정보( 입금확인, 출금신청, 출금완료) 등 상태에 대한 데이터는 shop_deposit_history 에 모두 기록 되며, 입금 완료 , 출금 완료 데이터는 shop_deposit_info 에 등록하여 최종 total 값을 가지고 있는다.
    //출금 신청 시 shop_deposit_info 테이블에서는 선 출금 하며, 출금 철회를 할경우 재입금 되도록 하여 두개의 테이블에서 수정 및 삭제가 발생하지 않도록 한다
    //$use_type : P:입금 W:출금
    //$history_type : 처리상태 (1:입금대기 2:입금취소 3:입금완료 4:사용완료 5:출금요청 6:출금취소 7:출금확정)
    //모든 예치금 관련 발생하는 데이터는 기록 하기 때문에 모두 등록 한다

    $transction    = $master_db->query("SET AUTOCOMMIT=0");
    $transction    = $master_db->query("BEGIN");
    $transction_ok = true;

    //예외 처리 추가
    if ($history_type != '6' && $history_type != '7' && $history_type != '8') {
        if ($pay_method != 'bank' && $pay_method != 'refund') {
            $slave_mdb->query("select oid from shop_deposit_order_tmp where oid = '".$oid."'");
            if (!$slave_mdb->total) {// 해당 주문으로 이미 입력되어 있지 않을때만 처리
                $sql           = "insert into shop_deposit_order_tmp
                        (oid,data) values ('".$oid."','".urlencode(serialize($pay_data))."')";
                $transction    = $master_db->query($sql);
                if (!$transction || mysql_affected_rows() == 0) $transction_ok = false;
            } else {
                //이미 주문이 들어간 상태로 프로세스 타지 않도록 처리
                $transction_ok = false;
            }
        }
    }

    $sql           = "insert into shop_deposit_history
						(uid,oid,deposit,history_type,etc,bank_name,bank_number,bank_owner,regdate)
					values
						('".$user_code."','".$oid."','".$deposit."','".$history_type."','".$etc."',HEX(AES_ENCRYPT('".$bank_name."','".$db->ase_encrypt_key."')),HEX(AES_ENCRYPT('".$bank_number."','".$db->ase_encrypt_key."')),HEX(AES_ENCRYPT('".$bank_owner."','".$db->ase_encrypt_key."')),NOW())";
    //	$master_db->query($sql);
    $transction    = $master_db->query($sql);
    if (!$transction || mysql_affected_rows() == 0) $transction_ok = false;
    //echo "1".$transction_ok."<br>";
    if ($history_type == '1' || $history_type == '5') {// 예치금에 대한 신청이 이루어 질때 는 shop_deposit_charge_info 신청정보를 입력 하고 입금 완료 될 경우 해당 테이블은 입금 확인 처리 한다. (주문 order table 형태)
        $sql           = "insert into shop_deposit_charge_info (uid,oid,deposit,history_type,etc,bank_name,bank_number,bank_owner,regdate) values ('".$user_code."','".$oid."','".$deposit."','".$history_type."','".$etc."',HEX(AES_ENCRYPT('".$bank_name."','".$db->ase_encrypt_key."')),HEX(AES_ENCRYPT('".$bank_number."','".$db->ase_encrypt_key."')),HEX(AES_ENCRYPT('".$bank_owner."','".$db->ase_encrypt_key."')),NOW())";
        //		$master_db->query($sql);
        $transction    = $master_db->query($sql);
        if (!$transction || mysql_affected_rows() == 0) $transction_ok = false;
        //echo "2".$transction_ok."<br>";
        $sql           = "insert into shop_deposit_charge_status (uid,oid,deposit,history_type,etc,regdate) values ('".$user_code."','".$oid."','".$deposit."','".$history_type."','".$etc."',NOW())"; // 변경내역을 등록만하는 history 테이블
        //		$master_db->query($sql);
        $transction    = $master_db->query($sql);
        if (!$transction || mysql_affected_rows() == 0) $transction_ok = false;
        //echo "3".$transction_ok."<br>";
    }else {

        if ($history_ix) {
            if ($history_type != '4') {
                switch ($history_type) {
                    case '2': //입금취소
                        $date_update = " , cc_date = NOW()";
                        break;
                    case '3': //입금완료
                        $date_update = " , ic_date = NOW()";
                        break;
                    case '6': //출금취소
                    case '7': //출금확정
                        $date_update = " , change_date = NOW()";
                        break;
                }
                $sql           = "update shop_deposit_charge_info set history_type = '".$history_type."', charger_ix = '".$charger_ix."', etc = '".$etc."' ".$date_update."  where history_ix = '".$history_ix."'  ";
                //			$master_db->query($sql);
                $transction    = $master_db->query($sql);
                if (!$transction || mysql_affected_rows() == 0) $transction_ok = false;
                //	echo "4".$transction_ok."<br>";
                $sql           = "insert into shop_deposit_charge_status (uid,oid,deposit,history_type,etc,history_ix,regdate) values ('".$user_code."','".$oid."','".$deposit."','".$history_type."','".$etc."','".$history_ix."',NOW())"; // 변경내역을 등록만하는 history 테이블
                //			$master_db->query($sql);
                $transction    = $master_db->query($sql);
                if (!$transction || mysql_affected_rows() == 0) $transction_ok = false;
                //	echo "5".$transction_ok."<br>";
            }
        }
    }
    $sql           = "select total_deposit from shop_deposit_info where uid = '".$user_code."' order by de_ix desc limit 1"; //해당 회원의 최종 예치금 데이터 값에서 total 예치금 값을 가져옴
    $slave_mdb->query($sql);
    $slave_mdb->fetch();
    $total_deposit = $slave_mdb->dt['total_deposit'];

    switch ($history_type) {
        case '3': //입금완료
        case '6': //출금취소(철회)
            $total_deposit = $total_deposit + $deposit;
            $sql           = "insert into shop_deposit_info (history_ix,uid,oid,deposit,total_deposit,use_type,etc,regdate) values ('".$history_ix."','".$user_code."','".$oid."','".$deposit."','".$total_deposit."','".$use_type."','".$etc."',NOW())";
            //			$master_db->query($sql);
            $transction    = $master_db->query($sql);
            if (!$transction || mysql_affected_rows() == 0) $transction_ok = false;
            //echo "6".$transction_ok."<br>";
            $sql           = "update ".TBL_COMMON_USER." set deposit = '".$total_deposit."' where code = '".$user_code."'";
            //			$master_db->query($sql);
            $transction    = $master_db->query($sql);
            if (!$transction || mysql_affected_rows() == 0) $transction_ok = false;
            //echo "7".$transction_ok."<br>";
            break;


        case '4': //사용(출금)완료
        case '5': //출금요청
            $total_deposit = $total_deposit - $deposit;

            $sql           = "insert into shop_deposit_info (history_ix,uid,charger_ix,oid,deposit,total_deposit,use_type,etc,regdate) values ('".$history_ix."','".$user_code."','".$charger_ix."','".$oid."','".$deposit."','".$total_deposit."','".$use_type."','".$etc."',NOW())";
            //			$master_db->query($sql);
            $transction    = $master_db->query($sql);
            if (!$transction || mysql_affected_rows() == 0) $transction_ok = false;
            //echo "8".$transction_ok."<br>";
            $sql           = "update ".TBL_COMMON_USER." set deposit = '".$total_deposit."' where code = '".$user_code."'";
            //			$master_db->query($sql);
            $transction    = $master_db->query($sql);
            if (!$transction || mysql_affected_rows() == 0) $transction_ok = false;
            //echo "9".$transction_ok."<br>";
            break;
    }
    if (!$transction_ok) {
        $transction = $master_db->query("ROLLBACK");
        $transction = $master_db->query("SET AUTOCOMMIT=1");
        return "fail";
        exit;
    } else {
        $transction = $master_db->query("COMMIT");
        $transction = $master_db->query("SET AUTOCOMMIT=1");
        return 'true';
        exit;
    }
}

function SearchDeposit($user_code)
{
    global $slave_mdb;


    $sql           = "select total_deposit from shop_deposit_info where uid = '".$user_code."' order by de_ix desc limit 1"; //해당 회원의 최종 예치금 데이터 값에서 total 예치금 값을 가져옴
    $slave_mdb->query($sql);
    $slave_mdb->fetch();
    $total_deposit = $slave_mdb->dt['total_deposit'] ?? '';

    return $total_deposit;
}

//끝 JK


function InsertDepositInfo($use_type, $state, $use_state, $oid, $deposit_ix, $deposit, $uid, $etc, $admininfo = array(), $bank_ix = '')
{
    global $slave_mdb, $master_db;
    /*
      $use_type : P:입금 W:출금
      $state : 처리상태 (1:입금대기 2:입금취소 3:입금완료 4:사용완료 5:출금요청 6:출금취소 7:출금확정 8:송금완료)
      $use_state : 사용타입 (1:지연취소 2:고객입금 3:주문취소 4:주문교환 5:주문반품입금 6:마케팅 7:상품구매 8:고객요청 9:기타)
      $oid : 주문번호
      $deposit : 예치금금액 (외부에서 넘겨주는경우)
      $user_code : 회원코드값
      $etc : 입출금 상세내역
      state : 10-사용대기 , 11-사용대기취소 , 4- 사용완료 일시에는 새로 추가하기에 $deposit_ix 는 빈값으로 입력함 2014-07-22 이학봉
     */

    //$slave_mdb = new Database;
    $slave_mdb->query("select * from common_user where code = '".$uid."'");
    $slave_mdb->fetch();

    $is_wholesale = UserSellingType();

    if ($state == '1' || $state == '4' || $state == '5' || $state == '10' || $state == '11') { //10:사용대기 11:사용대기취소 일경우에 새롭게 insert 함 2014-07-22 이학봉
        switch ($state) {
            case '1':
                $waiting_date    = date("Y-m-d H:i:s");
                break;
            case '2':
                $cancel_date     = date("Y-m-d H:i:s");
                break;
            case '3':
                $complete_date   = date("Y-m-d H:i:s");
                break;
            case '4':
                $use_date        = date("Y-m-d H:i:s");
                $cancel_deposit  = $deposit;
                break;
            case '5':
                $w_request_date  = date("Y-m-d H:i:s");
                break;
            case '6':
                $w_cancel_date   = date("Y-m-d H:i:s");
                break;
            case '7':
                $w_fixed_date    = date("Y-m-d H:i:s");
                break;
            case '8':
                $w_complate_date = date("Y-m-d H:i:s");
                break;
            case '10':
                $w_use_date      = date("Y-m-d H:i:s");
                break;
            case '11':
                $c_use_date      = date("Y-m-d H:i:s");
                break;
        }

        $use_deposit = ToalmemberDeposit($uid); //총보유 예치금합

        if ($sate == '4') {
            $slave_mdb->query("select * from shop_deposit where deposit_ix = '".$deposit_ix."'");
            $oid = $slave_mdb->dt['oid'];
        }

        $sql               = "insert into shop_deposit(deposit_ix,uid,oid,deposit,cancel_deposit,use_deposit,use_type,state,use_state,is_wholesale,auto_cancel,waiting_date,cancel_date,complete_date,use_date,w_request_date,w_cancel_date, w_fixed_date, w_complate_date, charger_name, charger_ix, edit_date, regdate, etc, bank_ix, w_use_date, c_use_date) values('','$uid','$oid','$deposit','$cancel_deposit','$use_deposit','$use_type','$state','$use_state','$is_wholesale','N','$waiting_date','$cancel_date','$complete_date','$use_date','$w_request_date','$w_cancel_date','$w_fixed_date','$w_complate_date','".$admininfo['charger']."','".$admininfo['charger_ix']."',NOW(),NOW(),'$etc','$bank_ix', '$w_use_date', '$c_use_date')";
        $master_db->query($sql);
        $Insert_deposit_ix = $master_db->insert_id();

        if ($state == '4' || $state == '3') { //4:사용완료, 3:입금완료
            $use_deposit = ToalmemberDeposit($uid); //총보유 예치금합
            $master_db->query("update common_user set deposit = '".$use_deposit."' where code = '".$uid."'");
            $master_db->query("update shop_deposit set use_deposit = '".$use_deposit."' where deposit_ix = '".$Insert_deposit_ix."'");
        }

        if ($state == '11' || $state == '4') { //사용대기 -> 사용취소,사용완료 처리 구분값 UPDATE
            if ($state == '11') {
                $deposit_status = 'C';
            } else if ($state == '4') {
                $deposit_status = 'U';
            }

            if ($deposit_ix) {
                $where = " and deposit_ix = '".$deposit_ix."' ";
            } else if ($oid) {
                $where = " and oid = '".$oid."' and state = '10'";
            } else {
                return false;
            }

            $sql = "update shop_deposit set deposit_status = '".$deposit_status."' where 1 $where";
            $master_db->query($sql);
        }
    } else {

        $use_deposit = ToalmemberDeposit($uid); //총보유 예치금합

        if ($deposit_ix) {
            $where = " and deposit_ix = '".$deposit_ix."' ";
        } else if ($oid) {
            $where = " and oid = '".$oid."' ";
        } else {
            if ($state != '3') {
                return false;
            }
        }

        $sql          = "select * from shop_deposit where uid = '".$uid."' $where";
        $master_db->query($sql);
        $deposit_info = $master_db->fetch();

        if ($state == '2') { //입금취소	: 입금대기 -> 입금취소 상태변경 (원상태가 입금대기가 아닐경우 처리 안함)
            if ($deposit_info['state'] == '1') {
                $sql = "update shop_deposit set
								state = '".$state."',
								use_state = '".$use_state."',
								use_deposit = '".$use_deposit."',
								etc = '".$etc."',
								edit_date = NOW(),
								cancel_date = NOW()
							where
								uid = '".$uid."'
								$where";
                $master_db->query($sql);
            } else {
                return false;
            }
        } else if ($state == '3') { //입금완료	: 입금대기 => 입금완료로 상태변경

            /* 입관완료 되는 프로세스 정리 2014-07-26 이학봉
              1. 사용자 입금시 입금대기 => 입금완료시 UPDADE
              2. 관리자 popup 페이지나 CRM 에서 바로 입금완료 처리시 INSERT
              3. 부분취소,환불리스트에서 예치금 환불시 바로 입금완료 처리	INSERT
             */

            if ($deposit_ix == "") { //입금완료시 주문번호나 예치금 번호가 없을경우 바로 입금완료 처리 . pop 페이지에서 처리를 위함
                $use_deposit = ToalmemberDeposit($uid); //총보유 예치금합

                $sql               = "insert into shop_deposit(deposit_ix,uid,oid,deposit,cancel_deposit,use_deposit,use_type,state,use_state,is_wholesale,auto_cancel,waiting_date,cancel_date,complete_date,use_date,w_request_date,w_cancel_date, w_fixed_date, w_complate_date, charger_name, charger_ix, edit_date, regdate, etc, bank_ix, w_use_date, c_use_date) values('','$uid','$oid','$deposit','$cancel_deposit','$use_deposit','$use_type','$state','$use_state','$is_wholesale','N','$waiting_date','$cancel_date',NOW(),'$use_date','$w_request_date','$w_cancel_date','$w_fixed_date','$w_complate_date','".$admininfo['charger']."','".$admininfo['charger_ix']."',NOW(),NOW(),'$etc','$bank_ix', '$w_use_date', '$c_use_date')";
                $master_db->query($sql);
                $Insert_deposit_ix = $master_db->insert_id();

                if ($state == '4' || $state == '3') { //4:사용완료, 3:입금완료
                    $use_deposit = ToalmemberDeposit($uid); //총보유 예치금합
                    $master_db->query("update common_user set deposit = '".$use_deposit."' where code = '".$uid."'");
                    $master_db->query("update shop_deposit set use_deposit = '".$use_deposit."' where deposit_ix = '".$Insert_deposit_ix."'");
                }
            } else {

                if ($deposit_info['state'] == '1') {  //입금대기-> 입금완료로 전환해주는 부분 2014-07-26 이학봉
                    $sql = "update shop_deposit set
									state = '".$state."',
									use_state = '".$use_state."',
									use_deposit = use_deposit + '".$deposit."',
									etc = '".$etc."',
									edit_date = NOW(),
									complete_date = NOW()
								where
									uid = '".$uid."'
									$where";
                    //echo nl2br($sql)."<br><br>";
                    $master_db->query($sql);

                    $use_deposit = ToalmemberDeposit($uid); //총보유 예치금합
                    $master_db->query("update shop_deposit set use_deposit = '".$use_deposit."' where deposit_ix = '".$deposit_ix."'");
                    $master_db->query("update common_user set deposit = '".$use_deposit."' where code = '".$uid."'");
                } else {
                    return false;
                }
            }
        } else if ($state == '6') { //출금취소	: 출금요청  => 출금취소로 상태변경
            if ($deposit_info['state'] == '5') {
                $sql = "update shop_deposit set
								state = '".$state."',
								use_state = '".$use_state."',
								use_deposit = '".$use_deposit."',
								etc = '".$etc."',
								edit_date = NOW(),
								w_cancel_date = NOW()
							where
								uid = '".$uid."'
								$where";
                $master_db->query($sql);
            } else {
                return false;
            }
        } else if ($state == '7') { //출금확정	: 출금요청  => 출금확정으로 상태변경
            if ($deposit_info['state'] == '5') {
                $sql = "update shop_deposit set
								state = '".$state."',
								use_state = '".$use_state."',
								use_deposit = '".$use_deposit."',
								etc = '".$etc."',
								edit_date = NOW(),
								w_fixed_date = NOW()
							where
								uid = '".$uid."'
								$where";
                $master_mdb->query($sql);
            } else {
                return false;
            }
        } else if ($state == '8') { //송금완료	: 출금요청  => 출금확정으로 상태변경
            if ($deposit_info['state'] == '5' || $deposit_info['state'] == '7') {
                $sql = "update shop_deposit set
								state = '".$state."',
								use_state = '".$use_state."',
								use_deposit = use_deposit - '".$deposit."',
								etc = '".$etc."',
								edit_date = NOW(),
								w_complate_date = NOW()
							where
								uid = '".$uid."'
								$where";
                $master_mdb->query($sql);

                $use_deposit = ToalmemberDeposit($uid); //총보유 예치금합
                $master_mdb->query("update shop_deposit set use_deposit = '".$use_deposit."' where deposit_ix = '".$deposit_ix."'");
                $master_mdb->query("update common_user set deposit = '".$use_deposit."' where code = '".$uid."'");
            } else {
                return false;
            }
        }
    }
}

//예치금 관련 함수 추가 끝 2014-06-03 이학봉

function DisplayCommentCategory($event_ix)
{
    global $slave_mdb;
    if (!$event_ix) {
        return false;
    }

    //global $_SESSION;
    //$db = new Database;
    //$db2 = new Database;

    $sql        = "select * from shop_display_comment_div where event_ix = '".$event_ix."' and disp='1'";
    $slave_mdb->query($sql);
    $data_array = $slave_mdb->fetchall();

    $data = "<select name='div_ix' id='div_ix' style='width:100%;' validation=true title='댓글분류'>";
    $data .= "<option value=''>필수선택입니다.</option>";
    for ($i = 0; $i < count($data_array); $i++) {
        $data .= "<option value='".$data_array[$i]['div_ix']."'>".$data_array[$i]['div_name']."</option>";
    }

    $data .= "</select>";

    return $data;
}

function insertProductPoint($state, $use_state, $oid = '', $od_ix = '', $point, $pid, $etc, $admininfo = array(), $type = '')
{
    global $slave_mdb, $master_db;

    if (!$slave_mdb) {
        $slave_mdb = new Database;
        $slave_mdb->slave_db_setting();
    }
    if (!$point) {  //판매신용점수 점수가 없을경우 설정값에서 불러옴 (관리자 추가경우와 , 프로세스 자동설정경우 두가지 )
        $product_level_info = getSharedInfo('product_level_setting');
        if ($type == "click" || $type == "wish" || $type == "cart") {
            $point = $product_level_info["".$type."_point"];
            $rule  = $product_level_info["".$type."_rule"];

            if (sess_val("user", "code")) {
                if ($type == "cart") {
                    if ($rule == 1) {
                        $sql = "select * from commerce_salestack where pid='".$pid."' and step1 = '1' and ucode = '".$_SESSION["user"]["code"]."' ";
                        $slave_mdb->query($sql);
                        if ($slave_mdb->total) {
                            return;
                        }
                    } else if ($rule == 2) {
                        $sql = "select * from commerce_salestack where pid='".$pid."' and step1 = '1' and vdate = '".date("Ymd")."' and ucode = '".$_SESSION["user"]["code"]."'  ";
                        $slave_mdb->query($sql);
                        if ($slave_mdb->total) {
                            return;
                        }
                    }
                } else if ($type == "wish") {
                    if ($rule == 1) {
                        $sql = "select * from commerce_salestack where pid='".$pid."' and step_wish = '1' and ucode = '".$_SESSION["user"]["code"]."' ";
                        $slave_mdb->query($sql);
                        if ($slave_mdb->total) {
                            return;
                        }
                    } else if ($rule == 2) {
                        $sql = "select * from commerce_salestack where pid='".$pid."' and step_wish = '1' and vdate = '".date("Ymd")."' and ucode = '".$_SESSION["user"]["code"]."'  ";
                        $slave_mdb->query($sql);
                        if ($slave_mdb->total) {
                            return;
                        }
                    }
                } else if ($type == "click") {
                    if ($rule == 1) {
                        $sql = "select * from commerce_viewingview where pid='".$pid."'  and ucode = '".$_SESSION["user"]["code"]."' ";
                        $slave_mdb->query($sql);
                        if ($slave_mdb->total) {
                            return;
                        }
                    } else if ($rule == 2) {
                        $sql = "select * from commerce_viewingview where pid='".$pid."' and vdate = '".date("Ymd")."' and ucode = '".$_SESSION["user"]["code"]."'  ";
                        $slave_mdb->query($sql);
                        if ($slave_mdb->total) {
                            return;
                        }
                    }
                }
            }
        } else if ($type == "delay" || $type == "delay_add") {
            $point = $product_level_info["delivery_".$type."_point"];
            $rule  = $product_level_info["delivery_".$type."_date"];
            if ($type == "delay") {

            }
        } else {
            $point = $product_level_info["level_".$type."_point"];
        }
    }

    $sql   = "select pname, product_point from shop_product where id='".$pid."' ";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();
    $pname = $slave_mdb->dt['pname'];
    $pname = str_replace("\"", "&quot;", $pname);
    $pname = str_replace("'", "&#39;", $pname);

    $product_point = $slave_mdb->dt['product_point'];

    switch ($state) {
        case '1':
            $complete_date = date("Y-m-d H:i:s");
            break;
        case '2':
            $use_date      = date("Y-m-d H:i:s");
            break;
    }

    if ($state == 1) {//적립(+)
        $product_point = $product_point + $point;
    } else {
        $product_point = $product_point - $point;
    }

    $use_date = $use_date ?? '';
    $sql      = "insert into shop_product_point
		(pid,pname,oid,od_ix,point,total_point,state,use_state,etc,charger_ix,charger_name,complete_date,use_date,edit_date,regdate)
		values
		('$pid','$pname','$oid','$od_ix','$point','".$product_point."','$state','$use_state','$etc','".($admininfo['charger_ix'] ?? '')."','".($admininfo['charger']
            ?? '')."','$complete_date','$use_date',NOW(),NOW())";
    //echo nl2br($sql);
    $master_db->query($sql);
    $pp_ix    = $master_db->insert_id();

    //$use_penalty = TotalCompanyPenalty($company_id);	//새로 입력후 총 판매신용점수
    if ($state == 1) {//적립(+)
        $master_db->query("update shop_product set product_point = product_point+'".$point."'  where id = '".$pid."'"); //, editdate = NOW()
        $master_db->query("update shop_product_point set total_point = total_point+'".$point."' where pp_ix = '".$pp_ix."'");
    } else {
        $master_db->query("update shop_product set product_point = product_point-'".$point."' where id = '".$pid."'"); //  , editdate = NOW()
        $master_db->query("update shop_product_point set total_point = total_point-'".$point."' where pp_ix = '".$pp_ix."'");
    }
}

//셀러판매신용점수 관리 시작 2014-06-15 이학봉
function InsertPenaltyInfo($state, $use_state, $oid = '', $od_ix = '', $point, $company_id, $etc, $admininfo = array(), $type = '')
{
    global $slave_mdb, $master_db;
    /* 셀러별 판매신용점수 관리
      $state : 처리상태 (1:적립(+) 2:차감(-))
      $use_state : 사용타입 (1:입금완료 2:배송완료 3:구매확정 4:입금후 취소 5:교환승인 6:반품승인 7:입금후완료일(배송지연) 8:입금후완료일추가(배송지연) 9:기타)
      $oid : 주문번호
      $od_ix : 주문상세번호
      $point : 예치금금액 (외부에서 넘겨주는경우)
      $company_id : 셀러키값
      $etc : 입출금 상세내역
     */

    if (!$point) {  //판매신용점수 점수가 없을경우 설정값에서 불러옴 (관리자 추가경우와 , 프로세스 자동설정경우 두가지 )
        $point_info = getBasicSellerSetup('sellergroup_penalty');
        $point      = $point_info["penalty_".$type."_point"];
    }
    if (!$slave_mdb) {
        $slave_mdb = new Database;
    }

    $sql         = "select
					ccd.com_name,
					AES_DECRYPT(UNHEX(cmd.name),'".$slave_mdb->ase_encrypt_key."') as name,
					cu.id,
					cmd.code, csd.penalty
				from
					common_company_detail as ccd
					inner join common_seller_detail as csd on (ccd.company_id = csd.company_id)
					left join common_member_detail as cmd on (csd.charge_code = cmd.code)
					left join common_user as cu on (cmd.code = cu.code)
				where
					ccd.company_id = '".$company_id."'";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();
    $com_name    = $slave_mdb->dt['com_name'];
    $seller_code = $slave_mdb->dt['code'];
    $use_point   = $slave_mdb->dt['penalty'];

    switch ($state) {
        case '1':
            $complete_date = date("Y-m-d H:i:s");
            break;
        case '2':
            $use_date      = date("Y-m-d H:i:s");
            break;
    }

    //$use_point = TotalCompanyPenalty($company_id);	//새로 입력전 총 판매신용점수
    if ($state == 1) {//적립(+)
        $use_point = $use_point + $point;
    } else {
        $use_point = $use_point - $point;
    }


    $com_name   = addslashes($com_name);
    $sql        = "insert into common_seller_penalty
		(company_id,com_name,seller_code,oid,od_ix,penalty,cancel_penalty,use_penalty,state,use_state,etc,charger_ix,charger_name,complete_date,use_date,edit_date,regdate)
		values
		('$company_id','$com_name','$seller_code','$oid','$od_ix','$point','$point','".($use_point)."','$state','$use_state','$etc','".$admininfo['charger_ix']."','".$admininfo['charger']."','$complete_date','$use_date',NOW(),NOW())";
    //echo nl2br($sql)."<br><br>";
    $master_db->query($sql);
    $penalty_ix = $master_db->insert_id();

    //$use_penalty = TotalCompanyPenalty($company_id);	//새로 입력후 총 판매신용점수
    $master_db->query("update common_seller_detail set penalty = penalty + '".$point."' where company_id = '".$company_id."'");
    //$slave_mdb->query("update common_seller_penalty set use_penalty = use_penalty + ".$point." where penalty_ix = '".$penalty_ix."'");
}

function TotalCompanyPenalty($company_id)
{
    global $slave_mdb;
    /*
      $type = A : 총보유예치금 = 입금완료 - 사용완료 - 송금완료
      $type = U : 사용가능예치금 금액 = 입금완료 - 사용완료 - 송금완료 - 출금확정
     */
    //$slave_mdb = new Database;

    $sql = "select
					sum(if(state = '1',penalty,0)) as complete_penalty,
					sum(if(state = '2',penalty,0)) as use_deposit
				from
					common_seller_penalty
				where
					company_id = '".$company_id."'";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    $total_penalty = ($slave_mdb->dt['complete_penalty'] - $slave_mdb->dt['use_deposit']);

    return $total_penalty;
}

//셀러판매신용점수 관리 끝 2014-06-15 이학봉

function salerate_round($number)
{
    if ($number < 1) {
        $number = 1;
    }
    return round($number);
}

function make_shop_order_oid()
{
    //$microtime = explode(".",microtime());
    //return date("YmdHis")."-".rand(0,9).substr($microtime[1],0,3).rand(1,9);
    //2017-08-14 주문번호 생성 중복 이슈로 인해 수정
    /*
      global $layout_config,$admin_config;

      //세션은 안됨 cron 돌때 안됨!
      if( ! empty($layout_config[mall_data_root])){
      $mall_data_root = $layout_config[mall_data_root];
      }else{
      $mall_data_root = $admin_config[mall_data_root];
      }

      include_once $_SERVER["DOCUMENT_ROOT"]."/admin/logstory/class/sharedmemory.class";
      $shmop = new Shared("make_oid");
      $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$mall_data_root."/_shared/";
      $shmop->SetFilePath();
      $result = $shmop->getObjectForKey("make_oid");

      $result = unserialize(urldecode($result));

      $NOW = date('Ymd');
      $setData = array();

      if( ! empty($result[$NOW])){
      $result[ $NOW ]++;
      $setData = $result;
      }else{
      $setData[ $NOW ] = 1;
      }

      $num = zerofill($setData[ $NOW ], '7');

      $setData = urlencode(serialize($setData));
      $shmop->setObjectForKey($setData,"make_oid");

      //20150702235952-11912 ->  //201507031210-0079962
      return $NOW . date('Hi') . '-' . $num;
     */

    $ms_db = new Database;
    $ms_db->master_db_setting();
    $ms_db->query("begin");

    $config_name = "make_oid";
    $NOW         = date('Ymd');
    $oid_first   = "";
    $oid_last    = "";
    //FOR UPDATE 구문은 select 도 락시킴!
    $sql         = "select * from shop_mall_config where mall_ix='".$config_name."' and config_name='".$config_name."' FOR UPDATE";
    $ms_db->query($sql);
    if ($ms_db->total > 0) {
        $ms_db->fetch();
        list($date, $num) = explode("|", $ms_db->dt['config_value']);
        if ($date == $NOW) {
            $num++;
        } else {
            $date = $NOW;
            $num  = 1;
        }
    } else {
        $date = $NOW;
        $num  = 1;
    }

    $oid_first    = $date.date('Hi');
    $oid_last     = zerofill($num, '7');
    $config_value = $date."|".$num;
    $oid          = $oid_first."-".$oid_last;
    $sql          = "replace into shop_mall_config (mall_ix,config_name,config_value)
              values ('".$config_name."','".$config_name."','".$config_value."')";
    $ms_db->query($sql);
    $ms_db->query("commit");
    //컴잇이후 이후 프로세스는 자동 컴잇!
    $ms_db->query("set autocommit = 1");
    return $oid;
}

//카테고리별 접속권한 상위카테고리까지 체크함수 2014-10-10 이학봉
function check_category_access($cid)
{

    global $_SESSION, $slave_mdb;

    if (!$cid) {
        return false;
    }

    $category_info = get_this_categoryinfo($cid); //카테고리정보 불러오기

    for ($i = $category_info[0]['depth']; $i >= 0; $i--) {

        $oci_cid = substr($cid, 0, ($i * 3 + 3));

        switch ($i * 3 + 3) {
            case '12':
                $oci_cid = $oci_cid."000";
                break;
            case '9':
                $oci_cid = $oci_cid."000000";
                break;
            case '6':
                $oci_cid = $oci_cid."000000000";
                break;
            case '3':
                $oci_cid = $oci_cid."000000000000";
                break;
        }

        check_category_info($cid);
    }
}

//카테고리별 접속 권한 설정 함수 2014-10-08 이학봉 작업예정
function check_category_info($cid)
{
    global $_SESSION, $slave_mdb;

    if (!$cid) {
        return false;
    }

    //카테고리별 19세 미만 접속 설정
    $sql = "select * from shop_category_info where cid = '".$cid."'";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    if ($slave_mdb->dt['is_adult'] == '1') {
        if ($_SESSION['user']['age'] < '19') {
            echo("<script>alert('19세이상만 접속 가능합니다.');location.href='../member/login.php';</script>");
            return false;
        }
    }

    //회원접근권한
    $sql             = "select * from shop_category_auth where cid = '".$cid."' and category_access  not in ('MD','DE')";
    $slave_mdb->query($sql);
    $category_access = $slave_mdb->fetchall();
    $access          = true;
    if (count($category_access) > 0) {
        for ($i = 0; $i < count($category_access); $i++) {
            if ($category_access[$i]['category_access'] == 'M') { //회원만 접근 가능
                if (!$_SESSION['user']['code']) {
                    $access = false;
                }
            } else if ($category_access[$i]['category_access'] == 'G') { //지정된 회원그룹만 접근가능
                if ($_SESSION['user']['gp_ix'] == $category_access[$i]['access_user']) {
                    $access = true;
                    continue;
                } else {
                    $access = false;
                }
            } else if ($category_access[$i]['category_access'] == 'U') { //지정된 회원만 접근가능
                if ($_SESSION['user']['code'] == $category_access[$i]['access_user']) {
                    $access = true;
                    continue;
                } else {
                    $access = false;
                }
            }
        }
    }

    if ($access == false) {
        if ($category_access[0]['category_access'] == 'M') {
            echo("<script>alert('로그인후 접속 가능합니다.');location.href='../member/login.php';</script>");
            exit;
        } else {
            echo("<script>alert('해당 카테고리에 대한 접근권한이 없습니다.');history.go(-1);</script>");
            exit;
        }
    }
}

function GetCategoryImg($cid, $select_name)
{

    global $_SESSION, $slave_mdb;

    if (!$cid) {
        return false;
    }

    $sql = "select ".$select_name." from shop_category_info where cid = '".$cid."'";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    return $slave_mdb->dt[$select_name];
}

function getProductTotalCnt()
{
    global $slave_mdb;

    $sql = "select count(*) as total from shop_product where state in ('0','1') and disp in ('1','3') ";
    $slave_mdb->query($sql);
    $slave_mdb->fetch();

    return $slave_mdb->dt['total'];
}

function getcartinfo()
{

    global $_SESSION, $slave_mdb, $shop_product_type;

    //비회원시 세션아이디로, 회원일시 회원코드로
    if ($_SESSION['user']['code'] != "") {
        $where = " and mem_ix = '".$_SESSION['user']['code']."' and c.product_type in (".implode(' , ', $shop_product_type).")  ";
    } else {
        $where = " and cart_key = '".session_id()."' and c.product_type in (".implode(' , ', $shop_product_type).") ";
    }

    $sql = "select
					dcprice,
					pcount,
					id,
					REPLACE(REPLACE(pname,'[',''),']','') AS pname,
					cid
				from
					shop_cart c
				where
					1
					$where
					and est_ix = '0'";

    $slave_mdb->query($sql);
    $carts2 = $slave_mdb->fetchall();

    return $carts2;
}

//코웰 모바일 메뉴
function getMobileMenuUsingBanner()
{
    global $slave_mdb;

    //$sql = "SELECT * FROM shop_banner_div WHERE agent_type = 'M' AND disp = 1 AND div_name LIKE '메뉴_%'";
    $sql = "SELECT * FROM shop_banner_div WHERE agent_type = 'M' AND disp = 1 AND div_name LIKE '메인'";
    $slave_mdb->query($sql);

    return $slave_mdb->fetchall("object");
}

//아카마이 파일 업로드
/*
  $files[] = 'ms_0000000008.gif';
  akamaiFtpUpload('/data/cowell_data/images/product/00/00/00/00/08',$files);
 */
function akamaiFtpUpload($path, $files = array())
{
    //2016-06-30 Hong 사용안함 (커스텀으로 이미지를 이미지 서버 FPT로 올리는 기능)
    return;
}

function ConnectUserLog($id, $code, $connect_type)
{
    $db = gVal('db');

    //connect_type = maintain : 접속 유지 , login : 접속 , logout : 로그아웃
    $sql = "SHOW TABLES LIKE 'common_member_connect_log'";
    $db->query($sql);
    if (!$db->total) {
        $sql = "CREATE TABLE `common_member_connect_log` (
				  `lo_ix` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT COMMENT '회원접속 로그 인덱스',
				  `code` varchar(32) DEFAULT NULL COMMENT '회원코드',
				  `id` varchar(100) DEFAULT NULL COMMENT '접속 ID정보',
				  `connect_yn` enum('Y','N') DEFAULT NULL COMMENT '접속 성공 여부 Y: 성공 N:실패',
				  `connect_time` datetime DEFAULT NULL COMMENT '접속시도 당시 시간',
				  `expired_time` datetime DEFAULT NULL COMMENT '접속 시도 당시 예상 종료 시간 및 로그아웃 시 당시 시간',
				  `connect_ip` varchar(50) DEFAULT NULL COMMENT '접속 IP 주소',
				  PRIMARY KEY (`lo_ix`),
				  KEY `code` (`code`),
				  KEY `connect_yn` (`connect_yn`),
				  KEY `connect_time` (`connect_time`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			";
        $db->query($sql);
    }

    //회원 접속 로그 기록 유지 기간 설정 값 가져오기
    $member_connect_delete_day = $_SESSION['privacy_config']['member_connect_delete_day'];
    if ($member_connect_delete_day > '0') {
        $member_connect_delete_day = $member_connect_delete_day;
    } else {
        $member_connect_delete_day = "180";
    }

    //echo $member_connect_delete_day;
    $now_date        = date('Y-m-d H:i:s');
    $delete_log_time = date('Y-m-d H:i:s', strtotime($now_date."- ".$member_connect_delete_day." days"));

    //로그 기록 기준이 만료된 데이터 삭제

    $sql = "delete from common_member_connect_log where connect_time < '".$delete_log_time."'";
    //echo $sql;
    $db->query($sql);


    $session_out_time = ini_get('session.gc_maxlifetime'); // 아무 행동하지 않았을때 세션이 만료되는 시간 가져오기
    $now_time         = time(); // 현재 시간 가져오기
    $expired_time     = date('Y-m-d H:i:s', $now_time + $session_out_time); // 현재 시간과 세션이 만료되는 시간을 더해 세션 종료예정 시간 등록

    if ($connect_type == 'login') {
        if ($code) {
            //회원 코드값이 존재하면, 로그인 성공
            $sql = "insert into common_member_connect_log (code, id, connect_yn, connect_time, expired_time, connect_ip) values ('".$code."','".$id."','Y',NOW(),'".$expired_time."','".$_SERVER["REMOTE_ADDR"]."')";
            $db->query($sql);
        } else {
            $sql = "select code from ".TBL_COMMON_USER." where id = '".$id."' ";
            $db->query($sql);
            if ($db->total) {
                $db->fetch();
                $user_code = $db->dt['code'];
                //회원 코드 값이 존재하지 않기 때문에 접속 실패로 간주
                $sql       = "insert into common_member_connect_log (code, id, connect_yn, connect_time, expired_time, connect_ip) values ('".$user_code."','".$id."','N',NOW(),'','".$_SERVER["REMOTE_ADDR"]."')";
                $db->query($sql);
            }
        }
    } else if ($connect_type == 'logout') {
        //회원이 로그아웃 버튼 클릭으로 실제 로그아웃 했을때 기록 업데이트
        $sql = "select max(lo_ix) lo_ix from common_member_connect_log where code = '".$code."' and connect_yn = 'Y'";
        $db->query($sql);
        if ($db->total) {
            $db->fetch();
            $lo_ix = $db->dt['lo_ix'];

            $sql = "update common_member_connect_log set expired_time = NOW() where code = '".$code."' and lo_ix = '".$lo_ix."'";
            $db->query($sql);
        }
    } else if ($connect_type == 'maintain') {
        //접속 시간이 유지되는 상태 즉 회원이 사이트 내에서 활동 중일때는 예정된 expired_time 이 증가 됨으로 해당 시간 값을 업데이트 한다.
        $sql = "select max(lo_ix) lo_ix from common_member_connect_log where code = '".$code."' and connect_yn = 'Y'";
        $db->query($sql);

        if ($db->total) {
            $db->fetch();
            $lo_ix = $db->dt['lo_ix'];

            $sql = "update common_member_connect_log set expired_time = '".$expired_time."' where code = '".$code."' and lo_ix = '".$lo_ix."'";
            $db->query($sql);
        }
    }
}

function unreceived_claim($od_ix, $type)
{
    global $db;

    if ($type == 'message') {
        $sql = "select claim_message as data from shop_order_unreceived_claim where od_ix = '".$od_ix."'";
    } else if ($type == 'claim_date') {
        $sql = "select claim_date as data from shop_order_unreceived_claim where od_ix = '".$od_ix."'";
    }
    $db->query($sql);

    $db->fetch();
    return $db->dt['data'];
}

function getImageNum($str)
{
    $num = explode("[", $str);
    $num = explode("]", $num[1]);

    return getBannerInfo($num[0]);
}

//회원 코드값으로 아이디 정보 가져오기
function getUserCodeById($code)
{
    global $db;

    $sql = "select id from ".TBL_COMMON_USER." where code = '".$code."'";
    $db->query($sql);
    $db->fetch();
    return $db->dt['id'];
}

function InterestfreeCardPromotion($dcprice)
{
    global $db;

    $sql = "select cp_ix, title, discount_type, condition_price from shop_card_promotion where date_format(NOW(),'%Y%m%d') between sdate and edate and disp='1'";
    $db->query($sql);
    return $db->fetchall();
}

function getShopNameAndLogo($pid)
{
    $P = new msLayOut("028001000000000");

    $db  = new Database;
    $sql = sprintf("SELECT sd.shop_name , sd.company_id
						  FROM shop_product p left join common_seller_detail sd on p.admin = sd.company_id
						 WHERE p.id = %s", $pid);


    $db->query($sql);
    $results    = $db->fetchall();
    $result     = $results[0];
    $company_id = $result['company_id'];

    $logoPhysicalPath = $_SERVER["DOCUMENT_ROOT"].$P->Config['mall_image_path']."/shopimg/shop_logo_".$company_id.".gif";

    if (file_exists($logoPhysicalPath)) {
        $logoPath = $P->Config['mall_image_path']."/shopimg/shop_logo_".$company_id.".gif";
    } else {
        $logoPath = "noimage";
    }
    return array(array('logoPath' => $logoPath, 'shopName' => $result['shop_name']));
}

function getCompanyId($pid)
{
    $db  = new Database;
    $sql = sprintf("SELECT admin
						  FROM shop_product
						 WHERE id = %s", $pid);


    $db->query($sql);
    $results   = $db->fetchall();
    $result    = $results[0];
    $companyId = $result['admin'];

    return $companyId;
}

// ---------------------------------------------------------------------------------
// Best, New, 무료배송, 쿠폰, 무이자 태그를 가져옴.
// 쿠폰은 더 develop 시켜야함.
// BEST : 3일이내 주문이 있는 경우
// New  : 일주일 이내에 등록된 상품
// 무료배송 : 디비기준
// 쿠폰 : 디비기준
// 무이자 : 현재 시점에 설정된 신용카드 프로모션 제한 가격이 상품가격을 넘을때
// SOLDOUT : 상품의 상태값이 0일경우 또는 stock_use_yn이 y거나 q이면서 재고가 0이하일때
//
//                                                          2016.11.22 이철성, 김형수
// ---------------------------------------------------------------------------------
function getTags($pid)
{
    //print_r($pid);
    $db  = new Database;
    $sql = sprintf("SELECT p.id
							 , IF(od.regdate >= SUBDATE(CURDATE(),3), 'Y', 'N') as BEST
							 , IF(p.regdate >= SUBDATE(CURDATE(),7), 'Y', 'N') as NEW
							 , IF(p.free_delivery_yn = 'y', 'Y', 'N') as FREESHIPPING
							 , IF(p.coupon_use_yn = 'y', 'Y', 'N') as COUPON
							 , IF((SELECT condition_price
									 FROM shop_card_promotion cp
									WHERE date_type = 1
									  AND disp = 1
									  AND NOW() BETWEEN sdate and edate) <= p.sellprice, 'Y', 'N' ) as NOINT
							 ,(CASE state
								WHEN '0' THEN 'Y'
								ELSE (CASE
											WHEN p.stock_use_yn = 'Y' AND (p.stock + p.available_stock) <= 0 THEN 'Y'
											WHEN p.stock_use_yn = 'Q' AND (p.stock + p.available_stock) <= 0 THEN 'Y'
											ELSE 'N'
										END)
							END) AS SOLDOUT
						  FROM shop_product p left join shop_order_detail od on p.id = od.pid
						 WHERE p.id = %d
						 ORDER BY od_ix DESC LIMIT 1
	 					   ", $pid);

    $db->query($sql);
    $results = $db->fetchall();
    $result  = $results[0];

    $dispAttrib = "style='display:none;'";
    $html       = "";
    //유명호과장 확인후 적용필요(빠질수도 있음)
    //$html .= sprintf("<em class='coupon' %s>쿠폰</em>", $result['COUPON'] == 'N' ? $dispAttrib : '');
    //$html .= sprintf("<em class='free_delivery' %s>무료배송2</em>", $result['FREESHIPPING'] == 'N' ? $dispAttrib : '');
    $html       .= sprintf("<em class='is_best' %s>BEST</em>", $result['BEST'] == 'N' ? $dispAttrib : '');
    $html       .= sprintf("<em class='is_new' %s>NEW</em>", $result['NEW'] == 'N' ? $dispAttrib : '');
    $html       .= sprintf("<em class='noninterest' %s>무이자</em>", $result['NOINT'] == 'N' ? $dispAttrib : '');
    $html       .= sprintf("<em class='soldout' %s>SOLDOUT</em>", $result['SOLDOUT'] == 'N' ? $dispAttrib : '');

    return $html;
}

// ---------------------------------------------------------------------------------
// Best, New, 무료배송, 쿠폰, 무이자 태그를 가져옴.
// 쿠폰은 더 develop 시켜야함(유명호과장 확인후 적용필요->빠질수도 있음).
// 쿠폰 : UsableCupon 함수 사용
// 무료배송 : shop_product_addinfo.free_delivery_yn 디비기준 => shop_product_addinfo.free_delivery_yn값은 정상 변경됨(1: 무료배송)
// BEST : 전일기준 판매된 상품(shop_product.recent_order_date 컬럼추가 고민필요)
// New  : 일주일 이내에 등록된 상품(getProducts 함수 lib.function.php 8008 라인)
// 무이자 : 현재 시점에 설정된 신용카드 프로모션 제한 가격이 상품가격을 넘을때
//				=>쿼리에서 추출하는 정책 반영 --> 쿼리로 매번 호출하는건 아닌거 같음 --> 세션으로 생성 하던지? 방법 고민필요
// SOLDOUT : 상품의 상태값이 0일경우 또는 stock_use_yn이 y거나 q이면서 재고가 0이하일때
//
//																						2016.11.29 김형수
// ---------------------------------------------------------------------------------
function getTagsInfo($product_info)
{
    $html = "";
    if (is_array($product_info)) {
        $db = gVal('db');

        $sql = sprintf("SELECT p.id
								 , IF(p.order_cnt > 0, 'Y', 'N') as BEST
								 , IF((SELECT condition_price
										 FROM shop_card_promotion cp
										WHERE date_type = 1
										  AND disp = 1
										  AND NOW() BETWEEN sdate and edate) <= p.sellprice, 'Y', 'N' ) as NOINT
							 FROM
								shop_product p
								left join shop_order_detail od on p.id = od.pid
							 WHERE
								p.id = %d
							 ORDER BY od_ix DESC
							 LIMIT 1
	 					   ", $product_info['id']);

        $db->query($sql);
        $result = $db->fetch();

        $dispAttrib = "style='display:none;'";

        $usable_coupons = UsableCupon($product_info['id'], $product_info['dcprice'], 1, 1, "array");
        $html           .= sprintf("<em class='is_sale' %s>SALE</em>", $product_info['listprice'] > $product_info['dcprice'] ? '' : $dispAttrib);
        $html           .= sprintf("<em class='is_best' %s>BEST</em>", $result['BEST'] == 'N' ? $dispAttrib : '');
        $html           .= sprintf("<em class='is_new' %s>NEW</em>", $product_info['is_new'] == '0' ? $dispAttrib : '');
        $html           .= sprintf("<em class='noninterest' %s>무이자</em>", $result['NOINT'] == 'N' ? $dispAttrib : '');
        $html           .= sprintf("<em class='soldout' %s>SOLDOUT</em>",
            $product_info['sold_out'] == 'Y' || $product_info['state'] == '0' ? '' : $dispAttrib);
    }
    return $html;
}

function getGoodsflowStatus($page_type = 'front', $unique_code, $order_from = 'self', $style = '')
{
    global $master_db;

    $sql = "select * from sellertool_site_info where site_code = 'goodsflow'";
    $master_db->query($sql);
    $master_db->fetch();

    if (!isset($master_db->dt['site_id']) || $master_db->dt['site_id'] == '') {
        return;
    }

    $site_id = $master_db->dt['site_id'];

    $result     = '';
    $result_div = '';
    if ($unique_code) {
        $sql = "SELECT * FROM shop_order_goodsflow_status WHERE trans_unique_code = '".$unique_code."'";

        $master_db->query($sql);
        $data    = $master_db->fetch();
        $invoice = explode('_', $data['item_unique_code']);
        //print_r($invoice);
        if ($master_db->total > 0) {
            if ($page_type == 'admin') {
                //echo $data['status'];
                if ($order_from == 'self') {
                    $result_div = "<br/><a href='#' onclick=\"PoPWindow('https://b2c.goodsflow.com/".$site_id."/Whereis.aspx?item_unique_code=".$data['item_unique_code']."',800,600,'goodsflow')\" ".$style.">".getGoodsflowStatusdiv($data['status'])."<br/>".$invoice[1]."</a>";
                } else {
                    $result_div = "<br/><a href='#' onclick=\"PoPWindow('https://b2c.goodsflow.com/".$site_id."/Whereis.aspx?item_unique_code=".$data['item_unique_code']."',800,600,'goodsflow')\" ".$style.">제휴사주문<br/>".$invoice[1]."</a>";
                }
            } else if ($page_type == 'front') {
                $result_div = $data['status'];
            }
        }

        $result = $result_div;
    }

    return $result;
}

function getGoodsflowStatusdiv($status = '')
{

    //굿스플로 상태값
    $_GOODSFLOW_STATUS["WDR"] = "출고예정";
    $_GOODSFLOW_STATUS["DR"]  = "배송준비중";
    $_GOODSFLOW_STATUS["DI"]  = "출고완료";
    $_GOODSFLOW_STATUS["DC"]  = "배송완료";

    $statusArray = array('WDR', 'DR', 'DI', 'DC');

    if (in_Array($status, $statusArray)) {
        $result = $_GOODSFLOW_STATUS[$status];
    } else {
        $result = '';
    }

    return $result;
}

/**
 * @param int $length
 * @return string
 * BY mjk
 * 원한은 길이만큼 문자및 숫자를 랜덤으로 표기
 */
function generateRandomString($length = 10)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters['rand'(0, $charactersLength - 1)];
    }
    return $randomString;
}

function isUseGoodsflow()
{
    global $slave_mdb;
    $sql        = "SELECT * FROM sellertool_site_info WHERE site_code = 'goodsflow'";
    $slave_mdb->query($sql);
    $goods_flow = $slave_mdb->fetch();
    if ($goods_flow['api_yn'] == 'Y') {
        return true;
    } else {
        return false;
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////
/**
 * csrf Token 생성
 * 이철성
 */
function getCsrfToken()
{
    // openssl_random_pseudo_bytes 가 정석이나 php 5.3+ 부터 지원
    // return bin2hex(openssl_random_pseudo_bytes(32));
    $token = bin2hex(generateRandomString(32));
    return $token;
}

/**
 * csrf Token 설정
 * session start 이후 실행해야함.
 * 세션에 토큰값 설정
 * 이철성
 */
function setCsrfTokenInSess($token)
{
    $_SESSION['csrf_token'] = $token;
    return;
}

/**
 * csrf Token 검증
 * 이철성
 */
function valCsrfToken($token)
{
    $result = false;
    if (hash_equals(sess_val('csrf_token'), $token)) {
        $result = true;
    }
    return $result;
}
// hash equals. 외부 라이브러리. csrf 검증을 위함.
// php 5.3+ 버전이었으나 5.2 로 컨버팅함.
// 이철성
if (!function_exists('hash_equals')) {
    defined('USE_MB_STRING') or define('USE_MB_STRING', function_exists('mb_strlen'));

    /**
     * hash_equals — Timing attack safe string comparison
     *
     * Arguments are null by default, so an appropriate warning can be triggered
     *
     * @param string $known_string
     * @param string $user_string
     *
     * @link http://php.net/manual/en/function.hash-equals.php
     *
     * @return boolean
     */
    function hash_equals($known_string = null, $user_string = null)
    {
        if ($known_string == null || $user_string == null) {
            return false;
        }

        $argc = func_num_args();
        // Check the number of arguments
        if ($argc < 2) {
            trigger_error(sprintf('hash_equals() expects exactly 2 parameters, %d given', $argc), E_USER_WARNING);
            return null;
        }
        // Check $known_string type
        if (!is_string($known_string)) {
            trigger_error(sprintf('hash_equals(): Expected known_string to be a string, %s given', strtolower(gettype($known_string))), E_USER_WARNING);
            return false;
        }
        // Check $user_string type
        if (!is_string($user_string)) {
            trigger_error(sprintf('hash_equals(): Expected user_string to be a string, %s given', strtolower(gettype($user_string))), E_USER_WARNING);
            return false;
        }
        // Compare string lengths
        if (($length = csrfStrLen($known_string)) !== csrfStrLen($user_string)) {
            return false;
        }
        $diff = 0;
        // Calculate differences
        for ($i = 0; $i < $length; $i++) {
            $diff |= ord($known_string[$i]) ^ ord($user_string[$i]);
        }
        return $diff === 0;
    }
}

/**
 * 멀티바이트 캐릭터일 경우 8비트 기준 length 구하기
 * 이철성
 */
function csrfStrLen($string)
{
    if (USE_MB_STRING) {
        return mb_strlen($string, '8bit');
    }
    return strlen($string);
    //return csrfStrLen($string);
}

/**
 * csrf 체크후 토큰에 문제가 있을 경우 메세지를 띄움
 * 이철성
 */
function valCsrf()
{
//    if (!valCsrfToken(($_POST['csrfToken'] ?? ''))) {
//        echo "<script>
//				alert('비정상적인 접근입니다.');
//			</script>";
//        exit;
//    }
}
if (!function_exists("GetThisCategory")) {

    function GetThisCategory($this_cid, $this_depth)// 해당 카테고리 이름을 반환하는 함수
    {
        global $slave_db;
        //$slave_db = new Database;

        $sql = "select c.cid,c.cname from mallstory_category_info c where cid LIKE '".substr($this_cid, 0, ($this_depth + 1) * 3)."%' and depth = '".$this_depth."'  ";

        $slave_db->query($sql);

        $slave_db->fetch(0);

        return $slave_db->dt['cname'];
    }
}
