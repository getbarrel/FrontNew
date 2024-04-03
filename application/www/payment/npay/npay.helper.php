<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('npay_pinfo_xml')) {

    /**
     * 네이버페이 상품 정보 조회용 XML
     * @param array $data
     * @return string
     */
    function npay_pinfo_xml($data)
    {
        if (isset($data['id'])) {
            $xml[] = '<item id="'.$data['id'].'">';
            $xml[] = '    <name><![CDATA['.$data['pname'].']]></name>';
            $xml[] = '    <url>'.'/shop/goodsView/'.$data['id'].'</url>';
            $xml[] = '    <description><![CDATA['.$data['basicinfo'].']]></description>';
            $xml[] = '    <image>'.$data['image_src'].'</image>';
            $xml[] = '    <thumb>'.$data['thumb_src'].'</thumb>';
            $xml[] = '    <price>'.$data['sellprice'].'</price>';
            $xml[] = '    <quantity>'.$data['stock'].'</quantity>';

            if (!empty($data['cates'])) {
                $xml[] = '    <category>';
                if (isset($data['cates']['0'])) {
                    $xml[] = '        <first id="MJ01">'.$data['cates']['0'].'</first>';
                }
                if (isset($data['cates']['1'])) {
                    $xml[] = '        <second id="ML01">'.$data['cates']['0'].'</second>';
                }
                if (isset($data['cates']['2'])) {
                    $xml[] = '        <third id="MN01">'.$data['cates']['2'].'</third>';
                }
                $xml[] = '    </category>';
            }

            if (!empty($data['options'])) {
                $xml[] = '    <options>';
                foreach ($data['options'] as $opt) {
                    $xml[] = '        <option name="'.$opt['option_name'].'">';
                    foreach ($opt['optionDetailList'] as $oDetail) {
                        $xml[] = '            <select> <![CDATA[ '.$oDetail['option_div'].' ]]> </select>';
                    }
                    $xml[] = '        </option>';
                }
                $xml[] = '    </options>';
            }
            $xml[] = '</item>';

            return implode("\n", $xml);
        } else {
            return '';
        }
    }
}

if (!function_exists('npay_buy')) {

    /**
     * 네이버페이 구매용 XML 생성함수
     * @param array $data
     * @return string
     */
    function npay_buy($cartIxs)
    {
        $cartInfo = npay_get_cart_data($cartIxs);

        if (!empty($cartInfo)) {

            //return $cartInfo;

            // 카트 정보 삭제
//            npay_del_cart_data($cartIxs);
            $baseUrl      = HTTP_PROTOCOL.FORBIZ_HOST;
            $cartUrl      = $baseUrl.'/shop/cart';
            $goodsViewUrl = $baseUrl.'/shop/goodsView';

            $xml[] = '<?xml version="1.0" encoding="utf-8"?>';
            $xml[] = '<order>';
            $xml[] = '<merchantId>'.NPAY_SHOP_ID.'</merchantId>';
            $xml[] = '<certiKey>'.NAPY_CERTI_KEY.'</certiKey>';
            $xml[] = '<backUrl><![CDATA['.$cartUrl.']]></backUrl>';

            foreach ($cartInfo as $cart) {
                foreach ($cart['deliveryTemplateList'] as $delivery) {
                    foreach ($delivery['productList'] as $product) {
                        // 파라미터 정보를 이용하여 가맹점 데이터를 가지고 온 후 XML로 구성
                        $xml[] = '<product>';
                        $xml[] = '<id>'.$product['id'].'</id>'; // 상품코드
                        $xml[] = '<ecMallProductId>'.$product['id'].'</ecMallProductId>'; // 네이버 EP 연동 상품 ID
                        $xml[] = '<name><![CDATA['.$product['pname'].']]></name>';
                        $xml[] = '<basePrice>'.$product['sellprice'].'</basePrice>';
                        $xml[] = '<taxType>TAX</taxType>'; // 과세 여부 (과세: TAX, 면세: TAX_FREE, 영세: ZERO_TAX)
                        $xml[] = '<infoUrl><![CDATA['.$goodsViewUrl.$product['id'].']]></infoUrl>';
                        $xml[] = '<imageUrl><![CDATA['.$product['image_src'].']]></imageUrl>';
                        // $xml[] = '<giftName><![CDATA['.$product['giftName'].']]></giftName>'; // 사은품명
                        // 배송 정책 정보

                        $feePayType = 'CASH_ON_DELIVERY'; // 배송비 결제방법 (착불)
                        $feeType    = ($delivery['total_delivery_price'] > 0 ? 'CHARGE' : 'FREE'); // 배송비 유형

                        $xml[] = '<shippingPolicy>';
                        $xml[] = '  <groupId>'.$delivery['dt_ix'].'</groupId>';
                        $xml[] = '  <method>DELIVERY</method>'; // 배송방법
                        $xml[] = '  <feePayType>'.$feePayType.'</feePayType>';
                        $xml[] = '  <feeType>'.$feeType.'</feeType>';
                        $xml[] = '  <feePrice>'.$delivery['total_delivery_price'].'</feePrice>'; // 기본배송비
                        if ($delivery['delivery_region_use'] == 1) {
                            $xml[] = '  <surchargeByArea>';
                            $xml[] = '      <apiSupport>false</apiSupport>';
                            $xml[] = '      <splitUnit>'.$delivery['delivery_region_area'].'</splitUnit>';
                            $xml[] = '      <area2Price>'.$delivery['delivery_jeju_price'].'</area2Price>';
                            $xml[] = '      <area3Price>'.$delivery['delivery_except_price'].'</area3Price>';
                            $xml[] = '  </surchargeByArea>';
                        }
                        $xml[] = '</shippingPolicy>';

                        $opt = explode(':', $product['options_text']);

                        $xml[] = '<option>';
                        $xml[] = '  <quantity>'.$product['pcount'].'</quantity>';
                        $xml[] = '  <selectedItem>';
                        $xml[] = '      <type>SELECT</type>';
                        $xml[] = '      <name><![CDATA['.$opt[0].']]></name>';
                        $xml[] = '      <value>';
                        $xml[] = '          <id>'.$product['select_option_id'].'</id>';
                        $xml[] = '          <text><![CDATA['.$opt[1].']]></text>';
                        $xml[] = '      </value>';
                        $xml[] = '  </selectedItem>';
                        $xml[] = '</option>';

                        if (!empty($product['addOptionList'])) {
                            foreach ($product['addOptionList'] as $supplement) {
                                $xml[] = '<supplement>';
                                $xml[] = '  <id>'.$supplement['opn_d_ix'].'</id>';
                                $xml[] = '  <name><![CDATA['.$supplement['opn_text'].']]></name>';
                                $xml[] = '  <price>'.$supplement['sellprice'].'</price>';
                                $xml[] = '  <quantity>'.$supplement['opn_count'].'</quantity>';
                                $xml[] = '</supplement>';
                            }
                        }
                        $xml[] = '</product>';
                    }
                }
            }
            $xml[] = '</order>';

            return npay_api_exec('order', implode("\n", $xml));
        } else {
            return false;
        }
    }
}

if (!function_exists('npay_api_exec')) {

    /**
     * 네이버 페이 API 호출
     * @param string $type
     * @param string $xml
     * @return array
     */
    function npay_api_exec($type, $xml)
    {
        $api = [
            'order' => [
                'exec' => "https://".NPAY_REQ_HOST."/o/customer/api/order/v20/register"
                , 'url' => "https://".NPAY_ORDER_HOST."/customer/buy"
            ]
        ];

        if (isset($api[$type])) {
            // 주문 등록 API 호출
            $ci       = curl_init();
            curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ci, CURLOPT_HTTPHEADER, ['Content-Type: application/xml; charset=utf-8']);
            curl_setopt($ci, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ci, CURLOPT_URL, $api[$type]['exec']);
            curl_setopt($ci, CURLOPT_POST, TRUE);
            curl_setopt($ci, CURLOPT_TIMEOUT, 10);
            curl_setopt($ci, CURLOPT_POSTFIELDS, $xml);
            // 주문 등록 후 결과값 확인
            $response = curl_exec($ci);
            curl_close($ci);

            $param    = explode(':', $response);
            if ($param[0] == "SUCCESS") {
                // 성공일 경우
                return [
                    'result' => true
                    , 'data' => $api[$type]['url']."/".$param[1]."/".$param[2]
                ];
            } else {
                return [
                    'result' => false
                    , 'data' => $response
                ];
            }
        } else {
            return [
                'result' => false
                , 'data' => 'Not define api type'
            ];
        }
    }
}

if (!function_exists('npay_get_cart_data')) {

    /**
     * 카트 아이디를 이용하여 카트 정보 조회
     * @param array $cartIxs
     * @return boolean|array
     */
    function npay_get_cart_data($cartIxs)
    {
        if (!empty($cartIxs)) {
            /* @var $cartModel CustomMallCartModel */
            $cartModel = getForbiz()->import('model.mall.cart');
            //카트정보 조회
            return $cartModel->get($cartIxs);
        } else {
            return false;
        }
    }
}

if (!function_exists('npay_del_cart_data')) {

    /**
     * 카트 아이디를 이용하여 카트 정보 삭제
     * @param array $cartIxs
     */
    function npay_del_cart_data($cartIxs)
    {
        /* @var $cartModel CustomMallCartModel */
        $cartModel = getForbiz()->import('model.mall.cart');
        //카트정보 삭제
        $cartModel->delete($cartIxs);
    }
}