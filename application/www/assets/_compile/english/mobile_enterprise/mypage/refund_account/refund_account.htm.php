<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/refund_account/refund_account.htm 000004492 */ 
$TPL_bankList_1=empty($TPL_VAR["bankList"])||!is_array($TPL_VAR["bankList"])?0:count($TPL_VAR["bankList"]);?>
<!--<h1 class="wrap-title">
    환불계좌 관리
    <button class="back"></button>
</h1>-->

<div class="br__mypage__pass">
    <p class="pass-title">Setting payment</p>
</div>

<section class="br__mypage br__refund">
    <form id="devRefundAccountForm">
        <div id="devRefundAccountContent">

            <!-- 등록된 case -->
            <div class="devForbizTpl" id="devRefundAccountList">
                <ul class="br__refund__info">
                   <li id="devRefundAccountData" data-bankix="{[bank_ix]}" data-bankcode="{[bank_code]}" data-bankowner="{[bank_owner]}">
                       <p class="refund__info-title">Bank</p>
                       <p class="refund__info-sub">{[bank_name]}</p>
                   </li>
                    <li>
                        <p class="refund__info-title">account holder</p>
                        <p class="refund__info-sub">{[bank_owner]}</p>
                    </li>
                    <li>
                        <p class="refund__info-title">Account number</p>
                        <p class="refund__info-sub">{[bank_number]}</p>
                    </li>
                </ul>

                <div class="br__refund__line"></div>
                <p class="br__refund__txt">
                    Only one account can be registered. Please fill out the registered account as accurately as possible as the refund amount will be deposited to the account when the cash payment order is cancelled.
                </p>
            </div>
            <!-- EOD : 등록된 case -->

            <div class="wrap-refund-complete devForbizTpl" id="devRefundAccountLoading">
                Loading...
            </div>

            <!-- 등록된 계좌 없을 때 / 변경할 때-->

            <div class="devForbizTpl" id="devRefundAccountReplaceForm">
                <dl class="br__join__list">
                    <dt>Bank</dt>
                    <dd>
                        <select title="은행명" name="bank_code" id="devBankCode">
                            <option value="">Select</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option><?php }}?>
                        </select>
                    </dd>
                </dl>

                <dl class="br__join__list">
                    <dt>account holder</dt>
                    <dd>
                        <input type="text" name="bank_owner" title="account holder" id="devBankOwner">
                    </dd>
                </dl>

                <dl class="br__join__list">
                    <dt>Account number</dt>
                    <dd>
                        <input type="text" name="bank_number" title="Account number" id="devBankNumber">
                        <p class="br__refund__noti">'-' 는 제외하고 입력해주세요.</p>
                    </dd>
                </dl>

                <div class="br__refund__line refund"></div>
                <p class="br__refund__txt">
                    Only one account can be registered. Please fill out the registered account as accurately as possible as the refund amount will be deposited to the account when the cash payment order is cancelled.
                </p>
            </div>
            <!-- EOD : 등록된 계좌 없을 때 / 변경할 때-->

        </div>

        <div class="br__login__info" id="devDivModifyBtnGroup" style="display:none;">
            <div class="information__btn">
                <button type="button" class="information__btn__join" id="devRefundAccountItemDelete">Delete</button>
                <button type="button" class="information__btn__login" id="devRefundAccountItemModify">Change</button>
            </div>
        </div>

        <div class="br__login__info" id="devDivSaveBtnGroup" style="display:none;">
            <div class="information__btn">
                <button type="button" class="information__btn__join" id="devRefundAccountModifyCancel">Cancel</button>
                <button type="button" class="information__btn__login" id="devRefundAccountItemSave">Save</button>
            </div>
        </div>
    </form>
</section>