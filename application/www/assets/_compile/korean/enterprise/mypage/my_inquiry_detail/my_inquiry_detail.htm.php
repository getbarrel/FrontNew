<?php /* Template_ 2.2.8 2024/03/19 14:51:49 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/my_inquiry_detail/my_inquiry_detail.htm 000010304 */ 
$TPL_oInfo_1=empty($TPL_VAR["oInfo"])||!is_array($TPL_VAR["oInfo"])?0:count($TPL_VAR["oInfo"]);
$TPL_cInfo_1=empty($TPL_VAR["cInfo"])||!is_array($TPL_VAR["cInfo"])?0:count($TPL_VAR["cInfo"]);?>
<!-- 컨텐츠 S -->
<form id="devMyInquiryDetailForm">
    <input type="hidden" name="bType" id="bType" value="qna"/>
    <input type="hidden" name="bbsIx" id="bbsIx" value="<?php echo $TPL_VAR["bbsIx"]?>"/>
</form>
<section class="fb__mypage fb__mypage-board">
	<div class="fb__bbs__detail">
		<div class="fb__bbs__detail__title">
			<div class="title-md">1:1 문의</div>
		</div>
		<section class="fb__bbs__detail-content">
			<div class="detail">
				<div class="detail__header">
					<div class="detail__header-group">
						<span class="detail__category category">[<?php echo $TPL_VAR["div_name"]?>]</span>
<?php if($TPL_VAR["status"]=='1'){?>
						<span class="detail__state state">답변 대기중</span>
<?php }elseif($TPL_VAR["status"]=='2'){?>
						<span class="detail__state state">확인중</span>
<?php }elseif($TPL_VAR["status"]=='5'){?>
						<span class="detail__state state complete">답변완료</span>
<?php }?>
					</div>
					<div class="detail__header-group">
						<h3 class="detail__title"><?php echo $TPL_VAR["bbs_subject"]?></h3>
						<span class="detail__date date"><?php echo $TPL_VAR["regdate"]?></span>
					</div>
				</div>

				<!-- 주문 상품 영역 S -->
				<div class="detail__product">
					<ul class="product-item__wrap">
						<li class="product-item__list">
							<!-- 주문 내역 - 상품 레이아웃 커스텀 S -->
<?php if($TPL_VAR["bbs_etc4"]!=''){?>
<?php if($TPL_oInfo_1){$TPL_I1=-1;foreach($TPL_VAR["oInfo"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
							<a href="/mypage/orderDetail?oid=<?php echo $TPL_V1["oid"]?>" class="product-item__link">
								<dl class="product-item">
									<dt class="product-item__thumbnail-box">
										<div class="product-item__thumb">
											<img src="<?php echo $TPL_V1["pimg"]?>" alt="" />
										</div>
									</dt>
									<dd class="product-item__infobox">
										<div class="product-item__info">
											<div class="order-day">2024.12.31</div>
											<div class="product-item__title c-pointer">
												<div class="title-sm"><?php echo $TPL_V1["pname"]?> <?php if($TPL_VAR["oInfoCnt"]> 1){?>외 <?php echo $TPL_VAR["oInfoCnt"]?>개 상품<?php }else{?><?php }?></div>
											</div>
											<div class="order-number"><?php echo $TPL_V1["oid"]?></div>
										</div>
										<div class="product-item__btn-area">
											<div class="order-price"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_V1["dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></div>
										</div>
									</dd>
								</dl>
							</a>
<?php }?>
<?php }}?>
<?php }else{?>
<?php }?>
							<!-- 주문 내역 - 상품 레이아웃 커스텀 E -->
						</li>
					</ul>
				</div>
				<!-- 주문 상품 영역 E -->

				<div class="content-area detail__content">
					<div class="cont-area">
						<?php echo nl2br($TPL_VAR["bbs_contents"])?>

					</div>

<?php if($TPL_VAR["bbs_file_1"]!=''){?>
					<div class="content-area detail__content">
						<p class="detail__file file">
							<a class="detail__file__name" href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_1"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_1"]?></a>
						</p><!--파일링크 추가 필요--> 
					</div>
<?php }?>

<?php if($TPL_VAR["bbs_file_2"]!=''){?>
					<div class="content-area detail__content">
						<p class="detail__file file">
							<a class="detail__file__name" href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_2"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_2"]?></a>
						</p><!--파일링크 추가 필요--> 
					</div>
<?php }?>

<?php if($TPL_VAR["bbs_file_3"]!=''){?>
					<div class="content-area detail__content">
						<p class="detail__file file">
							<a class="detail__file__name" href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_3"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_3"]?></a>
						</p><!--파일링크 추가 필요--> 
					</div>
<?php }?>

<?php if($TPL_VAR["bbs_file_4"]!=''){?>
					<div class="content-area detail__content">
						<p class="detail__file file">
							<a class="detail__file__name" href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_4"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_4"]?></a>
						</p><!--파일링크 추가 필요--> 
					</div>
<?php }?>
				</div>

				<!-- 답변 영역 S -->
<?php if($TPL_cInfo_1){foreach($TPL_VAR["cInfo"] as $TPL_V1){?>
				<div class="detail__answer">
					<div class="detail__answer__info">
						<span class="detail__answer__info-name">BARREL 고객센터</span>
						<span class="detail__answer__info-date"><?php echo $TPL_V1["resdate"]?></span>
					</div>
					<div class="detail__answer__content answer">
						<?php echo nl2br($TPL_V1["cmt_contents"])?>

					</div>
				</div>
<?php }}?>
				<!-- 답변 영역 E -->

				<!-- 답변 없고 / 게시글 수정할 경우 S -->
<?php if($TPL_VAR["status"]== 1){?>
				<div class="detail__footer">
					<div class="btn-group">
						<button type="button" class="btn-default btn-dark-line"><a href="/customer/qna/<?php echo $TPL_VAR["bbsIx"]?>" class="my-inquiry__btns__mod">수정하기</a></button>
						<button type="button" id="devDeleteInquiry" class="btn-default btn-dark-line">삭제하기</button>
						<button type="button" class="btn-default btn-dark-line"><a href="/mypage/myInquiry/" class="my-inquiry__btns__mod">목록으로</a></button>
					</div>
				</div>
<?php }else{?>
				<!-- 답변 완료 되었을 때 S -->
				<div class="detail__footer">
					<button type="button" class="btn-default btn-dark-line">목록으로</button>
				</div>
				<!-- 답변 완료 되었을 때 E -->

<?php }?>
				<!-- 답변 없고 / 게시글 수정할 경우 E -->
			</div>
		</section>
	</div>
</section>
<!-- 컨텐츠 E -->
<!--
<form id="devMyInquiryDetailForm">
    <input type="hidden" name="bType" id="bType" value="qna"/>
    <input type="hidden" name="bbsIx" id="bbsIx" value="<?php echo $TPL_VAR["bbsIx"]?>"/>
</form>
<div class="fb__my-inquiry-detail br__inquiry-detail">
    <div class="detail">
        <div class="detail__top">
            <span class="detail__top__date">작성일시 : <em class="font-rb"><?php echo $TPL_VAR["regdate"]?></em></span>
<?php if($TPL_VAR["status"]=='1'){?>
            <span class="status--normal">문의중</span>
<?php }elseif($TPL_VAR["status"]=='2'){?>
            <span class="status--normal">확인중</span>
<?php }elseif($TPL_VAR["status"]=='5'){?>
            <span class="status--complete">답변완료</span>
<?php }?>
        </div>

        <div class="detail__title">
            <?php echo $TPL_VAR["bbs_subject"]?>

        </div>
        <div class="detail__content wrap-question">
            <!-- 주문번호 존재시 -- 
<?php if($TPL_VAR["bbs_etc4"]!=''){?>
<?php if($TPL_oInfo_1){$TPL_I1=-1;foreach($TPL_VAR["oInfo"] as $TPL_V1){$TPL_I1++;?>
<?php if($TPL_I1== 0){?>
            <a href="/mypage/orderDetail?oid=<?php echo $TPL_V1["oid"]?>">
                <div class="detail__item">
                    <div class="detail__item__thumb">
                        <img src="<?php echo $TPL_V1["pimg"]?>" alt="img">
                    </div>
                    <div class="detail__item__info">
                        <p class="detail__item__info-num order-num">주문번호 <span><?php echo $TPL_V1["oid"]?></span></p>
                        <p class="detail__item__info-title"><?php echo $TPL_V1["pname"]?> <?php if($TPL_VAR["oInfoCnt"]> 1){?>외 <?php echo $TPL_VAR["oInfoCnt"]?>개 상품<?php }else{?><?php }?></p>
                    </div>
                </div>
            </a>
<?php }?>
<?php }}?>
<?php }else{?>
<?php }?>

            <div class="detail__question question"><?php echo nl2br($TPL_VAR["bbs_contents"])?></div>
<?php if($TPL_VAR["bbs_file_1"]!=''){?>
            <p class="detail__file file">
                <a class="detail__file__name" href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_1"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_1"]?></a>
            </p><!--파일링크 추가 필요-- 
<?php }?>

<?php if($TPL_VAR["bbs_file_2"]!=''){?>
            <p class="detail__file file">
                <a class="detail__file__name" href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_2"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_2"]?></a>
            </p><!--파일링크 추가 필요-- 
<?php }?>

<?php if($TPL_VAR["bbs_file_3"]!=''){?>
            <p class="detail__file file">
                <a class="detail__file__name" href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_3"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_3"]?></a>
            </p><!--파일링크 추가 필요-- 
<?php }?>

<?php if($TPL_VAR["bbs_file_4"]!=''){?>
            <p class="detail__file file">
                <a class="detail__file__name" href="<?php echo $TPL_VAR["bbs_filepath"]?><?php echo $TPL_VAR["bbs_file_4"]?>" target='_blank'><?php echo $TPL_VAR["bbs_file_4"]?></a>
            </p><!--파일링크 추가 필요-- 
<?php }?>

        </div>

<?php if($TPL_cInfo_1){foreach($TPL_VAR["cInfo"] as $TPL_V1){?>
        <div class="detail__answer ">
            <div class="detail__answer__info">
                <span class="detail__answer__info-name">BARREL</span>
                <span class="detail__answer__info-date">답변일시: <em><?php echo $TPL_V1["resdate"]?></em></span>
            </div>
            <div class="detail__answer__content answer"><?php echo nl2br($TPL_V1["cmt_contents"])?></div>
        </div>
<?php }}?>
<?php if($TPL_VAR["status"]== 1){?>
        <div class="my-inquiry__btns">
            <button class="my-inquiry__btns__del" id="devDeleteInquiry">삭제</button>
            <a href="/customer/qna/<?php echo $TPL_VAR["bbsIx"]?>" class="my-inquiry__btns__mod">수정</a>
        </div>
<?php }?>
    </div>
</div>
-->