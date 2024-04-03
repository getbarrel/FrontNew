<?php

/**
 * Description of CustomMallPopupModel
 *
 * @author hoksi
 */
class CustomMallPopupModel extends ForbizModel
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getOrderHistory($userCode, $offset, $len)
    {
        $order_history = null;

        $result = $this->qb
            ->select('o.oid')
            ->from(TBL_SHOP_ORDER.' o')
            ->join(TBL_SHOP_ORDER_DETAIL.' od', 'od.oid = o.oid')
            ->where('od.status !=', '')
            ->where('o.status !=', 'SR')
            ->where('o.user_code', $userCode)
            ->groupBy('o.oid')
            ->orderBy('order_date', 'DESC')
            ->limit($len, $offset)
            ->exec();

        $total = $result->num_rows();

        if ($total) {
            $oids = [];

            foreach ($result->getResultArray() as $row) {
                $oids[] = $row['oid'];
            }

            $order_history = $this->qb
                ->select('*')
                ->select('COUNT(*) AS total', false)
                ->select('oc.od_count')
                ->select('SUM(ptprice) AS ptprice')
                ->select('COUNT(*)-1 AS outSide')
                ->select('SUM(dcprice) AS dcprice')
                ->from('shop_order_detail od')
                ->join(
                    $this->qb->startSubQuery('o')
                        ->select('oid')
                        ->select('order_date as date', false)
                        ->from('shop_order o')
                        ->where('user_code', $userCode)
                        ->where('o.status !=', 'SR')
                        ->whereIn('oid', $oids)
                        ->endSubQuery(), 'od.oid = o.oid'
                )
                ->join(
                    $this->qb->startSubQuery('oc')
                        ->select('o.oid')
                        ->select('COUNT(*) AS od_count', false)
                        ->select('o.payment_price')
                        ->from(TBL_SHOP_ORDER.' o')
                        ->join(TBL_SHOP_ORDER_DETAIL.' od', 'od.oid = o.oid')
                        ->where('user_code', $userCode)
                        ->where('o.status !=', 'SR')
                        ->groupBy('o.oid')
                        ->endSubQuery(), 'od.oid = oc.oid'
                )
                ->whereIn('od.oid', $oids)
                ->groupBy('od.oid')
                ->groupBy('company_id')
                ->orderBy('od.oid', 'desc')
                ->exec()
                ->getResultArray();
        }

        return [
            'total' => $total,
            'orderHistory' => $order_history
        ];
    }

	public function goodsSizeTitle(){
		$result = $this->qb
            ->select('cid')
			->select('title')
            ->from('shop_goods_size_info')
            ->where('size_use =', '1')
            ->where('depth =', '0')
            ->orderBy('cid', 'ASC')
            ->exec()
			->getResultArray();

		return $result;
	}


	public function goodsSizeList($cid){
		$result = $this->qb
            ->select('cid')
			->select('title')
			->select('title_img')
			->select('contents_pc')
			->select('contents_mo')
            ->from('shop_goods_size_info')
			->like('cid', $cid, 'after')
            ->where('size_use =', '1')
            ->where('depth =', '1')
            ->orderBy('cid', 'ASC')
            ->exec()
			->getResultArray();

		return $result;
	}
}