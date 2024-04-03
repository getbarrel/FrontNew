<?php

/**
 * Description of ForbizMallMileageModel
 *
 * @author hoksi
 * 
 * 마일리지 프로세스
 *   add = 적립만
 *   use = 사용만
 *   log = 적립, 사용 전체 기록
 *   remove = 소멸
 *
 *   -적립, 사용 리스트 노출시 add, use 사용
 *   -합산 계산시 log 사용 혹은 common_user 테이블 사용
 *   -remove 소멸. 적립된 순서대로 순차적으로 소멸하기위해 존재.
 *   -마일리지는 무조건 insert만 가능하며 이미 insert된 데이터는 다시 update하거나 delete 사용하지 않음
 *
 * 소멸
 *   am : add_mileage
 *   um : use_mileage
 *   -마일리지 적립시 : 취소일 경우 remove 테이블에 마일리지 복구 상태 데이터 입력.(rm_state=2)
 *   -마일리지 사용시 : 사용할 경우 무조건 입력됨.
 *   shop_add_mileage 내역 중 사용될 내역 데이터(am_ix)와 shop_use_mileage 의 현재 사용되는 내역 데이터(um_ix)가 조합됨
 *   -
 *   1) 크론을 통하여 shop_add_mileage 의 소멸기간(extinction_date) 데이터 조회.
 *   2) 이 중 remove 테이블에 데이터가 없는 마일리지 소멸 처리됨(use 테이블에 소멸 내역으로 입력됨. remove 테이블에 내역 데이터 입력됨.)
 *   3) remove 테이블의 마일리지 합산 내역과 add 테이블의 마일리지 계산하여 해당 마일리지만큼을 소멸함
 *   예) 1000원 적립. 500원 사용. 이 경우 소멸시 500원 소멸되며 use 테이블, remove 테이블에 500원 소멸로 내역 입력됨
 * 
 * * * *
 * 마일리지 환불은 입금전취소는 바로 가능하나, 결제 완료된 이후부터는 환불완료시 처리됨
 */
class ForbizMallMileageModel extends ForbizModel
{

    /**
     * 마일리지 정책 정보
     * @var type
     */
    protected $config;

    /**
     * 마일리지 노출 명칭
     * @var type
     */
    protected $name;

    /**
     * 마일리지 노출 단위
     * @var type
     */
    protected $unit;

    /**
     * 사용 환경 (W: PC, M:모바일)
     * @var string
     */
    protected $agentType = 'W';

    /**
     * 회원 그룹 인덱스 (common_member_detail.gp_ix)
     * @var type
     */
    protected $memberGroupIx = 0;

    /**
     * 회원 code (common_user.code)
     * @var type
     */
    protected $userCode = '';

    /**
     * 회원 마일리지 사용 여부
     * @var type
     */
    protected $userUseYn = '';

    public function __construct()
    {
        parent::__construct();

        $this->config = ForbizConfig::getSharedMemory('b2c_mileage_rule');
        $this->name = ($this->config['mileage_name'] ?? '마일리지');
        $this->unit = ($this->config['mileage_unit_txt'] ?? 'M');

        $this->setAgentType((is_mobile() ? "M" : "W"));
        $this->setMember(sess_val('user', 'code'), sess_val('user', 'gp_ix'), sess_val('user', 'use_reserve_yn'));
    }

    /**
     * set 사용 환경
     * @param string $agentType
     * @return $this
     */
    public function setAgentType($agentType)
    {
        $this->agentType = strtoupper($agentType);
        return $this;
    }

    /**
     * set 회원
     * @param string $userCode
     * @param int $gpIx
     * @param string $userUseYn
     * @return $this
     */
    public function setMember($userCode, $gpIx, $userUseYn)
    {
        $this->userCode = $userCode;
        $this->memberGroupIx = $gpIx;
        $this->userUseYn = $userUseYn;
        return $this;
    }

    /**
     * get 마일리지 노출 명칭
     * @return type
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * get 마일리지 노출 단위
     * @return type
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * get config
     * @param type $key
     * @return type
     */
    public function getConfig($key)
    {
        return empty($this->config[$key]) ? '' : $this->config[$key];
    }

    /**
     * 마일리지 금액 조회
     * @return type
     */
    public function getUserAmount()
    {
        if ($this->isUseMileage()) {
            $result = $this->qb
                ->select("mileage")
                ->from(TBL_COMMON_USER)
                ->where("code", $this->userCode)
                ->limit("1")
                ->exec()
                ->getRowArray();
        }

        return ($result['mileage'] ?? 0);
    }

    /**
     * get 적립 마일리지
     * @param string $individualYn 상품 개별 적립 사용 유무
     * @param string $individualType 상품 개별 적립 타입 [%(2) or 원]
     * @param type $individualValue 상품 개별 적립 값
     * @param type $companyId 업체 코드
     * @param type $totalListPrice 상품 총 기본값
     * @param type $totalDcPrice 상품 총 할인가
     * @param type $totalCouponWithDcPrice 상품 총 쿠폰적용가
     */
    public function getSaveMileage($individualYn, $individualType, $individualValue, $companyId, $totalListPrice, $totalDcPrice, $totalCouponWithDcPrice)
    {
        $saveMileage = f_decimal(0);
        if ($this->isUseMileage()) {
            //적립 기준
            $targetPrice = f_decimal($totalCouponWithDcPrice); //최종 결제가(기획, 특별할인, 상품쿠폰할인 포함)
            switch ($this->config['standard']) {
                case 'S': //판매가(기획, 특별할인 미포함)
                    $targetPrice = f_decimal($totalListPrice);
                    break;
                case 'D': //할인가(기획, 특별할인 포함)
                    $targetPrice = f_decimal($totalDcPrice);
                    break;
            }

            //상품 개별 적립
            if ($individualYn == 'Y') {
                //원
                if ($individualType == '2') {
                    $saveMileage = f_decimal($individualValue);
                }
                //%
                else {
                    $saveMileage = ($targetPrice * $individualValue / 100)->round((defined('BCSCALE') ? BCSCALE : 0));
                }
            } else {
                if ($this->config['scale'] != 'H' || ($this->config['scale'] == 'H' && $companyId == ForbizConfig::getCompanyInfo('company_id'))) {
                    //적립 비율
                    $saveRate = 0;
                    switch ($this->config['mileage_info_use']) {
                        case 'S': //공통 적립
                            $saveRate = $this->config['mileage_rate']['common'];
                            break;
                        case 'P': //플랫폼별 차등 적립
                            if ($this->agentType == 'M') {
                                $saveRate = $this->config['mileage_rate']['m'];
                            } else {
                                $saveRate = $this->config['mileage_rate']['p'];
                            }
                            break;
                        case 'G': //회원그룹별 차등 적립
							$timenow	= date("Y-m-d H:i:s");
							$timeStart	= $this->config['mileage_term_sdate']." ".$this->config['mileage_term_sdate_h'].":".$this->config['mileage_term_sdate_i'].":".$this->config['mileage_term_sdate_s'];
							$timeEnd	= $this->config['mileage_term_edate']." ".$this->config['mileage_term_edate_h'].":".$this->config['mileage_term_edate_i'].":".$this->config['mileage_term_edate_s'];

							$str_now	= strtotime($timenow);
							$str_start	= strtotime($timeStart);
							$str_end	= strtotime($timeEnd);

							$saveRate = ($this->config['mileage_rate'][$this->memberGroupIx] ?? 0);

							if($this->config['mileage_term_yn'] == "Y"){
								if($str_now >= $str_start && $str_now <= $str_end) {
									$saveRate = $saveRate + $this->config['mileage_add'];
								}
							}
                            break;
                    }
                    if (empty($saveRate)) {
                        $saveRate = f_decimal(0);
                    } else {
                        $saveRate = f_decimal($saveRate);
                    }
                    $saveMileage = ($targetPrice * $saveRate / 100)->round((defined('BCSCALE') ? BCSCALE : 0));
                }
            }
        }
        return $saveMileage;
    }

    /**
     * 마일리지 사용
     * @param int $mileage
     * @param int $type 1 : 주문에 의한 사용 ,2 : 수동사용 처리,  5 : 마일리지 소멸 , 6 : 탈퇴에 의한 소멸
     * @param string $message
     * @param array $etcData ['oid' => oid]
     */
    public function useMileage($mileage, $type, $message, $etcData = [])
    {
        if ($this->isUseMileage()) {
            $oid = ($etcData['oid'] ?? '');

            $this->qb
                ->set('uid', $this->userCode)
                ->set('use_type', $type)
                ->set('um_mileage', $mileage) //사용된 마일리지 값
                ->set('um_state', 1) //현재는 무조건 1 사용 완료 상태만 존재(기존 솔루션)
                ->set('message', $message)
                ->set('date', date('Y-m-d H:i:s'))
                ->set('regdate', date('Y-m-d H:i:s'));

            if (!empty($oid)) {
                $this->qb->set('oid', $oid);
            }

            $ix = $this->qb->insert(TBL_SHOP_USE_MILEAGE)->exec();

            $newMileage = $this->calculateTotalMileage($mileage, 'use'); //총 마일리지 재계산
            $this->recodeLogTable($mileage, $newMileage, 'use', $ix, $message, $etcData); //로그테이블 입력. 실질적인 마일리지 계산 테이블.
            $this->updateUserMileage($newMileage); //회원 마일리지 정보 업데이트
            
            //소멸 데이터 처리
            $this->useExtinctionProcess($mileage, $ix);
        }
        return;
    }

    /**
     * 마일리지 적립
     * @param int $mileage 마일리지
     * @param int $type 1 : 주문에 의한 적립, 2 : 회원가입에 의한 적립  3 : 수동적립, 4 : 취소적립, 5 : 배송비 적립 ,6 : 게시판 글 작성, 7 :기타
     * @param string $message 적립메시지
     * @param array $etcData 기타 데이타 ['oid', 'od_ix', 'pid', 'ptprice', 'payprice']
     */
    public function addMileage($mileage, $type, $message, $etcData = [])
    {
        if ($this->isUseMileage()) {
            $oid = ($etcData['oid'] ?? ''); // 주문번호
            $od_ix = ($etcData['od_ix'] ?? ''); // 개별 주문번호
            $pid = ($etcData['pid'] ?? ''); // 상품코드
            $ptprice = ($etcData['ptprice'] ?? ''); //log 테이블 기록시 사용됨
            $payprice = ($etcData['payprice'] ?? ''); //log 테이블 기록시 사용됨

            $extinction_date = '';
            if ($this->config['auto_extinction'] == 'Y') {
                $extinction_date = date('Y-m-d', mktime(date("h"), date("i"), date("s"), date("m") + $this->config['cancel_month'], date("d"), date("Y") + $this->config['cancel_year']));
            }

            $this->qb
                ->set('uid', $this->userCode)
                ->set('add_type', $type)
                ->set('am_mileage', $mileage) //사용된 마일리지 값
                ->set('am_state', 1) //적립상태 값이나 현재는 무조건 1 적립완료 일때만 사용(기존 솔루션)
                ->set('message', $message)
                ->set('reserve_type', 'b2c')//도/소매구분 b2b:도매 b2c:소매
                ->set('auto_cancel', $this->config['auto_extinction']) //Y: 자동소멸 N : 디펄트
                ->set('date', date('Y-m-d H:i:s'))
                ->set('regdate', date('Y-m-d H:i:s'))
                ->set('extinction_date', $extinction_date);

            if (!empty($oid)) {
                $this->qb->set('oid', $oid);
            }
            if (!empty($od_ix)) {
                $this->qb->set('od_ix', $od_ix);
            }
            if (!empty($pid)) {
                $this->qb->set('pid', $pid);
            }

            $ix = $this->qb->insert(TBL_SHOP_ADD_MILEAGE)->exec();

            $newMileage = $this->calculateTotalMileage($mileage, 'add'); //총 마일리지 재계산
            $this->recodeLogTable($mileage, $newMileage, 'add', $ix, $message, $etcData); //로그테이블 입력. 실질적인 마일리지 계산 테이블.
            $this->updateUserMileage($newMileage); //회원 마일리지 정보 업데이트
            
            //소멸 데이터 처리
            $this->addExtinctionProcess($mileage);
        }
        return;
    }
    
    /**
     * 마일리지 적립시 소멸 데이터 내역 입력 프로세스
     * @param type $mileage
     */
    protected function addExtinctionProcess($mileage)
    {
        $mileage = f_decimal($mileage);
        //마일리지 amIx = 0 (-마일리지시 입금 amIx 대상이 없을경우..)
        $remainList = $this->qb
            ->select('rm_ix')
            ->select('rm_mileage')
            ->select('um_ix')
            ->from(TBL_SHOP_REMOVE_MILEAGE)
            ->where('uid', $this->userCode)
            ->where('am_ix', 0)
            ->orderBy('rm_ix')
            ->exec()
            ->getResultArray();
        
        if (!empty($remainList)) {
            foreach ($remainList as $val) {
                $rm_mileage = f_decimal($val['rm_mileage']);
                if ($rm_mileage >= $mileage) {
                    $this->extinctionProcess($mileage, $val['um_ix']);
                    if ($rm_mileage > $mileage) {
                        $this->putExtinctionMileage($val['rm_ix'], ($rm_mileage - $mileage));
                    } else {
                        $this->delExtinctionMileage($val['rm_ix']);
                    }
                    break;
                } else {
                    $this->extinctionProcess($rm_mileage, $val['um_ix']);
                    $this->delExtinctionMileage($val['rm_ix']);
                    $mileage -= $rm_mileage;
                }
            }
        }
    }

    /**
     * 마일리지 사용시 소멸 데이터 내역 입력 프로세스
     * @param int $rmMileage
     * @param int $umIx
     */
    protected function useExtinctionProcess($rmMileage, $umIx)
    {
        $this->extinctionProcess($rmMileage, $umIx);
    }
    
    /**
     * 마일리지 소멸 프로세스
     * @param type $rmMileage
     * @param type $umIx
     */
    protected function extinctionProcess($rmMileage, $umIx)
    {
        $rmMileage = f_decimal($rmMileage);
        if ($rmMileage > 0) {
            $rmMsg = $this->name . ' 사용에 따른 순차적 차감';

            //마일리지 소멸 대상 데이터 추출
            $removeLogs = $this->qb
                ->select('am.am_mileage - SUM(IFNULL(rm_mileage,0)) as remove_mileage')
                ->select('am.am_ix')
                ->from(TBL_SHOP_ADD_MILEAGE . ' as am')
                ->join(TBL_SHOP_REMOVE_MILEAGE . ' as rm', 'rm.am_ix=am.am_ix', 'left')
                ->where('am.uid', $this->userCode)
                ->groupBy('am.am_ix')
                ->having('remove_mileage > 0')
                ->orderBy('am_ix')
                ->exec()
                ->getResultArray();

            if (!empty($removeLogs)) { //소멸 내역으로 이미 입력된 데이터가 있는지 확인
                foreach ($removeLogs as $k => $v) {
                    $amIx = $v['am_ix'];
                    $remove_mileage = f_decimal($v['remove_mileage']);
                    if ($remove_mileage >= $rmMileage) {
                        $amIx = $v['am_ix'];
                        $this->addExtinctionMileage(1, $amIx, $umIx, $rmMileage, $rmMsg);
                        $rmMileage = f_decimal(0);
                        break;
                    } else {
                        $this->addExtinctionMileage(1, $amIx, $umIx, $remove_mileage, $rmMsg);
                        $rmMileage -= $remove_mileage;
                    }
                }
            }
            //마일리지 - 인 경우 처리
            if ($rmMileage > 0) {
                //우선 amIx를 0으로 처리후 위에서 추가 차감처리
                $this->addExtinctionMileage(1, 0, $umIx, $rmMileage, $rmMsg);
            }
        }
    }

    /**
     * 마일리지 회원 탈퇴 시 소멸 프로세스
     */
    public function withdrawExtinctionMileage($userCode){
        $data = $this->qb
            ->select('mileage')
            ->from(TBL_COMMON_USER)
            ->where('code', $userCode)
            ->exec()->getRowArray();

        if($data['mileage'] > 0){
            $message = "회원 탈퇴에 따른 ".$this->name." 소멸";
            $this->useMileage($data['mileage'],'6',$message);
        }

    }

    /**
     * 마일리지 소멸 내역 입력
     * @param int $type
     * @param int $amIx
     * @param int $umIx
     * @param int $mileage
     * @param string $msg
     */
    protected function addExtinctionMileage($type, $amIx, $umIx, $mileage, $msg)
    {
        $this->qb
            ->set('uid', $this->userCode)
            ->set('rm_state', $type) //차감 상태 1: 차감 완료 2: 차감 취소
            ->set('am_ix', $amIx) //사용된 적립(add) 마일리지 키
            ->set('um_ix', $umIx) //사용된 사용(use) 마일리지 키
            ->set('rm_mileage', $mileage)
            ->set('message', $msg)
            ->set('date', date('Y-m-d H:i:s'))
            ->set('regdate', date('Y-m-d H:i:s'))
            ->insert(TBL_SHOP_REMOVE_MILEAGE)
            ->exec();
        return;
    }
    
    /**
     * 마일리지 소멸 내역 수정
     * @param type $rmIx
     * @param type $rmMileage
     * @return type
     */
    protected function putExtinctionMileage($rmIx, $rmMileage)
    {
        $this->qb
            ->set('rm_mileage', $rmMileage)
            ->update(TBL_SHOP_REMOVE_MILEAGE)
            ->where('rm_ix', $rmIx)
            ->exec();
        return;
    }

    /**
     * 마일리지 소멸 내역 삭제
     * @param int $rmIx
     */
    protected function delExtinctionMileage($rmIx)
    {
        $this->qb
            ->delete(TBL_SHOP_REMOVE_MILEAGE)
            ->where('rm_ix', $rmIx)
            ->exec();
        return;
    }

    /**
     * 총 남은 마일리지 재계산
     * @param int $mileage
     * @param int $type
     * @return int
     */
    protected function calculateTotalMileage($mileage, $type)
    {
        $total = $this->qb
            ->setDatabase('payment')
            ->select('total_mileage')
            ->from(TBL_SHOP_MILEAGE_LOG)
            ->where('uid', $this->userCode)
            ->orderBy('ml_ix', 'desc')
            ->limit(1)
            ->exec()
            ->getRow(0, 'array');

        $mileage = f_decimal($mileage);

        if (empty($total['total_mileage'])) {
            $total_mileage = f_decimal(0);
        } else {
            $total_mileage = f_decimal($total['total_mileage']);
        }

        if ($type == 'add') {
            $newMileage = $total_mileage + $mileage;
        } else { //use
            $newMileage = $total_mileage - $mileage;
        }
        return $newMileage;
    }

    /**
     * 마일리지 적립, 사용 전체 로그 데이터 입력
     * @param int $mileage
     * @param int $newMileage
     * @param int $type
     * @param int $ix
     * @param string $message
     * @param array $etcData
     * @return type
     */
    protected function recodeLogTable($mileage, $newMileage, $type, $ix, $message, $etcData)
    {
        $oid = ($etcData['oid'] ?? '');
        $od_ix = ($etcData['od_ix'] ?? '');
        $pid = ($etcData['pid'] ?? '');
        $ptprice = ($etcData['ptprice'] ?? '');
        $payprice = ($etcData['payprice'] ?? '');

        $this->qb
            ->set('uid', $this->userCode)
            ->set('log_type', $type) //사용타입 : add, remove, use 적립 , 차감 , 사용
            ->set('type_ix', $ix)
            ->set('ml_mileage', $mileage)
            ->set('total_mileage', $newMileage)
            ->set('message', $message)
            ->set('date', date('Y-m-d H:i:s'))
            ->set('regdate', date('Y-m-d H:i:s'));

        if ($type == 'add') { //로그 등록 상태 1 : 적립 2 : 사용 9 : 취소
            $this->qb->set('ml_state', 1);
        } else {
            $this->qb->set('ml_state', 2);
        }

        if (!empty($oid)) {
            $this->qb->set('oid', $oid);
        }
        if (!empty($od_ix)) {
            $this->qb->set('od_ix', $od_ix);
        }
        if (!empty($pid)) {
            $this->qb->set('pid', $pid);
        }
        if (!empty($ptprice)) {
            $this->qb->set('ptprice', $ptprice);
        }
        if (!empty($payprice)) {
            $this->qb->set('payprice', $payprice);
        }

        //회원 마일리지 로그 테이블 입력(실질적인 마일리지 계산, 조회 등은 기존 테이블에서는 해당 로그 테이블에서 사용하였음)
        $this->qb->insert(TBL_SHOP_MILEAGE_LOG)->exec();
        return;
    }

    /**
     * 해당 회원의 총 마일리지 데이터 업데이트(common_user)
     * @param int $mileage
     */
    protected function updateUserMileage($mileage)
    {
        $this->qb
            ->set('mileage', $mileage)
            ->update(TBL_COMMON_USER)
            ->where('code', $this->userCode)
            ->exec();
        return;
    }
    
    /**
     * 몰 마일리지 사용 여부
     * @return boolean
     */
    public function isUseMileage()
    {
        if ($this->config['mileage_use_yn'] == 'Y' && !empty($this->userCode) && $this->userUseYn == 'Y') {
            return true;
        } else {
            return false;
        }
    }

    /*
     * 소멸 예정 마일리지 구하기
     * 30일 이내에 소멸 예정인 적립금 합
     */

    public function getExtMilageAmount($month = '1')
    {
        $nowDate = date('Y-m-d');
        //        $afterDate = "date_add('{$nowDate}', INTERVAL {$month} MONTH )";
        $afterDate = date('Y-m-d', strtotime("{$nowDate} +{$month} month"));
        $data = $this->qb->from(TBL_SHOP_ADD_MILEAGE)
            ->select('am_ix')
            ->select('am_mileage')
            ->where('uid',$this->userCode)
            ->betweenDate('extinction_date',$nowDate,$afterDate)
            ->exec()->getResultArray();

        $extinction_mileage = 0;
        if(is_array($data) && count($data) > 0){
            foreach($data as $key=>$val){
                $removeData = $this->qb->from(TBL_SHOP_REMOVE_MILEAGE)
                    ->select("ifnull(sum(case when rm_state = '2' then -rm_mileage else rm_mileage end),0) as remove_mileage")
                    ->where('am_ix',$val['am_ix'])
                    ->where('uid',$this->userCode)
                    ->groupBy('am_ix')
                    ->exec()->getRowArray();

                $remove_mileage = f_decimal($removeData['remove_mileage']);
                $am_mileage = f_decimal($val['am_mileage']);

                if($am_mileage > $remove_mileage){
                    $extinction_mileage += $am_mileage - $remove_mileage;
                }
            }
        }

        return $extinction_mileage;

    }

    /*
     * 적립 예정 금액의 합
     */

    public function getExpectedMilage()
    {
        $status = [ORDER_STATUS_INCOM_COMPLETE,ORDER_STATUS_DELIVERY_READY,ORDER_STATUS_DELIVERY_ING,ORDER_STATUS_DELIVERY_COMPLETE,ORDER_STATUS_DELIVERY_DELAY];

        $row = $this->qb
            ->select("SUM(reserve) AS reserve_amount")
            ->from(TBL_SHOP_ORDER_DETAIL.' AS a')
            ->join(TBL_SHOP_ORDER.' AS b', 'a.oid = b.oid')
            ->where("b.user_code", $this->userCode)
            ->whereIn("a.status", $status)
            ->exec()
            ->getRowArray();

        return ($row['reserve_amount'] ?? 0);
    }
    
    /**
     * 회원가입시 적립
     */
    public function memberJoinGiveMileage()
    {
        if (!empty($this->config['join_use']) && $this->config['join_use'] == 'Y' && !empty($this->config['join_rate'])) {
            $this->addMileage($this->config['join_rate'], '2', '회원가입 적립');
        }
    }
}
