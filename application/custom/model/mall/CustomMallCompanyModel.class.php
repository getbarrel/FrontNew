<?php

/**
 * Description of CustomerMallCompanyModel
 *
 * @author hong
 */
class CustomMallCompanyModel extends ForbizMallCompanyModel
{

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * get 약관 히스토리 정보
     * @param array $argList
     * @return array
     */
    public function getPolicyHistory($piCode)
    {
        return $this->qb
            ->select('pi_ix')
            ->select('pi_code')
            ->select('left(startdate, 10) as regdate')
            ->select('pi_contents')
            ->from(TBL_SHOP_POLICY_INFO)
            ->where('disp', 'Y')
            ->where('pi_code', $piCode)
            ->where('startdate <= now()')
            ->orderBy('startdate', 'DESC')
            ->exec()
            ->getResultArray();
    }

    public function getPolicyNow($piCode){
        $data = $this->qb
            ->select('pi_ix')
            ->select('pi_code')
            ->select('left(startdate, 10) as regdate')
            ->select('pi_contents')
            ->from(TBL_SHOP_POLICY_INFO)
            ->where('disp', 'Y')
            ->where('pi_code', $piCode)
            ->where('startdate <= now()')
            ->orderBy('startdate','desc')
            ->limit(1)
            ->exec()
            ->getResultArray();

        return $data;
    }

    public function getPolicyHistoryDate($piCode){
        return $this->qb
            ->select('pi_ix')
            ->select('pi_code')
            ->select('left(startdate, 10) as regdate')
            ->from(TBL_SHOP_POLICY_INFO)
            ->where('disp', 'Y')
            ->where('pi_code', $piCode)
            ->where('startdate <= now()')
            ->orderBy('startdate', 'DESC')
            ->exec()
            ->getResultArray();
    }

    public function getPolicyData($pi_ix){
        $data = $this->qb
            ->select('pi_ix')
            ->select('pi_code')
            ->select('left(startdate, 10) as regdate')
            ->select('pi_contents')
            ->from(TBL_SHOP_POLICY_INFO)
            ->where('pi_ix', $pi_ix)
            ->exec()
            ->getRow();

        return $data;
    }
}