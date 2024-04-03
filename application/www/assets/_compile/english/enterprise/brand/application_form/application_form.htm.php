<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/brand/application_form/application_form.htm 000004844 */ ?>
<section class="br__apply">
    <h2 class="br__apply__title">2020 배럴 스프린트 챔피언십<br> 온라인 참가 신청</h2>
    <p class="br__apply__desc">개인과 단체를 잘 구분하여 신청해 주시기 바랍니다.</p>
    <div class="apply__btn">
        <a href="#" id="goIndivisual" class="apply__btn--personal">개인 신청하러 가기</a>
        <a href="#" id="goGroup" class="apply__btn--group">단체 신청하러 가기</a>
        <button type="button" class="apply__btn--check">내 신청서 조회 / 수정하러 가기</button>
    </div>
    <section class="inquiry-info">
        <h3 class="inquiry-info__title">내 신청서 조회 / 수정하기</h3>
        <p class="inquiry-info__desc">
            내가 신청한 신청서를 조회할 수 있습니다. 잘못 기입한 사항이 있으면<br>수정할 수 있으니 수정 가능기간(01. 02 ~ 01. 09) 을 확인 후 수정 바랍니다.
        </p>
        <div class="inquiry__inputbox inquiry__inputbox--personal">
            <h3>개인 신청서 확인 및 신청서 수정</h3>
            <form id="devBasicForm" method="post" autocomplete="off">
                <input type="hidden" name="type" value="I"/>
                <dl class="inquiry__inputbox__list">
                    <dt class="inquiry__inputbox__title">이름(실명)</dt>
                    <dd class="inquiry__inputbox__input">
                        <input type="text" id="devName" name="name"  value="" title="이름(실명)"/>
                    </dd>
                </dl>
                <dl class="inquiry__inputbox__list">
                    <dt class="inquiry__inputbox__title">생년월일</dt>
                    <dd class="inquiry__inputbox__input">
                        <input type="text" id="devBirthday" name="birthday" value="" title="생년월일"/>
                        <span>(예: 830724)</span>
                    </dd>
                </dl>
                <dl class="inquiry__inputbox__list">
                    <dt class="inquiry__inputbox__title">비밀번호</dt>
                    <dd class="inquiry__inputbox__input">
                        <input type="password" name="password" id="devPassword" value="" title="비밀번호"/>
                        <!-- 비밀번호 경고문구 노출 : class 에 "password-warning--show" 추가 -->
                        <p class="inquiry__inputbox__desc password-warning">비밀번호가 틀립니다. 다시 입력해주세요.</p>
                        <p class="inquiry__inputbox__desc">신청서 작성 시 기입했던 신청서 비밀번호를 입력해 주세요.</p>
                    </dd>
                </dl>
                <button type="button" class="inquiry__inputbox__btn" id="devIndivisual">조회하기</button>
            </form>

        </div>
        <div class="inquiry__inputbox">
            <form id="devGroupForm" method="post" autocomplete="off">
                <input type="hidden" name="type" value="G"/>
                <h3>단체 신청서 확인 및 신청서 수정</h3>
                <dl class="inquiry__inputbox__list">
                    <dt class="inquiry__inputbox__title">단체명</dt>
                    <dd class="inquiry__inputbox__input">
                        <input type="text" name="group_name" id="devGroupName" value="" title="단체명">
                    </dd>
                </dl>
                <dl class="inquiry__inputbox__list">
                    <dt class="inquiry__inputbox__title">감독자(대표자)</dt>
                    <dd class="inquiry__inputbox__input">
                        <input type="text" name="group_master" id="devMasterName" value="" title="감독자(대표자)">
                    </dd>
                </dl>
                <dl class="inquiry__inputbox__list">
                    <dt class="inquiry__inputbox__title">비밀번호</dt>
                    <dd class="inquiry__inputbox__input">
                        <input type="password" name="password" id="devMasterPassword" title="비밀번호">
                        <!-- 비밀번호 경고문구 노출 : class 에 "password-warning&#45;&#45;show" 추가 -->
                        <p class="inquiry__inputbox__desc password-warning">비밀번호가 틀립니다. 다시 입력해주세요.</p>
                        <p class="inquiry__inputbox__desc">신청서 작성 시 기입했던 신청서 비밀번호를 입력해 주세요.</p>
                    </dd>
                </dl>
                <button type="button" class="inquiry__inputbox__btn" id="devGroup">조회하기</button>
            </form>

        </div>
    </section>
</section>