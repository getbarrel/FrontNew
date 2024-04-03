<?php
defined('USE_COLLECT') OR exit('No direct script access allowed');

if (!function_exists('get_collect_db')) {

    /**
     * Collect DB 객체를 가져온다.
     * @staticvar boolean $db
     * @return ForbizMySQLi
     */
    function get_collect_db(): ForbizMySQLi
    {
        static $db = false;

        if ($db === false) {
            $db = new ForbizMySQLi();
        }

        return $db->setDb(COLLECT_DB_CONN);
    }
}

if (!function_exists('db_esc_str')) {

    function db_esc_str($str)
    {
        return get_collect_db()->escape($str);
    }
}