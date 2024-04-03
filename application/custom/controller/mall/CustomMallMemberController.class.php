<?php

/**
 * Description of ForbizMallMemberController
 *
 * @author hoksi
 *
 * @property CustomMallSnsLoginModel $snsLoginModel Sns 연동 모델
 */
class CustomMallMemberController extends ForbizMallMemberController
{
    protected $snsLoginModel;

    public function __construct()
    {
        parent::__construct();

        $this->snsLoginModel = $this->import('model.mall.snsLogin');
    }

    /**
     * 구글 로그인 콜백
     */
    public function google()
    {
        $sns_type = 'google';

        $id_token = $this->input->get('id_token');
        if(!empty($id_token)) {
            $client = new Google_Client(['client_id' => GOOGLE_CLIENT_ID]);
            $response = $client->verifyIdToken($id_token);
            $response['id'] = $response['sub'];
        }else {
            //APP일경우 client 조회 후 값이 들어옴, 우선 필요값만 받음.
            $response['sub'] = $this->input->get('id');
            $response['id'] = $this->input->get('id');
            $response['email'] = $this->input->get('email');
            $response['name'] = $this->input->get('name');
        }

        if ($response) {
            $sns_info['response'] = $response;
            $loginInfo = $this->snsLoginModel->doLogin($sns_type, $sns_info);
            $this->snsProcess($loginInfo, $sns_type);
        } else {
            // Invalid ID token
            $_SESSION['sns_login']['error'] = $response;
            // SNS Login 에러 처리
            log_message('debug', 'Google login Error : '.$response);
            redirect('/member/login');
        }


    }

    public function snsProcess($loginInfo, $sns_type) {

        $gotoUrl = $loginInfo['gotoUrl'];
        $appType = getAppType();
        if ($appType !== false) {
            if(empty($loginInfo['userId'])) $loginInfo['userId'] = '';
            if(empty($loginInfo['userCode'])) $loginInfo['userCode'] = '';
            echo "<script>
                                var obj = {};
                                obj['userId'] = '".$loginInfo['userId']."';
                                obj['userCode'] = '".$loginInfo['userCode']."';
                                obj['cookieInfo'] = {};
                                obj['cookieInfo']['connection_no'] = '".$loginInfo['loginCookie']['connection_no']."';
                                obj['cookieInfo']['auto_login'] = '".$loginInfo['loginCookie']['auto_login']."';
                            </script>";
            if($appType == 'Android'){
                echo "<script>
                                    window.JavascriptInterface.loginSuccess(JSON.stringify(obj));
                                    window.JavascriptInterface.loadUrl('".$gotoUrl."');
                                </script>";
            }else if($appType == 'iOS') {
                echo "<script>
                            window.webkit.messageHandlers.loginSuccess.postMessage(JSON.stringify(obj));
                            window.webkit.messageHandlers.loadUrl.postMessage('".$gotoUrl."');
                        </script>";
            }
            exit("<script>window.close();</script>");
        } else {
            redirect($gotoUrl);
        }
    }

    /**
     * 페이스북 로그인 콜백
     */
    public function facebook()
    {
        $sns_type = 'facebook';

        $fb = new Facebook\Facebook([
            'app_id' => FACEBOOK_APP_ID,
            'app_secret' => FACEBOOK_APP_SECRET,
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Exception $e) {
            $response = $e->getMessage();
        }

        if (isset($accessToken)) {
            $_SESSION['sns_login'][$sns_type]['access_token'] = $accessToken->getValue();

            if ($this->getFlashData('sns_test') == $sns_type) {
                redirect('/tests/facebook.php/GetProfile');
            } else {
                $sns_info = $this->snsLoginModel->getFacebookProfile();
                // SNS 정보 조회되었나?
                if (isset($sns_info['response']['id'])) {
                    $loginInfo = $this->snsLoginModel->doLogin($sns_type, $sns_info);
                    $this->snsProcess($loginInfo, $sns_type);
                } else {
                    $response = json_encode($sns_info);
                }
            }
        } else {
            $_SESSION['sns_login']['error'] = $response;
        }

        // SNS Login 에러 처리
        log_message('debug', 'Facebook login Error : '.$response);
        if (getAppType() !== false) {
            exit("<script>opener.document.location.replace('/member/login');\nwindow.close();</script>");
        } else {
            redirect('/member/login');
        }


    }

    /**
     * 네이버 로그인 콜백
     */
    public function naver()
    {
        $sns_type = 'naver';

        // 네이버 로그인 콜백
        $client_id     = NAVER_CLIENT_ID;
        $client_secret = NAVER_CLIENT_SECRET;
        $code          = $this->input->get("code");
        $state         = $this->input->get("state");
        $redirectURI   = urlencode(NAVER_CALLBACK_URL);
        $url           = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$code."&state=".$state;
        $is_post       = false;
        $ch            = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers     = array();
        $response    = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status_code == 200) {
            $_SESSION['sns_login'][$sns_type] = json_decode($response, true);
        } else {
            $_SESSION['sns_login']['error'] = $response;
        }

        if ($this->getFlashData('sns_test') == $sns_type) {
            redirect('/tests/naver.php/GetProfile');
        } elseif ($status_code == 200 && isset($_SESSION['sns_login'][$sns_type]['access_token'])) {
            $sns_info = $this->snsLoginModel->getNaverProfile();

            $userCheck = $sns_info['response'];
            $userCheckBool = true;

            #필수 항목 체크가 필요 할 경우 아래 정보를 사용하여 처리 함
//            $userCheckData = array('id','gender','email','name','birthday');
//            if(is_array($userCheck) && count($userCheck) > 0){
//                foreach($userCheckData as $key=>$val){
//                    if(empty($userCheck[$val])){
//                        $userCheckBool = false;
//                    }
//                }
//            }else{
//                $userCheckBool = false;
//            }

            if($userCheckBool === false){
                $this->snsLoginModel->naver_delete();
                $failUrl = "/member/joinEnd/fail";
                if (getAppType() !== false) {
                    exit("<script>opener.document.location.replace('{$failUrl}');\nwindow.close();</script>");
                } else {
                    redirect($failUrl);
                }
            }else{
                // SNS 정보 조회되었나?
                if (isset($sns_info['response']['id'])) {
                    $loginInfo = $this->snsLoginModel->doLogin($sns_type, $sns_info);;
                    $this->snsProcess($loginInfo, $sns_type);
                } else {
                    $response = json_encode($sns_info);
                    // SNS Login 에러 처리
                    log_message('debug', 'Naver login Error : '.$response);
                    if (getAppType() !== false) {
                        exit("<script>opener.document.location.replace('/member/login');\nwindow.close();</script>");
                    } else {
                        redirect('/member/login');
                    }
                }
            }
        } else {
            redirect('/member/login');
        }
    }


    /**
     * 카카오 로그인 콜백
     */
    public function kakao()
    {
/*echo $_REQUEST['state'];
echo "<hr>";
echo $this->input->get("state");
exit;*/
        if($this->input->get("error") == 'access_denied'){
            exit("<script>alert('동의 취소하셨습니다.');document.location.replace('/member/login');</script>");
        }

        $sns_type = 'kakao';

        // 네이버 로그인 콜백
        $app_key    = KAKAO_APP_KEY;
        $app_secret = KAKAO_APP_SECRET;

        $post_data = http_build_query([
            'code' => $this->input->get("code")
            , 'grant_type' => 'authorization_code'
            , 'client_id' => $app_key
            , 'client_secret' => $app_secret
            , 'redirect_uri' => KAKAO_CALLBACK_URL
        ]);

        $url     = "https://kauth.kakao.com/oauth/token";
        $is_post = true;
        $ch      = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers     = array();
        $response    = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status_code == 200) {
            $_SESSION['sns_login'][$sns_type] = json_decode($response, true);
        } else {
            $_SESSION['sns_login']['error'] = $response;
        }

        if ($this->getFlashData('sns_test') == $sns_type) {
            redirect('/tests/kakao.php/GetProfile');
        } elseif ($status_code == 200 && isset($_SESSION['sns_login'][$sns_type]['access_token'])) {
            $sns_info = $this->snsLoginModel->getKakaoProfile();
            $shipping_info = $this->snsLoginModel->getKakaoShipping();
            $sns_info['response']['shipping_addresses'] = $shipping_info['response']['shipping_addresses'];

            // SNS 정보 조회되었나?
            if (isset($sns_info['response']['id'])) {
				if(strpos($this->input->get("state"),'ok') !== false){
					$DirectURL			= explode("?",$this->input->get("state"));
					$sns_info['Direct'] = $DirectURL[0];
				}
                $loginInfo = $this->snsLoginModel->doLogin($sns_type, $sns_info);
                $this->snsProcess($loginInfo, $sns_type);
            }else {
                // SNS Login 에러 처리
                log_message('error', 'Kakao login Error : '.$response);

                if (getAppType() !== false) {
                    exit("<script>opener.document.location.replace('/member/login');window.close();</script>");
                } else {
                    redirect('/member/login');
                }
            }
        }else{

            $_SESSION['kakaoNotUser'] = true;
            if(isset($_SESSION['gotoUrl'])){
                $res['gotoUrl'] = $_SESSION['gotoUrl'];
                unset($_SESSION['gotoUrl']);
                redirect($_SESSION['gotoUrl']);
            }else{
                redirect('/');
            }
        }
    }

    /**
     * 외부 가입/로그인 유도시 (QR 및 챗봇) 로그인/회원가입 URL 즉시 연결
     * URI : {도메인}/controller/member/kakaoDirectLogin
     */
    public function kakaoDirectLogin(){
        $url = $this->snsLoginModel->getKakaoLoginIcon();
        redirect($url);
    }

    /**
     * 카카오 채널 추가 여부 확인 (구 카카오 플러스친구)
     * 해당 기능을 사용하기 위해서는 카카오개발자센터 내 (내 애플리케이션 -> 동의항목 -> 카카오톡 채널 추가 상태 및 내역 이 필수또는선택으로 지정되어 있어야 사용가능
     * URI : {도메인}/controller/member/kakaoPlusFriends
     */
    public function kakaoPlusFriends(){
        //

        $friend = $this->snsLoginModel->kakaoPlusFriends();
        print_r($friend);
    }

    /**
     * 카카오 채널관계 알림 받기
     * URI : {도메인}/controller/member/kakaoChannelCallBack
     */
    public function kakaoChannelCallBack(){
        $headers = apache_request_headers();
        $Authorization = $headers['Authorization'];
        $AuthArr = explode(' ',$Authorization);
        if($AuthArr[0] == 'KakaoAK'){
            $KakaoAK = trim($AuthArr[1]);
        }

        $adminKey = KAKAO_ADMIN_KEY;

        if($adminKey == $KakaoAK ) {
            $this->snsLoginModel->kakaoChannelCallBack();
        }
    }


    /**
     * 카카오 연결끊기 알림 (회원 탈퇴 처리)
     */

    public function kakaoDeRegister(){
        $headers = apache_request_headers();
        $Authorization = $headers['Authorization'];
        $AuthArr = explode(' ',$Authorization);
        if($AuthArr[0] == 'KakaoAK'){
            $KakaoAK = trim($AuthArr[1]);
        }
        $user_id = $this->input->get("user_id");
        $referrer_type = $this->input->get("referrer_type");

        $adminKey = KAKAO_ADMIN_KEY;

        if($adminKey == $KakaoAK ){
            /* @var $orderModel CustomMallOrderModel */
            $orderModel = $this->import('model.mall.order');

            /* @var $orderModel CustomMallMileageModel */
            $mileageModel = $this->import('model.mall.mileage');

            // SNS 정보 여부 확인
            $sns_data = $this->qb
                ->from(TBL_SNS_INFO)
                ->where('sns_id', $user_id)
                ->exec()->getRowArray();
            if(isset($sns_data['uid'])) {

                $user_data = $this->qb
                    ->select('cu.id')
                    ->select('cu.mem_type')
                    ->select('cu.code')
                    ->decryptSelect('cmd.name')
                    ->decryptSelect('cmd.mail')
                    ->decryptSelect('cmd.pcs')
                    ->from(TBL_COMMON_USER ." as cu")
                    ->join(TBL_COMMON_MEMBER_DETAIL ." as cmd",'cu.code = cmd.code','inner')
                    ->where('cu.code', $sns_data['uid'])
                    ->exec()->getRowArray();

                if(isset($user_data['code'])) {
                    // 트랜잭션 시작
                    $this->qb->transStart();
                    // 탈퇴회원 등록
                    $this->qb
                        ->set('code', $user_data['code'])
                        ->set('id', $user_data['id'])
                        ->set('mem_type', $user_data['mem_type'])
                        ->set('reason', $referrer_type)
                        ->set('message', '카카오 연결해제 요청 처리건')
                        ->set('dropdate', date('Y-m-d H:i:s'))
                        ->set('name', $user_data['name'])
                        ->set('email', $user_data['mail'])
                        ->insert(TBL_COMMON_DROPMEMBER)
                        ->exec();

                    // 회원 정보 삭제
                    $this->qb
                        ->where('code', $user_data['code'])
                        ->delete(TBL_COMMON_USER)
                        ->exec();

                    // 회원 상세 정보 삭제
                    $this->qb
                        ->where('code', $user_data['code'])
                        ->delete(TBL_COMMON_MEMBER_DETAIL)
                        ->exec();

                    // 회원 탈퇴시 개인정보 관련 처리
                    $orderModel->withdrawOrderProcess($user_data['code']);

                    //회원 탈퇴시 마일리지 소멸
                    $mileageModel->withdrawExtinctionMileage($user_data['code']);

                    // 트랜잭션 Complete
                    $this->qb->transComplete();

                    // SNS 정보 삭제
                    $this->qb
                        ->where('uid', $user_data['code'])
                        ->delete(TBL_SNS_INFO)
                        ->exec();


                    // 이메일 전송 이벤트 호출
                    $this->event->trigger('withdrowMemberSendEmail',
                        [
                            'mem_name' => $user_data['name'],
                            'mem_mail' => $user_data['mail'],
                            'mem_id' => $user_data['id'],
                            'mem_mobile' => $user_data['pcs'],
                            'msg_code' => '0102',
                            'exit_date' => date('Y-m-d')
                        ]);
                }
            }
        }
        http_response_code(200);
    }

    /**
     * 카카오1초 회원가입
     */
    public function joinInputBasic2()
	{
		$pcs = $_GET['pcs1'].'-'.$_GET['pcs2'].'-'.$_GET['pcs3'];

		// 회원 가입룰
		$memberRegRule = ForbizConfig::getSharedMemory('member_reg_rule');

		$registData['authorized']  = ($memberRegRule['auth_type'] != "A" ? 'N' : 'Y'); //자동 승인 여부
		$registData['agentType']   = (is_mobile() ? 'M' : 'W');
		$registData['name']        = $_GET['userName'];
		$registData['email']       = $_GET['emailId'].'@'.$_GET['emailHost'];
		$registData['pcs']         = $pcs;
		$registData['tel']         = "";
		$registData['birthday']    = sprintf('%s-%s-%s', $_GET['birthYear'], $_GET['birthMonth'], $_GET['birthDay']);
		$registData['birthdayDiv'] = $_GET['birthdayDiv'];
		$registData['info']        = "1";
		$registData['sms']         = "1";
		$registData['collection']  = "1";
		$registData['sexDiv']      = $_GET['gender'];
		$registData['zip']         = $_GET['zip'];
		$registData['addr1']       = $_GET['addr1'];
		$registData['addr2']       = $_GET['addr2'];
		$registData['gpIx']    = DEFAULT_GPIX;
		$registData['memType'] = 'M';
		$registData['date'] = date('Y-m-d H:i:s');
		$registData['area']        = "";
		$registData['kakaoOk']     = $_GET['kakaoOk'];
		$registData['utm_source']  = $_GET['utm_source'];
		$registData['utm_medium']  = $_GET['utm_medium'];

		$registData['userId'] = $this->snsLoginModel->makeSnsRandId();
		$registData['pw']     = $this->snsLoginModel->getSnsId();

		// 회원 가입
		$userCode = $this->memberModel->registMember($registData);

		/*echo "6<hr>";
		print_r($userCode);
		exit;*/

		$this->snsLoginModel->updateSnsInfo($userCode);

		$registData['code'] = $userCode;

		// UserCode set
		$this->setFlashData('userCode', $userCode);

		// 세션 데이타 삭제
		$this->memberModel->resetAuthSession();
		$this->memberModel->resetJoinSession();

		/*
		// 개인정보 동의 로그
		if (is_array($joinData['policy'])) {
			foreach ($joinData['policy'] as $piIx) {
				//해당 부분은 이벤트가 아닌 바로 모델로 처리 필요
				$this->event->emmit('insertAgreementHistory', [
					'piIx' => $piIx,
					'userCode' => $userCode,
					'userId' => $registData['userId'],
					'name' => $registData['name'],
					'memType' => 'M'
				]);
			}
		}
		*/

		// 자동승인 여부에 따라 로그인 처리
		if ($registData['authorized'] == 'Y') {
			$this->setFlashData('doLoginInfo',
				[
				'userId' => $registData['userId']
				, 'userPw' => $registData['pw']
				, 'userPcs' => $registData['pcs']
			]);
		}

		return ['user' => $registData];
		//redirect('/member/joinEnd');
	}

    public function joinInputBasic()
    {

        // SNS 연동인가?
        $sns_login = sess_val('sns_login');
        $isSns = isset($_SESSION['sns_login']);

        // SNS 연동
        if ($isSns && (is_array($sns_login) && count($sns_login) > 0)) {
			$chekField = [
				'userName',
				//'gender',
				//'zip','addr1','addr2',
				'emailId', 'emailHost',
				'pcs1', 'pcs2', 'pcs3',
			];
		} else if(BASIC_LANGUAGE == 'english'){
			// 입력 필수 항목
			$chekField = [
				'userId', 'pw', 'comparePw',
				'userName',
				'zip','addr1','addr2',
				'emailId', 'emailHost',
				'national_phone', 'pcs',
			];
		} else {
			// 입력 필수 항목
			$chekField = [
				'userId', 'pw', 'comparePw',
				'userName',
				//'zip','addr1','addr2',
				'emailId', 'emailHost',
				'pcs1', 'pcs2', 'pcs3',
			];
		}
		
        // 필수 항목 점검
        if (form_validation($chekField)) {
            // 인증데이타
            $authData = $this->memberModel->getAuthSessionData();
            //가입 데이터 (type, policy, receive)
            $joinData = $this->memberModel->getJoinSession();
            // 휴대폰 번호
            if(BASIC_LANGUAGE == 'english'){
                $pcs = $this->input->post('national_phone')."-".$this->input->post('pcs');
            }else{
                $pcs = $this->input->post('pcs1').'-'.$this->input->post('pcs2').'-'.$this->input->post('pcs3');
            }

			// 비밀번호 유효성 저장시 체크
			$pw             = $this->input->post('pw');
			$comparePw      = $this->input->post('comparePw');

			$num            = preg_match('/[0-9]/u', $pw);                                  // 숫자체크
			$eng            = preg_match('/[a-z]/u', $pw);                                  // 소문자체크
			$caEng          = preg_match('/[A-Z]/u', $pw);                                  // 대문자체크
			$spe            = preg_match("/[\!\@\#$\%\^\&\*\(\)\_\+\~]/u",$pw);             // 특수문자 => 해당기호만 !@#$%^&*()_+~

			$eng = $eng + $caEng;

			if($eng >= 1){
				$eng = 1;
			}

			$pwSum          = $num + $eng + $spe;                                           // 영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합 확인

			$compareNum     = preg_match('/[0-9]/u', $comparePw);                           // 숫자체크(비밀번호확인)
			$compareEng     = preg_match('/[a-z]/u', $comparePw);                           // 소문자체크(비밀번호확인)
			$compareCaEng   = preg_match('/[A-Z]/u', $comparePw);                           // 대문자체크(비밀번호확인)
			$compareSpe     = preg_match("/[\!\@\#$\%\^\&\*\(\)\_\+\~]/u",$comparePw);      // 특수문자(비밀번호확인) => 해당기호만 !@#$%^&*()_+~

			$compareEng = $compareEng + $compareCaEng;

			if($compareEng >= 1){
				$compareEng = 1;
			}

			$compareSum     = $compareNum + $compareEng + $compareSpe;                      // 영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합 확인(비밀번호확인)

			$pwCnt          = strlen($pw);                                                  // 비밀번호 갯수
			$comparePwCnt   = strlen($comparePw);                                           // 비밀번호 확인 갯수

			if ($isSns && (is_array($sns_login) && count($sns_login) > 0)) {
			}else {

				if($pw == $comparePw) {
					if($pwCnt>=8 && $pwCnt<=16){
						if($pwSum > 1){
							/*echo "<script>alert('정상완료');</script>";
							$this->setResponseResult('doubleId');
							$resultMessage = "가입완료";
							$result = "Y";*/
						} else {
							/*exit("<script>alert('영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합하여 최소 8자~최대 16자로 입력해 주세요.');</script>");
							$resultMessage = "영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합하여 최소 8자~최대 16자로 입력해 주세요.";
							$result = "N";*/
							$this->setResponseResult('false');
						}
					} else{
						/*exit("<script>alert('영문+숫자+특수문자를 조합하여 8~20자리로 입력해 주세요.');</script>");
						$resultMessage = "영문+숫자+특수문자를 조합하여 8~20자리로 입력해 주세요.";
						$result = "N";*/
						$this->setResponseResult('false');
					}
				} else {
					/*exit("<script>alert('비밀번호와 비밀번호확인이 일치하지 않습니다.');</script>");
					$resultMessage = "영문+숫자+특수문자를 조합하여 8~20자리로 입력해 주세요.";
					$result = "N";*/
					$this->setResponseResult('false');
				}
			}
			// // 비밀번호 유효성 저장시 체크

           /*
             * 아이디 중복 체크
             * 일반 회원인지 확인
             * 인증 데이터 체크
             * 가입 데이터 (type, policy, receive) 체크
             */
            if (!$this->memberModel->checkUserId(trim($this->input->post('userId')))) {
                // 사용자 ID 중복됨
                $this->setResponseResult('doubleId');
            } elseif (!isset($joinData['type']) || ($joinData['type'] != 'B' && $joinData['type'] != 'F1')) {
                // 인증데이터 없음
                $this->setResponseResult('sessionIssue');
            /*} elseif ($this->memberModel->pcsExists($pcs)) {
                // 휴대폰 번호 중복됨
                $this->setResponseResult('existsPcs');*/
            } else {
                // 회원 가입룰
                $memberRegRule = ForbizConfig::getSharedMemory('member_reg_rule');

                $registData['authorized']  = ($memberRegRule['auth_type'] != "A" ? 'N' : 'Y'); //자동 승인 여부
                $registData['agentType']   = (is_mobile() ? 'M' : 'W');
                $registData['name']        = $this->input->post('userName');
                $registData['email']       = $this->input->post('emailId').'@'.$this->input->post('emailHost');
                $registData['pcs']         = $pcs;
                $registData['ci']          = md5($registData['email']);
                $registData['di']          = md5(str_replace('-', '', $registData['pcs']));
                $registData['birthday']    = sprintf('%s-%s-%s', $this->input->post('birthYear'), $this->input->post('birthMonth'), $this->input->post('birthDay'));
                $registData['birthdayDiv'] = $this->input->post('birthdayDiv');
                $registData['info']        = $this->input->post('email');
                $registData['sms']         = $this->input->post('sms');
				$registData['collection']  = $this->input->post('collection');
                $registData['tel']         = $this->input->post('tel1').'-'.$this->input->post('tel2').'-'.$this->input->post('tel3');
                $registData['sexDiv']      = $this->input->post('gender');
                $registData['zip']         = $this->input->post('zip');
                $registData['addr1']       = $this->input->post('addr1');
                $registData['addr2']       = $this->input->post('addr2');
                $registData['area']        = $this->input->post('area');

                if(BASIC_LANGUAGE == 'english'){
                    $registData['gpIx']    = GLOBAL_DEFAULT_GPIX;
                    $registData['country'] = $this->input->post('country');
                    $registData['city']    = $this->input->post('city');
                    $registData['state']   = $this->input->post('state');
                    $registData['memType'] = 'F';
                }else{
                    $registData['gpIx']    = DEFAULT_GPIX;
                    $registData['memType'] = 'M';
                }

                $registData['date'] = date('Y-m-d H:i:s');

                // SNS 연동 확인
                if ($isSns && (is_array($sns_login) && count($sns_login) > 0)) {
                    $registData['userId'] = $this->snsLoginModel->makeSnsRandId();
                    $registData['pw']     = $this->snsLoginModel->getSnsId();
                } else {
                    $registData['userId'] = trim($this->input->post('userId'));
                    $registData['pw']     = $this->input->post('pw');
                }
//                echo $isSns.'/';
//                echo is_array($sns_login).'/';
//                echo count($sns_login).'/';
//                print_r($registData);


                // 회원 가입
                $userCode = $this->memberModel->registMember($registData);

                // SnsInfo update
                if ($isSns) {
                    if(!empty($_SESSION['sns_login']['google'])) {
                        $this->snsLoginModel->replaceSnsInfo('google', $_SESSION['sns_login']['google']['sns_info']['sub'], $_SESSION['sns_login']['google'], $userCode);
                    }else {
                        $this->snsLoginModel->updateSnsInfo($userCode);
                    }
                }

                $registData['code'] = $userCode;

                // UserCode set
                $this->setFlashData('userCode', $userCode);

                // 세션 데이타 삭제
                $this->memberModel->resetAuthSession();
                $this->memberModel->resetJoinSession();

                /*
                // 개인정보 동의 로그
                if (is_array($joinData['policy'])) {
                    foreach ($joinData['policy'] as $piIx) {
                        //해당 부분은 이벤트가 아닌 바로 모델로 처리 필요
                        $this->event->emmit('insertAgreementHistory', [
                            'piIx' => $piIx,
                            'userCode' => $userCode,
                            'userId' => $registData['userId'],
                            'name' => $registData['name'],
                            'memType' => 'M'
                        ]);
                    }
                }
                */

                // 자동승인 여부에 따라 로그인 처리
                if ($registData['authorized'] == 'Y') {
                    $this->setFlashData('doLoginInfo',
                        [
                        'userId' => $registData['userId']
                        , 'userPw' => $registData['pw']
                        , 'userPcs' => $registData['pcs']
                    ]);
                }

                return ['user' => $registData];
            }
        } else {
            log_message('error', validation_errors());
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 휴대폰 인증 번호 발송
     */
    public function certiReq()
    {
        if (form_validation(['pcs'])) {
            //인증 확인
            $certi_num = $this->memberModel->doCertiReq($this->input->post('pcs'));

            if ($certi_num == 'existPcs') {
                // 등록된 번호
                $this->setResponseResult($certi_num);
                $this->setFlashData('ForbizCertiNum', rand(111111, 999999));
            } else {
                // 등록되지 않은 번호
                $this->setFlashData('ForbizCertiNum', $certi_num);
                $this->setResponseResult('success');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 휴대폰 인증 번호 발송
     * 아이디 찾기
     * 비밀번호 찾기
     */
    public function certiSearchReq()
    {
        $chkList = ['pcs', 'name','id'];

        if (form_validation($chkList)) {
            //인증 확인
            $checkMember = $this->memberModel->doCertiSearchReq($this->input->post('id'),$this->input->post('name'),$this->input->post('pcs'));

            if($checkMember['code'] == 'success'){
                // 등록된 번호로 인증번호 발송함
                log_message('error',$checkMember['certifyNum']);
                $this->setFlashData('ForbizCertiNum', $checkMember['certifyNum']);
                $this->setResponseResult('success');
            }else if($checkMember['code'] == 'snsMember'){
                // SNS 간편로그인 회원, 아이디/패스워드 조회 제공 안함
                $this->setResponseResult($checkMember['code'])->setResponseData($checkMember['login_type']);
                $this->setFlashData('ForbizCertiNum', $checkMember['code']);
            }else if($checkMember['code'] == 'notExistPcs'){
                // 등록되지 않은 번호임
                $this->setResponseResult($checkMember['code']);
                $this->setFlashData('ForbizCertiNum', rand(111111, 999999)); // reset 처리
            }else{
                $this->setResponseResult('fail');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 이메일 인증 번호 발송
     * 비밀번호 찾기
     */
    public function certiSearchReqByEmail()
    {
        if(BASIC_LANGUAGE == 'english'){

            $chekField = [
                'userEmail', 'userId'
            ];
        }else{

            $chekField = [
                'userEmail', 'userName', 'userId'
            ];
        }

        if (form_validation($chekField)) {

            // 이메일 등록여부 체크: by 아이디, 이름, 이메일
            $result = $this->memberModel->getUserIdByEmail($this->input->post('userName'),$this->input->post('userEmail'),$this->input->post('userId'));

            if($result['code'] == 'success'){

                $certNo = rand(111111, 999999);
                log_message('error','cert_no:'.$certNo);

                // 인증번호 60분 제한 설정
                $dueYear = date( 'Y', strtotime("+1 hour"));
                $dueMonth = date( 'm', strtotime("+1 hour"));
                $dueDate= date( 'd', strtotime("+1 hour"));
                $dueHour = date( 'H', strtotime("+1 hour"));
                $dueMinute = date( 'i', strtotime("+1 hour"));

                // 이메일 발송 추가
                sendMessage('search_pw_certi', $this->input->post('userEmail'), '', ['cert_no' => $certNo, 'year'=> $dueYear, 'month'=> $dueMonth, 'date'=> $dueDate, 'hour'=> $dueHour, 'minute'=> $dueMinute]);

                $this->setFlashData('ForbizCertiNum', $certNo, 3600);

                $this->setResponseResult($result['code']);
                $this->setResponseData($result['data']);

            }else{
                if($result['login_type']){
                    $this->setResponseResult($result['code'])->setResponseData($result['login_type']);
                }else{
                    $this->setResponseResult($result['code']);
                }

            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }




    /**
     * 인증번호 확인
     */
    public function certiConfirm()
    {
        if (form_validation(['certiVal'])) {
            $certi_val = $this->getFlashData('ForbizCertiNum');

            if ($certi_val == $this->input->post('certiVal')) {
                $this->setResponseResult('success');
            } else {
                $this->setFlashData('ForbizCertiNum', $certi_val);
                $this->setResponseResult('notMatched');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 유효값 체크
     * 아이디 찾기
     */
    public function searchUserById()
    {
        $chekField = ['userName', 'pcs1', 'pcs2', 'pcs3'];
        $pcs       = $this->input->post('pcs1').'-'.$this->input->post('pcs2').'-'.$this->input->post('pcs3');
        $this->setResponseResult('fail')->setResponseData(validation_errors());

        if (form_validation($chekField)) {
            $this->setResponseResult('fail')->setResponseData($this->input->post());

            //입력받은 이름과 휴대폰번호 체크 후 아이디를 전송
            $certi_res = $this->memberModel->doCertiIdReq($pcs, $this->input->post('userName'));

            if ($certi_res == 'existSearch') {
                //결과값 실패
                $this->setResponseResult($certi_res);
            } else {
                //결과값 성공
                $this->setFlashData('ForbizCertiNum', $pcs);
                $this->setResponseResult('success');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 유효값 체크
     * 비밀번호 찾기
     */
    public function searchUserByPw()
    {
        $chekField = ['userId', 'pcs1', 'pcs2', 'pcs3'];
        $pcs       = $this->input->post('pcs1').'-'.$this->input->post('pcs2').'-'.$this->input->post('pcs3');
        $this->setResponseResult('fail')->setResponseData(validation_errors());

        if (form_validation($chekField)) {
            $this->setResponseResult('fail')->setResponseData($this->input->post());

            //입력받은 아이디와 휴대폰번호 체크 후 임시비밀번호를 전송
            $certi_res = $this->memberModel->doCertiPwReq($pcs, $this->input->post('userId'));

            if ($certi_res == 'existSearch') {
                //결과값 실패
                $this->setResponseResult($certi_res);
            } else {
                //결과값 성공
                $this->setFlashData('ForbizCertiNum', $pcs);
                $this->setResponseResult('success');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 아이디 저장
    */
    public function saveId()
    {
        $chekField = ['id'];

        if (form_validation($chekField)) {

            /* @var $memberLoginModel ForbizMallMemberLoginModel */
            $memberLoginModel = $this->import('model.mall.memberLogin');

            //아이디 저장
            $responseData = $memberLoginModel->saveId($this->input->post('id'), 'Y');

            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }
    
    /**
     * 휴면회원 인증
     */
    public function nextSleepMemberReleaseAuth()
    {
        if (is_login()) {
            // Next step
            $this->setFlashData('sleepStep', 'policy');
            $this->setResponseResult('success');
        } else {
            $this->setResponseResult('needLogin');
        }
    }
    
    /**
     * 휴면회원 비밀번호 변경
     */
    public function nextSleepMemberReleaseChangePassword()
    {
        if (is_login()) {
            $chkField = ['policyIx[]'];

            if (form_validation($chkField)) {
                foreach ($this->input->post('policyIx') as $ix => $val) {
                    $this->memberModel->insertAgreementHistory($ix, sess_val('user', 'code'), sess_val('user', 'id'), sess_val('user', 'name'), 'M');
                }

                if (is_sns_login()) {
                    //일반회원은 $this->memberModel->doChangePassword 에서 처리 되지만 sns 계정은 별도로 처리
                    if ($this->memberModel->activeMember(sess_val('user', 'code'), "회원 로그인 시도 후 휴면 해지 진행") !== true) {
                        $this->setResponseResult('fail');
                    } else {
                        $this->setFlashData('sleepStep', 'complete');
                    }
                } else {
                    //비밀번호 변경 권한 set
                    $this->memberModel->setChangePasswordAccessSessionType('sleep');
                    $this->memberModel->setChangePasswordAccessSessionUserCode(sess_val('user', 'code'));
                    
                    // Next step
                    $this->setFlashData('sleepStep', 'password');
                    $this->setResponseResult('success');
                }
            } else {
                $this->setResponseResult('fail')->setResponseData(validation_errors());
            }
        } else {
            $this->setResponseResult('needLogin');
        }
    }

    /**
     * 회원 아이디 체크
     */
    public function userIdCheck()
    {
        if (form_validation(['userId']) == false) {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        } else {
            $result = $this->memberModel->checkUserId($this->input->post('userId'));

            if($result == 'success'){
                $this->setResponseResult('success');
            }else if($result == 'withdrawn'){
                $this->setResponseResult('withdrawn');
            }else{
                $this->setResponseResult('fail');
            }

        }
    }


    /**
     * 회원 아이디 찾기
     * @param : 회원 이름, 이메일
     */
    public function searchUserIdByEmail()
    {
        if(BASIC_LANGUAGE == 'english'){
            $checkField = [ 'devUserEmail1', 'devUserEmail2'];
        }else{
            $checkField = ['devUserName','devUserEmail1', 'devUserEmail2'];
        }


        if (form_validation($checkField) == false) {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        } else {
            $userName = trim($this->input->post('devUserName'));
            $userEmail = trim($this->input->post('devUserEmail1'))."@".trim($this->input->post('devUserEmail2'));
            $result = $this->memberModel->getUserIdByEmail($userName, $userEmail);

            if($result['code'] == 'success'){
                $this->setResponseResult($result['code']);
                $this->setResponseData($result['data']);
            }else{
                $this->setResponseResult($result['code']);
            }

        }
    }


    /**
     * 회원 아이디 찾기
     * @param : 회원 이름, 전화번호
     */
    public function searchUserIdByPhone()
    {
        $checkField = ['devUser', 'devHp1', 'devHp2', 'devHp3'];

        if (form_validation($checkField) == false) {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        } else {
            $userName = trim($this->input->post('devUser'));
            $userPcs = trim($this->input->post('devHp1'))."-".trim($this->input->post('devHp2'))."-".trim($this->input->post('devHp3'));

            $result = $this->memberModel->getUserIdByPhone($userName, $userPcs);
            if($result['code'] == 'success'){
                $this->setResponseResult($result['code']);
                $this->setResponseData($result['data']);
            }else{
                $this->setResponseResult($result['code']);
            }

        }
    }


    /**
     * 비밀번호 찾기 > 회원 계정 확인
     * @param : 아이디, 이름, 휴대전화, 이메일
     */
    public function checkUserInfo()
    {

        if(BASIC_LANGUAGE == 'english'){
            $checkField = ['searchType', 'userId', 'certNo'];
        }else{
            $checkField = ['searchType', 'userId', 'userName', 'certNo'];
        }


        $userId = trim($this->input->post('userId'));
        $userName = trim($this->input->post('userName'));
        $userEmail = trim($this->input->post('userEmail1'))."@".trim($this->input->post('userEmail2'));
        $userPcs = trim($this->input->post('pcs1'))."-".trim($this->input->post('pcs2'))."-".trim($this->input->post('pcs3'));
        $searchType = $this->input->post('searchType');


        if (form_validation($checkField) == false) {
            $this->setResponseResult('fail')->setResponseData(validation_errors());

        } else {

            $result = $this->memberModel->searchUserPassword($userId, $userName, $searchType, $userEmail, $userPcs);

            if($result['code'] == 'success'){
                $this->setResponseResult($result['code']); // 회원 확인 성공

                $this->memberModel->setChangePasswordAccessSessionType('searchPassword');
                $this->memberModel->setChangePasswordAccessSessionUserCode($result['data']);

                // Next step
                $this->setFlashData('sleepStep', 'password');
                $this->setResponseResult('success');


            }else{
                $this->setResponseResult($result['code'])->setResponseData($result); // 회원 미확인
            }

        }
    }

    /**
     * 비회원(주문조회)
     */
    public function nonMemberLogin()
    {

        if(is_mobile()){
            $chkField = ['buyerName', 'orderId','orderId2', 'orderPassword'];
        }else{
            $chkField = ['buyerName', 'orderId', 'orderPassword'];
        }

        if (form_validation($chkField)) {

            if(is_mobile()){
                $orderId = $this->input->post('orderId')."-".$this->input->post('orderId2');
            }else{
                $orderId = $this->input->post('orderId');
            }

            $result = $this->memberModel->doNonMemberlogin(
                $orderId, $this->input->post('buyerName'), $this->input->post('orderPassword')
            );

            // 결과 확인
            if (isset($result['oid'])) {
                $this->memberModel->setNonMemberSession($result);
                $this->setResponseResult('success')->setResponseData([
                    'url' => '/mypage/orderHistory'
                ]);
            } else {
                $this->setResponseResult('fail');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 일반회원 비밀번호 변경
     * @overwrite
     *
     */
    public function changePassword()
    {
        $chkField = ['pw', 'comparePw'];

        if (form_validation($chkField)) {
            // 회원코드
            $userCode = $this->memberModel->getChangePasswordAccessSessionUserCode();

			// 비밀번호 유효성 저장시 체크
			$pw             = $this->input->post('pw');
			$comparePw      = $this->input->post('comparePw');

			$num            = preg_match('/[0-9]/u', $pw);                                  // 숫자체크
			$eng            = preg_match('/[a-z]/u', $pw);                                  // 소문자체크
			$caEng          = preg_match('/[A-Z]/u', $pw);                                  // 대문자체크
			$spe            = preg_match("/[\!\@\#$\%\^\&\*\(\)\_\+\~]/u",$pw);             // 특수문자 => 해당기호만 !@#$%^&*()_+~

			$eng = $eng + $caEng;

			if($eng >= 1){
				$eng = 1;
			}

			$pwSum          = $num + $eng + $spe;                                           // 영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합 확인

			$compareNum     = preg_match('/[0-9]/u', $comparePw);                           // 숫자체크(비밀번호확인)
			$compareEng     = preg_match('/[a-z]/u', $comparePw);                           // 소문자체크(비밀번호확인)
			$compareCaEng   = preg_match('/[A-Z]/u', $comparePw);                           // 대문자체크(비밀번호확인)
			$compareSpe     = preg_match("/[\!\@\#$\%\^\&\*\(\)\_\+\~]/u",$comparePw);      // 특수문자(비밀번호확인) => 해당기호만 !@#$%^&*()_+~

			$compareEng = $compareEng + $compareCaEng;

			if($compareEng >= 1){
				$compareEng = 1;
			}

			$compareSum     = $compareNum + $compareEng + $compareSpe;                      // 영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합 확인(비밀번호확인)

			$pwCnt          = strlen($pw);                                                  // 비밀번호 갯수
			$comparePwCnt   = strlen($comparePw);                                           // 비밀번호 확인 갯수

			if($pw == $comparePw) {
				if($pwCnt>=8 && $pwCnt<=16){
					if($pwSum > 1){
						/*echo "<script>alert('정상완료');</script>";
						$this->setResponseResult('doubleId');
						$resultMessage = "가입완료";
						$result = "Y";*/
					} else {
						/*exit("<script>alert('영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합하여 최소 8자~최대 16자로 입력해 주세요.');</script>");
						$resultMessage = "영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합하여 최소 8자~최대 16자로 입력해 주세요.";
						$result = "N";*/
						$this->setResponseResult('false');
					}
				} else{
					/*exit("<script>alert('영문+숫자+특수문자를 조합하여 8~20자리로 입력해 주세요.');</script>");
					$resultMessage = "영문+숫자+특수문자를 조합하여 8~20자리로 입력해 주세요.";
					$result = "N";*/
					$this->setResponseResult('false');
				}
			} else {
				/*exit("<script>alert('비밀번호와 비밀번호확인이 일치하지 않습니다.');</script>");
				$resultMessage = "영문+숫자+특수문자를 조합하여 8~20자리로 입력해 주세요.";
				$result = "N";*/
				$this->setResponseResult('false');
			}
			// // 비밀번호 유효성 저장시 체크

            // 비밀번호 변경
            $responseData = $this->memberModel->doChangePassword($this->input->post('pw'), $this->input->post('comparePw'));

            // 결과 확인
            if ($responseData == 'false' || $responseData == 'failActiveMember' || $responseData == 'equalCurrentPw') {
                $this->setResponseResult($responseData);

            } else {

                // 휴면회원
                if ($responseData['changeType'] == 'sleep') {
                    $this->setFlashData('sleepStep', 'complete');
                }

                unset($responseData['changeType']);

                // userCode와 비밀번호를 사용하여 로그인
                // $this->memberModel->useUserCodeLogin($userCode, $this->input->post('pw'));
                // $userProfile = $this->memberModel->getMemberProfile($userCode);
                //$responseData['name'] = $userProfile['name'];
                $this->memberModel->getMemberProfile($userCode);

                $this->setResponseResult('success')->setResponseData($responseData);
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 사용자정보를 수정한다.
     */
    public function modifyProfile()
    {
        if (is_login()) {
            $mem_type = sess_val('user', 'mem_type');

            if ($mem_type == 'C') {
                // 업체회원
                $chkField = [
                    'com_tel1', 'com_tel2', 'com_tel3', 'com_zip', 'com_addr1', 'com_addr2',
                    'comEmailId', 'comEmailHost', 'com_pcs1', 'com_pcs2', 'com_pcs3',
                    'name', 'emailId', 'emailHost'
                ];

                if ($this->input->post('pcs1') != '') {
                    $chkField[] = 'pcs2';
                    $chkField[] = 'pcs3';
                } else {
                    $chkField[] = 'pcs';
                }
            } else if($mem_type == 'F'){
                // 일반회원
                $chkField = ['emailId', 'emailHost', 'national_phone', 'pcs'];
            } else {
                // 일반회원
                $chkField = ['emailId', 'emailHost', 'pcs1', 'pcs2', 'pcs3'];
            }

            if (form_validation($chkField)) {
                if ($mem_type == 'C') {
                    $res = $this->memberModel->doModifyProfile($this->input->post(), sess_val('user', 'company_id'));
                } else {
                    $res = $this->memberModel->doModifyProfile($this->input->post());
                }

                // 개인정보 동의 로그 이벤트 전파
                if (is_array($this->input->post('policy'))) {
                    foreach ($this->input->post('policy') as $piIx) {
                        $this->event->emmit('insertAgreementHistory', [
                            'piIx' => $piIx,
                            'userCode' => sess_val('user', 'code'),
                            'userId' => sess_val('user', 'id'),
                            'name' => sess_val('user', 'name'),
                            'memType' => sess_val('user', 'mem_type')
                        ]);
                    }
                }

                $this->setResponseResult('success')->setResponseData($res);
            } else {
                $this->setResponseResult('fail')->setResponseData(validation_errors());
            }
        } else {
            $this->setResponseResult('needLogin');
        }
    }
}