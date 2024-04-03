<?php
/**
 * Created by PhpStorm.
 * User: moon
 * Date: 2017-06-22
 * Time: 오후 5:48
 */
require_once(OLDBASE_ROOT.'/shop/inipay_standard/libs/INIStdPayUtil.php');
require_once(OLDBASE_ROOT.'/shop/inipay_standard/libs/sha256.inc.php');
$SignatureUtil = new INIStdPayUtil();


if($pg_info['service_type'] == 'service' ){
    $mid = $pg_info['mid'];
    $signKey = $pg_info['service_key'];
    $pg_script = "<script language=\"javascript\" type=\"text/javascript\" src=\"HTTPS://stdpay.inicis.com/stdjs/INIStdPay.js\" charset=\"UTF-8\"></script>";
}else{
    $mid = "INIpayTest";  // 가맹점 ID(가맹점 수정후 고정)
    $signKey = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; // 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지
    $pg_script = "<script language=\"javascript\" type=\"text/javascript\" src=\"https://stgstdpay.inicis.com/stdjs/INIStdPay.js\" charset=\"UTF-8\"></script>";
}

$timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성
$orderNumber = $_SESSION['order']['oid'];
$price = $_SESSION['order']['payment_price'];

if(count($carts3) > 1){
    $pname = cut_str( $carts3[0]['pname'], 20 ) . " 외 " . count($carts3) . "건";
}else{
    $pname = cut_str( $carts3[0]['pname'], 25 );
}
$pcs = $_SESSION['order']['pcs1_a']."-".$_SESSION['order']['pcs2_a']."-".$_SESSION['order']['pcs3_a'];

switch( $_SESSION['order']['pay_method'] ){
    case 'Card':	//신용카드
        if(is_mobile()){
            $paymethod = 'wcard';
        }else {
            $paymethod = 'Card';
        }
        break;
    case 'virtual':	//무통장입금(가상계좌)
        if(is_mobile()){
            $paymethod = 'vbank';
        }else {
            $paymethod = 'VBank';
        }
        break;
    case 'iche':	//실시간계좌이체
        if(is_mobile()){
            $paymethod = 'bank';
        }else{
            $paymethod = 'DirectBank';
        }
        break;
    case 'OCB':	//OKCashbag
        $paymethod = 'OCBPoint';
        break;
    case 'mobile':	//핸드폰
        if(is_mobile()){
            $paymethod = 'mobile';
        }else {
            $paymethod = 'HPP';
        }
        break;
    case 'Phone':	//폰빌, 전화결제
        $paymethod = 'PhoneBill';
        break;
    case 'Culture':	//문화상품권결제
        if(is_mobile()){
            $paymethod = 'culture';
        }else {
            $paymethod = 'Culture';
        }
        break;
    case 'DGCL':	//스마트문상 결제
        $paymethod = 'Culture';
        break;
    case 'TeenCash':	//틴캐시
        $paymethod = 'TeenCash';
        break;
    case 'Bcsh':	//도서문화상품권
        $paymethod = 'Bcsh';
        break;
    case 'HPMN':	//해피머니상품권
        if(is_mobile()){
            $paymethod = 'hpmn';
        }else {
            $paymethod = 'HPMN';
        }
        break;
    case 'YPAY':	//엘로페이
        $paymethod = 'YPAY';
        break;
    case 'Kpay':	//케이페이
        $paymethod = 'Kpay';
        break;
    case 'Paypin':	//페이핀
        $paymethod = 'Paypin';
        break;
    case 'EasyPay':	//간편결제
        $paymethod = 'EasyPay';
        break;
    case 'EWallet':	//전자지갑
        $paymethod = 'EWallet';
        break;
    case 'POINT':	//포인트
        $paymethod = 'POINT';
        break;
    case 'GiftCard':	//상품권
        $paymethod = 'GiftCard';
        break;
    case 'kakaopay':	//카카오 페이
        $paymethod = 'onlykakaopay';
        break;
    case 'payco':	//페이코
        $paymethod = 'onlypayco';
        break;
}


$mKey = hash("sha256", $signKey);

$params = array(
    "oid" => $orderNumber,
    "price" => $price,
    "timestamp" => $timestamp
);

$sign = $SignatureUtil->makeSignature($params);

$siteDomain = $orders->http_type.$_SERVER["HTTP_HOST"].""; //가맹점 도메인 입력
$returnurl = $siteDomain."/shop/complete_payment.php";
$notiurl = $siteDomain."/shop/inipay_standard/noti.php";
if(sess_val('app_type') != ''){
    $completeurl = "dlwmall://".$_SERVER["HTTP_HOST"]."/shop/securepay_complete.php";
}else{
    $completeurl = $siteDomain."/shop/securepay_complete.php";
}

if(is_mobile()){
    $payReqMap['inipaymobile_type'] = "web";
    $payReqMap['P_MID'] = $mid;
    $payReqMap['pg_com'] = $sattle_module;
    $payReqMap['P_OID'] = $orderNumber;
    $payReqMap['P_GOODS'] = $pname;
    $payReqMap['P_AMT'] = $price;
    $payReqMap['P_UNAME'] = $_SESSION['order']['name_a'];
    $payReqMap['P_MNAME'] = $_SESSION['layout_config']['shop_name'];
    $payReqMap['P_MOBILE'] = $pcs;
    $payReqMap['P_EMAIL'] = $_SESSION['order']['mail_a'];
    $payReqMap['gopaymethod'] = $paymethod;
    $payReqMap['paymethod'] = $paymethod;

    $payReqMap['P_NEXT_URL'] = $returnurl;
    $payReqMap['P_NOTI_URL'] = $notiurl;

    if($paymethod == 'onlykakaopay' || $paymethod == 'onlypayco'){
        $payReqMap['P_RESERVED'] = "Y";
        if($paymethod == 'onlypayco'){
            $payReqMap['d_payco'] = "Y";
        }else if($paymethod == 'onlykakaopay'){
            $payReqMap['d_kakaopay'] = "Y";
        }
    }
    switch( $paymethod ) {
        case 'bank':
            $payReqMap['P_RETURN_URL'] = $completeurl;
            break;
        case 'vbank':
            $payReqMap['P_VBANK_DT'] = date('Ymd', strtotime('+6days'));
            break;
        case 'mobile':
            $payReqMap['P_HPP_METHOD'] = "2"; //컨텐츠 일 경우 : 1 실물일 경우 : 2
        default:
            break;
    }

    $PaymentAddScript  = $orders->getFormData($payReqMap,'EUC-KR');
}else {
    $payReqMap['version'] = "1.0";
    $payReqMap['mid'] = $mid;
    $payReqMap['pg_com'] = $sattle_module;
    $payReqMap['oid'] = $orderNumber;
    $payReqMap['goodname'] = $pname;
    $payReqMap['price'] = $price;
    $payReqMap['tax'] = $surtax_n;
    $payReqMap['taxfree'] = $surtax_y;
    $payReqMap['currency'] = 'WON';
    $payReqMap['buyername'] = $_SESSION['order']['name_a'];
    $payReqMap['buyertel'] = $pcs;
    $payReqMap['buyeremail'] = $_SESSION['order']['mail_a'];
    $payReqMap['timestamp'] = $timestamp;
    $payReqMap['signature'] = $sign;
    $payReqMap['returnUrl'] = $returnurl;
    $payReqMap['mKey'] = $mKey;
    $payReqMap['gopaymethod'] = $paymethod;
    $payReqMap['paymethod'] = $paymethod;
    $payReqMap['offerPeriod'] = ''; //가맹점에서 판매상품에 대한 제공기한 설정
    $payReqMap['languageView'] = ''; //초기 표시 언어
    $payReqMap['charset'] = "UTF-8";
    $payReqMap['payViewType'] = "overlay";//popup
    $payReqMap['closeUrl'] = $siteDomain . "/shop/inipay_standard/close.php";
    $payReqMap['popupUrl'] = $siteDomain . "/shop/inipay_standard/popup.php";
    $payReqMap['merchantD'] = "";
    $payReqMap['acceptmethod'] = "";
    if($paymethod == 'HPP'){
        $payReqMap['acceptmethod'] = "HPP(2)"; //컨텐츠 일 경우 : 1 실물일 경우 : 2
    }else if($paymethod == 'onlykakaopay' || $paymethod == 'onlypayco'){
        $payReqMap['acceptmethod'] = "cardonly";
    }

    $PaymentAddScript  = $orders->getFormData($payReqMap,'UTF-8');
}