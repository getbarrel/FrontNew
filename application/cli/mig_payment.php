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
(new class extends ForbizCli
{
    protected $mig_tbl = 'member_payment_info1030';
    protected $mileageModel;
    protected $memberModel;
    protected $migType = 'develop'; // 'develop' or 'product'

    public function __construct()
    {
        parent::__construct();

        /* @var $memberModel CustomMallMemberModel */
        $this->memberModel = $this->import('model.mall.member');
    }

    public function index()
    {
        echo "'{$_SERVER['PHP_SELF']} up'\n";
    }

    /**
     * 마이그레이션 진행
     */
    public function up()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        // 마이그레이션 데이터 조회
        $rows = $this->qb
            ->select('*')
            ->from($this->mig_tbl)
            ->limit('100')
            ->exec()
            ->getResultArray();

        $cnt = [
            'insert' => 0
            , 'update' => 0
        ];


        foreach ($rows as $row) {
            $ret = $this->paymentUser($row);

            if ($ret == 'insert') {
                $cnt['insert']++;
            } else {
                $cnt['update']++;
            }
        }

        var_dump($cnt);
    }

    /* --------------------------------------------------------------------------------------- */

    protected function paymentUser($row)
    {
        // 회원정보
        $setting = [
            'id' => $row['id']
            , 'price' => $row['price']
            , 'mall_ix' => $row['mall_ix']
        ];

        // 회원코드로 조회
        $isExists = $this->qb->from('common_user')->where('id', $row['id'])->where('mall_ix', $row['mall_ix'])->getCount() > 0;

        // 회원 정보 설정
        $this->qb->set($setting);

        // 회원 정보 있음?
        if ($isExists) {
            // 업데이트
            $mig_mode = 'update';

            $result_code = $this->qb
                ->select('code')
                ->from('common_user')
                ->where('id', $id)
				->where('mall_ix', $row['mall_ix'])
                ->exec()
                ->getRowArray();

	        $result_price = $this->qb
                ->select('price')
                ->from('member_payment_info1030')
                ->where('id', $id)
	            ->where('mall_ix', $row['mall_ix'])
                ->exec()
                ->getRowArray();

            $this->qb
                ->where('id', $id)
                ->set('code', $result_code['code'])
				->set('price', $result_price['price']+$row['price'])
                ->set('decimal_price', $result_price['price']+$row['price'])
                ->update('member_payment_info10300')
                ->exec();
        } else {
            // 인서트
            $mig_mode = 'insert';
            $this->qb
                ->insert('member_payment_info10300')
                ->exec();
        }

        return $mig_mode;
    }

})->run();