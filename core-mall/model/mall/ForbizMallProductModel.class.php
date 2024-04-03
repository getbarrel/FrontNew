<?php

/**
 * Description of ForbizMallProductModel
 * @property CustomMallCartModel $cartModel
 *
 * @author hong
 */
class ForbizMallProductModel extends ForbizModel
{
    protected $cartModel;

    /**
     * 도소매 구분 (R:소매, W:도매)
     * @var string
     */
    protected $sellingType = 'R';

    /**
     * 구매 가격 구분 (P:프리미엄가, S:판매가, L:정가)
     * @var string
     */
    protected $displayPriceType = 'S';

    /**
     * 성인여부 (true: 성인)
     * @var  booleans
     */
    protected $isUserAdult = false;

    /**
     * 상품별 할인정보 데이터
     * @var array
     */
    protected $discountData = [];

    /**
     * 할인 단위 자리수 (1:일, 2:십, 3:백)
     * @var int
     */
    protected $discoutRoundPosition = 1;

    /**
     * 할인 절삭 타입 (floor:내림, ceil:올림)
     * @var string
     */
    protected $discoutRoundType = 'floor';

    /**
     * 회원 그룹 인덱스 (common_member_detail.gp_ix)
     * @var type
     */
    protected $discoutMemberGroupIx = 0;

    /**
     * 회원 그룹 할인율
     * @var int
     */
    protected $discoutMemberGroupSaleRate = 0;

    /**
     * App 할인율
     * @var int
     */
    protected $discoutAppSaleRate = 0;

    /**
     * 사용 환경 (W: PC, M:모바일)
     * @var string
     */
    protected $agentType = 'W';

    public function __construct()
    {
        parent::__construct();

        $this->cartModel = $this->import('model.mall.cart');

        //로그인 여부에 따른 세팅
        if (is_login()) {
            $this->setSellingType(sess_val('user', 'selling_type'));
            $this->setDisplayPriceType(sess_val('user', 'dc_standard_price'));
            $this->setUserAdult((sess_val('user', 'age') >= '19' ? true : false));
            $this->setDiscoutMemberGroup(sess_val('user', 'gp_ix'), (sess_val('user', 'use_discount_type') == 'g' ? sess_val('user', 'sale_rate') : 0));
            $this->setDiscoutApp(sess_val('user', 'app_dc_rate'));
        }
        $this->setAgentType((is_mobile() ? "M" : "W"));
    }

    /**
     * set 도소매 구분
     * @param string $sellingType
     * @return $this
     */
    public function setSellingType($sellingType)
    {
        $this->sellingType = strtoupper($sellingType);
        return $this;
    }

    /**
     * set 구매 가격 구분
     * @param string $displayPriceType
     * @return $this
     */
    public function setDisplayPriceType($displayPriceType)
    {
        $this->displayPriceType = strtoupper($displayPriceType);
        return $this;
    }

    /**
     * set 성인여부 (true: 성인)
     * @param booleans $userAdult
     * @return $this
     */
    public function setUserAdult($userAdult)
    {
        $this->isUserAdult = $userAdult;
        return $this;
    }

    /**
     * set 회원 그룹 키, 할인율
     * @param int $gpIx
     * @param int $rate
     * @return $this
     */
    public function setDiscoutMemberGroup($gpIx, $rate)
    {
        $this->discoutMemberGroupIx       = $gpIx;
        $this->discoutMemberGroupSaleRate = $rate;
        return $this;
    }

    /**
     * set App 할인율
     * @param int $rate
     * @return $this
     */
    public function setDiscoutApp($rate)
    {
        $this->discoutAppSaleRate = $rate;
        return $this;
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
     * get 대카테고리 (0 depth 카테고리)
     * @param string $cid
     * @param int $depth
     * @return array
     */
    public function getLargeCategoryList()
    {
        return $this->qb
                ->select('cname, cid, depth')
                ->from(TBL_SHOP_CATEGORY_INFO)
                ->where('depth', '0')
                ->where('category_use', '1')
                ->where('is_delete', 0)
                ->exec()
                ->getResultArray();
    }

    /**
     * 특정 카테고리의 상위, 동위 카테고리 데이터 전체 호출
     * @param string $cid
     * @return array
     */
    public function getCategoryNavigationList($cid)
    {
        $depth = $this->getDepth($cid); //depth 계산
        $cids  = array();
        for ($i = 0; $i <= $depth; $i++) {
            if (!empty($cid)) {
                $this->qb->select('if(SUBSTRING(cid, 1, '.(3 * ($i + 1)).')="'.substr($cid, 0, 3 * ($i + 1)).'", 1, 0) as isBelong');

                if ($i > 0) {
                    $this->qb->like('cid', substr($cid, 0, 3 * $i), 'after');
                }
            }

            $datas = $this->qb
                    ->select('cid, cname, depth')
                    ->from(TBL_SHOP_CATEGORY_INFO)
                    ->where('depth', $i)
                    ->where('category_use', '1')
                    ->exec()->getResultArray();

            if(!empty($datas)){
                $cids[] = $datas;
            }

        }

        return $cids;
    }

    /**
     * 특정 카테고리 하위 1개의 데이터만 호출
     * @param string $cid
     * @return array
     */
    public function getCategorySubList($cid, $pathBool = false)
    {
        $depth = $this->getDepth($cid); //depth 계산

        $this->qb->startCache();
        $this->qb
            ->select('cname, cid, depth')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->where('category_use', '1');

        if (!empty($cid)) {
            $this->qb->like('cid', substr($cid, 0, 3 * ($depth + 1)), 'after');
            $this->qb->where('depth', ($depth + 1));
        } else {
            $this->qb->where('depth', $depth);
        }
        $this->qb->stopCache();

        $datas = $this->qb->exec()->getResultArray();
        $this->qb->flushCache(); //sql 캐시 날리기

        if ($pathBool) {
            foreach ($datas as $k => $v) {
                $datas[$k]['pathArray'] = $this->getCategoryPath($v['cid'], $v['depth']);
            }
        }

        return $datas;
    }

    /**
     * 카테고리 경로 데이터
     * @param string $cid
     * @param int $depth
     * @return array
     */
    public function getCategoryPath($cid, $depth)
    {
        $this->qb
            ->select('cname, cid, depth')
            ->from(TBL_SHOP_CATEGORY_INFO);

        for ($i = 0; $i <= $depth; $i++) {
            $this->qb
                ->orGroupStart()
                ->like('cid', substr($cid, 0, 3 * ($i + 1)), 'after')
                ->where('depth', $i)
                ->groupEnd();
        }

        return $this->qb->exec()->getResultArray();
    }

    /**
     * 브랜드 전체 리스트
     * @return array
     */
    public function getBrandList()
    {
        return $this->qb
                ->select('b_ix, brand_name')
                ->from(TBL_SHOP_BRAND)
                ->where('disp', 1)
                ->exec()->getResultArray();
    }

    /**
     * depth 계산
     * @param string $cid
     * @return int
     */
    public function getDepth($cid)
    {
        $depth     = 0;
        $cid_array = str_split($cid, 3);
        foreach ($cid_array as $k => $v) {
            if ($v == '000' && $k > 0) {// cid : 0001002003000000 일 경우 003 이하는 루프돌지 않도록 처리함
                break;
            } else {
                $depth = $k;
            }
        }
        return $depth;
    }

    /**
     * 리스트 호출(상품리스트, 검색)
     * @param array $where
     * @param array $sort
     * @return array
     * 컬럼 표준명
     * 카테고리 = filterCid = r.cid
     * 브랜드 = filterBrands = p.brand (예시 : 1,2,3)
     * 무료배송 여부 = filterDeliveryFree = dt.delivery_policy
     * 상품명 = filterText
     */
    public function getList($filter = [], $page = 1, $max = 5, $sort = "regdateDesc")
    {
        if (!empty($sort)) {
            list($orderBy, $orderByType) = $this->setOrderby($sort);
        }

        $this->qb->startCache();

        if (empty($filter['filterCid'])) {
            $this->qb
                ->where('basic', '1');
        }

        $this->basicWhere($filter)
            ->from(TBL_SHOP_PRODUCT.' p')
            ->join(TBL_SHOP_PRODUCT_DELIVERY.' as pd', 'p.id=pd.pid', 'inner')
            ->join(TBL_SHOP_DELIVERY_TEMPLATE.' as dt', 'pd.dt_ix=dt.dt_ix', 'inner')
            ->join(TBL_SHOP_PRODUCT_RELATION.' as r', 'p.id=r.pid', 'left');
        $this->qb->stopCache();

        $total = $this->qb->getCount('DISTINCT p.id');

        $paging = $this->qb->setTotalRows($total)->pagination($page, $max);

        $list = $this->qb
            ->distinct()
            ->select('p.id')
            ->orderBy($orderBy, $orderByType)
            ->limit($max, $paging['offset'])
            ->exec()
            ->getResultArray();

        $this->qb->flushCache();

        return [
            'total' => $total,
            'list' => $this->getListById(array_column($list, 'id')),
            'paging' => $paging
        ];
    }
    
    /**
     * 리스트 호출 검색엔진 
     * @param type $filter
     * @param type $page
     * @param type $max
     * @param type $sort
     * @return type
     * 
     * @filter Params
      [filterBrands] => 브랜드
      [filterDeliveryFree] => 배송
      [filterInsideText] =>  결과내검색
      [filterText] => 검색어
     */
    public function getSearchList($filter = [], $page = 1, $max = 5, $sort = "regdateDesc")
    {
        $esResult = [];
        $config = fb_config('elasticsearch');
        $this->elastic_config = $config['conn'];
        $es = (new EsLib\EsLibClient($this->elastic_config))->getHandler();

        $search = ["text" => $filter['filterText'], "firstColumn" => "pid"];
        $searchData = $es->serachProduct($search);

        if (isset($searchData['firstColumn']) && count($searchData['firstColumn']) > 0) {
            $esResult['pid'] = $searchData['firstColumn'];
        } else {
            $esResult['pid'] = [];
        }

        //결과내 검색이 있을 경우
        if (isset($filter['filterInsideText']) && $filter['filterInsideText']) {
            $filter['pid'] = $esResult['pid'];
            $insideSearchData = $es->serachProductInside($filter);
            if (isset($insideSearchData['data']['pid']) && count($insideSearchData['data']['pid']) > 0) {
                $esResult['pid'] = $insideSearchData['data']['pid'];
            } else {
                $esResult['pid'] = [];
            }
        }

        if (count($esResult['pid']) <= 0) {
            $esResult['pid'] = [-1]; //검색없음 처리 방법    
        }




        if (!empty($sort)) {
            list($orderBy, $orderByType) = $this->setOrderby($sort);
        }

        $this->qb->startCache();

        if (empty($filter['filterCid'])) {
            $this->qb
                ->where('basic', '1');
        }


        $this->qb
            ->whereIn('p.mall_ix', ['', MALL_IX])
            ->where('p.is_delete', '0')
            ->where('p.disp', '1')
            ->whereIn('p.state', ['1', '0'])
            ->where("if(p.is_sell_date = '1',p.sell_priod_sdate <= '" . date('Y-m-d H:i:s') . "' and p.sell_priod_edate >= '" . date('Y:m:d H:i:s') . "','1=1')", '', false)
            ->where('p.product_type != ', 77)
            ->from(TBL_SHOP_PRODUCT . ' p')
            ->join(TBL_SHOP_PRODUCT_DELIVERY . ' as pd', 'p.id=pd.pid', 'inner')
            ->join(TBL_SHOP_DELIVERY_TEMPLATE . ' as dt', 'pd.dt_ix=dt.dt_ix', 'inner')
            ->join(TBL_SHOP_PRODUCT_RELATION . ' as r', 'p.id=r.pid', 'left');

        if (isset($esResult['pid']) && count($esResult['pid']) > 0) {
            $this->qb->whereIn("p.id", $esResult['pid']);
        }

        $this->qb->stopCache();

        $total = $this->qb->getCount('DISTINCT p.id');

        $paging = $this->qb->setTotalRows($total)->pagination($page, $max);

        $list = $this->qb
            ->distinct()
            ->select('p.id')
            ->orderBy($orderBy, $orderByType)
            ->limit($max, $paging['offset'])
            ->exec()
            ->getResultArray();

        $this->qb->flushCache();

        return [
            'total' => $total,
            'list' => $this->getListById(array_column($list, 'id')),
            'paging' => $paging
        ];
    }

    /**
     * 검색 엔진 데이터 전체 넣기
     */
    public function putSearchData()
    {
        $config = fb_config('elasticsearch');
        $elastic_config = $config['conn'];
        $esSet = (new EsLib\EsLibClient($elastic_config))->getMappingHandler();
        $index = "product";

        $rows = $this->qb
            ->select('p.id')
            ->select('p.pname')
            ->from(TBL_SHOP_PRODUCT . ' p')
            ->exec()
            ->getResultArray();
        $esSet->base_bluk_data($index, $rows);
    }
    
    /**
     * 검색 엔진 자동완성 데이터 전체 넣기
     */
    public function putAutoSearchData()
    {
        $config = fb_config('elasticsearch');
        $elastic_config = $config['conn'];
        $esSet = (new EsLib\EsLibClient($elastic_config))->getMappingHandler();
        $index = "product_autocomplete";

        $rows = $this->qb
            ->select('p.id')
            ->select('p.pname')
            ->from(TBL_SHOP_PRODUCT . ' p')
            ->exec()
            ->getResultArray();
        $esSet->autocomplete_bluk_data($index, $rows);
    }
    
    public function getAutoSearchList($searchText)
    {
        $config = fb_config('elasticsearch');
        $elastic_config = $config['conn'];
        $es = (new EsLib\EsLibClient($elastic_config))->getHandler();
        $index = "product_autocomplete";
        
        return $es->autoSerachProduct($searchText);
    }

    /**
     * where 세팅
     * @param array $where
     * @return
     */
    protected function setWhere($where)
    {
        if (is_array($where) && !empty($where)) {
            foreach ($where as $k => $v) {
                if (empty($v)) {
                    continue;
                } else {
                    if ($k == 'filterCid') {
                        $depth = $this->getDepth($v);
                        $this->qb->like('r.cid', substr($v, 0, 3 * ($depth + 1)), 'after');
                    } else if ($k == 'filterBrands') {
                        $brands = explode(',', $v);
                        $this->qb->whereIn('p.brand', $brands);
                    } else if ($k == 'filterDeliveryFree') {
                        $this->qb->where('dt.delivery_policy', 1);
                    } else if ($k == 'filterText') {
                        $vReplace = preg_replace("/\s+/", "", $v);
                        $this->qb->groupStart()
                            ->like('p.pname', $v, 'both')
                            ->orWhere("REPLACE(p.pname, ' ', '') LIKE '%{$v}%'")
                            ->orWhere("REPLACE(p.pname, ' ', '') LIKE '%{$vReplace}%'")
                            ->orLike('p.search_keyword', $v, 'both')
                            ->orWhere("REPLACE(p.search_keyword, ' ', '') LIKE '%{$v}%'")
                            ->orWhere("REPLACE(p.search_keyword, ' ', '') LIKE '%{$vReplace}%'")
                            ->groupEnd();
                    } else if ($k == 'filterInsideText') {
                        $this->qb->like('p.pname', $v, 'both');
                    }
                }
            }
        }
        return $this->qb;
    }

    protected function setOrderby($sort)
    {
        switch ($sort) {
            case 'orderCnt':
                return ['p.order_cnt', 'desc'];
                break;
            case 'lowPrice':
                return ['p.sellprice', 'asc'];
                break;
            case 'highPrice':
                return ['p.sellprice', 'desc'];
                break;
            case 'regDate':
                return ['p.regdate', 'desc'];
                break;
        }

        return ['p.regdate_desc', 'asc'];
    }

    /**
     * get 상품아이디로 상품정보 리턴
     * @param array $ids
     * @param string $imageSizeType
     * @param array $addSelect
     * @return string
     */
    public function getListById($ids = [], $imageSizeType = 'm', $addSelect = [])
    {
        if (empty($ids)) {
            return [];
        }

        //추가 select 처리
        if (!empty($addSelect) && is_array($addSelect)) {
            foreach ($addSelect as $select) {
                $this->qb->select($select);
            }
        }

        $list = $this->basicSelect()
            ->select('p.id')
            ->select('p.pname')
            ->select('p.brand_name')
            ->select('p.icons')
            ->from(TBL_SHOP_PRODUCT.' p')
            ->whereIn('p.id', $ids)
            ->exec()
            ->getResultArray();

        if (!empty($list)) {
            /* @var $wishModel CustomMallWishModel */
            $wishModel = $this->import('model.mall.wish');

            //ids 에 넘긴 순서대로 정렬
            $list = $this->sortList($ids, $list, 'id');

            //상품 데이터 처리
            foreach ($list as $key => $li) {
                //이미지
                $li['image_src']  = get_product_images_src($li['id'], $this->isUserAdult, $imageSizeType, $li['is_adult']);
                $li['status']     = $this->setStatus($li['disp'], $li['state'], $li['stock']);
                unset($li['state']);
                unset($li['disp']);
                $li['isDiscount'] = false;
                if ($li['listprice'] > $li['dcprice']) {
                    $li['isDiscount'] = true;
                }
                // 위시 추가 여부
                $li['alreadyWish'] = $wishModel->checkAlreadyWish($li['id']);

                //아이콘
                $icons = [];
                if (!empty($li['icons'])) {
                    $icons_exp = explode(';', $li['icons']);
                    foreach ($icons_exp as $iconsKey => $iconsVal) {
                        $icons[$iconsKey] = "<img src='".IMAGE_SERVER_DOMAIN.MALL_DATA."/images/icon/".$iconsVal.".gif'>";
                    }
                }
                $li['icons'] = $icons;

                $list[$key] = $li;
            }

            //할인 적용
            $list = $this->discount($list);
        }

        return $list;
    }

    /**
     * 상품상세 데이터 출력
     * @param string $id
     * @param string $imageSizeType
     * @return array
     */
    public function get($id, $imageSizeType = 'm')
    {
        /* @var $wishModel CustomMallWishModel */
        $wishModel = $this->import('model.mall.wish');

        $datas = $this->basicSelect()
                ->select('p.id')
                ->select('p.pcode')
                ->select('p.brand')
                ->select('p.admin')
                ->select('p.pname')
                ->select('p.shotinfo')
                ->select('p.brand_name')
                ->select('d.dt_ix')
                ->select('cd.com_name')
                ->select('p.allow_basic_cnt')
                ->select('p.allow_max_cnt')
                ->select('p.allow_byoneperson_cnt')
                ->select('p.basicinfo')
                ->select('p.m_basicinfo')
                ->select('p.mandatory_use')
                ->select('p.reserve_yn')
                ->select('p.wholesale_rate_type')
                ->select('p.reserve')
                ->select('p.reserve_rate')
                ->select('r.cid')
                ->from(TBL_SHOP_PRODUCT.' p')
                ->join(TBL_SHOP_PRODUCT_RELATION.' as r', 'p.id=r.pid', 'inner')
                ->join(TBL_SHOP_PRODUCT_DELIVERY.' as d', 'p.id=d.pid', 'inner')
                ->join(TBL_COMMON_COMPANY_DETAIL.' as cd', 'p.admin = cd.company_id', 'inner')
                ->where('p.id', $id)
                ->where('r.basic', 1)
                ->exec()->getResultArray();

        //상품 데이터 처리
        foreach ($datas as $key => $li) {
            $li['image_src']     = get_product_images_src($li['id'], $this->isUserAdult, $imageSizeType, $li['is_adult']); //이미지
            $li['thumb_src']     = get_product_images_src($li['id'], $this->isUserAdult, 's', $li['is_adult']); // thumb이미지
            $li['add_image_src'] = $this->getAddImagesSrc($li['id'], $li['is_adult']); //추가이미지
            $li['status']        = $this->setStatus($li['disp'], $li['state'], $li['stock']); //판매 상태
            unset($li['state']);
            unset($li['disp']);
            $li['isDiscount']    = false;
            if ($li['listprice'] > $li['dcprice']) {
                $li['isDiscount'] = true;
            }
            // 위시 추가 여부
            $li['alreadyWish'] = $wishModel->checkAlreadyWish($li['id']);

            //묶음 그룹 배송을 사용하는 배송정책의 경우 대표 배송정책으로 변경
            $deliveryGroup = $this->cartModel->getDeliveryGroup(array($li['dt_ix']));
            foreach ($deliveryGroup as $dg) {
                if (!empty($dg['target_dt_ix'])) {
                    $li['dt_ix'] = $dg['target_dt_ix'];
                    break;
                }
            }
            unset($deliveryGroup);

            if (is_mobile()) {
                if (!empty($li['m_basicinfo'])) { //상세정보
                    $li['basicinfo'] = $li['m_basicinfo'];
                }
            }
            unset($li['m_basicinfo']);

            $datas[$key] = $li;
        }

        $datas = $this->discount($datas); //할인 적용

        if (!empty($datas[0])) {
            /* @var $mileageModel CustomMallMileageModel */
            $mileageModel               = $this->import('model.mall.mileage');
            $datas[0]['is_use_reserve'] = $mileageModel->isUseMileage();
            if ($datas[0]['is_use_reserve']) {
                $datas[0]['save_reserve'] = $mileageModel->getSaveMileage(
                    $datas[0]['reserve_yn']
                    , $datas[0]['wholesale_rate_type']
                    , ($datas[0]['wholesale_rate_type'] == '1' ? $datas[0]['reserve_rate'] : $datas[0]['reserve'])
                    , $datas[0]['admin']
                    , $datas[0]['listprice']
                    , $datas[0]['dcprice']
                    , $datas[0]['dcprice']
                );
            } else {
                $datas[0]['save_reserve'] = 0;
            }

            return $datas[0];
        } else {
            return;
        }
    }

    /**
     * get 상품 옵션정보
     * @param int $id 상품ID
     * @param string $returnType all or row
     * @param int $optionId
     * @return array
     */
    public function getOption($id, $returnType = 'all', $optionId = '')
    {
        $options            = [];
        $addOptions         = [];
        $combinationOptions = [];

        if (!empty($optionId)) {
            $this->qb
                ->join(TBL_SHOP_PRODUCT_OPTIONS_DETAIL.' as pod', 'po.opn_ix=pod.opn_ix')
                ->whereIn('pod.id', explode(",", $optionId))
                ->groupBy('po.opn_ix');
        }

        $optionRows = $this->qb
                ->select('po.opn_ix')
                ->select('po.option_kind')
                ->select('po.option_type')
                ->select('po.option_name')
                ->select('p.state as product_state')
                ->from(TBL_SHOP_PRODUCT_OPTIONS.' as po')
                ->join(TBL_SHOP_PRODUCT.' as p', 'po.pid=p.id')
                ->where('po.option_use', '1')
                ->where('po.pid', $id)
                ->orderby('po.option_vieworder', 'asc')
                ->exec()->getResultArray();

        if (!empty($optionRows)) {

            $pinfo = $this->basicSelect()
                    ->from(TBL_SHOP_PRODUCT.' as p')
                    ->where('p.id', $id)
                    ->exec()->getRowArray();

            //옵션 구분
            foreach ($optionRows as $optionsRow) {
                //추가구성상품
                if ($optionsRow['option_kind'] == 'a') {
                    $addOptions[] = [
                        'opn_ix' => $optionsRow['opn_ix']
                        , 'option_name' => $optionsRow['option_name']
                        , 'product_state' => $optionsRow['product_state']
                    ];
                }
                //조합옵션
                else if ($optionsRow['option_kind'] == 'c1') {
                    $combinationOptions[] = [
                        'opn_ix' => $optionsRow['opn_ix']
                        , 'option_kind' => $optionsRow['option_kind']
                        , 'option_name' => $optionsRow['option_name']
                        , 'product_state' => $optionsRow['product_state']
                    ];
                } else {
                    $options[] = [
                        'opn_ix' => $optionsRow['opn_ix']
                        , 'option_kind' => $optionsRow['option_kind']
                        , 'option_type' => $optionsRow['option_type']
                        , 'option_name' => $optionsRow['option_name']
                        , 'product_state' => $optionsRow['product_state']
                    ];
                }
            }

            if (!empty($optionId)) {
                $this->qb->whereIn('pod.id', explode(",", $optionId));
            }

            $optionDetailRows = $this->basicOptionDetailSelect()
                    ->select('pod.id as option_id')
                    ->select('pod.opn_ix')
                    ->select('pod.option_price')
                    ->select('pod.option_div')
                    ->select('pod.option_color')
                    ->select('pod.option_size')
                    ->from(TBL_SHOP_PRODUCT_OPTIONS_DETAIL.' as pod')
                    ->whereIn('pod.opn_ix',
                        array_merge(
                            array_column($options, 'opn_ix')
                            , array_column($addOptions, 'opn_ix')
                            , array_column($combinationOptions, 'opn_ix')
                        )
                    )
                    ->orderby('pod.opn_ix', 'asc')
                    ->orderby('pod.option_seq', 'asc')
                    ->exec()->getResultArray();

            //옵션 상세
            foreach ($optionDetailRows as $optionDetailRow) {

                //추가구성상품
                if (!empty($addOptions)) {
                    //추가 옵션은 할인에서 제외
                    $addOptionKey = array_search($optionDetailRow['opn_ix'], array_column($addOptions, 'opn_ix'));
                    if ($addOptionKey !== false) {
                        $addOptions[$addOptionKey]['optionDetailList'][] = [
                            'option_id' => $optionDetailRow['option_id']
                            , 'option_div' => $optionDetailRow['option_div']
                            , 'option_listprice' => f_decimal($optionDetailRow['option_sellprice'])
                            , 'option_sellprice' => f_decimal($optionDetailRow['option_sellprice'])
                            , 'option_dcprice' => f_decimal($optionDetailRow['option_sellprice'])
                            , 'option_add_price' => f_decimal(0)
                            , 'option_stock' => ($addOptions[$addOptionKey]['product_state'] == '1' ? $optionDetailRow['option_stock'] : 0)
                        ];
                        continue;
                    }
                }

                //조합옵션
                if (!empty($combinationOptions)) {
                    $combinationOptionsKey = array_search($optionDetailRow['opn_ix'], array_column($combinationOptions, 'opn_ix'));
                    if ($combinationOptionsKey !== false) {
                        //조합옵션은 combinationOption 에서 금액, 재고 처리
                        $optionListPrice                                                  = f_decimal($pinfo['listprice']) + f_decimal($optionDetailRow['option_price']);
                        $optionSellPrice                                                  = f_decimal($pinfo['dcprice']) + f_decimal($optionDetailRow['option_price']);
                        $optionDcPrice                                                    = f_decimal($pinfo['dcprice']) + f_decimal($optionDetailRow['option_price']);
                        $combinationOptions[$combinationOptionsKey]['optionDetailList'][] = [
                            'option_id' => $optionDetailRow['option_id']
                            , 'option_div' => $optionDetailRow['option_div']
                            , 'option_listprice' => $optionListPrice
                            , 'option_sellprice' => $optionSellPrice
                            , 'option_dcprice' => $optionDcPrice
                            , 'option_add_price' => $optionDetailRow['option_price']
                            , 'option_stock' => ($combinationOptions[$combinationOptionsKey]['product_state'] == '1' ? 99999 : 0)
                        ];
                        continue;
                    }
                }

                $optionsKey = array_search($optionDetailRow['opn_ix'], array_column($options, 'opn_ix'));
                //조합옵션(독립)일때
                if ($options[$optionsKey]['option_kind'] == 'i1') {
                    $optionListPrice = f_decimal($pinfo['listprice']) + f_decimal($optionDetailRow['option_price']);
                    $optionSellPrice = f_decimal($pinfo['dcprice']) + f_decimal($optionDetailRow['option_price']);
                    $optionDcPrice   = f_decimal($pinfo['dcprice']) + f_decimal($optionDetailRow['option_price']);
                    $discount        = $this->discountCalculation($id, $optionListPrice, $optionDcPrice);
                    $optionDcPrice   = $discount['dcprice'];
                    $optionAddPrice  = $optionDetailRow['option_price'];
                    $optionStock     = ($options[$optionsKey]['product_state'] == '1' ? 99999 : 0);
                } else {
                    $optionListPrice = f_decimal($optionDetailRow['option_listprice']);
                    $optionSellPrice = f_decimal($optionDetailRow['option_sellprice']);
                    $discount        = $this->discountCalculation($id, $optionDetailRow['option_listprice'], $optionDetailRow['option_dcprice']);
                    $optionDcPrice   = $discount['dcprice'];
                    $optionAddPrice  = 0;
                    $optionStock     = ($options[$optionsKey]['product_state'] == '1' ? $optionDetailRow['option_stock'] : 0);
                }
                $optionDiscountAmount = $discount['discount_amount'];
                $optionDiscountRate   = $discount['discount_rate'];
                $optionDiscountList   = $discount['discountList'];

                $division = [];
                if ($options[$optionsKey]['option_type'] == 'o') {
                    $option_div = $optionDetailRow['option_color'].', '.$optionDetailRow['option_size'];
                    $division[] = $optionDetailRow['option_color'];
                    $division[] = $optionDetailRow['option_size'];
                } else if ($options[$optionsKey]['option_type'] == 'c') {
                    $option_div = $optionDetailRow['option_color'];
                    $division[] = $optionDetailRow['option_id'];
                } else if ($options[$optionsKey]['option_type'] == 's') {
                    $option_div = $optionDetailRow['option_size'];
                    $division[] = $optionDetailRow['option_id'];
                } else {
                    $option_div = $optionDetailRow['option_div'];
                    $division[] = $optionDetailRow['option_id'];
                }
                $options[$optionsKey]['optionDetailList'][] = [
                    'option_id' => $optionDetailRow['option_id']
                    , 'option_div' => $option_div
                    , 'option_listprice' => $optionListPrice
                    , 'option_sellprice' => $optionSellPrice
                    , 'option_dcprice' => $optionDcPrice
                    , 'option_add_price' => $optionAddPrice
                    , 'option_discount_amount' => $optionDiscountAmount
                    , 'option_discount_rate' => $optionDiscountRate
                    , 'division' => $division
                    , 'optionDiscountList' => $optionDiscountList
                    , 'option_stock' => $optionStock
                ];
            }
        }

        if (!empty($combinationOptions)) {
            $options     = $this->combinationOption($id, $combinationOptions);
            $viewOptions = $this->compileViewOption($combinationOptions);
        } else if (!empty($options)) {
            $viewOptions = $this->compileViewOption($options);
            $options     = $options[0]['optionDetailList'];
        } else {
            $viewOptions = [];
        }

        if ($returnType == 'row') {

            if (!empty($addOptions)) {
                $options = $addOptions[0]['optionDetailList'];
            }

            $targetOption = ($options[0] ?? []);
            return [
                'option_kind' => ($optionRows[0]['option_kind'] ?? '')
                , 'option_id' => ($targetOption['option_id'] ?? 0)
                , 'option_div' => ($targetOption['option_div'] ?? '')
                , 'option_listprice' => ($targetOption['option_listprice'] ?? 0)
                , 'option_sellprice' => ($targetOption['option_sellprice'] ?? 0)
                , 'option_dcprice' => ($targetOption['option_dcprice'] ?? 0)
                , 'option_add_price' => ($targetOption['option_add_price'] ?? 0)
                , 'option_discount_amount' => ($targetOption['option_discount_amount'] ?? 0)
                , 'option_discount_rate' => ($targetOption['option_discount_rate'] ?? 0)
                , 'optionDiscountList' => ($targetOption['optionDiscountList'] ?? [])
                , 'option_stock' => ($targetOption['option_stock'] ?? 0)
            ];
        } else {
            return ['options' => $options
                , 'viewOptions' => $viewOptions
                , 'addOptions' => $addOptions
            ];
        }
    }

    /**
     * get 상품 구매 수량 조건
     * @param int $id
     * @param string $userCode
     * @return array
     */
    public function getBuyCountCondition($id, $userCode = '')
    {
        if ($this->sellingType == 'W') {
            $this->qb
                ->select('wholesale_allow_basic_cnt as allow_basic_cnt')
                ->select('wholesale_allow_max_cnt as wholesale_allow_max_cnt')
                ->select('wholesale_allow_byoneperson_cnt as allow_byoneperson_cnt');
        } else {
            $this->qb
                ->select('allow_basic_cnt as allow_basic_cnt')
                ->select('allow_max_cnt as allow_max_cnt')
                ->select('allow_byoneperson_cnt as allow_byoneperson_cnt');
        }

        $row = $this->qb
                ->from(TBL_SHOP_PRODUCT.' as p')
                ->where('p.id', $id)
                ->exec()->getRowArray();

        //최소 구매 수량
        $allowBasicCnt       = (!empty($row['allow_basic_cnt']) ? $row['allow_basic_cnt'] : 0);
        //1회 최대 구매 수량
        $allowMaxCnt         = (!empty($row['allow_max_cnt']) ? $row['allow_max_cnt'] : 0);
        //ID당 구매수량
        $allowByOnePersonCnt = (!empty($row['allow_byoneperson_cnt']) ? $row['allow_byoneperson_cnt'] : 0);
        //회원 상품 구매수량
        $userBuyCnt          = 0;

        if ($allowByOnePersonCnt > 0) {
            if (!empty($userCode)) {
                //회원 구매 수량
                $row = $this->qb
                        ->selectSum('od.pcnt')
                        ->from(TBL_SHOP_ORDER.' as o')
                        ->join(TBL_SHOP_ORDER_DETAIL.' as od', 'o.oid=od.oid')
                        ->where('od.pid', $id)
                        ->where('o.user_code', $userCode)
                        ->whereNotIn('od.status',
                            [ORDER_STATUS_SETTLE_READY, ORDER_STATUS_INCOM_BEFORE_CANCEL_COMPLETE, ORDER_STATUS_CANCEL_COMPLETE, ORDER_STATUS_RETURN_COMPLETE])
                        ->exec()->getRowArray();

                if (!empty($row) && !empty($row['pcnt'])) {
                    $userBuyCnt = $row['pcnt'];
                }
            } else {
                //비회원은 구매 할수 없도록
                $userBuyCnt = $allowByOnePersonCnt;
            }
        }
        return ['allow_basic_cnt' => $allowBasicCnt, 'allow_max_cnt' => $allowMaxCnt, 'allow_byoneperson_cnt' => $allowByOnePersonCnt, 'user_buy_cnt' => $userBuyCnt];
    }

    /**
     * 상품 상세 정보 고시 호출
     * @param string $id
     * @return array
     */
    public function getMandatoryInfos($id)
    {
        $datas = $this->qb
                ->select('pmi_title')
                ->select('pmi_desc')
                ->from(TBL_SHOP_PRODUCT_MANDATORY_INFO)
                ->where('pid', $id)
                ->exec()->getResultArray();
        return $datas;
    }

    /**
     * 연관상품 리스트 호출
     * @param string $id
     * @return array
     */
    public function getRelationProducts($id)
    {
        $ids = $this->basicWhere()
                ->select('p.id')
                ->from(TBL_SHOP_PRODUCT.' p')
                ->join(TBL_SHOP_RELATION_PRODUCT.' as r', 'p.id=r.rp_pid', 'left')
                ->where('r.pid', $id)
                ->exec()->getResultArray();

        if (!empty($ids)) {
            $list = $this->getListById(array_column($ids, 'id'));
            return $list;
        } else {
            return;
        }
    }

    /**
     * 기획전 호출
     * @param string $id
     * @return array
     */
    public function getRelationPromotion($id)
    { //기획전만
        $datas = $this->qb
                ->select('e.event_ix')
                ->select('e.event_title')
                ->from(TBL_SHOP_EVENT.' as e ')
                ->join(TBL_SHOP_EVENT_PRODUCT_RELATION.' as ep ', 'e.event_ix=ep.event_ix', 'inner')
                ->where('ep.pid', $id)
                ->where('e.disp', 1)
                ->where('e.kind', 'P')
                ->where(time().' BETWEEN event_use_sdate AND event_use_edate ')
                ->groupBy('e.event_ix')
                ->exec()->getResultArray();
        return $datas;
    }

    /**
     * 할인 정보
     * @param type $productList
     */
    protected function discount($productList)
    {
        //메모리 초기화
        if (count($this->discountData) > 300) {
            $this->discountData = [];
        }

        $ids     = array_column($productList, 'id');
        $saveIds = array_keys($this->discountData);

        // 현재 할인된 상품 리스트에서 조회
        $noIds = array_diff($ids, $saveIds); // $ids - $saveIds
        //discountData 에 상품의 할인 정보가 없다면, 없는 id 들만 추려서 setDiscountData 처리

        if (!empty($noIds)) {
            $noIds = array_unique($noIds);
            $this->setDiscountData($noIds);
        }

        foreach ($productList as $productKey => $product) {
            $productList[$productKey] = array_merge($product, $this->discountCalculation($product['id'], $product['listprice'], $product['dcprice']));
        }

        return $productList;
    }

    /**
     * discountData 데이터에 있는 기준으로 계산
     * @param int $id
     * @param int $listPrice
     * @param int $dcPrice
     * @return array
     */
    protected function discountCalculation($id, $listPrice, $dcPrice)
    {
        $listPrice = f_decimal($listPrice);
        $dcPrice = f_decimal($dcPrice);

        $discountList   = [];

        //즉시 할인
        if ($listPrice > $dcPrice) {
            $discountList[] = [
                'type' => 'IN'
                , 'title' => ForbizConfig::getDiscount('IN')
                , 'discount_amount' => ($listPrice - $dcPrice)
            ];
        }


        // 상품에 관한 할인 정보(멀티)가 있으면, 적용해서 각각의 값을 보유하고 최종적으로
        // 할인 정책중 가장 할인률이 높은 하나를 적용해 준다.
        if (!empty($this->discountData[$id])) {
            $beforeDcPrice = f_decimal(0);
            $__dcPrice = f_decimal(0);
            foreach ($this->discountData[$id] as $discountKey => $data) {

                $lastDiscount = ($discountList[(count($discountList) - 1)] ?? ['type' => '']);

                $data['title'] = ForbizConfig::getDiscount($data['type']);


                if (in_array($data['type'], ['GP', 'SP', 'M']) && $lastDiscount['type'] == $data['type']) {
                    $_dcPrice = $beforeDcPrice;
                } else {
                    $_dcPrice = $dcPrice;
                }


                // 할인률 할인
                if ($data['sale_type'] == '1') { // %
                    $dcPrice            = $this->round($_dcPrice * f_decimal((100 - $data['sale_value']) / 100));
                    $_headofficeDcPrice = $this->round($_dcPrice * f_decimal((100 - $data['headoffice_sale_value']) / 100));

                    // 정액 할인
                } else if ($data['sale_type'] == '2') { // 원
                    $dcPrice            = (($_dcPrice - f_decimal($data['sale_value'])) > 0 ? $_dcPrice - f_decimal($data['sale_value']) : f_decimal(0));
                    $_headofficeDcPrice = (($_dcPrice - f_decimal($data['headoffice_sale_value'])) > 0 ? $_dcPrice - f_decimal($data['headoffice_sale_value']) : f_decimal(0));
                }


                $beforeDcPrice = $_dcPrice;

                $_discountAmount           = $_dcPrice - $dcPrice;
                $_headofficeDiscountAmount = $_dcPrice - $_headofficeDcPrice;

                $data['discount_amount']            = $_discountAmount;
                $data['headoffice_discount_amount'] = $_headofficeDiscountAmount;
                $data['seller_discount_amount']     = $_discountAmount - $_headofficeDiscountAmount;


                //기획&특별&모바일은 %,원 금액중 가장 큰금액으로 할인해 줘야 함
                if (in_array($data['type'], ['GP', 'SP', 'M']) && $lastDiscount['type'] == $data['type']) {
                    if ($lastDiscount['discount_amount'] < $data['discount_amount']) {
                        $discountList[(count($discountList) - 1)] = $data;
                        $__dcPrice = $dcPrice;
                    } else {
                        $dcPrice = $__dcPrice;
                    }
                } else {
                    $discountList[] = $data;
                    $__dcPrice = $dcPrice;
                }
            }
        }

        return [
            'dcprice' => $dcPrice
            , 'discount_amount' => $listPrice - $dcPrice
            , 'discount_rate' => ($listPrice > 0 ? round(($listPrice - $dcPrice) / $listPrice * 100) : 0)
            , 'discountList' => $discountList
        ];
    }

    /**
     * 디스플레이 옵션
     * @param string $id
     * @return array
     */
    public function getDisplayOptions($id)
    {
        return $this->qb
                ->from(TBL_SHOP_PRODUCT_DISPLAYINFO)
                ->where('pid', $id)
                ->exec()->getResultArray();
    }

    /**
     * 판매랭킹 호출(크론으로 랭킹 데이터 설정됨)
     * @param int $limit
     * @param string $cid
     * @return array
     */
    public function getCategoryRanking($limit, $cid = '')
    {
        $this->cidWhere($cid);
        $ids = $this->basicWhere()
                ->select('p.id')
                ->from(' shop_product_ranking as r ')
                ->join(TBL_SHOP_PRODUCT.' as p ', 'p.id=r.pid', 'inner')
                ->orderBy('ranking')
                ->limit($limit)
                ->exec()->getResultArray();

        if (!empty($ids)) {
            $list = $this->getListById(array_column($ids, 'id'));
            return $list;
        } else {
            return array();
        }
    }

    /**
     * 절사
     * @param int $price
     * @return int
     */
    protected function round($price)
    {
        $price = f_decimal($price);
        if($this->discoutRoundPosition > 0){
            $pow = pow(10, $this->discoutRoundPosition);
            switch ($this->discoutRoundType) {
                case 'floor':
                    $price = floor($price / $pow) * $pow;
                    break;
                case 'ceil';
                    $price = ceil($price / $pow) * $pow;
                    break;
                default :
                    $price = round($price / $pow) * $pow;
                    break;
            }
            $price = f_decimal($price);
        } else {
            $places  = $this->discoutRoundPosition * -1;
            switch ($this->discoutRoundType) {
                case 'floor':
                    $price = $price->round($places, $price::ROUND_FLOOR);
                    break;
                case 'ceil';
                    $price = $price->round($places, $price::ROUND_CEILING);
                    break;
                default :
                    $price = $price->round($places);
                    break;
            }
        }
        return $price;
    }

    /**
     * set discountData
     * @param array $ids
     */
    protected function setDiscountData($ids)
    {

        foreach ($ids as $id) {
            $this->discountData[$id] = [];
        }

        //그룹(MG)
        if ($this->discoutMemberGroupSaleRate > 0) {
            foreach ($ids as $id) {
                $this->discountData[$id][] = $this->structureDiscountData('MG', 1, $this->discoutMemberGroupSaleRate,
                        $this->discoutMemberGroupSaleRate, 0, $this->discoutMemberGroupIx);
            }
        }

        //기획&특별&모바일(GP:기획,SP:특별,M:모바일)
        if ($this->discoutMemberGroupIx > 0) {
            $this->qb
                ->join(TBL_SHOP_DISCOUNT_DISPLAY_RELATION.' as ddr', "d.dc_ix = ddr.dc_ix and ddr.relation_type = 'G'", 'left')
                ->groupStart()
                ->where('member_target', 'A')
                ->orGroupStart()
                ->where('member_target', 'G')
                ->where('ddr.r_ix', $this->discoutMemberGroupIx)
                ->groupEnd()
                ->groupEnd();
        } else {
            $this->qb->where('member_target', 'A');
        }

        // 듀이트리 모바일 할인 타입 사용 안함
        /*
          if ($this->agentType == 'M') {
          $this->qb->where('d.discount_type', 'M');
          } else {
          $this->qb->where('d.discount_type !=', 'M');
          }
         */

        $rows = $this->qb
                ->select('dpr.pid')
                ->select('d.discount_type')
                ->select('dpg.dpg_ix')
                ->select('dpg.discount_sale_type')
                ->select('dpg.sale_rate')
                ->select('dpg.headoffice_rate')
                ->select('dpg.seller_rate')
                ->select('dpg.commission')
                ->from(TBL_SHOP_DISCOUNT.' as d')
                ->join(TBL_SHOP_DISCOUNT_PRODUCT_GROUP.' as dpg', 'd.dc_ix = dpg.dc_ix')
                ->join(TBL_SHOP_DISCOUNT_PRODUCT_RELATION.' as dpr', 'd.dc_ix = dpr.dc_ix and dpg.group_code = dpr.group_code')
                ->where('discount_use_sdate <=', time(), false)
                ->where('discount_use_edate >=', time(), false)
                ->where('d.is_use', '1')
                ->where('dpg.is_display', 'Y')
                ->whereIn('dpr.pid', $ids)
                ->orderBy('dpr.pid')
                ->orderBy('d.discount_type')
                ->orderBy('dpg.sale_rate', 'desc')
                ->exec()->getResultArray();

        //group by 가 안되서 for 문으로 처리 ※정렬 중요!!
        //pid, discount_type, discount_sale_type 별로 각가 등록 (원,% 중 실제 할인 금액이 큰건 계산해봐야 알수 있음)
        if (!empty($rows)) {
            $tmp = [];
            foreach ($rows as $row) {
                if (empty($tmp[$row['pid']][$row['discount_type']][$row['discount_sale_type']])) {
                    $this->discountData[$row['pid']][]                                   = $this->structureDiscountData(
                        $row['discount_type'], $row['discount_sale_type']
                        , $row['sale_rate'], $row['headoffice_rate'], $row['seller_rate']
                        , $row['dpg_ix'], $row['commission']
                    );
                    $tmp[$row['pid']][$row['discount_type']][$row['discount_sale_type']] = true;
                }
            }
            unset($tmp);
            unset($rows);
        }

        //APP(APP)
        if ($this->discoutAppSaleRate > 0) {
            foreach ($ids as $id) {
                $this->discountData[$id][] = $this->structureDiscountData('APP', 1, $this->discoutAppSaleRate, $this->discoutAppSaleRate, 0, '');
            }
        }
    }

    /**
     * discountData 구조체
     * @param string $type
     * @param int $saleType 1:%, 2:원
     * @param int $saleValue
     * @param int $headOfficeSaleValue
     * @param int $sellerSaleValue
     * @param string $code
     * @param int $commission
     * @return type
     */
    protected function structureDiscountData($type, $saleType, $saleValue, $headOfficeSaleValue, $sellerSaleValue, $code, $commission = 0,
                                             $description = '')
    {
        return [
            'type' => $type
            , 'sale_type' => $saleType
            , 'sale_value' => $saleValue
            , 'headoffice_sale_value' => $headOfficeSaleValue
            , 'seller_sale_value' => $sellerSaleValue
            , 'code' => $code
            , 'commission' => $commission
            , 'description' => $description
        ];
    }

    /**
     * 옵션 조합
     * @param int $id
     * @param array $options
     * @return array
     */
    protected function combinationOption($id, $options)
    {
        $result = [];
        if (!empty($options)) {
            foreach ($options as $optionKey => $option) {
                $tmp = [];
                foreach ($option['optionDetailList'] as $detail) {
                    if ($optionKey == 0) {
                        $tmp[] = [
                            'option_id' => $detail['option_id']
                            , 'option_div' => $option['option_name'].":".$detail['option_div']
                            , 'option_listprice' => $detail['option_listprice']
                            , 'option_sellprice' => $detail['option_sellprice']
                            , 'option_dcprice' => $detail['option_dcprice']
                            , 'option_stock' => $detail['option_stock']
                            , 'division' => [$detail['option_id']]
                        ];
                    } else {
                        foreach ($result as $r) {
                            $optionIds = explode(",", $r['option_id']);
                            array_push($optionIds, $detail['option_id']);
                            sort($optionIds, SORT_NUMERIC);

                            $division = array_merge($r['division'], [$detail['option_id']]);

                            $tmp[] = [
                                'option_id' => implode(",", $optionIds)
                                , 'option_div' => $r['option_div'].", ".$option['option_name'].":".$detail['option_div']
                                , 'option_listprice' => $r['option_listprice'] + $detail['option_add_price']
                                , 'option_sellprice' => $r['option_sellprice'] + $detail['option_add_price']
                                , 'option_dcprice' => $r['option_dcprice'] + $detail['option_add_price']
                                , 'option_stock' => $detail['option_stock']
                                , 'division' => $division
                            ];
                        }
                    }
                }
                $result = $tmp;
            }

            //금액 관련 처리
            foreach ($result as $key => $r) {
                $discount                    = $this->discountCalculation($id, $r['option_dcprice'], $r['option_dcprice']);
                $r['option_dcprice']         = $discount['dcprice'];
                $r['option_add_price']       = ($r['option_dcprice'] - $r['option_sellprice'] > 0 ? $r['option_dcprice'] - $r['option_sellprice'] : 0);
                $r['option_discount_amount'] = $discount['discount_amount'];
                $r['option_discount_rate']   = $discount['discount_rate'];
                $r['optionDiscountList']     = $discount['discountList'];
                $result[$key] = $r;
            }
        }
        return $result;
    }

    /**
     * 옵션 분리
     * @param array $options
     * @return array
     */
    protected function compileViewOption($options)
    {
        $result = [];
        foreach ($options as $option) {
            $optionName = $option['option_name'];

            $optionDetailList = [];

            //가격+재고옵션이면서 컬러 + 사이즈 타입일때
            if ($option['option_kind'] == 'b' && $option['option_type'] == 'o') {
                $optionName = 'COLOR';

                foreach ($option['optionDetailList'] as $optionsDetail) {
                    $division = $optionsDetail['division'][0];
                    if (array_search($division, array_column($optionDetailList, 'division')) === false) {
                        $optionDetailList[] = [
                            'division' => $division
                            , 'option_div' => $division
                        ];
                    }
                }
                $result[] = [
                    'option_name' => $optionName
                    , 'optionDetailList' => $optionDetailList
                ];

                $optionDetailList = [];
                $optionName       = 'SIZE';
                foreach ($option['optionDetailList'] as $optionsDetail) {
                    $division = $optionsDetail['division'][1];
                    if (array_search($division, array_column($optionDetailList, 'division')) === false) {
                        $optionDetailList[] = [
                            'division' => $division
                            , 'option_div' => $division
                        ];
                    }
                }
            } else {

                foreach ($option['optionDetailList'] as $optionsDetail) {
                    $optionDetailList[] = [
                        'division' => $optionsDetail['option_id']
                        , 'option_div' => $optionsDetail['option_div']
                        , 'option_stock' => $optionsDetail['option_stock']
                    ];
                }
            }

            $result[] = [
                'option_name' => $optionName
                , 'optionDetailList' => $optionDetailList
            ];
        }
        return $result;
    }

    /**
     * $standardArray 기준으로 $targetArray 정렬
     * @param array $standardArray
     * @param array $targetArray
     * @param string $targetKey
     * @return array
     */
    protected function sortList($standardArray, $targetArray, $targetKey)
    {
        $return = [];
        foreach ($standardArray as $value) {
            $return[] = $targetArray[array_search($value, array_column($targetArray, $targetKey))];
        }
        return $return;
    }

    /**
     * 상품 기본 were 조건
     * @return qb
     */
    public function basicWhere($filter = false)
    {
        if ($filter !== false) {
            $this->setWhere($filter);
        }

        return $this->qb
                ->whereIn('p.mall_ix', ['', MALL_IX])
                ->where('p.is_delete', '0')
                ->where('p.disp', '1')
                ->whereIn('p.state', ['1', '0'])
                ->where("if(p.is_sell_date = '1',p.sell_priod_sdate <= '".date('Y-m-d H:i:s')."' and p.sell_priod_edate >= '".date('Y:m:d H:i:s')."','1=1')",
                    '', false)
                ->where('p.product_type != ', 77);
    }

    /**
     * 상품 기본 select
     * @return qb
     */
    public function basicSelect()
    {
        if ($this->sellingType == 'W') {
            //도매
            $this->qb
                ->select('p.wholesale_price as listprice');
            if ($this->displayPriceType == 'L') {
                $this->qb
                    ->select('p.wholesale_price as sellprice')
                    ->select('p.wholesale_price as dcprice');
            } else {
                $this->qb
                    ->select('p.wholesale_sellprice as sellprice')
                    ->select('p.wholesale_sellprice as dcprice');
            }
        } else {
            //소매
            $this->qb
                ->select('p.listprice');
            if ($this->displayPriceType == 'P') {
                $this->qb
                    ->select('p.sellprice')
                    ->select('p.premiumprice as dcprice');
            } else if ($this->displayPriceType == 'L') {
                $this->qb
                    ->select('p.listprice as sellprice')
                    ->select('p.listprice as dcprice');
            } else {
                $this->qb
                    ->select('p.sellprice')
                    ->select('p.sellprice as dcprice');
            }
        }
        return $this->qb
                ->select('p.state')
                ->select('p.disp')
                ->select('p.is_adult')
                ->select('(CASE p.state WHEN "1" THEN '
                    .'(CASE WHEN p.stock_use_yn IN ("Q","Y") THEN '
                    . "(SELECT IF(SUM(IFNULL(pod.option_stock,0)) > SUM(IFNULL(IF(pod.option_sell_ing_cnt > pod.option_stock, pod.option_stock, pod.option_sell_ing_cnt),0)), SUM(IFNULL(pod.option_stock,0)) - SUM(IFNULL(IF(pod.option_sell_ing_cnt > pod.option_stock, pod.option_stock, pod.option_sell_ing_cnt),0)), 0)"
                    ." FROM ".TBL_SHOP_PRODUCT_OPTIONS." as po, ".TBL_SHOP_PRODUCT_OPTIONS_DETAIL." as pod WHERE po.opn_ix = pod.opn_ix AND po.option_use='1' AND pod.option_soldout!='1' AND po.pid=p.id )"
                    .' ELSE 99999 END)'
                    .' ELSE 0 END) AS stock');
    }

    /**
     * 옵션 기본 select
     * @return qb
     */
    protected function basicOptionDetailSelect()
    {
        if ($this->sellingType == 'W') {
            //도매
            $this->qb
                ->select('pod.option_wholesale_listprice as option_listprice');
            if ($this->displayPriceType == 'L') {
                $this->qb
                    ->select('pod.option_wholesale_listprice as option_sellprice')
                    ->select('pod.option_wholesale_listprice as option_dcprice');
            } else {
                $this->qb
                    ->select('pod.option_wholesale_price as option_sellprice')
                    ->select('pod.option_wholesale_price as option_dcprice');
            }
        } else {
            //소매
            $this->qb
                ->select('pod.option_listprice as option_listprice');
            if ($this->displayPriceType == 'P') {
                $this->qb
                    ->select('pod.option_price as option_sellprice')
                    ->select('pod.option_premiumprice as option_dcprice');
            } else if ($this->displayPriceType == 'L') {
                $this->qb
                    ->select('pod.option_listprice as option_sellprice')
                    ->select('pod.option_listprice as option_dcprice');
            } else {
                $this->qb
                    ->select('pod.option_price as option_sellprice')
                    ->select('pod.option_price as option_dcprice');
            }
        }
        return $this->qb->select('(CASE pod.option_soldout WHEN "1" THEN 0'
                .' ELSE IF((IFNULL(pod.option_stock,0) > IFNULL(pod.option_sell_ing_cnt,0)), IFNULL(pod.option_stock,0) - IFNULL(pod.option_sell_ing_cnt,0),0) END) AS option_stock');
    }

    /**
     * 상품 판매상태 설정
     * @param int $disp
     * @param int $state
     * @param int $stock
     * @return string
     */
    protected function setStatus($disp, $state, $stock)
    {
        //상품 상태 sale:판매, soldout:일시품절, stop:판매중지
        if ($disp == '1') {
            if ($state == '1') {
                if ($stock > 0) {
                    $status = 'sale';
                } else {
                    $status = 'soldout';
                }
            } else if ($state == '0') {
                $status = 'soldout';
            } else {
                $status = 'stop';
            }
        } else {
            $status = 'stop';
        }
        return $status;
    }

    /**
     * where 절에 cid 추가
     * @param string $cid
     * @param string $type
     * @return
     */
    protected function cidWhere($cid = '', $type = '')
    {
        if (!empty($cid)) {
            if (is_array($cid) && $type == 'array') {
                $this->qb->whereIn('cid', $cid);
            } else {
                $this->qb->where('cid', $cid);
            }
        }
        return $this->qb;
    }

    /**
     * 추가이미지 호출
     * @param string $id
     * @param boolean $isAdult
     * @return array
     */
    protected function getAddImagesSrc($id, $isAdult = false)
    {
        $addIds = $this->qb
                ->select('*')
                ->from(TBL_SHOP_ADDIMAGE)
                ->where('pid', $id)
                ->exec()->getResultArray();

        $basicPath    = DATA_ROOT."/images/product";
        $basicAddPath = DATA_ROOT."/images/addimg";

        $addImgs = array();
        foreach ($addIds as $k => $v) {

            //19세 상품일때
            if (!$this->isUserAdult && $isAdult) {
                $addImgs[] = IMAGE_SERVER_DOMAIN.$basicPath.'/product_19_200.gif';
                continue;
            }

            $imgDir        = implode("/", str_split(zerofill($id), 2));
            $imageBigSrc   = $basicAddPath.'/'.$imgDir."/b_".zerofill($v['id'], 8)."_add.gif";
            $imageSmallSrc = $basicAddPath.'/'.$imgDir."/m_".zerofill($v['id'], 8)."_add.gif";

            //이미지 없을떄
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].$imageBigSrc)) {
                $addImgs[] = array('bigImg' => $basicPath."/shop/noimg.gif", 'smallImg' => $basicPath."/shop/noimg.gif");
            } else {
                $addImgs[] = array('bigImg' => $imageBigSrc, 'smallImg' => $imageSmallSrc);
            }
        }

        return $addImgs;
    }

    public function addSearchKeywordLog($keyword)
    {

        $this->qb
            ->set('keyword', trim($keyword))
            ->set('regdate', date('Y-m-d H:i:s'))
            ->insert(TBL_SHOP_SEARCH_KEYWORD_LOG)
            ->exec();
    }

    /**
     * 인기검색어
     * @return array
     */
    public function getPopularKeyword($limit = 20, $offset = 0)
    {
        $searchKeyWord = ForbizConfig::getSharedMemory('mobile_search_keyword','0');

        $scIxArray=array();
        for($i=1;$i<=20;$i++){
            if( ! empty($searchKeyWord['code'.($i)])){
                $scIxArray[] = $searchKeyWord['code'.($i)];
            }
        }
        $datas = array();
        if(count($scIxArray)>0){
            $datas = $this->qb
                ->select('keyword')
                ->from(TBL_SHOP_SEARCH_KEYWORD)
                ->where('recommend', '0')
                ->whereIn('k_ix',$scIxArray)
                ->orderBy('searchcnt', 'desc')
                ->limit($limit, $offset)->exec()->getResultArray();
        }

        return $datas;
    }

    /**
     * 최근검색어 세팅
     * @param string $searchText
     * @return
     */
    public function setRecentKeyword($searchText, $max = 10)
    {
        if (empty($searchText)) {
            return;
        } else {
            $recentKeyword = array();
            if (!empty($_COOKIE['recentKeyword'])) {
                $recentKeyword = json_decode(urldecode($_COOKIE['recentKeyword']), true);
                if (!in_array($searchText, $recentKeyword)) {
                    array_unshift($recentKeyword, $searchText);
                }
            } else {
                array_push($recentKeyword, $searchText);
            }
            $recentKeyword = array_slice(array_unique($recentKeyword), 0, $max);
            setcookie("recentKeyword", urlencode(json_encode($recentKeyword)), time() + 180000, "/"); //$HTTP_HOST
            return;
        }
    }

    /**
     * 최근검색어 삭제
     * @param string $searchText
     */
    public function deleteRecentKeyword($searchText)
    {
        $recentKeyword = json_decode(urldecode($_COOKIE['recentKeyword']), true);
        unset($recentKeyword[$searchText]);
        $recentKeyword = array_diff($recentKeyword, array($searchText));
        setcookie("recentKeyword", urlencode(json_encode($recentKeyword)), time() + 180000, "/"); //$HTTP_HOST
        return;
    }

    /**
     * 최근검색어 전체삭제
     * @param string $searchText
     */
    public function deleteAllRecentKeyword()
    {
        $recentKeyword = array();
        setcookie("recentKeyword", urlencode(json_encode($recentKeyword)), time() + 180000, "/"); //$HTTP_HOST
        return;
    }

    /**
     * 최근검색어 리스트 호출
     * @return type
     */
    public function getRecentKeyword($cnt = '')
    {
        if (empty($cnt)) $cnt = 10;

        if (!empty($_COOKIE['recentKeyword'])) {
            $recentKeyword = json_decode(urldecode($_COOKIE['recentKeyword']), true);
            $recentKeyword = array_slice($recentKeyword, 0, $cnt);
            return $recentKeyword;
        } else {
            return;
        }
    }

    /**
     * 최근 본 상품을 추가/갱신 한다.
     * @param string $userCode 회원코드
     * @param string $pid 상품코드
     * @param string $cid 카테고리코드
     * @return boolean | int
     */
    public function replaceProductViewHistory($userCode, $pid, $cid = '')
    {
        if ($pid) {
            $row = $this->qb
                ->select('vh_ix')
                ->select('view_cnt')
                ->from(TBL_SHOP_VIEW_HISTORY)
                ->where('pid', $pid)
                ->where('mem_ix', $userCode)
                ->limit(1)
                ->exec()
                ->getRow();

            $this->qb
                ->set('pid', $pid)
                ->set('cid', $cid)
                ->set('mem_ix', $userCode);

            if (isset($row->vh_ix)) {
                if ($row->view_cnt >= 2) {
                    $this->qb->set('regdate', date('Y-m-d H:i:s'));
                }

                $this->qb
                        ->set('view_cnt', 'view_cnt + 1', false)
                        ->where('vh_ix', $row->vh_ix)
                        ->update(TBL_SHOP_VIEW_HISTORY)
                        ->exec();
            } else {
                $this->qb
                        ->set('regdate', date('Y-m-d H:i:s'))
                        ->insert(TBL_SHOP_VIEW_HISTORY)
                        ->exec();
            }

        } else {
            // 로그인전 최근본 상품 세션 확인
            $viewHistory = sess_val('latest_product_view');
            if (!empty($viewHistory)) {
                foreach ($viewHistory as $pid) {
                    $this->replaceProductViewHistory($this->userInfo->code, $pid, '');
                }

                $_SESSION['latest_product_view'] = [];
            }
        }
    }

    /**
     * 최근 본 상품 데이타
     * @param string $userCode 회원코드
     * @param int $cur_page 현재 페이지 번호
     * @param int $per_page 페이지당 라인수
     * @param boolean $is_paging 페이징 표시 여부
     * @return array
     */
    public function getProductViewHistory($userCode, $cur_page = 1, $per_page = 10, $is_paging = true)
    {
        $this->qb->startCache();
        $this->basicWhere()
            ->select('vh.pid')
            ->from(TBL_SHOP_PRODUCT.' as p')
            ->join(TBL_SHOP_VIEW_HISTORY.' as vh', 'vh.pid = p.id')
            ->where('vh.mem_ix', $userCode)
            ->stopCache();

        // Get total rows
        $total = $this->qb->getCount();

        if ($is_paging) {
            // Get paging data
            $paging = $this->qb
                ->setTotalRows($total)
                ->pagination($cur_page, $per_page);

            $limit  = $per_page;
            $offset = $paging['offset'];
        } else {
            $limit  = $per_page;
            $offset = ($cur_page - 1) * $per_page;
            $paging = false;
        }

        $list = [];
        if ($total > 0) {
            $ids = $this->qb
                ->orderBy('vh.regdate', 'desc')
                ->limit($limit, $offset)
                ->exec()
                ->getResultArray();
        }

        $this->qb->flushCache();

        if ($total > 0) {
            $list = $this->getListById(array_column($ids, 'pid'));
        }

        return [
            'list' => $list,
            'paging' => $paging,
            'pid' => array_column($list, 'id'),
            'total' => $total
        ];
    }

    /**
     * 최근 본 상품 삭제 한다.
     * @param string $userCode 회원코드
     * @param string $pid 상품코드
     * @param string $cid 카테고리코드
     * @return boolean | int
     */
    public function deleteProductViewHistory($param)
    {
        if ($param['mem_ix']) {

            $this->qb->delete(TBL_SHOP_VIEW_HISTORY)
                ->whereIn('pid', $param['pids'])
                ->where('mem_ix', $param['mem_ix'])
                ->exec();
            return;
        }
    }

    /**
     * 상품의 카테고리 Cname 정보
     * @param string $cid
     * @return array
     */
    public function getProductCategoryCnames($cid)
    {
        $catCnames = [];

        $cate = [substr($cid, 0, 3), substr($cid, 0, 6), substr($cid, 0, 12), $cid];

        for ($i = 0; $i < 4; $i++) {
            $row           = $this->qb
                ->select('cname')
                ->from(TBL_SHOP_CATEGORY_INFO)
                ->where('depth', $i)
                ->like('cid', $cate[$i], 'after')
                ->exec()
                ->getRowArray();
            $catCnames[$i] = $row['cname'];
        }

        return $catCnames;
    }
}