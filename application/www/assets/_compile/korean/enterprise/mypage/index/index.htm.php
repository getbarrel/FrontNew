<?php /* Template_ 2.2.8 2024/03/06 13:55:00 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/index/index.htm 000009096 */ 
$TPL_order_summerydata_1=empty($TPL_VAR["order_summerydata"])||!is_array($TPL_VAR["order_summerydata"])?0:count($TPL_VAR["order_summerydata"]);
$TPL_wishList_1=empty($TPL_VAR["wishList"])||!is_array($TPL_VAR["wishList"])?0:count($TPL_VAR["wishList"]);?>
<map name="">
	<area shape="" href="" coords="" alt="">
</map><!-- crema load -->
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
<div class="layout-content">
	<!-- 컨텐츠 S -->
	<section class="fb__mypage wrap-mypage">
		<!-- fb__mypage-top S -->
<?php $this->print_("mypage_top",$TPL_SCP,1);?>

		<!-- fb__mypage-top E -->
		<section class="fb__mypage__status">
			<div class="fb__mypage-title">
				<div class="title-sx">주문 현황</div>
				<a href="#;" class="btn-link">최근 1개월</a>
			</div>
			<div class="fb__mypage__overview">
				<ul class="fb__mypage__overview-list">
<?php if($TPL_VAR["langType"]=='korean'){?>
					<li class="devOrderStatusCnt <?php if(g_price($TPL_VAR["incom_ready_cnt"])> 0){?> active<?php }?>" data-status="<?php echo ORDER_STATUS_INCOM_READY?>" onclick="">
						<!--진행중일 때 li 에 class = active 추가-->
						<em class="my-order__seq__count <?php if(g_price($TPL_VAR["incom_ready_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["incom_ready_cnt"])?></em>
						<p>입금대기</p>
					</li>
<?php }?>
					<li class="devOrderStatusCnt <?php if(g_price($TPL_VAR["incom_end_cnt"])> 0){?> active<?php }?>" data-status="<?php echo ORDER_STATUS_INCOM_COMPLETE?>" onclick="">
						<em class="my-order__seq__count <?php if(g_price($TPL_VAR["incom_end_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["incom_end_cnt"])?></em>
						<p>결제완료</p>
					</li>
					<li class="devOrderStatusCnt <?php if(g_price($TPL_VAR["delivery_ready_cnt"])> 0){?> active<?php }?>"  data-status="<?php echo ORDER_STATUS_DELIVERY_READY?>"onclick="">
						<em class="my-order__seq__count <?php if(g_price($TPL_VAR["delivery_ready_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["delivery_ready_cnt"])?></em>
						<p>배송준비중</p>
					</li>
					<li class="devOrderStatusCnt <?php if(g_price($TPL_VAR["delivery_ing_cnt"])> 0){?> active<?php }?>" data-status="<?php echo ORDER_STATUS_DELIVERY_ING?>" onclick="">
						<em class="my-order__seq__count <?php if(g_price($TPL_VAR["delivery_ing_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["delivery_ing_cnt"])?></em>
						<p>배송중</p>
					</li>
					<li class="devOrderStatusCnt <?php if(g_price($TPL_VAR["delivery_end_cnt"])> 0){?> active<?php }?>" data-status="<?php echo ORDER_STATUS_DELIVERY_COMPLETE?>" onclick="">
						<em class="my-order__seq__count <?php if(g_price($TPL_VAR["delivery_end_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["delivery_end_cnt"])?></em>
						<p>배송완료</p>
					</li>
				</ul>
				<div class="fb__mypage__overview-claim">
					<dl class="devReturnStatusCnt" data-status="<?php echo ORDER_STATUS_CANCEL_APPLY?>" onclick="">
						<dt class="my-order__seq__kind">취소</dt>
						<dd class="my-order__seq__count <?php if(g_price($TPL_VAR["cancel_apply_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["cancel_apply_cnt"])?></dd>
					</dl>
					<dl class="devReturnStatusCnt" data-status="<?php echo ORDER_STATUS_RETURN_APPLY?>" onclick="">
						<dt>반품신청</dt>
						<dd class="my-order__seq__count <?php if(g_price($TPL_VAR["return_apply_cnt"])> 0){?> my-order__seq__count--point<?php }?>"><?php echo number_format($TPL_VAR["return_apply_cnt"])?></dd>
					</dl>
				</div>
			</div>

			<!-- 최근 주문 내역 - 리스트 S -->
			<div class="wrap-recently-order fb__mypage-order">
				<ul class="product-item__wrap">
<?php if($TPL_VAR["order_summerydata"]&&!empty($TPL_VAR["order_summerydata"])){?>
<?php if($TPL_order_summerydata_1){foreach($TPL_VAR["order_summerydata"] as $TPL_V1){?>
					<li class="product-item__list">
						<a href="/mypage/orderDetail?oid=<?php echo $TPL_V1["oid"]?>" class="product-item__link">
							<dl class="product-item">
								<dt class="product-item__thumbnail-box">
									<div class="product-item__thumb">
										<img src="<?php echo $TPL_V1["orderDetailSummery"]["pimg"]?>" alt="<?php echo $TPL_V1["orderDetailSummery"]["pname"]?>">
									</div>
								</dt>
								<dd class="product-item__infobox">
									<div class="product-item__info">
										<div class="order-day"><?php echo $TPL_V1["order_date"]?></div>
										<div class="product-item__title c-pointer">
											<div class="title-sm">
												<?php echo $TPL_V1["orderDetailSummery"]["pname"]?> <?php if($TPL_V1["ordCnt"]> 0){?> 외 <?php echo $TPL_V1["ordCnt"]?>건 <?php }?>
											</div>
										</div>
										<div class="order-number"><?php echo $TPL_V1["oid"]?></div>
									</div>
									<div class="product-item__btn-area">
										<div class="order-status">
										<!--@TODO 2. 배송완료일때는 "fb__mypage__odtable--bold "이 클래스를 추가해 주세요.-->
										상세보기	
										</div>
										<div class="order-price"><?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo g_price($TPL_V1["total_price"])?></strong> <?php echo $TPL_VAR["fbUnit"]["b"]?></div>
									</div>
								</dd>
							</dl>
						</a>
						<!-- 주문 내역 - 상품 레이아웃 커스텀 E -->
					</li>
<?php }}?>
<?php }else{?>
					<li class="product-item__list no-data" >
						<p class="empty-content">최근 1개월 내 주문 내역이 없습니다.</p>
					</li>
<?php }?>
				</ul>
			</div>
			<!-- 최근 주문 내역 - 리스트 E -->
		</section>
		<section class="fb__mypage__wishlist">
			<div class="fb__mypage-title">
				<div class="title-sx">나의 위시리스트 상품</div>
				<a href="/mypage/wishlist" class="btn-link">더 보기</a>
			</div>
			<ul class="fb__goods col-5">
<?php if($TPL_wishList_1){$TPL_I1=-1;foreach($TPL_VAR["wishList"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1< 5){?>
				<li class="fb__goods__list">
					<a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="fb__goods__link">
						<figure class="fb__goods__img">
							<div>
								<img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>">
							</div>
						</figure>
						<div class="fb__goods__info">
							<ul class="fb__goods__infoBox">
								<!-- <li class="fb__goods__etc">친환경 소재</li> -->
								<li class="fb__goods__name"><?php echo $TPL_V1["pname"]?></li>
								<li class="fb__goods__option"><?php echo $TPL_V1["add_info"]?></li>
								<li class="fb__goods__brand"><?php echo $TPL_V1["brand_name"]?></li>
							</ul>
						</div>
						<div class="fb__goods__important">
<?php if($TPL_V1["state_soldout"]){?>
							<span class="fb__goods__price__state" style="display: none">[품절]</span>
<?php }else{?>	
<?php if($TPL_V1["isPercent"]){?>
							<div class="fb__goods__sale"><p class="per"><em><?php echo $TPL_V1["discount_rate"]?></em>%</p></div>
<?php }?>
<?php }?>
							<span class="fb__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo g_price($TPL_V1["dcprice"])?></strong><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php if($TPL_V1["isDiscount"]){?>
							<span class="fb__goods__noprice"><?php echo $TPL_VAR["fbUnit"]["f"]?><strong><?php echo g_price($TPL_V1["listprice"])?></strong><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php }?>
						</div>
						<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
					</a>
					<a href="#" class="product-box__heart <?php if($TPL_V1["alreadyWish"]){?>product-box__heart--active<?php }?> " data-devWishBtn='<?php echo $TPL_V1["id"]?>'>hart</a>
				</li>
<?php }?>
<?php }}else{?>
				<!--등록된 상품이 없을 시 S -->
				<li class="empty-content" style="display: none">등록된 상품이 없습니다.</li>
				<!--등록된 상품이 없을 시 E -->
<?php }?>
			</ul>
		</section>
	</section>
	<!-- 컨텐츠 E -->
</div>