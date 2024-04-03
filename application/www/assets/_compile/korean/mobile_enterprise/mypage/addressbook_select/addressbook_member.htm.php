<?php /* Template_ 2.2.8 2023/07/18 10:19:57 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/addressbook_select/addressbook_member.htm 000002083 */ ?>
<script>var addressPopMode = 'member';</script>
<div class="address-select">
    <div>
        <ul class="address-select__list" id="devAddressBooKContent">
            <li id="devAddressBooKLoading"  class="devForbizTpl">
                <div class="mobile_address-contents">
                    <header>
                        <h3>Loading...</h3>
                    </header>
                </div>
            </li>
            <li id="devAddressBooKList" class="address-select__box devForbizTpl">
                <div class="address-select__info">
                    <span class="address-select__info__title">{[recipient]} {[#if default_yn]}<span>[기본]</span>{[/if]}</span>
                    <span class="address-select__info__name">{[recipient]}</span>
                    {[#if nation_name]}<p class="address-select__info__addr">{[nation_name]}</p>{[/if]}
                    <p class="address-select__info__addr">{[address1]} <br>{[address2]}</p>
                    {[#if city]}<p class="address-select__info__addr">{[city]}</p>{[/if]}
                    {[#if state]}<p class="address-select__info__addr">{[state]}</p>{[/if]}
                    <p class="address-select__info__phone">{[mobile]} / {[tel]}</p>
                </div>
                <div class="address-select__btn">
                    <button class="devAddressBookItemSelect" data-oid="<?php echo $TPL_VAR["oid"]?>" data-ix="{[ix]}">주소 선택</button>
                </div>
            </li>
            <li id="devAddressBooKEmpty"  class="devForbizTpl empty-content">
                <h3>등록된 배송지가 없습니다.</h3>
            </li>
        </ul>
        <div class="br__more" id="devPageWrap"></div>
    </div>
</div>

<div class="address-select__btn btn-add-address">
    <a href="javascript:void(0)" id="devAddressBookAddBtn" class="join__email__check-btn">새 배송지 추가</a>
</div>