<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Visitor
 *
 * @author hoksi
 */
Class Visitor {

    public $gData;

    function __construct() {
        $this->gData = "";
    }

    function VisitorCheck() {

        $vistordate = $_COOKIE["VISITORDATE"] ?? '';
        
        if ($vistordate == "" || (($vistordate != "") && ($vistordate != date("Ymd"))) || $this->gData->debug) {
            setcookie("VISITORDATE", $this->gData->VisitDate, time() + 2592000, "/", $this->gData->COOKIE_HOST);
            setcookie("UVID", $this->gData->VISITORID, time() + 2592000, "/", $this->gData->COOKIE_HOST);

            //echo $_COOKIE["UVID"];
            if (($_COOKIE["VID"] ?? '') == "") {
                $this->VisitorUpdate();
            }
        }
    }

    function VisitorUpdate() {
        $mData = $this->gData;
        $db = new forbizDatabase();
        $db->debug = $this->gData->debug;
        $db->query("select vdate from " . TBL_LOGSTORY_VISITOR . " where vdate = '" . $mData->VisitDate . "' and agent_type = '" . $mData->agent_type . "'  ");

        if ($db->total > 0) {
            $sql = "update " . TBL_LOGSTORY_VISITOR . " set nh" . $mData->VisitTime . " = nh" . $mData->VisitTime . "+1, ncnt = ncnt+1 where vdate = '" . $mData->VisitDate . "' and agent_type = '" . $mData->agent_type . "'  ";
        } else {
            $sql = "insert into " . TBL_LOGSTORY_VISITOR . " (vdate, agent_type ,nh" . $mData->VisitTime . ",ncnt) values ('" . $mData->VisitDate . "','" . $mData->agent_type . "', 1,1) ";
        }
        $db->query($sql);

        if ($mData->VISITORID) {
            $db->query("select vdate from " . TBL_LOGSTORY_VISITORINFO . " where vdate = '" . $mData->VisitDate . "' and agent_type = '" . $mData->agent_type . "'  and ip_addr ='" . $mData->fREMOTE_ADDR . "'   "); //and uvid = '".$mData->VISITORID."'
        } else {
            $db->query("select vdate from " . TBL_LOGSTORY_VISITORINFO . " where vdate = '" . $mData->VisitDate . "' and agent_type = '" . $mData->agent_type . "'  and ip_addr ='" . $mData->fREMOTE_ADDR . "' "); //and uvid = '".$mData->VISITORID."' 
        }

        if ($db->total > 0) {
            $sql = "update " . TBL_LOGSTORY_VISITORINFO . " set  visit_cnt = visit_cnt+1, visit_etc_info = '" . ($_COOKIE["VISITORDATE"] ?? '') . "," . ($_COOKIE["PHPSESSID"] ?? '') . "," . ($_COOKIE["VID"] ?? '') . "' where vdate = '" . $mData->VisitDate . "' and ip_addr ='" . $mData->fREMOTE_ADDR . "' and agent_type = '" . $mData->agent_type . "'  ";
        } else {
            $sql = "insert into " . TBL_LOGSTORY_VISITORINFO . " 
						(vdate,agent_type, uvid, ip_addr,user_agent, vreferer_id, kid, visit_cnt, cpc_yn, visit_etc_info2, regdate) 
						values 
						('" . $mData->VisitDate . "','" . $mData->agent_type . "', '" . $mData->VISITORID . "','" . $mData->fREMOTE_ADDR . "','" . $mData->fHTTP_USER_AGENT . "','" . $mData->fRefererID . "','" . $mData->KID . "',1, '" . ($mData->OVER_TURE ? "1" : "0") . "','" . cook_val("VISITORDATE") . "," .cook_val("PHPSESSID") . "," .cook_val("VID") . "," .cook_val("LAST_CON_TIME") . "', NOW()) ";
        }

        $db->query($sql);
    }

    function RefererVisitUpdate($bool_visitor) {
        $mData = $this->gData;
        $db = new forbizDatabase();
        $db->debug = $this->gData->debug;
        //echo "test";

        $db->query("select vdate from " . TBL_LOGSTORY_BYREFERER . " where vdate = '" . $mData->VisitDate . "'");

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
