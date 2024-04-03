<?php /* Template_ 2.2.8 2024/03/10 19:02:33 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/coupon/coupon.htm 000006459 */ 
$TPL_couponList_1=empty($TPL_VAR["couponList"])||!is_array($TPL_VAR["couponList"])?0:count($TPL_VAR["couponList"]);?>
<!-- 컨텐츠 S -->
<section class="fb__mypage fb__coupon wrap-mypage br__mypage-coupon">
	<div class="fb__mypage-title">
		<div class="title-md">쿠폰 관리</div>
	</div>
	<div class="coupon">
<?php if($TPL_VAR["langType"]=='korean'){?>
		<section class="coupon__top">
			<form id="devInputCoupon">
			<div class="coupon-registration">
				<div class="tit coupon-registration__title">쿠폰 등록</div>
				<div class="fb__form-item">
					<label for="devCouponNum" class="hide">쿠폰번호</label>
					<input type="text" name="coupon_num" id="devCouponNum" class="fb__form-input" title="쿠폰번호" placeholder="쿠폰 번호를 입력해 주세요." />
				</div>
				<input type="submit" id="devSubmitBtn" class="btn-lg btn-dark-line btn-point" value="등록" />
			</div>
			<div>
                <p class="coupon-registration__desc--fail" id="devInputFail" style="display: none;">잘못 입력되거나 존재하지 않는 쿠폰 번호입니다.</p>
			</div>
			<div class="txt-list">
				<p>배럴에서 발급한 쿠폰 번호를 입력해 주세요. (대소문자 구분, 일련번호 ‘-‘ 제외)</p>
				<p>쿠폰 등록 시 발급 기간 및 사용 기한을 반드시 확인해 주세요.</p>
			</div>
			</form>
		</section>
<?php }?>
		<section class="coupon__detail">
			<div class="fb-tab__wrap fb-tab__col">
				<div class="fb-tab__nav">
					<ul>
						<li class="active">
							<a href="javascript:void(0);">
								보유 쿠폰
								(<em class="txt-red"><span  id="devCouponCount">0</span></em>)
							</a>
						</li>
						<li>
							<a href="javascript:void(0);">
								발급 가능
								<span>(<em class="txt-red"><?php echo $TPL_VAR["downTatal"]?></em>)</span>
							</a>
						</li>
					</ul>
				</div>
				<form id="devListForm">
					<input type="hidden" name="page" value="1" id="devPage"/>
					<input type="hidden" name="max" value="99999" />
					<input type="hidden" name="couponUseYn" value="1" id="devCouponUse" />
				</form>
				<div class="fb-tab__contents-wrap">
					<div class="fb-tab__contents active">
						<div class="coupon__list-wrap">
							<ul id="devListContents" class="coupon__list">
								<li id="devListDetail" class="coupon__list-item">
									<div class="coupon__box">
										<div class="coupon__box-haed">
											{[#if use_sdate_text]}
											<span class="day">{[use_sdate_text]} ~ {[use_edate_text]}</span>
											{[/if]}
											<span class="available">{[regist_diff]}</span>
										</div>
										<div class="coupon__box-cont">
											<div class="title-lg"><em>{[cupon_sale_value_text]}</em> 할인</div>
											<p class="name">{[publish_name]}</p>
											<p class="desc txt-desc">{[publish_condition_price_text]}</p>
										</div>
									</div>
									<!--<a href="#;" class="btn-link devItemInfo" data-ix="{[publish_ix]}">적용대상 상품 보기</a>-->
								</li>

								<div class="empty-content devForbizTpl" id="devListEmpty">
									<p>사용가능한 쿠폰이 없습니다.</p>
								</div>
								<div class="devForbizTpl" id="devListLoading">
									<div class="loading"></div>
								</div>
							</ul>
						</div>
					</div>

					<div class="fb-tab__contents">
<?php if($TPL_VAR["downTatal"]== 0){?>
						<div class="coupon__list-wrap">
							<ul class="coupon__list">
								<li class="coupon__list-item">
									<a href="javascript:void(0);" class="btn-link">다운로드 가능한 쿠폰이 없습니다.</a>
								</li>
							</ul>
						</div>
<?php }else{?>
						<div class="coupon__list-wrap devDownLoadCoupon">
							<ul class="coupon__list">
<?php if($TPL_couponList_1){foreach($TPL_VAR["couponList"] as $TPL_V1){
$TPL_DownUse_2=empty($TPL_V1["DownUse"])||!is_array($TPL_V1["DownUse"])?0:count($TPL_V1["DownUse"]);?>
<?php if($TPL_DownUse_2){foreach($TPL_V1["DownUse"] as $TPL_V2){?>
								<li class="coupon__list-item">
									<div class="coupon__box">
										<div class="coupon__box-haed">
											<span class="day">
<?php if($TPL_V1["use_date_type"]=='9'){?>
													무기한
<?php }elseif($TPL_V1["use_date_type"]=='1'){?>
													<?php echo $TPL_V1["regdate"]?> ~ <?php echo $TPL_V1["publish_limit_date"]?>

<?php }elseif($TPL_V1["use_date_type"]=='2'){?>
													발급 후 <?php echo $TPL_V1["regist_date_differ"]?>

<?php if($TPL_V1["regist_date_type"]=='3'){?>
														일
<?php }elseif($TPL_V1["regist_date_type"]=='2'){?>
														개월
<?php }elseif($TPL_V1["regist_date_type"]=='1'){?>
														년
<?php }?>
													이내 사용 가능
<?php }elseif($TPL_V1["use_date_type"]=='3'){?>
													<?php echo $TPL_V1["use_sdate"]?> ~ <?php echo $TPL_V1["use_edate"]?>

<?php }?>
											</span>
											<span class="available">1장 발급 가능</span>
										</div>
										<div class="coupon__box-cont">
											<div class="title-lg"><em><?php echo number_format($TPL_V1["cupon_sale_value"])?><?php if($TPL_V1["cupon_sale_type"]=='1'){?>%<?php }else{?>원<?php }?></em> 할인</div>
											<p class="name">
<?php if($TPL_V1["use_product_type"]=='1'){?>
												전 상품 대상 할인 쿠폰
<?php }elseif($TPL_V1["use_product_type"]=='2'){?>
												특정 카테고리 상품 대상 할인 쿠폰
<?php }elseif($TPL_V1["use_product_type"]=='3'){?>
												특정 상품 대상 할인 쿠폰
<?php }?>
											</p>
											<p class="desc txt-desc">
<?php if($TPL_V1["publish_min"]=='N'){?>
												제한조건없음
<?php }else{?>
												<?php echo number_format($TPL_V1["publish_condition_price"])?> 원 이상 구매시
<?php }?>
											</p>
										</div>
									</div>
									<button type="button" class="btn-lg btn-dark-line" devPublishIx="<?php echo $TPL_V1["publish_ix"]?>">쿠폰 받기</button>
									<!--<a href="#;" class="btn-link">적용대상 상품 보기</a>-->
								</li>
<?php }}?>
<?php }}?>
							</ul>
							<!--<div class="coupon__list-footer">
								<button type="button" class="btn-lg btn-dark">쿠폰 전체 받기</button>
							</div>-->
						</div>
<?php }?>
					</div>
				</div>
			</div>
		</section>
	</div>
</section>
<!-- 컨텐츠 E -->