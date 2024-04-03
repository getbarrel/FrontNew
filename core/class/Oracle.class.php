<?php

class Oracle {

    var $dbms_type = "oracle";
    var $dbcon;  // 링크 식별자
    var $db_host; // 디비 호스트
    var $db_user; // 디비 사용자
    var $db_pass; // 디비 비밀번호
    var $db_name; // 디비 이름
    var $result; // 쿼리 결과셋
    var $result_all;
    var $last_insert_id;
    var $total;  // 쿼리 결과수
    var $dt;  // 결과 데이터
    var $sql;
    var $sequences;
    var $debug;
    var $error_display;
    var $sql_injection_result;
    var $ase_encrypt_key = "";
    var $too_big_data = "";

    function __construct() {
        global $db_host, $db_user, $db_pass, $db_name;

        if ($db_host && $db_user && $db_pass && $db_name) {
            //echo $_SERVER["HTTP_HOST"];
            $this->db_host = $db_host;
            $this->db_user = $db_user;
            $this->db_pass = $db_pass;
            $this->db_name = $db_name;
        } else if ($_SERVER["HTTP_HOST"] == "oracle.forbiz.co.kr") {
            $this->db_host = "175.209.244.68/orcl";
            $this->db_user = "didierdubot2"; //njoyny5
            $this->db_pass = "oracle1234";
            $this->db_name = "didierdubot2";
        } else if ($_SERVER["HTTP_HOST"] == "didierdubot.forbiz.co.kr") {
            $this->db_host = "175.209.244.68/orcl";
            $this->db_user = "dev_oracle1"; //njoyny5
            $this->db_pass = "oracle1234";
            $this->db_name = "dev_oracle1";
        }

        $this->ase_encrypt_key = "1234567890abcdef";
        //echo trim($_SERVER["REMOTE_ADDR"])."<br>";
        if (trim($_SERVER["REMOTE_ADDR"]) == "175.121.188.179") {
            //echo "aaA";
            //$this->debug = false;
        } else {
            //echo "'".$_SERVER["REMOTE_ADDR"]."'<br>";
            //$this->debug = false;
        }
        $this->error_display = true;
        $this->sql_injection_result = true;
    }

    function dbcon($db_name) {
        global $cnt;
        //putenv("NLS_LANG=KOREAN_KOREA.AL32UTF8");
        $this->dbcon = oci_connect($this->db_user, $this->db_pass, $this->db_host, "AL32UTF8") or $this->error();

        //oci_select_db($this->db_name,$this->dbcon) or $this->error();
    }

    function close() {
        return oci_close($this->dbcon);
    }

    function query($sql, $key = "''") {
        global $admininfo, $CHANGE_TABLEINFO;

        unset($this->result_all);
        //$sql = strtoupper($sql);
        $sql = $sql;
        $sql = str_replace("NOW()", "sysdate", $sql);
        $sql = str_replace("now()", "sysdate", $sql);
        $sql = str_replace("DATE_FORMAT", "TO_CHAR", $sql);
        //$sql = str_replace("date_format","TO_DATE",$sql);
        $sql = str_replace("date_format", "TO_CHAR", $sql);

        if (false) {
            $sql = str_replace("%Y", "YYYY", $sql);
            $sql = str_replace("%m", "MM", $sql);
            $sql = str_replace("%d", "DD", $sql);
            $sql = str_replace("%H", "HH24", $sql);
            $sql = str_replace("%i", "MI", $sql);
            $sql = str_replace("%s", "SS", $sql);
        }
        $sql = str_replace("%Y%m%d%H%i%s", "YYYYMMDDHH24MISS", $sql);
        $sql = str_replace("%Y%m%d", "YYYYMMDD", $sql);
        $sql = str_replace("%Y%m", "YYYYMM", $sql);
        $sql = str_replace("%Y.%m.%d", "YYYY.MM.DD", $sql);
        $sql = str_replace("%Y-%m-%d", "YYYY-MM-DD", $sql);

        $sql = str_replace("%H:%i:%s", "HH24:MI:SS", $sql);
        $sql = str_replace("%H:%i", "HH24:MI", $sql);
        $sql = str_replace("%H%i", "HH24MI", $sql);
        $sql = str_replace("%H", "HH24", $sql);
        $sql = str_replace("%i", "MI", $sql);

        $sql = str_replace("MD5(", "DBMS_OBFUSCATION_TOOLKIT.MD5(", $sql);

        //$sql = str_replace("AES128_CRYPTO.decrypt(","(",$sql);
        $sql = str_replace("AES_DECRYPT(", "AES128_CRYPTO.decrypt(", $sql);

        //$sql = str_replace("AES_DECRYPT(","(",$sql);

        $sql = str_replace("AES_ENCRYPT(", "AES128_CRYPTO.encrypt(", $sql);
        //$sql = str_replace("AES_ENCRYPT(","(",$sql);
        //$sql = str_replace("AES128_CRYPTO.encrypt(","(",$sql);
        //$sql = str_replace(",'1234567890abcdef'","",$sql);
        //오라클은 헥스 안씀!
        $sql = str_replace("(UNHEX(", "((", $sql);
        $sql = str_replace("(HEX(", "((", $sql);
        $sql = str_replace("HEX(", "(", $sql);
        //$sql = str_replace("(UNHEX(","(HEXTORAW(",$sql);
        //$sql = str_replace("(HEX(","(RAWTOHEX(",$sql);
        //$sql = str_replace("HEX(","RAWTOHEX(",$sql);

        $sql = str_replace("SUBSTRING(", "SUBSTR(", $sql);
        $sql = str_replace("substring(", "substr(", $sql);

        $sql = str_replace("DATE_SUB", "", $sql);
        //$sql = str_replace("sysdate,","sysdate - ",$sql);
        $sql = str_replace("sysdate, interval", "sysdate - interval ", $sql);

        $sql = str_replace("IFNULL", "nvl", $sql);
        $sql = str_replace("CHAR_LENGTH", "LENGTH", $sql);

        $sql = str_replace("HIGH_PRIORITY", "", $sql);

        $sql = str_replace("CEILING(", "CEIL(", $sql);

        $sql = str_replace("rand()", "dbms_random.value", $sql);
        $sql = str_replace("uid ", "uid_ ", $sql);
        $sql = str_replace("uid,", "uid_,", $sql);
        $sql = str_replace(".date ", ".date_ ", $sql);
        $sql = str_replace(" date ", " date_ ", $sql);
        $sql = str_replace(".date,", ".date_,", $sql);
        $sql = str_replace("left(", "substr(", $sql);
        $sql = str_replace("LEFT(", "substr(", $sql);


        // 테이블 이름 변경
        for ($i = 0; $i < count($CHANGE_TABLEINFO); $i++) {
            $sql = str_replace($CHANGE_TABLEINFO[$i][mysql_orgin_name], $CHANGE_TABLEINFO[$i][change_name], $sql);
        }




        if (substr_count($sql, "LIMIT") || substr_count($sql, "limit")) {
            $parser = new PHPSQLParser($sql);
            $query_info = $parser->parsed;

            if (is_array($query_info["LIMIT"]) || is_array($query_info["limit"])) {
                //print_r($query_info);
                //echo $query_info["LIMIT"]["end"];
                //exit;
                $sql = str_replace("LIMIT " . $query_info["LIMIT"]["start"] . ", " . $query_info["LIMIT"]["end"] . "", "", $sql);
                $sql = str_replace("LIMIT " . $query_info["LIMIT"]["start"] . "," . $query_info["LIMIT"]["end"] . "", "", $sql);
                $sql = str_replace("limit " . $query_info["LIMIT"]["start"] . "," . $query_info["LIMIT"]["end"] . "", "", $sql);
                $sql = str_replace("limit " . $query_info["LIMIT"]["start"] . ", " . $query_info["LIMIT"]["end"] . "", "", $sql);
                /*
                  $sql = str_replace("from",", ROWNUM rnum from ",$sql);
                  $sql = str_replace("FROM",", ROWNUM rnum FROM ",$sql);
                  $sql = str_replace("where"," where ROWNUM <= ".$query_info["LIMIT"][end]." and ",$sql);
                  $sql = str_replace("WHERE"," WHERE ROWNUM <= ".$query_info["LIMIT"][end]." and ",$sql);
                 */
                $sql = "select * from (
					    select a.*, ROWNUM rnum from (
						" . $sql . "
						) a where ROWNUM <= " . ($query_info["LIMIT"][start] + $query_info["LIMIT"][end]) . "
					) where rnum >= " . $query_info["LIMIT"][start] . "";

                //echo nl2br($sql);
            }
        }
        if (preg_match('/^shop_product|SHOP_PRODUCT/i', $sql)) {
            $parser = new PHPSQLParser($sql);
            //print_r($parser->parsed);
            //exit;
        }

        //preg_match_all("|.*limit (.*),(.*)--|U",$sql,$results, PREG_PATTERN_ORDER);
        //print_r($results);
        //$sql = str_replace("--","",$sql);

        if (preg_match('/^insert|INSERT/i', $sql) && !preg_match('/^select|SELECT/i', $sql)) {
            //echo $sql."<br />";
            // 시퀀스를 미리 지정해서 넘겨받지 않는 경우 : 이현우(2013-04-30)
            if ($this->sequences) {
                $this->sequences = strtoupper($this->sequences);
                $seq_sql = "select " . $this->sequences . ".nextval from dual";
                //echo " oracle.class : seq_chk_sql_row : ".$seq_chk_sql_row[0]." ".$this->sequences;
                // 실제로 오라클DB에 해당 시퀀스 구성이 되어 있는지 체크
                $seq_chk_sql = "select count(*) cnt from user_sequences WHERE SEQUENCE_NAME ='" . $this->sequences . "' ";
                if (!isset($this->dbcon))
                    $this->dbcon($this->db_name);
                $this->result = oci_parse($this->dbcon, $seq_chk_sql);
                $result_bool = oci_execute($this->result, OCI_DEFAULT);
                $seq_chk_sql_row = $this->fetch();
                $this->result_all = "";

                if (!$seq_chk_sql_row[cnt]) { // 시컨스테이블 구성이 없으면 무조건 count + 1 로 seq 값 셋팅 : 이현우(2013-05-02)
                    $count_sql = "SELECT nvl(COUNT(*),0) as cnt FROM " . $table_name;
                    $count_result = $this->query($count_sql);
                    $count_row = $this->fetch();
                    $count = $count_row[cnt] + 1;
                    $_SEQ[nextval] = $count;
                    $sql = str_replace("(''", "('" . $_SEQ[nextval] . "'", $sql);
                } else {
                    if (!isset($this->dbcon))
                        $this->dbcon($this->db_name);

                    $this->result = oci_parse($this->dbcon, $seq_sql);

                    $result_bool = oci_execute($this->result, OCI_DEFAULT);

                    //print_r($this->dt);
                    //exit;
                    if (!$result_bool) {
                        $e = oci_error($this->result);
                        $this->error($e);
                        exit;
                    } else {
                        $this->fetch(0);
                        $_SEQ = $this->dt;
                        $this->last_insert_id = $_SEQ[nextval];
                        $last_insert_id = $this->last_insert_id;

                        // 시퀀스값이 테이블 COUNT 보다 작으면 primary key duplicate 문제가 생기므로 테이블의 카운트 조회 : 이현우(2013-04-30)
                        $count_sql = "SELECT nvl(COUNT(*),0) as cntt FROM " . $table_name;
                        if (!isset($this->dbcon))
                            $this->dbcon($this->db_name);
                        $this->result_all = "";
                        $this->result = oci_parse($this->dbcon, $count_sql);
                        $result_bool = oci_execute($this->result, OCI_DEFAULT);
                        $count_row2 = $this->fetch();
                        $count = $count_row2[cntt] + 1;

                        if ($last_insert_id < $count) {   // 시퀀스값이 테이블 COUNT 보다 작으면 primary key duplicate 문제가 생기므로 테이블의 카운트 조회 : 이현우(2013-04-30)
                            $_SEQ[nextval] = $count;
                        }
                        $sql = str_replace("(''", "('" . $_SEQ[nextval] . "'", $sql);
                    }
                }
            }

            //echo $sql;
            //exit;
        }
        $this->sql = $sql;
        //echo $sql."\n<br>";
        if ($this->debug) {
            echo nl2br($sql) . "<br><br>";
            //$this->showExplain($sql);
        }


        if (($_SERVER["HTTP_HOST"] == "soho.mallstory.com" || $_SERVER["HTTP_HOST"] == "b22b.mallstory.com")) { //|| $_SERVER["HTTP_HOST"] == "biz.mallstory.com"
            if (substr_count($_SERVER["PHP_SELF"], "admin/")) {
                if (eregi('^DELETE', $sql) || eregi('^delete', $sql) || eregi('^UPDATE', $sql) || eregi('^update', $sql)) { //
                    echo "<script>alert('데모사이트는 수정/삭제 권한이 없습니다.');if(parent.document.URL == document.URL){history.back();}else{parent.document.location.reload();}</script>";
                    exit;
                }
            } else {
                if (eregi('^DELETE', $sql)) { //
                    //echo "데모사이트는 삭제권한이 없습니다.";
                    //echo "<script>alert('데모사이트는 수정/삭제 권한이 없습니다.');if(parent.document.URL == document.URL){history.back();}else{parent.document.location.reload();}</script>";
                    //exit;
                }
            }
        }

        if (!isset($this->dbcon))
            $this->dbcon($this->db_name);


        $this->result = oci_parse($this->dbcon, $sql);

        if ($this->too_big_data) {
            oci_bind_by_name($this->result, $this->too_big_data[key], $this->too_big_data[val]);
            unset($this->too_big_data);
            $this->too_big_data = "";
        }

        $result_bool = oci_execute($this->result, OCI_DEFAULT);

        if (!$result_bool) {
            $e = oci_error($this->result);
            $this->error($e);
            exit;
        }

        if (preg_match('/^insert|INSERT|update|UPDATE|replace|REPLACE|delete|DELETE/i', $sql)) {
            $result_bool = oci_commit($this->dbcon);
            //echo $this->sql."<br/>";
            if (!$result_bool) {
                $e = oci_error($this->result);
                $this->error($e);
                exit;
            }
        }


        if (preg_match('/^select|desc|show|SELECT|DESC|SHOW/i', $sql)) {
            //exit;
            //echo nl2br($sql)."<br><br>";
            $this->total();
        }

        /*
          while (($row = oci_fetch_array($this->result, OCI_BOTH))) {
          // Use the uppercase column names for the associative array indices
          echo $row[0] . " and " . $row['DEPARTMENT_ID']   . " are the same<br>\n";
          echo $row[1] . " and " . $row['DEPARTMENT_NAME'] . " are the same<br>\n";
          }
         */


        //echo "row:".$this->result;
        //var_dump($row);
        //exit;
        $this->sequences = "";
        return $this->result;
    }

    function fetch($rows = 0, $type = 'array', $result_type = MYSQL_BOTH) {

        //$fetch = "oci_fetch_$type";
        //print_r($this->result);
        //exit;
        if (!is_array($this->result_all)) {
            //echo nl2br($this->sql)."<br />";
            $this->total = oci_fetch_all($this->result, $this->result_all, null, null, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        }
        //print_r($this->result_all);
        $this->dt = $this->result_all[$rows];
        if (is_array($this->dt)) {
            $this->dt = array_change_key_case($this->dt);
        }

        return $this->dt;
    }

    function fetchall($type = 'array') {
        //try{
        //echo $this->sql;
        //print_r($this->result);
        $this->total = oci_fetch_all($this->result, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW + OCI_ASSOC);
        //$result = $this->array_change_key_case_r3($result, CASE_LOWER, true);
        //print_r($result);
        for ($i = 0; $i < count($result); $i++) {
            $result[$i] = array_change_key_case($result[$i]);
        }
        //}catch(Exception  $e){
        //	echo $this->sql;
        //}
        return $result;
    }

    function fetchall2($type = 'array') {
        $i = 0;
        $fetch = "oci_fetch_$type";
        while ($row = $fetch($this->result)) {
            //$marray = array_merge($array1, (array)$row);
            $data[] = (array) $row;

            //echo "user_id: ".$data[$i][0]."<br>\n";
            $i++;
        }
        //print_r($data);
        return $data;
    }

    function array_change_key_case_r3(&$array, $case = CASE_LOWER, $flag_rec = false) {
        $array = array_change_key_case($array, $case);
        if ($flag_rec) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $this->array_change_key_case_r3($array[$key], $case, true);
                }
            }
        }
    }

    function oci_table_exists($table) {
        if (!isset($this->dbcon))
            $this->dbcon($this->db_name);

        $exists = oci_query("SELECT 1 FROM $table LIMIT 0");
        if ($exists)
            return true;
        return false;
    }

    function table_exists($table) {
        if (!isset($this->dbcon))
            $this->dbcon($this->db_name);

        $_exists = oci_parse($this->dbcon, "SELECT 1 FROM $table where rownum < 1 ");
        $result_bool = oci_execute($_exists, OCI_DEFAULT);

        //$exists = oci_query("SELECT 1 FROM $table LIMIT 0");
        if ($result_bool)
            return true;
        return false;
    }

    function getrows() {
        $i = 0;

        while ($row = oci_fetch_row($this->result)) {
            //print_r($row)."<br>";
            //$var[$cnt][$i]=$array[$loop]; //배열에 이름 저장
            for ($loop = 0; $loop <= count($row); $loop++) {  // 레코드값들으 배열에 저장
                $var[$loop][$i] = $row[$loop];
                //echo $row[$loop];
            }
            $i++;
        }
        //print_r($var);
        return $var;
    }

    function total() {
        $_sql = " SELECT COUNT(*) AS NUM_ROWS FROM ($this->sql) count_table  ";
        //echo $_sql."<br>";
        $stid = oci_parse($this->dbcon, $_sql);
        oci_define_by_name($stid, 'NUM_ROWS', $num_rows);
        @oci_execute($stid);
        @oci_fetch($stid);
        $this->total = $num_rows;
        //$this->total = oci_num_rows($this->result);
    }

    function error($e) {
        global $HTTP_REFERER;
        global $install_path;

        $write = date('Y-m-d H:i:s') . " " . $_SERVER["REQUEST_URI"] . " " . $HTTP_REFERER . " \n " . addslashes($e['message']) . "\n" . $this->sql . "\n\n";
        $path = $_SERVER["DOCUMENT_ROOT"] . "/_logs/";

        //20130723 홍진영
        echo "<script type='text/javascript'>
			<!--
				if(window.name =='act' || window.name =='iframe_act'){
					alert(\"데이터베이스 처리중에 문제가 생겼습니다. 계속해서 문제가 발생할시 관리자에게 문의 바랍니다. 에러 메세지 : [" . addslashes($e['message']) . "]\");
				}
			//-->
			</script>";

        if (!is_dir($path)) {
            mkdir($path, 0777);
            chmod($path, 0777);
        } else {
            //chmod($path,0777);
        }


        $fp = fopen($_SERVER["DOCUMENT_ROOT"] . $_SESSION["layout_config"]["mall_data_root"] . "/_logs/oci_error.txt", "a+");
        fwrite($fp, $write);
        fclose($fp);


        //else{
        $mstring = "<html>";
        $mstring .= "<table width=100% height=100%>";
        $mstring .= "<tr><td align=center valign=middle><div style='height:200px;width:400px;border:10px solid #efefef;font-size:12px;font-family:돋움;text-align:left;'>Oracle 오류 <br><br>" . addslashes($e['message']) . " <br><br>" . nl2br($this->sql) . "<br><br><br><br></div></td></tr>";
        $mstring .= "<table>";
        $mstring .= "</html>";

        echo $mstring;
        //}

        exit;

        if ($this->error_display) {
            echo("<script>\nalert('" . addslashes($e['message']) . " : " . addslashes($e['message']) . "');\nlocation = '" . $HTTP_REFERER . "';\n</script>");
        } else {
            echo("<script>\nalert('Oracle Error');\nlocation = '" . $HTTP_REFERER . "';\n</script>");
        }
        exit;
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
        //$array_split_item[0] = "-";
        $block_chars = array("--", ";", "/*", "*/", "@@", "char", "nchar", "varchar", "nvarchar", "alter", "begin", "cast", "create", "cursor", "declare", "delete", "drop", "end", "exec", "execute", "fetch", "insert", "kill", "open", "select", "sys", "sysobjects", "syscolumns", "table", "update", "<script", "</script>", "'");
        //$block_schars = array ("|","-", ";", "/*", "*/", "@@", "@", "&", ";", "$", "%", "&", "'", "\"", "\\'", "\\"", "<>", "()", "+", ",","\");

        for ($i = 0; $i < count($block_chars); $i++) {
            if (substr_count(" " . $param, $block_chars[$i])) {
                $this->sql_injection_result = false;
                $this->saveSqlInjectionLog("Check-" . $block_chars[$i] . ": " . $param);
                exit;
            }
        }
        return $param;
    }

    function saveSqlInjectionLog($log_txt) {
        $write = date('Y-m-d H:i:s') . " " . $this->sql . "\t";
        $write = $write . $log_txt . "\n";
        $path = $_SERVER["DOCUMENT_ROOT"] . "/_logs/";

        if (!is_dir($path)) {
            mkdir($path, 0777);
            chmod($path, 0777);
        } else {
            //chmod($path,0777);
        }


        $fp = fopen($_SERVER["DOCUMENT_ROOT"] . "/_logs/sql_injection_log.txt", "a+");
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
        //echo "test";
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
            $result = oci_query('EXPLAIN ' . $sql) or die(oci_error());
            $outHTML .= '<div style="padding:3px;border:1px solid #AAAAAA;margin:5px;width:800px;">' . $sql . '</div>';
            $outHTML .= '<table border="1" cellpadding="3" cellspacing="1" style="border-collapse:collapse;border-color:#AAAAAA;margin:5px;"><tr bgcolor="#E3E3E3" align="center"><td>id</td><td>select_type</td><td>table</td><td>type</td><td>possible_keys</td><td>key</td><td>key_len</td><td>ref</td><td>rows</td><td>Extra</td></tr>';

            while ($row = oci_fetch_assoc($result)) {
                $arr_table[] = $row['table'];
                $ut_eSelectType[] = $row['select_type'];
                $ut_eType[] = $row['type'];
                $ut_eMaxKeyLen[] = $row['key_len'];
                $ut_eMaxRows[] = $row['rows'];
                $type_s = ($row['type'] == 'ALL') ? ' style="color:#FF0000;font-weight:bold;"' : '';
                $rows_s = ($row['rows'] > 1000) ? ' style="color:#FF0000;"' : '';
                $outHTML .= '<tr bgcolor="#FFFFFFF"><td>' . $row['id'] . '</td><td>' . $row['select_type'] . '</td><td>' . $row['table'] . '</td><td' . $type_s . '>' . $row['type'] . '</td><td>' . $row['possible_keys'] . '</td><td>' . $row['key'] . '</td><td>' . $row['key_len'] . '</td><td>' . $row['ref'] . '</td><td' . $rows_s . '>' . $row['rows'] . '</td><td>' . $row['Extra'] . '</td></tr>';
            }
            $outHTML .= '</table>';
        }
        //if($_SESSION['admininfo']['charger_id'] == 'caesar')	echo $outHTML;
        // 로그 저장
        $uq_querys = '';
        $ut_querys = array();
        preg_match_all('/admin_log|admin_log_test|bbs_after|bbs_after_comment|bbs_b2b_notice|bbs_b2b_notice_comment|bbs_b2b_qna|bbs_b2b_qna_comment|bbs_counsel|bbs_counsel_comment|bbs_faq|bbs_faq2|bbs_free_boad|bbs_free_boad_comment|bbs_manage_config|bbs_manage_div|bbs_notice|bbs_notice_comment|bbs_qna|bbs_qna5|bbs_qna_comment|bbs_spam_config|bbs_templete|bbs_unconfirmed|bbs_unconfirmed_comment|blog_basicinfo|blog_bbs|blog_bbs_comment|blog_bbs_group|blog_bbs_manage|cafe_basicinfo|cafe_bbs|cafe_bbs_comment|cafe_bbs_group|cafe_bbs_manage|cafe_member|co_product|co_sellershop_apply|co_sellershopinfo|commerce_salestack|commerce_viewingview|con_log|inventory_company_info|inventory_info|inventory_info_productorder|inventory_input_history|inventory_input_history_detail|inventory_output_history|logstory_ByKeyword|logstory_ByReferer|logstory_ByetcReferer|logstory_DurationTime|logstory_PageViewTime|logstory_banner_click|logstory_bypage|logstory_etchost|logstory_etcrefererinfo|logstory_keywordinfo|logstory_main_mdgoods_click|logstory_maingoods_click|logstory_memberreg_stack|logstory_pageinfo|logstory_pageviewtime|logstory_referer_categoryinfo|logstory_refererurl|logstory_revisittime|logstory_time|logstory_visitor|logstory_visitorinfo|logstory_visittime|shop_accounts|shop_addimage|shop_addressbook|shop_addressbook_group|shop_admin_favorite|shop_auction_list|shop_bankinfo|shop_bannerinfo|shop_bbs_group|shop_bbs_useafter|shop_brand|shop_buyingservice_info|shop_cart|shop_cash_info|shop_category_addfield|shop_category_info|shop_code|shop_company|shop_company_department|shop_company_position|shop_cooperation|shop_cupon|shop_cupon_publish|shop_cupon_regist|shop_cupon_relation_brand|shop_cupon_relation_category|shop_cupon_relation_product|shop_design|shop_dropmember|shop_estimate_category|shop_estimate_relation|shop_estimates|shop_estimates_detail|shop_event|shop_event_info|shop_event_product_group|shop_event_product_relation|shop_gift_certificate|shop_groupinfo|shop_html_library|shop_icon|shop_image_resizeinfo|shop_join_info|shop_layout_info|shop_mail_box|shop_mail_taget|shop_mailling_history|shop_mailsend_config|shop_main_product_group|shop_main_product_relation|shop_manage_flash|shop_manual|shop_my_friend|shop_order|shop_order_delivery|shop_order_detail|shop_order_gift|shop_order_memo|shop_order_status|shop_orders_|shop_pageinfo|shop_poll_field|shop_poll_group|shop_poll_result|shop_poll_title|shop_popup|shop_priceinfo|shop_product|shop_product_auction|shop_product_buyingservice_priceinfo|shop_product_displayinfo|shop_product_options_detail|shop_product_options|shop_product_photo|shop_product_qna|shop_product_qna2|shop_product_relation|shop_promotion_div|shop_promotion_goods|shop_promotion_goods_relation|shop_qna|shop_recommend|shop_recommend_div|shop_recommend_product_relation|shop_region_delivery|shop_relation_product|shop_reserve_info|shop_search_count|shop_search_keyword|shop_shopinfo|shop_sms_regist|shop_taxbill|shop_taxbill_detail|shop_taxbill_status|shop_tmp|shop_wishlist|shop_zip|receipt|receipt_result|recipe_category|search_popular|view_goods_saleprice|work_group|work_list|work_quick|work_tmp/', $sql, $table);
        $qi = 0;
        foreach ($table[0] as $_key => $_val) {
            //echo strpos($sql, $_val);
            $tmp = explode(' ', str_replace(array('  ', ','), array(' ', ''), $sql));
            $tbKey = array_search($_val, $tmp);
            if (($eKey = array_search($tmp[$tbKey], $arr_table)) !== false) {
                $tbName = $tmp[$tbKey];
            } else if (($eKey = array_search($tmp[$tbKey + 1], $arr_table)) !== false) {
                $tbName = $tmp[$tbKey];
            } else {
                $eKey = null;
            }
            $type = explode(' ', $sql);
            $type = strtoupper($type[0]);
            $result = oci_query('SELECT COUNT(*) FROM useQuery uq INNER JOIN useTable ut ON ut.uq_idx = uq.uq_idx WHERE uq.uq_location = "' . $_SERVER['PHP_SELF'] . '" AND uq.uq_type = "' . $type . '" AND ut.ut_tableName = "' . $_val . '" AND ut.ut_selectType = "' . $ut_eSelectType[$eKey] . '" AND ut.ut_type = "' . $ut_eType[$eKey] . '"') or die(oci_error());
            $row = oci_fetch_row($result);
            if (!$row[0]) {
                $uq_querys = '("' . $type . '","' . $_SERVER['PHP_SELF'] . '","' . $_SERVER['QUERY_STRING'] . '","' . addslashes($sql) . '", NOW())';
                $ut_querys[$qi][] = 'ut_tableName = "' . $_val . '"';
                $ut_querys[$qi][] = 'ut_selectType = "' . $ut_eSelectType[$eKey] . '"';
                $ut_querys[$qi][] = 'ut_type = "' . $ut_eType[$eKey] . '"';
                $ut_querys[$qi][] = 'ut_maxKeyLen = "' . $ut_eMaxKeyLen[$eKey] . '"';
                $ut_querys[$qi][] = 'ut_rows = "' . $ut_eMaxRows[$eKey] . '"';
                $qi++;
            }
        }
        if (count($ut_querys) > 0) {
            //echo 'INSERT INTO useQuery (uq_type, uq_location, uq_param, uq_sql, uq_regdate) VALUES '.$uq_querys;
            oci_query('INSERT INTO useQuery (uq_type, uq_location, uq_param, uq_sql, uq_regdate) VALUES ' . $uq_querys) or die(oci_error());
            $uq_idx = oci_insert_id();
            foreach ($ut_querys as $_key2 => $_val2) {
                $_val2[] = 'uq_idx = ' . $uq_idx;
                oci_query('INSERT INTO useTable SET ' . implode(',', $_val2)) or die(oci_error());
            }
        }
    }

}
