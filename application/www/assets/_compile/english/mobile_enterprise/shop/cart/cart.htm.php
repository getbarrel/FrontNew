<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/cart/cart.htm 000016726 */ 
$TPL_cart_1=empty($TPL_VAR["cart"])||!is_array($TPL_VAR["cart"])?0:count($TPL_VAR["cart"]);?>
<script>
	var emnet_tagm_products=[];
</script>

<?php if($TPL_cart_1){foreach($TPL_VAR["cart"] as $TPL_V1){
$TPL_deliveryTemplateList_2=empty($TPL_V1["deliveryTemplateList"])||!is_array($TPL_V1["deliveryTemplateList"])?0:count($TPL_V1["deliveryTemplateList"]);?>
<?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){
$TPL_productList_3=empty($TPL_V2["productList"])||!is_array($TPL_V2["productList"])?0:count($TPL_V2["productList"]);?>
<?php if($TPL_productList_3){foreach($TPL_V2["productList"] as $TPL_V3){?>
<script>
	emnet_tagm_products.push({
	'name': '<?php echo $TPL_V3["pname"]?>',
	'id': '<?php echo $TPL_V3["id"]?>',
	'price': '<?php echo $TPL_V3["total_dcprice"]?>',
	'quantity': '<?php echo $TPL_V3["pcount"]?>'
	});
</script>
<?php }}?>
<?php }}?>
<?php }}?>

<!-- 장바구니 dataLayer -->
<script>
 dataLayer.push({
     'event': 'addToCart',
     'ecommerce': {
         'currencyCode': 'KRW',
         'add': {
         'products': emnet_tagm_products
         }
     }
 });
</script>


<input type="hidden" class="devProductSoldOut" value="<?php echo $TPL_VAR["isPrdSoldOut"]?>" />
<p class="br__cart__has-soldout" id="devSoldOutProductView" style="display: none;">There is a sold out item in the cart.</p>
<section class="br__cart">
    <h2 class="br__cart__title">Cart</h2>

    <div class="br__cart__content">
<?php if($TPL_VAR["cart"]){?>
        <div class="cart-notice">
            <p class="cart-notice__title">Online Ordering and Delivery Guidance</p>
            <ul class="cart-notice__list">
                <li class="cart-notice__desc">· Cancellation is not possible, when your order status is in ""Preparing/Shipped"".</li>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <li class="cart-notice__desc">· If the account is not paid within 24 hours, the order will automatically be cancelled.</li>
<?php }?>
            </ul>
        </div>
        <div class="cart-top">
            <div class="cart-top__info">
                <input type="checkbox" id="cart_all_check" class="devChangePriceEvent" checked>
                <label for="cart_all_check">Select All </label>
                <span class="cart-top__info__total"><span>Item Total</span><span><?php echo $TPL_VAR["cartCnt"]?></span></span>
            </div>
            <div class="cart-top__del">
                <button class="cart-top__del__btn" id="devSelectDeleteButton">Delete Selection</button>
            </div>

        </div>
<?php if($TPL_cart_1){$TPL_I1=-1;foreach($TPL_VAR["cart"] as $TPL_V1){$TPL_I1++;
$TPL_deliveryTemplateList_2=empty($TPL_V1["deliveryTemplateList"])||!is_array($TPL_V1["deliveryTemplateList"])?0:count($TPL_V1["deliveryTemplateList"]);?>
<?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){
$TPL_productList_3=empty($TPL_V2["productList"])||!is_array($TPL_V2["productList"])?0:count($TPL_V2["productList"]);?>
        <div class="cart-item">

            <!-- 필요 없을 경우 삭제 -->
            <div class="top" style="display:none;">
                <input type="checkbox" class="cart_company_check devChangePriceEvent" id="<?php echo $TPL_V1["company_id"]?>" checked>
                <label for="<?php echo $TPL_V1["company_id"]?>"><?php echo $TPL_V1["com_name"]?></label>
            </div>


            <ul class="cart-item__list">
<?php if($TPL_productList_3){foreach($TPL_V2["productList"] as $TPL_V3){
$TPL_setData_4=empty($TPL_V3["setData"])||!is_array($TPL_V3["setData"])?0:count($TPL_V3["setData"]);
$TPL_addOptionList_4=empty($TPL_V3["addOptionList"])||!is_array($TPL_V3["addOptionList"])?0:count($TPL_V3["addOptionList"]);
$TPL_giftItem_4=empty($TPL_V3["giftItem"])||!is_array($TPL_V3["giftItem"])?0:count($TPL_V3["giftItem"]);?>
                <li class="devProductContents cart-item__box">
                    <label class="cart-item__check">
                        <input type="checkbox" class="cart_product_check devChangePriceEvent devCartIx" <?php if($TPL_V3["status"]=='sale'){?>checked<?php }else{?>disabled<?php }?> value="<?php echo $TPL_V3["cart_ix"]?>">
                    </label>
                    <figure class="cart-item__thumb">
                        <a href="/shop/goodsView/<?php echo $TPL_V3["id"]?>">
                            <img src="<?php echo $TPL_V3["image_src"]?>" alt="<?php echo $TPL_V3["brand_name"]?> <?php echo $TPL_V3["pname"]?>">
                        </a>
                    </figure>
                    <div class="cart-item__info">
                        <p class="cart-item__info__title"><?php echo $TPL_V3["brand_name"]?> <?php echo $TPL_V3["pname"]?></p>
<?php if($TPL_V3["set_group"]> 0){?>                        <input type="hidden" name="cartType" class="cartType" value="set" />
<?php if(!empty($TPL_V3["add_info"])){?>
                        <p class="cart-item__info__option"><?php echo $TPL_V3["add_info"]?></p>
<?php }?>
                        <p class="cart-item__info__option">
<?php if($TPL_setData_4){foreach($TPL_V3["setData"] as $TPL_V4){?>
<?php if($TPL_I1!= 0){?> | <?php }?><?php echo $TPL_V4["options_text"]?>

<?php }}?>
                        </p>
<?php }else{?>                        <input type="hidden" name="cartType" class="cartType"  value="" />
<?php if(!empty($TPL_V3["add_info"])){?>
                        <p class="cart-item__info__option"><?php echo $TPL_V3["add_info"]?></p>
<?php }?>
                        <p class="cart-item__info__option"><?php echo $TPL_V3["options_text"]?> / Quantity: <?php echo $TPL_V3["pcount"]?></p>
<?php }?>

                        <p class="cart-item__info__price">
<?php if($TPL_V3["status"]=='stop'){?>
                            <span class="cart-item__info__price--stop">Out of stock</span>
<?php }elseif($TPL_V3["status"]=='ready'){?>
                            <span class="cart-item__info__price--stop">For Sale</span>
<?php }elseif($TPL_V3["status"]=='end'){?>
                            <span class="cart-item__info__price--stop">Sales End</span>
<?php }?>

<?php if($TPL_V3["listprice"]>$TPL_V3["dcprice"]){?>
                            <span class="cart-item__info__price--strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V3["listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php }?>
                            <span class="cart-item__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V3["dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php if($TPL_V3["discount_rate"]){?>
                            <span class="cart-item__info__price--discount">[<?php echo $TPL_V3["discount_rate"]?>%]</span>
<?php }?>

<?php if($TPL_V3["status"]=='soldout'){?>
                            <span class="cart-item__info__price--soldout">
                                Out of stock
                            </span>
<?php }?>

                        </p>

                        <div class="cart-item__info__count">
                            <div class="control">
                                <ul class="option-up-down">
                                    <li><button class="down devCountDownButton" <?php if($TPL_V3["status"]=='soldout'||$TPL_V3["status"]=='stop'||$TPL_V3["status"]=='ready'||$TPL_V3["status"]=='end'){?>disabled<?php }?>></button></li>
                                    <li><input type="text" value="<?php echo $TPL_V3["pcount"]?>" class="devCount" <?php if($TPL_V3["status"]=='soldout'||$TPL_V3["status"]=='stop'||$TPL_V3["status"]=='ready'||$TPL_V3["status"]=='end'){?>disabled<?php }?>/></li>
                                    <li><button class="up devCountUpButton" <?php if($TPL_V3["status"]=='soldout'||$TPL_V3["status"]=='stop'||$TPL_V3["status"]=='ready'||$TPL_V3["status"]=='end'){?>disabled<?php }?>></button></li>
                                </ul>
                            </div>
                            <button class="cart-item__info__count--change devCountUpdateButton" <?php if($TPL_V3["status"]=='soldout'||$TPL_V3["status"]=='stop'||$TPL_V3["status"]=='ready'||$TPL_V3["status"]=='end'){?>disabled<?php }?>>Change</button>
                        </div>
                    </div>
                    <div>
<?php if($TPL_V3["status"]=='sale'&&$TPL_V3["stock"]<$TPL_V3["pcount"]){?>
                        <p class="txt-error">You can order up to <?php echo $TPL_VAR["addOptionList"]["stock"]?> quantity.</p>
<?php }?>
                        <!--
                        <button class="btn-s btn-point-line btn-payment devDirectBuyButton" <?php if($TPL_V3["status"]!='sale'){?>disabled<?php }?>>바로구매</button>
                        -->
                    </div>
<?php if($TPL_V3["addOptionList"]){?>
                    <div class="add-product__wrap">
                        <p class="add-product__title">Additional configuration product</p>
<?php if($TPL_addOptionList_4){foreach($TPL_V3["addOptionList"] as $TPL_V4){?>
                        <div class="add-product devAddOptionContents">
                            <input type="hidden" class="devCartOptionIx" value="<?php echo $TPL_V4["cart_option_ix"]?>"/>

                            <p class="add-product__name"><?php echo $TPL_V4["opn_text"]?></p>
                            <div class="control">
<?php if($TPL_V4["stock"]> 0){?>
                                <ul class="option-up-down">
                                    <li><button class="down devAddCountDownButton"></button></li>
                                    <li><input type="text" value="<?php echo $TPL_V4["opn_count"]?>" class="devAddCount"/></li>
                                    <li><button class="up devAddCountUpButton"></button></li>
                                </ul>
                                <button class="add-product__change devAddOptionCountUpdateButton">Change</button>
                                <p class="add-product__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V4["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
<?php if($TPL_V4["stock"]<$TPL_V4["opn_count"]){?>
                                <p class="txt-error mat10">You can order up to <?php echo $TPL_V4["stock"]?> quantity.</p>
<?php }?>
<?php }else{?>
                                <p class="price">Out of stock</p>
<?php }?>
                            </div>
                            <button class="item-del-btn devAddOptionDeleteButton">Delete</button>
                        </div>
<?php }}?>
                    </div>
<?php }?>


                    <div class="cart-item__change">
                        <button type="button" class="cart-item__change__btn" data-pid="<?php echo $TPL_V3["id"]?>" data-cart_ix="<?php echo $TPL_V3["cart_ix"]?>" data-pcount="<?php echo $TPL_V3["pcount"]?>" <?php if($TPL_V3["status"]=='soldout'||$TPL_V3["status"]=='stop'||$TPL_V3["status"]=='ready'||$TPL_V3["status"]=='end'){?>disabled<?php }?>>Change Options</button>


                        <span class="cart-item__change__price">Total : <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V3["total_dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                    </div>

                    <div class="cart-item__option">
                        <p class="cart-item__option__title">Size</p>
                        <!--<p class="cart-item__option__title">옵션상품</p>-->

                        <!-- [S] 반복 -->
                        <div class="cart-item__option__select">
                            <select>
                                <option disabled selected>[required] Please select the option</option>
                                <option>Option Value</option>
                            </select>
                        </div>
                        <!-- [E] 반복 -->

                        <div class="cart-item__option__btns">
                            <button class="cart-item__option__btns--submit">Change</button>
                            <button type="button" class="cart-item__option__btns--cancel">{=trans(''취소)}</button>
                        </div>
                    </div>

<?php if(count($TPL_V3["giftItem"])> 0){?>                    <div class="cart-item__freebie">
                        <p class="cart-item__freebie__title"><span>GIft</span> <?php echo $TPL_VAR["giftItem"]["gift_title"]?></p>
                        <ul class="cart-item__freebie__list">
<?php if($TPL_giftItem_4){foreach($TPL_V3["giftItem"] as $TPL_V4){?>
                            <li class="cart-item__freebie__box devGiftList" data-status="<?php echo $TPL_V4["status"]?>">
                                <div class="cart-item__freebie__thumb">
                                    <figure>
                                        <img src="<?php echo $TPL_V4["image_src"]?>" alt="<?php echo $TPL_V4["gift_name"]?>">
                                    </figure>
                                </div>
                                <div class="cart-item__freebie__info">
                                    <p class="cart-item__freebie__text"><?php echo $TPL_V4["gift_name"]?> / <?php echo $TPL_V4["cnt"]?>개 <?php if($TPL_V4["status"]=='soldout'){?> <?php if($TPL_VAR["langType"]=='korean'){?>[품절]<?php }else{?>[Out of stock]<?php }?> <?php }?></p>
                                </div>

                            </li>
<?php }}?>
                        </ul>
                    </div>
<?php }?>
                    <button class="cart-item__del devDeleteButton">Delete</button>
                </li>
<?php }}?>
            </ul>



        </div>

<?php }}?>
        <div class="cart-item__result" devCartCompanyPriceContents="<?php echo $TPL_V1["company_id"]?>" id="devCartPriceContents">
            <dl class="cart-item__result__part">
                <dt>Number of selected products</dt>
                <dd><em id=""devSelectItemCnt"">0</em></dd>
            </dl>
            <dl class="cart-item__result__part">
                <dt>Subtotal</dt>
                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_listprice"><?php echo g_price($TPL_V1["product_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
            <dl class="cart-item__result__part">
                <dt>Item-discount</dt>
                <dd>-<?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_basic_discount_amount"><?php echo g_price($TPL_V1["product_basic_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
            <dl class="cart-item__result__part">
                <dt>Membership-discount</dt>
                <dd>-<?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_mem_discount_amount"><?php echo g_price($TPL_V1["product_mem_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
            <!--<dl class="cart-item__result__part">-->
                <!--<dt>special discount</dt>-->
                <!--<dd>-<?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_Special_discount_amount"><?php echo g_price($TPL_V1["product_Special_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>-->
            <!--</dl>-->
            <dl class="cart-item__result__part">
                <dt>Shipping fee<div class="br__delivery-desc"><span><?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){?><?php echo $TPL_V2["delivery_text"]?><?php }}?></span></div></dt>
                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="total_delivery_price"><?php echo g_price($TPL_V1["total_delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
            <dl class="cart-item__result__total">
                <dt>Estimated Total</dt>
                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="payment_price"><?php echo g_price($TPL_V1["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </dl>
        </div>
        <div class="cart-item__payment">
            <!--<button class="cart-item__payment__btn" id="devHomeButton">홈으로</button>-->
            <button class="cart-item__payment__btn" id="devBuyButton">BUY NOW</button>
        </div>
<?php }}?>

<?php }else{?>
        <div class="empty-content">
            <p>No items in cart.</p>
            <button class="btn-default btn-dark-line" id="devHomeButton">Home</button>
        </div>
<?php }?>
    </div>
</section>