<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/layout/leftmenu/goods_left.htm 000002226 */ ?>
<section class="fb__left-goodsList">
    <div class="goodsNav">
        <header class="goodsNav__header">
            <span class="goodsNav__inner">
                 <h2 class="goodsNav__title">
                    <?php echo $TPL_VAR["topCateName"]?>

                </h2>
                <!-- v1.6 삭제 -->
                <!--<a href="#" class="goodsNav__btn" >
                    <span>열기</span>
                    <span>닫기</span>
                </a>-->
             </span>
        </header>
        <ul class="goodsNav__wrap">
<?php if(is_array($TPL_R1=$TPL_VAR["cateArr"]["subCate"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
            <li class="goodsNav__list">
                <header class="goodsNav__subHeader">
                    <a href="/shop/subGoodsList/<?php echo $TPL_V1["cid"]?>" class="goodsNav__subHeader--link">
                        <h3 class="goodsNav__subList <?php if($TPL_V1["cid"]==$TPL_VAR["cid"]){?> goodsNav__subList--active <?php }?>">
                            <?php echo $TPL_V1["cname"]?>

                        </h3>
                    </a>
                    <a href="#" class="goodsNav__btn <?php if($TPL_V1["cid"]==$TPL_VAR["cid"]){?>goodsNav__btn--close  <?php }?>" >
                        <span>열기</span>
                        <span>닫기</span>
                    </a>
                </header>
                <ul class="goodsNav__cont <?php if($TPL_V1["cid"]==$TPL_VAR["depth2CateCid"]){?> goodsNav__cont--active <?php }?>">
<?php if(is_array($TPL_R2=$TPL_V1["subCate"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
                    <li class="goodsNav__subList-inner">
                        <a href="/shop/subGoodsList/<?php echo $TPL_V2["cid"]?>" class="goodsNav__subList-link <?php if($TPL_V2["cid"]==$TPL_VAR["cid"]){?> goodsNav__subList-link--active <?php }?>">
                           <?php echo $TPL_V2["cname"]?>

                        </a>
                    </li>
<?php }}?>
                </ul>
            </li>
<?php }}?>
        </ul>
    </div>
</section>