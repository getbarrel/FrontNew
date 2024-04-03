<?php

/**
 * Description of PageView
 *
 * @author hoksi
 */
Class PageView {

    public $gData;

    function __construct() {
        $this->gData = "";
    }

    function PageViewUpdate() {
        $mData = $this->gData;
        $db = new forbizDatabase();
        //echo "agent_type:".$mData->agent_type;
        $db->query("select vdate from " . TBL_LOGSTORY_PAGEVIEWTIME . " where vdate = '" . $mData->VisitDate . "' and agent_type = '" . $mData->agent_type . "' ");

        if ($db->total > 0) {
            $sql = "update " . TBL_LOGSTORY_PAGEVIEWTIME . " set nh" . $mData->VisitTime . " = nh" . $mData->VisitTime . "+1, ncnt = ncnt+1 where vdate = '" . $mData->VisitDate . "' and agent_type = '" . $mData->agent_type . "'   ";
        } else {
            $sql = "insert into " . TBL_LOGSTORY_PAGEVIEWTIME . " (vdate,agent_type, nh" . $mData->VisitTime . ",ncnt) values ('" . $mData->VisitDate . "','" . $mData->agent_type . "',1,1) ";
        }
        $db->query($sql);
    }

    function DurationUpdate() {
        $mData = $this->gData;
        $db = new forbizDatabase();

        $db->query("select vdate from " . TBL_LOGSTORY_DURATIONTIME . " where vdate = '" . $mData->VisitDate . "' and agent_type = '" . $mData->agent_type . "' ");

        if ($db->total > 0) {
            $sql = "update " . TBL_LOGSTORY_DURATIONTIME . " set nh" . $mData->VisitTime . " = nh" . $mData->VisitTime . "+" . $mData->DurationTime . ", nduration = nduration+" . $mData->DurationTime . " where vdate = '" . $mData->VisitDate . "' and agent_type = '" . $mData->agent_type . "' ";
        } else {
            $sql = "insert into " . TBL_LOGSTORY_DURATIONTIME . " (vdate,agent_type, nh" . $mData->VisitTime . ",nduration) values ('" . $mData->VisitDate . "','" . $mData->agent_type . "', " . $mData->DurationTime . "," . $mData->DurationTime . ") ";
        }
        $db->query($sql);
    }

    function MemberDurationUpdate($mem_ix) {
        $mData = $this->gData;
        $db = new forbizDatabase();
        //$db->debug = true;
        $db->query("select vdate from logstory_duration_history where vdate = '" . $mData->VisitDate . "' and mem_ix = '" . $mem_ix . "' ");

        if ($db->total > 0) {
            $sql = "update logstory_duration_history set nh" . $mData->VisitTime . " = nh" . $mData->VisitTime . "+" . $mData->DurationTime . ", nduration = nduration+" . $mData->DurationTime . " where vdate = '" . $mData->VisitDate . "' and mem_ix = '" . $mem_ix . "' ";
        } else {
            $sql = "insert into logstory_duration_history (vdate,mem_ix, nh" . $mData->VisitTime . ",nduration) values ('" . $mData->VisitDate . "','" . $mem_ix . "'," . $mData->DurationTime . "," . $mData->DurationTime . ") ";
        }
        $db->query($sql);
    }

}
