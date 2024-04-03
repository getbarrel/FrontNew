<?php
/**
 * Created by PhpStorm.
 * User: moon
 * Date: 2017-07-11
 * Time: 오후 1:34
 */
//PG 결제 완료 시 입금 완료 상태로 접근 할 경우 프로세스 처리
$db        = getForbiz()->import('db.db');
$master_db = getForbiz()->import('db.master');

if ($status == "IC") {
    $ic_date_str = ", ic_date=NOW() ";

    $db->query("select expect_product_price, expect_delivery_price from shop_order_price where oid = '".$ordr_idxx."' and payment_status ='G'");
    $db->fetch();

    table_order_price_data_creation($ordr_idxx, '', '', 'G', 'P', 0, $db->dt['expect_product_price'], "", 0, 0, 0);
    table_order_price_data_creation($ordr_idxx, '', '', 'G', 'D', 0, $db->dt['expect_delivery_price'], "", 0, 0, 0);

    $master_db->query("update shop_order_payment set pay_status='IC', ic_date=NOW() where oid='".$ordr_idxx."'");
}

//앱 첫 구매시 쿠폰 발행 프로세스
require(OLDBASE_ROOT."/shop/first_app_purchase.php");

if ($_SESSION['order']['deposit_price'] > 0 && $_SESSION['order']['deposit_price'] != "") {
    /* 예치금 처리 관련 데이터 JK160804 */
    $deposit_data                 = array();
    $deposit_data['user_code']    = $user['code'];
    $deposit_data['oid']          = $ordr_idxx;
    $deposit_data['deposit']      = $_SESSION['order']['deposit_price'];
    $deposit_data['history_type'] = '4';
    $deposit_data['etc']          = '상품구매시 예치금 사용완료';
    $deposit_data['use_type']     = 'W';

    if (function_exists(DepositManagement)) {
        DepositManagement($deposit_data);
    }

    table_order_price_data_creation($ordr_idxx, '', '', 'G', 'P', 0, 0, "", 0, 0, $_SESSION['order']['deposit_price']);
}


if ($_SESSION['order']['reserve_price'] > 0 && $_SESSION['order']['reserve_price'] != "") {
    table_order_price_data_creation($ordr_idxx, '', '', 'G', 'P', 0, 0, "", $_SESSION['order']['reserve_price'], 0, 0);

    /* 신규 포인트,마일리지 접립 함수 JK 160405 */
    $mileage_data['uid']        = $user['code'];
    $mileage_data['type']       = 1;
    $mileage_data['mileage']    = $_SESSION['order']['reserve_price'];
    $mileage_data['message']    = '마일리지 사용';
    $mileage_data['state_type'] = 'use';
    $mileage_data['save_type']  = 'mileage';
    $mileage_data['oid']        = $ordr_idxx;
    $mileage_data['od_ix']      = $od_ix;
    $mileage_data['pid']        = $id;
    InsertMileageInfo($mileage_data);
}

//쿠폰 사용 처리
if ($_SESSION['order']['cart_coupon']['cart_coupon_price'] > 0 && $_SESSION['order']['cart_coupon']['cart_coupon_price'] != "") {
    $sql = "update shop_cupon_regist set use_yn='1', use_oid='".$ordr_idxx."' where regist_ix = '".$_SESSION['order']['cart_coupon']['tid']."' ";
    $db->query($sql);
}


$sql = "select opay_ix from shop_order_payment where oid='".$ordr_idxx."' and pay_type='G' and method='".$nPaymethod."' ";
$db->query($sql);

$db->fetch();
$opay_ix     = $db->dt['opay_ix'];
$master_db->query("update shop_order_payment set vb_info='".$v_bank."', bank_input_name='".$bank_input_name."', bank_input_date='".$bank_input_date."', card_info='".($card_info
            ?? '')."', settle_module='".$pg_com."', tid='".$tid."', authcode='".$app_no."' , memo='".($pg_memo ?? '')."' , escrow_use='".(($escrow_use
            ?? '') == "Y" ? "Y" : "N")."' where opay_ix='".$opay_ix."'");
$master_db->query("update shop_order set status = '$status' where oid = '$ordr_idxx'");
$ic_date_str = $ic_date_str ?? '';
$master_db->query("update shop_order_detail set status = '$status' $ic_date_str where oid = '$ordr_idxx'");

set_order_status($ordr_idxx, $status, "$strCard 완료", "시스템", "");

//셀러판매신용점수 추가 시작 2014-06-15 이학봉
$sql = "select * from shop_order_detail where oid = '".$ordr_idxx."' and status = 'IC'";

$db->query($sql);
$od_infos = $db->fetchall("object");
for ($i = 0; $i < count($od_infos); $i++) {
    InsertPenaltyInfo('1', '1', $ordr_idxx, $od_infos[$i]['od_ix'], $penalty, $od_infos[$i]["company_id"], '입금완료 판매신용점수 추가', '', 'ic');
    insertProductPoint('1', POINT_USE_STATE_IC, $ordr_idxx, $od_infos[$i]['od_ix'], $point, $od_infos[$i]["pid"], '입금완료 상품점수 추가', '', 'ic');
}
//셀러판매신용점수 추가 끝 2014-06-15 이학봉
//증빙문서 처리
if ($nPaymethod == ORDER_METHOD_CARD || $nPaymethod == ORDER_METHOD_PHONE) {
    if ($_SESSION['order']['taxbill_apply'] == "T") {
        $receipt_where = " and method in ('".ORDER_METHOD_SAVEPRICE."','".ORDER_METHOD_RESERVE."') ";
    } else {
        $receipt_where = " and method in ('".ORDER_METHOD_SAVEPRICE."') ";
    }
} else {
    if ($_SESSION['order']['taxbill_apply'] == "T") {
        $receipt_where = " and method in ('".$nPaymethod."','".ORDER_METHOD_SAVEPRICE."','".ORDER_METHOD_RESERVE."') ";
    } else {
        $receipt_where = " and method in ('".$nPaymethod."','".ORDER_METHOD_SAVEPRICE."') ";
    }
}

$ReceiptType = $ReceiptType ?? '';
if ($_SESSION['order']['taxbill_apply'] == "T") {
    $master_db->query("update shop_order_payment set taxsheet_yn='Y', tax_com_name='".$_SESSION['order']['tax_com_name']."', tax_com_ceo='".$_SESSION['order']['tax_com_ceo']."', tax_com_number='".$_SESSION['order']['tax_com_number']."' where oid='".$ordr_idxx."' and pay_type='G' ".$receipt_where." ");
} elseif ($_SESSION['order']['taxbill_apply'] == "R" || ($ReceiptType == 1 || $ReceiptType == 2)) {

    $master_db->query("update shop_order_payment set receipt_yn='Y' where oid='".$ordr_idxx."' and pay_type='G' ".$receipt_where." ");

    if ($RECEIPT_RESULT["result"] == "Y") {
        $master_db->query("insert into receipt(order_no,m_useopt,m_number,id,rname,receipt_yn,regdate)
						values('".$ordr_idxx."','".$RECEIPT_RESULT["m_useopt"]."','".ereg_replace("[^0-9+]", "", $_SESSION['order']['m_number'])."','".$user['id']."','".$_SESSION['order']['name_a']."','C',NOW())");

        $master_db->query("insert into receipt_result(oid,m_rcash_noappl,m_tid,m_payment_price,m_save_price,m_rcr_price,m_rsup_price,m_rtax,m_rsrvc_price,m_ruseopt,regdate)
						values('".$ordr_idxx."','".$RECEIPT_RESULT["m_rcash_noappl"]."','".$RECEIPT_RESULT["m_tid"]."','".$RECEIPT_RESULT["m_payment_price"]."','".$_SESSION['order']['deposit_price']."','".($RECEIPT_RESULT["m_payment_price"]
            - $_SESSION['order']['deposit_price'])."','".$RECEIPT_RESULT["m_rsup_price"]."','".$RECEIPT_RESULT["m_rtax"]."','".$RECEIPT_RESULT["m_rsrvc_price"]."','".$RECEIPT_RESULT["m_useopt"]."',NOW())");
    } elseif ($RECEIPT_RESULT["result"] == "E") {
        set_order_status($ordr_idxx, $status, "현금영수증 발급 실패[".$RECEIPT_RESULT["result_msg"]."]", "시스템", "");
    }

    if ($RECEIPT_RESULT["result"] != "Y") {
        $master_db->query("insert into receipt(order_no,m_useopt,m_number,id,rname,receipt_yn,regdate)
					values('".$ordr_idxx."','".$_SESSION['order']['m_useopt']."','".ereg_replace("[^0-9+]", "", $_SESSION['order']['m_number'])."','".$user['id']."','".$_SESSION['order']['name_a']."','Y',NOW())");
    }
}

$user_code = $_SESSION['user']['code'];

//배송비 쿠폰 처리
if (count($_SESSION['order']['delivery_cupon_code']) > 0) {
    foreach ($_SESSION['order']['delivery_cupon_code'] as $company_id => $datas) {
        foreach ($datas as $pid => $infos) {
            foreach ($infos as $delivery_type => $datas_1) {
                foreach ($datas_1 as $delivery_package => $datas_2) {
                    foreach ($datas_2 as $delivery_method => $datas_3) {
                        foreach ($datas_3 as $delivery_pay_method => $datas_4) {
                            foreach ($datas_4 as $delivery_addr_use => $datas_5) {
                                foreach ($datas_5 as $addr_ix => $regist_ix) {
                                    $master_db->query("update ".TBL_SHOP_CUPON_REGIST." set use_oid = '".$_SESSION['order']['oid']."', use_yn = 1, usedate = NOW() where regist_ix = '".$regist_ix."'");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

//장바구니 쿠폰 사용 처리
if (sess_val('order', 'cart_coupon', 'tid')) {
    $master_db->query("update ".TBL_SHOP_CUPON_REGIST." set use_oid = '".$_SESSION['order']['oid']."', use_yn = 1, usedate = NOW() where regist_ix = '".$_SESSION['order']['cart_coupon']['tid']."'");
}


$sql          = "select * from ".TBL_SHOP_ORDER_DETAIL." where oid = '".$ordr_idxx."' ";
$db->query($sql);
$order_detail = $db->fetchall();

if (is_array($order_detail)) {
    foreach ($order_detail as $od) {
        $cart_ix          = $od['cart_ix'];
        $pid              = $od['pid'];
        $product_type     = $od['product_type'];
        $hotcon_event_id  = $od['hotcon_event_id'];
        $hotcon_pcode     = $od['hotcon_pcode'];
        $count            = $od['pcnt'];
        $pcode            = $od['pcode'];
        $select_option_id = $od['option_id'];
        $stock_use_yn     = $od['stock_use_yn'];

        if ($_SESSION['order']['use_cupon_code'][$cart_ix]) {
            $master_db->query("update ".TBL_SHOP_CUPON_REGIST." set use_oid = '".$_SESSION['order']['oid']."', use_pid = '".$pid."', use_yn = 1, usedate = NOW() where regist_ix = '".$_SESSION['order']['use_cupon_code'][$cart_ix]."'");
        }

        if (sess_val('order','use_add_cupon_code',$cart_ix)) {
            $master_db->query("update ".TBL_SHOP_CUPON_REGIST." set use_oid = '".$_SESSION['order']['oid']."', use_pid = '".$pid."', use_yn = 1, usedate = NOW() where regist_ix = '".$_SESSION['order']['use_add_cupon_code'][$cart_ix]."'");
        }

        if ($stock_use_yn == "Y") {

            $pid_array   = array();
            $pid_array[] = $pid;

            $sql = "select od.id as opnd_ix ,pid from ".TBL_SHOP_PRODUCT." p inner join ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." od on (p.id=od.pid) where p.stock_use_yn='Y' and option_code = '".$pcode."' ";
            $master_db->query($sql);
            if ($master_db->total) {

                $option_dt_info = $master_db->fetchall("object");
                for ($j = 0; $j < count($option_dt_info); $j++) {

                    $pid_array[] = $option_dt_info[$j]['pid'];
                    $master_db->query("update ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." set option_sell_ing_cnt = option_sell_ing_cnt + '".$count."' where id = '".$option_dt_info[$j]['opnd_ix']."' ");
                }
                $pid_array = array_unique($pid_array);
            }

            $master_db->query("update ".TBL_SHOP_PRODUCT." set sell_ing_cnt = sell_ing_cnt + '".$count."', order_cnt = order_cnt + '".$count."' where id in ('".implode("','",
                    $pid_array)."') ");

            $master_db->query("update inventory_goods_unit set sell_ing_cnt = sell_ing_cnt + '".$count."', order_cnt = order_cnt + '".$count."' where gu_ix ='$pcode' ");

            //real_lack_stock update
            if ($pcode) {

                $sql = "select real_lack_stock from shop_order_detail  where gu_ix = '".$pcode."' and status in ('IR','IC','DR','DD') and oid !='".$_SESSION['order']['oid']."' order by regdate desc limit 0,1";
                $master_db->query($sql);
                if ($master_db->total) {
                    $master_db->fetch();

                    $item_stock_sum = $master_db->dt['real_lack_stock'];
                } else {
                    $sql = "select sum(ps.stock) as stock
				from inventory_goods_unit gu  left join inventory_product_stockinfo ps on (ps.unit = gu.unit and ps.gid=gu.gid)
				where gu.gu_ix = '".$pcode."' ";
                    $master_db->query($sql);
                    $master_db->fetch();

                    $item_stock_sum = $master_db->dt['stock'];
                }

                $sql = "select od_ix, pcnt from shop_order_detail  where oid='".$_SESSION['order']['oid']."' and gu_ix = '".$pcode."'";
                $master_db->query($sql);

                if ($master_db->total) {
                    $od_info = $master_db->fetchall("object");

                    $real_lack_stock = $item_stock_sum;

                    for ($j = 0; $j < count($od_info); $j++) {
                        $real_lack_stock -= $od_info[$j]['pcnt'];
                        $sql             = "update shop_order_detail set real_lack_stock='".$real_lack_stock."' where od_ix='".$od_info[$j]['od_ix']."' ";
                        $master_db->query($sql);
                    }
                }
            }
        } elseif ($stock_use_yn == "Q") {
            $master_db->query("update ".TBL_SHOP_PRODUCT." set sell_ing_cnt = sell_ing_cnt + '".$count."', order_cnt = order_cnt + '".$count."' where id ='$pid'");
            $master_db->query("update ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." set option_sell_ing_cnt = option_sell_ing_cnt + '".$count."' where pid = '$pid' and id ='$select_option_id' ");
        } else {
            $master_db->query("update ".TBL_SHOP_PRODUCT." set order_cnt = order_cnt + '".$count."' where id ='$pid'");
        }


        if ($product_type == 3) {
            if ($status == "IC") {
                $result = CallHotCon($user_code, $_SESSION['order']['oid'], $pid, $hotcon_event_id, $hotcon_pcode, $count,
                    $_SESSION['order']['pcs1_b']."".$_SESSION['order']['pcs2_b']."".$_SESSION['order']['pcs3_b']);
                $result = iconv("CP949", "UTF-8", $result);
            }
        }

        if (is_mobile()) {
            $agent_type = "M";
        } else {
            $agent_type = "W";
        }
        $bl = gVal('bl');
        $bl->agent_type = $agent_type;
        $bl->CommerceLogic($_SESSION["user"]["code"], 6, $od['cid'], $od['pid'], $od['pcnt'], $od['psprice'] + $od['option_price']);
    }
}


$info_result = "OK";

