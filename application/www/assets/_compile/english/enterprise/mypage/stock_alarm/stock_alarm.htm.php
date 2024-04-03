<?php /* Template_ 2.2.8 2021/08/09 17:14:28 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/stock_alarm/stock_alarm.htm 000005093 */ ?>
<?php if(!$TPL_VAR["nonMemberOid"]){?><?php $this->print_("mypage_top",$TPL_SCP,1);?>

<?php }?>
<section class="fb__stock-alarm">
    <form id="devListForm">
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="10" />
    </form>

    <h2 class="fb__stock-alarm__title">Request for restock <span class="fb__stock-alarm__total">All <span class="fb__stock-alarm__total--count" id="devAlarmTotal">0</span></span></h2>
    <div class="fb__stock-alarm__list">
        <table class="table-default alarm-list">
            <colgroup> 
                <col width="130px">
                <col width="*">
				<col width="130px">
                <col width="130px">
                <col width="86px">
            </colgroup>
            <thead>
                <tr>
                    <th>Application date</th>
                    <th>Product Name</th>
                    <th>Notification Period</th>
					<th>재입고상태</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="devListContents">
            <tr id="devListEmpty">
                <td class="empty-content" colspan="4">
                    <p>No restock notification</p>

                    <!--<button class="btn-default btn-dark" id="devMoveHome">Home</button>-->
                </td>

            </tr>

            <tr id="devListLoading">
                <td colspan="4">&nbsp;</td>
            </tr>

            <tr id="devListDetail">
                <td class="alarm-list__date">{[regdateYmd]}</td>
                <td class="alarm-list__goods">
                    <figure class="alarm-list__goods__thumb">
                        <a href="/shop/goodsView/{[pid]}" class="alarm-list__goods__link">
                            <img src="{[image_src]}" alt="{[pname]}">
                        </a>
                    </figure>
                    <div class="alarm-list__goods__info">
                        <a href="/shop/goodsView/{[pid]}" class="alarm-list__goods__link">
                            <p class="alarm-list__goods__pname">{[pname]}</p>
                            <p class="alarm-list__goods__option">{[optionDiv]}</p>
                            <p class="alarm-list__goods__option">{[add_info]}</p>
                            <p class="alarm-list__goods__price">
                                {[#if discount_rate]}<span class="alarm-list__goods__price&#45;&#45;strike"><span class="hidden">Original Price</span> {[listprice]}원</span>{[/if]}
                                <span class="alarm-list__goods__price--cost"><span class="hidden">Price</span> <span>{[dcprice]}</span>원</span>
                                {[#if discount_rate]}<span class="alarm-list__goods__price--discount"><span class="hidden">Discount</span> {[discount_rate]}%</span>{[/if]}
                        </p>
                        </a>
                        <a href="#" class="alarm-list__goods__wish {[#if alreadyWish]}alarm-list__goods__wish--active{[/if]}" data-devWishBtn="{[id]}">
                            hart
                        </a>
                    </div>
                </td>
                <td class="alarm-list__term">{[regdateYmd]}<br> ~ {[expiration_date]}</td>
				<td class="alarm-list__term">{[rm_status_name]}</td>
                <td class="alarm-list__del"><button class="alarm-list__del__btn devDeleteReminder" data-srix="{[sr_ix]}"">delete button for Restock notification</button></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="use-notice">
        <h3 class="use-notice__title">Term of use</h3>
        <ul class="use-notice__list">
            <li class="use-notice__desc">Product information, such as price and option configuration of SMS requested products, may change, so please check product information upon re-purchase.</li>
            <li class="use-notice__desc">(english)SMS 알림은 요청일로부터 15일간 유효하며 재입고된 상품 알림 문자는 1회 발송되오니 고객님께서 확인 못하신 입고 알림을 다시 받고 싶으실 경우,<br /> 재신청해 주시기 바랍니다.</li>
            <li class="use-notice__desc">Popular products may be sold out early after SMS notification.</li>
            <li class="use-notice__desc">You may not receive SMS notifications when you refuse to receive or spam from your mobile phone.</li>
            <li class="use-notice__desc">(english)기본 휴대폰으로 알림을 신청하신 경우, 해당 휴대폰 번호로 안내드리며, 신청 후 휴대폰 번호 변경을 원하시는 경우 재입고 알림을 다시 신청해주시기<br />바랍니다.</li>
            <li class="use-notice__desc">Items that have passed 3 months since the notification application and products that have been sold will be automatically deleted.</li>
        </ul>
    </div>

</section>