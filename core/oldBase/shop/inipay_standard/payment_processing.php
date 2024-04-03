<?php
/**
 * Created by PhpStorm.
 * User: moon
 * Date: 2017-07-11
 * Time: 오후 12:13
 */

$inipay_standard_is_mobile = false;
$mobile_noti = gVal('mobile_noti');

if($mobile_noti == true){
    $inipay_standard_is_mobile = true;

    $P_TID       = $_REQUEST['P_TID'];
    $P_MID       = $_REQUEST['P_MID'];
    $P_AUTH_DT   = $_REQUEST['P_AUTH_DT'];
    $P_STATUS    = $_REQUEST['P_STATUS'];
    $P_TYPE      = $_REQUEST['P_TYPE'];
    $P_OID       = $_REQUEST['P_OID'];
    $P_FN_CD1    = $_REQUEST['P_FN_CD1'];
    $P_FN_CD2    = $_REQUEST['P_FN_CD2'];
    $P_FN_NM     = $_REQUEST['P_FN_NM'];
    $P_AMT       = $_REQUEST['P_AMT'];
    $P_UNAME     = $_REQUEST['P_UNAME'];
    $P_RMESG1    = $_REQUEST['P_RMESG1'];
    $P_RMESG2    = $_REQUEST['P_RMESG2'];
    $P_NOTI      = $_REQUEST['P_NOTI'];
    $P_AUTH_NO   = $_REQUEST['P_AUTH_NO'];
}else if(!empty($_POST["P_STATUS"])){ //모바일 결제일때!
    $inipay_standard_is_mobile = true;

    $P_STATUS = $_POST['P_STATUS'];
    $P_REQ_URL = $_POST['P_REQ_URL'];
    $P_TID = $_POST['P_TID'];

    function makeParam($P_TID, $P_MID){
        return "P_TID=".$P_TID."&P_MID=".$P_MID;
    }
    function parseData($receiveMsg) { //승인결과 Parse
        $returnArr = explode("&",$receiveMsg);
        foreach($returnArr as $value){
            $tmpArr = explode("=",$value);
            $returnArr[] = $tmpArr;
        }
    }
    function call_noti( $url, $param ){
        /*
        $return = shell_exec("curl --data '".$param."' ".$url);
        $return = iconv( "euc-kr", "utf-8", $return );
        return $return;
        */
        $ch = curl_init ();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param );

        $raw = curl_exec($ch);
        curl_close ($ch);
        $raw = iconv( "euc-kr", "utf-8", $raw );
        return $raw;
    }

    if($P_STATUS=="00" && !empty($P_TID)) {
        if($pg_info['service_type'] == 'service' ) {
            $mid = $pg_info['mid'];
        }else{
            $mid = "INIpayTest";
        }
        $result=call_noti($P_REQ_URL,makeParam($P_TID, $mid));
        $arr_result = explode("&", $result);

        foreach ($arr_result as $key => $val):
            list($k_text, $v_text) = explode("=", $val);
            $result_pay['trim'($k_text)] = trim($v_text);
        endforeach;

        $P_TID       = $result_pay['P_TID'];
        $P_MID       = $result_pay['P_MID'];
        $P_AUTH_DT   = $result_pay['P_AUTH_DT'];
        $P_STATUS    = $result_pay['P_STATUS'];
        $P_TYPE      = $result_pay['P_TYPE'];
        $P_OID       = $result_pay['P_OID'];
        $P_FN_CD1    = $result_pay['P_VACT_BANK_CODE'];
        $P_FN_CD2    = $result_pay['P_FN_CD2'];
        $P_FN_NM     = $result_pay['P_FN_NM'];
        $P_AMT       = $result_pay['P_AMT'];
        $P_UNAME     = $result_pay['P_UNAME'];
        $P_RMESG1    = $result_pay['P_RMESG1'];
        $P_RMESG2    = $result_pay['P_RMESG2'];
        $P_NOTI      = $result_pay['P_NOTI'];
        $P_AUTH_NO   = $result_pay['P_AUTH_NO'];
        $P_VACT_NUM  = $result_pay['P_VACT_NUM'];
        $P_VACT_NAME = $result_pay['P_VACT_NAME'];
        $P_VACT_DATE = $result_pay['P_VACT_DATE'];
    }
}

if($inipay_standard_is_mobile == true){//모바일
    if(!empty($P_OID)){
        $ordr_idxx = $P_OID;
    }
    $tid = $P_TID;
    $pg_result_code = $P_STATUS;
    $app_no= $P_AUTH_NO;
    $pg_result_msg = $P_RMESG1;
    $pg_payment_price = $P_AMT;

    if( ($P_TYPE!="VBANK" && $P_STATUS == "00") || ($P_TYPE=="VBANK" && ($P_STATUS == "00" || $P_STATUS == "01" || $P_STATUS == "02") ) ){
        switch($P_TYPE){
            case 'ISP':
            case 'CARD':
                $status = "IC";
                $strCard  = $P_FN_NM;
                $nPaymethod = ORDER_METHOD_CARD;
                break;
            case 'VBANK':
                if($P_STATUS != "02") //입금통보 "02" 가 아니면(가상계좌 채번 : 00 또는 01 경우)
                {
                    $status = "IR";
                    $strCard  = "가상계좌";
                    $nPaymethod = ORDER_METHOD_VBANK;
                    $bank_input_date = $P_VACT_DATE;
                    $v_bank = $P_FN_NM." ".$P_VACT_NUM." ".$P_VACT_NAME;
                }else if ($P_STATUS == '02'){
                    $status = "IC";
                    $strCard  = "가상계좌";
                    $nPaymethod = ORDER_METHOD_VBANK;
                    $ic_date_str = ", ic_date=NOW() ";

                    $db->query("select expect_product_price, expect_delivery_price from shop_order_price where oid = '" . $ordr_idxx . "' and payment_status ='G'");
                    $db->fetch();

                    table_order_price_data_creation($ordr_idxx, '', '', 'G', 'P', 0, $db->dt['expect_product_price'], "", 0, 0, 0);
                    table_order_price_data_creation($ordr_idxx, '', '', 'G', 'D', 0, $db->dt['expect_delivery_price'], "", 0, 0, 0);

                    $db->query("update shop_order_payment set pay_status='IC', ic_date=NOW() where oid='" . $ordr_idxx . "'");

                    $sql = "select opay_ix from shop_order_payment where oid='" . $ordr_idxx . "' and pay_type='G' and method='" . $nPaymethod . "' ";
                    $db->query($sql);
                    $db->fetch();
                    $opay_ix = $db->dt['opay_ix'];

                    $db->query("update shop_order_payment set tid='" . $tid . "', authcode='" . $app_no . "' where opay_ix='" . $opay_ix . "'");
                    $db->query("update shop_order set status = '$status' where oid = '$ordr_idxx'");
                    $db->query("update shop_order_detail set status = '$status' $ic_date_str where oid = '$ordr_idxx'");

                    /*대명 추가 상품타입에 따른 입금확인시 상태변경 변경*/
                    //해피콜 상품 상담 대기로 변경
                    $db->query("update shop_order_detail set status = '".ORDER_STATUS_CONSULTING_READY."' where oid = '$ordr_idxx' and product_type='60'");
                    //티켓은 미사용으로 변경
                    $db->query("update shop_order_detail set status = '".ORDER_STATUS_USE_READY."' where oid = '$ordr_idxx' and product_type='70'");
                    //해피콜과 티켓 제외하고 모든 상품 미배송 상품은 구매결정으로 변경
                    $db->query("update shop_order_detail set status = '".ORDER_STATUS_BUY_COMPLETE."', dr_date=NOW(), di_date=NOW(), dc_date=NOW() where oid = '$ordr_idxx' and product_type not in ('60','70') and delivery_type='3'");

                    set_order_status($ordr_idxx,$status,"$strCard 입금 완료","시스템","");

                    echo "OK";//절대로 지우지 마세요
                    exit;
                }
                break;
            case 'BANK':
                $status = "IC";
                $strCard = "실시간계좌이체";
                $nPaymethod = ORDER_METHOD_ICHE;
                $bank = $P_FN_NM;
                break;
            case 'MOBILE':
                $status = 'IC';
                $strCard = '휴대폰';
                $nPaymethod = ORDER_METHOD_PHONE;
                break;
            case 'ONLYKAKAOPAY':
                $status = 'IC';
                $strCard = '카카오페이';
                $nPaymethod = ORDER_METHOD_KAKAOPAY;
                break;
            case 'ONLYPAYCO':
                $status = 'IC';
                $strCard = '페이코';
                $nPaymethod = ORDER_METHOD_PAYCO;
                break;
        }

        require(OLDBASE_ROOT . "/shop/complete_payment_info.php");

        if ($info_result == 'OK') {
            //성공
            $pg_result_success = '1';
        }
    }
} else {


    require_once(OLDBASE_ROOT . '/shop/inipay_standard/libs/INIStdPayUtil.php');
    require_once(OLDBASE_ROOT . '/shop/inipay_standard/libs/HttpClient.php');
    require_once(OLDBASE_ROOT . '/shop/inipay_standard/libs/sha256.inc.php');
    require_once(OLDBASE_ROOT . '/shop/inipay_standard/libs/json_lib.php');

    $util = new INIStdPayUtil();

    try {

        //#############################
        // 인증결과 파라미터 일괄 수신
        //#############################

        //#####################
        // 인증이 성공일 경우만
        //#####################

        if (strcmp("0000", $_REQUEST["resultCode"]) == 0) {


            //############################################
            // 1.전문 필드 값 설정(***가맹점 개발수정***)
            //############################################

            $mid = $_REQUEST["mid"];                            // 가맹점 ID 수신 받은 데이터로 설정

            $signKey = $pg_info['pay_key'] ?? '';            // 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지

            $timestamp = $util->getTimestamp();                        // util에 의해서 자동생성

            $charset = "UTF-8";                                        // 리턴형식[UTF-8,EUC-KR](가맹점 수정후 고정)

            $format = "JSON";                                        // 리턴형식[XML,JSON,NVP](가맹점 수정후 고정)

            $authToken = $_REQUEST["authToken"];                    // 취소 요청 tid에 따라서 유동적(가맹점 수정후 고정)

            $authUrl = $_REQUEST["authUrl"];                            // 승인요청 API url(수신 받은 값으로 설정, 임의 세팅 금지)

            $netCancel = $_REQUEST["netCancelUrl"];                    // 망취소 API url(수신 받은f값으로 설정, 임의 세팅 금지)

            $mKey = hash("sha256", $signKey);                        // 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)

            //#####################
            // 2.signature 생성
            //#####################
            $signParam["authToken"] = $authToken;        // 필수
            $signParam["timestamp"] = $timestamp;        // 필수
            // signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
            $signature = $util->makeSignature($signParam);


            //#####################
            // 3.API 요청 전문 생성
            //#####################
            $authMap["mid"] = $mid;            // 필수
            $authMap["authToken"] = $authToken;        // 필수
            $authMap["signature"] = $signature;        // 필수
            $authMap["timestamp"] = $timestamp;        // 필수
            $authMap["charset"] = $charset;        // default=UTF-8
            $authMap["format"] = $format;        // default=XML

            try {

                $httpUtil = new HttpClient();

                //#####################
                // 4.API 통신 시작
                //#####################

                $authResultString = "";
                if ($httpUtil->processHTTP($authUrl, $authMap)) {
                    $authResultString = $httpUtil->body;
                } else {
                    throw new Exception("Http Connect Error");
                }

                //############################################################
                //5.API 통신결과 처리(***가맹점 개발수정***)
                //############################################################


                $resultMap = json_decode($authResultString, true);


                /*************************  결제보안 추가 2016-05-18 START ****************************/
                $secureMap["mid"] = $mid;                            //mid
                $secureMap["tstamp"] = $timestamp;                    //timestemp
                $secureMap["MOID"] = $resultMap["MOID"];            //MOID
                $secureMap["TotPrice"] = $resultMap["TotPrice"];        //TotPrice

                // signature 데이터 생성
                $secureSignature = $util->makeSignatureAuth($secureMap);
                /*************************  결제보안 추가 2016-05-18 END ****************************/

                $pg_result_code = $resultMap["resultCode"];
                $pg_card_company_code = $resultMap['CARD_Code'] ?? '';
                $tid = $resultMap['tid'];
                $app_no = $resultMap['applNum'] ?? '';
                $pg_result_msg = $resultMap['resultMsg'];
                $pg_payment_price = $resultMap['TotPrice'];

                if ((strcmp("0000", $resultMap["resultCode"]) == 0) && (strcmp($secureSignature, $resultMap["authSignature"]) == 0)) {    //결제보안 추가 2016-05-18
                    /*****************************************************************************
                     * 여기에 가맹점 내부 DB에 결제 결과를 반영하는 관련 프로그램 코드를 구현한다.
                     *
                     * [중요!] 승인내용에 이상이 없음을 확인한 뒤 가맹점 DB에 해당건이 정상처리 되었음을 반영함
                     * 처리중 에러 발생시 망취소를 한다.
                     ******************************************************************************/
                    $paymethod = $resultMap["payMethod"];
                    switch ($paymethod) {
                        case 'VCard':
                            $status = 'IC';
                            $strCard = '신용카드(ISP)';
                            $nPaymethod = ORDER_METHOD_CARD;
                            $bank = $resultMap["CARD_Code"];
                            break;
                        case 'Card':
                            $status = 'IC';
                            $strCard = '신용카드(안심클릭)';
                            $nPaymethod = ORDER_METHOD_CARD;
                            break;
                        case 'OCBPoint':
                            $status = 'IC';
                            $strCard = 'OK캐쉬백 포인트';
                            $nPaymethod = ORDER_METHOD_OCB;
                            break;
//                    case 'GSPT':    //GS&POINT
//                    case 'UPNT':    //삼성 U-point
                        case 'DirectBank':
                            $status = 'IC';
                            $strCard = '실시간계좌이체(K계좌이체)';
                            $nPaymethod = ORDER_METHOD_ICHE;
                            $bank = $resultMap["vactBankName"];
                            break;
                        case 'iDirectBank':
                            $status = 'IC';
                            $strCard = '실시간계좌이체(I계좌이체)';
                            $nPaymethod = ORDER_METHOD_ICHE;
                            $bank = $resultMap["vactBankName"];
                            break;
                        case 'HPP':
                            $status = 'IC';
                            $strCard = '휴대폰';
                            $nPaymethod = ORDER_METHOD_PHONE;
                            break;
                        case 'VBank':
                            $status = 'IR';
                            $strCard = '무통장입금(가상계좌)';
                            $nPaymethod = ORDER_METHOD_VBANK;
                            $bank_input_date = $resultMap["VACT_Date"];
                            $bankname = $resultMap["vactBankName"];
                            $account = iconv('EUC-KR', 'UTF-8', $resultMap['VACT_Num']);
                            $depositor = iconv("EUC-KR", "UTF-8//IGNORE", $resultMap['VACT_Name']);
                            $bank_input_name = iconv("EUC-KR", "UTF-8//IGNORE", $resultMap['VACT_InputName']);
                            $v_bank = $bankname . " " . iconv('EUC-KR', 'UTF-8', $resultMap['VACT_Num']) . " " . $depositor;
                            break;
//                    case 'PhoneBill':   // 폰빌전화결제
//                    case 'Culture':    //문화상품권
//                    case 'TeenCash':    //틴캐쉬
//                    case 'DGCL':    //스마트문화상품권
//                    case 'BCSH':   //도서문화상품권
//                    case 'HPMN':    //해피머니상품권
//                    case 'YPAY':    //옐로페이
//                    case 'EWallet':   // 뱅크월렛
                        case 'onlykakaopay':
                            $status = 'IC';
                            $strCard = '카카오페이';
                            $nPaymethod = ORDER_METHOD_KAKAOPAY;
                            break;
                        case 'onlypayco':
                            $status = 'IC';
                            $strCard = '페이코';
                            $nPaymethod = ORDER_METHOD_PAYCO;
                            break;
                        default:
                            $status = 'IR';
                            $strCard = '결제타입 없음';
                            $nPaymethod = ORDER_METHOD_VBANK;
                            break;
                    }


                    require OLDBASE_ROOT . "/shop/complete_payment_info.php";

                    if ($info_result == 'OK') {
                        //성공
                        $pg_result_success = '1';
                    } else {
                        //실패
                        throw new Exception("데이터 DB 처리 실패");
                    }
                } else {

                    //결제보안키가 다른 경우.
                    $resultMap["authSignature"] = $resultMap["authSignature"] ?? '';
                    if (strcmp($secureSignature, $resultMap["authSignature"]) != 0) {
                        if (strcmp("0000", $resultMap["resultCode"]) == 0) {
                            throw new Exception("데이터 위변조 체크 실패");
                        }
                    } else {

                    }

                }

                //공통 부분만

                // 수신결과를 파싱후 resultCode가 "0000"이면 승인성공 이외 실패
                // 가맹점에서 스스로 파싱후 내부 DB 처리 후 화면에 결과 표시
                // payViewType을 popup으로 해서 결제를 하셨을 경우
                // 내부처리후 스크립트를 이용해 opener의 화면 전환처리를 하세요
                //throw new Exception("강제 Exception");
            } catch (Exception $e) {
                //    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                //####################################
                // 실패시 처리(***가맹점 개발수정***)
                //####################################
                //---- db 저장 실패시 등 예외처리----//
                $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                echo $s;

                //#####################
                // 망취소 API
                //#####################

                $netcancelResultString = ""; // 망취소 요청 API url(고정, 임의 세팅 금지)
                if ($httpUtil->processHTTP($netCancel, $authMap)) {
                    $netcancelResultString = $httpUtil->body;
                } else {
                    throw new Exception("Http Connect Error");
                }


                /*##XML output##*/
                //$netcancelResultString = str_replace("<", "&lt;", $$netcancelResultString);
                //$netcancelResultString = str_replace(">", "&gt;", $$netcancelResultString);

                // 취소 결과 확인
                echo "<p>" . $netcancelResultString . "</p>";
            }
        } else {

            //#############
            // 인증 실패시
            //#############

        }
    } catch (Exception $e) {
        $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
        echo $s;
    }
}