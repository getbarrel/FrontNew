<?php /* Template_ 2.2.8 2024/03/13 12:23:39 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/layout/header/header_search.htm 000002130 */ ?>
<section id="header" class="br__search__detail">

    <article class="br__search__title">
        <button class="search-back" onclick="history.back();"></button>
        <label for="devHeaderSearchText" class="hide">검색어 입력 영역</label>
		<input class="search-input after devAutoComplete" type="text" id="devHeaderSearchText" value="<?php echo $TPL_VAR["searchText"]?>" onblur="removeHeaderTag(this.value);" onkeypress="removeKeyPress(this.value);" onkeydown="removeKeydown(this.value);" data-id="devHeaderSearchText">
		<button class="search-btn" id="devHeaderSearchButton" style="left:5.8rem">
			<i class="ico ico-search"></i>
		</button>
        <button class="search-close after" onclick="searchTxtRemove();" style="display:none;"></button>
    </article>

    <article class="br__search__layer" style="display:none;">
        <div class="auto-complete">
            <ul class="auto-complete__list">
            </ul>'
        </div>
    </article>
</section>

<!--
<section id="header" class="br__search__detail">

    <article class="br__search__title">
        <button class="search-back" onclick="history.back();"></button>
        <label for="devHeaderSearchText" class="hide">검색어 입력 영역</label>
		<input class="search-input after devAutoComplete" type="text" id="devHeaderSearchText" value="<?php echo $TPL_VAR["searchText"]?>" onblur="removeHeaderTag(this.value);" onkeypress="removeKeyPress(this.value);" onkeydown="removeKeydown(this.value);" data-id="devHeaderSearchText">
		<button class="search-btn" id="devHeaderSearchButton" style="left:5.8rem">
			<i class="ico ico-search"></i>
		</button>
        <button class="search-close after" onclick="searchTxtRemove();" style="display:none;"></button>
    </article>

    <article class="br__search__layer" style="display:none;">
        <div class="auto-complete">
            <ul class="auto-complete__list">
            </ul>'
        </div>
    </article>
</section>

-->