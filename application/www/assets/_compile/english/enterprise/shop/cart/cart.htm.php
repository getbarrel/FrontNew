<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/shop/cart/cart.htm 000018458 */ 
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
<input type="hidden" id="devShopName" value="<?php echo $TPL_VAR["companyInfo"]["shop_name"]?>"/>
<section class="wrap-cart fb__shop fb__cart">
    <div class="fb__shop__title-area">
        <h2 class="fb__shop__title">Cart</h2>
        <ul class="fb__shop__step-area">
            <li class="fb__shop__step fb__shop__step--on"><em>01</em> Cart</li>
            <li class="fb__shop__step"><em>02</em> Check Out</li>
            <li class="fb__shop__step"><em>03</em> Order Completed</li>
        </ul>
    </div>
<?php if($TPL_VAR["cart"]){?>
    <div class="fb__cart__noti">
        Online Ordering and Delivery Guidance<br>
<?php if($TPL_VAR["langType"]=='korean'){?>
        <em>· Cancellation is not possible, when your order status is in ""Preparing/Shipped"".<br>· If the account is not paid within 24 hours, the order will automatically be cancelled.</em>
<?php }else{?>
        <em>· Cancellation is not possible, when your order status is in ""Preparing/Shipped"".</em>
<?php }?>
    </div>
    <div class="layout-section fb__cart__layout-section fb__shop__layout-section">
        <div class="top-area fb__cart__top">
                <span class="check-area fb__check-area">
                    <input type="checkbox" id="cart_all_check" class="devChangePriceEvent" checked>
                    <label for="cart_all_check">Select All </label>
                </span>
            <span class="fb__cart__total">Total<em><?php echo $TPL_VAR["cartCnt"]?></em></span>
            <button class="fb__cart__top-delete btn-s btn-white" id="devSelectDeleteButton">Delete Selection</button>
        </div>
<?php if($TPL_cart_1){$TPL_I1=-1;foreach($TPL_VAR["cart"] as $TPL_V1){$TPL_I1++;
$TPL_deliveryTemplateList_2=empty($TPL_V1["deliveryTemplateList"])||!is_array($TPL_V1["deliveryTemplateList"])?0:count($TPL_V1["deliveryTemplateList"]);?>
        <div class="layout-left">


            <section class="fb__cart__seller-box seller-box">
                <p class="fb__cart__soldout" id="devSoldOutProductView" style="display: none;">
                    There is a sold out itemst <em>in the cart</em>
                </p>
<?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){
$TPL_productList_3=empty($TPL_V2["productList"])||!is_array($TPL_V2["productList"])?0:count($TPL_V2["productList"]);?>
                    <div class="table-area fb__cart__item-wrap">
                        <table>
                            <caption>Shopping cart product group</caption>
                            <colgroup>
                                <col width="60px"/>
                                <col width="*"/>
                                <col width="220px"/>
                                <col width="100px"/>
                                <col width="110px"/>
                            </colgroup>
<?php if($TPL_productList_3){foreach($TPL_V2["productList"] as $TPL_V3){
$TPL_setData_4=empty($TPL_V3["setData"])||!is_array($TPL_V3["setData"])?0:count($TPL_V3["setData"]);
$TPL_addOptionList_4=empty($TPL_V3["addOptionList"])||!is_array($TPL_V3["addOptionList"])?0:count($TPL_V3["addOptionList"]);
$TPL_giftItem_4=empty($TPL_V3["giftItem"])||!is_array($TPL_V3["giftItem"])?0:count($TPL_V3["giftItem"]);?>
                                <tr class="fb__cart__item cart-item devProductContents <?php if($TPL_V3["status"]=='soldout'){?>sold-out<?php }elseif($TPL_V3["status"]=='stop'){?>sold-stop<?php }?>">
                                    <td>
                                        <input type="checkbox" class="cart_product_check devChangePriceEvent devCartIx" <?php if($TPL_V3["status"]=='sale'){?>checked<?php }else{?>disabled<?php }?> value="<?php echo $TPL_V3["cart_ix"]?>">
                                    </td>
                                    <td>
                                        <div class="cart-item__infobox">
                                            <div class="cart-item__thumb">
                                                <a href="/shop/goodsView/<?php echo $TPL_V3["id"]?>">
                                                    <img src="<?php echo $TPL_V3["image_src"]?>">
<?php if($TPL_V3["status"]=='soldout'){?>
                                                    <div class="sold-out-txt">Out of stock</div>
<?php }?>
                                                </a>
                                            </div>
                                            <div class="cart-item__info">
                                                <!--<li class="cart-item__pre">-->
                                                    <?php echo $TPL_VAR["preface"]?>

                                                <!--</li>-->
                                                <p class="cart-item__title c-pointer" onclick="location.href='/shop/goodsView/<?php echo $TPL_V3["id"]?>'"><?php if($TPL_V3["brand_name"]){?>[<?php echo $TPL_V3["brand_name"]?>] <?php }?><?php echo $TPL_V3["pname"]?></p>
<?php if($TPL_V3["set_group"]> 0){?>
                                                    <input type="hidden" name="cartType" class="cartType" value="set" />
                                                    <p class="cart-item__option">
<?php if($TPL_setData_4){foreach($TPL_V3["setData"] as $TPL_V4){?>
<?php if($TPL_I1!= 0){?> | <?php }?><?php echo $TPL_V4["options_text"]?>

<?php }}?>
                                                    </p>
<?php }else{?>
                                                    <p class="cart-item__option">
                                                        <?php echo $TPL_V3["options_text"]?>

                                                    </p>
<?php }?>
<?php if(!empty($TPL_V3["add_info"])){?>
                                                <p class="cart-item__option"><?php echo $TPL_V3["add_info"]?></p>
<?php }?>
                                                <button type="button" class="cart-item__change__btn btn-xs btn-white" data-pid="<?php echo $TPL_V3["id"]?>" data-cart_ix="<?php echo $TPL_V3["cart_ix"]?>" data-title="Change Options" data-pcount="<?php echo $TPL_V3["pcount"]?>" <?php if($TPL_V3["status"]=='soldout'){?>disabled<?php }?>>Change Options</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="cart-item__control">
                                            <ul class="option-up-down">
                                                <li><button class="down devCountDownButton" <?php if($TPL_V3["status"]=='soldout'){?>disabled<?php }?>></button></li>
                                                <li><input type="text" value="<?php echo $TPL_V3["pcount"]?>" class="devCount" <?php if($TPL_V3["status"]=='soldout'){?>disabled<?php }?>/></li>
                                                <li><button class="up devCountUpButton" <?php if($TPL_V3["status"]=='soldout'){?>disabled<?php }?>></button></li>
                                            </ul>
                                            <button class="btn-xs btn-white devCountUpdateButton" <?php if($TPL_V3["status"]=='soldout'){?>disabled<?php }?>>Change</button>
<?php if($TPL_V3["status"]=='sale'&&$TPL_V3["stock"]<$TPL_V3["pcount"]){?>
                                            <p class="txt-error mat10">You can order up to <?php echo $TPL_VAR["addOptionList"]["stock"]?> quantity.</p>
<?php }?>
                                        </div>
                                    </td>
                                    <td class="cart-item__price price">
<?php if($TPL_V3["status"]=='sale'){?>
<?php }elseif($TPL_V3["status"]=='stop'){?>
                                        <p class="cart-item__status">Out of stock</p>
<?php }elseif($TPL_V3["status"]=='ready'){?>
                                        <p class="cart-item__status">For Sale</p>
<?php }elseif($TPL_V3["status"]=='end'){?>
                                        <p class="cart-item__status">Sales End</p>
<?php }?>
                                        <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V3["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?>

                                    </td>
                                    <td class="td-btn-area cart-item__btn-area">
                                        <button class="btn-xs btn-dark devDirectBuyButton" <?php if($TPL_V3["status"]!='sale'){?>disabled<?php }?>>BUY NOW</button>
                                        <button class="btn-xs btn-dark-line devDeleteButton cart-item__btn-area-del">Delete</button>
                                    </td>
                                </tr>
<?php if($TPL_addOptionList_4){foreach($TPL_V3["addOptionList"] as $TPL_V4){?>
                                    <!--//기획 미정........ 따로 상품처럼 구매할 수도 있다고 합니다~~//-->
                                    <tr class="fb__cart__add-product add-product devAddOptionContents">
                                        <td class="bg-none"><input type="hidden" class="devCartOptionIx" value="<?php echo $TPL_V4["cart_option_ix"]?>"/></td>
                                        <td>
                                            <p class="cart-item__title add-product__title">Additional configuration product</p>
                                            <p class="cart-item__option"><?php echo $TPL_V4["opn_text"]?></p>
<?php if($TPL_V4["stock"]> 0){?>
                                            <div class="control cart-item__control">
                                                <ul class="option-up-down">
                                                    <li><button class="down devCountDownButton"></button></li>
                                                    <li><input type="text" value="<?php echo $TPL_V4["opn_count"]?>" class="devCount"/></li>
                                                    <li><button class="up devCountUpButton"></button></li>
                                                </ul>
                                                <button class="btn-xs btn-white devAddOptionCountUpdateButton">Change</button>
<?php if($TPL_V4["stock"]<$TPL_V4["opn_count"]){?>
                                                <p class="txt-error mat10">You can order up to <?php echo $TPL_V4["stock"]?> quantity.</p>
<?php }?>
                                            </div>
<?php }?>
                                        </td>
                                        <td class="cart-item__price price">
<?php if($TPL_V4["stock"]> 0){?>
                                            <p><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V4["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
<?php }else{?>
                                            <p class="sold-out">Out of stock</p>
<?php }?>
                                        </td>
                                        <td class="td-btn-area add-product__del-area">
                                            <button class="item-del-btn devAddOptionDeleteButton">Delete</button>
                                        </td>
                                    </tr>
<?php }}?>
<?php if(count($TPL_V3["giftItem"])> 0){?>
                                    <tr class="product-gift-wrap">
                                        <td></td>
                                        <td colspan="4">
                                            <div class="product-gift">
                                                <p class="product-gift__title"><span>GIft</span> <?php echo $TPL_VAR["giftItem"]["gift_title"]?></p>
                                                <ul class="product-gift__list">
<?php if($TPL_giftItem_4){foreach($TPL_V3["giftItem"] as $TPL_V4){?>
                                                    <li class="product-gift__box inner-gift devGiftList" data-status="<?php echo $TPL_V4["status"]?>">
                                                        <figure class="product-gift__thumb">
                                                            <img src="<?php echo $TPL_V4["image_src"]?>" alt="<?php echo $TPL_V4["gift_name"]?>">
                                                        </figure>
                                                        <div class="product-gift__info">
                                                            <span class="product-gift__info__pname"><?php echo $TPL_V4["gift_name"]?></span>
                                                            <span class="product-gift__info__count"><?php echo $TPL_V4["cnt"]?>ltem(s)</span>
<?php if($TPL_V4["status"]=='soldout'){?><span><?php if($TPL_VAR["langType"]=='korean'){?> [품절] <?php }else{?> [Sold Out] <?php }?></span><?php }?>
                                                        </div>
                                                    </li>
<?php }}?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
<?php }?>
<?php }}?>
                        </table>
                    </div>
<?php }}?>
            </section>
        </div>

        <div class="layout-right" >
            <div class="shop-right-area">
                <div class="shop-total-price" devCartCompanyPriceContents="<?php echo $TPL_V1["company_id"]?>" id="devCartPriceContents">
                    <h2 class="shop-total-price__title">Item Total</h2>
                    <dl class="shop-total-price__cate">
                        <dt class="shop-total-price__cate__title">Number of selected products</dt>
                        <dd class="shop-total-price__cate__price">
                            <em id="devSelectItemCnt">0</em> ltem(s)
                        </dd>
                    </dl>
                    <dl class="shop-total-price__cate">
                        <dt class="shop-total-price__cate__title">Subtotal</dt>
                        <dd class="shop-total-price__cate__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_listprice"><?php echo g_price($TPL_VAR["cartSummary"]["product_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                    <dl class="shop-total-price__cate">
                        <dt class="shop-total-price__cate__title">Item-discount</dt>
                        <dd class="shop-total-price__cate__price">-<?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_basic_discount_amount"><?php echo g_price($TPL_V1["product_basic_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                    <dl class="shop-total-price__cate">
                        <dt class="shop-total-price__cate__title">Membership-discount</dt>
                        <dd class="shop-total-price__cate__price">-<?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="product_mem_discount_amount"><?php echo g_price($TPL_V1["product_mem_discount_amount"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    </dl>
                    <dl class="shop-total-price__cate">
                        <dt class="shop-total-price__cate__title">
                            <span>Shipping fee</span>
                            <span class="js__cart__delivery-icon shop-total-price__cate__icon">느낌표 아이콘</span>
                        </dt>
                        <dd class="shop-total-price__cate__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="total_delivery_price"><?php echo g_price($TPL_VAR["cartSummary"]["total_delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
<?php if($TPL_deliveryTemplateList_2){foreach($TPL_V1["deliveryTemplateList"] as $TPL_V2){?>
<?php if($TPL_V2["delivery_text"]){?>
                        <dd class="fb__cart__layer-delivery">
                            <span>
                                <?php echo $TPL_V2["delivery_text"]?>

                            </span>
                        </dd>
<?php }?>
<?php }}?>
                    </dl>
                    <dl class="shop-total-price__cate-total">
                        <dt class="shop-total-price__cate-total__title">Estimated Total</dt>
                        <dd class="shop-total-price__cate-total__price">
                            <?php echo $TPL_VAR["fbUnit"]["f"]?><em devPrice="payment_price"><?php echo g_price($TPL_V1["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?>

                        </dd>
                    </dl>
                </div>
                <button class="btn-lg fb__btn-point fb__shop__buy-btn" id="devBuyButton">Place order</button>
            </div>
        </div>
<?php }}?>
    </div>
<?php }else{?>
    <div class="empty-content">
        <p>No items in cart.</p>
        <a href="/"><button class="btn-dark btn-default mat30">Home</button></a>
    </div>
<?php }?>

</section>