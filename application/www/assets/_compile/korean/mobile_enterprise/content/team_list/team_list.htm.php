<?php /* Template_ 2.2.8 2024/03/04 06:30:14 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/content/team_list/team_list.htm 000003522 */ 
$TPL_displayContentList_1=empty($TPL_VAR["displayContentList"])||!is_array($TPL_VAR["displayContentList"])?0:count($TPL_VAR["displayContentList"]);?>
<!-- 컨텐츠 영역 S -->
			<section class="br__teamBARREL-bbs">
				<section class="gallery-bbs">
					<div class="gallery-bbs__header">
						<div class="title-lg">팀 배럴</div>
						<p>
							다양한 워터스포츠 종목에서 우수한 실력을 겸비하고<br />
							끊임없는 도전 정신으로 자신의 종목에서 최선을 다하는 선수로 구성된<br />
							팀 배럴을 소개합니다.
						</p>
						<div class="gallery-bbs__tab">
							<div class="br-tab__slide swiper-container">
								<ul class="swiper-wrapper">
									<li class="swiper-slide active"><a href="#;">전체</a></li>
									<li class="swiper-slide"><a href="#;">서핑</a></li>
									<li class="swiper-slide"><a href="#;">수영</a></li>
									<li class="swiper-slide"><a href="#;">프리다이빙</a></li>
									<li class="swiper-slide"><a href="#;">스쿠버다이빙</a></li>
									<li class="swiper-slide"><a href="#;">요가</a></li>
									<li class="swiper-slide"><a href="#;">필라테스</a></li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="gallery-bbs__box">
<?php if($TPL_VAR["displayContentList"]){?>
<?php if($TPL_displayContentList_1){foreach($TPL_VAR["displayContentList"] as $TPL_V1){?>
								<li class="gallery-bbs__list">
									<a href="#;">
										<div class="gallery-bbs__category" style="color:<?php echo $TPL_V1["c_preface"]?>;<?php if($TPL_V1["b_preface"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_preface"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_preface"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["preface"]?></div>
										<div class="gallery-bbs__img-box">
											<figure class="gallery-bbs__img">
												<img src="<?php echo $TPL_V1["contentImgSrc"]?>" alt="" />
											</figure>
										</div>
										<div class="gallery-bbs__info">
											<div class="gallery-bbs__title-md layout-flex">
												<h4 style="text-align:<?php if($TPL_V1["s_title"]=='L'){?>left<?php }elseif($TPL_V1["s_title"]=='C'){?>center<?php }elseif($TPL_V1["s_title"]=='R'){?>right<?php }?>;color:<?php echo $TPL_V1["c_title"]?>;<?php if($TPL_V1["b_title"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["title"]?></h4>
												<span style="color:<?php echo $TPL_V1["c_title_b"]?>;<?php if($TPL_V1["b_title_b"]=='Y'){?>font-weight: bold;<?php }?> <?php if($TPL_V1["i_title_b"]=='Y'){?>font-style:oblique;<?php }?> <?php if($TPL_V1["u_title_b"]=='Y'){?>text-decoration-line: underline;<?php }?>"><?php echo $TPL_V1["title_en"]?></span>
											</div>
										</div>
									</a>
								</li>
<?php }}?>
<?php }else{?>
							<!-- 등록된 게시글이 없을 경우 S -->
							<li class="gallery-bbs__list no-data">
								<p class="empty-content">등록된 글이 없습니다.</p>
							</li>
							<!-- 등록된 게시글이 없을 경우 E -->
<?php }?>
					</ul>
				</section>
			</section>
			<!-- 컨텐츠 영역 E -->