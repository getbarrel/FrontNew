<?php

/**
 * Description of CustomMallFatModel
 *
 * @author hong
 */
class CustomMallFatModel extends ForbizMallFatModel
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function initCfg()
    {
        // DB 설정
        if (defined('DB_CONNECTION_DIV') && 'production' == DB_CONNECTION_DIV) {
            $statDb    = 'barrel_statistics.';
            $productDb = 'barrel_mall.';
        } elseif(defined('DB_CONNECTION_DIV') && 'testing' == DB_CONNECTION_DIV) {
            // DB 설정
            $statDb    = 'dev_barrel.';
            $productDb = 'dev_barrel.';
        } else {
            $statDb    = 'dev_statistics.';
            $productDb = 'barrel_mall_dev.';
        }

        // 테이블 설정
        define('STAT_TBL_LOG', $statDb.'system_prdt_vwlog');
        define('STAT_TBL_ORDER', $productDb.'shop_order');
        define('STAT_TBL_ORDER_DETAIL', $productDb.'shop_order_detail');
        define('STAT_TBL_PAYMENT', $productDb.'shop_order_payment');
        define('STAT_TBL_PRODUCT', $productDb.'shop_product');
        define('STAT_TBL_CATEGORY', $productDb.'shop_product_relation');

        // 기본날짜 구간 설정
        $this->sDate = date('Y-m-d');
        $this->eDate = date('Y-m-d');
    }
}