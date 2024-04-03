<?php /* Template_ 2.2.8 2023/05/30 10:30:06 /home/barrel-stage/application/www/assets/templet/enterprise/popup/freebie_select/freebie_select.htm 000002574 */ 
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);?>
<?php if($TPL_VAR["freeGift"]){?>
<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<div class="freebie-select">
    <input type="hidden" id="cart_ix" value="<?php echo $TPL_VAR["cartIx"]?>" />
    <input type="hidden" id="gift_title" value="<?php echo $TPL_V1["gift_title"]?>" />
    <ul class="freebie-select__list">

<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["status"]=='sale'){?>
        <li class="freebie-select__box js__freebie__count-target devGiftList" data-pid="<?php echo $TPL_V2["pid"]?>" data-fg_ix="<?php echo $TPL_V1["fg_ix"]?>" >
            <figure class="freebie-select__box__thumb">
                <img src="<?php echo $TPL_V2["image_src"]?>" alt="<?php echo $TPL_V2["pname"]?>">
            </figure>
            <p class="freebie-select__box__title"><?php echo $TPL_V2["pname"]?></p>
            <div class="control">
                <ul class="js__freebie__updown option-up-down devControlCntBox" devGiftCnt="<?php echo $TPL_V1["gift_cnt"]?>" devGiftStock="<?php echo $TPL_V2["stock"]?>">
                    <li class="devCntMinus"><button class="down"></button></li>
                    <!--<li><input type="text" value="{[allowBasicCnt]}" class="devMinicartPrdCnt"></li>-->
                    <li><input type="text" value="0" class="js__freebie__count devMinicartPrdCnt"></li>
                    <li class="devCntPlus"><button class="up"></button></li>
                </ul>
            </div>
        </li>
<?php }?>
<?php }}?>
    </ul>
    <div class="freebie-select__bottom">
        <p class="freebie-select__desc">선택 가능한 사은품 :
            <span class="freebie-select__count__current" id="devSelectCnt">0</span>/<span class="freebie-select__count__total"><?php echo $TPL_V1["gift_cnt"]?></span>
        </p>
        <button type="button" class="freebie-select__submit noChoice devNoChoice" data-src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>" data-freegift_condition="<?php echo $TPL_V1["freegift_condition"]?>">사은품 선택 안함</button>
        <button type="button" class="freebie-select__submit devSubmit" data-freegift_condition="<?php echo $TPL_V1["freegift_condition"]?>">사은품 선택</button>
    </div>
</div>
<?php }}?>
<?php }?>