<?php
defined('FORBIZ_BASEURL') OR exit('No direct script access allowed');

function trans($text, $language = false)
{
    if($language === false){
        $language = BASIC_LANGUAGE;
    }
    $cacheLangPath = CUSTOM_ROOT.'/_cache/_language/'. $language . ".php";


    if (defined('USE_SHARED_CACHE') && USE_SHARED_CACHE === true && file_exists($cacheLangPath)) {
        $languageFilePath = $cacheLangPath;
    } else {
        $languageFilePath = MALL_DATA_PATH . "/_language/" . $language . ".php";
    }


    if (file_exists($languageFilePath)) {
        $languageData = include($languageFilePath);
    } else {
        $languageData = [];
    }
    return $languageData[md5($text)] ?? $text;
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

if (!function_exists('default_password')) {
    /**
     * 기본패스워드
     * @param string $pw
     * @return string
     */
    function default_password($pw)
    {
        return hash('sha256', md5($pw));
    }
}

//elasticserach helper
if (file_exists(__DIR__ . '/es.helper.php')) {
    require_once (__DIR__ . '/es.helper.php');
}

/**
 * 글로벌 가격 노출
 * @param type $price
 * @return type
 */
function g_price($price)
{
    return number_format((float)$price, (defined('BCSCALE') ? BCSCALE : 0));
}

/**
 * zore fill
 * @param int $num
 * @param int $zerofill
 * @return int
 */
function zerofill($num, $zerofill = 10)
{
    return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
}

/**
 * get 상품 이미지
 * @param type $id
 * @param type $isUserAdult
 * @param type $sizeType
 * @param boolean $isAdult
 * @return string
 */
function get_product_images_src($id, $isUserAdult, $sizeType = 'm', $isAdult = false)
{
    $basicPath = DATA_ROOT . "/images/product";

    $domain = (!empty(IMAGE_SERVER_DOMAIN) ? IMAGE_SERVER_DOMAIN : HTTP_PROTOCOL . FORBIZ_HOST );

    //19세 상품일때
    if (!$isUserAdult && $isAdult) {
        return $domain . $basicPath . '/product_19_200.gif';
    } else {
        $id = zerofill($id);
        $imgDir = implode("/", str_split($id, 2));

        $imageSrc = $basicPath . '/' . $imgDir . "/" . $sizeType . "_" . $id . ".gif";

        //이미지 없을떄 (nas 이용시 다중 접속에 의한 속도 지연 문제로 배럴데이 이벤트 처리 2020-03-03 JK
        if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === false) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $imageSrc)) {
                $imageSrc = $basicPath . "/shop/noimg.gif";
            }
        }
        return $domain . $imageSrc;
    }
}

function get_product_images_detail_src($id){
    $basicPath = DATA_ROOT . "/images/productNew/";

    $domain = (!empty(IMAGE_SERVER_DOMAIN) ? IMAGE_SERVER_DOMAIN : HTTP_PROTOCOL . FORBIZ_HOST );

    $id = zerofill($id);
    $imgDir = implode("/", str_split($id, 2));

    $imgpath = $basicPath.$imgDir;
    $porductImg = "";

    if (file_exists($imgpath)) {
        $handle  = opendir($imgpath); // 디렉토리 open

        $files = array();

        // 디렉토리의 파일을 저장
        while (false !== ($filename = readdir($handle))) {
            // 파일인 경우만 목록에 추가한다.
            if(is_file($imgpath . "/" . $filename)){
                $files[] = $filename;

            }
        }
        closedir($handle); // 디렉토리 close

        sort($files);

        foreach ($files as $f) { // 파일명 출력
            $basic[] = array('basic_img' => $domain.$imgpath."/".$f);
        }
    }
    return $basic;
}

function get_product_images_new_src($id)
{
    $basicPath = DATA_ROOT . "/images/productNew/";

    $domain = (!empty(IMAGE_SERVER_DOMAIN) ? IMAGE_SERVER_DOMAIN : HTTP_PROTOCOL . FORBIZ_HOST );

    $id = zerofill($id);
    $imgDir = implode("/", str_split($id, 2));

    $imgpath = $basicPath.$imgDir;
    $porductImg = "";

    if (file_exists($imgpath)) {
        $imageSrc = $basicPath . '/' . $imgDir . "/" . "basic_" . $id . "_0.gif";
    }else{
        $imageSrc = $basicPath . "/shop/noimg.gif";
    }
    return $domain . $imageSrc;
}

function get_product_images_src_new($id, $isUserAdult, $sizeType = 'm', $isAdult = false, $imgNum){
    $basicPath = DATA_ROOT . "/images/addimgNew";

    $domain = (!empty(IMAGE_SERVER_DOMAIN) ? IMAGE_SERVER_DOMAIN : HTTP_PROTOCOL . FORBIZ_HOST );

    //19세 상품일때
    if (!$isUserAdult && $isAdult) {
        return $domain . $basicPath . '/product_19_200.gif';
    } else {

        $id = zerofill($id);
        $imgDir = implode("/", str_split($id, 2));

        $imageSrc = $basicPath . '/' . $imgDir . "/" . $sizeType . "_" . $id . "_" . $imgNum . ".gif";
        //이미지 없을떄 (nas 이용시 다중 접속에 의한 속도 지연 문제로 배럴데이 이벤트 처리 2020-03-03 JK
        if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === false) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $imageSrc)) {
                if($sizeType == "patt"){
                    $imageSrc = "";

                    return $imageSrc;
                }else{
                    $imageSrc = $basicPath . "/shop/noimg.gif";

                    return $domain . $imageSrc;
                }
            }
        }
    }
    return $domain . $imageSrc;
}

/**
 * get 재고 품목 이미지
 */
function get_inventory_images_src($Pid, $isUserAdult, $sizeType = 'm', $isAdult = false)
{
    $basicPath = DATA_ROOT . "/images/inventory";

    $domain = (!empty(IMAGE_SERVER_DOMAIN) ? IMAGE_SERVER_DOMAIN : HTTP_PROTOCOL . FORBIZ_HOST );

    //19세 상품일때
    if (!$isUserAdult && $isAdult) {
        return $domain . $basicPath . '/product_19_200.gif';
    } else {
        $Pid = str_replace("/", "_", $Pid);
        $Pid = str_replace(":", "_", $Pid);
        $Pid = str_replace(" ", "_", $Pid);


        $id = substr(zerofill($Pid), 0, 10);

        $imgDir = implode("/", str_split($id, 2));

        $imageSrc = $basicPath . '/' . $imgDir . "/" . $sizeType . "_" . $Pid . ".gif";


        //이미지 없을떄 (nas 이용시 다중 접속에 의한 속도 지연 문제로 배럴데이 이벤트 처리 2020-03-03 JK
        if (defined('IS_BARREL_DAY') && IS_BARREL_DAY === false) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $imageSrc)) {
                $imageSrc = $basicPath . "/shop/noimg.gif";
            }
        }
        return $domain . $imageSrc;
    }
}

/**
 * 배너위치 함수
 * @param int $bannerPosition
 * @return
 */
function get_schedule_banner_info($bannerPosition, $cid = "")
{
    $view = getForbiz();

    if (!empty($cid)) {
        $view->qb->where('display_cid', $cid);
    }

    $datas = $view->qb
        ->select('banner_ix')
        ->select('banner_kind')
        ->select('banner_name')
        ->from('shop_bannerinfo')
        ->where('banner_position', $bannerPosition)
        ->where('NOW() between use_sdate and use_edate')
        ->orderBy('banner_ix', 'desc')
        ->limit(1)
        ->exec()
        ->getRowArray();

    if (!empty($datas)) {
        return get_banner_info($datas['banner_ix']);
    } else {
        return array();
    }
}

/**
 * 배너 함수
 * @param int $bannerIx
 * @return
 */
function get_banner_info($bannerIx)
{
    $view = getForbiz();
    $basicPath = IMAGE_SERVER_DOMAIN . DATA_ROOT . '/images/banner/' . $bannerIx . '/'; //배너이미지 기본 경로

    $datas = $view->qb
        ->select('b.banner_ix , b.banner_kind , b.banner_name')
        ->from('shop_bannerinfo as b')
        ->where('banner_ix', $bannerIx)
        ->where('disp', 1)
        ->where('NOW() between use_sdate and use_edate')
        ->orderBy('use_sdate', 'asc')
        ->orderBy('use_edate', 'asc')
        ->limit(1)
        ->exec()
        ->getRowArray();
    $bannerKind = $datas['banner_kind'];

    if ($bannerKind == 1) { // 일반배너
        $details = $view->qb
            ->select('b.banner_ix, b.banner_kind, change_effect, banner_img,banner_img_on,banner_btn_position, banner_link,banner_target,banner_width,banner_height,disp,banner_name,
            IFNULL(sum(bc.ncnt),0) as ncnt')
            ->from('shop_bannerinfo as b')
            ->join('logstory_banner_click as bc', 'on b.banner_ix = bc.banner_ix and b.banner_ix = "' . $bannerIx . '"', 'left')
            ->where('b.banner_ix', $bannerIx)
            ->where('disp', 1)
            ->groupBy('b.banner_ix, banner_img,banner_link,banner_target,banner_width,banner_height')
            ->exec()
            ->getResultArray();

        if (!empty($details)) {
            for ($i = 0; $i < count($details); $i++) {
                $bannerIx = $details[$i]['banner_ix'];
                $bannerImg = $details[$i]['banner_img'];
                $bannerWidth = $details[$i]['banner_width'];
                $bannerHeight = $details[$i]['banner_height'];
                $bannerImgOn = $details[$i]['banner_img_on'];
                $bannerOnUse = $details[$i]['banner_on_use'];
                $bannerTarget = strtolower($details[$i]['banner_target']);

                if (is_mobile())
                    $bannerTarget = "_parent";

                if ($i > 0)
                    $mString . "<BR>";

                if ($bannerOnUse == "Y" || $bannerImgOn) { // 마우스오버시 바로 이미지가 바뀌는 오버기능 사용시
                    $onHoverScript = "onmouseover='this.src=\"" . $basicPath . $bannerImgOn . "\"' onmouseout='this.src=\"" . $basicPath . $bannerImg . "\"'";
                }

                if ($details[$i]['banner_link'] != "" && $details[$i]['banner_link'] != "#") {
                    $onclick = "onclick='top.location.href=\"/bannerLink.php?bdIx=&bannerIx=" . $bannerIx . "\"' style='cursor:pointer;'";
                }

                $mString .= "<img src='" . $basicPath . $bannerImg . "'  width='" . $bannerWidth . "' height='" . $bannerHeight . "' " . $onHoverScript . " " . $onclick . ">";
            }
        }
    } else if ($bannerKind == 5) { // 사용자지정 배너
        $details = $view->qb
            ->select('b.banner_ix, b.banner_kind, b.use_sdate, b.use_edate, change_effect, banner_img,banner_link,banner_target,
                        banner_width,banner_height,disp,banner_name, bd.*, IFNULL(sum(bc.ncnt),0) as ncnt')
            ->select('concat("' . $basicPath . '", bd.bd_file) as imgSrc, case when bd.bd_link="" or bd_link="#" then bd_link else concat("/bannerLink.php?bannerIx=", b.banner_ix, "&bdIx=", bd_ix) end as bannerLink')
            ->from('shop_bannerinfo as b')
            ->join('shop_bannerinfo_detail as bd', 'b.banner_ix = bd.banner_ix', 'left')
            ->join('logstory_banner_click as bc', 'b.banner_ix = bc.banner_ix and b.banner_ix = "' . $bannerIx . '"', 'left')
            ->where('b.banner_ix', $bannerIx)
            ->where('disp', 1)
            ->groupBy('b.banner_ix, bd.bd_ix, banner_img,banner_link,banner_target,banner_width,banner_height')
            ->orderBy('bd.vieworder')
            ->exec()
            ->getResultArray();
        return $details;
    }

    return $mString;
}

/**
 * 이미지 서버를 기준으로 하여 이미지 URL 생성
 * @param string $url
 * @return string
 */
function get_img_url($url)
{
    return IMAGE_SERVER_DOMAIN . str_replace('//', '/', ('/' . $url));
}

/**
 * 성인 여부를 확인한다.
 * @return boolean
 */
function is_adult()
{
    return intval(sess_val('user', 'age')) >= 19;
}

/**
 * 문자열을 자른후 ... 을 붙임
 *
 * @param string $str
 * @param int $len
 * @return string
 */
function str_cut($str, $len = 30)
{
    return mb_substr($str, 0, $len) . (mb_strlen($str) > $len ? ' ...' : '');
}

/**
 * 검색어에 하이라이트 효과 줌
 * @param string $str
 * @param string $search
 * @return string
 */
function highlight($str, $search)
{
    return str_replace($search, '<span style="background-color: yellow;">' . $search . "</span>", $str);
}

/**
 * SMS 메시지 전송 랩퍼
 * @param string $to
 * @param string $msg_txt
 * @return string
 */
function sms_msg_send($to, $msg_txt)
{
    $msg = new MsgForbiz();

    return $msg->protocol('sms')
            ->from(ForbizConfig::getCompanyInfo('com_phone'))
            ->to($to)
            ->message($msg_txt,'')
            ->send();
}

/**
 * SNS를 통하여 로그인 확인
 * 휴면 회원 해제시
 * @return boolean
 */
function is_sns_login()
{
    return !empty($_SESSION['sns_login']);
}


function dd($array, $c = true){
    echo "<pre>";
    print_r($array);
    if($c)
        exit;
}


/**
 * 이미지 파일 업로드
 * @param type $fldName
 * @param type $upload_path
 * @return type
 */
function img_file_upload($fldName, $upload_path)
{
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }

    $fb = getForbiz();

    $fb->load->library('upload', [
        'upload_path' => $upload_path
        , 'encrypt_name' => true
        , 'allowed_types' => 'gif|jpg|jpeg|png'
    ]);

    if ($fb->upload->do_upload($fldName)) {
        return $fb->upload->data();
    } else {
        log_message('error', 'image upload error'.json_encode($fb->upload->display_errors()) );
        return $fb->upload->display_errors();
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
        if(BASIC_LANGUAGE == 'english'){
            $mcCode = $mcCode."_global";
        }
        $msgConfig = $triggerModel->getMsgConfig($mcCode);
/*if($_SERVER["REMOTE_ADDR"] == '211.104.22.53'){
    print_r($msgConfig);
    echo "<hr>";
}*/
        if (!empty($msgConfig)) {

            $templateData = array_merge($triggerModel->getCommonEmailTemplateData(), $templateData);
            //메일
            if (!empty($email) && $msgConfig->mc_mail_usersend_yn == 'Y') {
/*if($_SERVER["REMOTE_ADDR"] == '211.104.22.53'){
    echo "AA : ".$email." // ".$msgConfig->mc_mail_title." // ".$mcCode."<br>";
    print_r($templateData);
}*/
                $msg->protocol('email')
                    ->from(ForbizConfig::getCompanyInfo('com_email'))
                    ->to($email)
                    ->subject($msgConfig->mc_mail_title)
                    ->template($mcCode, $templateData)
                    ->send();
            }

            //SMS & 알림톡
            if(BASIC_LANGUAGE == 'korean') {
                if (!empty($mobile)) {
                    if ($msgConfig->mc_sms_usersend_yn == 'Y') {
                        //SMS
                        $msg->protocol('sms')
                            ->from(ForbizConfig::getCompanyInfo('com_phone'))
                            ->to(str_replace('-', '', $mobile))
                            ->template($mcCode, $templateData,'')
                            ->send();
                    } else if ($msgConfig->mc_sms_usersend_yn == 'K') {
                        //알림톡
                        $msg->protocol('alimtalk')
                            ->from(ForbizConfig::getCompanyInfo('com_phone'))
                            ->to(str_replace('-', '', $mobile))
                            ->template($mcCode, $templateData,6)
                            ->send();
                    }
                }
                /*if($_SERVER["REMOTE_ADDR"] == '211.104.22.53'){
                    echo "End";
                    exit;
                }*/
            }
        }
    }
}

if ( ! function_exists('show_error'))
{
    /**
     * Error Handler
     *
     * This function lets us invoke the exception class and
     * display errors using the standard error template located
     * in application/views/errors/error_general.php
     * This function will send the error page directly to the
     * browser and exit.
     *
     * @param	string
     * @param	int
     * @param	string
     * @return	void
     */
    function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered')
    {
        $status_code = abs($status_code);
        if ($status_code < 100)
        {
            $exit_status = $status_code + 9; // 9 is EXIT__AUTO_MIN
            $status_code = 500;
        }
        else
        {
            $exit_status = 1; // EXIT_ERROR
        }

        $_error =& load_class('Exceptions', 'core');
        if(BASIC_LANGUAGE == 'english'){
            echo $_error->show_error($heading, $message, 'error_english', $status_code);
        }else{
            echo $_error->show_error($heading, $message, 'error_general', $status_code);
        }

        exit($exit_status);
    }
}