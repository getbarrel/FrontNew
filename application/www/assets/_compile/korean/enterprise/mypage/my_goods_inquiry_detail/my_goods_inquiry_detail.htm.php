<?php /* Template_ 2.2.8 2024/03/20 10:19:20 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/my_goods_inquiry_detail/my_goods_inquiry_detail.htm 000007431 */ 
$TPL_comments_1=empty($TPL_VAR["comments"])||!is_array($TPL_VAR["comments"])?0:count($TPL_VAR["comments"]);?>
<!-- 컨텐츠 S -->
<section class="fb__mypage fb__mypage-board">
	<div class="fb__bbs__detail">
		<div class="fb__bbs__detail__title">
			<div class="title-md">상품 Q&A</div>
		</div>
		<section class="fb__bbs__detail-content">
			<div class="detail">
				<div class="detail__header">
					<div class="detail__header-group">
						<span class="detail__category category"><?php echo $TPL_VAR["div_name"]?></span>
						<span class="detail__state state <?php if($TPL_VAR["isResponse"]){?> complete <?php }?>">
<?php if($TPL_VAR["isResponse"]){?>
						<span class="status complete">답변완료</span>
<?php }else{?>
						<span class="status">답변대기</span>
<?php }?>
						</span>
					</div>
					<div class="detail__header-group">
						<h3 class="detail__title"><?php echo $TPL_VAR["bbs_subject"]?></h3>
						<span class="detail__date date lock"><?php echo $TPL_VAR["regdate"]?></span>
					</div>
				</div>

				<!-- 주문 상품 영역 S -->
				<div class="detail__product">
					<ul class="product-item__wrap">
						<li class="product-item__list">
							<dl class="product-item">
								<dt class="product-item__thumbnail-box">
									<div class="product-item__thumb">
										<a href="/shop/goodsView/<?php echo $TPL_VAR["pid"]?>">
											<img src="<?php echo $TPL_VAR["image_src"]?>" alt="" />
										</a>
									</div>
								</dt>
								<dd class="product-item__infobox">
									<div class="product-item__info">
										<div class="product-item__title c-pointer">
											<a href="/shop/goodsView/<?php echo $TPL_VAR["pid"]?>"><?php echo $TPL_VAR["pname"]?></a>
										</div>
										<div class="product-item__option">
											<?php echo $TPL_VAR["add_info"]?>

										</div>
										<div class="product-item__price-group">
<?php if($TPL_VAR["discount_rate"]> 0){?><div class="product-item__price-percent"><?php echo $TPL_VAR["discount_rate"]?>%</div><?php }?>
											<div class="product-item__price price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
<?php if($TPL_VAR["discount_rate"]> 0){?><div class="product-item__noprice"><?php echo $TPL_VAR["fbUnit"]["f"]?><del><?php echo g_price($TPL_VAR["listprice"])?></del><?php echo $TPL_VAR["fbUnit"]["b"]?></div><?php }?>
										</div>
									</div>
								</dd>
							</dl>
						</li>
					</ul>
				</div>
				<!-- 주문 상품 영역 E -->

				<div class="content-area detail__content">
					<div class="cont-area">
						<?php echo $TPL_VAR["bbs_contents"]?>

					</div>
				</div>

				<!-- 답변 영역 S -->
<?php if($TPL_VAR["isResponse"]){?>
				<div class="detail__answer">
<?php if($TPL_comments_1){foreach($TPL_VAR["comments"] as $TPL_V1){?>
					<div class="detail__answer__info">
						<span class="detail__answer__info-name">BARREL 고객센터</span>
						<span class="detail__answer__info-date"><?php echo $TPL_V1["regdate"]?></span>
					</div>
					<div class="detail__answer__content answer">
						<?php echo $TPL_V1["cmt_contents"]?>

					</div>
<?php }}?>
				</div>
<?php }?>
				<!-- 답변 영역 E -->

				<!-- 답변 완료 되었을 때 S -->
				<div class="detail__footer">
					<button type="button" class="btn-default btn-dark-line">목록으로</button>
				</div>
				<!-- 답변 완료 되었을 때 E -->

				<!-- 답변 없고 / 게시글 수정할 경우 S -->
				<!-- 숨김 처리 -->
				<div class="detail__footer">
					<div class="btn-group">
<?php if($TPL_VAR["isResponse"]){?>

<?php }else{?>
						<button type="button" class="btn-default btn-dark-line devModifyQna" data-bbs_ix="<?php echo $TPL_VAR["bbs_ix"]?>" data-pid="<?php echo $TPL_VAR["pid"]?>">수정하기</button>
						<button type="button" class="btn-default btn-gray-line devDeleteQna" data-bbs_ix="<?php echo $TPL_VAR["bbs_ix"]?>">삭제하기</button>
<?php }?>
					</div>
				</div>
				<!-- 답변 없고 / 게시글 수정할 경우 E -->
			</div>
		</section>
	</div>
</section>
<!-- 컨텐츠 E -->

<!--
<div class="fb__myGoodsInquiryDetail">
    <div class="detail">
        <div class="wrap-bbs-view">
            <div class="top-area">
                <span>작성일시 : <em class="font-rb"><?php echo $TPL_VAR["regdate"]?></em></span>
<?php if($TPL_VAR["isResponse"]){?>
                <span class="status complete">답변완료</span>
<?php }else{?>
                <span class="status">답변대기</span>
<?php }?>
            </div>

            <div class="bbs-title">
                <?php echo $TPL_VAR["bbs_subject"]?>

            </div>
            <div class="wrap-question">
                <a href="/shop/goodsView/<?php echo $TPL_VAR["pid"]?>">
                    <div class="item">
                        <div class="thumb">
                            <img src="<?php echo $TPL_VAR["image_src"]?>">
                        </div>
                        <div class="info">
                            <p class="title"><?php echo $TPL_VAR["pname"]?></p>
<?php if($TPL_VAR["add_info"]){?>
                            <p class="color">색상 : <?php echo $TPL_VAR["add_info"]?></p>
<?php }?>
                        </div>
                    </div>
                </a>
                <p class="question"><?php echo $TPL_VAR["bbs_contents"]?></p>
            </div>

<?php if($TPL_VAR["isResponse"]&&false){?>
            <div class="wrap-answer">
<?php if($TPL_comments_1){foreach($TPL_VAR["comments"] as $TPL_V1){?>
                <div class="top-area">
                    <span class="float-l"><?php echo $TPL_V1["cmt_name"]?></span>
                    <span class="float-r">답변일시: <em class="font-rb"><?php echo $TPL_V1["regdate"]?></em></span>
                </div>
                <p class="answer">
                    <?php echo $TPL_V1["cmt_contents"]?>

                </p>
<?php }}?>
            </div>
<?php }?>
<?php if($TPL_VAR["isResponse"]){?>
            <div class="detail__answer">
<?php if($TPL_comments_1){foreach($TPL_VAR["comments"] as $TPL_V1){?>
                <div class="detail__answer-list">
                    <header class="detail__answer-header">
                        <h3 class="detail__answer-title">
                            BARREL
                        </h3>
                        <span class="detail__answer-day">
                            답변일시 : <?php echo $TPL_V1["regdate"]?>

                        </span>
                    </header>
                    <p  class="detail__answer-info">
                        <?php echo nl2br($TPL_V1["cmt_contents"])?>

                    </p>
                </div>
<?php }}?>
            </div>
<?php }?>

            <div class="popup-btn-area">
<?php if($TPL_VAR["isResponse"]){?>

<?php }else{?>
                <button class="btn-default btn-dark-line devDeleteQna" data-bbs_ix="<?php echo $TPL_VAR["bbs_ix"]?>">삭제</button>
                <button class="btn-default btn-dark devModifyQna" data-bbs_ix="<?php echo $TPL_VAR["bbs_ix"]?>" data-pid="<?php echo $TPL_VAR["pid"]?>">수정</button>
<?php }?>
            </div>
        </div>
    </div>
</div>
-->