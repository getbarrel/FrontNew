<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load Forbiz View
$view = getForbizView('noLayout');

$memberModel = $view->import('model.mall.member');

$params = $view->getParams();

/**
 * @todo 휴대폰 및 ipin 인증 연동 필요함
 *
 * 휴대폰 및 ipin 인증 연동 된것으로하고 샘플 데이터 세션에 저장
 */
$data['name']        = "테스트";
$data['ci']          = 'ci';
$data['di']          = 'di';
$data['birthday']    = '1896-01-01'; //0000-00-00
$data['birthdayDiv'] = '1'; //1:양력, 0:음력
$data['sexDiv']      = 'M'; //M:남성, W:여성, D:기타
$data['pcs']         = '010-'.rand(1111,9999).'-0000'; //000-0000-0000

$memberModel->setAuthSessionData($data);

$retData = json_encode([
    'name' => $data['name'],
    'pcs' => $data['pcs']
    ]);

if (is_mobile()) {
    echo "<script>parent.common.certify.response(true,'',{$retData});self.close();</script>";
} else {
    echo "<script>opener.common.certify.response(true,'', {$retData});self.close();</script>";
}