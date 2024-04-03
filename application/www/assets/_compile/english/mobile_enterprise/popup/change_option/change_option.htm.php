<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/popup/change_option/change_option.htm 000002404 */ 
$TPL_product_gift_1=empty($TPL_VAR["product_gift"])||!is_array($TPL_VAR["product_gift"])?0:count($TPL_VAR["product_gift"]);?>
<script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/minicart.js?version=<?php echo CLIENT_VERSION?>" data-url="/controller/product/loadOptionDatas/<?php echo $TPL_VAR["pid"]?>" id="devMinicartScript"></script>

<div class="br__goods-view br__cart__change"> <!-- 디자인 적용을 위한 wrap 태그 -->

    <div class="goods-info" id="devSildeMinicartArea" data-pid="<?php echo $TPL_VAR["pid"]?>" data-cart_Ix="<?php echo $TPL_VAR["cartIx"]?>" data-pcount="<?php echo $TPL_VAR["pcount"]?>">
        <div class="devForbizTpl" id="devSildeLonelyOption">
            <span id="devSildeLonelyOptionName">
                <p>{[option_name]}</p>
            </span>
        </div>
        <div id="devSildeMinicartOptions"></div>


        <!--사은품-->
<?php if($TPL_VAR["product_gift"]){?>
        <div class="br__cart__change-freebie">
            <h4 class="goods-info__set__title">Free Gift Select</h4>

            <ul class="goods-info__set__list">
<?php if($TPL_product_gift_1){$TPL_I1=-1;foreach($TPL_VAR["product_gift"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1<$TPL_VAR["gift_selectbox_cnt"]){?>
                <li class="goods-info__set__box">
                    <select class="devProductGift_<?php echo $TPL_I1?> devGiftSelect" data-idx="<?php echo $TPL_I1?>">
                        <option value="">Please select </option>
<?php if(is_array($TPL_R2=$TPL_V1["product_gift_detail"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                        <option value="<?php echo $TPL_V2["pid"]?>" <?php if($TPL_V2["status"]=='soldout'){?> disabled <?php }?> ><?php echo $TPL_V2["pname"]?> <?php if($TPL_V2["status"]=='soldout'){?>[Out of stock]<?php }?></option>
<?php }}?>
                    </select>
                </li>
<?php }?>
<?php }}?>

            </ul>
        </div>
<?php }?>

        <div class="freebie-select__btns">
            <button type="button" class="freebie-select__btns__cancel close">Cancel</button>
            <button type="button" class="freebie-select__btns__submit devChangeOption">Change</button>
        </div>
    </div>

</div>