<?php /* Template_ 2.2.8 2019/08/05 16:59:52 /home/barrel-stage/application/www/assets/templet/enterprise/member/password_induce/password_induce.htm 000001577 */ ?>
<section class="br__password">
    <header class="password__header">
        <h2 class="password__title">회원님의 비밀번호를 변경해주세요.</h2>
        <p class="password__summary">
            비밀번호를 변경한지 <?php echo $TPL_VAR["changePasswordDay"]?>일이 지난 경우<br/>
            아래 비밀번호 입력 방법을 참고하여 비밀번호를 변경해 주세요.<br/><br/>
            정기적인 비밀번호 변경은 회원님의 소중한 개인 정보를 보호할 수 있습니다.
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
                비밀번호가 일치하지 않습니다.
            </span><br/>
            영문 대소문자, 숫자, 특수문자 중 2개 이상을 조합하여 최소 8자~최대 16자로 입력
        </p>
    </div>
    <div class="password-button">
        <button>30일후 재알림</button>
    </div>
    <div>
        <button>비밀번호 변경</button>
    </div>
</section>