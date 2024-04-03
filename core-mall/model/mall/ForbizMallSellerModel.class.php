<?php

/**
 * Description of ForbizMallProductModel
 *
 * @author hong
 */
class ForbizMallSellerModel extends ForbizModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 셀러 공지사항 출력
     * @param string $companyId
     * @return string
     */
    public function getSellerNotice($companyId)
    {

        $datas = $this->qb->select('pn_ix')
            ->from(TBL_COMMON_SELLER_PROMOTION_NOTICE)
            ->where('company_id', $companyId)
            ->exec()
            ->getResultArray();

        $basicPath = DATA_ROOT . "/images/basic/sellergroup";
        foreach ($datas as $k => $v) { //공지사항은 항상 1개만 사용처리됨
            $imageSrc = $basicPath . '/seller_promotion_' . $v['pn_ix'] . '.jpg';
        }
        if (empty($imageSrc)) {
            return;
        }
        return IMAGE_SERVER_DOMAIN . $imageSrc;

    }

    /**
     * 셀러 마감시간 출력
     * @param string $companyId
     * @return array
     */
    public function getSellerDeadline($companyId)
    {
        $datas = $this->qb
            ->select('delivery_deadline_yn')
            ->select('delivery_deadline_hour')
            ->select('delivery_deadline_minute')
            ->select('average_delivery_day')
            ->from(TBL_COMMON_SELLER_DELIVERY . ' as d ')
            ->join(TBL_COMMON_SELLER_DETAIL . ' as sd ', 'd.company_id=sd.company_id', 'inner')
            ->where('d.company_id', $companyId)
            ->exec()
            ->getRowArray();

        return [
            'average_delivery_day' => $datas['average_delivery_day']
            , 'deadlineUse' => $datas['delivery_deadline_yn']
            , 'deadlineHour' => str_pad($datas['delivery_deadline_hour'], 2, '0', STR_PAD_LEFT)
            , 'deadlineMinute' => str_pad($datas['delivery_deadline_minute'], 2, '0', STR_PAD_LEFT)
        ];
    }
}
