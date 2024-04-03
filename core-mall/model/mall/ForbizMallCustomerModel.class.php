<?php

/**
 * Description of ForbizMallCustomerModel
 *
 * @author hoksi
 */
class ForbizMallCustomerModel extends ForbizModel
{
    protected $adminMode = false;
    protected $boardEname = null;
    protected $boardConfig = null;
    protected $boardStyle = null;
    protected $bmIx = null;
    protected $tableName = null;
    protected $tableComment = null;
    protected $userCode = null;
    protected $userName = null;
    protected $bbsDiv = null;
    protected $subBbsDivs = null;
    protected $bbsStatus = null;
    protected $writeTemplate = null;

    public function __construct()
    {
        parent::__construct();

        if (sess_val("admininfo", 'charger_ix') != "") {
            $this->adminMode = true;
            $this->userCode = sess_val("admininfo", 'charger_ix');
            $this->userName = "admin";
        } else {
            $this->adminMode = false;
            $this->userCode = sess_val('user', 'code');
            $this->userName = sess_val('user', 'name');
        }
    }

    public function setBoardConfig($boardEname)
    {
        $this->qb->select('*');
        if ($this->adminMode) {
            $this->qb->select('\'admin\' AS bbs_templet_dir');
        }

        $bbsConfig = $this->qb->from(TBL_BBS_MANAGE_CONFIG)
            ->where('board_ename', $boardEname)
            ->limit(1)
            ->exec()
            ->getRowArray();

        $this->bmIx = $bbsConfig['bm_ix'];
        $this->boardStyle = $bbsConfig['board_style'];
        $this->boardEname = $boardEname;
        $this->tableName = "bbs_" . $boardEname;
        $this->tableComment = "bbs_" . $boardEname . "_comment";

        if ($bbsConfig['board_style'] == "faq") {
            $this->writeTemplate = "faq_write.htm";
        } else {
            $this->writeTemplate = "bbs_write.htm";
        }

        if ($bbsConfig['board_category_use_yn'] == "Y") {
            $this->bbsDiv = $this->getDivInfo($this->bmIx, false, 1);
            $bbsConfig['bbsDiv'] = $this->bbsDiv;
        }

        $this->boardConfig = $bbsConfig;

        $this->bbsStatus = $this->qb->select("status_ix, bm_ix, status_name")
            ->from(TBL_BBS_MANAGE_STATUS)
            ->where('bm_ix', $this->bmIx)
            ->where('disp', 1)
            ->orderby('view_order', 'ASC')
            ->exec()
            ->getResultArray();
    }

    public function getBoardConfig()
    {
        $result = $this->boardConfig;
        $result['bbs_table_name'] = $this->tableName;
        $result['bbs_table_comment'] = $this->tableComment;
        $result['bbs_write_template'] = $this->writeTemplate;

        return $result;
    }


    public function getNoticeList($param)
    {
        if (intVal($this->boardConfig['board_max_cnt']) == 0) {
            $perPage = 10;
        } else {
            $perPage = $this->boardConfig['board_max_cnt'];
        }

        // 쿼리 캐시 시작
        $this->qb
            ->startCache()
            ->from($this->tableName);

        if (isset($param['bbsDiv'])&& $param['bbsDiv'] != '') {
            $this->qb->where('bbs_div', $param['bbsDiv']);
        }

        if (isset($param['sDate'])&& $param['sDate'] != '') {
            $this->qb->where("date(regdate) >=", $param['sDate']);
        }
        if (isset($param['eDate'])&& $param['eDate'] != '') {
            $this->qb->where("date(regdate) <=", $param['eDate']);
        }

        // Q&A 경우 처리상태
        if ($this->boardEname == 'qna') {
            $this->qb->select("(CASE WHEN status = '1' THEN '문의중' WHEN status = '2' THEN '처리중' WHEN status = '5' THEN '답변완료' END) as qna_status");
            $this->qb->select("( if (status = '5', '1', '') ) as complete_status");
            $this->qb->select("(CASE WHEN (bbs_etc4 = '' or bbs_etc4 is null) THEN '-' ELSE bbs_etc4 END) as oid");
            $this->qb->where('mem_ix', $this->userCode);
        }

        if (isset($param['searchText']) && $param['searchText'] != '') {
            if ($param['sType'] == 'sub') {
                $this->qb->like("bbs_subject", $param['searchText']);
            } else if ($param['sType'] == 'con') {
                $this->qb->like("bbs_contents", $param['searchText']);
            } else {
                $this->qb->groupStart();
                $this->qb->like("bbs_subject", $param['searchText']);
                $this->qb->orLike("bbs_contents", $param['searchText']);
                $this->qb->groupEnd();
            }
        }

        $this->qb->stopCache();

        $total = $this->qb->getCount();
        $paging = $this->qb->setTotalRows($total)->pagination($param['curPage'], $perPage);
        $limit = $perPage;
        $offset = $paging['offset'];

        $list = $this->qb
            ->select("bbs_ix, bbs_ix as idx, bbs_div, sub_bbs_div, bbs_subject, bbs_name, bbs_contents, bbs_hit, regdate", false)
            ->select("(CASE WHEN is_notice = 'Y' THEN 'Y' ELSE '' END) as is_notice")
            ->select("concat(bbs_div, '_', sub_bbs_div) as div_code")
            ->select("date_format(regdate,'%Y-%m-%d') as reg_date")
            ->orderby("is_notice", "DESC")
            ->orderby("regdate", "DESC")
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();

        $this->qb->flushCache();

        // 분류코드
        $divInfo = $this->getDivInfo($this->bmIx, true);
        if (count($list) > 0) {
            foreach ($list as $p => $v) {
                if (array_key_exists($v['bbs_div'], $divInfo)) {
                    $list[$p]['div_name'] = $divInfo[$v['bbs_div']];
                }
                if (array_key_exists($v['sub_bbs_div'], $divInfo)) {
                    $list[$p]['div_name'] .= "/" . $divInfo[$v['sub_bbs_div']];
                }

                // 말줄임 40자
                $list[$p]['short_subject'] = str_cut($v['bbs_subject'], 40);
                // 검색어 하이라이트 효과
                if (isset($param['searchText']) && $param['searchText'] != '') {
                    $list[$p]['short_subject'] = highlight($list[$p]['short_subject'], $param['searchText']);
                }
            }
        }


        // Q&A 게시판 최근답변일시 추가
        if ($this->boardEname == 'qna') {
            if (is_array($list)) {
                foreach ($list as $key => $val) {
                    $cmtInfo = $this->qb->select("*")
                        ->from($this->tableComment)
                        ->where('bbs_ix', $val['bbs_ix'])
                        ->orderBy('regdate', 'DESC')
                        ->limit('1')
                        ->exec()
                        ->getRowArray('0');

                    if ($cmtInfo['cmt_ix'] != '') {
                        $list[$key]['res_name'] = $cmtInfo['cmt_name'];
                        $list[$key]['res_content'] = $cmtInfo['cmt_contents'];
                        if (isset($cmtInfo['regdate'])) {
                            $list[$key]['res_date'] = $cmtInfo['regdate'];
                        } else {
                            $list[$key]['res_date'] = '-';
                        }
                    }
                }
            }
        }

        return [
            'total' => $total,
            'list' => $list,
            'paging' => $paging,
            'searchText' => $param['searchText']
        ];
    }

    public function getFaqList($curPage, $bbsIx, $divIx, $sText)
    {

        $perPage = intVal($this->boardConfig['board_max_cnt']) == 0 ? 10 : $this->boardConfig['board_max_cnt'];

        $this->qb->startCache()
            ->select("bbs_ix, bbs_div, '기타' as div_name, sub_bbs_div, bbs_q, bbs_a, bbs_contents_type, bbs_ix AS idx", false)
            ->select("date_format(regdate,'%Y-%m-%d') AS reg_date")
            ->from($this->tableName);

        if ($divIx > 0) {
            $this->qb->groupStart();
            $this->qb->where("bbs_div", $divIx);
            $this->qb->orwhere("sub_bbs_div", $divIx);
            $this->qb->groupEnd();
        }
        if ($bbsIx > 0) {
            $this->qb->where("bbs_ix", $bbsIx);
        }
        if ($sText != "") {
            $this->qb->groupStart();
            $this->qb->like("bbs_q", $sText);
            $this->qb->orlike("bbs_a", $sText);
            $this->qb->groupEnd();
        }

        $this->qb->stopCache();

        // paging
        $total = $this->qb->limit(1)->getCount();
        $paging = $this->qb->setTotalRows($total)->pagination($curPage, $perPage);
        $limit = $perPage;
        $offset = $paging['offset'];

        // list
        $list = $this->qb->orderby("is_best", "DESC")
            ->orderby("regdate", "DESC")
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();
        $this->qb->flushCache();

        // div
        $divInfo = $this->getDivInfo($this->boardConfig['bm_ix'], true);
        if (count($list) > 0) {
            foreach ($list as $p => $v) {
                if (array_key_exists($v['bbs_div'], $divInfo)) {
                    $list[$p]['div_name'] = $divInfo[$v['bbs_div']];
                }
                if (array_key_exists($v['sub_bbs_div'], $divInfo)) {
                    $list[$p]['div_name'] .= "/" . $divInfo[$v['sub_bbs_div']];
                }
                if (isset($list[$p]['div_name'])) {
                    $list[$p]['div_name'] = "[" . $list[$p]['div_name'] . "]";
                }

                // $list[$p]['bbs_a'] = nl2br($list[$p]['bbs_a']);
                $list[$p]['bbs_a'] = $list[$p]['bbs_a'];
            }
        }

        return [
            'total' => $total,
            'list' => $list,
            'paging' => $paging,
            'divIx' => $divIx,
            'sText' => $sText
        ];
    }


    public function getCustomerNotice($limit)
    {
        $result = $this->qb->select("bbs_ix")
            ->select("bbs_subject as notice_subject")
            ->select("date_format(regdate,'%Y-%m-%d') as reg_date")
            ->from($this->tableName)
            ->where("status", "1")
            // ->where("is_notice", "Y")
            ->orderBy("regdate", "DESC")
            ->limit($limit)
            ->exec()
            ->getResultArray();
        return $result;
    }
    
    public function getCustomerBestFaq($limit)
    {
        $this->qb->where('is_best', '1');
        return $this->getFaq($limit, 0);
    }
    
    public function getCustomerFaq($limit)
    {
        return $this->getFaq($limit, 0);
    }
    
    private function getFaq($limit, $start = 0)
    {
        $list = $this->qb->select("bbs_ix, bbs_div, sub_bbs_div, bbs_a, bbs_q")
            ->from($this->tableName)
            ->orderBy("regdate", "DESC")
            ->limit($limit)
            ->exec()
            ->getResultArray();

        $divInfo = $this->getDivInfo($this->boardConfig['bm_ix'], true);

        if (count($list) > 0) {
            foreach ($list as $p => $v) {

                if (array_key_exists($v['bbs_div'], $divInfo)) {
                    $list[$p]['div_name'] = $divInfo[$v['bbs_div']];
                    $list[$p]['div_ix'] = $v['bbs_div'];
                }

                if (array_key_exists($v['sub_bbs_div'], $divInfo)) {
                    $list[$p]['div_name'] .= "/" . $divInfo[$v['sub_bbs_div']];
                    $list[$p]['div_ix'] = $v['sub_bbs_div'];
                }

                if(isset($list[$p]['div_name'])){
                    $list[$p]['div_name'] = "[" . $list[$p]['div_name'] . "]";
                }

            }
        }

        return $list;
    }

    public function getQnaDetail($bbsIx, $table = '')
    {
        if($table){
            $table = $table;
            $tableComment = $table."_comment";
        }else{
            $table = $this->tableName;
            $tableComment = $this->tableComment;
        }
        $qnaInfo = $this->qb->select("*")
            ->select("concat('" . DATA_ROOT . "/bbs_data/qna/', '" . sess_val('user', 'id') . "/') as bbs_filepath")
            ->from($table)
            ->where("bbs_ix", $bbsIx)
            ->limit("1")
            ->exec()
            ->getRowArray('0');

        $cmtInfo = $this->qb->select("*")
            ->from($tableComment)
            ->where("bbs_ix", $bbsIx)
            ->orderby('regdate', 'DESC')
            ->exec()
            ->getResultArray();

        $result['qInfo'] = $qnaInfo;
        $result['qInfo']['cInfo'] = $cmtInfo;

        if($table != '') {

            if (($qnaInfo['bbs_etc4'] ?? '') != "") {
                /* @var $orderModel CustomMallOrderModel */
                $orderModel = $this->import('model.mall.order');
                $orderInfo = $orderModel->getOderDetailItems($qnaInfo['bbs_etc4']);
                $result['qInfo']['oInfo'] = $orderInfo[$qnaInfo['bbs_etc4']];
            }
        }

        return $result;
    }

    public function getDivInfo($bmIx = null, $tag = false, $type = null)
    {
        if (is_null($bmIx) || $bmIx == '') {
            $bmIx = $this->boardConfig['bm_ix'];
        }

        $result = array();
        $dInfo = $this->qb->select("div_ix, div_name")
            ->from(TBL_BBS_MANAGE_DIV)
            ->where("bm_ix", $bmIx)
            ->where("disp", "1")
            ->orderBy("view_order", "ASC")
            ->exec()
            ->getResultArray();

        if ($type == '1') {
            return $dInfo;
        }

        if (count($dInfo) > 0) {
            foreach ($dInfo as $p => $v) {
                if ($tag) {
                    $result[$v['div_ix']] = str_replace('[', '', str_replace(']', '', $v['div_name']));
                } else {
                    $result[$v['div_ix']] = $v['div_name'];
                }
            }
        }
        return $result;
    }

    public function getArticle($bbs_ix)
    {

        $this->qb->set('bbs_hit', 'bbs_hit +1', false)
            ->where('bbs_ix', $bbs_ix)
            ->update($this->tableName)
            ->exec();

        $this->qb->select("*")
            ->select("bbs_name AS writer")
            ->select("DATE_FORMAT(regdate, '%Y-%m-%d') AS reg_date")
            ->select("CONCAT(SUBSTR(bbs_name,1,1),'*',SUBSTR(bbs_name,3)) AS bbs_name")
            ->select("CASE WHEN regdate > DATE_SUB(now(), interval " . $this->boardConfig['design_new_priod'] . " HOUR) THEN 1 ELSE 0 END as new")
            ->from($this->tableName)
            ->where("bbs_ix", $bbs_ix)
            ->where("status", "1");

        $result = $this->qb->limit('1')
            ->exec()
            ->getRowArray();


        // (이전 레코드)
        $result['before_record'] = $this->qb->select("bbs_pass, mem_ix, bbs_ix, bbs_subject, bbs_hidden, bbs_re_cnt, bbs_hit, regdate, date_format(regdate, '%Y-%m-%d') reg_date, bbs_etc1, bbs_etc2, bbs_rec_cnt")
            ->select("bbs_name AS writer")
            ->select("CONCAT(SUBSTR(bbs_name,1,1),'*',SUBSTR(bbs_name,3)) AS bbs_name")
            ->select("CONCAT('/customer/" . $this->boardConfig['board_ename'] . "/read/', bbs_ix) AS link")
            ->select("CASE WHEN regdate > DATE_SUB(now(), interval " . $this->boardConfig['design_new_priod'] . " HOUR) THEN 1 ELSE 0 END AS new")
            ->from($this->tableName)
            ->where('bbs_ix <', $bbs_ix)
            ->where('bbs_ix_level', 0)
            ->orderby('bbs_ix', 'DESC')
            ->limit(1)
            ->exec()
            ->getResultArray();


        // (다음 레코드)
        $result['next_record'] = $this->qb->select("bbs_pass, mem_ix, bbs_ix, bbs_subject, bbs_hidden, bbs_re_cnt, bbs_hit, regdate, date_format(regdate, '%Y-%m-%d') reg_date, bbs_etc1, bbs_etc2, bbs_rec_cnt")
            ->select("bbs_name AS writer")
            ->select("CONCAT(SUBSTR(bbs_name,1,1), '*', SUBSTR(bbs_name,3)) AS bbs_name")
            ->select("CONCAT('/customer/" . $this->boardConfig['board_ename'] . "/read/', bbs_ix) AS link")
            ->select("CASE WHEN regdate > DATE_SUB(now(), interval " . $this->boardConfig['design_new_priod'] . " HOUR) THEN 1 ELSE 0 END AS new")
            ->from($this->tableName)
            ->where('bbs_ix >', $bbs_ix)
            ->where('bbs_ix_level', 0)
            ->orderby('bbs_ix', 'ASC')
            ->limit(1)
            ->exec()
            ->getResultArray();


        // (해당 댓글)
        $result['comment_loop'] = $this->qb->select("*")
            ->from($this->tableComment)
            ->where('bbs_ix', $bbs_ix)
            ->orderby('regdate', 'ASC')
            ->exec()
            ->getResultArray();

        $result['board'] = $this->boardEname;
        $result['bbs_table_name'] = $this->tableName;
        $result['bbs_template_name'] = "bbs_read.htm";

        return $result;
    }

    public function registerArticle($param)
    {

        $this->setBoardConfig($param['board']);

        // 첨부파일 경로 (미정)
        $uploadPath = MALL_DATA_PATH . '/bbs_data/qna/' . sess_val('user', 'id');

        for ($i = 1; $i <= 3; $i++) {
            if (isset($_FILES['bbsFile' . $i]['name'])) {

                $temp = explode(".", $_FILES['bbsFile' . $i]["name"]);
                $newfilename = md5($_FILES['bbsFile' . $i]["name"].microtime()) . '.' . end($temp);
                $_FILES['bbsFile' . $i]['name'] = $newfilename;

                $resultUpload = form_file_upload('bbsFile' . $i, $uploadPath);
                if (!empty($resultUpload['file_name'])) {
                    $this->qb->set('bbs_file_' . $i, $resultUpload['file_name']);
                    $result['file'][$i] = "ok";
                } else {
                    $result['file'][$i] = "error";
                }
            }
        }

        $result['url'] = '/mypage/myInquiry';
        $result['ins'] = $this->qb
            ->set('bbs_div', $param['bbsDiv'])
            ->set('sub_bbs_div', $param['subBbsDiv'])
            ->set('mem_ix', sess_val('user', 'code'))
            ->set('bbs_name', sess_val('user', 'name'))
            ->set('bbs_email', $param['bbsEmail'])
            ->set('bbs_subject', $param['subject'])
            ->set('bbs_contents', $param['contents'])
            ->set('bbs_etc1', $param['hp'])
            ->set('bbs_etc4', $param['bbsEtc4'])
            ->set('ip_addr', $_SERVER['REMOTE_ADDR'])
            ->set('status', '1')
            ->set('regdate', 'now()', false)
            ->insert($this->tableName)
            ->exec();

        return $result;
    }

    public function deleteArticle($bbs_ix)
    {
        $result = $this->qb->delete($this->tableName, array("bbs_ix" => $bbs_ix), "1")->exec();
        return $result;
    }
}