<?php

/**
 * Description of CustomMallEventModel
 * @author lee
 * @property CustomMallProductModel $productModel
 */
class CustomMallEventModel extends ForbizMallEventModel
{

    private $productModel = false;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 진행이벤트 호출
     * @param string $orderBy
     * @param string $orderByType
     * @param int $page
     * @param int $max
     * @return array
     */
    public function getEventListAll($orderBy, $orderByType, $page, $max)
    {
        return $this->getEventListByKind('E', $orderBy, $orderByType, $page, $max, 'monthLimit');
    }

    public function getMagazineListAll($orderBy, $orderByType, $page, $max)
    {
        return $this->getEventListByKind('D', $orderBy, $orderByType, $page, $max, '', '00000005');
    }

    private function getEventListByKind($kind, $orderBy, $orderByType, $page, $max, $monthLimit, $er_ix = '')
    {
        if (!empty($max)) {
            $perPage = $max;
        } else {
            $perPage = 10;
        }

        $this->qb->startCache();

        $this->qb
            ->from(TBL_SHOP_EVENT)
            ->where('disp', 1)
            ->where('kind', $kind);

        if ($monthLimit == 'monthLimit') {
            $this->qb->where(strtotime('-3 month') . ' < event_use_sdate');
        }

        if (!empty($er_ix)) {
            $this->qb->where('er_ix', $er_ix);
        }

        $this->qb->stopCache();

        $total = $this->qb->getCount();

        $paging = $this->qb
            ->setTotalRows($total)
            ->pagination($page, $perPage);
        $limit = $perPage;
        $offset = $paging['offset'];

        $this->qb->orderBy($orderBy, $orderByType);
        $this->qb->orderBy('event_ix', 'desc');

        $list = $this->qb
            ->select('event_ix')
            ->select('event_title')
            ->select('LEFT(regdate, 10) AS regdate')
            ->select('(CASE WHEN ' . time() . ' > event_use_sdate AND ' . time() . ' < event_use_edate THEN "Y" ELSE null END) AS onOff')
            ->select('DATE_FORMAT(FROM_UNIXTIME(event_use_sdate), "%Y-%m-%d") AS startDate, DATE_FORMAT(FROM_UNIXTIME(event_use_edate), "%Y-%m-%d") AS endDate')
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();
        $this->qb->flushCache();

        $domain = (!empty(IMAGE_SERVER_DOMAIN) ? IMAGE_SERVER_DOMAIN : HTTP_PROTOCOL . FORBIZ_HOST );

        foreach ($list as $k => $v) {
            $list[$k]['imgPath'] = $domain . "/dewytree_data/images/event/" . $list[$k]['event_ix'] . "/event_banner_" . $list[$k]['event_ix'] . ".gif";
        }

        return [
            'total' => $total
            , 'list' => $list
            , 'paging' => $paging
        ];
    }

    /**
     * 댓글리스트 호출
     * @param string $orderBy
     * @param string $orderByType
     * @param int $page
     * @param int $max
     * @param string $event_ix
     * @return array
     */
    public function getEventCommentListAll($orderBy, $orderByType, $page, $max, $event_ix)
    {
        return $this->getCommentListAll('E', $orderBy, $orderByType, $page, $max, $event_ix, 'monthLimit');
    }

    public function getMagazineCommentListAll($orderBy, $orderByType, $page, $max, $event_ix)
    {
        return $this->getCommentListAll('D', $orderBy, $orderByType, $page, $max, $event_ix, '');
    }

    private function getCommentListAll($kind, $orderBy, $orderByType, $page, $max, $event_ix, $monthLimit)
    {
        if (!empty($max)) {
            $perPage = $max;
        } else {
            $perPage = 10;
        }

        $this->qb->startCache();

        $this->qb
            ->from(TBL_SHOP_EVENT . " AS e")
            ->join('shop_event_comment' . " AS c", "e.event_ix = c.event_ix", "inner")
            ->join(TBL_COMMON_USER . " AS u", "c.mem_ix = u.code", "left")
            ->join(TBL_COMMON_MEMBER_DETAIL ." as cmd","u.code = cmd.code","left")
            ->where('e.disp', 1)
            ->where('c.disp', 1)
            ->where('kind', $kind)
            ->where('e.event_ix', $event_ix);

        if ($monthLimit == 'monthLimit') {
            $this->qb->where(strtotime('-3 month') . ' < event_use_sdate');
        }

        $this->qb->stopCache();

        $total = $this->qb->getCount();

        $paging = $this->qb
            ->setTotalRows($total)
            ->pagination($page, $perPage);
        $limit = $perPage;
        $offset = $paging['offset'];

        $this->qb->orderBy($orderBy, $orderByType);

        $list = $this->qb
            ->select('ec_ix')
            ->select('comment')
            ->select('mem_ix')
            ->select('LEFT(c.regdate, 10) AS comment_regdate')
            ->select('CONCAT(SUBSTR(id, 1, 3), "****") AS id')
            ->decryptSelect('cmd.name','name')
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();
        $this->qb->flushCache();

        //if (is_login()) { //로그인 아이디 댓글 체크
            foreach ($list as $k => $v) {
                if (sess_val('user','code') == $list[$k]['mem_ix']) {
                    $list[$k]['idChk'] = "Y";
                } else {
                    $list[$k]['idChk'] = "";
                }
                $list[$k]['str_name'] = mb_substr($list[$k]['name'],0,1,"utf-8")."****";
                $list[$k]['comment_text'] = $list[$k]['comment'];
                $list[$k]['comment'] = nl2br($list[$k]['comment']);
            }
       // }

        return [
            'total' => $total
            , 'list' => $list
            , 'paging' => $paging
        ];
    }

    /**
     * 진행이벤트 상세 정보 호출
     * @param string $event_ix
     * @return array
     */
    public function doEventDetail($event_ix)
    {
        $row = $this->qb
            ->select('event_title')
            ->select('manage_title')
            ->select('event_text')
            ->select('LEFT(e.regdate, 7) AS magazine_date')
            ->select('(CASE WHEN ' . time() . ' > event_use_sdate AND ' . time() . ' < event_use_edate THEN "Y" ELSE null END) AS onOff')
            ->select('DATE_FORMAT(FROM_UNIXTIME(event_use_sdate), "%Y-%m-%d") AS startDate, DATE_FORMAT(FROM_UNIXTIME(event_use_edate), "%Y-%m-%d") AS endDate')
            ->select('use_comment')
            ->select('use_yn')
            ->from(TBL_SHOP_EVENT . ' e')
            ->join(TBL_SHOP_EVENT_CONFIG . ' as c', 'e.event_ix = c.event_ix', 'inner')
            ->join(TBL_SHOP_EVENT_PRODUCT_GROUP . ' as g', 'e.event_ix = g.event_ix', 'inner')
            ->where('e.event_ix', $event_ix)
            ->limit(1)
            ->exec()
            ->getRowArray();

        return $row;
    }

    /**
     * 진행이벤트 상세 그룹 정보 호출
     * @param string $event_ix
     * @return array
     */
    public function doEventDetailGroup($event_ix)
    {
        $datas = $this->qb
            ->select('epg_ix')
            ->select('group_name')
            ->select('event_name')
            ->select('group_code')
            ->select('product_cnt')
            ->from(TBL_SHOP_EVENT_PRODUCT_GROUP)
            ->where('event_ix', $event_ix)
            ->exec()
            ->getResultArray();

        foreach ($datas as $k => $v) {
            $datas[$k]['goods'] = $this->getEventDetailGroupGoods($event_ix, $v['group_code'], $v['product_cnt']);
        }

        return $datas;
    }

    /**
     * 진행이벤트 상세 그룹 상품 정보 호출
     * @param string $event_ix
     * @param string $group_code
     * @return array
     */
    public function getEventDetailGroupGoods($event_ix, $group_code, $product_cnt = 4)
    {
        if ($this->productModel == false) {
            $this->productModel = $this->import('model.mall.product');
        }

        $ids = $this->productModel->basicWhere()
                ->select('p.id')
                ->from(TBL_SHOP_PRODUCT . ' p')
                ->join(TBL_SHOP_EVENT_PRODUCT_RELATION . ' as r', 'r.pid=p.id', 'left')
                ->where('r.event_ix', $event_ix)
                ->where('r.group_code', $group_code)
                ->orderBy('r.vieworder', 'ASC')
                ->limit($product_cnt)
                ->exec()->getResultArray();

        if (!empty($ids)) {
            return $this->productModel->getListById(array_column($ids, 'id'));
        } else {
            return;
        }
    }

    /**
     * 진행이벤트 상세 코멘트 삽입
     * @param int $event_ix
     * @param string $code
     * @param string $comment
     * @return string
     */
    public function getEventDetailComment($event_ix, $code, $comment)
    {
        $cnt = $this->qb
            ->from(TBL_SHOP_EVENT_COMMENT)
            ->where('event_ix', $event_ix)
            ->where('mem_ix', $code)
            ->getCount();

        if ($cnt > 0) {
            return 'fail';
        } else {
            $this->getCommentInsert($event_ix, $code, $comment);
            return 'success';
        }
    }

    /**
     * 댓글 등록
     * @param int $event_ix
     * @param string $code
     * @param string $comment
     */
    public function getCommentInsert($event_ix, $code, $comment)
    {
        $this->qb
            ->set('event_ix', $event_ix)
            ->set('mem_ix', $code)
            ->set('comment', $comment)
            ->insert(TBL_SHOP_EVENT_COMMENT)
            ->exec();
    }

    /**
     * 댓글 삭제
     * @param int $ec_ix
     */
    public function getCommentDelete($ec_ix)
    {
        $this->qb
            ->delete(TBL_SHOP_EVENT_COMMENT)
            ->where('ec_ix', $ec_ix)
            ->exec();
    }

    /**
     * 듀이트리 스토리(듀이트리 컨셉 & 약산성 스토리 & 30일 간의 약속) 페이지 호출
     * @param string $er_ix
     * @return array
     */
    public function doStoryPage($er_ix)
    {
        $row = $this->qb
            ->select('event_title')
            ->select('event_text')
            ->from(TBL_SHOP_EVENT)
            ->where('er_ix', $er_ix)
            ->where('disp', 1)
            ->where('kind', 'D')
            ->where('' . time() . ' > event_use_sdate AND ' . time() . ' < event_use_edate')
            ->orderBy('event_ix', 'desc')
            ->limit(1)
            ->exec()
            ->getRowArray();

        return $row;
    }

    /**
     * 듀이트리 영상 리스트 호출
     * @return array
     */
    public function getVideoListAll($orderBy, $orderByType, $page, $max)
    {
        if (!empty($max)) {
            $perPage = $max;
        } else {
            $perPage = 10;
        }

        $this->qb->startCache();

        $this->qb
            ->from(TBL_DEWYTREE_VIDEO)
            ->where('disp', 1);

        $this->qb->stopCache();

        $total = $this->qb->getCount();

        $paging = $this->qb
            ->setTotalRows($total)
            ->pagination($page, $perPage);
        $limit = $perPage;
        $offset = $paging['offset'];

        $this->qb->orderBy($orderBy, $orderByType);

        $list = $this->qb
            ->select('dv_ix')
            ->select('title')
            ->select('video_url')
            ->select('SUBSTRING_INDEX(SUBSTRING_INDEX(video_url, "/", 10), "/", -1) AS thumNail')
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();
        $this->qb->flushCache();

        return [
            'total' => $total
            , 'list' => $list
            , 'paging' => $paging
        ];
    }

    /**
     * 진행이벤트 상세 정보 호출
     * @param string $event_ix
     * @return array
     */
    public function getEventDetail($event_ix)
    {
        $row = $this->qb
            ->select('e.event_ix')
            ->select('event_title')
            ->select('manage_title')
            ->select('event_text')
            ->select('event_text2')
            ->select('kind')
            ->select('b_img_text')
            ->select('b_img_text2')
            ->select('er_ix')
            ->select('LEFT(e.regdate, 7) AS magazine_date')
            ->select('(CASE WHEN ' . time() . ' > event_use_sdate AND ' . time() . ' < event_use_edate THEN "Y" ELSE null END) AS onOff')
            ->select('DATE_FORMAT(FROM_UNIXTIME(event_use_sdate), "%Y-%m-%d") AS startDate, DATE_FORMAT(FROM_UNIXTIME(event_use_edate), "%Y-%m-%d") AS endDate')
            ->select('use_comment')
            ->from(TBL_SHOP_EVENT . ' e')
            ->join(TBL_SHOP_EVENT_CONFIG . ' as c', 'e.event_ix = c.event_ix', 'inner')
            ->where('e.event_ix', $event_ix)
            ->limit(1)
            ->exec()
            ->getRowArray();

        return $row;
    }

    public function getEventRelation($erIx){
        $data = $this->qb
            ->select('title')
            ->from(TBL_SHOP_EVENT_RELATION)
            ->where('er_ix',$erIx)
            ->where('use_yn','Y')
            ->exec()->getRowArray();
        return $data;
    }

    /**
     * 댓글 수정
     * @param int $event_ix
     * @param string $code
     * @param string $comment
     */
    public function getCommentModify($event_ix, $code, $comment, $ec_ix)
    {
        $this->qb
            ->where('ec_ix', $ec_ix)
            ->where('event_ix', $event_ix)
            ->where('mem_ix', $code)
            ->set('comment', $comment)
            ->set('regdate', date('Y-m-d H:i:s'))
            ->update(TBL_SHOP_EVENT_COMMENT)
            ->exec();
    }

    /**
     * 챔피온십에 사용할 옵션을 key로 value 가져오기
     */
    public function getChampionshipOptions($key)
    {
        $options = $this->qb
            ->select('co_ix')
            ->select('option_value')
            ->from(TBL_CHAMPIONSHIP_OPTIONS)
            ->where('option_key', $key)
            ->orderBy('option_order')
            ->exec()->getResultArray();

        return $options;
    }

    /**
     * 챔피온십 멤버 등록
     */
    public function joinChampionship($data)
    {
        $now = date('Y-m-d H:i:s');
        $this->qb->transStart();
        $result = $this->qb
            ->set('gp_ix', $data['attend_div'])
            ->set('attend_div', $data['attend_div'])
            ->encryptSet('name', $data['userName'])
            ->set('sex', $data['sex'])
            ->encryptSet('birthday', $data['birthday'])
            ->encryptSet('handphone', $data['pcs1'].'-'.$data['pcs2'].'-'.$data['pcs3'])
            ->encryptSet('email', $data['emailId'].'@'.$data['emailHost'])
            ->set('size', $data['size'])
            //->set('postnum', $data['zip'])
            //->encryptSet('address1', $data['addr1'])
            //->encryptSet('address2', $data['addr2'])
            ->set('class_name', $data['class_name'])
            ->set('attend_group', $data['attend_group'])
            ->set('attend_event1', $data['attend_event1'])
            ->set('attend_event2', $data['attend_event2'])
            ->encryptSet('depositor', $data['depositor'])
            ->set('password', $this->encryptUserPassword($data['password']))
            ->set('image_url', $data['image_url'])
            ->set('image_url_path', $data['image_url_path'])
            ->set('regdate', $now)
            ->insert(TBL_CHAMPIONSHIP_MEMBER)
            ->exec();


        if($result){
            @rename(MALL_DATA_PATH."/championship/tmp/".$data['image_url_path'], MALL_DATA_PATH.'/championship/'.$data['image_url_path']);

            if(!empty($data['email'])) {
                $this->qb->set('email_yn', ($data['email'] == '1'?'Y':'N'));
            }
            if(!empty($data['sms'])) {
                $this->qb->set('sms_yn', ($data['sms'] == '1'?'Y':'N'));
            }

            $result = $this->qb
                ->set('cm_ix', $this->qb->getInsertId())
                ->set('gp_ix', $data['attend_div'])
                ->set('use_yn', ($data['policyUse'] == 'on'?'Y':'N'))
                ->set('collection_yn', ($data['policyCollection'] == 'on'?'Y':'N'))
                ->set('regdate', $now)
                ->insert(TBL_CHAMPIONSHIP_AGREEMENT)
                ->exec();
        }
        $this->qb->transComplete();
        return $result;

    }

    /**
     * 챔피온십 멤버 수정
     */
    public function updateChampionship($data)
    {
        $now = date('Y-m-d H:i:s');
        $this->qb->transStart();
        $result = $this->qb
            ->set('gp_ix', $data['attend_div'])
            ->set('attend_div', $data['attend_div'])
            ->encryptSet('name', $data['userName'])
            ->set('sex', $data['sex'])
            ->encryptSet('birthday', $data['birthday'])
            ->encryptSet('handphone', $data['pcs1'].'-'.$data['pcs2'].'-'.$data['pcs3'])
            ->encryptSet('email', $data['emailId'].'@'.$data['emailHost'])
            ->set('size', $data['size'])
            //->set('postnum', $data['zip'])
            //->encryptSet('address1', $data['addr1'])
            //->encryptSet('address2', $data['addr2'])
            ->set('class_name', $data['class_name'])
            ->set('attend_group', $data['attend_group'])
            ->set('attend_event1', $data['attend_event1'])
            ->set('attend_event2', $data['attend_event2'])
            ->encryptSet('depositor', $data['depositor'])
            ->set('image_url', $data['image_url'])
            ->set('image_url_path', $data['image_url_path'])
            ->set('editdate', $now)
            ->where('cm_ix', $data['cm_ix'])
            ->update(TBL_CHAMPIONSHIP_MEMBER)
            ->exec();


        if($result){
            @rename(MALL_DATA_PATH."/championship/tmp/".$data['image_url_path'], MALL_DATA_PATH.'/championship/'.$data['image_url_path']);

            $this->qb
                ->set('use_yn', ($data['policyUse'] == 'on'?'Y':'N'))
                ->set('collection_yn', ($data['policyCollection'] == 'on'?'Y':'N'))
                ->set('editdate', $now)
                ->where('cm_ix', $data['cm_ix'])
                ->update(TBL_CHAMPIONSHIP_AGREEMENT)
                ->exec();
        }
        $this->qb->transComplete();
        return $result;

    }

    /**
     * 챔피온십 그룹 등록
     */
    public function joinChampionshipGroup($data)
    {
        $this->qb->transStart();
        $now = date('Y-m-d H:i:s');
        $attend = $data['group_attend'];

        $this->qb
            ->set('group_name', $data['groupName'])
            ->encryptSet('group_master', $data['groupMaster'])
            ->encryptSet('handphone', $data['mpcs1'].'-'.$data['mpcs2'].'-'.$data['mpcs3'])
            ->encryptSet('email', $data['emailMId'].'@'.$data['emailMHost'])
            //->set('postnum', $data['zip'])
            //->encryptSet('address1', $data['addr1'])
            //->encryptSet('address2', $data['addr2'])
            ->set('member_cnt', $data['memberCnt'])
            ->set('attend_event', $attend)
            ->set('group_master_image_url', $data['group_master_image_url'])
            ->set('group_master_image_url_path', $data['group_master_image_url_path'])
            ->encryptSet('depositor', $data['depositor'])
            ->set('password', $this->encryptUserPassword($data['password']))
            ->set('regdate', $now)
            ->insert(TBL_CHAMPIONSHIP_GROUP)
            ->exec();
        $gp_ix = $this->qb->getInsertId();

        if(!empty($gp_ix)) {
            @rename(MALL_DATA_PATH."/championship/tmp/".$data['group_master_image_url_path'], MALL_DATA_PATH.'/championship/'.$data['group_master_image_url_path']);

            $data['sex'] = $this->reduceArray($data['sex']);

            for($i=0; $i<$data['memberCnt']; $i++) {
                //->set('email', $data['emailId'][$i].'@'.$data['emailHost'][$i])
                if(empty($data['attend_event2'][$i])) {
                    $data['attend_event2'][$i] = '';
                }
                $result = $this->qb
                    ->set('gp_ix', $gp_ix)
                    ->set('attend_div', $data['attend_div'])
                    ->encryptSet('name', $data['name'][$i])
                    ->set('sex', $data['sex'][$i])
                    ->encryptSet('birthday', $data['birthday'][$i])
                    ->encryptSet('handphone', $data['pcs1'][$i].'-'.$data['pcs2'][$i].'-'.$data['pcs3'][$i])
                    ->set('size', $data['size'][$i])
                    ->set('class_name', $data['groupName'])
                    ->set('attend_group', $data['attend_group'][$i])
                    ->set('attend_event1', $data['attend_event1'][$i])
                    ->set('attend_event2', $data['attend_event2'][$i])
                    ->set('image_url', $data['image_url'][$i])
                    ->set('image_url_path', $data['image_url_path'][$i])
                    ->set('regdate', $now)
                    ->insert(TBL_CHAMPIONSHIP_MEMBER)
                    ->exec();

                $cm_ix = $this->qb->getInsertId();

                if($result){
                    @rename(MALL_DATA_PATH."/championship/tmp/".$data['image_url_path'][$i], MALL_DATA_PATH.'/championship/'.$data['image_url_path'][$i]);

                    if(!empty($data['email'])) {
                        $this->qb->set('email_yn', ($data['email'] == '1'?'Y':'N'));
                    }

                    if(!empty($data['sms'])) {
                        $this->qb->set('sms_yn', ($data['sms'] == '1'?'Y':'N'));
                    }

                    $this->qb
                        ->set('cm_ix', $cm_ix)
                        ->set('gp_ix', $gp_ix)
                        ->set('use_yn', ($data['policyUse'] == 'on'?'Y':'N'))
                        ->set('collection_yn', ($data['policyCollection'] == 'on'?'Y':'N'))
                        ->set('regdate', $now)
                        ->insert(TBL_CHAMPIONSHIP_AGREEMENT)
                        ->exec();
                }
            }
            $this->qb->transComplete();
            return $result;
        }
        $this->qb->transComplete();
        return false;
    }

    /**
     * 챔피온십 그룹 수정
     */
    public function updateChampionshipGroup($data)
    {
        $this->qb->transStart();
        $now = date('Y-m-d H:i:s');
        $attend = $data['group_attend'];
        $result = $this->qb
            ->set('group_name', $data['groupName'])
            ->encryptSet('group_master', $data['groupMaster'])
            ->encryptSet('handphone', $data['mpcs1'].'-'.$data['mpcs2'].'-'.$data['mpcs3'])
            ->encryptSet('email', $data['emailMId'].'@'.$data['emailMHost'])
            //->set('postnum', $data['zip'])
            //->encryptSet('address1', $data['addr1'])
            //->encryptSet('address2', $data['addr2'])
            ->set('member_cnt', $data['memberCnt'])
            ->set('attend_event', $attend)
            ->set('group_master_image_url', $data['group_master_image_url'])
            ->set('group_master_image_url_path', $data['group_master_image_url_path'])
            ->encryptSet('depositor', $data['depositor'])
            ->set('editdate', $now)
            ->where('gp_ix', $data['gp_ix'])
            ->update(TBL_CHAMPIONSHIP_GROUP)
            ->exec();

        if($result){
            @rename(MALL_DATA_PATH."/championship/tmp/".$data['group_master_image_url_path'], MALL_DATA_PATH.'/championship/'.$data['group_master_image_url_path']);

            $data['sex'] = $this->reduceArray($data['sex']);

            for($i=0; $i<$data['memberCnt']; $i++) {
                //->set('email', $data['emailId'][$i] . '@' . $data['emailHost'][$i])
                if(!empty($data['cm_ix'][$i])) {
                    //기존회원 업데이트
                    $result = $this->qb
                        ->set('attend_div', $data['attend_div'])
                        ->encryptSet('name', $data['name'][$i])
                        ->set('sex', $data['sex'][$i])
                        ->encryptSet('birthday', $data['birthday'][$i])
                        ->encryptSet('handphone', $data['pcs1'][$i] . '-' . $data['pcs2'][$i] . '-' . $data['pcs3'][$i])
                        ->set('size', $data['size'][$i])
                        ->set('class_name', $data['groupName'])
                        ->set('attend_group', $data['attend_group'][$i])
                        ->set('attend_event1', $data['attend_event1'][$i])
                        ->set('attend_event2', (!empty($data['attend_event2'][$i]) ? $data['attend_event2'][$i] : ''))
                        ->set('image_url', $data['image_url'][$i])
                        ->set('image_url_path', $data['image_url_path'][$i])
                        ->set('editdate', $now)
                        ->where('gp_ix', $data['gp_ix'])
                        ->where('cm_ix', $data['cm_ix'][$i])
                        ->update(TBL_CHAMPIONSHIP_MEMBER)
                        ->exec();

                    if ($result) {
                        @rename(MALL_DATA_PATH . "/championship/tmp/" . $data['image_url_path'][$i], MALL_DATA_PATH . '/championship/' . $data['image_url_path'][$i]);

                        if (!empty($data['email'])) {
                            $this->qb->set('email_yn', ($data['email'] == '1' ? 'Y' : 'N'));
                        }

                        if (!empty($data['sms'])) {
                            $this->qb->set('sms_yn', ($data['sms'] == '1' ? 'Y' : 'N'));
                        }

                        $this->qb
                            ->set('use_yn', ($data['policyUse'] == 'on' ? 'Y' : 'N'))
                            ->set('collection_yn', ($data['policyCollection'] == 'on' ? 'Y' : 'N'))
                            ->set('editdate', $now)
                            ->where('cm_ix', $data['cm_ix'][$i])
                            ->where('gp_ix', $data['gp_ix'])
                            ->update(TBL_CHAMPIONSHIP_AGREEMENT)
                            ->exec();
                    }
                }else {
                    //새로추가된 팀원
                    $result = $this->qb
                        ->set('gp_ix', $data['gp_ix'])
                        ->set('attend_div', $data['attend_div'])
                        ->encryptSet('name', $data['name'][$i])
                        ->set('sex', $data['sex'][$i])
                        ->encryptSet('birthday', $data['birthday'][$i])
                        ->encryptSet('handphone', $data['pcs1'][$i].'-'.$data['pcs2'][$i].'-'.$data['pcs3'][$i])
                        ->set('size', $data['size'][$i])
                        ->set('class_name', $data['groupName'])
                        ->set('attend_group', $data['attend_group'][$i])
                        ->set('attend_event1', $data['attend_event1'][$i])
                        ->set('attend_event2', (!empty($data['attend_event2'][$i]) ? $data['attend_event2'][$i] : ''))
                        ->set('image_url', $data['image_url'][$i])
                        ->set('image_url_path', $data['image_url_path'][$i])
                        ->set('regdate', $now)
                        ->insert(TBL_CHAMPIONSHIP_MEMBER)
                        ->exec();

                    $cm_ix = $this->qb->getInsertId();

                    if($result){
                        @rename(MALL_DATA_PATH."/championship/tmp/".$data['image_url_path'][$i], MALL_DATA_PATH.'/championship/'.$data['image_url_path'][$i]);

                        if(!empty($data['email'])) {
                            $this->qb->set('email_yn', ($data['email'] == '1'?'Y':'N'));
                        }

                        if(!empty($data['sms'])) {
                            $this->qb->set('sms_yn', ($data['sms'] == '1'?'Y':'N'));
                        }

                        $this->qb
                            ->set('cm_ix', $cm_ix)
                            ->set('gp_ix', $data['gp_ix'])
                            ->set('use_yn', ($data['policyUse'] == 'on'?'Y':'N'))
                            ->set('collection_yn', ($data['policyCollection'] == 'on'?'Y':'N'))
                            ->set('regdate', $now)
                            ->insert(TBL_CHAMPIONSHIP_AGREEMENT)
                            ->exec();
                    }
                }
            }
        }
        $this->qb->transComplete();
        return $result;
    }

    /**
     * @param array $data
     * @return 멤버번호, 그룹번호
     * @comment 등록여부 확인
     */
    public function checkChampionship($data)
    {
        $result = $this->qb
            ->select('cm_ix')
            ->select('gp_ix')
            ->from(TBL_CHAMPIONSHIP_MEMBER)
            ->encryptWhere('name', $data['name'])
            ->encryptWhere('birthday', $data['birthday'])
            ->where('password', $this->encryptUserPassword($data['password']))
            ->exec()->getRowArray();

        return $result;
    }
    /**
     * @param array $data
     * @return 그룹번호
     * @comment 그룹 등록여부 확인
     */
    public function checkChampionshipGroup($data)
    {
        $result = $this->qb
            ->select('gp_ix')
            ->from(TBL_CHAMPIONSHIP_GROUP)
            ->where('group_name', $data['group_name'])
            ->encryptWhere('group_master', $data['group_master'])
            ->where('password', $this->encryptUserPassword($data['password']))
            ->exec()->getRowArray();
        return $result;
    }

    /**
     * @param int $cm_ix
     * @return 개인참가자 정보
     * @comment 개인참가자 정보가져오기
     */
    public function selectChampionshipMember($cm_ix)
    {
        $result = $this->qb
            ->select('cm.cm_ix')
            ->select('cm.gp_ix')
            ->select('cm.attend_div')
            ->select('cm.sex')
            ->select('cm.postnum')
            ->select('cm.size')
            ->select('cm.class_name')
            ->select('cm.attend_group')
            ->select('cm.attend_event1')
            ->select('cm.attend_event2')
            ->select('cm.image_url')
            ->select('cm.image_url_path')
            ->decryptSelect('cm.name')
            ->decryptSelect('cm.birthday')
            ->decryptSelect('cm.handphone')
            ->decryptSelect('cm.email')
            ->decryptSelect('cm.address1')
            ->decryptSelect('cm.address2')
            ->decryptSelect('cm.depositor')
            //->select('DATE_FORMAT(cm.birthday, "%y%m%d") as birthday')
            ->select('use_yn, collection_yn, email_yn, sms_yn')
            ->from(TBL_CHAMPIONSHIP_MEMBER.' AS cm')
            ->join(TBL_CHAMPIONSHIP_AGREEMENT.' AS ca', 'cm.cm_ix = ca.cm_ix')
            ->where('cm.cm_ix', $cm_ix)
            ->exec()->getRowArray();

            $result['explodePcs'] = explode('-', $result['handphone']);
            $result['explodeEmail'] = explode('@', $result['email']);
            $result['image_path'] = DATA_ROOT.'/championship/'.$result['image_url_path'];

        return $result;
    }

    /**
     * @param int $gp_ix
     * @return 그룹참가자 정보
     * @comment 그룹참가자 정보가져오기
     */
    public function selectChampionshipGroup($gp_ix)
    {
        $group = $this->qb
            ->select('cg.gp_ix')
            ->select('cg.group_name')
            ->select('cg.member_cnt')
            ->select('cg.postnum')
            ->select('cg.postnum')
            ->select('cg.attend_event')
            ->select('cg.group_master_image_url')
            ->select('cg.group_master_image_url_path')
            ->select('ca.*')
            ->decryptSelect('cg.group_master')
            ->decryptSelect('cg.address1')
            ->decryptSelect('cg.address2')
            ->decryptSelect('cg.email')
            ->decryptSelect('cg.handphone')
            ->decryptSelect('cg.depositor')
            ->from(TBL_CHAMPIONSHIP_GROUP.' AS cg')
            ->join(TBL_CHAMPIONSHIP_AGREEMENT.' AS ca', 'cg.gp_ix = ca.gp_ix')
            ->where('cg.gp_ix', $gp_ix)
            ->limit(1)
            ->exec()->getRowArray();

        $group['explodeMPcs'] = explode('-', $group['handphone']);
        $group['explodeMEmail'] = explode('@', $group['email']);

        $group['attend_event'] = explode(',', $group['attend_event']);
        if(empty($group['attend_event'][0])) {
            $aCnt = 0;
        }else {
            $aCnt = count($group['attend_event']);
        }
        $group['group_master_image_path'] = DATA_ROOT.'/championship/'.$group['group_master_image_url_path'];

        $group['member'] = $this->qb
            ->select('cm.cm_ix')
            ->select('cm.gp_ix')
            ->select('cm.attend_div')
            ->select('cm.sex')
            ->select('cm.postnum')
            ->select('cm.size')
            ->select('cm.class_name')
            ->select('cm.attend_group')
            ->select('cm.attend_event1')
            ->select('cm.attend_event2')
            ->select('cm.image_url')
            ->select('cm.image_url_path')
            ->decryptSelect('cm.name')
            ->decryptSelect('cm.birthday')
            ->decryptSelect('cm.handphone')
            ->decryptSelect('cm.email')
            ->decryptSelect('cm.address1')
            ->decryptSelect('cm.address2')
            ->decryptSelect('cm.depositor')
            //->select('DATE_FORMAT(cm.birthday, "%y%m%d") as birthday')
            ->select('use_yn, collection_yn, email_yn, sms_yn')
            ->from(TBL_CHAMPIONSHIP_MEMBER.' AS cm')
            ->join(TBL_CHAMPIONSHIP_AGREEMENT.' AS ca', 'cm.cm_ix = ca.cm_ix and cm.gp_ix = ca.gp_ix')
            ->where('cm.gp_ix', $gp_ix)
            ->exec()->getResultArray();

        for($i=0; $i<$group['member_cnt']; $i++) {
            $group['member'][$i]['explodePcs'] = explode('-', $group['member'][$i]['handphone']);
            //$group['member'][$i]['explodeEmail'] = explode('@', $group['member'][$i]['email']);
            $group['member'][$i]['image_path'] = DATA_ROOT.'/championship/'.$group['member'][$i]['image_url_path'];
        }

        $group['joinPrice'] = (40000 * $group['member_cnt']) + (20000 * $aCnt);

        return $group;
    }

    /**
     * 챔피온십 멤버수 체크
     */
    public function checkChampionshipLimit()
    {
        $this->qb->setDatabase('payment');
        $result = $this->qb
            ->select('count(*) as cnt')
            ->from(TBL_CHAMPIONSHIP_MEMBER)
            ->exec()->getRow();

        return $result->cnt;
    }

    /**
     * 챔피온십 그룹 멤버 제거
     */
    public function deleteChampionship($data)
    {
        $this->qb->setDatabase('payment');
        //멤버수 감소
        if($this->downGroupMemberCount($data)) {
            $result = $this->qb
                ->delete(TBL_CHAMPIONSHIP_MEMBER)
                ->where('cm_ix', $data['cm_ix'])
                ->exec();
        }

        return $result;
    }

    /**
     * @param $data
     * @return bool|NunaResult
     * 그룹 인원수 감소
     */
    public function downGroupMemberCount($data)
    {
        $this->qb->setDatabase('payment');
        $result = $this->qb
            ->update(TBL_CHAMPIONSHIP_GROUP)
            ->set('member_cnt', ($data['member_cnt']-1))
            ->where('gp_ix', $data['gp_ix'])
            ->exec();

        return $result;
    }

    /**
     * @param
     * @return bool|NunaResult
     * 챔피언십 오픈/마감일 체크
     */
    public function checkChampionshipDay()
    {
        $info = $this->qb
            ->select('*')
            ->from(TBL_CHAMPIONSHIP_SET)
            ->exec()->getRow();

        return $info;
    }


    /**
     * 비밀번호 암호화
     * @param string $pw
     * @return string
     */
    public function encryptUserPassword($pw)
    {
        return encrypt_user_password($pw);
    }

    /**
     * 배열 빈값 제거 후 당기기
     * @param array
     * @return array
     */
    public function reduceArray($arr) {
        return array_values(array_filter(array_map('trim',$arr)));
    }
}
