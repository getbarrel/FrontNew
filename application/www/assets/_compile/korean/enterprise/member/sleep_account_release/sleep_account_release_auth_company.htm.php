<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/sleep_account_release/sleep_account_release_auth_company.htm 000002813 */ ?>
<div class="wrap-member">
    <div class="title-area">
        <h1>휴면 계정 전환 안내ㅇㅇㅇ</h1>
        <ul class="wrap-member-step sleep">
            <li class="step01 active">
                <div>
                    <span>STEP 01</span>
                    <p>사업자 인증</p>
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
    </div>

    <div class="wrap-joininput-layout">
        <div class="wrap-line-box">
            <form id="devCompanyForm">
                <table class="join-cpn-table" style="margin:0 auto;">
                    <colgroup>
                        <col width="*">
                        <col width="380px">
                    </colgroup>
                    <tr>
                        <th scope="col">상호명</th>
                        <td>
                            <input type="text" id="devComName" name="comName" title="상호명">
                            <p class="txt-error" devTailMsg="devComName"></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col">사업자등록번호</th>
                        <td class="td-number">
                            <input type="number" name="comNumber1" id="devComNumber1" title="사업자등록번호">
                            <span>-</span>
                            <input type="number" name="comNumber2" id="devComNumber2" title="사업자등록번호">
                            <span>-</span>
                            <input type="number" name="comNumber3" id="devComNumber3" title="사업자등록번호">
                            <p class="txt-error" devTailMsg="devComNumber1 devComNumber2 devComNumber3"></p>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <div class="wrap-btn-area member">
        <button class="btn-lg btn-dark-line" id="devCancelButton">취소</button>
        <button class="btn-lg btn-point" id="devCompanySubmitButton">사업자 확인</button>
    </div>
</div>