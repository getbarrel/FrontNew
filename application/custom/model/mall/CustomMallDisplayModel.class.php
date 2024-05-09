<?php

/**
 * Description of CustomMallCouponModel
 * @author hoksi
 */
class CustomMallDisplayModel extends ForbizMallDisplayModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 최근 클립영상 리스트 출력
     * @return array
     */
    public function getBannerClip()
    {
        $result = $this->qb
            ->select('video_url')
            ->select('SUBSTRING_INDEX(SUBSTRING_INDEX(video_url, "/", 10), "/", -1) AS thumNail')
            ->from('dewytree_video')
            ->where('disp', 1)
            ->orderBy('regdate', 'desc')
            ->limit(1)
            ->exec()
            ->getRowArray();

        return $result;
    }

    /**
     * 최근 공지사항 출력
     * @return array
     */
    public function getNotice()
    {
        $result = $this->qb
            ->select('bbs_ix')
            ->select('bbs_subject')
            ->select('LEFT(regdate, 10) as regdate')
            ->from(TBL_BBS_NOTICE)
            ->orderBY('regdate', 'desc')
            ->limit(1)
            ->exec()
            ->getRowArray();

        return $result;
    }

    public function getPopupList()
    {
        $url = parse_url($this->input->server('REQUEST_URI'));
        $requestUrl = ($url['path'] ?? '');

        //exit;
        $now = date('Y-m-d H:i:s');
        $userCode = sess_val('user', 'code');
        $userGpIx = sess_val('user', 'gp_ix');

        if (in_array($requestUrl, ['', '/', '/index'])) { //메인
            $displayPosition = 'M';
        } else if (strncmp($requestUrl, '/shop/goodsList', 15) === 0) { //상품 리스트
            $displayPosition = 'C';
            $cid = (explode('/', $requestUrl)[4] ?? '');
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
                ->whereIn('p.mall_ix', ['', MALL_IX])
                ->exec()
                ->getResultArray();
    }

    /**
     * 이미지 데이터 출력
     * @param array $data
     * @return array
     */
    public function getMainSubBannerImgs($data)
    {
        $reviewImageFolder = '/images/main';
        if (DIRECTORY_SEPARATOR == '\\') {
            $basicPath = IMAGE_SERVER_DOMAIN . DATA_ROOT .'/' . $reviewImageFolder;
        } else {
            $basicPath = MALL_DATA_PATH . $reviewImageFolder;
        }
        $basicUrl = MALL_DATA . $reviewImageFolder;

        $imgPath = "/" . intval($data['mg_ix']) . "_main_group_" . intval($data['group_code']) . ".gif";

        $imgSize = @getimagesize($basicPath . $imgPath);
        if (isset($imgSize['mime'])) {
            $imgs = @get_img_url($basicUrl . $imgPath);
        }

        return $imgs;
    }

    protected function setOrderby($sort)
    {
        switch ($sort) {
            case 'banner_ix asc':
                return ['banner_ix', 'asc'];
                break;
            case 'banner_ix':
                return ['banner_ix', 'desc'];
                break;
            case 'display_cid':
                return ['display_cid', 'asc'];
                break;
            case 'display_cid':
                return ['display_cid', 'asc'];
                break;
        }

        return ['banner_ix', 'desc'];
    }

    public function getDisplayBannerCount($bannerPosition,$sort='banner_ix',$cid=''){

        $datas = $this->qb
            ->select('banner_ix')
            ->select('banner_kind')
            ->from(TBL_SHOP_BANNERINFO)
            ->whereIn('mall_ix', ['', MALL_IX])
            ->where('banner_position', $bannerPosition)
            ->where('NOW() between use_sdate and use_edate')
            ->where('disp', 1)
            ->orderBy($orderBy, $orderByType)
            ->exec()
            ->getResultArray();

            return $datas;
    }

    public function getDisplayBannerGroup($bannerPosition,$sort='banner_ix',$cid=''){
        if (!empty($sort)) {
            list($orderBy, $orderByType) = $this->setOrderby($sort);
        }

        //기본 정렬을 배너 노출 순서 로 지정
        $this->qb->orderBy('view_order','asc');


        if(!empty($cid)) {
            $this->qb->where('display_cid', $cid);
        }



        $datas = $this->qb
            ->select('banner_ix')
            ->select('banner_kind')
            ->from(TBL_SHOP_BANNERINFO)
            ->whereIn('mall_ix', ['', MALL_IX])
            ->where('banner_position', $bannerPosition)
            ->where('NOW() between use_sdate and use_edate')
            ->where('disp', 1)
            ->orderBy($orderBy, $orderByType)
            ->exec()
            ->getResultArray();

        if(is_array($datas) && count($datas) > 0){

            if(count($datas) > 1){
                foreach($datas as $key => $val){
                    $bannerInfo[$key] = $this->getDisplayBannerInfo($val['banner_ix']);
                }
            }else{
                foreach($datas as $key => $val){
                    if($val['banner_kind'] == 1){
                        $bannerInfo[$key] = $this->getDisplayBannerInfo($val['banner_ix']);
                    }else{
                        $bannerInfo = $this->getDisplayBannerInfo($val['banner_ix']);
                    }
                }
            }

            return $bannerInfo;
        }

    }

    public function getDisplayJournalInfo(){
        $result = $this->qb
            ->select('banner_ix, banner_kind, banner_name')
            ->select('shot_title')
            ->select('banner_img')
            ->select('banner_link')
            ->from('shop_bannerinfo')
            ->where('disp', 1)
            ->where('banner_position', 66)
            //->where('banner_position', 2)
            ->where('NOW() between use_sdate and use_edate')
            ->orderBy('view_order', 'asc')
            ->orderBy('use_sdate', 'asc')
            ->orderBy('use_edate', 'asc')
            ->limit(3)
            ->exec()
            ->getResultArray();

        foreach($result as $key => $val){
            $basicPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/banner/' . $val['banner_ix'] . '/'; //배너이미지 기본 경로
            $result[$key]['imgSrc'] = $basicPath.$val['banner_img'];
        }

        return $result;
    }

    public function getDisplayBannerInfo($bannerIx){
        $basicPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/banner/' . $bannerIx . '/'; //배너이미지 기본 경로

        $details = [];

        $datas = $this->qb
            ->select('b.banner_ix , b.banner_kind , b.banner_name')
            ->from('shop_bannerinfo as b')
            ->where('banner_ix', $bannerIx)
            ->where('disp', 1)
            ->where('NOW() between use_sdate and use_edate')
            ->orderBy('use_sdate', 'asc')
            ->orderBy('use_edate', 'asc')
            ->limit(1)
            ->exec()
            ->getRowArray();
        $bannerKind = $datas['banner_kind'];

        if ($bannerKind == 1) { // 일반배너
            $details = $this->qb
                ->select('b.banner_ix')
                ->select('b.banner_kind')
                ->select('b.banner_loc')
                ->select('change_effect')
                ->select('banner_on_use')
                ->select('shot_title')
                ->select('banner_desc')
                ->select('shot_title_m')
                ->select('banner_desc_m')
                ->select('banner_img')
                ->select('banner_img_on')
                ->select('banner_btn_position')
                ->select('banner_link as bannerLink')
                ->select('banner_target')
                ->select('banner_width')
                ->select('banner_height')
                ->select('disp')
                ->select('b_name')
                ->select('i_name')
                ->select('u_name')
                ->select('c_name')
                ->select('s_name')
                ->select('b_title')
                ->select('i_title')
                ->select('u_title')
                ->select('c_title')
                ->select('s_title')
                ->select('b_desc')
                ->select('i_desc')
                ->select('u_desc')
                ->select('c_desc')
                ->select('s_desc')
                ->select('b_name_m')
                ->select('i_name_m')
                ->select('u_name_m')
                ->select('c_name_m')
                ->select('s_name_m')
                ->select('b_title_m')
                ->select('i_title_m')
                ->select('u_title_m')
                ->select('c_title_m')
                ->select('s_title_m')
                ->select('b_desc_m')
                ->select('i_desc_m')
                ->select('u_desc_m')
                ->select('c_desc_m')
                ->select('s_desc_m')
                ->select('banner_name')
                ->select('banner_name_m')
                ->select('IFNULL(sum(bc.ncnt),0) as ncnt')
				->select('b.banner_text_reversal')
                ->from(TBL_SHOP_BANNERINFO.' as b')
                ->join(TBL_LOGSTORY_BANNER_CLICK.' as bc', 'on b.banner_ix = bc.banner_ix and b.banner_ix = "' . $bannerIx . '"', 'left')
                ->where('b.banner_ix', $bannerIx)
                ->where('disp', 1)
                ->groupBy('b.banner_ix, banner_img,banner_link,banner_target,banner_width,banner_height')
                ->exec()
                ->getRowArray();

            if(count($details) > 0){
                $basicPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/banner/' . $bannerIx . '/'; //배너이미지 기본 경로
                $details['imgSrc'] = $basicPath.$details['banner_img'];
                $details['imgSrcOn'] = $basicPath.$details['banner_img_on'];

            }

        } else if ($bannerKind == 5) { // 사용자지정 배너
            $details = $this->qb
                ->select('b.banner_ix, b.banner_kind, b.use_sdate, b.shot_title,b.banner_desc,b.use_edate, change_effect, banner_img,banner_link,banner_target,
                        banner_width,banner_height,disp,banner_name, bd.*, IFNULL(sum(bc.ncnt),0) as ncnt')
                ->select('concat("' . $basicPath . '", bd.bd_file) as imgSrc, case when bd.bd_link="" or bd_link="#" then bd_link else concat("/bannerLink.php?bannerIx=", b.banner_ix, "&bdIx=", bd_ix) end as bannerLink')
                ->from(TBL_SHOP_BANNERINFO.' as b')
                ->join(TBL_SHOP_BANNERINFO_DETAIL.' as bd', 'b.banner_ix = bd.banner_ix', 'left')
                ->join(TBL_LOGSTORY_BANNER_CLICK.' as bc', 'b.banner_ix = bc.banner_ix and b.banner_ix = "' . $bannerIx . '"', 'left')
                ->where('b.banner_ix', $bannerIx)
                ->where('disp', 1)
                ->groupBy('b.banner_ix, bd.bd_ix, banner_img,banner_link,banner_target,banner_width,banner_height')
                ->orderBy('bd.vieworder')
                ->exec()
                ->getResultArray();
            
                //베너 이미지가 존재하지 않을때 정보 초기화 처리 필요시 사용
//                if(is_array($details)){
//                    foreach($details as $key=>$val){
//                        $basicPath = DOCUMENT_ROOT . DATA_ROOT . '/images/banner/' . $bannerIx . '/'; //배너이미지 기본 경로
//                        $imgSrcPath = $basicPath.$val['banner_img'];
//                        if(!file_exists($imgSrcPath)){
//                            unset($details[$key]);
//                        }
//                    }
//                }
        } else if ($bannerKind == 4){
            $details = $this->qb
                ->select('b.banner_html')
                ->select('b.banner_html_m')
                ->select('b.banner_loc')
                ->select('b.shot_title')
                ->select('b.banner_name')
                ->select('b.banner_desc')
                ->from(TBL_SHOP_BANNERINFO.' as b')
                ->join(TBL_LOGSTORY_BANNER_CLICK.' as bc', 'on b.banner_ix = bc.banner_ix and b.banner_ix = "' . $bannerIx . '"', 'left')
                ->where('b.banner_ix', $bannerIx)
                ->where('disp', 1)
                ->groupBy('b.banner_ix, banner_img,banner_link,banner_target,banner_width,banner_height')
                ->exec()
                ->getResultArray();

        }

        return $details;
    }

    public function getMainDisplayGroup($divCode){
        $lists = $this->getMainDisplayLists($divCode);
        foreach ($lists as $k => $v) {
            $lists[$k]['details'] = $this->getMainDisplayGroupList($v['div_code'], $v['key']);
        }
        return $lists;
    }

    public function getMainDisplayGroupList($divCode, $key = ''){
        $this->qb
            ->select('*')
            ->from(TBL_SHOP_MAIN_PRODUCT_GROUP)
            ->where('use_yn', 'Y')
            ->where('div_code', $divCode)
            ->orderBy('vieworder', 'asc')
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

            $getPromotionBanner = $this->getDisplayBannerGroup($v['banner_position']);

            if($getPromotionBanner){
                $datas[$k]['getPromotionBanner'] = $getPromotionBanner;
            }else{
                $datas[$k]['getPromotionBanner'] = '';
            }
        }

        return $datas;
    }

    public function getMainDisplayGoodsByPaging($key, $groupCode, $limit = '100',$page = 1, $max = 4)
    {

        $this->qb->startCache();

        $this->productModel->basicWhere()
            ->from(TBL_SHOP_PRODUCT . ' as p')
            ->join(TBL_SHOP_MAIN_PRODUCT_RELATION . ' as r', 'p.id=r.pid', 'inner')
            ->where('mg_ix', $key)
            ->where('group_code', $groupCode);
        $this->qb->stopCache();
        $total = $this->qb->getCount('DISTINCT p.id');
        $paging = $this->qb->setTotalRows($total)->pagination($page, $max);
        $ids = $this->qb
            ->distinct()
            ->select('r.pid')
            ->orderBy('r.vieworder', 'asc')
            ->limit($max, $paging['offset'])
            ->exec()
            ->getResultArray();
        $this->qb->flushCache();

        return [
            'total' => $total,
            'list' => $this->productModel->getListById(array_column($ids, 'pid')),
            'paging' => $paging
        ];
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
            ->whereIn('g.mall_ix', ['', MALL_IX])
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

    public function getDisplayBannerByDiv($div_name,$bp_name){
        if(is_mobile()){
            $agent_type = "M";
        }else{
            $agent_type = "W";
        }
        $banner_info = $this->qb
            ->select('bp.bp_ix')
            ->from(TBL_SHOP_BANNER_DIV .' as bd')
            ->join(TBL_SHOP_BANNER_POSITION .' as bp' ,'bd.div_ix = bp.div_ix')
            ->where('bd.div_name',$div_name)
            ->where('bp.bp_name',$bp_name)
            ->where('bd.agent_type',$agent_type)
            ->exec()->getRowArray();

        $bp_ix = $banner_info['bp_ix'];

        return $this->getDisplayBannerGroup($bp_ix);
    }

    //2024년 리뉴얼 신규
    function getContentMain(){
        $result = $this->qb
            ->select('*')
            ->from('shop_content_main')
            ->where('main_use', 'Y')
            ->where('main_default', 'Y')
            ->where('main_start <=', time())
            ->where('main_end >=', time())
            ->orderBy('main_start', 'ASC')
            ->limit(1)
            ->exec()
            ->getRowArray();

        return $result;
    }

    function getContentMainStyleContent($cid, $content_gubun, $conm_ix){
        $result = $this->qb
            ->select('c.cid, c.con_ix, c.list_img, c.display_gubun')
            ->select('c.title, c.title_en, c.b_title, c.i_title, c.u_title, c.c_title, c.s_title')
            ->select('c.preface, c.preface_en, c.b_preface, c.i_preface, c.u_preface, c.c_preface')
            ->select('c.explanation, c.explanation_en, c.b_explanation, c.i_explanation, c.u_explanation, c.c_explanation')
            ->from('shop_content AS c')
            ->join('shop_content_main_content AS cmc' ,'c.con_ix = cmc.con_ix')
            ->like('c.cid', $cid, 'after')
            ->where('content_gubun',$content_gubun)
            ->where('conm_ix',$conm_ix)
            ->where('c.display_use', 'Y')
            ->where('c.display_state', 'D')
            ->where('c.display_start <=', time())
            ->where('c.display_end >=', time())
            ->orderBy('cmc.sort', 'ASC')
            ->exec()->getResultArray();

        foreach($result as $key => $val){
            $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . $val['con_ix'] . '/'; //배너이미지 기본 경로
            $result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
            $result[$key]['title'] = nl2br($val['title']);
            $result[$key]['title_en'] = nl2br($val['title_en']);
            $result[$key]['preface'] = nl2br($val['preface']);
            $result[$key]['preface_en'] = nl2br($val['preface_en']);
            $result[$key]['explanation'] = nl2br($val['explanation']);
            $result[$key]['explanation_en'] = nl2br($val['explanation_en']);
        }

        return $result;
    }

    function getContentMainContent($conm_ix, $content_gubun){
        $result = $this->qb
            ->select('c.con_ix, c.list_img, c.recommend_img, c.display_gubun')
            ->select('c.title, c.title_en, c.b_title, c.i_title, c.u_title, c.c_title, c.s_title')
            ->select('c.preface, c.preface_en, c.b_preface, c.i_preface, c.u_preface, c.c_preface')
            ->select('c.explanation, c.explanation_en, c.b_explanation, c.i_explanation, c.u_explanation, c.c_explanation')
            ->select('c.display_date_use')
			->select('DATE_FORMAT(FROM_UNIXTIME(c.display_start), "%Y-%m-%d") AS startDate, DATE_FORMAT(FROM_UNIXTIME(c.display_end), "%Y-%m-%d") AS endDate')
            ->from('shop_content AS c')
            ->join('shop_content_main_content AS cmc' ,'c.con_ix = cmc.con_ix')
            ->where('cmc.conm_ix',$conm_ix)
            ->where('content_gubun',$content_gubun)
            ->where('c.display_use', 'Y')
            ->where('c.display_state', 'D')
            ->where('c.display_start <=', time())
            ->where('c.display_end >=', time())
            ->orderBy('cmc.sort', 'ASC')
            ->exec()->getResultArray();

        foreach($result as $key => $val){
            $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . $val['con_ix'] . '/'; //배너이미지 기본 경로
            $result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
            $result[$key]['contentRecomImgSrc'] = $contentPath.$val['recommend_img'];
            $result[$key]['title'] = nl2br($val['title']);
            $result[$key]['title_en'] = nl2br($val['title_en']);
            $result[$key]['preface'] = nl2br($val['preface']);
            $result[$key]['preface_en'] = nl2br($val['preface_en']);
            $result[$key]['explanation'] = nl2br($val['explanation']);
            $result[$key]['explanation_en'] = nl2br($val['explanation_en']);
        }

        return $result;
    }

    function getCategoryInfo($bastCate){
        $cateDepth = $this->qb
            ->select('depth')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->where('cid', $bastCate)
            ->exec()
            ->getRowArray();

        return $cateDepth;
    }

    function getBastCateInfo($subCate, $depth){
        $result = $this->qb
            ->select('cid, cname, category_sort')
            ->from(TBL_SHOP_CATEGORY_INFO)
            ->where('depth', $depth+1)
            //->where('category_use', 1)
            ->whereIn('category_use', [1, 2])
            ->like('cid', $subCate, 'after')
            ->orderBy('vlevel'.($depth+2), 'ASC')
            ->exec()
            ->getResultArray();
        return $result;
    }

    function getBastCateProductInfo($cid, $category_sort){
        $depth = $this->getDepth($cid);

        switch ($category_sort) {
            case 'orderCnt':
                $orderBy = "p.order_cnt";
                $orderSort = "desc";
                break;
            case 'lowPrice':
                $orderBy = "p.sellprice";
                $orderSort = "asc";
                break;
            case 'highPrice':
                $orderBy = "p.sellprice";
                $orderSort = "desc";
                break;
            case 'regDate':
                $orderBy = "p.regdate";
                $orderSort = "desc";
                break;
            case 'afterCnt':
                $orderBy = "p.after_cnt";
                $orderSort = "desc";
                break;
            case 'viewOrder':
                $orderBy = "r.sortdepth".$depth;
                $orderSort = "asc";
                break;
            default:
                $orderBy = "p.regdate";
                $orderSort = "desc";
                break;
        }

        $productInfo = $this->qb
            ->select('p.id')
            ->from('shop_product as p')
            ->join('shop_product_relation AS r' ,'r.pid = p.id')
            //->where('r.cid', $cid)
            ->like('r.cid', $cid, 'after')
            ->where('p.disp', 1)
            ->orderBy($orderBy, $orderSort)
            ->orderBy('id', 'DESC')
            ->groupBy('p.id')
            ->limit(10)
            ->exec()
            ->getResultArray();

        return $productInfo;
    }

    function getContentMainGroup($conm_ix){
        $result = $this->qb
            ->select('*')
            ->from('shop_content_main_group_relation')
            ->where('main_group_use', 'Y')
            ->where('main_group_display_start <=', time())
            ->where('main_group_display_end >=', time())
            ->where('conm_ix', $conm_ix)
            ->orderBy('main_group_code', 'ASC')
            ->exec()
            ->getResultArray();

        foreach($result as $key => $val){
            $result[$key]['main_group_title'] = nl2br($val['main_group_title']);
            $result[$key]['main_group_title_en'] = nl2br($val['main_group_title_en']);
            $result[$key]['main_group_explanation'] = nl2br($val['main_group_explanation']);
            $result[$key]['main_group_explanation_en'] = nl2br($val['main_group_explanation_en']);
        }

        return $result;
    }

    function getContentMainGroupRelationPC($cmgr_ix){

        $sql = "SELECT con_ix, title, list_img, group_con_gubun, banner_link, sort, banner_desc, b_name, i_name, u_name, c_name, s_name, b_desc, i_desc, u_desc, c_desc, s_desc, shot_title, b_title, i_title, u_title, c_title, s_title FROM (
				(SELECT c.con_ix, c.title, c.list_img, cmgrc.group_con_gubun, '' as banner_link, cmgrc.sort, 
				'' AS banner_desc, '' AS b_name, '' AS i_name, '' AS u_name, '' AS c_name, '' AS s_name, '' AS b_desc, '' AS i_desc, '' AS u_desc, '' AS c_desc, '' AS s_desc,
				'' AS shot_title, '' AS b_title, '' AS i_title, '' AS u_title, '' AS c_title, '' AS s_title
				FROM 
				shop_content c, 
				shop_content_main_group_content_relation cmgrc 
				WHERE c.con_ix = cmgrc.con_ix AND cmgrc.cmgr_ix = '" . $cmgr_ix . "' AND cmgrc.group_con_gubun = 'S' ORDER BY cmgrc.sort ASC)
				UNION ALL
				(SELECT b.banner_ix as con_ix, b.banner_name as title, b.banner_img as list_img, cmgrc.group_con_gubun, b.banner_link, cmgrc.sort, 
				b.banner_desc, b_name, i_name, u_name, c_name, s_name, b_desc, i_desc, u_desc, c_desc, s_desc, 
				b.shot_title, b_title, i_title, u_title, c_title, s_title 
				FROM 
				shop_bannerinfo b, 
				shop_content_main_group_content_relation cmgrc 
				WHERE b.banner_ix = cmgrc.con_ix AND cmgrc.cmgr_ix = '" . $cmgr_ix . "' AND cmgrc.group_con_gubun = 'B' ORDER BY cmgrc.sort ASC)
			) AS a ORDER BY sort ASC";

        $result = $this->qb->exec($sql)->getResultArray();



        /*$result = $this->qb
            ->select('c.con_ix, c.list_img, cmgcr.group_con_gubun')
            ->from('shop_content c')
            ->join('shop_content_main_group_content_relation AS cmgcr' ,'c.con_ix = cmgcr.con_ix')
            ->where('cmgcr.cmgr_ix', $cmgr_ix)
            ->where('c.display_use', 'Y')
            ->where('c.display_start <=', time())
            ->where('c.display_end >=', time())
            ->orderBy('cmgcr.sort', 'ASC')
            ->exec()
            ->getResultArray();*/
        /*$content = $this->qb
            ->select('c.con_ix, c.list_img, cmgcr.group_con_gubun')
            ->from('shop_content c')
            ->join('shop_content_main_group_content_relation AS cmgcr' ,'c.con_ix = cmgcr.con_ix')
            ->where('cmgcr.cmgr_ix', $cmgr_ix)
            ->where('c.display_use', 'Y')
            ->where('c.display_start <=', time())
            ->where('c.display_end >=', time())


        $result = $this->qb
            ->select('b.banner_ix, b.banner_img, cmgcr.group_con_gubun')
            ->from('shop_banner b')
            ->join('shop_content_main_group_content_relation AS cmgcr' ,'b.banner_ix = cmgcr.con_ix')
            ->where('cmgcr.cmgr_ix', $cmgr_ix)
            ->where('b.display_use', 'Y')
            ->whereBetween(date("Y-m-d H:i:s" , time()), 'b.use_sdate', 'b.use_end')
            ->unionAll($content)
            ->exec()
            ->getResultArray();*/

        foreach($result as $key => $val){
            if($val['group_con_gubun'] == "S"){
                $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . sprintf('%010d',$val['con_ix']) . '/'; //배너이미지 기본 경로
            }else if($val['group_con_gubun'] == "B"){
                $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/banner/' . $val['con_ix'] . '/'; //배너이미지 기본 경로
            }
            $result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
            /*$result[$key]['title'] = nl2br($val['title']);
            $result[$key]['title_en'] = nl2br($val['title_en']);
            $result[$key]['preface'] = nl2br($val['preface']);
            $result[$key]['preface_en'] = nl2br($val['preface_en']);
            $result[$key]['explanation'] = nl2br($val['explanation']);
            $result[$key]['explanation_en'] = nl2br($val['explanation_en']);*/
        }

        return $result;
    }

    function getContentMainGroupRelationMO($cmgr_ix){

        $sql = "SELECT con_ix, title, list_img, list_img_m, group_con_gubun, banner_link, sort, banner_desc, b_name, i_name, u_name, c_name, s_name, b_desc, i_desc, u_desc, c_desc, s_desc, shot_title, b_title, i_title, u_title, c_title, s_title FROM (
				(SELECT c.con_ix, c.title, c.list_img, c.list_img_m, cmgrc.group_con_gubun, '' as banner_link, cmgrc.sort, 
				'' AS banner_desc, '' AS b_name, '' AS i_name, '' AS u_name, '' AS c_name, '' AS s_name, '' AS b_desc, '' AS i_desc, '' AS u_desc, '' AS c_desc, '' AS s_desc,
				'' AS shot_title, '' AS b_title, '' AS i_title, '' AS u_title, '' AS c_title, '' AS s_title
				FROM 
				shop_content c, 
				shop_content_main_group_content_relation cmgrc 
				WHERE c.con_ix = cmgrc.con_ix AND cmgrc.cmgr_ix = '" . $cmgr_ix . "' AND cmgrc.group_con_gubun = 'S' ORDER BY cmgrc.sort ASC)
				UNION ALL
				(SELECT b.banner_ix as con_ix, b.banner_name_m as title, b.banner_img_on as list_img, '' as list_img_m, cmgrc.group_con_gubun, b.banner_link, cmgrc.sort, 
				b.banner_desc_m, b_name_m, i_name_m, u_name_m, c_name_m, s_name_m, b_desc_m, i_desc_m, u_desc_m, c_desc_m, s_desc_m, 
				b.shot_title_m, b_title_m, i_title_m, u_title_m, c_title_m, s_title_m 
				FROM 
				shop_bannerinfo b, 
				shop_content_main_group_content_relation cmgrc 
				WHERE b.banner_ix = cmgrc.con_ix AND cmgrc.cmgr_ix = '" . $cmgr_ix . "' AND cmgrc.group_con_gubun = 'B' ORDER BY cmgrc.sort ASC)
			) AS a ORDER BY sort ASC";

        $result = $this->qb->exec($sql)->getResultArray();



        /*$result = $this->qb
            ->select('c.con_ix, c.list_img, cmgcr.group_con_gubun')
            ->from('shop_content c')
            ->join('shop_content_main_group_content_relation AS cmgcr' ,'c.con_ix = cmgcr.con_ix')
            ->where('cmgcr.cmgr_ix', $cmgr_ix)
            ->where('c.display_use', 'Y')
            ->where('c.display_start <=', time())
            ->where('c.display_end >=', time())
            ->orderBy('cmgcr.sort', 'ASC')
            ->exec()
            ->getResultArray();*/
        /*$content = $this->qb
            ->select('c.con_ix, c.list_img, cmgcr.group_con_gubun')
            ->from('shop_content c')
            ->join('shop_content_main_group_content_relation AS cmgcr' ,'c.con_ix = cmgcr.con_ix')
            ->where('cmgcr.cmgr_ix', $cmgr_ix)
            ->where('c.display_use', 'Y')
            ->where('c.display_start <=', time())
            ->where('c.display_end >=', time())


        $result = $this->qb
            ->select('b.banner_ix, b.banner_img, cmgcr.group_con_gubun')
            ->from('shop_banner b')
            ->join('shop_content_main_group_content_relation AS cmgcr' ,'b.banner_ix = cmgcr.con_ix')
            ->where('cmgcr.cmgr_ix', $cmgr_ix)
            ->where('b.display_use', 'Y')
            ->whereBetween(date("Y-m-d H:i:s" , time()), 'b.use_sdate', 'b.use_end')
            ->unionAll($content)
            ->exec()
            ->getResultArray();*/

        foreach($result as $key => $val){
            if($val['group_con_gubun'] == "S"){
                $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . sprintf('%010d',$val['con_ix']) . '/'; //배너이미지 기본 경로
                if($val['list_img_m'] == ''){
                    $result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
                    $result[$key]['contentImgSrcM'] = $contentPath.$val['list_img'];
                }else{
                    $result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
                    $result[$key]['contentImgSrcM'] = $contentPath.$val['list_img_m'];
                }
            }else if($val['group_con_gubun'] == "B"){
                $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/banner/' . $val['con_ix'] . '/'; //배너이미지 기본 경로
                $result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
                $result[$key]['contentImgSrcM'] = $contentPath.$val['list_img'];
            }
            /*$result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
            $result[$key]['contentImgSrcM'] = $contentPath.$val['list_img_m'];*/
            /*$result[$key]['title'] = nl2br($val['title']);
            $result[$key]['title_en'] = nl2br($val['title_en']);
            $result[$key]['preface'] = nl2br($val['preface']);
            $result[$key]['preface_en'] = nl2br($val['preface_en']);
            $result[$key]['explanation'] = nl2br($val['explanation']);
            $result[$key]['explanation_en'] = nl2br($val['explanation_en']);*/
        }

        return $result;
    }

    function getContentGroupProductRelation($con_ix, $cgr_ix=""){
        $this->qb
            ->select('pid')
            ->from('shop_content_group_product_relation')
            ->where('con_ix', $con_ix);
        if($cgr_ix != ""){
            $this->qb->where('cgr_ix', $cgr_ix);
        }

        $this->qb->orderBy('sort', 'ASC')
            ->limit(10);
        $productInfo = $this->qb->exec()->getResultArray();


        return $productInfo;
    }

    function getContentGroupProductRelationDetail($con_ix, $cgr_ix=""){
        $this->qb
            ->select('cgpr.pid')
            ->from('shop_content_group_product_relation as cgpr')
            ->join(TBL_SHOP_PRODUCT . ' AS p', 'cgpr.pid=p.id', 'inner')
            ->where('cgpr.con_ix', $con_ix)
            ->where('p.disp', 1);
        if($cgr_ix != ""){
            $this->qb->where('cgr_ix', $cgr_ix);
        }

        $this->qb->orderBy('sort', 'ASC');
        $productInfo = $this->qb->exec()->getResultArray();


        return $productInfo;
    }

    function getContentGroupRelation($con_ix){
        $result = $this->qb
            ->select('*')
            ->from('shop_content_group_relation')
            ->where('con_ix', $con_ix)
            ->where('group_use', 'Y')
            ->where('group_display_start <=', time())
            ->where('group_display_end >=', time())
            ->orderBy('group_code', 'ASC')
            ->limit(1)
            ->exec()
            ->getResultArray();

        foreach($result as $key => $val){
            $result[$key]['group_title'] = nl2br($val['group_title']);
            $result[$key]['group_title_en'] = nl2br($val['group_title_en']);
            $result[$key]['group_preface'] = nl2br($val['group_preface']);
            $result[$key]['group_preface_en'] = nl2br($val['group_preface_en']);
            $result[$key]['group_explanation'] = nl2br($val['group_explanation']);
            $result[$key]['group_explanation_en'] = nl2br($val['group_explanation_en']);
        }

        return $result;
    }

    function getDisplayContentClass($cid="",$gubun=""){
        $this->qb
            ->select('*')
            ->from('shop_content_class')
            ->where('content_view', '1')
            ->where('content_use', '1');
            if($cid == ""){
                $this->qb->where('depth', '1');
            }else{
                $this->qb->like('cid', $cid, 'after');
                if($gubun != "S"){
                    $this->qb->where('depth', '2');
                }
            }
            $this->qb->orderBy('cid', 'ASC');

        $result = $this->qb->exec()->getResultArray();

        return $result;
    }

    function getDisplayContentGoodsView($cid){
        $result = $this->qb
            ->select('*')
            ->from('shop_content')
            ->like('cid', $cid, 'after')
            ->where('display_use', 'Y')
            ->where('display_state', 'D')
            ->where('display_start <=', time())
            ->where('display_end >=', time())
            ->orderBy('sort', 'ASC')
            ->exec()
            ->getResultArray();

        foreach($result as $key => $val){
            $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . $val['con_ix'] . '/'; //배너이미지 기본 경로
            $result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
            $result[$key]['title'] = nl2br($val['title']);
            $result[$key]['title_en'] = nl2br($val['title_en']);
            $result[$key]['preface'] = nl2br($val['preface']);
            $result[$key]['preface_en'] = nl2br($val['preface_en']);
            $result[$key]['explanation'] = nl2br($val['explanation']);
            $result[$key]['explanation_en'] = nl2br($val['explanation_en']);
            $result[$key]['display_start'] = date("Y.m.d",$val['display_start']);
            $result[$key]['display_end'] = date("Y.m.d",$val['display_end']);
        }

        return $result;
    }

    function getDisplayContentGoodsRelationId($cid){
        $result = $this->qb
            ->select('c.con_ix')
            ->from('shop_content as c')
            ->join('shop_content_relation AS cr' ,'c.con_ix = cr.con_ix')
            ->where('cr.cid', $cid)
            ->where('c.display_use', 'Y')
            ->where('c.display_state', 'D')
            ->where('c.display_start <=', time())
            ->where('c.display_end >=', time())
            ->orderBy('c.con_ix', 'DESC')
            ->exec()
            ->getResultArray();

        return $result;
    }

    function getDisplayContentGoodsRelationNew($con_ix){

        $sql = "SELECT * FROM shop_content WHERE con_ix IN (".$con_ix.") ORDER BY con_ix DESC";

        $result = $this->qb->exec($sql)->getResultArray();

        foreach($result as $key => $val){
            $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . $val['con_ix'] . '/'; //배너이미지 기본 경로
            $result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
            $result[$key]['title'] = nl2br($val['title']);
            $result[$key]['title_en'] = nl2br($val['title_en']);
            $result[$key]['preface'] = nl2br($val['preface']);
            $result[$key]['preface_en'] = nl2br($val['preface_en']);
            $result[$key]['explanation'] = nl2br($val['explanation']);
            $result[$key]['explanation_en'] = nl2br($val['explanation_en']);
            $result[$key]['display_start'] = date("Y.m.d",$val['display_start']);
            $result[$key]['display_end'] = date("Y.m.d",$val['display_end']);
        }

        return $result;
    }

    function getDisplayContentGoodsRelation($cid){
        $result = $this->qb
            ->select('c.*')
            ->from('shop_content as c')
            ->join('shop_content_relation AS cr' ,'c.con_ix = cr.con_ix')
            ->where('cr.cid', $cid)
            ->where('c.display_use', 'Y')
            ->where('c.display_state', 'D')
            ->where('c.display_start <=', time())
            ->where('c.display_end >=', time())
            ->orderBy('c.con_ix', 'DESC')
            ->exec()
            ->getResultArray();

        foreach($result as $key => $val){
            $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . $val['con_ix'] . '/'; //배너이미지 기본 경로
            $result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
            $result[$key]['title'] = nl2br($val['title']);
            $result[$key]['title_en'] = nl2br($val['title_en']);
            $result[$key]['preface'] = nl2br($val['preface']);
            $result[$key]['preface_en'] = nl2br($val['preface_en']);
            $result[$key]['explanation'] = nl2br($val['explanation']);
            $result[$key]['explanation_en'] = nl2br($val['explanation_en']);
            $result[$key]['display_start'] = date("Y.m.d",$val['display_start']);
            $result[$key]['display_end'] = date("Y.m.d",$val['display_end']);
        }

        return $result;
    }

    function getDisplayContentProductRelationId($cid){
        $result = $this->qb
            ->select('c.con_ix')
            ->from('shop_content as c')
            ->join('shop_content_product_relation AS cpr' ,'c.con_ix = cpr.con_ix')
            ->where('cpr.pid', $cid)
            ->where('c.display_use', 'Y')
            ->where('c.display_state', 'D')
            ->where('c.display_start <=', time())
            ->where('c.display_end >=', time())
            ->orderBy('c.con_ix', 'ASC')
            ->exec()
            ->getResultArray();

        return $result;
    }

    function getDisplayContentProductRelation($cid){
        $result = $this->qb
            ->select('c.*')
            ->from('shop_content as c')
            ->join('shop_content_product_relation AS cpr' ,'c.con_ix = cpr.con_ix')
            ->where('cpr.pid', $cid)
            ->where('c.display_use', 'Y')
            ->where('c.display_state', 'D')
            ->where('c.display_start <=', time())
            ->where('c.display_end >=', time())
            ->orderBy('c.con_ix', 'ASC')
            ->exec()
            ->getResultArray();

        foreach($result as $key => $val){
            $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . $val['con_ix'] . '/'; //배너이미지 기본 경로
            $result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
            $result[$key]['title'] = nl2br($val['title']);
            $result[$key]['title_en'] = nl2br($val['title_en']);
            $result[$key]['preface'] = nl2br($val['preface']);
            $result[$key]['preface_en'] = nl2br($val['preface_en']);
            $result[$key]['explanation'] = nl2br($val['explanation']);
            $result[$key]['explanation_en'] = nl2br($val['explanation_en']);
            $result[$key]['display_start'] = date("Y.m.d",$val['display_start']);
            $result[$key]['display_end'] = date("Y.m.d",$val['display_end']);
        }

        return $result;
    }

    function getDisplayContent($cid, $param=""){
        if (intVal($this->boardConfig['board_max_cnt']) == 0) {
            $perPage = 9;
        } else {
            $perPage = $this->boardConfig['board_max_cnt'];
        }

        $limit = $perPage;

        $this->qb->select("*")
            ->from('shop_content')
            ->like('cid', $cid, 'after')
            ->where('display_use', 'Y')
            ->where('display_state', 'D')
            ->where('display_start <=', time())
            ->where('display_end >=', time());
        $total2 = $this->qb->getCount();

        $total = $total2;

        if(is_mobile()){
            $paging = $this->qb->setTotalRows($total)->pagination($param, $perPage,5);
        }else{
            $paging = $this->qb->setTotalRows($total)->pagination($param, $perPage);
        }

        $offset = $paging['offset'];

        $result['list'] = $this->qb
            ->select('con_ix, cid, depth, company_id, title, preface, b_preface, i_preface, u_preface, c_preface, explanation, list_img, recommend_img, b_title, i_title, u_title, c_title, s_title')
            ->from('shop_content')
            ->like('cid', $cid, 'after')
            ->where('display_use', 'Y')
            ->where('display_state', 'D')
            ->where('display_start <=', time())
            ->where('display_end >=', time())
            ->orderBy('sort', 'ASC')
			->limit($limit, $offset)
            ->exec()
            ->getResultArray();

        foreach($result['list'] as $key => $val){
            $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . $val['con_ix'] . '/'; //배너이미지 기본 경로
            $result['list'][$key]['contentImgSrc'] = $contentPath.$val['list_img'];
            $result['list'][$key]['title'] = nl2br($val['title']);
            $result['list'][$key]['title_en'] = nl2br($val['title_en']);
            $result['list'][$key]['preface'] = nl2br($val['preface']);
            $result['list'][$key]['preface_en'] = nl2br($val['preface_en']);
            $result['list'][$key]['explanation'] = nl2br($val['explanation']);
            $result['list'][$key]['explanation_en'] = nl2br($val['explanation_en']);
            $result['list'][$key]['display_start'] = date("Y.m.d",$val['display_start']);
            $result['list'][$key]['display_end'] = date("Y.m.d",$val['display_end']);
        }
        $total = count($result['list']);


		// array 페이징
        if(intval($param) == '0'){
            $start ='0';
        }else{
            $start = ($param-1) * $perPage;
        }
		
		$result['total'] = $total;
		$result['paging'] = $paging;

        return $result;
    }

    function getDisplayContentList($cid, $param=""){
        if (intVal($this->boardConfig['board_max_cnt']) == 0) {
            $perPage = 12;
        } else {
            $perPage = $this->boardConfig['board_max_cnt'];
        }

        $limit = $perPage;

        $this->qb->select("*")
            ->from('shop_content')
            ->like('cid', $cid, 'after')
            ->where('display_use', 'Y')
            ->where('display_state', 'D')
            ->where('display_start <=', time())
            ->where('display_end >=', time());
        $total2 = $this->qb->getCount();

        $total = $total2;

        if(is_mobile()){
            $paging = $this->qb->setTotalRows($total)->pagination($param, $perPage,5);
        }else{
            $paging = $this->qb->setTotalRows($total)->pagination($param, $perPage);
        }

        $offset = $paging['offset'];

        $result['list'] = $this->qb
            ->select('con_ix, cid, depth, display_gubun, company_id, title, preface, b_preface, i_preface, u_preface, c_preface, explanation, list_img, recommend_img, b_title, i_title, u_title, c_title, s_title, display_date_use, display_start, display_end')
            ->from('shop_content')
            ->like('cid', $cid, 'after')
            ->where('display_use', 'Y')
            ->where('display_state', 'D')
            ->where('display_start <=', time())
            ->where('display_end >=', time())
            ->orderBy('sort', 'ASC')
            ->orderBy('regdate', 'DESC')
			->limit($limit, $offset)
            ->exec()
            ->getResultArray();

        foreach($result['list'] as $key => $val){
            $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . $val['con_ix'] . '/'; //배너이미지 기본 경로
            $result['list'][$key]['contentImgSrc'] = $contentPath.$val['list_img'];
            $result['list'][$key]['title'] = nl2br($val['title']);
            $result['list'][$key]['title_en'] = nl2br($val['title_en']);
            $result['list'][$key]['preface'] = nl2br($val['preface']);
            $result['list'][$key]['preface_en'] = nl2br($val['preface_en']);
            $result['list'][$key]['explanation'] = nl2br($val['explanation']);
            $result['list'][$key]['explanation_en'] = nl2br($val['explanation_en']);
            $result['list'][$key]['display_start'] = date("Y.m.d",$val['display_start']);
            $result['list'][$key]['display_end'] = date("Y.m.d",$val['display_end']);
        }
        $total = count($result['list']);


		// array 페이징
        if(intval($param) == '0'){
            $start ='0';
        }else{
            $start = ($param-1) * $perPage;
        }
		
		$result['total'] = $total;
		$result['paging'] = $paging;

        return $result;
    }

    public function getDisplayContentListMo($orderBy, $orderByType, $page, $max, $cid, $where = [])
    {
        if (!empty($max)) {
            $perPage = $max;
        } else {
            $perPage = 10;
        }

        $this->qb->startCache();

        $this->qb
            ->from('shop_content')
            ->like('cid', $cid, 'after')
            ->where('display_use', 'Y')
            ->where('display_state', 'D')
            ->where('display_start <=', time())
            ->where('display_end >=', time());


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

        $this->qb->orderBy('sort', 'ASC')->orderBy('regdate', 'DESC');

        $list = $this->qb
            ->select('con_ix, cid, depth, display_gubun, company_id, title, preface, b_preface, i_preface, u_preface, c_preface, explanation, list_img, recommend_img, b_title, i_title, u_title, c_title, s_title, display_date_use, display_start, display_end')
            ->select('DATE_FORMAT(FROM_UNIXTIME(display_start), "%Y-%m-%d") AS startDate, DATE_FORMAT(FROM_UNIXTIME(display_end), "%Y-%m-%d") AS endDate')
            ->limit($limit, $offset)
            ->exec()
            ->getResultArray();
        $this->qb->flushCache();

        $domain = (!empty(IMAGE_SERVER_DOMAIN) ? IMAGE_SERVER_DOMAIN : HTTP_PROTOCOL . FORBIZ_HOST );

        $wishModel = $this->import('model.mall.wish');

        foreach ($list as $k => $v) {
            $list[$k]['imgPath'] = $domain . DATA_ROOT ."/images/content/" . $list[$k]['con_ix'] . "/" . $list[$k]['list_img'];

            if($wishModel->checkAlreadyContentWish($list[$k]['con_ix'], 'C')){
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
        }

        return [
            'total' => $total
            , 'list' => $list
            , 'paging' => $paging
        ];
    }

    function getDisplayContentDetail($con_ix, $preview=""){
		if($preview == "preview") {
			$result = $this->qb
				->select('*')
				->from('shop_content')
				->where('con_ix', $con_ix)
				->exec()
				->getRowArray();
		}else{
			$result = $this->qb
				->select('*')
				->from('shop_content')
				->where('con_ix', $con_ix)
				->where('display_use', 'Y')
				->where('display_state', 'D')
				->where('display_start <=', time())
				->where('display_end >=', time())
				->exec()
				->getRowArray();
		}
        return $result;
    }

    function getDisplayContentGroup($con_ix){
        $result = $this->qb
            ->select('*')
            ->from('shop_content_group_relation')
            ->where('con_ix', $con_ix)
            ->where('group_use', 'Y')
            ->where('group_display_start <=', time())
            ->where('group_display_end >=', time())
            ->exec()
            ->getResultArray();

        foreach($result as $key => $val){
            $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . $val['con_ix'] . '/'; //배너이미지 기본 경로
            $result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
            $result[$key]['group_title'] = nl2br($val['group_title']);
            $result[$key]['group_title_en'] = nl2br($val['group_title_en']);
            $result[$key]['group_preface'] = nl2br($val['group_preface']);
            $result[$key]['group_preface_en'] = nl2br($val['group_preface_en']);
            $result[$key]['group_explanation'] = nl2br($val['group_explanation']);
            $result[$key]['group_explanation_en'] = nl2br($val['group_explanation_en']);
            $result[$key]['group_display_start'] = date("Y.m.d",$val['group_display_start']);
            $result[$key]['group_display_end'] = date("Y.m.d",$val['group_display_end']);
        }

        return $result;
    }

    function getDisplayContentGroupContent($cgr_ix){
        $result = $this->qb
            ->select('c.con_ix, c.list_img, c.display_gubun')
            ->select('c.title, c.title_en, c.b_title, c.i_title, c.u_title, c.c_title, c.s_title')
            ->select('c.preface, c.preface_en, c.b_preface, c.i_preface, c.u_preface, c.c_preface')
            ->select('c.explanation, c.explanation_en, c.b_explanation, c.i_explanation, c.u_explanation, c.c_explanation')
            ->from('shop_content AS c')
            ->join('shop_content_group_relation_content AS cgrc' ,'c.con_ix = cgrc.con_ix')
            ->where('cgrc.cgr_ix',$cgr_ix)
            ->where('c.display_use', 'Y')
            ->where('c.display_state', 'D')
            ->where('c.display_start <=', time())
            ->where('c.display_end >=', time())
            ->orderBy('cgrc.sort', 'ASC')
            ->exec()->getResultArray();

        foreach($result as $key => $val){
            $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . $val['con_ix'] . '/'; //배너이미지 기본 경로
            $result[$key]['contentImgSrc'] = $contentPath.$val['list_img'];
            $result[$key]['title'] = nl2br($val['title']);
            $result[$key]['title_en'] = nl2br($val['title_en']);
            $result[$key]['preface'] = nl2br($val['preface']);
            $result[$key]['preface_en'] = nl2br($val['preface_en']);
            $result[$key]['explanation'] = nl2br($val['explanation']);
            $result[$key]['explanation_en'] = nl2br($val['explanation_en']);
        }

        return $result;
    }

    /**
     * depth 계산
     * @param string $cid
     * @return int
     */
    public function getDepth($cid)
    {
        // 상품 최상이 카테고리
        $kind = ForbizConfig::getProductTopKind();
        $cid = $kind[$cid] ?? $cid;

        $depth = 0;
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

    // //2024년 리뉴얼 신규
}
