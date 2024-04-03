<?php /* Template_ 2.2.8 2021/01/26 15:07:52 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/layout/header/header_top.htm 000009146 */ 
$TPL_topBeltBanner_1=empty($TPL_VAR["topBeltBanner"])||!is_array($TPL_VAR["topBeltBanner"])?0:count($TPL_VAR["topBeltBanner"]);?>
<?php if($TPL_VAR["topBeltBanner"]){?>
<section class="header__banner swiper-container" style="display:none;">
    <div class="swiper-wrapper">
<?php if($TPL_topBeltBanner_1){foreach($TPL_VAR["topBeltBanner"] as $TPL_V1){?>
        <div class="swiper-slide">
            <a href="<?php echo $TPL_V1["bannerLink"]?>" class="header__banner__link">
                <figure class="header__banner__image">
                    <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">
                    <!--<img src="//getbarrel.com/data/barrel_data/images/banner/798/상단띠배너.jpg" alt="<?php echo $TPL_V1["banner_name"]?>">-->
                </figure>
            </a>
        </div>
        <!--<div class="swiper-slide">-->
            <!--<a href="<?php echo $TPL_V1["bannerLink"]?>" class="header__banner__link">-->
                <!--<figure class="header__banner__image">-->
                    <!--&lt;!&ndash;<img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["banner_name"]?>">&ndash;&gt;-->
                    <!--<img src="//getbarrel.com/data/barrel_data/images/banner/798/상단띠배너.jpg" alt="<?php echo $TPL_V1["banner_name"]?>">-->
                <!--</figure>-->
            <!--</a>-->
        <!--</div>-->
<?php }}?>
    </div>
    <button type="button" class="header__banner__close">상단 띠배너 닫기</button>
</section>
<?php }?>
<section class="br__header__inner">
    <div class="inner">
        <h1><a href="/"></a></h1>
        <button href="#navigation" class="inner__menu">menu</button>
        <a href="javascript:void(0)" id="icon_search" class="inner__search" onclick="searchLayerOpen();">search</a>
        <a href="/shop/cart" class="inner__cart">cart<em class="inner__cart__count"><?php echo number_format($TPL_VAR["layoutCommon"]["userInfo"]["cartCnt"])?></em></a>
    </div>
</section>

<style>
    .crema-type .br__search {background:rgba(255,255,255,.95); padding-top:13rem;}

    .crema-type .br__search__title {background:none; padding:0 1.5rem;}
    .crema-type .br__search__title .wrap_search-close {height:4rem; position:relative;}
    .crema-type .br__search__title .wrap_search-bar {margin-top:5rem; position:relative;}
    .crema-type .br__search__title .search-close {width:4.5rem; height:4rem; right:-1.25rem; top:1rem;}
    .crema-type .br__search__title .search-input {height:4rem; background:none; border-bottom:#000 5px solid; border-radius:0; color:#000; font-family:'Noto Sans KR'; font-size:1.8rem !important; font-weight:bold; line-height:2.1rem !important; letter-spacing:-1px; padding:0 4.5rem 0 1rem;}
    .crema-type .br__search__title .wrap_search-bar input::-ms-input-placeholder {color:#b5b5b6;}
    .crema-type .br__search__title .wrap_search-bar input::-webkit-input-placeholder {color:#b5b5b6;}
    .crema-type .br__search__title .wrap_search-bar input::-moz-input-placeholder {color:#b5b5b6;}
    .crema-type .br__search__title .search-btn {width:4.3rem; height:2.5rem; right:0.5rem; top:0.5rem;}

    .crema-type .br__search__content {background:none; margin:0; padding:4rem 3rem 0;}

    .crema-type .br__search__content .popularity__word {width:50%; border-top:none; float:left;}
    .crema-type .br__search__content .popularity__word .search__list a:before {width:1.2rem; color:#000; display:inline-block; font-size:1rem; line-height:1.8rem; font-weight:normal;}
    .crema-type .br__search__content .search__list li a {color:#000; font-size:1rem; line-height:1.8rem; font-weight:normal; padding:0 0 0.7rem;}

    .crema-type .br__search__content .late__word {width:50%; float:left;}

    .crema-type .br__search__content .search-title {font-size:1.3rem; line-height:2.2rem; font-weight:bold; padding:0 0 2rem;}
    .crema-type .br__search__content .search-title button {border-bottom:none; color:#b5b5b6; font-size:1rem; line-height:1.8rem; font-weight:normal; right:0; top:-0.1rem;}
    .crema-type .br__search__content .search__list li button {width:8px; height:8px; background-size:100% 100%; background-position:0 0; opacity:0.5; padding:0; right:0; top:0.5rem;}

    .crema-type .br__search__layer {position:absolute; top:13rem;}
    .crema-type .br__search__layer .auto-complete {background:none; padding:0 1.5rem;}
    .crema-type .br__search__layer .auto-complete .auto-complete__list {background:#fff; border:#b1b1b1 1px solid; border-width:0 1px 1px 1px; padding:1.2rem 0;}
    .crema-type .br__search__layer .auto-complete__list li a {border-bottom:none; font-size:1rem; line-height:1.8rem; font-weight:normal; padding:0.3rem 0;}
    .crema-type .br__search__layer .auto-complete__list li button {display:none;}
    .crema-type .br__search__layer .auto-complete__list li span {color:#00bce7 !important;}




    /*.crema-type .br__search__title .search-close {background:url('https://m.stg.barrelmade.co.kr/assets/mobile_templet/mobile_enterprise/_/img/icon/m_sprite_icon.png') no-repeat; background-size:50%; background-position:0 150px;}*/
</style>
<!-- 2019.07.04 검색 영역 -->
<section class="br__search" style="display:none;">
    <!-- 검색어 입력 -->
        <script type="text/javascript">
            function igChk(){
                var ig_chkVal = document.getElementById("devHeaderSearchText").value;
                if(ig_chkVal == "") {
                    $(".br__search__layer").css("display", "none");
                }
            }
        </script>


    <article class="br__search__title">
        <div class="wrap_search-close">
            <button class="search-close" title="닫기" onclick="searchLayerClose()"></button>
        </div>
        <div class="wrap_search-bar">
            <input class="search-input devAutoComplete" type="text" id="devHeaderSearchText" placeholder="Please enter a search word." onblur="removeHeaderTag(this.value);" onkeyup="igChk()"/>
            <button class="search-btn" id="devHeaderSearchButton"></button>
        </div>
    </article>
    <!-- EOD : 검색어 입력 -->

    <!-- 검색 자동완성 -->
    <article class="br__search__layer" style="display:none;">
        <div class="auto-complete">
            <ul class="auto-complete__list">
                <li><a href="#"><em>Rashguard</em></a><button></button></li>
                <li><a href="#">Bra-top <em>Rashguard</em></a><button></button></li>
                <li><a href="#">ODD <em>Rashguard</em></a><button></button></li>
                <li><a href="#">Loose fit <em>Rashguard</em></a><button></button></li>
                <li><a href="#">Zip-up <em>Rashguard</em></a><button></button></li>
            </ul>
        </div>
    </article>
    <!-- EOD : 검색 자동완성 -->

    <!-- 최근검색어, 인기검색어 리스트 -->
    <article class="br__search__content">
        <!-- 인기검색어 -->
        <div class="popularity__word">
            <h2 class="search-title">Popular Search</h2>
            <ul class="search__list">
<?php if(is_array($TPL_R1=$TPL_VAR["headerTop"]["popularKeyword"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
<?php if($TPL_K1< 10){?>
                <li><a href="/shop/search/?searchText=<?php echo rawurlencode($TPL_V1["keyword"])?>"><?php echo $TPL_V1["keyword"]?></a></li>
<?php }?>
<?php }}?>
            </ul>
        </div>
        <!-- EOD : 인기검색어 -->

        <!-- 최근검색어 -->
        <div class="late__word">
            <h2 class="search-title">Recent Search<button id="devRecentKeyWordDeleteAll" <?php if($TPL_VAR["headerTop"]["recentKeyword"]){?>style="display:none;"<?php }?>>Delete All</button></h2>
<?php if($TPL_VAR["headerTop"]["recentKeyword"]){?>
            <ul class="search__list" id="devRecent">
<?php if(is_array($TPL_R1=$TPL_VAR["headerTop"]["recentKeyword"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_K1=>$TPL_V1){?>
                <li devDelKey="<?php echo $TPL_K1?>">
                    <a href="/shop/search/?searchText=<?php echo rawurlencode($TPL_V1)?>">
                        <?php echo $TPL_V1?>

                    </a>
                    <button class="search__word-del" id="devRecentKeyWordDelete" devDelText="<?php echo $TPL_V1?>"></button>
                </li>
<?php }}?>
            </ul>
<?php }?>
        </div>
        <!-- EOD : 최근검색어 -->

    </article>
    <!-- EOD : 최근검색어, 인기검색어 리스트 -->
</section>
<!-- EOD : 2019.07.04 검색 영역 -->

<?php if($TPL_VAR["headerTop"]["randomCoupon"]){?>
<div id="devRandomCouponArea" class="randomCoupon"  data-percent="<?php echo $TPL_VAR["headerTop"]["randomCouponInfo"]["percentage"]?>">
	<img src="<?php echo $TPL_VAR["headerTop"]["randomCouponInfo"]["gift_file_path"]?>" alt="쿠폰이미지">
	<input type="button" value="쿠폰발행" id="devRandomCouponIssue" data-gcix="<?php echo $TPL_VAR["headerTop"]["randomCouponInfo"]["gc_ix"]?>" />
</div>
<?php }?>