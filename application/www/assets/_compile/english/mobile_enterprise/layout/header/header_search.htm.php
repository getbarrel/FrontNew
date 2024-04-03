<?php /* Template_ 2.2.8 2020/12/10 10:05:34 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/layout/header/header_search.htm 000001543 */ ?>
<section id="header" class="br__search__detail">
    <!-- 검색어 입력 -->
    <article class="br__search__title">        
        <button class="search-back" onclick="history.back();"></button>
        <input class="search-input after devAutoComplete" type="input" id="devHeaderSearchText" value="<?php echo $TPL_VAR["searchText"]?>" onblur="removeHeaderTag(this.value);" onkeypress="removeKeyPress(this.value);" onkeydown="removeKeydown(this.value);"/>
        <button class="search-btn" id="devHeaderSearchButton"></button>
        <button class="search-close after" onclick="searchTxtRemove();" style="display:none;"></button>
    </article>
    <!-- EOD : 검색어 입력 -->

    <!-- 검색 자동완성 -->
    <article class="br__search__layer" style="display:none;">
        <div class="auto-complete">
            <ul class="auto-complete__list">
                <li><a href="#"><em>Rashguard</em></a><button></button></li>
                <li><a href="#">Bra-top <em>Rashguard</em></a><button></button></li>
                <li><a href="#">ODD <em>Rashguard</em></a><button></button></li>
                <li><a href="#">Loose fit <em>Rashguard</em></a><button></button></li>
                <li><a href="#">Zip-up <em>Rashguard</em></a><button></button></li>
            </ul>'
        </div>
    </article>
    <!-- EOD : 검색 자동완성 -->
</section>