<?php /* Template_ 2.2.8 2020/10/27 09:25:25 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/password/password.htm 000001283 */ ?>
<div class="wrap-change-password">
    <form id="devPmComparePasswordForm">
        <div class="desc">Enter a new password.</div>

        <dl>
            <dt>New Password</dt>
            <dd>
                <input type="password" name="pw" id="devPmPassword" title="New Password">
                <p class="txt-guide" devTailMsg="devPmPassword"></p>
            </dd>
        </dl>

        <dl>
            <dt>Confrim New Password</dt>
            <dd>
                <input type="password" name="comparePw" id="devPmComparePassword" title="Confrim New Password">
                <p class="txt-guide" devTailMsg="devPmComparePassword"></p>
            </dd>
        </dl>

        <div class="desc02">Enter at least 8 characters and up to 16 characters using at least 2 combinations of uppercase and lowercase letters, numbers and special characters.</div>

        <div class="popup-btn-area">
            <button type="button" class="btn-default btn-dark-line" id="devPmCancel">Cancel</button>
            <button type="button" class="btn-default btn-dark" id="devPmSubmit">Accept</button>
        </div>
    </form>
</div>