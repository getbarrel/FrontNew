<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/shop/goods_best/goods_best.htm 000008241 */ 
$TPL_bestBannerInfo_1=empty($TPL_VAR["bestBannerInfo"])||!is_array($TPL_VAR["bestBannerInfo"])?0:count($TPL_VAR["bestBannerInfo"]);
$TPL_promotionArea_1=empty($TPL_VAR["promotionArea"])||!is_array($TPL_VAR["promotionArea"])?0:count($TPL_VAR["promotionArea"]);?>
<section class="fb__goods-list fb__goods-best">

    <h3 class="fb__goods-best__title">BEST </h3>

<?php if($TPL_VAR["bestBannerInfo"]){?>
    <section class="fb__main__slider fb__main__visual fb__main__slider__gap fb__best__slider">
        <h3 class="fb__title--hidden">
            main slider
        </h3>
        <div class="newSlider mainVisual">
            <div class="newSlider__slider swiper-container">
                <div class="swiper-wrapper">
<?php if($TPL_bestBannerInfo_1){foreach($TPL_VAR["bestBannerInfo"] as $TPL_V1){?>
                    <div class="swiper-slide newSlider__list">
                        <a href="<?php echo $TPL_V1["bannerLink"]?>">
                            <figure>
                                <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                            </figure>
                        </a>
                    </div>
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
<?php if($TPL_VAR["promotionArea"]){?>
<?php if($TPL_promotionArea_1){foreach($TPL_VAR["promotionArea"] as $TPL_V1){?>

         <div class="fb__main__slider__wrap">
             <section class="fb__goods-list__nav <?php if(!$TPL_VAR["bannerData"]){?> fb__goods-list__nav--mt <?php }?>">
                 <!--<h3 class="fb__goods-list__title"><?php if($TPL_V1["pg_title"]){?> <?php echo $TPL_V1["pg_title"]?> <?php }else{?> noTitle <?php }?></h3>-->
                 <nav id="goods-best-category__wrapper" class="fb__goods-list__menu fb__goods-best__tnb">
<?php if(is_array($TPL_R2=$TPL_V1["products"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_V2["goods"]){?>
                     <a href="#best-contents_<?php echo $TPL_V2["group_code"]?>" class="fb__goods-best__tnb-list <?php if($TPL_I2== 0){?> fb__goods-best__tnb-list--active <?php }?>">
                         <?php echo $TPL_V2["group_name"]?>

                         <?php echo $TPL_V2["index"]?>

                     </a>
<?php }?>
<?php }}?>
                 </nav>
             </section>
<?php if(is_array($TPL_R2=$TPL_V1["products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
            <section id="best-contents_<?php echo $TPL_V2["group_code"]?>" class="fb__goods-list__contents best-contents" >
<?php if($TPL_V2["goods"]){?>
                <div class="list-contents best-contents__inner" id="tab_<?php echo $TPL_V2["group_code"]?>" >
                    <div class="fb__main__goods  product-box three-boxes-wrap">
                        <p class="best-contents__title"><?php echo $TPL_V2["group_name"]?></p>
                        <ul class="fb__main__fb__goods fb__goods best-contents__box"  id="devListContents">
<?php if(is_array($TPL_R3=$TPL_V2["goods"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                            <li class="fb__goods__list" id="devListDetail" data-fatid="<?php echo $TPL_V3["id"]?>">
                                <a href="/shop/goodsView/<?php echo $TPL_V3["id"]?>" class="fb__goods__link">
                                    <figure class="fb__goods__img">
<?php if($TPL_V3["timeSaleIconView"]){?>
                                        <img src="<?php echo $TPL_V3["timeSaleIcon"]?>" class="product-box__time-deal" >
<?php }?>
                                        <div>
                                            <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="<?php echo $TPL_V3["image_src"]?>">
                                        </div>
                                    </figure>
                                    <div class="fb__goods__info">
                                        <div class="fb__badge">
<?php if($TPL_V3["icons_path"]){?>
<?php if(is_array($TPL_R4=$TPL_V3["icons_path"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
                                            <span class="fb__badge--water">
                                                <?php echo $TPL_V4?>

                                            </span>
<?php }}?>
<?php }?>
                                        </div>
                                        <ul class="fb__goods__infoBox">
                                            <li class="fb__goods__pre">
                                                <?php echo $TPL_V3["preface"]?>

                                            </li>
                                            <li class="fb__goods__name">
                                                <?php echo $TPL_V3["pname"]?>

                                            </li>
                                            <li class="fb__goods__option">
                                                <?php echo $TPL_V3["add_info"]?>

                                            </li>
                                            <li class="fb__goods__brand">
                                                <?php echo $TPL_V3["brand_name"]?>

                                            </li>
                                        </ul>

                                    </div>
                                </a>
                                <div class="fb__goods__important">
                                    <span class="fb__goods__price">
                                        <em><?php echo g_price($TPL_V3["dcprice"])?></em>
                                    </span>
                                    <span class="fb__goods__noprice">
<?php if($TPL_V3["isDiscount"]){?><?php echo g_price($TPL_V3["listprice"])?><?php }?>
                                    </span>
<?php if($TPL_V3["is_soldout"]){?>
                                    <span class="fb__goods__price__state">Out of stock</span>
<?php }else{?>
<?php if($TPL_V3["discount_rate"]){?>
                                        <span class="fb__goods__sale">
                                            <p class="per"><em><?php echo $TPL_V3["discount_rate"]?></em>%</p>
                                        </span>
<?php }?>
<?php }?>
                                </div>
                                <a href="#" class="product-box__heart <?php if($TPL_V3["alreadyWish"]){?>product-box__heart--active<?php }?>" data-devWishBtn="<?php echo $TPL_V3["id"]?>">
                                    hart
                                </a>
                            </li>
<?php }}?>
                        </ul>
                    </div>
                </div>
<?php }?>
            </section>
<?php }}?>
<?php }}?>
        </div>
<?php }else{?>
        <div class="fb__main__slider__wrap">
            <section class="fb__goods-list__contents best-contents" >
                <div style="text-align: center;" >
                No registered product.
                </div>
            </section>
        </div>
<?php }?>
</section>