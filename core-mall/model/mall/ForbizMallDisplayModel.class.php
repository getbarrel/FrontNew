<?php

/**
 * Description of ForbizMallCustomerModel
 *
 * @author hoksi
 * @property CustomMallProductModel $productModel
 */
class ForbizMallDisplayModel extends ForbizModel
{

    /**
     * 사용 환경 (W: PC, M:모바일)
     * @var string
     */
    protected $agentType = 'W';
    public $productModel;

    public function __construct()
    {
        parent::__construct();

        $this->productModel = $this->import('model.mall.product');
        $this->setAgentType((is_mobile() ? "M" : "W"));
    }

    /**
     * set 사용 환경
     * @param string $agentType
     * @return $this
     */
    public function setAgentType($agentType)
    {
        $this->agentType = strtoupper($agentType);
        return $this;
    }

    /**
     * 배너링크 리턴
     * @param int $bannerIx
     * @param int $bdIx
     * @return string
     */
    public function getBannerLink($bannerIx, $bdIx = '')
    {
        if (!empty($bdIx)) { //banenr_info_detail 사용
            $datas = $this->qb
                ->select('bd_link as link')
                ->from(TBL_SHOP_BANNERINFO_DETAIL)
                ->where('bd_ix', $bdIx)
                ->exec()
                ->getRowArray();
        } else { //banenr_info 사용
            if (!empty($bannerIx)) {
                $datas = $this->qb
                    ->select('banner_link as link')
                    ->from(TBL_SHOP_BANNERINFO)
                    ->where('banner_ix', $bannerIx)
                    ->exec()
                    ->getRowArray();
            } else {
                return;
            }
        }

        $this->updateBannerClick($bannerIx); //로그스토리 클릭수 업데이트

        if ($datas["link"] != "#" && !empty($datas["link"])) {
            return $datas["link"];
        } else {
            return;
        }
    }

    /**
     * 배너 클릭시 로그 테이블에 쌓이는 기능
     * @param int $bannerIx
     * @return type
     */
    public function updateBannerClick($bannerIx)
    {
        $datas = $this->qb
            ->select('vdate, ncnt, nh' . date("H"))
            ->from(TBL_LOGSTORY_BANNER_CLICK)
            ->where('vdate', date("Ymd"))
            ->where('banner_ix', $bannerIx)
            ->exec()
            ->getRowArray();

        if (!empty($datas)) {
            $this->qb
                ->set('nh' . date("H"), $datas['nh' . date("H")] + 1)
                ->set('ncnt', $datas['ncnt'] + 1)
                ->where('vdate', date("Ymd"))
                ->where('banner_ix', $bannerIx)
                ->update(TBL_LOGSTORY_BANNER_CLICK)
                ->exec();
        } else {
            $this->qb->insert(TBL_LOGSTORY_BANNER_CLICK, [
                'vdate' => date("Ymd"),
                'banner_ix' => $bannerIx,
                'nh' . date("H") => 1,
                'ncnt' => 1
            ])->exec();
        }

        return;
    }

    /**
     * 메인/프로모션 전시 목록 전체 데이터(각 전시의 하위데이터, 상품 포함)
     * @param string $type : main 또는 promotion
     * @param string $divCode : 메인 전시 분류
     * @return array
     */
    public function getMainDisplay($divCode = '', $mpIx = '')
    {
        $lists = $this->getMainDisplayLists($divCode, $mpIx);
        foreach ($lists as $k => $v) {
            $lists[$k]['details'] = $this->getMainDisplayDetails($v['div_code'], $v['key']);
        }
        return $lists;
    }

    /**
     * 메인 전시 목록 데이터(각 전시의 하위데이터(그룹), 상품 미포함)
     * @param string $divCode
     * @return array
     */
    public function getMainDisplayLists($divCode = '', $mpIx = '')
    {
        $this->qb
            ->select('g.mg_ix as key, d.div_ix,d.div_code,g.*')
            ->from(TBL_SHOP_MAIN_DIV . ' as d ')
            ->join(TBL_SHOP_MAIN_GOODS . ' as g ', 'd.div_ix = g.div_ix', 'left')
            ->where('d.agent_type', $this->agentType)
            ->where('d.disp', 1)
            ->where('g.disp', 1)
            ->where('g.mg_use_sdate <=', time())
            ->where('g.mg_use_edate >=', time())
            ->orderBy('g.div_ix', 'asc');

        if (!empty($divCode)) {
            $this->qb->where('d.div_code', $divCode);
        }

        if (!empty($mpIx)) {
            $this->qb->where('g.mp_ix', $mpIx);
        }

        $items = $this->qb->exec()->getResultArray();

        return $items;
    }

    /**
     * 메인 전시 목록의 하위 그룹 데이터
     * @param string $divCode
     * @param int $key
     * @return array
     */
    public function getMainDisplayDetails($divCode, $key = '')
    {
        $this->qb
            ->select('*')
            ->from(TBL_SHOP_MAIN_PRODUCT_GROUP)
            ->where('use_yn', 'Y')
            ->where('div_code', $divCode)
            ->orderBy('mg_ix', 'asc')
            ->orderBy('group_code', 'asc');

        if (!empty($key)) {
            $this->qb->where('mg_ix', $key);
        }

        $datas = $this->qb->exec()->getResultArray();

        $getMainSubBannerImgs = [];
        foreach ($datas as $k => $v) {
            $getMainSubBannerImgs = @$this->getMainSubBannerImgs($v);

            if ($getMainSubBannerImgs) {
                $datas[$k]['getMainSubBannerImgs'] = $getMainSubBannerImgs;
            } else {
                $datas[$k]['getMainSubBannerImgs'] = '';
            }

            $datas[$k]['goods'] = $this->getMainDisplayGoods($key, $v['group_code'], $v['product_cnt']);
        }

        return $datas;
    }

    /**
     * 메인 전시 목록의 하위 그룹의 상품 데이터
     * @param int $key
     * @param int $groupCode
     * @param int $limit
     * @return array
     */
    public function getMainDisplayGoods($key, $groupCode, $limit = '100')
    {
        $list = [];
        $ids = $this->productModel->basicWhere()
            ->select('r.pid')
            ->from(TBL_SHOP_PRODUCT . ' as p')
            ->join(TBL_SHOP_MAIN_PRODUCT_RELATION . ' as r', 'p.id=r.pid', 'inner')
            ->where('mg_ix', $key)
            ->where('group_code', $groupCode)
            ->groupBy('id')
            ->orderBy('r.vieworder', 'asc')
            ->limit($limit)
            ->exec()
            ->getResultArray();

        if (!empty($ids) && is_array($ids)) {
            $list = $this->productModel->getListById(array_column($ids, 'pid'));
        }
        return $list;
    }

    /**
     * 프로모션 전시 목록 데이터(각 전시의 하위데이터(그룹), 상품 미포함)
     * @param string $divCode
     * @return array
     */
    public function getPromotionDisplayLists($divCode = '')
    {
        $this->qb
            ->select('g.pg_ix as key, d.div_ix,d.div_code,g.*')
            ->from(TBL_SHOP_PROMOTION_DIV . ' as d ')
            ->join(TBL_SHOP_PROMOTION_GOODS . ' as g ', 'd.div_ix = g.div_ix', 'left')
            ->where('d.agent_type', $this->agentType)
            ->where('d.disp', 1)
            ->where('g.disp', 1)
            ->where('g.pg_use_sdate <=', time())
            ->where('g.pg_use_edate >=', time())
            ->orderBy('g.div_ix', 'asc');

        if (!empty($divCode)) {
            $this->qb->where('d.div_code', $divCode);
        }

        return $this->qb->exec()->getResultArray();
    }

    /**
     * 프로모션 전시 목록의 하위 그룹 데이터
     * @param string $divCode
     * @param int $key
     * @return array
     */
    public function getPromotionDisplayDetails($divCode, $key = '')
    {
        $this->qb
            ->select('*')
            ->from(TBL_SHOP_PROMOTION_PRODUCT_GROUP)
            ->where('use_yn', 'Y')
            ->where('div_code', $divCode)
            ->orderBy('pg_ix', 'asc')
            ->orderBy('group_code', 'asc');

        if (!empty($key)) {
            $this->qb->where('pg_ix', $key);
        }

        $datas = $this->qb->exec()->getResultArray();

        foreach ($datas as $k => $v) {
            $datas[$k]['goods'] = $this->getPromotionDisplayGoods($key, $v['group_code'], $v['product_cnt']);
        }
        return $datas;
    }

    /**
     * 프로모션 전시 목록의 하위 그룹의 상품 데이터
     * @param int $key
     * @param int $groupCode
     * @param int $limit
     * @return array
     */
    public function getPromotionDisplayGoods($key, $groupCode, $limit = '100')
    {
        $list = [];
        $ids = $this->productModel->basicWhere()
            ->select('r.pid')
            ->from(TBL_SHOP_PRODUCT . ' as p ')
            ->join(TBL_SHOP_PROMOTION_PRODUCT_RELATION . ' as r', 'p.id=r.pid', 'inner')
            ->where('pg_ix', $key)
            ->where('group_code', $groupCode)
            ->orderBy('r.vieworder', 'asc')
            ->limit($limit)
            ->exec()
            ->getResultArray();

        if (!empty($ids) && is_array($ids)) {
            $list = $this->productModel->getListById(array_column($ids, 'pid'));
        }
        return $list;
    }

    /**
     * 분류별 메인전시(카테고리) 전시 리스트
     * @param string $cid
     * @param string $divCode
     * @param string $subDivCode
     * @return array
     */
    public function getCategoryMain($cid, $divCode = "", $subDivCode = "")
    {//subdivcode
        $lists = [];

        $this->qb
            ->select('g.*')
            ->from(TBL_SHOP_CATEGORY_MAIN_GOODS . ' as g ')
            ->join(TBL_SHOP_CATEGORY_MAIN_POSITION . ' as p ', 'g.display_position=p.cmp_ix', 'inner')
            ->join(TBL_SHOP_CATEGORY_MAIN_DIV . ' as d ', 'p.div_ix=d.div_ix', 'inner')
            ->where('display_cid', $cid);

        if (!empty($divCode)) {
            $this->qb->where('d.div_name', $divCode);
        }

        if (!empty($subDivCode)) {
            $this->qb->where('p.cmp_name', $subDivCode);
        }

        $lists = $this->qb->exec()->getResultArray();

        if (!empty($lists) && is_array($lists)) {
            foreach ($lists as $k => $v) {
                $lists[$k]['details'] = $this->getCategoryMainDisplayLists($v['cmg_ix']);
            }
        }
        return $lists;
    }

    /**
     * 분류별 메인전시(카테고리) 하위그룹 데이터
     * @param int $cmgIx
     * @return array
     */
    public function getCategoryMainDisplayLists($cmgIx)
    {
        $datas = $this->qb
            ->select('pg.*')
            ->from(TBL_SHOP_CATEGORY_MAIN_PRODUCT_GROUP . ' as pg ')
            ->where('cmg_ix', $cmgIx)
            ->exec()
            ->getResultArray();

        if (!empty($datas) && is_array($datas)) {
            foreach ($datas as $k => $v) {
                $datas[$k]['goods'] = $this->getCategoryMainDisplayGoods($v['cmg_ix'], $v['group_code']);
            }
        }
        return $datas;
    }

    /**
     * 분류별 메인전시(카테고리) 상품 데이터
     * @param int $cmg_ix
     * @param int $groupCode
     * @return array
     */
    public function getCategoryMainDisplayGoods($cmg_ix, $groupCode = '')
    {
        $list = [];
        $ids = $this->productModel->basicWhere()
            ->select('r.pid')
            ->from(TBL_SHOP_PRODUCT . ' as p')
            ->join(TBL_SHOP_CATEGORY_MAIN_PRODUCT_RELATION . ' as r', 'r.pid=p.id', 'inner') //상품 카테고리 테이블
            ->where('cmg_ix', $cmg_ix)
            ->where('group_code', $groupCode)
            ->orderBy('r.vieworder', 'asc')
            ->exec()
            ->getResultArray();

        if (!empty($ids) && is_array($ids)) {
            $list = $this->productModel->getListById(array_column($ids, 'pid'));
        }
        return $list;
    }

    /**
     * 이미지 데이터 출력
     * @param array $data
     * @return array
     */
    public function getMainSubBannerImgs($data)
    {
        $reviewImageFolder = '/images/main';

        $basicPath = MALL_DATA_PATH . $reviewImageFolder;
        $basicUrl = DATA_ROOT . $reviewImageFolder;

        $imgPath = "/" . intval($data['mg_ix']) . "_main_group_" . intval($data['group_code']) . ".gif";

        $imgSize = @getimagesize($basicPath . $imgPath);
        if (isset($imgSize['mime'])) {
            $imgs = @get_img_url($basicUrl . $imgPath);
        }

        return $imgs;
    }

    public function getPopupList()
    {
        $requestUrl = $this->uri->uri_string();

        $now = date('Y-m-d H:i:s');
        $userCode = sess_val('user', 'code');
        $userGpIx = sess_val('user', 'gp_ix');

        if (in_array($requestUrl, ['', '/', '/index'])) { //메인
            $displayPosition = 'M';
        } else if (strncmp($requestUrl, '/shop/goodsList', 15) === 0) { //상품 리스트
            $displayPosition = 'C';
            $cid = explode('/', $requestUrl)[3];
            $this->qb->join(TBL_SHOP_POPUP_DISPLAY_RELATION . ' AS pdr', "p.popup_ix = pdr.popup_ix AND pdr.pdr_div = 'P' AND pdr.pdr_sub_div = 'C' AND pdr.r_ix = '" . $cid . "'");
        } else { //기타 URL
            $displayPosition = 'E';
            $this->qb->where("'" . $requestUrl . "' LIKE CONCAT(p.display_url,'%')", '', false);
        }

        if (!empty($userCode)) {
            $this->qb->join(TBL_SHOP_POPUP_DISPLAY_RELATION . ' AS pdr2', "p.popup_ix = pdr2.popup_ix and pdr2.pdr_div = 'T'", 'LEFT');
            $this->qb->groupStart()
                ->where('p.display_target', 'A') //노출회원 설정 A:전체
                ->orGroupStart()
                ->Where('p.display_target', 'T') // 노출회원 설정 T:회원
                ->groupStart()
                ->groupStart()
                ->where('p.display_sub_target', 'M') // 지정 회원
                ->where('pdr2.pdr_sub_div', 'M') // 지정 회원
                ->where('pdr2.r_ix', $userCode)
                ->groupEnd()
                ->orGroupStart()
                ->where('p.display_sub_target', 'G') // 지정 그룹
                ->where('pdr2.pdr_sub_div', 'G') // 지정 그룹
                ->where('pdr2.r_ix', $userGpIx)
                ->groupEnd()
                ->groupEnd()
                ->groupEnd()
                ->groupEnd();
        } else {
            $this->qb->where('p.display_target', 'A'); //노출회원 설정 A:전체
        }

        return $this->qb
                ->select('p.popup_ix')
                ->select('p.popup_title')
                ->select('p.popup_top')
                ->select('p.popup_left')
                ->select('p.popup_type')
                ->from(TBL_SHOP_POPUP . ' AS p')
                ->where('p.disp', '1')
                ->where('p.popup_position', (is_mobile() ? 'M' : 'F')) //F: PC, M:모바일
                ->where('p.display_position', $displayPosition) //M: 메인 C: 카테고리 E: 특정 url
                ->where('p.popup_use_sdate <= ', $now)
                ->where('p.popup_use_edate >= ', $now)
                ->exec()
                ->getResultArray();
    }

    public function getPopup($popupIx)
    {
        return $this->qb
                ->select('p.popup_ix')
                ->select('p.popup_title')
                ->select('p.popup_today')
                ->select('p.popup_text')
                ->select('p.popup_type')
                ->from(TBL_SHOP_POPUP . ' AS p')
                ->where('p.popup_ix', $popupIx)
                ->exec()
                ->getRowArray();
    }
}
