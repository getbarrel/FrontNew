<?php

/**
 * Description of CustomMallGlobalModel
 *
 * @author hoksi
 */
class CustomMallGlobalModel extends ForbizMallGlobalModel
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getNationInfo(){

        $datas = $this->qb
            ->select('nation_name')
            ->select('nation_code')
            ->select('national_phone')
            ->from(TBL_GLOBAL_NATION_CODE)
            ->whereNotIn('nation_code','kr')
            ->orderBy('nation_name','asc')
            ->exec()->getResultArray();

        return $datas;
    }

    public function getSelectNationInfo($nation_code){

        $data = $this->qb
            ->select('nation_name')
            ->select('nation_code')
            ->select('national_phone')
            ->from(TBL_GLOBAL_NATION_CODE)
            ->whereNotIn('nation_code','kr')
            ->where('nation_code',$nation_code)
            ->exec()->getRowArray();

        return $data;
    }

    public function getRegionalInformation(){

        $datas = $this->qb
            ->select('reg_code')
            ->select('reg_name')
            ->from(TBL_UNITED_STATES_REGIONAL_INFORMATION)
            ->orderBy('reg_name','asc')
            ->exec()->getResultArray();

        return $datas;

    }

    public function getGlobalUserInfo($code){
        $data = $this->qb
            ->select('country')
            ->select('city')
            ->select('state')
            ->from(TBL_COMMON_MEMBER_DETAIL)
            ->where('code',$code)
            ->exec()->getRowArray();
        return $data;
    }

    /**
     * 환율 변경 금액
     * @param $price
     * @return float
     */
    public function exchangePrice($price)
    {
        static $exchangeRate = false;
        if ($exchangeRate === false) {
            $data = $this->qb
                ->select('usd')
                ->from(TBL_COMMON_EXCHANGE_RATE)
                ->where('is_use', '1')
                ->exec()->getRowArray();
            $exchangeRate = $data['usd'];
        }
        return f_decimal(round($price / $exchangeRate, 2));
    }
}