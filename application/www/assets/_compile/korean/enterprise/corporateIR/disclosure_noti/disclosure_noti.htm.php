<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/corporateIR/disclosure_noti/disclosure_noti.htm 000002077 */ ?>
<form id="devIrFrom">
      <input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>"/>
      <input type="hidden" name="page" id="devPage" value="1"/>
      <input type="hidden" name="max" id="devMax" value="10"/>
</form>
<section class="br__ir">
      <section class="br__ir__content">
            <h3 class="br__ir__title">
                 board_name<p>총 <span class="number" id="devListTotal">0</span><?php if($TPL_VAR["langType"]=='korean'){?>개<?php }?></p>
            </h3>
            <section class="br__ir__noti">
            <table>
                  <caption>board_name</caption>
                  <colgroup>
                        <col width="107px">
                        <col width="*">
                        <col width="151px">
                        <col width="133px">
                  </colgroup>
                  <thead>
                        <th><span>번호</span></th>
                        <th><span>제목</span></th>
                        <th><span>작성자</span></th>
                        <th><span>등록일</span></th>
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