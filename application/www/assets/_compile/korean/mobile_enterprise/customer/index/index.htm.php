<?php /* Template_ 2.2.8 2024/03/04 00:05:54 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/customer/index/index.htm 000004933 */ 
$TPL_faqList_1=empty($TPL_VAR["faqList"])||!is_array($TPL_VAR["faqList"])?0:count($TPL_VAR["faqList"]);
$TPL_noticeList_1=empty($TPL_VAR["noticeList"])||!is_array($TPL_VAR["noticeList"])?0:count($TPL_VAR["noticeList"]);?>
<!-- 컨텐츠 S -->
<section class="br__cs">
	<div class="cs">
		<section class="cs__menu">
			<div class="br-tab__slide swiper-container">
				<ul class="swiper-wrapper">
					<li class="swiper-slide active">
						<a href="/customer">고객센터 홈</a>
					</li>
					<li class="swiper-slide">
						<a href="/customer/faq">자주 묻는 질문</a>
					</li>
					<li class="swiper-slide">
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
					<li class="swiper-slide">
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
					<li class="swiper-slide">
						<a href="/customer/contactUs">제휴 문의</a>
					</li>
				</ul>
			</div>
		</section>
		<section class="cs__info">
<?php if($TPL_VAR["langType"]=='english'){?>
			<div class="cs__info__call"><a class="cs__info__call-link" mailto:<?php echo $TPL_VAR["companyInfo"]["global_cs_email"]?>">MailSend</a></div>
<?php }else{?>
			<div class="cs__info__call"><a class="cs__info__call-link" href="tel:<?php echo $TPL_VAR["companyInfo"]["cs_phone"]?>"><?php echo $TPL_VAR["companyInfo"]["cs_phone"]?></a><span>(유료)</span></div>
<?php }?>
<?php if($TPL_VAR["langType"]=='korean'){?>
			<div class="cs__info__runtime">
				<?php echo nl2br($TPL_VAR["companyInfo"]["opening_time"])?>

				<!-- <div class="title-md">운영시간 : 월 ~ 금 10:00 ~ 17:00</div>
				<p>[점심시간 13:00 ~ 14:00]</p> -->
			</div>
<?php }?>
		</section>
		<section class="cs__noti">
			<div class="cs__noti__wrap">
				<div class="cs__noti__title">
					<div class="title-md">자주 묻는 질문 TOP 5</div>
					<a href="/customer/faq">전체보기</a>
				</div>
				<div class="cs__noti__contents board-faq">
					<!-- 게시판 FAQ S -->
					<div class="board-faq__wrap">
						<div class="board-faq__list">
<?php if($TPL_VAR["faqList"]){?>
<?php if($TPL_faqList_1){foreach($TPL_VAR["faqList"] as $TPL_V1){?>							
							<dl class="board-faq__item">
								<!-- 펼칠 경우 dl class = active 추가 -->
								<dt class="board-faq__Q">
									<a href="#;" class="board-faq__link">
										<div class="title-sm">
											<span><?php echo $TPL_V1["div_name"]?></span>
											<?php echo $TPL_V1["bbs_q"]?>

										</div>
										<i class="ico ico-arrow-bottom"></i>
									</a>
								</dt>
								<dd class="board-faq__A">
									<div class="answer">
										<?php echo $TPL_V1["bbs_a"]?>

									</div>
								</dd>
							</dl>
<?php }}?>
<?php }else{?>
							<dl>
								<p>등록된 FAQ 정보가 존재하지 않습니다.</p>
							</dl>
<?php }?>

						</div>
					</div>
					<!-- 게시판 FAQ E -->
				</div>
			</div>
			<div class="cs__noti__wrap">
				<div class="cs__noti__title">
					<div class="title-md">공지사항</div>
					<a href="/customer/notice">전체보기</a>
				</div>
				<div class="cs__noti__contents board-bbs">
					<!-- 게시판 S -->
					<div class="board-bbs__wrap">
						<ul class="board-bbs__list">
<?php if($TPL_noticeList_1){foreach($TPL_VAR["noticeList"] as $TPL_V1){?>
							<li class="board-bbs__item">
								<div class="board-bbs__title-group">
									<div class="board-bbs__title-sub">
										<!-- <span class="board-bbs__category">[배송]</span> -->
										<span class="board-bbs__day"><?php echo $TPL_V1["reg_date"]?></span>
									</div>
									<div class="board-bbs__title">
										<a class="board-bbs__link" href="/customer/notice/read/<?php echo $TPL_V1["bbs_ix"]?>">
											<?php echo $TPL_V1["notice_subject"]?>

											<i class="ico ico-arrow-right"></i>
										</a>
									</div>
								</div>
							</li>
<?php }}else{?>
							<li class="board-bbs__item no-data" style="display: none">
								<p class="empty-content">등록된 공지사항이 없습니다.</p>
							</li>
<?php }?>
						</ul>
					</div>
					<!-- 게시판 E -->
				</div>
			</div>
		</section>
	</div>
</section>
<!-- 컨텐츠 E -->