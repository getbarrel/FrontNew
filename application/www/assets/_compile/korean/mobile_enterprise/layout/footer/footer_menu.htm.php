<?php /* Template_ 2.2.8 2024/03/08 09:52:06 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/layout/footer/footer_menu.htm 000007433 */ 
$TPL_filter_1=empty($TPL_VAR["filter"])||!is_array($TPL_VAR["filter"])?0:count($TPL_VAR["filter"]);?>
<?php if($TPL_VAR["chkMenu"]=="goodsLists"){?>
<!-- 상품 리스트 / 검색 페이지 에서만 노출 S -->
<div class="br__filter-nav">
	<ul class="filter-nav">
		<li>
			<button class="btn-filter" onclick="DownLayerJS('search-filter');">상세필터</button>
		</li>
		<li class="select-box__wrap">
			<div class="br__select-box">
				<div class="select-box">
					<button class="select-box__title select-box__name devSortPopTab"><span>최신상품순</span></button>
					<div class="select-box__layer">
						<label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="regdateDesc">
                            <span>최신상품순</span>
						</label>
						<label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="orderCnt">
                            <span>인기상품순</span>
						</label>
						<label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="lowPrice">
                            <span style="font-size:1.05rem">낮은가격순</span>
						</label>
						<label class="select-box__layer__label">
							<input type="radio" class="devSortTab" name="filterRadio" value="highPrice" />
							<span style="font-size: 1.05rem">높은가격순</span>
						</label>
						<label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="afterCnt">
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <span>상품후기순</span>
<?php }else{?>
                            <span>Most reviews</span>
<?php }?>
						</label>
						<label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="viewOrder" checked>
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <span>배럴추천순</span>
<?php }else{?>
                            <span>Recommended</span>
<?php }?>
						</label>
					</div>
				</div>
			</div>
		</li>
	</ul>
</div>


<!-- 검색 상세 필터 S -->
<section id="search-filter" class="br__filter-layer">
	<div class="filter-layer">
		<div class="filter-layer__title">
			<div class="title-md">필터</div>
			<button type="button" class="btn-close" onclick="DownLayerJS('search-filter');">닫기</button>
		</div>
		<div class="filter-layer__content">
<?php if($TPL_filter_1){foreach($TPL_VAR["filter"] as $TPL_V1){?>
			<div class="filter-layer__content__acco <?php if($TPL_V1["filter_type"]=='COLOR'){?> filter-layer__content__acco--color <?php }else{?> filter-layer__content__acco--benefits2 <?php }?>">
				<div class="accordion">
					<div type="button" class="accordion__opner">
						<div class="accordion__opner__title"><?php echo $TPL_V1["filter_type_text"]?></div>
						<!-- 선택한 옵션 노출 영역 S -->
						<div class="accordion__opner__value-group">
							<button type="button" class="btn-del">
								<span class="accordion__opner__value"></span>
							</button>
						</div>
					</div>
					<div class="accordion__content">
						<ul class="accordion__content__list">
<?php if(is_array($TPL_R2=$TPL_V1["item"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
							<li>
								<label class="accordion__content__label">
									<input type="checkbox" class="devFilterItem" name="<?php echo $TPL_V1["filter_type"]?>" value="<?php echo $TPL_V2["filter_idx"]?>" />
<?php if($TPL_V2["filter_img_mobile"]){?>
									<figure class="thumb">
										<img src="<?php echo $TPL_V2["filter_img_mobile"]?>" alt="">
									</figure>
<?php }?>
									<span><?php echo trans($TPL_V2["filter_name"])?></span>
								</label>

							</li>
<?php }}?>
						</ul>
					</div>
				</div>
			</div>
<?php }}?>
			<div class="filter-layer__content__acco filter-layer__content__acco--price">
				<div class="accordion">
					<div class="accordion__opner">
						<div class="accordion__opner__title">가격</div>
						<div class="accordion__opner__value-group">
							<button type="button" class="btn-del">
								<span class="accordion__opner__value">선택된 옵션명</span>
							</button>
						</div>
					</div>
					<div class="accordion__content">
						<ul class="accordion__content__list">
							<li>
								<label class="accordion__content__label">
									<input type="radio" name="search_price" class="devPriceType" value="1" data-sprice="0" data-eprice="9999" />
									<span class="title">1만원 미만</span>
								</label>
							</li>
							<li>
								<label class="accordion__content__label">
									<input type="radio" name="search_price" class="devPriceType" value="2" data-sprice="10000" data-eprice="29999" />
									<span class="title">1만원 ~ 3만원 미만</span>
								</label>
							</li>
							<li>
								<label class="accordion__content__label">
									<input type="radio" name="search_price" class="devPriceType" value="3" data-sprice="30000" data-eprice="49999" />
									<span class="title">3만원 ~ 5만원 미만</span>
								</label>
							</li>
							<li>
								<label class="accordion__content__label">
									<input type="radio" name="search_price" class="devPriceType" value="4" data-sprice="50000" data-eprice="99999" />
									<span class="title">5만원 ~ 10만원 미만</span>
								</label>
							</li>
							<li>
								<label class="accordion__content__label">
									<input type="radio" name="search_price" class="devPriceType" value="5" data-sprice="100000" data-eprice="149999" />
									<span class="title">10만원 ~ 15만원 미만</span>
								</label>
							</li>
							<li>
								<label class="accordion__content__label">
									<input type="radio" name="search_price" class="devPriceType" value="6" data-sprice="150000" data-eprice="199999" />
									<span class="title">15만원 ~ 20만원 미만</span>
								</label>
							</li>
							<li>
								<label class="accordion__content__label">
									<input type="radio" name="search_price" class="devPriceType" value="7" data-sprice="200000" data-eprice="249999" />
									<span class="title">20만원 ~ 25만원 미만</span>
								</label>
							</li>
							<li>
								<label class="accordion__content__label">
									<input type="radio" name="search_price" class="devPriceType" value="8" data-sprice="250000" data-eprice="9999999999999" />
									<span class="title">20만원 이상</span>
								</label>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="filter-layer__btn">
		<button type="button" class="btn-lg filter-layer__btn__reset">초기화</button>
		<button type="button" class="btn-lg filter-layer__btn__apply" id="devFilterSubmit">적용하기</button>
	</div>
</section>
<!-- 검색 상세 필터 E -->

<!-- 상품 리스트 / 검색 페이지 에서만 노출 E -->
<?php }?>