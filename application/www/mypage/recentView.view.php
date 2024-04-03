<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

//if (is_login()) {
    // View get
    $view = getForbizView();

    // 마이페이지 공통
    //$view->mypageCommon();
    // Layout 출력
    echo $view->loadLayout();
/*} else {
    redirect('/member/login?url=/mypage/recentView');
}*/