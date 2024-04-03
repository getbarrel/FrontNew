<?php /* Template_ 2.2.8 2024/03/06 13:12:48 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/receipt_print/receipt_print.htm 000006656 */ ?>
<!-- 컨텐츠 S -->
<section class="br__order-detail receipt-print">
	<div class="page-title my-title">
		<div class="title-sm">결제영수증</div>
	</div>
	<section class="br__order-content">
		<!--결제 정보 S -->
		<div class="pay-comp__wrap payment">
			<div class="pay-comp__payment">
				<div class="pay-comp__payment__list">
					<dl class="pay-comp__payment__box">
						<dt>주문번호</dt>
						<dd><?php echo $TPL_VAR["order"]["oid"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>주문일자</dt>
						<dd><?php echo $TPL_VAR["order"]["order_date"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>주문자</dt>
						<dd><?php echo $TPL_VAR["order"]["bname"]?></dd>
					</dl>
				</div>
				<div class="product-list__footer">
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(($TPL_V1["method"]==ORDER_METHOD_VBANK||$TPL_V1["method"]==ORDER_METHOD_ICHE||$TPL_V1["method"]==ORDER_METHOD_ASCROW)&&$TPL_V1["receipt_yn"]=='Y'){?>
<?php if($TPL_V1["tid"]){?>
								<button class="btn-lg btn-dark-line order-detail__btn devCachInfo" data-tid="<?php echo $TPL_V1["tid"]?>" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-total="<?php echo intval($TPL_V1["payment_price"])?>">현금영수증 조회</button>
<?php }?>
<?php }elseif($TPL_V1["method"]==ORDER_METHOD_CARD){?>
<?php if($TPL_V1["tid"]){?>
							<button class="btn-lg btn-dark-line order-detail__btn devCardInfo" data-tid="<?php echo $TPL_V1["tid"]?>" data-oid="<?php echo $TPL_VAR["order"]["oid"]?>" data-total="<?php echo intval($TPL_V1["payment_price"])?>">신용카드 전표</button>
<?php }?>
<?php }?>
<?php }}?>
				</div>
			</div>
		</div>
		<!--결제 정보 E -->

		<!-- 주문 내역 - 리스트 S -->
<?php if(is_array($TPL_R1=$TPL_VAR["order"]["orderDetail"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
		<div class="br__odhistory__list">
			<div class="br__mypage-title">
				<div class="title-sm">주문 상품</div>
			</div>
			<ul class="product-list">
				<li class="product-list__item">
					<!-- 상품 S -->
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){
$TPL_setData_3=empty($TPL_V2["setData"])||!is_array($TPL_V2["setData"])?0:count($TPL_V2["setData"]);?>
					<dl class="product-list__group">
						<dt class="product-list__group-left">
							<figure class="product-list__thumb">
								<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>">
									<img src="<?php echo $TPL_V2["pimg"]?>" data-protocol="<?php echo IMAGE_SERVER_DOMAIN?>" >
								</a>
							</figure>
						</dt>
						<dd class="product-list__group-right">
							<div class="product-list__info">
								<div class="product-list__info__title"><a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>"><?php echo $TPL_V2["pname"]?></a></div>

								<div class="product-list__info__option">
									<div class="product-list__info__option-item">

<?php if($TPL_V2["set_group"]> 0){?>                                    <?php if($TPL_setData_3){foreach($TPL_V2["setData"] as $TPL_V3){?>
									<span class="size"><?php echo $TPL_V3["option_text"]?> (구성수량:<?php echo $TPL_V3["pcnt"]?>개)</span>
<?php }}?>
<?php }else{?>
                                    <span class="size"><?php echo $TPL_V2["option_text"]?></span>
<?php }?>
<?php if($TPL_V2["add_info"]){?><span class="color"><?php echo $TPL_V2["add_info"]?></span><?php }?>
									</div>
								</div>
								<!-- 세트 상품 E -->

								<div class="product-list__info__price">
									<span class="product-list__info__status"><?php echo $TPL_V2["status_text"]?><?php if($TPL_V2["refund_status"]){?>/<?php echo $TPL_V2["refund_status_text"]?><?php }?></span>
									<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V2["pt_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
								</div>
							</div>
						</dd>
					</dl>
<?php }}?>
				</li>
			</ul>
		</div>
<?php }}?>
		<!-- 주문 내역 - 리스트 E -->

		<!--결제 정보 S -->
		<div class="pay-comp__wrap payment">
			<div class="br__mypage-title">
				<div class="title-sm">결제 정보</div>
			</div>
			<div class="pay-comp__payment">
				<div class="pay-comp__payment__list">
<?php if(is_array($TPL_R1=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
					<dl class="pay-comp__payment__box">
						<dt>결제수단</dt>
						<dd><?php if(is_array($TPL_R2=$TPL_VAR["paymentInfo"]["payment"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?><?php echo $TPL_V1["method_text"]?> <?php }}?></dd>
					</dl>
<?php }}?>
					<dl class="pay-comp__payment__box">
						<dt>총 상품금액</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["paymentInfo"]["total_listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>총 할인금액</dt>
						<dd><?php if($TPL_VAR["paymentInfo"]["total_dc"]> 0){?>-<?php }?><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["paymentInfo"]["total_dc"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>적립금 사용</dt>
						<dd><?php if($TPL_VAR["paymentInfo"]["use_reserve"]> 0){?>-<?php }?><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["paymentInfo"]["use_reserve"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>총 배송비</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["order"]["delivery_price"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
					</dl>
					<dl class="pay-comp__payment__box">
						<dt>총 결제 금액</dt>
						<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo number_format($TPL_VAR["paymentInfo"]["pt_dcprice"]+$TPL_VAR["order"]["delivery_price"])?><?php echo $TPL_VAR["fbUnit"]["f"]?></dd>
					</dl>
				</div>
			</div>
		</div>
		<!--결제 정보 E -->
	</section>

	<!-- <div class="br__order-footer">
		<button class="btn-lg btn-dark-line order-detail__btn order-detail__btn--type1 receipt-print__btn__capture" >이미지 저장</button>
		<p>본 영수증은 소득공제 및 매입 계산서로 사용할 수 없으며 결제된 내역을 <br>증명하는 용도입니다.</p>
	</div> -->
</section>
<!-- 컨텐츠 E -->