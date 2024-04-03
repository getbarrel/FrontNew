<?php /* Template_ 2.2.8 2024/03/11 14:49:23 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/basic/faq_list.htm 000004323 */ 
$TPL_bbs_divs_1=empty($TPL_VAR["bbs_divs"])||!is_array($TPL_VAR["bbs_divs"])?0:count($TPL_VAR["bbs_divs"]);?>
<!-- 컨텐츠 S -->
<section class="br__faq">
	<div class="br__faq__wrap">
		<section class="cs__menu">
			<div class="br-tab__slide swiper-container">
				<ul class="swiper-wrapper">
					<li class="swiper-slide">
						<a href="/customer">고객센터 홈</a>
					</li>
					<li class="swiper-slide active">
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
		<div class="page-title">
			<div class="title-md">자주 묻는 질문</div>
		</div>
		<section class="board-faq__wrap">
			<form id="devFaqForm">
				<div class="input-search">
					<input type="hidden" name="page" value="1" id="devPage">
					<input type="hidden" name="max" value="20" id="devMax">
					<input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>" id="bType">
					<input type="hidden" name="curPage" value="" id="curPage">
					<input type="hidden" name="lastPage" value="" id="lastPage">
					<input type="hidden" name="divIx" value="<?php echo $TPL_VAR["divIx"]?>" id="divIx">
					<input type="hidden" name="bbsIx" value="<?php echo $TPL_VAR["bbsIx"]?>" id="bbsIx">
				</div>
				<!-- <div class="board-search__form">
					<label for="" class="hide">게시글 검색 입력창</label>
					<input type="text" class="fb__form-input" placeholder="검색어를 입력하세요." value="" />
					<button type="button" class="btn-search"><i class="ico ico-search"></i></button>
				</div> -->
				<div class="board-tab__wrap">
					<div class="br-tab__nav br-tab__slide swiper-container">
						<ul class="swiper-wrapper" id="devDivs">
							<li id="devDivIx2" class="swiper-slide active">
								<a href="javascript:void(0)" devDivIx="" data-divix="">전체</a>
							</li>
<?php if($TPL_bbs_divs_1){foreach($TPL_VAR["bbs_divs"] as $TPL_V1){?>
							<li id="devDivIx2<?php echo $TPL_V1["div_ix"]?>" class="swiper-slide">
								<a href="javascript:void(0)" devDivIx="<?php echo $TPL_V1["div_ix"]?>" data-divix="<?php echo $TPL_V1["div_ix"]?>"><?php echo $TPL_V1["div_name"]?></a>
							</li>
<?php }}?>
						</ul>
					</div>
				</div>

				<div class="empty-content"  id="devFaqEmpty">
					<p id="emptyMsg"><strong></strong></p>
				</div>

				<div class="empty-content" id="devFaqLoading">
					<p>Loading...</p>
				</div>
				<div class="board-faq__list" id="devFaqContent">
					<dl class=" " id="devFaqList">
						<dt class="board-faq__Q devFaqQuestion">
							<a href="javascript:void(0);" class="">
								<div class="title-sm">
									<span>{[div_name]}</span>
									{[{bbs_q}]}
								</div>
								<i class="ico ico-arrow-bottom"></i>
							</a>
						</dt>
						<dd class="board-faq__A devFaqAnswer">
							<div class="answer">
								<p>{[{bbs_a}]}</p>
							</div>
						</dd>
					</dl>
				</div>

				<div id="devPageWrap" class="board-footer">
					<button type="button" class="btn-lg btn-dark-line">더보기</button>
				</div>

				<!-- <div id="devPageWrap" style="text-align:center;margin-top:30px;">
					<div class="br__more devPageBtnCls">더보기</div>
				</div> -->
			</form>
		</section>
	</div>
</section>
<!-- 컨텐츠 E -->