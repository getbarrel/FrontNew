<?php

/**
 * Description of Visit
 *
 * @author hoksi
 */
Class Visit {

    public $gData;

    function __construct() {
        $this->gData = "";
        //$this->debug = false;
    }

    function VisitCheck() {
        global $HTTP_HOST;

        //echo "test :". $_COOKIE["VID"];


        if (($_COOKIE["VID"] ?? '') == "" || $this->gData->debug) {

            setcookie("RFID", $this->gData->fRefererID, time() + 259200, "/", $this->gData->COOKIE_HOST);
            setcookie("VID", $this->gData->VISITID, time() + 1800, "/", $this->gData->COOKIE_HOST);

            //echo "VID : ".$this->gData->VISITID." :::".$_COOKIE["VID"];
            //echo $_COOKIE["VID"];
            //	exit;
            //echo "test :". $this->gData->VISITID ."::::".$this->gData->COOKIE_HOST;

            if (($_COOKIE["VISITORDATE"] ?? '')) {
                $this->ReVisitUpdate();
            }
            $this->VisitUpdate();
            if ($this->gData->fRefererID == "000004000000000") {
                //기타 URL 정보 입력하는곳..
                $this->RefererVisitUpdate((($_COOKIE["VISITORDATE"] ?? '') != $this->gData->VisitDate));
                $this->EtcRefererVisitUpdate((($_COOKIE["VISITORDATE"] ?? '') != $this->gData->VisitDate));
            } else {
                $this->RefererVisitUpdate((($_COOKIE["VISITORDATE"] ?? '') != $this->gData->VisitDate));
                if ($this->gData->SearchKeyWordId != "") {
                    setcookie("KWID", $this->gData->SearchKeyWordId, time() + 259200, "/", $this->gData->COOKIE_HOST); // 3일간 키워드 유지
                    $this->KeyWordUpdate(($_COOKIE["VISITORDATE"] != $this->gData->VisitDate));
                }
            }
        } else {
            //echo "test".$this->gData->COOKIE_HOST;
            setcookie("VID", $_COOKIE["VID"], time() + 1800, "/", $this->gData->COOKIE_HOST);
            setcookie("RFID", $_COOKIE["RFID"], time() + 259200, "/", $this->gData->COOKIE_HOST);
        }
    }

    function VisitUpdate() {
        $mData = $this->gData;
        $db = new forbizDatabase();

        $db->query("select vdate from " . TBL_LOGSTORY_VISITTIME . " where vdate = '" . $mData->VisitDate . "' and agent_type = '" . $mData->agent_type . "'  ");

        if ($db->total > 0) {
            $sql = "update " . TBL_LOGSTORY_VISITTIME . " set nh" . $mData->VisitTime . " = nh" . $mData->VisitTime . "+1, ncnt = ncnt+1 where vdate = '" . $mData->VisitDate . "' and agent_type = '" . $mData->agent_type . "'  ";
        } else {
            $sql = "insert into " . TBL_LOGSTORY_VISITTIME . " (vdate, agent_type ,nh" . $mData->VisitTime . ",ncnt) values ('" . $mData->VisitDate . "','" . $mData->agent_type . "',1,1) ";
        }
        $db->query($sql);
    }

    function ReVisitUpdate() {
        $mData = $this->gData;
        $db = new forbizDatabase();

        $db->query("select vdate from " . TBL_LOGSTORY_REVISITTIME . " where vdate = '" . $mData->VisitDate . "' and agent_type = '" . $mData->agent_type . "'  ");

        if ($db->total > 0) {
            $sql = "update " . TBL_LOGSTORY_REVISITTIME . " set nh" . $mData->VisitTime . " = nh" . $mData->VisitTime . "+1, ncnt = ncnt+1 where vdate = '" . $mData->VisitDate . "' and agent_type = '" . $mData->agent_type . "'  ";
        } else {
            $sql = "insert into " . TBL_LOGSTORY_REVISITTIME . " (vdate,agent_type,nh" . $mData->VisitTime . ",ncnt) values ('" . $mData->VisitDate . "','" . $mData->agent_type . "',1,1) ";
        }
        $db->query($sql);
    }

    function RefererVisitUpdate($bool_visitor) {
        $mData = $this->gData;
        $db = new forbizDatabase();
        $db->debug = $this->gData->debug;
        if ($this->gData->debug) {
            //echo "true";
        }

        if (trim($mData->fHTTP_REFERER) != "") {
            $aryURL = explode("?", $mData->fHTTP_REFERER);
            parse_str(($aryURL[1] ?? ''), $aryKeyword);
            //echo $mData->fRefererID;
            if ($mData->fRefererID != "000005000000000") {
                if (mb_detect_encoding(urldecode($aryKeyword[$mData->SearchParam])) == "UTF-8") {
                    $db->query("insert into " . TBL_LOGSTORY_REFERERURL . " (id,vdate,vreferer_id, vurl,keyword,kokeyword_decode, kokeyword, charset, ipaddr, regdate) values ('','" . $mData->VisitDate . "','" . $mData->fRefererID . "','" . $aryURL[0] . "','" . ($aryURL[1] ?? '') . "','" . urldecode($aryKeyword[$mData->SearchParam]) . "','" . iconv('CP949', 'UTF-8', urldecode($aryKeyword[$mData->SearchParam])) . "', '" . mb_detect_encoding(urldecode($aryKeyword[$mData->SearchParam])) . "',  '" . $mData->fREMOTE_ADDR . "', NOW()) ");
                } else {
                    $db->query("insert into " . TBL_LOGSTORY_REFERERURL . " (id,vdate,vreferer_id, vurl,keyword,kokeyword_decode, kokeyword, charset, ipaddr,  regdate) values ('','" . $mData->VisitDate . "','" . $mData->fRefererID . "','" . $aryURL[0] . "','" . ($aryURL[1] ?? '') . "','" . $mData->SearchParam . "::" . urldecode($aryKeyword[$mData->SearchParam]) . "','" . $mData->SearchParam . "::" . iconv('CP949', 'UTF-8', urldecode($aryKeyword[$mData->SearchParam])) . "', '" . mb_detect_encoding(urldecode($aryKeyword[$mData->SearchParam])) . "',  '" . $mData->fREMOTE_ADDR . "', NOW()) ");
                }
            }


            $db->query("select vdate from " . TBL_LOGSTORY_BYREFERER . " where vdate = '" . $mData->VisitDate . "' and vreferer_id ='" . $mData->fRefererID . "' ");

            //	$mystr = "test1=blah&test2=bleh&test1=burp";
            //	parse_str($mystr, $myarray);
            //	echo $myarray['test1'];


            if ($db->total > 0) {
                if ($bool_visitor) {
                    $sql = "update " . TBL_LOGSTORY_BYREFERER . " set visit_cnt = visit_cnt+1, visitor_cnt = visitor_cnt+1 where vdate = '" . $mData->VisitDate . "' and vreferer_id ='" . $mData->fRefererID . "' ";
                } else {
                    $sql = "update " . TBL_LOGSTORY_BYREFERER . " set visit_cnt = visit_cnt+1 where vdate = '" . $mData->VisitDate . "' and vreferer_id ='" . $mData->fRefererID . "' ";
                }
            } else {
                $sql = "insert into " . TBL_LOGSTORY_BYREFERER . " (vdate,vreferer_id,visit_cnt,visitor_cnt) values ('" . $mData->VisitDate . "','" . $mData->fRefererID . "',1,1) ";
            }
            $db->query($sql);
        }
    }

    function EtcRefererVisitUpdate($bool_visitor) {
        $mData = $this->gData;
        $db = new forbizDatabase();

        $sql = "insert into " . TBL_LOGSTORY_ETCHOST . " (idx,referer, etcuri,etchost) values ('','" . strtolower($mData->fHTTP_REFERER) . "','" . strtolower($mData->fREQUEST_URI) . "','" . strtolower($mData->fHTTP_HOST) . "') ";
        $db->query($sql);

        $db->query("select vdate from " . TBL_LOGSTORY_BYETCREFERER . " where vdate = '" . $mData->VisitDate . "' and vetcreferer_id ='" . $mData->fetcRefererID . "' ");

        if ($db->total > 0) {
            if ($bool_visitor) {
                $sql = "update " . TBL_LOGSTORY_BYETCREFERER . " set visit_cnt = visit_cnt+1, visitor_cnt = visitor_cnt+1 where vdate = '" . $mData->VisitDate . "' and vetcreferer_id ='" . $mData->fetcRefererID . "' ";
            } else {
                $sql = "update " . TBL_LOGSTORY_BYETCREFERER . " set visit_cnt = visit_cnt+1 where vdate = '" . $mData->VisitDate . "' and vetcreferer_id ='" . $mData->fetcRefererID . "' ";
            }
        } else {
            $sql = "insert into " . TBL_LOGSTORY_BYETCREFERER . " (vdate,vetcreferer_id,visit_cnt,visitor_cnt) values ('" . $mData->VisitDate . "','" . $mData->fetcRefererID . "',1,1) ";
        }
        $db->query($sql);
    }

    function KeyWordUpdate($bool_visitor) {
        $mData = $this->gData;
        $db = new forbizDatabase();

        $db->query("select vdate from " . TBL_LOGSTORY_BYKEYWORD . " where vdate = '" . $mData->VisitDate . "' and vreferer_id ='" . $mData->fRefererID . "' and kid = '" . $mData->SearchKeyWordId . "'");

        //	$mystr = "test1=blah&test2=bleh&test1=burp";
        //	parse_str($mystr, $myarray);
        //	echo $myarray['test1'];


        if ($db->total > 0) {
            if ($bool_visitor) {
                $sql = "update " . TBL_LOGSTORY_BYKEYWORD . " set nh" . $mData->VisitTime . " = nh" . $mData->VisitTime . "+1, visit_cnt = visit_cnt+1, visitor_cnt = visitor_cnt+1 where vdate = '" . $mData->VisitDate . "' and vreferer_id ='" . $mData->fRefererID . "' and kid = '" . $mData->SearchKeyWordId . "'";
            } else {
                $sql = "update " . TBL_LOGSTORY_BYKEYWORD . " set nh" . $mData->VisitTime . " = nh" . $mData->VisitTime . "+1, visit_cnt = visit_cnt+1 where vdate = '" . $mData->VisitDate . "' and vreferer_id ='" . $mData->fRefererID . "' and kid = '" . $mData->SearchKeyWordId . "'";
            }
        } else {
            $sql = "insert into " . TBL_LOGSTORY_BYKEYWORD . " (vdate,vreferer_id,kid,nh" . $mData->VisitTime . ",visit_cnt,visitor_cnt) values ('" . $mData->VisitDate . "','" . $mData->fRefererID . "','" . $mData->SearchKeyWordId . "',1,1,1) ";
        }
        $db->query($sql);
    }

}
