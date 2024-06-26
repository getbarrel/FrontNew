<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/search_pw_result/search_pw_result.htm 000001408 */ ?>
<section class="fb__member-search fb__search-result">
    <div class="search">
        <header class="search__header">
            <h2 class="search__title">아이디/비밀번호 찾기</h2>
        </header>
        <nav class="fb__tab">
            <a href="/member/searchIdResult" class="fb__tab-link">
                아이디
            </a>
            <a href="/member/searchPwResult" class="fb__tab-link fb__tab-link--active">
                비밀번호
            </a>
        </nav>
        <section class="search__wrap">
            <div id="search__id" class="search__content search__content--show">
                <p class="search__content__title"><?php echo $TPL_VAR["userData"]["name"]?> 회원님의 비밀번호가 성공적으로 변경되었습니다.</p>
                <p>해당 계정으로 로그인하시면 배럴의 모든 서비스를 이용하실 수 있습니다.</p>
                <p>앞으로도 많은 이용과 관심 부탁드립니다.</p>
                <div class="search__other-link">
                    <a href="/" class="button-black">홈으로</a>
                    <a href="/member/login">로그인</a>
                </div>
            </div>
        </section>
    </div>
</section>