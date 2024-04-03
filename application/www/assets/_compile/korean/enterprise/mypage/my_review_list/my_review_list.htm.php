<?php /* Template_ 2.2.8 2024/03/07 00:46:13 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/my_review_list/my_review_list.htm 000001790 */ ?>
<!-- crema load -->
<script>
    var crema_userId = null;
    var crema_userNm = null;

<?php if($TPL_VAR["layoutCommon"]["isLogin"]){?>    
        crema_userId = "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["id"]?>";
        crema_userNm = "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["name"]?>"; 
<?php }?>
            
    window.cremaAsyncInit = function() { // init.js가 다운로드 & 실행된 후에 실행하는 함수
      //console.log("[CREMA] cremaAsyncInit() - EXECUTED!");
      crema.init(crema_userId, crema_userNm);
      //console.log("[CREMA] crema.init() - EXECUTED!");
    };
    
    (function(i,s,o,g,r,a,m){if(s.getElementById(g))<?php echo $TPL_VAR["return"]?>;a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.id=g;a.async=1;a.src=r;m.parentNode.insertBefore(a,m)})
    (window,document,'script','crema-jssdk','//<?php echo CREMA_WIDGET_HOST?>/getbarrel.com/mobile/init.js');
</script>
<!-- 컨텐츠 S -->
<section class="fb__mypage wrap-mypage fb__wishlist">
	<!--<div class="fb__mypage-title">
		<div class="title-md">내 리뷰 내역</div>
	</div>-->

	<div class="crema-reviews" data-type="my-reviews"></div>
		
	<!--<section class="fb__wishlist-wrap">
		<div class="fb-tab__wrap fb-tab__col">
			<div class="fb-tab__nav">
				<ul>
					<li class="active">
						<a href="javascript:void(0);">작성 가능한 리뷰 (<span id="devTotal">0</span>)</a>
					</li>
					<li>
						<a href="javascript:void(0);">내가 작성한 리뷰 (<span><?php echo $TPL_VAR["ContentWishList"]["total"]?></span>)</a>
					</li>
				</ul>
			</div>
	</section>-->
</section>
<!-- 컨텐츠 E -->