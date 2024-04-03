<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/corporateIR/disclosure_noti/disclosure_noti.htm 000002102 */ ?>
<form id="devIrFrom">
      <input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>"/>
      <input type="hidden" name="page" id="devPage" value="1"/>
      <input type="hidden" name="max" id="devMax" value="10"/>
</form>
<section class="br__ir">
      <section class="br__ir__content">
            <h3 class="br__ir__title">
                 (english)board_name<p>Total <span class="number" id="devListTotal">0</span><?php if($TPL_VAR["langType"]=='korean'){?>ltem(s)<?php }?></p>
            </h3>
            <section class="br__ir__noti">
            <table>
                  <caption>(english)board_name</caption>
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
                        <tr id="devMyLoading"></tr>
                        <tr id="devMyListEmpty"></tr>
                        <tr id="devMyList">
                              <td>{[no]}</td>
                              <td style="text-align: left;" devBbsIx="{[bbs_ix]}">
                                    <div>
                                          <a href="#">{[short_subject]}</a>
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