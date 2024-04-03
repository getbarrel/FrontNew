<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
if (is_login()) {
    $view = getForbizView();

// 마이페이지 공통
    $view->mypageCommon();

    echo $view->loadLayout();
}else{
    redirect('/member/login?url=/mypage/stockAlarm');
}