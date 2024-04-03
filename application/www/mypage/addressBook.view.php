<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 배송지 관리
 */
if (is_login()) {
    // Load Forbiz View
    /*
     * @var CustomMallDefaultViewController $view
     */
    $view = getForbizView();

    // 마이페이지 공통
    $view->mypageCommon();

    // Layout 출력
    echo $view->loadLayOut();
} else {
    redirect('/member/login');
}
