<?php

/**
 * Description of ForbizMallMemberModel
 *
 * @author hoksi
 */
class ForbizMallMemberModel extends ForbizModel
{
    public $error = '';
    public $activatioCode = '';
    public $goUrl = '/';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 사업자 파일 등록
     * @param $companyId
     * @param $sheetName
     * @param $sheetValue
     */
    public function insertCompanyFile($companyId, $sheetName, $sheetValue, $text = '')
    {
        $fileCnt = $this->qb
            ->from(TBL_COMMON_COMPANY_FILE)
            ->where('company_id', $companyId)
            ->where('sheet_name', $sheetName)
            ->getCount();

        $this->qb
            ->set('sheet_value', $sheetValue)
            ->set('text', $text)
            ->set('edit_date', date('Y-m-d H:i:s'));

        if ($fileCnt > 0) {
            return $this->qb
                ->where('company_id', $companyId)
                ->where('sheet_name', $sheetName)
                ->update(TBL_COMMON_COMPANY_FILE)
                ->exec();
        } else {
            return $this->qb->insert(TBL_COMMON_COMPANY_FILE)->exec();
        }
    }

    /**
     * 회원 약관 동의 로그
     * @param $piIx
     * @param $userCode
     * @param $userId
     * @param $name
     * @param $memType
     */
    public function insertAgreementHistory($piIx, $userCode, $userId, $name, $memType)
    {
        return $this->qb
            ->set('pi_ix', $piIx)
            ->set('user_code', $userCode)
            ->set('user_id', $userId)
            ->encryptSet('user_name', $name)
            ->set('user_type', $memType)
            ->set('user_ip', $_SERVER['REMOTE_ADDR'])
            ->set('regdate', date('Y-m-d H:i:s'))
            ->insert(TBL_SHOP_AGREEMENT_HISTORY)
            ->exec();
    }

    /**
     * 로그인 실패 횟수 확인
     * @param type $id
     * @return boolean
     */
    public function checkLoginFailCount($id)
    {
        /* @var $loginModel CustomMallMemberLoginModel */
        $loginModel = $this->import('model.mall.member.login');

        if ($loginModel->overLoginFailCount($id)) {
            $_SESSION['auth_type'] = "Y";
            $_SESSION['login_id'] = trim($id);

            return true;
        } else {
            return false;
        }
    }

    /**
     * 회원 로그아웃
     * @return boolean
     */
    public function doLogout()
    {
        /* @var $loginModel CustomMallMemberLoginModel */
        $loginModel = $this->import('model.mall.memberLogin');

        //로그아웃 정보 로그기록
        $loginModel->connectUserLog(sess_val('user', 'id'), sess_val('user', 'code'), 'logout');

        $_SESSION = [];

        setcookie("connection_no", '', time() - 1, "/", $_SERVER['HTTP_HOST'], false, true);
        setcookie("auto_login", '', time() - 1, "/", $_SERVER['HTTP_HOST'], false, true);
		setcookie("MBCODE", '', time() + 1209600, "/", $_SERVER['HTTP_HOST'], false, true);

        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    /**
     * 회원정보 수정
     * @param array $data
     * @param string $companyId
     * @return string
     */
    public function doModifyProfile($data, $companyId = '')
    {
        // 회원 프로필 수정
        $ret[] = $this->modifyMemberProfile($data);

        if ($companyId != '') {
            // 업체정보 수정
            $ret[] = $this->modifyCompanyProfile($companyId, $data);
        }

        return $companyId != '' ? 'company' : 'basic';
    }

    /**
     * 일반회원 정보 수정
     * @param array $data
     * @return boolean
     */
    public function modifyMemberProfile($data)
    {
        $_SESSION['user']['mail'] = "{$data['emailId']}@{$data['emailHost']}";

        // 휴대폰 번호 설정
        if (isset($data['pcs1'])) {
            $_SESSION['user']['pcs'] = "{$data['pcs1']}-{$data['pcs2']}-{$data['pcs3']}";
        } else {
            $_SESSION['user']['pcs'] = $data['pcs'] ?? '011--';
        }

        // 이름이 있는 경우 업데이트 설정
        if (isset($data['name'])) {
            $_SESSION['user']['name'] = $data['name'];
            $this->qb->encryptSet('name', $data['name']);
        }

        // 우편번호와 주소가 있는 경우
        if (isset($data['zip'])) {
            $this->qb->encryptSet('zip', $data['zip'])
                ->encryptSet('addr1', $data['addr1'])
                ->encryptSet('addr2', $data['addr2']);
        }

        // 전화번호가 있는 경우
        if (isset($data['tel1'])) {
            $this->qb->encryptSet('tel', ($data['tel2'] ? "{$data['tel1']}-{$data['tel2']}-{$data['tel3']}" : ''));
        }

        return $this->qb
            ->encryptSet('pcs', $_SESSION['user']['pcs'])
            ->encryptSet('mail', $_SESSION['user']['mail'])
            ->set('sms', $data['sms'] ?? '0')
            ->set('info', $data['email'] ?? '0')
            ->where('code', sess_val('user', 'code'))
            ->update(TBL_COMMON_MEMBER_DETAIL)
            ->exec();
    }

    /**
     * 업체회원정보 수정
     * @param string $companyId
     * @param array $data
     * @return boolean
     */
    public function modifyCompanyProfile($companyId, $data)
    {
        // 사업자등록증 업로드
        $this->uploadCompanyfile($companyId);

        return $this->qb
            ->set('com_phone', "{$data['com_tel1']}-{$data['com_tel2']}-{$data['com_tel3']}")
            ->set('com_zip', $data['com_zip'])
            ->set('com_addr1', $data['com_addr1'])
            ->set('com_addr2', $data['com_addr2'])
            ->set('com_mobile', "{$data['com_pcs1']}-{$data['com_pcs2']}-{$data['com_pcs2']}")
            ->set('com_email', "{$data['comEmailId']}@{$data['comEmailHost']}")
            ->where('company_id', $companyId)
            ->update(TBL_COMMON_COMPANY_DETAIL)
            ->exec();
    }

    /**
     * 비회원(주문조회)
     * @param string $oid 주문번호
     * @param string $bname 주문자명
     * @return boolean
     */
    public function doNonMemberlogin($oid, $bname, $orderPw)
    {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');

        return $orderModel->getOidUsingPasswordAndName($oid, $bname, $orderPw, date('Y-m-d H:i:s', strtotime('-5 years')));
    }

    /**
     * 회원가입 (회원선택)
     * @return array
     */
    public function getMemberRegRule()
    {
        return ForbizConfig::getSharedMemory("member_reg_rule");
    }

    /**
     * 회원가입 세션에 가입타입 저장
     * @param $type
     */
    public function setJoinSessionType($type)
    {
        if ($type != '') {
            $_SESSION['join']['type'] = $type;
            return true;
        }

        return false;
    }

    /**
     * 회원가입 세션에 약관동의항목 저장(array(12,23,56,policy_ix) 형태)
     * @param $data
     */
    public function setJoinSessionAgreePolicy($data)
    {
        $_SESSION['join']['policy'] = $data;
    }

    /**
     * 회원가입 세션에 수신동의 set (eamil, sms)
     * @param $data
     */
    public function setJoinSessionReceive($data)
    {
        $_SESSION['join']['receive'] = $data;
    }

    /**
     * 회원가입 세션에 사업자 정보 set (comName, comNumber)
     * @param $data
     */
    public function setJoinSessionCompany($data)
    {
        $_SESSION['join']['company'] = $data;
    }

    /**
     * 비회원 세션 생성
     * @param $orderDate
     */
    public function setNonMemberSession($orderDate)
    {
        $_SESSION['nonMember']['oid'] = $orderDate['oid'];
    }

    /**
     * 인증 정보 set
     */
    public function setAuthSessionData($data)
    {
        $_SESSION['auth']['data'] = $data;
    }

    /**
     * 비밀번호 변경 안내 세션 생성
     * @param $boolean
     */
    public function setChangePasswordSession($boolean)
    {
        $_SESSION['user']['changeAccessPassword'] = $boolean;
    }

    /**
     * 비밀번호 변경 타입 세션 set
     */
    public function setChangePasswordAccessSessionType($type)
    {
        $_SESSION['changePasswordAccess']['type'] = $type;
    }

    /**
     * 비밀번호 변경 타입 대상 회원 User code set
     */
    public function setChangePasswordAccessSessionUserCode($userCode)
    {
        $_SESSION['changePasswordAccess']['userCode'] = $userCode;
    }

    /**
     * 비밀번호 변경 안내 기간 체크
     * @param $userChangePwDate
     * @param $userJoinDate
     * @return bool
     */
    public function isChangePassword($userChangePwDate, $userJoinDate)
    {
        // 개인정보 설정 확인
        if (
            ForbizConfig::getPrivacyConfig('change_pw_info') == 'Y' &&
            ForbizConfig::getPrivacyConfig('change_pw_day') != '' &&
            ForbizConfig::getPrivacyConfig('change_pw_continue_day') != ''
        ) {
            if (!empty($userChangePwDate)) {
                $changePwDate = date('Y-m-d H:i:s', strtotime($userChangePwDate));
            } else {
                $changePwDate = date('Y-m-d H:i:s', strtotime($userJoinDate));
            }

            $changeCkeckDate = date("Y-m-d H:i:s", strtotime($changePwDate . " +" . ForbizConfig::getPrivacyConfig('change_pw_day') . " days"));

            if (strtotime($changeCkeckDate) < strtotime('now')) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 회원가입 세션
     * @return mixed
     */
    public function getJoinSession()
    {
        return sess_val('join');
    }

    /**
     * 인증 정보 get
     */
    public function getAuthSessionData()
    {
        return sess_val('auth', 'data');
    }

    /**
     * 비밀번호 변경 타입 세션 get
     */
    public function getChangePasswordAccessSessionType()
    {
        return sess_val('changePasswordAccess', 'type');
    }

    /**
     * 비밀번호 변경 타입 대상 회원 User code get
     */
    public function getChangePasswordAccessSessionUserCode()
    {
        return sess_val('changePasswordAccess', 'userCode');
    }

    /**
     * 인증 세션 삭제
     */
    public function resetAuthSession()
    {
        $_SESSION['auth'] = false;
        unset($_SESSION['auth']);
    }

    /**
     * 회원가입 세션 삭제
     */
    public function resetJoinSession()
    {
        $_SESSION['join'] = false;
        unset($_SESSION['join']);
    }

    /**
     * 비밀번호 변경 세션 삭제
     */
    public function resetChangePasswordAccessSession()
    {
        $_SESSION['changePasswordAccess'] = false;
        unset($_SESSION['changePasswordAccess']);
    }

    /**
     * 회원 아이디 암호화
     * @param string $pw
     * @return string
     */
    public function encryptUserPassword($pw)
    {
        return encrypt_user_password($pw);
    }

    public function doAuthentication($joinType)
    {
        $data = [];

        $this->resetAuthSession();

        $member_reg_rule = ForbizConfig::getSharedMemory("member_reg_rule");

        $data['useIpin'] = $member_reg_rule['mall_use_ipin'] == "Y";
        $data['useCertify'] = $member_reg_rule['mall_use_certify'] == "Y";
        $data['joinType'] = $joinType;

        return $data;
    }

    /**
     * 가입동의 데이타
     * @param string $joinType
     * @return array
     */
    public function doJoinAgreement($joinType)
    {
        $data = [];

        $data['joinType'] = $joinType;
        $data['mallName'] = ForbizConfig::getCompanyInfo('shop_name');

        /* @var $companyModel CustomMallCompanyModel */
        $companyModel = $this->import('model.mall.company');

        $data['policyData'] = $companyModel->getPolicy('use', 'collection', 'consign', 'third', 'marketing', 'collection_select');

        return $data;
    }

    /**
     * 가입동의 데이타
     * @param string $joinType
     * @return array
     */
    public function doJoinInput($joinType)
    {
        $data = [];

        $data['joinType'] = $joinType;

        // 사업자 회원
        if ($joinType == 'C') {
            $joinData = $this->getJoinSession();
            if (!isset($joinData['company']['name']) || !isset($joinData['company']['number'])) {
                return false;
            } else {
                $data['comName'] = $joinData['company']['name'];
                $data['comNumber'] = $joinData['company']['number'];
            }
        } else {
            $memberRegRule = ForbizConfig::getSharedMemory("member_reg_rule");
            $authData = $this->getAuthSessionData();

            if (($memberRegRule['mall_use_ipin'] == "Y" || ($memberRegRule['mall_use_certify'] ?? '') == "Y") && empty($authData['ci'])) {
                return false;
            } else {
                $data['userName'] = $authData['name'];
                $data['changeFormatBirthday'] = date('Y년 m월 d일', strtotime($authData['birthday']));
                $data['changeFormatSexDiv'] = ($authData['sexDiv'] == 'M' ? "남성" : "여성");
                $data['explodePcs'] = explode("-", $authData['pcs']);
            }
        }

        return $data;
    }

    /**
     * 아이디 찾기 폼 관련 데이타
     * @return array
     */
    public function doSearchId()
    {
        $data = [];

        //인증 관련 세션 초기화
        $this->resetAuthSession();
        //get 회원가입 설정
        $memberRegRule = ForbizConfig::getSharedMemory("member_reg_rule");

        //아이핀 사용 유무
        $data['useIpin'] = ($memberRegRule['mall_use_ipin'] == "Y" ? true : false);
        //본인인증 사용 유무
        $data['useCertify'] = ($memberRegRule['mall_use_certify'] == "Y" ? true : false);
        //CS 연락처
        $data['csPhone'] = ForbizConfig::getCompanyInfo('cs_phone');

        return $data;
    }

    /**
     * 비밀번호 찾기
     */
    public function doSearchPw()
    {
        return $this->doSearchId();
    }

    /**
     * 휴면회원 인증
     * @param string $sleepStep
     * @return array
     */
    public function doSleepMemberAuth($sleepStep)
    {
        //get 회원가입 설정
        $memberRegRule = ForbizConfig::getSharedMemory('member_reg_rule');

        $data = [
            'memType' => sess_val('user', 'mem_type'),
            'useIpin' => ($memberRegRule['mall_use_ipin'] == "Y" ? true : false),
            'useCertify' => ($memberRegRule['mall_use_certify'] == "Y" ? true : false),
            'releaseStep' => $sleepStep
        ];

        return $data;
    }

    /**
     * 휴면회원 약관동의
     * @param string $sleepStep
     * @return array
     */
    public function doSleepMemberPolicy($sleepStep)
    {
        /* @var $companyModel CustomMallCompanyModel */
        $companyModel = $this->import('model.mall.company');

        $data = [
            //use 구매 이용 약관
            //collection 개인정보 수집 및 이용에 대한 안내
            //consign 개인정보 취급 위탁
            'policyData' => $companyModel->getPolicy('use', 'collection', 'consign'),
            'releaseStep' => $sleepStep
        ];

        return $data;
    }

    /**
     * 회원탈퇴
     * @param array $data
     * @return string
     */
    public function withdrawMember($data)
    {
        /* @var $orderModel CustomMallOrderModel */
        $orderModel = $this->import('model.mall.order');

        if ($orderModel->hasOngoingOrder($data['code'])) {
            // 배송중 주문 있음
            return 'hasOrder';
        } else {

            $data['dropdate'] = date('Y-m-d H:i:s');

            // 탈퇴사유 조회
            $row = $this->qb
                ->select('dp_name')
                ->from(TBL_COMMON_DROPMEMBER_SETUP)
                ->where('drop_ix', $data['drop_ix'])
                ->exec()
                ->getRowArray();

            // 트랜잭션 시작
            $this->qb->transStart();
            // 탈퇴회원 등록
            $this->qb
                ->set('code', $data['code'])
                ->set('id', $data['id'])
                ->set('mem_type', $data['mem_type'])
                ->set('reason', ($row['dp_name'] ?? ''))
                ->set('message', $data['other_reason'])
                ->set('dropdate', $data['dropdate'])
                ->set('name', $data['name'])
                ->set('email', $data['mail'])
                ->set('drop_ix', $data['drop_ix'])
                ->insert(TBL_COMMON_DROPMEMBER)
                ->exec();

            // 회원 정보 삭제
            $this->qb
                ->where('code', $data['code'])
                ->delete(TBL_COMMON_USER)
                ->exec();

            // 회원 상세 정보 삭제
            $this->qb
                ->where('code', $data['code'])
                ->delete(TBL_COMMON_MEMBER_DETAIL)
                ->exec();

            // 회원 탈퇴시 개인정보 관련 처리
            $orderModel->withdrawOrderProcess($data['code']);

            // 트랜잭션 Complete
            $this->qb->transComplete();

            // 이메일 전송 이벤트 호출
            $this->event->trigger('withdrowMemberSendEmail',
                [
                    'mem_name' => $data['name'],
                    'mem_mail' => $data['mail'],
                    'mem_id' => $data['id'],
                    'mem_mobile' => $data['pcs'],
                    'dropdate' => $data['dropdate']
                ]);

            return 'success';
        }
    }

    /**
     * 비밀번호 변경
     * @param string $pw
     * @param string $comparePw
     * @return string
     */
    public function doChangePassword($pw, $comparePw)
    {
        $changeType = $this->getChangePasswordAccessSessionType();
        $userCode = $this->getChangePasswordAccessSessionUserCode();

        if (empty($userCode) || $pw != $comparePw) {
            $ret = 'false';
        } else {
            $ret = [
                'changeType' => $changeType,
                'url' => '/'
            ];

            if ($changeType == 'sleep') {
                // 휴면회원 복구
                if ($this->activeMember($userCode, "회원 로그인 시도 후 휴면 해지 진행") !== true) {
                    return 'failActiveMember';
                } else {
                    $ret['url'] = ForbizConfig::getPrivacyConfig('sleep_user_release');
                }
            } else {
                //정기 비밀번호 변경
                $this->setChangePasswordSession(false);
            }

            $encryptPw = $this->encryptUserPassword($pw);

            // 비밀번호 변경
            $this->updatePassword($userCode, $encryptPw);
            //정기 비밀번호 변경
            $this->setChangePasswordSession(false);
        }

        $this->resetChangePasswordAccessSession();

        return $ret;
    }

    /**
     * 환불계좌 정보 조회
     * @param string $userCode
     * @return array
     */
    public function getRefundAccount($userCode, $getRows = false)
    {
        $row = $this->qb
            ->select('bank_ix')
            ->select('bank_code')
            ->decryptSelect('bank_name')
            ->decryptSelect('bank_owner')
            ->decryptSelect('bank_number')
            ->from(TBL_SHOP_USER_BANKINFO)
            ->where('ucode', $userCode)
            ->where('is_basic', 1)
            ->orderBy('regdate', 'desc')
            ->limit(1)
            ->exec()
            ->getRowArray();

        if (!empty($row)) {
            $row['ori_bank_number'] = $row['bank_number'];
            $row['bank_number'] = substr($row['bank_number'], 0, 3) . '*******';
            $list = [$row];
        } else {
            $list = false;
        }

        if ($getRows) {
            return $row;
        } else {
            return [
                'list' => $list,
                'paging' => false
            ];
        }
    }

    /**
     * 환불계좌를 삭제한다.
     * @param string $userCode
     * @param int $bankIx
     * @return boolean
     */
    public function refundAccountDelete($userCode, $bankIx)
    {
        return $this->qb
            ->where('ucode', $userCode)
            ->where('bank_ix', $bankIx)
            ->delete(TBL_SHOP_USER_BANKINFO)
            ->exec();
    }

    public function refundAccountReplace($userCode, $data)
    {
        $this->qb
            ->set('ucode', $userCode)
            ->set('bank_code', $data['bank_code'])
            ->encryptSet('bank_name', ForbizConfig::getBankList($data['bank_code']))
            ->encryptSet('bank_number', $data['bank_number'])
            ->encryptSet('bank_owner', $data['bank_owner'])
            ->set('use_yn', 'Y')
            ->set('is_basic', 1);

        if (isset($data['bank_ix']) && $data['bank_ix']) {
            $replaceType = 'update';
            $this->qb
                ->set('editdate', date('Y-m-d H:i:s'))
                ->where('ucode', $userCode)
                ->where('bank_ix', $data['bank_ix'])
                ->update(TBL_SHOP_USER_BANKINFO)
                ->exec();
        } else {
            $replaceType = 'insert';
            $this->qb
                ->set('regdate', date('Y-m-d H:i:s'))
                ->insert(TBL_SHOP_USER_BANKINFO)
                ->exec();
        }

        return $replaceType;
    }

    /**
     * 비밀번호 변경을 다음으로 미룬다.
     * @param string $userCode
     * @return boolean
     */
    public function doPasswordContinue($userCode)
    {
        // 비밀번호 변경일 변경
        $this->updateChangePasswordDate($userCode);

        // 비밀번호 변경 관련 세션 데이타 리셋
        $this->resetChangePasswordAccessSession();
        $this->setChangePasswordSession(false);

        return true;
    }

    /**
     * 비밀번호 변경일자 수정
     * @param $userCode
     * @param $date
     */
    public function updateChangePasswordDate($userCode)
    {
        return $this->qb
            ->set('change_pw_date', date('Y-m-d H:i;s'))
            ->where('code', $userCode)
            ->update(TBL_COMMON_USER)
            ->exec();
    }

    public function useUserCodeLogin($userCode, $pw)
    {
        $row = $this->qb
            ->select('id')
            ->from(TBL_COMMON_USER)
            ->where('code', $userCode)
            ->exec()
            ->getRow();

        if (isset($row->id)) {
            $this->doLogin($row->id, $pw);

            return $row->id;
        }

        return false;
    }

    /**
     * 회원 로그인 처리
     * @param string $id
     * @param string $pw
     * @param string $autoLogin
     * @param string $saveId
     * @param string $url
     * @return string
     */
    public function doLogin($id, $pw, $autoLogin = 'N', $saveId = 'N', $url = '/')
    {
        //비회원 로그인 정보 리셋
        $this->resetNonMemberSession();

        /* @var $loginModel CustomMallMemberLoginModel */
        $loginModel = $this->import('model.mall.memberLogin');

        //아이디 비밀번호로 회원 데이터 가지고 오기
        $userAuthData = $loginModel->getUserAuthDataByIdPw($id, $pw, sess_val('privacy_config', 'sleep_user_yn'));

        // 로그인 성공 확인
        if (empty($userAuthData['code'])) {
            return "fail";
        } else {
            //승인 여부 확인
            if ($userAuthData['authorized'] == "Y") {
                //로그인 세션 생성
                $loginModel->setUserSession($userAuthData);

                //로그인 성공 관련 회원정보 업데이트
                $loginModel->updateLoginUserData($userAuthData['code']);

                //비회원일때 카트 담은 정보 업데이트
                $loginModel->updateLoginUserCartData($userAuthData['code']);

                //비밀번호 변경안내 (휴면계정일때는 비밀번호 변경 처리를 유보함)
                if ($userAuthData['sleep_account'] != 'Y') {
                    // 정기비밀번호 변경 여부 확인
                    if ($this->isChangePassword($userAuthData['change_pw_date'], $userAuthData['date'])) {
                        // 정기 비밀번호 변경 설정
                        $this->setChangePasswordAccessSessionType('regular');
                        $this->setChangePasswordAccessSessionUserCode(sess_val('user', 'code'));
                        $this->setChangePasswordSession(true);

                        $url = '/member/password';
                    } else {
                        $this->setChangePasswordSession(false);
                    }
                }

                //로그인 히스토리 정보 삭제 ( 기존에 프로세스 대로 코딩했지만 크론으로 따로 빼야 하는거 아닌지? )
                $loginModel->deleteConnectUserLog(sess_val('privacy_config', 'member_connect_delete_day'));
                //로그인 히스토리 정보 등록
                $loginModel->connectUserLog($id, $userAuthData['code'], 'login');

                //자동 로그인 여부 쿠키 세팅
                $loginModel->autoLoginCookie($id, $pw, $autoLogin, $userAuthData['code']);
                //아이디 저장
                $loginModel->saveId($id, $saveId);

                /* @var $productModel CustomMallProductModel */
                $productModel = $this->import('model.mall.product');
                // 로그인전 등록된 최근 본 상품 정보 기록
                $productModel->replaceProductViewHistory($userAuthData['code'], '');

                //로그&이커머스분석 이벤트 전파
                $this->event->emmit('MemberLoginUpdate', ['userCode' => $userAuthData['code']]);

                // 로그인 성공
                return ['url' => ($url ? $url : '/'), 'userCode' => $userAuthData['code']];
            } else {
                //로그인 히스토리 정보 등록
                $loginModel->connectUserLog($id, '', 'login');
                // 승인대기/거부 설정
                return ($userAuthData['authorized'] == "N" ? "standby" : "reject");
            }
        }
    }

    /**
     * 회원 비밀번호 수정
     * @param $userCode
     * @param $encryptPw
     */
    public function updatePassword($userCode, $encryptPw)
    {
        // 비밀번호 변경
        return $this->qb
            ->set('pw', $encryptPw)
            ->set('change_pw_date', date('Y-m-d H:i:s'))
            ->where('code', $userCode)
            ->update(TBL_COMMON_USER)
            ->exec();
    }

    /**
     * 휴면 계정 활성화
     * @param $userCode
     * @param $message
     * @return bool
     */
    public function activeMember($userCode, $message)
    {
        /**
         * @todo 트랜젹션 시작
         */
        $this->qb->transStart();

        // log 작성
        $this->qb
            ->set('code', $userCode)
            ->set('message', $message)
            ->set('charger_ix', $userCode)
            ->set('change_type', 'M')
            ->set('regdate', date('Y-m-d H:i:s'))
            ->set('id',
                $this->qb
                    ->startSubQuery()
                    ->select('id')->from(TBL_COMMON_USER_SLEEP)->where('code', $userCode)
                    ->endSubQuery(), false
            )
            ->set('name',
                $this->qb
                    ->startSubQuery()
                    ->select('name')->from(TBL_COMMON_MEMBER_DETAIL_SLEEP)->where('code', $userCode)
                    ->endSubQuery(), false
            )
            ->set('status', 'U')
            ->insert(TBL_COMMON_USER_SLEEP_LOG)
            ->exec();

        // 회원 정보 복원

        $this->qb->exec($this->qb->queryBind(
            'INSERT INTO ' . TBL_COMMON_USER . ' SELECT * FROM ' . TBL_COMMON_USER_SLEEP . ' WHERE code = ? AND NOT EXISTS (SELECT code FROM ' . TBL_COMMON_USER . ' WHERE code=?)',
            [$userCode, $userCode]
        ));

        // 회원 상세 정보 복원
        $this->qb->exec($this->qb->queryBind(
            'INSERT INTO ' . TBL_COMMON_MEMBER_DETAIL . ' SELECT * FROM ' . TBL_COMMON_MEMBER_DETAIL_SLEEP . ' WHERE code = ? AND NOT EXISTS (SELECT code FROM ' . TBL_COMMON_MEMBER_DETAIL . ' WHERE code=?)',
            [$userCode, $userCode]
        ));

        // 휴면회원 정보 삭제
        $this->qb->where('code', $userCode)->delete(TBL_COMMON_USER_SLEEP)->exec();
        // 휴면회원 상세 정보 삭제
        $this->qb->where('code', $userCode)->delete(TBL_COMMON_MEMBER_DETAIL_SLEEP)->exec();

        // 주문정보 조회
        $rows = $this->qb->select('oid')->from(TBL_SHOP_ORDER)->where('user_code', $userCode)->exec()->getResultArray();
        if (!empty($rows)) {
            foreach ($rows as $row) {
//                $this->qb
//                    ->set('o.btel', 'so.btel', false)
//                    ->set('o.bmobile', 'so.bmobile', false)
//                    ->set('o.btel', 'so.btel', false)
//                    ->where('o.oid', $row['oid'])
//                    ->where('o.oid', 'so.oid', false)
//                    ->update(TBL_SHOP_ORDER.' o, '.TBL_SEPARATION_SHOP_ORDER.' so', false)
//                    ->exec();
                $sql = "UPDATE shop_order o, separation_shop_order so "
                    . " SET o.btel = so.btel, o.bmobile = so.bmobile ,o.bmail=so.bmail ,o.bzip=so.bzip ,o.baddr=so.baddr  "
                    . " WHERE `o`.`oid` = '{$row['oid']}' AND o.oid = so.oid";
                $this->qb->exec($sql);

                $this->qb->where('oid', $row['oid'])->delete(TBL_SEPARATION_SHOP_ORDER)->exec();

                $sql2 = "UPDATE shop_order_detail_deliveryinfo d, separation_shop_order_deliveryinfo sd "
                    . " SET d.rname = sd.rname, d.rtel = sd.rtel, d.rmobile = sd.rmobile, d.rmail = sd.rmail, d.zip = sd.zip, d.addr1 = sd.addr1, d.addr2 = sd.addr2 "
                    . " WHERE `sd`.`oid` = '{$row['oid']}' AND d.odd_ix = sd.odd_ix  ";
//                $this->qb
//                    ->set('d.rname', 'sd.rname', false)
//                    ->set('d.rtel', 'sd.rtel', false)
//                    ->set('d.rmobile', 'sd.rmobile', false)
//                    ->set('d.rmail', 'sd.rmail', false)
//                    ->set('d.zip', 'sd.zip', false)
//                    ->set('d.addr1', 'sd.addr1', false)
//                    ->set('d.addr2', 'sd.addr2', false)
//                    ->where('sd.rname', $row['oid'])
//                    ->where('d.odd_ix', 'sd.odd_ix', false)
//                    ->update(TBL_ORDER_DETAIL_DELIVERUINFO.' d, '.TBL_SEPARATION_SHOP_ORDER_DELIVERYINFO.' sd')
//                    ->exec();
                $this->qb->exec($sql2);
                $this->qb->where('oid', $row['oid'])->delete(TBL_SEPARATION_SHOP_ORDER_DELIVERYINFO)->exec();
            }
        }

        /**
         * @todo 트랜젹션 끝
         */
        $this->qb->transComplete();

        return $this->qb->transStatus();
    }

    /**
     * User Code 생성
     * @return string
     */
    public function makeCode()
    {
        return make_member_code();
    }

    /**
     * 회원 등록
     * @param $data
     * @return string
     */
    public function registMember($data)
    {
        $userCode = $this->makeCode();

        $this->qb
            ->set('code', $userCode)
            ->set('id', $data['userId'])
            ->set('company_id', ($data['companyId'] ?? ''))
            ->set('pw', $this->encryptUserPassword($data['pw']))
            ->set('mem_type', ($data['memType'] ?? 'M'))//회원 타입 : M:일반회원 C: 사업자 A: 직원
            ->set('mem_div', ($data['memDiv'] ?? 'D'))//S: 셀러 MD : MD담당자 D:아무도 아닌경우
            ->set('authorized', $data['authorized'])//Y : 자동승인, N : 수동승인
            ->set('auth', ($data['auth'] ?? '0'))
            ->set('request_info', ($data['requestInfo'] ?? 'M'))//M : 일반회원 요청
            ->set('request_yn', ($data['requestYn'] ?? 'Y'))//Y : 요청 승인
            ->set('agent_type', ($data['agentType'] ?? 'W'))//W : pc, M : mobile
            ->set('ip', $_SERVER['REMOTE_ADDR'])
            ->set('user_agent', $_SERVER["HTTP_USER_AGENT"])
            ->set('date', ($data['date'] ?? date('Y-m-d H:i:s')))
            ->set('regdate_desc', (time() * -1))
            ->set('last', ($data['date'] ?? date('Y-m-d H:i:s')))
            ->insert(TBL_COMMON_USER)
            ->exec();

        $this->qb
            ->set('code', $userCode)
            ->set('ci', $data['ci'])
            ->set('di', $data['di'])
            ->set('birthday', $data['birthday'])
            ->set('birthday_div', ($data['birthdayDiv'] ?? '1'))//1:양력, 0:음력
            ->encryptSet('name', $data['name'])
            ->encryptSet('mail', $data['email'])
            ->encryptSet('pcs', $data['pcs'])
            ->encryptSet('tel', $data['tel'])
            ->encryptSet('zip', ($data['zip'] ?? ''))
            ->encryptSet('addr1', ($data['addr1'] ?? ''))
            ->encryptSet('addr2', ($data['addr2'] ?? ''))
            ->set('info', ($data['info'] ?? '0'))// 1,0
            ->set('sms', ($data['sms'] ?? '0'))// 1,0
            ->set('sex_div', ($data['sexDiv'] ?? 'M'))//M:남성, W:여성, D:기타
            ->set('gp_ix', ($data['gpIx'] ?? '1'))//1 : 일반회원 하드코딩
            ->set('date', ($data['date'] ?? date('Y-m-d H:i:s')))
            ->insert(TBL_COMMON_MEMBER_DETAIL)
            ->exec();

        return $userCode;
    }

    /**
     * 사업자 회원 등록
     * @param $data
     * @return string
     */
    public function registCompany($data)
    {
        $companyId = $this->makeCode();

        $this->qb
            ->set('company_id', $companyId)
            ->set('com_type', 'G')
            ->set('com_name', $data['comName'])
            ->set('seller_type', ($data['sellerType'] ?? "1"))//거래처 유형 1 : 국내매출, 2 : 국내매입, 3: 해외수입, 4:해외수출
            ->set('com_ceo', $data['comCeo'])
            ->set('com_email', $data['comEmail'])
            ->set('com_business_status', ($data['comBusinessStatus'] ?? ''))
            ->set('com_business_category', ($data['comBusinessCategory'] ?? ''))
            ->set('online_business_number', ($data['onlineBusinessNumber'] ?? ''))
            ->set('com_number', $data['comNumber'])
            ->set('com_phone', $data['comPhone'])
            ->set('com_mobile', $data['comMobile'])
            ->set('com_zip', $data['comZip'])
            ->set('com_addr1', $data['comAddr1'])
            ->set('com_addr2', $data['comAddr2'])
            ->set('seller_auth', ($data['sellerAuth'] ?? "Y"))
            ->set('regdate', date('Y-m-d H:i:s'))
            ->insert(TBL_COMMON_COMPANY_DETAIL)
            ->exec();

        $this->qb
            ->set('company_id', $companyId)
            ->set('shop_name', ($data['shopName'] ?? ''))
            ->set('md_code', ($data['mdCode'] ?? ''))
            ->set('authorized', ($data['authorized'] ?? "1"))//N:승인대기, Y:승인, X:승인거부
            ->set('seller_date', ($data['sellerDate'] ?? date('Y-m-d')))//거래일
            ->set('regdate', date('Y-m-d H:i:s'))
            ->insert(TBL_COMMON_SELLER_DETAIL)
            ->exec();

        // 사업자 등록증 업로드
        $this->uploadCompanyfile($companyId);

        return $companyId;
    }

    /**
     * 사업자 등록증 파일 업로드
     * @param string $companyId
     */
    public function uploadCompanyfile($companyId)
    {
        // Upload File 설정
        $path = MALL_DATA_PATH . "/images/basic/" . $companyId;
        $fileName = "business_file_" . $companyId . ".jpg";
        // Upload File 저장
        $ret = form_file_upload('businessFile', $path, $fileName);
        if (isset($ret['client_name'])) {
            $this->insertCompanyFile($companyId, 'business_file', $fileName, $ret['client_name']);
        }
    }

    /**
     * 회원탈퇴 사유
     * @return array
     */
    public function getDropMemberReasen()
    {
        return $this->qb
            ->select('drop_ix')
            ->select('dp_name')
            ->from(TBL_COMMON_DROPMEMBER_SETUP)
            ->where('disp', 1)
            ->orderBy('drop_ix')
            ->exec()
            ->getResultArray();
    }

    /**
     * User code를 이용하여 프로필을 가져온다.
     * @param string $userCode
     * @return array
     */
    public function getMemberProfile($userCode)
    {
        $data = $this->qb
            ->select('cu.id')
            ->select('cu.mem_type')
            ->select('cu.company_id')
            ->select('cmd.birthday')
            ->select('cmd.birthday_div')
            ->select('cmd.sex_div')
            ->select('cmd.info')
            ->select('cmd.sms')
            ->decryptSelect('cmd.name')
            ->decryptSelect('cmd.mail')
            ->decryptSelect('cmd.zip')
            ->decryptSelect('cmd.addr1')
            ->decryptSelect('cmd.addr2')
            ->decryptSelect('cmd.tel')
            ->decryptSelect('cmd.pcs')
            ->from(TBL_COMMON_USER . ' as cu')
            ->join(TBL_COMMON_MEMBER_DETAIL . ' as cmd', 'cu.code=cmd.code')
            ->where('cu.code', $userCode)
            ->exec()
            ->getRowArray();

        if (isset($data['id'])) {
            $data['birthday'] = str_replace('-', '', $data['birthday']);
            $data['tel'] = explode('-', ($data['tel'] ?? '02--'));
            $data['pcs'] = explode('-', $data['pcs']);
            $data['mail'] = explode('@', $data['mail']);
        }

        return $data;
    }

    /**
     * 기업회원 ID로 정보를 조회한다.
     * @param string $companyId
     * @return array
     */
    public function getCompanyProfile($companyId)
    {
        $data = $this->qb
            ->select('com_name')
            ->select('com_number')
            ->select('com_phone')
            ->select('com_zip')
            ->select('com_addr1')
            ->select('com_addr2')
            ->select('com_ceo')
            ->select('com_mobile')
            ->select('com_email')
            ->select('com_div')
            ->from(TBL_COMMON_COMPANY_DETAIL)
            ->where('company_id', $companyId)
            ->exec()
            ->getRowArray();

        if (isset($data['com_name'])) {
            $data['com_phone'] = explode('-', ($data['com_phone'] ?? '02--'));
            $data['com_mobile'] = explode('-', $data['com_mobile']);
            $data['com_email'] = explode('@', $data['com_email']);
        }

        return $data;
    }

    /**
     * 가입 완료 데이터
     * @param string $userCode
     * @return array
     */
    public function getJoinEndData($userCode)
    {
        return $this->qb
            ->select('cu.mem_type')
            ->select('cu.authorized')
            ->decryptSelect('cmd.name')
            ->select('ccd.com_name')
            ->from('common_member_detail cmd')
            ->join('common_user cu', 'cmd.code=cu.code')
            ->join('common_company_detail ccd', 'ccd.company_id=cu.company_id', 'left')
            ->where('cu.code', $userCode)
            ->limit(1)
            ->exec()
            ->getRowArray();
    }

    /**
     * 회원가입시 id 체크
     * @param $userId
     * @return bool
     */
    public function checkUserId($userId)
    {
        $denyId = ForbizConfig::getConfig('mall_deny_id');

        return (
            in_array($userId, $denyId) ||
            $this->qb->from(TBL_COMMON_USER)->where('id', $userId)->getCount() > 0 ||
            $this->qb->from(TBL_COMMON_DROPMEMBER)->where('id', $userId)->getCount() > 0 ||
            $this->qb->from(TBL_COMMON_USER_SLEEP)->where('id', $userId)->getCount() > 0
        ) ? false : true;
    }

    /**
     * 사용자 비밀번호를 확인한다.
     * @param string $userId
     * @param string $userPw
     * @return boolean
     */
    public function checkUserPassword($userCode, $userPw, $userId)
    {
        $rowCnt = $this->qb
            ->from(TBL_COMMON_USER)
            ->where('code', $userCode)
            ->groupStart()
            ->where('pw', $this->encryptUserPassword(strtoupper($userPw)))//소문자를 대문자로
            ->orWhere('pw', $this->encryptUserPassword(strtolower($userPw)))//대문자를 소문자로
            ->orWhere('pw', $this->encryptUserPassword($userPw))
            ->groupEnd()
            ->getCount();

        $mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

        if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){
            $gubun = "M";
        }else{
            $gubun = "P";
        }

        if($rowCnt > 0){
            //	성공시 member_log 입력 처리
            $this->qb
                ->set('mem_id', $userId)
                ->set('ip', $_SERVER['REMOTE_ADDR'])
                ->set('gubun', $gubun)
                ->set('log_date', date('Y-m-d H:i:s'))
                ->set('log_div', 'S')
                ->insert("member_log")
                ->exec();
            //	성공시 member_log 입력 처리
        }else{
            //	실패시 member_log 입력 처리
            $this->qb
                ->set('mem_id', $userId)
                ->set('ip', $_SERVER['REMOTE_ADDR'])
                ->set('gubun', $gubun)
                ->set('log_date', date('Y-m-d H:i:s'))
                ->set('log_div', 'F')
                ->insert("member_log")
                ->exec();
            //	실패시 성공시 member_log 입력 처리
        }

        return $rowCnt > 0;
    }

    /**
     * 회원 가입시 eamil 체크
     * @param $userId
     */
    public function checkEmail($email)
    {
        // 회원 로그인 된 경우
        if (is_login()) {
            $this->qb->where('code !=', sess_val('user', 'code'));
        }

        $email = strtolower($email);
        return $this->qb
            ->from(TBL_COMMON_MEMBER_DETAIL)
            ->encryptWhere('LOWER(mail)', $email)
            ->getCount() > 0 ? false : true;
    }

    /**
     * 사업자 회원 eamil 중복 체크
     * @param $userId
     */
    public function checkCompanyEmail($email)
    {
        // 회원 로그인 된 경우
        if (is_login()) {
            $this->qb->where('company_id !=', sess_val('user', 'company_id'));
        }

        $email = strtolower($email);
        return $this->qb
            ->from(TBL_COMMON_COMPANY_DETAIL)
            ->encryptWhere('LOWER(com_email)', $email)
            ->getCount() > 0 ? false : true;
    }

    /**
     * 사업자 번호 중복 체크
     * @param $comNumber
     * @return bool
     */
    public function checkCompanyNumber($comNumber)
    {
        return ($this->qb
            ->from(TBL_COMMON_COMPANY_DETAIL)
            ->where('com_number', $comNumber)
            ->getCount() > 0 ? false : true);
    }

    /**
     * ci 정보로 회원정보 가지고 오기
     * @param $ci
     * @return mixed
     */
    public function getUserDataByCi($ci)
    {

        return $this->qb
            ->select('cu.code')
            ->select('cu.id')
            ->decryptSelect('cmd.name')
            ->select('cu.company_id')
            ->select('cu.date')
            ->from(TBL_COMMON_USER . ' cu')
            ->join(TBL_COMMON_MEMBER_DETAIL . ' cmd', 'cu.code = cmd.code')
            ->whereIn('cu.mem_type', ['M', 'C'])
            ->where('cmd.ci', $ci)
            ->exec()
            ->getRowArray();
    }

    /**
     * company id 로 회원 정보 가지고 오기
     * @param $companyId
     * @return mixed
     */
    public function getUserDataByCompanyId($companyId)
    {
        return $this->qb
            ->select('code')
            ->select('id')
            ->select('date')
            ->from(TBL_COMMON_USER)
            ->where('mem_type', 'C')
            ->where('company_id', $companyId)
            ->limit(1)
            ->exec()
            ->getRowArray();
    }

    /**
     * 사업자 정보 가지고 오기
     * @param $companyId
     * @return mixed
     */
    public function getCompanyData($companyId)
    {
        return $this->qb
            ->select('company_id')
            ->select('com_name')
            ->select('com_number')
            ->from(TBL_COMMON_COMPANY_DETAIL)
            ->where('company_id', $companyId)
            ->limit(1)
            ->exec()
            ->getRowArray();
    }

    /**
     * 사업자명, 사업자번호, 대표자명 으로 업체 조회
     * @param $comName
     * @param $comNumber
     * @param $comCeo
     * @return mixed
     */
    public function searchCompany($comName, $comNumber, $comCeo)
    {
        return $this->qb
            ->select('company_id')
            ->from(TBL_COMMON_COMPANY_DETAIL)
            ->where('com_name', $comName)
            ->where('com_number', $comNumber)
            ->where('com_ceo', $comCeo)
            ->limit(1)
            ->exec()
            ->getRowArray();
    }

    /**
     * 배송지 정보 리스트
     * @param string $code
     * @param int $cur_page
     * @param int $per_page
     * @param boolean $is_paging
     * @return array
     */
    public function getAddressBookList($userCode, $cur_page = 1, $per_page = 10, $is_paging = true)
    {
        $this->qb
            ->startCache()
            ->where('mem_ix', $userCode)
            ->from(TBL_SHOP_SHIPPING_ADDRESS)
            ->stopCache();

        if ($is_paging) {
            // Get total rows
            $total = $this->qb->getCount();

            // Get paging data
            $paging = $this->qb
                ->setTotalRows($total)
                ->pagination($cur_page, $per_page);

            $limit = $per_page;
            $offset = $paging['offset'];
        } else {
            $limit = $per_page;
            $offset = ($cur_page - 1) * $per_page;
            $paging = false;
        }

        // Get user addressbook data
        $list = $this->qb
            ->select('ix')// 배송지키
            ->select('shipping_name')// 배송명칭
            ->select("if(default_yn = 'Y', 'Y', '') default_yn", false)// 기본주소여부
            ->select('recipient')// 수신자명
            ->select('tel')// 전화번호
            ->select('mobile')// 핸드폰번호
            ->select('zipcode')// 주소
            ->select('address1')// 주소
            ->select('address2')// 상세주소
            ->orderBy('ix', 'desc')
            ->limit($limit, $offset)
            ->exec()
            ->getResult();

        if (!empty($list)) {
            $mobile = explode('-', $list['mobile']);
            $list['pcs1'] = $mobile[0] ?? '010';
            $list['pcs2'] = $mobile[1] ?? '';
            $list['pcs3'] = $mobile[2] ?? '';
        }


        $this->qb->flushCache();

        return [
            'list' => $list,
            'paging' => $paging
        ];
    }

    /**
     * 배송지를 추가한다.
     * @param array $data
     * @return int
     */
    public function addressBookReplace($userCode, $data)
    {
        $data['default_yn'] = ($data['default_yn'] ?? 'N');

        $tel = ($data['tel'] ?? (!empty($data['tel2']) && !empty($data['tel3']) ? "{$data['tel1']}-{$data['tel2']}-{$data['tel3']}" : ""));
        $mobile = ($data['mobile'] ?? (!empty($data['pcs2']) && !empty($data['pcs3']) ? "{$data['pcs1']}-{$data['pcs2']}-{$data['pcs3']}" : ""));

        // 기본 배송지인 경우 기존 기본 배송지 리셋
        if ($data['default_yn'] == 'Y') {
            $this->qb
                ->set('default_yn', 'N')
                ->where('mem_ix', $userCode)
                ->update(TBL_SHOP_SHIPPING_ADDRESS)
                ->exec();
        }

        $this->qb
            ->set('recipient', $data['recipient'])
            ->set('tel', $tel)
            ->set('mobile', $mobile)
            ->set('shipping_name', $data['shipping_name'] ?? '')
            ->set('zipcode', $data['zip'] ?? '')
            ->set('address1', $data['addr1'] ?? '')
            ->set('address2', $data['addr2'] ?? '')
            ->set('default_yn', $data['default_yn']);

        if ($data['mode'] == 'update') {
            return $this->qb
                ->where('mem_ix', $userCode)
                ->where('ix', $data['ix'])
                ->update(TBL_SHOP_SHIPPING_ADDRESS)
                ->exec();
        } elseif ($data['mode'] == 'insert') {
            return $this->qb
                ->set('mem_ix', $userCode)
                ->insert(TBL_SHOP_SHIPPING_ADDRESS)
                ->exec();
        }
    }

    /**
     * 배송지 삭제
     * @param string $userCode
     * @param string $ix
     * @return boolean
     */
    public function addressBookDelete($userCode, $ix)
    {
        return $this->qb
            ->where('mem_ix', $userCode)
            ->where('ix', $ix)
            ->delete(TBL_SHOP_SHIPPING_ADDRESS)
            ->exec();
    }

    /**
     * 배송지 추가
     * @param int $ix
     * @return array
     */
    public function getAddressBookItem($userCode, $ix)
    {
        $row = $this->qb
            ->select('ix')
            ->select('recipient')
            ->select('tel')
            ->select('mobile')
            ->select('shipping_name')
            ->select('zipcode')
            ->select('address1')
            ->select('address2')
            ->select('default_yn')
            ->from(TBL_SHOP_SHIPPING_ADDRESS)
            ->where('mem_ix', $userCode)
            ->where('ix', $ix)
            ->exec()
            ->getRowArray();

        if (!empty($row)) {
            $tel = explode('-', $row['tel']);
            $row['tel1'] = $tel[0] ?? '02';
            $row['tel2'] = $tel[1] ?? '';
            $row['tel3'] = $tel[2] ?? '';

            $mobile = explode('-', $row['mobile']);
            $row['pcs1'] = $mobile[0] ?? '010';
            $row['pcs2'] = $mobile[1] ?? '';
            $row['pcs3'] = $mobile[2] ?? '';
        }

        return $row;
    }

    /**
     * 배송지키 검색
     * @param string $userCode
     * @param array $data
     * @return 배송지 Primary Key
     */
    public function searchAddressBook($userCode, $data)
    {
        $row = $this->qb
            ->select('ix')// 배송지키
            ->from(TBL_SHOP_SHIPPING_ADDRESS)
            ->where('mem_ix', $userCode)
            ->where('recipient', $data['recipient'])
            ->where('zipcode', $data['zip'])
            ->where('address1', $data['addr1'])
            ->where('address2', $data['addr2'])
            ->limit(1)
            ->exec()
            ->getRowArray();

        return ($row['ix'] ?? false);
    }

    /**
     * 비회원 로그인 세션 삭제
     */
    public function resetNonMemberSession()
    {
        $_SESSION['nonMember'] = false;
        unset($_SESSION['nonMember']);
    }

    /**
     * get 회원 그룹 정보
     * @param type $gpIx
     * @return type
     */
    public function getGroupInfo($gpIx)
    {
        $row = $this->qb
            ->from(TBL_SHOP_GROUPINFO)
            ->where('gp_ix', $gpIx)
            ->exec()
            ->getRowArray();

        return $row;
    }
}
