<?php /* Template_ 2.2.8 2024/03/20 11:26:49 /home/barrel-stage/application/www/assets/templet/enterprise/shop/search/search.htm 000008362 */ ?>
<script>
    var productList = [];
</script>

<form id="devListForm">
    <input type="hidden" name="page" value="1" id="devPage"/>
    <input type="hidden" name="max" value="20" id="devMax"/>
    <input type="hidden" name="orderBy" value="regdateDesc" id="devSort" />
    <input type="hidden" name="vlevel1" value="1" />

    <input type="hidden" name="filterCid" value="<?php echo $TPL_VAR["cid"]?>" id="devCid" />
    <input type="hidden" name="filterBrands" value="" />
    <input type="hidden" name="filterDeliveryFree" value="" />
    <input type="hidden" name="filterInsideText" value="" />
    <input type="hidden" name="filterText" value="<?php echo $TPL_VAR["searchText"]?>" />
    <input type="hidden" name="filterSearchPage" value="T" />

    <input type="hidden" name="product_filter" value="" id="devProductFilter" />
    <input type="hidden" name="sprice" value="" id="devSprice" />
    <input type="hidden" name="eprice" value="" id="devEprice" />
    <input type="hidden" name="price_type" value="" id="devPriceType" />
</form>
<!-- 컨텐츠 영역 S -->
<section class="fb__search">
	<section class="fb__search__top">
		<div class="fb__search__inner">
			<div class="fb__search__research">
				<fieldset class="search-area">
					<div class="search-area__inner">
						<label for="devHeaderSearchText" class="hide">검색텍스트</label>
						<input type="text" class="header-input-search search-area__text devAutoComplete devAutoCompleteDetail devInsideText" id="devSearchText" placeholder="검색어를 입력해주세요." onblur="removeTag(this.value);" onkeypress="removeKeyPress(this.value);" onkeydown="removeKeydown(this.value);"/>
						<i class="search_close_btn" id="devSearchCloseBtn"></i>
						<button class="search-area__del">삭제버튼</button>
						<input type="button" id="devGoInsideSearch" class="btn_sch_submit"/>
						<!-- 텍스트 입력시 자동 완성 텍스트 레이어 S -- 
						<div class="search-area__layer">
							<ul class="search-area__auto-text">
								<li>
									<a href="#;"> <span>래</span>쉬가드 </a>
								</li>
								<li>
									<a href="#;"> 오션 <span>래</span>쉬가드 </a>
								</li>
								<li>
									<a href="#;"> 남자 <span>래</span>쉬가드 </a>
								</li>
								<li>
									<a href="#;"> 여자 <span>래</span>쉬가드 </a>
								</li>
								<li>
									<a href="#;"> 키즈 <span>래</span>쉬가드 </a>
								</li>
							</ul>
						</div>
						텍스트 입력시 자동 완성 텍스트 레이어 E -->
					</div>
				</fieldset>
			</div>
			<div class="fb__search__footer">
				<h2 class="fb__search__title"><strong>‘<?php echo $TPL_VAR["searchText"]?>’</strong>의 검색 결과</h2>
				<p class="fb__search__info"><span id="devPrdSearchTotal"></span>개의 검색 결과</p>
				
			</div>
		</div>
	</section>
	<!-- 상품 리스트 S -->
	<div class="fb__goods-list">
		<section class="fb__goods-list__contents">
			<div class="list-contents">
				<div class="list-contents__header">
					<h3 class="fb__main__title--hidden">상품 리스트</h3>
					<nav class="list-contents__nav">
						<div class="filter">
                            <select name="count" class="fb__select devChangeMax">
								<option value="20" selected="selected">20개씩 보기</option>
								<option value="40">40개씩 보기</option>
								<option value="60">60개씩 보기</option>
							</select>
							<select name="sort" class="fb__select devSortTab">
                                <option value="regDate" selected="selected">최신상품순</option>
                                <option value="orderCnt" >판매인기순</option>
                                <option value="lowPrice" >낮은가격순</option>
                                <option value="highPrice" >높은가격순</option>
                                <option value="afterCnt" >상품후기순</option>
                            </select>
						</div>
					</nav>
				</div>
				<div class="fb__main__goods fb__main__goodsInner">
					<!--필터 검색 시 검색 결과가 없을 시 S -- 
					<div id="devEmptyKeyword" class="empty-content">
						<p class="fb__search-noresult__info"><i></i> <span>검색 결과가 없습니다.</span></p>
						<div class="fb__search-noresult__list">
							<span>-검색어가 올바르게 입력되었는지 확인해 주세요.</span>
							<span>-일반적인 검색어로 다시 검색해 주세요.</span>
							<span>-검색어의 띄어쓰기를 다르게 해보세요.</span>
						</div>
					</div>
					필터 검색 시 검색 결과가 없을 시 E -->
					<ul class="fb__goods three-boxes-wrap" id="devListContents">
					
						<li class="devForbizTpl" id="devSubCategorys"></li> 
						<li class="devForbizTpl" id="devSelected"></li> 
						<li class="empty-content devListLoading" id="devListLoading">loading...</li>
						<li class="empty-content devForbizTpl" id="devListEmpty">
							<p class="fb__search-noresult__info"><i></i> <span>검색 결과가 없습니다.</span></p>
							<div class="fb__search-noresult__list">
								<span>-검색어가 올바르게 입력되었는지 확인해 주세요.</span>
								<span>-일반적인 검색어로 다시 검색해 주세요.</span>
								<span>-검색어의 띄어쓰기를 다르게 해보세요.</span>
							</div>	
						</li>

						
						<li class="fb__goods__list" id="devListDetail">
							<script> productList.push("{[id]}") </script>
							<!-- Criteo 카테고리/검색/리스팅 태그 23.06.29--> 
							<script type="text/javascript">
								if (productList.length == 4) {
									window.criteo_q = window.criteo_q || [];
									var deviceType = /iPad/.test(navigator.userAgent) ? "t" : /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Silk/.test(navigator.userAgent) ? "m" : "d";
									window.criteo_q.push(
										{ event: "setAccount", account: 104564},
										{ event: "setEmail", email: "", hash_method: "" },
										{ event: "setZipcode", zipcode: "" },
										{ event: "setSiteType", type: deviceType},
										{ event: "viewList",
											item: [productList[1], productList[2], productList[3]],
											keywords: "<?php echo $TPL_VAR["searchText"]?>"
										});
								}
							</script>
							<!-- END Criteo 카테고리/검색/리스팅 태그 --> 
							<a href="/shop/goodsView/{[id]}" class="fb__goods__link">
								<figure class="fb__goods__img">
									{[#if timeSaleIconView]}
									<img src="{[timeSaleIcon]}" class="product-box__time-deal" >
									{[/if]}
									<div>
										<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="{[image_src]}" onmouseover="this.src='{[image_src2]}'" onmouseout="this.src='{[image_src]}'">
									</div>
								</figure>
								<div class="fb__goods__info">
									<ul class="fb__goods__infoBox">
										{[#if prefaceName]}<p class="fb__goods__etc" style="color:{[prefaceColor]};{[b_preface]}{[i_preface]}{[u_preface]}">{[prefaceName]}</p>{[/if]}
										<li class="fb__goods__name">{[pname]}</li>
										<li class="fb__goods__option">{[add_info]}</li>
										<li class="fb__goods__brand">{[brand_name]}</li>
									</ul>
								</div>
								<div class="fb__goods__important">
									{[#if is_soldout]}
										<span class="goods-list__price__state" style="color:#ff4e00;font-size:12px;">[품절]</span>
									{[else]}
										{[#if discount_rate]}
										<div class="fb__goods__sale">
											<p class="per"><em>{[discount_rate]}</em>%</p>
										</div>
										{[/if]}
										<span class="fb__goods__price">{[dcprice]}</span>
										<span class="fb__goods__noprice">{[#if isDiscount]}{[listprice]}{[/if]}</span>
									{[/if]}
								</div>
								<p class="fb__goods__condition">30,000원 이상 구매 시 무료배송</p>
							</a>
							<a href="javascript:void(0);" class="product-box__heart {[#if alreadyWish]}product-box__heart--active{[/if]}" data-devWishBtn="{[id]}">hart</a>
						</li>
					</ul>
				</div>
			</div>
			<div id="devPageWrap"></div>
		</section>
	</div>
	<!-- 상품 리스트 E -->
</section>
<!-- 컨텐츠 영역 E -->