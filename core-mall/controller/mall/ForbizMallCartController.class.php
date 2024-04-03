<?php

/**
 * Description of ForbizMallCartController
 *
 * @author hong
 * @property CustomMallCartModel $cartModel
 */
class ForbizMallCartController extends ForbizMallController
{
    /**
     * 장바구니 모델
     */
    public $cartModel;

    public function __construct()
    {
        parent::__construct();
        $this->cartModel = $this->import('model.mall.cart');
    }

    /**
     * 선택된 상품 Summery 정보 조회
     * array cartIxs
     */
    public function getSummary()
    {
        $cartIxs = $this->input->post('cartIxs');
        $cart    = $this->cartModel->get($cartIxs);
        $this->setResponseData($this->cartModel->getSummary($cart));
    }

    /**
     * 상품 삭제
     * array cartIxs
     */
    public function delete()
    {
        $cartIxs = $this->input->post('cartIxs');
        $this->cartModel->delete($cartIxs);
    }

    /**
     * 옵션(추가구성상품) 삭제
     * array cartOptionIxs
     */
    public function deleteOption()
    {
        $cartOptionIxs = $this->input->post('cartOptionIxs');
        $this->cartModel->deleteOption($cartOptionIxs);
    }

    /**
     * 상품 수량 수정
     * int cartIx
     * int count
     */
    public function updateCount()
    {
        $cartIx = $this->input->post('cartIx');
        $count  = $this->input->post('count');

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');
        $row          = $this->cartModel->getProductRow($cartIx);

        if (!empty($row)) {

            // 재고 수량 점검
            $buyCountCondition = $productModel->getBuyCountCondition($row['id'], sess_val('user', 'code'));

            //최소 구매수량 보다 적은 수량일때
            if ($buyCountCondition['allow_basic_cnt'] > 0 && $buyCountCondition['allow_basic_cnt'] > $count) {
                $this->setResponseResult('failBasicCount');
                $this->setResponseData($buyCountCondition['allow_basic_cnt']);
            } else if ($buyCountCondition['allow_byoneperson_cnt'] > 0 && $buyCountCondition['allow_byoneperson_cnt'] < ($buyCountCondition['user_buy_cnt']
                + $count)) {
                //ID당 구매수량이 적을때
                $this->setResponseResult('failByOnePersonCount');
                $this->setResponseData($buyCountCondition['allow_byoneperson_cnt'] - $buyCountCondition['user_buy_cnt']);
            } else if ($row['status'] != 'sale') {
                //상품이 판매중이 아닐때
                $this->setResponseResult('failNoSale');
            } else if ($row['stock'] < $count) {
                //재고 수량보다 많이 입력한 경우
                $this->setResponseResult('failStockLack');
                $this->setResponseData($row['stock']);
            } else {
                //구매수량 업데이트
                $this->cartModel->updateCount($cartIx, $count);

                $this->setResponseResult('success');
            }
        } else {
            $this->setResponseResult('fail');
        }
    }

    /**
     * 옵션(추가구성상품) 수량 수정
     * array cartOptionIx
     * int count
     */
    public function updateOptionCount()
    {
        $cartOptionIx = $this->input->post('cartOptionIx');
        $count        = $this->input->post('count');

        $options = $this->cartModel->getOptionRow($cartOptionIx);

        //재고 수량보다 많이 입력한 경우
        if ($options['option_stock'] < $count) {
            $this->setResponseResult('failStockLack');
            $this->setResponseData($options['option_stock']);
            return;
        }

        //구매수량 업데이트
        $this->cartModel->updateOptionCount($cartOptionIx, $count);
    }

    /**
     * 주문 가능 여부 체크
     * array cartIxs
     */
    public function paymentValidate()
    {
        $cartIxs = $this->input->post('cartIxs');
        $cart    = $this->cartModel->get($cartIxs);

        foreach ($cart as $company) {
            foreach ($company['deliveryTemplateList'] as $deliveryTemplate) {

                foreach ($deliveryTemplate['productList'] as $product) {

                    if ($product['status'] != 'sale') {
                        $this->setResponseResult('fail');
                        return;
                    } else if ($product['stock'] < $product['pcount']) {
                        $this->setResponseResult('fail');
                        $this->setResponseData(['cart_ix'=>$product['cart_ix'], 'stock'=>$product['stock']]);
                        return;
                    }
                    foreach ($product['addOptionList'] as $addOption) {
                        if ($addOption['stock'] < $addOption['opn_count']) {
                            $this->setResponseResult('fail');
                            return;
                        }
                    }
                }
            }
        }
    }

    /**
     * 카트에 상품을 추가함
     */
    public function add()
    {
        $datas             = $this->input->post('data');
        $productModel      = $this->import('model.mall.product');
        $buyCountCondition = $productModel->getBuyCountCondition($datas[0]['pid'], sess_val('user', 'code'));

        foreach ($datas as $k => $v) {
            $option_infos = $productModel->getOption($v['pid'], 'row', $v['optionId']);

            //최소 구매수량 보다 적은 수량일때
            if ($buyCountCondition['allow_basic_cnt'] > 0 && $buyCountCondition['allow_basic_cnt'] > $v['count']) {
                $this->setResponseResult('failBasicCount');
                $this->setResponseData($buyCountCondition['allow_basic_cnt']);
                return;
            }
            //ID당 구매수량이 적을때
            else if ($buyCountCondition['allow_byoneperson_cnt'] > 0 && $buyCountCondition['allow_byoneperson_cnt'] < ($buyCountCondition['user_buy_cnt']
                + $v['count'])) {
                //옵션으로 구매수량 계산시 애매하여 차후 PM 협의필요. 180907
                $this->setResponseResult('failByOnePersonCount');
                $this->setResponseData($buyCountCondition['allow_byoneperson_cnt'] - $buyCountCondition['user_buy_cnt']);
                return;
            }
            //재고 수량보다 많이 입력한 경우
            else if ($option_infos['option_stock'] < $v['count']) {
                $this->setResponseResult('failStockLack');
                $this->setResponseData($option_infos['option_stock']);
                return;
            } else if (!is_numeric($v['count'])) {
                $this->setResponseResult('failNotNumeric');
                return;
            }
        }

        $cartIxs = $this->cartModel->add($datas);
        $this->setResponseData($cartIxs);
    }
}