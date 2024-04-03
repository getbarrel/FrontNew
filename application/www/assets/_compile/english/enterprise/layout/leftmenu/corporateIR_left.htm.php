<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/layout/leftmenu/corporateIR_left.htm 000002484 */ ?>
<section class="fb__left-nav">
    <h2 class="fb__left-nav__title">
        <a href="/corporateIR/financialInfo/" title="기업 IR" >Corporate IR</a>
    </h2>
    <ul class="fb__left-nav__box">
        <li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">
                <a href="/corporateIR/financialInfo/" title="Financial information" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/notice')> 0){?>on<?php }?>">
                    Financial information
                </a>
            </h3>
            <a href="/corporateIR/financialInfo/" title="F/P" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/notice')> 0){?>on<?php }?>">
                F/P
            </a>
            <a href="/corporateIR/financialProfit/" title="C/I" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/notice')> 0){?>on<?php }?>">
                C/I
            </a>
        </li>
<?php if($TPL_VAR["langType"]=='korean'){?>
        <li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">
                <a href="/corporateIR/disclosureNoti/disclosure" title="Public announcement" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/notice')> 0){?>on<?php }?>">
                    Public announcement
                </a>
            </h3>
            <a href="/corporateIR/disclosureNoti/disclosure" title="Public announcement" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/corporateIR/disclosureNoti/disclosure')> 0){?>on<?php }?>">
                Public announcement
            </a>
            <a href="/corporateIR/disclosureNoti/announce" title="Public announcement" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/corporateIR/disclosureNoti/announce')> 0){?>on<?php }?>">
                Public announcement
            </a>
        </li>
<?php }?>
        <li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">
                <a href="/corporateIR/IRResources">
                    IR Data
                </a>
            </h3>
        </li>
        <li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">
                <a href="/corporateIR/pressReleases">
                    Press release
                </a>
            </h3>
        </li>

    </ul>
</section>