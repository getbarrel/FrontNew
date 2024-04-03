<?php
// ** 전역 변수 설정
require_once(OLDBASE_ROOT."/include/config.php");

// 보안점검
// define("__CASTLE_PHP_VERSION_BASE_DIR__", OLDBASE_ROOT."/castle");
// require_once(__CASTLE_PHP_VERSION_BASE_DIR__."/castle_referee.php");

// ** DB DRIVER LOAD
require_once(OLDBASE_ROOT."/class/mysqli.class.php");

// ** boot 함수 로딩
// require_once(OLDBASE_ROOT."/include/bootFunction.php");

// 전역 함수 로딩
// require_once(OLDBASE_ROOT."/include/global_util.php");
// require_once(OLDBASE_ROOT."/include/lib.function.php");

// 삭제 예정 ---------------
// require_once(OLDBASE_ROOT."/admin/include/lib/number.function.php");
// require_once(OLDBASE_ROOT."/include/option.lib.php");
// require_once(OLDBASE_ROOT."/include/ms_util.php");
//require_once(OLDBASE_ROOT."/include/design.tmp.php");
//require_once(OLDBASE_ROOT."/include/menu.tmp.php");
//require_once(OLDBASE_ROOT."/include/category.tmp.php");

// bbs 관련 함수 로딩
//require_once(OLDBASE_ROOT."/bbs/bbs.lib.php");
//require_once(OLDBASE_ROOT."/include/dir.manage.php");
//require_once(OLDBASE_ROOT."/admin/lib/imageResize.lib.php");
//require_once(OLDBASE_ROOT."/bbs/bbs.php");
// 삭제 예정 ---------------

// Core class include End
// 전역변수 Extract
/* * *****************************************************************************
 * 에러 리포팅 설정과 register_globals_on일때 변수 재 정의
 * **************************************************************************** */
// error_reporting(E_ALL);

// BusinessLogic 객체 생성
//$bl        = new BusinessLogic();