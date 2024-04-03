<?php /* Template_ 2.2.8 2024/02/06 13:37:37 /home/barrel-qa/application/www.bak/assets/templet/enterprise/member/sleep_account_release/sleep_account_release_complete.htm 000001050 */ ?>
<!-- 컨텐츠 영역 S -->
<section class="fb__password">
	<div class="fb__password-wrap">
		<div class="password__header">
			<h2 class="password__title title-md">휴면 회원 안내</h2>
			<p class="password__summary"><?php echo $TPL_VAR["userName"]?> 회원님의 계정이 활성화 되었습니다.</p>
			<p class="password__summary"> 
				해당 계정으로 로그인 하시면 <?php echo $TPL_VAR["mallName"]?><?php echo trans('의 모든 서비스를 이용하실 수 있습니다.<br/>앞으로도 많은 이용과 관심 부탁드립니다.')?>

			</p>
		</div>
		<div class="password__footer">
			<button type="button" class="btn-lg btn-dark-line"><a href="/">홈으로</a></button>
			<button type="button" class="btn-lg btn-dark-line" id="devSleepMemberReleaseComplete">로그인</button>
		</div>
	</div>
</section>
<!-- 컨텐츠 영역 E -->