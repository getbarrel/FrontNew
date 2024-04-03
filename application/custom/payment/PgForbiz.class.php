<?php

/**
 *
 * @author Hong
 */
abstract class PgForbiz extends ForbizModel
{

    /**
     * 사용 환경 (W: PC, M:모바일, A:APP)
     * @var string
     */
    protected $agentType;

    public function __construct($agentType)
    {
        parent::__construct();
        $this->agentType = $agentType;
    }

    /**
     * get 결제 요청 데이터
     * @param PgForbizPaymentData $paymentData
     */
    abstract public function getPaymentRequestData(PgForbizPaymentData $paymentData): array;

    /**
     * get 결제 요청 자바스크립트 include
     */
    abstract public function getPaymentIncludeJavaScript(): string;

    /**
     * get 결제 요청 자바스크립트
     */
    abstract public function getPaymentRequestJavaScript(): string;

    /**
     * 결제 승인 ( 결제 모듈마다 리턴데이터 타입이 다를수 있어 정의 따로 안함 )
     */
    abstract public function doApply($data);

    /**
     * 결제 취소
     */
    abstract public function doCancel(PgForbizCancelData $cancelData, PgForbizResponseData $responseData): PgForbizResponseData;
}
