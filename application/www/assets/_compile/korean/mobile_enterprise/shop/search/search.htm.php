<?php /* Template_ 2.2.8 2024/03/20 11:26:44 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/search/search.htm 000019719 */ 
$TPL_brandList_1=empty($TPL_VAR["brandList"])||!is_array($TPL_VAR["brandList"])?0:count($TPL_VAR["brandList"]);
$TPL_filter_1=empty($TPL_VAR["filter"])||!is_array($TPL_VAR["filter"])?0:count($TPL_VAR["filter"]);?>
<form id="devListForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="20" />
    <input type="hidden" name="orderBy" value="regdateDesc" id="devSort" />
    <input type="hidden" name="filterText" value="<?php echo $TPL_VAR["searchText"]?>" />
    <input type="hidden" name="product_filter" value="" id="devProductFilter" />
    <input type="hidden" name="sprice" value="" id="devSprice" />
    <input type="hidden" name="eprice" value="" id="devEprice" />
    <input type="hidden" name="price_type" value="" id="devPriceType" />
    <input type="hidden" name="filterSearchPage" value="T" />
</form>

<!-- 2019.07.05 검색결과 -->
<section class="br__search__reslut">
    <div class="br__goods-list__filter" style="display:none;">
        <div class="filters">
            <button type="button" class="filters__btn" id="devFilterView">필터</button>
            <div class="filters__grid">
                <input type="radio" name="goodsGrid" id="gridNormal" value="normal" checked><label for="gridLarge" class="title-box__grid__icon title-box__grid__icon--normal">일반보기</label>
                <input type="radio" name="goodsGrid" id="gridLarge" value="large"><label for="gridNormal" class="title-box__grid__icon title-box__grid__icon--large">크게보기</label>
            </div>
            <div class="br__select-box">
                <div class="select-box">
                    <button class="select-box__title"><span>최신상품순</span></button>
                    <div class="select-box__layer">
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="regdateDesc" checked>
                            <span>최신상품순</span>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="orderCnt">
                            <span>인기상품순</span>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="lowPrice">
                            <span>낮은가격순</span>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="highPrice">
                            <span>높은가격순</span>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="afterCnt">
                            <span>상품후기순</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 검색 필터 -->
    <article class="result__sorting">
        <span class="reslut__count"><?php if($TPL_VAR["langType"]=='korean'){?>총 상품 <?php }?><em id="devSearchTotal"></em> 개</span>
    </article>
    <!-- EOD : 검색 필터 -->

    <!-- 검색 결과 상품리스트 -->
    <article class="main-cate__goods-list br__goods-list__wrap br__goods-list__wrap--normal">
        <div class="goods-list">
            <ul class="goods-list__list" id="devListContents">
                <li id="devListLoading">loading...</li>

                <article class="result__data" id="devListEmpty">
                    <em>검색결과가 없습니다.</em>
                </article>

                <li class="goods-list__box" id="devListDetail">
                    <a href="/shop/goodsView/{[id]}" class="goods-list__link">
                        <figure class="goods-list__thumb">
                            {[#if timeSaleIconViewM]}
                            <img src="{[timeSaleIconM]}" class="goods-list__time-deal" >
                            {[/if]}
                            <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="{[image_src]}" alt="{[pname]}">
                        </figure>
                        <div class="goods-list__info">
                            {[#if icons]}
                            <div class="goods-list__badge">
                                {[#each icons_path]}
                                <span>{[{this}]}</span>
                                {[/each]}
                                <!--<span class="goods-list__badge__icon goods-list__badge__icon--water">WATER</span>
                                <span class="goods-list__badge__icon goods-list__badge__icon--fitness">FITNESS</span>-->
                            </div>
                            {[/if]}
                            {[#if prefaceName]}<p class="br__goods__pre" style="color:{[prefaceColor]};{[b_preface]}{[i_preface]}{[u_preface]}">{[prefaceName]}</p>{[/if]}
                            <p class="goods-list__title">{[pname]}</p>
                            <span class="goods-list__color">{[add_info]}</span>
                            <div class="goods-list__price">
								{[#if is_soldout]}
									<div class="goods-list__price__state">[품절]</div>
								{[else]}
									{[#if isPercent]}
									<div class="goods-list__price__percent"><span>{[discount_rate]}</span>%</div>
									{[/if]}
									<div class="goods-list__price__discount"><?php echo $TPL_VAR["fbUnit"]["f"]?><span>{[dcprice]}</span><?php if($TPL_VAR["langType"]!='korean'){?><?php echo $TPL_VAR["fbUnit"]["b"]?><?php }?></div>
									{[#if isDiscount]}
									<div class="goods-list__price__cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><del>{[listprice]}</del><?php if($TPL_VAR["langType"]!='korean'){?><?php echo $TPL_VAR["fbUnit"]["b"]?><?php }?></div>
									{[/if]}
								{[/if]}
                            </div>
                        </div>
                    </a>
                    <label class="goods-list__wish {[#if alreadyWish]}on{[/if]}" devwishbtn="{[id]}">
                        {[#if alreadyWish]}
                        <input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_{[id]}" onclick="productWish('{[id]}')" checked>
                        {[else]}
                        <input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_{[id]}" onclick="productWish('{[id]}')">
                        {[/if]}
                    </label>
                </li>
            </ul>
            <div class="br__more devPageBtnCls" id="devPageWrap"></div>
        </div>
    </article>
    <!-- EOD : 검색 결과 상품리스트 -->

    <!-- 검색 결과가 없을 경우 -->
    <!--<article class="result__data">-->
        <!--<em>'<?php echo $TPL_VAR["searchText"]?>'에 대한 검색 결과가 없습니다.</em>-->
        <!--<ul>-->
            <!--<li>- 검색어가 올바르게 입력되었는지 확인해 주세요.</li>-->
            <!--<li>- 일반적인 검색어로 다시 검색해주세요.</li>-->
            <!--<li>- '검색어의 띄어쓰기를 다르게 해보세요.</li>-->
            <!--<li>- '일시적으로 상품이 품절되었을 수 있습니다.</li>-->
        <!--</ul>-->
    <!--</article>-->

    <!--<article class="result__data">-->
        <!--<em>선택하신 조건에 대한 검색 결과가 없습니다.</em>-->
        <!--<ul>-->
            <!--<li>다른 옵션을 선택하여 검색해 보세요.</li>-->
        <!--</ul>-->
    <!--</article>-->
    <!-- EOD : 검색 결과가 없을 경우 -->
</section>
<!-- EOD : 2019.07.05 검색결과 -->

<div class="layer-search-detail hidden">
    <div class="dim"></div>
    <div class="wrap-search-detail">
        <div class="title">
            <div>
                <p>상세검색 설정</p>
                <span>총 <em>0</em>개</span>
            </div>
            <div class="button-area">
                <button class="btn-refresh">초기화</button>
                <button class="btn-close" onclick="searchDetailClose();">닫기</button></div>
            </div>

        <dl class="dl-category">
            <dd class=""><span>카테고리 <em class="txt-sel">백팩</em></span></dd>
            <dt>
<?php if(false){?>
                    <!--작업해두신 카테고리 소스는 데이터가 나오지 않아 어디를 갖다넣어야할지 몰라 우선 하드코딩하였습니다.-->
<?php }?>
                <ul class="category-list" id="category-detail-area">
                    <li class="list-1dep all on">
                        <p>전체</p>
                    </li>
                    <li class="list-1dep">
                        <p>미용소품</p>
                        <ul class="cate-2depth" >
                            <li>면봉/화장솜</li>
                            <li>페이스소품</li>
                        </ul>
                    </li>
                    <li class="list-1dep">
                        <p>스킨케어</p>
                        <ul class="cate-2depth">
                            <li>스킨케어세트</li>
                            <li>스킨패드</li>
                            <li>스킨/토너</li>
                        </ul>
                    </li>
                </ul>
            </dt>
        </dl>
        <dl class="dl-brand">
            <dd>브랜드 <em class="txt-sel">3개</em></dd>
            <dt>
                <ul id="brand-list-area">
<?php if($TPL_brandList_1){foreach($TPL_VAR["brandList"] as $TPL_V1){?>
                    <li data-ix="<?php echo $TPL_V1["b_ix"]?>" class="devBrandSelect<?php echo $TPL_V1["b_ix"]?>"><div ><?php echo $TPL_V1["brand_name"]?></div></li>
<?php }}?>
                </ul>
            </dt>
        </dl>
        <div class="dl-price">

            <div class="section">
                <p>배송</p>
                <p class="btn-dark-line btn-default btn-free devFreeDelivery">무료배송</p>
            </div>

            <div class="section">
                <p>결과 내 검색</p>

                <div class="input-form">
                    <input type="text"  class="sub-searchWord devInsideText devAutoCompleteDetail">
                    <button  id="devGoInsideSearch" class="btn-inside-search">search</button>
                </div>
            </div>
        </div>
    </div>
</div>
<section id="filter" class="br__filter">
	<div class="br__filter-nav">
		<ul class="filter-nav">
			<li>
				<button class="btn-filter filters__btn" id="devFilterView">상세필터</button>
			</li>
			<li class="select-box__wrap">
				<div class="br__select-box">
					<div class="select-box">
						<button class="select-box__title select-box__name"><span>최신상품순</span></button>
						<div class="select-box__layer">
							<label class="select-box__layer__label">
								<input type="radio" class="devSortTab" name="filterRadio" value="regdateDesc" checked="">
								<span>최신상품순</span>
							</label>
							<label class="select-box__layer__label">
								<input type="radio" class="devSortTab" name="filterRadio" value="orderCnt">
								<span>인기상품순</span>
							</label>
							<label class="select-box__layer__label">
								<input type="radio" class="devSortTab" name="filterRadio" value="lowPrice">
								<span style="">낮은가격순</span>
							</label>
							<label class="select-box__layer__label">
								<input type="radio" class="devSortTab" name="filterRadio" value="highPrice">
								<span style="">높은가격순</span>
							</label>
							<label class="select-box__layer__label">
								<input type="radio" class="devSortTab" name="filterRadio" value="afterCnt">
								<span>상품후기순</span>
							</label>
							<label class="select-box__layer__label">
								<input type="radio" class="devSortTab" name="filterRadio" value="viewOrder">
								<span>배럴추천순</span>
							</label>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
	<section id="search-filter" class="br__filter-layer">
		<div class="filter-layer">
			<div class="filter-layer__title">
				<h3>필터</h3>
			</div>
			<div class="filter-layer__content">
<?php if($TPL_filter_1){foreach($TPL_VAR["filter"] as $TPL_V1){?>
				<div class="filter-layer__content__acco <?php if($TPL_V1["filter_type"]=='COLOR'){?> filter-layer__content__acco--color <?php }else{?> filter-layer__content__acco--size <?php }?>">
					<div class="accordion">
						<div type="button" class="accordion__opner">
							<span class="accordion__opner__title"><?php echo $TPL_V1["filter_type_text"]?></span>
							<span class="accordion__opner__value"></span>
						</div>
						<div class="accordion__content">
							<ul class="accordion__content__list">
<?php if(is_array($TPL_R2=$TPL_V1["item"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<li>
									<label class="accordion__content__label">
<?php if($TPL_V1["filter_type"]=='COLOR'){?>
											<input type="checkbox" class="devFilterItem devFilterItemColor" name="<?php echo $TPL_V1["filter_type"]?>" value="<?php echo $TPL_V2["filter_idx"]?>">
<?php }else{?>
											<input type="checkbox" class="devFilterItem " name="<?php echo $TPL_V1["filter_type"]?>" value="<?php echo $TPL_V2["filter_idx"]?>">
<?php }?>
<?php if($TPL_V2["filter_img_mobile"]){?>
										<figure class="thumb">
											<img src="<?php echo $TPL_V2["filter_img_mobile"]?>" alt="">
										</figure>
<?php }?>
										<span><?php echo $TPL_V2["filter_name"]?></span>
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
						<button class="accordion__opner">
							<span class="accordion__opner__title">가격</span>
							<span class="accordion__opner__value">4,500원 이상 114,500원 이하</span>
						</button>
						<div class="accordion__content">
							<ul class="accordion__content__list">
								<li class="">
									<label class="accordion__content__label">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" class="devPriceType" value="1" data-sprice="0" data-eprice="10000">
<?php }else{?>
										<input type="radio" name="search_price" class="devPriceType" value="1" data-sprice="0" data-eprice="10">
<?php }?>
										<span class="title">
											1만원 미만
										</span>
									</label>
								</li>
								<li class="">
									<label class="accordion__content__label">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" class="devPriceType" value="2"  data-sprice="10000" data-eprice="30000">
<?php }else{?>
										<input type="radio" name="search_price" class="devPriceType" value="2"  data-sprice="10" data-eprice="30">
<?php }?>
										<span class="title">
											1만원 ~ 3만원 미만
										</span>
									</label>
								</li>
								<li class="">
									<label class="accordion__content__label">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" class="devPriceType" value="3"  data-sprice="30000" data-eprice="50000">
<?php }else{?>
										<input type="radio" name="search_price" class="devPriceType" value="3"  data-sprice="50" data-eprice="100">
<?php }?>
										<span class="title">
											3만원 ~ 5만원 미만
										</span>
									</label>
								</li>
								<li class="">
									<label class="accordion__content__label">	
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" class="devPriceType" value="4"  data-sprice="50000" data-eprice="100000">
<?php }else{?>
										<input type="radio" name="search_price" class="devPriceType" value="4"  data-sprice="50" data-eprice="100">
<?php }?>
										<span class="title">
											5만원 ~ 10만원 미만
										</span>
									</label>
								</li>
								<li class="">
									<label class="accordion__content__label">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" class="devPriceType" value="5"  data-sprice="100000" data-eprice="150000">
<?php }else{?>
										<input type="radio" name="search_price" class="devPriceType" value="5"  data-sprice="100" data-eprice="150">
<?php }?>
										<span class="title">
											10만원 ~ 15만원 미만
										</span>
									</label>
								</li>

								<li class="">
									<label class="accordion__content__label">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" class="devPriceType" value="6"  data-sprice="150000" data-eprice="200000">
<?php }else{?>
										<input type="radio" name="search_price" class="devPriceType" value="6"  data-sprice="150" data-eprice="200">
<?php }?>
										<span class="title">
											15만원 ~ 20만원 미만
										</span>
									</label>
								</li>

								<li class="">
									<label class="accordion__content__label">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" class="devPriceType" value="7"  data-sprice="200000" data-eprice="250000">
<?php }else{?>
										<input type="radio" name="search_price" class="devPriceType" value="7"  data-sprice="200" data-eprice="250">
<?php }?>
										<span class="title">
											20만원 ~ 25만원 미만
										</span>
									</label>
								</li>

								<li class="">
									<label class="accordion__content__label">
<?php if($TPL_VAR["langType"]=='korean'){?>
										<input type="radio" name="search_price" class="devPriceType" value="8"  data-sprice="250000" data-eprice="999999">
<?php }else{?>
										<input type="radio" name="search_price" class="devPriceType" value="8"  data-sprice="250" data-eprice="999">
<?php }?>
										<span class="title">
											25만원 이상
										</span>
									</label>
								</li>
								<li style="display:none;">
									<div class="accordion__content__input">
										<label><input type="radio" name="search_price" class="devPriceType" value="5"  data-sprice="" data-eprice=""></label>
										<div class="input-box">
											<div class="input-box__wrap">
												<span class="unit"><?php echo $TPL_VAR["fbUnit"]["f"]?></span><input type="text" value="" id="devSpriceInput" ><span class="unit"><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
											</div>
											<span class="input-box__tilde">~</span>
											<div class="input-box__wrap">
												<span class="unit"><?php echo $TPL_VAR["fbUnit"]["f"]?></span><input type="text" value="" id="devEpriceInput" ><span class="unit"><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>

			</div>
			<div class="filter-layer__btn">
				<button type="button" class="filter-layer__btn__reset">초기화</button>
				<button type="button" class="filter-layer__btn__apply" id="devFilterSubmit">적용하기</button>
			</div>
			<button class="filter-layer__close">닫기</button>
		</div>
	</section>
</section>