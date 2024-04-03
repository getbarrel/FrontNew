<?php
/**
 * SNS 관련 설정 파일
 *
 * @author		Caesar <ddong0927@naver.com>
 * @copyright	2007-2011 ForBiz
 * @version		1.0
 * @package
 */
defined('TBL_SNS_CATEGORY_INFO') OR define('TBL_SNS_CATEGORY_INFO', 'sns_category_info');     // SNS 카테고리 정보
defined('TBL_SNS_CATEGORY_ADDFIELD') OR define('TBL_SNS_CATEGORY_ADDFIELD', 'sns_category_addfield');   // 사용 안하는 듯
// 상품관련 테이블
defined('TBL_SNS_PRODUCT_RELATION') OR define('TBL_SNS_PRODUCT_RELATION', 'sns_product_relation');    // SNS 상품 카테고리 릴레이션
defined('TBL_SNS_BRAND') OR define('TBL_SNS_BRAND', 'sns_brand');         // SNS 브랜드
defined('TBL_SNS_COMPANY') OR define('TBL_SNS_COMPANY', 'sns_company');        // SNS 제조사
defined('TBL_SNS_IMAGE_RESIZEINFO') OR define('TBL_SNS_IMAGE_RESIZEINFO', 'sns_image_resizeinfo');    // SNS 이미지 리사이징 정보
defined('TBL_SNS_PRODUCT_ETCINFO') OR define('TBL_SNS_PRODUCT_ETCINFO', 'sns_product_etcInfo');
defined('TBL_SNS_COUPON_INFO') OR define('TBL_SNS_COUPON_INFO', 'sns_coupon_info');      // SNS 쿠폰정보 테이블
defined('TBL_SNS_PRODUCT_COMMENT') OR define('TBL_SNS_PRODUCT_COMMENT', 'sns_product_comment');
defined('TBL_SNS_RECOMMEND_PRODUCT_RELATION') OR define('TBL_SNS_RECOMMEND_PRODUCT_RELATION', 'sns_recommend_product_relation'); //만료된 쿠폰 앵콜요청 히스토리
defined('TBL_SNS_FREEPRODUCT') OR define('TBL_SNS_FREEPRODUCT', 'sns_freeproduct');    //무료쿠폰 테이블
defined('TBL_SNS_FREEPRODUCT_DIV') OR define('TBL_SNS_FREEPRODUCT_DIV', 'sns_freeproduct_div');  //무료쿠폰 카테고리
defined('TBL_SNS_FREEGOODSHISTORY') OR define('TBL_SNS_FREEGOODSHISTORY', 'sns_freegoodshistory');  //무료쿠폰 다운히스토리

defined('TBL_SNS_PRODUCT') OR define('TBL_SNS_PRODUCT', 'shop_product');       // SNS 상품 정보 (현재 기존 몰과 같이 씀)
defined('TBL_SNS_PRODUCT_OPTIONS_DETAIL') OR define('TBL_SNS_PRODUCT_OPTIONS_DETAIL', 'shop_product_options_detail');   // SNS 상품 옵션 (현재 기존 몰과 같이 씀)
defined('TBL_SNS_PRODUCT_OPTIONS') OR define('TBL_SNS_PRODUCT_OPTIONS', 'shop_product_options');   // SNS 상품 옵션 상세 (현재 기존 몰과 같이 씀)
defined('TBL_SNS_PRICEINFO') OR define('TBL_SNS_PRICEINFO', 'shop_priceinfo');    // SNS 상품 가격정보 (현재 기존 몰과 같이 씀)
defined('TBL_SNS_CART') OR define('TBL_SNS_CART', 'shop_cart');
defined('TBL_SNS_PRODUCT_BUYINGSERVICE_PRICEINFO') OR define('TBL_SNS_PRODUCT_BUYINGSERVICE_PRICEINFO', 'shop_product_buyingservice_priceinfo'); // SNS 비지니스상품 가격정보 (현재 기존 몰과 같이 씀)
defined('TBL_SNS_RELATION_PRODUCT') OR define('TBL_SNS_RELATION_PRODUCT', 'shop_relation_product');  // SNS 상품 관련상품 릴레이션 (현재 기존 몰과 같이 씀)
defined('TBL_SNS_IMAGE_RESIZEINFO') OR define('TBL_SNS_IMAGE_RESIZEINFO', 'shop_image_resizeinfo');  // 이미지 썸네일 정보 (현재 기존 몰과 같이 씀)
defined('TBL_SNS_ADDIMAGE') OR define('TBL_SNS_ADDIMAGE', 'shop_addimage');      // 상품 추가 이미지 정보 (현재 기존 몰과 같이 씀)
defined('TBL_SNS_PRODUCT_DISPLAYINFO') OR define('TBL_SNS_PRODUCT_DISPLAYINFO', 'shop_product_displayinfo'); // 상품 추가 정보 (현재 기존 몰과 같이 씀)
defined('TBL_SNS_ICON') OR define('TBL_SNS_ICON', 'shop_icon');        // 상품 아이콘 정보 (현재 기존 몰과 같이 씀)
defined('TBL_SNS_COMPANYINFO') OR define('TBL_SNS_COMPANYINFO', 'shop_companyinfo');     // 회사정보 (현재 기존 몰과 같이 씀)
defined('TBL_SNS_REGION_DELIVERY') OR define('TBL_SNS_REGION_DELIVERY', 'shop_region_delivery');    //  (현재 기존 몰과 같이 씀)
// 주문관련 테이블
defined('TBL_SNS_ORDER') OR define('TBL_SNS_ORDER', 'shop_order');
defined('TBL_SNS_ORDER_DETAIL') OR define('TBL_SNS_ORDER_DETAIL', 'shop_order_detail');
defined('TBL_SNS_ORDER_DELIVERY') OR define('TBL_SNS_ORDER_DELIVERY', 'shop_order_delivery');
defined('TBL_SNS_ORDER_DELIVERY_STATUS') OR define('TBL_SNS_ORDER_DELIVERY_STATUS', 'shop_order_status');

//회원관련 테이블
defined('TBL_SNS_MEMBER') OR define('TBL_SNS_MEMBER', 'common_member_detail');    //  (현재 기존 몰과 같이 씀)
defined('TBL_SNS_GROUPINFO') OR define('TBL_SNS_GROUPINFO', 'shop_groupinfo');    //  (현재 기존 몰과 같이 씀)
// 쿠폰상태 관련
defined('SNS_COUPON_STATUS_READY') OR define('SNS_COUPON_STATUS_READY', "R"); // SNS 쿠폰 사용대기
defined('SNS_COUPON_STATUS_EXPIRE') OR define('SNS_COUPON_STATUS_EXPIRE', "E"); // SNS 쿠폰 기간만료
defined('SNS_COUPON_STATUS_COMPLETE') OR define('SNS_COUPON_STATUS_COMPLETE', "C"); // SNS 쿠폰 사용완료
// SNS 구분자값
$ShopType = "SNS";

function fetch_sns_category()
{
    global $db;
    $db->query("SELECT * FROM ".TBL_SNS_CATEGORY_INFO." where category_use = 1 and depth = 0 order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5");

    return $db->fetchall();
    exit;
}

function fetch_snsCategoryName($cid)
{
    global $db;
    $db->query("SELECT cname FROM ".TBL_SNS_CATEGORY_INFO." where cid = '".$cid."' ");
    $db->fetch();

    return $db->dt['cname'];
    exit;
}

function GetSNSCategory($subcid, $subdepth)// 상위 카테고리 이름을 반환하는 함수
{
    $mdb = new Database;

    $sql = "select c.cid,c.cname from ".TBL_SNS_CATEGORY_INFO." c where cid LIKE '".substr($subcid, 0, $subdepth * 3)."%' and depth = ".($subdepth - 1)."  ";

    $mdb->query($sql);
    $mdb->fetch(0);

    $category_string = $mdb->dt[cname];

    if ($subdepth > 1) {
        $sql = "select c.cid,c.cname from ".TBL_SNS_CATEGORY_INFO." c where cid LIKE '".substr($subcid, 0, ($subdepth - 1) * 3)."%' and depth = ".($subdepth
            - 2)."  ";
        $mdb->query($sql);
        $mdb->fetch(0);

        $category_string = $mdb->dt[cname]." > ".$category_string;
    }



    return $category_string;
}
