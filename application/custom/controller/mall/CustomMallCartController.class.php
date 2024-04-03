<?php

/**
 * Description of CustomMallCartController
 *
 * @author hong
 */
class CustomMallCartController extends ForbizMallCartController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 카트에 상품을 추가함
     */
    public function add()
    {
        $datas = $this->input->post('data');
        $viewType = $this->input->post('viewType');
        $beForCartIx = $this->input->post('cartIxArr');

        /* @var $productModel CustomMallProductModel */
        $productModel      = $this->import('model.mall.product');
        $buyCountCondition = $productModel->getBuyCountCondition($datas[0]['pid'], sess_val('user', 'code'));

        // 수량 점검
        foreach ($datas as $k => $v) {
            // 옵션별 정보 조회
            $option_infos             = $productModel->getOption($v['pid'], 'row', $v['optionId']);
            // 옵션 정보 추가
            $datas[$k]['option_kind'] = $option_infos['option_kind'];
            $datas[$k]['opn_ix']      = $option_infos['opn_ix'];

            //최소 구매수량 보다 적은 수량일때
            if ($buyCountCondition['allow_basic_cnt'] > 0 && $buyCountCondition['allow_basic_cnt'] > $v['count']) {
                $this->setResponseResult('failBasicCount');
                $this->setResponseData($buyCountCondition['allow_basic_cnt']);
                return;
            } else if($buyCountCondition['allow_byoneperson_cnt'] > 0 && $buyCountCondition['allow_max_cnt'] > 0){
                //ID 구매 수량 과 최대 구매 수량이 같이 존재 할 경우
                if(is_login()){
                    //회원 일 경우 제한 수량이 적은 대상으로 체크
                    if($buyCountCondition['allow_byoneperson_cnt'] < $buyCountCondition['allow_max_cnt']){
                        if($buyCountCondition['allow_byoneperson_cnt'] > 0 && $buyCountCondition['allow_byoneperson_cnt'] < ($buyCountCondition['user_buy_cnt']
                                + $v['count'])){
                            $this->setResponseResult('failByOnePersonCount');
                            $this->setResponseData($buyCountCondition['allow_byoneperson_cnt']);
                            return;
                        }
                    }  else {
                        // 최대 구매 수량으로 만 체크
                        if($buyCountCondition['allow_max_cnt'] > 0 && $buyCountCondition['allow_max_cnt'] < ($buyCountCondition['user_buy_cnt']
                                + $v['count'])){
                            $this->setResponseResult('failByOneMaxCount');
                            $this->setResponseData($buyCountCondition['allow_max_cnt']);
                            return;
                        }
                    }
                }else{
                    //로그인 상태가 아닌 경우 최대 구매 수량으로 만 체크
                    // 최대 구매 수량으로 만 체크
                    if($buyCountCondition['allow_max_cnt'] > 0 && $buyCountCondition['allow_max_cnt'] < ($buyCountCondition['user_buy_cnt']
                            + $v['count'])){
                        $this->setResponseResult('failByOneMaxCount');
                        $this->setResponseData($buyCountCondition['allow_max_cnt']);
                        return;
                    }
                }

            }
            //ID당 구매수량이 적을때
            else if ($buyCountCondition['allow_byoneperson_cnt'] > 0 && $buyCountCondition['allow_byoneperson_cnt'] < ($buyCountCondition['user_buy_cnt']
                + $v['count'])) {
                //옵션으로 구매수량 계산시 애매하여 차후 PM 협의필요. 180907
                if(is_login()){

                    $this->setResponseResult('failByOnePersonCount');
                    $this->setResponseData($buyCountCondition['allow_byoneperson_cnt']);
                }else{
                    $this->setResponseResult('noLogin');
                }
                return;
            }
            //최대 구매수량 초과
            else if ($buyCountCondition['allow_max_cnt'] > 0 && $buyCountCondition['allow_max_cnt'] < ($buyCountCondition['user_buy_cnt']
                    + $v['count'])){
                $this->setResponseResult('failByOneMaxCount');
                $this->setResponseData($buyCountCondition['allow_max_cnt']);
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

        $cartIxs = $this->cartModel->add($datas,$viewType,$beForCartIx);
        $this->setResponseData($cartIxs);
    }

    public function updateCountNew()
    {
        $chkField = ['cartIx', 'count'];

        if (form_validation($chkField)) {
            $cartIx   = $this->input->post('cartIx');
            $count    = $this->input->post('count');
            $cartType = $this->input->post('cartType');
            $optVal = $this->input->post('optVal');

            /* @var $productModel CustomMallProductModel */
            $productModel = $this->import('model.mall.product');

            // 세트상품?
            if ($cartType == 'set') {
                $cartIx = explode(',', $cartIx);
            }

            // 카트정보 조회
            $row = $this->cartModel->getProductRow($cartIx);

            if (!empty($row)) {

                // 재고 수량 점검
                $buyCountCondition = $productModel->getBuyCountCondition($row['id'], sess_val('user', 'code'));

                $optionText = $this->cartModel->getProductOptionTextNew($optVal, '');

                // 최소 구매수량 보다 적은 수량일 때
                if ($buyCountCondition['allow_basic_cnt'] > 0 && $buyCountCondition['allow_basic_cnt'] > $count) {
                    $this->setResponseResult('failBasicCount')->setResponseData($buyCountCondition['allow_basic_cnt']);
                } else if($buyCountCondition['allow_byoneperson_cnt'] > 0 && $buyCountCondition['allow_max_cnt'] > 0){
                    //ID 구매 수량 과 최대 구매 수량이 같이 존재 할 경우
                    if(is_login()){
                        //회원 일 경우 제한 수량이 적은 대상으로 체크
                        if($buyCountCondition['allow_byoneperson_cnt'] < $buyCountCondition['allow_max_cnt']){
                            if($buyCountCondition['allow_byoneperson_cnt'] > 0 && $buyCountCondition['allow_byoneperson_cnt'] < ($buyCountCondition['user_buy_cnt']
                                    + $count)){
                                $this->setResponseResult('failByOnePersonCount');
                                $this->setResponseData($buyCountCondition['allow_byoneperson_cnt']);
                                return;
                            }
                        }  else {
                            // 최대 구매 수량으로 만 체크
                            if($buyCountCondition['allow_max_cnt'] > 0 && $buyCountCondition['allow_max_cnt'] < ($buyCountCondition['user_buy_cnt']
                                    + $count)){
                                $this->setResponseResult('failByOneMaxCount');
                                $this->setResponseData($buyCountCondition['allow_max_cnt']);
                                return;
                            }
                        }
                    }else{
                        //로그인 상태가 아닌 경우 최대 구매 수량으로 만 체크
                        // 최대 구매 수량으로 만 체크
                        if($buyCountCondition['allow_max_cnt'] > 0 && $buyCountCondition['allow_max_cnt'] < ($buyCountCondition['user_buy_cnt']
                                + $count)){
                            $this->setResponseResult('failByOneMaxCount');
                            $this->setResponseData($buyCountCondition['allow_max_cnt']);
                            return;
                        }
                    }

                    //구매수량 업데이트
                    if ($cartType == 'set') {
                        // 세트상품 수량 수정
                        $this->cartModel->updateCartSetCountNew($cartIx, $count, $row['set_group']);
                    } else {
                        $this->cartModel->updateCountNew($cartIx, $count, $optVal, $optionText);
                    }

                    $this->cartModel->updateGiftCount($cartIx, $count);

                    $this->setResponseResult('success');

                } else if ($buyCountCondition['allow_byoneperson_cnt'] > 0 ) {
                    // ID당 구매수량이 적을때
                    if(is_login()){
                        if(($buyCountCondition['allow_byoneperson_cnt'] - $buyCountCondition['user_buy_cnt']) < ($count)) {
                            $this->setResponseResult('failByOnePersonCount');
                            $this->setResponseData($buyCountCondition['allow_byoneperson_cnt']);
                        }else{
                            //구매수량 업데이트
                            if ($cartType == 'set') {
                                // 세트상품 수량 수정
                                $this->cartModel->updateCartSetCountNew($cartIx, $count, $row['set_group']);
                            } else {
                                $this->cartModel->updateCountNew($cartIx, $count, $optVal, $optionText);
                            }

                            $this->cartModel->updateGiftCount($cartIx,$count);

                            $this->setResponseResult('success');
                        }
                    }else{
                        $this->setResponseResult('noLogin');
                    }


                    //최대 구매수량 체크
                }else if($buyCountCondition['allow_max_cnt'] > 0 && $buyCountCondition['allow_max_cnt'] < ($buyCountCondition['user_buy_cnt'] + $count)){
                    $this->setResponseResult('failByOneMaxCount');
                    $this->setResponseData($buyCountCondition['allow_max_cnt']);
                    // 상품이 판매중이 아닐때
                } else if ($row['status'] != 'sale') {

                    $this->setResponseResult('failNoSale');

                    // 재고 수량보다 많이 입력한 경우
                } else if ($row['stock'] < $count) {

                    $this->setResponseResult('failStockLack')->setResponseData($row['stock']);

                } else {
                    //구매수량 업데이트
                    if ($cartType == 'set') {
                        // 세트상품 수량 수정
                        $this->cartModel->updateCartSetCountNew($cartIx, $count, $row['set_group']);
                    } else {
                        $this->cartModel->updateCountNew($cartIx, $count, $optVal, $optionText);
                    }

                    $this->cartModel->updateGiftCount($cartIx,$count);

                    $this->setResponseResult('success');
                }
            } else {
                $this->setResponseResult('fail');
            }


        }else{
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 상품 수량 수정
     */
    public function updateCount()
    {
        $chkField = ['cartIx', 'count'];

        if (form_validation($chkField)) {
            $cartIx   = $this->input->post('cartIx');
            $count    = $this->input->post('count');
            $cartType = $this->input->post('cartType');

            /* @var $productModel CustomMallProductModel */
            $productModel = $this->import('model.mall.product');

            // 세트상품?
            if ($cartType == 'set') {
                $cartIx = explode(',', $cartIx);
            }

            // 카트정보 조회
            $row = $this->cartModel->getProductRow($cartIx);


            if (!empty($row)) {

                // 재고 수량 점검
                $buyCountCondition = $productModel->getBuyCountCondition($row['id'], sess_val('user', 'code'));

                // 최소 구매수량 보다 적은 수량일 때
                if ($buyCountCondition['allow_basic_cnt'] > 0 && $buyCountCondition['allow_basic_cnt'] > $count) {
                    $this->setResponseResult('failBasicCount')->setResponseData($buyCountCondition['allow_basic_cnt']);


                } else if($buyCountCondition['allow_byoneperson_cnt'] > 0 && $buyCountCondition['allow_max_cnt'] > 0){
                    //ID 구매 수량 과 최대 구매 수량이 같이 존재 할 경우
                    if(is_login()){
                        //회원 일 경우 제한 수량이 적은 대상으로 체크
                        if($buyCountCondition['allow_byoneperson_cnt'] < $buyCountCondition['allow_max_cnt']){
                            if($buyCountCondition['allow_byoneperson_cnt'] > 0 && $buyCountCondition['allow_byoneperson_cnt'] < ($buyCountCondition['user_buy_cnt']
                                    + $count)){
                                $this->setResponseResult('failByOnePersonCount');
                                $this->setResponseData($buyCountCondition['allow_byoneperson_cnt']);
                                return;
                            }
                        }  else {
                            // 최대 구매 수량으로 만 체크
                            if($buyCountCondition['allow_max_cnt'] > 0 && $buyCountCondition['allow_max_cnt'] < ($buyCountCondition['user_buy_cnt']
                                    + $count)){
                                $this->setResponseResult('failByOneMaxCount');
                                $this->setResponseData($buyCountCondition['allow_max_cnt']);
                                return;
                            }
                        }
                    }else{
                        //로그인 상태가 아닌 경우 최대 구매 수량으로 만 체크
                        // 최대 구매 수량으로 만 체크
                        if($buyCountCondition['allow_max_cnt'] > 0 && $buyCountCondition['allow_max_cnt'] < ($buyCountCondition['user_buy_cnt']
                                + $count)){
                            $this->setResponseResult('failByOneMaxCount');
                            $this->setResponseData($buyCountCondition['allow_max_cnt']);
                            return;
                        }
                    }
                    //구매수량 업데이트
                    if ($cartType == 'set') {
                        // 세트상품 수량 수정
                        $this->cartModel->updateCartSetCount($cartIx, $count, $row['set_group']);
                    } else {
                        $this->cartModel->updateCount($cartIx, $count);
                    }

                    $this->cartModel->updateGiftCount($cartIx,$count);

                    $this->setResponseResult('success');

                } else if ($buyCountCondition['allow_byoneperson_cnt'] > 0 ) {
                    // ID당 구매수량이 적을때
                    if(is_login()){
                        if(($buyCountCondition['allow_byoneperson_cnt'] - $buyCountCondition['user_buy_cnt']) < ($count)) {
                            $this->setResponseResult('failByOnePersonCount');
                            $this->setResponseData($buyCountCondition['allow_byoneperson_cnt']);
                        }else{
                            //구매수량 업데이트
                            if ($cartType == 'set') {
                                // 세트상품 수량 수정
                                $this->cartModel->updateCartSetCount($cartIx, $count, $row['set_group']);
                            } else {
                                $this->cartModel->updateCount($cartIx, $count);
                            }

                            $this->cartModel->updateGiftCount($cartIx,$count);

                            $this->setResponseResult('success');
                        }
                    }else{
                        $this->setResponseResult('noLogin');
                    }


                //최대 구매수량 체크
                }else if($buyCountCondition['allow_max_cnt'] > 0 && $buyCountCondition['allow_max_cnt'] < ($buyCountCondition['user_buy_cnt'] + $count)){
                    $this->setResponseResult('failByOneMaxCount');
                    $this->setResponseData($buyCountCondition['allow_max_cnt']);
                // 상품이 판매중이 아닐때
                } else if ($row['status'] != 'sale') {

                    $this->setResponseResult('failNoSale');

                // 재고 수량보다 많이 입력한 경우
                } else if ($row['stock'] < $count) {

                    $this->setResponseResult('failStockLack')->setResponseData($row['stock']);

                } else {

                    //구매수량 업데이트
                    if ($cartType == 'set') {
                        // 세트상품 수량 수정
                        $this->cartModel->updateCartSetCount($cartIx, $count, $row['set_group']);
                    } else {
                        $this->cartModel->updateCount($cartIx, $count);
                    }

                    $this->cartModel->updateGiftCount($cartIx,$count);

                    $this->setResponseResult('success');
                }
            } else {
                $this->setResponseResult('fail');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 상품 삭제
     */
    public function delete()
    {
        $chkField = ['cartIxs[]'];

        if (form_validation($chkField)) {
            $cartIxs  = $this->input->post('cartIxs');

            $this->cartModel->delete($cartIxs);
        }
    }



    // 네이버 페이 in Cart
    public function reqNpayCart(){

        $datas = $this->input->post('data');

        /* @var $cartModel CustomMallCartModel */
        $cartModel = $this->import('model.mall.cart');
        $cartInfo = $cartModel->get($datas['cartIxs']);
        $cartString = "";


        // 1. 카트 및 결제정보 확인
         if(count($cartInfo) > 0 && $cartInfo['0']['payment_price'] > 0){

             $cInfo = $cartInfo['0'];
             // 2. 배송 정책별
             foreach ($cInfo['deliveryTemplateList'] as $deliveryTemplateKey => $deliveryTemplate) {

                 // 3. 카트 상품
                 foreach ($deliveryTemplate['productList'] as $key => $list) {

                     if($cartString == ""){
                         $cartString .= 'ITEM_ID=' . urlencode($list['id']);
                     }else{
                         $cartString .= '&ITEM_ID=' . urlencode($list['id']);
                     }
                     $cartString .= '&ITEM_NAME=' . urlencode($list['pname']);
                     $cartString .= '&ITEM_COUNT=' . $list['pcount'];
                     $cartString .= '&ITEM_OPTION=' . urlencode(str_replace('<br>', '', $list['options_text']));
                     $cartString .= '&ITEM_OPTION_CODE=' . urlencode($list['select_option_id']);
                     $cartString .= '&ITEM_TPRICE=' . $list['total_dcprice'];
                     $cartString .= '&ITEM_UPRICE=' . $list['dcprice'];
                 }
             }
        }

        // 4. 배송비 추가
        if($cInfo['total_delivery_price'] > 0){
            $cartString .= '&SHIPPING_TYPE=PAYED';
            $cartString .= '&SHIPPING_PRICE='.$cInfo['total_delivery_price'];
        }else{
            $cartString .= '&SHIPPING_TYPE=FREE';
            $cartString .= '&SHIPPING_PRICE=0';
        }

        //  print_r($cInfo['payment_price']);exit;

        // 5. 결제 금액 추가
        $cartString .= '&TOTAL_PRICE='.$cInfo['payment_price'];
        $cartString .= "&BACK_URL=http://".$_SERVER["HTTP_HOST"]."/shop/cart";

        // 6. 상점정보 추가 및 네이버 주문번호 요청처리
        $result = $this->requestNaverPayOrderNumber($cartString);

        //print_r($result);exit;

        if($result['resultCode'] == "200"){
            $this->setResponseResult('success');
            $this->setResponseData($result);
        }else{
            $this->setResponseResult('fail');
            $this->setResponseData($result);
        }

    }

    // 네이버 결제 페이지 요청
    public function requestNaverPayOrderNumber($cartString){

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        // 네이버페이 정보
        $nPayInfo = $productModel->getNpayInfo();

        $req_url = NPAY_REQ_URL;
        if($nPayInfo['naverpay_type'] == 'service'){
            $service_url = NPAY_SERVICE_URL;
            $req_addr    = NPAY_REQ_ADDR;
            $req_host    = NPAY_REQ_HOST;
        }else{
            $service_url = NPAY_TEST_URL;
            $req_addr    = NPAY_REQ_TEST_ADDR;
            $req_host    = NPAY_REQ_TEST_HOST;
        }

        $queryString  = 'SHOP_ID='.urlencode($nPayInfo['naverpay_id']);
        $queryString .= '&CERTI_KEY='.urlencode($nPayInfo['naverpay_key']);
        $queryString .= '&RESERVE1=&RESERVE2=&RESERVE3=&RESERVE4=&RESERVE5=';
        $queryString .= '&'.$cartString;
        $req_port = 443;

        $orderId = "";
        $headers = "";
        $bodys = "";


    //    print_r($queryString);exit;


        $nc_sock = @fsockopen($req_addr, $req_port, $errno, $errstr);
        if ($nc_sock) {
            fwrite($nc_sock, $req_url."\r\n" );
            fwrite($nc_sock, "Host: ".$req_host.":".$req_port."\r\n" );
            fwrite($nc_sock, "Content-type: application/x-www-form-urlencoded; charset=utf-8\r\n");
            fwrite($nc_sock, "Content-length: ".strlen($queryString)."\r\n");
            fwrite($nc_sock, "Accept: */*\r\n");
            fwrite($nc_sock, "\r\n");
            fwrite($nc_sock, $queryString."\r\n");
            fwrite($nc_sock, "\r\n");
            // get header
            while(!feof($nc_sock)){
                $header=fgets($nc_sock,4096);
                if($header=="\r\n"){
                    break;
                } else {
                    $headers .= $header;
                }
            }
            // get body
            while(!feof($nc_sock)){
                $bodys.=fgets($nc_sock,4096);
            }
            fclose($nc_sock);
            $resultCode = substr($headers,9,3);

            if ($resultCode == 200) {
                // success
                $orderId = $bodys;
            } else {
                // fail
                // echo $bodys;
            }
        } else {
            echo "$errstr ($errno)<br>\n";
            exit(-1);
            //에러처리
        }
/*
        print_r('===resultcode===');
        print_r($resultCode);
        print_r('===bodys===');
        print_r($orderId);exit;*/


        if($resultCode == '200'){
            $result['resultCode'] = $resultCode;
            $result['queryString'] = $queryString."&ORDER_ID=".$orderId;
            $result['nPayUrl'] = $service_url;
            $result['orderId'] = $orderId;
        }else{
            $result['resultCode'] = $resultCode;
            $result['queryString'] = $queryString;
            $result['orderId'] = $orderId;
        }
        return $result;

    }


    // 네이버 페이 버튼 in goodsView
    public function reqNpayGoodsView(){

        $goodsInfo = $this->input->post('data');
        $gInfo = $goodsInfo['0'];
        $goodString = "";

        // 1. 상품 정보
        $totalPrice = $gInfo['ITEM_TPRICE'];
        $goodString .= 'ITEM_ID=' . urlencode($gInfo['ITEM_ID']);
        $goodString .= '&ITEM_NAME=' . urlencode($gInfo['ITEM_NAME']);
        $goodString .= '&ITEM_COUNT=' . $gInfo['ITEM_COUNT'];
        $goodString .= '&ITEM_OPTION=' . urlencode($gInfo['ITEM_OPTION']);
        $goodString .= '&ITEM_OPTION_CODE=' . $gInfo['ITEM_OPTION_CODE'];
        $goodString .= '&ITEM_TPRICE=' . $gInfo['ITEM_TPRICE'];
        $goodString .= '&ITEM_UPRICE=' . $gInfo['ITEM_UPRICE'];


        // 2. 배송비 추가 --- > 확인 요망
        $gInfo['total_delivery_price'] = 0;
        if(intval($gInfo['total_delivery_price']) > 0){
            $goodString .= '&SHIPPING_TYPE=PAYED';
            $goodString .= '&SHIPPING_PRICE='.$gInfo['total_delivery_price'] ;
        }else{
            $goodString .= '&SHIPPING_TYPE=FREE';
            $goodString .= '&SHIPPING_PRICE=0';
        }

        // 3. 결제 금액 추가
        $goodString .= '&TOTAL_PRICE='.$totalPrice;
        $goodString .= "&BACK_URL=http://".$_SERVER["HTTP_HOST"]."/shop/cart";


        // 4. 상점정보 추가 및 네이버 주문번호 요청처리
        $result = $this->requestNaverPayOrderNumber($goodString);


        if($result['resultCode'] == "200"){
            $this->setResponseResult('success');
            $this->setResponseData($result);
        }else{
            $this->setResponseResult('fail');
            $this->setResponseData($result);
        }

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
                    }else {
                        //최소 구매수량 보다 적은 수량일때
                        if ($product['allow_basic_cnt'] > 0 && $product['allow_basic_cnt'] > $product['pcount']) {
                            $this->setResponseResult('failBasicCount');
                            $this->setResponseData($product['allow_basic_cnt']);
                            return;
                        }else if((int)$product['allow_byoneperson_cnt'] > 0 && (int)$product['allow_max_cnt'] > 0){
                            //ID 구매 수량 과 최대 구매 수량이 같이 존재 할 경우
                            if(is_login()){
                                //회원 일 경우 제한 수량이 적은 대상으로 체크
                                if((int)$product['allow_byoneperson_cnt'] < (int)$product['allow_max_cnt']){
                                    if((int)$product['allow_byoneperson_cnt'] > 0 && (int)$product['allow_byoneperson_cnt'] < ((int)$product['user_buy_cnt']
                                            + (int)$product['pcount'])){
                                        $this->setResponseResult('failByOnePersonCount');
                                        $this->setResponseData($product['allow_byoneperson_cnt']);
                                        return;
                                    }
                                }  else {
                                    // 최대 구매 수량으로 만 체크
                                    if((int)$product['allow_max_cnt'] > 0 && (int)$product['allow_max_cnt'] < ((int)$product['user_buy_cnt']
                                            + (int)$product['pcount'])){
                                        $this->setResponseResult('failByOneMaxCount');
                                        $this->setResponseData($product['allow_max_cnt']);
                                        return;
                                    }
                                }
                            }else{
                                //로그인 상태가 아닌 경우 최대 구매 수량으로 만 체크
                                // 최대 구매 수량으로 만 체크
                                if((int)$product['allow_max_cnt'] > 0 && (int)$product['allow_max_cnt'] < ((int)$product['user_buy_cnt']
                                        + (int)$product['pcount'])){
                                    $this->setResponseResult('failByOneMaxCount');
                                    $this->setResponseData($product['allow_max_cnt']);
                                    return;
                                }
                            }

                        }
                        //ID당 구매수량이 적을때
                        else if ($product['allow_byoneperson_cnt'] > 0) {
                            //옵션으로 구매수량 계산시 애매하여 차후 PM 협의필요. 180907
                            if(is_login()){
                                if(((int)$product['allow_byoneperson_cnt'] - (int)$product['user_buy_cnt']) < $product['pcount']) {
                                    $this->setResponseResult('failByOnePersonCount');
                                    $this->setResponseData($product['allow_byoneperson_cnt']);
                                }
                            }else{
                                $this->setResponseResult('noLogin');
                            }
                            return;
                        }
                        //최대 구매수량 초과
                        else if ($product['allow_max_cnt'] > 0 && $product['allow_max_cnt'] < $product['pcount'] ){
                            $this->setResponseResult('failByOneMaxCount');
                            $this->setResponseData($product['allow_max_cnt']);
                            return;
                        } else if ($product['stock'] < $product['pcount']) {
                            $this->setResponseResult('fail');
                            $this->setResponseData(['cart_ix'=>$product['cart_ix'], 'stock'=>$product['stock']]);
                            return;
                        }
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
}
