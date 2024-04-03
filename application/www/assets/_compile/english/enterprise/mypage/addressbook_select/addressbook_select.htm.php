<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/addressbook_select/addressbook_select.htm 000000574 */ ?>
<form id="devAddressBookForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="3" />
</form>

<div class="wrap-window-popup address-popup">
    <p class="popup-title">
        <span>Change shipping address</span>
        <span class="close" onclick="window.close();"></span>
    </p>

<?php $this->print_("addressBookForm",$TPL_SCP,1);?>


</div>