<?php /* Template_ 2.2.8 2024/01/29 16:08:18 /home/barrel-stage/application/www/assets/templet/enterprise/popup/order_list/order_list.htm 000007040 */ ?>
<div id="devModalContent" class="popup-content">
				<section class="popup-content__wrap">
					<section class="popup-search">
						<form id="devListForm">
							<input type="hidden" name="page" value="1" id="devPage" />
							<input type="hidden" name="max" value="3"/>
							<div class="search">
								<div class="search__row">
									<div class="search__col">
										<div class="fb__form-item">
											<label for="devSdate" class="hide">조회기간</label>
											<input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick fb__form-input" title="조회시작기간" />
											<span>-</span>
											<input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick fb__form-input" title="조회종료기간" />
											<button type="button" title="조회" class="btn-lg btn-dark-line">조회</button>
										</div>
									</div>
									<div class="search__col">
										<div class="search__day">
											<div class="day-radio">
												<a href="#" class="day-radio__btn devDateBtn day-radio--active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="devDateDefault">최근 <em>1</em>개월</a>
												<a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["threeMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>3</em>개월</a>
												<a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>6</em>개월</a>
												<a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>12</em>개월</a>
												<!-- <a href="#;" class="day-radio__btn day-radio--active">최근 <em>1</em>개월</a>
												<a href="#;" class="day-radio__btn">최근 <em>3</em>개월</a>
												<a href="#;" class="day-radio__btn">최근 <em>6</em>개월</a>
												<a href="#;" class="day-radio__btn">최근 <em>12</em>개월</a> -->
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="search__result">
								<ul class="product-item__wrap" id="devListContents">
									<!-- 최근 주문 내역이 없을 시 S -->
									<!-- 숨김처리 -->
									<li class="product-item__list no-data" id="devListEmpty">
										<p class="empty-content">주문 내역이 없습니다.</p>
									</li>
									<li class="product-item__list no-data" id="devListLoading">
										<div class="devForbizTpl loading-text">loading...</div>
									</li>
									<!-- 최근 주문 내역이 없을 시 E -->
									<li class="product-item__list" id="devListDetail">
										<!-- 주문 내역 - 상품 레이아웃 커스텀 S -->
										<dl class="product-item">
											<dt class="product-item__thumbnail-box">
												<div class="product-item__checkbox">
													<input type="checkbox" class="cart_product_check" />
												</div>
												<div class="product-item__thumb devOrderListOid cursorP" data-oid="{[oid]}">
													<a href="#;">
														<img src="{[product_image_src]}" alt="" />
													</a>
												</div>
											</dt>
											<dd class="product-item__infobox">
												<div class="product-item__info devOrderListOid cursorP" data-oid="{[oid]}">
													<div class="order-day">{[order_date]}</div>
													<div class="product-item__title c-pointer">
														<a href="#;">{[buy_product_name]}</a>
													</div>
													<div class="order-number">{[oid]}</div>
												</div>
												<div class="product-item__btn-area">
													<div class="order-price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[payment_price]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
												</div>
												<button class="btn-xs btn-white" devSelectOid="{[oid]}" devSelectimg="{[product_image_src]}" devSelectdate="{[order_date]}" devSelecttitle="{[buy_product_name]}" devSelectprice="<?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[payment_price]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?>">선택</button>
											</dd>
										</dl>
										<!-- 주문 내역 - 상품 레이아웃 커스텀 E -->
									</li>
								</ul>
								<div id="devPageWrap"></div>
								<!-- <div class="search__result-btn">
									<button type="button" class="btn-lg btn-dark-line" devSelectOid="{[oid]}" devSelectimg="{[product_image_src]}" devSelectdate="{[order_date]}" devSelecttitle="{[buy_product_name]}" >확인</button>
								</div> -->
							</div>
						</form>
					</section>
				</section>
			</div>
<!--
<form id="devListForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="2" />
</form>

<div class="popup-order-check">
    <div class="desc">문의하려는 주문건을 확인 후 ‘선택’ 버튼을 누르시면 해당 주문건에 대한 문의 접수가 가능합니다.</div>
    <table class="table-default">
        <tbody id="devListContents">
        <colgroup>
            <col width="174px">
            <col width="*">
            <col width="100px">
            <col width="90px">
        </colgroup>
        <thead>
        <tr>
            <th>주문번호/주문일자</th>
            <th>주문상품</th>
            <th>총 결제금액</th>
            <th>선택</th>
        </tr>
        </thead>
        <tr id="devListDetail">
            <td>
                <p class="order-num">{[oid]}</p>
                <p class="date">{[order_date]}</p>
            </td>
            <td class="devOrderListOid cursorP" data-oid="{[oid]}">
                <div class="thumb">
                    <img src="{[product_image_src]}" width="100px">
                </div>
                <p class="title">{[buy_product_name]}</p>
            </td>
            <td>
                <p class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[payment_price]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
            </td>
            <td>
                <button class="btn-xs btn-white" devSelectOid="{[oid]}">선택</button>
            </td>
        </tr>
        <!--내역이 없을 경우-- 
        <tr>
            <td colspan="4" class="sj__cash-withdraw__listbox--empty empty-content" id="devListEmpty">
                <p>
                    주문하신 내역이 없습니다.
                </p>
            </td>
        </tr>
        </tbody>
    </table>
    <div id="devListLoading" class="devForbizTpl loading-text">loading...</div>
    <div id="devPageWrap"></div>
    <div class="popup-btn-area">
        <button class="btn-default btn-dark-line btn-orderlayer-close">닫기</button>
    </div>

</div>
-->