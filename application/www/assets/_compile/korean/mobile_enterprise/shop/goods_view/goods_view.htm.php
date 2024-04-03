<?php /* Template_ 2.2.8 2024/04/01 09:44:46 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/goods_view/goods_view.htm 000209630 */ 
$TPL_image_src_1=empty($TPL_VAR["image_src"])||!is_array($TPL_VAR["image_src"])?0:count($TPL_VAR["image_src"]);
$TPL_sameProduct_1=empty($TPL_VAR["sameProduct"])||!is_array($TPL_VAR["sameProduct"])?0:count($TPL_VAR["sameProduct"]);
$TPL_productGiftInfo_1=empty($TPL_VAR["productGiftInfo"])||!is_array($TPL_VAR["productGiftInfo"])?0:count($TPL_VAR["productGiftInfo"]);
$TPL_product_gift_1=empty($TPL_VAR["product_gift"])||!is_array($TPL_VAR["product_gift"])?0:count($TPL_VAR["product_gift"]);
$TPL_relationProduct_1=empty($TPL_VAR["relationProduct"])||!is_array($TPL_VAR["relationProduct"])?0:count($TPL_VAR["relationProduct"]);
$TPL_eventBannerInfo_1=empty($TPL_VAR["eventBannerInfo"])||!is_array($TPL_VAR["eventBannerInfo"])?0:count($TPL_VAR["eventBannerInfo"]);
$TPL_mandatoryInfos_1=empty($TPL_VAR["mandatoryInfos"])||!is_array($TPL_VAR["mandatoryInfos"])?0:count($TPL_VAR["mandatoryInfos"]);
$TPL_displayContentList_1=empty($TPL_VAR["displayContentList"])||!is_array($TPL_VAR["displayContentList"])?0:count($TPL_VAR["displayContentList"]);
$TPL_togeterProduct_1=empty($TPL_VAR["togeterProduct"])||!is_array($TPL_VAR["togeterProduct"])?0:count($TPL_VAR["togeterProduct"]);
$TPL_similraProduct_1=empty($TPL_VAR["similraProduct"])||!is_array($TPL_VAR["similraProduct"])?0:count($TPL_VAR["similraProduct"]);
$TPL_couponList_1=empty($TPL_VAR["couponList"])||!is_array($TPL_VAR["couponList"])?0:count($TPL_VAR["couponList"]);
$TPL_optionData_1=empty($TPL_VAR["optionData"])||!is_array($TPL_VAR["optionData"])?0:count($TPL_VAR["optionData"]);
$TPL_style_1=empty($TPL_VAR["style"])||!is_array($TPL_VAR["style"])?0:count($TPL_VAR["style"]);
$TPL_option_1=empty($TPL_VAR["option"])||!is_array($TPL_VAR["option"])?0:count($TPL_VAR["option"]);
$TPL_laundryOneDepth_1=empty($TPL_VAR["laundryOneDepth"])||!is_array($TPL_VAR["laundryOneDepth"])?0:count($TPL_VAR["laundryOneDepth"]);
$TPL_laundry_1=empty($TPL_VAR["laundry"])||!is_array($TPL_VAR["laundry"])?0:count($TPL_VAR["laundry"]);
$TPL_qnaDivs_1=empty($TPL_VAR["qnaDivs"])||!is_array($TPL_VAR["qnaDivs"])?0:count($TPL_VAR["qnaDivs"]);?>
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
        (window,document,'script','crema-jssdk','//<?php echo CREMA_WIDGET_HOST?>/getbarrel.com/mobile/init.js');
</script>
<script>
    function cartPopClose(clickNum){
        if(clickNum == 1){
            location.reload();
        }else if(clickNum == 2){
            location.href = '/shop/cart';
        }
    }
</script>
    <section class="br__goods-view">
        <h2 class="br__hidden">상품상세</h2>
        <!-- 상품슬라이드 S -->
        <section class="br__goods-view__thumb">
            <h3 class="br__hidden">상품 썸네일</h3>
            <div class="goods-thumb swiper-container">
                <ul class="swiper-wrapper">
<?php if($TPL_image_src_1){foreach($TPL_VAR["image_src"] as $TPL_V1){?>
                        <li class="swiper-slide">
                            <!--<a href="<?php echo $TPL_V1["basic_img"]?>" target="_blank" title="썸네일 원본보기">-->
                                <figure class="goods-thumb__box">
                                    <img src="<?php echo $TPL_V1["basic_img"]?>" alt="상품 썸네일" />
                                </figure>
                            <!--</a>-->
                        </li>
<?php }}?>
<?php if($TPL_VAR["movie"]){?>
                        <li class="swiper-slide" id="videoPlayer" data-vimeo-url="<?php echo $TPL_VAR["movie"]?>" data-url="<?php echo $TPL_VAR["movie"]?>">
							<div class="goods-thumb__box" id="js__video__target" data-movie="<?php echo $TPL_VAR["movie"]?>"></div>
                        </li>
<?php }?>
                </ul>
                <div class="goods-thumb__control">
                    <div class="swiper-control-group">
                        <div class="swiper-scrollbar"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
<?php if($TPL_VAR["wear_info"]){?>
            <div class="goods-thumb__info">
                <p><?php echo nl2br($TPL_VAR["wear_info"])?></p>
            </div>
<?php }?>
        </section>
        <!-- 상품슬라이드 E -->

        <!-- 타임세일 S -->
        <!-- 숨김 처리 -->
        <section class="br__goods-view__time-sale" style="display: none">
            <div class="time-sale">
                <p class="time-sale__title"><span>타임세일 상품</span></p>
                <p class="time-sale__countdown time-sale__countdown--show"><span>01:00</span> 후 종료!</p>
            </div>
        </section>
        <!-- 타임세일 E -->

        <!-- 상품기본정보 S -->
        <section class="br__goods-view__information">
            <h3 class="br__hidden">상품 기본 정보</h3>
            <div class="goods-info">
                <div class="goods-info__btns">
                    <h4 class="br__hidden">상품 공유하기 & 위시 버튼</h4>
                    <label class="goods-info__btns__wish <?php if($TPL_VAR["alreadyWish"]){?>on<?php }?>" devwishbtn="<?php echo $TPL_VAR["pid"]?>">
<?php if($TPL_VAR["alreadyWish"]){?>
                        <input type="checkbox" class="goods-info__btns__wish__btn" id="wishCheckBox_{[pid]}" onclick="productWish('{[pid]}')" checked>
<?php }else{?>
                        <input type="checkbox" class="goods-info__btns__wish__btn" id="wishCheckBox_{[pid]}" onclick="productWish('{[pid]}')" >
<?php }?>
                        위시리스트 추가
                    </label>
                    <button type="button" class="goods-info__btns__share" onclick="DownLayerJSNew('layer-share')"><i class="ico ico-share"></i>공유하기</button>
                </div>
                <!-- 소재 S -->
                <div class="goods-info__pre" style="color:<?php echo $TPL_VAR["prefaceColor"]?>;<?php if($TPL_VAR["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["prefaceName"]?></div>
                <!-- 소재 E -->

                <!-- 뱃지 S -->
                <!-- 숨김 -->
                <div class="goods-info__badge" style="display: none">
                    <h4 class="br__hidden">상품 뱃지</h4>
                    <span>뱃지</span>
                </div>
                <!-- 뱃지 E -->

                <!-- 상품 명 S -->
                <div class="goods-info__title"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></div>
                <!-- 상품 명 E -->

                <!-- 컬러 명 S -->
                <div class="goods-info__title-sub"><?php echo $TPL_VAR["add_info"]?></div>
                <!-- 컬러 명 E -->

                <!-- 세트 명 S -->
                <div class="goods-info__title-sub" style="display:none;">상/하의 세트</div>
                <!-- 세트 명 E -->

                <!-- 모델 번호 S -->
                <div class="goods-info__model-number"><?php echo $TPL_VAR["pcode"]?></div>
                <!-- 모델 번호 E -->

                <div class="goods-info__price">
                    <h4 class="br__hidden">상품 가격</h4>
                    <div class="goods-info__price-group">
<?php if($TPL_VAR["discount_rate"]> 0){?><span class="goods-info__price__discount"><em><?php echo $TPL_VAR["discount_rate"]?></em>%</span><?php }?>
                        <span class="goods-info__price__result"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["dcprice"])?></em></span>
<?php if($TPL_VAR["discount_rate"]> 0){?><del class="goods-info__price__strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["listprice"])?></em></del><?php }?>
                    </div>
<?php if($TPL_VAR["couponApplyCnt"]> 0){?>
                    <div class="goods-info__coupon">
                        <button type="button" class="btn-md btn-dark-line goods-info__coupon__btn" onclick="DownLayerJSNew('layer-coupon1')">쿠폰받기</button>
                    </div>
<?php }?>
                </div>
                <button type="button" class="btn-md btn-dark-line goods-info__benefit-list" onclick="DownLayerJSNew('layer-benefitList')">혜택 내역</button>

                <!-- 구매 적립금 S -->
                <div class="goods-info__other">
                    <div class="goods-info__other-title">
                        <div class="titls-sm">구매 예상 적립금</div>
                        <span class="price"><em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["save_reserve"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                    </div>
                    <p class="goods-info__other-desc">적립금은 실제 결제 금액에 따라 달라집니다.</p>
                </div>
                <!-- 구매 적립금 E -->

                <!-- 상품 후기 S -->
                <div class="goods-info__review">
                    <div class="goods-info__review-title">상품 리뷰</div>
                    <div class="goods-info__review-star">
                        <a href="#review">
                            <span class="goods-info__review-star--point"><span style="width: <?php echo $TPL_VAR["total_review_star_per"]?>%"></span></span>
                            <span class="goods-info__review-star--text">(<?php echo $TPL_VAR["total_review_cnt"]?>)</span>
                        </a>
                    </div>
                </div>
                <!-- 상품 후기 E -->
            </div>
        </section>
        <!-- 상품기본정보 E -->

        <!-- 상품 옵션 S -->
        <section class="br__goods-view__option" id="devSildeMinicartArea">
            <div class="goods-info">
                <!-- 색상 옵션 S -->
<?php if($TPL_VAR["product_type"]== 0&&$TPL_VAR["add_info"]!=''){?>
                <div class="goods-info__option goods-info__color">
                    <div class="goods-info__option-title">
                        <div class="title-sm">색상</div>
                        <div class="goods-info__option-value"><?php echo $TPL_VAR["add_info"]?></div>
                    </div>
                    <div class="goods-info__option-cont">
                        <div class="goods-info__option-slide swiper-container">
<?php if($TPL_VAR["sameProduct"]){?>
                            <ul class="goods-info__color__list swiper-wrapper">
<?php if($TPL_sameProduct_1){foreach($TPL_VAR["sameProduct"] as $TPL_V1){?>
                                <li class="goods-info__color__item swiper-slide">
                                    <a href="/shop/goodsView/<?php echo $TPL_V1["pid"]?>" class="goods-info__color__link <?php if($TPL_VAR["pid"]==$TPL_V1["pid"]){?>goods-info__color__link--active<?php }?>">
<?php if($TPL_V1["pattImg"]==''){?>
                                        <img src="<?php echo $TPL_V1["filterImg"]?>" alt="색상명" />
<?php }else{?>
                                        <img src="<?php echo $TPL_V1["pattImg"]?>" alt="패턴명" />
<?php }?>
                                    </a>
                                </li>
<?php }}?>
                            </ul>
<?php }?>
                        </div>
                    </div>
                </div>
<?php }?>
                <!-- 색상 옵션 E -->

                <!-- 사이즈 옵션 S -->
                <div class="goods-info__option goods-info__size" data-pid="<?php echo $TPL_VAR["pid"]?>">
                    <div class="devForbizTpl" id="devSildeLonelyOption">
                        <span id="devSildeLonelyOptionName">
                            <p>{[option_name]}</p>
                        </span>
                    </div>


                    <div class="goods-info__option-cont" id="devSildeMinicartOptions"></div>

                    <style>
                        .crema-fit-product-combined-summary { margin: 20px 0; }
                        .crema-fit-product-combined-summary > iframe { max-width: 100% !important; }
                        .ig_gap {    position: relative;    padding: 1.1rem 0;    line-height: 2.7rem;}
                    </style>
                    <div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" class="crema-fit-product-combined-summary" style="display:none;"></div>
<?php if(count($TPL_VAR["product_gift"])== 0&&$TPL_VAR["gift_selectbox_cnt"]> 1&&count($TPL_VAR["ig_addOptions"])== 0){?>
                    <div class="ig_gap"></div>
<?php }else{?>

<?php }?>

                    <!--<div class="goods-info__option-cont">
                        <ul class="goods-info__size__list">
                            <li class="goods-info__size__item">
                                <button type="button" class="goods-info__size__btn goods-info__size__btn&#45;&#45;active">75</button>
                            </li>
                            <li class="goods-info__size__item">
                                <button type="button" class="goods-info__size__btn">80</button>
                            </li>
                            <li class="goods-info__size__item">
                                <button type="button" class="goods-info__size__btn" disabled>85</button>
                            </li>
                            <li class="goods-info__size__item">
                                <button type="button" class="goods-info__size__btn">90</button>
                            </li>
                            <li class="goods-info__size__item">
                                <button type="button" class="goods-info__size__btn">95</button>
                            </li>
                            <li class="goods-info__size__item">
                                <button type="button" class="goods-info__size__btn">100</button>
                            </li>
                            <li class="goods-info__size__item">
                                <button type="button" class="goods-info__size__btn" disabled>105</button>
                            </li>
                        </ul>
                    </div>
                    <button type="button" class="btn-md btn-dark-line goods-info__size__alarm" onclick="DownLayerJS('layer-restock1')">재입고 알림 신청</button>-->
                </div>
                <!-- 사이즈 옵션 E -->

                <!-- 세트 상품 옵션 S -->
                <!--<div class="goods-info__set-group" id="devSlideMinicartAddOption">
                    <div class="goods-info__option goods-info__set">
                        <div class="goods-info__option-title">
                            <div class="title-sm">트랙 자켓</div>
                        </div>
                        <div class="goods-info__option-cont">
                            <ul class="goods-info__set__list">
                                <li class="goods-info__set__item">
                                    <select class="br__form-select">
                                        <option>색상 [필수]</option>
                                    </select>
                                </li>
                                <li class="goods-info__set__item">
                                    <select class="br__form-select" disabled>
                                        <option>사이즈 [필수]</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="goods-info__option goods-info__set">
                        <div class="goods-info__option-title">
                            <div class="title-sm">트랙 팬츠</div>
                        </div>
                        <div class="goods-info__option-cont">
                            <ul class="goods-info__set__list">
                                <li class="goods-info__set__item">
                                    <select class="br__form-select">
                                        <option>색상 [필수]</option>
                                    </select>
                                </li>
                                <li class="goods-info__set__item">
                                    <select class="br__form-select" disabled>
                                        <option>사이즈 [필수]</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>-->
                <!-- 세트 상품 옵션 E -->

                <!-- 신체 사이즈 가이드 S -->
                <div class="goods-info__size__guide">
                    <button type="button" class="goods-info__size__guide-btn" onclick="DownLayerJSNew2('layer-sizeGuide')">신체 사이즈 가이드</button>
                </div>
                <!-- 신체 사이즈 가이드 E -->

                <!-- 추가 옵션 상품 S -->
                <!-- <div class="goods-info__toggle goods-info__addition active" id="devSlideMinicartAddOption" style="display:none;">
                    <div class="goods-info__toggle-title">
                        <button type="button" class="goods-info__toggle-title--btn">
                            <span class="title-sm">추가 옵션 상품</span>
                            <i class="ico ico-plus"></i>
                        </button>
                    </div>
                    <div class="goods-info__toggle-cont">
                        <div class="product-list">
                            <ul class="product-list__wrap">
                                <li class="product-list__item">
                                    <dl class="product-list__group">
                                        <dt class="product-list__group-left">
                                            <figure class="product-list__thumb">
                                                <a href="javascript:void(0);">
                                                    <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                </a>
                                            </figure>
                                        </dt>
                                        <dd class="product-list__group-right">
                                            <div class="product-list__info">
                                                <div class="product-list__info__title">우먼 피쉬백 스트랩 스윔 브라탑</div>
                                                -- 일반상품 상품 S --
                                                <div class="product-list__info__option">
                                                    <div class="product-list__info__option-item">
                                                        <span class="color">미드나잇</span>
                                                    </div>
                                                </div>
                                                -- 일반상품 상품 E --

                                                <div class="product-list__info__price">
                                                    <span class="product-list__info__price--discount">10%</span>
                                                    <del class="product-list__info__price--strike"><em>1,405,550</em>원</del>
                                                    <span class="product-list__info__price--cost"><em>1,265,550</em>원</span>
                                                </div>
                                                <div class="product-list__select">
                                                    <select class="br__form-select">
                                                        <option>추가 옵션 선택</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </dd>
                                    </dl>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> -->


				<!-- 추가 상품 옵션 S -->
				<div class="info__box info__box-addition" id="devMinicartTopAddOption">
					<dl class="info__list active" id="dlClassTag">
						<dt class="info__list-title">
							<div class="info__title">
								<a class="info__title-toggle" href="javascript:void(0);">추가 옵션 상품 <i class="ico ico-plus" onclick="addOption();"></i></a>
							</div>
						</dt>
						<dd class="info__list-cont" style="display: block" id="devSlideMinicartAddOption">

						</dd>
					</dl>
				</div>
				<!-- 추가 상품 옵션 E -->

				<!-- 추가 옵션 상품 S -- 
				<div class="goods-info__toggle goods-info__addition active">
					<div class="goods-info__toggle-title">
						<button type="button" class="goods-info__toggle-title--btn">
							<span class="title-sm">추가 옵션 상품</span>
							<i class="ico ico-plus"></i>
						</button>
					</div>
					<div class="goods-info__toggle-cont">
						<div class="product-list">
							<ul class="product-list__wrap">
								<li class="product-list__item">
									<dl class="product-list__group">
										<dt class="product-list__group-left">
											<figure class="product-list__thumb">
												<a href="#;">
													<img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
												</a>
											</figure>
										</dt>
										<dd class="product-list__group-right">
											<div class="product-list__info">
												<div class="product-list__info__title">우먼 피쉬백 스트랩 스윔 브라탑</div>
												
												<div class="product-list__info__option">
													<div class="product-list__info__option-item">
														<span class="color">미드나잇</span>
													</div>
												</div>
												

												<div class="product-list__info__price">
													<span class="product-list__info__price--discount">10%</span>
													<del class="product-list__info__price--strike"><em>1,405,550</em>원</del>
													<span class="product-list__info__price--cost"><em>1,265,550</em>원</span>
												</div>
												<div class="product-list__select">
													<select class="br__form-select">
														<option>추가 옵션 선택</option>
													</select>
												</div>
											</div>
										</dd>
									</dl>
								</li>
							</ul>
						</div>
					</div>
				</div>
				-- 추가 옵션 상품 E -->

                <!-- 사은품 상품 S -->
<?php if($TPL_VAR["product_gift"]){?>
                <div class="goods-info__toggle goods-info__gifts">
                    <div class="goods-info__toggle-title">
                        <button type="button" class="goods-info__toggle-title--btn">
                            <span class="title-sm">사은품</span>
                            <i class="ico ico-plus"></i>
                        </button>
                    </div>
                    <div class="goods-info__toggle-cont">
                        <div class="product-list">
                            <ul class="product-list__wrap">
                                <li class="product-list__item">
                                    <dl class="product-list__group">
										<dt class="product-list__group-left">
											<figure class="product-list__thumb">
                                                <img id="giftImg" src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_freebie_sel_mo.png" alt="" />
											</figure>
										</dt>

                                        <dd class="product-list__group-right">
                                            <div class="product-list__info">
<?php if($TPL_productGiftInfo_1){foreach($TPL_VAR["productGiftInfo"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='soldout'){?>
                                                <div class="product-list__info__title" id="giftPname"></div>

                                                <div class="product-list__info__option">
                                                    <div class="product-list__info__option-item">
                                                        <span class="color" id="giftDate"></span>
                                                    </div>
                                                </div>


                                                <div class="product-list__info__price">
                                                    <span class="product-list__info__price--cost" id="giftPrice"></span>
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
<?php if($TPL_product_gift_1){$TPL_I1=-1;foreach($TPL_VAR["product_gift"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1<$TPL_VAR["gift_selectbox_cnt"]){?>
                                                <div class="product-list__select">
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
                                                    <input type="hidden" name="giftImg" id="giftImg_0000055421" value="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_no-freebie_mo.png">
<?php }?>
                                                    <input type="hidden" name="giftImg" id="giftImg_" value="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_freebie_sel_mo.png">
                                                </div>
<?php }?>
<?php }}?>
                                            </div>
                                        </dd>
                                    </dl>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
<?php }?>
                <!-- 사은품 상품 E -->



                <!-- 배송혜택 안내 S -->
                <div class="goods-info__delivery">
                    <div class="goods-info__delivery-title">배송혜택</div>
                    <div class="goods-info__delivery-desc">
                        30,000원 이상 구매 시 무료배송.<br />
                        (도서산간 및 제주 3,000원 추가)
                    </div>
                </div>
                <!-- 배송혜택 안내 E -->

                <!-- 선택된 상품 리스트 S -->
                <div class="goods-cart__wrap">
                    <ul class="goods-cart" id="devSildeMinicartSelected">
                        <li class="goods-cart__box devOptionBox devForbizTpl" devOptionKind="{[option_kind]}" devOptid="{[option_id]}" devUnit="{[option_dcprice]}" devStock="{[option_stock]}">
                            <div class="goods-cart__title">
                                <div class="title-sm">{[option_prefix]}{[pname]}</div>
                                <button type="button" class="btn-option-del devSildeMinicartDelete">삭제</button>
                            </div>
                            <div class="goods-cart__cont">
                                <div class="goods-cart__sub">
                                    <div class="goods-cart__sub-item">
                                        <span class="color">{[add_info_text]}</span>
                                        <span class="size">{[option_div_text]}</span>
                                        <span class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em class="devMinicartEachPrice">{[eachPrice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                    </div>
                                </div>
                                <div class="control">
                                    <ul class="control-box option-up-down devControlCntBox">
                                        <li class="devCntMinus"><button type="button" class="down devCountDownButton"></button></li>
                                        <li><input type="text" value="{[allowBasicCnt]}" class="br__form-input devCount option-text devMinicartPrdCnt" /></li>
                                        <li class="devCntPlus"><button type="button" class="up devCountUpButton"></button></li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                        <!-- 세트 상품 S -->
                        <!--<li class="goods-cart__box">
                            <div class="goods-cart__title">
                                <div class="title-sm">우먼 리플렉션 아쿠아 브릿지백 스트랩 스윔슈트</div>
                                <button type="button" class="btn-option-del">삭제</button>
                            </div>
                            <div class="goods-cart__cont">
                                <div class="goods-cart__sub">
                                    <div class="goods-cart__sub-item">
                                        <span class="title">유니섹스 트랙 셋업 자켓</span>
                                        <span class="color">블랙</span>
                                        <span class="size">M</span>
                                    </div>
                                    <div class="goods-cart__sub-item">
                                        <span class="title">유니섹스 트랙 셋업 자켓</span>
                                        <span class="color">블랙</span>
                                        <span class="size">M</span>
                                        <span class="price"><em>1,234,567</em>원</span>
                                    </div>
                                </div>
                                <div class="control">
                                    <ul class="control-box option-up-down">
                                        <li><button type="button" class="down"></button></li>
                                        <li><input type="text" value="1" class="br__form-input" /></li>
                                        <li><button type="button" class="up"></button></li>
                                    </ul>
                                </div>
                            </div>
                        </li>-->
                        <!-- 세트 상품 E -->
                    </ul>
                </div>
                <!-- 선택된 상품 리스트 E -->

                <div class="goods-view__btn-group">
                    <div class="goods-view__total">
                        <dt>총 상품 금액</dt>
                        <dd><em id="devMinicartTotal_ig">0</em>원</dd>
                    </div>
                    <div class="btn-group">
<?php if($TPL_VAR["status"]=='sale'){?>
                        <button type="button" class="btn-lg btn-dark-line goods-btn__cart devAddCart_ig devAddCart__layerBtn">장바구니</button>
<?php }?>
<?php if($TPL_VAR["status"]=='sale'){?>
                        <!--<button type="button" class="goods-btn__buy devOrderDirect_ig ">구매하기</button>-->
                        <button type="button" class="btn-lg btn-dark goods-btn__buy devOrderDirect_ig">구매하기</button>
<?php }elseif($TPL_VAR["status"]=='ready'){?>
                        <button type="button" class="btn-lg btn-dark goods-btn__buy devOrderDirect" disabled>판매예정</button>
<?php }elseif($TPL_VAR["status"]=='end'){?>
                        <button type="button" class="btn-lg btn-dark goods-btn__buy devOrderDirect" disabled>판매종료</button>
<?php }else{?>
                        <button type="button" class="btn-lg btn-dark goods-btn__buy devOrderDirect" disabled>일시품절</button>
<?php }?>
                    </div>
                    <button type="button" class="btn-lg btn-gray-line" onclick="DownLayerJSNew('layer-store')">구매가능 매장</button>

                </div>
            </div>
        </section>
        <!-- 상품 옵션 E -->

        <!-- 추천 연관 상품 S -->
        <section class="br__goods-view__recommend">
<?php if($TPL_VAR["relationProduct"]){?>
            <div class="goods-title">
                <div class="title-md">추천 연관 상품</div>
            </div>
            <div class="goods-recom">
                <div class="goods-list goods-list__slide swiper-container">
                    <ul class="goods-list__list swiper-wrapper">
<?php if($TPL_relationProduct_1){foreach($TPL_VAR["relationProduct"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='stop'){?>
                        <li class="goods-list__box swiper-slide">
                            <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="goods-list__link">
                                <div class="goods-list__thumb">
                                    <div class="goods-list__thumb-slide swiper-container">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="<?php echo $TPL_V1["image_src"]?>" alt="" />
                                            </div>
                                            <!--<div class="swiper-slide">
                                                <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                            </div>
                                            <div class="swiper-slide">
                                                <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                            </div>-->
                                        </div>
                                        <!--<div class="swiper-control-group">
                                            <div class="swiper-scrollbar"></div>
                                        </div>-->
                                    </div>
                                    <!-- 버튼으로 할 경우 S -->
                                    <!-- 숨김처리 -->
                                    <button type="button" class="btn-wishlist" style="display: none">
                                        <!-- 선택시 button class = active 추가-->
                                        <i class="ico ico-wishlist"></i>위시리스트
                                    </button>
                                    <!-- 버튼으로 할 경우 E -->

                                    <!-- 체크 박스로 할 경우 S -->
                                    <label class="goods-list__wish <?php if($TPL_VAR["alreadyWish"]){?>on<?php }?>" devwishbtn="<?php echo $TPL_VAR["pid"]?>">
<?php if($TPL_VAR["alreadyWish"]){?>
                                        <input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_{[pid]}" onclick="productWish('{[pid]}')" checked>
<?php }else{?>
                                        <input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_{[pid]}" onclick="productWish('{[pid]}')">
<?php }?>
                                        위시리스트 추가
                                    </label>
                                    <!-- 체크 박스로 할 경우 E -->
                                </div>
                                <div class="goods-list__info">
                                    <div class="goods-list__pre br__goods__pre"><?php echo $TPL_V1["prefaceName"]?></div>
                                    <div class="goods-list__title"><?php echo $TPL_V1["pname"]?></div>
                                    <div class="goods-list__color"><?php echo $TPL_V1["add_info"]?></div>
                                    <div class="goods-list__price">
<?php if($TPL_V1["isDiscount"]){?>
                                        <div class="goods-list__price__percent"><span><?php echo $TPL_V1["discount_rate"]?></span>%</div>
<?php }?>
                                        <div class="goods-list__price__discount"><span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["dcprice"])?></span></div>
<?php if($TPL_V1["isDiscount"]){?>
                                        <div class="goods-list__price__cost"><del><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?></del></div>
<?php }?>
                                        <!-- 품절일 경우 S -->
                                        <!-- 숨김 처리 -->
<?php if($TPL_V1["is_soldout"]){?>
                                        <div class="goods-list__price__state">품절</div>
<?php }?>
                                        <!-- 품절일 경우 E -->
                                    </div>
                                </div>
                            </a>
                        </li>
<?php }else{?>
                        <!--등록된 상품이 없을 시 S -->
                        <li class="goods-list__box no-data" id="devListEmpty" style="display: none !important"><p class="empty-content">추천 연관 상품이 없습니다.</p></li>
                        <!--등록된 상품이 없을 시 E -->
<?php }?>
<?php }}?>
                        <!-- 상품이 없을 경우 S -->
                        <!-- 숨김처리 -->
                        <!--<li class="goods-list__box no-data" style="display: none">
                            <p class="empty-content">가장 인기있는 상품이 없습니다</p>
                        </li>-->
                        <!-- 상품이 없을 경우 E -->
                    </ul>
                </div>
            </div>
<?php }?>
        </section>
        <!-- 추천 연관 상품 E -->

        <!-- 이벤트 배너 S -->
<?php if($TPL_VAR["eventBannerInfo"]){?>
        <section class="br__goods-view__event">
            <h3 class="br__hidden">이벤트 배너</h3>
            <div class="goods-event">
                <div class="goods-event__slide swiper-container">
                    <div class="swiper-wrapper">
<?php if($TPL_eventBannerInfo_1){foreach($TPL_VAR["eventBannerInfo"] as $TPL_V1){?>
                        <div class="swiper-slide">
                            <a href="<?php echo $TPL_V1["bannerLink"]?>"><img src="<?php echo $TPL_V1["imgSrcOn"]?>" alt="<?php echo $TPL_V1["bd_title"]?>" /></a>
                        </div>
<?php }}?>
                    </div>
                    <div class="goods-event__control">
                        <div class="swiper-control-group">
                            <div class="swiper-scrollbar"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php }?>
        <!-- 이벤트 배너 E -->

        <!-- 크리마 리뷰 S -->
        <section class="br__goods-view__banner" style="display:none;">
            <div style="height: 40rem; background: #ededed; color: #a5a5a5">공통배너 이미지 영역</div>
        </section>
        <!-- 크리마 리뷰 E -->

        <!-- 상품상세 하단버튼 S -->
        <section class="br__goods-view__btn">
            <dl>
                <dt>
                    <!-- 위시 리스트 버튼 S -->
                    <!-- 버튼으로 할 경우 S -->
                    <!-- 숨김처리 -->
                    <button type="button" class="goods-btn__wish" style="display: none"><i class="ico ico-wishlist"></i>위시리스트</button>
                    <!-- 버튼으로 할 경우 E -->

                    <!-- 체크 박스로 할 경우 S -->
                    <label class="goods-info__btns__wish <?php if($TPL_VAR["alreadyWish"]){?>on<?php }?>" devwishbtn="<?php echo $TPL_VAR["pid"]?>">
<?php if($TPL_VAR["alreadyWish"]){?>
                        <input type="checkbox" class="goods-info__btns__wish__btn" checked>
<?php }else{?>
                        <input type="checkbox" class="goods-info__btns__wish__btn">
<?php }?>
                        위시리스트 추가
                    </label>
                    <!-- 체크 박스로 할 경우 E -->
                    <!-- 위시 리스트 버튼 E -->
                    <button type="button" class="goods-btn__map" onclick="DownLayerJSNew('layer-store')"><i class="ico ico-map"></i>매장안내</button>
                    <button type="button" class="goods-btn__share" onclick="DownLayerJSNew('layer-share')"><i class="ico ico-share"></i>공유하기</button>
                </dt>
                <dd>
                    <button type="button" class="btn-lg btn-dark goods-btn__buy devOrderDirect" onclick="DownLayerJSNew('layer-order')">구매하기</button>
                </dd>
            </dl>
        </section>
<script>
    // 페이지가 로딩된 후 실행될 함수
    window.onload = function() {
        // 이동할 위치를 계산하여 스크롤
        function scrollToElement(elementId) {
            var element = document.getElementById(elementId);
            if (element) {
                var offset = 50; // 추가로 위로 이동할 픽셀 수
                var elementPosition = element.getBoundingClientRect().top + window.pageYOffset;
                window.scrollTo({
                    top: elementPosition - offset,
                    behavior: 'smooth' // 부드러운 스크롤 효과
                });
            }
        }

        // 페이지 내의 특정 링크를 클릭했을 때 스크롤하여 해당 위치로 이동
        var link = document.querySelector('a[href="#washing"]');
        if (link) {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // 링크의 기본 동작 취소
                scrollToElement('washing'); // 이동할 위치로 스크롤
            });
        }

        // 페이지 내의 특정 링크를 클릭했을 때 스크롤하여 해당 위치로 이동
        var link = document.querySelector('a[href="#return"]');
        if (link) {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // 링크의 기본 동작 취소
                scrollToElement('return'); // 이동할 위치로 스크롤
            });
        }

        // 페이지 내의 특정 링크를 클릭했을 때 스크롤하여 해당 위치로 이동
        var link = document.querySelector('a[href="#qna"]');
        if (link) {
            link.addEventListener('click', function(event) {
                event.preventDefault(); // 링크의 기본 동작 취소
                scrollToElement('qna'); // 이동할 위치로 스크롤
            });
        }
    };
</script>
        <!-- 상품상세 하단버튼 E -->
        <section class="br__goods-view__tabs">
            <h3 class="br__hidden">상품 상세 및 후기, 문의, 반품</h3>
            <div class="goods-tabs">
                <div class="goods-tabs__nav br-tab__slide swiper-container">
                    <ul class="swiper-wrapper">
                        <li class="swiper-slide active">
                            <a href="#review">상품 리뷰 <em><?php echo $TPL_VAR["total_review_cnt"]?></em></a>
                        </li>
                        <li class="swiper-slide">
                            <a href="#detail">상품정보</a>
                        </li>
                        <li class="swiper-slide">
                            <a href="#sizeGuide">사이즈 가이드</a>
                        </li>
                        <li class="swiper-slide">
                            <a href="#washing">세탁 & 주의사항</a>
                        </li>
                        <li class="swiper-slide">
                            <a href="#return">반품 & 환불</a>
                        </li>
                        <li class="swiper-slide">
                            <a href="#qna">상품문의</a>
                        </li>
                    </ul>
                </div>
                <div class="goods-tabs__content goods-review" id="review">
                    <div class="br__account active">
                        <button type="button" class="br__account__title active">
                            <span class="title-sm">상품 리뷰</span>
                            <i class="ico ico-plus"></i>
                        </button>
                        <div class="br__account__content">
                            <div class="goods-review__wrap">
                                <div class="title-sm">후기 적립금 안내</div>
                                <div class="goods-review__info">
                                    <div class="goods-review__info-box">
                                        <div class="goods-review__info-img">
                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/goods_view_review_img01.png" alt="" />
                                        </div>
                                        <div class="goods-review__info-cont">
                                            <div class="goods-review__info-title">
                                                <div class="title-sm">포토 리뷰</div>
                                                <span class="price"><em>5,000</em>원</span>
                                            </div>
                                            <p class="txt-desc">착용컷과 50자 이상의 실사용 후기</p>
                                        </div>
                                    </div>
                                    <div class="goods-review__info-box">
                                        <div class="goods-review__info-img">
                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/goods_view_review_img02.png" alt="" />
                                        </div>
                                        <div class="goods-review__info-cont">
                                            <div class="goods-review__info-title">
                                                <div class="title-sm">텍스트 리뷰</div>
                                                <span class="price"><em>3,000</em>원</span>
                                            </div>
                                            <p class="txt-desc">50자 이상의 실사용 후기 작성</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="goods-review__footer">
                                    <div class="title-sm">매달 베스트 리뷰 선정</div>
                                    <p class="txt-desc">베스트 리뷰에 선정되시면, 등수에 따라 최대 <em>50,000</em>원의 적립금을 드립니다.</p>
                                    <button type="button" class="btn-lg btn-gray-line goods-review__btn" onclick="location.href='/customer/bestReview'">베스트 리뷰 보러가기</button>
                                </div>
                                <div class="goods-review__creama goods-review">

<?php if($TPL_VAR["langType"]=='korean'){?>
                                    <div class="goods-review__crema">
                                        <!-- 소셜 위젯 -->
                                        <style>.crema-product-reviews > iframe { max-width: 100% !important; }</style>
                                        <!--<div class="crema-product-reviews" data-widget-id="23" data-product-code="<?php echo (int) $TPL_VAR["id"];?>"></div>-->

                                        <!--<div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="25" class="crema-product-reviews"></div>-->
                                        <!-- 크리마 리뷰 서비스 영역 -->
                                        <!-- cre.ma / 상품 리뷰 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
                                        <div class="crema-product-reviews" data-product-code="<?php echo (int) $TPL_VAR["id"];?>"></div>
                                    </div>
									<!-- 2024-03-01 중복 부분으로 주석처리 -->
                                   <!-- <div class="goods-review__crema">-->
                                        <!-- 소셜 위젯 -->
                                        <!--<style>.crema-product-reviews > iframe { max-width: 100% !important; }</style>-->
                                        <!--<div class="crema-product-reviews" data-product-code="<?php echo (int) $TPL_VAR["id"];?>"></div>-->

                                        <!--<div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="25" class="crema-product-reviews"></div>-->
                                        <!-- 크리마 리뷰 서비스 영역 -->
                                        <!-- cre.ma / 상품 리뷰 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
                                        <!--<div class="crema-product-reviews" data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="17"></div>-->
                                    <!--</div>-->

<?php }else{?>
<?php if($TPL_VAR["mandatory_use_global"]=='Y'){?>
                                    <div class="goods-review__crema">
                                        <!-- 소셜 위젯 -->
                                        <style>.crema-product-reviews > iframe { max-width: 100% !important; }</style>
                                        <div class="crema-product-reviews" data-product-code="<?php echo (int) $TPL_VAR["id"];?>"></div>

                                        <!--<div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="25" class="crema-product-reviews"></div>-->
                                        <!-- 크리마 리뷰 서비스 영역 -->
                                        <!-- cre.ma / 상품 리뷰 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
                                        <div class="crema-product-reviews" data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="17"></div>
                                    </div>

<?php }?>
<?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="goods-tabs__content goods-detail" id="detail">
                    <div class="br__account active">
                        <button type="button" class="br__account__title active">
                            <span class="title-sm">상품정보</span>
                            <i class="ico ico-plus"></i>
                        </button>
                        <div class="br__account__content" id="goods-detail">
                            <div class="img-box"><?php echo $TPL_VAR["basicinfo"]?></div>
                        </div>
                    </div>
                </div>
                <div class="goods-tabs__content goods-detail--info" id="detail-info">
                    <div class="br__account active">
                        <button type="button" class="br__account__title active">
                            <span class="title-sm">상품정보 제공고시</span>
                            <i class="ico ico-plus"></i>
                        </button>
                        <div class="br__account__content">
                            <!-- 상품정보 제공고지 S -->
                            <div class="product-info">
<?php if($TPL_mandatoryInfos_1){foreach($TPL_VAR["mandatoryInfos"] as $TPL_V1){?>
                                <div class="product-info__item">
                                    <div class="product-info__title">
                                        <div class="title-sm"><?php echo $TPL_V1["pmi_title"]?></div>
                                    </div>
                                    <div class="product-info__desc">
                                        <p class="txt-desc"><?php echo $TPL_V1["pmi_desc"]?></p>
                                    </div>
                                </div>
<?php }}?>
                                <div class="product-info__item">
                                    <div class="product-info__title">
                                        <div class="title-sm">상품코드</div>
                                    </div>
                                    <div class="product-info__desc">
                                        <p class="txt-desc"><?php echo $TPL_VAR["pcode"]?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- 상품정보 제공고지 E -->
                        </div>
                    </div>
                </div>
                <div class="goods-tabs__content goods-size__guide" id="sizeGuide">
                    <div class="br__account active">
                        <button type="button" class="br__account__title active">
                            <span class="title-sm">사이즈 가이드</span>
                            <i class="ico ico-plus"></i>
                        </button>
                        <div class="br__account__content">
                            <section class="goods-tabs__cont br__goods-view__crema">
                                <a id="goods-fit" class="br__hidden--anchor">크리마 핏 가이드</a>
                                <!-- <h3 class="br__hidden">크리마 핏 가이드</h3> -->
                                <div class="goods-crema">
                                    <style>.crema-fit-product-combined-detail > iframe { max-width: 100% !important; }</style>
                                    <!--<div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-mvp="1" class="crema-fit-product-size-detail"></div>-->
                                    <div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="25" class="crema-fit-product-combined-detail"></div>
                                </div>
                            </section>

                            <style> /* css 파일에 추가해 주세요 */
                            .size_btn_box {padding:48px 0px 0 ; margin-top:48px; border-top:5px solid #E5E5E5; text-align:center; }
                            .size_txt {font-size:18px; color:#000; margin-bottom:32px; }
                            .size_btn {display: inline-block; width: 100%; background: #000; color: #fff; font-size: 16px; line-height: 48px; }

                            </style>
                        </div>
                    </div>
                </div>
                <div class="goods-tabs__content goods-washing" id="washing">
                    <div class="br__account no-effect">
                        <button type="button" class="br__account__title" onclick="DownLayerJSNew('layer-washing')">
                            <span class="title-sm">세탁 & 주의사항</span>
                            <i class="ico ico-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <div class="goods-tabs__content goods-return" id="return">
                    <div class="br__account no-effect">
                        <button type="button" class="br__account__title" onclick="DownLayerJSNew('layer-return')">
                            <span class="title-sm">반품 & 환불</span>
                            <i class="ico ico-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <div class="goods-tabs__content goods-delivery" id="delivery">
                    <div class="br__account no-effect">
                        <button type="button" class="br__account__title" onclick="DownLayerJSNew('layer-delivery')">
                            <span class="title-sm">배송안내</span>
                            <i class="ico ico-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <div class="goods-tabs__content goods-qna" id="qna">
                    <div class="br__account active">
                        <button type="button" class="br__account__title active">
                            <span class="title-sm">상품문의</span>
                            <i class="ico ico-plus"></i>
                        </button>


                        <div class="br__account__content">
                            <form id="devProductQnaForm">
                                <input type="hidden" name="id" value="<?php echo $TPL_VAR["pid"]?>" id="devQnaPid"/>
                                <input type="hidden" name="qnaType" value="all"/>
                                <input type="hidden" name="qnaDiv" value="all"/>
                                <input type="hidden" name="page" value="1" id="devQnaPage"/>
                                <input type="hidden" name="max" value="5" id="devQnaMax"/>
                            </form>
                            <div class="board-qna__wrap" id="devTabInquiry">
                                <ul class="board-qna__list" id="devQnaContents">
                                    <!-- 답변 완료일 경우 li class="board-qna__item" 에서 class="complete" 추가 -->
                                    <!-- 내가 쓴 글일 경우 li class="board-qna__item" 에서 class="board-qna__my" 추가 -->
                                    <li id="devQnaDetail" class="goods-qna__box board-qna__item {[#if isResponse]}complete{[/if]}  {[#if isHidden]} QnA-list__my {[/if]} active {[#if isSameUser]}{[else]}goods-qna__box--secret{[/if]}">
                                        <!-- 비밀글일 경우 div class="board-qna__title" 에서 class="lock" 추가 -->
                                        <div class="board-qna__title qna-info {[#if isHidden]} lock {[/if]}" data-isSameUser="{[isSameUser]}" data-isHidden="{[isHidden]}">
                                            <a href="javascript:void(0);" class="board-qna__link">
                                                <div class="board-qna__title-item">
                                                    <span class="writer">{[bbs_name]}</span>
                                                    <span class="status">{[#if isResponse]}답변완료{[else]}답변대기{[/if]}</span>
                                                </div>
                                                <div class="board-qna__title-item">
                                                    <span class="category">{[div_name]}</span>
                                                    <span class="subject">{[bbs_subject]}</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="board-qna__cont" id="">
                                            <div class="board-qna__Q" id="devQnaQuestion">
                                                <div class="board-qna__Q-cont">{[bbs_contents]}</div>
                                                <!-- 내 글 / 답변이 안 달렸을 경우 수정 가능한 영역 노출 S -->
                                                {[#if isResponse]}
                                                {[else]}
                                                {[#if isSameUser]}
                                                <div class="board-qna__Q-footer">
                                                    <a href="javascript:void(0);" class="btn-link" onclick="qnaEdit('{[bbs_ix]}', '<?php echo $TPL_VAR["pid"]?>');DownLayerJSNew('layer-qna');">수정</a>
                                                    <a href="javascript:void(0);" class="btn-link devDeleteQna" data-bbs_ix="{[bbs_ix]}">삭제</a>
                                                </div>
                                                {[/if]}
                                                {[/if]}
                                                <!-- 내 글 / 답변이 안 달렸을 경우 수정 가능한 영역 노출 E -->
                                            </div>
                                            <div class="board-qna__A" id="devQnaResponse">
                                                <div class="board-qna__A-title">
                                                    <span class="manager">BARREL 고객센터</span>
                                                    <span class="day">{[regdate]}</span>
                                                </div>
                                                <div class="board-qna__A-cont">
                                                    {[cmt_contents]}
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li id="devQnaEmpty" class="empty-content" style="text-align:center;">등록된 상품문의가 없습니다.</li>

                                    <li id="devQnaLoading" class="QnA-list__item empty-content">
                                        <div class="wrap-loading"><div class="loading"></div></div>
                                    </li>
                                </ul>


                                <div class="board-qna__btn">
                                    <div type="button" class="btn-lg btn-gray-line" id="devQnaPageWrap">상품문의 더보기</div>
                                    <button type="button" class="btn-lg btn-dark-line" data-pid="<?php echo $TPL_VAR["pid"]?>" onclick="DownLayerJSNew('layer-qna')">상품문의하기</button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </section>

        <!-- 연관 기획전 / 다른 고객님이 함께 구매한 상품 / 추천 상품 S -->
        <section class="br__goods-view__special">
<?php if($TPL_VAR["displayContentList"]){?>
            <div class="goods-special">
                <div class="goods-title">
                    <div class="title-md">연관 기획전</div>
                </div>
                <div class="goods-special__slide">
                    <div class="br-main__card-slider swiper-container card-slider">
                        <div class="swiper-wrapper">
<?php if($TPL_displayContentList_1){foreach($TPL_VAR["displayContentList"] as $TPL_V1){?>
                                <div class="swiper-slide">
                                    <div class="br-main__card-item">
                                        <div class="br-main__card-title--sm" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["preface"]?></div>
                                        <dl class="br-main__card-cont">
                                            <dt class="br-main__card-img">
                                                <a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
                                                    <img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="" />
                                                </a>
                                            </dt>
                                            <dd class="br-main__card-textBOX">
                                                <a href="<?php if($TPL_V1["display_gubun"]=='P'){?>/content/focusNow2/<?php }else{?>/content/focusNow4/<?php }?><?php echo $TPL_V1["con_ix"]?>">
                                                    <div class="br-main__card-title" style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_title"]?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
                                                        <?php echo $TPL_V1["title"]?>

                                                    </div>
                                                    <p style="color:<?php echo $TPL_V1["c_explanation"]?>;<?php if($TPL_V1["b_explanation"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_explanation"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_explanation"]=='Y'){?>text-decoration-line: underline;<?php }?>">
                                                        <?php echo $TPL_V1["explanation"]?>

                                                    </p>
<?php if($TPL_V1["display_date_use"]=="Y"){?>
                                                    <p class="br-main__card-day"><?php echo $TPL_V1["display_start"]?> ~ <?php echo $TPL_V1["display_end"]?></p>
<?php }?>
                                                </a>
                                                <!-- 버튼으로 할 경우 S -->
                                                <!-- 숨김처리 -->
                                                <button type="button" class="btn-wishlist <?php if($TPL_V1["alreadyWishContent"]=='Y'){?>active<?php }?>" onclick="contentWish('<?php echo $TPL_VAR["pid"]?>','<?php echo $TPL_V1["con_ix"]?>', 'C', this)">
                                                    <!-- 선택시 button class = active 추가-->
                                                    <i class="ico ico-wishlist"></i>위시리스트
                                                </button>
                                                <!-- 버튼으로 할 경우 E -->

                                                <!-- 체크 박스로 할 경우 S -->
                                                <label class="br-main__card-wish" style="display: none">
                                                    <input type="checkbox" class="br-main__card-wish--btn" />
                                                </label>
                                                <!-- 체크 박스로 할 경우 E -->
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
<?php }}?>
                        </div>
                        <div class="br-main__card-control">
                            <div class="swiper-control-group">
                                <div class="swiper-scrollbar"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php }?>
            <div class="goods-special__group">
                <div class="goods-special">
                    <div class="goods-title">
                        <div class="title-md">다른 고객님이 함께 구매한 상품</div>
                    </div>
                    <div class="goods-special__slide">
                        <div class="goods-list goods-list__slide swiper-container">
                            <ul class="goods-list__list swiper-wrapper">
<?php if($TPL_togeterProduct_1){foreach($TPL_VAR["togeterProduct"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='stop'){?>
                                <li class="goods-list__box swiper-slide">
                                    <div class="goods-list__thumb">
                                        <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="goods-list__link">
                                            <div class="goods-list__thumb-slide swiper-container">
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide">
                                                        <img src="<?php echo $TPL_V1["image_src"]?>" alt="" />
                                                    </div>
                                                    <!--<div class="swiper-slide">
                                                        <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                    </div>-->
                                                </div>
                                                <!--<div class="swiper-control-group">
                                                    <div class="swiper-scrollbar"></div>
                                                </div>-->
                                            </div>
                                        </a>
                                        <!-- 버튼으로 할 경우 S -->
                                        <!-- 숨김처리 -->
                                        <button type="button" class="btn-wishlist" style="display: none">
                                            <!-- 선택시 button class = active 추가-->
                                            <i class="ico ico-wishlist"></i>위시리스트
                                        </button>
                                        <!-- 버튼으로 할 경우 E -->

                                        <!-- 체크 박스로 할 경우 S -->
                                        <label class="goods-list__wish" data-devWishBtn="<?php echo $TPL_V1["id"]?>">
<?php if($TPL_V1["alreadyWish"]){?>
                                            <input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V1["id"]?>" onclick="productWish('<?php echo $TPL_V1["id"]?>')" checked />
<?php }else{?>
                                            <input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V1["id"]?>" onclick="productWish('<?php echo $TPL_V1["id"]?>')" />
<?php }?>
                                        </label>
                                        <!-- 체크 박스로 할 경우 E -->
                                    </div>
                                    <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="goods-list__link">
                                        <div class="goods-list__info">
                                            <div class="goods-list__pre br__goods__pre"><?php echo $TPL_V1["prefaceName"]?></div>
                                            <div class="goods-list__title"><?php echo $TPL_V1["pname"]?></div>
                                            <div class="goods-list__color"><?php echo $TPL_V1["add_info"]?></div>
                                            <div class="goods-list__price">
<?php if($TPL_V1["isDiscount"]){?>
                                                <div class="goods-list__price__percent"><span><?php echo $TPL_V1["discount_rate"]?></span>%</div>
<?php }?>
                                                <div class="goods-list__price__discount"><span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["dcprice"])?></span></div>
<?php if($TPL_V1["isDiscount"]){?>
                                                <div class="goods-list__price__cost"><del><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?></del></div>
<?php }?>
<?php if($TPL_V1["is_soldout"]){?>
                                                <!-- 품절일 경우 S -->
                                                <!-- 숨김 처리 -->
                                                <div class="goods-list__price__state">품절</div>
                                                <!-- 품절일 경우 E -->
<?php }?>
                                            </div>
                                        </div>
                                    </a>
                                </li>
<?php }else{?>
                                <!-- 상품이 없을 경우 S -->
                                <!-- 숨김처리 -->
                                <li class="goods-list__box no-data">
                                    <p class="empty-content">다른 고객님이 함께 구매한 상품이 없습니다</p>
                                </li>
                                <!-- 상품이 없을 경우 E -->
<?php }?>
<?php }}?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="goods-special">
                    <div class="goods-title">
                        <div class="title-md">추천 상품</div>
                    </div>
                    <div class="goods-special__slide">
                        <div class="goods-list goods-list__slide swiper-container">
                            <ul class="goods-list__list swiper-wrapper">
<?php if($TPL_similraProduct_1){foreach($TPL_VAR["similraProduct"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='stop'){?>
                                <li class="goods-list__box swiper-slide">
                                    <div class="goods-list__thumb">
                                        <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="goods-list__link">
                                            <div class="goods-list__thumb-slide swiper-container">
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide">
                                                        <img src="<?php echo $TPL_V1["image_src"]?>" alt="" />
                                                    </div>
                                                    <!--<div class="swiper-slide">
                                                        <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                    </div>-->
                                                </div>
                                                <!--<div class="swiper-control-group">
                                                    <div class="swiper-scrollbar"></div>
                                                </div>-->
                                            </div>
                                        </a>
                                        <!-- 버튼으로 할 경우 S -->
                                        <!-- 숨김처리 -->
                                        <button type="button" class="btn-wishlist" style="display: none">
                                            <!-- 선택시 button class = active 추가-->
                                            <i class="ico ico-wishlist"></i>위시리스트
                                        </button>
                                        <!-- 버튼으로 할 경우 E -->

                                        <!-- 체크 박스로 할 경우 S -->
                                        <label class="goods-list__wish" data-devWishBtn="<?php echo $TPL_V1["id"]?>">
<?php if($TPL_V1["alreadyWish"]){?>
                                            <input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V1["id"]?>" onclick="productWish('<?php echo $TPL_V1["id"]?>')" checked />
<?php }else{?>
                                            <input type="checkbox" class="goods-list__wish__btn" id="wishCheckBox_<?php echo $TPL_V1["id"]?>" onclick="productWish('<?php echo $TPL_V1["id"]?>')" />
<?php }?>
                                        </label>
                                        <!-- 체크 박스로 할 경우 E -->
                                    </div>
                                    <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="goods-list__link">
                                        <div class="goods-list__info">
                                            <div class="goods-list__pre br__goods__pre"><?php echo $TPL_V1["prefaceName"]?></div>
                                            <div class="goods-list__title"><?php echo $TPL_V1["pname"]?></div>
                                            <div class="goods-list__color"><?php echo $TPL_V1["add_info"]?></div>
                                            <div class="goods-list__price">
<?php if($TPL_V1["isDiscount"]){?>
                                                <div class="goods-list__price__percent"><span><?php echo $TPL_V1["discount_rate"]?></span>%</div>
<?php }?>
                                                <div class="goods-list__price__discount"><span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["dcprice"])?></span></div>
<?php if($TPL_V1["isDiscount"]){?>
                                                <div class="goods-list__price__cost"><del><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?></del></div>
<?php }?>
<?php if($TPL_V1["is_soldout"]){?>
                                                <!-- 품절일 경우 S -->
                                                <!-- 숨김 처리 -->
                                                <div class="goods-list__price__state">품절</div>
                                                <!-- 품절일 경우 E -->
<?php }?>
                                            </div>
                                        </div>
                                    </a>
                                </li>
<?php }else{?>
                                <!-- 상품이 없을 경우 S -->
                                <!-- 숨김처리 -->
                                <li class="goods-list__box no-data">
                                    <p class="empty-content">가장 인기있는 상품이 없습니다</p>
                                </li>
                                <!-- 상품이 없을 경우 E -->
<?php }?>
<?php }}?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- 연관 기획전 / 다른 고객님이 함께 구매한 상품 / 추천 상품  E -->
    </section>
    <!-- 컨텐츠 E -->
</section>

<!-- modal S -->
<!-- 알림 팝업 같은 경우에는 popup-mask 없이 사용 S -->
<!-- 구매 수량 초과시 노출되는 팝업 S -->
<div class="br__layer-alert">
    <div class="layer-alert">
        <p class="layer-alert__title">최대 구매수량을 초과하였습니다.</p>
        <div class="layer-alert__body">
            <p class="layer-alert__body__script">해당 상품은 구매수량 제한 상품으로 더 이상 구매하실 수 없습니다.</p>
        </div>
        <div class="layer-alert__btn-box">
            <button type="button" class="layer-alert__btn layer-alert__btn--submit">확인</button>
        </div>
    </div>
</div>
<!-- 구매 수량 초과시 노출되는 팝업 E -->

<!-- 회원전용 구매 알림 팝업 S -->
<div class="br__layer-alert">
    <div class="layer-alert">
        <p class="layer-alert__title">회원 전용 구매 상품입니다.</p>
        <div class="layer-alert__body">
            <p class="layer-alert__body__script">해당 상품은 회원 전용 상품으로 비회원은 구매하실 수 없습니다. 회원가입을 하시겠습니까?</p>
        </div>
        <div class="layer-alert__btn-box">
            <button type="button" class="layer-alert__btn layer-alert__btn--join">회원가입</button>
            <button type="button" class="layer-alert__btn layer-alert__btn--cancel">취소</button>
        </div>
    </div>
</div>
<!-- 회원전용 구매 알림 팝업 E -->
<!-- 알림 팝업 같은 경우에는 popup-mask 없이 사용 S -->

<div class="popup-mask-goods-view"></div>

<!-- 공유하기 S -->
<div class="popup-layout popup-layout__goods" id="layer-share">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">상품 공유 하기</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="popup-product">
                    <ul class="product-list">
                        <li class="product-list__item">
                            <dl class="product-list__group">
                                <dt class="product-list__group-left">
                                    <figure class="product-list__thumb">
<?php if($TPL_image_src_1){$TPL_I1=-1;foreach($TPL_VAR["image_src"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
                                            <img src="<?php echo $TPL_V1["basic_img"]?>" alt="" />
<?php }?>
<?php }}?>
                                    </figure>
                                </dt>
                                <dd class="product-list__group-right">
                                    <div class="product-list__info">
                                        <div class="product-list__info__title"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></div>

                                        <!--<div class="product-list__info__option">
                                            <div class="product-list__info__option-item">
                                                <span class="color">미드나잇</span>
                                                <span class="size">95</span>
                                                <span class="count"><em>1</em>개</span>
                                            </div>
                                        </div>-->

                                        <div class="product-list__info__price">
                                            <span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                        </div>
                                    </div>
                                </dd>
                            </dl>
                        </li>
                    </ul>
                </div>
                <div class="popup-sns__wrap">
                    <ul class="layer-share__list">
                        <!--<li class="layer-share__box">
                            <button type="button" class="layer-share__btn layer-share__btn&#45;&#45;instargram">
                                <i class="ico ico-instargram-BK"></i>
                            </button>
                        </li>-->
                        <li class="layer-share__box">
                            <button type="button" class="layer-share__btn layer-share__sns__btn--kakaotalk" devSnsShare="kakaotalk">
                                <i class="ico ico-kakao"></i>
                            </button>
                        </li>
                        <li class="layer-share__box">
                            <button type="button" class="layer-share__btn layer-share__sns__btn--facebook" devSnsShare="facebook">
                                <i class="ico ico-facebook"></i>
                            </button>
                        </li>
                        <li class="layer-share__box">
                            <button type="button" class="layer-share__btn layer-share__btn--url" devSnsShare="url-copy">URL</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 공유하기 E -->

<!-- 쿠폰 S -->
<div class="popup-layout popup-layout__goods devCouponContents" id="layer-coupon1">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">쿠폰 받기</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="layer-coupon__wrap">
                    <div class="coupon-wrap">
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
                                        <span class="count txt-red"><?php echo $TPL_V1["regist_count"]?>장 발급 가능</span>
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
                                <!--<a href="javascript:void(0);" class="btn-link" onclick="DownLayerJS('layer-coupon2')">적용대상 상품 보기</a>-->
                            </div>
<?php }}?>
<?php }}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-layout__footer">
            <!--<div class="btn-group">
                <button type="button" class="btn-lg btn-dark">쿠폰 전체 받기</button>
            </div>-->
        </div>
    </div>
</div>
<div class="popup-layout popup-layout__goods" id="layer-coupon2">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">쿠폰 적용대상</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="layer-coupon__wrap">
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
                    </div>
                    <!-- 쿠폰 적용 상품 리스트 S -->
                    <div class="popup-goods__wrap" style="display: none">
                        <!-- 상품 리스트 S -->
                        <div class="br__goods-list__wrap br__goods-list__wrap--normal">
                            <div class="goods-list">
                                <ul class="goods-list__list" id="devListContents">
                                    <!-- 로딩 S -->
                                    <!-- 숨김처리 -->
                                    <li id="devListLoading" class="br-loading" style="display: none">loading...</li>
                                    <!-- 로딩우 E -->

                                    <!-- 상품이 없을 경우 S -->
                                    <!-- 숨김처리 -->
                                    <li class="goods-list__box no-data" style="display: none">
                                        <p class="empty-content">검색어와 일치하는 상품이 없습니다.</p>
                                    </li>
                                    <!-- 상품이 없을 경우 E -->

                                    <li class="goods-list__box">
                                        <a href="javascript:void(0);" class="goods-list__link">
                                            <div class="goods-list__thumb">
                                                <div class="goods-list__thumb-slide swiper-container">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                    </div>
                                                    <div class="swiper-control-group">
                                                        <div class="swiper-scrollbar"></div>
                                                    </div>
                                                </div>
                                                <!-- 버튼으로 할 경우 S -->
                                                <!-- 숨김처리 -->
                                                <button type="button" class="btn-wishlist" style="display: none">
                                                    <!-- 선택시 button class = active 추가-->
                                                    <i class="ico ico-wishlist"></i>위시리스트
                                                </button>
                                                <!-- 버튼으로 할 경우 E -->

                                                <!-- 체크 박스로 할 경우 S -->
                                                <label class="goods-list__wish">
                                                    <input type="checkbox" class="goods-list__wish__btn" />
                                                </label>
                                                <!-- 체크 박스로 할 경우 E -->
                                            </div>
                                            <div class="goods-list__info">
                                                <div class="goods-list__pre br__goods__pre">친환경 소재</div>
                                                <div class="goods-list__title">우먼 리조트 하프 집업 크롭 리조트 래쉬가드 베스트</div>
                                                <div class="goods-list__color">아쿠아블루</div>
                                                <div class="goods-list__price">
                                                    <div class="goods-list__price__percent"><span>40</span>%</div>
                                                    <div class="goods-list__price__discount"><span>265,550</span></div>
                                                    <div class="goods-list__price__cost"><del>405,550</del></div>
                                                    <!-- 품절일 경우 S -->
                                                    <!-- 숨김 처리 -->
                                                    <div class="goods-list__price__state" style="display: none">품절</div>
                                                    <!-- 품절일 경우 E -->
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="goods-list__box">
                                        <a href="javascript:void(0);" class="goods-list__link">
                                            <div class="goods-list__thumb">
                                                <div class="goods-list__thumb-slide swiper-container">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                    </div>
                                                    <div class="swiper-control-group">
                                                        <div class="swiper-scrollbar"></div>
                                                    </div>
                                                </div>
                                                <!-- 버튼으로 할 경우 S -->
                                                <!-- 숨김처리 -->
                                                <button type="button" class="btn-wishlist" style="display: none">
                                                    <!-- 선택시 button class = active 추가-->
                                                    <i class="ico ico-wishlist"></i>위시리스트
                                                </button>
                                                <!-- 버튼으로 할 경우 E -->

                                                <!-- 체크 박스로 할 경우 S -->
                                                <label class="goods-list__wish">
                                                    <input type="checkbox" class="goods-list__wish__btn" />
                                                </label>
                                                <!-- 체크 박스로 할 경우 E -->
                                            </div>
                                            <div class="goods-list__info">
                                                <div class="goods-list__title">우먼 리조트 하프 집업 크롭 리조트 래쉬가드 베스트</div>
                                                <div class="goods-list__color">아쿠아블루</div>
                                                <div class="goods-list__price">
                                                    <div class="goods-list__price__percent"><span>40</span>%</div>
                                                    <div class="goods-list__price__discount"><span>265,550</span></div>
                                                    <div class="goods-list__price__cost"><del>405,550</del></div>
                                                    <!-- 품절일 경우 S -->
                                                    <!-- 숨김 처리 -->
                                                    <div class="goods-list__price__state" style="display: none">품절</div>
                                                    <!-- 품절일 경우 E -->
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="goods-list__box">
                                        <a href="javascript:void(0);" class="goods-list__link">
                                            <div class="goods-list__thumb">
                                                <div class="goods-list__thumb-slide swiper-container">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                    </div>
                                                    <div class="swiper-control-group">
                                                        <div class="swiper-scrollbar"></div>
                                                    </div>
                                                </div>
                                                <!-- 버튼으로 할 경우 S -->
                                                <!-- 숨김처리 -->
                                                <button type="button" class="btn-wishlist" style="display: none">
                                                    <!-- 선택시 button class = active 추가-->
                                                    <i class="ico ico-wishlist"></i>위시리스트
                                                </button>
                                                <!-- 버튼으로 할 경우 E -->

                                                <!-- 체크 박스로 할 경우 S -->
                                                <label class="goods-list__wish">
                                                    <input type="checkbox" class="goods-list__wish__btn" />
                                                </label>
                                                <!-- 체크 박스로 할 경우 E -->
                                            </div>
                                            <div class="goods-list__info">
                                                <div class="goods-list__title">우먼 리조트 하프 집업 크롭 리조트 래쉬가드 베스트</div>
                                                <div class="goods-list__color">아쿠아블루</div>
                                                <div class="goods-list__price">
                                                    <div class="goods-list__price__discount"><span>265,550</span></div>
                                                    <!-- 품절일 경우 S -->
                                                    <!-- 숨김 처리 -->
                                                    <div class="goods-list__price__state" style="display: none">품절</div>
                                                    <!-- 품절일 경우 E -->
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="goods-list__box">
                                        <a href="javascript:void(0);" class="goods-list__link">
                                            <div class="goods-list__thumb">
                                                <div class="goods-list__thumb-slide swiper-container">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                    </div>
                                                    <div class="swiper-control-group">
                                                        <div class="swiper-scrollbar"></div>
                                                    </div>
                                                </div>
                                                <!-- 버튼으로 할 경우 S -->
                                                <!-- 숨김처리 -->
                                                <button type="button" class="btn-wishlist" style="display: none">
                                                    <!-- 선택시 button class = active 추가-->
                                                    <i class="ico ico-wishlist"></i>위시리스트
                                                </button>
                                                <!-- 버튼으로 할 경우 E -->

                                                <!-- 체크 박스로 할 경우 S -->
                                                <label class="goods-list__wish">
                                                    <input type="checkbox" class="goods-list__wish__btn" />
                                                </label>
                                                <!-- 체크 박스로 할 경우 E -->
                                            </div>
                                            <div class="goods-list__info">
                                                <div class="goods-list__pre br__goods__pre">친환경 소재</div>
                                                <div class="goods-list__title">우먼 리조트 하프 집업 크롭 리조트 래쉬가드 베스트</div>
                                                <div class="goods-list__color">아쿠아블루</div>
                                                <div class="goods-list__price">
                                                    <div class="goods-list__price__discount"><span>265,550</span></div>
                                                    <!-- 품절일 경우 S -->
                                                    <!-- 숨김 처리 -->
                                                    <div class="goods-list__price__state" style="display: none">품절</div>
                                                    <!-- 품절일 경우 E -->
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="goods-list__box">
                                        <a href="javascript:void(0);" class="goods-list__link">
                                            <div class="goods-list__thumb">
                                                <div class="goods-list__thumb-slide swiper-container">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                    </div>
                                                    <div class="swiper-control-group">
                                                        <div class="swiper-scrollbar"></div>
                                                    </div>
                                                </div>
                                                <!-- 버튼으로 할 경우 S -->
                                                <!-- 숨김처리 -->
                                                <button type="button" class="btn-wishlist" style="display: none">
                                                    <!-- 선택시 button class = active 추가-->
                                                    <i class="ico ico-wishlist"></i>위시리스트
                                                </button>
                                                <!-- 버튼으로 할 경우 E -->

                                                <!-- 체크 박스로 할 경우 S -->
                                                <label class="goods-list__wish">
                                                    <input type="checkbox" class="goods-list__wish__btn" />
                                                </label>
                                                <!-- 체크 박스로 할 경우 E -->
                                            </div>
                                            <div class="goods-list__info">
                                                <div class="goods-list__pre br__goods__pre">친환경 소재</div>
                                                <div class="goods-list__title">우먼 리조트 하프 집업 크롭 리조트 래쉬가드 베스트</div>
                                                <div class="goods-list__color">아쿠아블루</div>
                                                <div class="goods-list__price">
                                                    <!-- 품절일 경우 S -->
                                                    <div class="goods-list__price__state">품절</div>
                                                    <!-- 품절일 경우 E -->
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="goods-list__box">
                                        <a href="javascript:void(0);" class="goods-list__link">
                                            <div class="goods-list__thumb">
                                                <div class="goods-list__thumb-slide swiper-container">
                                                    <div class="swiper-wrapper">
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                        <div class="swiper-slide">
                                                            <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                                        </div>
                                                    </div>
                                                    <div class="swiper-control-group">
                                                        <div class="swiper-scrollbar"></div>
                                                    </div>
                                                </div>
                                                <!-- 버튼으로 할 경우 S -->
                                                <!-- 숨김처리 -->
                                                <button type="button" class="btn-wishlist" style="display: none">
                                                    <!-- 선택시 button class = active 추가-->
                                                    <i class="ico ico-wishlist"></i>위시리스트
                                                </button>
                                                <!-- 버튼으로 할 경우 E -->

                                                <!-- 체크 박스로 할 경우 S -->
                                                <label class="goods-list__wish">
                                                    <input type="checkbox" class="goods-list__wish__btn" />
                                                </label>
                                                <!-- 체크 박스로 할 경우 E -->
                                            </div>
                                            <div class="goods-list__info">
                                                <div class="goods-list__title">우먼 리조트 하프 집업 크롭 리조트 래쉬가드 베스트</div>
                                                <div class="goods-list__color">아쿠아블루</div>
                                                <div class="goods-list__price">
                                                    <!-- 품절일 경우 S -->
                                                    <div class="goods-list__price__state">판매예정</div>
                                                    <!-- 품절일 경우 E -->
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- 상품 리스트 E -->
                    </div>
                    <!-- 쿠폰 적용 상품 리스트 E -->
                </div>
            </div>
        </div>
        <div class="popup-layout__footer">
            <div class="btn-group">
                <button type="button" class="btn-lg btn-dark-line">확인</button>
            </div>
        </div>
    </div>
</div>
<!-- 쿠폰 E -->

<!-- 혜택 내역 S -->
<div class="popup-layout popup-layout__goods" id="layer-benefitList">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">혜택 내역</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="benefits-payment">
                    <div class="benefits-payment__list">
                        <dl class="benefits-payment__box">
                            <dt>할인가</dt>
                            <dd>-<em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["directDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["directDiscountPrice"])?><?php }else{?>0<?php }?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="benefits-payment__box">
                            <dt>기획 할인</dt>
                            <dd>-<em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["planDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["planDiscountPrice"])?><?php }else{?>0<?php }?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="benefits-payment__box">
                            <dt>추가 할인</dt>
                            <dd>-<em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["addDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["addDiscountPrice"])?><?php }else{?>0<?php }?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="benefits-payment__box">
                            <dt>쿠폰 할인</dt>
                            <dd>-<em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["couponDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["couponDiscountPrice"])?><?php }else{?>0<?php }?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <dl class="benefits-payment__box">
                            <dt>회원 등급 할인</dt>
                            <dd>-<em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["groupDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["groupDiscountPrice"])?><?php }else{?>0<?php }?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                    </div>
                    <dl class="benefits-payment__total">
                        <dt>최대 혜택가</dt>
                        <dd>
                            <div class="percent"><em><?php echo $TPL_VAR["totalDiscountRate"]?></em>%</div>
                            <div class="price"><em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["couponApplyPrice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="popup-layout__footer">
            <div class="btn-group">
                <button type="button" class="btn-lg btn-dark-line btn-close">확인</button>
            </div>
        </div>
    </div>
</div>
<!-- 혜택 내역 E -->

<!-- 재입고 알림 신청 팝업 S -->
<div class="popup-layout popup-layout__goods" id="layer-restock1">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">재입고 알림 신청</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="restock-wrap">
                    <div class="txt-desc">
                        <p>품절된 상품이 재입고되는 즉시 등록하신 휴대폰 번호로 재입고 알림 문자를 보내드립니다.</p>
                    </div>
                    <div class="popup-product">
                        <ul class="product-list">
                            <li class="product-list__item">
                                <dl class="product-list__group">
                                    <dt class="product-list__group-left">
                                        <figure class="product-list__thumb">
<?php if($TPL_image_src_1){$TPL_I1=-1;foreach($TPL_VAR["image_src"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
                                                <img src="<?php echo $TPL_V1["basic_img"]?>" alt="" />
<?php }?>
<?php }}?>
                                        </figure>
                                    </dt>
                                    <dd class="product-list__group-right">
                                        <div class="product-list__info">
                                            <div class="product-list__info__title"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></div>

                                            <div class="product-list__info__option">
                                                <div class="product-list__info__option-item">
                                                    <span class="color"><?php echo $TPL_VAR["add_info"]?></span>
                                                </div>
                                            </div>

                                            <div class="product-list__info__price">
                                                <span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                            </div>
                                            <div class="product-list__select">
                                                <div class="br__form-item">
                                                    <label class="hidden">사이즈 선택</label>
                                                    <select class="br__form-select" name="option_id" id="option_id">
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
                                    </dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                    <div class="restock-phone">
                        <div class="br__form-item">
                            <label for="Phone" class="br__form-label hidden">신청 휴대폰 번호</label>
                            <select class="br__form-select" name="pcs1" id="devPcs1" disabled>
                                <option value="010" <?php if($TPL_VAR["pcs1"]=='010'){?>selected<?php }?>>010</option>
                                <option value="011" <?php if($TPL_VAR["pcs1"]=='011'){?>selected<?php }?>>011</option>
                                <option value="016" <?php if($TPL_VAR["pcs1"]=='016'){?>selected<?php }?>>016</option>
                                <option value="017" <?php if($TPL_VAR["pcs1"]=='017'){?>selected<?php }?>>017</option>
                                <option value="018" <?php if($TPL_VAR["pcs1"]=='018'){?>selected<?php }?>>018</option>
                                <option value="019" <?php if($TPL_VAR["pcs1"]=='019'){?>selected<?php }?>>019</option>
                            </select>
                            <input type="text" placeholder="0000" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["pcs2"]?>" class="br__form-input" disabled />
                            <input type="text" placeholder="0000" name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["pcs3"]?>" class="br__form-input" disabled />
                        </div>
                    </div>
                    <div class="restock-checkbox">
                        <!-- 체크 박스 S -->
                        <div class="br__form-item">
                            <input type="checkbox" class="br__form-checkbox" name="change_pcs" id="devChangePcs" value="Y" />
                            <label for="PhoneChange">휴대번 번호 변경</label>
                        </div>
                        <!-- 체크 박스 E -->
                        <div class="restock-checkbox__desc">
                            <p>SMS 요청이 완료된 상품은 재입고 알림 목록으로 저장됩니다.</p>
                            <p>SMS 요청상품의 가격, 옵션 구성 등의 상품정보가 변동될 수 있으므로, 재입고 시 상품정보 확인 후 구매하시기 바랍니다.</p>
                            <p>재입고 SMS알림은 요청일로부터 15일간 유효합니다.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-layout__footer">
            <div class="btn-group">
                <button type="button" class="btn-lg btn-dark-line" id="devSubmitBtnLayer">재입고 알림 신청하기</button>
            </div>
        </div>
    </div>
</div>
<div class="popup-layout popup-layout__goods" id="layer-restock2">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">재입고 알림 신청이 완료되었습니다.</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="restock-wrap">
                    <div class="txt-desc">
                        <p>품절된 상품이 재입고되는 즉시 등록하신 휴대폰 번호로 재입고 알림 문자를 보내드립니다.</p>
                    </div>
                    <div class="popup-product">
                        <ul class="product-list">
                            <li class="product-list__item">
                                <dl class="product-list__group">
                                    <dt class="product-list__group-left">
                                        <figure class="product-list__thumb">
                                            <a href="javascript:void(0);">
                                                <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
                                            </a>
                                        </figure>
                                    </dt>
                                    <dd class="product-list__group-right">
                                        <div class="product-list__info">
                                            <div class="product-list__info__title">우먼 피쉬백 스트랩 스윔 브라탑</div>

                                            <div class="product-list__info__option">
                                                <div class="product-list__info__option-item">
                                                    <span class="color">미드나잇</span>
                                                </div>
                                            </div>

                                            <div class="product-list__info__price">
                                                <span class="product-list__info__price--cost"><em>1,265,550</em>원</span>
                                            </div>
                                            <div class="product-list__select">
                                                <div class="br__form-item">
                                                    <label class="hidden">사이즈 옵션</label>
                                                    <select class="br__form-select" disabled>
                                                        <option>95</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                    <div class="restock-phone">
                        <div class="br__form-item">
                            <label for="Phone" class="br__form-label">신청 휴대폰 번호</label>
                            <select class="br__form-select" id="Phone" disabled>
                                <option>010</option>
                            </select>
                            <input type="text" placeholder="0000" value="1234" class="br__form-input" disabled />
                            <input type="text" placeholder="0000" value="1234" class="br__form-input" disabled />
                        </div>
                    </div>
                    <div class="restock-checkbox">
                        <!-- 체크 박스 S -->
                        <!-- 숨김 처리 -->
                        <div class="br__form-item" style="display: none">
                            <input type="checkbox" class="br__form-checkbox" id="PhoneChange" checked />
                            <label for="PhoneChange">휴대번 번호 변경</label>
                        </div>
                        <!-- 체크 박스 E -->
                        <div class="restock-checkbox__desc">
                            <p>SMS 요청이 완료된 상품은 재입고 알림 목록으로 저장됩니다.</p>
                            <p>SMS 요청상품의 가격, 옵션 구성 등의 상품정보가 변동될 수 있으므로, 재입고 시 상품정보 확인 후 구매하시기 바랍니다.</p>
                            <p>재입고 SMS알림은 요청일로부터 15일간 유효합니다.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-layout__footer">
            <div class="btn-group">
                <button type="button" class="btn-lg btn-dark-line">닫기</button>
            </div>
        </div>
    </div>
</div>
<!-- 재입고 알림 신청 팝업 E -->

<!-- 사이즈 가이드 팝업 S -->
<div class="popup-layout popup-layout__full" id="layer-sizeGuide">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">신체 사이즈 가이드</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="sizeGuide-wrap">
                    <div class="br-slider__tab" >
                        <div class="br-tab__slide swiper-container">
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
                        <div class="br-slider__tab-contents">
                            <div class="br-slider__contents">
                                <div class="br-tab__wrap">
                                    <div class="br-tab__nav">
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
                                    <div class="br-tab__contents-wrap">
                                        <div class="br-tab__contents active">
                                            <div class="img-box">
                                                <img src="/assets/templet/enterprise/assets/img/size/size_rashguard_women_.jpg" alt="" />
                                            </div>
                                        </div>
                                        <div class="br-tab__contents">
                                            <div class="img-box">
                                                <img src="/assets/templet/enterprise/assets/img/size/size_rashguard_men.jpg" alt="" />
                                            </div>
                                        </div>
                                        <div class="br-tab__contents">
                                            <div class="img-box">
                                                <img src="/assets/templet/enterprise/assets/img/size/size_rashguard_kids.jpg" alt="" />
                                            </div>
                                        </div>
                                        <div class="br-tab__contents">
                                            <div class="img-box">
                                                <img src="/assets/templet/enterprise/assets/img/size/size_rashguard_toddler.jpg" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="br-slider__contents">
                                <div class="br-tab__wrap br-tab__col">
                                    <div class="br-tab__nav">
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
                                    <div class="br-tab__contents-wrap">
                                        <div class="br-tab__contents active">
                                            <div class="img-box">
                                                <img src="/assets/templet/enterprise/assets/img/size/size_rashguard_women_.jpg" alt="" />
                                            </div>
                                        </div>
                                        <div class="br-tab__contents">
                                            <div class="img-box">
                                                <img src="/assets/templet/enterprise/assets/img/size/size_rashguard_men.jpg" alt="" />
                                            </div>
                                        </div>
                                        <div class="br-tab__contents">
                                            <div class="img-box">
                                                <img src="/assets/templet/enterprise/assets/img/size/size_rashguard_kids.jpg" alt="" />
                                            </div>
                                        </div>
                                        <div class="br-tab__contents">
                                            <div class="img-box">
                                                <img src="/assets/templet/enterprise/assets/img/size/size_rashguard_toddler.jpg" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="br-slider__contents">
                                <div class="br-tab__wrap br-tab__col">
                                    <div class="br-tab__nav">
                                        <ul>
                                            <li class="active">
                                                <a href="javascript:void(0);">우먼</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">맨</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="br-tab__contents-wrap">
                                        <div class="br-tab__contents active">
                                            <div class="img-box">
                                                <img src="/assets/templet/enterprise/assets/img/size/size_rashguard_women_.jpg" alt="" />
                                            </div>
                                        </div>
                                        <div class="br-tab__contents">
                                            <div class="img-box">
                                                <img src="/assets/templet/enterprise/assets/img/size/size_rashguard_men.jpg" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="br-slider__contents">
                                <div class="br-tab__wrap br-tab__col">
                                    <div class="br-tab__nav">
                                        <ul>
                                            <li class="active">
                                                <a href="javascript:void(0);">우먼</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="br-tab__contents-wrap">
                                        <div class="br-tab__contents active">
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
<!-- 사이즈 가이드 팝업 E -->
<script>
$(document).ready(function () {
	$(".br-slider__tab .swiper-slide").each(function () {
		$(this).on("click", function () {
			var tabIex = $(this).index();
			$(".br-slider__tab .swiper-slide").removeClass("active");
			$(this).addClass("active");
			console.log(this);
			$(".br-slider__tab-contents").find(".br-slider__contents").hide();
			$(".br-slider__tab-contents").find(".br-slider__contents").eq(tabIex).show();
		});
	});
});
</script>
<!-- 장바구니 안내 팝업 S -->
<div class="popup-layout popup-layout__goods" id="layer-cart">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">장바구니에 상품을 담았습니다.</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content"></div>
        </div>
        <div class="popup-layout__footer">
            <div class="btn-group col">
                <button type="button" class="btn-lg btn-dark-line" onclick="cartPopClose(2);">장바구니 보러가기</button>
                <button type="button" class="btn-lg btn-dark" onclick="cartPopClose(1);">쇼핑 계속하기</button>
            </div>
        </div>
    </div>
</div>
<!-- 장바구니 안내 팝업 E -->

<!-- 구매 오더 팝업 S -->
<div class="popup-layout popup-layout__goods popup-layout__order" id="layer-order">
    <div class="popup-layout__wrap" id="devMinicartArea" data-pid="<?php echo $TPL_VAR["pid"]?>">
        <div class="popup-title">
            <h4 class="hidden">구매 옵션 레이어</h4>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="layer-order__wrap">
                    <section class="br__goods-view__option">
                        <div class="goods-info">
                            <!-- 색상 옵션 S -->
<?php if($TPL_VAR["product_type"]== 0&&$TPL_VAR["add_info"]!=''){?>
                            <div class="goods-info__option goods-info__color">
                                <div class="goods-info__option-title">
                                    <div class="title-sm">색상</div>
                                    <div class="goods-info__option-value"><?php echo $TPL_VAR["add_info"]?></div>
                                </div>
                                <div class="goods-info__option-cont">
                                    <div class="goods-info__option-slide swiper-container swiper-initialized swiper-horizontal swiper-ios swiper-backface-hidden">
<?php if($TPL_VAR["sameProduct"]){?>
                                        <ul class="goods-info__color__list swiper-wrapper" id="swiper-wrapper-35b7671cc177097c" aria-live="polite">
<?php if($TPL_sameProduct_1){foreach($TPL_VAR["sameProduct"] as $TPL_V1){?>
                                            <li class="goods-info__color__item swiper-slide swiper-slide-active" role="group" style="margin-right: 5px">
                                                <a href="/shop/goodsView/<?php echo $TPL_V1["pid"]?>" class="goods-info__color__link <?php if($TPL_VAR["pid"]==$TPL_V1["pid"]){?>goods-info__color__link--active<?php }?>">
<?php if($TPL_V1["pattImg"]==''){?>
                                                    <img src="<?php echo $TPL_V1["filterImg"]?>" alt="색상명" />
<?php }else{?>
                                                    <img src="<?php echo $TPL_V1["pattImg"]?>" alt="패턴명" />
<?php }?>
                                                </a>
                                            </li>
<?php }}?>
                                        </ul>
<?php }?>
                                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                                    </div>
                                </div>
                            </div>
<?php }?>
                            <!-- 색상 옵션 E -->

                            <!-- 사이즈 옵션 S -->
                            <div class="goods-info__option goods-info__size">
                                <div class="devForbizTpl" id="devLonelyOption">
                                    <span id="devLonelyOptionName">
                                        <p>{[option_name]}</p>
                                    </span>
                                </div>


                                <div class="goods-info__option-cont" id="devMinicartOptions"></div>
                            </div>
                            <!-- 사이즈 옵션 E -->

                            <!-- 세트 상품 옵션 S -->
                            <div class="goods-info__set-group">
                                <div class="goods-info__option goods-info__set" id="">
                                    <!--<div class="goods-info__option-title">
                                        <div class="title-sm">트랙 자켓</div>
                                    </div>
                                    <div class="goods-info__option-cont">
                                        <ul class="goods-info__set__list">
                                            <li class="goods-info__set__item">
                                                <select class="br__form-select">
                                                    <option>색상 [필수]</option>
                                                </select>
                                            </li>
                                            <li class="goods-info__set__item">
                                                <select class="br__form-select" disabled="">
                                                    <option>사이즈 [필수]</option>
                                                </select>
                                            </li>
                                        </ul>
                                    </div>-->
                                </div>
                                <!--<div class="goods-info__option goods-info__set">
                                    <div class="goods-info__option-title">
                                        <div class="title-sm">트랙 팬츠</div>
                                    </div>
                                    <div class="goods-info__option-cont">
                                        <ul class="goods-info__set__list">
                                            <li class="goods-info__set__item">
                                                <select class="br__form-select">
                                                    <option>색상 [필수]</option>
                                                </select>
                                            </li>
                                            <li class="goods-info__set__item">
                                                <select class="br__form-select" disabled="">
                                                    <option>사이즈 [필수]</option>
                                                </select>
                                            </li>
                                        </ul>
                                    </div>
                                </div>-->
                            </div>
                            <!-- 세트 상품 옵션 E -->

                            <!-- 신체 사이즈 가이드 S -->
                            <div class="goods-info__size__guide">
                                <button type="button" class="goods-info__size__guide-btn" onclick="DownLayerJSNew('layer-sizeGuide')">신체 사이즈 가이드</button>
                            </div>
                            <!-- 신체 사이즈 가이드 E -->

                   
                            <div id="devMinicartAddOption" class="goods-info__toggle goods-info__addition active">
                                <div class="goods-info__toggle-title">
                                    <button type="button" class="goods-info__toggle-title--btn">
                                        <span class="title-sm">추가 옵션 상품</span>
                                        <i class="ico ico-plus"></i>
                                    </button>
                                </div>
                                <div class="goods-info__toggle-cont" style="display: block">
                                    <div class="product-list">
                                    </div>
                                </div>
                            </div>


                            <!-- 사은품 상품 S -->
<?php if($TPL_VAR["product_gift"]){?>
                            <div class="goods-info__toggle goods-info__gifts">
                                <div class="goods-info__toggle-title">
                                    <button type="button" class="goods-info__toggle-title--btn">
                                        <span class="title-sm">사은품</span>
                                        <i class="ico ico-plus"></i>
                                    </button>
                                </div>
                                <div class="goods-info__toggle-cont">
                                    <div class="product-list">
                                        <ul class="product-list__wrap">
                                            <li class="product-list__item">
                                                <dl class="product-list__group">
                                                    <dt class="product-list__group-left">
                                                        <figure class="product-list__thumb">
                                                            <img id="giftImg" src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_freebie_sel_mo.png" alt="" />
                                                        </figure>
                                                    </dt>
                                                    <dd class="product-list__group-right">
                                                        <div class="product-list__info">
<?php if($TPL_product_gift_1){$TPL_I1=-1;foreach($TPL_VAR["product_gift"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1<$TPL_VAR["gift_selectbox_cnt"]){?>
                                                            <div class="product-list__select">
                                                                <select class="fb__form-select devProductGift_<?php echo $TPL_I1?> devGiftSelect" data-idx="<?php echo $TPL_I1?>" onchange="giftImgChange(this.value)">
                                                                    <option value="">사은품 선택 안함</option>
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
                                                                <input type="hidden" name="giftImg" id="giftImg_0000055421" value="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_no-freebie_mo.png">
<?php }?>
                                                                <input type="hidden" name="giftImg" id="giftImg_" value="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_freebie_sel_mo.png">
                                                            </div>
<?php }?>
<?php }}?>
                                                        </div>
                                                    </dd>
                                                </dl>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
<?php }?>
                            <!-- 사은품 상품 E -->

                            <!-- 배송혜택 안내 S -->
                            <div class="goods-info__delivery">
                                <div class="goods-info__delivery-title">배송혜택</div>
                                <div class="goods-info__delivery-desc">
                                    30,000원 이상 구매 시 무료배송.<br />
                                    (도서산간 및 제주 3,000원 추가)
                                </div>
                            </div>
                            <!-- 배송혜택 안내 E -->

                            <!-- 선택된 상품 리스트 S -->
                            <div class="goods-cart__wrap">
                                <ul class="goods-cart" id="devMinicartSelected">
                                    <li class="goods-cart__box devForbizTpl devOptionBox" devPid="{[pid]}" devOptionKind="{[option_kind]}" devOptid="{[option_id]}" devUnit="{[option_dcprice]}" devStock="{[option_stock]}">
                                        <div class="goods-cart__title">
                                            <div class="title-sm">{[option_prefix]}{[pname]}</div>
                                            <button type="button" class="btn-option-del devMinicartDelete">삭제</button>
                                        </div>
                                        <div class="goods-cart__cont">
                                            <div class="goods-cart__sub">
                                                <div class="goods-cart__sub-item">
                                                    <span class="color">{[add_info_text]}</span>
                                                    <span class="size">{[option_div_text]}</span>
                                                    <span class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em class="devMinicartEachPrice">{[eachPrice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                                </div>
                                            </div>
                                            <div class="control">
                                                <ul class="control-box option-up-down devControlCntBox">
                                                    <li class="devCntMinus"><button type="button" class="down devCountDownButton"></button></li>
                                                    <li><input type="text" value="{[allowBasicCnt]}" class="br__form-input devCount option-text devMinicartPrdCnt" /></li>
                                                    <li class="devCntPlus"><button type="button" class="up devCountUpButton"></button></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- 선택된 상품 리스트 E -->
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="popup-layout__footer">
            <div class="goods-view__total">
                <dt>총 상품 금액</dt>
                <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devMinicartTotal">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
            </div>
            <div class="btn-group">
                <button type="button" class="btn-lg btn-dark-line goods-btn__cart devAddCart_ig devAddCart__layerBtn">장바구니</button>
                <button type="button" class="btn-lg btn-dark devOrderDirect">구매하기</button>
            </div>
        </div>
    </div>
</div>
<!-- 구매 오더 팝업 E -->

<!-- 매장 안내 팝업 S -->
<div class="popup-layout popup-layout__goods" id="layer-store">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">구매가능 매장안내</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="store-wrap">
                    <p class="txt-error">매장에 따라 실시간으로 재고 상황이 바뀔 수 있으므로, 방문 전 해당 매장에 문의하시기 바랍니다.</p>
                    <div class="popup-product">
                        <ul class="product-list">
                            <li class="product-list__item">
                                <dl class="product-list__group">
                                    <dt class="product-list__group-left">
                                        <figure class="product-list__thumb">
<?php if($TPL_image_src_1){$TPL_I1=-1;foreach($TPL_VAR["image_src"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
                                                <img src="<?php echo $TPL_V1["basic_img"]?>" alt="" />
<?php }?>
<?php }}?>
                                        </figure>
                                    </dt>
                                    <dd class="product-list__group-right">
                                        <div class="product-list__info">
                                            <div class="product-list__info__title"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></div>

                                            <div class="product-list__info__option">
                                                <div class="product-list__info__option-item">
                                                    <span class="color"><?php echo $TPL_VAR["add_info"]?></span>
                                                </div>
                                            </div>

                                            <div class="product-list__info__price">
                                                <span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                            </div>
                                            <div class="product-list__select">
<?php if(count($TPL_VAR["style"])> 1){?>
                                                <div class="br__form-item">
                                                    <label class="hidden">사이즈 옵션</label>
                                                    <select class="br__form-select" name="style" id="devStyleSelect">
<?php if($TPL_style_1){foreach($TPL_VAR["style"] as $TPL_V1){?>
                                                        <option value="<?php echo $TPL_V1["style"]?><?php echo $TPL_V1["color"]?>"><?php echo $TPL_V1["gname"]?></option>
<?php }}?>
                                                    </select>
                                                </div>
<?php }?>
<?php if(!empty($TPL_VAR["option"])){?>
                                                <div class="br__form-item">
                                                    <label class="hidden">사이즈 옵션</label>
                                                    <select class="br__form-select" name="option" id="devOptionSelect">
<?php if($TPL_option_1){foreach($TPL_VAR["option"] as $TPL_V1){?>
                                                        <option value="<?php echo $TPL_V1["option_gid"]?>"><?php echo $TPL_V1["option_div"]?></option>
<?php }}?>
                                                    </select>
                                                </div>
<?php }?>
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                            </li>
                        </ul>
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
        <div class="popup-layout__footer">
            <div class="btn-group">
                <button type="button" class="btn-lg btn-dark-line" onclick="storeSch()">매장 검색</button>
            </div>
        </div>
    </div>
</div>
<!-- 매장 안내 팝업 E -->

<!-- 세탁&주의사항 안내 팝업 S -->
<div class="popup-layout popup-layout__goods" id="layer-washing">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">세탁 & 주의사항</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap" id="laundryInfo">
            <div class="popup-content">
                <div class="wash">
                    <div class="wash__select">
                        <div class="wash__select-item">
                            <div class="br__form-item">
                                <label for="" class="hidden">카테고리 선택</label>
                                <select class="br__form-select" onchange="laundryChange(this.value)">
<?php if($TPL_laundryOneDepth_1){foreach($TPL_VAR["laundryOneDepth"] as $TPL_V1){?>
<?php if($TPL_VAR["langType"]=='english'){?>
                                        <option value="<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryCid"]==$TPL_V1["cid"]){?>selected<?php }?>><?php echo $TPL_V1["title_en"]?></option>
<?php }else{?>
                                        <option value="<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryCid"]==$TPL_V1["cid"]){?>selected<?php }?>><?php echo $TPL_V1["title"]?></option>
<?php }?>
<?php }}?>
                                </select>
                            </div>
                        </div>
                        <div class="wash__select-item">
                            <div class="br__form-item">
                                <label for="" class="hidden">상세 아이템 선택</label>
                                <select class="br__form-select" onchange="laundryTwoChange(this.value)">
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
                    </div>
                    <div class="wash__contents">
                        <!-- 카테고리 결과 값 S -->
                        <section class="wash__contents__category wash__contents__category--show">
                            <div class="br-tab__wrap">
                                <div class="br-tab__nav">
                                    <ul>
                                        <li class="active">
                                            <a href="javascript:void(0);">세탁방법</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);">보관 및 주의사항</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="br-tab__contents-wrap">
                                    <div class="br-tab__contents active">
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
                                        <div class="contents__list" id="oneLaundry-<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_I2== 0){?>
<?php if(is_array($TPL_R3=$TPL_V2["four"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                                            <dl class="contents__item">
                                                <dt class="contents__item-img">
                                                    <img src="/assets/mobile_templet/mobile_enterprise/assets/img/img_product_precautions<?php echo $TPL_V3["imgCnt"]?>.png" alt="<?php echo $TPL_V3["title"]?>" />
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
                                    <div class="br-tab__contents">
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
                                        <div class="contents__list" id="twoLaundry-<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){$TPL_I2=-1;foreach($TPL_R2 as $TPL_V2){$TPL_I2++;?>
<?php if($TPL_I2== 1){?>
<?php if(is_array($TPL_R3=$TPL_V2["four"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                                            <dl class="contents__item">
                                                <dt class="contents__item-img">
                                                    <img src="/assets/mobile_templet/mobile_enterprise/assets/img/img_product_precautions04.svg" alt="미끄럼틀 금지" />
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
                        </section>
                        <!-- 카테고리 결과 값 E -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 세탁&주의사항 안내 팝업 E -->

<!-- 반품&환불 안내 팝업 S -->
<div class="popup-layout popup-layout__goods" id="layer-return">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">반품 & 환불 안내</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="claim">
                    <div class="claim__wrap">
                        <dl class="claim__item">
                            <dt class="claim__title-wrap">
                                <a href="javascript:void(0);" class="claim__link">
                                    <h3 class="claim__category">반품 / 환불</h3>
                                    <i class="ico ico-plus"></i>
                                </a>
                            </dt>
                            <dd class="claim__info-wrap">
                                <ul class="claim__info">
                                    <li class="claim__infoList">
                                        배럴 공식 홈페이지를 통해 구매하신 상품은 사이즈 및 색상 또는 다른 상품으로 교환되지 않습니다.<br />
                                        구매하신 상품을 반품하신 후 구매를 원하시는 다른 상품이나 사이즈, 색상으로 재구매해 주시기 바랍니다.<br />
                                        (유의사항 : 이벤트 기간에 주문하신 상품은 이벤트 기간 종료 후 재구매 시 할인 적용 및 사은품 지급이 되지 않으니, 반품을 신청하신 고객님께서는 이벤트 기간 내 재구매를 하셔야 혜택을 받으실 수 있습니다.)
                                    </li>
                                    <li class="claim__infoList">단순 변심에 의한 반품 시 반품하실 상품을 제외한 실결제 금액이 3만원 이상일 경우 2,500원, 3만원 미만일 경우 5,000원이 반품하신 상품의 결제한 금액에서 차감 후 환불이 진행됩니다.</li>
                                    <li class="claim__infoList">반품은 상품 수령 후 7일 이내에 접수 가능합니다.</li>
                                    <li class="claim__infoList">도서산간지역에서 반품을 신청한 경우 지역별로 도선료가 상이하여 별도의 추가금액을 지불하셔야 하는 경우가 있습니다.</li>
                                    <li class="claim__infoList">초기불량 제품 및 오배송 상품은 무료로 반품을 진행해 드리며, 주문하신 상품이 품절일 경우 환불 요청이나 다른 상품으로 재구매하여 주시기 바랍니다.</li>
                                    <li class="claim__infoList">단순 변심에 의한 반품 시 사용하신 쿠폰은 다시 반환되지 않습니다.</li>
                                    <li class="claim__infoList">부분 반품 시 사용하신 적립금과 쿠폰은 반환되지 않습니다.</li>
                                    <li class="claim__infoList txt-red">상품 이미지는 모니터의 종류 및 해상도, 촬영상태 등의 사유로 실제와 차이가 있을 수 있습니다.</li>
                                    <li class="claim__infoList">오배송된 상품이라도 사용했을 경우 반품이 불가합니다.</li>
                                    <li class="claim__infoList">단순 변심에 의한 반품은 제품 수령 후 7일 이내에 미개봉, 미사용 상품의 한하여 가능합니다.</li>
                                    <li class="claim__infoList">단순 변심에 의한 반품 시 사은품이 지급된 경우 반드시 함께 반송해 주셔야 하며 사용 및 패키지 손상이 없어야 합니다.</li>
                                    <li class="claim__infoList">사은품을 동봉하여 보내지 아니한 경우, 선불 택배를 이용하여 당사 물류센터로 보내 주신 후 제품에 대한 환불 처리가 가능합니다.</li>
                                    <li class="claim__infoList">단순 변심에 의한 반품 시 지급된 사은품을 사용하여 반송이 불가능한 경우, 사은품의 정상가 대비 70% 금액을 반품 요청하신 제품의 환불 처리금액에서 차감 후 환불이 진행됩니다.</li>
                                    <li class="claim__infoList">배송 기사님 방문 시 부재중이거나, 고객님의 정보오류로 인해 반송된 제품은 재배송 시 착불로 발송됩니다.</li>
                                    <li class="claim__infoList">배송 시 요청 사항란에 기재하는 요구사항의 경우 반영되지 않으니 이 점 양해 부탁드립니다.</li>
                                </ul>
                                <div class="title-sm">[코스메틱스] 별도 추가 사항</div>
                                <ul class="claim__info">
                                    <li class="claim__infoList">
                                        일부 화장품은 특정 고객님의 피부에 맞지 않을 수 있으며, 이는 상품 자체 품질의 문제로 볼 수 없습니다.<br />
                                        일부 상품 중 트러블(알러지, 붉은 반점, 가려움, 따가움) 발생 시 사진, 소견서, 진료 확인서 중 1가지를 첨부해야 반품이 가능합니다.<br />
                                        (단, 기타 제반 비용은 고객님의 부담입니다.)
                                    </li>
                                    <li class="claim__infoList">상품 오배송 및 표시/광고의 내용과 다르거나 계약 내용과 다르게 이행된 경우에는 상품을 공급받은 날로부터 3개월 이내, 그 사실을 알게된 날 또는 알 수 있었던 날부터 30일 이내 반품이 가능하며 배송비용은 배럴에서 제공됩니다.</li>
                                </ul>
                            </dd>
                        </dl>
                        <dl class="claim__item">
                            <dt class="claim__title-wrap">
                                <a href="javascript:void(0);" class="claim__link">
                                    <h3 class="claim__category">반품이 불가능한 경우</h3>
                                    <i class="ico ico-plus"></i>
                                </a>
                            </dt>
                            <dd class="claim__info-wrap">
                                <ul class="claim__info">
                                    <li class="claim__infoList">온라인 주문의 경우 오프라인 매장에서 반품 / 환불 처리는 불가하므로 요청 시 각 구매처로 문의 바랍니다.</li>
                                    <li class="claim__infoList">제품의 택이 훼손되거나 제거 된 경우에는 반품이 불가합니다.</li>
                                    <li class="claim__infoList">수령한 그대로가 아닌 포장을 개봉하여 시착 또는 사용하여 상품의 가치가 훼손된 경우에는 반품이 불가합니다.</li>
                                    <li class="claim__infoList">고객님의 귀책사유로 인해 상품의 가치가 훼손된 경우 반품이 불가합니다.</li>
                                    <li class="claim__infoList">고객님의 귀책사유로 인해 수거가 지연될 경우 반품/교환이 제한될 수 있습니다.</li>
                                    <li class="claim__infoList">별도의 배송 박스가 아닌 상품의 직접적인 포장 박스나 용기로 배송하여 반품을 요청한 경우.</li>
                                    <li class="claim__infoList">일부 상품의 반품 불가 고지상품.</li>
                                </ul>
                                <div class="title-sm">스포츠웨어</div>
                                <ul class="claim__info">
                                    <li class="claim__infoList">신축성 있는 제품 (탱크탑, 브라탑, 브라패드, 레깅스, 비키니, 비키니팬츠, 이너웨어) 은 시착 시 상품의 가치가 훼손되어 반품이 불가합니다.</li>
                                    <li class="claim__infoList">부착된 택을 제거하였거나 제거한 흔적이 있는 경우. (예 : 택제거, 패키지백 손상, 패키지백 분실)</li>
                                    <li class="claim__infoList">고객의 책임이 있는 사유로 인하여 상품이 멸실 또는 훼손된 경우. (예 : 흙탕물 또는 진흙에 의한 오염, 워터파크 내의 슬라이드 이용으로 인한 손상, 뜯김 등)</li>
                                    <li class="claim__infoList">착용한 흔적이 발견되었을 경우. (예 : 화장품의 흔적 여부(파우더, 아이라이너, 펄, 기타오염물질)</li>
                                    <li class="claim__infoList">이미 세탁 및 착용한 상품의 경우. (제품 하자 시에도 세탁 및 착용한 상품은 반품이 불가능합니다.)</li>
                                </ul>
                                <div class="title-sm">코스메틱스</div>
                                <ul class="claim__info">
                                    <li class="claim__infoList">
                                        일부 화장품은 특정 고객님의 피부에 맞지 않을 수 있으며, 이는 상품 자체 품질의 문제로 볼 수 없습니다.<br />
                                        일부 상품 중 트러블(알러지, 붉은 반점, 가려움, 따가움) 발생 시 사진, 소견서, 진료 확인서 중 1가지를 첨부하셔야 반품이 가능합니다.<br />
                                        (단, 기타 제반 비용은 고객님의 부담입니다.)
                                    </li>
                                    <li class="claim__infoList">반품 시 상품 및 구성품을 분실하였거나 취급 부주의로 인한 파손/고장/오염된 경우와 용기 및 포장 케이스의 훼손 또는 상품 가치 상실 등의 경우 반품이 불가합니다.</li>
                                </ul>
                            </dd>
                        </dl>
                        <dl class="claim__item">
                            <dt class="claim__title-wrap">
                                <a href="javascript:void(0);" class="claim__link">
                                    <h3 class="claim__category">반품 시 박스 포장 안내</h3>
                                    <i class="ico ico-plus"></i>
                                </a>
                            </dt>
                            <dd class="claim__info-wrap">
                                <ul class="claim__info">
                                    <li class="claim__infoList">브랜드 박스의 훼손이 없도록 택배 박스 및 타 박스로 포장하여 발송해주시기 바랍니다.</li>
                                </ul>
                                <div class="claim__img"><img src="/assets/mobile_templet/mobile_enterprise/assets/img/img-cliamGuide.png" "="" alt=""></div>
                            </dd>
                        </dl>
                        <dl class="claim__item">
                            <dt class="claim__title-wrap">
                                <a href="javascript:void(0);" class="claim__link">
                                    <h3 class="claim__category">반품 신청 후 철회</h3>
                                    <i class="ico ico-plus"></i>
                                </a>
                            </dt>
                            <dd class="claim__info-wrap">
                                <ul class="claim__info">
                                    <li class="claim__infoList">
                                        고객님께서 신청하신 반품 접수 철회를 요청하실 경우, 고객센터로 연락 주시기 바랍니다.<br />
                                        단, 이미 수거지시 및 수거가 진행 중인 경우에는 반품 접수 철회가 불가할 수 있습니다.
                                    </li>
                                </ul>
                            </dd>
                        </dl>
                        <dl class="claim__item">
                            <dt class="claim__title-wrap">
                                <a href="javascript:void(0);" class="claim__link">
                                    <h3 class="claim__category">반품 절차</h3>
                                    <i class="ico ico-plus"></i>
                                </a>
                            </dt>
                            <dd class="claim__info-wrap">
                                <ul class="claim__info">
                                    <li class="claim__infoList">고객변심으로 인한 반품 요청은 상품을 수령하신 날로부터 7일 이내로 배럴 공식 홈페이지 [마이페이지] 메뉴 내의 [주문내역 조회] 에서 신청하실 수 있습니다.</li>
                                    <li class="claim__infoList">[마이페이지] 메뉴 접속은 모바일의 경우 로그인 후 좌측 상단의 메뉴 선택 후 [마이 페이지] 터치, PC의 경우 로그인 후 오른쪽 상단의 아이콘 버튼을 통해 접속 가능합니다.</li>
                                    <li class="claim__infoList">가상계좌로 구매하신 고객님께서는 반드시 [마이페이지] 메뉴 내의 [환불계좌 관리]에서 환불 받으실 계좌를 등록해 주시기 바랍니다.</li>
                                    <li class="claim__infoList">반품접수를 신청하시면 자동으로 주문하셨던 주소로 수거가 진행 됩니다. 고객님께서 택배사의 별도 신청을 하지 않으셔도 수거가 진행되니 이점 참고 부탁드립니다.</li>
                                    <li class="claim__infoList">반품 신청 철회는 수거지시가 전달되기 전까지 가능하며, 고객센터로 연락 주시기 바랍니다.</li>
                                    <li class="claim__infoList">배송 기사님 방문 시 부재중이거나, 고객님의 정보 오류로 인해 수거가 지연될 경우 반품 및 환불이 지연됩니다.</li>
                                    <li class="claim__infoList">반품접수 요청 없이 고객님께서 임의로 반송을 하실 경우, 반품 요청 내역을 확인할 수 없으므로 반품접수가 되지 않거나 환불 지연 및 불가가 될 수 있습니다.</li>
                                    <li class="claim__infoList">
                                        타 택배사를 이용하여 반품을 요청하실 경우 배송비는 선불지급 후 보내주셔야 하며, 그렇지 않은 경우 착불 발생비용을 당사 계좌로 반드시 입금해주셔야 합니다.<br />
                                        (배송비 입금계좌 : 기업은행 551-037000-01-010 (주)배럴)
                                    </li>
                                    <li class="claim__infoList">반품 상품 수거 완료 후 상품 이상유무 판단 후 환불 처리되며, 상품의 초기 불량을 제외한 단순 변심에 의한 반품 요청 시 3만원 이상 구매 시 무료 배송으로 반품하실 상품을 제외한 실결제 금액이 3만원 이상일 경우 2,500원, 3만원 미만일 경우 5,000원이 반품하신 상품의 결제한 금액에서 차감 후 환불이 진행됩니다. 도서산간지역의 경우 별도의 추가금액이 발생됩니다.</li>
                                    <li class="claim__infoList">물류센터 주소 안내 : 경기도 이천시 호법면 중부대로798번길 103-40 [배럴 물류센터]</li>
                                </ul>
                            </dd>
                        </dl>
                        <dl class="claim__item">
                            <dt class="claim__title-wrap">
                                <a href="javascript:void(0);" class="claim__link">
                                    <h3 class="claim__category">반품 후 환불 안내</h3>
                                    <i class="ico ico-plus"></i>
                                </a>
                            </dt>
                            <dd class="claim__info-wrap">
                                <ul class="claim__info">
                                    <li class="claim__infoList">
                                        반품 후 환불은 물류센터에 도착한 날로부터 3영업일 이내 결제하신 PG사를 통해 진행됩니다. <br />
                                        (단, 검수를 통해 제품에 하자가 있을 경우 환불 시 그에 상응하는 금액을 공제하고 환불하거나 추후 별도로 청구할 수 있습니다.)
                                    </li>
                                    <li class="claim__infoList">단순 변심에 의한 반품 시 사용하신 쿠폰은 반환되지 않습니다.</li>
                                    <li class="claim__infoList">부분 반품 시 사용하신 적립금과 쿠폰은 반환되지 않습니다.</li>
                                    <li class="claim__infoList">
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
</div>
<!-- 반품&환불 안내 팝업 E -->

<!-- 배송안내 안내 팝업 S -->
<div class="popup-layout popup-layout__goods" id="layer-delivery">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">배송안내</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="gform">
                    <div class="gform__common">
                        <div class="gform__common__top">배송업체</div>
                        <div class="gform__common__desc">
                            <p>CJ 대한통운</p>
                        </div>
                    </div>
                    <div class="gform__common">
                        <div class="gform__common__top">배송업체</div>
                        <div class="gform__common__desc">
                            <p>
                                총 실결제금액 30,000원 미만 시 배송비 2,500원<br />
                                (산간벽지, 도서지방 3,000원 추가)
                            </p>
                        </div>
                    </div>
                    <div class="gform__common">
                        <div class="gform__common__top">배송기간</div>
                        <div class="gform__common__desc">
                            <p>
                                영업일 기준 1~3일 소요.<br />
                                (여름 시즌의 경우 주문량이 많아 평균 2~5일 소요.)
                            </p>
                        </div>
                    </div>
                    <div class="gform__common">
                        <div class="gform__common__top">배송 유의사항</div>
                        <div class="gform__common__desc">
                            <ul>
                                <li>당일 오후 2시 이전 결제 완료된 주문건의 경우, 일괄적으로 당일 출고됩니다.</li>
                                <li>주문번호가 다를 경우 묶음 배송은 불가합니다.</li>
                                <li>천재지변, 일시품절 등의 경우에 따라 일반적인 배송기간보다 지연될 수 있습니다.</li>
                                <li>배송사의 물량증가로 인한 지연이 있을 수 있습니다.</li>
                                <li>품절상품은 발송 전 순차적으로 연락드립니다.</li>
                                <li>주문서 입금 확인 시 상품 변경 및 주소 변경이 불가합니다.<br />변경을 희망하시는 경우 전체 취소 후 재구매를 부탁드립니다.</li>
                                <li>송장 발행 / 배송 준비 중 상태는 상품 포장이 완료된 상태로 취소 또는 변경이 불가합니다.</li>
                                <li>
                                    배송 중 상태에서는 반송 및 수취거부는 불가합니다.<br />상품을 수령하신 후 반품 신청을 부탁드립니다.<br />
                                    (고객변심으로 인한 반품 시 반품비가 발생됩니다.)
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 배송안내 안내 팝업 E -->

<!-- 문의하기 S -->
<div class="popup-layout popup-layout__full" id="layer-qna">
    <div class="popup-layout__wrap">
        <div class="popup-title">
            <div class="title-lg">상품문의하기</div>
            <a href="javascript:void(0);" class="btn-close">닫기</a>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content">
                <div class="board-qna__wrap">
                    <div class="popup-product">
                        <ul class="product-list">
                            <li class="product-list__item">
                                <dl class="product-list__group">
                                    <dt class="product-list__group-left">
                                        <figure class="product-list__thumb">
<?php if($TPL_image_src_1){$TPL_I1=-1;foreach($TPL_VAR["image_src"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
                                                    <img src="<?php echo $TPL_V1["basic_img"]?>" alt="" />
<?php }?>
<?php }}?>
                                        </figure>
                                    </dt>
                                    <dd class="product-list__group-right">
                                        <div class="product-list__info">
                                            <div class="product-list__info__title"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></div>

                                            <div class="product-list__info__option">
                                                <div class="product-list__info__option-item">
                                                    <span class="color"><?php echo $TPL_VAR["add_info"]?></span>
                                                </div>
                                            </div>

                                            <div class="product-list__info__price">
<?php if($TPL_VAR["discount_rate"]){?>
                                                <span class="product-list__info__price--discount"><?php echo $TPL_VAR["discount_rate"]?>%</span>
<?php }?>
<?php if($TPL_VAR["discount_rate"]){?>
                                                <del class="product-list__info__price--strike"><em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["listprice"])?></em>원</del>
<?php }?>
                                                <span class="product-list__info__price--cost"><em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["dcprice"])?></em>원</span>
                                                <!-- 판매중지 / 판매예정 / 판매종료 S -->
                                                <!-- 숨김처리 -->
                                                <span class="product-list__info__price--stop" style="display: none">판매중지</span>
                                                <!-- 판매중지 / 판매예정 / 판매종료 E -->

                                                <!-- 솔드아웃 S -->
                                                <!-- 숨김처리 -->
<?php if($TPL_VAR["is_soldout"]){?>
                                                <span class="product-list__info__price--soldout">품절</span>
<?php }?>
                                                <!-- 솔드아웃 E -->
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                            </li>
                        </ul>
                    </div>
                    <div class="board-qna__form-wrap">
                        <div class="board-qna__form">
                            <form name="goodsQnaFrom" id="devGoodsQnaFrom">
                                <input type="hidden" name="pid" id="devPid" value="<?php echo $TPL_VAR["pid"]?>">
                                <input type="hidden" name="bbs_ix" id="devBbsIx" value="<?php echo $TPL_VAR["bbs_ix"]?>">
                                <div class="br__form-item">
                                    <label for="" class="hidden">문의유형</label>
                                    <select class="br__form-select" name="div" id="devQnaDiv" title="문의유형">
                                        <option value="" selected>문의유형 선택</option>
<?php if($TPL_qnaDivs_1){foreach($TPL_VAR["qnaDivs"] as $TPL_V1){?>
                                        <option value="<?php echo $TPL_V1["ix"]?>" <?php if($TPL_VAR["bbs_div"]==$TPL_V1["ix"]){?> selected <?php }?>><?php echo trans($TPL_V1["div_name"])?></option>
<?php }}?>
                                    </select>
                                </div>
                                <div class="br__form-item">
                                    <label for="" class="hidden">문의유형</label>
                                    <input type="text" class="br__form-input" name="subject" value="<?php echo $TPL_VAR["bbs_subject"]?>" id="devQnaSubject" title="문의 제목" placeholder="문의 제목을 입력해 주세요." />
                                </div>
                                <div class="br__form-item br__form-email">
                                    <label for="devEmailId" class="inputs__title hidden">이메일 주소</label>
                                    <div class="br__form-group">
                                        <input type="text" name="emailId" id="devEmailId" class="br__form-input" placeholder="메일 아이디" value="<?php echo $TPL_VAR["emailId"]?>" title="이메일 주소" />
                                        <input type="text" name="emailHost" id="devEmailHost" class="br__form-input" placeholder="메일 도메인 주소" value="<?php echo $TPL_VAR["emailHost"]?>" title="이메일 주소" />
                                        <input type="hidden" id="devLoginEmailId" value="<?php echo $TPL_VAR["emailId"]?>" />
                                        <input type="hidden" id="devLoginEmailHost" value="<?php echo $TPL_VAR["emailHost"]?>"  />
                                    </div>
                                    <div class="br__form-group">
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
                                    <dl class="board-qna__form-radio">
                                        <dt class="title-sm">답변을 메일로 받으시겠습니까?</dt>
                                        <dd class="br__form-item">
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
                                <div class="br__form-item br__form-write">
                                    <div class="title-sm">내용입력</div>
                                    <textarea class="br__form-textarea" name="contents" id="devQnaContents" title="문의 내용" onclick="focusIn();" onblur="focusOut();"><?php echo $TPL_VAR["bbs_contents"]?></textarea>
<?php if($TPL_VAR["bbs_contents"]==''){?>
                                    <div class="br__form-textarea--placeholder" id="contentsPlace">
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
                                <div class="board-qna__form-notice">
                                    <dl class="board-qna__form-radio">
                                        <dt class="title-sm">비밀글로 설정하시겠습니까?</dt>
                                        <dd class="br__form-item">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-layout__footer">
            <div class="btn-group">
                <button type="button" class="btn-lg btn-dark-line" id="devSubmitBtnQna">문의하기</button>
            </div>
        </div>
    </div>
</div>
<!-- 공유하기 E -->
<!-- modal E -->
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

	$(".goods-info__toggle-title--btn").on("click", function () {
		var toggleItem = $(this).parents(".goods-info__toggle");
		toggleItem.toggleClass("active");
		if ($(this).parents(".goods-info__toggle").hasClass("active")) {
			toggleItem.addClass("active");
			toggleItem.find(".goods-info__toggle-cont").stop().slideDown();
		} else {
			toggleItem.removeClass("active");
			toggleItem.find(".goods-info__toggle-cont").stop().slideUp();
		}
	});
</script>
</body>
</html>