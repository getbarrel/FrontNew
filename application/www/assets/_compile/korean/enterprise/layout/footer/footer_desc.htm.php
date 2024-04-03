<?php /* Template_ 2.2.8 2024/03/19 10:50:06 /home/barrel-qa/application/www/assets/templet/enterprise/layout/footer/footer_desc.htm 000007451 */ ?>
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

	//Enliple Tracker Start_모비온
	(function(a,g,e,n,t){a.enp=a.enp||function(){(a.enp.q=a.enp.q||[]).push(arguments)};n=g.createElement(e);n.async=!0;n.defer=!0;n.src="https://cdn.megadata.co.kr/dist/prod/enp_tracker_self_hosted.min.js";t=g.getElementsByTagName(e)[0];t.parentNode.insertBefore(n,t)})(window,document,"script");
	enp('create', 'common', 'barrel', { device: 'W' });  // W:웹, M: 모바일, B: 반응형
	enp('send', 'common', 'barrel');
	//Enliple Tracker End_모비온
</script>
<!-- End Channel Plugin -->
<!--floating menu-->
<div class="fb__footer__desc">
	<div class="fb__footer__inner">
		<div class="fb__footer-group">
			<div class="fb__footer__logo">
				<a href="/" class=""><img src="/assets/templet/enterprise/assets/img/shop_logo.svg" alt="BARREL" /></a>
				<p>© BARREL ALL RIGHTS RESERVED.</p>
			</div>
			<div class="fb__footer-item">
				<nav class="etc__info">
					<ul>
						<li>
							<a href="/customer/notice" class="siteMap__link">고객센터</a>
						</li>
						<li>
							<a href="/customer/storeInformation" class="siteMap__link">매장안내</a>
						</li>
					</ul>
				</nav>
				<address class="fb__footer__descInfo">
					<p><strong><?php echo $TPL_VAR["companyInfo"]["com_name"]?></strong></p>
					<p><?php echo $TPL_VAR["companyInfo"]["com_addr1"]?> <?php echo $TPL_VAR["companyInfo"]["com_addr2"]?></p>
					<p>대표이사 : <?php echo $TPL_VAR["companyInfo"]["com_ceo"]?></p>
					<p>개인정보책임관리자 : <?php echo $TPL_VAR["companyInfo"]["officer_name"]?></p>
					<p>사업자번호 : <?php echo $TPL_VAR["companyInfo"]["com_number"]?> / <a href="http://www.ftc.go.kr/bizCommPop.do?wrkr_no=1058739951" target="_blank">사업자정보확인</a></p>
					<p>통신판매업 신고번호 : <?php echo $TPL_VAR["companyInfo"]["online_business_number"]?></p>
					<p>FAX : <?php echo $TPL_VAR["companyInfo"]["com_fax"]?> / Email : <a href="mailto:<?php echo $TPL_VAR["companyInfo"]["com_email"]?>" class="email"><?php echo $TPL_VAR["companyInfo"]["com_email"]?></a></p>
				</address>
			</div>
			<div class="fb__footer-item">
				<h4 class="tit">고객센터 운영안내</h4>
				<div class="fb__footer__descInfo">
					<h3>
<?php if($TPL_VAR["langType"]=='english'){?>
						en_help@getbarrel.com
<?php }else{?>
<?php if(str_replace("-","",$TPL_VAR["companyInfo"]["cs_phone"])){?>
								<?php echo $TPL_VAR["companyInfo"]["cs_phone"]?>

<?php }else{?>
								<?php echo $TPL_VAR["companyInfo"]["com_phone"]?>

<?php }?>
<?php }?>		
					</h3>
<?php if($TPL_VAR["langType"]=='korean'){?>
<?php if($TPL_VAR["companyInfo"]["opening_time"]){?>
						<span class='pub-sect pub-time'>
							<span><?php echo nl2br($TPL_VAR["companyInfo"]["opening_time"])?></span>
						</span>
<?php }?>
<?php if(false){?>
					<span class="pub-sect pub-time" >
<?php if($TPL_VAR["companyInfo"]["officer_email"]){?>
						<a href='mailto:<?php echo $TPL_VAR["companyInfo"]["officer_email"]?>' class="pub-email"><?php echo $TPL_VAR["companyInfo"]["officer_email"]?></a>
<?php }else{?>
						<a href='mailto:<?php echo $TPL_VAR["companyInfo"]["email"]?>' class="pub-email"><?php echo $TPL_VAR["companyInfo"]["email"]?></a>
<?php }?>
					</span>
<?php }?>
<?php }?>
					<!-- <p>평일 10:00~17:00 | 토,일,공휴일<br />휴무 점심시간 : 12:00-13:00</p> -->
				</div>
			</div>
		</div>
		<div class="fb__footer-etc">
			<nav class="etc__info">
				<ul>
					<li>
<?php if($TPL_VAR["langType"]=='english'){?>
						<a href="javascript:void(0)" onClick="common.util.popup('/company/privacy/person_global',600,700,'',true);" style="color:#01acd8; font-weight:700;">
							개인정보처리방침
						</a>
<?php }else{?>
						<!--<a href="javascript:void(0)" onClick="common.util.popup('/company/privacy/person',600,700,'',true);" style="color:#01acd8; font-weight:700;">
							개인정보처리방침
						</a>-->
						<a href="/company/privacyFull/person" style="color:#01acd8; font-weight:700;">
							개인정보처리방침
						</a>
<?php }?>
					</li>
					<li>
<?php if($TPL_VAR["langType"]=='english'){?>
						<a href="javascript:void(0)" onClick="common.util.popup('/company/agreement/agreement_global' ,600, 700,'',true);">
							이용약관
						</a>
<?php }else{?>
						<!--<a href="javascript:void(0)" onClick="common.util.popup('/company/agreement' ,600, 700,'',true);">-->
						<a href="/company/privacyFull/use">
							이용약관
						</a>
<?php }?>
					</li>
					<li>
						<a href="/corporateIR/IRResources">
							기업IR
						</a>
					</li>
					<!--
					<li>
						<a href="//www.getbarrel.com" class="<?php if($TPL_VAR["langType"]=='korean'){?>country__btn--active<?php }else{?>country__btn<?php }?>">KR</a>
					<li>
						<a href="//en.getbarrel.com" class="<?php if($TPL_VAR["langType"]=='english'){?>country__btn--active<?php }else{?>country__btn<?php }?>">EN</a>
					</li>
					-->
				</ul>
			</nav>
			<!-- ISMS 인증마크 영역 S -->
			<div class="fb__footer__gdweb">
				<a href="#;"><img src="/assets/templet/enterprise/assets/img/logo_isms_pc.png" alt="ISMS" /></a>
			</div>
			<!-- ISMS 인증마크 영역 E -->
			<ul class="fb__footer-sns">
				<li>
					<a href="https://www.instagram.com/getbarrel.official/">
						<i class="ico ico-instagram">인스타그램</i>
					</a>
				</li>
<?php if($TPL_VAR["langType"]=='korean'){?>
				<li>
					<a href="https://pf.kakao.com/_VxfxjDd">
						<i class="ico ico-KakaoTalk">카카오톡</i>
					</a>
				</li>
<?php }?>
				<!--<li>
					<a href="https://www.facebook.com/pages/Barrel/1416024818648425">
						<i class="ico ico-facebook">페이스북</i>
					</a>
				</li>-->
				<li>
					<a href="https://www.youtube.com/c/getbarrel">
						<i class="ico ico-youtube">유튜브</i>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>