<?php /* Template_ 2.2.8 2024/02/19 17:41:15 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/mileage/mileage.htm 000005375 */ ?>
<!-- 컨텐츠 S -->
<script>
	//레이아웃 인클로드 js (퍼블리싱)
	$(document).ready(function () {
		$(".search__date-input").datepicker({
			dateFormat: "yy.mm.dd",
			beforeShow: function (input) {
				var i_offset = $(input).offset();
				var i_w = $(input).outerWidth();
				setTimeout(function () {
					$("#ui-datepicker-div").css({ top: i_offset.top + 40, bottom: "", left: i_offset.left });
					$("#ui-datepicker-div").css({ width: i_w });
				});
			},
		});
	});
</script>
<section class="br__mileage">
	<div class="page-title my-title">
		<div class="title-sm">현재 사용 가능 적립금</div>
	</div>
	<div class="mileage">
		<section class="mileage-info">
			<div class="available-mileage"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo $TPL_VAR["myMileAmount"]?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
			<div class="mileage-info__group">
				<div class="mileage-info__item">
					<span class="tit">적립 예정</span>
					<div class="accumulate-mileage"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo $TPL_VAR["myMileageWaitAmount"]?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
				</div>
				<div class="mileage-info__item">
					<a href="#;" class="mileage-info__link">
						<span class="tit">소멸 예정</span>
						<div class="expired-mileage"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo $TPL_VAR["ext_mileage_amount"]?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
					</a>
				</div>
			</div>
		</section>
		<form id="devMileageForm">
		<input type="hidden" name="page" value="1" id="devPage"/>
		<input type="hidden" name="max" value="10" id="devMax"/>
		<input type="hidden" name="state" value="" id="state"/>
		<input type="hidden" name="sDateDef" id="sDateDef" value="<?php echo $TPL_VAR["sDate"]?>" />
		<input type="hidden" name="eDateDef" id="eDateDef" value="<?php echo $TPL_VAR["eDate"]?>" />
		<section class="br__mypage-search">
			<div class="search">
				<div class="br-tab__nav">
					<ul>
						<li devFilterState="" class="active">
							<a href="#;">전체</a>
						</li>
						<li devFilterState="1" >
							<a href="#;">적립</a>
						</li>
						<li devFilterState="2" >
							<a href="#;">사용</a>
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
					<button type="button" id="devBtnSearch" title="조회" class="btn-lg btn-gray-line">조회</button>
				</div>
			</div>
		</section>
		</form>
		<section class="mileage-detail">
			<div class="board-inquiry__wrap">
				<ul class="board-inquiry__list" id="devMileageContent">
					<li class="board-inquiry__item devForbizTpl" id="devMileageLoading">
						<p>loading...</p>
					</li>

					<li class="board-inquiry__item devForbizTpl" id="devMileageListEmpty">
						<p>조회 내역이 없습니다.</p>
					</li>

					<li class="board-inquiry__item devForbizTpl" id="devMileageList">
						<dl class="board-inquiry__group">
							<dt>
								<div class="day">{[date]}</div>
								<div class="category">주문번호</div>
							</dt>
							<dd>
								<div class="subject">{[message]}</div>
								<div class="order-number">{[oid]}</div>
							</dd>
						</dl>
						<div class="board-inquiry__side">
							<span class="{[state_desc2]}">{[mileage_desc]}</span>
						</div>
					</li>
					<!-- <li class="board-inquiry__item">
						<dl class="board-inquiry__group">
							<dt>
								<div class="day">2024-12-31</div>
								<div class="category">주문번호</div>
							</dt>
							<dd>
								<div class="subject">상품 구매 시 사용</div>
								<div class="order-number">202304251538-0000227</div>
							</dd>
						</dl>
						<div class="board-inquiry__side">
							<span class="minus">- <em>405,550</em>원</span>
						</div>
					</li> -->
				</ul>
			</div>
		</section>
	</div>
</section>
<!-- 컨텐츠 E -->