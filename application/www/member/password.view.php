<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// View get
$view        = getForbizView();
/* @var $memberModel CustomMallMemberModel */
$memberModel = $view->import('model.mall.member');

//regular 정기적 변경, searchPassword 비밀번호 찾기, sleep 휴먼회원 비밀번호 변경
$changeType = $memberModel->getChangePasswordAccessSessionType();

//sns 회원이 접근 못하도록
/* @var $loginModel CustomMallMemberLoginModel */
$loginModel = $view->import('model.mall.memberLogin');
$sns_user = $loginModel->isSnsMember(sess_val('user', 'code'));

//정의되지 않는 비밀번호 변경 접근은 X
if (empty($changeType) || $sns_user === true) {
    redirect('/');
} else {
    $view->assign('changeType', $changeType);

    if ($changeType == 'regular') {
        $view->assign('changePasswordDay', ForbizConfig::getPrivacyConfig('change_pw_day'));
        $view->assign('changePasswordContinueDay', ForbizConfig::getPrivacyConfig('change_pw_continue_day'));
    }

    // Layout 출력
    echo $view->loadLayout();
}