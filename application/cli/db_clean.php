<?php
// 도메인 변경이 필요할 때 설정함
// define('FORBIZ_BASEURL', 'localhost');

/*
 * Fobiz Framework Load
 */
require_once(__DIR__.'/../../core/framework/ForbizCli.php');

/**
 * @property CustomMallCartModel $cartModel
 */
(new class extends ForbizCli {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo "'{$_SERVER['PHP_SELF']} clean'\n";
    }

    /**
     * 리뷰 마이그레이션
     */
    public function clean($type = 'notice')
    {
        set_time_limit(0);

        if ($type == 'notice') {
            echo "DB를 설정된 초기상태로 되돌립니다.\n";
            echo "초기화 후 되돌릴수 없습니다.\n";
            echo "초기화 전 백업을 확인하십시오.\n\n";
            echo "{$_SERVER['PHP_SELF']} clean [all|inventory|product|order|member|mileage|coupon|account|freegift]\n";
        } elseif ($type == 'all') {
            echo "DB 초기화를 진행 합니다.\n";

            $this->cleanInventory(); // 인벤토리 정리
            $this->cleanProduct(); // 상품 정리
            $this->cleanOrder(); // 주문 정리
            $this->cleanMember(); // 회원 정리
            $this->cleanMileage(); // 회원 마일리지 정리
            $this->cleanCoupon(); // 쿠폰 정리
            $this->cleanAccount(); // 정산 정리
            $this->cleanFreeGift(); // 구매금액별 사은품 정리

            echo "DB 초기화를 완료하였습니다.\n";
        } else {
            switch ($type) {
                case 'inventory':
                    $this->cleanInventory();
                    break;
                case 'product':
                    $this->cleanProduct();
                    break;
                case 'order':
                    $this->cleanOrder();
                    break;
                case 'member':
                    $this->cleanMember();
                    break;
                case 'mileage':
                    $this->cleanMileage();
                    break;
                case 'coupon':
                    $this->cleanCoupon();
                    break;
                case 'account':
                    $this->cleanAccount();
                    break;
                case 'freegift':
                    $this->cleanFreeGift();
                    break;
            }
        }
    }
    ///////////////////////////////////////////////////////////

    /**
     * 테이블 truncate
     * @param array $tbls
     */
    protected function truncate($tbls)
    {
        if (!empty($tbls)) {
            foreach ($tbls as $tbl) {
                echo "Cleaning ... {$tbl}\n";
                $this->qb->exec("TRUNCATE `{$tbl}`");
            }
        }
    }

    /**
     * 지정한 디렉토리 및 파일을 삭제한다.
     * @param type $src
     */
    protected function rrmdir($src)
    {
        $path = realpath(MALL_DATA_PATH.'/'.$src);

        if ($path) {
            echo "'{$path}' Removed!\n";

            if (DIRECTORY_SEPARATOR === '\\') {
                exec(sprintf("rd /s /q %s", escapeshellarg($path)));
            } else {
                exec(sprintf("rm -rf %s", escapeshellarg($path)));
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * 재고관리 정보 정리
     */
    protected function cleanInventory()
    {
        $tbls = [
            'inventory_category_info'
            , 'inventory_company_detail'
            , 'inventory_company_info'
            , 'inventory_config'
            , 'inventory_customer_info'
            , 'inventory_goods'
            , 'inventory_goods_basic_place'
            , 'inventory_goods_item'
            , 'inventory_goods_multi_price'
            , 'inventory_goods_safestock'
            , 'inventory_goods_unit'
            , 'inventory_history'
            , 'inventory_history_detail'
            , 'inventory_info_productorder'
            , 'inventory_order'
            , 'inventory_order_detail'
            , 'inventory_order_detail_tmp'
            , 'inventory_product_stockinfo'
            , 'inventory_product_stockinfo_bydate'
            , 'inventory_warehouse_move'
            , 'inventory_warehouse_move_detail'
        ];

        echo "* 재고관리 테이블\n";
        $this->truncate($tbls);
        // 상품 이미지 삭제
        $this->rrmdir('images/inventory/00');
    }

    /**
     * 상품 정보 정리
     */
    protected function cleanProduct()
    {
        $tbls = [
            'shop_product'
            , 'shop_product_addinfo'
            , 'shop_product_addquestion'
            , 'shop_product_after'
            , 'shop_product_after_comment'
            , 'shop_product_after_like'
            , 'shop_product_auction'
            , 'shop_product_buyingservice_priceinfo'
            , 'shop_product_car'
            , 'shop_product_delivery'
            , 'shop_product_displayinfo'
            , 'shop_product_edit_history'
            , 'shop_product_gift'
            , 'shop_product_history'
            , 'shop_product_hotel'
            , 'shop_product_image_check'
            , 'shop_product_level'
            , 'shop_product_localdelivery_detail'
            , 'shop_product_mandatory_info'
            , 'shop_product_mult_rate'
            , 'shop_product_notice'
            , 'shop_product_options'
            , 'shop_product_options_detail'
            , 'shop_product_options_detail_temp'
            , 'shop_product_options_detail_tmp'
            , 'shop_product_options_temp'
            , 'shop_product_options_tmp'
            , 'shop_product_photo'
            , 'shop_product_point'
            , 'shop_product_property'
            , 'shop_product_qna'
            , 'shop_product_qna2'
            , 'shop_product_qna_comment'
            , 'shop_product_qna_div'
            , 'shop_product_ranking'
            , 'shop_product_region_delivery'
            , 'shop_product_relation'
            , 'shop_product_set_relation'
            , 'shop_product_sightseeing'
            , 'shop_product_standard_relation'
            , 'shop_product_state_history'
            , 'shop_product_stock_reminder'
            , 'shop_product_style'
            , 'shop_product_subs_senddetail'
            , 'shop_product_temp'
            , 'shop_product_viralinfo'
        ];

        echo "* 상품관리 테이블\n";

        // 테이블 비우기
        $this->truncate($tbls);
        // 상품 이미지 삭제
        $this->rrmdir('images/product/00');
    }

    protected function cleanFreeGift()
    {
        $tbls = [
            'shop_freegift'
            , 'shop_freegift_display_relation'
            , 'shop_freegift_product_group'
            , 'shop_freegift_product_relation'
        ];

        echo "* 구매금액별 사은품 테이블\n";
        $this->truncate($tbls);
    }

    /**
     * 주문 정보 정리
     */
    protected function cleanOrder()
    {
        $tbls = [
            'shop_order'
            , 'shop_order_claim_delivery'
            , 'shop_order_delivery'
            , 'shop_order_detail'
            , 'shop_order_detail_deliveryinfo'
            , 'shop_order_detail_discount'
            , 'shop_order_excel_ex_info'
            , 'shop_order_excel_template'
            , 'shop_order_gift'
            , 'shop_order_goodsflow_response'
            , 'shop_order_goodsflow_status'
            , 'shop_order_manual_log'
            , 'shop_order_memo'
            , 'shop_order_payment'
            , 'shop_order_price'
            , 'shop_order_price_history'
            , 'shop_order_session'
            , 'shop_order_set'
            , 'shop_order_siteinfo'
            , 'shop_order_status'
            , 'shop_order_unreceived_claim'
        ];

        echo "* 주문관리 테이블\n";
        $this->truncate($tbls);
    }

    /**
     * 회원 정보 정리
     */
    protected function cleanMember()
    {
        echo "* 회원정보 테이블 정리\n";
        $this->qb->exec("DELETE FROM `common_member_detail` WHERE `code` IN (SELECT `code` FROM `common_user` WHERE `mem_type` != 'A')");
        echo "* 회원상세정보 테이블 정리\n";
        $this->qb->exec("DELETE FROM `common_user` WHERE `mem_type` != 'A'");

        // SNS연동 정보 삭제
        $this->truncate(['sns_info']);
    }

    /**
     * 회원 마일리지 정리
     */
    protected function cleanMileage()
    {
        $tbls = [
            'shop_add_mileage'
            , 'shop_mileage_log'
            , 'shop_remove_mileage'
            , 'shop_use_mileage'
        ];

        echo "* 마일리지 테이블\n";
        $this->truncate($tbls);

        echo "* 회원 마일리지 리셋\n";
        $this->qb
            ->set('mileage', 0)
            ->where('mem_type', 'A')
            ->update(TBL_COMMON_USER);
    }

    /**
     * 쿠폰 정리
     */
    protected function cleanCoupon()
    {
        $tbls = [
            'shop_cupon'
            , 'shop_cupon_publish'
            , 'shop_cupon_publish_config'
            , 'shop_cupon_publish_tmp'
            , 'shop_cupon_regist'
            , 'shop_cupon_relation_brand'
            , 'shop_cupon_relation_category'
            , 'shop_cupon_relation_group'
            , 'shop_cupon_relation_product'
            , 'shop_cupon_relation_seller'
            , 'shop_gift_certificate_cupon'
            , 'shop_offline_cupon'
        ];

        echo "* 쿠폰 테이블\n";
        $this->truncate($tbls);
    }

    /**
     * 정산정보 정리
     */
    protected function cleanAccount()
    {
        $tbls = [
            'shop_accounts_remittance'
            , 'shop_accounts_add_price'
            , 'shop_accounts'
        ];

        echo "* 정산정보 정리\n";
        $this->truncate($tbls);
    }
})->run();

