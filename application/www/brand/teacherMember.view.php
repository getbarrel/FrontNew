<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load Forbiz View
$view = getForbizView();

$params = $view->getParams();
$method = $params[0] ?? 'list';
if(!empty($params[1])) {
    $bbsIx = $params[1];
}
//공지사항
$boardName = 'teacher';

/* @var $customerModel CustomMallCustomerModel */
$customerModel = $view->import('model.mall.customer');
$customerModel->setBoardConfig($boardName);
$bbsConfig = $customerModel->getBoardConfig();
$view->assign('bType', $boardName);
if ($method == 'list') {


    $view->setContentScope('bbs_templet/' . $bbsConfig['bbs_templet_dir'] . '/bbs_list.htm');

} else if ($method == 'read') {

    $view->setContentScope('bbs_templet/' . $bbsConfig['bbs_templet_dir'] . '/bbs_read.htm');

    if(!(int)$bbsIx){
        echo "<script>alert('정상적이지 않은 접근입니다.'); history.back();</script>";
        exit;
    }

    $result = $customerModel->getArticle($bbsIx);

    if(!isset($result)){
        echo "<script>alert('존재하지 않는 게시물 입니다.'); history.back();</script>";
        exit;
    }
    if($result['bbs_hidden'] == 1){
        if($result['mem_ix'] != $view->userInfo->code){
            echo "<script>alert('비밀글은 작성자만 조회할 수 있습니다.'); history.back();</script>";
            exit;
        }
    }


    if($result['writer']){
        $result['short_bbs_name'] = mb_substr($result['writer'],0,1, 'UTF-8')."**";
    }

    $view->assign('is_notice', $result['is_notice']);

    if(isset($result['before_record']['0'])){
        $view->assign('beforeRecord', $result['before_record']['0']);
    }
    if(isset($result['next_record']['0'])){
        $view->assign('nextRecord', $result['next_record']['0']);
    }

    $view->assign($result);

    $download_path = DATA_ROOT . "/bbs_data/bbs_" . $boardName . "/" . $bbsIx;
    $view->assign('download_path', $download_path);
} else if($method == 'write'){

    $view->assign($bbsConfig);

    if(!empty($bbsIx)) {
        $result = $customerModel->getArticle($bbsIx);
        //if($result['bbs_hidden'] == 1){
            if($result['mem_ix'] != $view->userInfo->code){
                echo "<script>alert('작성자만 수정할 수 있습니다.'); history.back();</script>";
                exit;
            }
        //}

        $view->assign($result);

    }else {

        $bbs_contents = "1. 이름 :
    
2. 개인 연락처 :

3. 티칭 종목 :

4. 티칭 지역 :

5. 자격증 이름 :
    ";

        $view->assign('bbs_contents', $bbs_contents);
    }

    $view->setContentScope('bbs_templet/' . $bbsConfig['bbs_templet_dir'] . '/bbs_write.htm');

}


echo $view->loadLayout();