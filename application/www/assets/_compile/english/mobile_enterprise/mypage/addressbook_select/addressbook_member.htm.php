<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/addressbook_select/addressbook_member.htm 000002063 */ ?>
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
                    <span class="address-select__info__title">{[recipient]} {[#if default_yn]}<span>[Default]</span>{[/if]}</span>
                    <span class="address-select__info__name">{[recipient]}</span>
                    {[#if nation_name]}<p class="address-select__info__addr">{[nation_name]}</p>{[/if]}
                    <p class="address-select__info__addr">{[address1]} <br>{[address2]}</p>
                    {[#if city]}<p class="address-select__info__addr">{[city]}</p>{[/if]}
                    {[#if state]}<p class="address-select__info__addr">{[state]}</p>{[/if]}
                    <p class="address-select__info__phone">{[mobile]} / {[tel]}</p>
                </div>
                <div class="address-select__btn">
                    <button class="devAddressBookItemSelect" data-oid="<?php echo $TPL_VAR["oid"]?>" data-ix="{[ix]}">Select Address</button>
                </div>
            </li>
            <li id="devAddressBooKEmpty"  class="devForbizTpl empty-content">
                <h3>No shipping address</h3>
            </li>
        </ul>
        <div class="br__more" id="devPageWrap"></div>
    </div>
</div>

<div class="address-select__btn btn-add-address">
    <a href="javascript:void(0)" id="devAddressBookAddBtn" class="join__email__check-btn">Add New Address</a>
</div>