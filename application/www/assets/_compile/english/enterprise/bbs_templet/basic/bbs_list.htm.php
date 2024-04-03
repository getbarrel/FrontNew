<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/basic/bbs_list.htm 000003256 */ ?>
<section class="wrap-notice fb__bbs br__customer-list">

<?php $this->print_("customerTop",$TPL_SCP,1);?>


    <form id="devBbsForm" name="devBbsForm">
        <input type="hidden" name="page" value="1" id="devPage"/>
        <input type="hidden" name="max" value="10" id="devMax"/>
        <input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>" id="bType"/>
        <input type='hidden' name='isAjaxList'  value ='Y' id='isAjaxList'/>

        <header class="fb__bbs__header">
            <h1 class="fb__bbs__header__title">Notice</h1>
            <span class="count fb__bbs__header__count"><em id="devTotal"></em></span>
            <div class="fb__bbs__header__filter">
                <select id="sType" name="sType" >
                    <option value="">All</option>
                    <option value="sub">Title</option>
                    <option value="con">Content</option>
                </select>
                <input type="text" id="searchText" name="searchText" title="please enter search word" value="<?php echo $TPL_VAR["searchText"]?>" data-ix="{[ix]}">
                <input type="button" id="btnSearch" value="Search" class="btn-default btn-dark">
            </div>
        </header>
    </form>

    <table class="table-default fb__bbs__table">
        <colgroup>
            <col width="104px">
            <col width="*">
            <col width="150px">
            <col width="104px">
            <!--<col width="97px">
            <col width="130px">
            <col width="">
            <col width="140px">
            <col width="97px">-->
        </colgroup>
        <thead>
            <tr>
                <th>No.</th>
                <!--<th>Sort</th>-->
                <th>Title</th>
                <th>Date</th>
                <th>Views</th>
            </tr>
        </thead>
        <tbody id="devBbsContent">

            <tr id="devBbsList" class="devForbizTpl {[#if soldoutClassName]}showBg{[else]}hideBg{[/if]}">
                <td>
                    {[#if is_notice]}<span class="fb__bbs__table-icon--noti" >Notice</span>{[else]}
                    <p>{[idx]}</p>
                    {[/if]}
                </td>
                <!--<td>{[div_name]}</td>-->
                <td devBbsIx="{[bbs_ix]}" class="table__left-text"><a  style="cursor:pointer" class="customer__list--text">{[{short_subject}]}</a></td>
                <td><em>{[reg_date]}</em></td>
                <td><em>{[bbs_hit]}</em></td>
            </tr>

            <tr id="devBbsLoading" class="devForbizTpl">
                <td colspan="4">
                    <div class="wrap-loading empty-content">
                        <div class="loading"></div>
                    </div>
                </td>
            </tr>

            <tr id="devBbsListEmpty" class="devForbizTpl">
                <td colspan="4">
                    <div class="empty-content">
                        <p id="emptyMsg"><em></em></p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div id="devPageWrap"></div>
</section>