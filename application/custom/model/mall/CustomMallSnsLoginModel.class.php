<?php

/**
 * Description of CustomMallSnsLoginModel
 *
 * @author hoksi
 */
class CustomMallSnsLoginModel extends ForbizModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 세션에 저장된 SNS 정보를 리셋한다.
     */
    public function resetSnsInfo()
    {
        $_SESSION['sns_login'] = [];
    }

    /**
     * 등록된 SNS ID인지 확인한다.
     * @param string $sns_type SNS 타입
     * @param string $sns_id SNS ID
     * @return boolean
     */
    public function existsSnsId($sns_type, $sns_id)
    {
        return $this->qb
                ->select('uid')
                ->from(TBL_SNS_INFO)
                ->where('sns_type', $sns_type)
                ->where('sns_id', $sns_id)
                ->getCount() > 0;
    }

    /**
     * SNS 정보를 이용하여 UserCode 조회
     * @param string $sns_type
     * @param string $sns_id
     * @return boolean | string
     */
    public function getUserCode($sns_type, $sns_id)
    {
        $row = $this->qb
            ->select('uid')
            ->from(TBL_SNS_INFO)
            ->where('sns_type', $sns_type)
            ->where('sns_id', $sns_id)
            ->exec()
            ->getRow();

        return isset($row->uid) ? $row->uid : false;
    }

    /**
     * SNS 정보를 이용하여 로그인에 필요한 정보 조회
     * @param string $sns_type
     * @param string $sns_id
     * @return string
     */
    public function getUserId($sns_type, $sns_id)
    {

        if (ForbizConfig::getPrivacyConfig('sleep_user_yn') == 'Y') {
            $sql = $this->qb
                    ->select('m.id')
                    ->from(TBL_SNS_INFO.' AS s')
                    ->join(TBL_COMMON_USER.' AS m', 's.uid = m.code')
                    ->where('sns_id', $sns_id)
                    ->where('sns_type', $sns_type)
                    ->toStr()
                . ' UNION '
                . $this->qb
                    ->select('m.id')
                    ->from(TBL_SNS_INFO.' AS s')
                    ->join(TBL_COMMON_USER_SLEEP.' AS m', 's.uid = m.code')
                    ->where('sns_id', $sns_id)
                    ->where('sns_type', $sns_type)
                    ->toStr();

            $row = $this->qb->exec($sql)->getRowArray();
        } else {
            $row = $this->qb
                ->select('m.id')
                ->from(TBL_SNS_INFO.' AS s')
                ->join(TBL_COMMON_USER.' AS m', 's.uid = m.code')
                ->where('sns_id', $sns_id)
                ->where('sns_type', $sns_type)
                ->exec()
                ->getRowArray();
        }


        return isset($row['id']) ? $row['id'] : false;
    }

    /**
     * SNS 정보를 업데이트 한다.
     * @param string $sns_type
     * @param string $sns_id
     * @param string $sns_profile
     * @param string $userCode
     * @return string
     */
    public function replaceSnsInfo($sns_type, $sns_id, $sns_profile, $userCode = false)
    {
        $isExists = $this->existsSnsId($sns_type, $sns_id);

        $this->qb
            ->set('sns_type', $sns_type)
            ->set('sns_id', $sns_id)
            ->set('sns_profile', is_string($sns_profile) ? $sns_profile : json_encode($sns_profile))
            ->set('sns_connect_date', date('Y-m-d H:i:s'));

        if ($userCode) {
            $this->qb->set('uid', $userCode);
        }

        if ($isExists) {
            $ret = $this->qb
                ->where('sns_type', $sns_type)
                ->where('sns_id', $sns_id)
                ->update(TBL_SNS_INFO)
                ->exec();
        } else {
            $ret = $this->qb
                ->insert(TBL_SNS_INFO)
                ->exec();
        }

        return $ret;
    }

    /**
     * 네이버 로그인 생성
     * @return string
     */
    public function getNaverLoginIcon()
    {
        $this->resetSnsInfo();

        $client_id   = NAVER_CLIENT_ID;
        $redirectURI = urlencode(NAVER_CALLBACK_URL);
        $state       = rand();
        $apiURL      = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;

        if (getAppType() !== false) {
            $apiURL = "javascript:window.open('{$apiURL}');";
        }

        return $apiURL;
    }

    /**
     * 네이버 회원 정보 조회
     * @return boolean | array
     */
    public function getNaverProfile()
    {
        $token = sess_val('sns_login', 'naver', 'access_token');
        if ($token) {
            $token       = $token;
            $header      = "Bearer ".$token; // Bearer 다음에 공백 추가
            $url         = "https://openapi.naver.com/v1/nid/me";
            $is_post     = false;
            $ch          = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $is_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers     = array();
            $headers[]   = "Authorization: ".$header;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response    = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return json_decode($response, true);
        }

        return false;
    }

    /**
     * 네이버 접근 토큰 삭제
     */
    public function naver_delete(){

        $sns_type = 'naver';

        // 네이버 로그인 콜백
        $client_id     = NAVER_CLIENT_ID;
        $client_secret = NAVER_CLIENT_SECRET;
        $access_token  = $_SESSION['sns_login'][$sns_type]['access_token'];
        if($access_token) {
            $redirectURI = urlencode(NAVER_CALLBACK_URL);
            $url = "https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=" . $client_id . "&client_secret=" . $client_secret . "&access_token=" . $access_token . "&service_provider=NAVER";

            $is_post = false;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $is_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $response = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        }
    }

    /**
     * 페이스북 로그인
     * @param string $type 타입
     * @return string
     */
    public function getFacebookLoginIcon()
    {
        $this->resetSnsInfo();

        $fb = new Facebook\Facebook([
            'app_id' => FACEBOOK_APP_ID,
            'app_secret' => FACEBOOK_APP_SECRET,
            'default_graph_version' => 'v2.2',
        ]);

        $helper   = $fb->getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl(FACEBOOK_CALLBACK_URL);

        if (getAppType() !== false) {
            $loginUrl = "javascript:window.open('{$loginUrl}');";
        }


        return $loginUrl;
    }

    /**
     * 페이스북 회원 정보 조회
     * @param string $type 타입
     * @return string
     */
    public function getFacebookProfile()
    {
        $access_token = sess_val('sns_login', 'facebook', 'access_token');
        if ($access_token) {
            $fb = new Facebook\Facebook([
                'app_id' => FACEBOOK_APP_ID,
                'app_secret' => FACEBOOK_APP_SECRET,
                'default_graph_version' => 'v2.2',
                'default_access_token' => $access_token
            ]);

            try {
                $me = $fb->get('/me');
            } catch (Exception $e) {
                $response = $e->getMessage();
            }

            if (isset($me)) {
                return ['response' => [
                        'id' => $me->getGraphUser()->getId()
                ]];
            } else {
                return $response;
            }
        } else {
            return false;
        }
    }

    public function getKakaoLoginIcon()
    {

        $this->resetSnsInfo();

        $app_key     = KAKAO_APP_KEY;
        //$state       = rand();
		$state       = $_REQUEST['uri'];
        $redirectURI = KAKAO_CALLBACK_URL;

        $apiURL = "https://kauth.kakao.com/oauth/authorize?client_id={$app_key}&redirect_uri={$redirectURI}&response_type=code&state={$state}";

        if (getAppType() !== false) {
            $apiURL = "javascript:window.open('{$apiURL}');";
        }

        return $apiURL;
    }



    public function getKakaoSyncLogin()
    {
        $this->resetSnsInfo();

        $app_key     = KAKAO_APP_KEY;
        $state       = rand();
        $redirectURI = KAKAO_CALLBACK_URL;

        $apiURL = "https://kauth.kakao.com/oauth/authorize?client_id={$app_key}&redirect_uri={$redirectURI}&response_type=code&prompt=none&state={$state}&auto_login=true";

        return $apiURL;
    }

    public function kakaoPlusFriends(){
        $sns_type = 'kakao';

        $id = $_SESSION['sns_login'][$sns_type]['sns_info']['id'];
        $admin_key = KAKAO_ADMIN_KEY;


        $url     = "https://kapi.kakao.com/v1/api/talk/plusfriends?target_id_type=user_id&target_id=".$id;
        $is_post = false;
        $ch      = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


       // $header      = "Bearer ".$token; // Bearer 다음에 공백 추가
        $header2      = "KakaoAK ".$admin_key;
        $headers     = [
            "Authorization: ".$header2
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $headers     = array();
        $response    = curl_exec($ch);

        print_r($response);
    }

    /**
     * 카카오 채널관계 알림 기록
     */
    public function kakaoChannelCallBack(){

        $data = json_decode(file_get_contents('php://input'), true);

        $this->qb
            ->set('event',$data['event'])
            ->set('user_id',$data['id'])
            ->set('id_type',$data['id_type'])
            ->set('plus_friend_public_id',$data['plus_friend_public_id'])
            ->set('plus_friend_uuid',$data['plus_friend_uuid'])
            ->set('updated_at',$data['updated_at'])
            ->set('updated_at',$data['updated_at'])
            ->set('json_data',json_encode($data))
            ->insert(TBL_KAKAO_CHANNEL_CALL_BACK)
            ->exec();

        //var_dump($data);
        //log_message('error', 'Kakao ChannelCallBack : '.json_encode($data));
    }

    /**
     * 카카오 회원 정보 조회
     * @return boolean | array
     */
    public function getKakaoProfile()
    {
        $token = sess_val('sns_login', 'kakao', 'access_token');
        if ($token) {
            $token       = $token;
            $header      = "Bearer ".$token; // Bearer 다음에 공백 추가
            $url         = "https://kapi.kakao.com/v2/user/me";
            $is_post     = false;
            $ch          = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $is_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers     = [
                "Authorization: ".$header
                , 'Content-type: application/x-www-form-urlencoded;charset=utf-8'
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response    = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return ['response' => json_decode($response, true)];
        }

        return false;
    }

    /**
     * 카카오 배송 정보 조회
     * @return boolean | array
     */
    public function getKakaoShipping()
    {
        $token = sess_val('sns_login', 'kakao', 'access_token');
        if ($token) {
            $token       = $token;
            $header      = "Bearer ".$token; // Bearer 다음에 공백 추가
            $url         = "https://kapi.kakao.com/v1/user/shipping_address";
            $is_post     = false;
            $ch          = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $is_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers     = [
                "Authorization: ".$header
                , 'Content-type: application/x-www-form-urlencoded;charset=utf-8'
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response    = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return ['response' => json_decode($response, true)];
        }

        return false;
    }

    /**
     * 카카오 탈퇴 처리(계정삭제)
     */
    public function kakaoUnlink(){
        $token = sess_val('sns_login', 'kakao', 'access_token');
        if ($token) {
            $token       = $token;
            $header      = "Bearer ".$token; // Bearer 다음에 공백 추가
            $url         = "https://kapi.kakao.com/v1/user/unlink";
            $is_post     = false;
            $ch          = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $is_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers     = [
                "Authorization: ".$header
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response    = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return ['response' => json_decode($response, true)];
        }

        return false;
    }

    public function kakaoLogOut(){
        $token = sess_val('sns_login', 'kakao', 'access_token');
        if ($token) {
            $token       = $token;
            $header      = "Bearer ".$token; // Bearer 다음에 공백 추가
            $url         = "https://kapi.kakao.com/v1/user/logout";
            $is_post     = false;
            $ch          = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $is_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers     = [
                "Authorization: ".$header
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response    = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return ['response' => json_decode($response, true)];
        }

        return false;
    }

    /**
     * SNS를 통하여 로그인 또는 가입을 진행
     * @param string $sns_type
     * @param array $sns_info
     * @return string
     */
    public function doLogin($sns_type, $sns_info)
    {

		// 세션에 SNS 연동 정보 기록
        $_SESSION['sns_login'][$sns_type]['sns_info'] = $sns_info['response'];

        // SNS ID 추출
        $sns_id                                       = $sns_info['response']['id'];

        // 회원코드 조회
        $userCode = $this->getUserCode($sns_type, $sns_id);
        if(isset($_SESSION['gotoUrl'])){
            $res['gotoUrl'] = $_SESSION['gotoUrl'];
            unset($_SESSION['gotoUrl']);
        }else{
			if($sns_info['Direct'] != ""){
				$res['gotoUrl'] = $sns_info['Direct'];
			} else {
				$res['gotoUrl'] = '/';
			}
        }

        $loginCookie['connection_no'] = "";
        $loginCookie['auto_login'] = "";
        $res['loginCookie'] = $loginCookie;

        // 가입된 회원 여부 확인
        if ($userCode) {
            /* @var $memberModel CustomMallMemberModel */
            $memberModel = $this->import('model.mall.member');

            // SNS 정보 갱신
            $this->replaceSnsInfo($sns_type, $sns_id, $sns_info, $userCode);
            // 로그인 정보 조회
            $userId = $this->getUserId($sns_type, $sns_id);
            $userCode = $this->getUserCode($sns_type, $sns_id);
            log_message('error', 'Kakao login code : id: '.$sns_id.' uid: '.$userId.' code: '.$userCode);
            $res['userId'] = $userId;
            $res['userCode'] = $userCode;

            // 로그인
            $memberModel->doLogin($userId, $sns_id);

        } else {
            // 미가입 회원
			//print_r($_GET);
			//exit;

			$state = json_decode($_REQUEST['state']);

			$utm_source = $state->utm_source;
			$utm_medium = $state->utm_medium;

			if($utm_source != "" && $utm_medium != ""){
				$res['gotoUrl'] = '/member/joinInput?kakaoOk=ok&utm_source='.$utm_source.'&utm_medium='.$utm_medium;
			} else{
				$res['gotoUrl'] = '/member/joinInput';
			}
        }

        return $res;
    }

    /**
     * 연동된 SNS 타입
     * @return string
     */
    public function getSnsType()
    {
        if (isset($_SESSION['sns_login']['naver'])) {
            return 'naver';
        } elseif (isset($_SESSION['sns_login']['facebook'])) {
            return 'facebook';
        } elseif (isset($_SESSION['sns_login']['kakao'])) {
            return 'kakao';
        } elseif (isset($_SESSION['sns_login']['google'])) {
            return 'google';
        }

        return '';
    }

    /**
     * 연동된 SNS ID
     * @return boolean | string
     */
    public function getSnsId()
    {
        $sns_type = $this->getSnsType();

        if ($sns_type) {
            return sess_val('sns_login', $sns_type, 'sns_info', 'id');
        }

        return false;
    }

    /**
     * 무작위 user id 생성
     * @param string $sns_type
     * @param int $len
     * @return string
     */
    public function makeSnsRandId($sns_type = false, $len = 10)
    {
        $sns_type = $sns_type == false ? $this->getSnsType() : $sns_type;

        if ($sns_type == 'naver') {
            $prefix = 'nh';
        } elseif ($sns_type == 'facebook') {
            $prefix = 'fa';
        } elseif ($sns_type == 'kakao') {
            $prefix = 'ka';
        } elseif ($sns_type == 'google') {
            $prefix = 'go';
        } else {
            $prefix = '';
        }

        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return $prefix.'@'.substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
    }

    /**
     * SNS 정보를 업데이트한다.
     * @param string $userCode
     */
    public function updateSnsInfo($userCode)
    {
        $sns_type = $this->getSnsType();

        switch ($sns_type) {
            case 'naver' :
                $sns_info = $this->getNaverProfile();
                break;
            case 'facebook':
                $sns_info = $this->getFacebookProfile();
                break;
            case 'kakao':
                $sns_info = $this->getKakaoProfile();
                break;
        }

        if (isset($sns_info['response']['id'])) {
            $sns_id = $sns_info['response']['id'];

            $this->replaceSnsInfo($sns_type, $sns_id, $sns_info, $userCode);
        }

        return true;
    }

    /**
     * 회원가입 시 SNS 정보 배열 정리
     */
    public function getAlangeMemberInfo($snsType, $data){
        $res = array();

        if($snsType == 'naver'){
            $res['distinctId'] = $data['sns_info']['id'];
        }else if($snsType == 'kakao'){
            $res['distinctId'] = $data['sns_info']['id'];

            if(isset($data['sns_info']['kakao_account']['email'])){
                $email = $data['sns_info']['kakao_account']['email'];
            }

            if(isset($data['sns_info']['kakao_account']['profile']['nickname'])){
                $res['userName'] = $data['sns_info']['kakao_account']['profile']['nickname'];
            }
            if(isset($data['sns_info']['kakao_account']['phone_number'])){
                $phone_number = $data['sns_info']['kakao_account']['phone_number'];
                $phoneCheckArr = explode(' ',$phone_number);
                $phoneArr = explode('-',$phoneCheckArr[1]);
                $res['pcs1'] = "0".$phoneArr[0];
                $res['pcs2'] = $phoneArr[1];
                $res['pcs3'] = $phoneArr[2];
            }

            if(isset($data['sns_info']['kakao_account']['gender'])){
                $gender = $data['sns_info']['kakao_account']['gender'];
                if($gender == 'male'){
                    $res['gender'] = "M";
                }else{
                    $res['gender'] = "W";
                }
            }
            if(isset($data['sns_info']['kakao_account']['birthday_type'])){
                $birthday_type = $data['sns_info']['kakao_account']['birthday_type'];
                if($birthday_type == 'SOLAR'){
                    $res['birthdayDiv'] = "1";
                }else{
                    $res['birthdayDiv'] = "0";
                }
            }

            if(isset($data['sns_info']['kakao_account']['birthyear'])){
                $res['birthYearText'] = $data['sns_info']['kakao_account']['birthyear'];
            }
            if(isset($data['sns_info']['kakao_account']['birthday'])){
                $birthday = $data['sns_info']['kakao_account']['birthday'];
                $res['birthMonthText'] = substr($birthday,0,2);
                $res['birthDayText'] = substr($birthday,2,2);
            }

            if(isset($data['sns_info']['shipping_addresses'])){
                foreach($data['sns_info']['shipping_addresses'] as $key=>$val){
                    if($val['default'] == '1'){
                        $res['zip'] = $val['zone_number'];
                        $res['addr1'] = $val['base_address'];
                        $res['addr2'] = $val['detail_address'];
                    }
                }
            }
//
//            $res['distinctId'] = $data['sns_info']['kakao_account']['email'];
//            $res['distinctId'] = $data['sns_info']['kakao_account']['email'];
        }else if($snsType == 'facebook'){
           // $email = $data['sns_info']['email'];
            $res['distinctId'] = $data['sns_info']['id'];
        }else if($snsType == 'google'){
            $res['distinctId'] = $data['sns_info']['sub'];
        }

        if(!empty($email)){
            $emailArr = explode('@',$email);
            $res['emailId'] = $emailArr[0];
            $res['emailHost'] = $emailArr[1];
        }

        return $res;
    }
}