<?php /* Template_ 2.2.8 2021/08/27 10:19:26 /home/barrel-stage/application/www/assets/templet/enterprise/main/index.htm 000027497 */ 
$TPL_mainBannerInfo_1=empty($TPL_VAR["mainBannerInfo"])||!is_array($TPL_VAR["mainBannerInfo"])?0:count($TPL_VAR["mainBannerInfo"]);
$TPL_mainMovieBannerInfo_1=empty($TPL_VAR["mainMovieBannerInfo"])||!is_array($TPL_VAR["mainMovieBannerInfo"])?0:count($TPL_VAR["mainMovieBannerInfo"]);
$TPL_mainBestBannerInfo_1=empty($TPL_VAR["mainBestBannerInfo"])||!is_array($TPL_VAR["mainBestBannerInfo"])?0:count($TPL_VAR["mainBestBannerInfo"]);
$TPL_mainNewProductBannerInfo_1=empty($TPL_VAR["mainNewProductBannerInfo"])||!is_array($TPL_VAR["mainNewProductBannerInfo"])?0:count($TPL_VAR["mainNewProductBannerInfo"]);
$TPL_mainNewProductType2BannerInfo_1=empty($TPL_VAR["mainNewProductType2BannerInfo"])||!is_array($TPL_VAR["mainNewProductType2BannerInfo"])?0:count($TPL_VAR["mainNewProductType2BannerInfo"]);
$TPL_mainEventBannerInfo_1=empty($TPL_VAR["mainEventBannerInfo"])||!is_array($TPL_VAR["mainEventBannerInfo"])?0:count($TPL_VAR["mainEventBannerInfo"]);
$TPL_mainBarrelUserBannerInfo_1=empty($TPL_VAR["mainBarrelUserBannerInfo"])||!is_array($TPL_VAR["mainBarrelUserBannerInfo"])?0:count($TPL_VAR["mainBarrelUserBannerInfo"]);
$TPL_mainDisplayGroup_1=empty($TPL_VAR["mainDisplayGroup"])||!is_array($TPL_VAR["mainDisplayGroup"])?0:count($TPL_VAR["mainDisplayGroup"]);?>
<?php if(!empty($TPL_VAR["mainDisplayGroupData"])){?>
<script>var mainDisplayGroupData = <?php echo $TPL_VAR["mainDisplayGroupData"]?>;</script>
<?php }?>
<section class="fb__main">
    <h2 class="fb__title--hidden">
        main
    </h2>
    <!--<a href="http://socal.cafe24.com" class="fb__main__before eng-hidden" target="_blank">-->
        <!--<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/banner-before-site.png" alt="">-->
    <!--</a>-->
<?php if($TPL_VAR["mainBannerInfo"]){?>
    <section class="fb__main__slider fb__main__visual fb__main__slider__gap">
        <h3 class="fb__title--hidden">
            main slider
        </h3>
        <div class="mainSlider mainVisual">
            <div class="mainSlider__slider swiper-container">
                <div class="swiper-wrapper">
<?php if($TPL_mainBannerInfo_1){foreach($TPL_VAR["mainBannerInfo"] as $TPL_V1){?>
                    <div class="swiper-slide mainSlider__item">
                        <a href="<?php echo $TPL_V1["bannerLink"]?>">
                            <figure>
                                <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                                <!--<img data-src="https://image.getbarrel.com/data/barrel_data/images/banner/1041/mbn_19fw_swim_julien_pc.jpg" alt="" class="swiper-lazy">-->
                            </figure>
                            <!--<div class="swiper-lazy-preloader"></div>-->
                        </a>
                    </div>
                    <!--<div class="swiper-slide mainSlider__item">-->
                        <!--<a href="<?php echo $TPL_V1["bannerLink"]?>">-->
                            <!--<figure>-->
                                <!--&lt;!&ndash;<img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">&ndash;&gt;-->
                                <!--<img data-src="https://image.getbarrel.com/data/barrel_data/images/banner/77/190901_mainbanner_barrelfit_독립몰.jpg" alt="" class="swiper-lazy">-->
                            <!--</figure>-->
                            <!--<div class="swiper-lazy-preloader">2</div>-->
                        <!--</a>-->
                    <!--</div>-->
                    <!--<div class="swiper-slide mainSlider__item">-->
                        <!--<a href="<?php echo $TPL_V1["bannerLink"]?>">-->
                            <!--<figure>-->
                                <!--&lt;!&ndash;<img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">&ndash;&gt;-->
                                <!--<img src="https://image.getbarrel.com/data/barrel_data/images/banner/966/2019_down_main_bn.jpg" alt="" class="swiper-lazy">-->
                            <!--</figure>-->
                            <!--<div class="swiper-lazy-preloader">3</div>-->
                        <!--</a>-->
                    <!--</div>-->
                    <!--<div class="swiper-slide mainSlider__item">-->
                        <!--<a href="<?php echo $TPL_V1["bannerLink"]?>">-->
                            <!--<figure>-->
                                <!--&lt;!&ndash;<img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">&ndash;&gt;-->
                                <!--<img src="https://image.getbarrel.com/data/barrel_data/images/banner/75/2019_brgirl_risabae_main_bn_w_독립몰.jpg" alt="" class="swiper-lazy">-->
                            <!--</figure>-->
                            <!--<div class="swiper-lazy-preloader">3</div>-->
                        <!--</a>-->
                    <!--</div>-->
                    <!--<div class="swiper-slide mainSlider__item">-->
                        <!--<a href="<?php echo $TPL_V1["bannerLink"]?>">-->
                            <!--<figure>-->
                                <!--&lt;!&ndash;<img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">&ndash;&gt;-->
                                <!--<img src="https://image.getbarrel.com/data/barrel_data/images/banner/74/190722_ohyeah_mbn_독립몰.jpg" alt="" class="swiper-lazy">-->
                            <!--</figure>-->
                            <!--<div class="swiper-lazy-preloader">3</div>-->
                        <!--</a>-->
                    <!--</div>-->

<?php }}?>
                </div>
            </div>
            <div class="mainSlider__control">
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
                    <span class="mainSlider__page__wrap"><span class="mainSlider__page__now">1</span>/<span class="mainSlider__page__total"><?php echo count($TPL_VAR["mainBannerInfo"])?></span></span>
                    <a href="#" class="mainSlider__auto">
                        <span class="mainSlider__auto--play">play</span>
                        <span class="mainSlider__auto--stop">stop</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php }?>

<?php if($TPL_VAR["mainMovieBannerInfo"]){?>
    <section class="fb__main__video" id="devBackGroundImg" style="background-image:url(<?php echo $TPL_VAR["mainMovieBackGroundImg"]?>);">
        <div class="mainVideo">
<?php if($TPL_mainMovieBannerInfo_1){foreach($TPL_VAR["mainMovieBannerInfo"] as $TPL_V1){?>
            <div class="mainVideo__content">
                <div class="mainVideo__inner">
                    <!-- 해당 hidden 영역의 이미지를 이용하여 백그라운드 이미지 처리 필요 -->
                    <!--<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/img-video-sample.jpg" alt="">-->
                    <iframe width="100%" height="365" src="<?php echo $TPL_V1["banner_html"]?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            <h3 class="mainVideo__title">
                <?php echo $TPL_V1["banner_name"]?>

                <b><?php echo $TPL_V1["shot_title"]?></b>
            </h3>
            <p class="mainVideo__summary">
                <?php echo nl2br($TPL_V1["banner_desc"])?>

            </p>
<?php }}?>
            <a href="/brand/visual" class="mainVideo__link">
                More video
            </a>
        </div>
    </section>
<?php }?>
    <div class="pubFloaingLine"></div>

<?php if($TPL_VAR["mainBestBannerInfo"]){?>
    <section class="fb__main__best">
        <h3 class="fb__title">
            Best Items

        </h3>
        <div class="bestSlider">
            <div class="bestSlider__slider swiper-container">
                <div class="swiper-wrapper">
<?php if($TPL_mainBestBannerInfo_1){foreach($TPL_VAR["mainBestBannerInfo"] as $TPL_V1){?>
                    <div class="swiper-slide bestSlider__list">
                        <a href="<?php echo $TPL_V1["bannerLink"]?>">
                                <!--<img data-src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>" class="swiper-lazy">-->
                                <img  data-src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>"  class="swiper-lazy">
                            <div class="bestSlider__list__title">
                                <p><span class="text"><?php echo $TPL_V1["banner_name"]?></span><span class="subtext"><?php echo $TPL_V1["shot_title"]?></span></p>
                            </div>
                            <div class="swiper-lazy-preloader"></div>
                        </a>
                    </div>
<?php }}?>
                    <div class="swiper-slide bestSlider__list bestSlider__list--last"></div>
                </div>
            </div>
            <div class=" mainSlider__control bestSlider__control">
                <div class="bestSlider__arrow">
                    <a href="#" class="bestSlider__arrow--prev">
                        prev
                    </a>
                    <a href="#" class="bestSlider__arrow--next">
                        next
                    </a>
                </div>
                <!--<div class="bestSlider__dot mainSlider__dot"></div>-->
            </div>
        </div>
    </section>
<?php }?>

<?php if($TPL_VAR["mainNewProductBannerInfo"]||$TPL_VAR["mainNewProductType2BannerInfo"]){?>
    <section class="fb__main__new">
        <h3 class="fb__title">
            Barrel NEW
        </h3>
        <div class="new">
<?php if($TPL_VAR["mainNewProductBannerInfo"]){?>
            <div class="new__banner">
<?php if($TPL_mainNewProductBannerInfo_1){foreach($TPL_VAR["mainNewProductBannerInfo"] as $TPL_V1){?>
                <div class="new__banner__list">
                    <a href="<?php echo $TPL_V1["bannerLink"]?>">
                        <figure>
                            <img  src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading_960.gif" data-src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                        </figure>
                        <span class="new__banner__text <?php if($TPL_V1["banner_text_reversal"]== 0){?> new__banner__text--white <?php }elseif($TPL_V1["banner_text_reversal"]== 1){?> new__banner__text--black <?php }elseif($TPL_V1["banner_text_reversal"]== 2){?> new__banner__text--white2 <?php }elseif($TPL_V1["banner_text_reversal"]== 3){?> new__banner__text--black2 <?php }else{?> new__banner__text--black <?php }?>">
                        <!--<span class="new__banner__text new__banner__text--black">-->
                            <span class="new__banner__text--title"><?php echo $TPL_V1["banner_name"]?></span>
                            <span class="new__banner__text--desc"><?php echo $TPL_V1["shot_title"]?></span>
                            <span class="new__banner__text--btn">Detail</span>
                        </span>
                    </a>
                </div>
<?php }}?>
            </div>
<?php }?>
<?php if($TPL_VAR["mainNewProductType2BannerInfo"]){?>
            <div class="newSlider">
                <div class="newSlider__slider swiper-container">
                    <div class="swiper-wrapper">
<?php if($TPL_mainNewProductType2BannerInfo_1){foreach($TPL_VAR["mainNewProductType2BannerInfo"] as $TPL_V1){?>
                        <div class="newSlider__list swiper-slide">
                            <a href="<?php echo $TPL_V1["bannerLink"]?>">
                                <figure>
                                    <!--<img data-src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>" class="swiper-lazy">-->
                                    <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                                </figure>
                                <span class="newSlider__banner__text slide__banner__text--black">
                                    <span class="newSlider__banner__text--title<?php echo $TPL_V1["banner_text_reversal"]?>"><?php echo $TPL_V1["banner_name"]?></span>
                                    <span class="newSlider__banner__text--desc<?php echo $TPL_V1["banner_text_reversal"]?>"><?php echo $TPL_V1["shot_title"]?></span>
                                    <span class="newSlider__banner__text--btn<?php echo $TPL_V1["banner_text_reversal"]?>">Detail</span>
                                </span>
                                <!--<div class="swiper-lazy-preloader"></div>-->
                            </a>
                        </div>
<?php }}?>
                    </div>
                </div>
                <div class="fb__main__slider newSlider__control">
                    <div class=" mainSlider__control">
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
                            <span class="mainSlider__page__wrap"><span class="mainSlider__page__now">1</span>/<span class="mainSlider__page__total"><?php echo count($TPL_VAR["mainNewProductType2BannerInfo"])?></span></span>
                            <a href="#" class="mainSlider__auto">
                                <span class="mainSlider__auto--play">play</span>
                                <span class="mainSlider__auto--stop">stop</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
<?php }?>
        </div>
    </section>
<?php }?>

<?php if($TPL_VAR["mainEventBannerInfo"]){?>
    <section  class="fb__main__event">
        <h3 class="fb__title--hidden">
            Barrel EVEVNT
        </h3>

        <div class="event">
            <div class="event__inner">
                <div class="event__slider swiper-container">
                    <div class="swiper-wrapper">
<?php if($TPL_mainEventBannerInfo_1){$TPL_I1=-1;foreach($TPL_VAR["mainEventBannerInfo"] as $TPL_V1){$TPL_I1++;?>
                        <div class="swiper-slide event__slider__list">
                            <a href="#eventView<?php echo $TPL_I1?>">
                                <figure>
                                    <img src="<?php echo $TPL_V1["imgSrcOn"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                                </figure>
                                <div class="event__bg">
                                    <p>
<?php if($TPL_V1["shot_title"]){?>
                                        <?php echo $TPL_V1["shot_title"]?><br>
<?php }?>
                                        <?php echo $TPL_V1["banner_name"]?>

                                    </p>
                                </div>
                            </a>
                        </div>
<?php }}?>
                    </div>
                </div>
            </div>
            <div class="fb__main__slider event__control">
                <div class=" mainSlider__control">
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
                </div>
            </div>

            <div class="event__detail">
<?php if($TPL_mainEventBannerInfo_1){$TPL_I1=-1;foreach($TPL_VAR["mainEventBannerInfo"] as $TPL_V1){$TPL_I1++;?>
                <div class="event__detail__view" id="eventView<?php echo $TPL_I1?>" style="<?php if($TPL_I1== 0){?>display:block;<?php }else{?>display:none<?php }?>">
                    <a href="<?php echo $TPL_V1["bannerLink"]?>">
                        <figure>
                            <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["shot_title"]?> <?php echo $TPL_V1["banner_name"]?>">
                        </figure>
                    </a>
                </div>

<?php }}?>
            </div>

        </div>
    </section>
<?php }?>

<?php if($TPL_VAR["mainBarrelUserBannerInfo"]){?>
    <section class="fb__main__user">
        <h3 class="fb__title">
            Barrel USER
        </h3>
        <div class="user">
            <div class="user__slider swiper-container" data-src='<?php echo $TPL_VAR["mainBarrelUserJson"]?>'>
                <div class="swiper-wrapper">
<?php if($TPL_mainBarrelUserBannerInfo_1){foreach($TPL_VAR["mainBarrelUserBannerInfo"] as $TPL_V1){?>
                    <div class="swiper-slide user__list">
                        <a href="#" data-id="<?php echo $TPL_V1["shot_title"]?>" data-summary="<?php echo nl2br($TPL_V1["banner_desc"])?>" data-name="<?php echo $TPL_V1["banner_name"]?>" data-src="<?php echo $TPL_V1["imgSrc"]?>">
                            <figure data-title="Detail">
                                <img data-src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>" class="swiper-lazy">
                            </figure>
                            <div class="swiper-lazy-preloader"></div>
                        </a>
                    </div>
<?php }}?>
                </div>
            </div>
            <div class="fb__main__slider user__control">
                <div class=" mainSlider__control">
                    <div class="mainSlider__arrow">
                        <a href="#" class="mainSlider__arrow--prev">
                            prev
                        </a>
                        <a href="#" class="mainSlider__arrow--next">
                            next
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }?>
<?php if($TPL_VAR["mainDisplayGroup"]){?>
    <section class="fb__main__goods bg">
<?php if($TPL_mainDisplayGroup_1){foreach($TPL_VAR["mainDisplayGroup"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["details"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
        <div class="goods devDisplayGroup" data-group_code="<?php echo $TPL_V2["group_code"]?>">
        <h3 class="fb__title" >
            <?php echo $TPL_V2["group_name"]?>

        </h3>
<?php if($TPL_V2["getPromotionBanner"]){?>
            <div data-slider-target="bgSlider__select--<?php echo $TPL_V2["group_code"]?>" class="bgSlider__select--<?php echo $TPL_V2["group_code"]?> bgSlider bgslide<?php echo $TPL_V2["group_code"]?> ">
                <div class="bgSlider__slider swiper-container">
                    <div class="swiper-wrapper">
<?php if(is_array($TPL_R3=$TPL_V2["getPromotionBanner"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                        <div class="bgSlider__list swiper-slide">
                            <a href="<?php echo $TPL_V3["bannerLink"]?>">
                                <figure>
                                    <!-- <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/sample/banner.png" alt="<?php echo $TPL_V3["banner_name"]?>"> -->
                                    <img src="<?php echo $TPL_V3["imgSrc"]?>" alt="<?php echo $TPL_V3["banner_name"]?>" class="swiper-lazy">
                                </figure>
                                <!--<div class="swiper-lazy-preloader"></div>-->
                            </a>
                        </div>
<?php }}?>
                    </div>
                </div>
                <div class="fb__main__slider bgSlider__control">
                    <div class="mainSlider__control">
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
                            <span class="mainSlider__page__wrap"><span class="mainSlider__page__now">1</span>/<span class="mainSlider__page__total"><?php echo count($TPL_V2["getPromotionBanner"])?></span></span>
                            <a href="#" class="mainSlider__auto">
                                <span class="mainSlider__auto--play">play</span>
                                <span class="mainSlider__auto--stop">stop</span>
                            </a>
                        </div>
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

            <div class="fb__main__goods fb__main__goodsInner">
                <ul class=" fb__goods  three-boxes-wrap " id="devListContents_<?php echo $TPL_V2["group_code"]?>">
                    <li class="devForbizTpl" id="devListLoading_<?php echo $TPL_V2["group_code"]?>"></li>
                    <li class="devForbizTpl" id="devListEmpty_<?php echo $TPL_V2["group_code"]?>">There is no registered product.</li>
                    <li class="fb__goods__list devForbizTpl" id="devListDetail_<?php echo $TPL_V2["group_code"]?>">
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
                                <span class="fb__goods__sale">
                                    <p class="per"><em class="is_soldout">Out of stock</em></p>
                                </span>
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
                        <a href="#" class="product-box__heart {[#if alreadyWish]}product-box__heart--active{[/if]}" data-fatid="{[id]}" data-devWishBtn="{[id]}">
                            hart
                        </a>
                    </li>
                </ul>
                <div class="fb__goods__add">
                    <div id="devPageWrap_<?php echo $TPL_V2["group_code"]?>"></div>
                    <!--<div id="devPageWrap_<?php echo $TPL_V2["group_code"]?>"></div>-->
                    <!--<button class="fb__goods__btn fb__goods__btn&#45;&#45;<?php echo $TPL_V2["group_code"]?>" data-page="2" data-group="<?php echo $TPL_V2["group_code"]?>">-->
                        <!--<span>View more</span>-->
                    <!--</button>-->
                </div>
            </div>
        </div>
<?php }}?>
<?php }}?>
    </section>
<?php }?>
    <div class="popup-bg"></div>
</section>


<!-- cre.ma / 리뷰 작성 유도 팝업 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
<div class="crema-popup"></div>