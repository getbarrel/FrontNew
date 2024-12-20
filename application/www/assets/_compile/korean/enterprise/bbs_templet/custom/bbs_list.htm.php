<?php /* Template_ 2.2.8 2024/02/13 15:02:51 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/custom/bbs_list.htm 000003646 */ ?>
<form id="devIrFrom">
    <input type="hidden" name="bType" id="bType" value="<?php echo $TPL_VAR["bType"]?>"/>
    <input type="hidden" name="page" id="devPage" value="1"/>
    <input type="hidden" name="max" id="devMax" value="10"/>
    <input type='hidden' name='isList' value ='Y' id='isList'/>
</form>
<!-- 컨텐츠 S -->
<section class="br__ir fb-corporateIR">
	<section class="br__ir__content-wrap fb-corporateIR__content-wrap">
		<div class="br__ir__header fb-corporateIR__header">
			<h2 class="title-md"><?php echo trans($TPL_VAR["board_name"])?></h2>
		</div>
		<section class="br__ir__content fb-corporateIR__content">
			<section class="br__ir__noti fb-corporateIR__noti board-bbs__wrap">
				<ul class="board-bbs__list" id="devMyContent">
					
					<li id="devMyLoading" class="board-bbs__item no-data"></li>
					<li id="devMyListEmpty" class="board-bbs__item no-data"><p class="empty-content">등록된 공지사항이 없습니다.</p></li>
					
					<li id="devMyList" class="board-bbs__item">
						<div class="board-bbs__title-group">
							<div class="board-bbs__title-sub">
								<span class="board-bbs__category">[BARREL]</span>
								<span class="board-bbs__day">{[reg_date]}</span>
							</div>
							<div class="board-bbs__title" devBbsIx="{[bbs_ix]}">
								<a class="board-bbs__link" href="#;">
									{[short_subject]}
									<i class="ico ico-arrow-right"></i>
								</a>
							</div>
						</div>
					</li>
				</ul>

				<!-- 페이지네이션 S -->
				<div id="devPageWrap"></div>
				<!-- 페이지네이션 E -->
			</section>
		</section>
	</section>
</section>
<!-- 컨텐츠 E -->
<!--
<section class="br__ir">
    <section class="br__ir__content">
        <h3 class="br__ir__title">
            <?php echo trans($TPL_VAR["board_name"])?><p>총 <span class="number" id="devListTotal">0</span><?php if($TPL_VAR["langType"]=='korean'){?>개<?php }?></p>
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
                <th><span>번호</span></th>
                <th><span>제목</span></th>
                <th><span>작성자</span></th>
                <th><span>등록일</span></th>
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
-->