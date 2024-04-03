<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/refund_account/refund_account.htm 000004009 */ 
$TPL_bankList_1=empty($TPL_VAR["bankList"])||!is_array($TPL_VAR["bankList"])?0:count($TPL_VAR["bankList"]);?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<div class="wrap-mypage fb__refund-account">
    <h2 class="fb__mypage__title">Refund account management</h2>
    <p class="fb__refund-account__annc">
        · Only one account can be registered. Only one account under my name can be registered/ changed. <br />
        · Please fill in the registered account correctly as the refund amount will be deposited to the account when the cash payment order is cancelled.
    </p>
    <form id="devRefundAccountForm">
        <input type="hidden" name="page" id="devPage" value="1" />
        <table class="table-default">
            <colgroup>
                <col width="170px">
                <col width="210px">
                <col width="*">
                <col width="110px">
            </colgroup>
            <thead>
                <tr>
                    <th>Bank</th>
                    <th>account holder</th>
                    <th>Account number</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="devRefundAccountContent">
                <tr class="fb__refund-account__complete devForbizTpl" id="devRefundAccountList">
                    <td>{[bank_name]}</td>
                    <td>{[bank_owner]}</td>
                    <td class="fb__n">{[bank_number]}</td>
                    <td class="txt-r">
                        <div class="td-btn-area">
                            <button type="button" class="btn-xs btn-dark " id="devRefundAccountItemModify" data-bankix="{[bank_ix]}" data-bankcode="{[bank_code]}" data-bankowner="{[bank_owner]}">Change</button>
                            <button type="button" class="btn-xs btn-white " id="devRefundAccountItemDelete" data-bankix="{[bank_ix]}">Delete</button>
                        </div>
                    </td>
                </tr>

                <tr class="devForbizTpl" id="devRefundAccountLoading">
                    <td colspan="4">
                        <div class="wrap-loading">
                            <div class="loading"></div>
                        </div>
                    </td>
                </tr>
                
                <tr class="devForbizTpl" id="devRefundAccountReplaceForm">
                    <td class="refund__input--info refund__input--banking">
                        <select name="bank_code" class="bank_code" title="은행명" id="devBankCode">
                            <option value="">Select</option>
<?php if($TPL_bankList_1){foreach($TPL_VAR["bankList"] as $TPL_K1=>$TPL_V1){?><option value="<?php echo $TPL_K1?>"><?php echo $TPL_V1?></option><?php }}?>
                        </select>
                    </td>
                    <td class="refund__input--info">
                        <input type="text" name="bank_owner" class="bank_owner" value="" title="예금주" id="devBankOwner">
                    </td>
                    <td class="refund__input--info">
                        <input type="text" name="bank_number" class="bank_number" value="" title="계좌번호" id="devBankNumber">
                        <p class="refund__input--info__noti">'-' 는 제외하고 입력해주세요.</p>
                    </td>
                    <td class="refund__input--info txt-r">
                        <div>
                            <button type="button" class="refund-delete__btn" id="devRefundAccountModifyCancel" style="display:none;">Cancel</button>
                            <button type="button" class="refund-delete__btn" id="devRefundAccountItemSave" data-bankix="">Save</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

    </form>
</div>