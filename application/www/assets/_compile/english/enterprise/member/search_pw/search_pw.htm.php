<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/member/search_pw/search_pw.htm 000012834 */ ?>
<?php if($TPL_VAR["langType"]=='korean'){?>
<section class="fb__member-search fb__memberpw">
    <div class="search">
        <header class="search__header">
            <h2 class="search__title">Forgot ID/PW</h2>
        </header>
        <nav class="fb__tab">
            <a href="/member/searchId" class="fb__tab-link">
                ID
            </a>
            <a href="/member/searchPw" class="fb__tab-link fb__tab-link--active">
                Password
            </a>
        </nav>



        <section class="search__wrap">
            <form id="devSearchEmailForm">
                <nav class="search__nav">
                    <div class="search__nav__btn">
                        <label><input type="radio" name="searchType" value="email" checked="checked"><span>Email</span></label>
                        <label><input type="radio" name="searchType" value="phone" class="nav--phone"><span>Tel</span></label>
                    </div>
                </nav>
                <div id="search__password" class="search__content search__content--show">
                    <div class="search__inner search__inner--show fb__join-input__form fb__member-search__email">
                        <ul class="search__company input-form__content-box">
                            <li class="inputs">
                                <span class="inputs__title">ID</span>
                                <div class="inputs__content">
                                    <input type="text" name="userId" id="devUserId" class="inputs__content__name" title="ID">
                                    <p class="inputs__content__text" name="devUserId"></p>
                                </div>
                            </li>
                            <li class="inputs">
                                <span class="inputs__title">Name</span>
                                <div class="inputs__content">
                                    <input type="text" name="userName" id="devUserName" class="inputs__content__name" title="Name">
                                    <p class="inputs__content__text" name="devUserName"></p>
                                </div>
                            </li>


                            <li class="inputs email_group">
                                <span class="inputs__title"><label for='devEmailId'>Email</label></span>
                                <div class="inputs__content">
                                <span class="pub-email">
                                <input type="text" name="userEmail1" id="devUserEmail1" class="input__email"  title="Email">
                                <span class="hyphen_2">@</span>
                                <input type="text" name="userEmail2" id="devUserEmail2" class="input__email"  title="Email">
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
                                </span>
                                </span>
                                </div>
                            </li>


                            <li class="inputs inputs__cellphone phone_group" style="display: none">
                                <span class="inputs__title">Tel</span>
                                <div class="inputs__content">
                                    <div class="selectWrap">
                                        <select name="pcs1"  id="devPcs1">
                                            <option value="010">010</option>
                                            <option value="011">011</option>
                                            <option value="016">016</option>
                                            <option value="017">017</option>
                                            <option value="018">018</option>
                                            <option value="019">019</option>
                                        </select>
                                        <span class="hyphen">-</span>
                                        <input type="number" name="pcs2" id="devPcs2" value="" title="휴대폰번호">
                                        <span class="hyphen">-</span>
                                        <input type="number"  name="pcs3" id="devPcs3" value="" title="휴대폰번호">
                                    </div>
                                </div>
                            </li>




                            <li class="inputs">
                                <span class="inputs__title"></span>
                                <div class="inputs__content">
                                    <button type="button" class="inputs-certi" id="devCertRequestBtn">인증요청</button>
                                </div>
                            </li>

                            <li class="inputs inputs-certi__number">
                                <span class="inputs__title"><label for='devEmailId'>Authentication number</label></span>
                                <div class="inputs__content">
                                    <input type="text" name="certNo" id="devCertNo" class="inputs__content__number" title="Authentication number">
                                    <button type="button" id="devCertiConfirmBtn" class="inputs-certi__check">인증번호 확인</button>
                                </div>
                            </li>
                        </ul>
                    </div>


                    <!--
                                    <div class="search__inner fb__join-input__form fb__member-search__phone">
                                        <ul class="search__company input-form__content-box">
                                            <li class="inputs">
                                                <span class="inputs__title">Name</span>
                                                <div class="inputs__content">
                                                    <input type="text" name="userName" id="devUserName" class="inputs__content__name">
                                                    <p class="inputs__content__text" name="devUserName" id="devFormatUserName"><?php echo $TPL_VAR["userName"]?></p>
                                                </div>
                                            </li>
                                            <li class="inputs inputs__cellphone">
                                                <span class="inputs__title">Tel</span>
                                                <div class="inputs__content">
                                                    <div class="selectWrap">
                                                        <select name="pcs1"  id="devPcs1">
                                                            <option value="010">010</option>
                                                            <option value="011">011</option>
                                                            <option value="016">016</option>
                                                            <option value="017">017</option>
                                                            <option value="018">018</option>
                                                            <option value="019">019</option>
                                                        </select>
                                                        <span class="hyphen">-</span>
                                                        <input type="number" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["explodePcs"][ 1]?>" title="휴대폰번호" <?php if($TPL_VAR["explodePcs"][ 1]!=''){?>readonly<?php }?>>
                                                        <span class="hyphen">-</span>
                                                        <input type="number"  name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["explodePcs"][ 2]?>" title="휴대폰번호" <?php if($TPL_VAR["explodePcs"][ 2]!=''){?>readonly<?php }?>>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                    -->

                </div>

            </form>
        </section>
        <p class="search__other-link">
            <a href="javascript:void(0)" id="devUserPwdSearchSubmitButton">Accept</a>
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
            <a href="/member/searchId" class="fb__tab-link">
                ID
            </a>
            <a href="/member/searchPw" class="fb__tab-link fb__tab-link--active">
                Password
            </a>
        </nav>



        <section class="search__wrap">
            <form id="devSearchEmailForm">
            <nav class="search__nav">
                <label><input type="radio" name="searchType" value="email" checked="checked"><span>Email</span></label>
                <!--<label><input type="radio" name="searchType" value="phone" class="nav&#45;&#45;phone">휴대폰</label>-->
            </nav>



            <div id="search__password" class="search__content search__content--show">
                <div class="search__inner search__inner--show fb__join-input__form fb__member-search__email">
                    <ul class="search__company input-form__content-box">

                        <li class="inputs">
                            <span class="inputs__title">ID</span>
                            <div class="inputs__content">
                                <input type="text" name="userId" id="devUserId" class="inputs__content__name" title="ID">
                                <p class="inputs__content__text" name="devUserId"></p>
                            </div>
                        </li>

                        <li class="inputs email_group">
                            <span class="inputs__title"><label for='devEmailId'>Email</label></span>
                            <div class="inputs__content">
                                <input type="text" name="userEmail1" id="devUserEmail1" class="input__email"  title="Email">
                                <span class="hyphen_2">@</span>
                                <input type="text" name="userEmail2" id="devUserEmail2" class="input__email"  title="Email">

                            </div>
                        </li>

                        <li class="inputs">
                            <span class="inputs__title"></span>
                            <div class="inputs__content">
                            <button type="button" class="inputs-certi" id="devCertRequestBtn">Authentication number</button>
                            </div>
                        </li>

                        <li class="inputs inputs-certi__number">
                            <span class="inputs__title"><label for='devCertNo'>Authentication number</label></span>
                            <div class="inputs__content">
                                <input type="text" name="certNo" id="devCertNo" class="inputs__content__number" title="Authentication number">
                                <button type="button" id="devCertiConfirmBtn" class="inputs-certi__check">Checking authentication number</button>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>

            </form>
        </section>
        <p class="search__other-link">
            <a href="javascript:void(0)" id="devUserPwdSearchSubmitButton">Accept</a>
        </p>
    </div>
</section>
<?php }?>