<?php /* Template_ 2.2.8 2024/02/22 16:03:00 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/return_history/return_history.htm 000005025 */ ?>
<!-- 컨텐츠 S -->
<section class="br__odhistory br__return">
	<div class="page-title my-title">
		<div class="title-sm">주문 내역</div>
	</div>
	<section class="br__mypage-search br__odhistory__top">
		<form id="devReturnHistoryForm">
			<input type="hidden" name="page" value="1" id="devPage" />
			<input type="hidden" name="max" value="10"/>
			<input type="hidden" name="status" value="" id="status"/>
			<input type="hidden" name="eDate" value="<?php echo $TPL_VAR["today"]?>" id="devEdate" />
			<div class="search">
				<div class="br-tab__nav">
					<ul>
						<li devFilterState="" class="active">
							<a href="#;">전체</a>
						</li>
						<li devFilterState="RA">
							<a href="#;">반품</a>
						</li>
						<li devFilterState="CA">
							<a href="#;">취소</a>
						</li>
					</ul>
				</div>
				<div class="br-tab__slide swiper-container">
					<ul class="swiper-wrapper">
						<li class="swiper-slide devDateBtn active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"  id="devDateDefault">
							<a href="#;">최근 <em>1</em>개월</a>
						</li>
						<li class="swiper-slide devDateBtn" data-sdate="<?php echo $TPL_VAR["threeMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">
							<a href="#;">최근 <em>3</em>개월</a>
						</li>
						<li class="swiper-slide devDateBtn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">
							<a href="#;">최근 <em>6</em>개월</a>
						</li>
						<li class="swiper-slide devDateBtn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">
							<a href="#;">최근 <em>12</em>개월</a>
						</li>
					</ul>
				</div>
				<div class="search__item">
					<div class="br__form-item">
						<label for="devSdate" class="hide">조회기간</label>
						<input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick br__form-input" title="조회시작기간" />
						<span>-</span>
						<input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick br__form-input" title="조회종료기간" />
					</div>
					<button type="button" title="조회" class="btn-lg btn-gray-line" id="devSearch">조회</button>
				</div>
			</div>
		</form>
	</section>
	<section class="br__odhistory__content">
		<!-- 주문 내역 - 리스트 S -->
		<div class="br__odhistory__list" id="devReturnHistoryContent">
			<li class="product-list__item no-data devForbizTpl" id="devReturnHistoryLoading">
				<p>Loading...</p>
			</li>

			<li class="product-list__item no-data devForbizTpl" id="devReturnHistoryEmpty">
				<p>기간내 반품/취소 내역이 없습니다.</p>
			</li>

			<ul class="product-list devForbizTpl" id="devReturnHistoryList">

				<li class="product-list__item">
					<dl class="product-list__item-date">
						<dt>
							<div class="order-day">{[claim_date]}</div>
							<span class="order-number">{[oid]}</span>
						</dt>
						<dd>
							<a href="/mypage/orderClaimDetail/{[oid]}/{[claim_group]}" class="btn-link">상세보기</a>
						</dd>
					</dl>
					<!-- 상품 S -->
					<div id="devOrderDetailContent">
					<dl class="product-list__group devForbizTpl" id="devReturnProduct">
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<a href="/mypage/orderDetail?oid={[oid]}">
									<img src="{[pimg]}">
								</a>
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title">{[pname]}</div>

								<!-- 일반 상품 S -->
								<div class="product-list__info__option">
									<div class="product-list__info__option-item">
										<span class="color">{[{option_text}]}</span>
										<span class="size">{[add_info]}</span>
										<span class="count">{[pcnt]}개</span>
									</div>
								</div>
								<!-- 일반 상품 E -->

								<div class="product-list__info__price">
									<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[listprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                    <span class="product-list__info__status">{[status_text]}{[#if refund_status_text]} / {[refund_status_text]}{[/if]}</span>
<?php }else{?>
                                    <span class="product-list__info__status">{[status_text]}{[#if refund_status_text]} /<br>{[refund_status_text]}{[/if]}</span>
<?php }?>
								</div>
							</div>
						</dd>
					</dl>
					</div>
					<!-- 상품 E -->
				</li>
			</ul>
		</div>
		<!-- 주문 내역 - 리스트 E -->
	</section>
</section>
<!-- 컨텐츠 E -->