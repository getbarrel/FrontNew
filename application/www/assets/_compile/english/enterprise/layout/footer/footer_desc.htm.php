<?php /* Template_ 2.2.8 2021/10/12 16:56:23 /home/barrel-stage/application/www/assets/templet/enterprise/layout/footer/footer_desc.htm 000008491 */ ?>
<style>
	.fb__floating {right:71px;}
	.fb__floating a {background-image:url('/assets/templet/enterprise/images/common/btn-floating-img2.png'); padding:11px 0 0 17px;}
	.fb__floating a .latest_img {width:23px; height:23px;}
	.fb__floating__btn--recent {background-position:0 0;}
	.fb__floating__btn--top {background-position:0 -70px; margin-bottom:0 !important;}
	.fb__floating__btn--bt {background-position:0 -130px;}
</style>
<!-- Channel Plugin Scripts -->
<script>
	(function() {
		var w = window;
		if (w.ChannelIO) {
			return (window.console.error || window.console.log || function(){})('ChannelIO script included twice.');
		}
		var ch = function() {
			ch.c(arguments);
		};
		ch.q = [];
		ch.c = function(args) {
			ch.q.push(args);
		};
		w.ChannelIO = ch;
		function l() {
			if (w.ChannelIOInitialized) {
				return;
			}
			w.ChannelIOInitialized = true;
			var s = document.createElement('script');
			s.type = 'text/javascript';
			s.async = true;
			s.src = 'https://cdn.channel.io/plugin/ch-plugin-web.js';
			s.charset = 'UTF-8';
			var x = document.getElementsByTagName('script')[0];
			x.parentNode.insertBefore(s, x);
		}
		if (document.readyState === 'complete') {
			l();
		} else if (window.attachEvent) {
			window.attachEvent('onload', l);
		} else {
			window.addEventListener('DOMContentLoaded', l, false);
			window.addEventListener('load', l, false);
		}
	})();

	ChannelIO('boot', {
		"pluginKey": "bc5029b1-f2f3-43c8-9970-9050be183588", //please fill with your plugin key
		"memberId": "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["MBCODE"]?>", //fill with user id
		"profile": {
			"name": "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["name"]?>", //fill with user name
			"mobileNumber": "<?php echo $TPL_VAR["layoutCommon"]["userInfo"]["pcs"]?>", //fill with user phone number
			"CUSTOM_VALUE_1": "", //any other custom meta data
			"CUSTOM_VALUE_2": ""
		}
	});
</script>
<!-- End Channel Plugin -->
<!--floating menu-->
<aside class="fb__floating <?php if($TPL_VAR["layoutCommon"]["bodyId"]!='main'){?>fb__floating--fixed<?php }?>">
	<a href="#" class="fb__floating__btn--recent devRecentView"><img id="devBeforePrd" src="" alt="" class="latest_img" style="display:none" />Recently viewed product</a>
	<!--<a href="#" class="fb__floating__btn&#45;&#45;talk">배럴톡</a>-->
	<a href="#" class="fb__floating__btn--top">TOP</a>
	<a href="#footer" class="fb__floating__btn--bt">BOTTOM</a>
</aside>
<aside class="fb__floating__layer testsetat">
	<header class="fb__floating__layer-top">
		<h3 class="fb__floating__layer-title">Recently Viewed Products <em>(<span id="devTotalRecentCnt">0</span>)</em></h3>
		<a href="/mypage/recentView/" class="fb__floating__layer-all">All</a>
		<button class="fb__floating__layer-close">닫기버튼</button>
	</header>
	<form id="devRightRecentViewForm">
		<input type="hidden" name="page" value="1" id="devRightPage"/>
		<input type="hidden" name="max" value="50"/>
		<input type="hidden" name="order" value="50"/>
		<ul class="recent__list" id="devRightRecentViewContent">
			<li class="recent__goods devForbizTpl" id="devRightRecentViewList">
				<div class="devRightRecentViewDetail" data-id="{[id]}">
					<figure class="recent__goods__thumb">
						<img src="{[image_src]}" alt="{[pname]}">
					</figure>
					<div class="recent__goods__info">
						<p class="recent__goods__name">{[pname]}</p>
						<p class="recent__goods__option">{[add_info]}</p>
						<div class="recent__goods__price">
							{[#if state_soldout ]}
							<p class="recent__goods__price--soldout">Out of stock</p>
							{[else]}
							{[#if isDiscount]}
							<span class="recent__goods__price--strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[listprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
							<span class="recent__goods__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[dcprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
							<span class="recent__goods__price--discount"><em>{[discount_rate]}</em>%</span>
							{[else]}
							<span class="recent__goods__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em>{[dcprice]}</em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
							{[/if]}
							{[/if]}
						</div>
						<div class="recent__goods__btn">
							<a href="/shop/goodsView/{[id]}" class="recent__goods__btn--buy">BUY NOW</a>
							<label class="recent__goods__btn--wish {[#if alreadyWish]}on{[/if]}" data-devwishbtn="{[id]}">
								{[#if alreadyWish]}
								<input type="checkbox" class="goods-list__wish__btn" checked>
								{[else]}
								<input type="checkbox" class="goods-list__wish__btn">
								{[/if]}
								<span>Wish list</span>
							</label>
						</div>
					</div>
					<button type="button" class="recent__goods__del devRightRecentDel" data-pid="{[id]}">Delete Button</button>
				</div>
			</li>
			<li id="devRightRecentViewLoading">
				<div class="empty-content">
					<div class="wrap-loading">
						<div class="loading"></div>
					</div>
				</div>
			</li>
			<li class="empty-content devForbizTpl" id="devRightRecentViewEmpty">No Recently Viewed Items</li>
		</ul>
	</form>
</aside>
<div class="fb__footer__desc">
	<div class="fb__footer__inner desc">
		<a href="/" class="fb__footer__logo"><img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/shop_logo_w.png"></a>
		<address class="fb__footer__descInfo">
			<div class="eng-hidden">
				상호명 : <?php echo $TPL_VAR["companyInfo"]["com_name"]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;사업장소재지 : <?php echo $TPL_VAR["companyInfo"]["com_addr1"]?> <?php echo $TPL_VAR["companyInfo"]["com_addr2"]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FAX : <?php echo $TPL_VAR["companyInfo"]["com_fax"]?> <br />
				사업자등록번호 : <?php echo $TPL_VAR["companyInfo"]["com_number"]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;통신판매업신고번호 : <?php echo $TPL_VAR["companyInfo"]["online_business_number"]?> <a href="http://www.ftc.go.kr/www/bizCommView.do?key=232&apv_perm_no=2014322016230203158&pageUnit=10&searchCnd=bup_nm&searchKrwd=%EB%B0%B0%EB%9F%B4&pageIndex=2" target="_blank">사업자정보확인</a> <br />
				대표 : <?php echo $TPL_VAR["companyInfo"]["com_ceo"]?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;개인정보관리책임자 :  <?php echo $TPL_VAR["companyInfo"]["officer_name"]?>

				<a href="mailto:<?php echo $TPL_VAR["companyInfo"]["com_email"]?>" class="email"><?php echo $TPL_VAR["companyInfo"]["com_email"]?></a> <br /><br />
			</div>
				COPYRIGHT(C) 2019 barrel. ALL RIGHTS RESERVED
		</address>
		<div class="fb__footer__out eng-hidden">
			<div class="out">
				<figure class="out__img">
					<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/img-footer-agree.png" alt="">
				</figure>
				You can use the purchase safety service, consumer damage insurance when making cash payments for safety transactions.
			</div>
		</div>
<?php if($TPL_VAR["langType"]=='korean'){?>
		<div class="fb__footer__gdweb">
			<form name="GD_AUTHMARK_FORM" method="get">
				<input type="hidden" name="str_keycode" value='2020051937491960972409C31D25FF'/>
			</form>
			<a href="javascript:onPopIsms();" style="position:absolute; right:51px; top:2px;">
				<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/common/logo_isms_pc.png">
			</a>
			<a href="javascript:onPopGdAuthMark();">
				<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/common/img-footer-gdweb-pc.png">
			</a>
			<!-- ISMS 인증마크 적용 시작 -->
			<script>
                function onPopIsms() {
                    window.open('/company/isms','GD_ISMS','width=730, height=650, status=no, toolbar=no, menubar=no, location=no, scrollbars=no');
                }
			</script>
			<!-- ISMS 인증마크 적용 종료 -->
			<!-- GDWEB 인증마크 적용 시작 -->
			<script>
                function onPopGdAuthMark() {
                    window.open('','GD_AUTHMARK','width=730, height=650, status=yes, toolbar=no, menubar=no, location=no, scrollbars=yes');
                    document.GD_AUTHMARK_FORM.action='http://www.gdweb.co.kr/issue/';
                    document.GD_AUTHMARK_FORM.target='GD_AUTHMARK';
                    document.GD_AUTHMARK_FORM.submit();
                }
			</script>
			<!-- GDWEB 인증마크 적용 종료 -->
		</div>
<?php }?>
	</div>
</div>