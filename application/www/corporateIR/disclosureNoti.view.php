<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();

$params = $view->getParams();
//$boardName = $params[0] ?? 'disclosure';
$boardName = $params[0] ?? 'announce';
$method = $params[1] ?? 'list';

/* @var $customerModel CustomMallCustomerModel */
$customerModel = $view->import('model.mall.customer');
$customerModel->setBoardConfig($boardName);
$bbsConfig = $customerModel->getBoardConfig();

$view->assign('bType', $boardName);
$view->assign($bbsConfig);
if ($method == 'list') {

    $view->setContentScope('bbs_templet/' . $bbsConfig['bbs_templet_dir'] . '/bbs_list.htm');

} else if ($method == 'read') {
    $bbsIx = $params[2] ?? null;

    if (is_null($bbsIx)) {
        redirect("/corporateIR/IRResources");
    }

    $view->setContentScope('bbs_templet/' . $bbsConfig['bbs_templet_dir'] . '/bbs_read.htm');

    $result = $customerModel->getArticle($bbsIx);

    if(strpos($result['bbs_subject'],'||') !== false){
        $temp = explode("||", $result['bbs_subject']);
        $result['bbs_subject'] = $temp['0'];
        if($temp['1'] != '배럴' && $temp['1'] != 'BARREL' && $temp['1'] != 'barrel'){
            $result['bbs_name'] = $temp['1'];
        }
    }


    if(isset($result['before_record']) && is_array($result['before_record'])){
        foreach($result['before_record'] as $key=>$val){
            if(strpos($val['bbs_subject'],'||') !== false){
                $temp = explode("||", $val['bbs_subject']);
                $result['before_record'][$key]['bbs_subject'] = $temp['0'];
                if($temp['1'] != '배럴' && $temp['1'] != 'BARREL' && $temp['1'] != 'barrel'){
                    $result['before_record'][$key]['bbs_name'] = $temp['1'];
                }
            }

            $result['before_record'][$key]['link'] = str_replace('/customer','/corporateIR/disclosureNoti',$val['link']);
        }
    }

    if(isset($result['next_record']) && is_array($result['next_record'])){

        foreach($result['next_record'] as $key=>$val){
            if(strpos($val['bbs_subject'],'||') !== false){
                $temp = explode("||", $val['bbs_subject']);
                $result['next_record'][$key]['bbs_subject'] = $temp['0'];
                if($temp['1'] != '배럴' && $temp['1'] != 'BARREL' && $temp['1'] != 'barrel'){
                    $result['next_record'][$key]['bbs_name'] = $temp['1'];
                }
            }
            $result['next_record'][$key]['link'] = str_replace('/customer','/corporateIR/disclosureNoti',$val['link']);
        }
    }

    if(isset($result['before_record']['0'])){
        $view->assign('beforeRecord', $result['before_record']['0']);
    }
    if(isset($result['next_record']['0'])){
        $view->assign('nextRecord', $result['next_record']['0']);
    }

    $view->assign($result);

    $download_path = DATA_ROOT . "/bbs_data/bbs_" . $boardName . "/" . $bbsIx;
    $view->assign('download_path', $download_path);
}

echo $view->loadLayout();