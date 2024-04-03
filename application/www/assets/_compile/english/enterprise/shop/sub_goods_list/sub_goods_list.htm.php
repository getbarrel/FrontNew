<?php /* Template_ 2.2.8 2020/09/04 10:58:49 /home/barrel-stage/application/www/assets/templet/enterprise/shop/sub_goods_list/sub_goods_list.htm 000018283 */ 
$TPL_bannerInfo_1=empty($TPL_VAR["bannerInfo"])||!is_array($TPL_VAR["bannerInfo"])?0:count($TPL_VAR["bannerInfo"]);
$TPL_filter_1=empty($TPL_VAR["filter"])||!is_array($TPL_VAR["filter"])?0:count($TPL_VAR["filter"]);?>
<form id="devListForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="20" id="devMax" />
    <input type="hidden" name="filterCid" value="<?php echo $TPL_VAR["cid"]?>" id="devCid"/>
    <input type="hidden" name="orderBy" value="viewOrder" id="devSort"/>
    <input type="hidden" name="product_filter" value="" id="devProductFilter" />
    <input type="hidden" name="sprice" value="" id="devSprice" />
    <input type="hidden" name="eprice" value="" id="devEprice" />
    <input type="hidden" name="price_type" value="" id="devPriceType" />
</form>
<section class="fb__subGoods-list ">
    <h2 class="fb__main__title--hidden">Product list</h2>
<?php if($TPL_VAR["bannerInfo"]){?>
    <div class='banner'>
        <div class="banner__sliderWrap fb__main__slider fb__subGoods-list__slider">
            <div class="banner__slider swiper-container">
                <div class="swiper-wrapper">
<?php if($TPL_bannerInfo_1){foreach($TPL_VAR["bannerInfo"] as $TPL_V1){?>
                    <div class="banner__sliderList swiper-slide">
                        <a href="<?php echo $TPL_V1["bannerLink"]?>">
                            <figure>
                                <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="">
                            </figure>
                        </a>
                    </div>
<?php }}?>
                </div>
            </div>
            <div class="mainSlider__control fb__main">
                <div class="mainSlider__dot">

                </div>
                <div class="mainSlider__arrow">
                    <a href="#" class="mainSlider__arrow--prev">
                        prev
                    </a>
                    <a href="#" class="mainSlider__arrow--next">
                        next
                    </a>
                </div>
                <div class="mainSlider__page">
                    <span class="mainSlider__page__wrap"><span class="mainSlider__page__now">1</span>/<span class="mainSlider__page__total">5</span></span>
                    <a href="#" class="mainSlider__auto">
                        <span class="mainSlider__auto--play">play</span>
                        <span class="mainSlider__auto--stop">stop</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php }?>

    <div class="fb__goods-list <?php if(!$TPL_VAR["bannerInfo"]){?> fb__goods-list--noBanner <?php }?>">
        <section class="fb__goods-list__contents">
            <div class="list-contents">
                <header class="list-contents__header">
                    <h3 class="fb__main__title--hidden">Product list</h3>
                    <p class="list-contents__info">
                        <em><span id="devTotalProduct"></span></em> items
                    </p>
                    <nav class="list-contents__nav">
                        <div class="filter">
                            <select name="count" class="fb__select" id="devMaxTab">
                                <option value="20" selected="selected">20 per page</option>
                                <option value="40">40 per page</option>
                                <option value="60" >60 per page</option>
                            </select>
                            <select name="sort" class="fb__select" id="devSortTab">
                                <option value="regdateDesc" >(english)최근상품순</option>
                                <option value="orderCnt">Best Sellers</option>
                                <option value="lowPrice" >Price: Low to High</option>
                                <option value="highPrice" >Price: High to Low</option>
                                <option value="afterCnt" >Avg. Customer Review</option>
                                <option value="viewOrder" selected="selected">Barrel&#39;s recommendation</option>
                            </select>
                            <button class="filter__btn">
                            <span>
                                Filter
                            </span>
                            </button>
                        </div>
                    </nav>
                </header>
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
                                                <input type="checkbox" class="devFilterItem" name="<?php echo $TPL_V1["filter_type"]?>" value="<?php echo $TPL_V2["filter_idx"]?>">
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
                                    <!--Select option-->
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
                <div class="fb__main__goods fb__main__goodsInner">
                    <div id="devFilterEmpty" class="empty-content" style="display:none"><p><em class=""js__selected__text""> No results</em>found for your search.<span>Please select another option to search.</span></p></div>
                    <ul class=" fb__goods  three-boxes-wrap " id="devListContents">
                        <li class="devForbizTpl" id="devListLoading">loading...</li>

                        <li class="empty-content devForbizTpl" id="devListEmpty">No registered product.</li>

                        <li class="fb__goods__list devForbizTpl" id="devListDetail" data-fatid="{[id]}">
                            <a href="/shop/goodsView/{[id]}" class="fb__goods__link">
                                <figure class="fb__goods__img">
                                    {[#if timeSaleIconView]}
                                    <img src="{[timeSaleIcon]}" class="product-box__time-deal" >
                                    {[/if]}
                                    <div>
                                        <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="{[image_src]}" >
                                    </div>
                                </figure>
                                <div class="fb__goods__info">
                                    <div class="fb__badge">
                                        {[#each icons_path]}
                                        <span class="fb__badge--water">
                                        {[{this}]}
                                        </span>
                                        {[/each]}
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
                                <div class="fb__goods__important">
                                    <span class="fb__goods__price">
                                        <?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[dcprice]}</em><?php if($TPL_VAR["langType"]!='korean'){?><?php echo $TPL_VAR["fbUnit"]["b"]?><?php }?>
                                    </span>
                                    <span class="fb__goods__noprice">
                                        {[#if isDiscount]}<?php echo $TPL_VAR["fbUnit"]["f"]?>{[listprice]}<?php if($TPL_VAR["langType"]!='korean'){?><?php echo $TPL_VAR["fbUnit"]["b"]?><?php }?>{[/if]}
                                    </span>
                                    {[#if is_soldout]}
                                    <span class="fb__goods__price__state">Out of stock</span>
                                    {[else]}
                                        {[#if isPercent]}
                                        <span class="fb__goods__sale">
                                            <p class="per"><em>{[discount_rate]}</em>%</p>
                                        </span>
                                        {[/if]}
                                    {[/if]}
                                </div>
                                <p class="fb__goods__condition">
                                    Overseas shipping fee will be charged
                                </p>
                            </a>
                            <a href="#" class="product-box__heart {[#if alreadyWish]}product-box__heart--active{[/if]}" data-devwishbtn="{[id]}">
                                hart
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
</section>

<div id="devPageWrap"></div>