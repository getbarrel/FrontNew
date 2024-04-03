<?php /* Template_ 2.2.8 2021/10/19 17:30:16 /home/barrel-stage/application/www/assets/templet/enterprise/popup/apply_stock/apply_stock.htm 000005660 */ 
$TPL_optionData_1=empty($TPL_VAR["optionData"])||!is_array($TPL_VAR["optionData"])?0:count($TPL_VAR["optionData"]);?>
<!-- 입고신청알림 -->
<div class="goods-alarm apply-stock">
    <form id="devReStock">
        <input type="hidden" name="pid" value="<?php echo $TPL_VAR["id"]?>" />
        <div class="goods-alarm__scroll">
            <h3 class="goods-alarm__title">Request for restock notification!</h3>
            <p class="goods-alarm__desc">SMS will be sent to registered mobile number upon restock of the product</p>
            <div class="goods-alarm__goods">
                <figure class="goods-alarm__goods__thumb">
                    <img src="<?php echo $TPL_VAR["image_src"]?>" alt="">
                </figure>
                <div class="goods-alarm__goods__info">
                    <p class="goods-alarm__goods__title"><?php echo $TPL_VAR["pname"]?></p>
                    <p class="goods-alarm__goods__option"><?php echo $TPL_VAR["add_info"]?></p>
                    <div class="goods-alarm__goods__price">
<?php if($TPL_VAR["discount_rate"]> 0){?><span class="goods-alarm__goods__strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span><?php }?>
                        <span class="goods-alarm__goods__result"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php if($TPL_VAR["discount_rate"]> 0){?><span class="goods-alarm__goods__discount"><span><?php echo $TPL_VAR["discount_rate"]?></span>%</span><?php }?>
                    </div>
                </div>
            </div>

            <div class="goods-alarm__options">
<?php if($TPL_VAR["opn_id"]){?>
                <p class="goods-alarm__options__title"><?php echo ('선택')?> <span><?php echo $TPL_VAR["option_div"]?></span></p>
                <input type="hidden" name="option_id" value="<?php echo $TPL_VAR["opn_id"]?>" />
<?php }else{?>
                <p class="goods-alarm__options__title"><?php echo ('사이즈')?> <span id="devSizeInfoStock"></span></p>
                <!-- 버튼박스 인경우 노출 -->
                <ul class="goods-alarm__options__list">
<?php if($TPL_optionData_1){$TPL_I1=-1;foreach($TPL_VAR["optionData"] as $TPL_V1){$TPL_I1++;?>
<?php if(is_array($TPL_R2=$TPL_V1["optionDetailList"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
                    <li class="goods-alarm__options__box">
                        <input type="radio" value="<?php echo $TPL_V2["division"]?>" id="alarm_option<?php echo $TPL_I1?><?php echo $TPL_I2?>" name="option_id" class="devReStockSelect" title="옵션" data-info="<?php echo $TPL_V2["option_div"]?>" <?php if($TPL_V2["option_stock"]> 0){?> disabled <?php }?>>
                        <label class="goods-alarm__options__btn" for="alarm_option<?php echo $TPL_I1?><?php echo $TPL_I2?>"><?php echo $TPL_V2["shot_option_div"]?></label>
                    </li>
<?php }}?>
<?php }}?>
                    <!--
                    <li class="goods-alarm__options__box">
                        <button class="goods-alarm__options__btn" disabled>XS</button>
                    </li>
                    <li class="goods-alarm__options__box">
                        <button class="goods-alarm__options__btn goods-alarm__options__btn--active">XS</button>
                    </li>
                    -->
                </ul>
<?php }?>
            </div>
            <div class="goods-alarm__phone">
                <dl class="goods-alarm__phone__default">
                    <dt>Mobile number</dt>
                    <dd><?php echo $TPL_VAR["pcs"]?></dd>
                    <input type="hidden" name="pcs"  value="<?php echo $TPL_VAR["pcs"]?>">
                </dl>
                <label class="goods-alarm__phone__check">
                    <input type="checkbox" name="change_pcs" id="devChangePcs" value="Y">
                    <span>Change Mobile</span>
                </label>
                <div class="goods-alarm__phone__new">
                    <select name="pcs1" id="devPcs1" disabled>
                        <option value="010">010</option>
                        <option value="011">011</option>
                        <option value="016">016</option>
                        <option value="017">017</option>
                        <option value="018">018</option>
                        <option value="019">019</option>
                    </select>
                    <span>-</span>
                    <input type="text" name="pcs2" id="devPcs2" title="휴대폰번호" disabled>
                    <span>-</span>
                    <input type="text" name="pcs3" id="devPcs3" title="휴대폰번호"  disabled>
                </div>
            </div>
            <ul class="goods-alarm__notice">
                <li class="goods-alarm__notice__desc">Completed SMS request of the product is saved as a restock notification list</li>
                <li class="goods-alarm__notice__desc">Product information such as price and option configuration of SMS requested product may vary, please check product information upon restock prior to purchase.</li>
                <li class="goods-alarm__notice__desc">Restock SMS notification is valid for 15 days from the requested date.</li>
            </ul>
            <buttton class="goods-alarm__submit" id="devSumbitBtn">Register</buttton>
        </div>
    </form>
</div>