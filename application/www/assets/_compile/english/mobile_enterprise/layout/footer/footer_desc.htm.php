<?php /* Template_ 2.2.8 2021/11/02 15:46:11 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/layout/footer/footer_desc.htm 000008861 */ ?>
<script src="../../js/mypage/review_bbs.js"></script>
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
<section class="br__footer">
	<h2 class="br__hidden">꼬리말</h2>
	<div class="br__footer__cscenter">
		<div class="cscenter">
			<h3 class="cscenter__title">
				
<?php if($TPL_VAR["langType"]=='english'){?>
				Contact us
					<span class="cscenter__title__phone">en_help@getbarrel.com</span>
<?php }else{?>
				CS Center :
					<span class="cscenter__title__phone"><?php echo $TPL_VAR["companyInfo"]["cs_phone"]?></span>
<?php }?>
			</h3>
<?php if($TPL_VAR["langType"]=='korean'){?>
			<p class="cscenter__work"><?php echo nl2br($TPL_VAR["companyInfo"]["opening_time"])?></p>
<?php }?>
		</div>
	</div>

	<div class="br__footer__btn-list">
		<ul class="footer-btn">
			<li class="footer-btn__box">
<?php if(is_login()){?>
				<a class="footer-btn__btn devLogout">Logout</a>
<?php }else{?>
				<a class="footer-btn__btn" href="/member/login">Sign in</a>
<?php }?>
			</li>
			<li class="footer-btn__box">
				<a class="footer-btn__btn" href="/customer/">CS Center</a>
			</li>
			<!--<li class="footer-btn__box">-->
				<!--<a class="footer-btn__btn" href="javascript:alert('지원하지않는 기능입니다.');">PC version</a>-->
			<!--</li>-->
			<li class="footer-btn__box">
				<a class="footer-btn__btn" href="javascript:alert('Preparing for service.');">Download App</a>
			</li>
		</ul>
	</div>
<?php if($TPL_VAR["langType"]=='korean'){?>
	<div class="br__footer__info">
		<div class="information">
			<button type="button" class="information__btn">Check business information</button>
			<div class="information__list">
				<dl>
					<dt>Representative</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["com_name"]?></dd>
					<dt>Yong-june Choi</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["com_ceo"]?></dd>
					<dt>CPO</dt>
					<dd>Sanghum Hwang</dd>
					<dt>Business registration number</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["com_number"]?></dd>
					<dt>Communication sales business report</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["online_business_number"]?> <br><a href="http://www.ftc.go.kr/www/bizCommView.do?key=232&apv_perm_no=2014322016230203158&pageUnit=10&searchCnd=bup_nm&searchKrwd=%EB%B0%B0%EB%9F%B4&pageIndex=2" target="_blank" class="information__list__link">Business license information check</a></dd>
					<dt>Address</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["com_addr1"]?> <?php echo $TPL_VAR["companyInfo"]["com_addr2"]?></dd>
					<dt>Fax</dt>
					<dd>FAX. <?php echo $TPL_VAR["companyInfo"]["com_fax"]?></dd>
				</dl>
			</div>
		</div>
	</div>
<?php }?>
	<div class="br__footer__btn-list">
		<ul class="footer-btn">
			<li class="footer-btn__box">
				<a class="footer-btn__btn" href="/corporateIR/financialInfo/">Corporate IR</a>
			</li>
			<li class="footer-btn__box">
<?php if($TPL_VAR["langType"]=='korean'){?>
				<a class="footer-btn__btn" href="/company/privacy/person" style="color:#01acd8; font-weight:700;">Privacy Policy</a>
<?php }else{?>
				<a class="footer-btn__btn" href="/company/privacy/person_global" style="color:#01acd8; font-weight:700;">Privacy Policy</a>
<?php }?>
			</li>
			<li class="footer-btn__box">
<?php if($TPL_VAR["langType"]=='korean'){?>
				<a class="footer-btn__btn" href="/company/agreement">Terms and Conditions</a>
<?php }else{?>
				<a class="footer-btn__btn" href="/company/agreement/agreement_global">Terms and Conditions</a>
<?php }?>
			</li>
		</ul>
	</div>

	<div class="br__footer__copyright">
		<div class="copyright">
<?php if($TPL_VAR["langType"]=='korean'){?>
			<span class="copyright__lang copyright__lang--kr js__lang__open">한국어</span>
<?php }elseif($TPL_VAR["langType"]=='english'){?>
			<span class="copyright__lang copyright__lang--en js__lang__open">English</span>
<?php }else{?>
			<span class="copyright__lang copyright__lang--cn js__lang__open">中國語</span>
<?php }?>
			<p class="copyright__text">© barrel. all rights reserved.</p>
		</div>
	</div>

	<div class="br__footer__sns-list">
		<ul class="sns-list">
			<li class="sns-list__box">
				<a href="#instar" class="sns-list__box__link sns-list__box__link--instargram js__sns__open">instargram</a>
			</li>
			<li class="sns-list__box">
				<a href="https://www.facebook.com/pages/Barrel/1416024818648425" class="sns-list__box__link sns-list__box__link--facebook">facebook</a>
			</li>
<?php if($TPL_VAR["langType"]=='korean'){?>
			<li class="sns-list__box">
				<a href="https://pf.kakao.com/_VxfxjDd" class="sns-list__box__link sns-list__box__link--kakao">kakaoplus</a>
			</li>
			<li class="sns-list__box">
				<a href="http://blog.naver.com/socal_kr" class="sns-list__box__link sns-list__box__link--blog">blog</a>
			</li>
<?php }?>
			<li class="sns-list__box">
				<a href="https://www.youtube.com/c/getbarrel" class="sns-list__box__link sns-list__box__link--youtube">youtube</a>
			</li>
		</ul>
	</div>
<?php if($TPL_VAR["langType"]=='korean'){?>
	<div class="br__footer__gdweb">
		<a href="#" class="br__footer__isms">
			<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/common/logo_isms_m.png" width="45" height="40">
		</a>
		<a href="#" class="btn_gdweb">
			<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/common/img-footer-gdweb-m.png">
		</a>

<?php if(false){?>
		<a href="javascript:onPopGdAuthMark();">
			<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/common/img-footer-gdweb-m.png">
		</a>
		<form name="GD_AUTHMARK_FORM" method="get">
			<input type="hidden" name="str_keycode" value='2020051937491960972409C31D25FF'/>
		</form>
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
                common.util.iframeModal.open('GDWEB DESIGN AWARDS','http://www.gdweb.co.kr/issue/?str_keycode=2020051937491960972409C31D25FF');
//                window.open('','GD_AUTHMARK','width=730, height=650, status=yes, toolbar=no, menubar=no, location=no, scrollbars=yes');
//                document.GD_AUTHMARK_FORM.action='http://www.gdweb.co.kr/issue/';
//                document.GD_AUTHMARK_FORM.target='GD_AUTHMARK';
//                document.GD_AUTHMARK_FORM.submit();
            }
		</script>
<?php }?>
	</div>
<?php }?>
</section>
<?php if($TPL_VAR["langType"]=='korean'){?>
<div class="isms__wrap">
	<div class="isms__dimmed"></div>
	<div class="isms__popup">
		<div class="isms__popup__img">
			<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/common/img_isms_m_211102.jpg" alt="">
		</div>
		<button type="button" class="isms__popup__close">[닫기]</button>
	</div>
</div>
<div class="gdweb__wrap">
	<div class="gdweb__dimmed"></div>
	<div class="gdweb__popup">
		<div class="gdweb__popup__img">
			<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/common/gdweb_winner_prize.jpg" alt="">
		</div>
		<button type="button" class="gdweb__popup__close">[닫기]</button>
	</div>
</div>
<?php }?>