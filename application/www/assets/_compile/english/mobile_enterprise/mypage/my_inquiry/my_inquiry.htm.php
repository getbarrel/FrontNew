<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/my_inquiry/my_inquiry.htm 000002835 */ 
$TPL_bbsDiv_1=empty($TPL_VAR["bbsDiv"])||!is_array($TPL_VAR["bbsDiv"])?0:count($TPL_VAR["bbsDiv"]);?>
<!--
<h1 class="wrap-title">
    나의 1:1 문의 내역
    <button class="back"></button>
</h1>
-->

<!-- 1:1 문의 list -->
<section class="br__mypage br__myInquiry">
    <div class="br__mypage__pass">
        <p class="pass-title">1:1 Inquiry</p>
    </div>
    <form id="devMyInquiryForm">
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="20"/>
        <input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>"/>
        <input type="hidden" name="qType" value="" id="devQnaType"/>
        <div class="br__myInquiry__opt">
            <select id="devQnaType" class="devQnaTypeSelect">
<?php if($TPL_bbsDiv_1){foreach($TPL_VAR["bbsDiv"] as $TPL_V1){?>
                <option value="<?php echo $TPL_V1["div_ix"]?>"><?php echo trans($TPL_V1["div_name"])?></option>
<?php }}?>
            </select>
        </div>

        <div class="br__goods-view__tabs">
            <ul class="goods-qna__list list" id="devMyInquiryContent">
                <li id="devMyInquiryLoading">
                    <p class="qna-no-data">Loading...</p>
                </li>
                <li class="empty-content devForbizTpl" id="devMyInquiryEmpty">
                    <p class="qna-no-data">No inquiry history</p>
                </li>

                <li class="goods-qna__box devForbizTpl" id="devMyInquiryList">
                    <a href="/mypage/myInquiryDetail/{[bbs_ix]}" class="qna-info">
                        <div class="qna-info__info">
                            {[#if res_count]}
                            <span class="qna-info__state qna-info__state--point">{[qna_status]}</span>
                            {[else]}
                            <span class="qna-info__state">{[qna_status]}</span>
                            {[/if]}
                            <span class="qna-info__type">[{[div_name]}]</span>
                            <!--<span class="qna-info__name">필요 X</span>-->
                            <span class="qna-info__date">{[reg_date]}</span>
                        </div>
                        <p class="qna-info__title">{[bbs_subject]}</p>
                    </a>
                </li>
            </ul>
        </div>
        <div id="devPageWrap"></div>
        <div class="br__login__info">
            <div class="information__btn">
                <a href="/customer/qna" class="information__btn__nomem">
                    Write
                </a>
            </div>
        </div>
    </form>
</section>
<!-- EOD : 1:1 문의 list -->