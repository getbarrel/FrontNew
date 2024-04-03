<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/addressbook/addressbook.htm 000003758 */ ?>
<form id="devAddressBookForm">
	<input type="hidden" name="page" value="1" id="devPage"/>
	<input type="hidden" name="max" value="100" />
</form>

<!--<h1 class="wrap-title">
	배송지 관리
	<button class="back"></button>
</h1>-->

<section class="br__mypage br__address">
	<div class="br__mypage__pass">
		<p class="pass-title">Edit Addresses</p>
	</div>
	<div class="br__address__group">
		List of shipping address
	</div>

	<ul class="br__address__list" id="devAddressBooKContent">
		<li class="devForbizTpl" id="devAddressBooKList">
			<p class="address_tit">{[recipient]} {[#if default_yn]}<span>&#40;Default&#41;</span>{[/if]}</p>
			<p class="address_name">{[recipient]}</p>
			<p class="address_info">
				{[#if nation_name]}
				{[nation_name]} <br>
				{[/if]}
				{[address1]}<br/>{[address2]}
			</p>
			<p class="address_phone">{[mobile]} {[#if tel]} <span></span> {[tel]}{[/if]}</p>
			<div class="br__address__btn">
				{[#if default_yn]}
				{[else]}
				<button type="button" class="address__btn-del devAddressBookDelete" data-ix="{[ix]}">Delete</button>
				{[/if]}
				<a class="address__btn-modi" href="/mypage/addressbookManage/{[ix]}">Edit</a>
			</div>
		</li>

		<li class="devForbizTpl" id="devAddressBooKEmpty">
			<p class="address_empty">Registering shipping address is convenient because you do not need to enter shipping address every time you purchase the product.</p>
		</li>

		<li class="empty-content devForbizTpl" id="devAddressBooKLoading">
			<p class="address_empty">Loading...</p>
		</li>

	</ul>

	<div class="br__join br__address">
		<div class="join__email__check">
			<input type="hidden" name="devIsInsert" id="devIsInsert">
<?php if($TPL_VAR["langType"]=='korean'){?>
			<a href="javascript:void(0)" id="devAddressBookAddBtn" class="join__email__check-btn">Add New Address</a>
<?php }else{?>
			<a href="javascript:void(0)" id="devAddressBookAddBtn" class="join__email__check-btn">Add New Address</a>
<?php }?>
		</div>
	</div>

	<ul class="br__address__manage">
		<li>
			<div class="br__address__manage-box">
				Address list management
			</div>
			<div class="br__address__manage-info">
				<p class="manage-info-txt">You can manage the address information you want to use when purchasing the product.</p>
				<p class="manage-info-txt">A maximum of 10 shipping addresses can be registered and will be automatically updated based on the most recent shipping address book unless registered separately.</p>
			</div>
		</li>
	</ul>
</section>


<?php if(false){?>
<div class="wrap-mypage">
	<ul class="wrap-address-list" id="devAddressBooKContent">
		<li class="devForbizTpl" id="devAddressBooKList">
			<div class="address">
				<p class="tit">{[recipient]}{[#if shipping_name]}[{[shipping_name]}]{[/if]} {[#if default_yn]}<em>address</em>{[/if]}</p>
				<p class="sub">
					{[address1]}<br>{[address2]}
				</p>
				<p class="sub font-rb">{[mobile]} {[#if tel]}/ {[tel]}{[/if]}</p>
			</div>
			<div class="address-btn-area">
				<a class="btn-xs btn-point-line" href="/mypage/addressbookManage/{[ix]}">Edit</a>
				{[#if default_yn]}
				{[else]}
				<button type="button" class="btn-xs btn-white devAddressBookDelete" data-ix="{[ix]}">Delete</button>
				{[/if]}
			</div>
		</li>

		<li class="empty-content devForbizTpl" id="devAddressBooKEmpty">
			<p>No shipping address</p>
		</li>

		<li class="empty-content devForbizTpl" id="devAddressBooKLoading">
			<p>Loading...</p>
		</li>

	</ul>

	<div class="wrap-btn-area">
		<a href="/mypage/addressbookManage" class="btn-lg btn-point">Add New Address</a>
	</div>
</div>
<?php }?>