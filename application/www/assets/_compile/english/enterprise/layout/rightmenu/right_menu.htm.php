<?php /* Template_ 2.2.8 2020/08/31 15:57:15 /home/barrel-stage/application/www/assets/templet/enterprise/layout/rightmenu/right_menu.htm 000002138 */ ?>
<div id="rightMenu">
    <div class="inner">
        <div class="wrap_right_menu">
            <div class="banner">
                <div>
                    <!--마이페이지 > 나의 적립금-->
<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>
                    <a href="/mypage/mileage">
<?php }else{?>
                    <a href="/member/login">
<?php }?>
                        <p class="title">적립금</p>
                        <p class="point_num"><span><?php echo number_format($TPL_VAR["layoutCommon"]["headerTopMyInfo"]["myMileAmount"])?></span>원</p>
                    </a>
                </div>
                <div class="banner_cart">
                    <a href="/shop/cart">
                        <i class="icon_cart"></i>
                        <p class="title">장바구니</p>
                        <em>{=number_format(layoutCommon.userInfo..cartCnt)}</em>
                    </a>
                </div>
                <div>
                    <a href="/mypage/orderHistory">
                        <i class="icon_order"></i>
                        <p class="title">주문조회</p>
                    </a>
                </div>
                <div class="flexslider">
                    <p class="title">오늘 본 상품</p>
                    <div>
                        <ul class="slides">
                            <li>
<?php if(is_array($TPL_R1=$TPL_VAR["rightMenu"]["historyList"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                                <a href="/shop/goodsView/<?php echo $TPL_V1["id"]?>">
                                    <img src="<?php echo $TPL_V1["image_src"]?>">
                                </a>
<?php }}?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="btn_top" id="btnScrollTop">
                TOP
            </div>
        </div>
    </div>

</div>
<script>

</script>