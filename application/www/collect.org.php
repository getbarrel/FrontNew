<?php
header("Cache-control: no-cache");
header("Pragma: no-cache");
header("P3P:CP=\"NOI DSP COR DEVa TAIa OUR BUS UNI COM NAV STA PRE\"");

// 기본 설정 파일
require_once($_SERVER['DOCUMENT_ROOT'] . '/../../core-mall/forbiz.config.php');
// 상수 Include
//require_once(OLDBASE_ROOT."/include/constants.php");

// Database 설정 로드
require_once(OLDBASE_ROOT . '/class/mysqli.class.php');

// DB DRIVER LOAD
//require_once(OLDBASE_ROOT."/class/".FORBIZ_MALL_DB_DRIVER.".class.php");
extract($_GET);
extract($_POST);
extract($_SERVER);

require_once(OLDBASE_ROOT . "/class/businessLogic.clientversion.class.php");

$pars = [];
parse_str($_SERVER['QUERY_STRING'], $pars);

$referer = ($referer ?? ($pars['referer'] ?? ''));
$siteID = ($siteID ?? ($pars['siteID'] ?? ''));
$URL = ($URL ?? ($pars['URL'] ?? ''));
$agent_type = ($agent_type ?? ($pars['agent_type'] ?? ''));
$leftURL = ($leftURL ?? ($pars['leftURL'] ?? ''));
$title = ($title ?? ($pars['title'] ?? ''));

if (substr_count(strtolower($referer), str_replace(array("www.", "b2b."), "", $_SERVER["HTTP_HOST"])) > 0) {
    $referer = "";
}

$URL = str_replace(array($_SERVER["HTTP_HOST"], str_replace("www.", "", $_SERVER["HTTP_HOST"])), "", $URL);
$URL = str_replace("//", "/", $URL);

$fg = new forbizGather();

if (substr_count(strtolower($HTTP_HOST), "www") > 0) {
    $cookie_domain = str_replace("www.", ".", $_SERVER["HTTP_HOST"]);
} else {
    $cookie_domain = "." . $_SERVER["HTTP_HOST"];
}
//echo $cookie_domain;
$debug = $debug ?? false;

$fg->OVER_TURE = false;
$fg->PARAM_ANALISYS = false;
$fg->debug = $debug;
$fg->COOKIE_HOST = $cookie_domain; //".mallstory.com";

$fg->fPHP_SELF = $URL;
$fg->fHTTP_REFERER = $referer;
$fg->fREQUEST_URI = "";
$fg->fHTTP_HOST = strtolower($_SERVER["HTTP_HOST"]);
$fg->fREMOTE_ADDR = $_SERVER["REMOTE_ADDR"];
$fg->fHTTP_USER_AGENT = $_SERVER["HTTP_USER_AGENT"];
$fg->agent_type = $agent_type;
$fg->siteID = $siteID;
$fg->data_root = DATA_ROOT;

if (cook_val("VID") == "") {
    $fg->VISITID = md5(uniqid(rand()));
} else {
    $fg->VISITID = $_COOKIE["VID"];
}

if (sess_val("user", "id") != "") {
    $fg->USERID = $_SESSION["user"]["id"];
    $fg->UCODE = $_SESSION["user"]["code"];
    setcookie("USERID", $_SESSION["user"]["id"], time() + 2592000, "/", $HTTP_HOST);
    setcookie("UCODE", $_SESSION["user"]["code"], time() + 2592000, "/", $HTTP_HOST);
} else if (cook_val("USERID")) {
    $fg->USERID = "(-) " . cook_val("USERID");
    $fg->UCODE = cook_val("UCODE");
} else {
    $fg->USERID = "";
    $fg->UCODE = "";
}

$fg->VisitTime = date("H", time());
$fg->VisitDate = date("Ymd", time());

if (cook_val("LAST_CON_TIME")) {
    $fg->BEFORE_LAST_CON_TIME = $_COOKIE["LAST_CON_TIME"];
} else {
    $fg->BEFORE_LAST_CON_TIME = date("Y-m-d H:i:s");
}

$fg->DurationTime = $fg->CheckDuration();

if ($debug) {
    //	$fg->fRefererID = $fg->CheckReferer(strtolower($referer),strtolower($URL) );
    if (cook_val("RFID") && cook_val("RFID") != "000005000000000") {
        $fg->fRefererID = $_COOKIE["RFID"];
    } else {
        $fg->fRefererID = $fg->CheckReferer(strtolower($referer), strtolower($URL));
    }
} else {
    //print_r($_COOKIE);
    if (cook_val("RFID") && cook_val("RFID") != "000005000000000") {
        $fg->fRefererID = $_COOKIE["RFID"];
    } else {
        $fg->fRefererID = $fg->CheckReferer(strtolower($referer), strtolower($URL));
    }
}

$fg->PageID = $fg->GetPageID($URL);
$fg->SearchKeyWordId = $fg->InsertKeyWord(strtolower($referer), strtolower($URL));

$bl = new BusinessLogic($fg, ($cdb ?? ''));

if (false) {
    $path = $_SERVER["DOCUMENT_ROOT"] . "/_logs/";

    if (!is_dir($path)) {
        mkdir($path, 0777);
        chmod($path, 0777);
    }

    $path = $_SERVER["DOCUMENT_ROOT"] . "/_logs/logstory_" . date("Ymd") . ".log";

    $fp = fopen($_SERVER["DOCUMENT_ROOT"] . "/_logs/logstory_" . date("Ymd") . ".log", "a+");
    fwrite($fp, $REQUEST_URI . "\n");

    if (!file_exists($path)) {
        chmod($path, 0777);
    }
}
