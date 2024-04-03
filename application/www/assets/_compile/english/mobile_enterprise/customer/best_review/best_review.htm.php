<?php /* Template_ 2.2.8 2021/11/18 15:33:08 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/customer/best_review/best_review.htm 000015217 */ 
$TPL_reviewBanner_1=empty($TPL_VAR["reviewBanner"])||!is_array($TPL_VAR["reviewBanner"])?0:count($TPL_VAR["reviewBanner"]);?>
<!-- crema load -->
<script>
        var crema_userId = null;
    var crema_userNm = null;

<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
        crema_userId = "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["id"]?>";
        crema_userNm = "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["name"]?>";
<?php }?>

    window.cremaAsyncInit = function() { // init.js가 다운로드 & 실행된 후에 실행하는 함수
      //console.log("[CREMA] cremaAsyncInit() - EXECUTED!");
      crema.init(crema_userId, crema_userNm);
      //console.log("[CREMA] crema.init() - EXECUTED!");
    };

    (function(i,s,o,g,r,a,m){if(s.getElementById(g))<?php echo $TPL_VAR["return"]?>;a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.id=g;a.async=1;a.src=r;m.parentNode.insertBefore(a,m)})
    (window,document,'script','crema-jssdk','//<?php echo CREMA_WIDGET_HOST?>/getbarrel.com/mobile/init.js');
</script>
<?php if($TPL_VAR["langType"]=='korean'){?>

<section class="br__best-review">
<?php if($TPL_VAR["reviewBanner"]){?>
    <figure class="br__best-review__mainVusual">
<?php if($TPL_reviewBanner_1){$TPL_I1=-1;foreach($TPL_VAR["reviewBanner"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
        <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
<?php }?>
<?php }}?>
    </figure>
<?php }?>
<?php if($TPL_VAR["reviewBanner2"]){?>
    <div  class="goods-review__best__kind">
        <a href="<?php echo $TPL_VAR["reviewBanner2"]["bannerLink"]?>"><img src="<?php echo $TPL_VAR["reviewBanner2"]["imgSrc"]?>" alt=""></a>
    </div>
<?php }?>

    <!--통이미지로 처리-->
    <!--<div class="best-review">-->
        <!--<h2 class="best-review__title">BEST <span>REVIEW</span></h2>-->
        <!--<p class="best-review__desc">Every month <strong>last Thursday</strong>, we select the best reviews.</p>-->
        <!--<div class="best-review__rank">-->
            <!--<dl class="best-review__rank__box">-->
                <!--<dt>영문몰해당없음</dt>-->
                <!--<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><span>50,000</span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>-->
            <!--</dl>-->
            <!--<dl class="best-review__rank__box">-->
                <!--<dt>영문몰해당없음</dt>-->
                <!--<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><span>20,000</span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>-->
            <!--</dl>-->
            <!--<dl class="best-review__rank__box">-->
                <!--<dt>영문몰해당없음</dt>-->
                <!--<dd><?php echo $TPL_VAR["fbUnit"]["f"]?><span>10,000</span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>-->
            <!--</dl>-->
        <!--</div>-->
        <!--<div class="best-review__type">-->
            <!--<dl class="best-review__type__box">-->
                <!--<dt>Reviews</dt>-->
                <!--<dd>Thank you for your comments.<strong></dd>-->
            <!--</dl>-->
            <!--<dl class="best-review__type__box">-->
                <!--<dt>Photo Reviews</dt>-->
                <!--<dd><span>글 50자 이상의 생생한 후기와 착용컷</span>을 남겨주시면 <span>5,000원</span>이 적립 됩니다.</dd>-->
            <!--</dl>-->
        <!--</div>-->
        <!--<p class="best-review__extra">※ Mileage given for reviews are for online purchases only.</p>-->
    <!--</div>-->

    <div class="crema-review">
        <h3 class="crema-review__title">Best Review</h3>
        <p class="crema-review__desc">Post a full-shot picture of yourself with a detailed review, and your chances go up.</p>
        <!--<p class="crema-review__desc">(english)매월 마지막 주 목요일 한 달간의 포토 후기 중</br> <strong>베스트 리뷰 TOP 3</strong>를 선정하여,</br> 상품 구매 시 사용할 수 있는 적립금을 드립니다.</p>-->
        <div id="crema-widget"></div>
    </div>

    <!-- 베스트 위젯 -->
    <style>.crema-reviews > iframe { max-width: 100% !important; }</style>
    <div class="crema-reviews" data-widget-id="34"></div>

    <div class="best-review__notice">
        <h4 class="best-review__notice__title">Non-assetable Condition</h4>
        <ul class="best-review__notice__list">
            <li class="best-review__notice__desc">·리뷰 작성시 수정이 안되오니 이점 참고 부탁 드립니다.</li>
            <li class="best-review__notice__desc">·상품 품절시 리뷰 적용이 안되어 적립금 지급이 안되오니 이점 양해 부탁 드립니다.</li>

            <li class="best-review__notice__desc">For the cases when a same review comment is used again(copy/paste), the reward will be given only once.</li>
            <li class="best-review__notice__desc">· 50 letters does not include space, symbols,letters which are not a 'word'; Chinese characters and numbers are counted as a one letter each.</li>
            <li class="best-review__notice__desc">If the delivery date has passed more than 30days.</li>
            <li class="best-review__notice__desc">Reward is not paid for post a review after purchase as non-member. (Only for members)</li>
            <li class="best-review__notice__desc">Reward is not paid for post a review after purchase as non-member. (Only for members)</li>
            <li class="best-review__notice__desc">When the price of the product is less than $10, reward cannot be given.</li>
            <li class="best-review__notice__desc">·배럴 SALE 상품 구매 시 구매후기 작성 및 후기작성으로 인한 적립금 지급 불가.</li>
            <li class="best-review__notice__desc">·이벤트 진행 시 해당 상품 구매에 대한 후기 적립금은 조정될 수 있습니다.</li>
        </ul>
    </div>

    <div class="crema-review">
        <h3 class="crema-review__title">Photo Review</h3>
        <div class='crema-reviews' data-widget-id='27'></div>
    </div>

    <div class="crema-review">
        <h3 class="crema-review__title">Review</h3>
        <div class='crema-reviews'></div>
    </div>
</section>
<?php }else{?>
<!--상품후기-->
<form id="devProductReviewForm">
    <input type="hidden" name="id" value="<?php echo $TPL_VAR["pid"]?>"/>
    <input type="hidden" name="orderBy" value="real_regdate"/>
    <input type="hidden" name="orderByType" value="desc"/>
    <input type="hidden" name="bbsDiv" value=""/>
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="3" id="devMax"/>
</form>

<section class="br__best-review">
    <div class="best-review">
       <h2 class="br__cs__title"><span>Review</span></h2>
        <!--<p class="best-review__desc">Every month <strong>last Thursday</strong>, we select the best reviews.</p>-->
        <!--<div class="best-review__rank">-->
            <!--<dl class="best-review__rank__box">-->
                <!--<dt>영문몰해당없음</dt>-->
                <!--<dd><span>50,000</span>Won</dd>-->
            <!--</dl>-->
            <!--<dl class="best-review__rank__box">-->
                <!--<dt>영문몰해당없음</dt>-->
                <!--<dd><span>20,000</span>Won</dd>-->
            <!--</dl>-->
            <!--<dl class="best-review__rank__box">-->
                <!--<dt>영문몰해당없음</dt>-->
                <!--<dd><span>10,000</span>Won</dd>-->
            <!--</dl>-->
        <!--</div>-->
        <!--<div class="best-review__type">-->
            <!--<dl class="best-review__type__box">-->
                <!--<dt>Reviews</dt>-->
                <!--<dd>Thank you for your comments.<strong></dd>-->
            <!--</dl>-->
            <!--<dl class="best-review__type__box">-->
                <!--<dt>Photo Reviews</dt>-->
                <!--<dd><span>글 50자 이상의 생생한 후기와 착용컷</span>을 남겨주시면 <span>5,000원</span>이 적립 됩니다.</dd>-->
            <!--</dl>-->
        <!--</div>-->
        <!--<p class="best-review__extra">※ Mileage given for reviews are for online purchases only.</p>-->
    </div>

    <!--<div class="crema-review">
        <h3 class="crema-review__title">Best Review</h3>
        <p class="crema-review__desc">영문몰해당없음</p>
        <div class='crema-reviews' data-widget-id='29'></div>
    </div>-->

    <div class="best-review__notice" <?php if($TPL_VAR["langType"]!='korean'){?>style="margin-top:0;"<?php }?>>
        <h4 class="best-review__notice__title">Non-assetable Condition</h4>
        <ul class="best-review__notice__list">
            <li class="best-review__notice__desc">For the cases when a same review comment is used again(copy/paste), the reward will be given only once.</li>
            <li class="best-review__notice__desc">When the product is bought from offline stores or the other website.</li>
            <li class="best-review__notice__desc">If the delivery date has passed more than 30days.</li>
            <li class="best-review__notice__desc">Reward is not paid for post a review after purchase as non-member. (Only for members)</li>
            <li class="best-review__notice__desc">Reward is not paid for post a review after purchase as non-member. (Only for members)</li>
            <li class="best-review__notice__desc">When the price of the product is less than $10, reward cannot be given.</li>
            <li class="best-review__notice__desc">·배럴 SALE 상품 구매 시 구매후기 작성 및 후기작성으로 인한 적립금 지급 불가.</li>
        </ul>
    </div>

    <div class="tab-review">
        <div class="top-area">
            <p class="title">Customer Satisfaction</p>
            <div class="total-score">
                            <span class="set-star big">
                                <span class="score" style="width:<?php echo $TPL_VAR["avg"]["avgPct"]?>%"></span>
                            </span>
                <em><?php echo $TPL_VAR["avg"]["avg"]?></em>
            </div>
            <div class="total-score type2">
                <span>
                    <span>Product</span>
                    <span class="set-star gray">
                        <span class="score" style="width:<?php echo $TPL_VAR["avg"]["goodsAvgPct"]?>%"></span>
                    </span>
                    <em><?php echo $TPL_VAR["avg"]["goodsAvg"]?></em>
                </span>
                <span>
                    <span>Shipping</span>
                    <span class="set-star gray">
                        <span class="score" style="width:<?php echo $TPL_VAR["avg"]["deliveryAvgPct"]?>%"></span>
                    </span>
                    <em><?php echo $TPL_VAR["avg"]["deliveryAvg"]?></em>
                </span>
            </div>
        </div>

        <div class="review-content">
            <div class="top">
                <div class="review-tab tab-js">
                    <a class="devReviewsDiv active" data-bbsdiv="">All<em><?php echo number_format($TPL_VAR["allReviewTotal"])?></em></a>
                    <a class="devReviewsDiv" data-bbsdiv="2">Reviews<em><?php echo number_format($TPL_VAR["reviewTotal"])?></em></a>
                    <a class="devReviewsDiv" data-bbsdiv="1">Photo Reviews<em><?php echo number_format($TPL_VAR["premiumReviewTotal"])?></em></a>
                </div>
                <div class="detail-info-sorting jq-radio">
                    <a class="devSort on" data-orderby="real_regdate" data-sort="desc">Recent</a>
                    <a class="devSort" data-orderby="avg" data-sort="asc">Lowest rate</a>
                    <a class="devSort" data-orderby="avg" data-sort="desc">Highest rate</a>
                </div>
            </div>

            <div class="wrap-tab-cont review-list">
                <div id="review-tab1" class="active">
                    <ul id="devReviewContents">
                        <li id="devReviewLoading">
                            <div class="empty-content">
                                Loading...
                            </div>
                        </li>

                        <li id="devReviewEmpty">
                            <div class="empty-content">
                                No product review
                            </div>
                        </li>

                        <li id="devReviewDetail">
                            <div class="review toggle devReviewDetailContents">
                                <span class="set-star">
                                                    <span class="score" style="width:{[avg_pct]}%"></span>
                                                </span>
                                <span class="user">{[bbs_id]}</span>
                                <span class="date">{[regdate]}</span>

                                <p class="option">{[pname]}</p>
                                {[#if isThumb]}<span class="thumb"><img src="{[thumb]}"></span>{[/if]}
                                <p class="tit">{[bbs_subject]}</p>
                            </div>
                            <div class="review-detail">
                                <div class="wrap-score">
                                    <span>Product evaluation <img src="<?php echo $TPL_VAR["templet_src"]?>/img/icon/m_star_s_{[valuation_goods]}.png">{[valuation_goods]}</span>
                                    <span>Shipping Evaluation <img src="<?php echo $TPL_VAR["templet_src"]?>/img/icon/m_star_s_{[valuation_delivery]}.png">{[valuation_delivery]}</span>
                                </div>
                                <div class="content">{[bbs_contents]}</div>
                                <div class="review-img-area">
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper" id="devReviewImgsContents">
                                            <div class="swiper-slide devReviewImgs" id="devReviewImgsDetails" data-bbsIx="{[bbsIx]}" data-index="{[index]}">
                                                <img src="{[img]}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {[#if cmt.cmt_ix]}
                                <div class="admin_comment">
                                    <p class="info"><span>{[cmt.cmt_name]}</span>{[cmt.cmt_date]}</p>
                                    <div class="comment">
                                        {[{cmt.cmt_contents}]}
                                    </div>
                                </div>
                                {[/if]}
                            </div>
                        </li>
                    </ul>
                    <div class="wrap-btn-area more" id="devReviewPageWrap"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php }?>