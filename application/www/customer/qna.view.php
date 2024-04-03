<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$view = getForbizView();
$params = $view->getParams();
$method = 'write';
if(!empty($params[0])) {
    $bbsIx = $params[0];
}

//1:1문의
if(BASIC_LANGUAGE == 'korean'){
    $boardName = 'qna';
}else{
    $boardName = 'qna_global';
}


/* @var $customerModel CustomMallCustomerModel */
$customerModel = $view->import('model.mall.customer');
$customerModel->setBoardConfig($boardName);
$bbsConfig = $customerModel->getBoardConfig();

if ($method == "write") {

    if (is_login() === false) {
        redirect("/member/login?url=" . $view->input->server('REQUEST_URI'));
    }

    if(!empty($bbsIx)) {
        $result = $customerModel->getQnaDetail($bbsIx, 'bbs_qna');

        $productName = "";
        $productImage = "";

        if(isset($result['qInfo']['oInfo'])){

            $productCnt = count($result['qInfo']['oInfo']);

            if($productCnt > 1){
                $productName = $result['qInfo']['oInfo']['0']['pname']." 외 ".($productCnt -1)."개 상품";
            }else{
                $productName = $result['qInfo']['oInfo']['0']['pname'];
            }
            $productImage = $result['qInfo']['oInfo']['0']['pimg'];
        }


        if(isset($result['qInfo']['cInfo'])){
            $view->assign('cInfo', $result['qInfo']['cInfo']);
        }
        $view->assign($result['qInfo']);
        $view->assign('productName', $productName);
        $view->assign('productImage', $productImage);
        $view->assign('bbsIx', $bbsIx);
		$view->assign('btnName', '수정');
    }else{
		$view->assign('btnName', '둥록');
	}

    $view->assign($bbsConfig);

    $view->setContentScope('bbs_templet/' . $bbsConfig['bbs_templet_dir'] . '/bbs_write.htm');

    $defaultEmail = explode('@', sess_val('user', 'mail'));
    $defaultPhone = explode('-', sess_val('user', 'pcs'));
    $view->assign('emailId', $defaultEmail['0'] ?? '');
    $view->assign('emailHost', $defaultEmail['1'] ?? '');
    $view->assign('phone1', $defaultPhone['0'] ?? '');
    $view->assign('phone2', $defaultPhone['1'] ?? '');
    $view->assign('phone3', $defaultPhone['2'] ?? '');
    $view->assign('oid', $view->input->get('oid'));
}

if (is_mobile() || $view->userInfo->appType) {
    $view->assign([
        'appType' => $view->userInfo->appType
    ]);
}

echo $view->loadLayout();