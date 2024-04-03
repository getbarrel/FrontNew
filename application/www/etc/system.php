<?php
$mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){
?>
<!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no" />
        <link rel="icon" href="/assets/mobile_templet/mobile_enterprise/favicon/favicon.ico" />
        <!--[E] FAVICON-->
        <title>BARREL</title>
    </head>
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="/assets/mobile_templet/mobile_enterprise/assets/css/common.css" />

    <!-- js -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="/assets/mobile_templet/mobile_enterprise/assets/js/swiper/swiper-bundle.min.js"></script>
    <!-- footer.html 에 해당 js를 추가해 중복되어서 해당 js를 일단 주석처리 해놨습니다.
    <script type="text/javascript" src="/assets/mobile_templet/mobile_enterprise/assets/js/common.js"></script>-->
    <body class="NEWbarrelM">
    <!--리뉴얼용 구분 class(NEWbarrel) 추가-->
    <!-- 해당 페이지 css 는 공통 /assets/css/common.css 에 추가 되어 있습니다.-->
    <?php if(BASIC_LANGUAGE == 'english'):?>
        <section class="system-page">
            <div class="system-page__wrap">
                <div class="title-md">Preparing for service check.</div>
                <div class="system-page__desc">
                    <p>
                        Thank you for visiting Barrel Shopping Mall.<br>
                        We are currently checking the service, so please wait.<br>
                        We will do our best for your convenient service.
                    </p>
                </div>
                <div class="system-page__logo">
                    <img src="/assets/mobile_templet/mobile_enterprise/assets/img/icon/icon_bi_big.svg" alt="BARREL" />
                </div>
            </div>
        </section>
    <?php else: ?>
    <section class="system-page">
        <div class="system-page__wrap">
            <div class="title-md">시스템 점검 안내</div>
            <div class="system-page__desc">
                <p>
                    이용에 불편을 드려 대단히 죄송합니다.<br />
                    보다 안정적인 서비스 제공을 위해 시스템 점검을<br />
                    진행하고 있습니다.
                </p>
                <p>잠시 후 이용 부탁드립니다.</p>
            </div>
            <div class="system-page__time">
                시스템 점검 기간 :
                <?php
                if (time() >= strtotime('2024-03-22 03:00:00') && time() < strtotime('2024-03-22 07:00:00')) {
                    ?>
                    <p>2024.03.22 오전 03:00 ~ 2024.03.22 오전 07:00</p>
                    <?php
                } else {
                    ?>
                    <p>2024.03.22 오전 03:00 ~ 2024.03.22 오전 07:00</p>
                    <?php
                }
                ?>
            </div>
            <div class="system-page__logo">
                <img src="/assets/mobile_templet/mobile_enterprise/assets/img/icon/icon_bi_big.svg" alt="BARREL" />
            </div>
        </div>
    </section>
    <?php endif ?>
    </body>
</html>
<?php
}else{
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="shortcut icon" href="/assets/templet/enterprise/assets/img/favicon.ico" />
        <title>BARREL</title>
    </head>
    <!-- css -->
    <link rel="stylesheet" type="text/css" href="/assets/templet/enterprise/assets/css/common.css" />

    <!-- js -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="/assets/templet/enterprise/assets/js/swiper/swiper-bundle.min.js"></script>

    <body class="NEWbarrel">
    <?php if(BASIC_LANGUAGE == 'english'):?>
        <section class="system-page">
            <div class="system-page__wrap">
                <div class="title-md">Preparing for service check.</div>
                <div class="system-page__desc">
                    <p>
                        Thank you for visiting Barrel Shopping Mall.<br>
                        We are currently checking the service, so please wait.<br>
                        We will do our best for your convenient service.
                    </p>
                </div>
                <div class="system-page__logo">
                    <img src="/assets/templet/enterprise/assets/img/shop_logo.svg" alt="BARREL" />
                </div>
            </div>
        </section>
    <?php else: ?>
        <!--리뉴얼용 구분 class(NEWbarrel) 추가-->
        <!-- 해당 페이지 css 는 공통 /assets/css/common.css 에 추가 되어 있습니다.-->
        <section class="system-page">
            <div class="system-page__wrap">
                <div class="title-md">시스템 점검 안내</div>
                <div class="system-page__desc">
                    <p>
                        이용에 불편을 드려 대단히 죄송합니다.<br />
                        보다 안정적인 서비스 제공을 위해 시스템 점검을<br />
                        진행하고 있습니다.
                    </p>
                    <p>잠시 후 이용 부탁드립니다.</p>
                </div>
                <div class="system-page__time">
                    시스템 점검 기간 :
                    <?php
                    if (time() >= strtotime('2024-03-22 03:00:00') && time() < strtotime('2024-03-22 07:00:00')) {
                        ?>
                        <p>2024.03.22 오전 03:00 ~ 2024.03.22 오전 07:00</p>
                        <?php
                    } else {
                        ?>
                        <p>2024.03.22 오전 03:00 ~ 2024.03.22 오전 07:00</p>
                        <?php
                    }
                    ?>
                </div>
                <div class="system-page__logo">
                    <img src="/assets/templet/enterprise/assets/img/shop_logo.svg" alt="BARREL" />
                </div>
            </div>
        </section>
    <?php endif ?>
    </body>
</html>
<?php
}
?>
