<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/goods_best/goods_best.htm 000007808 */ 
$TPL_bestBannerInfo_1=empty($TPL_VAR["bestBannerInfo"])||!is_array($TPL_VAR["bestBannerInfo"])?0:count($TPL_VAR["bestBannerInfo"]);
$TPL_promotionArea_1=empty($TPL_VAR["promotionArea"])||!is_array($TPL_VAR["promotionArea"])?0:count($TPL_VAR["promotionArea"]);?>
<section class="br__main br__goods-best">
<?php if($TPL_VAR["bestBannerInfo"]){?>
<section class="br__main__top-slide">
    <h3 class="br__hidden">Upper Slide</h3>
    <div class="br__slide br__slide--type1">
        <div class="swiper-container">
            <ul class="swiper-wrapper">
<?php if($TPL_bestBannerInfo_1){foreach($TPL_VAR["bestBannerInfo"] as $TPL_V1){?>
                <li class="swiper-slide">
                    <div class="slide-content">
                        <a class="slide-content__link" href="<?php echo $TPL_V1["bannerLink"]?>">
                            <figure class="slide-content__thumb">
                                <!--<img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">-->
                                <img src="https://image.getbarrel.com/data/barrel_data/images/banner/991/2019_down_main_bn_m.jpg" alt="<?php echo $TPL_V1["banner_name"]?>">
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
<?php if($TPL_VAR["promotionArea"]){?>
<?php if($TPL_promotionArea_1){foreach($TPL_VAR["promotionArea"] as $TPL_V1){?>
        <div class="tnb-wrap">
            <!--<button type="button" class="br__title-box__back">뒤로가기</button>-->
            <!--<h2 class="br__title-box__title"><button type="button"><?php if($TPL_V1["pg_title"]){?> <?php echo $TPL_V1["pg_title"]?> <?php }else{?> noTitle <?php }?></button></h2>-->
            <nav id="goods-best-category__wrapper" class="fb__goods-list__menu fb__goods-best__tnb">
<?php if(is_array($TPL_R2=$TPL_V1["products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["goods"]){?>
				<a href="#best-contents_<?php echo $TPL_V2["group_code"]?>" class="fb__goods-best__tnb-list <?php echo $TPL_V2["index"]?>">
					<?php echo $TPL_V2["group_name"]?>

				</a>
<?php }?>
<?php }}?>
			</nav>
        </div>
        <section class="br__goods-list best-contents">
<?php if(is_array($TPL_R2=$TPL_V1["products"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["goods"]){?>
                <div class="br__slide br__slide--type1 br__slide__best-goods" id="best-contents_<?php echo $TPL_V2["group_code"]?>">
					<h4 class="best-cate__title"><?php echo $TPL_V2["group_name"]?></h4>
                    <div class="br__goods-list__wrap br__goods-list__wrap--normal">
                        <!-- <p class="best-contents__title"><?php echo $TPL_V2["group_name"]?></p> -->
                        <div class="goods-list best-contents__box">
                            <ul class="goods-list__list" id="devListContents">
<?php if(is_array($TPL_R3=$TPL_V2["goods"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                                <li class="goods-list__box" id="devListDetail">
                                    <a href="/shop/goodsView/<?php echo $TPL_V3["id"]?>" class="goods-list__link">
                                        <figure class="goods-list__thumb">
<?php if($TPL_V3["timeSaleIconView"]){?>
                                            <img src="<?php echo $TPL_V3["timeSaleIcon"]?>" class="goods-list__time-deal" >
<?php }?>
                                            <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="<?php echo $TPL_V3["image_src"]?>" alt="<?php echo $TPL_V3["pname"]?>">
                                        </figure>
                                        <div class="goods-list__info">

                                            <div class="goods-list__badge">
<?php if($TPL_V3["icons_path"]){?>
<?php if(is_array($TPL_R4=$TPL_V3["icons_path"])&&!empty($TPL_R4)){foreach($TPL_R4 as $TPL_V4){?>
                                                <span><?php echo $TPL_V4?></span>
<?php }}?>
<?php }?>
                                            </div>

                                            <p class="br__goods__pre"><?php echo $TPL_V3["preface"]?></p>
                                            <p class="goods-list__title"><?php echo $TPL_V3["pname"]?></p>
                                            <span class="goods-list__color"><?php echo $TPL_V3["add_info"]?></span>
                                            <div class="goods-list__price">
                                                <span class="goods-list__price__discount"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V3["dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php if($TPL_V3["isDiscount"]){?>
                                                <span class="goods-list__price__cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php if($TPL_V3["isDiscount"]){?><?php echo g_price($TPL_V3["listprice"])?><?php }?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
<?php }?>
<?php if($TPL_V3["is_soldout"]){?>
                                                    <span class="goods-list__price__state">Out of stock</span>
<?php }else{?>
<?php if($TPL_V3["discount_rate"]){?>
                                                        <span class="goods-list__price__percent"><span><?php echo $TPL_V3["discount_rate"]?></span>%</span>
<?php }?>
<?php }?>
                                            </div>
                                        </div>
                                    </a>
                                    <label class="goods-list__wish<?php if($TPL_V3["alreadyWish"]){?> on<?php }?>" devwishbtn="<?php echo $TPL_V3["id"]?>">
<?php if($TPL_V3["alreadyWish"]){?>
                                        <input type="checkbox" class="goods-list__wish__btn" checked>
<?php }else{?>
                                        <input type="checkbox" class="goods-list__wish__btn">
<?php }?>
                                    </label>
                                </li>
<?php }}?>
                            </ul>
                        </div>
                    </div>
                </div>
<?php }?>
<?php }}?>
        </section>
<?php }}?>
<?php }else{?>
    <div class="empty-content">
        <p>No registered product.</p>
    </div>
<?php }?>
</section>