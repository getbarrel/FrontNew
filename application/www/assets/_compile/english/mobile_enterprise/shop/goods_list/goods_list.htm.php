<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/goods_list/goods_list.htm 000020395 */ 
$TPL_bannerInfo_1=empty($TPL_VAR["bannerInfo"])||!is_array($TPL_VAR["bannerInfo"])?0:count($TPL_VAR["bannerInfo"]);
$TPL_filter_1=empty($TPL_VAR["filter"])||!is_array($TPL_VAR["filter"])?0:count($TPL_VAR["filter"]);?>
<form id="devListForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="20" />
    <input type="hidden" name="filterCid" value="<?php echo $TPL_VAR["cid"]?>" id="devCid"/>
    <input type="hidden" name="orderBy" value="viewOrder" id="devSort" />
    <input type="hidden" name="product_filter" value="" id="devProductFilter" />
    <input type="hidden" name="sprice" value="" id="devSprice" />
    <input type="hidden" name="eprice" value="" id="devEprice" />
    <input type="hidden" name="price_type" value="" id="devPriceType" />
</form>
<div class="br__title-box">
    <!--<button type="button" class="br__title-box__back">뒤로가기</button>-->
    <h2 class="br__title-box__title"><button type="button"><?php echo $TPL_VAR["cateName"]?></button></h2>
</div>
<section class="br__goods-list">
<?php if($TPL_VAR["bannerInfo"]){?>
    <div class="br__slide br__slide--type1">
        <div class="swiper-container">
            <ul class="swiper-wrapper">
<?php if($TPL_bannerInfo_1){foreach($TPL_VAR["bannerInfo"] as $TPL_V1){?>
                <li class="swiper-slide">
                    <div class="slide-content">
                        <a class="slide-content__link" href="<?php echo $TPL_V1["bannerLink"]?>">
                            <figure class="slide-content__thumb">
                                <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                                <!--<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/sample/sample.jpg" alt="<?php echo $TPL_V1["banner_name"]?>">-->
                            </figure>
                        </a>
                        <!--<div class="slide-content__script">-->
                        <!--<p class="slide-content__script__preface"><?php echo $TPL_V1["shot_title"]?></p>-->
                        <!--<p class="slide-content__script__title"><?php echo $TPL_V1["banner_name"]?></p>-->
                        <!--<p class="slide-content__script__desc"><?php echo nl2br($TPL_V1["banner_desc"])?></p>-->
                        <!--<a href="<?php echo $TPL_V1["bannerLink"]?>" class="slide-content__script__btn">Detail</a>-->
                        <!--</div>-->
                    </div>
                </li>
<?php }}?>
            </ul>
            <div class="slide-controller">
                <div class="slide-controller__page">
                    <div class="slide-controller__page__wrap">
                        <span class="slide-controller__page__current">1</span>
                        <span class="slide-controller__page__slash">/</span>
                        <span class="slide-controller__page__total">1</span>
                    </div>
                    <button type="button" class="slide-controller__page__all-view">전체보기 버튼</button>
                </div>
                <div class="slide-controller__player">
                    <button class="slide-controller__player__btn">자동재생/일시정지 버튼</button>
                </div>
                <!--<div class="slide-controller__arrow">-->
                <!--<button type="button" class="slide-controller__arrow__btn slide-controller__arrow__btn&#45;&#45;prev">이전으로</button>-->
                <!--<button type="button" class="slide-controller__arrow__btn slide-controller__arrow__btn&#45;&#45;next">다음으로</button>-->
                <!--</div>-->
            </div>
        </div>
        <div class="slide-layer">
            <div class="slide-layer__inner">
                <h4 class="slide-layer__title">All</h4>
                <ul class="slide-layer__content">
                    <!--<li class="slide-layer__list"></li>-->
                </ul>
                <button class="slide-layer__close">close view all</button>
            </div>
            <div class="slide-layer__bg"></div>
        </div>
<?php }?>
    <div class="br__goods-list__filter">
        <div class="filters">
            <button type="button" class="filters__btn" id="devFilterView">Filter</button>
            <div class="filters__grid">
                <input type="radio" name="goodsGrid" id="gridNormal" value="normal" checked><label for="gridLarge" class="title-box__grid__icon title-box__grid__icon--normal">view</label>
                <input type="radio" name="goodsGrid" id="gridLarge" value="large"><label for="gridNormal" class="title-box__grid__icon title-box__grid__icon--large">Enlarge</label>
            </div>
            <div class="br__select-box select-box__wrap">
                <div class="select-box">
                    <button class="select-box__title select-box__name"><span>New Arrivals</span></button>
                    <div class="select-box__layer">
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="regdateDesc">
                            <span>New Arrivals</span>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="orderCnt">
                            <span>Best Sellers</span>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="lowPrice">
                            <span style="font-size:1.05rem">Price: Low to High</span>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="highPrice">
                            <span style="font-size:1.05rem">Price: High to Low</span>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="afterCnt">
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <span>Avg. Customer Review</span>
<?php }else{?>
                            <span>Most reviews</span>
<?php }?>
                        </label>
                        <label class="select-box__layer__label">
                            <input type="radio" class="devSortTab" name="filterRadio" value="viewOrder" checked>
<?php if($TPL_VAR["langType"]=='korean'){?>
                            <span>Barrel&#39;s recommendation</span>
<?php }else{?>
                            <span>Recommended</span>
<?php }?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="br__goods-list__wrap br__goods-list__wrap--normal">
        <div class="goods-list">
            <div id="devFilterEmpty" class="empty-content" style="display:none"><p><em class=""js__selected__text""> No results</em>found for your search.<span>Please select another option to search.</span></p></div>
            <ul class="goods-list__list" id="devListContents">
                <li class="devForbizTpl" id="devListLoading">loading...</li>

                <li id="devListEmpty" class="empty-content devForbizTpl"><p>No registered product.</p></li>

                <li class="devForbizTpl goods-list__box" id="devListDetail">
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
                            </div>
                            {[else]}
                            <div class="goods-list__badge">
                                <span></span>
                            </div>
                            {[/if]}
                            <p class="br__goods__pre">{[preface]}</p>
                            <p class="goods-list__title">{[pname]}</p>
                            <span class="goods-list__color">{[add_info]}</span>
                            <div class="goods-list__price">
                                <span class="goods-list__price__discount"><em><?php echo $TPL_VAR["fbUnit"]["f"]?></em><span>{[dcprice]}</span><?php if($TPL_VAR["langType"]!='korean'){?><?php echo $TPL_VAR["fbUnit"]["b"]?><?php }?></span>
                                {[#if isDiscount]}
                                <span class="goods-list__price__cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><span>{[listprice]}</span><?php if($TPL_VAR["langType"]!='korean'){?><?php echo $TPL_VAR["fbUnit"]["b"]?><?php }?></span>
                                {[/if]}
                                {[#if is_soldout]}
                                <span class="goods-list__price__state">Out of stock</span>
                                {[else]}
                                    {[#if isPercent]}
                                        <span class="goods-list__price__percent"><span>{[discount_rate]}</span>%</span>
                                    {[/if]}
                                {[/if]}
                            </div>
                        </div>
                    </a>
                    <label class="goods-list__wish{[#if alreadyWish]} on{[/if]}" devwishbtn="{[id]}">
                        {[#if alreadyWish]}
                        <input type="checkbox" class="goods-list__wish__btn" checked>
                        {[else]}
                        <input type="checkbox" class="goods-list__wish__btn">
                        {[/if]}
                    </label>
                </li>
            </ul>
            <div id="devPageWrap" style="text-align:center;">
                <div class="br__more devPageBtnCls">View more</div>
            </div>
        </div>
    </div>
</section>

<section class="br__category-layer">
    <div class="cate-layer">
        <h2 class="cate-layer__top">category list layer</h2>
        <div class="cate-layer__wrap">
            <h3 class="cate-layer__title"><?php echo $TPL_VAR["topCateName"]?></h3>
            <ul class="cate-layer__list">
                <li class="cate-layer__box">
                    <a href="/shop/goodsList/<?php echo $TPL_VAR["topCateCid"]?>" class="cate-layer__box__link">All</a>
                </li>
<?php if(is_array($TPL_R1=$TPL_VAR["cateArr"]["subCate"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <li class="cate-layer__box <?php if(substr($TPL_VAR["cid"], 3, 3)==substr($TPL_V1["cid"], 3, 3)){?>cate-layer__box--active<?php }?>"><!-- 중카테고리 페이지 -->
                    <button type="button" class="cate-layer__toggle"><?php echo $TPL_V1["cname"]?></button>
                    <ul class="cate-layer__down">
                        <li class="cate-layer__down__box">
                            <a href="/shop/goodsList/<?php echo $TPL_V1["cid"]?>" class="cate-layer__down__link">All</a>
                        </li>
<?php if(is_array($TPL_R2=$TPL_V1["subCate"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                        <li class="cate-layer__down__box">
                            <a href="/shop/goodsList/<?php echo $TPL_V2["cid"]?>" class="cate-layer__down__link <?php if($TPL_VAR["cid"]==$TPL_V2["cid"]){?>cate-layer__down__link--active<?php }?>"><?php echo $TPL_V2["cname"]?></a>
                        </li>
<?php }}?>
                    </ul>
                </li>
<?php }}?>
            </ul>
            <ul class="cate-layer__other">
<?php if(is_array($TPL_R1=$TPL_VAR["headerMenu"]["categoryList"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["cid"]!=$TPL_VAR["topCateCid"]){?>
                <li class="cate-layer__other__box">
                    <a href="/shop/goodsList/<?php echo $TPL_V1["cid"]?>" class="cate-layer__other__link"><?php echo $TPL_V1["cname"]?></a>
                </li>
<?php }?>
<?php }}?>
            </ul>
        </div>
        <button type="button" class="cate-layer__close">카테고리 레이어 닫기</button>
    </div>
</section>
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
                                        <input type="checkbox" class="devFilterItem" name="<?php echo $TPL_V1["filter_type"]?>" value="<?php echo $TPL_V2["filter_idx"]?>">
<?php if($TPL_V2["filter_img_mobile"]){?>
                                        <figure class="thumb">
                                            <img src="<?php echo $TPL_V2["filter_img_mobile"]?>" alt="">
                                        </figure>
<?php }?>
                                        <span><?php echo trans($TPL_V2["filter_name"])?></span>
                                    </label>
<?php }}?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
<?php }}?>

            <div class="filter-layer__content__acco filter-layer__content__acco--price">
                <div class="accordion">
                    <button class="accordion__opner">
                        <span class="accordion__opner__title">Price</span>
                        <span class="accordion__opner__value"></span>
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
        <button class="filter-layer__close">닫기</button>
    </div>
</section>