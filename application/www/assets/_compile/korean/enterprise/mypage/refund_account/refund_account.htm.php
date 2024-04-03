<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/refund_account/refund_account.htm 000004004 */ 
$TPL_bankList_1=empty($TPL_VAR["bankList"])||!is_array($TPL_VAR["bankList"])?0:count($TPL_VAR["bankList"]);?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<div class="wrap-mypage fb__refund-account">
    <h2 class="fb__mypage__title">환불계좌 관리</h2>
    <p class="fb__refund-account__annc">
        · 계좌는 1개만 등록 가능하며 본인명의 계좌만 등록/변경 가능합니다. <br />
        · 등록된 계좌는 현금결제 주문취소 시 해당 계좌로 환불 금액이 입금 되오니 정확하게 기입해 주시기 바랍니다.
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
                    <th>은행명</th>
                    <th>예금주</th>
                    <th>계좌번호</th>
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
                            <button type="button" class="btn-xs btn-dark " id="devRefundAccountItemModify" data-bankix="{[bank_ix]}" data-bankcode="{[bank_code]}" data-bankowner="{[bank_owner]}">변경</button>
                            <button type="button" class="btn-xs btn-white " id="devRefundAccountItemDelete" data-bankix="{[bank_ix]}">삭제</button>
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
                            <option value="">선택</option>
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
                            <button type="button" class="refund-delete__btn" id="devRefundAccountModifyCancel" style="display:none;">취소</button>
                            <button type="button" class="refund-delete__btn" id="devRefundAccountItemSave" data-bankix="">저장</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

    </form>
</div>