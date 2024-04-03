<?php

/**
 * Description of ForbizMallMemberController
 *
 * @author hoksi
 *
 * @property CustomMallMemberModel $memberModel 회원 관련 모델 Object
 */
class ForbizMallMemberController extends ForbizMallController
{
    protected $memberModel;

    public function __construct()
    {
        parent::__construct();

        // mall member model Load
        $this->memberModel = $this->import('model.mall.member');
    }

    /**
     * 로그인
     */
    public function login()
    {
        if (form_validation(['userId', 'userPw'])) {
            // Login
            $result = $this->memberModel->doLogin(
                $this->input->post('userId'), $this->input->post('userPw'), $this->input->post('autoLogin'), $this->input->post('saveId'),
                $this->input->post('url', true)
            );

            if (is_array($result)) {
                $this->setResponseResult('success')->setResponseData($result);
            } else {
                $this->setResponseResult($result);
            }
        } else {
            $this->setResponseResult("fail")->setResponseData(validation_errors());
        }
    }

    /**
     * 비회원(주문조회)
     */
    public function nonMemberLogin()
    {
        $chkField = ['buyerName', 'orderId', 'orderPassword'];

        if (form_validation($chkField)) {
            $result = $this->memberModel->doNonMemberlogin(
                $this->input->post('orderId'), $this->input->post('buyerName'), $this->input->post('orderPassword')
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
     * 사용자 비밀번호를 확인한다.
     */
    public function validatePassword()
    {
        if (is_login()) {
            // 비밀번호 확인 요청 타입
            $reconfirmType = $this->getFlashData('passReconfirmType');

            if ($reconfirmType != '') {
                $chkFiled = ['pass'];

                if (form_validation($chkFiled)) {
                    $res = $this->memberModel->checkUserPassword(sess_val('user', 'code'), $this->input->post('pass'));

                    if ($res) {
                        $this->setFlashData('reconfirmPassMode', $reconfirmType);
                        $this->setResponseResult('success')->setResponseData($reconfirmType);
                    } else {
                        $this->setFlashData('passReconfirmType', $reconfirmType);
                        $this->setResponseResult('notMatch');
                    }
                } else {
                    $this->setResponseResult('fail')->setResponseData(validation_errors());
                }
            } else {
                $this->setResponseResult('noReconfirmType');
            }
        } else {
            $this->setResponseResult('needLogin');
        }
    }

    /**
     * 회원탈퇴를 진행한다.
     */
    public function withdraw()
    {
        if (is_login()) {
            $chkField = ['withdrawCode', 'drop_ix'];
            if (form_validation($chkField)) {
                if ($this->getFlashData('withdrawCode') == $this->input->post('withdrawCode')) {
                    // 회원탈퇴 필요정보 설정
                    $withdrawData             = $this->input->post();
                    $withdrawData['code']     = sess_val('user', 'code');
                    $withdrawData['name']     = sess_val('user', 'name');
                    $withdrawData['id']       = sess_val('user', 'id');
                    $withdrawData['mail']     = sess_val('user', 'mail');
                    $withdrawData['pcs']      = sess_val('user', 'pcs');
                    $withdrawData['mem_type'] = sess_val('user', 'mem_type');

                    // 회원탈퇴
                    $ret = $this->memberModel->withdrawMember($withdrawData);

                    if ($ret == 'hasOrder') {
                        $this->setFlashData('withdrawCode', $this->input->post('withdrawCode'));
                        $this->setResponseResult('hasOrder');
                    } else {
                        $this->memberModel->doLogout();
                        $this->setResponseResult('success')->setResponseData($ret);
                    }
                } else {
                    $this->setResponseResult('invalidwithdrawCode');
                }
            } else {
                $this->setResponseResult('fail')->setResponseData(validation_errors());
            }
        } else {
            $this->setResponseResult('needLogin');
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
                        $this->event->emmit('insertAgreementHistory',
                            [
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

    /**
     * 휴면회원 인증
     */
    public function nextSleepMemberReleaseAuth()
    {
        if (is_login()) {
            // Next step
            $this->setFlashData('sleepStep', 'auth');
            $this->setResponseResult('success');
        } else {
            $this->setResponseResult('needLogin');
        }
    }

    /**
     * 휴면회원 약관동의(일반)
     */
    public function nextSleepMemberReleasePolicyBasic()
    {
        if (is_login()) {
            $authData = $this->memberModel->getAuthSessionData();

            if (empty($authData['ci'])) {
                $this->setResponseResult('fail');
            } else {
                // Next step
                $this->setFlashData('sleepStep', 'policy');
                $this->setResponseResult('success');
            }
        } else {
            $this->setResponseResult('needLogin');
        }
    }

    /**
     * 휴면회원 약관동의(사업자)
     */
    public function nextSleepMemberReleasePolicyCompany()
    {
        // 로그인 확인
        if (is_login()) {
            $chkField = ['comName', 'comNumber1', 'comNumber2', 'comNumber3'];
            if (form_validation($chkField)) {
                $comNumber = $this->input->post('comNumber1').'-'.$this->input->post('comNumber2').'-'.$this->input->post('comNumber3');
                $comData   = $this->memberModel->getCompanyData(sess_val('user', 'company_id'));

                if ($comData['com_name'] == $this->input->post('comName') && $comData['com_number'] == $comNumber) {
                    // Next step
                    $this->setFlashData('sleepStep', 'policy');

                    $this->setResponseResult('success')->setResponseData(['companyId' => sess_val('user', 'company_id')]);
                } else {
                    // 사업자 정보 맞지 않음
                    $this->setResponseResult('noMatchData');
                }
            } else {
                $this->setResponseResult('fail')->setResponseData(validation_errors());
            }
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

                //비밀번호 변경 권한 set
                $this->memberModel->setChangePasswordAccessSessionType('sleep');
                $this->memberModel->setChangePasswordAccessSessionUserCode(sess_val('user', 'code'));

                // Next step
                $this->setFlashData('sleepStep', 'password');
                $this->setResponseResult('success');
            } else {
                $this->setResponseResult('fail')->setResponseData(validation_errors());
            }
        } else {
            $this->setResponseResult('needLogin');
        }
    }

    /**
     * 가입 회원 타입을 선택한다. 
     */
    public function joinSelectType()
    {
        if (form_validation(['joinType'])) {
            $result = $this->memberModel->setJoinSessionType($this->input->post('joinType', true)) ? 'success' : 'error';
            $this->setResponseResult($result);
        } else {
            $this->setResponseResult('fail');
        }
    }

    /**
     * 회원 약관 및 정보 수신 수락 선택 
     */
    public function joinAgreePolicy()
    {
        if (form_validation(['policyIx[]'])) {
            $agreePolicyIxList = $this->input->post('policyIx');
            $receiveData       = [
                'email' => $this->input->post('email'),
                'sms' => $this->input->post('sms')
            ];

            $setData = array();
            if (is_array($agreePolicyIxList)) {
                foreach ($agreePolicyIxList as $ix => $val) {
                    if ($val == "Y") {
                        $setData[] = $ix;
                    }
                }
            }

            $this->memberModel->setJoinSessionAgreePolicy($setData);
            $this->memberModel->setJoinSessionReceive($receiveData);

            $this->setResponseResult('success');
        } else {
            $this->setResponseResult('fail');
        }
    }

    /**
     * 회원 아이디 체크 
     */
    public function userIdCheck()
    {
        if (form_validation(['userId']) == false || $this->memberModel->checkUserId($this->input->post('userId')) === false) {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        } else {
            $this->setResponseResult('success');
        }
    }

    /**
     * 일반회원 이메일 체크 
     */
    public function emailCheck()
    {
        $email     = $this->input->post('email');
        $chk_email = preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);
        if ($chk_email) {
            if ($this->memberModel->checkEmail($email) === false) {
                $this->setResponseResult('fail');
            } else {
                $this->setResponseResult('success');
            }
        } else {
            $this->setResponseResult('wrongEmail');
        }
    }

    /**
     * 업체회원 이메일 체크 
     */
    public function companyEmailCheck()
    {
        if (form_validation(['email']) == false || $this->memberModel->checkCompanyEmail($this->input->post('email')) === false) {
            $this->setResponseResult('fail');
        } else {
            $this->setResponseResult('success');
        }
    }

    /**
     * 일반 회원 가입
     */
    public function joinInputBasic()
    {

        // 입력 필수 항목
        $chekField = [
            'userId', 'pw', 'comparePw',
            'emailId', 'emailHost',
            'pcs1', 'pcs2', 'pcs3',
        ];

        // 필수 항목 점검
        if (form_validation($chekField)) {
            // 인증데이타
            $authData = $this->memberModel->getAuthSessionData();
            //가입 데이터 (type, policy, receive)
            $joinData = $this->memberModel->getJoinSession();

            /*
             * 아이디 중복 체크
             * 일반 회원인지 확인
             * 인증 데이터 체크
             * 가입 데이터 (type, policy, receive) 체크
             */
            if (!$this->memberModel->checkUserId($this->input->post('userId'))) {
                $this->setResponseResult('doubleId');
            } elseif (!isset($joinData['type']) || $joinData['type'] != 'B') {
                $this->setResponseResult('sessionIssue');
            } elseif (empty($authData['ci'])) {
                $this->setResponseResult('authIssue');
            } else {
                $memberRegRule = ForbizConfig::getSharedMemory('member_reg_rule');

                $registData['userId']      = $this->input->post('userId');
                $registData['pw']          = $this->input->post('pw');
                $registData['authorized']  = ($memberRegRule['auth_type'] != "A" ? 'N' : 'Y'); //자동 승인 여부
                $registData['agentType']   = (is_mobile() ? 'M' : 'W');
                $registData['name']        = $authData['name'];
                $registData['ci']          = $authData['ci'];
                $registData['di']          = $authData['di'];
                $registData['birthday']    = $authData['birthday'];
                $registData['birthdayDiv'] = $authData['birthdayDiv'];
                $registData['email']       = $this->input->post('emailId').'@'.$this->input->post('emailHost');
                $registData['info']        = $joinData['receive']['email'];
                $registData['pcs']         = $authData['pcs'];
                $registData['sms']         = $joinData['receive']['sms'];
                $registData['tel']         = $this->input->post('tel1').'-'.$this->input->post('tel2').'-'.$this->input->post('tel3');
                $registData['sexDiv']      = $authData['sexDiv'];
                $registData['zip']         = $this->input->post('zip');
                $registData['addr1']       = $this->input->post('addr1');
                $registData['addr2']       = $this->input->post('addr2');
                $registData['gpIx']        = DEFAULT_GPIX;
                $registData['date']        = date('Y-m-d H:i:s');

                // 회원 가입
                $userCode = $this->memberModel->registMember($registData);

                $registData['code'] = $userCode;

                // UserCode set
                $this->setFlashData('userCode', $userCode);

                // 세션 데이타 삭제
                $this->memberModel->resetAuthSession();
                $this->memberModel->resetJoinSession();

                // 개인정보 동의 로그
                if (is_array($joinData['policy'])) {
                    foreach ($joinData['policy'] as $piIx) {
//                        해당 부분은 이벤트가 아닌 바로 모델로 처리 필요
//                        $this->event->emmit('insertAgreementHistory', [
//                            'piIx' => $piIx,
//                            'userCode' => $userCode,
//                            'userId' => $registData['userId'],
//                            'name' => $registData['name'],
//                            'memType' => 'M'
//                        ]);
                    }
                }

                // 자동승인 여부에 따라 로그인 처리
                if ($registData['authorized'] == 'Y') {
                    $this->setFlashData('doLoginInfo',
                        [
                            'userId' => $registData['userId'],
                            'userPw' => $registData['pw']
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
     * 사업자 인증
     */
    public function authenticationCompany()
    {
        // 입력 필수 항목
        $chkField = ['comName', 'comNumber1', 'comNumber2', 'comNumber3'];

        // 필수 항목 점검
        if (form_validation($chkField)) {
            $comNumber = $this->input->post('comNumber1', true).'-'.$this->input->post('comNumber2', true).'-'.$this->input->post('comNumber3', true);

            // 등록된 사업자번호인지 확인
            if (!$this->memberModel->checkCompanyNumber($comNumber)) {
                $this->setResponseResult('doubleCompanyNumber');
            } else {
                $this->memberModel->setJoinSessionCompany([
                    'name' => $this->input->post('comName'),
                    'number' => $comNumber,
                ]);
            }
        } else {
            log_message('error', validation_errors());
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 사업자 회원 가입
     */
    public function joinInputCompany()
    {

        $chkField = [
            'userId', 'pw', 'comparePw',
            'comPhone1', 'comPhone2', 'comPhone3',
            'comZip', 'comAddr1', 'comAddr2',
            'comCeo', 'comEmailId', 'comEmailHost',
            'comPcs1', 'comPcs2', 'comPcs3',
            'userName', 'emailId', 'emailHost',
        ];

        // upload file 점검
        if (!isset($_FILES['businessFile']['name'])) {
            $chkField[] = 'businessFile';
        }

        if (form_validation($chkField)) {
            //인증 데이터
            $authData = $this->memberModel->getAuthSessionData();
            //가입 데이터 (type, policy, receive)
            $joinData = $this->memberModel->getJoinSession();

            /*
             * 아이디 중복 체크
             * 사업자 회원 체크
             * 인증 데이터 체크
             */
            if (!$this->memberModel->checkUserId($this->input->post('userId'))) {
                $this->setResponseResult('doubleId');
            } elseif (!isset($joinData['type']) || $joinData['type'] != 'C') {
                $this->setResponseResult('sessionIssue');
            } elseif (!isset($authData['ci']) || $authData['ci'] == '') {
                $this->setResponseResult('authIssue');
            } else {
                $memberRegRule = ForbizConfig::getSharedMemory('member_reg_rule');

                //company set
                $companyRegistData              = [];
                $companyRegistData['comName']   = $joinData['company']['name'];
                $companyRegistData['comCeo']    = $this->input->post('comCeo');
                $companyRegistData['comEmail']  = $this->input->post('comEmailId').'@'.$this->input->post('comEmailHost');
                $companyRegistData['comNumber'] = $joinData['company']['number'];
                $companyRegistData['comPhone']  = $this->input->post('comPhone1').'-'.$this->input->post('comPhone2').'-'.$this->input->post('comPhone3');
                $companyRegistData['comMobile'] = $this->input->post('comPcs1').'-'.$this->input->post('comPcs2').'-'.$this->input->post('comPcs3');
                $companyRegistData['comZip']    = $this->input->post('comZip');
                $companyRegistData['comAddr1']  = $this->input->post('comAddr1');
                $companyRegistData['comAddr2']  = $this->input->post('comAddr2');

                //사업자 가입
                $companyId = $this->memberModel->registCompany($companyRegistData);

                //user set
                $registData                = [];
                $registData['companyId']   = $companyId;
                $registData['memType']     = 'C';
                $registData['requestInfo'] = 'C';
                $registData['userId']      = $this->input->post('userId');
                $registData['pw']          = $this->input->post('pw');
                $registData['authorized']  = ($memberRegRule['b2b_auth_type'] == "A" ? 'Y' : 'N');
                $registData['agentType']   = (is_mobile() ? 'M' : 'W');
                $registData['name']        = $this->input->post('userName');
                $registData['ci']          = $authData['ci'];
                $registData['di']          = $authData['di'];
                $registData['birthday']    = $authData['birthday'];
                $registData['birthdayDiv'] = $authData['birthdayDiv'];
                $registData['email']       = $this->input->post('emailId').'@'.$this->input->post('emailHost');
                $registData['info']        = $joinData['receive']['email'];
                $registData['pcs']         = $authData['pcs'];
                $registData['sms']         = $joinData['receive']['sms'];
                $registData['tel']         = '';
                $registData['sexDiv']      = $authData['sexDiv'];
                $registData['gpIx']        = DEFAULT_GPIX;
                $registData['date']        = date('Y-m-d H:i:s');

                // 회원 등록
                $userCode = $this->memberModel->registMember($registData);

                $registData['code'] = $userCode;

                // UserCode set
                $this->setFlashData('userCode', $userCode);

                // 세션 데이타 삭제
                $this->memberModel->resetAuthSession();
                $this->memberModel->resetJoinSession();

                // 개인정보 동의 로그
                if (is_array($joinData['policy'])) {
                    foreach ($joinData['policy'] as $piIx) {
//                        해당 부분은 이벤트가 아닌 바로 모델로 처리 필요
//                        $this->event->emmit('insertAgreementHistory', [
//                            'piIx' => $piIx,
//                            'userCode' => $userCode,
//                            'userId' => $registData['userId'],
//                            'name' => $registData['name'],
//                            'memType' => 'M'
//                        ]);
                    }
                }

                return [
                    'user' => $registData
                    , 'company' => $companyRegistData
                ];
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 인증으로 인한 회원 조회
     */
    public function searchUserByCertify()
    {
        $authData = $this->memberModel->getAuthSessionData();
        $userData = $this->memberModel->getUserDataByCi($authData['ci']);

        if (isset($userData['code']) && $userData['code']) {
            $this->setResponseResult('success');
        } else {
            $this->setResponseResult('noSearchUser');
        }
    }

    /**
     * 사업자 조회
     */
    public function searchCompany()
    {
        $chkField = [
            'comName', 'comCeo', 'comNumber1', 'comNumber2', 'comNumber3'
        ];

        if (form_validation($chkField)) {
            $comNumber = $this->input->post('comNumber1').'-'.$this->input->post('comNumber2').'-'.$this->input->post('comNumber3');
            $comData   = $this->memberModel->searchCompany($this->input->post('comName'), $comNumber, $this->input->post('comCeo'));

            if (isset($comData['company_id']) && $comData['company_id']) {
                //인증 세션 등록
                $this->memberModel->setAuthSessionData(['companyId' => $comData['company_id']]);

                $this->setResponseResult('success');
            } else {
                $this->setResponseResult('noSearchCompany');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 비밀번호 찾기에서 일반회원 조회
     */
    public function searchUserByCertifyAndUserData()
    {
        $chkField = ['userId', 'userName'];

        if (form_validation($chkField)) {
            $authData = $this->memberModel->getAuthSessionData();
            $userData = $this->memberModel->getUserDataByCi($authData['ci']);

            if (empty($userData['code'])) {
                $this->setResponseResult('noSearchUser');
            } elseif ($userData['id'] != $this->input->post('userId') || $userData['name'] != $this->input->post('userName')) {
                $this->setResponseResult('noMatchData');
            } else {
                //비밀번호 변경 권한 set
                $this->memberModel->setChangePasswordAccessSessionType('searchPassword');
                $this->memberModel->setChangePasswordAccessSessionUserCode($userData['code']);

                $this->setResponseResult('success');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 일반회원 비밀번호 변경
     */
    public function changePassword()
    {
        $chkField = ['pw', 'comparePw'];

        if (form_validation($chkField)) {
            // 회원코드
            $userCode     = $this->memberModel->getChangePasswordAccessSessionUserCode();
            // 비밀번호 변경
            $responseData = $this->memberModel->doChangePassword($this->input->post('pw'), $this->input->post('comparePw'));
            // 결과 확인
            if ($responseData == 'false' || $responseData == 'failActiveMember') {
                $this->setResponseResult($responseData);
            } else {
                // 휴면회원
                if ($responseData['changeType'] == 'sleep') {
                    $this->setFlashData('sleepStep', 'complete');
                }

                unset($responseData['changeType']);

                // userCode와 비밀번호를 사용하여 로그인
                $this->memberModel->useUserCodeLogin($userCode, $this->input->post('pw'));

                $this->setResponseResult('success')->setResponseData($responseData);
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 비밀번호 변경을 다음으로 미룬다.
     */
    public function passwordContinue()
    {
        if (is_login()) {
            $this->memberModel->doPasswordContinue(sess_val('user', 'code'));

            $this->setResponseResult('success');
        } else {
            $this->setResponseResult('needLogin');
        }
    }

    /**
     * 비밀번호 찾기에서 사업자 조회
     */
    public function searchCompanyByCertifyAndCompanyData()
    {
        $chkField = [
            'userId', 'comName', 'comNumber1', 'comNumber2', 'comNumber3'
        ];

        if (form_validation($chkField)) {
            $authData = $this->memberModel->getAuthSessionData();
            $userData = $this->memberModel->getUserDataByCi($authData['ci']);
            // 등록된 회원인지 확인
            if (empty($userData['code'])) {
                $this->setResponseResult('noSearchUser');
            } else {
                $comNumber = $this->input->post('comNumber1').'-'.$this->input->post('comNumber2').'-'.$this->input->post('comNumber3');
                $comData   = $this->memberModel->getCompanyData($userData['company_id']);
                // 정합성 체크
                if (
                    $userData['id'] != $this->input->post('userId') ||
                    $comData['com_name'] != $this->input->post('comName') ||
                    $comData['com_number'] != $comNumber
                ) {
                    $this->setResponseResult('noMatchData');
                } else {
                    //비밀번호 변경 권한 set
                    $this->memberModel->setChangePasswordAccessSessionType('searchPassword');
                    $this->memberModel->setChangePasswordAccessSessionUserCode($userData['code']);

                    $this->setResponseResult('success');
                }
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }
}