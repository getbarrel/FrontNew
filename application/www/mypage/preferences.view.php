<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

    // View get
    $view = getForbizView();

    if (is_mobile() || $view->userInfo->appType) {
        $mCfg = ForbizConfig::getSharedMemory('mobile_config');
        if ($view->userInfo->appType == 'iOS') {
            $newVersion = $mCfg['ios_app_version'];
        } elseif($view->userInfo->appType == 'Android') {
            $newVersion = $mCfg['android_app_version'];
        } else {
            $newVersion = '알수없음';
        }
        $view->assign([
            'appType' => $view->userInfo->appType
            , 'newVersion' => $newVersion
        ]);
        
        // Layout 출력
        echo $view->loadLayout();
    } else {
        show_404();
    }
