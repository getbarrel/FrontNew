<?php

class Cubrid {

    var $dbcon; // 링크 식별자
    var $db_host; // 디비 호스트
    var $db_user; // 디비 사용자
    var $db_pass; // 디비 비밀번호
    var $db_name; // 디비 이름
    var $db_port; // 디비 포트
    var $result; // 쿼리 결과셋
    var $total; // 쿼리 결과수
    var $dt; // 결과 데이터
    var $sql;
    var $sequences;
    var $debug;
    var $error_display;
    var $sql_injection_result;
    var $ase_encrypt_key = "";

    function __construct() {
        global $db_host, $db_user, $db_pass, $db_name, $db_port;

        if ($db_host && $db_user && $db_pass && $db_name && $db_port) {
            // echo $_SERVER["HTTP_HOST"];
            $this->db_host = $db_host;
            $this->db_user = $db_user;
            $this->db_pass = $db_pass;
            $this->db_name = $db_name;
            $this->db_port = $db_port;
        } else if ($_SERVER ["HTTP_HOST"] == "cubrid.forbiz.co.kr") {
            $this->db_host = "localhost";
            $this->db_user = "dba";
            $this->db_pass = "vhqlwm2011";
            $this->db_name = "dev";
            $this->db_port = "33000";
        } else {
            $this->db_host = "localhost";
            $this->db_user = "forbiz";
            $this->db_pass = "vhqlwm2011";
            $this->db_name = "dev";
            $this->db_port = "8022";
        }

        $this->ase_encrypt_key = "2ad265d024a06e3039c3649213a834390412aa7097ea05eea4e0b44c88ecf7972ad265d024a06e3039c3649213a834390412aa7097ea05eea4e0b44c88ecf797";

        $this->error_display = true;
        $this->sql_injection_result = true;
    }

    function dbcon($db_name) {
        global $cnt;

        $this->dbcon = cubrid_connect($this->db_host, $this->db_port, $this->db_name, $this->db_user, $this->db_pass) or $this->error();
    }

    function close() {
        return cubrid_close($this->dbcon);
    }

    function query($sql) {
        global $admininfo;

        $this->sql = $sql;

        if ($this->debug) {
            echo nl2br($sql) . "<br><br>";
            $this->showExplain($sql);
        }

        if (($_SERVER ["HTTP_HOST"] == "soho.mallstory.com" || $_SERVER ["HTTP_HOST"] == "b2b.mallstory.com" || $_SERVER ["HTTP_HOST"] == "sohosample.s2.mallstory.com" || $_SERVER ["HTTP_HOST"] == "bizsample.s2.mallstory.com")) { // || $_SERVER["HTTP_HOST"] == "biz.mallstory.com"
            if (substr_count($_SERVER ["PHP_SELF"], "admin/")) {
                if (eregi('^DELETE', $sql) || eregi('^delete', $sql) || eregi('^UPDATE', $sql) || eregi('^update', $sql) || eregi('^INSERT', $sql) || eregi('^insert', $sql) || eregi('^delete', $act) || eregi('^DELETE', $act) || eregi('^UPDATE', $act) || eregi('^update', $act) || eregi('^INSERT', $act) || eregi('^insert', $act)) { //
                    if (strpos($sql, "insert into bbs_tmp") === false && strpos($sql, "insert into con_log") === false) { // 체험판 로그인과 메인 접속을 위해 수정 kbk 12/12/04
                        echo "<script>alert('데모사이트는 입력/수정/삭제 권한이 없습니다.');if(parent.document.URL == document.URL){history.back();}else{parent.document.location.reload();}</script>";
                        exit();
                    }
                }
            } else {
                if (eregi('^DELETE', $sql)) { //
                    // echo "데모사이트는 삭제권한이 없습니다.";
                    // echo "<script>alert('데모사이트는 수정/삭제 권한이 없습니다.');if(parent.document.URL == document.URL){history.back();}else{parent.document.location.reload();}</script>";
                    // exit;
                }
            }
        }

        if (!isset($this->dbcon))
            $this->dbcon($this->db_name);
        cubrid_query("set names utf8");

        $this->result = cubrid_query("$sql") or $this->error();

        /*
         * if (eregi('^SELECT',$sql)) $this->total(); if (eregi('^select',$sql)) $this->total(); if (eregi('^DESC',$sql)) $this->total(); if (eregi('^show',$sql)) $this->total();
         */
        if (preg_match('/^select|desc|show/i', $sql)) {
            $this->total();
        }
        return $this->result;
    }

    function fetch($rows = 0, $type = 'array', $result_type = MYSQL_BOTH) {
        $fetch = "cubrid_fetch_$type";

        if (@cubrid_data_seek($this->result, $rows)) {
            if ($type == 'array') {
                $this->dt = $fetch($this->result, $result_type);
            } else {
                $this->dt = $fetch($this->result);
            }
        }

        return $this->dt;
    }

    function fetchall($type = 'array') {
        $i = 0;
        $fetch = "cubrid_fetch_$type";
        while ($row = $fetch($this->result)) {
            $array1 = array(
                "idx_" => $i + 1
            );
            $marray = array_merge($array1, (array) $row);
            $data [] = $marray;

            // echo "user_id: ".$data[$i][0]."<br>\n";
            $i ++;
        }
        // print_r($data);
        return $data;
    }

    function insert_id() {
        $id = cubrid_insert_id();

        return $id;
    }

    function fetchall2($type = 'array') {
        $i = 0;
        $fetch = "cubrid_fetch_$type";
        while ($row = $fetch($this->result)) {
            // $marray = array_merge($array1, (array)$row);
            $data [] = (array) $row;

            // echo "user_id: ".$data[$i][0]."<br>\n";
            $i ++;
        }
        // print_r($data);
        return $data;
    }

    function cubrid_table_exists($table) {
        if (!isset($this->dbcon))
            $this->dbcon($this->db_name);

        $exists = cubrid_query("SELECT 1 FROM $table LIMIT 0");
        if ($exists)
            return true;
        return false;
    }

    function table_exists($table) {
        if (!isset($this->dbcon))
            $this->dbcon($this->db_name);

        $exists = cubrid_query("SELECT 1 FROM $table LIMIT 0");
        if ($exists)
            return true;
        return false;
    }

    function getrows() {
        $i = 0;

        while ($row = cubrid_fetch_row($this->result)) {
            // print_r($row)."<br>";
            // $var[$cnt][$i]=$array[$loop]; //배열에 이름 저장
            for ($loop = 0; $loop <= count($row); $loop ++) { // 레코드값들으 배열에 저장
                $var [$loop] [$i] = $row [$loop];
                // echo $row[$loop];
            }
            $i ++;
        }
        // print_r($var);
        return $var;
    }

    function total() {
        $this->total = @cubrid_num_rows($this->result);
    }

    function error() {
        global $HTTP_REFERER;
        global $install_path;
        echo 1;
        $write = date('Y-m-d H:i:s') . " " . $_SERVER ["REQUEST_URI"] . " " . $HTTP_REFERER . " \n " . addslashes(cubrid_error()) . "\n" . $this->sql . "\n\n";
        $path = $_SERVER ["DOCUMENT_ROOT"] . "/_logs/";

        if (!is_dir($path)) {
            mkdir($path, 0777);
            chmod($path, 0777);
        } else {
            // chmod($path,0777);
        }

        $fp = fopen($_SERVER ["DOCUMENT_ROOT"] . $_SESSION ["layout_config"] ["mall_data_root"] . "/_logs/cubrid_error.txt", "a+");
        fwrite($fp, $write);
        fclose($fp);

        if ($_SERVER ["HTTP_HOST"] != "dev.forbiz.co.kr" && false) {
            if (cubrid_errno() == "1146") { // 테이블이 없을때 ...
                ini_set('include_path', '.:/usr/local/lib/php:' . $_SERVER ["DOCUMENT_ROOT"] . '/include/pear');

                // $install_path = "../include/";
                $install_path = $_SERVER ["DOCUMENT_ROOT"] . "/include";
                include_once ("SOAP/Client.php");

                $soapclient = new SOAP_Client("http://dev.forbiz.co.kr/ws/?wsdl");
                // server.php 의 namespace 와 일치해야함
                $options = array(
                    'namespace' => 'urn:SOAP_MALLSTORY_WS',
                    'trace' => 1
                );

                preg_match_all("|Table '(.*)\.(.*)' doesn't exist|U", cubrid_error(), $table_info, PREG_PATTERN_ORDER);

                $table_name = $table_info [2] [0];
                $error_sql = $this->sql;
                // print_r($table_info);;
                // exit;

                $create_table_str = $soapclient->call("getTableInfo", $params = array(
                    "table_name" => $table_name
                        ), $options);

                // echo $create_table_str;
                $this->query($create_table_str);
                $this->query($error_sql);
                exit();
            } else if (cubrid_errno() == "1054") { // 컬럼이 없을때 ...
                ini_set('include_path', '.:/usr/local/lib/php:' . $_SERVER ["DOCUMENT_ROOT"] . '/include/pear');

                // $install_path = "../include/";
                $install_path = $_SERVER ["DOCUMENT_ROOT"] . "/include";
                include_once ("SOAP/Client.php");

                $soapclient = new SOAP_Client("http://dev.forbiz.co.kr/ws/?wsdl");
                // server.php 의 namespace 와 일치해야함
                $options = array(
                    'namespace' => 'urn:SOAP_MALLSTORY_WS',
                    'trace' => 1
                );
                // echo "1<br><br>";
                // exit;
                preg_match_all("|Unknown column '(.*)\.(.*)' in|U", cubrid_error(), $column_info, PREG_PATTERN_ORDER);
                // echo cubrid_error();
                // print_r($column_info);
                $column_name = $column_info [2] [0];
                $alias = $column_info [1] [0];

                if ($column_name != "") {

                    $parser = new PHPSQLParser($this->sql);
                    // print_r($parser->parsed);
                    // exit;
                    $table_info = $parser->parsed [FROM];
                    for ($i = 0; $i < count($table_info); $i ++) {
                        if ($table_info [$i] [alias] == $alias) {
                            $tables [$i] = $table_info [$i] [table];
                        }
                    }

                    $error_sql = $this->sql;
                    // echo $column_name."<br><br>";
                    // exit;

                    $column_info = (array) $soapclient->call("getColumnInfo", $params = array(
                                "tables" => $tables,
                                "column_name" => $column_name
                                    ), $options);
                    // print_r($column_info);
                    // echo count($column_info)."<br><br>";
                    // exit;
                    if (count($column_info) > 0) {
                        if (is_null($column_info ["Default"])) {
                            $default_str = " default null ";
                        } else if ($column_info ["Default"] != "") {
                            $default_str = " default '" . $column_info ["Default"] . "'";
                        } else if ($column_info ["Default"] == "" && $column_info ["Null"] == "YES") {
                            $default_str = " default NULL";
                        }

                        $alter_table_str = "alter table " . $column_info [table_name] . " add " . $column_name . "  " . $column_info ["Type"] . "  " . ($column_info ["Null"] == "YES" ? "NULL" : "NOT NULL") . "  $default_str " . $column_info ["Extra"] . "   " . ($column_info ["after_column_name"] != "" ? "after " . $column_info ["after_column_name"] : "") . " ";
                        // echo $alter_table_str."<br>";
                        // exit;
                        $this->query($alter_table_str);

                        if ($column_info ["Key"] == "MUL") {
                            $alter_table_key_str = "alter table " . $column_info [table_name] . " add index " . $column_name . "(" . $column_name . ") ";
                            // echo $alter_table_key_str."<br>";
                            $this->query($alter_table_key_str);
                        } else if ($column_info ["Key"] == "PRI") {
                            $alter_table_key_str = "alter table " . $column_info [table_name] . " add index " . $column_name . "(" . $column_name . ") ";
                            // echo $alter_table_key_str."<br>";
                            $this->query($alter_table_key_str);
                        }
                    }

                    return $this->query($error_sql);
                }
                // exit;
                //
					
					// return ;
            }
        }
        // else{
        $mstring = "<html>";
        $mstring .= "<table width=100% height=100%>";
        $mstring .= "<tr><td align=center valign=middle><div style='height:200px;width:400px;border:10px solid #efefef;font-size:12px;font-family:돋움;'>MYSQL 오류 <br><br> " . addslashes(cubrid_errno()) . " " . addslashes(cubrid_error()) . " <br><br>" . $this->sql . "</div></td></tr>";
        $mstring .= "<table>";
        $mstring .= "</html>";

        $mstring = '
					<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
					<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
					<head>
					<title> 요청하신 페이지를 찾을 수 없습니다.</title>
					<meta http-equiv="content-type" content="text/html; charset=utf-8" />
					<style type="text/css">
					html, body, div, span, applet, object, iframe,
					h1, h2, h3, h4, h5, h6, p, blockquote, pre,
					a, abbr, acronym, address, big, cite, code,
					del, dfn, em, img, ins, kbd, q, s, samp,
					small, strike, strong, sub, sup, tt, var,
					b, u, i, center,
					dl, dt, dd, ol, ul, li,
					fieldset, form, label, legend,input,button,textarea,select,option
					table, caption, tbody, tfoot, thead, tr, th, td,
					article, aside, canvas, details, embed, 
					figure, figcaption, footer, header, hgroup, 
					menu, nav, output, ruby, section, summary,
					time, mark, audio, video {
					margin: 0;
					padding: 0;
					border: 0;
					}
					h1,h2,h3,h4,h5,h6{font-size:12px;text-align:left}
					body,input,button,textarea,select,option{font-size:12px; font-family:"돋움", dotum,Helvetica,sans-serif; color:#383d41;}
					a{color:#2f3743;text-decoration:none}
					a:hover{color:#000;text-decoration:none}
					article, aside, details, figcaption, figure, 
					footer, header, hgroup, menu, nav, section {
					display: block;
					}
					body {
					line-height: 1;
					}
					ol, ul {
					list-style: none;
					}
					blockquote, q {
					quotes: none;
					}
					blockquote:before, blockquote:after,
					q:before, q:after {
					content: "";
					content: none;
					}
					table {
					border-collapse: collapse;
					border-spacing: 0;
					}

					.warp{width:516px; padding-top:150px; margin:0px auto;}
					</style>
					</head>

					<body>
					<div class="warp">
						<h1 style="padding-bottom:15px; border-bottom:1px solid #ddd; text-align:center;"><img src="http://' . $_SERVER ["HTTP_HOST"] . '/images/error/error_05.gif" alt="요청하신 페이지를 찾을 수 없습니다." title="서비스 이용에 불편을 드려 죄송합니다." /></h1>
						<div style="margin-top:18px; line-height:150%; color:#757575; padding-left:20px;">
							인터넷 통신 이상 등으로 인한 일시적인 오류일 수 있으나 페이지 새로고침을 해 보시고,<br />오류가 지속될 경우 고객센터로 문의해 주시기 바랍니다.
						</div>
						<div style="text-align:center; padding:20px 0; line-height:140%">
							<ul>';
        if ($_SESSION ["shopcfg"] ["phone"] != "") {
            $mstring .= '<li style="font-size:13px">사이트 운영사 : ' . $_SESSION ["shopcfg"] ["phone"] . '</li>';
        }
        $mstring .= '<li style="font-size:13px">사이트 구축사 : 1600-2028</li>
							</ul>
						</div>
						<div style="background:#ededed; width:100%;">
							<div style="padding:15px 22px; line-height:140%;">
								<h3 style="color:#fb6921; padding-bottom:10px;">오류 알림 : ' . date("Y.m.d H시i분s초") . ' : 웹페이지를 찾을 수 없습니다.</h3>';
        if ($_SERVER ["HTTP_HOST"] == "dev.forbiz.co.kr" || $_SERVER ["HTTP_HOST"] == "s1.mallstory.com" || $_SERVER ["HTTP_HOST"] == "s2.mallstory.com" || $_SERVER ["HTTP_HOST"] == "s3.mallstory.com" || $_SERVER ["REMOTE_ADDR"] == "175.209.244.68") {
            $mstring .= '<div style="color:black;">MYSQL 오류<br><br>' . addslashes(cubrid_errno()) . ' ' . addslashes(cubrid_error()) . '<br><br>' . $this->sql . '</div>';
        }
        $mstring .= '<div style="color:#757575;">해당 오류로 인하여 요청하신 페이지를 찾을 수 없습니다. 해당 문의는 고객센터를 통해 문의해 주시기 바랍니다.</div>
							</div>
						</div>
						<div align="center" style="padding-top:23px;">
							<span>';
        if ($_SERVER ["HTTP_REFERER"] != "") {
            $mstring .= '<a href="' . $_SERVER ["HTTP_REFERER"] . '">';
        } else {
            $mstring .= '<a href="/">';
        }
        $mstring .= '<img src="http://' . $_SERVER ["HTTP_HOST"] . '/images/error/error_butom_07.gif" alt="이전페이지"></a>
							</span>
							<span style="padding-left:16px;">
								<a href="/"><img src="http://' . $_SERVER ["HTTP_HOST"] . '/images/error/error_butom_09.gif" alt="메인페이지"></a>
							</span>
						</div>
					</div>

					</body>
					</html>
				'; // 오류 페이지 kbk 13/04/12

        echo $mstring;
        // }

        exit();

        if ($this->error_display) {
            echo ("<script>\nalert('" . addslashes(cubrid_errno()) . " : " . addslashes(cubrid_error()) . "');\nlocation = '" . $HTTP_REFERER . "';\n</script>");
        } else {
            echo ("<script>\nalert('Mysql Error');\nlocation = '" . $HTTP_REFERER . "';\n</script>");
        }
        exit();
    }

    function nocache() {
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
    }

    function include_all_once($pattern) {
        foreach (glob($pattern) as $file) { // remember the { and } are necessary!
            include $file;
        }
    }

    function sqlFilter($param) {
        // $array_split_item[0] = "-";
        $block_chars = array(
            "--",
            ";",
            "/*",
            "*/",
            "@@",
            "char",
            "nchar",
            "varchar",
            "nvarchar",
            "alter",
            "begin",
            "cast",
            "create",
            "cursor",
            "declare",
            "delete",
            "drop",
            "end",
            "exec",
            "execute",
            "fetch",
            "insert",
            "kill",
            "open",
            "select",
            "sys",
            "sysobjects",
            "syscolumns",
            "table",
            "update",
            "<script",
            "</script>",
            "'"
        );
        // $block_schars = array ("|","-", ";", "/*", "*/", "@@", "@", "&", ";", "$", "%", "&", "'", "\"", "\\'", "\\"", "<>", "()", "+", ",","\");

        for ($i = 0; $i < count($block_chars); $i ++) {
            if (substr_count(" " . $param, $block_chars [$i])) {
                $this->sql_injection_result = false;
                $this->saveSqlInjectionLog("Check-" . $block_chars [$i] . ": " . $param);
                exit();
            }
        }
        return $param;
    }

    function saveSqlInjectionLog($log_txt) {
        $write = date('Y-m-d H:i:s') . " " . $this->sql . "\t";
        $write = $write . $log_txt . "\n";
        $path = $_SERVER ["DOCUMENT_ROOT"] . "/_logs/";

        if (!is_dir($path)) {
            mkdir($path, 0777);
            chmod($path, 0777);
        } else {
            // chmod($path,0777);
        }

        $fp = fopen($_SERVER ["DOCUMENT_ROOT"] . "/_logs/sql_injection_log.txt", "a+");
        fwrite($fp, $write);
        fclose($fp);
    }

    /**
     * 쿼리 실행계획 보여주기
     *
     * 2011.02.21 추가 (김동현)
     */
    function showExplain($sql) {
        $sql = trim($sql);
        // echo "test";
        if (!isset($this->dbcon)) {
            $this->dbcon($this->db_name);
        }

        $outHTML = '';
        $arr_table = array();
        $ut_eSelectType = null;
        $ut_eType = null;
        $ut_eMaxKeyLen = null;
        $ut_eMaxRows = null;
        if (preg_match('/^select/i', $sql) || preg_match('/^SELECT/i', $sql)) {
            $result = cubrid_query('EXPLAIN ' . $sql) or die(cubrid_error());
            $outHTML .= '<div style="padding:3px;border:1px solid #AAAAAA;margin:5px;width:800px;">' . $sql . '</div>';
            $outHTML .= '<table border="1" cellpadding="3" cellspacing="1" style="border-collapse:collapse;border-color:#AAAAAA;margin:5px;"><tr bgcolor="#E3E3E3" align="center"><td>id</td><td>select_type</td><td>table</td><td>type</td><td>possible_keys</td><td>key</td><td>key_len</td><td>ref</td><td>rows</td><td>Extra</td></tr>';

            while ($row = cubrid_fetch_assoc($result)) {
                $arr_table [] = $row ['table'];
                $ut_eSelectType [] = $row ['select_type'];
                $ut_eType [] = $row ['type'];
                $ut_eMaxKeyLen [] = $row ['key_len'];
                $ut_eMaxRows [] = $row ['rows'];
                $type_s = ($row ['type'] == 'ALL') ? ' style="color:#FF0000;font-weight:bold;"' : '';
                $rows_s = ($row ['rows'] > 1000) ? ' style="color:#FF0000;"' : '';
                $outHTML .= '<tr bgcolor="#FFFFFFF"><td>' . $row ['id'] . '</td><td>' . $row ['select_type'] . '</td><td>' . $row ['table'] . '</td><td' . $type_s . '>' . $row ['type'] . '</td><td>' . $row ['possible_keys'] . '</td><td>' . $row ['key'] . '</td><td>' . $row ['key_len'] . '</td><td>' . $row ['ref'] . '</td><td' . $rows_s . '>' . $row ['rows'] . '</td><td>' . $row ['Extra'] . '</td></tr>';
            }
            $outHTML .= '</table>';
        }
        // if($_SESSION['admininfo']['charger_id'] == 'caesar') echo $outHTML;
        // 로그 저장
        $uq_querys = '';
        $ut_querys = array();
        preg_match_all('/admin_log|admin_log_test|bbs_after|bbs_after_comment|bbs_b2b_notice|bbs_b2b_notice_comment|bbs_b2b_qna|bbs_b2b_qna_comment|bbs_counsel|bbs_counsel_comment|bbs_faq|bbs_faq2|bbs_free_boad|bbs_free_boad_comment|bbs_manage_config|bbs_manage_div|bbs_notice|bbs_notice_comment|bbs_qna|bbs_qna5|bbs_qna_comment|bbs_spam_config|bbs_templete|bbs_unconfirmed|bbs_unconfirmed_comment|blog_basicinfo|blog_bbs|blog_bbs_comment|blog_bbs_group|blog_bbs_manage|cafe_basicinfo|cafe_bbs|cafe_bbs_comment|cafe_bbs_group|cafe_bbs_manage|cafe_member|co_product|co_sellershop_apply|co_sellershopinfo|commerce_salestack|commerce_viewingview|con_log|inventory_company_info|inventory_info|inventory_info_productorder|inventory_input_history|inventory_input_history_detail|inventory_output_history|logstory_ByKeyword|logstory_ByReferer|logstory_ByetcReferer|logstory_DurationTime|logstory_PageViewTime|logstory_banner_click|logstory_bypage|logstory_etchost|logstory_etcrefererinfo|logstory_keywordinfo|logstory_main_mdgoods_click|logstory_maingoods_click|logstory_memberreg_stack|logstory_pageinfo|logstory_pageviewtime|logstory_referer_categoryinfo|logstory_refererurl|logstory_revisittime|logstory_time|logstory_visitor|logstory_visitorinfo|logstory_visittime|shop_accounts|shop_addimage|shop_addressbook|shop_addressbook_group|shop_admin_favorite|shop_auction_list|shop_bankinfo|shop_bannerinfo|shop_bbs_group|shop_bbs_useafter|shop_brand|shop_buyingservice_info|shop_cart|shop_cash_info|shop_category_addfield|shop_category_info|shop_code|shop_company|shop_company_department|shop_company_position|shop_cooperation|shop_cupon|shop_cupon_publish|shop_cupon_regist|shop_cupon_relation_brand|shop_cupon_relation_category|shop_cupon_relation_product|shop_design|shop_dropmember|shop_estimate_category|shop_estimate_relation|shop_estimates|shop_estimates_detail|shop_event|shop_event_info|shop_event_product_group|shop_event_product_relation|shop_gift_certificate|shop_groupinfo|shop_html_library|shop_icon|shop_image_resizeinfo|shop_join_info|shop_layout_info|shop_mail_box|shop_mail_taget|shop_mailling_history|shop_mailsend_config|shop_main_product_group|shop_main_product_relation|shop_manage_flash|shop_manual|shop_my_friend|shop_order|shop_order_delivery|shop_order_detail|shop_order_gift|shop_order_memo|shop_order_status|shop_orders_|shop_pageinfo|shop_poll_field|shop_poll_group|shop_poll_result|shop_poll_title|shop_popup|shop_priceinfo|shop_product|shop_product_auction|shop_product_buyingservice_priceinfo|shop_product_displayinfo|shop_product_options_detail|shop_product_options|shop_product_photo|shop_product_qna|shop_product_qna2|shop_product_relation|shop_promotion_div|shop_promotion_goods|shop_promotion_goods_relation|shop_qna|shop_recommend|shop_recommend_div|shop_recommend_product_relation|shop_region_delivery|shop_relation_product|shop_reserve_info|shop_search_count|shop_search_keyword|shop_shopinfo|shop_sms_regist|shop_taxbill|shop_taxbill_detail|shop_taxbill_status|shop_tmp|shop_wishlist|shop_zip|receipt|receipt_result|recipe_category|search_popular|view_goods_saleprice|work_group|work_list|work_quick|work_tmp/', $sql, $table);
        $qi = 0;
        foreach ($table [0] as $_key => $_val) {
            // echo strpos($sql, $_val);
            $tmp = explode(' ', str_replace(array(
                '  ',
                ','
                            ), array(
                ' ',
                ''
                            ), $sql));
            $tbKey = array_search($_val, $tmp);
            if (($eKey = array_search($tmp [$tbKey], $arr_table)) !== false) {
                $tbName = $tmp [$tbKey];
            } else if (($eKey = array_search($tmp [$tbKey + 1], $arr_table)) !== false) {
                $tbName = $tmp [$tbKey];
            } else {
                $eKey = null;
            }
            $type = explode(' ', $sql);
            $type = strtoupper($type [0]);
            $result = cubrid_query('SELECT COUNT(*) FROM useQuery uq INNER JOIN useTable ut ON ut.uq_idx = uq.uq_idx WHERE uq.uq_location = "' . $_SERVER ['PHP_SELF'] . '" AND uq.uq_type = "' . $type . '" AND ut.ut_tableName = "' . $_val . '" AND ut.ut_selectType = "' . $ut_eSelectType [$eKey] . '" AND ut.ut_type = "' . $ut_eType [$eKey] . '"') or die(cubrid_error());
            $row = cubrid_fetch_row($result);
            if (!$row [0]) {
                $uq_querys = '("' . $type . '","' . $_SERVER ['PHP_SELF'] . '","' . $_SERVER ['QUERY_STRING'] . '","' . addslashes($sql) . '", NOW())';
                $ut_querys [$qi] [] = 'ut_tableName = "' . $_val . '"';
                $ut_querys [$qi] [] = 'ut_selectType = "' . $ut_eSelectType [$eKey] . '"';
                $ut_querys [$qi] [] = 'ut_type = "' . $ut_eType [$eKey] . '"';
                $ut_querys [$qi] [] = 'ut_maxKeyLen = "' . $ut_eMaxKeyLen [$eKey] . '"';
                $ut_querys [$qi] [] = 'ut_rows = "' . $ut_eMaxRows [$eKey] . '"';
                $qi ++;
            }
        }
        if (count($ut_querys) > 0) {
            // echo 'INSERT INTO useQuery (uq_type, uq_location, uq_param, uq_sql, uq_regdate) VALUES '.$uq_querys;
            cubrid_query('INSERT INTO useQuery (uq_type, uq_location, uq_param, uq_sql, uq_regdate) VALUES ' . $uq_querys) or die(cubrid_error());
            $uq_idx = cubrid_insert_id();
            foreach ($ut_querys as $_key2 => $_val2) {
                $_val2 [] = 'uq_idx = ' . $uq_idx;
                cubrid_query('INSERT INTO useTable SET ' . implode(',', $_val2)) or die(cubrid_error());
            }
        }
    }

    /**
     * db,user setter 추가 12.08.13 bgh
     */
    function setDbName($dbname) {
        $this->db_name = $dbname;
    }

    function setDbUser($dbuser, $dbpass) {
        $this->db_user = $dbuser;
        $this->db_pass = $dbpass;
    }

    function setDbHost($dbhost) {
        $this->db_host = $dbhost;
    }

}
