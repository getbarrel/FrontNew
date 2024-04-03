<?php /* Template_ 2.2.8 2021/03/23 14:00:14 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/customer/store_information_detail/store_information_detail.htm 000003202 */ ?>
<section class="br__store-detail">
      <h2 class="br__hidden">Store finder</h2>
      <figure class="br__store-detail__bg">
            <img src="//image2.getbarrel.com/socal/store/<?php echo $TPL_VAR["storeInfo"]["store_code"]?>/store-info-bg.jpg" alt="배럴매장이미지">
      </figure>
      <artcle class="store-each">
            <h3 class="br__hidden">Background and detail information</h3>
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
            </div>
      </artcle>
      <artcle class="store-map store-map--fold">
            <header class="store-map__top">
                  <span class="store-map__foldicon store-map__foldicon--point">접기 아이콘</span>
                  <h3 class="store-map__title">Story Direction</h3>
            </header>
            <div class="store-map__scroll-area">
                  <div id="map" class="store-map__map">

                  </div>
                  <p class="store-map__addr">
                        <span id="devAddress1"><?php echo $TPL_VAR["storeInfo"]["store_address1"]?></span><br>
                        <?php echo $TPL_VAR["storeInfo"]["store_address2"]?>

                  </p>
                  <div class="store-map__by">
                        <div class="store-map__by__open">
                              <h4 class="store-map__title">Subway instruction</h4>
                              <span class="store-map__foldicon store-map__foldicon--normal">Fold icon</span>
                        </div>
                        <p class="store-map__by__detail">
                                <?php echo $TPL_VAR["storeInfo"]["subway"]?>

                        </p>
                  </div>
                  <div class="store-map__by">
                        <div class="store-map__by__open">
                              <h4 class="store-map__title">Bus Direction</h4>
                              <span class="store-map__foldicon store-map__foldicon--normal">Fold icon</span>
                        </div>
                        <p class="store-map__by__detail">
                              <?php echo nl2br($TPL_VAR["storeInfo"]["bus"])?>

                        </p>
                  </div>
            </div>
      </artcle>
</section>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo KAKAO_SCRIPT_KEY?>&libraries=services"></script>