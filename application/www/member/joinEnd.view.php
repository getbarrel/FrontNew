<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView();

// user code 조회
$userCode = $view->getFlashData('userCode');

// sns 필수 정보 획득 관련 성공/실패 여부
$result  = $view->getParams(0);
$view->assign('result', $result);
if($result == 'fail'){
    echo $view->loadLayout();
}else{
    if (is_login() || !$userCode) {
        redirect('/');
    } else {
        /* @var $memberModel CustomMallMemberModel */
        $memberModel = $view->import('model.mall.member'); //몰 이름
        // 가입시 정보 조회
        $userData    = $memberModel->getJoinEndData($userCode);
        // 로그인 정보
        $doLoginInfo = $view->getFlashData('doLoginInfo');

        // 로그인 진행 => #4493 이슈로 인해 주석처리
        if(!empty($doLoginInfo)) {
            //$memberModel->doLogin($doLoginInfo['userId'], $doLoginInfo['userPw']);
        }

        $view->assign('mallName', ForbizConfig::getMallConfig('mall_name')); //회원 타입 M:일반회원 C: 사업자 A: 직원
        $view->assign('memberType', $userData['mem_type']);
        $view->assign('authorized', $userData['authorized']); //회원승인여부

        if ($userData['mem_type'] == 'C') {
            $view->assign('name', $userData['com_name']); //업체명
        } else {
            $view->assign('name', $userData['name']); //회원명
        }


        //카카오 모먼트 회원가입 완료 스크립트 추가 [S]
        $kakaoMomentSubScript = "
        <script type='text/javascript'>
              kakaoPixel('".KAKAO_MOMENT_KEY."').completeRegistration();
        </script>
        ";
        $view->assign('kakaoMomentSubScript', $kakaoMomentSubScript);
        //카카오 모먼트 회원가입 완료 스크립트 추가 [E]

        echo $view->loadLayout();
    }
}

