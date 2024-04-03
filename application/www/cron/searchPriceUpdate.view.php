<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView(true);

/* @var $productModel CustomMallProductModel */
$productModel = $view->import('model.mall.product');

$responseData = $productModel->getList([], 1, 1);

//echo '<xmp>'; print_r($responseData); echo '</xmp>';

$total = $responseData['total'];
$max = 100;
$page = 1;
$lastPage = ceil($total / $max);

for ($count = 0; $page <= $lastPage; $page++) {
    $data = $productModel->getList([], $page, $max);
    if (count($data['list']) > 0) {
        foreach ($data['list'] as $p) {
            $sql = "SELECT count(*) as cnt FROM shop_product_search_price WHERE pid = '".$p['id']."' AND mall_ix ='".MALL_IX."'";

            $rows = $view->qb->exec($sql)->getResultArray();

            if($rows[0]['cnt'] > 0){
                $sql = "UPDATE shop_product_search_price SET price '".$p['dcprice']."' WHERE mall_ix = '".MALL_IX."' AND pid = '".$p['id']."' ";
                $view->qb->exec($sql);
            }else {
                $sql = "INSERT INTO shop_product_search_price (mall_ix, pid, price) VALUES ('".MALL_IX."', '".$p['id']."', '".$p['dcprice']."')";
                $view->qb->exec($sql);
            }
            /*$view->qb
                ->where('mall_ix', MALL_IX)
                ->where('pid', $p['id'])
                ->from(TBL_SHOP_PRODUCT_SEARCH_PRICE)->exec();
            if ($view->qb->total > 0) {
                $view->qb
                    ->set('price', $p['dcprice'])
                    ->update(TBL_SHOP_PRODUCT_SEARCH_PRICE)
                    ->where('mall_ix', MALL_IX)
                    ->where('pid', $p['id'])
                    ->exec();
            } else {
                $view->qb
                    ->set('mall_ix', MALL_IX)
                    ->set('pid', $p['id'])
                    ->set('price', $p['dcprice'])
                    ->insert(TBL_SHOP_PRODUCT_SEARCH_PRICE)
                    ->exec();
            }*/
        }
    } else {
        break;
    }
}