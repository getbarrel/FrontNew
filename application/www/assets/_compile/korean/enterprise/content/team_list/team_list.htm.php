<?php /* Template_ 2.2.8 2024/03/04 06:30:17 /home/barrel-stage/application/www/assets/templet/enterprise/content/team_list/team_list.htm 000015435 */ 
$TPL_displayContentList_1=empty($TPL_VAR["displayContentList"])||!is_array($TPL_VAR["displayContentList"])?0:count($TPL_VAR["displayContentList"]);?>
<!-- 컨텐츠 영역 S -->
				<section class="fb-teamBARREL__bbs" style="margin:0 -68px;">
					<section class="gallery-bbs">
						<div class="gallery-bbs__header">
							<h2 class="fb__main__title-lg">Team BARREL</h2>
							<p>
								다양한 워터스포츠 종목에서 우수한 실력을 겸비하고<br />
								끊임없는 도전 정신으로 자신의 종목에서 최선을 다하는 선수로 구성된<br />
								팀 배럴을 소개합니다.
							</p>
							<div class="fb-tab__nav-btn">
								<ul>
									<li class="active">
										<a href="#;">전체</a>
									</li>
									<li>
										<a href="#;">서핑</a>
									</li>
									<li>
										<a href="#;">수영</a>
									</li>
									<li>
										<a href="#;">프리다이빙</a>
									</li>
									<li>
										<a href="#;">스쿠버다이빙</a>
									</li>
									<li>
										<a href="#;">요가</a>
									</li>
									<li>
										<a href="#;">필라테스</a>
									</li>
								</ul>
							</div>
						</div>
						<ul class="gallery-bbs__box col-4">
<?php if($TPL_VAR["displayContentList"]){?>
<?php if($TPL_displayContentList_1){foreach($TPL_VAR["displayContentList"] as $TPL_V1){?>
									<li class="gallery-bbs__list">
										<a href="/content/teamDetail/<?php echo $TPL_V1["con_ix"]?>">
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

							<!--<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">SURF</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample15.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>KIHUN LEE</h4>
											<span>이기훈</span>
										</div>
									</div>
								</a>
							</li>
							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">SWIM</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample16.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>YESOL JANG</h4>
											<span>장예솔</span>
										</div>
									</div>
								</a>
							</li>
							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">SURF</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample17.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>JAY LEE</h4>
											<span>제이리</span>
										</div>
									</div>
								</a>
							</li>
							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">FREE DIVING</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample18.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>KIHUN LEE</h4>
											<span>이기훈</span>
										</div>
									</div>
								</a>
							</li>

							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">SURF</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample15.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>KIHUN LEE</h4>
											<span>이기훈</span>
										</div>
									</div>
								</a>
							</li>
							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">SWIM</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample16.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>YESOL JANG</h4>
											<span>장예솔</span>
										</div>
									</div>
								</a>
							</li>
							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">SURF</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample17.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>JAY LEE</h4>
											<span>제이리</span>
										</div>
									</div>
								</a>
							</li>
							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">FREE DIVING</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample18.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>KIHUN LEE</h4>
											<span>이기훈</span>
										</div>
									</div>
								</a>
							</li>

							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">SURF</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample15.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>KIHUN LEE</h4>
											<span>이기훈</span>
										</div>
									</div>
								</a>
							</li>
							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">SWIM</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample16.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>YESOL JANG</h4>
											<span>장예솔</span>
										</div>
									</div>
								</a>
							</li>
							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">SURF</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample17.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>JAY LEE</h4>
											<span>제이리</span>
										</div>
									</div>
								</a>
							</li>
							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">FREE DIVING</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample18.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>KIHUN LEE</h4>
											<span>이기훈</span>
										</div>
									</div>
								</a>
							</li>

							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">SURF</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample15.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>KIHUN LEE</h4>
											<span>이기훈</span>
										</div>
									</div>
								</a>
							</li>
							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">SWIM</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample16.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>YESOL JANG</h4>
											<span>장예솔</span>
										</div>
									</div>
								</a>
							</li>
							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">SURF</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample17.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>JAY LEE</h4>
											<span>제이리</span>
										</div>
									</div>
								</a>
							</li>
							<li class="gallery-bbs__list">
								<a href="/content/teamDetail">
									<div class="gallery-bbs__category">FREE DIVING</div>
									<div class="gallery-bbs__img-box">
										<figure class="gallery-bbs__img">
											<img src="/assets/templet/enterprise/assets/img/board/gallery_board_sample18.png" alt="" />
										</figure>
									</div>
									<div class="gallery-bbs__info">
										<div class="gallery-bbs__title-md layout-flex">
											<h4>KIHUN LEE</h4>
											<span>이기훈</span>
										</div>
									</div>
								</a>
							</li>-->
						</ul>

						<!-- 페이지네이션 S -->
						<div id="devPageWrap">
<?php if($TPL_VAR["displayContentPaging"]){?>
								<div class="wrap-pagination">
									<button type="button" class="prev btn-pagination-prev prev devPageBtnCls" onClick="location.href='/content/specialList/<?php echo $TPL_VAR["prevPage"]?>'" <?php if($TPL_VAR["curPage"]==$TPL_VAR["prevPage"]){?>disabled<?php }?>><i class="ico ico-arrow-left"></i>이전</button>
<?php if($TPL_VAR["firstPage"]!=$TPL_VAR["lastPage"]){?><a href="/content/specialList/<?php echo $TPL_VAR["firstPage"]?>" class="devPageBtnCls on"><?php echo $TPL_VAR["firstPage"]?></a><?php }?>
									
									<div class="fb__bubble" <?php if($TPL_VAR["firstPage"]==$TPL_VAR["lastPage"]){?>style="display:none"<?php }?>>
										<a href="/content/specialList/<?php echo $TPL_VAR["firstPage"]?>">...</a>
										<div class="fb__go-page">
											<div class="fb__go-form">
												<div class="fb__form-item">
													<label for="" class="fb__form-label--hidden">페이지넘버</label>
													<input type="text" class="fb__form-input" />
												</div>
												<div class="fb__go-last"><?php echo $TPL_VAR["lastPage"]?></div>
												<button type="button" class="btn-sx">GO</button>
											</div>
										</div>
									</div>
									<?php echo $TPL_VAR["pageNumTpl"]?>

									
									<div class="fb__bubble" <?php if($TPL_VAR["firstPage"]==$TPL_VAR["lastPage"]){?>style="display:none"<?php }?>>
										<a href="/content/specialList/<?php echo $TPL_VAR["lastPage"]?>">...</a>
										<div class="fb__go-page">
											<div class="fb__go-form">
												<div class="fb__form-item">
													<label for="" class="fb__form-label--hidden">페이지넘버</label>
													<input type="text" class="fb__form-input" value="<?php echo $TPL_VAR["lastPage"]?>" />
												</div>
												<div class="fb__go-last"><?php echo $TPL_VAR["lastPage"]?></div>
												<button type="button" class="btn-sx">GO</button>
											</div>
										</div>
									</div>
									
<?php if($TPL_VAR["firstPage"]!=$TPL_VAR["lastPage"]){?><a href="/content/specialList/<?php echo $TPL_VAR["lastPage"]?>" class="devPageBtnCls"><?php echo $TPL_VAR["lastPage"]?></a><?php }?>
									<button type="button" class="next btn-pagination-next" onClick="location.href='/content/specialList/<?php echo $TPL_VAR["nextPage"]?>'" <?php if($TPL_VAR["curPage"]==$TPL_VAR["nextPage"]){?>disabled<?php }?>><i class="ico ico-arrow-right"></i>다음</button>
								</div>
<?php }?>
						</div>
						<!-- 페이지네이션 E -->
					</section>
				</section>
				<!-- 컨텐츠 영역 E -->