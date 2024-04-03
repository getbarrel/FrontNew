<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/search_pw_result/search_pw_result.htm 000001290 */ ?>
<section class="fb__member-search fb__search-result">
    <div class="search">
        <header class="search__header">
            <h2 class="search__title">Forgot ID/PW</h2>
        </header>
        <nav class="fb__tab">
            <a href="/member/searchIdResult" class="fb__tab-link">
                ID
            </a>
            <a href="/member/searchPwResult" class="fb__tab-link fb__tab-link--active">
                Password
            </a>
        </nav>
        <section class="search__wrap">
            <div id="search__id" class="search__content search__content--show">
                <p class="search__content__title"><?php echo $TPL_VAR["userData"]["name"]?> your password has been changed successfully .</p>
                <p>Now all services of Barrel are available with your account.</p>
                <p>Please give a lot of support to us.</p>
                <div class="search__other-link">
                    <a href="/" class="button-black">Home</a>
                    <a href="/member/login">Sign in</a>
                </div>
            </div>
        </section>
    </div>
</section>