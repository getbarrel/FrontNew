<?php

/**
 * Description of CustomMallPopupModel
 *
 * @author hoksi
 */
class CustomMallSellerModel extends ForbizMallSellerModel
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 상품상세 공지사항 출력
     * @param string $companyId
     * @return string
     */
    public function getSellerNotice($cid)
    {

        $datas = $this->qb->select('t1.*, t2.bd_ix, t2.bd_title, t2.bd_link, t2.bd_file')
            ->from(TBL_SHOP_BANNERINFO .' as t1')
            ->join(TBL_SHOP_BANNERINFO_DETAIL .' as t2', 't1.banner_ix = t2.banner_ix')
            ->join(TBL_SHOP_BANNER_DIV .' as t3', 't1.banner_page = t3.div_ix')
            ->where('t1.banner_page', 11)
            ->where('t1.disp', 1)
            ->where('DATE_FORMAT(use_sdate, \'%Y%m%d%H%i%s\') <= DATE_FORMAT(SYSDATE(), \'%Y%m%d%H%i%s\')')
            ->where('DATE_FORMAT(use_edate, \'%Y%m%d%H%i%s\') >= DATE_FORMAT(SYSDATE(), \'%Y%m%d%H%i%s\')')
            ->groupStart()
            ->where("substr(t1.display_cid,1,3) = '".substr($cid,0,3)."' OR substr(t1.display_cid,1,6) = '".substr($cid,0,6)."'  OR t1.display_cid = ''")
            ->groupEnd()
            ->orderBy('t1.display_cid, t1.regdate', 'DESC')
            ->limit('1')
            ->exec()
            ->getResultArray();

        $data = '';

        if(isset($datas['0'])){

            $data = $datas['0'];
            if($data['banner_kind']== '5'){
                $data['image_src'] = IMAGE_SERVER_DOMAIN. "/dewytree_data/images/banner/".$datas['0']['banner_ix']."/".$datas['0']['bd_file'];
            }else{
                $data['image_src'] = IMAGE_SERVER_DOMAIN. "/dewytree_data/images/banner/".$datas['0']['banner_ix']."/".$datas['0']['banner_img'];
            }
        }

        return $data;

    }


}