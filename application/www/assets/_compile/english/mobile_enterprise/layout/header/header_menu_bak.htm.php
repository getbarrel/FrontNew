<?php /* Template_ 2.2.8 2021/09/17 11:22:05 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/layout/header/header_menu_bak.htm 000019420 */ ?>
<style>
    .crema-type .br__drawer__global .global-box__select__btn {font-size:13px;}
    .crema-type .br__drawer__global .global-box__select__list li a {font-size:13px; padding-right:0.35rem; text-align:center;}
</style>

<section class="br__dockbar">
    <ul class="br__dockbar__list">
        <li class="dockbar-list">
            <button class="dockbar-list__btn dockbar-list__btn--category">category</button>
        </li>
        <li class="dockbar-list <?php if($_SERVER['PHP_SELF']=='/index.php/mypage/orderHistory'){?>dockbar-list--active<?php }?>">
            <a href="/mypage/orderHistory" class="dockbar-list__btn dockbar-list__btn--delivery">Shipping check</a>
        </li>
        <li class="dockbar-list <?php if($_SERVER['PHP_SELF']=='/index.php'){?>dockbar-list--active<?php }?>">

            <a href="/" class="dockbar-list__btn dockbar-list__btn--home"><?php if($TPL_VAR["langType"]=='english'){?>HOME<?php }else{?>BARREL HOME<?php }?></a>
        </li>
        <li class="dockbar-list <?php if($_SERVER['PHP_SELF']=='/mypage/index.php'){?>dockbar-list--active<?php }?>">
            <a href="/mypage/" class="dockbar-list__btn dockbar-list__btn--mypage">My page</a>
        </li>
        <li class="dockbar-list">
            <button class="dockbar-list__btn dockbar-list__btn--recent open-layer__recent-view" data-title="Recently viewed product"><?php if($TPL_VAR["langType"]=='english'){?>Viewed<?php }else{?>Recently viewed product<?php }?></button>
        </li>
    </ul>
</section>


<section class="br__drawer">
    <h2 class="hidden">drawer menu</h2>
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
    <h3 class="br__drawer__script"><strong>Hello <?php echo $TPL_VAR["layoutCommon"]["userInfo"]["name"]?> </strong></h3>
<?php }else{?>
    <p class="br__drawer__script">
        <a href="/member/login">Sign in, Please.</a>
    </p>
<?php }?>
    <div class="br__drawer__scroll">
        <section class="br__drawer__goods">
            <div class="br__drawer__user">
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
                <div class="user-info">
                    <ul class="user-info__box">
                        <li class="user-info__list">
                            <a href="/mypage/" class="user-info__list--mypage"><span class="text">My <br>Page</span></a>
                        </li>
                        <li class="user-info__list">
                            <a href="/mypage/orderHistory" class="user-info__list--history"><span class="text">Your Orders</span></a>
                        </li>
                        <li class="user-info__list">
                            <a href="/mypage/wishlist" class="user-info__list--wishlist">
                                <span class="text">Wish<br>List</span>
                                <span class="count"><?php echo $TPL_VAR["headerMenu"]["totalWish"]?></span>
                                <span class="unit eng-hidden">ltem(s)</span>
                            </a>
                        </li>
                        <li class="user-info__list">
                            <a href="/mypage/coupon" class="user-info__list--coupon">
                                <span class="text">My Coupons</span>
                                <span class="count"><?php echo $TPL_VAR["headerMenu"]["totalCoupon"]?></span>
                                <span class="unit eng-hidden"> </span>
                            </a>
                        </li>
                    </ul>
                </div>
<?php }else{?>
                <div class="user-info">
                    <p class="user-info__join-script">To take advantage of the benefits of BARREL: <br><a href="/member/login">Sign in/Join</a> required</p>
                </div>
<?php }?>
            </div>
            <!--<a href="http://socal.cafe24.com" class="br__main__before eng-hidden" target="_blank">-->
                <!--<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/banner-before-site-m.png" width="100%" alt="">-->
            <!--</a>-->
            <div class="br__drawer__menu br__drawer__menu--folding"><!-- toggle : br__drawer__menu--folding -->
                <button class="br__drawer__menu--resize">Menu Sizing Button</button>
                <div class="drawer_menu ">
                    <ul class="drawer__menu__box">
                        <li class="drawer__menu__list drawer__menu__campaign">
                            <a href="#">
                                <figure class="drawer__menu__thumb">
                                    <img src="https://image.getbarrel.com/data/barrel_data/images/menu/img-menu-ch.jpg">
                                </figure>
                                <span class="drawer__menu__text">SPORTS CAMPAIGN</span>
                            </a>
                        </li>
<?php if(is_array($TPL_R1=$TPL_VAR["headerMenu"]["leftTopList"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if($TPL_V1["banner_name"]=='위드배럴'){?>
                                <li class="drawer__menu__list drawer__menu__list--withbarrel">
                                    <label for="withbarrel">
                                        <figure class="drawer__menu__thumb">
                                            <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                                        </figure>
                                        <span class="drawer__menu__text"><?php echo $TPL_V1["banner_name"]?></span>
                                    </label>
                                    <select id="withbarrel">
                                        <option value="#1">Option 1</option>
                                        <option value="#2">Option 2</option>
                                    </select>
                                </li>
<?php }else{?>
                                <li class="drawer__menu__list 12312312">
                                    <a href="<?php echo $TPL_V1["bannerLink"]?>">
                                        <figure class="drawer__menu__thumb">
                                            <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                                        </figure>
                                        <span class="drawer__menu__text"><?php echo $TPL_V1["banner_name"]?></span>
                                    </a>
                                </li>
<?php }?>
<?php }}?>
                    </ul>
                </div>
            </div>

            <div class="br__drawer__cate">
                <div class="cate-box cate-box--depth1 cate-box--active">
                    <div class="cate-box__navi">
                        <button class="cate-box__navi__back">go back to category</button>
                        <button class="cate-box__navi__category"><span>Main</span></button>
                    </div>
                    <ul class="cate-box__wrapper">
<?php if(is_array($TPL_R1=$TPL_VAR["headerMenu"]["categoryList"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                            <li class="cate-box__list" data-cid="<?php echo $TPL_V1["cid"]?>">
<?php if(!empty($TPL_V1["subCateList"])){?>
									<button class="cate-box__list__category" <?php if($TPL_V1["is_layout_emphasis"]=="Y"){?>style="font-weight: 900;"<?php }?>><?php echo $TPL_V1["cname"]?><?php if($TPL_V1["is_layout_emphasis"]=="Y"){?><font style="color:#00BCE7">*</font><?php }?></button>
<?php }else{?>
<?php if($TPL_V1["category_type"]=="C"){?>
										<a href="/shop/goodsList/<?php echo $TPL_V1["cid"]?>" class="cate-box__list__category"><?php echo $TPL_V1["cname"]?></a>
<?php }else{?>
										<a href="<?php echo $TPL_V1["category_link"]?>" class="cate-box__list__category"><?php echo $TPL_V1["cname"]?></a>
<?php }?>
<?php }?>
                            </li>
<?php }}?>
                        <li class="cate-box__list"  data-cid="brandList">
                            <button class="cate-box__list__category">About Us</button>
                        </li>
                    </ul>
                </div>
<?php if(is_array($TPL_R1=$TPL_VAR["headerMenu"]["categoryList"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                <div id="<?php echo $TPL_V1["cid"]?>" class="cate-box cate-box--depth2" data-depth="<?php echo $TPL_V1["depth"]?>">
                    <div class="cate-box__navi">
                        <button class="cate-box__navi__back">go back to category</button>
                        <button class="cate-box__navi__category cate-box__go__main"><span>Main</span></button>
                        <button class="cate-box__navi__category cate-box__go__cate" data-cid="<?php echo $TPL_V1["cid"]?>"><span><?php echo $TPL_V1["cname"]?></span></button>
                    </div>
                    <ul class="cate-box__wrapper">
                        <li class="cate-box__list">
<?php if($TPL_V1["category_type"]=="C"){?>
								<a href="/shop/goodsList/<?php echo $TPL_V1["cid"]?>" class="cate-box__list__category"><?php echo $TPL_V1["cname"]?> All</a>
<?php }else{?>
								<a href="<?php echo $TPL_V1["category_link"]?>" class="cate-box__list__category"><?php echo $TPL_V1["cname"]?> All</a>
<?php }?>
                        </li>
<?php if(is_array($TPL_V1["subCateList"])){?>
<?php if(is_array($TPL_R2=$TPL_V1["subCateList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                        <li class="cate-box__list" data-cid="<?php echo $TPL_V2["cid"]?>">
<?php if(!empty($TPL_V2["subCateList"])){?>
                            <button class="cate-box__list__category" <?php if($TPL_V2["is_layout_emphasis"]=="Y"){?>style="font-weight: 900;"<?php }?>><?php echo $TPL_V2["cname"]?> <?php if($TPL_V2["is_layout_emphasis"]=="Y"){?><font style="color:#00BCE7">*</font><?php }?></button>
<?php }else{?>
<?php if($TPL_V2["category_type"]=="C"){?>
									<a href="/shop/goodsList/<?php echo $TPL_V2["cid"]?>" class="cate-box__list__category" <?php if($TPL_V2["is_layout_emphasis"]=="Y"){?>style="font-weight: 900;"<?php }?>><?php echo $TPL_V2["cname"]?> <?php if($TPL_V2["is_layout_emphasis"]=="Y"){?><font style="color:#00BCE7">*</font><?php }?></a>
<?php }else{?>
									<a href="<?php echo $TPL_V2["category_link"]?>" class="cate-box__list__category" <?php if($TPL_V2["is_layout_emphasis"]=="Y"){?>style="font-weight: 900;"<?php }?>><?php echo $TPL_V2["cname"]?> <?php if($TPL_V2["is_layout_emphasis"]=="Y"){?><font style="color:#00BCE7">*</font><?php }?></a>
<?php }?>
<?php }?>
                        </li>
<?php }}?>
<?php }?>
                    </ul>
                </div>
<?php }}?>
                <div id="brandList" class="cate-box cate-box--depth2" data-depth="0">
                    <div class="cate-box__navi">
                        <button class="cate-box__navi__back">go back to category</button>
                        <button class="cate-box__navi__category cate-box__go__main"><span>Main</span></button>
                        <button class="cate-box__navi__category cate-box__go__cate" data-cid="brandList"><span>About Us</span></button>
                    </div>
                    <ul class="cate-box__wrapper cate-box__brand">
<?php if(is_array($TPL_R1=$TPL_VAR["headerMenu"]["leftBrandStory"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                        <li class="cate-box__list cate-box__brand__list">
                            <a href="<?php echo $TPL_V1["bannerLink"]?>" class="cate-box__list__category">
                                <figure class="cate-box__brand__thumb">
                                    <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                                </figure>
                                <div class="cate-box__brand__info">
                                    <p class="cate-box__brand__title"><?php echo $TPL_V1["banner_name"]?></p>
                                    <span class="cate-box__brand__sub"><?php echo $TPL_V1["shot_title"]?></span>
                                </div>
                            </a>
                        </li>
<?php }}?>
                    </ul>
                </div>

<?php if(is_array($TPL_R1=$TPL_VAR["headerMenu"]["categoryList"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["subCateList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <div id="<?php echo $TPL_V2["cid"]?>" class="cate-box cate-box--depth3" data-depth="<?php echo $TPL_V2["depth"]?>">
                        <div class="cate-box__navi">
                            <button class="cate-box__navi__back">go back to category</button>
                            <button class="cate-box__navi__category cate-box__go__main"><span>Main</span></button>
                            <button class="cate-box__navi__category cate-box__go__cate" data-cid="<?php echo $TPL_V1["cid"]?>"><span><?php echo $TPL_V1["cname"]?></span></button>
                            <button class="cate-box__navi__category"><span><?php echo $TPL_V2["cname"]?></span></button>
                        </div>
                        <ul class="cate-box__wrapper">
                            <li class="cate-box__list">
<?php if($TPL_V2["category_type"]=="C"){?>
									<a href="/shop/goodsList/<?php echo $TPL_V2["cid"]?>" class="cate-box__list__category"><?php echo $TPL_V2["cname"]?> (view all)</a>
<?php }else{?>
									<a href="<?php echo $TPL_V2["category_link"]?>" class="cate-box__list__category"><?php echo $TPL_V2["cname"]?> (view all)</a>
<?php }?>
                            </li>
<?php if(is_array($TPL_R3=$TPL_V2["subCateList"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                            <li class="cate-box__list" data-cid="<?php echo $TPL_V3["cid"]?>">
<?php if($TPL_V3["category_type"]=="C"){?>
									<a href="/shop/goodsList/<?php echo $TPL_V3["cid"]?>" class="cate-box__list__category"><?php echo $TPL_V3["cname"]?></a>
<?php }else{?>
									<a href="<?php echo $TPL_V3["category_link"]?>" class="cate-box__list__category"><?php echo $TPL_V3["cname"]?></a>
<?php }?>
                            </li>
<?php }}?>
                        </ul>
                    </div>
<?php }}?>
<?php }}?>
            </div>
        </section>

<?php if($TPL_VAR["langType"]=='korean'){?>
        <section class="br__drawer__guide">
            <div class="guide-box">
                <h3 class="guide-box__title">Membership Guide</h3>
                <p class="guide-box__desc">영문몰해당없음</p>
                <a href="/customer/storeInformation" class="guide-box__link">Store Information</a>
            </div>
        </section>
<?php }?>

        <section class="br__drawer__cscenter">
            <div class="cscenter-box">
<?php if($TPL_VAR["langType"]=='english'){?>
                <h3 class="cscenter-box__title">Contact us<br/><a href="mailto:en_help@getbarrel.com">en_help@getbarrel.com</a></h3>
<?php }else{?>
                <h3 class="cscenter-box__title">Customer Advise<a href="tel:<?php echo $TPL_VAR["companyInfo"]["cs_phone"]?>"><?php echo $TPL_VAR["companyInfo"]["cs_phone"]?></a></h3>
<?php }?>
<?php if($TPL_VAR["langType"]=='english'){?>
                <!--<p class="cscenter-box__desc"><?php echo nl2br($TPL_VAR["companyInfo"]["global_opening_time"])?></p>-->
<?php }else{?>
                <p class="cscenter-box__desc"><?php echo nl2br($TPL_VAR["companyInfo"]["opening_time"])?></p>
<?php }?>
                <!--
                <p class="cscenter-box__desc">Business day 10:00-1800/1300-1400 <span>(lunch)</span></p>
                <p class="cscenter-box__desc">Office closed on weekends and holidays</p>
                -->
                <a href="/customer/" class="cscenter-box__link">Customer Service Center</a>
            </div>
        </section>

        <style>
            .crema-type .br__drawer__sns .sns-box__list--kakao a {
                background-position-x: -14rem;
            }
        </style>

        <section class="br__drawer__sns">
            <div class="sns-box">
                <h3 class="sns-box__title">Social Media</h3>
                <p class="sns-box__desc">Get the news and events from Barrel quickly.</p>
                <ul class="sns-box__wrapper">
                    <li class="sns-box__list sns-box__list--instagram js__sns__open"><a class="js__sns__open" href="#insta">Instagram</a></li>
                    <li class="sns-box__list sns-box__list--facebook"><a href="https://www.facebook.com/pages/Barrel/1416024818648425">Facebook</a></li>
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <li class="sns-box__list sns-box__list--kakao"><a href="https://pf.kakao.com/_VxfxjDd">(english)카카오플친</a></li>
                    <li class="sns-box__list sns-box__list--blog"><a href="http://blog.naver.com/socal_kr">Blog</a></li>
<?php }?>
                    <li class="sns-box__list sns-box__list--youtube"><a href="https://www.youtube.com/c/getbarrel">Youtube</a></li>
                </ul>
            </div>
        </section>

        <section class="br__drawer__global">
            <div class="global-box">
                <h3 class="global-box__title">GLOBAL SITE</h3>
                <div class="global-box__select">
                    <button class="global-box__select__btn">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        KR<!-- <img src="/assets/mobile_templet/mobile_enterprise/dist/images/layout/icon_drawer_global_kr.png" alt="국기"> -->
<?php }elseif($TPL_VAR["langType"]=='english'){?>
                        EN<!-- <img src="/assets/mobile_templet/mobile_enterprise/dist/images/layout/icon_drawer_global_en.png" alt="국기"> -->
<?php }else{?>
                        CN<!-- <img src="/assets/mobile_templet/mobile_enterprise/dist/images/layout/icon_drawer_global_cn.png" alt="국기"> -->
<?php }?>
                    </button>
                    <ul class="global-box__select__list">
                        <li><a href="//www.getbarrel.com/"><!-- <img src="/assets/mobile_templet/mobile_enterprise/dist/images/layout/icon_drawer_global_kr.png" alt="국기"> -->KR</a></li>
                        <!--<li><a href="javascript:alert('영문몰 오픈 준비중입니다.');"><img src="/assets/mobile_templet/mobile_enterprise/dist/images/layout/icon_drawer_global_en.png" alt="국기"><span>EN</span></a></li>-->
                        <li><a href="//en.getbarrel.com/"><!-- <img src="/assets/mobile_templet/mobile_enterprise/dist/images/layout/icon_drawer_global_en.png" alt="국기"> -->EN</a></li>
                        <li><a href="/event/eventDetail/12"><!-- <img src="/assets/mobile_templet/mobile_enterprise/dist/images/layout/icon_drawer_global_cn.png" alt="국기"> -->CN</a></li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
<?php if($TPL_VAR["layoutCommon"]["appType"]){?>
    <!-- mobile App -->
    <div class="br__drawer__setting">
        <a href="/mypage/preferences" class="br__drawer__setting--btn">설정</a>
    </div>
<?php }?>
    <button class="br__drawer__close">Cancel</button>
</section>