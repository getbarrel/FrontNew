<?php /* Template_ 2.2.8 2024/04/02 16:15:54 /home/barrel-stage/application/www/assets/templet/enterprise/shop/goods_view/goods_view.htm 000129748 */ 
$TPL_image_src_1=empty($TPL_VAR["image_src"])||!is_array($TPL_VAR["image_src"])?0:count($TPL_VAR["image_src"]);
$TPL_add_image_src_1=empty($TPL_VAR["add_image_src"])||!is_array($TPL_VAR["add_image_src"])?0:count($TPL_VAR["add_image_src"]);
$TPL_relationProduct_1=empty($TPL_VAR["relationProduct"])||!is_array($TPL_VAR["relationProduct"])?0:count($TPL_VAR["relationProduct"]);
$TPL_eventBannerInfo_1=empty($TPL_VAR["eventBannerInfo"])||!is_array($TPL_VAR["eventBannerInfo"])?0:count($TPL_VAR["eventBannerInfo"]);
$TPL_displayContentList_1=empty($TPL_VAR["displayContentList"])||!is_array($TPL_VAR["displayContentList"])?0:count($TPL_VAR["displayContentList"]);
$TPL_togeterProduct_1=empty($TPL_VAR["togeterProduct"])||!is_array($TPL_VAR["togeterProduct"])?0:count($TPL_VAR["togeterProduct"]);
$TPL_similraProduct_1=empty($TPL_VAR["similraProduct"])||!is_array($TPL_VAR["similraProduct"])?0:count($TPL_VAR["similraProduct"]);
$TPL_icons_path_1=empty($TPL_VAR["icons_path"])||!is_array($TPL_VAR["icons_path"])?0:count($TPL_VAR["icons_path"]);
$TPL_sameProduct_1=empty($TPL_VAR["sameProduct"])||!is_array($TPL_VAR["sameProduct"])?0:count($TPL_VAR["sameProduct"]);
$TPL_colorChipList_1=empty($TPL_VAR["colorChipList"])||!is_array($TPL_VAR["colorChipList"])?0:count($TPL_VAR["colorChipList"]);
$TPL_product_gift_1=empty($TPL_VAR["product_gift"])||!is_array($TPL_VAR["product_gift"])?0:count($TPL_VAR["product_gift"]);
$TPL_productGiftInfo_1=empty($TPL_VAR["productGiftInfo"])||!is_array($TPL_VAR["productGiftInfo"])?0:count($TPL_VAR["productGiftInfo"]);
$TPL_optionData_1=empty($TPL_VAR["optionData"])||!is_array($TPL_VAR["optionData"])?0:count($TPL_VAR["optionData"]);
$TPL_couponList_1=empty($TPL_VAR["couponList"])||!is_array($TPL_VAR["couponList"])?0:count($TPL_VAR["couponList"]);
$TPL_style_1=empty($TPL_VAR["style"])||!is_array($TPL_VAR["style"])?0:count($TPL_VAR["style"]);
$TPL_option_1=empty($TPL_VAR["option"])||!is_array($TPL_VAR["option"])?0:count($TPL_VAR["option"]);
$TPL_qnaDivs_1=empty($TPL_VAR["qnaDivs"])||!is_array($TPL_VAR["qnaDivs"])?0:count($TPL_VAR["qnaDivs"]);
$TPL_laundryOneDepth_1=empty($TPL_VAR["laundryOneDepth"])||!is_array($TPL_VAR["laundryOneDepth"])?0:count($TPL_VAR["laundryOneDepth"]);
$TPL_laundry_1=empty($TPL_VAR["laundry"])||!is_array($TPL_VAR["laundry"])?0:count($TPL_VAR["laundry"]);
$TPL_mandatoryInfos_1=empty($TPL_VAR["mandatoryInfos"])||!is_array($TPL_VAR["mandatoryInfos"])?0:count($TPL_VAR["mandatoryInfos"]);?>
<script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/minicart.js?version=<?php echo CLIENT_VERSION?>" data-url="/controller/product/loadOptionDatas/<?php echo $TPL_VAR["pid"]?>" id="devMinicartScript"></script>

 <!-- crema load -->
<script>
    var crema_userId = null;
    var crema_userNm = null;

<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
        crema_userId = "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["id"]?>";
        crema_userNm = "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["name"]?>";
<?php }?>

    window.cremaAsyncInit = function() { // init.js가 다운로드 & 실행된 후에 실행하는 함수
      //console.log("[CREMA] cremaAsyncInit() - EXECUTED!");
      crema.init(crema_userId, crema_userNm);
      //console.log("[CREMA] crema.init() - EXECUTED!");
    };

    (function(i,s,o,g,r,a,m){if(s.getElementById(g))<?php echo $TPL_VAR["return"]?>;a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.id=g;a.async=1;a.src=r;m.parentNode.insertBefore(a,m)})
    (window,document,'script','crema-jssdk','//<?php echo CREMA_WIDGET_HOST?>/getbarrel.com/init.js');
</script>

<script>
	function addOption(){
		if($("#devMinicartAddOption").is(":hidden")) {
			$("#devMinicartAddOption").show('slow');
			$('#dlClassTag').addClass('active');
		} else {
			$("#devMinicartAddOption").hide('slow');
			$('#dlClassTag').removeClass('active');
		}
	}

	function cartPopClose(clickNum){
		if(clickNum == 1){
			location.reload();
		}else if(clickNum == 2){
			location.href = '/shop/cart';
		}
	}
</script>

<script>
    var emnet_tagm_products=[];
</script>

<script>
emnet_tagm_products.push({
    'name': '<?php echo $TPL_VAR["pname"]?>',
    'id': '<?php echo $TPL_VAR["pid"]?>',
    'price': '<?php echo $TPL_VAR["dcprice"]?>',
    'quantity': '1'
});
</script>

<!-- 상품상세 dataLayer -->
<script>
 dataLayer.push({
     'event': 'viewContent',
     'ecommerce': {
         'detail': {
            'products': emnet_tagm_products
         }
     }
 });

var $document = $(document);

$document.on("click", ".cosmetics__link1", function () {
	$(this).toggleClass("cosmetics__link1--open");
	return false;
});
</script>


<!-- Criteo 상품 태그 23.06.29-->
<script type="text/javascript">
    window.criteo_q = window.criteo_q || [];
    var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
    window.criteo_q.push(
        { event: "setAccount", account: 104564},
        { event: "setEmail", email: "", hash_method: "" },
        { event: "setZipcode", zipcode: "" },
        { event: "setSiteType", type: deviceType},
        { event: "viewItem", item: "<?php echo $TPL_VAR["pid"]?>" });
</script>
<!-- END Criteo 상품 태그 -->

<!-- Enliple Tracker Start_모비온 -->
<script type="text/javascript">
var ENP_VAR = {
collect: {},
conversion: { product: [] }
};
ENP_VAR.collect.productCode = '<?php echo $TPL_VAR["pid"]?>';
ENP_VAR.collect.productName = '<?php echo $TPL_VAR["pname"]?>';
ENP_VAR.collect.price = '<?php echo $TPL_VAR["listprice"]?>';
ENP_VAR.collect.dcPrice = '<?php echo $TPL_VAR["dcprice"]?>';
if('<?php echo $TPL_VAR["status"]?>' == 'sale'){
	ENP_VAR.collect.soldOut = 'N';
}else{
	ENP_VAR.collect.soldOut = 'Y';
}
ENP_VAR.collect.imageUrl = '<?php echo $TPL_VAR["image_src"]?>';
//ENP_VAR.collect.secondImageUrl = '상품 이미지 URL(다중이미지 사용시 세팅)';
//ENP_VAR.collect.thirdImageUrl = '상품 이미지 URL(다중이미지 사용시 세팅)';
//ENP_VAR.collect.fourthImageUrl = '상품 이미지 URL(다중이미지 사용시 세팅)';
ENP_VAR.collect.topCategory = '<?php echo $TPL_VAR["cid"]?>'.substring(0,3);
ENP_VAR.collect.firstSubCategory = '<?php echo $TPL_VAR["cid"]?>'.substring(3,6);
ENP_VAR.collect.secondSubCategory = '<?php echo $TPL_VAR["cid"]?>'.substring(6,9);
ENP_VAR.collect.thirdSubCategory = '<?php echo $TPL_VAR["cid"]?>'.substring(9,12);

(function(a,g,e,n,t){a.enp=a.enp||function(){(a.enp.q=a.enp.q||[]).push(arguments)};n=g.createElement(e);n.async=!0;n.defer=!0;n.src="https://cdn.megadata.co.kr/dist/prod/enp_tracker_self_hosted.min.js";t=g.getElementsByTagName(e)[0];t.parentNode.insertBefore(n,t)})(window,document,"script");
/* 상품수집 */
enp('create', 'collect', 'barrel', { device: 'W' });
/* 장바구니 버튼 타겟팅 */
enp('create', 'cart', 'barrel', { device: 'W', btnSelector: '.devAddCart' });
/* 찜 버튼 타겟팅 */
enp('create', 'wish', 'barrel', { device: 'W', btnSelector: '.btn-wish' });
</script>
<!-- Enliple Tracker End_모비온 -->
<!-- 컨텐츠 S -->
<section class="fb__goods-view">
	<h2 class="fb__main__title--hidden">상품상세</h2>
	<div class="fb__goods-view__left">
		<!-- 상세 메인 상품 이미지 -->
		<section class="fb__goods-view__photo">
			<ul class="fb__goods-view__photo-list">
<?php if($TPL_image_src_1){foreach($TPL_VAR["image_src"] as $TPL_V1){?>
				<li><img src="<?php echo $TPL_V1["basic_img"]?>" data-big_img="<?php echo $TPL_V1["basic_img"]?>"></li>
<?php }}?>
<?php if($TPL_VAR["movie"]){?>
				<li>
					<div id="videoPlayer" data-vimeo-url="<?php echo $TPL_VAR["movie"]?>" data-url="<?php echo $TPL_VAR["movie"]?>"></div>
				</li>
<?php }?>
<?php if($TPL_add_image_src_1){foreach($TPL_VAR["add_image_src"] as $TPL_V1){?>
				<!--<li><img src="<?php echo $TPL_V1["smallImg"]?>" data-big_img="<?php echo $TPL_V1["bigImg"]?>"></li>-->
<?php }}?>
			</ul>
<?php if($TPL_VAR["movie_thumbnail"]){?>
			<a href="javascript:void(0);" class="photo__slider__item--movie" style="display:none;">
				<figure class="photo__slider__item--play" style="display:none;">
					<img src="<?php echo $TPL_VAR["movie_thumbnail"]?>" data-movie="<?php echo $TPL_VAR["movie"]?>">
				</figure>
			</a>
<?php }?>
<?php if($TPL_VAR["movie"]){?>
				<button class="goods-thumb__play" style="display:none;">영상 재생</button>
<?php }?>
			<div class="fb__goods-view__photo-desc">
<?php if($TPL_VAR["wear_info"]!=''){?>
				<div class="title-sm">착장 정보</div>
				<p><?php echo nl2br($TPL_VAR["wear_info"])?></p>
				<!--<p>168cm / Bust 32 / Waist 24 / Hip 36</p>
				<p>우먼 바이브 스웰 래쉬가드 핑크 085</p>
				<p>우먼 바이브 9부 워터 레깅스 미드나잇블루 085</p>-->
<?php }?>
			</div>
		</section>
		<!-- 상세 메인 상품 이미지 -->

		<section class="fb__goods-view__banner">
<?php if($TPL_VAR["relationProduct"]){?>
			<div class="product-slider__list">
				<div class="product-slider__item">
					<div class="fb__cart-goods--slider swiper swiper-goods-default swiper-initialized swiper-horizontal swiper-backface-hidden">
						<div class="product-slider__title">
							<h3>연관 상품</h3>
						</div>
						<ul class="fb__goods swiper-wrapper">
<?php if($TPL_relationProduct_1){foreach($TPL_VAR["relationProduct"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='stop'){?>
									<li class="fb__goods__list swiper-slide">
										<a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="fb__goods__link">
											<figure class="fb__goods__img">
												<div>
													<img src="<?php echo $TPL_V1["image_src"]?>" alt="상품이미지" />
												</div>
											</figure>
											<div class="fb__goods__info">
												<ul class="fb__goods__infoBox">
													<li class="fb__goods__etc"><?php echo $TPL_V1["prefaceName"]?></li>
													<li class="fb__goods__name"><?php echo $TPL_V1["pname"]?></li>
													<li class="fb__goods__option"><?php echo $TPL_V1["add_info"]?></li>
													<li class="fb__goods__brand"></li>
												</ul>
											</div>
											<div class="fb__goods__important">
<?php if($TPL_V1["isDiscount"]){?>
												<div class="fb__goods__sale">
													<p class="per"><em><?php echo $TPL_V1["discount_rate"]?></em>%</p>
												</div>
<?php }?>
												<span class="fb__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["dcprice"])?></span>
<?php if($TPL_V1["isDiscount"]){?>
												<span class="fb__goods__noprice"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?></span>
<?php }?>
<?php if($TPL_V1["is_soldout"]){?>
												<span class="fb__goods__price__state">[품절]</span>
<?php }?>
											</div>
											<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
										</a>
										<a href="javascript:void(0);" class="product-box__heart <?php if($TPL_V1["alreadyWish"]){?>product-box__heart--active<?php }?>" data-devWishBtn="<?php echo $TPL_V1["id"]?>">hart</a>
									</li>
<?php }?>
<?php }}?>
						</ul>
						<button type="button" class="swiper-button swiper-button-prev"><i class="ico ico-arrow-left"></i>이전</button>
						<button type="button" class="swiper-button swiper-button-next"><i class="ico ico-arrow-right"></i>다음</button>
					</div>
				</div>
			</div>
<?php }?>

			<div class="fb__goods-view__event">
				<div class="swiper-button-group">
					<button type="button" class="swiper-button swiper-button-prev swiper-GoodsView-button-prev"></button>
					<button type="button" class="swiper-button swiper-button-next swiper-GoodsView-button-next"></button>
				</div>
				<div class="fb__goods-view__event-slider swiper-container">
					<div class="swiper-wrapper">
<?php if($TPL_eventBannerInfo_1){foreach($TPL_VAR["eventBannerInfo"] as $TPL_V1){?>
						<div class="swiper-slide">
							<a href="<?php echo $TPL_V1["bannerLink"]?>"><img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["bd_title"]?>" /></a>
						</div>
<?php }}?>
					</div>
				</div>
				<div class="fb__goods-view__event-control">
					<div class="swiper-control-group">
						<div class="swiper-scrollbar"></div>
						<div class="swiper-pagination"></div>
					</div>
				</div>
			</div>
		</section>

		<!-- 하단 상품상세 - 왼쪽 메인 영역 -->
		<section class="fb__goods-view__detail">
			<h4 class="fb__main__title--hidden">하단 상품상세 - 왼쪽 메인 영역</h4>
			<div class="detail">
				<div class="detail__main detail-tab__wrap">
					<!-- 상품관련 메뉴 타이틀 -->
					<div class="detail-tab__nav">
						<ul>
							<li class="active">
<?php if($TPL_VAR["langType"]=='korean'){?>
									<a href="#devTabReview" title="devTabReview" data-content="">상품 리뷰<span>(<?php echo $TPL_VAR["total_review_cnt"]?>)</span></a>
<?php }else{?>
<?php if(false){?>
									<a href="#devTabReview" title="devTabReview" data-content="devTabReview">상품 리뷰<?php if($TPL_VAR["allReviewTotal"]> 0){?><span>(<?php echo $TPL_VAR["total_review_cnt"]?>)</span><?php }?></a>
<?php }?>
<?php }?>
							</li>
							<li>
								<a href="#devTapDetail" title="devTapDetail" data-content="devViewDetail">상품정보</a>
							</li>
<?php if($TPL_VAR["langType"]=='korean'){?>
								<li>
									<a href="#devTabRecom" title="devTabRecom" data-content="">사이즈 가이드</a>
								</li>
<?php }else{?>
								<li>
									<a href="#devTabRecom" title="devTabRecom" data-content="">Size Guide</a>
								</li>
<?php }?>
							<li>
								<a href="#devTabInquiry" title="devTabInquiry" data-content="devTabInquiry">상품문의<span>(<?php echo number_format($TPL_VAR["qnaTotal"])?>)</span></a>
							</li>
						</ul>
					</div>
					<!-- 상품관련 메뉴 타이틀 -->

					<!-- 상품관련 메뉴 내용 -->
					<div class="detail-tab__contents-wrap">
						<!-- 상품 리뷰 -->
						<div class="detail-tab__contents" id="devTabReview">
							<div class="detail-title__toggle active">
								<div class="title-sm">상품 리뷰</div>
								<i class="ico ico-plus"></i>
							</div>
							<div class="detail-content">
								<div class="detail-review">
									<div class="detail-review__box">
										<div class="title-sm">후기 적립금 안내</div>
										<ul class="detail-review__list">
											<li class="detail-review__item">
												<div class="detail-review__title">
													<span>텍스트 리뷰</span>
													<span><em>3,000</em>원</span>
												</div>
												<p>50자 이상의 실사용 후기 작성</p>
											</li>
											<li class="detail-review__item">
												<div class="detail-review__title">
													<span>포토 리뷰</span>
													<span><em>5,000</em>원</span>
												</div>
												<p>착용컷과 50자 이상의 실사용 후기</p>
											</li>
										</ul>
									</div>
									<div class="detail-review__box">
										<div class="title-sm">매달 베스트 리뷰 선정</div>
										<p>베스트 리뷰에 선정되시면, 등수에 따라 최대 50,000원의 적립금을 드립니다.</p>
										<div class="btn-box">
											<button type="button" class="btn-lg btn-gray-line" onclick="location.href='/customer/bestReview'">베스트 리뷰 보러가기</button>
										</div>
									</div>
								</div>
								<!-- <div class="detail-creama__review">크리마 리뷰 영역</div> -->
								<div id="devTabReview" class="tab-info view-detail ">
									<div class="crema-product-reviews" data-product-code="<?php echo (int) $TPL_VAR["id"];?>" style="margin-top: 20px;"></div>
								</div>
							</div>
						</div>
						<!-- // 상품 리뷰 -->
						<!-- 상품 정보 -->
						<div class="detail-tab__contents" id="devTapDetail">
							<?php echo html_entity_decode($TPL_VAR["basicinfo"])?>

						</div>
						<!-- 2024-04-02 상품상세 css 강제 변경 -->
						<script>
							$(document).ready(function() {
								$(".fs_l").css({"margin": "1 auto 40px", "width" : "100%" });
							});
						</script>
						<!-- // 2024-04-02 상품상세 css 강제 변경 -->
						<!-- // 상품 정보 -->

						<!-- 상품사이즈 가이드 -->
						<div class="detail-tab__contents" id="devTabRecom">
							<div class="detail-title__toggle active">
								<div class="title-sm">사이즈 가이드</div>
								<i class="ico ico-plus"></i>
							</div>
							<div class="detail-content">
								<style>.crema-fit-product-combined-detail { margin: 60px 0 0px;}</style>
								<div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" class="crema-fit-product-combined-detail"></div>
								<style> /* css 파일에 추가해 주세요 */
								.size_btn_box {padding:48px 0px 0 ; margin-top:48px; border-top:5px solid #E5E5E5; text-align:center; }
								.size_txt {font-size:18px; color:#000; margin-bottom:32px; }
								.size_btn {display: inline-block; width: 100%; background: #000; color: #fff; font-size: 16px; line-height: 48px; }

								</style>
							</div>
						</div>
						<!-- // 상품사이즈 가이드 -->
						<!-- 상품문의 -->
						<form id="devProductQnaForm">
							<input type="hidden" name="id" id="pid" value="<?php echo $TPL_VAR["pid"]?>" id="devQnaPid"/>
							<input type="hidden" name="qnaType" value="all" id="devQnaType"/>
							<input type="hidden" name="qnaDiv" value="all"/>
							<input type="hidden" name="page" value="1" id="devQnaPage"/>
							<input type="hidden" name="max" value="5" id="devQnaMax"/>
						</form>
						<div class="detail-tab__contents" id="devTabInquiry">
							<div class="detail-title__toggle active">
								<div class="title-sm">상품문의<span>(<?php echo number_format($TPL_VAR["qnaTotal"])?>)</span></div>
								<i class="ico ico-plus"></i>
							</div>
							<div class="detail-content">
								<div class="QnA-list__wrap">
									<ul class="QnA-list" id="devQnaContents">

										<!-- 답변 완료일 경우 li class="QnA-list__item" 에서 class="complete" 추가 -->
										<!-- 내가 쓴 글일 경우 li class="QnA-list__item" 에서 class="QnA-list__my" 추가 -->
										<li id="devQnaDetail" class="QnA-list__item {[#if isHidden]} QnA-list__my {[/if]} {[#if isResponse]}complete{[/if]} active">
											<!-- 비밀글일 경우 div class="QnA-list__title" 에서 class="lock" 추가 -->
											<div class="QnA-list__title devQnaDetailCover tab-qna__row" data-isSameUser="{[isSameUser]}" data-isHidden="{[isHidden]}">
												<a href="javascript:void(0);" class="QnA-list__link">
													<div class="QnA-list__title-top">
														<span class="writer" style="text-align:left;">{[bbs_name]}</span>
														<span class="status">{[#if isResponse]}답변완료{[else]}답변대기{[/if]}</span>
													</div>
													<div class="QnA-list__title-bottom">
														<span class="category" style="text-align:left;">{[div_name]}</span>
														<span class="subject">{[bbs_subject]}</span>
													</div>
												</a>
											</div>


											<div class="QnA-list__cont" id="devQnaDetailContents">
												<div class="QnA-list__Q" id="devQnaQuestion">
													<div class="QnA-list__Q-cont">{[bbs_contents]}</div>
													<!-- 내 글 / 답변이 안 달렸을 경우 수정 가능한 영역 노출 S -->
													{[#if isResponse]}
													{[else]}
													{[#if isSameUser]}
													<div class="QnA-list__Q-footer">
														<a href="javascript:void(0);" class="btn-link " data-bbs_ix="{[bbs_ix]}" data-pid="<?php echo $TPL_VAR["pid"]?>" onclick="qnaEdit('{[bbs_ix]}', '<?php echo $TPL_VAR["pid"]?>');SidePopupJS('product-QnA')">수정</a>
														<a href="javascript:void(0);" class="btn-link devDeleteQna" data-bbs_ix="{[bbs_ix]}">삭제</a>
													</div>
													{[/if]}
													{[/if]}
													<!-- 내 글 / 답변이 안 달렸을 경우 수정 가능한 영역 노출 E -->
												</div>
												<div class="QnA-list__A"  id="devQnaResponse">
													<div class="QnA-list__A-title">
														<span class="manager">BARREL 고객센터</span>
														<span class="day">{[regdate]}</span>
													</div>
													<div class="QnA-list__A-cont">
														{[cmt_contents]}
													</div>
												</div>
											</div>
										</li>
										<li id="devQnaEmpty" class="empty-content">등록된 상품문의가 없습니다.</li>

										<li id="devQnaLoading" class="QnA-list__item empty-content">
											<div class="wrap-loading"><div class="loading"></div></div>
										</li>
									</ul>

									<div class="QnA-list__btn">
										<div type="button"  id="devQnaPageWrap" class="btn-lg btn-gray-line">상품문의 더보기</div>
										<!-- <button class="tab-qna__write btn-default btn-dark btn-qna-write" id="devQnaWrite" data-pid="<?php echo $TPL_VAR["pid"]?>">상품 Q&A 작성하기</button> -->
										<button type="button" class="btn-lg btn-dark-line" data-pid="<?php echo $TPL_VAR["pid"]?>" onclick="SidePopupJS('product-QnA')">상품문의하기</button>
									</div>

								</div>
							</div>
						</div>
						<!-- // 상품문의 -->

						<!-- 연관 기획전 -->
						<div class="detail-tab__contents">

							<div class="detail-title__toggle active" <?php if(!$TPL_VAR["displayContentList"]){?>style="display: none;"<?php }?>>
								<div class="title-sm">연관 기획전</div>
								<i class="ico ico-plus"></i>
							</div>

							<div class="detail-content">
<?php if($TPL_VAR["displayContentList"]){?>
								<div class="fb-main__slide">
									<div class="fb-main__card-slider swiper-container goods-slider-add">
										<div class="swiper-wrapper">
<?php if($TPL_displayContentList_1){foreach($TPL_VAR["displayContentList"] as $TPL_V1){?>
												<div class="swiper-slide">
													<div class="fb-main__card-item">
														<div class="fb-main__card-title--sm" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["preface"]?></div>
														<dl class="fb-main__card-cont">
															<dt class="fb-main__card-img">
																<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
																	<img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="" />
																</a>
															</dt>
															<dd class="fb-main__card-textBOX">
																<a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
																	<div class="fb-main__card-title" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_title"]?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
																		<?php echo $TPL_V1["title"]?>

																	</div>
																	<p style="color:<?php echo $TPL_V1["c_explanation"]?>;<?php if($TPL_V1["b_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>">
																		<?php echo $TPL_V1["explanation"]?>

																	</p>
<?php if($TPL_V1["display_date_use"]=="Y"){?>
																	<div class="fb-main__card-day"><?php echo $TPL_V1["display_start"]?> ~ <?php echo $TPL_V1["display_end"]?></div>
<?php }?>
																</a>
																<!--<button type="button" class="btn-wishlist" onclick="contentWish('<?php echo $TPL_V1["con_ix"]?>');"><i class="ico ico-wishlist"></i>좋아요</button>-->
																<button type="button" class="btn-wishlist <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>product-box__heart--active<?php }?>" onclick="contentWish('<?php echo $TPL_VAR["pid"]?>','<?php echo $TPL_V1["con_ix"]?>', 'C', this)"><i class="ico ico-wishlist"></i>좋아요</button>
																<!--a href="javascript:void(0);" class="product-box__heart <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>product-box__heart--active<?php }?>" onclick="contentWish('<?php echo $TPL_VAR["pid"]?>','<?php echo $TPL_V1["con_ix"]?>', 'C', this)">좋아요</a-->
															</dd>
														</dl>
													</div>
												</div>
<?php }}?>
										</div>
										<div class="fb-main__card-control">
											<div class="swiper-control-group">
												<div class="swiper-scrollbar"></div>
												<div class="swiper-pagination"></div>
											</div>
										</div>
									</div>
								</div>
<?php }?>
								<div class="product-slider__list">
									<div class="product-slider__item">
										<div class="fb__cart-goods--slider swiper swiper-goods-default">
											<div class="product-slider__title">
												<h3>다른 고객님이 함께 구매한 상품</h3>
											</div>
											<ul class="fb__goods swiper-wrapper">
<?php if($TPL_togeterProduct_1){foreach($TPL_VAR["togeterProduct"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='stop'){?>
													<li class="fb__goods__list swiper-slide">
														<a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="fb__goods__link">
															<figure class="fb__goods__img">
																<div>
																	<img src="<?php echo $TPL_V1["image_src"]?>" alt="상품이미지" />
																</div>
															</figure>
															<div class="fb__goods__info">
																<ul class="fb__goods__infoBox">
																	<li class="fb__goods__etc"><?php echo $TPL_V1["prefaceName"]?></li>
																	<li class="fb__goods__name"><?php echo $TPL_V1["pname"]?></li>
																	<li class="fb__goods__option"><?php echo $TPL_V1["add_info"]?></li>
																	<li class="fb__goods__brand"></li>
																</ul>
															</div>
															<div class="fb__goods__important">
<?php if($TPL_V1["isDiscount"]){?>
																	<div class="fb__goods__sale">
																		<p class="per"><em><?php echo $TPL_V1["discount_rate"]?></em>%</p>
																	</div>
<?php }?>

																<span class="fb__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["dcprice"])?></span>
<?php if($TPL_V1["isDiscount"]){?>
																	<span class="fb__goods__noprice"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?></span>
<?php }?>
<?php if($TPL_V1["is_soldout"]){?>
																<!-- 품절일 경우 노출 S -->
																	<span class="fb__goods__price__state">품절</span>
																<!-- 품절일 경우 노출 S -->
<?php }?>
															</div>
															<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
														</a>
															<a href="javascript:void(0);" class="product-box__heart <?php if($TPL_V1["alreadyWish"]){?>product-box__heart--active<?php }?>" data-devWishBtn="<?php echo $TPL_V1["id"]?>">hart</a>
														<!--<a href="javascript:void(0);" class="product-box__heart product-box__heart">hart</a> --active -->
													</li>
<?php }else{?>
													<!--등록된 상품이 없을 시 S -->
														<li class="empty-content swiper-slide" id="devListEmpty">등록된 상품이 없습니다.</li>
													<!--등록된 상품이 없을 시 E -->
<?php }?>
<?php }}?>
											</ul>
											<button type="button" class="swiper-button swiper-button-prev"><i class="ico ico-arrow-left"></i>이전</button>
											<button type="button" class="swiper-button swiper-button-next"><i class="ico ico-arrow-right"></i>다음</button>
										</div>
									</div>
									<div class="product-slider__item">
										<div class="fb__cart-goods--slider swiper swiper-goods-default">
											<div class="product-slider__title">
												<h3>추천 상품</h3>
											</div>
											<ul class="fb__goods swiper-wrapper">
<?php if($TPL_similraProduct_1){foreach($TPL_VAR["similraProduct"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='stop'){?>
														<li class="fb__goods__list swiper-slide">
															<a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="fb__goods__link">
																<figure class="fb__goods__img">
																	<div>
																		<img src="<?php echo $TPL_V1["image_src"]?>" alt="상품이미지" />
																	</div>
																</figure>
																<div class="fb__goods__info">
																	<ul class="fb__goods__infoBox">
																		<li class="fb__goods__etc"><?php echo $TPL_V1["prefaceName"]?></li>
																		<li class="fb__goods__name"><?php echo $TPL_V1["pname"]?></li>
																		<li class="fb__goods__option"><?php echo $TPL_V1["add_info"]?></li>
																		<li class="fb__goods__brand"></li>
																	</ul>
																</div>
																<div class="fb__goods__important">
<?php if($TPL_V1["isDiscount"]){?>
																		<div class="fb__goods__sale">
																			<p class="per"><em><?php echo $TPL_V1["discount_rate"]?></em>%</p>
																		</div>
<?php }?>
																		<span class="fb__goods__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["dcprice"])?></span>
<?php if($TPL_V1["isDiscount"]){?>
																		<span class="fb__goods__noprice"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?></span>
<?php }?>
<?php if($TPL_V1["is_soldout"]){?>
																		<span class="fb__goods__price__state">[품절]</span>
<?php }?>
																</div>
																<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
															</a>
															<a href="javascript:void(0);" class="product-box__heart <?php if($TPL_V1["alreadyWish"]){?>product-box__heart--active<?php }?>" data-devWishBtn="<?php echo $TPL_V1["id"]?>">hart</a>
															<!--<a href="javascript:void(0);" class="product-box__heart product-box__heart">hart</a> --active -->
														</li>
<?php }else{?>
													<!--등록된 상품이 없을 시 S -->
														<li class="empty-content swiper-slide" id="devListEmpty">등록된 상품이 없습니다.</li>
													<!--등록된 상품이 없을 시 E -->
<?php }?>
<?php }}?>
											</ul>
											<button type="button" class="swiper-button swiper-button-prev"><i class="ico ico-arrow-left"></i>이전</button>
											<button type="button" class="swiper-button swiper-button-next"><i class="ico ico-arrow-right"></i>다음</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- //연관 기획전 -->
					</div>
					<!-- //상품관련 메뉴 내용 -->
				</div>
			</div>
		</section>
		<!-- // 하단 상품상세 - 왼쪽 메인 영역 -->
	</div>
	<div class="fb__goods-view__right">
		<section class="fb__goods-view__info fb-scroll">
			<div class="info">
				<!-- 상품정보 우측 상단 -->
				<div class="info__header">
<?php if($TPL_VAR["icons_path"]){?>
<?php if($TPL_icons_path_1){foreach($TPL_VAR["icons_path"] as $TPL_V1){?>
					<span class="fb__badge--water">
						<?php echo $TPL_V1?>

					</span>
<?php }}?>
<?php }?>
					<div class="info__preface" style="color:<?php echo $TPL_VAR["prefaceColor"]?>;<?php if($TPL_VAR["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["prefaceName"]?></div>
					<div class="info__name"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></div>
					<div class="info__shotinfo"><?php echo $TPL_VAR["add_info"]?></div>
					<div class="info__model-number"><?php echo $TPL_VAR["pcode"]?></div>
					<div class="info__price">
<?php if($TPL_VAR["discount_rate"]> 0){?><div class="info__price--percent"><em><?php echo $TPL_VAR["discount_rate"]?></em>%</div><?php }?>
						<div class="info__price--now"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
<?php if($TPL_VAR["discount_rate"]> 0){?><div class="info__price--ori"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["listprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></div><?php }?>
					</div>
					<div class="info__header-group">
						<div class="btn-group">
							<button type="button" class="product-box__heart2 <?php if($TPL_VAR["alreadyWish"]){?>product-box__heart--active<?php }?>" style="position:static;" onclick="goodsWish('<?php echo $TPL_VAR["pid"]?>', this)"><i class="ico ico-wishlist"></i>좋아요</button>

							<!-- <button type="button" class="product-box__heart<?php if($TPL_VAR["alreadyWish"]){?> product-box__heart--active<?php }?>" style="position:static;" data-devWishBtn="<?php echo $TPL_VAR["pid"]?>"><i class="ico ico-wishlist">좋아요</i></button>
							<!--<button type="button" class="btn-share" onclick="benefitsInfo('goodsView-share',0)"><i class="ico ico-share">공유하기</i></button>-->
							<button type="button" class="btn-share" onclick="NewPopupJSNew('goodsView-share')"><i class="ico ico-share">공유하기</i></button>
						</div>
<?php if($TPL_VAR["couponApplyCnt"]> 0){?>
						<button type="button" class="btn-s btn-dark-line info__coupon-btn" onclick="SidePopupJS('coupon-part1')">쿠폰받기</button>
<?php }?>
					</div>
				</div>
				<!-- // 상품정보 우측 상단 -->

				<!-- // 상품정보 우측 하단 -->
				<div class="info__content">
					<div class="info__content-btn">
						<!--<button type="button" class="btn-s btn-dark-line btn-benefit info__benefit" onclick="benefitsInfo('goodsView-benefits',0)">혜택 내역</button>-->
						<button type="button" class="btn-s btn-dark-line btn-benefit info__benefit" onclick="NewPopupJSNew('goodsView-benefits')">혜택 내역</button>
					</div>
					<!-- 구매 혜택 적립금 S -->
					<div class="info__box info__box-mileage">
						<dl class="info__list">
							<dt class="info__list-title">
								구매 예상 적립금
								<p class="txt-guide">적립금은 실제 결제 금액에 따라 달라집니다.</p>
							</dt>
							<dd class="info__list-cont">
								<div class="info__mileage"><span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["save_reserve"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
							</dd>
						</dl>
					</div>
					<!-- 구매 혜택 적립금 E -->
					<!-- 상품 리뷰 S -->
<?php if($TPL_VAR["langType"]=='korean'){?>
					<div class="info__box">
						<dl class="info__list">
							<dt class="info__list-title">상품 리뷰</dt>
							<dd class="info__review-score">
								<a href="javascript:void(0);" class="info__box-link" title="devTabReview">
									<div class="product-review__star-wrap">
										<div class="product-review__star">
											<!-- <span data-widths="<?php echo $TPL_VAR["total_review_star_per"]?>"></span> -->
											<span style="width: <?php echo $TPL_VAR["total_review_star_per"]?>"></span>
										</div>
										<span class="product-review__star-number">(<?php echo $TPL_VAR["total_review_cnt"]?>)</span>
									</div>
								</a>
							</dd>
						</dl>
					</div>
<?php }else{?>
<?php }?>
					<!-- 상품 리뷰 E -->


					<!-- 상품 색상 S -->
<?php if($TPL_VAR["product_type"]== 0&&$TPL_VAR["add_info"]!=''){?>
					<div class="info__box info__box-color">
						<dl class="info__list">
							<dt class="info__list-title">
								<div class="info__title">색상</div>
								<span class="info__select"><?php echo $TPL_VAR["add_info"]?></span>
							</dt>
							<dd class="info__list-cont">
<?php if($TPL_VAR["sameProduct"]){?>
								<ul class="info-color">
<?php if($TPL_sameProduct_1){foreach($TPL_VAR["sameProduct"] as $TPL_V1){?>
									<li class="info-color__item">
										<a href="/shop/goodsView/<?php echo $TPL_V1["pid"]?>" class="info-color__link <?php if($TPL_VAR["pid"]==$TPL_V1["pid"]){?>active<?php }?>">
											<!--선택시 a태그 class에 active 추가-->
<?php if($TPL_V1["pattImg"]==''){?>
												<img src="<?php echo $TPL_V1["filterImg"]?>" alt="색상이미지" />
<?php }else{?>
												<img src="<?php echo $TPL_V1["pattImg"]?>" alt="패턴이미지" />
<?php }?>
										</a>
									</li>
<?php }}?>
								</ul>
<?php }?>
							</dd>
						</dl>
					</div>
<?php }?>
					<!-- 상품 색상 E -->

					<!-- 상품 색상칩셋 S
<?php if($TPL_VAR["colorChipList"]){?>
					<div class="info__box info__box-color">
<?php if($TPL_colorChipList_1){foreach($TPL_VAR["colorChipList"] as $TPL_K1=>$TPL_V1){?>
						<dl class="info__list">
							<dt class="info__list-title">
								<div class="info__title"></div>
<?php if($TPL_K1=='1'&&!empty($TPL_VAR["relation_text1"])){?>
								<span class="info__select"><?php echo $TPL_VAR["relation_text1"]?></span>
<?php }?>
<?php if($TPL_K1=='2'&&!empty($TPL_VAR["relation_text2"])){?>
								<span class="info__select"><?php echo $TPL_VAR["relation_text2"]?></span>
<?php }?>
							</dt>
							<dd class="info__list-cont">
								<ul class="info-color">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
									<li class="info-color__item">
										<a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>" class="info-color__link <?php if($TPL_VAR["pid"]==$TPL_V1["pid"]){?>active<?php }?>">
											선택시 a태그 class에 active 추가
											<img src="<?php echo $TPL_V2["filterImg"]?>" alt="색상이미지" />
										</a>
									</li>
<?php }}?>
								</ul>
							</dd>
						</dl>
<?php }}?>
					</div>
<?php }?>
					 상품 색상칩셋 E -->


			<!-- S -->


                <div class="info__box option" id="devMinicartArea" data-pid="<?php echo $TPL_VAR["pid"]?>" style="border-top:none; padding-top:6px;">
                    <!--<p class="option-tit">옵션선택</p>-->
                    <div class="devForbizTpl" id="devLonelyOption">
                        <span id="devLonelyOptionName">
                            <p>{[option_name]}</p>
                        </span>
                    </div>

                    <div id="devMinicartOptions" class="info__box info__box-size"></div>

                    <!-- cre.ma / 통합 요약 위젯 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
                    <style>.fb__goods-view .goods-info__size {padding-top: 40px;}</style>
                    <style>.crema-fit-product-combined-summary { margin-top:40px; margin-bottom:20px; padding-left: 108px;}</style>
                    <div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" class="crema-fit-product-combined-summary" style="display:none;"></div>

					<!--사은품
					<div class="goods-option">
<?php if($TPL_VAR["product_gift"]){?>
                        <div class="goods-info__set">
                            <h4 class="goods-info__set__title">사은품 선택</h4>

                            <ul class="goods-info__set__list">
<?php if($TPL_product_gift_1){$TPL_I1=-1;foreach($TPL_VAR["product_gift"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1<$TPL_VAR["gift_selectbox_cnt"]){?>
                                <li class="goods-info__set__box">
                                    <select class="devProductGift_<?php echo $TPL_I1?> devGiftSelect" data-idx="<?php echo $TPL_I1?>">
                                        <option value=""> 선택해 주세요 </option>
<?php if(is_array($TPL_R2=$TPL_V1["product_gift_detail"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                                        <option value="<?php echo $TPL_V2["pid"]?>" <?php if($TPL_V2["status"]=='soldout'){?> disabled <?php }?>><?php echo $TPL_V2["pname"]?> <?php if($TPL_V2["status"]=='soldout'){?> [[품절]] <?php }?></option>
<?php }}?>
                                    </select>
                                </li>
<?php }?>
<?php }}?>
                            </ul>
                        </div>
<?php }?>
                    </div>
                    -->
                </div>
				<div class="info__box-footer">
					<button type="button" class="btn-link goods-info__size__guide" onclick="SidePopupJS('size-guide')">신체 사이즈 가이드</button>
				</div>

				<!-- 추가 상품 옵션 S -->
				<div class="info__box info__box-addition" id="devMinicartTopAddOption" style="display:none;">
					<dl class="info__list active" id="dlClassTag">
						<dt class="info__list-title">
							<div class="info__title">
								<a class="info__title-toggle" href="javascript:void(0);">추가 옵션 상품 <i class="ico ico-plus" onclick="addOption();"></i></a>
							</div>
						</dt>
						<dd class="info__list-cont" style="display: block" id="devMinicartAddOption">

						</dd>
					</dl>
				</div>
				<!-- 추가 상품 옵션 E -->

				<!-- 추가 상품 옵션 S -- 
				<div class="info__box info__box-addition">
					<dl class="info__list active">

						<dt class="info__list-title">
							<div class="info__title">
								<a class="info__title-toggle" href="#;">추가 옵션 상품 <i class="ico ico-plus"></i></a>
							</div>
						</dt>
						<dd class="info__list-cont" style="display: block">
							<dl class="product-item" style="border-top:0px;">
								<dt class="product-item__thumbnail-box">
									<div class="product-item__thumb">
										<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
									</div>
								</dt>
								<dd class="product-item__infobox">
									<div class="product-item__info">
										<div class="product-item__title c-pointer">우먼 피쉬백 스트랩 스윔 브라탑</div>
										<div class="product-item__option">
											<span>미드나잇</span>
										</div>
										<div class="product-item__price-group">
											<div class="product-item__price-percent">30%</div>
											<div class="product-item__price price"><em>1,405,550</em>원</div>
											<div class="product-item__noprice"><del>1,265,550</del>원</div>
										</div>
										<div class="product-item__footer">
											<div class="fb__form-item">
												<select class="fb__form-select">
													<option value="">색상 [필수]</option>
												</select>
											</div>
										</div>
									</div>
								</dd>
							</dl>
							<dl class="product-item" style="border-top:0px;">
								<dt class="product-item__thumbnail-box">
									<div class="product-item__thumb">
										<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
									</div>
								</dt>
								<dd class="product-item__infobox">
									<div class="product-item__info">
										<div class="product-item__title c-pointer">우먼 피쉬백 스트랩 스윔 브라탑</div>
										<div class="product-item__option">
											<span>미드나잇</span>
										</div>
										<div class="product-item__price-group">
											<div class="product-item__price-percent">30%</div>
											<div class="product-item__price price"><em>1,405,550</em>원</div>
											<div class="product-item__noprice"><del>1,265,550</del>원</div>
										</div>
										<div class="product-item__footer">
											<div class="fb__form-item">
												<select class="fb__form-select">
													<option value="">색상 [필수]</option>
												</select>
											</div>
										</div>
									</div>
								</dd>
							</dl>
						</dd>
					</dl>
				</div>
				 추가 상품 옵션 E -->



					<!-- 사은품 옵션 S -->
<?php if($TPL_VAR["product_gift"]){?>
					<div class="info__box info__box-gifts">
						<dl class="info__list active">
							<dt class="info__list-title">
								<div class="info__title">
									<a class="info__title-toggle" href="javascript:void(0);">사은품 <i class="ico ico-plus"></i></a>
								</div>
							</dt>
							<dd class="info__list-cont" style="display: block">
								<dl class="product-item">
									<dt class="product-item__thumbnail-box">
										<div class="product-item__thumb">
											<img id="giftImg" src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_freebie_sel.png" alt="" />
										</div>
									</dt>
									<dd class="product-item__infobox">
										<div class="product-item__info">
<?php if($TPL_productGiftInfo_1){foreach($TPL_VAR["productGiftInfo"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='soldout'){?>
											<div class="product-item__title c-pointer" id="giftPname"></div>
											<div class="product-item__option">
												<span id="giftDate"></span>
											</div>
											<div class="product-item__price-group">
												<div class="product-item__price price" id="giftPrice"></div>
											</div>

											<input type="hidden" id="giftPname_<?php echo $TPL_V1["pid"]?>" value="<?php echo $TPL_V1["pname"]?>">
											<input type="hidden" id="giftDate_<?php echo $TPL_V1["pid"]?>" value="행사기간 : <?php echo $TPL_V1["sell_priod_sdate"]?> ~ <?php echo $TPL_V1["sell_priod_edate"]?>">
											<input type="hidden" id="giftPrice_<?php echo $TPL_V1["pid"]?>" value="<em><?php echo $TPL_V1["add_info"]?></em>원 상당">
<?php }?>
<?php }}?>
											<input type="hidden" id="giftPname_0000055421" value="">
											<input type="hidden" id="giftDate_0000055421" value="">
											<input type="hidden" id="giftPrice_0000055421" value="">
											<input type="hidden" id="giftPname_" value="">
											<input type="hidden" id="giftDate_" value="">
											<input type="hidden" id="giftPrice_" value="">
											<div class="product-item__footer" style="margin-top:auto;">
<?php if($TPL_product_gift_1){$TPL_I1=-1;foreach($TPL_VAR["product_gift"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1<$TPL_VAR["gift_selectbox_cnt"]){?>
												<div class="fb__form-item">
													<select class="fb__form-select devProductGift_<?php echo $TPL_I1?> devGiftSelect" data-idx="<?php echo $TPL_I1?>" onchange="giftImgChange(this.value)">
														<option value="">사은품 선택 </option>
<?php if(is_array($TPL_R2=$TPL_V1["product_gift_detail"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
														<option value="<?php echo $TPL_V2["pid"]?>" <?php if($TPL_V2["status"]=='soldout'){?> disabled <?php }?>><?php echo $TPL_V2["pname"]?> <?php if($TPL_V2["status"]=='soldout'){?> [[품절]] <?php }?></option>
<?php }}?>
<?php if($TPL_VAR["gift_selectbox_nooption_yn"]=="Y"){?>
														<option value="0000055421">사은품 선택 안함</option>
<?php }?>
													</select>
<?php if(is_array($TPL_R2=$TPL_V1["product_gift_detail"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
													<input type="hidden" name="giftImg" id="giftImg_<?php echo $TPL_V2["pid"]?>" value="<?php echo $TPL_V2["image_src"]?>">
<?php }}?>
<?php if($TPL_VAR["gift_selectbox_nooption_yn"]=="Y"){?>
													<input type="hidden" name="giftImg" id="giftImg_0000055421" value="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_no-freebie.png">
<?php }?>
													<input type="hidden" name="giftImg" id="giftImg_" value="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_freebie_sel.png">
												</div>
<?php }?>
<?php }}?>
											</div>
										</div>
									</dd>
								</dl>
							</dd>
						</dl>
					</div>
<?php }?>
					<!-- 사은품 옵션 E -->

				<!-- 옵션 선택 후 노출되는 옵션 영역 S -->
				<div class="info__decided option-box" id="devMinicartSelected">
					<!-- 옵션 S -->
					<div class="info__decided-box devOptionBox devForbizTpl" devPid="{[pid]}" devOptionKind="{[option_kind]}" devOptid="{[option_id]}" devUnit="{[option_dcprice]}" devStock="{[option_stock]}">
						<div class="info__decided-info">
							<div class="info__decided-title tit">{[option_prefix]}{[pname]}</div>
							<button class="info__decided__del btn-option-del devMinicartDelete">삭제</button>
						</div>
						<dl class="info__decided-group">
							<dt class="info__decided-option--list">
								<!-- 일반 옵션 S -->
								<div class="info__decided-option">
									<!--<span>{[add_info_text]}<br />{[option_div_text]}</span>
									<span>{[add_info_text]} {[option_div_text]}</span>-->
									<span>{[add_info_text]}</span>
									<span>{[option_div_text]}</span>
									<span class="info__decided-price price"> <em class="devMinicartEachPrice">{[eachPrice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?> </span>
								</div>
								<!-- 일반 옵션 E -->
							</dt>
							<dd class="info__decided-quantity">
								<div class="product-quantity__control control">
									<ul class="option-up-down">
										<li>
											<button type="button" class="btn-down down devCountDownButton"><i class="ico ico-minus devCntMinus"></i>DOWN</button>
										</li>
										<li><input type="text" value="{[allowBasicCnt]}" class="devCount option-text devMinicartPrdCnt" /></li>
										<li>
											<button type="button" class="btn-up up devCountUpButton"><i class="ico ico-plus devCntPlus"></i>UP</button>
										</li>
									</ul>
								</div>
							</dd>
						</dl>
					</div>
					<!-- 옵션 E -->
				</div>
				<!-- 옵션 선택 후 노출되는 옵션 영역 E -->
			<!-- E -->

					<!-- 총금액/구매버튼 S -->
					<div class="info__box info__total-box total-price">
						<dl class="info__list">
							<dt class="info__list-title">총 상품 금액</dt>
							<dd class="info__list-cont info__total-price"><em id="devMinicartTotal">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
						</dl>
					</div>
					<div class="goods-btn-area">
						<div class="btn-group">
							<!--<button type="button" class="btn-lg btn-dark-line" onclick="NewPopupJS('goodsView-AddToCart')">장바구니</button>
							<button type="button" class="btn-lg btn-dark" onclick="NewPopupJS('goodsView-member')">구매하기</button>-->
							<button type="button" class="btn-lg btn-dark-line devAddCart devAddCart__layerBtn" onclick="teraCart('<?php echo $TPL_VAR["pid"]?>')">장바구니</button>
							<button type="button" class="btn-lg btn-dark devOrderDirect">구매하기</button>
						</div>
						<!-- 장바구니 담겼을 경우 팝업 S -->
						<div class="popup-layout" id="goodsView-AddToCart" style="display:none;position:absolute;top:-224px;left:-78px;width:390px;height:196px;background:#fff;border:1px solid #000;">
							<div class="popup-title">
								<span id="devModalTitle">장바구니에 상품을 담았습니다.</span>
								<button type="button" class="btn-close close" style="width:auto;" onclick="cartPopClose(1);">닫기</button>
							</div>
							<div id="devModalContent" class="popup-content">
								<section class="popup-content__wrap">
									<div class="btn-group--col">
										<button type="button" class="btn-lg btn-dark-line" onclick="cartPopClose(2);">장바구니 보러가기</button>
										<button type="button" class="btn-lg btn-dark" onclick="cartPopClose(1);">쇼핑 계속하기</button>
									</div>
								</section>
							</div>
						</div>
						<!-- 장바구니 담겼을 경우 팝업 E -->
						<button type="button" class="btn-default btn-gray-line btn-find-store" onclick="SidePopupJS('store')">구매가능 매장</button>
					</div>
					<!-- 총금액/구매버튼 E -->
					<!-- 배송 혜택 S -->
					<div class="info__box info__box-delivery">
						<dl class="info__list">
							<dt class="info__list-title">배송혜택</dt>
							<dd class="info__list-cont">
								30,000원 이상 구매 시 무료배송.<br />
								(도서산간 및 제주 3,000원 추가)
							</dd>
						</dl>
					</div>
					<!-- 배송 혜택 E -->
					<!-- 반품/교환/세탁/배송/상품 정보 제공고시 S -->
					<ul class="info__link-list">
						<li class="info__link-item">
							<a href="javascript:void(0);" onclick="SidePopupJS('return-refund')">반품 & 환불 안내<i class="ico ico-arrow-right"></i></a>
						</li>
						<li class="info__link-item">
							<a href="javascript:void(0);" onclick="SidePopupJS('wash-precautions')">세탁 & 주의사항<i class="ico ico-arrow-right"></i></a>
						</li>
						<li class="info__link-item">
							<a href="javascript:void(0);" onclick="SidePopupJS('delivery-info')">배송안내<i class="ico ico-arrow-right"></i></a>
						</li>
<?php if($TPL_VAR["mandatory_use"]=='Y'){?>
						<li class="info__link-item">
							<a href="javascript:void(0);" onclick="SidePopupJS('product-info')">상품정보 제공고시<i class="ico ico-arrow-right"></i></a>
						</li>
<?php }?>
					</ul>
					<!-- 반품/교환/세탁/배송/상품 정보 제공고시 E -->
				</div>
				<!-- // 상품정보 우측 하단 -->
			</div>

			<!-- 우측 메뉴 전용 레이어 팝업 영역 S -->
			<!-- 재입고 알림 신청 S -->
			<!-- 기본 S -->
			<div class="fb__goods-view__layer" id="restock">
				<div class="side-popup__wrap">
					<div class="side-popup__header">
						<a href="javascript:void(0);" class="btn-close">닫기</a>
						<div class="title-md">재입고 알림 신청</div>
					</div>
					<div class="side-popup__content-wrap">
						<div class="side-popup__content">
							<div class="txt-desc">
								<p>품절된 상품이 재입고되는 즉시 등록하신 휴대폰 번호로 재입고 알림 문자를 보내드립니다.</p>
							</div>
							<div class="restock-wrap">
								<div class="popup-product">
									<div class="popup-product__left">
										<figure class="popup-product__thumb">
<?php if($TPL_image_src_1){$TPL_I1=-1;foreach($TPL_VAR["image_src"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
												<img src="<?php echo $TPL_V1["basic_img"]?>" alt="" />
<?php }?>
<?php }}?>
										</figure>
									</div>
									<div class="popup-product__info goods-info">
										<div class="goods-info__title"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></div>
										<div class="goods-info__option">
											<span><?php echo $TPL_VAR["add_info"]?></span>
										</div>
										<dl class="goods-info__price-group">
											<dd>
												<div class="goods-info__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["dcprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
											</dd>
										</dl>
										<div class="goods-info__footer">
											<div class="fb__form-item">
												<select class="fb__form-select" name="option_id" id="option_id">
													<option value="">사이즈 선택</option>
<?php if($TPL_optionData_1){foreach($TPL_VAR["optionData"] as $TPL_V1){?>
<?php if(is_array($TPL_R2=$TPL_V1["optionDetailList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["option_stock"]== 0){?>
															<option value="<?php echo $TPL_V2["division"]?>"><?php echo $TPL_V2["shot_option_div"]?></option>
<?php }?>
<?php }}?>
<?php }}?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="restock-phone">
									<div class="fb__form-item">
										<label for="Phone" class="fb__form-label hide">신청 휴대폰 번호</label>
										<select class="fb__form-select" name="pcs1" id="devPcs1" disabled>
											<option value="010" <?php if($TPL_VAR["pcs1"]=='010'){?>selected<?php }?>>010</option>
											<option value="011" <?php if($TPL_VAR["pcs1"]=='011'){?>selected<?php }?>>011</option>
											<option value="016" <?php if($TPL_VAR["pcs1"]=='016'){?>selected<?php }?>>016</option>
											<option value="017" <?php if($TPL_VAR["pcs1"]=='017'){?>selected<?php }?>>017</option>
											<option value="018" <?php if($TPL_VAR["pcs1"]=='018'){?>selected<?php }?>>018</option>
											<option value="019" <?php if($TPL_VAR["pcs1"]=='019'){?>selected<?php }?>>019</option>
										</select>
										<input type="text" placeholder="0000" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["pcs2"]?>" class="fb__form-input" disabled />
										<input type="text" placeholder="0000" name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["pcs3"]?>" class="fb__form-input" disabled />
									</div>
								</div>
								<div class="restock-checkbox">
									<div class="fb__form-item">
										<input type="checkbox" class="fb__form-checkbox" name="change_pcs" id="devChangePcs" value="Y"/>
										<label for="PhoneChange">휴대번 번호 변경</label>
									</div>
									<div class="restock-checkbox__desc">
										<p>SMS 요청이 완료된 상품은 재입고 알림 목록으로 저장됩니다.</p>
										<p>SMS 요청상품의 가격, 옵션 구성 등의 상품정보가 변동될 수 있으므로, 재입고 시 상품정보 확인 후 구매하시기 바랍니다.</p>
										<p>재입고 SMS알림은 요청일로부터 15일간 유효합니다.</p>
									</div>
								</div>
								<div class="btn-box">
									<button type="button" class="btn-lg btn-dark-line" id="devSumbitBtn">재입고 알림 신청하기</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 기본 E -->

			<!-- 핸드폰 번호 번경 S -->
			<div class="fb__goods-view__layer" id="restock2">
				<div class="side-popup__wrap">
					<div class="side-popup__header">
						<a href="javascript:void(0);" class="btn-close">닫기</a>
						<div class="title-md">재입고 알림 신청</div>
					</div>
					<div class="side-popup__content-wrap">
						<div class="side-popup__content">
							<div class="txt-desc">
								<p>품절된 상품이 재입고되는 즉시 등록하신 휴대폰 번호로 재입고 알림 문자를 보내드립니다.</p>
							</div>
							<div class="restock-wrap">
								<div class="popup-product">
									<div class="popup-product__left">
										<figure class="popup-product__thumb">
											<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
										</figure>
									</div>
									<div class="popup-product__info goods-info">
										<div class="goods-info__title">우먼 모션 크롭 집업 래쉬가드</div>
										<div class="goods-info__option">
											<span>미드나잇</span>
										</div>
										<dl class="goods-info__price-group">
											<dd>
												<div class="goods-info__price">1,265,550원</div>
											</dd>
										</dl>
										<div class="goods-info__footer">
											<div class="fb__form-item">
												<select class="fb__form-select">
													<option>사이즈 선택</option>
													<option>90</option>
													<option>95</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="restock-phone">
									<div class="fb__form-item">
										<label for="Phone" class="fb__form-label hide">신청 휴대폰 번호</label>
										<select class="fb__form-select" id="Phone">
											<option>010</option>
										</select>
										<input type="text" placeholder="0000" value="1234" class="fb__form-input" />
										<input type="text" placeholder="0000" value="1234" class="fb__form-input" />
									</div>
								</div>
								<div class="restock-checkbox">
									<div class="fb__form-item">
										<input type="checkbox" class="fb__form-checkbox" id="PhoneChange" checked />
										<label for="PhoneChange">휴대번 번호 변경</label>
									</div>
									<div class="restock-checkbox__desc">
										<p>SMS 요청이 완료된 상품은 재입고 알림 목록으로 저장됩니다.</p>
										<p>SMS 요청상품의 가격, 옵션 구성 등의 상품정보가 변동될 수 있으므로, 재입고 시 상품정보 확인 후 구매하시기 바랍니다.</p>
										<p>재입고 SMS알림은 요청일로부터 15일간 유효합니다.</p>
									</div>
								</div>
								<div class="btn-box">
									<button type="button" class="btn-lg btn-dark-line" onclick="SidePopupJS('restock3')">재입고 알림 신청하기</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 핸드폰 번호 번경 E -->

			<!-- 재입고 알림 신청 완료 S -->
			<div class="fb__goods-view__layer" id="restock3">
				<div class="side-popup__wrap">
					<div class="side-popup__header">
						<a href="javascript:void(0);" class="btn-close">닫기</a>
						<div class="title-md">재입고 알림 신청이 완료되었습니다.</div>
					</div>
					<div class="side-popup__content-wrap">
						<div class="side-popup__content">
							<div class="txt-desc">
								<p>품절된 상품이 재입고되는 즉시 등록하신 휴대폰 번호로 재입고 알림 문자를 보내드립니다.</p>
							</div>
							<div class="restock-wrap">
								<div class="popup-product">
									<div class="popup-product__left">
										<figure class="popup-product__thumb">
											<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="" />
										</figure>
									</div>
									<div class="popup-product__info goods-info">
										<div class="goods-info__title">우먼 모션 크롭 집업 래쉬가드</div>
										<div class="goods-info__option">
											<span>미드나잇</span>
										</div>
										<dl class="goods-info__price-group">
											<dd>
												<div class="goods-info__price">1,265,550원</div>
											</dd>
										</dl>
										<div class="goods-info__footer">
											<div class="fb__form-item">
												<select class="fb__form-select" disabled>
													<option>사이즈 선택</option>
													<option>90</option>
													<option selected>95</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="restock-phone">
									<div class="fb__form-item">
										<label for="Phone" class="fb__form-label">신청 휴대폰 번호</label>
										<select class="fb__form-select" id="Phone" disabled>
											<option>010</option>
										</select>
										<input type="text" placeholder="0000" value="1234" class="fb__form-input" disabled />
										<input type="text" placeholder="0000" value="1234" class="fb__form-input" disabled />
									</div>
								</div>
								<div class="restock-checkbox">
									<div class="fb__form-item" style="display: none">
										<input type="checkbox" class="fb__form-checkbox" id="PhoneChange" checked />
										<label for="PhoneChange">휴대번 번호 변경</label>
									</div>
									<div class="restock-checkbox__desc">
										<p>SMS 요청이 완료된 상품은 재입고 알림 목록으로 저장됩니다.</p>
										<p>SMS 요청상품의 가격, 옵션 구성 등의 상품정보가 변동될 수 있으므로, 재입고 시 상품정보 확인 후 구매하시기 바랍니다.</p>
										<p>재입고 SMS알림은 요청일로부터 15일간 유효합니다.</p>
									</div>
								</div>
								<div class="btn-box">
									<button type="button" class="btn-lg btn-dark-line">닫기</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 재입고 알림 신청 완료 E -->
			<!-- 재입고 알림 신청 E -->

			<!-- 쿠폰 받기 S -->
			<div class="fb__goods-view__layer devCouponContents" id="coupon-part1">
				<div class="side-popup__wrap">
					<div class="side-popup__header">
						<a href="javascript:void(0);" class="btn-close">닫기</a>
						<div class="title-md">쿠폰 받기</div>
					</div>
					<div class="side-popup__content-wrap">
						<div class="side-popup__content">
							<div class="coupon-wrap">
								<!--<div class="btn-box">
									<button type="button" class="btn-lg btn-dark">쿠폰 전체 받기</button>
								</div>-->
								<div class="coupon-list">
<?php if($TPL_couponList_1){foreach($TPL_VAR["couponList"] as $TPL_V1){
$TPL_DownUse_2=empty($TPL_V1["DownUse"])||!is_array($TPL_V1["DownUse"])?0:count($TPL_V1["DownUse"]);?>
<?php if($TPL_DownUse_2){foreach($TPL_V1["DownUse"] as $TPL_V2){?>
									<div class="coupon-item">
										<dl class="coupon-box">
											<dt class="coupon-box__top">
												<span class="day">
<?php if($TPL_V1["use_date_type"]=='9'){?>
														무기한
<?php }elseif($TPL_V1["use_date_type"]=='1'){?>
														<?php echo $TPL_V1["regdate"]?> ~ <?php echo $TPL_V1["publish_limit_date"]?>

<?php }elseif($TPL_V1["use_date_type"]=='2'){?>
														발급 후 <?php echo $TPL_V1["regist_date_differ"]?>

<?php if($TPL_V1["regist_date_type"]=='3'){?>
															일
<?php }elseif($TPL_V1["regist_date_type"]=='2'){?>
															개월
<?php }elseif($TPL_V1["regist_date_type"]=='1'){?>
															년
<?php }?>
														이내 사용 가능
<?php }elseif($TPL_V1["use_date_type"]=='3'){?>
														<?php echo $TPL_V1["use_sdate"]?> ~ <?php echo $TPL_V1["use_edate"]?>

<?php }?>
												</span>
												<span class="count txt-red">1장 발급 가능</span>
											</dt>
											<dd class="coupon-box__bottom">
												<div class="title-lg"><span><?php echo number_format($TPL_V1["cupon_sale_value"])?></span><?php if($TPL_V1["cupon_sale_type"]=='1'){?>%<?php }else{?>원<?php }?> 할인</div>
												<p class="name txt-dark">
<?php if($TPL_V1["use_product_type"]=='1'){?>
														전 상품 대상 할인 쿠폰
<?php }elseif($TPL_V1["use_product_type"]=='2'){?>
														특정 카테고리 상품 대상 할인 쿠폰
<?php }elseif($TPL_V1["use_product_type"]=='3'){?>
														특정 상품 대상 할인 쿠폰
<?php }?>
												</p>
												<p class="desc txt-gray">
<?php if($TPL_V1["publish_min"]=='N'){?>
														제한조건없음
<?php }else{?>
														<?php echo number_format($TPL_V1["publish_condition_price"])?> 원 이상 구매시
<?php }?>
												</p>
											</dd>
										</dl>
										<div class="btn-box">
<?php if($TPL_V2["DownUse"]=='N'){?>
												<button type="button" class="btn-lg btn-dark-line" disabled>다운로드 완료</button>
<?php }else{?>
												<button type="button" class="btn-lg btn-dark-line" devPublishIx="<?php echo $TPL_V1["publish_ix"]?>">쿠폰 받기</button>
<?php }?>
										</div>
										<!--<a href="javascript:void(0);" class="btn-link">적용대상 상품 보기</a>-->
									</div>
<?php }}?>
<?php }}?>
									<!--
									<div class="coupon-item">
										<dl class="coupon-box">
											<dt class="coupon-box__top">
												<span class="day">2024.12.31 ~ 2025.12.31</span>
												<span class="count txt-red">99장 발급 가능</span>
											</dt>
											<dd class="coupon-box__bottom">
												<div class="title-lg"><span>99</span>% 할인</div>
												<p class="name txt-dark">전 상품 대상 할인 쿠폰</p>
												<p class="desc txt-gray">30.000원 이상 구매 시 사용 가능. (최대 999,999원 할인)</p>
											</dd>
										</dl>
										<div class="btn-box">
											<button type="button" class="btn-lg btn-dark-line">쿠폰 받기</button>
										</div>
										<a href="javascript:void(0);" class="btn-link">적용대상 상품 보기</a>
									</div>
									-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="fb__goods-view__layer" id="coupon-part2">
				<div class="side-popup__wrap">
					<div class="side-popup__header">
						<a href="javascript:void(0);" class="btn-close">닫기</a>
						<div class="title-md">쿠폰 적용대상</div>
					</div>
					<div class="side-popup__content-wrap">
						<div class="side-popup__content">
							<div class="txt-desc">
								<p>일부 상품의 경우 쿠폰 할인 적용대상에서 제외될 수 있습니다.</p>
							</div>
							<div class="category-wrap">
								<div class="title-sm">카테고리</div>
								<ul class="category-list">
									<li class="category-item">
										<a href="javascript:void(0);" class="category-item__link">우먼<i class="ico ico-arrow-right"></i></a>
									</li>
									<li class="category-item">
										<a href="javascript:void(0);" class="category-item__link">맨<i class="ico ico-arrow-right"></i></a>
									</li>
									<li class="category-item">
										<a href="javascript:void(0);" class="category-item__link">키즈<i class="ico ico-arrow-right"></i></a>
									</li>
									<li class="category-item">
										<a href="javascript:void(0);" class="category-item__link">슈즈 > 키즈<i class="ico ico-arrow-right"></i></a>
									</li>
								</ul>
								<div class="btn-box">
									<button type="button" class="btn-lg btn-dark-line">확인</button>
								</div>
							</div>
							<div class="popup-product__wrap">
								<ul class="fb__goods col-2">
									<!--등록된 상품이 없을 시 S -->
									<li class="empty-content" id="devListEmpty" style="display: none">등록된 상품이 없습니다.</li>
									<!--등록된 상품이 없을 시 E -->
									<li class="fb__goods__list">
										<a href="javascript:void(0);" class="fb__goods__link">
											<div class="fb__goods__slide swiper-container">
												<div class="swiper-wrapper">
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
												</div>
												<div class="swiper-control-group">
													<div class="swiper-scrollbar"></div>
												</div>
											</div>
											<div class="fb__goods__info">
												<ul class="fb__goods__infoBox">
													<li class="fb__goods__etc">친환경 소재</li>
													<li class="fb__goods__name">우먼 리조트 하프 집업 크롭 래쉬가드</li>
													<li class="fb__goods__option">아쿠아블루</li>
													<li class="fb__goods__brand"></li>
												</ul>
											</div>
											<div class="fb__goods__important">
												<div class="fb__goods__sale">
													<p class="per"><em>10</em>%</p>
												</div>
												<span class="fb__goods__price">265,550</span>
												<span class="fb__goods__noprice">405,550</span>
												<!-- 품절일 경우 노출 S -->
												<span class="fb__goods__price__state" style="display: none">품절</span>
												<!-- 품절일 경우 노출 S -->
											</div>
											<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
										</a>
										<a href="javascript:void(0);" class="product-box__heart product-box__heart--active">hart</a>
									</li>
									<li class="fb__goods__list">
										<a href="javascript:void(0);" class="fb__goods__link">
											<div class="fb__goods__slide swiper-container">
												<div class="swiper-wrapper">
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
												</div>
												<div class="swiper-control-group">
													<div class="swiper-scrollbar"></div>
												</div>
											</div>
											<div class="fb__goods__info">
												<ul class="fb__goods__infoBox">
													<li class="fb__goods__name">우먼 리조트 하프 집업 크롭 래쉬가드</li>
													<li class="fb__goods__option">아쿠아블루</li>
													<li class="fb__goods__brand"></li>
												</ul>
											</div>
											<div class="fb__goods__important">
												<div class="fb__goods__sale">
													<p class="per"><em>10</em>%</p>
												</div>
												<span class="fb__goods__price">265,550</span>
												<span class="fb__goods__noprice">405,550</span>
												<!-- 품절일 경우 노출 S -->
												<span class="fb__goods__price__state" style="display: none">품절</span>
												<!-- 품절일 경우 노출 S -->
											</div>
											<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
										</a>
										<a href="javascript:void(0);" class="product-box__heart">hart</a>
									</li>
									<li class="fb__goods__list">
										<a href="javascript:void(0);" class="fb__goods__link">
											<div class="fb__goods__slide swiper-container">
												<div class="swiper-wrapper">
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
												</div>
												<div class="swiper-control-group">
													<div class="swiper-scrollbar"></div>
												</div>
											</div>
											<div class="fb__goods__info">
												<ul class="fb__goods__infoBox">
													<li class="fb__goods__name">우먼 리조트 하프 집업 크롭 래쉬가드</li>
													<li class="fb__goods__option">아쿠아블루</li>
													<li class="fb__goods__brand"></li>
												</ul>
											</div>
											<div class="fb__goods__important">
												<span class="fb__goods__price">265,550</span>
												<!-- 품절일 경우 노출 S -->
												<span class="fb__goods__price__state" style="display: none">품절</span>
												<!-- 품절일 경우 노출 S -->
											</div>
											<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
										</a>
										<a href="javascript:void(0);" class="product-box__heart product-box__heart--active">hart</a>
									</li>
									<li class="fb__goods__list">
										<a href="javascript:void(0);" class="fb__goods__link">
											<div class="fb__goods__slide swiper-container">
												<div class="swiper-wrapper">
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
												</div>
												<div class="swiper-control-group">
													<div class="swiper-scrollbar"></div>
												</div>
											</div>
											<div class="fb__goods__info">
												<ul class="fb__goods__infoBox">
													<li class="fb__goods__etc">친환경 소재</li>
													<li class="fb__goods__name">우먼 리조트 하프 집업 크롭 래쉬가드</li>
													<li class="fb__goods__option">아쿠아블루</li>
													<li class="fb__goods__brand"></li>
												</ul>
											</div>
											<div class="fb__goods__important">
												<span class="fb__goods__price">265,550</span>
												<!-- 품절일 경우 노출 S -->
												<span class="fb__goods__price__state" style="display: none">품절</span>
												<!-- 품절일 경우 노출 S -->
											</div>
											<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
										</a>
										<a href="javascript:void(0);" class="product-box__heart">hart</a>
									</li>
									<li class="fb__goods__list">
										<a href="javascript:void(0);" class="fb__goods__link">
											<div class="fb__goods__slide swiper-container">
												<div class="swiper-wrapper">
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
												</div>
												<div class="swiper-control-group">
													<div class="swiper-scrollbar"></div>
												</div>
											</div>
											<div class="fb__goods__info">
												<ul class="fb__goods__infoBox">
													<li class="fb__goods__etc">친환경 소재</li>
													<li class="fb__goods__name">우먼 리조트 하프 집업 크롭 래쉬가드</li>
													<li class="fb__goods__option">아쿠아블루</li>
													<li class="fb__goods__brand"></li>
												</ul>
											</div>
											<div class="fb__goods__important">
												<div class="fb__goods__sale">
													<p class="per"><em>10</em>%</p>
												</div>
												<span class="fb__goods__price">265,550</span>
												<span class="fb__goods__noprice">405,550</span>
												<!-- 품절일 경우 노출 S -->
												<span class="fb__goods__price__state" style="display: none">품절</span>
												<!-- 품절일 경우 노출 S -->
											</div>
											<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
										</a>
										<a href="javascript:void(0);" class="product-box__heart product-box__heart--active">hart</a>
									</li>
									<li class="fb__goods__list">
										<a href="javascript:void(0);" class="fb__goods__link">
											<div class="fb__goods__slide swiper-container">
												<div class="swiper-wrapper">
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
													<div class="swiper-slide">
														<img src="/assets/templet/enterprise/assets/img/product/sample.png" alt="상품이미지" />
													</div>
												</div>
												<div class="swiper-control-group">
													<div class="swiper-scrollbar"></div>
												</div>
											</div>
											<div class="fb__goods__info">
												<ul class="fb__goods__infoBox">
													<li class="fb__goods__name">우먼 리조트 하프 집업 크롭 래쉬가드</li>
													<li class="fb__goods__option">아쿠아블루</li>
													<li class="fb__goods__brand"></li>
												</ul>
											</div>
											<div class="fb__goods__important">
												<div class="fb__goods__sale">
													<p class="per"><em>10</em>%</p>
												</div>
												<span class="fb__goods__price">265,550</span>
												<span class="fb__goods__noprice">405,550</span>
												<!-- 품절일 경우 노출 S -->
												<span class="fb__goods__price__state" style="display: none">품절</span>
												<!-- 품절일 경우 노출 S -->
											</div>
											<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
										</a>
										<a href="javascript:void(0);" class="product-box__heart">hart</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 쿠폰 받기 E -->

			<!-- 구매가능 매장 안내 S -->
			<div class="fb__goods-view__layer" id="store">
				<div class="side-popup__wrap">
					<div class="side-popup__header">
						<a href="javascript:void(0);" class="btn-close">닫기</a>
						<div class="title-md">구매가능 매장안내</div>
					</div>
					<div class="side-popup__content-wrap">
						<div class="side-popup__content">
							<div class="store-wrap">
								<div class="txt-error">매장에 따라 실시간으로 재고 상황이 바뀔 수 있으므로, 방문 전 해당 매장에 문의하시기 바랍니다.</div>
								<div class="popup-product">
									<div class="popup-product__left">
										<figure class="popup-product__thumb">
<?php if($TPL_image_src_1){$TPL_I1=-1;foreach($TPL_VAR["image_src"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
												<img src="<?php echo $TPL_V1["basic_img"]?>" alt="" />
<?php }?>
<?php }}?>
										</figure>
									</div>
									<div class="popup-product__info goods-info">
										<div class="goods-info__title"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></div>
										<div class="goods-info__option">
											<span><?php echo $TPL_VAR["add_info"]?></span>
										</div>
										<dl class="goods-info__price-group">
											<dd>
												<div class="goods-info__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["dcprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
											</dd>
										</dl>
										<div class="goods-info__footer">
<?php if(count($TPL_VAR["style"])> 1){?>
											<div class="fb__form-item">
												<select class="fb__form-select" name="style" id="devStyleSelect">
<?php if($TPL_style_1){foreach($TPL_VAR["style"] as $TPL_V1){?>
													<option value="<?php echo $TPL_V1["style"]?><?php echo $TPL_V1["color"]?>"><?php echo $TPL_V1["gname"]?></option>
<?php }}?>
												</select>
											</div>
<?php }?>
<?php if(!empty($TPL_VAR["option"])){?>
											<div class="fb__form-item">
												<select class="fb__form-select" name="option" id="devOptionSelect">
<?php if($TPL_option_1){foreach($TPL_VAR["option"] as $TPL_V1){?>
													<option value="<?php echo $TPL_V1["option_gid"]?>"><?php echo $TPL_V1["option_div"]?></option>
<?php }}?>
												</select>
											</div>
<?php }?>
										</div>
									</div>
								</div>
								<div class="store-select">
									<div class="fb__form-item">
										<select class="fb__form-select" name="city" id="devCitySelect">
<?php if(is_array($TPL_R1=$TPL_VAR["cityList"]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
											<option value="<?php echo $TPL_V1["city_code"]?>"><?php echo $TPL_V1["city_name"]?></option>
<?php }}?>
										</select>
									</div>
								</div>
								<div class="btn-box">
									<button type="button" class="btn-lg btn-dark-line" onclick="storeSch()">매장 검색</button>
								</div>
								<div class="store-result">
									<!-- 결과 없을 경우 S -->
									<!-- 숨김처리 -->
									<div class="store-result__no-data" style="display: none">
										<p class="empty-content">검색 된 매장이 없습니다.</p>
									</div>
									<!-- 결과 없을 경우 E -->
									<div class="store-result__area">
										<div class="store-result__title"><span id="storeListCount">0</span>개의 배럴 매장이 검색되었습니다.</div>
										<ul class="store-result__list" id="storeList"></ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 구매가능 매장 안내 E -->

			<!-- 신체 사이즈 가이드 S -->
			<div class="fb__goods-view__layer" id="size-guide">
				<div class="side-popup__wrap">
					<div class="side-popup__header">
						<a href="javascript:void(0);" class="btn-close">닫기</a>
						<div class="title-md">신체 사이즈 가이드</div>
					</div>
					<div class="side-popup__content-wrap">
						<div class="side-popup__content">
							<div class="sizeGuide-wrap">
								<div class="fb-slider__tab">
									<div class="fb-slider__tab-nav swiper-container">
										<ul class="swiper-wrapper">
											<li class="swiper-slide active">
												<a href="javascript:void(0);">워터스포츠</a>
											</li>
											<li class="swiper-slide">
												<a href="javascript:void(0);">실내수영</a>
											</li>
											<li class="swiper-slide">
												<a href="javascript:void(0);">라이프스타일</a>
											</li>
											<li class="swiper-slide">
												<a href="javascript:void(0);">배럴핏</a>
											</li>
										</ul>
									</div>
									<div class="fb-slider__tab-contents">
										<div class="fb-slider__contents active">
											<div class="fb-tab__wrap fb-tab__col">
												<div class="fb-tab__nav">
													<ul>
														<li class="active">
															<a href="javascript:void(0);">우먼</a>
														</li>
														<li>
															<a href="javascript:void(0);">맨</a>
														</li>
														<li>
															<a href="javascript:void(0);">아동</a>
														</li>
														<li>
															<a href="javascript:void(0);">유아</a>
														</li>
													</ul>
												</div>
												<div class="fb-tab__contents-wrap">
													<div class="fb-tab__contents active">
														<div class="img-box">
															<img src="/assets/templet/enterprise/assets/img/size/size_rashguard_women_.jpg" alt="" />
														</div>
													</div>
													<div class="fb-tab__contents">
														<div class="img-box">
															<img src="/assets/templet/enterprise/assets/img/size/size_rashguard_men.jpg" alt="" />
														</div>
													</div>
													<div class="fb-tab__contents">
														<div class="img-box">
															<img src="/assets/templet/enterprise/assets/img/size/size_rashguard_kids.jpg" alt="" />
														</div>
													</div>
													<div class="fb-tab__contents">
														<div class="img-box">
															<img src="/assets/templet/enterprise/assets/img/size/size_rashguard_toddler.jpg" alt="" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="fb-slider__contents">
											<div class="fb-tab__wrap fb-tab__col">
												<div class="fb-tab__nav">
													<ul>
														<li class="active">
															<a href="javascript:void(0);">우먼</a>
														</li>
														<li>
															<a href="javascript:void(0);">맨</a>
														</li>
														<li>
															<a href="javascript:void(0);">아동</a>
														</li>
														<li>
															<a href="javascript:void(0);">유아</a>
														</li>
													</ul>
												</div>
												<div class="fb-tab__contents-wrap">
													<div class="fb-tab__contents active">
														<div class="img-box">
															<img src="/assets/templet/enterprise/assets/img/size/size_rashguard_women_.jpg" alt="" />
														</div>
													</div>
													<div class="fb-tab__contents">
														<div class="img-box">
															<img src="/assets/templet/enterprise/assets/img/size/size_rashguard_men.jpg" alt="" />
														</div>
													</div>
													<div class="fb-tab__contents">
														<div class="img-box">
															<img src="/assets/templet/enterprise/assets/img/size/size_rashguard_kids.jpg" alt="" />
														</div>
													</div>
													<div class="fb-tab__contents">
														<div class="img-box">
															<img src="/assets/templet/enterprise/assets/img/size/size_rashguard_toddler.jpg" alt="" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="fb-slider__contents">
											<div class="fb-tab__wrap fb-tab__col">
												<div class="fb-tab__nav">
													<ul>
														<li class="active">
															<a href="javascript:void(0);">우먼</a>
														</li>
														<li>
															<a href="javascript:void(0);">맨</a>
														</li>
													</ul>
												</div>
												<div class="fb-tab__contents-wrap">
													<div class="fb-tab__contents active">
														<div class="img-box">
															<img src="/assets/templet/enterprise/assets/img/size/size_rashguard_women_.jpg" alt="" />
														</div>
													</div>
													<div class="fb-tab__contents">
														<div class="img-box">
															<img src="/assets/templet/enterprise/assets/img/size/size_rashguard_men.jpg" alt="" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="fb-slider__contents">
											<div class="fb-tab__wrap fb-tab__col">
												<div class="fb-tab__nav">
													<ul>
														<li class="active">
															<a href="javascript:void(0);">우먼</a>
														</li>
													</ul>
												</div>
												<div class="fb-tab__contents-wrap">
													<div class="fb-tab__contents active">
														<div class="img-box">
															<img src="/assets/templet/enterprise/assets/img/size/size_rashguard_women_.jpg" alt="" />
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 신체 사이즈 가이드 E -->

			<!-- 상품문의 S -->
			<div class="fb__goods-view__layer" id="product-QnA">
				<div class="side-popup__wrap">
					<div class="side-popup__header">
						<a href="javascript:void(0);" class="btn-close">닫기</a>
						<div class="title-md">상품문의하기</div>
					</div>
					<div class="side-popup__content-wrap">
						<div class="side-popup__content">
							<div class="QnA-wrap">
								<div class="popup-product">
									<div class="popup-product__left">
										<figure class="popup-product__thumb">
<?php if($TPL_image_src_1){$TPL_I1=-1;foreach($TPL_VAR["image_src"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
													<img src="<?php echo $TPL_V1["basic_img"]?>" alt="" />
<?php }?>
<?php }}?>
										</figure>
									</div>
									<div class="popup-product__info goods-info">
										<div class="goods-info__title"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></div>
										<div class="goods-info__option">
											<span><?php echo $TPL_VAR["add_info"]?></span>
										</div>
										<dl class="goods-info__price-group">
<?php if($TPL_VAR["discount_rate"]){?>
											<dt class="goods-info__price-percent"><?php echo $TPL_VAR["discount_rate"]?>%</dt>
<?php }?>
											<dd>
<?php if($TPL_VAR["discount_rate"]){?>
												<div class="goods-info__price-regular"><del><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["listprice"])?></del>원</div>
<?php }?>
												<div class="goods-info__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["dcprice"])?>원</div>
											</dd>
										</dl>
									</div>
								</div>
								<div class="QnA-form__wrap">
									<form name="goodsQnaFrom" id="devGoodsQnaFrom">
										<input type="hidden" name="pid" id="devPid" value="<?php echo $TPL_VAR["pid"]?>">
										<input type="hidden" name="bbs_ix" id="devBbsIx" value="<?php echo $TPL_VAR["bbs_ix"]?>">
										<div class="fb__form-item">
											<label for="" class="hide">문의유형</label>
											<select class="fb__form-select" name="div" id="devQnaDiv" title="문의유형">
												<option value="" selected>문의유형 선택</option>
<?php if($TPL_qnaDivs_1){foreach($TPL_VAR["qnaDivs"] as $TPL_V1){?>
												<option value="<?php echo $TPL_V1["ix"]?>" <?php if($TPL_VAR["bbs_div"]==$TPL_V1["ix"]){?> selected <?php }?>><?php echo trans($TPL_V1["div_name"])?></option>
<?php }}?>
											</select>
										</div>
										<div class="fb__form-item">
											<label for="" class="hide">문의유형</label>
											<input type="text" class="fb__form-input" placeholder="제목을 입력해 주세요." name="subject" value="<?php echo $TPL_VAR["bbs_subject"]?>" id="devQnaSubject" title="문의 제목" placeholder="문의 제목을 입력해 주세요." />
										</div>
										<div class="fb__form-item fb__form-email">
											<label for="devEmailId" class="inputs__title hide">이메일 주소</label>
											<div class="fb__form-group">
												<input type="text" name="emailId" id="devEmailId" class="br__form-input" placeholder="메일 아이디" value="<?php echo $TPL_VAR["emailId"]?>" title="이메일 주소" />
												<input type="text" name="emailHost" id="devEmailHost" class="br__form-input" placeholder="메일 도메인 주소" value="<?php echo $TPL_VAR["emailHost"]?>" title="이메일 주소" />
												<input type="hidden" id="devLoginEmailId" value="<?php echo $TPL_VAR["emailId"]?>" />
												<input type="hidden" id="devLoginEmailHost" value="<?php echo $TPL_VAR["emailHost"]?>"  />
											</div>
											<div class="fb__form-group">
												<select id="devEmailHostSelect" class="input__select">
													<option value="">직접입력</option>
													<option value="naver.com">naver.com</option>
													<option value="gmail.com">gmail.com</option>
													<option value="hotmail.com">hotmail.com</option>
													<option value="hanmail.net">hanmail.net</option>
													<option value="daum.net">daum.net</option>
													<option value="nate.com">nate.com</option>
												</select>
											</div>
											<dl class="QnA-form__radio">
												<dt class="title-sm">답변을 메일로 받으시겠습니까?</dt>
												<dd class="fb__form-item">
													<label class="inputs__label">
														<input type="radio" title="메일 답변 유무" name="bbs_email_return" id="devEmailReturn_1" value="1" <?php if($TPL_VAR["bbs_email_return"]== 1){?> checked <?php }?> />
														<span>예</span>
													</label>
													<label class="inputs__label">
														<input type="radio" title="메일 답변 유무" name="bbs_email_return" id="devEmailReturn_0" value="0" <?php if($TPL_VAR["bbs_email_return"]== 0||$TPL_VAR["bbs_email_return"]==''){?> checked <?php }?>/>
														<span>아니오</span>
													</label>
												</dd>
											</dl>
										</div>
										<div class="fb__form-item fb__form-write">
											<div class="title-sm">내용입력</div>
											<textarea class="fb__form-textarea" name="contents" title="문의 내용"><?php echo $TPL_VAR["bbs_contents"]?></textarea>
<?php if($TPL_VAR["bbs_contents"]==''){?>
											<div class="fb__form-textarea--placeholder" id="contentsPlace">
												<div class="title-md">[문의 전 유의사항]</div>
												<div class="txt-list">
													<p>
														상품문의하기에서는 상품 단순 문의만 작성 부탁드립니다.<br />
														급한 배송, 반품 문의는 [마이페이지] 1:1 맞춤 상담 게시판을 이용해 주시면 좀 더 빠른 답변을 받으실 수 있습니다.
													</p>
													<p>주문처리 상태가 ‘배송 대기 / 배송 중’ 상태인 경우 택배 발송된 상태이므로 반품 및 취소를 원하시면 왕복 택배비를 납부 후 반품 및 취소를 받으실 수 있습니다.</p>
													<p>반품접수를 신청하시면 자동으로 주문하셨던 주소로 수거가 진행됩니다. 고객님께서 택배사의 별도 신청을 하지 않으셔도 수거가 진행되니 이점 참고 부탁드립니다.</p>
												</div>
											</div>
<?php }?>
										</div>
										<div class="QnA-form__notice">
											<dl class="QnA-form__radio">
												<dt class="title-sm">비밀글로 설정하시겠습니까?</dt>
												<dd class="fb__form-item">
													<label class="inputs__label">
														<input type="radio" title="비밀번호 설정 유무" name="isHidden" id="devIsHidden_1" value="1" checked />
														<span>예</span>
													</label>
													<label class="inputs__label">
														<input type="radio" title="비밀번호 설정 유무" name="isHidden" id="devIsHidden_0" value="0" />
														<span>아니오</span>
													</label>
												</dd>
											</dl>
											<div class="txt-list">
												<p>
													상품문의하기에서는 상품 단순 문의만 작성 부탁드립니다.<br />
													급한 배송, 반품 문의는 [마이페이지] 1:1 맞춤 상담 게시판을 이용해 주시면 좀 더 빠른 답변을 받으실 수 있습니다.
												</p>

												<p>주문처리 상태가 ‘배송 대기 / 배송 중’ 상태인 경우 택배 발송된 상태이므로 반품 및 취소를 원하시면 왕복 택배비를 납부 후 반품 및 취소를 받으실 수 있습니다.</p>

												<p>반품접수를 신청하시면 자동으로 주문하셨던 주소로 수거가 진행됩니다. 고객님께서 택배사의 별도 신청을 하지 않으셔도 수거가 진행되니 이점 참고 부탁드립니다.</p>
											</div>
										</div>
									</form>
								</div>
								<div class="QnA-wrap__footer">
									<button type="button" class="btn-lg btn-dark-line" id="devSubmitBtnQna">문의하기</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 상품문의 E -->

			<!-- 반품 및 환불 안내 S -->
			<div class="fb__goods-view__layer" id="return-refund">
				<div class="side-popup__wrap">
					<div class="side-popup__header">
						<a href="javascript:void(0);" class="btn-close">닫기</a>
						<div class="title-md">반품 & 환불 안내</div>
					</div>
					<div class="side-popup__content-wrap">
						<div class="side-popup__content">
							<div class="cosmetics__wrap br__cliamGuide">
								<dl class="cosmetics__list">
									<dt class="cosmetics__title-wrap">
										<a href="javascript:void(0);" class="cosmetics__link">
											<h3 class="cosmetics__category">반품 / 환불</h3>
											<i class="ico ico-plus"></i>
										</a>
									</dt>
									<dd class="cosmetics__info-wrap">
										<ul class="cosmetics__info">
											<li class="cosmetics__infoList">
												배럴 공식 홈페이지를 통해 구매하신 상품은 사이즈 및 색상 또는 다른 상품으로 교환되지 않습니다.<br />
												구매하신 상품을 반품하신 후 구매를 원하시는 다른 상품이나 사이즈, 색상으로 재구매해 주시기 바랍니다.<br />
												(유의사항 : 이벤트 기간에 주문하신 상품은 이벤트 기간 종료 후 재구매 시 할인 적용 및 사은품 지급이 되지 않으니, 반품을 신청하신 고객님께서는 이벤트 기간 내 재구매를 하셔야 혜택을 받으실 수 있습니다.)
											</li>
											<li class="cosmetics__infoList">단순 변심에 의한 반품 시 반품하실 상품을 제외한 실결제 금액이 3만원 이상일 경우 2,500원, 3만원 미만일 경우 5,000원이 반품하신 상품의 결제한 금액에서 차감 후 환불이 진행됩니다.</li>
											<li class="cosmetics__infoList">반품은 상품 수령 후 7일 이내에 접수 가능합니다.</li>
											<li class="cosmetics__infoList">도서산간지역에서 반품을 신청한 경우 지역별로 도선료가 상이하여 별도의 추가금액을 지불하셔야 하는 경우가 있습니다.</li>
											<li class="cosmetics__infoList">초기불량 제품 및 오배송 상품은 무료로 반품을 진행해 드리며, 주문하신 상품이 품절일 경우 환불 요청이나 다른 상품으로 재구매하여 주시기 바랍니다.</li>
											<li class="cosmetics__infoList">단순 변심에 의한 반품 시 사용하신 쿠폰은 다시 반환되지 않습니다.</li>
											<li class="cosmetics__infoList">부분 반품 시 사용하신 적립금과 쿠폰은 반환되지 않습니다.</li>
											<li class="cosmetics__infoList txt-red">상품 이미지는 모니터의 종류 및 해상도, 촬영상태 등의 사유로 실제와 차이가 있을 수 있습니다.</li>
											<li class="cosmetics__infoList">오배송된 상품이라도 사용했을 경우 반품이 불가합니다.</li>
											<li class="cosmetics__infoList">단순 변심에 의한 반품은 제품 수령 후 7일 이내에 미개봉, 미사용 상품의 한하여 가능합니다.</li>
											<li class="cosmetics__infoList">단순 변심에 의한 반품 시 사은품이 지급된 경우 반드시 함께 반송해 주셔야 하며 사용 및 패키지 손상이 없어야 합니다.</li>
											<li class="cosmetics__infoList">사은품을 동봉하여 보내지 아니한 경우, 선불 택배를 이용하여 당사 물류센터로 보내 주신 후 제품에 대한 환불 처리가 가능합니다.</li>
											<li class="cosmetics__infoList">단순 변심에 의한 반품 시 지급된 사은품을 사용하여 반송이 불가능한 경우, 사은품의 정상가 대비 70% 금액을 반품 요청하신 제품의 환불 처리금액에서 차감 후 환불이 진행됩니다.</li>
											<li class="cosmetics__infoList">배송 기사님 방문 시 부재중이거나, 고객님의 정보오류로 인해 반송된 제품은 재배송 시 착불로 발송됩니다.</li>
											<li class="cosmetics__infoList">배송 시 요청 사항란에 기재하는 요구사항의 경우 반영되지 않으니 이 점 양해 부탁드립니다.</li>
										</ul>
										<div class="title-sm">[코스메틱스] 별도 추가 사항</div>
										<ul class="cosmetics__info">
											<li class="cosmetics__infoList">
												일부 화장품은 특정 고객님의 피부에 맞지 않을 수 있으며, 이는 상품 자체 품질의 문제로 볼 수 없습니다.<br />
												일부 상품 중 트러블(알러지, 붉은 반점, 가려움, 따가움) 발생 시 사진, 소견서, 진료 확인서 중 1가지를 첨부해야 반품이 가능합니다.<br />
												(단, 기타 제반 비용은 고객님의 부담입니다.)
											</li>
											<li class="cosmetics__infoList">상품 오배송 및 표시/광고의 내용과 다르거나 계약 내용과 다르게 이행된 경우에는 상품을 공급받은 날로부터 3개월 이내, 그 사실을 알게된 날 또는 알 수 있었던 날부터 30일 이내 반품이 가능하며 배송비용은 배럴에서 제공됩니다.</li>
										</ul>
									</dd>
								</dl>
								<dl class="cosmetics__list">
									<dt class="cosmetics__title-wrap">
										<a href="javascript:void(0);" class="cosmetics__link">
											<h3 class="cosmetics__category">반품이 불가능한 경우</h3>
											<i class="ico ico-plus"></i>
										</a>
									</dt>
									<dd class="cosmetics__info-wrap">
										<ul class="cosmetics__info">
											<li class="cosmetics__infoList">온라인 주문의 경우 오프라인 매장에서 반품 / 환불 처리는 불가하므로 요청 시 각 구매처로 문의 바랍니다.</li>
											<li class="cosmetics__infoList">제품의 택이 훼손되거나 제거 된 경우에는 반품이 불가합니다.</li>
											<li class="cosmetics__infoList">수령한 그대로가 아닌 포장을 개봉하여 시착 또는 사용하여 상품의 가치가 훼손된 경우에는 반품이 불가합니다.</li>
											<li class="cosmetics__infoList">고객님의 귀책사유로 인해 상품의 가치가 훼손된 경우 반품이 불가합니다.</li>
											<li class="cosmetics__infoList">고객님의 귀책사유로 인해 수거가 지연될 경우 반품/교환이 제한될 수 있습니다.</li>
											<li class="cosmetics__infoList">별도의 배송 박스가 아닌 상품의 직접적인 포장 박스나 용기로 배송하여 반품을 요청한 경우.</li>
											<li class="cosmetics__infoList">일부 상품의 반품 불가 고지상품.</li>
										</ul>
										<div class="title-sm">스포츠웨어</div>
										<ul class="cosmetics__info">
											<li class="cosmetics__infoList">신축성 있는 제품 (탱크탑, 브라탑, 브라패드, 레깅스, 비키니, 비키니팬츠, 이너웨어) 은 시착 시 상품의 가치가 훼손되어 반품이 불가합니다.</li>
											<li class="cosmetics__infoList">부착된 택을 제거하였거나 제거한 흔적이 있는 경우. (예 : 택제거, 패키지백 손상, 패키지백 분실)</li>
											<li class="cosmetics__infoList">고객의 책임이 있는 사유로 인하여 상품이 멸실 또는 훼손된 경우. (예 : 흙탕물 또는 진흙에 의한 오염, 워터파크 내의 슬라이드 이용으로 인한 손상, 뜯김 등)</li>
											<li class="cosmetics__infoList">착용한 흔적이 발견되었을 경우. (예 : 화장품의 흔적 여부(파우더, 아이라이너, 펄, 기타오염물질)</li>
											<li class="cosmetics__infoList">이미 세탁 및 착용한 상품의 경우. (제품 하자 시에도 세탁 및 착용한 상품은 반품이 불가능합니다.)</li>
										</ul>
										<div class="title-sm">코스메틱스</div>
										<ul class="cosmetics__info">
											<li class="cosmetics__infoList">
												일부 화장품은 특정 고객님의 피부에 맞지 않을 수 있으며, 이는 상품 자체 품질의 문제로 볼 수 없습니다.<br />
												일부 상품 중 트러블(알러지, 붉은 반점, 가려움, 따가움) 발생 시 사진, 소견서, 진료 확인서 중 1가지를 첨부하셔야 반품이 가능합니다.<br />
												(단, 기타 제반 비용은 고객님의 부담입니다.)
											</li>
											<li class="cosmetics__infoList">반품 시 상품 및 구성품을 분실하였거나 취급 부주의로 인한 파손/고장/오염된 경우와 용기 및 포장 케이스의 훼손 또는 상품 가치 상실 등의 경우 반품이 불가합니다.</li>
										</ul>
									</dd>
								</dl>
								<dl class="cosmetics__list">
									<dt class="cosmetics__title-wrap">
										<a href="javascript:void(0);" class="cosmetics__link">
											<h3 class="cosmetics__category">반품 시 박스 포장 안내</h3>
											<i class="ico ico-plus"></i>
										</a>
									</dt>
									<dd class="cosmetics__info-wrap">
										<ul class="cosmetics__info">
											<li class="cosmetics__infoList">브랜드 박스의 훼손이 없도록 택배 박스 및 타 박스로 포장하여 발송해주시기 바랍니다.</li>
										</ul>
										<div class="cosmetics__img">
											<img src="/assets/templet/enterprise/assets/img/img-cliamGuide.png" alt="" />
										</div>
									</dd>
								</dl>
								<dl class="cosmetics__list">
									<dt class="cosmetics__title-wrap">
										<a href="javascript:void(0);" class="cosmetics__link">
											<h3 class="cosmetics__category">반품 신청 후 철회</h3>
											<i class="ico ico-plus"></i>
										</a>
									</dt>
									<dd class="cosmetics__info-wrap">
										<ul class="cosmetics__info">
											<li class="cosmetics__infoList">
												고객님께서 신청하신 반품 접수 철회를 요청하실 경우, 고객센터로 연락 주시기 바랍니다.<br />
												단, 이미 수거지시 및 수거가 진행 중인 경우에는 반품 접수 철회가 불가할 수 있습니다.
											</li>
										</ul>
									</dd>
								</dl>
								<dl class="cosmetics__list">
									<dt class="cosmetics__title-wrap">
										<a href="javascript:void(0);" class="cosmetics__link">
											<h3 class="cosmetics__category">반품 절차</h3>
											<i class="ico ico-plus"></i>
										</a>
									</dt>
									<dd class="cosmetics__info-wrap">
										<ul class="cosmetics__info">
											<li class="cosmetics__infoList">고객변심으로 인한 반품 요청은 상품을 수령하신 날로부터 7일 이내로 배럴 공식 홈페이지 [마이페이지] 메뉴 내의 [주문내역 조회] 에서 신청하실 수 있습니다.</li>

											<li class="cosmetics__infoList">[마이페이지] 메뉴 접속은 모바일의 경우 로그인 후 좌측 상단의 메뉴 선택 후 [마이 페이지] 터치, PC의 경우 로그인 후 오른쪽 상단의 아이콘 버튼을 통해 접속 가능합니다.</li>

											<li class="cosmetics__infoList">가상계좌로 구매하신 고객님께서는 반드시 [마이페이지] 메뉴 내의 [환불계좌 관리]에서 환불 받으실 계좌를 등록해 주시기 바랍니다.</li>

											<li class="cosmetics__infoList">반품접수를 신청하시면 자동으로 주문하셨던 주소로 수거가 진행 됩니다. 고객님께서 택배사의 별도 신청을 하지 않으셔도 수거가 진행되니 이점 참고 부탁드립니다.</li>

											<li class="cosmetics__infoList">반품 신청 철회는 수거지시가 전달되기 전까지 가능하며, 고객센터로 연락 주시기 바랍니다.</li>

											<li class="cosmetics__infoList">배송 기사님 방문 시 부재중이거나, 고객님의 정보 오류로 인해 수거가 지연될 경우 반품 및 환불이 지연됩니다.</li>

											<li class="cosmetics__infoList">반품접수 요청 없이 고객님께서 임의로 반송을 하실 경우, 반품 요청 내역을 확인할 수 없으므로 반품접수가 되지 않거나 환불 지연 및 불가가 될 수 있습니다.</li>

											<li class="cosmetics__infoList">
												타 택배사를 이용하여 반품을 요청하실 경우 배송비는 선불지급 후 보내주셔야 하며, 그렇지 않은 경우 착불 발생비용을 당사 계좌로 반드시 입금해주셔야 합니다.<br />
												(배송비 입금계좌 : 기업은행 551-037000-01-010 (주)배럴)
											</li>

											<li class="cosmetics__infoList">반품 상품 수거 완료 후 상품 이상유무 판단 후 환불 처리되며, 상품의 초기 불량을 제외한 단순 변심에 의한 반품 요청 시 3만원 이상 구매 시 무료 배송으로 반품하실 상품을 제외한 실결제 금액이 3만원 이상일 경우 2,500원, 3만원 미만일 경우 5,000원이 반품하신 상품의 결제한 금액에서 차감 후 환불이 진행됩니다. 도서산간지역의 경우 별도의 추가금액이 발생됩니다.</li>

											<li class="cosmetics__infoList">물류센터 주소 안내 : 경기도 이천시 호법면 중부대로798번길 103-40 [배럴 물류센터]</li>
										</ul>
									</dd>
								</dl>
								<dl class="cosmetics__list">
									<dt class="cosmetics__title-wrap">
										<a href="javascript:void(0);" class="cosmetics__link">
											<h3 class="cosmetics__category">반품 후 환불 안내</h3>
											<i class="ico ico-plus"></i>
										</a>
									</dt>
									<dd class="cosmetics__info-wrap">
										<ul class="cosmetics__info">
											<li class="cosmetics__infoList">
												반품 후 환불은 물류센터에 도착한 날로부터 3영업일 이내 결제하신 PG사를 통해 진행됩니다. <br />
												(단, 검수를 통해 제품에 하자가 있을 경우 환불 시 그에 상응하는 금액을 공제하고 환불하거나 추후 별도로 청구할 수 있습니다.)
											</li>

											<li class="cosmetics__infoList">단순 변심에 의한 반품 시 사용하신 쿠폰은 반환되지 않습니다.</li>

											<li class="cosmetics__infoList">부분 반품 시 사용하신 적립금과 쿠폰은 반환되지 않습니다.</li>

											<li class="cosmetics__infoList">
												배송비가 부과되는 경우 환불금액에서 차감되어 진행됩니다.<br />
												정상 환불이 확인되지 않는 고객님께서는 고객센터로 연락해 주시기 바랍니다.
											</li>
										</ul>
									</dd>
								</dl>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 반품 및 환불 안내 E -->

			<!-- 세탁 및 주의사항 S -->
			<div class="fb__goods-view__layer" id="wash-precautions">
				<div class="side-popup__wrap">
					<div class="side-popup__header">
						<a href="javascript:void(0);" class="btn-close">닫기</a>
						<div class="title-md">세탁 & 주의사항</div>
					</div>
					<div class="side-popup__content-wrap" id="laundryInfo">
						<div class="side-popup__content">
							<div class="wash-wrap">
								<div class="fb__form-group">
									<div class="fb__form-item">
										<label for="" class="hide">카테고리1</label>
										<select class="fb__form-select" onchange="laundryChange(this.value)">
<?php if($TPL_laundryOneDepth_1){foreach($TPL_VAR["laundryOneDepth"] as $TPL_V1){?>
<?php if($TPL_VAR["langType"]=='english'){?>
												<option value="<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryCid"]==$TPL_V1["cid"]){?>selected<?php }?>><?php echo $TPL_V1["title_en"]?></option>
<?php }else{?>
												<option value="<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryCid"]==$TPL_V1["cid"]){?>selected<?php }?>><?php echo $TPL_V1["title"]?></option>
<?php }?>
<?php }}?>
										</select>
									</div>
									<div class="fb__form-item">
										<label for="" class="hide">카테고리2</label>
										<select class="fb__form-select" onchange="laundryTwoChange(this.value)">
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
<?php if($TPL_VAR["langType"]=='english'){?>
												<option value="<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?>selected<?php }?>><?php echo $TPL_V1["title_en"]?></option>
<?php }else{?>
												<option value="<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?>selected<?php }?>><?php echo $TPL_V1["title"]?></option>
<?php }?>
<?php }}?>
										</select>
										<input type="hidden" id="laundryTwoDepthOld" value="<?php echo $TPL_VAR["laundryTwoFirst"]?>">
									</div>
								</div>
								<div class="fb-tab__wrap fb-tab__col">
									<div class="fb-tab__nav">
										<ul>
											<li class="active">
												<a href="javascript:void(0);">세탁 방법</a>
											</li>
											<li>
												<a href="javascript:void(0);">보관 및 주의사항</a>
											</li>
										</ul>
									</div>
									<div class="fb-tab__contents-wrap">
										<div class="fb-tab__contents active">
											<div class="contents__box">
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
												<div class="contents__list" id="oneLaundry-<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_I2== 0){?>
<?php if(is_array($TPL_R3=$TPL_V2["four"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
													<dl class="contents__item">
														<dt class="contents__item-img">
															<img src="/assets/templet/enterprise/assets/img/img_product_precautions<?php echo $TPL_V3["imgCnt"]?>.png" alt="<?php echo $TPL_V3["title"]?>" />
														</dt>
														<dd class="contents__item-cont">
															<div class="contents__subtitle"><?php echo $TPL_V3["title"]?></div>
															<div class="contents__summary">
																<p><?php echo $TPL_V3["contents"]?></p>
															</div>
														</dd>
													</dl>
<?php }}?>
<?php }?>
<?php }}?>
												</div>
<?php }}?>
											</div>
										</div>
										<div class="fb-tab__contents">
											<div class="contents__box">
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
												<div class="contents__list" id="twoLaundry-<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_I2== 1){?>
<?php if(is_array($TPL_R3=$TPL_V2["four"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
													<dl class="contents__item">
														<dt class="contents__item-img">
															<img src="/assets/templet/enterprise/assets/img/img_product_precautions<?php echo $TPL_V3["imgCnt"]?>.png" alt="<?php echo $TPL_V3["title"]?>" />
														</dt>
														<dd class="contents__item-cont">
															<div class="contents__subtitle"><?php echo $TPL_V3["title"]?></div>
															<div class="contents__summary">
																<p><?php echo $TPL_V3["contents"]?></p>
															</div>
														</dd>
													</dl>
<?php }}?>
<?php }?>
<?php }}?>
												</div>
<?php }}?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 세탁 및 주의사항 E -->

			<!-- 배송 안내 S -->
			<div class="fb__goods-view__layer" id="delivery-info">
				<div class="side-popup__wrap">
					<div class="side-popup__header">
						<a href="javascript:void(0);" class="btn-close">닫기</a>
						<div class="title-md">배송안내</div>
					</div>
					<div class="side-popup__content-wrap">
						<div class="side-popup__content">
							<div class="guide-wrap">
								<ul class="guide-list">
									<li class="guide-list__item">
										<div class="title-md">배송업체</div>
										<p>CJ 대한통운</p>
									</li>
									<li class="guide-list__item">
										<div class="title-md">배송비용</div>
										<p>
											총 실결제금액 30,000원 미만 시 배송비 2,500원<br />
											(산간벽지, 도서지방 3,000원 추가)
										</p>
									</li>
									<li class="guide-list__item">
										<div class="title-md">배송기간</div>
										<p>
											영업일 기준 1~3일 소요.<br />
											(여름 시즌의 경우 주문량이 많아 평균 2~5일 소요.)
										</p>
									</li>
									<li class="guide-list__item">
										<div class="title-md">배송 유의사항</div>
										<div class="guide-list__desc">
											<p>
												당일 오후 2시 이전 결제 완료된 주문건의 경우,<br />
												일괄적으로 당일 출고됩니다.
											</p>

											<p>주문번호가 다를 경우 묶음 배송은 불가합니다.</p>

											<p>
												천재지변, 일시품절 등의 경우에 따라 일반적인 배송기간보다<br />
												지연될 수 있습니다.
											</p>

											<p>배송사의 물량증가로 인한 지연이 있을 수 있습니다.</p>

											<p>품절상품은 발송 전 순차적으로 연락드립니다.</p>

											<p>
												주문서 입금 확인 시 상품 변경 및 주소 변경이 불가합니다.<br />
												변경을 희망하시는 경우 전체 취소 후 재구매를 부탁드립니다.
											</p>

											<p>
												송장 발행 / 배송 준비 중 상태는 상품 포장이 완료된 상태로<br />
												취소 또는 변경이 불가합니다.
											</p>

											<p>
												배송 중 상태에서는 반송 및 수취거부는 불가합니다.<br />
												상품을 수령하신 후 반품 신청을 부탁드립니다.<br />
												(고객변심으로 인한 반품 시 반품비가 발생됩니다.)
											</p>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 배송 안내 E -->

			<!-- 상품정보 제공고시 S -->
			<div class="fb__goods-view__layer" id="product-info">
				<div class="side-popup__wrap">
					<div class="side-popup__header">
						<a href="javascript:void(0);" class="btn-close">닫기</a>
						<div class="title-md">상품정보 제공고시</div>
					</div>
					<div class="side-popup__content-wrap">
						<div class="side-popup__content">
							<div class="guide-wrap">
								<ul class="guide-list custom">
<?php if($TPL_mandatoryInfos_1){foreach($TPL_VAR["mandatoryInfos"] as $TPL_V1){?>
<?php if($TPL_V1["pmi_title"]!=''){?>
									<li class="guide-list__item">
										<div class="title-md"><?php echo $TPL_V1["pmi_title"]?></div>
										<p><?php echo $TPL_V1["pmi_desc"]?></p>
									</li>
<?php }?>
<?php }}?>
									<li class="guide-list__item">
										<div class="title-md">상품코드</div>
										<p><?php echo $TPL_VAR["pcode"]?></p>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 상품정보 제공고시 E -->
			<!-- 우측 메뉴 전용 레이어 팝업 영역 S -->
		</section>
	</div>
</section>
<!-- 컨텐츠 E -->

<!-- 팝업 S -->
<div class="popup-mask-goods-view"></div>
<!-- 혜택 안내 팝업 S -->
<div class="popup-layout" id="goodsView-benefits">
	<div class="popup-title">
		<span id="devModalTitle">혜택 내역</span>
		<button type="button" class="btn-close">닫기</button>
	</div>
	<div id="devModalContent" class="popup-content">
		<section class="popup-content__wrap">
			<div class="benefits-list">
				<dl class="benefits-item">
					<dt class="benefits-name">할인가</dt>
					<dd class="benefits-price">- <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["directDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["directDiscountPrice"])?><?php }else{?>0<?php }?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>
				<dl class="benefits-item">
					<dt class="benefits-name">기획 할인</dt>
					<dd class="benefits-price">- <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["planDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["planDiscountPrice"])?><?php }else{?>0<?php }?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>
				<dl class="benefits-item">
					<dt class="benefits-name">추가 할인</dt>
					<dd class="benefits-price">- <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["addDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["addDiscountPrice"])?><?php }else{?>0<?php }?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>
				<dl class="benefits-item">
					<dt class="benefits-name">쿠폰 할인</dt>
					<dd class="benefits-price">- <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["couponDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["couponDiscountPrice"])?><?php }else{?>0<?php }?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>
				<dl class="benefits-item">
					<dt class="benefits-name">회원 등급 할인</dt>
					<dd class="benefits-price">- <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["groupDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["groupDiscountPrice"])?><?php }else{?>0<?php }?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
				</dl>
				<dl class="benefits-item benefits-item__total">
					<dt class="benefits-name">최대 혜택가</dt>
					<dd class="benefits-price">
						<span class="percent"><em><?php echo $TPL_VAR["totalDiscountRate"]?></em>%</span>
						<span class="price"><em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["couponApplyPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
					</dd>
				</dl>
				<div class="benefits-btn">
					<button type="button" class="btn-lg btn-dark-line btn-close">확인</button>
				</div>
			</div>
		</section>
	</div>
</div>
<!-- 혜택 안내 팝업 E -->

<!-- 상품 공유하기 팝업 S -->
<div class="popup-layout" id="goodsView-share">
	<div class="popup-title">
		<span id="devModalTitle">상품 공유 하기</span>
		<button type="button" class="btn-close">닫기</button>
	</div>
	<div id="devModalContent" class="popup-content">
		<section class="popup-content__wrap">
			<div class="popup-share__wrap">
				<div class="popup-product">
					<div class="popup-product__left">
						<figure class="popup-product__thumb">
<?php if($TPL_image_src_1){$TPL_I1=-1;foreach($TPL_VAR["image_src"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
								<img src="<?php echo $TPL_V1["basic_img"]?>" alt="" />
<?php }?>
<?php }}?>
						</figure>
					</div>
					<div class="popup-product__info goods-info">
						<div class="goods-info__title"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></div>
						<!--<div class="goods-info__option">
							<span>미드나잇</span>
							<span>95</span>
							<span>1개</span>
						</div>-->
						<dl class="goods-info__price-group">
							<dt></dt>
							<dd>
								<div class="goods-info__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
							</dd>
						</dl>
					</div>
				</div>
				<div class="popup-share__footer">
					<ul>
						<!--<li>
							<button type="button" class="btn-sns"><i class="ico ico-instagram-bk">인스타그램</i></button>
						</li>-->
						<li>
							<button type="button" class="btn-sns layer-share__sns__btn--kakaotalk" devSnsShare="kakaotalk"><i class="ico ico-KakaoTalk-bk2">카카오</i></button>
						</li>
						<li>
							<button type="button" class="btn-sns layer-share__sns__btn--facebook" devSnsShare="facebook"><i class="ico ico-facebook-bk">페이스북</i></button>
						</li>
						<li>
							<button type="button" class="btn-sns layer-share__sns__btn--url" devSnsShare="url-copy">URL</button>
						</li>
					</ul>
				</div>
			</div>
		</section>
	</div>
</div>
<!-- 상품 공유하기 팝업 E -->

<!-- 최대구매초과 팝업 S -->
<div class="popup-layout popup-layout__small popup-guide" id="goodsView-guide">
	<div id="" class="popup-content">
		<section class="popup-content__wrap">
			<div class="guide-box">
				<div class="title-md">최대 구매수량을 초과하였습니다.</div>
				<div class="guide-cont">
					<p>해당 상품은 구매수량 제한 상품으로 더 이상 구매하실 수 없습니다.</p>
				</div>
				<div class="link-group">
					<a href="javascript:void(0);" class="btn-link btn-close close">확인</a>
				</div>
			</div>
		</section>
	</div>
</div>
<!-- 최대구매초과 팝업 E -->

<!-- 회원구매전용 팝업 S -->
<div class="popup-layout popup-layout__small popup-guide" id="goodsView-member">
	<div id="" class="popup-content">
		<section class="popup-content__wrap">
			<div class="guide-box">
				<div class="title-md">회원 전용 구매 상품입니다.</div>
				<div class="guide-cont">
					<p>해당 상품은 회원 전용 상품으로 비회원은 구매하실 수 없습니다.<br />회원가입을 하시겠습니까?</p>
				</div>
				<div class="link-group">
					<a href="javascript:void(0);" class="btn-link">회원가입</a>
					<a href="javascript:void(0);" class="btn-link btn-close close">취소</a>
				</div>
			</div>
		</section>
	</div>
</div>
<!-- 회원구매전용 팝업 E -->
<!-- 팝업 E -->