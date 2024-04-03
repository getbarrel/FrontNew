<?php

/**
 * Description of CustomMallMypageModel
 *
 * @author hoksi
 */
class CustomMallProductQnaModel extends ForbizMallProductQnaModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 상품문의 입력
     * @param array $res
     * @return boolean
     */
    public function insertQna($res)
    {
        $prdDatas = $this->qb->select("pname, admin")
            ->from(TBL_SHOP_PRODUCT)
            ->where('id', $res['pid'])
            ->exec()
            ->getRowArray(); //상품데이터

        if (empty($res['isHidden'])) {
            $res['isHidden'] = '0';
        }

        $this->qb->insert(TBL_SHOP_PRODUCT_QNA,
            [
                'mall_ix' => MALL_IX,
                'bbs_div' => $res['div'],
                'pid' => $res['pid'],
                'pname' => $prdDatas['pname'],
                'company_id' => $prdDatas['admin'],
                'ucode' => $this->userCode,
                'bbs_subject' => $res['subject'],
                'bbs_name' => $this->userName,
                'bbs_id' => $this->userId,
                'bbs_hidden' => $res['isHidden'],
                'bbs_email' => $res['emailId'].'@'.$res['emailHost'],
                'bbs_contents' => $res['contents'],
                'bbs_email_return' => $res['bbs_email_return'],
                'regdate' => date('Y-m-d H:i:s')
            ])->exec();
        return true;
    }

    public function updateQna($res){
        $bbsDatas = $this->qb->select()
            ->from(TBL_SHOP_PRODUCT_QNA)
            ->where('bbs_ix', $res['bbs_ix'])
            ->where('ucode', $this->userCode)
            ->getCount();

        if($bbsDatas) {
            if (empty($res['isHidden'])) {
                $res['isHidden'] = '0';
            }

            $this->qb
                ->set('bbs_div',$res['div'])
                ->set('bbs_subject',$res['subject'])
                ->set('bbs_hidden',$res['isHidden'])
                ->set('bbs_email',$res['emailId'] . '@' . $res['emailHost'])
                ->set('bbs_contents',$res['contents'])
                ->set('bbs_email_return',$res['bbs_email_return'])
                ->update(TBL_SHOP_PRODUCT_QNA)
                ->where('bbs_ix',$res['bbs_ix'])
                ->where('ucode', $this->userCode)
                ->exec();

            return true;
        }else{
            return false;
        }
    }

    /**
     * 상품문의 리스트
     * @param string $id
     * @param string $type
     * @param int $bbsDiv
     * @param int $max
     * @param int $curPage
     * @return array
     */
    public function getList($id, $type, $bbsDiv, $max, $curPage, $resYn = '', $sDate = '', $eDate = '')
    {
        $perPage = $max;
        $this->qb->startCache();
        $this->qb->from(TBL_SHOP_PRODUCT_QNA);

        $this->qb->where('mall_ix', MALL_IX);

        if ($bbsDiv != '' && $bbsDiv != 'all') {
            $this->qb->where('bbs_div', $bbsDiv);
        }

        // 내문의
        if ($type == 'mine') {
            $this->qb->where('ucode', $this->userCode);
        }

        if ($id) {
            $this->qb->where('pid', $id);
        }

        // 답변등록여부
        if ($resYn == 'Y') {
            $this->qb->where('bbs_re_cnt > ', 0);
        } else if ($resYn == 'N') {
            $this->qb->where('bbs_re_cnt = ', 0);
        }

        if ($sDate != "") {
            $this->qb->where("date_format(regdate,'%Y-%m-%d') >= ", $sDate);
        }
        if ($eDate != "") {
            $this->qb->where("date_format(regdate,'%Y-%m-%d') <= ", $eDate);
        }

        $this->qb->stopCache();

        $total  = $this->qb->getCount();
        if(is_mobile()){
            $paging = $this->qb->setTotalRows($total)->pagination($curPage, $perPage,5);
        }else{
            $paging = $this->qb->setTotalRows($total)->pagination($curPage, $perPage);
        }



        $limit  = $perPage;
        $offset = $paging['offset'];
        #내가쓴 문의 글을 가장 상위로 보내기 위해 처리
        $datas = [];
        $datas2 = [];
        if($this->userCode){

            $datas  = $this->qb
                ->select("*")
                ->select("CASE WHEN regdate > DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 1 ELSE 0 END AS NEW")
                ->select("CONCAT(SUBSTR(bbs_id, 1, 3), '****') AS bbs_id")
                ->where('ucode', $this->userCode)
                ->limit($limit, $offset)
                ->orderBy('regdate', 'desc')
                ->exec()
                ->getResultArray();

            $datas2  = $this->qb
                ->select("*")
                ->select("CASE WHEN regdate > DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 1 ELSE 0 END AS NEW")
                ->select("CONCAT(SUBSTR(bbs_id, 1, 3), '****') AS bbs_id")
                ->whereNotIn('ucode', $this->userCode)
                ->limit($limit, $offset)
                ->orderBy('regdate', 'desc')
                ->exec()
                ->getResultArray();

            $datas = array_merge($datas,$datas2);
        }else{

            $datas  = $this->qb
                ->select("*")
                ->select("CASE WHEN regdate > DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 1 ELSE 0 END AS NEW")
                ->select("CONCAT(SUBSTR(bbs_id, 1, 3), '****') AS bbs_id")
                ->limit($limit, $offset)
                ->orderBy('regdate', 'desc')
                ->exec()
                ->getResultArray();
        }



        $this->qb->flushCache();

        $list = array();
        foreach ($datas as $k => $v) {

            $v['bbs_contents'] = $v['bbs_contents'];
            $v['image_src']    = get_product_images_src($v['pid'], false, 'm', '');

            $v['div_name']   = $this->getDivsName($v['bbs_div']);
            $v['comments']   = $this->getComments($v['bbs_ix']); //답변 데이터
            $v['isResponse'] = false; //답변 여부
            if (count($v['comments']) > 0) {
                $v['isResponse'] = true;
                $v['resDate']    = $v['comments']['0']['regdate'];
            }

            $v['isHidden'] = false; //공개/비공개 여부
            if ($v['bbs_hidden'] == 1) {
                $v['isHidden'] = true;
            }

            $v['regdate'] = date('Y-m-d',strtotime($v['regdate']));

            $v['isSameUser'] = false; //동일 작성자 여부
            if (!empty($this->userCode) && ($v['ucode'] == $this->userCode)) {
                $v['isSameUser'] = true;
            }else{
                $v['isSameUser'] = false;
                $v['bbs_name'] = iconv_substr($v['bbs_name'],0,1,'utf-8')."**";

                if ($v['bbs_hidden'] == 1) {
                    $v['bbs_contents'] = '비공개';
                    $v['comments'] = '비공개';
                }

            }
            $list[] = $v;
        }

        return [
            'total' => $total,
            'list' => $list,
            'paging' => $paging
        ];
    }

    public function deleteQna($bbsIx){


        $this->qb
            ->select()
            ->from(TBL_SHOP_PRODUCT_QNA)
            ->where('ucode',$this->userCode)
            ->where('bbs_ix',$bbsIx);

        $cnt = $this->qb->getCount();
        if($cnt){
            $comments  = $this->getComments($bbsIx); //답변 데이터

            if (count($comments) > 0) {
                $result = "fail";
                $msg = "답변이 존재함";
            }else{

                $this->qb
                    ->delete(TBL_SHOP_PRODUCT_QNA)
                    ->where('ucode',$this->userCode)
                    ->where('bbs_ix',$bbsIx)
                    ->exec();

                $result = "success";
                $msg = "";
            }

        }else{
            $result = "fail";
            $msg = "회원과 게시물 매칭에 실패 함";
        }

        return [
            'result' => $result
            ,'msg' => $msg
        ];
    }

    public function getSelectQna($bbsIx){
        $bbsData = $this->qb
            ->select('*')
            ->from(TBL_SHOP_PRODUCT_QNA)
            ->where('ucode',$this->userCode)
            ->where('bbs_ix',$bbsIx)
            ->exec()->getRowArray()
        ;

        if($bbsData['bbs_email']){
            $emailArr = explode('@',$bbsData['bbs_email']);
            $bbsData['emailId'] = $emailArr[0];
            $bbsData['emailHost']   = $emailArr[1];
        }

        return $bbsData;
    }

    /**
     * 상품 문의 상세
     * @param type $bbsIx
     * @return type
     */
    public function getDetail($bbsIx, $userCode)
    {
        $row = $this->qb
            ->select("bbs_ix")
            ->select("pq.pid")
            ->select("pq.pname")
            ->select("bbs_div")
            ->select("bbs_subject")
            ->select("bbs_contents")
            ->select("pq.regdate")
            ->select("p.add_info")
            ->select("pq.regdate")
            ->select("p.add_info")
            ->from(TBL_SHOP_PRODUCT_QNA . ' AS pq')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'pq.pid = p.id')
            ->where("bbs_ix", $bbsIx)
            ->where("ucode", $userCode)
            ->exec()
            ->getRowArray();

        if(!empty($row)){
            $row['bbs_contents'] = nl2br($row['bbs_contents']);
            $row['image_src']    = get_product_images_src($row['pid'], false, 's', '');
            $row['comments']   = $this->getComments($row['bbs_ix']); //답변 데이터
            $row['div_name'] = $this->getDivsName($row['bbs_div']);
            $row['regdate'] = date('Y-m-d', strtotime($row['regdate']));
            $row['isResponse'] = false; //답변 여부
            if (count($row['comments']) > 0) {
                $row['isResponse'] = true;
            }
        }
        return $row;
    }

    /**
     * 답변 데이터 출력
     * @param int $bbsIx
     * @return array
     */
    public function getComments($bbsIx)
    {
        $datas = $this->qb->select("cmt_name, cmt_contents, regdate")
            ->from(TBL_SHOP_PRODUCT_QNA_COMMENT)
            ->where("bbs_ix", $bbsIx)
            ->orderBy("regdate", "ASC")
            ->exec()
            ->getResultArray();

        if (!empty($datas)) {
            for ($i = 0; $i < count($datas); $i++) {
                $datas[$i]['cmt_contents'] = $datas[$i]['cmt_contents'];
                $datas[$i]['regdate'] = date('Y-m-d', strtotime($datas[$i]['regdate']));
            }
        }

        return $datas;
    }

    /**
     * 문의 개수 출력
     * @param string $id
     * @return array
     */
    public function getCount($id, $bbsDiv = 'all')
    {
        if ($bbsDiv != '' && $bbsDiv != 'all') {
            $this->qb
                ->startCache()
                ->where('bbs_div', $bbsDiv)
                ->stopCache();
        }

        $datas = $this->qb
            ->select('bbs_ix')
            ->from(TBL_SHOP_PRODUCT_QNA)
            ->where('pid', $id)
            ->where('mall_ix', MALL_IX)
            ->exec()
            ->getResultArray();

        $specificDatas = $this->qb
            ->select('bbs_ix')
            ->from(TBL_SHOP_PRODUCT_QNA)
            ->where('pid', $id)
            ->where('ucode', $this->userCode)
            ->where('mall_ix', MALL_IX)
            ->exec()
            ->getResultArray();

        // qb 캐시 클리어
        $this->qb->flushCache();

        $total = array('all' => count($datas), 'mine' => count($specificDatas));
        return $total;
    }

    /**
     * 문의 분류 출력
     * @return array
     */
    public function getAllDivs()
    {
        $Datas = $this->qb
            ->select('*')
            ->from(TBL_SHOP_PRODUCT_QNA_DIV)
            ->where('disp', '1')
            ->whereIn('mall_ix', ['', MALL_IX])
            ->exec()
            ->getResultArray();
        return $Datas;
    }
}