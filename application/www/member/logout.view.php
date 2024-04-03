<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView('noLayout');
/* @var $memberModel CustomMallMemberModel */
$memberModel = $view->import('model.mall.member');

$memberModel->doLogout();

$sns_login = sess_val('sns_login');

if (is_array($sns_login)) {
   foreach($sns_login as $key=>$val){
       /* @var $snsModel CustomMallSnsLoginModel */
       $snsModel = $this->import('model.mall.snsLogin');
       if($key == 'kakao'){
           $snsModel->kakaoLogOut();
       }
   }
}

//redirect('/');
?>
<script>
    if(navigator.userAgent.match(/BarrelAOSApp/i)) {
        window.JavascriptInterface.logOut();
    }else if(navigator.userAgent.match(/BarrelIOSApp/i)) {
        window.webkit.messageHandlers.logOut.postMessage("");
    }
    location.replace('/');
</script>
