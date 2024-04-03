<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/join_select/join_select.htm 000002422 */ ?>
<!--일반-->
<section class="fb__join-select">
    <header class="fb__join-select__header">
        <h2 class="fb__join-select__title">Welcome to <?php echo $TPL_VAR["companyInfo"]["shop_name"]?> !</h2>
        <p class="fb__join-select__summary">Become a <?php echo $TPL_VAR["companyInfo"]["shop_name"]?> member and enjoy special offers such as discount coupons and points.<br>
            Please select a member type that suits you and proceed with the membership registration.</p>
    </header>
    <div class="fb__join-select__contents">
        <div class="fb__join-select__inner">
<?php if(!empty($TPL_VAR["useBasicJoin"])){?>
            <section class="fb__join-select__type">
                <header class="fb__join-select__header">
                    <h3 class="fb__join-select__subtitle">purchase for member</h3>
                    <p class="fb__join-select__subsummary">Sign up for 14 years or older.</p>
                </header>
                <a href="#" class="fb__join-select__btn" id="devBasicJoinButton">Join</a>
            </section>
<?php }?>
<?php if(!empty($TPL_VAR["useCompanyJoin"])){?>
            <section class="fb__join-select__type">
                <header class="fb__join-select__header">
                    <h3 class="fb__join-select__subtitle">purchase for business member</h3>
                    <p class="fb__join-select__subsummary">Member with business registration card</p>
                </header>
                <a href="#" class="fb__join-select__btn" id="devCompanyJoinButton">Join</a>
            </section>
<?php }?>
        </div>
        <div class="fb__join-select__sns">
            <p>
                Simple membership sign in with SNS
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