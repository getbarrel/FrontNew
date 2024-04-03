<?php

/**
 * Description of FobizMallMypageModel
 *
 * @author hoksi
 */
class ForbizMallProductReviewModel extends ForbizModel
{
    protected $userCode = "";
    protected $config;

    public function __construct()
    {
        parent::__construct();

        $this->userCode = $this->userInfo->code;
        $this->config   = ForbizConfig::getSharedMemory("use_after"); //후기 설정 출력
    }

    public function getConfig()
    {
        return $this->config;
    }

    /**
     * 후기 설정에 평점 사용여부가 포함되어있음. 해당 설정에 따라 평점 정보 달라짐.
     * @param string $type
     * @return
     */
    public function getAverageColumn($type = '')
    {
        $avg_column = '0';

        if ($this->config['use_valuation_goods'] == 'Y' && $this->config['use_valuation_delivery'] == 'Y') {
            $avg_column = '(valuation_goods+valuation_delivery)/2';
        } else if ($this->config['use_valuation_goods'] == 'Y') {
            $avg_column = 'valuation_goods';
        } else if ($this->config['use_valuation_delivery'] == 'Y') {
            $avg_column = 'valuation_delivery';
        }

        if ($type == 'avg') { //총 평균값
            return $this->qb
                    ->selectAvg($avg_column, 'avg')
                    ->selectAvg('valuation_goods')
                    ->selectAvg('valuation_delivery');
        } else {
            return $this->qb
                    ->select('round('.$avg_column.', 1) as avg')
                    ->select('valuation_goods')
                    ->select('valuation_delivery')
                    ->select('(round('.$avg_column.', 1)*20) as avg_pct')
                    ->select('(valuation_goods*20) as valuation_goods_pct')
                    ->select('(valuation_delivery*20) as valuation_delivery_pct');
        }
    }

    /**
     * 평균값 구하기. Pct는 퍼센트의 약자.
     * @param string $id
     * @return array
     */
    public function getAverage($id='')
    {
        if($id){
            $this->qb
            ->where('pid', $id);
        }

        $data = $this->getAverageColumn('avg')
            ->from(TBL_SHOP_PRODUCT_AFTER)
            ->exec()
            ->getRowArray();

        $avgs = array('avg' => round($data['avg'], 1),
            'avgPct' => round($data['avg'], 1) * 20,
            'goodsAvg' => round($data['valuation_goods'], 1),
            'goodsAvgPct' => round($data['valuation_goods'], 1) * 20,
            'deliveryAvg' => round($data['valuation_delivery'], 1),
            'deliveryAvgPct' => round($data['valuation_delivery'], 1) * 20
        );
        return $avgs;
    }

    /**
     * 후기 개수 구하기
     * @param string $id
     * @return array
     */
    public function getCount($id='')
    {
        if($id){
            $this->qb
                ->where('pid', $id);
        }

        $premiumReview = $this->qb
            ->select('bbs_ix')
            ->from(TBL_SHOP_PRODUCT_AFTER)

            ->where('bbs_div', 1)
            ->exec()
            ->getResultArray();

        if($id){
            $this->qb
                ->where('pid', $id);
        }

        $review = $this->qb
            ->select('bbs_ix')
            ->from(TBL_SHOP_PRODUCT_AFTER)
            ->where('bbs_div', 2)
            ->exec()
            ->getResultArray();

        $total = array('total' => count($premiumReview) + count($review), 'premiumReview' => count($premiumReview), 'review' => count($review));
        return $total;
    }

    /**
     * 후기 리스트
     * @param array $res
     * @return array
     */
    public function getReviewList($res, $code = '')
    {
        if (!empty($res['max'])) {
            $perPage = $res['max'];
        } else {
            $perPage = 10;
        }

        $this->qb->startCache();
        $this->qb
            ->from(TBL_SHOP_PRODUCT_AFTER." as b")
            ->join(TBL_SHOP_PRODUCT." AS p", "b.pid = p.id", "left");

        if (!empty($res['sDate'])) { //마이페이지
            $this->qb->where("DATE_FORMAT(b.regdate,'%Y-%m-%d') >= ", $res['sDate']);
        }
        if (!empty($res['eDate'])) { //마이페이지
            $this->qb->where("DATE_FORMAT(b.regdate,'%Y-%m-%d') <= ", $res['eDate']);
        }

        if (empty($res['pageType'])) { //마이페이지
            $this->qb->where("mem_ix", $this->userCode);
        } else {
            if ($res['pageType'] == 'prd') {
                $this->qb->where('pid', $res['id']);
            }
        }

        if (!empty($res['bbsDiv'])) {
            $this->qb->where('bbs_div', $res['bbsDiv']);
        }

        $this->qb->stopCache();

        $total  = $this->qb->getCount();
        $paging = $this->qb
            ->setTotalRows($total)
            ->pagination($res['page'], $perPage);

        $limit  = $perPage;
        $offset = $paging['offset'];

        // 베스트순
        // $this->qb->orderBy('isBest', 'desc');

        if (!empty($res['orderBy'])) {
            $this->qb->orderBy($res['orderBy'], $res['orderByType']);
        }

        // 등록날짜순
        $this->qb->orderBy('b.regdate', 'desc');


        $list = $this->getAverageColumn()
            ->select("bbs_subject, bbs_contents, p.pname, p.brand_name, p.brand, b.regdate as real_regdate, pid, oid, bbs_ix, convert(bbs_ix,UNSIGNED) as bbs_no,  bbs_file_1, bbs_file_2, bbs_file_3, bbs_file_4, bbs_file_5")
            ->select("(SELECT date_format(order_date, '%Y-%m-%d') FROM shop_order WHERE oid = b.oid) order_date")
            ->select("CASE WHEN is_best = 'Y' THEN 1 ELSE 0 END AS isBest")
            ->select("CASE WHEN b.regdate > DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 1 ELSE 0 END AS NEW")
            ->select("CONCAT(SUBSTR(bbs_id, 1, 3), '****') AS bbs_id")
            ->select("DATE_FORMAT(b.regdate, '%Y-%m-%d') AS regdate")
            ->select('round((valuation_goods+valuation_delivery)/2, 1) as rev_avg')
            ->select('round(valuation_goods, 1) as rev_goods_avg')
            ->select('round(valuation_delivery, 1) as rev_delivery_avg')
            ->select('CASE WHEN CHAR_LENGTH(bbs_contents) > 35 THEN CONCAT(LEFT(bbs_contents, 35), "...") ELSE bbs_contents END AS bbs_contents_skip')
            ->select('CASE WHEN CHAR_LENGTH(bbs_contents) > 30 THEN CONCAT(LEFT(bbs_contents, 30), "...") ELSE bbs_contents END AS bbs_contents_mobile_skip')
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();

        $afterImgs = []; //후기 이미지 데이터 생성
        foreach ($list as $k => $v) {
            $list[$k]['pimg'] = get_product_images_src($v['pid'], is_adult());
            $thumb = $this->getAfterImg($v, 'thum'); //썸네일(첫번째 이미지)

            if (!empty($thumb)) {
                $list[$k]['isThumb'] = true;
                $list[$k]['thumb']   = $thumb;
            } else {
                $list[$k]['isThumb'] = false;
            }

            $afterImgs = $this->getAfterImg($v, 'all'); //상세리뷰 이미지
            if (count($afterImgs) > 0) {
                $list[$k]['anotherImgs'] = $afterImgs;
            } else {
                $list[$k]['anotherImgs'] = [];
            }
        }

        $this->qb->flushCache();

        foreach ($list as $k => $v) {
            if ($v['bbs_ix'] != "") {
                $cList = $this->qb->select("cmt_ix, cmt_name, cmt_contents")
                    ->select("date_format(regdate, '%Y-%m-%d') AS cmt_date")
                    ->from(TBL_SHOP_PRODUCT_AFTER_COMMENT)
                    ->where("bbs_ix", $v['bbs_ix'])
                    ->orderby("regdate", "ASC")
                    ->limit("1")
                    ->exec()
                    ->getRowArray(0);

                $cList['cmt_contents']    = nl2br($cList['cmt_contents']);
                $list[$k]['cmt']          = $cList;
                $list[$k]['bbs_contents'] = nl2br($v['bbs_contents']);
            }

            //좋아요했는지 체크
            $likeCheck = $this->qb->select("bbs_ix")
                ->from('shop_product_after_like')
                ->where("bbs_ix", $list[$k]['bbs_ix'])
                ->where("code", $code)
                ->limit("1")
                ->exec()
                ->getRowArray(0);
            if ($likeCheck) {
                $list[$k]['likeCheck'] = $likeCheck;
            } else {
                $list[$k]['likeCheck'] = "";
            }
        }

        return [
            'total' => $total
            , 'list' => $list
            , 'paging' => $paging
        ];
    }

    /**
     * 상품후기 상세
     * @param string $bbsIx
     * @return array
     */
    public function getReviewDetail($bbsIx)
    {
        $result['review'] = $this->qb->select("b.*")
            ->select("p.id, p.pname, p.global_pinfo, p.brand_name, p.brand")
            ->select("'P' AS after_type")
            ->select("ccd.com_name AS shop_name")
            ->select("valuation_goods AS valuation")
            ->select("ROUND(valuation_goods * 20) AS uf_valuation")
            ->select("CASE WHEN b.regdate > DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 1 ELSE 0 END AS NEW")
            ->select("CONCAT(SUBSTR(bbs_name,1,1), '*', SUBSTR(bbs_name,3)) AS bbs_name")
            ->select("DATE_FORMAT(b.regdate, '%Y-%m-%d') AS reg_date")
            ->select("DATE_FORMAT(so.order_date, '%Y-%m-%d') AS buy_date")
            ->select("so.*")
            ->from(TBL_SHOP_PRODUCT_AFTER." AS b")
            ->join(TBL_SHOP_PRODUCT." AS p", "b.pid = p.id", "left")
            ->join(TBL_COMMON_COMPANY_DETAIL." AS ccd", "p.admin = ccd.company_id", "left")
            ->join(TBL_SHOP_ORDER." AS so", "b.oid = so.oid", "left")
            ->where("b.mem_ix", sess_val('user', 'code'))
            ->where("b.bbs_ix", $bbsIx)
            ->exec()
            ->getRowArray(0);

        $afterImgs = []; //후기 이미지 데이터 생성
        $thumb[]   = get_product_images_src($result['review']['pid'], false, 'm', false); //썸네일(첫번째 이미지)
        if (!empty($thumb)) {
            $result['review']['isThumb'] = true;
            $result['review']['thumb']   = $thumb['0'];
        } else {
            $result['review']['isThumb'] = false;
        }

        $afterImgs = $this->getAfterImg($result['review'], 'all'); //상세리뷰 이미지
        if (count($afterImgs) > 0) {
            $result['review']['anotherImgs'] = $afterImgs;
        } else {
            $result['review']['anotherImgs'] = [];
        }

        $result['cmt'] = $this->qb->select("*")
            ->select("date_format(regdate, '%Y-%m-%d') AS reg_date")
            ->from(TBL_SHOP_PRODUCT_AFTER_COMMENT)
            ->where("bbs_ix", $bbsIx)
            ->orderby("regdate", "DESC")
            ->exec()
            ->getResultArray();

        return $result;
    }

    /**
     * 상품후기 삭제
     * @param array $res
     * @return boolean
     */
    public function deleteReview($res)
    {

        $result = $this->qb->delete(TBL_SHOP_PRODUCT_AFTER, array("bbs_ix" => $res['bbs_ix'], "mem_ix" => $res['mem_ix']), "1")->exec();
        if ($result) {
            $this->qb->delete(TBL_SHOP_PRODUCT_AFTER_COMMENT, array("bbs_ix" => $res['bbs_ix']))->exec();
        }
        return $result;
    }

    /**
     * 특정 게시물 데이터만 리턴
     * @param int $bbsIx
     * @return
     */
    public function getData($bbsIx)
    {
        $datas = $this->qb
            ->select("*")
            ->from(TBL_SHOP_PRODUCT_AFTER." as b")
            ->where("bbs_ix", $bbsIx)
            ->exec()
            ->getRowArray();
        return $datas;
    }

    /**
     * 후기 이미지 데이터 출력. 첫번째 이미지를 썸네일로 함.
     * @param array $data
     * @param string $type
     * @return array
     */
    public function getAfterImg($data, $type = '')
    {
        $imgs              = [];
        $reviewImageFolder = '/product_after';
        $basicPath         = MALL_DATA_PATH.$reviewImageFolder;
        $basicUrl          = DATA_ROOT.$reviewImageFolder;

        if ($type == 'all') {
            $start = 1;
            $end   = 6;
        } elseif ($type == 'thum') {
            $start = 1;
            $end   = 2;
        } else {
            $start = 2;
            $end   = 6;
        }

        for ($i = $start; $i < $end; $i++) {
            $imgPath = "/".intval($data['bbs_ix'])."/".$data['bbs_file_'.$i];
            if ($data['bbs_file_'.$i] && file_exists($basicPath.$imgPath)) {
                $imgs[] = get_img_url($basicUrl.$imgPath);
            }
        }


        return $imgs;
    }

    /**
     * 상품 후기가 등록된 주문과 상품인지 확인
     * @param string $oid
     * @param string $pid
     * @return boolean
     */
    public function existsReview($oid, $pid, $option_id = '')
    {
        if(!empty($option_id)){
            $this->qb->where('option_id', $option_id);
        }
        return $this->qb
                ->from(TBL_SHOP_PRODUCT_AFTER)
                ->where('oid', $oid)
                ->where('pid', $pid)
                ->getCount() > 0;
    }

    /**
     * 상품 후기를 등록한다.
     * @param array $post_data
     * @return boolean
     */
    public function insertReview($post_data)
    {
        // 직원회원 작성?
        if (defined('STAFF_GPIX') && $this->userInfo->gp_ix == STAFF_GPIX) { // 직원회원
            $row = $this->qb
                ->select('p.pname')
                ->select('p.brand_name')
                ->select('pd.company_id')
                ->from(TBL_SHOP_PRODUCT.' AS p')
                ->join(TBL_SHOP_PRODUCT_DELIVERY.' AS pd', 'p.id = pd.pid')
                ->where('p.id', $post_data['pid'])
                ->exec()
                ->getRowArray();
        } else {
            if ($this->existsReview($post_data['oid'], $post_data['pid'], $post_data['option_id']) === false) {
                $row = $this->qb
                    ->select('pname')
                    ->select('brand_name')
                    ->select('company_id')
                    ->select('option_text')
                    ->from(TBL_SHOP_ORDER_DETAIL)
                    ->where('oid', $post_data['oid'])
                    ->where('pid', $post_data['pid'])
                    ->where('option_id', $post_data['option_id'])
                    ->exec()
                    ->getRowArray();
            } else {
                return 'existsReview';
            }
        }

        if (isset($row['pname'])) {
            $config = ForbizConfig::getSharedMemory('use_after');

            $is_regist = $this->qb
                    ->from(TBL_SHOP_PRODUCT_AFTER)
                    ->where('oid', $post_data['oid'])
                    ->where('pid', $post_data['pid'])
                    ->getCount() > 0;

            $is_primium = false;

            if(!empty($post_data['bbs_subject'])){
                $bbs_subject = $post_data['bbs_subject'];
            }else{
                $bbs_subject = ' ';
            }

            $data = [
                'bbs_contents' => $post_data['bbs_contents']
                , 'bbs_div' => $post_data['type']
                , 'bbs_subject' => $bbs_subject
                , 'bbs_name' => $this->userInfo->name
                , 'bbs_id' => $this->userInfo->id
                , 'mem_ix' => $this->userInfo->code
                , 'bbs_hidden' => 0
                , 'bbs_hit' => 0
                , 'bbs_re_cnt' => 0
                , 'is_best' => 'N'
                , 'pid' => $post_data['pid']
                , 'pname' => $row['pname']
                , 'brand' => $row['brand_name']
                , 'company_id' => $row['company_id']
                , 'oid' => ($post_data['oid'] ?? '')
                , 'option_name' => ($row['option_text'] ?? '')
                , 'option_id' => ($post_data['option_id'] ?? '')
                , 'valuation_goods' => $post_data['valuation_goods']
                , 'valuation_delivery' => $post_data['valuation_delivery']
                , 'ip_addr' => $this->input->ip_address()
                , 'regdate' => date('Y-m-d H:i:s')
            ];

            $bbs_ix = $this->qb
                ->set($data)
                ->insert(TBL_SHOP_PRODUCT_AFTER)
                ->exec();

            $upData = [];
            if (!empty($_FILES)) {
                foreach (array_keys($_FILES) as $upfile) {
                    $upData[] = img_file_upload($upfile, MALL_DATA_PATH.'/product_after/'.$bbs_ix);
                }
            }

            if (isset($upData[0]['file_name'])) {
                $is_primium = true; // 프리미엄 후기

                $this->qb
                    ->set('bbs_file_1', ($upData[0]['file_name'] ?? ''))
                    ->set('bbs_file_2', ($upData[1]['file_name'] ?? ''))
                    ->set('bbs_file_3', ($upData[2]['file_name'] ?? ''))
                    ->set('bbs_file_4', ($upData[3]['file_name'] ?? ''))
                    ->set('bbs_file_5', ($upData[4]['file_name'] ?? ''))
                    ->where('bbs_ix', $bbs_ix)
                    ->update(TBL_SHOP_PRODUCT_AFTER)
                    ->exec();
            }

            // 상품후기 마일리지 적립 && 등록되지 않은 상품 후기 && 직원회원 아님
            if ($config['use_mileage'] == 'Y' && $is_regist === false && $this->userInfo->gp_ix != 8) {
                switch ($config['add_mileage_type']) {
                    case '1':
                        $mileage = $config['mileage_amount'];
                        break;
                    case '2':
                        $mileage = $is_primium ? $config['mileage_amount_p'] : $config['mileage_amount_r'];
                        break;
                    case '3':
                        $mileage = isset($config['mileage_amount_group'][$this->userInfo->gp_ix]) ? isset($config['mileage_amount_group'][$this->userInfo->gp_ix])
                                : 0;
                        break;
                    default:
                        $mileage = 0;
                        break;
                }

                if ($mileage > 0) {
                    /* @var $mileageModel CustomMallMileageModel */
                    $mileageModel = $this->import('model.mall.mileage');

                    $mileageModel
                        ->setMember($this->userInfo->code, $this->userInfo->gp_ix, 'Y')
                        ->addMileage($mileage, 7, $row['pname'].($is_primium ? ' 포토후기' : ' 일반후기').' 작성');
                }
            }

            return 'success';
        }

        return 'notExistsOrder';
    }
}