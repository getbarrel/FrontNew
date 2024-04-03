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
    protected $mig_tbl = 'mig_bbs_final';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo "'{$_SERVER['PHP_SELF']} up'\n";
    }

    /**
     * 마이그레이션 테이블 조회
     * @return array
     */
    public function selMig()
    {
        $rows = $this->qb
            ->select('*')
            ->from($this->mig_tbl)
            //->where('FIELD27=2 AND FIELD3 IN (9) AND FIELD13=""')//글로벌댓글
            //->where('FIELD27=2 AND FIELD3 IN (9)') 글로벌
            //->where('FIELD27=2 AND FIELD3 IN (4)')
            //->where('FIELD27=1 AND FIELD3 IN (23,1001,22,6,101,9,8,27)')
            //->where('((FIELD27=1 AND FIELD3 IN (23,1001,22,6,101,9,8,27)) OR (FIELD27=2 AND FIELD3 IN (4, 6, 9)))')

            //->where('field3', [23, 1001, 22, 6, 101, 9, 8, 27])
            //->whereIn('field27', [1, 2])

            //->like('field12', 'socal')
            //->where('(FIELD10 LIKE \'%barrel%\' OR FIELD10 LIKE \'%socal%\')')
            ->orderBy('Field1', 'asc')
            ->exec()
            ->getResultArray();

        return $rows;
    }

    /**
     * 마이그레이션 처리
     */
    public function up()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        // 마이그레이션 데이터 조회
        $rows = $this->selMig();

        $cnt = [
            'insert' => 0
            , 'update' => 0
        ];

        foreach ($rows as $row) {
            //Field3
            /*
            4 = 통합후기 (bbs_after 이용후기보기) (shop_bbs_useafter 사용후기보기) (bbs_premium_after 프리미엄구매후기)
            6 = Qna (shop_product_qna)
            8 = 포토갤러리 (bbs_premium_after)
            9 = 1:1문의 (bbs_qna)
            101 = 이용문의
            1002 = z제휴문의
            22 = 배럴 티처 멤버 모집
            27 = 온라인 접수
            3 = FAQ (bbs_faq)
            1 = 공지사항 (bbs_notice)
            23 = 공시 (기업공시?)
            24 = 공고 (기업공고)
            25 = IR자료
            1001 = 	배럴 스프린트 챔피언십 응원의 메시지

            - 사용할 게시판
            통합후기 게시판   4 (국내:크리마, 글로벌:자체)
            상품 Q&A   6 (국내+글로벌)
            1:1 맞춤상담   9
            배럴 티처 멤버 모집   22
            공시   23(숫자는 게시판 아이디 입니다)
            온라인 접수 27
            이용문의게시판   101
            배럴 스프린트 챔피언십 응원의 메시지   1001
             */


            //코멘트만
            if (
                ($row['Field3'] != '8' && $row['Field10'] == 'socal') ||
                (($row['Field3'] != '1' && $row['Field3'] != '23' && $row['Field3'] != '24' && $row['Field3'] != '25') && ($row['Field10'] == 'barrel' || $row['Field10'] == 'BARREL')) ||
                $row['Field10'] == 'BARREL_CS'
            ) {

				/*
                if ($row['Field3'] == '4' && $row['Field27'] == '2') { //국내는 크리마, 글로벌만
                    $this->bbsComment($row, 'shop_product_after_comment');
                } else if ($row['Field3'] == '6') {
                    $this->bbsComment($row, 'shop_product_qna_comment');
                } else if ($row['Field3'] == '8') {
                    if ($row['Field27'] == '2') {
                        $this->bbsComment($row, 'bbs_premium_after_global_comment');
                    } else {
                        $this->bbsComment($row, 'bbs_premium_after_comment');
                    }
                } else if ($row['Field3'] == '9') {
                    if ($row['Field27'] == '2') {
                        $this->bbsComment($row, 'bbs_qna_global_comment');
                    } else {
                        $this->bbsComment($row, 'bbs_qna_comment');
                    }
                } else if ($row['Field3'] == '23') {
                    if ($row['Field27'] == '2') {
                        $this->bbsComment($row, 'bbs_disclosure_global_comment');
                    } else {
                        $this->bbsComment($row, 'bbs_disclosure_comment');
                    }
                } else if ($row['Field3'] == '1001') {
                    $this->bbsComment($row, 'bbs_sprint_comment');
                } else if ($row['Field3'] == '101') {
                    $this->bbsComment($row, 'bbs_contact_comment');
                } else if ($row['Field3'] == '22') {
                    $this->bbsComment($row, 'bbs_teacher_comment');
                } else if ($row['Field3'] == '24') {
                    $this->bbsComment($row, 'bbs_announce_comment');
                } else if ($row['Field3'] == '25') {
                    $this->bbsComment($row, 'bbs_ir_comment');
                } else if ($row['Field3'] == '27') {
                    $this->bbsComment($row, 'bbs_online_comment');
                }

				*/


            } else {


                /*
                if ($row['Field3'] == '1') {
                    if ($row['Field27'] == '2') {
                        $ret = $this->bbs($row, 'bbs_notice_global');
                    } else {
                        $ret = $this->bbs($row, 'bbs_notice');
                    }
                } else if ($row['Field3'] == '4' && $row['Field27'] == '2') { //국내는 크리마, 글로벌만
                    $ret = $this->bbs($row, 'shop_product_after');
                } else if ($row['Field3'] == '6') {
                    $ret = $this->bbs($row, 'shop_product_qna');
                } else if ($row['Field3'] == '8') {
                    if ($row['Field27'] == '2') {
                        $ret = $this->bbs($row, 'bbs_premium_after_global');
                    } else {
                        $ret = $this->bbs($row, 'bbs_premium_after');
                    }
                } else if ($row['Field3'] == '9') {
                    if ($row['Field27'] == '2') {
                        $ret = $this->bbs($row, 'bbs_qna_global');
                    } else {
                        $ret = $this->bbs($row, 'bbs_qna');
                    }
                } else if ($row['Field3'] == '23') {
                    if ($row['Field27'] == '2') {
                        $ret = $this->bbs($row, 'bbs_disclosure_global');
                    } else {
                        $ret = $this->bbs($row, 'bbs_disclosure');
                    }
                } else if ($row['Field3'] == '101') {
                    $ret = $this->bbs($row, 'bbs_contact');
                } else if ($row['Field3'] == '22') {
                    $ret = $this->bbs($row, 'bbs_teacher');
                } else if ($row['Field3'] == '24') {
                    $ret = $this->bbs($row, 'bbs_announce');
                } else if ($row['Field3'] == '25') {
                    $ret = $this->bbs($row, 'bbs_ir');
                } else if ($row['Field3'] == '27') {
                    $ret = $this->bbs($row, 'bbs_online');
                } else if ($row['Field3'] == '1002') {
                    $ret = $this->bbs($row, 'bbs_partnership');
                }
                */

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

        $rows = $this->selMig();

        foreach ($rows as $row) {
            if ($row['Field3'] == '1') {
                $this->rollback('bbs_notice', $row);
                $this->rollback('bbs_notice_comment', $row);
            } else if ($row['Field3'] == '4') {
                $this->rollback('shop_product_after', $row);
                $this->rollback('shop_product_after_comment', $row);
            } else if ($row['Field3'] == '6') {
                $this->rollback('shop_product_qna', $row);
                $this->rollback('shop_product_qna_comment', $row);
            } else if ($row['Field3'] == '8') {
                $this->rollback('bbs_premium_after', $row);
                $this->rollback('bbs_premium_after_comment', $row);
                $this->rollback('bbs_premium_after_global', $row);
                $this->rollback('bbs_premium_after_global_comment', $row);
            } else if ($row['Field3'] == '9') {
                $this->rollback('bbs_qna', $row);
                $this->rollback('bbs_qna_comment', $row);
                $this->rollback('bbs_qna_global', $row);
                $this->rollback('bbs_qna_global_comment', $row);
            } else if ($row['Field3'] == '22') {
                $this->rollback('bbs_teacher', $row);
                $this->rollback('bbs_teacher_comment', $row);
            } else if ($row['Field3'] == '23') {
                $this->rollback('bbs_disclosure', $row);
                $this->rollback('bbs_disclosure_comment', $row);
                $this->rollback('bbs_disclosure_global', $row);
                $this->rollback('bbs_disclosure_global_comment', $row);
            } else if ($row['Field3'] == '24') {
                $this->rollback('bbs_announce', $row);
                $this->rollback('bbs_announce_comment', $row);
            } else if ($row['Field3'] == '25') {
                $this->rollback('bbs_ir', $row);
                $this->rollback('bbs_ir_comment', $row);
            } else if ($row['Field3'] == '27') {
                $this->rollback('bbs_online', $row);
                $this->rollback('bbs_online_comment', $row);
            } else if ($row['Field3'] == '101') {
                $this->rollback('bbs_contact', $row);
                $this->rollback('bbs_contact_comment', $row);
            }
        }//end for
    }
    /* --------------------------------------------------------------------------------------- */


    /**
     * 게시물 마이그레이션
     * @param array $row
     * @return string
     */
    protected function bbs($row, $table)
    {
        $data = $this->selMember($row['Field12']);

        $userCode = $data->code;

        $row['Field13'] = str_replace("\\", "", $row['Field13']);

        if ($row['Field3'] == 4) { //SHOP_PRODUCT_AFTER (통합후기 게시판)
            $setting = [
                'mem_ix' => trim($userCode)
                , 'bbs_div' => 1
                , 'bbs_subject' => trim($row['Field13'])
                , 'bbs_name' => trim($row['Field10'])
                , 'bbs_id' => $row['Field12']
                , 'bbs_contents' => $row['Field26']
                , 'bbs_hidden' => trim($row['Field15']) == 'T' ? '1' : '0'
                , 'ip_addr' => trim($row['Field16'])
                , 'bbs_hit' => trim($row['Field8'])
                , 'regdate' => trim($row['Field9'])
                , 'co_no' => trim($row['Field2'])
                , 'pid' => trim($row['Field4'])
                , 'pname' => trim($row['Field5'])
                , 'bbs_file_1' => trim($row['Field17'])
                , 'mall_ix' => $row['Field27'] == '1' ? '20bd04dac38084b2bafdd6d78cd596b1' : '20bd04dac38084b2bafdd6d78cd596b2'
            ];

        } else if ($row['Field3'] == 8 || $row['Field3'] == 1) { //bbs_premium_after(프리미엄포토후기 게시판) || 공지사항
            $setting = [
                'mem_ix' => trim($userCode)
                , 'bbs_subject' => trim($row['Field13'])
                , 'bbs_contents' => $row['Field26']
                , 'bbs_hidden' => trim($row['Field15']) == 'T' ? '1' : '0'
                , 'ip_addr' => trim($row['Field16'])
                , 'bbs_hit' => trim($row['Field8'])
                , 'regdate' => trim($row['Field9'])
                , 'bbs_name' => trim($row['Field10'])
                , 'is_notice' => trim($row['Field21']) == 'T' ? 'Y' : 'N'
                , 'co_no' => trim($row['Field2'])
                , 'is_html' => 'Y'
                , 'status' => trim($row['Field24']) == 'Y' ? '5' : '1'
                , 'bbs_div' => '41'
            ];

        } else if ($row['Field3'] == 9) { //TBL_BBS_QNA (1:1 게시판)
            $setting = [
                'mem_ix' => trim($userCode)
                , 'bbs_subject' => trim($row['Field13'])
                , 'sub_bbs_div' => '0'
                , 'bbs_contents' => $row['Field26']
                , 'bbs_hidden' => trim($row['Field15']) == 'T' ? '1' : '0'
                , 'ip_addr' => trim($row['Field16'])
                , 'bbs_hit' => trim($row['Field8'])
                , 'regdate' => trim($row['Field9'])
                , 'bbs_name' => trim($row['Field10'])
                , 'is_notice' => trim($row['Field21']) == 'T' ? 'Y' : 'N'
                , 'co_no' => trim($row['Field2'])
                , 'is_html' => 'Y'
                , 'status' => trim($row['Field24']) == 'Y' ? '5' : '1'
                , 'bbs_div' => '41'
                , 'mall_ix' => $row['Field27'] == '1' ? '20bd04dac38084b2bafdd6d78cd596b1' : '20bd04dac38084b2bafdd6d78cd596b2'
            ];

        } else if ($row['Field3'] == 6) { //TBL_SHOP_PRODUCT_QNA (상품문의 게시판)
            $setting = [
                'pid' => trim($row['Field4'])
                , 'ucode' => trim($userCode)
                , 'bbs_subject' => trim($row['Field13'])
                , 'bbs_id' => $row['Field12']
                , 'bbs_contents' => $row['Field26']
                , 'bbs_hidden' => trim($row['Field15']) == 'T' ? '1' : '0'
                , 'bbs_hit' => trim($row['Field8'])
                , 'regdate' => trim($row['Field9'])
                , 'bbs_name' => trim($row['Field10'])
                , 'bbs_email' => trim($row['Field11'])
                , 'bbs_re_cnt' => trim($row['Field24'])
                , 'co_no' => trim($row['Field2'])
                , 'mall_ix' => $row['Field27'] == '1' ? '20bd04dac38084b2bafdd6d78cd596b1' : '20bd04dac38084b2bafdd6d78cd596b2'
            ];

        } else if ($row['Field3'] == 3) { //bbs_faq (자주묻는질문게시판)
            $setting = [
                'bbs_div' => 1
                , 'bbs_q' => trim($row['Field13'])
                , 'bbs_a' => trim($row['Field26'])
                , 'bbs_contents_type' => 'H'
                , 'bbs_hit' => trim($row['Field8'])
                , 'regdate' => trim($row['Field9'])
                , 'co_no' => trim($row['Field2'])
            ];
        } else {
            $setting = [
                'mem_ix' => trim($userCode)
                , 'bbs_subject' => trim($row['Field13'])
                , 'bbs_contents' => $row['Field26']
                , 'bbs_hidden' => trim($row['Field15']) == 'T' ? '1' : '0'
                , 'ip_addr' => trim($row['Field16'])
                , 'bbs_hit' => trim($row['Field8'])
                , 'regdate' => trim($row['Field9'])
                , 'bbs_name' => trim($row['Field10'])
                , 'is_notice' => trim($row['Field21']) == 'T' ? 'Y' : 'N'
                , 'co_no' => trim($row['Field2'])
                , 'is_html' => 'Y'
                , 'status' => trim($row['Field24']) == 'Y' ? '5' : '1'
                , 'bbs_div' => '41'
            ];

        }

        $this->qb->set($setting);

        $mig_mode = 'insert';

        $this->qb
            ->insert($table)
            ->exec();

        print_r($table);
        print_r($setting);

        return $mig_mode;
    }

    /**
     * 게시판 bbs 마이그레이션 코멘트
     * @param $row
     * @param $table
     */
    protected function bbsComment($row, $table)
    {

        $parentTable = str_replace("_comment", "", $table);

        $selBbs = $this->selBbs($parentTable, $row['Field2']);
        $bbs_ix = $selBbs->bbs_ix;

        $data = $this->selMember($row['Field12']);
        $userCode = $data->code;

        if($table == 'bbs_contact_comment' || $table == 'bbs_online_comment' || $table == 'shop_product_qna_comment'){
            $setting = [
                'bbs_ix' => $bbs_ix
                , 'mem_ix' => $userCode
                , 'cmt_name' => trim($row['Field10'])
                , 'cmt_contents' => $row['Field26']
                , 'regdate' => trim($row['Field9'])
            ];
        }else {
            $setting = [
                'bbs_ix' => $bbs_ix
                , 'bbs_div' => '41'
                , 'mem_ix' => $userCode
                , 'cmt_name' => trim($row['Field10'])
                , 'cmt_contents' => $row['Field26']
                , 'regdate' => trim($row['Field9'])
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
            ->set('bbs_re_cnt = bbs_re_cnt+1')
            ->exec();

        print_r($table);
        print_r($setting);

        return $mig_mode;
    }

    /**
     * 게시판 롤백
     * @param $table
     * @param $row
     */
    protected function rollback($table, $row)
    {
        /*
        if ($table == TBL_SHOP_PRODUCT_QNA) {
            $where = 'ucode';
        } else {
            $where = 'mem_ix';
        }

        if(!empty($row['Field12'])) {
            $data = $this->selMember($row['Field12']);
            if ($data->code) {
                $this->qb
                    ->whereIn(
                        $where, $data->code)
                    ->delete($table)
                    ->exec();
            }
        }
        */

        $this->qb
            ->from($table)
            ->exec();

        if ($this->qb->total == 0) {
            return;
        } else {

            print_r($table);

            if (strpos($table, 'comment') !== false) {
                $this->qb
                    ->where('cmt_ix!=""');
            } else {
                $this->qb
                    ->where('bbs_ix!=""');
            }

            $this->qb
                ->delete($table)
                ->exec();
        }
    }

    /**
     * member 조회
     * @param $id
     * @return mixed
     */
    protected
    function selMember($id)
    {
        $data = $this->qb
            ->select('code')
            ->from(TBL_COMMON_USER)
            ->where('id', $id)
            ->exec()
            ->getRow();

        return $data;
    }

    /**
     * qna 조회
     * @param $table
     * @param $no
     * @return mixed
     */
    protected
    function selBbs($table, $no)
    {
        $data = $this->qb
            ->select('bbs_ix')
            ->from($table)
            ->where('co_no', $no)
            ->exec()
            ->getRow();
        return $data;
    }
})->
run();
