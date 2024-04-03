<?php /* Template_ 2.2.8 2021/11/18 10:35:00 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/shop/goods_view/goods_view.htm 000108270 */ 
$TPL_add_image_src_1=empty($TPL_VAR["add_image_src"])||!is_array($TPL_VAR["add_image_src"])?0:count($TPL_VAR["add_image_src"]);
$TPL_icons_path_1=empty($TPL_VAR["icons_path"])||!is_array($TPL_VAR["icons_path"])?0:count($TPL_VAR["icons_path"]);
$TPL_sameProduct_1=empty($TPL_VAR["sameProduct"])||!is_array($TPL_VAR["sameProduct"])?0:count($TPL_VAR["sameProduct"]);
$TPL_product_gift_1=empty($TPL_VAR["product_gift"])||!is_array($TPL_VAR["product_gift"])?0:count($TPL_VAR["product_gift"]);
$TPL_colorChipList_1=empty($TPL_VAR["colorChipList"])||!is_array($TPL_VAR["colorChipList"])?0:count($TPL_VAR["colorChipList"]);
$TPL_togeterProduct_1=empty($TPL_VAR["togeterProduct"])||!is_array($TPL_VAR["togeterProduct"])?0:count($TPL_VAR["togeterProduct"]);
$TPL_similraProduct_1=empty($TPL_VAR["similraProduct"])||!is_array($TPL_VAR["similraProduct"])?0:count($TPL_VAR["similraProduct"]);
$TPL_eventBannerInfo_1=empty($TPL_VAR["eventBannerInfo"])||!is_array($TPL_VAR["eventBannerInfo"])?0:count($TPL_VAR["eventBannerInfo"]);
$TPL_productGiftInfo_1=empty($TPL_VAR["productGiftInfo"])||!is_array($TPL_VAR["productGiftInfo"])?0:count($TPL_VAR["productGiftInfo"]);
$TPL_laundryOneDepth_1=empty($TPL_VAR["laundryOneDepth"])||!is_array($TPL_VAR["laundryOneDepth"])?0:count($TPL_VAR["laundryOneDepth"]);
$TPL_laundry_1=empty($TPL_VAR["laundry"])||!is_array($TPL_VAR["laundry"])?0:count($TPL_VAR["laundry"]);
$TPL_mandatoryInfos_1=empty($TPL_VAR["mandatoryInfos"])||!is_array($TPL_VAR["mandatoryInfos"])?0:count($TPL_VAR["mandatoryInfos"]);
$TPL_mandatoryInfosGlobal_1=empty($TPL_VAR["mandatoryInfosGlobal"])||!is_array($TPL_VAR["mandatoryInfosGlobal"])?0:count($TPL_VAR["mandatoryInfosGlobal"]);?>
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
    (window,document,'script','crema-jssdk','//<?php echo CREMA_WIDGET_HOST?>/getbarrel.com/mobile/init.js');
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


<script type="text/javascript">
    $(function() {
        $(window).scroll(function() {
            if ($(this).scrollTop() >= Math.ceil($('.goods-info__other').offset().top)) {
                //  보임
                $(".br__goods-view__btn").css("display", "block");
                $(".br__goods-view__minicart--toggle").css("display", "block");
                $(".br__goods-view__minicart").css("display", "flex");
            } else {
                //  숨김
                $(".br__goods-view__btn").css("display", "none");
                $(".br__goods-view__minicart--toggle").css("display", "none");
                $(".br__goods-view__minicart").css("display", "none");
            }
        });
    });
</script>
<style>
    .goods-tabs__cont .goods-detail__view iframe {
        height:250px;
    }

    .crema-type .br__goods-view__time-sale .time-sale__title {font-size:1.3rem; line-height:2.1rem;}
    .crema-type .br__goods-view__time-sale .time-sale__countdown--show {font-size:1.2rem; line-height:2rem;}
    .crema-type .br__goods-view__time-sale .time-sale__countdown--show span {font-size:1.3rem; line-height:2.1rem;}

    .crema-type .br__goods-view .goods-info__price {/*margin-bottom:0.5rem;*/}
    .crema-type .br__goods-view .goods-info__price__strike {font-family:'Roboto_Regular'; font-size:1.2rem; margin-bottom:0.5rem;}
    .crema-type .br__goods-view .goods-info__price__result {font-size:1.2rem; line-height:2.6rem; letter-spacing:-0.1rem;}
    .crema-type .br__goods-view .goods-info__price__result span {font-family:'Roboto_Bold' !important; font-size:2rem; font-weight:900 !important; line-height:2.6rem;}
    .crema-type .br__goods-view .goods-info__benefit-list {height:2rem; background-color:#fff; border:1px solid #000; border-radius:2rem; color:#000; font-size:1.1rem; line-height:2rem; padding:0 1.2rem; vertical-align:4px;} 
    .crema-type .br__goods-view .goods-info__benefit-list:after {display:none;}
    .crema-type .br__goods-view .goods-info__price__discount {bottom:2.1rem; color:#00bce7; font-size:2.5rem;}
    .crema-type .br__goods-view .goods-info__price__discount span {font-size:4rem;}
    .crema-type .br__goods-view .goods-info__coupon {padding:0 0 3rem;}
    .crema-type .br__goods-view .goods-info__coupon__btn {background-color:#000; font-size:1.2rem;}
    .crema-type .br__goods-view .goods-info__color {border-top:1px solid #f0f0f0; padding:3rem 1.4rem 0;}

    .crema-type .br__goods-view .goods-info {padding:0;}
    .crema-type .br__goods-view .goods-info__size {border-top:none; padding:1.7rem 0 2.75rem; position:relative;}
    .crema-type .br__goods-view .goods-info__size__guide {border-bottom:none; right:0.3rem; top:1.4rem;}

    .crema-type .br__goods-view .goods-info__color__title {font-size:1.3rem; padding:0.1rem;}
    .crema-type .br__goods-view .goods-info__color__title span {font-size:1.2rem;}

    .crema-type .br__goods-view .goods-info__size__btn:disabled:before {display:none;}

    .crema-type .br__goods-view .goods-info__color__box {width:20%; margin-right:0; padding:0 0.3rem;}
    .crema-type .br__goods-view .goods-info__color__link {width:100%; height:3.2rem;}
    .crema-type .br__goods-view .goods-info__color__link--active {border:0.2rem solid #000; outline:none !important; padding:0.1rem;}

    .crema-type .br__goods-view .goods-info__size__alarm {width:38%; height:3.2rem; font-size:1.2rem; font-weight:700; line-height:3.2rem; margin:1.25rem 0 0.75rem 0.3rem;}

    .crema-type .br__goods-view .goods-info__size__title {font-size:1.3rem; padding:0.1rem;}
    .crema-type .br__goods-view .goods-info__size__title span {font-size:1.2rem;}
    .crema-type .br__goods-view .goods-info__size__box {width:20%; margin-right:0; padding:0 0.3rem;}
    .crema-type .br__goods-view .goods-info__size__box:nth-child(6n+1) {clear:none;}
    .crema-type .br__goods-view .goods-info__size__box:nth-last-child(-n+6) {margin-bottom:0.75rem;}
    .crema-type .br__goods-view .goods-info__size__btn {width:100%; height:3.2rem; font-size:1.2rem;}

    .crema-fit-product-combined-summary {margin:10px 0;}

    .crema-type .br__goods-view__option .goods-option--add {margin-top:0.55rem; padding:0 1.5rem 3rem; position:relative;}
    .crema-type .br__goods-view__option .goods-option--add:before {content: ""; position: absolute; left: 0; right: 0; bottom: 100%; height: 0.5rem; border-top: 1px solid #dcdddd; background: #efefef;}
    .crema-type .br__goods-view__option .goods-option__title {font-size:1.3rem; line-height:2.4rem; padding:3rem 0 1rem;}
    .crema-type .br__goods-view__option .goods-option__title:after {top:3.6rem;}
    .crema-type .br__goods-view__option .goods-option__box {border-bottom:none; padding:1rem 0;}

    .crema-type .br__goods-view__option .goods-option__info__title {font-size:1.3rem; line-height:2.1rem; margin-bottom:0.5rem; height:52px;}
    .crema-type .br__goods-view__option .goods-option__info__addinfo {color:#000; font-size:1.2rem; line-height:2rem;}


    .crema-type .br select {border:#dcdddd 1px solid; color:#b5b5b6; font-size:1.2rem;}

    .crema-type .br .goods-cart__wrap {padding:0 1.5rem; position:relative;}
    .crema-type .br .goods-cart__wrap:before {content: ""; position: absolute; left: 0; right: 0; bottom: 100%; height: 0.5rem; border-top: 1px solid #dcdddd; background: #efefef;}
    .crema-type .br .goods-cart__wrap .goods-cart__box:last-child:after {content: ""; position: absolute; left: 0; right: 0; bottom:0; height: 3px; background: #000; margin:0 1.5rem;}
    .crema-type .br .goods-cart {background-color:#fff; border-top:none;}

    .crema-type .br .goods-cart__box {border-top:#f0f0f0 1px solid; padding:3rem 1.5rem 3rem; position:relative;}
    .crema-type .br .goods-cart__box:first-child {border-top:none;}
    .crema-type .br .goods-cart__box:last-child {padding-bottom:3.5rem;}
    .crema-type .br .goods-cart__box:last-child .price {bottom:3.4rem;}
    .crema-type .br .goods-cart__box:last-child .btn-option-del2 {bottom:3.3rem;}
    .crema-type .br .goods-cart__tit {font-size:1.3rem; line-height:2.1rem; margin-bottom:2.6rem; padding-right:9rem;}
    .crema-type .br .goods-cart__sub {color:#898989; font-size:1.2rem; margin-top:0.6rem; padding-right:10rem;}

    .crema-type .control {position:absolute; right:1.5rem; top:2.6rem;}

    .crema-type .br .goods-cart {padding:0;}
    .crema-type .br .goods-cart .price {bottom:3rem; right:3.5rem; float:right;position: unset;}
    .crema-type .br .goods-cart .price em {font-family:'Roboto_Medium'; font-size:1.3rem;}
    .crema-type .br .goods-cart .btn-option-del2 {width:1.6rem !important; height:1.6rem !important; background-size:1.6rem !important; bottom:2.9rem; right:15px; !important;}
    /*.crema-type .br .goods-cart .btn-option-del {background:url(/assets/mobile_templet/mobile_enterprise/images/common/icon_detail_minicart_cancel2.png) no-repeat; position:relative; top:0.5rem; background-size:100%;}*/

    .crema-type .br .br__goods-view__recommend {margin-top:0;}

    .crema-type .br .br__goods-view__tabs {margin-top:0;}
    .crema-type .br .br__goods-view__tabs:before {display:none;}

    .crema-type .br__goods-view__recommend .goods-recom__title {font-size:1.8rem; line-height:2.4rem; padding-top:3rem;}

    .crema-type .br__goods-view .goods-info__other {border-top:none; padding:3rem 1.5rem 2rem; position:relative;}
    .crema-type .br__goods-view .goods-info__other:before {content: ""; position: absolute; left: 0; right: 0; bottom: 100%; height: 0.5rem; border-top: 1px solid #dcdddd; background: #efefef;}
    .crema-type .br__goods-view .goods-info__review {border-top:#f0f0f0 1px solid; padding:2rem 1.5rem 3rem;}

    .crema-type .br__goods-view .goods-info__review__title {font-size:1.3rem; line-height:2.1rem; margin-right:1rem;}

    .crema-type .br__goods-view .goods-info__review__star {height:1.3rem; margin-top:0.2rem; padding-right:2rem;}
    .crema-type .br__goods-view .goods-info__review__star--number {color:#000; top:0.3rem;}

    .crema-type .br__goods-view .goods-info__review__btn {margin-top:0.3rem;}
    .crema-type .br__goods-view .goods-info__review__btn:after {display:none;}

    .crema-type .br__goods-view__tabs .goods-review {padding:0; position:relative;}
    .crema-type .br__goods-view__tabs .goods-review:before {content: ""; position: absolute; left: 0; right: 0; bottom: 100%; height: 0.5rem; border-top: 1px solid #dcdddd; background: #efefef;}

    .crema-type .br__goods-view__tabs .goods-review__title {font-size:1.8rem; line-height:2.4rem; padding:3rem 1.5rem 1rem;}
    .crema-type .br__goods-view__tabs .goods-review__title:before {content: ""; position: absolute; left: 0; right: 0; bottom: 100%; height: 0.5rem; border-top: 1px solid #dcdddd; background: #efefef;}
    .crema-type .br__goods-view__tabs .goods-review__title span {color:#00bce7; font-weight:700;}

    .crema-type .br__goods-view__tabs .goods-review__des {color:#b5b5b6; font-size:1.2rem; line-height:2rem; padding:0 1.5rem;}


    .crema-type .br__goods-view__tabs .goods-review__best {border-top:none; margin-top:0; padding:0;}

    .crema-type .br__goods-view__tabs .goods-review__best__title {font-size:1.3rem; line-height:2.1rem; padding:0 1.5rem;}
    .crema-type .br__goods-view__tabs .goods-review__best__desc {color:#000; font-size:1.2rem; line-height:2rem; margin-top:0; padding:0 1.5rem;}

    .crema-type .br__goods-view__tabs .goods-review__best__rank {margin:2rem 1.5rem 0;}

    .rank-list2 li {background-color:#f8f8f8; color:#000; display:block; margin-bottom:1rem; padding:2rem 2rem; position:relative;}
    .rank-list2 li .rank-list2-txt1 {font-size:1.4rem;}
    .rank-list2 li .rank-list2-txt2 {float:right; font-size:1.5rem; margin-top:-0.2rem;}
    .rank-list2 li .rank-list2-txt2 strong {font-size:2rem;}

    .crema-type .br .goods-view__recent-btn--imsi {bottom:15.7rem;}

    .crema-type .br .goods-view__recent-btn {right:1rem;}
    .crema-type .br .goods-view__recent-btn img {width:15px; height:15px; left:1.1rem; position:absolute; top:0.8rem;}

    .crema-type .br__floating-btn--up {bottom:39px; right:1rem;}
    .crema-type .br__floating-btn--down {right:1rem;}

    .crema-type .br__goods-view .goods-info__color__box:nth-child(6n+1) {clear:none;}
    .crema-type .br__goods-view .goods-info__color__box:nth-last-child(-n+6) {margin-bottom:0.75rem;}

    .crema-type .br__goods-view__pre {font-size:1.2rem; line-height:2rem; margin-bottom:2rem;}
    .crema-type .br__goods-view .goods-info__title {font-size:1.8rem; line-height:2.6rem; margin-bottom:1rem;}

    .crema-type .br__goods-view .goods-info__other__list dt {width:6.5rem; font-size:1.3rem; line-height:2.1rem; margin-right:2rem;}
    .crema-type .br__goods-view .goods-info__other__list dd {font-size:1.2rem; line-height:2rem;}

    .crema-type .br__goods-view__recommend .goods-recom {padding:0 1.5rem 2.5rem;}

    .crema-type .br__goods-view__recommend .goods-recom__info__strike {font-family:'Roboto_Regular'; }
    .crema-type .br__goods-view__recommend .goods-recom__info__result {font-family:'Roboto_Medium'; }
    .crema-type .br__goods-view__recommend .goods-recom__info__discount {float:right; font-weight:700; font-size:1.2rem;}

    .crema-type .br__goods-view__recommend .goods-recom__wrap {margin-top:2rem;}
    .crema-type .br__goods-view__recommend .goods-recom__list {padding:0 1.5rem;}

    .crema-type .br__goods-view__minicart .minicart__banner {margin-top:0.5rem;}
    .crema-type .br__goods-view__minicart .minicart__banner__desc {font-size:0.9rem; line-height:1.6rem;}

    .crema-type .br .goods-alarm__options__box:nth-last-of-type(-n+5) {width:20%;}
    .crema-type .br .goods-alarm__options__btn {width:100%; height:3.2rem; border:#000 1px solid; color:#000; font-size:1.2rem; line-height:3.2rem;}

    .crema-type .br .goods-alarm__options__btn--active {background: #000; color:#FFF;}

    .crema-type .br .goods-alarm__options__btn:before {border:none;}
    .crema-type .br .goods-alarm__options__box input[type=radio]:disabled + label:before {display:none;}

    input[type="radio"]:disabled + label {border:#b5b5b6 1px solid !important; color:#b5b5b6 !important;}

    .br__goods-view__information .goods-cart {position:relative;}
    .br__goods-view__information .goods-cart:before {content: ""; position: absolute; left: 0; right: 0; bottom: 100%; height: 0.5rem; border-top: 1px solid #dcdddd; background: #efefef;}

    
    .crema-type .br__goods-view__minicart {bottom:4.5rem;}

    .crema-type .br__goods-view__minicart--dimmed {bottom:5rem;}

    .crema-type .br__goods-view__minicart .minicart__total {background:#fff; bottom:2.1rem; padding:1.5rem; position:relative; z-index:999;}
    .crema-type .br__goods-view__minicart .minicart__total:before {content: ""; position: absolute; left: 0; right: 0; bottom: 100%; height: 0.5rem; border-top: 1px solid #dcdddd; background: #efefef;}

    .crema-type .br__goods-view__minicart .minicart__total__text {font-size:1.2rem; line-height:2rem; color:#666;}

    .crema-type .br__goods-view__minicart .minicart__total__price {color:#000; font-size:1.2rem; line-height:2rem;}
    .crema-type .br__goods-view__minicart .minicart__total__price span {color:#00bce7; font-size:2rem; line-height:3rem; font-weight:600; vertical-align:-0.1rem;}

    .crema-type .br__goods-view__minicart .minicart .br__goods-view__information {padding-bottom:2.6rem;}
    .crema-type .br__goods-view__minicart .minicart .br__goods-view__information .goods-info {padding-bottom:0;}
    .crema-type .br__goods-view__minicart .minicart .br__goods-view__information .goods-info > div[class^=goods-info__] {padding:0;}

    .crema-type .br__goods-view__btn .goods-btn__store, .crema-type .br__goods-view__btn .goods-btn__cart, .crema-type .br__goods-view__btn .goods-btn__buy {height:4.5rem;}

    .crema-type .br__goods-view__btn .goods-btn__store {border:#e6e6e6 1px solid;}
    .crema-type .br__goods-view__btn .goods-btn__cart {background:#e6e6e6; color:#000; }
    .crema-type .br__goods-view__btn .goods-btn__buy {background:#000;}

    .crema-type .br__goods-view__recommend .goods-recom__info__price {border-top:#f0f0f0 1px solid;}

    .crema-type .br__goods-view__tabs .goods-tabs__list {border-top:#f0f0f0 1px solid; border-bottom:#000 1px solid;}

    .crema-type .br__goods-view__tabs .goods-review__best__refer {margin-top:1rem; padding:0 1.5rem 3rem;}

    .crema-type .br__goods-view__tabs .goods-review__best_btn {padding:0 1.5rem;}
    .crema-type .br__goods-view__tabs .goods-review__best_btn a {background-color:#000; color:#fff; display:block; font-family:'noto sans cjk kr_medium'; font-size:1.2rem; font-weight:600; line-height:2rem; padding:1rem 0; text-align:center;}

    .crema-type .br__goods-view__tabs .goods-review__best__kind {border-top:#f0f0f0 1px solid; margin-top:2rem; padding:1rem 0 2rem;}
    .crema-type .br__goods-view__tabs .goods-review__best__kind .best-kind {border-bottom:none; padding:1rem 0;}
    .crema-type .br__goods-view__tabs .goods-review__best__kind .best-kind__title {width:10.5rem; line-height:2.1rem; padding:0 2rem 0 1.5rem;}
    .crema-type .br__goods-view__tabs .goods-review__best__kind .best-kind__desc {font-size:1.2rem; line-height:2rem; padding:0 1.5rem 0 0;}

    .crema-type .br__goods-view__tabs .goods-tabs__cont {position:relative;}
    .crema-type .br__goods-view__tabs .goods-tabs__cont:before {display:none; /*content: ""; position: absolute; left: 0; right: 0; bottom: 100%; height: 0.5rem; border-top: 1px solid #dcdddd; background: #efefef;*/}
    
    .crema-type .br__goods-view__tabs .goods-qna__write {padding:3rem 1.5rem 0;}
    .crema-type .br__goods-view__tabs .goods-qna__write:before {content: ""; position: absolute; left: 0; right: 0; bottom: 100%; height: 0.5rem; border-top: 1px solid #dcdddd; background: #efefef;}
    .crema-type .br__goods-view__tabs .goods-qna__write__title {font-size:1.8rem; line-height:2.4rem;}
    .crema-type .br__goods-view__tabs .goods-qna__write__title span {color:#00bce7;}
    
    .crema-type .br__goods-view__tabs .goods-qna__write__desc {width:100%; color:#000; font-size:1.2rem; line-height:2rem;}
    .crema-type .br__goods-view__tabs .goods-qna__write__btn {width:100%; color:#fff; display:block; font-family:'noto sans cjk kr_medium'; font-size:1.2rem; font-weight:600; line-height:2rem; margin:2rem 0 3rem; padding:1rem 0px; text-align:center; position:unset;}

    .crema-type .br__goods-view__tabs .goods-qna__list {border-top:#f0f0f0 1px solid; }
    .crema-type .br__goods-view__tabs .goods-qna__box .qna-info {border-bottom:#f0f0f0 1px solid; }
    .crema-type .br__goods-view__tabs .goods-qna__box .qna-info__state {width:auto; height:2rem; background-color:#fff; border:1px solid #b5b5b6; border-radius:2rem; color:#b5b5b6; font-size:1.1rem; line-height:2rem; margin-bottom:0; padding:0 1.2rem; vertical-align:4px;}

    .crema-type .br__goods-view__tabs .goods-qna__box .qna-info__type, .crema-type .br__goods-view__tabs .goods-qna__box .qna-info__name {color:#b5b5b6; font-size:1.1rem; line-height:1.8rem; vertical-align:5px;}

    .crema-type .br__goods-view__tabs .goods-qna__box .qna-info__title {margin-top:1rem;}
    .crema-type .br__goods-view__tabs .goods-qna__box .qna-info__state--point {border-color:#00bce7; color:#00bce7; }

    .crema-type .br__goods-view__tabs .goods-qna__box .qna-detail {background:#f0f0f0; border-bottom:none; padding:2rem 0;}
    .crema-type .br__goods-view__tabs .goods-qna__box .qna-detail__question__desc {font-size:1.1rem; line-height:1.8rem; padding:0 1.5rem;}
    .crema-type .br__goods-view__tabs .goods-qna__box .qna-detail__question__mod {margin-top:2rem;}
    .crema-type .br__goods-view__tabs .goods-qna__box .qna-detail__question__btn {line-height:1.8rem; margin-left:1rem;}
    
    .crema-type .br__goods-view__tabs .goods-qna__box .qna-info__my-qna {font-size:1.3rem; margin-bottom:2rem;}

    .crema-type .br__goods-view__tabs .goods-qna__box .qna-detail__answer {border-top:1px solid #b5b5b6; margin-top:2rem;}
    .crema-type .br__goods-view__tabs .goods-qna__box .qna-detail__answer__desc {font-size:1.1rem; line-height:1.8rem;}
    .crema-type .br__goods-view__tabs .goods-qna__box .qna-detail__answer__info {padding:1rem 1.5rem 0;}

    .crema-type .br .wrap-pagination {margin:2rem auto 4.5rem;}

    .crema-type .br__goods-view__tabs .goods-tabs__cont .goods-detail__acco:before {content: ""; position: absolute; left: 0; right: 0; bottom: 100%; height: 0.5rem; border-top: 1px solid #dcdddd; background: #efefef;}
    .crema-type .br__goods-view__tabs .goods-detail__acco__btn {border-bottom:#f0f0f0 1px solid; font-size:1.2rem; line-height:2rem; font-weight:400; padding:1rem 4rem 1rem 1.5rem;}
    .crema-type .br__goods-view__tabs .goods-notice__box {border-top:#f0f0f0 1px solid;}
    .crema-type .br__goods-view__tabs .goods-notice__btn {font-size:1.2rem; line-height:2rem; font-weight:400; padding:1rem 3.5rem 1rem 1.5rem;}
    .crema-type .br__goods-view__tabs .goods-detail__acco__cont {padding:2rem 1.5rem 3rem;}

    .goods-review__crema {padding-top:1rem;}

    .crema-type .br__goods-view__btn .goods-btn__sold-out {height:5rem; border:none; flex-basis:80%;}

    .crema-type .br .goods-cart__price {bottom:4.2rem; font-size:1rem; right:0;}
    .crema-type .br .goods-cart__price em {font-family:'Roboto_Regular' !important; font-weight:500; font-size:1.3rem; margin-right:0.2rem;}

    .crema-type .br__footer__gdweb {padding-bottom:10rem;}

    .crema-type .br .goods-alarm__submit {background:#000; }

    .crema-type .br__qna-write__detail .write-form__submit__btn {background:#000;}

    .crema-type .br .layer__benefit-list {border-top:#b5b5b6 1px solid;}
    .crema-type .br .layer__benefit-list .benefit-list__price {border-bottom:#b5b5b6 1px solid;}
    .crema-type .br .layer__benefit-list .benefit-list__type {border-bottom:#b5b5b6 1px solid;}

    .goods-option--active .goods-option__title:after {transform:rotate(180deg); right:0.4rem !important;}

    .br__floating-btn--historyback {display:none;}



    .crema-type .br__goods-view .goods-info__set {padding:3rem 0; padding-bottom:0; border-top: none;}
    .crema-type .br__goods-view .goods-info__set__box {margin-top:1rem;}
    .crema-type .br__goods-view .goods-info__set__title {font-size:1.3rem; line-height:2rem; font-weight:500;}

    .crema-type .br__goods-view .bx2{margin-top:1rem;}

    .crema-type .br__goods-view .bxbx2{padding:2rem 0; border:none; padding-bottom:0;}
    .crema-type .br__goods-view .bxbx2:last-child {padding-bottom:3.5rem;}

    .crema-type .br__goods-view__minicart .minicart .goods-info__set {padding-right:0; padding-left:0;}


    .crema-type .br__goods-view__event .goods-event {padding-top:3rem; padding-bottom:3rem;}

    .ig_li_bn {margin-bottom:1rem;}
    .ig_li_bn:last-child {margin-bottom:0;}

    .ig_div1 {    position: absolute;   right: 15px;    bottom: 38px;}
</style>

<!-- vimeo api (영상) -->
<script src="https://player.vimeo.com/api/player.js"></script>

<section class="br__goods-view">
    <h2 class="br__hidden">Product Detail</h2>
    <!-- [S] 상품슬라이드 -->
    <section class="br__goods-view__thumb">
        <h3 class="br__hidden">Product Thumnail</h3>
        <div class="goods-thumb">
            <div class="swiper-container">
                <ul class="swiper-wrapper">
<?php if($TPL_VAR["movie_now"]=='Y'){?>
<?php if($TPL_VAR["movie"]){?>
                        <li class="swiper-slide">
                            <!--<figure class="goods-thumb__box">-->
                            <!--<iframe src="<?php echo $TPL_VAR["movie"]?>" style="width: 100%; height:100%;"></iframe>-->
                            <!--</figure>-->
                            <div class="goods-thumb__box" id="js__video__target" data-movie="<?php echo $TPL_VAR["movie"]?>"></div>
                        </li>
<?php }?>
                        <li class="swiper-slide">
                            <a href="<?php echo $TPL_VAR["image_src"]?>" target="_blank" title="썸네일 원본보기">
                                <figure class="goods-thumb__box">
                                    <img src="<?php echo $TPL_VAR["image_src"]?>" alt="상품 썸네일">
                                </figure>
                            </a>
                        </li>
<?php }else{?>
                        <li class="swiper-slide">
                            <a href="<?php echo $TPL_VAR["image_src"]?>" target="_blank" title="썸네일 원본보기">
                                <figure class="goods-thumb__box">
                                    <img src="<?php echo $TPL_VAR["image_src"]?>" alt="상품 썸네일">
                                </figure>
                            </a>
                        </li>
<?php if($TPL_VAR["movie"]){?>
                        <li class="swiper-slide">
                            <!--<figure class="goods-thumb__box">-->
                                <!--<iframe src="<?php echo $TPL_VAR["movie"]?>" style="width: 100%; height:100%;"></iframe>-->
                            <!--</figure>-->
                            <div class="goods-thumb__box" id="js__video__target" data-movie="<?php echo $TPL_VAR["movie"]?>"></div>
                        </li>
<?php }?>
<?php }?>
<?php if($TPL_add_image_src_1){foreach($TPL_VAR["add_image_src"] as $TPL_V1){?>
                    <li class="swiper-slide">
                        <a href="<?php echo $TPL_V1["bigImg"]?>" target="_blank" title="썸네일 원본보기">
                            <figure class="goods-thumb__box">
                                <img src="<?php echo $TPL_V1["bigImg"]?>" alt="상품 썸네일">
                            </figure>
                        </a>
                    </li>
<?php }}?>
                </ul>
                <button class="swiper-button-prev">prev</button>
                <button class="swiper-button-next">next</button>
                <div class="swiper-pagination"></div>
<?php if($TPL_VAR["movie"]){?>
                <button class="goods-thumb__play">play clip</button>
<?php }?>
            </div>

        </div>
        <div class="layer-zoom">
            <div class="layer-zoom__img">

            </div>
            <button type="button" class="layer-zoom__close">close layer</button>
        </div>
    </section>
    <!-- [E] 상품슬라이드 -->
    <!-- [S] 타임세일 -->
<?php if($TPL_VAR["discountView"]){?>
    <section class="br__goods-view__time-sale">
        <div class="time-sale">
            <p class="time-sale__title"><span>Time Sale Item</span></p>
            <p class="time-sale__countdown"><span><?php echo $TPL_VAR["saleTime"]?></span> end after !</p>
        </div>
    </section>
<?php }?>
    <!-- [E] 타임세일 -->
    <!-- [S] 상품기본정보 -->
    <section class="br__goods-view__information">
        <h3 class="br__hidden">Product information</h3>
        <div class="goods-info">
            <p class="br__goods-view__pre"><?php echo $TPL_VAR["preface"]?></p>

            <div class="goods-info__badge" style="margin-bottom:0; display:none;">
                <h4 class="br__hidden">Product badge</h4>
<?php if($TPL_icons_path_1){foreach($TPL_VAR["icons_path"] as $TPL_V1){?>
                    <?php echo $TPL_V1?>

<?php }}?>
            </div>

            <div class="goods-info__btns">
                <h4 class="br__hidden">Product Share & Wish Button</h4>
                <button class="goods-info__btns__share">Share</button>
                <label class="goods-info__btns__wish <?php if($TPL_VAR["alreadyWish"]){?>on<?php }?>" devwishbtn="<?php echo $TPL_VAR["pid"]?>">
<?php if($TPL_VAR["alreadyWish"]){?>
                    <input type="checkbox" checked>
<?php }else{?>
                    <input type="checkbox">
<?php }?>
                    Add to wishlist
                </label>
                <div class="layer-share" style="display:none;">
                    <h5 class="layer-share__title"><?php echo $TPL_VAR["pname"]?></h5>
                    <p class="layer-share__option"><?php echo $TPL_VAR["add_info"]?></p>
                    <ul class="layer-share__list">
                        <!--<li class="layer-share__box">-->
                            <!--<button class="layer-share__btn layer-share__btn&#45;&#45;instagram" shareMode='prd' shareContentId="<?php echo $TPL_VAR["id"]?>" shareTypeText="상품" devsnsshare="instagram">인스타그램</button>-->
                        <!--</li>-->
                        <!--@TODO 카카오톡, 페이스북, 트위터, url 기획 확정-->
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <li class="layer-share__box">
                            <button class="layer-share__btn layer-share__btn--kakaotalk" shareMode='prd' shareContentId="<?php echo $TPL_VAR["id"]?>" shareTypeText="상품" devsnsshare="kakaotalk">Kakao Talk</button>
                        </li>
<?php }?>
                        <li class="layer-share__box">
                            <button class="layer-share__btn layer-share__btn--facebook" shareMode='prd' shareContentId="<?php echo $TPL_VAR["id"]?>" shareTypeText="상품" devsnsshare="facebook">Facebook</button>
                        </li>
                        <!--<li class="layer-share__box">-->
                            <!--<button class="layer-share__btn layer-share__btn&#45;&#45;blog" shareMode='prd' shareContentId="<?php echo $TPL_VAR["id"]?>" shareTypeText="상품" devsnsshare="naver">naver</button>-->
                        <!--</li>-->
                        <li class="layer-share__box">
                            <button class="layer-share__btn layer-share__btn--twitter" shareMode='prd' shareContentId="<?php echo $TPL_VAR["id"]?>" shareTypeText="상품" devsnsshare="twitter">Twiter</button>
                        </li>
                        <li class="layer-share__box">
                            <button class="layer-share__btn layer-share__btn--url" value="<?php echo $TPL_VAR["snsShareUrl"]?>" devsnsshare="url-copy">Copy URL</button>
                        </li>
                    </ul>
                </div>
            </div>
            <h4 class="goods-info__title"><?php echo $TPL_VAR["pname"]?></h4><!-- 줄바꿈 방식 확인 필요 -->
            <div class="goods-info__price">
                <h4 class="br__hidden">Price</h4>
<?php if($TPL_VAR["discount_rate"]> 0){?><span class="goods-info__price__strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span><?php }?>
                <span class="goods-info__price__result"><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?> <button class="goods-info__benefit-list">혜택내역 +</button></span>
<?php if($TPL_VAR["discount_rate"]> 0){?><span class="goods-info__price__discount"><span><?php echo $TPL_VAR["discount_rate"]?></span>%</span><?php }?>
            </div>
<?php if($TPL_VAR["couponApplyCnt"]> 0){?>
            <div class="goods-info__coupon">
                <button class="goods-info__coupon__btn" id="devCouponDown" data-pid="<?php echo $TPL_VAR["pid"]?>">Discount coupon download</button>
            </div>
<?php }?>
            <!-- 혜택내역 layer content -->
            <div class="layer__benefit-list">
                <dl class="benefit-list__price">
                    <dt>Order value</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["listprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="benefit-list__type">
                    <dt>Discount</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php if($TPL_VAR["directDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["directDiscountPrice"])?><?php }else{?>0<?php }?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    <dt>Planning discount</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php if($TPL_VAR["planDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["planDiscountPrice"])?><?php }else{?>0<?php }?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    <dt>Additional discount</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php if($TPL_VAR["addDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["addDiscountPrice"])?><?php }else{?>0<?php }?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    <dt>Coupon discount</dt>
                    <dd>- <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php if($TPL_VAR["couponDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["couponDiscountPrice"])?><?php }else{?>0<?php }?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                    <dt>Membership discount</dt>
                    <dd>-<?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php if($TPL_VAR["groupDiscountPrice"]> 0){?><?php echo g_price($TPL_VAR["groupDiscountPrice"])?><?php }else{?>0<?php }?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
                <dl class="benefit-list__total">
                    <dt>Savings total</dt>
                    <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_VAR["couponApplyPrice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                </dl>
            </div>
        </div>
    </section>
    <!-- [E] 상품기본정보 -->

    <section class="br__goods-view__option">
        <div class="goods-info" style="padding:0;">
<?php if($TPL_VAR["product_type"]== 0&&$TPL_VAR["add_info"]!=''){?>
            <div class="goods-info__color">
                <h4 class="goods-info__color__title">Color <span><?php echo $TPL_VAR["add_info"]?></span></h4>
<?php if($TPL_VAR["sameProduct"]){?>
                <ul class="goods-info__color__list">
<?php if($TPL_sameProduct_1){foreach($TPL_VAR["sameProduct"] as $TPL_V1){?>
                    <li class="goods-info__color__box">
                        <a href="/shop/goodsView/<?php echo $TPL_V1["pid"]?>" class="goods-info__color__link <?php if($TPL_VAR["pid"]==$TPL_V1["pid"]){?>goods-info__color__link--active<?php }?>">
                            <img src="<?php echo $TPL_V1["filterImg"]?>" alt="색상명">
                        </a>
                    </li>
<?php }}?>
                </ul>
<?php }?>
            </div>
<?php }?>

    <!-- [S] 상품옵션 -->
    <section class="br__goods-view__option">
<?php if($TPL_VAR["product_type"]== 99){?>
        <!--<h3 class="goods-set__title">Option for Set product</h3>-->
<?php }else{?>
        <!--<h3 class="goods-set__title">Select options</h3>-->
<?php }?>
        <div class="goods-info" id="devSildeMinicartArea" data-pid="<?php echo $TPL_VAR["pid"]?>">
            <div class="devForbizTpl" id="devSildeLonelyOption">
                <span id="devSildeLonelyOptionName">
                    <p>{[option_name]}</p>
                </span>
            </div>


<?php if($TPL_VAR["product_type"]== 99){?>
            <div id="devSildeMinicartOptions" style="padding:0 1.5rem; border-top: 1px solid #f0f0f0;"></div>
<?php }else{?>
            <div id="devSildeMinicartOptions" style="padding:0 1.5rem;"></div>
<?php }?>



            <!-- cre.ma / 통합 요약 위젯 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
            <style>
                .crema-fit-product-combined-summary { margin: 20px 0; }
                .crema-fit-product-combined-summary > iframe { max-width: 100% !important; }
                .ig_gap {    position: relative;    padding: 1.1rem 0;    line-height: 2.7rem;}
            </style>
            <div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" class="crema-fit-product-combined-summary" style="display:none;"></div>
<?php if(count($TPL_VAR["product_gift"])== 0&&$TPL_VAR["gift_selectbox_cnt"]> 1&&count($TPL_VAR["ig_addOptions"])== 0){?>
                    <div class="ig_gap"></div>
<?php }else{?>

<?php }?>



            <!--사은품-->
<?php if($TPL_VAR["product_gift"]&&$TPL_VAR["gift_selectbox_cnt"]> 0){?>
            <div class="goods-info__set">
                <h4 class="goods-info__set__title">Free Gift Select</h4>

                <ul class="goods-info__set__list">
<?php if($TPL_product_gift_1){$TPL_I1=-1;foreach($TPL_VAR["product_gift"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1<$TPL_VAR["gift_selectbox_cnt"]){?>
                    <li class="goods-info__set__box">
                        <select class="devProductGift_<?php echo $TPL_I1?>" data-idx="<?php echo $TPL_I1?>">
                            <option value="">Please select</option>
<?php if(is_array($TPL_R2=$TPL_V1["product_gift_detail"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                            <option value="<?php echo $TPL_V2["pid"]?>" <?php if($TPL_V2["status"]=='soldout'){?>disabled<?php }?>><?php echo $TPL_V2["pname"]?> <?php if($TPL_V2["status"]=='soldout'){?>[Out of stock]<?php }?></option>
<?php }}?>
                        </select>
                    </li>
<?php }?>
<?php }}?>
                </ul>

            </div>
<?php }?>



            <div id="devSlideMinicartAddOption" class="hidden goods-option--add">
                <h3 class="goods-option__title">Option Product</h3>
            </div>

            <div class="goods-cart__wrap">
                <ul id="devSildeMinicartSelected" class="goods-cart">
                    <li class="goods-cart__box devOptionBox devForbizTpl" devOptionKind="{[option_kind]}" devOptid="{[option_id]}" devUnit="{[option_dcprice]}" devStock="{[option_stock]}">
                        <p class="goods-cart__tit">{[option_prefix]}{[pname]}</p>
                        <p class="goods-cart__sub">{[add_info_text]}</p>
                        <p class="goods-cart__sub">{[option_div_text]}</p>
                        <div class="control">
                            <ul class="option-up-down devControlCntBox"> <!-- option-up-down 클래스 삭제 -->
                                <li class="devCntMinus">
                                    <button class=" down">
                                        -
                                    </button>
                                </li>
                                <li class="detail__aside__option-btns--count">
                                    <input type="text" value="{[allowBasicCnt]}" class="devMinicartPrdCnt">
                                </li>
                                <li class="devCntPlus">
                                    <button class=" up">
                                        +
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <!--<div class="option__right">-->
                        <!-- <div class="ig_div1"> -->
                            <button class="btn-option-del2 devSildeMinicartDelete"></button>
                            <div class="price">
                                <?php echo $TPL_VAR["fbUnit"]["f"]?>

                                <em class="devMinicartEachPrice">{[eachPrice]}</em>
                                <?php echo $TPL_VAR["fbUnit"]["b"]?>

                            </div>
                        <!-- </div> -->
                        <!--</div>-->
                    </li></ul>
            </div>
            
            <style>
                .crema-type .br .goods-view__btn__set {margin:0 1.5rem; padding:3rem 0 4rem; position:relative;}
                .crema-type .br .goods-view__btn__set .goods-view__total {background:#fff; padding-bottom:1.5rem; position:relative; text-align:right;}
                .crema-type .br .goods-view__btn__set .goods-view__total__text {font-size:1.2rem; line-height:2rem; margin-right:0.5rem;color:#666;}
                .crema-type .br .goods-view__btn__set .goods-view__total__price {color:#000; font-size:1.2rem; line-height:2rem;}
                .crema-type .br .goods-view__btn__set .goods-view__total__price span {color:#00bce7; font-size:2rem; line-height:3rem; font-weight:600; vertical-align:-0.1rem;}
                .crema-type .br .goods-view__btn__set .goods-btn__buy {width:100%; background:#000; color:#fff; font-size:1.3rem; font-weight:600; line-height:4.5rem; margin-bottom:1rem; text-align:center;}
                .crema-type .br .goods-view__btn__set .goods-btn {overflow:hidden;}
                .crema-type .br .goods-view__btn__set .goods-btn li {width:50%; float:left;}
                .crema-type .br .goods-view__btn__set .goods-btn li.col_l {padding-right:0.5rem;}
                .crema-type .br .goods-view__btn__set .goods-btn li.col_r {padding-left:0.5rem;}
                .crema-type .br .goods-view__btn__set .goods-btn .goods-btn__store {width:100%; background:#fff; border:#000 1px solid; color:#000; font-size:1.3rem; font-weight:600; line-height:4rem; text-align:center;}
                .crema-type .br .goods-view__btn__set .goods-btn .goods-btn__cart {width:100%; background:#e6e6e6; border:#e6e6e6 1px solid; color:#000; font-size:1.3rem; font-weight:600; line-height:4rem; text-align:center;}
                .crema-type .br .goods-view__btn__set .goods-btn__sold-out {width:100%; background:#7c7c7c; border:#7c7c7c 1px solid; color:#fff; font-size:1.3rem; font-weight:600; line-height:4rem; margin-bottom:1rem; text-align:center;}
            </style>
            <div class="goods-view__btn__set">
                <div class="goods-view__total">
                    <span class="goods-view__total__text">총 상품 금액</span>
                    <span class="goods-view__total__price"><span></span><span id="devMinicartTotal_ig">0</span>원</span>
                </div>


<?php if($TPL_VAR["status"]=='sale'){?>
                <button type="button" class="goods-btn__buy devOrderDirect_ig ">BUY NOW</button>
<?php }elseif($TPL_VAR["status"]=='ready'){?>
                <button type="button" class="goods-btn__sold-out devOrderDirect" disabled>For Sale</button>
<?php }elseif($TPL_VAR["status"]=='end'){?>
                <button type="button" class="goods-btn__sold-out devOrderDirect" disabled>Sales End</button>
<?php }else{?>
                <button type="button" class="goods-btn__sold-out devOrderDirect" disabled>Out of stock</button>
<?php }?>

                <ul class="goods-btn">
<?php if($TPL_VAR["status"]=='sale'){?>
                        <li class="col_l"><button type="button" class="goods-btn__store" id="storeGuide_ig" data-id="<?php echo $TPL_VAR["id"]?>" data-type="<?php echo $TPL_VAR["product_type"]?>">Membership Guide</button></li>                    
<?php }elseif($TPL_VAR["status"]=='ready'){?>
                        <button type="button" class="goods-btn__store" id="storeGuide_ig" data-id="<?php echo $TPL_VAR["id"]?>" data-type="<?php echo $TPL_VAR["product_type"]?>">Membership Guide</button>
<?php }elseif($TPL_VAR["status"]=='end'){?>
                        <button type="button" class="goods-btn__store" id="storeGuide_ig" data-id="<?php echo $TPL_VAR["id"]?>" data-type="<?php echo $TPL_VAR["product_type"]?>">Membership Guide</button>
<?php }else{?>
                        <button type="button" class="goods-btn__store" id="storeGuide_ig" data-id="<?php echo $TPL_VAR["id"]?>" data-type="<?php echo $TPL_VAR["product_type"]?>">Membership Guide</button>
<?php }?>

<?php if($TPL_VAR["status"]=='sale'){?>
                    <li class="col_r"><button type="button" class="goods-btn__cart devAddCart_ig devAddCart__layerBtn">Cart</button></li>
<?php }?>

                </ul>
            </div>
        </div>
        <!-- 크리마핏 사이즈 영역 -->
<?php if($TPL_VAR["langType"]=='korean'){?>
        <!-- 사이즈 선택 도우미 버튼 -->

            <!--
                기존 요약 위젯(crema-fit-product-size-summary)은 제거
            <div class="br__goods-view__crema">
                <div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-mvp="1" class="crema-fit-product-size-summary"></div>
            </div>
            -->
<?php }?>
    </section>
    <!-- [E] 상품옵션 -->





            <div class="goods-info__other">
<?php if($TPL_VAR["is_use_reserve"]){?>
                <dl class="goods-info__other__list">
                    <dt>Reward</dt>
                    <dd>Expected reward <span class="goods-info__other__list--point"><em><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["save_reserve"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span><br>(Reserves may be different at checkout.)</dd>
                </dl>
<?php }?>
                <dl class="goods-info__other__list">
                    <dt>Shipping Information</dt>
                    <dd>
<?php if($TPL_VAR["delivery"]["deliveryPolicy"]== 1){?> <!-- 무료배송 -->
                        <?php echo $TPL_VAR["delivery"]["text"]?>

<?php }elseif($TPL_VAR["delivery"]["deliveryPolicy"]== 2){?> <!-- 고정배송비 -->
                        <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["delivery"]["sumPrice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?>

<?php }else{?> <!-- 조건배송비 -->
                        <!-- #5650 고객사요구로 삭제
                        <?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_VAR["delivery"]["sumPrice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?>

                        <?php echo $TPL_VAR["delivery"]["deliveryComName"]?>

                        -->
                        <?php echo $TPL_VAR["delivery"]["text"]?>

                        <br>(Overseas shipping fee will be charged)
<?php }?>
                        <br>
                    </dd>
                </dl>
            </div>

<?php if($TPL_VAR["langType"]=='korean'){?>
            <div class="goods-info__review">
                <span class="goods-info__review__title">Reviews</span>
                <span class="goods-info__review__star">
                    <span class="goods-info__review__star--point">
                        <span data-widths="<?php echo $TPL_VAR["total_review_star_per"]?>" style="width:8rem;"></span>
                    </span>
                    <span class="goods-info__review__star--number"> <?php echo $TPL_VAR["total_review_star"]?> </span>
                </span>
                <button type="button" class="goods-info__review__btn" >To see review</button>
            </div>
<?php }else{?>
<?php }?>

<?php if($TPL_VAR["colorChipList"]){?>
            <div class="goods-info__color">
<?php if($TPL_colorChipList_1){foreach($TPL_VAR["colorChipList"] as $TPL_K1=>$TPL_V1){?>
                <h4 class="goods-info__color__title">
<?php if($TPL_K1=='1'&&!empty($TPL_VAR["relation_text1"])){?><?php echo $TPL_VAR["relation_text1"]?><?php }?><?php if($TPL_K1=='2'&&!empty($TPL_VAR["relation_text2"])){?><?php echo $TPL_VAR["relation_text2"]?><?php }?>
                </h4>
                <ul class="goods-info__color__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <li class="goods-info__color__box">
                        <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>" class="goods-info__color__link <?php if($TPL_VAR["pid"]==$TPL_V2["pid"]){?>goods-info__color__link--active<?php }?>">
                            <img src="<?php echo $TPL_V2["filterImg"]?>" alt="색상명">
                        </a>
                    </li>
<?php }}?>
                </ul>
<?php }}?>
            </div>
<?php }?>
        </div>

    </section>

<?php if($TPL_VAR["langType"]=='korean'){?>
    <!-- [S] 포토후기 -->
    <!-- <section class="br__goods-view__photo">
        <div class="goods-photo">
            <h3 class="goods-photo__title">Photo reviews</h3>
            <p class="goods-photo__sub">Check out our customer real photo reviews.</p>
            <div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="25" class="crema-product-reviews"></div>
        </div>
    </section> -->
    <!-- [E] 포토후기 -->
<?php }?>

    <!-- [S] 다른 고객님이 함께 구매한 상품, 비슷한 상품 -->
<?php if($TPL_VAR["togeterProduct"]){?>
    <section class="br__goods-view__recommend">
        <div class="goods-recom">
            <h3 class="goods-recom__title">Items purchased by other customers</h3>
            <div class="goods-recom__wrap">
                <ul class="goods-recom__list">
<?php if($TPL_togeterProduct_1){foreach($TPL_VAR["togeterProduct"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='stop'){?>
                    <li class="goods-recom__box">
                        <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="goods-recom__link">
                            <figure class="goods-recom__thumb">
                                <img src="<?php echo $TPL_V1["image_src"]?>" alt="nonono">
                            </figure>
                            <div class="goods-recom__info">
                                <span class="goods-recom__info__title"><?php echo $TPL_V1["pname"]?></span>
                                <span class="goods-recom__info__color"><?php echo $TPL_V1["add_info"]?></span>
                                <span class="goods-recom__info__price">
<?php if($TPL_VAR["langType"]=='korean'){?>
<?php if($TPL_V1["isDiscount"]){?>
                                        <span class="goods-recom__info__strike">
                                            <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                        </span>
<?php }?>
                                        <span class="goods-recom__info__result">
                                            <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V1["dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?>

                                        </span>
                                        <span class="goods-recom__info__discount">
<?php if($TPL_V1["is_soldout"]){?>
                                            Out of stock
<?php }else{?>
<?php if($TPL_V1["isDiscount"]){?>
                                            <?php echo $TPL_V1["discount_rate"]?>%
<?php }?>
<?php }?>
                                        </span>
<?php }else{?>
<?php if($TPL_V1["is_soldout"]){?>
                                            <span class="goods-recom__info__discount">
                                                Out of stock
                                            </span>
<?php }else{?>
<?php if($TPL_V1["isDiscount"]){?>
                                            <span class="goods-recom__info__strike">
                                                <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                            </span>
<?php }?>
                                            <span class="goods-recom__info__result">
                                                <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo $TPL_V1["dcprice"]?></span><?php echo $TPL_VAR["fbUnit"]["b"]?>

                                            </span>
                                            <span class="goods-recom__info__discount">
<?php if($TPL_V1["isDiscount"]){?>
                                                <?php echo $TPL_V1["discount_rate"]?>%
<?php }?>
                                            </span>
<?php }?>
<?php }?>
                                </span>
                            </div>
                        </a>
                    </li>
<?php }?>
<?php }}?>
                </ul>
            </div>
        </div>
    </section>
<?php }?>
<?php if($TPL_VAR["similraProduct"]){?>
    <section class="br__goods-view__recommend">
        <div class="goods-recom">
            <h3 class="goods-recom__title">Similar items</h3>
            <div class="goods-recom__wrap">
                <ul class="goods-recom__list">
<?php if($TPL_similraProduct_1){foreach($TPL_VAR["similraProduct"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='stop'){?>
                    <li class="goods-recom__box">
                        <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>" class="goods-recom__link">
                            <figure class="goods-recom__thumb">
                                <img src="<?php echo $TPL_V1["image_src"]?>" alt="">
                            </figure>
                            <div class="goods-recom__info">
                                <span class="goods-recom__info__title"><?php echo $TPL_V1["pname"]?></span>
                                <span class="goods-recom__info__color"><?php echo $TPL_V1["add_info"]?></span>
                                <span class="goods-recom__info__price">
<?php if($TPL_VAR["langType"]=='korean'){?>
<?php if($TPL_V1["isDiscount"]){?>
                                        <span class="goods-recom__info__strike">
                                            <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                        </span>
<?php }?>
                                        <span class="goods-recom__info__result">
                                            <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V1["dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?>

                                        </span>
                                        <span class="goods-recom__info__discount">
<?php if($TPL_V1["is_soldout"]){?>
                                            Out of stock
<?php }else{?>
<?php if($TPL_V1["isDiscount"]){?>
                                            <?php echo $TPL_V1["discount_rate"]?>%
<?php }?>
<?php }?>
                                        </span>
<?php }else{?>
<?php if($TPL_V1["is_soldout"]){?>
                                            <span class="goods-recom__info__discount">
                                                Out of stock
                                            </span>
<?php }else{?>
<?php if($TPL_V1["isDiscount"]){?>
                                            <span class="goods-recom__info__strike">
                                                <span><?php echo $TPL_VAR["fbUnit"]["f"]?><?php echo g_price($TPL_V1["listprice"])?><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                            </span>
<?php }?>
                                            <span class="goods-recom__info__result">
                                                <?php echo $TPL_VAR["fbUnit"]["f"]?><span><?php echo g_price($TPL_V1["dcprice"])?></span><?php echo $TPL_VAR["fbUnit"]["b"]?>

                                            </span>
                                            <span class="goods-recom__info__discount">
<?php if($TPL_V1["isDiscount"]){?>
                                                <?php echo $TPL_V1["discount_rate"]?>%
<?php }?>
                                            </span>
<?php }?>
<?php }?>
                                </span>
                            </div>
                        </a>
                    </li>
<?php }?>
<?php }}?>
                </ul>
            </div>
        </div>
    </section>
<?php }?>
    <!-- [E] 다른 고객님이 함께 구매한 상품, 비슷한 상품 -->



    <!-- [S] 이벤트 배너 -->
<?php if($TPL_VAR["eventBannerInfo"]){?>

    <section class="br__goods-view__event">
        <h3 class="br__hidden">Event Banner</h3>
        <div class="goods-event">
            <div class="br__slide br__slide--type2">

                    <ul class="">
<?php if($TPL_eventBannerInfo_1){foreach($TPL_VAR["eventBannerInfo"] as $TPL_V1){?>
                        <li class="ig_li_bn">
                            <div class="">
                                <a class="slide-content__link" href="<?php echo $TPL_V1["bannerLink"]?>">
                                    <figure class="slide-content__thumb">
                                        <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["bd_title"]?>">
                                    </figure>
                                </a>
                            </div>
                        </li>
<?php }}?>
                    </ul>

     
            </div>
        </div>
    </section>


    <!--section class="br__goods-view__event">
        <h3 class="br__hidden">Event Banner</h3>
        <div class="goods-event">
            <div class="br__slide br__slide--type2">
                <div class="swiper-container">
                    <ul class="swiper-wrapper">
<?php if($TPL_eventBannerInfo_1){foreach($TPL_VAR["eventBannerInfo"] as $TPL_V1){?>
                        <li class="swiper-slide">
                            <div class="slide-content">
                                <a class="slide-content__link" href="<?php echo $TPL_V1["bannerLink"]?>">
                                    <figure class="slide-content__thumb">
                                        <img src="<?php echo $TPL_V1["imgSrc"]?>" alt="<?php echo $TPL_V1["bd_title"]?>">
                                    </figure>
                                </a>
                            </div>
                        </li>
<?php }}?>
                    </ul>
                    <div class="slide-controller">
                        <div class="slide-controller__page">
                            <div class="slide-controller__page__wrap">
                                <span class="slide-controller__page__current">1</span>
                                <span class="slide-controller__page__slash">/</span>
                                <span class="slide-controller__page__total">1</span>
                            </div>
                            <button type="button" class="slide-controller__page__all-view">viewl all button</button>
                        </div>
                        <div class="slide-controller__player">
                            <button class="slide-controller__player__btn">Play/Pause button</button>
                        </div>
                    </div>
                </div>
                <div class="slide-layer">
                    <h4 class="slide-layer__title">All</h4>
                    <ul class="slide-layer__content">
                    </ul>
                    <button class="slide-layer__close">close view all</button>
                </div>
            </div>
        </div>
    </section-->

<?php }?>
    <!-- [E] 이벤트 배너 -->

    <!-- [S] 탭 영역 -->
    <style>
        .crema-type .br__goods-view__tabs .goods-tabs__btn {display:inline-block; font-size:1.1rem; padding-top:0.5rem;}
        .crema-type .br__goods-view__tabs .goods-tabs__btn2 {padding-top:1.2rem;}
        .crema-type .br__goods-view__tabs .goods-tabs__btn--active {
            background: #000;
            color: #fff;
        }

     
    </style>

    <link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://kenwheeler.github.io/slick/slick/slick-theme.css"/>
    
    <style>
        .crema-type .br__goods-view__tabs .goods-tabs__box {width:100px !important; height:70px !important; display:inline-block !important; position:relative;}
        .crema-type .br__goods-view__tabs .goods-tabs__box:after {width:1px; height:24px; background-color:#dedede; content:''; display:block; position:absolute; right:0; top:11px;}
        .crema-type .br__goods-view__tabs .goods-tabs__box:last-child:after {display:none;}
        .crema-type .br__goods-view__tabs .goods-tabs__list li.goods-tabs__box:last-child {width:130px !important; padding-right:50px;}

        .crema-type .br__goods-view__tabs .goods-tabs__btn--active {z-index:1;}
    </style>

    <section class="br__goods-view__tabs">
        <h3 class="br__hidden">(english)상품 상세 및 후기, 문의, 반품</h3>
        <div class="goods-tabs">
            <ul class="goods-tabs__list">
<?php if($TPL_VAR["langType"]=='korean'){?>
                <li class="goods-tabs__box">
                    <a href="#goods-review" class="goods-tabs__btn goods-tabs__btn2 devReviewDetailTabs" data-content="devTabReview">Reviews<em>(<?php echo $TPL_VAR["total_review_cnt"]?>)</em></a>
                    <!--<a href="#goods-review" class="goods-tabs__btn devDetailTabs devReviewDetailTabs" data-content="devTabReview">Reviews(<?php echo $TPL_VAR["allReviewTotal"]?>)</a>-->
                </li>
<?php }else{?>
<?php }?>

                <li class="goods-tabs__box">
                    <a href="#goods-detail" class="goods-tabs__btn goods-tabs__btn2">Product Information</a>
                </li>

<?php if($TPL_VAR["langType"]=='korean'){?>
				<li class="goods-tabs__box">
                    <a href="#goods-fit" class="goods-tabs__btn goods-tabs__btn2">사이즈 추천</a>
                </li>

                <li class="goods-tabs__box">
                    <a href="#washing-ins" class="goods-tabs__btn goods-tabs__btn2">Washing & Care</a>
                </li>

                <li class="goods-tabs__box">
                    <a href="#goods-return" class="goods-tabs__btn goods-tabs__btn2">반품/환불/수선</a>
                </li>
<?php }else{?>
				<li class="goods-tabs__box">
                    <a href="#goods-fit" class="goods-tabs__btn goods-tabs__btn2">Size Guide</a>
                </li>

                <li class="goods-tabs__box">
                    <a href="#washing-ins" class="goods-tabs__btn goods-tabs__btn2">Washing&Care</a>
                </li>

                <li class="goods-tabs__box">
                    <a href="#goods-return" class="goods-tabs__btn goods-tabs__btn2">Returns/Refunds</a>
                </li>
<?php }?>

                <li class="goods-tabs__box">
                    <a href="#goods-qna" class="goods-tabs__btn goods-tabs__btn2" data-content="devTabInquiry">Q&amp;A<em>(<?php echo number_format($TPL_VAR["qnaTotal"])?>)</em></a>
                </li>
                <!-- <li class="goods-tabs__box">
                    <a href="#goods-notice" class="goods-tabs__btn">Returns / Refunds</a>
                </li> -->
            </ul>
        </div>

        <script type="text/javascript">
            $(document).ready(function(){
                $('.goods-tabs__list').slick({
                    dots: false,
                    infinite: false,
                    speed: 500,
                    slidesToShow: 4,
                    slidesToScroll: 2,
                    rows: 1,
                    //swipeToSlide: true,
                    centerMode: false,
                    mobileFirst: true,
                    variableWidth: true
                });
            });
        </script>

        <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="https://kenwheeler.github.io/slick/slick/slick.js"></script>


        <section class="goods-tabs__cont goods-review">
<?php if($TPL_VAR["reviewBanner"]){?>
			<div  class="goods-review__event">
				<a href="<?php echo $TPL_VAR["reviewBanner"]["bannerLink"]?>"><img src="<?php echo $TPL_VAR["reviewBanner"]["imgSrc"]?>" alt=""></a>
			</div>
<?php }?>
			

            <a id="goods-review" class="br__hidden--anchor">Reviews<br><em><?php echo $TPL_VAR["total_review_cnt"]?></em></a>

<?php if($TPL_VAR["langType"]=='korean'){?>
                    <div class="goods-review__crema">
                        <!-- 소셜 위젯 -->
                        <style>.crema-product-reviews > iframe { max-width: 100% !important; }</style>
                        <!--<div class="crema-product-reviews" data-widget-id="23" data-product-code="<?php echo (int) $TPL_VAR["id"];?>"></div>-->

                        <!--<div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="25" class="crema-product-reviews"></div>-->
                        <!-- 크리마 리뷰 서비스 영역 -->
                        <!-- cre.ma / 상품 리뷰 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->                
                        <div class="crema-product-reviews" data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="17"></div>
                    </div>



                    <div class="goods-review__crema">
                        <!-- 소셜 위젯 -->
                        <style>.crema-product-reviews > iframe { max-width: 100% !important; }</style>
                        <div class="crema-product-reviews" data-widget-id="23" data-product-code="<?php echo (int) $TPL_VAR["id"];?>"></div>

                        <!--<div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="25" class="crema-product-reviews"></div>-->
                        <!-- 크리마 리뷰 서비스 영역 -->
                        <!-- cre.ma / 상품 리뷰 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->                
                        <!--<div class="crema-product-reviews" data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="17"></div>-->
                    </div>




<?php }else{?>
<?php if($TPL_VAR["mandatory_use_global"]=='Y'){?>
                    <div class="goods-review__crema">
                        <!-- 소셜 위젯 -->
                        <style>.crema-product-reviews > iframe { max-width: 100% !important; }</style>
                        <div class="crema-product-reviews" data-widget-id="23" data-product-code="<?php echo (int) $TPL_VAR["id"];?>"></div>

                        <!--<div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="25" class="crema-product-reviews"></div>-->
                        <!-- 크리마 리뷰 서비스 영역 -->
                        <!-- cre.ma / 상품 리뷰 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->                
                        <div class="crema-product-reviews" data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="17"></div>
                    </div>


<?php }?>
<?php }?>


        </section>
        <section class="goods-tabs__cont goods-detail">
            <a id="goods-detail" class="br__hidden--anchor">Product detail information tab</a>


<?php if($TPL_VAR["productGiftInfo"]){?>
            <div class="goods-detail__acco">
                <button type="button" class="goods-detail__acco__btn">Free gift Information</button>
                <div class="goods-detail__acco__cont">
                    <div class="gift-cont">
<?php if($TPL_productGiftInfo_1){foreach($TPL_VAR["productGiftInfo"] as $TPL_V1){?>
<?php if($TPL_V1["status"]!='soldout'){?>
                        <figure class="gift-cont__thumb">
                            <img src="<?php echo $TPL_V1["image_src"]?>" alt="<?php echo $TPL_V1["pname"]?>">
                        </figure>
                        <div class="gift-cont__info">
                            <p class="gift-cont__info__title"><?php echo $TPL_V1["pname"]?></p>
                            <p class="gift-cont__info__date">Event Period : <?php echo $TPL_V1["sell_priod_sdate"]?> ~ <?php echo $TPL_V1["sell_priod_edate"]?></p>
                            <p class="gift-cont__info__price"><span><?php echo $TPL_V1["add_info"]?></span>worth of $</p>
                        </div>
<?php }?>
<?php }}?>
                        <div class="gift-cont__notice">
                            <p class="gift-cont__notice__desc">If you do not return the item for exchange or refund, please note that cancellation is not possible.</p>
                        </div>
                    </div>
                </div>
            </div>
<?php }?>






<?php if($TPL_VAR["sellerNotice"]){?>
            <div>
                <p style="text-align:center;"><img src="<?php echo $TPL_VAR["sellerNotice"]?>"></p>
            </div>
<?php }?>
            <div class="goods-detail__view"  id="goods-detail">
                <?php echo $TPL_VAR["basicinfo"]?>

            </div>
        </section>



<?php if($TPL_VAR["langType"]=='korean'){?>
    <!-- [S] 크리마 핏 가이드 -->
    <section class="goods-tabs__cont br__goods-view__crema">
        <a id="goods-fit" class="br__hidden--anchor">Crima Fit guide</a>
        <!-- <h3 class="br__hidden">Crima Fit guide</h3> -->
        <div class="goods-crema">
        <style>.crema-fit-product-combined-detail > iframe { max-width: 100% !important; }</style>
            <!--<div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-mvp="1" class="crema-fit-product-size-detail"></div>-->
            <div data-product-code="<?php echo (int) $TPL_VAR["id"];?>" data-widget-id="25" class="crema-fit-product-combined-detail"></div>
        </div>
    </section>
    <!-- [E] 크리마 핏 가이드 -->
<?php }?>

    <!-- [S] 세탁주의사항 -->
    <section class="goods-tabs__cont br__goods-view__crema">
<?php if($TPL_VAR["langType"]=='korean'){?>
        <a id="washing-ins" class="br__hidden--anchor">Washing & Care</a>
<?php }else{?>
		<a id="washing-ins" class="br__hidden--anchor">Washing&Care</a>
<?php }?>
        <div class="goods-crema" style="padding:10px 0 30px;">
            <style>
				.wash_select {text-align:center;}
				.wash_select select {width:100%; height:40px !important; border:#222 1px solid; color:#000 !important; font-size:1.4rem !important; font-weight:700; text-align: center; text-align:-moz-center; text-align:-webkit-center; text-align-last: center; -ms-text-align-last: center; -moz-text-align-last: center;}
				.wash_sub_txt {color:#000; font-size:12px !important; padding:10px 0 25px; text-align:center;}

				.contents__box-detail--show li.contents__list:last-child {border-bottom:#000 1px solid !important;}

				.crema-type .br .wash__contents .contents__list {padding:1.9rem 0 1.9rem 1.313rem;}
				.crema-type .br .wash__contents .contents__subtitle {font-size:1.4rem !important; display:block !important;}
				.crema-type .br .wash__contents .contents__summary {padding:0.9rem 0.9rem 0 0 !important;}


			</style>

			<div class="wash"  id="laundryInfo">
				<div class="wash_select">
					<select name="laundryOneDepth" onchange="laundryChange(this.value)">
<?php if($TPL_laundryOneDepth_1){foreach($TPL_VAR["laundryOneDepth"] as $TPL_V1){?>
<?php if($TPL_VAR["langType"]=='english'){?>
								<option value="<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryCid"]==$TPL_V1["cid"]){?>selected<?php }?>><?php echo $TPL_V1["title_en"]?></option>
<?php }else{?>
								<option value="<?php echo $TPL_V1["cid"]?>" <?php if($TPL_VAR["laundryCid"]==$TPL_V1["cid"]){?>selected<?php }?>><?php echo $TPL_V1["title"]?></option>
<?php }?>
<?php }}?>
					</select>
<?php if($TPL_VAR["langType"]=='korean'){?>
					<p class="wash_sub_txt">카테고리를 선택해 주세요.</p>
<?php }else{?>
					<p class="wash_sub_txt">Please select a category.</p>
<?php }?>
				</div>

				<nav class="wash__category">
<?php if($TPL_laundry_1){foreach($TPL_VAR["laundry"] as $TPL_V1){?>
						<a href="javascrip:void(0);" data-target="<?php echo $TPL_V1["cid"]?>" class="wash__category-link<?php if($TPL_VAR["laundryTwoFirst"]==$TPL_V1["cid"]){?> wash__category-link--active<?php }?>">
<?php if($TPL_VAR["langType"]=='english'){?>
								<?php echo $TPL_V1["title_en"]?>

<?php }else{?>
								<?php echo $TPL_V1["title"]?>

<?php }?>
						</a>
<?php }}?>
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
								<nav class="contents__tab">
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V1["firstCid"]==$TPL_V2["cid"]){?>
											<a href="javascript:void(0);" data-target="wash" class="contents__tab-link contents__tab-link--active">
<?php }else{?>
											<a href="javascript:void(0);" data-target="precaution" class="contents__tab-link">
<?php }?>
<?php if($TPL_VAR["langType"]=='english'){?>
											<?php echo $TPL_V2["title_en"]?>

<?php }else{?>
											<?php echo $TPL_V2["title"]?>

<?php }?>
										</a>
<?php }}?>
								</nav>

								<div class="contents__box">
<?php if(is_array($TPL_R2=$TPL_V1["three"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V1["firstCid"]==$TPL_V2["cid"]){?>
											<ul class="contents__box-wash contents__box-detail contents__box-detail--show">
<?php }else{?>
											<ul class="contents__box-precaution contents__box-detail">
<?php }?>
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
										</ul>
<?php }}?>
								</div>
							</div>
						</section>
<?php }}?>
				</div>
			</div>
        </div>
    </section>
    <!-- [E] 세탁주의사항 -->

<?php if($TPL_VAR["langType"]=='korean'){?>
    <!-- [S] 반품/환불/수선 -->
    <section class="goods-tabs__cont br__goods-view__crema">
        <a id="goods-return" class="br__hidden--anchor">반품/환불/수선</a>
        <h4 class="goods-review__title">반품/환불/수선</h4>
        <section class="goods-tabs__cont goods-detail">
<?php if($TPL_VAR["langType"]=='korean'){?>
				<div class="goods-detail__acco">
					<button type="button" class="goods-detail__acco__btn">Product information announcement</button>

					<div class="goods-detail__acco__cont">
<?php if($TPL_mandatoryInfos_1){foreach($TPL_VAR["mandatoryInfos"] as $TPL_V1){?>
						<dl class="goods-announce">
							<dt class="goods-announce__title"><?php echo $TPL_V1["pmi_title"]?></dt>
							<dd class="goods-announce__info"><?php echo $TPL_V1["pmi_desc"]?></dd>
						</dl>
<?php }}?>
						<dl class="goods-announce">
							<dt class="goods-announce__title">상품코드</dt>
							<dd class="goods-announce__info"><?php echo $TPL_VAR["pcode"]?></dd>
						</dl>
					</div>
				</div>
<?php }else{?>
<?php if($TPL_VAR["mandatory_use_global"]=='Y'){?>
					<div class="goods-detail__acco">
						<button type="button" class="goods-detail__acco__btn">Product information announcement</button>

						<div class="goods-detail__acco__cont">
<?php if($TPL_mandatoryInfosGlobal_1){foreach($TPL_VAR["mandatoryInfosGlobal"] as $TPL_V1){?>
							<dl class="goods-announce">
								<dt class="goods-announce__title"><?php echo $TPL_V1["pmi_title"]?></dt>
								<dd class="goods-announce__info"><?php echo $TPL_V1["pmi_desc"]?></dd>
							</dl>
<?php }}?>
							<dl class="goods-announce">
								<dt class="goods-announce__title">Style Code</dt>
								<dd class="goods-announce__info"><?php echo $TPL_VAR["pcode"]?></dd>
							</dl>
						</div>
					</div>
<?php }?>
<?php }?>
		</section>


		<section class="goods-tabs__cont goods-notice">
			<a id="goods-notice" class="br__hidden--anchor">Exchange/Refund information tab</a>
			<ul class="goods-notice__list">
				<li class="goods-notice__box">
					<button type="button" class="goods-notice__btn goods-notice__btn--shipping">Barrel Uses EMS at the post office</button>
				</li>
				<!-- <li class="goods-notice__box">
					<button type="button" class="goods-notice__btn goods-notice__btn--precautions">Washing & Care Guide</button>
				</li> -->
				<li class="goods-notice__box">
					<button type="button" class="goods-notice__btn goods-notice__btn--cliam">Returns / Refunds</button>
				</li>
				<li class="goods-notice__box">
					<button type="button" class="goods-notice__btn goods-notice__btn--repair">Repair Information</button>
				</li>
			</ul>
		</section>
    </section>
    <!-- [E] 반품/환불/수선 -->
<?php }?>
<?php if($TPL_VAR["langType"]=='korean'){?>
        <section class="goods-tabs__cont goods-review ">
            <a id="goods-review_IG" class="br__hidden--anchor">Product Review Tab</a>

            <!--<h4 class="goods-review__title">Reviews<span>(<?php echo $TPL_VAR["total_review_cnt"]?>)</span></h4>
            <p class="goods-review__des">Reviews of other customers.</p>-->

            <h4 class="goods-review__title">Best Review</h4>



<?php if($TPL_VAR["langType"]=='korean'){?>
            <div class="goods-review__best">

                <!-- <h5 class="goods-review__best__title">Montly Best Review!</h5> -->
                <p class="goods-review__best__desc">Every month <strong>last Thursday</strong>, we select the best reviews.<br><?php if($TPL_VAR["isCosmetic"]){?> Barrel Cosmetics <?php }else{?> body <?php }?> With the wearer&#39;s cut, the <br>probability> increases.</p>
                <div class="goods-review__best__rank">
                    <ul class="rank-list2">
                        <li><span class="rank-list2-txt1">영문몰해당없음</span><span class="rank-list2-txt2"><?php echo $TPL_VAR["fbUnit"]["f"]?><strong>50,000</strong><?php echo $TPL_VAR["fbUnit"]["b"]?></span></li>
                        <li><span class="rank-list2-txt1">영문몰해당없음</span><span class="rank-list2-txt2"><?php echo $TPL_VAR["fbUnit"]["f"]?><strong>20,000</strong><?php echo $TPL_VAR["fbUnit"]["b"]?></span></li>
                        <li><span class="rank-list2-txt1">영문몰해당없음</span><span class="rank-list2-txt2"><?php echo $TPL_VAR["fbUnit"]["f"]?><strong>10,000</strong><?php echo $TPL_VAR["fbUnit"]["b"]?></span></li>
                    </ul>
                    <!-- <ul class="rank-list">
                        <li class="rank-list__box">
                            <span class="rank-list__rank">영문몰해당없음</span>
                            <span class="rank-list__prize"><?php echo $TPL_VAR["fbUnit"]["f"]?>50,000<?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        </li>
                        <li class="rank-list__box">
                            <span class="rank-list__rank">영문몰해당없음</span>
                            <span class="rank-list__prize"><?php echo $TPL_VAR["fbUnit"]["f"]?>20,000<?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        </li>
                        <li class="rank-list__box">
                            <span class="rank-list__rank">영문몰해당없음</span>
                            <span class="rank-list__prize"><?php echo $TPL_VAR["fbUnit"]["f"]?>10,000<?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                        </li>
                    </ul> -->
                </div>

                <!-- 베스트 위젯 -->
                <style>
                    .crema-type .br__goods-view .crema-applied.crema-best-review { width:calc(100% + 1rem) !important;margin-left:-.5rem; } .crema-reviews > iframe { max-width: 100% !important; }
                    .crema-type .br__goods-view .crema-best-review {padding:0 1rem;}
                </style>
                <!-- <div class="crema-reviews crema-best-review" data-widget-id="34"></div> -->

                <p class="goods-review__best__refer">※ Mileage given for reviews are for online purchases only.</p>

                <div class="goods-review__best_btn">
                    <a href="/customer/bestReview">베스트 리뷰 보러가기</a>
                </div>

                <div class="goods-review__best__kind">
                    <dl class="best-kind">
                        <dt class="best-kind__title">Reviews</dt>
                        <dd class="best-kind__desc">Thank you for your comments.<strong></dd>
                    </dl>
                    <dl class="best-kind">
                        <dt class="best-kind__title">Photo Reviews</dt>
                        <dd class="best-kind__desc">(english)<strong>글 50자 이상의 생생한 후기와 착용컷</strong>을 남겨주시면 <strong><?php if($TPL_VAR["isCosmetic"]){?>1,000원<?php }else{?>5,000원<?php }?></strong>이 적립 됩니다.</dd>
                    </dl>
                </div>



            </div>
            <!-- <div class="goods-review__notice">
                <h5 class="goods-review__notice__title">Non-assetable Condition</h5>
                <ul class="goods-review__notice__list">
                    <li class="goods-review__notice__desc"></li>
                    <li class="goods-review__notice__desc">In case the same photo is uploaded twice with both products and in the case of a duplicate postscript (copy/paste), the reward is given only once.</li>
                    <li class="goods-review__notice__desc">(english)· 글 50자는 ‘공백 제외/ 특수문자 제외 / ㅋ,ㅎ,ㅠ,..등 자음 및 모음 ,한자는 제외 숫자의 경우 한 글자로 처리.</li>
                    <li class="goods-review__notice__desc">When the product is bought at offline stores, or from websites other than our offical one.</li>
                    <li class="goods-review__notice__desc">Reward is not paid for post a review after purchase as non-member. (Only for members)</li>
                    <li class="goods-review__notice__desc">When products are bought as a non-member, then writes review, no mileage will be given.<span>(Benefits for membership)</span></li>
                    <li class="goods-review__notice__desc">When the price of the product is less than $10, reward cannot be given.</li>
<?php if(!$TPL_VAR["isCosmetic"]){?>
                    <li class="goods-review__notice__desc">· When buying at the Barrel Outlet, no mileage will be accumulated for reviews.</li>
<?php }?>
                    <li class="goods-review__notice__desc">· 이벤트 진행 시 해당 상품 구매에 대한 후기 적립금은 조정될 수 있습니다.</li>
                </ul>
            </div> -->
<?php }?>
<?php if($TPL_VAR["langType"]=='korean'){?>

<?php }else{?>
            <!--상품후기-->
            <form id="devProductReviewForm">
                <input type="hidden" name="id" value="<?php echo $TPL_VAR["pid"]?>"/>
                <input type="hidden" name="orderBy" value="real_regdate"/>
                <input type="hidden" name="orderByType" value="desc"/>
                <input type="hidden" name="bbsDiv" value=""/>
                <input type="hidden" name="page" value="1" id="devPage"/>
                <input type="hidden" name="max" value="3" id="devMax"/>
            </form>

            <div id="devTabReview" class="tab-review">
<?php if($TPL_VAR["allReviewTotal"]== 0){?>
                <div id="devAllReviewEmpty" class="empty-content">
                    No product review
                </div>
<?php }else{?>
                <div class="top-area">
                    <p class="title">Customer Satisfaction</p>
                    <div class="total-score">
                        <span class="set-star big">
                            <span class="score" style="width:<?php echo $TPL_VAR["avg"]["avgPct"]?>%"></span>
                        </span>
                        <em><?php echo $TPL_VAR["avg"]["avg"]?></em>
                    </div>
                    <div class="total-score type2">
                        <span>
                            <span>Product</span>
                            <span class="set-star gray">
                                <span class="score" style="width:<?php echo $TPL_VAR["avg"]["goodsAvgPct"]?>%"></span>
                            </span>
                            <em><?php echo $TPL_VAR["avg"]["goodsAvg"]?></em>
                        </span>
                        <span>
                            <span>Shipping</span>
                            <span class="set-star gray">
                                <span class="score" style="width:<?php echo $TPL_VAR["avg"]["deliveryAvgPct"]?>%"></span>
                            </span>
                            <em><?php echo $TPL_VAR["avg"]["deliveryAvg"]?></em>
                        </span>
                    </div>
                </div>

                <div class="review-content" <?php if($TPL_VAR["allReviewTotal"]== 0){?>style="display:none"<?php }?>>
                <div class="top">
                    <div class="review-tab tab-js">
                        <a class="devReviewsDiv active" data-bbsdiv="">All<em><?php echo g_price($TPL_VAR["allReviewTotal"])?></em></a>
                        <a class="devReviewsDiv" data-bbsdiv="2">Reviews<em><?php echo g_price($TPL_VAR["reviewTotal"])?></em></a>
                        <a class="devReviewsDiv" data-bbsdiv="1">Photo Reviews<em><?php echo g_price($TPL_VAR["premiumReviewTotal"])?></em></a>
                    </div>
                    <div class="detail-info-sorting jq-radio">
                        <a class="devSort on" data-orderby="real_regdate" data-sort="desc">Recent</a>
                        <a class="devSort" data-orderby="avg" data-sort="asc">Lowest rate</a>
                        <a class="devSort" data-orderby="avg" data-sort="desc">Highest rate</a>
                    </div>
                </div>

                <div class="wrap-tab-cont review-list">
                    <div id="review-tab1" class="active">
                        <ul id="devReviewContents">
                            <li id="devReviewLoading">
                                <div class="empty-content">
                                    Loading...
                                </div>
                            </li>

                            <li id="devReviewEmpty">
                                <div class="empty-content">
                                    No product review
                                </div>
                            </li>

                            <li id="devReviewDetail">
                                <div class="review toggle devReviewDetailContents">
                                    {[#if isBest]}<span class="best">BEST</span>{[/if]}
                                    <span class="set-star">
                                            <span class="score" style="width:{[avg_pct]}%"></span>
                                        </span>
                                    <span class="user">{[bbs_id]}</span>
                                    <span class="date">{[regdate]}</span>

                                    <p class="option">{[pname]}</p>
                                    {[#if isThumb]}<span class="thumb"><img src="{[thumb]}"></span>{[/if]}
                                    <p class="tit">{[bbs_subject]}</p>
                                </div>
                                <div class="review-detail">
                                    <div class="wrap-score">
                                        <span>Product evaluation <img src="<?php echo $TPL_VAR["templet_src"]?>/img/icon/m_star_s_{[valuation_goods]}.png">{[valuation_goods]}</span>
                                        <span>Shipping Evaluation <img src="<?php echo $TPL_VAR["templet_src"]?>/img/icon/m_star_s_{[valuation_delivery]}.png">{[valuation_delivery]}</span>
                                    </div>
                                    <div class="content">{[bbs_contents]}</div>
                                    <div class="review-img-area">
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper" id="devReviewImgsContents">
                                                <div class="swiper-slide devReviewImgs" id="devReviewImgsDetails" data-bbsIx="{[bbsIx]}" data-index="{[index]}">
                                                    <img src="{[img]}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {[#if cmt.cmt_ix]}
                                    <div class="admin_comment">
                                        <p class="info"><span>{[cmt.cmt_name]}</span>{[cmt.cmt_date]}</p>
                                        <div class="comment">
                                            {[{cmt.cmt_contents}]}
                                        </div>
                                    </div>
                                    {[/if]}
                                </div>
                            </li>
                        </ul>
                        <div class="wrap-btn-area more" id="devReviewPageWrap"></div>
                    </div>
                </div>
            </div>
<?php }?>
            </div>
            <!--상품문의-->
<?php }?>
        </section>
<?php }?>
        <section class="goods-tabs__cont goods-qna">
            <a id="goods-qna" class="br__hidden--anchor">Product inquiry tab</a>
            <div class="goods-qna__write">
                <h4 class="goods-qna__write__title">Customer Q&A&nbsp;<span>(<?php echo $TPL_VAR["qnaTotal"]?>)</span></h4>
<?php if($TPL_VAR["langType"]=='korean'){?>
				<p class="goods-qna__write__desc">고객님들의 문의사항을 신속하고 친절하게<br />안내하겠습니다.</p>
<?php }else{?>
				<p class="goods-qna__write__desc">If you have any question about the item,<br />please feel free to contact us.</p>
<?php }?>
                <a href="javascript:void(0);" class="goods-qna__write__btn" id="devQnaWrite" data-pid="<?php echo $TPL_VAR["pid"]?>">Write Product Q&A</a>
            </div>
            <form id="devProductQnaForm">
                <input type="hidden" name="id" value="<?php echo $TPL_VAR["pid"]?>" id="devQnaPid"/>
                <input type="hidden" name="qnaType" value="all"/>
                <input type="hidden" name="qnaDiv" value="all"/>
                <input type="hidden" name="page" value="1" id="devQnaPage"/>
                <input type="hidden" name="max" value="20" id="devQnaMax"/>
            </form>
<?php if($TPL_VAR["qnaTotal"]== 0){?>
            <div id="devAllQnaEmpty" class="empty-content">
                No product Q&A
            </div>
<?php }else{?>
            <ul class="goods-qna__list" id="devQnaContents">
                <li id="devQnaLoading">
                    <div class="empty-content">
                        Loading...
                    </div>
                </li>

                <li id="devQnaEmpty">
                    <div class="empty-content">
                        No product inquiry
                    </div>
                </li>

                <!--
                    무조건 비밀글 아이콘 표기되도록 요청되어 goods-qna__box--secret 클레스 공통 적용 처리 #5493
                     goods-qna__box--secret에 있던 자물쇠 아이콘은 다른곳으로 옮겨서 모든 리스트에 나오도록 처리하였습니다.
                -->
                <li class="goods-qna__box {[#if isSameUser]}{[else]}goods-qna__box--secret{[/if]}" id="devQnaDetail">
                    <button class="qna-info">
                        <!-- [S] 내 글인 경우 -->
                        {[#if isSameUser]}
                        <span class="qna-info__my-qna">[My Q&A]</span>
                        {[/if]}
                        <!-- [E] 내 글인 경우 -->
                        <div class="qna-info__info">
                            {[#if isResponse]}
                            <span class="qna-info__state qna-info__state--point">Completed</span>
                            <span class="qna-info__type">[{[div_name]}]</span>
                            {[else]}
                            <span class="qna-info__state">Pending</span>
                            <span class="qna-info__type">[{[div_name]}]</span>
                            {[/if]}

                            <span class="qna-info__name">[{[bbs_name]}]</span>

                            <!-- 기획의도로 인한 주석처리 -->
                            <!--<span class="qna-info__date">{[regdate]}</span>-->
                        </div>
                        <p class="qna-info__title">{[bbs_subject]}</p>
                    </button>
                    <div class="qna-detail" id="devQnaDetailContents">
                        <div class="qna-detail__question" id="devQnaQuestion">
                            <p class="qna-detail__question__desc">{[bbs_contents]}</p>
                            <!-- [S] 답변 받기 전, 내 글인 경우 -->
                            {[#if isResponse]}
                            {[else]}
                            {[#if isSameUser]}
                            <div class="qna-detail__question__mod">
                                <button type="button" class="qna-detail__question__btn devDeleteQna" data-bbs_ix="{[bbs_ix]}" >Delete</button>
                                <a href="javascript:void(0);" class="qna-detail__question__btn devModifyQna" data-bbs_ix="{[bbs_ix]}" data-pid="<?php echo $TPL_VAR["pid"]?>">Edit</a>
                            </div>
                            {[/if]}
                            {[/if]}
                            <!-- [E] 답변 받기 전, 내 글인 경우 -->
                        </div>
                        <!-- [S] 배럴 답변 -->
                        <div class="qna-detail__answer" id="devQnaResponse">
                            <div class="qna-detail__answer__info">
                                <span class="qna-detail__answer__name">BARREL</span>
                                <!-- 기획의도로 인한 주석처리 -->
                                <!--<span class="qna-detail__answer__date">{[resDate]}</span>-->
                                <p class="qna-detail__answer__desc">
                                    {[cmt_contents]}
                                </p>
                            </div>
                        </div>
                        <!-- [E] 배럴 답변 -->
                    </div>
                </li>
            </ul>
            <div id="devQnaPageWrap"></div>
<?php }?>
        </section>
    </section>
    <!-- [E] 탭 영역 -->

    <!-- [S] 미니카트 -->
    <section class="br__goods-view__minicart mini-cart" id="devMinicartArea" data-pid="<?php echo $TPL_VAR["pid"]?>">
        <button type="button" class="br__goods-view__minicart--toggle">{=trans('미니카트 토글버튼')</button>
        <div class="br__goods-view__minicart--dimmed"></div>
        <div class="minicart">
            <div class="minicart__banner">
                <p class="minicart__banner__desc">
                    <span class=" eng-hidden">
<?php if($TPL_VAR["deliveryPolicy"]== 1){?> <!-- 무료배송 -->
                    <?php echo trans($TPL_VAR["delivery"]["text"])?>

<?php }elseif($TPL_VAR["deliveryPolicy"]== 2){?> <!-- 고정배송비 -->
                    <?php echo g_price($TPL_VAR["delivery"]["sumPrice"])?>원
<?php }else{?> <!-- 조건배송비 -->
                    <?php echo trans($TPL_VAR["delivery"]["text"])?>

<?php }?>
                        </span>
                     <span class="minicart__banner__desc--point">[Overseas shipping fee will be charged]</span>
                </p>
            </div>
            <section class="br__goods-view__information">
                <div class="goods-info">
<?php if($TPL_VAR["product_type"]== 0&&$TPL_VAR["add_info"]!=''){?>
                    <div class="goods-info__color">
                        <h4 class="goods-info__color__title">Color <span><?php echo $TPL_VAR["add_info"]?></span></h4>
<?php if($TPL_VAR["sameProduct"]){?>
                        <ul class="goods-info__color__list">
<?php if($TPL_sameProduct_1){foreach($TPL_VAR["sameProduct"] as $TPL_V1){?>
                            <li class="goods-info__color__box">
                                <a href="/shop/goodsView/<?php echo $TPL_V1["pid"]?>" class="goods-info__color__link <?php if($TPL_VAR["pid"]==$TPL_V1["pid"]){?>goods-info__color__link--active<?php }?>">
                                    <img src="<?php echo $TPL_V1["filterImg"]?>" alt="색상명">
                                </a>
                            </li>
<?php }}?>
                        </ul>
<?php }?>
                    </div>
<?php }?>
<?php if($TPL_VAR["colorChipList"]){?>
                    <div class="goods-info__color">
<?php if($TPL_colorChipList_1){foreach($TPL_VAR["colorChipList"] as $TPL_K1=>$TPL_V1){?>
                        <h4 class="goods-info__color__title">
<?php if($TPL_K1=='1'&&!empty($TPL_VAR["relation_text1"])){?><?php echo $TPL_VAR["relation_text1"]?><?php }?><?php if($TPL_K1=='2'&&!empty($TPL_VAR["relation_text2"])){?><?php echo $TPL_VAR["relation_text2"]?><?php }?>
                        </h4>
                        <ul class="goods-info__color__list">
<?php if(is_array($TPL_R2=$TPL_V1)&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                            <li class="goods-info__color__box">
                                <a href="/shop/goodsView/<?php echo $TPL_V2["pid"]?>" class="goods-info__color__link <?php if($TPL_VAR["pid"]==$TPL_V2["pid"]){?>goods-info__color__link--active<?php }?>">
                                    <img src="<?php echo $TPL_V2["filterImg"]?>" alt="색상명">
                                </a>
                            </li>
<?php }}?>
                        </ul>
<?php }}?>
                    </div>
<?php }?>
                    <div class="devForbizTpl" id="devLonelyOption">
                    <span id="devLonelyOptionName">
                        Option selection
                        <p>{[option_name]}</p>
                    </span>
                    </div>

<?php if($TPL_VAR["product_type"]== 99){?>
                    <h4 class="goods-info__set__title" style="font-weight:600;">Option for Set product</h4>
<?php }?>
                    <div class="goods-info__size" id="devMinicartOptions"></div>
                </div>

                <section class="br__goods-view__option">
                    <div id="devMinicartAddOption" class="goods-option hidden">
                        <h3 class="goods-option__title">Option Product</h3>
                    </div>
                </section>

                <!--사은품-->
<?php if($TPL_VAR["product_gift"]&&$TPL_VAR["gift_selectbox_cnt"]> 0){?>
                <div class="goods-info__set">
                    <h4 class="goods-info__set__title">Free Gift Select</h4>

                    <ul class="goods-info__set__list">
<?php if($TPL_product_gift_1){$TPL_I1=-1;foreach($TPL_VAR["product_gift"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1<$TPL_VAR["gift_selectbox_cnt"]){?>
                        <li class="goods-info__set__box">
                            <select class="devProductGift_<?php echo $TPL_I1?> devGiftSelect" data-idx="<?php echo $TPL_I1?>" name="product_gift[]">
                                <option value=""> Please select </option>
<?php if(is_array($TPL_R2=$TPL_V1["product_gift_detail"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                                <option value="<?php echo $TPL_V2["pid"]?>" <?php if($TPL_V2["status"]=='soldout'){?> disabled <?php }?>><?php echo $TPL_V2["pname"]?> <?php if($TPL_V2["status"]=='soldout'){?>[Out of stock]<?php }?></option>
<?php }}?>
                            </select>
                        </li>
<?php }?>
<?php }}?>
                    </ul>
                </div>
<?php }?>

                <ul class="goods-cart" id="devMinicartSelected">
					<li class="goods-cart__box devOptionBox devForbizTpl" devPid="{[pid]}" devOptionKind="{[option_kind]}" devOptid="{[option_id]}" devUnit="{[option_dcprice]}" devStock="{[option_stock]}">
                        <p class="goods-cart__tit">{[option_prefix]}{[pname]}</p>
                        <p class="goods-cart__sub">{[add_info_text]}</p>
                        <p class="goods-cart__sub">{[option_div_text]}</p>
                        <div class="control">
                            <ul class="option-up-down devControlCntBox">
                                <li class="devCntMinus"><button class="down"></button></li>
                                <li><input type="text" value="{[allowBasicCnt]}" class="devMinicartPrdCnt"></li>
                                <li class="devCntPlus"><button class="up"></button></li>
                            </ul>
                        </div>
                        <!-- <div class="ig_div1"> -->
                            <div class="price" style="display: inline-flex; float:left;"><?php echo $TPL_VAR["fbUnit"]["f"]?><em class="devMinicartEachPrice">{[eachPrice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
                            <!--<button class="btn-option-del devMinicartDelete"></button>-->
                            <button class="btn-option-del2 devMinicartDelete"></button>
                        <!-- </div> -->
                    </li>
				</ul>
            </section>
            <div class="minicart__total">
                <span class="minicart__total__text">Total price</span>
                <span class="minicart__total__price"><span><?php echo $TPL_VAR["fbUnit"]["f"]?></span><span id="devMinicartTotal">0</span><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                <!--<span class="minicart__total__count">(<span class="devMinicartPrdCnt">0</span>ltem(s))</span>-->
            </div>
        </div>
    </section>
    <!-- [E] 미니카트 -->

    <!-- [S] 상품상세 하단버튼 -->
    <section class="br__goods-view__btn">
        <div class="goods-btn">
<?php if($TPL_VAR["langType"]=='korean'){?>
            <button type="button" class="goods-btn__store" id="storeGuide" data-id="<?php echo $TPL_VAR["id"]?>" data-type="<?php echo $TPL_VAR["product_type"]?>">Membership Guide</button>
<?php }?>
<?php if($TPL_VAR["viewMode"]=='preview'){?>
            <button type="button" class="goods-btn__sold-out devOrderDirect" disabled>Preview Product</button>
<?php }else{?>
<?php if($TPL_VAR["status"]=='sale'){?>
                <button type="button" class="goods-btn__cart devAddCart devAddCart__layerBtn">Cart</button>
                <button type="button" class="goods-btn__buy devOrderDirect">BUY NOW</button>
<?php }elseif($TPL_VAR["status"]=='ready'){?>
                <button type="button" class="goods-btn__sold-out devOrderDirect" disabled>For Sale</button>
<?php }elseif($TPL_VAR["status"]=='end'){?>
                <button type="button" class="goods-btn__sold-out devOrderDirect" disabled>Sales End</button>
<?php }else{?>
                <button type="button" class="goods-btn__sold-out devOrderDirect" disabled style="height:4.5rem;">Out of stock</button>
<?php }?>
<?php }?>
        </div>
    </section>
    <!-- [E] 상품상세 하단버튼 -->
    <div class="devAddCart__layer">
        <div class="devAddCart__layer__content">
            <a href="#" class="devAddCart__layer__close">
                닫기
            </a>
            <p>The selected item has been added to your cart. <br> Would you like to go to the cart page?</p>
            <div class="devAddCart__layer__btn">
                <a href="#" class="btn-dark">
                    Continue
                </a>
                <a href="/shop/cart" class="btn-dark-line ">
                    View cart
                </a>
            </div>
        </div>
        <div class="devAddCart__layer__bg"></div>
    </div>
</section>


<section class="tab-popup-content">
    <div id="pop-repair">
        <div class="br__claim">
            <div class="gform">
                <dl class="gform__common">
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <dt class="gform__common__top">A/S 신청</dt>
                    <dd class="gform__common__desc">
                        불량 확인 또는 수선 가능 문의 및 요청은 <span class="point">마이페이지 > 1:1 문의하기</span> 게시판에 작성 부탁드립니다.
                        <a href="/customer/productRepairGuide" class="repair-link">A/S 신청 및 접수 방법 자세히 보기</a>
                    </dd>
<?php }else{?>
                    <dt class="gform__common__top">Repair Information</dt>
                    <dd class="gform__common__desc repair">
                        Any inquiry regarding defective and repair,
                        <br>please go on to <span class="point">My Page > request 1:1 inquiry</span> or
                        <br>e-mail us at <span class="point"><a href="mailto:en_help@getbarrel.com">en_help@getbarrel.com</a></span>
                    </dd>
<?php }?>
                </dl>
            </div>
        </div>
    </div>
    <div id="pop-shipping">
<?php $this->print_("shippingGuide",$TPL_SCP,1);?>

    </div>
    <div id="pop-precautions">
        <!-- productPrecautions -->
    </div>
    <div id="pop-cliam">
        <div class="br__claim">
<?php $this->print_("cliamGuide",$TPL_SCP,1);?>

        </div>
    </div>
</section>

<!--현재 챗봇 가림으로 가운데 뜬 공간 goods-view__recent-btn--imsi 에 넣어놈. 나중에 이 클래스만 빼면 제 위치로 됨. -->
<button class="goods-view__recent-btn goods-view__recent-btn2 goods-view__recent-btn--imsi open-layer__recent-view " data-title="Recently viewed product">
    <img id="devBeforePrd" src="" alt="">
    Recently viewed products button
</button>


<!-- cre.ma / 타겟 팝업 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
<div class="crema-target-popup"></div>

<!-- cre.ma / 리뷰 작성 유도 팝업 / 스크립트를 수정할 경우 연락주세요 (support@cre.ma) -->
<div class="crema-popup"></div>