<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/popup/change_option/change_option.htm 000003242 */ 
$TPL_product_gift_1=empty($TPL_VAR["product_gift"])||!is_array($TPL_VAR["product_gift"])?0:count($TPL_VAR["product_gift"]);?>
<script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/minicart.js?version=<?php echo CLIENT_VERSION?>" data-url="/controller/product/loadOptionDatas/<?php echo $TPL_VAR["pid"]?>" id="devMinicartScript"></script>
<section>
      <div class="fb__change-option"> <!-- 디자인 적용을 위한 wrap 태그 -->
            <div class="fb__change-option__cont">
                  <div class="fb__change-option__left">
                        <figure class="fb__change-option__thumb">
                              <img src="<?php echo $TPL_VAR["thumb_src"]?>" alt="">
                        </figure>
                  </div>
                  <div class="fb__change-option__info goods-info" id="devSildeMinicartArea" data-pid="<?php echo $TPL_VAR["pid"]?>" data-cart_Ix="<?php echo $TPL_VAR["cartIx"]?>" data-pcount="<?php echo $TPL_VAR["pcount"]?>">
                        <p class="goods-info__set__title"><?php echo $TPL_VAR["pname"]?></p>
                        <div class="devForbizTpl" id="devSildeLonelyOption">
                        <span id="devSildeLonelyOptionName">
                            <p>{[option_name]}</p>
                        </span>
                        </div>
                        <div id="devSildeMinicartOptions"></div>

                        <!--사은품-->
<?php if($TPL_VAR["product_gift"]){?>
                        <div class="goods-info__set">
                              <h4 class="goods-info__set__title">Free Gift Select</h4>

                              <ul class="goods-info__set__list">
<?php if($TPL_product_gift_1){$TPL_I1=-1;foreach($TPL_VAR["product_gift"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1<$TPL_VAR["gift_selectbox_cnt"]){?>
                                    <li class="goods-info__set__box">
                                          <select class="devProductGift_<?php echo $TPL_I1?> devGiftSelect" data-idx="<?php echo $TPL_I1?>">
                                                <option value=""> Please select </option>
<?php if(is_array($TPL_R2=$TPL_V1["product_gift_detail"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                                                <option value="<?php echo $TPL_V2["pid"]?>" <?php if($TPL_V2["status"]=='soldout'){?> disabled <?php }?> > <?php echo $TPL_V2["pname"]?> <?php if($TPL_V2["status"]=='soldout'){?> [Out of stock] <?php }?></option>
<?php }}?>
                                          </select>
                                    </li>
<?php }?>
<?php }}?>

                              </ul>
                        </div>
<?php }?>
                  </div>
            </div>
            <div class="fb__change-option__btn">
                  <button type="button" class="fb__change-option__btn--cancel js__change-option__cancel">Cancel</button>
                  <button type="button" class="fb__change-option__btn--submit devChangeOption">Change</button>
            </div>
      </div>
</section>