<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// 네이버페이 전용 헬퍼 로드
require_once (__DIR__.'/npay.helper.php');

// 프레임워크 로드
$view = getForbizView(false);

$query = $view->input->server('QUERY_STRING');
if ($query != '') {
    $vars = array();
    foreach (explode('&', $query) as $pair) {
        list($key, $value) = explode('=', $pair);
        $key          = urldecode($key);
        $value        = urldecode($value);
        $vars[$key][] = $value;
    }

    if (count($vars['ITEM_ID']) > 0) {
        /* @var $productModel CustomMallProductModel */
        $productModel = $view->import('model.mall.product');

        foreach ($vars['ITEM_ID'] as $pid) {
            $row = $productModel->get($pid);
            if (!empty($row)) {
                $row['cates']   = $productModel->getProductCategoryCnames($row['cid']);
                $options        = $productModel->getOption($pid);
                $row['options'] = $options['viewOptions'] ?? [];

                echo npay_pinfo_xml($row);
            }
        }
        exit;
    }
}

echo 'ITEM_ID 는 필수입니다.';
