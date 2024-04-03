<?php
defined('USE_COLLECT') OR exit('No direct script access allowed');
defined('FORBIZ_BASEURL') OR exit('No direct script access allowed(FORBIZ_BASEURL)');

/**
 * CollectReport 클래스
 * 수집 정보 보고서 작성
 *
 * @author hoksi
 */
class CollectReport
{
    protected $_cookie_data;
    protected $_session_data;
    protected $_get_data;
    protected $_collect_data;
    protected $db;

    public function __construct($collectData = false)
    {
        $this->db = get_collect_db();

        if ($collectData) {
            $this->setCollectData($collectData);
        }
    }

    /**
     * 수집정보 설정
     * @param array $collectData
     * @return $this
     */
    public function setCollectData($collectData)
    {
        if (!empty($collectData)) {
            $this->_cookie_data  = ($collectData['cookie'] ?? []);
            $this->_session_data = ($collectData['session'] ?? []);
            $this->_get_data     = ($collectData['get'] ?? []);
            $this->_collect_data = ($collectData['collect'] ?? []);
        }

        return $this;
    }

    /**
     * 쿠키 값을 가져온다.
     * @param string $keys
     * @return mixed
     */
    public function getCookie(string ...$keys)
    {
        return $this->getBaseData($this->_cookie_data, $keys);
    }

    /**
     * 세션 값을 가져온다.
     * @param string $keys
     * @return mixed
     */
    public function getSession(string ...$keys)
    {
        return $this->getBaseData($this->_session_data, $keys);
    }

    /**
     * GET 값을 가져온다.
     * @param string $keys
     * @return mixed
     */
    public function getGet(string ...$keys)
    {
        return $this->getBaseData($this->_get_data, $keys);
    }

    public function get($key = false)
    {
        if ($key) {
            return ($this->_collect_data[$key] ?? '');
        } else {
            return $this->_collect_data;
        }
    }

    /**
     * 통계 보고서 작성
     * @return array
     */
    public function writeReport()
    {
        // 재방문?
        if ($this->get('reVisitUpdate') === true) {
            // yes
            $this->reVisitUpdate();
        }
        // 방문 보고서 작성
        $this->visitUpdate();
        // referer 보고서 작성
        $this->refererVisitUpdate();

        if ($this->get('fRefererID') == '000004000000000') {
            // 기타 referer 방문 보고서 작성
            $this->etcRefererVisitUpdate();
        } else {
            if ($this->get('SearchKeyWordId')) {
                // 키워드 보고서 작성
                $this->keyWordUpdate();
            }
        }

        // 처음 방문자인가?
        if ($this->getCookie('VID') == '') {
            $this->visitorUpdate();
        }

        // 페이지별 보고서 작성
        $this->pageViewByPageUpdate();
        // 페이지뷰 보고서 작성
        $this->pageViewUpdate();

        // 체류시간 보고서 작성
        $this->durationUpdate();

        if ($this->get('UCODE')) {
            $this->memberDurationUpdate();
        }

        return [
            'cookie' => $this->_cookie_data
            , 'session' => $this->_session_data
            , 'get' => $this->_get_data
            , 'collect' => $this->_collect_data
        ];
    }

    /**
     * 재방문 보고서 작성
     */
    protected function reVisitUpdate()
    {
        $this->db->query("select vdate from ".TBL_LOGSTORY_REVISITTIME." where vdate = '".$this->get('VisitDate')."' and agent_type = '".$this->get('agent_type')."'  ");

        if ($this->db->total > 0) {
            $sql = "update ".TBL_LOGSTORY_REVISITTIME." set nh".$this->get('VisitTime')." = nh".$this->get('VisitTime')."+1, ncnt = ncnt+1 where vdate = '".$this->get('VisitDate')."' and agent_type = '".$this->get('agent_type')."'  ";
        } else {
            $sql = "insert into ".TBL_LOGSTORY_REVISITTIME." (vdate,agent_type,nh".$this->get('VisitTime').",ncnt) values ('".$this->get('VisitDate')."','".$this->get('agent_type')."',1,1) ";
        }
        $this->db->query($sql);
    }

    /**
     * 방문 보고서 작성
     */
    protected function visitUpdate()
    {
        $this->db->query("select vdate from ".TBL_LOGSTORY_VISITTIME." where vdate = '".$this->get('VisitDate')."' and agent_type = '".$this->get('agent_type')."'  ");

        if ($this->db->total > 0) {
            $sql = "update ".TBL_LOGSTORY_VISITTIME." set nh".$this->get('VisitTime')." = nh".$this->get('VisitTime')."+1, ncnt = ncnt+1 where vdate = '".$this->get('VisitDate')."' and agent_type = '".$this->get('agent_type')."'  ";
        } else {
            $sql = "insert into ".TBL_LOGSTORY_VISITTIME." (vdate, agent_type ,nh".$this->get('VisitTime').",ncnt) values ('".$this->get('VisitDate')."','".$this->get('agent_type')."',1,1) ";
        }
        $this->db->query($sql);
    }

    /**
     * 방문자 referer 로그 및 보고서 작성
     */
    protected function refererVisitUpdate()
    {
        $bool_visitor = $this->getBoolVisitor();
        $referer      = trim($this->get('fHTTP_REFERER'));

        if ($referer != "") {
            $aryURL       = explode("?", $referer);
            parse_str(($aryURL[1] ?? ''), $aryKeyword);
            $sKeyWord     = urldecode(($aryKeyword[$this->get('SearchParam')] ?? ''));
            $shKeyWordEnc = mb_detect_encoding($sKeyWord);

            if ($this->get('fRefererID') != "000005000000000") {
                if ($shKeyWordEnc == "UTF-8") {
                    $kokeyword_decode = $sKeyWord;
                    $kokeyword        = $sKeyWord;
                } else {
                    $kokeyword_decode = $this->get('SearchParam')."::".$sKeyWord;
                    $kokeyword        = $this->get('SearchParam')."::".iconv($shKeyWordEnc, 'UTF-8', $sKeyWord);
                }

                $this->db->query("insert into ".TBL_LOGSTORY_REFERERURL." (id,vdate,vreferer_id, vurl,keyword,kokeyword_decode, kokeyword, charset, ipaddr, regdate) values (".
                    "'','".
                    $this->get('VisitDate').
                    "','".
                    $this->get('fRefererID').
                    "','".
                    $aryURL[0].
                    "','".
                    ($aryURL[1] ?? '').
                    "','".
                    $this->get('SearchParam')."::".urldecode($sKeyWord).
                    "','".
                    $this->get('SearchParam')."::".iconv('CP949', 'UTF-8', urldecode($sKeyWord)).
                    "', '".
                    $shKeyWordEnc.
                    "',  '".
                    $this->get('fREMOTE_ADDR').
                    "', '".
                    $this->get('now()').
                    "') "
                );
            }


            $this->db->query("select vdate from ".TBL_LOGSTORY_BYREFERER." where vdate = '".$this->get('VisitDate')."' and vreferer_id ='".$this->get('fRefererID')."' ");

            if ($this->db->total > 0) {
                if ($bool_visitor) {
                    $sql = "update ".TBL_LOGSTORY_BYREFERER." set visit_cnt = visit_cnt+1, visitor_cnt = visitor_cnt+1 where vdate = '".$this->get('VisitDate')."' and vreferer_id ='".$this->get('fRefererID')."' ";
                } else {
                    $sql = "update ".TBL_LOGSTORY_BYREFERER." set visit_cnt = visit_cnt+1 where vdate = '".$this->get('VisitDate')."' and vreferer_id ='".$this->get('fRefererID')."' ";
                }
            } else {
                $sql = "insert into ".TBL_LOGSTORY_BYREFERER." (vdate,vreferer_id,visit_cnt,visitor_cnt) values ('".$this->get('VisitDate')."','".$this->get('fRefererID')."',1,1) ";
            }
            $this->db->query($sql);
        }
    }

    /**
     * 기타 Referer 레프트 작성
     */
    protected function etcRefererVisitUpdate()
    {
        $bool_visitor = $this->getBoolVisitor();

        $sql = "insert into ".TBL_LOGSTORY_ETCHOST." (idx,referer, etcuri,etchost) values ('','".strtolower($this->get('fHTTP_REFERER'))."','".strtolower($this->get('fREQUEST_URI'))."','".strtolower($this->get('fHTTP_HOST'))."') ";
        $this->db->query($sql);

        $this->db->query("select vdate from ".TBL_LOGSTORY_BYETCREFERER." where vdate = '".$this->get('VisitDate')."' and vetcreferer_id ='".$this->get('fetcRefererID')."' ");

        if ($this->db->total > 0) {
            if ($bool_visitor) {
                $sql = "update ".TBL_LOGSTORY_BYETCREFERER." set visit_cnt = visit_cnt+1, visitor_cnt = visitor_cnt+1 where vdate = '".$this->get('VisitDate')."' and vetcreferer_id ='".$this->get('fetcRefererID')."' ";
            } else {
                $sql = "update ".TBL_LOGSTORY_BYETCREFERER." set visit_cnt = visit_cnt+1 where vdate = '".$this->get('VisitDate')."' and vetcreferer_id ='".$this->get('fetcRefererID')."' ";
            }
        } else {
            $sql = "insert into ".TBL_LOGSTORY_BYETCREFERER." (vdate,vetcreferer_id,visit_cnt,visitor_cnt) values ('".$this->get('VisitDate')."','".$this->get('fetcRefererID')."',1,1) ";
        }
        $this->db->query($sql);
    }

    protected function keyWordUpdate()
    {
        $bool_visitor = $this->getBoolVisitor();

        $this->db->query("select vdate from ".TBL_LOGSTORY_BYKEYWORD." where vdate = '".$this->get('VisitDate')."' and vreferer_id ='".$this->get('fRefererID')."' and kid = '".$this->get('SearchKeyWordId')."'");

        if ($this->db->total > 0) {
            if ($bool_visitor) {
                $sql = "update ".TBL_LOGSTORY_BYKEYWORD." set nh".$this->get('VisitTime')." = nh".$this->get('VisitTime')."+1, visit_cnt = visit_cnt+1, visitor_cnt = visitor_cnt+1 where vdate = '".$this->get('VisitDate')."' and vreferer_id ='".$this->get('fRefererID')."' and kid = '".$this->get('SearchKeyWordId')."'";
            } else {
                $sql = "update ".TBL_LOGSTORY_BYKEYWORD." set nh".$this->get('VisitTime')." = nh".$this->get('VisitTime')."+1, visit_cnt = visit_cnt+1 where vdate = '".$this->get('VisitDate')."' and vreferer_id ='".$this->get('fRefererID')."' and kid = '".$this->get('SearchKeyWordId')."'";
            }
        } else {
            $sql = "insert into ".TBL_LOGSTORY_BYKEYWORD." (vdate,vreferer_id,kid,nh".$this->get('VisitTime').",visit_cnt,visitor_cnt) values ('".$this->get('VisitDate')."','".$this->get('fRefererID')."','".$this->get('SearchKeyWordId')."',1,1,1) ";
        }
        $this->db->query($sql);
    }

    /**
     * 방문자 보고서 업데이트
     */
    protected function visitorUpdate()
    {
        $this->db->query("select vdate from ".TBL_LOGSTORY_VISITOR." where vdate = '".$this->get('VisitDate')."' and agent_type = '".$this->get('agent_type')."'  ");

        if ($this->db->total > 0) {
            $sql = "update ".TBL_LOGSTORY_VISITOR." set nh".$this->get('VisitTime')." = nh".$this->get('VisitTime')."+1, ncnt = ncnt+1 where vdate = '".$this->get('VisitDate')."' and agent_type = '".$this->get('agent_type')."'  ";
        } else {
            $sql = "insert into ".TBL_LOGSTORY_VISITOR." (vdate, agent_type ,nh".$this->get('VisitTime').",ncnt) values ('".$this->get('VisitDate')."','".$this->get('agent_type')."', 1,1) ";
        }
        $this->db->query($sql);

        $this->db->query("select vdate from ".TBL_LOGSTORY_VISITORINFO." where vdate = '".$this->get('VisitDate')."' and agent_type = '".$this->get('agent_type')."'  and ip_addr ='".$this->get('fREMOTE_ADDR')."'");

        if ($this->db->total > 0) {
            $sql = "update ".TBL_LOGSTORY_VISITORINFO.
                " set  visit_cnt = visit_cnt+1, visit_etc_info = '".
                $this->getCookie('VISITORDATE').
                ",".
                $this->getCookie('PHPSESSID').
                ",".
                $this->getCookie('VID').
                "' where vdate = '".
                $this->get('VisitDate').
                "' and ip_addr ='".
                $this->get('fREMOTE_ADDR').
                "' and agent_type = '".
                $this->get('agent_type').
                "'";
        } else {
            $sql = "insert into ".TBL_LOGSTORY_VISITORINFO." (vdate,agent_type, uvid, ip_addr,user_agent, vreferer_id, kid, visit_cnt, cpc_yn, visit_etc_info2, regdate) values ('".
                $this->get('VisitDate').
                "','".
                $this->get('agent_type').
                "', '".
                $this->get('VISITORID').
                "','".
                $this->get('fREMOTE_ADDR')
                ."','".
                $this->get('fHTTP_USER_AGENT').
                "','".
                $this->get('fRefererID').
                "','".
                $this->get('KID').
                "',1, '".
                ($this->get('OVER_TURE') ? "1" : "0").
                "','".
                $this->getCookie('VISITORDATE').
                ",".
                $this->getCookie('PHPSESSID').
                ",".
                $this->getCookie('VID').
                ",".
                $this->getCookie('LAST_CON_TIME').
                "', '".
                $this->get('now()').
                "') ";
        }

        $this->db->query($sql);
    }

    /**
     * 페이지 뷰 보고서 작성
     */
    protected function pageViewUpdate()
    {
        $this->db->query("select vdate from ".TBL_LOGSTORY_PAGEVIEWTIME." where vdate = '".$this->get('VisitDate')."' and agent_type = '".$this->get('agent_type')."' ");

        if ($this->db->total > 0) {
            $sql = "update ".TBL_LOGSTORY_PAGEVIEWTIME." set nh".$this->get('VisitTime')." = nh".$this->get('VisitTime')."+1, ncnt = ncnt+1 where vdate = '".$this->get('VisitDate')."' and agent_type = '".$this->get('agent_type')."'   ";
        } else {
            $sql = "insert into ".TBL_LOGSTORY_PAGEVIEWTIME." (vdate,agent_type, nh".$this->get('VisitTime').",ncnt) values ('".$this->get('VisitDate')."','".$this->get('agent_type')."',1,1) ";
        }
        $this->db->query($sql);
    }

    /**
     * 체류시간 보고서 작성
     */
    protected function durationUpdate()
    {
        $this->db->query("select vdate from ".TBL_LOGSTORY_DURATIONTIME." where vdate = '".$this->get('VisitDate')."' and agent_type = '".$this->get('agent_type')."' ");

        if ($this->db->total > 0) {
            $sql = "update ".TBL_LOGSTORY_DURATIONTIME." set nh".$this->get('VisitTime')." = nh".$this->get('VisitTime')."+".$this->get('DurationTime').", nduration = nduration+".$this->get('DurationTime')." where vdate = '".$this->get('VisitDate')."' and agent_type = '".$this->get('agent_type')."' ";
        } else {
            $sql = "insert into ".TBL_LOGSTORY_DURATIONTIME." (vdate,agent_type, nh".$this->get('VisitTime').",nduration) values ('".$this->get('VisitDate')."','".$this->get('agent_type')."', ".$this->get('DurationTime').",".$this->get('DurationTime').") ";
        }
        $this->db->query($sql);
    }

    /**
     * 로그인 사용자 체류시간 보고서 작성
     */
    protected function memberDurationUpdate()
    {
        $mem_ix = $this->get('UCODE');

        $this->db->query("select vdate from logstory_duration_history where vdate = '".$this->get('VisitDate')."' and mem_ix = '".$mem_ix."' ");

        if ($this->db->total > 0) {
            $sql = "update logstory_duration_history set nh".$this->get('VisitTime')." = nh".$this->get('VisitTime')."+".$this->get('DurationTime').", nduration = nduration+".$this->get('DurationTime')." where vdate = '".$this->get('VisitDate')."' and mem_ix = '".$mem_ix."' ";
        } else {
            $sql = "insert into logstory_duration_history (vdate,mem_ix, nh".$this->get('VisitTime').",nduration) values ('".$this->get('VisitDate')."','".$mem_ix."',".$this->get('DurationTime').",".$this->get('DurationTime').") ";
        }
        $this->db->query($sql);
    }

    /**
     * 페이지별 뷰 리포트 작성
     */
    protected function pageViewByPageUpdate() {
        $page_id = $this->get('PageID');

        $this->db->query("select pageid from " . TBL_LOGSTORY_BYPAGE . " where pageid = '$page_id' and vdate ='" . $this->get('VisitDate') . "'");

        if ($this->db->total > 0) {
            $this->db->query("update " . TBL_LOGSTORY_BYPAGE . " set ncnt = ncnt+1, nduration = nduration + " . $this->get('DurationTime') . " where pageid = '" . $page_id . "' and vdate ='" . $this->get('VisitDate') . "'");
        } else {
            $this->db->query("insert into " . TBL_LOGSTORY_BYPAGE . " (vdate,pageid) values ('" . $this->get('VisitDate') . "','" . $page_id . "') ");
        }
    }

    /**
     * 재방문 여부 확인
     * @return boolean
     */
    protected function getBoolVisitor()
    {
        return $this->getCookie('VISITORDATE') == $this->get('VisitDate');
    }
    /////////////////////////////////////////////////////////////////////////////////////////
    // Private araa
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * 정보 조회
     * @param array $data
     * @param array $keys
     * @return string
     */
    private function getBaseData(&$data, $keys)
    {
        switch (count($keys)) {
            case 4:
                return $data[$keys[0]][$keys[1]][$keys[2]][$keys[3]] ?? '';
                break;
            case 3:
                return $data[$keys[0]][$keys[1]][$keys[2]] ?? '';
                break;
            case 2:
                return $data[$keys[0]][$keys[1]] ?? '';
                break;
            case 1:
                return $data[$keys[0]] ?? '';
                break;
            case 0:
                return $data;
                break;
            default:
                return '';
                break;
        }
    }
}