<?php /* Template_ 2.2.8 2024/03/10 19:03:27 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/mypage/coupon/coupon.htm 000009919 */ 
$TPL_couponList_1=empty($TPL_VAR["couponList"])||!is_array($TPL_VAR["couponList"])?0:count($TPL_VAR["couponList"]);?>
<section id="container" class="br__layout">
    <!-- 컨텐츠 S -->
    <section class="br__coupon">
        <div class="page-title my-title">
            <div class="title-sm">쿠폰 관리</div>
        </div>
        <div class="coupon">
<?php if($TPL_VAR["langType"]=='korean'){?>
            <section class="coupon-top">
                <div class="coupon-registration">
                    <div class="title-sm">쿠폰 등록</div>
                    <div class="br__form-item">
                        <label for="devCouponNum" class="hidden">쿠폰번호</label>
                        <input type="text" name="coupon_num" id="devCouponNum" class="br__form-input" title="쿠폰번호" placeholder="쿠폰 번호를 입력해 주세요." />
                        <input type="submit" id="devSubmitBtn" class="btn-lg btn-dark-line" value="등록" />
                    </div>
                </div>
                <div class="txt-list">
                    <p>배럴에서 발급한 쿠폰 번호를 입력해 주세요.<br />(대소문자 구분, 일련번호 ‘-‘ 제외)</p>
                    <p>쿠폰 등록 시 발급 기간 및 사용 기한을 반드시 확인해 주세요.</p>
                </div>
            </section>
<?php }?>
            <section class="coupon-detail">
                <div class="br-tab__wrap br-tab__col">
                    <div class="br-tab__nav">
                        <ul>
                            <li class="active">
                                <a href="javascript:void(0);">
                                    보유 쿠폰
                                    <span>(<em class="txt-red" id="devCouponCount">0</em>)</span>
                                </a>
                            </li>
                            <li>
                                <a href="avascript:void(0);">
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
                    <div class="br-tab__contents-wrap">
                        <div class="br-tab__contents active">
                            <div class="coupon-wrap">
                                <div class="coupon-list" id="devListContents">
                                    <div class="coupon-item" id="devListDetail">
                                        <dl class="coupon-box">
                                            <dt class="coupon-box__top">
                                                {[#if use_sdate_text]}
                                                <span class="day">{[use_sdate_text]} ~ {[use_edate_text]}</span>
                                                {[/if]}
                                                <span class="count txt-red">{[regist_diff]}</span>
                                            </dt>
                                            <dd class="coupon-box__bottom">
                                                <div class="title-lg"><span>{[cupon_sale_value_text]}</span> 할인</div>
                                                <p class="name txt-dark">{[publish_name]}</p>
                                                <p class="desc txt-gray">{[publish_condition_price_text]}</p>
                                            </dd>
                                        </dl>
                                        <!--<a href="#;" class="btn-link">적용대상 상품 보기</a>-->
                                    </div>

                                    <!-- 쿠폰이 없을 경우 S -->
                                    <!-- 숨김 처리 -->
                                    <div class="coupon-item no-data" id="devListEmpty">
                                        <p class="empty-content">보유한 쿠폰이 없습니다.</p>
                                    </div>
                                    <div class="devForbizTpl" id="devListLoading">
                                        <div class="loading"></div>
                                    </div>
                                    <!-- 쿠폰이 없을 경우 E -->
                                </div>
                            </div>
                        </div>
                        <div class="br-tab__contents">
                            <div class="coupon-wrap">
                                <!--<div class="coupon-all">
                                    <button type="button" class="btn-lg btn-dark coupon-all__btn">쿠폰 전체 받기</button>
                                </div>-->
                                <div class="coupon-list">
                                    <!-- 발급 가능한 쿠폰이 없을 경우 S -->
                                    <!-- 숨김 처리 -->
<?php if($TPL_VAR["downTatal"]== 0){?>
                                        <div class="coupon-item no-data" style="display: none">
                                            <p class="empty-content">발급 가능한 쿠폰이 없습니다.</p>
                                        </div>
<?php }else{?>
                                    <!-- 발급 가능한 쿠폰이 없을 경우 E -->
<?php if($TPL_couponList_1){foreach($TPL_VAR["couponList"] as $TPL_V1){
$TPL_DownUse_2=empty($TPL_V1["DownUse"])||!is_array($TPL_V1["DownUse"])?0:count($TPL_V1["DownUse"]);?>
<?php if($TPL_DownUse_2){foreach($TPL_V1["DownUse"] as $TPL_V2){?>
                                        <div class="coupon-item devDownLoadCoupon">
                                            <dl class="coupon-box">
                                                <dt class="coupon-box__top">
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
                                                    <span class="count txt-red">1장 발급 가능</span>
                                                </dt>
                                                <dd class="coupon-box__bottom">
                                                    <div class="title-lg"><span><?php echo number_format($TPL_V1["cupon_sale_value"])?></span><?php if($TPL_V1["cupon_sale_type"]=='1'){?>%<?php }else{?>원<?php }?> 할인</div>
                                                    <p class="name txt-dark">
<?php if($TPL_V1["use_product_type"]=='1'){?>
                                                        전 상품 대상 할인 쿠폰
<?php }elseif($TPL_V1["use_product_type"]=='2'){?>
                                                        특정 카테고리 상품 대상 할인 쿠폰
<?php }elseif($TPL_V1["use_product_type"]=='3'){?>
                                                        특정 상품 대상 할인 쿠폰
<?php }?>
                                                    </p>
                                                    <p class="desc txt-gray">
<?php if($TPL_V1["publish_min"]=='N'){?>
                                                        제한조건없음
<?php }else{?>
                                                        <?php echo number_format($TPL_V1["publish_condition_price"])?> 원 이상 구매시
<?php }?>
                                                    </p>
                                                </dd>
                                            </dl>
                                            <div class="btn-box">
                                                <button type="button" class="btn-lg btn-dark-line" devPublishIx="<?php echo $TPL_V1["publish_ix"]?>">쿠폰 받기</button>
                                            </div>
                                            <!--<a href="#;" class="btn-link">적용대상 상품 보기</a>-->
                                        </div>
<?php }}?>
<?php }}?>
<?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    <!-- 컨텐츠 E -->
</section>