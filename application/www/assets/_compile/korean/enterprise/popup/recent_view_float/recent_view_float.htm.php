<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/popup/recent_view_float/recent_view_float.htm 000004945 */ ?>
<div class="br__recent">
      <form id="devRecentViewForm">
            <input type="hidden" name="page" value="1" id="devPage"/>
            <input type="hidden" name="max" value="50"/>
            <input type="hidden" name="order" value="50"/>

            <div class="list-top-area clearfix devForbizTpl" id="devRecentViewSelector">
                  <div class="float-l mat10">
                        <input type="checkbox" id="all-check">
                        <label for="all-check">전체선택</label>
                  </div>
                  <button class="btn-s btn-white float-r" id='devBtnDelRecent'>삭제</button>
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
                                          <p class="recent__goods__price--soldout">[[품절]]</p>
                                          {[/if]}
                                    </div>

                                    <div class="recent__goods__btn">
                                          <a href="/shop/goodsView/{[id]}" class="recent__goods__btn--buy">구매하기</a>
                                          <label class="recent__goods__btn--wish {[#if alreadyWish]}on{[/if]}" devwishbtn="{[id]}">
                                                {[#if alreadyWish]}
                                                <input type="checkbox" class="goods-list__wish__btn" checked>
                                                {[else]}
                                                <input type="checkbox" class="goods-list__wish__btn">
                                                {[/if]}
                                                <span>위시리스트</span>
                                          </label>
                                    </div>
                              </div>
                              <button type="button" class="recent__goods__del devRecentDel" data-pid="{[id]}">삭제버튼</button>
                        </div>
                  </li>

                  <li id="devRecentViewLoading">
                        <div class="empty-content">
                              <div class="wrap-loading">
                                    <div class="loading"></div>
                              </div>
                        </div>
                  </li>

                  <li class="empty-content devForbizTpl" id="devRecentViewEmpty">최근 본 상품이 없습니다.</li>
            </ul>
      </form>
      <div class="recent__notice">
            <p class="recent__notice__title">최근 본 상품 안내</p>
            <ul class="recent__notice__list">
                  <li class="recent__notice__desc">· 최근 본 상품은 50개까지 저장되며 순차적으로 삭제되오니 상품을 위시리스트에 보관하시는 것이 편리합니다.</li>
                  <li class="recent__notice__desc">· 비회원 고객님들에 한하여 최근 본 상품 보관 기간은 1일이오니 로그인 후 이용해 주시기 바랍니다.</li>
            </ul>
      </div>
</div>