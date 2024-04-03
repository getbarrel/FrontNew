<?php
$_SERVER['DOCUMENT_ROOT']   = realpath(__DIR__.'/../../application/www');
$_SERVER['HTTP_HOST']       = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
$_SERVER['HTTP_USER_AGENT'] = '';
$_SERVER['SERVER_NAME']     = $_SERVER['HTTP_HOST'];
$_SERVER['REQUEST_URI']     = '';

/*
 * Fobiz Framework Load
 */
// ** 기본 설정 파일
require_once(__DIR__.'/../../core-scm/forbiz.config.php');

// Common require
require_once __DIR__.'/ForbizCommon.php';

// LOAD THE BOOTSTRAP FILE
require_once APPPATH.'core/ForbizCoreCli.php';

