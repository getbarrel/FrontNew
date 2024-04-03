<?php
defined('FORBIZ_BASEURL') OR exit('No direct script access allowed');

if (!function_exists('cafe24_password')) {

    /**
     * cafe24 비밀번호 해시
     * @param string $pw
     * @return string
     */
    function cafe24_password($pw)
    {
        return hash('sha256', md5($pw));
    }
}

if (!function_exists('makeshop_password')) {

    /**
     * 메이크샵 비밀번호 해시
     * @param string $user_id
     * @param string $user_pw
     * @return string
     */
    function makeshop_password($user_id, $user_pw)
    {
        $makeshop_id = ''; //메이크샵 쇼핑몰 샵아이디 필수
        return hash("sha512", md5($user_pw).$makeshop_id.$user_id);
    }
}

if (!function_exists('default_password')) {

    /**
     * 기본패스워드
     * @param string $pw
     * @return string
     */
    function default_password($pw)
    {
        return hash('sha256', $pw);
    }
}

if (!function_exists('encrypt_user_password')) {

    /**
     * 비밀번호를 암호화 합니다.
     * @param string $pw
     * @return string
     */
    function encrypt_user_password($pw, $id = '')
    {
        return default_password($pw);
    }
}

if (!function_exists('trans')) {

    /**
     * 문자열 번역
     * @param string $text
     * @param string $lang
     * @return string
     */
    function trans($text, $lang = 'kr')
    {
        return $text;
    }
}

if (!function_exists('sendMessage')) {

    /**
     * 이메일&SMS(또는 알림톡) 보내기
     * @param string $mcCode
     * @param string $email
     * @param string $mobile
     * @param array $templateData
     */
    function sendMessage($mcCode, $email, $mobile, $templateData)
    {
        $msg = new MsgForbiz();

        $templateData = $templateData ? $templateData : [];

        /* @var $triggerModel CustomMallTriggerModel */
        $triggerModel = getForbiz()->import('model.mall.trigger');

        $msgConfig = $triggerModel->getMsgConfig($mcCode);
        if (!empty($msgConfig)) {

            $templateData = array_merge($triggerModel->getCommonEmailTemplateData(), $templateData);

            //메일
            if (!empty($email) && $msgConfig->mc_mail_usersend_yn == 'Y') {
                $msg->protocol('email')
                    ->from(ForbizConfig::getCompanyInfo('com_email'))
                    ->to($email)
                    ->subject($msgConfig->mc_mail_title)
                    ->template($mcCode, $templateData)
                    ->send();
            }

            //SMS & 알림톡
            if (!empty($mobile)) {
                if ($msgConfig->mc_sms_usersend_yn == 'Y') {
                    //SMS
                    $msg->protocol('sms')
                        ->from(ForbizConfig::getCompanyInfo('com_phone'))
                        ->to(str_replace('-', '', $mobile))
                        ->template($mcCode, $templateData)
                        ->send();
                } else if ($msgConfig->mc_sms_usersend_yn == 'K') {
                    //알림톡
                    $msg->protocol('alimtalk')
                        ->to(str_replace('-', '', $mobile))
                        ->template($mcCode, $templateData)
                        ->send();
                }
            }
        }
    }
}

if (!function_exists('getLogPath')) {

    /**
     * 로그 경로 가지고 오기
     * @param type $dir
     * @return boolean|string
     */
    function getLogPath(...$dirs)
    {
        $path = MALL_DATA_PATH.'/_logs';
        if (!is_dir($path)) {
            if (!mkdir($path, 0777)) {
                return false;
            }
        }
        if (is_array($dirs)) {
            foreach ($dirs as $dir) {
                $path .= '/'.$dir;
                if (!is_dir($path)) {
                    if (!mkdir($path, 0777)) {
                        return false;
                    }
                }
            }
        }
        return $path;
    }
}

if (!function_exists('getAppType')) {

    /**
     * App 으로 접근하였는지 확인한다.
     * @return string
     */
    function getAppType()
    {
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            if (strstr($_SERVER['HTTP_USER_AGENT'], 'IOSApp')) {
                return 'iOS';
            } elseif (strstr($_SERVER['HTTP_USER_AGENT'], 'AOSApp')) {
                return 'Android';
            }
        }

        return false;
    }
}

if (!function_exists('fb_column')) {

    function fb_column($input, $index_key, $merge = false)
    {
        if (!empty($input)) {
            $output = [];

            foreach ($input as $key => $val) {
                if (array_key_exists($index_key, $val)) {
                    $key = $val[$index_key];
                }

                if($merge) {
                    $output[$key][] = $val;
                } else {
                    $output[$key] = $val;
                }
            }

            return $output;
        } else {
            return [];
        }
    }
}

if (!function_exists('fb_column_merge')) {

    function fb_column_merge($input, $index_key, $index_value)
    {
        if (!empty($input)) {
            $output = [];

            foreach ($input as $key => $val) {
                if (array_key_exists($index_key, $val)) {
                    $key = $val[$index_key];
                }

                $output[$key][] = $val[$index_value];
            }

            return $output;
        } else {
            return [];
        }
    }
}

if(!function_exists('fb_config')) {
    function fb_config($file_name)
    {
        $config_file = CUSTOM_ROOT . '/config/' . $file_name . '.php';
        if(file_exists($config_file)) {
            return include $config_file;
        } else{
            return [];
        }
        
    }
}
