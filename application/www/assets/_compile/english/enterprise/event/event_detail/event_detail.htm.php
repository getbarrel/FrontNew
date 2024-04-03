<?php /* Template_ 2.2.8 2021/09/02 10:53:04 /home/barrel-stage/application/www/assets/templet/enterprise/event/event_detail/event_detail.htm 000018274 */ 
$TPL_eventGroupGoodsData_1=empty($TPL_VAR["eventGroupGoodsData"])||!is_array($TPL_VAR["eventGroupGoodsData"])?0:count($TPL_VAR["eventGroupGoodsData"]);?>
<form id="devEventDetailForm">
    <input type="hidden" name="event_ix" value="<?php echo $TPL_VAR["event_ix"]?>"/>
    <input type="hidden" name="kind" value="<?php echo $TPL_VAR["kind"]?>"/>
    <input type="hidden" name="orderBy" value="ec_ix"/>
    <input type="hidden" name="orderByType" value="desc"/>
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="20" id="devMax"/>
    <input type="hidden" value="<?php echo $TPL_VAR["use_comment"]?>" id="use_comment"/>
</form>

<section class="sj__event-detail">
    <?php echo $TPL_VAR["event_text"]?>

<?php if($TPL_VAR["kind"]=='P'){?>
<?php if($TPL_VAR["eventGroupGoodsData"]){?>
    <div class="fb__goods-list__contents" style="width:100%;">
        <section class="fb__main__goods  product-box three-boxes-wrap">
<?php if($TPL_eventGroupGoodsData_1){foreach($TPL_VAR["eventGroupGoodsData"] as $TPL_V1){?>

<?php if($TPL_V1["group_image"]==''){?>
				<h2 class="fb__goods-list__title" style="font-size:30px;"> <?php echo $TPL_V1["group_name"]?> </h2>
<?php }else{?>
				<h2 class="fb__goods-list__title" style="font-size:30px;"> <img src="<?php echo $TPL_V1["group_image"]?>" style="width:100%;"> </h2>
<?php }?>

            <div class="goodsbox-contents" id="<?php echo $TPL_V1["epg_ix"]?>" style="width:1200px; margin:0 auto;">
                <ul class="fb__main__fb__goods fb__goods">
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <li class="fb__goods__list">
                        <a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>">
                            <figure class="fb__goods__img">
                                <div>
                                 <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="<?php echo $TPL_V2["image_src"]?>" alt="<?php echo $TPL_V2["pname"]?>">
                                </div>
                            </figure>
                            <div class="fb__goods__info">

                                <div class="fb__badge">
<?php if(is_array($TPL_R3=$TPL_V2["icons_path"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                                    <span class="fb__badge--water">
                                        <?php echo $TPL_V3?>

                                    </span>
<?php }}?>
                                </div>
<?php if($TPL_V2["icons_path"]){?>
<?php }?>
                                <ul class="fb__goods__infoBox">
                                    <li class="fb__goods__pre">
                                        <?php echo $TPL_V2["preface"]?>

                                    </li>
                                    <li class="fb__goods__name">
                                        <?php echo $TPL_V2["pname"]?>

                                    </li>
                                    <li class="fb__goods__option">
                                        <?php echo $TPL_V2["add_info"]?>

                                    </li>
                                    <li class="fb__goods__brand">
                                        <?php echo $TPL_V2["brand_name"]?>

                                    </li>

                                </ul>
                            </div>
                            <div class="fb__goods__important">
                                <span class="fb__goods__price">
                                    <em><?php echo g_price($TPL_V2["dcprice"])?></em>
                                </span>
<?php if($TPL_V2["isDiscount"]){?>
                                <span class="fb__goods__noprice">
                                    <?php echo g_price($TPL_V2["listprice"])?>

                                </span>
<?php }?>
<?php if($TPL_V2["is_soldout"]){?>
                                <span class="fb__goods__price__state">Out of stock</span>
<?php }else{?>
<?php if($TPL_V2["discount_rate"]){?>
                                    <span class="fb__goods__sale">
                                        <p class="per"><em><?php echo $TPL_V2["discount_rate"]?></em>%</p>
                                    </span>
<?php }?>
<?php }?>
                            </div>
                        </a>
                        <!--<p class="list-item__condition">-->
                            <?php echo $TPL_VAR["deliveryText"]?>

                        <!--</p>-->
                        <a href="#" class="product-box__heart <?php if($TPL_VAR["alreadyWish"]){?>product-box__heart--active<?php }?>" data-devWishBtn="<?php echo $TPL_V2["id"]?>">
                            heart
                        </a>
                    </li>
<?php }}?>
                </ul>
            </div>
<?php }}?>
        </section>
    </div>
<?php }?>
<?php }?>
<?php if(false){?>
    <header class="sj__event-detail__header">
        <h2 class="sj__event-detail__title">
            <?php echo $TPL_VAR["event_title"]?>

        </h2>
        <p class="sj__event-detail__subtitle">
            <?php echo $TPL_VAR["manage_title"]?>

        </p>
        <p class="sj__event-detail__date">
<?php if($TPL_VAR["onOff"]=='Y'){?>
            <span class="sj__event-detail__date__from">
                <em class="year"><?php echo $TPL_VAR["startDate"]?></em>
            </span>
            <span class="sj__event-detail__date__to">
                <em class="year"><?php echo $TPL_VAR["endDate"]?></em>
            </span>
            <span class="sj__event-detail__date__d-day">
                D<em><?php echo $TPL_VAR["dDay"]?></em>
            </span>
<?php }else{?>
            <span class="date end"><font color="red">이벤트 종료</font></span>
<?php }?>
        </p>
    </header>

    <section class="sj__event-detail__banner">
        <h3 class="sj__event-detail__banner__title">이벤트 상세 배너이미지</h3>
<?php if($TPL_VAR["event_bannerImg"]){?>
        <figure class="sj__event-detail__banner__thumb">
            <img src="<?php echo $TPL_VAR["event_bannerImg"]?>" alt="<?php echo $TPL_VAR["event_title"]?>">
        </figure>
<?php }?>
    </section>

    <section class="sj__event-detail__goodsbox  product-box four-boxes-wrap">
        <ul class="goodsbox-tab" id="stickytab">

<?php if($TPL_eventGroupGoodsData_1){$TPL_I1=-1;foreach($TPL_VAR["eventGroupGoodsData"] as $TPL_V1){$TPL_I1++;?>
            <li class="goodsbox-tab__list goodsbox-tab__list<?php if($TPL_I1== 0){?>--active<?php }?>">
                <a href="#<?php echo $TPL_V1["epg_ix"]?>"><?php echo $TPL_V1["event_name"]?></a>
            </li>
<?php }}?>
        </ul>
<?php if($TPL_eventGroupGoodsData_1){foreach($TPL_VAR["eventGroupGoodsData"] as $TPL_V1){
$TPL_goods_2=empty($TPL_V1["goods"])||!is_array($TPL_V1["goods"])?0:count($TPL_V1["goods"]);?>
        <div class="goodsbox-contents" id="<?php echo $TPL_V1["epg_ix"]?>">
            <h3 class="goodsbox-contents__title">
                <span>
                        <?php echo $TPL_V1["event_name"]?>

                </span>
            </h3>
            <ul class="goodsbox-contents__box">
<?php if($TPL_goods_2){foreach($TPL_V1["goods"] as $TPL_V2){?>
                <li class="list-item">
                    <a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>">
                        <figure class="list-item__thumb">
                            <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="<?php echo $TPL_V2["image_src"]?>" alt="<?php echo $TPL_V2["pname"]?>">
                        </figure>
                        <div class="list-item__infobox">
                            <div class="sj__badge sj__badge">
                                <span class="sj__badge--new">
                                    new
                                </span>
                                <span class="sj__badge--coupon">
                                    coupon
                                </span>
                            </div>

                            <ul class="list-item__info">
                                <li class="list-item__brand">
                                    <?php echo $TPL_V2["brand_name"]?>

                                </li>
                                <li class="list-item__name">
                                    <?php echo $TPL_V2["pname"]?>

                                </li>
<?php if($TPL_V2["isDiscount"]){?>
                                <li class="list-item__noprice">
                                    <?php echo g_price($TPL_V2["listprice"])?>

                                </li>
<?php }?>
                                <li class="list-item__price">
                                    <em><?php echo g_price($TPL_V2["dcprice"])?></em>원
                                </li>

                            </ul>
                        </div>
                    </a>
<?php if($TPL_V2["discount_rate"]){?>
                    <span class="list-item__sale">
                        <em><?php echo $TPL_V2["discount_rate"]?></em>%
                    </span>
<?php }?>
                    <p class="list-item__condition">
                        <?php echo $TPL_VAR["deliveryText"]?>

                    </p>
                    <a href="#" class="product-box__heart <?php if($TPL_VAR["alreadyWish"]){?>product-box__heart--active<?php }?>" data-devWishBtn="<?php echo $TPL_V2["id"]?>">
                        heart
                    </a>
                </li>
<?php }}?>
            </ul>
        </div>
<?php }}?>
    </section>
<?php }?>
<?php if($TPL_VAR["use_comment"]== 1){?>
<?php if($TPL_VAR["rel_title"]=='SPRINT'){?>
        <!--튜닝된 댓글 영역-->
        <section class="sj__event-detail__reviews">
            <h3>이벤트 상세 댓글</h3>
            <div class="left-line"></div>

            <div class="sj__event-detail__reviews__inner">
                <img id="comment-box-title" src="//image.getbarrel.com/barrel_data/images/sp/w/comment_box_title.jpg" alt="">
                <div class="reviews-write">
<?php if($TPL_VAR["onOff"]=='Y'){?>
                    <form class="reviews-write__form" id="eventDetailInputComment">
                        <input type="hidden" name="" value="" />
                        <textarea class="reviews-write__form__comment" cols="30" rows="10" id="devInputComment" title="댓글"  placeholder="여러분의 응원메시지를 남겨주세요"  disabled></textarea>
                        <div class="reviews-write__form__byte"></div>
                        <div class="reviews-write__form__btn__wrap">
                        <input class="reviews-write__form__btn" type="submit" id="devBtn" value="메시지 등록하기"></div>
                    </form>
<?php }?>
                    <div class="white-line"></div>
                </div>
                <div class="reviews-view">
                    <p class="reviews-view__total">댓글 <em><span id="devCommentCount">0</span></em>개</p>
                    <div id="devEventDetailContent">
                        <div id="devEventDetailLoading" class="devForbizTpl">
                            <div class="wrap-loading">
                                <div class="loading"></div>
                            </div>
                        </div>

                        <div id="devEventDetailListEmpty" class="devForbizTpl">등록된 댓글이 없습니다.</div>

                        <div class="reviews-view__viewbox viewbox">
                            <div class="viewbox__list" id="devEventDetailList">
                                <div class="logo"></div>
                                <div class="info">
                                    <div class="name-wrap">

                                        <p class="name font-30">{[str_name]}</p>

                                        {[#if idChk]}
                                        <div>
                                            <button class="viewbox__list__edit-btn devModifyComment">수정</button>
                                        </div>
                                        <div>
                                            <button class="viewbox__list__del-btn devCommentDeleteBtn" devIx="{[ec_ix]}">삭제</button>
                                        </div>
                                        {[/if]}

                                    </div>


                                <!--<div class="viewbox__list__title">-->
                                    <!--<span class="viewbox__list__name">-->

                                    <!--</span>-->
                                    <!--<span class="viewbox__list__date">-->
                                        <!--<em>{[comment_regdate]}</em>-->
                                    <!--</span>-->
                                <!--</div>-->
                                    <div class="viewbox__list__cont">
                                        <div class="inner">
                                            {[{comment}]}
                                        </div>
                                        <div class="viewbox__list__edit-area devCommentModifyArea">
                                            <span class="viewbox__list__name">{[nick_name]}</span>
                                            <span class="viewbox__list__date">
                                        {[comment_regdate]}
                                        </span>
                                        <form>
                                            <textarea class="viewbox__list__edit-area__textarea devInputComment" name="comment"  cols="30" rows="10">{[comment_text]}</textarea>
                                            <div class="viewbox__list__edit-area__btns" id="devCommentContent">
                                                <button class="viewbox__list__edit-area__btns--cancel devCommentModifyCancel">취소</button>
                                                <button class="viewbox__list__edit-area__btns--submit devCommentModifyBtn"  type="button" data-ec_ix="{[ec_ix]}" >등록</button>
                                            </div>
                                        </form>
                                    </div>



                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="devPageWrap"></div>
            </div>
        </section>
<?php }else{?>
        <!--기본 댓글 영역-->
        <section class="sj__event-detail__reviews">
            <h3>이벤트 상세 댓글</h3>
            <div class="reviews-write">
<?php if($TPL_VAR["onOff"]=='Y'){?>
                <form class="reviews-write__form" id="eventDetailInputComment">
                    <input type="hidden" name="" value="" />
                    <textarea class="reviews-write__form__comment" cols="30" rows="10" id="devInputComment" title="댓글"disabled></textarea>
                    <div class="reviews-write__form__byte"></div>
                    <input class="reviews-write__form__btn" type="submit" id="devBtn" value="등록">
                </form>
<?php }?>
            </div>
            <div class="reviews-view">
                <p class="reviews-view__total">댓글 <em><span id="devCommentCount">0</span></em>개</p>
                <div id="devEventDetailContent">
                    <div id="devEventDetailLoading" class="devForbizTpl">
                        <div class="wrap-loading">
                            <div class="loading"></div>
                        </div>
                    </div>

                    <div id="devEventDetailListEmpty" class="devForbizTpl">등록된 댓글이 없습니다.</div>

                    <div class="reviews-view__viewbox viewbox">
                        <dl class="viewbox__list" id="devEventDetailList">
                            <dt class="viewbox__list__title">
                                <span class="viewbox__list__name">
                                    {[nick_name]}
                                </span>
                                <span class="viewbox__list__date">
                                    <em>{[comment_regdate]}</em>
                                </span>
                            </dt>
                            <dd class="viewbox__list__cont">
                                {[comment]}
                            </dd>
                            {[#if idChk]}
                            <button class="viewbox__list__edit-btn">수정</button>
                            {[/if]}

                            <div class="viewbox__list__edit-area">
                                <span class="viewbox__list__name">{[nick_name]}</span>
                                <span class="viewbox__list__date">
                                {[comment_regdate]}
                            </span>
                                <form>
                                    <textarea class="viewbox__list__edit-area__textarea devInputComment" name="comment"  cols="30" rows="10"></textarea>
                                    <div class="viewbox__list__edit-area__btns" id="devCommentContent">
                                        <button class="viewbox__list__edit-area__btns--cancel">취소</button>
                                        <button class="viewbox__list__edit-area__btns--submit devCommentModifyBtn"  type="button" data-ec_ix="{[ec_ix]}" >등록</button>
                                    </div>
                                </form>
                            </div>
                        </dl>
                    </div>

                </div>
            </div>
            <div id="devPageWrap"></div>
        </section>
<?php }?>
<?php }?>
    <?php echo $TPL_VAR["b_img_text"]?>

</section>