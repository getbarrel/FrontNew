<?php

class ForbizMySQLi
{
    protected $dbms_type         = "mysql";
    protected $dbcon;  // 링크 식별자
    protected $db_host; // 디비 호스트
    protected $db_user; // 디비 사용자
    protected $db_pass; // 디비 비밀번호
    protected $db_name; // 디비 이름
    protected $db_port; // 디비 포트
    protected $result; // 쿼리 결과셋
    protected $dt;  // 결과 데이터
    protected $sql;
    protected $sequences;
    protected $debug;
    protected $debug_data        = array();
    protected $debug_remote_addr = array("221.151.188.10", "221.151.188.11", "127.0.0.1");
    protected $error_display;
    protected $sql_injection_result;
    protected $ase_encrypt_key   = "";
    protected $conn_name         = "";
    protected $db                = false;
    protected $framework         = false;
    protected $dbInfo            = [];
    public $total;  // 쿼리 결과수

    function __construct($_db_host = "", $_db_user = "", $_db_pass = "", $_db_name = "", $_db_port = "3306")
    {
        $dbConfigFile = CUSTOM_ROOT.'/config/database.php';

        if (file_exists($dbConfigFile)) {
            $this->dbInfo = require(CUSTOM_ROOT.'/config/database.php');

            $this->master_db_setting($_db_host, $_db_user, $_db_pass, $_db_name, $_db_port);
            $this->ase_encrypt_key = "2ad265d024a06e3039c3649213a834390412aa7097ea05eea4e0b44c88ecf7972ad265d024a06e3039c3649213a834390412aa7097ea05eea4e0b44c88ecf797";

            $this->error_display        = true;
            $this->sql_injection_result = true;
        } else {
            exit("DB Config file not found! [{$dbConfigFile}]");
        }
    }

    public function master_db_setting($_db_host = "", $_db_user = "", $_db_pass = "", $_db_name = "", $_db_port = "3306")
    {
        if ($_db_host && $_db_user && $_db_pass && $_db_name) {
            $this->conn_name = "master";

            $this->db_host = $_db_host;
            $this->db_user = $_db_user;
            $this->db_pass = $_db_pass;
            $this->db_name = $_db_name;
            $this->db_port = $_db_port;
        } else {
            $this->conn_name = "master";

            $this->db_host = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['host'];
            $this->db_user = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['user'];
            $this->db_pass = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['pass'];
            $this->db_name = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['name'];
            $this->db_port = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['port'];
        }
    }

    public function slave_db_setting()
    {
        $this->conn_name = "slave";

        if (!empty($this->dbInfo[DB_CONNECTION_DIV][$this->conn_name])) {
            $this->db_host = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['host'];
            $this->db_user = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['user'];
            $this->db_pass = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['pass'];
            $this->db_name = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['name'];
            $this->db_port = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['port'];
        } else {
            exit("No Slave DB Config!");
        }
    }

    function dbcon($db_name)
    {
        $this->dbcon = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name, $this->db_port) or $this->error();
        mysqli_query($this->dbcon, "set names utf8");
        mysqli_query($this->dbcon, "set lower_case_table_names = 1");
        mysqli_query($this->dbcon, "set session sql_mode='NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
        mysqli_select_db($this->dbcon, $this->db_name) or $this->error();
    }

    function close()
    {
        return mysqli_close($this->dbcon);
    }

    function query($sql, $writeLog = true)
    {
        global $admininfo;
        static $nIdx = 1;

        $this->sql = $sql;

        // query debug
        if ($writeLog && function_exists('log_message') && $sql && $GLOBALS['CFG']->item('log_threshold') > 1) {
            $backLog = debug_backtrace(0)[0];
            log_message('debug', 'oldDrv - '.$_SERVER['REQUEST_URI'].'('.$backLog['file'].':'.$backLog['line'].') - '.$sql);
            $nIdx++;
        }

        if ($this->debug) {
            $this->debug_data['debugsql'] = $sql;
        }

        if (($_SERVER["HTTP_HOST"] == "soho.mallstory.com" || $_SERVER["HTTP_HOST"] == "b2b.mallstory.com" || $_SERVER["HTTP_HOST"] == "sohosample.s2.mallstory.com"
            || $_SERVER["HTTP_HOST"] == "bizsample.s2.mallstory.com")) { //|| $_SERVER["HTTP_HOST"] == "biz.mallstory.com"
            if (substr_count($_SERVER["PHP_SELF"], "admin/")) {
                if (eregi('^DELETE', $sql) || eregi('^delete', $sql) || eregi('^UPDATE', $sql) || eregi('^update', $sql) || eregi('^INSERT', $sql) || eregi('^insert',
                        $sql) || eregi('^delete', $act) || eregi('^DELETE', $act) || eregi('^UPDATE', $act) || eregi('^update', $act) || eregi('^INSERT',
                        $act) || eregi('^insert', $act)) { //
                    if (strpos($sql, "insert into bbs_tmp") === false && strpos($sql, "insert into con_log") === false) {//체험판 로그인과 메인 접속을 위해 수정 kbk 12/12/04
                        echo "<script>alert('데모사이트는 입력/수정/삭제 권한이 없습니다.');if(parent.document.URL == document.URL){history.back();}else{parent.document.location.reload();}</script>";
                        exit;
                    }
                }
            } else {
                if (eregi('^DELETE', $sql)) { //
                    //echo "데모사이트는 삭제권한이 없습니다.";
                    //echo "<script>alert('데모사이트는 수정/삭제 권한이 없습니다.');if(parent.document.URL == document.URL){history.back();}else{parent.document.location.reload();}</script>";
                    //exit;
                }
            }
        }

        if (!isset($this->dbcon)) $this->dbcon($this->db_name);

        if ($this->debug) {
            $this->debug_data['time'] = time();
        }

        $this->result = mysqli_query($this->dbcon, $sql) or $this->error();

        if ($this->debug) {
            $this->debug_data['time'] -= time();
            print_r($this->debug_data);
        }

        /*
          if (eregi('^SELECT',$sql)) $this->total();
          if (eregi('^select',$sql)) $this->total();
          if (eregi('^DESC',$sql)) $this->total();
          if (eregi('^show',$sql)) $this->total();
         */
        if (preg_match('/^select|desc|show/i', $sql)) {
            $this->total();
        }
        return $this->result;
    }

    function fetch($rows = 0, $type = 'array', $result_type = MYSQLI_BOTH)
    {
        $fetch = "mysqli_fetch_$type";

        if ($this->total > 0 && is_object($this->result)) {
            if (mysqli_data_seek($this->result, $rows)) {
                if ($type == 'array') {
                    $this->dt = $fetch($this->result, $result_type);
                } else {
                    $this->dt = $fetch($this->result);
                }
            } else {
                $this->dt = "";
            }
        } else {
            $this->dt = "";
        }

        return $this->dt;
    }

    function fetchall($type = 'array', $result_type = MYSQLI_BOTH)
    {
        $i    = 0;
        $data = [];
        switch ($type) {
            case 'object' : // object는 결과타입 선택 불가라서 따로 분리함. 2013.10.23 bgh
                while ($row = mysqli_fetch_object($this->result)) {
                    $data [] = (array) $row;
                }
                break;
            default :
                $fetch = "mysqli_fetch_".$type;
                while ($row   = $fetch($this->result, $result_type)) {
                    if ($result_type == MYSQLI_BOTH) {
                        $array1  = array(
                            "idx_" => $i + 1
                        );
                        $marray  = array_merge($array1, (array) $row);
                        $data [] = $marray;

                        $i ++;
                    } else {
                        $data [] = $row;
                    }
                }
                break;
        }
        return $data;
    }

    function insert_id()
    {

        $id = mysqli_insert_id($this->dbcon);

        return $id;
    }

    function fetchall2($type = 'array')
    {
        $i     = 0;
        $fetch = "mysqli_fetch_$type";
        while ($row   = $fetch($this->result)) {
            //$marray = array_merge($array1, (array)$row);
            $data[] = (array) $row;

            //echo "user_id: ".$data[$i][0]."<br>\n";
            $i++;
        }
        //print_r($data);
        return $data;
    }

    function mysql_table_exists($table)
    {
        if (!isset($this->dbcon)) $this->dbcon($this->db_name);

        $exists = mysqli_query("SELECT 1 FROM $table LIMIT 0");
        if ($exists) return true;
        return false;
    }

    function table_exists($table)
    {
        if (!isset($this->dbcon)) $this->dbcon($this->db_name);

        $exists = mysqli_query("SELECT 1 FROM $table LIMIT 0");
        if ($exists) return true;
        return false;
    }

    function getrows()
    {
        $var = [];

        if (is_object($this->result)) {
            $i = 0;

            while ($row = mysqli_fetch_row($this->result)) {
                for ($loop = 0; $loop < count($row); $loop++) {  // 레코드값들으 배열에 저장
                    $var[$loop][$i] = $row[$loop];
                }
                $i++;
            }
        }
        return $var;
    }

    function total()
    {
        if (is_object($this->result)) {
            $this->total = mysqli_num_rows($this->result);
        } else {
            $this->total = 0;
        }
    }

    function error()
    {
        if ($this->dbcon) {
            $write = date('Y-m-d H:i:s')." ".$_SERVER["REQUEST_URI"]." ".$_SERVER['HTTP_REFERER']." \n ".addslashes(mysqli_error($this->dbcon))."\n".$this->sql."\n\n";
            $path  = $_SERVER["DOCUMENT_ROOT"]."/_logs/";

            if (!is_dir($path)) {
                mkdir($path, 0777);
                chmod($path, 0777);
            } else {
                //chmod($path,0777);
            }

            $fp = fopen($_SERVER["DOCUMENT_ROOT"].sess_val("layout_config", "mall_data_root")."/_logs/mysql_error.txt", "a+");
            fwrite($fp, $write);
            fclose($fp);

            //20130723 홍진영
            if (in_array($_SERVER["REMOTE_ADDR"], $this->debug_remote_addr)) {
                $error_msg = addslashes(mysqli_error($this->dbcon));
            }

            $errMsg[] = "<script type='text/javascript'>";
            $errMsg[] = "<!--";
            $errMsg[] = "if(window.name =='act' || window.name =='iframe_act'){";
            $errMsg[] = "alert('데이터베이스 처리중에 문제가 생겼습니다. 계속해서 문제가 발생할시 관리자에게 문의 바랍니다. ".( $error_msg != "" ? "에러 메세지 : [{$error_msg}]" : "")."');";
            $errMsg[] = "}";
            $errMsg[] = "//-->";
            $errMsg[] = "</script>";
            $errMsg[] = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
            $errMsg[] = '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">';
            $errMsg[] = '<head>';
            $errMsg[] = '<title> 요청하신 페이지를 찾을 수 없습니다.</title>';
            $errMsg[] = '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
            $errMsg[] = '<style type="text/css">';
            $errMsg[] = 'html, body, div, span, applet, object, iframe,';
            $errMsg[] = 'h1, h2, h3, h4, h5, h6, p, blockquote, pre,';
            $errMsg[] = 'a, abbr, acronym, address, big, cite, code,';
            $errMsg[] = 'del, dfn, em, img, ins, kbd, q, s, samp,';
            $errMsg[] = 'small, strike, strong, sub, sup, tt, var,';
            $errMsg[] = 'b, u, i, center,';
            $errMsg[] = 'dl, dt, dd, ol, ul, li,';
            $errMsg[] = 'fieldset, form, label, legend,input,button,textarea,select,option, ';
            $errMsg[] = 'table, caption, tbody, tfoot, thead, tr, th, td, article, aside, ';
            $errMsg[] = 'canvas, details, embed, figure, figcaption, footer, header, hgroup, ';
            $errMsg[] = 'menu, nav, output, ruby, section, summary, ';
            $errMsg[] = 'time, mark, audio, video { margin: 0; padding: 0; border: 0; }';
            $errMsg[] = 'h1,h2,h3,h4,h5,h6 { font-size:12px;text-align:left }';
            $errMsg[] = 'body,input,button,textarea,select,option { font-size:12px; font-family:"돋움", dotum,Helvetica,sans-serif; color:#383d41; }';
            $errMsg[] = 'a { color:#2f3743;text-decoration:none }';
            $errMsg[] = 'a:hover { color:#000;text-decoration:none }';
            $errMsg[] = 'article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section { display: block; }';
            $errMsg[] = 'body { line-height: 1; }';
            $errMsg[] = 'ol, ul { list-style: none; }';
            $errMsg[] = 'blockquote, q { quotes: none; }';
            $errMsg[] = 'blockquote:before, blockquote:after, q:before, q:after { content: none; }';
            $errMsg[] = 'table { border-collapse: collapse; border-spacing: 0; }';
            $errMsg[] = '.warp { width:516px; padding-top:150px; margin:0px auto; }';
            $errMsg[] = '</style>';
            $errMsg[] = '</head>';
            $errMsg[] = '<body>';
            $errMsg[] = '<div class="warp">';
            $errMsg[] = '<h1 style="padding-bottom:15px; border-bottom:1px solid #ddd; text-align:center;"><img src="/images/error/error_05.gif" alt="요청하신 페이지를 찾을 수 없습니다." title="서비스 이용에 불편을 드려 죄송합니다." /></h1>';
            $errMsg[] = '<div style="margin-top:18px; line-height:150%; color:#757575; padding-left:20px;">';
            $errMsg[] = '인터넷 통신 이상 등으로 인한 일시적인 오류일 수 있으나 페이지 새로고침을 해 보시고,<br />오류가 지속될 경우 고객센터로 문의해 주시기 바랍니다.';
            $errMsg[] = '</div>';
            $errMsg[] = '<div style="text-align:center; padding:20px 0; line-height:140%">';
            $errMsg[] = '<ul>';
            if (sess_val("shopcfg", "phone") != "") {
                $errMsg[] = '<li style="font-size:13px">사이트 운영사 : '.sess_val("shopcfg", "phone").'</li>';
            } else {
                $errMsg[] = '<li style="font-size:13px">사이트 구축사 : 1600-2028</li>';
            }
            $errMsg[] = '</ul>';
            $errMsg[] = '</div>';
            $errMsg[] = '<div style="background:#ededed; width:100%;">';
            $errMsg[] = '<div style="padding:15px 22px; line-height:140%;">';
            $errMsg[] = '<h3 style="color:#fb6921; padding-bottom:10px;">오류 알림 : '.date("Y.m.d H시i분s초").' : 웹페이지를 찾을 수 없습니다.</h3>';
            if (in_array($_SERVER["REMOTE_ADDR"], $this->debug_remote_addr)) {
                $errMsg[] = '<div style="color:black;">MYSQL 오류 : '.$_SERVER["SCRIPT_FILENAME"].'<br><br>'.addslashes(mysqli_errno($this->dbcon)).' '.addslashes(mysqli_error($this->dbcon)).'<br><br>'.$this->sql.'</div>';
            }
            $errMsg[] = '<div style="color:#757575;">해당 오류로 인하여 요청하신 페이지를 찾을 수 없습니다. 해당 문의는 고객센터를 통해 문의해 주시기 바랍니다.</div>';
            $errMsg[] = '</div>';
            $errMsg[] = '</div>';
            $errMsg[] = '<div align="center" style="padding-top:23px;">';
            $errMsg[] = '<span>';
            if (($_SERVER["HTTP_REFERER"] ?? '') != "") {
                $errMsg[] = '<a href="'.$_SERVER["HTTP_REFERER"].'">';
            } else {
                $errMsg[] = '<a href="/">';
            }
            $errMsg[] = '<img src=/images/error/error_butom_07.gif" alt="이전페이지"></a>';
            $errMsg[] = '</span>';
            $errMsg[] = '<span style="padding-left:16px;">';
            $errMsg[] = '<a href="/"><img src=/images/error/error_butom_09.gif" alt="메인페이지"></a>';
            $errMsg[] = '</span>';
            $errMsg[] = '</div>';
            $errMsg[] = '</div>';
            $errMsg[] = '</body>';
            $errMsg[] = '</html>';

            echo implode("\n", $errMsg);
        }

        exit;
    }

    function nocache()
    {
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
    }

    function include_all_once($pattern)
    {
        foreach (glob($pattern) as $file) { // remember the { and } are necessary!
            // include_once $file;
        }
    }

    function sqlFilter($param)
    {
        //$array_split_item[0] = "-";
        $block_chars = array("--", ";", "/*", "*/", "@@", "char", "nchar", "varchar", "nvarchar", "alter", "begin", "cast", "create", "cursor", "declare",
            "delete", "drop", "end", "exec", "execute", "fetch", "insert", "kill", "open", "select", "sys", "sysobjects", "syscolumns", "table", "update",
            "<script", "</script>", "'");

        for ($i = 0; $i < count($block_chars); $i++) {
            if (substr_count(" ".$param, $block_chars[$i])) {
                $this->sql_injection_result = false;
                $this->saveSqlInjectionLog("Check-".$block_chars[$i].": ".$param);

                exit;
            }
        }
        return $param;
    }

    function saveSqlInjectionLog($log_txt)
    {
        $write = date('Y-m-d H:i:s')." ".$this->sql."\t";
        $write = $write.$log_txt."\n";
        $path  = $_SERVER["DOCUMENT_ROOT"]."/_logs/";

        if (!is_dir($path)) {
            mkdir($path, 0777);
            chmod($path, 0777);
        } else {
            //chmod($path,0777);
        }


        $fp = fopen($_SERVER["DOCUMENT_ROOT"]."/_logs/sql_injection_log.txt", "a+");
        fwrite($fp, $write);
        fclose($fp);
    }

    /**
     * 쿼리 실행계획 보여주기
     *
     * 2011.02.21 추가 (김동현)
     */
    function showExplain($sql)
    {
        $sql = trim($sql);
        //echo "test";
        if (!isset($this->dbcon)) {
            $this->dbcon($this->db_name);
        }

        $outHTML        = '';
        $arr_table      = array();
        $ut_eSelectType = null;
        $ut_eType       = null;
        $ut_eMaxKeyLen  = null;
        $ut_eMaxRows    = null;
        if (preg_match('/^select/i', $sql) || preg_match('/^SELECT/i', $sql)) {
            $result  = mysqli_query($this->dbcon, 'EXPLAIN '.$sql) or die(mysqli_error($this->dbcon));
            $outHTML .= '<div style="padding:3px;border:1px solid #AAAAAA;margin:5px;width:800px;">'.$sql.'</div>';
            $outHTML .= '<table border="1" cellpadding="3" cellspacing="1" style="border-collapse:collapse;border-color:#AAAAAA;margin:5px;"><tr bgcolor="#E3E3E3" align="center"><td>id</td><td>select_type</td><td>table</td><td>type</td><td>possible_keys</td><td>key</td><td>key_len</td><td>ref</td><td>rows</td><td>Extra</td></tr>';

            while ($row = mysqli_fetch_assoc($result)) {
                $arr_table[]      = $row['table'];
                $ut_eSelectType[] = $row['select_type'];
                $ut_eType[]       = $row['type'];
                $ut_eMaxKeyLen[]  = $row['key_len'];
                $ut_eMaxRows[]    = $row['rows'];
                $type_s           = ($row['type'] == 'ALL') ? ' style="color:#FF0000;font-weight:bold;"' : '';
                $rows_s           = ($row['rows'] > 1000) ? ' style="color:#FF0000;"' : '';
                $outHTML          .= '<tr bgcolor="#FFFFFFF"><td>'.$row['id'].'</td><td>'.$row['select_type'].'</td><td>'.$row['table'].'</td><td'.$type_s.'>'.$row['type'].'</td><td>'.$row['possible_keys'].'</td><td>'.$row['key'].'</td><td>'.$row['key_len'].'</td><td>'.$row['ref'].'</td><td'.$rows_s.'>'.$row['rows'].'</td><td>'.$row['Extra'].'</td></tr>';
            }
            $outHTML .= '</table>';
        }
        //if($_SESSION['admininfo']['charger_id'] == 'caesar')	echo $outHTML;
        // 로그 저장
        $uq_querys = '';
        $ut_querys = array();
        preg_match_all('/admin_log|admin_log_test|bbs_after|bbs_after_comment|bbs_b2b_notice|bbs_b2b_notice_comment|bbs_b2b_qna|bbs_b2b_qna_comment|bbs_counsel|bbs_counsel_comment|bbs_faq|bbs_faq2|bbs_free_boad|bbs_free_boad_comment|bbs_manage_config|bbs_manage_div|bbs_notice|bbs_notice_comment|bbs_qna|bbs_qna5|bbs_qna_comment|bbs_spam_config|bbs_templete|bbs_unconfirmed|bbs_unconfirmed_comment|blog_basicinfo|blog_bbs|blog_bbs_comment|blog_bbs_group|blog_bbs_manage|cafe_basicinfo|cafe_bbs|cafe_bbs_comment|cafe_bbs_group|cafe_bbs_manage|cafe_member|co_product|co_sellershop_apply|co_sellershopinfo|commerce_salestack|commerce_viewingview|con_log|inventory_company_info|inventory_info|inventory_info_productorder|inventory_input_history|inventory_input_history_detail|inventory_output_history|logstory_ByKeyword|logstory_ByReferer|logstory_ByetcReferer|logstory_DurationTime|logstory_PageViewTime|logstory_banner_click|logstory_bypage|logstory_etchost|logstory_etcrefererinfo|logstory_keywordinfo|logstory_main_mdgoods_click|logstory_maingoods_click|logstory_memberreg_stack|logstory_pageinfo|logstory_pageviewtime|logstory_referer_categoryinfo|logstory_refererurl|logstory_revisittime|logstory_time|logstory_visitor|logstory_visitorinfo|logstory_visittime|shop_accounts|shop_addimage|shop_addressbook|shop_addressbook_group|shop_admin_favorite|shop_auction_list|shop_bankinfo|shop_bannerinfo|shop_bbs_group|shop_bbs_useafter|shop_brand|shop_buyingservice_info|shop_cart|shop_cash_info|shop_category_addfield|shop_category_info|shop_code|shop_company|shop_company_department|shop_company_position|shop_cooperation|shop_cupon|shop_cupon_publish|shop_cupon_regist|shop_cupon_relation_brand|shop_cupon_relation_category|shop_cupon_relation_product|shop_design|shop_dropmember|shop_estimate_category|shop_estimate_relation|shop_estimates|shop_estimates_detail|shop_event|shop_event_info|shop_event_product_group|shop_event_product_relation|shop_gift_certificate|shop_groupinfo|shop_html_library|shop_icon|shop_image_resizeinfo|shop_join_info|shop_layout_info|shop_mail_box|shop_mail_taget|shop_mailling_history|shop_mailsend_config|shop_main_product_group|shop_main_product_relation|shop_manage_flash|shop_manual|shop_my_friend|shop_order|shop_order_delivery|shop_order_detail|shop_order_gift|shop_order_memo|shop_order_status|shop_orders_|shop_pageinfo|shop_poll_field|shop_poll_group|shop_poll_result|shop_poll_title|shop_popup|shop_priceinfo|shop_product|shop_product_auction|shop_product_buyingservice_priceinfo|shop_product_displayinfo|shop_product_options_detail|shop_product_options|shop_product_photo|shop_product_qna|shop_product_qna2|shop_product_relation|shop_promotion_div|shop_promotion_goods|shop_promotion_goods_relation|shop_qna|shop_recommend|shop_recommend_div|shop_recommend_product_relation|shop_region_delivery|shop_relation_product|shop_reserve_info|shop_search_count|shop_search_keyword|shop_shopinfo|shop_sms_regist|shop_taxbill|shop_taxbill_detail|shop_taxbill_status|shop_tmp|shop_wishlist|shop_zip|receipt|receipt_result|recipe_category|search_popular|view_goods_saleprice|work_group|work_list|work_quick|work_tmp/',
            $sql, $table);
        $qi        = 0;
        foreach ($table[0] as $_key => $_val) {
            //echo strpos($sql, $_val);
            $tmp   = explode(' ', str_replace(array('  ', ','), array(' ', ''), $sql));
            $tbKey = array_search($_val, $tmp);
            if (($eKey  = array_search($tmp[$tbKey], $arr_table)) !== false) {
                $tbName = $tmp[$tbKey];
            } else if (($eKey = array_search($tmp[$tbKey + 1], $arr_table)) !== false) {
                $tbName = $tmp[$tbKey];
            } else {
                $eKey = null;
            }
            $type   = explode(' ', $sql);
            $type   = strtoupper($type[0]);
            $result = mysqli_query($this->dbcon,
                'SELECT COUNT(*) FROM useQuery uq INNER JOIN useTable ut ON ut.uq_idx = uq.uq_idx WHERE uq.uq_location = "'.$_SERVER['PHP_SELF'].'" AND uq.uq_type = "'.$type.'" AND ut.ut_tableName = "'.$_val.'" AND ut.ut_selectType = "'.$ut_eSelectType[$eKey].'" AND ut.ut_type = "'.$ut_eType[$eKey].'"') or die(mysql_error());
            $row    = mysqli_fetch_row($result);
            if (!$row[0]) {
                $uq_querys        = '("'.$type.'","'.$_SERVER['PHP_SELF'].'","'.$_SERVER['QUERY_STRING'].'","'.addslashes($sql).'", NOW())';
                $ut_querys[$qi][] = 'ut_tableName = "'.$_val.'"';
                $ut_querys[$qi][] = 'ut_selectType = "'.$ut_eSelectType[$eKey].'"';
                $ut_querys[$qi][] = 'ut_type = "'.$ut_eType[$eKey].'"';
                $ut_querys[$qi][] = 'ut_maxKeyLen = "'.$ut_eMaxKeyLen[$eKey].'"';
                $ut_querys[$qi][] = 'ut_rows = "'.$ut_eMaxRows[$eKey].'"';
                $qi++;
            }
        }
        if (count($ut_querys) > 0) {
            //echo 'INSERT INTO useQuery (uq_type, uq_location, uq_param, uq_sql, uq_regdate) VALUES '.$uq_querys;
            mysqli_query($this->dbcon, 'INSERT INTO useQuery (uq_type, uq_location, uq_param, uq_sql, uq_regdate) VALUES '.$uq_querys) or die(mysql_error());
            $uq_idx = mysqli_insert_id($this->dbcon);
            foreach ($ut_querys as $_key2 => $_val2) {
                $_val2[] = 'uq_idx = '.$uq_idx;
                mysql_query('INSERT INTO useTable SET '.implode(',', $_val2)) or die(mysql_error());
            }
        }
    }

    /**
     * db,user setter 추가 12.08.13 bgh
     */
    function setDbName($dbname)
    {
        $this->db_name = $dbname;
    }

    function setDbUser($dbuser, $dbpass)
    {
        $this->db_user = $dbuser;
        $this->db_pass = $dbpass;
    }

    function setDbHost($dbhost)
    {
        $this->db_host = $dbhost;
    }
}