<?php /* Template_ 2.2.8 2021/12/02 12:53:19 /home/barrel-stage/application/www/assets/templet/enterprise/shop/goods_view/goods_view.htm 000096417 */ 
$TPL_categorys_1=empty($TPL_VAR["categorys"])||!is_array($TPL_VAR["categorys"])?0:count($TPL_VAR["categorys"]);
$TPL_add_image_src_1=empty($TPL_VAR["add_image_src"])||!is_array($TPL_VAR["add_image_src"])?0:count($TPL_VAR["add_image_src"]);
$TPL_icons_path_1=empty($TPL_VAR["icons_path"])||!is_array($TPL_VAR["icons_path"])?0:count($TPL_VAR["icons_path"]);
$TPL_sameProduct_1=empty($TPL_VAR["sameProduct"])||!is_array($TPL_VAR["sameProduct"])?0:count($TPL_VAR["sameProduct"]);
$TPL_colorChipList_1=empty($TPL_VAR["colorChipList"])||!is_array($TPL_VAR["colorChipList"])?0:count($TPL_VAR["colorChipList"]);
$TPL_product_gift_1=empty($TPL_VAR["product_gift"])||!is_array($TPL_VAR["product_gift"])?0:count($TPL_VAR["product_gift"]);
$TPL_togeterProduct_1=empty($TPL_VAR["togeterProduct"])||!is_array($TPL_VAR["togeterProduct"])?0:count($TPL_VAR["togeterProduct"]);
$TPL_similraProduct_1=empty($TPL_VAR["similraProduct"])||!is_array($TPL_VAR["similraProduct"])?0:count($TPL_VAR["similraProduct"]);
$TPL_eventBannerInfo_1=empty($TPL_VAR["eventBannerInfo"])||!is_array($TPL_VAR["eventBannerInfo"])?0:count($TPL_VAR["eventBannerInfo"]);
$TPL_productGiftInfo_1=empty($TPL_VAR["productGiftInfo"])||!is_array($TPL_VAR["productGiftInfo"])?0:count($TPL_VAR["productGiftInfo"]);
$TPL_mandatoryInfos_1=empty($TPL_VAR["mandatoryInfos"])||!is_array($TPL_VAR["mandatoryInfos"])?0:count($TPL_VAR["mandatoryInfos"]);
$TPL_mandatoryInfosGlobal_1=empty($TPL_VAR["mandatoryInfosGlobal"])||!is_array($TPL_VAR["mandatoryInfosGlobal"])?0:count($TPL_VAR["mandatoryInfosGlobal"]);
$TPL_laundryOneDepth_1=empty($TPL_VAR["laundryOneDepth"])||!is_array($TPL_VAR["laundryOneDepth"])?0:count($TPL_VAR["laundryOneDepth"]);
$TPL_laundry_1=empty($TPL_VAR["laundry"])||!is_array($TPL_VAR["laundry"])?0:count($TPL_VAR["laundry"]);?>
<script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/minicart.js?version=<?php echo CLIENT_VERSION?>" data-url="/controller/product/loadOptionDatas/<?php echo $TPL_VAR["pid"]?>" id="devMinicartScript"></script>

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
    (window,document,'script','crema-jssdk','//<?php echo CREMA_WIDGET_HOST?>/getbarrel.com/init.js');
</script>

<script>
    var emnet_tagm_products=[];
</script>

<script>
emnet_tagm_products.push({
    'name': '<?php echo $TPL_VAR["pname"]?>',
    'id': '<?php echo $TPL_VAR["pid"]?>',
    'price': '<?php echo $TPL_VAR["dcprice"]?>',
    'quantity': '1'
});
</script>

<!-- 상품상세 dataLayer -->
<script>
 dataLayer.push({
     'event': 'viewContent',
     'ecommerce': {
         'detail': {
            'products': emnet_tagm_products
         }
     }
 });
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
    @import url('//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSansNeo.css');
    
    .fb#shop_goodsView .fb__content {width:1370px;}

    .fb__page-nav {padding:61px 0 30px;}
    .fb__goods-view {min-width:1370px;}

    .fb__goods-view__photo2 .photo2 {width:910px; box-sizing:border-box; float:left;}
    .fb__goods-view__photo2 .photo2 .photo2_main_thumb {width:410px; height:513px; box-sizing:border-box; float:left; margin:0 10px 10px 0;}
    .fb__goods-view__photo2 .photo2 .photo2_main_thumb img  {width:100%;}
    .fb__goods-view__photo2 .photo2 .photo2_main_movie {width:410px; height:513px; box-sizing:border-box; float:left; margin:0 10px 10px 0;}

    .fb__goods-view .info {width:460px;}    
    .fb__goods-view .info__name {color:#000; font-size:26px; font-weight:500; line-height:34px; margin-bottom:20px; padding-top:30px; }
    .fb__goods-view .info__number {border-top:#f0f0f0 1px solid; padding-top:18px;}
    .fb__goods-view .info__price--ori {padding-bottom:8px;}
    .fb__goods-view .info__price--now em {font-weight:500; line-height:34px;}
    .fb__goods-view .info__benefit {background-color:#fff; border:#000 1px solid; color:#000; }
    .fb__goods-view .info__benefit span:after {content:'+'; background:none;}
    .fb__goods-view .info__percent {color:#00BCE7; font-family:'SHS', 'Notosans', sans-serif; font-size:26px; font-style:italic; font-weight:200;}
    .fb__goods-view .info__percent em {font-size:40px;}

    .fb__goods-view .info__box {border-top:#f0f0f0 1px solid; padding-bottom:0;}
    .fb__goods-view .info__color__link {width:62px; height:37px; }
    .fb__goods-view .info__color__link--active {border:2px solid #000 !important; outline:none !important;}
    .fb__goods-view .info__color__link--active:before {display:none;}

    .fb__goods-view .goods-info__set {border-bottom:none; padding-bottom:0;}

    .fb__goods-view .goods-info__size {padding-bottom:20px; padding-left:105px;}
    .fb__goods-view .goods-info__size__btn {width:62px; height:37px;}
    .fb__goods-view .goods-info__size__btn--active:before {display:none;}
    .fb__goods-view .goods-info__size__guide {border-bottom:none;}
    .fb__goods-view .goods-info__size__alarm {width:134px; height:37px; line-height:34px;}
    .fb__goods-view .goods-info__size__alarm:hover {background-color:#000; color:#fff;}

    .fb__goods-view .goods-option {margin-bottom:60px;}
    .fb__goods-view .goods-option__box {margin-top:17px;}
    .fb__goods-view .goods-option__box:first-child {margin-top:17px;}

    .fb__goods-view .goods-option__info {margin-top:-5px;}
    .fb__goods-view .goods-option__info__title {min-height:34px; font-size:16px; line-height:34px;}
    .fb__goods-view .goods-option__info__addinfo {color:#666; font-size:14px; line-height:34px;}

    .fb__goods-view .info .goods-cart__price {position:absolute; right:0; top:37px;}

    .fb__goods-view .goods-option .info__box {border-bottom:#000 2px solid;}

    .fb__goods-view .info .info__decided {background:none; border-top:#F0F0F0 1px solid; padding:30px 0; position:relative;}
    .fb__goods-view .info__decided-info {width:320px; color:#000; font-size:16px; line-height:34px; margin-bottom:56px;}
    .fb__goods-view .info .goods-cart__sub {width:320px; bottom:30px; color:#666; font-size:14px; line-height:22px;}

    .fb__goods-view .info__decided-btns {width:120px; height:40px; border:#ddd 1px solid; margin-top:0; position:absolute; right:0; top:30px;}
    .fb__goods-view .info__decided-btns--minus {width:39px; height:38px; background-position:center 5px; border-right:#ddd 1px solid; line-height:40px;}
    .fb__goods-view .info__decided-btns--count {height:38px; line-height:40px;}
    .fb__goods-view .info__decided-btns--plus {width:39px; height:38px; background-position:center 5px; line-height:40px;}

    .fb__goods-view .info__decided-price {bottom:27px; color:#000; float:none; margin:0; position:absolute; right:32px;}
    .fb__goods-view .info__decided-price em {font-family:'Roboto', sans-serif; font-weight:500;}
    .fb__goods-view .info__decided__del {bottom:30px; float:none; position:absolute; right:0;}
    .fb__goods-view .info__decided__del:after {background:url('/assets/templet/enterprise/_/images/shop/btn-del2.png') 0 0 no-repeat; margin-top:0; right:0; top:-17px;}

    .fb__goods-view .info__total-box { margin:57px 0 48px;}
    .goods-option .total-price .tit {color:#000; font-size:18px; line-height:34px;}
    .fb__goods-view .goods-option .total-price .price {color:#000;}
    .goods-option .total-price .price {font-size:20px;}
    .fb__goods-view .goods-option .total-price .price em {color:#000;}
    .goods-option .total-price .price em {font-family:'Roboto', sans-serif; font-size:30px; font-weight:500;}

    .fb__goods-view .goods-btn-area .btn-lg--cart {border:#000 1px solid; color:#000;}
    .fb__goods-view .goods-btn-area .devOrderDirect {background-color:#000; border:#000 1px solid; color:#fff;}
    .fb__goods-view .goods-btn-area .btn-lg {width:225px;}
    .fb__goods-view .goods-btn-area .btn-find-store {width:460px;}

    .fb__goods-view .goods-info__size__btn:disabled:after {background: url('/assets/templet/enterprise/images/common/bg_detail_size_disabled2.png') no-repeat center center;}

    .fb__goods-view .info__box-bd_type {border-top:none; border-bottom:#f0f0f0 1px solid;}
    .fb__goods-view .info__list {min-height:64px; padding-left:105px;}
    .fb__goods-view .info__list_h_type {min-height:37px !important;}
    .fb__goods-view .info__list .info_txt_type1 {color:#00BCE7; font-size:14px; font-weight:normal;}
    .fb__goods-view .info__review__btn:after {display:none;}

    .fb__goods-view .goods-info__review__star--point span {background:url('/assets/templet/enterprise/_/images/common/bg_detail_star2.png') no-repeat bottom left !important;}
    .fb__goods-view .goods-info__review__star--number {color:#000; font-size:14px; font-weight:normal; line-height:22px; vertical-align:2px;}
    .fb__goods-view .info__review__btn {color:#666;}

    .fb .goods__slider {width:1140px; margin:0 auto;}
    .fb .goods__slider__wrap {width:529px;}
    .fb .goods__slider__wrap .swiper-slide {width:160px;}
    .fb .goods__slider__title {font-weight:700;}
    .fb .goods__slider__price p {color:#000; font-family:'Roboto', sans-serif; font-weight:500;}
    .fb .goods__slider__price--strike {color:#666; font-family:'Roboto', sans-serif; font-weight:400;}
    .fb .goods__slider__sale {font-family:'Roboto', sans-serif; font-size:14px; font-weight:400;}
    .fb .goods__slider__sale .per {color:#FF0000; font-size:14px; font-weight:500;}
    .fb .goods__slider__sale .per em {font-size:16px; font-weight:500;}
    
    .fb .goods__slider__info .slider__box {position:relative;}
    .fb .goods__slider__info .slider__box__event {width:160px; font-size:14px; left:0; position:absolute; top:17px;}
    .fb .goods__slider__info .slider__box__brand {font-size:15px; padding-top:45px;}

    .fb .goods__slider__btn {right:0;}
    .fb .goods__slider__btn--right {right:29px;}

    .wrap_bnr_event {width:1140px; margin:100px auto 0;}
    .wrap_bnr_event .bnr_event {margin-bottom:20px;}
    .wrap_bnr_event .bnr_event img {width:1140px; height:180px;}

    .fb__goods-view__detail {padding-top:100px;}
    .fb__goods-view__detail .detail {width:1140px; margin:0 auto;}
    .fb__goods-view__detail .detail__main__tab-menu {border:none;}
    .fb__goods-view__detail .detail__main__tab-menu--fixed {background:none;}
    .fb__goods-view__detail .detail__main__tab-menu--fixed:before {background:none;}

    .fb__goods-view__detail .detail__main__tab-list {width:190px; font-family:'Noto Sans KR'; font-weight:300; line-height:58px;}
    .fb__goods-view__detail .detail__main__tab-list em {margin-left:10px;}
    .fb__goods-view__detail .detail__main__tab-list--on em {color:#fff;}
    .fb__goods-view__detail .detail__aside--fixed.detail__main__tab-menu--fixed .detail__main__tab-list--on em {color:#fff;}

    .fb__goods-view__other .other-box__title {color:#000; font-size:22px; font-family:'Noto Sans KR'; font-weight:500; line-height:32px; padding-bottom:20px;}
    .fb__goods-view__other .other-box__title span {color:#666; font-size:18px; font-weight:400; margin-left:20px;}

    .fb__goods-view__detail .detail__main .review-guide {background:none; padding:40px 0 0;}
    .fb__goods-view__detail .detail__main .review-guide__main {margin-left:53px; padding:0; position:relative;}
    .fb__goods-view__detail .detail__main .review-guide__main:before {content:'1'; color:#000; font-family:'Noto Sans KR'; font-size:22px; font-weight:500; left:-53px; line-height:32px; position:absolute; top:0;}
    .fb__goods-view__detail .detail__main .review-guide__main p {display:inline-block; font-family:'Noto Sans KR'; font-size:22px; font-weight:500; line-height:32px;}
    .fb__goods-view__detail .detail__main .review-guide__main span {font-family:'Noto Sans KR'; font-size:18px; font-weight:400; line-height:32px; margin-left:30px;}

    .fb__goods-view__detail .detail__main .review-guide__rank {margin:40px 0 0 53px; text-align:left;}
    .fb__goods-view__detail .detail__main .review-guide__rank__list {width:240px; height:120px; background-color:#F0F0F0; border-radius:0; color:#666; font-size:18px; margin:0 10px 0 0; padding:15px 30px; text-align:left;}
    .fb__goods-view__detail .detail__main .review-guide__rank__list p {color:#000; font-size:36px; margin-top:28px;}
    .fb__goods-view__detail .detail__main .review-guide__rank__list p i {font-size:20px;}

    .fb__goods-view__detail .detail__main .review-guide__notice__list {margin:20px 0 0 53px;}
    .fb__goods-view__detail .detail__main .review-guide__notice__list li {color:#666; font-size:18px; line-height:32px; margin-top:0;}
    .fb__goods-view__detail .detail__main .review-guide__notice__list li:before {margin-top:-1px; top:50%;}
    
    .fb__goods-view__detail .detail__main .review-guide__btn_best {margin:40px 0 40px 53px;}
    .fb__goods-view__detail .detail__main .review-guide__btn_best a {width:260px; border:#000 1px solid; color:#000; display:block; font-size:18px; line-height:60px; text-align:center;}
    .fb__goods-view__detail .detail__main .review-guide__btn_best a:hover {background-color:#000; color:#fff; display:block; font-size:18px; line-height:60px; text-align:center;}

    .fb__goods-view__detail .detail__main .review-guide__type {border-top:#F0F0F0 1px solid; margin-top:0; padding:40px 0 0 53px; position:relative;}
    .fb__goods-view__detail .detail__main .review-guide__type dt {color:#000; font-family:'Noto Sans KR'; font-size:22px; font-weight:500; line-height:32px; margin:0 30px 14px 0;}
    .fb__goods-view__detail .detail__main .review-guide__type dd {color:#000; font-family:'Noto Sans KR'; font-size:18px; font-weight:400; line-height:32px;}
    .fb__goods-view__detail .detail__main .review-guide__type dt.review-guide__txt {position:relative;}
    .fb__goods-view__detail .detail__main .review-guide__type dt.review-guide__txt:before {content:'2'; color:#000; font-family:'Noto Sans KR'; font-size:22px; font-weight:500; left:-53px; line-height:32px; position:absolute; top:0;}

    .fb__goods-view__detail .detail__main .tab-qna__write {width:260px; height:60px; background-color:#fff; border:#000 1px solid; color:#000; display:block; font-size:18px; line-height:60px; text-align:center;}
    .fb__goods-view__detail .detail__main .tab-qna__write:hover {background-color:#000; color:#fff; display:block; font-size:18px; line-height:60px; text-align:center;}

    .fb__goods-view__other .other-box__title {padding-bottom:57px;}

    .fb__goods-view__detail .detail__main .tab-qna__row--title {height:60px; background-color:#F6F6F6; border-bottom:#000 1px solid; color:#666; font-size:18px; line-height:60px; margin-bottom:17px;}
    .fb__goods-view__detail .detail__main .tab-qna__row__subject {color:#666; font-size:18px;}
    .fb__goods-view__detail .detail__main .tab-qna__row {height:47px; border-bottom:none; font-size:18px; line-height:47px;}

    .fb__goods-view__sub-title {color:#000; font-family:'Noto Sans KR'; font-size:22px; font-weight:500; line-height:32px;}
    .fb__goods-view__detail .detail__main .tab-info__detail-offer .offer-table__title {height:60px; background-color:#F0F0F0; border-bottom:#C8C8C8 1px solid; color:#666; font-size:16px; line-height:32px;}
    .fb__goods-view__detail .detail__main .tab-info__detail-offer .offer-table__content {border-bottom:#C8C8C8 1px solid; color:#666; font-size:16px; line-height:32px; padding:20px;}

    

    .fb__goods-view__detail .detail__main .view-detail {padding-top:100px;}

    .fb__guide .gform__common__top {display:none;}

    .fb__goodslist__title {color:#000; font-family:'Noto Sans KR'; font-size:22px; font-weight:500; padding-bottom:20px;}
    .fb .gform__common {margin-top:40px;}
    .fb__guide .gform__info dt {font-family:'Noto Sans KR'; font-size:18px; font-weight:500; margin-bottom:15px; text-align:left;}
    .fb__guide .gform__info dd {font-family:'Noto Sans KR'; font-size:18px; font-weight:400; margin-bottom:15px; text-align:left;}
    .fb__guide .gform__common__descWarp {background-color:#F0F0F0; padding:40px;}
    .fb__guide .gform__common__desc {font-size:16px; margin-top:13px;}
    .fb .gform__common__desc:after {width:2px; height:2px; background-color:#666; border-radius:50%; top:50% !important;}

    .fb__wash .wash {margin-top:20px;}
    .fb__wash .wash__category li {border:#E9E9E9 1px solid;}
    .fb__wash .wash__category-link {color:#000; font-size:18px; line-height:58px;}
    .fb__wash .wash__category-link--active:after {border:none; outline:#000 1px solid;}

    .fb__cosmetics .cosmetics__wrap {border-bottom:#e9e9e9 1px solid;}
    .fb__cosmetics .cosmetics__list {border-top:#e9e9e9 1px solid;}
    .fb__cosmetics .cosmetics__link {font-size:16px; line-height:60px; padding-left:20px;}
    .fb__cosmetics .cosmetics__link .cosmetics__category {font-size:16px;}

    .fb__goodslist__repair {padding-left:20px;}
    .fb__goodslist__repair p {font-size:18px; margin-top:40px;}
    .fb__goodslist__repair--btn {width:320px; height:60px; background-color:#fff; border:#000 1px solid; color:#000; display:block; font-size:18px; line-height:60px; margin-top:40px; padding:0; text-align:center;}
    .fb__goodslist__repair--btn:hover {background-color:#000; color:#fff;}


</style>





<nav class="fb__page-nav">
    <ul class="fb__page-nav__inner" >
        <li class="fb__page-nav__home">
            Home
        </li>
<?php if($TPL_categorys_1){$TPL_I1=-1;foreach($TPL_VAR["categorys"] as $TPL_V1){$TPL_I1++;?>
        <li class="fb__page-nav__select">
            <select <?php if($TPL_I1== 0){?> class="devSelectCid" <?php }else{?> class="devSelectCidsub" <?php }?>>
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V2["cname"]){?>
                <option value="<?php echo $TPL_V2["cid"]?>" <?php if($TPL_V2["isBelong"]== 1){?>selected<?php }?>><?php echo $TPL_V2["cname"]?><?php echo $TPL_V1["isBelong"]?></option>
<?php }?>
<?php }}?>
            </select>
        </li>
<?php }}?>
    </ul>
</nav>
<section class="fb__goods-view">
    <h2 class="fb__main__title--hidden">상품상세</h2>
    <section class="fb__goods-view__photo2">
        <div class="photo2">
            <div class="photo2_main_thumb"><img src="<?php echo $TPL_VAR["image_src"]?>" data-big_img="<?php echo $TPL_VAR["image_src"]?>"></div>
<?php if($TPL_VAR["movie"]){?>
			<div id="videoPlayer" class="photo2_main_movie" data-vimeo-url="<?php echo $TPL_VAR["movie"]?>" data-url="<?php echo $TPL_VAR["movie"]?>"></div>
<?php }?>
<?php if($TPL_add_image_src_1){foreach($TPL_VAR["add_image_src"] as $TPL_V1){?>
            <div class="photo2_main_thumb"><img src="<?php echo $TPL_V1["smallImg"]?>" data-big_img="<?php echo $TPL_V1["bigImg"]?>"></div>
<?php }}?>
        </div>
<?php if($TPL_VAR["movie_thumbnail"]){?>
        <a href="#" class="photo__slider__item--movie" style="display:none;">
            <figure class="photo__slider__item--play" style="display:none;">
                <img src="<?php echo $TPL_VAR["movie_thumbnail"]?>" data-movie="<?php echo $TPL_VAR["movie"]?>">
            </figure>
        </a>
<?php }?>
<?php if($TPL_VAR["movie"]){?>
			<button class="goods-thumb__play" style="display:none;">play clip</button>
<?php }?>
    </section>





    <!-- <section class="fb__goods-view__photo">
        <div class="photo">
            <div class="photo__main">
<?php if($TPL_VAR["movie_thumbnail"]){?>
                <div class="photo__main__video <?php if($TPL_VAR["movie_now"]=='Y'){?>photo__main__video--show<?php }?>">
                    <div id="videoPlayer" data-vimeo-url="<?php echo $TPL_VAR["movie"]?>" data-url="<?php echo $TPL_VAR["movie"]?>"></div>
                </div>
                <button type="button" class="photo__main__video--player" data-movie="<?php echo $TPL_VAR["movie"]?>" <?php if($TPL_VAR["movie_now"]=='Y'){?>style="display:none"<?php }?>>동영상 재생 버튼</button>
<?php }?>
                <figure class="picZoomer photo__main__pic" data-fatid="<?php echo $TPL_VAR["id"]?>">
<?php if($TPL_VAR["movie_now"]=='Y'){?>
                    <img src="<?php echo $TPL_VAR["movie_thumbnail"]?>" data-big_img="<?php echo $TPL_VAR["movie_thumbnail"]?>"  alt="">
<?php }else{?>
                    <img src="<?php echo $TPL_VAR["image_src"]?>" data-big_img="<?php echo $TPL_VAR["big_image_src"]?>"  alt="">
<?php }?>
                </figure>
<?php if($TPL_VAR["discountView"]){?>
                <div class="fb__goods-view__time-sale">
                    <p class="time-sale__title">Time Sale <span class="time-sale__countdown"><em class="time-sale__countdown__time"><?php echo $TPL_VAR["saleTime"]?></em> end after!</span></p>
                </div>
<?php }?>
            </div>
            <div class="photo__slider">
                <div class="photo__slider__inner">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
<?php if($TPL_VAR["movie_now"]=='Y'){?>
<?php if($TPL_VAR["movie_thumbnail"]){?>
                                    <div class="swiper-slide">
                                        <div class="photo__slider__item photo__slider__item--active">
                                            <a href="#" class="photo__slider__item--movie">
                                                <figure class="photo__slider__item--play">
                                                    <img src="<?php echo $TPL_VAR["movie_thumbnail"]?>" data-movie="<?php echo $TPL_VAR["movie"]?>">
                                                </figure>
                                            </a>
                                        </div>
                                    </div>
<?php }?>
                                <div class="swiper-slide">
                                    <div class="photo__slider__item photo__slider__item">
                                        <a href="#">
                                            <figure>
                                                <img src="<?php echo $TPL_VAR["image_src"]?>" data-big_img="<?php echo $TPL_VAR["big_image_src"]?>">
                                            </figure>
                                        </a>
                                    </div>
                                </div>
<?php }else{?>
                                <div class="swiper-slide">
                                    <div class="photo__slider__item photo__slider__item--active">
                                        <a href="#">
                                            <figure>
                                                <img src="<?php echo $TPL_VAR["image_src"]?>" data-big_img="<?php echo $TPL_VAR["image_src"]?>">
                                            </figure>
                                        </a>
                                    </div>
                                </div>
<?php if($TPL_VAR["movie_thumbnail"]){?>
                                    <div class="swiper-slide">
                                        <div class="photo__slider__item">
                                            <a href="#" class="photo__slider__item--movie">
                                                <figure class="photo__slider__item--play">
                                                    <img src="<?php echo $TPL_VAR["movie_thumbnail"]?>" data-movie="<?php echo $TPL_VAR["movie"]?>">
                                                </figure>
                                            </a>
                                        </div>
                                    </div>
<?php }?>
<?php }?>
<?php if($TPL_add_image_src_1){foreach($TPL_VAR["add_image_src"] as $TPL_V1){?>
                            <div class="swiper-slide">
                                <div class="photo__slider__item">
                                    <a href="#">
                                        <figure>
                                            <img src="<?php echo $TPL_V1["smallImg"]?>" data-big_img="<?php echo $TPL_V1["bigImg"]?>">
                                        </figure>
                                    </a>
                                </div>
                            </div>
<?php }}?>
                        </div>
                    </div>
                    <nav class="photo__slider__nav">
                        <a href="#" class="photo__slider__nav--left">
                            left
                        </a>
                        <a href="#" class="photo__slider__nav--right">
                            right
                        </a>
                    </nav>
                </div>
            </div>


        </div>
    </section> -->
    <section class="fb__goods-view__info">
        <div class="info">
            <header class="info__header">
                <div class="fb__badge fb__badge--v2">
                    <span class="fb__badge--new">
                        new
                    </span>
                    <span class="fb__badge--coupon">
                        coupon
                    </span>
                </div>
<?php if($TPL_VAR["icons_path"]){?>
<?php if($TPL_icons_path_1){foreach($TPL_VAR["icons_path"] as $TPL_V1){?>
                <span class="fb__badge--water">
                    <?php echo $TPL_V1?>

                </span>
<?php }}?>
<?php }?>
                <p class="info__preface"><?php echo $TPL_VAR["preface"]?></p>
                <h3 class="info__name"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></h3>
                <span class="info__shotinfo"><?php echo $TPL_VAR["add_info"]?></span>
                <div class="info__number">
                    <div class="info__price">
                        <span class="info__price--ori">
<?php if($TPL_VAR["discount_rate"]> 0){?>
                            <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["listprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?>

<?php }?>
                        </span>
                        <span class="info__price--now">
                            <?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?>

                        </span>
                    </div>

                    <button class="info__benefit <?php if($TPL_VAR["discount_rate"]< 0){?> info__benefit--nomargin <?php }?>">
                        <span>Discount Benefits</span>
                    </button>
                    <div class="benefit__popup">
                        <h3 class="benefit__popup__title">Discount Benefits</h3>
                        <button class="benefit__popup__btn">Benefits list close button</button>
                        <ul class="benefit__popup__cont">
                            <li class="benefit__popup__price benefit__popup__price--bold">
                                <p class="price__text">Order value</p>
                                <span class="price__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            </li>
                            <li class="benefit__popup__price">
                                <p class="price__text">Discount</p>
                                <span class="price__cont">- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["directDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["directDiscountPrice"])?><?php }else{?>0<?php }?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            </li>
                            <li class="benefit__popup__price">
                                <p class="price__text">Planning discount</p>
                                <span class="price__cont">- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["planDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["planDiscountPrice"])?><?php }else{?>0<?php }?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            </li>
                            <li class="benefit__popup__price">
                                <p class="price__text">Additional discount</p>
                                <span class="price__cont">- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["addDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["addDiscountPrice"])?><?php }else{?>0<?php }?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            </li>
                            <li class="benefit__popup__price">
                                <p class="price__text">Coupon discount</p>
                                <span class="price__cont">- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["couponDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["couponDiscountPrice"])?><?php }else{?>0<?php }?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            </li>
                            <li class="benefit__popup__price">
                                <p class="price__text">Membership discount</p>
                                <span class="price__cont">- <?php echo $TPL_VAR["fbUnit"]["f"]?><?php if($TPL_VAR["groupDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["groupDiscountPrice"])?><?php }else{?>0<?php }?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            </li>
                            <li class="benefit__popup__price benefit__popup__price--total">
                                <p class="price__text">Savings total</p>
                                <span class="price__cont"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["couponApplyPrice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                            </li>
                        </ul>
                    </div>
<?php if($TPL_VAR["discount_rate"]> 0){?>
                    <span class="info__percent">
                        <em><?php echo $TPL_VAR["discount_rate"]?></em>%
                    </span>
<?php }?>
                </div>
            </header>
            <!--쿠폰혜택-->
<?php if($TPL_VAR["couponApplyCnt"]> 0){?>
            <ul class="info__box">
                <li class="info__list info__list--coupon">
                   <span class="info__title info__title--middle">
                        Coupon benefit
                   </span>
                    <button class="info__coupon-btn" id="devCouponDown" data-pid="<?php echo $TPL_VAR["pid"]?>">
                        <span>Discount coupon download</span>
                    </button>
                </li>
            </ul>
<?php }?>
<?php if($TPL_VAR["product_type"]== 0&&$TPL_VAR["add_info"]!=''){?>
            <!-- 색상 -->
            <ul class="info__box">
                <li class="info__list">
                    <span class="info__title">Color</span>
                    <p><?php echo $TPL_VAR["add_info"]?></p>
<?php if($TPL_VAR["sameProduct"]){?>
                    <ul class="info__color">
<?php if($TPL_sameProduct_1){foreach($TPL_VAR["sameProduct"] as $TPL_V1){?>
                            <li class="info__color__box">
                                <a href="/shop/goodsView/<?php echo $TPL_V1["pid"]?>" class="info__color__link <?php if($TPL_VAR["pid"]==$TPL_V1["pid"]){?>info__color__link--active<?php }?>">
                                    <img src="<?php echo $TPL_V1["filterImg"]?>" alt="Color Image">
                                </a>
                            </li>
<?php }}?>
                    </ul>
<?php }?>
                </li>
            </ul>
<?php }?>

<?php if($TPL_VAR["colorChipList"]){?>
            <ul class="info__box">
<?php if($TPL_colorChipList_1){foreach($TPL_VAR["colorChipList"] as $TPL_K1=>$TPL_V1){?>
                <li class="info__list">
<?php if($TPL_K1=='1'&&!empty($TPL_VAR["relation_text1"])){?>
                    <span class="info__title"><?php echo $TPL_VAR["relation_text1"]?></span>
<?php }?>
<?php if($TPL_K1=='2'&&!empty($TPL_VAR["relation_text2"])){?>
                    <span class="info__title"><?php echo $TPL_VAR["relation_text2"]?></span>
<?php }?>
                    <ul class="info__color">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                        <li class="info__color__box">
                            <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>" class="info__color__link <?php if($TPL_VAR["pid"]==$TPL_V2["pid"]){?>info__color__link--active<?php }?>">
                                <img src="<?php echo $TPL_V2["filterImg"]?>" alt="Color Image">
                            </a>
                        </li>
<?php }}?>
                    </ul>
                </li>
<?php }}?>
            </ul>
<?php }?>

            <div class="goods-option">
                <div class="info__box option" id="devMinicartArea" data-pid="<?php echo $TPL_VAR["pid"]?>" style="border-top:none; padding-top:6px;">
                    <!--<p class="option-tit">Option selection</p>-->
                    <div class="devForbizTpl" id="devLonelyOption">
                        <span id="devLonelyOptionName">
                            <p>{[option_name]}</p>
                        </span>
                    </div>

                    <div id="devMinicartOptions"></div>


                    <!-- cre.ma / 통합 요약 위젯 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
                    <style>.fb__goods-view .goods-info__size {padding-top: 40px;}</style>
                    <style>.crema-fit-product-combined-summary { margin-top:40px; margin-bottom:20px; padding-left: 108px;}</style>
                    <div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" class="crema-fit-product-combined-summary" style="display:none;"></div>



                    <div class="goods-option">
                        <!--사은품-->
<?php if($TPL_VAR["product_gift"]){?>
                        <div class="goods-info__set">
                            <h4 class="goods-info__set__title">Free Gift Select</h4>

                            <ul class="goods-info__set__list">
<?php if($TPL_product_gift_1){$TPL_I1=-1;foreach($TPL_VAR["product_gift"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1<$TPL_VAR["gift_selectbox_cnt"]){?>
                                <li class="goods-info__set__box">
                                    <select class="devProductGift_<?php echo $TPL_I1?> devGiftSelect" data-idx="<?php echo $TPL_I1?>">
                                        <option value=""> Please select </option>
<?php if(is_array($TPL_R2=$TPL_V1["product_gift_detail"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                                        <option value="<?php echo $TPL_V2["pid"]?>" <?php if($TPL_V2["status"]=='soldout'){?> disabled <?php }?>><?php echo $TPL_V2["pname"]?> <?php if($TPL_V2["status"]=='soldout'){?> [Out of stock] <?php }?></option>
<?php }}?>
                                    </select>
                                </li>
<?php }?>
<?php }}?>
                            </ul>
                        </div>
<?php }?>
                    </div>

                    <div id="devMinicartAddOption" class="hidden" style="padding-bottom:63px; ">
                        <p class="option-tit">Selection for additional option</p>
                    </div>
                    <div id="devMinicartSelected">
                        <div class="info__decided option-box devOptionBox devForbizTpl" devPid="{[pid]}" devOptionKind="{[option_kind]}" devOptid="{[option_id]}" devUnit="{[option_dcprice]}" devStock="{[option_stock]}">
                            <p class="info__decided-info tit">{[option_prefix]}{[pname]}</p>
                            <p class="goods-cart__sub">{[add_info_text]}<br />{[option_div_text]}</p>
                            <!-- <p class="goods-cart__sub">{[option_div_text]}</p> -->
                            <div class="info__decided-btns control">
                                <ul class="devControlCntBox"> <!-- option-up-down 클래스 삭제 -->
                                    <li class="devCntMinus"><button class="info__decided-btns--minus down"></button></li>
                                    <li><input type="text" value="{[allowBasicCnt]}" class="info__decided-btns--count devMinicartPrdCnt"></li>
                                    <li class="devCntPlus"><button class="info__decided-btns--plus up"></button></li>
                                </ul>
                            </div>
                            <!--<div class="info__decided-rightside">-->
                            <button class="info__decided__del btn-option-del devMinicartDelete"></button>
                            <div class="info__decided-price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em class="devMinicartEachPrice">{[eachPrice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>

                            <!--</div>-->
                        </div>
                    </div>
                </div>

                <div class="info__total-box total-price ">
                    <p class="tit">Total price</p>
                    <p class="price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="devMinicartTotal">0</em><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
                </div>
                <div class="goods-btn-area">
                    <button class="btn-wish <?php if($TPL_VAR["alreadyWish"]){?>on<?php }?>" data-devWishBtn="<?php echo $TPL_VAR["pid"]?>">하트버튼</button>
                    <button class="btn-share">공유하기</button>
<?php if($TPL_VAR["viewMode"]=='preview'){?>
                        <button class="btn-soldout" disabled>Preview Product</button>
<?php }else{?>
<?php if($TPL_VAR["status"]=='sale'){?>
                        <div class="innerbox">
                            <div class="devAddCart__wrap">
                                <button class="btn-lg btn-lg--cart devAddCart devAddCart__layerBtn">Cart</button>

                                <div class="devAddCart__layer">
                                    <a href="#" class="devAddCart__layer__close">
                                        닫기
                                    </a>
                                    <p>
                                        The selected item has been added to your cart. <br> Would you like to go to the cart page?
                                    </p>
                                    <div class="devAddCart__layer__btn">
                                        <a href="#" class="btn-dark">
                                            Continue
                                        </a>
                                        <a href="/shop/cart" class="btn-dark-line ">
                                            View cart
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <button class="btn-lg btn-point devOrderDirect">Check Out</button>

                            <div class="cart-msg" style="display:none">
                                <p class="cart-msg__txt">택하신 상품이 장바구니에 담겼습니다.<br>장바구니로 이동하시겠습니까?</p>
                                <button class="cart-msg__btn btn-stay">쇼핑 계속하기</button>
                                <button class="cart-msg__btn btn-move">장바구니 이동</button>
                                <span class="cart-msg__close">닫기 버튼</span>
                            </div>
                        </div>
<?php }elseif($TPL_VAR["status"]=='ready'){?>
                        <button class="btn-lg btn-soldout" disabled>For Sale</button>
<?php }elseif($TPL_VAR["status"]=='end'){?>
                        <button class="btn-lg btn-soldout" disabled>Sales End</button>
<?php }else{?>
                        <button class="btn-soldout" disabled>Out of stock</button>
<?php }?>

<?php }?>
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <button class="btn-find-store" id="storeGuide" data-id="<?php echo $TPL_VAR["pid"]?>" data-type="<?php echo $TPL_VAR["product_type"]?>">Store guide where you can purchase the product</button>
<?php }?>
                </div>
            </div>

<?php if($TPL_VAR["langType"]=='korean'){?>
            <!--상품후기-->
            <ul class="info__box info__box-bd_type">
                <li class="info__list info__list_h_type">
                    <span class="info__title">Reviews</span>
                    <span class="goods-info__review__star">
                        <span class="goods-info__review__star--point">
                            <span data-widths="<?php echo $TPL_VAR["total_review_star_per"]?>"></span>
                        </span>
                    <span class="goods-info__review__star--number"><?php echo $TPL_VAR["total_review_star"]?></span>
                </span>
                    <a href="#" class="info__review__btn">To see review</a>
                </li>
            </ul>
<?php }else{?>
<?php }?>
<?php if($TPL_VAR["is_use_reserve"]){?>
            <!-- 회원혜택 -->
            <ul class="info__box info__box-bd_type">
                <li class="info__list">
                   <span class="info__title">
                        Reward
                    </span>
                    <p class="info__mileage">
                        예상적립금 <span class="info__mileage__money"><em class="info_txt_type1"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["save_reserve"])?></em></span><?php echo $TPL_VAR["fbUnit"]["b"]?><br>(적립금은 결제 시 상이할 수 있습니다.)
                    </p>
                </li>
            </ul>
<?php }?>
            <!-- 배송정보 -->
            <ul class="info__box info__box-bd_type">
                <li class="info__list">
                    <span class="info__title">Shipping Information</span>
                    <p>
                        <?php echo $TPL_VAR["delivery"]["text"]?>

                        <br>(Overseas shipping fee will be charged)
                    </p>
                    <!--고객사 요청으로 수정, 확정되면 지울예정입니다.-->
                    <p style="display: none;">
<?php if($TPL_VAR["delivery"]["deliveryPolicy"]== 1){?> <!-- 무료배송 -->
                        <?php echo $TPL_VAR["delivery"]["text"]?>

<?php }elseif($TPL_VAR["delivery"]["deliveryPolicy"]== 2){?> <!-- 고정배송비 -->
                        <?php echo g_price($TPL_VAR["delivery"]["sumPrice"])?>원
<?php }else{?> <!-- 조건배송비 -->
                        <?php echo g_price($TPL_VAR["delivery"]["sumPrice"])?>원 (<?php echo $TPL_VAR["delivery"]["text"]?>)
<?php }?>
                        . <?php echo $TPL_VAR["delivery"]["deliveryComName"]?><br>
                    </p>
                </li>
            </ul>

        </div>

        <div class="layer-share">
            <p class="layer-share__title">Share</p>
            <div class="layer-share__sns">
                <!--@TODO 카카오톡, 페이스북, 트위터, url 기획 확정-->
                <!--<a href="#" class="layer-share__sns__btn layer-share__sns__btn&#45;&#45;instagram" devsnsshare="instagram">-->
                    <!--instagram-->
                <!--</a>-->
<?php if($TPL_VAR["langType"]=='korean'){?>
                <!--<a href="#" class="layer-share__sns__btn layer-share__sns__btn&#45;&#45;kakaostory" devsnsshare="kakaostory">-->
                    <!--kakaostory-->
                <!--</a>-->
<?php }?>
<?php if($TPL_VAR["langType"]=='korean'){?>
                <a href="#" class="layer-share__sns__btn layer-share__sns__btn--kakaotalk" devSnsShare="kakaotalk">
                    kakaotalk
                </a>
<?php }?>
                <a href="#" class="layer-share__sns__btn layer-share__sns__btn--facebook" devSnsShare="facebook">
                    facebook
                </a>
                <a href="#" class="layer-share__sns__btn layer-share__sns__btn--twitter" devSnsShare="twitter">
                    twitter
                </a>
                <a href="#" class="layer-share__sns__btn layer-share__sns__btn--url" devSnsShare="url-copy">
                    URL복사
                </a>
                <!--<a href="#" class="layer-share__sns__btn layer-share__sns__btn&#45;&#45;blog" devsnsshare="naver">
                    blog
                </a>-->

            </div>
            <button type="button" class="layer-share__close">공유하기 닫기버튼</button>
        </div>
    </section>
</section>

<div class="goods__slider">
<?php if($TPL_VAR["togeterProduct"]){?>
    <div class="goods__slider__wrap goods__slider__wrap--left">
        <h3 class="goods__slider__title">Items purchased by other customers</h3>
        <div class="swiper-container">
            <ul class="swiper-wrapper goods__swiper">
<?php if($TPL_togeterProduct_1){foreach($TPL_VAR["togeterProduct"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='stop'){?>
                <li class="swiper-slide goods__swiper__inner">
                    <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>">
                        <figure class="goods__slider__img">
                            <img src="<?php echo $TPL_V1["image_src"]?>" alt="">
                        </figure>
                        <div class="fb__badge goods__slider__badge">
<?php if($TPL_V1["icons_path"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["icons_path"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                            <span class="fb__badge--water">
                                        <?php echo $TPL_V2?>

                                    </span>
<?php }}?>
<?php }?>
                        </div>
                        <div class="goods__slider__info">
                            <ul class="slider__box">
                                <li class="slider__box__event"><?php echo $TPL_V1["preface"]?></li>
                                <li class="slider__box__brand"><?php echo $TPL_V1["pname"]?></li>
                                <li class="slider__box__option"><?php echo $TPL_V1["add_info"]?></li>
                            </ul>
                        </div>
                        <div class="goods__slider__price">
<?php if($TPL_VAR["langType"]=='korean'){?>
                                <p><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["dcprice"])?><!-- <?php echo $TPL_VAR["fbUnit"]["b"]?> --></p>
<?php if($TPL_V1["isDiscount"]){?>
                                <span class="goods__slider__price--strike">
                                    <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?><!-- <?php echo $TPL_VAR["fbUnit"]["b"]?> -->
                                </span>
<?php }?>
                                <span class="goods__slider__sale <?php if($TPL_V1["is_soldout"]){?>goods__slider__sale--soldout<?php }?>">
<?php if($TPL_V1["is_soldout"]){?>
                                    <p class="per">Out of stock</p>
<?php }else{?>
<?php if($TPL_V1["isDiscount"]){?>
                                        <p class="per"><em><?php echo $TPL_V1["discount_rate"]?></em>%</p>
<?php }?>
<?php }?>
                                </span>
<?php }else{?>
<?php if($TPL_V1["is_soldout"]){?>
                                    <span class="goods__slider__sale <?php if($TPL_V1["is_soldout"]){?>goods__slider__sale--soldout<?php }?>">
                                        <p class="per">Out of stock</p>
                                    </span>
<?php }else{?>
                                    <p><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["dcprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
<?php if($TPL_V1["isDiscount"]){?>
                                    <span class="goods__slider__price--strike">
                                            <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?>

                                        </span>
<?php }?>
                                    <span class="goods__slider__sale">
<?php if($TPL_V1["isDiscount"]){?>
                                            <p class="per"><em><?php echo $TPL_V1["discount_rate"]?></em>%</p>
<?php }?>
                                    </span>
<?php }?>
<?php }?>
                        </div>
                    </a>
                </li>
<?php }?>
<?php }}?>
            </ul>
        </div>
        <div class="swiper-button-prev goods__slider__btn goods__slider__btn--right"><span class="btn__prev"></span></div>
        <div class="swiper-button-next goods__slider__btn"><span class="btn__next"></span></div>
    </div>
<?php }?>
<?php if($TPL_VAR["similraProduct"]){?>
    <div class="goods__slider__wrap goods__slider__wrap--right">
        <h3 class="goods__slider__title">Similar items</h3>
        <div class="swiper-container">

            <ul class="swiper-wrapper goods__swiper">
<?php if($TPL_similraProduct_1){foreach($TPL_VAR["similraProduct"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='stop'){?>
                <li class="swiper-slide goods__swiper__inner">
                    <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>">
                        <figure class="goods__slider__img">
                            <img src="<?php echo $TPL_V1["image_src"]?>" alt="">
                        </figure>
                        <div class="fb__badge goods__slider__badge">
<?php if($TPL_V1["icons_path"]){?>
<?php if(is_array($TPL_R2=$TPL_V1["icons_path"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                            <span class="fb__badge--water">
                                        <?php echo $TPL_V2?>

                                    </span>
<?php }}?>
<?php }?>
                        </div>
                        <div class="goods__slider__info">
                            <ul class="slider__box">
                                <li class="slider__box__event"><?php echo $TPL_V1["preface"]?></li>
                                <li class="slider__box__brand"><?php echo $TPL_V1["pname"]?></li>
                                <li class="slider__box__option"><?php echo $TPL_V1["add_info"]?></li>
                            </ul>
                        </div>
                        <div class="goods__slider__price">
<?php if($TPL_VAR["langType"]=='korean'){?>
                                <p><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["dcprice"])?><!-- <?php echo $TPL_VAR["fbUnit"]["b"]?> --></p>
<?php if($TPL_V1["isDiscount"]){?>
                                <span class="goods__slider__price--strike">
                                    <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?><!-- <?php echo $TPL_VAR["fbUnit"]["b"]?> -->
                                </span>
<?php }?>
                                <span class="goods__slider__sale <?php if($TPL_V1["is_soldout"]){?>goods__slider__sale--soldout<?php }?>">
<?php if($TPL_V1["is_soldout"]){?>
                                    <p class="per">Out of stock</p>
<?php }else{?>
<?php if($TPL_V1["isDiscount"]){?>
                                        <p class="per"><em><?php echo $TPL_V1["discount_rate"]?></em>%</p>
<?php }?>
<?php }?>
                                </span>
<?php }else{?>
<?php if($TPL_V1["is_soldout"]){?>
                                <span class="goods__slider__sale <?php if($TPL_V1["is_soldout"]){?>goods__slider__sale--soldout<?php }?>">
                                    <p class="per">Out of stock</p>
                                </span>
<?php }else{?>
                                <p><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["dcprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></p>
<?php if($TPL_V1["isDiscount"]){?>
                                <span class="goods__slider__price--strike">
                                        <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?>

                                    </span>
<?php }?>
                                <span class="goods__slider__sale">
<?php if($TPL_V1["isDiscount"]){?>
                                        <p class="per"><em><?php echo $TPL_V1["discount_rate"]?></em>%</p>
<?php }?>
                                </span>
<?php }?>
<?php }?>
                        </div>
                    </a>
                </li>
<?php }?>
<?php }}?>
            </ul>
        </div>
        <div class="swiper-button-prev goods__slider__btn goods__slider__btn--right"><span class="btn__prev"></span></div>
        <div class="swiper-button-next goods__slider__btn"><span class="btn__next"></span></div>
    </div>
<?php }?>
</div>

<!-- event banner -->
<div class="wrap_bnr_event">
<?php if($TPL_eventBannerInfo_1){foreach($TPL_VAR["eventBannerInfo"] as $TPL_V1){?>
    <div class="bnr_event">
        <a href="<?php echo $TPL_V1["bannerLink"]?>">
            <figure>
                <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["bd_title"]?>">
            </figure>
        </a>
    </div>
<?php }}?>
</div>

<section class="fb__goods-view__other">

<?php if($TPL_VAR["relationInfos"]){?>


<?php }?>

    <!-- <?php if($TPL_VAR["langType"]=='korean'){?>
    <div class="other-box js__size__box">
        <h3 class="other-box__title js">Size chart</h3>
        <div class="other-box__crema"> -->
            <!-- cre.ma 상품정보  스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
            <!--<div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-mvp="1" class="crema-fit-product-size-detail"></div>-->
            <!-- cre.ma 핏 상품고시정보  스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
            <style>.crema-fit-product-combined-detail { margin: 60px 0 80px;}</style>
            <!-- <div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" class="crema-fit-product-combined-detail"></div>
        </div>
    </div> -->
    <!-- <?php }?> -->

    <!-- <?php if($TPL_VAR["eventBannerInfo"]){?>
    <div class="other-box">
        <h3 class="other-box__title">EVENT</h3>
        <div class="newSlider">
            <div class="newSlider__slider swiper-container">
                <div class="swiper-wrapper">
<?php if($TPL_eventBannerInfo_1){foreach($TPL_VAR["eventBannerInfo"] as $TPL_V1){?>
                    <div class="swiper-slide newSlider__list">
                        <a href="<?php echo $TPL_V1["bannerLink"]?>">
                            <figure>
                                <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["bd_title"]?>">
                            </figure>
                        </a>
                    </div>
<?php }}?>
                </div>
                <div class="fb__main__slider newSlider__control">
                    <div class=" mainSlider__control">
                        <div class="mainSlider__dot">

                        </div>
                        <div class="mainSlider__arrow">
                            <a href="#" class="mainSlider__arrow--prev">
                                prev
                            </a>
                            <a href="#" class="mainSlider__arrow--next">
                                next
                            </a>
                        </div>
                        <div class="mainSlider__page">
                            <span class="mainSlider__page__wrap"><span class="mainSlider__page__now">1</span>/<span class="mainSlider__page__total"><?php echo count($TPL_VAR["eventBannerInfo"])?></span></span>
                            <a href="#" class="mainSlider__auto">
                                <span class="mainSlider__auto--play">play</span>
                                <span class="mainSlider__auto--stop">stop</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php }?> -->
</section>

<section class="fb__goods-view__detail">
    <style>
        .fb__goods-view__detail .detail__main__tab-menu--fixed__inner {
            border-bottom: 1px solid #000;
        }

        .fb__goods-view__detail .detail__main__tab-list--on {
            color: #fff;
            background: #000;
        }

        .fb__goods-view__detail .detail__aside--fixed.detail__main__tab-menu--fixed .detail__main__tab-list--on {
            background-color:#000; border-bottom:#000 2px solid; color:#fff; 
        }

    </style>
    <h3 class="fb__main__title--hidden"> 하단 상품상세</h3>
    <div class="detail "><!--goods-view-main-area-->
        <section class="detail__main wrap-tab-area">
            <h4 class="fb__main__title--hidden">하단 상품상세 - 왼쪽 메인 영역</h4>
            <nav class="detail__main__tab-menu"> <!--  goods-view-tab tab-js-->
                <div class="detail__main__tab-menu--fixed">
                    <div class="detail__main__tab-menu--fixed__inner">

<?php if($TPL_VAR["langType"]=='korean'){?>
                        <a href="#devTabReview" class="detail__main__tab-list tab-review" data-content="">Reviews<em><?php echo $TPL_VAR["total_review_cnt"]?></em></a>
<?php }else{?>
<?php if(false){?>
                            <a href="#devTabReview" class="detail__main__tab-list devDetailTabs" data-content="devTabReview">Reviews<?php if($TPL_VAR["allReviewTotal"]> 0){?><em>(<?php echo g_price($TPL_VAR["allReviewTotal"])?>)</em><?php }?></a>
<?php }?>
<?php }?>


                        <a href="#devTapDetail" class="detail__main__tab-list detail__main__tab-list--on devDetailTabs active" data-content="devViewDetail">Product Information</a>
                        <!--<a href="#devTabReview" class="detail__main__tab-list devDetailTabs" data-content="devTabReview">Reviews<?php if($TPL_VAR["allReviewTotal"]> 0){?><em><?php echo g_price($TPL_VAR["allReviewTotal"])?></em><?php }?></a>-->
<?php if($TPL_VAR["langType"]=='korean'){?>
	                        <a href="#devTabRecom" class="detail__main__tab-list" data-content="">사이즈 추천</a>
							<a href="#pubPrecautions" class="detail__main__tab-list" data-content="">Washing & Care</a>
							<a href="#devTabExchange" class="detail__main__tab-list" data-content="">반품/환불/수선</a>
<?php }else{?>
							<a href="#devTabRecom" class="detail__main__tab-list" data-content="">Size Guide</a>
							<a href="#pubPrecautions" class="detail__main__tab-list" data-content="">Washing&Care</a>
							<a href="#devTabExchange" class="detail__main__tab-list" data-content="">Returns/Refunds</a>
<?php }?>
                        <!-- <?php if($TPL_VAR["langType"]=='korean'){?>
                        <a href="#pubShippingGuide" class="detail__main__tab-list" data-content="">shipping information</a>
<?php }?> -->
						<a href="#devTabInquiry" class="detail__main__tab-list devDetailTabs" data-content="devTabInquiry">Q&A<?php if($TPL_VAR["qnaTotal"]> 0){?><em><?php echo number_format($TPL_VAR["qnaTotal"])?></em><?php }?></a>
                        <!-- <a href="#pubRepairGuide" class="detail__main__tab-list" data-content="">Repair Information</a> -->
                    </div>
                </div>
            </nav>
            <div class="detail__main__tab-content wrap-tab-cont">
<?php if($TPL_VAR["reviewBanner"]){?>
				<div style="margin-top:0; position:relative;">
					<a href="<?php echo $TPL_VAR["reviewBanner"]["bannerLink"]?>"><img src="<?php echo $TPL_VAR["reviewBanner"]["imgSrc"]?>" alt=""></a>
				</div>
<?php }?>
                <!--상품정보-->
                <div id="devTabReview" class="tab-info view-detail ">
<?php if($TPL_VAR["sellerNotice"]){?>
                    <figure class="tab-info__notice">
                        <img src="<?php echo $TPL_VAR["sellerNotice"]?>" alt="">
                    </figure>
<?php }?>

                    <!--사은품-->
<?php if($TPL_VAR["productGiftInfo"]){?>

                    <div class="goods-detail__acco fb__goods-view__gift">
                        <div class="goods-detail__acco__btn goods-view__btn">
                            <button type="button">The gift <span> product is a gift-giving product.</span></button>
                        </div>
                        <div class="goods-detail__acco__wrap goods-detail__acco__wrap--active">
                            <div class="gift-cont">
<?php if($TPL_productGiftInfo_1){foreach($TPL_VAR["productGiftInfo"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='soldout'){?>
                                <div class="gift-cont__list">
                                    <figure class="gift-cont__thumb">
                                        <img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>">
                                    </figure>
                                    <div class="goods-detail__acco__info">
                                        <p class="goods-detail__acco__title"><?php echo $TPL_V1["pname"]?></p>
                                        <p class="goods-detail__acco__date">Event Period : <?php echo $TPL_V1["sell_priod_sdate"]?> ~ <?php echo $TPL_V1["sell_priod_edate"]?></p>
                                        <p class="goods-detail__acco__price"><span><?php echo $TPL_V1["add_info"]?></span>value</p>
                                    </div>
                                </div>
<?php }?>
<?php }}?>
                                <div class="gift-cont__notice">
                                    <p class="gift-cont__notice__desc">Please enclose a gift for return and refund.</p>
                                </div>
                            </div>
                        </div>
                    </div>
<?php }?>

<?php if($TPL_VAR["langType"]=='korean'){?>
<?php if($TPL_VAR["mandatory_use"]=='Y'){?>

                    <!-- cre.ma / 상품 리뷰 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
                    <div class="crema-product-reviews" data-product-code="<?php echo (int) $TPL_VAR["id"];?>" style="margin-top: 20px;"></div>

<?php }?>
<?php }else{?>
<?php if($TPL_VAR["mandatory_use_global"]=='Y'){?>

                    <!-- cre.ma / 상품 리뷰 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
                    <div class="crema-product-reviews" data-product-code="<?php echo (int) $TPL_VAR["id"];?>" style="margin-top: 20px;"></div>

<?php }?>
<?php }?>

                </div>

                <div class="tab-info__pic" id="devTapDetail">
                    <?php echo html_entity_decode($TPL_VAR["basicinfo"])?>

                </div>

<?php if($TPL_VAR["langType"]=='korean'){?>
                <div id="devTabRecom" class="other-box js__size__box">
                    <!-- <h3 class="other-box__title js">Size chart</h3> -->
                    <div class="other-box__crema">
                        <!-- cre.ma 상품정보  스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
                        <!--<div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-mvp="1" class="crema-fit-product-size-detail"></div>-->
                        <!-- cre.ma 핏 상품고시정보  스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
                        <style>.crema-fit-product-combined-detail { margin: 60px 0 0px;}</style>
                        <div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" class="crema-fit-product-combined-detail"></div>
                    </div>
                </div>
<?php }?>


                <!--상품후기-->
                <div class="tab-review view-detail">
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <div class="fb__goods-view__other">
                        <div class="other-box">
                            <h3 class="other-box__title">Reviews <span>Reviews of other customers.</span></h3>
                            <div class="review-guide">
                                <div class="review-guide__main"><p>Montly Best Review! <br />&nbsp;</p><span>Every last Thursday of every month, we select Best Review .<br /><?php if($TPL_VAR["isCosmetic"]){?> Barrel Cosmetics <?php }else{?> body <?php }?> If you write a qualitative review with a picture of the outfit, the probability increases.</span></div>
                                <ul class="review-guide__rank">
                                    <li class="review-guide__rank__list">1등 <br><p>50,000<i>원</i></p></li>
                                    <li class="review-guide__rank__list">2등 <br><p>20,000<i>원</i></p></li>
                                    <li class="review-guide__rank__list">3등 <br><p>10,000<i>원</i></p></li>
                                </ul>
                                <ul class="review-guide__notice__list">
                                    <li>Mileage given for reviews are for online purchases only.</li>
                                </ul>
                                <div class="review-guide__btn_best"><a href="/customer/bestReview">베스트 리뷰 보러가기</a></div>

                                <dl class="review-guide__type">
                                    <dt class="review-guide__txt">Reviews</dt>
                                    <dd>글 50자 이상의 생생한 후기를 남겨주시면 <?php if($TPL_VAR["isCosmetic"]){?>500원<?php }else{?>3,000원<?php }?>이 적립 됩니다.</dd>
                                    <dt>Photo Reviews</dt>
                                    <dd>글 50자 이상의 생생한 후기와 착용컷을 남겨주시면 <?php if($TPL_VAR["isCosmetic"]){?>1,000원<?php }else{?>5,000원<?php }?>이 적립 됩니다.</dd>
                                </dl>



                                <!-- <div class="review-guide__notice">
                                    <p class="review-guide__notice__title">Non-assetable Condition</p>
                                    <ul class="review-guide__notice__list">
                                        <li>For the cases when a same review comment is used again(copy/paste), the reward will be given only once.</li>
                                        <li>(english)글 50자는 ‘공백 제외/ 특수문자 제외 / ㅋ,ㅎ,ㅠ,...등 자음 및 모음, 한자는 제외 / 숫자의 경우 한 글자로 처리</li>
                                        <li>When the product is bought from offline stores or the other website.</li>
                                        <li>Reward is not paid for post a review after purchase as non-member. (Only for members)</li>
                                        <li>When products are bought as a non-member, then writes review, no mileage will be given.(Benefits for membership)</li>
                                        <li>When the price of the product is less than $10, reward cannot be given.</li>
<?php if(!$TPL_VAR["isCosmetic"]){?>
                                        <li>When buying at the BARREL outlet, no reward will be given for reviews.</li>
<?php }?>
                                        <li>이벤트 진행 시 해당 상품 구매에 대한 후기 적립금은 조정될 수 있습니다.</li>
                                    </ul>
                                </div> -->
                            </div>
                        </div>

                        <!-- 소셜 위젯 -->
                        <div class="other-box crema-product-reviews" data-widget-id="22" data-product-code="<?php echo (int) $TPL_VAR["id"];?>"></div>

                        <!-- <div class="other-box">
                            <h3 class="other-box__title">Best Review</h3> -->
                            <!-- cre.ma / 큰썸네일 위젯 / 카드형태 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
                            <!-- <div class="crema-reviews" data-widget-id="30" style="margin-top: 20px;"></div>
                        </div> -->
                    </div>


<?php }else{?>
<?php if(false){?>
                        <div class="fb__goods-view__other">
                            <h3 class="other-box__title">Reviews <span>Reviews of other customers.</span></h3>
                        </div>

                        <form id="devProductReviewForm">
                            <input type="hidden" name="id" value="<?php echo $TPL_VAR["pid"]?>"/>
                            <input type="hidden" name="orderBy" value="regdate"/>
                            <input type="hidden" name="orderByType" value="desc"/>
                            <input type="hidden" name="bbsDiv" value="2"/>
                            <input type="hidden" name="page" value="1" id="devPage"/>
                            <input type="hidden" name="max" value="3" id="devMax"/>
                        </form>

<?php if($TPL_VAR["allReviewTotal"]> 0){?>
                        <div class="satisfy top-area">

                            <div class="satisfy__inner total-score">
                                <span class="satisfy__inner__title title">Customer Satisfaction</span>
                                <span class="satisfy__inner__star set-star big">
                                    <span class="satisfy__inner__star--color score" style="width:<?php echo $TPL_VAR["avg"]["avgPct"]?>%"></span>
                                    <script>console.log('<?php echo $TPL_VAR["avg"]["avgPct"]?>');</script>
                                </span>
                                <em class="satisfy__inner__num sj__n"><?php echo $TPL_VAR["avg"]["avg"]?></em>
                            </div>
                            <div class="satisfy__inner total-score type2">
                                <div class="satisfy__sub sec">
                                    <p class="satisfy__sub__title">Product evaluation</p>
                                    <span class="satisfy__sub__star set-star">
                                    <span class="satisfy__sub__star--color score" style="width:<?php echo $TPL_VAR["avg"]["goodsAvgPct"]?>%"></span>
                                </span>
                                    <span class="satisfy__sub__num sj__n"><?php echo $TPL_VAR["avg"]["goodsAvg"]?></span>

                                </div>
                                <div class="satisfy__sub sec">
                                    <p class="satisfy__sub__title">Shipping Evaluation</p>
                                    <span class="satisfy__sub__star set-star">
                                    <span class="satisfy__sub__star--color score" style="width:<?php echo $TPL_VAR["avg"]["deliveryAvgPct"]?>%"></span>
                                </span>
                                    <span class="satisfy__sub__num sj__n"><?php echo $TPL_VAR["avg"]["deliveryAvg"]?></span>
                                </div>
                            </div>
                        </div>

                        <div class="tab-review__content review-content">
                            <div class="sort-list top">
                                <div class="sort-list__tab review-tab tab-js">
                                    <a href="#review-tab1" class="devReviewsDiv active" data-bbsdiv="0">
                                        All review<em class="sj__n"><?php echo g_price($TPL_VAR["reviewTotal"])?></em>
                                    </a>
                                    <a href="#review-tab1" class="devReviewsDiv" data-bbsdiv="2">
                                        Reviews<em class="sj__n"><?php echo g_price($TPL_VAR["reviewTotal"])?></em>
                                    </a>
                                    <a href="#review-tab1" class="devReviewsDiv" data-bbsdiv="1">
                                        Photo Reviews<em class="sj__n"><?php echo g_price($TPL_VAR["premiumReviewTotal"])?></em>
                                    </a>
                                </div>

                                <select class="sort-list__select devSort" title="후기 정렬">
                                    <option value="real_regdate" data-sort="desc">Recent</option>
                                    <option value="upCnt" data-sort="desc">Like</option>
                                    <option value="avg" data-sort="asc">Lowest rate</option>
                                    <option value="avg" data-sort="desc">Highest rate</option>
                                </select>
                            </div>

                            <div class="tab-review__list  wrap-tab-cont review-list">
                                <div id="review-tab1" class="active">
                                    <ul id="devReviewContents">
                                        <li class="empty-content" id="devReviewLoading">
                                            <div class="wrap-loading">
                                                <div class="loading"></div>
                                            </div>
                                        </li>

                                        <li class="empty-content" id="devReviewEmpty">No product review</li>

                                        <li id="devReviewDetail">
                                            <div class="review devReviewDetailContents" data-bbsIx="{[bbs_ix]}" data-video_idx="{[video_idx]}" data-bbs_subject="{[bbs_subject]}">
                                                <div class="review__wrap-star col star">
                                                    <div class="review__star-inner">
                                                    <span class="set-star">
                                                        <span class="score devStarScore" data-avg_pct="{[avg_pct]}" ></span>
                                                    </span>
                                                    </div>
                                                </div>
                                                <div class="review__wrap-info col info">
                                                    {[#if isThumb]}
                                                    <figure class="{[#if isVideo]}wrap-video video-play{[else]}wrap-thumb{[/if]}">
                                                        <img src="{[thumb]}" alt="{[bbs_subject]}">
                                                    </figure>
                                                    {[/if]}
                                                    <div class="review__wrap-info__text--normal devViewVideoReview" data-video_idx="{[video_idx]}">
                                                        <p class="review__wrap-info__option">{[option_name]}</p>
                                                        <p class="review__wrap-info__title">{[bbs_subject]}</p>
                                                    </div>
                                                </div>
                                                <div class="review__wrap-user col user">
                                                    <span>{[bbs_id]}</span>
                                                </div>
                                                <div class="review__wrap-date col date">
                                                    <span>{[regdate]}</span>
                                                </div>
                                            </div>

                                            <div class="review-detail" id="devDetailView_{[video_idx]}">
                                                <div class="review-detail__top wrap-score">
                                                    <div class="review-detail__wrap-score">
                                                        <span class="review-detail__title">Product evaluation</span>
                                                        <span class="col star">
                                                        <span class="set-star">
                                                            <span class="score devStarScore" data-avg_pct="{[valuation_goods_pct]}" ></span>
                                                        </span>
                                                    </span>
                                                        <!--<img {[valuation_goods_pct]}>-->
                                                    </div>
                                                    <span class="review-detail__wrap-score">
                                                    <span class="review-detail__title">Shipping Evaluation</span>
                                                    <span class="col star">
                                                        <span class="set-star">
                                                            <span class="score devStarScore" data-avg_pct="{[valuation_delivery_pct]}" ></span>
                                                        </span>
                                                    </span>
                                                </span>
                                                    <!--<img class="score_{[valuation_delivery_pct]}" {[valuation_delivery_pct]}>-->
                                                </div>
                                                <div class="review-detail__content content">{[{bbs_contents}]}</div>
                                                {[#if isThumb]}
                                                <div class="review-detail__img-area review-img-area" id="devReviewImgsContents">
                                                    <figure class="review-detail__thumb thumb devViewReviewImg" id="devReviewImgsDetails" data-bbsIx="{[bbsIx]}" data-index="{[index]}">
                                                        <img src = "{[img]}" alt="goods thumbnail">
                                                    </figure>
                                                </div>
                                                {[/if]}

                                                <!--어드민 댓글-->
                                                {[#if cmt.cmt_ix]}
                                                <div class="review-detail__admin-comment admin_comment">
                                                    <p class="review-detail__admin-info">
                                                        <span class="review-detail__admin-info__title">{[cmt.cmt_name]}</span>
                                                        <span class="review-detail__admin-info__date">{[cmt.cmt_date]}</span>
                                                    </p>
                                                    <div class="review-detail__admin-text comment">
                                                        {[{cmt.cmt_contents}]}
                                                    </div>
                                                </div>
                                                {[/if]}
                                            </div>
                                        </li>

                                    </ul>

                                    <div class="wrap-pagination" id="devReviewPageWrap"></div>
                                </div>
                            </div>


                        </div>
<?php }else{?>
                        <div id="devAllReviewEmpty" class="empty-content">
                            <p>No product review</p>
                        </div>
<?php }?>
<?php }?>
<?php }?>
                </div>

                <!-- 상품정보 제공고시 -->
<?php if($TPL_VAR["langType"]=='korean'){?>
<?php if($TPL_VAR["mandatory_use"]=='Y'){?>
                <div class="tab-info__detail-offer">
                    <h2 class="fb__goods-view__sub-title">Product information announcement</h2>
                    <table class="offer-table"> <!--table-default-->
<?php if($TPL_mandatoryInfos_1){foreach($TPL_VAR["mandatoryInfos"] as $TPL_V1){?>
<?php if($TPL_V1["pmi_title"]!=''){?>
                        <tr>
                            <th class="offer-table__title"><?php echo $TPL_V1["pmi_title"]?></th>
                            <td class="offer-table__content"><?php echo $TPL_V1["pmi_desc"]?></td>
                        </tr>
<?php }?>
<?php }}?>
                        <tr>
                            <th class="offer-table__title">상품코드</th>
                            <td class="offer-table__content"><?php echo $TPL_VAR["pcode"]?></td>
                        </tr>
                    </table>
                </div>
<?php }?>
<?php }else{?>
<?php if($TPL_VAR["mandatory_use_global"]=='Y'){?>
                <div class="tab-info__detail-offer">
                    <h2 class="fb__goods-view__sub-title">Product information announcement</h2>
                    <table class="offer-table"> <!--table-default-->
<?php if($TPL_mandatoryInfosGlobal_1){foreach($TPL_VAR["mandatoryInfosGlobal"] as $TPL_V1){?>
                        <tr>
                            <th class="offer-table__title"><?php echo $TPL_V1["pmi_title"]?></th>
                            <td class="offer-table__content"><?php echo $TPL_V1["pmi_desc"]?></td>
                        </tr>
<?php }}?>
                        <tr>
                            <th class="offer-table__title">Style Code</th>
                            <td class="offer-table__content"><?php echo $TPL_VAR["pcode"]?></td>
                        </tr>
                    </table>
                </div>
<?php }?>
<?php }?>



                <!-- 배송안내 -->
<?php if($TPL_VAR["langType"]=='korean'){?>
                <div id="pubShippingGuide" class="view-detail">
                    <div class="fb__guide">
                        <h2 class="fb__goodslist__title">shipping information</h2>
<?php $this->print_("shippingGuide",$TPL_SCP,1);?>

                    </div>
                </div>
<?php }?>
                <!-- 세탁&주의사항 -->
                <div id="pubPrecautions" class="view-detail">
                    <div class="fb__wash">
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <h2 class="fb__goodslist__title">Washing & Care</h2>
<?php }else{?>
						<h2 class="fb__goodslist__title">Washing & Care</h2>
<?php }?>
                        <style>
							.wash_sub_txt {color:#666; font-size:14px; margin:14px 0;}
							.wash__category {padding-left:265px; position:relative;}
							.wash__category .wash_select {left:0; position:absolute; top:0;}
							.wash__category .wash_select select {width:223px; height:50px; border:#222 1px solid; color:#222; font-size:18px;}
							.wash__category ul {padding-top:1px;}
							.wash__category ul li {width:167px !important; height:50px; margin-top:-1px;}

							.fb__wash .wash__category-link {line-height:48px;}
							.fb__wash .wash__category-link--active:after {width:165px; height:48px; left:-1px; top:-1px; z-index:1;}
							.fb__wash .wash .contents__list {width:100%; display:table; padding:30px 0 30px 30px;}
							.fb__wash .wash .contents__subtitle {width:235px; display:table-cell; float:none; line-height:27px; vertical-align:middle;}
							.fb__wash .wash .contents__summary {width:650px; height:auto; display:table-cell; float:none;}
							.fb__wash .wash .contents__summary ul li {margin-bottom:0 !important;}
							.fb__wash .wash .contents__summary ul li:before {display:none;}
						</style>

						<div class="wash" id="laundryInfo">
<?php if($TPL_VAR["langType"]=='korean'){?>
							<div class="wash_sub_txt">카테고리를 선택해 주세요.</div>
<?php }else{?>
							<div class="wash_sub_txt">Please select a category.</div>
<?php }?>
							<nav class="wash__category">
								<span class="wash_select">
									<select name="laundryOneDepth" onchange="laundryChange(this.value)">
<?php if($TPL_laundryOneDepth_1){foreach($TPL_VAR["laundryOneDepth"] as $TPL_V1){?>
<?php if($TPL_VAR["langType"]=='english'){?>
												<option value="<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryCid"]==$TPL_V1["cid"]){?>selected<?php }?>><?php echo $TPL_V1["title_en"]?></option>
<?php }else{?>
												<option value="<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryCid"]==$TPL_V1["cid"]){?>selected<?php }?>><?php echo $TPL_V1["title"]?></option>
<?php }?>
<?php }}?>
									</select>
								</span>
								<ul>
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
									<li>
										<a href="#" data-target="<?php echo $TPL_V1["cid"]?>" class="wash__category-link <?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?>wash__category-link--active<?php }?>">
<?php if($TPL_VAR["langType"]=='english'){?>
												<?php echo $TPL_V1["title_en"]?>

<?php }else{?>
												<?php echo $TPL_V1["title"]?>

<?php }?>
										</a>
									</li>
<?php }}?>
								</ul>
							</nav>
							<div class="wash__contents">
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
								<section class="wash__contents__category wash__contents<?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?>__category--show wash__contents<?php }?>-<?php echo $TPL_V1["cid"]?>">
									<div class="contents">
										<h3 class="contents__title">
<?php if($TPL_VAR["langType"]=='english'){?>
												<?php echo $TPL_V1["title_en"]?>

<?php }else{?>
												<?php echo $TPL_V1["title"]?>

<?php }?>
										</h3>
									</div>
									<div class="contents__box">
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V2["cid"]){?>
											<ul class="contents__box-wash contents__box-detail contents__box-detail--show">
<?php }else{?>
											<ul class="contents__box-precaution contents__box-detail">
<?php }?>
												<li>
													<h3 class="contents__box__subtitle">
<?php if($TPL_VAR["langType"]=='english'){?>
															<?php echo $TPL_V2["title_en"]?>

<?php }else{?>
															<?php echo $TPL_V2["title"]?>

<?php }?>
													</h3>
												</li>
											</ul>
<?php if(is_array($TPL_R3=$TPL_V2["four"])&&!empty($TPL_R3)){foreach($TPL_R3 as $TPL_V3){?>
											<li class="contents__list">
												<h4 class="contents__subtitle">
<?php if($TPL_VAR["langType"]=='english'){?>
														<?php echo $TPL_V3["title_en"]?>

<?php }else{?>
														<?php echo $TPL_V3["title"]?>

<?php }?>
												</h4>
												<div class="contents__summary">
													<ul>
														<li>
<?php if($TPL_VAR["langType"]=='english'){?>
																<?php echo $TPL_V3["contents_en"]?>

<?php }else{?>
																<?php echo $TPL_V3["contents"]?>

<?php }?>
														</li>
													</ul>
												</div>
											</li>
<?php }}?>
<?php }}?>
									</div>
								</section>
<?php }}?>
							</div>
						</div>
                    </div>
                </div>

                <!--교환/반품 안내-->
                <div id="devTabExchange" class="view-detail fb__cosmetics">
                    <div class="cosmetics fb__claim">
                        <h2 class="fb__goodslist__title">Returns / Refunds</h2>
<?php $this->print_("cliamGuide",$TPL_SCP,1);?>

                    </div>
                </div>
                <!--상품수선안내-->
                <div id="pubRepairGuide" class="view-detail">
                    <div class="fb__guide">
                        <h2 class="fb__goodslist__title">Repair Information</h2>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <div class="fb__goodslist__repair">
                            <p>불량 확인 또는 수선 가능 문의 및 요청은 <span>마이페이지 > 1:1 문의하기</span> 게시판에 작성 부탁드립니다.</p>
                            <a class="fb__goodslist__repair--btn" href="/customer/productRepairGuide">A/S 신청 및 접수 방법 자세히 보기</a>
                        </div>
<?php }else{?>
                        <div class="fb__goodslist__repair">
                            <p>
                                Any inquiry regarding defective and repair, please go on to <br>
                                <span>My Page > request 1:1 inquiry</span> or e-mail us at <span><a href="mailto:en_help@getbarrel.com">en_help@getbarrel.com</a></span>
                            </p>
                        </div>
<?php }?>
                    </div>
                </div>

				<!--상품문의-->
                <form id="devProductQnaForm">
                    <input type="hidden" name="id" value="<?php echo $TPL_VAR["pid"]?>" id="devQnaPid"/>
                    <input type="hidden" name="qnaType" value="all" id="devQnaType"/>
                    <input type="hidden" name="qnaDiv" value="all"/>
                    <input type="hidden" name="page" value="1" id="devQnaPage"/>
                    <input type="hidden" name="max" value="10" id="devQnaMax"/>
                </form>
                <div id="devTabInquiry" class="tab-qna view-detail"> <!--tab-inquiry-->
                    <section class="fb__goods-view__other">
                        <div class="other-box">
                            <h3 class="other-box__title">Q&A <span>If you have any question about the item, please feel free to contact us.</span></h3>
                            <button class="tab-qna__write btn-default btn-dark btn-qna-write" id="devQnaWrite" data-pid="<?php echo $TPL_VAR["pid"]?>">Write</button>
                        </div>
                    </section>
                    <div class="tab-qna__list wrap-tab-cont inquiry-list">
                        <div id="inquiry-tab1" class="active">
                            <ul id="devQnaContents">
                                <li id="devQnaBasicContents">
                                    <div class="inquiry title tab-qna__row--title">
                                        <div class="tab-qna__row__type col type">
                                            Sort
                                        </div>
                                        <div class="tab-qna__row__status col status">
                                            Status
                                        </div>
                                        <div class="tab-qna__row__subject col tit">
                                            Title
                                        </div>
                                        <div class="tab-qna__row__user col user">
                                            Writer
                                        </div>
                                    </div>
                                </li>

                                <li id="devQnaLoading" class="empty-content">
                                    <div class="wrap-loading">
                                        <div class="loading"></div>
                                    </div>
                                </li>

                                <li id="devQnaEmpty" class="empty-content">No product inquiry</li>

                                <li id="devQnaDetail">
                                    <div class="inquiry qna-title devQnaDetailCover tab-qna__row" data-isSameUser="{[isSameUser]}" data-isHidden="{[isHidden]}">
                                        <div class="tab-qna__row__type col type">
                                            {[div_name]}
                                        </div>
                                        <div class="tab-qna__row__status col status">
                                            <p class="{[#if isResponse]}complete{[/if]}">{[#if isResponse]}Completed{[else]}Pending{[/if]}</p>
                                        </div>
                                        <div class="tab-qna__row__subject col tit">
                                            <p class="{[#if isHidden]}private {[#if isSameUser]}{[else]}devNotSameUser{[/if]}{[/if]} {[#if isSameUser]}my-qna{[/if]}">{[#if isSameUser]}<strong>[My Q&A]</strong>{[/if]} {[bbs_subject]}</p>
                                        </div>
                                        <div class="tab-qna__row__user col user">
                                            <span class="">{[bbs_name]}</span>
                                        </div>
                                    </div>
                                    <div class="inquiry-detail tab-qna__row-detail" id="devQnaDetailContents">
                                        <div id="devQnaQuestion">
                                            <p class="tab-qna__row-detail__question">{[bbs_contents]}</p>
                                            <!-- [S] 답변 받기 전, 내 글인 경우 -->
                                            {[#if isResponse]}
                                            {[else]}
                                            {[#if isSameUser]}
                                            <div class="tab-qna__row-detail__btn">
                                                <button class="tab-qna__row-detail__btn--edit devModifyQna" data-bbs_ix="{[bbs_ix]}" data-pid="<?php echo $TPL_VAR["pid"]?>">Edit</button>
                                                <button class="tab-qna__row-detail__btn--del devDeleteQna" data-bbs_ix="{[bbs_ix]}">Delete</button>
                                            </div>
                                            {[/if]}
                                            {[/if]}
                                        </div>
                                        <div class="tab-qna__row-detail__answer wrap-answer" id="devQnaResponse">
                                            <div class="info">
                                                <span>BARREL</span> {[regdate]}
                                            </div>
                                            <p class="answer">{[cmt_contents]}</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <div class="wrap-pagination" id="devQnaPageWrap">
                                <button class="first">first</button>
                                <button class="prev">prev</button>
                                <a class="on" href="">1</a>
                                <button class="next">first</button>
                                <button class="last">prev</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
        <!--aside-->
    </div>
</section>

<section class="tab-popup-content">

</section>
<!-- 연관상품 -->
<input type="hidden" name="hcid" value="<?php echo $TPL_VAR["cid"]?>" />
<input type="hidden" name="hpid" value="<?php echo $TPL_VAR["id"]?>" />

<!-- cre.ma / 리뷰 작성 유도 팝업 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
<div class="crema-popup"></div>