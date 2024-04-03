<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/my_goods_inquiry/my_goods_inquiry.htm 000008024 */ 
$TPL_divsInfo_1=empty($TPL_VAR["divsInfo"])||!is_array($TPL_VAR["divsInfo"])?0:count($TPL_VAR["divsInfo"]);?>
<link rel="stylesheet" href="/assets/templet/enterprise/js/themes/base/ui.all.css">

<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<div class="wrap-mypage fb__mypage">
    <section class="fb__mypage__search">
        <h2 class="fb__mypage__title">Search inquiry history</h2>

        <form id="devMyGoodsInquiryForm">
            <input type="hidden" name="type" value="mine"/>
            <input type="hidden" name="page" id="devPage" value="1"/>
            <input type="hidden" name="max" id="devMax" value="10"/>
            <input type="hidden" name="sDateDef" id="sDateDef" value="<?php echo $TPL_VAR["sDate"]?>" />
            <input type="hidden" name="eDateDef" id="eDateDef" value="<?php echo $TPL_VAR["eDate"]?>" />

            <div class="search ">
                <div class="search__row">
                    <div class="search__col">
                        <span class="search__col-title">Period</span>
                        <input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick" title="조회시작기간">
                        ~
                        <input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick"  title="조회종료기간">
                    </div>

                    <div class="search__col__day">
                        <div class="day-radio">
                            <a href="#"  class="day-radio__btn today devDateBtn" data-sdate="<?php echo $TPL_VAR["today"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">Today</a>
                            <a href="#"  class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneWeek"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>1</em> week</a>
                            <a href="#"  class="day-radio__btn devDateBtn day-radio--active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>" id="devDateDefault"><em>1</em> month</a>
                            <a href="#"  class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>6</em> months</a>
                            <a href="#"  class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"><em>1</em> year</a>
                        </div>
                    </div>
                </div>
                <div class="search__row">
                    <!--<div class="search__col">-->
                        <!--<label class="search__col-title" for="devDivInfo">Sort</label>-->
                        <!--<select class="search__select" name="bbsDiv" id="devDivInfo">-->
                            <!--<option value="">All</option>-->
<?php if($TPL_divsInfo_1){foreach($TPL_VAR["divsInfo"] as $TPL_V1){?>
                            <!--<option value="<?php echo $TPL_V1["ix"]?>"><?php echo $TPL_V1["div_name"]?></option>-->
<?php }}?>
                        <!--</select>-->
                    <!--</div>-->

                    <div class="search__col wrap-checkbox">
                        <span class="search__col-title">Status</span>
                        <!--<label>-->
                            <!--<input type="radio" name="resYn" value="" checked>-->
                            <!--<span class="check-area">All</span>-->
                        <!--</label>-->
                        <!--<label>-->
                            <!--<input type="radio" name="resYn" value="N">-->
                            <!--<span class="check-area">Pending</span>-->
                        <!--</label>-->
                        <!--<label>-->
                            <!--<input type="radio" name="resYn" value="Y">-->
                            <!--<span class="check-area">Completed</span>-->
                        <!--</label>-->
                        <span class="check-area">
                            <input type="checkbox" name="ready" id="ready" value="Y"><label for="ready">Pending</label>
                        </span>
                        <span class="check-area">
                            <input type="checkbox" name="complete" id="complete" value="Y"><label for="complete">Completed</label>
                        </span>
                    </div>
                </div>
            </div>
        </form>

        <div class="search__btn ">
            <a href="#" id="devBtnReset" class="search__btn--cancel">Reset</a>
            <input type="button" id="devBtnSearch" value="Search" class="search__btn--search">
        </div>
    </section>


    <section class="fb__bbs">
        <h2 class="fb__mypage__title">
            Item Q&A
            <span class="fb__mypage__title--detail">
                Total <em id="devTotal" class="fb__n"></em>  
            </span>
        </h2>
        <table class="table-default inquiry-table">
            <colgroup>
                <!--<col width="6%">-->
                <col width="15%">
                <col width="*">
                <col width="20%">
                <col width="15%">
            </colgroup>
            <thead>
            <th>Sort</th>
            <!--<th>Product Name</th>-->
            <th>Title</th>
            <th>Written date/Replied date</th>
            <th>Status</th>
            </thead>

            <tbody id="devMyContent">
            <tr id="devMyList" class="devForbizTpl">
                <td>
                    {[div_name]}
                </td>
                <!--<td>-->
                    <!--<a href="/shop/goodsView/{[pid]}" target="_blank" class="item">-->
                        <!--<div class="thumb">-->
                            <!--<img src="{[image_src]}" alt="{[#if brand_name]} [{[brand_name]}] {[/if]} {[pname]}">-->
                        <!--</div>-->
                        <!--<div class="info">-->
                            <!--<p class="title"> {[#if brand_name]} [{[brand_name]}] {[/if]} {[pname]}</p>-->
                        <!--</div>-->
                    <!--</a>-->
                <!--</td>-->
                <td class="fb__bbs__subTitle" devBbsIx="{[bbs_ix]}">
                    <p>
                        <a href="#">
                            <span class="ellipsis-txt">
                                {[bbs_subject]}
                            </span>
                        </a>
                    </p>
                    {[#if isResponse]}
                    <p class="fb__bbs__answer">
                        RE : {[bbs_subject]}
                    </p>
                    {[/if]}
                </td>
                <td>
                    <span class="fb__n br__bbs__date">{[regdate]}</span>
                    <span class="fb__n br__bbs__date">{[resDate]}</span>
                </td>
                <td class="{[#if isResponse]}point-color{[/if]}">
                    {[#if isResponse ]}
                        Completed
                    {[else]}
                        Pending
                    {[/if]}
                </td>
            </tr>

            <tr id="devMyLoading" class="devForbizTpl">
                <td colspan="4">
                    <div class="wrap-loading">
                        <div class="loading"></div>
                    </div>
                </td>
            </tr>

            <tr id="devMyListEmpty" class="devForbizTpl">
                <td colspan="4">
                    <div class="empty-content">
                        <p>No results are found.</p>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </section>
    <div id="devPageWrap"></div>

</div>