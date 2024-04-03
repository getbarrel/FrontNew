<?php /* Template_ 2.2.8 2024/03/01 16:54:00 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/basic/bbs_read.htm 000006905 */ ?>
<!-- 컨텐츠 S -->
<section class="br__cs-noti br__cs">
	<div class="br__cs-noti--detail">
		<section class="cs__menu">
			<div class="br-tab__slide swiper-container">
				<ul class="swiper-wrapper">
					<li class="swiper-slide ">
						<a href="/customer">고객센터 홈</a>
					</li>
					<li class="swiper-slide ">
						<a href="/customer/faq">자주 묻는 질문</a>
					</li>
					<li class="swiper-slide active">
						<a href="/customer/notice">공지사항</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/memberBenefit">회원혜택</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/storeInformation">매장안내</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/bestReview">제품후기</a>
					</li>
					<li class="swiper-slide ">
						<a href="/customer/benefitsGuide/">적립금 / 쿠폰 안내</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/cliamGuide">반품 / 환불 안내</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/shippingGuide">배송 안내</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/productPrecautions">제품 주의사항</a>
					</li>
					<li class="swiper-slide ">
						<a href="/customer/contactUs">제휴 문의</a>
					</li>
				</ul>
			</div>
		</section>
		<section class="board-detail__wrap">
			<section class="board-detail__header">
				<div class="page-title">
					<div class="title-md">공지사항</div>
				</div>
			</section>
			<section class="board-detail__content">
				<input type="hidden" id="isList" value="N" />
				<div class="detail-bbs__wrap">
					<div class="detail-bbs__header">
						<div class="detail-bbs__header-sub">
<?php if($TPL_VAR["is_notice"]=='Y'){?>
							<span class="detail-bbs__category category">공지</span>
<?php }?>
							<span class="detail-bbs__date date"><?php echo $TPL_VAR["reg_date"]?></span>
						</div>
						<div class="detail-bbs__header-group">
							<h3 class="detail-bbs__title"><?php echo $TPL_VAR["bbs_subject"]?></h3>
						</div>
					</div>
					<div class="detail-bbs__content">
						<div class="cont-area">
						<?php echo $TPL_VAR["bbs_contents"]?>

						</div>
<?php if($TPL_VAR["bbs_file_1"]!=""||$TPL_VAR["bbs_file_2"]!=""||$TPL_VAR["bbs_file_3"]!=""||$TPL_VAR["bbs_file_4"]!=""){?>
						<div class="read__file ">
<?php if($TPL_VAR["bbs_file_1"]!=""){?><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_1"]?>"><?php echo $TPL_VAR["bbs_file_1"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_2"]!=""){?>, <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_2"]?>"><?php echo $TPL_VAR["bbs_file_2"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_3"]!=""){?>, <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_3"]?>"><?php echo $TPL_VAR["bbs_file_3"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_4"]!=""){?>, <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_4"]?>"><?php echo $TPL_VAR["bbs_file_4"]?></a><?php }?>
						</div>
<?php }?>
					</div>
					<div class="detail-bbs__footer">
						<button type="button" class="btn-default btn-dark-line"><a href="/customer/notice">목록으로</a></button>
					</div>
				</div>
			</section>
		</section>
	</div>
</section>
<!-- 컨텐츠 E -->
<style>
img {display: block;max-width: 100%; height: auto;}
</style>
<!--공지사항 상세
<section class="br__cs-noti br__cs">
    <h2 class="br__cs__title">
        공지사항
    </h2>
    <div class="read ">
        <input type="hidden" id="isList" value="N" />
        <div class="read__header">

<?php if($TPL_VAR["is_notice"]=='Y'){?>
            <span class="read__noti-badge">공지</span>
<?php }?>

            <p class="read__title">
                <span class="read__date"><?php echo $TPL_VAR["reg_date"]?></span><?php echo $TPL_VAR["bbs_subject"]?>

                <span class="read__barrel">BARREL</span>
            </p>

        </div>
        <div class="read__content">
            <?php echo $TPL_VAR["bbs_contents"]?>

<?php if($TPL_VAR["bbs_file_1"]!=""||$TPL_VAR["bbs_file_2"]!=""||$TPL_VAR["bbs_file_3"]!=""||$TPL_VAR["bbs_file_4"]!=""){?>
            <div class="read__file ">
<?php if($TPL_VAR["bbs_file_1"]!=""){?><a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_1"]?>"><?php echo $TPL_VAR["bbs_file_1"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_2"]!=""){?>, <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_2"]?>"><?php echo $TPL_VAR["bbs_file_2"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_3"]!=""){?>, <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_3"]?>"><?php echo $TPL_VAR["bbs_file_3"]?></a><?php }?>
<?php if($TPL_VAR["bbs_file_4"]!=""){?>, <a href="<?php echo $TPL_VAR["download_path"]?>/<?php echo $TPL_VAR["bbs_file_4"]?>"><?php echo $TPL_VAR["bbs_file_4"]?></a><?php }?>
            </div>
<?php }?>
        </div>
        <ul class="cs__noti__wrap">
            <li class="cs__noti__list">
               <span class="cs__noti__prev">이전글</span>
                <div class="cs__noti__list--middle">
<?php if($TPL_VAR["beforeRecord"]['bbs_subject']!=''){?>
                    <span class="cs__noti__subject" onclick="javascript:location.href='/customer/notice/read/<?php echo $TPL_VAR["beforeRecord"]['bbs_ix']?>'"><?php echo $TPL_VAR["beforeRecord"]['bbs_subject']?></span>
                    <span class="cs__noti__date"><?php echo $TPL_VAR["beforeRecord"]['reg_date']?></span>
<?php }else{?>
                    <span class="cs__noti__subject">이전글이 없습니다.</span>
<?php }?>
                </div>
                <span class="cs__noti__barrel">BARREL</span>
            </li>
        </ul>
        <ul class="cs__noti__wrap">
            <li class="cs__noti__list">
                <span class="cs__noti__next">다음글</span>
                <div class="cs__noti__list--middle">
<?php if($TPL_VAR["nextRecord"]['bbs_subject']!=''){?>
                    <span class="cs__noti__subject" onclick="javascript:location.href='/customer/notice/read/<?php echo $TPL_VAR["nextRecord"]['bbs_ix']?>'"><?php echo $TPL_VAR["nextRecord"]['bbs_subject']?></span>
                    <span class="cs__noti__date"><?php echo $TPL_VAR["nextRecord"]['reg_date']?></span>
<?php }else{?>
                    <span class="cs__noti__subject">다음글이 없습니다.</span>
<?php }?>
                </div>
                <span class="cs__noti__barrel">BARREL</span>
            </li>
        </ul>
    </div>
    <div class="read__btn--wrap">
        <a class="read__btn__list" href="/customer/notice">목록</a>
    </div>
</section>
-->