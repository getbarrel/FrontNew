<?php

/**
 * Description of ForbizMallFatController
 *
 * @author hoksi
 * @property CustomMallFatModel $fatModel
 */
class ForbizMallFatController extends ForbizMallController
{
    protected $fatModel;

    public function __construct()
    {
        parent::__construct();

        $this->fatModel = $this->import('model.mall.fat');

        if ($this->input->post('countingScreen') == 'current') {
            $this->fatModel->setRefHash($this->input->post('curl'));
        } else {
            $this->fatModel->setRefHash(false);
        }
    }

    /**
     * 상품별 주문,조회 리스트
     */
    public function statProductList()
    {
        $chkField = ['sDate', 'eDate', 'pids[]'];

        if (form_validation($chkField)) {
            $this->setResponseData($this->fatModel
                    ->setSdate($this->input->post('sDate'))
                    ->setEdate($this->input->post('eDate'))
                    ->getViewAndOrderList($this->input->post('pids'))
            );
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 옵션별 주문 분석
     */
    public function getOrderOption()
    {
        $chkField = ['sDate', 'eDate', 'pid'];

        if (form_validation($chkField)) {
            $this->setResponseData($this->fatModel
                    ->setSdate($this->input->post('sDate'))
                    ->setEdate($this->input->post('eDate'))
                    ->getOrderOptionStat($this->input->post('pid'), $this->input->post('option'))
            );
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 구매패턴 분석(성별&연령)
     */
    public function getOrderAge()
    {
        $chkField = ['sDate', 'eDate', 'pid'];

        if (form_validation($chkField)) {
            $this->setResponseData($this->fatModel
                    ->setSdate($this->input->post('sDate'))
                    ->setEdate($this->input->post('eDate'))
                    ->getAgeAndSexOrderStat($this->input->post('pid'))
            );
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 구매패턴 분석(요일별)
     */
    public function getOrderWeek()
    {
        $chkField = ['sDate', 'eDate', 'pid'];

        if (form_validation($chkField)) {
            $this->setResponseData($this->fatModel
                    ->setSdate($this->input->post('sDate'))
                    ->setEdate($this->input->post('eDate'))
                    ->getWeekOrderStat($this->input->post('pid'))
            );
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 구매패턴 분석(시간대별)
     */
    public function getOrderHour()
    {
        $chkField = ['sDate', 'eDate', 'pid'];

        if (form_validation($chkField)) {
            $this->setResponseData($this->fatModel
                    ->setSdate($this->input->post('sDate'))
                    ->setEdate($this->input->post('eDate'))
                    ->getHourOrderStat($this->input->post('pid'))
            );
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 구매패턴 분석(결제수단별)
     */
    public function getOrderPayment()
    {
        $chkField = ['sDate', 'eDate', 'pid'];

        if (form_validation($chkField)) {
            $this->setResponseData($this->fatModel
                    ->setSdate($this->input->post('sDate'))
                    ->setEdate($this->input->post('eDate'))
                    ->getPaymentOrderStat($this->input->post('pid'))
            );
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 주문/조회 분석
     */
    public function getOrderAndView()
    {
        $chkField = ['sDate', 'eDate', 'pid'];

        if (form_validation($chkField)) {
            $this->setResponseData($this->fatModel
                    ->setSdate($this->input->post('sDate'))
                    ->setEdate($this->input->post('eDate'))
                    ->getOrderAndView($this->input->post('pid'))
            );
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 함께 구매한 상품
     */
    public function getTogetherProuct()
    {
        $chkField = ['sDate', 'eDate', 'pid'];

        if (form_validation($chkField)) {
            $this->setResponseData($this->fatModel
                    ->setSdate($this->input->post('sDate'))
                    ->setEdate($this->input->post('eDate'))
                    ->getTogetherProuct($this->input->post('pid'))
            );
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 오늘주문 분석
     */
    public function getTodayTotal()
    {
        $this->setResponseData($this->fatModel->getTodayTotal());
    }

    /**
     * 카테고리 정보
     */
    public function getCategory()
    {
        $this->setResponseData($this->fatModel->getCategory($this->input->post('cid')));
    }

    /**
     * 기간별 구매패턴 분석
     */
    public function purchasePattern()
    {
        $chkField = ['sDate', 'eDate', 'ptype'];

        if (form_validation($chkField)) {
            $this->setResponseData($this->fatModel
                    ->setSdate($this->input->post('sDate'))
                    ->setEdate($this->input->post('eDate'))
                    ->setCid($this->input->post('cid'))
                    ->getPurchasePattern($this->input->post('ptype'))
            );
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 엑셀 데이터 전송
     */
    public function getExcelData()
    {
        $chkField = ['sDate', 'eDate', 'pids'];

        if (form_validation($chkField)) {
            $this->setResponseData($this->fatModel
                    ->setSdate($this->input->post('sDate'))
                    ->setEdate($this->input->post('eDate'))
                    ->getExcelData($this->input->post('pids'))
            );
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    public function purchaseTargetGoods()
    {
        $chkField = ['sDate', 'eDate'];

        if (form_validation($chkField)) {
            $this->setResponseData($this->fatModel
                    ->setSdate($this->input->post('sDate'))
                    ->setEdate($this->input->post('eDate'))
                    ->getPurchaseTargetGoods($this->input->post('sex'), $this->input->post('age'))
            );
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }
}