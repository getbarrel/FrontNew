<?php /* Template_ 2.2.8 2020/08/31 15:56:56 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/customer/store_information/store_information.htm 000003167 */ ?>
<form id="devListForm">
      <input type="hidden" name="page" value="1" id="devPage"/>
      <input type="hidden" name="max" value="10" />
      <input type="hidden" name="city" value="" id="devCity" />
      <input type="hidden" name="area" value="" id="devArea" />
</form>
<section class="br__store">
      <h2 class="br__cs__title">Membership Guide</h2>

      <header class="br__store__top">
            <div class="br__select-box br__store__sort">
                  <div class="select-box">
                        <button class="select-box__title"><span>Region</span></button>
                        <div class="select-box__layer" id="devCitySelect">
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
                        <button class="select-box__title"><span>City/Province</span></button>
                        <div class="select-box__layer" id="devAreaSelect">
                              <label class="select-box__layer__label">
                                    <input type="radio" class="devSortTab" name="filterRadio" value="">
                                    <span>City/Province</span>
                              </label>
                        </div>
                  </div>
            </div>
            <button class="br__store__find" id="devSearchStore">Search</button>
      </header>
      <section class="br__store__result">
            <h3 class="br__hidden">Search result</h3>
            <div class="result">

                  <div class="result__empty" id="devLoading">
                        No result found
                  </div>
                  <ul class="result__list" id="devListContents">
                        <li class="devForbizTpl" id="devListLoading">loading...</li>

                        <li id="devListEmpty" class="empty-content devForbizTpl">No result found</li>

                        <li class="result__each" id="devListDetail">
                              <span class="result__each__name">{[store_name]}</span>
                              <span class="result__each__addr">{[store_address1]}<br/>{[store_address2]}</span>
                              <a href="/customer/storeInformationDetail/{[store_idx]}" class="result__each__btn">Product Description</a>
                        </li>
                        <div class="br__more" id="devPageWrap"></div>
                  </ul>

            </div>
      </section>
</section>