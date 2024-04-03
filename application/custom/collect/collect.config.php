<?php
///////////////////////////////////////////////////
// 수집 모듈 사용 여부
///////////////////////////////////////////////////
define('USE_COLLECT', true);
///////////////////////////////////////////////////
// rabbitMq 사용 여부
///////////////////////////////////////////////////
define('RABBITMQ_USE', true);
///////////////////////////////////////////////////
// Collect db 연결명
///////////////////////////////////////////////////
define('COLLECT_DB_CONN', 'stat');

///////////////////////////////////////////////////
// 프레임워크 연동 상수 정의
///////////////////////////////////////////////////
define('CORE_ROOT', realpath(__DIR__.'/../../../core').'/');
define('CUSTOM_ROOT', realpath(__DIR__.'/..').'/');
define('FORBIZ_BASEURL', str_replace(['www.', 'm.'], '', $_SERVER['HTTP_HOST']));
define('CUSTOM_CONFIG_PATH', CUSTOM_ROOT.'/config');

///////////////////////////////////////////////////
// collect 상수 선언
///////////////////////////////////////////////////
define('VENDOR_ROOT', CORE_ROOT.'ThirdParty/vendor/');
define('COLLECT_INC_ROOT', CUSTOM_ROOT.'collect/');
define('COLLECT_CLASS_PATH', COLLECT_INC_ROOT.'class/');

///////////////////////////////////////////////////
// 쿠키 도메인 설정
///////////////////////////////////////////////////
define('COOKIE_DOMAIN', '.'.FORBIZ_BASEURL);

///////////////////////////////////////////////////
// 테이블 상수
///////////////////////////////////////////////////
defined('TBL_LOGSTORY_PAGEINFO') OR define('TBL_LOGSTORY_PAGEINFO', 'logstory_pageinfo');
defined('TBL_LOGSTORY_BYPAGE') OR define('TBL_LOGSTORY_BYPAGE', 'logstory_bypage');
defined('TBL_LOGSTORY_PAGEVIEWTIME') OR define('TBL_LOGSTORY_PAGEVIEWTIME', 'logstory_pageviewtime');
defined('TBL_LOGSTORY_DURATIONTIME') OR define('TBL_LOGSTORY_DURATIONTIME', 'logstory_durationtime');
defined('TBL_LOGSTORY_REVISITTIME') OR define('TBL_LOGSTORY_REVISITTIME', 'logstory_revisittime');
defined('TBL_LOGSTORY_REFERER_CATEGORYINFO') OR define('TBL_LOGSTORY_REFERER_CATEGORYINFO', 'logstory_referer_categoryinfo');
defined('TBL_LOGSTORY_VISITTIME') OR define('TBL_LOGSTORY_VISITTIME', 'logstory_visittime');
defined('TBL_LOGSTORY_VISITOR') OR define('TBL_LOGSTORY_VISITOR', 'logstory_visitor');
defined('TBL_LOGSTORY_VISITORINFO') OR define('TBL_LOGSTORY_VISITORINFO', 'logstory_visitorinfo');
defined('TBL_LOGSTORY_REFERERURL') OR define('TBL_LOGSTORY_REFERERURL', 'logstory_refererurl');
defined('TBL_LOGSTORY_BYREFERER') OR define('TBL_LOGSTORY_BYREFERER', 'logstory_ByReferer');
defined('TBL_LOGSTORY_ETCREFERERINFO') OR define('TBL_LOGSTORY_ETCREFERERINFO', 'logstory_etcrefererinfo');
defined('TBL_LOGSTORY_KEYWORDINFO') OR define('TBL_LOGSTORY_KEYWORDINFO', 'logstory_keywordinfo');
defined('TBL_LOGSTORY_BYKEYWORD') OR define('TBL_LOGSTORY_BYKEYWORD', 'logstory_ByKeyword');
defined('TBL_LOGSTORY_DURATION_HISTORY') OR define('TBL_LOGSTORY_DURATION_HISTORY', 'logstory_duration_history');
defined('TBL_LOGSTORY_ETCHOST') OR define('TBL_LOGSTORY_ETCHOST', 'logstory_etchost');
defined('TBL_LOGSTORY_BYETCREFERER') OR define('TBL_LOGSTORY_BYETCREFERER', 'logstory_ByetcReferer');

///////////////////////////////////////////////////
// Mallid 정의
///////////////////////////////////////////////////
require_once(CUSTOM_CONFIG_PATH.'/server/'.FORBIZ_BASEURL.'.config.php');
///////////////////////////////////////////////////
// Db class 로드
///////////////////////////////////////////////////
require_once(COLLECT_CLASS_PATH.'ForbizMySQLi.class.php');
///////////////////////////////////////////////////
// collect helper 로드
///////////////////////////////////////////////////
require_once(COLLECT_INC_ROOT.'collect.helper.php');
