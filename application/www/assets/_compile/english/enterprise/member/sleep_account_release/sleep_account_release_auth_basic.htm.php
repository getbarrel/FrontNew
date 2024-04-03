<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/sleep_account_release/sleep_account_release_auth_basic.htm 000002325 */ ?>
<div class="sleep-account-area fb__sleep-account-release">

    <div class="title-area">
        <h1>휴면 계정 전환 안내</h1>
        <ul class="wrap-member-step sleep">
            <li class="step01 active">
                <div>
                    <span>STEP 01</span>
<?php if($TPL_VAR["joinType"]=='C'){?><!--사업자-->
                    <p>사업자인증</p>
<?php }else{?><!--일반-->
                    <p>본인인증</p>
<?php }?>
                </div>
            </li>
            <li class="step02">
                <div>
                    <span>STEP 02</span>
                    <p>약관동의</p>
                </div>
            </li>
            <li class="step03">
                <div>
                    <span>STEP 03</span>
                    <p>비밀번호 변경</p>
                </div>
            </li>
            <li class="step04">
                <div>
                    <span>STEP 04</span>
                    <p>계정 활성화</p>
                </div>
            </li>
        </ul>

        <p class="subtitle">휴면 계정 해제를 위해 본인확인이 필요합니다. 원하시는 본인인증 방법을 선택해 주세요.</p>
    </div>

    <div class="wrap-join-layout clearfix">
<?php if($TPL_VAR["useCertify"]){?>
        <div class="inner-box">
            <p class="inner-tit join03">휴대폰 인증</p>
            <p class="inner-txt">본인 명의의 휴대폰으로 인증하실 수 있습니다.</p>


            <a href="#" class="btn-default btn-point-line mat20" id="devCertifyButton">인증하기</a>

        </div>
<?php }?>
<?php if($TPL_VAR["useIpin"]){?>
        <div class="inner-box">
            <p class="inner-tit join04">아이핀 인증</p>
            <p class="inner-txt">아이핀 아이디와 비밀번호로 인증하실 수 있습니다.</p>


            <a href="#" class="btn-default btn-point-line mat20" id="devIpinButton">인증하기</a>

        </div>
<?php }?>
    </div>


    <div class="wrap-btn-area member">
        <button class="btn-lg btn-dark-line" id="devCancelButton">취소</button>
    </div>


</div>