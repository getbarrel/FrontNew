<?php
/**
 * 코어 클래스 Autoloader
 */
spl_autoload_register(function($class) {

    switch ($class) {
        case 'Forbiz':
        case 'ForbizCli':
        case 'ForbizController':
        case 'ForbizAdminController':
        case 'ForbizModel':
        case 'ForbizView':
        case 'ForbizTest':
            require_once(APPPATH."/core/{$class}.class.php");
            break;
        case 'ForbizAdminInfo':
        case 'ForbizUserInfo':
        case 'ForbizCoreConfig':
        case 'ForbizExcel':
        case 'NunaCacheRedis':
        case 'NunaCacheFile':
        case 'NunaCacheMemcached';
            require_once(FORBIZ_CLASS_PATH."{$class}.class.php");
            break;
        case 'CI_Driver_Library':
            require_once(THIRDPARTYPATH.'/vendor/codeigniter/framework/system/libraries/Driver.php');
            break;
        default:
            if (strncmp($class, 'PgForbiz', 8) === 0) {
                if (defined('FORBIZ_MALL_VERSION')) {
                    require_once(CUSTOM_ROOT."/payment/{$class}.class.php");
                } elseif(defined('FORBIZ_SCM_VERSION')) {
                    require_once(APPLICATION_ROOT."/payment/{$class}.class.php");
                }
            } elseif (strncmp($class, 'MsgForbiz', 9) === 0) {
                if (defined('FORBIZ_MALL_VERSION')) {
                    require_once(CUSTOM_ROOT."/message/{$class}.class.php");
                } elseif(defined('FORBIZ_SCM_VERSION')) {
                    require_once(APPLICATION_ROOT."/message/{$class}.class.php");
                }
            } else {
                switch ($class) {
                    case 'Tag':
                        require_once(OLDBASE_ROOT."/class/{$class}.class.php");
                        break;
                    case 'forbizDatabase':
                    case 'CommerceDatabase':
                        require_once(OLDBASE_ROOT."/class/mysql.class.php");
                        break;
                    case 'forbizGather':
                    case 'BusinessLogic':
                    case 'MemberReg':
                    case 'Commerce':
                    case 'PageView':
                        require_once(OLDBASE_ROOT."/class/{$class}.class.php");
                        break;
                    case 'visit':
                        require_once(OLDBASE_ROOT."/class/Visit.class.php");
                        break;
                    case 'visitor':
                        require_once(OLDBASE_ROOT."/class/Visitor.class.php");
                        break;
                    case 'LayOut':
                    case 'NunaResult':
                    case 'Encryption':
                    case 'Shared':
                        require_once(FORBIZ_CLASS_PATH."{$class}.class.php");
                        break;
                    case 'Template_':
                        require_once(THIRDPARTYPATH.'Template_.2.2.8/Template_.class.php');
                        break;
                    case 'CI_DB':
                        break;
                }
            }
            break;
    }
});
