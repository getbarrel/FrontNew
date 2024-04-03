<?php /* Template_ 2.2.8 2020/08/31 15:56:55 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/basic/bbs_list.htm 000001787 */ ?>
<!--공지사항페이지-->
<section class="br__cs-noti br__cs">
        <form id="devBbsForm">
            <input type="hidden" name="page" value="1" id="devPage"/>
            <input type="hidden" name="max" value="20" id="devMax"/>
            <input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>" id="bType"/>
            <input type='hidden' name='isList' value ='Y' id='isList'/>
            <input type='hidden' name='isMobile' value ='Y' id='isMobile'/>
        </form>
      <h2 class="br__cs__title">
          Notice
      </h2>
        <ul class="cs__noti__wrap" id="devBbsContent">
            <li class="cs__noti__list {[#if is_notice]} cs__noti__list--point{[/if]}" id="devBbsList">
                <!-- ** 개발확인 제목영역을 눌러야만 상세로 들어갈 수 있음 a태그 전체로 걸어야함 -->
                <a href="javascript:void(0)" devBbsIx="{[bbs_ix]}">
                    {[#if is_notice]}<span class="cs__noti__badge">Notice</span>{[/if]}
                    <div class="cs__noti__list--middle">
                        <span class="cs__noti__subject" >{[bbs_subject]}</span>
                        <span class="cs__noti__date">{[reg_date]}</span>
                    </div>
                    <span class="cs__noti__barrel">BARREL</span>
                </a>
            </li>
        </ul>

        <div id="devBbsLoading" class="empty-content">
            <p>Loading...</p>
        </div>

        <div id="devBbsEmpty" class="empty-content">
            <p>No results were found</p>
        </div>

        <div id="devPageWrap"></div>
</section>