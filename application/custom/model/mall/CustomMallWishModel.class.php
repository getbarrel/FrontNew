<?php

/**
 * 
 * @author hoksi
 */
class CustomMallWishModel extends ForbizMallWishModel
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getTotalWish() {

        $list = $this->qb->select('count(sp.pid) as cnt')
            ->from(TBL_SHOP_PRODUCT . ' as p')
            ->join(TBL_SHOP_WISHLIST . ' as sp', 'sp.pid = p.id')
            ->where('sp.mid', $this->userCode)
            ->exec()->getResult();

        return $list[0]->cnt;

    }
}