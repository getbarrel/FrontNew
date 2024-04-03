<?php /* Template_ 2.2.8 2020/10/22 15:42:03 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/my_inquiry/my_inquiry.htm 000007249 */ 
$TPL_bbsDiv_1=empty($TPL_VAR["bbsDiv"])||!is_array($TPL_VAR["bbsDiv"])?0:count($TPL_VAR["bbsDiv"]);
$TPL_bbsStatus_1=empty($TPL_VAR["bbsStatus"])||!is_array($TPL_VAR["bbsStatus"])?0:count($TPL_VAR["bbsStatus"]);?>
<link rel="stylesheet" href="/assets/templet/enterprise/js/themes/base/ui.all.css">

<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<div class="fb__mypage">
    <section class="fb__mypage__search fb__mypage__section">
        <h2 class="fb__mypage__title">1:1 Inquiry Search</h2>

        <form id="devMyInquiryForm">
            <input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>"/>
            <input type="hidden" name="page" id="devPage" value="1"/>
            <input type="hidden" name="max" id="devMax" value="1"/>
            <input type="hidden" name="mypageQnaYn" id="mypageQnaYn" value="Y"/>

            <input type="hidden" name="sDateDef" id="sDateDef" value="<?php echo $TPL_VAR["oneMonth"]?>"/>
            <input type="hidden" name="eDateDef" id="eDateDef" value="<?php echo $TPL_VAR["today"]?>"/>

            <div class="search wrap-sort">
                <div class="search__row">
                    <div class="search__col">
                        <span class="search__col-title">Period</span>
                        <input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick" title="Search begin period">
                        ~
                        <input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick"  title="Search end period">
                    </div>

                    <div class="search__col__day">
                        <div class="day-radio">
                            <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["today"]?>"    data-edate="<?php echo $TPL_VAR["today"]?>">Today</a>
                            <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneWeek"]?>"  data-edate="<?php echo $TPL_VAR["today"]?>"><em>1</em> week</a>
                            <a href="#" class="day-radio__btn devDateBtn day-radio--active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="devDateDefault"><em>1</em> month</a>
                            <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>6</em> months</a>
                            <a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>"  data-edate="<?php echo $TPL_VAR["today"]?>"><em>1</em> year</a>
                        </div>
                    </div>
                </div>


                <div class="search__row">
                    <div class="search__col">
                        <span class="search__col-title">Sort</span>
                        <select class="search__select" name="bbsDiv" id="devBbsDiv">
                            <option value="">All</option>
<?php if($TPL_bbsDiv_1){foreach($TPL_VAR["bbsDiv"] as $TPL_V1){?>
                            <option value="<?php echo $TPL_V1["div_ix"]?>"><?php echo $TPL_V1["div_name"]?></option>
<?php }}?>
                        </select>
                    </div>

                    <div class="search__col wrap-checkbox">
                        <span class="search__col-title">Status</span>
<?php if($TPL_bbsStatus_1){foreach($TPL_VAR["bbsStatus"] as $TPL_V1){?>
                        <label>
                            <input type="checkbox" name="bbs_status[]" class="devStatus" value="<?php echo $TPL_V1["status_ix"]?>" checked="true">
                            <span class="check-area"><?php echo $TPL_V1["status_name"]?></span>
                        </label>
<?php }}?>
                        <!--
                        <label>
                            <input type="checkbox" name="s2" class="devStatus" value="2" checked="true">
                            <span class="check-area">In progress</span>
                        </label>
                        <label>
                            <input type="checkbox" name="s3" class="devStatus" value="5" checked="true">
                            <span class="check-area">Completed</span>
                        </label>
                        -->
                    </div>
                </div>
            </div>
        </form>

        <div class="search__btn">
            <a href="#" id="devBtnReset" class="search__btn--cancel">Reset</a>
            <input type="button" id="devBtnSearch" value="Search" class="search__btn--search">
        </div>
    </section>


    <section class="fb__mypage__section">
        <h2 class="fb__mypage__title clearfix">
            1:1 Inquiry History
            <span class="fb__mypage__title--detail">Total
                <em id="devTotal"></em>
                  
            </span>
            <a href="/customer/qna" class="btn-s btn-dark-line float-r">Write</a>
        </h2>

        <table class="table-default">
            <colgroup>
                <!--<col width="21%">-->
                <col width="15%">
                <col width="*">
                <col width="20%">
                <col width="15%">
            </colgroup>
            <thead>
            <!--<th>Order No.</th>-->
            <th>Sort</th>
            <th>Title</th>
            <th>Written date/Replied date</th>
            <th>Status</th>
            </thead>

            <tbody id="devMyInquiryContent">
            <tr id="devMyInquiryList" class="devForbizTpl">
                <!--<td>{[oid]}</td>-->
                <td>{[div_name]}</td>
                <td class="fb__bbs__subTitle c-pointer one-line" devBbsIx="{[bbs_ix]}">
                    <p class="ellipsis-txt " >
                        {[short_subject]}
                    </p>
                    {[#if complete_status]}
                    <p class="fb__bbs__answer">
                        RE : {[short_subject]}
                    </p>
                    {[/if]}
                </td>
                <td>
                    <span class="font-rb">{[reg_date]}<br>{[res_date]}</span>
                </td>
                <!--답변완료시 색 있는 클래스명은 status--complete-->
                <td class="{[#if res_count]}point-color{[/if]}">{[qna_status]}</td>
            </tr>

            <tr id="devMyInquiryLoading" class="devForbizTpl">
                <td colspan="4">
                    <div class="wrap-loading">
                        <div class="loading"></div>
                    </div>
                </td>
            </tr>

            <tr id="devMyInquiryEmpty" class="devForbizTpl">
                <td colspan="4">
                    <div class="empty-content">
                        <p>No results were found</p>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </section>
    <br>
    <div id="devPageWrap"></div>
</div>