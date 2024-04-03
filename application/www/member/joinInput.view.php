<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// 로그인 되어 있으면 / 로 이동
if (is_login()) {
    redirect('/');
} else {
    // Load Forbiz View
    $view        = getForbizView();
    // Load Model
    /* @var $memberModel CustomMallMemberModel */
    $memberModel = $view->import('model.mall.member');

    /* @var $snsModel CustomMallSnsLoginModel */
    $snsModel = $view->import('model.mall.snsLogin');

    if(BASIC_LANGUAGE == 'english'){
        $_SESSION['join']['type'] = "F1";
        $view->assign('joinType' , 'F1');
    }else{
        $_SESSION['join']['type'] = "B";
        $view->assign('joinType' , 'B');
    }

//print_r($_SESSION['sns_login']);
    $data = $memberModel->doJoinInput(sess_val('join', 'type'));
    if ($data !== false) {
        $view->assign($data);
        $view->define([
            'joinBasic' => "member/join_input/join_input_basic.htm",
            'joinGlobal' => "member/join_input/join_input_global.htm",
            'joinCompany' => "member/join_input/join_input_company.htm"
        ]);

        $sns_login = sess_val('sns_login');
        $isSnsJoin = false;
        $snsType = '';
        if(!empty($sns_login)){
            $snsType = key($sns_login);
			$memberModel->setJoinSessionType('B');
			$res = $snsModel->getAlangeMemberInfo($snsType,$sns_login[$snsType]);

			$kakaoOk = $_REQUEST['kakaoOk'];
			$utm_source = $_REQUEST['utm_source'];
			$utm_medium = $_REQUEST['utm_medium'];

			if($snsType == 'kakao'){
				if($kakaoOk == "ok"){
					$parm = '?distinctId='.$res['distinctId'].'&userName='.$res['userName'].'&pcs1='.$res['pcs1'].'&pcs2='.$res['pcs2'].'&pcs3='.$res['pcs3'].'&gender='.$res['gender'].'&birthdayDiv='.$res['birthdayDiv'].'&birthYear='.$res['birthYearText'].'&birthMonth='.$res['birthMonthText'].'&birthDay='.$res['birthDayText'].'&zip='.$res['zip'].'&addr1='.$res['addr1'].'&addr2='.$res['addr2'].'&emailId='.$res['emailId'].'&emailHost='.$res['emailHost'].'&utm_source='.$utm_source.'&utm_medium='.$utm_medium.'&kakaoOk=ok';
				}else{
					$parm = '?distinctId='.$res['distinctId'].'&userName='.$res['userName'].'&pcs1='.$res['pcs1'].'&pcs2='.$res['pcs2'].'&pcs3='.$res['pcs3'].'&gender='.$res['gender'].'&birthdayDiv='.$res['birthdayDiv'].'&birthYear='.$res['birthYearText'].'&birthMonth='.$res['birthMonthText'].'&birthDay='.$res['birthDayText'].'&zip='.$res['zip'].'&addr1='.$res['addr1'].'&addr2='.$res['addr2'].'&emailId='.$res['emailId'].'&emailHost='.$res['emailHost'];
				}
				redirect('/controller/member/joinInputBasic2'.$parm);
			}else{
				$view->assign($res);
				$isSnsJoin = true;
			}
        }

        $view->assign('isSnsJoin' , $isSnsJoin);
        $view->assign('snsType' , $snsType);

		
        #생년월일 basic 데이터 추출
        $birthYear = array();
        $nowYear = date('Y');
        $firstYear = 1940;
        for($i=$nowYear; $i >=$firstYear; $i-- ){
            $birthYear[] = $i;
        }
        $view->assign('birthYear',$birthYear);

        $birthMonth = array();
        for($i=01; $i <= 12; $i++ ){
            $birthMonth[] = str_pad($i, 2, 0, STR_PAD_LEFT);
        }
        $view->assign('birthMonth',$birthMonth);

        $birthDay = array();
        for($i=01; $i <= 31; $i++ ){
            $birthDay[] = str_pad($i, 2, 0, STR_PAD_LEFT);
        }
        $view->assign('birthDay',$birthDay);
        

        if(BASIC_LANGUAGE == 'english'){
            //약관동의
            $view->assign($memberModel->doJoinAgreementGlobal(sess_val('join', 'type')));
            /* @var $globalModel CustomMallGlobalModel */
            $globalModel = $view->import('model.mall.global');
            $nation = $globalModel->getNationInfo();

            $regional_information = $globalModel->getRegionalInformation();

            $view->assign('nation', $nation);
            $view->assign('regional_information', $regional_information);
        }else{
            //약관동의
            $view->assign($memberModel->doJoinAgreement(sess_val('join', 'type')));
        }

		//디비 확인 후 최종 수정
        $view->assign('gender','W');
        $view->assign('birthdayDiv','1');

        echo $view->loadLayout();

        $view->event->emmit('MemberRegLogic',['code' => sess_val('user', 'code'), 'step' => 3]);
    } else {
        redirect('/member/login');
    }
}