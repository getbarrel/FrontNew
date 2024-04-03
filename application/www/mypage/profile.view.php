<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    // View get
    $view = getForbizView();
    $sns_login = sess_val('sns_login');

    if ($view->getFlashData('reconfirmPassMode') == 'profile' || $sns_login ) {
        // Load Model
        /* @var $mypageModel CustomMallMypageModel */
        $mypageModel = $view->import('model.mall.mypage');
        $profile = $mypageModel->doProfile();
        $mem_type    = sess_val('user', 'mem_type');

        if($profile['birthday']){
            $birthdayArr = explode('-',$profile['birthday']);
            $birthdayArr = array_filter($birthdayArr);
            if(count($birthdayArr) == 3){
                $view->assign('birthdayArr',$birthdayArr);
            }
        }




        $view->assign($profile);

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

        if ($mem_type == 'C') {
            // 사업자 회원
            $view->define('profile_form', 'mypage/profile/profile_company.htm');
        } else {
            // 일반 회원
            if(BASIC_LANGUAGE == 'english'){
                $view->define('profile_form', 'mypage/profile/profile_basic_global.htm');
            }else{
                $view->define('profile_form', 'mypage/profile/profile_basic.htm');
            }

        }

        // 마이페이지 공통
        $view->mypageCommon();

        $sns_login = sess_val('sns_login');
        $isSnsJoin = false;
        if(!empty($sns_login)){
            $isSnsJoin = true;
        }
        $view->assign('isSnsJoin' , $isSnsJoin);

        if(BASIC_LANGUAGE == 'english'){

            if(!empty($profile['pcs'])){

                $view->assign('pcs',$profile['pcs'][1]);

            }

            /* @var $globalModel CustomMallGlobalModel */
            $globalModel = $view->import('model.mall.global');
            $nation = $globalModel->getNationInfo();

            $regional_information = $globalModel->getRegionalInformation();

            $view->assign('nation', $nation);
            $view->assign('regional_information', $regional_information);
        }

        // Layout 출력
        echo $view->loadLayout();
    } else {
        // 비밀번호 재확인
        $view->setFlashData('passReconfirmType', 'profile');
        redirect('/mypage/passReconfirm');
    }
} else {
    redirect('/member/login?url=/mypage/profile');
}