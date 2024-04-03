<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    redirect('/');
} else {


    /***
     * 대기열 적용
     */
    $WG_GATE_ID = WEB_GATE_ID_4;
    $WG_SERVICE_ID  = WEB_GATE_SERVICE_ID;                   // fixed
    $WG_SECRET_TEXT = "BARREL-LEGGINGS";   // fixed
    $WG_VALIDATION_KEY  = $WG_SERVICE_ID . "-" . $WG_GATE_ID . "-" . $WG_SECRET_TEXT;
    $WG_COOKIE_NAME     = "WG_VALIDATION_KEY";
    //$WG_GATE_SERVERS    = array("wk2.devy.kr", "wk3.devy.kr", "wc1.devy.kr", "wc2.devy.kr", "ws1.devy.kr");
	$WG_GATE_SERVERS    = array("1012-0.devy.kr","1012-1.devy.kr","1012-2.devy.kr");
//$NextUrl = $view->input->server('REQUEST_URI');
//$NowUrl = $view->input->server('HTTP_REFERER');

    $wg_is_need_to_redirect = true;
    if(isset($_COOKIE[$WG_COOKIE_NAME])) {
        $wg_cookie_value = $_COOKIE[$WG_COOKIE_NAME];
        if($wg_cookie_value == $WG_VALIDATION_KEY)
        {
            $wg_is_need_to_redirect = false;
        }
    }

	$wg_is_kakao_page = "F";
	if ($_GET[kakao] == 'one'){
		$wg_is_kakao_page = "T";	
	}
// 검증키가 Cache에 없거나 값이 다르면 대기열 요청 후 응답 내용(대기자 수)으로 PASS/WAIT 판단
//      --> 대기자가 없으면 PASS(정상 페이지로드)
//      --> 대기자가 있으면 WAIT(응답을 LoadWebGate.html의 html로 교체)
    if($wg_is_need_to_redirect  && (defined('IS_USE_WEB_GATE') && IS_USE_WEB_GATE === true))
    {
        // 검증키 체크가 실패한 경우, 즉 대기열 체크를 하지 않은 경우 이곳으로 진입합니다.
        $wg_isWaiting = false; // 대기자가 있는지 여부

        // WG_GATE_SERVERS 서버 중 임의의 서버에 API 호출 --> json 응답
        $wg_receiveLine="";
        $wg_receiveText="";
        // Fail-over를 위해 최대 2차까지 시도
        $wg_serverCount = count($WG_GATE_SERVERS);
        $wg_serverChoice1  = rand(0, $wg_serverCount-1); // 1차대기열서버 : 임의의 대기열 서버
        $wg_url1 =  "http://" . $WG_GATE_SERVERS[$wg_serverChoice1] . "/?ServiceId=" . $WG_SERVICE_ID . "&GateId=" . $WG_GATE_ID . "&Action=CHECK";
        $wg_serverChoice2 = ($wg_serverChoice1 + rand(1, $wg_serverCount-1)) % $wg_serverCount; // 2차대기열서버 :1차 서버를 제외한 임의의 서버
        $wg_url2 =  "http://" . $WG_GATE_SERVERS[$wg_serverChoice2] . "/?ServiceId=" . $WG_SERVICE_ID . "&GateId=" . $WG_GATE_ID . "&Action=CHECK";

        // 1차 시도
        $wg_responseText = file_get_contents($wg_url1);
        // 오류나면 공백 $wg_responseText이 null
        if ( $wg_responseText == null || $wg_responseText == "")
        {
            // 1차시도 실패 시 2차시도
            $wg_responseText = file_get_contents($wg_url2);
        }

        // 1차 또는 2차시도로 응답을 받은경우 json decode
        if ( $wg_responseText != null && $wg_responseText != "")
        {
            $wg_responseJson = json_decode($wg_responseText);

            $wg_apiResultCode    = $wg_responseJson->ResultCode;        // 0:정상, 그외 : 오류
            $wg_apiResultMessage = $wg_responseJson->ResultMessage;     // "PASS" or "WAIT"


            // 대기자 수가 있으면 대기열 UI 표시(WAIT)
            // 대기자 수가 없으면 PASS
            $wg_isWaiting = $wg_apiResultCode == 0 && $wg_apiResultMessage == "WAIT";
            // 대기가 있는 경우
            if ($wg_isWaiting) {
                // 대기열 호출용 html로 load
                $doc = new DOMDocument('1.0', 'UTF-8');
                $internalErrors = libxml_use_internal_errors(true);
                $loadPagePath = $_SERVER['DOCUMENT_ROOT']."/gate/LoadWebGate.html";
                $doc->loadHTMLFile($loadPagePath);
                $html = $doc->saveHTML();
                // load한 html로 응답을 교체하고 return
                print str_replace("WG_GATE_ID", $WG_GATE_ID, $html); // SET Gate ID
                return;
            }
            // 대기가 없는 경우
            else {
                // 냉무 : 별도의 코딩 필요 없음
            }
        }
    }

// 페이지 새로고침 시에도 대기열을 체크하기위해 아래와 같이 쿠키를 삭제해줍니다.
    setcookie($WG_COOKIE_NAME, "", time() + (-1 * 86400), "/"); // 86400 = 1 day


    // Load Forbiz View
    $view = getForbizView();
    $view->assign('url', $view->input->get('url'));

    $_SESSION["URL_REFERER"] = $view->input->server('HTTP_REFERER');

    /* @var $snsLoginModel CustomMallSnsLoginModel */
    $snsLoginModel = $view->import('model.mall.snsLogin');

    $view->assign([
        'url' => $view->input->get('url')
        , 'naver_login' => $snsLoginModel->getNaverLoginIcon() // 네이버 로그인 버튼
        , 'facebook_login' => $snsLoginModel->getFacebookLoginIcon() // 페이스북 로그인 버튼
        , 'kakao_login' => $snsLoginModel->getKakaoLoginIcon() // 카카오 로그인 버튼
    ]);

    if(strpos($view->input->get('url'), "/shop/infoInput?cartIx=") !== false){
        $view->assign("isNonMemberBuy", true);
    }else{
        $view->assign("isNonMemberBuy", false);
    }




	//	ig 캡차 사용해야 하는 경우인지 체크
        $view->assign("captcha_use", $view->input->get('captcha_use'));
	//	//ig 캡차 사용해야 하는 경우인지 체크


        $view->assign("wg_is_kakao_page", $wg_is_kakao_page);


    if(is_mobile()){
        if(getAppType()){
            $view->assign('app_type', true);
        }else{
            $view->assign('app_type', false);
        }
    }

    echo $view->loadLayout();
}
