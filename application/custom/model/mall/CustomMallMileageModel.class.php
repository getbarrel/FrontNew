<?php

/**
 * Description of ForbizMallMileageModel
 *
 * @author hoksi
 */
class CustomMallMileageModel extends ForbizMallMileageModel
{

    public function __construct()
    {
        parent::__construct();

        if(BASIC_LANGUAGE == 'english'){
            $this->config = ForbizConfig::getSharedMemory('global_mileage_rule');

            $this->name = ($this->config['mileage_name'] ?? 'mileage');
            $this->unit = ($this->config['mileage_unit_txt'] ?? 'M');
        }else{
            $this->config = ForbizConfig::getSharedMemory('b2c_mileage_rule');

            $this->name = ($this->config['mileage_name'] ?? '마일리지');
            $this->unit = ($this->config['mileage_unit_txt'] ?? 'M');
        }
    }

    /**
     * crema call back
     * 크리마에서 마일리지 콜백
     * @param type $post
     */
    public function cremaMileAgeCallBack($post = [])
    {
        $result['code'] = 0;
        $result['message'] = 'success';

        //test data
//        $post = [
//            'user_code' => 'forbiz'
//            , 'amount' => 1000
//            , 'review_id' => '159'
//            , 'product_code' => '0000000016'
//            , 'order_code' => '201907171644-0000001'
//            , 'message' => '포토리뷰'
//            , 'created_at' => date('Y-m-d\TH:i:sO')
//        ];

        //validation check
        $rows = $this->cremaOrderCheck($post['order_code'], $post['user_code']);

        if (count($rows) >= 1 && $rows['code']) {
            $this->setMember($rows['code'], $rows['gp_ix'], $rows['use_reserve_yn']);
            $etcData = [];
            if ($post['amount'] > 0) {
                //적립
                $etcData['oid'] = $post['order_code'];
                $etcData['pid'] = $post['product_code'];
                $this->addMileage($post['amount'], 7, $post['message'], $etcData);
            } else if ($post['amount'] < 0) {
                //차감
                $etcData['oid'] = $post['order_code'];
                $etcData['pid'] = $post['product_code'];
                $this->useMileage( abs($post['amount']), 2, $post['message'], $etcData);
            }
            return $result;
        } else {
            $result['code'] = -1;
            $result['message'] = '해당 주문을 찾을 수 없습니다.';
            return $result;
        }
    }

    /**
     * 크리마 회원과 주문 체크
     * @param type $oid
     * @param type $user_id
     * @return type
     */
    public function cremaOrderCheck($oid, $user_id)
    {
        return $this->qb
                ->select('u.code')
                ->select('g.gp_ix')
                ->select('g.use_reserve_yn')
                ->from(TBL_COMMON_USER . ' AS u')
                ->join(TBL_SHOP_ORDER . ' AS o', 'u.code = o.user_code')
                ->join(TBL_COMMON_MEMBER_DETAIL . ' AS m', 'u.code = m.code')
                ->join(TBL_SHOP_GROUPINFO . ' AS g', 'm.gp_ix = g.gp_ix')
                ->where('u.id', $user_id)
                ->where('o.oid', $oid)
                ->exec()
                ->getRowArray();
    }

    /*
     * 소멸 예정 마일리지 구하기
     * 특정 개월 이내에 소멸 예정인 적립금 합 구하기
     */

    public function getExtMilageAmount($month = '1')
    {
        $nowDate = date('Y-m-d');
        $afterDate = date("Y-m-d", strtotime("+".$month." months"));
        $data = $this->qb->from(TBL_SHOP_ADD_MILEAGE)
            ->select('am_ix')
            ->select('am_mileage')
            ->where('uid',$this->userCode)
            ->betweenBasic('extinction_date',$nowDate,$afterDate)
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

    public function extMileageList($month,$page,$max){
        $nowDate = date('Y-m-d');
        $afterDate = date("Y-m-d", strtotime("+".$month." months"));

        $this->qb->startCache();
            $this->qb->from(TBL_SHOP_ADD_MILEAGE.' as am')
            ->select('am.am_ix')
            ->select('am.am_mileage')
            ->select('am.extinction_date')
            ->select(
                $this->qb->startSubQuery()
                    ->select("ifnull(sum(case when rm_state = '2' then -rm_mileage else rm_mileage end),0) as remove_mileage")
                    ->from(TBL_SHOP_REMOVE_MILEAGE)
                    ->where('am_ix','am.am_ix',false)
                    ->where('uid',$this->userCode)
                    ->endSubQuery().' as remove_mileage', false
            )
            ->where('am.uid',$this->userCode)
            ->betweenDate('am.extinction_date',$nowDate,$afterDate)
            ->where('am.am_mileage > ',
                $this->qb->startSubQuery()
                    ->select("ifnull(sum(case when rm_state = '2' then -rm_mileage else rm_mileage end),0) as remove_mileage")
                    ->from(TBL_SHOP_REMOVE_MILEAGE)
                    ->where('am_ix','am.am_ix',false)
                    ->where('uid',$this->userCode)
                    ->endSubQuery(), false
            )
            ;
        $this->qb->stopCache();
        $total = $this->qb->getCount();
        $paging = $this->qb->setTotalRows($total)->pagination($page, $max);

        $data = $this->qb
            ->orderBy('extinction_date','asc')->exec()->getResultArray();
        $this->qb->flushCache();

        $extinctionMileageArray = array();
        if(is_array($data) && count($data) > 0){
            $num = 0;
            foreach($data as $key=>$val) {
                $extinctionMileageArray[$num]['am_ix'] = $val['am_ix'];
                $extinctionMileageArray[$num]['extinction_date'] = date('Y.m.d', strtotime($val['extinction_date']));
                $extinctionMileageArray[$num]['extinction_mileage'] = g_price(f_decimal($val['am_mileage']) - f_decimal($val['remove_mileage']));
                $num++;
            }
        }


        return [
            'total' => $total,
            'list' => array_slice($extinctionMileageArray,$paging['offset'],$max),
            'paging' => $paging

        ];
    }

    /**
     * 회원가입시 적립
     */
    public function memberJoinGiveMileage()
    {
        // if ($this->config['join_use'] == 'Y' && !empty($this->config['join_rate'])) {
        if (($this->config['join_use'] ?? 'N') == 'Y' && !empty($this->config['join_rate'])) {
            $this->addMileage($this->config['join_rate'], '2', '회원가입 적립');
        }
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
            if($mileage > 0) {

                //이미 동일한 주문건의 적립이 존재 할경우 프로세스 진행 하지 않고 return
                if(!empty($etcData['oid']) && !empty($etcData['od_ix'])){
                    $dupOdCount = $this->qb
                        ->select('am_ix')
                        ->from(TBL_SHOP_ADD_MILEAGE)
                        ->where('oid',$etcData['oid'])
                        ->where('od_ix',$etcData['od_ix'])
                        ->getCount();

                    if($dupOdCount > 0){
                        return;
                    }
                }

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
                    ->set('am_mileage', $mileage)//사용된 마일리지 값
                    ->set('am_state', 1)//적립상태 값이나 현재는 무조건 1 적립완료 일때만 사용(기존 솔루션)
                    ->set('message', $message)
                    ->set('reserve_type', 'b2c')//도/소매구분 b2b:도매 b2c:소매
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
        }
        return;
    }
}
