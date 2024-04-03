<?php /* Template_ 2.2.8 2021/07/12 14:28:02 /home/barrel-stage/application/www/assets/templet/enterprise/shop/search/search.htm 000021052 */ 
$TPL_filter_1=empty($TPL_VAR["filter"])||!is_array($TPL_VAR["filter"])?0:count($TPL_VAR["filter"]);
$TPL_brandList_1=empty($TPL_VAR["brandList"])||!is_array($TPL_VAR["brandList"])?0:count($TPL_VAR["brandList"]);?>
<form id="devListForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="20" id="devMax"/>
    <input type="hidden" name="orderBy" value="regdateDesc" id="devSort" />
    <input type="hidden" name="vlevel1" value="1" />

    <input type="hidden" name="filterCid" value="<?php echo $TPL_VAR["cid"]?>" id="devCid" />
    <input type="hidden" name="filterBrands" value="" />
    <input type="hidden" name="filterDeliveryFree" value="" />
    <input type="hidden" name="filterInsideText" value="" />
    <input type="hidden" name="filterText" value="<?php echo $TPL_VAR["searchText"]?>" />
    <input type="hidden" name="filterSearchPage" value="T" />

    <input type="hidden" name="product_filter" value="" id="devProductFilter" />
    <input type="hidden" name="sprice" value="" id="devSprice" />
    <input type="hidden" name="eprice" value="" id="devEprice" />
    <input type="hidden" name="price_type" value="" id="devPriceType" />
</form>
<section class="fb__search">
    <section class="fb__search__top">
        <header class="fb__search__header">
            <h2 class="fb__search__title">‘<?php echo $TPL_VAR["searchText"]?>’</h2>
            <p class="fb__search__info">Search results <em id='devSearchTotal'></em></p>
        </header>
        <div class="fb__search__research">
            <input type="text" class="devInsideText devAutoCompleteDetail" id="devSearchText" placeholder="Search within results" onblur="removeTag(this.value);" onkeypress="removeKeyPress(this.value);" onkeydown="removeKeydown(this.value);">
            <button id="devGoInsideSearch" class="btn-default btn-dark ">Search</button>
        </div>
    </section>
    <div class="fb__goods-list">
        <section class="fb__goods-list__contents">
            <div class="list-contents">
                <header class="list-contents__header list-contents__header--open">
                    <h3 class="fb__main__title--hidden">Product list</h3>
                    <p class="list-contents__info">
                        <em><span id="devPrdSearchTotal"></span></em>items
                    </p>
                    <nav class="list-contents__nav">
                        <div class="filter">
                            <!--<a href="#" class="list-contents__nav&#45;&#45;avtive devSortTab"  data-sort="orderCnt">-->
                            <!--판매인기순-->
                            <!--</a>-->
                            <!--<a href="#" class="devSortTab" data-sort="regDate">-->
                            <!--최근등록순-->
                            <!--</a>-->
                            <!--<a href="#" class="devSortTab" data-sort="lowPrice">-->
                            <!--낮은가격순-->
                            <!--</a>-->
                            <!--<a href="#" class="devSortTab" data-sort="highPrice">-->
                            <!--높은가격순-->
                            <!--</a>-->
                            <select name="count" class="fb__select devChangeMax">
                                <option value="20" selected="selected">20 per page</option>
                                <option value="40">40 per page</option>
                                <option value="60" >60 per page</option>
                            </select>
                            <select name="sort" class="fb__select devSortTab">
                                <option value="regDate" selected="selected">New Arrivals</option>
                                <option value="orderCnt" >Popuar Sales</option>
                                <option value="lowPrice" >Price: Low to High</option>
                                <option value="highPrice" >Price: High to Low</option>
                                <option value="afterCnt" >Avg. Customer Review</option>
                            </select>
                            <button class="filter__btn">
                            <span>
                                Filter
                            </span>
                            </button>
                        </div>
                    </nav>
                </header>
<?php if($TPL_VAR["filter"]){?>
                <div class="filter__content">
                    <ul>
<?php if($TPL_filter_1){foreach($TPL_VAR["filter"] as $TPL_V1){?>
                        <li class="filter__list">
                            <dl>
                                <dt class="filter__title">
                                <span>
                                    <?php echo $TPL_V1["filter_type_text"]?>

                                </span>
<?php if($TPL_V1["filter_type"]=='COLOR'){?>
                                    <button class="filter__title__view <?php if(count($TPL_V1["item"])> 15){?>filter__title__view--show<?php }?>">전체보기 버튼</button>
<?php }else{?>
                                    <button class="filter__title__view <?php if(count($TPL_V1["item"])> 11){?>filter__title__view--show<?php }?>">전체보기 버튼</button>
<?php }?>
                                </dt>
                                <dd class="filter__cont-box">
                                    <ul>
<?php if(is_array($TPL_R2=$TPL_V1["item"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                                        <li class="filter__inner <?php if($TPL_V1["filter_type"]=='COLOR'){?>filter__inner--color<?php }?>">
<?php if($TPL_V1["filter_type"]=='COLOR'){?>
                                            <label class="filter__checkbox filter__checkbox-color">
                                                <input type="checkbox" class="devFilterItem devFilterItemColor" name="<?php echo $TPL_V1["filter_type"]?>" value="<?php echo $TPL_V2["filter_idx"]?>">
                                                <figure class="thumb">
                                                    <img src="<?php echo $TPL_V2["filter_img_pc"]?>" alt="<?php echo trans($TPL_V2["filter_name"])?>" title="<?php echo trans($TPL_V2["filter_name"])?>">
                                                </figure>
                                            </label>
<?php }else{?>
                                            <label class="filter__checkbox filter__checkbox-size">
                                                <input type="checkbox" class="devFilterItem" name="<?php echo $TPL_V1["filter_type"]?>" value="<?php echo $TPL_V2["filter_idx"]?>">
                                                <span>
                                                <?php echo $TPL_V2["filter_name"]?>

                                            </span>
                                            </label>
<?php }?>
                                            </label>
                                        </li>
<?php }}?>
                                    </ul>
                                </dd>
                            </dl>
                        </li>
<?php }}?>
                        <li class="filter__list">
                            <dl>
                                <dt class="filter__title">
                                <span>
                                    Price
                                </span>
                                </dt>
                                <dd class="filter__price">
                                    <div class="filter__price-btn">
                                        <ul>
                                            <li class="filter__button__inner">
                                                <label for="search_price_1" class="filter__button-price">
<?php if($TPL_VAR["langType"]=='korean'){?>
                                                    <input type="radio" name="search_price" id="search_price_1" value="1" data-sprice="0" data-eprice="10000">
<?php }else{?>
                                                    <input type="radio" name="search_price" id="search_price_1" value="1" data-sprice="0" data-eprice="10">
<?php }?>
                                                    <span class="font-rb">
                                                        $0~$10
                                                    </span>
                                                </label>
                                            </li>
                                            <li class="filter__button__inner">
                                                <label for="search_price_2" class="filter__button-price">
<?php if($TPL_VAR["langType"]=='korean'){?>
                                                    <input type="radio" name="search_price" id="search_price_2" value="2"  data-sprice="10000" data-eprice="50000">
<?php }else{?>
                                                    <input type="radio" name="search_price" id="search_price_2" value="2"  data-sprice="10" data-eprice="50">
<?php }?>
                                                    <span class="font-rb">
                                                      $10~$50
                                                    </span>
                                                </label>
                                            </li>
                                            <li class="filter__button__inner">
                                                <label for="search_price_3" class="filter__button-price">
<?php if($TPL_VAR["langType"]=='korean'){?>
                                                    <input type="radio" name="search_price" id="search_price_3" value="3"  data-sprice="50000" data-eprice="100000">
<?php }else{?>
                                                    <input type="radio" name="search_price" id="search_price_3" value="3"  data-sprice="50" data-eprice="100">
<?php }?>
                                                    <span class="font-rb">
                                                      $50~$100
                                                    </span>
                                                </label>
                                            </li>
                                            <li class="filter__button__inner">
                                                <label for="search_price_4" class="filter__button-price">
<?php if($TPL_VAR["langType"]=='korean'){?>
                                                    <input type="radio" name="search_price" id="search_price_4" value="4"  data-sprice="100000" data-eprice="9999999">
<?php }else{?>
                                                    <input type="radio" name="search_price" id="search_price_4" value="4"  data-sprice="100" data-eprice="999">
<?php }?>
                                                    <span class="font-rb">
                                                        $100~
                                                    </span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="filter__text-price">
                                        <input type="text" id="devSpriceInput" value="">
                                        <span>~</span>
                                        <input type="text" id="devEpriceInput" value="">
                                        <label for="search_price_5" class="filter__button-apply">
                                            <input type="radio" name="search_price" id="search_price_5" value="5"  data-sprice="" data-eprice="">
                                            <span>
                                            Apply
                                        </span>
                                        </label>
                                    </div>
                                </dd>
                            </dl>
                        </li>
                        <li class="filter__result">
                            <dl>
                                <!--<dt class="filter__title">-->
                                <!--<span>-->
                                    <!--선택옵션-->
                                <!--</span>-->
                                <!--</dt>-->
                                <dd class="">
<?php if($TPL_VAR["langType"]!='korean'){?>
                                    <div class="filter__result__list eng"></div>
<?php }else{?>
                                    <div class="filter__result__list"></div>
<?php }?>
                                    <nav class="filter__nav">
                                        <button class="filter__all__release">
                                        <span>
                                            Remove all
                                        </span>
                                        </button>
                                        <button class="filter__all__search" id="devFilterSubmit">
                                        <span>
                                            Search
                                        </span>
                                        </button>
                                    </nav>
                                </dd>
                            </dl>
                        </li>
                    </ul>
                </div>
<?php }?>
            </div>
        </section>
    </div>

    <section id="devPrdSearchSection">
        <div class="wrap-search-detail" id="devSelectSearchOption">
            <dl class="dl-category">
                <dt>카테고리 <button class="btn-dl-open">+</button></dt>
                <dd>
                    <div id="devCategoryPath" class="category-path"></div>
                    <ul id="devSubCategorysContents" class="devForbizTpl">
                        <li id="devSubCategorys" data-cid='{[cid]}' data-path='{[path]}' class='devCategorySelect{[cid]}'>{[cname]}</li>
                    </ul>
                </dd>
            </dl>
            <dl class="dl-brand">
                <dt>브랜드<button class="btn-dl-open">+</button></dt>
                <dd>
                    <ul>
<?php if($TPL_brandList_1){foreach($TPL_VAR["brandList"] as $TPL_V1){?>
                        <li data-ix="<?php echo $TPL_V1["b_ix"]?>" class="devBrandSelect<?php echo $TPL_V1["b_ix"]?>"><span><?php echo $TPL_V1["brand_name"]?></span></li>
<?php }}?>
                    </ul>

                </dd>
            </dl>
            <dl class="dl-free">
                <dt>배송</dt>
                <dd>
                    <div class="devFreeDelivery btn-free-delivery">무료배송</div>
                </dd>
            </dl>

            <!--선택옵션이 있을때만 보여져야 합니다.-->
            <dl class="dl-option-list">
                <dt>선택옵션</dt>
                <dd>
                    <ul id="devSelectedView">
                        <li id="devSelected" class="{[devFilter]}">{[selected]}<span class='devRemoveSelected btn-sel-remove' data-kind='{[kind]}'></span></li>
                    </ul>
                    <button class="btn-sel-refresh">전체해제</button>
                </dd>
            </dl>
            <!--//// -->

        </div>
        <section class="fb__main__best fb__goods-list__contents">

            <div class="fb__main__goods ">
                <div class="fb__main__goods fb__main__goodsInner">
                    <ul class="fb__goods " id="devListContents">
                    <li id="devListLoading" class="devForbizTpl loading-text">loading...</li>
                    <li id="devListEmpty" class="empty-content devForbizTpl">

                        <!--상세검색결과가 없을 때-->
                        <div class="no-result type02 devForbizTpl" id="devEmptyFilter">
                            <p> <i></i> No results found for the selected option.</p>
                            <span>Choose another option to search.</span>
                        </div>

                        <!--검색결과가 없을 때-->
                        <div class="no-result type01 fb__search-noresult" id="devEmptyKeyword">
                            <p class="fb__search-noresult__info"><i></i> <span>No result.</span></p>
                            <div class="fb__search-noresult__list">
                                <!--<span>-일시적으로 상품이 품절되었을 수 있습니다.</span><br/>-->
                                <span>-Please make sure the search term is typed correctly.</span>
                                <span>-Please try your search again.</span>
                                <span>-Try different spacing for your search terms.</span>
                            </div>
                        </div>

                    </li>
                    <li class="fb__goods__list devForbizTpl" id="devListDetail">
                        <a href="/shop/goodsView/{[id]}" class="fb__goods__link">
                            <figure class="fb__goods__img">
                                {[#if timeSaleIconView]}
                                <img src="{[timeSaleIcon]}" class="product-box__time-deal" >
                                {[/if]}
                                <div>
                                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="{[image_src]}">
                                </div>
                            </figure>
                            <div class="fb__goods__info">
                                <div class="fb__badge">
                                    {[#if icons]}
                                        {[#each icons_path]}
                                        <span class="fb__badge--water">
                                            {[{this}]}
                                        </span>
                                        {[/each]}
                                        <!--<span class="fb__badge&#45;&#45;fitness">-->
                                            <!--<img src="/assets/templet/enterprise/images/main/icon-goods-fitness.gif" alt="FITNESS">-->
                                        <!--</span>-->
                                    {[/if]}
                                </div>
                                <ul class="fb__goods__infoBox">
                                    <li class="fb__goods__pre">
                                        {[preface]}
                                    </li>
                                    <li class="fb__goods__name">
                                        {[pname]}
                                    </li>
                                    <li class="fb__goods__option">
                                        {[add_info]}
                                    </li>
                                    <li class="fb__goods__brand">
                                        {[brand_name]}
                                    </li>
                                </ul>

                            </div>
                        </a>
                        <div class="fb__goods__important">
                            <span class="fb__goods__price">
                                <em>{[dcprice]}</em>
                            </span>
                            <span class="fb__goods__noprice">
                                {[#if isDiscount]}{[listprice]}{[/if]}
                            </span>
                            {[#if is_soldout]}
                            <span class="fb__goods__price__state">Out of stock</span>
                            {[else]}
                                {[#if discount_rate]}
                                <span class="fb__goods__sale">
                                    <p class="per"><em>{[discount_rate]}</em>%</p>
                                </span>
                                {[/if]}
                            {[/if]}
                        </div>
                        <!--p class="fb__goods__condition">
                            {[#if deliveryText]}<p class="per"><em>{[discount_rate]}</em>%</p>{[else]} Shipping information policy not entered {[/if]}
                        </p-->
                        <a href="#" class="product-box__heart {[#if alreadyWish]}product-box__heart--active{[/if]}" data-devWishBtn="{[id]}">
                            hart
                        </a>
                    </li>
                </ul>
                </div>
            </div>
            <div id="devPageWrap"></div>
        </section>
    </section>
</section>