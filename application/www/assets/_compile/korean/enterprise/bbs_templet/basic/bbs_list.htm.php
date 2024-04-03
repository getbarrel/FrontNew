<?php /* Template_ 2.2.8 2024/01/29 15:08:16 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/basic/bbs_list.htm 000002498 */ ?>
<style>
/*로딩*/
.wrap-loading {
    position: relative;
    padding: 0px 0;
    z-index: 99;
    width: 100%;
}

.wrap-loading .loading {
    display: block;
    margin: 0 auto;
    width: 50px;
    height: 50px;
    border: 3px solid rgba(0, 0, 0, .1);
    border-radius: 50%;
    border-top-color: #00bce7;
    animation: spin 1s ease-in-out infinite;
    -webkit-animation: spin 1s ease-in-out infinite;
}
</style>
<section class="wrap-notice fb__bbs br__customer-list">
    <form id="devBbsForm" name="devBbsForm">
	<input type="hidden" name="page" value="1" id="devPage"/>
	<input type="hidden" name="max" value="10" id="devMax"/>
	<input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>" id="bType"/>
	<input type='hidden' name='isAjaxList'  value ='Y' id='isAjaxList'/>
	<input type='hidden' name='sType'  value ='' id='sType'/>
	<div class="board-bbs__wrap">
		<div class="board-bbs__header">
			<div class="title-md">공지사항</div>
		</div>
		<div class="board-search__wrap">
			<div class="board-search__form">
				<input type="text" id="searchText" name="searchText" title="검색어 입력" class="fb__form-input" placeholder="검색어를 입력하세요." value="<?php echo $TPL_VAR["searchText"]?>" data-ix="{[ix]}" />
				<button type="button" id="btnSearch" class="btn-search"><i class="ico ico-search"></i></button>
			</div>
		</div>
    </form>
	<ul class="board-bbs__list" id="devBbsContent">
		<li class="board-bbs__item" id="devBbsList" >
			<div class="board-bbs__title-group">
				<div class="board-bbs__title-sub">
					<span class="board-bbs__category">
					{[#if is_notice]}<span class="fb__bbs__table-icon--noti" >공지</span>{[else]}
					<!-- <p>{[idx]}</p> -->
					{[/if]}
					</span>
					<span class="board-bbs__day">{[reg_date]}</span>
				</div>
				<div devBbsIx="{[bbs_ix]}" class="board-bbs__title">
					<a style="cursor:pointer"  class="board-bbs__link">
						{[{short_subject}]}
						<i class="ico ico-arrow-right"></i>
					</a>
				</div>
			</div>
		</li>

		<li class="board-bbs__item" id="devBbsLoading">
			<div class="wrap-loading">
				<div class="loading"></div>
			</div>
		</li>

		<li class="board-bbs__item" id="devBbsListEmpty">
			<p class="empty-content">등록된 공지사항이 없습니다.</p>
		</li>
	</ul>

    <div id="devPageWrap"></div>
</section>