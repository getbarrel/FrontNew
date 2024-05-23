<?php

/**
 * Description of CustomMallCustomerModel
 * @author hoksi
 */
class CustomMallCustomerModel extends ForbizMallCustomerModel
{

    protected $imageServer = 'https://image2.getbarrel.com';

    public function __construct()
    {
        parent::__construct();

        $this->adminMode = false;
        $this->userCode = sess_val('user', 'code');
        $this->userName = sess_val('user', 'name');
    }

    public function setTableName($tableName){
        $this->tableName = $tableName;
    }

    public function getDashboardData($div_ix): array
    {
        $ret = [
            'div_ix' => $div_ix,
            'div_info' => '',
            'bbs_data' => ''
        ];

        $ret['opening_time'] = ForbizConfig::getCompanyInfo('opening_time');
        $ret['cs_phone'] = ForbizConfig::getCompanyInfo('cs_phone');

        return $ret;
    }

    public function getOperationInfo()
    {

        $result['opening_time'] = ForbizConfig::getCompanyInfo('opening_time');
        $result['cs_phone'] = ForbizConfig::getCompanyInfo('cs_phone');

        return $result;
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
            ->select("concat('/data/barrel_data/bbs_data/qna/', '" . sess_val('user', 'id') . "/') as bbs_filepath")
            ->select("date_format(regdate,'%Y-%m-%d') as regdate")
            ->select($this->qb->startSubQuery('div_name')
                ->select('div_name')
                ->from(TBL_BBS_MANAGE_DIV)
                ->where('bbs_div', TBL_BBS_MANAGE_DIV.'.div_ix', false)
                ->endSubQuery(), false)
            ->from($table)
            ->where("bbs_ix", $bbsIx)
            ->limit("1")
            ->exec()
            ->getRowArray('0');

        $cmtInfo = $this->qb->select("*")
            ->select("date_format(regdate,'%Y-%m-%d') as resdate")
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

    public function getCity() {

        $list = $this->qb->select('city_code, count(city_code) as store_cnt')
            ->from('barrel_store_info')
            ->where('store_idx IS NOT NULL')
            ->where('view_yn', 'Y')
            ->groupBy('city_code')
            ->orderBy('store_idx')
            ->exec()
            ->getResultArray();

        $total = count($list);

        return [
            'total' => $total,
            'list' => $list
        ];

    }

    public function getCityCode() {

        $list = $this->qb->select('ac.city_code, ac.city_name, count(bsi.city_code) as store_cnt')
            ->from('barrel_city_code as ac')
            ->join('barrel_store_info as bsi', 'on ac.city_name = bsi.city_code')
            ->where('store_idx IS NOT NULL')
            ->groupBy('ac.city_code')
            ->exec()
            ->getResultArray();

        $total = count($list);

        return [
            'total' => $total,
            'list' => $list
        ];

    }

    public function getArea($city) {

        $list = $this->qb->select('area_code')
            ->from('barrel_store_info')
            ->where('city_code', $city)
            ->where('view_yn', 'Y')
            ->groupBy('area_code')
            ->orderBy('store_idx')
            ->exec()
            ->getResultArray();

        $total = count($list);

        return [
            'total' => $total,
            'list' => $list
        ];

    }

    public function getStoreList($page = 1, $max = 10, $city = "", $area = "", $name = "", $id = "") {

        $this->qb->select('*')
            //->select('CASE WHEN store_idx=90 THEN 0 END AS display')
            ->select('if(store_idx=90,0,1) AS display')
            ->select('if(store_idx=163,0,1) AS display2')
            //->select('(if store_idx=90 then 0 elseif store_idx=163 then 1 else 0 end if) AS display')
            ->from('barrel_store_info');

        if(!empty($city)) {
            $this->qb->where('city_code', $city);
        }

        if(!empty($id)) {
            $this->qb->where('store_code', $id);
        }

        if(!empty($area)) {
            $this->qb->where('area_code', $area);
        }

        if(!empty($name)) {
            $this->qb->like('store_name', $name);
        }

        $list = $this->qb
            ->where('view_yn','Y')
            ->orderby('display','ASC')
            ->orderby('display2','ASC')
            ->orderby('store_idx','ASC')
            ->exec()->getResultArray();

        $total = count($list);

        for($i=0; $i<$total; $i++){
            $list[$i]['src'][] = $this->imageServer."/socal/store/".$list[$i]['store_code']."/store_img_1.jpg";
            $list[$i]['src'][] = $this->imageServer."/socal/store/".$list[$i]['store_code']."/store_img_2.jpg";
            $list[$i]['src'][] = $this->imageServer."/socal/store/".$list[$i]['store_code']."/store_img_3.jpg";

            $list[$i]['store_tel'] = $list[$i]['store_tel'] ? $list[$i]['store_tel'] : '';
            $list[$i]['open_time2'] = $list[$i]['open_time2'] ? $list[$i]['open_time2'] : '';
            $list[$i]['open_time3'] = $list[$i]['open_time3'] ? $list[$i]['open_time3'] : '';

            $list[$i]['bus'] = nl2br($list[$i]['bus']);
            $list[$i]['subway'] = nl2br($list[$i]['subway']);
            $list[$i]['json'] = json_encode($list[$i]);
        }

        $paging = $this->qb->setTotalRows($total)->pagination($page, $max);

        return [
            'total' => $total,
            'list' => $list,
            'basic' => $basic,
            'paging' => $paging
        ];
    }

    public function getStoreInfo($store_code) {
        $info = $this->qb->select('*')
            ->from('barrel_store_info')
            ->groupStart()
            ->where('store_code', $store_code)
            ->orWhere('store_idx', $store_code)
            ->groupEnd()
            ->exec()->getResultArray();

		$info[0]['src'] = "<div class='swiper-slide'><img src='".$this->imageServer."/socal/store/".$info[0]['store_code']."/store_img_1.jpg' alt='' /></div><div class='swiper-slide'><img src='".$this->imageServer."/socal/store/".$info[0]['store_code']."/store_img_2.jpg' alt='' /></div><div class='swiper-slide'><img src='".$this->imageServer."/socal/store/".$info[0]['store_code']."/store_img_3.jpg' alt='' /></div>";
		$info[0]['srcM'] = "<div class='swiper-slide'><img src='".$this->imageServer."/socal/store/".$info[0]['store_code']."/store-info-bg_1.jpg' alt='' /></div><div class='swiper-slide'><img src='".$this->imageServer."/socal/store/".$info[0]['store_code']."/store-info-bg_2.jpg' alt='' /></div><div class='swiper-slide'><img src='".$this->imageServer."/socal/store/".$info[0]['store_code']."/store-info-bg_3.jpg' alt='' /></div>";

        return $info;
    }

    public function getCustomerNotice($limit)
    {
        $result = $this->qb->select("bbs_ix")
            ->select("is_notice")
            ->select("bbs_subject as notice_subject")
            ->select("date_format(regdate,'%Y-%m-%d') as reg_date")
            ->from($this->tableName)
            ->where("status", "1")
            ->where("bbs_hidden","0")
            ->orderBy("regdate", "DESC")
            ->limit($limit)
            ->exec()
            ->getResultArray();
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

        if (isset($param['bbsDiv']) && $param['bbsDiv'] != "") {
            $this->qb->where('bbs_div', $param['bbsDiv']);
        }
        if (isset($param['state']) && $param['state'] != "") {
			$this->qb->where('status', $param['state']);
        }

        if (isset($param['sDate']) && $param['sDate'] != "") {
            $this->qb->where("date(regdate) >=", $param['sDate']);
        }
        if (isset($param['eDate']) && $param['eDate'] != "") {
            $this->qb->where("date(regdate) <=", $param['eDate']);
        }
        if (isset($param['qType']) && !empty($param['qType'])) {
            $this->qb->where('bbs_div', $param['qType']);
        }

        if(!isset($param['searchText'])){
            $param['searchText'] = '';
        }

        if(isset($param['status']) && !empty($param['status'])){
            $this->qb->whereIn('status', $param['status']);
        }

        // Q&A 경우 처리상태
        if ($this->boardEname == 'qna' || $this->boardEname == 'qna_global') {
            //$this->qb->select("(CASE WHEN status = '1' THEN '문의중' WHEN status = '2' THEN '처리중' WHEN status = '5' THEN '답변완료' END) as qna_status");
            $this->qb->select("( if (status = '5', '1', '') ) as complete_status");
            $this->qb->select("(CASE WHEN (bbs_etc4 = '' or bbs_etc4 is null) THEN '-' ELSE bbs_etc4 END) as oid");
            $this->qb->select('status');
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
        if(is_mobile()){
            $paging = $this->qb->setTotalRows($total)->pagination($param['curPage'], $perPage,5);
        }else{
            $paging = $this->qb->setTotalRows($total)->pagination($param['curPage'], $perPage);
        }

        $limit = $perPage;
        $offset = $paging['offset'];

        $list = $this->qb
            ->select("bbs_ix, bbs_ix as idx, format(bbs_ix,0) AS no, bbs_div, sub_bbs_div, bbs_subject, bbs_name, bbs_contents, bbs_hit, regdate,bbs_hidden,mem_ix", false)
            ->select("(CASE WHEN is_notice = 'Y' THEN 'Y' ELSE '' END) as is_notice")
            ->select("concat(bbs_div, '_', sub_bbs_div) as div_code")
            ->select("date_format(regdate,'%Y-%m-%d') as reg_date")
            ->select("bbs_file_1")
            ->select("bbs_file_2")
            ->select("bbs_file_3")
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

                //qna 처리상태 데이터 획득 방식 변경
                $list[$p]['qna_status'] = "";

                if ($this->boardEname == 'qna' || $this->boardEname == 'qna_global') {

                    if(isset($v['status'])){
                        $manage_status = $this->qb
                            ->select('status_name')
                            ->from(TBL_BBS_MANAGE_STATUS)
                            ->where('status_ix',$v['status'])
                            ->exec()->getRowArray();
                        $list[$p]['qna_status'] = $manage_status['status_name'];
                    }

                }
                //작성자 ** 표기
                if($v['bbs_name']){
                    $list[$p]['short_bbs_name'] = mb_substr($v['bbs_name'],0,1, 'UTF-8')."**";
                }

                $list[$p]['isSameUser'] = false; //동일 작성자 여부
                if (!empty($this->userInfo->code) && $v['mem_ix'] == $this->userInfo->code) {
                    $list[$p]['isSameUser'] = true;
                }


                // 말줄임 40자
                $list[$p]['short_subject'] = str_cut($v['bbs_subject'], 40);
                // 검색어 하이라이트 효과
                if (isset($param['searchText']) && $param['searchText'] != '') {
                    $list[$p]['short_subject'] = highlight($list[$p]['short_subject'], $param['searchText']);
                }

                $checkBbsFileExist = false;
                if(!empty($v['bbs_file_1'])){
                    $filePath = DOCUMENT_ROOT.DATA_ROOT."/bbs_data/".$this->tableName."/".$v['bbs_ix']."/".$v['bbs_file_1'];
                    if(!file_exists($filePath)){
                        unset($list[$p]['bbs_file_1']);
                    }else{
                        $checkBbsFileExist = true;
                    }
                }
                if(!empty($v['bbs_file_2'])){
                    $filePath = DOCUMENT_ROOT.DATA_ROOT."/bbs_data/".$this->tableName."/".$v['bbs_ix']."/".$v['bbs_file_2'];
                    if(!file_exists($filePath)){
                        unset($list[$p]['bbs_file_2']);
                    }else{
                        $checkBbsFileExist = true;
                    }
                }
                if(!empty($v['bbs_file_3'])){
                    $filePath = DOCUMENT_ROOT.DATA_ROOT."/bbs_data/".$this->tableName."/".$v['bbs_ix']."/".$v['bbs_file_3'];
                    if(!file_exists($filePath)){
                        unset($list[$p]['bbs_file_3']);
                    }else{
                        $checkBbsFileExist = true;
                    }
                }
                $list[$p]['bbs_file_exist'] = $checkBbsFileExist;
            }
        }


        // Q&A 게시판 최근답변일시 추가
        if ($this->boardEname == 'qna' || $this->boardEname == 'qna_global' ) {
            if (is_array($list)) {
                foreach ($list as $key => $val) {
                    $cmtInfo = $this->qb->select("*")
                        ->select("date_format(regdate,'%Y-%m-%d') as regdate")
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

        //comment count

        if (is_array($list)) {
            foreach ($list as $key => $val) {
                $countInfo = $this->qb->select("*")
                    ->from($this->tableComment)
                    ->where('bbs_ix', $val['bbs_ix'])
                    ->getCount();
                if($countInfo > 0){
                    $list[$key]['res_count'] = $countInfo;
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

    public function noticeList($param)
    {
        if (intVal($this->boardConfig['board_max_cnt']) == 0) {
            $perPage = 10;
        } else {
            $perPage = $this->boardConfig['board_max_cnt'];
        }

        $limit = $perPage;
            // 유효한 공지 리스트
        $this->qb->select("bbs_ix, bbs_ix AS idx, bbs_subject, bbs_contents, bbs_file_1, regdate, DATE_FORMAT(regdate,'%Y-%m-%d') AS reg_date, '' AS is_notice, bbs_hit")
            ->from($this->tableName)
            ->where("status", 1)
			->where("bbs_hidden", 0)
            ->where("is_notice !=", 'Y');
        $total2 = $this->qb->getCount();


        $total = $total2;

        if(is_mobile()){
            $paging = $this->qb->setTotalRows($total)->pagination($param['curPage'], $perPage,5);
        }else{
            $paging = $this->qb->setTotalRows($total)->pagination($param['curPage'], $perPage);
        }

        $offset = $paging['offset'];



        // 상단 공지 리스트 별도
        $list1 = $this->qb->select("bbs_ix, bbs_ix AS idx, bbs_subject, bbs_contents, bbs_file_1, regdate, DATE_FORMAT(regdate,'%Y-%m-%d') AS reg_date, 'Y' AS is_notice, bbs_hit")
        ->from($this->tableName)
        ->where("is_notice", 'Y')
        ->where("status", 1)
		->where("bbs_hidden", 0)
        ->orderby("regdate", "DESC")
        ->exec()->getResultArray();


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

        if ($param['divIx'] > 0) {
            $this->qb->groupStart();
            $this->qb->where("bbs_div", $param['divIx']);
            $this->qb->orwhere("sub_bbs_div", $param['divIx']);
            $this->qb->groupEnd();
        }

        // 유효한 공지 리스트
        $list2 = $this->qb->select("bbs_ix, bbs_ix AS idx, bbs_subject, bbs_contents, bbs_file_1, regdate, DATE_FORMAT(regdate,'%Y-%m-%d') AS reg_date, '' AS is_notice, bbs_hit")
        ->from($this->tableName)
        ->where("status", 1)
		->where("bbs_hidden", 0)
        ->where("is_notice !=", 'Y')
        ->orderby("regdate", "DESC")
        ->limit($limit, $offset)
        ->exec()->getResultArray();

        $list = array_merge($list1, $list2);
        $total = count($list);

        foreach($list as $p => $v) {
            $checkBbsFileExist = false;
            if(!empty($v['bbs_file_1'])){
                $filePath = DOCUMENT_ROOT.DATA_ROOT."/bbs_data/".$this->tableName."/".$v['bbs_ix']."/".$v['bbs_file_1'];
                if(!file_exists($filePath)){
                    unset($list[$p]['bbs_file_1']);
                }else{
                    $checkBbsFileExist = true;
                }
            }
            if(!empty($v['bbs_file_2'])){
                $filePath = DOCUMENT_ROOT.DATA_ROOT."/bbs_data/".$this->tableName."/".$v['bbs_ix']."/".$v['bbs_file_2'];
                if(!file_exists($filePath)){
                    unset($list[$p]['bbs_file_2']);
                }else{
                    $checkBbsFileExist = true;
                }
            }
            if(!empty($v['bbs_file_3'])){
                $filePath = DOCUMENT_ROOT.DATA_ROOT."/bbs_data/".$this->tableName."/".$v['bbs_ix']."/".$v['bbs_file_3'];
                if(!file_exists($filePath)){
                    unset($list[$p]['bbs_file_3']);
                }else{
                    $checkBbsFileExist = true;
                }
            }
            $list[$p]['bbs_file_exist'] = $checkBbsFileExist;
        }


        return [
            'total' => $total,
            'list' => $list,
            'paging' => $paging
        ];
    }


    public function getNoticeMixedList($param)
    {
        if (intVal($this->boardConfig['board_max_cnt']) == 0) {
            $perPage = 10;
        } else {
            $perPage = $this->boardConfig['board_max_cnt'];
        }

        $limit = $perPage;

        // 상단 공지 리스트 별도
        $list1 = $this->qb->select("bbs_ix, bbs_ix AS idx, bbs_subject, bbs_contents, DATE_FORMAT(regdate,'%Y-%m-%d') AS reg_date, 'Y' AS is_notice, bbs_hit")
        ->from($this->tableName)
        ->where("is_notice", 'Y')
        ->where("status", 1)
        ->where("bbs_hidden", 0)
        ->orderby("regdate", "DESC")

        ->exec()->getResultArray();


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

        if ($param['divIx'] > 0) {
            $this->qb->groupStart();
            $this->qb->where("bbs_div", $param['divIx']);
            $this->qb->orwhere("sub_bbs_div", $param['divIx']);
            $this->qb->groupEnd();
        }

        // 유효한 공지 리스트
        $list2 = $this->qb->select("bbs_ix, bbs_ix AS idx, bbs_subject, bbs_contents, DATE_FORMAT(regdate,'%Y-%m-%d') AS reg_date, '' AS is_notice, bbs_hit")
        ->from($this->tableName)
        ->where("status", 1)
        ->where("bbs_hidden", 0)
        ->orderby("regdate", "DESC")
        ->exec()->getResultArray();
        $list = array_merge($list1, $list2);

        $total = count($list);
        if (count($list) > 0) {
            foreach ($list as $p => $v) {
                // 말줄임 40자
               $list[$p]['short_subject'] = str_cut($v['bbs_subject'], 40);
            }
        }

        // array 페이징
        if(intval($param['curPage']) == '0'){
            $start ='0';
        }else{
            $start = ($param['curPage']-1) * $perPage;
        }

        $finalList = array_slice($list, $start, $perPage);

        $paging = $this->qb->setTotalRows($total)->pagination($param['curPage'], $perPage);
        $offset = $paging['offset'];

        return [
            'noticeTotal' => count($list1),
            'total' => $total,
            'list' => $finalList,
            'paging' => $paging
        ];
    }

    public function registerTeacherMember($param)
    {

        $this->setBoardConfig($param['board']);

		if($this->tableName == "bbs_teacher") {
			$result['url'] = '/brand/teacherMember';
			$this->qb
				->set('bbs_div', $param['bbsDiv'])
				->set('mem_ix', sess_val('user', 'code'))
				->set('bbs_name', sess_val('user', 'name'))
				->set('bbs_email', sess_val('user', 'mail'))
				->set('bbs_subject', $param['subject'])
				->set('bbs_contents', $param['contents'])
				->set('bbs_etc1', $param['bbsEtc1'])
				->set('ip_addr', $_SERVER['REMOTE_ADDR'])
				->set('bbs_hidden', $param['isHidden'])
				->set('status', '1')
				->set('regdate', 'now()', false);
			if($param['uType'] == 'U') {
				$result['ins'] = $this->qb->where('bbs_ix', $param['bbsIx'])->update($this->tableName)->exec();
			}else {
				$result['ins'] = $this->qb->insert($this->tableName)->exec();
			}


			// 첨부파일 경로 (미정)
			$uploadPath = MALL_DATA_PATH . '/bbs_data/'.$this->tableName.'/' . str_pad($result['ins'], 8, '0', STR_PAD_LEFT);

			for ($i = 1; $i <= 3; $i++) {
				if (isset($_FILES['bbsFile' . $i]['name'])) {

					$temp = explode(".", $_FILES['bbsFile' . $i]["name"]);
					$newfilename = md5($_FILES['bbsFile' . $i]["name"].microtime()) . '.' . end($temp);
					$_FILES['bbsFile' . $i]['name'] = $newfilename;

					$resultUpload = form_file_upload('bbsFile' . $i, $uploadPath);
					if (!empty($resultUpload['file_name'])) {
						$this->qb->update($this->tableName)
						->set('bbs_file_' . $i, $resultUpload['file_name'])
						->where('bbs_ix',$result['ins'])->exec();
						$result['file'][$i] = "ok";
					} else {
						$result['file'][$i] = "error";
					}
				}
			}
		} else {
		}

        return $result;
    }

    public function registerArticle($param)
    {

        $this->setBoardConfig($param['board']);

        // 첨부파일 경로 (미정)
        $uploadPath = MALL_DATA_PATH . '/bbs_data/qna/' . sess_val('user', 'id');

        for ($i = 1; $i <= 4; $i++) {
            if (isset($_FILES['bbsFile' . $i]['name'])) {

                $temp = explode(".", $_FILES['bbsFile' . $i]["name"]);
                $newfilename = md5($_FILES['bbsFile' . $i]["name"].microtime()) . '.' . end($temp);
                $_FILES['bbsFile' . $i]['name'] = $newfilename;

                $resultUpload = form_file_upload('bbsFile' . $i, $uploadPath,false,'20480');
                if (!empty($resultUpload['file_name'])) {
                    $this->qb->set('bbs_file_' . $i, $resultUpload['file_name']);
                    $result['file'][$i] = "ok";
                } else {
                    $result['file'][$i] = "error";
                }
            }
        }

        $result['url'] = '/mypage/myInquiry';
        if(BASIC_LANGUAGE == 'korean'){
            $staus = '1';
        }else{
            $staus = '19';
        }
        $this->qb
            ->set('bbs_div', $param['bbsDiv'])
            ->set('sub_bbs_div', $param['subBbsDiv'])
            ->set('mem_ix', sess_val('user', 'code'))
            ->set('bbs_name', sess_val('user', 'name'))
            ->set('bbs_email', $param['bbsEmail'])
            ->set('bbs_subject', $param['subject'])
            ->set('bbs_contents', $param['contents'])
            ->set('bbs_etc1', $param['hp'] ?? '')
            ->set('bbs_etc2', $param['notifyEmail'])
            ->set('bbs_etc3', $param['notifyHp'])
            ->set('bbs_etc4', $param['bbsEtc4'])
            ->set('ip_addr', $_SERVER['REMOTE_ADDR'])
            ->set('status', $staus)
            ->set('regdate', 'now()', false);
        if($param['uType'] == 'U') {
            $result['ins'] = $this->qb->where('bbs_ix', $param['bbsIx'])->update($this->tableName)->exec();
        }else {
            $result['ins'] = $this->qb->insert($this->tableName)->exec();
        }

        return $result;
    }

    public function deleteArticle($bbs_ix)
    {
        $result = $this->qb->delete('bbs_'.$this->tableName, array("bbs_ix" => $bbs_ix, "mem_ix" => $this->userCode), "1")->exec();
        return $result;
    }


    /*
     * 재무정보
     * 재무상태표/손익계산서 각 1부 출력 처리
     */
    public function getFinanceInfo()
    {
        $result = [];

        // 분류코드
        $divInfo = $this->getDivInfo($this->bmIx, true);
        $i=0;
        foreach ($divInfo as $p => $v) {
            $data = $this->qb
                ->select("bbs_ix, bbs_div, bbs_subject, bbs_name, bbs_contents, regdate", false)
                ->select("date_format(regdate,'%Y-%m-%d') as reg_date")
                ->from($this->tableName)
                ->where("status", 1)
                ->where("bbs_div", $p)
                ->orderby("regdate", "DESC")
                ->limit(1)
                ->exec()
                ->getRowArray(0);

            if(count($data) > 0){
                $result[$i] = $data;
                $result[$i]['div_name'] = $v;
            }
            $i++;
        }

        return $result;
    }


    public function getCorporateIrArticle($bbs_ix)
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
            ->select("CONCAT('/corporateIR/IRResources/read/', bbs_ix) AS link")
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
            ->select("CONCAT('/corporateIR/IRResources/read/', bbs_ix) AS link")
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
            ->select($this->qb->startSubQuery('div_name')
                ->select('div_name')
                ->from(TBL_BBS_MANAGE_DIV)
                ->where('bbs_div', TBL_BBS_MANAGE_DIV.'.div_ix', false)
                ->endSubQuery(), false)
            ->from($this->tableName)
            ->where("bbs_ix", $bbs_ix)
            ->where("status", "1");

        $result = $this->qb->limit('1')
            ->exec()
            ->getRowArray();
        if($result){

            if($this->boardConfig['board_ename'] == "Find_Prescription_Swimming_Goggles_Store"){
                $board_ename = "waterscape";
            }else{
                $board_ename = $this->boardConfig['board_ename'];
            }

            // (이전 레코드)
            $result['before_record'] = $this->qb->select("bbs_pass, mem_ix, bbs_ix, bbs_subject, bbs_hidden, bbs_re_cnt, bbs_hit, regdate, date_format(regdate, '%Y-%m-%d') reg_date, bbs_etc1, bbs_etc2, bbs_rec_cnt")
                ->select("bbs_name AS writer")
                ->select("CONCAT(SUBSTR(bbs_name,1,1),'*',SUBSTR(bbs_name,3)) AS bbs_name")
                ->select("CONCAT('/customer/" . $board_ename . "/read/', bbs_ix) AS link")
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
                ->select("CONCAT('/customer/" . $board_ename . "/read/', bbs_ix) AS link")
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
        if(is_mobile()){
            $paging = $this->qb->setTotalRows($total)->pagination($curPage, $perPage,5);
        }else{
            $paging = $this->qb->setTotalRows($total)->pagination($curPage, $perPage);
        }

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

    public function getBbsStatus(){
        return $this->bbsStatus;
    }
}