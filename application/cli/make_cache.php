<?php
// 도메인 변경이 필요할 때 설정함
// define('FORBIZ_BASEURL', 'localhost');

/*
 * Fobiz Framework Load
 */
require_once(__DIR__ . '/../../core/framework/ForbizCli.php');

/**
 * @property CustomMallCartModel $cartModel
 */
(new class extends ForbizCli {
    /**
     * 캐시 유지 시간
     * @var type
     */
    protected $ttl = 86400; // 1Day

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo 'Category : ' . ($this->cate() === true ? 'Created!' : 'Fail') . "\n";
        echo 'EnCategory : ' . ($this->enCate() === true ? 'Created!' : 'Fail') . "\n";
        echo 'BannerGroup : ' . ($this->bannerGroup() === true ? 'Created!' : 'Fail') . "\n";
        echo 'PrivacyConfig : ' . ($this->privacyConfig() === true ? 'Created!' : 'Fail') . "\n";
        echo 'MallConfig : ' . ($this->mallConfig() === true ? 'Created!' : 'Fail') . "\n";
        echo 'PaymentConfig : ' . ($this->paymentConfig() === true ? 'Created!' : 'Fail') . "\n";

    }

    public function all(){
        $this->cate();
        $this->enCate();
        $this->bannerGroup();
        $this->privacyConfig();
        $this->mallConfig();
        $this->paymentConfig();
    }

    public function cate()
    {
        /* @var $productModel CustomMallProductModel */
        $productModel = getForbiz()->import('model.mall.product');

        //카테고리
        $largeCateData = $productModel->getLargeCategoryList();

        if (is_array($largeCateData)) {
            foreach ($largeCateData as $key => $largeCate) {
                $largeCateData[$key]['subCateList'] = $productModel->getCategorySubList($largeCate['cid']);
                if (is_array($largeCateData[$key]['subCateList'])) {
                    foreach ($largeCateData[$key]['subCateList'] as $key2 => $smallCate) {
                        $largeCateData[$key]['subCateList'][$key2]['subCateList'] = $productModel->getCategorySubList($smallCate['cid']);
                    }
                }
            }
        }

        return fb_set('largeCateData', $largeCateData, 86400 * 365); // 라이프 타임 1Day
    }


    public function enCate()
    {
        /* @var $productModel CustomMallProductModel */
        $productModel = getForbiz()->import('model.mall.product');

        //카테고리
        $largeCateData = $productModel->getLargeEnCategoryList();

        if (is_array($largeCateData)) {
            foreach ($largeCateData as $key => $largeCate) {
                $largeCateData[$key]['subCateList'] = $productModel->getEnCategorySubList($largeCate['cid']);
                if (is_array($largeCateData[$key]['subCateList'])) {
                    foreach ($largeCateData[$key]['subCateList'] as $key2 => $smallCate) {
                        $largeCateData[$key]['subCateList'][$key2]['subCateList'] = $productModel->getEnCategorySubList($smallCate['cid']);
                    }
                }
            }
        }

        return fb_set('largeEnCateData', $largeCateData, 86400 * 365); // 라이프 타임 1Day
    }

    public function bannerGroup(){
        /* @var $displayModel CustomMallDisplayModel */
        $displayModel = getForbiz()->import('model.mall.display');

        $bannerPosition10    = $displayModel->getDisplayBannerGroup(10, 'banner_ix asc');
        $bannerPosition11 = $displayModel->getDisplayBannerGroup(11, 'banner_ix asc');
        $bannerPosition57 = $displayModel->getDisplayBannerGroup(57, 'banner_ix asc');

        $bannerPosition61 = $displayModel->getDisplayBannerGroup(61);
        $bannerPosition62 = $displayModel->getDisplayBannerGroup(62);

        fb_set('bannerPosition10', $bannerPosition10, 86400 * 365); // 라이프 타임 1Day
        fb_set('bannerPosition11', $bannerPosition11, 86400 * 365); // 라이프 타임 1Day
        fb_set('bannerPosition57', $bannerPosition57, 86400 * 365); // 라이프 타임 1Day
        fb_set('bannerPosition61', $bannerPosition61, 86400 * 365); // 라이프 타임 1Day
        fb_set('bannerPosition62', $bannerPosition62, 86400 * 365); // 라이프 타임 1Day

        return true;
    }

    public function privacyConfig(){
        $data = null;
        if ($data === null) {
            $row = getForbiz()->qb
                ->select('config_name')
                ->select('config_value')
                ->from(TBL_SHOP_MALL_PRIVACY_SETTING)
                ->where('mall_ix', MALL_IX)
                ->exec()
                ->getResultArray();

            $data = [];
            foreach ($row as $item) {
                switch ($item['config_name']) {
                    case 'pw_combi':
                    case 'pw_continuous_check':
                    case 'pw_same_check':
                        $data[$item['config_name']] = json_decode($item['config_value'], true);
                        break;
                    default:
                        $data[$item['config_name']] = $item['config_value'];
                        break;
                }
            }
        }

        return fb_set('getPrivacyConfig', $data, 86400 * 365); // 라이프 타임 1Day
    }

    public function mallConfig(){
        $data = [];

        $rows = getForbiz()->qb
            ->select('config_value')
            ->select('config_name')
            ->from(TBL_SHOP_MALL_CONFIG)
            ->where('mall_ix', MALL_IX)
            ->exec()
            ->getResultArray();

        if(is_array($rows)){
            foreach($rows as $val){
                $data[$val['config_name']] = $val['config_value'] ?? '';
            }
        }

        return fb_set('getMallConfig', $data, 86400 * 365); // 라이프 타임 1Day

    }

    public function paymentConfig(){
        $data = [];

        $rows = getForbiz()->qb
            ->select('config_value')
            ->select('pg_code')
            ->select('config_name')
            ->from(TBL_SHOP_PAYMENT_CONFIG)
            ->where('mall_ix', MALL_IX)
            ->exec()
            ->getResultArray();

        if(is_array($rows)){
            foreach($rows as $val){
                $data[$val['pg_code']][$val['config_name']] = $val['config_value'] ?? '';
            }
        }

        return fb_set('getPaymentConfig', $data, 86400 * 365); // 라이프 타임 1Day


    }
})->run();