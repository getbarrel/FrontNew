<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/refund_account/refund_account.htm 000004502 */ 
$TPL_bankList_1=empty($TPL_VAR["bankList"])||!is_array($TPL_VAR["bankList"])?0:count($TPL_VAR["bankList"]);?>
<!--<h1 class="wrap-title">
    환불계좌 관리
    <button class="back"></button>
</h1>-->

<div class="br__mypage__pass">
    <p class="pass-title">환불계좌관리</p>
</div>

<section class="br__mypage br__refund">
    <form id="devRefundAccountForm">
        <div id="devRefundAccountContent">

            <!-- 등록된 case -->
            <div class="devForbizTpl" id="devRefundAccountList">
                <ul class="br__refund__info">
                   <li id="devRefundAccountData" data-bankix="{[bank_ix]}" data-bankcode="{[bank_code]}" data-bankowner="{[bank_owner]}">
                       <p class="refund__info-title">은행명</p>
                       <p class="refund__info-sub">{[bank_name]}</p>
                   </li>
                    <li>
                        <p class="refund__info-title">예금주</p>
                        <p class="refund__info-sub">{[bank_owner]}</p>
                    </li>
                    <li>
                        <p class="refund__info-title">계좌번호</p>
                        <p class="refund__info-sub">{[bank_number]}</p>
                    </li>
                </ul>

                <div class="br__refund__line"></div>
                <p class="br__refund__txt">
                    계좌는 1개만 등록 가능하며, 등록된 계좌는 현금결제 주문취소 시<br/>해당 계좌로 환불금액이 입금 되오니 최대한 정확하게 기입해<br/> 주시기 바랍니다.
                </p>
            </div>
            <!-- EOD : 등록된 case -->

            <div class="wrap-refund-complete devForbizTpl" id="devRefundAccountLoading">
                Loading...
            </div>

            <!-- 등록된 계좌 없을 때 / 변경할 때-->

            <div class="devForbizTpl" id="devRefundAccountReplaceForm">
                <dl class="br__join__list">
                    <dt>은행명</dt>
                    <dd>
                        <select title="은행명" name="bank_code" id="devBankCode">
                            <option value="">선택</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option><?php }}?>
                        </select>
                    </dd>
                </dl>

                <dl class="br__join__list">
                    <dt>예금주</dt>
                    <dd>
                        <input type="text" name="bank_owner" title="예금주" id="devBankOwner">
                    </dd>
                </dl>

                <dl class="br__join__list">
                    <dt>계좌번호</dt>
                    <dd>
                        <input type="text" name="bank_number" title="계좌번호" id="devBankNumber">
                        <p class="br__refund__noti">'-' 는 제외하고 입력해주세요.</p>
                    </dd>
                </dl>

                <div class="br__refund__line refund"></div>
                <p class="br__refund__txt">
                    계좌는 1개만 등록 가능하며, 등록된 계좌는 현금결제 주문취소 시<br/>해당 계좌로 환불금액이 입금 되오니 최대한 정확하게 기입해<br/> 주시기 바랍니다.
                </p>
            </div>
            <!-- EOD : 등록된 계좌 없을 때 / 변경할 때-->

        </div>

        <div class="br__login__info" id="devDivModifyBtnGroup" style="display:none;">
            <div class="information__btn">
                <button type="button" class="information__btn__join" id="devRefundAccountItemDelete">삭제</button>
                <button type="button" class="information__btn__login" id="devRefundAccountItemModify">변경</button>
            </div>
        </div>

        <div class="br__login__info" id="devDivSaveBtnGroup" style="display:none;">
            <div class="information__btn">
                <button type="button" class="information__btn__join" id="devRefundAccountModifyCancel">취소</button>
                <button type="button" class="information__btn__login" id="devRefundAccountItemSave">저장</button>
            </div>
        </div>
    </form>
</section>