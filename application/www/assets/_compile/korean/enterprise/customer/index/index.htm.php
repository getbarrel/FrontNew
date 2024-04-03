<?php /* Template_ 2.2.8 2024/01/25 15:04:15 /home/barrel-stage/application/www/assets/templet/enterprise/customer/index/index.htm 000003802 */ 
$TPL_faqList_1=empty($TPL_VAR["faqList"])||!is_array($TPL_VAR["faqList"])?0:count($TPL_VAR["faqList"]);
$TPL_noticeList_1=empty($TPL_VAR["noticeList"])||!is_array($TPL_VAR["noticeList"])?0:count($TPL_VAR["noticeList"]);?>
<script>
	//레이아웃 인클로드 js (퍼블리싱)
	$(document).ready(function () {

		/* 아코디언 형식의 리스트 js */
		$(".board-faq__link").on("click", function () {
			var faqiem = $(this).parents(".board-faq__item");
			faqiem.toggleClass("active");
			if ($(this).parents(".board-faq__item").hasClass("active")) {
				$(".board-faq__item").removeClass("active");
				$(".board-faq__A").stop().slideUp();
				faqiem.addClass("active");
				faqiem.find(".board-faq__A").stop().slideDown();
			} else {
				faqiem.removeClass("active");
				faqiem.find(".board-faq__A").stop().slideUp();
			}
		});
	});
</script>
<?php $this->print_("customerTop",$TPL_SCP,1);?>

<!-- 자주 묻는 질문 TOP 5 S -->
<section class="fb__customer__faq sec-faq-best board-faq">
	<div class="fb__customer__faq-header">
		<h3 class="fb__customer__title">자주 묻는 질문 TOP 5</h3>
		<a href="/customer/faq" class="fb__customer__faq-more">전체보기</a>
	</div>
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

						<!-- <p>배럴에서는 3만원이상 구매 시</p>
						<p>택배 운송비에 대한 부담을 최소화해드리기 위해 무료배송으로 보내드립니다.</p>
						<p>&nbsp;</p>
						<p>다만, 도서산간 지역은 추가 배송비 3,000원 추가됩니다.</p>
						<p>&nbsp;</p>
						<p>감사합니다.</p> -->
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
</section>
<!-- 자주 묻는 질문 TOP E S -->

<!-- 공지사항 S -->
<section class="fb__customer__noti">
	<div class="fb__customer__noti-header">
		<h3 class="fb__customer__title">공지사항</h3>
		<a href="/customer/notice" class="fb__customer__noti-more">전체보기</a>
	</div>
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
			<!-- 게시글이 없을 경우 S -->
			<!-- 숨김 처리 -->
			<li class="board-bbs__item no-data">
				<p class="empty-content">등록된 공지사항이 없습니다.</p>
			</li>
			<!-- 게시글이 없을 경우 E -->
<?php }?>
		</ul>
	</div>
	<!-- 게시판 E -->
</section>
<!-- 공지사항 E -->