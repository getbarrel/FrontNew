<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/teacher/bbs_list.htm 000004398 */ ?>
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
                <span>My location</span>
                <ol>
                    <li><a href="/">Home</a></li>
                    <li><a href="/board/index.html">Board</a></li>
                    <li title="현재 위치"><strong>Recruitment of barrel teacher members</strong></li>
                </ol>
            </div>

            <div class="title">
                <h2>Teacher member recruitment</h2>
                <p>If you become a barrel teacher member, you can get a 15% discount on the category when you purchase items.</p>
            </div>
            <!--<h1 class="fb__bbs__header__title">Teacher member recruitment</h1>-->
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
            <th>No.</th>
            <th>Sort</th>
            <th>Title</th>
            <th>Writer</th>
            <th>Status</th>
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
                Completed
                {[else]}
                Pending
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
    <div class="write">
        <a href="javascript:void(0)" id="devBbsWrite" class="btn-s btn-dark-line float-r">Register</a>
    </div>
    <div id="devPageWrap"></div>

</section>