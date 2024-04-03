<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (is_login()) {
    // Load Forbiz View
    $view = getForbizView();

    $params = $view->getParams();

    /* @var $memberModel CustomMallMemberModel */
    $memberModel = $view->import('model.mall.member');

    if(isset($params[0])) {

        $data = $memberModel->getAddressBookItem($view->userInfo->code, $params[0]);

        $view->assign($data);
        $view->assign('force_default_yn', 'N');
        $view->assign('mode', 'modify');
    } else {
        $addressBookCnt = $memberModel->getAddressBookCnt($view->userInfo->code);
        $addressBookDefaultCnt = $memberModel->getAddressBookDefaultCnt($view->userInfo->code);
        if($addressBookCnt == 0 || $addressBookDefaultCnt == 0){
            $view->assign('default_yn', 'Y');
            $view->assign('force_default_yn', 'Y');
        }else{
            $view->assign('default_yn', 'N');
            $view->assign('force_default_yn', 'N');
        }

        $view->assign('mode', 'insert');
    }

    if(BASIC_LANGUAGE == 'english'){
        /* @var $globalModel CustomMallGlobalModel */
        $globalModel = $view->import('model.mall.global');
        $nation = $globalModel->getNationInfo();

        $regional_information = $globalModel->getRegionalInformation();

        $view->assign('nation', $nation);
        $view->assign('regional_information', $regional_information);
    }

    echo $view->loadLayOut();
} else {
    echo sprintf("<script>alert('%s'); windows.colse();</script>", trans('로그인을 해주세요'));
}