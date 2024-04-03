<?php /* Template_ 2.2.8 2024/03/21 16:48:36 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/layout/footer/footer_desc.htm 000018913 */ ?>
<script src="/assets/templet/enterprise/js/mypage/review_bbs.js"></script>
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
	enp('create', 'common', 'barrel', { device: 'M' });  // W:웹, M: 모바일, B: 반응형
	enp('send', 'common', 'barrel');
	//Enliple Tracker End_모비온
</script>
<!-- End Channel Plugin -->
<section class="br__dockbar">
	<ul class="br__dockbar__list">
		<li class="dockbar-list">
			<!-- 해당 메뉴가 활성화(페이지 이동)일 때 li class = dockbar-list--active 추가 -->
			<button class="dockbar-list__btn dockbar-list__btn--category" onclick="SideLayerJS('navigation');">카테고리</button>
		</li>
		<li class="dockbar-list">
			<button class="dockbar-list__btn dockbar-list__btn--inside" onclick="location.href='/content/specialList'">배럴 인사이드</button>
		</li>
		<li class="dockbar-list">
			<a href="/" class="dockbar-list__btn dockbar-list__btn--home">배럴홈</a>
		</li>
		<li class="dockbar-list">
			<a href="/mypage/" class="dockbar-list__btn dockbar-list__btn--mypage">마이페이지</a>
		</li>
		<li class="dockbar-list">
			<!-- 해당 메뉴가 활성화(페이지 이동)일 때 li class = dockbar-list--active 추가 -->
			<a href="/mypage/wishlist" class="dockbar-list__btn dockbar-list__btn--wishlist">
				<!-- 활성화일 때 class = active -->
				위시리스트
			</a>
		</li>
	</ul>
</section>

<!-- 하단 제어 버튼 S -->
<div class="br__floating-btn">
	<ul>
		<li>
			<a href="https://pf.kakao.com/_VxfxjDd" class="br__floating__btn--talk"><i class="ico ico-KakaoTalk">카카오톡</i></a>
		</li>
		<li>
			<a href="#;" class="br__floating__btn--top"><i class="ico ico-arrow-top">TOP</i></a>
		</li>
	</ul>
</div>
<!-- 하단 제어 버튼 E -->

<section class="br__footer__inner">
	<h2 class="br__hidden">꼬리말</h2>
	<div class="br__footer__btn">
		<ul class="footer-btn">
			<li class="footer-btn__item">
				<a href="/customer/" class="footer-btn__link">고객센터</a>
			</li>
			<li class="footer-btn__item">
				<a href="/customer/storeInformation" class="footer-btn__link">매장안내</a>
			</li>
		</ul>
	</div>
	<div class="br__footer-logo">
		<a href="/">
			<img src="/assets/mobile_templet/mobile_enterprise/assets/img/icon/icon_bi_big.svg" alt="BARREL" />
		</a>
	</div>
	<div class="br__footer__btn-list">
		<ul class="footer-list">
			<li class="footer-list__item">
<?php if($TPL_VAR["langType"]=='korean'){?>
				<a class="footer-list__btn" href="/company/privacy/person">개인정보처리방침</a>
<?php }else{?>
				<a class="footer-list__btn" href="/company/privacy/person_global">개인정보처리방침</a>
<?php }?>
			</li>
			<li class="footer-list__item">
<?php if($TPL_VAR["langType"]=='korean'){?>
				<a class="footer-list__btn" href="/company/agreement">이용약관</a>
<?php }else{?>
				<a class="footer-list__btn" href="/company/agreement/agreement_global">이용약관</a>
<?php }?>
			</li>
			<li class="footer-list__item">
				<a class="footer-list__btn" href="/corporateIR/financialInfo/">기업IR</a>
			</li>
			<!--
			<li class="footer-list__item">
				<a class="footer-list__btn" href="#;">EN</a>
			</li>
			-->
		</ul>
		<div class="br__footer__gdweb">
			<a class="br__footer__isms" href="#;">
				<img src="/assets/mobile_templet/mobile_enterprise/assets/img/logo_isms_m.png" alt="isms" />
			</a>
		</div>
	</div>
<?php if($TPL_VAR["langType"]=='korean'){?>
	<div class="br__footer__info">
		<div class="information">
			<button type="button" class="information__btn">사업자정보 확인</button>
			<div class="information__list">
				<address><?php echo $TPL_VAR["companyInfo"]["com_addr1"]?> <?php echo $TPL_VAR["companyInfo"]["com_addr2"]?></address>
				<dl>
					<dt>{=trans('대표이사2024-03-01</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["com_ceo"]?></dd>
				</dl>
				<dl>
					<dt>개인정보책임관리자</dt>
					<dd>황상흠</dd>
				</dl>
				<dl>
					<dt>사업자번호</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["com_number"]?> / <a href="http://www.ftc.go.kr/bizCommPop.do?wrkr_no=1058739951" target="_blank" class="information__list__link">사업자정보확인</a></dd>
				</dl>
				<dl>
					<dt>통신판매업 신고번호</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["online_business_number"]?></dd>
				</dl>
				
				<dl class="last">
					<dt>FAX</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["com_fax"]?></dd>
					<dt>Email</dt>
					<dd><a href="mailto:help@getbarrel.com">help@getbarrel.com</a></dd>
				</dl>
			</div>
		</div>
	</div>
<?php }?>
	<div class="br__footer__sns-list">
		<ul class="sns-list">
			<li class="sns-list__box">
				<a href="https://www.instagram.com/getbarrel.official/" class="sns-list__box__link"> <i class="ico ico-instargram-GY"></i>instargram </a>
			</li>
			<li class="sns-list__box">
				<a href="https://pf.kakao.com/_VxfxjDd" class="sns-list__box__link"> <i class="ico ico-kakao-GY"></i>kakaoplus </a>
			</li>
			<!--<li class="sns-list__box">
				<a href="https://www.facebook.com/pages/Barrel/1416024818648425" class="sns-list__box__link"> <i class="ico ico-facebook-GY"></i>facebook </a>
			</li>-->
			<li class="sns-list__box">
				<a href="https://www.youtube.com/c/getbarrel" class="sns-list__box__link"> <i class="ico ico-youtube-GY"></i>youtube </a>
			</li>
		</ul>
	</div>
	<div class="br__footer__copyright">
<?php if($TPL_VAR["langType"]=='korean'){?>
			<!--span class="copyright__lang copyright__lang--kr js__lang__open">한국어</span-->
<?php }elseif($TPL_VAR["langType"]=='english'){?>
			<!--span class="copyright__lang copyright__lang--en js__lang__open">English</span-->
<?php }else{?>
			<!--span class="copyright__lang copyright__lang--cn js__lang__open">中國語</span-->
<?php }?>
		<p class="copyright__text">© BARREL all rights reserved.</p>
	</div>
</section>
<?php if($TPL_VAR["langType"]=='korean'){?>
<div id="isms" class="isms__wrap">
	<div class="isms__dimmed"></div>
	<div class="isms__popup">
		<div class="isms__popup__img">
			<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/common/img_isms_m_211102.jpg" alt="" />
		</div>
		<button type="button" class="isms__popup__close">[닫기]</button>
	</div>
</div>
<div id="gdweb" class="gdweb__wrap">
	<div class="gdweb__dimmed"></div>
	<div class="gdweb__popup">
		<div class="gdweb__popup__img">
			<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/img/common/gdweb_winner_prize.jpg" alt="" />
		</div>
		<button type="button" class="gdweb__popup__close">[닫기]</button>
	</div>
</div>
<?php }?>
<!-- 인클루드한 html 에서 해당 js를 로드하기 위해 추가한 것으로 작업시 해당 js는 body 위에 넣어주시면 됩니다. layout 폴더의 layout_default.html 참고하시면 됩니다.-->
<script type="text/javascript" src="/assets/mobile_templet/mobile_enterprise/assets/js/common.js"></script>


<!--
<script src="../../js/mypage/review_bbs.js"></script>
<!-- Channel Plugin Scripts --
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

	//공통 호출 하단 스크립트 : 모든페이지 하단 설치_TERA
	//PlayD TERA Log Script v1.2
	var _nSA=(function(_g,_s,_p,_d,_i,_h){
		if(_i.wgc!=_g){_i.wgc=_g;_i.wrd=(new Date().getTime());
		var _sc=_d.createElement('script');_sc.src=_p+'//sas.techhub.co.kr/'+_s+'gc='+_g+'&rd='+_i.wrd;
		var _sm=_d.getElementsByTagName('script')[0];_sm.parentNode.insertBefore(_sc, _sm);} return _i;
	})('TR10247806101','sa-w.js?',location.protocol,document,window._nSA||{},location.hostname);
	//LogAnalytics Script Install

	//Enliple Tracker Start_모비온
	(function(a,g,e,n,t){a.enp=a.enp||function(){(a.enp.q=a.enp.q||[]).push(arguments)};n=g.createElement(e);n.async=!0;n.defer=!0;n.src="https://cdn.megadata.co.kr/dist/prod/enp_tracker_self_hosted.min.js";t=g.getElementsByTagName(e)[0];t.parentNode.insertBefore(n,t)})(window,document,"script");
	enp('create', 'common', 'barrel', { device: 'M' });  // W:웹, M: 모바일, B: 반응형
	enp('send', 'common', 'barrel');
	//Enliple Tracker End_모비온
</script>
<!-- End Channel Plugin --
<section class="br__footer">
	<h2 class="br__hidden">꼬리말</h2>
	<div class="br__footer__cscenter">
		<div class="cscenter">
			<h3 class="cscenter__title">

<?php if($TPL_VAR["langType"]=='english'){?>
				고객지원센터
					<span class="cscenter__title__phone">en_help@getbarrel.com</span>
<?php }else{?>
				고객센터 :
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
<?php if(is_login()){?>--
				<a class="footer-btn__btn devLogout">로그아웃</a>
<?php }else{?>--
				<a class="footer-btn__btn" href="/member/login">로그인</a>
<?php }?>--
			</li>
			<li class="footer-btn__box">
				<a class="footer-btn__btn" href="/customer/">고객센터</a>
			</li>
			<!--<li class="footer-btn__box">-->
				<!--<a class="footer-btn__btn" href="javascript:alert('지원하지않는 기능입니다.');">PC버전</a>-->
			<!--</li>-->
			<!--li class="footer-btn__box">
				<a class="footer-btn__btn" href="javascript:alert('서비스 준비중입니다.');">앱 다운로드</a>
			</li--
		</ul>
	</div>
<?php if($TPL_VAR["langType"]=='korean'){?>
	<div class="br__footer__info">
		<div class="information">
			<button type="button" class="information__btn">사업자 정보 확인</button>
			<div class="information__list">
				<dl>
					<dt>회사명</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["com_name"]?></dd>
					<dt>대표</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["com_ceo"]?></dd>
					<dt>개인정보관리책임자</dt>
					<dd>황상흠</dd>
					<dt>사업자등록번호</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["com_number"]?></dd>
					<dt>통신판매업신고</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["online_business_number"]?> <br><a href="http://www.ftc.go.kr/bizCommPop.do?wrkr_no=1058739951" target="_blank" class="information__list__link">사업자정보확인</a></dd>
					<dt>주소</dt>
					<dd><?php echo $TPL_VAR["companyInfo"]["com_addr1"]?> <?php echo $TPL_VAR["companyInfo"]["com_addr2"]?></dd>
					<dt>팩스</dt>
					<dd>FAX. <?php echo $TPL_VAR["companyInfo"]["com_fax"]?></dd>
				</dl>
			</div>
		</div>
	</div>
<?php }?>
	<div class="br__footer__btn-list">
		<ul class="footer-btn">
			<li class="footer-btn__box">
				<a class="footer-btn__btn" href="/corporateIR/financialInfo/">기업IR</a>
			</li>
			<li class="footer-btn__box">
<?php if($TPL_VAR["langType"]=='korean'){?>
				<a class="footer-btn__btn" href="/company/privacy/person" style="color:#01acd8; font-weight:700;">개인정보처리방침</a>
<?php }else{?>
				<a class="footer-btn__btn" href="/company/privacy/person_global" style="color:#01acd8; font-weight:700;">개인정보처리방침</a>
<?php }?>
			</li>
			<li class="footer-btn__box">
<?php if($TPL_VAR["langType"]=='korean'){?>
				<a class="footer-btn__btn" href="/company/agreement">이용약관</a>
<?php }else{?>
				<a class="footer-btn__btn" href="/company/agreement/agreement_global">이용약관</a>
<?php }?>
			</li>
		</ul>
	</div>

	<div class="br__footer__copyright">
		<div class="copyright">
<?php if($TPL_VAR["langType"]=='korean'){?>
			<!--span class="copyright__lang copyright__lang--kr js__lang__open">한국어</span--
<?php }elseif($TPL_VAR["langType"]=='english'){?>
			<!--span class="copyright__lang copyright__lang--en js__lang__open">English</span--
<?php }else{?>
			<!--span class="copyright__lang copyright__lang--cn js__lang__open">中國語</span--
<?php }?>
			<p class="copyright__text">© barrel. all rights reserved.</p>
		</div>
	</div>

	<div class="br__footer__sns-list">
		<ul class="sns-list">
			<li class="sns-list__box">
				<!-- a href="#instar" class="sns-list__box__link sns-list__box__link--instargram js__sns__open">instargram</a--
				<a href="https://www.instagram.com/getbarrel" class="sns-list__box__link sns-list__box__link--instargram">instargram</a>
			</li>
			<li class="sns-list__box">
				<a href="https://www.facebook.com/pages/Barrel/1416024818648425" class="sns-list__box__link sns-list__box__link--facebook">facebook</a>
			</li>
			<li class="sns-list__box">
				<a href="https://www.youtube.com/c/getbarrel" class="sns-list__box__link sns-list__box__link--youtube">youtube</a>
			</li>
<?php if($TPL_VAR["langType"]=='korean'){?>
			<li class="sns-list__box">
				<a href="https://pf.kakao.com/_VxfxjDd" class="sns-list__box__link sns-list__box__link--kakao">kakaoplus</a>
			</li>
			<!--li class="sns-list__box">
				<a href="http://blog.naver.com/socal_kr" class="sns-list__box__link sns-list__box__link--blog">blog</a>
			</li--
<?php }?>

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
		<!-- ISMS 인증마크 적용 시작 --
		<script>
			function onPopIsms() {
				window.open('/company/isms','GD_ISMS','width=730, height=650, status=no, toolbar=no, menubar=no, location=no, scrollbars=no');
			}
		</script>
		<!-- ISMS 인증마크 적용 종료 -->
		<!-- GDWEB 인증마크 적용 시작 --
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
<!-- 인클루드한 html 에서 해당 js를 로드하기 위해 추가한 것으로 작업시 해당 js는 body 위에 넣어주시면 됩니다. layout 폴더의 layout_default.html 참고하시면 됩니다.--
<script type="text/javascript" src="/assets/mobile_templet/mobile_enterprise/assets/js/common.js"></script>
-->