<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/main/index.htm 000019470 */ 
$TPL_mainBannerInfo_1=empty($TPL_VAR["mainBannerInfo"])||!is_array($TPL_VAR["mainBannerInfo"])?0:count($TPL_VAR["mainBannerInfo"]);
$TPL_mainEventBannerInfo_1=empty($TPL_VAR["mainEventBannerInfo"])||!is_array($TPL_VAR["mainEventBannerInfo"])?0:count($TPL_VAR["mainEventBannerInfo"]);
$TPL_mainMovieBannerInfo_1=empty($TPL_VAR["mainMovieBannerInfo"])||!is_array($TPL_VAR["mainMovieBannerInfo"])?0:count($TPL_VAR["mainMovieBannerInfo"]);
$TPL_mainBestBannerInfo_1=empty($TPL_VAR["mainBestBannerInfo"])||!is_array($TPL_VAR["mainBestBannerInfo"])?0:count($TPL_VAR["mainBestBannerInfo"]);
$TPL_mainProMotionBannerInfo_1=empty($TPL_VAR["mainProMotionBannerInfo"])||!is_array($TPL_VAR["mainProMotionBannerInfo"])?0:count($TPL_VAR["mainProMotionBannerInfo"]);
$TPL_mainEventBottomBannerInfo_1=empty($TPL_VAR["mainEventBottomBannerInfo"])||!is_array($TPL_VAR["mainEventBottomBannerInfo"])?0:count($TPL_VAR["mainEventBottomBannerInfo"]);
$TPL_mainDisplayGroup_1=empty($TPL_VAR["mainDisplayGroup"])||!is_array($TPL_VAR["mainDisplayGroup"])?0:count($TPL_VAR["mainDisplayGroup"]);?>
<?php if(!empty($TPL_VAR["mainDisplayGroupData"])){?>
<script>var mainDisplayGroupData = <?php echo $TPL_VAR["mainDisplayGroupData"]?>;</script> 
<?php }?>
<section class="br__main">
    <h2 class="br__hidden">Main page</h2>

<?php if($TPL_VAR["mainBannerInfo"]){?>
    <section class="br__main__top-slide">
        <h3 class="br__hidden">Upper Slide</h3>
        <div class="br__slide br__slide--type1">
            <div class="swiper-container">
                <ul class="swiper-wrapper">
<?php if($TPL_mainBannerInfo_1){foreach($TPL_VAR["mainBannerInfo"] as $TPL_V1){?>
                    <li class="swiper-slide">
                        <div class="slide-content">
                            <a class="slide-content__link" href="<?php echo $TPL_V1["bannerLink"]?>">
                                <figure class="slide-content__thumb">
                                    <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                                </figure>
                            </a>
                            <div class="slide-content__script">
                                <p class="slide-content__script__preface"><?php echo $TPL_V1["shot_title"]?></p>
                                <p class="slide-content__script__title"><?php echo $TPL_V1["banner_name"]?></p>
                                <p class="slide-content__script__desc"><?php echo nl2br($TPL_V1["banner_desc"])?></p>
                                <a href="<?php echo $TPL_V1["bannerLink"]?>" class="slide-content__script__btn">Detail</a>
                            </div>
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
                    <div class="slide-controller__arrow">
                        <button type="button" class="slide-controller__arrow__btn slide-controller__arrow__btn--prev">이전으로</button>
                        <button type="button" class="slide-controller__arrow__btn slide-controller__arrow__btn--next">다음으로</button>
                    </div>
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
        </div>
    </section>
<?php }?>
<?php if($TPL_VAR["mainEventBannerInfo"]){?>
    <section class="br__main__event br__main__event--type1">
        <h3 class="br__hidden">Event Slide</h3>
        <div class="br__slide br__slide--type4">
            <div class="swiper-container">
                <ul class="swiper-wrapper">
<?php if($TPL_mainEventBannerInfo_1){foreach($TPL_VAR["mainEventBannerInfo"] as $TPL_V1){?>
                    <li class="swiper-slide">
                        <div class="slide-content">
                            <a class="slide-content__link" href="<?php echo $TPL_V1["bannerLink"]?>">
                                <figure class="slide-content__thumb">
                                    <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                                </figure>
                            </a>
                        </div>
                    </li>
<?php }}?>
                </ul>
                <div class="slide-controller">
                    <div class="slide-controller__bullet"></div><!-- bullet 일 경우 -->
                </div>
            </div>
        </div>
    </section>
<?php }?>
<?php if($TPL_VAR["mainMovieBannerInfo"]){?>
    <section class="br__main__video">
        <h3 class="br__hidden">image area</h3>
        <div class="main-video">
            <div class="main-video__player">
                <!-- 영상 재생 영역 -->
                <!--<img src="/assets/mobile_templet/mobile_enterprise/images/_temp/sample_main_video.jpg" alt="" style="display:block;width:100%;">-->
<?php if($TPL_mainMovieBannerInfo_1){foreach($TPL_VAR["mainMovieBannerInfo"] as $TPL_V1){?>
                <iframe width="100%" height="365" src="<?php echo $TPL_V1["banner_html"]?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<?php }}?>
            </div>
            <div class="main-video__link">
                <a href="/brand/visual?category=video" class="main-video__link__btn">More video</a>
            </div>
        </div>

    </section>
<?php }?>

<?php if($TPL_VAR["mainBestBannerInfo"]){?>
    <section class="br__main__new-goods">
        <h3 class="br__hidden">Best section</h3>
        <div class="new-goods">
            <div class="new-goods__title">Best Items</div>
            <div class="br__slide br__slide--type5">
                <div class="swiper-container">
                    <ul class="swiper-wrapper">
<?php if($TPL_mainBestBannerInfo_1){foreach($TPL_VAR["mainBestBannerInfo"] as $TPL_V1){?>
                        <li class="swiper-slide">
                            <div class="slide-content">
                                <a class="slide-content__link" href="<?php echo $TPL_V1["bannerLink"]?>">
                                    <figure class="slide-content__thumb best">
                                        <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                                    </figure>
                                    <span class="slide-content__title">
                                        <span class="slide-content__title__text"><?php echo $TPL_V1["banner_name"]?></span>
<?php if($TPL_V1["shot_title"]){?>
                                        <span class="slide-content__title__text"><?php echo $TPL_V1["shot_title"]?></span>
<?php }?>
                                    </span>
                                </a>
                            </div>
                        </li>
<?php }}?>
                    </ul>
                    <div class="slide-controller" >
                        <div class="slide-controller__bullet"></div><!-- bullet 일 경우 -->
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }?>

<?php if($TPL_VAR["mainProMotionBannerInfo"]){?>
    <section class="br__main__exhibition">
        <h3 class="br__hidden">Exhibition List</h3>
        <ul class="exhibition">
<?php if($TPL_mainProMotionBannerInfo_1){foreach($TPL_VAR["mainProMotionBannerInfo"] as $TPL_V1){?>
            <li class="exhibition__list">
                <a href="<?php echo $TPL_V1["bannerLink"]?>" class="exhibition__list__link">
                    <figure class="exhibition__list__thumb">
                        <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                    </figure>
                </a>
                <p class="exhibition__desc"><?php echo $TPL_V1["banner_desc"]?></p>
            </li>
<?php }}?>
        </ul>
    </section>
<?php }?>

<?php if($TPL_VAR["mainEventBottomBannerInfo"]){?>
    <section class="br__main__event br__main__event--type2">
        <h3 class="br__hidden">Event Slide</h3>
        <div class="br__slide br__slide--type3">
            <div class="swiper-container">
                <ul class="swiper-wrapper">
<?php if($TPL_mainEventBottomBannerInfo_1){foreach($TPL_VAR["mainEventBottomBannerInfo"] as $TPL_V1){?>
                    <li class="swiper-slide">
                        <div class="slide-content">
                            <a class="slide-content__link" href="<?php echo $TPL_V1["bannerLink"]?>">
                                <figure class="slide-content__thumb">
                                    <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                                </figure>
                            </a>
                            <div class="slide-content__script">
                                <p class="slide-content__script__title"><?php echo $TPL_V1["banner_name"]?></p>
                                <p class="slide-content__script__desc"><?php echo nl2br($TPL_V1["banner_desc"])?></p>
                            </div>
                        </div>
                    </li>
<?php }}?>
                </ul>
                <div class="slide-controller">
                    <div class="slide-controller__bullet"></div><!-- bullet 일 경우 -->
                    <div class="slide-controller__arrow">
                        <button type="button" class="slide-controller__arrow__btn slide-controller__arrow__btn--prev">prev</button>
                        <button type="button" class="slide-controller__arrow__btn slide-controller__arrow__btn--next">next</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }?>

<?php if($TPL_VAR["mainDisplayGroup"]){?>
    <section class="br__main__category">
        <h3 class="br__hidden">카테고리 리스트</h3>
        <!-- [S] 카테고리 반복구간 -->
<?php if($TPL_mainDisplayGroup_1){foreach($TPL_VAR["mainDisplayGroup"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["details"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
        <div class="main-cate devDisplayGroup" data-group_code="<?php echo $TPL_V2["group_code"]?>">
            <h4 class="main-cate__title"><?php echo $TPL_V2["group_name"]?></h4>
<?php if($TPL_V2["getPromotionBanner"]){?>
            <div class="main-cate__slide">
                <div class="br__slide br__slide--type2">
                    <div class="swiper-container">
                        <ul class="swiper-wrapper">
<?php if(is_array($TPL_R3=$TPL_V2["getPromotionBanner"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                            <li class="swiper-slide">
                                <div class="slide-content">
                                    <a class="slide-content__link" href="<?php echo $TPL_V3["bannerLink"]?>">
                                        <figure class="slide-content__thumb">
                                            <img src="<?php echo $TPL_V3["imgSrc"]?>" alt="<?php echo $TPL_V3["banner_name"]?>">
                                        </figure>
                                    </a>
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
                        </div>
                    </div>
                    <div class="slide-layer">
                        <h4 class="slide-layer__title">All</h4>
                        <ul class="slide-layer__content">
                            <!--<li class="slide-layer__list"></li>-->
                        </ul>
                        <button class="slide-layer__close">전체보기 닫기</button>
                    </div>
                </div>
            </div>
<?php }?>
            <form id="devListForm_<?php echo $TPL_V2["group_code"]?>">
                <input type="hidden" name="page" value="1" id="devPage_<?php echo $TPL_V2["group_code"]?>"/>
                <input type="hidden" name="max" value="8" />
                <input type="hidden" name="div_code" value="<?php echo $TPL_V2["div_code"]?>" />
                <input type="hidden" name="mg_ix" value="<?php echo $TPL_V2["mg_ix"]?>" />
                <input type="hidden" name="group_code" value="<?php echo $TPL_V2["group_code"]?>" />
                <input type="hidden" name="product_cnt" value="<?php echo $TPL_V2["product_cnt"]?>" />
                <input type="hidden" name="orderBy" value="regdateDesc" />
            </form>
            <div class="main-cate__goods-list br__goods-list__wrap br__goods-list__wrap--normal">
                <div class="goods-list">
                    <ul class="goods-list__list" id="devListContents_<?php echo $TPL_V2["group_code"]?>">
                        <li class="devForbizTpl" id="devListLoading_<?php echo $TPL_V2["group_code"]?>"></li>
                        <li class="devForbizTpl" id="devListEmpty_<?php echo $TPL_V2["group_code"]?>">There is no registered product.</li>
                        <li class="goods-list__box devForbizTpl" id="devListDetail_<?php echo $TPL_V2["group_code"]?>">
                            <a href="/shop/goodsView/{[id]}" class="goods-list__link">
                                <figure class="goods-list__thumb">
                                    {[#if timeSaleIconViewM]}
                                    <img src="{[timeSaleIconM]}" class="goods-list__time-deal" >
                                    {[/if]}
                                    <img  src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif"  data-src="{[image_src]}" alt="{[pname]}">
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
                                        {[#if isPercent]}
                                        <span class="goods-list__price__percent"><span>{[discount_rate]}</span>%</span>
                                        {[else is_soldout]}
                                        <span class="goods-list__price__state">Out of stock</span>
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
                    <div class="br__more devPageBtnCls" id="devPageWrap_<?php echo $TPL_V2["group_code"]?>"></div>
                </div>
            </div>
        </div>
<?php }}?>
<?php }}?>
        <!-- [E] 카테고리 반복구간 -->
    </section>
<?php }?>
</section>

<!-- cre.ma / 타겟 팝업 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
<div class="crema-target-popup"></div>

<!-- cre.ma / 리뷰 작성 유도 팝업 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
<div class="crema-popup"></div>

<!-- cre.ma / 공통 스크립트 (Mobile) / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
<script>(function(i,s,o,g,r,a,m){if(s.getElementById(g))<?php echo $TPL_VAR["return"]?>;a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.id=g;a.async=1;a.src=r;m.parentNode.insertBefore(a,m)})(window,document,'script','crema-jssdk','//widgets.cre.ma/getbarrel.com/mobile/init.js');</script>