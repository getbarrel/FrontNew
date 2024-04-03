<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/recent_view/recent_view.htm 000004829 */ ?>
<!--@TODO mypage_top 확인해주세요 -->
<div class="fb__mypage wrap-mypage">
    <section>
        <h2 class="fb__mypage__title">Recently Viewed Products</h2>
        <form id="devRecentViewForm">
            <input type="hidden" name="page" value="1" id="devPage"/>
            <input type="hidden" name="max" value="20"/>

            <div class="wrap-item-list fb__wishlist__items">
                <div id="devTopButton" class="top-area clearfix items__btn">
                    <div class="float-l">
                        <input type="checkbox" id="all-check" >
                        <label for="all-check">Select All </label>
                    </div>
                    <button type="button" id='devBtnDelRecent' class="items__btn__delete">Delete</button>
                </div>

                <ul class="item-list fb__wishlist--inner" id="devRecentViewContent">

                    <li id="devRecentViewLoading" class="devForbizTpl empty-content">
                        <br>
                        <div class="wrap-loading">
                            <div class="loading"></div>
                        </div>
                    </li>

                    <li class="devForbizTpl fb__wishlist--item" id="devRecentViewList">
                        <div class="check-area">
                            <input type="checkbox" id="recentList_{[index_]}" name="recentList[]" value="{[id]}" class="item-check">
                            <label for="recentList_{[index_]}"></label>
                        </div>

                        <a href="/shop/goodsView/{[id]}" class="fb__wishlist__detail">
                            <div class="item fb__item">
                                <div class="thumb fb__wishlist__detail--img">
                                    <img src="{[image_src]}" alt="{[pname]}">
                                </div>
                                <div class="info wishlist__info">
                                    <div class="fb__badge__wrap">
                                        {[#each icons_path]}
                                        <span class="fb__badge--water">
                                            {[{this}]}
                                        </span>
                                        {[/each]}
                                    </div>
                                    <p class="title fb__item__promotion">{[preface]}</p>
                                    <p class="title fb__item__title">{[pname]}</p>
                                    <p class="title fb__item__option">{[add_info]}</p>

                                    <div class="price-area fb__item__price-area fb__wishlist__item">
                                        <p class="price discount fb__item__price fb__wishlist__price"><em>{[dcprice]}</em></p>
                                        {[#if isDiscount]}
                                        <p class="strike"><em>{[listprice]}</em></p>
                                        {[/if]}
                                        {[#if state_soldout]}
                                        <p class="fb__wishlist__soldout">Out of stock</p>
                                        {[else]}
                                        {[#if isPercent]}
                                        <p class="fb__wishlist__percent"><em>{[discount_rate]}</em>%</p>
                                        {[/if]}
                                        {[/if]}
                                    </div>
                                    <!--<p class="price soldout">Out of stock</p>-->
                                </div>
                            </div>
                        </a>

                        <div class="fb__wishlist__btn {[#if alreadyWish]}fb__wishlist__btn--active{[/if]}" data-devWishBtn="{[id]}">
                            <span>wish</span>
                        </div>
                        <!--<a href="#" class="product-box__heart {[#if alreadyWish]}on{[/if]}" devwishbtn="{[id]}">
                            {[#if alreadyWish]}
                            <input type="checkbox" class="goods-list__wish__btn" checked>
                            {[else]}
                            <input type="checkbox" class="goods-list__wish__btn">
                            {[/if]}
                        </a>-->
                    </li>
                    <li class="empty-content devForbizTpl" id="devRecentViewEmpty">
                        <p>No Recently Viewed Items</p>
                    </li>
                </ul>
            </div>

            <div id="devPageWrap"></div>
        </form>
    </section>
</div>