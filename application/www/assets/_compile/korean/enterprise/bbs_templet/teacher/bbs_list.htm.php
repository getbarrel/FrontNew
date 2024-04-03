<?php /* Template_ 2.2.8 2022/08/26 15:31:57 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/teacher/bbs_list.htm 000004459 */ ?>
<section class="br__teacher-member">
    <figure>
        <!--<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/barrel_teacher.jpg" alt="티처멤버 모집">-->
        <img src="http://image2.getbarrel.com/landing/teacher/barrel_teacher_landing_web.jpg" alt="티처멤버 모집">
    </figure>
</section>
<section class="wrap-notice fb__bbs br__customer-list br__bbsModule">

    <form id="devBbsForm" name="devBbsForm">
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="10" id="devMax"/>
        <input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>" id="bType"/>
        <input type='hidden' name='isAjaxList'  value ='Y' id='isAjaxList'/>

        <header class="fb__bbs__header">

            <div class="path">
                <span>현재 위치</span>
                <ol>
                    <li><a href="/">홈</a></li>
                    <li><a href="/board/index.html">게시판</a></li>
                    <li title="현재 위치"><strong>배럴 티처 멤버 모집</strong></li>
                </ol>
            </div>

            <div class="title">
                <h2>티처멤버 모집</h2>
                <p>배럴 티처 멤버가 되시면, 종목에 따른 구분을 하여 상품구매 시 해당 카테고리 15% 할인 혜택을 받으실 수 있습니다.</p>
            </div>
            <!--<h1 class="fb__bbs__header__title">티처멤버 모집</h1>-->
            <!--<span class="count fb__bbs__header__count"><em id="devTotal"></em></span>-->

        </header>
    </form>
    <table class="table-default fb__bbs__table">
        <colgroup>
            <col width="104px">
            <col width="110px">
            <col width="*">
            <col width="100px">
            <col width="100px">
        </colgroup>
        <thead>
        <tr>
            <th>번호</th>
            <th>분류</th>
            <th>제목</th>
            <th>작성자</th>
            <th>처리상태</th>
        </tr>
        </thead>
        <tbody id="devBbsContent">

        <tr id="devBbsList" class="devForbizTpl " >
            <td>
                <p>{[idx]}</p>
            </td>
            <td><em>{[div_name]}</em></td>
            <td devBbsIx="{[bbs_ix]}" class="table__left-text" data-issameuser="{[isSameUser]}">
                <a style="cursor:pointer" class="">{[short_subject]}</a>
                {[#if bbs_hidden]}
                <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/icon_201701251431174700.gif" alt="비밀글" class="ec-common-rwd-image">
                {[/if]}
                {[#if bbs_file_exist]}
                <img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/icon_201404041807316100.png" alt="파일첨부" class="ec-common-rwd-image">
                {[/if]}
                {[#if res_count]}
                <span class="txtEm">[{[res_count]}]</span>
                {[/if]}
            </td>
            <!--<td><em>{[reg_date]}</em></td>-->
            <!--<td><em>{[bbs_hit]}</em></td>-->
            <td>
                <em>
                    {[#if isSameUser]}
                        {[bbs_name]}
                    {[else]}
                        {[short_bbs_name]}
                    {[/if]}
                </em>
            </td>

            <td>
                <em>
                {[#if res_count]}
                답변완료
                {[else]}
                답변대기
                {[/if]}
                </em>
            </td>


        </tr>

        <tr id="devBbsLoading" class="devForbizTpl">
            <td colspan="5">
                <div class="wrap-loading empty-content">
                    <div class="loading"></div>
                </div>
            </td>
        </tr>

        <tr id="devBbsListEmpty" class="devForbizTpl">
            <td colspan="5">
                <div class="empty-content">
                    <p id="emptyMsg"><em></em></p>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <!--div class="write">
        <a href="javascript:void(0)" id="devBbsWrite" class="btn-s btn-dark-line float-r">신청하기</a>
    </div-->
    <div id="devPageWrap"></div>

</section>