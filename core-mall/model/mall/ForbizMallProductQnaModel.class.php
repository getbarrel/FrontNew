<?php

/**
 * Description of FobizMallMypageModel
 *
 * @author hoksi
 */
class ForbizMallProductQnaModel extends ForbizModel
{
    protected $userCode = "";
    protected $userId;
    protected $userName;
    protected $config;

    public function __construct()
    {
        parent::__construct();

        $this->userCode = sess_val('user', 'code');
        $this->userId   = sess_val('user', 'id');
        $this->userName = sess_val('user', 'name');

        $this->config = ForbizConfig::getSharedMemory("product_qna"); //qna 설정 호출
    }

    public function getConfig()
    {
        return $this->config;
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
            ->exec()
            ->getResultArray();

        $specificDatas = $this->qb
            ->select('bbs_ix')
            ->from(TBL_SHOP_PRODUCT_QNA)
            ->where('pid', $id)
            ->where('ucode', $this->userCode)
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
            ->exec()
            ->getResultArray();
        return $Datas;
    }

    /**
     * 문의 키값에 따른 문의명 출력
     * @param int $ix
     * @return string
     */
    public function getDivsName($ix)
    {
        $Datas = $this->qb
            ->select('div_name')
            ->from(TBL_SHOP_PRODUCT_QNA_DIV)
            ->where('ix', $ix)
            ->exec()
            ->getResultArray();
        return $Datas[0]['div_name'];
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
        $paging = $this->qb->setTotalRows($total)->pagination($curPage, $perPage);

        $limit  = $perPage;
        $offset = $paging['offset'];
        $datas  = $this->qb
            ->select("*")
            ->select("CASE WHEN regdate > DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 1 ELSE 0 END AS NEW")
            ->select("CONCAT(SUBSTR(bbs_id, 1, 3), '****') AS bbs_id")
            ->limit($limit, $offset)
            ->orderBy('regdate', 'desc')
            ->exec()
            ->getResultArray();

        $this->qb->flushCache();



        $list = array();
        foreach ($datas as $k => $v) {

            $v['bbs_contents'] = nl2br($v['bbs_contents']);
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

            $v['isSameUser'] = false; //동일 작성자 여부
            if ($v['ucode'] == $this->userCode) {
                $v['isSameUser'] = true;
            }
            $list[] = $v;
        }

        return [
            'total' => $total,
            'list' => $list,
            'paging' => $paging
        ];
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
            ->orderBy("regdate", "DESC")
            ->exec()
            ->getResultArray();

        if (!empty($datas)) {
            for ($i = 0; $i < count($datas); $i++) {
                $datas[$i]['cmt_contents'] = nl2br($datas[$i]['cmt_contents']);
            }
        }

        return $datas;
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
            'regdate' => date('Y-m-d H:i:s')
        ])->exec();
        return true;
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
            ->select("pid")
            ->select("pname")
            ->select("bbs_div")
            ->select("bbs_subject")
            ->select("bbs_contents")
            ->select("regdate")
            ->from(TBL_SHOP_PRODUCT_QNA)
            ->where("bbs_ix", $bbsIx)
            ->where("ucode", $userCode)
            ->exec()
            ->getRowArray();
        
        if(!empty($row)){
            $row['bbs_contents'] = nl2br($row['bbs_contents']);
            $row['image_src']    = get_product_images_src($row['pid'], false, 's', '');
            $row['comments']   = $this->getComments($row['bbs_ix']); //답변 데이터   
            $row['div_name'] = $this->getDivsName($row['bbs_div']);
            $row['isResponse'] = false; //답변 여부
            if (count($row['comments']) > 0) {
                $row['isResponse'] = true;
            }
        }
        return $row;
    }
}