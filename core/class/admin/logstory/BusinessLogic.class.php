<?php

/**
 * Description of businessLogin
 *
 * @author hoksi
 */
Class BusinessLogic {

    public $gData;
    public $robot_bool = false;
    public $agent_type = "W";

    function __construct() {
        global $REMOTE_ADDR;
        // 로봇으로 추정되는 IP ADDRESS 를 통계에서만 차단한다 
        //if(false){
        //$block_ip_addrss = array ("203.241.147.24", "114.111.36.29", "72.30.65.54","58.230.114.109","125.132.238.31","114.111.36.24","114.111.36.30","220.72.139.141", "38.99.13.122", "124.62.114.100", "124.54.89.110", "125.177.218.102", "219.251.74.156", "124.199.189.204", "211.177.248.244", "121.178.234.85", "66.249.67.22", "118.217.181.188", "195.56.172.205","74.6.19.115","74.6.28.103","202.179.180.46","202.179.180.44","64.81.243.165","66.249.72.3", "61.247.221.41", "61.247.221.42", "61.247.221.48", "61.247.221.50", "61.247.221.44", "61.247.221.43", "61.247.221.49", "61.247.221.47", "61.247.221.45", "61.247.221.46","83.45.33.110","66.249.66.15","61.74.99.177");

        $block_ip_addrss[0] = "203.241.147.24";
        $block_ip_addrss[1] = "114.111.36.29";
        $block_ip_addrss[2] = "72.30.65.54";
        $block_ip_addrss[3] = "58.230.114.109";
        $block_ip_addrss[4] = "125.132.238.31";
        $block_ip_addrss[5] = "114.111.36.24";
        $block_ip_addrss[6] = "114.111.36.30";
        $block_ip_addrss[7] = "220.72.139.141";
        $block_ip_addrss[8] = "38.99.13.122";
        $block_ip_addrss[9] = "124.62.114.100";
        $block_ip_addrss[10] = "124.54.89.110";
        $block_ip_addrss[11] = "125.177.218.102";
        $block_ip_addrss[12] = "219.251.74.156";
        $block_ip_addrss[13] = "124.199.189.204";
        $block_ip_addrss[14] = "211.177.248.244";
        $block_ip_addrss[15] = "121.178.234.85";
        $block_ip_addrss[16] = "66.249.67.22";
        $block_ip_addrss[17] = "118.217.181.188";
        $block_ip_addrss[18] = "195.56.172.205";
        $block_ip_addrss[19] = "74.6.19.115";
        $block_ip_addrss[20] = "74.6.28.103";
        $block_ip_addrss[21] = "202.179.180.46";
        $block_ip_addrss[22] = "202.179.180.44";
        $block_ip_addrss[23] = "64.81.243.165";
        $block_ip_addrss[24] = "66.249.72.3";
        $block_ip_addrss[25] = "116.41.233.167";
        $block_ip_addrss[26] = "119.64.237.3";
        $block_ip_addrss[27] = "124.199.34.167";
        $block_ip_addrss[28] = "123.109.48.170";
        $block_ip_addrss[29] = "211.51.145.193";
        $block_ip_addrss[30] = "203.236.3.225";
        $block_ip_addrss[31] = "124.51.121.109";
        $block_ip_addrss[32] = "122.128.65.168";
        $block_ip_addrss[33] = "220.125.145.11";
        $block_ip_addrss[34] = "210.94.41.89";
        $block_ip_addrss[35] = "83.45.33.110";
        $block_ip_addrss[36] = "66.249.66.15";
        $block_ip_addrss[37] = "61.74.99.177";
        $block_ip_addrss[38] = "220.86.67.89";
        $block_ip_addrss[39] = "211.186.2.13";
        $block_ip_addrss[40] = "211.252.150.118";
        $block_ip_addrss[41] = "61.80.177.253";
        $block_ip_addrss[42] = "121.188.165.33";
        $block_ip_addrss[43] = "222.108.135.87";
        $block_ip_addrss[44] = "125.137.1.174";
        $block_ip_addrss[45] = "211.117.22.57";
        $block_ip_addrss[46] = "125.190.243.31";
        $block_ip_addrss[47] = "121.168.188.208";
        $block_ip_addrss[48] = "125.128.122.29";
        $block_ip_addrss[49] = "115.95.60.93";
        $block_ip_addrss[50] = "58.125.115.236";
        $block_ip_addrss[51] = "211.224.145.16";
        $block_ip_addrss[52] = "211.209.206.101";
        $block_ip_addrss[53] = "221.138.207.227";
        $block_ip_addrss[54] = "193.75.59.64";
        $block_ip_addrss[55] = "63.80.233.248";
        $block_ip_addrss[56] = "xxx"; //59.10.117.150
        $block_ip_addrss[57] = "116.124.36.105";
        $block_ip_addrss[58] = "119.205.143.137";
        $block_ip_addrss[59] = "58.236.148.227";
        $block_ip_addrss[60] = "218.37.195.145";
        $block_ip_addrss[61] = "218.39.53.187";
        $block_ip_addrss[62] = "211.176.86.173";
        $block_ip_addrss[63] = "63.80.56.41";
        $block_ip_addrss[64] = "220.74.18.152";
        $block_ip_addrss[65] = "203.252.103.59";
        $block_ip_addrss[66] = "125.189.14.57";
        $block_ip_addrss[67] = "219.250.21.194";
        $block_ip_addrss[68] = "::1";
        $block_ip_addrss[69] = "xxx"; //59.10.117.150
        $block_ip_addrss[70] = "217.14.4.197";
        $block_ip_addrss[71] = "85.23.67.140";
        $block_ip_addrss[72] = "121.142.5.35";
        $block_ip_addrss[73] = "218.37.12.26";
        $block_ip_addrss[74] = "58.228.162.115";
        $block_ip_addrss[75] = "121.144.164.86";
        $block_ip_addrss[76] = "121.153.138.165";
        $block_ip_addrss[77] = "218.39.20.137";
        $block_ip_addrss[78] = "219.254.196.202";
        $block_ip_addrss[79] = "116.125.7.72";
        $block_ip_addrss[80] = "58.238.215.158";
        $block_ip_addrss[81] = "121.157.192.165";
        $block_ip_addrss[82] = "221.157.243.135";
        $block_ip_addrss[83] = "222.235.13.106";
        $block_ip_addrss[84] = "121.191.170.144";
        $block_ip_addrss[85] = "118.219.242.220";
        $block_ip_addrss[86] = "118.33.197.127";
        $block_ip_addrss[87] = "121.143.168.56";
        $block_ip_addrss[88] = "218.37.72.90";
        $block_ip_addrss[89] = "218.37.72.90";
        $block_ip_addrss[90] = "119.71.2.59";
        $block_ip_addrss[91] = "121.167.82.242";
        $block_ip_addrss[92] = "211.200.149.43";
        $block_ip_addrss[93] = "116.40.163.147";
        $block_ip_addrss[94] = "125.181.148.86";
        $block_ip_addrss[95] = "59.0.180.20";
        $block_ip_addrss[96] = "211.210.96.185";
        $block_ip_addrss[97] = "222.238.124.217";
        $block_ip_addrss[98] = "121.139.58.249";
        $block_ip_addrss[99] = "218.234.118.48";
        $block_ip_addrss[100] = "124.49.98.115";
        $block_ip_addrss[101] = "220.126.254.174";
        $block_ip_addrss[102] = "220.85.133.199";
        $block_ip_addrss[103] = "124.80.159.207";
        $block_ip_addrss[104] = "211.172.214.224";
        $block_ip_addrss[105] = "116.32.10.18";
        $block_ip_addrss[106] = "124.54.212.132";
        $block_ip_addrss[107] = "125.143.161.71";


        if (substr_count(strtolower($_SERVER["HTTP_USER_AGENT"]), "bot") == 0 && substr_count(strtolower($_SERVER["HTTP_USER_AGENT"]), "ws.daum.net") == 0 && $_SERVER["HTTP_USER_AGENT"] != "") {
            if (!in_array($REMOTE_ADDR, $block_ip_addrss) && !substr_count($REMOTE_ADDR, "74.6.") && !substr_count($REMOTE_ADDR, "61.247.221.") && !substr_count($REMOTE_ADDR, "66.247.221.") && !substr_count($REMOTE_ADDR, "66.249.71.") && !substr_count($REMOTE_ADDR, "66.249.73.") && !substr_count($REMOTE_ADDR, "78.159.112.")) {

                $this->robot_bool = true;
                $fg = new forbizGather();
                $this->gData = $fg;

                /* 		
                  $vs = new visit();
                  $vs->gData = $fg;
                  $vs->VisitCheck();



                  $vst = new visitor();
                  $vst->gData = $fg;
                  $vst->VisitorCheck();

                  $pv = new PageView();
                  $pv->gData = $fg;
                  $pv->PageViewUpdate();
                  $pv->DurationUpdate();
                 */
            } else {
                $this->robot_bool = true;
                $fg = new forbizGather();
                $this->gData = $fg;
            }
        }
    }

    function CommerceLogic($vucode, $vStep, $vcid, $vpid, $vquantity, $vprice) {
        //if ($this->robot_bool) {		
        $cmc = new Commerce();
        $cmc->gData = $this->gData;
        $cmc->agent_type = $this->agent_type;
        //echo "vStep:".$vStep."<br>";
        if ($vStep == "0") {
            //echo "vStep=0<br>";
            $cmc->ProductViewingUpdate($vcid, $vpid, $vucode);
        } else {// || $vStep != "wish"
            //echo "vStep=아닌것<br>";
            $cmc->SaleInfoUpdate($vucode, $vStep, $vcid, $vpid, $vquantity, $vprice);
        }
        //}
    }

    function MemberRegLogic($vucode, $vStep) {
        $mrg = new MemberReg();
        $mrg->gData = $this->gData;
        $mrg->agent_type = $this->agent_type;

        $mrg->MemberInfoUpdate($vucode, $vStep);
    }

    function MemberLoginUpdate($mem_ix) {
        $mrg = new MemberReg();
        $mrg->gData = $this->gData;

        $mrg->MemberLoginUpdate($mem_ix);
    }

    function PromotionLogic($event_ix) {
        $cmc = new Commerce();
        $cmc->gData = $this->gData;

        $cmc->PromotionLogic($event_ix);
    }

}
