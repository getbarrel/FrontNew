<?php /* Template_ 2.2.8 2024/04/02 09:34:42 /home/barrel-stage/application/www/assets/templet/enterprise/layout/leftmenu/content_left.htm 000003869 */ 
$TPL_displayContentClassList_1=empty($TPL_VAR["displayContentClassList"])||!is_array($TPL_VAR["displayContentClassList"])?0:count($TPL_VAR["displayContentClassList"]);
$TPL_displayContentClassDepthList_1=empty($TPL_VAR["displayContentClassDepthList"])||!is_array($TPL_VAR["displayContentClassDepthList"])?0:count($TPL_VAR["displayContentClassDepthList"]);?>
<section class="fb__left-brandList Inside">
	<div class="brandNav">
		<div class="brandNav__header">
			<h2 class="brandNav__title">배럴 인사이드</h2>
		</div>
		<div class="brandNav__wrap">
			<ul class="brandNav__list">
				<li class="brandNav__main-menu active">
<?php if($TPL_displayContentClassList_1){foreach($TPL_VAR["displayContentClassList"] as $TPL_V1){?>
<?php if($TPL_V1["cid"]=='001001000000000'){?>
							<a href="/content/specialList" class="brandNav__main-link" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["cname"]?></a>
<?php }?>
<?php }}?>

					<ul class="brandNav__sub-list active">
						<!-- 현재 페이지 메뉴일 경우 class = active 추가 -->
						<li class="brandNav__sub-menu <?php if($TPL_VAR["paramCid"]=="001001"){?>active<?php }?>">
							<!-- 현재 페이지 메뉴일 경우 class = active 추가 -->
							<a href="/content/specialList" class="brandNav__sub-link">전체</a>
						</li>
<?php if($TPL_displayContentClassDepthList_1){foreach($TPL_VAR["displayContentClassDepthList"] as $TPL_V1){?>
							<li class="brandNav__sub-menu <?php if($TPL_VAR["paramCid"]==$TPL_V1["cid"]){?>active<?php }?>">
								<a href="/content/specialList/<?php echo $TPL_V1["cid"]?>" class="brandNav__sub-link" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["cname"]?></a>
							</li>
<?php }}?>
						<!--<li class="brandNav__sub-menu">
							<a href="/content/focusNow1" class="brandNav__sub-link">컬렉션</a>
						</li>
						<li class="brandNav__sub-menu">
							<a href="/content/focusNow2" class="brandNav__sub-link">배럴 저널</a>
						</li>
						<li class="brandNav__sub-menu">
							<a href="/content/focusNow3" class="brandNav__sub-link">캠패인</a>
						</li>
						<li class="brandNav__sub-menu">
							<a href="/content/focusNow4" class="brandNav__sub-link">브랜드 스토리</a>
						</li>-->
					</ul>
				</li>
<?php if($TPL_displayContentClassList_1){foreach($TPL_VAR["displayContentClassList"] as $TPL_V1){?>
<?php if($TPL_V1["cid"]!='001001000000000'){?>
						<li class="brandNav__main-menu <?php if($TPL_V1["cid"]=='001002000000000'){?>line<?php }?> active">
							<a href="<?php if($TPL_V1["cid"]=='001002000000000'){?>/content/styleList<?php }elseif($TPL_V1["cid"]=='001003000000000'){?>/content/teamList<?php }elseif($TPL_V1["cid"]=='001004000000000'){?>/customer/bestReview<?php }?>" class="brandNav__main-link"><?php echo $TPL_V1["cname"]?></a>
						</li>
<?php }?>
<?php }}?>
				<!--<li class="brandNav__main-menu line active">
					<a href="/content/specialList" class="brandNav__main-link">스타일 큐레이션</a>
				</li>
				<li class="brandNav__main-menu active">
					<a href="#;" class="brandNav__main-link">팀 배럴</a>
				</li>
				<li class="brandNav__main-menu active">
					<a href="#;" class="brandNav__main-link">베스트 리뷰</a>
				</li>-->
			</ul>
		</div>
	</div>
</section>