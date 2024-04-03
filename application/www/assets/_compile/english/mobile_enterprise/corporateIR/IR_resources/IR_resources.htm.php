<?php /* Template_ 2.2.8 2020/08/31 15:56:56 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/corporateIR/IR_resources/IR_resources.htm 000004510 */ ?>
<section class="br__ir">
      <header class="br__ir__top">
            <div class="br__title-box">
                  <button type="button" class="br__title-box__back">Back</button>
                  <h2 class="br__title-box__title">Corporate IR</h2>
            </div>
            <nav class="br__ir__nav">
                  <ul>
                        <li><a href="/corporateIR/financialInfo/">Financial information</a></li>
                        <li class="eng-hidden"><a href="/corporateIR/disclosureNoti/">Announcement</a></li>
                        <li class="br__ir__nav--active"><a href="/corporateIR/IRResources/">IR Data</a></li>
                        <li><a href="/corporateIR/pressReleases/">Press release</a></li>
                  </ul>
            </nav>
      </header>

      <section class="br__ir__content">
            <form id="devBbsForm">
                  <input type="hidden" name="page" value="1" id="devPage"/>
                  <input type="hidden" name="max" value="5" id="devMax"/>
                  <input type="hidden" name="bType" value="ir" id="bType"/>
                  <input type='hidden' name='isList' value ='Y' id='isList'/>
                  <input type='hidden' name='isMobile' value ='Y' id='isMobile'/>
            </form>

            <h3 class="br__ir__content-title">IR Data</h3>

            <ul class="br__ir__list" id="devBbsContent">
                  <ul class="irlist devForbizTpl" id="devBbsList" devBbsIx="{[bbs_ix]}">
                        <li class="irlist__each">
                              <div class="irlist__each__left" >
                                    <span class="irlist__each__num">{[no]}</span>
                                    <p class="irlist__each__title">{[bbs_subject]}</p>
                                    {[#if bbs_file_1]}
                                    <a href="<?php echo $TPL_VAR["download_path"]?>/{[bbs_ix]}/{[bbs_file_1]}" download>
                                    <button class="irlist__each__download">Attachment</button>
                                    </a>
                                    {[/if]}
                              </div>
                              <span class="irlist__each__date">{[reg_date2]}</span>
                        </li>
                  </ul>
            </ul>
            <div id="devBbsLoading" class="empty-content devForbizTpl">
                  <p>Loading...</p>
            </div>

            <div id="devBbsEmpty" class="empty-content devForbizTpl">
                  <p>No results were found</p>
            </div>

            <div id="devPageWrap"></div>
      </section>
</section>



<!--공지사항페이지-->
<!--

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
            <li class="cs__noti__list {[#if is_notice]} cs__noti__list&#45;&#45;point{[/if]}" id="devBbsList">
                  &lt;!&ndash; ** 개발확인 제목영역을 눌러야만 상세로 들어갈 수 있음 a태그 전체로 걸어야함 &ndash;&gt;
                  <a href="javascript:void(0)" devBbsIx="{[bbs_ix]}">
                        {[#if is_notice]}<span class="cs__noti__badge">Notice</span>{[/if]}
                        <div class="cs__noti__list&#45;&#45;middle">
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

-->