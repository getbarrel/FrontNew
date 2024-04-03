<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/join_select/join_select.htm 000002490 */ ?>
<!--일반-->
<section class="fb__join-select">
    <header class="fb__join-select__header">
        <h2 class="fb__join-select__title"><?php echo $TPL_VAR["companyInfo"]["shop_name"]?>에 오신 것을 환영합니다.</h2>
        <p class="fb__join-select__summary"><?php echo $TPL_VAR["companyInfo"]["shop_name"]?>의 회원이 되시면 할인쿠폰과 포인트 적립 등의 특별한 혜택을 누리실 수 있습니다.<br>
            본인에 맞는 회원 타입을 선택하신 후 회원가입을 진행하여 주시기 바랍니다.</p>
    </header>
    <div class="fb__join-select__contents">
        <div class="fb__join-select__inner">
<?php if(!empty($TPL_VAR["useBasicJoin"])){?>
            <section class="fb__join-select__type">
                <header class="fb__join-select__header">
                    <h3 class="fb__join-select__subtitle">구매 일반회원</h3>
                    <p class="fb__join-select__subsummary">만 14세 이상 가입 가능</p>
                </header>
                <a href="#" class="fb__join-select__btn" id="devBasicJoinButton">회원가입</a>
            </section>
<?php }?>
<?php if(!empty($TPL_VAR["useCompanyJoin"])){?>
            <section class="fb__join-select__type">
                <header class="fb__join-select__header">
                    <h3 class="fb__join-select__subtitle">구매 사업자회원</h3>
                    <p class="fb__join-select__subsummary">사업자등록증을 보유한 회원</p>
                </header>
                <a href="#" class="fb__join-select__btn" id="devCompanyJoinButton">회원가입</a>
            </section>
<?php }?>
        </div>
        <div class="fb__join-select__sns">
            <p>
                SNS 간편 회원가입
            </p>
            <nav class="fb__join-select__nav">
                <a href="<?php echo $TPL_VAR["naver_login"]?>" class="fb__join-select__sns--naver">
                    naver
                </a>
                <a href="<?php echo $TPL_VAR["kakao_login"]?>" class="fb__join-select__sns--kakao">
                    kakao
                </a>
                <a href="<?php echo $TPL_VAR["facebook_login"]?>" class="fb__join-select__sns--facebook">
                    facebook
                </a>
            </nav>
        </div>
    </div>
</section>