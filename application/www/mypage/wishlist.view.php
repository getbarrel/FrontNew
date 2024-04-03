<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();

if(is_login()) {
    $view->mypageCommon();

    $wishModel      = $view->import('model.mall.wish');
    $displayModel   = $view->import('model.mall.display');
    $eventyModel    = $view->import('model.mall.event');

    $ContentWishList = $wishModel->getContentWishlist();

    $c = 0;
    foreach($ContentWishList['list'] as $key){

        if($key['type'] == "C"){
            $displayContentList = $displayModel->getDisplayContentDetail($key['con_ix']);

            $ContentWishList['list'][$c] = $displayContentList;

            $contentPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/content/' . $key['con_ix'] . '/'; //배너이미지 기본 경로
            $ContentWishList['list'][$c]['contentImgSrc'] = $contentPath.$displayContentList['list_img'];
            $ContentWishList['list'][$c]['group_title'] = nl2br($displayContentList['group_title']);
            $ContentWishList['list'][$c]['group_title_en'] = nl2br($displayContentList['group_title_en']);
            $ContentWishList['list'][$c]['group_preface'] = nl2br($displayContentList['group_preface']);
            $ContentWishList['list'][$c]['group_preface_en'] = nl2br($displayContentList['group_preface_en']);
            $ContentWishList['list'][$c]['group_explanation'] = nl2br($displayContentList['group_explanation']);
            $ContentWishList['list'][$c]['group_explanation_en'] = nl2br($displayContentList['group_explanation_en']);
            $ContentWishList['list'][$c]['group_display_start'] = date("Y.m.d",$displayContentList['group_display_start']);
            $ContentWishList['list'][$c]['group_display_end'] = date("Y.m.d",$displayContentList['group_display_end']);
            $ContentWishList['list'][$c]['display_gubun'] = $displayContentList['display_gubun'];

            if(substr($displayContentList['cid'],0,6) == "001002"){
                $ContentWishList['list'][$c]['display_gubun'] = "S";
            }
        }else if($key['type'] == "E"){
            $eventDetail = $eventyModel->getEventDetail($key['con_ix']);

            $domain = (!empty(IMAGE_SERVER_DOMAIN) ? IMAGE_SERVER_DOMAIN : HTTP_PROTOCOL . FORBIZ_HOST );

            $ContentWishList['list'][$c]['contentImgSrc'] = $domain . DATA_ROOT ."/images/event/" . $eventDetail['event_ix'] . "/event_banner_" . $eventDetail['event_ix'] . ".gif";
            //$ContentWishList['list'][$c]['title'] = $domain . DATA_ROOT ."/images/event/" . $key['con_ix'] . "/event_banner_" . $key['con_ix'] . ".gif";
            $ContentWishList['list'][$c]['display_gubun'] = "E";

            $ContentWishList['list'][$c]['title'] = $eventDetail['event_title'];
            $ContentWishList['list'][$c]['explanation'] = $eventDetail['startDate']." - ".$eventDetail['endDate'];
        }

        $c++;
    }

    $view->assign('ContentWishList', $ContentWishList);

    // Layout 출력
    echo $view->loadLayout();
} else {
    redirect('/member/login?url=/mypage/wishlist');
}
