<?php /* Template_ 2.2.8 2024/02/19 16:50:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/stock_alarm/stock_alarm.htm 000004393 */ ?>
<!-- 컨텐츠 S -->
<section class="br__stock-alarm">
	<div class="page-title my-title">
		<div class="title-sm">재입고 알림 유의사항</div>
	</div>
    <form id="devListForm">
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="10" />
    </form>
	<div class="stock-alarm">
		<div class="product-list">
			<div class="product-list__top">
				<div class="product-list__top-info">
					<div class="br__form-item">
						<input type="checkbox" id="cart_all_check" class="br__from-checkbox" />
						<label for="cart_all_check">전체선택 <em class="product-list__info__total" id="devAlarmTotal">0</em></label>
					</div>
				</div>
				<div class="product-list__top-del">
					<button class="btn-del">선택삭제</button>
				</div>
			</div>
			<ul class="product-list__wrap" id="devListContents">
				<li class="product-list__item devForbizTpl empty-content" id="devListEmpty">
					<p>재입고 알림 신청 내역이 없습니다.</p>
				</li>

				<li class="product-list__item devForbizTpl" id="devListLoading"></li>

				<li class="product-list__item" id="devListDetail">
					<div class="product-list__item-top">
						<label class="product-item__check-label">
							<input type="checkbox" class="product-item__check" />
						</label>
						<button class="btn-sm btn-line-no devDeleteReminder" data-srix="{[sr_ix]}">삭제</button>
					</div>
					<dl class="product-list__group">
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<a href="/shop/goodsView/{[pid]}">
									<img src="{[image_src]}" alt="{[pname]}">
								</a>
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title"><a href="/shop/goodsView/{[pid]}">{[pname]}</a></div>
								<!-- 일반상품 상품 S -->
								<div class="product-list__info__option">
									<div class="product-list__info__option-item">
										<span class="color">{[optionDiv]}</span>
										<span class="size">{[add_info]}</span>
									</div>
									<div class="product-list__info__option-item">
										{[#if discount_rate]}<span class="size"><?php echo $TPL_VAR["fbUnit"]["f"]?>{[listprice]}<?php echo $TPL_VAR["fbUnit"]["b"]?></span>{[/if]}
										<span class="size"><?php echo $TPL_VAR["fbUnit"]["f"]?><span>{[dcprice]}</span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
										{[#if discount_rate]} <span class="price">[{[discount_rate]}%]</span>{[/if]}
									</div>
								</div>
								<!-- 일반상품 상품 E -->

								<div class="product-list__info__add">
									<span class="product-list__info__add--title">알림 기간</span>
									<span class="product-list__info__add--day">{[regdateYmd]} ~ {[expiration_date]}</span>
								</div>
							</div>
						</dd>
					</dl>
				</li>
			</ul>
		</div>
        <div class="br__more devPageBtnCls" id="devPageWrap"></div>
	</div>
	<div class="use-notice">
		<h3 class="use-notice__title">최근 본 상품 안내</h3>
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