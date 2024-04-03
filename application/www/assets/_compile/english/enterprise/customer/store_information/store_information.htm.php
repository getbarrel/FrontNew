<?php /* Template_ 2.2.8 2021/03/23 13:53:56 /home/barrel-stage/application/www/assets/templet/enterprise/customer/store_information/store_information.htm 000008639 */ ?>
<form id="devListForm">
      <input type="hidden" name="page" value="1" id="devPage"/>
      <input type="hidden" name="max" value="10" />
      <input type="hidden" name="city" value="" id="devCity" />
      <input type="hidden" name="area" value="" id="devArea" />
      <input type="hidden" name="name" value="<?php echo $TPL_VAR["storeName"]?>" id="devStoreName" />
</form>
<section class="fb__store">
      <!-- {#customerT op} -->
      <!--<h2 class="fb__cs__title">Membership Guide</h2>-->
      <div id="map" style="width: 1920px; height: 770px; "></div>
      <aside class="fb__store__lnb">
            <div class="lnb">
                  <h2 class="lnb__title">Stores<span class="lnb__fold">접기아이콘</span></h2>
                  <header class="lnb__top">
                        <select class="lnb__top__sort" id="devCitySelect" name="city">
                              <option value="">Region</option>
<?php if(is_array($TPL_R1=$TPL_VAR["cityList"]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                              <option class="devSortTab" name="filterRadio" value="<?php echo $TPL_V1["city_code"]?>"><?php echo $TPL_V1["city_code"]?></option>
<?php }}?>
                        </select>
                        <select class="lnb__top__sort" id="devAreaSelect" name="area">
                              <option class="devSortTab" value="">City/Province</option>
                        </select>
                        <input class="lnb__top__name" type="text" id="devStoreInput" name="store_input" placeholder="매장명" value="<?php echo $TPL_VAR["storeName"]?>">
                        <button class="lnb__top__search" id="devSearchStore">Search</button>
                  </header>
                  <div class="lnb__result">
                        <h3 class="lnb__result__title">Search results(<span id="devStoreCnt">0</span>)</h3>
                        <div class="lnb__result__scroll">
                              <ul id="devListContents" style="display: none">
                                    <li class="devForbizTpl" id="devListLoading"></li>

                                    <li id="devListEmpty" class="empty-content devForbizTpl">No result found</li>

                                    <li class="js__each__store devForbizTpl" id="devListDetail" >
                                          <a href="#" data-ob='[{[json]}]'>
                                                <dl class="lnb__result__each">
                                                      <dt class="lnb__result__each-name">{[store_name]}</dt>
                                                      <dd class="lnb__result__each-detail" >
                                                            <span class="devAddressInfo">{[store_address1]} {[store_address2]}</span>
                                                            <span>{[open_time]}</span>
                                                            <span>{[store_tel]}</span>
                                                            <span class="lnb__result__each-marker">지도마커</span>
                                                      </dd>
                                                </dl>
                                          </a>
                                    </li>
                              </ul>
                              <div class="lnb__result__empty" id="devLoading" style="display:none">
                                    No result found
                              </div>
                        </div>
                  </div>
            </div>
      </aside>
      <section class="fb__store__detail s-detail">
            <div class="s-detail__slide">
                  <div class="s-detail__slide-inner js__store__list">
                        <!--<div class="s-detail__each swiper-container" style="display: none;" >-->
                        <div class="s-detail__each swiper-container" style="display: none;">
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
                              <!-- [개발확인필요] 191023 수정 -->
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
                              <!-- // [개발확인필요] 191023 수정 -->

                              <!--<ul class="s-detail__each__desc">-->
                                    <!--<li class="s-detail__each__desc&#45;&#45;basic">-->
                                          <!--<span>아이콘</span>-->
                                          <!--<p class="s-detail__each__title">{[store_name]}</p>-->
                                          <!--<p>{[store_address]}</p>-->
                                    <!--</li>-->
                                    <!--<li class="s-detail__each__desc&#45;&#45;time">-->
                                          <!--<span>아이콘</span>-->
                                          <!--<p>시간시간</p>-->
                                          <!--<p>1855-6969</p>-->
                                    <!--</li>-->
                                    <!--<li class="s-detail__each__desc&#45;&#45;bus">-->
                                          <!--<span>아이콘</span>-->
                                          <!--<p>버스버스버스</p>-->
                                    <!--</li>-->
                                    <!--<li class="s-detail__each__desc&#45;&#45;subway">-->
                                          <!--<span>아이콘</span>-->
                                          <!--<p>지하철지하철</p>-->
                                    <!--</li>-->
                              <!--</ul>-->
                        </div>
                  </div>
                  <div class="s-detail__slide__nav">
                        <button class="s-detail__slide__nav--prev">prev</button>
                        <button class="s-detail__slide__nav--next">next</button>
                  </div>
            </div>
      </section>
</section>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo KAKAO_SCRIPT_KEY?>&libraries=services"></script>