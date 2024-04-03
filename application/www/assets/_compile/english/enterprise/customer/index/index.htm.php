<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/customer/index/index.htm 000002721 */ 
$TPL_noticeList_1=empty($TPL_VAR["noticeList"])||!is_array($TPL_VAR["noticeList"])?0:count($TPL_VAR["noticeList"]);
$TPL_faqList_1=empty($TPL_VAR["faqList"])||!is_array($TPL_VAR["faqList"])?0:count($TPL_VAR["faqList"]);?>
<?php $this->print_("customerTop",$TPL_SCP,1);?>

<section class="fb__customer__index br__customer__index">
    <h2 class="fb__main__title--hidden">
        CS Center
    </h2>
    <section class="fb__customer__menu">
        <header class="fb__customer__noti-header">
            <h3 class="fb__customer__title">Menu</h3>
        </header>
        <nav class="fb__customer__menu-inner">
            <a href="/customer/storeInformation" class="fb__customer__menu--order eng-hidden">Membership Guide</a>
            <a href="/customer/memberBenefit" class="fb__customer__menu--cancle">Membership Guide</a>
<?php if($TPL_VAR["langType"]=='korean'){?>
            <a href="/customer/bestReview" class="fb__customer__menu--member">Shipping & Cancel Guide </a>
<?php }else{?>
            <a href="/customer/shippingGuide" class="fb__customer__menu--member">Shipping & Cancel Guide </a>
<?php }?>
        </nav>
    </section>
    <section class="fb__customer__noti">
        <header class="fb__customer__noti-header">
            <h3 class="fb__customer__title">Notice</h3>
            <a href="/customer/notice" class="fb__customer__noti-more">
                View more
            </a>
        </header>
        <ul class="cus-notice">
<?php if($TPL_noticeList_1){foreach($TPL_VAR["noticeList"] as $TPL_V1){?>
            <li onclick="location.href = '/customer/notice/read/<?php echo $TPL_V1["bbs_ix"]?>'">
                <span class="title"><?php echo $TPL_V1["notice_subject"]?></span>
                <span class="date"><?php echo $TPL_V1["reg_date"]?></span>
            </li>
<?php }}?>
        </ul>
    </section>
    <section class="fb__customer__faq sec-faq-best">
        <header class="fb__customer__faq-header">
            <h3 class="fb__customer__title">FAQ</h3>
            <a href="/customer/faq" class="fb__customer__faq-more">
                View more
            </a>
        </header>
<?php if($TPL_VAR["faqList"]){?>
<?php if($TPL_faqList_1){foreach($TPL_VAR["faqList"] as $TPL_V1){?>
        <dl>
            <dt><?php echo $TPL_V1["div_name"]?></dt>
            <dd class="ellipsis-txt" onclick="location.href = '/customer/faq?bbs_ix=<?php echo $TPL_V1["bbs_ix"]?>'"><?php echo $TPL_V1["bbs_q"]?></dd>
        </dl>
<?php }}?>
<?php }else{?>
        <dl>
            <p>No FAQ</p>
        </dl>
<?php }?>
    </section>
</section>