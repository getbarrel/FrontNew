<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView(true);
$publishIx = $view->input->get('p');

//다중 쿠폰 다운로드 기능 철회에 따른 주석 처리 #9112
/*
$publishIxArray = array();
if(strpos($publishIx, ',') !== false) {
    $publishIxArray = explode(',',$publishIx);
}
*/
if(empty($view->userInfo->code)){
    echo "
    <script>
        if(confirm('로그인이 필요 합니다. 로그인 하시겠습니까?')){
            var referrer =  document.referrer;            
            var returnUrI = '/';
            if(referrer){
                returnUrI = referrer;
            }
            document.location.href = '/member/login?url=' + encodeURI(returnUrI);
        }else{
            history.back();
        }
    </script>
    ";
    exit;
}


$encrypt = new FbEncrypt('180d7d18b8b53e9dba898cc5a692dbb3');
/* @var $couponModel CustomMallCouponModel */
$couponModel = $view->import('model.mall.coupon');

if(is_array($publishIxArray) && count($publishIxArray) > 0){

    $overlapCount= 0;
    $successCount= 0;
    $failCount= 0;
    $useFailCount= 0;
    foreach($publishIxArray as $val){
        $publishIx = $encrypt->decode($val);
        $result = $couponModel->giveCoupon($publishIx);
        if ($result == "success") {
            $successCount++;
        } else if($result == "useFail"){
            $useFailCount++;
        } else if($result == "overlap"){
            $overlapCount++;
        } else if($result == "fail"){
            $failCount++;
        }
    }
    $msg = "쿠폰 등록 ".$successCount." 건\\n";
    $msg .= "보유한 쿠폰 ".$overlapCount." 건\\n";
    $msg .= "사용불가 쿠폰 ".$useFailCount." 건\\n";
    $msg .= "발행 실패 ".$failCount." 건\\n";

    echo "<script>alert('".$msg."');history.back();</script>";
    exit;
}else {

    $publishIx = $encrypt->decode($publishIx);
    $result = $couponModel->giveCoupon($publishIx);

    if ($result == "success") {
        echo "<script>alert('쿠폰이 등록되었습니다.');history.back();</script>";
        exit;
    } else {
        if ($result == "useFail") {
            echo "<script>alert('사용 불가능한 쿠폰입니다.');history.back();</script>";
            exit;
        } else if($result =="overlap"){
            echo "<script>alert('이미 발급받은 쿠폰입니다.');history.back();</script>";
            exit;
        }else  {
            echo "<script>alert('발급 처리에 실패했습니다.');history.back();</script>";
            exit;
        }
    }
}
//print_r($result);