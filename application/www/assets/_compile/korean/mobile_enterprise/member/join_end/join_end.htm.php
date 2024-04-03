<?php /* Template_ 2.2.8 2023/07/18 17:28:30 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/join_end/join_end.htm 000002533 */ ?>
<!-- 회원가입 완료 -->
<?php if($TPL_VAR["result"]=='fail'){?>
<!-- 회원가입 실패 -->
<section class="br__join__end" >
    <h2 class="br__find-user__title">회원가입 실패</h2>
    <p class="join-end__title"><em>SNS 회원가입 시</em> 필수제공항목에 동의해야<br/>회원가입이 가능합니다.<br/>필수제공항목 동의 후 회원가입을 진행해주세요.</p>

    <div class="br__join__btn">
        <a class="join__btn" href="/mypage/">로그인</a>
    </div>

    <div class="br__join__btn">
        <a class="join__btn black" href="/">홈으로</a>
    </div>
</section>
<!-- EOD : 회원가입 실패 -->
<?php }else{?>
<section class="br__join__end" >
    <h2 class="br__find-user__title">회원가입 완료</h2>
    <p class="join-end__title"><em>배럴 회원</em>이 되신 것을 축하합니다!<br/>다양한 회원혜택을 만나보세요.</p>
    <div class="br__join__btn">
        <a class="join__btn" href="/mypage/">로그인</a>
    </div>

    <div class="br__join__btn">
        <a class="join__btn black" href="/">홈으로</a>
    </div>

    <div class="br__login__info">
        <div class="information__benefit">
            <h3 class="information__benefit__title">배럴 회원 혜택</h3>
            <ul class="information__benefit__box">
                <li class="information__benefit__list">
                    <p class="information__benefit__desc">회원등급에 따른 <br><strong>쿠폰, 즉시할인 혜택</strong></p>
                </li>
                <!-- <li class="information__benefit__list">
                    <p class="information__benefit__desc">배럴 신규회원 <br><strong>즉시 사용가능한 <br>3,000원</strong> 적립금</p>
                </li> -->
                <li class="information__benefit__list">
                    <p class="information__benefit__desc">회원등급에 따른 <br><strong>구매금액의 <br>1%이상</strong> 적립금</p>
                </li>
                <li class="information__benefit__list">
                    <p class="information__benefit__desc">신규가입시 <br><strong>5,000원 할인쿠폰</strong>(5만원 구매이상)<br><strong>10,000원 할인쿠폰</strong>(10만원 구매이상)</p>
                </li>
            </ul>
        </div>
    </div>
</section>
<!-- EOD : 회원가입 완료 -->
<?php }?>