<?php
/**
 * Description of CustomMallShopController
 *
 * @author hoksi
 */
class CustomMallDisplayController extends ForbizMallController
{
    /* @var $displayModel CustomMallDisplayModel */
    private $displayModel;

    public function __construct()
    {
        parent::__construct();
        $this->displayModel = $this->import('model.mall.display');
    }


    public function getMainDisplayGoods(){
        /* 기본 필터 */
        $max = $this->input->post('max');
        $page = $this->input->post('page');
        $mgIx = $this->input->post('mg_ix');
        $groupCode = $this->input->post('group_code');
        $productCnt = $this->input->post('product_cnt');


        /* @var $displayModel CustomMallDisplayModel */
        $displayModel = $this->import('model.mall.display');
        $responseData = $displayModel->getMainDisplayGoodsByPaging($mgIx, $groupCode, $productCnt,$page,$max);

        if (!empty($responseData['list'])) {
            foreach ($responseData['list'] as $key => $row) {
                $row['listprice'] = g_price($row['listprice']);
                $row['dcprice'] = g_price($row['dcprice']);
                $row['sellprice'] = g_price($row['sellprice']);
                $responseData['list'][$key] = $row;
            }
        }

        $this->setResponseResult('success')->setResponseData($responseData);
    }

    public function getSpecialListNew()
    {
        $res = $this->input->post();
        $orderBy = $res['orderBy'];
        $orderByType = $res['orderByType'];
        $page = $res['page'];
        $max = $res['max'];
        $paramCid = $res['paramCid'];

        $displayModel = $this->import('model.mall.display');
        //$responseData = $eventModel->getEventListNew('E', $orderBy, $orderByType, $page, $max, $state);
        $responseData = $displayModel->getDisplayContentListMo($orderBy, $orderByType, $page, $max, substr($paramCid,0,9));

        $this->setResponseResult('success')->setResponseData($responseData);
    }

}
