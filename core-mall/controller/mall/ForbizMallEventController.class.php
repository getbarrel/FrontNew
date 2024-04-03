<?php

/**
 * Description of ForbizMallEventController
 *
 * @author hong
 * @property CustomMallEventModel $eventModel
 */
class ForbizMallEventController extends ForbizMallController
{
    /**
     * 이벤트 모델
     */
    public $eventModel;
    
    public function __construct()
    {
        parent::__construct();
        $this->eventModel = $this->import('model.mall.event');
    }

    /**
     * 이벤트 리스트 출력
     */
    public function getEventList()
    {
        $res = $this->input->post();
        $orderBy = $res['orderBy'];
        $orderByType = $res['orderByType'];
        $page = $res['page'];
        $max = $res['max'];

        $responseData = $this->eventModel->getEventList('E', $orderBy, $orderByType, $page, $max);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 이벤트 상세 댓글 출력
     */
    public function getCommentList()
    {
        $res = $this->input->post();
        $event_ix = $res['event_ix'];
        $orderBy = $res['orderBy'];
        $orderByType = $res['orderByType'];
        $page = $res['page'];
        $max = $res['max'];

        $responseData = $this->eventModel->getCommentList($event_ix, sess_val('user','code'), $orderBy, $orderByType, $page, $max);

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    /**
     * 이벤트 댓글 등록 (유저당 하나의 댓글)
     */
    public function addCommentByUser()
    {
        $res = $this->input->post();
        $event_ix = $res['event_ix'];
        $comment = $res['comment'];

        if (is_login()) {
            $userCode = sess_val('user', 'code');
            if ($this->eventModel->isUserComment($event_ix, $userCode)) {
                $this->setResponseResult('preAdd');
            } else {
                $this->eventModel->addComment($event_ix, $userCode, $comment);
            }
        } else { //댓글 작성시 로그인
            $this->setResponseResult('loginFail');
        }
    }

    /**
     * 이벤트 댓글 등록
     */
    public function addComment()
    {
        $res = $this->input->post();
        $event_ix = $res['event_ix'];
        $comment = $res['comment'];

        if (is_login()) {
            $this->eventModel->addComment($event_ix, sess_val('user', 'code'), $comment);
        } else { //댓글 작성시 로그인
            $this->setResponseResult('loginFail');
        }
    }

    /**
     * 댓글 삭제
     */
    public function delComment()
    {
        $res = $this->input->post();
        $ec_ix = $res['ec_ix'];

        $responseData = $this->eventModel->delComment($ec_ix, sess_val('user', 'code'));
        $this->setResponseResult('success')->setResponseData($responseData);
    }
}
