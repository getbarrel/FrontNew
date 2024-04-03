<?php /* Template_ 2.2.8 2020/08/31 15:56:55 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/bbs_templet/custom/bbs_list.htm 000004739 */ ?>
<form id="devIrFrom">
    <input type="hidden" name="bType" id="bType" value="<?php echo $TPL_VAR["bType"]?>"/>
    <input type="hidden" name="page" id="devPage" value="1"/>
    <input type="hidden" name="max" id="devMax" value="10"/>
    <input type='hidden' name='isList' value ='Y' id='isList'/>
</form>
<section class="br__ir">
    <header class="br__ir__top">
        <div class="br__title-box">
            <button type="button" class="br__title-box__back">Back</button>
            <h2 class="br__title-box__title">Corporate IR</h2>
        </div>
        <nav class="br__ir__nav">
            <ul>
                <li><a href="/corporateIR/financialInfo/">Financial information</a></li>
                <li <?php if($TPL_VAR["bType"]=='disclosure'||$TPL_VAR["bType"]=='announce'){?> class="br__ir__nav--active" <?php }?> class="eng-hidden"><a href="/corporateIR/disclosureNoti">Announcement</a></li>
                <li <?php if($TPL_VAR["bType"]=='ir'){?> class="br__ir__nav--active" <?php }?>><a href="/corporateIR/IRResources/">IR Data</a></li>
                <li <?php if($TPL_VAR["bType"]=='press'){?> class="br__ir__nav--active" <?php }?> ><a href="/corporateIR/pressReleases/">Press release</a></li>
            </ul>
        </nav>
    </header>
    <section class="br__ir__content">
<?php if($TPL_VAR["bType"]=='disclosure'||$TPL_VAR["bType"]=='announce'){?>
        <h3 class="br__hidden">공시공고</h3>
        <div class="br__ir__tab">
            <button class="tab--first devBoardTab <?php if($TPL_VAR["bType"]=="disclosure"){?> br__ir__tab--active <?php }?>" data-board="disclosure">Public announcement</button>
            <button class="tab--second devBoardTab <?php if($TPL_VAR["bType"]=="announce"){?> br__ir__tab--active <?php }?>" data-board="announce">Public announcement</button>
        </div>
<?php }?>
        <!--tab1-->
        <div class="br__ir__tab-detail <?php if($TPL_VAR["bType"]=="disclosure"||$TPL_VAR["bType"]=="announce"){?> br__ir__tab-detail--type2 <?php }?> br__ir__tab-detail--show" id="devMyContent">
            <ul class="irlist">
                <li id="devMyLoading" class="devForbizTpl"></li>
                <li id="devMyListEmpty" class="empty-content devForbizTpl">
<?php if($TPL_VAR["bType"]=='disclosure'||$TPL_VAR["bType"]=='announce'){?>
                    <p>(english)등록된 공시공고가 없습니다.</p>
<?php }else{?>
                    <p>There are no registered press releases.</p>
<?php }?>
                </li>

<?php if($TPL_VAR["bType"]=='disclosure'||$TPL_VAR["bType"]=='announce'){?>
                <li class="irlist__each irlist__each--type2 devForbizTpl" id="devMyList">
                    <span class="irlist__each__date">{[reg_date]}</span>
                    <div class="irlist__each__left" devBbsIx="{[bbs_ix]}">
                        <!--<span class="irlist__each__num">{[no]}</span>-->
                        <p class="irlist__each__title">
                            {[short_subject]}
                            {[#if existFile]}
                            <span class="icon-download"><img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_file-download.png" alt=""></span>
                            {[/if]}
                        </p>
                        <p>{[bbs_name]}</p>
                    </div>
                </li>
<?php }else{?>
                <li class="irlist__each devForbizTpl" id="devMyList">
                    <div class="irlist__each__left" devBbsIx="{[bbs_ix]}">
                        <span class="irlist__each__num">{[no]}</span>
                        <p class="irlist__each__title">{[short_subject]}</p>
                    </div>
                    <span class="irlist__each__date">{[reg_date]}</span>
                </li>
<?php }?>
            </ul>
        </div>
        <div id="devPageWrap"></div>
        <!--tab2-->
        <!--<div class="br__ir__tab-detail br__ir__tab-detail&#45;&#45;second">-->
            <!--<ul class="irlist">-->
                <!--<li class="irlist__each">-->
                    <!--<div class="irlist__each__left">-->
                        <!--<span class="irlist__each__num">1</span>-->
                        <!--<p class="irlist__each__title">공고공고공고공고공고공고공고공고공고공고공고공고공고공고공고공고</p>-->

                    <!--</div>-->
                    <!--<span class="irlist__each__date">19.03.12</span>-->
                <!--</li>-->
            <!--</ul>-->
        <!--</div>-->
    </section>
</section>