<?php
// Class Autoloader
spl_autoload_register(function($class) {
    if ($class == 'ForbizConfig') {
        require_once(CUSTOM_CONFIG_PATH.'/ForbizConfig.class.php');
    } elseif (strncmp($class, 'Forbiz', 6) === 0 || strncmp($class, 'Custom', 6) === 0) {
        $cword = preg_split('/(?=[A-Z])/', $class);
        $type  = array_pop($cword);
        if (isset($cword[2])) {
            $package = strtolower($cword[2]).'/';

            if ($cword[1] === 'Forbiz') {
                $clasFilePath = ($type == 'Controller' ? FORBIZCONTROLLERPATH : FORBIZMODELPATH)."{$package}{$class}.class.php";
            } else {
                $clasFilePath = ($type == 'Controller' ? CUSTOMCONTROLLERPATH : CUSTOMMODELPATH)."{$package}{$class}.class.php";
            }

            if (file_exists($clasFilePath)) {
                require_once($clasFilePath);
            }
        }
    } else {
        if (function_exists('log_message') && $GLOBALS['CFG']->item('log_threshold') > 1) {
            $backLog = debug_backtrace(0)[2];
            log_message('debug', $_SERVER['REQUEST_URI'].'('.json_encode($backLog).') - ', $class);
        }
    }
});

/**
 * php 7.x 제거된 함수 지원용
 */
if (!function_exists('session_register')) {

    function session_register()
    {
        $args = func_get_args();
        foreach ($args as $key) {
            $_SESSION[$key] = $GLOBALS[$key];
        }
    }
}

if (!function_exists('session_is_registered')) {

    function session_is_registered($key)
    {
        return isset($_SESSION[$key]);
    }
}

if (!function_exists('session_unregister')) {

    function session_unregister($key)
    {
        unset($_SESSION[$key]);
    }
}

if (!function_exists('sess_val')) {

    function sess_val(string ...$keys)
    {
        switch (count($keys)) {
            case 4:
                return $_SESSION[$keys[0]][$keys[1]][$keys[2]][$keys[3]] ?? '';
                break;
            case 3:
                return $_SESSION[$keys[0]][$keys[1]][$keys[2]] ?? '';
                break;
            case 2:
                return $_SESSION[$keys[0]][$keys[1]] ?? '';
                break;
            case 1:
                return $_SESSION[$keys[0]] ?? '';
                break;
            default:
                return '';
                break;
        }
    }
}

if (!function_exists('cook_val')) {

    function cook_val(string ...$keys)
    {
        switch (count($keys)) {
            case 4:
                return $_COOKIE[$keys[0]][$keys[1]][$keys[2]][$keys[3]] ?? '';
                break;
            case 3:
                return $_COOKIE[$keys[0]][$keys[1]][$keys[2]] ?? '';
                break;
            case 2:
                return $_COOKIE[$keys[0]][$keys[1]] ?? '';
                break;
            case 1:
                return $_COOKIE[$keys[0]] ?? '';
                break;
            default:
                return '';
                break;
        }
    }
}

if (!function_exists('gVal')) {

    function gVal(...$keys)
    {
        switch (count($keys)) {
            case 1:
                return $GLOBALS[$keys[0]] ?? '';
                break;
            case 2:
                return $GLOBALS[$keys[0]][$keys[1]] ?? '';
                break;
            case 3:
                return $GLOBALS[$keys[0]][$keys[1]][$keys[2]] ?? '';
                break;
            case 4:
                return $GLOBALS[$keys[0]][$keys[1]][$keys[2]][$keys[3]] ?? '';
                break;
            default:
                return '';
                break;
        }
    }
}

if (!function_exists('is_mobile')) {

    function is_mobile()
    {
        //PC에서도 확인할 수 있도록
        if (strtolower(substr($_SERVER["HTTP_HOST"], 0, 2)) == "m.") {
            //m 도메인 접근시 PC버전 사용 세션 제거
            $_SESSION['use_pc_version'] = 'N';
            return true;
        } elseif (sess_val('use_pc_version') == 'Y') {
            //PC버전 사용시 FALSE 리턴
            return false;
        } elseif (sess_val("is_webview") == true) {
            //webview check
            return true;
        } else {
            return _is_mobile();
        }
    }
}

if (!function_exists('is_login')) {

    function is_login($type = 'check', $redirectUrl = '/member/login')
    {
        $loginBool = sess_val('user', 'code');
        if ($type == 'redirect') {
            if (!$loginBool) {
                redirect($redirectUrl."?url=".urlencode($_SERVER['REQUEST_URI']));
            }
        }
        return $loginBool;
    }
}