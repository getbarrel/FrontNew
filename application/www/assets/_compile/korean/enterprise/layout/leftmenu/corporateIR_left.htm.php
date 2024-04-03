<?php /* Template_ 2.2.8 2024/01/30 14:19:11 /home/barrel-stage/application/www/assets/templet/enterprise/layout/leftmenu/corporateIR_left.htm 000003700 */ ?>
<section class="fb__left-basicList">
	<div class="basicNav">
		<div class="basicNav__header">
			<h2 class="basicNav__title">기업 IR</h2>
		</div>
		<div class="basicNav__wrap">
			<div class="basicNav__item">
				<div class="title-sm"><a href="/corporateIR/financialInfo/">재무 정보</a></div>
				<ul class="basicNav__list">
					<li class="basicNav__list-item <?php if(substr_count($_SERVER['PHP_SELF'],'/corporateIR/financialInfo')> 0){?> active <?php }?>"><a href="/corporateIR/financialInfo/">재무상태표</a></li>
					<li class="basicNav__list-item <?php if(substr_count($_SERVER['PHP_SELF'],'/corporateIR/financialProfit')> 0){?> active <?php }?>"><a href="/corporateIR/financialProfit/">손익계산서</a></li>
				</ul>
			</div>
			<div class="basicNav__item">
				<ul class="basicNav__list">
					<li class="basicNav__list-item <?php if(substr_count($_SERVER['PHP_SELF'],'/corporateIR/disclosureNoti')> 0){?> active <?php }?>"><a href="/corporateIR/disclosureNoti/announce">공고</a></li>
					<li class="basicNav__list-item <?php if(substr_count($_SERVER['PHP_SELF'],'/corporateIR/IRResources')> 0){?> active <?php }?>"><a href="/corporateIR/IRResources">IR 자료</a></li>
				</ul>
			</div>
		</div>
	</div>
</section>


<!--
<section class="fb__left-nav">
    <h2 class="fb__left-nav__title">
        <a href="/corporateIR/financialInfo/" title="기업 IR" >기업 IR</a>
    </h2>
    <ul class="fb__left-nav__box">
        <li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">
                <a href="/corporateIR/financialInfo/" title="재무정보" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/notice')> 0){?>on<?php }?>">
                    재무정보
                </a>
            </h3>
            <a href="/corporateIR/financialInfo/" title="재무상태표" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/notice')> 0){?>on<?php }?>">
                재무상태표
            </a>
            <a href="/corporateIR/financialProfit/" title="손익계산서" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/notice')> 0){?>on<?php }?>">
                손익계산서
            </a>
        </li>
<?php if($TPL_VAR["langType"]=='korean'){?>
        <li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">
                <a href="/corporateIR/disclosureNoti/announce" title="공고" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/customer/notice')> 0){?>on<?php }?>">
                    공고
                </a>
            </h3>
            <!-- a href="/corporateIR/disclosureNoti/disclosure" title="공시" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/corporateIR/disclosureNoti/disclosure')> 0){?>on<?php }?>">
                공시
            </a -- 
            <a href="/corporateIR/disclosureNoti/announce" title="공고" class="<?php if(substr_count($_SERVER['PHP_SELF'],'/corporateIR/disclosureNoti/announce')> 0){?>on<?php }?>">
                공고
            </a>
        </li>
<?php }?>
        <li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">
                <a href="/corporateIR/IRResources">
                    IR자료
                </a>
            </h3>
        </li>
        <!--li class="fb__left-nav__link">
            <h3 class="fb__left-nav__subtitle">
                <a href="/corporateIR/pressReleases">
                    보도자료
                </a>
            </h3>
        </li-- 

    </ul>
</section>
-->