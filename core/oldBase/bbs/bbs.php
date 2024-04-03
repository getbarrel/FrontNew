<?php
ini_set("memory_limit", "256M");

// $ss_pgid 초기화
$ss_pgid = $ss_pgid ?? '';

if ($ss_pgid && !$pgid && $_SERVER["REDIRECT_URL"] == "") {
    $pgid = $ss_pgid;
}

//$layout_config['mall_data_root'] = MALL_DATA_PATH;
//$layout_config['mall_data_path'] = MALL_DATA_PATH;
// {=print_bbs(_GET["board"],_GET["mode"], _GET["act"],"010001000000000") // 게시판을 불러오는 치환함수}

if (!function_exists('print_bbs')) {


    function print_bbs($board, $mode, $act, $pgid = "010001000000000", $admin_mode = false)
    {

        $act = gVal('act');
        $user = gVal('user');
        $db = getForbiz()->import('db.db');
        $bdb = getForbiz()->import('db.bdb');
        $bbs_div = gVal('bbs_div');
        $ss_pgid = gVal('ss_pgid');
        $article_no = gVal('article_no');
        $bbs_ix = gVal('bbs_ix');
        $page = gVal('page');
        $admininfo = gVal('admininfo');
        $bbs_file_dir = gVal('bbs_file_dir');
        $presetBCode = gVal('presetBCode');
        $admininfo = gVal('admininfo');
        $layout_config = gVal('layout_config');
        $admin_config = gVal('admin_config');
        $bbs_div = gVal('bbs_div');
        $sub_bbs_div = gVal('sub_bbs_div');
        $bbs_pass = gVal('bbs_pass');
        $bbs_ix_step = gVal('bbs_ix_step');
        $bbs_hidden = gVal('bbs_hidden');
        $page_type = gVal('page_type');
        $mmode = gVal('mmode');
        $mem_ix = gVal('mem_ix');
        $bbs_etc1 = gVal('bbs_etc1');
        $bbs_etc3 = gVal('bbs_etc3');
        $bbs_etc4 = gVal('bbs_etc4');
        $bbs_etc5 = gVal('bbs_etc5');
        $bbs_etc21 = gVal('bbs_etc21');
        $bbs_etc22 = gVal('bbs_etc22');
        $bbs_etc23 = gVal('bbs_etc23');
        $HTTP_POST_FILES = gVal('_FILES');

        if ($bbs_etc21 != "") {
            $bbs_etc2 = $bbs_etc21 . "-" . $bbs_etc22 . "-" . $bbs_etc23;
        }

        if ($ss_pgid) {
            $pgid = $ss_pgid;
        }
       
        if (sess_val("layout_config","mall_page_type") == "M") {
            $presetBCode = "mobile_";
        }
        $layoutBCode = (isset($presetBCode)) ? $presetBCode : '';

        
        //** ** 페이지 아이디가 넘어올 때
        if ($pgid) {
            $sqlManageInfo = 
            "SELECT 
                li.bbs_name, 
                board_ename, 
                d.contents, 
                d.templet_name,  
                li.cid, 
                li.depth, 
                mc.bbs_templet_dir  
               FROM " . TBL_SHOP_LAYOUT_INFO . " li, " . TBL_SHOP_DESIGN . " d, " . TBL_BBS_MANAGE_CONFIG . " mc 
              WHERE cid = '" . $pgid . "' 
                  and li.cid = d.pcode 
                  and li.bbs_name = mc.board_ename ";
            $db->query($sqlManageInfo);
            $db->fetch();
        }
        
        
        //**  게시판 설정 정보 테이블 조회
        if ($board) {
            $sqlManageInfo = "SELECT board_name, bbs_templet_dir FROM " . TBL_BBS_MANAGE_CONFIG . " WHERE board_ename = '" . $board . "'  ";
            $db->query($sqlManageInfo);
            $db->fetch();            
            $bbs_templet_dir = $db->dt['bbs_templet_dir'];
            $bbs_table_name = "bbs_" . $board;
        }
        
        //** bbs 템플릿 스킨
        $bbs_templet = $layoutBCode . $bbs_templet_dir;
        if (!$bbs_templet) {
            $bbs_templet = "basic";
        }

        //** 사용자 아이디 코드
        if ($admin_mode) {
            $bbs_template_dir = MALL_DATA_PATH . "/bbs_templet/admin";
            $user_code = sess_val('admininfo', 'charger_ix');
        
        } else {
            $bbs_template_dir = MALL_DATA_PATH . "/bbs_templet/" . $bbs_templet;

            if ($user['code'] ?? false) {
                $user_code = sess_val('user', 'code');// user ID
                $bbs_name = sess_val('user', 'name');     // user 이름
            }
        }     
        
        
        //** setting template config
        $site_template_src = MALL_DATA_PATH . "/templet";
        $site_product_src = MALL_DATA_PATH . "/product";
        $site_images_src = MALL_DATA_PATH . "/images";
        $bbs_compile_dir = MALL_DATA_PATH . "/compile_/customer/" . $board . "/";
        $bbs_data_dir = MALL_DATA_PATH . "/bbs_data";
        $edit_data_dir = path_to_root($_SERVER["PHP_SELF"]) . MALL_DATA_PATH . "/bbs_data"; 
        

        $tpl = new Template_();
        $tpl->template_dir = $site_template_src;
        $tpl->compile_dir = $bbs_compile_dir;
        $tpl->site_template_src = $site_template_src;
        $tpl->site_product_src = $site_product_src;
        $tpl->assign('templet_src', $site_template_src);
        $tpl->assign('product_src', $site_product_src);
        $tpl->assign('images_src', $site_images_src);
        error_reporting(-1);

        
        // 2. act 공통 
        if ($act) {

            $msb = new MsBoard2($bbs_table_name);
            $msb->MsBoardConfigration(getForbizView()->msLayout);
            $msb->bbs_admin_mode = $admin_mode;
            $msb->BoardAuth($_POST["act"]);

            if ((!strstr($_SERVER["HTTP_REFERER"], $_SERVER["HTTP_HOST"])) || getenv("REQUEST_METHOD") === 'GET') {
                Error(getLanguageText('8e0732ba2113446cc1ee378a15b652c2') . ".");
                // 8e0732ba2113446cc1ee378a15b652c2 : 정상적으로 글을 작성하여 주시기 바랍니다
            }
        }

        // 포인트 적립 설정 가져오기
        if ($user_code) {
            $sql = "select mem_type from " . TBL_COMMON_USER . " where code = '" . $user_code . "'";
            $db->query($sql);
            $db->fetch();
            $mem_type = ($db->dt['mem_type'] ?? '');

            if ($mem_type == "M") {
                $point_rule_file = "b2c_point_rule";
            } else if ($mem_type == "C") {
                $point_rule_file = "b2b_point_rule";
            } else if ($mem_type == "A") {
                $point_rule_file = "b2c_point_rule";
            }

            $point_rule_file = $point_rule_file ?? '';
            $shmop = new Shared($point_rule_file);
            $shmop->filepath = MALL_DATA_PATH . "/_shared/";
            $shmop->SetFilePath();
            $reserve_data = $shmop->getObjectForKey($point_rule_file);          //** 하단 포인트 처리와 관련..
            $reserve_data = unserialize(urldecode($reserve_data));
        }

        
        
        //** 중간중간 체크를 한다...
        //** 아래는 act 중 해당 엑션에 대해서만 구분해서 다시 처리
        // 2009-03-19 스팸 차단을 위해 추가된 부분
        /***  임시 
        if ($act) {
            $db->query("SELECT * FROM bbs_spam_config where spam_usable = 1 limit 0,1 ");
            $db->fetch();

            if ($db->total) {
                //**  $db->fetch();

                $spam_check_bool = false;
                $ip_check_bool = false;
                $spam_words = "";
                $block_ips = "";
                if ($db->dt['spam_word'] != "") {
                    $spam_words = explode(",", $db->dt['spam_word']);
                }

                if ($db->dt['block_ip'] != "") {
                    $block_ips = "block_ips : " . $db->dt['block_ip'];
                }

                if ($block_ips != "") {
                    if (substr_count(str_replace("*", "", $block_ips), $_SERVER["REMOTE_ADDR"]) > 0) {
                        $ip_check_bool = true;
                        //6268be4394dbeccc69bfaac199a10ac3 : 차단된 IP 주소 입니다. 확인후 다시 시도해주세요 . 계속해서 문제가 될 경우 고객센타로 문의주시기 바랍니다
                        echo "<Script>alert('" . getLanguageText('6268be4394dbeccc69bfaac199a10ac3') . ".');document.location.href='?mode=list&board=$board&bbs_div=$bbs_div';</Script>";
                        exit;
                    }
                }

                if ($spam_words != "" && is_array($spam_words)) {
                    foreach ($_POST as $key => $val) {
                        if ($val) {
                            for ($i = 0; $i < count($spam_words); $i++) {
                                if (substr_count($val, str_replace("\r\n", "", $spam_words[$i]))) {
                                    $spam_check_bool = true;
                                    //c62df828e814dd6129fca9979c9bd5e8 : 스팸문자가 포함되어 글 등록이 차단되었습니다. 확인후 다시 시도해주세요 . 계속해서 문제가 될 경우 고객센타로 문의주시기 바랍니다.
                                    echo "<script>alert('" . getLanguageText('c62df828e814dd6129fca9979c9bd5e8') . ".');document.location.href='?mode=list&board=" . $board . "&bbs_div=" . $bbs_div . "';</script>";
                                    exit;
                                }
                            }
                        }
                    }
                }

                // 2015-12-17	hyungsoo.kim	파일명에 한글이 있는지 체크
                if (isset($_FILES['bbs_file_1'])) {
                    $fileName = basename($_FILES['bbs_file_1']['name'], strrchr($_FILES['bbs_file_1']['name'], '.'));
                    if (preg_match("/[\xA1-\xFE][\xA1-\xFE]/", $fileName) != 0) {
                        echo "<Script>alert('한글이 포함되어 있는 파일명은 업로드 할수 없습니다. 확인후 다시 시도해주세요. ');</Script>";
                        exit;
                    }
                }
            }
        }
        */
        
        
        
        
        
        
        
        
        
        
        
        // ** 1 등록처리
        if ($act == "insert") {

            valCsrf();
            $csrfToken = getCsrfToken();
            setCsrfTokenInSess($csrfToken);

            $bbs_subject = gVal('bbs_subject');
            $focus_info = gVal('focus_info');
            $status = gVal('status');

            if (gVal('antispam_yn') == "Y") {
                if ($_SESSION["security_code"] != $_POST["security_code2"]) {
                    echo "<script>alert('입력한 코드문자가 틀립니다. 다시한번 작성하시기 바랍니다.');</script>";
                    exit;
                }
            }

            $bbs_file_1 = ($HTTP_POST_FILES['bbs_file_1']['tmp_name'] ?? '');
            $bbs_file_1_name = ($HTTP_POST_FILES['bbs_file_1']['name'] ?? '');
            $bbs_file_1_size = ($HTTP_POST_FILES['bbs_file_1']['size'] ?? '');
            $bbs_file_1_type = ($HTTP_POST_FILES['bbs_file_1']['type'] ?? '');

            $bbs_file_2 = ($HTTP_POST_FILES['bbs_file_2']['tmp_name'] ?? '');
            $bbs_file_2_name = ($HTTP_POST_FILES['bbs_file_2']['name'] ?? '');
            $bbs_file_2_size = ($HTTP_POST_FILES['bbs_file_2']['size'] ?? '');
            $bbs_file_2_type = ($HTTP_POST_FILES['bbs_file_2']['type'] ?? '');

            $bbs_file_3 = ($HTTP_POST_FILES['bbs_file_3']['tmp_name'] ?? '');
            $bbs_file_3_name = ($HTTP_POST_FILES['bbs_file_3']['name'] ?? '');
            $bbs_file_3_size = ($HTTP_POST_FILES['bbs_file_3']['size'] ?? '');
            $bbs_file_3_type = ($HTTP_POST_FILES['bbs_file_3']['type'] ?? '');


            //** 이것참...  idx를 생성한다... 
            $bbs_ix = 0;
            $bbs_parent_ix = 0;
            $bbs_ix_level = 0;
            $db->query("select IFNULL(max(bbs_ix),0) as bbs_ix from " . $bbs_table_name);
            if ($db->total) {
                $db->fetch();
                $bbs_ix = $db->dt['bbs_ix'] + 1;
            }

            $bbs_parent_ix = gVal('bbs_parent_ix');
            $bbs_ix_level = gVal('bbs_ix_level');


            //** 범위 조정....
            /* 스팸글 방지위해 만듬 시작 */
            $bbs_user = $_SERVER["REMOTE_ADDR"] . "\t" . $_SERVER["HTTP_USER_AGENT"] . "\t" . date("Y-m-d H:i:s") . "\t" . $_COOKIE["C_TOKEN"] . "\t" . $bbs_subject . "\r\n";
            $fp = fopen($bbs_data_dir . "/bbs_writer.txt", "a+");
            fwrite($fp, $bbs_user);
            fclose($fp);

            if ($focus_info != 'Y' || $_SERVER["HTTP_REFERER"] == "") {
                echo "<script>alert('스팸체크1 {$focus_info} {$_SERVER['HTTP_REFERER']}');</script>"; //history.go(-1);
                exit;
            }

            /* 스팸글 방지위해 만듬 끝 */
            $is_html = gVal('is_html');
            if (!$is_html) {
                $is_html = "Y";
            }

            $is_notice = gVal('is_notice');
            if (!$is_notice) {
                $is_notice = "N";
            }

            if (($admininfo['company_id'] ?? '')) {
                $bbs_etc5 = $admininfo['company_id'];
            }

            if (($admininfo['com_type'] ?? '') == 'S' && ($board == "b2b_qna" || $board == "b2b_suggest" || $board == "b2b_account")) {
                $bbs_etc1 = $md_code;
            }

            if ($bbs_table_name == "bbs_qna") {
                $bbs_contents = gVal('bbs_contents');
                if (empty($bbs_subject)) {
                    echo "<script>alert('제목이 입력되었는지 다시 확인해주세요');</script>";
                    exit;
                } else if (empty($bbs_contents)) {
                    echo "<script>alert('내용이 입력되었는지 다시 확인해주세요');</script>";
                    exit;
                }
            }


            //** 상태 값 
            if (!$status) {
                $sql = "SELECT bms.status_ix , bms.status_name 
                        FROM" . TBL_BBS_MANAGE_STATUS . " bms, bbs_manage_config bmc
                        WHERE bms.bm_ix = bmc.bm_ix and bmc.board_ename = '" . $board . "'
                        ORDER By view_order ASC LIMIT 0,1";

                $db->query($sql);
                $db->fetch();
                if ($db->dt['status_ix']) {
                    $status = $db->dt['status_ix'];
                } else {
                    $status = 1;
                }
            }



            if ($board == "after" || $board == "premium_after") {
                $status = 1;
            }

            if ($board == "attend_check") {
                $sql = "SELECT bbs_ix from " . $bbs_table_name . " WHERE mem_ix='" . $user_code . "' and date_format(regdate,'%Y%m%d')='" . date("Ymd") . "' ";
                $db->query($sql);

                if ($db->total) {
                    echo "<script>alert('출석댓글 입력은 하루에 한번씩만 가능합니다.');</script>";
                    exit;
                }
            } else if ($board == "after" || $board == "premium_after") {
                $db->query("UPDATE shop_product SET after_score = after_score + '" . $valuation_goods . "' ,  after_cnt = after_cnt + 1 WHERE id ='" . $bbs_etc1 . "' ");
            }

            $bbs_contents = str_replace("'", "&#39;", $bbs_contents);

            $bbs_email = gVal('bbs_email');
            $mail_02 = gVal('mail_02');
            $mail_01 = gVal('mail_01');
            if (!$bbs_email) {
                if ($mail_02) {
                    $bbs_email = "$mail_01@$mail_02";
                } else {
                    $bbs_email = $mail_01;
                }
            }


            //** 공통 DB 처리
            $sql = "INSERT INTO " . $bbs_table_name . " (bbs_ix,bbs_div,sub_bbs_div, mem_ix,bbs_subject,bbs_name,bbs_pass,bbs_email,bbs_contents,bbs_top_ix, bbs_ix_level, bbs_ix_step, bbs_hidden, bbs_file_1,bbs_file_2,bbs_file_3, bbs_etc1,bbs_etc2,bbs_etc3,bbs_etc4,bbs_etc5,is_notice, is_html, ip_addr, status, regdate)
			VALUES  ('$bbs_ix','$bbs_div','$sub_bbs_div','$user_code','$bbs_subject','$bbs_name','$bbs_pass','$bbs_email','$bbs_contents','$bbs_ix','$bbs_ix_level','$bbs_ix_step','$bbs_hidden','$bbs_file_1_name','$bbs_file_2_name','$bbs_file_3_name','$bbs_etc1','$bbs_etc2','$bbs_etc3','$bbs_etc4','$bbs_etc5','$is_notice','$is_html','{$_SERVER["REMOTE_ADDR"]}','$status',NOW())";
            $db->query($sql);


            $db->query("SELECT bbs_ix FROM " . $bbs_table_name . " WHERE bbs_ix = '" . $bbs_ix . "' ");
            $db->fetch(0);
            $bbs_ix = $db->dt['bbs_ix'];
            $path = $bbs_data_dir;


            //**  예외처리
            if ($board == "after" || $board == "premium_after") {
                if (empty($valuation_goods_info)) {
                    $valuation_goods_info = $valuation_goods;
                }

                if (empty($valuation_package)) {
                    $valuation_package = $valuation_delivery;
                }

                $sql = "UPDATE " . $bbs_table_name . "
				   SET valuation_goods ='" . $valuation_goods . "'
				     , valuation_goods_info ='" . $valuation_goods_info . "'
				     , valuation_delivery ='" . $valuation_delivery . "'
				     , valuation_package ='" . $valuation_package . "'
				 WHERE bbs_ix = '" . $bbs_ix . "' ";

                $db->query($sql);
            }

            if (!is_dir($path . "/" . $bbs_table_name)) {
                if (is_writable($path)) {
                    mkdir($path . "/" . $bbs_table_name, 0777);
                    chmod($path . "/" . $bbs_table_name, 0777);
                }
            }

            $path = $bbs_data_dir . "/" . $bbs_table_name;

            if (!is_dir($path . "/" . $bbs_ix)) {
                if (is_writable($path)) {
                    mkdir($path . "/$bbs_ix", 0777);
                    chmod($path . "/$bbs_ix", 0777);
                }
            }


            //**  이미지 업로드 처리
            $path = $bbs_data_dir . "/" . $bbs_table_name . "/" . $bbs_ix;

            if (is_dir($path)) {
                //아카마이 ftp 파일 업로드
                $akamaiFtpUploadFiles = array();

                $db->query("select board_thumbnail_yn,thum_width,thum_height from bbs_manage_config where board_ename = '" . $board . "'");
                $db->fetch();
                $board_thumbnail_yn = $db->dt['board_thumbnail_yn'];
                $thum_width = $db->dt['thum_width'];
                $thum_height = $db->dt['thum_height'];

                if ($bbs_file_1_size > 0) {
                    move_uploaded_file($bbs_file_1, $path . "/" . $bbs_file_1_name);
                    $akamaiFtpUploadFiles[] = $bbs_file_1_name;
                    if ($board_thumbnail_yn == "Y") {
                        $akamaiFtpUploadFiles[] = "s_" . $bbs_file_1_name;
                    }
                }

                if ($bbs_file_2_size > 0) {
                    move_uploaded_file($bbs_file_2, $path . "/" . $bbs_file_2_name);
                    $akamaiFtpUploadFiles[] = $bbs_file_2_name;
                    if ($board_thumbnail_yn == "Y") {
                        $akamaiFtpUploadFiles[] = "s_" . $bbs_file_2_name;
                    }
                }

                if ($bbs_file_3_size > 0) {
                    move_uploaded_file($bbs_file_3, $path . "/" . $bbs_file_3_name);
                    $akamaiFtpUploadFiles[] = $bbs_file_3_name;
                    if ($board_thumbnail_yn == "Y") {
                        $akamaiFtpUploadFiles[] = "s_" . $bbs_file_3_name;
                    }
                }

                /* 썸네일 이미지 생성 시작 */
                if (!is_dir($path . "/" . $bbs_file_1_name) && file_exists($path . "/" . $bbs_file_1_name)) {
                    $image_info = getimagesize($path . "/" . $bbs_file_1_name);
                    $image_type = strtolower(substr($image_info['mime'], strpos($image_info['mime'], "/") + 1, strlen($image_info['mime'])));
                } else {
                    $image_info = null;
                    $image_type = '';
                }

                if (in_array($image_type, array("gif", "jpg", "jpeg", "png"))) {
                    if ($board_thumbnail_yn == "Y") {
                        if ($board == "premium_after") {
                            if ($image_type == "gif" || $image_type == "GIF") {
                                if ($bbs_file_1_size > 0) {
                                    MirrorGif($path . "/" . $bbs_file_1_name, $path . "/b_" . $bbs_file_1_name, MIRROR_NONE);
                                    resize_gif($path . "/b_" . $bbs_file_1_name, '700', '700', 'W');

                                    MirrorGif($path . "/" . $bbs_file_1_name, $path . "/s_" . $bbs_file_1_name, MIRROR_NONE);
                                    resize_gif($path . "/s_" . $bbs_file_1_name, $thum_width, $thum_height, 'W');
                                }
                                if ($bbs_file_2_size > 0) {
                                    MirrorGif($path . "/" . $bbs_file_2_name, $path . "/s_" . $bbs_file_2_name, MIRROR_NONE);
                                    resize_gif($path . "/s_" . $bbs_file_2_name, $thum_width, $thum_height, 'W');
                                }
                                if ($bbs_file_3_size > 0) {
                                    MirrorGif($path . "/" . $bbs_file_3_name, $path . "/s_" . $bbs_file_3_name, MIRROR_NONE);
                                    resize_gif($path . "/s_" . $bbs_file_3_name, $thum_width, $thum_height, 'W');
                                }
                            } else if ($image_type == "png" || $image_type == "PNG") {
                                if ($bbs_file_1_size > 0) {
                                    MirrorPNG($path . "/" . $bbs_file_1_name, $path . "/b_" . $bbs_file_1_name, MIRROR_NONE);
                                    resize_png($path . "/b_" . $bbs_file_1_name, '700', '700', 'W');

                                    MirrorPNG($path . "/" . $bbs_file_1_name, $path . "/s_" . $bbs_file_1_name, MIRROR_NONE);
                                    resize_png($path . "/s_" . $bbs_file_1_name, $thum_width, $thum_height, 'W');
                                }
                                if ($bbs_file_2_size > 0) {
                                    MirrorPNG($path . "/" . $bbs_file_2_name, $path . "/s_" . $bbs_file_2_name, MIRROR_NONE);
                                    resize_png($path . "/s_" . $bbs_file_2_name, $thum_width, $thum_height, 'W');
                                }
                                if ($bbs_file_3_size > 0) {
                                    MirrorPNG($path . "/" . $bbs_file_3_name, $path . "/s_" . $bbs_file_3_name, MIRROR_NONE);
                                    resize_png($path . "/s_" . $bbs_file_3_name, $thum_width, $thum_height, 'W');
                                }
                            } else {
                                if ($bbs_file_1_size > 0) {
                                    Mirror($path . "/" . $bbs_file_1_name, $path . "/b_" . $bbs_file_1_name, MIRROR_NONE);
                                    resize_jpg($path . "/b_" . $bbs_file_1_name, '700', '700', 'W');

                                    Mirror($path . "/" . $bbs_file_1_name, $path . "/s_" . $bbs_file_1_name, MIRROR_NONE);
                                    resize_jpg($path . "/s_" . $bbs_file_1_name, $thum_width, $thum_height, 'W');
                                }
                                if ($bbs_file_2_size > 0) {
                                    Mirror($path . "/" . $bbs_file_2_name, $path . "/s_" . $bbs_file_2_name, MIRROR_NONE);
                                    resize_jpg($path . "/s_" . $bbs_file_2_name, $thum_width, $thum_height, 'W');
                                }
                                if ($bbs_file_3_size > 0) {
                                    Mirror($path . "/" . $bbs_file_3_name, $path . "/s_" . $bbs_file_3_name, MIRROR_NONE);
                                    resize_jpg($path . "/s_" . $bbs_file_3_name, $thum_width, $thum_height, 'W');
                                }
                            }
                        } else {
                            if ($image_type == "gif" || $image_type == "GIF") {
                                if ($bbs_file_1_size > 0) {
                                    MirrorGif($path . "/" . $bbs_file_1_name, $path . "/s_" . $bbs_file_1_name, MIRROR_NONE);
                                    resize_gif($path . "/s_" . $bbs_file_1_name, $thum_width, $thum_height);
                                }
                                if ($bbs_file_2_size > 0) {
                                    MirrorGif($path . "/" . $bbs_file_2_name, $path . "/s_" . $bbs_file_2_name, MIRROR_NONE);
                                    resize_gif($path . "/s_" . $bbs_file_2_name, $thum_width, $thum_height);
                                }
                                if ($bbs_file_3_size > 0) {
                                    MirrorGif($path . "/" . $bbs_file_3_name, $path . "/s_" . $bbs_file_3_name, MIRROR_NONE);
                                    resize_gif($path . "/s_" . $bbs_file_3_name, $thum_width, $thum_height);
                                }
                            } else if ($image_type == "png" || $image_type == "PNG") {
                                if ($bbs_file_1_size > 0) {
                                    MirrorPNG($path . "/" . $bbs_file_1_name, $path . "/s_" . $bbs_file_1_name, MIRROR_NONE);
                                    resize_png($path . "/s_" . $bbs_file_1_name, $thum_width, $thum_height);
                                }
                                if ($bbs_file_2_size > 0) {
                                    MirrorPNG($path . "/" . $bbs_file_2_name, $path . "/s_" . $bbs_file_2_name, MIRROR_NONE);
                                    resize_png($path . "/s_" . $bbs_file_2_name, $thum_width, $thum_height);
                                }
                                if ($bbs_file_3_size > 0) {
                                    MirrorPNG($path . "/" . $bbs_file_3_name, $path . "/s_" . $bbs_file_3_name, MIRROR_NONE);
                                    resize_png($path . "/s_" . $bbs_file_3_name, $thum_width, $thum_height);
                                }
                            } else {
                                if ($bbs_file_1_size > 0) {
                                    Mirror($path . "/" . $bbs_file_1_name, $path . "/s_" . $bbs_file_1_name, MIRROR_NONE);
                                    resize_jpg($path . "/s_" . $bbs_file_1_name, $thum_width, $thum_height);
                                }
                                if ($bbs_file_2_size > 0) {
                                    Mirror($path . "/" . $bbs_file_2_name, $path . "/s_" . $bbs_file_2_name, MIRROR_NONE);
                                    resize_jpg($path . "/s_" . $bbs_file_2_name, $thum_width, $thum_height);
                                }
                                if ($bbs_file_3_size > 0) {
                                    Mirror($path . "/" . $bbs_file_3_name, $path . "/s_" . $bbs_file_3_name, MIRROR_NONE);
                                    resize_jpg($path . "/s_" . $bbs_file_3_name, $thum_width, $thum_height);
                                }
                            }
                        }
                    }


                    if ($board == "premium_after") {
                        if ($layout_config['mall_data_root']) {
                            akamaiFtpUpload($layout_config['mall_data_root'] . "/bbs_data/" . $bbs_table_name . "/" . $bbs_ix, $akamaiFtpUploadFiles);
                        } else {
                            akamaiFtpUpload($admininfo['mall_data_root'] . "/bbs_data/" . $bbs_table_name . "/" . $bbs_ix, $akamaiFtpUploadFiles);
                        }
                    }
                }
                /* 썸네일 이미지 생성 끝 */
            }

            // ** 계시판 포인트 설정이 있을 시.. 포인트 처리 추가...
            //--------------------게시판 포인트 START--------------------//
            if ($reserve_data['point_use_yn'] == "Y") {
                $sql = "SELECT board_point_yn, board_point_time, write_point, board_name FROM bbs_manage_config WHERE board_ename = '" . $board . "' ";
                $db->query($sql);
                $db->fetch();
                $board_point_yn = $db->dt['board_point_yn'];
                $board_point_time = $db->dt['board_point_time'];
                $write_point = $db->dt['write_point'];
                $board_name = $db->dt['board_name'];

                if ($board_point_yn == 'Y' && $write_point > 0 && $user_code != '') {
                    if ($board_point_time == 'R') {//즉시
                        $reserve_state = '1';     //적용완료
                    } elseif ($db->dt['board_point_time'] == 'A') {//승인
                        $reserve_state = '0';     //적립대기
                    } else {
                        $reserve_state = '0';
                    }

                    if ($board == "attend_check") {// kbk 12/08/28
                        $point_where = " and date_format(regdate,'%Y%m%d') = '" . date("Ymd") . "' ";
                    } else {
                        $point_where = " and od_ix = '" . $bbs_ix . "' ";
                    }

                    if ($reserve_state == 1) {
                        //////////////// 마일리지 적립 시작///////////////////////
                        //InsertReserveInfo($user_code,$board,$bbs_ix,'',$write_point,$reserve_state,'5',$board_name." 쓰기에 대한 포인트 적립",'point',$admininfo);	//마일리지,적립금 통합용 함수 2013-06-19 이학봉
                        // 새로운 마일리지 사용 형태로 주석처리 2017.06-27 SHS
                        //////////////// 마일리지 적립 끝///////////////////////

                        /* 신규 포인트,마일리지 접립 함수 JK 160405 */
                        $mileage_data['uid'] = $user_code;
                        $mileage_data['type'] = 1;
                        $mileage_data['mileage'] = $write_point;
                        $mileage_data['message'] = $board_name . " 쓰기에 대한 포인트 적립";
                        $mileage_data['state_type'] = 'add';
                        $mileage_data['save_type'] = 'mileage';
                        $mileage_data['oid'] = $board;
                        $mileage_data['od_ix'] = $bbs_ix;
                        InsertMileageInfo($mileage_data);
                    }
                }
            }
            //--------------------게시판 포인트 END--------------------//



            if ($page_type == "pop") {
                if (is_mobile()) {
                    echo "<script>alert('" . getLanguageText('694ce65315db5e5b460a3b5c8dcef684') . ".');top.opener.location.reload();top.self.close();top.window.close();</script>"; //echo "<Script>alert('구매후기가 작성되었습니다.');top.document.location.href='/mypage/profile.php';</Script>";
                } else {
                    if ($popup_style == 'modal') {
                        echo "<script>alert('" . getLanguageText('694ce65315db5e5b460a3b5c8dcef684') . ".');top.document.location.href='/shop/goods_view.php?id=" . $bbs_etc1 . "';</script>";
                    } else {
                        echo "<script>alert('" . getLanguageText('694ce65315db5e5b460a3b5c8dcef684') . ".');top.self.close();parent.opener.document.location.reload();</script>";
                    }
                }
            } else if ($page_type == "mobile") {
                if (is_mobile()) {
                    if ($backpage != "") {
                        echo "<Script>alert('" . getLanguageText('694ce65315db5e5b460a3b5c8dcef684') . ".');top.document.location.href='" . $backpage . "';</Script>";
                    } else {
                        echo "<Script>alert('" . getLanguageText('694ce65315db5e5b460a3b5c8dcef684') . ".');top.document.location.href='/shop/goods_view.php?id=" . $bbs_etc1 . "';</Script>";
                    }
                } else {
                    echo "<Script>alert('" . getLanguageText('694ce65315db5e5b460a3b5c8dcef684') . ".');top.document.location.href='/mypage/';</Script>";
                }
            } else if ($mmode == "pop") {
                echo "<Script>parent.parent.opener.location.reload();parent.self.close();</Script>";
            } else if ($board == "qna") {
                if (is_mobile()) {
                    echo "<Script>alert('" . getLanguageText('de95ce964dc797c111d2aa80e5cd5297') . ".');top.document.location.href='/mypage/mypage_bbs.php';</Script>";
                } else {
                    echo "<Script>alert('" . getLanguageText('de95ce964dc797c111d2aa80e5cd5297') . ".');top.document.location.href='/customer/bbs.php?board=qna';</Script>";
                }
            } else {
                echo "<Script>parent.document.location.href='?mode=list&board=$board&mmode=$mmode&mem_ix=$mem_ix';</Script>"; // $bbs_div 를 가져갈 경우 글 쓰고 나서 리스트에 방금 작성한 글만 보임 kbk
            }
            exit;
        }


        // ** 2 변경
        if ($act == "update") {
            $bbs_file_1 = $HTTP_POST_FILES['bbs_file_1']['tmp_name'];
            $bbs_file_1_name = $HTTP_POST_FILES['bbs_file_1']['name'];
            $bbs_file_1_size = $HTTP_POST_FILES['bbs_file_1']['size'];
            $bbs_file_1_type = $HTTP_POST_FILES['bbs_file_1']['type'];

            $bbs_file_2 = $HTTP_POST_FILES['bbs_file_2']['tmp_name'];
            $bbs_file_2_name = $HTTP_POST_FILES['bbs_file_2']['name'];
            $bbs_file_2_size = $HTTP_POST_FILES['bbs_file_2']['size'];
            $bbs_file_2_type = $HTTP_POST_FILES['bbs_file_2']['type'];

            $bbs_file_3 = $HTTP_POST_FILES['bbs_file_3']['tmp_name'];
            $bbs_file_3_name = $HTTP_POST_FILES['bbs_file_3']['name'];
            $bbs_file_3_size = $HTTP_POST_FILES['bbs_file_3']['size'];
            $bbs_file_3_type = $HTTP_POST_FILES['bbs_file_3']['type'];

            //아카마이 ftp 파일 업로드
            $akamaiFtpUploadFiles = array();

            $path = $bbs_data_dir . "/" . $bbs_table_name . "/";
            if (!is_dir($path)) {
                if (is_writable($bbs_data_dir)) {
                    mkdir($path, 0777);
                    chmod($path, 0777);
                }
            }

            $path = $bbs_data_dir . "/" . $bbs_table_name . "/" . $bbs_ix . "/";
            if (!is_dir($path)) {
                if (is_writable($bbs_data_dir . "/" . $bbs_table_name)) {
                    mkdir($path, 0777);
                    chmod($path, 0777);
                }
            }

            $db->query("select board_thumbnail_yn,thum_width,thum_height from bbs_manage_config where board_ename = '" . $board . "'");
            $db->fetch();

            $board_thumbnail_yn = $db->dt['board_thumbnail_yn'];
            $thum_width = $db->dt['thum_width'];
            $thum_height = $db->dt['thum_height'];

            $db->query("select bbs_file_1,bbs_file_2,bbs_file_3 from " . $bbs_table_name . " where bbs_ix = '" . $bbs_ix . "'");
            $db->fetch();

            if ($bbs_file_1_size > 0) {
                if ($db->dt['bbs_file_1'] != "") {
                    if (file_exists($path . $db->dt['bbs_file_1'])) {
                        unlink($path . $db->dt['bbs_file_1']);
                    }
                    if (file_exists($path . "s_" . $db->dt['bbs_file_1'])) {
                        unlink($path . "s_" . $db->dt['bbs_file_1']);
                    }
                }

                move_uploaded_file($bbs_file_1, $path . $bbs_file_1_name);
                $file_string = ", bbs_file_1 = '" . $bbs_file_1_name . "' ";

                $akamaiFtpUploadFiles[] = $bbs_file_1_name;
                if ($board_thumbnail_yn == "Y") {
                    $akamaiFtpUploadFiles[] = "s_" . $bbs_file_1_name;
                }
            }

            if ($bbs_file_2_size > 0) {
                if ($db->dt['bbs_file_2'] != "") {
                    if (file_exists($path . $db->dt['bbs_file_2'])) {
                        unlink($path . $db->dt['bbs_file_2']);
                    }
                    if (file_exists($path . "s_" . $db->dt['bbs_file_2'])) {
                        unlink($path . "s_" . $db->dt['bbs_file_2']);
                    }
                }
                move_uploaded_file($bbs_file_2, $path . $bbs_file_2_name);
                $file_string .= ", bbs_file_2 = '" . $bbs_file_2_name . "' ";

                $akamaiFtpUploadFiles[] = $bbs_file_2_name;
                if ($board_thumbnail_yn == "Y") {
                    $akamaiFtpUploadFiles[] = "s_" . $bbs_file_2_name;
                }
            }

            if ($bbs_file_3_size > 0) {
                if ($db->dt['bbs_file_3'] != "") {
                    if (file_exists($path . $db->dt['bbs_file_3'])) {
                        unlink($path . $db->dt['bbs_file_3']);
                    }
                    if (file_exists($path . "s_" . $db->dt['bbs_file_3'])) {
                        unlink($path . "s_" . $db->dt['bbs_file_3']);
                    }
                }
                move_uploaded_file($bbs_file_3, $path . $bbs_file_3_name);
                $file_string .= ", bbs_file_3 ='" . $bbs_file_3_name . "' ";

                $akamaiFtpUploadFiles[] = $bbs_file_3_name;
                if ($board_thumbnail_yn == "Y") {
                    $akamaiFtpUploadFiles[] = "s_" . $bbs_file_3_name;
                }
            }

            /* 썸네일 이미지 생성 시작 */
            $image_info = getimagesize($path . "/" . $bbs_file_1_name);
            $image_type = substr($image_info['mime'], -3);

            if ($board_thumbnail_yn == "Y") {
                if ($board == "premium_after") {
                    if ($image_type == "gif" || $image_type == "GIF") {
                        if ($bbs_file_1_size > 0) {
                            MirrorGif($path . "/" . $bbs_file_1_name, $path . "/b_" . $bbs_file_1_name, MIRROR_NONE);
                            resize_gif($path . "/b_" . $bbs_file_1_name, '700', '700', 'W');

                            MirrorGif($path . "/" . $bbs_file_1_name, $path . "/s_" . $bbs_file_1_name, MIRROR_NONE);
                            resize_gif($path . "/s_" . $bbs_file_1_name, $thum_width, $thum_height, 'W');
                        }
                        if ($bbs_file_2_size > 0) {
                            MirrorGif($path . "/" . $bbs_file_2_name, $path . "/s_" . $bbs_file_2_name, MIRROR_NONE);
                            resize_gif($path . "/s_" . $bbs_file_2_name, $thum_width, $thum_height, 'W');
                        }
                        if ($bbs_file_3_size > 0) {
                            MirrorGif($path . "/" . $bbs_file_3_name, $path . "/s_" . $bbs_file_3_name, MIRROR_NONE);
                            resize_gif($path . "/s_" . $bbs_file_3_name, $thum_width, $thum_height, 'W');
                        }
                    } else if ($image_type == "png" || $image_type == "PNG") {
                        if ($bbs_file_1_size > 0) {
                            MirrorPNG($path . "/" . $bbs_file_1_name, $path . "/b_" . $bbs_file_1_name, MIRROR_NONE);
                            resize_png($path . "/b_" . $bbs_file_1_name, '700', '700', 'W');

                            MirrorPNG($path . "/" . $bbs_file_1_name, $path . "/s_" . $bbs_file_1_name, MIRROR_NONE);
                            resize_png($path . "/s_" . $bbs_file_1_name, $thum_width, $thum_height, 'W');
                        }
                        if ($bbs_file_2_size > 0) {
                            MirrorPNG($path . "/" . $bbs_file_2_name, $path . "/s_" . $bbs_file_2_name, MIRROR_NONE);
                            resize_png($path . "/s_" . $bbs_file_2_name, $thum_width, $thum_height, 'W');
                        }
                        if ($bbs_file_3_size > 0) {
                            MirrorPNG($path . "/" . $bbs_file_3_name, $path . "/s_" . $bbs_file_3_name, MIRROR_NONE);
                            resize_png($path . "/s_" . $bbs_file_3_name, $thum_width, $thum_height, 'W');
                        }
                    } else {
                        if ($bbs_file_1_size > 0) {
                            Mirror($path . "/" . $bbs_file_1_name, $path . "/b_" . $bbs_file_1_name, MIRROR_NONE);
                            resize_jpg($path . "/b_" . $bbs_file_1_name, '700', '700', 'W');

                            Mirror($path . "/" . $bbs_file_1_name, $path . "/s_" . $bbs_file_1_name, MIRROR_NONE);
                            resize_jpg($path . "/s_" . $bbs_file_1_name, $thum_width, $thum_height, 'W');
                        }
                        if ($bbs_file_2_size > 0) {
                            Mirror($path . "/" . $bbs_file_2_name, $path . "/s_" . $bbs_file_2_name, MIRROR_NONE);
                            resize_jpg($path . "/s_" . $bbs_file_2_name, $thum_width, $thum_height, 'W');
                        }
                        if ($bbs_file_3_size > 0) {
                            Mirror($path . "/" . $bbs_file_3_name, $path . "/s_" . $bbs_file_3_name, MIRROR_NONE);
                            resize_jpg($path . "/s_" . $bbs_file_3_name, $thum_width, $thum_height, 'W');
                        }
                    }
                } else {
                    if ($image_type == "gif" || $image_type == "GIF") {
                        if ($bbs_file_1_size > 0) {
                            MirrorGif($path . "/" . $bbs_file_1_name, $path . "/s_" . $bbs_file_1_name, MIRROR_NONE);
                            resize_gif($path . "/s_" . $bbs_file_1_name, $thum_width, $thum_height);
                        }
                        if ($bbs_file_2_size > 0) {
                            MirrorGif($path . "/" . $bbs_file_2_name, $path . "/s_" . $bbs_file_2_name, MIRROR_NONE);
                            resize_gif($path . "/s_" . $bbs_file_2_name, $thum_width, $thum_height);
                        }
                        if ($bbs_file_3_size > 0) {
                            MirrorGif($path . "/" . $bbs_file_3_name, $path . "/s_" . $bbs_file_3_name, MIRROR_NONE);
                            resize_gif($path . "/s_" . $bbs_file_3_name, $thum_width, $thum_height);
                        }
                    } else if ($image_type == "png" || $image_type == "PNG") {
                        if ($bbs_file_1_size > 0) {
                            MirrorPNG($path . "/" . $bbs_file_1_name, $path . "/s_" . $bbs_file_1_name, MIRROR_NONE);
                            resize_png($path . "/s_" . $bbs_file_1_name, $thum_width, $thum_height);
                        }
                        if ($bbs_file_2_size > 0) {
                            MirrorPNG($path . "/" . $bbs_file_2_name, $path . "/s_" . $bbs_file_2_name, MIRROR_NONE);
                            resize_png($path . "/s_" . $bbs_file_2_name, $thum_width, $thum_height);
                        }
                        if ($bbs_file_3_size > 0) {
                            MirrorPNG($path . "/" . $bbs_file_3_name, $path . "/s_" . $bbs_file_3_name, MIRROR_NONE);
                            resize_png($path . "/s_" . $bbs_file_3_name, $thum_width, $thum_height);
                        }
                    } else {
                        if ($bbs_file_1_size > 0) {
                            Mirror($path . "/" . $bbs_file_1_name, $path . "/s_" . $bbs_file_1_name, MIRROR_NONE);
                            resize_jpg($path . "/s_" . $bbs_file_1_name, $thum_width, $thum_height);
                        }
                        if ($bbs_file_2_size > 0) {
                            Mirror($path . "/" . $bbs_file_2_name, $path . "/s_" . $bbs_file_2_name, MIRROR_NONE);
                            resize_jpg($path . "/s_" . $bbs_file_2_name, $thum_width, $thum_height);
                        }
                        if ($bbs_file_3_size > 0) {
                            Mirror($path . "/" . $bbs_file_3_name, $path . "/s_" . $bbs_file_3_name, MIRROR_NONE);
                            resize_jpg($path . "/s_" . $bbs_file_3_name, $thum_width, $thum_height);
                        }
                    }
                }

                if ($board == "premium_after") {
                    if ($layout_config['mall_data_root']) {
                        akamaiFtpUpload($layout_config['mall_data_root'] . "/bbs_data/" . $bbs_table_name . "/" . $bbs_ix, $akamaiFtpUploadFiles);
                    } else {
                        akamaiFtpUpload($admininfo['mall_data_root'] . "/bbs_data/" . $bbs_table_name . "/" . $bbs_ix, $akamaiFtpUploadFiles);
                    }
                }
            }
            /* 썸네일 이미지 생성 끝 */
            if ($regdate) {
                $regdate_str = ",regdate = '$regdate' ";
            }

            if (!$is_html) {
                $is_html = "Y";
            }

            if (!$is_notice) {
                $is_notice = "N";
            }

            if ($admininfo['company_id']) {
                $bbs_etc5 = $admininfo['company_id'];
            }

            if ($admininfo['com_type'] == 'A' && ($board == "b2b_qna" || $board == "b2b_suggest" || $board == "b2b_account")) {
                $bbs_etc1 = $md_code;
            }

            if ($status != '') {
                $status_str = ",status = '$status'";
            }

            $bbs_subject = str_replace("'", "&#39;", $bbs_subject);
            $bbs_contents = str_replace("'", "&#39;", $bbs_contents);
            //$bbs_contents = strip_tags($bbs_contents,"<img><table><th><col><colgroup><tbody><tr><td><div><a><ul><li><dl><dt><p><h><br>");

            $sql = "	update " . $bbs_table_name . "
			   set bbs_subject = '" . trim($bbs_subject) . "'
			   	 , bbs_div = '$bbs_div'
			   	 , sub_bbs_div = '$sub_bbs_div'
			     , bbs_name = '$bbs_name'
			     , bbs_pass = '$bbs_pass'
			     , bbs_email = '$bbs_email'
			     , bbs_contents = '$bbs_contents'
			     , bbs_hidden = '$bbs_hidden'
			     , bbs_etc1 = '$bbs_etc1'
			     , bbs_etc2 = '$bbs_etc2'
			     , bbs_etc3 = '$bbs_etc3'
			     , bbs_etc4 = '$bbs_etc4'
			     , bbs_etc5 = '$bbs_etc5'
			     , is_notice = '$is_notice'
			     , is_html = '$is_html'
			     , ip_addr = '" . $_SERVER["REMOTE_ADDR"] . "'
				 $status_str
				 $file_string
				 $regdate_str
			 where bbs_ix = '" . $bbs_ix . "' ";

            //echo nl2br($sql);
            //exit;
            $db->query($sql);

            if ($board == "after" || $board == "premium_after") {
                if (empty($valuation_goods_info)) {
                    $valuation_goods_info = $valuation_goods;
                }

                if (empty($valuation_package)) {
                    $valuation_package = $valuation_delivery;
                }

                $sql = "update " . $bbs_table_name . "
				   set valuation_goods = '" . $valuation_goods . "'
				     , valuation_goods_info = '" . $valuation_goods_info . "'
				     , valuation_delivery = '" . $valuation_delivery . "'
				     , valuation_package = '" . $valuation_package . "'
				 where bbs_ix = '" . $bbs_ix . "' ";

                $db->query($sql);
            }

            //--------------------게시판 포인트 START--------------------//
            if ($reserve_data['point_use_yn'] == "Y") {
                //일반후기, 프리미엄후기시 공개시 updqte!
                if (($board == "after" || $board == "premium_after") && $status == '1' && substr_count($_SERVER["PHP_SELF"], "/admin/") > 0) {
                    InsertReserveInfo($user_code, $board, $bbs_ix, '', $write_point, '1', '5', $board_name . " 쓰기에 대한 포인트 적립", 'point', $admininfo);

                    /* 신규 포인트,마일리지 접립 함수 JK 160405 */
                    $mileage_data['uid'] = $user_code;
                    $mileage_data['type'] = 1;
                    $mileage_data['mileage'] = $write_point;
                    $mileage_data['message'] = $board_name . " 쓰기에 대한 포인트 적립";
                    $mileage_data['state_type'] = 'add';
                    $mileage_data['save_type'] = 'point';
                    $mileage_data['oid'] = $board;
                    $mileage_data['od_ix'] = $bbs_ix;
                    InsertMileageInfo($mileage_data);
                }
            }
            //--------------------게시판 포인트 END--------------------//


            if ($bbs_mode == "slide") {
                echo "<Script>document.location.href='?mode=list&board=$board&page=$page&bbs_ix=$bbs_ix&bbs_div=$bbs_div&mmode=$mmode&mem_ix=$mem_ix';</Script>";
            } else if ($bbs_mode == "top") {
                echo "<Script>parent.document.location.reload();location.href='about:blank';</Script>";
            } else {
                //echo "<Script>top.document.location.href='?mode=read&board=$board&article_no=$article_no&bbs_ix=$bbs_ix&bbs_div=$bbs_div';</Script>";
                if ($page_type == "pop") {
                    // ff660ba890b2a82d00b44d1ff2b76f0a : 구매후기가 수정되었습니다.
                    if ($popup_style == 'modal') {
                        echo("<script>alert('" . getLanguageText('694ce65315db5e5b460a3b5c8dcef684') . ".');top.location.reload();</script>");
                    } else {
                        echo "<Script>alert('" . getLanguageText('694ce65315db5e5b460a3b5c8dcef684') . ".');top.self.close();parent.opener.document.location.reload();</Script>";
                    }

                    //echo "<Script>alert('".getLanguageText('ff660ba890b2a82d00b44d1ff2b76f0a').".');top.opener.location.reload();top.location.reload();location.href='about:blank';</Script>";
                } else if ($page_type == "mobile") {
                    //모바일
                    if ($board == "after" || $board == "premium_after") {
                        if ($board == "premium_after") {
                            $review_type = "A";
                        }
                        // ff660ba890b2a82d00b44d1ff2b76f0a : 구매후기가 수정되었습니다.
                        echo "<Script>alert('" . getLanguageText('ff660ba890b2a82d00b44d1ff2b76f0a') . ".');top.document.location.href='/mypage/review_bbs.php?review_type=$review_type';</Script>";
                    } else {
                        echo "<Script>parent.document.location.href='?mode=read&board=$board&article_no=$article_no&bbs_ix=$bbs_ix&bbs_div=$bbs_div&mmode=$mmode&mem_ix=$mem_ix';</Script>";
                    }
                } else {
                    echo "<Script>parent.document.location.href='?mode=read&board=$board&article_no=$article_no&bbs_ix=$bbs_ix&bbs_div=$bbs_div&mmode=$mmode&mem_ix=$mem_ix';</Script>";
                }
            }
        }

        // ** 3 삭제 
        if ($act == "delete") {
            if (($user_code != "") && !$admin_mode) {
                $db->query("select * from " . $bbs_table_name . " where mem_ix = '" . $user_code . "' and bbs_ix = '$bbs_ix' ");

                if ($db->total) {
                    $path = $bbs_data_dir . "/" . $bbs_table_name . "/" . $bbs_ix . "/";

                    if (is_dir($path)) {
                        rmdirr($path);
                    }

                    $sql = "delete from " . $bbs_table_name . " where bbs_ix='$bbs_ix' and mem_ix = '" . $user_code . "' ";
                    $db->query($sql);

                    $sql = "delete from " . $bbs_table_name . "_comment where bbs_ix='$bbs_ix'";
                    $db->query($sql);

                    //echo "<Script>document.location.href='?mode=list&board=$board&bbs_div=$bbs_div';</Script>";
                    //후기 작업시 아래 내용으로 아이소다 프로세스 복사 2013.06.30 신훈식
                    if ($bbs_mode == "top") {
                        echo "<Script>top.document.location.reload();location.href='about:blank';</Script>";
                    } else if ($bbs_mode == "after") {
                        echo "<Script>parent.document.location.reload();location.href='about:blank';</Script>";
                    } else {
                        echo "<Script>document.location.href='?mode=list&board=$board&bbs_div=$bbs_div&mmode=$mmode&mem_ix=$mem_ix" . $add_after_query . "';</Script>";
                    }
                } else {
                    //후기 작업시 아래 내용으로 아이소다 프로세스 복사 2013.06.30 신훈식
                    // 85b2ed76529ee1a1610c8f09354feed3 : 해당글은 회원님의 글이 아닙니다. 확인후 다시 삭제해 주시기 바랍니다
                    if ($bbs_mode == "top") {
                        echo "<Script>alert('" . getLanguageText('85b2ed76529ee1a1610c8f09354feed3') . ".');</Script>";
                    } else {
                        echo "<Script>alert('" . getLanguageText('85b2ed76529ee1a1610c8f09354feed3') . ".');history.back();</Script>";
                    }
                }
            } else if ($admin_mode) {
                $db->query("Select * from " . $bbs_table_name . " where bbs_ix='$bbs_ix' ");

                $path = $bbs_data_dir . "/" . $bbs_table_name . "/" . $bbs_ix . "/";

                if (is_dir($path)) {
                    rmdirr($path);
                }

                $sql = "delete from " . $bbs_table_name . " where bbs_ix='$bbs_ix'";
                $db->query($sql);

                $sql = "delete from " . $bbs_table_name . "_comment where bbs_ix='$bbs_ix'";
                $db->query($sql);

                echo "<Script>document.location.href='?mode=list&board=$board&bbs_div=$bbs_div&mmode=$mmode&mem_ix=$mem_ix';</Script>";
            } else {
                $db->query("Select * from " . $bbs_table_name . " where bbs_pass = '$bbs_pass' and bbs_ix='$bbs_ix' ");

                if ($db->total) {
                    $path = $bbs_data_dir . "/" . $bbs_table_name . "/" . $bbs_ix . "/";

                    if (is_dir($path)) {
                        rmdirr($path);
                    }

                    $sql = "delete from " . $bbs_table_name . " where bbs_ix='$bbs_ix'  ";
                    $db->query($sql);

                    $sql = "delete from " . $bbs_table_name . "_comment where bbs_ix='$bbs_ix'";
                    $db->query($sql);

                    echo "<Script>document.location.href='?mode=list&board=$board&bbs_div=$bbs_div&mmode=$mmode&mem_ix=$mem_ix';</Script>";
                } else {
                    // ac67370562054286e2a91334b2d96b4c : 비밀번호가 불일치 합니다.
                    echo "<Script>alert('" . getLanguageText('ac67370562054286e2a91334b2d96b4c') . ".');history.back();</Script>";
                }
            }
        }

        // ** 4 응답
        if ($act == "response") {
            $bbs_file_1 = $HTTP_POST_FILES['bbs_file_1']['tmp_name'];
            $bbs_file_1_name = $HTTP_POST_FILES['bbs_file_1']['name'];
            $bbs_file_1_size = $HTTP_POST_FILES['bbs_file_1']['size'];
            $bbs_file_1_type = $HTTP_POST_FILES['bbs_file_1']['type'];

            $bbs_file_2 = $HTTP_POST_FILES['bbs_file_2']['tmp_name'];
            $bbs_file_2_name = $HTTP_POST_FILES['bbs_file_2']['name'];
            $bbs_file_2_size = $HTTP_POST_FILES['bbs_file_2']['size'];
            $bbs_file_2_type = $HTTP_POST_FILES['bbs_file_2']['type'];

            $bbs_file_3 = $HTTP_POST_FILES['bbs_file_3']['tmp_name'];
            $bbs_file_3_name = $HTTP_POST_FILES['bbs_file_3']['name'];
            $bbs_file_3_size = $HTTP_POST_FILES['bbs_file_3']['size'];
            $bbs_file_3_type = $HTTP_POST_FILES['bbs_file_3']['type'];

            /* 스팸글 방지위해 만듬 시작 */
            $bbs_user = $_SERVER["REMOTE_ADDR"] . "\t" . $_SERVER["HTTP_USER_AGENT"] . "\t" . date("Y-m-d H:i:s") . "\t" . $_COOKIE["C_TOKEN"] . "\t" . $bbs_subject . "\r\n";

            $fp = fopen($bbs_data_dir . "/bbs_writer.txt", "a+");
            fwrite($fp, $bbs_user);
            fclose($fp);

            if (($focus_info == "" && $focus_info != "Y") || $_SERVER["HTTP_REFERER"] == "") {  //  || $focus_info != "Y"
                exit;
            }

            if ($_COOKIE["C_TOKEN"] != $token || $_COOKIE["C_TOKEN"] == "") {
                exit;
            }
            /* 스팸글 방지위해 만듬 끝 */

            $db->query("select IFNULL(max(bbs_ix),0) as bbs_ix from " . $bbs_table_name);
            if ($db->total) {
                $db->fetch();
                $bbs_ix = $db->dt['bbs_ix'] + 1;
            } else {
                $bbs_ix = 0;
            }

            if ($bbs_parent_ix == "") {
                $bbs_parent_ix = 0;
            }

            if ($bbs_ix_level == "") {
                $bbs_ix_level = 0;
            }

            $sql = "select IFNULL(max(bbs_ix_step )+1,0) as bbs_ix_step from " . $bbs_table_name . " where bbs_top_ix =  '" . $bbs_top_ix . "' ";
            $db->query($sql);

            if ($db->total) {
                $db->fetch();
                $bbs_ix_step = $db->dt['bbs_ix_step'];
            } else {
                $bbs_ix_step = 0;
            }

            $sql = "select IFNULL(max(bbs_ix_level )+1,0) as bbs_ix_level from " . $bbs_table_name . " where bbs_top_ix = " . $bbs_parent_ix . " and bbs_ix_level = " . $bbs_ix_level;
            $db->query($sql);
            if ($db->total) {
                $db->fetch();
                $bbs_ix_level = $db->dt['bbs_ix_level'];
            } else {
                $bbs_ix_level = 0;
            }

            if (!$is_html) {
                $is_html = "Y";
            }

            $bbs_subject = str_replace("'", "&#39;", $bbs_subject);
            $bbs_contents = str_replace("'", "&#39;", $bbs_contents);

            $sql = "insert into " . $bbs_table_name . " (bbs_ix,bbs_div,mem_ix,bbs_subject,bbs_name,bbs_pass,bbs_email,bbs_contents,bbs_top_ix, bbs_ix_level, bbs_ix_step, bbs_hidden, bbs_file_1,bbs_file_2,bbs_file_3, bbs_etc1,bbs_etc2,valuation_goods,bbs_etc4,bbs_etc5, is_html, ip_addr, regdate)
			values
			('$bbs_ix','$bbs_div','" . $user_code . "','$bbs_subject','$bbs_name','$bbs_pass','$bbs_email','$bbs_contents','$bbs_parent_ix','$bbs_ix_level','$bbs_ix_step','$bbs_hidden','$bbs_file_1_name','$bbs_file_2_name','$bbs_file_3_name','$bbs_etc1','$bbs_etc2','$valuation_goods','$bbs_etc4','$bbs_etc5','$is_html','" . $_SERVER["REMOTE_ADDR"] . "', NOW())";

            $db->query($sql);
            $db->query("Select bbs_ix from " . $bbs_table_name . " where bbs_ix = '$bbs_ix' ");
            $db->fetch(0);
            $bbs_ix = $db->dt['bbs_ix'];

            $path = $bbs_data_dir;
            if (!is_dir($path . "/" . $bbs_table_name)) {

                if (is_writable($path)) {
                    mkdir($path . "/" . $bbs_table_name, 0777);
                    chmod($path . "/" . $bbs_table_name, 0777);
                }
            }

            $path = $bbs_data_dir . "/" . $bbs_table_name;
            if (!is_dir($path . "/" . $bbs_ix)) {

                if (is_writable($path)) {
                    //echo $path."/".$bbs_ix;
                    mkdir($path . "/" . $bbs_ix, 0777);
                    chmod($path . "/" . $bbs_ix, 0777);
                }
            }

            $path = $bbs_data_dir . "/" . $bbs_table_name . "/" . $bbs_ix;
            if (is_dir($path)) {

                if ($bbs_file_1_size > 0) {
                    move_uploaded_file($bbs_file_1, $path . "/" . $bbs_file_1_name);
                }

                if ($bbs_file_2_size > 0) {
                    move_uploaded_file($bbs_file_2, $path . "/" . $bbs_file_2_name);
                }

                if ($bbs_file_3_size > 0) {
                    move_uploaded_file($bbs_file_3, $path . "/" . $bbs_file_3_name);
                }
            }

            //--------------------게시판 포인트 START--------------------//
            if ($reserve_data['point_use_yn'] == "Y") {
                $sql = "select board_point_yn, board_point_time, response_point, board_name FROM bbs_manage_config where board_ename = '" . $board . "' ";
                $db->query($sql);
                $db->fetch();

                $board_point_yn = $db->dt['board_point_yn'];
                $board_point_time = $db->dt['board_point_time'];
                $response_point = $db->dt['response_point'];
                $board_name = $db->dt['board_name'];

                if ($board_point_yn == 'Y' && $write_point > 0 && $user_code != '') {
                    if ($board_point_time == 'R') {//즉시
                        $reserve_state = 1; //적립금 1이 RESERVE_STATUS_COMPLETE
                    } else if ($board_point_time == 'A') {//승인
                        $reserve_state = 0; //적립금 0이 RESERVE_STATUS_READY
                    } else {
                        $reserve_state = 0;
                    }
                    //////////////// 마일리지 적립 시작///////////////////////
                    InsertReserveInfo($user_code, $board, $bbs_ix, '', $response_point, $reserve_state, '5', $board_name . " 쓰기에 대한 포인트 적립", 'point', $admininfo); //마일리지,적립금 통합용 함수 2013-06-19 이학봉
                    //////////////// 마일리지 적립 끝///////////////////////

                    /* 신규 포인트,마일리지 접립 함수 JK 160405 */
                    $mileage_data['uid'] = $user_code;
                    $mileage_data['type'] = 1;
                    $mileage_data['mileage'] = $response_point;
                    $mileage_data['message'] = $board_name . " 쓰기에 대한 포인트 적립";
                    $mileage_data['state_type'] = 'add';
                    $mileage_data['save_type'] = 'point';
                    $mileage_data['oid'] = $board;
                    $mileage_data['od_ix'] = $bbs_ix;
                    InsertMileageInfo($mileage_data);
                }
            }
            //--------------------게시판 포인트 END--------------------//
            //exit;
            echo "<Script>document.location.href='?mode=list&board=$board&bbs_div=$bbs_div&mmode=$mmode&mem_ix=$mem_ix';</Script>";
        }

        // ** 5 댓글 등록
        if ($act == "comment_insert") {
            /* 스팸글 방지위해 만듬 시작 */
            $bbs_user = $_SERVER["REMOTE_ADDR"] . "\t" . $_SERVER["HTTP_USER_AGENT"] . "\t" . date("Y-m-d H:i:s") . "\t" . $_COOKIE["C_TOKEN"] . "\t" . $cmt_name . "\r\n";

            $fp = fopen($bbs_data_dir . "/bbs_comment_writer.txt", "a+");
            fwrite($fp, $bbs_user);
            fclose($fp);
            if ($focus_info != "Y" || $_SERVER["HTTP_REFERER"] == "") {
                echo "spam error";
                exit;
            }

            if ($_COOKIE["C_TOKEN"] != $token || $_COOKIE["C_TOKEN"] == "") {
                exit;
            }
            /* 스팸글 방지위해 만듬 끝 */

            $cmt_contents = str_replace("'", "&#39;", $cmt_contents);

            $sql = "insert into " . $bbs_table_name . "_comment
			(cmt_ix,bbs_ix,mem_ix,cmt_name,cmt_pass,cmt_email,cmt_contents, regdate)
			values
			('','$bbs_ix','" . $user_code . "','$cmt_name','$cmt_pass','$cmt_email','$cmt_contents',NOW())";
            $db->sequences = "" . strtoupper($bbs_table_name) . "_COMMENT_SEQ";
            $db->query($sql);

            if ($status != "") {
                $status_str = ", status = '" . $status . "'";
            }

            $db->query("update " . $bbs_table_name . " set bbs_re_cnt = bbs_re_cnt + 1 $status_str where bbs_ix ='$bbs_ix'");

            $sql = "SELECT bd.div_name, b.* FROM bbs_manage_config bc LEFT JOIN bbs_manage_div bd ON bc.bm_ix=bd.bm_ix LEFT JOIN " . $bbs_table_name . " b ON bd.div_ix=b.bbs_div WHERE b.bbs_ix='" . $bbs_ix . "' "; //수정 kbk 12/06/28
            $db->query($sql);
            if ($db->total) {
                $db->fetch();
            }

            if ($status == "5") {//답변완료일때만 답변메일 보내도록 kbk 12/06/28
                if ($db->dt['bbs_etc1'] == 1 || $db->dt['bbs_etc3'] == 1) {
                    $mail_info['bbs_div'] = $db->dt['div_name'];
                    $mail_info['bbs_subject'] = $db->dt['bbs_subject'];
                    $mail_info['bbs_contents'] = $db->dt['bbs_contents'];
                    $mail_info['cmt_contents'] = $cmt_contents;
                    $mail_info['mem_name'] = $db->dt['bbs_name'];

                    if ($db->dt['bbs_etc1'] == 1)
                        $mail_info['mem_mail'] = $db->dt['bbs_email'];
                    $mail_info['mem_id'] = $db->dt['bbs_name'];
                    if ($db->dt['bbs_etc3'] == 1)
                        $mail_info['mem_mobile'] = $db->dt['bbs_etc2'];
                    $mail_info['msg_code'] = '0703'; // MSG 발송코드 0703 : 1:1상담답변
                    sendMessageByStep('cs_reply', $mail_info);
                }
            }

            //--------------------게시판 포인트 START--------------------//
            if ($reserve_data['point_use_yn'] == "Y") {
                $sql = "SELECT board_point_yn, board_point_time, comment_point, board_name  FROM bbs_manage_config where board_ename = '" . $board . "' ";
                $db->query($sql);
                $db->fetch();

                $board_point_yn = $db->dt['board_point_yn'];
                $board_point_time = $db->dt['board_point_time'];
                $comment_point = $db->dt['comment_point'];
                $board_name = $db->dt['board_name'];

                if ($board_point_yn == 'Y' && $write_point > 0 && $user_code != '') {
                    if ($board_point_time == 'R') {//즉시
                        $reserve_state = 1; //적립금 1이 RESERVE_STATUS_COMPLETE
                    } elseif ($board_point_time == 'A') {//승인
                        $reserve_state = 0; //적립금 0이 RESERVE_STATUS_READY
                    } else {
                        $reserve_state = 0;
                    }

                    //////////////// 마일리지 적립 시작///////////////////////
                    InsertReserveInfo($user_code, $board, $bbs_ix, '', $response_point, $reserve_state, '5', $board_name . " 쓰기에 대한 포인트 적립", 'point', $admininfo); //마일리지,적립금 통합용 함수 2013-06-19 이학봉
                    //////////////// 마일리지 적립 끝///////////////////////

                    /* 신규 포인트,마일리지 접립 함수 JK 160405 */
                    $mileage_data['uid'] = $user_code;
                    $mileage_data['type'] = 1;
                    $mileage_data['mileage'] = $response_point;
                    $mileage_data['message'] = $board_name . " 쓰기에 대한 포인트 적립";
                    $mileage_data['state_type'] = 'add';
                    $mileage_data['save_type'] = 'point';
                    $mileage_data['oid'] = $board;
                    $mileage_data['od_ix'] = $bbs_ix;
                    InsertMileageInfo($mileage_data);
                }
            }
            //--------------------게시판 포인트 END--------------------//


            if ($mmode == 'pop') {
                echo "<Script>parent.opener.location.reload();self.close();</Script>";
            } else {
                if ($_POST["bbs_pass"]) {
                    echo "<Script>document.location.href='?mode=read&board=$board&article_no=$article_no&bbs_ix=$bbs_ix&bbs_div=$bbs_div&bbs_pass=" . $_POST["bbs_pass"] . "';</Script>";
                } else {
                    echo "<Script>document.location.href='?mode=read&board=$board&article_no=$article_no&bbs_ix=$bbs_ix&bbs_div=$bbs_div';</Script>";
                }
            }
            exit;
        }

        // ** 6. 댓글 삭제
        if ($act == "comment_delete") {
            if ($admin_mode) {
                $sql = "select * from " . $bbs_table_name . "_comment where cmt_ix = '$cmt_ix' and bbs_ix='$bbs_ix'";
            } else {
                if ($cmt_pass != "") {
                    $sql = "select * from " . $bbs_table_name . "_comment where cmt_ix = '$cmt_ix' and bbs_ix='$bbs_ix' and cmt_pass ='$cmt_pass' ";
                } else {
                    $sql = "select * from " . $bbs_table_name . "_comment where cmt_ix = '$cmt_ix' and bbs_ix='$bbs_ix' and mem_ix ='" . $user_code . "' ";
                }
            }
            $db->query($sql);

            if ($db->total) {
                $sql = "	delete from " . $bbs_table_name . "_comment where cmt_ix = '$cmt_ix' and bbs_ix='$bbs_ix' ";
                $db->query($sql);
                $db->query("update " . $bbs_table_name . " set bbs_re_cnt = bbs_re_cnt - 1 where bbs_ix ='$bbs_ix'");

                if ($_POST["bbs_pass"]) {
                    echo "<Script>document.location.href='?mode=read&board=$board&article_no=$article_no&bbs_ix=$bbs_ix&bbs_div=$bbs_div&bbs_pass=" . $_POST["bbs_pass"] . "';</Script>";
                } else {
                    echo "<Script>document.location.href='?mode=read&board=$board&article_no=$article_no&bbs_ix=$bbs_ix&bbs_div=$bbs_div';</Script>";
                }
            } else {
                if ($cmt_pass != "") {
                    // ac67370562054286e2a91334b2d96b4c : 비밀번호가 불일치 합니다.
                    echo "<Script>alert('" . getLanguageText('ac67370562054286e2a91334b2d96b4c') . ".');history.back();</Script>";
                } else {
                    // a0529d88fdda811597e7271f2fa4be9d : 자신의 글이 아닙니다.
                    echo "<Script>alert('" . getLanguageText('a0529d88fdda811597e7271f2fa4be9d') . ".');history.back();</Script>";
                }
            }
        }

        // ** 7. 
        if ($act == "pass_check" || $act == "pass_check_for_read") {
            $pass_bbs_ix = $_POST["bbs_ix"]; // $_GET 값과 혼동되어 $_POST로 넘어 온 값을 인식못함 kbk 12/03/19
            $bbs_table_name = "bbs_" . $_POST["board"]; // 테이블 명 정보를 $_POST로 넘어 온 값을 사용 kbk 12/03/19
            if ($user_code != "" && $bbs_pass == "") {  //로그인 이고 자기글일때 바로 접근할때만
                $db->query("Select * from " . $bbs_table_name . " where mem_ix = '" . $user_code . "' and bbs_ix='$pass_bbs_ix' ");
            } else {
                $sql = "select * from " . $bbs_table_name . " where bbs_ix='$pass_bbs_ix' and bbs_pass ='$bbs_pass' ";
                //	echo $sql;
                $db->query($sql);
            }

            if ($db->total) {
                if ($act == "pass_check_for_read") {
                    echo "<Script>document.location.href='?mode=read&board=$board&bbs_ix=$pass_bbs_ix&bbs_pass=$bbs_pass';</Script>";
                } else {
                    echo "<Script>document.location.href='?mode=modify&board=$board&bbs_ix=$pass_bbs_ix&article_no=$article_no&page=$page&bbs_pass=$bbs_pass';</Script>";
                }
            } else {
                // ac67370562054286e2a91334b2d96b4c : 비밀번호가 불일치 합니다.
                echo "<Script>alert('" . getLanguageText('ac67370562054286e2a91334b2d96b4c') . ".');history.back();</Script>";
            }
        }

        // 8 faq 등록
        if ($act == "faq_insert") {
            $bbs_q = str_replace("'", "&#39;", $bbs_q);
            $bbs_a = str_replace("'", "&#39;", $bbs_a);

            $sql = "insert into " . $bbs_table_name . "
			(bbs_ix,bbs_div,sub_bbs_div, bbs_q,bbs_a,bbs_contents_type,regdate)
			values
			('','$bbs_div','$sub_bbs_div','$bbs_q','$bbs_a','$bbs_contents_type',NOW())";
            $db->sequences = "" . strtoupper($bbs_table_name) . "_SEQ";
            //echo $sql;
            $db->query($sql);
            echo "<Script>document.location.href='?mode=list&board=$board&bbs_div=$bbs_div';</Script>";
        }

        // 9 faq 변경
        if ($act == "faq_update") {
            $bbs_q = str_replace("'", "&#39;", $bbs_q);
            $bbs_a = str_replace("'", "&#39;", $bbs_a);

            $sql = "update " . $bbs_table_name . "
			   set bbs_div = '" . $_POST["bbs_div"] . "'
			     , sub_bbs_div = '$sub_bbs_div'
			     , bbs_q = '$bbs_q'
			     , bbs_a = '$bbs_a'
			     , bbs_contents_type = '$bbs_contents_type'
			 where bbs_ix = '$bbs_ix'";

            $db->query($sql);

            echo "<Script>document.location.href='?board=$board&mode=list';</Script>";
            exit;
        }

        // 10. faq 삭제
        if ($act == "faq_delete") {
            $sql = "delete from " . $bbs_table_name . " where bbs_ix='$bbs_ix'  ";
            $db->query($sql);

            echo "<Script>document.location.href='?board=$board&mode=list';</Script>";
            exit;
        }

        // 11. 
        if ($act == "select_delete") {
            $cnt = count($bbs_ix);
            if ($cnt > 0) {
                for ($i = 0; $i < $cnt; $i++) {
                    $path = $bbs_data_dir . "/" . $bbs_table_name . "/" . $bbs_ix[$i] . "/";

                    if (is_dir($path)) {
                        rmdirr($path);
                    }

                    $sql = "delete from " . $bbs_table_name . " where bbs_ix='" . $bbs_ix[$i] . "' ";
                    $db->query($sql);

                    $sql = "delete from " . $bbs_table_name . "_comment where bbs_ix='" . $bbs_ix[$i] . "'";
                    $db->query($sql);
                }
            }
            echo "<Script>document.location.href='?mode=list&board=$board&bbs_div=$bbs_div&mmode=$mmode&mem_ix=$mem_ix';</Script>";
        }

        // 12. 파일 삭제
        if ($act == "file_delete") {
            $file_column = "bbs_file_" . $file_num;
            $file_box_id = $file_column . "_box";

            $sql = "select " . $file_column . " from " . $bbs_table_name . " where bbs_ix='" . $bbs_ix . "' ";
            $db->query($sql);
            if ($db->total > 0) {
                $db->fetch();
                $in_file_name = $db->dt[$file_column];

                $sql = "update " . $bbs_table_name . " set " . $file_column . "='' where bbs_ix='" . $bbs_ix . "' ";
                $db->query($sql);

                $path = $bbs_data_dir . "/" . $bbs_table_name . "/" . $bbs_ix;
                if (file_exists($path . "/" . $in_file_name)) {
                    unlink($path . "/" . $in_file_name);
                }

                echo "<script type='text/javascript'>top.document.getElementById('" . $file_box_id . "').innerHTML='';</script>";
                exit;
            }
        }



        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        /*
         * View 처리
         */
        
        

        if ($mode == "category") {
            include($_SERVER["DOCUMENT_ROOT"] . "/bbs/category.load.php");
            exit;
        } else if ($mode == "download") {
            include($_SERVER["DOCUMENT_ROOT"] . "/bbs/download.php");
            exit;
        }
//
//echo $bbs_table_name;
        
        $msb = new MsBoard2($bbs_table_name);
        $msb->MsBoardConfigration();
        $msb->bbs_admin_mode = $admin_mode;
        $msb->bbs_template_dir = $bbs_template_dir;
        $msb->bbs_compile_dir = $bbs_compile_dir;
        $msb->bbs_data_dir = $bbs_data_dir;
        $msb->bbs_file_dir = $bbs_file_dir;
        $msb->site_template_src = $site_template_src;
        $msb->site_product_src = $site_product_src; //추가 kbk 13/07/05

        
        if ($mode == "list" || $mode == "") {
            $msb->bbs_singlefilemode = true;
//            
//            var_dump($msb);

            
            return $msb->PrintMsBoardList($bbs_div);
        } else if ($mode == "read") {
            $msb->bbs_table_name = $bbs_table_name;
            $msb->bbs_singlefilemode = true;
            return $msb->PrintMsBoardRead($article_no, $bbs_ix, $page, $bbs_div);
        } else if ($mode == "write") {
            $msb->edit_data_dir = $edit_data_dir;
            return $msb->PrintMsBoardWrite($bbs_div);
        } else if ($mode == "modify") {
            $msb->edit_data_dir = $edit_data_dir;
            return $msb->PrintMsBoardModify($bbs_ix, $article_no, $page, $bbs_div);
        } else if ($mode == "response") {
            $msb->edit_data_dir = $edit_data_dir;
            return $msb->PrintMsBoardResponse($bbs_ix, $page, $bbs_div);
        }
    }
}










function path_to_root($path)
{

    $pathinfo = pathinfo($path);
    $deep = substr_count($pathinfo['dirname'], "/");

    $path_to_root_str = "./";

    for ($i = 1; $i <= $deep; $i++) {
        $path_to_root_str .= "../";
    }

    return $path_to_root_str;
}
