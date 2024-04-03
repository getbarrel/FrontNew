<?php /* Template_ 2.2.8 2020/08/31 15:57:03 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/member/search_id_result/search_id_result.htm 000004425 */ 
$TPL_userData_1=empty($TPL_VAR["userData"])||!is_array($TPL_VAR["userData"])?0:count($TPL_VAR["userData"]);?>
<section class="br__find-user">
    <h2 class="br__find-user__title">Forgot ID/PW</h2>

    <div class="br__tabs">
        <ul class="br__tabs__list">
            <li class="br__tabs__box">
                <a href="/member/searchId" class="br__tabs__btn br__tabs__btn--active">ID</a>
            </li>
            <li class="br__tabs__box">
                <a href="/member/searchPw" class="br__tabs__btn">Password</a>
            </li>
        </ul>
        <div class="br__tabs__content">

            <!-- 2019.07.11 아이디 찾기 성공한 경우 -->
<?php if($TPL_VAR["userData"]!=""&&count($TPL_VAR["userData"])> 0){?>
<?php if(count($TPL_VAR["userData"])== 1){?>
<?php if($TPL_userData_1){foreach($TPL_VAR["userData"] as $TPL_V1){?>
                    <div class="br__find__fail">
                        <p class="fail__title">Your ID has been successfully located.</p>
                        <div class="fail__box">
<?php if($TPL_VAR["langTYpe"]=='korean'){?>
                            <p class="fail__box-title"><?php echo $TPL_V1["name"]?> yorur ID<br/><em><?php echo $TPL_V1["id"]?></em> is.</p>
<?php }else{?>
                            <p class="fail__box-title">Your ID is <br/><em><?php echo $TPL_V1["id"]?></em></p>
<?php }?>
                        </div>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <p class="fail__title-sub">BARREL will always push ourselves <br/> for your pleasant and comfortable shopping.</p>
<?php }else{?>
                        <p class="fail__title-sub">BARREL will always push ourselves <br/> for your pleasant and comfortable shopping.</p>
<?php }?>
                        <div class="find-user__btn">
                            <a href="/mypage/" class="find-user__btn__submit">Sign in</a>
                        </div>
                    </div>
<?php }}?>
<?php }else{?>
                    <!-- 1개 이상 아이디 존재시 -->
                    <div class="br__find__fail">
                        <p class="fail__title">Your ID has been successfully located.</p>
                        <div class="fail__box">
<?php if($TPL_userData_1){$TPL_I1=-1;foreach($TPL_VAR["userData"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
                            <p class="fail__box-title"><?php echo $TPL_V1["name"]?> your ID is</p>
<?php }?>
                            <p class="fail__box-title"><em><?php echo $TPL_V1["id"]?></em></p>
<?php }}?>
                        </div>
<?php if($TPL_VAR["langType"]=='korean'){?>
                        <p class="fail__title-sub">BARREL will always push ourselves <br/> for your pleasant and comfortable shopping.</p>
<?php }else{?>
                        <p class="fail__title-sub">BARREL will always push ourselves <br/> for your pleasant and comfortable shopping.</p>
<?php }?>
                        <div class="find-user__btn">
                            <a href="/mypage/" class="find-user__btn__submit">Sign in</a>
                        </div>
                    </div>
<?php }?>
            <!-- EOD : 2019.07.11 아이디 찾기 성공한 경우 -->
<?php }else{?>
            <!-- 2019.07.11 가입한 아이디가 없는경우 (dev: 불필요) -->
            <div class="br__find__success">
                <div class="success__box">
                    <p class="success__box-title">No ID is registered.</p>
<?php if($TPL_VAR["langType"]=='korean'){?>
                    <p class="success__box-sub">Sign up now to receive <br/> the various benefits of <em>barrel</em>.</p>
<?php }else{?>
                    <p class="success__box-sub">Sign up now to receive <br/> the various benefits of <em>barrel</em>.</p>
<?php }?>
                </div>
                <div class="find-user__btn">
                    <a href="/" class="find-user__btn__home" class="">Home</a>
                </div>
                <div class="find-user__btn">
                    <a href="/member/joinInput" class="find-user__btn__submit">Join</a>
                </div>
            </div>
            <!-- EOD : 2019.07.11 가입한 아이디가 없는경우 -->
<?php }?>
        </div>
    </div>
</section>