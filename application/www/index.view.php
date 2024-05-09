<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/***
 * 대기열 적용
 */
$WG_GATE_ID = WEB_GATE_ID_1;
$WG_SERVICE_ID  = WEB_GATE_SERVICE_ID;                   // fixed
$WG_SECRET_TEXT = "BARREL-LEGGINGS";   // fixed
$WG_VALIDATION_KEY  = $WG_SERVICE_ID . "-" . $WG_GATE_ID . "-" . $WG_SECRET_TEXT;
$WG_COOKIE_NAME     = "WG_VALIDATION_KEY";
$WG_GATE_SERVERS    = array("1012-0.devy.kr","1012-1.devy.kr","1012-2.devy.kr");

$wg_is_need_to_redirect = true;
if(isset($_COOKIE[$WG_COOKIE_NAME])) {
    $wg_cookie_value = $_COOKIE[$WG_COOKIE_NAME];
    if($wg_cookie_value == $WG_VALIDATION_KEY)
    {
        $wg_is_need_to_redirect = false;
    }
}

if($wg_is_need_to_redirect  && (defined('IS_USE_WEB_GATE') && IS_USE_WEB_GATE === true))
{
    // 검증키 체크가 실패한 경우, 즉 대기열 체크를 하지 않은 경우 이곳으로 진입합니다.
    $wg_isWaiting = false; // 대기자가 있는지 여부

    // WG_GATE_SERVERS 서버 중 임의의 서버에 API 호출 --> json 응답
    $wg_receiveLine="";
    $wg_receiveText="";
    // Fail-over를 위해 최대 2차까지 시도
    $wg_serverCount = count($WG_GATE_SERVERS);
    $wg_serverChoice1  = rand(0, $wg_serverCount-1); // 1차대기열서버 : 임의의 대기열 서버
    $wg_url1 =  "http://" . $WG_GATE_SERVERS[$wg_serverChoice1] . "/?ServiceId=" . $WG_SERVICE_ID . "&GateId=" . $WG_GATE_ID . "&Action=CHECK";
    $wg_serverChoice2 = ($wg_serverChoice1 + rand(1, $wg_serverCount-1)) % $wg_serverCount; // 2차대기열서버 :1차 서버를 제외한 임의의 서버
    $wg_url2 =  "http://" . $WG_GATE_SERVERS[$wg_serverChoice2] . "/?ServiceId=" . $WG_SERVICE_ID . "&GateId=" . $WG_GATE_ID . "&Action=CHECK";

    // 1차 시도
    $wg_responseText = file_get_contents($wg_url1);
    // 오류나면 공백 $wg_responseText이 null
    if ( $wg_responseText == null || $wg_responseText == "")
    {
        // 1차시도 실패 시 2차시도
        $wg_responseText = file_get_contents($wg_url2);
    }

    // 1차 또는 2차시도로 응답을 받은경우 json decode
    if ( $wg_responseText != null && $wg_responseText != "")
    {
        $wg_responseJson = json_decode($wg_responseText);

        $wg_apiResultCode    = $wg_responseJson->ResultCode;        // 0:정상, 그외 : 오류
        $wg_apiResultMessage = $wg_responseJson->ResultMessage;     // "PASS" or "WAIT"

        // 대기자 수가 있으면 대기열 UI 표시(WAIT)
        // 대기자 수가 없으면 PASS
        $wg_isWaiting = $wg_apiResultCode == 0 && $wg_apiResultMessage == "WAIT";
        // 대기가 있는 경우
        if ($wg_isWaiting) {
            // 대기열 호출용 html로 load
            $doc = new DOMDocument('1.0', 'UTF-8');
            $internalErrors = libxml_use_internal_errors(true);
            $loadPagePath = $_SERVER['DOCUMENT_ROOT']."/gate/LoadWebGate.html";
            $doc->loadHTMLFile($loadPagePath);
            $html = $doc->saveHTML();
            // load한 html로 응답을 교체하고 return
            print str_replace("WG_GATE_ID", $WG_GATE_ID, $html); // SET Gate ID
            return;
        }
        // 대기가 없는 경우
        else {
            // 냉무 : 별도의 코딩 필요 없음
        }
    }
}

setcookie($WG_COOKIE_NAME, "", time() + (-1 * 86400), "/"); // 86400 = 1 day

if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === true) {
    header("Location: " . HTTP_PROTOCOL . FORBIZ_HOST . "/event/eventDetail/271");
    die();
}

$view = getForbizView();
/* @var $displayModel CustomMallDisplayModel */
$displayModel = $view->import('model.mall.display');
$productModel = $view->import('model.mall.product');
$wishModel = $view->import('model.mall.wish');

#배너팝업가져오기
/*$slideBannerPopUp = $displayModel->getDisplayBannerGroup(69);
$view->assign('slideBannerPopUp', $slideBannerPopUp);*/

#메인 상단 프로모션 배너 노출
$mainBannerInfo = $displayModel->getDisplayBannerGroup(67);

#동영상 노출
$mainMovieBannerInfo = $displayModel->getDisplayBannerGroup(68);

if ($view->isCached() === false) {
    if (is_mobile()) {
        #메인 상단 프로모션 배너 노출
        //$mainBannerInfo = $displayModel->getDisplayBannerGroup(2);
        $num = 0;
        foreach($mainBannerInfo as $key => $val){
            if($val['banner_loc'] == "A" || $val['banner_loc'] == "M"){

                $mainBannerInfo_m[$num]['banner_desc'] = nl2br($val['banner_desc']);
                $mainBannerInfo_m[$num] = $val;

                $num++;
            }
        }

        $view->assign('mainBannerInfo', $mainBannerInfo_m);

        $num = 0;
        foreach($mainMovieBannerInfo as $key => $val){
            if($val['banner_loc'] == "A" || $val['banner_loc'] == "M"){
                $mainMovieBannerInfo_m[$num] = $val;
                $num++;
            }
        }

        $view->assign('mainMovieBannerInfo', $mainMovieBannerInfo_m);
		
        #메인페이지 가져오기
        $mainContentInfo = $displayModel->getContentMain();
        $view->assign('mainContentInfo', $mainContentInfo);

        #메인페이지 추천기획전 가져오기(추천기획전 사용유무 사용/미사용 여부 확인)
        if($mainContentInfo['special_use'] == 'Y'){
            $mainContentSpecialInfo = $displayModel->getContentMainContent($mainContentInfo['conm_ix'], "E");
        if($_SERVER["REMOTE_ADDR"] == '211.104.22.53'){
			//print_r($mainContentSpecialInfo);
			//$max = 10;
        }
            $c = 0;
            foreach($mainContentSpecialInfo as $key){
                if($wishModel->checkAlreadyContentWish($key['con_ix'], 'C')){
                    $mainContentSpecialInfo[$c]['alreadyWishContent'] = 'Y';
                }else{
                    $mainContentSpecialInfo[$c]['alreadyWishContent'] = 'N';
                }
                $c++;
            }
            $view->assign('mainContentSpecialInfo', $mainContentSpecialInfo);
        }

        #메인페이지 베스트아이템 설정 가져오기(베스트아이템 사용유무 사용/미사용 여부 확인)
        if($mainContentInfo['best_use'] == 'Y' && $mainContentInfo['bast_cate']){
            $mainCategoryInfo = $displayModel->getCategoryInfo($mainContentInfo['bast_cate']);

            if($mainCategoryInfo['depth'] == 0){
                $subCate = substr($mainContentInfo['bast_cate'],0,3);
            }else if($mainCategoryInfo['depth'] == 1){
                $subCate =  substr($mainContentInfo['bast_cate'],0,6);
            }else if($mainCategoryInfo['depth'] == 2){
                $subCate =  substr($mainContentInfo['bast_cate'],0,9);
            }else if($mainCategoryInfo['depth'] == 3){
                $subCate =  substr($mainContentInfo['bast_cate'],0,12);
            }else if($mainCategoryInfo['depth'] == 4){
                $subCate =  $mainContentInfo['bast_cate'];
            }
            $view->assign('mainBastCateCode', $mainContentInfo['bast_cate']);

            $mainBastCateList = $displayModel->getBastCateInfo($subCate, $mainCategoryInfo['depth']);
            $view->assign('mainBastCateList', $mainBastCateList);

            foreach($mainBastCateList as $key => $val){

                if($mainCategoryInfo['depth'] == 0){
                    $mainBastCateProductInfo = $displayModel->getBastCateProductInfo(substr($val['cid'],0,6), $val['category_sort']);
                }else{
                    $mainBastCateProductInfo = $displayModel->getBastCateProductInfo($val['cid'], $val['category_sort']);
                }

                $ids = [];
                foreach($mainBastCateProductInfo as $key1 => $val1){
                    $ids[] = $val1['id'];
                }

                $mainBastCateProductList = $productModel->getListById($ids);
                $mainBastCateProductListAll[$key]['bastProductList'] = $mainBastCateProductList;

                if (!empty($mainBastCateProductListAll[$key]['bastProductList'])) {
                    foreach ($mainBastCateProductListAll[$key]['bastProductList'] as $key1 => $row) {
                        $row['listprice'] = g_price($row['listprice']);
                        $row['dcprice'] = g_price($row['dcprice']);
                        $row['sellprice'] = g_price($row['sellprice']);
                        $preface = explode('_', $row['preface']);
                        $row['preface'] = $preface[0];
                        $mainBastCateProductListAll[$key]['bastProductList'][$key1] = $row;
                    }
                }
            }
            $view->assign('mainBastCateProductListAll', $mainBastCateProductListAll);
            $view->assign('mainBastCateUse', "Y");
        }else{
            $view->assign('mainBastCateUse', "N");
        }

        #메인페이지에 등록된 상품그룹 가져오기
        $mainContentMainGroupInfo = $displayModel->getContentMainGroup($mainContentInfo['conm_ix']);
        $view->assign('mainContentMainGroupInfo', $mainContentMainGroupInfo);

        $n = 0;
        $num = 0;
        foreach($mainContentMainGroupInfo as $key => $val){
            $mainContentMainGroupRelationInfo = $displayModel->getContentMainGroupRelationMo($val['cmgr_ix']);

            foreach($mainContentMainGroupRelationInfo as $key5 => $val5){
                if($val5['group_con_gubun'] == "S"){
                    $num++;
                }

                if($val5['group_con_gubun'] == "B" && $before_group_con_gubun == $val5['group_con_gubun']){
                    if($key5 != 0){
                        $mainContentMainGroupRelationInfo[$key5-1]['slider_group_con_gubun'] = "Y";
                    }
                    $mainContentMainGroupRelationInfo[$key5]['slider_group_con_gubun'] = "Y";
                }else{
                    $mainContentMainGroupRelationInfo[$key5]['slider_group_con_gubun'] = "N";
                }

                $before_group_con_gubun = $val5['group_con_gubun'];
            }

            $cnt = 0;
            $b = 0;

            foreach($mainContentMainGroupRelationInfo as $key1 => $val1){
                if($val1['group_con_gubun'] == "S"){
                    if($b > 0){
                        $b = 0;
                    }
                    $mainContentGroupRelationInfo = $displayModel->getContentGroupRelation($val1['con_ix']);

                    foreach($mainContentGroupRelationInfo as $key2 => $val2){
                        $mainContentGroupProductRelationInfo = $displayModel->getContentGroupProductRelation($val1['con_ix'], $val2['cgr_ix']);
                        //$mainContentGroupProductRelationInfo = $displayModel->getContentGroupProductRelation($val1['con_ix']);

                        $ids = [];
                        foreach($mainContentGroupProductRelationInfo as $key3 => $val3){
                            $ids[] = $val3['pid'];
                        }

                        $mainContentGroupProductRelationList = $productModel->getListById($ids);
                        $mainContentMainGroupRelationList[$n] = $val2;
                        $mainContentMainGroupRelationList[$n]['displayCnt']         = $cnt;
                        //if($val1['group_con_gubun'] == "S"){
                            $cnt++;
                        //}
                        //$mainContentMainGroupRelationList[$n]['displayTotalCnt']    = count($mainContentGroupRelationInfo)-1;
                        $mainContentMainGroupRelationList[$n]['displayTotalCnt']    = $num;
                        $mainContentMainGroupRelationList[$n]['con_ix']             = $val1['con_ix'];
                        $mainContentMainGroupRelationList[$n]['group_con_gubun']    = $val1['group_con_gubun'];
                        $mainContentMainGroupRelationList[$n]['contentImgSrc']      = $val1['contentImgSrcM'];
                        $mainContentMainGroupRelationList[$n]['title']      = $val1['title'];
                        $mainContentMainGroupRelationList[$n]['s_title']      = $val1['s_title'];
                        $mainContentMainGroupRelationList[$n]['b_title']      = $val1['b_title'];
                        $mainContentMainGroupRelationList[$n]['i_title']      = $val1['i_title'];
                        $mainContentMainGroupRelationList[$n]['u_title']      = $val1['u_title'];
                        $mainContentMainGroupRelationList[$n]['c_title']      = $val1['c_title'];
                        $mainContentMainGroupRelationList[$n]['main_group_title']   = $val['main_group_title'];
                        $mainContentMainGroupRelationList[$n]['main_group_title_en']= $val['main_group_title_en'];
                        $mainContentMainGroupRelationList[$n]['b_main_group_title'] = $val['b_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['i_main_group_title'] = $val['i_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['u_main_group_title'] = $val['u_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['c_main_group_title'] = $val['c_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['s_main_group_title'] = $val['s_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['main_group_explanation']   = $val['main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['main_group_explanation_en']= $val['main_group_explanation_en'];
                        $mainContentMainGroupRelationList[$n]['b_main_group_explanation'] = $val['b_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['i_main_group_explanation'] = $val['i_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['u_main_group_explanation'] = $val['u_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['c_main_group_explanation'] = $val['c_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['bastProductList']    = $mainContentGroupProductRelationList;

                        if (!empty($mainContentMainGroupRelationList[$n]['bastProductList'])) {
                            foreach ($mainContentMainGroupRelationList[$n]['bastProductList'] as $key4 => $row) {
                                $row['listprice'] = g_price($row['listprice']);
                                $row['dcprice'] = g_price($row['dcprice']);
                                $row['sellprice'] = g_price($row['sellprice']);
                                $preface = explode('_', $row['preface']);
                                $row['preface'] = $preface[0];
                                $mainContentMainGroupRelationList[$n]['bastProductList'][$key4] = $row;
                            }
                        }
                    }
                }else{
                    if($val1['slider_group_con_gubun'] == "Y"){
                        if($b == 0){
                            $mainContentMainGroupRelationList[$n]['displayCnt']         = $cnt;
                            $mainContentMainGroupRelationList[$n]['main_group_title']   = $val['main_group_title'];
                            $mainContentMainGroupRelationList[$n]['main_group_title_en']= $val['main_group_title_en'];
                            $mainContentMainGroupRelationList[$n]['b_main_group_title'] = $val['b_main_group_title'];
                            $mainContentMainGroupRelationList[$n]['i_main_group_title'] = $val['i_main_group_title'];
                            $mainContentMainGroupRelationList[$n]['u_main_group_title'] = $val['u_main_group_title'];
                            $mainContentMainGroupRelationList[$n]['c_main_group_title'] = $val['c_main_group_title'];
                            $mainContentMainGroupRelationList[$n]['s_main_group_title'] = $val['s_main_group_title'];
                            $mainContentMainGroupRelationList[$n]['main_group_explanation']   = $val['main_group_explanation'];
                            $mainContentMainGroupRelationList[$n]['main_group_explanation_en']= $val['main_group_explanation_en'];
                            $mainContentMainGroupRelationList[$n]['b_main_group_explanation'] = $val['b_main_group_explanation'];
                            $mainContentMainGroupRelationList[$n]['i_main_group_explanation'] = $val['i_main_group_explanation'];
                            $mainContentMainGroupRelationList[$n]['u_main_group_explanation'] = $val['u_main_group_explanation'];
                            $mainContentMainGroupRelationList[$n]['c_main_group_explanation'] = $val['c_main_group_explanation'];
                            $mainContentMainGroupRelationList[$n]['group_con_gubun']            = $val1['group_con_gubun'];
                            $mainContentMainGroupRelationList[$n]['slider_group_con_gubun']     = $val1['slider_group_con_gubun'];
                        }
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['con_ix']             = $val1['con_ix'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['group_con_gubun']    = $val1['group_con_gubun'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['contentImgSrc']      = $val1['contentImgSrcM'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['banner_link']        = $val1['banner_link'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['banner_desc']        = $val1['banner_desc'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['banner_name']        = $val1['title'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['b_name']        = $val1['b_name'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['i_name']        = $val1['i_name'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['u_name']        = $val1['u_name'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['c_name']        = $val1['c_name'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['s_name']        = $val1['s_name'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['b_desc']        = $val1['b_desc'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['i_desc']        = $val1['i_desc'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['u_desc']        = $val1['u_desc'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['c_desc']        = $val1['c_desc'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['s_desc']        = $val1['s_desc'];

                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['shot_title']     = $val1['shot_title'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['b_title']        = $val1['b_title'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['i_title']        = $val1['i_title'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['u_title']        = $val1['u_title'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['c_title']        = $val1['c_title'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['s_title']        = $val1['s_title'];
                        $b++;
                    }else{
                        $mainContentMainGroupRelationList[$n]['displayCnt']         = $cnt;
                        $mainContentMainGroupRelationList[$n]['main_group_title']   = $val['main_group_title'];
                        $mainContentMainGroupRelationList[$n]['main_group_title_en']= $val['main_group_title_en'];
                        $mainContentMainGroupRelationList[$n]['b_main_group_title'] = $val['b_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['i_main_group_title'] = $val['i_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['u_main_group_title'] = $val['u_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['c_main_group_title'] = $val['c_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['s_main_group_title'] = $val['s_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['main_group_explanation']   = $val['main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['main_group_explanation_en']= $val['main_group_explanation_en'];
                        $mainContentMainGroupRelationList[$n]['b_main_group_explanation'] = $val['b_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['i_main_group_explanation'] = $val['i_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['u_main_group_explanation'] = $val['u_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['c_main_group_explanation'] = $val['c_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['con_ix']             = $val1['con_ix'];
                        $mainContentMainGroupRelationList[$n]['group_con_gubun']    = $val1['group_con_gubun'];
                        $mainContentMainGroupRelationList[$n]['contentImgSrc']      = $val1['contentImgSrcM'];
                        $mainContentMainGroupRelationList[$n]['banner_link']        = $val1['banner_link'];
                        $mainContentMainGroupRelationList[$n]['slider_group_con_gubun']    = $val1['slider_group_con_gubun'];
                        $mainContentMainGroupRelationList[$n]['banner_desc']   = $val1['banner_desc'];
                        $mainContentMainGroupRelationList[$n]['banner_name']   = $val1['title'];
                        $mainContentMainGroupRelationList[$n]['b_name']        = $val1['b_name'];
                        $mainContentMainGroupRelationList[$n]['i_name']        = $val1['i_name'];
                        $mainContentMainGroupRelationList[$n]['u_name']        = $val1['u_name'];
                        $mainContentMainGroupRelationList[$n]['c_name']        = $val1['c_name'];
                        $mainContentMainGroupRelationList[$n]['s_name']        = $val1['s_name'];
                        $mainContentMainGroupRelationList[$n]['b_desc']        = $val1['b_desc'];
                        $mainContentMainGroupRelationList[$n]['i_desc']        = $val1['i_desc'];
                        $mainContentMainGroupRelationList[$n]['u_desc']        = $val1['u_desc'];
                        $mainContentMainGroupRelationList[$n]['c_desc']        = $val1['c_desc'];
                        $mainContentMainGroupRelationList[$n]['s_desc']        = $val1['s_desc'];
                        $mainContentMainGroupRelationList[$n]['shot_title']    = $val1['shot_title'];
                        $mainContentMainGroupRelationList[$n]['b_title']       = $val1['b_title'];
                        $mainContentMainGroupRelationList[$n]['i_title']       = $val1['i_title'];
                        $mainContentMainGroupRelationList[$n]['u_title']       = $val1['u_title'];
                        $mainContentMainGroupRelationList[$n]['c_title']       = $val1['c_title'];
                        $mainContentMainGroupRelationList[$n]['s_title']       = $val1['s_title'];
                        $b=0;
                    }
                    $cnt++;
                }
                $n++;
            }
        }
        $view->assign('mainContentMainGroupRelationList', $mainContentMainGroupRelationList);

        #메인페이지 추천스타일 가져오기(추천스타일 사용유무 사용/미사용 여부 확인)
        if($mainContentInfo['style_use'] == 'Y'){

            $displayContentClassDepthList = $displayModel->getDisplayContentClass('001002', "S");

            $n = 0;
            foreach($displayContentClassDepthList as $key){
                //$mainContentStyleInfo = $displayModel->getContentMainContent($mainContentInfo['conm_ix'], "S");
                //$mainContentStyleInfo = $displayModel->getContentMainStyleContent($key['cid'], "S");
                $cid = $key['cid'];
                if($key['depth'] == 1){
                    $cid =  substr($cid,0,6);
                }
                $mainContentStyleInfo = $displayModel->getContentMainStyleContent($cid, "S", $mainContentInfo['conm_ix']);

                $displayContentClassDepthList[$n]['styleGuide'] = $mainContentStyleInfo;
                $n++;
            }

            $view->assign('displayContentClassStyleList', $displayContentClassDepthList);

            //$displayContentClassDepthList['styleGuide'] = $mainContentStyleInfo;

            //$view->assign('mainContentStyleInfo', $mainContentStyleInfo);
        }

        #메인페이지 추천스타일 가져오기(추천스타일 사용유무 사용/미사용 여부 확인)
        /*if($mainContentInfo['style_use'] == 'Y'){
            $mainContentStyleInfo = $displayModel->getContentMainContent($mainContentInfo['conm_ix'], "S");
            $view->assign('mainContentStyleInfo', $mainContentStyleInfo);
        }

        $displayContentClassDepthList = $displayModel->getDisplayContentClass('001002');

        $view->assign('displayContentClassStyleList', $displayContentClassDepthList);*/

        //메인저널
        $mainJournalInfo = $displayModel->getDisplayJournalInfo();
        $view->assign('mainJournalInfo', $mainJournalInfo);

        #메인페이지 추천컨텐츠 가져오기(추천컨텐츠 사용유무 사용/미사용 여부 확인)
        if($mainContentInfo['content_use'] == 'Y'){
            $mainContentContentInfo = $displayModel->getContentMainContent($mainContentInfo['conm_ix'], "C");

            $c = 0;
            foreach($mainContentContentInfo as $key){
                if($wishModel->checkAlreadyContentWish($key['con_ix'], 'C')){
                    $mainContentContentInfo[$c]['alreadyWishContent'] = 'Y';
                }else{
                    $mainContentContentInfo[$c]['alreadyWishContent'] = 'N';
                }
                $c++;
            }

            $view->assign('mainContentContentInfo', $mainContentContentInfo);
        }

        #동영상 노출
        /*$mainMovieBannerInfo = $displayModel->getDisplayBannerGroup(4);
        $view->assign('mainMovieBannerInfo', $mainMovieBannerInfo);*/
    } else {
        #메인 상단 프로모션 배너 노출
        //$mainBannerInfo = $displayModel->getDisplayBannerGroup(13);

        $num = 0;
        foreach($mainBannerInfo as $key => $val){
            if($val['banner_loc'] == "A" || $val['banner_loc'] == "P"){

                //$mainBannerInfo_p[$num]['banner_desc'] = nl2br($val['banner_desc']);
                $mainBannerInfo_p[$num] = $val;

                $num++;
            }
        }

        $view->assign('mainBannerInfo', $mainBannerInfo_p);

        $num = 0;
        foreach($mainMovieBannerInfo as $key => $val){
            if($val['banner_loc'] == "A" || $val['banner_loc'] == "P"){
                $mainMovieBannerInfo_p[$num] = $val;
                $num++;
            }
        }

        $view->assign('mainMovieBannerInfo', $mainMovieBannerInfo_p);

        #메인페이지 가져오기
        $mainContentInfo = $displayModel->getContentMain();
        $view->assign('mainContentInfo', $mainContentInfo);

        #메인페이지 추천기획전 가져오기(추천기획전 사용유무 사용/미사용 여부 확인)
        if($mainContentInfo['special_use'] == 'Y'){
            $mainContentSpecialInfo = $displayModel->getContentMainContent($mainContentInfo['conm_ix'], "E");
            $wishModel = $view->import('model.mall.wish');

            $c = 0;
            foreach($mainContentSpecialInfo as $key){
                if($wishModel->checkAlreadyContentWish($key['con_ix'], 'C')){
                    $mainContentSpecialInfo[$c]['alreadyWishContent'] = 'Y';
                }else{
                    $mainContentSpecialInfo[$c]['alreadyWishContent'] = 'N';
                }
                $c++;
            }
            $view->assign('mainContentSpecialInfo', $mainContentSpecialInfo);
        }

        #메인페이지 베스트아이템 설정 가져오기(베스트아이템 사용유무 사용/미사용 여부 확인)
        if($mainContentInfo['best_use'] == 'Y' && $mainContentInfo['bast_cate']){

            $mainCategoryInfo = $displayModel->getCategoryInfo($mainContentInfo['bast_cate']);

            if($mainCategoryInfo['depth'] == 0){
                $subCate = substr($mainContentInfo['bast_cate'],0,3);
            }else if($mainCategoryInfo['depth'] == 1){
                $subCate =  substr($mainContentInfo['bast_cate'],0,6);
            }else if($mainCategoryInfo['depth'] == 2){
                $subCate =  substr($mainContentInfo['bast_cate'],0,9);
            }else if($mainCategoryInfo['depth'] == 3){
                $subCate =  substr($mainContentInfo['bast_cate'],0,12);
            }else if($mainCategoryInfo['depth'] == 4){
                $subCate =  $mainContentInfo['bast_cate'];
            }
            $view->assign('mainBastCateCode', $mainContentInfo['bast_cate']);

            $mainBastCateList = $displayModel->getBastCateInfo($subCate, $mainCategoryInfo['depth']);

            $view->assign('mainBastCateList', $mainBastCateList);

            foreach($mainBastCateList as $key => $val){
                if($mainCategoryInfo['depth'] == 0){
                    $mainBastCateProductInfo = $displayModel->getBastCateProductInfo(substr($val['cid'],0,6), $val['category_sort']);
                }else{
                    $mainBastCateProductInfo = $displayModel->getBastCateProductInfo($val['cid'], $val['category_sort']);
                }

                $ids = [];
                foreach($mainBastCateProductInfo as $key1 => $val1){
                    $ids[] = $val1['id'];
                }

                $mainBastCateProductList = $productModel->getListById($ids);
                $mainBastCateProductListAll[$key]['cid']             = $val['cid'];
                $mainBastCateProductListAll[$key]['cname']           = $val['cname'];
                $mainBastCateProductListAll[$key]['bastProductList'] = $mainBastCateProductList;

                if (!empty($mainBastCateProductListAll[$key]['bastProductList'])) {
                    foreach ($mainBastCateProductListAll[$key]['bastProductList'] as $key1 => $row) {
                        $row['listprice'] = g_price($row['listprice']);
                        $row['dcprice'] = g_price($row['dcprice']);
                        $row['sellprice'] = g_price($row['sellprice']);
                        $preface = explode('_', $row['preface']);
                        $row['preface'] = $preface[0];
                        $mainBastCateProductListAll[$key]['bastProductList'][$key1] = $row;
                    }
                }
            }

            $view->assign('mainBastCateProductListAll', $mainBastCateProductListAll);
            $view->assign('mainBastCateUse', "Y");
        }else{
            $view->assign('mainBastCateUse', "N");
        }

        #메인페이지에 등록된 상품그룹 가져오기
        $mainContentMainGroupInfo = $displayModel->getContentMainGroup($mainContentInfo['conm_ix']);
        $view->assign('mainContentMainGroupInfo', $mainContentMainGroupInfo);

        $n = 0;
        $num = 0;
        foreach($mainContentMainGroupInfo as $key => $val){
            $mainContentMainGroupRelationInfo = $displayModel->getContentMainGroupRelationPC($val['cmgr_ix']);

            foreach($mainContentMainGroupRelationInfo as $key5 => $val5){
                if($val5['group_con_gubun'] == "S"){
                    $num++;
                }

                if($val5['group_con_gubun'] == "B" && $before_group_con_gubun == $val5['group_con_gubun']){
                    if($key5 != 0){
                        $mainContentMainGroupRelationInfo[$key5-1]['slider_group_con_gubun'] = "Y";
                    }
                    $mainContentMainGroupRelationInfo[$key5]['slider_group_con_gubun'] = "Y";
                }else{
                    $mainContentMainGroupRelationInfo[$key5]['slider_group_con_gubun'] = "N";
                }

                $before_group_con_gubun = $val5['group_con_gubun'];
            }

            $cnt = 0;
            $b = 0;

            /*if($_SERVER["REMOTE_ADDR"] == '211.104.22.53'){
                print_r($mainContentMainGroupRelationInfo);
                exit;
            }*/

            foreach($mainContentMainGroupRelationInfo as $key1 => $val1){
                if($val1['group_con_gubun'] == "S"){
                    if($b > 0){
                        $b = 0;
                    }
                    $mainContentGroupRelationInfo = $displayModel->getContentGroupRelation($val1['con_ix']);

                    foreach($mainContentGroupRelationInfo as $key2 => $val2){
                        $mainContentGroupProductRelationInfo = $displayModel->getContentGroupProductRelation($val1['con_ix'], $val2['cgr_ix']);
                        //$mainContentGroupProductRelationInfo = $displayModel->getContentGroupProductRelation($val1['con_ix']);

                        $ids = [];
                        foreach($mainContentGroupProductRelationInfo as $key3 => $val3){
                            $ids[] = $val3['pid'];
                        }

                        $mainContentGroupProductRelationList = $productModel->getListById($ids);
                        $mainContentMainGroupRelationList[$n] = $val2;
                        $mainContentMainGroupRelationList[$n]['displayCnt']         = $cnt;
                        //if($val1['group_con_gubun'] == "S"){
                            $cnt++;
                        //}
                        //$mainContentMainGroupRelationList[$n]['displayTotalCnt']    = count($mainContentGroupRelationInfo)-1;
                        $mainContentMainGroupRelationList[$n]['displayTotalCnt']    = $num;
                        $mainContentMainGroupRelationList[$n]['con_ix']             = $val1['con_ix'];
                        $mainContentMainGroupRelationList[$n]['group_con_gubun']    = $val1['group_con_gubun'];
                        $mainContentMainGroupRelationList[$n]['contentImgSrc']      = $val1['contentImgSrc'];

                        $mainContentMainGroupRelationList[$n]['title']      = $val1['title'];
                        $mainContentMainGroupRelationList[$n]['s_title']      = $val1['s_title'];
                        $mainContentMainGroupRelationList[$n]['b_title']      = $val1['b_title'];
                        $mainContentMainGroupRelationList[$n]['i_title']      = $val1['i_title'];
                        $mainContentMainGroupRelationList[$n]['u_title']      = $val1['u_title'];
                        $mainContentMainGroupRelationList[$n]['c_title']      = $val1['c_title'];


                        $mainContentMainGroupRelationList[$n]['main_group_title']   = $val['main_group_title'];
                        $mainContentMainGroupRelationList[$n]['main_group_title_en']= $val['main_group_title_en'];
                        $mainContentMainGroupRelationList[$n]['b_main_group_title'] = $val['b_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['i_main_group_title'] = $val['i_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['u_main_group_title'] = $val['u_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['c_main_group_title'] = $val['c_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['s_main_group_title'] = $val['s_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['main_group_explanation']   = $val['main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['main_group_explanation_en']= $val['main_group_explanation_en'];
                        $mainContentMainGroupRelationList[$n]['b_main_group_explanation'] = $val['b_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['i_main_group_explanation'] = $val['i_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['u_main_group_explanation'] = $val['u_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['c_main_group_explanation'] = $val['c_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['bastProductList']    = $mainContentGroupProductRelationList;

                        if (!empty($mainContentMainGroupRelationList[$n]['bastProductList'])) {
                            foreach ($mainContentMainGroupRelationList[$n]['bastProductList'] as $key4 => $row) {
                                $row['listprice'] = g_price($row['listprice']);
                                $row['dcprice'] = g_price($row['dcprice']);
                                $row['sellprice'] = g_price($row['sellprice']);
                                $preface = explode('_', $row['preface']);
                                $row['preface'] = $preface[0];
                                $mainContentMainGroupRelationList[$n]['bastProductList'][$key4] = $row;
                            }
                        }
                    }
                }else{
                    if($val1['slider_group_con_gubun'] == "Y"){
                        if($b == 0){
                            $mainContentMainGroupRelationList[$n]['displayCnt']         = $cnt;
                            $mainContentMainGroupRelationList[$n]['main_group_title']   = $val['main_group_title'];
                            $mainContentMainGroupRelationList[$n]['main_group_title_en']= $val['main_group_title_en'];
                            $mainContentMainGroupRelationList[$n]['b_main_group_title'] = $val['b_main_group_title'];
                            $mainContentMainGroupRelationList[$n]['i_main_group_title'] = $val['i_main_group_title'];
                            $mainContentMainGroupRelationList[$n]['u_main_group_title'] = $val['u_main_group_title'];
                            $mainContentMainGroupRelationList[$n]['c_main_group_title'] = $val['c_main_group_title'];
                            $mainContentMainGroupRelationList[$n]['s_main_group_title'] = $val['s_main_group_title'];
                            $mainContentMainGroupRelationList[$n]['main_group_explanation']   = $val['main_group_explanation'];
                            $mainContentMainGroupRelationList[$n]['main_group_explanation_en']= $val['main_group_explanation_en'];
                            $mainContentMainGroupRelationList[$n]['b_main_group_explanation'] = $val['b_main_group_explanation'];
                            $mainContentMainGroupRelationList[$n]['i_main_group_explanation'] = $val['i_main_group_explanation'];
                            $mainContentMainGroupRelationList[$n]['u_main_group_explanation'] = $val['u_main_group_explanation'];
                            $mainContentMainGroupRelationList[$n]['c_main_group_explanation'] = $val['c_main_group_explanation'];
                            $mainContentMainGroupRelationList[$n]['group_con_gubun']            = $val1['group_con_gubun'];
                            $mainContentMainGroupRelationList[$n]['slider_group_con_gubun']     = $val1['slider_group_con_gubun'];
                        }
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['con_ix']             = $val1['con_ix'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['group_con_gubun']    = $val1['group_con_gubun'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['contentImgSrc']      = $val1['contentImgSrc'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['banner_link']        = $val1['banner_link'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['banner_desc']        = $val1['banner_desc'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['banner_name']        = $val1['title'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['b_name']        = $val1['b_name'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['i_name']        = $val1['i_name'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['u_name']        = $val1['u_name'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['c_name']        = $val1['c_name'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['s_name']        = $val1['s_name'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['b_desc']        = $val1['b_desc'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['i_desc']        = $val1['i_desc'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['u_desc']        = $val1['u_desc'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['c_desc']        = $val1['c_desc'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['s_desc']        = $val1['s_desc'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['shot_title']     = $val1['shot_title'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['b_title']        = $val1['b_title'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['i_title']        = $val1['i_title'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['u_title']        = $val1['u_title'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['c_title']        = $val1['c_title'];
                        $mainContentMainGroupRelationList[$n-$b]['slider_banner'][$b]['s_title']        = $val1['s_title'];
                        $b++;
                    }else{
                        $mainContentMainGroupRelationList[$n]['displayCnt']         = $cnt;
                        $mainContentMainGroupRelationList[$n]['main_group_title']   = $val['main_group_title'];
                        $mainContentMainGroupRelationList[$n]['main_group_title_en']= $val['main_group_title_en'];
                        $mainContentMainGroupRelationList[$n]['b_main_group_title'] = $val['b_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['i_main_group_title'] = $val['i_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['u_main_group_title'] = $val['u_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['c_main_group_title'] = $val['c_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['s_main_group_title'] = $val['s_main_group_title'];
                        $mainContentMainGroupRelationList[$n]['main_group_explanation']   = $val['main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['main_group_explanation_en']= $val['main_group_explanation_en'];
                        $mainContentMainGroupRelationList[$n]['b_main_group_explanation'] = $val['b_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['i_main_group_explanation'] = $val['i_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['u_main_group_explanation'] = $val['u_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['c_main_group_explanation'] = $val['c_main_group_explanation'];
                        $mainContentMainGroupRelationList[$n]['con_ix']             = $val1['con_ix'];
                        $mainContentMainGroupRelationList[$n]['group_con_gubun']    = $val1['group_con_gubun'];
                        $mainContentMainGroupRelationList[$n]['contentImgSrc']      = $val1['contentImgSrc'];
                        $mainContentMainGroupRelationList[$n]['banner_link']        = $val1['banner_link'];
                        $mainContentMainGroupRelationList[$n]['slider_group_con_gubun']    = $val1['slider_group_con_gubun'];
                        $mainContentMainGroupRelationList[$n]['banner_desc']   = $val1['banner_desc'];
                        $mainContentMainGroupRelationList[$n]['banner_name']   = $val1['title'];
                        $mainContentMainGroupRelationList[$n]['b_name']        = $val1['b_name'];
                        $mainContentMainGroupRelationList[$n]['i_name']        = $val1['i_name'];
                        $mainContentMainGroupRelationList[$n]['u_name']        = $val1['u_name'];
                        $mainContentMainGroupRelationList[$n]['c_name']        = $val1['c_name'];
                        $mainContentMainGroupRelationList[$n]['s_name']        = $val1['s_name'];
                        $mainContentMainGroupRelationList[$n]['b_desc']        = $val1['b_desc'];
                        $mainContentMainGroupRelationList[$n]['i_desc']        = $val1['i_desc'];
                        $mainContentMainGroupRelationList[$n]['u_desc']        = $val1['u_desc'];
                        $mainContentMainGroupRelationList[$n]['c_desc']        = $val1['c_desc'];
                        $mainContentMainGroupRelationList[$n]['s_desc']        = $val1['s_desc'];
                        $mainContentMainGroupRelationList[$n]['shot_title']    = $val1['shot_title'];
                        $mainContentMainGroupRelationList[$n]['b_title']       = $val1['b_title'];
                        $mainContentMainGroupRelationList[$n]['i_title']       = $val1['i_title'];
                        $mainContentMainGroupRelationList[$n]['u_title']       = $val1['u_title'];
                        $mainContentMainGroupRelationList[$n]['c_title']       = $val1['c_title'];
                        $mainContentMainGroupRelationList[$n]['s_title']       = $val1['s_title'];
                        $b=0;
                    }
                    $cnt++;
                }
                $n++;
            }

        }

        $view->assign('mainContentMainGroupRelationList', $mainContentMainGroupRelationList);

        #메인페이지 추천스타일 가져오기(추천스타일 사용유무 사용/미사용 여부 확인)
        if($mainContentInfo['style_use'] == 'Y'){
            $displayContentClassDepthList = $displayModel->getDisplayContentClass('001002', "S");

            $n = 0;
            foreach($displayContentClassDepthList as $key){
                //$mainContentStyleInfo = $displayModel->getContentMainContent($mainContentInfo['conm_ix'], "S");
                //$mainContentStyleInfo = $displayModel->getContentMainStyleContent($key['cid'], "S");

                $cid = $key['cid'];
                if($key['depth'] == 1){
                    $cid =  substr($cid,0,6);
                }
                $mainContentStyleInfo = $displayModel->getContentMainStyleContent($cid, "S", $mainContentInfo['conm_ix']);

                if($mainContentStyleInfo){
                    $displayContentClassDepthList[$n]['styleGuide'] = $mainContentStyleInfo;
                    $n++;
                }
            }

            $view->assign('displayContentClassStyleList', $displayContentClassDepthList);

            //$displayContentClassDepthList['styleGuide'] = $mainContentStyleInfo;

            //$view->assign('mainContentStyleInfo', $mainContentStyleInfo);
        }



        //메인저널
        $mainJournalInfo = $displayModel->getDisplayJournalInfo();
        $view->assign('mainJournalInfo', $mainJournalInfo);

        #메인페이지 추천컨텐츠 가져오기(추천컨텐츠 사용유무 사용/미사용 여부 확인)
        if($mainContentInfo['content_use'] == 'Y'){
            $mainContentContentInfo = $displayModel->getContentMainContent($mainContentInfo['conm_ix'], "C");

            $c = 0;
            foreach($mainContentContentInfo as $key){
                if($wishModel->checkAlreadyContentWish($key['con_ix'], 'C')){
                    $mainContentContentInfo[$c]['alreadyWishContent'] = 'Y';
                }else{
                    $mainContentContentInfo[$c]['alreadyWishContent'] = 'N';
                }
                $c++;
            }

            $view->assign('mainContentContentInfo', $mainContentContentInfo);
        }

        #동영상 노출
        /*$mainMovieBannerInfo = $displayModel->getDisplayBannerGroup(14);
        $view->assign('mainMovieBannerInfo', $mainMovieBannerInfo);*/
    }
}

echo $view->loadLayout();