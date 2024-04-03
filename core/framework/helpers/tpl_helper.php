<?php
if (!function_exists('showdate')) {

    function showdate($date)
    {
        $date = date("Y년 n월 j일 a g시 i분", $date);
        $date = str_replace("am", "오전", $date);
        $date = str_replace("pm", "오후", $date);
        $date = ereg_replace("0([0-9]분)", "\\1", $date);

        return $date;
    }
}

if (!function_exists('useafter_yn')) {

    function useafter_yn($pid)
    {
        global $db;

        $sql = "SELECT COUNT(bbs_ix) AS cnt FROM bbs_after WHERE bbs_etc1='".$pid."' AND mem_ix='".$_SESSION["user"]["code"]."' ";
        $db->query($sql);
        $db->fetch();
        $cnt = $db->dt["cnt"];

        return $cnt;
    }
}

if (!function_exists('use_primiumafter_yn')) {

    function use_primiumafter_yn($pid)
    {
        global $db;

        $sql = "SELECT COUNT(bbs_ix) AS cnt FROM bbs_premium_after WHERE bbs_etc1='".$pid."' AND mem_ix='".$_SESSION["user"]["code"]."' ";
        $db->query($sql);
        $db->fetch();
        $cnt = $db->dt["cnt"];

        return $cnt;
    }
}

if (!function_exists('get_order_delivery_price')) {

    function get_order_delivery_price($company_id, $oid)
    {
        $db = new Database;

        $sql = "SELECT delivery_price,delivery_pay_type FROM shop_order_delivery WHERE oid='".$oid."' AND company_id='".$company_id."' ";
        $db->query($sql);

        return $db->fetchall();
    }
}

if (!function_exists('get_cancel_compare_count')) {

    function get_cancel_compare_count($oid)
    {//주문 상세 수와 입금 예정인 주문 상세 수 비교 kbk 13/07/14
        $mdb = new Database;

        $sql    = "SELECT COUNT(od.od_ix) AS od_cnt, (SELECT COUNT(od_ix) FROM ".TBL_SHOP_ORDER_DETAIL." WHERE oid=o.oid AND status IN ('IR')) AS ir_cnt FROM ".TBL_SHOP_ORDER." o LEFT JOIN ".TBL_SHOP_ORDER_DETAIL." od ON o.oid=od.oid WHERE o.oid='".$oid."' ";
        $mdb->query($sql);
        $mdb->fetch();
        $od_cnt = $mdb->dt["od_cnt"];
        $ir_cnt = $mdb->dt["ir_cnt"];

        if ($od_cnt == $ir_cnt) {
            return true;
        } else {
            return false;
        }
    }
}