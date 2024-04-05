<?php

/**
 * Description of msLayOut
 *
 * @author hoksi
 */
Class msLayOut
{
    var $Contents;
    var $mallstory_left;
    var $ms_header_top;
    var $ms_header_menu;
    var $ms_center_history;
    var $ms_cotents_add;
    var $ms_footer_menu;
    var $ms_footer_desc;
    var $ms_template;
    var $ms_template_path;
    var $ms_template_wehtpah;
    var $ms_template_webpath;
    var $ms_image_path;
    var $mall_use_templete;
    var $mall_use_mobile_templete;
    var $AddScript;
    var $Config;
    var $page_title;
    var $keyword_desc;
    var $left_trans_bool = true;
    var $page_aliasing   = "leftmenu";
    var $content_title;
    var $content_desc;
    var $meta_image;
    var $snsShareConfig;

    function __construct($pcode = "", $login_bool = true)
    {
        global $DOCUMENT_ROOT, $HTTP_HOST, $user, $layout_config, $shopcfg;
        global $slave_db;

        $this->LayoutConfig($pcode);
        if ($this->Config['mall_open_yn'] == "Y" && $login_bool) {
            ms_auth();
        }

        $this->content_title = $this->Config['mall_title'];
        $this->content_desc  = $this->Config['mall_title'];
        $this->meta_image    = 'http://'.$_SERVER["HTTP_HOST"].$this->Config['mall_templet_webpath'].'/images/meta_image.png';


        $this->checkAutoLogin();


        $tpl                = new Template_();
        $tpl->template_dir  = $this->Config['mall_templet_path'];
        $this->page_title   = $this->Config['mall_title'];
        $this->keyword_desc = $this->Config['mall_keyword'];


        $tpl->compile_dir = $_SERVER["DOCUMENT_ROOT"].$this->Config['mall_data_root']."/compile_/";
        if ($this->Config['header1'] != "" && file_exists($_SERVER["DOCUMENT_ROOT"].$this->Config['mall_templet_webpath']."/layout/header/".$this->Config['header1'])) {//
            $tpl->define(array('header_top' => "layout/header/".$this->Config['header1'], 'brand_menu' => "layout/header/brand_menu.htm"));
            $tpl->assign('user', $user);
            $tpl->assign('templet_src', $this->Config['mall_templet_webpath']);
            $tpl->assign('product_src', $this->Config['mall_product_imgpath']);
            $tpl->assign('service_product_src', $this->Config['mall_service_product_imgpath']);
            $tpl->assign('images_src', $this->Config['mall_image_path']);

            $this->ms_header_top = $tpl->fetch('header_top');
        }

        if ($this->Config['header2'] != "" && file_exists($_SERVER["DOCUMENT_ROOT"].$this->Config['mall_templet_webpath']."/layout/header/".$this->Config['header2'])) {
            $tpl->define(array('header_menu' => "layout/header/".$this->Config['header2'], 'brand_menu' => "layout/header/brand_menu.htm"));
            $tpl->assign('user', $user);

            $tpl->assign('search_word', $search_word ?? '');
            $tpl->assign('templet_src', $this->Config['mall_templet_webpath']);
            $tpl->assign('product_src', $this->Config['mall_product_imgpath']);
            $tpl->assign('service_product_src', $this->Config['mall_service_product_imgpath']);
            $tpl->assign('images_src', $this->Config['mall_image_path']);
            $tpl->caching   = false;
            $tpl->cache_dir = $_SERVER["DOCUMENT_ROOT"].$this->Config['mall_data_root']."/_cache/";
            $tpl->setCache('header_menu', 3600, array('all', 'layout', 'header_menu', 'header2'));

            if (!$tpl->isCached('header_menu')) {

            }

            $this->ms_header_menu = $tpl->fetch('header_menu');
        }

        if ($this->Config['contents_add'] != "" && file_exists($_SERVER["DOCUMENT_ROOT"].$this->Config['mall_templet_webpath']."/layout/contents_add/".$this->Config['contents_add'])) {
            $tpl->define('contents_add', "layout/contents_add/".$this->Config['contents_add']);

            $shmop           = new Shared("reserve_rule");
            $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$this->Config['mall_data_root']."/_shared/";
            $shmop->SetFilePath();

            $reserve_data    = $shmop->getObjectForKey("reserve_rule");
            $reserve_data    = unserialize(urldecode($reserve_data));

            $tpl->assign("reserve_use_yn", $reserve_data['reserve_use_yn']);
            $tpl->assign('templet_src', $this->Config['mall_templet_webpath']);
            $tpl->assign('product_src', $this->Config['mall_product_imgpath']);
            $tpl->assign('service_product_src', $this->Config['mall_service_product_imgpath']);
            $tpl->assign('images_src', $this->Config['mall_image_path']);
            $this->ms_contents_add = $tpl->fetch('contents_add');
        }

        if ($this->Config['footer1'] != "" && file_exists($_SERVER["DOCUMENT_ROOT"].$this->Config['mall_templet_webpath']."/layout/footer/".$this->Config['footer1'])) {
            $tpl->define('footer_menu', "layout/footer/".$this->Config['footer1']);
            $tpl->assign('templet_src', $this->Config['mall_templet_webpath']);
            $tpl->assign('product_src', $this->Config['mall_product_imgpath']);
            $tpl->assign('service_product_src', $this->Config['mall_service_product_imgpath']);
            $tpl->assign('images_src', $this->Config['mall_image_path']);
            $this->ms_footer_menu = $tpl->fetch('footer_menu');
        }

        if ($this->Config['footer2'] != "" && file_exists($_SERVER["DOCUMENT_ROOT"].$this->Config['mall_templet_webpath']."/layout/footer/".$this->Config['footer2'])) {
            $tpl->define('footer_desc', "layout/footer/".$this->Config['footer2']);
            $tpl->assign('templet_src', $this->Config['mall_templet_webpath']);
            $tpl->assign('product_src', $this->Config['mall_product_imgpath']);
            $tpl->assign('service_product_src', $this->Config['mall_service_product_imgpath']);

            $this->ms_footer_desc = $tpl->fetch('footer_desc');
        }



        $this->Contents = "";
    }

    function LayoutConfig($pcode = "")
    {
        global $layout_config, $shopcfg, $HTTP_HOST, $DOCUMENT_ROOT;
        global $skin;
        global $slave_db, $master_db;

        if (isset($_COOKIE["CHECK_KEY"]) && $_COOKIE["CHECK_KEY"] && isset($_COOKIE["MAIL_VISIT_YN"]) && $_COOKIE["MAIL_VISIT_YN"] != "1") {
            $sql = "update shop_mailling_history set mail_click='1' where check_key='".$_COOKIE["CHECK_KEY"]."'";
            $master_db->query($sql);
            setcookie("MAIL_VISIT_YN", "1", time() + 3600, "/", $HTTP_HOST);
        }

        if (!sess_val("shopcfg", 'shop_name')) {

            $sql                                    = "select ccd.company_id, csd.shop_name, csd.shop_desc, ccd.com_name , ccd.com_number, ccd.online_business_number, ccd.com_ceo, ccd.com_addr1,
				ccd.com_addr2, ccd.com_phone, ccd.com_fax, ccd.com_email ,ccd.com_business_status, ccd.com_business_category
				,ccd.opening_time,ccd.cs_phone,ccd.officer_name,ccd.officer_email,ccd.return_zip,ccd.return_addr1,ccd.return_addr2,ccd.return_disp,ccd.return_use
				from common_seller_detail csd, common_company_detail ccd
				where csd.company_id = ccd.company_id and ccd.com_type = 'A' ";
            $slave_db->query($sql);
            $slave_db->fetch();

            $_SESSION["shopcfg"]['shop_name']       = $slave_db->dt['shop_name'];
            $_SESSION["shopcfg"]['shop_desc']       = $slave_db->dt['shop_desc'];
            $_SESSION["shopcfg"]['company_id']      = $slave_db->dt['company_id'];
            $_SESSION["shopcfg"]['com_name']        = $slave_db->dt['com_name']; //$slave_db->dt[company_name];
            $_SESSION["shopcfg"]['biz_no']          = $slave_db->dt['com_number'];
            $_SESSION["shopcfg"]['online_biz_no']   = $slave_db->dt['online_business_number'];
            $_SESSION["shopcfg"]['ceo']             = $slave_db->dt['com_ceo'];
            $_SESSION["shopcfg"]['company_address'] = $slave_db->dt['com_addr1']." ".$slave_db->dt['com_addr2'];
            $_SESSION["shopcfg"]['phone']           = $slave_db->dt['com_phone'];
            $_SESSION["shopcfg"]['fax']             = $slave_db->dt['com_fax'];
            $_SESSION["shopcfg"]['email']           = $slave_db->dt['com_email'];
            $_SESSION["shopcfg"]['biz_kind']        = $slave_db->dt['com_business_category'];
            $_SESSION["shopcfg"]['biz_item']        = $slave_db->dt['com_business_status'];
            $_SESSION["shopcfg"]["opening_time"]    = $slave_db->dt['opening_time'];
            list($l_cs_phone1, $l_cs_phone2, $l_cs_phone3) = (count($csPhoneExp                             = explode("-", $slave_db->dt['cs_phone']))
                > 3 ? $csPhoneExp : ['', '', '']);

            $l_cs_phone1_ = '';
            $l_cs_phone2_ = '';
            $l_cs_phone3_ = '';

            if ($l_cs_phone1 != "") $l_cs_phone1_                         = "-".$l_cs_phone1;
            if ($l_cs_phone2 != "") $l_cs_phone2_                         = "-".$l_cs_phone2;
            if ($l_cs_phone3 != "") $l_cs_phone3_                         = "-".$l_cs_phone3;
            $l_cs_phone                           = substr($l_cs_phone1_.$l_cs_phone2_.$l_cs_phone3_, 1);
            $_SESSION["shopcfg"]["cs_phone"]      = $l_cs_phone; //수정함 kbk 13/07/19
            $_SESSION["shopcfg"]["customer_name"] = ($slave_db->dt['customer_name'] ?? '');
            $_SESSION["shopcfg"]["officer_name"]  = $slave_db->dt['officer_name'];
            $_SESSION["shopcfg"]["officer_email"] = $slave_db->dt['officer_email'];
            $_SESSION["shopcfg"]["return_zip"]    = $slave_db->dt['return_zip'];
            $_SESSION["shopcfg"]["return_addr1"]  = $slave_db->dt['return_addr1'];
            $_SESSION["shopcfg"]["return_addr2"]  = $slave_db->dt['return_addr2'];
            $_SESSION["shopcfg"]["return_disp"]   = $slave_db->dt['return_disp'];
            $_SESSION["shopcfg"]["return_use"]    = $slave_db->dt['return_use'];
        }

        if (!($layout_config && sess_val("layout_config", 'mall_ix')) || $skin || true) {//
            $this_host = array('unimind.kr', 'www.unimind.kr', 'demo.unimind.kr');
            if (in_array($HTTP_HOST, $this_host)) {
                $slave_db->query("select * from ".TBL_SHOP_SHOPINFO." where mall_div = 'B' ");
                //mall_ix,mall_div, mall_ename, mall_type, mall_data_root, mall_domain, mall_domain_id, mall_domain_key, mall_title, mall_keyword, mall_use_templete, mall_use_mobile_templete, photoskin_type, mall_price_open, mall_cart_open, mall_open_yn,mall_use_inventory, mall_use_category_templet,basic_send_cost_quick,basic_send_cost_tekbae, free_cost_price, sattle_module, inipay_mid,inipay_nointerest_use,inipay_nointerest_str,inipay_interest_str,allthegate_id, allthegate_interest_str, allthegate_nointerest_str, allthegate_nointerest_use,allthegate_nointerest_price,lgdacom_id,lgdacom_key,lgdacom_type, lgdacom_interest_str, lgdacom_nointerest_str, lgdacom_nointerest_price,lgdacom_skin, delivery_policy_text, escrow_use,escrow_mid,escrow_apply,escrow_method_bank,escrow_method_vbank,escrow_method_card, mall_use_identification,mall_cc_interval,mall_dc_interval, naver_checkout, translator
                $slave_db->fetch();
            } else {
                $thisHost = str_replace('www.', '', $_SERVER['HTTP_HOST']);


                $domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);
                //if(substr_count($_SERVER["HTTP_USER_AGENT"],"Mobile")){ //substr_count($_SERVER["HTTP_USER_AGENT"],"Mobile") //|| substr_count($_SERVER["HTTP_HOST"],"m.")
                if (substr($_SERVER["HTTP_HOST"], 0, 2) == "m.") {

                    $sql = "select ss.*, 'M' as mall_page_type from ".TBL_SHOP_SHOPINFO." ss where mall_mobile_domain = '{$domain}' "; //mall_div = 'B' and
                    //mall_ix,mall_div, mall_ename, mall_type, mall_data_root, mall_domain, mall_domain_id, mall_domain_key, mall_title, mall_keyword, mall_use_templete, mall_use_mobile_templete, photoskin_type, 'M' as mall_page_type, mall_price_open, mall_cart_open, mall_open_yn,mall_use_inventory, mall_use_category_templet,basic_send_cost_quick,basic_send_cost_tekbae, free_cost_price, sattle_module, inipay_mid,inipay_nointerest_use,inipay_nointerest_str,inipay_interest_str,allthegate_id, allthegate_interest_str, allthegate_nointerest_str, allthegate_nointerest_use,allthegate_nointerest_price,lgdacom_id,lgdacom_key,lgdacom_type, lgdacom_interest_str, lgdacom_nointerest_str, lgdacom_nointerest_price,lgdacom_skin, delivery_policy_text, escrow_use,escrow_mid,escrow_apply,escrow_method_bank,escrow_method_vbank,escrow_method_card, mall_use_identification,mall_cc_interval,mall_dc_interval, naver_checkout, translator
                    //echo $sql;
                    $slave_db->query($sql);
                    $slave_db->fetch();
                } else {
                    $sql = "select * from ".TBL_SHOP_SHOPINFO." where mall_domain = '{$domain}'"; //mall_domain = 'B'
                    //echo "sql : ".$sql;
                    $slave_db->query($sql);
                    $slave_db->fetch();
                    //echo $slave_db->db_name."<br>";
                    //print_r($slave_db->dt);
                }

                if (!$slave_db->dt['mall_ix']) {
                    echo "비정상적인 접속입니다.";
                    exit;
                }
            }

            if ($_SERVER["HTTP_HOST"] == "deploy.mallstory.com") {
                //print_r($slave_db->dt);
            }

            if ($skin) {
                $_SESSION["layout_config"]['mall_use_templete'] = $skin;
            } else {
                $_SESSION["layout_config"]['mall_use_templete'] = $slave_db->dt['mall_use_templete'];
            }

            $this->mall_use_templete        = $_SESSION["layout_config"]['mall_use_templete'];
            $this->mall_use_mobile_templete = $slave_db->dt['mall_use_mobile_templete'];

            $_SESSION["layout_config"]['mall_ix']     = $slave_db->dt['mall_ix'];
            $_SESSION["layout_config"]['mall_div']    = $slave_db->dt['mall_div'];
            $_SESSION["layout_config"]['mall_domain'] = $slave_db->dt['mall_domain'];
            $_SESSION["layout_config"]['mall_ename']  = $slave_db->dt['mall_ename'];


            if ($slave_db->dt['mall_type'] == "BW" || $slave_db->dt['mall_ename'] == "b2b") {
                $_SESSION["layout_config"]['currency_type'] = "wholesale";
                $_SESSION["layout_config"]['mall_type']     = "BW";
            } else {
                $_SESSION["layout_config"]['mall_type'] = $slave_db->dt['mall_type'];
            }

            $_SESSION["layout_config"]['mall_title']   = $slave_db->dt['mall_title'];
            $_SESSION["layout_config"]['mall_keyword'] = $slave_db->dt['mall_keyword'];

            $_SESSION["layout_config"]['mall_use_mobile_templete'] = $slave_db->dt['mall_use_mobile_templete'];
            //$_SESSION["layout_config"][photoskin_type] = $slave_db->dt[photoskin_type];


            $_SESSION["layout_config"]['mall_page_type']            = $slave_db->dt['mall_page_type']; // 페이지 형식 P=> 포토스킨, S=>SNS, M=> 모바일
            $_SESSION["layout_config"]['mall_use_category_templet'] = $slave_db->dt['mall_use_category_templet'];
            $_SESSION["layout_config"]['mall_price_open']           = $slave_db->dt['mall_price_open'];
            $_SESSION["layout_config"]['mall_cart_open']            = $slave_db->dt['mall_cart_open'];
            $_SESSION["layout_config"]['mall_open_yn']              = $slave_db->dt['mall_open_yn'];

            if ($_SESSION["layout_config"]['mall_page_type'] == "M") {
                $_SESSION["layout_config"]['mall_templet_path']    = "$DOCUMENT_ROOT".$slave_db->dt['mall_data_root']."/mobile_templet/".$slave_db->dt['mall_use_mobile_templete'];
                $_SESSION["layout_config"]['mall_templet_webpath'] = $slave_db->dt['mall_data_root']."/mobile_templet/".$slave_db->dt['mall_use_mobile_templete'];
            } else {
                $_SESSION["layout_config"]['mall_templet_path']    = "$DOCUMENT_ROOT".$slave_db->dt['mall_data_root']."/templet/".$_SESSION["layout_config"]['mall_use_templete'];
                $_SESSION["layout_config"]['mall_templet_webpath'] = $slave_db->dt['mall_data_root']."/templet/".$_SESSION["layout_config"]['mall_use_templete'];
            }
//echo $_SESSION["layout_config"][mall_templet_webpath];

            $_SESSION["layout_config"]['mall_product_imgpath']         = $slave_db->dt['mall_data_root']."/images/product";
            $_SESSION["layout_config"]['mall_service_product_imgpath'] = $slave_db->dt['mall_data_root']."/images/service_product";
            $_SESSION["layout_config"]['mall_image_path']              = $slave_db->dt['mall_data_root']."/images";
            $_SESSION["layout_config"]['sattle_module']                = $slave_db->dt['sattle_module'];
            $_SESSION["layout_config"]['basic_send_cost_tekbae']       = $slave_db->dt['basic_send_cost_tekbae'];
            $_SESSION["layout_config"]['basic_send_cost_quick']        = $slave_db->dt['basic_send_cost_quick'];
            $_SESSION["layout_config"]['free_cost_price']              = $slave_db->dt['free_cost_price'];
            $_SESSION["layout_config"]['mall_data_root']               = $slave_db->dt['mall_data_root'];
            $_SESSION["layout_config"]['mall_domain']                  = $slave_db->dt['mall_domain'];
            $_SESSION["layout_config"]['mall_domain_key']              = $slave_db->dt['mall_domain_key'];
            $_SESSION["layout_config"]['mall_use_inventory']           = $slave_db->dt['mall_use_inventory'];
            $_SESSION["layout_config"]['mall_use_identification']      = $slave_db->dt['mall_use_identification'];
            $_SESSION["layout_config"]['mall_cc_interval']             = $slave_db->dt['mall_cc_interval'];
            $_SESSION["layout_config"]['mall_dc_interval']             = $slave_db->dt['mall_dc_interval'];
            $_SESSION["layout_config"]['delivery_policy_text']         = $slave_db->dt['delivery_policy_text'];
            $_SESSION["layout_config"]['naver_checkout']               = $slave_db->dt['naver_checkout'];
            $_SESSION["layout_config"]['translator']                   = $slave_db->dt['translator'];




            /* 2011.07.17 신훈식 삭제
              $_SESSION["layout_config"][mall_send_tekbae_use] = $slave_db->dt[mall_send_tekbae_use];
              $_SESSION["layout_config"][mall_send_quick_use] = $slave_db->dt[mall_send_quick_use];
              $_SESSION["layout_config"][mall_send_truck_use] = $slave_db->dt[mall_send_truck_use];
              $_SESSION["layout_config"][mall_send_self_use] = $slave_db->dt[mall_send_self_use];
             */

            if ($slave_db->dt['sattle_module'] == "inicis") {
                $_SESSION["layout_config"]['pg_company'] = "(주) 이니시스";
            } else if ($slave_db->dt['sattle_module'] == "allthegate") {
                $_SESSION["layout_config"]['pg_company'] = " 이지스효성(주)";
            } else if ($slave_db->dt['sattle_module'] == "kcp") {
                $_SESSION["layout_config"]['pg_company'] = " KCP";
            } else if ($slave_db->dt['sattle_module'] == "ksnet") {
                $_SESSION["layout_config"]['pg_company'] = " KSNET";
            } else {
                $_SESSION["layout_config"]['pg_company'] = " LG DACOM";
            }

            /* 도로명 주소관련 api key 사용 및 몰스토리 DB사용 정보 세션등록 jk131219 */
            $slave_db->query("SELECT * FROM `shop_mall_config` where mall_ix = '".($layout_config['mall_ix'] ?? '')."' and config_name in('zipcode_type','zipcode_key','popbill_id','search_engine_yn','search_engine_type','sns','sns_link_yn')  ");
            if ($slave_db->total) {
                for ($i = 0; $i < $slave_db->total; $i++) {
                    $slave_db->fetch($i);
                    $_SESSION["layout_config"][$slave_db->dt['config_name']] = $slave_db->dt['config_value'];
                }
            } else {
                $_SESSION["layout_config"]["zipcode_type"] = "M";
                $_SESSION["layout_config"]["zipcode_key"]  = "";
            }

            /*
              $_SESSION["layout_config"][escrow_use] = $slave_db->dt[escrow_use];
              $_SESSION["layout_config"][escrow_mid] = $slave_db->dt[escrow_mid];
              $_SESSION["layout_config"][escrow_apply] = $slave_db->dt[escrow_apply];
              $_SESSION["layout_config"][escrow_method_bank] = $slave_db->dt[escrow_method_bank];
              $_SESSION["layout_config"][escrow_method_vbank] = $slave_db->dt[escrow_method_vbank];
              $_SESSION["layout_config"][escrow_method_card] = $slave_db->dt[escrow_method_card];
             */
            //echo $DOCUMENT_ROOT.$slave_db->dt[mall_data_root]."/templet/".$_SESSION["layout_config"][mall_use_templete]."/layout.xml";
            //$fp = fopen($DOCUMENT_ROOT.$slave_db->dt[mall_data_root]."/xml/layout.xml","r");
            //while (!feof($fp)) {
            //	$strxmldata .= fread($fp,1024);
            //}
            //fclose($fp);
        }

        $doc = new DOMDocument();
        if ($_SESSION["layout_config"]['mall_page_type'] == "M") {
            if (is_file($DOCUMENT_ROOT.$_SESSION["layout_config"]['mall_data_root']."/mobile_templet/".$_SESSION["layout_config"]['mall_use_mobile_templete']."/layout2.xml")) {
                $doc->load($DOCUMENT_ROOT.$_SESSION["layout_config"]['mall_data_root']."/mobile_templet/".$_SESSION["layout_config"]['mall_use_mobile_templete']."/layout2.xml");
            } else {
                $doc->load($DOCUMENT_ROOT.$_SESSION["layout_config"]['mall_data_root']."/mobile_templet/".$_SESSION["layout_config"]['mall_use_mobile_templete']."/layout.xml");
            }
        } else {
            if (is_file($DOCUMENT_ROOT.$_SESSION["layout_config"]['mall_data_root']."/templet/".$_SESSION["layout_config"]['mall_use_templete']."/layout2.xml")) {
                $doc->load($DOCUMENT_ROOT.$_SESSION["layout_config"]['mall_data_root']."/templet/".$_SESSION["layout_config"]['mall_use_templete']."/layout2.xml");
            } else {
                $doc->load($DOCUMENT_ROOT.$_SESSION["layout_config"]['mall_data_root']."/templet/".$_SESSION["layout_config"]['mall_use_templete']."/layout.xml");
            }
        }
        $xpath = new DOMXpath($doc);
        $params = $xpath->query("*[@pcode='$pcode']");

        if ($params) {

            foreach ($params as $param) {
                $_SESSION["layout_config"]['page_help']    = $param->getElementsByTagName("page_help")->item(0)->nodeValue;
                $_SESSION["layout_config"]['layout']       = $param->getElementsByTagName("layout")->item(0)->nodeValue; //$slave_db->dt[layout];
                $_SESSION["layout_config"]['page_navi']    = $param->getElementsByTagName("page_navi")->item(0)->nodeValue; //$slave_db->dt[page_navi];
                $_SESSION["layout_config"]['header1']      = $param->getElementsByTagName("header1")->item(0)->nodeValue; //$slave_db->dt[header1];
                $_SESSION["layout_config"]['header2']      = $param->getElementsByTagName("header2")->item(0)->nodeValue; //$slave_db->dt[header2];
                $_SESSION["layout_config"]['leftmenu']     = $param->getElementsByTagName("leftmenu")->item(0)->nodeValue; //$slave_db->dt[leftmenu];
                $_SESSION["layout_config"]['contents']     = $param->getElementsByTagName("contents")->item(0)->nodeValue; //$slave_db->dt[contents];
                $_SESSION["layout_config"]['contents_add'] = $param->getElementsByTagName("contents_add")->item(0)->nodeValue; //$slave_db->dt[contents_add];
                $_SESSION["layout_config"]['rightmenu']    = $param->getElementsByTagName("rightmenu")->item(0)->nodeValue; //$slave_db->dt[rightmenu];
                $_SESSION["layout_config"]['footer1']      = $param->getElementsByTagName("footer1")->item(0)->nodeValue; //$slave_db->dt[footer1];
                $_SESSION["layout_config"]['footer2']      = $param->getElementsByTagName("footer2")->item(0)->nodeValue; //$slave_db->dt[footer2];
                $_SESSION["layout_config"]['page_path']    = $param->getElementsByTagName("page_path")->item(0)->nodeValue; //$slave_db->dt[footer2];
                $_SESSION["layout_config"]['caching']      = $param->getElementsByTagName("caching")->item(0)->nodeValue; //$slave_db->dt[caching];
                $_SESSION["layout_config"]['caching_time'] = $param->getElementsByTagName("caching_time")->item(0)->nodeValue; //$slave_db->dt[caching_time];
            }
        } else {
            if ($pcode) {
                $slave_db->query("select * from ".TBL_SHOP_DESIGN." where mall_ix ='".$_SESSION["layout_config"]['mall_ix']."' and pcode='$pcode'");
            } else {
                $slave_db->query("select cid from ".TBL_SHOP_LAYOUT_INFO." where  basic_link='".$_SERVER["REDIRECT_URL"]."'");
                $slave_db->fetch();
                $pcode = $slave_db->dt['cid'];

                $slave_db->query("select * from ".TBL_SHOP_DESIGN." where mall_ix ='".$_SESSION["layout_config"]['mall_ix']."' and pcode='".$pcode."'");
            }

            $slave_db->fetch();
            $_SESSION["layout_config"]['layout']       = $slave_db->dt['layout'];
            $_SESSION["layout_config"]['page_navi']    = $slave_db->dt['page_navi'];
            $_SESSION["layout_config"]['header1']      = $slave_db->dt['header1'];
            $_SESSION["layout_config"]['header2']      = $slave_db->dt['header2'];
            $_SESSION["layout_config"]['leftmenu']     = $slave_db->dt['leftmenu'];
            $_SESSION["layout_config"]['contents']     = $slave_db->dt['contents'];
            $_SESSION["layout_config"]['contents_add'] = $slave_db->dt['contents_add'];
            $_SESSION["layout_config"]['rightmenu']    = $slave_db->dt['rightmenu'];
            $_SESSION["layout_config"]['footer1']      = $slave_db->dt['footer1'];
            $_SESSION["layout_config"]['footer2']      = $slave_db->dt['footer2'];
            $_SESSION["layout_config"]['page_path']    = $slave_db->dt['page_path'];
            $_SESSION["layout_config"]['caching']      = $slave_db->dt['caching'];
            $_SESSION["layout_config"]['caching_time'] = $slave_db->dt['caching_time'];
        }

        $_SESSION["layout_config"]['this_templet_path'] = $_SESSION["layout_config"]['page_path']."/".trim($_SESSION["layout_config"]['contents']);
        $_SESSION["layout_config"]['contents_path']     = $_SESSION["layout_config"]['mall_templet_path']."/_".$pcode."/".trim($_SESSION["layout_config"]['contents']);

        $this->Config = $_SESSION["layout_config"];
    }












    function trasform_leftmenu($leftmenu = "")
    {
        global $DOCUMENT_ROOT, $user;
        ;
        global $slave_db;
        if ($leftmenu != "" && file_exists($_SERVER["DOCUMENT_ROOT"].$this->Config['mall_templet_webpath']."/layout/leftmenu/".$this->Config['leftmenu'])) {

            $tpl               = new Template_();
            $tpl->template_dir = $this->Config['mall_templet_path'];

            $tpl->compile_dir = $_SERVER["DOCUMENT_ROOT"].$this->Config['mall_data_root']."/compile_/";
            if ($this->page_aliasing == "main") {
                $tpl->caching = false;
                $cashing_name = "main_leftmenu";
            } else if ($this->page_aliasing == "category_main") {
                $tpl->caching = false;
                $cashing_name = "category_main_leftmenu";
            } else {
                $tpl->caching = false;
                $cashing_name = "leftmenu";
            }
            //echo $cashing_name;
            $tpl->define(array($cashing_name => "layout/leftmenu/".$this->Config['leftmenu'], 'loginbox' => "layout/leftmenu/loginbox.htm"));

            $tpl->cache_dir = $_SERVER["DOCUMENT_ROOT"].$this->Config['mall_data_root']."/_cache/";
            $tpl->setCache($cashing_name, 3600, array('all', 'layout', 'category'), $_GET);
            //$slave_db = new Database;
            if (!$tpl->isCached($cashing_name)) {
                //$tpl->define($cashing_name,"layout/leftmenu/".$this->Config[leftmenu]);



                $slave_db->query("SELECT * FROM ".TBL_SHOP_CATEGORY_INFO." where category_use = 1 and depth = 0 order by vlevel1, vlevel2, vlevel3, vlevel4, vlevel5");

                $categorys = $slave_db->fetchall();
                /*
                  foreach($categorys as $key => $category){
                  $categorys[$key][subcategorys] = subcategorys($category[cid],$category[depth],"Y");
                  $categorys[$key][display] = get_category_display($category[cid],"55","code");
                  if(is_array($categorys[$key][display])){
                  foreach($categorys[$key][display] as $_key => $_display){
                  if($_display[cmpg_ix]){
                  $categorys[$key][display][$_key][group_infos] = get_group_category_display($_display[cmpg_ix]);
                  if(is_array($categorys[$key][display][$_key][group_infos])){
                  foreach($categorys[$key][display][$_key][group_infos] as $__key => $__group_infos){
                  $categorys[$key][display][$_key][group_infos][$__key] = get_display_goods($_display[cmg_ix], $_display[group_code], $_display[goods_display_type], $_display[goods_display_sub_type]);
                  //get_display_goods(..cmg_ix, ..group_code, ..goods_display_type, ..goods_display_sub_type)
                  }
                  }
                  }
                  }
                  }
                  }
                 */
                $tpl->assign('categorys', $categorys);
            }


            $slave_db->query("SELECT board_name, board_ename FROM ".TBL_BBS_MANAGE_CONFIG." order by regdate");
            $bbsmenu = $slave_db->fetchall();
            $tpl->assign('bbsmenu', $bbsmenu);
            /*
              if($_GET[cf_ix]){
              $sql = "SELECT cfb.cafe_reg_mem_cnt, date_format(cfb.regdate,'%Y.%m.%d') as open_date,mem_ix as cafe_owner,  AES_DECRYPT(UNHEX(cmd.name),'".$slave_db->ase_encrypt_key."') as name, cu.id,cmd.nick_name
              FROM cafe_basicinfo cfb, common_user cu, common_member_detail cmd
              WHERE cf_ix = '".$_GET[cf_ix]."' and cfb.mem_ix = cu.code and cu.code = cmd.code ";
              //echo $sql;
              //echo $user[code];
              $slave_db->query($sql);
              $slave_db->fetch();
              if($slave_db->total){
              $tpl->assign($slave_db->dt);
              }

              $slave_db->query("SELECT * FROM cafe_bbs_group WHERE cf_ix = '".$_GET[cf_ix]."' and disp = '1' order by vieworder asc, bbs_group_name asc ");
              $bbs_groups = $slave_db->fetchall();
              if(is_array($bbs_groups)){
              $tpl->assign('bbs_groups',$bbs_groups);
              }
              }
             */
            /*
              if($_GET[bg_ix]){
              $sql = "SELECT bgb.blog_reg_mem_cnt, date_format(bgb.regdate,'%Y.%m.%d') as open_date,mem_ix as blog_owner,  AES_DECRYPT(UNHEX(cmd.name),'".$slave_db->ase_encrypt_key."') as name, cu.id
              FROM blog_basicinfo bgb, common_user cu, common_member_detail cmd
              WHERE bg_ix = '".$_GET[bg_ix]."' and bgb.mem_ix = cu.code and cu.code = cmd.code ";
              $slave_db->query($sql);
              $slave_db->fetch();
              if($slave_db->total){
              $tpl->assign($slave_db->dt);
              }

              $slave_db->query("SELECT * FROM blog_bbs_group WHERE bg_ix = '".$_GET[bg_ix]."' and disp = '1' order by vieworder asc, bbs_group_name asc ");
              $bbs_groups = $slave_db->fetchall();
              if(is_array($bbs_groups)){
              $tpl->assign('bbs_groups',$bbs_groups);
              }
              } */

            $tpl->assign('images_src', $this->Config['mall_image_path']);
            $tpl->assign('templet_src', $this->Config['mall_templet_webpath']);
            $tpl->assign('product_src', $this->Config['mall_product_imgpath']);
            $tpl->assign('service_product_src', $this->Config['mall_service_product_imgpath']);

            $shmop           = new Shared("reserve_rule");
            //echo $_SERVER["DOCUMENT_ROOT"].$this->Config[mall_data_root]."/_shared/";
            $shmop->filepath = $_SERVER["DOCUMENT_ROOT"].$this->Config['mall_data_root']."/_shared/";
            $shmop->SetFilePath();
            $reserve_data    = $shmop->getObjectForKey("reserve_rule");
            $reserve_data    = unserialize(urldecode($reserve_data));
            //print_r($reserve_data);
            $tpl->assign("mgm_use_yn", $reserve_data['mgm_use_yn']);


            $this->mallstory_left = $tpl->fetch($cashing_name);
        }
    }

    function transform_top_menu($header_top = "")
    {
        global $user, $DOCUMENT_ROOT;


        if ($header_top != "") {
            $tpl               = new Template_();
            $tpl->template_dir = $this->Config['mall_templet_path'];
            $tpl->compile_dir  = $DOCUMENT_ROOT.$this->Config['mall_data_root']."/compile_/";
            $tpl->define('header_top', "header/".$header_top);

            $tpl->assign('user', $user);

            $tpl->assign('templet_src', $this->Config['mall_templet_webpath']);
            $tpl->assign('product_src', $this->Config['mall_product_imgpath']);
            $tpl->assign('service_product_src', $this->Config['mall_service_product_imgpath']);
            $tpl->assign('images_src', $this->Config['mall_image_path']);

            $this->ms_header_top = $tpl->fetch('header_top');
        }
    }

    function CheckText($text, $vurl, $this_page)
    {
        if ($vurl == $this_page) {
            return MenuCirCleBoxStart('#646464', '50%').$text.MenuCirCleBoxEnd('#646464');
        } else {
            return $text;
        }
    }

    function LoadLayOut()
    {
        global $HTTP_HOST, $REQUEST_UR, $DOCUMENT_ROOT, $shopcfg;
        //$db = new Database;

        if ($this->left_trans_bool) {
            $this->trasform_leftmenu($this->Config['leftmenu']);
        }

        if (function_exists('getForbiz')) {
            $tpl = getForbiz()->tpl;
        } else {
            $tpl = new Template_();
        }

        $tpl->template_dir = $this->Config['mall_templet_path'];
        $tpl->compile_dir  = $DOCUMENT_ROOT.$this->Config['mall_data_root']."/compile_/";

        $tpl->define('layout', "layout/".$this->Config['layout']);
        $tpl->assign('templet_src', $this->Config['mall_templet_webpath']);
        $tpl->assign('images_src', $this->Config['mall_image_path']);
        $tpl->assign('product_src', $this->Config['mall_product_imgpath']);
        $tpl->assign('service_product_src', $this->Config['mall_service_product_imgpath']);
        $tpl->assign('mall_data_root', $this->Config['mall_data_root']);
        $tpl->assign('photoskin_path', $this->Config['photoskin_path'] ?? '');
        //echo $this->Config[photoskin_path];

        $tpl->assign('center_contents', $this->Contents);
        $tpl->assign('center_leftmenu', $this->mallstory_left);
        $tpl->assign('title_desc', $this->page_title);

        $tpl->assign('title_desc', $this->Config['mall_title']);
        $tpl->assign('content_title', $this->content_title);
        $tpl->assign('content_desc', $this->content_desc);
        $tpl->assign('meta_image', $this->meta_image);

        //SNS 공유 관련 Head 에 Meta 태그처리
        if (is_array($this->snsShareConfig) && count($this->snsShareConfig) > 0) {
            $tpl->assign($this->snsShareConfig);
        }

        $tpl->assign('keyword_desc', $this->keyword_desc);
        $tpl->assign('center_history', $this->ReturnHistory());
        $tpl->assign('contents_add', $this->ms_contents_add ?? '');

        $this->AddScript .= MainPopUp('E');
        $tpl->assign('script', $this->AddScript);
        $tpl->assign('header_top', $this->ms_header_top);
        $tpl->assign('header_menu', $this->ms_header_menu);
        $tpl->assign('footer_menu', $this->ms_footer_menu);
        $tpl->assign('footer_desc', $this->ms_footer_desc);

        $tpl->assign('page_navi', str_replace("{templet_src}", $this->Config['mall_templet_webpath'], $this->Config['page_navi']));

        /*
          $tpl->assign('navi',$this->navi);
          $tpl->assign('title_img',$this->title_img);
          $tpl->assign('cate_main_img',$this->cate_main_img);
         */

        $T            = new Tag();
        $T->file      = "/mallstory_SalesAnalysisTag.js";
        $T->userID    = gVal('user', 'id');  //--> 사용자 아이디(생략가능)
        $T->siteID    = "";  //--> 사용자 아이디(생략가능)
        $T->data_root = $this->Config['mall_data_root'];  //--> 사용자 아이디(생략가능)
        $T->email     = gVal('user', 'mail');  //--> 사용자 이메일(생략가능)
        $T->mobile    = gVal('user', 'pcs');  //--> 사용자 이메일(생략가능)



        $not_allow_page = array('/shop/product_after.php',
            '/shop/product_qna.php',
            '/shop/premium_after.php'
        );
        //echo $_SERVER['PHP_SELF'];
        if (!in_array($_SERVER['PHP_SELF'], $not_allow_page)) {
            return $tpl->fetch('layout').$T->ToTagString();
        } else {
            return $tpl->fetch('layout');
        }

        ob_end_flush();
    }

    function ReturnHistory()
    {
        global $DOCUMENT_ROOT;


        if ($this->Config['rightmenu'] != "" && file_exists($_SERVER["DOCUMENT_ROOT"].$this->Config['mall_templet_webpath']."/layout/rightmenu/".$this->Config['rightmenu'])) {
            $tpl               = new Template_();
            $tpl->template_dir = $this->Config['mall_templet_path'];
            $tpl->compile_dir  = $_SERVER["DOCUMENT_ROOT"].$this->Config['mall_data_root']."/compile_/";
            $tpl->assign('templet_src', $this->Config['mall_templet_webpath']);
            $tpl->assign('product_src', $this->Config['mall_product_imgpath']);
            $tpl->assign('images_src', $this->Config['mall_image_path']);
            $tpl->assign('service_product_src', $this->Config['mall_service_product_imgpath']);


            $tpl->compile_dir = $_SERVER["DOCUMENT_ROOT"].$this->Config['mall_data_root']."/compile_/";
            $tpl->define('today_history', "/layout/rightmenu/".$this->Config['rightmenu']);

            $tpl->caching   = false;
            $tpl->cache_dir = $_SERVER["DOCUMENT_ROOT"].$this->Config['mall_data_root']."/_cache/";
            $tpl->setCache('today_history', 3600, array('all', 'layout', 'today_history'));
            $tpl->assign('history', $_SESSION["HISTORY"] ?? '');
            //print_r($_SESSION["HISTORY"]);
            if (!$tpl->isCached('today_history')) {

            }

            //print_r($HISTORY);

            return $tpl->fetch('today_history');
        }
    }

    /**
     * 자동로그인 확인
     * 2014.7.14 bgh
     * @access private
     */
    private function checkAutoLogin()
    {
        if (empty($_SESSION['user'])) {
            //cookie 체크해서 로그인가능하면 바로 로그인처리
            if (!empty($_COOKIE['connection_no'])) {
                $login_info = @explode('|', $this->myDecrypt($_COOKIE['connection_no']));

                //유효성 체크
                if (!empty($login_info[0]) && !empty($login_info[1])) {
                    $this->autoLogin($login_info);
                }
            }
        }
    }

    /**
     * 로그인 처리
     * @param array $info (id,pw)
     *
     * @access private
     * @see /member/login.php
     */
    private function autoLogin($info)
    {
        $db            = new Database();
        $id            = $info[0];
        $pw            = $info[1];
        $stropp_passwd = strtoupper($pw); //소문자를 대문자로
        $strlow_passwd = strtolower($pw); //대문자를 소문자로

        $query = "(pw='".crypt($stropp_passwd, "mo")."' OR pw='".crypt($strlow_passwd, "mo")."' ";
        $query .= "OR pw='".md5($stropp_passwd)."' OR pw='".md5($strlow_passwd)."'";
        $query .= "OR pw='".hash("sha256", $stropp_passwd)."' OR pw='".hash("sha256", $strlow_passwd)."' OR pw='".hash("sha256", $pw)."' OR pw='".hash("sha256",
                md5($pw))."' OR pw='".md5(hash("sha256", $pw))."')";
        // OR pw='".hash("sha256", $pw)."' 대소문자를 섞어서 썼을 경우를 대비해서 추가함 kbk 13/03/05
        //wisa 회원 비밀번호용 추가  OR pw='".md5(hash("sha256",$pw))."' kbk 13/05/25
        $sql   = "SELECT
					cu.code,
					cu.id,
					cu.company_id,
					AES_DECRYPT(UNHEX(cmd.name),'".$db->ase_encrypt_key."') as name,
					AES_DECRYPT(UNHEX(cmd.pcs),'".$db->ase_encrypt_key."') as pcs,
					AES_DECRYPT(UNHEX(cmd.mail),'".$db->ase_encrypt_key."') as mail,
					AES_DECRYPT(UNHEX(cmd.mail),'".$db->ase_encrypt_key."') as mail,
					cmd.nick_name,
					mg.gp_level,mg.mall_ix,
					mg.gp_name, mg.sale_rate, cmd.gp_ix,
					cmd.sex_div as sex,
					cu.mem_type,
					cu.authorized,
					cu.is_id_auth,
					mg.wholesale_dc,
					mg.retail_dc,
					mg.mem_type AS mg_mem_type,
					mg.shipping_dc_yn,mg.use_discount_type,mg.round_depth,mg.round_type,
					mg.shipping_dc_price,mg.selling_type,
					cmd.niceid_di,
					".(date("Y") + 1)."-date_format(birthday,'%Y') as age,
					cmd.ipin_safekey
				FROM
					".TBL_COMMON_USER." cu ,
					".TBL_COMMON_MEMBER_DETAIL." cmd ,
					".TBL_SHOP_GROUPINFO." mg
				WHERE
					id=TRIM('$id')  and cu.mem_type in ('M','F','C','A')
					and cu.code = cmd.code
					and cmd.gp_ix = mg.gp_ix
					and mg.gp_level != 0
					and $query "; //, mg.wholesale_dc, mg.retail_dc, mg.mem_type AS mg_mem_type, mg.shipping_dc_yn, mg.shipping_dc_price 추가 kbk 13/06/14
        $db->query($sql);
        if ($db->total) {
            $db->fetch();

            $ipin_safekey = $db->dt['ipin_safekey'];
            $niceid_di    = $db->dt['niceid_di'];
            $user_code    = $db->dt['code'];

            if ($db->dt['authorized'] == "Y") {
                $_SESSION["user"]['company_id']  = $db->dt['company_id'];
                $_SESSION["user"]['code']        = $db->dt['code'];
                $_SESSION["user"]['name']        = $db->dt['name'];
                $_SESSION["user"]['nick_name']   = $db->dt['nick_name'];
                $_SESSION["user"]['mail']        = $db->dt['mail'];
                $_SESSION["user"]['id']          = $db->dt['id'];
                $_SESSION["user"]['gp_level']    = $db->dt['gp_level'];
                $_SESSION["user"]['gp_name']     = $db->dt['gp_name'];
                $_SESSION["user"]['perm']        = $db->dt['gp_level'];
                $_SESSION["user"]['mem_type']    = $db->dt['mem_type'];
                $_SESSION["user"]['gp_ix']       = $db->dt['gp_ix'];
                $_SESSION["user"]['sex']         = $db->dt['sex'];
                $_SESSION["user"]['age']         = $db->dt['age'];
                $_SESSION["user"]['use_mall_yn'] = $db->dt['use_mall_yn'];
                $_SESSION["user"]['birthday']    = $db->dt['birthday'];      //19금 사용여부를 위하여 추가 2014-02-04 이학봉
                //$_SESSION["user"][sale_rate]   = $db->dt[sale_rate];
                if ($db->dt['selling_type'] == "R") {//회원 타입에 따라서 할인율 적용 kbk 13/06/14
                    if ($db->dt['retail_dc']) {
                        $_SESSION["user"]['sale_rate'] = $db->dt['retail_dc'];
                    } else {
                        $_SESSION["user"]['sale_rate'] = '0';
                    }
                } else {
                    if ($db->dt['wholesale_dc']) {
                        $_SESSION["user"]['sale_rate'] = $db->dt['wholesale_dc'];
                    } else {
                        $_SESSION["user"]['sale_rate'] = '0';
                    }
                }
                if ($db->dt["shipping_dc_yn"] == "Y") {//회원등급별 배송비 kbk 13/06/17
                    $_SESSION["user"]["shipping_dc_price"] = ($db->dt["shipping_dc_price"] > 0 ? $db->dt["shipping_dc_price"] : 0);
                } else {
                    $_SESSION["user"]["shipping_dc_price"] = 0;
                }
                $_SESSION["user"]['pcs']               = $db->dt['pcs'];
                $_SESSION["user"]['use_discount_type'] = $db->dt['use_discount_type']; //회원그룹 할인율 타입 c:카테고리할인 g:일반할인(그룹) w:품목별가격 적용
                $_SESSION["user"]['round_depth']       = $db->dt['round_depth'];
                $_SESSION["user"]['round_type']        = $db->dt['round_type'];
                $_SESSION["user"]['selling_type']      = $db->dt['selling_type'];   //회원그룹별 도소매 구분 소매 :R 도매:W

                $db->query("INSERT INTO common_login_history (clh_ix,code, ip, ip_block_yn, regdate) VALUES ('','".$user_code."','".$_SERVER["REMOTE_ADDR"]."','N',NOW())");

                $db->query("UPDATE ".TBL_COMMON_USER." SET visit=visit+1, last=NOW(), ip='$REMOTE_ADDR' WHERE code='".$user_code."'");
                if ($_SESSION['layout_config']['mall_type'] != 'H') {
                    $db->query("update shop_cart set mem_ix = '".$user_code."' where cart_key = '".session_id()."' and mem_ix =''");
                }
                $point_user_code = $user_code;

                //////////////// 포인트 적립 시작///////////////////////
                $point_data = GetPointRate();
                if ($point_data['point_login_yn'] == "Y") {
                    if ($point_data['point_auto_yn'] == "Y" && $point_data['point_login_yn'] == 0) { //자동지급 사용시 적립완료
                        $point_state = "1";
                    } else {
                        $point_state = "0";  //미사용시 적립대기
                    }
                    if ($point_data['login_point_price'] > 0) {
                        InsertReserveInfo($point_user_code, '', '', '', $point_data['login_point_price'], $point_state, '5', "로그인시 적립금 지급", 'point',
                            $admininfo); //마일리지,적립금 통합용 함수 2013-06-19 이학봉
                    }
                }
                //////////////// 포인트 적립 끝///////////////////////
                //자동로그인 쿠키 연장
                setcookie("connection_no", $auth_token, time() + 1209600, "/", $_SERVER['HTTP_HOST'], false, true);
                setcookie("auto_login", 'Y', time() + 1209600, "/", $_SERVER['HTTP_HOST'], false, true);
            }
        }
    }

    /**
     * 자동로그인용 쿠키저장 액세스 토큰 생성
     * @param string $id
     * @param string $pw
     *
     * @access public
     * @return string
     */
    public function makeAuthToken($id, $pw)
    {
        $source = $id.'|'.$pw;
        return $this->myEncrypt($source);
    }

    /**
     * AES-128 encrypt
     * # Java source 와 매칭버전
     * 2014.1.22 bgh
     */
    private function myEncrypt($val)
    {
        $cipher     = "rijndael-128";
        $mode       = "cbc";
        $secret_key = "salkf!gsek@ugjwer!@#sfwegwet3!2";
        //iv length should be 16 bytes
        $iv         = "feacba9876543211";

        // Make sure the key length should be 16 bytes
        $key_len = strlen($secret_key);
        if ($key_len < 16) {
            $addS = 16 - $key_len;
            for ($i = 0; $i < $addS; $i++) {
                $secret_key .= " ";
            }
        } else {
            $secret_key = substr($secret_key, 0, 16);
        }

        $td         = mcrypt_module_open($cipher, "", $mode, $iv);
        mcrypt_generic_init($td, $secret_key, $iv);
        $cyper_text = mcrypt_generic($td, $val);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return bin2hex($cyper_text);
    }

    /**
     * AES-128 decrypt
     * # Java source 와 매칭버전
     * 2014.1.22 bgh
     */
    private function myDecrypt($val)
    {
        $cipher     = "rijndael-128";
        $mode       = "cbc";
        $secret_key = "salkf!gsek@ugjwer!@#sfwegwet3!2";
        //iv length should be 16 bytes
        $iv         = "feacba9876543211";

        // Make sure the key length should be 16 bytes
        $key_len = strlen($secret_key);
        if ($key_len < 16) {
            $addS = 16 - $key_len;
            for ($i = 0; $i < $addS; $i++) {
                $secret_key .= " ";
            }
        } else {
            $secret_key = substr($secret_key, 0, 16);
        }

        $td             = mcrypt_module_open($cipher, "", $mode, $iv);
        mcrypt_generic_init($td, $secret_key, $iv);
        $decrypted_text = mdecrypt_generic($td, $this->hex2bin($val));
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return trim($decrypted_text);
    }

    /**
     * hex to bin
     * # Java source 와 매칭버전
     * 2014.1.22 bgh
     */
    private function hex2bin($data)
    {
        $bin = "";
        $i   = 0;
        do {
            $bin .= chr(hexdec($data{$i}.$data{($i + 1)}));
            $i   += 2;
        } while ($i < strlen($data));

        return $bin;
    }
}