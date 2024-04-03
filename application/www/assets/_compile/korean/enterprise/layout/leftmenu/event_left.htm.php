<?php /* Template_ 2.2.8 2024/03/11 17:53:19 /home/barrel-stage/application/www/assets/templet/enterprise/layout/leftmenu/event_left.htm 000001243 */ ?>
<section class="fb__left-brandList event">
	<div class="brandNav">
		<div class="brandNav__header">
			<h2 class="brandNav__title">이벤트</h2>
		</div>
		<div class="brandNav__wrap">
			<ul class="brandNav__list">
				<li class="brandNav__main-menu <?php if($TPL_VAR["state"]=='I'||$TPL_VAR["state"]==''){?>active<?php }?>">
					<!-- 현재 페이지 메뉴일 경우 class = active 추가 -->
					<a href="/event/eventList/I" class="brandNav__main-link">진행 중 이벤트</a>

					<ul class="brandNav__sub-list active">
						<!-- 현재 페이지 메뉴일 경우 class = active 추가 -->
						<li class="brandNav__sub-menu <?php if($TPL_VAR["state"]=='E'){?>active<?php }?>">
							<!-- 현재 페이지 메뉴일 경우 class = active 추가 -->
							<a href="/event/eventList/E" class="brandNav__sub-link">종료 이벤트</a>
						</li>
						<li class="brandNav__sub-menu <?php if($TPL_VAR["state"]=='A'){?>active<?php }?>">
							<a href="/event/eventList/A" class="brandNav__sub-link">전체</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</section>