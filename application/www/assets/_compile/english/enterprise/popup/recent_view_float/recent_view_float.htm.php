<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/popup/recent_view_float/recent_view_float.htm 000004845 */ ?>
<div class="br__recent">
      <form id="devRecentViewForm">
            <input type="hidden" name="page" value="1" id="devPage"/>
            <input type="hidden" name="max" value="50"/>
            <input type="hidden" name="order" value="50"/>

            <div class="list-top-area clearfix devForbizTpl" id="devRecentViewSelector">
                  <div class="float-l mat10">
                        <input type="checkbox" id="all-check">
                        <label for="all-check">Select All </label>
                  </div>
                  <button class="btn-s btn-white float-r" id='devBtnDelRecent'>Delete</button>
            </div>

            <ul class="recent__list" id="devRecentViewContent">
                  <li class="recent__box devForbizTpl" id="devRecentViewList">
                        <div class="check-area" style="display:none;">
                              <input type="checkbox" id="recentList_{[index_]}" name="recentList[]" value="{[id]}" class="item-check">
                        </div>
                        <div class="recent__goods devRecentViewDetail" data-id="{[id]}">
                              <figure class="recent__goods__thumb">
                                    <img src="{[image_src]}" alt="{[pname]}">
                              </figure>
                              <div class="recent__goods__info">
                                    <p class="recent__goods__title">{[pname]}</p>
                                    <div class="recent__goods__price">
                                          {[#if isDiscount]}
                                          <span class="recent__goods__price--strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[listprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                          <span class="recent__goods__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[dcprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                          <span class="recent__goods__price--discount"><em>30</em>%</span>
                                          {[else]}
                                          <span class="recent__goods__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[dcprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                          {[/if]}

                                          {[#if state_soldout]}
                                          <p class="recent__goods__price--soldout">[Out of stock]</p>
                                          {[/if]}
                                    </div>

                                    <div class="recent__goods__btn">
                                          <a href="/shop/goodsView/{[id]}" class="recent__goods__btn--buy">BUY NOW</a>
                                          <label class="recent__goods__btn--wish {[#if alreadyWish]}on{[/if]}" devwishbtn="{[id]}">
                                                {[#if alreadyWish]}
                                                <input type="checkbox" class="goods-list__wish__btn" checked>
                                                {[else]}
                                                <input type="checkbox" class="goods-list__wish__btn">
                                                {[/if]}
                                                <span>Wish list</span>
                                          </label>
                                    </div>
                              </div>
                              <button type="button" class="recent__goods__del devRecentDel" data-pid="{[id]}">Delete Button</button>
                        </div>
                  </li>

                  <li id="devRecentViewLoading">
                        <div class="empty-content">
                              <div class="wrap-loading">
                                    <div class="loading"></div>
                              </div>
                        </div>
                  </li>

                  <li class="empty-content devForbizTpl" id="devRecentViewEmpty">No Recently Viewed Items</li>
            </ul>
      </form>
      <div class="recent__notice">
            <p class="recent__notice__title">Recent viewed item</p>
            <ul class="recent__notice__list">
                  <li class="recent__notice__desc">· Up to 50 items are saved and deleted sequentially, so it is convenient to keep them on the wish list.</li>
                  <li class="recent__notice__desc">· For non-members only, the recent viewed item storage period is one day, so please log in and use it.</li>
            </ul>
      </div>
</div>