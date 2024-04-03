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
    protected $mig_tbl = 'mig_member_zipcode_final';
    protected $gp_ix = [
        'V.VIP' => 4
        , '옐로우 서퍼' => 1
        , '실버 서퍼' => 21
        , '브론즈 서퍼' => 20
        , '블루 서퍼' => 19
        , '배럴 서퍼' => 23
        , '골드 서퍼' => 22
        , '그린 서퍼' => 18
        , '카페24대량메일테스트' => 25
        , 'Ten percent' => 8
        , 'BARREL EMPLOYEE' => 47
        , '코스메틱 서포터즈' => 46
        , 'BARREL TEACHERS' => 43
    ];

    protected $migType = 'develop'; // 'develop' or 'product'

    public function __construct()
    {
        parent::__construct();
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
            ->where("Field3 != ''")
            ->where("Field4 != ''")
            ->where("Field5 != ''")
            ->where("Field1 = '1'")
			->orderby('Field6', 'asc')
            ->exec()
            ->getResultArray();

        $cnt = [
            'insert' => 0
            , 'update' => 0
        ];


        foreach ($rows as $key => $row) {
            // 회원 기본 정보 마이그레이션
            $ret = $this->commonUser($row);
			syslog(1, '['.$key.']'. $ret.' - '.$row['Field6']);
            if ($ret == 'insert') {

                $cnt['insert']++;
            } else {
                $cnt['update']++;
            }
        }

        var_dump($cnt);
    }
    /* --------------------------------------------------------------------------------------- */

    /**
     * common_user 마이그레이션
     * @param string $userCode
     * @param array $row
     * @return string
     */
    protected function commonUser($row)
    {
        // 회원정보
        $selMig = $this->selMigMember($row['Field6']);
        $selData = $this->selCommonUser($row['Field6']);
        $userCode = $selData->code;

        // 회원코드로 조회
        $isExists = $this->qb->from('common_member_detail')->where('code', $userCode)->getCount() > 0;

        $row['Field5'] = str_replace("'", "", trim($row['Field5']));

        // 회원 정보 설정
        $this->qb
            ->encryptSet('zip', (trim($row['Field3']) ?? ''))
            ->encryptSet('addr1', (trim($row['Field4']) ?? ''))
            ->encryptSet('addr2', ($row['Field5'] ?? ''))
            ->encryptSet('tel', trim($selMig->Field49))
            ->encryptSet('pcs', trim($selMig->Field50));
        // 회원 정보 있음?
        if ($isExists) {
            // 업데이트
            $mig_mode = 'update';
            $this->qb
                ->where('code', $userCode)
                ->update('common_member_detail')
                ->exec();
        }

        return $mig_mode;
    }

    protected function selMigMember($id)
    {
        $data = $this->qb
            ->select('Field49')
            ->select('Field50')
            ->from('mig_member_final')
            ->where('Field2', $id)
            ->exec()
            ->getRow();

        return $data;
    }

    protected function selCommonUser($id)
    {
        $data = $this->qb
            ->select('code')
            ->from('common_user')
            ->where('id', $id)
            ->exec()
            ->getRow();

        return $data;
    }
})->run();
