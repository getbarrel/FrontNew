<?php

/**
 * Description of CustomMallCollectModel
 * @author hoksi
 */
class CustomMallCollectModel extends ForbizMallCollectModel
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function initCfg()
    {
        // DB 설정
        if (defined('DB_CONNECTION_DIV') && 'production' == DB_CONNECTION_DIV) {
            if($_SERVER['SERVER_NAME'] == 'qa.barrelmade.co.kr'){
                $statDb    = 'barrel_mall.';
            }else{
                $statDb    = 'barrel_statistics.';
            }
            $productDb = 'barrel_mall.';
        } elseif(defined('DB_CONNECTION_DIV') && 'testing' == DB_CONNECTION_DIV) {
            // DB 설정
            $statDb    = 'dev_barrel.';
            $productDb = 'dev_barrel.';
        } else {
            $statDb    = 'barrel_mall_dev.';
            $productDb = 'barrel_mall_dev.';
        }

        // 테이블 설정
        defined('STAT_TBL_LOG') OR define('STAT_TBL_LOG', $statDb.'system_prdt_vwlog');
    }
}