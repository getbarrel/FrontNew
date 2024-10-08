<?php /* Template_ 2.2.8 2024/01/30 11:59:41 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/mileage/mileage.htm 000006051 */ ?>
<link rel="stylesheet" href="/assets/templet/enterprise/js/themes/base/ui.all.css">
<!-- 컨텐츠 S -->
<section class="fb__mypage wrap-mypage fb__mileage">
	<div class="fb__mypage-title">
		<div class="title-md">적립금</div>
	</div>
	<div class="mileage">
		<section class="mileage__top">
			<div class="mileage__inner">
				<dl class="mileage__top-info">
					<dt class="mileage__top-left">
						<div class="title-md">현재 사용 가능 적립금</div>
						<div class="available-mileage"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo $TPL_VAR["myMileAmount"]?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
					</dt>
					<dd class="mileage__top-right">
						<div class="mileage__top-item">
							<span class="tit">적립 예정</span>
							<div class="accumulate-mileage"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo $TPL_VAR["myMileageWaitAmount"]?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
						</div>
						<div class="mileage__top-item">
							<a href="#;" class="mileage__top-item--link">
								<span class="tit">소멸 예정</span>
								<div class="expired-mileage"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo $TPL_VAR["ext_mileage_amount"]?></em> <?php echo $TPL_VAR["fbUnit"]["b"]?></div>
							</a>
						</div>
					</dd>
				</dl>
			</div>
		</section>
		<section class="fb__mypage__search">
				<div class="search">
					<div class="fb-tab__nav">
						<ul>
							<li devFilterState="" class="active">
								<a href="#;">전체</a>
							</li>
							<li devFilterState="1" >
								<a href="#;">적립</a>
							</li>
							<li devFilterState="2" >
								<a href="#;">사용</a>
							</li>
						</ul>
					</div>
					<form id="devMileageForm">
					<input type="hidden" name="page" value="1" id="devPage"/>
					<input type="hidden" name="max" value="10" id="devMax"/>
					<input type="hidden" name="state" value="" id="state"/>
					<input type="hidden" name="sDateDef" id="sDateDef" value="<?php echo $TPL_VAR["sDate"]?>" />
					<input type="hidden" name="eDateDef" id="eDateDef" value="<?php echo $TPL_VAR["eDate"]?>" />
					<div class="search__row">
						<div class="search__col">
							<div class="fb__form-item">
								<label for="devSdate" class="hide">조회기간</label>
								<input type="text" id="devSdate" name="sDate" value="<?php echo $TPL_VAR["oneMonth"]?>" class="search__date-input date-pick fb__form-input" title="조회시작기간" />
								<span>-</span>
								<input type="text" id="devEdate" name="eDate" value="<?php echo $TPL_VAR["today"]?>" class="search__date-input date-pick fb__form-input" title="조회종료기간" />
								<button type="button" id="devBtnSearch" title="조회" class="btn-lg btn-dark-line ">조회</button>
								<!-- <button type="submit" id="devBtnSearch" value="검색" title="검색" alt="검색" class="btn-lg btn-dark-line search__btn--search"> -->
							</div>
						</div>
						<div class="search__col">
							<div class="search__day">
								<div class="day-radio">
									<a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneWeek"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>1</em>주일</a>
									<a href="#" class="day-radio__btn day-radio--active" data-sdate="<?php echo $TPL_VAR["oneMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>"  id="devDateDefault">최근 <em>1</em>개월</a>
									<a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["sixMonth"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>6</em>개월</a>
									<a href="#" class="day-radio__btn devDateBtn" data-sdate="<?php echo $TPL_VAR["oneYear"]?>" data-edate="<?php echo $TPL_VAR["today"]?>">최근 <em>12</em>개월</a>
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
		</section>

		<section class="mileage__detail">
			<div class="board-inquiry__wrap" id="tplMileage">
				<ul class="board-inquiry__list" id="devMileageContent">

					<li class="board-inquiry__item no-data" id="devMileageLoading">
						<div class="wrap-loading">
							<div class="loading"></div>
						</div>
					</li>

					<li class="board-inquiry__item" id="devMileageList">
						<dl class="board-inquiry__group">
							<dt>
								<div class="day">{[date]}</div>
							</dt>
							<dd>
								<div class="subject">{[message]}</div>
							</dd>
						</dl>
						<div class="board-inquiry__side">
							<span class="{[state_desc2]}">{[mileage_desc]}</span>
						</div>
					</li>

					
					<li class="board-inquiry__item no-data" id="devMileageListEmpty">
						<p class="empty-content">적립금 내역이 없습니다.</p>
					</li>
				</ul>
			</div>
			<!-- 	

			<span class="plus">+ <em>1,405,550</em>원</span>
			<span class="minus">- <em>405,550</em>원</span>

			<div class="board-inquiry__wrap" id="tplMileage">
				<table class="table-default mileage-table">
					<tbody id="devMileageContent">
						<tr id="devMileageLoading" class="devForbizTpl">
							<td colspan="4">
								<div class="wrap-loading">
									<div class="loading"></div>
								</div>
							</td>
						</tr>

						<tr id="devMileageList" class="devForbizTpl {[#if soldoutClassName]}showBg{[else]}hideBg{[/if]}">
							<td><div class="day">{[date]}</span></td>
							<td class="detail">{[message]}
								{[#if oid]}
								<span class="devLocationOrder" data-oid="{[oid]}">({[oid]})</span>
								{[/if]}
							</td>
							<td class="mileage mileage__list">
								<span class="fb__n  {[log_type]}">{[mileage_desc]}</span>
							</td>
						</tr>

						<tr id="devMileageListEmpty" class="devForbizTpl">
							<td colspan="4">
								<div class="empty-content">
									<p>적립금 내역이 없습니다.</p>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			  -->
		</section>
	</div>
</section>
<!-- 컨텐츠 E -->