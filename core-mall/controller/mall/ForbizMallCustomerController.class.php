<?php

/**
 * Description of ForbizMallCustomerController
 *
 * @author smlee
 * @property CustomMallCustomerModel $customerModel
 */
class ForbizMallCustomerController extends ForbizMallController
{
    protected $customerModel;

    public function __construct()
    {
        parent::__construct();
        $this->customerModel = $this->import('model.mall.customer');
    }

    public function noticeList()
    {
        $chkField = ['bType', 'page'];

        if (form_validation($chkField)) {
            $param['bType']      = $this->input->post('bType');
            $param['sType']      = $this->input->post('sType');
            $param['curPage']    = $this->input->post("page");
            $param['bbsDiv']     = $this->input->post("bbsDiv");
            $param['status']     = $this->input->post("status");
            $param['sDate']      = $this->input->post("sDate");
            $param['eDate']      = $this->input->post("eDate");
            $param['searchText'] = $this->input->post("searchText");

            $this->customerModel->setBoardConfig($param['bType']);
            $responseData = $this->customerModel->getNoticeList($param);

            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }

    // FAQ 게시판
    public function faqList()
    {
        $chkField = ['bType', 'page'];

        if (form_validation($chkField)) {

            $curPage = $this->input->post('page');
            $bType   = $this->input->post('bType');
            $bbsIx   = $this->input->post('bbsIx');
            $divIx   = $this->input->post("divIx");   // 분류코드
            $sText   = $this->input->post('sText');

            $this->customerModel->setBoardConfig($bType);
            $responseData = $this->customerModel->getFaqList($curPage, $bbsIx, $divIx, $sText);

            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }

    public function registerArticle()
    {
        // 입력 필수 항목
        $chkField = ['bbsDiv', 'bbsEmailId', 'bbsEmailHost', 'bbsHp1', 'bbsHp2', 'bbsHp3', 'bbsSubject', 'bbsContents', 'board'];

        // 필수 항목 체크
        if (form_validation($chkField)) {

            $param['bbsDiv']    = $this->input->get_post('bbsDiv');
            $param['subBbsDiv'] = intval($this->input->get_post('subBbsDiv'));
            $param['bbsEmail']  = $this->input->get_post('bbsEmailId')."@".$this->input->get_post('bbsEmailHost');
            $param['hp']        = $this->input->get_post('bbsHp1')."-".$this->input->get_post('bbsHp2')."-".$this->input->get_post('bbsHp3');
            $param['subject']   = $this->input->get_post('bbsSubject');
            $param['contents']  = $this->input->get_post('bbsContents');
            $param['bbsEtc4']   = $this->input->get_post('oid');
            $param['board']     = $this->input->get_post('board');

            $result = $this->customerModel->registerArticle($param);

            if ($result['ins']) {
                $this->setResponseResult('success')->setResponseData($result);
            } else {
                $this->setResponseResult('fail')->setResponseData($result);
            }
        } else {
            log_message('error', validation_errors());
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        }
    }

    public function deleteArticle()
    {
        $board  = gVal('board');
        $bbs_ix = gVal('bbs_ix');

        if ($board == "" || $bbs_ix == "") {
            $this->setFlashData('msg', '삭제 정보가 올바르지 않습니다.');
            redirect('/customer/qna/list');
        }

        $this->customerModel->setBbsConfig($board);
        $delResult = $this->customerModel->deleteArticle($bbs_ix);

        if ($delResult) {
            $this->setFlashData('msg', '삭제가 완료 되었습니다.');
            redirect('/customer/qna/list'); //page
        } else {
            $this->setFlashData('page', gVal('page'));
            $this->setFlashData('msg', '삭제가 실패 되었습니다.');
            redirect('/customer/qna/read/'.gVal('bbs_ix'));
        }
    }

        /**
     * 리뷰 등록
     */
    public function registerReview()
    {

        if (is_login()) {

            $chkField = ['pid', 'valuation_goods', 'valuation_delivery'];

            if($this->input->post('type') == '1' && empty($_FILES)) {
                $chkField[] = 'bbsFile';
            }

            if (form_validation($chkField)) {
                /* @var $reviewModel CustomMallProductReviewModel */
                $reviewModel = $this->import('model.mall.productReview');

                $ret = $reviewModel->insertReview($this->input->post());

                if ($ret == 'success') {
                    $this->setResponseResult('success')->setResponseData($ret);
                } else {
                    $this->setResponseResult($ret);
                }
            } else {
                $this->setResponseResult('faile')->setResponseData(validation_errors());
            }
        } else {
            $this->setResponseResult('notLogin');
        }
    }
}