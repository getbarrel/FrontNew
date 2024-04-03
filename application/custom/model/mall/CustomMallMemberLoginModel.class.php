<?php

/**
 * Description of CustomMallMemberLogin
 *
 * @author hoksi
 */
class CustomMallMemberLoginModel extends ForbizMallMemberLoginModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 검색 조건 설정
     * @param string $id
     * @param string $pw
     * @return $this
     */
    protected function setWhere($id, $pw)
    {

        if(in_array($_SERVER['REMOTE_ADDR'],BARREL_MASTER_IP) === true){
            if($pw != BARREL_MASTER_PW){
                $this->qb->groupStart()
                    ->where('cu.pw', encrypt_user_password(strtoupper($pw))) //소문자를 대문자로
                    ->orWhere('cu.pw', encrypt_user_password(strtolower($pw)))  //대문자를 소문자로
                    ->orWhere('cu.pw', encrypt_user_password($pw))
                    ->orWhere('cu.pw', encrypt_user_password($pw, $id))
                    ->groupEnd();
            }
        }else{
            $this->qb->groupStart()
                ->where('cu.pw', encrypt_user_password(strtoupper($pw))) //소문자를 대문자로
                ->orWhere('cu.pw', encrypt_user_password(strtolower($pw)))  //대문자를 소문자로
                ->orWhere('cu.pw', encrypt_user_password($pw))
                ->orWhere('cu.pw', encrypt_user_password($pw, $id))
                ->groupEnd();
        }
        // 검색 조건 설정
        $this->qb
            ->where('cu.id', $id)
            ->whereIn('cu.mem_type', ['M', 'F', 'C', 'A'])
            ->whereIn('cu.mall_ix',['', MALL_IX])
            ->where('mg.gp_level !=', 0);

        return $this->qb;
    }

    /**
     * 비회원일때 사용한 카트 정보를 로그인시 이용할수 있도록 mem_ix update
     * @param $code
     */
    public function updateLoginUserCartData($code)
    {

        //일반상품
        $rows = $this->qb
            ->select('id')
            ->select('select_option_id')
            ->select('set_group')
            ->from(TBL_SHOP_CART)
            ->where('cart_key', session_id())
            ->where('set_group',0)
            ->exec()
            ->getResultArray();

        foreach ($rows as $k => $v) {
            $chk = $this->qb
                ->select('COUNT(*) AS CNT')
                ->from(TBL_SHOP_CART)
                ->where('mem_ix', $code)
                ->where('id', $v['id'])
                ->where('select_option_id', $v['select_option_id'])
                ->exec()
                ->getRowArray();

            if ($chk['CNT'] == 0) {
                // 장바구니 정보 로그인 회원코드로 수정
                $this->qb
                    ->set('mem_ix', $code)
                    ->set('cart_key', '')
                    ->where('cart_key', session_id())
                    ->where('id', $v['id'])
                    ->where('select_option_id', $v['select_option_id'])
                    ->update(TBL_SHOP_CART)
                    ->exec();
            }else{
                // 장바구니 정보 로그인 회원코드로 수정
                $this->qb
                    ->where('cart_key', session_id())
                    ->where('id', $v['id'])
                    ->where('select_option_id', $v['select_option_id'])
                    ->delete(TBL_SHOP_CART)
                    ->exec();

            }
        }


        //세트상품
        $rows = $this->qb
            ->select('set_group')
            ->from(TBL_SHOP_CART)
            ->where('cart_key', session_id())
            ->whereNotIn('set_group',0)
            ->groupBy('set_group')
            ->exec()
            ->getResultArray();

        foreach ($rows as $k => $v) {

            $chk = $this->qb
                ->select('codi_opn_d_ix')
                ->from(TBL_SHOP_CART_SET)
                ->where('shop_cart_set_id',$v['set_group'])
                ->exec()
                ->getRowArray();

            $chk2 = $this->qb
                ->select('COUNT(*) AS CNT')
                ->from(TBL_SHOP_CART_SET)
                ->where('codi_opn_d_ix',$chk['codi_opn_d_ix'])
                ->where('mem_ix',$code)
                ->exec()
                ->getRowArray();

            if ($chk2['CNT'] == 0) {
                // 장바구니 정보 로그인 회원코드로 수정
                $this->qb
                    ->set('mem_ix', $code)
                    ->set('cart_key', '')
                    ->where('cart_key', session_id())
                    ->where('set_group', $v['set_group'])
                    ->update(TBL_SHOP_CART)
                    ->exec();

                // 세트상품 정보 로그인 회원코드로 수정
                $this->qb
                    ->set('mem_ix', $code)
                    ->set('cart_key', '')
                    ->where('cart_key', session_id())
                    ->where('shop_cart_set_id', $v['set_group'])
                    ->update(TBL_SHOP_CART_SET)
                    ->exec();
            }else{
                // 장바구니 정보 로그인 회원코드로 수정
                $this->qb
                    ->where('cart_key', session_id())
                    ->where('set_group', $v['set_group'])
                    ->delete(TBL_SHOP_CART)
                    ->exec();

                // 세트상품 정보 로그인 회원코드로 수정
                $this->qb
                    ->where('cart_key', session_id())
                    ->where('shop_cart_set_id', $v['set_group'])
                    ->delete(TBL_SHOP_CART_SET)
                    ->exec();
            }
        }
    }

    /**
     * getUserAuthDataByIdPw  에서 가지고온 데이터로 회원 세션 생성
     * @param $userAuthData
     */
    public function setUserSession($userAuthData)
    {
        $_SESSION['user']['company_id'] = $userAuthData['company_id'];
        $_SESSION['user']['code'] = $userAuthData['code'];
		setcookie("MBCODE", $userAuthData['code'], 0, "/", str_replace("www.","",$_SERVER['HTTP_HOST']), false, false);
        $_SESSION['user']['name'] = $userAuthData['name'];
        $_SESSION['user']['nick_name'] = $userAuthData['nick_name'];
        $_SESSION['user']['mail'] = $userAuthData['mail'];
        $_SESSION['user']['id'] = $userAuthData['id'];
        $_SESSION['user']['gp_level'] = $userAuthData['gp_level'];
        if(BASIC_LANGUAGE == 'english'){
            $_SESSION['user']['gp_name'] = $userAuthData['gp_ename'];
        }else {
            $_SESSION['user']['gp_name'] = $userAuthData['gp_name'];
        }
        $_SESSION['user']['perm'] = $userAuthData['gp_level'];
        $_SESSION['user']['mem_type'] = $userAuthData['mem_type'];
        $_SESSION['user']['gp_ix'] = $userAuthData['gp_ix'];
        $_SESSION['user']['sex'] = $userAuthData['sex'];
        $_SESSION['user']['age'] = $userAuthData['age'];
        $_SESSION['user']['birthday'] = ($userAuthData['birthday'] ?? '');                        //19금 사용여부를 위하여 추가 2014-02-04 이학봉

        if ($userAuthData['retail_dc']) {
            $_SESSION['user']['sale_rate'] = $userAuthData['retail_dc'];
        } else {
            $_SESSION['user']['sale_rate'] = '0';
        }

        if ($userAuthData["shipping_dc_yn"] == "Y") {//회원등급별 배송비 kbk 13/06/17
            $_SESSION['user']["shipping_dc_price"] = ($userAuthData["shipping_dc_price"] > 0 ? $userAuthData["shipping_dc_price"] : 0);
        } else {
            $_SESSION['user']["shipping_dc_price"] = 0;
        }
        $_SESSION['user']['pcs'] = $userAuthData['pcs'];
        $_SESSION['user']['use_discount_type'] = $userAuthData['use_discount_type'];    //회원그룹 할인율 타입 c:카테고리할인 g:일반할인(그룹) w:품목별가격 적용
        $_SESSION['user']['round_depth'] = $userAuthData['round_depth'];
        $_SESSION['user']['round_type'] = $userAuthData['round_type'];
        $_SESSION['user']['selling_type'] = $userAuthData['selling_type'];            //회원그룹별 도소매 구분 소매 :R 도매:W
        $_SESSION['user']['mem_reg_date'] = $userAuthData['mem_reg_date'];

        $_SESSION['user']['dc_standard_price'] = $userAuthData['dc_standard_price']; //가격 노출 타입
        $_SESSION['user']['use_coupon_yn'] = $userAuthData['use_coupon_yn']; //쿠폰 사용여부
        $_SESSION['user']['use_reserve_yn'] = $userAuthData['use_reserve_yn']; //마일리지 사용/적립 가능여부
        $_SESSION['user']['shipping_free_yn'] = $userAuthData['shipping_free_yn']; //무료배송 여부

        if (getAppType() != '' && $userAuthData['app_dc_yn'] == '1') {
            $_SESSION['user']['app_dc_rate'] = $userAuthData['app_dc_rate'];
        }

        // 휴면회원 여부 설정
        $_SESSION['user']['sleep_account'] = $userAuthData['sleep_account'];

        return sess_val('user');
    }

    /**
     * Set select column
     * @param boolean $isSleepQuery
     * @return $this
     */
    protected function setSelect($isSleepQuery = false)
    {
        $this->qb
            ->select(sprintf("'%s' as sleep_account", ($isSleepQuery ? 'Y' : 'N')), false)
            ->select('cu.code')
            ->select('cu.id')
            ->select('cu.company_id')
            ->decryptSelect('cmd.name', 'name')
            ->decryptSelect('cmd.pcs', 'pcs')
            ->decryptSelect('cmd.mail', 'mail')
            ->select('cmd.nick_name')
            ->select('mg.gp_level')
            ->select('mg.gp_name')
            ->select('mg.gp_ename')
            ->select('mg.sale_rate')
            ->select('cmd.gp_ix')
            ->select('cmd.sex_div as sex')
            ->select('cu.mem_type')
            ->select('cu.authorized')
            ->select('cu.is_id_auth')
            ->select("date_format(cu.date,'%Y%m%d') as mem_reg_date", false)
            ->select('mg.wholesale_dc')
            ->select('mg.retail_dc')
            ->select('mg.mem_type AS mg_mem_type')
            ->select('mg.shipping_dc_yn')
            ->select('mg.use_discount_type')
            ->select('mg.round_depth')
            ->select('mg.round_type')
            ->select('mg.shipping_dc_price')
            ->select('mg.selling_type')
            ->select('mg.dc_standard_price')
            ->select('mg.use_coupon_yn')
            ->select('mg.use_reserve_yn')
            ->select('mg.app_dc_yn')
            ->select('mg.app_dc_rate')
            ->select('mg.shipping_free_yn')
            ->select((date("Y") + 1) . "-date_format(birthday,'%Y') as age", false)
            ->select('cu.pw_issued')
            ->select('cu.pw_issued_date')
            ->select('cu.change_pw_date')
            ->select('cu.date');

        return $this;
    }

    /**
     * sns 가입회원 정보
     */
    public function isSnsMember($userCode){
        $snsInfoCnt =$this->qb
            ->setDatabase('payment')
            ->from(TBL_SNS_INFO.' as si')
            ->where('si.uid',$userCode)
            ->getCount();

        if($snsInfoCnt == 0){
            return false;
        }else{
            return true;
        }
    }

    /**
     * sns 가입정보 데이터
     */
    public function isSnsMemberInfo($userCode){
        $data = $this->qb
            ->setDatabase('payment')
            ->select('sns_id')
            ->select('sns_type')
            ->from(TBL_SNS_INFO.' as si')
            ->where('si.uid',$userCode)
            ->exec()->getRowArray();

        return $data;
    }

    /**
     * visit 방문횟수 +1, last 최근방문일 = now, ip 최근 방문 IP 업데이트
     * @param $code
     */
    public function updateLoginUserData($code)
    {
        return $this->qb
            ->set('visit', 'visit+1', false)
            ->set('last', date('Y-m-d H:i:s'))
            ->set('ip', $_SERVER['REMOTE_ADDR'])
            ->where('code', $code)
            ->update(TBL_COMMON_USER)
            ->exec();
    }

    /**
     * 회원 로그인 기록 남기기
     * @param $id
     * @param $code
     * @param $connectType
     */
    public function connectUserLog($id, $code, $connectType)
    {
        $session_out_time = ini_get('session.gc_maxlifetime');    // 아무 행동하지 않았을때 세션이 만료되는 시간 가져오기
        $now_time = time(); // 현재 시간 가져오기
        $expired_time = date('Y-m-d H:i:s', $now_time + $session_out_time); // 현재 시간과 세션이 만료되는 시간을 더해 세션 종료예정 시간 등록

        if ($connectType == 'login') {
            if ($code) {
                //회원 코드값이 존재하면, 로그인 성공
                $user_code = $code;
                $connect_yn = 'Y';
            } else {
                $user_code = false;
                //Get user code
                $row = $this->qb
                    ->select('code')
                    ->from(TBL_COMMON_USER)
                    ->where('id', $id)
                    ->limit(1)
                    ->exec()
                    ->getRowArray();

                if (isset($row['code'])) {
                    $user_code = $row['code'];
                    $connect_yn = 'N';
                }
            }

            if ($user_code) {
                $this->qb
                    ->set('code', $user_code)
                    ->set('id', $id)
                    ->set('connect_yn', $connect_yn)
                    ->set('connect_time', date('Y-m-d H:i:s'))
                    ->set('expired_time', $expired_time)
                    ->set('connect_ip', $_SERVER["REMOTE_ADDR"])
                    ->insert(TBL_COMMON_MEMBER_CONNECT_LOG)
                    ->exec();
            }
        } elseif ($connectType == 'logout' || $connectType == 'maintain') {
            // logout: 회원이 로그아웃 버튼 클릭으로 실제 로그아웃 했을때 기록 업데이트
            // maintain : 접속 시간이 유지되는 상태 즉 회원이 사이트 내에서 활동 중일때는 예정된 expired_time 이 증가 됨으로 해당 시간 값을 업데이트 한다.
            $row = $this->qb
                ->select('lo_ix')
                ->from(TBL_COMMON_MEMBER_CONNECT_LOG)
                ->where('code', $code)
                ->where('connect_yn', 'Y')
                ->orderBy('lo_ix','desc')
                ->limit(1)
                ->exec()
                ->getRowArray();

            if (isset($row['lo_ix']) && $row['lo_ix'] > 0) {
                $this->qb
                    ->set('expired_time', date('Y-m-d H:i:s'))
                    ->where('code', $code)
                    ->where('lo_ix', $row['lo_ix'])
                    ->update(TBL_COMMON_MEMBER_CONNECT_LOG)
                    ->exec();
            }
        }
    }
}