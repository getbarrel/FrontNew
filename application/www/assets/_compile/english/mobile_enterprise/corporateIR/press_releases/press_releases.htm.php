<?php /* Template_ 2.2.8 2020/08/31 15:56:56 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/corporateIR/press_releases/press_releases.htm 000002471 */ ?>
<section class="br__ir">
      <header class="br__ir__top">
            <div class="br__title-box">
                  <button type="button" class="br__title-box__back">Back</button>
                  <h2 class="br__title-box__title">Corporate IR</h2>
            </div>
            <nav class="br__ir__nav">
                  <ul>
                        <li><a href="/corporateIR/financialInfo/">Financial information</a></li>
                        <li><a href="/corporateIR/disclosureNoti/">Announcement</a></li>
                        <li><a href="/corporateIR/IRResources/">IR Data</a></li>
                        <li class="br__ir__nav--active"><a href="/corporateIR/pressReleases/">Press release</a></li>
                  </ul>
            </nav>
      </header>
+
      <section class="br__ir__content">
            <form id="devBbsForm">
                  <input type="hidden" name="page" value="1" id="devPage"/>
                  <input type="hidden" name="max" value="5" id="devMax"/>
                  <input type="hidden" name="bType" value="press" id="bType"/>
                  <input type='hidden' name='isList' value ='Y' id='isList'/>
                  <input type='hidden' name='isMobile' value ='Y' id='isMobile'/>
            </form>

            <h3 class="br__ir__content-title">press release</h3>
            <ul class="irlist" id="devBbsContent">
                  <li class="irlist__each" id="devBbsList">
                        <div class="irlist__each__left" devBbsIx="{[bbs_ix]}">
                              <span class="irlist__each__num">{[no]}</span>
                              <p class="irlist__each__title">{[bbs_subject]}
                                    <span>Download</span></p>
                              <span class="irlist__each__id">{[bbs_name]}</span>
                        </div>
                        <span class="irlist__each__date">{[reg_date2]}</span>
                  </li>
            </ul>

            <div id="devBbsLoading" class="empty-content">
                  <p>Loading...</p>
            </div>

            <div id="devBbsEmpty" class="empty-content">
                  <p>There are no registered press releases.</p>
            </div>

            <div id="devPageWrap"></div>
      </section>
</section>