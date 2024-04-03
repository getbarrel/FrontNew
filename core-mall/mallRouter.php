<?php
/*
 * Fobiz Framework Load
 */
// ** 기본 설정 파일
require_once(__DIR__.'/forbiz.config.php');

return (function() {
        $fb        = getForbiz();
        $className = $fb->router->fetch_method();

        // 정기 비밀번호 변경 확인
        switch ($fb->uri->uri_string) {
            case 'member/password':
            case 'controller/member/changePassword':
            case 'controller/member/passwordContinue':
                break;
            default:
                if (ForbizConfig::getChangePasswordSession() && $fb->uri->uri_string != 'member/logout') {
                    // 비밀번호 변경으로 이동
                    redirect('/member/password');
                }
                break;
        }

        // Framework 연동
        if ($className != 'index') {
            if ($className == 'controller') {
                $params    = getForbiz()->router->fetch_params();
                $className = array_shift($params);
                $app       = getForbiz()->router->getRoutingApp('mall', $className, $params);
                if (is_object($app)) {
                    $app->run();
                    return false;
                } else {
                    show_404();
                }
            } else {
                $path = [];
                foreach ($fb->uri->segments as $segment) {
                    $path[]   = $segment;
                    $routeUri = implode('/', $path);

                    $viewFilePath = (is_cli() ? '' : $_SERVER['DOCUMENT_ROOT']).'/'.$routeUri.'.view.php';

                    if (file_exists($viewFilePath)) {
                        $fb->router->setRouteUri($routeUri);
                        $fb->router->setParams(array_values(array_diff($fb->uri->segments, $path)));

                        // require ViewController
                        require($viewFilePath);

                        return false;
                    }
                }

                show_404();
            }
        } else {
            return true;
        }
    })();

