<?php
if (!isset($_SERVER['HTTP_HOST'])) {
    throw new Exception('$_SERVER["HTTP_HOST"] variable not defined');
} else {
    @ob_start('ob_gzhandler');

    // Common require
    require_once __DIR__.'/ForbizCommon.php';

    // LOAD THE BOOTSTRAP FILE
    require_once APPPATH.'core/ForbizCore.php';
}
