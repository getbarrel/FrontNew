<?php
// Forbiz 솔루션 관리자 버젼
define('FORBIZ_MALL_VERSION', '4.3');
// CLI 여부
define('IS_FORBIZ_CLI', PHP_SAPI === 'cli' OR defined('STDIN'));
define('IS_FORBIZ_WEB', !IS_FORBIZ_CLI);

// 모바일 점검 함수
function _is_mobile()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i',
            $_SERVER['HTTP_USER_AGENT'])) {
        return true;
    } else {
        return false;
    }
}
// CORE_MALL_ROOT ROOT 정의
define('CORE_MALL_ROOT', realpath(__DIR__));
// CORE ROOT 정의
define('CORE_ROOT', realpath(CORE_MALL_ROOT.'/../core'));
// APPLICATION ROOT 정의
define('APPLICATION_ROOT', realpath(CORE_MALL_ROOT.'/../application'));
// CUSTOM ROOT 정의
define('CUSTOM_ROOT', realpath(APPLICATION_ROOT.'/custom'));

// Document Root 전역변수 및 상수 설정
defined('DOCUMENT_ROOT') OR define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
// BASEURL 정의
defined('FORBIZ_BASEURL') OR define('FORBIZ_BASEURL', str_replace(['www.', 'm.'], '', $_SERVER['HTTP_HOST']));
defined('FORBIZ_HOST') OR define('FORBIZ_HOST', $_SERVER['HTTP_HOST']);
// CONIF PATH 정의
define('CORE_CONFIG_PATH', CORE_ROOT.'/config');
define('CORE_MALL_CONFIG_PATH', CORE_MALL_ROOT.'/config');
define('CUSTOM_CONFIG_PATH', CUSTOM_ROOT.'/config');

// Mallid 정의
if (is_file(CUSTOM_CONFIG_PATH.'/server/'.FORBIZ_BASEURL.'.config.php')) {
    require_once(CUSTOM_CONFIG_PATH.'/server/'.FORBIZ_BASEURL.'.config.php');
} else {
    exit(FORBIZ_BASEURL.' config not exists!');
}

// CONSTANS 로드
require_once(CUSTOM_CONFIG_PATH.'/constants.php');

// Js,Css 버전
defined('CLIENT_VERSION') OR define('CLIENT_VERSION', filemtime(__FILE__));

// 시스템 정지 확인
if (IS_FORBIZ_WEB && defined('FORBIZ_SHUTDOWN') && FORBIZ_SHUTDOWN === true) {
    if (file_exists(CUSTOM_ROOT.'/helper/shutdown.helper.php')) {
        $shutdownFunc = require_once(CUSTOM_ROOT.'/helper/shutdown.helper.php');
        if (is_callable($shutdownFunc)) {
            $shutdownIncFile = $shutdownFunc();

            if ($shutdownIncFile && file_exists($shutdownIncFile)) {
                require_once($shutdownIncFile); // 시스템 정지 안내
                exit;
            } else {
                //exit('SYSTEM 점검중입니다.');
            }
        } else {
            exit('SYSTEM 점검중입니다.');
        }
    } else {
        exit('SYSTEM 점검중입니다.');
    }
}

require_once(CORE_MALL_CONFIG_PATH.'/constants.php');
require_once(CORE_CONFIG_PATH.'/constants.php');

define('MALL_DATA', MALL_ID.'_data');
define('DATA_ROOT', '/data/'.MALL_DATA);
define('MALL_DATA_PATH', DOCUMENT_ROOT.DATA_ROOT);

// 메시지(메일) 템플릿 저장 경로
defined('MESSAGE_TEMPLATE_PATH') OR define('MESSAGE_TEMPLATE_PATH', MALL_DATA_PATH.'/_message');

// 타임존 설정
date_default_timezone_set('Asia/Seoul');
// layout 시간 측정 시작
$script_times['layout_start'] = time();

// Class Path 정의
define('FORBIZ_CLASS_PATH', realpath(CORE_ROOT.'/class').DIRECTORY_SEPARATOR);

// 몰별 Custom DATA 함수 및 session, cookie 관련 설정
if (defined('MALL_ID') && MALL_ID != '') {
    (function() {
        if (IS_FORBIZ_WEB) {
            if (ini_get('session.save_handler') === 'files') {
                $session_path = CUSTOM_ROOT.'/_session/'.MALL_ID;
                if (!is_dir($session_path)) {
                    mkdir($session_path, 0777, true);
                }
                ini_set('session.save_path', $session_path);
            }
            ini_set('session.cookie_domain', ('.'.FORBIZ_BASEURL));

            if (defined('SESSION_INTEGRATION') && SESSION_INTEGRATION === true) {
                // 언어별 세션ID 사용
                session_name('SESSION_ID_'.strtoupper(BASIC_LANGUAGE));
            }

            // 세션 시작
            session_start();
        }
    })();
} else {
    exit('Mall 설정(ID 및 DATA)을 확인하여 주십시오.');
}

//LANGUAGE 설정
define('LANGUAGE', ($_COOKIE['language'] ?? BASIC_LANGUAGE));

// Autoload Class 설정
require_once(CORE_ROOT.'/autoload.php');
require_once(CORE_MALL_ROOT.'/autoload.php');
if (file_exists(CUSTOM_ROOT.'/autoload.php')) {
    require_once (CUSTOM_ROOT.'/autoload.php');
}

// Custom template Config load
if (file_exists(CUSTOM_ROOT.'/config/template.php')) {
    require_once(CUSTOM_ROOT.'/config/template.php');
}

// Template 설정
if (is_mobile()) {
    defined('FORBIZ_TPL_TPLDIR') OR define('FORBIZ_TPL_TPLDIR', DOCUMENT_ROOT.'/assets/mobile_templet');
    defined('FORBIZ_TPL_SKIN') OR define('FORBIZ_TPL_SKIN', MALL_MOBILE_TEMPLATE);
} else {
    defined('FORBIZ_TPL_TPLDIR') OR define('FORBIZ_TPL_TPLDIR', DOCUMENT_ROOT.'/assets/templet');
    defined('FORBIZ_TPL_SKIN') OR define('FORBIZ_TPL_SKIN', MALL_TEMPLATE);
}
defined('FORBIZ_TPL_MSGDIR') OR define('FORBIZ_TPL_MSGDIR', MALL_DATA_PATH.'/_message');
defined('FORBIZ_TPL_CPLDIR') OR define('FORBIZ_TPL_CPLDIR', DOCUMENT_ROOT.'/assets/_compile/'.LANGUAGE);
defined('FORBIZ_TPL_CACHEDIR') OR define('FORBIZ_TPL_CACHEDIR', DOCUMENT_ROOT.'/assets/_cache/'.LANGUAGE);
defined('TPL_ROOT') OR define('TPL_ROOT', str_replace(DOCUMENT_ROOT, '', FORBIZ_TPL_TPLDIR).'/'.FORBIZ_TPL_SKIN);

// 전역 Helper Load
if (file_exists(CUSTOM_ROOT.'/helper/common.helper.php')) {
    // Custom
    require_once (CUSTOM_ROOT.'/helper/common.helper.php');
}
require_once (CORE_MALL_ROOT.'/helper/common.helper.php');
require_once (CORE_ROOT.'/helper/common.helper.php');

if (!defined('FORBIZ_CORE_MALL_ROOT')) {
    $forbiz_path = realpath(__DIR__.'/../core/framework/Forbiz.php');

    if ($forbiz_path) {
        require_once($forbiz_path);
    } else {
        throw new Exception('Invalid ForbizCore path');
    }
}
