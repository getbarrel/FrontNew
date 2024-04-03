<?php /* Template_ 2.2.8 2024/03/21 01:07:40 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/popup/order_list/order_list.htm 000003219 */ ?>
<form id="devListForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="5" />
</form>

<div class="orderlist">
	<ul class="orderlist-wrap" id="devListContents">
		<div id="devListLoading" class="devForbizTpl loading-text">loading...</div>
        <div class="orderlist-empty" id="devListEmpty"> <p>주문하신 내역이 없습니다.</p></div>




		<li class="product-list__item orderlist-box" id="devListDetail">
			<dl class="product-list__group">
				<dt class="product-list__group-left">
					<figure class="product-list__thumb">
						<a href="#;">
							<img src="{[product_image_src]}" alt="{[buy_product_name]}">
						</a>
					</figure>
				</dt>
				<dd class="product-list__group-right">
					<div class="product-list__info">
						<div class="product-list__info__data">
							<span class="date">{[order_date]}</span>
							<label for="" class="br__form-checkbox--label">
								<button type="button" class="orderlist-box__btn m_selbtn" data-oid="{[oid]}" devSelectOid="{[oid]}">선택</button>
								<!-- <input type="checkbox" class="br__form-checkbox" /> -->
							</label>
						</div>
						<div class="product-list__info__title">{[buy_product_name]}</div>

						<div class="product-list__info__price">
							<span class="product-list__info__model-number">{[oid]}</span>
							<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[payment_price]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
						</div>
					</div>
				</dd>
			</dl>
		</li>
	</ul>
	<!--
    <ul class="orderlist-wrap" id="devListContents">
        <div class="orderlist-empty" id="devListEmpty">
            <p>주문하신 내역이 없습니다.</p>
        </div>
        <li class="orderlist-box" id="devListDetail">
            <div class="orderlist-box__info">
                <span class="orderlist-box__info__date"><span class="br__hidden">날짜 :</span>{[order_date]}</span>
                <span class="orderlist-box__info__number"><span class="br__hidden">주문번호 :</span>{[oid]}</span>
            </div>
            <div class="orderlist-box__goods">
                <figure class="orderlist-box__goods__thumb">
                    <img src="{[product_image_src]}" alt="{[buy_product_name]}">
                </figure>
                <div class="orderlist-box__goods__info">
                    <p class="orderlist-box__goods__title">{[buy_product_name]}</p>
                    <span class="orderlist-box__goods__price">
                        총 결제금액
                        <span><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[payment_price]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                    </span>
                </div>
            </div>
            <button type="button" class="orderlist-box__btn m_selbtn" data-oid="{[oid]}" devSelectOid="{[oid]}">주문번호 선택버튼</button>
        </li>
    </ul>
	-->
    <div class="br__more" id="devPageWrap"></div>
    <div class="br__more"><br></div>
</div>