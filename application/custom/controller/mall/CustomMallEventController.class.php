<?php

/**
 * Description of CustomMallEventController
 *
 * @author lee
 */
class CustomMallEventController extends ForbizMallController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 이벤트 리스트 출력
     */
    public function eventListsAll()
    {
        $res = $this->input->post();
        $orderBy = $res['orderBy'];
        $orderByType = $res['orderByType'];
        $page = $res['page'];
        $max = $res['max'];

        /* @var $eventModel CustomMallEventModel */
        $eventModel = $this->import('model.mall.event');
        $responseData = $eventModel->getEventListAll($orderBy, $orderByType, $page, $max);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    public function getEventList()
    {
        $res = $this->input->post();
        $orderBy = $res['orderBy'];
        $orderByType = $res['orderByType'];
        $page = $res['page'];
        $max = $res['max'];
        $state = $res['state'];

        $eventModel = $this->import('model.mall.event');
        $responseData = $eventModel->getEventList('E', $orderBy, $orderByType, $page, $max, $state);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    public function getEventListNew()
    {
        $res = $this->input->post();
        $orderBy = $res['orderBy'];
        $orderByType = $res['orderByType'];
        $page = $res['page'];
        $max = $res['max'];
        $state = $res['state'];

        $eventModel = $this->import('model.mall.event');
        $responseData = $eventModel->getEventListNew('E', $orderBy, $orderByType, $page, $max, $state);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 매거진 리스트 출력
     */
    public function magazineListsAll()
    {
        $res = $this->input->post();
        $orderBy = $res['orderBy'];
        $orderByType = $res['orderByType'];
        $page = $res['page'];
        $max = $res['max'];

        /* @var $eventModel CustomMallEventModel */
        $eventModel = $this->import('model.mall.event');
        $responseData = $eventModel->getMagazineListAll($orderBy, $orderByType, $page, $max);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 이벤트 상세 댓글 출력
     */
    public function eventCommentList()
    {
        $res = $this->input->post();
        $event_ix = $res['event_ix'];
        $orderBy = $res['orderBy'];
        $orderByType = $res['orderByType'];
        $page = $res['page'];
        $max = $res['max'];

        /* @var $eventDetailModel CustomMallEventModel */
        $eventDetailModel = $this->import('model.mall.event');
        $responseData = $eventDetailModel->getEventCommentListAll($orderBy, $orderByType, $page, $max, $event_ix);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 매거진 상세 댓글 출력
     */
    public function magazineCommentList()
    {
        $res = $this->input->post();
        $event_ix = $res['event_ix'];
        $orderBy = $res['orderBy'];
        $orderByType = $res['orderByType'];
        $page = $res['page'];
        $max = $res['max'];

        /* @var $eventDetailModel CustomMallEventModel */
        $eventDetailModel = $this->import('model.mall.event');
        $responseData = $eventDetailModel->getMagazineCommentListAll($orderBy, $orderByType, $page, $max, $event_ix);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 이벤트 댓글 등록
     */
    public function eventCommentInsert()
    {
        $res = $this->input->post();
        $event_ix = $res['event_ix'];
        $comment = $res['comment'];

        if (is_login()) {
            $code = $_SESSION['user']['code'];

            /* @var $eventDetailModel CustomMallEventModel */
            $eventDetailModel = $this->import('model.mall.event');
            $responseData = $eventDetailModel->getEventDetailComment($event_ix, $code, $comment);

            if ($responseData == 'fail') {  //이미 작성한 아이디의 댓글
                $this->setResponseResult('fail')->setResponseData($responseData);
            } else { //댓글 등록 성공
                $this->setResponseResult('success')->setResponseData($responseData);
            }
        } else { //댓글 작성시 로그인
            $this->setResponseResult('loginFail');
        }
    }

    /**
     * 댓글 등록
     */
    public function commentInsert()
    {
        $res = $this->input->post();
        $event_ix = $res['event_ix'];
        $comment = $res['comment'];

        $code = $_SESSION['user']['code'];

        /* @var $eventDetailModel CustomMallEventModel */
        $eventDetailModel = $this->import('model.mall.event');

        $responseData = $eventDetailModel->getCommentInsert($event_ix, $code, $comment);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 댓글 삭제
     */
    public function commentDelete()
    {
        $res = $this->input->post();
        $ec_ix = $res['ec_ix'];

        /* @var $eventDetailModel CustomMallEventModel */
        $eventDetailModel = $this->import('model.mall.event');

        $responseData = $eventDetailModel->getCommentDelete($ec_ix);
        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 영상 리스트 출력
     */
    public function videoListsAll()
    {
        $res = $this->input->post();
        $orderBy = $res['orderBy'];
        $orderByType = $res['orderByType'];
        $page = $res['page'];
        $max = $res['max'];

        /* @var $eventModel CustomMallEventModel */
        $eventModel = $this->import('model.mall.event');
        $responseData = $eventModel->getVideoListAll($orderBy, $orderByType, $page, $max);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 댓글 수정
     */
    public function commentModify()
    {
        $res = $this->input->post();
        $event_ix = $res['event_ix'];
        $ec_ix = $res['ec_ix'];
        $comment = $res['comment'];

        $code = sess_val('user','code');

        /* @var $eventDetailModel CustomMallEventModel */
        $eventDetailModel = $this->import('model.mall.event');

        $responseData = $eventDetailModel->getCommentModify($event_ix, $code, $comment,$ec_ix);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 스프린트 챔피언십 등록
     */
    public function joinChampionship()
    {
        $res = $this->input->post();

        /* @var $eventDetailModel CustomMallEventModel */
        $eventDetailModel = $this->import('model.mall.event');
        $info = $eventDetailModel->checkChampionshipDay();
        $fail_msg = "등록에 실패하였습니다.";
        if($res['type'] == 'I') {
            $now = date('Y-m-d H:i:s');
            if($eventDetailModel->checkChampionshipLimit() <= $info->max && ($now > $info->sdate && $now < $info->edate )){
                if($res['attend_div'] == 1) {
                    $result = $eventDetailModel->joinChampionship($res);
                }else {
                    $result = $eventDetailModel->joinChampionshipGroup($res);
                }
            }else {
                $fail_msg = "선착순 마감되었습니다.";
            }
        }else {
            if($res['attend_div'] == 1) {
                $result = $eventDetailModel->updateChampionship($res);
            }else {
                $result = $eventDetailModel->updateChampionshipGroup($res);
            }
        }

        if($result) {
            if($res['type'] == 'M') {
                //업데이트 후 허용 세션 제거
                unset($_SESSION['championship_allow']);
            }
            $this->setResponseResult('success')->setResponseData($result);
        }else {
            $this->setResponseResult('fail')->setResponseData($fail_msg);
        }
    }

    /**
     * 스프린트 챔피언십 조회
     */
    public function checkChampionship()
    {
        if (form_validation(['name','birthday', 'password']) == false) {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        } else {
            /* @var $eventDetailModel CustomMallEventModel */
            $eventDetailModel = $this->import('model.mall.event');
            $result = $eventDetailModel->checkChampionship($this->input->post());
            $result['redirect'] = 'applicationFormIndivisual';

            if(!empty($result['cm_ix'])) {
                $_SESSION['championship_allow'] = $result['cm_ix'];
                $this->setResponseResult('success')->setResponseData($result);
            }else {
                $this->setResponseResult('fail');
            }
        }
    }

    /**
     * 스프린트 챔피언십 그룹 조회
     */
    public function checkChampionshipGroup()
    {
        if (form_validation(['group_name','group_master', 'password']) == false) {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        } else {
            /* @var $eventDetailModel CustomMallEventModel */
            $eventDetailModel = $this->import('model.mall.event');
            $result = $eventDetailModel->checkChampionshipGroup($this->input->post());
            $result['redirect'] = 'applicationFormGroup';

            if(!empty($result['gp_ix'])) {
                $_SESSION['championship_allow'] = $result['gp_ix'];
                $this->setResponseResult('success')->setResponseData($result);
            }else {
                $this->setResponseResult('fail');
            }
        }
    }

    /**
     * 스프린트 챔피언십 그룹멤버 삭제
     */
    public function deleteChampionshipGroup()
    {
        if (form_validation(['cm_ix']) == false) {
            $this->setResponseResult('fail')->setResponseData(validation_errors());
        } else {
            /* @var $eventDetailModel CustomMallEventModel */
            $eventDetailModel = $this->import('model.mall.event');
            $result = $eventDetailModel->deleteChampionship($this->input->post());

            if(!empty($result)) {
                $this->setResponseResult('success')->setResponseData($result);
            }else {
                $this->setResponseResult('fail');
            }
        }
    }

    /**
     * 스프린트 챔피언십 그룹멤버수 체크
     */
    public function checkChampionshipMember()
    {
        /* @var $eventDetailModel CustomMallEventModel */
        $eventDetailModel = $this->import('model.mall.event');
        $result = $eventDetailModel->checkChampionshipLimit();
        $info = $eventDetailModel->checkChampionshipDay();

        $this->setResponseResult('success')->setResponseData($result);

    }

    /**
     * 스프린트 챔피언십날짜 체크
     */
    public function checkChampionshipDay()
    {
        /* @var $eventDetailModel CustomMallEventModel */
        $eventDetailModel = $this->import('model.mall.event');
        $info = $eventDetailModel->checkChampionshipDay();

        $now = date('Y-m-d H:i:s');

        //$result = false;
        //if($now >= $info->sdate && $now <= $info->edate) {
            $result = true;
        //}

        if($result) {
            $this->setResponseResult('success')->setResponseData($result);
        }else {
            $this->setResponseResult('fail');
        }
    }

    /**
     * Temp 파일 업로드
     */
    public function tmpFileUpload()
    {
        $allowed_ext = array('jpg','jpeg','png', 'JPG','JPEG','PNG');

        if(!empty($_FILES['image_file']['name'])){
            if(is_array($_FILES['image_file']['name'])){
                //단체에 속한 선수
                $error = $_FILES['image_file']['error'][0];
                $name = $_FILES['image_file']['name'][0];
                $tmp = $_FILES['image_file']['tmp_name'][0];
                $size = $_FILES['image_file']['size'][0];
            }else {
                //개인선수
                $error = $_FILES['image_file']['error'];
                $name = $_FILES['image_file']['name'];
                $tmp = $_FILES['image_file']['tmp_name'];
                $size = $_FILES['image_file']['size'];
            }
        }else {
            //단체 지도자
            $error = $_FILES['group_master_image_file']['error'];
            $name = $_FILES['group_master_image_file']['name'];
            $tmp = $_FILES['group_master_image_file']['tmp_name'];
            $size = $_FILES['group_master_image_file']['size'];
        }
        $ext = explode('.', $name);
        $ext = $ext[1];
        $newName = md5($name.microtime()).'.'.$ext;
        $msg = "";

        // 오류 확인
        if( $error != UPLOAD_ERR_OK ) {
            switch ($error) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $msg = "파일이 너무 큽니다. ($error)";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $msg = "파일이 첨부되지 않았습니다. ($error)";
                    break;
                default:
                    $msg = "파일이 제대로 업로드되지 않았습니다. ($error)";
            }
        }else if($size > 2097152) {
            $msg =  "파일은 2MB이하로 등록 가능합니다.";
        }else if( !in_array($ext, $allowed_ext) ) {
            $msg = "허용되지 않는 확장자입니다.";
        }

        $uploadPath = MALL_DATA_PATH."/championship/tmp/";
        if($msg == "") {
            if(!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777);
            }

            // 파일 이동
            $result['result'] = move_uploaded_file( $tmp, $uploadPath.$newName);
            $result['name'] = $name;
            $result['newName'] = $newName;
            $this->setResponseResult('success')->setResponseData($result);
        }else {
            $this->setResponseResult('fail')->setResponseData($msg);
        }
    }
}
