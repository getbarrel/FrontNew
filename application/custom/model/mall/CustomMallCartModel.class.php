<?php

/**
 * Description of CustomerMallCartModel
 *
 * @author hong
 *
 */
class CustomMallCartModel extends ForbizMallCartModel
{

    /**
     * 회원 무료 배송 여부
     * @var string
     */
    protected $shippingFreeYn;

    public function __construct()
    {
        parent::__construct();

        $this->shippingFreeYn = sess_val('user', 'shipping_free_yn');
    }

    /**
     * 카트에 담긴 상품수
     * 일반 상품 + 세트상품 수 구분 처리
     * @return int 카트에 담긴 상품수
     */
    public function cartCnt()
    {
        // 1 일반 상품
        $this->qb->setDatabase('payment');
        $productCnt = $this->userWhere()
            ->from(TBL_SHOP_CART . ' AS c')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'c.id = p.id')
            ->where('est_ix', '0')
            ->where('state !=', '2')
            ->where('set_group =', '0')
            ->where('disp', '1')
            ->where("if(p.is_sell_date = '1',p.sell_priod_sdate <= '" . date('Y-m-d H:i:s') . "' and p.sell_priod_edate >= '" . date('Y:m:d H:i:s') . "','1=1')", '', false)
            ->getCount();

        // 2. 세트상품
        $this->qb->setDatabase('payment');
        $setProduct = $this->userWhere()
            ->select('c.set_group')
            ->from(TBL_SHOP_CART . ' AS c')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'c.id = p.id')
            ->where('est_ix', '0')
            ->where('state !=', '2')
            ->where('set_group !=', '0')
            ->where('disp', '1')
            ->where("if(p.is_sell_date = '1',p.sell_priod_sdate <= '" . date('Y-m-d H:i:s') . "' and p.sell_priod_edate >= '" . date('Y:m:d H:i:s') . "','1=1')", '', false)
            ->groupby('set_group')
            ->exec()->getResultArray();

        return ($productCnt + count($setProduct));
    }


    /**
     * 사은품 선택유무
    */
    private function chkGiftPrd($data)
    {
        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');
        $choiceGift = '';

        $resGift = $productModel->getGift($data['pid'],'s',1);
        if(!empty($resGift)){
            if (isset($data['giftItemList']) && is_array($data['giftItemList']) && count($data['giftItemList']) > 0) {
                $choiceGift = 'Y';
            }else{//사은품을 선택하지 않음
                $choiceGift = 'N';
            }
        }else{//사은품이 존재하지 않을경우
            $choiceGift = 'E';
        }

        return $choiceGift;
    }

    /**
     * 추가
     * $datas[] = [
     *  'pid' => '상품ID', 'optionId' => '선택옵션ID', 'count' => '수량'
     *  , 'addOptionList'[] => ['optionId' => '추가구성ID', 'count' => '추가구성수량']
     * ]
     * @param array $datas
     * @return array 추가된 cart_ix
     */
    public function add($datas, $viewType = "", $beForCartIx = "")
    {
        if ($viewType == 'change' && $beForCartIx) {
            //$this->delete($beForCartIx);

            $addCartIxs = [];
            if (is_array($datas)) {
                foreach ($datas as $key=> $data) {
                    //선택 옵션일 경우 , 구분으로 여러게 넘어 오기 때문에 값 정렬처리!
                    $optionText = "";
                    if (!empty($data['optionId'])) {

                        $data['choiceGift'] = $this->chkGiftPrd($data);

                        // 세트상품인가?
                        if ($data['option_kind'] == 's2') {
                            // 세트상품 ID 조회
                            $addCartIxs = array_merge($addCartIxs, $this->changeCartSet($data, $beForCartIx));

                        } elseif ($data['option_kind'] == 'c') {
                            $addCartIxs = array_merge($addCartIxs, $this->changeCartCodi($data, $beForCartIx));
                        } else {

                            // 옵션 정렬
                            $data['optionId'] = $this->sortOptionId($data['optionId']);
                            $data['cart_ix'] = $beForCartIx[0];
                            //장바구니 추가/수정
                            $cartIx = $this->changeCartInfo($data);

                            $addCartIxs[] = $cartIx;

                            //장바구니 추가구성상품
                            if (isset($data['addOptionList']) && is_array($data['addOptionList'])) {
                                foreach ($data['addOptionList'] as $addOption) {

                                    //추가구성상품 추가/수정
                                    $this->replaceCartAddOption($cartIx, $addOption);
                                }
                            }
                        }

						if (isset($data['giftItemList']) && is_array($data['giftItemList']) && count($data['giftItemList']) > 0) {
							//사은품 등록
							//옵션 수정 시 사은 품 수량 획득하기
							$giftItemCnt = $this->getCartItemCount($addCartIxs[$key]);
							$this->insertGiftItem($addCartIxs[$key], $data['giftItemList'], $giftItemCnt);
						} else {
							//이미 등록 된 사은품이 있을때 바로 구매 상태로 사은품 지정 안할 경우 사은품 정보가 삭제 되어야 하기때문에 장바구니 키 값을 이용한 사은품 삭제 프로세스 진행

							$this->deleteGiftItem($addCartIxs[$key]);
						}
                    }
                }
            }
        } else {
            $addCartIxs = [];
            $inputCartIx = [];
            if (is_array($datas)) {
                foreach ($datas as $key=> $data) {
                    //선택 옵션일 경우 , 구분으로 여러게 넘어 오기 때문에 값 정렬처리!
                    $optionText = "";
                    if (!empty($data['optionId'])) {

                        $data['choiceGift'] = $this->chkGiftPrd($data);
                        // 세트상품인가?
                        if ($data['option_kind'] == 's2') {
                            // 세트상품 ID 조회
                            $inputCartIx = $this->replaceCartSet($data);
                            $addCartIxs = array_merge($addCartIxs, $inputCartIx);
                        } elseif ($data['option_kind'] == 'c') {
                            $inputCartIx = $this->replaceCartCodi($data);
                            $addCartIxs = array_merge($addCartIxs, $inputCartIx);
                        } else {

                            // 옵션 정렬
                            $data['optionId'] = $this->sortOptionId($data['optionId']);

                            //장바구니 추가/수정
                            $cartIx = $this->replaceCartInfo($data);
                            $inputCartIx[] = $cartIx;
                            $addCartIxs[] = $cartIx;

                            //장바구니 추가구성상품
                            if (isset($data['addOptionList']) && is_array($data['addOptionList'])) {
                                foreach ($data['addOptionList'] as $addOption) {

                                    //추가구성상품 추가/수정
                                    $this->replaceCartAddOption($cartIx, $addOption);
                                }
                            }
                        }

						if (isset($data['giftItemList']) && is_array($data['giftItemList']) && count($data['giftItemList']) > 0) {
							//사은품 등록
							$this->insertGiftItem($inputCartIx[$key], $data['giftItemList'], $data['giftItemCnt']);
						} else {
							//이미 등록 된 사은품이 있을때 바로 구매 상태로 사은품 지정 안할 경우 사은품 정보가 삭제 되어야 하기때문에 장바구니 키 값을 이용한 사은품 삭제 프로세스 진행

							$this->deleteGiftItem($inputCartIx[$key]);
						}
                    }
                }
            }
        }

        return $addCartIxs;
    }

    /**
     * 카트ID를 조회한다
     * @param string $pid 상품ID
     * @param string $dataOprionId 상품옵션ID
     * @param string $optKind 옵션타입
     * @return string | boolean
     */
    public function getCartIx($pid, $dataOptionId, $setGroup = false)
    {
        // 세트상품이나 코디상품인 경우 set_group 검색 추가
        if ($setGroup > 0) {
            $this->qb->where('set_group', $setGroup);
        }

        $row = $this->userWhere()
            ->select('cart_ix')
            ->from(TBL_SHOP_CART . ' AS c')
            ->where('id', $pid)
            ->where('select_option_id', $dataOptionId)
            ->exec()
            ->getRow();

        return isset($row->cart_ix) ? $row->cart_ix : false;
    }

    /**
     * 옵션을 정렬한다.
     * @param string $dataOptionId 옵션ID (여러개일 경우 ,로 분리)
     * @return string
     */
    protected function sortOptionId($dataOptionId)
    {
        $optionIds = explode(",", $dataOptionId);
        if (count($optionIds) > 1) {
            sort($optionIds, SORT_NUMERIC);
            return implode(",", $optionIds);
        } else {
            return $dataOptionId;
        }
    }

    public function getProductOptionTextNew($optionDetailId, $option_name = false){
        $optionDetailIds = explode(",", $optionDetailId);

        $list = $this->qb
            ->select('pod.option_div')
            ->select('po.option_name')
            ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' as pod')
            ->join(TBL_SHOP_PRODUCT_OPTIONS . ' as po', 'pod.opn_ix = po.opn_ix')
            ->whereIn('pod.id', $optionDetailIds)
            ->exec()
            ->getResultArray();

        $optionText = [];
        foreach ($list as $li) {
            if ($option_name != false) {
                $optionText[] = $option_name . ":" . $li['option_div'];
            } else {
                $optionText[] = $li['option_name'] . ":" . $li['option_div'];
            }
        }

        return implode(", ", $optionText);
    }

    /**
     * get 옵션명
     * @param int $optionDetailId
     * @return string
     */
    protected function getProductOptionText($optionDetailId, $option_name = false)
    {
        $optionDetailIds = explode(",", $optionDetailId);

        $list = $this->qb
            ->select('pod.option_div')
            ->select('po.option_name')
            ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' as pod')
            ->join(TBL_SHOP_PRODUCT_OPTIONS . ' as po', 'pod.opn_ix = po.opn_ix')
            ->whereIn('pod.id', $optionDetailIds)
            ->exec()
            ->getResultArray();

        $optionText = [];
        foreach ($list as $li) {
            if ($option_name != false) {
                $optionText[] = $option_name . ":" . $li['option_div'];
            } else {
                $optionText[] = $li['option_name'] . ":" . $li['option_div'];
            }
        }

        return implode(", ", $optionText);
    }

    /**
     * 장바구니 ITEM을 추가/수정 한다.
     * @param array $data 장바구니 ITEM DATA
     * @return int
     */
    protected function replaceCartInfo($data)
    {
        // 옵션 텍스트 생성
        $option_name = ($data['option_name'] ?? '');
        $set_group = ($data['set_group'] ?? 0);
        $optionText = $this->getProductOptionText($data['optionId'], $option_name);
        //장바구니ID 조회
        $cartIx = $this->getCartIx($data['pid'], $data['optionId'], $set_group);

        if ($cartIx) {
            //수정
            $this->userWhere()
                ->set('pcount', $data['count'])
                ->set('options_text', $optionText)
                ->set('choice_gift', $data['choiceGift'])
                ->where('cart_ix', $cartIx)
                ->update(TBL_SHOP_CART . ' AS c')
                ->exec();
        } else {
            /* @var $collectModel CustomMallCollectModel */
            $collectModel = $this->import('model.mall.collect');

            //추가
            $this->userSet()
                ->set('id', $data['pid'])
                ->set('pcount', $data['count'])
                ->set('choice_gift', $data['choiceGift'])
                ->set('select_option_id', $data['optionId'])
                ->set('options_text', $optionText)
                ->set('set_group', $set_group)
                ->set('regdate', date('Y-m-d H:i:s'))
                ->set('hash_idx', $collectModel->setPid($data['pid'])->getHash())
                ->insert(TBL_SHOP_CART)
                ->exec();

            $cartIx = $this->qb->getInsertId();
        }

        return $cartIx;
    }


    /**
     * 장바구니 ITEM을 수정 한다.
     * @param array $data 장바구니 ITEM DATA
     * @return int
     */
    protected function changeCartInfo($data)
    {
        // 옵션 텍스트 생성
        $option_name = ($data['option_name'] ?? '');
        $set_group = ($data['set_group'] ?? 0);
        $optionText = $this->getProductOptionText($data['optionId'], $option_name);
        //장바구니ID 조회

        $cartIx = $data['cart_ix'];

        if ($cartIx) {

            $this->userWhere()
                ->select()
                ->from(TBL_SHOP_CART . ' AS c')
                ->where('select_option_id', $data['optionId'])
                ->where('set_group', $set_group)
                ->whereNotIn('cart_ix', $cartIx);
            $total = $this->qb->getCount();

            if ($total > 0) {
                if (isset($data['addOptionList']) && is_array($data['addOptionList'])) {

                } else {
                    if ($this->userType == 'member') {
                        $this->qb->where('mem_ix', $this->userKey);
                    } else {
                        $this->qb->where('cart_key', $this->userKey);
                    }
                    $this->qb
                        ->delete(TBL_SHOP_CART)
                        ->where('cart_ix', $cartIx)
                        ->exec();
                }

                $this->userWhere()
                    ->select('pcount')
                    ->from(TBL_SHOP_CART . ' AS c')
                    ->where('select_option_id', $data['optionId'])
                    ->where('set_group', $set_group);
                $cartData = $this->qb->exec()->getRowArray();

                $pcount = $cartData['pcount'];

                $this->userWhere()
                    ->set('pcount', $pcount)
                    ->where('select_option_id', $data['optionId'])
                    ->where('set_group', $set_group)
                    ->update(TBL_SHOP_CART . ' AS c')
                    ->exec();
            } else {
                //수정
                $this->userWhere()
                    ->set('select_option_id', $data['optionId'])
                    ->set('options_text', $optionText)
                    ->set('set_group', $set_group)
                    ->where('cart_ix', $cartIx)
                    ->update(TBL_SHOP_CART . ' AS c')
                    ->exec();
            }

        } else {
            /* @var $collectModel CustomMallCollectModel */
            $collectModel = $this->import('model.mall.collect');

            //추가
            $this->userSet()
                ->set('id', $data['pid'])
                ->set('pcount', $data['count'])
                ->set('select_option_id', $data['optionId'])
                ->set('options_text', $optionText)
                ->set('set_group', $set_group)
                ->set('regdate', date('Y-m-d H:i:s'))
                ->set('hash_idx', $collectModel->setPid($data['pid'])->getHash())
                ->insert(TBL_SHOP_CART)
                ->exec();

            $cartIx = $this->qb->getInsertId();
        }

        return $cartIx;
    }

    /**
     * 장바구니 추가구성상품 추가/수정
     * @param type $cartIx
     * @param type $addOption
     */
    protected function replaceCartAddOption($cartIx, $addOption)
    {
        $cartAddOption = $this->qb
            ->select('cart_option_ix')
            ->from(TBL_SHOP_CART_OPTIONS)
            ->where('cart_ix', $cartIx)
            ->where('opn_d_ix', $addOption['optionId'])
            ->exec()
            ->getRow();

        $addOptionText = $this->getProductOptionText($addOption['optionId']);

        if (isset($cartAddOption->cart_option_ix)) {
            //수정
            $this->qb
                ->set('opn_count', 'opn_count + ' . $addOption['count'], false)
                ->set('opn_text', $addOptionText)
                ->where('cart_option_ix', $cartAddOption->cart_option_ix)
                ->update(TBL_SHOP_CART_OPTIONS)
                ->exec();
        } else {
            //등록
            $this->qb
                ->set('cart_ix', $cartIx)
                ->set('opn_count', $addOption['count'])
                ->set('opn_d_ix', $addOption['optionId'])
                ->set('opn_text', $addOptionText)
                ->set('regdate', date('Y-m-d H:i:s'))
                ->insert(TBL_SHOP_CART_OPTIONS)
                ->exec();
        }
    }

    /**
     * 세트/코디 상품 카트 옵션정보 추가/수정
     * @return int | boolean
     */
    protected function replaceCartSetCodiData($data)
    {
        if ($this->userType == 'member') {
            $userCode = $this->userKey;
            $cartKey = '';
        } else {
            $userCode = '';
            $cartKey = $this->userKey;
        }

        // 코디상품인가?
        if ($data['option_kind'] == 'c') {
            $this->qb->where('codi_opn_d_ix', $data['optionId']);
        } else {
            $this->qb->where('opn_d_ix', $data['optionId']);
        }

        // 세트 상품 키 조회
        $row = $this->qb
            ->select('shop_cart_set_id')
            ->from(TBL_SHOP_CART_SET)
            ->where('cart_key', $cartKey)
            ->where('mem_ix', $userCode)
            ->exec()
            ->getRow();

        $shop_cart_set_id = isset($row->shop_cart_set_id) ? $row->shop_cart_set_id : false;

        // 세트 상품 추가 or 수정
        if ($shop_cart_set_id) {
            $this->qb
                ->set('pcount', $data['count'])
                ->where('shop_cart_set_id', $shop_cart_set_id)
                ->update(TBL_SHOP_CART_SET)
                ->exec();
        } else {
            // 코디상품인가?
            if ($data['option_kind'] == 'c') {
                $this->qb->set('codi_opn_d_ix', $data['optionId']);
            } else {
                $this->qb->set('opn_d_ix', $data['optionId']);
            }

            $shop_cart_set_id = $this->qb
                ->set('opn_ix', $data['opn_ix'])
                ->set('pcount', $data['count'])
                ->set('mem_ix', $userCode)
                ->set('cart_key', $cartKey)
                ->insert(TBL_SHOP_CART_SET)
                ->exec();
        }

        return $shop_cart_set_id;
    }

    /**
     * 세트/코디 상품 카트 옵션정보 수정
     * @return int | boolean
     */
    protected function changeCartSetCodiData($data)
    {
        if ($this->userType == 'member') {
            $userCode = $this->userKey;
            $cartKey = '';
        } else {
            $userCode = '';
            $cartKey = $this->userKey;
        }

        // 코디상품인가?
        if ($data['option_kind'] == 'c') {
            $this->qb->where('codi_opn_d_ix', $data['optionId']);
        } else {
            $this->qb->where('opn_d_ix', $data['optionId']);
        }

        // 세트 상품 키 조회
        $row = $this->qb
            ->select('shop_cart_set_id')
            ->from(TBL_SHOP_CART_SET)
            ->where('cart_key', $cartKey)
            ->where('mem_ix', $userCode)
            ->exec()
            ->getRow();

        $shop_cart_set_id = isset($row->shop_cart_set_id) ? $row->shop_cart_set_id : false;

        // 세트 상품 추가 or 수정
        if ($shop_cart_set_id) {
//            $this->qb
//                ->set('pcount', $data['count'])
//                ->where('shop_cart_set_id', $shop_cart_set_id)
//                ->update(TBL_SHOP_CART_SET)
//                ->exec();
        } else {
            // 코디상품인가?
            if ($data['option_kind'] == 'c') {
                $this->qb->set('codi_opn_d_ix', $data['optionId']);
            } else {
                $this->qb->set('opn_d_ix', $data['optionId']);
            }

            $shop_cart_set_id = $this->qb
                ->set('opn_ix', $data['opn_ix'])
                ->set('pcount', $data['count'])
                ->set('mem_ix', $userCode)
                ->set('cart_key', $cartKey)
                ->insert(TBL_SHOP_CART_SET)
                ->exec();
        }

        return $shop_cart_set_id;
    }

    /**
     * 장바구니 코디상품을 추가한다.
     * @param array $data
     */
    protected function replaceCartCodi($data)
    {
        $set_group = $this->replaceCartSetCodiData($data);
        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        $rows = $productModel->getCodiOptionInfo($data['pid'], $data['optionId']);

        $addCartIxs = [];
        foreach ($rows as $row) {
            $set_data = [
                'pid' => $data['pid']
                , 'optionId' => $row['id']
                , 'count' => $data['count'] * $row['option_etc1'] // 구매 수량 * 구성 수량
                , 'option_kind' => $data['option_kind']
                , 'opn_ix' => $data['opn_ix']
                , 'option_name' => '' //$row['option_div']
                , 'set_group' => $set_group
                , 'choiceGift' => $data['choiceGift']
            ];

            //장바구니 추가/수정
            $addCartIxs[] = $this->replaceCartInfo($set_data);
        }

        return $addCartIxs;
    }

    /**
     * 장바구니 코디상품을 수정한다.
     * @param array $data
     */
    protected function changeCartCodi($data, $beForCartIx)
    {
        $this->deleteCartSet($beForCartIx);
        $set_group = $this->changeCartSetCodiData($data);
        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        $rows = $productModel->getCodiOptionInfo($data['pid'], $data['optionId']);

        $cartIxArr = explode(',', $beForCartIx[0]);

        $addCartIxs = [];
        foreach ($rows as $key => $row) {
            $set_data = [
                'pid' => $data['pid']
                , 'optionId' => $row['id']
                , 'count' => $data['count'] * $row['option_etc1'] // 구매 수량 * 구성 수량
                , 'option_kind' => $data['option_kind']
                , 'opn_ix' => $data['opn_ix']
                , 'option_name' => '' //$row['option_div']
                , 'set_group' => $set_group
                , 'cart_ix' => $cartIxArr[$key]
            ];

            //장바구니 추가/수정
            $addCartIxs[] = $this->changeCartInfo($set_data);
        }

        return $addCartIxs;
    }

    /**
     * 장바구니 세트상품을 추가한다.
     * @param array $data
     * @return int
     */
    protected function replaceCartSet($data)
    {
        $set_group = $this->replaceCartSetCodiData($data);

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        // 세트상품 조회
        $rows = $productModel->getSetOptionInfo($data['pid'], $data['opn_ix'], $data['optionId']);
        $setOptionName = $productModel->getOptionDiv($data['optionId']);

        $addCartIxs = [];
        foreach ($rows as $row) {
            $set_data = [
                'pid' => $data['pid']
                , 'optionId' => $row['id']
                , 'count' => ($row['option_etc1'] > 0 ? $data['count'] * $row['option_etc1'] : $data['count']) // 구매 수량 * 구성 수량
                , 'option_kind' => $data['option_kind']
                , 'opn_ix' => $data['opn_ix']
                , 'option_name' => $setOptionName
                , 'set_group' => $set_group
                , 'choiceGift' => $data['choiceGift']
            ];

            //장바구니 추가/수정
            $addCartIxs[] = $this->replaceCartInfo($set_data);
        }

        return $addCartIxs;
    }


    /**
     * 장바구니 세트상품을 변경한다.
     * @param array $data
     * @return int
     */
    protected function changeCartSet($data, $beForCartIx)
    {
        $set_group = $this->changeCartSetCodiData($data);

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        // 세트상품 조회
        $rows = $productModel->getSetOptionInfo($data['pid'], $data['opn_ix'], $data['optionId']);
        $setOptionName = $productModel->getOptionDiv($data['optionId']);

        $cartIxArr = explode(',', $beForCartIx[0]);

        $addCartIxs = [];
        foreach ($rows as $key => $row) {
            $set_data = [
                'pid' => $data['pid']
                , 'optionId' => $row['id']
                , 'count' => ($row['option_etc1'] > 0 ? $data['count'] * $row['option_etc1'] : $data['count']) // 구매 수량 * 구성 수량
                , 'option_kind' => $data['option_kind']
                , 'opn_ix' => $data['opn_ix']
                , 'option_name' => $setOptionName
                , 'set_group' => $set_group
                , 'cart_ix' => $cartIxArr[$key]
            ];

            //장바구니 추가/수정
            $addCartIxs[] = $this->changeCartInfo($set_data);
        }

        return $addCartIxs;
    }

    /**
     * 옵션 데이터 조회
     * @param array $product
     * @param CustomMallProductModel $productModel
     * @return array
     */
    protected function getOptionData($product, $productModel)
    {

        // 코디 상품인가?
        if ($product['select_option_id'] == 'codi') {
            // 품절 체크 코드
            $isStop = false;
            // 세트 주문정보
            $setData = $this->getCartSetData($product['set_group']);

            // 옵션 기본값
            $option = [
                'option_kind' => 'c'
                , 'option_id' => 'codi'
                , 'option_div' => ''
                , 'option_listprice' => 0
                , 'option_sellprice' => 0
                , 'option_dcprice' => 0
                , 'option_add_price' => 0
                , 'option_discount_amount' => 0
                , 'option_discount_rate' => 0
                , 'optionDiscountList' => []
                , 'option_stock' => 0
                , 'opn_ix' => ''
                , 'optionDiscountList' => []
                , 'weight' => 0
            ];

            foreach ($product['setData'] as $pitem) {
                $opt = $productModel->getOption($product['id'], 'row', $pitem['optionId']);

                $option['option_listprice'] += $opt['option_listprice'];
                $option['option_sellprice'] += $opt['option_sellprice'];
                $option['option_dcprice'] += $opt['option_dcprice'];
                $option['option_add_price'] += $opt['option_add_price'];
                $option['option_discount_amount'] += $opt['option_discount_amount'];
                $option['option_discount_rate'] += $opt['option_discount_rate'];
                $option['weight'] += empty($opt['weight']) ? 0 : $opt['weight'];

                if ($option['option_stock'] == 0 || $option['option_stock'] > $opt['option_stock']) {
                    $option['option_stock'] = $opt['option_stock']; // 확인 필요
                }

                if (!empty($opt['optionDiscountList'])) {
                    foreach ($opt['optionDiscountList'] as $discount) {
                        $index = array_search($discount['type'], array_column($option['optionDiscountList'], 'type'));
                        if ($index === false) {
                            $option['optionDiscountList'][] = $discount;
                        } else {
                            $option['optionDiscountList'][$index]['discount_amount'] += $discount['discount_amount'];
                            $option['optionDiscountList'][$index]['headoffice_discount_amount'] += $discount['headoffice_discount_amount'];
                            $option['optionDiscountList'][$index]['seller_discount_amount'] += $discount['seller_discount_amount'];
                        }
                    }
                }

                // 키 체크
                if ($pitem['optionId'] != $opt['option_id']) {
                    $option['option_id'] = 'stop';
                }
            }
        } else {
            $option = $productModel->getOption($product['id'], 'row', $product['select_option_id']);
        }

        return $option;
    }

    /**
     * 정보 조회
     * API로 바로 데이터 구조 호출 X (노출되면 안되는 정보도 있기 때문에)
     * @param array $cartIxs
     * @param string $zipCode
     * @param array $useCoupon
     * @return array
     */
    public function get($cartIxs = [], $zipCode = '', $useCoupon = [], $isOrder = false, $cartCouponData = false, $setProductCouponData = false,$deliveryCouponData = false)
    {

        //배송 업체별로 상품 정보 리스트
        $cartData = $this->getGroupByDeliveryCompany($cartIxs, $isOrder);

        if (!empty($cartData)) {

            /* @var $productModel CustomMallProductModel */
            $productModel = $this->import('model.mall.product');
            $productModel->setDiscoutMemberGroupCalculationYn('Y');
            /* @var $mileageModel CustomMallMileageModel */
            $mileageModel = $this->import('model.mall.mileage');
            /* @var $couponModel CustomMallCouponModel */
            $couponModel = $this->import('model.mall.coupon');

            if (!is_array($useCoupon)) {
                $useCoupon = [];
            }

            //상품 추가 정보 select column
            $addProductColumn = ['p.admin', 'p.surtax_yorn'];

            // 도소매 구분 (R:소매, W:도매)
            if ($this->sellingType == 'W') {
                $addProductColumn = array_merge($addProductColumn,
                    ['p.wholesale_reserve_yn as reserve_yn', 'p.wholesale_rate_type as rate_type', 'p.wholesale_reserve_rate as reserve_rate']);
            } else {
                $addProductColumn = array_merge($addProductColumn, ['p.reserve_yn', 'p.rate_type', 'p.reserve_rate']);
            }

            // 세트,코디 상품별 배송비 확인용
            $setGroupDelivery = [];


            //업체 Loop 2 start
            foreach ($cartData as $cartDataKey => $data) {

                $companySumProductListprice = f_decimal(0);
                $companySumProductSellprice = f_decimal(0);
                $companySumProductDcprice = f_decimal(0);
                $companySumOrgTotalDeliveryPrice = f_decimal(0);
                $companySumTotalDeliveryPrice = f_decimal(0);
                $companySumDeliveryPrice = f_decimal(0);
                $companySumDeliveryAddPrice = f_decimal(0);
                $companySumPaymentPrice = f_decimal(0);
                $companySumMileagePrice = f_decimal(0);

                $companySumDiscountMem = f_decimal(0);
                $companySumDiscountSpecial = f_decimal(0);


                // LOOP 1. 배송정책 Loop start
                foreach ($data['deliveryTemplateList'] as $deliveryTemplateKey => $deliveryTemplate) {

                    //상품 정보 가지고 오기
                    $productList = $productModel->getListById(array_column($deliveryTemplate['productList'], 'id'), 'm', $addProductColumn);
                    $deliverySumProductListprice = f_decimal(0);
                    $deliverySumProductSellprice = f_decimal(0);
                    $deliverySumProductDcprice = f_decimal(0);
                    $deliverySumProductCouponWithDcprice = f_decimal(0);
                    $deliverySumProductQty = 0;
                    $deliverySumProductWeight = 0;

                    //상품 Loop start 1.1
                    foreach ($deliveryTemplate['productList'] as $key => $list) {

                        $product = array_merge($list, $productList[array_search($list['id'], array_column($productList, 'id'))]);

                        //옵션 정보로 가격 변경
                        $product['add_price'] = 0;

                        if (!empty($product['select_option_id'])) {

                            // 옵션 정보 조회
                            $option = $this->getOptionData($product, $productModel);

                            //옵션이 삭제되었거나 변경되었을때 예외처리
                            if ($product['select_option_id'] != $option['option_id']) {
                                $product['status'] = 'stop';
                            }

                            $product['option_kind'] = $option['option_kind'];
                            $product['listprice'] = $option['option_listprice'];
                            $product['sellprice'] = $option['option_sellprice'];
                            $product['dcprice'] = $option['option_dcprice'];
                            $product['add_price'] = $option['option_add_price'];
                            $product['discount_amount'] = $option['option_discount_amount'];
                            $product['discount_rate'] = $option['option_discount_rate'];
                            $product['discountList'] = $option['optionDiscountList'];
                            $product['option_etc1'] = $option['option_etc1'] ?? '';
                            $product['stock'] = $option['option_stock'];
                            $product['weight'] = $option['weight'];
                        }

                        // 재고를 체크하여 상품 판매 상태 변경
                        if ($product['status'] == 'sale' && $product['stock'] <= 0) {
                            $product['status'] = 'soldout';
                        }

                        // 코디/세트 상품?
                        if ($product['option_kind'] == 's2' || $product['option_kind'] == 'c') {
                            $setData = $this->getCartSetData($product['set_group']);
                            $buyerPcnt = $setData['pcount'];
                        } else {
                            $buyerPcnt = $product['pcount'];
                        }
                        $companySumPaymentPrice += $buyerPcnt;
                        // 할인 정보 * 수량 처리
                        $product['discount_amount'] = $product['discount_amount'] * $buyerPcnt;

                        // Loop start 1-1-1
                        foreach ($product['discountList'] as $discountKey => $discount) {
                            if (isset($discount['discount_amount'])) {
                                $discount['discount_amount'] = $discount['discount_amount'] * $buyerPcnt;
                            }
                            if (isset($discount['headoffice_discount_amount'])) {
                                $discount['headoffice_discount_amount'] = $discount['headoffice_discount_amount'] * $buyerPcnt;
                            }
                            if (isset($discount['seller_discount_amount'])) {
                                $discount['seller_discount_amount'] = $discount['seller_discount_amount'] * $buyerPcnt;
                            }
                            $product['discountList'][$discountKey] = $discount;

                            if ($discount['type'] == 'MG') {
                                $companySumDiscountMem += $discount['discount_amount'];
                            } else if ($discount['type'] == 'GP' || $discount['type'] == 'SP') {
                                $companySumDiscountSpecial += $discount['discount_amount'];
                            }

                        }

                        $product['total_listprice'] = $product['listprice'] * $buyerPcnt;
                        $product['total_dcprice'] = $product['dcprice'] * $buyerPcnt;
                        $product['total_ptprice'] = $product['sellprice'] * $buyerPcnt;

                        //추가 구성 상품 Loop start 1.1.2
                        foreach ($product['addOptionList'] as $addOptionKey => $addOption) {
                            $option = $productModel->getOption($product['id'], 'row', $addOption['opn_d_ix']);
                            $addOption['listprice'] = $option['option_listprice'];
                            $addOption['sellprice'] = $option['option_sellprice'];
                            $addOption['dcprice'] = $option['option_dcprice'];
                            $addOption['total_listprice'] = $addOption['listprice'] * $addOption['opn_count'];
                            $addOption['total_sellprice'] = $addOption['sellprice'] * $addOption['opn_count'];
                            $addOption['total_dcprice'] = $addOption['dcprice'] * $addOption['opn_count'];

                            //추가 구성 상품 재고
                            $addOption['stock'] = $option['option_stock'];

                            //적립 마일리지 처리
                            if (isset($productModel->categoryReserveYn[$product['id']]) && $productModel->categoryReserveYn[$product['id']] == true) {
                                $addOption['mileage'] = 0;
                            } else {
                                $addOption['mileage'] = $mileageModel->getSaveMileage($product['reserve_yn'], $product['rate_type'],
                                    $product['reserve_rate']
                                    , $product['admin'], $addOption['total_listprice'], $addOption['total_dcprice'], $addOption['total_dcprice']);
                            }
                            $companySumMileagePrice += $addOption['mileage'];

                            $deliverySumProductListprice += $addOption['total_dcprice'];
                            $deliverySumProductSellprice += $addOption['total_sellprice'];
                            $deliverySumProductCouponWithDcprice += $addOption['total_dcprice'];
                            $deliverySumProductDcprice += $addOption['total_dcprice'];
                            $deliverySumProductQty += $addOption['opn_count'];

                            $product['addOptionList'][$addOptionKey] = $addOption;
                        }
                        //추가 구성 상품 Loop end
                        //쿠폰 사용 처리
                        $registIx = ($useCoupon[$product['cart_ix']] ?? 0);
                        if ($registIx > 0) {
                            $couponData = $couponModel->applyProductCoupon($registIx, $product['id'], $product['dcprice'], $product['total_dcprice']);
                            if ($couponData === false) {
                                $totalCouponWithDcprice = $product['total_dcprice'];
                                $cartOverlapUseYn = 'Y';
                            } else {
                                $couponData['type'] = 'CP';
                                $couponData['title'] = ForbizConfig::getDiscount('CP');
                                array_push($product['discountList'], $couponData);
                                $totalCouponWithDcprice = $product['total_dcprice'] - $couponData['discount_amount'];
                                $cartOverlapUseYn = $couponData['cartOverlapUseYn'];
                            }
                        } else {
                            $totalCouponWithDcprice = $product['total_dcprice'];
                            $cartOverlapUseYn = 'Y';
                        }
                        $product['cartOverlapUseYn'] = $cartOverlapUseYn;

                        //세트 상품 쿠폰 처리
                        if ($setProductCouponData !== false && !empty($setProductCouponData[$product['set_group']])) {

                            $_setProductCouponData = $setProductCouponData[$product['set_group']];

                            if ($setProductCouponData[$product['set_group']]['last_cart_ix'] == $product['cart_ix']) {
                                $_setProductCouponData['discount_amount'] = f_decimal($_setProductCouponData['discount_amount']) - f_decimal($setProductCouponData[$product['set_group']]['sum_discount_amount']);
                                $_setProductCouponData['headoffice_discount_amount'] = f_decimal($_setProductCouponData['headoffice_discount_amount']) - f_decimal($setProductCouponData[$product['set_group']]['sum_headoffice_discount_amount']);
                                $_setProductCouponData['seller_discount_amount'] = $_setProductCouponData['discount_amount'] - $_setProductCouponData['headoffice_discount_amount'];
                            } else {
                                $_setProductCouponData['discount_amount'] = f_decimal($_setProductCouponData['discount_amount']
                                    * $product['total_dcprice'] / $_setProductCouponData['total_product_dcprice'])->round((defined('BCSCALE') ? BCSCALE : 0));
                                $_setProductCouponData['headoffice_discount_amount'] = f_decimal($_setProductCouponData['headoffice_discount_amount']
                                    * $product['total_dcprice'] / $_setProductCouponData['total_product_dcprice'])->round((defined('BCSCALE') ? BCSCALE : 0));
                                $_setProductCouponData['seller_discount_amount'] = $_setProductCouponData['discount_amount']
                                    - $_setProductCouponData['headoffice_discount_amount'];
                                $setProductCouponData[$product['set_group']]['sum_discount_amount'] += $_setProductCouponData['discount_amount'];
                                $setProductCouponData[$product['set_group']]['sum_headoffice_discount_amount'] += $_setProductCouponData['headoffice_discount_amount'];
                            }
                            unset($_setProductCouponData['last_cart_ix']);
                            unset($_setProductCouponData['total_product_dcprice']);
                            unset($_setProductCouponData['sum_discount_amount']);
                            unset($_setProductCouponData['sum_headoffice_discount_amount']);
                            array_push($product['discountList'], $_setProductCouponData);
                            $totalCouponWithDcprice = $product['total_dcprice'] - $_setProductCouponData['discount_amount'];
                        }

                        //장바구니 쿠폰 처리
                        if ($cartCouponData !== false
                            && $totalCouponWithDcprice > 0
                            && in_array($product['id'], $cartCouponData['permitPid'])
                        ) {
                            $_cartCouponData = $cartCouponData;
                            if ($cartCouponData['last_cart_ix'] == $product['cart_ix']) {
                                $_cartCouponData['discount_amount'] = f_decimal($_cartCouponData['discount_amount']) - f_decimal($cartCouponData['sum_discount_amount']);
                                $_cartCouponData['headoffice_discount_amount'] = f_decimal($_cartCouponData['headoffice_discount_amount']) - f_decimal($cartCouponData['sum_headoffice_discount_amount']);
                                $_cartCouponData['seller_discount_amount'] = $_cartCouponData['discount_amount'] - $_cartCouponData['headoffice_discount_amount'];
                            } else {
                                $_cartCouponData['discount_amount'] = f_decimal($_cartCouponData['discount_amount'] * $totalCouponWithDcprice
                                    / $_cartCouponData['total_product_dcprice'])->round((defined('BCSCALE') ? BCSCALE : 0));
                                $_cartCouponData['headoffice_discount_amount'] = f_decimal($_cartCouponData['headoffice_discount_amount'] * $totalCouponWithDcprice
                                    / $_cartCouponData['total_product_dcprice'])->round((defined('BCSCALE') ? BCSCALE : 0));
                                $_cartCouponData['seller_discount_amount'] = $_cartCouponData['discount_amount'] - $_cartCouponData['headoffice_discount_amount'];
                                $cartCouponData['sum_discount_amount'] += $_cartCouponData['discount_amount'];
                                $cartCouponData['sum_headoffice_discount_amount'] += $_cartCouponData['headoffice_discount_amount'];
                            }
                            unset($_cartCouponData['last_cart_ix']);
                            unset($_cartCouponData['total_product_dcprice']);
                            unset($_cartCouponData['sum_discount_amount']);
                            unset($_cartCouponData['sum_headoffice_discount_amount']);
                            array_push($product['discountList'], $_cartCouponData);
                            $totalCouponWithDcprice = $totalCouponWithDcprice - $_cartCouponData['discount_amount'];
                        }



                        //쿠폰할인 포함된 가격
                        $product['total_coupon_with_dcprice'] = $totalCouponWithDcprice;

                        //적립 마일리지 처리

                        if (isset($productModel->categoryReserveYn[$product['id']]) && $productModel->categoryReserveYn[$product['id']] == true) {
                            $product['mileage'] = 0;
                        } else {
                            $product['mileage'] = $mileageModel->getSaveMileage($product['reserve_yn'], $product['rate_type'],
                                $product['reserve_rate']
                                , $product['admin'], $product['total_listprice'], $product['total_dcprice'], $product['total_coupon_with_dcprice']);
                        }

                        $companySumMileagePrice += $product['mileage'];
                        if ($product['status'] == 'sale') {
                            $deliverySumProductListprice += $product['total_listprice'];
                            $deliverySumProductSellprice += $product['total_ptprice'];
                            $deliverySumProductDcprice += $product['total_dcprice'];
                            $deliverySumProductCouponWithDcprice += $product['total_coupon_with_dcprice'];
                            //세트/코디상품인가?
                            if ($product['option_kind'] == 's2' || $product['option_kind'] == 'c') {
                                //세트/코디상품
                                if (!isset($setGroupDelivery[$product['set_group']])) {
                                    $deliverySumProductQty = $buyerPcnt;
                                }
                            } else {
                                $deliverySumProductQty += $buyerPcnt;
                            }
                            $buyerWeight = (($product['weight'] ?: 0) * $buyerPcnt);
                            $deliverySumProductWeight += $buyerWeight;
                        }
/*print_r($list['cart_ix']);
echo "<hr>";*/
                        #사은품 정보 체크
                        $product['giftItem'] = $this->getGiftItem($list['cart_ix']);
                        $product['giftItemExists'] = $this->getGiftItemNoSelect($list['cart_ix']);

                        $deliveryTemplate['productList'][$key] = $product;


                    }

                    //상품 Loop end

                    //배송비
                    $deliveryInfo = $this->getDeliveryInfo($deliveryTemplate['dt_ix'],
                        ['price' => $deliverySumProductDcprice, 'qty' => $deliverySumProductQty, 'weight' => $deliverySumProductWeight], $zipCode);



                    $deliveryTemplate['org_total_delivery_price'] = $deliveryInfo['sumPrice'];
                    $deliveryTemplate['total_delivery_price'] = $deliveryInfo['sumPrice'];
                    $deliveryTemplate['delivery_price'] = $deliveryInfo['price'];
                    $deliveryTemplate['delivery_add_price'] = $deliveryInfo['addPrice'];
                    $deliveryTemplate['delivery_text'] = $deliveryInfo['text'] . (!empty($deliveryInfo['regionText']) ? " (" . $deliveryInfo['regionText'] . ")"
                            : "");

                    //배송비 쿠폰 처리
                    if ($deliveryCouponData !== false && $deliveryTemplate['delivery_price'] > 0 ) {

                        $data['deliveryCoupon'] = $deliveryCouponData;
                        $deliveryTemplate['total_delivery_price'] = $deliveryTemplate['total_delivery_price'] - $deliveryCouponData['discount_amount'];
                        $deliveryTemplate['delivery_price'] = $deliveryTemplate['delivery_price'] - $deliveryCouponData['discount_amount'];
                    }

                    $data['deliveryTemplateList'][$deliveryTemplateKey] = $deliveryTemplate;

                    //업체별 금액 합산을 위한 계산
                    $companySumProductListprice += $deliverySumProductListprice;
                    $companySumProductSellprice += $deliverySumProductSellprice;
                    $companySumProductDcprice += $deliverySumProductCouponWithDcprice;


                    // 판매 중인 상품에 대해서만 배송비 추가
                    $companySumOrgTotalDeliveryPrice += $deliveryTemplate['org_total_delivery_price'];
                    $companySumTotalDeliveryPrice += $deliveryTemplate['total_delivery_price'];
                    $companySumDeliveryPrice += $deliveryTemplate['delivery_price'];
                    $companySumDeliveryAddPrice += $deliveryTemplate['delivery_add_price'];
                }
                // LOOP 1. 배송정책 Loop end

                //배송비 쿠폰 처리
//                if ($deliveryCouponData !== false && $companySumDeliveryPrice > 0 ) {
//                    $data['deliveryCoupon'] = $deliveryCouponData;
//                    $companySumDeliveryPrice = $companySumDeliveryPrice - $deliveryCouponData['discount_amount'];
//                    $companySumTotalDeliveryPrice = $companySumTotalDeliveryPrice - $deliveryCouponData['discount_amount'];
//                }



                $data['product_listprice'] = $companySumProductListprice;
                $data['product_sellprice'] = $companySumProductSellprice;
                $data['product_dcprice'] = $companySumProductDcprice;
                $data['product_discount_amount'] = $data['product_listprice'] - $data['product_dcprice'];
                $data['product_basic_discount_amount'] = $data['product_listprice'] - $data['product_sellprice'] + $companySumDiscountSpecial;
                $data['product_mem_discount_amount'] = $companySumDiscountMem;
                $data['product_Special_discount_amount'] = $companySumDiscountSpecial;
                $data['org_total_delivery_price'] = $companySumOrgTotalDeliveryPrice;
                $data['total_delivery_price'] = $companySumTotalDeliveryPrice;
                $data['delivery_price'] = $companySumDeliveryPrice;
                $data['delivery_add_price'] = $companySumDeliveryAddPrice;
                $data['payment_price'] = $data['product_dcprice'] + $data['total_delivery_price'];
                $data['product_total_count'] = $companySumPaymentPrice;
                $data['companySumMileagePrice'] = $companySumMileagePrice;
                $cartData[$cartDataKey] = $data;
            }
            //업체 Loop end

            $productModel->setDiscoutMemberGroupCalculationYn('N');
        }

        return $cartData;
    }

    /**
     * 배송비 정보
     * 배럴 회원 그룹 별 부료 배송 확인
     * @param int $dtIx
     * @param array $productData
     * @param string $zipCode
     * @return array
     */
    public function getDeliveryInfo($dtIx, $productData = [], $zipCode = '')
    {
        if (!is_array($productData)) {
            $productData = [];
        }
        $productPrice = f_decimal($productData['price'] ?? 0);
        $productQty = ($productData['qty'] ?? 1);
        $productWeight = ($productData['weight'] ?? 0);

        $deliveryPrice = f_decimal(0);
        $addDeliveryPrice = f_decimal(0);
        $conditionText = "";
        $regionText = "";

        if (MALL_IX == '20bd04dac38084b2bafdd6d78cd596b2') {
            //해외
            /* @var $globalModel CustomMallGlobalModel */
            $globalModel = $this->import('model.mall.global');
            $deliveryPrice = $globalModel->exchangePrice($this->getEmsPrice($productWeight));
            $conditionText = 'EMS';
            $regionText = '';
            $deliveryClaimText = '';
            $template = [
                'delivery_policy' => '0'
                , 'delivery_region_use' => '0'
                , 'tekbae_ix' => '0'
                , 'company_id' => 'bb9d15b603ea947966f617bab0524851'
            ];

            $deliveryCompany = [
                'code_name' => 'EMS'
            ];
        } else {
            //국내
            $template = $this->qb
                ->select('delivery_policy')
                ->select('delivery_price')
                ->select('delivery_cnt_price')
                ->select('free_shipping_term')
                ->select('delivery_unit_price')
                ->select('delivery_region_use')
                ->select('delivery_region_area')
                ->select('delivery_jeju_price')
                ->select('delivery_except_price')
                ->select('delivery_region_use')
                ->select('company_id')
                ->select('delivery_policy_text_m')
                ->select('delivery_policy_text')
                ->select('tekbae_ix')
                ->from(TBL_SHOP_DELIVERY_TEMPLATE)
                ->where('dt_ix', $dtIx)
                ->exec()->getRowArray();

            //회원별 무료 배송 정책 사용시
            if ($this->shippingFreeYn == 'Y') {
                $template['delivery_policy'] = '1';
            }

            switch ($template['delivery_policy']) {
                //무료배송
                case '1':
                    $conditionText = "무료배송";
                    break;
                //고정 배송비
                case '2':
                    $deliveryPrice = f_decimal($template['delivery_price']);
                    $conditionText = "배송비 " . g_price($deliveryPrice) . "원";
                    break;
                //결제금액당 배송비
                case '3':
                    //수량별 할인/할증적용(상품단위)
                case '4':
                    $this->qb
                        ->select('delivery_price')
                        ->select('delivery_basic_terms')
                        ->from(TBL_SHOP_DELIVERY_TERMS)
                        ->where('dt_ix', $dtIx)
                        ->where('delivery_policy_type', $template['delivery_policy']);

                    $basicDeliveryPrice = 0;
                    $conditionDeliveryPrice = false;
                    switch ($template['delivery_policy']) {
                        //결제금액당 배송비
                        case '3':
                            $row = $this->qb
                                ->exec()->getRowArray();
                            if (!empty($row)) {
                                if ($row['delivery_basic_terms'] > $productPrice && $conditionDeliveryPrice === false) {
                                    $conditionDeliveryPrice = $row['delivery_price'];
                                }
                                $conditionText = g_price($row['delivery_basic_terms']) . "원 이상 구매 시 무료배송";
                            }
                            break;
                        //수량별 할인/할증적용(상품단위)
                        case '4':
                            $basicDeliveryPrice = $template['delivery_cnt_price'];

                            $rows = $this->qb
                                ->orderBy('delivery_basic_terms', 'desc')
                                ->exec()->getResultArray();

                            if (!empty($rows)) {
                                $conditionTextList = [];
                                foreach ($rows as $key => $row) {
                                    if ($row['delivery_basic_terms'] <= $productQty && $conditionDeliveryPrice === false) {
                                        $conditionDeliveryPrice = $row['delivery_price'];
                                    }
                                    $conditionTextList[] = number_format($row['delivery_basic_terms']) . "개 이상 " . g_price($row['delivery_price']) . "원";
                                }
                                $conditionText = "기본 배송비 " . g_price($basicDeliveryPrice) . "원 / " . implode(", ", $conditionTextList);
                            }
                            break;
                    }
                    $deliveryPrice = f_decimal($conditionDeliveryPrice !== false ? $conditionDeliveryPrice : $basicDeliveryPrice);
                    break;
                //상품 1개단위 배송비
                case '6':
                    $deliveryPrice = f_decimal($template['delivery_unit_price'] * $productQty);
                    $conditionText = "1개당 배송비 " . g_price($template['delivery_unit_price']) . "원";
                    break;
                default :
                    break;
            }


            //추가 배송비
            if ($template['delivery_region_use'] == '1') {

                if ($template['delivery_region_area'] == '2') {
                    $regionText = "제주 및 도서산간 " . g_price($template['delivery_jeju_price']) . "원 추가";
                } else if ($template['delivery_region_area'] == '3') {
                    $regionText = "제주 " . g_price($template['delivery_jeju_price']) . "원 / 제주 외 도서산간 " . g_price($template['delivery_except_price']) . "원 추가";
                }

                if (!empty($zipCode)) {
                    $region = $this->qb
                        ->select('price')
                        ->from(TBL_SHOP_ADD_DELIVERY_AREA)
                        ->where('zip', $zipCode)
                        ->exec()->getRowArray();

                    if (!empty($region)) {
                        //권역 사라지고 고정배송비
                        $addDeliveryPrice = $region['price'];
                        /*//2권역
                        if ($template['delivery_region_area'] == '2') {
                            $addDeliveryPrice = (!empty($template['delivery_jeju_price']) ? $template['delivery_jeju_price'] : 0);
                        } //3권역
                        else if ($template['delivery_region_area'] == '3') {
                            if ($region['jeju_yn'] == 'Y') {
                                $addDeliveryPrice = (!empty($template['delivery_jeju_price']) ? $template['delivery_jeju_price'] : 0);
                            } else {
                                $addDeliveryPrice = (!empty($template['delivery_except_price']) ? $template['delivery_except_price'] : 0);
                            }
                        }*/
                    }
                }
            }

            //교환/반품안내
            if (is_mobile()) {
                $deliveryClaimText = $template['delivery_policy_text_m'];
            } else {
                $deliveryClaimText = $template['delivery_policy_text'];
            }

            //택배사명
            $deliveryCompany = $this->qb
                ->select('c.code_name')
                ->from(TBL_SHOP_DELIVERY_TEMPLATE . ' as t')
                ->join(TBL_SHOP_CODE . ' as c', 't.tekbae_ix=c.code_ix', 'inner')
                ->where('t.dt_ix', $dtIx)
                ->where('c.code_gubun', '02')
                ->exec()->getRowArray();
        }

        return ['sumPrice' => ($deliveryPrice + $addDeliveryPrice)
            , 'price' => $deliveryPrice
            , 'addPrice' => $addDeliveryPrice
            , 'text' => $conditionText
            , 'regionText' => $regionText
            , 'deliveryPolicy' => $template['delivery_policy']
            , 'deliveryRegionUse' => $template['delivery_region_use']
            , 'deliveryClaimText' => $deliveryClaimText
            , 'deliveryComCode' => $template['tekbae_ix']
            , 'deliveryComName' => $deliveryCompany['code_name']
            , 'company_id' => $template['company_id']
        ];
    }

    /**
     * 무개당 EMS 배송비 가격
     * @param $weight
     * @return mixed
     */
    protected function getEmsPrice($weight)
    {
        $list = [
            "0.50" => "26500"
            , "0.75" => "30000"
            , "1.00" => "33500"
            , "1.25" => "37000"
            , "1.50" => "40500"
            , "1.75" => "44000"
            , "2.00" => "47500"
            , "2.50" => "54500"
            , "3.00" => "61000"
            , "3.50" => "68000"
            , "4.00" => "74500"
            , "4.50" => "81500"
            , "5.00" => "88000"
            , "5.50" => "95000"
            , "6.00" => "102000"
            , "6.50" => "108500"
            , "7.00" => "115500"
            , "7.50" => "122000"
            , "8.00" => "129000"
            , "8.50" => "135500"
            , "9.00" => "142500"
            , "9.50" => "149500"
            , "10.00" => "156000"
            , "10.50" => "163000"
            , "11.00" => "169500"
            , "11.50" => "176500"
            , "12.00" => "183500"
            , "12.50" => "190000"
            , "13.00" => "197000"
            , "13.50" => "203500"
            , "14.00" => "210500"
            , "14.50" => "217000"
            , "15.00" => "224000"
            , "15.50" => "231000"
            , "16.00" => "237500"
            , "16.50" => "244500"
            , "17.00" => "251000"
            , "17.50" => "258000"
            , "18.00" => "264500"
            , "18.50" => "271500"
            , "19.00" => "278500"
            , "19.50" => "285000"
            , "20.00" => "292000"
            , "20.50" => "298500"
            , "21.00" => "305500"
            , "21.50" => "312000"
            , "22.00" => "319000"
            , "22.50" => "326000"
            , "23.00" => "332500"
            , "23.50" => "339500"
            , "24.00" => "346000"
            , "24.50" => "353000"
            , "25.00" => "360000"
            , "25.50" => "366500"
            , "26.00" => "373500"
            , "26.50" => "380000"
            , "27.00" => "387000"
            , "27.50" => "393500"
            , "28.00" => "400500"
            , "28.50" => "407500"
            , "29.00" => "414000"
            , "29.50" => "421000"
            , "30.00" => "427500"
        ];

        foreach ($list AS $_weight => $_price) {
            if ($_weight >= $weight) {
                $price = $_price;
                break;
            }
        }
        return $price;
    }

    /**
     * 세트 상품 정보 조회
     * @param int $shop_cart_set_id
     * @return array
     */
    protected function getCartSetData($shop_cart_set_id)
    {
        $row = $this->qb
            ->setDatabase('payment')
            ->select('pcount')
            ->select('opn_d_ix')
            ->from(TBL_SHOP_CART_SET)
            ->where('shop_cart_set_id', $shop_cart_set_id)
            ->exec()
            ->getRowArray();

        return $row;
    }

    /**
     * 세트 상품 정보 변환
     * @param array $list
     * @return array
     */
    protected function cvtCartSetList($list)
    {
        $setList = [];
        foreach ($list as $li) {
            if ($li['set_group'] > 0) {
                if (isset($setList[$li['set_group']]['cart_ix'])) {
                    $setList[$li['set_group']]['cart_ix'] .= (',' . $li['cart_ix']);
                } else {
                    // 세트 상품 재고 및 주문 수량 조회
                    $cartSetData = $this->getCartSetData($li['set_group']);

                    // 세트상품, 코디상품 구분
                    $opn_d_ix = $cartSetData['opn_d_ix'] ? $cartSetData['opn_d_ix'] : 'codi';

                    // 세트 상품 정보 설정
                    $setList[$li['set_group']]['cart_ix'] = $li['cart_ix'];
                    $setList[$li['set_group']]['id'] = $li['id'];
                    $setList[$li['set_group']]['select_option_id'] = $opn_d_ix;
                    $setList[$li['set_group']]['set_group'] = $li['set_group'];
                    $setList[$li['set_group']]['pcount'] = $cartSetData['pcount'];
                    $setList[$li['set_group']]['options_text'] = '';
                    $setList[$li['set_group']]['dt_ix'] = $li['dt_ix'];
                    $setList[$li['set_group']]['hash_idx'] = $li['hash_idx'];
                    $setList[$li['set_group']]['allow_basic_cnt'] = $li['allow_basic_cnt'];
                    $setList[$li['set_group']]['allow_max_cnt'] = $li['allow_max_cnt'];
                    $setList[$li['set_group']]['allow_byoneperson_cnt'] = $li['allow_byoneperson_cnt'];
                }

                $setList[$li['set_group']]['setData'][] = [
                    'options_text' => $li['options_text']
                    , 'optionId' => $li['select_option_id']
                    , 'pcount' => $li['pcount']
                ];
            }
        }

        $newList = [];
        $chkList = [];
        foreach ($list as $li) {
            if (isset($setList[$li['set_group']])) {
                if (!isset($chkList[$li['set_group']])) {
                    $newList[] = $setList[$li['set_group']];
                    $chkList[$li['set_group']] = true;
                }
            } else {
                $newList[] = $li;
            }
        }

        return $newList;
    }

    /**
     * get 업체-배송정책-상품-옵션(추가구성상품)별 정보
     * get 함수의 기본 뼈대 정보 리턴
     * @param array $cartIxs 카트ID
     * @return array
     */
    protected function getGroupByDeliveryCompany($cartIxs, $isOrder = false)
    {
        //장바구니 정보 및 배송정책 조회
        $this->qb->setDatabase('payment');
        if (MALL_IX == '20bd04dac38084b2bafdd6d78cd596b2') {
            //해외는 무조껀 하나의 정책으로 처리 필요
            $this->qb->select('2 AS dt_ix');
        } else {
            $this->qb->select('pd.dt_ix');
        }

        $this->userWhere()
            ->select('c.cart_ix')
            ->select('c.id')
            ->select('c.set_group')
            ->select('c.select_option_id')
            ->select('c.options_text')
            ->select('c.pcount')
            ->select('c.hash_idx')
            ->select('c.choice_gift')
            ->select('p.allow_basic_cnt')
            ->select('p.allow_max_cnt')
            ->select('p.allow_byoneperson_cnt')
            ->from(TBL_SHOP_CART . ' as c')
            ->join(TBL_SHOP_PRODUCT_DELIVERY . ' as pd', 'c.id = pd.pid')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'p.id = c.id')
            ->where('pd.is_wholesale', $this->sellingType)
            ->where('p.state != ', 2)
            ->where('p.disp = ', 1)
            ->where("if(p.is_sell_date = '1',p.sell_priod_sdate <= '" . date('Y-m-d H:i:s') . "' and p.sell_priod_edate >= '" . date('Y:m:d H:i:s') . "','1=1')", '', false)
            ->orderBy('c.cart_ix', 'ASC')
            ->orderBy('c.regdate', 'DESC');

        //카트ID 있음?
        if (!empty($cartIxs)) {
            foreach ($cartIxs as $cartIxKey => $cartIx) {
                if (substr_count($cartIx, ',')) {
                    $_cartIxs = explode(',', $cartIx);
                    foreach ($_cartIxs as $_cartIxKey => $_cartIx) {
                        if ($_cartIxKey == 0) {
                            $cartIxs[$cartIxKey] = $_cartIx;
                        } else {
                            $cartIxs[] = $_cartIx;
                        }
                    }
                }
            }

            $this->qb->whereIn('c.cart_ix', $cartIxs);
        }

        $list = $this->qb
            ->exec()
            ->getResultArray(); //리턴은 array로


        if (empty($list)) {
            return [];
        }

        // 주문에서 조회하는가?
        if ($isOrder === false) {
            // 세트상품 변환
            $list = $this->cvtCartSetList($list);
        }

        //templetList = [ dt_ix => [ cart_ix, id, select_option_id, pcount, options_text ] ];
        $templetList = [];
        $cartIxs = [];
        foreach ($list as $li) {
            if (empty($templetList[$li['dt_ix']])) {
                $templetList[$li['dt_ix']] = [];
            }
            //혹시 모르는 중복 값이 있을 수 있음
            if (array_search($li['cart_ix'], array_column($templetList[$li['dt_ix']], 'cart_ix')) === false) {

                if ($li['allow_byoneperson_cnt'] > 0) {
                    if (!empty($this->userInfo->code)) {
                        //회원 구매 수량
                        $row = $this->qb
                            ->selectSum('od.pcnt')
                            ->select('od.product_type')
                            ->select($this->qb->startSubQuery('pcount')
                                ->selectSum('pcount')
                                ->from(TBL_SHOP_ORDER_SET)
                                ->where('oid', 'o.oid', false)
                                ->where('shop_order_set_id', 'od.set_group', false)
                                ->endSubQuery(), false)
                            ->from(TBL_SHOP_ORDER.' as o')
                            ->join(TBL_SHOP_ORDER_DETAIL.' as od', 'o.oid=od.oid')
                            ->where('od.pid', $li['id'])
                            ->where('o.user_code', $this->userInfo->code)
                            ->whereNotIn('od.status',
                                [ORDER_STATUS_SETTLE_READY, ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE, ORDER_STATUS_CANCEL_COMPLETE, ORDER_STATUS_RETURN_COMPLETE])
                            ->exec()->getRowArray();

                        if (!empty($row) && !empty($row['pcnt'])) {
                            if($row['product_type'] == '99'){
                                $userBuyCnt = $row['pcount'];
                            }else{
                                $userBuyCnt = $row['pcnt'];
                            }

                        }
                    } else {
                        //비회원은 구매 할수 없도록
                        $userBuyCnt = $li['allow_byoneperson_cnt'];
                    }
                }

                $templetList[$li['dt_ix']][] = [
                    'cart_ix' => $li['cart_ix']
                    , 'id' => $li['id']
                    , 'choice_gift' => ($li['choice_gift'] ?? '')
                    , 'select_option_id' => ($li['select_option_id'] ?? '')
                    , 'pcount' => $li['pcount']
                    , 'options_text' => $li['options_text']
                    , 'hash_idx' => $li['hash_idx']
                    , 'set_group' => $li['set_group'] // 세트 상품 그룹
                    , 'setData' => ($li['setData'] ?? '') // 세트 상품 옵션 정보
                    , 'allow_basic_cnt' => ($li['allow_basic_cnt'] ?? '') // 세트 상품 옵션 정보
                    , 'allow_max_cnt' => ($li['allow_max_cnt'] ?? '') // 세트 상품 옵션 정보
                    , 'allow_byoneperson_cnt' => ($li['allow_byoneperson_cnt'] ?? '') // 세트 상품 옵션 정보
                    , 'user_buy_cnt' => ($userBuyCnt ?? '') // 세트 상품 옵션 정보
                ];

                $cartIxs[] = $li['cart_ix'];
            }
        }
        unset($list);

        //추가 구성 상품 조회
        $cartAddOption = $this->qb
            ->setDatabase('payment')
            ->select('cart_option_ix')
            ->select('cart_ix')
            ->select('opn_d_ix')
            ->select('opn_count')
            ->select('opn_text')
            ->from(TBL_SHOP_CART_OPTIONS)
            ->whereIn('cart_ix', $cartIxs)
            ->exec()->getResultArray();

        //cartAddOptionList = [ cart_ix => [ cart_option_ix, opn_d_ix, opn_count, opn_text ] ];
        $cartAddOptionList = [];
        foreach ($cartAddOption as $cao) {
            $cartAddOptionList[$cao['cart_ix']][] = [
                'cart_option_ix' => $cao['cart_option_ix']
                , 'opn_d_ix' => $cao['opn_d_ix']
                , 'opn_count' => $cao['opn_count']
                , 'opn_text' => $cao['opn_text']
            ];

            $cartIxs[] = $li['cart_ix'];
        }

        //묶음 배송 처리
        $deliveryGroup = $this->getDeliveryGroup(array_keys($templetList));

        //묶음 배송을 사용하는 dt_ix 는 target_dt_ix 로 변경
        foreach ($deliveryGroup as $dg) {
            $templetList[$dg['target_dt_ix']] = array_merge(($templetList[$dg['target_dt_ix']] ?? []), $templetList[$dg['dt_ix']]);
            unset($templetList[$dg['dt_ix']]);
        }
        unset($deliveryGroup);

        //업체 별 조회
        $list = $this->qb
            ->select('cd.company_id')
            ->select('cd.com_name')
            ->select('dt.dt_ix')
            ->from(TBL_SHOP_DELIVERY_TEMPLATE . ' as dt')
            ->join(TBL_COMMON_COMPANY_DETAIL . ' as cd', 'dt.company_id = cd.company_id')
            ->whereIn('dt.dt_ix', array_keys($templetList))
            ->exec()->getResultArray();

        if (empty($list)) {
            return [];
        }

        //deliveryCompanyList = [ company_id => [ com_name, dt_ix=[] ] ];
        $deliveryCompanyList = [];
        foreach ($list as $li) {
            if (empty($deliveryCompanyList[$li['company_id']])) {
                $deliveryCompanyList[$li['company_id']]['com_name'] = $li['com_name'];
                $deliveryCompanyList[$li['company_id']]['dt_ix'] = [];
            }
            //혹시 모르는 중복 값이 있을 수 있음
            if (!in_array($li['dt_ix'], $deliveryCompanyList[$li['company_id']]['dt_ix'])) {
                $deliveryCompanyList[$li['company_id']]['dt_ix'][] = $li['dt_ix'];
            }
        }

        //최종 결과 데이터 만들기
        $result = [];
        foreach ($deliveryCompanyList as $companyId => $deliveryCompany) {

            $deliveryTemplateList = [];
            foreach ($deliveryCompany['dt_ix'] as $key => $dtIx) {

                foreach ($templetList[$dtIx] as $templetKey => $templet) {
                    if (!empty($cartAddOptionList[$templet['cart_ix']])) {
                        $templetList[$dtIx][$templetKey]['addOptionList'] = $cartAddOptionList[$templet['cart_ix']];
                    } else {
                        $templetList[$dtIx][$templetKey]['addOptionList'] = array();
                    }
                }

                $deliveryTemplateList[$key]['dt_ix'] = $dtIx;
                $deliveryTemplateList[$key]['productList'] = $templetList[$dtIx];
            }

            $result[] = [
                'company_id' => $companyId
                , 'com_name' => $deliveryCompany['com_name']
                , 'deliveryTemplateList' => $deliveryTemplateList
            ];
        }

        return $result;
    }

    /**
     * 카트의 세트 상품 주문 수량 수정
     * @param string $cartIx 장바구니ID
     * @param int $count 수량
     * @param int $shop_cart_set_id 카트세트상품ID
     */
    public function updateCartSetCount($cartIx, $count, $shop_cart_set_id)
    {
        // 세트상품별 구성 수량 조회
        $rows = $this->userWhere()
            ->select('c.cart_ix')
            ->select('c.select_option_id')
            ->select('o.option_etc1')
            ->from(TBL_SHOP_CART . ' AS c')
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS o', 'c.select_option_id = o.id')
            ->whereIn('cart_ix', $cartIx)
            ->exec()
            ->getResultArray();

        if (!empty($rows)) {
            // 세트상품 수량 수정
            $this->qb
                ->set('pcount', $count)
                ->where('shop_cart_set_id', $shop_cart_set_id)
                ->update(TBL_SHOP_CART_SET)
                ->exec();

            // 카트에 담긴 세트상품별 수량 수정
            foreach ($rows as $row) {
                $this->userWhere()
                    ->set('pcount', $row['option_etc1'] * $count)
                    ->where('cart_ix', $row['cart_ix'])
                    ->update(TBL_SHOP_CART . ' as c')
                    ->exec();
            }
        }
    }

    /**
     * 삭제
     * @param array $cartIxs
     */
    public function delete($cartIxs = [])
    {
        $newCartIxs = [];
        // 장바구니에 담긴 세트상품 카트ID 추출
        foreach ($cartIxs as $cartIx) {
            if (strstr($cartIx, ',')) {
                $cArr = explode(',', $cartIx);
                $newCartIxs = array_merge($newCartIxs, $cArr);
            } else {
                $newCartIxs[] = $cartIx;
            }
        }

        // 장바구니 ID
        $cartIxs = $newCartIxs;

        // 장바구니 조회
        $rows = $this->userWhere()
            ->select('cart_ix')
            ->from(TBL_SHOP_CART . ' as c')
            ->whereIn('cart_ix', $cartIxs)
            ->exec()
            ->getResultArray();

        if (!empty($rows)) {
            // 세트상품 삭제
            $this->deleteCartSet($cartIxs);

            $deleteCartIxs = [];
            foreach ($rows as $row) {
                $deleteCartIxs[] = $row['cart_ix'];
            }

            $this->qb->delete(TBL_SHOP_CART)->whereIn('cart_ix', $deleteCartIxs)->exec();
            $this->qb->delete(TBL_SHOP_CART_OPTIONS)->whereIn('cart_ix', $deleteCartIxs)->exec();
            $this->qb->delete(TBL_SHOP_CART_GIFT)->whereIn('cart_ix', $deleteCartIxs)->exec();
        }
    }

    /**
     * 카트 정보 생성
     * @param array $cartData
     * @return array
     */
    public function getSummary($cartData)
    {

        $companySummary = [];
        $summary = [
            'product_listprice' => f_decimal(0)
            , 'product_sellprice' => f_decimal(0)
            , 'product_dcprice' => f_decimal(0)
            , 'product_discount_amount' => f_decimal(0)
            , 'product_basic_discount_amount' => f_decimal(0)
            , 'product_mem_discount_amount' => f_decimal(0)
            , 'product_Special_discount_amount' => f_decimal(0)
            , 'org_total_delivery_price' => f_decimal(0)
            , 'total_delivery_price' => f_decimal(0)
            , 'delivery_price' => f_decimal(0)
            , 'delivery_add_price' => f_decimal(0)
            , 'payment_price' => f_decimal(0)
            , 'tax_price' => f_decimal(0)
            , 'tax_free_price' => f_decimal(0)
            , 'mileage' => f_decimal(0)
            , 'product_total_count' => f_decimal(0)
            , 'companySumMileagePrice' => f_decimal(0)
            , 'productDiscountList' => []
            , 'deliveryDiscountList' => []
        ];

        foreach ($cartData as $company) {
            $companySummary[] = [
                'company_id' => $company['company_id']
                , 'product_listprice' => $company['product_listprice']
                , 'product_sellprice' => $company['product_sellprice']
                , 'product_dcprice' => $company['product_dcprice']
                , 'product_discount_amount' => $company['product_discount_amount']
                , 'product_basic_discount_amount' => $company['product_basic_discount_amount']
                , 'product_mem_discount_amount' => $company['product_mem_discount_amount']
                , 'product_Special_discount_amount' => $company['product_Special_discount_amount']
                , 'org_total_delivery_price' => $company['org_total_delivery_price']
                , 'total_delivery_price' => $company['total_delivery_price']
                , 'delivery_price' => $company['delivery_price']
                , 'delivery_add_price' => $company['delivery_add_price']
                , 'payment_price' => $company['payment_price']
                , 'product_total_count' => $company['product_total_count']
                , 'companySumMileagePrice' => $company['companySumMileagePrice']
            ];

            $summary['product_listprice'] += $company['product_listprice'];
            $summary['product_sellprice'] += $company['product_sellprice'];
            $summary['product_dcprice'] += $company['product_dcprice'];
            $summary['product_discount_amount'] += $company['product_discount_amount'];
            $summary['product_basic_discount_amount'] += $company['product_basic_discount_amount'];
            $summary['product_mem_discount_amount'] += $company['product_mem_discount_amount'];
            $summary['product_Special_discount_amount'] += $company['product_Special_discount_amount'];
            $summary['org_total_delivery_price'] += $company['org_total_delivery_price'];
            $summary['total_delivery_price'] += $company['total_delivery_price'];
            $summary['delivery_price'] += $company['delivery_price'];
            $summary['delivery_add_price'] += $company['delivery_add_price'];
            $summary['payment_price'] += $company['payment_price'];
            $summary['product_total_count'] += $company['product_total_count'];
            $summary['companySumMileagePrice'] += $company['companySumMileagePrice'];

            foreach ($company['deliveryTemplateList'] as $deliveryTemplate) {
                $summary['tax_price'] += $deliveryTemplate['total_delivery_price'];

                foreach ($deliveryTemplate['productList'] as $product) {
                    $summary['mileage'] += $product['mileage'];
                    if ($product['surtax_yorn'] == 'Y') {
                        $summary['tax_free_price'] += $product['total_coupon_with_dcprice'];
                    } else {
                        $summary['tax_price'] += $product['total_coupon_with_dcprice'];
                    }
                    foreach ($product['addOptionList'] as $addOption) {
                        $summary['mileage'] += $addOption['mileage'];
                        $summary['tax_price'] += $addOption['total_dcprice'];
                    }
                    foreach ($product['discountList'] as $discount) {
                        $index = array_search($discount['type'], array_column($summary['productDiscountList'], 'type'));
                        if ($index === false) {
                            $summary['productDiscountList'][] = [
                                'type' => $discount['type']
                                , 'title' => $discount['title']
                                , 'discount_amount' => $discount['discount_amount']
                            ];
                        } else {
                            $summary['productDiscountList'][$index]['discount_amount'] += $discount['discount_amount'];
                        }
                    }
                }
            }
            if(isset($company['deliveryCoupon']) && is_array($company['deliveryCoupon'])) {

                $index = array_search($company['deliveryCoupon']['type'],
                    array_column($summary['deliveryDiscountList'], 'type'));
                if ($index === false) {
                    $summary['deliveryDiscountList'][] = [
                        'type' => $company['deliveryCoupon']['type']
                        ,
                        'title' => $company['deliveryCoupon']['title']
                        ,
                        'discount_amount' => $company['deliveryCoupon']['discount_amount']
                    ];
                } else {
                    $summary['deliveryDiscountList'][$index]['discount_amount'] += $company['deliveryCoupon']['discount_amount'];
                }

            }
        }

        // 배송금액 오류 수정
//        $summary['total_delivery_price'] = $summary['product_dcprice'] >= 10000 ? 0 : $summary['total_delivery_price'];
//        $summary['delivery_price'] = $summary['product_dcprice'] >= 10000 ? 0 : $summary['delivery_price'];

        // 할인금액 재계산
        $summary['productDiscountList'] = $this->refactDiscount($summary['productDiscountList']);


        return ['companySummary' => $companySummary, 'summary' => $summary];
    }

    /**
     * 할인 정보 재구성
     * @param array $productDiscountList
     * @return array
     */
    public function refactDiscount($productDiscountList)
    {
        $discountData = [];

        if (!empty($productDiscountList)) {
            foreach ($productDiscountList as $discount) {
                // 즉시할인 + 회원할인 더함
                if ($discount['type'] == 'IN' || $discount['type'] == 'MG') {
                    if (isset($discountData['IN_MG'])) {
                        $discountData['IN_MG']['discount_amount'] += $discount['discount_amount'];
                    } else {
                        $discountData['IN_MG'] = [
                            'type' => 'IN'
                            , 'title' => ForbizConfig::getDiscount('IN')
                            , 'discount_amount' => $discount['discount_amount']
                        ];
                    }
                } else {
                    $discountData[$discount['type']] = [
                        'type' => $discount['type']
                        , 'title' => $discount['title']
                        , 'discount_amount' => $discount['discount_amount']
                    ];
                }
            }
        }

        return array_values($discountData);
    }
    //////////////////////////////////////////////////////////////

    /**
     * 카트에 담긴 세트 상품 삭제
     * @param array $delCartSet 카트ID
     * @return boolean
     */
    protected function deleteCartSet($delCartSet)
    {
        return $this->qb
            ->whereIn('shop_cart_set_id',
                $this->qb
                    ->startSubQuery()
                    ->distinct()
                    ->select('set_group')
                    ->from(TBL_SHOP_CART)
                    ->whereIn('cart_ix', $delCartSet)
                    ->endSubQuery(), false
            )
            ->delete(TBL_SHOP_CART_SET)
            ->exec();
    }

    public function insertGiftItem($addCartIxs, $giftData, $giftCnt)
    {

        if (!empty($addCartIxs)) {
            if (is_array($giftData)) {

                $this->qb
                    ->delete(TBL_SHOP_CART_GIFT)
                    ->where('cart_ix', $addCartIxs)
                    ->exec();

                foreach ($giftData as $pid) {
                    if (!empty($pid)) {
                        $product = $this->qb
                            ->select('pname')
                            ->from(TBL_SHOP_PRODUCT)
                            ->where('id', $pid)
                            ->exec()->getRowArray();
                        $pname = $product['pname'];
                        $this->qb
                            ->set('cart_ix', $addCartIxs)
                            ->set('pid', $pid)
                            ->set('gift_type', 'P')
                            ->set('cnt', $giftCnt)
                            ->set('gift_name', $pname)
                            ->set('regdate', date('Y-m-d H:i:s'))
                            ->insert(TBL_SHOP_CART_GIFT)
                            ->exec();
                    }
                }
            }
        }
    }

    public function deleteGiftItem($addCartIxs)
    {

        if (!empty($addCartIxs)) {
            $this->qb
                ->delete(TBL_SHOP_CART_GIFT)
                ->where('cart_ix', $addCartIxs)
                ->exec();
        }
    }

    public function getGiftItem($cartIx)
    {
        $this->qb->setDatabase('payment');

        /*$data = $this->qb
            ->select('*')
            ->from(TBL_SHOP_CART_GIFT)
            ->whereIn('cart_ix', explode(',', $cartIx))
            ->whereIn('gift_type', 'P')
            ->exec()->getResultArray();

        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key2 => $val2) {
                $datas = $this->qb
                    ->select('id, disp, state, stock, slistNum')
                    ->from(TBL_SHOP_PRODUCT)
                    ->whereIn('id', $val2['pid'])
                    ->exec()->getResultArray();
                if (is_array($datas) && count($datas) > 0) {
                    print_r($datas);
                    echo "<hr>";

                    foreach ($datas as $key => $val) {
                        //$datas[$key]['image_src'] = get_product_images_src($val['pid'], '', 's', '');

                        if ($val['slistNum'] == 0) {
                            $datas[$key2]['image_src'] = get_product_images_src_new($val['id'], '', 'slist', '', 0);
                        } else {
                            $datas[$key2]['image_src'] = get_product_images_src_new($val['id'], '', 'slist', '', $val['slistNum'] - 1);
                        }

                        $datas[$key2]['gift_type'] = $val2['gift_type'];
                        $datas[$key2]['cnt'] = $val2['cnt'];
                        $datas[$key2]['gift_name'] = $val2['gift_name'];


                        if ($_SERVER['REQUEST_URI'] == '/shop/cart') {
                            //장바구니에서만 품절처리
                            $datas[$key2]['status'] = $this->setStatus($val['disp'], $val['state'], $val['stock']);
                        } else {
                            //그 외 페이지에서는 비노출
                            if ($this->setStatus($val['disp'], $val['state'], $val['stock']) != 'sale') {
                                if (count($datas) > 1) {
                                    $this->array_pop_key($datas, $key2);
                                } else {
                                    $datas = array();
                                }
                            }
                        }
                    }
                }else{
                    $datas[$key2]['image_src'] = "/assets/templet/enterprise/images/common/icon_no-freebie.png";
                    $datas[$key2]['gift_type'] = $val2['gift_type'];
                    $datas[$key2]['cnt'] = 0;
                    $datas[$key2]['gift_name'] = "사은품 선택 안함";
                }
            }
        }*/

        $datas = $this->qb
            ->select('cg.*, p.disp, p.state, p.stock, p.slistNum')
            ->from(TBL_SHOP_CART_GIFT . ' AS cg')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'cg.pid = p.id')
            ->whereIn('cart_ix', explode(',', $cartIx))
            ->whereIn('gift_type', 'P')
            ->exec()->getResultArray();

        if (is_array($datas) && count($datas) > 0) {
            foreach ($datas as $key => $val) {
                //$datas[$key]['image_src'] = get_product_images_src($val['pid'], '', 's', '');

                if($val['slistNum'] == 0){
                    $datas[$key]['image_src'] = get_product_images_src_new($val['pid'], '', 'slist', '', 0);
                }else{
                    $datas[$key]['image_src'] = get_product_images_src_new($val['pid'], '', 'slist', '', $val['slistNum']-1);
                }

                if($val['pid'] == '55421'){
                    //$this->array_pop_key($datas, $key);
                }else{
                    if ($_SERVER['REQUEST_URI'] == '/shop/cart') {
                        //장바구니에서만 품절처리
                        $datas[$key]['status'] = $this->setStatus($val['disp'], $val['state'], $val['stock']);
                    } else {
                        //그 외 페이지에서는 비노출
                        if ($this->setStatus($val['disp'], $val['state'], $val['stock']) != 'sale') {

                            if (count($datas) > 1) {
                                $this->array_pop_key($datas, $key);
                            } else {
                                $datas = array();
                            }
                        }
                    }
                }
            }
        }

        return $datas;
    }

    public function getGiftItemNoSelect($cartIx)
    {
        $this->qb->setDatabase('payment');
        $datas = $this->qb
            ->select('c.id,pg.gift_pid, p.disp, p.state, p.stock')
            ->from(TBL_SHOP_CART . ' AS c')
            ->join(TBL_SHOP_PRODUCT_GIFT . ' AS pg', 'pg.pid = c.id')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'pg.gift_pid = p.id')
            ->whereIn('cart_ix', explode(',', $cartIx))
            ->where("if(p.is_sell_date = '1',p.sell_priod_sdate <= '" . date('Y-m-d H:i:s') . "' and p.sell_priod_edate >= '" . date('Y:m:d H:i:s') . "','1=1')", '', false)
            ->exec()->getResultArray();

        $stockCheckBool = false;
        if (is_array($datas) && count($datas) > 0) {
            foreach ($datas as $key => $val) {
                    //장바구니에서만 품절처리sale
                $status = $this->setStatus($val['disp'], $val['state'], $val['stock']);
                if($status == 'sale'){
                    $stockCheckBool = true;
                }

            }
        }
        return $stockCheckBool;
    }

    public function getSeletedGiftItem($cartIx, $type)
    {
        $datas = $this->qb
            ->select('*')
            ->from(TBL_SHOP_CART_GIFT)
            ->whereIn('cart_ix', explode(',', $cartIx))
            ->whereIn('gift_type', $type)
            ->exec()->getResultArray();

        if (is_array($datas) && count($datas) > 0) {
            foreach ($datas as $key => $val) {
                $datas[$key]['image_src'] = get_product_images_src($val['pid'], '', 's', '');

            }
        }
        return $datas;
    }

    public function updateGiftCount($cartIx, $count)
    {

        if (is_array($cartIx)) {
            $cartIxArr = $cartIx;
        } else {
            $cartIxArr = explode(',', $cartIx);
        }

        $this->qb
            ->set('cnt', $count)
            ->whereIn('cart_ix', $cartIxArr)
            ->update(TBL_SHOP_CART_GIFT . ' as c')
            ->exec();


    }

    public function getCartItemCount($cartIx)
    {

        if (is_array($cartIx)) {
            $cartIxArr = $cartIx;
        } else {
            $cartIxArr = explode(',', $cartIx);
        }


        $data = $this->qb
            ->select('pcount')
            ->from(TBL_SHOP_CART)
            ->whereIn('cart_ix', $cartIxArr)
            ->exec()->getRowArray();

        return $data['pcount'] ?? 0;

    }

    /**
     * 상품 판매상태 설정
     * @param int $disp
     * @param int $state
     * @param int $stock
     * @return string
     */
    public function setStatus($disp, $state, $stock)
    {
        //상품 상태 sale:판매, soldout:일시품절, stop:판매중지
        if ($disp == '1') {
            if ($state == '1') {
                if ($stock > 0) {
                    $status = 'sale';
                } else {
                    $status = 'soldout';
                }
            } else if ($state == '0') {
                $status = 'soldout';
            } else if ($state == '4') {
                $status = 'ready';
            } else if ($state == '5') {
                $status = 'end';
            } else {
                $status = 'stop';
            }
        } else {
            $status = 'stop';
        }
        return $status;
    }


    public function array_pop_key(&$array, $key)
    {
        if (!isset($array[$key])) return null;
        $value = $array[$key];
        unset($array[$key]);
        return $value;
    }

    public function getCremaCartInfo($isAll = false)
    {
        if($isAll === false) {
            $yesterDay = date("Y-m-d", strtotime("yesterday"));
            $this->qb->betweenDate('regdate', $yesterDay, $yesterDay);
        }

        if($isAll == 'test') {
            $this->qb->limit(10);
        }

        return $this->qb
            ->select('cm.id')
            ->select('sc.cart_ix')
            ->select("TRIM(LEADING '0' FROM sc.id) AS pid", false)
            ->select("DATE_FORMAT(regdate, '%Y-%m-%dT%T') AS regdate", false)
            ->from(TBL_SHOP_CART . ' sc')
            ->join(TBL_COMMON_USER . ' cm', 'sc.mem_ix = cm.code')
            ->where('mem_ix !=', '')
            ->orderBy('mem_ix')
            ->orderBy('cart_ix')
            ->exec()
            ->getResultArray();
    }

}