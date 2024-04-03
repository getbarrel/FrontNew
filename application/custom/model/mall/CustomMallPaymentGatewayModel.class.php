<?php

/**
 * Description of CustomMallPaymentGatewayModel
 *
 * @author hong
 */
class CustomMallPaymentGatewayModel extends ForbizMallPaymentGatewayModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get 결제 모듈 정보
     * @param $method
     * @return string
     */
    public function getPayModuleNameByMethod($method)
    {
        if ($method == ORDER_METHOD_NPAY) {
            $moduleName = 'naverpayPg';
        } else if ($method == ORDER_METHOD_PAYCO) {
            $moduleName = 'payco';
        } else if ($method == ORDER_METHOD_EXIMBAY) {
            $moduleName = 'eximbay';
        } else if ($method == ORDER_METHOD_TOSS) {
            $moduleName = 'toss';
        } else if ($method == ORDER_METHOD_KAKAOPAY) {
            $moduleName = 'kcp';
        } else {
            $moduleName = ForbizConfig::getMallConfig('sattle_module');
        }
        return $moduleName;
    }
}