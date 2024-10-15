<?php

/**
 * Description of CustomMallMemberModel
 *
 * @author hoksi
 */
class CustomMallMemberModel extends ForbizMallMemberModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 회원 비밀번호 암호화
     * @param string $pw 비밀번호
     * @param string $id 사용자 ID
     * @return string
     */
    public function encryptUserPassword($pw, $id = '')
    {
        return encrypt_user_password($pw, $id);
    }

    /**
     * 무작위 5자리 숫자를 전송한다.
     * @param string $to
     * @return int
     */
    public function doCertiReq($to)
    {
        // 등록된 핸드폰인가?
        if ($this->pcsExists($to)) {
            // 등록됨
            return 'existPcs';
        } else {
            // 등록안됨
            $randnum = rand(11111, 99999);
            sms_msg_send($to, sprintf('[%s] 인증번호[%05d]를  입력해 주세요.', ForbizConfig::getCompanyInfo('shop_name'), $randnum));
            return $randnum;
        }
    }

    /**
     * 무작위 5자리 숫자를 전송한다.
     * 아이디 찾기
     * 비밀번호 찾기
     * SNS 간편로그인 회원인지 체크
     * @param string $to
     * @return int
     */
    public function doCertiSearchReq($id, $name, $pcs)
    {

        // 등록된 핸드폰인가?
        $result['code']= "";
        $result['login_type'] = "";
        $result['certifyNum'] = "";
        if ($this->pcsExists($id, $name, $pcs)) {

            // 간편로그인 ID 회원 예외처리 (fa@, nh@, ka@)
            $check_member = $this->ckeckSNSId($id, $name, $pcs);
            if (isset($check_member['sns_type'])) {
                $result['code']= "snsMember";
                $result['login_type'] = $check_member['sns_type'];
                return $result;
            } else {
                // 등록됨
                $randnum = rand(11111, 99999);
                sms_msg_send($pcs, sprintf('[%s] 인증번호[%05d]를  입력해 주세요.', ForbizConfig::getCompanyInfo('shop_name'), $randnum));
                $result['code']= "success";
                $result['certifyNum'] = $randnum;
                return $result;
            }
        } else {
            if ($this->pcsExistsSleep($id, $name, $pcs)) {
                // 간편로그인 ID 회원 예외처리 (fa@, nh@, ka@)
                $check_member = $this->ckeckSNSId($id, $name, $pcs);
                if (isset($check_member['sns_type'])) {
                    $result['code']= "snsMember";
                    $result['login_type'] = $check_member['sns_type'];
                    return $result;
                } else {
                    // 등록됨
                    $randnum = rand(11111, 99999);
                    sms_msg_send($pcs, sprintf('[%s] 인증번호[%05d]를  입력해 주세요.', ForbizConfig::getCompanyInfo('shop_name'), $randnum));
                    $result['code']= "success";
                    $result['certifyNum'] = $randnum;
                    return $result;
                }
            } else {
                // 등록안됨
                $result['code']= "notExistPcs";
                return $result;
            }
        }
    }

    /**
     * 등록된 핸드폰 번호인지 확인한다.
     * @param string $pcs
     * @return boolean
     */
    public function pcsExists($id, $name, $pcs)
    {
        $cnt = $this->qb
            ->from(TBL_COMMON_USER." as cu")
            ->join(TBL_COMMON_MEMBER_DETAIL." as cmd", 'cu.code = cmd.code', 'left')
            ->where('cu.id', $id)
            ->encryptWhere('cmd.pcs', $pcs)
            ->encryptWhere('cmd.name', $name)
            ->whereNotIn('cu.mem_type', 'A')
            ->getCount();
        return $cnt > 0;
    }

    /**
     * 등록된 핸드폰 번호인지 확인한다.(휴면회원)
     * @param string $pcs
     * @return boolean
     */
    public function pcsExistsSleep($id, $name, $pcs)
    {
        $cnt = $this->qb
            ->from(TBL_COMMON_USER_SLEEP." as cu")
            ->join(TBL_COMMON_MEMBER_DETAIL_SLEEP." as cmd", 'cu.code = cmd.code', 'left')
            ->where('cu.id', $id)
            ->encryptWhere('cmd.pcs', $pcs)
            ->encryptWhere('cmd.name', $name)
            ->whereNotIn('cu.mem_type', 'A')
            ->getCount();
        return $cnt > 0;
    }

    /**
     * 회원아이디가 SNS에서 전달받은 아이디 인지 확인한다.
     * @param string $pcs
     * @return boolean
     */
    public function ckeckSNSId($id, $name, $pcs)
    {
        $datas = $this->qb
            ->select('u.code')
            ->select('u.id')
            ->select('si.sns_type')
            ->from(TBL_COMMON_MEMBER_DETAIL.' AS md')
            ->join(TBL_COMMON_USER.' AS u', 'md.code = u.code')
            ->join(TBL_SNS_INFO.' as si', 'u.code = si.uid','left')
            ->where('u.id', $id)
            ->whereNotIn('u.mem_type', 'A')
            ->encryptWhere('md.pcs', $pcs)
            ->encryptWhere('md.name', $name)
            ->exec()->getRowArray();


        return $datas;
    }

    /**
     * 아이디 찾기 시 체크
     * @param string $pcs       핸드폰번호
     * @param string $userName  이름
     * @return string
     */
    public function doCertiIdReq($pcs, $userName)
    {
        // 등록된 핸드폰인가?
        $data = $this->nameCheck($pcs, $userName);

        if (isset($data)) {
            // 등록됨
            $mcCode                   = 'search_id';
            $templateData['mem_name'] = $userName;
            $templateData['contents'] = $data['id'];

            // 메시지 전송
            sendMessage($mcCode, '', $pcs, $templateData);

            return 'successSearch';
        } else {
            // 등록안됨
            return 'existSearch';
        }
    }

    /**
     * 비밀번호 찾기 시 체크
     * @param string $pcs       핸드폰번호
     * @param string $userId    아이디
     * @return string
     */
    public function doCertiPwReq($pcs, $userId)
    {
        // 등록된 고객인가?
        $data = $this->idCheck($pcs, $userId);

        if (isset($data)) {
            // 등록됨
            //임시비밀번호 생성
            $this->load->helper('string');
            $rand_str = strtolower(random_string('alnum', 10));

            // sms_msg_send($pcs, '임시비밀번호는 [' . $rand_str . '] 입니다.', ForbizConfig::getCompanyInfo('shop_name'));
            $mcCode                   = 'search_pw';
            $templateData['mem_name'] = $data['name'];
            $templateData['contents'] = $rand_str;

            sendMessage($mcCode, '', $pcs, $templateData);

            //DB에서 고객 임시비밀번호 업데이트
            $temp_pw = encrypt_user_password($rand_str, $data['id']);
            $this->pwChange($data['id'], $temp_pw);

            return $rand_str;
        } else {
            // 등록안됨
            return 'existSearch';
        }
    }

    /**
     * 등록된 이름인지 확인한다.
     * @param string $pcs   핸드폰번호
     * @param string $userName  이름
     * @return string
     */
    public function nameCheck($pcs, $userName)
    {
        $row = $this->qb
            ->select('u.id')
            ->from(TBL_COMMON_MEMBER_DETAIL.' AS md')
            ->join(TBL_COMMON_USER.' AS u', 'md.code = u.code')
            ->encryptWhere('md.pcs', $pcs)
            ->encryptWhere('md.name', $userName)
            ->exec()
            ->getRowArray();

        return $row;
    }

    /**
     * 등록된 아이디인지 확인한다.
     * @param string $pcs       핸드폰번호
     * @param string $userId    아이디
     * @return string
     */
    public function idCheck($pcs, $userId)
    {
        $row = $this->qb
            ->select('u.id')
            ->decryptSelect('md.name')
            ->from(TBL_COMMON_MEMBER_DETAIL.' AS md')
            ->join(TBL_COMMON_USER.' AS u', 'md.code = u.code')
            ->encryptWhere('md.pcs', $pcs)
            ->where('u.id', $userId)
            ->exec()
            ->getRowArray();

        return $row;
    }

    /**
     * 비밀번호 찾기 시 임시비밀번호로 변경
     * @param string $id        아이디
     * @param string $temp_pw   임시비밀번호
     */
    public function pwChange($id, $temp_pw)
    {
        return $this->qb
                ->set('pw', $temp_pw)
                ->where('id', $id)
                ->update(TBL_COMMON_USER)
                ->exec();
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
            if (BASIC_LANGUAGE == 'english') {
                $_SESSION['user']['pcs'] = "{$data['national_phone']}-{$data['pcs']}" ?? '';
            } else {
                $_SESSION['user']['pcs'] = $data['pcs'] ?? '010--';
            }
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

        // 회사 전화번호가 있는 경우
        if (isset($data['comTel1'])) {
            $this->qb->encryptSet('com_tel', ($data['comTel2'] ? "{$data['comTel1']}-{$data['comTel2']}-{$data['comTel3']}" : ''));
        }

        // 생일 정보가 있는 경우
        if (isset($data['birthdayDiv'])) {
            $this->qb->set('birthday_div', $data['birthdayDiv']);
        }
        if (isset($data['birthYear']) && isset($data['birthMonth']) && isset($data['birthDay'])) {
            $birthday = $data['birthYear']."-".$data['birthMonth']."-".$data['birthDay'];
            $this->qb->set('birthday', $birthday);
        }

        // 회사 우편번호와 회사 주소가 있는 경우
        if (isset($data['rZipcode'])) {
            $this->qb->encryptSet('r_zipcode', $data['rZipcode'])
                ->encryptSet('r_addr1', $data['rAddr1'])
                ->encryptSet('r_addr2', $data['rAddr2']);
        }

        // 지역정보 입력한 경우
        if (isset($data['area'])) {
            $this->qb->set('area', $data['area']);
        }

        //Country 정보 여부
        if (isset($data['country'])) {
            $this->qb->set('country', $data['country']);
        }

        //City 정보 여부
        if (isset($data['city'])) {
            $this->qb->set('city', $data['city']);
        }
        //state 정보 여부
        if (isset($data['state'])) {
            $this->qb->set('state', $data['state']);
        }

        return $this->qb
                ->set('di', md5(str_replace('-', '', $_SESSION['user']['pcs'])))
                ->encryptSet('pcs', $_SESSION['user']['pcs'])
                ->encryptSet('mail', $_SESSION['user']['mail'])
                ->set('sms', $data['sms'] ?? '0')
                ->set('info', $data['info'] ?? '0')
				->set('agree_infodate', ($data['oldInfo'] == $data['info'] ? $data['agree_infodate'] : date('Y-m-d H:i:s'))) // 이메일수신 동의 및 미동의 시간
				->set('smsdate', ($data['oldSms'] == $data['sms'] ? $data['smsdate'] : date('Y-m-d H:i:s'))) // 이메일수신 동의 및 미동의 시간
                ->set('sex_div', $data['gender'] ?? 'M')
                ->where('code', sess_val('user', 'code'))
                ->update(TBL_COMMON_MEMBER_DETAIL)
                ->exec();
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

        /* @var $orderModel CustomMallMileageModel */
        $mileageModel = $this->import('model.mall.mileage');

        if ($orderModel->hasOngoingOrder($data['code'])) {
            // 배송중 주문 있음
            return 'hasOrder';
        } else {
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
                ->set('dropdate', date('Y-m-d H:i:s'))
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

            //회원 탈퇴시 마일리지 소멸
            $mileageModel->withdrawExtinctionMileage($data['code']);

            // 트랜잭션 Complete
            $this->qb->transComplete();


            // SNS 정보 여부 확인
            $sns_data = $this->qb
                    ->from(TBL_SNS_INFO)
                    ->where('uid', $data['code'])
                    ->exec()->getRowArray();

            $sns_login = sess_val('sns_login');

            if (is_array($sns_login) && !empty($sns_data['sns_type'])) {
                if (is_array($sns_login[$sns_data['sns_type']])) {
                    if ($sns_data['sns_id'] == $sns_login[$sns_data['sns_type']]['sns_info']['id']) {
                        /* @var $snsModel CustomMallSnsLoginModel */
                        $snsModel = $this->import('model.mall.snsLogin');

                        if ($sns_data['sns_type'] == 'kakao') {
                            $snsModel->kakaoUnlink();
                            $snsModel->kakaoLogOut();
                        } else if ($sns_data['sns_type'] == 'naver') {
                            $snsModel->naver_delete();
                        }
                    }
                }
            }

            // SNS 정보 삭제
            $this->qb
                ->where('uid', $data['code'])
                ->delete(TBL_SNS_INFO)
                ->exec();



            // 이메일 전송 이벤트 호출
            $this->event->trigger('withdrowMemberSendEmail',
                [
                    'mem_name' => $data['name'],
                    'mem_mail' => $data['mail'],
                    'mem_id' => $data['id'],
                    'mem_mobile' => $data['pcs'],
                    'msg_code' => '0102',
                    'exit_date' => date('Y-m-d')
            ]);

            return 'success';
        }
    }

    /**
     * customRecencyInfo
     * @param array $argList
     * @return array
     */
    public function customRecencyInfo(...$argList)
    {
        if (count($argList) > 0) {

            $data = $this->qb
                ->select('pi_ix')
                ->select('pi_code')
                ->select('left(startdate, 10) as regdate')
                ->select('pi_contents')
                ->from(TBL_SHOP_POLICY_INFO)
                ->where('disp', 'Y')
                ->whereIN('pi_code', implode("', '", $argList))
                ->orderBy('startdate', 'DESC')
                ->exec()
                ->getResultArray();

            //echo $this->qb->lastQuery();

            return ['recency' => $data];
        }

        return [];
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
			->select('cmd.smsdate')
			->select('cmd.agree_infodate')
            ->select('cmd.area')
            ->select('cmd.country')
            ->select('cmd.city')
            ->select('cmd.state')
            ->select('cmd.date')
            ->decryptSelect('cmd.name')
            ->decryptSelect('cmd.mail')
            ->decryptSelect('cmd.zip')
            ->decryptSelect('cmd.addr1')
            ->decryptSelect('cmd.addr2')
            ->decryptSelect('cmd.tel')
            ->decryptSelect('cmd.pcs')
            ->decryptSelect('cmd.com_tel')
            ->decryptSelect('cmd.r_zipcode')
            ->decryptSelect('cmd.r_addr1')
            ->decryptSelect('cmd.r_addr2')
            ->from(TBL_COMMON_USER.' as cu')
            ->join(TBL_COMMON_MEMBER_DETAIL.' as cmd', 'cu.code=cmd.code')
            ->where('cu.code', $userCode)
            ->exec()
            ->getRowArray();

        if (isset($data['id'])) {
            $data['tel']  = explode('-', ($data['tel'] ?? '02--'));
            $data['pcs']  = explode('-', $data['pcs']);
            $data['mail'] = explode('@', $data['mail']);

            $data['com_tel'] = explode('-', ($data['com_tel'] ?? '02--'));
        }
		if($data['smsdate'] != ""){
			$data['viewSmsdate'] = substr($data['smsdate'],0,4).".".substr($data['smsdate'],5,2).".".substr($data['smsdate'],8,2);
		}else{
			$data['smsdate'] = date('Y-m-d H:i:s');
		}
		if($data['agree_infodate'] != ""){
			$data['viewInfodate'] = substr($data['agree_infodate'],0,4).".".substr($data['agree_infodate'],5,2).".".substr($data['agree_infodate'],8,2);
		}else{
			$data['agree_infodate'] = date('Y-m-d H:i:s');
		}

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
                $data['comName']   = $joinData['company']['name'];
                $data['comNumber'] = $joinData['company']['number'];
            }
        } else {

            /* 본인 인증 여부 확인 */
//            $memberRegRule                = ForbizConfig::getSharedMemory("member_reg_rule");
//            $authData                     = $this->getAuthSessionData();
//
//            if (($memberRegRule['mall_use_ipin'] == "Y" || ($memberRegRule['mall_use_certify'] ?? '') == "Y") && empty($authData['ci'])) {
//                return false;
//            } else {
//                $data['userName']             = $authData['name'];
//                $data['changeFormatBirthday'] = date('Y년 m월 d일', strtotime($authData['birthday']));
//                $data['changeFormatSexDiv']   = ($authData['sexDiv'] == 'M' ? "남성" : "여성");
//                $data['explodePcs']           = explode("-", $authData['pcs']);
//            }
        }

        return $data;
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
            ->set('pw', $this->encryptUserPassword($data['pw'], $data['userId']))
            ->set('mem_type', ($data['memType'] ?? 'M')) //회원 타입 : M:일반회원 C: 사업자 A: 직원 F:글로벌
            ->set('mem_div', ($data['memDiv'] ?? 'D')) //S: 셀러 MD : MD담당자 D:아무도 아닌경우
            ->set('authorized', $data['authorized']) //Y : 자동승인, N : 수동승인
            ->set('auth', ($data['auth'] ?? '0'))
            ->set('request_info', ($data['requestInfo'] ?? 'M')) //M : 일반회원 요청
            ->set('request_yn', ($data['requestYn'] ?? 'Y')) //Y : 요청 승인
            ->set('agent_type', ($data['agentType'] ?? 'W')) //W : pc, M : mobile
            ->set('ip', $_SERVER['REMOTE_ADDR'])
            ->set('user_agent', $_SERVER["HTTP_USER_AGENT"])
            ->set('date', ($data['date'] ?? date('Y-m-d H:i:s')))
            ->set('regdate_desc', (time() * -1))
            ->set('last', ($data['date'] ?? date('Y-m-d H:i:s')))
            ->set('mall_ix', MALL_IX)
            ->set('language', BASIC_LANGUAGE)
            ->insert(TBL_COMMON_USER)
            ->exec();

        $this->qb
            ->set('code', $userCode)
            //->set('ci', $data['ci'])
            //->set('di', $data['di'])
            ->set('birthday', $data['birthday'])
            ->set('birthday_div', ($data['birthdayDiv'] ?? '1')) //1:양력, 0:음력
            ->encryptSet('name', $data['name'])
            ->encryptSet('mail', $data['email'])
            ->encryptSet('pcs', $data['pcs'])
            ->encryptSet('tel', $data['tel'])
            ->encryptSet('zip', ($data['zip'] ?? ''))
            ->encryptSet('addr1', ($data['addr1'] ?? ''))
            ->encryptSet('addr2', ($data['addr2'] ?? ''))
            ->set('area', ($data['area'] ?? ''))
            ->set('info', ($data['info'] ?? '0')) // 1,0
            ->set('sms', ($data['sms'] ?? '0')) // 1,0
			->set('agree_infodate', ($data['date'] ?? date('Y-m-d H:i:s'))) // 이메일수신 동의 및 미동의 시간
            ->set('smsdate', ($data['date'] ?? date('Y-m-d H:i:s')))		// sms수신 동의 및 미동의 시간
			->set('collection', ($data['collection'] ?? '0')) // 1,0
            ->set('sex_div', ($data['sexDiv'] ?? 'M')) //M:남성, W:여성, D:기타
            ->set('gp_ix', ($data['gpIx'] ?? '1')) //1 : 일반회원 하드코딩
            ->set('date', ($data['date'] ?? date('Y-m-d H:i:s')));

        if (BASIC_LANGUAGE == 'english') {
            $this->qb
                ->set('nationality', 'E')
                ->set('country', $data['country'])
                ->set('city', $data['city'])
                ->set('state', $data['state'])
            ;
        } else {
            $this->qb->set('nationality', 'O');
        }
        $this->qb
            ->insert(TBL_COMMON_MEMBER_DETAIL)
            ->exec();

        // 가입시 입력한 주소값으로 기본배송지로 저장
        $addressData['default_yn']    = 'Y';
        $addressData['mode']          = 'insert';
        $addressData['shipping_name'] = trans('기본배송지');
        $addressData['mobile']        = $data['pcs'];
        $addressData['recipient']     = $data['name'];
        $addressData['tel']           = $data['tel'];
        $addressData['zip']           = $data['zip'];
        $addressData['addr1']         = $data['addr1'];
        $addressData['addr2']         = $data['addr2'];
        if (BASIC_LANGUAGE == 'english') {
            $addressData['country'] = $data['country'];
            $addressData['city']    = $data['city'];
            $addressData['state']   = $data['state'];
        }
		if($data['zip'] != ""){
			if($data['pcs'] != "--"){
				$this->addressBookReplace($userCode, $addressData);
			}
		}

        return $userCode;
    }

    /**
     * 회원가입시 id 체크
     * @param $userId
     * @return bool
     */
    public function checkUserId($userId)
    {
        $denyId         = ForbizConfig::getConfig('mall_deny_id');
        $userCheck      = $this->qb->from(TBL_COMMON_USER)->where('id', $userId)->where('mall_ix', MALL_IX)->getCount();
        $droupUserCheck = $this->qb->from(TBL_COMMON_DROPMEMBER)->where('id', $userId)->where('mall_ix', MALL_IX)->getCount();
        $sleepUserCheck = $this->qb->from(TBL_COMMON_USER_SLEEP)->where('id', $userId)->where('mall_ix', MALL_IX)->getCount();

        if (in_array($userId, $denyId)) {
            $returnData = "fail";
            return $returnData;
        }

        if ($userCheck > 0 || $sleepUserCheck > 0) {
            $returnData = "fail";
            return $returnData;
        }

        if ($droupUserCheck > 0) {
            $returnData = "withdrawn";
            return $returnData;
        }

        return "success";
    }

    /**
     * User code를 이용하여 고객명을 가져온다.
     * @param string $userCode
     * @return array
     */
    public function getMemberName($userCode)
    {
        $data = $this->qb
            ->select('cu.id')
            ->decryptSelect('cmd.name')
            ->decryptSelect('cmd.mail')
            ->from(TBL_COMMON_USER.' as cu')
            ->join(TBL_COMMON_MEMBER_DETAIL.' as cmd', 'cu.code=cmd.code')
            ->where('cu.code', $userCode)
            ->exec()
            ->getRowArray();

        if (isset($data['id'])) {
            $this->setAuthSessionData($data);
        }

        return $data;
    }

    /**
     * User code를 이용하여 가입일을 가져온다.
     * @param string $userCode
     * @return array
     */
    public function getMemberDate($userCode)
    {
        $data = $this->qb
            ->select('cu.date')
            ->from(TBL_COMMON_USER.' as cu')
            ->join(TBL_COMMON_MEMBER_DETAIL.' as cmd', 'cu.code=cmd.code')
            ->where('cu.code', $userCode)
            ->exec()
            ->getRowArray();

        if (isset($data['id'])) {
            $this->setAuthSessionData($data);
        }

        return $data;
    }

    /**
     * 아이디 찾기 (회원 이름, 회원 이메일)
     * 회원별 다중 아이디 존재 가능
     * @param $userName, $userEmail
     * @return array
     */
    public function getUserIdByEmail($userName, $userEmail, $userId = '')
    {

        $this->qb
            ->select('cu.code')
            ->select('cu.id')
            ->decryptSelect('md.name')
            ->select("'일반' as memState")
            ->from(TBL_COMMON_MEMBER_DETAIL.' AS md')
            ->join(TBL_COMMON_USER.' AS cu', 'md.code = cu.code')
            ->encryptWhere('md.mail', $userEmail);
            //->where("cu.language", BASIC_LANGUAGE);
        if (BASIC_LANGUAGE == 'korean') {
            $this->qb->encryptWhere('md.name', $userName);
        }
        if ($userId != '') {
            $this->qb->where('cu.id', $userId);
        }
        // 어드민 계정 제외
        $this->qb->where('cu.mem_type != ', 'A');
        $userRows = $this->qb->exec()
            ->getResultArray();

        $this->qb
            ->select('cu.code')
            ->select('cu.id')
            ->decryptSelect('md.name')
            ->select("'휴면' as memState")
            ->from(TBL_COMMON_MEMBER_DETAIL_SLEEP.' AS md')
            ->join(TBL_COMMON_USER_SLEEP.' AS cu', 'md.code = cu.code')
            ->encryptWhere('md.mail', $userEmail);
            //->where("cu.language", BASIC_LANGUAGE);
        if (BASIC_LANGUAGE == 'korean') {
            $this->qb->encryptWhere('md.name', $userName);
        }
        if ($userId != '') {
            $this->qb->where('cu.id', $userId);
        }
        // 어드민 계정 제외
        $this->qb->where('cu.mem_type != ', 'A');
        $sleepRows = $this->qb->exec()
            ->getResultArray();

        $rows = array_merge($userRows, $sleepRows);

        $result['login_type'] = "";
        if (count($rows) > 0) {
            $snsList = $this->qb
                ->select('uid')
                ->select('sns_type')
                ->from(TBL_SNS_INFO)
                ->whereIn('uid', array_column($rows, 'code'))
                ->exec()
                ->getResultArray();

            $this->setAuthSessionData($rows);
            foreach ($rows as $key => $val) {
                foreach ($snsList as $sns) {
                    if ($val['code'] == $sns['uid']) {
                        unset($rows[$key]);
                        $result['login_type'] = $sns['sns_type'];
                    }
                }
            }
            if (count($rows) > 0) {
                $result['code'] = 'success';
                $result['data'] = $rows;
            } else {
                $result['code'] = 'fail';
            }
        } else {
            $result['code'] = 'fail';
        }

        return $result;
    }

    /**
     * 아이디 찾기 (회원 이름, 회원 전화번호)
     * 회원별 다중 아이디 존재 가능
     * @param $userName, $userPhone
     * @return array
     */
    public function getUserIdByPhone($userName, $userPhone)
    {

        $userRows = $this->qb
            ->select('cu.code')
            ->select('cu.id')
            ->decryptSelect('md.name')
            ->select("'일반' as memState")
            ->from(TBL_COMMON_MEMBER_DETAIL.' AS md')
            ->join(TBL_COMMON_USER.' AS cu', 'md.code = cu.code')
            ->encryptWhere('md.pcs', $userPhone)
            ->encryptWhere('md.name', $userName)
            ->where('cu.mem_type != ', 'A')
            ->exec()
            ->getResultArray();

        $sleepRows = $this->qb
            ->select('cu.code')
            ->select('cu.id')
            ->decryptSelect('md.name')
            ->select("'휴면' as memState")
            ->from(TBL_COMMON_MEMBER_DETAIL_SLEEP.' AS md')
            ->join(TBL_COMMON_USER_SLEEP.' AS cu', 'md.code = cu.code')
            ->encryptWhere('md.pcs', $userPhone)
            ->encryptWhere('md.name', $userName)
            ->where('cu.mem_type != ', 'A')
            ->exec()
            ->getResultArray();

        $rows = array_merge($userRows, $sleepRows);

        if (count($rows) > 0) {
            $snsList = $this->qb
                ->select('uid')
                ->from(TBL_SNS_INFO)
                ->whereIn('uid', array_column($rows, 'code'))
                ->exec()
                ->getResultArray();

            $this->setAuthSessionData($rows);
            foreach ($rows as $key => $val) {
                foreach ($snsList as $sns) {
                    if ($val['code'] == $sns['uid']) {
                        unset($rows[$key]);
                    }
                }
            }
            if (count($rows) > 0) {
                $result['code'] = 'success';
                $result['data'] = $rows;
            } else {
                $result['code'] = 'fail';
            }
        } else {
            $result['code'] = 'fail';
        }

        return $result;
    }

    /**
     * 패스워드를 찾기 위한 회원 검증
     * @param $userName, $userPhone
     * @return usercode
     */
    public function searchUserPassword($userId, $userName, $searchType, $userEmail, $userPcs)
    {

        $this->qb->startCache();
        $this->qb
            ->select('cu.code')
            ->decryptSelect('md.name')
            ->from(TBL_COMMON_MEMBER_DETAIL.' AS md')
            ->join(TBL_COMMON_USER.' AS cu', 'md.code = cu.code')
            ->where("cu.id", $userId);
            //->where("cu.language", BASIC_LANGUAGE);

        if (BASIC_LANGUAGE == 'korean') {
            $this->qb->encryptWhere('md.name', $userName);
        }


        if ($searchType == 'phone') {
            $this->qb->encryptWhere("md.pcs", $userPcs);
        } else {
            $this->qb->encryptWhere("md.mail", $userEmail);
        }

        $this->qb->stopCache();
        $rows = $this->qb->exec()->getResultArray();
        $this->qb->flushCache();

        if (count($rows) > 0) {
            $this->setAuthSessionData($rows);
            $result['code'] = 'success';
            $result['data'] = $rows['0']['code'];
        } else {
            $this->qb->startCache();
            $this->qb
                ->select('cu.code')
                ->decryptSelect('md.name')
                ->from(TBL_COMMON_MEMBER_DETAIL_SLEEP.' AS md')
                ->join(TBL_COMMON_USER_SLEEP.' AS cu', 'md.code = cu.code')
                ->where("cu.id", $userId);
                //->where("cu.language", BASIC_LANGUAGE);

            if (BASIC_LANGUAGE == 'korean') {
                $this->qb->encryptWhere('md.name', $userName);
            }


            if ($searchType == 'phone') {
                $this->qb->encryptWhere("md.pcs", $userPcs);
            } else {
                $this->qb->encryptWhere("md.mail", $userEmail);
            }

            $this->qb->stopCache();
            $rows = $this->qb->exec()->getResultArray();
            $this->qb->flushCache();

            if (count($rows) > 0) {
                $this->setAuthSessionData($rows);
                $result['code'] = 'success';
                $result['data'] = $rows['0']['code'];
            } else {
                $result['code'] = 'fail';
            }
        }

        return $result;
    }

    /**
     * 비밀번호 변경일자 수정
     * @param $userCode
     * @param $date
     */
    public function updateChangePasswordDate($userCode)
    {
        $pwDays    = ForbizConfig::getPrivacyConfig('change_pw_day');
        $delayDays = ForbizConfig::getPrivacyConfig('change_pw_continue_day');

        $settingDate = intval($pwDays) - intval($delayDays);
        return $this->qb
                ->set('change_pw_date', "date_sub(now(), INTERVAL {$settingDate} DAY)", false)
                ->where('code', $userCode)
                ->update(TBL_COMMON_USER)
                ->exec();
    }

    /**
     * 배송지 총 개수
     */
    public function getAddressBookCnt($userCode)
    {
        $this->qb
            ->where('mem_ix', $userCode)
            ->from(TBL_SHOP_SHIPPING_ADDRESS);

        // Get total rows
        return $this->qb->getCount();
    }

    public function getAddressBookDefaultCnt($userCode)
    {
        $this->qb
            ->where('mem_ix', $userCode)
            ->where('default_yn', 'Y')
            ->from(TBL_SHOP_SHIPPING_ADDRESS);

        // Get total rows
        return $this->qb->getCount();
    }

    /**
     * 비밀번호 변경
     * @overwrite
     * 이전 비밀번호 사용 불가
     * @param string $pw
     * @param string $comparePw
     * @return string
     */
    public function doChangePassword($pw, $comparePw)
    {
        $changeType = $this->getChangePasswordAccessSessionType();
        $userCode   = $this->getChangePasswordAccessSessionUserCode();


        if (empty($userCode) || $pw != $comparePw) {
            $ret = 'false';
        } else {
            $ret = [
                'changeType' => $changeType,
                'url' => '/member/searchPwResult'
            ];

            if ($changeType == 'sleep') {
                // 휴면회원 복구
                if ($this->activeMember($userCode, "회원 로그인 시도 후 휴면 해지 진행") !== true) {
                    return 'failActiveMember';
                } else {
                    $ret['url'] = ForbizConfig::getPrivacyConfig('sleep_user_release');
                }
            }

            $encryptPw = $this->encryptUserPassword($pw);

            //현재 사용중인 비밀번호와 비교
            if ($this->compareCurrentPassword($userCode, $encryptPw)) {
                return 'equalCurrentPw';
            }

            //현재 사용중인 비밀번호와 비교(휴면)
            if ($this->compareCurrentPasswordSleep($userCode, $encryptPw)) {
                return 'equalCurrentPw';
            }


            // 비밀번호 변경
            $this->updatePassword($userCode, $encryptPw);
            // 비밀번호 변경(휴면)
            $this->updatePasswordSleep($userCode, $encryptPw);
            //정기 비밀번호 변경
            $this->setChangePasswordSession(false);
        }

        $this->resetChangePasswordAccessSession();

        return $ret;
    }

    /**
     * 현재비밀번호와 새로운 비밀번호와 비교
     */
    public function compareCurrentPassword($userCode, $encryptPw)
    {
        $res = $this->qb->select('pw')
                ->from(TBL_COMMON_USER)
                ->where('code', $userCode)
                ->exec()->getRowArray();

        if ($res['pw'] == $encryptPw) return true;
        else return false;
    }

    /**
     * 현재비밀번호와 새로운 비밀번호와 비교(휴면)
     */
    public function compareCurrentPasswordSleep($userCode, $encryptPw)
    {
        $res = $this->qb->select('pw')
            ->from(TBL_COMMON_USER_SLEEP)
            ->where('code', $userCode)
            ->exec()->getRowArray();

        if ($res['pw'] == $encryptPw) return true;
        else return false;
    }

    /**
     * 배송지를 추가한다.
     * @overwrite
     * 등록일 추가
     * @param array $data
     * @return int
     */
    public function addressBookReplace($userCode, $data)
    {
        $data['default_yn'] = ($data['default_yn'] ?? 'N');

        $tel = ($data['tel'] ?? (!empty($data['tel2']) && !empty($data['tel3']) ? "{$data['tel1']}-{$data['tel2']}-{$data['tel3']}" : ""));

        if (BASIC_LANGUAGE == 'english') {
            $mobile = ($data['mobile'] ?? (!empty($data['pcs']) ? "{$data['national_phone']}-{$data['pcs']}" : ""));
        } else {
            $mobile = ($data['mobile'] ?? (!empty($data['pcs2']) && !empty($data['pcs3']) ? "{$data['pcs1']}-{$data['pcs2']}-{$data['pcs3']}" : ""));
        }


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
            ->set('default_yn', $data['default_yn'])
            ->set('regdate', 'now()', false)
        ;

        if (BASIC_LANGUAGE == 'english') {
            $this->qb
                ->set('country', $data['country'])
                ->set('city', $data['city'])
                ->set('state', $data['state']);
        }

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
     * 크리마 회원 연동
     */
    public function cronCremaPutMember()
    {

        $sdate = date('Y-m-d 00:00:00', strtotime('-1 day'));
        $edate = date('Y-m-d 23:59:59', strtotime('-1 day'));

        $rows = $this->qb
            ->select('u.id')
            ->decryptSelect('m.name')
            ->decryptSelect('m.pcs')
            ->select('m.sms')
            ->decryptSelect('m.mail')
            ->select('m.info')
            ->select('m.gp_ix')
            ->select('u.last')
            ->select('m.birthday')
            ->select('m.date')
            ->from(TBL_COMMON_USER.' as u')
            ->join(TBL_COMMON_MEMBER_DETAIL.' as m', 'u.code = m.code')
            ->betweenDate('date', $sdate, $edate)
            ->exec()
            ->getResultArray();


        //crema api
        $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);
        foreach ($rows as $key => $val) {
            if (!$val['birthday']) {
                $val['birthday'] = null;
            }

			if ($val['gp_ix'] == "14") {
                $user_grade_id = '9';
            } else {
                $user_grade_id = NULL;
            }

            $param = ['user_id' => $val['id']
                , 'user_name' => $val['name']
                , 'created_at' => date('Y-m-d\TH:i:sO', strtotime($val['date']))
                , 'user_phone' => $val['pcs']
                , 'allow_sms' => $val['sms'] //sms수신허용
                , 'user_email' => $val['mail'] //필수는 아님
                , 'allow_email' => $val['info'] //email 수신허용
                , 'user_grade_id' => $user_grade_id
                , 'last_logged_in_at' => date('Y-m-d\TH:i:sO', strtotime($val['date'])) //마지막로그인기록 하지만 회원 생성 기준으로는 없을수 있음
                , 'active' => 1 //활성회원여부
                , 'birth_date' => $val['birthday']
            ];
            $data  = $this->cremaModel->putUser($param);
        }
    }

    /**
     * 가입동의 데이타
     * @param string $joinType
     * @return array
     */
    public function doJoinAgreementGlobal($joinType)
    {
        $data = [];

        $data['joinType'] = $joinType;
        $data['mallName'] = ForbizConfig::getCompanyInfo('shop_name');

        /* @var $companyModel CustomMallCompanyModel */
        $companyModel = $this->import('model.mall.company');

        $data['policyData'] = $companyModel->getPolicy('use_global', 'collection_global', 'consign_global', 'third_global', 'marketing_global');

        return $data;
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
			//	ig_로그인 실패시 처리
				if(trim($id) != "") {
						$this->qb
							->set('fail_count', 'fail_count +1', false)
							->where('id', $id)
							->update(TBL_COMMON_USER)
							->exec();


						//	로그인 실패 횟수 체크
							$ig_row = $this->qb
								->select('fail_count')
								->from(TBL_COMMON_USER)
								->where('id', $id)
								->exec()
								->getRowArray();

							if (!empty($ig_row)) {
								if($ig_row["fail_count"] >= "5") {
									//	실패회수가 5회 이상일 경우 캡차 실행
						            return "fail_ig";
								} else {
						            return "fail";
								}
							}
						//	//로그인 실패 횟수 체크
				}

            //	_로그인 실패시 member_log 입력 처리
            $mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

            if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){
                $gubun = "M";
            }else{
                $gubun = "P";
            }

            $this->qb
                ->set('mem_id', $id)
                ->set('ip', $_SERVER['REMOTE_ADDR'])
                ->set('gubun', $gubun)
                ->set('log_date', date('Y-m-d H:i:s'))
                ->set('log_div', 'N')
                ->insert("member_log")
                ->exec();
            //	_로그인 실패시 member_log 입력 처리
			//	ig_로그인 실패시 처리


            return "fail";
        } else {
            //sns회원 여부
            $snsMember = $loginModel->isSnsMemberInfo($userAuthData['code']);
            if(isset($snsMember['sns_id'])){
                //sns 회원 으로 접근 하였으나 sns 접근 세션이 없을경우 정상적이지 않은 방법으로 로그인 시도로 판단하여 접근 금지 처리
                if(!isset($_SESSION['sns_login'][$snsMember['sns_type']])){
                    return 'snsAccount';
                }
            }

						//	로그인 실패 횟수 체크
							$ig_row = $this->qb
								->select('fail_count')
								->from(TBL_COMMON_USER)
								->where('id', $id)
								->exec()
								->getRowArray();

							if (!empty($ig_row)) {
								if($ig_row["fail_count"] >= "5") {
									//	실패회수가 5회 이상일 경우 캡차 실행
						            return "fail_ig";
								} else {

								}
							}
						//	//로그인 실패 횟수 체크



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
                    if ($this->isChangePassword($userAuthData['change_pw_date'], $userAuthData['date']) && $loginModel->isSnsMember($userAuthData['code'])
                        === false) {
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
                //서비스 부하 발생 가능성으로 히스토리 삭제 스케줄 시스템으로 변경 (관리자 크론 동작)
                //$loginModel->deleteConnectUserLog(ForbizConfig::getPrivacyConfig('member_connect_delete_day'));
                //로그인 히스토리 정보 등록
                $loginModel->connectUserLog($id, $userAuthData['code'], 'login');

                //자동 로그인 여부 쿠키 세팅
                if ($userAuthData['authorized'] == 'Y') {
                    $connection_no = $loginModel->autoLoginCookie($id, $pw, $autoLogin, $userAuthData['code']);
                    if ($connection_no) {
                        $loginCookie['connection_no'] = $connection_no;
                    } else {
                        $loginCookie['connection_no'] = "";
                    }
                    if ($autoLogin) {
                        $loginCookie['auto_login'] = $autoLogin;
                    } else {
                        $loginCookie['auto_login'] = "";
                    }
                } else {
                    $loginCookie['connection_no'] = "";
                    $loginCookie['auto_login']    = "";
                }

                //아이디 저장
                $loginModel->saveId($id, $saveId);

                /* @var $productModel CustomMallProductModel */
                $productModel = $this->import('model.mall.product');
                // 로그인전 등록된 최근 본 상품 정보 기록
                $productModel->replaceProductViewHistory($userAuthData['code'], '');

                //로그&이커머스분석 이벤트 전파
                $this->event->emmit('MemberLoginUpdate', ['userCode' => $userAuthData['code']]);

                // 로그인 성공
                if (!empty($url)) {
                    $url = $url;
                } else {
                    $url = "/";
                }
                $return_data['url']      = $url;
                $return_data['userCode'] = $userAuthData['code'];

                $return_data['loginCookie'] = $loginCookie;


                #GTM tag 데이터 추가 전송[S]
                //$return_data['gtmTag'] = $this->getGtmMemberInfo($userAuthData['code']);
                #GTM tag 데이터 추가 전송[E]
                #airbrige tag 데이터 추가 전송[S]
                //$userInfo = $this->getMemberProfile($userAuthData['code']);
                //$return_data['airbrigeTag']['id'] = $userInfo['id'];
                //$return_data['airbrigeTag']['mail'] = $userInfo['mail'];
                #airbrige tag 데이터 추가 전송[E]
                //return ['url' => ($url ? $url : '/'), 'userCode' => $userAuthData['code']];


			//	ig_로그인 성공시 처리
				if(trim($id) != "") {
						$this->qb
							->set('fail_count', '0', false)
							->where('id', $id)
							->update(TBL_COMMON_USER)
							->exec();

				}
			//	ig_로그인 성공시 처리

			//	마일리지 동기화 처리(로그인한 회원당 최소 1회 처리)
				$tg_mileagerow = $this->qb
						->select('mileage')
						->select('code')
						->select('syncyn')
						->from(TBL_COMMON_USER)
						->where('id', $id)
						->exec()
						->getRowArray();

				if($tg_mileagerow['syncyn'] == 'N') {
					$tg_usemileagerow = $this->qb
									->select('sum(um_mileage) as um_mileage')
									->from(TBL_SHOP_USE_MILEAGE)
									->where('uid', $tg_mileagerow['code'])
									->exec()
									->getRowArray();

					$tg_addmileagerow = $this->qb
										->select('sum(am_mileage) as am_mileage')
										->from(TBL_SHOP_ADD_MILEAGE)
										->where('uid', $tg_mileagerow['code'])
										->exec()
										->getRowArray();

					$user_mileage		= $tg_mileagerow['mileage'];
					$user_use_mileage	= $tg_usemileagerow['um_mileage'];
					$user_add_mileage	= $tg_addmileagerow['am_mileage'];

					if($user_mileage == ($user_add_mileage - $user_use_mileage)) {
						$this->qb
							->set('syncyn', 'Y')
							->where('id', $id)
							->update(TBL_COMMON_USER)
							->exec();
					} else {
						$mileage = $user_add_mileage - $user_use_mileage;
						$this->qb
							->set('mileage', $mileage)
							->set('syncyn', 'Y')
							->where('id', $id)
							->update(TBL_COMMON_USER)
							->exec();
					}
				}


			//	마일리지 동기화 처리(로그인한 회원당 최소 1회 처리)

                return $return_data;
            } else {
                //로그인 히스토리 정보 등록
                $loginModel->connectUserLog($id, '', 'login');
                // 승인대기/거부 설정
                return ($userAuthData['authorized'] == "N" ? "standby" : "reject");
            }
        }
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
            ->select('country')
            ->select('city')
            ->select('state')
            ->from(TBL_SHOP_SHIPPING_ADDRESS)
            ->where('mem_ix', $userCode)
            ->where('ix', $ix)
            ->exec()
            ->getRowArray();

        if (!empty($row)) {
            $tel         = explode('-', $row['tel']);
            $row['tel1'] = $tel[0] ?? '02';
            $row['tel2'] = $tel[1] ?? '';
            $row['tel3'] = $tel[2] ?? '';

            $mobile = explode('-', $row['mobile']);
            if (BASIC_LANGUAGE == 'english') {
                $row['nation_code'] = $mobile[0] ?? '';
                $row['pcs']         = $mobile[1] ?? '';
            } else {
                $row['pcs1'] = $mobile[0] ?? '010';
                $row['pcs2'] = $mobile[1] ?? '';
                $row['pcs3'] = $mobile[2] ?? '';
            }
        }

        return $row;
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

            $limit  = $per_page;
            $offset = $paging['offset'];
        } else {
            $limit  = $per_page;
            $offset = ($cur_page - 1) * $per_page;
            $paging = false;
        }

        // Get user addressbook data
        if (BASIC_LANGUAGE == 'english') {
            $this->qb
                ->select('country')
                ->select('city')
                ->select('state');
        }
        $list = $this->qb
            ->select('ix')// 배송지키
            ->select('shipping_name')// 배송명칭
            ->select("if(default_yn = 'Y', 'Y', '') default_yn", false)// 기본주소여부
            ->select('recipient')// 수신자명
            ->select('tel')// 전화번호
            ->select('mobile')// 핸드폰번호
            ->select('zipcode')// 우편번호
            ->select('address1')// 주소
            ->select('address2')// 상세주소
            ->orderBy('ix', 'desc')
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();

        $this->qb->flushCache();

        if (BASIC_LANGUAGE == 'english') {
            if (!empty($list)) {
                foreach ($list as $key => $val) {
                    if (!empty($val['country'])) {
                        $nation = $this->qb
                                ->select('nation_name')
                                ->from(TBL_GLOBAL_NATION_CODE)
                                ->where('nation_code', $val['country'])
                                ->exec()->getRowArray();

                        $list[$key]['nation_name'] = $nation['nation_name'];
                    }

                    if ($val['mobile']) {
                        $mobileArr            = explode('-', $val['mobile']);
                        $list[$key]['mobile'] = "+".$mobileArr[0]." ".$mobileArr[1];
                    }
                }
            }
        }

        return [
            'list' => $list,
            'paging' => $paging,
            'total' => $total
        ];
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
            ->where('country', $data['country'])
            ->where('city', $data['city'])
            ->where('state', $data['state'])
            ->limit(1)
            ->exec()
            ->getRowArray();

        return ($row['ix'] ?? false);
    }

    public function cronCremaMemberInsert($user_codes = [])
    {
        $result = [];

        if ($user_codes && is_array($user_codes)) {
            $rows = $this->qb
                ->select('u.id')
                ->decryptSelect('m.name')
                ->decryptSelect('m.pcs')
                ->select('m.sms')
                ->decryptSelect('m.mail')
                ->select('m.info')
                ->select('m.gp_ix')
                ->select('u.last')
                ->select('m.birthday')
                ->select('m.date')
                ->from(TBL_COMMON_USER.' as u')
                ->join(TBL_COMMON_MEMBER_DETAIL.' as m', 'u.code = m.code')
                ->whereIN('u.id', $user_codes)
                ->exec()
                ->getResultArray();


            //crema api
            $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);

            $member = [];

            foreach ($rows as $key => $val) {

				if ($val['gp_ix'] == "14") {
					$user_grade_id = '9';
				} else {
					$user_grade_id = NULL;
				}


                $param = ['user_id' => $val['id']
                    , 'user_name' => $val['name']
                    , 'created_at' => date('Y-m-d\TH:i:sO', strtotime($val['date']))
                    , 'user_phone' => $val['pcs']
                    , 'allow_sms' => $val['sms'] ?: '0' //sms수신허용
                    , 'user_email' => $val['mail'] //필수는 아님
                    , 'allow_email' => $val['info'] ?: '0' //email 수신허용
                    , 'user_grade_id' => $user_grade_id
                    , 'last_logged_in_at' => date('Y-m-d\TH:i:sO', strtotime($val['date'])) //마지막로그인기록 하지만 회원 생성 기준으로는 없을수 있음
                    , 'active' => 1 //활성회원여부
                ];

                if(isset($val['birthday']) && $val['birthday'] != '--') {
                    $param['birth_date'] = $val['birthday'];
                }

                $data = $this->cremaModel->putUserLog($param);

                if (isset($data['error_code']) && $data['error_code'] == '00') {
                    //에러 아닌것
                    $this->insertCremaLog('member', $this->cremaModel->issetJson($param), $this->cremaModel->issetJson($data['response'] ?? null),
                        $this->cremaModel->issetJson($data['response_heder'] ?? null),
                        $this->cremaModel->issetErrorJson(null, $data['curl_error'] ?? null));
                } else {
                    //에러인것
                    $this->insertCremaLog('member', $this->cremaModel->issetJson($param), null,
                        $this->cremaModel->issetJson($data['response_heder'] ?? null),
                        $this->cremaModel->issetErrorJson($data['response'] ?? null, $data['curl_error'] ?? null));
                    $member[] = $val['id'];
                }
            }
        }

        if (!empty($member)) {
            $result['failed_user_codes'] = $member;
        }



        return $result;
    }

    /**
     * 크리마 관련 로그
     * @param type $type
     * @param type $params
     * @param type $response
     */
    public function insertCremaLog($type, $params, $response, $response_heder, $response_error)
    {
        $this->qb
            ->set('type', $type)
            ->set('params', $params)
            ->set('response', $response)
            ->set('response_heder', $response_heder)
            ->set('response_error', $response_error)
            ->set('regdate', date("Y-m-d H:i:s"))
            ->insert('crema_logs')
            ->exec();
    }

    /**
     * User code를 이용하여 프로필을 가져온다.
     * @param string $userCode
     * @return array
	 * mem_type -> M:일반회원 C: 사업자 A: 직원 F:글로벌
	 * birthday_div -> 양력/음력구분값
	 * sex_div -> 성별
     */
    public function getApiMemberProfile($Code, $CUS_NO_INNER = null, $CUS_CARD_CD = null, $name = null, $pcs = null, $startDate = null, $endDate = null)
    {

		if(strlen($Code) <= 15) {
			$userCode = "";
			$pcs = $Code;
		}else{
			$userCode = $Code;
			$pcs = "";
		}

        $couponModel = $this->import('model.mall.coupon');

        $this->qb
            ->select('cu.id as web_id')
            ->select('cu.code')
            ->select('cmd.add_etc5 as CUS_NO_INNER')
            ->select('cmd.add_etc6 as CUS_CARD_CD')
            ->decryptSelect('cmd.name')
            ->decryptSelect('cmd.pcs')
            ->select('mg.gp_ix as cus_gradeIdx')
            ->select('mg.gp_name as cus_gradeName')
            ->select('CONVERT(cu.mileage, SIGNED) as mileage')
            ->from(TBL_COMMON_USER.' as cu')
            ->join(TBL_COMMON_MEMBER_DETAIL.' as cmd', 'cu.code=cmd.code')
            ->join(TBL_SHOP_GROUPINFO.' as mg', 'cmd.gp_ix = mg.gp_ix');

        if ($userCode != '') {
            $this->qb->where('cu.code', $userCode);
        }
        if ($CUS_NO_INNER != '') {
            $this->qb->where('cmd.add_etc5', $CUS_NO_INNER);
        }
        if ($CUS_CARD_CD != '') {
            $this->qb->where('cmd.add_etc6', $CUS_CARD_CD);
        }
        if ($name != '') {
            $this->qb->where('cu.code', $name);
        }
        if ($pcs != '') {
			$this->qb->like("REPLACE(AES_DECRYPT(UNHEX(cmd.pcs),'2ad265d024a06e3039c3649213a834390412aa7097ea05eea4e0b44c88ecf7972ad265d024a06e3039c3649213a834390412aa7097ea05eea4e0b44c88ecf797'),'-','')", $pcs);
			$this->qb->orLike("AES_DECRYPT(UNHEX(cmd.pcs),'2ad265d024a06e3039c3649213a834390412aa7097ea05eea4e0b44c88ecf7972ad265d024a06e3039c3649213a834390412aa7097ea05eea4e0b44c88ecf797')", $pcs);
        }
        if ($startDate != '' && $endDate != '') {
            $this->qb->where('cu.date >=', $startDate." 00:00:00");
            $this->qb->where('cu.date <=', $endDate." 23:59:59");
        }

		$data = $this->qb->exec() ->getResultArray();
        if (isset($data['web_id'])) {
            $data['pcs']  = $data['pcs'];
            $data['mail'] = $data['mail'];
        }

		if(count($data) == 0) {
			$retData	= array('RESULT' => 'FAIL', "ERRMSG" => "검색된 회원이 없습니다.");
		} else {
			$retData	= array('RESULT' => 'SUCCESS', "ERRMSG" => "", "LISTCOUNT" => count($data));
			array_push($retData['MEMBERLIST'], "");
		}

		foreach ($data as $key => $val) {
			if($val["pcs"]) {
				$pcs         = explode('-', $val['pcs']);
				$data[$key]['pcs'] = $pcs[0].'-****-'.$pcs[2] ?? '';
			}
			array_push($val['coupon'], "");

			//쿠폰 리스트
			$coupons		= $couponModel->getApiUserCouponList($val['code']);
			$data[$key]['coupon'] = array_change_key_case($coupons, CASE_UPPER);
		}

		//회원리스트 배력에 추가
		$retData['MEMBERLIST'] = array_change_key_case($data, CASE_UPPER);

        return $retData;
    }

    /**
     * User code를 이용하여 프로필을 가져온다.
     * @param string $userCode : 회원 코드
     * @param string $proc_gb : 처리 구분
     * @return array
	 * proc_gb -> C : 신규가입,  U : 변경, D : 탈퇴
   */
    public function getApiMemberErpReg($userCode, $proc_gb)
    {
		$view			= getForbizView();
		$jwtModel		= $view->import('model.mall.jwt');

		//$sendUrl		= "https://erp.getbarrel.com/barrelAPI/memberRegister";
		$sendUrl		= "http://barreldev-p.sgerp.com/barrelAPI/memberRegister";

        $this->qb
            ->select('cu.id as web_id')
            ->select('cu.code as on_cust_cd')
            ->decryptSelect('cmd.name','cus_nm')
            ->select('1 as cus_grade')
            ->select('cmd.add_etc4 as join_cd')
            ->select('"" as proc_gb')
            ->select('cu.date as proc_dt')
            ->from(TBL_COMMON_USER.' as cu')
            ->join(TBL_COMMON_MEMBER_DETAIL.' as cmd', 'cu.code=cmd.code')
            ->join(TBL_SHOP_GROUPINFO.' as mg', 'cmd.gp_ix = mg.gp_ix')
			->where('cu.code', $userCode);

		$data = $this->qb->exec() ->getRowArray();

		// API 호출
		//==========================

		$data['proc_gb'] = $proc_gb;
		$data['proc_dt'] = date("Ymd", strtotime($data['proc_dt']));

		$tokenVal			= $jwtModel->hashing($data);

		$url = $sendUrl."?tokenVal=".$tokenVal;
		$postData = ['tokenVal' => $tokenVal];
		$postDataString = http_build_query($postData);

		// 헤더 설정 (필요한 경우)
		$headers = [
			'Content-Type:application/json',
			'Content-Length: ' . strlen($postDataString)
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);				// 요청할 URL
		curl_setopt($ch, CURLOPT_POST, true);				// POST 요청으로 설정
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		// 응답을 문자열로 반환
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);				// 요청 타임아웃 설정
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataString); // POST 데이터 설정
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // 헤더 추가

		$response = curl_exec($ch);
		// API 호출
        return $response;

    }

	public function commApiMemGroup(){
        $data = $this->qb
            ->select('gp_ix')
            ->select('gp_name')
            ->select('gp_ename')
            ->select('sale_rate')
            ->select('sale_rate')
            ->select('gp_level')
            ->select('order_price')
            ->select('FORMAT(ed_order_price ,0) AS ed_order_price')
            ->select('gp_type')
            ->select('selling_type')
            ->select('use_discount_type')
            ->select('retail_dc')
            ->select('round_depth')
            ->select('round_type')
            ->select('dc_standard_price')
            ->select('use_coupon_yn')
            ->select('use_reserve_yn')
            ->select('use_discount_category_yn')
            ->select('use_discount_category_mileage_yn')
            ->select('date_format(regdate, "%Y%m%d") as regdate')
            ->from(TBL_SHOP_GROUPINFO)
            ->orderBy('gp_level', 'asc')
            ->exec()
            ->getResultArray();

		if(count($data) == 0) {
			$retData	= array('RESULT' => 'FAIL', "ERRMSG" => "검색된 회원등급이 없습니다.");
		} else {
			$retData	= array('RESULT' => 'SUCCESS', "ERRMSG" => "", "LISTCOUNT" => count($data));
			array_push($retData['GROUPLIST'], "");
			$retData['GROUPLIST'] = arrayKeysToUpper($data);
		}

        return $retData;
	}
}