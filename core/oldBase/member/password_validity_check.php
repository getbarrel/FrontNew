<?php
/**
 * Created by PhpStorm.
 * User: moon
 * Date: 2017-09-13
 * Time: 오후 4:59
 */
$pass_chk                = new password_validity_check(gVal('password'));
/**
 * 비밀번호 유효성 체크에 대한 설정 정보 가져오기
 */
$pw_combi                = sess_val('privacy_config', 'pw_combi'); // 비밀번호 조합 정보
$min_pw_length           = sess_val('privacy_config', 'min_pw_length'); // 비밀번호 최소 입력 단위
$max_pw_length           = sess_val('privacy_config', 'max_pw_length'); // 비밀번호 최대 입력 단위
$pw_continuous_check     = sess_val('privacy_config', 'pw_continuous_check'); //비밀번호 연속문자 사용 처리 항목
$pw_min_continuous_check = sess_val('privacy_config', 'pw_min_continuous_check'); //비밀번호 연속문자 처리 개수 정보
$pw_same_check           = sess_val('privacy_config', 'pw_same_check'); //비밀번호 동일문자 사용 처리 항목
$pw_min_same_check       = sess_val('privacy_config', 'pw_min_same_check'); //비밀번호 동일문자 사용 개수 정보

if (is_array($pw_combi)) {
    foreach ($pw_combi as $key => $val) {
        switch ($val) {
            case 'number':
                $check_str[]           = "[0-9]";
                $pw_combi_text_array[] = '숫자';
                break;
            case 'small':
                $check_str[]           = "[a-z]";
                $pw_combi_text_array[] = '소문자';
                break;
            case 'capital':
                $check_str[]           = "[A-Z]";
                $pw_combi_text_array[] = '대문자';
                break;
            case 'special':
                $check_str[]           = "[~!@#$%^&*()_|]";
                $pw_combi_text_array[] = '특수문자 (~!@#$%^&*()_|)';
                break;
        }
    }
} else {
    echo "<script>alert('패스워드 조합 규칙 설정이 필요 합니다. 관리자에 문의 바랍니다.'); history.back();</script>";
    exit;
}

if (isset($tpl)) {
    $tpl->assign("pw_combi", $pw_combi);
    $tpl->assign("pw_combi_text", gVal('pw_combi_text'));
    if (is_array($pw_combi_text_array)) {
        $tpl->assign("pw_combi_text_array", implode(',', $pw_combi_text_array));
    }
    $tpl->assign("min_pw_length", $min_pw_length);
    $tpl->assign("max_pw_length", $max_pw_length);
    $tpl->assign("pw_continuous_check", $pw_continuous_check);
    $tpl->assign("pw_min_continuous_check", $pw_min_continuous_check);
    $tpl->assign("pw_same_check", $pw_same_check);
    $tpl->assign("pw_min_same_check", $pw_min_same_check);
}