<?php /* Template_ 2.2.8 2024/02/06 14:57:09 /home/barrel-qa/application/www.bak/assets/mobile_templet/mobile_enterprise/member/search_id_result/search_id_result.htm 000003218 */ 
$TPL_userData_1=empty($TPL_VAR["userData"])||!is_array($TPL_VAR["userData"])?0:count($TPL_VAR["userData"]);?>
<!-- 컨텐츠 S -->
<section class="br__find-user">
<?php if($TPL_VAR["userData"]!=""&&count($TPL_VAR["userData"])> 0){?>
	<!-- 아이디 찾기 성공한 경우 S -->
	<div class="br__find__success">
		<div class="page-title">
			<div class="title-md">아이디 찾기</div>
			<div class="page-title__sub">
				입력하신 정보로<br />
				아이디가 확인되었습니다.
			</div>
		</div>
		<div class="success__box">
<?php if(count($TPL_VAR["userData"])== 1){?>
<?php if($TPL_userData_1){foreach($TPL_VAR["userData"] as $TPL_V1){?>
			<div class="success__box-item">
				<div class="title-sm"><?php if($TPL_VAR["langTYpe"]=='korean'){?>가입 되어 있는 ID<?php }else{?>Your ID is<?php }?></div>
				<div class="success__box-text">
					<p class="id"><?php echo $TPL_V1["id"]?></p>
				</div>
			</div>
			<div class="success__box-item">
				<div class="title-sm"><?php if($TPL_VAR["langTYpe"]=='korean'){?>회원 가입일<?php }else{?>Your Regist Date is<?php }?></div>
				<div class="success__box-text">
					<p class="day"><?php echo $TPL_V1["userData"]?></p>
				</div>
			</div>
<?php }}?>
<?php }else{?>
			<div class="success__box-item">
				<div class="title-sm"><?php if($TPL_VAR["langTYpe"]=='korean'){?>가입 되어 있는 ID<?php }else{?>Your ID is<?php }?></div>
				<div class="success__box-text">
<?php if($TPL_userData_1){foreach($TPL_VAR["userData"] as $TPL_V1){?>
					<p class="id"><?php echo $TPL_V1["id"]?></p>
<?php }}?>
				</div>
			</div>
			<div class="success__box-item">
				<div class="title-sm"><?php if($TPL_VAR["langTYpe"]=='korean'){?>회원 가입일<?php }else{?>Your Regist Date is<?php }?></div>
				<div class="success__box-text">
<?php if($TPL_userData_1){foreach($TPL_VAR["userData"] as $TPL_V1){?>
					<p class="day">2023.01.01</p>
<?php }}?>
				</div>
			</div>
<?php }?>
		</div>
		<div class="find-user__btn">
			<a href="#;" class="btn-lg btn-dark-line find-user__btn__submit">로그인</a>
			<a href="#;" class="btn-lg btn-dark-line">비밀번호 찾기</a>
		</div>
	</div>
	<!-- 아이디 찾기 성공한 경우 E -->
<?php }else{?>
	<!-- 아이디 찾기 실패할 경우 S -->
	<div class="br__find__fail">
		<div class="page-title">
			<div class="title-md">아이디 찾기</div>
			<div class="page-title__sub">
				<p>가입된 아이디가 없습니다.</p>
				<p>지금 회원가입을 하시면 <em class="txt-dark">배럴의 다양한 혜택</em>을 받으실 수 있습니다.</p>
			</div>
		</div>
		<div class="find-user__btn">
			<a href="/" class="btn-lg btn-dark-line find-user__btn__home" class="">홈으로</a>
			<a href="/member/joinInput" class="btn-lg btn-dark-line find-user__btn__submit">회원가입</a>
		</div>
	</div>
	<!-- 아이디 찾기 실패할 경우 E -->
<?php }?>
	<div class="br__find-user__footer">
		<a href="/member/login" class="btn-link">로그인으로 돌아가기</a>
	</div>
</section>
<!-- 컨텐츠 E -->