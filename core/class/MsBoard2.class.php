<?php

/**
 * Description of MsBoard2
 *
 * @author hoksi
 */
Class MsBoard2
{

    var $bbs_templete_web_path;
    var $bbs_template_path;
    var $bbs_table_name;
    var $bbs_config;
    var $bbs_title;
    var $bbs_admin_mode;
    var $bbs_template_dir;
    var $bbs_compile_dir;
    var $site_template_src;
    var $site_product_src;
    var $bbs_data_dir;
    var $edit_data_dir;
    var $bbs_file_dir;
    var $bbs_template_name;
    var $bbs_after_admin_confirm;

    function __construct($pbbs_table_name = "")
    {
        global $DOCUMENT_ROOT, $ss_bbs_table_name;

        if ($pbbs_table_name == "") {
            $this->bbs_table_name = $_SESSION["ss_bbs_table_name"];
        } else {
            $this->bbs_table_name = $pbbs_table_name;
            $_SESSION["ss_bbs_table_name"] = ($_SERVER["pbbs_table_name"] ?? '');
        }
        $this->bbs_template_name = "";
        $this->bbs_admin_mode = false;
        $this->bbs_data_dir = "";
        $this->edit_data_dir = "";
        $this->bbs_after_admin_confirm = true; // 후기 관리자 승인후 노출 여부 2015-07-20 Hong
    }

    function MsBoardConfigration($layout_obj = "")
    {
        global $DOCUMENT_ROOT;
        $config_db = new Database();

        if ($this->bbs_admin_mode) {
            $sql = "SELECT 'admin' AS bbs_templet_dir, mc.* FROM bbs_manage_config mc WHERE  board_ename = '" . str_replace("bbs_", "", $this->bbs_table_name) . "' ";
            $config_db->query($sql);
            $config_db->fetch();
            $this->bbs_config = $config_db;
        } else {
            $sql = "SELECT * FROM bbs_manage_config mc WHERE board_ename = '" . str_replace("bbs_", "", $this->bbs_table_name) . "' ";
            $config_db->query($sql);
            $config_db->fetch();
            $this->bbs_config = $config_db;
        }
        
        
        //** 전달받은 객체로 템플릿 경로 셋팅
        if (is_object($layout_obj)) {
            $this->bbs_templete_web_path = $layout_obj->Config['mall_data_root'] . "/bbs_templet/" . $config_db->dt['bbs_templet_dir'] . "/";
            $this->bbs_template_path = $DOCUMENT_ROOT . $layout_obj->Config['mall_data_root'] . "/bbs_templet/" . $config_db->dt['bbs_templet_dir'];
        }

        $this->bbs_title = $config_db->dt['board_name'];
    }
 
    
    function PrintMsBoardList()
    {
        
        global $HTTP_URL, $user, $QUERY_STRING, $_GET, $admininfo;
        global $search_word, $esn, $ess, $esc, $type, $a_date_y, $a_date_m, $a_date_d, $status;
        global $status_info;
        global $FromYY, $FromMM, $FromDD, $ToYY, $ToMM, $ToDD;                                          //관리자 등록일자 검색 kbk 12/10/05
        global $sdate, $edate, $bbs_etc2;                                                               //마이페이지용 kbk 13/07/08

        $mdb = new Database();

        $nset = gVal("nset");
        $board = gVal("board");
        $page = gVal("page");
        $bbs_div = gVal("bbs_div");
        $sub_bbs_div = gVal("sub_bbs_div");
        $this->BoardAuth(gVal("mode"));
        $pid = gVal('pid');

        //** 게시판 스타일 
        if ($this->bbs_template_name == "") {
            if ($this->bbs_config->dt['board_style'] == "faq") {
                $this->bbs_template_name = "faq_list.htm";
            } else if ($this->bbs_config->dt['board_style'] == "attend") {
                $this->bbs_template_name = "attend_list.htm";
            } else {
                $this->bbs_template_name = "bbs_list.htm";
            }
        }

        //** 검색 조건 생성
        $bbsOn = false;
        $essOn = false;
        $esnOn = false;
        $escOn = false;
        $where = " WHERE 1 ";
        $pid_where = "";
        $add_notice_where = "";


        if ($this->bbs_config->dt['board_style'] == "bbs") {
            $bbsOn = true;
        }
        if ($type == "ess" || $ess == "on") {
            $essOn = true;
        }
        if ($type == "esn" || $esn == "on") {
            $esnOn = true;
        }
        if ($type == "esc" || $esc == "on") {
            $escOn = true;
        }


        if ($search_word != "") {

            if ($esnOn && $bbsOn) {
                $where .= " OR (bbs_name LIKE '%" . $search_word . "%')";
            }

            if ($essOn && $bbsOn) {
                $where .= " OR (bbs_subject LIKE '%" . $search_word . "%')";
            } else if ($essOn) {
                $where .= " OR (bbs_q LIKE '%" . $search_word . "%')";
            }

            if ($escOn && $bbsOn) {
                $where .= " OR (bbs_contents LIKE '%" . $search_word . "%')";
            } else if ($escOn) {
                $where .= " OR (bbs_a LIKE '%" . $search_word . "%')";
            }

            if (!($essOn || $esnOn || $escOn) && $bbsOn) {
                $where .= " OR (bbs_contents LIKE '%" . $search_word . "%') OR (bbs_subject LIKE '%" . $search_word . "%') OR (bbs_name LIKE '%" . $search_word . "%')";
            } else {
                $where .= " OR (bbs_a LIKE '%" . $search_word . "%')";
            }
        }

        if (gVal("daiso_charger_ix") != "") {
            $where .= " OR bbs_ix in (select bc.bbs_ix from " . $this->bbs_table_name . "_comment bc where bc.mem_ix='" . gVal("daiso_charger_ix") . "' )";
        }

        if (!empty($status)) {

            if (is_array($status)) {
                $cnt = 0;
                $tmpCond = "";
                foreach ($status as $st) {
                    if ($cnt > 0) {
                        $tmpCond .= " ,'" . $st . "' ";
                    } else {
                        $tmpCond .= " '" . $st . "' ";
                    }
                    $cnt++;
                }

                if ($cnt > 0) {
                    $where .= " AND status IN (" . $tmpCond . ")";
                }

                syslog(LOG_INFO, 'where : ' . $where);
            } else {
                $where .= " AND status = '" . $status . "'";
            }
        }


        if ($sdate != "") {
            $arr_sDate = explode("-", $sdate);
            $FromYY = $arr_sDate[0];
            $FromMM = $arr_sDate[1];
            $FromDD = $arr_sDate[2];

            $arr_eDate = explode("-", $edate);
            $ToYY = $arr_eDate[0];
            $ToMM = $arr_eDate[1];
            $ToDD = $arr_eDate[2];
        }

        if ($FromYY != "") {//관리자 등록일자 검색 kbk 12/10/05
            $s_regdate = $FromYY . "-" . $FromMM . "-" . $FromDD;
            $e_regdate = $ToYY . "-" . $ToMM . "-" . $ToDD;
            $where .= " AND (DATE_FORMAT(bbs.regdate,'%Y-%m-%d') BETWEEN '" . $s_regdate . "' AND '" . $e_regdate . "') ";
        }


        if ($bbs_div) {
            $where .= " AND bbs_div = '" . $bbs_div . "'";
        } else {
            $where .= " AND bbs_ix > 0 ";
        }
        if ($sub_bbs_div) {
            $where .= " AND sub_bbs_div = '" . $sub_bbs_div . "'";
        }

        //답변글로 인하여 디비 필드 추가 및 where절 추가 2009.12.22 김지훈
        if ($this->bbs_config->dt['board_qna_yn'] == "Y") {

            if (!substr_count($_SERVER["PHP_SELF"], "admin/")) {

                if ($this->bbs_admin_mode) {
                    $where .= " AND mem_ix = '" . sess_val("admininfo", 'charger_ix') . "'";
                } else {
                    if (sess_val("admininfo", 'company_id') && sess_val("admininfo", 'use_work') == 1) {
                        $where .= " AND bbs_etc5 = '" . sess_val("admininfo", 'company_id') . "' ";
                    } else {
                        $where .= " AND mem_ix = '" . $user['code'] . "' ";
                    }
                }
            }
        } else {
            if (sess_val("admininfo", 'company_id') && sess_val('admininfo', 'use_work') == 1) {
                $where .= " AND bbs_etc5 = '" . sess_val('admininfo', 'company_id') . "' ";
            }
        }


        if (gVal("mmode") == "personalization") {
            $where .= " AND mem_ix = '" . gVal("mem_ix") . "' ";
        }

        // 셀러관리 셀러업체 1:1 문의(b2b_qna) , 상점 1:1(seller_shop_cs) 문의 게시판은 자기게시글만 노출되게끔 처리함	2013-10-01 이학봉
        if (sess_val("admininfo", 'com_type') == "S" && ($this->bbs_config->dt['board_ename'] == "seller_shop_cs" || $this->bbs_config->dt['board_ename'] == "b2b_qna")) {
            $where .= " AND bbs_etc5 = '" . sess_val("admininfo", 'company_id') . "' ";
        }

        //일반후기와 프리미엄후기의 경우 마이페이지에서만 자신의 글 볼 수 있음 kbk 13/07/08
        if (($this->bbs_config->dt['board_ename'] == "after" || $this->bbs_config->dt['board_ename'] == "premium_after") && substr_count($_SERVER["PHP_SELF"], "/mypage/") > 0) {
            $where .= " AND mem_ix = '" . $user['code'] . "'";
        }

        if (($this->bbs_config->dt['board_ename'] == "after" || $this->bbs_config->dt['board_ename'] == "premium_after")) {
            if (!(substr_count($_SERVER["PHP_SELF"], "/admin/") > 0) && $this->bbs_after_admin_confirm) {
                $where .= " AND status = '1' AND bbs.bbs_etc1 in (select p.id from shop_product p where p.mall_ix in ('','" . sess_val('layout_config', 'mall_ix') . "')) ";
            }
        }

        $day_length = date("t");
        $day_array = array();
        for ($d = 1; $d <= $day_length; $d++) {
            array_push($day_array, $d);
        }

        //오라클때문에 
        if ($this->bbs_config->dt['board_style'] == "bbs") {
            $add_notice_where = " AND is_notice != 'Y'"; 
        }

        if ($pid != "") {
            $pid_where = " AND bbs_etc1 = '" . $pid . "' ";
        }

        if ($bbs_etc2 != "") {
            $where .= " AND bbs_etc2 LIKE '%" . $bbs_etc2 . "%' ";
        }

        //출석게시판의 경우 해당 일에 대한 게시물만 가져온다. kbk 12/06/08
        if ($this->bbs_config->dt['board_style'] == "attend") {
            if (!$a_date_y) {
                $a_date_y = date("Y");
            }
            if (!$a_date_m) {
                $a_date_m = date("m");
            }
            if (!$a_date_d) {
                $a_date_d = date("d");
            }
            $a_date_full = $a_date_y . "-" . $a_date_m . "-" . $a_date_d;
            $where .= " AND date_format(bbs.regdate,'%Y-%m-%d') = '" . $a_date_full . "'";
        }

        // Total 건수
        $sql = "SELECT COUNT(*) AS total FROM " . $this->bbs_table_name . " bbs  $where $add_notice_where $pid_where ";
        $mdb->query($sql);
        $mdb->fetch();
        $total = $mdb->dt['total'];


        $max = $this->bbs_config->dt['board_max_cnt'];
        if (intVal($max) == 0) {
            $max = 10;
        }

        // paging
        if ($page == '' || $page == '0') {
            $start = 0;
            $page = 1;
        } else {
            $start = ($page - 1) * $max;
        }

        $valuation_str = "";
        $select_str = "";

        // BBS or ATTEND
        if ($this->bbs_config->dt['board_style'] == "bbs" || $this->bbs_config->dt['board_style'] == "attend") {
            
            $no = $total - ($page - 1) * $max;

            if ($this->bbs_config->dt['board_ename'] == "qna" && sess_val("admininfo", "company_id")) {
                $select_str = " 
                    ,(SELECT mem_ix FROM " . $this->bbs_table_name . "_comment cmt WHERE cmt.bbs_ix = bbs.bbs_ix order by cmt_ix asc limit 0,1) as charger_ix
                    ,(SELECT regdate FROM " . $this->bbs_table_name . "_comment cmt WHERE cmt.bbs_ix = bbs.bbs_ix order by cmt_ix desc limit 0,1) as complete_date";
            }


            if ($this->bbs_config->dt['board_category_use_yn'] == "Y") {
                $sql = "
                    SELECT 
                        CASE 
                        WHEN bsdiv.div_name != '' 
                        THEN concat(bdiv.div_name,' > ',bsdiv.div_name) 
                        ELSE bdiv.div_name 
                        END AS div_name,  
                        bbs.*, 
                        bbs_name, 
                        IF(LENGTH(SUBSTRING(bbs.bbs_subject,(" . $this->bbs_config->dt['board_titlemax_cnt'] . "+1-bbs.bbs_ix_level),1)) > 0,
                            CONCAT(SUBSTRING(bbs.bbs_subject,1," . $this->bbs_config->dt['board_titlemax_cnt'] . "-bbs.bbs_ix_level),'...'), bbs.bbs_subject) AS bbs_subject,
                            bbs_subject as nocut_bbs_subject, $no AS cno,
                            CONCAT('?mode=read&board=" . $this->bbs_config->dt['board_ename'] . "&bbs_ix=',bbs_ix,'&page=','" . $page . "') AS link , 
                            CASE 
                            WHEN bbs.regdate > DATE_SUB(now(), interval " . $this->bbs_config->dt['design_new_priod'] . " HOUR) 
                            THEN 1 
                            ELSE 0 
                            END AS new 
                            " . $valuation_str . " " . $select_str . "
					FROM " . $this->bbs_table_name . " bbs 
                        LEFT JOIN " . TBL_BBS_MANAGE_DIV . " bdiv 
                            ON bdiv.div_ix = bbs.bbs_div  
                        AND bdiv.bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "'
					LEFT JOIN " . TBL_BBS_MANAGE_DIV . " bsdiv 
                        ON bsdiv.div_ix = bbs.sub_bbs_div  
                        AND bsdiv.bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "'
					$where 
                    $add_notice_where 
                    $pid_where 
                        ORDER BY bbs_top_ix DESC,
                        bbs_ix_level ASC 
                        LIMIT $start, $max ";
            } else {
                $sql = "
                    SELECT 
                        bbs.*, 
                        bbs_name, 
                        IF(LENGTH(SUBSTRING(bbs.bbs_subject,(" . $this->bbs_config->dt['board_titlemax_cnt'] . "+1-bbs.bbs_ix_level),1)) > 0, 
                            CONCAT(SUBSTRING(bbs.bbs_subject,1," . $this->bbs_config->dt['board_titlemax_cnt'] . "-bbs.bbs_ix_level),'...'), bbs.bbs_subject) AS bbs_subject, 
                            bbs_subject AS nocut_bbs_subject, 
                            $no AS cno,
                            CONCAT('?mode=read&board=" . $this->bbs_config->dt['board_ename'] . "&bbs_ix=',bbs_ix,'&page=','" . $page . "') AS link, 
                            CASE 
                            WHEN regdate > DATE_SUB(now(), interval " . $this->bbs_config->dt['design_new_priod'] . " HOUR) 
                            THEN 1 
                            ELSE 0 
                            END AS new 
                            " . $valuation_str . " " . $select_str . "
					FROM " . $this->bbs_table_name . " bbs
					$where 
                    $add_notice_where 
                    $pid_where 
                    ORDER BY bbs_top_ix DESC,
                    bbs_ix_level ASC 
                    LIMIT $start, $max ";
            }

            $mdb->query($sql);

            //** FAQ                
        } else if ($this->bbs_config->dt['board_style'] == "faq") {
            $sql = "Select * from " . $this->bbs_table_name . " bbs left join " . TBL_BBS_MANAGE_DIV . " bdiv on bdiv.div_ix = bbs.bbs_div $where  order by bbs_ix asc LIMIT $start, $max ";

            $mdb->query($sql);
        }
        
        
        //** 템플릿 설정
        $tpl = new Template_;
        $tpl->template_dir = $this->bbs_template_dir;
        $tpl->compile_dir = $this->bbs_compile_dir;
        $tpl->assign('day_length', $day_length);
        $tpl->assign('day_array', $day_array);
        $tpl->assign('a_date_y', $a_date_y);
        $tpl->assign('a_date_m', $a_date_m);
        $tpl->assign('a_date_d', $a_date_d);
        $tpl->define(array('bbs_list' => $this->bbs_template_name, 'bbs_title' => 'bbs_title.htm', 'bbs_write_s' => 'bbs_write_s.htm'));
        
        
        $loop = $mdb->fetchall();
        if (is_array($loop)) {
            foreach ($loop as $key => $val) {
                $mdb->query("Select * from " . $this->bbs_table_name . "_comment where  bbs_ix = '" . $val['bbs_ix'] . "' order by regdate asc ");
                $cmt_loop = $mdb->fetchall();
                $loop[$key]['cmt_loop'] = $cmt_loop;
            }
        }

        $tpl->assign('list', $loop);
        $tpl->assign('count_list', count($loop));
            
            
        if ($this->bbs_config->dt['board_style'] == "bbs" || $this->bbs_config->dt['board_style'] == "attend") {
       
            $sql = "Select b.div_name,a.*,CONCAT(SUBSTR(bbs_name,1,1),'*',SUBSTR(bbs_name,3)) AS bbs_name , $no as cno,bbs_name as writer,  concat('?mode=read&board=" . 
                $this->bbs_config->dt['board_ename'] . "&bbs_ix=',bbs_ix,'&page=','" . $page . "') as link , case when a.regdate > DATE_SUB(now(), interval " . 
                $this->bbs_config->dt['design_new_priod'] . " HOUR) then 1 else 0 end as new " . $valuation_str . " from " . $this->bbs_table_name . " a left join bbs_manage_div b on b.div_ix = a.bbs_div 
                    where is_notice = 'Y' order by bbs_top_ix desc,bbs_ix_step asc";
            $mdb->query($sql);

            $notices = $mdb->fetchall();
            $tpl->assign('notices', $notices);
     
            if ($this->bbs_config->dt['board_category_use_yn'] == "Y") {
                $sql = "SELECT bdiv.*, sum(case when bbs_div is NULL then 0 else 1 end) as  div_bbs_cnt , case when div_depth = 1 then div_ix  else parent_div_ix end as div_order
							FROM " . TBL_BBS_MANAGE_DIV . " bdiv left join bbs_" . $this->bbs_config->dt['board_ename'] . " bbs on bdiv.div_ix = bbs.bbs_div
							where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "' and div_depth = 1 AND bdiv.disp = 1
							group by div_ix
							order by view_order asc, div_depth asc"; 

                $mdb->query($sql);
                $bbs_divs = $mdb->fetchall();

                $tpl->assign('bbs_divs', $bbs_divs);

                if ($bbs_div) {
                    $sql = "SELECT bdiv.*, sum(case when bbs_div is NULL then 0 else 1 end) as  div_bbs_cnt , case when div_depth = 1 then div_ix  else parent_div_ix end as div_order
							FROM " . TBL_BBS_MANAGE_DIV . " bdiv left join bbs_" . $this->bbs_config->dt['board_ename'] . " bbs on bdiv.div_ix = bbs.bbs_div
							where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "' and div_depth = 2 and parent_div_ix = '$bbs_div' AND bdiv.disp = 1
							group by div_ix
							order by view_order asc, div_depth asc,div_ix asc";

                    $mdb->query($sql);

                    $sub_bbs_divs = $mdb->fetchall();
                    $tpl->assign('sub_bbs_divs', $sub_bbs_divs);
                }
            }
            
            
            
        // 그 외 게시판 
        } else {
            
            
            $sql = "SELECT bdiv.*, sum(case when bbs_div is NULL then 0 else 1 end) as  div_bbs_cnt , case when div_depth = 1 then div_ix  else parent_div_ix end as div_order
					FROM " . TBL_BBS_MANAGE_DIV . " bdiv left join bbs_" . $this->bbs_config->dt['board_ename'] . " bbs on bdiv.div_ix = bbs.bbs_div
					where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "' and div_depth = 1 and bdiv.disp = 1
					group by div_ix
					order by view_order asc, div_depth asc";
            $mdb->query($sql);

            $bbs_divs = $mdb->fetchall();

            $tpl->assign('bbs_divs', $bbs_divs);

            if ($bbs_div) {
                $sql = "SELECT bdiv.*, sum(case when bbs_div is NULL then 0 else 1 end) as  div_bbs_cnt , case when div_depth = 1 then div_ix  else parent_div_ix end as div_order
					FROM " . TBL_BBS_MANAGE_DIV . " bdiv left join bbs_" . $this->bbs_config->dt['board_ename'] . " bbs on bdiv.div_ix = bbs.bbs_div
					where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "' and div_depth = 2 and parent_div_ix = '$bbs_div' AND bdiv.disp = 1
					group by div_ix
					order by view_order asc, div_depth asc,div_ix asc";
                $mdb->query($sql);

                $sub_bbs_divs = $mdb->fetchall();
                $tpl->assign('sub_bbs_divs', $sub_bbs_divs);
            }
        }




        
         // 문의 카운팅 추가
        if ($board == 'qna') {
            $complete_cnt = 0;
            $in_progress_cnt = 0;
            if (!empty($loop)) {
                foreach ($loop as $lp):
                    switch ($lp['status']) {
                        case '1':
                        case '2':
                        case '3':
                            $in_progress_cnt++;
                            break;
                        case '5':
                            $complete_cnt++;
                            break;
                    }
                endforeach;
            }
            $tpl->assign('in_progress_cnt', $in_progress_cnt);
            $tpl->assign('complete_cnt', $complete_cnt);
        }

        $tpl->assign('page', $page);
        $tpl->assign('start', $start);
        $tpl->assign($this->bbs_config->dt);
        $tpl->assign('template_dir', $tpl->template_dir);
        $tpl->assign('templet_src', $this->site_template_src);
        $tpl->assign('bbs_table_name', $this->bbs_table_name);
        $tpl->assign('bbs_data_dir', $this->bbs_data_dir . "/" . $this->bbs_table_name);
        $tpl->assign('bbs_file_dir', $this->bbs_file_dir . "/" . $this->bbs_table_name);
        $tpl->assign('bbs_admin_mode', $this->bbs_admin_mode);
        $tpl->assign('total', $total);
        $tpl->assign('bbs_div', $bbs_div);
        $tpl->assign('board', $board);
        $tpl->assign('product_src', $this->site_product_src);
        $tpl->assign('bbs_after_admin_confirm', $this->bbs_after_admin_confirm);


        $query_string = str_replace("nset=" . ($_GET["nset"] ?? '') . "&", "", $QUERY_STRING);
        $query_string = str_replace("page=" . ($_GET["page"] ?? '') . "&", "", $query_string);


        $tpl->assign('paging_str', $this->bbs_page_bar($total, $page, $max, $HTTP_URL, $tpl->template_dir, "&" . $query_string));
        $tpl->assign('paging_str2', $this->bbs_page_bar2($total, $page, $max, $HTTP_URL, $tpl->template_dir, "&" . $query_string));
        $tpl->assign('page_mobile_string', $this->bbs_page_bar_mobile($total, $page, $max, $HTTP_URL, $tpl->template_dir, "&" . $query_string));
        $tpl->assign('token', $this->getToken());

        $bbs_ix = gVal('bbs_ix');
        if (is_dir($this->bbs_data_dir . "/" . $this->bbs_table_name . "/" . $bbs_ix) && !is_dir($this->bbs_data_dir . "/" . $this->bbs_table_name . "/" . $bbs_ix . "/" . ($mdb->dt['bbs_file_1'] ?? ''))) {//faq 게시판처럼 bbs_file_1 컬럼이 없는 게시판은 오류 발생해서 검사함 kbk 12/01/27
            $bbs_file_1_image_info = getimagesize($this->bbs_data_dir . "/" . $this->bbs_table_name . "/" . $bbs_ix . "/" . ($mdb->dt['bbs_file_1'] ?? ''));
            $bbs_file_1_image_type = strtolower(substr($bbs_file_1_image_info['mime'], strpos($bbs_file_1_image_info['mime'], "/") + 1, strlen($bbs_file_1_image_info['mime'])));

            $tpl->assign('bbs_file_1_image_info', $bbs_file_1_image_info);
        }

        if ($this->bbs_config->dt['board_qna_yn'] == "Y") {
            $sql = "SELECT bms.status_ix , bms.status_name FROM " . TBL_BBS_MANAGE_STATUS . " bms
					where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "'
					order by view_order asc";

            $mdb->query($sql);
            $bbs_status = $mdb->fetchall('object');
            for ($i = 0; $i < count($bbs_status); $i++) {
                $status_info[$bbs_status[$i]['status_ix']] = $bbs_status[$i]['status_name'];
            }
            $tpl->assign('bbs_status', $bbs_status); // kbk 12/10/08
        }

        if ($pid) {
            $sql = "select * from shop_order o , shop_order_detail od
				where o.oid=od.oid and o.uid = '" . $user["code"] . "'
				and od.pid = '$pid'
				and od.status NOT IN ('" . ORDER_STATUS_SETTLE_READY . "','" . ORDER_STATUS_INCOM_READY . "','" . ORDER_STATUS_INCOM_COMPLETE . "','" . ORDER_STATUS_DELIVERY_READY . "','" . ORDER_STATUS_DELIVERY_ING . "','" . ORDER_STATUS_CANCEL_APPLY . "','" . ORDER_STATUS_CANCEL_COMPLETE . "') ";
            $mdb->query($sql);
            if (!$mdb->total) {
                $order_yn = "N";
            } else {
                $order_yn = "Y";
            }
            $tpl->assign('order_yn', $order_yn);

            $sql = "SELECT bbs_ix FROM bbs_premium_after WHERE mem_ix='" . $_SESSION["user"]["code"] . "' AND bbs_etc1='" . $pid . "' ";
            $mdb->query($sql);
            if ($mdb->total){
                $write_yn = "Y";
            }else{
                $write_yn = "N";
            }
            $tpl->assign('write_yn', $write_yn);
        }

        //[Start] 게시판 분류 불러옴 kbk 13/07/14
        $sql = "SELECT * FROM " . TBL_BBS_MANAGE_DIV . " where bm_ix ='" . $this->bbs_config->dt['bm_ix'] . "' AND div_depth='1' AND disp='1' ORDER BY view_order ASC ";
        $mdb->query($sql);
        $fetch_bbs_div = $mdb->fetchall();
        $tpl->assign('fetch_bbs_div', $fetch_bbs_div);

        if ($bbs_div) {
            $sql = "SELECT * FROM " . TBL_BBS_MANAGE_DIV . " where bm_ix ='" . $this->bbs_config->dt['bm_ix'] . "' AND div_depth='2' AND parent_div_ix = '" . $bbs_div . "' AND disp='1' ORDER BY view_order ASC ";
            $mdb->query($sql);
            $fetch_sub_bbs_div = $mdb->fetchall();
            $tpl->assign('fetch_sub_bbs_div', $fetch_sub_bbs_div);
        }

        return $tpl->fetch('bbs_list');
    }

    
    
    
    
    function PrintMsBoardRead($article_no, $bbs_ix, $page, $comp = "")
    {
        global $user, $board, $admininfo;
        global $status_info;
        $mdb = new Database();
        $cdb = new Database();
        $ndb = new Database();

        //게시물 정보를 읽어온다.
        $mdb->query(" update " . $this->bbs_table_name . " set bbs_hit = bbs_hit+1 where bbs_ix = '$bbs_ix' ");

        if (($this->bbs_config->dt['board_ename'] == "after" || $this->bbs_config->dt['board_ename'] == "premium_after")) {
            $valuation_str = "
                , round((valuation_goods+valuation_goods_info + valuation_delivery + valuation_package)/4*20) AS uf_valuation
                , round(IFNULL((valuation_goods+valuation_goods_info + valuation_delivery + valuation_package)/4,0)) AS valuation";
        }

        $valuation_str = gVal('valuation_str');
        if ($this->bbs_config->dt['board_category_use_yn'] == "Y") {
            $sql = "
                SELECT CASE WHEN bsdiv.div_name != '' THEN concat(bdiv.div_name,' > ',bsdiv.div_name) ELSE bdiv.div_name END as div_name, 
                        bbs_name as writer, 
                        bbs.*,
                        CONCAT(SUBSTR(bbs_name,1,1),'*',SUBSTR(bbs_name,3)) AS bbs_name, 
                        CASE WHEN bbs.regdate > DATE_SUB(now(), interval " . $this->bbs_config->dt['design_new_priod'] . " HOUR) THEN 1 ELSE 0 END as new 
                            " . $valuation_str . "
				FROM " . $this->bbs_table_name . " bbs 
                    LEFT JOIN " . TBL_BBS_MANAGE_DIV . " bdiv 
                        ON bdiv.div_ix = bbs.bbs_div 
                        AND bdiv.bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "'
				LEFT JOIN " . TBL_BBS_MANAGE_DIV . " bsdiv 
                    ON bsdiv.div_ix = bbs.sub_bbs_div 
                    AND bsdiv.bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "'
				WHERE bbs_ix = '$bbs_ix' ";
        } else {
            $sql = "SELECT *, CONCAT(SUBSTR(bbs_name,1,1),'*',SUBSTR(bbs_name,3)) AS bbs_name " . $valuation_str . " FROM " . $this->bbs_table_name . " WHERE bbs_ix = '$bbs_ix' ";
        }

        $mdb->query($sql);

        
        //게시글 정보를 못 불러올 경우 kbk 12/01/17
        //해당 게시물은 삭제되었거나 존재하지 않습니다
        if (!$mdb->total) {
            echo "<script type='text/javascript'>alert('" . getLanguageText('05627754a73eb8899688e03c69e9c28f') . ".');location.href='?board=" . $board . "';</script>";
            exit;
        }

        if ($this->bbs_template_name == "") {
            $this->bbs_template_name = "bbs_read.htm";
        }

        $mdb->fetch();
        $this->BoardAuth($_GET["mode"], $mdb->dt['mem_ix'], $mdb->dt['bbs_hidden'], $mdb->dt['bbs_pass']);
        $tpl = new Template_;
        $tpl->template_dir = $this->bbs_template_dir;
        $tpl->compile_dir = $this->bbs_compile_dir;
        $tpl->define(array('bbs_read' => $this->bbs_template_name, 'bbs_title' => 'bbs_title.htm'));
        $tpl->assign($mdb->dt);
        $tpl->assign($this->bbs_config->dt);
        $tpl->assign('page', $page);
        $tpl->assign('article_no', $article_no);
        $tpl->assign('bbs_table_name', $this->bbs_table_name);
        $tpl->assign('bbs_admin_mode', $this->bbs_admin_mode);
        $tpl->assign('bbs_after_admin_confirm', $this->bbs_after_admin_confirm);
        $tpl->assign('token', $this->getToken());

        if ($mdb->dt['bbs_file_1']) {
            if (file_exists($this->bbs_data_dir . "/" . $this->bbs_table_name . "/" . $bbs_ix . "/" . $mdb->dt['bbs_file_1'])) {
                $bbs_file_1_image_info = getimagesize($this->bbs_data_dir . "/" . $this->bbs_table_name . "/" . $bbs_ix . "/" . $mdb->dt['bbs_file_1']);
                $bbs_file_1_image_type = strtolower(substr($bbs_file_1_image_info['mime'], strpos($bbs_file_1_image_info['mime'], "/") + 1, strlen($bbs_file_1_image_info['mime'])));
            }
        }

        
        $bbs_file_1_image_info = $bbs_file_1_image_info ?? '';
        $tpl->assign('bbs_file_1_image_info', $bbs_file_1_image_info);

        $where = '';
        if ($this->bbs_config->dt['board_qna_yn'] == "Y") {
            
            if ($this->bbs_admin_mode) {
                $where .= " and mem_ix = '" . sess_val("admininfo", 'charger_ix') . "'";
            } else {
                if (sess_val("admininfo", 'company_id') && sess_val("admininfo", 'use_work') == 1) {
                    $where .= " and bbs_etc5 = '" . sess_val("admininfo", 'company_id') . "' ";
                } else {

                    if ($mdb->dt['mem_ix'] != $user['code']) {
                        echo "<script type='text/javascript'>alert('" . getLanguageText('f1b03ab7611f445635e33b914dd412e4') . ".');history.back();</script>";
                        exit;
                    }

                    $where .= " and mem_ix = '{$user['code']}' ";
                }
            }
            
        } else {
            
            if (sess_val("admininfo", 'company_id') && sess_val("admininfo", 'use_work') == 1) {
                $where .= " and bbs_etc5 = '" . sess_Val("admininfo", 'company_id') . "' ";
            }
        }

        //일반후기와 프리미엄후기의 경우 마이페이지에서만 자신의 글 볼 수 있음 kbk 13/07/08
        if (($this->bbs_config->dt['board_ename'] == "after" || $this->bbs_config->dt['board_ename'] == "premium_after") && substr_count($_SERVER["PHP_SELF"], "/mypage/") > 0) {
            $where .= " and mem_ix = '$user[code]' ";
        }



        //, bbs_rec_cnt 추가 kbk 13/07/08
        $ndb->query("Select bbs_pass,mem_ix,bbs_ix,CONCAT(SUBSTR(bbs_name,1,1),'*',SUBSTR(bbs_name,3)) AS bbs_name,bbs_name as writer,bbs_subject, bbs_hidden, bbs_re_cnt, bbs_hit, regdate,
			concat('?mode=read&board=" . $this->bbs_config->dt['board_ename'] . "&bbs_ix=',bbs_ix,'&page=','" . $page . "') as link ,
			case when regdate > DATE_SUB(now(), interval " . $this->bbs_config->dt['design_new_priod'] . " HOUR) then 1 else 0 end as new,bbs_etc1,bbs_etc2, bbs_rec_cnt " . $valuation_str . "
			from " . $this->bbs_table_name . " where  bbs_ix < '$bbs_ix'  and bbs_ix_level = 0 $where order by bbs_ix desc LIMIT 1 ");

        $before_loop = $ndb->fetchall();
        $test = $ndb->total;
        $tpl->assign('test', $this->bbs_table_name);
        $tpl->assign('test', $this->bbs_table_name);
        $tpl->assign('test2', $this->bbs_config->dt['board_ename']); //weaning
        $tpl->assign('before_loop', $before_loop);


        $ndb->query("
            SELECT bbs_pass,
            mem_ix,
            bbs_ix,
            CONCAT(SUBSTR(bbs_name,1,1),'*',SUBSTR(bbs_name,3)) AS bbs_name,
            bbs_name as writer, 
            bbs_subject, 
            bbs_hidden, 
            bbs_re_cnt, 
            bbs_hit, 
            regdate,
			concat('?mode=read&board=" . $this->bbs_config->dt['board_ename'] . "&bbs_ix=',bbs_ix,'&page=','" . $page . "') AS link ,
			case when regdate > DATE_SUB(now(), interval " . $this->bbs_config->dt['design_new_priod'] . " HOUR) then 1 else 0 end as new,
                bbs_etc1,
                bbs_etc2, 
                bbs_rec_cnt " . $valuation_str . "
			from " . $this->bbs_table_name . " where bbs_ix > '$bbs_ix'  and bbs_ix_level = 0 $where order by bbs_ix asc LIMIT 1 ");
        $next_loop = $ndb->fetchall();
        $tpl->assign('next_loop', $next_loop);

        $cdb->query("Select * from " . $this->bbs_table_name . "_comment where  bbs_ix = '$bbs_ix' order by regdate asc ");
        $cmt_loop = $cdb->fetchall();
        $tpl->assign('cmt_loop', $cmt_loop);
        $tpl->assign('board_file_yn', $this->bbs_config->dt['board_file_yn']);
        $tpl->assign('template_dir', $tpl->template_dir);
        $tpl->assign('templet_src', $this->site_template_src);
        $tpl->assign('bbs_data_dir', $this->bbs_data_dir . "/" . $this->bbs_table_name . "/" . $bbs_ix);
        $tpl->assign('bbs_file_dir', $this->bbs_file_dir . "/" . $this->bbs_table_name);
        $tpl->assign('bbs_templet_dir', $this->bbs_config->dt['bbs_templet_dir']);
        $tpl->assign('board', $board);
        $tpl->assign('product_src', $this->site_product_src);
        
        if ($this->bbs_config->dt['board_qna_yn'] == "Y") {
            $sql = "SELECT bms.status_ix , bms.status_name FROM " . TBL_BBS_MANAGE_STATUS . " bms
					where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "'
					order by view_order asc";

            $mdb->query($sql);

            $bbs_status = $mdb->fetchall('object');
            for ($i = 0; $i < count($bbs_status); $i++) {
                $status_info[$bbs_status[$i]['status_ix']] = $bbs_status[$i]['status_name'];
            }
        }

        if ($this->bbs_config->dt['board_qna_yn'] == "Y") {
            $sql = "SELECT bms.* FROM " . TBL_BBS_MANAGE_STATUS . " bms
					where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "'
					order by view_order asc";

            $mdb->query($sql);

            $bbs_status = $mdb->fetchall('object');
            //print_r($bbs_status);
            $tpl->assign('bbs_status', $bbs_status);
        }

        return $tpl->fetch('bbs_read');
        exit;
    }

    
    
    
    
    function PrintMsBoardModify($bbs_ix, $article_no, $page, $bbs_div = "")
    {
        global $bbs_pass, $user, $board;

        if ($this->bbs_template_name == "") {
            if ($this->bbs_config->dt['board_style'] == "bbs") {
                $this->bbs_template_name = "bbs_modify.htm";
            } else if ($this->bbs_config->dt['board_style'] == "faq") {
                $this->bbs_template_name = "faq_modify.htm";
            }
        }



        $mdb = new Database();
        if ($this->bbs_config->dt['board_style'] == "bbs") {
            if ($user || $this->bbs_admin_mode) {
                $mdb->query("Select * from " . $this->bbs_table_name . " where bbs_ix = '$bbs_ix' ");
            } else {
                $mdb->query("Select * from " . $this->bbs_table_name . " where bbs_ix = '$bbs_ix' and bbs_pass ='$bbs_pass'");
            }
        } else if ($this->bbs_config->dt['board_style'] == "faq") {
            $mdb->query("Select * from " . $this->bbs_table_name . " where bbs_ix = '$bbs_ix' ");
        }
        if (!$mdb->total) {//게시글 정보를 못 불러올 경우 kbk 12/01/17
            echo "<script type='text/javascript'>alert('" . getLanguageText('05627754a73eb8899688e03c69e9c28f') . ".');location.href='?board=" . $board . "';</script>";
            exit;
        }
        $mdb->fetch();
        if (!$bbs_div) {
            $bbs_div = $mdb->dt["bbs_div"]; // 서브 카테고리를 가져오기 위해 추가 kbk
        }

        $this->BoardAuth($_GET["mode"], $mdb->dt['mem_ix'], "", $mdb->dt['bbs_pass']);

        $tpl = new Template_;
        $tpl->template_dir = $this->bbs_template_dir;
        $tpl->compile_dir = $this->bbs_compile_dir;
        $tpl->define(array('bbs_modify' => $this->bbs_template_name, 'bbs_title' => 'bbs_title.htm'));
        $tpl->assign($mdb->dt);
        $tpl->assign($this->bbs_config->dt);
        $tpl->assign('page', $page);
        $tpl->assign('article_no', $article_no);
        $tpl->assign('bbs_table_name', $this->bbs_table_name);
        $tpl->assign('bbs_admin_mode', $this->bbs_admin_mode);
        $tpl->assign('board_file_yn', $this->bbs_config->dt['board_file_yn']);
        $tpl->assign('board_hidden_yn', $this->bbs_config->dt['board_hidden_yn']);
        $tpl->assign('templet_src', $this->site_template_src);
        $tpl->assign('template_dir', $tpl->template_dir);
        $tpl->assign('bbs_data_dir', $this->bbs_data_dir . "/" . $this->bbs_table_name);
        $tpl->assign('edit_data_dir', $this->edit_data_dir . "/" . $this->bbs_table_name);
        $tpl->assign('bbs_file_dir', $this->bbs_file_dir . "/" . $this->bbs_table_name);
        $tpl->assign('bbs_templet_dir', $this->bbs_config->dt['bbs_templet_dir']);
        $tpl->assign('product_src', $this->site_product_src);
        $tpl->assign('bbs_after_admin_confirm', $this->bbs_after_admin_confirm);


        if ($this->bbs_config->dt['board_qna_yn'] == "Y") {
            $sql = "SELECT bms.* FROM " . TBL_BBS_MANAGE_STATUS . " bms
					where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "'
					order by view_order asc";

            $mdb->query($sql);

            $bbs_status = $mdb->fetchall('object');
            $tpl->assign('bbs_status', $bbs_status);
        }

        if ($this->bbs_config->dt['board_category_use_yn'] == "Y") {

            $sql = "SELECT bdiv.*, sum(case when bbs_div is NULL then 0 else 1 end) as  div_bbs_cnt , case when div_depth = 1 then div_ix  else parent_div_ix end as div_order
					FROM " . TBL_BBS_MANAGE_DIV . " bdiv left join bbs_" . $this->bbs_config->dt['board_ename'] . " bbs on bdiv.div_ix = bbs.bbs_div
					where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "' and div_depth = 1 AND bdiv.disp = 1
					group by div_ix
					order by view_order asc, div_depth asc";

            $mdb->query($sql);

            $bbs_divs = $mdb->fetchall();
            $tpl->assign('bbs_divs', $bbs_divs);

            if ($bbs_div) {
                $sql = "SELECT bdiv.*, sum(case when bbs_div is NULL then 0 else 1 end) as  div_bbs_cnt , case when div_depth = 1 then div_ix  else parent_div_ix end as div_order
						FROM " . TBL_BBS_MANAGE_DIV . " bdiv left join bbs_" . $this->bbs_config->dt['board_ename'] . " bbs on bdiv.div_ix = bbs.bbs_div
						where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "' and div_depth = 2 and parent_div_ix = '$bbs_div' AND bdiv.disp = 1
						group by div_ix
						order by view_order asc, div_depth asc,div_ix asc";
                $mdb->query($sql);
                //echo $sql;
                $sub_bbs_divs = $mdb->fetchall();
                $tpl->assign('sub_bbs_divs', $sub_bbs_divs);
            }
        }

        return $tpl->fetch('bbs_modify');
        exit;
    }

    function PrintMsBoardWrite($comp = "")
    {

        $this->BoardAuth($_GET["mode"]);

        if ($this->bbs_template_name == "") {
            if ($this->bbs_config->dt['board_style'] == "bbs") {
                $this->bbs_template_name = "bbs_write.htm";
            } else if ($this->bbs_config->dt['board_style'] == "faq") {
                $this->bbs_template_name = "faq_write.htm";
            }
        }
        $mdb = new Database();

        $tpl = new Template_;
        $tpl->template_dir = $this->bbs_template_dir;
        $tpl->compile_dir = $this->bbs_compile_dir;
        $tpl->define(array('bbs_write' => $this->bbs_template_name, 'bbs_title' => 'bbs_title.htm'));
        $tpl->assign($this->bbs_config->dt);
        $tpl->assign('board_file_yn', $this->bbs_config->dt['board_file_yn']);
        $tpl->assign('board_hidden_yn', $this->bbs_config->dt['board_hidden_yn']);
        $tpl->assign('board_user_write_auth_yn', $this->bbs_config->dt['board_user_write_auth_yn']);
        $tpl->assign('board_write_auth', $this->bbs_config->dt['board_write_auth']);
        $tpl->assign('bbs_templet_dir', $this->bbs_config->dt['bbs_templet_dir']);
        $tpl->assign('bbs_admin_mode', $this->bbs_admin_mode);
        $tpl->assign('bbs_table_name', $this->bbs_table_name);
        $tpl->assign('templet_src', $this->site_template_src);
        $tpl->assign('template_dir', $tpl->template_dir);
        $tpl->assign('bbs_data_dir', $this->bbs_data_dir . "/" . $this->bbs_table_name);
        $tpl->assign('edit_data_dir', $this->edit_data_dir . "/" . $this->bbs_table_name);
        $tpl->assign('bbs_file_dir', $this->bbs_file_dir . "/" . $this->bbs_table_name);
        $tpl->assign('product_src', $this->site_product_src);
        $tpl->assign('bbs_after_admin_confirm', $this->bbs_after_admin_confirm);

        $tpl->assign('token', $this->getToken());
        if ($this->bbs_config->dt['board_qna_yn'] == "Y") {
            $sql = "SELECT bms.* FROM " . TBL_BBS_MANAGE_STATUS . " bms
					where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "'
					order by view_order asc";

            $mdb->query($sql);

            $bbs_status = $mdb->fetchall('object');
            $tpl->assign('bbs_status', $bbs_status);
        }
        if ($this->bbs_config->dt['board_category_use_yn'] == "Y") {

            $sql = "SELECT bdiv.*, sum(case when bbs_div is NULL then 0 else 1 end) as  div_bbs_cnt , case when div_depth = 1 then div_ix  else parent_div_ix end as div_order
						FROM " . TBL_BBS_MANAGE_DIV . " bdiv left join bbs_" . $this->bbs_config->dt['board_ename'] . " bbs on bdiv.div_ix = bbs.bbs_div
						where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "' and div_depth = 1 AND bdiv.disp = 1
						group by div_ix
						order by view_order asc, div_depth asc";
            $mdb->query($sql);

            $bbs_divs = $mdb->fetchall();
            $tpl->assign('bbs_divs', $bbs_divs);

            $bbs_div = gVal('bbs_div');
            if ($bbs_div) {
                $sql = "SELECT bdiv.*, sum(case when bbs_div is NULL then 0 else 1 end) as  div_bbs_cnt , case when div_depth = 1 then div_ix  else parent_div_ix end as div_order
					FROM " . TBL_BBS_MANAGE_DIV . " bdiv left join bbs_" . $this->bbs_config->dt['board_ename'] . " bbs on bdiv.div_ix = bbs.bbs_div
					where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "' and div_depth = 1 and parent_div_ix = '$bbs_div' AND bdiv.disp = 1
					group by div_ix
					order by view_order asc, div_depth asc,div_ix asc";
                $mdb->query($sql);

                $sub_bbs_divs = $mdb->fetchall();
                $tpl->assign('sub_bbs_divs', $sub_bbs_divs);
            }
        }


        return $tpl->fetch('bbs_write');
        exit;
    }

    function PrintMsBoardResponse($bbs_ix, $article_no, $page)
    {
        global $board;
        $this->BoardAuth($_GET["mode"]);

        $mdb = new Database();

        if ($this->bbs_template_name == "") {
            if ($this->bbs_config->dt['board_style'] == "bbs") {
                $this->bbs_template_name = "bbs_response.htm";
            } else if ($this->bbs_config->dt['board_style'] == "faq") {
                $this->bbs_template_name = "faq_response.htm";
            }
        }

        $sql = "Select * , case when regdate > DATE_SUB(now(), interval " . $this->bbs_config->dt['design_new_priod'] . " HOUR) then 1 else 0 end as new  from " . $this->bbs_table_name . " where bbs_ix = '$bbs_ix' ";
        $mdb->query($sql);

        if (!$mdb->total) {//게시글 정보를 못 불러올 경우 kbk 12/01/17
            echo "<script type='text/javascript'>alert('" . getLanguageText('05627754a73eb8899688e03c69e9c28f') . ".');location.href='?board=" . $board . "';</script>";
            exit;
        }

        $tpl = new Template_;
        $tpl->template_dir = $this->bbs_template_dir;
        $tpl->compile_dir = $this->bbs_compile_dir;
        $tpl->assign('bbs_admin_mode', $this->bbs_admin_mode);
        $tpl->define(array('bbs_response' => $this->bbs_template_name, 'bbs_title' => 'bbs_title.htm'));
        if ($mdb->total) {
            $mdb->fetch(0);
            $tpl->assign($mdb->dt);
        }
        $tpl->assign($this->bbs_config->dt);
        $tpl->assign('board_file_yn', $this->bbs_config->dt['board_file_yn']);
        $tpl->assign('board_hidden_yn', $this->bbs_config->dt['board_hidden_yn']);
        $tpl->assign('bbs_table_name', $this->bbs_table_name);
        $tpl->assign('templet_src', $this->site_template_src);
        $tpl->assign('template_dir', $tpl->template_dir);
        $tpl->assign('bbs_data_dir', $this->bbs_data_dir . "/" . $this->bbs_table_name);
        $tpl->assign('edit_data_dir', $this->edit_data_dir . "/" . $this->bbs_table_name);
        $tpl->assign('bbs_file_dir', $this->bbs_file_dir . "/" . $this->bbs_table_name);
        $tpl->assign('bbs_templet_dir', $this->bbs_config->dt['bbs_templet_dir']);
        $tpl->assign('product_src', $this->site_product_src);

        $tpl->assign('token', $this->getToken());

        if ($this->bbs_config->dt['board_category_use_yn'] == "Y") {
            $sql = "SELECT bms.* FROM " . TBL_BBS_MANAGE_STATUS . " bms
					where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "'
					order by view_order asc";

            $mdb->query($sql);

            $bbs_divs = $mdb->fetchall();
            $tpl->assign('bbs_status', $bbs_status);
        }
        if ($this->bbs_config->dt['board_category_use_yn'] == "Y") {

            $sql = "SELECT bdiv.*, sum(case when bbs_div is NULL then 0 else 1 end) as  div_bbs_cnt , case when div_depth = 1 then div_ix  else parent_div_ix end as div_order
					FROM " . TBL_BBS_MANAGE_DIV . " bdiv left join bbs_" . $this->bbs_config->dt['board_ename'] . " bbs on bdiv.div_ix = bbs.bbs_div
					where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "' and div_depth = 1 AND bdiv.disp = 1
					group by div_ix
					order by view_order asc, div_depth asc";
            $mdb->query($sql);

            $bbs_divs = $mdb->fetchall();
            $tpl->assign('bbs_divs', $bbs_divs);

            if ($bbs_div) {
                $sql = "SELECT bdiv.*, sum(case when bbs_div is NULL then 0 else 1 end) as  div_bbs_cnt , case when div_depth = 1 then div_ix  else parent_div_ix end as div_order
						FROM " . TBL_BBS_MANAGE_DIV . " bdiv left join bbs_" . $this->bbs_config->dt['board_ename'] . " bbs on bdiv.div_ix = bbs.bbs_div
						where bm_ix = '" . $this->bbs_config->dt['bm_ix'] . "' and div_depth = 1 and parent_div_ix = '$bbs_div' AND bdiv.disp = 1
						group by div_ix
						order by view_order asc, div_depth asc,div_ix asc";
                $mdb->query($sql);

                $sub_bbs_divs = $mdb->fetchall();
                $tpl->assign('sub_bbs_divs', $sub_bbs_divs);
            }
        }

        return $tpl->fetch('bbs_response');
    }

    function bbs_page_bar($total, $page, $max, $bbs_list_url, $templet_path = "/bbs/bbs_templet/basic/", $add_query = "")
    {

        global $nset;
        global $HTTP_URL;
        global $_LANGUAGE;

        if (!$nset || $nset == "")
            $nset = 1; //kbk


        if ($total % $max > 0) {
            $total_page = floor($total / $max) + 1;
        } else {
            $total_page = floor($total / $max);
        }

        $total_nset = ceil($total_page / 10);

        $next = (($nset) + 1);
        $prev = (($nset) - 1);

        if ($total) {
            if ($this->bbs_admin_mode) {
                $first = "<a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . ($nset - 1) . "&page=1$add_query' " . $paging_type_target . "><img src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowleft01.png' border=0 align=absmiddle onmouseover=\"this.src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowleft01.png'\" onmouseout=\"this.src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowleft01.png'\" style='vertical-align:middle;' /></a>&nbsp;";
                $prev_mark_10 = ($nset > 1) ? "<a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . ($nset - 1) . "&page=" . (($nset - 2) * 10 + 1) . "$add_query' " . $paging_type_target . "><img src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowleft02.png' border=0 align=absmiddle onmouseover=\"this.src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowleft02.png'\" onmouseout=\"this.src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrow_prev.gif'\" style='vertical-align:middle;' /></a>&nbsp;" : "<img src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowleft02.png' border=0 align=absmiddle style='vertical-align:middle;'>&nbsp;";
                $next_mark_10 = ($nset < $total_nset) ? "&nbsp;<a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . ($nset + 1) . "&page=" . ($nset * 10 + 1) . "$add_query' " . $paging_type_target . "> <img src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowright02.png' border=0 align=absmiddle onmouseover=\"this.src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowright02.png'\" onmouseout=\"this.src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowright02.png'\" style='vertical-align:middle;' /></a>" : "&nbsp;<img src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowright02.png' border=0 align=absmiddle style='vertical-align:middle;'>";
                $last = " <a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . ($nset - 1) . "&page=" . $total_page . "$add_query' " . $paging_type_target . "><img src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowright01.png' border=0 align=absmiddle onmouseover=\"this.src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowright01.png'\" onmouseout=\"this.src='" . $templet_path . "/img/" . $_SESSION["admininfo"]["language"] . "/arrowright01.png'\" style='vertical-align:middle;' /></a>&nbsp;";
            } else {
                //버튼 텍스트
                $first = ($page == 1) ? "<button class='first-button disabled'></button> " : "<button class='first-button' onclick='location.href=" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . ($nset - 1) . "&page=1$add_query' " . $paging_type_target . "><em class='hidden'></em></button> ";
                $prev_mark_10 = ($nset > 1) ? "<a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . ($nset - 1) . "&page=" . (($nset - 2) * 10 + 1) . "$add_query' " . $paging_type_target . " class='prev-button'></a>" : "<button class='prev-button disabled'></button>";
                $next_mark_10 = ($nset < $total_nset) ? " <a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . ($nset + 1) . "&page=" . ($nset * 10 + 1) . "$add_query' " . $paging_type_target . " class='next-button'></a>" : "<button class='next-button disabled'></button>";
                $last = ($page == $total_page) ? " <button class='last-button disabled'></button>" : " <button class='last-button' onclick='location.href=" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . ($nset - 1) . "&page=" . $total_page . "$add_query' " . $paging_type_target . "><em class='hidden'></em></button> ";
            }
        }


        if ($page >= 1 && $page <= 10) {
            $nset = 1;
        } else if ($page >= 11 && $page <= 20) {
            $nset = 2;
        } else if ($page >= 21 && $page <= 30) {
            $nset = 3;
        } else if ($page >= 31 && $page <= 40) {
            $nset = 4;
        } else if ($page >= 41 && $page <= 50) {
            $nset = 5;
        } else if ($page >= 51 && $page <= 60) {
            $nset = 6;
        } else if ($page >= 61 && $page <= 70) {
            $nset = 7;
        } else if ($page >= 71 && $page <= 80) {
            $nset = 8;
        } else if ($page >= 81 && $page <= 90) {
            $nset = 9;
        } else if ($page >= 91 && $page <= 100) {
            $nset = 10;
        }

        $next = (($nset) + 1);
        $prev = (($nset) - 1);

        $prev_mark = gVal('prev_mark');
        $page_string = $prev_mark;

        for ($i = ($nset - 1) * 10 + 1; $i <= (($nset - 1) * 10 + 10); $i++) {
            if ($i > 0) {
                if ($i <= $total_page) {
                    if ($i != $page) {
                        $page_string .= '<a href="javascript:void(0);" onclick="location.href=\'' . $HTTP_URL . '?nset=' . $nset . '&page=' . $i . $add_query . '\';">' . $i . '</a>';
                    } else {
                        $page_string .= '<em class="on">' . $i . '</em>';
                    }
                }
            }
        }

        $next_mark = gVal('next_mark');
        $page_string = $page_string . $next_mark;

        $first = $first ?? '';
        $prev_mark_10 = $prev_mark_10 ?? '';
        $page_string = $page_string ?? '';
        $next_mark_10 = $next_mark_10 ?? '';
        $last = $last ?? '';
        $page_string = $first . $prev_mark_10 . $page_string . $next_mark_10 . $last;

        $page_string = "<div style='padding-bottom:1px;'>" . $page_string . "</div>";

        return $page_string;
    }

    function bbs_page_bar2($total, $page, $max, $bbs_list_url, $templet_path = "/bbs/bbs_templet/basic/", $add_query = "")
    {

        global $nset;
        global $HTTP_URL;

        if ($total % $max > 0) {
            $total_page = floor($total / $max) + 1;
        } else {
            $total_page = floor($total / $max);
        }

        if ($nset == "") {
            $nset = 1;
        }

        $next = (($nset) * 10 + 1);
        $prev = (($nset - 2) * 10 + 1);

        $paging_type = gVal('paging_type');
        if ($paging_type == "inner") {
            $paging_type_param = "view=innerview&";
            $paging_type_target = " target=act";
        } else {
            $paging_type_param = "";
            $paging_type_target = "";
        }


        $pre_mark = gVal('pre_mark');
        if ($total) {
            $prev_mark = ($page >= 2) ? " <a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . ($nset) . "&page=" . ($page - 1) . "$add_query' " . $paging_type_target . "><img src='/image/btn_pre' border=0 align=absmiddle></a> " : "";
            $pre_mark .= ($prev == -9) ? " <a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . ($nset - 1) . "&page=" . (($nset - 2) * 10 + 1) . "$add_query' " . $paging_type_target . "><img src='/image/btn_tenpre' border=0 align=absmiddle></a> " : "";
            $next_mark = ($total_page > 1) ? " <a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . ($nset) . "&page=" . ($nset + 1) . "$add_query' " . $paging_type_target . "><img src='/image/btn_next' border=0 align=absmiddle></a>" : "";
            $next_mark .= ($total_page > 10) ? " <a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . ($nset + 1) . "&page=" . ($nset * 10 + 1) . "$add_query' " . $paging_type_target . "><img src='/image/btn_tennext' border=0 align=absmiddle></a>" : "";
        }

        $prev_mark = $prev_mark ?? '';
        $page_string2 = $prev_mark;

        for ($i = ($nset - 1) * 10 + 1; $i <= (($nset - 1) * 10 + 10); $i++) {
            if ($i > 0) {
                if ($i <= $total_page) {

                    if ($i != $page) {
                        if ($i != (($nset - 1) * 10 + 1)) {
                            $page_string2 = $page_string2 . ("<font color='silver'>|</font> <a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=$nset&page=$i$add_query' style='font-weight:bold;color:gray' " . $paging_type_target . ">$i</a> ");
                        } else {
                            $page_string2 = $page_string2 . (" <a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=$nset&page=$i$add_query' style='font-weight:bold;color:gray' " . $paging_type_target . ">$i</a> ");
                        }
                    } else {

                        if ($i != (($nset - 1) * 10 + 1)) {
                            $page_string2 = $page_string2 . ("<font color='silver'>|</font> <font color=ff7635 style='font-weight:bold'>$i</font> ");
                        } else {
                            $page_string2 = $page_string2 . ("<font color=ff7635 style='font-weight:bold'>$i</font> ");
                        }
                    }
                }
            }
        }
        if ($nset < (floor($total_page / 10) + 1)) {
            $last_page_string = "<b style='color:gray'>...</b> <a href='" . $HTTP_URL . "?board=" . $this->bbs_config->dt['board_ename'] . "&" . $paging_type_param . "nset=" . (floor($total_page / 10) + 1) . "&page=$total_page$add_query' style='font-weight:bold;color:gray' " . $paging_type_target . ">$total_page</a> ";
        }
        $last_page_string = $last_page_string ?? '';
        $next_mark = $next_mark ?? '';
        $page_string2 = $page_string2 . $last_page_string . $next_mark;

        return $page_string2;
    }

    function bbs_page_bar_mobile($total, $page, $max, $bbs_list_url, $templet_path = "/bbs/bbs_templet/basic/", $add_query = "")
    {

        global $nset, $layout_config;
        global $HTTP_URL, $_LANGUAGE;

        $total_page = ceil($total / $max);
        $total_nset = ceil($total_page / 10);
        $next_nset = (($nset) * 10 + 1);
        $prev_nset = (($nset - 2) * 10 + 1);
        $nset = ceil($page / 10);
        $first_page = ($nset - 1) * 10;

        if ($nset >= $total_nset) {
            $last_page = $total_page;
        } else {
            $last_page = $nset * 10;
        }

        $prev_mark = $prev_mark ?? '';
        $page_string = $prev_mark;

        if ($max * $page > $total) {
            $curItem = $total;
        } else {
            $curItem = $max * $page;
        }

        $page_string .= "<div class='page_class'>";
        $page_string .= "<span>";
        $page_string .= getLanguageText('b5e087f6f0fdabdc4c163a3882ab6eb6') . "(<span class='paging_item'>" . $curItem . "</span>/<span class='paging_total'>" . $total . "</span>)";
        $page_string .= "</span>";
        $page_string .= '</div>';

        $next_mark = $next_mark ?? '';
        $page_string = $page_string . $next_mark;

        $prev_mark_10 = $prev_mark_10 ?? '';
        $next_mark_10 = $next_mark_10 ?? '';
        $page_string = $prev_mark_10 . $page_string . $next_mark_10;

        return $page_string;
    }

    
    
    function BoardAuth($mode, $mem_ix = "", $bbs_hidden = "", $bbs_pass = "")
    {
        if ($mode == 'list' || $mode == '') {
            if (!$this->bbs_admin_mode) {
                if ($this->bbs_config->dt['board_list_auth']) {
                    if (!sess_val("user") || $this->bbs_config->dt['board_list_auth'] < sess_val("user", "perm")) {
                        echo "<script>alert('" . getLanguageText('5589a6d7fcaa7a2e90a8273a49661147') . ".');location.href='/member/login.php?url=" . urlencode($_SERVER['REQUEST_URI']) . "';</script>";
                        exit;
                    }
                }
            }
        } else if ($mode == 'read') {
            if (!$this->bbs_admin_mode) {
                // 사용자권한중 읽기 권한이 전체가 아닐때
                if ($this->bbs_config->dt['board_read_auth']) {
                    if ((!sess_val("user") || $this->bbs_config->dt['board_read_auth'] < sess_val("user", "perm")) || sess_val("user", "code") != $mem_ix && $bbs_hidden == "1") {
                        echo "<script>alert('" . getLanguageText('f1b03ab7611f445635e33b914dd412e4') . ".');location.href='/member/login.php?url=" . urlencode($_SERVER['REQUEST_URI']) . "';</script>";
                        exit;
                    }
                }
            }
        } else if ($mode == 'modify') {

            //ISMS관련 수정(•	URL 에 표시 된 파라미터 중 mode 를 modify 로 조작하여 정상적으로는 수정이 불가한 1대1 문의 수정)
            //1:1 문의를 수정하여 CS 와 분쟁소지를 막기 위하여 관리자, 프론트 모두 수정 못하게 처리함!
            if ($this->bbs_config->dt['board_ename'] == 'qna') {
                echo "<script>alert('고객 1:1문의는 수정할수 없습니다.');history.back();</script>";
                exit;
            }

            if (!$this->bbs_admin_mode) {
                if ((sess_val("user", "code") != $mem_ix && sess_val("admininfo", "charger_ix") != $mem_ix && $mem_ix != "") || (gVal("bbs_pass") != $bbs_pass) || (empty(gVal("bbs_pass")) && sess_val("admininfo", "charger_ix") == "" && sess_val("user", "code") == "")) {
                    echo "<script>alert('" . getLanguageText('800e620fd86d72229b1e8fdbf73a6132') . ". ');history.back();</script>";
                    exit;
                }
            }
        } else if ($mode == 'comment_insert' || $mode == 'comment_delete') {
            if (!$this->bbs_admin_mode) {
                // 컴멘트 글쓰기 권한이 전체쓰기 가 아니면 권한체크
                if ($this->bbs_config->dt['board_comment_auth'] != "0" && $this->bbs_config->dt['board_comment_yn'] != "N") {
                    if (sess_val("user", "perm") == "" || $this->bbs_config->dt['board_comment_auth'] > sess_val("user", "perm")) {
                        echo "<script>alert('" . getLanguageText('0697f87ad3897f2247d0823a9cd6890d') . ".');history.back();</script>";
                        exit;
                    }
                }
            }
        } else if ($mode == 'write' || $mode == 'insert' || $mode == 'update' || $mode == 'delete' || $mode == 'response' || $mode == 'comment_insert' || $mode == 'comment_delete' || $mode == 'faq_insert' || $mode == 'faq_delete') {
            if (!$this->bbs_admin_mode) {
                if ($this->bbs_config->dt['board_write_auth'] != "0" || $this->bbs_config->dt['board_user_write_auth_yn'] != "Y") {
                    if (sess_val("user", "perm") == "" || $this->bbs_config->dt['board_write_auth'] < sess_val("user", "perm")) {
                        if ($mode == 'delete' || $mode == 'comment_delete' || $mode == 'faq_delete') {
                            echo "<script>alert('" . getLanguageText('1c0be3c42f0f1045a0aad6502a36106b') . ".');history.back();</script>";
                        } else {
                            echo "<script>alert('" . getLanguageText('0697f87ad3897f2247d0823a9cd6890d') . ".');history.back();</script>";
                        }
                        exit;
                    }
                }
            }
        }
    }

    function getToken()
    {
        $token = md5(uniqid(rand()));
        setcookie("C_TOKEN", $token, 0, "/", "");
        return $token;
    }
}
