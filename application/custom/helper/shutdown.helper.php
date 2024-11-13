<?php
return function() {
    // 접속 허용 IP
    date_default_timezone_set('Asia/Seoul');
    if ((time() >= strtotime('2024-11-14 02:00:00') && time() < strtotime('2024-11-14 04:00:00')) || (time() >= strtotime('2024-11-26 02:00:00') && time() < strtotime('2024-11-26 04:00:00'))  ) {
        $allowIpAddr = [
            '220.75.187.234' // 클라이언트 IP
            ,'221.151.188.10' // 포비즈 IP
            ,'221.151.188.11' // 포비즈 IP
            ,'127.0.0.1' // 개발 로컬 IP
            ,'211.55.49.54' //크리마팩토리 현재 아이피 IP
            ,'61.250.89.37' //크리마 프록시 IP
            ,'121.134.236.41' //크리마랩 사무실 고정 IP
            ,'210.122.73.58', '203.238.36.173', '103.215.144.173', '203.238.36.178', '103.215.144.174' //KCP 입금 통보 IP
            ,'121.128.108.188'//에이치엠파트너즈
            ,'61.39.229.249' //임우철(집)
			,'222.120.124.247'//황상흠차장님(자택)
			,'222.106.202.99'//배럴본사IP
            ,'218.48.123.15' //이커머스 담당자
            ,'1.229.54.170' //박현
            ,'221.168.43.164' //김동찬(집)
        ];
        if(PHP_SAPI !== 'cli' && !defined('STDIN')) {
            if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP']) {
                $ip_addr = $_SERVER['HTTP_CLIENT_IP'];
            } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']) {
                $ip_addr = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else if (isset($_SERVER['HTTP_X_FORWARDED']) && $_SERVER['HTTP_X_FORWARDED']) {
                $ip_addr = $_SERVER['HTTP_X_FORWARDED'];
            } else if (isset($_SERVER['HTTP_FORWARDED_FOR']) && $_SERVER['HTTP_FORWARDED_FOR']) {
                $ip_addr = $_SERVER['HTTP_FORWARDED_FOR'];
            } else if (isset($_SERVER['HTTP_FORWARDED']) && $_SERVER['HTTP_FORWARDED']) {
                $ip_addr = $_SERVER['HTTP_FORWARDED'];
            } else {
                $ip_addr = $_SERVER['REMOTE_ADDR'];
            }

            // 등록된 IP인지 확인한다.
            if (in_array($ip_addr, $allowIpAddr) === false) {
                return DOCUMENT_ROOT.'/etc/system.php';
            } else {
                return false;
            }
        }


    } else {
        return false;
    }
};
