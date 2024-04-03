<?php /* Template_ 2.2.8 2024/02/19 14:31:55 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/my_inquiry_detail/my_inquiry_detail.htm 000004619 */ 
$TPL_oInfo_1=empty($TPL_VAR["oInfo"])||!is_array($TPL_VAR["oInfo"])?0:count($TPL_VAR["oInfo"]);
$TPL_cInfo_1=empty($TPL_VAR["cInfo"])||!is_array($TPL_VAR["cInfo"])?0:count($TPL_VAR["cInfo"]);?>
<!-- 컨텐츠 S -->
<section class="br__mypage br__myInquiry">
	<section class="br__myInquiry-wrap">
		<section class="board-detail__wrap">
			<section class="board-detail__header">
				<div class="page-title">
					<div class="title-sm">1:1 문의</div>
				</div>
			</section>
			<form id="devMyInquiryDetailForm">
				<input type="hidden" name="bType" id="bType" value="qna"/>
				<input type="hidden" name="bbsIx" id="bbsIx" value="<?php echo $TPL_VAR["bbsIx"]?>"/>
			</form>
			<section class="board-detail__content">
				<div class="detail-bbs__wrap">
					<div class="detail-bbs__header">
						<!-- 비밀 글일 경우 div class="detail-bbs__header"에 class = lock 추가 -->
						<div class="detail-bbs__header-sub">
							<span class="detail-bbs__category category">[<?php echo $TPL_VAR["div_name"]?>]</span>
<?php if($TPL_VAR["status"]=='5'){?>
							<span class="detail-bbs__state state complete">답변완료</span>
<?php }else{?>
							<span class="detail-bbs__state state">답변대기</span>
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
								<!-- 주문번호 존재시 -->
<?php if($TPL_VAR["bbs_etc4"]!=''){?>
<?php if($TPL_oInfo_1){$TPL_I1=-1;foreach($TPL_VAR["oInfo"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
								<dl class="product-list__group">
									<dt class="product-list__group-left">
										<figure class="product-list__thumb">
											<a href="/mypage/orderDetail?oid=<?php echo $TPL_V1["oid"]?>">
												<img src="<?php echo $TPL_V1["pimg"]?>" alt="" />
											</a>
										</figure>
									</dt>
									<dd class="product-list__group-right">
										<div class="product-list__info">
											<div class="product-list__info__model-number"><?php echo $TPL_V1["oid"]?></div>
											<div class="product-list__info__title"><?php echo $TPL_V1["pname"]?> <?php if($TPL_VAR["oInfoCnt"]> 1){?><span>외 <?php echo $TPL_VAR["oInfoCnt"]?>개 상품</span><?php }else{?><?php }?></div>

											<div class="product-list__info__price">
												<span class="product-list__info__price--title">총 결제금액</span>
												<span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo number_format($TPL_V1["dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
											</div>
										</div>
									</dd>
								</dl>
<?php }?>
<?php }}?>
<?php }else{?>
<?php }?>
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
<?php if($TPL_cInfo_1){foreach($TPL_VAR["cInfo"] as $TPL_V1){?>
					<div class="detail-bbs__answer">
						<div class="detail-bbs__answer__info">
							<span class="detail-bbs__answer__info-name">BARREL 고객센터</span>
							<span class="detail-bbs__answer__info-date"><?php echo $TPL_V1["resdate"]?></span>
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


<?php if($TPL_VAR["status"]== 1){?>
					<div class="detail-bbs__footer">
						<div class="btn-group col">
							<button type="button" class="btn-lg btn-dark-line"><a href="/customer/qna/<?php echo $TPL_VAR["bbsIx"]?>">수정하기</a></button>
							<button type="button" class="btn-lg btn-dark-line" id="devDeleteInquiry">삭제하기</button>
						</div>
					</div>
<?php }?>
				</div>
			</section>
		</section>
	</section>
</section>
<!-- 컨텐츠 E -->