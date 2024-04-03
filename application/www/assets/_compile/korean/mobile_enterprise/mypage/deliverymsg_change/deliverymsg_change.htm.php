<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/deliverymsg_change/deliverymsg_change.htm 000002546 */ 
$TPL_msgInfo_1=empty($TPL_VAR["msgInfo"])||!is_array($TPL_VAR["msgInfo"])?0:count($TPL_VAR["msgInfo"]);?>
<form name="devDeliveryMsgForm" id="devDeliveryMsgForm">
    <input type="hidden" name="oid" id="oid" value="<?php echo $TPL_VAR["oid"]?>" />
    <section class="br__obrder-detail">
        <h2 class="br__order-detail__title">배송요청사항 변경</h2>

        <div class="br__order-msg">
<?php if($TPL_msgInfo_1){foreach($TPL_VAR["msgInfo"] as $TPL_V1){?>
            <div class="order-msg">
                <p class="order-msg__title">배송요청사항</p>
                <div class="info-addr__recent__select devDeliveryMessageContents">
                    <div class="info-buyer__form info-buyer__form--request">
                        <select class="devDeliveryMessageSelectBox">
                            <option>부재 시 경비실에 맡겨주세요.</option>
                            <option>부재 시 휴대폰으로 연락주세요.</option>
                            <option>집 앞에 놓아주세요.</option>
                            <option>배송 전에 연락주세요.</option>
                            <option value="direct" selected>직접입력</option>
                        </select>
                        <div class="order-msg__request js__counting devDeliveryMessageDirectContents">
                            <textarea class="js__counting__textarea order-msg__request__textarea" maxlength="30" name="deliveryMsg[<?php echo $TPL_V1["msg_ix"]?>]" id="deliveryMsg_<?php echo $TPL_V1["msg_ix"]?>" data-ix="<?php echo $TPL_V1["msg_ix"]?>" data-msgtype="<?php echo $TPL_V1["msg_type"]?>" placeholder="30자 이내로 입력해 주세요."><?php echo $TPL_V1["msg"]?></textarea>
                            <div class="order-msg__request__counting">
                                <span><em class="js__counting__num devDeliveryMessageByte">0</em>/30 자</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php }}?>

            <div class="order-msg__btn__wrap">
                <a class="order-msg__btn order-msg__btn--cancel" id="devMsgCancelBtn">취소</a>
                <a class="order-msg__btn order-msg__btn--submit" id="devMsgSubmitBtn">변경</a>
            </div>
        </div>
    </section>


</form>