<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/search_id/search_id.htm 000012970 */ ?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="fb__member-search fb__memberpw">
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

            <!--  아이디 찾기 -->
            <div id="search__id" class="search__content search__content--show">
                <fieldset>
                    <legend>
                        Forgot ID
                    </legend>
                    <nav class="search__nav">
                        <div class="search__nav__btn">
                            <label><input type="radio" name="idsearch" value="email" checked="checked"><span>Email</span></label>
                            <label><input type="radio" name="idsearch" value="phone" class="nav--phone"><span>Tel</span></label>
                        </div>
                    </nav>
                    <form id="devSearchEmailForm">
                        <div class="search__inner search__inner--show fb__join-input__form fb__member-search__email">
                            <ul class="search__company input-form__content-box">
                                <li class="inputs">
                                    <span class="inputs__title">Name</span>
                                    <div class="inputs__content">
                                        <input type="text" name="devUserName" id="devUserName" class="inputs__content__name" title="Name">
                                        <p class="inputs__content__text" name="devUserName" id="devFormatUserName"><?php echo $TPL_VAR["userName"]?></p>
                                    </div>
                                </li>
                                <li class="inputs">
                                    <span class="inputs__title"><label for="devEmailId">Email</label></span>
                                    <div class="inputs__content">
                                        <span class="pub-email">
                                        <input type="text" name="devUserEmail1" id="devUserEmail1" class="input__email" title="Email">
                                        <span class="hyphen_2">@</span>
                                        <input type="text" name="devUserEmail2" id="devUserEmail2" class="input__email title="Email">
                                        <span class="inputs__content__email">
                                            <select id="devEmailHostSelect" class="input__select">
                                                <option value="">Select Email</option>
                                                <option value="naver.com">naver.com</option>
                                                <option value="gmail.com">gmail.com</option>
                                                <option value="hotmail.com">hotmail.com</option>
                                                <option value="hanmail.net">hanmail.net</option>
                                                <option value="daum.net">daum.net</option>
                                                <option value="nate.com">nate.com</option>
                                            </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </form>
                    <form id="devSearchPhoneForm">
                        <div class="search__inner fb__join-input__form fb__member-search__phone">
                            <ul class="search__company input-form__content-box">
                                <li class="inputs">
                                    <span class="inputs__title">Name</span>
                                    <div class="inputs__content">
                                        <input type="text" name="devUser" id="devUser" title="Name" class="inputs__content__name">
                                        <p class="inputs__content__text" name="devUserName" id="devFormatUserName"><?php echo $TPL_VAR["userName"]?></p>
                                    </div>
                                </li>
                                <li class="inputs inputs__cellphone">
                                    <span class="inputs__title">Tel</span>
                                    <div class="inputs__content">
                                        <div class="selectWrap">
                                            <select name="devHp1"  id="devHp1">
                                                <option value="010">010</option>
                                                <option value="011">011</option>
                                                <option value="016">016</option>
                                                <option value="017">017</option>
                                                <option value="018">018</option>
                                                <option value="019">019</option>
                                            </select>
                                            <span class="hyphen">-</span>
                                            <input type="number" name="devHp2" id="devHp2" value="" title="휴대폰번호">
                                            <span class="hyphen">-</span>
                                            <input type="number"  name="devHp3" id="devHp3" value="" title="휴대폰번호">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </form>
                </fieldset>
            </div>
        </section>
        <p class="search__other-link">
            <a href="javascript:void(0)" id="devUserSubmitButton">Accept</a>
        </p>
    </div>
</section>

<?php }else{?>

<!-- @TODO 글로벌 수정영역 -->
<section class="fb__member-search fb__memberpw">
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

            <!--  아이디 찾기 -->
            <div id="search__id" class="search__content search__content--show">
                    <fieldset>
                        <legend>
                            Forgot ID
                        </legend>
                        <nav class="search__nav">
                            <div>
                                <label><input type="radio" name="idsearch" value="email" checked>Email</label>
                                <!--<label><input type="radio" name="idsearch" value="phone" class="nav&#45;&#45;phone">휴대폰</label>-->
                            </div>
                        </nav>
                        <form id="devSearchEmailForm">
                        <div class="search__inner search__inner--show fb__join-input__form fb__member-search__email">
                            <ul class="search__company input-form__content-box">
                                <!--<li class="inputs">-->
                                    <!--<span class="inputs__title">Name</span>-->
                                    <!--<div class="inputs__content">-->
                                        <!--<input type="text" name="devUserName" id="devUserName" class="inputs__content__name" title="Name">-->
                                        <!--<p class="inputs__content__text" name="devUserName" id="devFormatUserName"><?php echo $TPL_VAR["userName"]?></p>-->
                                    <!--</div>-->
                                <!--</li>-->
                                <li class="inputs">
                                    <span class="inputs__title"><label for="devUserEmail1">Email</label></span>
                                    <div class="inputs__content">
                                        <span class="pub-email">
                                        <input type="text" name="devUserEmail1" id="devUserEmail1" class="input__email" title="Email">
                                        <span class="hyphen_2">@</span>
                                        <input type="text" name="devUserEmail2" id="devUserEmail2" class="input__email title="Email">
                                        <span class="inputs__content__email">
<?php if($TPL_VAR["langType"]!='english'){?>
                                            <select id="devEmailHostSelect" class="input__select">
                                                <option value="">Select Email</option>
                                                <option value="naver.com">naver.com</option>
                                                <option value="gmail.com">gmail.com</option>
                                                <option value="hotmail.com">hotmail.com</option>
                                                <option value="hanmail.net">hanmail.net</option>
                                                <option value="daum.net">daum.net</option>
                                                <option value="nate.com">nate.com</option>
                                            </select>
<?php }?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        </form>


                        <!--<form id="devSearchPhoneForm">-->
                        <!--<div class="search__inner fb__join-input__form fb__member-search__phone">-->
                            <!--<ul class="search__company input-form__content-box">-->
                                <!--<li class="inputs">-->
                                    <!--<span class="inputs__title">Name</span>-->
                                    <!--<div class="inputs__content">-->
                                        <!--<input type="text" name="devUser" id="devUser" title="Name" class="inputs__content__name">-->
                                        <!--<p class="inputs__content__text" name="devUserName" id="devFormatUserName"><?php echo $TPL_VAR["userName"]?></p>-->
                                    <!--</div>-->
                                <!--</li>-->
                                <!--<li class="inputs inputs__cellphone">-->
                                    <!--<span class="inputs__title">Tel</span>-->
                                    <!--<div class="inputs__content">-->
                                        <!--<div class="selectWrap">-->
                                            <!--<select name="devHp1"  id="devHp1">-->
                                                <!--<option value="010">010</option>-->
                                                <!--<option value="011">011</option>-->
                                                <!--<option value="016">016</option>-->
                                                <!--<option value="017">017</option>-->
                                                <!--<option value="018">018</option>-->
                                                <!--<option value="019">019</option>-->
                                            <!--</select>-->
                                            <!--<span class="hyphen">-</span>-->
                                            <!--<input type="number" name="devHp2" id="devHp2" value="" title="휴대폰번호">-->
                                            <!--<span class="hyphen">-</span>-->
                                            <!--<input type="number"  name="devHp3" id="devHp3" value="" title="휴대폰번호">-->
                                        <!--</div>-->
                                    <!--</div>-->
                                <!--</li>-->
                            <!--</ul>-->
                        <!--</div>-->
                        <!--</form>-->
                    </fieldset>
            </div>
        </section>
        <p class="search__other-link">
            <a href="javascript:void(0)" id="devUserSubmitButton">Accept</a>
        </p>
    </div>
</section>
<?php }?>