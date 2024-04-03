<?php

class ForbizMySQLi
{
    public $dbms_type         = "mysql";
    public $dbcon;  // 링크 식별자
    public $db_host; // 디비 호스트
    public $db_user; // 디비 사용자
    public $db_pass; // 디비 비밀번호
    public $db_name; // 디비 이름
    public $db_port; // 디비 포트
    public $db_charset; // DB Charset
    public $result; // 쿼리 결과셋
    public $dt;  // 결과 데이터
    public $sql;
    public $sequences;
    public $debug;
    public $debug_data        = array();
    public $debug_remote_addr = array("221.151.188.10", "221.151.188.11", "127.0.0.1");
    public $error_display;
    public $sql_injection_result;
    public $ase_encrypt_key   = "";
    public $conn_name         = "";
    public $db                = false;
    public $framework         = false;
    public $dbInfo            = [];
    public $total;  // 쿼리 결과수
    protected $ip_addr;
    protected $lastExecTime;
    protected $aliveTime      = 60;

    public function __construct()
    {
        if(PHP_SAPI !== 'cli' && !defined('STDIN')) {
            if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP']) {
                $this->ip_addr = $_SERVER['HTTP_CLIENT_IP'];
            } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
                $this->ip_addr = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else if (isset($_SERVER['HTTP_X_FORWARDED']) && $_SERVER['HTTP_X_FORWARDED']) {
                $this->ip_addr = $_SERVER['HTTP_X_FORWARDED'];
            } else if (isset($_SERVER['HTTP_FORWARDED_FOR']) && $_SERVER['HTTP_FORWARDED_FOR']) {
                $this->ip_addr = $_SERVER['HTTP_FORWARDED_FOR'];
            } else if (isset($_SERVER['HTTP_FORWARDED']) && $_SERVER['HTTP_FORWARDED']) {
                $this->ip_addr = $_SERVER['HTTP_FORWARDED'];
            } else {
                $this->ip_addr = $_SERVER['REMOTE_ADDR'];
            }
        }else{
            $this->ip_addr = "127.0.0.1";
        }

        $dbConfigFile = CUSTOM_ROOT.'/config/database.php';

        if (file_exists($dbConfigFile)) {
            $this->lastExecTime = time();
            $this->dbcon        = [];
            $this->dbInfo       = require(CUSTOM_ROOT.'/config/database.php');
        } else {
            exit("DB Config file not found! [{$dbConfigFile}]");
        }
    }

    public function __destruct()
    {
        $this->close();
    }

    public function setDb($conn_name)
    {
        $this->conn_name = $conn_name;

        $this->db_host    = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['host'];
        $this->db_user    = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['user'];
        $this->db_pass    = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['pass'];
        $this->db_name    = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['name'];
        $this->db_port    = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['port'];
        $this->db_charset = $this->dbInfo[DB_CONNECTION_DIV][$this->conn_name]['char_set'];

        return $this->dbcon();
    }

    public function dbcon()
    {
        if (isset($this->dbcon[$this->conn_name]) === false || $this->dbcon[$this->conn_name] === false) {
            $this->dbcon[$this->conn_name] = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name, $this->db_port) OR $this->error();
            mysqli_query($this->dbcon[$this->conn_name], "set names ".$this->db_charset);
            mysqli_query($this->dbcon[$this->conn_name], "set lower_case_table_names = 1");
            mysqli_query($this->dbcon[$this->conn_name],
                "set session sql_mode='NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
            mysqli_select_db($this->dbcon[$this->conn_name], $this->db_name) OR $this->error();
        }

        return $this;
    }

    public function close()
    {
        $ret = false;

        if ($this->dbcon[$this->conn_name]) {
            $ret               = mysqli_close($this->dbcon[$this->conn_name]);
            $this->dbcon[$this->conn_name] = false;
        }

        return $ret;
    }

    public function query($sql)
    {
        static $nIdx = 1;

        $this->sql = $sql;

        if (!isset($this->dbcon[$this->conn_name])) {
            $this->setDb($this->conn_name);
        }

        if((time() - $this->lastExecTime) > $this->aliveTime) {
            $this->close();
            $this->dbcon();
        }

        $this->result       = mysqli_query($this->dbcon[$this->conn_name], $sql) or $this->error();
        $this->lastExecTime = time();

        if (preg_match('/^select|desc|show/i', strtolower($sql))) {
            $this->total();
        }

        return $this;
    }

    public function fetch($rows = 0)
    {
        if ($this->total > 0 && is_object($this->result)) {
            if (mysqli_data_seek($this->result, $rows)) {
                $this->dt = mysqli_fetch_assoc($this->result);
            } else {
                $this->dt = "";
            }
        } else {
            $this->dt = "";
        }

        return $this->dt;
    }

    public function fetchall()
    {
        $data = [];

        while ($row = mysqli_fetch_assoc($this->result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function insert_id()
    {
        return mysqli_insert_id($this->dbcon[$this->conn_name]);
    }

    public function getrows()
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

    public function total()
    {
        if (is_object($this->result)) {
            $this->total = mysqli_num_rows($this->result);
        } else {
            $this->total = 0;
        }

        return $this;
    }

    public function error()
    {
        if ($this->dbcon[$this->conn_name]) {
            //20130723 홍진영
            if (in_array($this->ip_addr, $this->debug_remote_addr)) {
                $error_msg = addslashes(mysqli_error($this->dbcon[$this->conn_name]));

                echo $error_msg.' : '.$this->sql;
            }
        }

        exit;
    }

    public function escape($str)
    {
        return mysqli_real_escape_string($this->dbcon[$this->conn_name], $str);
    }
}