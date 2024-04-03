<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/wishlist/wishlist.htm 000007052 */ ?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<div class="fb__mypage wrap-mypage fb__wishlist">
    <section class="fb__wishlist__wrap">
        <h2 class="fb__mypage__title fb__wishlist__title">Wish list</h2>
        <div class="fb__wishlist__summary">
            <p>Total <span id="devTotal">0</span></p>
            <span>You can select the option on the product detail page.</span>
        </div>
        <form id="devMyWishForm">
            <input type="hidden" name="page" id="devPage" value="1"/>
            <input type="hidden" name="max" id="devMax" value="20"/>

            <div class="wrap-item-list fb__wishlist__items">
                <!-- wish list 있을때만 보여짐 -->
                <div id="devTopButton" class="top-area clearfix items__btn">
                    <div class="float-l">
                        <input type="checkbox" id="all-check" >
                        <label for="all-check">Select All </label>
                    </div>
                    <button type="button" id='devBtnDelWish' class="items__btn__delete">Delete</button>
                </div>
                <ul class="item-list fb__wishlist--inner" id="devMyWishContent" >
                    <!--<li class="fb__wishlist__list">
                        <div class="check-area">
                            <input type="checkbox" id="wishList_{[index_]}" name="wishList[]" value="{[id]}" class="item-check">
                            <label for="wishList_{[index_]}"></label>
                        </div>
                        <a href="#" class="fb__wishlist__detail">
                            <div class="item">
                                <div class="thumb fb__wishlist__detail&#45;&#45;img">
                                    <img src="http://barrel.devs/data/barrel_data/images/product/00/00/00/00/05/m_0000000005.gif" alt="">
                                </div>
                                <div class="info wishlist__info">
                                    <div>
                                        <span class="detail__box detail__box&#45;&#45;water">WATER</span>
                                        <span class="detail__box detail__box&#45;&#45;fitness">FITNESS</span>
                                    </div>
                                    <p class="title fb__item__title">Product Name</p>
                                    <p class="title fb__item__option">White/Navy/Black</p>

                                    <div class="price-area fb__item__price-area fb__wishlist__item">
                                        <p class="strike"><em>28,900</em>원</p>
                                        <p class="price discount fb__item__price fb__wishlist__price"><em>28,900</em>원</p>
                                        <p class="fb__wishlist__percent"><em>30</em>%</p>
                                    </div>
                                    &lt;!&ndash;<p class="price soldout">Out of stock</p>&ndash;&gt;
                                </div>
                            </div>
                        </a>
                        <div class="fb__wishlist__btn fb__wishlist__btn&#45;&#45;active">
                            <span data-devWishBtn=''>wish</span>
                        </div>
                    </li>-->
                    <li id="devMyWishList" class="devForbizTpl fb__wishlist--item">
                        <div class="check-area">
                            <input type="checkbox" id="wishList_{[index_]}" name="wishList[]" value="{[id]}" class="item-check">
                            <label for="wishList_{[index_]}"></label>
                        </div>
                        <a href="/shop/goodsView/{[id]}" class="fb__wishlist__detail">
                            <div class="item">
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
                                        <!--<span class="detail__box detail__box&#45;&#45;water">WATER</span>-->
                                        <!--<span class="detail__box detail__box&#45;&#45;fitness">FITNESS</span>-->
                                    </div>
                                    <p class="title fb__item__promotion">{[preface]}</p>
                                    <p class="title fb__item__title">{[pname]}</p>
                                    <p class="title fb__item__option">{[add_info]}</p>

                                    <div class="price-area fb__item__price-area fb__wishlist__item">
                                        <p class="price discount fb__item__price fb__wishlist__price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[dcprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                                        {[#if isDiscount]}
                                        <p class="strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[listprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                                        {[/if]}
                                        {[#if state_soldout]}
                                        <p class="fb__wishlist__percent">Out of stock</p>
                                        {[else]}
                                            {[#if isPercent]}
                                            <p class="fb__wishlist__percent"><em class="number__font">{[discount_rate]}</em>%</p>
                                            {[/if]}
                                        {[/if]}

                                    </div>

                                </div>
                            </div>
                        </a>
                        <div class="fb__wishlist__btn fb__wishlist__btn--active" data-devWishBtn='{[id]}'>
                            <span >wish</span>
                        </div>
                    </li>
                    <li id="devMyWishLoading" class="devForbizTpl empty-content">
                        <div class="wrap-loading">
                            <div class="loading"></div>
                        </div>
                    </li>
                    <li id="devMyWishEmpty" class="devForbizTpl empty-content">
                        <p>Your Wish list is empty.</p>
                    </li>
                </ul>
            </div>

            <div id="devPageWrap"></div>

        </form>
    </section>
</div>