<?php /* Template_ 2.2.8 2023/12/15 16:32:04 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/stock_alarm/stock_alarm.htm 000004569 */ ?>
<!-- 컨텐츠 S -->
<section class="fb__mypage fb__stock-alarm">
    <form id="devListForm">
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="10" />
    </form>
	<div class="fb__mypage-title">
		<div class="title-md">재입고 알림 신청 내역</div>
	</div>
	<div class="fb__stock-alarm__list">
		<!-- 재입고 알림 신청 내역이 없을 경우 S -->
		<!-- 숨김 처리 -->
		<div class="fb__stock-alarm__no-data" style="display: none">
			<div class="empty-content">재입고 알림 신청 내역이 없습니다.</div>
		</div>
		<!-- 재입고 알림 신청 내역이 없을 경우 E -->
		<div class="fb__stock-alarm__product">
			<div class="top-area product-top">
				<div class="check-area fb__check-area">
					<input type="checkbox" id="cart_all_check" class="devChangePriceEvent" />
					<label for="cart_all_check">전체선택<em class="fb__cart__total" id="devAlarmTotal">0</em></label>
				</div>
				<div class="btn-group">
					<button class="fb__cart__top-delete btn-s btn-white btn-line-no" id="">선택삭제</button>
				</div>
			</div>
			<ul id="devListContents" class="product-item__wrap">
				<li id="devListDetail" class="product-item__list">
					<!-- 상품 영역 S -->
					<dl class="product-item">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__checkbox">
								<input type="checkbox" class="cart_product_check" />
							</div>
							<div class="product-item__thumb">
								<a href="/shop/goodsView/{[pid]}">
									<img src="{[image_src]}" alt="{[pname]}">
								</a>
							</div>
						</dt>
						<dd class="product-item__infobox">
							<div class="product-item__info">
								<div class="product-item__title c-pointer">
									<a href="/shop/goodsView/{[pid]}">{[pname]}</a>
								</div>
								<div class="product-item__option">
									<input type="hidden" name="cartType" class="cartType" value="set" />
									<span>{[optionDiv]}</span>
									<span>{[add_info]}</span>
									<span>1개</span>
								</div>
								<p class="alarm-list__goods__price">
									{[#if discount_rate]}<span class="alarm-list__goods__price&#45;&#45;strike">{[listprice]}원</span>{[/if]}
									<span class="alarm-list__goods__price--cost"><span>{[dcprice]}</span>원</span>
									{[#if discount_rate]}<span class="alarm-list__goods__price--discount">{[discount_rate]}%</span>{[/if]}
								</p>
								<div class="product-item__stock-alarm-title">
									<p>알림 기간</p>
								</div>
							</div>
							<div class="product-item__btn-area">
								<button class="btn-xs btn-white btn-line-no devDeleteButton cart-item__btn-area-del devDeleteReminder" data-srix="{[sr_ix]}">삭제</button>
								<div class="product-item__stock-alarm-day">{[regdateYmd]} ~ {[expiration_date]}</div>
							</div>
						</dd>
					</dl>
					<!-- 상품 영역 E -->
				</li>
				<div class="empty-content devForbizTpl" id="devListEmpty">
					<p>입고 알림 신청 내역이 없습니다.</p>
				</div>
				<div class="devForbizTpl" id="devListLoading">
					<div class="loading"></div>
				</div>
			</ul>
		</div>
	</div>
	<div class="use-notice">
		<h3 class="use-notice__title">재입고 알림 유의사항</h3>
		<ul class="use-notice__list">
			<li class="use-notice__desc">상품의 가격, 옵션 구성 등은 변동될 수 있으므로, 재입고 시 상품정보 확인 후 구매하시기 바랍니다.</li>
			<li class="use-notice__desc">SMS 알림은 요청일로부터 15일간 유효하며, 재입고된 상품 알림 문자는 1회 발송됩니다. 입고 알림을 다시 받고 싶으실 경우, 재신청해 주시기 바랍니다.</li>
			<li class="use-notice__desc">재입고 알림 SMS 발송 후 인기 상품은 조기 품절될 수 있습니다.</li>
			<li class="use-notice__desc">휴대폰에서 수신거부 또는 스팸처리 시 SMS 알림을 받지 못할 수 있습니다.</li>
			<li class="use-notice__desc">기본 휴대폰으로 알림을 신청하신 경우, 해당 휴대폰 번호로 안내드리며, 신청 후 휴대폰 번호 변경을 원하시는 경우 재입고 알림을 다시 신청해주시기 바랍니다.</li>
			<li class="use-notice__desc">알림 신청 후 3개월이 지난 상품, 판매종료된 상품은 자동 삭제됩니다.</li>
		</ul>
	</div>
</section>
<!-- 컨텐츠 E -->