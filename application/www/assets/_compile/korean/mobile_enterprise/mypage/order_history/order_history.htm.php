<?php /* Template_ 2.2.8 2024/03/06 14:21:20 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_history/order_history.htm 000012005 */ ?>
<!-- crema load -->
<script>
var crema_userId = null;
var crema_userNm = null;

<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>    
	crema_userId = "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["id"]?>";
	crema_userNm = "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["name"]?>"; 
<?php }?>
		
window.cremaAsyncInit = function() { // init.js가 다운로드 & 실행된 후에 실행하는 함수
  //console.log("[CREMA] cremaAsyncInit() - EXECUTED!");
  crema.init(crema_userId, crema_userNm);
  //console.log("[CREMA] crema.init() - EXECUTED!");
};

(function(i,s,o,g,r,a,m){if(s.getElementById(g))<?php echo $TPL_VAR["return"]?>;a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.id=g;a.async=1;a.src=r;m.parentNode.insertBefore(a,m)})
(window,document,'script','crema-jssdk','//<?php echo CREMA_WIDGET_HOST?>/getbarrel.com/mobile/init.js');
</script>
<section class="br__odhistory">
	<div class="page-title my-title">
		<div class="title-sm">주문 내역</div>
	</div>

	<section class="br__mypage-search br__odhistory__top ">
		<form id="devOrderHistoryForm">
            <input type="hidden" name="page" value="1" id="devPage" />
            <input type="hidden" name="max" value="5"/>
            <input type="hidden" id="status" name="status" value=""/>
			<div class="search">
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
					<button type="button" id="devBtnSearch" title="조회" class="btn-lg btn-gray-line">조회</button>
				</div>
			</div>
			<div class="my-order">
				<ul class="my-order__seq">
<?php if($TPL_VAR["langType"]=='korean'){?>
					<li class="my-order__seq__box ">
						<!-- 라디오 선택 되었을 경우 / 또는 해당 메뉴가 활성화 될 때 div.my-order__seq__box 의 class = active 추가-->
						<label class="my-order__seq__label ">
							<input type="radio" class="devSortTab" name="filterRadio" value="IR" />
							<span class="my-order__seq__count"><?php echo number_format($TPL_VAR["incom_ready_cnt"])?></span>
							<span class="my-order__seq__kind">입금 대기</span>
						</label>
					</li>
<?php }?>
					<li class="my-order__seq__box">
						<label class="my-order__seq__label">
							<input type="radio" class="devSortTab" name="filterRadio" value="IC" />
							<span class="my-order__seq__count"><?php echo number_format($TPL_VAR["incom_end_cnt"])?></span>
							<span class="my-order__seq__kind">결제 완료</span>
						</label>
					</li>
					<li class="my-order__seq__box">
						<label class="my-order__seq__label">
							<input type="radio" class="devSortTab" name="filterRadio" value="DR" />
							<span class="my-order__seq__count"><?php echo number_format($TPL_VAR["delivery_ready_cnt"])?></span>
							<span class="my-order__seq__kind">배송 준비</span>
						</label>
					</li>
					<li class="my-order__seq__box">
						<label class="my-order__seq__label">
							<input type="radio" class="devSortTab" name="filterRadio" value="DI" />
							<span class="my-order__seq__count"><?php echo number_format($TPL_VAR["delivery_ing_cnt"])?></span>
							<span class="my-order__seq__kind">배송 중</span>
						</label>
					</li>
					<li class="my-order__seq__box">
						<label class="my-order__seq__label">
							<input type="radio" class="devSortTab" name="filterRadio" value="DC" />
							<span class="my-order__seq__count"><?php echo number_format($TPL_VAR["delivery_end_cnt"])?></span>
							<span class="my-order__seq__kind">배송 완료</span>
						</label>
					</li>
					<!-- <li class="my-order__seq__box">
						<label class="my-order__seq__label">
							<input type="radio" class="devSortTab" name="filterRadio" value="BF" />
							<span class="my-order__seq__count"><?php echo number_format($TPL_VAR["delivery_end_cnt"])?></span>
							<span class="my-order__seq__kind">구매확정</span>
						</label>
					</li> -->
				</ul>

			</div>
		</form>
	</section>

	<section class="br__odhistory__content">
		<!-- 주문 내역 - 리스트 S -->
		<div class="br__odhistory__list">
			<ul class="product-list" id="devOrderHistoryContent">
				<li class="product-list__item no-data devForbizTpl" id="devOrderHistoryLoading">
					<p>Loading...</p>
				</li>

				<li class="product-list__item no-data devForbizTpl" id="devOrderHistoryEmpty">
					<p class="empty-content">기간내 주문내역이 없습니다.</p>
				</li>

				<li class="product-list__item" id="devOrderHistoryList">
					<dl class="product-list__item-date">
						<dt>
							<div class="order-day">{[order_date]}</div>
							<span class="order-number"><a href="/mypage/orderDetail?oid={[oid]}" class="btn-link">{[oid]}</a></span>
						</dt>
						<dd>
							<a href="/mypage/orderDetail?oid={[oid]}" class="btn-link">상세보기</a>
						</dd>
					</dl>
					<!-- 상품 S -->
					<div  id="devOrderDetailContent">
						<div  id="devOrderDetailProduct">
							<dl class="product-list__group">
								<dt class="product-list__group-left">
									<figure class="product-list__thumb">
										<a href="/shop/goodsView/{[pid]}">
											<img src="{[pimg]}" alt="" />
										</a>
									</figure>
								</dt>
								<dd class="product-list__group-right">
									<div class="product-list__info">
										<div class="product-list__info__title">{[pname]}</div>

										<!-- 세트 상품 S -->
										<!-- 세트 옵션일 경우 div.product-list__info__option 에 class = set 추가 -->
										<div class="product-list__info__option">
											<div class="product-list__info__option-item">
												{[#if add_info]}<span class="color">{[add_info]}</span>{[/if]}
												<span class="set-tit">{[option_text2]}</span>
												<span class="count">{[pcnt]}개</span>
											</div>
										</div>
										<!-- 세트 상품 E -->

										<div class="product-list__info__price">
											<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[listprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
											<span class="product-list__info__status">{[status_text]}</span>
										</div>
									</div>
								</dd>
							</dl>
							<!-- 상품 E -->
							<div class="product-list__footer">
								{[#if isIncomeComplate]}
								{[#if isMethod]}
								{[else]}
								<button type="button" class="btn-lg btn-dark-line devOrderCancelBtn" data-oid="{[oid]}" data-part_cancel="{[partCancelBool]}" data-odix="{[od_ix]}">주문취소</button>
								{[/if]}
								{[/if]}
												
								{[#if isDeliveryIng]}
								<div class="btn-group">
									<button type="button" class="btn-lg btn-gray-line devInvoice" onclick="javascirt:void(0);" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">배송추적</button>
									<button type="button" class="btn-lg btn-gray-line devOrderComplateBtn" data-oid="{[oid]}" data-odix="{[od_ix]}">배송완료</button>
								</div>
								{[/if]}

								{[#if isDeliveryComplate]}
								<div class="btn-group">
									<button type="button" class="btn-lg btn-gray-line devOrderReturnBtn" data-oid="{[oid]}" data-odix="{[od_ix]}" data-functionable="{[returnable_yn]}">반품신청</button>
									<button type="button" class="btn-lg btn-gray-line devInvoice" onclick="javascirt:void(0);" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">배송추적</button>
								</div>
								<button class="btn-lg btn-gray-line devBuyFinalizedBtn" data-oid="{[oid]}" data-odix="{[od_ix]}">구매확정</button>
								{[/if]}

								{[#if isDeleveryTrace]}
								<button type="button" class="btn-lg btn-gray-line devInvoice" onclick="javascirt:void(0);" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">배송추적</button>
								{[/if]}

								{[#if isByFinalized]}
								<button type="button" class="btn-lg btn-gray-line devInvoice" onclick="javascirt:void(0);" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">배송추적</button>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
<?php if($TPL_VAR["langType"]=='korean'){?>
								<button type="button" class="btn-lg btn-gray-line"><a class="crema-new-review-link odeach__btn--bk" data-product-code="{[co_no]}" widget-id="100" >리뷰쓰기</a></button>
<?php }else{?>
<?php if(false){?>
									<button class="btn-lg btn-gray-line"><button class="odeach__btn--bk devByFinalized" data-pid="{[pid]}" data-oid="{[oid]}" data-odix="{[ode_ix]}">리뷰쓰기</button></button>
<?php }?>
<?php }?>
<?php }?>
								{[/if]}
							</div>
						</div>
					</div>
					{[#if isAllCancel]}
					<div class="product-list__footer">
						<button type="button" class="btn-lg btn-dark-line devOrderCancelAllBtn" data-oid="{[oid]}">전체 취소</button>
					</div>
					{[/if]}
				</li>

			</ul>

		</div>
		<div class="br__more" id="devPageWrap"></div>
        <!--(주문상태 레이어) *배럴에서 사용하지 않습니다. 참고하시라고 남겨두었습니다. display: none 상태입니다.-->
        <div class="devForbizTpl" id="devMorePopup" style="display: none">
		</div>
		<!-- 주문 내역 - 리스트 E -->
		<div class="delivery-guide">
			<div class="delivery-guide__title">
				<div class="title-sm">배송 단계 안내</div>
			</div>
			<div class="delivery-guide__list">
				<dl class="delivery-guide__item">
					<dt>
						<span>01</span>
						<strong>입금대기</strong>
					</dt>
					<dd>가상계좌로 구매하신 주문 건의 주문 접수 상태이며, 입금 후 결제 완료 단계로 변경됩니다.</dd>
				</dl>
				<dl class="delivery-guide__item">
					<dt>
						<span>02</span>
						<strong>결제완료</strong>
					</dt>
					<dd>입금 확인 및 주문이 완료되었습니다.</dd>
				</dl>
				<dl class="delivery-guide__item">
					<dt>
						<span>03</span>
						<strong>배송준비중</strong>
					</dt>
					<dd>상품 포장이 완료되어 배송을 준비 중이며, 취소가 불가합니다.</dd>
				</dl>
				<dl class="delivery-guide__item">
					<dt>
						<span>04</span>
						<strong>배송중</strong>
					</dt>
					<dd>주문하신 상품이 택배사로 전달되어 고객님께 배송중입니다.</dd>
				</dl>
				<dl class="delivery-guide__item">
					<dt>
						<span>05</span>
						<strong>배송완료</strong>
					</dt>
					<dd>배송지로 주문하신 상품의 배송이 완료되었습니다. 상품 수령 후 7일 이내에 [취소/반품] 신청이 가능합니다.</dd>
				</dl>
			</div>
		</div>
	</section>
</section>