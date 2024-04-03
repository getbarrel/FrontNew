<?php

/**
 * Description of MemberReg
 *
 * @author hoksi
 */
Class MemberReg {

    public $gData;
    public $agent_type = "W";

    function __construct() {
        $this->gData = "";
    }

    function MemberInfoUpdate($vucode, $vStep) {
        $mData = $this->gData;
        $db = new forbizDatabase();

        $db->query("select ucode, step1, step2, step3, step4, step5,step6 from " . TBL_LOGSTORY_MEMBERREG_STACK . " where vdate = '" . $mData->VisitDate . "'  and visitid ='" . ($_COOKIE["VID"] ?? '') . "'");

        if ($db->total > 0) {
            $db->fetch(0);
            if ($db->dt['ucode'] == "" && $vucode != "") {
                $db->query("update " . TBL_LOGSTORY_MEMBERREG_STACK . " set step" . $vStep . " = 1, ucode ='" . $vucode . "', agent_type = '" . $this->agent_type . "' where vdate = '" . $mData->VisitDate . "' and visitid ='" . ($_COOKIE["VID"] ?? '') . "'");
            } else {
                if ($db->dt["step$vStep"] == 0) {
                    $db->query("update " . TBL_LOGSTORY_MEMBERREG_STACK . " set step" . $vStep . " = 1, agent_type = '" . $this->agent_type . "'  where vdate = '" . $mData->VisitDate . "' and visitid ='" . ($_COOKIE["VID"] ?? '') . "'");
                }
            }
        } else {
            $db->sequences = "LOGSTORY_MEMBERREG_STACK_SEQ";
            $db->query("insert into " . TBL_LOGSTORY_MEMBERREG_STACK . " (id, vdate,vtime,visitid, vreferer_id,ucode,step" . $vStep . ") values ('','" . $mData->VisitDate . "','" . $mData->VisitTime . "','" . ($_COOKIE["VID"] ?? '') . "','" . $mData->fRefererID . "','" . $vucode . "','1')");
        }
    }

    function MemberLoginUpdate($mem_ix) {
        $mData = $this->gData;
        $db = new forbizDatabase();

        if ($mData->VisitTime) {
            $db->query("select vdate from logstory_login_history where vdate = '" . $mData->VisitDate . "' and mem_ix = '" . $mem_ix . "' ");

            if ($db->total > 0) {
                $sql = "update logstory_login_history set nh" . $mData->VisitTime . " = nh" . $mData->VisitTime . "+1, ncnt = ncnt+1 where vdate = '" . $mData->VisitDate . "' and mem_ix = '" . $mem_ix . "' ";
            } else {
                $sql = "insert into logstory_login_history (vdate,mem_ix, nh" . $mData->VisitTime . ",ncnt) values ('" . $mData->VisitDate . "','" . $mem_ix . "',1,1) ";
            }
            $db->query($sql);
        }
    }

}
