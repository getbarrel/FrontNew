<?php

/**
 * Description of ForbizMallProductModel
 *
 * @author hong
 */
class ForbizMallWishModel extends ForbizModel
{
    protected $userCode = false;

    public function __construct()
    {
        parent::__construct();

        $this->userCode = sess_val('user', 'code');
    }

    /**
     * 추가되어있는지 확인
     * @param string $id
     * @return boolean
     */
    public function checkAlreadyWish($id)
    {
        $datas = $this->qb
            ->from(TBL_SHOP_WISHLIST)
            ->where('pid', $id)
            ->where('mid', $this->userCode)
            ->getCount();
        if ($datas > 0) {
            return true;
        }
        return false;
    }

    /**
     * 추가
     * @param string $id
     */
    public function insertWish($id)
    {
        if (!empty($this->userCode)) {
            $this->qb->insert(TBL_SHOP_WISHLIST,
                [
                    'pid' => $id,
                    'mid' => $this->userCode,
                    'regdate' => date('Y-m-d H:i:s')
                ])->exec();
        }
        return;
    }

    /**
     * 위시리스트 삭제
     * @param array $id
     */
    public function deleteWish($id)
    {
        $this->qb->delete(TBL_SHOP_WISHLIST)
            ->whereIn('pid', $id)
            ->where('mid', $this->userCode)
            ->exec();
        return;
    }

    /**
     * 위시리스트 리스트
     * @param array $userId
     */
    public function getWishlist($userCode, $cur_page = 1, $per_page = 10, $is_paging = true)
    {

        /* @var $productModel CustomMallProductModel */
        $productModel = $this->import('model.mall.product');

        $this->qb->startCache();
        $productModel->basicWhere()
            ->select('sp.pid')
            ->from(TBL_SHOP_PRODUCT . ' as p')
            ->join(TBL_SHOP_WISHLIST . ' as sp', 'sp.pid = p.id')
            ->where('sp.mid', $userCode)
            ->stopCache();

        // Get total rows
        $total = $this->qb->getCount();

        if ($is_paging) {
            // Get paging data
            $paging = $this->qb
                ->setTotalRows($total)
                ->pagination($cur_page, $per_page);

            $limit = $per_page;
            $offset = $paging['offset'];
        } else {
            $limit = $per_page;
            $offset = ($cur_page - 1) * $per_page;
            $paging = false;
        }

        $list = [];
        if ($total > 0) {
            $ids = $this->qb
                ->orderBy('sp.regdate', 'desc')
                ->limit($limit, $offset)
                ->exec()
                ->getResultArray();
        }

        $this->qb->flushCache();

        if ($total > 0) {
            $list = $productModel->getListById(array_column($ids, 'pid'));
        }

        return [
            'list' => $list
            , 'paging' => $paging
            , 'total' => $total
        ];
    }


    /**
     * 컨텐츠 추가되어있는지 확인
     * @param string $id
     * @return boolean
     */
    public function checkAlreadyContentWish($con_ix, $type)
    {
        $datas = $this->qb
            ->from('shop_wishcontentlist')
            ->where('con_ix', $con_ix)
            ->where('type', $type)
            ->where('mid', $this->userCode)
            ->getCount();
        if ($datas > 0) {
            return true;
        }
        return false;
    }

    /**
     * 추가
     * @param string $id
     */
    public function insertContentWish($con_ix, $type)
    {
        if (!empty($this->userCode)) {
            $this->qb->insert('shop_wishcontentlist',
                [
                    'con_ix' => $con_ix,
                    'mid' => $this->userCode,
                    'type' => $type,
                    'regdate' => date('Y-m-d H:i:s')
                ])->exec();
        }
        return;
    }

    /**
     * 위시리스트 삭제
     * @param array $id
     */
    public function deleteContentWish($con_ix, $type)
    {
        $this->qb->delete('shop_wishcontentlist')
            ->whereIn('con_ix', $con_ix)
            ->where('mid', $this->userCode)
            ->where('type', $type)
            ->exec();
        return;
    }

    /**
     * 위시리스트 리스트
     * @param array $userId
     */
    public function getContentWishlist($cur_page = 1, $per_page = 10, $is_paging = true)
    {

        $result = $this->qb
            ->select('*')
            ->from('shop_wishcontentlist')
            ->where('mid', $this->userCode)
            ->exec()
            ->getResultArray();

        $total = $this->qb
            ->from('shop_wishcontentlist')
            ->where('mid', $this->userCode)
            ->getCount();

        if ($is_paging) {
            // Get paging data
            $paging = $this->qb
                ->setTotalRows($total)
                ->pagination($cur_page, $per_page);

            $limit = $per_page;
            $offset = $paging['offset'];
        } else {
            $limit = $per_page;
            $offset = ($cur_page - 1) * $per_page;
            $paging = false;
        }

        return [
            'list' => $result
            , 'paging' => $paging
            , 'total' => $total
        ];
    }




}