<?php /* Template_ 2.2.8 2024/03/20 10:21:38 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/my_goods_inquiry_detail/my_goods_inquiry_detail.htm 000004714 */ 
$TPL_comments_1=empty($TPL_VAR["comments"])||!is_array($TPL_VAR["comments"])?0:count($TPL_VAR["comments"]);?>
<!-- 컨텐츠 S -->
<section class="br__mypage br__myInquiry">
	<section class="br__myInquiry-wrap">
		<section class="board-detail__wrap">
			<section class="board-detail__header">
				<div class="page-title">
					<div class="title-sm">상품 Q&A</div>
				</div>
			</section>
			<section class="board-detail__content">
				<div class="detail-bbs__wrap">
					<div class="detail-bbs__header lock">
						<!-- 비밀 글일 경우 div class="detail-bbs__header"에 class = lock 추가 -->
						<div class="detail-bbs__header-sub">
							<span class="detail-bbs__category category"><?php echo $TPL_VAR["div_name"]?></span>
<?php if($TPL_VAR["isResponse"]){?>
							<span class="detail-bbs__state state complete">답변완료</span>
<?php }else{?>
							<span class="detail-bbs__state state">답변 대기중</span>
<?php }?>
						</div>
						<div class="detail-bbs__header-group">
							<h3 class="detail-bbs__title"><?php echo $TPL_VAR["bbs_subject"]?></h3>
							<span class="detail-bbs__date date"><?php echo $TPL_VAR["regdate"]?></span>
						</div>
					</div>

					<!-- 주문 상품 영역 S -->
					<div class="detail-bbs__product">
						<ul class="product-list">
							<li class="product-list__item">
								<dl class="product-list__group">
									<dt class="product-list__group-left">
										<figure class="product-list__thumb">
											<a href="/shop/goodsView/<?php echo $TPL_VAR["pid"]?>">
												<img src="<?php echo $TPL_VAR["image_src"]?>" alt="<?php echo $TPL_VAR["pname"]?>" />
											</a>
										</figure>
									</dt>
									<dd class="product-list__group-right">
										<div class="product-list__info">
											<div class="product-list__info__title"><?php echo $TPL_VAR["pname"]?></div>
											<!-- 일반상품 상품 S -->
											<div class="product-list__info__option">
												<div class="product-list__info__option-item">
													<span class="color"><?php echo $TPL_VAR["add_info"]?></span>
												</div>
											</div>
											<!-- 일반상품 상품 E -->

											<div class="product-list__info__price">
<?php if($TPL_VAR["discount_rate"]> 0){?><span class="product-list__info__price--discount"><?php echo $TPL_VAR["discount_rate"]?>%</span>
												<del class="product-list__info__price--strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></del><?php }?>
												<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
											</div>
										</div>
									</dd>
								</dl>
							</li>
						</ul>
					</div>
					<!-- 주문 상품 영역 E -->

					<div class="detail-bbs__content">
						<div class="cont-area">
							<p><?php echo nl2br($TPL_VAR["bbs_contents"])?></p>
						</div>
					</div>

					<!-- 답변 영역 S -->
<?php if($TPL_comments_1){foreach($TPL_VAR["comments"] as $TPL_V1){?>
					<div class="detail-bbs__answer">
						<div class="detail-bbs__answer__info">
							<span class="detail-bbs__answer__info-name">BARREL 고객센터</span>
							<span class="detail-bbs__answer__info-date"><?php echo $TPL_V1["regdate"]?></span>
						</div>
						<div class="detail-bbs__answer__content answer">
							<p><?php echo nl2br($TPL_V1["cmt_contents"])?></p>
						</div>
					</div>
<?php }}?>
					<!-- 답변 영역 E -->

					<!-- 답변 완료 되었을 때 S -->
					<div class="detail-bbs__footer">
						<button type="button" class="btn-lg btn-dark-line" onClick="javascript:history.back();">목록으로</button>
					</div>
					<!-- 답변 완료 되었을 때 E -->

					<!-- 답변 없고 / 게시글 수정할 경우 S -->
					<!-- 숨김 처리 -->
					<div class="detail-bbs__footer">
						<div class="btn-group col">
							<button type="button" class="btn-lg btn-dark-line"><a href="javascript:void(0);" class="devModifyQna" data-bbs_ix="<?php echo $TPL_VAR["bbs_ix"]?>" data-pid="<?php echo $TPL_VAR["pid"]?>">수정하기</a></button>
							<button type="button" class="btn-lg btn-gray-line devDeleteQna" data-bbs_ix="<?php echo $TPL_VAR["bbs_ix"]?>">삭제하기</button>
						</div>
					</div>
					<!-- 답변 없고 / 게시글 수정할 경우 E -->
				</div>
			</section>
		</section>
	</section>
</section>
<!-- 컨텐츠 E -->