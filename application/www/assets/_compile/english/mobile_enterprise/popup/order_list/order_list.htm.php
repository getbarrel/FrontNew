<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/popup/order_list/order_list.htm 000002063 */ ?>
<form id="devListForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="10" />
</form>

<div class="orderlist">

    <ul class="orderlist-wrap" id="devListContents">
        <div class="orderlist-empty" id="devListEmpty">
            <p>No order history</p>
        </div>
        <li class="orderlist-box" id="devListDetail">
            <div class="orderlist-box__info">
                <span class="orderlist-box__info__date"><span class="br__hidden">Date:</span>{[order_date]}</span>
                <span class="orderlist-box__info__number"><span class="br__hidden">Order number:</span>{[oid]}</span>
            </div>
            <div class="orderlist-box__goods">
                <figure class="orderlist-box__goods__thumb">
                    <img src="{[product_image_src]}" alt="{[buy_product_name]}">
                </figure>
                <div class="orderlist-box__goods__info">
                    <p class="orderlist-box__goods__title">{[buy_product_name]}</p>
                    <span class="orderlist-box__goods__price">
                        Total Payment
                        <span><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[payment_price]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                    </span>
                </div>
            </div>
            <button type="button" class="orderlist-box__btn m_selbtn" data-oid="{[oid]}" devSelectOid="{[oid]}">Order number selection number</button>
        </li>
    </ul>
    <!--<div class="orderlist-empty" id="devListEmpty">-->
        <!--<p>No order history</p>-->
    <!--</div>-->
    <div id="devListLoading" class="devForbizTpl loading-text">loading...</div>
    <div class="br__more" id="devPageWrap"></div>

    <div class="orderlist-bottom">
        <button type="button" class="orderlist-bottom__btn">Cancel</button>
    </div>
</div>