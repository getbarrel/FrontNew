<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/popup/freebie_select/freebie_select.htm 000002602 */ 
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);?>
<?php if($TPL_VAR["freeGift"]){?>
<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<div class="freebie-select">

    <p class="freebie-select__count">Selectable free gift(s) :
        <span class="freebie-select__count__current" id="devSelectCnt">0</span>/<span class="freebie-select__count__total"><?php echo $TPL_V1["gift_cnt"]?></span>
    </p>
    <input type="hidden" id="cart_ix" value="<?php echo $TPL_VAR["cartIx"]?>" />
    <input type="hidden" id="gift_title" value="<?php echo $TPL_V1["gift_title"]?>" />
    <ul class="freebie-select__list">
<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["status"]=='sale'){?>
        <li class="freebie-select__box devGiftList" data-pid="<?php echo $TPL_V2["pid"]?>" data-fg_ix="<?php echo $TPL_V1["fg_ix"]?>">
            <figure class="freebie-select__box__thumb">
                <img src="<?php echo $TPL_V2["image_src"]?>" alt="<?php echo $TPL_V2["pname"]?>">
            </figure>
            <p class="freebie-select__box__title"><?php echo $TPL_V2["pname"]?></p>
            <div class="control">
                <ul class="option-up-down devControlCntBox" devGiftCnt="<?php echo $TPL_V1["gift_cnt"]?>" devGiftStock="<?php echo $TPL_V2["stock"]?>">
                    <li class="devCntMinus"><button class="down"></button></li>
                    <!--<li><input type="text" value="{[allowBasicCnt]}" class="devMinicartPrdCnt"></li>-->
                    <li><input type="text" value="0" class="devMinicartPrdCnt"></li>
                    <li class="devCntPlus"><button class="up"></button></li>
                </ul>
            </div>
        </li>
<?php }?>
<?php }}?>
    </ul>

    <div class="freebie-select__btns">
        <!--<button type="button" class="freebie-select__btns__cancel close">취소</button>-->
        <button type="button" class="freebie-select__btns__cancel devNoChoice" data-src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>" data-freegift_condition="<?php echo $TPL_V1["freegift_condition"]?>">No select Free Gift</button>
        <button type="button" class="freebie-select__btns__submit devSubmit" data-freegift_condition="<?php echo $TPL_V1["freegift_condition"]?>">Free Gift Select</button>
    </div>
</div>
<?php }}?>
<?php }?>