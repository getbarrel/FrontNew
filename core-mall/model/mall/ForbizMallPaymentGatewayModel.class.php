<?php

/**
 * Description of ForbizMallPaymentGatewayModel
 *
 * @author hong
 */
class ForbizMallPaymentGatewayModel extends ForbizModel
{
    /**
     * 결제 모듈명
     * @var string
     */
    protected $moduleName;

    /**
     * 결제 모듈
     * @var class
     */
    protected $module = false;

    /**
     * 사용 환경 (W: PC, M:모바일, A:APP)
     * @var string
     */
    protected $agentType;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 세팅
     * @param type $moduleName
     * @param type $agentType
     */
    public function init($moduleName, $agentType = 'W')
    {
        $this->moduleName = $moduleName;
        $this->agentType = $agentType;

        $moduleClassName = $this->getModuleClassName();
        if ($this->module !== false) {
            unset($this->module);
        }
        $class = 'PgForbiz' . $moduleClassName;
        $this->module = new $class($this->agentType);
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
        } else {
            $moduleName = ForbizConfig::getMallConfig('sattle_module');
        }
        return $moduleName;
    }

    /**
     * form Html
     * @return string
     */
    public function requestPaymentForm(PgForbizPaymentData $paymentData)
    {
        $requestData = $this->module->getPaymentRequestData($paymentData);
        return $this->generationPaymentJavaScript() . $this->generationPaymentFormHtml($requestData);
    }

    /**
     * module 에 에 있는 method 실행
     * @param type $method
     * @return type
     */
    public function evalModuleMethod($method, ...$arg)
    {
        return call_user_func_array([$this->module, $method], $arg);
    }

    /**
     * get module name
     * @return type
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * 로그 경로 처리
     * @return type
     */
    public function getLogPath()
    {
        return getLogPath('payment', $this->moduleName, $this->input->server('SERVER_ADDR'));
    }

    /**
     * infoinput.view.php 에서 PG 관련 스크립트 로드
     * @return mixed
     */
    public function getPaymentIncludeJavaScript()
    {
        $agentType = (is_mobile() ? 'M' : 'W');
        $this->init($this->getPayModuleNameByMethod(ORDER_METHOD_CARD), $agentType);
        $script = $this->module->getPaymentIncludeJavaScript();

        //추가 결제 수단 payment include
        if (ForbizConfig::getMallConfig('add_sattle_module_naverpay_pg') == 'Y') {
            $this->init($this->getPayModuleNameByMethod(ORDER_METHOD_NPAY), $agentType);
            $script .= $this->module->getPaymentIncludeJavaScript();
        }
        return $script;
    }

    /**
     * 결제 성공
     * @param type $oid
     */
    public function paymentSuccess($oid)
    {
        redirect('/shop/paymentComplete');
    }

    /**
     * 결제 실패
     */

    public function paymentFailGoCart($resultMsg)
    {
        echo implode("",
            [
                "<script>"
                , "alert('결제 실패 : " . trim($resultMsg) . "');"
                , "location.replace('/shop/cart')"
                , "</script>"
            ]);
    }

    /**
     * 결제 실패
     * @param type $oid
     */
    public function paymentFail($resultMsg, $cartIxs)
    {
        echo implode("",
            [
                "<script>"
                , "alert('" . trim($resultMsg) . "');"
                , "location.replace('/shop/infoInput?cartIx=" . implode(',', $cartIxs) . "')"
                , "</script>"
            ]);
    }

    /**
     * 결제 승인 요청
     * @param $data
     * @return mixed
     */
    public function paymentApply($data)
    {
        return $this->module->doApply($data);
    }

    /**
     * 취소 요청
     * @param type $oid
     * @return type
     */
    public function requestCancel(PgForbizCancelData $cancelData)
    {
        if (empty($cancelData->logPath)) {
            $cancelData->logPath = $this->getLogPath();
        }
        /* @var $responseData PgForbizResponseData */
        $responseData = new PgForbizResponseData();
        $responseData = $this->module->doCancel($cancelData, $responseData);

        return ['result' => $responseData->result, 'message' => $responseData->message];
    }

    /**
     * get 모듈 class name
     * @param type $moduleName
     * @return type
     */
    protected function getModuleClassName()
    {
        switch ($this->moduleName) {
            default :
                $name = ucfirst($this->moduleName);
                break;
        }
        return $name;
    }

    /**
     * 결제 자바 스크립트
     * @return string
     */
    protected function generationPaymentJavaScript()
    {
        $js = '<script>'
            . 'paymentGateway = {'
            . 'request: function () {'
            . $this->module->getPaymentRequestJavaScript()
            . '}'
            . '}</script>';
        return $js;
    }

    /**
     * 결제 form
     * @param type $data
     * @param type $charset
     * @return string
     */
    protected function generationPaymentFormHtml($data, $charset = "")
    {
        $form = '';

        if (is_array($data)) {
            $form = '<form name="paymentGatewayForm" id="paymentGatewayForm" method="POST" ' . ($charset != '' ? 'accept-charset="' . $charset . '"' : '') . ' >';
            foreach ($data as $key => $val) {
                $form .= '<input type="hidden" name="' . $key . '" id="' . $key . '" value="' . $val . '">';
            }
            $form .= '</form>';
        }

        return $form;
    }
}