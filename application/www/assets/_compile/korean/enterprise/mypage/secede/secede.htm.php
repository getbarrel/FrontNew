<?php /* Template_ 2.2.8 2024/01/17 13:24:24 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/secede/secede.htm 000003193 */ 
$TPL_reason_1=empty($TPL_VAR["reason"])||!is_array($TPL_VAR["reason"])?0:count($TPL_VAR["reason"]);?>
<section class="fb__mypage fb__secede">
    <form id="devSecedeForm" data-shopname="<?php echo $TPL_VAR["companyInfo"]["shop_name"]?>">
        <input type="hidden" name="withdrawCode" value="<?php echo $TPL_VAR["withdrawCode"]?>" />

        <h2 class="fb__mypage__title">회원탈퇴</h2>

        <p class="fb__secede__annc">
            그동안 <?php echo $TPL_VAR["companyInfo"]["shop_name"]?>를 이용해주셔서 감사합니다.<br>
            회원탈퇴 전 다음 사항을 꼭 숙지하시기 바랍니다.
        </p>

        <div class="secede-box">
            <dl>
                <dt>1. 탈퇴 이후 가입시, 탈퇴 전 개인정보는 복원되지 않습니다.</dt>
                <dd>· 탈퇴 전의 회원정보, 주문정보, 마일리지, 쿠폰 등은 복원되지 않습니다.</dd>
            </dl>
            <dl>
                <dt>2. 기존에 작성하신 상품후기, 상품문의 등의 게시물은 탈퇴 후에도 삭제되지 않습니다.</dt>
				<dd>· 작성하신 게시물의 삭제를 원하실 경우 직접 삭제 후 탈퇴바라며, 삭제가 불가능하신 경우 고객센터로 문의 바랍니다.</dd>
				<dd>· 주문 내역은 5년이 지난 경우에 자동 파기 처리됩니다.</dd>
				<dd>· 주문 상담 내역, 나의 1:1 문의는 3년이 지난 경우 자동 파기 처리됩니다.</dd>
            </dl>
            <dl>
                <dt>3. 현재 진행중인 거래 건이 있는 경우 탈퇴가 불가능합니다.</dt>
                <dd>· 모든 상품의 주문 상태가 구매 확정, 반품확정, 취소 완료인 경우에만 탈퇴가 가능합니다.</dd>
            </dl>
        </div>


        <table class="join-table">
            <colgroup>
                <col width="210px">
                <col width="*">
            </colgroup>
            <tbody>
            <tr>
                <th scope="col" class="ver-m"><label><em class="star">*</em>탈퇴사유</label></th>
                <td>
                    <select name="drop_ix" style="width:400px;" title="탈퇴사유" id="devWithdrawReason">
                        <option value="">탈퇴사유 선택</option>
<?php if($TPL_reason_1){foreach($TPL_VAR["reason"] as $TPL_V1){?><option value="<?php echo $TPL_V1["drop_ix"]?>"><?php echo trans($TPL_V1["dp_name"])?></option><?php }}?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="col">기타의견</th>
                <td>
                    <textarea name="other_reason" title="기타의견 입력 영역"></textarea>
                </td>
            </tr>
        </table>

        <div class="fb__join-footer">
            <button type="button" class="btn-lg btn-dark-line" id="devSecedeCancel">취소</button>
            <input type="submit" class="btn-lg btn-dark" value="회원탈퇴" id="devSecedeSubmit" />
        </div>
    </form>
</section>