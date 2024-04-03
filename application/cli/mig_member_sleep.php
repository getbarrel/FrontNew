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
    protected $mig_tbl = 'mig_member_sleep_final';

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
        for($i=0; $i <= 145571; $i++ ){
            $msg .= $this->make_member_code()."\n";
        }

        $file = fopen("/home/barrel/application/cli/usersleepcode.txt","w");
        if(!$file) die("Cannot open the file.");
        fwrite($file, $msg);
        fclose($file);
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
            ->exec()
            ->getResultArray();

        $common_user = [];
        $common_member_detail = [];

        $cnt = [
            'insert' => 0
            , 'update' => 0
        ];


        foreach ($rows as $row) {
            $userCode = $row['Field86'];

            // 회원 기본 정보 마이그레이션
//            $ret = $this->migration($userCode, $row);
            // 회원 상세 정보 마이그레이션
//            $this->migrationDetail($userCode, $row);

                // 마일리지 적립
                $this->setMileage($userCode, $row['Field9']);

            if ($ret == 'insert') {
                // 마일리지 적립
                //$this->setMileage($userCode, $row['Field9']);

                $cnt['insert']++;
            } else {
                $cnt['update']++;
            }
        }

        print_r("\n");
        var_dump($cnt);
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
     * 마이그레이션 롤백
     */
    public function down()
    {
        // common_user table rollback
        $this->rollbackCommonUser();
        // common_member_detail rollback
        $this->rollbackCommonMemberDetail();
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
    protected function migration($userCode, $row)
    {
        // 회원정보
        $common_user = [
            'code' => $userCode // 회원 코드
            , 'id' => trim($row['Field2']) // ID
            //, 'pw' => encrypt_user_password(trim($row['Field53']))
            , 'pw' => trim($row['Field53'])
            , 'mem_type' => $row['Field1'] == '1' ? 'M' : 'F'
            , 'mileage' => $row['Field9']
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
        $isExists = $this->qb->from('common_user_sleep')->where('code', $userCode)->getCount() > 0;

        // 회원 정보 설정
        $this->qb->set($common_user);
        // 회원 정보 있음?
        if ($isExists) {
            // 업데이트
            $mig_mode = 'update';
            $this->qb
                ->where('code', $userCode)
                ->update('common_user_sleep')
                ->exec();
        } else {
            // 인서트
            $mig_mode = 'insert';
            $this->qb
                ->insert('common_user_sleep')
                ->exec();
        }

        return $mig_mode;
    }

    /**
     * 마이그레이션 상세
     * @param string $userCode
     * @param array $row
     */
    protected function migrationDetail($userCode, $row)
    {
        // 회원상세정보
        $common_member_detail = [
            'code' => $userCode
            , 'gp_ix' => $row['Field11']
            , 'birthday' => $row['Field80']
            , 'birthday_div' => '1'
            , 'info' => (trim($row['Field23']) == 'T' ? 1 : 0)
            , 'sms' => (trim($row['Field22']) == 'T' ? 1 : 0)
            , 'sex_div' => (trim($row['Field31']) == 'M' ? 'M' : 'W')
            , 'date' => $this->getDate($row['Field6'])
            , 'nationality' => $row['Field1'] == '1' ? 'O' : 'E'
            , 'di' => md5(str_replace('-', '', trim($row['Field50']))) // 휴대폰번호
            , 'ci' => md5(str_replace('-', '', trim($row['Field51']))) // 이메일
        ];

        // 회원 상세 정보 입력되어 있는지 확인
        $isExists = $this->qb->from('common_member_detail_sleep')->where('code', $userCode)->getCount() > 0;
        // 연락처
        $tel = ($this->migType == 'product' ? trim($row['Field49']) : '010-0000-0000');
        // 휴대폰번호
        $pcs = ($this->migType == 'product' ? trim($row['Field50']) : '010-0000-0000');

        if ($pcs == '') {
            if ($tel != '') {
                $pcs = $tel;
            } else {
                $pcs = '010-0000-0000';
            }
        }

        $row['Field84'] = str_replace("'", "", $row['Field84']);
        $row['Field85'] = str_replace("'", "", $row['Field85']);

        // 상세 정보 설정
        $this->qb
            ->encryptSet('name', trim($row['Field48']))
            ->encryptSet('mail', trim($row['Field51']))
            ->encryptSet('zip', trim($row['Field83']))
            ->encryptSet('addr1', trim($row['Field84']))
            ->encryptSet('addr2', trim($row['Field85']))
            ->encryptSet('tel', $tel)
            ->encryptSet('pcs', $pcs)
            ->set($common_member_detail);

        // 회원 상세 정보 있음?
        if ($isExists) {
            // 업데이트
            $this->qb
                ->where('code', $userCode)
                ->update('common_member_detail_sleep')
                ->exec();
        } else {
            // 인서트
            $this->qb
                ->insert('common_member_detail_sleep')
                ->exec();
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
                    ->select('Field86')
                    ->from($this->mig_tbl)
                    ->endSubQuery(), false)
            ->delete('common_user_sleep')
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
                    ->select('Field86')
                    ->from($this->mig_tbl)
                    ->endSubQuery(), false)
            ->delete('common_member_detail_sleep')
            ->exec();
    }
})->run();
