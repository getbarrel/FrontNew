<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/custom/bbs_list.htm 000002310 */ ?>
<form id="devIrFrom">
    <input type="hidden" name="bType" id="bType" value="<?php echo $TPL_VAR["bType"]?>"/>
    <input type="hidden" name="page" id="devPage" value="1"/>
    <input type="hidden" name="max" id="devMax" value="10"/>
    <input type='hidden' name='isList' value ='Y' id='isList'/>
</form>
<section class="br__ir">
    <section class="br__ir__content">
        <h3 class="br__ir__title">
            <?php echo trans($TPL_VAR["board_name"])?><p>Total <span class="number" id="devListTotal">0</span><?php if($TPL_VAR["langType"]=='korean'){?>ltem(s)<?php }?></p>
        </h3>
        <section class="br__ir__noti">
            <table>
                <caption><?php echo trans($TPL_VAR["board_name"])?></caption>
                <colgroup>
                    <col width="107px">
                    <col width="*">
                    <col width="151px">
                    <col width="133px">
                </colgroup>
                <thead>
                <th><span>No.</span></th>
                <th><span>Title</span></th>
                <th><span>Writer</span></th>
                <th><span>Registraiton date</span></th>
                </thead>
                <tbody id="devMyContent">
                <tr id="devMyLoading" class="devForbizTpl"></tr>
                <tr id="devMyListEmpty" class="devForbizTpl"></tr>
                <tr id="devMyList" class="devForbizTpl">
                    <td>{[no]}</td>
                    <td style="text-align: left;" devBbsIx="{[bbs_ix]}">
                        <div>
                            <a href="#">{[short_subject]}</a>
                            {[#if existFile]}
                            <span class="icon-download"><img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/icon_file-download.png" alt=""></span>
                            {[/if]}
                        </div>
                    </td>
                    <td>{[bbs_name]}</td>
                    <td>{[reg_date]}</td>
                </tr>
                </tbody>
            </table>
            <div id="devPageWrap"></div>
        </section>
    </section>
</section>