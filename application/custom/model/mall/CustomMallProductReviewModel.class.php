<?php

/**
 * Description of CustomMallMypageModel
 *
 * @author hoksi
 */
class CustomMallProductReviewModel extends ForbizMallProductReviewModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 후기 리스트
     * @param array $res
     * @return array
     */
    public function getReviewListAll($res, $code = '')
    {
        if (!empty($res['max'])) {
            $perPage = $res['max'];
        } else {
            $perPage = 10;
        }

        $this->qb->startCache();
        $this->qb
            ->from(TBL_SHOP_PRODUCT_AFTER." as b")
            ->join(TBL_SHOP_PRODUCT." AS p", "b.pid = p.id", "inner")
            ->join("(select bbs_ix, count(bbs_ix) as cnt from shop_product_after_like)"." AS l", "b.bbs_ix = l.bbs_ix", "left");

        if (!empty($res['category'])) {
            $this->qb
                ->join(TBL_SHOP_PRODUCT_RELATION." AS r", "r.pid = p.id", "inner")
                ->join(TBL_SHOP_CATEGORY_INFO." AS c", "c.cid = r.cid", "inner")
                ->like("c.cid", '000'.substr($res['category'],3, 3), 'after');
        }

        if (!empty($res['regdate'])) {
            $this->qb->where("b.regdate", $res['regdate']);
        }

        if (!empty($res['bbsDiv'])) {
            $this->qb->where('bbs_div', $res['bbsDiv']);
        }

        $this->qb->stopCache();

        $total = $this->qb->getCount();

        $paging = $this->qb
            ->setTotalRows($total)
            ->pagination($res['page'], $perPage);

        $limit  = $perPage;
        $offset = $paging['offset'];

        if (!empty($res['orderBy'])) {
            $this->qb->orderBy($res['orderBy'], $res['orderByType']);
        }

        $list = $this->getAverageColumn()
            ->select("bbs_subject, bbs_contents, bbs_file_1, bbs_file_2, bbs_file_3, bbs_file_4, bbs_file_5, is_best, b.pname, b.bbs_ix, p.id, p.is_adult")
            ->select("CASE WHEN b.regdate > DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 1 ELSE 0 END AS NEW", false)
            ->select("CASE WHEN b.is_best = 'Y' THEN 'Y' ELSE null END AS is_best_set", false)
            ->select("(select COUNT(bbs_ix) AS cnt FROM shop_product_after_like where bbs_ix=b.bbs_ix) AS likeCnt", false)
            ->select("CONCAT(SUBSTR(bbs_id, 1, 3), '****') AS bbs_id", false)
            ->select("IF(LENGTH(bbs_contents)>70, CONCAT(SUBSTR(bbs_contents, 1, 70), '...'), bbs_contents) AS bbs_contents_skip", false)
            ->select("IF(LENGTH(bbs_contents)>22, CONCAT(SUBSTR(bbs_contents, 1, 22), '...'), bbs_contents) AS bbs_contents_skip_m", false)
            ->select('round((valuation_goods+valuation_delivery)/2, 1) as avg')
            ->select('round(valuation_goods, 1) as goods_avg')
            ->select('round(valuation_delivery, 1) as delivery_avg')
            ->select('round((valuation_goods+valuation_delivery)/2, 1) * 20 as avg_pct')
            ->select('round(valuation_goods, 1) * 20 as goods_avg_pct')
            ->select('round(valuation_delivery, 1) * 20 as delivery_avg_pct')
            ->select("DATE_FORMAT(b.regdate, '%Y-%m-%d') AS regdate", false)
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();

        $afterImgs = []; //후기 이미지 데이터 생성
        foreach ($list as $k => $v) {
            $list[$k]['image_src'] = get_product_images_src($list[$k]['id'], false, 'm', $list[$k]['is_adult']);

            $thumb = $this->getAfterImg($v, 'thum'); //썸네일(첫번째 이미지)

            if (!empty($thumb)) {
                $list[$k]['isThumb'] = true;
                $list[$k]['thumb']   = $thumb;
            } else {
                $list[$k]['isThumb'] = false;
            }

            $afterImgs = $this->getAfterImg($v); //상세리뷰 이미지
            if (count($afterImgs) > 0) {
                $list[$k]['anotherImgs'] = $afterImgs;
            } else {
                $list[$k]['anotherImgs'] = [];
            }

            $afterImgsAll = $this->getAfterImg($v, 'all');
            if (count($afterImgsAll) > 0) {
                $list[$k]['afterImgsAll'] = $afterImgsAll;
            } else {
                $list[$k]['afterImgsAll'] = [];
            }
        }

        $this->qb->flushCache();

        foreach ($list as $k => $v) {
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

        if (isset($res['havingCmt'])) {
            foreach ($list as $k => $v) {
                if ($v['bbs_ix'] != "") {
                    $cList           = $this->qb->select("cmt_ix, cmt_name, cmt_contents")
                        ->select("date_format(regdate, '%Y-%m-%d') AS cmt_date")
                        ->from(TBL_SHOP_PRODUCT_AFTER_COMMENT)
                        ->where("bbs_ix", $v['bbs_ix'])
                        ->orderby("regdate", "ASC")
                        ->limit("1")
                        ->exec()
                        ->getRowArray(0);
                    $list[$k]['cmt'] = $cList;

                    $cList['cmt_contents']    = nl2br($cList['cmt_contents']);
                    $list[$k]['cmt']          = $cList;
                    $list[$k]['bbs_contents'] = nl2br($v['bbs_contents']);
                }
            }
        }

        return [
            'total' => $total
            , 'list' => $list
            , 'paging' => $paging
        ];
    }

    /**
     * 좋아요 처리
     * @param array $res
     * @param array $code
     * @return string
     */
    public function getLikesClick($res, $code)
    {
        //좋아요했는지 체크
        $cList = $this->qb->select("lkt_ix")
            ->from('shop_product_after_like')
            ->where("bbs_ix", $res['bbs_ix'])
            ->where("code", $code)
            ->limit("1")
            ->exec()
            ->getRowArray(0);

        //리스트 게시물 번호
        $ix = $res['bbs_ix'];

        if ($cList) {
            //존재하면 삭제
            $this->getAfterLikeDelete($ix, $code);
            $upDown = 'down';
        } else {
            //미존재하면 삽입
            $this->getAfterLikesInsert($ix, $code);
            $upDown = 'up';
        }

        //좋아요 수
        $cnt = $this->getAfterLikeCount($res['bbs_ix']);

        return [
            'upDown' => $upDown,
            'cnt' => $cnt
        ];
    }

    /**
     * 좋아요 추가
     * @param string $ix   게시물번호
     * @param string $code 회원코드
     */
    public function getAfterLikesInsert($ix, $code)
    {
        $this->qb
            ->set('bbs_ix', $ix)
            ->set('code', $code)
            ->insert('shop_product_after_like')
            ->exec();
    }

    /**
     * 좋아요 삭제
     * @param string $ix   게시물번호
     * @param string $code 회원코드
     */
    public function getAfterLikeDelete($ix, $code)
    {
        $this->qb
            ->where('bbs_ix', $ix)
            ->where('code', $code)
            ->delete('shop_product_after_like')
            ->exec();
    }

    /**
     * 좋아요 수
     * @param string $ix   게시물번호
     */
    public function getAfterLikeCount($ix)
    {
        $cnt = $this->qb->select("COUNT(bbs_ix) AS cnt")
            ->from('shop_product_after_like')
            ->where("bbs_ix", $ix)
            ->limit("1")
            ->exec()
            ->getRow();

        return $cnt;
    }

    /**
     * 포토후기 상세
     * @param string $ix  게시물번호
     */
    public function getPhotoReviewDetail($ix, $code = '')
    {
        $list = $this->qb->select("b.bbs_ix, bbs_id, LEFT(b.regdate,10) as regdate, valuation_goods, valuation_delivery, bbs_contents, b.pname, p.id, p.is_adult")
            ->select("bbs_file_1, bbs_file_2, bbs_file_3, bbs_file_4, bbs_file_5")
            ->select("CONCAT(SUBSTR(bbs_id, 1, 3), '****') AS bbs_id")
            ->select('round((valuation_goods+valuation_delivery)/2, 1) as avg')
            ->select('round(valuation_goods, 1) as goods_avg')
            ->select('round(valuation_delivery, 1) as delivery_avg')
            ->select('round((valuation_goods+valuation_delivery)/2, 1) * 20 as avg_pct')
            ->select('round(valuation_goods, 1) * 20 as goods_avg_pct')
            ->select('round(valuation_delivery, 1) * 20 as delivery_avg_pct')
            ->select("(select COUNT(bbs_ix) AS cnt FROM shop_product_after_like where bbs_ix=b.bbs_ix) AS likeCnt")
            ->from(TBL_SHOP_PRODUCT_AFTER." as b")
            ->join(TBL_SHOP_PRODUCT." as p", "b.pid = p.id", "inner")
            ->join("(select bbs_ix, count(bbs_ix) as cnt from shop_product_after_like)"." as l", "b.bbs_ix = l.bbs_ix", "left")
            ->where("b.bbs_ix", $ix)
            ->limit("1")
            ->exec()
            ->getResultArray();

        $afterImgs = []; //후기 이미지 데이터 생성
        foreach ($list as $k => $v) {
            $list[$k]['image_src'] = get_product_images_src($list[$k]['id'], false, 'm', $list[$k]['is_adult']);

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

            if ($v['bbs_ix'] != "") { //상세리뷰 관리자 댓글
                $cList           = $this->qb->select("cmt_ix, cmt_name, cmt_contents")
                    ->select("date_format(regdate, '%Y-%m-%d') AS cmt_date")
                    ->from(TBL_SHOP_PRODUCT_AFTER_COMMENT)
                    ->where("bbs_ix", $v['bbs_ix'])
                    ->orderby("regdate", "ASC")
                    ->limit("1")
                    ->exec()
                    ->getRowArray(0);
                $list[$k]['cmt'] = $cList;
            }

            if ($code) {
                //좋아요했는지 체크
                $likeCheck = $this->qb->select("bbs_ix")
                    ->from('shop_product_after_like')
                    ->where("bbs_ix", $v['bbs_ix'])
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
        }

        return $list;
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
        if (DIRECTORY_SEPARATOR == '\\') {
            $basicPath = IMAGE_SERVER_DOMAIN.'/dewytree_data'.$reviewImageFolder;
        } else {
            $basicPath = MALL_DATA_PATH.$reviewImageFolder;
        }
        $basicUrl = DATA_ROOT.$reviewImageFolder;

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
            if ($data['bbs_file_'.$i]) {
                $imgPath = "/".intval($data['bbs_ix'])."/".$data['bbs_file_'.$i];
                $imgSize = @getimagesize($basicPath.$imgPath);
                if ($data['bbs_file_'.$i] && isset($imgSize['mime'])) {
                    $imgs[] = get_img_url($basicUrl.$imgPath);
                }
            }
        }


        return $imgs;
    }

    /**
     * 상품 후기를 등록한다.
     * @param array $post_data
     * @return boolean
     */
    public function insertReview($post_data)
    {
        // 직원회원 작성?
        /*
        if ($this->userInfo->gp_ix == STAFF_GPIX) { // 직원회원
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
            if ($this->existsReview($post_data['oid'], $post_data['pid']) === false) {
                $row = $this->qb
                    ->select('pname')
                    ->select('brand_name')
                    ->select('company_id')
                    ->select('option_text')
                    ->from(TBL_SHOP_ORDER_DETAIL)
                    ->where('oid', $post_data['oid'])
                    ->where('pid', $post_data['pid'])
                    //   ->where('ode_ix', $post_data['ode_ix'])
                    ->exec()
                    ->getRowArray();
            } else {
                return 'existsReview';
            }
        }
        */
        if ($this->existsReview($post_data['oid'] , $post_data['pid']) === false) {
            $row = $this->qb
                ->select('pname')
                ->select('brand_name')
                ->select('company_id')
                ->select('option_text')
                ->from(TBL_SHOP_ORDER_DETAIL)
                ->where('oid', $post_data['oid'])
                ->where('pid', $post_data['pid'])
                //   ->where('ode_ix', $post_data['ode_ix'])
                ->exec()
                ->getRowArray();
        } else {
            return 'existsReview';
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

            // 상품후기 마일리지 적립 && 등록되지 않은 상품 후기
            if ($config['use_mileage'] == 'Y' && $is_regist === false ) {
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