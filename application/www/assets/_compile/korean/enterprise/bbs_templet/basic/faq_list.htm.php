<?php /* Template_ 2.2.8 2024/02/13 15:02:31 /home/barrel-stage/application/www/assets/templet/enterprise/bbs_templet/basic/faq_list.htm 000002298 */ 
$TPL_bbs_divs_1=empty($TPL_VAR["bbs_divs"])||!is_array($TPL_VAR["bbs_divs"])?0:count($TPL_VAR["bbs_divs"]);?>
<section class="wrap-board fb__bbs br__customer-notice br__customer-faq board-faq">
	<div class="board-faq__wrap">
		<form id="devFaqForm">
		<input type="hidden" name="page" value="1" id="devPage"/>
		<input type="hidden" name="max" value="10" id="devMax"/>
		<input type="hidden" name="bType" value="<?php echo $TPL_VAR["bType"]?>" id="bType"/>
		<input type="hidden" name="sText" value="<?php echo $TPL_VAR["sText"]?>" id="sText"/>
		<input type="hidden" name="divIx" value="<?php echo $TPL_VAR["divIx"]?>" id="divIx"/>
		<input type="hidden" name="bbsIx" value="<?php echo $TPL_VAR["bbsIx"]?>" id="bbsIx"/>
		<div class="board-faq__header">
			<div class="title-md">자주 묻는 질문</div>
		</div>
		<div class="board-tab__wrap">
			<nav class="fb-tab__nav">
				<ul>
					<li id="devDivIx2" devDivIx2=""  class="active">
						<a href="javascript:void(0)" devDivIx="" data-divix="">전체</a>
					</li>
<?php if($TPL_bbs_divs_1){foreach($TPL_VAR["bbs_divs"] as $TPL_V1){?>
					<li id="devDivIx2<?php echo $TPL_V1["div_ix"]?>" devDivIx2="<?php echo $TPL_V1["div_ix"]?>">
						<a href="javascript:void(0)" devDivIx="<?php echo $TPL_V1["div_ix"]?>" data-divix="<?php echo $TPL_V1["div_ix"]?>"><?php echo $TPL_V1["div_name"]?></a>
					</li>
<?php }}?>
				</ul>
			</nav>
		</div>
		</form>

		<div id="devFaqContent" class="board-faq__list">
			<dl id="devFaqList" class="board-faq__item">
				<dt class="board-faq__Q devFaqQuestion">
					<a href="#;" class="board-faq__link">
						<div class="title-sm">
							<span>{[div_name]}</span>
							{[bbs_q]}
						</div>
						<i class="ico ico-arrow-bottom"></i>
					</a>
				</dt>

				<dd class="devFaqAnswer board-faq__A">
					<div class="answer">{[{bbs_a}]}</div>
				</dd>
			</dl>

			<div id="devFaqLoading" class="empty-content">
				<div class="wrap-loading">
					<div class="loading"></div>
				</div>
			</div>

			<div id="devFaqEmpty" class="empty-content">
				<p id="emptyMsg"><em></em></p>
			</div>
		</div>
		<div id="devPageWrap"></div>
	</div>
</section>