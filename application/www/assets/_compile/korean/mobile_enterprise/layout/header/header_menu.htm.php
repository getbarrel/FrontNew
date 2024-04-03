<?php /* Template_ 2.2.8 2024/03/21 16:49:56 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/layout/header/header_menu.htm 000014008 */ 
$TPL_displayContentClassList_1=empty($TPL_VAR["displayContentClassList"])||!is_array($TPL_VAR["displayContentClassList"])?0:count($TPL_VAR["displayContentClassList"]);
$TPL_displayContentClassDepthList_1=empty($TPL_VAR["displayContentClassDepthList"])||!is_array($TPL_VAR["displayContentClassDepthList"])?0:count($TPL_VAR["displayContentClassDepthList"]);?>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300&display=swap');

    .user-info {padding:20px 18px;}
    .user-info .panel__btn__login {width:100%; background-color:#00bce7; border:#00bce7 1px solid; color:#fff; display:block; font-size:1.3rem; font-weight:600; line-height:3.1rem; margin-bottom:10px; text-align:center;}
    .user-info .panel__btn__join {width:100%; background-color:#fff; border:#dcdddd 1px solid; color:#000; display:block; font-size:1.3rem; font-weight:600; line-height:3.1rem; text-align:center;}

    .crema-type .br__drawer__cate .cate-box__list__category {font-size:1.4rem; font-weight:600; padding:1.3rem 1.3rem 1.3rem 0;}
    .crema-type .br__drawer__guide .guide-box__title {font-size:1.4rem; margin-bottom:0.8rem;}
    .crema-type .br__drawer__guide .guide-box__link {font-size:1.3rem; margin-top:1.0rem;}
    .crema-type .br__drawer__guide .guide-box__link:after {display:none;}
    .crema-type .br__drawer__cscenter .cscenter-box__title {font-size:1.4rem; margin-bottom:0.8rem;}
    .crema-type .br__drawer__cscenter .cscenter-box__desc {font-size:1.2rem;}
    .crema-type .br__drawer__cscenter .cscenter-box__link {font-size:1.3rem; margin-top:1.0rem;}
    .crema-type .br__drawer__cscenter .cscenter-box__link:after {display:none;}

    .crema-type .br__drawer__sns .sns-box {padding:2.5rem 0;}
    .crema-type .br__drawer__sns .sns-box__title {padding:0 2.5rem;}
    .crema-type .br__drawer__sns .sns-box__desc {letter-spacing:-1px; padding:0 2.5rem;}
    .crema-type .br__drawer__sns .sns-box__wrapper {padding:0 1rem;}
    .crema-type .br__drawer__sns .sns-box__list {width:25%; text-align:center;}
    .crema-type .br__drawer__sns .sns-box__list:first-child {padding:0 1rem;}
    .crema-type .br__drawer__sns .sns-box__list:last-child {padding:0 1rem;}
    .crema-type .br__drawer__sns .sns-box__list a {background: url('/assets/mobile_templet/mobile_enterprise/images/layout/icon_drawer_sns.png') no-repeat 0 0; background-size:17.05rem 3.5rem; display:inline-block;}
    .crema-type .br__drawer__sns .sns-box__list--facebook a {background-position-x:-8.8rem;}
    .crema-type .br__drawer__sns .sns-box__list--youtube a {background-position-x:-13.1rem;}
    .crema-type .br__drawer__sns .sns-box__list--blog a {background-position-x:-3.5rem;}
    .crema-type .br__drawer__sns .sns-box__list--pola a {background-position-x:-4.4rem;}

    .crema-type .br__drawer__global .global-box__select {width:8rem; border:none;}
    .crema-type .br__drawer__global .global-box__select__btn {font-size:12px; padding:0;}
    .crema-type .br__drawer__global .global-box__select__btn img {width:auto; height:20px; margin-right:5px; vertical-align:middle;}
    .crema-type .br__drawer__global .global-box__select__btn:before {display:none;}

    .crema-type .br__drawer__global .global-box__select__list li a {font-size:12px; text-align:left;}
    .crema-type .br__drawer__global .global-box__select__list li img {width:auto; height:20px; margin-right:5px; vertical-align:middle;}

</style>

<section class="br__dockbar">
    <ul class="br__dockbar__list">
        <li class="dockbar-list">
            <button class="dockbar-list__btn dockbar-list__btn--category">카테고리</button>
        </li>
        <li class="dockbar-list <?php if($_SERVER['PHP_SELF']=='/index.php/mypage/orderHistory'){?>dockbar-list--active<?php }?>">
            <a href="/mypage/orderHistory" class="dockbar-list__btn dockbar-list__btn--delivery">배송조회</a>
        </li>
        <li class="dockbar-list <?php if($_SERVER['PHP_SELF']=='/index.php'){?>dockbar-list--active<?php }?>">

            <a href="/" class="dockbar-list__btn dockbar-list__btn--home"><?php if($TPL_VAR["langType"]=='english'){?>HOME<?php }else{?>배럴홈<?php }?></a>
        </li>
        <li class="dockbar-list <?php if($_SERVER['PHP_SELF']=='/mypage/index.php'){?>dockbar-list--active<?php }?>">
            <a href="/mypage/" class="dockbar-list__btn dockbar-list__btn--mypage">마이페이지</a>
        </li>
        <li class="dockbar-list">
            <button class="dockbar-list__btn dockbar-list__btn--recent open-layer__recent-view" data-title="최근본상품"><?php if($TPL_VAR["langType"]=='english'){?>Viewed<?php }else{?>최근본상품<?php }?></button>
        </li>
    </ul>
</section>

<!-- 좌측 슬라이드 메뉴 S --> 
<section class="br__drawer">
	<h2 class="hidden">drawer menu</h2>
	<section class="br__drawer__search">
		<div class="br__search-inner">
			<div class="br__search__title">
				<div class="wrap_search-bar">
					<label for="devHeaderSearchTextMenu" class="hide">검색어 입력 영역</label>
					<input class="search-input br__form-input" type="text" id="devHeaderSearchTextMenu" placeholder="검색어를 입력해 주세요." onblur="removeHeaderTag(this.value);" onkeyup="igChk()" autocomplete="off" data-id="devHeaderSearchTextMenu">
					<button class="search-btn" id="devHeaderSearchButtonMenu">
						<i class="ico ico-search"></i>
					</button>
				</div>
				<div class="wrap_search-close">
					<button class="search-close" title="닫기" onclick="SideLayerJS('navigation');">닫기</button>
				</div>
			</div>
			<!-- <div class="br__search__layer">
				<div class="auto-complete">
					<ul class="auto-complete__list">
						<li>
							<a href="#"><em>래</em>쉬가드</a>
						</li>
						<li>
							<a href="#">오션 <em>래</em>쉬가드</a>
						</li>
						<li>
							<a href="#">남자 <em>래</em>쉬가드</a>
						</li>
						<li>
							<a href="#">여자 <em>래</em>쉬가드</a>
						</li>
						<li>
							<a href="#">키즈 <em>래</em>쉬가드</a>
						</li>
					</ul>
				</div>
			</div> -->
		</div>
	</section>
	<div class="br__drawer__scroll">
		<section class="br__drawer__goods">
			<div class="br__drawer__cate">
				<div class="cate-box cate-box--depth1 cate-box--active">
					<ul class="cate-box__wrapper">
<?php if(is_array($TPL_R1=$TPL_VAR["headerMenu"]["categoryList"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>	
						<li class="cate-box__list"  data-cid="<?php echo $TPL_V1["cid"]?>">

<?php if(!empty($TPL_V1["subCateList"])){?>
								<button type="button" class="cate-box__list__category"><?php echo $TPL_V1["cname"]?></button>
<?php }else{?>
<?php if($TPL_V1["category_type"]=="C"){?>
									<a href="/shop/goodsList/<?php echo $TPL_V1["cid"]?>" class="cate-box__list__category"><?php echo $TPL_V1["cname"]?></a>
<?php }else{?>
									<a href="<?php echo $TPL_V1["category_link"]?>" class="cate-box__list__category"><?php echo $TPL_V1["cname"]?></a>
<?php }?>
<?php }?>
						</li>
<?php }}?>

						<li class="cate-box__list">
							<a href="/content/styleList" class="cate-box__list__category">스타일 가이드</a>
						</li>
						<li class="cate-box__list">
							<a href="/event/eventList" class="cate-box__list__category">이벤트</a>
						</li>
					</ul>
				</div>

<?php if(is_array($TPL_R1=$TPL_VAR["headerMenu"]["categoryList"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
				<div id="<?php echo $TPL_V1["cid"]?>" class="cate-box cate-box--depth2" data-depth="<?php echo $TPL_V1["depth"]?>">
					<div class="cate-box__navi">
						<button type="button" class="cate-box__navi__back">이전</button>
					</div>
					<div class="cate-box__title">
						<div class="title-md" data-cid="<?php echo $TPL_V1["cid"]?>"><?php echo $TPL_V1["cname"]?></div>
					</div>
					<ul class="cate-box__wrapper">
						<li class="cate-box__list">
<?php if($TPL_V1["category_type"]=="C"){?>
								<a href="/shop/goodsList/<?php echo $TPL_V1["cid"]?>" class="cate-box__list__category"><?php echo $TPL_V1["cname"]?> 전체</a>
<?php }else{?>
								<a href="<?php echo $TPL_V1["category_link"]?>" class="cate-box__list__category"><?php echo $TPL_V1["cname"]?> 전체</a>
<?php }?>
						</li>
<?php if(is_array($TPL_V1["subCateList"])){?>
<?php if(is_array($TPL_R2=$TPL_V1["subCateList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
								<li class="cate-box__list" data-cid="<?php echo $TPL_V2["cid"]?>">
<?php if(!empty($TPL_V2["subCateList"])){?>
										<button type="button" class="cate-box__list__category"><?php echo $TPL_V2["cname"]?></button>
<?php }else{?>
<?php if($TPL_V2["category_type"]=="C"){?>
											<a href="/shop/goodsList/<?php echo $TPL_V2["cid"]?>" class="cate-box__list__category"><?php echo $TPL_V2["cname"]?></a>
<?php }else{?>
											<a href="<?php echo $TPL_V2["category_link"]?>" class="cate-box__list__category"><?php echo $TPL_V2["cname"]?></a>
<?php }?>
<?php }?>
									<div class="cate-box cate-box--depth3">
										<ul class="cate-box__wrapper">
											<li class="cate-box__list">
<?php if($TPL_V2["category_type"]=="C"){?>
												<a href="/shop/goodsList/<?php echo $TPL_V2["cid"]?>" class="cate-box__list__category"><?php echo $TPL_V2["cname"]?> (전체보기)</a>
<?php }else{?>
												<a href="<?php echo $TPL_V2["category_link"]?>" class="cate-box__list__category"><?php echo $TPL_V2["cname"]?> (전체보기)</a>
<?php }?>
											</li>
<?php if(is_array($TPL_R3=$TPL_V2["subCateList"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
											<li class="cate-box__list" data-cid="<?php echo $TPL_V3["cid"]?>">
<?php if($TPL_V3["category_type"]=="C"){?>
												<a href="/shop/goodsList/<?php echo $TPL_V3["cid"]?>" class="cate-box__list__category"><?php echo $TPL_V3["cname"]?></a>
<?php }else{?>
												<a href="<?php echo $TPL_V3["category_link"]?>" class="cate-box__list__category"><?php echo $TPL_V3["cname"]?></a>
<?php }?>
<?php }}?>
											</li>
										</ul>
									</div>
								</li>
<?php }}?>
<?php }?>
					</ul>
				</div>
<?php }}?>
			</div>
		</section>
		<section class="br__drawer__cscenter">
			<div class="cscenter-box">
				<div class="cscenter-box__item">
					<a href="/customer/storeInformation">매장안내</a>
					<a href="/customer/">고객센터</a>
					<a href="/customer/bestReview">베스트 리뷰</a>
				</div>
				<!--<div class="cscenter-box__item">
					<a href="/customer/bestReview">제품후기</a>
				</div>-->
			</div>
			<div class="cscenter-sns">
				<ul>
					<li>
						<a class="js__sns__open" href="https://www.instagram.com/getbarrel.official/"><i class="ico ico-instargram-BK">인스타그램</i></a>
					</li>
					<li>
						<a href="https://pf.kakao.com/_VxfxjDd"><i class="ico ico-KakaoTalk-BK">카카오</i></a>
					</li>
					<!--<li>
						<a href="https://www.facebook.com/pages/Barrel/1416024818648425"><i class="ico ico-facebook-BK">페이스북</i></a>
					</li>-->
					<li>
						<a href="https://www.youtube.com/c/getbarrel"><i class="ico ico-youtube-BK">유튜브</i></a>
					</li>
				</ul>
			</div>
		</section>
	</div>
</section>
<!-- 좌측 슬라이드 메뉴 E -->

<!-- 배럴인사이드 메뉴 S -->
<section id="inside" class="br__inside">
	<div class="br__inside-inner">
		<div class="br__inside-haed">
			<button type="button" class="btn-close" onclick="DownLayerJS('inside');">닫기</button>
		</div>
		<div class="br__inside-body">
<?php if($TPL_displayContentClassList_1){foreach($TPL_VAR["displayContentClassList"] as $TPL_V1){?>
<?php if($TPL_V1["cid"]=='001001000000000'){?>
					<!--<div class="title-md">기획전</div>-->
					<a href="/content/specialList" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><div class="title-md"><?php echo $TPL_V1["cname"]?></div></a>
<?php }?>
<?php }}?>
			<ul class="br__inside-list">
				<li>
					<a href="/content/specialList">전체</a>
				</li>
<?php if($TPL_displayContentClassDepthList_1){foreach($TPL_VAR["displayContentClassDepthList"] as $TPL_V1){?>
					<li>
						<a href="/content/specialList/<?php echo $TPL_V1["cid"]?>" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["cname"]?></a>
					</li>
<?php }}?>
				<!--<li>
					<a href="/content/focusNow1">컬렉션</a>
				</li>
				<li>
					<a href="/content/focusNow2">배럴 저널</a>
				</li>
				<li>
					<a href="/content/focusNow3">캠패인</a>
				</li>
				<li>
					<a href="/content/focusNow4">브랜드 스토리</a>
				</li>-->
			</ul>
			<ul class="br__inside-list">
<?php if($TPL_displayContentClassList_1){foreach($TPL_VAR["displayContentClassList"] as $TPL_V1){?>
<?php if($TPL_V1["cid"]!='001001000000000'){?>
						<li>
							<a href="<?php if($TPL_V1["cid"]=='001002000000000'){?>/content/styleList<?php }elseif($TPL_V1["cid"]=='001003000000000'){?>/content/teamList<?php }elseif($TPL_V1["cid"]=='001004000000000'){?>/customer/bestReview<?php }?>" class="brandNav__main-link"><div class="title-md"><?php echo $TPL_V1["cname"]?></div></a>
						</li>
<?php }?>
<?php }}?>
				<!--<li>
					<a href="/content/specialList"><div class="title-md">스타일 큐레이션</div></a>
				</li>
				<li>
					<a href="/content/teamList"><div class="title-md">팀 배럴</div></a>
				</li>
				<li>
					<a href="/content/teamDetail"><div class="title-md">베스트 리뷰</div></a>
				</li>-->
			</ul>
		</div>
	</div>
</section>
<!-- 배럴인사이드 메뉴 E -->