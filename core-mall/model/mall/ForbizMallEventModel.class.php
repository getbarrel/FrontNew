<?php

/**
 * Description of ForbizMallEventModel
 *
 * @author hong
 * @property CustomMallProductModel $productModel
 */
class ForbizMallEventModel extends ForbizModel
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
    public function getEventList($kind, $orderBy, $orderByType, $page, $max, $state, $where = [])
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

        if($state == "I"){
            $this->qb
                ->where('event_use_sdate <=', time())
                ->where('event_use_edate >=', time());
        }else if($state == "E"){
            $this->qb
                ->where('event_use_edate < ', time());
        }

        if (is_array($where) && !empty($where)) {
            foreach ($where as $k => $v) {
                $this->qb->where($k, $v);
            }
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

        $wishModel = $this->import('model.mall.wish');

        foreach ($list as $k => $v) {
            $list[$k]['imgPath'] = $domain . DATA_ROOT ."/images/event/" . $list[$k]['event_ix'] . "/event_banner_" . $list[$k]['event_ix'] . ".gif";

            if($wishModel->checkAlreadyContentWish($list[$k]['event_ix'], 'E')){
                $list[$k]['alreadyWishContent'] = true;
            }else{
                $list[$k]['alreadyWishContent'] = false;
            }
        }

        return [
            'total' => $total
            , 'list' => $list
            , 'paging' => $paging
        ];
    }

    public function getEventListNew($kind, $orderBy, $orderByType, $page, $max, $state, $where = [])
    {
        if (!empty($max)) {
            $perPage = $max;
        } else {
            $perPage = 10;
        }

        $this->qb->startCache();

        $this->qb
            ->from('shop_content')
            ->like('cid', '002', 'after');

        if($state == "I" || $state == ""){      // 진행중 이벤트
            $this->qb
                ->where('display_start <=', time())
                ->where('display_end >=', time())
                ->where('display_state', "D");
        }else if($state == "E"){    // 종료 이벤트
            $this->qb
                ->where('display_end < ', time())
                ->orwhere('display_state', "E");
        }else if($state == "A"){ // 전체
            $this->qb
                ->where('display_start <', time())
                ->where('display_state != ', 'W');
        }

        if (is_array($where) && !empty($where)) {
            foreach ($where as $k => $v) {
                $this->qb->where($k, $v);
            }
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
            ->select('con_ix as event_ix')
            ->select('title as event_title')
            ->select('title_en, b_title, i_title, u_title, c_title, s_title')
            ->select('preface as onOff')
            ->select('preface_en, b_preface, i_preface, u_preface, c_preface')
            ->select('explanation')
            ->select('explanation_en, b_explanation, i_explanation, u_explanation, c_explanation')
            ->select('list_img')
            ->select('display_gubun')
            ->select('display_date_use')
            ->select('display_end')
            ->select('display_state')
            //->select('LEFT(regdate, 10) AS regdate')
            //->select('(CASE WHEN ' . time() . ' > event_use_sdate AND ' . time() . ' < event_use_edate THEN "Y" ELSE null END) AS onOff')
            ->select('DATE_FORMAT(FROM_UNIXTIME(display_start), "%Y-%m-%d") AS startDate, DATE_FORMAT(FROM_UNIXTIME(display_end), "%Y-%m-%d") AS endDate')
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();
        $this->qb->flushCache();

        $domain = (!empty(IMAGE_SERVER_DOMAIN) ? IMAGE_SERVER_DOMAIN : HTTP_PROTOCOL . FORBIZ_HOST );

        $wishModel = $this->import('model.mall.wish');

        foreach ($list as $k => $v) {
            $list[$k]['imgPath'] = $domain . DATA_ROOT ."/images/content/" . $list[$k]['event_ix'] . "/" . $list[$k]['list_img'];

            if($list[$k]['display_end'] < time() || $list[$k]['display_state'] == 'E'){
                $list[$k]['display_end_gubun'] = true;
            }else{
                $list[$k]['display_end_gubun'] = false;
            }

            if($wishModel->checkAlreadyContentWish($list[$k]['event_ix'], 'E')){
                $list[$k]['alreadyWishContent'] = true;
            }else{
                $list[$k]['alreadyWishContent'] = false;
            }

            if($list[$k]['display_gubun'] == "P"){
                $list[$k]['display_gubun'] = true;
            }else{
                $list[$k]['display_gubun'] = false;
            }

            if($list[$k]['b_title'] == "Y"){
                $list[$k]['b_title']    = "font-weight: bold;";
            }else{
                $list[$k]['b_title']    = "";
            }

            if($li['i_title'] == "Y"){
                $li['i_title']    = "font-style:oblique;";
            }else{
                $li['i_title']    = "";
            }

            if($list[$k]['u_title'] == "Y"){
                $list[$k]['u_title']    = "text-decoration-line: underline;";
            }else{
                $list[$k]['u_title']    = "";
            }

            if($list[$k]['s_title'] == "L") {
                $list[$k]['s_title']    = "text-align: left;";
            }else if($list[$k]['s_title'] == "C") {
                $list[$k]['s_title']    = "text-align: center;";
            }else if($list[$k]['s_title'] == "R"){
                $list[$k]['s_title']    = "text-align: right;";
            }else{
                $list[$k]['s_title']    = "";
            }

            if($list[$k]['b_preface'] == "Y"){
                $list[$k]['b_preface']    = "font-weight: bold;";
            }else{
                $list[$k]['b_preface']    = "";
            }

            if($list[$k]['i_preface'] == "Y"){
                $list[$k]['i_preface']    = "font-style:oblique;";
            }else{
                $list[$k]['i_preface']    = "";
            }

            if($list[$k]['u_preface'] == "Y"){
                $list[$k]['u_preface']    = "text-decoration-line: underline;";
            }else{
                $list[$k]['u_preface']    = "";
            }

            if($list[$k]['b_explanation'] == "Y"){
                $list[$k]['b_explanation']    = "font-weight: bold;";
            }else{
                $list[$k]['b_explanation']    = "";
            }

            if($list[$k]['i_explanation'] == "Y"){
                $list[$k]['i_explanation']    = "font-style:oblique;";
            }else{
                $list[$k]['i_explanation']    = "";
            }

            if($list[$k]['u_explanation'] == "Y"){
                $list[$k]['u_explanation']    = "text-decoration-line: underline;";
            }else{
                $list[$k]['u_explanation']    = "";
            }

            if($list[$k]['display_date_use'] == "Y"){
                $list[$k]['display_date_use'] = true;
            }else{
                $list[$k]['display_date_use'] = false;
            }

            //$list[$k]['explanation'] = nl2br($list[$k]['explanation']);
            //$list[$k]['explanation'] = str_replace("\r\n","<p>",$list[$k]['explanation']);
            //echo $list[$k]['explanation']."<br>";
        }

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

    /**
     * 진행이벤트 상세 그룹 정보 호출
     * @param string $event_ix
     * @return array
     */
    public function getEventGroupGoods($event_ix)
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
            $datas[$k]['goods'] = $this->getEventGoods($event_ix, $v['group_code'], $v['product_cnt']);
			if(file(IMAGE_SERVER_DOMAIN."/".MALL_DATA."/images/event/$event_ix/event_group_".$v['group_code'].".gif")){
				$datas[$k]['group_image'] = IMAGE_SERVER_DOMAIN."/".MALL_DATA."/images/event/$event_ix/event_group_".$v['group_code'].".gif";
			}
			if(file(IMAGE_SERVER_DOMAIN."/".MALL_DATA."/images/event/$event_ix/m_event_group_".$v['group_code'].".gif")){
				$datas[$k]['group_image_m'] = IMAGE_SERVER_DOMAIN."/".MALL_DATA."/images/event/$event_ix/m_event_group_".$v['group_code'].".gif";
			}
        }

        return $datas;
    }

    /**
     * 진행이벤트 상세 그룹별 상품 정보 호출
     * @param string $event_ix
     * @param string $group_code
     * @return array
     */
    public function getEventGoods($event_ix, $group_code = false, $product_cnt = 4)
    {
        if ($this->productModel == false) {
            $this->productModel = $this->import('model.mall.product');
        }

        if ($group_code !== false) {
            $this->qb->where('r.group_code', $group_code);
        }

        $ids = $this->productModel->basicWhere()
            ->select('p.id')
            ->from(TBL_SHOP_PRODUCT . ' p')
            ->join(TBL_SHOP_EVENT_PRODUCT_RELATION . ' as r', 'r.pid=p.id', 'left')
            ->where('r.event_ix', $event_ix)
            ->orderBy('r.vieworder', 'ASC')
            ->limit($product_cnt)
            ->exec()->getResultArray();

        if (!empty($ids)) {
            return $this->productModel->getListById(array_column($ids, 'id'));
        } else {
            return [];
        }
    }

    /**
     * 댓글리스트
     * @param $kind
     * @param $orderBy
     * @param $orderByType
     * @param $page
     * @param $max
     * @param $event_ix
     * @param $monthLimit
     * @return array
     */
    public function getCommentList($event_ix, $userCode, $orderBy, $orderByType, $page, $max)
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
            ->where('e.disp', 1)
            ->where('c.disp', 1)
            ->where('e.event_ix', $event_ix);

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
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();
        $this->qb->flushCache();

        if (is_login()) { //로그인 아이디 댓글 체크
            foreach ($list as $k => $v) {
                if ($userCode == $list[$k]['mem_ix']) {
                    $list[$k]['idChk'] = "Y";
                } else {
                    $list[$k]['idChk'] = "";
                }
                $list[$k]['comment'] = nl2br($list[$k]['comment']);
            }
        }

        return [
            'total' => $total
            , 'list' => $list
            , 'paging' => $paging
        ];
    }

    /**
     * 진행이벤트 회원 코멘트 입력 체크
     * @param int $event_ix
     * @param string $userCode
     * @param string $comment
     * @return string
     */
    public function isUserComment($event_ix, $userCode)
    {
        $cnt = $this->qb
            ->from(TBL_SHOP_EVENT_COMMENT)
            ->where('event_ix', $event_ix)
            ->where('mem_ix', $userCode)
            ->getCount();

        if ($cnt > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 댓글 등록
     * @param int $event_ix
     * @param string $userCode
     * @param string $comment
     */
    public function addComment($event_ix, $userCode, $comment)
    {
        $this->qb
            ->set('event_ix', $event_ix)
            ->set('mem_ix', $userCode)
            ->set('comment', $comment)
            ->insert(TBL_SHOP_EVENT_COMMENT)
            ->exec();
    }

    /**
     * 댓글 삭제
     * @param int $ec_ix
     */
    public function delComment($ec_ix, $userCode)
    {
        $this->qb
            ->delete(TBL_SHOP_EVENT_COMMENT)
            ->where('ec_ix', $ec_ix)
            ->where('mem_ix', $userCode)
            ->exec();
    }
}