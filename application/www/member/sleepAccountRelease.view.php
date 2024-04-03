<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


    $view = getForbizView();

    /* @var $memberModel CustomMallMemberModel */
    $memberModel = $view->import('model.mall.member');

    $view->assign('mallName', ForbizConfig::getCompanyInfo('shop_name')); //몰 이름
    $view->assign('mallEmail', ForbizConfig::getCompanyInfo('com_email')); //몰 이메일 주소
    $view->assign('csPhone', ForbizConfig::getCompanyInfo('cs_phone')); //고객센터 번호
    $view->assign('sleepYear', ForbizConfig::getPrivacyConfig('sleep_date')); //휴면회원 조건 기간(년)
    $view->assign('userName', sess_val('user', 'name')); //회원이름

	$view->assign('userId', $memberModel->userInfo->id); //회원이름
	$view->assign('userRegDate', $memberModel->userInfo->mem_reg_date); //회원이름
    // 휴면회원 해제 단계
    $sleepStep = $view->getFlashData('sleepStep');

    switch ($sleepStep) {
        case 'complete':
            $memberModel->doLogout();
            $view->define('complete', 'member/sleep_account_release/sleep_account_release_complete.htm');
        case 'policy':
            $view->assign($memberModel->doSleepMemberPolicy($sleepStep));
            $view->define('policy', 'member/sleep_account_release/sleep_account_release_policy.htm');
            break;
        case 'auth':
            $data = $memberModel->doSleepMemberAuth($sleepStep);

            $view->assign($data);
            if ($data['memType'] == 'C') {
                $view->define('authCompany', 'member/sleep_account_release/sleep_account_release_auth_company.htm');
            } else {
                $view->define('authBasic', 'member/sleep_account_release/sleep_account_release_auth_basic.htm');
            }
            break;
        default:
//            $view->define('guide', 'member/sleep_account_release/sleep_account_release_guide.htm');
            $view->assign($memberModel->doSleepMemberPolicy('policy'));
            $view->define('policy', 'member/sleep_account_release/sleep_account_release_policy.htm');
            break;
    }

    echo $view->loadLayout();
