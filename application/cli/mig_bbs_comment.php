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
    protected $mig_tbl = 'mig_bbs_comment_190812';
    protected $migType = 'develop';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        echo ' bbs_comment ';


        /*
        // 코멘트의 게시물번호 매칭
        $rows = $this->qb
            ->select('Field1')
            ->select('Field2')
            ->select('Field3')
            ->from($this->mig_tbl)
            ->where('Field14', '1')
            //->where('Field15 is null')
            ->where('Field15=""')
            ->exec()
            ->getResultArray();

        foreach ($rows as $row) {
            $data = $this->qb
                ->select('Field2')
                ->from('mig_bbs_190717')
                ->where('Field1', $row['Field2'])
                ->where('Field3', $row['Field1'])
                ->exec()
                ->getRowArray();

            if ($data) {
                $this->qb
                    ->where('Field3', $row['Field3'])
                    ->update($this->mig_tbl)
                    ->set('Field15', $data['Field2'])
                    ->exec();
            }
        }
        */

        $this->up();
    }

    /**
     * 마이그레이션 처리
     */
    public function up()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        // 마이그레이션 데이터 조회
        $rows = $this->qb
            ->select('*')
            ->from($this->mig_tbl)
            ->where('Field14', '1')
            ->where('Field1', '8')
            ->exec()
            ->getResultArray();

        $cnt = [
            'insert' => 0
            , 'update' => 0
        ];

        foreach ($rows as $row) {
            /*
             * 글로벌 통합후기 게시판은 크리마 연동안하기때문에 마이그레이션 해야된다.
            6 = Qna (shop_product_qna)
            8 = 포토갤러리 (bbs_premium_after)
            22 = 배럴 티처 멤버 모집
            101 = 이용문의
             */
            if ($row['Field1'] == '6') {
                $ret = $this->bbs($row, TBL_SHOP_PRODUCT_QNA_COMMENT);
            } else if ($row['Field1'] == '8') {
                $ret = $this->bbs($row, 'bbs_premium_after_comment');
            } else if ($row['Field1'] == '22') {
                $ret = $this->bbs($row, 'bbs_teacher_comment');
            } else if ($row['Field1'] == '101') {
                $ret = $this->bbs($row, 'bbs_contact_comment');
            }

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
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $rows = $this->qb
            ->select('*')
            ->from($this->mig_tbl)
            ->where('Field14', '1')
            ->exec()
            ->getResultArray();

        foreach ($rows as $row) {
            if ($row['Field15']) { //매칭된 게시물번호 체크
                if ($row['Field1'] == 6) { //상품 QNA
                    $this->rollback(TBL_SHOP_PRODUCT_QNA_COMMENT, $row);
                } else if ($row['Field1'] == 8) { //포토후기 게시판
                    $this->rollback('bbs_premium_after', $row);
                } else if ($row['Field1'] == 22) { //배럴티처멤버모집
                    $this->rollback('bbs_teacher', $row);
                } else if ($row['Field1'] == 101) { //이용문의
                    $this->rollback('bbs_contact', $row);
                }
            }
        }
    }
    /* --------------------------------------------------------------------------------------- */


    /**
     * 마이그레이션
     * @param array $row
     * @return string
     */
    protected function bbs($row, $table)
    {
        if ($row['Field1'] == 6) {//상품 QNA
            $table = TBL_SHOP_PRODUCT_QNA_COMMENT;
            $parentTable = TBL_SHOP_PRODUCT_QNA;
            $selBbs = $this->selBbs($parentTable, $row['Field15']);
            $bbs_ix = $selBbs->bbs_ix;
        } else if ($row['Field1'] == 8) { //포토후기 게시판
            $table = 'bbs_premium_after_comment';
            $parentTable = 'bbs_premium_after';
            $selBbs = $this->selBbs($parentTable, $row['Field15']);
            $bbs_ix = $selBbs->bbs_ix;
        } else if ($row['Field1'] == 22) { //배럴 티처 게시판
            $table = 'bbs_teacher_comment';
            $parentTable = 'bbs_teacher';
            $selBbs = $this->selBbs($parentTable, $row['Field15']);
            $bbs_ix = $selBbs->bbs_ix;
        } else if ($row['Field1'] == 101) { //이용문의 게시판
            $table = 'bbs_contact_comment';
            $parentTable = 'bbs_contact';
            $selBbs = $this->selBbs($parentTable, $row['Field15']);
            $bbs_ix = $selBbs->bbs_ix;
        }

        if ($bbs_ix) {
            if ($row['Field1'] == 6) { //상품 QNA 셋팅
                $setting = [
                    'bbs_ix' => $bbs_ix
                    , 'mem_ix' => trim($selBbs->member_ix)
                    , 'cmt_name' => trim($row['Field5'])
                    , 'cmt_contents' => $row['Field4']
                    , 'cmt_ip_addr' => trim($row['Field9'])
                    , 'regdate' => trim($row['Field8'])
                ];
            } else { // 그외 게시판
                $setting = [
                    'bbs_ix' => $bbs_ix
                    , 'mem_ix' => trim($selBbs->member_ix)
                    , 'cmt_name' => trim($row['Field5'])
                    , 'cmt_pass' => trim($row['Field13'])
                    , 'cmt_contents' => $row['Field4']
                    , 'cmt_ip_addr' => trim($row['Field9'])
                    , 'regdate' => trim($row['Field8'])
                ];
            }

            $this->qb->set($setting);

            $mig_mode = 'insert';
            $this->qb
                ->insert($table)
                ->exec();

            $this->qb
                ->where('bbs_ix', $bbs_ix)
                ->update($parentTable)
                ->set('bbs_re_cnt', 'bbs_re_cnt+1')
                ->exec();
        }

        return $mig_mode;
    }

    /**
     * 게시판 롤백
     * @param $table
     * @param $row
     */
    protected function rollback($table, $row)
    {
        $this->qb
            ->whereIn('co_no', $row['Field1'])
            ->delete($table)
            ->exec();
    }

    /**
     * 조회
     * @param $table
     * @param $no
     * @return mixed
     */
    protected function selBbs($table, $no)
    {
        if ($table == TBL_SHOP_PRODUCT_QNA) {
            $this->qb
                ->select('ucode');
        } else {
            $this->qb
                ->select('mem_ix');
        }

        $data = $this->qb
            ->select('bbs_ix')
            ->from($table)
            ->where('co_no', $no)
            ->exec()
            ->getRow();
        return $data;
    }
})->run();
