<?php /* Template_ 2.2.8 2024/03/13 14:33:38 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/order_detail/order_detail.htm 000015379 */ 
$TPL_freeGift_1=empty($TPL_VAR["freeGift"])||!is_array($TPL_VAR["freeGift"])?0:count($TPL_VAR["freeGift"]);?>
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
<!-- 컨텐츠 S -->
<section class="br__order-detail">
	<div class="page-title my-title">
		<div class="title-sm">주문 상세 내역</div>
	</div>
	<!--취소교환반품 신청내역조회일 때 S -->
	<div class="order-number-box" id="devOrderDetailContent">
		<div class="order-number-box__cont">
			<dl class="order-number-box__item">
				<dt class="order-title">주문번호</dt>
				<dd class="order-number"><?php echo $TPL_VAR["order"]["oid"]?></dd>
			</dl>
			<dl class="order-number-box__item">
				<dt class="order-title">주문일자</dt>
				<dd class="order-day"><?php echo $TPL_VAR["order"]["order_date"]?></dd>
			</dl>
		</div>
		<div class="order-number-box__btn">
<?php if($TPL_VAR["order"]["status"]=='IR'||$TPL_VAR["order"]["status"]=='IC'){?>
			<button type="button" class="btn-lg btn-dark-line devOrderCancelAllBtn orderDetail_infi all_cancel" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>">전체 취소</button>
<?php }?>
		</div>
	</div>
	<!--취소교환반품 신청내역조회일 때 E -->

	<section class="br__order-content">
		<!-- 주문 내역 - 리스트 S -->
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div class="br__odhistory__list">
			<div class="br__mypage-title">
				<div class="title-sm">주문 상품</div>
			</div>
			<ul class="product-list">
				<!-- 최근 주문 내역이 없을 시 S -->
				<!-- 숨김처리 -->
				<li class="product-list__item no-data" style="display: none">
					<p class="empty-content">기간내 주문내역이 없습니다.</p>
				</li>
				<!-- 최근 주문 내역이 없을 시 E -->
				<li class="product-list__item">
					<!-- 상품 S -->
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_product_gift_3=empty($TPL_V2["product_gift"])||!is_array($TPL_V2["product_gift"])?0:count($TPL_V2["product_gift"]);?>
					<dl class="product-list__group">
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
									<img src="<?php echo $TPL_V2["pimg"]?>">
								</a>
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title"><?php echo $TPL_V2["pname"]?></div>

								<div class="product-list__info__option">
									<div class="product-list__info__option-item">
<?php if($TPL_V2["add_info"]){?><span class="color"><?php echo $TPL_V2["add_info"]?></span><?php }?>
										<span class="size"><?php echo $TPL_V2["option_text"]?></span>
										<span class="count"><?php echo $TPL_V2["pcnt"]?>개</span>
									</div>
								</div>
								<!-- 세트 상품 E -->

								<div class="product-list__info__price">
									<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
									<span class="product-list__info__status"><?php echo $TPL_V2["status_text"]?><?php if($TPL_V2["refund_status"]){?>/<?php echo $TPL_V2["refund_status_text"]?><?php }?></span>
								</div>
							</div>
						</dd>
					</dl>
					<div class="product-list__footer">
<?php if($TPL_V2["isDeliveryIng"]){?>						<div class="btn-group">
							<button class="btn-lg btn-gray-line devDeliveryTrace" data-quick="<?php echo $TPL_V2["quick"]?>" data-tracking_expiration="<?php echo $TPL_V2["tracking_expiration"]?>" data-invoice_no="<?php echo $TPL_V2["invoice_no"]?>">배송조회</button>
							<button class="btn-lg btn-dark-line devOrderComplateBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">배송완료</button>
						</div>
<?php }?>

<?php if($TPL_V2["isDeliveryComplate"]){?>						<div class="btn-group">
							<button class="btn-lg btn-dark-line devOrderReturnBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">반품신청</button>
							<button class="btn-lg btn-gray-line devDeliveryTrace" data-quick="<?php echo $TPL_V2["quick"]?>" data-tracking_expiration="<?php echo $TPL_V2["tracking_expiration"]?>" data-invoice_no="<?php echo $TPL_V2["invoice_no"]?>">배송조회</button>
						</div>
						<button class="btn-lg btn-dark-line odeach__btn--all devBuyFinalizedBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">구매확정</button>
<?php }?>

<?php if($TPL_V2["isByFinalized"]){?>							<div class="btn-group">
<?php if($TPL_V2["quick"]&&$TPL_V2["invoice_no"]){?>
							<button class="btn-lg btn-gray-line devInvoice" onclick="javascirt:void(0);" data-quick="<?php echo $TPL_V2["quick"]?>" data-tracking_expiration="<?php echo $TPL_V2["tracking_expiration"]?>" data-invoice_no="<?php echo $TPL_V2["invoice_no"]?>">배송조회</button>
<?php }?>
<?php if(is_login()){?>
<?php if($TPL_VAR["langType"]=='korean'){?>
									<button class="btn-lg btn-dark-line devOrderReturnBtn"><a class="crema-new-review-link odeach__btn--bk" data-product-code="<?php echo $TPL_V2["co_no"]?>" widget-id="100" >리뷰쓰기</a></button>
<?php }else{?>
<?php if(false){?>
									<button class="btn-lg btn-dark-line devByFinalized" data-pid="<?php echo $TPL_V2["pid"]?>" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-odix="<?php echo $TPL_V2["od_ix"]?>">리뷰쓰기</button>
<?php }?>
<?php }?>
<?php }?>
							</div>
<?php }?>
					</div>
					<!-- 상품 E -->

					<!-- 상품 사은품 S -->
<?php if($TPL_V2["product_gift"]){?>
					<div><h4 class="odeach__gift__title">구매 사은품 <!--<span>사은품타이틀</span>--></h4></div>
					<dl class="product-list__group">
<?php if($TPL_product_gift_3){foreach($TPL_V2["product_gift"] as $TPL_V3){?>
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<img src="<?php echo $TPL_V3["image_src"]?>" alt="">
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title"><?php echo $TPL_V3["pname"]?></div>

								<div class="product-list__info__option">
									<div class="product-list__info__option-item">
										<span class="count">1개</span>
									</div>
								</div>
							</div>
						</dd>
<?php }}?>
					</dl> 
<?php }?>
<?php }}?>
					<!-- 상품 사은품 E -->
				</li>
			</ul>
		</div>
<?php }}?>
		<!-- 주문 내역 - 리스트 E -->

		<!--구매별 사은품 S -->
<?php if($TPL_VAR["freeGift"]){?>
<?php if($TPL_freeGift_1){foreach($TPL_VAR["freeGift"] as $TPL_V1){?>
<?php if($TPL_V1["gift_products"]){?>
		<div class="gift-wrap">
			<div class="br__mypage-title">
				<div class="title-sm">구매금액별 사은품</div>
			</div>
			<ul class="product-list">
				<li class="product-list__item">
					<!-- 상품 S -->
<?php if(is_array($TPL_R2=$TPL_V1["gift_products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
					<dl class="product-list__group" id="devPgItem">
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<img src="<?php echo $TPL_V2["image_src"]?>" alt="">
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title"><?php echo $TPL_V2["pname"]?></div>

								<!-- 일반 상품 S -->
								<div class="product-list__info__option">
									<div class="product-list__info__option-item">
										<span class="count">1개</span>
									</div>
								</div>
								<!-- 일반 상품 E -->
							</div>
						</dd>
					</dl>
<?php }}?>
				</li>
			</ul>
		</div>
<?php }?>
<?php }}?>
<?php }?>
		<!--구매별 사은품 E -->

		<!--배송 정보 S -->
		<div class="pay-comp__wrap address">
			<div class="br__mypage-title">
				<div class="title-sm">배송 정보</div>
			</div>
			<div class="pay-comp__address">
				<div class="name"><?php echo $TPL_VAR["deliveryInfo"]["rname"]?> <span>(기본)</div>
				<div class="address">
<?php if($TPL_VAR["deliveryInfo"]["country_full"]){?>country : <p><?php echo $TPL_VAR["deliveryInfo"]["country_full"]?> </p> <?php }?>
					<p>[<?php echo $TPL_VAR["deliveryInfo"]["zip"]?>] <?php echo $TPL_VAR["deliveryInfo"]["addr1"]?> </p><p><?php echo $TPL_VAR["deliveryInfo"]["addr2"]?> </p>
<?php if($TPL_VAR["deliveryInfo"]["city"]){?>city : <p><?php echo $TPL_VAR["deliveryInfo"]["city"]?> </p><?php }?>
<?php if($TPL_VAR["deliveryInfo"]["state"]){?>state: <p><?php echo $TPL_VAR["deliveryInfo"]["state"]?><?php }?>
				</div>
				<div class="title">
					<p>주문자명 : <?php echo $TPL_VAR["order"]["bname"]?></p>
				</div>
				<div class="title">배송 요청사항</div>
				<div class="message">
<?php if(false&&$TPL_VAR["order"]["status"]==(ORDER_STATUS_INCOM_READY||$TPL_VAR["order"]["status"]==ORDER_STATUS_INCOM_COMPLETE)){?>
					<button class="order-detail__wrap__btn" id="devDeliveryRequestChangeBtn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>">변경하기</button>
<?php }?>
<?php if(is_array($TPL_R1=$TPL_VAR["deliveryInfo"]["msg"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["msg"]!=''){?>
						<span><?php echo $TPL_V1["msg"]?></span>
<?php }else{?>
						<span>-</span>
<?php }?>
<?php }}?>
				</div>
			</div>
		</div>
		<!--배송 정보 E -->

		<!--결제 정보 S -->
		<div class="pay-comp__wrap payment">
			<div class="br__mypage-title">
				<div class="title-sm">결제 정보</div>
			</div>
			<div class="pay-comp__payment">
				<dl class="pay-comp__payment__total">
					<dt>총 결제 예정 금액</dt>
					<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["payment"][ 0]["payment_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>

				<!-- 가상 계좌 결제 시 노출 S -->
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["method"]==ORDER_METHOD_BANK||$TPL_V1["method"]==ORDER_METHOD_VBANK||$TPL_V1["method"]==ORDER_METHOD_ICHE||$TPL_V1["method"]==ORDER_METHOD_ASCROW){?>
				<div class="pay-comp__payment__virtual">
					<div class="title-sm">입금 정보</div>
					<div class="pay-comp__payment__virtual-text">
						<?php echo $TPL_V1["bank"]?> / 계좌번호 : <em><?php echo $TPL_V1["bank_account_num"]?></em><br />
						<?php echo $TPL_V1["vb_info"]?><?php if($TPL_V1["bank_input_name"]!=''){?>예금주 : <?php echo $TPL_V1["bank_input_name"]?><?php }?>  <!-- 예금주 : 주식회사 배럴 -->
					</div>
					<div class="layout-flex txt-red">
						<span>입금 기한</span>
						<span><?php echo date('Y년 m월 d일',strtotime($TPL_V1["bank_input_date"]))?>까지</span>
					</div>
				</div>
<?php }?>
<?php }}?>

				<div class="pay-comp__payment__list">
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<dl class="pay-comp__payment__box">
						<dt>결제수단</dt>
						<dd><?php echo $TPL_V1["method_text"]?></dd>
					</dl>
<?php }}?>
					<dl class="pay-comp__payment__box">
						<dt>총 상품금액</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>상품 할인</dt>
						<dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["dr_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>등급 할인</dt>
						<dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["mg_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>쿠폰 할인</dt>
						<dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["cp_dc"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>적립금 사용</dt>
						<dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["use_reserve"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>총 배송비</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["order"]["delivery_price"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
				</div>
				<dl class="pay-comp__payment__benefits">
					<dt>적립 혜택</dt>
					<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["paymentInfo"]["total_reserve"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>
			</div>
		</div>
		<!--결제 정보 E -->
	</section>

<?php if(is_login()){?>
<?php if($TPL_VAR["langType"]=='korean'&&$TPL_VAR["order"]["status"]!='IR'){?>
	<div class="br__order-footer">
		<button class="btn-lg btn-dark-line order-detail__btn order-detail__btn--type1  order-detail__btn--full receipt-btn" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" >영수증 보기</button>
	</div>
<?php }?>
	
<?php if($TPL_VAR["claimData"]["cancelData"]&&$TPL_VAR["claimData"]["returnData"]){?>
	<div class="br__order-footer">
		<button class="btn-lg btn-dark-line order-detail__btn order-detail__btn--type1 cancelBtn" >주문취소 환불내역</button>
		<button class="btn-lg btn-dark-line order-detail__btn order-detail__btn--type1 bringBackBtn" >반품신청 환불내역</button>
	</div>
<?php }else{?>
<?php if($TPL_VAR["claimData"]["cancelData"]){?>
		<div class="br__order-footer">
			<button class="btn-lg btn-dark-line order-detail__btn order-detail__btn--type1 order-detail__btn--full cancelBtn" >주문취소 환불내역</button>
		</div>
<?php }?>
<?php if($TPL_VAR["claimData"]["returnData"]){?>
		<div class="br__order-footer">
			<button class="btn-lg btn-dark-line order-detail__btn order-detail__btn--type1 order-detail__btn--full bringBackBtn" >반품신청 환불내역</button>
		</div>
<?php }?>
<?php }?>
<?php }?>
</section>
<!-- 컨텐츠 E -->