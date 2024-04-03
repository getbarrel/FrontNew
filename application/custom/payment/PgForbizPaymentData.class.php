<?php

/**
 * Description of PgForbizPaymentData
 *
 * @author Hong
 */
class PgForbizPaymentData
{

    /**
     * 주문번호
     * @var string
     */
    public $oid;

    /**
     * 상품갯수
     * @var int
     */
    public $goodsCount;

    /**
     * 상품 구매 수량 총 갯수
     * @var int
     */
    public $totalPcnt;

    /**
     * 대표 상품명 (예: 장미의 이름 외 1건(X), 장미의 이름(O))
     * @var string
     */
    public $mainGoodsName;

    /**
     * 상품명
     * @var string
     */
    public $goodsName;

    /**
     * 결제 금액
     * @var int
     */
    public $amt;

    /**
     * 결제 금액 - 과세
     * @var int
     */
    public $taxAmt;

    /**
     * 결제 금액 - 비과세
     * @var int
     */
    public $taxExAmt;

    /**
     * 결제 수단
     * @var int
     */
    public $method;

    /**
     * 구매자 아이디
     * @var string
     */
    public $buyerId;

    /**
     * 구매자 명
     * @var string
     */
    public $buyerName;

    /**
     * 구매자 핸드폰 번호
     * @var string
     */
    public $buyerMobile;

    /**
     * 구매자 이메일
     * @var string
     */
    public $buyerEmail;

    /**
     * 입금 일자 (YYYYMMDD)
     * @var type
     */
    public $vbankExpirationDate;

    /**
     * 구매 상품 정보 리스트
     * @var type
     */
    public $goodsList;
}
