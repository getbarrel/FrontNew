<?php

/**
 * Description of forvizGather
 *
 * @author hoksi
 */
Class forbizGather {

    public $fREQUEST_URI;
    public $fPHP_SELF;
    public $fHTTP_REFERER;
    public $fHTTP_HOST;
    public $fREMOTE_ADDR;
    public $VISITID;
    public $VISITORID;
    public $VisitCookie;
    public $VisitTime;
    public $VisitDate;
    public $fRefererID;
    public $fetcRefererID;
    public $SearchParam;
    public $SearchKeyWordId;
    public $PageID;
    public $DurationTime;
    public $BEFORE_LAST_CON_TIME;
    public $USERID;
    public $UCODE;
    public $COOKIE_HOST;
    public $OVER_TURE;
    public $PARAM_ANALISYS;
    public $KID;
    public $fHOST;
    public $siteID;
    public $data_root;
    public $agent_type = "W";

    function __construct() {
        global $PHP_SELF, $HTTP_REFERER, $HTTP_HOST, $REMOTE_ADDR, $REQUEST_URI, $HTTP_USER_AGENT;

        if (!(substr_count(strtolower($HTTP_HOST), strtolower("mallstory.com")) > 0)) {
            $adb = new ForbizMySQLi();

            $sql = "insert into " . TBL_LOGSTORY_ETCHOST . " (idx,referer, etcuri,etchost) values ('','" . strtolower($HTTP_REFERER) . "','" . strtolower($REQUEST_URI) . "','" . strtolower($HTTP_HOST) . "') ";
            //echo $sql;
            //$adb->query($sql);
        }

        if (substr_count(strtolower($HTTP_HOST), "www") > 0) {
            $cookie_domain = str_replace("www.", ".", $_SERVER["HTTP_HOST"]);
        } else {
            $cookie_domain = "." . $_SERVER["HTTP_HOST"];
        }
        //echo $cookie_domain;
        $this->OVER_TURE = false;
        $this->PARAM_ANALISYS = false;
        $this->COOKIE_HOST = $cookie_domain; //".mallstory.com";
        $this->fREQUEST_URI = $REQUEST_URI;
        $this->fPHP_SELF = $PHP_SELF;
        $this->fHTTP_REFERER = strtolower($HTTP_REFERER);
        $this->fHTTP_HOST = strtolower($HTTP_HOST);
        $this->fREMOTE_ADDR = $REMOTE_ADDR;
        $this->fHTTP_USER_AGENT = $HTTP_USER_AGENT;
        if (!isset($_COOKIE["VID"]) || $_COOKIE["VID"] == "") {
            $this->VISITID = md5(uniqid(rand()));
        } else {
            $this->VISITID = $_COOKIE["VID"];
        }

        if (isset($_SESSION["user"]["id"]) && $_SESSION["user"]["id"] != "") {
            $this->USERID = $_SESSION["user"]["id"];
            $this->UCODE = $_SESSION["user"]["code"];
            setcookie("USERID", $_SESSION["user"]["id"], time() + 2592000, "/", $HTTP_HOST);
            setcookie("UCODE", $_SESSION["user"]["code"], time() + 2592000, "/", $HTTP_HOST);
        } else if (isset($_COOKIE["USERID"]) && $_COOKIE["USERID"]) {
            $this->USERID = "(-) " . $_COOKIE["USERID"];
            $this->UCODE = $_COOKIE["UCODE"];
        } else {
            $this->USERID = "";
            $this->UCODE = "";
        }

        if (!isset($_COOKIE["UVID"]) || $_COOKIE["UVID"] == "") {
            $this->VISITORID = md5(uniqid(rand()));
        } else {
            $this->VISITORID = $_COOKIE["UVID"];
        }

        $this->VisitTime = date("H", time());
        $this->VisitDate = date("Ymd", time());

        if (isset($_COOKIE["LAST_CON_TIME"]) && $_COOKIE["LAST_CON_TIME"]) {
            $this->BEFORE_LAST_CON_TIME = $_COOKIE["LAST_CON_TIME"];
        } else {
            $this->BEFORE_LAST_CON_TIME = date("Y-m-d H:i:s");
        }

        if (isset($_COOKIE["RFID"]) && $_COOKIE["RFID"] && $_COOKIE["RFID"] != "000005000000000") {
            $this->fRefererID = $_COOKIE["RFID"];
        } else {
            $this->fRefererID = $this->CheckReferer(strtolower($HTTP_REFERER), strtolower($REQUEST_URI));
        }

        $this->SearchKeyWordId = $this->InsertKeyWord(strtolower($HTTP_REFERER), strtolower($REQUEST_URI));
        if ($this->SearchKeyWordId) {
            $this->KID = $this->SearchKeyWordId;
        } else {
            $this->KID = $_COOKIE["KWID"] ?? '';
        }
    }

    function CheckDuration() {
        global $HTTP_HOST;
        if ($_COOKIE["LAST_CON_TIME"] == "") {
            setcookie("LAST_CON_TIME", time(), time() + 1800, "/", $HTTP_HOST);
            return 0;
        } else {
            $Before_Duration = $_COOKIE["LAST_CON_TIME"];
            setcookie("LAST_CON_TIME", time(), time() + 1800, "/", $HTTP_HOST);
            return time() - $Before_Duration;
        }
    }

    function VisitSetCookie() {
        //setcookie("VID",$URL, time()+180000,"/",$HTTP_HOST);
    }

    function CheckReferer($this_referer, $this_url = '') {

        if (!isset($_COOKIE["VID"]) || $_COOKIE["VID"] == "") {
            $db = new ForbizMySQLi();

            // 파라미터에 따라 유입사이트가 결정
            $sql = "select cid,vreferer_url,vkeyword, vparameter , case when vparameter = '' then 0 else 1 end as paramorder
									from " . TBL_LOGSTORY_REFERER_CATEGORYINFO . "
									where vparameter <> '' and depth in (2,3,4)
									order by paramorder desc";
            $db->query($sql);

            for ($i = 0; $i < $db->total; $i++) {
                $db->fetch($i);

                // 파라미터가 있는지 확인
                if ($this_referer == "" || substr_count($this_referer, $this->fHTTP_HOST) > 0) {
                    // 현재 페이지 URL 에서 파라미터 검사
                    if ($this->SearchString($db->dt['vparameter'], $db->dt['cid'], $this_url)) { // 해당 파라미터가 있을때
                        if ($db->dt[vparameter] == "OVRAW") { // 파라미터가 OVRAW 이면 오버추어 분석
                            $this->OVER_TURE = true;
                        }
                        $this->PARAM_ANALISYS = true;
                        $this->SearchParam = $db->dt['vparameter'];
                        return $db->dt[cid]; // 레퍼러가 없을때는 파라미터가 검색된 유입사이트를 선택
                        exit;
                    }
                } else { // 레피러가 있을때
                    if ($this->SearchString(str_replace("*.", "", $db->dt[vreferer_url]), $db->dt[cid], $this_referer)) {
                        if ($this->SearchString($db->dt[vparameter], $db->dt[cid], $this_url)) {
                            if ($db->dt['vparameter'] == "OVRAW") {
                                $this->OVER_TURE = true;
                            }
                            $this->PARAM_ANALISYS = true;
                            $this->SearchParam = $db->dt['vparameter'];
                            return $db->dt[cid];
                            exit;
                        }
                    }
                }
            }


            if ($this_referer == "") {
                return "000005000000000"; // 직접방문
            }

            $sql = "select cid,vreferer_url,vkeyword, vparameter , case when vparameter = '' then 0 else 1 end as paramorder
									from " . TBL_LOGSTORY_REFERER_CATEGORYINFO . "
									where vreferer_url != '' and depth in (2,3,4)
									order by paramorder desc";

            $db->query($sql);

            for ($i = 0; $i < $db->total; $i++) {
                $db->fetch($i);

                if ($db->dt['vreferer_url'] != "") {
                    if ($this->SearchString(str_replace("*.", "", $db->dt['vreferer_url']), $db->dt['cid'], $this_referer)) {
                        $this->SearchParam = $db->dt['vkeyword'];
                        return $db->dt[cid];
                        exit;
                    }
                }
            }


            if ($this->SearchString($this->fHTTP_HOST, "000005000000000", $this_referer)) {
                return "000005000000000";
            } else {
                $this->fetcRefererID = $this->InsertEtcReferer($this_referer);
                return "000004000000000";
            }
        } else {
            return $_COOKIE["RFID"];
        }
    }

    function GetPageID($pageurl) {

        $db = new forbizDatabase();

        $db->query("select pageid from " . TBL_LOGSTORY_PAGEINFO . " where vurl = '" . strtolower($pageurl) . "'");

        if ($db->total > 0) {
            $db->fetch(0);
            $this->PageViewInsertByPage($db->dt[pageid]);
            setcookie("PAGEID", $db->dt[pageid], time() + 180000, "/", $HTTP_HOST);
            return $db->dt[pageid];
        } else {

            $sql = "insert into " . TBL_LOGSTORY_PAGEINFO . " (pageid,vurl,vdate) values ('','" . strtolower($pageurl) . "','" . $this->VisitDate . "') ";
            $db->sequences = "LOGSTORY_PAGEINFO_SEQ";
            $db->query($sql);

            if ($db->dbms_type == "oracle") {
                $pageid = $db->last_insert_id;
            } else {
                $db->query("SELECT pageid FROM " . TBL_LOGSTORY_PAGEINFO . " WHERE pageid=LAST_INSERT_ID()");
                $db->fetch(0);
                $pageid = $db->dt[0];
            }
            $this->PageViewInsertByPage($pageid);
            setcookie("PAGEID", $pageid, time() + 180000, "/", $HTTP_HOST);
            return $pageid;
        }
    }

    function PageViewInsertByPage($page_id) {
        global $user;
        $db = new forbizDatabase();

        $db->query("select pageid from " . TBL_LOGSTORY_BYPAGE . " where pageid = '$page_id' and vdate ='" . $this->VisitDate . "'");

        if ($db->total > 0) {
            $db->query("update " . TBL_LOGSTORY_BYPAGE . " set ncnt = ncnt+1, nduration = nduration + " . $this->DurationTime . " where pageid = '" . $page_id . "' and vdate ='" . $this->VisitDate . "'");
        } else {
            $db->query("insert into " . TBL_LOGSTORY_BYPAGE . " (vdate,pageid) values ('" . $this->VisitDate . "','" . $page_id . "') ");
        }

        if (true) {
            $memcache = new Memcache;
            //$memcache_obj = memcache_connect("183.111.154.6 ", 22);
            $memcache->connect(MEMCACHE_IP, MEMCACHE_PORT);
            $realtime_data = $memcache->get('realtime_data');
            $realtime_data[$_COOKIE["VID"]] = array(
                'server_addr' => $_SERVER["SERVER_ADDR"],
                'ipaddr' => $_SERVER["REMOTE_ADDR"],
                'user_id' => $this->USERID,
                'user_code' => $this->UCODE,
                'page_id' => $page_id,
                'before_visit_date' => date("Y-m-d H:i:s", $this->BEFORE_LAST_CON_TIME),
                'recent_visit_date' => date("Y-m-d H:i:s"),
                'VID' => $_COOKIE["VID"]
            );


            $result = $memcache->add("realtime_data", $realtime_data, false, 100);
            if (!$result) {
                $result = $memcache->set("realtime_data", $realtime_data, false, 100);
            }
        } else {
            $shmop = new Shared("realtime_data");
            $shmop->filepath = $_SERVER["DOCUMENT_ROOT"] . $this->data_root . "/_shared/";
            //echo $shmop->filepath;
            $shmop->SetFilePath();
            $realtime_data = $shmop->getObjectForKey("realtime_data");
            $realtime_data[md5($_SERVER["REMOTE_ADDR"])] = array('server_addr' => $_SERVER["SERVER_ADDR"], 'ipaddr' => $_SERVER["REMOTE_ADDR"], 'user_id' => $this->USERID, 'user_code' => $this->UCODE, 'page_id' => $page_id, 'before_visit_date' => date("Y-m-d H:i:s", $this->BEFORE_LAST_CON_TIME), 'recent_visit_date' => date("Y-m-d H:i:s"));

            if (count($realtime_data) > 100) {
                foreach ($realtime_data as $key => $row) {
                    if ((time() - strtotime($row['recent_visit_date'])) > 600) {
                        unset($realtime_data[$key]);
                    }
                }
            }


            $shmop->setObjectForKey($realtime_data, "realtime_data");
        }
    }

    function InsertEtcReferer($vreferer_url) {

        $db = new forbizDatabase();



        $db->query("select vetcreferer_id from " . TBL_LOGSTORY_ETCREFERERINFO . " where vetcreferer_url = '" . strtolower($vreferer_url) . "'");



        if ($db->total > 0) {
            $db->fetch(0);
            return $db->dt[vetcreferer_id];
        } else {
            $sql = "insert into " . TBL_LOGSTORY_ETCREFERERINFO . " (vetcreferer_id,vetcreferer_url,vdate) values ('','" . strtolower($vreferer_url) . "','" . $this->VisitDate . "') ";
            $db->sequences = "LOGSTORY_ETCREFERERINFO_SEQ";
            $db->query($sql);


            if ($db->dbms_type == "oracle") {
                $vetcreferer_id = $db->last_insert_id;
            } else {
                $db->query("SELECT vetcreferer_id FROM " . TBL_LOGSTORY_ETCREFERERINFO . " WHERE vetcreferer_id=LAST_INSERT_ID()");
                $db->fetch(0);
                $vetcreferer_id = $db->dt[0];
            }
            return $vetcreferer_id;
        }
    }

    function SearchString($str, $ref_id, $referer_url) {
        $numarray = explode(",", $str);
        $size = count($numarray);
        parse_str($referer_url, $paraminfos);
        //print_r($paraminfos);
        for ($i = 0; $i < $size; $i++) {
            if (@substr_count(strtolower($referer_url), strtolower($numarray[$i])) > 0) {

                //if($paraminfos[strtolower($numarray[$i])]){
                $this->SearchParam = strtolower($numarray[$i]);
                return true;
            }
        }

        return false;
    }

    function InsertKeyWord($vreferer_url, $vrequest_uri) {

        if ($this->SearchParam == "") {
            return "";
            exit;
        }
        if ($this->PARAM_ANALISYS) {
            parse_str(urldecode($vrequest_uri), $myarray);
        } else {
            parse_str(urldecode($vreferer_url), $myarray);
        }

        $db = new forbizDatabase();
        $myarray[$this->SearchParam] = $myarray[$this->SearchParam] ?? '';

        $encoding_type = mb_detect_encoding($myarray[$this->SearchParam]);
        if ($encoding_type == "UTF-8") {
            $search_keyword = iconv('CP949', 'UTF-8', $myarray[$this->SearchParam]);
            if ($search_keyword == "") {
                $search_keyword = $myarray[$this->SearchParam];
            }
        } else {
            $search_keyword = iconv('CP949', 'UTF-8', $myarray[$this->SearchParam]);
            if ($search_keyword == "") {
                $search_keyword = $myarray[$this->SearchParam];
            }
        }
        $db->query("select kid from " . TBL_LOGSTORY_KEYWORDINFO . " where keyword = '" . $search_keyword . "' limit 0, 1");

        if ($db->total > 0) {
            $db->fetch(0);
            return $db->dt['kid'];
        } else {
            //if($this->fRefererID == "000001001000000"){

            $sql = "insert into " . TBL_LOGSTORY_KEYWORDINFO . " (kid,keyword,charset,vdate) values ('','" . $search_keyword . "', '" . $encoding_type . "',NOW()) ";
            $db->sequences = "LOGSTORY_KEYWORDINFO_SEQ";
            $db->query($sql);

            if ($db->dbms_type == "oracle") {
                $kid = $db->last_insert_id;
            } else {
                $db->query("SELECT kid FROM " . TBL_LOGSTORY_KEYWORDINFO . " WHERE kid=LAST_INSERT_ID()");
                $db->fetch(0);
                $kid = $db->dt[0];
            }
            return $kid;
        }
    }

}
