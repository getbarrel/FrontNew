<?php

/**
 * Description of ForbizMallProductController
 *
 * @author hoksi
 */
class ForbizMallProductController extends ForbizMallController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getGoodsList()
    {
        /* 기본 필터 */
        $max     = $this->input->post('max');
        $page    = $this->input->post('page');
        $orderBy = $this->input->post('orderBy');

        /* 추가 필터 */
        $filter['filterCid']          = $this->input->post('filterCid');
        $filter['filterBrands']       = $this->input->post('filterBrands');
        $filter['filterDeliveryFree'] = $this->input->post('filterDeliveryFree');
        $filter['filterInsideText']   = $this->input->post('filterInsideText');
        $filter['filterText']         = $this->input->post('filterText');

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        $responseData = $productModel->getList($filter, $page, $max, $orderBy);
        if (!empty($responseData['list'])) {
            foreach ($responseData['list'] as $key => $row) {
                $row['listprice'] = g_price($row['listprice']);
                $row['dcprice'] = g_price($row['dcprice']);
                $row['sellprice'] = g_price($row['sellprice']);
                $responseData['list'][$key] = $row;
            }
        }
        $responseData['filterInsideText'] = $filter['filterInsideText'];
        $this->setResponseResult('success')->setResponseData($responseData);
    }

    public function getCategorySubList()
    {
        $cid = $this->input->post('cid');

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        $responseData = $productModel->getCategorySubList($cid, true);
        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 미니카트에 사용할 옵션 데이터 호출
     * @param string $pid
     */
    public function loadOptionDatas($pid = null)
    {

        if ($pid) {
            $this->setResponseType('js'); //js 로 리턴

            /* @var $productModel CustomMallProductModel */
            $productModel = $this->import('model.mall.product');

            $options           = $productModel->getOption($pid); //옵션 데이터 호출
            $buyCountCondition = $productModel->getBuyCountCondition($pid, sess_val('user', 'code')); //구매가능 조건(수량) 호출

            echo "var devOptionData = ".json_encode($options).";\n"
            ."var allow_basic_cnt = ".$buyCountCondition['allow_basic_cnt'].";\n" //구매허용 수량
            ."var allow_byoneperson_cnt = ".($buyCountCondition['allow_byoneperson_cnt'] - $buyCountCondition['user_buy_cnt']).";\n"; //인당 최대구매 수량. 옵션일 경우 계산하기 애매함. PM 협의필요.
        }
    }

    /**
     * 관심상품 추가, 삭제 기능
     */
    public function wish()
    {
        $chkField = ['pid'];

        if (form_validation($chkField)) {
            $pid = $this->input->post('pid');
            $type = $this->input->post('type');

            if($pid == ''){
                $pid = $this->input->get('pid');
            }

            /* @var $wishModel CustomMallWishModel */
            $wishModel = $this->import('model.mall.wish');

            if($type == ''){
                if ($wishModel->checkAlreadyWish($pid)) {
                    $wishModel->deleteWish(array($pid));
                    $this->setResponseResult('delete'); //삭제
                } else {
                    $wishModel->insertWish($pid);
                    $this->setResponseResult('insert'); //추가
                }
            }else{
                if($type == "Y"){
                    $wishModel->deleteWish(array($pid));
                    $this->setResponseResult('delete'); //삭제
                }else if($type == "N"){
                    $wishModel->insertWish($pid);
                    $this->setResponseResult('insert'); //추가
                }
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 컨텐츠 추가, 삭제 기능
     */
    public function content()
    {
        $chkField = ['con_ix', 'type'];

        if (form_validation($chkField)) {
            $con_ix = $this->input->post('con_ix');
            $type = $this->input->post('type');

            if($con_ix == ''){
                $con_ix = $this->input->get('con_ix');
                $type = $this->input->get('type');
            }

            /* @var $wishModel CustomMallWishModel */
            $wishModel = $this->import('model.mall.wish');

            if ($wishModel->checkAlreadyContentWish($con_ix, $type)) {
                $wishModel->deleteContentWish($con_ix, $type);
                $this->setResponseResult('delete'); //삭제
            } else {
                $wishModel->insertContentWish($con_ix, $type);
                $this->setResponseResult('insert'); //추가
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 상품리뷰 리스트 출력
     */
    public function reviewLists()
    {
        $res = $this->input->post(); //데이터가 많아 배열로 넘김
        $res['pageType'] = 'prd';

        /* @var $reviewModel CustomMallProductReviewModel */
        $reviewModel = $this->import('model.mall.productReview');
        $responseData = $reviewModel->getReviewList($res);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    public function bestReviewLists()
    {
        $res             = $this->input->post(); //데이터가 많아 배열로 넘김
        $res['pageType'] = 'bestReview';

        /* @var $reviewModel CustomMallProductReviewModel */
        $reviewModel  = $this->import('model.mall.productReview');
        $responseData = $reviewModel->getReviewList($res);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    public function qnaCount()
    {
        $chkField = ['qnaDiv'];

        if(form_validation($chkField)) {
            /* @var $qnaModel CustomMallProductQnaModel */
            $qnaModel     = $this->import('model.mall.productQna');
            $responseData = $qnaModel->getCount($this->input->post('id'), $this->input->post('qnaDiv'));
            
            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 상품문의 리스트 출력
     */
    public function qnaLists()
    {
        $chkField = ['id', 'qnaType', 'qnaDiv', 'max', 'page'];

        if (form_validation($chkField)) {
            $id      = $this->input->post('id');
            $type    = $this->input->post('qnaType'); //전체문의, 내문의
            $bbsDiv  = $this->input->post('qnaDiv'); //문의분류
            $max     = $this->input->post('max');
            $curPage = $this->input->post('page');

            /* @var $qnaModel CustomMallProductQnaModel */
            $qnaModel     = $this->import('model.mall.productQna');
            $responseData = $qnaModel->getList($id, $type, $bbsDiv, $max, $curPage);

            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    /**
     * 상품문의 작성
     */
    public function qnaWrite()
    {
        $chkField = ['div', 'pid', 'subject', 'contents'];

        if (form_validation($chkField)) {
            $res = $this->input->post(); //데이터가 많아 배열로 넘김

            /* @var $qnaModel CustomMallProductQnaModel */
            $qnaModel     = $this->import('model.mall.productQna');
            $responseData = $qnaModel->insertQna($res);

            if ($responseData) {
                $this->setResponseResult('success');
            } else {
                $this->setResponseResult('fail');
            }
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    public function downCoupon()
    {
        $chkField = ['publishIx'];

        if (form_validation($chkField)) {
            $publishIx = $this->input->post('publishIx');

            /* @var $couponModel CustomMallCouponModel */
            $couponModel = $this->import('model.mall.coupon');
            $result      = $couponModel->giveCoupon($publishIx);

            $this->setResponseResult($result);
        } else {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }
}