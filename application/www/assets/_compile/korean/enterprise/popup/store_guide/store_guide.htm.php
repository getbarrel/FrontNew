<?php /* Template_ 2.2.8 2023/07/18 10:20:06 /home/barrel-qa/application/www.bak/assets/templet/enterprise/popup/store_guide/store_guide.htm 000004505 */ 
$TPL_style_1=empty($TPL_VAR["style"])||!is_array($TPL_VAR["style"])?0:count($TPL_VAR["style"]);
$TPL_option_1=empty($TPL_VAR["option"])||!is_array($TPL_VAR["option"])?0:count($TPL_VAR["option"]);?>
<form id="devStoreGuideForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="10" />
    <input type="hidden" name="city" value="" id="devCity" />
    <input type="hidden" name="item" value="" id="devItem" />
</form>
<section class="store-guide">
    <!-- [S] 상품정보 -->
    <section class="store-guide__goods">
        <div class="about-goods">
            <figure class="about-goods__thumb">
                <img src="<?php echo $TPL_VAR["image_src"]?>" alt="상품명 썸네일">
            </figure>
            <div class="about-goods__info">
                <p class="about-goods__title"><?php echo $TPL_VAR["pname"]?></p>
                <p class="about-goods__option"><?php echo $TPL_VAR["add_info"]?></p>
            </div>
        </div>
    </section>
    <!-- [E] 상품정보 -->
	<!-- [S] 상품정보 -->
    <section class="store-guide__goods">
        <div class="about-goods">
            <div class="about-goods__info">
                <img src="/assets/templet/enterprise/images/shop/store_guide.jpg" style="width:500px;">
            </div>
        </div>
    </section>
    <!-- [S] 상품 검색 -->
    <section class="store-guide__search">
        <div class="search-store">
            <p class="search-store__title">검색 조건</p>
            <div class="search-store__filter">
<?php if(count($TPL_VAR["style"])> 1){?>
                <div class="br__select-box">
                    <div class="select-box">
                        <select name="style" id="devStyleSelect">
<?php if($TPL_style_1){foreach($TPL_VAR["style"] as $TPL_V1){?>
                            <option value="<?php echo $TPL_V1["style"]?><?php echo $TPL_V1["color"]?>"><?php echo $TPL_V1["gname"]?></option>
<?php }}?>
                        </select>
                    </div>
                </div>
<?php }?>
<?php if(!empty($TPL_VAR["option"])){?>
                <div class="br__select-box">
                    <div class="select-box">
                        <select name="option" id="devOptionSelect">
<?php if($TPL_option_1){foreach($TPL_VAR["option"] as $TPL_V1){?>
                            <option value="<?php echo $TPL_V1["option_gid"]?>"><?php echo $TPL_V1["option_div"]?></option>
<?php }}?>
                        </select>
                    </div>
                </div>
<?php }?>
                <div class="br__select-box">
                    <div class="select-box">
                        <select name="city" id="devCitySelect">
<?php if(is_array($TPL_R1=$TPL_VAR["cityList"]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                            <option value="<?php echo $TPL_V1["city_code"]?>"><?php echo $TPL_V1["city_name"]?></option>
<?php }}?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="search-store__submit">
                <button class="search-store__submit__btn" id="devSearch">검색</button>
            </div>
        </div>
    </section>
    <!-- [E] 상품 검색 -->
    <section class="store-guide__result">
        <div class="search-result">
            <p class="search-result__total">검색 결과 (<span id="devListCount">0</span>)</p>
            <div class="search-result__empty" id="devLoading">
                매장 검색 결과가 없습니다.
            </div>
            <ul class="search-result__list" id="devListContents">
                <li class="devForbizTpl" id="devListLoading">loading...</li>

                <li id="devListEmpty" class="empty-content devForbizTpl">매장 검색 결과가 없습니다.</li>

                <li class="search-result__box" id="devListDetail">
                    <div class="search-result__info">
                        <p class="search-result__info__name">{[shop_nm]}</p>
                        <p class="search-result__info__addr">{[shop_addr]}</p>
                    </div>
                    <a href="/customer/storeInformation/{[shop_cd]}" class="search-result__btn">상세정보</a>
                </li>
            </ul>
        </div>
    </section>
</section>