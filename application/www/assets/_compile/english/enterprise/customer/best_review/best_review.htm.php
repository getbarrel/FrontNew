<?php /* Template_ 2.2.8 2021/11/18 15:33:03 /home/barrel-stage/application/www/assets/templet/enterprise/customer/best_review/best_review.htm 000017649 */ ?>
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
    (window,document,'script','crema-jssdk','//<?php echo CREMA_WIDGET_HOST?>/getbarrel.com/init.js');
</script>
<?php if($TPL_VAR["langType"]=='korean'){?>

<!-- [E] -->
<section class="fb__best-review">
<?php $this->print_("customerTop",$TPL_SCP,1);?>

      <div class="best-review">
            <h2 class="fb__best-review__title">Product Reviews</h2>
            <section class="best-review__top">
                  <h3 class="best-review__title">BEST REVIEW</h3>
                  <p class="best-review__desc">Every last Thursday of every month, we select Best Review .</p>
                  <div class="best-review__rank">
                        <dl class="best-review__rank__box">
                              <dt><em>1st</em>Place</dt>
                              <dd><em>50,000</em>원</dd>
                        </dl>
                        <dl class="best-review__rank__box">
                              <dt><em>2nd</em>Place</dt>
                              <dd><em>20,000</em>원</dd>
                        </dl>
                        <dl class="best-review__rank__box">
                              <dt><em>3rd</em>Place</dt>
                              <dd><em>10,000</em>원</dd>
                        </dl>
                  </div>
                  <!-- 베스트 위젯 -->
                  <div class="crema-reviews" data-widget-id="35"></div>

                  <div class="best-review__type">
                        <dl class="best-review__type__box">
                              <dt>Reviews</dt>
                              <dd>Thank you for real comment.</dd>
                        </dl>
                        <dl class="best-review__type__box">
                              <dt>Photo Reviews</dt>
                              <dd>글 50자 이상의 생생한 후기와<br>착용컷을 남겨주시면 5,000원이 적립 됩니다.</dd>
                        </dl>
                  </div>
<?php if($TPL_VAR["reviewBanner2"]){?>
                <div  class="review-guide__type">
                    <a href="<?php echo $TPL_VAR["reviewBanner2"]["bannerLink"]?>"><img src="<?php echo $TPL_VAR["reviewBanner2"]["imgSrc"]?>" style="width:100%;" alt=""></a>
                </div>
<?php }?>
                  <p class="best-review__desc--light">Review reward can be used for only online order</p>
            </section>

            <!--후기목록영역-->
            <div id="crema-widget"></div>

            <div class="best-review__notice">
                  <h4 class="best-review__notice__title">Non-assetable Condition</h4>
                  <ul class="best-review__notice__list">
                        <li class="best-review__notice__desc">리뷰 작성시 수정이 안되오니 이점 참고 부탁 드립니다.</li>
                        <li class="best-review__notice__desc">상품 품절시 리뷰 적용이 안되어 적립금 지급이 안되오니 이점 양해 부탁 드립니다.</li>
                        <li class="best-review__notice__desc">For the cases when a same review comment is used again(copy/paste), the reward will be given only once.</li>
                        <li class="best-review__notice__desc">50 letters does not include space, symbols, etters which are not a 'word'; Chinese characters and numbers are counted as a one letter each.</li>
                        <li class="best-review__notice__desc">When the product is bought from offline stores or the other website.</li>
                        <li class="best-review__notice__desc">If the delivery date has passed more than 30days.</li>
                        <li class="best-review__notice__desc">Reward is not paid for post a review after purchase as non-member. (Only for members)</li>
                        <li class="best-review__notice__desc">When the price of the product is less than $10, reward cannot be given.</li>
                        <li class="best-review__notice__desc">배럴 SALE 상품 구매 시 구매후기 작성 및 후기작성으로 인한 적립금 지급 불가</li>
                        <li class="best-review__notice__desc">이벤트 진행 시 해당 상품 구매에 대한 후기 적립금은 조정될 수 있습니다.</li>
                  </ul>
            </div>

            <!--포토리뷰영역-->
            <div class="best-review__crema crema-reviews" data-widget-id='27'></div>
            <!--모든리뷰목록영역-->
            <div class="best-review__crema crema-reviews"></div>
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

<section class="fb__best-review fb__goods-view__detail">
<?php $this->print_("customerTop",$TPL_SCP,1);?>

      <div class="best-review detail__main">
            <h2 class="fb__best-review__title">Product Reviews</h2>
            <section class="best-review__type__wrap eng-hidden">
                  <div class="best-review__type">
                        <dl class="best-review__type__box">
                              <dt>Reviews</dt>
                              <dd>Thank you for real comment.</dd>
                        </dl>
                        <dl class="best-review__type__box">
                              <dt>Photo Reviews</dt>
                              <dd>글 50자 이상의 생생한 후기와<br>착용컷을 남겨주시면 5,000원이 적립 됩니다.</dd>
                        </dl>
                  </div>
                  <p class="best-review__desc--light">Review reward can be used for only online order</p>
            </section>

            <!-- @TODO 제품후기 리스트 (상품상세 참조) -->
            <section class="tab-review" style="margin-top:50px;">
                  <div class="tab-review__content">
                        <div class="tab-review__content review-content">
                              <div class="sort-list top">
                                    <div class="sort-list__tab review-tab tab-js">
                                          <a href="#review-tab1" class="devReviewsDiv active" data-bbsdiv="0">
                                                All review<em class="sj__n"><?php echo number_format($TPL_VAR["allReviewTotal"])?></em>
                                          </a>
                                          <a href="#review-tab1" class="devReviewsDiv" data-bbsdiv="2">
                                                Reviews<em class="sj__n"> <?php echo number_format($TPL_VAR["reviewTotal"])?></em>
                                          </a>
                                          <a href="#review-tab1" class="devReviewsDiv eng-hidden" data-bbsdiv="1">
                                                Photo Reviews<em class="sj__n"><?php echo number_format($TPL_VAR["premiumReviewTotal"])?></em>
                                          </a>
                                    </div>

                                    <select class="sort-list__select devSort" title="후기 정렬">
                                          <option value="real_regdate" data-sort="desc">Recent</option>
                                          <option value="avg" data-sort="asc">Lowest rate</option>
                                          <option value="avg" data-sort="desc">Highest rate</option>
                                    </select>
                              </div>

                              <div class="tab-review__list  wrap-tab-cont review-list">
                                    <div id="review-tab1" class="active">
                                          <ul id="devReviewContents">
                                                <li class="empty-content" id="devReviewLoading">
                                                      <div class="wrap-loading">
                                                            <div class="loading"></div>
                                                      </div>
                                                </li>

                                                <li class="empty-content" id="devReviewEmpty">No product review</li>

                                                <li id="devReviewDetail">
                                                      <div class="review devReviewDetailContents" data-bbsIx="{[bbs_ix]}" data-video_idx="{[video_idx]}" data-bbs_subject="{[bbs_subject]}">
                                                            <div class="review__wrap-star col star">
                                                                  <div class="review__star-inner">
                                    <span class="set-star">
                                        <span class="score devStarScore" data-avg_pct="{[avg_pct]}" ></span>
                                    </span>
                                                                  </div>
                                                            </div>
                                                            <div class="review__wrap-info col info">
                                                                  {[#if isThumb]}
                                                                  <figure class="{[#if isVideo]}wrap-video video-play{[else]}wrap-thumb{[/if]}">
                                                                        <img src="{[thumb]}" alt="{[bbs_subject]}">
                                                                  </figure>
                                                                  {[/if]}
                                                                  <div class="review__wrap-info__text--normal devViewVideoReview" data-video_idx="{[video_idx]}">
                                                                        <p class="review__wrap-info__option">{[option_name]}</p>
                                                                        <p class="review__wrap-info__title">{[bbs_subject]}</p>
                                                                  </div>
                                                            </div>
                                                            <div class="review__wrap-user col user">
                                                                  <span>{[bbs_id]}</span>
                                                            </div>
                                                            <div class="review__wrap-date col date">
                                                                  <span>{[regdate]}</span>
                                                            </div>
                                                      </div>

                                                      <div class="review-detail" id="devDetailView_{[video_idx]}">
                                                            <div class="review-detail__top wrap-score">
                                                                  <div class="review-detail__wrap-score">
                                                                        <span class="review-detail__title">Product evaluation</span>
                                                                        <span class="col star">
                                        <span class="set-star">
                                            <span class="score devStarScore" data-avg_pct="{[valuation_goods_pct]}" ></span>
                                        </span>
                                    </span>
                                                                        <!--<img {[valuation_goods_pct]}>-->
                                                                  </div>
                                                                  <span class="review-detail__wrap-score">
                                    <span class="review-detail__title">Shipping Evaluation</span>
                                    <span class="col star">
                                        <span class="set-star">
                                            <span class="score devStarScore" data-avg_pct="{[valuation_delivery_pct]}" ></span>
                                        </span>
                                    </span>
                                </span>
                                                                  <!--<img class="score_{[valuation_delivery_pct]}" {[valuation_delivery_pct]}>-->
                                                            </div>
                                                            <div class="review-detail__content content">{[{bbs_contents}]}</div>
                                                            {[#if isThumb]}
                                                            <div class="review-detail__img-area review-img-area" id="devReviewImgsContents">
                                                                  <figure class="review-detail__thumb thumb devViewReviewImg" id="devReviewImgsDetails" data-bbsIx="{[bbsIx]}" data-index="{[index]}">
                                                                        <img src = "{[img]}" alt="goods thumbnail">
                                                                  </figure>
                                                            </div>
                                                            {[/if]}

                                                            <!--어드민 댓글-->
                                                            {[#if cmt.cmt_ix]}
                                                            <div class="review-detail__admin-comment admin_comment">
                                                                  <p class="review-detail__admin-info">
                                                                        <span class="review-detail__admin-info__title">{[cmt.cmt_name]}</span>
                                                                        <span class="review-detail__admin-info__date">{[cmt.cmt_date]}</span>
                                                                  </p>
                                                                  <div class="review-detail__admin-text comment">
                                                                        {[{cmt.cmt_contents}]}
                                                                  </div>
                                                            </div>
                                                            {[/if]}
                                                      </div>
                                                </li>

                                          </ul>

                                          <div class="wrap-pagination" id="devReviewPageWrap"></div>
                                    </div>
                              </div>


                        </div>
                  </div>
            </section>



            <div class="best-review__notice">
                  <h4 class="best-review__notice__title">Non-assetable Condition</h4>
                  <ul class="best-review__notice__list">
                        <li class="best-review__notice__desc">For the cases when a same review comment is used again(copy/paste), the reward will be given only once.</li>
                        <li class="best-review__notice__desc eng-hidden">50 letters does not include space, symbols, etters which are not a 'word'; Chinese characters and numbers are counted as a one letter each.</li>
                        <li class="best-review__notice__desc">When the product is bought from offline stores or the other website.</li>
                        <li class="best-review__notice__desc">If the delivery date has passed more than 30days.</li>
                        <li class="best-review__notice__desc">Reward is not paid for post a review after purchase as non-member. (Only for members)</li>
                        <li class="best-review__notice__desc">When the price of the product is less than $10, reward cannot be given.</li>
                        <li class="best-review__notice__desc">배럴 SALE 상품 구매 시 구매후기 작성 및 후기작성으로 인한 적립금 지급 불가</li>
                  </ul>
            </div>

      </div>
</section>

<?php }?>