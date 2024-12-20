<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/join_select/join_select.htm 000001212 */ ?>
<h1 class="wrap-title">
    회원가입
    <button class="back"></button>
</h1>

<div class="layout-padding wrap-join-select">
    <h1 class="join-title"><?php echo $TPL_VAR["companyInfo"]["shop_name"]?>에 오신 것을 <br> 환영합니다.</h1>

    <p class="desc">
        <?php echo $TPL_VAR["companyInfo"]["shop_name"]?>의 회원이 되시면 할인쿠폰과 포인트 적립 등의<br>
        특별한 혜택을 누리실 수 있습니다.<br>
        본인에 맞는 회원타입을 선택하신 후 회원가입을<br>
        진행하여 주시기 바랍니다.
    </p>

    <ul>
        <li id="devBasicJoinButton">
            <div class="basic">
                <p>일반회원(외국인 포함)</p>
                <span>만 14세 이상 가입 가능</span>
            </div>
        </li>
        <li id="devCompanyJoinButton">
            <div class="company">
                <p>기업회원</p>
                <span>사업자등록증을 보유한 회원</span>
            </div>
        </li>
    </ul>
</div>