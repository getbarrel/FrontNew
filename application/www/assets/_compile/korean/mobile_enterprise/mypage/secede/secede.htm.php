<?php /* Template_ 2.2.8 2022/04/22 11:16:54 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/secede/secede.htm 000006481 */ 
$TPL_reason_1=empty($TPL_VAR["reason"])||!is_array($TPL_VAR["reason"])?0:count($TPL_VAR["reason"]);?>
<!--<h1 class="wrap-title">
    회원탈퇴
    <button class="back"></button>
</h1>-->

<section class="br__join br__secede">
    <form id="devSecedeForm" data-shopname="<?php echo $TPL_VAR["companyInfo"]["shop_name"]?>">
        <input type="hidden" name="withdrawCode" value="<?php echo $TPL_VAR["withdrawCode"]?>" />
        <div class="br__mypage__pass">
            <p class="pass-title">회원탈퇴</p>
        </div>
        <div class="br__secede__info">
            그동안 <strong><?php echo $TPL_VAR["companyInfo"]["shop_name"]?></strong>을 이용해주셔서 감사합니다.<br/>
            회원탈퇴 전 다음 사항을 꼭 숙지하시기 바랍니다.
        </div>

        <ul class="info__txt">
            <li>
                <p class="info__txt-number">탈퇴 이후 가입시, 탈퇴 전 개인정보는 복원되지 않습니다.</p>
                <p class="info__txt-bullet">탈퇴 전의 회원정보, 주문정보, 마일리지, 쿠폰 등은 복원되지 않습니다.</p>
            </li>
            <li>
                <p class="info__txt-number">기존에 작성하신 상품후기, 상품문의 등의 게시물은 탈퇴 후에도 삭제되지 않습니다.</p>
				<p class="info__txt-bullet">작성하신 게시물의 삭제를 원하실 경우 직접 삭제 후 탈퇴바라며, 삭제가 불가능하신 경우 고객센터로 문의 바랍니다.</p>
				<p class="info__txt-bullet">주문 내역은 5년이 지난 경우에 자동 파기 처리됩니다.</p>
				<p class="info__txt-bullet">주문 상담 내역, 나의 1:1 문의는 3년이 지난 경우 자동 파기 처리됩니다.</p>
            </li>
            <li>
                <p class="info__txt-number">현재 진행중인 거래 건이 있는 경우 탈퇴가 불가능합니다.</p>
                <p class="info__txt-bullet">모든 상품의 주문 상태가 구매 확정, 반품확정, 취소 완료인 경우에만 탈퇴가 가능합니다.</p>
            </li>
        </ul>

        <dl class="br__join__list">
            <dt>탈퇴사유</dt>
            <dd>
                <select name="drop_ix" title="탈퇴사유" id="devWithdrawReason">
                    <option value="">탈퇴사유 선택</option>
<?php if($TPL_reason_1){foreach($TPL_VAR["reason"] as $TPL_V1){?><option value="<?php echo $TPL_V1["drop_ix"]?>"><?php echo $TPL_V1["dp_name"]?></option><?php }}?>
                </select>
            </dd>
        </dl>

        <dl class="br__join__list">
            <dt>기타사유</dt>
            <dd>
                <textarea class="br__secede-area" name="other_reason"></textarea>
            </dd>
        </dl>

        <div class="br__login__info secede__btn">
            <div class="information__btn">
                <button class="information__btn__login" id="devSecedeCancel">취소</button>
                <input type="submit" class="information__btn__join" value="회원탈퇴" id="devSecedeSubmit" />
            </div>
        </div>
    </form>
</section>


<?php if(false){?>
<div class="wrap-mypage secede">
    <form id="devSecedeForm" data-shopname="<?php echo $TPL_VAR["companyInfo"]["shop_name"]?>">
        <input type="hidden" name="withdrawCode" value="<?php echo $TPL_VAR["withdrawCode"]?>" />

        <div class="secede-title">
            그동안 <?php echo $TPL_VAR["companyInfo"]["shop_name"]?>를 이용해주셔서 감사합니다.<br>
            회원탈퇴 전 다음 사항을 꼭 숙지하시기 바랍니다.
        </div>

        <div class="secede-box">
            <dl>
                <dt>1. 기존 아이디로 재가입이 불가능 합니다.</dt>
                <dd>회원탈퇴 신청 시, 해당 아이디는 탈퇴처리 되며 동일한 아이디로 재가입할 수 없습니다.</dd>
                <dd>재가입 시 새로운 아이디로 가입이 가능합니다.</dd>
            </dl>
            <dl>
                <dt>2. 현재 회원님이 보유하고 계신 쿠폰 및 마일리지는 회원탈퇴 시 즉시 소멸됩니다.</dt>
            </dl>
            <dl>
                <dt>3. 회원님이 기존에 작성하신 상품후기, 상품문의 게시물은 회원탈퇴 시에도 삭제되지 않습니다.</dt>
                <dd>작성하신 게시물의 삭제를 원하실 경우에는 직접 삭제하신 후 탈퇴바라며, 삭제가 불가능한 경우 고객센터로 문의 바랍니다.</dd>
            </dl>
            <dl>
                <dt>4. 회원님의 주문 및 상담 내역, 1:1 문의 내역은 회원탈퇴 시 즉시 삭제되지 않으며 일정기간이 지난 후 파기됩니다.</dt>
                <dd>주문 내역은 5년이 지난 경우에 자동 파기 처리됩니다.</dd>
                <dd>주문 상담 내역, 1:1 문의 내역은 3년이 지난 경우 자동 파기 처리됩니다.</dd>
            </dl>
            <dl>
                <dt>5. 현재 진행 중인 거래 건이 있는 경우 탈퇴가 불가능합니다.</dt>
                <dd>모든 상품의 주문 상태가 구매확정, 반품확정, 교환확정, 취소완료인 경우에만 탈퇴가 가능합니다.</dd>
            </dl>
        </div>


        <div class="wrap-input-form">
            <dl>
                <dt>탈퇴사유 <em>*</em></dt>
                <dd>
                    <select name="drop_ix" style="width:100%;" title="탈퇴사유" id="devWithdrawReason">
                        <option value="">탈퇴사유 선택</option>
<?php if($TPL_reason_1){foreach($TPL_VAR["reason"] as $TPL_V1){?><option value="<?php echo $TPL_V1["drop_ix"]?>"><?php echo $TPL_V1["dp_name"]?></option><?php }}?>
                    </select>
                </dd>
            </dl>

            <dl>
                <dt>기타의견</dt>
                <dd>
                    <textarea name="other_reason"></textarea>
                </dd>
            </dl>
        </div>

        <div class="wrap-btn-area">
            <button type="button" class="btn-lg btn-dark-line" id="devSecedeCancel">취소</button>
            <input type="submit" class="btn-lg btn-point" value="회원탈퇴" id="devSecedeSubmit" />
        </div>
    </form>
</div>
<?php }?>