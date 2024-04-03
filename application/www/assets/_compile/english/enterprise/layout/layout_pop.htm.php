<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/layout/layout_pop.htm 000003793 */ ?>
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
    <link rel="shortcut icon" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/favicon.ico">
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/css/common/common.css?version=<?php echo CLIENT_VERSION?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/css/common/reset.css?version=<?php echo CLIENT_VERSION?>">
<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["GroupCssSrc"])){?>
    <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layout"]["GroupCssSrc"]?>?version=<?php echo CLIENT_VERSION?>">
<?php }?>
    <!-- js library -->
    <script>var forbizCsrf = { name:"<?php echo $TPL_VAR["layout"]["ForbizCsrfName"]?>", hash:"<?php echo $TPL_VAR["layout"]["ForbizCsrfHash"]?>", isLogin:<?php echo json_encode($TPL_VAR["layoutCommon"]["isLogin"])?>};</script>
    <link rel="stylesheet" type="text/css" href="/assets/templet/enterprise/assets/css/main.css?version=1.0">
    <script src="/assets/templet/enterprise/assets/js/vendor.js?version=1.0"></script>
    <script src="/assets/templet/enterprise/assets/js/main.js?version=1.0"></script>
    <!--<script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/library.js?version=<?php echo CLIENT_VERSION?>"></script>-->

<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["LanguageJsSrc"])){?>
    <!-- 언어 -->
    <script src="<?php echo $TPL_VAR["layout"]["LanguageJsSrc"]?>?version=<?php echo CLIENT_VERSION?>"></script>
<?php }?>
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/ui_common.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 퍼블공통 -->
    <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/dev_common.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 개발공통 -->
    <script>
        //set environment
        common.environment = "<?php echo ENVIRONMENT?>";
        common.langType = "<?php echo BASIC_LANGUAGE?>";
        common.kakaoScriptKey = "<?php echo KAKAO_SCRIPT_KEY?>";
    </script>

    <!--웹폰트cdn 이후 다운로드 받아서 처리 하는 방식으로 수정 예정-->
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans|Roboto" rel="stylesheet">
    <!-- 몰 관련 태그 -->
    <title><?php echo $TPL_VAR["layoutCommon"]["title_desc"]?></title>
    <meta name="description" content="<?php echo $TPL_VAR["title_desc"]?>">
    <meta name="keywords" content="<?php echo $TPL_VAR["keyword_desc"]?>">
</head>
<body id="<?php echo $TPL_VAR["layoutCommon"]["bodyId"]?>"  class="fb fb__popup">
<div>
<?php $this->print_("contents",$TPL_SCP,1);?>

</div>

<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["GroupJsSrc"])){?>
<!-- 퍼블&개발 공통:폴더별 -->
<script src="<?php echo $TPL_VAR["layout"]["GroupJsSrc"]?>?version=<?php echo CLIENT_VERSION?>"></script>
<?php }?>
<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["PageJsSrc"])){?>
<!-- 퍼블&개발 공통:각 페이지 별 -->
<script src="<?php echo $TPL_VAR["layout"]["PageJsSrc"]?>?version=<?php echo CLIENT_VERSION?>"></script>
<?php }?>
<?php if(DB_CONNECTION_DIV=='development'){?>
<script>
    //load 된 언어 서버요청
    common.lang.jsLanguageCollection();
</script>
<?php }?>
</body>
</html>