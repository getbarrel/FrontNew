<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/search_id_result/search_id_result.htm 000003812 */ 
$TPL_userData_1=empty($TPL_VAR["userData"])||!is_array($TPL_VAR["userData"])?0:count($TPL_VAR["userData"]);?>
<section class="fb__member-search fb__search-result">
    <div class="search">
        <header class="search__header">
            <h2 class="search__title">Forgot ID/PW</h2>
        </header>
        <nav class="fb__tab">
            <a href="/member/searchId" class="fb__tab-link fb__tab-link--active">
                ID
            </a>
            <a href="/member/searchPw" class="fb__tab-link">
                Password
            </a>
        </nav>
        <section class="search__wrap">

<?php if($TPL_VAR["userData"]!=""&&count($TPL_VAR["userData"])> 0){?>
            <!-- 아이디 찾기 성공한 경우 -->
<?php if(count($TPL_VAR["userData"])== 1){?>
<?php if($TPL_userData_1){foreach($TPL_VAR["userData"] as $TPL_V1){?>
                    <div id="search__id" class="search__content search__content--show">
                        <p>We succeeded in finding your ID.</p>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <strong class="search__content__title"><?php echo $TPL_V1["name"]?> your ID  is <span class=""search__content__id""><?php echo $TPL_V1["id"]?></span></strong>
<?php }else{?>
                        <strong class="search__content__title">your ID is<br><span class="search__content__id"><?php echo $TPL_V1["id"]?></span></strong>
<?php }?>
                        <p>Barrel will always try to make shopping fun and comfortable for you.</p>
                        <div class="search__other-link">
                            <a href="/">Accept</a>
                        </div>
                    </div>
<?php }}?>
<?php }else{?>
                <div id="search__id" class="search__content search__content--show">
                    <p>We succeeded in finding your ID.</p>
                    <p>
<?php if($TPL_userData_1){$TPL_I1=-1;foreach($TPL_VAR["userData"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <strong class="search__content__title"><?php echo $TPL_V1["name"]?> your ID is</strong>
<?php }else{?>
                        <strong class="search__content__title">your ID is</strong>
<?php }?>
<?php }?>
                        <br><strong class="search__content__id"><?php echo $TPL_V1["id"]?></strong> <!-- 다중 아이디 p 태그 수정 요망  -->
<?php }}?>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <p class="search__content__title">영문몰해당없음</p>
<?php }?>
                    </p>

                    <p><?php echo trans('항상 고객님의 즐겁고 편안한 쇼핑을 위해 노력하는 배럴이 되도록 하겠습니다.')?></p>
                    <div class="search__other-link">
                        <a href="/">Accept</a>
                    </div>
                </div>
<?php }?>
<?php }else{?>

            <!-- 아이디 없는 경우 결과페이지 불필요, 출력조건 없음 dev -->
            <div id="search__password" class="search__content search__content--show">
                <div class="search__inner search__inner--show fb__join-input__form">
                    <strong>No ID is registered.</strong>
                    <p>Become BARREL&#39;s member and enjoy various benefits.</p>
                    <p class="search__other-link">
                        <a href="/" class="button-black">Home</a>
                        <a href="/member/joinInput">Join</a>
                    </p>
                </div>
            </div>
            <!-- 불필요 -->
<?php }?>
        </section>
    </div>
</section>