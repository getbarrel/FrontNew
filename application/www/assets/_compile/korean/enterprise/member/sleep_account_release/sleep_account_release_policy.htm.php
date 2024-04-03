<?php /* Template_ 2.2.8 2024/02/06 13:21:22 /home/barrel-qa/application/www.bak/assets/templet/enterprise/member/sleep_account_release/sleep_account_release_policy.htm 000002155 */ ?>
<!-- 컨텐츠 영역 S -->
<section class="fb__password">
	<form id="devForm" class="term js__check-wrap">
	<input type="hidden" id="agree-term1" name="policyIx[1]" value="Y">
	<input type="hidden" id="agree-term2" name="policyIx[37]" value="Y">
	<div class="fb__password-wrap">
		<div class="password__header">
			<h2 class="password__title title-md">휴면 회원 안내</h2>
			<p class="password__summary">현재 회원님은 <span>[휴면 회원]</span> 상태입니다.</p>
		</div>
		<div class="password__content">
			<!-- <dl class="password__content-item">
				<dt>휴면 회원 이음</dt>
				<dd><span class="txt-red"><?php echo $TPL_VAR["userName"]?></span></dd>
			</dl> -->
			<dl class="password__content-item">
				<dt>휴면 회원 ID</dt>
				<dd><span class="txt-red"><?php echo $TPL_VAR["userId"]?></span></dd>
			</dl>
			<dl class="password__content-item">
				<dt>회원 가입일</dt>
				<dd><span class="txt-red"><?php echo $TPL_VAR["userRegDate"]?></span></dd>
			</dl>
		</div>
		<div class="password__footer">
			<p>회원님께서는 1년 이상 로그인 내역이 없어 휴면 계정으로 전환 되었습니다. 휴면 계정 해제를 원하시는 경우, 본인 인증을 진행하시면 정상적으로 서비스를 이용하실 수 있습니다.</p>
<?php if($TPL_VAR["useCertify"]){?>
			<button type="button" class="btn-lg btn-dark-line" id="devCertifyButton">휴대폰 인증</button>
			<!--{: ? useIpin}-->
			<button type="button" class="btn-lg btn-dark-line" id="devIpinButton">아이핀(i-PIN) 인증</button>
<?php }else{?>
			<button type="button" class="btn-lg btn-dark-line" id="devSubmitButton">휴면 계정 해제</button>
<?php }?>
			<p>[주식회사 배럴]은 관련 법률에 의거하여, 1년 이상 로그인하지 않은 회원님의 개인정보를 안전하게 보호하기 위해 휴면계정 정책을 시행하고 있습니다.</p>
		</div>
	</div>
    </form>
</section>
<!-- 컨텐츠 영역 E -->