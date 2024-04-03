<?php /* Template_ 2.2.8 2023/07/18 10:19:55 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/event/event_detail/event_detail.htm 000014874 */ 
$TPL_eventGroupGoodsData_1=empty($TPL_VAR["eventGroupGoodsData"])||!is_array($TPL_VAR["eventGroupGoodsData"])?0:count($TPL_VAR["eventGroupGoodsData"]);?>
<div class="wrap_event_detail">
    <form id="devEventDetailForm">
        <input type="hidden" name="event_ix" value="<?php echo $TPL_VAR["event_ix"]?>"/>
        <input type="hidden" name="orderBy" value="ec_ix"/>
        <input type="hidden" name="orderByType" value="desc"/>
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="20" id="devMax"/>
    </form>
    <?php echo $TPL_VAR["event_text2"]?>


    <!--<div class="br__goods-list__wrap br__goods-list__wrap&#45;&#45;normal">-->
        <!--<div class="goods-list">-->
            <!--<div id="devFilterEmpty" class="empty-content" style="display:none"><p>선택하신 조건에 대한 검색 결과가 없습니다. <span>다른 옵션을 선택하여 검색해 보세요.</span></p></div>-->
            <!--<ul class="goods-list__list">-->
                <!--<li class="goods-list__box">-->
                    <!--<a href="/shop/goodsView/{[id]}" class="goods-list__link">-->
                        <!--<figure class="goods-list__thumb">-->
                            <!--<img src="{[image_src]}" alt="상품제목">-->
                        <!--</figure>-->
                        <!--<div class="goods-list__info">-->
                            <!--{[#if icons]}-->
                            <!--<div class="goods-list__badge">-->
                                <!--{[#each icons_path]}-->
                                <!--<span>{[{this}]}</span>-->
                                <!--{[/each]}-->
                            <!--</div>-->
                            <!--{[else]}-->
                            <!--<div class="goods-list__badge">-->
                                <!--<span></span>-->
                            <!--</div>-->
                            <!--{[/if]}-->
                            <!--<p class="br__goods__pre">{[preface]}</p>-->
                            <!--<p class="goods-list__title">{[pname]}</p>-->
                            <!--<span class="goods-list__color">{[add_info]}</span>-->
                            <!--<div class="goods-list__price">-->
                                <!--{[#if isDiscount]}-->
                                <!--<span class="goods-list__price__cost"><?php echo $TPL_VAR["fbUnit"]["f"]?>{[listprice]}<?php echo $TPL_VAR["fbUnit"]["b"]?></span>-->
                                <!--{[/if]}-->
                                <!--<span class="goods-list__price__discount"><?php echo $TPL_VAR["fbUnit"]["f"]?>{[dcprice]}<?php echo $TPL_VAR["fbUnit"]["b"]?></span>-->
                                <!--{[#if isPercent]}-->
                                <!--<span class="goods-list__price__percent">[{[discount_rate]}%]</span>-->
                                <!--{[/if]}-->
                                <!--{[#if is_soldout]}-->
                                <!--<span class="goods-list__price__state">[품절]</span>-->
                                <!--{[/if]}-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</a>-->
                    <!--<label class="goods-list__wish{[#if alreadyWish]} on{[/if]}" devwishbtn="{[id]}">-->
                        <!--{[#if alreadyWish]}-->
                        <!--<input type="checkbox" class="goods-list__wish__btn" checked>-->
                        <!--{[else]}-->
                        <!--<input type="checkbox" class="goods-list__wish__btn">-->
                        <!--{[/if]}-->
                    <!--</label>-->
                <!--</li>-->
            <!--</ul>-->
        <!--</div>-->
    <!--</div>-->
<?php if($TPL_VAR["kind"]=='P'){?>
<?php if($TPL_VAR["eventGroupGoodsData"]){?>
    <div class="main-cate ">
        <div class="main-cate__goods-list br__goods-list__wrap br__goods-list__wrap--normal">
            <div class="goods-list">
<?php if($TPL_eventGroupGoodsData_1){foreach($TPL_VAR["eventGroupGoodsData"] as $TPL_V1){?>
<?php if($TPL_V1["group_name"]==''){?>
<?php if($TPL_V1["group_image_m"]==''){?>
						<h2 style="font-size:2.0rem; line-height:3rem; padding: 10px 0; width:100%; margin:0 auto 0; color:#000; font-weight:600; text-align:center; "> <?php echo $TPL_V1["group_name"]?> </h2>
<?php }else{?>
						<h2 style="font-size:2.0rem; line-height:3rem; padding: 10px 0; width:100%; margin:0 auto 0; color:#000; font-weight:600; text-align:center; "> <img src="<?php echo $TPL_V1["group_image_m"]?>" style="width:100%;"> </h2>
<?php }?>
<?php }else{?>
					<h2 style="font-size:2.0rem; line-height:3rem; padding: 10px 0; width:100%; margin:0 auto 0; color:#000; font-weight:600; text-align:center; "> <?php echo $TPL_V1["group_name"]?> </h2>
<?php }?>

                <ul class="goods-list__list devProductTab" id="productTab<?php echo $TPL_V1["epg_ix"]?>" style="margin-bottom: 60px;">
<?php if(is_array($TPL_R2=$TPL_V1["goods"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <li class="goods-list__box">
                        <a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>" class="goods-list__link">
                            <figure class="goods-list__thumb">
                                <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="<?php echo $TPL_V2["image_src"]?>" alt="{[pname]}">
                            </figure>
                            <div class="goods-list__info">

                                <div class="goods-list__badge">
<?php if(is_array($TPL_R3=$TPL_V2["icons_path"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
                                    <span><?php echo $TPL_V3?></span>
<?php }}?>
                                </div>

                                <p class="br__goods__pre" style="color:<?php echo $TPL_V2["prefaceColor"]?>;"><?php echo $TPL_V2["prefaceName"]?></p>
                                <p class="goods-list__title"><?php echo $TPL_V2["pname"]?></p>
                                <span class="goods-list__color"><?php echo $TPL_V2["add_info"]?></span>
                                <div class="goods-list__price">
<?php if($TPL_V2["isDiscount"]){?>
                                    <span class="goods-list__price__cost"><?php echo g_price($TPL_V2["listprice"])?>원</span>
<?php }?>
                                    <span class="goods-list__price__discount"><?php echo g_price($TPL_V2["dcprice"])?>원</span>

<?php if($TPL_V2["discount_rate"]){?>
                                    <span class="goods-list__price__percent">
                                       [<?php echo $TPL_V2["discount_rate"]?>%]
                                    </span>
<?php }?>
                                </div>
                            </div>
                        </a>
                    </li>
<?php }}?>
                </ul>
<?php }}?>
            </div>
        </div>
    </div>
<?php }?>
<?php }?>
<?php if(false){?>
    <h1 class="wrap-title">
        상세정보
        <button class="back"></button>
    </h1>

    <div class="event_txt">
        <p class="title"><?php echo $TPL_VAR["event_title"]?></p>
        <p class="desc"><?php echo $TPL_VAR["manage_title"]?></p>
<?php if($TPL_VAR["onOff"]=='Y'){?>
        <p class="date"><?php echo $TPL_VAR["startDate"]?> - <?php echo $TPL_VAR["endDate"]?></p>
<?php }else{?>
        <p class="date end"><font color="red">이벤트 종료</font></p>
<?php }?>
    </div>

    <div class="event-products event-products-img">
        <?php echo $TPL_VAR["event_text2"]?>

    </div>

    <div class="event-products">

        <ul class="tab_menu clearfix">
            <li class="tab_link" data-tab="tab-1">
                <select name="" id="devGroupSel">
                    <option value="">전체</option>
<?php if($TPL_eventGroupGoodsData_1){foreach($TPL_VAR["eventGroupGoodsData"] as $TPL_V1){?>
                    <option value="<?php echo $TPL_V1["epg_ix"]?>"><?php echo $TPL_V1["group_name"]?></option>
<?php }}?>
                </select>
            </li>
        </ul>

<?php if($TPL_eventGroupGoodsData_1){foreach($TPL_VAR["eventGroupGoodsData"] as $TPL_V1){
$TPL_goods_2=empty($TPL_V1["goods"])||!is_array($TPL_V1["goods"])?0:count($TPL_V1["goods"]);?>
        <span class="dec"></span>
        <ul class="products clearfix devProductTab" id="productTab<?php echo $TPL_V1["epg_ix"]?>">
            <a class="event-products-tit" href="javacript:void(0);"><?php echo $TPL_V1["group_name"]?></a>
            <p class="tab_menu_subText devSubText" id="subText<?php echo $TPL_V1["epg_ix"]?>"><?php echo $TPL_V1["event_name"]?></p>

<?php if($TPL_goods_2){foreach($TPL_V1["goods"] as $TPL_V2){?>
            <li>
                <div class="thumb">
                    <a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>">
                        <img src="<?php echo $TPL_V2["image_src"]?>"/>
                    </a>
                </div>
                <p class="tit"><?php echo $TPL_V2["pname"]?></p>
                <div class="price-area">
<?php if($TPL_V2["isDiscount"]){?>
                    <p class="strike"><em><?php echo $TPL_V2["listprice"]?></em>원</p>
<?php }?>
                    <p class="price discount"><em><?php echo $TPL_V2["dcprice"]?></em>원</p>
                </div>
            </li>
<?php }}?>
        </ul>
<?php }}?>
    </div>
<?php }?>
<?php if($TPL_VAR["use_comment"]== 1){?>
<?php if($TPL_VAR["rel_title"]=='SPRINT'){?>
    <div class="sprint event_comment">
        <div class="inner">
            <img class="title" src="//getbarrel.com/barrel_data/images/sp/m/comment_box_title.jpg" alt="">
            <div class="inner__content">
<?php if($TPL_VAR["onOff"]=='Y'){?>
        <form id="devEventCommentForm">
            <input type="hidden" name="event_ix" value="<?php echo $TPL_VAR["event_ix"]?>"/>
            <div class="area_input">
                <textarea placeholder="댓글을 입력해주세요." name="comment" id="devInputComment" title="댓글"></textarea>
                <div class="wrap__btn">
                    <button class="btn-square btn-point" id="devBtn">댓글 등록하기</button>
                </div>
            </div>
        </form>
<?php }?>

        <div class="area_comment_list">
            <p class="reply_num">댓글 (<span id="devCommentCount">0</span>)</p>
            <div>
                <div class="sprint__list" id="devEventDetailContent">
                    <div id="devEventDetailLoading" class="devForbizTpl">
                        <div class="wrap-loading">
                            <div class="loading"></div>
                        </div>
                    </div>

                    <div id="devEventDetailListEmpty" class="devForbizTpl no-contents">등록된 댓글이 없습니다.</div>

                    <div id="devEventDetailList" class="devForbizTpl">
                        <div class="info">
                            <p class="writer font-ss" title="작성자">
                                {[str_name]}
                                {[#if idChk]}
                                    <button class="viewbox__list__edit-btn devModifyComment">수정</button>
                                    <button class="viewbox__list__del-btn devCommentDeleteBtn" devIx="{[ec_ix]}">삭제</button>
                                {[/if]}
                            </p>
                            <!-- <p class="regdate font-sss" title="작성일">2019-09-04</p> -->
                        </div>
                        <div class="text">
                            <p class="contents">{[{comment}]}</p>
                        </div>
                        <div class="viewbox__list__edit-area devCommentModifyArea" style="display: none;">
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
        </div>
    </div>
    <div id="devPageWrap"></div>
<?php }else{?>
    <div class="event_comment">
<?php if($TPL_VAR["onOff"]=='Y'){?>
        <form id="devEventCommentForm">
            <input type="hidden" name="event_ix" value="<?php echo $TPL_VAR["event_ix"]?>"/>
            <div class="area_input">
                <textarea placeholder="댓글을 입력해주세요." name="comment" id="devInputComment" title="댓글"></textarea>
                <button class="btn-square btn-point" id="devBtn">댓글 등록하기</button>
            </div>
        </form>
<?php }?>

        <div class="area_comment_list">
            <p class="reply_num">댓글 (<span id="devCommentCount">0</span>)</p>
            <ul>
                <div class="area_comment_list" id="devEventDetailContent">
                    <div id="devEventDetailLoading" class="devForbizTpl">
                        <div class="wrap-loading">
                            <div class="loading"></div>
                        </div>
                    </div>

                    <div id="devEventDetailListEmpty" class="devForbizTpl no-contents">등록된 댓글이 없습니다.</div>

                    <div id="devEventDetailList" class="devForbizTpl">
                        <li>
                            <p class="info">
                                <span>{[id]}</span><span class="date">{[comment_regdate]}</span>
                            </p>
                            <p class="contents">{[{comment}]}</p>
                        </li>
                    </div>
                </div>
            </ul>
        </div>
    </div>
    <div id="devPageWrap"></div>
<?php }?>

<?php }?>
    <?php echo $TPL_VAR["b_img_text2"]?>

</div>