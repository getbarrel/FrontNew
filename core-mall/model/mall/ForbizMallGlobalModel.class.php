<?php

/**
 * Description of ForbizMallGlobalModel
 *
 * @author hoksi
 */
class ForbizMallGlobalModel extends ForbizModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * js에 사용하는 언어 수집
     * storage[common.validation.required.text][key]=bdaeb176b9b69ac1c24395d13d47aba0
     * storage[common.validation.required.text][text]=[title]을/를 입력해 주세요.
     * @param $storage
     */
    public function jsLanguageCollection($storage)
    {
        static $callKeyList = [];

        if (defined('DB_CONNECTION_DIV') && DB_CONNECTION_DIV == 'development') {
            //개발일때 언어관련 모델 로드

            if (is_array($storage)) {
                /* @var $langModel CustomMallLanguagetModel */
                $langModel = $this->import('model.mall.language');
                
                foreach ($storage as $language) {
                    if (in_array($language['key'], $callKeyList) === false) {
                        $callKeyList[] = $language['key'];

                        // 언어 수집
                        $langModel->addTranLang($language['key'], $language['text']);
                    }
                }
            }
        }

        return $callKeyList;
    }
}