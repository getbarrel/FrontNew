<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_detail/order_detail_org.htm 000020916 */ ?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<div class="wrap-mypage wrap-order-detail">
	<section>
		<h1>주문상세 조회</h1>
        <!--<h1>신청내역 조회</h1>--><!--취소교환반품 신청내역조회일 때-->

		<div class="order-number-box">
			<span class="tit">주문번호</span>
			<span class="order-num"><?php echo $TPL_VAR["order"]["oid"]?></span>
			<span class="tit">주문일자</span>
			<span class="order-date"><?php echo $TPL_VAR["order"]["order_date"]?></span>

			<button class="btn-s btn-dark-line receipt-btn">결제영수증 출력</button>
		</div>

		<table class="table-default order-table">
			<colgroup>
				<col width="*"/>
				<col width="100px"/>
				<col width="100px"/>
				<col width="100px"/>
				<col width="100px"/>
				<col width="100px"/>
			</colgroup>
			<thead>
			<th>상품명/옵션</th>
			<th>주문수량</th>
			<th>상품금액</th>
			<th>할인금액</th>
			<th>결제금액</th>
			<th>주문상태</th>
			</thead>
			<tbody>
			<tr>
				<td>
					<a href="#">
						<div class="thumb">
							<img src="<?php echo $TPL_VAR["templet_src"]?>/img/sample/sample_90.jpg">
						</div>
						<div class="info">
							<p class="title">[브랜드명] 우리지역 시금치 200g</p>
							<p class="option">흙당근 10kg</p>
						</div>
					</a>
				</td>
				<td><em>1</em>개</td>
				<td><em>19,000</em>원</td>
				<td>-<em>19,000</em>원
					<span class="tooltip">
					<div class="tooltip-layer">
						<dl>
							<dt>즉시할인</dt>
							<dd>1,000원</dd>
						</dl>
						<dl>
							<dt>기획할인</dt>
							<dd>0원</dd>
						</dl>
						<dl>
							<dt>쿠폰할인</dt>
							<dd>1,000원</dd>
						</dl>
						<dl class="total">
							<dt>총 할인금액</dt>
							<dd>2,000원</dd>
						</dl>
					</div>
					</span>

				</td>
				<td class="price"><em>19,000</em>원</td>
				<td>
					<p>취소완료</p>
					<p>환불완료</p>
				</td>
			</tr>
			<tr>
				<td>
					<a href="#">
						<div class="thumb">
							<img src="<?php echo $TPL_VAR["templet_src"]?>/img/sample/sample_90.jpg">
						</div>
						<div class="info">
							<p class="title">[브랜드명] 우리지역 시금치 200g</p>
							<p class="option">흙당근 10kg</p>
						</div>
					</a>
				</td>
				<td><em>1</em>개</td>
				<td><em>19,000</em>원</td>
				<td>-<em>19,000</em>원 <span class="tooltip"></span></td>
				<td class="price"><em>19,000</em>원</td>
				<td>
					<p>취소완료</p>
					<p>환불완료</p>
				</td>
			</tr>
			</tbody>
		</table>
		<div class="delivery-area">
			<span>배송비 <em>2,500원</em> (<em>50,000</em> 이상 구매 시 무료 배송)</span>
		</div>

		<table class="table-default order-table">
			<colgroup>
				<col width="*"/>
				<col width="100px"/>
				<col width="100px"/>
				<col width="100px"/>
				<col width="100px"/>
				<col width="100px"/>
			</colgroup>
			<thead>
			<th>상품명/옵션</th>
			<th>주문수량</th>
			<th>상품금액</th>
			<th>할인금액</th>
			<th>결제금액</th>
			<th>주문상태</th>
			</thead>
			<tbody>
			<tr>
				<td>
					<a href="#">
						<div class="thumb">
							<img src="<?php echo $TPL_VAR["templet_src"]?>/img/sample/sample_90.jpg">
						</div>
						<div class="info">
							<p class="title">[브랜드명] 우리지역 시금치 200g</p>
							<p class="option">흙당근 10kg</p>
						</div>
					</a>
				</td>
				<td><em>1</em>개</td>
				<td><em>19,000</em>원</td>
				<td>-<em>19,000</em>원 <span class="tooltip"></span></td>
				<td class="price"><em>19,000</em>원</td>
				<td>
					<p>취소완료</p>
				</td>
			</tr>
			</tbody>
		</table>
		<div class="delivery-area">
			<span>배송비 <em>2,500원</em> (<em>50,000</em> 이상 구매 시 무료 배송)</span>
		</div>


<?php if(false){?>
        <!--취소교환반품 신청내역조회일 때 S -->
        <table class="table-default order-table">
            <colgroup>
                <col width="*"/>
                <col width="100px"/>
                <col width="100px"/>
                <col width="100px"/>
            </colgroup>
            <thead>
            <th>상품명/옵션</th>
            <th>주문수량</th>
            <th>교환수량</th>
            <th>결제금액</th>
            </thead>
            <tbody>
            <tr>
                <td>
                    <a href="#">
                        <div class="thumb">
                            <img src="<?php echo $TPL_VAR["templet_src"]?>/img/sample/sample_90.jpg">
                        </div>
                        <div class="info">
                            <p class="title">[브랜드명] 우리지역 시금치 200g</p>
                            <p class="option">흙당근 10kg</p>
                        </div>
                    </a>
                </td>
                <td><em>3</em>개</td>
                <td><em>1</em>개</td>
                <td class="price"><em>19,000</em>원</td>
            </tr>
            </tbody>
        </table>
        <div class="delivery-area">
            <span>배송비 <em>2,500원</em> (<em>50,000</em> 이상 구매 시 무료 배송)</span>
        </div>
        <!--취소교환반품 신청내역조회일 때 E -->
<?php }?>
	</section>

	<section>
		<h1>주문결제 내역</h1>
		<div class="order-payment-list">
			<div class="section">
				<div class="sec">
					<h2>결제수단</h2>
					<p class="tit">가상계좌</p>
					<dl>
						<dt>은행명</dt>
						<dd>우리은행</dd>
					</dl>
					<dl>
						<dt>예금주</dt>
						<dd>포비즈코리아</dd>
					</dl>
					<dl>
						<dt>계좌번호</dt>
						<dd>1002785004755</dd>
					</dl>
					<dl>
						<dt>입금마감기한</dt>
						<dd>2018-08-08</dd>
					</dl>
				</div>

				<div class="sec">
					<h2>마일리지 적립</h2>
					<p>250원 적립(상품 구매 시)</p>
				</div>
			</div>
			<div class="section price">
				<dl>
					<dt>총 상품금액</dt>
					<dd><em>90,500</em>원</dd>
				</dl>
				<dl>
					<dt>총 할인금액</dt>
					<dd><em>-4,500</em>원</dd>
				</dl>
				<dl class="disc-list">
					<dt>즉시할인</dt>
					<dd><em>2,000</em>원</dd>
				</dl>
				<dl class="disc-list">
					<dt>기획할인</dt>
					<dd><em>2,000</em>원</dd>
				</dl>
				<dl class="disc-list">
					<dt>쿠폰할인</dt>
					<dd><em>2,000</em>원</dd>
				</dl>
				<dl class="disc-list">
					<dt>마일리지 사용</dt>
					<dd><em>2,000</em>원</dd>
				</dl>
				<dl class="mat10">
					<dt>총 배송비</dt>
					<dd><em>2,500</em>원</dd>
				</dl>
				<dl class="total-price">
					<dt>총 결제금액</dt>
					<dd><em>88,500</em>원</dd>
				</dl>

			</div>
		</div>
	</section>

	<section>
		<h1>주문취소 환불내역</h1>
		<table class="table-default refund-table">
			<colgroup>
				<col width="*">
				<col width="155px">
				<col width="145px">
				<col width="145px">
				<col width="145px">
			</colgroup>
			<thead>
			<th>상품명</th>
			<th>주문취소 상품 총 금액</th>
			<th>주문취소 배송비</th>
			<th>환불 예정 금액</th>
			<th>환불 처리일자</th>
			</thead>
			<tbody>
			<tr>
				<td class="product">[브랜드명]신선한 흙당근 10kg 한박스</td>
				<td><em>21,500</em>원</td>
				<td><em>0</em>원</td>
				<td><em>21,500</em>원</td>
				<td><em>2018-05-13</em></td>
			</tr>
			</tbody>
		</table>
	</section>

	<section>
		<h1>반품신청 환불내역</h1>
		<table class="table-default refund-table">
			<colgroup>
				<col width="*">
				<col width="155px">
				<col width="145px">
				<col width="145px">
				<col width="145px">
			</colgroup>
			<thead>
			<th>상품명</th>
			<th>반품신청 상품 총 금액</th>
			<th>반품 배송비</th>
			<th>환불 예정 금액</th>
			<th>환불 처리일자</th>
			</thead>
			<tbody>
			<tr>
				<td class="product">[브랜드명]신선한 흙당근 10kg 한박스</td>
				<td><em>21,500</em>원</td>
				<td><em>0</em>원</td>
				<td><em>21,500</em>원</td>
				<td><em>2018-05-13</em></td>
			</tr>
			</tbody>
		</table>
	</section>

	<section>
		<h1 class="clearfix">
			배송지 정보
			<button class="btn-xs btn-dark-line float-r address-link">배송지변경</button>
		</h1>

		<table class="join-table type02 shipping-info-table">
			<colgroup>
				<col width="180px">
				<col width="*">
			</colgroup>
			<tr>
				<th>받는 분</th>
				<td>홍길동</td>
			</tr>
			<tr>
				<th>주소</th>
				<td>
					<p>06744</p>
					<p>서울특별시 서초구 바우뫼로37길 56(양재동) 2층 포비즈코리아</p>
				</td>
			</tr>
			<tr>
				<th>휴대폰번호</th>
				<td>010-2345-5678</td>
			</tr>
			<tr>
				<th>전화번호</th>
				<td>02-2345-5678</td>
			</tr>
			<tr>
				<th>배송요청사항</th>
				<td class="request">
                    <div class="section"><!--복수 배송요청사항 section 이 반복 -->
                        <p class="product">[브랜드명]하루한끼 느타리 팩 150g</p>
                        <p>부재 시 경비실에 맡겨주세요.</p>
                        <div class="mat10">
                            <input type="text" id="input_request" onkeyup="onkeylengthMax(this, 200, 'msg_byte');" maxlength="30">
                            <button class="btn-default btn-dark">요청사항 변경</button>
                        </div>
                        <div class="mat10">
                            <div class="counting">
                                <em class="txt-error" style="display:none;">요청사항을 입력하세요.</em>
                                <span><em id="msg_byte">0</em>/30 자</span>
                            </div>
                        </div>
                    </div>
                    <div class="section more-btn toggle">
                        <span>더보기</span>
                    </div>
                    <div class="section">
                        <p class="product">[브랜드명]하루한끼 느타리 팩 150g</p>
                        <div class="mat10">
                            <input type="text" id="input_request" onkeyup="onkeylengthMax(this, 200, 'msg_byte');" maxlength="30">
                            <button class="btn-default btn-dark">요청사항 변경</button>
                        </div>
                        <div class="mat10">
                            <div class="counting">
                                <em class="txt-error" style="display:none;">요청사항을 입력하세요.</em>
                                <span><em id="msg_byte">0</em>/30 자</span>
                            </div>
                        </div>
                    </div>
                    <div class="section">
                        <p class="product">[브랜드명]하루한끼 느타리 팩 150g</p>
                        <div class="mat10">
                            <input type="text" id="input_request" onkeyup="onkeylengthMax(this, 200, 'msg_byte');" maxlength="30">
                            <button class="btn-default btn-dark">요청사항 변경</button>
                        </div>
                        <div class="mat10">
                            <div class="counting">
                                <em class="txt-error" style="display:none;">요청사항을 입력하세요.</em>
                                <span><em id="msg_byte">0</em>/30 자</span>
                            </div>
                        </div>
                    </div>
				</td>
			</tr>
		</table>
	</section>


    <!--취소교환반품 신청내역조회일 때 S -->
    <section>
        <table class="join-table type02 cancel-table">
            <colgroup>
                <col width="180px"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th rowspan="2">교환사유</th>
                <td>기타(구매자 책임)</td>
            </tr>
            <tr>
                <td>사이즈를 교환하고 싶어요. 교환해 주세요.</td>
            </tr>
        </table>
    </section>
    <section>
        <h1>교환거부/불가내역</h1>
        <table class="join-table type02 cancel-table">
            <colgroup>
                <col width="180px"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>상품정보</th>
                <td>
                    <p class="tit">[브랜드명] 하루한끼 느타리 팩</p>
                    <p class="option">흙당근</p>
                </td>
            </tr>
            <tr>
                <th>교환거부 사유</th>
                <td>해당 상품은 교환하실 수 없는 상품입니다.</td>
            </tr>
            <tr>
                <th>교환불가 사유</th>
                <td>해당 상품은 상당히 파손된 상태로 발송되었으며, 교환 불가인 상품이므로 교환하실 수 없습니다.</td>
            </tr>
        </table>
    </section>
    <section>
        <h1>교환방법</h1>
        <table class="join-table type02 cancel-table method">
            <colgroup>
                <col width="180px"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>교환 발송 방법</th>
                <td>
                    직접발송<span>(구매자께서 새별로 상품을 이미 발송한 경우)</span>
                </td>
            </tr>
            <tr>
                <th>교환 발송 정보</th>
                <td>
                    우체국 택배 <span>(송장번호:12312312313)</span> <br>
                    상품 발송 시 배송비 <span>선불</span>
                </td>
            </tr>
            <tr>
                <th rowspan="5">교환상품 받으실 주소<br>
                    <span>(구매자 주소지)</span>
                </th>
                <td>
                    <dl>
                        <dt>성명</dt>
                        <dd>홍길동</dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>주소</dt>
                        <dd>06744 서울특별시 서초구 바우뫼로37길 56(양재동, 건영빌딩) 2층 포비즈코리아</dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>휴대폰 번호</dt>
                        <dd><em>010-4153-4545</em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>전화번호</dt>
                        <dd><em>02-4153-4545</em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>배송요청사항</dt>
                        <dd></dd>
                    </dl>
                </td>
            </tr>
        </table>
    </section>

    <section>
        <h1>환불내역</h1>
        <div class="refund-list">
            <div class="clearfix">
                <div class="col">
                    <div class="row-top">
                        <p class="tit">취소신청 상품 총 금액</p>
                        <p class="price"><em>34,300</em>원</p>
                    </div>
                    <div class="row-bottom">
                        <dl>
                            <dt>취소상품 총 금액</dt>
                            <dd><em>38,000</em>원</dd>
                        </dl>
                        <dl>
                            <dt>취소상품 총 배송비</dt>
                            <dd><em>0</em>원</dd>
                        </dl>
                        <dl>
                            <dt>취소상품 총 할인금액</dt>
                            <dd><em>-3,700</em>원</dd>
                        </dl>
                        <dl class="disc-list first">
                            <dt>즉시할인</dt>
                            <dd><em>1,000</em>원</dd>
                        </dl>
                        <dl class="disc-list">
                            <dt>기획할인</dt>
                            <dd><em>1,500</em>원</dd>
                        </dl>
                        <dl class="disc-list">
                            <dt>쿠폰할인</dt>
                            <dd><em>1,000</em>원</dd>
                        </dl>
                        <dl class="disc-list">
                            <dt>마일리지 사용</dt>
                            <dd><em>200</em>원</dd>
                        </dl>
                    </div>
                </div>
                <div class="col">
                    <div class="row-top">
                        <p class="tit">환불금액 차감내역</p>
                        <p class="price"><em>0</em>원</p>
                    </div>
                    <div class="row-bottom">
                        <dl>
                            <dt>주문취소 배송비</dt>
                            <dd><em>0</em>원</dd>
                        </dl>
                    </div>
                </div>
                <div class="col">
                    <div class="row-top">
                        <p class="tit">환불 예정 금액</p>
                        <p class="price point-color"><em>34,300</em>원</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <dl>
                    <dt>결제수단(상품 구매 시)</dt>
                    <dd>가상계좌</dd>
                </dl>
                <dl>
                    <dt>환불수단</dt>
                    <dd>우리은행 / 100**********</dd>
                </dl>
            </div>
        </div>
        <div class="desc">
            결제수단 중 신용카드 및 실시간 계좌이체는 자동 환불 처리되며 기타 결제수단을 통해 결제하신 고객님은 환불계좌에 등록된 계좌로 송금 처리됩니다.<br>
            결제 시 사용한 쿠폰 및 마일리지는 내부정책에 따라 취소신청 완료 후 환불됩니다.
        </div>
    </section>

    <section>
        <h1>변동내역</h1>
        <div class="change-list">
            <div class="first">
                <dl>
                    <dt>교환신청 상품 총 금액</dt>
                    <dd><em>18,000</em>원</dd>
                </dl>
                <dl>
                    <dt>교환 배송비</dt>
                    <dd><em>2,500</em>원</dd>
                </dl>
            </div>
            <div class="last">
                <dl>
                    <dt>추가 결제 예정 금액</dt>
                    <dd><em>2,500</em>원</dd>
                </dl>
            </div>
        </div>
        <div class="desc">
            교환 배송비는 판매자가 교환상품 최종 승인 후 변경될 수 있습니다.
        </div>
    </section>
    <!--취소교환반품 신청내역조회일 때 E -->

	<!--비회원일 때-->
	<section>
		<h1 class="clearfix">
			배송지 정보
			<button class="btn-xs btn-dark-line float-r address-link">배송지변경</button>
		</h1>

		<table class="join-table type02 shipping-info-table non-member">
			<colgroup>
				<col width="180px">
				<col width="*">
			</colgroup>
			<tr>
				<th>받는 분</th>
				<td>홍길동</td>
			</tr>
			<tr>
				<th>주소</th>
				<td>
					<p>06744</p>
					<p>서울특별시 서초구 바우뫼로37길 56(양재동) 2층 포비즈코리아</p>
				</td>
			</tr>
			<tr>
				<th>휴대폰번호</th>
				<td>010-2345-5678</td>
			</tr>
			<tr>
				<th>전화번호</th>
				<td>02-2345-5678</td>
			</tr>
			<tr>
				<th>배송요청사항</th>
				<td class="request">
					<div class="section"><!--복수 배송요청사항 section 이 반복 -->
						<p>부재 시 경비실에 맡겨주세요.</p>
						<div class="mat10">
							<input type="text" id="input_request" onkeyup="onkeylengthMax(this, 200, 'msg_byte');" maxlength="30">
							<button class="btn-default btn-dark">요청사항 변경</button>
						</div>
						<div class="mat10">
							<div class="counting">
								<em class="txt-error" style="display:none;">요청사항을 입력하세요.</em>
								<span><em id="msg_byte">0</em>/30 자</span>
							</div>
						</div>
					</div>
				</td>
			</tr>
		</table>

	</section>
	<!--///////-->

	<div class="wrap-btn-area">
		<button class="btn-lg btn-dark" onclick="parent.history.back(-1);">이전</button>
	</div>
</div>