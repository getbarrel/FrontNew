<?php /* Template_ 2.2.8 2024/02/02 11:10:12 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/customer/store_information/store_information.htm 000007736 */ ?>
<!-- 컨텐츠 S -->
<form id="devListForm">
      <input type="hidden" name="page" value="1" id="devPage"/>
      <input type="hidden" name="max" value="10" />
      <input type="hidden" name="city" value="" id="devCity" />
      <input type="hidden" name="area" value="" id="devArea" />
      <input type="hidden" name="name" value="<?php echo $TPL_VAR["storeName"]?>" id="devStoreName" />
</form>
<section class="br__store">
	<section class="cs__menu">
		<div class="br-tab__slide swiper-container">
			<ul class="swiper-wrapper">
				<li class="swiper-slide ">
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
				<li class="swiper-slide active">
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
				<li class="swiper-slide ">
					<a href="/customer/contactUs">제휴 문의</a>
				</li>
			</ul>
		</div>
	</section>
	<div class="br__store-wrap">
		<div class="page-title">
			<div class="title-md">매장안내</div>
		</div>
		<div class="br__store__top">
			<div class="br__store__top-group">
				<div class="br__store__sort">
					<!-- 셀렉트 박스(select) S -->
					<select class="fb__form-select" id="devCitySelect" name="city">
						<option value="">전체</option>
<?php if(is_array($TPL_R1=$TPL_VAR["cityList"]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<option class="devSortTab" name="filterRadio" value="<?php echo $TPL_V1["city_code"]?>"><?php echo $TPL_V1["city_code"]?></option>
<?php }}?>
					</select>
				</div>
				<div class="br__store__sort">
					<!-- 셀렉트 박스(select) S -->
					<select class="fb__form-select" id="devAreaSelect" name="area">
						<option class="devSortTab" value="">시/군/구</option>
					</select>
				</div>
				<button class="btn-lg btn-dark-line br__store__find" id="devSearchStore">검색</button>
			</div>
					
			<div class="br__form-item">
				<label for="devStoreInput" class="hide"></label>
				<input class="lnb__top__name br__form-input" type="text" id="devStoreInput" name="store_input" placeholder="매장명 검색" value="<?php echo $TPL_VAR["storeName"]?>" />
				<i class="ico ico-search"></i>
			</div>
		</div>
		<div class="br__store__result">
			<h3 class="br__hidden">매장검색결과</h3>
			<div class="result">
				<!-- 최초 메시지(검색 전) S -->
				<!-- 숨김처리 되어 있음 -->
				<div class="result__empty" id="devLoading">
					<p class="empty-content">찾으시는 지역을 선택해 주세요.</p>
				</div>
				<!-- 최초 메시지(검색 전) E -->

				<!-- 검색 후 노출 S -- 
				<div class="result__empty">
					<p class="empty-content"><span>10</span>개의 배럴 매장이 검색되었습니다.</p>
				</div>
				<!-- 검색 후 노출 E -->

				<ul class="result__list" id="devListContents">
					<li class="br-Loading" id="devListLoading" style="display: none">loading...</li>
					
					<li id="devListEmpty" class="result__each no-data">
						<p class="empty-content">선택하신 지역의 매장을 찾을 수 없습니다.</p>
					</li>

					<li class="result__each" id="devListDetail">
						<a href="/customer/storeInformationDetail/{[store_idx]}" class="result__each__link">
							<span class="result__each__name">{[store_name]}</span>
							<span class="result__each__addr">{[store_address1]} {[store_address2]}</span>
						</a>
					</li>
                        <div class="br__more" id="devPageWrap"></div>
				</ul>
			</div>
		</div>
	</div>
</section>
<!-- 컨텐츠 E -->
<!--
<form id="devListForm">
      <input type="hidden" name="page" value="1" id="devPage"/>
      <input type="hidden" name="max" value="10" />
      <input type="hidden" name="city" value="" id="devCity" />
      <input type="hidden" name="area" value="" id="devArea" />
</form>
<section class="br__store">
      <h2 class="br__cs__title">매장안내</h2>

      <header class="br__store__top">
            <div class="br__select-box br__store__sort">
                  <div class="select-box">
                        <button class="select-box__title"><span>시/도</span></button>
                        <div class="select-box__layer" id="devCitySelect">
	  						  <label class="select-box__layer__label">
                                    <input type="radio" class="devSortTab" name="filterRadio" value="">
                                    <span>전체</span>
                              </label>
<?php if(is_array($TPL_R1=$TPL_VAR["cityList"]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                              <label class="select-box__layer__label">
                                    <input type="radio" class="devSortTab" name="filterRadio" value="<?php echo $TPL_V1["city_code"]?>">
                                    <span><?php echo $TPL_V1["city_code"]?></span>
                              </label>
<?php }}?>
                        </div>
                  </div>
            </div>
            <div class="br__select-box br__store__sort">
                  <div class="select-box">
                        <button class="select-box__title"><span>지역구</span></button>
                        <div class="select-box__layer" id="devAreaSelect">
                              <label class="select-box__layer__label">
                                    <input type="radio" class="devSortTab" name="filterRadio" value="">
                                    <span>지역구</span>
                              </label>
                        </div>
                  </div>
            </div>
            <button class="br__store__find" id="devSearchStore">매장검색</button>
      </header>
      <section class="br__store__result">
            <h3 class="br__hidden">매장검색결과</h3>
            <div class="result">

                  <div class="result__empty" id="devLoading">
                        매장 검색 결과가 없습니다.
                  </div>
                  <ul class="result__list" id="devListContents">
                        <li class="devForbizTpl" id="devListLoading">loading...</li>

                        <li id="devListEmpty" class="empty-content devForbizTpl">매장 검색 결과가 없습니다.</li>

                        <li class="result__each" id="devListDetail">
                              <span class="result__each__name">{[store_name]}</span>
                              <span class="result__each__addr">{[store_address1]}<br/>{[store_address2]}</span>
                              <a href="/customer/storeInformationDetail/{[store_idx]}" class="result__each__btn">상세정보</a>
                        </li>
                        <div class="br__more" id="devPageWrap"></div>
                  </ul>

            </div>
      </section>
</section>
-->