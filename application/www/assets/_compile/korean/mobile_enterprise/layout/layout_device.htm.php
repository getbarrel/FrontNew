<?php /* Template_ 2.2.8 2024/02/19 13:27:29 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/layout/layout_device.htm 000018197 */ ?>
<!DOCTYPE html>
<?php if($TPL_VAR["langType"]=='korean'){?>
<html lang="ko" class="crema-type">
<?php }elseif($TPL_VAR["langType"]=='english'){?>
<html lang="en" class="crema-type">
<?php }?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">

    <!--[S] FAVICON-->
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="36x36"  href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/android-icon-36x36.png">
    <link rel="icon" type="image/png" sizes="48x48"  href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/android-icon-48x48.png">
    <link rel="icon" type="image/png" sizes="72x72"  href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/android-icon-72x72.png">
    <link rel="icon" type="image/png" sizes="96x96"  href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/android-icon-96x96.png">
    <link rel="icon" type="image/png" sizes="144x144"  href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/android-icon-144x144.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/favicon/favicon-16x16.png">
    <!-- <link rel="manifest" href="/manifest.json"> -->
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!--안드로이드 크롬-->
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon/favicon_192.png">
    <!--IE10 매트로 타일-->
    <meta name="msapplication-TileImage" content="/favicon/favicon_144.png">
    <!--[E] FAVICON-->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8JMZSEV839"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-8JMZSEV839');
    </script>

    <!-- css -->
	<link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/css/main.css?version=<?php echo CLIENT_VERSION?>" />
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/css/common.css?version=<?php echo CLIENT_VERSION?>" /> -->
	<!-- 2024.01.19 리뉴얼 S -->
	<link rel="stylesheet" type="text/css" href="/assets/mobile_templet/mobile_enterprise/assets/css/common.css" />
	<!-- 2024.01.19 리뉴얼 E -->


<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["GroupCssSrc"])){?>
    <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layout"]["GroupCssSrc"]?>?version=<?php echo CLIENT_VERSION?>">
<?php }?>
    <!-- js library -->
    <script>var forbizCsrf = {name: "<?php echo $TPL_VAR["layout"]["ForbizCsrfName"]?>", hash: "<?php echo $TPL_VAR["layout"]["ForbizCsrfHash"]?>", isLogin: <?php echo json_encode($TPL_VAR["layoutCommon"]["isLogin"])?>};</script>

    <!--[S] FRONT-->
    <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/css/main.css?version=<?php echo CLIENT_VERSION?>">
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/js/vendor.js?version=<?php echo CLIENT_VERSION?>"></script>
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/js/main.js?version=<?php echo CLIENT_VERSION?>"></script>
    <!--<script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/library.js?version=<?php echo CLIENT_VERSION?>"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/decimal.js/10.2.0/decimal.min.js"></script>
	<!-- 2024.01.19 리뉴얼 S -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="/assets/mobile_templet/mobile_enterprise/assets/js/swiper/swiper-bundle.min.js"></script>
	<!-- 2024.01.19 리뉴얼 E -->

    <!--[E] FRONT-->

<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["LanguageJsSrc"])){?>
    <!-- 언어 -->
    <script src="<?php echo $TPL_VAR["layout"]["LanguageJsSrc"]?>?version=<?php echo CLIENT_VERSION?>"></script>
<?php }?>
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/ui_common.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 퍼블공통 -->
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/dev_common.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 개발공통 -->
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/layout.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 레이아웃 스크립트 -->
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/wish.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 관심상품 -->
    <script>
        //set environment
        common.environment = "<?php echo DB_CONNECTION_DIV?>";
        common.langType = "<?php echo BASIC_LANGUAGE?>";
        common.bcscale = <?php if(defined('BCSCALE')){?><?php echo BCSCALE?><?php }else{?>0<?php }?>;
        common.kakaoScriptKey = "<?php echo KAKAO_SCRIPT_KEY?>";
    </script>

    <!-- 몰 관련 태그 -->
    <title><?php echo $TPL_VAR["layoutCommon"]["title_desc"]?></title>
    <meta name="keywords" content="<?php echo $TPL_VAR["keyword_desc"]?>">

    <!-- 다음주소 -->
    <script src="<?php echo $TPL_VAR["daumJsUrl"]?>"></script>

    <!--구글 로그인-->
    <meta name="google-signin-client_id" content="<?=GOOGLE_CLIENT_ID?>">
    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
    <script>
        function onSignIn(googleUser) {
            var profile = googleUser.getBasicProfile();
            location.href = '/controller/member/google?id='+profile.getId()+'&id_token='+googleUser.getAuthResponse().id_token;
        }

        function signOut() {
            try{
                var auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function () {
                    console.log('User signed out.');
                });
                auth2.disconnect();
            }catch(e){
                console.log(e);
            }
        }

        function onLoad() {
            gapi.load('auth2', function() {
                gapi.auth2.init();
            });
        }
    </script>

<?php if($TPL_VAR["layout"]["isSnsShare"]){?>
    <!--SNS 공유-->
    <link rel="image_src" href="<?php echo $TPL_VAR["layout"]["snsShareImage"]?>" />

    <meta property="og:image" content="<?php echo $TPL_VAR["layout"]["snsShareImage"]?>" />
    <meta property="og:title" content="<?php echo $TPL_VAR["layout"]["snsShareTitle"]?>" />
    <meta property="og:url" content="<?php echo $TPL_VAR["layout"]["snsShareUrl"]?>" />
    <meta property="og:description" content="<?php echo $TPL_VAR["layout"]["snsShareDescription"]?>" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?php echo $TPL_VAR["title_desc"]?>" />

    <meta name="twitter:image" content="<?php echo $TPL_VAR["layout"]["snsShareImage"]?>" />
    <meta name="twitter:title" content="<?php echo $TPL_VAR["layout"]["snsShareTitle"]?>" />
    <meta name="twitter:url" content="<?php echo $TPL_VAR["layout"]["snsShareUrl"]?>" />
    <meta name="twitter:description" content="<?php echo $TPL_VAR["layout"]["snsShareDescription"]?>" />
    <meta name="twitter:card" content="summary_large_image" />

    <meta itemprop="image" content="<?php echo $TPL_VAR["layout"]["snsShareImage"]?>">
    <meta itemprop="name" content="<?php echo $TPL_VAR["layout"]["snsShareTitle"]?>">
    <meta itemprop="description" content="<?php echo $TPL_VAR["layout"]["snsShareDescription"]?>">
    <!--SNS 공유 스크립트 : 공통-->
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/snsShare.js?version=<?php echo CLIENT_VERSION?>"></script>
    <!--SNS 공유 스크립트 : kakao-->
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <!--/-->
<?php }else{?>
    <meta name="description" content="<?php echo $TPL_VAR["title_desc"]?>">
<?php }?>
  
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <?php echo $TPL_VAR["layout"]["layOutHeaderScript"]?>

    <?php echo $TPL_VAR["layout"]["kakaoMomentScript"]?>

    <?php echo $TPL_VAR["kakaoMomentSubScript"]?>

</head>
<body id="<?php echo $TPL_VAR["layoutCommon"]["bodyId"]?>" class="NEWbarrelM">

<?php echo $TPL_VAR["layoutCommon"]["gtmBodyScript"]?>

<header id="header" class="br__header">
<?php $this->print_("headerTop",$TPL_SCP,1);?>

    <nav id="navigation" class="br__navi">
<?php $this->print_("headerMenu",$TPL_SCP,1);?>

    </nav>
</header>
<section id="container" class="br__layout">
<?php $this->print_("contents",$TPL_SCP,1);?>

    <div class="br__floating-btn">
        <a href="#historyback" class="br__floating-btn--historyback">뒤로가기</a>
        <a href="#document" class="br__floating-btn--up"></a>
        <a href="#document" class="br__floating-btn--down"></a>
        <!--
        강과장님요청으로 주석처리
        <a href="#chatbot" class="br__floating-btn&#45;&#45;chatbot">챗봇열기</a>
        -->
        <script type="text/javascript">
        
                //  업으로 이동
                var $btnTop_ig = $(".br__floating-btn--up");

                $btnTop_ig.on('click', function (e) {
                    // localStorage.scrollY = $(window).scrollTop();
                    // window.location.href = "/mypage/preferences";
                    // e.preventDefault();

                    var cmsIframe = $('#brand_info__content');

                    e.stopPropagation();
                    $('body, html').stop().animate({
                        scrollTop: 0
                    });

                    //최상단으로 갈때 헤더 보이지 않는 경우 있어 빈공간처럼 노출됨 #6333 >> 헤더,푸터 보이도록 추가
                    $header.addClass('up').removeClass('down').css({
                        'margin-top': ''
                    });

                    $(".br__header__inner").css({
                        'margin-top': ''
                    });
                    $footer.css({
                        'margin-bottom': ''
                    });
                    $floatingMenu.css({
                        'margin-bottom': ''
                    });

                    // cms에서 가져오는 iframe에 데이터 전송
                    if (cmsIframe.length > 0) {
                        document.getElementById('brand_info__content').contentWindow.postMessage({
                            cmd: 'scrollTop'
                        }, '*');
                    }
                });





                //  최하단으로 이동
                $(".br__floating-btn--down").on('click', function (e) {

                    $('body, html').stop().animate({
                        scrollTop: $(document).height()
                    });
                });
        </script>
    </div>
</section>
<footer id="footer">
<?php $this->print_("footerMenu",$TPL_SCP,1);?>

<?php $this->print_("footerDesc",$TPL_SCP,1);?>

</footer>

<!-- modal -->
<div class="popup-mask"></div>
<div class="popup-layout">
    <p class="popup-title">
        <span id="devModalTitle">제목</span>
        <span class="close"></span>
    </p>
    <div id='devModalContent' class="popup-content">내용</div>
</div>

<!-- iframe modal -->
<div class="popup-frame-layout">
    <p class="popup-title">
        <span id="devIframeModalTitle"></span>
        <span class="close"></span>
    </p>
    <div class="popup-content">
        <iframe id="devIframeModalIframe"></iframe>
    </div>
</div>

<!--layer-lang-->
<div class="br__layer br__layer-lang">
    <span class="br__layer-lang__close js__lang__close">닫기버튼</span>
    <ul class="br__layer-lang__list">
        <h2 class="br__layer-lang__title">SELECT YOUR LANGUAGE</h2>
        <li class="br__layer-lang__list--kr"><a href="//www.getbarrel.com/">한국어</a></li>
        <li class="br__layer-lang__list--ch"><a href="/event/eventDetail/">中國語</a></li>
        <!--<li class="br__layer-lang__list&#45;&#45;us"><a href="javascript:alert('영문몰 오픈 준비중입니다.')">ENGLISH</a></li>-->
        <li class="br__layer-lang__list--us"><a href="//en.getbarrel.com">ENGLISH</a></li>
    </ul>
</div>

<!--layer-sns-->
<div class="br__layer br__layer-sns">
    <span class="br__layer-sns__close js__sns__close">닫기버튼</span>
    <div class="br__layer-sns__list">
        <h2 class="br__layer-sns__title">배럴 인스타그램</h2>
        <ul>
            <li><a href="https://www.instagram.com/barrel.lifestyle/?hl=ko" target="_blank"><span>배럴 오피셜</span></a></li>
            <!--li><a href="https://www.instagram.com/barrel.swim" target="_blank"><span>배럴 스윔</span></a></li-->
            <li><a href="https://www.instagram.com/barrel.fit/?hl=ko" target="_blank"><span>배럴핏</span></a></li>
            <!--li><a href="https://www.instagram.com/barrel.cosmetics" target="_blank"><span>배럴 코스메틱스</span></a></li-->
        </ul>

    </div>
</div>
<!--layer-campaign-->
<div class="br__layer br__layer-campaign  ">
    <span class="br__layer-sns__close js__sns__close">닫기버튼</span>
    <div class="br__layer-campaign__list">
        <h2 class="br__layer-sns__title">스포츠 캠페인</h2>
        <ul>
            <li class="e3qqf"><a href="/event/eventDetail/47"><span class="inner">스프린트 챔피언십</span></a></li>
            <li><a href="/event/eventDetail/13"><span class="inner">SOS 캠페인</span></a></li>
            <li><a href="/brand/cheering"><span class="inner">치어링 유어 스웻</span></a></li>
        </ul>
    </div>
</div>

<!-- layer-alert -->
<div class="br__layer-alert">
    <div class="layer-alert">
        <p class="layer-alert__title"></p>
        <div class="layer-alert__body">
            <p class="layer-alert__body__script"></p>
        </div>
        <div class="layer-alert__btn-box">
            <button type="button" class="layer-alert__btn layer-alert__btn--submit">확인</button>
            <button type="button" class="layer-alert__btn layer-alert__btn--cancel">취소</button>
        </div>
        <button type="button" class="layer-alert__close">닫기</button>
    </div>
</div>
<!-- layer-login -->
<div class="br__layer-login">
    <div class="layer-login">
        <div class="layer-login__body">
            <p class="layer-login__body__desc">해당 서비스는 로그인이 필요합니다. <br>로그인 하시겠습니까?</p>
            <a href="/member/login" class="layer-login__body__btn">로그인 하러가기</a>
            <p class="layer-login__body__join">아직 배럴 회원이 아니신가요? <a href="/member/joinInput">회원가입 하러가기</a></p>
        </div>
        <button type="button" class="layer-login__close">닫기</button>
    </div>
</div>


<!--팝업레이어창-->
<div class="main_popupL devForbizTpl devNotiPopup" devPopupIx="{[popup_ix]}" style="width:100%; height:auto; top:20%; left:0;" id="devNotiPopupTpl">
    <section class="main_popupL-inner">
        <div style="position: relative;">
            {[{popup_text}]}
        </div>
    </section>
</div>

<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["GroupJsSrc"])){?>
<!-- 퍼블&개발 공통:폴더별 -->
<script src="<?php echo $TPL_VAR["layout"]["GroupJsSrc"]?>?version=<?php echo CLIENT_VERSION?>"></script>
<?php }?>
<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["PageJsSrc"])){?>
<!-- 퍼블&개발 공통:각 페이지 별 -->
<script src="<?php echo $TPL_VAR["layout"]["PageJsSrc"]?>?version=<?php echo CLIENT_VERSION?>"></script>
<?php }?>
<script>
<?php if(DB_CONNECTION_DIV=='development'){?>
    //load 된 언어 서버요청
    common.lang.jsLanguageCollection();
<?php }?>

    common.noti.popup.load(<?php echo $TPL_VAR["layout"]["jsonPopupList"]?>);
</script>
<?php echo $TPL_VAR["footerDesc"]["footerScript"]?>

</body>
</html>