<?php

/**
 * Description of CustomMallDefaultViewController
 *
 * @author smlee
 */
class CustomMallCustomerController extends ForbizMallCustomerController
{

    public function __construct()
    {
        parent::__construct();
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

    /**
     * 지역 조회
     */
    public function getArea()
    {
        $city = $this->input->post('city');

        /* @var $customerModel CustomMallCustomerModel */
        $customerModel = $this->import('model.mall.customer');
        $area = $customerModel->getArea($city);

        $this->setResponseResult('success')->setResponseData($area);
    }

    /**
     * 스토어 조회
     */
    public function getStoreList()
    {
        $page = $this->input->post('page');
        $max = $this->input->post('max');
        $city = $this->input->post('city');
        $area = $this->input->post('area');
        $name = $this->input->post('name');

        /* @var $customerModel CustomMallCustomerModel */
        $customerModel = $this->import('model.mall.customer');

        $storeList = $customerModel->getStoreList($page, $max, $city, $area, $name);

        $this->setResponseResult('success')->setResponseData($storeList);
    }

    public function registerArticle()
    {
        if(is_login()){
            // 입력 필수 항목
            $chkField = ['bbsDiv', 'bbsEmailId', 'bbsEmailHost', 'bbsSubject', 'bbsContents', 'board'];

			$board_tmp = explode('/customer/', $_SERVER["HTTP_REFERER"]);
			$board = explode('/', $board_tmp[1]);
	
			if($this->input->get_post('board') == $board[0]) {

				// 필수 항목 체크
				if (form_validation($chkField)) {

					$bbsContents = $this->input->get_post('bbsContents');
					$bbsContents = str_replace('cookie', '', $bbsContents);
					$bbsContents = str_replace('document', '', $bbsContents);
					$bbsContents = str_replace('confirm', '', $bbsContents);
					$bbsContents = str_replace('onmouseenter=', '', $bbsContents);
					$bbsContents = str_replace('input', '', $bbsContents);

					$param['bbsDiv']        = $this->input->get_post('bbsDiv');
					$param['subBbsDiv']     = intval($this->input->get_post('subBbsDiv'));
					$param['bbsEmail']      = $this->input->get_post('bbsEmailId')."@".$this->input->get_post('bbsEmailHost');
					if($this->input->get_post('bbsHp2')){
						$param['hp']        = $this->input->get_post('bbsHp1')."-".$this->input->get_post('bbsHp2')."-".$this->input->get_post('bbsHp3');
					}
					$param['subject']       = $this->input->get_post('bbsSubject');
					//$param['contents']      = $this->input->get_post('bbsContents');
					$param['contents']      = $bbsContents;
					$param['bbsEtc4']       = $this->input->get_post('oid');
					$param['board']         = $this->input->get_post('board');
					$param['uType']         = $this->input->get_post('uType');
					$param['bbsIx']         = $this->input->get_post('bbsIx');
					$param['notifyEmail']   = $this->input->get_post('notifyEmail');
					$param['notifyHp']      = $this->input->get_post('notifyHp');

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
			} else {
				$this->setResponseResult('fail');
			}
        }
    }

    public function registerTeacherMember()
    {
        if(is_login()) {
            // 입력 필수 항목
            $chkField = ['bbsDiv', 'bbsSubject', 'bbsContents'];

            // 필수 항목 체크
            if (form_validation($chkField)) {

                $param['bbsDiv'] = $this->input->get_post('bbsDiv');
                $param['subject'] = $this->input->get_post('bbsSubject');
                $param['contents'] = $this->input->get_post('bbsContents');
                $param['bbsEtc1'] = $this->input->get_post('bbs_etc1');
                $param['board'] = $this->input->get_post('board');
                $param['uType'] = $this->input->get_post('uType');
                $param['bbsIx'] = $this->input->get_post('bbsIx');
                $param['isHidden'] = $this->input->get_post('isHidden');

                $result = $this->customerModel->registerTeacherMember($param);

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
    }


    public function deleteArticle()
    {
        if(is_login()){
            $board = $this->input->post('bType');
            $bbs_ix = $this->input->post('bbsIx');

            if ($board == "" || $bbs_ix == "") {
                $this->setFlashData('msg', '삭제 정보가 올바르지 않습니다.');
                if($board == 'qna') {
                    redirect('/mypage/myInquiry');
                }
            }
            $this->customerModel->setTableName($board);
            $delResult = $this->customerModel->deleteArticle($bbs_ix);

            if ($delResult) {
                $this->setResponseResult('success')->setResponseData($delResult);
            } else {
                $this->setResponseResult('fail')->setResponseData($delResult);
            }
        }
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
            $responseData = $this->customerModel->noticeList($param);

            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }


    public function mixedNoticeList()
    {
        $chkField = ['bType', 'page'];

        if (form_validation($chkField)) {
            $param['bType']      = $this->input->post('bType');
            $param['sType']      = $this->input->post('sType');
            $param['curPage']    = $this->input->post("page");
            $param['searchText'] = $this->input->post("searchText");

            $this->customerModel->setBoardConfig($param['bType']);
            $responseData = $this->customerModel->getNoticeMixedList($param);

            $this->setResponseResult('success')->setResponseData($responseData);
        } else {
            $this->setResponseResult('fail');
        }
    }

    public function customBbsData(){


        $param['curPage'] = $this->input->post('page');
        $param['bType'] = $this->input->post('bType');


        /* @var $customerModel ForbizMallCustomerModel */
        $customerModel = $this->import('model.mall.customer');
        $customerModel->setBoardConfig($param['bType']);

        $responseData = $customerModel->getNoticeList($param);

        $this->setResponseResult('success')->setResponseData($responseData);

    }

    public function getBbsTeacher(){

        $param['curPage'] = $this->input->post('page');
        $param['bType'] = $this->input->post('bType');


        /* @var $customerModel ForbizMallCustomerModel */
        $customerModel = $this->import('model.mall.customer');
        $customerModel->setBoardConfig($param['bType']);


        $responseData = $customerModel->getNoticeList($param);

        $this->setResponseResult('success')->setResponseData($responseData);
    }
}