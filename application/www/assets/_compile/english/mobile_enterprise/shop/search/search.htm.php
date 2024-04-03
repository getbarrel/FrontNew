<?php /* Template_ 2.2.8 2020/08/31 15:57:05 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/search/search.htm 000021604 */ 
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
    <div class="br__goods-list__filter">
        <div class="filters">
            <button type="button" class="filters__btn" id="devFilterView">Filter</button>
            <div class="filters__grid">
                <input type="radio" name="goodsGrid" id="gridNormal" value="normal" checked><label for="gridLarge" class="title-box__grid__icon title-box__grid__icon--normal">일반보기</label>
                <input type="radio" name="goodsGrid" id="gridLarge" value="large"><label for="gridNormal" class="title-box__grid__icon title-box__grid__icon--large">크게보기</label>
            </div>
            <div class="br__select-box">
                <div class="select-box">
                    <button class="select-box__title"><span>New Arrivals</span></button>
                    <div class="select-box__layer">
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="regdateDesc" checked>
                            <span>New Arrivals</span>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="orderCnt">
                            <span>Best Sellers</span>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="lowPrice">
                            <span>Price: Low to High</span>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="highPrice">
                            <span>Price: High to Low</span>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="afterCnt">
                            <span>Avg. Customer Review</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 검색 필터 -->
    <article class="result__sorting">
        <span class="reslut__count"><?php if($TPL_VAR["langType"]=='korean'){?>ITEM <?php }?><em id="devSearchTotal"></em> ltem(s)</span>
    </article>
    <!-- EOD : 검색 필터 -->

    <!-- 검색 결과 상품리스트 -->
    <article class="main-cate__goods-list br__goods-list__wrap br__goods-list__wrap--normal">
        <div class="goods-list">
            <ul class="goods-list__list" id="devListContents">
                <li id="devListLoading">loading...</li>

                <article class="result__data" id="devListEmpty">
                    <em>There are no search results.</em>
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
                            <p class="br__goods__pre">{[preface]}</p>
                            <p class="goods-list__title">{[pname]}</p>
                            <span class="goods-list__color">{[add_info]}</span>
                            <div class="goods-list__price">
                                {[#if isDiscount]}
                                <span class="goods-list__price__cost"><?php echo $TPL_VAR["fbUnit"]["f"]?>{[listprice]}<?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                {[/if]}
                                <span class="goods-list__price__discount"><?php echo $TPL_VAR["fbUnit"]["f"]?>{[dcprice]}<?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                {[#if is_soldout]}
                                <span class="goods-list__price__state">Out of stock</span>
                                {[else]}
                                    {[#if isPercent]}
                                        <span class="goods-list__price__percent">{[discount_rate]}%</span>
                                    {[/if]}
                                {[/if]}
                            </div>
                        </div>
                    </a>
                    <label class="goods-list__wish {[#if alreadyWish]}on{[/if]}" devwishbtn="{[id]}">
                        {[#if alreadyWish]}
                        <input type="checkbox" class="goods-list__wish__btn" checked>
                        {[else]}
                        <input type="checkbox" class="goods-list__wish__btn">
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
        <!--<em>'<?php echo $TPL_VAR["searchText"]?>'No results were found.</em>-->
        <!--<ul>-->
            <!--<li>- Please make sure the search term is typed correctly.</li>-->
            <!--<li>- Please try your search again.</li>-->
            <!--<li>- 'Try different spacing for your search terms.</li>-->
            <!--<li>- 'This item may be temporarily out of stock.</li>-->
        <!--</ul>-->
    <!--</article>-->

    <!--<article class="result__data">-->
        <!--<em>No results found for the selected option.</em>-->
        <!--<ul>-->
            <!--<li>Choose another option to search.</li>-->
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
<section class="br__filter-layer">
    <div class="filter-layer">
        <div class="filter-layer__title">
            <h3>Filter</h3>
        </div>
        <div class="filter-layer__content">
<?php if($TPL_filter_1){foreach($TPL_VAR["filter"] as $TPL_V1){?>
            <div class="filter-layer__content__acco <?php if($TPL_V1["filter_type"]=='COLOR'){?> filter-layer__content__acco--color <?php }else{?> filter-layer__content__acco--size <?php }?>">
                <div class="accordion">
                    <button class="accordion__opner">
                        <span class="accordion__opner__title"><?php echo $TPL_V1["filter_type_text"]?></span>
                        <span class="accordion__opner__value"></span>
                    </button>
                    <div class="accordion__content">
                        <ul>
                            <li class="accordion__content__list">
                                <div class="accordion__content__label">
<?php if(is_array($TPL_R2=$TPL_V1["item"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                                    <label>
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
<?php }}?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
<?php }}?>

            <!--<div class="filter-layer__content__acco filter-layer__content__acco&#45;&#45;color">-->
            <!--<div class="accordion">-->
            <!--<button class="accordion__opner">-->
            <!--<span class="accordion__opner__title">Color</span>-->
            <!--</button>-->
            <!--<div class="accordion__content">-->
            <!--<ul>-->
            <!--<li class="accordion__content__list">-->
            <!--<div class="accordion__content__label">-->
            <!--<input type="checkbox" name="color" id="filterColor1">-->
            <!--<label for="filterColor1">-->
            <!--<figure class="thumb" style="background:#000;">-->
            <!--&lt;!&ndash;<img src="" alt="">&ndash;&gt;-->
            <!--</figure>-->
            <!--<span class="title">Black</span>-->
            <!--<span class="count">(6)</span>-->
            <!--</label>-->
            <!--</div>-->
            <!--</li>-->
            <!--<li class="accordion__content__list">-->
            <!--<div class="accordion__content__label">-->
            <!--<input type="checkbox" name="color" id="filterColor2">-->
            <!--<label for="filterColor2">-->
            <!--<figure class="thumb" style="background:#0b559b">-->
            <!--&lt;!&ndash;<img src="" alt="">&ndash;&gt;-->
            <!--</figure>-->
            <!--<span class="title">Blue</span>-->
            <!--<span class="count">(6)</span>-->
            <!--</label>-->
            <!--</div>-->
            <!--</li>-->
            <!--<li class="accordion__content__list">-->
            <!--<div class="accordion__content__label">-->
            <!--<input type="checkbox" name="color"  id="filterColor3">-->
            <!--<label for="filterColor3">-->
            <!--<figure class="thumb" style="background:#fff;">-->
            <!--&lt;!&ndash;<img src="" alt="">&ndash;&gt;-->
            <!--</figure>-->
            <!--<span class="title">White</span>-->
            <!--<span class="count">(6)</span>-->
            <!--</label>-->
            <!--</div>-->
            <!--</li>-->
            <!--<li class="accordion__content__list">-->
            <!--<div class="accordion__content__label">-->
            <!--<input type="checkbox" name="color" id="filterColor4">-->
            <!--<label for="filterColor4">-->
            <!--<figure class="thumb" style="background:#990000;">-->
            <!--&lt;!&ndash;<img src="" alt="">&ndash;&gt;-->
            <!--</figure>-->
            <!--<span class="title">Red</span>-->
            <!--<span class="count">(6)</span>-->
            <!--</label>-->
            <!--</div>-->
            <!--</li>-->
            <!--<li class="accordion__content__list">-->
            <!--<div class="accordion__content__label">-->
            <!--<input type="checkbox" name="color" id="filterColor5">-->
            <!--<label for="filterColor5">-->
            <!--<figure class="thumb" style="background:#dad55e;">-->
            <!--&lt;!&ndash;<img src="" alt="">&ndash;&gt;-->
            <!--</figure>-->
            <!--<span class="title">Yellow</span>-->
            <!--<span class="count">(6)</span>-->
            <!--</label>-->
            <!--</div>-->
            <!--</li>-->
            <!--</ul>-->
            <!--</div>-->
            <!--</div>-->
            <!--</div>-->

            <div class="filter-layer__content__acco filter-layer__content__acco--price">
                <div class="accordion">
                    <button class="accordion__opner">
                        <span class="accordion__opner__title">Price</span>
                        <span class="accordion__opner__value">4,500원 이상 114,500원 이하</span>
                    </button>
                    <div class="accordion__content">
                        <ul>
                            <li class="accordion__content__list">
                                <div class="accordion__content__label">
                                    <label>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                        <input type="radio" name="search_price" class="devPriceType" value="1" data-sprice="0" data-eprice="10000">
<?php }else{?>
                                        <input type="radio" name="search_price" class="devPriceType" value="1" data-sprice="0" data-eprice="10">
<?php }?>
                                        <span class="title">
                                            $0~$10
                                        </span>
                                    </label>
                                </div>
                            </li>
                            <li class="accordion__content__list">
                                <div class="accordion__content__label">
                                    <label>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                        <input type="radio" name="search_price" class="devPriceType" value="2"  data-sprice="10000" data-eprice="50000">
<?php }else{?>
                                        <input type="radio" name="search_price" class="devPriceType" value="2"  data-sprice="10" data-eprice="50">
<?php }?>
                                        <span class="title">
                                            $10~$50
                                        </span>
                                    </label>
                                </div>
                            </li>
                            <li class="accordion__content__list">
                                <div class="accordion__content__label">
                                    <label>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                        <input type="radio" name="search_price" class="devPriceType" value="3"  data-sprice="50000" data-eprice="100000">
<?php }else{?>
                                        <input type="radio" name="search_price" class="devPriceType" value="3"  data-sprice="50" data-eprice="100">
<?php }?>
                                        <span class="title">
                                            $50~$100
                                        </span>
                                    </label>
                                </div>
                            </li>
                            <li class="accordion__content__list">
                                <div class="accordion__content__label">
                                    <label>
<?php if($TPL_VAR["langType"]=='korean'){?>
                                        <input type="radio" name="search_price" class="devPriceType" value="4"  data-sprice="100000" data-eprice="9999999">
<?php }else{?>
                                        <input type="radio" name="search_price" class="devPriceType" value="4"  data-sprice="100" data-eprice="999">
<?php }?>
                                        <span class="title">
                                            $100~
                                        </span>
                                    </label>
                                </div>
                            </li>
                            <li class="accordion__content__list">
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
            <button type="button" class="filter-layer__btn__reset">Reset</button>
            <button type="button" class="filter-layer__btn__apply" id="devFilterSubmit">apply</button>
        </div>
        <button class="filter-layer__close">Cancel</button>
    </div>
</section>