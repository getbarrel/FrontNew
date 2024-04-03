<?php /* Template_ 2.2.8 2020/08/31 15:57:04 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/popup/noti/noti.htm 000002945 */ ?>
<?php if($TPL_VAR["popupType"]!='L'){?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <!-- css -->
        <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/css/common/common.css?version=<?php echo CLIENT_VERSION?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/css/common/reset.css?version=<?php echo CLIENT_VERSION?>">
<?php if(is_file(DOCUMENT_ROOT.''.$TPL_VAR["layout"]["GroupCssSrc"])){?>
        <link rel="stylesheet" type="text/css" href="<?php echo $TPL_VAR["layout"]["GroupCssSrc"]?>?version=<?php echo CLIENT_VERSION?>">
<?php }?>
        <!-- js library -->
        <script>var forbizCsrf = {name: "<?php echo $TPL_VAR["layout"]["ForbizCsrfName"]?>", hash: "<?php echo $TPL_VAR["layout"]["ForbizCsrfHash"]?>", isLogin: <?php echo json_encode(is_login())?>};</script>
        <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/library.js?version=<?php echo CLIENT_VERSION?>"></script>
        <script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/dev_common.js?version=<?php echo CLIENT_VERSION?>"></script><!-- 개발공통 -->
        <script>
            //set environment
            common.environment = "<?php echo ENVIRONMENT?>";

            var notiPopupWidth, notiPopupHeight;
            $(document).ready(function (){
                setInterval(function(){
                    var width = $('body').outerWidth() + (window.outerWidth - window.innerWidth);
                    var height = $('body').outerHeight() + (window.outerHeight - window.innerHeight);
                    if(notiPopupWidth != width || notiPopupHeight != height){
                        window.resizeTo(width, height);
                        notiPopupWidth = width;
                        notiPopupHeight = height;
                    }
                }, 300);
            });
        </script>
        <title><?php echo $TPL_VAR["popupTitle"]?></title>
    </head>
    <body>

<?php }?>

        <?php echo $TPL_VAR["popupText"]?>


    <div class="noti__popup">
<?php if($TPL_VAR["popupToday"]=='1'){?>
        <!--오늘 하루보기 사용 체크박스 -->
        <input type='checkbox' id="closeToday" class='devPopupToday' devPopupIx='<?php echo $TPL_VAR["popupIx"]?>' onClick="$(this).prop('checked', true);common.noti.popup.close('<?php echo $TPL_VAR["popupType"]?>', '<?php echo $TPL_VAR["popupIx"]?>');"/>
        <label for="closeToday">Do not open today</label>
<?php }?>
        <span class="noti__popup__closebtn" onClick="common.noti.popup.close('<?php echo $TPL_VAR["popupType"]?>', '<?php echo $TPL_VAR["popupIx"]?>');">Close</span>
    </div>
<?php if($TPL_VAR["popupType"]!='L'){?>

    </body>
</html>
<?php }?>