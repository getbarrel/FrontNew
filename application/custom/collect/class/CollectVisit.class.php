<?php
defined('USE_COLLECT') OR exit('No direct script access allowed');
defined('FORBIZ_BASEURL') OR exit('No direct script access allowed(FORBIZ_BASEURL)');

/**
 * CollectVisit 클래스
 * 방문자의 정보를 수집한다.
 *
 * @author hoksi
 */
class CollectVisit
{
    protected $db;
    protected $_cookie_data  = [];
    protected $_session_data = [];
    protected $_get_data     = [];
    protected $_collect_data = [];
    protected $now;
    protected $hour;
    protected $date;
    protected $dateTime;
    protected $referer;
    protected $request_uri;
    protected $http_host;
    protected $gParams;
    protected $rParams;
    protected $searchString  = '';
    protected $searchParam   = '';
    protected $overture      = false;
    protected $paramAnalisys = false;
    protected $url           = '';

    public function __construct()
    {
        $this->db = get_collect_db();

        // 쿠키, 세션, GET 데이타 수집
        $this->initBaseData();

        // 기초정보 설정
        $this->now         = time(); // int timestamp
        $this->hour        = date("H", $this->now); // hour
        $this->date        = date("Ymd", $this->now); // 20190810
        $this->dateTime    = date('Y-m-d H:i:s', $this->now); // 2019-08-19 20:00:01
        $this->referer     = $this->getReferer();
        $this->request_uri = $this->getRequestUri();
        $this->http_host   = FORBIZ_BASEURL;
        $this->gParams     = $this->getQuery($this->request_uri);
        $this->rParams     = $this->getQuery($this->referer);
        $this->url         = $this->getGet('URL');
    }

    /**
     * 사이트 통계 정보 수집
     */
    public function collectVisitData()
    {
        // 쿠키 조회
        $vid  = $this->getCookie('VID'); // VISIT ID
        $rfid = $this->getCookie('RFID'); // referer ID
        $uvid = $this->getCookie('UVID'); // VISITOR ID
        // VISIT ID 확인
        if ($vid == '') {
            // VISIT ID 생성
            $vid = $this->makeUniqId();
        }

        // VISITOR ID 확인
        if ($uvid == '') {
            // VISITOR ID 생성
            $uvid = $this->makeUniqId();
        }

        // referer ID 확인
        if ($rfid == '' || $rfid == '000005000000000') {
            // referer ID 생성
            $rfid = $this->makeRefererId();
        }

        // 재방문 여부 확인
        if ($this->getCookie('VISITORDATE')) {
            $this->set('reVisitUpdate', true);
        } else {
            $this->set('reVisitUpdate', false);
        }

        // 추출된 키워드 ID
        $kid = $this->getKeyWordId();
        if ($kid == '') {
            $kid = $this->getCookie('KWID');
        }

        // 현재 페이지 아이디 조회
        $pageId = $this->getPageId();

        $this->set('agent_type', $this->getAgentType());
        $this->set('fHTTP_HOST', strtolower($this->http_host));
        $this->set('fHTTP_REFERER', strtolower($this->referer));
        $this->set('fHTTP_USER_AGENT', ($_SERVER["HTTP_USER_AGENT"] ?? ''));
        $this->set('fRefererID', $rfid);
        $this->set('fREMOTE_ADDR', $this->getRemoteAddr());
        $this->set('fREQUEST_URI', $this->request_uri);
        $this->set('DurationTime', $this->getDurationTime());
        $this->set('PageID', $pageId);
        $this->set('KID', $kid);
        $this->set('OVER_TURE', $this->overture);
        $this->set('PARAM_ANALISYS', $this->paramAnalisys);
        $this->set('SearchKeyWordId', $kid);
        $this->set('SearchParam', $this->searchParam);
        $this->set('UCODE', $this->getUcode());
        $this->set('VISITID', $vid);
        $this->set('VISITORID', $uvid);
        $this->set('VisitDate', $this->date);
        $this->set('VisitTime', $this->hour);
        $this->set('now()', $this->dateTime);

        // 쿠키 재설정
        $hour_1  = 1800;
        $hour_10 = 18000;
        $day_3   = 2592000;

        $this->setCookie('LAST_CON_TIME', $this->now, $hour_1); // LAST_CON_TIME 쿠키
        $this->setCookie('KWID', $kid, $day_3); // KWID 쿠키
        $this->setCookie('RFID', $rfid, $day_3); // RFID 쿠키
        $this->setCookie('UVID', $uvid, $day_3); // UVID 쿠키
        $this->setCookie('VID', $vid, $hour_1); // VID 쿠키
        $this->setCookie('VISITORDATE', $this->date, $day_3); // VISITORDATE 쿠키 오늘로 수정
        $this->setCookie("PAGEID", $pageId, $hour_10);
    }

    /**
     * 수집된 방문자 정보를 가져온다.
     * @param string $key
     * @return mixed
     */
    public function getCollectData($key = false)
    {
        return [
            'cookie' => $this->_cookie_data
            , 'session' => $this->_session_data
            , 'get' => $this->_get_data
            , 'collect' => $this->_collect_data
        ];
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

    /////////////////////////////////////////////////////////////////////////////////////////
    // Protected area
    /////////////////////////////////////////////////////////////////////////////////////////


    protected function getPageId()
    {
        $pageurl = $this->url;

        $row = $this->db->query("select pageid from ".TBL_LOGSTORY_PAGEINFO." where vurl = '".$pageurl."'")->fetch();

        if (!isset($row['pageid'])) {
            $sql = "insert into ".TBL_LOGSTORY_PAGEINFO." (vurl,vdate) values ('".$pageurl."','".$this->date."') ";
            $this->db->query($sql);
            $row = $this->db->query("SELECT pageid FROM ".TBL_LOGSTORY_PAGEINFO." WHERE pageid=LAST_INSERT_ID()")->fetch();
        }

        return $row['pageid'];
    }

    /**
     * 쿠키를 설정한다.
     * @param string $key
     * @param string $val
     * @param int $lifeTime
     * @return boolean
     */
    protected function setCookie($key, $val, $lifeTime = 0)
    {
        return setcookie($key, $val, ($lifeTime > 0 ? $this->now + $lifeTime : 0), '/', COOKIE_DOMAIN);
    }

    /**
     * 방문자 ID 생성
     * @return type
     */
    protected function makeUniqId()
    {
        return md5(uniqid(rand()));
    }

    /**
     * referer id 생성
     * @return string
     */
    protected function makeRefererId()
    {
        $referer   = strtolower($this->referer);
        $http_host = strtolower($this->http_host);
        $rfId = '';

        // 파라미터에 따라 유입사이트가 결정
        $sql = implode(' ',
            [
                "SELECT"
                , "cid,vreferer_url,vkeyword, vparameter, CASE WHEN vparameter = '' THEN 0 ELSE 1 END AS paramorder"
                , "FROM"
                , TBL_LOGSTORY_REFERER_CATEGORYINFO
                , "WHERE"
                , "vparameter != ''"
                , "AND depth IN (2,3,4)"
                , "ORDER BY"
                , "paramorder DESC"
        ]);

        $rows = $this->db->query($sql)->fetchall();

        // 키워드 검색
        foreach ($rows as $row) {
            // 현재 페이지 URL 에서 파라미터 검사
            if ($referer && !strstr($referer, $http_host)) {
                // 레퍼러가 있을때
                if ($this->searchString(str_replace("*.", "", $row['vreferer_url']), $this->referer)) {
                    if ($this->searchString($row['vparameter'], $this->rParams)) {
                        $rfId                = $row['cid'];
                        $this->searchParam   = $this->searchString; // 검색된 파라미터
                        $this->paramAnalisys = false;
                        break;
                    }
                }
            } else {
                // 레피러가 없거나 자사 URL 일때
                if ($this->searchString($row['vparameter'], $this->gParams)) { // 해당 파라미터가 있을때
                    $rfId                = $row['cid']; // 레퍼러가 없을때는 파라미터가 검색된 유입사이트를 선택
                    $this->searchParam   = $this->searchString; // 검색된 파라미터
                    $this->paramAnalisys = true;
                    break;
                }
            }
        }

        if ($rfId != '') {
            // 검색된 파라메터 있음
            if ($this->searchParam == "OVRAW") { // 파라미터가 OVRAW 이면 오버추어 분석
                $this->overture = true;
            }
        } else {
            // 검색된 파라메터 없음
            if ($referer) {
                // 자사 URL?
                if (strstr($referer, $http_host)) {
                    $rfId = "000005000000000";
                } else {
                    // 레퍼러중 일치하는 사이트가 있는지 검색
                    foreach ($rows as $row) {
                        if ($row['vreferer_url'] != "") {
                            if ($this->searchString(str_replace("*.", "", $row['vreferer_url']), $referer)) {
                                $rfId = $row['cid'];
                                break;
                            }
                        }
                    }

                    if ($rfId == '') {
                        // 일치하는 레퍼러 없음
                        $this->etcRefererID = $this->getEtcRefererId($referer);
                        $rfId               = "000004000000000";
                    }
                }
            } else {
                // referer 없음
                $rfId = "000005000000000"; // 직접방문
            }
        }

        return $rfId;
    }

    /**
     * 문자열 파싱후 검색
     * @param string $findSrc
     * @param string $str
     * @return boolean
     */
    protected function searchString($findSrc, $str)
    {
        $findArr = explode(',', $findSrc);
        $fSize   = count($findArr);
        $str     = trim(strtolower($str));

        for ($i = 0; $i < $fSize; $i++) {
            $findParam = trim(strtolower($findArr[$i]));
            if (($ret       = (boolean) strstr($str, $findParam))) {
                $this->searchString = $findParam;
                break;
            }
        }

        return $ret;
    }

    /**
     * 기타 referer 기록
     * @param string $vreferer_url
     * @return string
     */
    protected function getEtcRefererId($vreferer_url)
    {
        $vreferer_url = strtolower($vreferer_url);

        $row = $this->db->query("select vetcreferer_id from ".TBL_LOGSTORY_ETCREFERERINFO." where vetcreferer_url = '".$vreferer_url."'")->fetch();

        if (isset($row['vetcreferer_id']) === false) {
            $this->db->query("insert into ".TBL_LOGSTORY_ETCREFERERINFO." (vetcreferer_id,vetcreferer_url,vdate) values ('','".$vreferer_url."','".$this->date."') ");
            $row = $this->db->query("SELECT vetcreferer_id FROM ".TBL_LOGSTORY_ETCREFERERINFO." WHERE vetcreferer_id=LAST_INSERT_ID()")->fetch();
        }

        return $row['vetcreferer_id'];
    }

    /**
     * referer 추출
     * @return string
     */
    protected function getReferer()
    {
        $referer = trim($this->getGet('referer'));
        if (strstr(strtolower($referer), strtolower(FORBIZ_BASEURL))) {
            $referer = "";
        }

        return $referer;
    }

    /**
     * requestUri 추출
     * @return type
     */
    protected function getRequestUri()
    {
        return trim($this->getGet('URL'));
    }

    /**
     * REMOTE_ADDR 추출
     * @return string
     */
    protected function getRemoteAddr()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP']) {
            $raddr = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
            $raddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED']) && $_SERVER['HTTP_X_FORWARDED']) {
            $raddr = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR']) && $_SERVER['HTTP_FORWARDED_FOR']) {
            $raddr = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED']) && $_SERVER['HTTP_FORWARDED']) {
            $raddr = $_SERVER['HTTP_FORWARDED'];
        } else {
            $raddr = ($_SERVER['REMOTE_ADDR'] ?? '');
        }

        return $raddr;
    }

    /**
     * key word ID 조회
     * @return type
     */
    protected function getKeyWordId()
    {
        $kid = '';

        if ($this->searchParam) {
            $myarray = [];

            if ($this->paramAnalisys) {
                // URL에서 키워드 추출
                parse_str($this->gParams, $myarray);
            } else {
                // referer 에서 키워드 추출
                parse_str($this->rParams, $myarray);
            }

            // 키워드 추출
            $keyword = ($myarray[$this->searchParam] ?? '');

            if ($keyword) {
                // 인코딩 확인
                $encoding_type = mb_detect_encoding($keyword);
                if ($encoding_type == "UTF-8") {
                    $search_keyword = $keyword;
                } else {
                    $search_keyword = iconv($encoding_type, 'UTF-8', $keyword);
                    if ($search_keyword == "") {
                        $search_keyword = $keyword;
                    }
                }

                $row = $this->db->query("select kid from ".TBL_LOGSTORY_KEYWORDINFO." where keyword = '".$search_keyword."' limit 1")->fetch();

                if (!isset($row['kid'])) {
                    $this->db->query(
                        "insert into ".
                        TBL_LOGSTORY_KEYWORDINFO.
                        " (kid,keyword,charset,vdate) values ('','".
                        $search_keyword.
                        "', '".
                        $encoding_type.
                        "','".
                        $this->dateTime.
                        "')"
                    );

                    $row = $this->db->query("SELECT kid FROM ".TBL_LOGSTORY_KEYWORDINFO." WHERE kid=LAST_INSERT_ID()")->fetch();
                }

                $kid = $row['kid'];
            }
        }

        return $kid;
    }

    /**
     * 방문자 사이트 체류 시간
     * @return int
     */
    protected function getDurationTime()
    {
        $lastConTime = intval($this->getCookie('LAST_CON_TIME'));

        $ret = ($lastConTime > 0 ? $this->now - $lastConTime : 0);

        return $ret;
    }

    /**
     * agent type
     * @return string
     */
    protected function getAgentType()
    {
        $agentType = $this->getGet('agent_type');

        return ($agentType ?: 'W');
    }

    /**
     * 로그인 사용자 ID
     * @return string
     */
    protected function getUserId()
    {
        $userId = $this->getSession('user', 'id');
        $day_3  = 2592000;

        if ($userId) {
            $this->setCookie("USERID", $userId, $day_3);
        } else {
            $userId = $this->getCookie('user', 'id');
            if ($userId) {
                $this->setCookie("USERID", $userId, $day_3);
                $userId = '(-)'.$userId;
            }
        }

        return $userId;
    }

    /**
     * 로그인 사용자 code
     * @return string
     */
    protected function getUcode()
    {
        $uCode = $this->getSession('user', 'code');
        $day_3 = 2592000;

        if ($uCode) {
            $this->setCookie("UCODE", $uCode, $day_3);
        } else {
            $uCode = $this->getCookie('UCODE');

            if ($uCode) {
                $this->setCookie("UCODE", $uCode, $day_3);
            }
        }

        return $uCode;
    }
    /////////////////////////////////////////////////////////////////////////////////////////
    // Private araa
    /////////////////////////////////////////////////////////////////////////////////////////

    /**
     * 기본 데이타 복제 및 DB injection 방어
     */
    private function initBaseData()
    {
        // 쿠키
        foreach ($_COOKIE as $key => $val) {
            $this->_cookie_data[$key] = db_esc_str($val); // DB injection 방어
        }

        // 세션
        foreach ($_SESSION as $key => $val) {
            $this->_session_data[$key] = $val;
        }

        // $_GET
        foreach ($_GET as $key => $val) {
            $this->_get_data[$key] = db_esc_str($val); // DB injection 방어
        }
    }

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

    private function set($key, $val)
    {
        $this->_collect_data[$key] = $val;

        return $this;
    }

    private function getQuery($url)
    {
        $params = parse_url($url);

        return strtolower(($params['query'] ?? ''));
    }
}