<?php

/**
 * Description of CustomMallBbsController
 *
 * @author smlee
 */
class CustomMallBbsController extends ForbizMallBbsController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getBbsInfoText(){
        $chkField = ['bbsDiv'];

        if (form_validation($chkField)) {
            $bbsDiv   = $this->input->post('bbsDiv');

            /* @var $mypageModel CustomMallMypageModel */
            $mypageModel = $this->import('model.mall.mypage');


            $result = $mypageModel->getBbsInfoText($bbsDiv);

            if($result){
                $this->setResponseResult('success');
                $this->setResponseData($result);
            } else {
                $this->setResponseResult('fail');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }
}
