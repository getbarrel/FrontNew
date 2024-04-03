<?php /* Template_ 2.2.8 2021/08/09 17:16:56 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/stock_alarm/stock_alarm.htm 000005761 */ ?>
<section class="br__stock-alarm">
    <div class="br__mypage__pass">
        <h2 class="pass-title">Restock notification</h2>
    </div>

    <form id="devListForm">
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="10" />
    </form>
    <div class="stock-alarm" >
        <p class="stock-alarm__count">총 <span id="devAlarmTotal">0</span>건</p>
        <ul class="stock-alarm__list" id="devListContents">
            <li class="devForbizTpl empty-content" id="devListEmpty">
                <p>No restock notification history</p>
                <!--<a href="/" class="empty-content__btn">Home</a>-->
            </li>

            <li class="devForbizTpl" id="devListLoading"></li>

            <li class="devForbizTpl stock-alarm__box" id="devListDetail">
                <div class="stock-alarm__goods">
                    <a href="/shop/goodsView/{[pid]}" class="stock-alarm__thumb">
                        <figure>
                            <img src="{[image_src]}" alt="{[pname]}">
                        </figure>
                    </a>
                    <div class="stock-alarm__info">
                        <p class="stock-alarm__title"><a href="/shop/goodsView/{[pid]}">{[pname]}</a></p>
                        <p class="stock-alarm__option">{[optionDiv]}</p>
                        <p class="stock-alarm__option">{[add_info]}</p>
                        <div class="stock-alarm__price">
                            {[#if discount_rate]}<span class="stock-alarm__price__strike"><?php echo $TPL_VAR["fbUnit"]["f"]?>{[listprice]}<?php echo $TPL_VAR["fbUnit"]["b"]?></span>{[/if]}
                            <span class="stock-alarm__price__cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><span>{[dcprice]}</span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            {[#if discount_rate]} <span class="stock-alarm__price__discount">[{[discount_rate]}%]</span>{[/if]}
                        </div>
                       <label class="br__add-wish {[#if alreadyWish]}on{[/if]}" devwishbtn="{[id]}">
                            {[#if alreadyWish]}
                            <input type="checkbox" class="br__add-wish__btn" checked>
                            {[else]}
                            <input type="checkbox" class="br__add-wish__btn">
                            {[/if]}
                        </label>
                    </div>
                </div>
                <div class="stock-alarm__date__wrap">
                    <dl class="stock-alarm__date">
                        <dt style="width:6rem;">Application date</dt>
                        <dd>{[regdateYmd]}</dd>
                    </dl>
                    <dl class="stock-alarm__date">
                        <dt style="width:6rem;">notification time</dt>
                        <dd>{[regdateYmd]} ~ {[expiration_date]}</dd>
                    </dl>
					<dl class="stock-alarm__date">
                        <dt style="width:6rem;">재입고상태</dt>
                        <dd>{[rm_status_name]}</dd>
                    </dl>
                    {[#if reminder_date]}
                    <dl class="stock-alarm__date">
                        <dt>notification time</dt>
                        <dd>{[reminder_date]}</dd>
                    </dl>
                    {[/if]}
                </div>
                <button class="stock-alarm__box__btn devDeleteReminder" data-srix="{[sr_ix]}">입고알림 삭제버튼</button>
            </li>

        </ul>
        <div class="br__more devPageBtnCls" id="devPageWrap"></div>
        <div class="br__faq__content">
            <dl class="br__faq__list">
                <dt class="br__faq__question br__faq__question--opened">
                        <span class="br__faq__name">
                             Term of use
                        </span>
                <p class="br__faq__title"></p>
                <span class="br__faq__icon--arrow">화살표아이콘</span>
                </dt>
                <dd class="br__faq__answer br__faq__answer--show">
                    <ul class="stock-alarm__guide">
                        <li class="stock-alarm__guide__desc">&middot; Product information, such as price and option configuration of SMS requested products, may change, so please check product information upon re-purchase.</li>
                        <li class="stock-alarm__guide__desc">&middot; SMS notifications are valid for 15 days from the date of request. Re-stocked items <br/> Notification text will be sent once. If you would like to receive another notification, please reapply.</li>
                        <li class="stock-alarm__guide__desc">&middot; Restock Notifications After sending SMS, popular items may be sold out early. <br/></li>
                        <li class="stock-alarm__guide__desc">&middot; You may not receive SMS notifications when you unsubscribe or spam on your mobile phone.</li>
                        <li class="stock-alarm__guide__desc">&middot; 기본 휴대폰으로 알림을 신청하신 경우, 해당 휴대폰 번호로<br/>안내드리며,신청 후 휴대폰 번호 변경을 원하시는 경우 재입고<br/>알림을 다시 신청해주시기 바랍니다.</li>
                        <li class="stock-alarm__guide__desc">&middot; Items that have passed 3 months since the notification application and products that have been sold<br/>will be automatically deleted.</li>
                    </ul>
                </dd>
            </dl>
        </div>
    </div>
</section>