<?php

/**
 * Description of Commerce
 *
 * @author hoksi
 */
Class Commerce {

    public $gData;
    public $agent_type = "W";

    function __construct() {
        $this->gData = "";
    }

    function SaleInfoUpdate($vucode, $vStep, $vcid, $vpid, $vquantity, $vprice) {
        $mData = $this->gData;
        $db = new ForbizMySQLi();
        //$db->debug = true;
        $db->query("select ucode, step_wish, step1, step2, step3, step4, step5,step6, vprice from " . TBL_COMMERCE_SALESTACK . " where vdate = '" . $mData->VisitDate . "' and cid ='$vcid' and pid ='$vpid' and visitid ='" . ($_COOKIE["VID"] ?? '') . "'");

        if ($db->total > 0) {
            $db->fetch(0);
            if ($db->dt[ucode] == "" && $vucode != "") {
                if ($vStep == "wish") {
                    $sql = "update " . TBL_COMMERCE_SALESTACK . " set 
								agent_type='" . $this->agent_type . "', step_wish = '1', ucode ='" . $vucode . "' , vquantity = '$vquantity', vsale = " . $vquantity . "*vprice 
								where vdate = '" . $mData->VisitDate . "' and cid ='$vcid' and pid ='$vpid' and visitid ='" . $_COOKIE["VID"] . "'";
                } else {
                    $sql = "update " . TBL_COMMERCE_SALESTACK . " set 
								agent_type='" . $this->agent_type . "', step" . $vStep . " = 1, ucode ='" . $vucode . "' , vquantity = '$vquantity', vsale = " . $vquantity . "*vprice 
								where vdate = '" . $mData->VisitDate . "' and cid ='$vcid' and pid ='$vpid' and visitid ='" . $_COOKIE["VID"] . "'";
                }
                $db->query($sql);
            } else {
                if ($vStep == "wish") {
                    if ($db->dt["step_wish"] == '0') {
                        $sql = "update " . TBL_COMMERCE_SALESTACK . " set 
										agent_type='" . $this->agent_type . "', step_wish = 1 , vquantity = '$vquantity', vsale = " . $vquantity . "*vprice 
										where vdate = '" . $mData->VisitDate . "' and cid ='$vcid' and pid ='$vpid' and visitid ='" . $_COOKIE["VID"] . "'";
                        $db->query($sql);
                    }
                } else {
                    if ($db->dt["step$vStep"] == '0') {
                        if ($vprice > 0 && $db->dt["vprice"] == 0) {
                            $sql = "update " . TBL_COMMERCE_SALESTACK . " set 
										agent_type='" . $this->agent_type . "', step" . $vStep . " = 1 , vquantity = '$vquantity', vsale = " . $vquantity . "*" . $vprice . " , vprice = '" . $vprice . "' 
										where vdate = '" . $mData->VisitDate . "' and cid ='$vcid' and pid ='$vpid' and visitid ='" . $_COOKIE["VID"] . "'";
                        } else {
                            $sql = "update " . TBL_COMMERCE_SALESTACK . " set 
										agent_type='" . $this->agent_type . "', step" . $vStep . " = 1 , vquantity = '$vquantity', vsale = " . $vquantity . "*vprice 
										where vdate = '" . $mData->VisitDate . "' and cid ='$vcid' and pid ='$vpid' and visitid ='" . $_COOKIE["VID"] . "'";
                        }
                        $db->query($sql);
                    }
                }

                if ($vStep == 6) {
                    if ($vucode) {
                        $sql = "update  " . TBL_COMMERCE_VIEWINGVIEW . " set is_order = 1 where ucode = '" . $vucode . "' and pid = '" . $vpid . "' and vdate <= '" . $mData->VisitDate . "'  ";
                        $db->query($sql);

                        $sql = "update  " . TBL_COMMERCE_SALESTACK . " set is_order = 1 where ucode = '" . $vucode . "' and pid = '" . $vpid . "' and vdate <= '" . $mData->VisitDate . "'  ";
                        $db->query($sql);
                    }
                }
            }
        } else {
            $db->sequences = "COMMERCE_SALESTACK_SEQ";

            if ($vStep == "wish") {
                $db->query("insert into " . TBL_COMMERCE_SALESTACK . " (id,vdate,vtime,visitid, vreferer_id,kid, ucode,cid,pid,agent_type, step_wish,vquantity,vprice,vsale) values ('','" . $mData->VisitDate . "','" . $mData->VisitTime . "','" . $mData->VISITID . "','" . $mData->fRefererID . "','" . $mData->KID . "','" . $vucode . "','$vcid','$vpid','" . $this->agent_type . "','1','$vquantity','$vprice','" . ($vquantity * $vprice) . "')");
            } else {
                $db->query("insert into " . TBL_COMMERCE_SALESTACK . " (id,vdate,vtime,visitid, vreferer_id,kid, ucode,cid,pid,agent_type, step" . $vStep . ",vquantity,vprice,vsale) values ('','" . $mData->VisitDate . "','" . $mData->VisitTime . "','" . $mData->VISITID . "','" . $mData->fRefererID . "','" . $mData->KID . "','" . $vucode . "','$vcid','$vpid','" . $this->agent_type . "','1','$vquantity','$vprice','" . ($vquantity * $vprice) . "')");
            }
        }
    }

    function ProductViewingUpdate($vcid, $vpid, $ucode = "") {
        $mData = $this->gData;
        $db = new forbizDatabase();
        //$db->debug = true;
        $db->query("select vdate, ucode from " . TBL_COMMERCE_VIEWINGVIEW . " where vdate = '" . $mData->VisitDate . "' and visitid = '" . $mData->VISITID . "' and cid ='$vcid' and pid ='$vpid' and agent_type='" . $this->agent_type . "' ");

        if ($db->total > 0) {
            if ($ucode != "") {
                $db->query("update " . TBL_COMMERCE_VIEWINGVIEW . " set ucode ='$ucode' where vdate = '" . $mData->VisitDate . "' and visitid = '" . $mData->VISITID . "'");
            }
            $db->query("update " . TBL_COMMERCE_VIEWINGVIEW . " set nview_cnt = nview_cnt+1 where vdate = '" . $mData->VisitDate . "' and cid ='$vcid' and pid ='$vpid' and visitid = '" . $mData->VISITID . "'");
        } else {
            $db->query("insert into " . TBL_COMMERCE_VIEWINGVIEW . " (vdate,vreferer_id,kid, visitid,ucode, cid,pid,agent_type, nview_cnt) values ('" . $mData->VisitDate . "','" . $mData->fRefererID . "','" . $mData->KID . "','" . $mData->VISITID . "','$ucode','$vcid','$vpid','" . $this->agent_type . "','1')");
        }
    }

    function SalesStepUpdate($vcid, $vpid, $ucode, $stepnumber, $vquantity, $vprice, $vsale) {
        $mData = $this->gData;
        $db = new forbizDatabase();

        $db->query("select vdate from " . TBL_COMMERCE_SALESTACK . " where vdate = '" . $mData->VisitDate . "' and visitid = '" . $mData->VISITID . "' and cid ='$vcid' and pid ='$vpid'");

        if ($db->total > 0) {
            if ($ucode != "") {
                $db->query("update " . TBL_COMMERCE_SALESTACK . " set ucode = '$ucode' where vdate = '" . $mData->VisitDate . "' and visitid = '" . $mData->VISITID . "' ");
            }
            $db->query("update " . TBL_COMMERCE_SALESTACK . " set step$stepnumber = 1, vquantity = '$vquantity', vsale = " . $vquantity . "*vprice where vdate = '" . $mData->VisitDate . "' and visitid = '" . $mData->VISITID . "' and cid ='$vcid' and pid ='$vpid' ");
        } else {
            $db->sequences = "COMMERCE_SALESTACK_SEQ";
            $db->query("insert into " . TBL_COMMERCE_SALESTACK . " (id,vdate,vtime, visitid, vreferer_id, kid, ucode, cid,pid, step" . $stepnumber . ", vquantity, vprice,vsale) values ('','" . $mData->VisitDate . "','" . $mData->VisitTime . "','" . $mData->VISITID . "','" . $mData->fRefererID . "','" . $mData->KID . "','" . $vucode . "','$vcid','$vpid','1','$vquantity','$vprice','" . ($vquantity * $vprice) . "')");
        }
    }

    function PromotionLogic($event_ix) {
        $mData = $this->gData;
        $db = new forbizDatabase();

        if ($mData->VisitTime) {
            $db->query("select vdate from logstory_event_click where vdate = '" . $mData->VisitDate . "' and event_ix = '" . $event_ix . "' ");

            if ($db->total > 0) {
                $sql = "update logstory_event_click set nh" . $mData->VisitTime . " = nh" . $mData->VisitTime . "+1, ncnt = ncnt+1 where vdate = '" . $mData->VisitDate . "' and event_ix = '" . $event_ix . "' ";
            } else {
                $sql = "insert into logstory_event_click (vdate,event_ix, nh" . $mData->VisitTime . ",ncnt) values ('" . $mData->VisitDate . "','" . $event_ix . "',1,1) ";
            }
            $db->query($sql);
        }
    }

}
