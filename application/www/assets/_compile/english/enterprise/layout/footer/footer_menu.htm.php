<?php /* Template_ 2.2.8 2021/10/21 16:54:47 /home/barrel-stage/application/www/assets/templet/enterprise/layout/footer/footer_menu.htm 000011624 */ ?>
<style>
    .fb__footer__ectmenu .etc__global__country {margin:-2px 0 0 15px;}
    .fb__footer__ectmenu .etc__global__country a:before {display:none !important; font-size:15px; font-weight:500;}
    .fb__footer__ectmenu .etc__global__country .country__btn {color:#999;}
    .fb__footer__ectmenu .etc__global__country .country__btn--active {color:#fff;}
    .fb__footer__ectmenu .etc__global__country span {width:1px; color:#fff; display:inline-block; font-size:11px; padding:0 11px 0 5px; vertical-align:3px;}
</style>
<div class="fb__footer__ectmenu">
    <div class="etc fb__footer__inner">
        <nav class="etc__info">
            <a href="/corporateIR/IRResources">
                Corporate IR
            </a>
<?php if($TPL_VAR["langType"]=='english'){?>
            <a href="javascript:void(0)" onClick="common.util.popup('/company/agreement/agreement_global' ,600, 700,'',true);">
                Terms and Conditions
            </a>
<?php }else{?>
            <a href="javascript:void(0)" onClick="common.util.popup('/company/agreement' ,600, 700,'',true);">
                Terms and Conditions
            </a>
<?php }?>
<?php if($TPL_VAR["langType"]=='english'){?>
            <a href="javascript:void(0)" onClick="common.util.popup('/company/privacy/person_global',600,700,'',true);" style="color:#01acd8; font-weight:700;">
                Privacy Policy
            </a>
<?php }else{?>
            <a href="javascript:void(0)" onClick="common.util.popup('/company/privacy/person',600,700,'',true);" style="color:#01acd8; font-weight:700;">
                Privacy Policy
            </a>
<?php }?>
        </nav>
        <div class="etc__global">
            <span class="etc__global__title">
                Global Site
            </span>
            <nav class="etc__global__country">
                <a href="//getbarrel.com" class="<?php if($TPL_VAR["langType"]=='korean'){?>country__btn--active<?php }else{?>country__btn<?php }?>">KR<!-- <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-ko.gif" alt="KO"> --></a>
                <span>|</span>
                <a href="//en.getbarrel.com" class="<?php if($TPL_VAR["langType"]=='english'){?>country__btn--active<?php }else{?>country__btn<?php }?>">EN<!-- <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-en.gif" alt="US"> --></a>
                <!--<a href="javascript:alert('영문몰 오픈 준비중입니다.');" class="<?php if($TPL_VAR["langType"]=='english'){?>country__btn&#45;&#45;active<?php }else{?>country__btn<?php }?>">-->
                    <!--<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-en.gif" alt="US">-->
                <!--</a>-->
                <span>|</span>
                <a href="/event/eventDetail/12" class="<?php if($TPL_VAR["langType"]=='china'){?>country__btn--active<?php }else{?>country__btn<?php }?>">CN<!-- <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/main/icon-ch.gif" alt="CH"> --></a>
            </nav>
        </div>
    </div>
</div>
<div class="fb__footer__store">
    <div class="fb__footer__inner">
        <section class="fb__footer__customer">
            <h2 class="fb__title">Contact us</h2>
            <span class="pub-sect pub-tel">
<?php if($TPL_VAR["langType"]=='english'){?>
                en_help@getbarrel.com
<?php }else{?>
<?php if(str_replace("-","",$TPL_VAR["companyInfo"]["cs_phone"])){?>
                        <?php echo $TPL_VAR["companyInfo"]["cs_phone"]?>

<?php }else{?>
                        <?php echo $TPL_VAR["companyInfo"]["com_phone"]?>

<?php }?>
<?php }?>
            </span>
<?php if($TPL_VAR["langType"]=='korean'){?>
<?php if($TPL_VAR["companyInfo"]["opening_time"]){?>
                <span class='pub-sect pub-time'>
                    <span><?php echo nl2br($TPL_VAR["companyInfo"]["opening_time"])?></span>
                </span>
<?php }?>
<?php if(false){?>
            <span class="pub-sect pub-time" >
<?php if($TPL_VAR["companyInfo"]["officer_email"]){?>
                <a href='mailto:<?php echo $TPL_VAR["companyInfo"]["officer_email"]?>' class="pub-email"><?php echo $TPL_VAR["companyInfo"]["officer_email"]?></a>
<?php }else{?>
                <a href='mailto:<?php echo $TPL_VAR["companyInfo"]["email"]?>' class="pub-email"><?php echo $TPL_VAR["companyInfo"]["email"]?></a>
<?php }?>
            </span>
<?php }?>
<?php }?>
        </section>
        <section class="fb__footer__store--kn" style="display:none;">
            <div class="store">
                <figure class="store__img">
                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/img-footer-gn.jpg" alt="">
                </figure>
                <h2 class="store__name">
                    Barrel Gangnam Flagship Store
                </h2>
                <p class="store__address">
                    722-4, Banpo-dong, Seocho-gu, Seoul, Republic of Korea<br>Mon~Sun : 11:00~21:00<br>Tel : 02-549-5838
                </p>
            </div>
        </section>
        <!--
        <section class="fb__footer__store--hu">
            <div class="store">
                <figure class="store__img">
                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/img-footer-hu.jpg" alt="">
                </figure>
                <h2 class="store__name">
                    Barrel Hongdae Flagship Store
                </h2>
                <p class="store__address">
                    8, Wausan-ro 23-gil, Mapo-gu, Seoul, Republic of Korea<br>Mon~Sun : 11:00 ? 21:00<br>Tel : +82 2-334-3176
                </p>
            </div>
        </section>
        -->

        <div class="out__sns">
            <nav class="out__sns__inner">
                <a href="https://www.instagram.com/barrel.lifestyle/?hl=ko" class="fb__sns--instagram">
                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon-footer-insta.png" alt="insta">
                </a>
                <a href="https://www.facebook.com/pages/Barrel/1416024818648425">
                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon-footer-facebook.png" alt="facebook">
                </a>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <a href="https://pf.kakao.com/_VxfxjDd">
                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon-footer-kakao.png" alt="kakaoplus">
                </a>
                <a href="http://blog.naver.com/socal_kr">
                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon-footer-blog.png" alt="blog">
                </a>
<?php }?>
                <a href="https://www.youtube.com/c/getbarrel">
                    <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon-footer-youtube.png" alt="youtube">
                </a>
            </nav>
        </div>

    </div>
</div>
<div class="fb__footer__siteMap">
    <ul class="siteMap">
        <li class="siteMap__list">
            <h2 class="siteMap__title">
                About Us
            </h2>
            <a href="/brand/brandStory" class="siteMap__link">BRAND STORY</a>
            <a href="/brand/technology" class="siteMap__link">TECHNOLOGY</a>
            <a href="/brand/visual" class="siteMap__link">VISUAL</a>
            <a href="/brand/issue" class="siteMap__link">BARREL ISSUE</a>
            <a href="/brand/sponsorship" class="siteMap__link">BARREL TEAM</a>
            <a href="#" class="fb__open__sport siteMap__link">SPORTS CAMPAIGN</a>
            <!--<a href="/" class="siteMap__link">SOS Survival swimming campaign</a>-->
            <!--<a href="/customer/storeInformation" class="siteMap__link">STORES</a>-->
        </li>
        <li class="siteMap__list">
            <h2 class="siteMap__title">
                <a href="/shop/goodsList/001000000000000#page1&filterCid=001000000000000&orderBy=regdateDesc">Online Store</a>
            </h2>
            <a href="/shop/goodsList/001000000000000#page1&filterCid=001000000000000&orderBy=regdateDesc" class="siteMap__link">WATER SPORTS</a>
            <a href="/shop/goodsList/002000000000000#page1&filterCid=002000000000000&orderBy=regdateDesc" class="siteMap__link"><?php if($TPL_VAR["langType"]=='korean'){?>Neoprene<?php }else{?>NEOPRENE<?php }?></a>
            <a href="/shop/goodsList/003000000000000#page1&filterCid=003000000000000&orderBy=regdateDesc" class="siteMap__link">ACCESSORIES</a>
            <a href="/shop/goodsList/004000000000000#page1&filterCid=004000000000000&orderBy=regdateDesc" class="siteMap__link">SWIM</a>
            <a href="/shop/goodsList/005000000000000#page1&filterCid=005000000000000&orderBy=regdateDesc" class="siteMap__link">BARREL FIT</a>
            <a href="/shop/goodsList/006000000000000#page1&filterCid=006000000000000&orderBy=regdateDesc" class="siteMap__link">COSMETICS</a>
            <a href="/shop/goodsList/007000000000000#page1&filterCid=007000000000000&orderBy=regdateDesc" class="siteMap__link">OUTLET</a>

        </li>
        <li class="siteMap__list">
            <h2 class="siteMap__title">
                <a href="/customer/notice" class="siteMap__link">CS Center</a>
            </h2>
            <a href="/customer/notice" class="siteMap__link">Notice</a>
            <a href="/customer/memberBenefit" class="siteMap__link">Membership Guide</a>
            <a href="/customer/storeInformation" class="siteMap__link eng-hidden">Membership Guide</a>
            <a href="/customer/bestReview" class="siteMap__link">Shipping & Cancel Guide </a>
            <a href="/customer/faq" class="siteMap__link">FAQ</a>
            <a href="/customer/benefitsGuide" class="siteMap__link">Reward & Coupon</a>
            <a href="/customer/shippingGuide" class="siteMap__link">Shipping & Cancel Guide </a>
            <a href="/customer/cliamGuide" class="siteMap__link">Returns / Refunds</a>
            <a href="/customer/productPrecautions" class="siteMap__link">Washing & Care</a>
            <a href="/customer/productRepairGuide" class="siteMap__link">Repair Guide</a>
            <a href="/customer/cosmeticsCaution" class="siteMap__link">Cosmetics Guide</a>
            <a href="/customer/contactUs" class="siteMap__link">Partnership</a>
        </li>
        <li class="siteMap__list">
            <h2 class="siteMap__title">
                <a href="/mypage/orderHistory" class="siteMap__link">My page</a>
            </h2>
            <a href="/mypage/orderHistory" class="siteMap__link">My Shopping</a>
            <a href="/mypage/mileage" class="siteMap__link">My Membership</a>
            <a href="/mypage/recentView" class="siteMap__link">My interest</a>
            <a href="/mypage/myInquiry" class="siteMap__link">My Community</a>
            <a href="/mypage/passReconfirm" class="siteMap__link">My Account</a>
        </li>
        <li class="siteMap__list eng-hidden">
            <h2 class="siteMap__title">
                <a href="/customer/storeInformation" class="siteMap__link">STORES</a>
            </h2>
            <a href="/customer/storeInformation" class="siteMap__link">Store Information</a>
            <!--</h2>-->
            <!--<a href="#" class="siteMap__link">BARREL WATERSPORTS WEAR</a>-->
            <!--<a href="#" class="siteMap__link">Barrel Cosmetics</a>-->
        </li>
    </ul>
</div>