<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/pass_reconfirm/pass_reconfirm.htm 000001345 */ ?>
<!--회원 수정 인트로 시작-->

<section class="wrap-mypage fb__mypage" id='check_pass_form'>

    <form id="devRevalidatePasswordForm">
<?php if($TPL_VAR["passReconfirmType"]=='profile'){?>
        <h2 class="fb__mypage__title">Edit Account</h2>
<?php }else{?>
        <h2 class="fb__mypage__title">Delete Account</h2>
<?php }?>

        <section class="wrap-profile-intro fb__pass-reconfirm">
            <h3 class="fb__pass-reconfirm__tit">Confirm Password</h3>
            <p class="fb__pass-reconfirm__subtit">Please re-enter your password to protect your privacy.</p>

            <dl class="password-area">
                <dt class="password-area__tit">
                    Password
                </dt>
                <dd class="password-area__input-area">
                    <input type="password" name="pass" value='' id="devUserPassword" title="Password">
                </dd>
            </dl>
        </section>

        <div class="wrap-btn-area mat30">
            <input type="submit" value="Accept" alt="Accept" title="Accept" class="btn-default btn-dark" id="devPasswordSubmit">
        </div>
    </form>
</section>

<!--회원 수정 인트로 끝-->