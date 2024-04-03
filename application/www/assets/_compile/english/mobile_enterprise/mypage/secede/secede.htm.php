<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/secede/secede.htm 000006827 */ 
$TPL_reason_1=empty($TPL_VAR["reason"])||!is_array($TPL_VAR["reason"])?0:count($TPL_VAR["reason"]);?>
<!--<h1 class="wrap-title">
    회원탈퇴
    <button class="back"></button>
</h1>-->

<section class="br__join br__secede">
    <form id="devSecedeForm" data-shopname="<?php echo $TPL_VAR["companyInfo"]["shop_name"]?>">
        <input type="hidden" name="withdrawCode" value="<?php echo $TPL_VAR["withdrawCode"]?>" />
        <div class="br__mypage__pass">
            <p class="pass-title">Delete Account</p>
        </div>
        <div class="br__secede__info">
            Thank you for using <strong>Barrel</strong><br/>
            Please be sure to read the following before the membership withdrawal
        </div>

        <ul class="info__txt">
            <li>
                <p class="info__txt-number">Unable to re-enroll with existing ID.</p>
                <p class="info__txt-bullet">When applying for membership withdrawal, the ID is withdrawn and cannot be registered with the same ID.</p>
                <p class="info__txt-bullet">You can sign up with a new ID when you re-enroll.</p>
            </li>
            <li>
                <p class="info__txt-number">The coupons and mileage you currently own will expire immediately upon membership withdrawal.</p>
            </li>
            <li>
                <p class="info__txt-number">Posts in the product reviews and product statements you have previously completed will not be deleted even when you withdraw from membership.</p>
                <p class="info__txt-bullet">You can sign up with a new ID when you re-enroll.</p>
            </li>
            <li>
                <p class="info__txt-number">Your order, consultation history, and my 1: 1 inquiries will not be deleted immediately upon withdrawal. It will be destroyed after a certain period of time.</p>
                <p class="info__txt-bullet">Your order will be destroyed after 5 years.</p>
                <p class="info__txt-bullet">Order consultation history, my 1: 1 inquiry will be destroyed after 3 years.</p>
            </li>
            <li>
                <p class="info__txt-number">You can&#39;t delete your account if you have a transaction in progress.</p>
                <p class="info__txt-bullet">Only if your order status were in “Order accepted / Return accepted /  Cancellation”, withdrawal is possible.</p>
            </li>
        </ul>

        <dl class="br__join__list">
            <dt>Reasons for withdrawal.</dt>
            <dd>
                <select name="drop_ix" title="Reasons for withdrawal." id="devWithdrawReason">
                    <option value="">Select reason for withdrawal.</option>
<?php if($TPL_reason_1){foreach($TPL_VAR["reason"] as $TPL_V1){?><option value="<?php echo $TPL_V1["drop_ix"]?>"><?php echo $TPL_V1["dp_name"]?></option><?php }}?>
                </select>
            </dd>
        </dl>

        <dl class="br__join__list">
            <dt>Other opinion</dt>
            <dd>
                <textarea class="br__secede-area" name="other_reason"></textarea>
            </dd>
        </dl>

        <div class="br__login__info secede__btn">
            <div class="information__btn">
                <button class="information__btn__login" id="devSecedeCancel">Cancel</button>
                <input type="submit" class="information__btn__join" value="Delete Account" id="devSecedeSubmit" />
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