<?php /* Template_ 2.2.8 2024/03/06 14:20:43 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_history/order_history.htm 000012364 */ ?>
<!-- 컨텐츠 S -->
<section class="fb__mypage wrap-mypage fb__mypage-order">
	<div class="fb__mypage-title">
		<div class="title-md">주문 내역</div>
	</div>
<?php if(!$TPL_VAR["nonMemberOid"]){?>	<section class="fb__mypage__search">
		<div class="title-sm">주문 내역 검색</div>
		<form id="devOrderHistoryForm">
            <input type="hidden" name="page" value="1" id="devPage" />
            <input type="hidden" name="max" value="5"/>
			<input type="hidden" id="status" name="status" value=""/>
			<div class="search">
				<div class="search__row">
					<div class="search__col">
						<div class="fb__form-item">
							<label for="devSdate" class="hide">조회기간</label>
							<input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick fb__form-input" title="조회시작기간" />
							<span>-</span>
							<input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick fb__form-input" title="조회종료기간" />
							<button type="button" id="devSearchBtn" title="조회" class="btn-lg btn-dark-line">조회</button>
						</div>
					</div>
					<div class="search__col">
						<ul class="fb__mypage__overview-list">
<?php if($TPL_VAR["langType"]=='korean'){?>
							<li class="devSortTab active" data-status="<?php echo ORDER_STATUS_INCOM_READY?>">
								<!--진행중일 때 li 에 class = active 추가-->
								<em class="my-order__seq__count "><?php echo number_format($TPL_VAR["incom_ready_cnt"])?></em>
								<p>입금대기</p>
							</li>
<?php }?>
							<li class="devSortTab" data-status="<?php echo ORDER_STATUS_INCOM_COMPLETE?>">
								<em class="my-order__seq__count"><?php echo number_format($TPL_VAR["incom_end_cnt"])?></em>
								<p>결제완료</p>
							</li>
							<li class="devSortTab"  data-status="<?php echo ORDER_STATUS_DELIVERY_READY?>">
								<em class="my-order__seq__count"><?php echo number_format($TPL_VAR["delivery_ready_cnt"])?></em>
								<p>배송준비</p>
							</li>
							<li class="devSortTab" data-status="<?php echo ORDER_STATUS_DELIVERY_ING?>">
								<em class="my-order__seq__count"><?php echo number_format($TPL_VAR["delivery_ing_cnt"])?></em>
								<p>배송중</p>
							</li>
							<li class="devSortTab" data-status="<?php echo ORDER_STATUS_DELIVERY_COMPLETE?>">
								<em class="my-order__seq__count"><?php echo number_format($TPL_VAR["delivery_end_cnt"])?></em>
								<p>배송완료</p>
							</li>
							<!-- <li class="devSortTab" data-status="BF">
								<em class="my-order__seq__count"><?php echo number_format($TPL_VAR["delivery_end_cnt"])?></em>
								<p>구매확정</p>
							</li> -->
						</ul>
				</ul>

					</div>
				</div>
			</div>
			<div class="search__day">
				<div class="day-radio">
					<a href="#;" class="day-radio__btn day-radio--active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="devDateDefault">최근 <em>1</em>개월</a>
					<a href="#;" class="day-radio__btn" data-sdate="<?php echo $TPL_VAR["threeMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>3</em>개월</a>
					<a href="#;" class="day-radio__btn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>6</em>개월</a>
					<a href="#;" class="day-radio__btn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>12</em>개월</a>
				</div>
			</div>
		</form>
	</section>
<?php }else{?>    <form id="devOrderHistoryForm">
        <input type="hidden" name="page" value="1" id="devPage" />
        <input type="hidden" name="max" value="1"/>
    </form>
<?php }?>

	<!-- 주문 내역 - 리스트 S -->
	<section class="fb__mypage__section">
		<div class="fb__mypage-order">
			<ul class="product-item__wrap" id="devOrderHistoryContent">
				<li class="product-item__list no-data" id="devOrderHistoryLoading">
					<div class="wrap-loading">
						<div class="loading"></div>
					</div>
				</li>
				
				<li class="product-item__list no-data" id="devOrderHistoryEmpty">
					<p class="empty-content">최근 1개월 내 주문 내역이 없습니다.</p>
				</li>

				<li class="product-item__list"  id="devOrderHistoryList">
					<dl class="product-item__top">
						<dt>
							<div class="order-day">{[order_date]}</div>
							<span class="order-number"><a href="/mypage/orderDetail?oid={[oid]}" class="btn-link">{[oid]}</a></span>
							<div>	
							{[#if isAllCancel]}<button type="button" class="fb__mypage__btn--lightgray mal10 devOrderCancelAllBtn" data-oid="{[oid]}">전체취소</button>{[/if]}
							</div>
						</dt>
						<dd>
							<a href="/mypage/orderDetail?oid={[oid]}" class="btn-link">상세보기</a>
						</dd>
					</dl>
					<!-- 상품 S -->
					<div id="devOrderDetailContent" style="margin-top:30px;">
					<dl class="product-item"  id="devOrderDetailProduct">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="/shop/goodsView/{[pid]}">
									<img src="{[pimg]}" alt="{[#if brand_name]}[{[brand_name]}] {[/if]} {[pname]}" />
								</a>
							</div>
						</dt>
						<dd class="product-item__infobox">
							<div class="product-item__info">
								<div class="product-item__title c-pointer">
									<a href="/shop/goodsView/{[pid]}">{[#if brand_name]}[{[brand_name]}] {[/if]} {[pname]}</a>
								</div>
								<div class="product-item__option">
									<a href="/shop/goodsView/{[pid]}">
										{[#if add_info]}<span class="color">{[add_info]}</span>{[/if]}
										<span class="set-tit">{[option_text2]}</span>
										<span class="count">{[pcnt]}개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[listprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
							</div>
<!--
                    $row['isIncomeComplate'] = false;
                    $row['isDeliveryIng'] = false;
                    $row['isDeliveryComplate'] = false;
                    $row['isByFinalized'] = false;
                    $row['isClaimed'] = false;

                    if ($row['status'] == ORDER_STATUS_INCOM_COMPLETE) {
                        $row['isIncomeComplate'] = true;
                    }
                    if ($row['status'] == ORDER_STATUS_DELIVERY_ING) {
                        $row['isDeliveryIng'] = true;
                    }
                    if ($row['status'] == ORDER_STATUS_DELIVERY_COMPLETE) {
                        $row['isDeliveryComplate'] = true;
                    }
                    if ($row['status'] == ORDER_STATUS_BUY_FINALIZED) {
                        $row['isByFinalized'] = true;
                    }
                    if (!empty($row['refund_status'])) {
                        $row['isClaimed'] = true;
                    }
-->
							<div class="product-item__btn-area">
								<div class="order-status">{[status_text]}</div>
								<div class="btn-group">
									{[#if isDeleveryTrace]}
										<button type="button" class="btn-default btn-gray-line"><a href="javascirt:void(0);" class="devInvoice" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">배송추적 ></a></button>
									{[/if]}

									{[#if isDeliveryIng]}
										<button type="button" class="btn-default btn-gray-line"><a href="javascirt:void(0);" class="devInvoice" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">배송추적</a></button>
									{[/if]}

									{[#if isDeliveryComplate]}
										<button type="button" class="btn-default btn-gray-line"><a href="javascirt:void(0);" class="devInvoice" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">배송추적</a></button>
									{[/if]}

									{[#if isByFinalized]}
										<button type="button" class="btn-default btn-gray-line"><a href="javascirt:void(0);" class="devInvoice" data-quick="{[quick]}" data-invoice_no="{[invoice_no]}">배송추적</a></button>
									{[/if]}	

									{[#if isIncomeComplate]}
										{[#if isMethod]}
										{[else]}
											<button class="btn-default btn-dark-line devOrderCancelBtn" data-oid="{[oid]}" data-part_cancel="{[partCancelBool]}" data-odix="{[od_ix]}">주문취소</button>
										{[/if]}
									{[/if]}


									{[#if isDeliveryIng]}
										<button class="btn-default btn-dark-line devOrderComplateBtn" data-oid="{[oid]}" data-odix="{[od_ix]}">배송완료</button>
									{[/if]}

									{[#if isDeliveryComplate]}
										{[#if isExchangeDetail]}
										{[else]}
											<button class="btn-default btn-dark-line devOrderReturnBtn" data-oid="{[oid]}" data-odix="{[od_ix]}" data-functionable="{[returnable_yn]}">반품신청</button>
										{[/if]}
										<button class="btn-default btn-dark-line devBuyFinalizedBtn" data-oid="{[oid]}" data-odix="{[od_ix]}">구매확정</button>
									{[/if]}

<?php if(is_login()){?>
									{[#if isByFinalized]}                                            
<?php if($TPL_VAR["langType"]=='korean'){?>
										<button class="crema-new-review-link btn-default btn-dark-line" data-product-code="{[co_no]}" widget-id="100" >리뷰쓰기</button>
<?php }else{?>
<?php if(false){?>
											<button class="fb__mypage__btn--lightgray devByFinalized" data-pid="{[pid]}" data-oid="{[oid]}" data-odeix="{[ode_ix]}">리뷰쓰기</button>
<?php }?>
<?php }?>
									{[/if]}

									{[#if isExchangeToggle]}
										<button data-exkey="{[exKey]}" class="btn-toggle devEcDetailToggleBtn">V</button>
									{[/if]}
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
		<div id="devPageWrap"></div>
	</section>

	<!-- 주문 내역 - 리스트 E -->

	<div class="fb__mypage-delivery">
		<div class="fb__mypage-title">
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
<!-- 컨텐츠 E -->
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
    (window,document,'script','crema-jssdk','//<?php echo CREMA_WIDGET_HOST?>/getbarrel.com/init.js');
</script>