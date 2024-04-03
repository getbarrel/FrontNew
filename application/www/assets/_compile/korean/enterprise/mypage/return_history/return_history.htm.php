<?php /* Template_ 2.2.8 2024/02/22 16:04:22 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/return_history/return_history.htm 000005413 */ ?>
<link rel="stylesheet" href="/assets/templet/enterprise/js/themes/base/ui.all.css">
<!-- 컨텐츠 S -->
<section class="fb__return-history">
	<div class="fb__mypage-title">
		<div class="title-md">반품 / 취소 내역</div>
	</div>
<?php if(!$TPL_VAR["nonMemberOid"]){?>
	<section class="fb__mypage__search">
		<form id="devReturnHistoryForm">
			<input type="hidden" name="page" value="1" id="devPage" />
			<input type="hidden" name="max" value="10"/>
			<input type="hidden" name="status" value="" id="status"/>
			<div class="search">
				<div class="fb-tab__nav">
					<ul>
						<li devFilterState="" class="active">
							<a href="javscript:void(0);">전체</a>
						</li>
						<li devFilterState="RA">
							<a href="javscript:void(0);">반품</a>
						</li>
						<li devFilterState="CA">
							<a href="javscript:void(0);">취소</a>
						</li>
					</ul>
				</div>
				<div class="search__row">
					<div class="search__col">
						<div class="fb__form-item">
							<label for="devSdate" class="hide">조회기간</label>
							<input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick fb__form-input" title="조회시작기간" />
							<span>-</span>
							<input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick fb__form-input" title="조회종료기간" />
							<button type="button" id="devSearchBtn" title="검색" class="btn-lg btn-dark-line">조회</button>
						</div>
					</div>
					<div class="search__col">
						<div class="search__day">
							<div class="day-radio">
                                <a href="#"  class="day-radio__btn devDateBtn day-radio--active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="devDateDefault">최근 <em>1</em>개월</a>
                                <a href="#"  class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["threeMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="">최근 <em>3</em>개월</a>
                                <a href="#"  class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>6</em>개월</a>
                                <a href="#"  class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>12</em>개월</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
<?php }else{?>
	<form id="devReturnHistoryForm">
		<input type="hidden" name="page" value="1" id="devPage" />
		<input type="hidden" name="max" value="1"/>
	</form>
<?php }?>
	<!-- 주문 내역 - 리스트 S -->
	<section class="fb__mypage__section">
		<div class="fb__mypage-order" id="devReturnHistoryContent">
			<ul class="product-item__wrap" id="devReturnHistoryLoading">
				<div class=" empty-content order-list">
					<div class="wrap-loading">
						<div class="loading"></div>
					</div>
				</div>
			</ul>
			<ul class="product-item__wrap" id="devReturnHistoryEmpty">
				<li class="product-item__list no-data">
					<p class="empty-content">기간내 반품/취소 내역이 없습니다.</p>
				</li>
			</ul>
			<ul class="product-item__wrap devForbizTpl" id="devReturnHistoryList">
				<li class="product-item__list">
					<dl class="product-item__top">
						<dt>
							<div class="order-day">{[claim_date]}</div>
							<span class="order-number">{[oid]}</span>
						</dt>
						<dd>
							<a href="/mypage/orderClaimDetail/{[oid]}/{[claim_group]}" class="btn-link">상세보기</a>
						</dd>
					</dl>
					<dl id="devOrderDetailContent" style="padding-top:30px">
					<!-- 상품 S -->
					<dl class="product-item" id="devReturnProduct">
						<dt class="product-item__thumbnail-box">
							<div class="product-item__thumb">
								<a href="">
                                    <img src="{[pimg]}" alt="{[#if brand_name]} [{[brand_name]}] {[/if]} {[pname]}">
								</a>
							</div>
						</dt>
						<dd class="product-item__infobox">
							<div class="product-item__info">
								<div class="product-item__title c-pointer">
									<a href="#;"> {[#if brand_name]} [{[brand_name]}] {[/if]} {[pname]}</a>
								</div>
								<div class="product-item__option">
									<a href="#;">
										<span>{[option_text]}</span>
										{[#if add_info]}
										<span>색상 : {[add_info]}</span>
										{[/if]}
										<span>{[pcnt]}개</span>
									</a>
								</div>
								<div class="product-item__price-group">
									<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[listprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
								</div>
							</div>
							<div class="product-item__btn-area">
								<div class="order-status">
                                    <p>{[status_text]}</p>
                                    {[#if refund_status_text]}<p>{[refund_status_text]}</p>{[/if]}								
								</div>
							</div>
						</dd>
					</dl>
					<!-- 상품 E -->
					</dl>
				</li>
			</ul>
		</div>
	</section>
	<!-- 주문 내역 - 리스트 E -->
</section>
<!-- 컨텐츠 E -->