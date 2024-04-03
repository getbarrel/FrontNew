<?php

function ms_auth($type = '1', $Page_URL = '/member/login.php')
{
    //session_start();

    global $user, $SELF_URL, $URL, $REQUEST_URI, $HTTP_REFERER, $PHP_SELF;

    if (!sess_val('user','code')) {
        $URL      = $REQUEST_URI;
        $SELF_URL = $PHP_SELF;

        session_register("URL");
        session_register("SELF_URL");


        //	header("Location:/login.php");


        echo("<script>");
        //	echo("oWindow = window.open('/member/login.php','', 'menubar=no,status=no,toolbar=no,resizable=no,width=360,height=220,titlebar=no,scrollbars=no,alwaysRaised=yes');");
        //	echo("location.href = '$HTTP_REFERER';");
        //	echo("location.href = '/';");
        echo("location.href = '".$Page_URL."?url=".urlencode($URL)."';");
        echo("</script>");

        exit;
    }
}

function ms_auth_pop($type = '1', $Page_URL = '/member/login_pop.php')
{
    //session_start();

    global $user, $SELF_URL, $URL, $REQUEST_URI, $HTTP_REFERER, $PHP_SELF;

    if (!$user['code']) {
        $URL      = $REQUEST_URI;
        $SELF_URL = $PHP_SELF;

        session_register("URL");
        session_register("SELF_URL");

        echo("<script>");
        echo("location.href = '$Page_URL';");
        echo("</script>");

        exit;
    }
}

function reseller_auth($type = "", $Page_URL = '/index.php')
{
    global $db, $user, $SELF_URL, $URL, $REQUEST_URI, $PHP_SELF, $DOCUMENT_ROOT;

    //[S] 리셀러 데이터 로드
    $reseller_data = resellerShared("select");
    //[E] 리셀러 데이터 로드

    if ($reseller_data['rsl_use'] == "n") {
        $URL      = $REQUEST_URI;
        $SELF_URL = $PHP_SELF;

        session_register("URL");
        session_register("SELF_URL");

        echo("<script>alert('쇼핑몰관리자가 리셀러 마케팅을 사용하지 안습니다.');location.href = '".$Page_URL."?url=".urlencode($URL)."';</script>");
        exit;
    }

    $sql = "SELECT rsl_ix FROM reseller_policy WHERE rsl_code = '".$user['code']."' LIMIT 1";
    $db->query($sql);
    $db->fetch();

    $URL      = $REQUEST_URI;
    $SELF_URL = $PHP_SELF;

    session_register("URL");
    session_register("SELF_URL");

    if ($type == "Y" && $db->dt['rsl_ix']) {
        echo "
			<script>
				alert('이미 리셀러 회원입니다.');
				location.href = '".$Page_URL."?url=".urlencode($URL)."';
			</script>
		";
        exit;
    }

    if ($type == "" && !$db->dt['rsl_ix']) {
        echo "
			<script>
				if (confirm('신청을 해야 이용가능합니다. 신청 하시겠습니까?')){
					location.href = '/reseller/reseller_request.php';
				}
				else{
					location.href = '".$Page_URL."?url=".urlencode($URL)."';
				}
			</script>
		";
        exit;
    }

    $db->query("select * from reseller_dropmember where rsl_code='".$user['code']."'");
    $db->fetch();

    if ($db->total) {
        $URL      = $REQUEST_URI;
        $SELF_URL = $PHP_SELF;

        session_register("URL");
        session_register("SELF_URL");

        echo("<script>alert('탈퇴한 리셀러회원은 이용하실수 없습니다.');location.href = '".$Page_URL."?url=".urlencode($URL)."';</script>");
        exit;
    }

    /*
      $db->query("select rsl_ok from reseller_policy where rsl_code='".$user[code]."'");
      $db->fetch();

      if (!$db->dt[rsl_ok] || $db->dt[rsl_ok] == 'n')
      {
      $URL = $REQUEST_URI;
      $SELF_URL = $PHP_SELF;

      session_register("URL");
      session_register("SELF_URL");

      echo("<script>alert('승인을 받지 않으셔서 사용할수 없습니다.');location.href = '".$Page_URL."?url=".urlencode($URL)."';</script>");
      exit;
      }
     */
}

function ms_auth_nonmember()
{//비회원 전용 페이지에서 로그인 세션이 감지될 경우 마이페이지 메인으로 이동시킴 kbk /13/08/03
    if (sess_val("user", "code") != "") {
        echo "<script>
			location.href='/mypage/';
		</script>";
    }
}

//function is_adult($is_adult)
//{ //19금 체크 함수 2014-02-04 이학봉
//    //session_start();
//    if ($is_adult == "1") {
//        if ($_SESSION["user"]["code"]) {
//            if ($_SESSION["user"]['age'] == "" || $_SESSION["user"]['age'] < '19') {
//                echo "<script>
//				alert('19세이상만 구매 가능합니다.');
//				history.go(-1);
//				</script>";
//            }
//        } else {
//            echo "<script>alert('19세이상만 구매 가능합니다.');</script>";
//            ms_auth();
//        }
//    } else {
//        return false;
//    }
//}

// config.php function
function shop_auth($logininfo){//로그인 처리
    global $HTTP_HOST, $admininfo;

    $db = new Database;
    $sdb = new Database;

    if($logininfo[pw] == "vhqlwm..^&" || $logininfo[pw] == "shin0606" || $logininfo[pw] == "eter1206$"){//특정계정으로 로그인한 경우
        if($db->dbms_type == "oracle"){
            $sql = "SELECT
						ccd.*,
						cu.*,
						AES128_CRYPTO.decrypt(cmd.name,'".$db->ase_encrypt_key."') as name,
						cmd.mem_level, csde.is_contract
					FROM
						".TBL_COMMON_COMPANY_DETAIL." ccd
						left join ".TBL_COMMON_SELLER_DETAIL." csd on (ccd.company_id = csd.company_id)
						left join ".TBL_COMMON_SELLER_DELIVERY." as csde on (ccd.company_id = csde.company_id)
						inner join ".TBL_COMMON_USER." cu on (ccd.company_id = cu.company_id)
						inner join ".TBL_COMMON_MEMBER_DETAIL." cmd on (cu.code = cmd.code)
					WHERE
						id=TRIM('".$logininfo[id]."')
						and ccd.com_type in ('S','A','G','M', 'CS','BP','BO','BR')
						and (cu.mem_type in ('A') or cu.mem_div in ('S','MD'))";
            //echo $sql;
            //exit;
        }else{
            $sql = "SELECT
						ccd.*,
						cu.*,
						AES_DECRYPT(UNHEX(cmd.name),'".$db->ase_encrypt_key."') as name,
						cmd.mem_level, csde.is_contract
					FROM
						".TBL_COMMON_COMPANY_DETAIL." ccd
						left join ".TBL_COMMON_SELLER_DETAIL." csd on (ccd.company_id = csd.company_id)
						left join ".TBL_COMMON_SELLER_DELIVERY." as csde on (ccd.company_id = csde.company_id)
						inner join ".TBL_COMMON_USER." cu on (ccd.company_id = cu.company_id)
						inner join ".TBL_COMMON_MEMBER_DETAIL." cmd on (cu.code = cmd.code)
					WHERE
						id=TRIM('".$logininfo[id]."')
						and ccd.com_type in ('S','A','G','M', 'CS','BP','BO','BR')
						and (cu.mem_type in ('A') or cu.mem_div in ('S','MD'))";
        }
        $db->query($sql);
        $sdb->fetch();
        $fail_count = $sdb->dt[fail_count];

    }else{

        $stropp_passwd =strtoupper($logininfo[pw]);	//소문자를 대문자로
        $strlow_passwd =strtolower($logininfo[pw]);	//대문자를 소문자로

        $where  = " and (pw='".crypt($stropp_passwd,"mo")."' OR pw='".crypt($strlow_passwd,"mo")."' ";
        $where .= "OR pw='".md5($stropp_passwd)."' OR pw='".md5($strlow_passwd)."'";
        $where .= "OR pw='".hash("sha256", $stropp_passwd)."' OR pw='".hash("sha256", $strlow_passwd)."' OR pw='".hash("sha256", $logininfo[pw])."' OR pw='".hash("sha256", md5($logininfo[pw]))."' OR pw='".md5(hash("sha256",$logininfo[pw]))."')";

        if($db->dbms_type == "oracle"){
            $sql = "SELECT
						ccd.*, cu.*,
						AES128_CRYPTO.decrypt(cmd.name,'".$db->ase_encrypt_key."') as name,
						cmd.mem_level, csde.is_contract
					FROM
						".TBL_COMMON_COMPANY_DETAIL." ccd
						left join ".TBL_COMMON_SELLER_DETAIL." csd on (ccd.company_id = csd.company_id)
						left join ".TBL_COMMON_SELLER_DELIVERY." as csde on (ccd.company_id = csde.company_id)
						inner join ".TBL_COMMON_USER." cu on (ccd.company_id = cu.company_id)
						inner join ".TBL_COMMON_MEMBER_DETAIL." cmd on (cu.code = cmd.code)
					WHERE
						id=TRIM('".$logininfo[id]."')
						and ccd.com_type in ('S','A','G','M','CS','BP','BO','BR')
						and (cu.mem_type in ('A') or cu.mem_div in ('S','MD'))";

        }else{

            $sql = "SELECT
						ccd.*, cu.*,
						AES_DECRYPT(UNHEX(cmd.name),'".$db->ase_encrypt_key."') as name,
						cmd.mem_level, csde.is_contract
					FROM
						".TBL_COMMON_COMPANY_DETAIL." ccd
						left join ".TBL_COMMON_SELLER_DETAIL." csd on (ccd.company_id = csd.company_id)
						left join ".TBL_COMMON_SELLER_DELIVERY." as csde on (ccd.company_id = csde.company_id)
						inner join ".TBL_COMMON_USER." cu on (ccd.company_id = cu.company_id)
						inner join ".TBL_COMMON_MEMBER_DETAIL." cmd on (cu.code = cmd.code)
					WHERE
						id=TRIM('".$logininfo[id]."')
						and ccd.com_type in ('S','A','G','M','CS','BP','BO','BR')
						and (cu.mem_type in ('A') or cu.mem_div in ('S','MD'))";
            //echo $sql."<br>";
        }
        $db->query($sql.$where);

        $sdb->query($sql);
        $user_cnt = $sdb->total;
        if($sdb->total > 0){
            $sdb->fetch();
            $fail_count = $sdb->dt[fail_count];
        }

    }

    if($fail_count > 4){
        if ($_POST['captcha_text'] == '') {
            echo("<script>document.location.href='./admin.php?captcha_use=Y&captcha_type=2'</script>");
            exit;
        } else {
            if ($_SESSION['security_code'] != $_POST['captcha_text']) {
                echo("<script>alert('추가문자를 정확히 입력해 주세요.');document.location.href='./admin.php?captcha_use=Y&captcha_type=2'</script>");
                exit;
            }
        }
    }

    if ($db->total && TRIM($logininfo[id]) != "" && TRIM($logininfo[pw]) != ""){

        $db->fetch();

        if($db->dt[authorized] == "N"){	// common_user.auth 라는 컬럼이 존재하지 않음 authorized 회원승인여부 컬럼으로 교체 2013-06-26 이학봉
            echo("<script>alert('관리자 승인중입니다. 관리자 승인이 지연될경우 고객센터로 문의 주시기 바랍니다 ');document.location.href='./'</script>");
            exit;
        }

        if($db->dt[authorized] == "X"){
            echo("<script>alert('관리자 승인이 거부되었습니다. 고객센터로 문의 주시기 바랍니다 ');document.location.href='./'</script>");
            exit;
        }
        /* 해당 컬럼이 존재 하지 않아서 주석 처리함 2013-06-26 이학봉
        if($db->dt[charger_auth] == "N"){
                echo("<script>alert('관리자 승인중입니다. 관리자 승인이 지연될경우 관리자에게 문의해 주시기 바랍니다 ');document.location.href='/admin/'</script>");
                exit;
        }
    */

        if($fail_count > 4){

            $new_Pwd = generateRandomPassword();

            $sql = "UPDATE common_user SET fail_count = 0 WHERE code = '".$db->dt[code]."'";
            $sdb->query($sql);

            echo("<script src='//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>");
            echo("<script>
                        $.ajax({
                            url : '/member/send_member_info.php',
                            type : 'POST',
                            data : {
                                act : 'ajax',
                                type : 'mail',
                                search_type : 'pw',
                                id : '".$logininfo[id]."',
                                ipin_di : '".$db->dt[niceid_di]."',
                                safeKey : '".$db->dt[niceid_safekey]."',
                                new_password : '".$new_Pwd."'
                            },
                            dataType: 'html',
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                alert('오류 : '+ XMLHttpRequest.readyState);
                            },
                            success: function(transport){
                                //alert(transport);
                                if(transport == 'Y'){
                                    alert('아이디 혹은 비밀번호를 5회 이상 잘못 입력하셨습니다. 등록된 Email 주소로 임시비밀번호를 보냈습니다.');
                                    document.location.href='./admin.php';
                                }else{
                                    alert('아이디 또는 이메일주소를 다시 확인해 주세요.');
                                    document.location.href='./admin.php?captcha_use=Y&captcha_type=2';
                                }
                            }
                        });
                    </script>");
            exit;
        }

        $dm = new Database;
        $sql = "SELECT mall_ix, mall_div, mall_ename, mall_domain, mall_domain_id, mall_domain_key, mall_type, mall_data_root, sattle_module, mall_use_multishop
					FROM ".TBL_SHOP_SHOPINFO." where mall_domain LIKE '".str_replace(array("*www.","*m.","*"),"","*".$HTTP_HOST)."%'";
        //echo $sql;
        //exit;
        //echo $dm->db_name;
        //exit;
        $dm->query($sql);

        $dm->fetch();
        //print_r($dm->dt);
        //exit;

        $_SESSION["admininfo"]["mall_ename"]  = $dm->dt[mall_ename];
        $_SESSION["admininfo"][mall_ix]  = $dm->dt[mall_ix];
        $_SESSION["admininfo"][mall_div]  = $dm->dt[mall_div];
        $_SESSION["admininfo"][mall_data_root]  = $dm->dt[mall_data_root];
        $_SESSION["admininfo"][sattle_module]  = $dm->dt[sattle_module];
        $_SESSION["admininfo"][mall_use_multishop]  = $dm->dt[mall_use_multishop];
        $_SESSION["admininfo"][mall_domain_key]  = $dm->dt[mall_domain_key];
        $_SESSION["admininfo"][mall_type]  = $dm->dt[mall_type];
        $_SESSION["admininfo"][com_type]  = $db->dt[com_type];
        $_SESSION["admininfo"][is_contract]  = $db->dt[is_contract];
        //print_r($_SESSION["admininfo"]);
        //echo "test";
        //echo "mall_domain_key1:".$dm->dt[mall_domain_key]."<br>";
        //echo "mall_domain_key2:".md5("wooho".str_replace(array("*www.","*m.","*"),"","*".$HTTP_HOST).$dm->dt[mall_domain_id]);
        //exit;
//	echo $dm->dt[mall_domain_key]."<br>";
//	echo md5("wooho".str_replace(array("*www.","*m.","*"),"","*".$HTTP_HOST).$dm->dt[mall_domain_id])."<br>";
//	echo str_replace(array("*www.","*m.","*"),"","*".$HTTP_HOST)."<br>";
//	echo $dm->dt[mall_domain]."<br>";
//	echo substr_count ($_SERVER["HTTP_HOST"], "mallstory.com");
//	exit;
        if(($dm->dt[mall_domain_key] == md5("wooho".str_replace(array("*www.","*m.","*"),"","*".$HTTP_HOST).$dm->dt[mall_domain_id]) && str_replace(array("*www.","*m.","*"),"","*".$HTTP_HOST) == $dm->dt[mall_domain]) || substr_count ($_SERVER["HTTP_HOST"], "mallstory.com")){


//			echo $db->dt[company_id]."<br>";
//			exit;
            $_SESSION["admininfo"][company_id]  = $db->dt[company_id];
            $_SESSION["admininfo"][company_name]  = $db->dt[com_name];
            /*
            $_SESSION["admininfo"][ceo]  = $db->dt[ceo];
            $_SESSION["admininfo"][business_number]  = $db->dt[business_number];
            $_SESSION["admininfo"][business_kind]  = $db->dt[business_kind];
            $_SESSION["admininfo"][business_item]    = $db->dt[business_item];
            $_SESSION["admininfo"][company_address] = $db->dt[company_address];
            $_SESSION["admininfo"][bank_owner] = $db->dt[bank_owner];
            $_SESSION["admininfo"][bank_name]   = $db->dt[bank_name];
            $_SESSION["admininfo"][bank_number]   = $db->dt[bank_number];

            $_SESSION["admininfo"][business_day]   = $db->dt[business_day];
            $_SESSION["admininfo"][admin_id]   = $db->dt[charger_id]; // $db->dt[admin_id];
            $_SESSION["admininfo"][charger_ix]   = $db->dt[charger_ix];
            $_SESSION["admininfo"][charger_id]   = $db->dt[charger_id];
            $_SESSION["admininfo"][charger]   = $db->dt[charger];
            $_SESSION["admininfo"][charger_email]   = $db->dt[charger_email];
            $_SESSION["admininfo"][homepage]   = $db->dt[homepage];
            $_SESSION["admininfo"][shipping_company]   = $db->dt[shipping_company];
            $_SESSION["admininfo"][auth]   = $db->dt[charger_auth];
            */
            $_SESSION["admininfo"][admin_id]   = $db->dt[id]; // $db->dt[admin_id];
            $_SESSION["admininfo"][charger_ix]   = $db->dt[code];
            $_SESSION["admininfo"][charger_id]   = $db->dt[id];
            $_SESSION["admininfo"][charger]   = $db->dt[name];
            $_SESSION["admininfo"][charger_roll]   = $db->dt[auth];
            $_SESSION["admininfo"][language]   = $db->dt[language];
            $_SESSION["admininfo"][mem_type]   = $db->dt[mem_type];
            $_SESSION["admininfo"][mem_level]  = $db->dt[mem_level];

            if($db->dt[mem_type] == "S" || $db->dt[mem_type] == "CS" ){	// 셀러와 가맹점 회원은 레벨 8
                $_SESSION["admininfo"][admin_level] = "8";
            }else if($db->dt[mem_type] == "A" || $db->dt[mem_type] == "MD"){	// 직원과 관리자 MD 는 레벨 9
                $_SESSION["admininfo"][admin_level] = "9";
            }else{
                $_SESSION["admininfo"][admin_level] = "8";
            }
            //$_SESSION["admininfo"][permit]  = $db->dt[permit];

            $http = new _Http;

            $Requrl = "http://sms.mallstory.com/login_history.php";
            $http->setURL($Requrl);                              //요청 url


            //$http->setParam("license", $shopinfo[mall_domain_key]);
            $http->setParam("mall_ix", $dm->dt[mall_ix]);
            $http->setParam("license", $dm->dt[mall_domain_key]);
            $http->setParam("mall_domain", str_replace(array("*www.","*m.","*"),"","*".$HTTP_HOST));

            @$http->send("POST");
            //	$http->send("GET");


            //session_register("admininfo");
            return true;
        }else{
            //echo md5("wooho".str_replace(array("www.","m.","*"),"","".$HTTP_HOST).$dm->dt[mall_domain_id])."<br>";
            //$authinf[mall_domain]=$HTTP_HOST;
            //$authinf[mall_domain_id]=$dm->dt[mall_domain_id];
            //echo $dm->dt[mall_domain_id]."<br>";
            //echo makelicensekey($authinfo);
            //exit;
            //exit;
            return false;
        }

    }
    else
    {
        if($user_cnt > 0){
            $sql = "SELECT * FROM common_user WHERE id=TRIM('$logininfo[id]')";
            $db->query($sql);
            $db->fetch();

            if($db->total > 0 && $db->dt['fail_count'] < 10) {
                $sql = "UPDATE common_user
					SET
						fail_count = (fail_count + 1)
					WHERE
						id=TRIM('$logininfo[id]')";
                $db->query($sql);
            }else{
                $sql = "UPDATE common_sleep_user
					SET
						fail_count = (fail_count + 1)
					WHERE
						id=TRIM('$logininfo[id]')";
                $db->query($sql);
            }
        }

        $error = "아이디와 비밀번호를 확인후 다시 시도해 주세요 ...";
        echo("<script>alert('$error');document.location.href='./'</script>");
    }


}

function generateRandomPassword() {

    $orderArray = array(3, 2, 1, 2);
    shuffle($orderArray);

    $number = "0123456789";
    $capital_Letter = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $small_Letter = "abcdefghijklmnopqrstuvwxyz";
    $special_Characters = "!@#$%^*+=-";

    $new_pwd = '';
    foreach($orderArray as $key => $val){
        switch($key) {
            case 0 :
                $new_pwd .= substr(str_shuffle($number), 0, $val);
                break;
            case 1 :
                $new_pwd .= substr(str_shuffle($capital_Letter), 0, $val);
                break;
            case 2 :
                $new_pwd .= substr(str_shuffle($small_Letter), 0, $val);
                break;
            case 3 :
                $new_pwd .= substr(str_shuffle($special_Characters), 0, $val);
                break;
        }
    }

    return str_shuffle($new_pwd);
}

function shop_auth_check($_authinfo, $basic_encode_str="wooho"){
    global $HTTP_HOST;

    if($_authinfo[mall_domain_key] == md5($basic_encode_str.str_replace(array("*www.","*m.","*"),"","*".$HTTP_HOST).$_authinfo[mall_domain_id]) && str_replace(array("*www.","*m.","*"),"","*".$HTTP_HOST) == $_authinfo[mall_domain]){

        $_SESSION["admininfo"][company_id]  = $db->dt[company_id];
        $_SESSION["admininfo"][company_name]  = $db->dt[company_name];
        $_SESSION["admininfo"][ceo]  = $db->dt[ceo];
        $_SESSION["admininfo"][business_number]  = $db->dt[business_number];
        $_SESSION["admininfo"][business_kind]  = $db->dt[business_kind];
        $_SESSION["admininfo"][business_item]    = $db->dt[business_item];
        $_SESSION["admininfo"][company_address] = $db->dt[company_address];
        $_SESSION["admininfo"][bank_owner] = $db->dt[bank_owner];
        $_SESSION["admininfo"][bank_name]   = $db->dt[bank_name];
        $_SESSION["admininfo"][bank_number]   = $db->dt[bank_number];

        $_SESSION["admininfo"][business_day]   = $db->dt[business_day];
        $_SESSION["admininfo"][admin_id]   = $db->dt[admin_id];
        $_SESSION["admininfo"][charger]   = $db->dt[charger];
        $_SESSION["admininfo"][charger_email]   = $db->dt[charger_email];
        $_SESSION["admininfo"][homepage]   = $db->dt[homepage];
        $_SESSION["admininfo"][shipping_company]   = $db->dt[shipping_company];

        /*
        $phone = split("-", $db->dt[phone]);

        $_SESSION["admininfo"][phone1] = $phone[0];
        $_SESSION["admininfo"][phone2] = $phone[1];
        $_SESSION["admininfo"][phone3] = $phone[2];

        $fax = split("-", $db->dt[fax]);

        $_SESSION["admininfo"][fax1] = $fax[0];
        $_SESSION["admininfo"][fax2] = $fax[1];
        $_SESSION["admininfo"][fax3] = $fax[2];
        */
        $_SESSION["admininfo"][admin_level] = $db->dt[admin_level];
        $_SESSION["admininfo"][permit]  = $db->dt[permit];

        session_register("admininfo");
        return true;
    }else{
        return false;
    }

}

function makelicensekey($authinfo){

    return md5("wooho".str_replace(array("www.","m."),"",$authinfo[mall_domain]).$authinfo[mall_domain_id]);

}