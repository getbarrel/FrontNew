<?php

/**
 * Description of ForbizMallGlobalController
 *
 * @author hoksi
 *
 */
class ForbizMallGlobalController extends ForbizMallController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * js 사용 언어 수집
     */
    public function jsLanguageCollection()
    {
        /* @var $globalModel CustomMallGlobalModel */
        $globalModel = $this->import('model.mall.global');

        $this->setResponseData($globalModel->jsLanguageCollection(json_decode($this->input->post('storage'), true)));
    }
}