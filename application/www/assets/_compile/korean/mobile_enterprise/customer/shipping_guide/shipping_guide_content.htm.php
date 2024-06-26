<?php /* Template_ 2.2.8 2024/01/22 13:31:15 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/customer/shipping_guide/shipping_guide_content.htm 000013221 */ ?>
<div class="br__guide-wrap">
	<div class="page-title">
		<div class="title-md">배송 안내</div>
	</div>
<?php if($TPL_VAR["langType"]=='korean'){?>
	<div class="gform">
		<div class="gform__common">
			<div class="gform__common__top">배송업체</div>
			<div class="gform__common__desc">
				<p>CJ 대한통운</p>
			</div>
		</div>
		<div class="gform__common">
			<div class="gform__common__top">배송업체</div>
			<div class="gform__common__desc">
				<p>
					총 실결제금액 30,000원 미만 시 배송비 2,500원<br />
					(산간벽지, 도서지방 3,000원 추가)
				</p>
			</div>
		</div>
		<div class="gform__common">
			<div class="gform__common__top">배송기간</div>
			<div class="gform__common__desc">
				<p>
					영업일 기준 1~3일 소요.<br />
					(여름 시즌의 경우 주문량이 많아 평균 2~5일 소요.)
				</p>
			</div>
		</div>
		<div class="gform__common">
			<div class="gform__common__top">배송 유의사항</div>
			<div class="gform__common__desc">
				<ul>
					<li>당일 오후 2시 이전 결제 완료된 주문건의 경우, 일괄적으로 당일 출고됩니다.</li>
					<li>주문번호가 다를 경우 묶음 배송은 불가합니다.</li>
					<li>천재지변, 일시품절 등의 경우에 따라 일반적인 배송기간보다 지연될 수 있습니다.</li>
					<li>배송사의 물량증가로 인한 지연이 있을 수 있습니다.</li>
					<li>품절상품은 발송 전 순차적으로 연락드립니다.</li>
					<li>주문서 입금 확인 시 상품 변경 및 주소 변경이 불가합니다.<br />변경을 희망하시는 경우 전체 취소 후 재구매를 부탁드립니다.</li>
					<li>송장 발행 / 배송 준비 중 상태는 상품 포장이 완료된 상태로 취소 또는 변경이 불가합니다.</li>
					<li>
						배송 중 상태에서는 반송 및 수취거부는 불가합니다.<br />상품을 수령하신 후 반품 신청을 부탁드립니다.<br />
						(고객변심으로 인한 반품 시 반품비가 발생됩니다.)
					</li>
				</ul>
			</div>
		</div>
	</div>
<?php }else{?>
	<p class="gform__info">
		- Excluding the product for free delivery set individually at checking in, delivery fee
		shall be applied for the basic delivery of product based on the standard charge rate of
		overseas delivery by EMS.<br>

		- This is applicable only to the U.S., Canada, Australia, Japan, China, China Hong Kong, Chinese Taipei,
		Singapore, Cambodia, Laos, China Macau, Malaysia, Mongol, Myanmar, Thailand, Vietnam and Philippines.<br>

		- Delivery fee differs by the weight and destination of package and each country. The product will be delivered
		after the payment is completed. It will take 10 to 15 days to China, and more than 15 days to other countries.
		(Only when we have inventories for the item.) Some items may take longer days of delivery. It may take 2 to 3 days
		to obtain a tracking information of EMS.<br>

		- A tracking number shall be transmitted through email and you can check it by clicking your order number at MY ACCOUNT > YOUR ORDERS.
		Import tax and customs tax may be imposed on international shipement of product. Tax will be imposed when the package arrives at the
		destination country. A recipient shall take responsibility for all related process fee. If customer refuse to take the package, the product will be returned to
		Korea and never be delivered again. Delivery fee will be deducted from your refund.<br><br>

		Tracking entire world: http://www.track-trace.com/post<br>
		Tracking U.S.A: http://tools.usps.com<br>
		Tracking Canada: http://www.danadapost.ca<br>
		Tracking Australia: http://auspost.com.au/track<br>
	</p>
<?php }?>
</div>

<!--
<div class="gform shippingGuide">
    <!---- 
    <div class="gform__common">
        <h3 class="gform__common__top">배송 안내</h3>
<?php if($TPL_VAR["langType"]=='korean'){?>
        <dl class="gform__info">
            <dt class="gform__info__title eng-hidden">배송업체</dt>
            <dd class="gform__info__detail eng-hidden">CJ 대한통운</dd>
            <dt class="gform__info__title eng-hidden">배송비용</dt>
            <dd class="gform__info__detail eng-hidden">
                주문금액 30,000원 미만 시<br>배송비 2,500원 추가<br>※ 산간벽지, 도서지방은 3,000원 추가
            </dd>
            <dt class="gform__info__title">배송기간</dt>
            <dd class="gform__info__detail">
                1-3일 소요(평일기준)<br>여름시즌 : 2-5일 소요(평일기준)
            </dd>
        </dl>
<?php }else{?>
        <p class="gform__info">
            - Excluding the product for free delivery set individually at checking in, delivery fee
            shall be applied for the basic delivery of product based on the standard charge rate of
            overseas delivery by EMS.<br>

            - This is applicable only to the U.S., Canada, Australia, Japan, China, China Hong Kong, Chinese Taipei,
            Singapore, Cambodia, Laos, China Macau, Malaysia, Mongol, Myanmar, Thailand, Vietnam and Philippines.<br>

            - Delivery fee differs by the weight and destination of package and each country. The product will be delivered
            after the payment is completed. It will take 10 to 15 days to China, and more than 15 days to other countries.
            (Only when we have inventories for the item.) Some items may take longer days of delivery. It may take 2 to 3 days
            to obtain a tracking information of EMS.<br>

            - A tracking number shall be transmitted through email and you can check it by clicking your order number at MY ACCOUNT > YOUR ORDERS.
            Import tax and customs tax may be imposed on international shipement of product. Tax will be imposed when the package arrives at the
            destination country. A recipient shall take responsibility for all related process fee. If customer refuse to take the package, the product will be returned to
            Korea and never be delivered again. Delivery fee will be deducted from your refund.<br><br>

            Tracking entire world: http://www.track-trace.com/post<br>
            Tracking U.S.A: http://tools.usps.com<br>
            Tracking Canada: http://www.danadapost.ca<br>
            Tracking Australia: http://auspost.com.au/track<br>
        </p>
<?php }?>
    </div>

<?php if($TPL_VAR["langType"]=='korean'){?>
    <p class="gform__common__desc">
        당일 오후 2시 이전 주문건(결제 완료된 주문건)의 경우,<br>일괄적으로 당일 출고됩니다.
    </p>
    <p class="gform__common__desc">
        주문번호가 다를 경우 묶음 배송은 불가합니다.
        <!--소리대리 요청으로 배럴데이 기간 주석처리
        <br>단, 수령지와 수령인이 동일할 경우 고객센터로 요청 시<br>묶음 배송 요청이 가능합니다.
        -- 
    </p>
    <p class="gform__common__desc">
        천재지변, 일시품절 등의 경우에 따라 일반적인<br>배송기간보다 다소 지연될 수 있습니다.
    </p>
    <p class="gform__common__desc">
        배송사의 물량증가로 인한 지연이 있을 수 있습니다.
    </p>
    <p class="gform__common__desc">
        품절상품은 발송 전 순차적으로 연락드립니다.
    </p>
	<p class="gform__common__desc">
        주문서 입금 확인 시 상품 변경 및 주소지 변경이 불가하여 주문 전체 취소 후 재주문 부탁드립니다.
    </p>
    <p class="gform__common__desc">
        송장 발행 / 배송 준비 중은 상품의 포장이 완료된 상태로 취소, 변경 불가능합니다.
    </p>

    <p class="gform__common__desc">
        배송 중 상태에서는 '반송 및 수취거부'는 불가합니다. 상품을 수령하신 후 반품 신청을 부탁드립니다. (반품비 발생)
    </p>
    <!--<p class="gform__common__desc">
        배송 준비중 상태에서는 취소가 불가합니다.<br>단, <em class=""gform__common__desc--point"">오전 9시 이전 주문건의 경우 오전 10시까지,<br>오후 2시 이전 주문건의경우 오후 3시까지<br></em>고객센터를 통해 취소 접수가 가능할 수 있으니<br>취소를 요청하는 경우 고객센터로 연락 부탁드립니다.
    </p>-- 
<?php }else{?>


    <p class="shippingGuide__desc">
        <strong class="shippingGuide__desc__title">[Customs Tax & Tax Related]</strong>
        - According to the national convention, customs tax may be imposed during the transportaion process.<br>
        - Customers will bear customs tax, and customs tax amount differs by the purchased region and item.<br>
        - Barrel provides an international transportation service through EMS.<br>
        - Please inquire details at EMS customer service center (phone: 11185) or at nearby post office.<br>
        - Customer will take all related cost.(including return transportaion cost, customs tax etc)<br>
        - Barrel will take responsibility for all cost besides the above cost.<br>
        - Any country may impose tax on the product you have purchased. Recipient will take responsibility for this expense.<br>
        - Barrel does not take any responsibility for unpaid customs tax.<br>
        - Barrel does not provide a refund for the order returned due to the problem of customs tax.<br>
    </p>
    <p class="shippingGuide__desc">
        <strong class="shippingGuide__desc__title">[Delivery Period]</strong>
        - It will take 10 days to process your order based on the business day.<br>
        - It may take longer delivery days for some products by each manufacturing company.<br>
        - According to the characteristic of fashion market in Korea, some delays are inevitable, and it may delay your
        order by maximum 20 business days.<br>
        - The delay of delivery is applicable to all customers of Korean brand and foregin brands.<br>
        - We will do our best for customers to receive products any where as fast as possible.<br>
        - If delay takes place, we would like to inform you of our best effort to deliver the product. In summer season, the delivery period may be longer
        due to a flood of orders.
        - Please keep this in mind and place an order in advance from the period you need.<br>
        - It may take longer business days for some regions but shipping will take 10 to 15 business days.<br>
    </p>
    <p class="shippingGuide__desc">
        <strong class="shippingGuide__desc__title">[Delivery]</strong>
        - If the shipping is omitted due to an insufficient inventory of product, we will send you emial when we have the product to ship.
        We will not charge additional delivery fee.<br>
        - If a recipient is absent or he cannot receive the product due to uncontrollable factors, Barrel will store the product in a corresponding site in charge for
        7 days according to the delivery procedure of EMS. If the recipient does not receive the product after 7 days, the shipped product shall
        be returned and we will not take responsibility for returned package. If the shipped package is returned, we will send you email regarding its situation.
        If a proper action is not taken within 3 weeks, we have a right to sell shipped product.
    </p>
    <p class="shippingGuide__desc">
        <strong class="shippingGuide__desc__title">[Cancellation]</strong>
        - Product in preparation: Possible to request for cancellation or change.

        - Delivery in preparation: Condition of complete product packing. Cancellation or change is not possible.

        - Cancellation or change after shipping: Cancellation or change is not possible after the shipping.
    </p>

<?php }?>


    <div class="gform__common">
        <h3 class="gform__common__top">취소 안내</h3>
        <dl class="gform__info">
            <dt class="gform__info__title">
                입금확인(결제완료)
            </dt>
            <dd class="gform__info__detail">
                주문 전체 취소만가능
            </dd>
            <dt class="gform__info__title">
                배송준비중
            </dt>
            <dd class="gform__info__detail">
                상품의 포장이 완료된 상태로<br>취소, 변경 불가능
            </dd>
            <dt class="gform__info__title">
                발송된 이후<br>취소/변경
            </dt>
            <dd class="gform__info__detail">
                발송된 이후에는 취소 및 변경이 불가능.<br>반품으로 진행되어 왕복 배송비를<br>부담해야합니다.
            </dd>
        </dl>
    </div>
    <p class="gform__common__desc">
        저희 BARREL은 빠른 배송을 위해 당일 출고로 진행되고<br>있습니다. 순차 출고되는 타 사이트에 비해 상품 준비 중<br>단계가 매우 짧아 취소/변경이 불가할 수 있습니다.
    </p>
</div>
-->