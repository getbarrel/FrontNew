<?php /* Template_ 2.2.8 2024/04/02 10:42:40 /home/barrel-stage/application/www/assets/templet/enterprise/layout/layout_default.htm 000010647 */ ?>
<!DOCTYPE html>
<?php if($TPL_VAR["langType"]=='korean'){?>
<html lang="ko">
<?php }elseif($TPL_VAR["langType"]=='english'){?>
<html lang="en">
<?php }?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8JMZSEV839"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-8JMZSEV839');
    </script>

    <!-- Criteo Loader File 23.06.29-->
    <script type="text/javascript" src="//dynamic.criteo.com/js/ld/ld.js?a=104564" async="true"></script>
    <!-- END Criteo Loader File -->

    <!--[S] FAVICON-->
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon_16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon_32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/favicon/favicon_48.png">
    <link rel="icon" type="image/png" sizes="64x64" href="/favicon/favicon_64.png">
    <link rel="icon" type="image/png" sizes="128x128" href="/favicon/favicon_128.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon/favicon_192.png">
    <link rel="icon" type="image/png" sizes="256x256" href="/favicon/favicon_256.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/favicon_152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/favicon_180.png">
    <!--[E] FAVICON-->

    <!-- css -->
<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["GroupCssSrc"])){?>
    <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layout"]["GroupCssSrc"]?>?version=<?php echo CLIENT_VERSION?>">
<?php }?>
    <link rel="shortcut icon" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/favicon.ico" type="image/x-icon">
    <!-- js library -->
    <script>var forbizCsrf = { name:"<?php echo $TPL_VAR["layout"]["ForbizCsrfName"]?>", hash:"<?php echo $TPL_VAR["layout"]["ForbizCsrfHash"]?>", isLogin:<?php echo json_encode($TPL_VAR["layoutCommon"]["isLogin"])?>}, barrelFat = {}; barrelFat.useFat = <?php if(empty($TPL_VAR["useFat"])){?>0<?php }else{?><?php echo $TPL_VAR["useFat"]?><?php }?>;</script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/css/main.css?version=<?php echo CLIENT_VERSION?>">
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/js/vendor.js?version=<?php echo CLIENT_VERSION?>"></script>
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/js/main.js?version=<?php echo CLIENT_VERSION?>"></script>
    <!--<script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/library.js?version=<?php echo CLIENT_VERSION?>"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/decimal.js/10.2.0/decimal.min.js"></script>

<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["LanguageJsSrc"])){?>
    <!-- 언어 -->
    <script src="<?php echo $TPL_VAR["layout"]["LanguageJsSrc"]?>?version=<?php echo CLIENT_VERSION?>"></script>
<?php }?>

<?php if($TPL_VAR["layoutCommon"]["bodyId"]=='shop_goodsView'){?>
    <script src="https://player.vimeo.com/api/player.js"></script>
<?php }?>
	
	
	<!-- css -->
	<link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/css/common.css" />

	<!-- js -->
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/js/swiper/swiper-bundle.min.js"></script>
	<script type="text/javascript" src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/js/common.js"></script>
	
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/ui_common.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 퍼블공통 -->
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/dev_common.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 개발공통 -->
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/layout.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 레이아웃 스크립트 -->
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/wish.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 관심상품 -->
    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>
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

    <!--구글 로그인-->
    <meta name="google-signin-client_id" content="<?=GOOGLE_CLIENT_ID?>">

	<!-- facebook 인증(2021.03.23 최수빈매니저 요청) -->
	<meta name="facebook-domain-verification" content="y3ol68wo8ke8p4l4mvj8xgav6rndp4"/>

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

    <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->

    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   
    <?php echo $TPL_VAR["layout"]["layOutHeaderScript"]?>

    <?php echo $TPL_VAR["layout"]["kakaoMomentScript"]?>

    <?php echo $TPL_VAR["kakaoMomentSubScript"]?>


</head>
<body id="<?php echo $TPL_VAR["layoutCommon"]["bodyId"]?>" class="NEWbarrel">
<!-- <body class="NEWbarrel"> -->
<header id="header" class="fb__header">
<?php $this->print_("headerTop",$TPL_SCP,1);?>

    <nav id="navigation" class="fb__main_nav">
<?php $this->print_("headerMenu",$TPL_SCP,1);?>

    </nav>
</header>
<section id="container" class="fb__content">
<?php if($TPL_VAR["useFat"]===true){?><?php $this->print_("_fat",$TPL_SCP,1);?><?php }?>
<?php $this->print_("contents",$TPL_SCP,1);?>

</section>
<footer id="footer" class="fb__footer ">
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

<!--팝업레이어창-->
<div class="main_popupL devForbizTpl devNotiPopup" devPopupIx="{[popup_ix]}" id="devNotiPopupTpl" style="top:{[popup_top]}px; left:{[popup_left]}px;">
    <section class="main_popupL-inner">{[{popup_text}]}</section>
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
$(function(){
<?php if(DB_CONNECTION_DIV=='development'){?>
    //load 된 언어 서버요청
    common.lang.jsLanguageCollection();
<?php }?>

    common.noti.popup.load(<?php echo $TPL_VAR["layout"]["jsonPopupList"]?>);
});
</script>
<?php echo $TPL_VAR["footerDesc"]["footerScript"]?>

</body>
</html>