<?php /* Template_ 2.2.8 2020/08/31 15:56:56 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/customer/index/index.htm 000005201 */ 
$TPL_noticeList_1=empty($TPL_VAR["noticeList"])||!is_array($TPL_VAR["noticeList"])?0:count($TPL_VAR["noticeList"]);?>
<section class="br__cs">
    <div class="cs">
        <section class="cs__info">
            <h2 class="cs__title">CS Center</h2>
<?php if($TPL_VAR["langType"]=='english'){?>
            <span class="cs__info__phone">en_help@getbarrel.com</span>
            <a class="cs__info__call" href="mailto:<?php echo $TPL_VAR["companyInfo"]["global_cs_email"]?>">Contact Us</a>
<?php }else{?>
            <span class="cs__info__phone"><?php echo $TPL_VAR["companyInfo"]["cs_phone"]?></span>
            <a class="cs__info__call" href="tel:<?php echo $TPL_VAR["companyInfo"]["cs_phone"]?>">Contact Us</a>
<?php }?>
<?php if($TPL_VAR["langType"]=='korean'){?>
            <div class="cs__info__runtime">
                <!--어드민에서 css 작업 따로 하는지 확인 필요 필요-->
                <span><?php echo nl2br($TPL_VAR["companyInfo"]["opening_time"])?></span>
                <!--<dl>-->
                    <!--<dt class="cs__info__runtime&#45;&#45;bold">평일</dt>-->
                    <!--<dd>10:00-18:00</dd>-->
                <!--</dl>-->
                <!--<dl>-->
                    <!--<dt class="cs__info__runtime&#45;&#45;bold">점심시간</dt>-->
                    <!--<dd>13:00-14:00</dd>-->
                <!--</dl>-->
                <!--<dl>-->
                    <!--<dt class="cs__info__runtime&#45;&#45;bold">휴무</dt>-->
                    <!--<dd>토요일·일요일·공휴일</dd>-->
                <!--</dl>-->
            </div>
<?php }?>
        </section>
<?php if($TPL_VAR["noticeList"]){?>
        <section class="cs__noti">
            <a class="cs__noti__title" href="/customer/notice">Notice</a>
            <ul class="cs__noti__wrap">
<?php if($TPL_noticeList_1){foreach($TPL_VAR["noticeList"] as $TPL_V1){?>
                    <!--**개발확인 > 최근 등록 순으로 최대 5개 노출입니다.-->
                    <!--**개발확인 > 고정공지에는 cs__noti__list--point 클래스를 추가해주세요. 공지뱃지도 같이 제거해주세요-->
<?php if($TPL_V1["is_notice"]=='Y'){?>
                    <li class="cs__noti__list cs__noti__list--point">
                        <a href="/customer/notice/read/<?php echo $TPL_V1["bbs_ix"]?>">
                            <!--**개발확인 > 공지뱃지는 고정공지일때만 추가-->
                            <span class="cs__noti__badge">Notice</span>
                            <div class="cs__noti__list--middle">
                                 <span class="cs__noti__subject"><?php echo $TPL_V1["notice_subject"]?></span>
                                <span class="cs__noti__subject__day"><?php echo $TPL_V1["reg_date"]?></span>
                            </div>
                            <span class="cs__noti__barrel">BARREL</span>
                        </a>
                    </li>
<?php }else{?>
                    <li class="cs__noti__list">
                        <a href="/customer/notice/read/<?php echo $TPL_V1["bbs_ix"]?>">
                            <div class="cs__noti__list--middle">
                                <span class="cs__noti__subject"><?php echo $TPL_V1["notice_subject"]?></span><span class="cs__noti__subject__day"><?php echo $TPL_V1["reg_date"]?></span>
                            </div>
                            <span class="cs__noti__barrel">BARREL</span>
                        </a>
                    </li>
<?php }?>
<?php }}?>
            </ul>
        </section>
<?php }?>
        <section class="cs__menu">
            <ul class="cs__menu__wrap">
                <!--**개발확인 > href 값 필요합니다.-->
                <li class="cs__menu__each"><a href="/customer/memberBenefit">Membership Guide</a></li>
                <li class="cs__menu__each eng-hidden"><a href="/customer/storeInformation">Store Information</a></li>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <li class="cs__menu__each"><a href="/customer/bestReview">Product Reviews</a></li>
<?php }else{?>
<?php }?>
                <li class="cs__menu__each"><a href="/customer/faq">FAQ</a></li>
                <li class="cs__menu__each"><a href="/customer/benefitsGuide/">Reward & Coupon</a></li>
                <li class="cs__menu__each"><a href="/customer/shippingGuide">Shipping & Cancel Guide </a></li>
                <li class="cs__menu__each"><a href="/customer/cliamGuide">Returns / Refunds</a></li>
                <li class="cs__menu__each"><a href="/customer/productPrecautions">Washing & Care</a></li>
                <li class="cs__menu__each"><a href="/customer/productRepairGuide/">Repair Guide</a></li>
                <li class="cs__menu__each"><a href="/customer/cosmeticsCaution">Cosmetics Guide</a></li>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <li class="cs__menu__each"><a href="/customer/contactUs">Affiliate Inquiry</a></li>
<?php }?>
            </ul>
        </section>
    </div>
</section>