<?php /* Template_ 2.2.8 2024/03/22 09:51:11 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/content/focus_now2/focus_now2.htm 000007144 */ 
$TPL_displayContentGroupList_1=empty($TPL_VAR["displayContentGroupList"])||!is_array($TPL_VAR["displayContentGroupList"])?0:count($TPL_VAR["displayContentGroupList"]);?>
<!-- 컨텐츠 영역 S -->
<section class="br__FocusNow-detail">
  <div class="detail-layout">
<?php if($TPL_VAR["displayContentList"]["content_text_mo"]){?>
   <div class="detail-layout__lnb" style="position: relative;">
    <div class="img-box">
     <!--<img src="/assets/mobile_templet/mobile_enterprise/assets/img/FocusNow_banner_img01.png" alt="" />-->
     <?php echo $TPL_VAR["displayContentList"]["content_text_mo"]?>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-rwdImageMaps/1.6/jquery.rwdImageMaps.min.js"></script>
    <script>
     $(document).ready(function() {
      $('img[usemap]').rwdImageMaps();
     });
    </script>
   </div>
<?php }?>
<?php if($TPL_VAR["displayContentGroupList"]){?>
  <div class="detail-layout__content">
   <div class="br-tab__wrap">
<?php if($TPL_VAR["displayContentList"]["category_use"]=='Y'){?>
    <div class="br-tab__nav">
     <ul class="br__FocusNow-nav">
<?php if($TPL_displayContentGroupList_1){$TPL_I1=-1;foreach($TPL_VAR["displayContentGroupList"] as $TPL_V1){$TPL_I1++;?>
      <li class="<?php if($TPL_I1== 0){?>active<?php }?>" style="<?php if($TPL_VAR["displayContentList"]["r_category"]=='R'){?>border-radius:10px;<?php }?>background-color:<?php echo $TPL_VAR["displayContentList"]["ba_category"]?>;border-color:<?php echo $TPL_VAR["displayContentList"]["bo_category"]?>;">
       <a href="javascript:void(0);" title="specia<?php echo $TPL_V1["group_code"]?>"><?php echo $TPL_V1["group_title"]?></a>
      </li>
<?php }}?>
     </ul>
    </div>
<?php }?>
    <div class="br-tab__contents-wrap">
<?php if($TPL_displayContentGroupList_1){foreach($TPL_VAR["displayContentGroupList"] as $TPL_V1){?>
     <div class="br-tab__contents detail-layout__section" id="specia<?php echo $TPL_V1["group_code"]?>">
<?php if($TPL_VAR["group_text_mo"]){?>
      <div class="br__FocusNow-banner">
       <!--<img src="/assets/mobile_templet/mobile_enterprise/assets/img/FocusNow_banner_img02.png" alt="" />-->
       <?php echo $TPL_V1["group_text_mo"]?>

      </div>
<?php }?>
      <section class="detail-goods__wrap">
<?php if($TPL_VAR["group_title"]){?>
       <div class="title-md" style="margin-top:40px;position: relative;display: flex;-webkit-box-align: end;align-items: flex-end;gap: 0 100px;width: 100%;text-align:<?php if($TPL_V1["s_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_group_title"]=='C'){?>center<?php }elseif($TPL_VAR["s_group_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_group_title"]?>;<?php if($TPL_V1["b_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["group_title"]?></div>
<?php }?>
       <!-- 상품 리스트 S -->
       <div class="br__goods-list__wrap br__goods-list__wrap--normal">
        <div class="goods-list">
         <ul class="goods-list__list">
<?php if(is_array($TPL_R2=$TPL_V1["productList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V1["productList"]){?>
            <li class="goods-list__box">
             <a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>" class="goods-list__link">
              <div class="goods-list__thumb">
               <div class="goods-list__thumb-slide swiper-container">
                <div class="swiper-wrapper">
                 <div class="swiper-slide">
                  <img src="<?php echo $TPL_V2["image_src"]?>" alt="" />
                 </div>
                 <div class="swiper-slide">
                  <img src="<?php echo $TPL_V2["image_src2"]?>" alt="" />
                 </div>
                </div>
                <div class="swiper-control-group">
                 <div class="swiper-scrollbar"></div>
                </div>
               </div>
               <!-- 버튼으로 할 경우 S -->
               <!-- 숨김처리 -->
               <button type="button" class="btn-wishlist <?php if($TPL_V2["alreadyWish"]=='Y'){?>active<?php }?>" onclick="contentWish('<?php echo $TPL_V2["id"]?>', 'C', this)" style="z-index: 999999;">
                <!-- 선택시 button class = active 추가-->
                <i class="ico ico-wishlist"></i>위시리스트
               </button>
               <!-- 버튼으로 할 경우 E -->

               <!-- 체크 박스로 할 경우 S -->
               <label class="goods-list__wish" style="display: none">
                <input type="checkbox" class="goods-list__wish__btn" />
               </label>
               <!-- 체크 박스로 할 경우 E -->
              </div>
              <div class="goods-list__info">
               <div class="goods-list__pre br__goods__pre" style="color:<?php echo $TPL_V2["c_preface"]?>;<?php if($TPL_V2["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V2["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V2["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V2["preface"]?></div>
               <div class="goods-list__title"><?php echo $TPL_V2["pname"]?></div>
               <div class="goods-list__color"><?php echo $TPL_V2["add_info"]?></div>
               <div class="goods-list__price">
                <div class="goods-list__price__percent" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>><span><?php echo $TPL_V2["discount_rate"]?></span>%</div>
                <div class="goods-list__price__discount"><span><?php echo $TPL_V2["dcprice"]?></span></div>
                <div class="goods-list__price__cost" <?php if($TPL_V2["discount_rate"]== 0||$TPL_V2["discount_rate"]==''){?>style="display:none;"<?php }?>><del><?php echo $TPL_V2["sellprice"]?></del></div>
                <!-- 품절일 경우 S -->
                <!-- 숨김 처리 -->
                <div class="goods-list__price__state" style="display: none">품절</div>
                <!-- 품절일 경우 E -->
               </div>
              </div>
             </a>
            </li>
<?php }else{?>
            <!-- 상품이 없을 경우 S -->
            <!-- 숨김처리 -->
            <li class="goods-list__box no-data">
             <p class="empty-content">일치하는 상품이 없습니다.</p>
            </li>
            <!-- 상품이 없을 경우 E -->
<?php }?>
<?php }}?>
         </ul>
        </div>
       </div>
       <!-- 상품 리스트 E -->
      </section>
     </div>
<?php }}?>
    </div>
   </div>
  </div>
<?php }?>
 </div>
</section>
<!-- 컨텐츠 영역 E -->