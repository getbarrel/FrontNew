<?php /* Template_ 2.2.8 2024/03/25 17:40:39 /home/barrel-stage/application/www/assets/templet/enterprise/customer/store_information/store_information.htm 000007176 */ ?>
<!-- 컨텐츠 S -->
<form id="devListForm">
      <input type="hidden" name="page" value="1" id="devPage"/>
      <input type="hidden" name="max" value="10" />
      <input type="hidden" name="city" value="" id="devCity" />
      <input type="hidden" name="area" value="" id="devArea" />
      <input type="hidden" name="name" value="<?php echo $TPL_VAR["storeName"]?>" id="devStoreName" />
</form>
<section class="fb__customer fb__store">
	<div class="fb__store-wrap">
		<aside class="fb__store__lnb">
			<div class="lnb">
				<div class="lnb__title">매장안내</div>
				<div class="lnb__top">
					<div class="fb__form-group">
						<select class="fb__form-select" id="devCitySelect" name="city">
                              <option value="">지역</option>
<?php if(is_array($TPL_R1=$TPL_VAR["cityList"]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                              <option class="devSortTab" name="filterRadio" value="<?php echo $TPL_V1["city_code"]?>"><?php echo $TPL_V1["city_code"]?></option>
<?php }}?>
						</select>
						<select class="fb__form-select" id="devAreaSelect" name="area">
                              <option class="devSortTab" value="">시/군/구</option>
						</select>
						<button class="lnb__top__search btn-lg btn-dark-line" id="devSearchStore">검색</button>
					</div>
					<div class="fb__form-item">
						<label for="devStoreInput" class="hide"></label>
						<input class="lnb__top__name fb__form-input" type="text" id="devStoreInput" name="store_input" placeholder="매장명 검색" value="<?php echo $TPL_VAR["storeName"]?>" />
						<i class="ico ico-search"></i>
					</div>
				</div>
				<div class="lnb__result">
					<div class="lnb__result__scroll">
						<ul id="devListContents">
							<li id="devListLoading" class="devForbizTpl"></li>

							<li id="devListEmpty" class="empty-content devForbizTpl">찾으시는 지역을 선택해 주세요.</li>

							<li class="lnb__result__title">
								<p class="empty-content"><span id="devStoreCnt">0</span>개의 배럴 매장이 검색되었습니다.</p>
							</li>
							<li class="js__each__store lnb__result__item" id="devListDetail">
								<a href="javascript:void(0);" data-ob='[{[json]}]'>
									<dl class="lnb__result__each">
										<dt class="lnb__result__each-name">{[store_name]} <i class="ico ico-arrow-right "></i></dt>
										<dd class="lnb__result__each-detail">
											<p class="devAddressInfo">{[store_address1]} {[store_address2]}</p>
										</dd>
									</dl>
								</a>
							</li>
							
						</ul>
					</div>
				</div>
			</div>
		</aside>
		<div class="fb__store__map">
			<div class="fb__store__map-wrap">
				<div class="fb__store-slide swiper-container">
					<div class="swiper-wrapper">
						<?php echo $TPL_VAR["storeBasicInfo"]["src"]?>

					</div>
					<div class="fb__store-slide__control">
						<div class="swiper-control-group">
							<div class="swiper-scrollbar"></div>
							<div class="swiper-pagination"></div>
							<button type="button" class="swiper-button swiper-button-prev"></button>
							<button type="button" class="swiper-button swiper-button-next"></button>
						</div>
					</div>
				</div>
				<div id="map" style="width: 830px; height: 600px; "></div>
			</div>
		</div>

		<section class="fb__store__detail s-detail ">
			<div class="fb__store__detail-wrap">
				<div class="fb__store__detail-info">
					<div class="fb__store__name"><?php echo $TPL_VAR["storeBasicInfo"]["store_name"]?></div>
					<div class="fb__store__address">
						<p>
							<?php echo $TPL_VAR["storeBasicInfo"]["store_address1"]?><br />
							<?php echo $TPL_VAR["storeBasicInfo"]["store_address2"]?>

						</p>
					</div>
					<div class="fb__store__businessDay">
						<button type="button" class="btn-sns" id="_businessSns" onclick="window.open('<?php echo $TPL_VAR["storeBasicInfo"]["sns_info"]?>')"><i class="ico ico-instagram-bk"></i></button>
						<p id="_businessDay"><?php echo $TPL_VAR["storeBasicInfo"]["open_time"]?></p>
						<p id="_businessTel"><?php echo $TPL_VAR["storeBasicInfo"]["store_tel"]?></p>
					</div>
				</div>
				<div class="fb__store__detail-publicTransport">
					<div class="fb__store__detail-item">
						<div class="title-sm">버스 이용 안내</div>
						<ul class="fb__store-desc">
							<li id="_bus">
								<?php echo $TPL_VAR["storeBasicInfo"]["bus"]?>

							</li>
						</ul>
					</div>
					<div class="fb__store__detail-item">
						<div class="title-sm">지하철 이용 안내</div>
						<ul class="fb__store-desc">
							<li id="_subway">
								<?php echo $TPL_VAR["storeBasicInfo"]["subway"]?>

							</li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<!--
		<section class="fb__store__detail s-detail">
			<div class="s-detail__slide">
				  <div class="s-detail__slide-inner js__store__list">
						<div class="s-detail__each swiper-container">
							  <div class="s-detail__each__thumb swiper-wrapper">
									<figure class="swiper-slide">
										  <img src="$<?php echo $GLOBALS["store_data"]["src"][$TPL_VAR["i"]]?>" alt="storeImg">
									</figure>
									<figure class="swiper-slide">
										  <img src="$<?php echo $GLOBALS["store_data"]["src"][$TPL_VAR["i"]]?>" alt="storeImg">
									</figure>
									<figure class="swiper-slide">
										  <img src="$<?php echo $GLOBALS["store_data"]["src"][$TPL_VAR["i"]]?>" alt="storeImg">
									</figure>
							  </div>
							  <ul class="s-detail__each__desc">
									<li class="s-detail__each__desc__list s-detail__each__desc--basic">
										  <p class="s-detail__each__desc__title">매장정보</p>
										  <p class="s-detail__each__title">{[store_name]}</p>
										  <p>{[store_address]}</p>
										  <p>시간시시간시간시간시간시간시간시간시간시간시간</p>
										  <p class="s-detail__each__time">1855-6969</p>
									</li>
									<li class="s-detail__each__desc__list s-detail__each__desc--time">
										  <p class="s-detail__each__desc__title">버스 이용방법</p>
										  <p>버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스버스</p>
									</li>
									<li class="s-detail__each__desc__list s-detail__each__desc--bus">
										  <p class="s-detail__each__desc__title">지하철 이용방법</p>
										  <p>지하철지하철지하철지하철지하철지하철지하철지하철지하철지하철지하철지하철</p>
									</li>
							  </ul> 
						</div>
				  </div>
				  <div class="s-detail__slide__nav">
						<button class="s-detail__slide__nav--prev">prev</button>
						<button class="s-detail__slide__nav--next">next</button>
				  </div>
			</div>
		</section>
		-->
	</div>
</section>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo KAKAO_SCRIPT_KEY?>&libraries=services"></script>
<!-- 컨텐츠 E -->