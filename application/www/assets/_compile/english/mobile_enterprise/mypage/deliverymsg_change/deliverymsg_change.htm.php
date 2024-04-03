<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/deliverymsg_change/deliverymsg_change.htm 000002555 */ 
$TPL_msgInfo_1=empty($TPL_VAR["msgInfo"])||!is_array($TPL_VAR["msgInfo"])?0:count($TPL_VAR["msgInfo"]);?>
<form name="devDeliveryMsgForm" id="devDeliveryMsgForm">
    <input type="hidden" name="oid" id="oid" value="<?php echo $TPL_VAR["oid"]?>" />
    <section class="br__obrder-detail">
        <h2 class="br__order-detail__title">Change shipping request</h2>

        <div class="br__order-msg">
<?php if($TPL_msgInfo_1){foreach($TPL_VAR["msgInfo"] as $TPL_V1){?>
            <div class="order-msg">
                <p class="order-msg__title">배송요청사항</p>
                <div class="info-addr__recent__select devDeliveryMessageContents">
                    <div class="info-buyer__form info-buyer__form--request">
                        <select class="devDeliveryMessageSelectBox">
                            <option>Please leave it to the security office if unavailable</option>
                            <option>Please contact me by cell phone if unavailable</option>
                            <option>Place in fron to the porch</option>
                            <option>Please contact before shipping</option>
                            <option value="direct" selected>직접입력</option>
                        </select>
                        <div class="order-msg__request js__counting devDeliveryMessageDirectContents">
                            <textarea class="js__counting__textarea order-msg__request__textarea" maxlength="30" name="deliveryMsg[<?php echo $TPL_V1["msg_ix"]?>]" id="deliveryMsg_<?php echo $TPL_V1["msg_ix"]?>" data-ix="<?php echo $TPL_V1["msg_ix"]?>" data-msgtype="<?php echo $TPL_V1["msg_type"]?>" placeholder="Please write under 30 characters"><?php echo $TPL_V1["msg"]?></textarea>
                            <div class="order-msg__request__counting">
                                <span><em class="js__counting__num devDeliveryMessageByte">0</em>/30 자</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php }}?>

            <div class="order-msg__btn__wrap">
                <a class="order-msg__btn order-msg__btn--cancel" id="devMsgCancelBtn">Cancel</a>
                <a class="order-msg__btn order-msg__btn--submit" id="devMsgSubmitBtn">Change</a>
            </div>
        </div>
    </section>


</form>