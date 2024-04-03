<?php /* Template_ 2.2.8 2024/03/07 02:39:38 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/content/focus_now1/focus_now1.htm 000006500 */ 
$TPL_displayContentGroupList_1=empty($TPL_VAR["displayContentGroupList"])||!is_array($TPL_VAR["displayContentGroupList"])?0:count($TPL_VAR["displayContentGroupList"]);?>
<section id="container" class="br__layout">
 <!-- 컨텐츠 영역 S -->
 <section class="br__FocusNow-detail">
  <div class="detail-layout">
   <div class="detail-layout__lnb">
    <div class="detail-slide swiper-container">
     <div class="swiper-wrapper">
<?php if(is_array($TPL_R1=$TPL_VAR["displayContentList"]["imgSrc"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
      <div class="swiper-slide"><img src="<?php echo $TPL_V1["imgSrcUrl"]?>" alt="" /></div>
<?php }}?>
     </div>
     <div class="detail-slide__control">
      <div class="swiper-control-group">
       <div class="swiper-scrollbar"></div>
       <div class="swiper-pagination"></div>
      </div>
     </div>
    </div>
   </div>
   <div class="detail-layout__content">
<?php if($TPL_displayContentGroupList_1){$TPL_I1=-1;foreach($TPL_VAR["displayContentGroupList"] as $TPL_V1){$TPL_I1++;?>
    <div class="detail-layout__header">
<?php if($TPL_I1== 0){?>
      <span style="color:<?php echo $TPL_VAR["displayContentList"]["c_preface"]?>;<?php if($TPL_VAR["displayContentList"]["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_VAR["displayContentList"]["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_VAR["displayContentList"]["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_VAR["displayContentList"]["preface"]?></span>
<?php }?>
     <div class="title-md" style="text-align:<?php if($TPL_V1["s_group_title"]=='L'){?>left<?php }elseif($TPL_V1["s_group_title"]=='C'){?>center<?php }elseif($TPL_VAR["s_group_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_group_title"]?>;<?php if($TPL_V1["b_group_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_group_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_group_title"]=='Y'){?>text-decoration-line: underline;<?php }?>">
      <?php echo $TPL_V1["group_title"]?>

     </div>
    </div>
    <section class="detail-goods__wrap">
     <!-- 상품 리스트 S -->
     <div class="br__goods-list__wrap br__goods-list__wrap--normal">
      <div class="goods-list">
       <ul class="goods-list__list" id="devListContents">
<?php if(is_array($TPL_R2=$TPL_V1["productList"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
<?php if($TPL_V1["productList"]){?>
          <li class="goods-list__box">
           <a href="/shop/goodsView/<?php echo $TPL_V2["id"]?>" class="goods-list__link">
            <div class="goods-list__thumb">
             <div class="goods-list__thumb-slide swiper-container">
              <div class="swiper-wrapper">
               <div class="swiper-slide">
                <img src="<?php echo $TPL_V2["image_src"]?>" alt="상품이미지" />
               </div>
               <!--<div class="swiper-slide">
                <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
               </div>
               <div class="swiper-slide">
                <img src="/assets/mobile_templet/mobile_enterprise/assets/img/product/sample.png" alt="" />
               </div>-->
              </div>
              <div class="swiper-control-group">
               <div class="swiper-scrollbar"></div>
              </div>
             </div>
             <!-- 버튼으로 할 경우 S -->
             <!-- 숨김처리 -->
             <button type="button" class="btn-wishlist <?php if($TPL_V2["alreadyWish"]){?>active<?php }?>" onclick="contentWish('<?php echo $TPL_V2["id"]?>', 'C', this)" style="z-index: 999999;">
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
           <p class="empty-content">검색어와 일치하는 상품이 없습니다.</p>
          </li>
          <!-- 상품이 없을 경우 E -->
<?php }?>
<?php }}?>
        <!-- 로딩 S -->
        <!-- 숨김처리 -->
        <li id="devListLoading" class="br-loading" style="display: none">loading...</li>
        <!-- 로딩우 E -->
       </ul>
      </div>
     </div>
     <!-- 상품 리스트 E -->
    </section>
<?php }}?>
   </div>
  </div>
 </section>
 <!-- 컨텐츠 영역 E -->
</section>