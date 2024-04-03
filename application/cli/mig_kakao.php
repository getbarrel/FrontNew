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
    protected $mig_tbl = 'common_user';
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
            ->select('replace(id, "@k", "") AS sns_id')
            ->from($this->mig_tbl)
            ->like('id', '@k')
            ->exec()
            ->getResultArray();

        $cnt = [
            'insert' => 0
            , 'update' => 0
        ];


        foreach ($rows as $row) {
            $id = $row['sns_id'];

            // 회원 기본 정보 마이그레이션
            $ret = $this->replaceCommonUser($id, $row);

            if ($ret == 'insert') {
                $cnt['insert']++;
            } else {
                $cnt['update']++;
            }
        }

        var_dump($cnt);
    }

    /**
     * 마이그레이션 롤백
     */
    public function down()
    {
        // common_user table rollback
        $this->rollbackCommonUser();
    }
    /* --------------------------------------------------------------------------------------- */

    /**
     * 메이크샵 날짜를 DB 형식으로 변경
     * @param string $date
     * @return string
     */
    protected function getDate($date)
    {
        return trim(str_replace(['(', ')'], '', $date));
    }

    /**
     * common_user 마이그레이션
     * @param string $userCode
     * @param array $row
     * @return string
     */
    protected function replaceCommonUser($id, $row)
    {
        // 회원정보
        $setting = [
            'uid' => $row['code']
            , 'sns_id' => $id
            , 'sns_type' => 'kakao'
            , 'sns_connect_date' => date('Y-m-d H:i:s', time())
        ];

        // 회원코드로 조회
        $isExists = $this->qb->from('sns_info')->where('sns_id', $id)->where('sns_type', 'kakao')->getCount() > 0;

        // 회원 정보 설정
        $this->qb->set($setting);

        // 회원 정보 있음?
        if ($isExists) {
            // 업데이트
            $mig_mode = 'update';
            $this->qb
                ->where('sns_id', $id)
                ->update('sns_info')
                ->exec();
        } else {
            // 인서트
            $mig_mode = 'insert';
            $this->qb
                ->insert('sns_info')
                ->exec();
        }

        return $mig_mode;
    }

    /**
     * rollback common_user
     */
    protected function rollbackCommonUser()
    {
        // 회원 정보 삭제
        $this->qb
            ->where('sns_type', 'kakao')
            ->whereIn(
                'sns_id',
                $this->qb->startSubQuery()
                    ->select('replace(id, "@k", "") AS id')
                    ->from($this->mig_tbl)
                    ->endSubQuery(), false)
            ->delete('sns_info')
            ->exec();
    }

})->run();
