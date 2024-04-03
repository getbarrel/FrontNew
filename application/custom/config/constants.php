<?php
date_default_timezone_set('Asia/Seoul');
if(BASIC_LANGUAGE == 'english'){
    define('FORBIZ_SHUTDOWN', true); // true 점검 중 처리 false 해제
} else {
    define('FORBIZ_SHUTDOWN', true);
}

// SSL 여부 확인
$_reqUrl_ = ($_SERVER['REQUEST_URI'] ?? '/');
if (($_SERVER["HTTP_X_FORWARDED_PROTO"] ?? '') == 'https' || ($_SERVER["SERVER_PORT"] ?? '') == "443") {
    define('HTTP_PROTOCOL', 'https://');
    if (FORBIZ_HOST == 'getbarrel.com') {
        if (_is_mobile()) {
            header("Location: https://m.".FORBIZ_BASEURL.$_reqUrl_);
        } else {
            header("Location: https://www.".FORBIZ_BASEURL.$_reqUrl_);
        }
        exit;
    }
} else {
    define('HTTP_PROTOCOL', 'http://');
    if (FORBIZ_BASEURL == 'getbarrel.com' || FORBIZ_BASEURL == 'barrelmade.co.kr' || FORBIZ_BASEURL == 'stg.barrelmade.co.kr' || FORBIZ_BASEURL == 'testbarrel.forbiz.co.kr' || FORBIZ_BASEURL == 'qa.barrelmade.co.kr') {
        if (strncmp(FORBIZ_HOST, 'm.', 2) == 0) {
            header("Location: https://m.".FORBIZ_BASEURL.$_reqUrl_);
        } else {
			if(FORBIZ_BASEURL == 'stg.barrelmade.co.kr' || FORBIZ_BASEURL == 'testbarrel.forbiz.co.kr' || FORBIZ_BASEURL == 'qa.barrelmade.co.kr') {
	            header("Location: https://".FORBIZ_BASEURL.$_reqUrl_);
			} else {
	            header("Location: https://www.".FORBIZ_BASEURL.$_reqUrl_);
			}
        }
        exit;
    }
}
unset($_reqUrl_);

if(PHP_SAPI !== 'cli' && !defined('STDIN')) {
    if ((isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) || (isset($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] == 443)) {
        defined('HTTP_PROTOCOL') OR define('HTTP_PROTOCOL', 'https://');
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
        defined('HTTP_PROTOCOL') OR define('HTTP_PROTOCOL', 'https://');
    } else {
        defined('HTTP_PROTOCOL') OR define('HTTP_PROTOCOL', 'http://');
    }

    if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP']) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED']) && $_SERVER['HTTP_X_FORWARDED']) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR']) && $_SERVER['HTTP_FORWARDED_FOR']) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED']) && $_SERVER['HTTP_FORWARDED']) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_FORWARDED'];
    } else {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
    }
}



if(FORBIZ_BASEURL == 'barrel.devs' ||
    FORBIZ_BASEURL == 'barrelfrontdev.forbiz.co.kr' ||
    FORBIZ_BASEURL == 'barrelfrontdev.welsoop.co.kr' ||
    FORBIZ_BASEURL == 'enbarrelfrontdev.forbiz.co.kr' ||
    FORBIZ_BASEURL == 'testbarrel.forbiz.co.kr' ||
    FORBIZ_BASEURL == 'm.testbarrel.forbiz.co.kr' ||
    FORBIZ_BASEURL == 'en.testbarrel.forbiz.co.kr' ||
    FORBIZ_BASEURL == 'm.entestbarrel.forbiz.co.kr') {
    defined("IMAGE_SERVER_DOMAIN") OR define("IMAGE_SERVER_DOMAIN", "");
}else{
    //일반 이미지 서버 사용시
    //defined("IMAGE_SERVER_DOMAIN") OR define("IMAGE_SERVER_DOMAIN", HTTP_PROTOCOL."image.getbarrel.com");

    //cnd 사용 시
    defined("IMAGE_SERVER_DOMAIN") OR define("IMAGE_SERVER_DOMAIN", HTTP_PROTOCOL."mfhaoswulcnn3822236.cdn.ntruss.com");
}
// 써드파디 라이브러리 로드
if (file_exists(CUSTOM_ROOT . '/third-party/vendor/autoload.php')) {
    require_once CUSTOM_ROOT . '/third-party/vendor/autoload.php';
}

//배럴데이 세팅 (개발사이트에서는 이벤트 기능 선 확인을 위한 분기 처리)
if(FORBIZ_BASEURL == 'barrelfrontdev.forbiz.co.kr' || FORBIZ_BASEURL == 'barrel.devs' || FORBIZ_BASEURL == 'barrelfrontdev.welsoop.co.kr'){
    $startBarrelDay = '2022-04-20 09:50:00';
} else{
    $startBarrelDay = '2022-04-20 09:50:00';
}
//$startOfflineBarrelDay = '2020-06-27 09:50:00';
$endBarrelDay = '2022-04-22 23:59:59';
$now = date('Y-m-d H:i:s');

//$isBarrelDay = false;
//$isOnlineBarrelDay = false;
//$isOfflineBarrelDay = false;
//$httpReferer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;

//대기열 솔루션 사용여부
define('IS_USE_WEB_GATE', true);
//대기열 서비스 관리 START
define('WEB_GATE_ID_1', 166);//메인 페이지에 사용
define('WEB_GATE_ID_2', 167);//결제정보 입력 페이지에 사용
define('WEB_GATE_ID_3', 168);//이벤트 페이지
define('WEB_GATE_ID_4', 169);//로그인 페이지
define('WEB_GATE_ID_5', 171);//상품리스트 페이지
define('WEB_GATE_SERVICE_ID', 1012);
//대기열 서비스 관리 END

if ($now >= $startBarrelDay && $now < $endBarrelDay) {
    // 배럴데이
    define('IS_BARREL_DAY', true);//이벤트 진행 시 default true 처리

    //카테고리별 회원할인 사용 여부 체크 true : 사용 false : 사용안함
    define('IS_EVENT_CATEGORY_SALE_USE', false); //이벤트 진행 시 default false 처리

    //구매금액대별,카테고리별,특정상품구매 별 사은품 기능 on off 기능 true : 사용 false : 사용안함
    define('IS_EVENT_FREE_GIFT_USE', false); //이벤트 진행 시 default false 처리

    define('USE_FAT', false);//이벤트 진행 시 default false 처리
}else{
    // 배럴데이
    define('IS_BARREL_DAY', false);

    //카테고리별 회원할인 사용 여부 체크
    define('IS_EVENT_CATEGORY_SALE_USE', true);

    //구매금액대별,카테고리별,특정상품구매 별 사은품 기능 on off 기능 true : 사용 false : 사용안함
    define('IS_EVENT_FREE_GIFT_USE', true);

    define('USE_FAT', true);
}



// 국가도메인간 세션 공유 금지 처리 true: 사용 (공유안됨) false: 사용안함 (공유됨)
defined('SESSION_INTEGRATION') OR define('SESSION_INTEGRATION', true); //define('SESSION_INTEGRATION',true);

define('DEFAULT_GPIX', 1); // 기본회원 등급
define('GLOBAL_DEFAULT_GPIX', 15); // 글로벌 기본회원 등급
define('MAX_ADDRESS_BOOK', 10); // 배송지관리 최대 등록 개수

define('APP_SCHEME', 'barrel://');

// OLDBASE_ROOT define
define('OLDBASE_ROOT', realpath(APPLICATION_ROOT.'/oldBase'));

// Js,Css 버전
define('CLIENT_VERSION', filemtime(__FILE__));


//add table define
define("TBL_SHOP_CART_SET", "shop_cart_set");
define("TBL_SHOP_CART_GIFT", "shop_cart_gift");
define("TBL_SHOP_PRODUCT_GIFT", "shop_product_gift");
define("TBL_SHOP_FREEGIFT", "shop_freegift");
define("TBL_SHOP_FREEGIFT_PRODUCT_GROUP", "shop_freegift_product_group");
define("TBL_SHOP_FREEGIFT_PRODUCT_RELATION", "shop_freegift_product_relation");
define('TBL_SHOP_ORDER_SET', 'shop_order_set');

define('TBL_SHOP_RELATION_PRODUCT2', 'shop_relation_product2');
define('TBL_SHOP_RELATION_ADD_PRODUCT', 'shop_relation_add_product');
define('TBL_COMMON_EXCHANGE_RATE', 'common_exchange_rate');

defined('TBL_SNS_INFO') OR define('TBL_SNS_INFO', 'sns_info');
defined('TBL_SHOP_PRODUCT_STOCK_REMINDER') OR define('TBL_SHOP_PRODUCT_STOCK_REMINDER', 'shop_product_stock_reminder');
defined('TBL_SHOP_GIFT_CERTIFICATE_DETAIL') OR define('TBL_SHOP_GIFT_CERTIFICATE_DETAIL', 'shop_gift_certificate_detail');
defined('TBL_SHOP_GIFT_CERTIFICATE') OR define('TBL_SHOP_GIFT_CERTIFICATE', 'shop_gift_certificate');
defined('TBL_SHOP_GIFT_CERTIFICATE_CUPON') OR define('TBL_SHOP_GIFT_CERTIFICATE_CUPON', 'shop_gift_certificate_cupon');


defined('TBL_SHOP_PRODUCT_FILTER') OR define('TBL_SHOP_PRODUCT_FILTER', 'shop_product_filter');
defined('TBL_SHOP_PRODUCT_FILTER_RELATION') OR define('TBL_SHOP_PRODUCT_FILTER_RELATION', 'shop_product_filter_relation');

defined('TBL_SHOP_PRODUCT_SEARCH_PRICE', 'shop_product_search_price');
defined("TBL_GLOBAL_NATION_CODE") OR define('TBL_GLOBAL_NATION_CODE', 'global_nation_code');
defined("TBL_UNITED_STATES_REGIONAL_INFORMATION") OR define('TBL_UNITED_STATES_REGIONAL_INFORMATION', 'united_states_regional_information');

defined("TBL_SHOP_PRODUCT_GLOBAL") OR define('TBL_SHOP_PRODUCT_GLOBAL', 'shop_product_global');
defined("TBL_SHOP_PRODUCT_OPTIONS_DETAIL_GLOBAL") OR define('TBL_SHOP_PRODUCT_OPTIONS_DETAIL_GLOBAL', 'shop_product_options_detail_global');
defined("TBL_SHOP_GROUP_DISCOUNT_CATEGORY") OR define('TBL_SHOP_GROUP_DISCOUNT_CATEGORY', 'shop_group_discount_category');

defined("TBL_SHOP_FREEGIFT_DISPLAY_RELATION") OR define('TBL_SHOP_FREEGIFT_DISPLAY_RELATION', 'shop_freegift_display_relation');

defined("USE_ELASTICSERACH") OR define('USE_ELASTICSERACH', true);

// crema log table
defined("TBL_CREMA_LOGS") OR define('TBL_CREMA_LOGS', 'crema_logs');

//랜덤쿠폰 DB
defined("TBL_SHOP_GIFT_RANDOM_CERTIFICATE") OR define('TBL_SHOP_GIFT_RANDOM_CERTIFICATE', 'shop_gift_random_certificate');
defined("TBL_SHOP_GIFT_RANDOM_CERTIFICATE_DETAIL") OR define('TBL_SHOP_GIFT_RANDOM_CERTIFICATE_DETAIL', 'shop_gift_random_certificate_detail');
defined("TBL_SHOP_GIFT_RANDOM_CERTIFICATE_ISSUE_LOG") OR define('TBL_SHOP_GIFT_RANDOM_CERTIFICATE_ISSUE_LOG', 'shop_gift_random_certificate_issue_log');

//스프린트 챔피언십
defined("TBL_CHAMPIONSHIP_GROUP") OR define('TBL_CHAMPIONSHIP_GROUP', 'championship_group');
defined("TBL_CHAMPIONSHIP_MEMBER") OR define('TBL_CHAMPIONSHIP_MEMBER', 'championship_member');
defined("TBL_CHAMPIONSHIP_OPTIONS") OR define('TBL_CHAMPIONSHIP_OPTIONS', 'championship_options');
defined("TBL_CHAMPIONSHIP_AGREEMENT") OR define('TBL_CHAMPIONSHIP_AGREEMENT', 'championship_agreement');
defined("TBL_CHAMPIONSHIP_SET") OR define('TBL_CHAMPIONSHIP_SET', 'championship_set');


defined("TBL_SHOP_PRODUCT_OPTIONS_SORT_BY_VALUE") OR define('TBL_SHOP_PRODUCT_OPTIONS_SORT_BY_VALUE', 'shop_product_options_sort_by_value');

//배송비 추가지역 테이블
define("TBL_SHOP_ADD_DELIVERY_AREA","shop_add_delivery_area");

defined("TBL_MEMBER_PAYMENT_INFO") OR define('TBL_MEMBER_PAYMENT_INFO', 'member_payment_info');

//정보고시 영문
defined("TBL_SHOP_PRODUCT_MANDATORY_INFO_GLOBAL") OR define('TBL_SHOP_PRODUCT_MANDATORY_INFO_GLOBAL', 'shop_product_mandatory_info_global');

//구매확인 api 결과 로그 (네이버페이 사용)
defined("TBL_SHOP_ORDER_PURCHASE_CONFIRM_LOG") OR define('TBL_SHOP_ORDER_PURCHASE_CONFIRM_LOG', 'shop_order_purchase_confirm_log');

//사은품 지금 관련 매칭 카테고리 정보
defined("TBL_SHOP_FREEGIFT_CATEGORY_RELATION") OR define('TBL_SHOP_FREEGIFT_CATEGORY_RELATION', 'shop_freegift_category_relation');

//사은품 지급 관련 매칭 상품 정보테이블
defined("TBL_SHOP_FREEGIFT_SELECT_PRODUCT_RELATION") OR define('TBL_SHOP_FREEGIFT_SELECT_PRODUCT_RELATION', 'shop_freegift_select_product_relation');

//주문클레임 정보 저장 테이블
defined("TBL_SHOP_ORDER_CLAIM_INFO") OR define('TBL_SHOP_ORDER_CLAIM_INFO', 'shop_order_claim_info');

//카카오 채널 관례 알림 콜백 데이터 저장 테이블
defined("TBL_KAKAO_CHANNEL_CALL_BACK") OR define('TBL_KAKAO_CHANNEL_CALL_BACK', 'kakao_channel_call_back');

// 서버별 설정
if (FORBIZ_BASEURL == 'barrel.devs' || FORBIZ_BASEURL == 'en.barrel.devs' || FORBIZ_BASEURL == 'bizfat.devs') {
    // 개발환경

    // 네이버 설정
    define('NAVER_CLIENT_ID', 'nkdlOkJQYieshN8NF4qD');
    define('NAVER_CLIENT_SECRET', '9Az12Gpilm');
    define('NAVER_CALLBACK_URL', HTTP_PROTOCOL.FORBIZ_HOST.'/controller/member/naver');

    //define('NAVER_CLIENT_ID', '1BRHF8r0YHat6I75MAz8'); // test
    // define('NAVER_CLIENT_SECRET', 'C48lfh20hG'); //  test



    // 카카오 설정
    define('KAKAO_APP_KEY', '1887e3a895521e08daaaa30573e7bd42');
    define('KAKAO_SCRIPT_KEY', '33da7242540c272bc28e03a6ee11f41d');
    define('KAKAO_APP_SECRET', '7Wo1cOxrumYe0E6iSkl9FA1oh1YG1fOq');
    define('KAKAO_ADMIN_KEY', 'b1395c4e8d267b8bba47fcb06cb131d8');
    define('KAKAO_CALLBACK_URL', HTTP_PROTOCOL.FORBIZ_HOST.'/controller/member/kakao');

    // Facebook 설정
    define('FACEBOOK_APP_ID', '454675405082236');
    define('FACEBOOK_APP_SECRET', '5456d8b16dd2f9305b0dfc8867e37e8d');
    define('FACEBOOK_CALLBACK_URL', HTTP_PROTOCOL.FORBIZ_HOST.'/controller/member/facebook');

    // define('FACEBOOK_APP_ID', '707791652991834'); // test
    // define('FACEBOOK_APP_SECRET', 'fbf1057e4833afac03a1928287903f64'); // test


    // Crema 설정
    define('CREMA_APP_ID', 'e6248128c2f5fbb79b736a9eb132c9308da2933d786fc909ae0127bc0aa53723');
    define('CREMA_SECRET', 'c11c03c9452f522387cd351de92f1f1cd3699cc3bde775a7d68a85f1d6893e94');
    define('CREMA_BRAND', 2473);
    define("CREMA_WIDGET_HOST", 'swidgets.cre.ma');
    define("CREMA_API_URL", 'https://sapi.cre.ma');

    // Elascit 설정
    define('ES_HOST', "106.10.38.50:9200"); //local dev


    // Google 설정
    define('GOOGLE_CLIENT_ID', '204674425922-v5u0fuqrgpq1l30scbge0mejoikabrgt.apps.googleusercontent.com');
    define('GOOGLE_CLIENT_SECRET', '7sDJuCvHU6cJv_NYOyh2__JL');

    $_SERVER['CI_ENV'] = 'development';
}else if (FORBIZ_BASEURL == 'barrelfrontdev.forbiz.co.kr' || FORBIZ_BASEURL == 'enbarrelfrontdev.forbiz.co.kr' || FORBIZ_BASEURL == 'testbarrel.forbiz.co.kr' || FORBIZ_BASEURL == 'en.testbarrel.forbiz.co.kr' || FORBIZ_BASEURL == 'barrelfrontdev.welsoop.co.kr') {
    // 개발환경

    // 네이버 설정
    define('NAVER_CLIENT_ID', 'QMi8BKspnu8BxhwbOGns');
    define('NAVER_CLIENT_SECRET', 'RjG2tLNAK8');
    define('NAVER_CALLBACK_URL', HTTP_PROTOCOL.FORBIZ_HOST.'/controller/member/naver');

    // 카카오 설정
    define('KAKAO_APP_KEY', '1887e3a895521e08daaaa30573e7bd42');
    define('KAKAO_SCRIPT_KEY', '33da7242540c272bc28e03a6ee11f41d');
    define('KAKAO_APP_SECRET', '7Wo1cOxrumYe0E6iSkl9FA1oh1YG1fOq');
    define('KAKAO_ADMIN_KEY', 'b1395c4e8d267b8bba47fcb06cb131d8');
    define('KAKAO_CALLBACK_URL', HTTP_PROTOCOL.FORBIZ_HOST.'/controller/member/kakao');

    // Facebook 설정
    define('FACEBOOK_APP_ID', '454675405082236');
    define('FACEBOOK_APP_SECRET', '5456d8b16dd2f9305b0dfc8867e37e8d');
    define('FACEBOOK_CALLBACK_URL', HTTP_PROTOCOL.FORBIZ_HOST.'/controller/member/facebook');

    // Crema 설정
    define('CREMA_APP_ID', 'e6248128c2f5fbb79b736a9eb132c9308da2933d786fc909ae0127bc0aa53723');
    define('CREMA_SECRET', 'c11c03c9452f522387cd351de92f1f1cd3699cc3bde775a7d68a85f1d6893e94');
    define('CREMA_BRAND', 2473);
    define("CREMA_WIDGET_HOST", 'swidgets.cre.ma');
    define("CREMA_API_URL", 'https://sapi.cre.ma');

    // Elascit 설정   
    define('ES_HOST', "10.41.0.203:9200"); //front

    // Google 설정
    define('GOOGLE_CLIENT_ID', '204674425922-v5u0fuqrgpq1l30scbge0mejoikabrgt.apps.googleusercontent.com');
    define('GOOGLE_CLIENT_SECRET', '7sDJuCvHU6cJv_NYOyh2__JL');

    $_SERVER['CI_ENV'] = 'development';
} else {

    // 네이버 설정
    define('NAVER_CLIENT_ID', 'ZJwSr3ANlhNLAcdsQFg3'); // 실서버
    define('NAVER_CLIENT_SECRET', 'itgKAJxZ1g'); // 실서버
    define('NAVER_CALLBACK_URL', HTTP_PROTOCOL.FORBIZ_HOST.'/controller/member/naver');

    // 카카오 설정
    define('KAKAO_APP_KEY', '0ecd0d218e3828fef2f2da6ed14c47fa');
    define('KAKAO_SCRIPT_KEY', '0803de64aa79aa0f59431b289f29d0b4');
    define('KAKAO_APP_SECRET', 'Nhg169tyR3hpfIWMgTVqi7AFnhiDl9he');
    define('KAKAO_ADMIN_KEY', 'ef63734c497c7ce56d9a1afad469239f');
    define('KAKAO_CALLBACK_URL', HTTP_PROTOCOL.FORBIZ_HOST.'/controller/member/kakao');

    // Facebook 설정
    define('FACEBOOK_APP_ID', '518616085571652');
    define('FACEBOOK_APP_SECRET', '480932ec95f1b8aac0043762b07a6eda');
    define('FACEBOOK_CALLBACK_URL', HTTP_PROTOCOL.FORBIZ_HOST.'/controller/member/facebook');

    // Crema 설정
    define('CREMA_APP_ID', 'e6248128c2f5fbb79b736a9eb132c9308da2933d786fc909ae0127bc0aa53723');
    define('CREMA_SECRET', 'c11c03c9452f522387cd351de92f1f1cd3699cc3bde775a7d68a85f1d6893e94');
    define('CREMA_BRAND', 2473);
    define("CREMA_WIDGET_HOST", 'widgets.cre.ma');
    define("CREMA_API_URL", 'https://api.cre.ma');

    // Elascit 설정
    define('ES_HOST', "10.41.167.100:9200"); // op

    //스윔위크 사용 검색 서버 변경 정보
    //define('ES_HOST', "10.41.170.206:9200"); // op

    //레깅스데이 사용 검색 서버 변경 정보
    //define('ES_HOST', "10.41.176.43:9200"); // op

    //20.10.14 배럴데이 사용 검색 서버 변경 정보
    //define('ES_HOST', "10.41.27.237:9200"); // op

    // Google 설정
    define('GOOGLE_CLIENT_ID', '204674425922-v5u0fuqrgpq1l30scbge0mejoikabrgt.apps.googleusercontent.com');
    define('GOOGLE_CLIENT_SECRET', '7sDJuCvHU6cJv_NYOyh2__JL');

    // 프레임워크 운영환경
    $_SERVER['CI_ENV'] = 'production';
}

//카카오모먼트 스크립트 관리 키
define('KAKAO_MOMENT_KEY','8430777460128761104');

define('BARREL_SHOPPING', '1.0');


define('BARREL_MASTER_IP', array('220.75.187.234','221.151.188.11'));
define('BARREL_MASTER_PW', 'barrel8751');
