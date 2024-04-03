<?php
// DATABASE Driver
include_once(FORBIZ_CLASS_PATH.'ForbizMySQLi.class.php');

class Database extends ForbizMySQLi
{
    public function __construct($_db_host = "", $_db_user = "", $_db_pass = "", $_db_name = "", $_db_port = "3306")
    {
        parent::__construct($_db_host, $_db_user, $_db_pass, $_db_name, $_db_port);
    }
}

// 전역 Db 객체 생성 시작
$db        = new Database();
// master DB
$master_db = new Database;
$master_db->master_db_setting();
// slaver DB
$slave_db  = new Database;
$slave_db->slave_db_setting();
// Slave DB
$slave_mdb = new Database;
$slave_mdb->slave_db_setting();