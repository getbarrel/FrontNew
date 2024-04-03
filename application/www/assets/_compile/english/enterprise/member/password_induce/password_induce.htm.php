<?php /* Template_ 2.2.8 2019/08/05 16:59:52 /home/barrel-stage/application/www/assets/templet/enterprise/member/password_induce/password_induce.htm 000001480 */ ?>
<section class="br__password">
    <header class="password__header">
        <h2 class="password__title">Please change your password.</h2>
        <p class="password__summary">
            <?php echo $TPL_VAR["changePasswordDay"]?> days after changing the password.<br/>
            Please change your password reger to the input method below.<br/><br/>
            Regular password change helps you to protect your valuable persnal information.
        </p>
    </header>
    <div class="password__form">
        <form action="#">
            <ul>
                <li class="password__list">
                    <input type="password" name="newPassword" title="새 비밀번호">
                </li>
                <li class="password__list">
                    <input type="password" name="PasswordConfirm" title="새 비밀번호 확인">
                </li>
            </ul>
        </form>
        <p>
            <span>
                Password doesn&#39;t match.
            </span><br/>
            Two or more combinations of upper and lowercase letters, numbers and special charactiers. Minimum 8, max 16 characters.
        </p>
    </div>
    <div class="password-button">
        <button>30 days later.</button>
    </div>
    <div>
        <button>Change Password</button>
    </div>
</section>