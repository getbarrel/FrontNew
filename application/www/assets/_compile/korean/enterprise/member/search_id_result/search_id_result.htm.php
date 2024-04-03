<?php /* Template_ 2.2.8 2024/01/02 11:57:46 /home/barrel-stage/application/www/assets/templet/enterprise/member/search_id_result/search_id_result.htm 000005689 */ 
$TPL_userData_1=empty($TPL_VAR["userData"])||!is_array($TPL_VAR["userData"])?0:count($TPL_VAR["userData"]);?>
<!-- 컨텐츠 영역 S -->
<section class="fb__member-search fb__search-result">
	<div class="search">
		<div class="search__wrap">
			<div class="search__header">
				<h2 class="search__title title-md">아이디 찾기</h2>
				<p>회원가입 시 등록한 정보로 아이디 찾기를 하실 수 있습니다.</p>
			</div>
<?php if($TPL_VAR["userData"]!=""&&count($TPL_VAR["userData"])> 0){?>
			<div class="search__content search__content-result">
				<div class="search__content-item">
					<div class="title-sm">가입 되어 있는 ID</div>
<?php if(count($TPL_VAR["userData"])== 1){?>
<?php if($TPL_userData_1){foreach($TPL_VAR["userData"] as $TPL_V1){?>
						<div class="search__content__id"><?php echo $TPL_V1["id"]?></div>
<?php }}?>
<?php }else{?>
<?php if($TPL_userData_1){$TPL_I1=-1;foreach($TPL_VAR["userData"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
<?php }?>
						<div class="search__content__id"><?php echo $TPL_V1["id"]?></div>
<?php }}?>
<?php }?>
				</div>
			</div>
<?php }else{?>
			<div class="search__content search__content-result">
				<div class="search__content-item">
					<div class="title-sm">
						<strong>가입된 아이디가 없습니다.</strong>
						<p>지금 회원가입을 하시면, 배럴의 다양한 혜택을 받으실 수 있습니다.</p>					
					</div>
				</div>
			</div>
<?php }?>
			<div class="search__footer">
				<a href="/member/login?url=" class="btn-lg btn-dark-line" id="">로그인</a>
				<a href="/member/searchPw" class="btn-lg btn-dark-line" id="">비밀번호 찾기</a>
			</div>
		</div>
	</div>
</section>
<!-- 컨텐츠 영역 E -->

<!--
<section class="fb__member-search fb__search-result">
    <div class="search">
        <header class="search__header">
            <h2 class="search__title">아이디/비밀번호 찾기</h2>
        </header>
        <nav class="fb__tab">
            <a href="/member/searchId" class="fb__tab-link fb__tab-link--active">
                아이디
            </a>
            <a href="/member/searchPw" class="fb__tab-link">
                비밀번호
            </a>
        </nav>
        <section class="search__wrap">

<?php if($TPL_VAR["userData"]!=""&&count($TPL_VAR["userData"])> 0){?>
            <!-- 아이디 찾기 성공한 경우 -- 
<?php if(count($TPL_VAR["userData"])== 1){?>
<?php if($TPL_userData_1){foreach($TPL_VAR["userData"] as $TPL_V1){?>
                    <div id="search__id" class="search__content search__content--show">
                        <p>고객님의 아이디 찾기가 성공적으로 이루어졌습니다.</p>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <strong class="search__content__title"><?php echo $TPL_V1["name"]?> 회원님의 아이디는<br><span class=""search__content__id""><?php echo $TPL_V1["id"]?></span> 입니다.</strong>
<?php }else{?>
                        <strong class="search__content__title">your ID is<br><span class="search__content__id"><?php echo $TPL_V1["id"]?></span></strong>
<?php }?>
                        <p>항상 고객님의 즐겁고 편안한 쇼핑을 위해 노력하는 배럴이 되도록 하겠습니다.</p>
                        <div class="search__other-link">
                            <a href="/">확인</a>
                        </div>
                    </div>
<?php }}?>
<?php }else{?>
                <div id="search__id" class="search__content search__content--show">
                    <p>고객님의 아이디 찾기가 성공적으로 이루어졌습니다.</p>
                    <p>
<?php if($TPL_userData_1){$TPL_I1=-1;foreach($TPL_VAR["userData"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <strong class="search__content__title"><?php echo $TPL_V1["name"]?> 회원님의 아이디는</strong>
<?php }else{?>
                        <strong class="search__content__title">your ID is</strong>
<?php }?>
<?php }?>
                        <br><strong class="search__content__id"><?php echo $TPL_V1["id"]?></strong> <!-- 다중 아이디 p 태그 수정 요망  -- 
<?php }}?>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <p class="search__content__title">입니다.</p>
<?php }?>
                    </p>

                    <p><?php echo trans('항상 고객님의 즐겁고 편안한 쇼핑을 위해 노력하는 배럴이 되도록 하겠습니다.')?></p>
                    <div class="search__other-link">
                        <a href="/">확인</a>
                    </div>
                </div>
<?php }?>
<?php }else{?>

            <!-- 아이디 없는 경우 결과페이지 불필요, 출력조건 없음 dev -- 
            <div id="search__password" class="search__content search__content--show">
                <div class="search__inner search__inner--show fb__join-input__form">
                    <strong>가입된 아이디가 없습니다.</strong>
                    <p>지금 회원가입을 하시면, 배럴의 다양한 혜택을 받으실 수 있습니다.</p>
                    <p class="search__other-link">
                        <a href="/" class="button-black">홈으로</a>
                        <a href="/member/joinInput">회원가입</a>
                    </p>
                </div>
            </div>
            <!-- 불필요 -- 
<?php }?>
        </section>
    </div>
</section>
-->