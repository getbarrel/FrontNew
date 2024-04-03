<?php
// 도메인 변경이 필요할 때 설정함
// define('FORBIZ_BASEURL', 'localhost');

/*
 * Fobiz Framework Load
 */
require_once(__DIR__ . '/../../core/framework/ForbizCli.php');

/**
 * @property CustomMallCartModel $cartModel
 */
(new class extends ForbizCli {
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo 'Welcome to CLI';
    }

    public function test()
    {
        var_dump($this->qb->from(TBL_COMMON_USER_SLEEP)->limit(10)->exec()->getResultArray());
    }
})->run();