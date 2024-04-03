<?php

//header("Cache-control: no-cache");
//header("Pragma: no-cache");
//header("P3P:CP=\"NOI DSP COR DEVa TAIa OUR BUS UNI COM NAV STA PRE\"");


Class forbizGather {

    var $fREQUEST_URI;
    var $fPHP_SELF;
    var $fHTTP_REFERER;
    var $fHTTP_HOST;
    var $fREMOTE_ADDR;
    var $VISITID;
    var $VISITORID;
    var $VisitCookie;
    var $VisitTime;
    var $VisitDate;
    var $fRefererID;
    var $fetcRefererID;
    var $SearchParam;
    var $SearchKeyWordId;
    var $PageID;
    var $DurationTime;
    var $BEFORE_LAST_CON_TIME;
    var $USERID;
    var $UCODE;
    var $COOKIE_HOST;
    var $OVER_TURE;
    var $PARAM_ANALISYS;
    var $KID;
    var $debug;
    var $fHOST;
    var $siteID;
    var $data_root;
    var $agent_type = "W";

    function CheckDuration() {
        global $HTTP_HOST;
        if (($_COOKIE["LAST_CON_TIME"] ?? '') == "") {
            setcookie("LAST_CON_TIME", time(), time() + 1800, "/", $HTTP_HOST);
            return 0;
        } else {
            $Before_Duration = $_COOKIE["LAST_CON_TIME"];
            setcookie("LAST_CON_TIME", time(), time() + 1800, "/", $HTTP_HOST);
            return time() - $Before_Duration;
        }
    }

    function VisitSetCookie() {
    }

    function CheckReferer111($this_referer, $this_url = '') {

        if ($_COOKIE["VID"] == "") {
            $db = new Database();

            // 파라미터에 따라 유입사이트가 결정
            $sql = "select cid,vreferer_url,vkeyword, vparameter , case when vparameter = '' then 0 else 1 end as paramorder
									from " . TBL_LOGSTORY_REFERER_CATEGORYINFO . "
									where vparameter <> '' and depth in (2,3,4,5)
									order by paramorder desc";
            $db->query($sql);

            for ($i = 0; $i < $db->total; $i++) {
                $db->fetch($i);

                // 파라미터가 있는지 확인
                if ($this_referer == "" || substr_count($this_referer, $this->fHTTP_HOST) > 0) {

                    // 현재 페이지 URL 에서 파라미터 검사
                    if ($this->SearchString($db->dt['vparameter'], $db->dt[cid], $this_url)) { // 해당 파라미터가 있을때
                        if ($db->dt['vparameter'] == "OVRAW") { // 파라미터가 OVRAW 이면 오버추어 분석
                            $this->OVER_TURE = true;
                        }
                        $this->PARAM_ANALISYS = true;
                        $this->SearchParam = $db->dt['vparameter'];
                        return $db->dt['cid']; // 레퍼러가 없을때는 파라미터가 검색된 유입사이트를 선택
                        exit;
                    }
                } else { // 레피러가 있을때
                    if ($this->SearchString(str_replace("*.", "", $db->dt['vreferer_url']), $db->dt['cid'], $this_referer)) {
                        if ($this->SearchString($db->dt['vparameter'], $db->dt['cid'], $this_url)) {
                            if ($db->dt['vparameter'] == "OVRAW") {
                                $this->OVER_TURE = true;
                            }
                            $this->PARAM_ANALISYS = true;
                            $this->SearchParam = $db->dt['vparameter'];
                            return $db->dt['cid'];
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
									where vreferer_url != '' and depth in (2,3,4,5)
									order by paramorder desc";

            $db->query($sql);

            for ($i = 0; $i < $db->total; $i++) {
                $db->fetch($i);

                if ($db->dt['vreferer_url'] != "") {
                    if ($this->SearchString(str_replace("*.", "", $db->dt['vreferer_url']), $db->dt['cid'], $this_referer)) {
                        $this->SearchParam = $db->dt['vkeyword'];
                        return $db->dt['cid'];
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

    function CheckReferer($this_referer, $this_url = '') {
        //echo $this_referer;
        if (($_COOKIE["VID"] ?? '') == "" || $this->debug) {
            //echo $this_referer;
            $db = new Database();
            $db->debug = $this->debug;
            // 파라미터에 따라 유입사이트가 결정
            $sql = "select cid,vreferer_url,vkeyword, vparameter , case when vparameter = '' then 0 else 1 end as paramorder
									from " . TBL_LOGSTORY_REFERER_CATEGORYINFO . "
									where  depth in (2,3,4)
									order by paramorder desc"; //vparameter <> '' and
            $db->query($sql);
            //echo $sql."<br>";
            for ($i = 0; $i < $db->total; $i++) {
                $db->fetch($i);

                // 파라미터가 있는지 확인
                if ($db->dt['vparameter'] || $this_referer == "" || substr_count($this_referer, $this->fHTTP_HOST) > 0) {
                    // 현재 페이지 URL 에서 파라미터 검사

                    if ($this->SearchString($db->dt['vparameter'], $db->dt['cid'], $this_url) || $db->dt['vparameter'] == $this_referer) { // 해당 파라미터가 있을때
                        if ($db->dt['vparameter'] == "OVRAW") { // 파라미터가 OVRAW 이면 오버추어 분석
                            $this->OVER_TURE = true;
                        }
                        $this->PARAM_ANALISYS = true;
                        $this->SearchParam = $db->dt['vparameter'];
                        return $db->dt['cid']; // 레퍼러가 없을때는 파라미터가 검색된 유입사이트를 선택
                        exit;
                    }
                } else { // 레피러가 있을때
                    if ($this->SearchString(str_replace("*.", "", $db->dt['vreferer_url']), $db->dt['cid'], $this_referer)) {
                        //echo $db->dt['cid'];
                        if ($this->SearchString($db->dt['vkeyword'], $db->dt['cid'], $this_referer)) {
                            if ($db->dt['vparameter'] == "OVRAW") {
                                $this->OVER_TURE = true;
                            }
                            $this->PARAM_ANALISYS = false;
                            $this->SearchParam = $db->dt['vkeyword'];
                            //echo $db->dt['cid'];

                            return $db->dt['cid'];
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
                        return $db->dt['cid'];
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
        $HTTP_HOST = $_SERVER['HTTP_HOST'];
        
        $db = new Database();

        $db->query("select pageid from " . TBL_LOGSTORY_PAGEINFO . " where vurl = '" . strtolower($pageurl) . "'");

        if ($db->total > 0) {
            $db->fetch(0);
            $this->PageViewInsertByPage($db->dt['pageid']);
            setcookie("PAGEID", $db->dt['pageid'], time() + 180000, "/", $HTTP_HOST);
            return $db->dt['pageid'];
        } else {
            $sql = "insert into " . TBL_LOGSTORY_PAGEINFO . " (pageid,vurl,vdate) values ('','" . strtolower($pageurl) . "','" . $this->VisitDate . "') ";
            $db->query($sql);
            if ($db->dbms_type == "oracle") {
                $pageid = $db->last_insert_id;
            } else {
                $db->query("SELECT pageid FROM " . TBL_LOGSTORY_PAGEINFO . " WHERE pageid=LAST_INSERT_ID()");
                $db->fetch(0);
                $pageid = $db->dt[0];
            }
            $this->PageViewInsertByPage($pageid);
            setcookie("PAGEID", $db->dt['pageid'], time() + 180000, "/", $HTTP_HOST);
            return $db->dt['pageid'];
        }
    }

    function PageViewInsertByPage($page_id) {
        global $user;
        $db = new Database();

        $db->query("select pageid from " . TBL_LOGSTORY_BYPAGE . " where pageid = '$page_id' and vdate ='" . $this->VisitDate . "'");

        if ($db->total > 0) {
            $db->query("update " . TBL_LOGSTORY_BYPAGE . " set ncnt = ncnt+1, nduration = nduration + " . $this->DurationTime . " where pageid = '" . $page_id . "' and vdate ='" . $this->VisitDate . "'");
        } else {
            $db->query("insert into " . TBL_LOGSTORY_BYPAGE . " (vdate,pageid) values ('" . $this->VisitDate . "','" . $page_id . "') ");
        }
    }

    function InsertEtcReferer($vreferer_url) {

        $db = new Database();



        $db->query("select vetcreferer_id from " . TBL_LOGSTORY_ETCREFERERINFO . " where vetcreferer_url = '" . strtolower($vreferer_url) . "'");



        if ($db->total > 0) {
            $db->fetch(0);
            return $db->dt['vetcreferer_id'];
        } else {
            $sql = "insert into " . TBL_LOGSTORY_ETCREFERERINFO . " (vetcreferer_id,vetcreferer_url,vdate) values ('','" . strtolower($vreferer_url) . "','" . $this->VisitDate . "') ";
            $db->query($sql);

            if ($db->dbms_type == "oracle") {
                $vetcreferer_id = $db->last_insert_id;
            } else {
                $db->query("SELECT vetcreferer_id FROM " . TBL_LOGSTORY_ETCREFERERINFO . " WHERE vetcreferer_id=LAST_INSERT_ID()");
                $db->fetch(0);
                $vetcreferer_id = $db->dt['vetcreferer_id'];
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
        //echo $this->SearchParam;

        if ($this->SearchParam == "") {
            //echo "정지";
            return "";
            exit;
        }
        if ($this->PARAM_ANALISYS) {
            parse_str(urldecode($vrequest_uri), $myarray);
        } else {
            parse_str(urldecode($vreferer_url), $myarray);
        }

        //print_r($myarray);
        //echo $myarray[$this->SearchParam];

        $db = new Database();
        if ($this->debug) {
            echo "key word encoding type check before : " . $this->SearchParam . "<br><br>";
        }
        $db->debug = $this->debug;

        $encoding_type = mb_detect_encoding(urldecode($myarray[$this->SearchParam]));
        if ($encoding_type == "UTF-8") {
            if ($this->debug) {
                echo "encoding type UTF-8 <br><br>";
            }
            //$search_keyword = iconv('CP949','UTF-8',urldecode($myarray[$this->SearchParam]));
            $search_keyword = urldecode($myarray[$this->SearchParam]);

            if ($this->debug) {
                echo " search_keyword : " . $search_keyword . "<br><br>";
            }

            if ($search_keyword == "") {
                $search_keyword = urldecode($myarray[$this->SearchParam]);
            }
        } else {
            $search_keyword = iconv('CP949', 'UTF-8', urldecode($myarray[$this->SearchParam]));
            if ($search_keyword == "") {
                $search_keyword = urldecode($myarray[$this->SearchParam]);
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
                $kid = $db->dt['kid'];
            }
            return $kid;
        }
    }

}
