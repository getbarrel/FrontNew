<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

ms_auth();

// View get
$view = getForbizView();

$tpl = $view->tpl;
$view->define('mypage_top', 'mypage/mypage_top/mypage_top.htm');
$view->define('mypage_bottom', 'mypage/mypage_bottom/mypage_bottom.htm');

$p_type = gVal('p_type');
if ($p_type != "") {
    $tpl->assign('p_type', $p_type);
} else {
    $tpl->assign('p_type', "");
}

$db = new Database;
$db2 = new Database;

$max = 10;

if (($page ?? '') == '') {
    $start = 0;
    $page = 1;
} else {
    $start = ($page - 1) * $max;
}



$sql = "select sattle_module from shop_shopinfo where mall_ix = '" . $layout_config['mall_ix'] . "'";
$db2->query($sql);
$db2->fetch();

$before10day = mktime(0, 0, 0, date("m"), date("d") - 10, date("Y"));

$receipt_array = array('0', '1', '2', 'x');
$tpl->assign('receipt_array', $receipt_array);


$month = gVal('month');
/* 모바일 검색시 사용 */
switch ($month) {
    case 1:
        $sDate = date('Y-m-d');
        $eDate = date('Y-m-d');
        break;
    case 2:
        $sDate = date("Y-m-d", strtotime("-1 week"));
        $eDate = date('Y-m-d');
        break;
    case 3:
        $sDate = date("Y-m-d", strtotime("-1 month")); // 한달 전
        $eDate = date('Y-m-d');
        break;
    case 6:
        $sDate = date("Y-m-d", strtotime("-6 month")); // 6달 전
        $eDate = date('Y-m-d');
        break;
    case 12:
        $sDate = date("Y-m-d", strtotime("-12 month")); // 12달 전
        $eDate = date('Y-m-d');
        break;
}
/* 끝 */

$sDate = gVal('sDate');
$eDate = gVal('eDate');
if (!$sDate == "") {
    $sDate = $sDate;
    $eDate = $eDate;
    $startDate = $sDate . " 00:00:00";
    $endDate = $eDate . " 23:59:59";
}

$tpl->assign('sDate', $sDate);
$tpl->assign('eDate', $eDate);

$where = "";

if (($startDate ?? '') != "" && ($endDate ?? '') != "") {
    $where .= " and  o.order_date between '$startDate' and '$endDate' ";
}

if (is_array(($m_useopt ?? ''))) {
    if ($m_useopt[0] != "") {
        if (count($m_useopt) == 1 && in_array("X", $m_useopt)) {
            $where .= " and ( ";
        } else {
            $where .= " and (r.m_useopt in(";
        }

        for ($i = 0; $i < count($m_useopt); $i++) {

            //if($m_useopt[$i] == count($m_useopt)-1)

            if ($i == 0) {
                $where .= " ";
            } else if ($i != count($m_useopt) - 1) {
                $where .= ", ";
            }

            if ($m_useopt[$i] == "0")
                $where .= " 0";
            elseif ($m_useopt[$i] == "1")
                $where .= " 1";
            elseif ($m_useopt[$i] == "2")
                $where .= " 2";
            //elseif($m_useopt[$i]=="X")	$where.=" 'X'";
            elseif ($m_useopt[$i] == "X")
                $is_null = " (r.m_useopt IS NULL AND op.receipt_yn = 'N' AND method in (0,5,4,12))";
        }

        if (count($m_useopt) == 1 && in_array("X", $m_useopt)) {
            $where .= $is_null . ")";
        } else {
            if ($is_null) {
                $where .= " ) or" . $is_null . ")";
            } else {
                $where .= " ))";
            }
        }
    }
} else {
    $m_useopt = array();
}

$tpl->assign("m_useopt", $m_useopt);

//echo $where;
$where .= " AND op.pay_status='IC' AND pay_type='G' AND method != '" . ORDER_METHOD_RESERVE . "' ";


$sql = "select * from " . TBL_SHOP_ORDER . " o LEFT JOIN shop_order_payment op ON o.oid=op.oid LEFT JOIN receipt r ON o.oid=r.order_no LEFT JOIN receipt_result rs ON rs.oid=o.oid  where o.user_code = '" . $user['code'] . "' " . $where . " group by o.oid ";
$db->query($sql);
$db->fetchall();

$total = $db->total;

$m_useopt_div = '';
foreach ($m_useopt as $key => $value) {
    $m_useopt_div .= "&m_useopt[]=" . $value;
}

$pagestring = product_page_bar($total, $page, $max, "$m_useopt_div&sDate=$sDate&eDate=$eDate&p_type=$p_type");
$tpl->assign("page_string", $pagestring);


$sql = "select
				o.oid,o.status,o.order_date,o.payment_price, date_format(op.ic_date,'%Y-%m-%d') as ic_date,
				op.taxsheet_yn,op.receipt_yn,op.tax_affairs_yn ,r.receipt_yn AS result, rs.m_tid, r.order_no AS r_row ,rs.m_rcash_noappl, r.m_useopt,
				(select CONCAT(od.pname,' ',case when count(*)>1 then CONCAT('외 ',(count(*) - 1),'건') else '' end ,case when od.option_text!='' then concat('<br/>',od.option_text) else '' end) as product_text from shop_order_detail od where od.oid=o.oid) as product_text, count(*) as rowspan_cnt
			from 
				" . TBL_SHOP_ORDER . " o 
				LEFT JOIN shop_order_payment op ON o.oid=op.oid
				LEFT JOIN receipt r ON o.oid=r.order_no 
				LEFT JOIN receipt_result rs ON rs.oid=o.oid 
			where 
				o.user_code = '" . $user['code'] . "' " . $where . "
			group by o.oid
			order by o.order_date desc
			limit $start,$max";
//echo nl2br($sql);
$db->query($sql);
$receipt = $db->fetchall();

$tpl->assign('receipt', $receipt);
$tpl->assign('sattle_module', $db2->dt['sattle_module']);


if ($db2->dt["sattle_module"] == "kcp") {
    $sql = "SELECT kcp_id from shop_shopinfo where mall_ix = '" . $layout_config['mall_ix'] . "' AND mall_domain='" . str_replace("www.", "", $_SERVER["SERVER_NAME"]) . "' ";
    $db2->query($sql);
    $db2->fetch();
    $tpl->assign("kcp_id", $db2->dt["kcp_id"]);
} else if ($db2->dt["sattle_module"] == "lgdacom") {
    $sql = "SELECT lgdacom_id from shop_shopinfo where mall_ix = '" . $layout_config['mall_ix'] . "' AND mall_domain='" . str_replace("www.", "", $_SERVER["SERVER_NAME"]) . "' ";
    $db2->query($sql);
    $db2->fetch();
    $tpl->assign("lgdacom_id", $db2->dt["lgdacom_id"]);
}

//$P->Contents = $tpl->fetch('004019000000000');
//echo $P->LoadLayOut();

function getCashReceipt($oid)
{
    $mdb = new Database;

    $mdb->query("select m_tid from receipt_result where oid = '" . $oid . "' ");
    $mdb->fetch();
    return $mdb->dt['m_tid'];
}

function payment_method($oid)
{
    $db = new Database;

    $sql = "select op.* ,r.receipt_yn AS result, rs.m_tid, r.order_no AS r_row ,rs.m_rcash_noappl, r.m_useopt
	from shop_order_payment op
	LEFT JOIN receipt r ON op.oid=r.order_no 
	LEFT JOIN receipt_result rs ON rs.oid=op.oid 
	where op.oid = '" . $oid . "' AND pay_type='G' AND method != '" . ORDER_METHOD_RESERVE . "' 
	";

    $db->query($sql);
    return $db->fetchall("object");
}

function chackReceiptBoll($ic_date)
{

    $date_info = explode("-", $ic_date);
    $ic_time = mktime(0, 0, 0, $date_info[1], "01", $date_info[0]);
    $next_date = date('Ym05', strtotime("+1 month", $ic_time));

    if ($next_date >= date("Ymd")) {
        return true;
    } else {
        return false;
    }
}
// Layout 출력
echo $view->loadLayout();
