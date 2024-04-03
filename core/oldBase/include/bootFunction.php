<?php

// Log 기록 함수
function bootLog()
{
    $qb = getForbiz()->qb;

//    $db        = gVal('db');
    $admininfo = gVal('admininfo');
    $act       = gVal('act');

    // Admin log 작성
    if (strpos($_SERVER['PHP_SELF'], '/admin/') !== false && strpos($_SERVER['PHP_SELF'], 'admin.php') === false && strpos($_SERVER['PHP_SELF'],
            'language.php') === false && strpos($_SERVER['PHP_SELF'], '/v3/include/') === false) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $send_data = serialize($_POST);
        } else {
            $send_data = $_SERVER["QUERY_STRING"];
        }

        $http_host = $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];

        $qb
            ->set('log_ix', '')
            ->set('admin_code', $admininfo['charger_ix'])
            ->set('admin_id', $admininfo['charger_id'])
            ->set('admin_name', $admininfo['charger'])
            ->set('act', $act)
            ->set('ip', $_SERVER["REMOTE_ADDR"])
            ->set('request_method', $_SERVER["REQUEST_METHOD"])
            ->set('http_host', $http_host)
            ->set('send_data', $send_data)
            ->set('regdate', 'NOW()', false);


        if (strpos($act, 'insert') !== false) {
            $qb->set('crud_div', 'C');
//            $sql = "INSERT INTO admin_log_new(log_ix, admin_code, admin_id, admin_name, crud_div, act, ip, request_method, http_host, send_data, regdate) VALUES ('', '".$admininfo['charger_ix']."', '".$admininfo['charger_id']."', '".$admininfo['charger']."', 'C', '".$act."', '".$_SERVER["REMOTE_ADDR"]."', '".$_SERVER["REQUEST_METHOD"]."', '".$http_host."', '".$send_data."', NOW())";
        } else if (strpos($act, 'update') !== false) {
            $qb->set('crud_div', 'U');

//            $sql = "INSERT INTO admin_log_new(log_ix, admin_code, admin_id, admin_name, crud_div, act, ip, request_method, http_host, send_data, regdate) VALUES ('', '".$admininfo['charger_ix']."', '".$admininfo['charger_id']."', '".$admininfo['charger']."', 'U', '".$act."', '".$_SERVER["REMOTE_ADDR"]."', '".$_SERVER["REQUEST_METHOD"]."', '".$http_host."', '".$send_data."', NOW())";
        } else if (strpos($act, 'delete') !== false) {
            $qb->set('crud_div', 'D');
//            $sql = "INSERT INTO admin_log_new(log_ix, admin_code, admin_id, admin_name, crud_div, act, ip, request_method, http_host, send_data, regdate) VALUES ('', '".$admininfo['charger_ix']."', '".$admininfo['charger_id']."', '".$admininfo['charger']."', 'D', '".$act."', '".$_SERVER["REMOTE_ADDR"]."', '".$_SERVER["REQUEST_METHOD"]."', '".$http_host."', '".$send_data."', NOW())";
        } else {
            $qb->set('crud_div', 'R');
//            $sql = "INSERT INTO admin_log_new(log_ix, admin_code, admin_id, admin_name, crud_div, act, ip, request_method, http_host, send_data, regdate) VALUES ('', '".$admininfo['charger_ix']."', '".$admininfo['charger_id']."', '".$admininfo['charger']."', 'R', '".$act."', '".$_SERVER["REMOTE_ADDR"]."', '".$_SERVER["REQUEST_METHOD"]."', '".$http_host."', '".$send_data."', NOW())";
        }

        $qb->insert('admin_log_new')->exec();
    }

    //로그인 정보(세션유지) 로그기록 하기 JK160211
    if (sess_val('privacy_config', 'login_fail_info') == 'Y' && sess_val('user')) {
        ConnectUserLog(sess_val('user', 'id'), sess_val('user', 'code'), 'maintain');
    }
}

// 점검 함수
function bootCheck()
{
//    $get_server_domain = str_replace("www.", "", $_SERVER["SERVER_NAME"]);
//    모바일 리다이렉트 제외 목록
//    $not_mobile_site     = array(
//        "omnichannel.forbiz.co.kr"
//    );
//    $is_mobile_domain  = substr($get_server_domain, 0, 2);
//    $is_not_mobile_query = ($_GET["not_mobile"] ?? ''); //모바일 PC버전보기 구분값
//
//    // 모바일 도메인 체크
//    if (!in_array($get_server_domain, $not_mobile_site)) {
//        if (is_mobile() && $is_mobile_domain != "m." && $is_not_mobile_query == "" && $_SESSION['use_pc_version'] != 'Y') {
//            if ($linkprice == "Y") {
//                header("Location://m.".$get_server_domain);
//            } else {
//                header("Location://m.".$get_server_domain.$_SERVER['REQUEST_URI']);
//            }
//            exit;
//        }
//    }
}

// 환경 설정
function bootConfig()
{
    // db 객체
    $qb            = getForbiz()->qb;
    $layout_config = gVal('layout_config');
    $admininfo     = gVal('admininfo');

    // 프라이버시 설정
    $sql = "SHOW TABLES LIKE 'shop_mall_privacy_setting'";
    $qb->exec($sql);
    if (!$qb->total) {
        $sql = "CREATE TABLE `shop_mall_privacy_setting` (
		  `mall_ix` varchar(32) NOT NULL COMMENT '쇼핑몰키',
		  `config_name` varchar(100) NOT NULL DEFAULT '' COMMENT '변수이름',
		  `config_value` varchar(255) DEFAULT NULL COMMENT '변수값',
		  PRIMARY KEY (`mall_ix`,`config_name`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='쇼핑몰 개인정보 설정 정보';
	";
        $qb->exec($sql);
    }

//    $rows = $qb->exec("SELECT * FROM shop_mall_privacy_setting where mall_ix in ('".($layout_config['mall_ix'] ?? '')."','".($admininfo['mall_ix'] ?? '')."')")->getResultArray();
    $rows = $qb
        ->from('shop_mall_privacy_setting')
        ->whereIn('mall_ix', [($layout_config['mall_ix'] ?? ''), ($admininfo['mall_ix'] ?? '')])
        ->exec()
        ->getResultArray();

    if (!empty($rows)) {
        foreach ($rows as $row) {
            if ($row['config_name'] == 'pw_combi' || $row['config_name'] == 'pw_continuous_check' || $row['config_name'] == 'pw_same_check') {
                $_SESSION['privacy_config'][$row['config_name']] = json_decode($row['config_value'], true);
            } else {
                $_SESSION['privacy_config'][$row['config_name']] = $row['config_value'];
            }
        }
    }

    // viewtype 설정
    if (($_GET["viewtype"] ?? '') == "analysis") {
        $_SESSION["viewtype"] = 'analysis';
    }
    // PC 버전 사용 여부 체크
    if (($_GET['use_pc_version'] ?? '') == 'Y' || ($_GET["not_mobile"] ?? '') == 'Y' || sess_val('use_pc_version') == 'Y') {
        $_SESSION['use_pc_version'] = 'Y';
    } else {
        $_SESSION['use_pc_version'] = 'N';
    }

    // APP_TYPE 설정
    if (sess_val('app_type') == '') {
        if (cook_val('APP-TYPE') != '') {
            setcookie("APP-TYPE", $_COOKIE['APP-TYPE'], 0, "/");
            $_SESSION['app_type'] = $_COOKIE['APP-TYPE'];
        }
    }

    // DEVICE-ID 설정
    if (sess_val('device_id') == '' && sess_val('app_type') != '') {
        if ($_COOKIE['DEVICE-ID'] != '') {
            setcookie("DEVICE-ID", $_COOKIE['DEVICE-ID'], 0, "/");
            $_SESSION['device_id'] = $_COOKIE['DEVICE-ID'];
        }
    } else if (sess_val('device_id') != cook_val('DEVICE-ID')) {
        setcookie("DEVICE-ID", $_COOKIE['DEVICE-ID'], 0, "/");
        $_SESSION['device_id'] = $_COOKIE['DEVICE-ID'];
    }

    // APP-VERSION 설정
    if (sess_val('app_version') == '' && sess_val('app_type') != '') {
        if ($_COOKIE['APP-VERSION'] != '') {
            setcookie("APP-VERSION", $_COOKIE['APP-VERSION'], 0, "/");
            $_SESSION['app_version'] = $_COOKIE['APP-VERSION'];
        }
    } else if (sess_val('app_version') != cook_val('APP-VERSION')) {
        setcookie("APP-VERSION", $_COOKIE['APP-VERSION'], 0, "/");
        $_SESSION['app_version'] = $_COOKIE['APP-VERSION'];
    }

    // Header Top View 설정
    if (cook_val('Header_Top_View') == 'Y') {
        $_SESSION['m_header_top_view'] = "Y";
    }
}

// 언어 설정
/*
// core/helper/common.helper.php 로 이동
function bootLangSet()
{
    $qb = getForbiz()->qb;

    // 언어설정
    if (sess_val("layout_config", "mall_domain") != $_SERVER['HTTP_HOST']) {
        $_SESSION["layout_config"]["front_language"] = "";
    }

    if (empty(sess_val("layout_config", "front_language"))) {
        $domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);

        if (substr($_SERVER['HTTP_HOST'], 0, 2) != 'm.') {
//            $sql = "select * from ".TBL_SHOP_SHOPINFO." where mall_domain = '{$domain}'";
            $qb->where('mall_domain', $domain);
        } else {
//            $sql = "select * from ".TBL_SHOP_SHOPINFO." where mall_mobile_domain = '{$domain}'";
            $qb->where('mall_mobile_domain', $domain);
        }

        $row = $qb
            ->from(TBL_SHOP_SHOPINFO)
            ->exec()
            ->getRowArray();

//        $db->query("SELECT config_value FROM `shop_mall_config` where mall_ix = '".$row['mall_ix']."' and config_name='nation_code' ");
//        $db->fetch();
        $row = $qb
            ->select('config_value')
            ->from('shop_mall_config')
            ->where('mall_ix', $row['mall_ix'])
            ->where('config_name', 'nation_code')
            ->exec()
            ->getRowArray();

        $sql = "SELECT gn.nation_name,gn.nation_code, gc.currency_name, gc.currency_code, gc.currency_unit_front, gc.currency_unit_back, gl.language_name, gl.language_code
			FROM global_nation gn
			left join global_currency gc on gn.currency_ix  = gc.currency_ix
			left join global_language gl on gn.language_ix  = gl.language_ix
		WHERE
			gn.nation_code='".$row['config_value']."' ";
        $row = $qb->exec($sql)->getResultArray();

        if (!empty($row)) {
            $front_language                       = $row['language_code'] ?? '';
            $layout_config["currency_unit_front"] = $row['currency_unit_front'] ?? '';
            $layout_config["currency_unit_back"]  = $row['currency_unit_back'] ?? '';
        } else {
            $front_language                       = "korean";
            $layout_config["currency_unit_front"] = "";
            $layout_config["currency_unit_back"]  = "원";
        }

        if ($front_language == 'korea') {
            $front_language = 'korean';
        }

        $_SESSION["layout_config"]["front_language"]      = $front_language;
        $_SESSION["layout_config"]["currency_unit_front"] = $layout_config["currency_unit_front"];
        $_SESSION["layout_config"]["currency_unit_back"]  = $layout_config["currency_unit_back"];
    } else {
        $front_language = $_SESSION["layout_config"]["front_language"];
    }


    // 언어파일 경로

    $_SESSION["layout_config"]["front_language"] = 'korean';
    $front_language                              = 'korean';
    return DOCUMENT_ROOT."/data/".MALL_ID."_data/_language/".$front_language."/*.php";
}
*/

// 부트 로그
bootLog();
// 점검 및 리다이렉트
bootCheck();
// 부트 설정
bootConfig();
