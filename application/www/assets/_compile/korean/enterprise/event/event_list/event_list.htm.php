<?php /* Template_ 2.2.8 2024/03/20 16:18:18 /home/barrel-stage/application/www/assets/templet/enterprise/event/event_list/event_list.htm 000003905 */ ?>
<!-- 컨텐츠 영역 S -->
<form id="devEventForm">
	<input type="hidden" name="orderBy" value="display_start"/>
	<input type="hidden" name="orderByType" value="desc"/>
	<input type="hidden" name="page" value="1" id="devPage"/>
	<input type="hidden" name="max" value="9" id="devMax"/>
	<input type="hidden" name="type" value="E" id="devType"/>
	<input type="hidden" name="state" value="<?php echo $TPL_VAR["state"]?>" id="state"/>
</form>
<style>
#outputDiv {
    white-space: pre-wrap; /* 공백 유지 */
}
</style>
<script>
// 텍스트 내용을 수정하는 함수
function modifyText() {
    var elements = document.querySelectorAll(".output-text"); // 모든 요소 선택
    elements.forEach(function(element) {
        var textContent = element.textContent.trim(); // 앞뒤 공백 제거
        var modifiedContent = textContent.replace(/\r?\n/g, "<br>"); // \r\n을 <br>로 변경
        element.innerHTML = modifiedContent; // 결과를 HTML로 반영
    });
}

// 페이지 로드 시 텍스트 수정 함수 호출
window.onload = modifyText;
</script>
<section class="fb-inside__bbs">
	<section class="gallery-bbs">
		<div class="gallery-bbs__header">
			<h2 class="fb__main__title"><?php if($TPL_VAR["state"]=="I"){?>진행 중 이벤트<?php }elseif($TPL_VAR["state"]==""){?>진행 중 이벤트<?php }elseif($TPL_VAR["state"]=="E"){?>종료 이벤트<?php }elseif($TPL_VAR["state"]=="A"){?>전체 이벤트<?php }?></h2>
		</div>
		<ul class="gallery-bbs__box" id="devEventContent">
			<li class="gallery-bbs__list devForbizTpl" id="devEventLoading">
                <div class="wrap-loading"> <div class="loading"></div></div>
            </li>
			
			<li class="gallery-bbs__list devForbizTpl" id="devEventListEmpty">등록된 기획전이 없습니다.</li>

			<li class="gallery-bbs__list"  id="devEventList">
				<!-- 이벤트 종료시 class = event-end-->
				<div class="gallery-bbs__category" style="color:{[c_preface]};{[b_preface]}{[i_preface]}{[u_preface]}">{[onOff]}</div>
				<!--<a href="/event/eventDetail/{[event_ix]}">-->
				<a href="{[#if display_gubun]}/content/focusNow2/{[else]}/content/focusNow4/{[/if]}{[event_ix]}">
					<div class="gallery-bbs__img-box">
						<figure class="gallery-bbs__img">
							<img src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/images/common/loading.gif" data-src="{[imgPath]}" alt="">
						</figure>
					</div>
				</a>
				<div class="gallery-bbs__info">
					<!--<button type="button" class="btn-wishlist"><i class="ico ico-wishlist"></i>좋아요</button>-->
					<button type="button" class="btn-wishlist {[#if alreadyWishContent]}product-box__heart--active{[/if]}" onclick="contentWish('{[event_ix]}', 'E', this)"><i class="ico ico-wishlist"></i>좋아요</button>
					<!--a href="javascript:void(0);" class="product-box__heart {[#if alreadyWishContent]}product-box__heart--active{[/if]}" style="width:21px;" onclick="contentWish('{[event_ix]}', 'E', this)">좋아요</a-->
					<a href="{[#if display_gubun]}/content/focusNow2/{[else]}/content/focusNow4/{[/if]}{[event_ix]}">
						<div class="gallery-bbs__title output-text" style="color:{[c_title]};{[s_title]}{[b_title]}{[i_title]}{[u_title]};">
							{[event_title]}
						</div>
					</a>
					 <div class="gallery-bbs__title-sub output-text" style="margin-top:19px;color:{[c_explanation]};{[b_explanation]}{[i_explanation]}{[u_explanation]};">
						 {[explanation]}
					</div>
					{[#if display_date_use]}
					<div class="gallery-bbs__date">{[startDate]} - {[endDate]}</div>
					{[/if]}
				</div>
			</li>
		</ul>

		<!-- 페이지네이션 S -->
		<div id="devPageWrap" style="padding-bottom:100px;"></div>
		<!-- 페이지네이션 E -->
	</section>
</section>
<!-- 컨텐츠 영역 E -->