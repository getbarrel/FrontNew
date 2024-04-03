<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/layout/layout_lnb.htm 000006908 */ ?>
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
    <link rel="shortcut icon" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/favicon.ico" type="image/x-icon">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-99146148-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-99146148-1');
    </script>

    <!-- css -->
    <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/css/customer.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/css/common/common.css?version=<?php echo CLIENT_VERSION?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/css/common/reset.css?version=<?php echo CLIENT_VERSION?>">
<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["GroupCssSrc"])){?>
    <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layout"]["GroupCssSrc"]?>?version=<?php echo CLIENT_VERSION?>">
<?php }?>
    <!-- js library -->
    <script>var forbizCsrf = { name:"<?php echo $TPL_VAR["layout"]["ForbizCsrfName"]?>", hash:"<?php echo $TPL_VAR["layout"]["ForbizCsrfHash"]?>", isLogin:<?php echo json_encode($TPL_VAR["layoutCommon"]["isLogin"])?>};</script>
    <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/css/main.css?version=<?php echo CLIENT_VERSION?>">
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/js/vendor.js?version=<?php echo CLIENT_VERSION?>"></script>
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/assets/js/main.js?version=<?php echo CLIENT_VERSION?>"></script>
    <!--<script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/library.js?version=<?php echo CLIENT_VERSION?>"></script>-->

<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["LanguageJsSrc"])){?>
    <!-- 언어 -->
    <script src="<?php echo $TPL_VAR["layout"]["LanguageJsSrc"]?>?version=<?php echo CLIENT_VERSION?>"></script>
<?php }?>

    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/ui_common.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 퍼블공통 -->
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/dev_common.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 개발공통 -->
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/layout.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 레이아웃 스크립트 -->
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/wish.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 고객센터공통 -->
    <script>
        //set environment
        common.environment = "<?php echo DB_CONNECTION_DIV?>";
        common.langType = "<?php echo BASIC_LANGUAGE?>";
        common.kakaoScriptKey = "<?php echo KAKAO_SCRIPT_KEY?>";
    </script>

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

    <!-- 몰 관련 태그 -->
    <title><?php echo $TPL_VAR["layoutCommon"]["title_desc"]?></title>
    <meta name="description" content="<?php echo $TPL_VAR["title_desc"]?>">
    <meta name="keywords" content="<?php echo $TPL_VAR["keyword_desc"]?>">
    <?php echo $TPL_VAR["layout"]["layOutHeaderScript"]?>

    <?php echo $TPL_VAR["layout"]["kakaoMomentScript"]?>

    <?php echo $TPL_VAR["kakaoMomentSubScript"]?>

</head>
<body id="<?php echo $TPL_VAR["layoutCommon"]["bodyId"]?>" class="fb">
<header id="header" class="fb__header">
<?php $this->print_("headerTop",$TPL_SCP,1);?>

    <nav id="navigation" class="fb__main_nav">
<?php $this->print_("headerMenu",$TPL_SCP,1);?>

    </nav>
</header>

<section id="container" class="layout-main-lnb fb__layout__leftmenu-type">
    <nav class="layout-lnb">
<?php $this->print_("leftMenu",$TPL_SCP,1);?>

    </nav>
    <div class="layout-content">
<?php $this->print_("contents",$TPL_SCP,1);?>

    </div>
</section>
<footer id="footer" class="fb__footer">
    <div class="fb__footer__inner">
<?php $this->print_("footerMenu",$TPL_SCP,1);?>

<?php $this->print_("footerDesc",$TPL_SCP,1);?>

    </div>
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
<?php if(DB_CONNECTION_DIV=='development'){?>
    //load 된 언어 서버요청
    common.lang.jsLanguageCollection();
<?php }?>

    common.noti.popup.load(<?php echo $TPL_VAR["layout"]["jsonPopupList"]?>);
</script>
<?php echo $TPL_VAR["footerDesc"]["footerScript"]?>

</body>
</html>