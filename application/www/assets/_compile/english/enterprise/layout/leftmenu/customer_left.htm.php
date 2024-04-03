<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/layout/leftmenu/customer_left.htm 000003709 */ ?>
<section class="fb__left-nav">
    <h2 class="fb__left-nav__title">
        <a href="/customer/" title="고객센터" >CS Center </a>
    </h2>
    <ul class="fb__left-nav__box">
        <li class="fb__left-nav__link">
            <a href="/customer/notice" title="Notice" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/notice')> 0){?>on<?php }?>">
                Notice
            </a>
        </li>
        <li class="fb__left-nav__link">
            <a href="/customer/memberBenefit" title="Membership Guide" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/memberBenefit')> 0){?>on<?php }?>">
                Membership Guide
            </a>
        </li>
        <li class="fb__left-nav__link eng-hidden">
            <a href="/customer/storeInformation" title=" Membership Guide"  class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/storeInformation')> 0){?>on<?php }?>">
                Membership Guide
            </a>
        </li>
<?php if($TPL_VAR["langType"]=='korean'){?>
        <li class="fb__left-nav__link">
            <a href="/customer/bestReview" title="Shipping & Cancel Guide "  class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/bestReview')> 0){?>on<?php }?>">
                Shipping & Cancel Guide 
            </a>
        </li>
<?php }else{?>
<?php }?>
        <li class="fb__left-nav__link">
            <a href="/customer/faq" title="FAQ" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/faq')> 0){?>on<?php }?>">
                FAQ
            </a>
        </li>
        <li class="fb__left-nav__link">
            <a href="/customer/benefitsGuide" title="Reward & Coupon" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/benefitsGuide')> 0){?>on<?php }?>">
                Reward & Coupon
            </a>
        </li>
        <li class="fb__left-nav__link">
            <a href="/customer/shippingGuide" title="Shipping & Cancel Guide " class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/shippingGuide')> 0){?>on<?php }?>">
                Shipping & Cancel Guide 
            </a>
        </li>
        <li class="fb__left-nav__link">
            <a href="/customer/cliamGuide" title="Returns / Refunds" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/cliamGuide')> 0){?>on<?php }?>">
                Returns / Refunds
            </a>
        </li>
        <li class="fb__left-nav__link">
            <a href="/customer/productPrecautions" title="Washing & Care" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/productPrecautions')> 0){?>on<?php }?>">
                Washing & Care
            </a>
        </li>
        <li class="fb__left-nav__link">
            <a href="/customer/productRepairGuide" title="Repair Guide" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/productRepairGuide')> 0){?>on<?php }?>">
                Repair Guide
            </a>
        </li>
        <li class="fb__left-nav__link">
            <a href="/customer/cosmeticsCaution " title="Cosmetics Guide" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/cosmeticsCaution')> 0){?>on<?php }?>">
                Cosmetics Guide
            </a>
        </li>
<?php if($TPL_VAR["langType"]=='korean'){?>
        <li class="fb__left-nav__link">
            <a href="/customer/contactUs" title="Affiliate Inquiry" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/contactUs')> 0){?>on<?php }?>">
                Affiliate Inquiry
            </a>
        </li>
<?php }?>
    </ul>
</section>