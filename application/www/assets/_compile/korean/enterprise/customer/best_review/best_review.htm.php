<?php /* Template_ 2.2.8 2023/12/14 09:28:26 /home/barrel-stage/application/www/assets/templet/enterprise/customer/best_review/best_review.htm 000017831 */ ?>
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
      <div class="best-review">
            <h2 class="fb__best-review__title">제품 후기</h2>
            <section class="best-review__top">
                  <h3 class="best-review__title">BEST REVIEW</h3>
                  <p class="best-review__desc">매달 마지막 주 목요일 마다 베스트리뷰를 선정합니다.</p>
                  <div class="best-review__rank">
                        <dl class="best-review__rank__box">
                              <dt><em>1</em>등</dt>
                              <dd><em>50,000</em>원</dd>
                        </dl>
                        <dl class="best-review__rank__box">
                              <dt><em>2</em>등</dt>
                              <dd><em>20,000</em>원</dd>
                        </dl>
                        <dl class="best-review__rank__box">
                              <dt><em>3</em>등</dt>
                              <dd><em>10,000</em>원</dd>
                        </dl>
                  </div>
                  <!-- 베스트 위젯 -->
                  <div class="crema-reviews" data-widget-id="35"></div>

                  <div class="best-review__type">
                        <dl class="best-review__type__box">
                              <dt>일반후기</dt>
                              <dd>글 50자 이상의 생생한 후기를<br> 남겨주시면 3,000원이 적립 됩니다.</dd>
                        </dl>
                        <dl class="best-review__type__box">
                              <dt>포토후기</dt>
                              <dd>글 50자 이상의 생생한 후기와<br>착용컷을 남겨주시면 5,000원이 적립 됩니다.</dd>
                        </dl>
                  </div>
<?php if($TPL_VAR["reviewBanner2"]){?>
                <div  class="review-guide__type">
                    <a href="<?php echo $TPL_VAR["reviewBanner2"]["bannerLink"]?>"><img src="<?php echo $TPL_VAR["reviewBanner2"]["imgSrc"]?>" style="width:100%;" alt=""></a>
                </div>
<?php }?>
                  <p class="best-review__desc--light">·후기 적립금은 온라인 구매만 해당됩니다.</p>
            </section>

            <!--후기목록영역-->
            <div id="crema-widget"></div>

            <div class="best-review__notice">
                  <h4 class="best-review__notice__title">적립불가 조건</h4>
                  <ul class="best-review__notice__list">
                        <li class="best-review__notice__desc">리뷰 작성시 수정이 안되오니 이점 참고 부탁 드립니다.</li>
                        <li class="best-review__notice__desc">상품 품절시 리뷰 적용이 안되어 적립금 지급이 안되오니 이점 양해 부탁 드립니다.</li>
                        <li class="best-review__notice__desc">두 가지 제품으로 같은 사진을 두번 올리는 경우 및 중복 후기 (복사/붙여넣기)의 경우 적립금은 한번만 지급</li>
                        <li class="best-review__notice__desc">글 50자는 ‘공백 제외/ 특수문자 제외 / ㅋ,ㅎ,ㅠ,..등 자음 및 모음 ,한자는 제외 숫자의 경우 한 글자로 처리</li>
                        <li class="best-review__notice__desc">오프라인 매장 구매, 공식 홈페이지 구매제품이 아닌 경우</li>
                        <li class="best-review__notice__desc">배송완료일로 부터 30일이 지난제품일 경우</li>
                        <li class="best-review__notice__desc">비회원으로 구입후 후기 작성 시 적립금 미지급 (회원혜택)</li>
                        <li class="best-review__notice__desc">1만원 이하의 상품일 경우 미지급</li>
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
            <h2 class="fb__best-review__title">제품 후기</h2>
            <section class="best-review__type__wrap eng-hidden">
                  <div class="best-review__type">
                        <dl class="best-review__type__box">
                              <dt>일반후기</dt>
                              <dd>글 50자 이상의 생생한 후기를<br> 남겨주시면 3,000원이 적립 됩니다.</dd>
                        </dl>
                        <dl class="best-review__type__box">
                              <dt>포토후기</dt>
                              <dd>글 50자 이상의 생생한 후기와<br>착용컷을 남겨주시면 5,000원이 적립 됩니다.</dd>
                        </dl>
                  </div>
                  <p class="best-review__desc--light">·후기 적립금은 온라인 구매만 해당됩니다.</p>
            </section>

            <!-- @TODO 제품후기 리스트 (상품상세 참조) -->
            <section class="tab-review" style="margin-top:50px;">
                  <div class="tab-review__content">
                        <div class="tab-review__content review-content">
                              <div class="sort-list top">
                                    <div class="sort-list__tab review-tab tab-js">
                                          <a href="#review-tab1" class="devReviewsDiv active" data-bbsdiv="0">
                                                전체후기<em class="sj__n"><?php echo number_format($TPL_VAR["allReviewTotal"])?></em>
                                          </a>
                                          <a href="#review-tab1" class="devReviewsDiv" data-bbsdiv="2">
                                                일반후기<em class="sj__n"> <?php echo number_format($TPL_VAR["reviewTotal"])?></em>
                                          </a>
                                          <a href="#review-tab1" class="devReviewsDiv eng-hidden" data-bbsdiv="1">
                                                포토후기<em class="sj__n"><?php echo number_format($TPL_VAR["premiumReviewTotal"])?></em>
                                          </a>
                                    </div>

                                    <select class="sort-list__select devSort" title="후기 정렬">
                                          <option value="real_regdate" data-sort="desc">최근등록순</option>
                                          <option value="avg" data-sort="asc">평점낮은순</option>
                                          <option value="avg" data-sort="desc">평점높은순</option>
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

                                                <li class="empty-content" id="devReviewEmpty">등록된 상품후기가 없습니다.</li>

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
                                                                        <span class="review-detail__title">상품평가</span>
                                                                        <span class="col star">
                                        <span class="set-star">
                                            <span class="score devStarScore" data-avg_pct="{[valuation_goods_pct]}" ></span>
                                        </span>
                                    </span>
                                                                        <!--<img {[valuation_goods_pct]}>-->
                                                                  </div>
                                                                  <span class="review-detail__wrap-score">
                                    <span class="review-detail__title">배송평가</span>
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
                  <h4 class="best-review__notice__title">적립불가 조건</h4>
                  <ul class="best-review__notice__list">
                        <li class="best-review__notice__desc">두 가지 제품으로 같은 사진을 두번 올리는 경우 및 중복 후기 (복사/붙여넣기)의 경우 적립금은 한번만 지급</li>
                        <li class="best-review__notice__desc eng-hidden">글 50자는 ‘공백 제외/ 특수문자제외 / ㅋ,ㅎ,ㅠ,..등 자음 및 모음 ,한자는 제외 숫자의 경우 한 글자로 처리</li>
                        <li class="best-review__notice__desc">오프라인 매장 구매, 공식 홈페이지 구매제품이 아닌 경우</li>
                        <li class="best-review__notice__desc">배송완료일로 부터 30일이 지난제품일 경우</li>
                        <li class="best-review__notice__desc">비회원으로 구입후 후기 작성 시 적립금 미지급 (회원혜택)</li>
                        <li class="best-review__notice__desc">1만원 이하의 상품일 경우 미지급</li>
                        <li class="best-review__notice__desc">배럴 SALE 상품 구매 시 구매후기 작성 및 후기작성으로 인한 적립금 지급 불가</li>
                  </ul>
            </div>

      </div>
</section>

<?php }?>