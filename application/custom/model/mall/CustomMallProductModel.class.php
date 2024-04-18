<?php

/**
 * Description of CustomerMallProductModel
 *
 * @author hong
 */
class CustomMallProductModel extends ForbizMallProductModel
{

    /**
     * 회원 그룹할인 적용 여부 Y:적용, N:적용안함
     * @var string
     */
    protected $discoutMemberGroupCalculationYn = 'N';
    public $categoryReserveYn = [];

    public function __construct()
    {
        parent::__construct();

        if (MALL_IX == '20bd04dac38084b2bafdd6d78cd596b2') {
            //해외
            $this->discoutRoundPosition = -2;
        }
    }

    /**
     * set 회원 그룹할인 적용
     * @param $value
     */
    public function setDiscoutMemberGroupCalculationYn($value)
    {
        $this->discoutMemberGroupCalculationYn = $value;
    }

    /**
     * get 상품 옵션정보
     * @param int $id 상품ID
     * @param string $returnType 'all' or 'row'
     * @param int $optionId
     * @param string $addOptionType '' or 'second'
     * @return array
     */
    public function getOption($id, $returnType = 'all', $optionId = '', $addOptionType = '')
    {

        $options = [];
        $addOptions = [];
        $combinationOptions = [];

        if (!empty($optionId)) {
            $this->qb
                ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS pod', 'po.opn_ix=pod.opn_ix')
                ->whereIn('pod.id', explode(",", $optionId))
                ->groupBy('po.opn_ix');
        }

        // step1
        // 상품 옵션 기본정보 리스트
        $optionRows = $this->qb
            ->select('p.pname')
            ->select('p.add_info')
            ->select('po.opn_ix')
            ->select('po.option_kind')
            ->select('po.option_type')
            ->select('po.option_name')
            ->select('p.state as product_state')
            ->from(TBL_SHOP_PRODUCT_OPTIONS . ' AS po')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'po.pid=p.id')
            ->where('po.option_use', '1')
            ->where('po.pid', $id)
            ->where('p.state', 1)
            ->where('p.disp', 1)
            ->orderby('po.option_vieworder', 'asc')
            ->exec()
            ->getResultArray();

        if (!empty($optionRows)) {

            $pinfo = $this->basicSelect()
                ->from(TBL_SHOP_PRODUCT . ' AS p')
                ->where('p.id', $id)
                ->exec()
                ->getRowArray();


            //옵션 타입별로 별도 저장
            foreach ($optionRows as $optionsRow) {

                //추가구성상품
                if ($optionsRow['option_kind'] == 'a') {
                    $addOptions[] = [
                        'opn_ix' => $optionsRow['opn_ix']
                        , 'option_name' => $optionsRow['option_name']
                        , 'product_state' => $optionsRow['product_state']
                        , 'add_info' => $optionsRow['add_info']
                    ];
                    //조합옵션
                } else if ($optionsRow['option_kind'] == 'c1' || $optionsRow['option_kind'] == 'c') {

                    $combinationOptions[] = [
                        'opn_ix' => $optionsRow['opn_ix']
                        , 'option_kind' => $optionsRow['option_kind']
                        , 'option_type' => $optionsRow['option_type']
                        , 'option_name' => $optionsRow['option_name']
                        , 'product_state' => $optionsRow['product_state']
                        , 'pname' => html_entity_decode(stripslashes($optionsRow['pname']), ENT_QUOTES)
                        , 'add_info' => $optionsRow['add_info']
                    ];
                } else {
                    $options[] = [
                        'opn_ix' => $optionsRow['opn_ix']
                        , 'option_kind' => $optionsRow['option_kind']
                        , 'option_type' => $optionsRow['option_type']
                        , 'option_name' => $optionsRow['option_name']
                        , 'product_state' => $optionsRow['product_state']
                        , 'pname' => html_entity_decode(stripslashes($optionsRow['pname']), ENT_QUOTES)
                        , 'add_info' => $optionsRow['add_info']
                    ];
                }
            }

            // 특정 옵션 아이디 선택시
            if (!empty($optionId)) {
                $this->qb->whereIn('pod.id', explode(",", $optionId));
            }

            // step2
            // 기본 가격 정보 추출
            $optionDetailRows = $this->basicOptionDetailSelect()
                ->select('pod.id as option_id')
                ->select('pod.opn_ix')
                ->select('pod.option_price')
                ->select('pod.option_div')
                ->select('CASE WHEN pod.option_div regexp "Small" THEN "S" WHEN pod.option_div regexp "Medium" THEN "M" WHEN pod.option_div regexp "Large" THEN "L" ELSE pod.option_div END AS m_option_div', FALSE )
                ->select('pod.option_color')
                ->select('pod.option_size')
                ->select('pod.option_etc1')// 구성수량
                ->select('pod.option_gid')// 품목 코드
                ->select('gu.weight')// 품목 코드
                ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' as pod')
                ->join(TBL_INVENTORY_GOODS_UNIT . ' as gu', 'gu.gu_ix = pod.option_code','left')
                ->join(TBL_INVENTORY_GOODS .' as ig' ,'ig.gid = pod.option_gid' ,'left')//옵션 size 정보 획득을 위한 join
                ->join(TBL_SHOP_PRODUCT_OPTIONS_SORT_BY_VALUE .' as sb' ,'sb.value = ig.size' ,'left') //옵션 정렬 기준 테이블
                ->whereIn('pod.opn_ix', array_merge(
                        array_column($options, 'opn_ix')
                        , array_column($addOptions, 'opn_ix')
                        , array_column($combinationOptions, 'opn_ix')
                    )
                )
                ->orderby('sb.view_order','asc')

                ->exec()
                ->getResultArray();

            //옵션 상세
            foreach ($optionDetailRows as $optionDetailRow) {

                // option_etc1 : 구성 수량
                // 구성수량이 설정된 옵션에 경우 개수를 가격에 곱해준다. .. 이건 아닌거 같음..
                // option_listprice
                // option_price 사용
                // 공통 맞는지?
//                if ($optionDetailRow['option_etc1'] > 0) {
//                    $optionDetailRow['option_listprice'] = $optionDetailRow['option_listprice'] * $optionDetailRow['option_etc1'];
//                    $optionDetailRow['option_price']     = $optionDetailRow['option_price'] * $optionDetailRow['option_etc1'];
//                }
                // A : 추가구성상품 ************************************************************************************
                if (!empty($addOptions)) {

                    // opn_ix : 옵션 기본 아이디, option_id : 옵션 상세 아이디
                    // !!!!!!!! 추가 옵션은 할인에서 제외
                    $addOptionKey = array_search($optionDetailRow['opn_ix'], array_column($addOptions, 'opn_ix'));

                    if ($addOptionKey !== false) {

                        if ($addOptions[$addOptionKey]['product_state'] == '1') {
                            if ($optionDetailRow['option_etc1'] > 0) {
                                $tmp_option_stock = intVal($optionDetailRow['option_stock'] / $optionDetailRow['option_etc1']);
                            } else {
                                $tmp_option_stock = $optionDetailRow['option_stock'];
                            }
                        } else {
                            $tmp_option_stock = 0;
                        }

                        if ($optionDetailRow['option_gid']) {
                            $invenImage = get_inventory_images_src($optionDetailRow['option_gid'], '', 'b', '');
                        }

                        $addOptions[$addOptionKey]['optionDetailList'][] = [
                            'option_id' => $optionDetailRow['option_id']
                            , 'option_div' => $optionDetailRow['option_div']
                            , 'm_option_div' => $optionDetailRow['m_option_div']
                            , 'option_listprice' => f_decimal($optionDetailRow['option_sellprice'])
                            , 'option_sellprice' => f_decimal($optionDetailRow['option_sellprice'])
                            , 'option_dcprice' => f_decimal($optionDetailRow['option_sellprice'])
                            , 'option_name' => $addOptions[$addOptionKey]['option_name']
                            , 'option_add_price' => f_decimal(0)
                            , 'option_stock' => $tmp_option_stock
                            , 'invenImage' => $invenImage
                            , 'weight' => $optionDetailRow['weight']
                        ];
                        continue;
                    }
                }


                // B : 조합옵션 ****************************************************************************************
                if (!empty($combinationOptions)) {

                    $optionCombinationStock = 0;
                    $combinationOptionsKey = array_search($optionDetailRow['opn_ix'], array_column($combinationOptions, 'opn_ix'));

                    // 코디 옵션이 존재하면
                    if ($combinationOptionsKey !== false) {

                        // c: 코디옵션
                        if ($combinationOptions[$combinationOptionsKey]['option_kind'] == 'c') {

                            $division = [];
                            if ($combinationOptions[$combinationOptionsKey]['option_type'] == 'd') {
                                $division[] = $optionDetailRow['option_color'];
                                $division[] = $optionDetailRow['option_size'];
                            } else {
                                $division[] = $optionDetailRow['option_id'];
                            }

                            $optionListPrice = f_decimal($optionDetailRow['option_listprice']);
                            $optionSellPrice = f_decimal($optionDetailRow['option_price']);
                            $optionDcPrice = f_decimal($optionDetailRow['option_price']);

                            if (intVal($optionDetailRow['option_etc1']) == 0) {
                                $optionCombinationStock = 0;
                            } else {
                                $optionCombinationStock = floor($optionDetailRow['option_stock'] / $optionDetailRow['option_etc1']);
                            }

                            $option_add_price = f_decimal(0);
                            // c1 : 조합옵션
                        } else {
                            //조합옵션은 combinationOption 에서 금액, 재고 처리
                            $optionListPrice = f_decimal($pinfo['listprice']) + f_decimal($optionDetailRow['option_price']);
                            $optionSellPrice = f_decimal($pinfo['dcprice']) + f_decimal($optionDetailRow['option_price']);
                            $optionDcPrice = f_decimal($pinfo['dcprice']) + f_decimal($optionDetailRow['option_price']);
                            $option_add_price = f_decimal($optionDetailRow['option_price']);
                        }


                        $combinationOptions[$combinationOptionsKey]['optionDetailList'][] = [
                            'option_id' => $optionDetailRow['option_id']
                            , 'option_div' => $optionDetailRow['option_div']
                            , 'm_option_div' => $optionDetailRow['m_option_div']
                            , 'option_listprice' => $optionListPrice
                            , 'option_sellprice' => $optionSellPrice
                            , 'option_dcprice' => $optionDcPrice
                            , 'option_add_price' => $option_add_price
                            , 'option_stock' => $optionCombinationStock
                            , 'division' => $division
                            , 'pname' => $combinationOptions[$combinationOptionsKey]['pname']
                            , 'add_info' => $combinationOptions[$combinationOptionsKey]['add_info']
                            , 'weight' => $optionDetailRow['weight']
                            , 'option_gid' => $optionDetailRow['option_gid']
                        ];
                        continue;
                    }
                }


                $optionsKey = array_search($optionDetailRow['opn_ix'], array_column($options, 'opn_ix'));


                // C: 조합옵션(독립)일때
                if ($options[$optionsKey]['option_kind'] == 'i1') {

                    $optionListPrice = f_decimal($pinfo['listprice']) + f_decimal($optionDetailRow['option_price']);
                    $optionSellPrice = f_decimal($pinfo['dcprice']) + f_decimal($optionDetailRow['option_price']);
                    $optionDcPrice = f_decimal($pinfo['dcprice']) + f_decimal($optionDetailRow['option_price']);
                    $discount = $this->discountCalculation($id, $optionListPrice, $optionDcPrice);
                    $optionDcPrice = $discount['dcprice'];
                    $optionAddPrice = $optionDetailRow['option_price'];
                    $optionStock = ($options[$optionsKey]['product_state'] == '1' ? 99999 : 0);
                } else {

                    $optionListPrice = f_decimal($optionDetailRow['option_listprice']);
                    $optionSellPrice = f_decimal($optionDetailRow['option_sellprice']);
                    $discount = $this->discountCalculation($id, $optionDetailRow['option_listprice'], $optionDetailRow['option_dcprice']);

                    $optionDcPrice = $discount['dcprice'];
                    $optionAddPrice = f_decimal(0);
                    $optionStock = ($options[$optionsKey]['product_state'] == '1' ? $optionDetailRow['option_stock'] : 0);
                }

                $optionDiscountAmount = $discount['discount_amount'];
                $optionDiscountRate = $discount['discount_rate'];
                $optionDiscountList = $discount['discountList'];

                $division = [];
                if ($options[$optionsKey]['option_type'] == 'o') {
                    $option_div = $optionDetailRow['option_color'] . ', ' . $optionDetailRow['option_size'];
                    $division[] = $optionDetailRow['option_color'];
                    $division[] = $optionDetailRow['option_size'];
                } else if ($options[$optionsKey]['option_type'] == 'c') {
                    $option_div = $optionDetailRow['option_color'];
                    $division[] = $optionDetailRow['option_id'];
                } else if ($options[$optionsKey]['option_type'] == 's') {
                    $option_div = $optionDetailRow['option_size'];
                    $division[] = $optionDetailRow['option_id'];
                } else {
                    $option_div = $optionDetailRow['option_div'];
                    $division[] = $optionDetailRow['option_id'];
                }

                $options[$optionsKey]['optionDetailList'][] = [
                    'option_id' => $optionDetailRow['option_id']
                    , 'option_div' => $option_div
                    , 'm_option_div' => $optionDetailRow['m_option_div']
                    , 'option_listprice' => $optionListPrice
                    , 'option_sellprice' => $optionSellPrice
                    , 'option_dcprice' => $optionDcPrice
                    , 'option_add_price' => $optionAddPrice
                    , 'option_discount_amount' => $optionDiscountAmount
                    , 'option_discount_rate' => $optionDiscountRate
                    , 'division' => $division
                    , 'optionDiscountList' => $optionDiscountList
                    , 'option_stock' => $optionStock
                    , 'opn_ix' => $options[$optionsKey]['opn_ix']
                    , 'pname' => $options[$optionsKey]['pname']
                    , 'add_info' => $options[$optionsKey]['add_info']
                    , 'weight' => $optionDetailRow['weight']
                ];

                // 세트 옵션?
                if ($options[$optionsKey]['option_kind'] == 's2') {
                    break;
                }
            }
        }

        //배럴 추가 구성 옵션 사용 안함
        $addOptions = [];
        if ($returnType == 'all' && $addOptionType != 'second') {
            $addProductlist = $this->qb
                ->select('rp_pid as pid')
                ->from(TBL_SHOP_RELATION_ADD_PRODUCT)
                ->where('pid', $id)
				->orderBy('vieworder')
                ->exec()->getResultArray();


            if (count($addProductlist) > 0) {

                $ids = array_column($addProductlist, 'pid');
                $saveIds = array_keys($this->discountData);

                // 현재 할인된 상품 리스트에서 조회
                $noIds = array_diff($ids, $saveIds); // $ids - $saveIds
                //discountData 에 상품의 할인 정보가 없다면, 없는 id 들만 추려서 setDiscountData 처리

                if (!empty($noIds)) {
                    $noIds = array_unique($noIds);
                    $this->setDiscountData($noIds);
                }

                foreach ($addProductlist as $addProdcut) {
                    //추가 구성 상품으로 등록된 상품이 또다른 추가 구성 상품을 가지고 있다면 프로세스가 중지 되어야 하기에 addoptiontype 추가 처리하여 조작 함
                    $optionData = $this->getOption($addProdcut['pid'], 'all', '', 'second');
                    if (count($optionData['viewOptions']) == 1 && $optionData['viewOptions'][0]['option_kind'] == 'b') {
                        $addoption = [
                            'opn_ix' => $addProdcut['pid']
                            , 'option_name' => $optionData['options'][0]['pname']
                            , 'add_info' => $optionData['options'][0]['add_info']
                            , 'pid' => $addProdcut['pid']
                            , 'images' => get_product_images_src($addProdcut['pid'], true, 'c')
                        ];
                        $addoption['optionDetailList'] = $optionData['options'];
                        $addOptions[] = $addoption;
                        //print_r($addOptions);
                    }
                }
            }
        }
        if (!empty($combinationOptions)) {
            $options = $this->combinationOption($id, $combinationOptions);
            $viewOptions = $this->compileViewOption($combinationOptions);
        } else if (!empty($options)) {
            $viewOptions = $this->compileViewOption($options);
            $options = empty($options[0]['optionDetailList']) ? [] : $options[0]['optionDetailList'];
        } else {
            $viewOptions = [];
        }

        if ($returnType == 'row') {

            if (!empty($addOptions)) {
                $options = $addOptions[0]['optionDetailList'];
            }

            $targetOption = ($options[0] ?? []);
            return [
                'option_kind' => ($optionRows[0]['option_kind'] ?? '')
                , 'option_id' => ($targetOption['option_id'] ?? 0)
                , 'option_div' => ($targetOption['option_div'] ?? '')
                , 'option_listprice' => ($targetOption['option_listprice'] ?? 0)
                , 'option_sellprice' => ($targetOption['option_sellprice'] ?? 0)
                , 'option_dcprice' => ($targetOption['option_dcprice'] ?? 0)
                , 'option_add_price' => ($targetOption['option_add_price'] ?? 0)
                , 'option_discount_amount' => ($targetOption['option_discount_amount'] ?? 0)
                , 'option_discount_rate' => ($targetOption['option_discount_rate'] ?? 0)
                , 'optionDiscountList' => ($targetOption['optionDiscountList'] ?? [])
                , 'option_stock' => ($targetOption['option_stock'] ?? 0)
                , 'opn_ix' => ($targetOption['opn_ix'] ?? '')
                , 'weight' => ($targetOption['weight'] ?? '')
            ];
        } else {

            return ['options' => $options
                , 'viewOptions' => $viewOptions
                , 'addOptions' => $addOptions
            ];
        }
    }

    /**
     * 옵션 조합
     * @param int $id
     * @param array $options
     * @return array
     */
    protected function combinationOption($id, $options)
    {
        $result = [];
        if (!empty($options)) {
            foreach ($options as $optionKey => $option) {
                $tmp = [];
                $optionType = $option['option_type'];
                foreach ($option['optionDetailList'] as $detail) {
                    if ($optionKey == 0) {
                        $tmp[] = [
                            'option_id' => $detail['option_id']
                            , 'option_div' => $option['option_name'] . ":" . $detail['option_div']
                            , 'option_listprice' => $detail['option_listprice']
                            , 'option_sellprice' => $detail['option_sellprice']
                            , 'option_dcprice' => $detail['option_dcprice']
                            , 'option_stock' => $detail['option_stock']
                            , 'pname' => $detail['pname']
                            , 'add_info' => $detail['add_info']
                            , 'division' => $detail['division']
                            , 'weight' => $detail['weight']
                            , 'option_gid' => $detail['option_gid']
                        ];
                    } else {
                        foreach ($result as $r) {
                            $optionIds = explode(",", $r['option_id']);
                            array_push($optionIds, $detail['option_id']);
                            sort($optionIds, SORT_NUMERIC);

                            $division = array_merge($r['division'], $detail['division']);

                            if ($r['option_gid'] == $detail['option_gid']) {
                                $option_gid = $r['option_gid'];
                                $option_stock = floor($detail['option_stock'] / count($optionIds));
                            } else {
                                $option_gid = '';
                                $option_stock = ($r['option_stock'] > $detail['option_stock'] ? $detail['option_stock'] : $r['option_stock']);
                            }

                            $tmp[] = [
                                'option_id' => implode(",", $optionIds)
                                , 'option_div' => $r['option_div'] . ", " . $option['option_name'] . ":" . $detail['option_div']
                                , 'option_listprice' => ($option['option_kind'] == 'c' ? $r['option_listprice'] + $detail['option_listprice'] : $r['option_listprice'] + $detail['option_add_price'])
                                , 'option_sellprice' => ($option['option_kind'] == 'c' ? $r['option_sellprice'] + $detail['option_sellprice'] : $r['option_sellprice'] + $detail['option_add_price'])
                                , 'option_dcprice' => ($option['option_kind'] == 'c' ? $r['option_dcprice'] + $detail['option_sellprice'] : $r['option_dcprice'] + $detail['option_add_price'])
                                , 'option_stock' => $option_stock
                                , 'pname' => $detail['pname']
                                , 'add_info' => $detail['add_info']
                                , 'division' => $division
                                , 'weight' => $detail['weight']
                                , 'option_gid' => $option_gid
                            ];
                        }
                    }
                }
                $result = $tmp;
            }

            //금액 관련 처리
            foreach ($result as $key => $r) {
                $discount = $this->discountCalculation($id, $r['option_dcprice'], $r['option_dcprice']);
                $r['option_dcprice'] = $discount['dcprice'];
                $r['option_add_price'] = ($r['option_dcprice'] - $r['option_sellprice'] > 0 ? $r['option_dcprice'] - $r['option_sellprice'] : 0);
                $r['option_discount_amount'] = $discount['discount_amount'];
                $r['option_discount_rate'] = $discount['discount_rate'];
                $r['optionDiscountList'] = $discount['discountList'];
                $result[$key] = $r;
            }
        }
        return $result;
    }

    /**
     * 세트상품 데이타 조회
     * @param string $pid 상품ID
     * @param int $opn_ix 옵션ID
     * @param int $opn_d_ix 옵션상세ID
     * @return array
     */
    public function getSetOptionInfo($pid, $opn_ix, $opn_d_ix)
    {
        $rows = $this->qb
            ->select('id')
            ->select('option_etc1')
            ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
            ->where('pid', $pid)
            ->where('opn_ix', $opn_ix)
            ->where('id !=', $opn_d_ix)
            ->orderBy('set_group_seq')
            ->exec()
            ->getResultArray();

        return $rows;
    }

    /**
     * 코디상품 데이타 조회
     * @param string $pid
     * @param string $opn_d_ix
     * @return array
     */
    public function getCodiOptionInfo($pid, $opn_d_ix)
    {
        if (strstr($opn_d_ix, ',')) {
            $opn_d_ix = explode(',', $opn_d_ix);
        }

        $rows = $this->qb
            ->select('id')
            ->select('option_div')
            ->select('option_etc1')
            ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
            ->where('pid', $pid)
            ->whereIn('id', is_array($opn_d_ix) ? $opn_d_ix : [$opn_d_ix])
            ->exec()
            ->getResultArray();

        return $rows;
    }

    /**
     * 옵션 텍스트 조회
     * @param int $opn_d_ix 옵션상세ID
     * @return string
     */
    public function getOptionDiv($opn_d_ix)
    {
        $row = $this->qb
            ->select('option_div')
            ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
            ->where('id', $opn_d_ix)
            ->exec()
            ->getRow();

        return $row->option_div ?? '';
    }
    /**
     * discountData 데이터에 있는 기준으로 계산
     * @param int $id
     * @param int $listPrice
     * @param int $dcPrice
     * @return array
     */
//    protected function discountCalculation($id, $listPrice, $dcPrice)
//    {
//        $discountAmount = 0;
//        $discountRate = 0;
//        $discountList = [];
//
//        //즉시 할인
//        if ($listPrice > $dcPrice) {
//            $discountList[] = [
//                'type' => 'IN'
//                , 'title' => ForbizConfig::getDiscount('IN')
//                , 'discount_amount' => ($listPrice - $dcPrice)
//            ];
//        }
//
//
//        $no = 1;
//        if (!empty($this->discountData[$id])) {
//
//            foreach ($this->discountData[$id] as $discountKey => $data) {
//
//                $lastDiscount = ($discountList[(count($discountList) - 1)] ?? ['type' => '']);
//
//                // 할인명 불러오기
//                $data['title'] = ForbizConfig::getDiscount($lastDiscount['type']);
//
//                if (in_array($data['type'], ['GP', 'SP', 'M', 'MG']) && $lastDiscount['type'] == $data['type']) {
//                    $_dcPrice = $beforeDcPrice;
//                } else {
//                    $_dcPrice = $dcPrice;
//                }
//
//                if ($data['sale_type'] == '1') { // %
//                    $dcPrice = $this->round($_dcPrice * (100 - $data['sale_value']) / 100);
//                    $_headofficeDcPrice = $this->round($_dcPrice * (100 - $data['headoffice_sale_value']) / 100);
//
//                } else if ($data['sale_type'] == '2') { // 원
//                    $dcPrice = ($_dcPrice - $data['sale_value'] ? $_dcPrice - $data['sale_value'] : 0);
//                    $_headofficeDcPrice = ($_dcPrice - $data['headoffice_sale_value'] > 0 ? $_dcPrice - $data['headoffice_sale_value'] : 0);
//                }
//
//                $beforeDcPrice = $_dcPrice;
//
//                $_discountAmount = $_dcPrice - $dcPrice;  // 할인금액
//                $_headofficeDiscountAmount = $_dcPrice - $_headofficeDcPrice;
//
//                $data['discount_amount'] = $_discountAmount; // 최종 할인된 금액
//                $data['headoffice_discount_amount'] = $_headofficeDiscountAmount; // 본사 할인 금액
//                $data['seller_discount_amount'] = $_discountAmount - $_headofficeDiscountAmount; // 셀러 할인 금액
//
//                //기획&특별&모바일은 %,원 금액중 가장 큰금액으로 할인해줘야함
//                if (in_array($data['type'], ['GP', 'SP', 'M', 'MG']) && $lastDiscount['type'] == $data['type']) {
//                    if ($lastDiscount['discount_amount'] < $data['discount_amount']) {
//                        $discountList[(count($discountList) - 1)] = $data;
//                    }
//                } else {
//                    $discountList[] = $data;
//                }
//
//                $no++;
//            }
//        }
//
//        return [
//            'dcprice' => $dcPrice
//            , 'discount_amount' => $listPrice - $dcPrice
//            , 'discount_rate' => ($listPrice > 0 ? round(($listPrice - $dcPrice) / $listPrice * 100) : 0)
//            , 'discountList' => $discountList
//        ];
//    }

    /**
     * 사은품 정보를 조회한다.
     * @param int $pid
     * @param string $imageSizeType
     * @return array
     */
    public function getGift($pid, $imageSizeType = 's', $cnt = 0)
    {
        $state = [0, 1];

        $rows = $this->qb
            ->select('p.id')
            ->select('p.pname')
            ->select('p.is_adult')
            ->select('p.gift_qty')
            ->select('p.sell_priod_sdate')
            ->select('p.sell_priod_edate')
            ->select('p.add_info')
            ->select('p.stock')
            ->select('p.state')
            ->select('p.disp')
            ->select('p.slistNum')
            ->from(TBL_SHOP_PRODUCT_GIFT . ' AS g')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'g.gift_pid = p.id')
            ->where('pid', $pid)
            ->whereIn('state', $state)
            ->where('disp', '1')
            ->exec()
            ->getResultArray();


        $data = [];
        $data2 = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                if (time() < strtotime($row['sell_priod_edate']) && time() > strtotime($row['sell_priod_sdate'])) { //사은품 판매기간 설정에 따른 조건추가 #5177
                    if($row['slistNum'] == 0){
                        $slistNum = 0;
                    }else{
                        $slistNum = $row['slistNum']-1;
                    }

                    $data[] = [
                        'pid' => $row['id']
                        //, 'image_src' => get_product_images_src($row['id'], $this->isUserAdult, $imageSizeType, $row['is_adult']) //이미지
                        , 'image_src' => get_product_images_src_new($row['id'], $this->isUserAdult, 'slist', $row['is_adult'], $slistNum) //이미지
                        , 'pname' => $row['pname']
                        , 'gift_qty' => $row['gift_qty']
                        , 'add_info' => $row['add_info']
                        , 'stock' => $row['stock']
                        , 'sell_priod_sdate' => date('m.d', strtotime($row['sell_priod_sdate']))
                        , 'sell_priod_edate' => date('m.d', strtotime($row['sell_priod_edate']))
                        , 'status' => $this->setStatus($row['disp'], $row['state'], $row['stock'])
                    ];
                }
            }

            //사은품 등록된 개수 만큼 사은품을 선택할 수 있도록 처리 하기 위해
//            foreach($rows as $key=> $row){
//                $data2[$key]['product_gift_detail'] = $data;
//            }

            for ($i = 0; $i < $cnt; $i++) {
                $data2[$i]['product_gift_detail'] = $data;
            }
        }

        return $data2;
    }

    public function getFreeGiftNew($freeGiftCondition,$payment_price=0, $fgKey=[],$imageSizeType = 's',$cartData=''){

        switch($freeGiftCondition){
            case 'C':
                $freegift_condition_text = "특정 카테고리 사은품";
                $this->qb->whereIn('fg.fg_ix',$fgKey);
                break;
            case 'P':
                $freegift_condition_text = "이벤트 제품 구매시 금액별 사은품";
                $this->qb->where('fpg.sale_condition_s <=', $payment_price);
                $this->qb->where('fpg.sale_condition_e >=', $payment_price);
                $this->qb->whereIn('fg.fg_ix',$fgKey);
                break;
            case 'G':
                $freegift_condition_text = "구매 금액별 사은품";
                $this->qb->where('fpg.sale_condition_s <=', $payment_price);
                $this->qb->where('fpg.sale_condition_e >=', $payment_price);
                break;

        }

        $rows = $this->qb
            ->select('fg.fg_ix')
            ->select('fg.member_target')
            ->select('fg.freegift_event_title')
            ->select('fpg.gift_cnt')
            ->select('fpg.sale_condition_s')
            ->select('fpg.sale_condition_e')
            ->select('fg.freegift_condition')
            ->from(TBL_SHOP_FREEGIFT . ' AS fg')
            ->join(TBL_SHOP_FREEGIFT_PRODUCT_GROUP . ' AS fpg', 'fg.fg_ix = fpg.fg_ix')
            ->where('fg.freegift_condition', $freeGiftCondition)
            ->where('fg.disp', 1)// 전시여부 = 전시
            ->where('fg.fg_use_sdate <=', time())
            ->where('fg.fg_use_edate >=', time())
            ->whereIn('fg.mall_ix',['', MALL_IX])
            //->orderBy('fg.fg_ix','RANDOM')
            ->orderBy('fpg.sale_condition_s','desc')
            //->limit(1)
            ->exec()
            ->getResultArray();

        $data = [];

        foreach ($cartData as $company) {
            foreach ($company['deliveryTemplateList'] as $deliveryTemplate) {
                foreach ($deliveryTemplate['productList'] as $product => $val) {
                    if($product == 0){
                        $id = $val['id'];
                    }else{
                        $id = $id.", ".$val['id'];
                    }
                    $cartPrice[$val['id']] = $val['dcprice'] * $val['pcount'];
                }
            }
        }

        if (!empty($rows)) {
            foreach ($rows as $row) {

                //$sql = "select sum(sellprice) as noSellPrice from shop_product as p, shop_freegift_select_product_relation as fspr where fspr.fg_ix = '".$row['fg_ix']."' and fspr.pid = p.id and fspr.pid in ($id)";
                //$noSellPriceRow = $this->qb->exec($sql)->getResultArray();
                /*if($noSellPriceRow[0]['noSellPrice'] != ''){
                    $freeGiftPrice = $payment_price - $noSellPriceRow[0]['noSellPrice'];
                }else{
                    $freeGiftPrice = $payment_price;
                }*/
                $sql = "select id from shop_product as p, shop_freegift_select_product_relation as fspr where fspr.fg_ix = '".$row['fg_ix']."' and group_code = 3 and fspr.pid = p.id and fspr.pid in ($id)";
                $idRow = $this->qb->exec($sql)->getResultArray();

                $noSellPriceRow = 0;
                foreach($idRow as $key => $val){
                    $noSellPriceRow = $noSellPriceRow + $cartPrice[$val['id']];
                    /*foreach ($cartData as $company) {
                        foreach ($company['deliveryTemplateList'] as $deliveryTemplate) {
                            foreach ($deliveryTemplate['productList'] as $product => $pVal) {
                                if($val['id'] == $pVal['id']){
                                    $noSellPriceRow = $pVal['dcprice'] * $pVal['pcount'];
                                    $freeGiftPrice = $payment_price - $noSellPriceRow;
                                }
                            }
                        }
                    }*/
                }
                $freeGiftPrice = $payment_price - $noSellPriceRow;

                if(($freeGiftCondition == "G" && $freeGiftPrice >= $row['sale_condition_s']) || $freeGiftCondition == "C" || $freeGiftCondition == "P"){
                    // 공통 검색 로직
                    $this->qb
                        ->select('p.id')
                        ->select('p.pname')
                        ->select('p.is_adult')
                        ->select('p.stock')
                        ->select('p.sell_ing_cnt')
                        ->select('p.disp')
                        ->select('p.state')
                        ->from(TBL_SHOP_FREEGIFT_PRODUCT_RELATION . ' AS fpr')
                        ->join(TBL_SHOP_PRODUCT . ' AS p', 'fpr.pid = p.id')
                        ->where('fpr.fg_ix', $row['fg_ix'])
                        ->where("if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')",
                            '', false)
                        ->orderBy('fpr.vieworder');

                    // 회원조건이 있는가?
                    if ($row['member_target'] == 'M') {
                        // 특정 회원
                        $prows = $this->qb
                            ->join(TBL_SHOP_FREEGIFT_DISPLAY_RELATION . ' AS fdr', 'fpr.fg_ix = fdr.fg_ix')
                            ->where('r_ix', $this->userInfo->code)// 회원코드
                            ->exec()
                            ->getResultArray();
                    } elseif ($row['member_target'] == 'G') {
                        // 회원그룹
                        $prows = $this->qb
                            ->join(TBL_SHOP_FREEGIFT_DISPLAY_RELATION . ' AS fdr', 'fpr.fg_ix = fdr.fg_ix')
                            ->where('r_ix', $this->userInfo->gp_ix)// 그룹코드
                            ->exec()
                            ->getResultArray();
                    } else {
                        // 전체 회원
                        $prows = $this->qb
                            ->exec()
                            ->getResultArray();
                    }

                    $data['gift_cnt'] = $row['gift_cnt'];
                    $data['freegift_event_title'] = $row['freegift_event_title'];
                    $data['sale_condition_s'] = $row['sale_condition_s'];
                    $data['sale_condition_e'] = $row['sale_condition_e'];
                    $data['fg_ix'] = $row['fg_ix'];
                    $data['freegift_condition'] = $row['freegift_condition'];
                    $data['freegift_condition_text'] = $freegift_condition_text;
                    $data['freegift_condition_text_select'] = $freegift_condition_text." 선택";
                    if (!empty($prows)) {
                        $soldOutCheck = true;
                        foreach ($prows as $prow) {
                            $stock = $prow['stock'] - $prow['sell_ing_cnt'];
                            $status = $this->setStatus($prow['disp'], $prow['state'], $stock);
                            if ($stock > 0 && $status == 'sale') {
                                $soldOutCheck = false;
                                $data['gift_products'][][$prow['id']] = [
                                    'pid' => $prow['id']
                                    , 'image_src' => get_product_images_new_src($prow['id'], $this->isUserAdult, $imageSizeType, $prow['is_adult']) //이미지
                                    , 'pname' => $prow['pname']
                                    , 'status' => $status
                                    , 'stock' =>$stock
                                    , 'event_title' => $row['freegift_event_title']
                                    , 'event_fg_ix' => $row['fg_ix']
                                ];
                            }
                        }
                        if($soldOutCheck){
                            $data['soldOut'] =  $soldOutCheck;
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * @param $payment_price
     * @param string $imageSizeType
     * @return array
     * @throws Exception
     * 금액대별 사은품 조회 ver.1
     * 사은품 조건이 다양해 짐에 따라 새로 만든 함수를 이용 함
     * 이전 작업 시작일 2020-05-29 JK
     */
    public function getFreeGift($payment_price, $imageSizeType = 's')
    {
        // 매출 금액 및 사은품 기간별 조회
        // orderBy 추가 이유 : 운영상 중복되는 금액대별 사은품은 등록하지 않는 것으로 협의 되었으나 
        // 만약 중복이 될 경우 아래 코드를 이용하여 하나의 사은품 그룹을 가져오기 위함임 
        // 랜덤으로 하나를 가져오는 방법 이나, 기준 시작 금액이 가장 높은 기준으로 하나를 가져오는 방식 적용
        // ->orderBy('fg.fg_ix','RANDOM')
        // ->orderBy('fpg.sale_condition_s','desc')
        $rows = $this->qb
            ->select('fg.fg_ix')
            ->select('fg.member_target')
            ->select('fpg.gift_cnt')
            ->select('fpg.sale_condition_s')
            ->select('fpg.sale_condition_e')
            ->from(TBL_SHOP_FREEGIFT . ' AS fg')
            ->join(TBL_SHOP_FREEGIFT_PRODUCT_GROUP . ' AS fpg', 'fg.fg_ix = fpg.fg_ix')
            ->where('fg.freegift_condition', 'G')
            ->where('fg.disp', 1)// 전시여부 = 전시
            ->where('fg.fg_use_sdate <=', time())
            ->where('fg.fg_use_edate >=', time())
            ->where('fpg.sale_condition_s <=', $payment_price)
            ->where('fpg.sale_condition_e >=', $payment_price)
            ->whereIn('fg.mall_ix',['', MALL_IX])
            //->orderBy('fg.fg_ix','RANDOM')
            ->orderBy('fpg.sale_condition_s','desc')
            ->limit(1)
            ->exec()
            ->getResultArray();

        $data = [];

        if (!empty($rows)) {
            foreach ($rows as $row) {
                // 공통 검색 로직
                $this->qb
                    ->select('p.id')
                    ->select('p.pname')
                    ->select('p.is_adult')
                    ->select('p.stock')
                    ->select('p.sell_ing_cnt')
                    ->select('p.disp')
                    ->select('p.state')
                    ->from(TBL_SHOP_FREEGIFT_PRODUCT_RELATION . ' AS fpr')
                    ->join(TBL_SHOP_PRODUCT . ' AS p', 'fpr.pid = p.id')
                    ->where('fpr.fg_ix', $row['fg_ix'])
                    ->where("if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')",
                        '', false)
                    ->orderBy('fpr.vieworder');

                // 회원조건이 있는가?
                if ($row['member_target'] == 'M') {
                    // 특정 회원
                    $prows = $this->qb
                        ->join(TBL_SHOP_FREEGIFT_DISPLAY_RELATION . ' AS fdr', 'fpr.fg_ix = fdr.fg_ix')
                        ->where('r_ix', $this->userInfo->code)// 회원코드
                        ->exec()
                        ->getResultArray();
                } elseif ($row['member_target'] == 'G') {
                    // 회원그룹
                    $prows = $this->qb
                        ->join(TBL_SHOP_FREEGIFT_DISPLAY_RELATION . ' AS fdr', 'fpr.fg_ix = fdr.fg_ix')
                        ->where('r_ix', $this->userInfo->gp_ix)// 그룹코드
                        ->exec()
                        ->getResultArray();
                } else {
                    // 전체 회원
                    $prows = $this->qb
                        ->exec()
                        ->getResultArray();
                }
                $data['gift_cnt'] = $row['gift_cnt'];
                $data['sale_condition_s'] = $row['sale_condition_s'];
                $data['sale_condition_e'] = $row['sale_condition_e'];
                $data['fg_ix'] = $row['fg_ix'];
                if (!empty($prows)) {
                    foreach ($prows as $prow) {
                        $stock = $prow['stock'] - $prow['sell_ing_cnt'];
                        $status = $this->setStatus($prow['disp'], $prow['state'], $stock);
                        if ($stock > 0 && $status == 'sale') {
                            $data['gift_products'][$prow['id']] = [
                                'pid' => $prow['id']
                                , 'image_src' => get_product_images_src($prow['id'], $this->isUserAdult, $imageSizeType, $prow['is_adult']) //이미지
                                , 'pname' => $prow['pname']
                                , 'status' => $status
                                , 'stock' =>$stock
                            ];
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * 상품상세 데이터 출력
     * @param string $id
     * @param string $imageSizeType
     * @return array
     */
    public function get($id, $imageSizeType = 'm')
    {
        $datas = $this->basicSelect()
            ->select('p.id')
            ->select('p.pcode')
            ->select('p.brand')
            ->select('p.admin')
            ->select('p.pname')
            ->select('p.shotinfo')
            ->select('p.brand_name')
            ->select('d.dt_ix')
            ->select('cd.com_name')
            ->select('p.allow_basic_cnt')
            ->select('p.allow_byoneperson_cnt')
            ->select('p.basicinfo')
            ->select('p.m_basicinfo')
            ->select('p.mandatory_use')
            ->select('p.mandatory_use_global')
            ->select('p.reserve_yn')
            ->select('p.wholesale_rate_type')
			->select('p.rate_type')
            ->select('p.reserve')
            ->select('p.reserve_rate')
            ->select('p.movie')
            ->select('p.movie_thumbnail')
            ->select('p.movie_now')
            ->select('p.icons')
            ->select('p.add_info')
            ->select('p.product_type')
            ->select('r.cid')
            ->select('p.gift_selectbox_cnt')
            ->select('p.relation_text1')
            ->select('p.relation_text2')
            ->select('p.preface')
            ->select('p.after_score')
            ->select('p.after_cnt')
            ->select('p.is_delete')
			->select('p.laundry_cid')
            ->select('p.wear_info')
            ->select('p.c_preface')
            ->select('p.b_preface')
            ->select('p.i_preface')
            ->select('p.u_preface')
            ->select('p.gift_selectbox_nooption_yn')
            ->from(TBL_SHOP_PRODUCT . ' AS p')
            ->join(TBL_SHOP_PRODUCT_RELATION . ' AS r', 'p.id=r.pid', 'inner')
            ->join(TBL_SHOP_PRODUCT_DELIVERY . ' AS d', 'p.id=d.pid', 'inner')
            ->join(TBL_COMMON_COMPANY_DETAIL . ' AS cd', 'p.admin = cd.company_id', 'inner')
            ->where('p.id', $id)
            ->where('r.basic', 1)
            ->exec()->getResultArray();

        //상품 데이터 처리
        foreach ($datas as $key => $li) {
            $li['pname'] = stripslashes($li['pname']);
            //$li['image_src'] = get_product_images_src($li['id'], $this->isUserAdult, $imageSizeType, $li['is_adult']); //이미지
            $li['image_src'] = get_product_images_detail_src($li['id']); //이미지
            //$li['thumb_src'] = get_product_images_src($li['id'], $this->isUserAdult, 's', $li['is_adult']); // thumb이미지
            if($li['pattNum'] == 0){
                $li['thumb_src'] = get_product_images_src_new($li['id'], $this->isUserAdult, 'patt', $li['is_adult'], 0); // thumb이미지
            }else{
                $li['thumb_src'] = get_product_images_src_new($li['id'], $this->isUserAdult, 'patt', $li['is_adult'], $li['pattNum']-1); // thumb이미지
            }

            $li['big_image_src'] = get_product_images_src($li['id'], $this->isUserAdult, 'b', $li['is_adult']); // thumb이미지
            $li['add_image_src'] = $this->getAddImagesSrc($li['id'], $li['is_adult']); //추가이미지
            $li['status'] = $this->setStatus($li['disp'], $li['state'], $li['stock']); //판매 상태
            $li['product_gift'] = $this->getGift($li['id'], 's', $li['gift_selectbox_cnt']); // 사은품 정보

            /* @var $wishModel CustomMallWishModel */
            $wishModel = $this->import('model.mall.wish');
            // 위시 추가 여부
            $li['alreadyWish'] = $wishModel->checkAlreadyWish($li['id']);

            unset($li['state']);
            unset($li['disp']);

            //묶음 그룹 배송을 사용하는 배송정책의 경우 대표 배송정책으로 변경
            $deliveryGroup = $this->cartModel->getDeliveryGroup(array($li['dt_ix']));
            foreach ($deliveryGroup as $dg) {
                if (!empty($dg['target_dt_ix'])) {
                    $li['dt_ix'] = $dg['target_dt_ix'];
                    break;
                }
            }
            unset($deliveryGroup);

            if (is_mobile()) {
                if (!empty($li['m_basicinfo'])) { //상세정보
                    $li['basicinfo'] = $li['m_basicinfo'];
                }
            }
            unset($li['m_basicinfo']);

            $li['basicinfo'] = str_replace('&quot;', '\'', $li['basicinfo']);

            //아이콘
            if (!empty($li['icons'])) {
                $icons_exp = explode(';', $li['icons']);
                foreach ($icons_exp as $icons_key => $icons_val) {
                    $li['icons_path'][$icons_key] = "<img src='" . IMAGE_SERVER_DOMAIN . DATA_ROOT . "/images/icon/" . $icons_val . ".gif'>";
                }
            }

            $datas[$key] = $li;
        }

        $datas = $this->discount($datas); //할인 적용

        if (!empty($datas[0])) {


            /* @var $mileageModel CustomMallMileageModel */
            $mileageModel = $this->import('model.mall.mileage');
            $datas[0]['is_use_reserve'] = $mileageModel->isUseMileage();

            if(isset($this->categoryReserveYn[$datas[0]['id']]) && $this->categoryReserveYn[$datas[0]['id']] == true){
                $datas[0]['save_reserve'] = 0;
            }else {
                if ($datas[0]['is_use_reserve']) {
                    $datas[0]['save_reserve'] = $mileageModel->getSaveMileage(
                        $datas[0]['reserve_yn']
                        #, $datas[0]['wholesale_rate_type']
						, $datas[0]['rate_type']
                        #, ($datas[0]['wholesale_rate_type'] == '1' ? $datas[0]['reserve_rate'] : $datas[0]['reserve'])
						, ($datas[0]['rate_type'] == '1' ? $datas[0]['reserve_rate'] : $datas[0]['reserve'])
                        , $datas[0]['admin']
                        , $datas[0]['listprice']
                        , $datas[0]['dcprice']
                        , $datas[0]['dcprice']
                    );
                } else {
                    $datas[0]['save_reserve'] = 0;
                }
            }

            return $datas[0];
        } else {
            return;
        }
    }

    public function getAutocomplet($keyword)
    {
        if (constant('USE_ELASTICSERACH') === true) {
            return getAutocomplet($keyword);
        } else {
            return ["error" => "no search engin"];
        }
    }

    /**
     * 리스트 호출(상품리스트, 검색)
     * @param array $where
     * @param array $sort
     * @return array
     * 컬럼 표준명
     * 카테고리 = filterCid = r.cid
     * 브랜드 = filterBrands = p.brand (예시 : 1,2,3)
     * 무료배송 여부 = filterDeliveryFree = dt.delivery_policy
     * 상품명 = filterText
     */
    public function getList($filter = [], $page = 1, $max = 5, $sort = "p.regdate")
    {
        if (!empty($filter['product_filter'])) {
            $filter_idx_list = json_decode(urldecode($filter['product_filter']), true);
        } else {
            $filter_idx_list = [];
        }

        if(empty($max)){
            $max = 5;
        }

        if (isset($filter_idx_list) && !empty($filter_idx_list)) {

            $pidItem = $this->qb
                ->select('pid')
                ->from(TBL_SHOP_PRODUCT_FILTER_RELATION)
                ->whereIn('filter_idx', $filter_idx_list)
                ->exec()->getResultArray();

            $filterPidArray = array_column($pidItem, 'pid');
            $filterPidArray = array_unique($filterPidArray);
        } else {
            $filter_idx_list = array();
        }

        $this->qb->startCache();

        if (empty($filter['filterCid'])) {
            $this->qb
                ->where('basic', '1');
            $depth = false;
        } else {
            $depth = $this->getDepth($filter['filterCid']);
            $this->qb->like('r.cid', substr($filter['filterCid'], 0, 3 * ($depth + 1)), 'after');
        }

        if (!empty($filter_idx_list)) {
            if (!empty($filterPidArray)) {
                $this->qb
                    ->whereIn('p.id', $filterPidArray);
            } else {
                $this->qb
                    ->where('1', '2');
            }
        }

        if ((isset($filter['sprice']) && !empty($filter['sprice'])) || (isset($filter['eprice']) && !empty($filter['eprice']))) {
            $this->qb
                ->join('shop_product_search_price as psr', "psr.pid=p.id AND psr.mall_ix = '" . MALL_IX . "'")
                ->where('psr.price between "' . $filter['sprice'] . '"  and  "' . $filter['eprice'] . '" ');
        }

		/*
			2024-04-09
			shop_product table : markNum1, markNum2 필드 생성 
			연결되는 테이블 조인으로 연결 테이블명 markImg1, markImg1 필드 생성 연결
		*/

        $this->basicWhere($filter)
            ->from(TBL_SHOP_PRODUCT . ' p')
            ->join(TBL_SHOP_PRODUCT_DELIVERY . ' as pd', 'p.id=pd.pid', 'inner')
            ->join(TBL_SHOP_DELIVERY_TEMPLATE . ' as dt', 'pd.dt_ix=dt.dt_ix', 'inner')
            ->join(TBL_SHOP_PRODUCT_RELATION . ' as r', 'p.id=r.pid', 'left');
        $this->qb->stopCache();

        $total = $this->qb->getCount('DISTINCT p.id');

        $paging = $this->qb->setTotalRows($total)->pagination($page, $max);

        $this->qb->startCache();

        $this->qb
            ->distinct()
            ->select('p.id')
            ->select('(CASE  WHEN p.state in ("1","4") THEN '
                . '(CASE WHEN p.stock_use_yn IN ("Q","Y") THEN '
                . "(SELECT IFNULL(sum(if((pod.option_stock < pod.option_sell_ing_cnt),0,(pod.option_stock - pod.option_sell_ing_cnt))),0)"
                . " FROM " . TBL_SHOP_PRODUCT_OPTIONS . " as po, " . TBL_SHOP_PRODUCT_OPTIONS_DETAIL . " as pod WHERE po.opn_ix = pod.opn_ix AND po.option_use='1' AND pod.option_soldout!='1' AND po.pid=p.id"
                . " AND (po.option_kind != 's2' OR (po.option_kind='s2' AND pod.set_group_seq!=0 )) )"
                . ' ELSE 99999 END)'
                . ' ELSE 0 END) AS stock');

        $this->setOrderby($sort, $depth);

        $this->qb->stopCache();

        $sql1 = $this->qb
            ->having('stock > ', 0)
            ->toStr();

        $sql2 = $this->qb
            ->having('stock < ', 1)
            ->toStr();

        if ($paging['offset']) {
            $limit = $paging['offset'] . "," . $max;
        } else {
            $limit = $max;
        }

        $sql = "select * 
            from ( $sql1 ) as a1
            union all            
            select * 
            from ( $sql2 ) as a2 group by id limit " . $limit . " ";

        $list = $this->qb->exec($sql)->getResultArray();
        $this->qb->flushCache();

        //$list = array_unique($list, SORT_REGULAR); //중복 ID 제거 품절 상품 뒤로 배치 하게 되면서 GROUP by 문제로 배열에서 제거 처리

        return [
            'total' => $total,
            'list' => $this->getListById(array_column($list, 'id')),
            'paging' => $paging
        ];
    }

    /**
     * elastic search 전용
     * USE_ELASTICSERACH false 일때는 원래 메소드 사용
     * @param type $filter
     * @param type $page
     * @param type $max
     * @param type $sort
     * @return type
     */
    public function getSearchList($filter = [], $page = 1, $max = 5, $sort = "")
    {
        //elasticserach 에서 pid 값 리턴이 있을경우
        if (constant('USE_ELASTICSERACH') === true) {
            $filter_option = [];
            if (isset($filter['filterText']) && $filter['filterText']) {
                if (BASIC_LANGUAGE == "korean") {
                    $sResult = getSearchResult($filter['filterText']); //elasticserach 검색
                    //$filter_option = $sResult['filter_option'];
                } else {
                    $sResult = getSearchResultGlobal($filter['filterText']); //elasticserach 검색
					
                }
            } else {
                $sResult['pid'] = [];
            }

			

            $esResult = $sResult['pid']; //기본 검색조건만 넣음
            $is_filter = false;
            $fResult = [];
            //필터 조건이 있는 경우
            if (!empty($filter['product_filter']) || (isset($filter['sprice']) && !empty($filter['sprice'])) || (isset($filter['eprice']) && !empty($filter['eprice']))) {
                $filter['es_pid'] = $esResult;
                if (BASIC_LANGUAGE == "korean") {
                    $fResult = getSearchFilterResult($filter); //elasticserach  filter 검색
                } else {
                    $fResult = getSearchFilterResultGlobal($filter); //elasticserach  filter 검색
                }
                $is_filter = true;
            }



            if($is_filter){
                $esResult = $fResult["pid"] ?? [];
            }

            //결과내 검색 키워드가 있으면 다시 검색
            if (isset($filter['filterInsideText']) && $filter['filterInsideText'] && count($esResult) > 0) {
                //검색 + 키워드로 유추된 pid 리스트가 반드시 들어가고, 검색어가 일치하는것
                if (BASIC_LANGUAGE == "korean") {
                    $totalResult = getMoreSearchResult($esResult, $filter['filterInsideText']);
                    //$filter_option = $totalResult['filter_option'];
                    if ($totalResult["total"] > 0) {
                        $esResult = $totalResult['pid'];
                    } else {
                        $esResult = [];
                    }
                } else {
                    $totalResult = getMoreSearchResultGlobal($esResult, $filter['filterInsideText']);
                    if ($totalResult["total"] > 0) {
                        $esResult = $totalResult['pid'];
                    } else {
                        $esResult = [];
                    }
                }
            }

            if (count($esResult) <= 0) {
                $esResult = [-1]; //조건이 안맞으면 없는 상품 검색
            }

            $this->qb->startCache();
            $this->qb
                ->whereIn("p.id", $esResult);
            $this->basicWhere($filter)
                ->from(TBL_SHOP_PRODUCT . ' p')
                ->join(TBL_SHOP_PRODUCT_DELIVERY . ' as pd', 'p.id=pd.pid', 'inner')
                ->join(TBL_SHOP_DELIVERY_TEMPLATE . ' as dt', 'pd.dt_ix=dt.dt_ix', 'inner')
                ->join(TBL_SHOP_PRODUCT_RELATION . ' as r', 'p.id=r.pid', 'left');

            $this->qb->stopCache();

            $total = $this->qb->getCount('DISTINCT p.id');

            $paging = $this->qb->setTotalRows($total)->pagination($page, $max);

            $this->qb->startCache();

            $this->qb
                ->distinct()
                ->select('p.id')
                ->select('(CASE p.state WHEN "1" THEN '
                    . '(CASE WHEN p.stock_use_yn IN ("Q","Y") THEN '
                    . "(SELECT IFNULL(sum(if((pod.option_stock < pod.option_sell_ing_cnt),0,(pod.option_stock - pod.option_sell_ing_cnt))),0)"
                    . " FROM " . TBL_SHOP_PRODUCT_OPTIONS . " as po, " . TBL_SHOP_PRODUCT_OPTIONS_DETAIL . " as pod WHERE po.opn_ix = pod.opn_ix AND po.option_use='1' AND pod.option_soldout!='1' AND po.pid=p.id"
                    . " AND (po.option_kind != 's2' OR (po.option_kind='s2' AND pod.set_group_seq!=0 )) )"
                    . ' ELSE 99999 END)'
                    . ' ELSE 0 END) AS stock');

            $this->setOrderby($sort);

            if ($sort == 'afterCnt') {
                //후기순일 때 후기수가 같은 상품 등록일 내림차순으로 정렬
                $this->qb->orderBy("p.regdate", "DESC");
            }

            $this->qb->stopCache();

            $sql1 = $this->qb
                ->groupBy('p.id')
                ->having('stock > ', 0)
                ->toStr();

            $sql2 = $this->qb
                ->groupBy('p.id')
                ->having('stock < ', 1)
                ->toStr();

            if ($paging['offset']) {
                $limit = $paging['offset'] . "," . $max;
            } else {
                $limit = $max;
            }

            $sql = "select * 
            from ( $sql1 ) as a1
            union all            
            select * 
            from ( $sql2 ) as a2 limit " . $limit . " ";



            $list = $this->qb->exec($sql)->getResultArray();


            $this->qb->flushCache();

            $list = array_unique($list, SORT_REGULAR); //중복 ID 제거 품절 상품 뒤로 배치 하게 되면서 GROUP by 문제로 배열에서 제거 처리

            return [
                'total' => $total,
                'list' => $this->getListById(array_column($list, 'id')),
                'filter' => $filter_option,
                'paging' => $paging
            ];
        } else {
			
            //사용하지 않으면 원래 메소드로 전달
            //return $this->getList($filter, $page, $max, $sort);
            return ['total' => 0, 'list' => [], 'paging' => [], 'info' => 'no elastic use'];
        }
    }

    /**
     * get 상품아이디로 상품정보 리턴
     * @param array $ids
     * @param string $imageSizeType
     * @param array $addSelect
     * @return string
     */
    public function getListById($ids = [], $imageSizeType = 'ms', $addSelect = [])
    {
        if (empty($ids)) {
            return [];
        }

        //추가 select 처리
        if (!empty($addSelect) && is_array($addSelect)) {
            foreach ($addSelect as $select) {
                $this->qb->select($select);
            }
        }

        $list = $this->basicSelect()
            ->select('p.id')
            ->select('p.pname')
            ->select('p.brand_name')
            ->select('p.icons')
            ->select('p.add_info')
            ->select('p.gift_selectbox_cnt')
            ->select('p.b_preface')
            ->select('p.c_preface')
            ->select('p.i_preface')
            ->select('p.u_preface')
            ->select('p.listNum')
            ->select('p.overNum')
            ->select('p.slistNum')
            ->select('p.nailNum')
            ->select('p.pattNum')
			->select('r.cid')
            ->from(TBL_SHOP_PRODUCT . ' AS p')
			->join(TBL_SHOP_PRODUCT_RELATION . ' AS r', 'p.id=r.pid', 'inner')
            ->whereIn('p.id', $ids)
            ->whereIn('mall_ix', ['', MALL_IX])
			->where('r.basic', 1)
            ->exec()
            ->getResultArray();

        if (!empty($list)) {
            /* @var $wishModel CustomMallWishModel */
            $wishModel = $this->import('model.mall.wish');

            //ids 에 넘긴 순서대로 정렬
            $list = $this->sortList($ids, $list, 'id');

            //할인 적용
            $list = $this->discount($list);

            $z = 1;
            //상품 데이터 처리
            foreach ($list as $key => $li) {
                //이미지
                $li['pname'] = html_entity_decode(stripslashes($li['pname']), ENT_QUOTES);
                if($imageSizeType == 'slist'){
                    if($li['slistNum'] == 0){
                        $li['image_src'] = get_product_images_src_new($li['id'], $this->isUserAdult, 'slist', $li['is_adult'], 0);
                    }else{
                        $li['image_src'] = get_product_images_src_new($li['id'], $this->isUserAdult, 'slist', $li['is_adult'], $li['slistNum']-1);
                    }
                }else{
                    if($li['listNum'] == 0){
                        $li['image_src'] = get_product_images_src_new($li['id'], $this->isUserAdult, 'list', $li['is_adult'], 0);
                    }else{
                        $li['image_src'] = get_product_images_src_new($li['id'], $this->isUserAdult, 'list', $li['is_adult'], $li['listNum']-1);
                    }
                    if($li['overNum'] == 0){
                        $li['image_src2'] = get_product_images_src_new($li['id'], $this->isUserAdult, 'over', $li['is_adult'], 2);
                    }else{
                        $li['image_src2'] = get_product_images_src_new($li['id'], $this->isUserAdult, 'over', $li['is_adult'], $li['overNum']-1);
                    }
                }
                /*
                    $li['image_src'] = get_product_images_src($li['id'], $this->isUserAdult, $imageSizeType, $li['is_adult']);
                */
                $status = $this->setStatus($li['disp'], $li['state'], $li['stock']);
                $li['status'] = $status;
                $li['is_soldout'] = $status == 'soldout' ? true : false;
                unset($li['state']);
                unset($li['disp']);
                $li['isDiscount'] = false;
                $li['isPercent'] = false;
                $li['number'] = $z;
                if ($li['listprice'] > $li['dcprice']) {
                    $li['isDiscount'] = true;
                    $product_percent_display = ForbizConfig::getMallConfig('product_percent_display');
                    if ($product_percent_display == 'Y') {
                        $li['isPercent'] = true;
                    }
                }
                // 위시 추가 여부
                $li['alreadyWish'] = $wishModel->checkAlreadyWish($li['id']);

				$preface = explode("_",$li['preface']);

				$li['prefaceName']  = $preface[0];
				$li['prefaceColor'] = $li['c_preface'];

                if($li['b_preface'] == "Y"){
                    $li['b_preface']    = "font-weight: bold;";
                }else{
                    $li['b_preface']    = "";
                }

                if($li['i_preface'] == "Y"){
                    $li['i_preface']    = "font-style:oblique;";
                }else{
                    $li['i_preface']    = "";
                }

                if($li['u_preface'] == "Y"){
                    $li['u_preface']    = "text-decoration-line: underline;";
                }else{
                    $li['u_preface']    = "";
                }

                // 사은품
                $li['product_gift'] = $this->getGift($li['id'], 's', $li['gift_selectbox_cnt']);

                //아이콘
                if (!empty($li['icons'])) {
                    $icons_exp = explode(';', $li['icons']);
                    foreach ($icons_exp as $icons_key => $icons_val) {
                        $li['icons_path'][$icons_key] = "<img src='" . IMAGE_SERVER_DOMAIN . DATA_ROOT . "/images/icon/" . $icons_val . ".gif'>";
                    }
                }

                //타임세일 아이콘 출력 처리
                $discountView = false;
                if(is_array($li['discountList'])){
                    foreach($li['discountList'] as $k=>$v){
                        if ($v['type'] == 'GP') {
                            if (isset($v['sDate']) && isset($v['eDate']) && !empty($v['sDate']) && !empty($v['eDate'])) {
                                $sDate = $v['sDate'];
                                $eDate = $v['eDate'];
                                if (time() >= strtotime($sDate) && time() > strtotime($eDate)) {
                                    $discountView = true;
                                }
                            }
                        }
                        //추가할인의 타임세일이 적용되어 있을 경우 기존 타임세일 정보는 추가할인의 타임세일 정보로 교체 한다.
                        if ($v['type'] == 'SP') {
                            if (isset($v['sDate']) && isset($v['eDate']) && !empty($v['sDate']) && !empty($v['eDate'])) {
                                $sDate = $v['sDate'];
                                $eDate = $v['eDate'];

                                if (time() >= strtotime($sDate) && time() > strtotime($eDate)) {
                                    $discountView = true;
                                }
                            }
                        }
                    }
                }

                //타임세일 아이콘 노출 설정
                if($discountView == true){
                    $basicPath = DATA_ROOT . "/images";
                    $domain = (!empty(IMAGE_SERVER_DOMAIN) ? IMAGE_SERVER_DOMAIN : HTTP_PROTOCOL . FORBIZ_HOST );

                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $basicPath."/time_sale.png")) {
                        $li['timeSaleIcon'] =  $domain . $basicPath."/time_sale.png";
                        $li['timeSaleIconView'] = $discountView;
                    }else{
                        $li['timeSaleIconView'] = false;
                    }
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $basicPath."/time_sale_mobile.png")) {
                        $li['timeSaleIconM'] =  $domain . $basicPath."/time_sale_mobile.png";
                        $li['timeSaleIconViewM'] = $discountView;
                    }else{
                        $li['timeSaleIconViewM'] = false;
                    }
                }


                $list[$key] = $li;
                $z++;
            }
        }

        return $list;
    }

    /**
     * get 상품아이디로 상품정보 리턴
     * @param array $ids
     * @param string $imageSizeType
     * @param array $addSelect
     * @return string
     */
    public function getListBySingleId($pid, $imageSizeType = 'm', $addSelect = [])
    {
        if (empty($pid)) {
            return '';
        }

        //추가 select 처리
        if (!empty($addSelect) && is_array($addSelect)) {
            foreach ($addSelect as $select) {
                $this->qb->select($select);
            }
        }

        $list = $this->basicSelect()
            ->select('p.id')
            ->select('p.pname')
            ->select('p.brand_name')
            ->select('p.icons')
            ->select('p.add_info')
            ->select('p.gift_selectbox_cnt')
            ->from(TBL_SHOP_PRODUCT . ' p')
            ->where('p.id', $pid)
            ->exec()
            ->getResultArray();

        if (!empty($list)) {
            /* @var $wishModel CustomMallWishModel */
            $wishModel = $this->import('model.mall.wish');


            //할인 적용
            $list = $this->discount($list);


            //상품 데이터 처리
            foreach ($list as $key => $li) {
                //이미지
                $li['image_src'] = get_product_images_src($li['id'], $this->isUserAdult, $imageSizeType, $li['is_adult']);
                $status = $this->setStatus($li['disp'], $li['state'], $li['stock']);
                $li['status'] = $status;
                $li['is_soldout'] = $status == 'soldout' ? true : false;
                unset($li['state']);
                unset($li['disp']);
                $li['isDiscount'] = false;
                $li['isPercent'] = false;
                if ($li['listprice'] > $li['dcprice']) {
                    $li['isDiscount'] = true;
                    $product_percent_display = ForbizConfig::getMallConfig('product_percent_display');
                    if ($product_percent_display == 'Y') {
                        $li['isPercent'] = true;
                    }
                }
                // 위시 추가 여부
                $li['alreadyWish'] = $wishModel->checkAlreadyWish($li['id']);

                // 사은품
                $li['product_gift'] = $this->getGift($li['id'], 's', $li['gift_selectbox_cnt']);

                //아이콘
                if (!empty($li['icons'])) {
                    $icons_exp = explode(';', $li['icons']);
                    foreach ($icons_exp as $icons_key => $icons_val) {
                        $li['icons_path'][$icons_key] = "<img src='" . IMAGE_SERVER_DOMAIN . DATA_ROOT . "/images/icon/" . $icons_val . ".gif'>";
                    }
                }

                $list[$key] = $li;
            }
        }

        return $list[0];
    }

    /**
     * 특정 카테고리 데이터 전체 호출
     * @param string $cid
     * @return array
     */
    public function getCategoryNavigationReviewList()
    {
        $this->qb
            ->select('cid, cname, depth')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->where('depth', '1')
            ->where('vlevel1', '0');

        $datas = $this->qb->exec()->getResultArray();

        return $datas;
    }

    /**
     * 기획전 호출
     * @param string $id
     * @return array
     */
    public function getRelationPromotionAll()
    { //기획전만
        $datas = $this->qb
            ->select('e.event_ix')
            ->select('e.event_title')
            ->from(TBL_SHOP_EVENT . ' as e ')
            ->where('e.disp', 1)
            ->where('e.kind', 'D')
            ->where(time() . ' BETWEEN event_use_sdate AND event_use_edate ')
            ->groupBy('e.event_ix')
            ->exec()->getResultArray();
        return $datas;
    }

    /**
     * depth 계산
     * @param string $cid
     * @return int
     */
    public function getDepth($cid)
    {
        // 상품 최상이 카테고리
        $kind = ForbizConfig::getProductTopKind();
        $cid = $kind[$cid] ?? $cid;

        $depth = 0;
        $cid_array = str_split($cid, 3);
        foreach ($cid_array as $k => $v) {
            if ($v == '000' && $k > 0) {// cid : 0001002003000000 일 경우 003 이하는 루프돌지 않도록 처리함
                break;
            } else {
                $depth = $k;
            }
        }
        return $depth;
    }

    /**
     * 하위 카테고리 추출
     * @param string $cid 현재 카테고리 ID
     * @return array
     */
    public function getSubCategory($cid)
    {
        // 상품 최상이 카테고리
        $kind = ForbizConfig::getProductTopKind();
        $cid = $kind[$cid] ?? $cid;

        $subCid = '';
        foreach (str_split($cid, 3) as $k => $v) {
            if ($v == '000' && $k > 0) {
                $subCid .= '001';
                break;
            }

            $subCid .= $v;
        }

        $subCate = $this->getCategoryNavigationList($subCid);

        return isset($subCate[1]) ? $subCate[1] : [];
    }

    /**
     * 상품의 기본 카테고리 정보
     * @param string $pid
     * @return array
     */
    public function getBasicCategory($pid)
    {
        $basicCategory = [
            'cid' => '',
            'subCid' => ''
        ];

        $row = $this->qb
            ->select('cid')
            ->from(TBL_SHOP_PRODUCT_RELATION)
            ->where('pid', $pid)
            ->where('basic', 1)
            ->exec()
            ->getRowArray();

        if (isset($row['cid'])) {
            $basicCategory['cid'] = ForbizConfig::getProductTopKind(substr($row['cid'], 0, 3) . '000000000000', 'key');
            $basicCategory['subCid'] = $row['cid'];
        }

        return $basicCategory;
    }

    /**
     * 인기검색어 추출
     * @return array
     */
    public function getPopularSearches($limit, $offset)
    {
        $datas = $this->qb
            ->select('keyword')
            ->from(TBL_SHOP_SEARCH_KEYWORD)
            ->where('recommend', '0')
            ->orderBy('searchcnt', 'DESC')
            ->limit($limit, $offset)
            ->exec()->getResultArray();

        return $datas;
    }

    /**
     * 검색어태그 추출
     * @return array
     */
    public function getSearchesTag()
    {
        $datas = $this->qb
            ->select('st_title')
            ->select('st_url')
            ->from('shop_search_text')
            ->exec()->getResultArray();

        return $datas;
    }

    /**
     * 상품 기본 select
     * @return qb
     */
    public function basicSelect()
    {
        if ($this->sellingType == 'W') {
            //도매
            $this->qb
                ->select('p.wholesale_price as listprice');
            if ($this->displayPriceType == 'L') {
                $this->qb
                    ->select('p.wholesale_price as sellprice')
                    ->select('p.wholesale_price as dcprice');
            } else {
                $this->qb
                    ->select('p.wholesale_sellprice as sellprice')
                    ->select('p.wholesale_sellprice as dcprice');
            }
        } else {
            //소매
            $this->qb
                ->select('p.listprice');
            if ($this->displayPriceType == 'P') {
                $this->qb
                    ->select('p.sellprice')
                    ->select('p.premiumprice as dcprice');
            } else if ($this->displayPriceType == 'L') {
                $this->qb
                    ->select('p.listprice as sellprice')
                    ->select('p.listprice as dcprice');
            } else {
                $this->qb
                    ->select('p.sellprice')
                    ->select('p.sellprice as dcprice');
            }
        }
        return $this->qb
            ->select('p.state')
            ->select('p.disp')
            ->select('p.is_adult')
            ->select('p.preface')
            ->select('(CASE p.state WHEN "1" THEN '
                . '(CASE WHEN p.stock_use_yn IN ("Q","Y") THEN '
                . "(SELECT IFNULL(sum(if((pod.option_stock < pod.option_sell_ing_cnt),0,(pod.option_stock - pod.option_sell_ing_cnt))),0)"
                . " FROM " . TBL_SHOP_PRODUCT_OPTIONS . " as po, " . TBL_SHOP_PRODUCT_OPTIONS_DETAIL . " as pod WHERE po.opn_ix = pod.opn_ix AND po.option_use='1' AND pod.option_soldout!='1' AND po.pid=p.id"
                . " AND (po.option_kind != 's2' OR (po.option_kind='s2' AND pod.set_group_seq!=0 )) )"
                . ' ELSE 99999 END)'
                . ' ELSE 0 END) AS stock');
    }

    /**
     * 상품의 카테고리 Cname 정보
     * @param string $cid
     * @return array
     */
    public function getProductCategoryCnames($cid)
    {
        $catCnames = [];

        $cate['0'] = substr($cid, 0, 3);
        $cate['1'] = substr($cid, 0, 6);
        $cate['2'] = substr($cid, 0, 12);

        for ($i = 0; $i < 3; $i++) {
            $row = $this->qb
                ->select('cname')
                ->from(TBL_SHOP_CATEGORY_INFO)
                ->where('depth', $i)
                ->like('cid', $cate[$i], 'after')
                ->exec()
                ->getRowArray();
            $catCnames[$i] = $row['cname'];
        }

        return $catCnames;
    }

    /**
     * 네이버페이 정보
     * @return array
     */
    public function getNpayInfo()
    {
        $npayInfo = [];

        $datas = $this->qb
            ->select('config_name as key, config_value as value')
            ->from(TBL_SHOP_MALL_CONFIG)
            ->wherein('config_name', ['naverpay_button_key', 'naverpay_ep', 'naverpay_id', 'naverpay_key', 'naverpay_type', 'naverpay_yn'])
            ->exec()->getResultArray();

        foreach ($datas as $p => $v) {
            $npayInfo[$v['key']] = $v['value'];
        }

        return $npayInfo;
    }

    /**
     * 네이버페이 정보
     * @return array
     */
    public function getNpayProductsInfo($pIds)
    {

        $datas = $this->qb
            ->select('p.id as pid, p.pname, p.product_type')
            ->select('o.opn_ix, o.option_kind, o.option_type, o.option_name')
            ->select('d.id AS opd_ix, d.option_div, d.option_color, d.option_size, d.set_group, d.set_group_seq, d.option_code, d.option_gid, d.option_listprice, d.option_price, d.option_stock')
            ->from(TBL_SHOP_PRODUCT . ' AS p')
            ->join(TBL_SHOP_PRODUCT_OPTIONS . ' AS o', 'p.id = o.pid', 'inner')
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS d', 'o.opn_ix = d.opn_ix', 'left')
            ->wherein('p.id', $pIds)
            ->orderby('p.id, o.option_kind')
            ->exec()->getResultArray();

        return $datas;
    }

    /**
     * 특정 카테고리 최상위 부터 최하위 데이터 전체 호출
     * @param string $cid
     * @return array
     */
    public function getTopCategoryInList($cid)
    {
        $this->qb
            ->select('cid, cname, depth, vlevel2, vlevel3, global_cinfo, is_layout_emphasis')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->whereIn('category_use', [1,2])
            ->like('cid', substr($cid, 0, 3), 'after')
            ->orderBy('vlevel1, vlevel2, vlevel3, vlevel4, vlevel5', 'asc');

        $datas = $this->qb->exec()->getResultArray();

        if (!empty(BASIC_LANGUAGE) && BASIC_LANGUAGE != 'korean') {
            if (!empty($datas)) {
                foreach ($datas as $key => $val) {
                    $global_cinfo = json_decode($val['global_cinfo'], true);
                    $datas[$key]['cname'] = urldecode($global_cinfo['cname'][BASIC_LANGUAGE]);
                }
            }
        }
        return $datas;
    }

    /**
     * 특정 카테고리 최상위 부터 최하위 데이터 전체 호출(모바일용)
     * @param string $cid
     * @return array
     */
    public function getTopCategoryTitle($cid)
    {
        $this->qb
            ->select('cid, cname, depth, vlevel2, vlevel3, global_cinfo, is_layout_emphasis')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->whereIn('category_use', [1,2])
            ->where('depth',0)
            ->like('cid', substr($cid, 0, 3), 'after')
            ->orderBy('vlevel1, vlevel2, vlevel3, vlevel4, vlevel5', 'asc');

        $datas = $this->qb->exec()->getResultArray();

        if (!empty(BASIC_LANGUAGE) && BASIC_LANGUAGE != 'korean') {
            if (!empty($datas)) {
                foreach ($datas as $key => $val) {
                    $global_cinfo = json_decode($val['global_cinfo'], true);
                    $datas[$key]['cname'] = urldecode($global_cinfo['cname'][BASIC_LANGUAGE]);
                }
            }
        }
        return $datas;
    }

    /**
     * 특정 카테고리 최상위 부터 최하위 데이터 전체 호출(모바일용)
     * @param string $cid
     * @return array
     */
    public function getTopCategoryMoList($cid)
    {
        /*$subCid0 = substr($cid, 0, 3);
        $subCid1 = substr($cid, 3, 3);
        $subCid2 = substr($cid, 6, 3);
        $subCid3 = substr($cid, 9, 3);
        $subCid4 = substr($cid, 12, 3);

        if($subCid1 == "000"){
            $subCid = $subCid0;
        }else{
            if($subCid2 == "000"){
                $subCid = $subCid0.$subCid1;
            }else{
                if($subCid3 == "000"){
                    $subCid = $subCid0.$subCid1.$subCid2;
                }else{
                    if($subCid4 == "000"){
                        $subCid = $subCid0.$subCid1.$subCid2.$subCid3;
                    }else{
                        $subCid = $subCid0.$subCid1.$subCid2.$subCid3.$subCid4;
                    }
                }
            }
        }*/

        $this->qb
            ->select('cid, cname, depth, vlevel2, vlevel3, global_cinfo, is_layout_emphasis')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->whereIn('category_use', [1,2])
            ->where('depth',0)
            ->like('cid', substr($cid, 0, 3), 'after')
            ->orderBy('vlevel1, vlevel2, vlevel3, vlevel4, vlevel5', 'asc');

        $datas = $this->qb->exec()->getResultArray();

        if (!empty(BASIC_LANGUAGE) && BASIC_LANGUAGE != 'korean') {
            if (!empty($datas)) {
                foreach ($datas as $key => $val) {
                    $global_cinfo = json_decode($val['global_cinfo'], true);
                    $datas[$key]['cname'] = urldecode($global_cinfo['cname'][BASIC_LANGUAGE]);
                }
            }
        }
        return $datas;
    }

    /**
     * 카테고리 경로 데이터
     * @param string $cid
     * @param int $depth
     * @return array
     */
    public function getCategoryPath($cid, $depth)
    {
        $this->qb
            ->select('cname, cid, depth,global_cinfo')
            ->from(TBL_SHOP_CATEGORY_INFO);

        for ($i = 0; $i <= $depth; $i++) {
            $this->qb
                ->orGroupStart()
                ->like('cid', substr($cid, 0, 3 * ($i + 1)), 'after')
                ->where('depth', $i)
                ->groupEnd();
        }
        $datas = $this->qb->exec()->getResultArray();

        if (!empty(BASIC_LANGUAGE) && BASIC_LANGUAGE != 'korean') {
            if (!empty($datas)) {
                foreach ($datas as $key => $val) {
                    $global_cinfo = json_decode($val['global_cinfo'], true);
                    $datas[$key]['cname'] = urldecode($global_cinfo['cname'][BASIC_LANGUAGE]);
                }
            }
        }
        return $datas;
    }

    /**
     * @return mixed
     * 카테고리별 회원할인 사용 여부 체크
     */
    protected function setDiscountCategoryYn(){
        if($this->userInfo->gp_ix != '' && $this->userInfo->code != ''){
            $data = $this->qb
                ->select('use_discount_category_yn')
                ->from(TBL_SHOP_GROUPINFO)
                ->where('gp_ix',$this->userInfo->gp_ix)
                ->exec()->getRowArray();

            return $data['use_discount_category_yn'];
        }
    }

    /**
     * @return mixed
     * 카테고리별 회원할인 사용 시 해당 카테고리 상품에 대한 마일리지 적립 여부 체크
     */
    protected function setDiscountCategoryMileageYn(){
        if($this->userInfo->gp_ix != '' && $this->userInfo->code != ''){
            $data = $this->qb
                ->select('use_discount_category_mileage_yn')
                ->from(TBL_SHOP_GROUPINFO)
                ->where('gp_ix',$this->userInfo->gp_ix)
                ->exec()->getRowArray();

            return $data['use_discount_category_mileage_yn'];
        }
    }

    /**
     * set discountData
     * @param array $ids
     */
    protected function setDiscountData($ids)
    {
        foreach ($ids as $id) {
            $this->discountData[$id] = [];
        }

        //카테고리별 회원할인 사용 여부 체크
        if (defined('IS_EVENT_CATEGORY_SALE_USE') && IS_EVENT_CATEGORY_SALE_USE === true) {
            $discountCategoryYn = $this->setDiscountCategoryYn();
        }else{
            $discountCategoryYn = 'N';
        }

        //카테고리별 회원할인 사용 시 해당 카테고리 상품에 대한 마일리지 적립 여부 체크
        if($discountCategoryYn == 'Y'){
            $discountCategoryMileageYn = $this->setDiscountCategoryMileageYn();
        }else{
            $discountCategoryMileageYn = "N";
        }


        //기획&특별&모바일(GP:기획,SP:특별,M:모바일)
        $sql = [];

        //전체상품
        $sql[] = $this->qb
            ->select('p.id AS pid')
            ->select('d.discount_type')
            ->select('dpg.dpg_ix')
            ->select('dpg.discount_sale_type')
            ->select('dpg.sale_rate')
            ->select('dpg.headoffice_rate')
            ->select('dpg.seller_rate')
            ->select('dpg.commission')
            ->select('d.use_time')
            ->select('d.discount_use_sdate')
            ->select('d.discount_use_edate')
            ->select('dpg.coupon_use_yn')
            ->from(TBL_SHOP_DISCOUNT . ' as d')
            ->join(TBL_SHOP_DISCOUNT_PRODUCT_GROUP . ' as dpg', 'd.dc_ix = dpg.dc_ix')
            ->join(TBL_SHOP_PRODUCT . ' as p', "p.id IN ('" . implode("','", $ids) . "')")
            ->where('dpg.goods_display_type', 'A')//전체상품
            ->where('discount_use_sdate <=', time(), false)
            ->where('discount_use_edate >=', time(), false)
            ->where('d.is_use', '1')
            ->where('dpg.is_display', 'Y')
            ->whereIn('d.mall_ix', ['', MALL_IX])
            ->toStr();

        //특정상품
        $sql[] = $this->qb
            ->select('dpr.pid')
            ->select('d.discount_type')
            ->select('dpg.dpg_ix')
            ->select('dpg.discount_sale_type')
            ->select('dpg.sale_rate')
            ->select('dpg.headoffice_rate')
            ->select('dpg.seller_rate')
            ->select('dpg.commission')
            ->select('d.use_time')
            ->select('d.discount_use_sdate')
            ->select('d.discount_use_edate')
            ->select('dpg.coupon_use_yn')
            ->from(TBL_SHOP_DISCOUNT . ' as d')
            ->join(TBL_SHOP_DISCOUNT_PRODUCT_GROUP . ' as dpg', 'd.dc_ix = dpg.dc_ix')
            ->join(TBL_SHOP_DISCOUNT_PRODUCT_RELATION . ' as dpr', 'd.dc_ix = dpr.dc_ix and dpg.group_code = dpr.group_code')
            ->where('dpg.goods_display_type', 'M')//특정 상품
            ->where('discount_use_sdate <=', time(), false)
            ->where('discount_use_edate >=', time(), false)
            ->where('d.is_use', '1')
            ->where('dpg.is_display', 'Y')
            ->whereIn('dpr.pid', $ids)
            ->whereIn('d.mall_ix', ['', MALL_IX])
            ->toStr();

        //제외상품
        $sql[] = $this->qb
            ->select('p.id as pid')
            ->select('d.discount_type')
            ->select('d.dpg_ix')
            ->select('d.discount_sale_type')
            ->select('d.sale_rate')
            ->select('d.headoffice_rate')
            ->select('d.seller_rate')
            ->select('d.commission')
            ->select('d.use_time')
            ->select('d.discount_use_sdate')
            ->select('d.discount_use_edate')
            ->select('d.coupon_use_yn')
            ->from(TBL_SHOP_PRODUCT . ' as p')
            ->join($this->qb->startSubQuery('d')
                ->select('d.dc_ix')
                ->select('dpg.group_code')
                ->select('d.discount_type')
                ->select('dpg.dpg_ix')
                ->select('dpg.discount_sale_type')
                ->select('dpg.sale_rate')
                ->select('dpg.headoffice_rate')
                ->select('dpg.seller_rate')
                ->select('dpg.commission')
                ->select('d.use_time')
                ->select('d.discount_use_sdate')
                ->select('d.discount_use_edate')
                ->select('dpg.coupon_use_yn')
                ->from(TBL_SHOP_DISCOUNT . ' as d')
                ->join(TBL_SHOP_DISCOUNT_PRODUCT_GROUP . ' as dpg', 'd.dc_ix = dpg.dc_ix')
                ->where('dpg.goods_display_type', 'ME')//특정 상품
                ->where('discount_use_sdate <=', time(), false)
                ->where('discount_use_edate >=', time(), false)
                ->where('d.is_use', '1')
                ->where('dpg.is_display', 'Y')
                ->whereIn('d.mall_ix', ['', MALL_IX])
                ->endSubQuery(), "p.id IN ('" . implode("','", $ids) . "')")
            ->where('p.id NOT IN ( SELECT dpr.pid FROM ' . TBL_SHOP_DISCOUNT_PRODUCT_RELATION . ' as dpr WHERE dpr.dc_ix = d.dc_ix and dpr.group_code = d.group_code)')
            ->toStr();

        //상품분류
        $sql[] = $this->qb
            ->select('pr.pid')
            ->select('d.discount_type')
            ->select('dpg.dpg_ix')
            ->select('dpg.discount_sale_type')
            ->select('dpg.sale_rate')
            ->select('dpg.headoffice_rate')
            ->select('dpg.seller_rate')
            ->select('dpg.commission')
            ->select('d.use_time')
            ->select('d.discount_use_sdate')
            ->select('d.discount_use_edate')
            ->select('dpg.coupon_use_yn')
            ->from(TBL_SHOP_DISCOUNT . ' as d')
            ->join(TBL_SHOP_DISCOUNT_PRODUCT_GROUP . ' as dpg', 'd.dc_ix = dpg.dc_ix')
            ->join(TBL_SHOP_PRODUCT_RELATION . ' as pr', "pr.cid !='000000000000000'")
            ->join(TBL_SHOP_DISCOUNT_DISPLAY_RELATION . ' as ddr', "ddr.dc_ix = d.dc_ix and ddr.group_code = dpg.group_code AND ddr.relation_type='C' AND pr.cid LIKE CONCAT(LEFT(ddr.r_ix,(INSTR(ddr.r_ix,'000')-1)),'%')")
            ->where('dpg.goods_display_type', 'C')//상품분류
            ->where('discount_use_sdate <=', time(), false)
            ->where('discount_use_edate >=', time(), false)
            ->where('d.is_use', '1')
            ->where('dpg.is_display', 'Y')
            ->whereIn('pr.pid', $ids)
            ->whereIn('d.mall_ix', ['', MALL_IX])
            ->toStr();

        //상품분류 제외
        $sql[] = $this->qb
            ->select('pr.pid')
            ->select('d.discount_type')
            ->select('d.dpg_ix')
            ->select('d.discount_sale_type')
            ->select('d.sale_rate')
            ->select('d.headoffice_rate')
            ->select('d.seller_rate')
            ->select('d.commission')
            ->select('d.use_time')
            ->select('d.discount_use_sdate')
            ->select('d.discount_use_edate')
            ->select('d.coupon_use_yn')
            ->from(TBL_SHOP_PRODUCT_RELATION . ' as pr')
            ->join($this->qb->startSubQuery('d')
                ->select('d.dc_ix')
                ->select('dpg.group_code')
                ->select('d.discount_type')
                ->select('dpg.dpg_ix')
                ->select('dpg.discount_sale_type')
                ->select('dpg.sale_rate')
                ->select('dpg.headoffice_rate')
                ->select('dpg.seller_rate')
                ->select('dpg.commission')
                ->select('d.use_time')
                ->select('d.discount_use_sdate')
                ->select('d.discount_use_edate')
                ->select('dpg.coupon_use_yn')
                ->from(TBL_SHOP_DISCOUNT . ' as d')
                ->join(TBL_SHOP_DISCOUNT_PRODUCT_GROUP . ' as dpg', 'd.dc_ix = dpg.dc_ix')
                ->where('dpg.goods_display_type', 'CE')//상품분류 제외
                ->where('discount_use_sdate <=', time(), false)
                ->where('discount_use_edate >=', time(), false)
                ->where('d.is_use', '1')
                ->where('dpg.is_display', 'Y')
                ->whereIn('d.mall_ix', ['', MALL_IX])
                ->endSubQuery(), "pr.pid IN ('" . implode("','", $ids) . "')")
            ->where("pr.cid NOT IN ( SELECT c.cid FROM " . TBL_SHOP_CATEGORY_INFO . " as c, " . TBL_SHOP_DISCOUNT_DISPLAY_RELATION . " as ddr WHERE ddr.dc_ix = d.dc_ix and ddr.group_code = d.group_code AND ddr.relation_type='C' AND c.cid LIKE CONCAT(LEFT(ddr.r_ix,(INSTR(ddr.r_ix,'000')-1)),'%'))")
            ->toStr();

        //※ 정렬 중요
        $sql = implode(" UNION ", $sql) . ' ORDER BY pid ASC, discount_type ASC, sale_rate desc , discount_use_edate DESC';
        $rows = $this->qb->exec($sql)->getResultArray();

        //group by 가 안되서 for 문으로 처리 ※정렬 중요!!
        //pid, discount_type, discount_sale_type 별로 각가 등록 (원,% 중 실제 할인 금액이 큰건 계산해봐야 알수 있음)
        if (!empty($rows)) {
            $tmp = [];
            foreach ($rows as $row) {
                $row['pid'] = zerofill($row['pid']);
                //타임세일 사용 안하면 날짜 빈값으로 처리
                if ($row['use_time'] != '1') {
                    $row['discount_use_sdate'] = '';
                    $row['discount_use_edate'] = '';
                }
                if (empty($tmp[$row['pid']][$row['discount_type']][$row['discount_sale_type']])) {
                    $this->discountData[$row['pid']][] = $this->structureDiscountData(
                        $row['discount_type'], $row['discount_sale_type']
                        , $row['sale_rate'], $row['headoffice_rate'], $row['seller_rate']
                        , $row['dpg_ix'], $row['commission'], '', $row['discount_use_sdate'], $row['discount_use_edate']
                        , $row['coupon_use_yn']
                    );
                    $tmp[$row['pid']][$row['discount_type']][$row['discount_sale_type']] = true;
                }
            }
            unset($tmp);
            unset($rows);
        }

        //APP(APP)
        if ($this->discoutAppSaleRate > 0) {
            foreach ($ids as $id) {
                $this->discountData[$id][] = $this->structureDiscountData('APP', 1, $this->discoutAppSaleRate, $this->discoutAppSaleRate, 0, '');
            }
        }

        //그룹(MG)
        if ($this->discoutMemberGroupSaleRate > 0) {
            foreach ($ids as $id) {
                if($discountCategoryYn == 'Y'){
                    $discountCategory = $this->qb
                        ->select('dc.cid')
                        ->from(TBL_SHOP_GROUP_DISCOUNT_CATEGORY .' as dc')
                        ->join(TBL_SHOP_PRODUCT_RELATION .' as pr','dc.cid = pr.cid','left')
                        ->where('dc.gp_ix',$this->userInfo->gp_ix)
                        ->where('pr.pid',$id)
                        ->getCount();
                    if($discountCategory > 0){
                        if($discountCategoryMileageYn == 'Y'){
                            $this->categoryReserveYn[$id] = true;
                        }
                        $this->discountData[$id][] = $this->structureDiscountData('MG', 1, $this->discoutMemberGroupSaleRate, $this->discoutMemberGroupSaleRate, 0, $this->discoutMemberGroupIx);
                    }
                }else{
                    $this->discountData[$id][] = $this->structureDiscountData('MG', 1, $this->discoutMemberGroupSaleRate, $this->discoutMemberGroupSaleRate, 0, $this->discoutMemberGroupIx);
                }
            }
        }
    }

    /**
     * 할인 정보
     * @param type $productList
     */
    protected function discount($productList)
    {
        //메모리 초기화
        if (count($this->discountData) > 300) {
            $this->discountData = [];
        }

        $ids = array_column($productList, 'id');
        $saveIds = array_keys($this->discountData);

        // 현재 할인된 상품 리스트에서 조회
        $noIds = array_diff($ids, $saveIds); // $ids - $saveIds
        //discountData 에 상품의 할인 정보가 없다면, 없는 id 들만 추려서 setDiscountData 처리

        if (!empty($noIds)) {
            $noIds = array_unique($noIds);
            $this->setDiscountData($noIds);
        }

        foreach ($productList as $productKey => $product) {
            $productList[$productKey] = array_merge($product, $this->discountCalculation($product['id'], $product['listprice'], $product['dcprice']));
        }

        return $productList;
    }

    /**
     * discountData 데이터에 있는 기준으로 계산
     * @param int $id
     * @param int $listPrice
     * @param int $dcPrice
     * @return array
     */
    protected function discountCalculation($id, $listPrice, $dcPrice)
    {
        $discountList = [];

        $listPrice = f_decimal($listPrice);
        $dcPrice = f_decimal($dcPrice);

        //즉시 할인
        if ($listPrice > $dcPrice) {
            $discountList[] = [
                'type' => 'IN'
                , 'title' => ForbizConfig::getDiscount('IN')
                , 'discount_amount' => ($listPrice - $dcPrice)
            ];
        }

        // 상품에 관한 할인 정보(멀티)가 있으면, 적용해서 각각의 값을 보유하고 최종적으로
        // 할인 정책중 가장 할인률이 높은 하나를 적용해 준다.
        if (!empty($this->discountData[$id])) {
            $beforeDcPrice = f_decimal(0);
            $__dcPrice = f_decimal(0);
            foreach ($this->discountData[$id] as $discountKey => $data) {

                if ($this->discoutMemberGroupCalculationYn == 'N' && $data['type'] == 'MG') {
                    continue;
                }

                $lastDiscount = ($discountList[(count($discountList) - 1)] ?? ['type' => '']);

                $data['title'] = ForbizConfig::getDiscount($data['type']);


                if (in_array($data['type'], ['GP', 'SP', 'M']) && $lastDiscount['type'] == $data['type']) {
                    $_dcPrice = $beforeDcPrice;
                } else {
                    $_dcPrice = $dcPrice;
                }


                // 할인률 할인
                if ($data['sale_type'] == '1') { // %
                    $dcPrice = $this->round($_dcPrice * f_decimal((100 - $data['sale_value']) / 100));
                    $_headofficeDcPrice = $this->round($_dcPrice * f_decimal((100 - $data['headoffice_sale_value']) / 100));

                    // 정액 할인
                } else if ($data['sale_type'] == '2') { // 원
                    $dcPrice = (($_dcPrice - f_decimal($data['sale_value'])) > 0 ? $_dcPrice - f_decimal($data['sale_value']) : f_decimal(0));
                    $_headofficeDcPrice = (($_dcPrice - f_decimal($data['headoffice_sale_value'])) > 0 ? $_dcPrice - f_decimal($data['headoffice_sale_value']) : f_decimal(0));
                }

                $beforeDcPrice = $_dcPrice;

                $_discountAmount = $_dcPrice - $dcPrice;
                $_headofficeDiscountAmount = $_dcPrice - $_headofficeDcPrice;

                $data['discount_amount'] = $_discountAmount;
                $data['headoffice_discount_amount'] = $_headofficeDiscountAmount;
                $data['seller_discount_amount'] = $_discountAmount - $_headofficeDiscountAmount;


                //기획&특별&모바일은 %,원 금액중 가장 큰금액으로 할인해 줘야 함
                if (in_array($data['type'], ['GP', 'SP', 'M']) && $lastDiscount['type'] == $data['type']) {
                    if ($lastDiscount['discount_amount'] < $data['discount_amount']) {
                        $discountList[(count($discountList) - 1)] = $data;
                        $__dcPrice = $dcPrice;
                    } else {
                        $dcPrice = $__dcPrice;
                    }
                } else {
                    $discountList[] = $data;
                    $__dcPrice = $dcPrice;
                }
            }
        }

        //할인 목록중 쿠폰 사용 정보 있으면 사용 안함!
        $discountCouponUseYn = 'X';
        foreach ($discountList as $discount) {
            if (isset($discount['coupon_use_yn'])) {
                if ($discount['coupon_use_yn'] == 'N') {
                    $discountCouponUseYn = 'N';
                    break;
                } else if ($discount['coupon_use_yn'] == 'Y') {
                    $discountCouponUseYn = 'Y';
                }
            }
        }

        return [
            'dcprice' => $dcPrice
            , 'discount_amount' => $listPrice - $dcPrice
            , 'discount_rate' => ($listPrice > 0 ? ceil(((f_decimal($listPrice) - f_decimal($dcPrice)) / f_decimal($listPrice)) * 100) : 0)
            , 'discountList' => $discountList
            , 'discount_coupon_use_yn' => $discountCouponUseYn
        ];
    }

    /**
     * discountData 구조체
     * @param string $type
     * @param int $saleType 1:%, 2:원
     * @param int $saleValue
     * @param int $headOfficeSaleValue
     * @param int $sellerSaleValue
     * @param string $code
     * @param int $commission
     * @return type
     */
    protected function structureDiscountData($type, $saleType, $saleValue, $headOfficeSaleValue, $sellerSaleValue, $code, $commission = 0, $description = '', $sDate = '', $eDate = '', $couponUseYn = 'X')
    {
        return [
            'type' => $type
            , 'sale_type' => $saleType
            , 'sale_value' => $saleValue
            , 'headoffice_sale_value' => $headOfficeSaleValue
            , 'seller_sale_value' => $sellerSaleValue
            , 'code' => $code
            , 'commission' => $commission
            , 'description' => $description
            , 'sDate' => $sDate
            , 'eDate' => $eDate
            , 'coupon_use_yn' => $couponUseYn
        ];
    }

    /**
     * 유사상품 옵션기준 - old
     * @param type $pid
     * @return type
     */
    public function getSameItem($pid)
    {
        $this->qb
            ->select('option_gid')
            ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
            ->where('pid', $pid);

        $datas = $this->qb->exec()->getResultArray();

        if (is_array($datas) && count($datas) > 0) {
            $gidArray = [];
            foreach ($datas as $key => $val) {
                $gid_style = $this->qb
                    ->select('style')
                    ->from(TBL_INVENTORY_GOODS)
                    ->where('gid', $val['option_gid'])
                    ->exec()->getRow();
                if (isset($gid_style)) {
                    $gidArray[] = $gid_style->style;
                }
            }

            $gidArray = array_unique($gidArray);
            if (empty($gidArray)) {
                return;
            }

            $sameGid = $this->qb
                ->select('gid')
                ->from(TBL_INVENTORY_GOODS)
                ->whereIn('style', $gidArray)
                ->exec()->getResultArray();
            if (is_array($sameGid) && count($sameGid) > 0) {
                $sameItem = [];
                foreach ($sameGid as $gid) {
                    $sameItem[] = $gid['gid'];
                }

                $sameProduct = $this->basicWhere()
                    ->select('od.pid')
                    ->select('p.listNum, p.overNum, p.slistNum, p.nailNum, p.pattNum')
                    ->from(TBL_SHOP_PRODUCT . ' as p')
                    ->join(TBL_SHOP_PRODUCT_OPTIONS . ' as o', 'p.id = o.pid', 'left')
                    ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' as od', 'o.opn_ix = od.opn_ix', 'left')
                    ->whereIn('od.option_gid', $sameItem)
                    ->where('o.option_kind', 'b')
                    ->groupBy('od.pid')
                    ->exec()->getResultArray();


                if (is_array($sameProduct) && count($sameProduct) > 0) {
                    foreach ($sameProduct as $key => $val) {
                        if($val['pattNum'] == 0){
                            $sameProduct[$key]['pattImg'] = get_product_images_src_new($val['pid'], '', 'patt', '', 0);
                        }else{
                            $sameProduct[$key]['pattImg'] = get_product_images_src_new($val['pid'], '', 'patt', '', $val['pattNum']-1);
                        }
                        $sameProduct[$key]['filterImg'] = get_product_images_src($val['pid'], '', 'filter', ''); //이미지
                    }
                }

                return $sameProduct;
            }
        }
    }

    public function getColorChipList($pid)
    {
        $data = [];

        $list = $this->qb
            ->select('rp_pid as pid')
            ->from(TBL_SHOP_RELATION_PRODUCT)
            ->where('pid', $pid)
            ->exec()->getResultArray();

        if ($this->qb->total > 0) {
            if (is_array($list) && count($list) > 0) {
                foreach ($list as $key => $val) {
                    $list[$key]['filterImg'] = get_product_images_src($val['pid'], '', 'filter', ''); //이미지
                }

                $data[1] = $list;
            }
        }

        $list = $this->qb
            ->select('rp_pid as pid')
            ->from(TBL_SHOP_RELATION_PRODUCT2)
            ->where('pid', $pid)
            ->exec()->getResultArray();

        if ($this->qb->total > 0) {
            if (is_array($list) && count($list) > 0) {
                foreach ($list as $key => $val) {
                    $list[$key]['filterImg'] = get_product_images_src($val['pid'], '', 'filter', ''); //이미지
                }

                $data[2] = $list;
            }
        }

        return $data;
    }

    /**
     * 옵션 분리
     * @param array $options
     * @return array
     */
    protected function compileViewOption($options)
    {
        $result = [];
        foreach ($options as $option) {
            $optionName = $option['option_name'];

            $optionDetailList = [];

            //가격+재고옵션이면서 컬러 + 사이즈 타입일때
            if (($option['option_kind'] == 'b' && $option['option_type'] == 'o') || ($option['option_kind'] == 'c' && $option['option_type'] == 'd')
            ) {
                if ($option['option_type'] == 'd') {
                    $optionName = 'OPTION 1';
                } else {
                    $optionName = 'COLOR';
                }

                foreach ($option['optionDetailList'] as $optionsDetail) {
                    $division = $optionsDetail['division'][0];
                    if (array_search($division, array_column($optionDetailList, 'division')) === false) {
                        $optionDetailList[] = [
                            'division' => $division
                            , 'option_div' => $division
                        ];
                    }
                }
                $result[] = [
                    'option_name' => $optionName
                    , 'origin_option_name' => $option['option_name']
                    , 'option_kind' => $option['option_kind']
                    , 'option_type' => $option['option_type']
                    , 'optionDetailList' => $optionDetailList
                ];

                $optionDetailList = [];
                if ($option['option_type'] == 'd') {
                    $optionName = 'OPTION 2';
                } else {
                    $optionName = 'SIZE';
                }

                foreach ($option['optionDetailList'] as $optionsDetail) {
                    $division = $optionsDetail['division'][1];
                    $findKey = array_search($division, array_column($optionDetailList, 'division'));
                    if ($findKey === false) {
                        $optionDetailList[] = [
                            'division' => $division
                            , 'option_div' => $division
                            , 'etc_data' => [
                                $optionsDetail['division'][0] => [
                                    'option_stock' => $optionsDetail['option_stock']
                                    , 'option_id' => $optionsDetail['option_id']
                                ]
                            ]
                        ];
                    } else {
                        $optionDetailList[$findKey]['etc_data'][$optionsDetail['division'][0]] = [
                            'option_stock' => $optionsDetail['option_stock']
                            , 'option_id' => $optionsDetail['option_id']
                        ];
                    }
                }
            } else {
                //m_option_div : 모바일 버튼옵션 용 Small => S, Medium => M, Large => L로 변경처리 값
                if (!empty($option['optionDetailList'])) {
                    foreach ($option['optionDetailList'] as $optionsDetail) {
                        $optionDivArray = explode('[',$optionsDetail['option_div']);
                        $optionDivMArray = explode('[',$optionsDetail['m_option_div']);
                        $optionDetailList[] = [
                            'division' => $optionsDetail['option_id']
                            , 'option_div' => $optionsDetail['option_div']
                            , 'm_option_div' => $optionsDetail['m_option_div']
                            , 'shot_option_div' => $optionDivArray[0]
                            , 'm_shot_option_div' => $optionDivMArray[0]
                            , 'option_stock' => $optionsDetail['option_stock']
                        ];
                    }
                }
            }

            $result[] = [
                'option_name' => $optionName
                , 'origin_option_name' => $option['option_name']
                , 'option_kind' => $option['option_kind']
                , 'option_type' => $option['option_type']
                , 'optionDetailList' => $optionDetailList
            ];
        }
        return $result;
    }

    public function inputProductReStock($res)
    {

        $userCode = $this->userInfo->code;

        if (!empty($res['change_pcs']) && $res['change_pcs'] == 'Y') {
            $pcs = $res['pcs1'] . '-' . $res['pcs2'] . '-' . $res['pcs3'];
        } else {
            $pcs = $res['pcs'];
        }


        $dataCnt = $this->qb
            ->select()
            ->from(TBL_SHOP_PRODUCT_STOCK_REMINDER)
            ->where('user_code', $userCode)
            ->where('pid', $res['pid'])
            ->where('op_id', $res['option_id'])
            ->where('pcs', $pcs)
            ->where('status', 'N')
            ->getCount();

        if ($dataCnt > 0) {
            return 'overlap';
        } else {

            $expiration_date = date('Y-m-d', strtotime('+15 days'));

            $this->qb
                ->insert(TBL_SHOP_PRODUCT_STOCK_REMINDER)
                ->set('user_code', $userCode)
                ->set('pcs', $pcs)
                ->set('pid', $res['pid'])
                ->set('op_id', $res['option_id'])
                ->set('status', 'N')
                ->set('expiration_date', $expiration_date)
                ->set('regdate', date('Y-m-d H:i:s'))
                ->exec();
            return 'success';
        }

        return 'fail';
    }

    public function getStockReminderList($page = 1, $max = 5)
    {

        $userCode = $this->userInfo->code;

        $notArr = [5]; // 5:판매종료

        $this->qb->startCache();
        $this->qb
            ->select('*, psr.pid as pid, psr.regdate as regdate, psr.status as rm_status')
            ->from(TBL_SHOP_PRODUCT_STOCK_REMINDER . ' AS psr')
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS pod', 'psr.pid = pod.pid and psr.op_id = pod.id', 'left')
            ->join(TBL_SHOP_PRODUCT_OPTIONS . ' AS po', 'pod.opn_ix = po.opn_ix', 'left')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'psr.pid = p.id', 'left')
            ->where('user_code', $userCode)
            ->whereNotIn('p.state', $notArr);
        $this->qb->stopCache();
        $total = $this->qb->getCount();
        $paging = $this->qb->setTotalRows($total)->pagination($page, $max);
        if ($paging['offset']) {
            $limit = $paging['offset'] . "," . $max;
        } else {
            $limit = $max;
        }

        $datas = $this->qb
            ->orderBy('sr_ix', 'desc')
            ->limit($max, $paging['offset'])
            ->exec()
            ->getResultArray();
        $this->qb->flushCache();
        $list = [];
        for ($i = 0; $i < count($datas); $i++) {
            $data = $datas[$i];
            $product = $this->getListBySingleId($data['pid']);

            if (is_array($product)) {
                $list[$i] = array_merge($data, $product);
            }
        }

        return [
            'total' => $total,
            'list' => $list,
            'paging' => $paging
        ];
    }

    public function deleteReminder($sr_ix)
    {
        $userCode = $this->userInfo->code;
        $this->qb
            ->delete(TBL_SHOP_PRODUCT_STOCK_REMINDER)
            ->where('user_code', $userCode)
            ->where('sr_ix', $sr_ix)
            ->exec();
    }

    /**
     * 최근 본 이전 상품 데이타
     * 상품상세에서는 최근본상품 -1
     * @param string $userCode 회원코드
     * @param int $cur_page 현재 페이지 번호
     * @param int $per_page 페이지당 라인수
     * @param boolean $is_paging 페이징 표시 여부
     * @return array
     */
    public function getBeforeProductView($userCode)
    {

        $offset = 1;
        $limit = 1;

        $this->qb->startCache();
        $this->basicWhere()
            ->select('vh.pid')
            ->from(TBL_SHOP_PRODUCT . ' as p')
            ->join(TBL_SHOP_VIEW_HISTORY . ' as vh', 'vh.pid = p.id')
            ->where('vh.mem_ix', $userCode)
            ->stopCache();

        // Get total rows
        $total = $this->qb->getCount();


        $list = [];
        if ($total > 0) {
            $ids = $this->qb
                ->orderBy('vh.regdate', 'desc')
                ->limit($limit, $offset)
                ->exec()
                ->getResultArray();
        }

        $this->qb->flushCache();

        if ($total > 0) {
            $list = $this->getListById(array_column($ids, 'pid'));
        }

        if (empty($list)) {
            return;
        } else {
            return $list[0];
        }
    }

    public function getStoreGuideStyle($pid)
    {
        $this->qb
            ->select('style, color, gname, gid')
            ->from(TBL_SHOP_PRODUCT_OPTIONS . ' AS o')
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS od', 'o.opn_ix = od.opn_ix')
            ->join(TBL_INVENTORY_GOODS . ' AS ig', 'od.option_gid=ig.gid')
            ->where('o.pid', $pid)
            ->where('option_kind', 'b')
            ->groupBy('style');

        $style = $this->qb->exec()->getResultArray();

        return $style;
    }

    public function getStoreGuideOption($pid)
    {
        $this->qb
            ->select('option_gid, option_div')
            ->from(TBL_SHOP_PRODUCT_OPTIONS . ' AS o')
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS od', 'o.opn_ix = od.opn_ix')
            ->where('o.pid', $pid)
            ->where('option_kind', 'b');

        $option = $this->qb->exec()->getResultArray();

        return $option;
    }

    public function getFilterList()
    {
        $filter = $this->qb
            ->select('idx')
            ->select('filter_type')
            ->select('filter_code')
            ->select('filter_name')
            ->select('filter_img_path')
            ->select('filter_img_pc')
            ->select('filter_img_mobile')
            ->from(TBL_SHOP_PRODUCT_FILTER)
            ->where('disp', 'Y')
			->orderBy('filter_sort')
            ->exec()->getResultArray();

        $filterArray = array();
        $filterSub = array();
        if (is_array($filter) && count($filter) > 0) {
            foreach ($filter as $key => $val) {
                switch ($val['filter_type']) {
                    case 'CLOTHING':
                        $filter_type_text = "의류";
                        break;
                    case 'SHOES':
                        $filter_type_text = "슈즈";
                        break;
                    case 'ACC':
                        $filter_type_text = "ACC";
                        break;
                    case 'COLOR':
                        $filter_type_text = "색상";
                        break;
                }

                $filterArray[$val['filter_type']]['filter_type'] = $val['filter_type'];
                $filterArray[$val['filter_type']]['filter_type_text'] = trans($filter_type_text);
                $filterArray[$val['filter_type']]['item'][$key]['filter_idx'] = $val['idx'];
                $filterArray[$val['filter_type']]['item'][$key]['filter_name'] = $val['filter_name'];

                $filterImg = $this->getFilterImg($val['idx']);
                if (isset($filterImg['pc'])) {
                    $filterArray[$val['filter_type']]['item'][$key]['filter_img_pc'] = $filterImg['pc'];
                }
                if (isset($filterImg['mobile'])) {
                    $filterArray[$val['filter_type']]['item'][$key]['filter_img_mobile'] = $filterImg['mobile'];
                }
            }
        }
        return $filterArray;
    }

    public function getFilterImg($idx)
    {
        $basicPath = DATA_ROOT . "/images/filter/";
        $domain = (!empty(IMAGE_SERVER_DOMAIN) ? IMAGE_SERVER_DOMAIN : HTTP_PROTOCOL . FORBIZ_HOST);

        $returnData = array();
        $pcSrc = $basicPath . $idx . "_pc.gif";
        $mobileSrc = $basicPath . $idx . "_mobile.gif";

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $pcSrc)) {
            $returnData['pc'] = $domain . $pcSrc;
        }
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $mobileSrc)) {
            $returnData['mobile'] = $domain . $mobileSrc;
        }

        return $returnData;
    }

    /**
     * 판매랭킹 호출(크론으로 랭킹 데이터 설정됨)
     * @param int $limit
     * @param string $cid
     * @return array
     * @custom 1Depth 카테고리에 속한 하위 카테고리 전부를 대상으로 베스트 추출
     */
    public function getCategoryRanking($limit, $cid = '')
    {
        return array();
        if (!empty($cid)) {
            $likeCid = substr($cid, 0, 4);
            $this->qb->like('cid', $likeCid, 'after');
        }
        $ids = $this->basicWhere()
            ->select('p.id')
            ->from(' shop_product_ranking as r ')
            ->join(TBL_SHOP_PRODUCT . ' as p ', 'p.id=r.pid', 'inner')
            ->orderBy('ranking')
            ->limit($limit)
            ->exec()->getResultArray();

        if (!empty($ids)) {
            $list = $this->getListById(array_column($ids, 'id'));
            return $list;
        } else {
            return array();
        }
    }

    /**
     * 크리마에서 직접 호출 하는 상품 매칭 정보
     * @param type $mode
     * @param type $sdate
     * @param type $edate
     * @return type
     */
    public function cronCremaFitProduct($mode, $sdate, $edate)
    {

        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $sdate = date("Y-m-d 00:00:00", strtotime($sdate));
        $edate = date("Y-m-d 23:59:59", strtotime($edate));


        if ($mode == "productcreate") {
            $this->qb->betweenDate('p.regdate', $sdate, $edate);
        } else if ($mode == "productupdate") {
            $this->qb->betweenDate('p.editdate', $sdate, $edate);
        } else {
            return ['mode' => "not mode ! checke mode parameter!", 'status' => 'fail'];
        }

        $rows = $this->qb
            ->select('p.id')
            ->select('p.pname')
            ->select('p.add_info')
            ->select('p.listprice')
            ->select('p.sellprice')
            ->select('p.disp')
            ->select('p.stock')
            ->from(TBL_SHOP_PRODUCT . ' AS p')
            ->exec()
            ->getResultArray();

        //crema api
        $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);

        if ($mode == "productcreate") {
            $this->qb->betweenDate('p.regdate', $sdate, $edate);
        } else if ($mode == "productupdate") {
            $this->qb->betweenDate('p.editdate', $sdate, $edate);
        } else {
            return ['mode' => "not mode ! checke mode parameter!", 'status' => 'fail'];
        }

        $options = $this->qb
            ->select('p.id')
            ->select('po.option_name')
            ->select('p.pname')
            ->select('pod.option_div')
            ->from(TBL_SHOP_PRODUCT_OPTIONS . ' AS po')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'po.pid  = p.id')
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS pod', 'pod.opn_ix = po.opn_ix')
            ->exec()
            ->getResultArray();

        $putProductCount = 0;
        foreach ($rows as $key => $val) {
            $cremaCate = $this->getCremaCate($val['id']);
            $cremaCate = $this->chageCremaCate($cremaCate);
            $cremaOpt = [];
            foreach ($options as $k => $v) {
                if ($val['id'] == $v['id']) {
                    $cremaOpt[$k]['option_name'] = $v['option_name'];
                    $cremaOpt[$k]['option_div'] = $v['option_div'];
                }
            }

            $crema_options = array();
            if (count($cremaOpt) > 0) {
                foreach (fb_column_merge($cremaOpt, 'option_name', 'option_div') as $crema_key => $crema_opt) {
                    $crema_options[] = ["name" => $crema_key, "values" => array_unique($crema_opt)];
                }
            }

            //기존에 있던 상품의 카테고리 가져옴
            $param = ['code' => $val['id']];
            $crema_product_info = $this->cremaModel->getProductInfo($param);
            $cremaCate = $this->getCremaCate($val['id']);


            if (!isset($crema_product_info['categories'])) {
                $crema_product_info['categories'] = [];
            }
            $this->putCremaCate($cremaCate);

            $inCate = [];
            foreach ($cremaCate as $cate_key => $cate_val) {
                $inCate[] = $cate_val['cid'];
            }

            $stock_count = 1;
            if ($val['stock'] <= 0) {
                $stock_count = 0;
            }

            $url = HTTP_PROTOCOL . FORBIZ_BASEURL . '/shop/goodsView/' . $val['id'];

            if(strpos($url, "https://www.") == false) {
                $url = HTTP_PROTOCOL . 'www.' . FORBIZ_BASEURL . '/shop/goodsView/' . $val['id'];
            }

            $param = [
                'code' => (int)$val['id']
                , 'name' => $val['pname'] . ' ' . $val['add_info']
                , 'url' => $url
                , 'org_price' => $val['listprice']
                , 'final_price' => $val['sellprice']
                , 'category_codes' => $inCate  //카테고리 arr 타입
                , 'display' => $val['disp']   //사용여부
                , 'image_url' => get_product_images_src($val['id'], $this->isUserAdult, 's')
                , 'stock_count' => $stock_count  // 재고있음 여부
                , 'product_options' => $crema_options
     //           , 'sub_product_codes' => [] //셋트상품코드
            ];

            if ($mode == "productcreate") {
                $param['shop_builder_created_at'] = date('Y-m-d\TH:i:sO'); //datetinme ISO8601
            } else if ($mode == "productupdate") {
                $param['shop_builder_updated_at'] = date('Y-m-d\TH:i:sO'); //datetinme ISO8601
            }

            $this->cremaModel->putJsonProduct(json_encode($param, JSON_UNESCAPED_UNICODE)); //없으면 생성            
            $putProductCount++;
        }
        return ['status' => 'success', 'putProductCount' => $putProductCount];
    }

    /**
     * 크리마 상품 추가
     * 배치 일일 10:00, 15:00 18:00 로 스케줄 설정 요청 드립니다.
     * 강태웅 과장
     * today 기준으로만 뽑아옴
     */
    public function cronCremaPutProduct()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $sdate = date("Y-m-d H:i:s",strtotime ("-12 hours"));
        $edate = date('Y-m-d H:i:s');
//        $sdate = date('Y-m-d 00:00:00');
//        $edate = date('Y-m-d 23:59:59');

        $rows = $this->qb
            ->select('p.id')
            ->select('p.pname')
            ->select('p.add_info')
            ->select('p.listprice')
            ->select('p.sellprice')
            ->select('p.disp')
            ->select('p.stock')
            ->from(TBL_SHOP_PRODUCT . ' AS p')
            ->betweenDate('p.regdate', $sdate, $edate)
            ->exec()
            ->getResultArray();

        //crema api
        $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);

        $options = $this->qb
            ->select('p.id')
            ->select('po.option_name')
            ->select('p.pname')
            ->select('pod.option_div')
            ->from(TBL_SHOP_PRODUCT_OPTIONS . ' AS po')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'po.pid  = p.id')
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS pod', 'pod.opn_ix = po.opn_ix')
            ->betweenDate('p.regdate', $sdate, $edate)
            ->exec()
            ->getResultArray();

        foreach ($rows as $key => $val) {
            $cremaCate = $this->getCremaCate($val['id']);
            $cremaCate = $this->chageCremaCate($cremaCate);
            $cremaOpt = [];

            foreach ($options as $k => $v) {

                if ($val['id'] == $v['id']) {
                    $cremaOpt[$k]['option_name'] = $v['option_name'];
                    $cremaOpt[$k]['option_div'] = $v['option_div'];
                }
            }

            $crema_options = array();
            if (count($cremaOpt) > 0) {
                foreach (fb_column_merge($cremaOpt, 'option_name', 'option_div') as $crema_key => $crema_opt) {
                    $crema_options[] = ["name" => $crema_key, "values" => array_unique($crema_opt)];
                }
            }

            //기존에 있던 상품의 카테고리 가져옴
            $param = ['code' => $val['id']];
            $crema_product_info = $this->cremaModel->getProductInfo($param);
            $cremaCate = $this->getCremaCate($val['id']);


            if (!isset($crema_product_info['categories'])) {
                $crema_product_info['categories'] = [];
            }
            $this->putCremaCate($cremaCate);

            $inCate = [];
            foreach ($cremaCate as $cate_key => $cate_val) {
                $inCate[] = $cate_val['cid'];
            }

            $stock_count = 1;
            if ($val['stock'] <= 0) {
                $stock_count = 0;
            }

            $url = HTTP_PROTOCOL . FORBIZ_BASEURL . '/shop/goodsView/' . $val['id'];

            if(strpos($url, "https://www.") == false) {
                $url = HTTP_PROTOCOL . 'www.' . FORBIZ_BASEURL . '/shop/goodsView/' . $val['id'];
            }

            $param = [
                'code' => (int)$val['id']
                , 'name' => $val['pname'] . ' ' . $val['add_info']
                , 'url' => $url
                , 'org_price' => $val['listprice']
                , 'final_price' => $val['sellprice']
                , 'category_codes' => $inCate  //카테고리 arr 타입
                , 'display' => $val['disp']   //사용여부
                , 'image_url' => get_product_images_src($val['id'], $this->isUserAdult, 's')
                , 'stock_count' => $stock_count  // 재고있음 여부
                , 'product_options' => $crema_options
//                , 'sub_product_codes' => [] //셋트상품코드
                , 'shop_builder_created_at' => date('Y-m-d\TH:i:sO')  //datetinme ISO8601
                //, 'shop_builder_updated_at' => date('Y-m-d\TH:i:sO') //datetinme ISO8601
            ];

            $data = $this->cremaModel->putJsonProduct(json_encode($param, JSON_UNESCAPED_UNICODE)); //없으면 생성            
            if (isset($data['error_code']) && $data['error_code'] == '00') {
                //에러 아닌것
                $this->insertCremaLog('product', $this->cremaModel->issetJson($param), $this->cremaModel->issetJson($data['response'] ?? null), $this->cremaModel->issetJson($data['response_heder'] ?? null), $this->cremaModel->issetErrorJson(null, $data['curl_error'] ?? null));
            } else {
                //에러인것
                $this->insertCremaLog('product', $this->cremaModel->issetJson($param), null, $this->cremaModel->issetJson($data['response_heder'] ?? null), $this->cremaModel->issetErrorJson($data['response'] ?? null, $data['curl_error'] ?? null));
            }
        }
    }

    /**
     * 크리마 상품 수정
     * 배치 일일 10:00, 15:00 18:00 로 스케줄 설정 요청 드립니다.
     * 강태웅 과장
     * today 기준으로만 뽑아옴
     */
    public function cronCremaPutProductUpdate()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
//        $sdate = date('Y-m-d 00:00:00');
//        $edate = date('Y-m-d 23:59:59');
        $sdate = date("Y-m-d H:i:s",strtotime ("-12 hours"));
        $edate = date('Y-m-d H:i:s');

        $rows = $this->qb
            ->select('p.id')
            ->select('p.pname')
            ->select('p.add_info')
            ->select('p.listprice')
            ->select('p.sellprice')
            ->select('p.disp')
            ->select('p.stock')
            ->from(TBL_SHOP_PRODUCT . ' AS p')
            ->betweenDate('p.editdate', $sdate, $edate)
            ->exec()
            ->getResultArray();

        //crema api
        $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);

        $options = $this->qb
            ->select('p.id')
            ->select('po.option_name')
            ->select('p.pname')
            ->select('pod.option_div')
            ->from(TBL_SHOP_PRODUCT_OPTIONS . ' AS po')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'po.pid  = p.id')
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS pod', 'pod.opn_ix = po.opn_ix')
            ->betweenDate('p.editdate', $sdate, $edate)
            ->exec()
            ->getResultArray();

        foreach ($rows as $key => $val) {
            $cremaCate = $this->getCremaCate($val['id']);
            $cremaCate = $this->chageCremaCate($cremaCate);
            $cremaOpt = [];

            foreach ($options as $k => $v) {

                if ($val['id'] == $v['id']) {
                    $cremaOpt[$k]['option_name'] = $v['option_name'];
                    $cremaOpt[$k]['option_div'] = $v['option_div'];
                }
            }

            $crema_options = array();
            if (count($cremaOpt) > 0) {
                foreach (fb_column_merge($cremaOpt, 'option_name', 'option_div') as $crema_key => $crema_opt) {
                    $crema_options[] = ["name" => $crema_key, "values" => array_unique($crema_opt)];
                }
            }

            //기존에 있던 상품의 카테고리 가져옴
            $param = ['code' => $val['id']];
            $crema_product_info = $this->cremaModel->getProductInfo($param);
            $cremaCate = $this->getCremaCate($val['id']);


            if (!isset($crema_product_info['categories'])) {
                $crema_product_info['categories'] = [];
            }
            $this->putCremaCate($cremaCate);

            $inCate = [];
            foreach ($cremaCate as $cate_key => $cate_val) {
                $inCate[] = $cate_val['cid'];
            }

            $stock_count = 1;
            if ($val['stock'] <= 0) {
                $stock_count = 0;
            }

            $url = HTTP_PROTOCOL . FORBIZ_BASEURL . '/shop/goodsView/' . $val['id'];

            if(strpos($url, "https://www.") == false) {
                $url = HTTP_PROTOCOL . 'www.' . FORBIZ_BASEURL . '/shop/goodsView/' . $val['id'];
            }

            $param = [
                'code' => (int)$val['id']
                , 'name' => $val['pname'] . ' ' . $val['add_info']
                , 'url' => $url
                , 'org_price' => $val['listprice']
                , 'final_price' => $val['sellprice']
                , 'category_codes' => $inCate  //카테고리 arr 타입
                , 'display' => $val['disp']   //사용여부
                , 'image_url' => get_product_images_src($val['id'], $this->isUserAdult, 's')
                , 'stock_count' => $stock_count  // 재고있음 여부
                , 'product_options' => $crema_options
     //           , 'sub_product_codes' => [] //셋트상품코드
                //, 'shop_builder_created_at' => date('Y-m-d\TH:i:sO')  //datetinme ISO8601
                , 'shop_builder_updated_at' => date('Y-m-d\TH:i:sO') //datetinme ISO8601
            ];

            $data = $this->cremaModel->putJsonProductLog(json_encode($param, JSON_UNESCAPED_UNICODE)); //없으면 생성            
            if (isset($data['error_code']) && $data['error_code'] == '00') {
                //에러 아닌것
                $this->insertCremaLog('product', $this->cremaModel->issetJson($param), $this->cremaModel->issetJson($data['response'] ?? null), $this->cremaModel->issetJson($data['response_heder'] ?? null), $this->cremaModel->issetErrorJson(null, $data['curl_error'] ?? null));
            } else {
                //에러인것
                $this->insertCremaLog('product', $this->cremaModel->issetJson($param), null, $this->cremaModel->issetJson($data['response_heder'] ?? null), $this->cremaModel->issetErrorJson($data['response'] ?? null, $data['curl_error'] ?? null));
            }
        }
    }

    /**
     * 크리마 크론 카테고리
     */
    public function cronCremaCategory()
    {

        $sdate = date('Y-m-d', strtotime('-1 day'));
        $edate = date('Y-m-d', strtotime('-1 day'));

        //전체 리스트를 가져오고
        $rows = $this->qb
            ->select('pr.pid')
            ->select('p.pname')
            ->select('ci.co_no')
            ->select('ci.cid')
            ->from(TBL_SHOP_PRODUCT_RELATION . ' AS pr')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'p.id = pr.pid')
            ->join(TBL_SHOP_CATEGORY_INFO . ' AS ci', 'ci.cid = pr.cid')
            ->betweenDate('regdate', $sdate, $edate)
            ->orderBy('ci.regdate', 'desc')
            ->exec()
            ->getResultArray();


        //카테고리 분류 별로 3자리로 끊어서 배열형태로 넣음
        $cate_code = [];
        foreach ($rows as $key => $val) {
            array_push($cate_code, substr($val['cid'], 0, 3));
            array_push($cate_code, substr($val['cid'], 3, 3));
            array_push($cate_code, substr($val['cid'], 6, 3));
            array_push($cate_code, substr($val['cid'], 9, 3));
            array_push($cate_code, substr($val['cid'], 12, 3));

            $crema_cate = $this->splite_crema_cate($cate_code);
            $this->putCremaCate($crema_cate);
            $cate_code = [];
        }
    }

    /**
     * 크리마 카테고리 변경 수정
     */
    public function cronCremaCategoryUpdate()
    {

        $sdate = date('Y-m-d', strtotime('-1 day'));
        $edate = date('Y-m-d', strtotime('-1 day'));

        //전체 리스트를 가져오고
        $rows = $this->qb
            ->select('pr.pid')
            ->select('p.pname')
            ->select('ci.co_no')
            ->select('ci.cid')
            ->from(TBL_SHOP_PRODUCT_RELATION . ' AS pr')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'p.id = pr.pid')
            ->join(TBL_SHOP_CATEGORY_INFO . ' AS ci', 'ci.cid = pr.cid')
            ->betweenDate('regdate', $sdate, $edate)
            ->orderBy('ci.regdate', 'desc')
            ->exec()
            ->getResultArray();


        //카테고리 분류 별로 3자리로 끊어서 배열형태로 넣음
        $cate_code = [];
        foreach ($rows as $key => $val) {
            array_push($cate_code, substr($val['cid'], 0, 3));
            array_push($cate_code, substr($val['cid'], 3, 3));
            array_push($cate_code, substr($val['cid'], 6, 3));
            array_push($cate_code, substr($val['cid'], 9, 3));
            array_push($cate_code, substr($val['cid'], 12, 3));

            $crema_cate = $this->splite_crema_cate($cate_code);
            $this->putCremaCate($crema_cate);
            $cate_code = [];
        }
    }

    /**
     * 첫 등록 하기 위한 전체 데이터
     */
    public function cronCremaPutProductAll($page)
    {

		$startTime = date("Y-m-d H:i:s");

		//$text  = "======== 크리마 상품전송 시작시간\n";
		//$text .= "======== ".$startTime."\n";
		//$text .= "======== 크리마 상품전송 시작시간\n\n";

        $size = 50000;
        $limit_offset = ($page - 1) * $size;
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $rows = $this->qb
            ->select('p.id')
            ->select('p.pname')
            ->select('p.add_info')
            ->select('p.listprice')
            ->select('p.sellprice')
            ->select('p.disp')
            ->select('p.stock')
            ->from(TBL_SHOP_PRODUCT . ' AS p ')
			//->betweenDate('p.id', '451', '8466')
			//->betweenDate('p.id', '8465', '50229')
			//->betweenDate('p.id', '50226', '51229')
			//->betweenDate('p.id', '51224', '52229')
			//->betweenDate('p.id', '52222', '53234')
			//->betweenDate('p.id', '53220', '53234')
			->betweenDate('p.id', '51001', '53000')
            ->exec()
            ->getResultArray();
        //crema api
        $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);

        $options = $this->qb
            ->select('p.id')
            ->select('po.option_name')
            ->select('p.pname')
            ->select('pod.option_div')
            ->from(TBL_SHOP_PRODUCT_OPTIONS . ' AS po')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'po.pid  = p.id')
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS pod', 'pod.opn_ix = po.opn_ix')
            ->exec()
            ->getResultArray();
        $result = [];
		
        foreach ($rows as $key => $val) {
            $cremaCate = $this->getCremaCate($val['id']);
            $cremaCate = $this->chageCremaCate($cremaCate);
            $cremaOpt = [];

            foreach ($options as $k => $v) {

                if ($val['id'] == $v['id']) {
                    $cremaOpt[$k]['option_name'] = $v['option_name'];
                    $cremaOpt[$k]['option_div'] = $v['option_div'];
                }
            }

            $crema_options = array();
            if (count($cremaOpt) > 0) {
                foreach (fb_column_merge($cremaOpt, 'option_name', 'option_div') as $crema_key => $crema_opt) {
                    $crema_options[] = ["name" => $crema_key, "values" => array_unique($crema_opt)];
                }
            }

            //기존에 있던 상품의 카테고리 가져옴
            $param = ['code' => (int)$val['id']];
            $crema_product_info = $this->cremaModel->getProductInfo($param);
            $cremaCate = $this->getCremaCate($val['id']);


            if (!isset($crema_product_info['categories'])) {
                $crema_product_info['categories'] = [];
            }
            $this->putCremaCate($cremaCate);

            $inCate = [];
            foreach ($cremaCate as $cate_key => $cate_val) {
                $inCate[] = $cate_val['cid'];
            }

            $stock_count = 1;
            if ($val['stock'] <= 0) {
                $stock_count = 0;
            }

            //$url = HTTP_PROTOCOL . FORBIZ_BASEURL . '/shop/goodsView/' . $val['id'];
			$url = HTTP_PROTOCOL . 'getbarrel.com/shop/goodsView/' . $val['id'];

            if(strpos($url, "https://www.") === false) {
                //$url = HTTP_PROTOCOL . 'www.' . FORBIZ_BASEURL . '/shop/goodsView/' . $val['id'];
				$url = HTTP_PROTOCOL . 'www.getbarrel.com/shop/goodsView/' . $val['id'];
            }

            $param = [
                'code' => (int)$val['id']
                , 'name' => $val['pname'] . ' ' . $val['add_info']
                , 'url' => $url
                , 'org_price' => $val['listprice']
                , 'final_price' => $val['sellprice']
                , 'category_codes' => $inCate  //카테고리 arr 타입
                , 'display' => $val['disp']   //사용여부
                , 'image_url' => get_product_images_src($val['id'], $this->isUserAdult, 's')
                , 'stock_count' => $stock_count  // 재고있음 여부
                , 'product_options' => $crema_options
    //            , 'sub_product_codes' => [] //셋트상품코드
                , 'shop_builder_created_at' => date('Y-m-d\TH:i:sO')  //datetinme ISO8601
                //, 'shop_builder_updated_at' => date('Y-m-d\TH:i:sO') //datetinme ISO8601
            ];

			//$text .= "======== 크리마 상품전송(param)\n";
			//$text .= "======== [".$key."] // ".$param."\n";
			//$text .= "======== \n";
			//$text .= "======== 크리마 상품전송(전체상품)\n\n";

            $data = $this->cremaModel->putJsonProductLog(json_encode($param, JSON_UNESCAPED_UNICODE)); //없으면 생성
			
			//$text .= "======== 크리마 상품전송(결과코드)\n";
			//$text .= "======== [".$data['error_code']."] // ".isset($data['error_code'])."\n";
			//$text .= "======== \n";
			//$text .= "======== 크리마 상품전송(결과코드)\n\n";

            if (isset($data['error_code']) && $data['error_code'] == '00') {
				echo $key." // ".$val['id']." : Success<br>";
				print_r($data);
                //에러 아닌것
                $this->insertCremaLog('product', $this->cremaModel->issetJson($param), $this->cremaModel->issetJson($data['response'] ?? null), $this->cremaModel->issetJson($data['response_heder'] ?? null), $this->cremaModel->issetErrorJson(null, $data['curl_error'] ?? null));
            } else {
				echo $key." // ".$val['id']." : Error_Error<br>";
				print_r($data);
                //에러인것
                $this->insertCremaLog('product', $this->cremaModel->issetJson($param), null, $this->cremaModel->issetJson($data['response_heder'] ?? null), $this->cremaModel->issetErrorJson($data['response'] ?? null, $data['curl_error'] ?? null));
            }
			echo "<hr>";
        }
echo "End6";
		//$endTime = date("Y-m-d H:i:s");
		//$text .= "======== 크리마 상품전송 종료시간\n";
		//$text .= "======== ".$endTime."\n";
		//$text .= "======== 크리마 상품전송 종료시간\n\n";

		//$inpath = $_SERVER["DOCUMENT_ROOT"].'/data/barrel_data/_logs/adminLog/';

		//$fp=fopen($inpath.'/cremaAllLog.txt', 'a');
		//fwrite($fp,$text."\r\n");
		//fclose($fp);
    }

	/**
     * 구역별로 전송 펑션(임시)
     */
    public function cronCremaPutProductAllImsi($cnt)
    {
		$startLimit = $cnt * 900;

        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $rows = $this->qb
            ->select('p.id')
            ->select('p.pname')
            ->select('p.add_info')
            ->select('p.listprice')
            ->select('p.sellprice')
            ->select('p.disp')
            ->select('p.stock')
            ->from(TBL_SHOP_PRODUCT . ' AS p ')
			->orderBy('id', 'asc')
			->limit(900, $startLimit)
            ->exec()
            ->getResultArray();

        //crema api
        $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);

        $options = $this->qb
            ->select('p.id')
            ->select('po.option_name')
            ->select('p.pname')
            ->select('pod.option_div')
            ->from(TBL_SHOP_PRODUCT_OPTIONS . ' AS po')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'po.pid  = p.id')
            ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL . ' AS pod', 'pod.opn_ix = po.opn_ix')
            ->exec()
            ->getResultArray();
        $result = [];
		
        foreach ($rows as $key => $val) {
            $cremaCate = $this->getCremaCate($val['id']);
            $cremaCate = $this->chageCremaCate($cremaCate);
            $cremaOpt = [];

            foreach ($options as $k => $v) {

                if ($val['id'] == $v['id']) {
                    $cremaOpt[$k]['option_name'] = $v['option_name'];
                    $cremaOpt[$k]['option_div'] = $v['option_div'];
                }
            }

            $crema_options = array();
            if (count($cremaOpt) > 0) {
                foreach (fb_column_merge($cremaOpt, 'option_name', 'option_div') as $crema_key => $crema_opt) {
                    $crema_options[] = ["name" => $crema_key, "values" => array_unique($crema_opt)];
                }
            }

            //기존에 있던 상품의 카테고리 가져옴
            $param = ['code' => (int)$val['id']];
            $crema_product_info = $this->cremaModel->getProductInfo($param);
            $cremaCate = $this->getCremaCate($val['id']);


            if (!isset($crema_product_info['categories'])) {
                $crema_product_info['categories'] = [];
            }
            $this->putCremaCate($cremaCate);

            $inCate = [];
            foreach ($cremaCate as $cate_key => $cate_val) {
                $inCate[] = $cate_val['cid'];
            }

            $stock_count = 1;
            if ($val['stock'] <= 0) {
                $stock_count = 0;
            }

			$url = HTTP_PROTOCOL . 'getbarrel.com/shop/goodsView/' . $val['id'];

            if(strpos($url, "https://www.") === false) {
				$url = HTTP_PROTOCOL . 'www.getbarrel.com/shop/goodsView/' . $val['id'];
            }

            $param = [
                'code' => (int)$val['id']
                , 'name' => $val['pname'] . ' ' . $val['add_info']
                , 'url' => $url
                , 'org_price' => $val['listprice']
                , 'final_price' => $val['sellprice']
                , 'category_codes' => $inCate  //카테고리 arr 타입
                , 'display' => $val['disp']   //사용여부
                , 'image_url' => get_product_images_src($val['id'], $this->isUserAdult, 's')
                , 'stock_count' => $stock_count  // 재고있음 여부
                , 'product_options' => $crema_options
                , 'shop_builder_created_at' => date('Y-m-d\TH:i:sO')  //datetinme ISO8601
            ];

			$data = $this->cremaModel->putJsonProductLog(json_encode($param, JSON_UNESCAPED_UNICODE)); //없으면 생성

            if (isset($data['error_code']) && $data['error_code'] == '00') {
                //에러 아닌것
                $this->insertCremaLog('product', $this->cremaModel->issetJson($param), $this->cremaModel->issetJson($data['response'] ?? null), $this->cremaModel->issetJson($data['response_heder'] ?? null), $this->cremaModel->issetErrorJson(null, $data['curl_error'] ?? null));
            } else {
                //에러인것
                $this->insertCremaLog('product', $this->cremaModel->issetJson($param), null, $this->cremaModel->issetJson($data['response_heder'] ?? null), $this->cremaModel->issetErrorJson($data['response'] ?? null, $data['curl_error'] ?? null));
            }
        }
    }

    /**
     * 크리마 카테고리 형태로 리턴
     * @param type $pid
     * @return type
     */
    protected function getCremaCate($pid)
    {

        $rows = $this->qb
            ->select('pr.pid')
            ->select('p.pname')
            ->select('ci.co_no')
            ->select('ci.cid')
            ->from(TBL_SHOP_PRODUCT_RELATION . ' AS pr')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'p.id = pr.pid')
            ->join(TBL_SHOP_CATEGORY_INFO . ' AS ci', 'ci.cid = pr.cid')
            ->where('p.id', $pid)
            ->exec()
            ->getResultArray();
        //카테고리 분류 별로 3자리로 끊어서 배열형태로 넣음
        $cate_code = [];
        $cremaCate = [];

        foreach ($rows as $key => $val) {
            array_push($cate_code, substr($val['cid'], 0, 3));
            array_push($cate_code, substr($val['cid'], 3, 3));
            array_push($cate_code, substr($val['cid'], 6, 3));
            array_push($cate_code, substr($val['cid'], 9, 3));
            array_push($cate_code, substr($val['cid'], 12, 3));

            $cremaCate = $this->splite_crema_cate($cate_code);
			
			foreach ($cremaCate as $key1 => $val1) {
				$cremaNewCate[] = $val1;
			}

            $cate_code = [];
        }

        //return $cremaCate;
		return $cremaNewCate;
    }

    /**
     * 크리마 카테고리 배열
     * @param type $cate_code
     * @return string
     */
    protected function splite_crema_cate($cate_code)
    {
        $cid = "";
        $parent_catetory = [];
        $crema_cate = [];
        foreach ($cate_code as $key => $val) {
            //코드가 000 인 것은 없는 카테고리
            if ($val != "000") {
                $cid .= $val;

                $data = $this->qb
                    ->select('cid')
                    ->select('cname')
                    ->select('depth')
                    ->select('category_use')
                    ->select(' "" as parent_category_code ', false)
                    ->where('depth', $key)
                    ->like('cid', $cid, 'after')
                    ->from(TBL_SHOP_CATEGORY_INFO)
                    ->exec()
                    ->getRowArray();

                //상위 카테고리를 구하기 위해서 배열로 쌓음
                array_push($parent_catetory, $data['cid']);

                foreach ($data as $k => $v) {
                    $cid_key = $data['depth'];
                    $cid_key = $cid_key - 1;
                    if ($cid_key < 0)
                        $cid_key = 0;
                    if ($k == 'depth') {
                        $data[$k] = $v + 1;
                        //0번 이상부터 2뎁스 시작으로 상위 카테고리가 있음
                        if ($cid_key > 0) {
                            $data['parent_category_code'] = $parent_catetory[$cid_key];
                        } else {
                            $data['parent_category_code'] = null;
                        }
                    }
                    if ($k == 'category_use') {
                        if ($v == 1) {
                            $data[$k] = 'visible';
                        } else {
                            $data[$k] = 'hidden';
                        }
                    }
                }
                $crema_cate[$key] = $data;
            }
        }

        return $crema_cate;
    }

    /**
     * 크리마 카테고리 생성 API
     * @param type $crema_cate
     */
    protected function putCremaCate($crema_cate)
    {

        //crema api
        $this->cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);
        foreach ($crema_cate as $key => $val) {
            $param = ['code' => $val['cid']
                , 'name' => $val['cname']
                , 'parent_category_id' => null
                , 'parent_category_code' => $val['parent_category_code'] ?? null
                //, 'status' => $val['category_use'] ?? 'visible'
            ];
            $data = $this->cremaModel->putCategoryLog($param); //없으면 생성
            if (isset($data['error_code']) && $data['error_code'] == '00') {
                //에러 아닌것
                $this->insertCremaLog('category', $this->cremaModel->issetJson($param), $this->cremaModel->issetJson($data['response'] ?? null), $this->cremaModel->issetJson($data['response_heder'] ?? null), $this->cremaModel->issetErrorJson(null, $data['curl_error'] ?? null));
            } else {
                //에러인것
                $this->insertCremaLog('category', $this->cremaModel->issetJson($param), null, $this->cremaModel->issetJson($data['response_heder'] ?? null), $this->cremaModel->issetErrorJson($data['response'] ?? null, $data['curl_error'] ?? null));
            }
        }
    }
    
    /**
     * 크리마 관련 로그
     * @param type $type
     * @param type $params
     * @param type $response
     */
    public function insertCremaLog($type, $params, $response, $response_heder, $response_error)
    {
        $this->qb
            ->set('type', $type)
            ->set('params', $params)
            ->set('response', $response)
            ->set('response_heder', $response_heder)
            ->set('response_error', $response_error)
            ->set('regdate', date("Y-m-d H:i:s"))
            ->insert('crema_logs')
            ->exec();
    }

    /**
     * 크리마 카테고리 입력 코드
     * @param type $cremaCate
     * @return type
     */
    protected function chageCremaCate($cremaCate)
    {
        $codes = [];
        foreach ($cremaCate as $key => $val) {
            if (isset($val['cid'])) {
                $codes[$key] = $val['cid'];
            } elseif (isset($val['code'])) {
                $codes[$key] = $val['code'];
            }
        }
        return implode(",", $codes);
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

    /**
     * get 대카테고리 (0 depth 카테고리)
     * @param string $cid
     * @param int $depth
     * @return array
     */
    public function getLargeCategoryList()
    {
        $datas = $this->qb
            ->select('cname, cid, depth, global_cinfo, is_layout_emphasis, category_type, category_link')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->where('depth', '0')
            ->where('category_use', '1')
            ->where('is_delete', 0)
            ->orderBy('vlevel1', 'asc')
            ->exec()
            ->getResultArray();

        if (!empty(BASIC_LANGUAGE) && BASIC_LANGUAGE != 'korean') {
            if (!empty($datas)) {
                foreach ($datas as $key => $val) {
                    $global_cinfo = json_decode($val['global_cinfo'], true);
                    $datas[$key]['cname'] = urldecode($global_cinfo['cname'][BASIC_LANGUAGE]);
                }
            }
        }
        return $datas;
    }

    public function getLargeEnCategoryList()
    {
        $datas = $this->qb
            ->select('cname, cid, depth,global_cinfo')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->where('depth', '0')
            ->where('category_use', '1')
            ->where('is_delete', 0)
            ->orderBy('vlevel1', 'asc')
            ->exec()
            ->getResultArray();


        if (!empty($datas)) {
            foreach ($datas as $key => $val) {
                $global_cinfo = json_decode($val['global_cinfo'], true);
                $datas[$key]['cname'] = urldecode($global_cinfo['cname']['english']);
            }
        }

        return $datas;
    }

    /**
     * 특정 카테고리 하위 1개의 데이터만 호출
     * @param string $cid
     * @return array
     */
    public function getCategorySubList($cid, $pathBool = false)
    {
        $depth = $this->getDepth($cid); //depth 계산

        $this->qb->startCache();
        $this->qb
            ->select('cname, cid, depth, global_cinfo, is_layout_emphasis, category_type, category_link')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->where('category_use', '1')
            ->orderBy('vlevel1, vlevel2, vlevel3, vlevel4, vlevel5', 'asc');

        if (!empty($cid)) {
            $this->qb->like('cid', substr($cid, 0, 3 * ($depth + 1)), 'after');
            $this->qb->where('depth', ($depth + 1));
        } else {
            $this->qb->where('depth', $depth);
        }
        $this->qb->stopCache();

        $datas = $this->qb->exec()->getResultArray();
        $this->qb->flushCache(); //sql 캐시 날리기

        if (!empty(BASIC_LANGUAGE) && BASIC_LANGUAGE != 'korean') {
            if (!empty($datas)) {
                foreach ($datas as $key => $val) {
                    $global_cinfo = json_decode($val['global_cinfo'], true);
                    $datas[$key]['cname'] = urldecode($global_cinfo['cname'][BASIC_LANGUAGE]);
                }
            }
        }
        if ($pathBool) {
            foreach ($datas as $k => $v) {
                $datas[$k]['pathArray'] = $this->getCategoryPath($v['cid'], $v['depth']);
            }
        }

        return $datas;
    }

    /**
     * 특정 카테고리 하위 1개의 데이터만 호출
     * @param string $cid
     * @return array
     */
    public function getEnCategorySubList($cid, $pathBool = false)
    {
        $depth = $this->getDepth($cid); //depth 계산

        $this->qb->startCache();
        $this->qb
            ->select('cname, cid, depth,global_cinfo')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->where('category_use', '1')
            ->orderBy('vlevel1, vlevel2, vlevel3, vlevel4, vlevel5', 'asc');

        if (!empty($cid)) {
            $this->qb->like('cid', substr($cid, 0, 3 * ($depth + 1)), 'after');
            $this->qb->where('depth', ($depth + 1));
        } else {
            $this->qb->where('depth', $depth);
        }
        $this->qb->stopCache();

        $datas = $this->qb->exec()->getResultArray();
        $this->qb->flushCache(); //sql 캐시 날리기


        if (!empty($datas)) {
            foreach ($datas as $key => $val) {
                $global_cinfo = json_decode($val['global_cinfo'], true);
                $datas[$key]['cname'] = urldecode($global_cinfo['cname']['english']);
            }
        }

        if ($pathBool) {
            foreach ($datas as $k => $v) {
                $datas[$k]['pathArray'] = $this->getCategoryPath($v['cid'], $v['depth']);
            }
        }

        return $datas;
    }

    /**
     * 크리마에서 마일리지 콜백으로 넘어올때 해당 상품 리뷰 +1
     * after_cnt
     * @param type $post
     */
    public function cremaMileAgeCallBackProductRecommand($post = [])
    {
        if (isset($post['product_code']) && $post['product_code']) {

            $pid = str_pad($post['product_code'], 10, "0", STR_PAD_LEFT);
            $rows = $this->qb
                ->select('p.id')
                ->select('p.pname')
                ->from(TBL_SHOP_PRODUCT . ' AS p')
                ->where("p.id", $pid)
                ->exec()
                ->getResultArray();

            //crema api
            $cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);

            foreach ($rows as $key => $val) {
                //크리마 리뷰 카운트 가져오기
                $param = ['code' => (int)$val['id']];
                $data = $cremaModel->getProductInfo($param);
                $total_review_cnt = $data['reviews_count'] ?? 0;

                $score = 0;
                if (isset($data['reviews_count'])) {
                    $param = ['product_code' => (int)$val['id'], 'page' => 1, 'limit' => 100];
                    $data_review = $cremaModel->getReviewInfo($param);
                    $score = 0;

                    if (count($data_review) > 0) {
                        foreach ($data_review as $review_key => $review_val) {
                            $score += $review_val['score'];
                        }
                        $score = ($score / count($data_review)) * 100; //*100 해서 실수를 정수형으로 바꾸고, 표현은 /100해서 실수로
                    }
                }


                $this->qb
                    ->set('after_score', $score)
                    ->set('after_cnt', $total_review_cnt)
                    ->where('id', $val['id'])
                    ->update(TBL_SHOP_PRODUCT)
                    ->exec();
            }
        }
    }

    /**
     * 크리마의 리뷰 카운트 숫자 동기화 크론
     */
    public function cremaReviewCount()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $rows = $this->qb
            ->select('p.id')
            ->select('p.pname')
            ->from(TBL_SHOP_PRODUCT . ' AS p')
            ->exec()
            ->getResultArray();


        //crema api
        $cremaModel = new CremaHandler(['environment' => DB_CONNECTION_DIV]);


        foreach ($rows as $key => $val) {
            //크리마 리뷰 카운트 가져오기
            $param = ['code' => (int)$val['id']];
            $data = $cremaModel->getProductInfo($param);
            //$total_review_cnt = $data['reviews_count'] ?? 0;
            $total_review_cnt = $data['meta_reviews_count'] ?? 0;

            $score = 0;
            if (isset($data['reviews_count'])) {
                $param = ['product_code' => (int)$val['id'], 'page' => 1, 'limit' => 100];
                $data_review = $cremaModel->getReviewInfo($param);
                $score = 0;

                if (count($data_review) > 0) {
                    foreach ($data_review as $review_key => $review_val) {
                        $score += $review_val['score'];
                    }
                    $score = ($score / count($data_review)) * 100; //*100 해서 실수를 정수형으로 바꾸고, 표현은 /100해서 실수로
                }
            }

            $this->qb
                ->set('after_score', $score)
                ->set('after_cnt', $total_review_cnt)
                ->where('id', $val['id'])
                ->update(TBL_SHOP_PRODUCT)
                ->exec();
        }
    }

    /**
     * 크리마 리뷰 카운트 개별 업데이트 (웹훅)
     * since 2020-02-17
     */
    public function cremaReviewCountById($datas){
        $updateBool = false;
        if(isset($datas['meta_score'])){
            $score = $datas['meta_score'] * 100; //*100 해서 실수를 정수형으로 바꾸고, 표현은 /100해서 실수로
            $this->qb->set('after_score',$score);
            $updateBool = true;
        }
        if(isset($datas['meta_reviews_count'])){
            $this->qb->set('after_cnt',$datas['meta_reviews_count']);
            $updateBool = true;
        }
        $pid = $datas['product_code'];
        if($pid && $updateBool === true){
            $this->qb
                ->where('id', $pid)
                ->update(TBL_SHOP_PRODUCT)
                ->exec();

            log_message('error', 'cremaReviewCountById : '.$this->qb->lastQuery());
        }

    }


    /**
     * where 세팅
     * elascitsearch 사용하면 해당 검색 조건을 사용하지 않는다
     * @param array $where
     * @return
     */
    protected function setWhere($where)
    {
        if ((constant('USE_ELASTICSERACH') === true)) {
            // no action 
        } else {
            if (is_array($where) && !empty($where)) {
                foreach ($where as $k => $v) {
                    if (empty($v)) {
                        continue;
                    } else {
                        if ($k == 'filterCid') {
                            $depth = $this->getDepth($v);
                            $this->qb->like('r.cid', substr($v, 0, 3 * ($depth + 1)), 'after');
                        } else if ($k == 'filterBrands') {
                            $brands = explode(',', $v);
                            $this->qb->whereIn('p.brand', $brands);
                        } else if ($k == 'filterDeliveryFree') {
                            $this->qb->where('dt.delivery_policy', 1);
                        } else if ($k == 'filterText') {
                            $vReplace = preg_replace("/\s+/", "", $v);
                            $this->qb->groupStart()
                                ->like('p.pname', $v, 'both')
                                ->orWhere("REPLACE(p.pname, ' ', '') LIKE '%{$v}%'")
                                ->orWhere("REPLACE(p.pname, ' ', '') LIKE '%{$vReplace}%'")
                                ->orLike('p.search_keyword', $v, 'both')
                                ->orWhere("REPLACE(p.search_keyword, ' ', '') LIKE '%{$v}%'")
                                ->orWhere("REPLACE(p.search_keyword, ' ', '') LIKE '%{$vReplace}%'")
                                ->groupEnd();
                        } else if ($k == 'filterInsideText') {
                            $this->qb->like('p.pname', $v, 'both');
                        }
                    }
                }
            }
        }
        return $this->qb;
    }

    /**
     * 같이 구매한 상품 리스트
     */
    public function getTogeterProduct($post = [])
    {

        $sql = $this->basicWhere()
                    ->select('p.id')
                    ->select('p.pname')
                    ->from(TBL_SHOP_PRODUCT ." as p")
                    ->where('p.id in ' . $this->qb->startSubQuery()
                            ->select('od.pid')
                            ->from(TBL_SHOP_ORDER_DETAIL ." as od")
                            ->where('od.oid in ' . $this->qb->startSubQuery()
                                ->select('oid')
                                ->from(TBL_SHOP_ORDER_DETAIL)
                                ->where('pid', $post['pid'])
                                ->whereNotIn('status',['SR','IR'])
                                ->groupBy('od.pid')
                                ->endSubQuery()
                            , '', false)
                            ->endSubQuery()
                        , '', false)
                    ->groupBy('p.id')
                    ->toStr();

        $rows = $this->qb
            ->select('id')
            ->select('pname')
            ->from("(".$sql.") as a")
            ->whereNotIn('a.id',$post['pid'])
            ->orderBy('a.id','RANDOM')
            ->limit(12)
            ->exec()->getResultArray();

//        $rows = $this->getListById(array_column($rows, 'pid'));
        $product = [];
        $product = $this->getListById(array_column($rows, 'id'), 'slist');

//        foreach ($rows as $key => $val) {
//            $perprice = 0;
//            if ($val['listprice'] > 0) {
//                $perprice = (int)($val['listprice'] - $val['sellprice']) / $val['listprice'] * 100;
//            }
//            $product[$key]['pid'] = $val['id'];
//            $product[$key]['pname'] = $val['pname'];
//            $product[$key]['listprice'] = $val['listprice'];
//            $product[$key]['sellprice'] = $val['sellprice'];
//            $product[$key]['perprice'] = $perprice;
//            $product[$key]['add_info'] = $val['add_info'];
//            $product[$key]['thumb_nail'] = get_product_images_src($val['id'], $this->isUserAdult, 'ms');
//        }

        return $product;
    }

    /**
     * 연관 상품 리스트
     */
    public function getRelationProduct($post = [])
    {
        $rows = $this->basicWhere()
            ->select('p.id')
            ->select('p.pname')
            ->select('p.listprice')
            ->select('p.sellprice')
            ->select('p.add_info')
            ->from('shop_relation_product3 AS pr')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'pr.rp_pid = p.id')
            ->where('pr.pid', $post['pid'])
            ->whereIn('p.mall_ix', ['', MALL_IX])
            ->where('product_type != ', 77)
            ->orderBy('pr.vieworder','asc')
            ->limit(12)
            ->exec()
            ->getResultArray();
        $product = [];
        $product = $this->getListById(array_column($rows, 'id'), 'slist');

        return $product;
    }

    /**
     * 유사 상품 리스트
     */
    public function getSimilarProduct($post = [])
    {
        $cid = "";
        $cate_code = [];
        array_push($cate_code, substr($post['cid'], 0, 3));
        array_push($cate_code, substr($post['cid'], 3, 3));
        array_push($cate_code, substr($post['cid'], 6, 3));
        array_push($cate_code, substr($post['cid'], 9, 3));
        array_push($cate_code, substr($post['cid'], 12, 3));
        foreach ($cate_code as $key => $val) {
            if ($val && (int)$val) {
                $cid .= $val; // 000 을 제외하고 값이 있는 카테고리 뎁스까지만
            }
        }
        $rows = $this->basicWhere()
            ->select('p.id')
            ->select('p.pname')
            ->select('p.listprice')
            ->select('p.sellprice')
            ->select('p.add_info')
            ->from(TBL_SHOP_PRODUCT_RELATION . ' AS pr')
            ->join(TBL_SHOP_CATEGORY_INFO . ' AS c', 'pr.cid = c.cid')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'pr.pid = p.id')
            ->like('c.cid', $cid, 'after')
            ->where('p.id !=', $post['pid'])
            ->whereIn('p.mall_ix', ['', MALL_IX])
            ->where('product_type != ', 77)
            ->orderBy('p.id','RANDOM')
            ->limit(12)
            ->exec()
            ->getResultArray();
        $product = [];
        $product = $this->getListById(array_column($rows, 'id'), 'slist');
//        foreach ($rows as $key => $val) {
//            $perprice = 0;
//            if ($val['listprice'] > 0) {
//                $perprice = (int)($val['listprice'] - $val['sellprice']) / $val['listprice'] * 100;
//            }
//            $product[$key]['pid'] = $val['id'];
//            $product[$key]['pname'] = $val['pname'];
//            $product[$key]['listprice'] = $val['listprice'];
//            $product[$key]['sellprice'] = $val['sellprice'];
//            $product[$key]['perprice'] = $perprice;
//            $product[$key]['add_info'] = $val['add_info'];
//            $product[$key]['thumb_nail'] = get_product_images_src($val['id'], $this->isUserAdult, 'ms');
//
//            if (!empty($val['icons'])) {
//                $icons_exp = explode(';', $val['icons']);
//                foreach ($icons_exp as $icons_key => $icons_val) {
//                    $product[$key]['icons_path'][$icons_key] = "<img src='" . IMAGE_SERVER_DOMAIN . DATA_ROOT . "/images/icon/" . $icons_val . ".gif'>";
//                }
//            }
//        }

        return $product;
    }

    protected function setOrderby($sort, $depth = false)
    {
        switch ($sort) {
            case 'orderCnt':
                $this->qb->orderBy('p.order_cnt', 'desc');
                break;
            case 'lowPrice':
                $this->qb->orderBy('p.sellprice', 'asc');
                break;
            case 'highPrice':
                $this->qb->orderBy('p.sellprice', 'desc');
                break;
            case 'regDate':
                $this->qb->orderBy('p.regdate', 'desc');
                break;
            case 'afterCnt':
                $this->qb->orderBy('p.after_cnt', 'desc');
                break;
            case 'viewOrder':
                if($depth === false ){
                    $this->qb->orderBy('p.regdate', 'desc');
                } else {
                    $sortDepth = 'sortdepth' . $depth;
                    $this->qb->orderBy($sortDepth, 'asc')
                        ->orderBy('p.regdate', 'desc');
                }
                break;
            default:
                $this->qb->orderBy('p.regdate', 'desc');
                break;
        }
        return $this->qb;
    }

    public function getCategoryMenu($cid)
    {

        $cate['0'] = substr($cid, 0, 3);

        $datas = $this->qb
            ->select('cname, cid,category_link, depth,global_cinfo')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->where('category_type', 'M')
            ->where('is_delete', 0)
            ->whereNotIn('depth', 0)
            ->like('cid', $cate['0'], 'after')
            ->orderBy('vlevel2', 'asc')
            ->exec()
            ->getResultArray();

        if (!empty(BASIC_LANGUAGE) && BASIC_LANGUAGE != 'korean') {
            if (!empty($datas)) {
                foreach ($datas as $key => $val) {
                    $global_cinfo = json_decode($val['global_cinfo'], true);
                    $datas[$key]['cname'] = urldecode($global_cinfo['cname'][BASIC_LANGUAGE]);
                }
            }
        }
        return $datas;
    }

    public function getStyleCode($pid)
    {
        if (!empty($pid)) {
            $options = $this->qb
                ->select('option_gid')
                ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
                ->where('pid', $pid)
                ->limit(1)
                ->exec()->getRowArray();

            if ($options['option_gid']) {
                $data = $this->qb
                    ->select('style')
                    ->select('color')
                    ->from(TBL_INVENTORY_GOODS)
                    ->where('gid', $options['option_gid'])
                    ->exec()->getRowArray();

                return $data['style'] . $data['color'];
            }
        }
    }

    /**
     * 특정 카테고리의 상위, 동위 카테고리 데이터 전체 호출
     * @param string $cid
     * @return array
     */
    public function getCategoryNavigationList($cid)
    {
        $depth = $this->getDepth($cid); //depth 계산
        $cids = array();
        for ($i = 0; $i <= $depth; $i++) {
            if (!empty($cid)) {
                $this->qb->select('if(SUBSTRING(cid, 1, ' . (3 * ($i + 1)) . ')="' . substr($cid, 0, 3 * ($i + 1)) . '", 1, 0) as isBelong');

                if ($i > 0) {
                    $this->qb->like('cid', substr($cid, 0, 3 * $i), 'after');
                }
            }

            $datas = $this->qb
                ->select('cid, cname, depth,global_cinfo')
                ->from(TBL_SHOP_CATEGORY_INFO)
                ->where('depth', $i)
                ->where('category_use', '1')
                ->exec()->getResultArray();


            if (!empty(BASIC_LANGUAGE) && BASIC_LANGUAGE != 'korean') {
                if (!empty($datas)) {
                    foreach ($datas as $key => $val) {
                        $global_cinfo = json_decode($val['global_cinfo'], true);
                        $datas[$key]['cname'] = urldecode($global_cinfo['cname'][BASIC_LANGUAGE]);
                    }
                }
            }

            if (!empty($datas)) {
                $cids[] = $datas;
            }
        }

        return $cids;
    }

    /**
     * 추가이미지 호출
     * @param string $id
     * @param boolean $isAdult
     * @return array
     */
    protected function getAddImagesSrc($id, $isAdult = false)
    {
        $addIds = $this->qb
            ->select('*')
            ->from(TBL_SHOP_ADDIMAGE)
            ->where('pid', $id)
            ->exec()->getResultArray();

        $basicPath = DATA_ROOT . "/images/product";
        $basicAddPath = DATA_ROOT . "/images/addimg";

        $addImgs = array();
        foreach ($addIds as $k => $v) {

            //19세 상품일때
            if (!$this->isUserAdult && $isAdult) {
                $addImgs[] = IMAGE_SERVER_DOMAIN . $basicPath . '/product_19_200.gif';
                continue;
            }

            $imgDir = implode("/", str_split(zerofill($id), 2));
            $imageBigSrc = IMAGE_SERVER_DOMAIN . $basicAddPath . '/' . $imgDir . "/b_" . zerofill($v['id'], 8) . "_add.gif";
            $imageSmallSrc = IMAGE_SERVER_DOMAIN . $basicAddPath . '/' . $imgDir . "/m_" . zerofill($v['id'], 8) . "_add.gif";

            //이미지 없을떄
            $addImgs[] = array('bigImg' => $imageBigSrc, 'smallImg' => $imageSmallSrc);
        }

        return $addImgs;
    }

    /**
     * 최근 본 상품을 추가/갱신 한다.
     * @param string $userCode 회원코드
     * @param string $pid 상품코드
     * @param string $cid 카테고리코드
     * @return boolean | int
     */
    public function replaceProductViewHistory($userCode, $pid, $cid = '')
    {
        if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === false) {
            // 배럴데이 아닐때만 실행
            if ($pid) {
                $row = $this->qb
                    ->select('vh_ix')
                    ->select('view_cnt')
                    ->from(TBL_SHOP_VIEW_HISTORY)
                    ->where('pid', $pid)
                    ->where('mem_ix', $userCode)
                    ->limit(1)
                    ->exec()
                    ->getRow();

                $this->qb
                    ->set('pid', $pid)
                    ->set('cid', $cid)
                    ->set('mem_ix', $userCode);

                if (isset($row->vh_ix)) {
                    if ($row->view_cnt >= 2) {
                        $this->qb->set('regdate', date('Y-m-d H:i:s'));
                    }

                    $this->qb
                            ->set('view_cnt', 'view_cnt + 1', false)
                            ->where('vh_ix', $row->vh_ix)
                            ->update(TBL_SHOP_VIEW_HISTORY)
                            ->exec();
                } else {
                    $this->qb
                            ->set('regdate', date('Y-m-d H:i:s'))
                            ->insert(TBL_SHOP_VIEW_HISTORY)
                            ->exec();
                }

            } else {
                // 로그인전 최근본 상품 세션 확인
                $viewHistory = sess_val('latest_product_view');
                if (!empty($viewHistory)) {
                    foreach ($viewHistory as $pid) {
                        $this->replaceProductViewHistory($this->userInfo->code, $pid, '');
                    }

                    $_SESSION['latest_product_view'] = [];
                }
            }
        }
    }

    public function getCategoryName($cid){
        $datas = $this->qb
            ->select('cname')
            ->select('global_cinfo')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->where('cid',$cid)
            ->exec()->getRowArray();


        if (!empty(BASIC_LANGUAGE) && BASIC_LANGUAGE != 'korean') {
            if (!empty($datas)) {
                $global_cinfo = json_decode($datas['global_cinfo'], true);
                $datas['cname'] = urldecode($global_cinfo['cname'][BASIC_LANGUAGE]);
            }
        }
        return $datas;
    }

    /**
     * 인기검색어
     * @return array
     */
    public function getPopularKeyword($limit = 20, $offset = 0)
    {
        $searchKeyWord = ForbizConfig::getSharedMemory('mobile_search_keyword','0');

        $scIxArray=array();
        for($i=1;$i<=20;$i++){
            if( ! empty($searchKeyWord['code'.($i)])){
                $scIxArray[] = $searchKeyWord['code'.($i)];
            }
        }
        $datas = array();
        if(count($scIxArray)>0){

            if(BASIC_LANGUAGE == 'english'){
                $this->qb
                    ->select('keyword_global as keyword')
                    ->whereNotIn('keyword_global','');
            }else{
                $this->qb
                    ->select('keyword')
                    ->whereNotIn('keyword','');
            }

            $datas = $this->qb
                ->from(TBL_SHOP_SEARCH_KEYWORD)
                ->where('recommend', '0')
                ->whereIn('k_ix',$scIxArray)
                ->orderBy("FIELD(k_ix," . implode(",",$scIxArray).")",'ASC',false)
                ->limit($limit, $offset)->exec()->getResultArray();
        }

        return $datas;
    }

    /**
     * 상품 상세 정보 고시 영문 호출
     * @param string $id
     * @return array
     */
    public function getMandatoryInfosGlobal($id)
    {
        $datas = $this->qb
            ->select('pmi_title')
            ->select('pmi_desc')
            ->from(TBL_SHOP_PRODUCT_MANDATORY_INFO_GLOBAL)
            ->where('pid', $id)
            ->exec()->getResultArray();
        return $datas;
    }

    /**
     * 카테고리 사용 미사용 숨김 정보 획득
     */
    public function getCategoryUseData($cid){
        $data = $this->qb
            ->select('category_use, category_sort')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->where('cid',$cid)
            ->exec()->getRowArray();
        return $data;
    }

    /**
     * get 상품 구매 수량 조건
     * @param int $id
     * @param string $userCode
     * @return array
     */
    public function getBuyCountCondition($id, $userCode = '')
    {
        if ($this->sellingType == 'W') {
            $this->qb
                ->select('wholesale_allow_basic_cnt as allow_basic_cnt')
                ->select('wholesale_allow_max_cnt as allow_max_cnt')
                ->select('wholesale_allow_byoneperson_cnt as allow_byoneperson_cnt');
        } else {
            $this->qb
                ->select('allow_basic_cnt as allow_basic_cnt')
                ->select('allow_max_cnt as allow_max_cnt')
                ->select('allow_byoneperson_cnt as allow_byoneperson_cnt');
        }

        $row = $this->qb
            ->from(TBL_SHOP_PRODUCT.' as p')
            ->where('p.id', $id)
            ->exec()->getRowArray();

        //최소 구매 수량
        $allowBasicCnt       = (!empty($row['allow_basic_cnt']) ? $row['allow_basic_cnt'] : 0);
        //1회 최대 구매 수량
        $allowMaxCnt         = (!empty($row['allow_max_cnt']) ? $row['allow_max_cnt'] : 0);
        //ID당 구매수량
        $allowByOnePersonCnt = (!empty($row['allow_byoneperson_cnt']) ? $row['allow_byoneperson_cnt'] : 0);
        //회원 상품 구매수량
        $userBuyCnt          = 0;

        if ($allowByOnePersonCnt > 0) {
            if (!empty($userCode)) {
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
                    ->where('od.pid', $id)
                    ->where('o.user_code', $userCode)
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
                $userBuyCnt = $allowByOnePersonCnt;
            }
        }
        return ['allow_basic_cnt' => $allowBasicCnt, 'allow_max_cnt' => $allowMaxCnt, 'allow_byoneperson_cnt' => $allowByOnePersonCnt, 'user_buy_cnt' => $userBuyCnt];
    }

    public function getItemCodeByProduct($gid){
        $product = $this->qb
                    ->select('pid')
            ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL)
            ->where('option_gid',$gid)
            ->exec()->getRowArray();

        return $product;
    }

    /**
     * 상품 기본 were 조건
     * @return qb
     */
    public function basicWhere($filter = false)
    {
        if ($filter !== false) {
            $this->setWhere($filter);
        }

        return $this->qb
            ->whereIn('p.mall_ix', ['', MALL_IX])
            ->where('p.is_delete', '0')
            ->where('p.disp', '1')
            ->whereIn('p.state', ['1', '0', '4'])
            ->where("if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')",
                '', false)
            ->where('p.product_type != ', 77);
    }

    /**
     * 주문 사은품 존재 체크
     * 1. 구매금액별
     * 2. 카테고리별
     * 3. 특정상품 포함 구매금액별
     */
    public function getFreeGiftInfo($cartData,$freeGiftCondition='all',$payment_price=0){
        $datas = [];

        switch($freeGiftCondition){
            case 'all':
                $datas[] = $this->getFreeGiftNew('G',$payment_price,'','',$cartData);// 구매금액별 사은품 정보
                $datas[] = $this->getFreeGiftByCategory($cartData);//카테고리별 사은품
                $datas[] = $this->getFreeGiftByProducts($cartData,$payment_price);// 특정 상품포함 사은품 정보
                break;
            case 'G';
                $datas[] = $this->getFreeGiftNew('G',$payment_price,'','',$cartData);// 구매금액별 사은품 정보
                break;
            case 'C';
                $datas[] = $this->getFreeGiftByCategory($cartData);//카테고리별 사은품
                break;
            case 'P';
                $datas[] = $this->getFreeGiftByProducts($cartData,$payment_price);// 특정 상품포함 사은품 정보
                break;
        }



        return array_filter($datas);
    }


    /**
     * 구매상품 카테고리 매칭 시 상픔의 카테고리 정보 매칭 여부 체크
     */
    public function getFreeGiftByCategory($cartData){
        $matchGiftKey = [];
        foreach ($cartData as $company) {
            foreach ($company['deliveryTemplateList'] as $deliveryTemplate) {
                foreach ($deliveryTemplate['productList'] as $product) {
                    $datas = $this->qb
                        ->select('fc.fg_ix')
                        ->from(TBL_SHOP_CATEGORY_INFO .' as c')
                        ->join(TBL_SHOP_PRODUCT_RELATION .' as pr','c.cid = pr.cid','left')
                        ->join(TBL_SHOP_FREEGIFT_CATEGORY_RELATION .' as fc','pr.cid = fc.cid', 'inner')
                        ->where('c.category_use','1')
                        ->where('pr.pid',$product['id'])
                        ->exec()->getResultArray();

                    if(isset($datas)){
                        foreach($datas as $val){
                            $matchGiftKey[] = $val['fg_ix'];
                        }
                    }
                }
            }
        }
        if(isset($matchGiftKey) && count($matchGiftKey) > 0){
            return $this->getFreeGiftNew('C','',array_unique($matchGiftKey),'',$cartData);
        }
    }

    /**
     * 구매상품 특정 상품 포함 사은품 정보
     */
    public function getFreeGiftByProducts($cartData,$payment_price){
        $matchGiftKey = [];
        foreach ($cartData as $company) {
            foreach ($company['deliveryTemplateList'] as $deliveryTemplate) {
                foreach ($deliveryTemplate['productList'] as $product) {
                    $datas = $this->qb
                        ->select('fg_ix')
                        ->from(TBL_SHOP_FREEGIFT_SELECT_PRODUCT_RELATION )
                        ->where('pid',$product['id'])
                        ->exec()->getResultArray();

                    if(isset($datas)){
                        foreach($datas as $val){
                            $matchGiftKey[] = $val['fg_ix'];
                        }
                    }
                }
            }
        }

        if(isset($matchGiftKey) && count($matchGiftKey) > 0){
            return $this->getFreeGiftNew('P',$payment_price,array_unique($matchGiftKey),'',$cartData);
        }
    }

	public function getLaundryList($depth, $cid){

		$laundryList = $this->qb
            ->select('cid, title, title_en, contents, contents_en')
			->select('"카테고리를 선택해 주세요." as category')
            ->from('shop_laundry_info')
            ->where('laundry_use','1')
			->where('laundry_use_en','1')
			->where('depth',$depth)
			->like('cid', $cid, 'after')
			->orderBy("vlevel1",'ASC')
			->orderBy("vlevel2",'ASC')
			->orderBy("vlevel3",'ASC')
			->orderBy("vlevel4",'ASC')
			->orderBy("vlevel5",'ASC')
            ->exec()->getResultArray();

		return $laundryList;
	}
}
