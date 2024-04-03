<?php

/**
 * Description of ForbizMallDefaultViewController
 *
 * @author hoksi
 *
 * @property CustomMallLayoutModel $layoutModel Layout 모델
 * @property LayOut $msLayout
 */
class ForbizMallDefaultViewController extends ForbizView
{
    protected $layoutModel;
    public $msLayout           = false;
    public $noCheckSleepMember = false;
    public $isLogin            = false;
    private $cachingTime       = 0;

    public function __construct($params = false)
    {
        parent::__construct();

        $this->layoutModel = $this->import('model.mall.layout');


        //자동 로그인 체크
        $this->autoLoginCheck();

        // 휴면회원 여부 확인
        switch ($this->router->routeUri) {
            // 휴면회원 확인 제외 URL
            case 'member/cretify/request':
            case 'member/cretify/response':
            case 'member/sleepAccountRelease':
            case 'member/password':
            case 'member/logout':
                break;
            default:
                $this->chkSleepMember();
                break;
        }



        // $params 값이 있는 경우 레이아웃 제외
        if (empty($params)) {
            $this->setMsLayout();
        }

        // 사용자 이벤트 정의 파일 로드
        if (file_exists(CUSTOM_CONFIG_PATH.'/event.php')) {
            $eventFunc = require CUSTOM_CONFIG_PATH.'/event.php';

            if (is_callable($eventFunc)) {
                $eventFunc('viewController');
            }
        }
    }

    /**
     * URL Segment 값을 배열로 반환, index 지정시 값 반환
     * @param int $idx
     * @return string|array
     */
    public function getParams($idx = false)
    {
        $params = $this->router->fetch_params();

        if ($idx !== false) {
            return isset($params[$idx]) ? $params[$idx] : '';
        }

        return $params;
    }

    /**
     * 휴면회원 확인 함수
     */
    protected function chkSleepMember()
    {
        // 휴면 유저 체크
        if ($this->noCheckSleepMember === false && ForbizConfig::getPrivacyConfig('sleep_user_yn') == 'Y') {
            if (sess_val('user', 'sleep_account') == 'Y') {
                redirect('/member/sleepAccountRelease');
            }
        }

        // 비밀번호 변경 확인
        $this->chekChangePassword();
    }

    /**
     * 라우팅된 URL 설정
     * @param string $uri
     * @return $this
     */
    public function setUri($uri)
    {
        $this->router->routeUri = $uri;
        $this->setMsLayout();

        return $this;
    }

    /**
     * 라우팅된 URL을 기준으로 Layout 구성
     * @return $this
     */
    protected function setMsLayout()
    {
        // 레이아웃 설정
        $layoutConfigData = $this->layoutModel->getLayoutUrlConfig($this->router->routeUri);

        //폐쇠몰 체크 하여 로그인 여부 확인
        if (ForbizConfig::getSharedMemory('member_reg_rule')['mall_open_yn'] == "Y" && !in_array($this->router->routeUri,
                ForbizConfig::getConfig('excludeLoginUrl'))) {
            is_login('redirect');
            return;
        }

        // 레이아웃 객체 가져오기
        $this->msLayout = $this->layoutModel->getLayout($layoutConfigData);

        // 캐싱 여부 처리
        $this->tpl->caching = $layoutConfigData->caching;
        $this->cachingTime  = $layoutConfigData->cachingTime;

        $this->msLayout->contentsScope();

        return $this;
    }

    public function setContentScope($contentsPath)
    {
        $this->msLayout->contentsScope($contentsPath);

        return $this;
    }

    /**
     * 템플릿 파일 캐싱 여부
     * @param string $cacheId
     * @return boolean
     */
    public function isCached($cacheId = null)
    {
        $this->tpl->setCache($this->msLayout->getContentsScopeId(), $this->cachingTime, array('all', $this->router->routeUri), $cacheId);
        return $this->tpl->isCached($this->msLayout->getContentsScopeId());
    }

    /**
     * Layout Data Assign
     * @param string $key
     * @param string $val
     * @return $this
     */
    public function setLayoutAssign($key, $val = '')
    {
        $this->msLayout->setLayoutAssign($key, $val);
        return $this;
    }

    /**
     * HeaderTop Data Assign
     * @param string $key
     * @param string $val
     * @return $this
     */
    public function setHeaderTopAssign($key, $val = '')
    {
        $this->msLayout->setHeaderTopAssign($key, $val);
        return $this;
    }

    /**
     * HeaderMenu Data Assign
     * @param string $key
     * @param string $val
     * @return $this
     */
    public function setHeaderMenuAssign($key, $val = '')
    {
        $this->msLayout->setHeaderMenuAssign($key, $val);
        return $this;
    }

    /**
     * ContentsAdd Data Assign
     * @param string $key
     * @param string $val
     * @return $this
     */
    public function setContentsAddAssign($key, $val = '')
    {
        $this->msLayout->setContentsAddAssign($key, $val);
        return $this;
    }

    /**
     * LeftMenu Data Assign
     * @param string $key
     * @param string $val
     * @return $this
     */
    public function setLeftMenuAssign($key, $val = '')
    {
        $this->msLayout->setLeftMenuAssign($key, $val);
        return $this;
    }

    /**
     * RightMenu Data Assign
     * @param string $key
     * @param string $val
     * @return $this
     */
    public function setRightMenuAssign($key, $val = '')
    {
        $this->msLayout->setRightMenuAssign($key, $val);
        return $this;
    }

    /**
     * FooterMenu Data Assign
     * @param string $key
     * @param string $val
     * @return $this
     */
    public function setFooterMenuAssign($key, $val = '')
    {
        $this->msLayout->setFooterMenuAssign($key, $val);
        return $this;
    }

    /**
     * FooterDesc Data Assign
     * @param string $key
     * @param string $val
     * @return $this
     */
    public function setFooterDescAssign($key, $val = '')
    {
        $this->msLayout->setFooterDescAssign($key, $val);
        return $this;
    }

    /**
     * Layout 템플릿을 문자열로 변환
     * @return boolean
     */
    public function loadLayout()
    {
        if (is_object($this->msLayout)) {
            /*$T            = new Tag();
            $T->file      = "/mallstory_SalesAnalysisTag.js";
            $T->userID    = sess_val('user', 'id');
            $T->siteID    = "";
            $T->data_root = DATA_ROOT;
            $T->email     = sess_val('user', 'mail');
            $T->mobile    = sess_val('user', 'pcs');*/

            $not_allow_page = array();

            // Fat
            if (defined('USE_FAT') && USE_FAT === true && ((in_array(sess_val('user', 'id'), sess_val('allowFatUser')) || sess_val('forbiz_qa_user') === true))) {
                $this->tpl->define('_fat', 'fat/default.htm');
            }

            // view 전역 이벤트 호출
            if ($this->router->routeUri) {
                $this->event->trigger($this->router->routeUri, [$this->router->routeUri]);
            }

            $this->event->trigger('viewController', [$this->router->routeUri]);

            //if (!in_array($_SERVER['PHP_SELF'], $not_allow_page)) {
                //return $this->msLayout->LoadLayOut().$T->ToTagString();
            //} else {
                return $this->msLayout->LoadLayOut();
            //}
        } else {
            log_message('error', 'msLayout not loaded : Default code check please');
            return false;
        }
    }

    /**
     * 컨트롤러 실행
     * @param boolean $profiler
     * @return string
     */
    public function run($profiler = false)
    {
        if ($profiler) {
            $this->output->enable_profiler();
        }

        if (method_exists($this, 'index')) {
            return $this->index();
        } else {
            return $this->loadLayout();
        }
    }

    /**
     * mypage에서 공통적으로 사용되는 부분 분리
     */
    public function mypageCommon()
    {
        /* @var $couponModel CustomMallCouponModel */
        $couponModel  = $this->import('model.mall.coupon');
        /* @var $orderModel CustomMallOrderModel */
        $orderModel   = $this->import('model.mall.order');
        /* @var $mileageModel CustomMallMileageModel */
        $mileageModel = $this->import('model.mall.mileage');

        // 배송상태별 카운팅
        $status = $orderModel->getStatusCount(sess_val('user', 'code'), ORDER_STATUS_DELIVERY_ING);

        $this->assign('mypage',
            [
                'userName' => sess_val("user", "name"), // 회원 이름
                'gpName' => sess_val("user", "gp_name"), // 멤버십 등급
                'deliveryIngCnt' => ($status[ORDER_STATUS_DELIVERY_ING] ?? 0), // 배송중인 상품
                'myMileAmount' => $mileageModel->getUserAmount(), // 마일리지
                'couponCnt' => $couponModel->setMember(sess_val('user', 'code'), sess_val('user', 'gp_ix'), sess_val('user', 'use_coupon_yn'))->getCouponCnt() // 보유중인 쿠폰수
        ]);

        if (!is_mobile()) {
            $this->define('mypage_top', 'mypage/mypage_top/mypage_top.htm');
        }
    }

    /**
     * 비밀번호 변경 확인
     */
    protected function chekChangePassword()
    {
        if (sess_val('user', 'changeAccessPassword')) {
            redirect('member/password');
        }
    }

    public function autoLoginCheck()
    {

        if (empty(sess_val('user', 'code'))) {
            //cookie 체크해서 로그인가능하면 바로 로그인처리
            if (!empty($_COOKIE['connection_no'])) {
                $crypt      = new Encryption();
                $login_info = @explode('|', $crypt->decrypt($_COOKIE['connection_no']));

                //유효성 체크
                if (!empty($login_info[0]) && !empty($login_info[1])) {
                    $this->autoLogin($login_info);
                }
            }
        }
    }

    public function autoLogin($info)
    {

        $id        = strtolower($info[0]);
        $pw        = $info[1];
        $cookie_id = $info[2];



        /* @var $loginModel CustomMallMemberLoginModel */
        $loginModel = $this->import('model.mall.member.login');

        $new_cookie_id = $loginModel->getRandomText(10, true);

        $crypt      = new Encryption();
        $source     = $id.'|'.$pw.'|'.$new_cookie_id;
        $auth_token = $crypt->encrypt($source);

        $loginCheck = $loginModel->autoLoginOutput($id, $cookie_id, $new_cookie_id);
        if ($loginCheck === true) {
            /* @var $memberModel CustomMallMemberModel */
            $memberModel = $this->import('model.mall.member');
            //갱신 하는 영역으로 로그인 시 오토 로그인 체크 하지 않고 쿠키만 연장 처리 함
            $memberModel->doLogin($id, $pw, 'R');


            //자동로그인 쿠키 연장
            setcookie("connection_no", $auth_token, time() + 1209600, "/", $_SERVER['HTTP_HOST'], false, true);
            setcookie("auto_login", 'Y', time() + 1209600, "/", $_SERVER['HTTP_HOST'], false, true);
        }
    }
}