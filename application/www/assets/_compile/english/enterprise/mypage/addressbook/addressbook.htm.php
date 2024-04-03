<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/addressbook/addressbook.htm 000003165 */ ?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<form id="devAddressBookForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="10" />
</form>

<section class="wrap-mypage fb__addressbook">
    <h2 class="fb__mypage__title" class="mat50">Edit Addresses</h2>
    <table class="table-default fb__addressbook__table">
        <colgroup>
            <col width="14%">
            <col width="*">
            <col width="15%">
            <col width="14%"  class="eng-hidden">
            <col width="11%">
        </colgroup>
        <thead>
        <tr>
            <th>Recipient</th>
            <th>Address</th>
            <th>Tel</th>
            <th class="eng-hidden">Name</th>
            <th></th>
        </tr>
        </thead>
        <tbody id="devAddressBooKContent">
        <tr id="devAddressBooKLoading"  class="devForbizTpl">
            <td colspan="4">
                <div class="wrap-loading">
                    <div class="loading"></div>
                </div>
            </td>
        </tr>
        <tr id="devAddressBooKList" class="devForbizTpl">
            <td>
                {[#if default_yn]}<span class="fb__addressbook__default-icon">Default</span>{[/if]}
                <p>{[recipient]}</p>
            </td>
            <td class="fb__addressbook__address">
                {[#if nation_name]}
                    {[nation_name]} <br>
                {[/if]}
                {[address1]}<br>{[address2]}

            </td>
            <td><p class="font-rb">{[mobile]}</p><p class="font-rb">{[tel]}</p></td>
            <td class="eng-hidden">
                {[#if shipping_name]}
                {[shipping_name]}
                {[else]}
                -
                {[/if]}
            </td>
            <td>
                <div class="td-btn-area">
                    <button class="btn-xs btn-dark devAddressBookModify" data-ix="{[ix]}">Edit</button>
                    <button class="btn-xs btn-white devAddressBookDelete" data-ix="{[ix]}" data-default_yn="{[default_yn]}">Delete</button>
                </div>
            </td>
        </tr>
        <tr id="devAddressBooKEmpty" class="devForbizTpl">
            <td colspan="5">
                <div class="empty-content">
                    <p>No shipping address</p>
                </div>
            </td>
        </tr>

        </tbody>
    </table>

    <div class="fb__addressbook__infoWarp mat10">
        <div class="fb__addressbook__info">
            <p>· You can manage the address information that you want to use when purchasing a product.</p>
            <p>· Up to 10 shipping address can be registered. If not registered, it will automatically be updated by your recent address book.</p>
        </div>
        <input type="hidden" name="devIsInsert" id="devIsInsert">
        <button class="btn-s btn-dark btn-add-pop" id="devAddressBookAddBtn">Add New Address</button>
    </div>

    <div id="devPageWrap"></div>
</section>