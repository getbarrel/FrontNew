<?php

/**
 * Description of CustomMallReviewController
 *
 * @author lee
 */
class CustomMallReviewController extends ForbizMallProductController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 상품리뷰 리스트 출력
     */
    public function reviewListsAll()
    {
        $res = $this->input->post(); //데이터가 많아 배열로 넘김

        // 댓글 가져오기
        $res['havingCmt'] = true;

        /* @var $reviewModel CustomMallProductReviewModel */
        $reviewModel = $this->import('model.mall.productReview');

        if (is_login()) {
            $code = $_SESSION['user']['code']; //회원코드
        }else{
            $code = "";
        }

        $responseData = $reviewModel->getReviewListAll($res, $code);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 좋아요 클릭
     */
    public function likesClick()
    {
        $res = $this->input->post();

        /* @var $reviewModel CustomMallProductReviewModel */
        $reviewModel = $this->import('model.mall.productReview');

        if (is_login()) {
            $code = $_SESSION['user']['code']; //회원코드

            $responseData = $reviewModel->getLikesClick($res, $code);

            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }
}
