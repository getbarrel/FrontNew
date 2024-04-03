<?php

/**
 * Description of ForbizMallCompanyModel
 *
 * @author hong
 */
class ForbizMallCompanyModel extends ForbizModel
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
            ->orderBy('startdate', 'DESC')
            ->exec()
            ->getResultArray();
    }

    /**
     * get 약관
     * @param array $argList
     * @return array
     */
    public function getPolicy(...$argList)
    {
        $returnData = [];

        if (count($argList) > 0) {

            $this->qb
                ->startCache()
                ->select('pi_ix')
                ->select('pi_code')
                ->select('left(startdate, 10) as regdate')
                ->select('pi_contents')
                ->from(TBL_SHOP_POLICY_INFO)
                ->where('disp', 'Y')
                ->where('startdate <= now()')
                ->orderBy('startdate', 'DESC')
                ->limit(1)
                ->stopCache();

            foreach ($argList as $piCode) {

                $row = $this->qb
                    ->where('pi_code', $piCode)
                    ->exec()
                    ->getRowArray();

                if (!empty($row)) {
                    $returnData[$row['pi_code']]['ix'] = $row['pi_ix'];
                    $row['pi_contents'] = str_replace("[DATE]", date("Y년 [m월 d일]", strtotime($row['regdate'])), $row['pi_contents']);
                    $returnData[$row['pi_code']]['contents'] = stripslashes($row['pi_contents']);
                }
            }

            $this->qb->flushCache();
        }

        return $returnData;
    }
}