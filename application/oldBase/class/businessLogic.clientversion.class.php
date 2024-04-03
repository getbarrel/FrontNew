<?php
require_once(OLDBASE_ROOT . "/class/gather.clientversion.class.php");


Class BusinessLogic
{
    var $gData;
    var $robot_bool = false;

    function __construct($fg, $cdb)
    {
        global $REMOTE_ADDR;
        // 로봇으로 추정되는 IP ADDRESS 를 통계에서만 차단한다

        if (!$fg) {
            $this->robot_bool = true;
            $fg = new forbizGather();
        }
        $this->gData = $fg;


        $vs = new visit();
        $vs->gData = $fg;
        $vs->VisitCheck();
        //print_r($fg);


        $vst = new visitor();
        $vst->gData = $fg;
        $vst->VisitorCheck();

        $pv = new PageView();
        $pv->gData = $fg;
        $pv->PageViewUpdate();
        $pv->DurationUpdate();
        if ($fg->UCODE) {
            $pv->MemberDurationUpdate($fg->UCODE);
        }


    }

    function CommerceLogic($vucode, $vStep, $vcid, $vpid, $vquantity, $vprice)
    {
        if ($this->robot_bool) {
            $cmc = new Commerce();
            $cmc->gData = $this->gData;


            if ($vStep == 0) {
                $cmc->ProductViewingUpdate($vcid, $vpid, $vucode);
            } else {
                $cmc->SaleInfoUpdate($vucode, $vStep, $vcid, $vpid, $vquantity, $vprice);

            }
        }
    }

    function MemberRegLogic($vucode, $vStep)
    {
        $mrg = new MemberReg();
        $mrg->gData = $this->gData;

        $mrg->MemberInfoUpdate($vucode, $vStep);

    }


}