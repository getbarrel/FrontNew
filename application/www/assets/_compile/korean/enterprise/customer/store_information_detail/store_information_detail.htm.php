<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/customer/store_information_detail/store_information_detail.htm 000003186 */ ?>
<section class="br__store-detail">
      <h2 class="br__hidden">매장찾기상세</h2>
      <figure class="br__store-detail__bg">
            <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/sample/bg.jpg" alt="">
      </figure>
      <artcle class="store-each">
            <h3 class="br__hidden">뒷배경 및 상세 정보</h3>
            <div class="store-each__top">
                  <h3 class="store-each__name"><?php echo $TPL_VAR["storeInfo"]["store_name"]?></h3>
<?php if($TPL_VAR["storeInfo"]["store_tel"]){?>
                  <a class="store-each__call" href="tel:<?php echo $TPL_VAR["storeInfo"]["store_tel"]?>">전화걸기아이콘</a>
<?php }?>
            </div>
            <p class="store-each__text">
                  <?php echo $TPL_VAR["storeInfo"]["store_address1"]?><br>
                  <?php echo $TPL_VAR["storeInfo"]["store_address2"]?>

            </p>
            <div class="store-each__text">
                  <span><?php echo $TPL_VAR["storeInfo"]["open_time"]?></span>
                  <span><?php echo $TPL_VAR["storeInfo"]["open_time2"]?></span>
                  <span><?php echo $TPL_VAR["storeInfo"]["open_time3"]?></span>
            </div>
      </artcle>
      <artcle class="store-map store-map--fold">
            <header class="store-map__top">
                  <span class="store-map__foldicon store-map__foldicon--point">접기 아이콘</span>
                  <h3 class="store-map__title">매장 지도 안내</h3>
            </header>
            <div class="store-map__scroll-area">
                  <div class="store-map__map">
                        지도 api
                  </div>
                  <p class="store-map__addr">
                        <?php echo $TPL_VAR["storeInfo"]["store_address1"]?><br>
                        <?php echo $TPL_VAR["storeInfo"]["store_address2"]?>

                  </p>
                  <div class="store-map__by">
                        <div class="store-map__by__open">
                              <h4 class="store-map__title">지하철 이용 안내</h4>
                              <span class="store-map__foldicon store-map__foldicon--normal">접기 아이콘</span>
                        </div>
                        <p class="store-map__by__detail">
                                <?php echo $TPL_VAR["storeInfo"]["subway"]?>

                        </p>
                  </div>
                  <div class="store-map__by">
                        <div class="store-map__by__open">
                              <h4 class="store-map__title">버스 이용 안내</h4>
                              <span class="store-map__foldicon store-map__foldicon--normal">접기 아이콘</span>
                        </div>
                        <p class="store-map__by__detail">
                              <?php echo nl2br($TPL_VAR["storeInfo"]["bus"])?>

                        </p>
                  </div>
            </div>
      </artcle>
</section>