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
    protected $mig_tbl = 'mig_member_final';
    protected $mig_tbl2 = 'mig_member_detail_final';
    /*
    protected $gp_ix = [
        //기존 고객 등급
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

        //글로벌
        'Green Surfers' => 37
        ,'Yellow Surfers' => 11
        ,'Silver Surfers' => 40
        ,'Gold Surfers' => 41
        ,'Blue Surfers' => 38
        ,'Barrel Surfers' => 42
        ,'Bronze Surfers' => 39
    ];
    */
    protected $gp_ix = [
        '옐로우서퍼' => 1
        , '그린서퍼' => 2
        , '블루서퍼' => 3
        , '브론즈서퍼' => 10
        , '실버서퍼' => 4
        , '골드서퍼' => 6
        , '배럴서퍼' => 7
        , '배럴티처' => 8
        , '셀러' => 9
        , '비회원' => 12
        , 'BARREL EMPLOYEE' => 14
    ];
    protected $gp_ix_global = [
        '옐로우서퍼' => 15
        , '그린서퍼' => 16
        , '블루서퍼' => 17
        , '브론즈서퍼' => 22
        , '실버서퍼' => 18
        , '골드서퍼' => 19
        , '배럴서퍼' => 20
        , '배럴티처' => 22
    ];
    protected $mileageModel;
    protected $memberModel;
    protected $migType = 'develop'; // 'develop' or 'product'

    public function __construct()
    {
        parent::__construct();

        /* @var $mileageModel CustomMallMileageModel */
        $this->mileageModel = $this->import('model.mall.mileage');

        /* @var $memberModel CustomMallMemberModel */
        $this->memberModel = $this->import('model.mall.member');
    }

    public function index()
    {
        echo "'{$_SERVER['PHP_SELF']} makeUserCode'\n";
        echo "'{$_SERVER['PHP_SELF']} up'\n";
    }

    function make_member_code()
    {
        srand(time());
        return md5(uniqid(rand()));
    }

    public function makeUserCode()
    {
        $msg = "";
        for($i=0; $i <= 165471; $i++ ){
            $msg .= $this->make_member_code()."\n";
        }

        $file = fopen("/home/barrel/application/cli/usercode.txt","w");
        if(!$file) die("Cannot open the file.");
        fwrite($file, $msg);
        fclose($file);


        /*
        $rows = $this->qb
            ->select('Field1')
            ->select('Field2')
            ->select('Field48')
            ->from($this->mig_tbl)
            ->whereIn('Field1', [1, 2])
            ->exec()
            ->getResultArray();

        foreach ($rows as $row) {
            $userCode = $this->make_member_code();

            $this->qb
                ->set('Field83', $userCode)
                ->update($this->mig_tbl)
                ->where('Field1', $row['Field1'])
                ->where('Field2', $row['Field2'])
                ->where('Field48', $row['Field48'])
                ->exec();
        }
        */
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
            ->whereIn('Field1', [1, 2])
            ->exec()
            ->getResultArray();

        $cnt = [
            'insert' => 0
            , 'update' => 0
        ];


        foreach ($rows as $row) {
            $userCode = $row['Field83'];

            // 회원 기본 정보 마이그레이션
            $ret = $this->replaceCommonUser($userCode, $row);
            // 회원 상세 정보 마이그레이션
            $this->replaceCommonMemberDetail($userCode, $row);

            if ($ret == 'insert') {
                // 마일리지 적립
                $this->setMileage($userCode, $row['Field9']);

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
        // common_member_detail rollback
        $this->rollbackCommonMemberDetail();
        // 마일리지 롤백
        $this->rollbackMileage();
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
    protected function replaceCommonUser($userCode, $row)
    {
        // 회원정보
        $common_user = [
            'code' => $userCode // 회원 코드
            , 'id' => trim($row['Field2']) // ID
            , 'pw' => trim($row['Field53'])
            , 'mem_type' => $row['Field1'] == '1' ? 'M' : 'F'
            //, 'mileage' => $row['Field9']
            , 'mem_div' => 'D'
            , 'date' => $this->getDate($row['Field6']) // 등록일
            , 'regdate_desc' => (strtotime($this->getDate($row['Field6'])) * -1) // 등록일 역정렬 코드
            , 'visit' => 1
            , 'last' => $this->getDate($row['Field7']) // 최근 방문일
            , 'ip' => trim($row['Field81'])
            , 'company_id' => ''
            , 'authorized' => 'Y'
            , 'auth' => 0
            , 'is_id_auth' => 'Y'
            , 'is_pos_link' => 'N'
            , 'join_status' => 'I'
            , 'request_info' => 'M'
            , 'request_yn' => 'Y'
            , 'request_date' => date('Y-m-d H:i:s')
            , 'change_pw_date' => date('Y-m-d H:i:s')
            , 'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36'
            , 'agent_type' => trim($row['Field40']) == 'm' ? 'M' : 'W'
            , 'language' => $row['Field1'] == '1' ? 'korean' : 'english'
            , 'mall_ix' => $row['Field1'] == '1' ? '20bd04dac38084b2bafdd6d78cd596b1' : '20bd04dac38084b2bafdd6d78cd596b2'
        ];

        // 회원코드로 조회
        $isExists = $this->qb->from(TBL_COMMON_USER)->where('code', $userCode)->getCount() > 0;

        // 회원 정보 설정
        $this->qb->set($common_user);

        // 회원 정보 있음?
        if ($isExists) {
            // 업데이트
            $mig_mode = 'update';
            $this->qb
                ->where('code', $userCode)
                ->update(TBL_COMMON_USER)
                ->exec();
        } else {
            // 인서트
            $mig_mode = 'insert';
            $this->qb
                ->insert(TBL_COMMON_USER)
                ->exec();
        }

        return $mig_mode;
    }

    /**
     * common_member_detail 마이그레이션
     * @param string $userCode
     * @param array $row
     */
    protected function replaceCommonMemberDetail($userCode, $row)
    {
        if ($row['Field1'] == 1) { //국내
            //'V.VIP' => 4
            //, '카페24대량메일테스트' => 25
            //, 'Ten percent' => 8
            //, '코스메틱 서포터즈' => 46
            if ($row['Field11'] == 1) {
                $gp_ix = 1;
            } else if ($row['Field11'] == 21) {
                $gp_ix = 4;
            } else if ($row['Field11'] == 20) {
                $gp_ix = 10;
            } else if ($row['Field11'] == 19) {
                $gp_ix = 3;
            } else if ($row['Field11'] == 23) {
                $gp_ix = 7;
            } else if ($row['Field11'] == 22) {
                $gp_ix = 6;
            } else if ($row['Field11'] == 18) {
                $gp_ix = 2;
            } else if ($row['Field11'] == 43) {
                $gp_ix = 8;
            } else if ($row['Field11'] == 47) {
                $gp_ix = 14;
            }
        } else { //글로벌
            if ($row['Field11'] == 37) {
                $gp_ix = 16;
            } else if ($row['Field11'] == 11) {
                $gp_ix = 15;
            } else if ($row['Field11'] == 40) {
                $gp_ix = 18;
            } else if ($row['Field11'] == 41) {
                $gp_ix = 19;
            } else if ($row['Field11'] == 38) {
                $gp_ix = 17;
            } else if ($row['Field11'] == 42) {
                $gp_ix = 20;
            } else if ($row['Field11'] == 39) {
                $gp_ix = 22;
            }
        }

        // 회원상세정보
        $common_member_detail = [
            'code' => $userCode
            , 'gp_ix' => $gp_ix
            , 'birthday' => $row['Field80']
            , 'birthday_div' => '1'
            , 'info' => (trim($row['Field23']) == 'T' ? 1 : 0)
            , 'sms' => (trim($row['Field22']) == 'T' ? 1 : 0)
            , 'sex_div' => (trim($row['Field31']) == 'M' ? 'M' : 'W')
            , 'date' => $this->getDate($row['Field6'])
            , 'nationality' => $row['Field1'] == '1' ? 'O' : 'E'
        ];

        // 회원 상세 정보 입력되어 있는지 확인
        $isExists = $this->qb->from(TBL_COMMON_MEMBER_DETAIL)->where('code', $userCode)->getCount() > 0;

        $detail = $this->qb
            ->select('Field3')
            ->select('Field4')
            ->select('Field5')
            ->from($this->mig_tbl2)
            ->where('Field6', $userCode)
            ->exec()
            ->getRow();
        if ($detail) {
            $this->qb
                ->encryptSet('zip', trim($detail->sField3))
                ->encryptSet('addr1', trim($detail->sField4))
                ->encryptSet('addr2', trim($detail->sField5));
        }

        $row['Field48'] = str_replace("'", "", $row['Field48']);

        // 상세 정보 설정
        $this->qb
            ->encryptSet('name', trim($row['Field48']))
            ->encryptSet('mail', trim($row['Field51']))
            ->encryptSet('tel', trim($row['Field49']))
            ->encryptSet('pcs', trim($row['Field50']))
            ->set($common_member_detail);

        // 회원 상세 정보 있음?
        if ($isExists) {
            // 업데이트
            $this->qb
                ->where('code', $userCode)
                ->update(TBL_COMMON_MEMBER_DETAIL)
                ->exec();
        } else {
            // 인서트
            $this->qb
                ->insert(TBL_COMMON_MEMBER_DETAIL)
                ->exec();
        }
    }

    /**
     * 마일리지 마이그레이션
     * @param string $userCode
     * @param string $mileage
     */
    protected function setMileage($userCode, $mileage)
    {
        // 마일리지
        $mileage = (int)trim($mileage);

        // 마일리지 있고 회원정보 인서트?
        if ($mileage > 0) {
            // 마일리지 적립
            $this->mileageModel
                ->setMember($userCode, $this->gp_ix, 'Y')
                ->addMileage($mileage, 7, '회원 이전에 따른 적립');
        }
    }

    /**
     * rollback common_user
     */
    protected function rollbackCommonUser()
    {
        // 회원 정보 삭제
        $this->qb
            ->whereIn(
                'code',
                $this->qb->startSubQuery()
                    ->select('Field83')
                    ->from($this->mig_tbl)
                    ->endSubQuery(), false)
            ->delete(TBL_COMMON_USER)
            ->exec();
    }

    /**
     * rollback common_member_detail
     */
    protected function rollbackCommonMemberDetail()
    {
        // 회원 상세 정보 삭제
        $this->qb
            ->whereIn(
                'code',
                $this->qb->startSubQuery()
                    ->select('Field83')
                    ->from($this->mig_tbl)
                    ->endSubQuery(), false)
            ->delete(TBL_COMMON_MEMBER_DETAIL)
            ->exec();
    }

    /**
     * rollback 마일리지
     */
    protected function rollbackMileage()
    {
        // 마일리지 삭제
        $this->qb
            ->whereIn(
                'uid',
                $this->qb->startSubQuery()
                    ->select('Field83')
                    ->from($this->mig_tbl)
                    ->endSubQuery(), false)
            ->delete(TBL_SHOP_USE_MILEAGE)
            ->exec();

        $this->qb
            ->whereIn(
                'uid',
                $this->qb->startSubQuery()
                    ->select('Field83')
                    ->from($this->mig_tbl)
                    ->endSubQuery(), false)
            ->delete(TBL_SHOP_REMOVE_MILEAGE)
            ->exec();

        $this->qb
            ->whereIn(
                'uid',
                $this->qb->startSubQuery()
                    ->select('Field83')
                    ->from($this->mig_tbl)
                    ->endSubQuery(), false)
            ->delete(TBL_SHOP_MILEAGE_LOG)
            ->exec();

        $this->qb
            ->whereIn(
                'uid',
                $this->qb->startSubQuery()
                    ->select('Field83')
                    ->from($this->mig_tbl)
                    ->endSubQuery(), false)
            ->delete(TBL_SHOP_ADD_MILEAGE)
            ->exec();

        $this->qb
            ->set('mileage', '0')
            ->update('common_user')
            ->exec();
    }
})->run();
