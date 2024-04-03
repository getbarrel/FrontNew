<?php /* Template_ 2.2.8 2020/08/31 15:57:06 /home/barrel-stage/application/www/assets/templet/enterprise/corporateIR/IR_resources/IR_resources.htm 000002756 */ ?>
<form id="devBbsForm">
      <input type="hidden" name="page" value="1" id="devPage"/>
      <input type="hidden" name="max" value="5" id="devMax"/>
      <input type="hidden" name="bType" value="ir" id="bType"/>
      <input type='hidden' name='isList' value ='Y' id='isList'/>
      <input type='hidden' name='isMobile' value ='N' id='isMobile'/>
</form>
<section class="br__ir">
      <section class="br__ir__content">
            <h3 class="br__ir__title">
                  IR Data <p>Total <span class="number" id="devListTotal">0</span> <?php if($TPL_VAR["langType"]=='korean'){?>ltem(s)<?php }?></p>
            </h3>
            <section class="br__ir__noti">
                <table>
                    <caption>Public announcement</caption>
                    <colgroup>
                          <col width="107px">
                          <col width="*">
                          <col width="151px">
                          <col width="133px">
                    </colgroup>
                    <tr>
                          <th><span>No.</span></th>
                          <th><span>Title</span></th>
                          <th><span>Attachment</span></th>
                          <th><span>Registraiton date</span></th>
                    </tr>
                    <tbody id="devBbsContent">
                    <tr id="devBbsLoading" class="devForbizTpl">
                          <td colspan="4">Loading...</td>
                    </tr>
                    <tr id="devBbsEmpty" class="devForbizTpl">
                        <td>No results were found</td>
                    </tr>
                    <tr id="devBbsList" class="devForbizTpl">
                          <td>{[no]}</td>
                          <td style="text-align: left;" devBbsIx="{[bbs_ix]}">
                                <div>
                                      <a href="javascript:void(0);">{[bbs_subject]}</a>
                                </div>
                          </td>
                        <td>
                            {[#if bbs_file_1]}
                            <a href="<?php echo $TPL_VAR["download_path"]?>/{[bbs_ix]}/{[bbs_file_1]}" download><button type="button"><?php if($TPL_VAR["langType"]=='korean'){?>Attachment<?php }else{?>Download<?php }?></button></a>
                            {[/if]}
                        </td>
                        <td>{[reg_date]}</td>
                    </tr>
                    </tbody>
                </table>
                <div id="devPageWrap"></div>
            </section>
      </section>
</section>