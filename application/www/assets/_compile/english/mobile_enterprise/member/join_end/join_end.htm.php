<?php /* Template_ 2.2.8 2021/08/23 17:03:30 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/join_end/join_end.htm 000002323 */ ?>
<!-- 회원가입 완료 -->
<?php if($TPL_VAR["result"]=='fail'){?>
<!-- 회원가입 실패 -->
<section class="br__join__end" >
    <h2 class="br__find-user__title">Registration failure.</h2>
    <p class="join-end__title"><em>when you sign up via SNS</em> you will need to aceept all requirements<br/>to complete sign up.<br/>Please proceed after accepting all requirements</p>

    <div class="br__join__btn">
        <a class="join__btn" href="/mypage/">Sign in</a>
    </div>

    <div class="br__join__btn">
        <a class="join__btn black" href="/">Home</a>
    </div>
</section>
<!-- EOD : 회원가입 실패 -->
<?php }else{?>
<section class="br__join__end" >
    <h2 class="br__find-user__title">Welcome!</h2>
    <p class="join-end__title">Congratulations on becoming a BARREL member!<br/>enjoy variety member benefits</p>
    <div class="br__join__btn">
        <a class="join__btn" href="/mypage/">Sign in</a>
    </div>

    <div class="br__join__btn">
        <a class="join__btn black" href="/">Home</a>
    </div>

    <div class="br__login__info">
        <div class="information__benefit">
            <h3 class="information__benefit__title">Membership Guide</h3>
            <ul class="information__benefit__box">
                <li class="information__benefit__list">
                    <p class="information__benefit__desc">회원등급에 따른 <br><strong>쿠폰, 즉시할인 혜택</strong></p>
                </li>
                <!-- <li class="information__benefit__list">
                    <p class="information__benefit__desc"><strong>$3 reward</strong></p>
                </li> -->
                <li class="information__benefit__list">
                    <p class="information__benefit__desc">회원등급에 따른 <br><strong>구매금액의 <br>1%이상</strong> 적립금</p>
                </li>
                <li class="information__benefit__list">
                    <p class="information__benefit__desc"><strong>$3 discount coupon available for purchases over $30</strong></p>
                </li>
            </ul>
        </div>
    </div>
</section>
<!-- EOD : 회원가입 완료 -->
<?php }?>