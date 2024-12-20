<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/my_review_list/my_review_list.htm 000006299 */ ?>
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

<section class="br__my-review">
    <div class="br__cs__title">My Reviews</div>
    <div class="crema-reviews" data-type="my-reviews"></div>
</section>

<?php }else{?>
<section class="br__my-review">
    <div class="br__cs__title">My Reviews</div>
    <div class="wrap-mypage community-list review">
        <p class="title-count">Total <em id="devTotal">0</em></span></p>
    </div>

    <form id="devMyReviewForm">
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="20"/>

        <div class="wrap-mypage community-list review" id="devMyReviewContent">

            <dl class="empty-content" id="devMyReviewLoading">
                <div class="wrap-loading">
                    <div class="loading"></div>
                </div>
            </dl>

            <dl id="devMyReviewList" class="devForbizTpl">
                <dt>
                    <a href="/shop/goodsView/{[pid]}">
                        <div class="item">

                            {[#if isThumb]}
                            <div class="thumb">
                                <img src="{[thumb]}">
                            </div>
                            {[/if]}
                            <div class="info">
                                <p class="tit">
                                    {[pname]}
                                </p>
                                {[#if oid]}
                                <p class="date">purchase date: <span>{[order_date]}</span></p>
                                {[else]}
                                <p class="date">purchase date: <span>{[regdate]}</span></p>
                                {[/if]}
                            </div>
                        </div>
                    </a>
                </dt>


                <dd>
                    <div>
				<span class="set-star">
					<span class="score" style="width:{[avg_pct]}%"></span>
				</span>
                        <span class="date">{[regdate]}</span>
                    </div>

                    <div class="wrap-score">
                        <span>Product evaluation <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/icon/m_star_s_{[valuation_goods]}.png"></span>
                        <span>Shipping Evaluation <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/icon/m_star_s_{[valuation_delivery]}.png"></span>
                    </div>

                    <div class="content">
                        <p class="tit">{[bbs_subject]}</p>
                        <p class="cont">{[{bbs_contents}]}</p>
                    </div>


                    <div class="review-img-area">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                {[#if bbs_file_1]}
                                <div class="swiper-slide"><a href="<?php echo $TPL_VAR["image_review_src"]?>/{[bbs_no]}/{[bbs_file_1]}" target="_blank"><img src="<?php echo $TPL_VAR["image_review_src"]?>/{[bbs_no]}/{[bbs_file_1]}"></a></div>
                                {[/if]}
                                {[#if bbs_file_2]}
                                <div class="swiper-slide"><a href="<?php echo $TPL_VAR["image_review_src"]?>/{[bbs_no]}/{[bbs_file_2]}" target="_blank"><img src="<?php echo $TPL_VAR["image_review_src"]?>/{[bbs_no]}/{[bbs_file_2]}"></a></div>
                                {[/if]}
                                {[#if bbs_file_3]}
                                <div class="swiper-slide"><a href="<?php echo $TPL_VAR["image_review_src"]?>/{[bbs_no]}/{[bbs_file_3]}" target="_blank"><img src="<?php echo $TPL_VAR["image_review_src"]?>/{[bbs_no]}/{[bbs_file_3]}"></a></div>
                                {[/if]}
                                {[#if bbs_file_4]}
                                <div class="swiper-slide"><a href="<?php echo $TPL_VAR["image_review_src"]?>/{[bbs_no]}/{[bbs_file_4]}"><img src="<?php echo $TPL_VAR["image_review_src"]?>/{[bbs_no]}/{[bbs_file_4]}"></a></div>
                                {[/if]}
                                {[#if bbs_file_5]}
                                <div class="swiper-slide"><a href="<?php echo $TPL_VAR["image_review_src"]?>/{[bbs_no]}/{[bbs_file_5]}"><img src="<?php echo $TPL_VAR["image_review_src"]?>/{[bbs_no]}/{[bbs_file_5]}"></a></div>
                                {[/if]}

                            </div>
                        </div>
                    </div>
                </dd>

                {[#if cmt.cmt_ix]}
                <dd class="review-comment-area">
                    <p><em>Comment</em> {[cmt.cmt_name]} <span>{[cmt.cmt_date]}</span></p>
                    <div class="comment-content">
                        {[{cmt.cmt_contents}]}
                    </div>
                </dd>
                {[/if]}

            </dl>
        </div>

        <div class="empty-content devForbizTpl" id="devMyReviewEmpty">
            <p>There are no product reviews.</p>
        </div>

        <div id="devPageWrap"></div>

    </form>




<?php }?>

</section>