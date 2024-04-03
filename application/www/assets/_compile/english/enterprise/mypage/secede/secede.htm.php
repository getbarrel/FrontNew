<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/secede/secede.htm 000003591 */ 
$TPL_reason_1=empty($TPL_VAR["reason"])||!is_array($TPL_VAR["reason"])?0:count($TPL_VAR["reason"]);?>
<section class="fb__mypage fb__secede">
    <form id="devSecedeForm" data-shopname="<?php echo $TPL_VAR["companyInfo"]["shop_name"]?>">
        <input type="hidden" name="withdrawCode" value="<?php echo $TPL_VAR["withdrawCode"]?>" />

        <h2 class="fb__mypage__title">Delete Account</h2>

        <p class="fb__secede__annc">
            Thank you for using Barrel<br>
            Please be sure to read the following before the membership withdrawal
        </p>

        <div class="secede-box">
            <dl>
                <dt>1. Unable to re-enroll with existing ID.</dt>
                <dd>· When applying for membership withdrawal, the ID is withdrawn and cannot be registered with the same ID.</dd>
                <dd>· You can sign up with a new ID when you re-enroll.</dd>
            </dl>
            <dl>
                <dt>2. The coupons and mileage you currently own will expire immediately upon membership withdrawal.</dt>
            </dl>
            <dl>
                <dt>3. Posts in the product reviews and product statements you have previously completed will not be deleted even when you withdraw from membership.</dt>
                <dd>· If you want to delete your posts, please delete them firsthand and then proceed withdrawal. If you are unable to delete your posts, please contact our customer service.</dd>
            </dl>
            <dl>
                <dt>4. Your order, consultation history, and my 1: 1 inquiries will not be deleted immediately upon withdrawal. It will be destroyed after a certain period of time.</dt>
                <dd>· Your order will be destroyed after 5 years.</dd>
                <dd>· Order consultation history, my 1: 1 inquiry will be destroyed after 3 years.</dd>
            </dl>
            <dl>
                <dt>5. You can&#39;t delete your account if you have a transaction in progress.</dt>
                <dd>· Only if your order status were in “Order accepted / Return accepted / Cancellation”, withdrawal is possible. </dd>
            </dl>
        </div>


        <table class="join-table">
            <colgroup>
                <col width="210px">
                <col width="*">
            </colgroup>
            <tbody>
            <tr>
                <th scope="col" class="ver-m"><label><em class="star">*</em>Reasons for withdrawal.</label></th>
                <td>
                    <select name="drop_ix" style="width:400px;" title="탈퇴사유" id="devWithdrawReason">
                        <option value="">Select reason for withdrawal.</option>
<?php if($TPL_reason_1){foreach($TPL_VAR["reason"] as $TPL_V1){?><option value="<?php echo $TPL_V1["drop_ix"]?>"><?php echo trans($TPL_V1["dp_name"])?></option><?php }}?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="col">Other opinion</th>
                <td>
                    <textarea name="other_reason" title="기타의견 입력 영역"></textarea>
                </td>
            </tr>
        </table>

        <div class="wrap-btn-area mat30">
            <button type="button" class="btn-lg btn-dark-line" id="devSecedeCancel">Cancel</button>
            <input type="submit" class="btn-lg btn-dark" value="Delete Account" id="devSecedeSubmit" />
        </div>
    </form>
</section>