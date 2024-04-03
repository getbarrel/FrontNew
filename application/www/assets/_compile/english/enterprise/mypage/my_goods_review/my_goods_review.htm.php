<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/my_goods_review/my_goods_review.htm 000006700 */ ?>
<link rel="stylesheet" href="/assets/templet/enterprise/js/themes/base/ui.all.css">

<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<div class="wrap-mypage fb__mypage">
    <form id="devMyReviewForm">
        <section class="fb__mypage__search">
            <h2 class="fb__mypage__title">Search</h2>
            <input type="hidden" name="page" value="1" id="devPage"/>
            <input type="hidden" name="max" value="10" id="devMax"/>
            <input type="hidden" name="sDateDef" id="sDateDef" value="<?php echo $TPL_VAR["sDate"]?>" />
            <input type="hidden" name="eDateDef" id="eDateDef" value="<?php echo $TPL_VAR["eDate"]?>" />

            <div class="search ">
                <div class="search__row ">
                    <div class="search__col">
                        <span class="search__col-title">Period</span>
                        <input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick" title="조회시작기간">
                        ~
                        <input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick"  title="조회종료기간">
                    </div>
                    <div class="search__col__day">
                        <div class="day-radio">
                            <a href="#" class="day-radio__btn today devDateBtn" data-sdate="<?php echo $TPL_VAR["today"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">Today</a>
                            <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneWeek"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>1</em> week</a>
                            <a href="#" class="day-radio__btn devDateBtn day-radio--active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="devDateDefault"><em>1</em> month</a>
                            <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>6</em> months</a>
                            <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>1</em> year</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search__btn">
                <a href="#" id="devBtnReset" class="search__btn--cancel">Reset</a>
                <input type="button" id="devBtnSearch" value="Search" title="Search" class="search__btn--search">
            </div>
        </section>
    </form>

    <form id="devForm1">
        <input type = "hidden" name="bbsIx" id="bbsIx" value="" />
    </form>

    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title">
            My postings
            <span class="fb__mypage__title--detail">
                Total <em id="devTotal"></em>  
            </span>
        </h2>
        <table class="table-default bbs-table myreview__table" id="tplMyReview">
            <colgroup>
                <col width="*">
                <col width="15%">
                <col width="13%">
                <col width="10%">
            </colgroup>
            <thead>
            <th>Reviews</th>
            <th>GPA</th>
            <th>reporting date</th>
            <th></th>
            </thead>
            <tbody id="devMyReviewContent">
            <tr class="devForbizTpl {[#if cmt]}has-comment  {[/if]}" id="devMyReviewList">
                <td>
                    <div class="product-review-area">
                        {[#if isSale]}
                        <a href="/shop/goodsView/{[pid]}" class="myreview__title" target="_blank">
                            {[else]}
                            <a href="javascript:void(0)" class="myreview__title">
                                {[/if]}
                                <span>{[#if brand_name]}[{[brand_name]}]&nbsp;{[/if]}{[pname]}</span>
                                <span>옵션 : {[option_name]} {[pcnt]}</span>
                            </a>
                            <div class="wrap-review detail-link">
                                {[#if isThumb]}
                                <!--영상일때 재생 버튼 처리해주세요 -->
                                <div class="{[#if isVideo]} myreview__video video-play {[else]} thumb {[/if]}">
                                    <img src="{[thumb]}" alt="{[bbs_subject]}">
                                </div>
                                {[/if]}
                                <div class="txt-area" data-bbsix="{[bbs_ix]}">
                                    <p class="tit">{[bbs_subject]}</p>
                                    <p class="content">{[{bbs_contents}]}</p>
                                </div>
                            </div>
                    </div>
                </td>
                <td>
                        <span class="set-star">
                            <span class="score" data-width="{[avg_pct]}%" style="width:{[avg_pct]}%"></span>
                        </span>
                    <p class="rating-txt">{[avg]}</p>
                </td>
                <td>
                    <span class="fb__n">{[regdate]}</span>
                </td>
                <td>
                    <button class="myreview__edit">수정</button>
                </td>
            </tr>

            <tr class="devForbizTpl" id="devMyReviewCmt">
                <td colspan="4" class="review-comment-area">
                    <p><em>관리자 댓글</em> {[cmt_name]} <span>{[cmt_date]}</span></p>
                    <div class="comment-content comment-content__admin">
                        {[{cmt_contents}]}
                    </div>
                </td>
            </tr>

            <tr id="devMyReviewLoading" class="devForbizTpl">
                <td colspan="4">
                    <div class="wrap-loading">
                        <div class="loading"></div>
                    </div>
                </td>
            </tr>
            <tr id="devMyReviewListEmpty" class="devForbizTpl">
                <td colspan="4">
                    <div class="empty-content">
                        <p>There are no product reviews.</p>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </section>
    <div id="devPageWrap"></div>

</div>