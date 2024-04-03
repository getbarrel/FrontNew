<?php /* Template_ 2.2.8 2024/02/23 12:19:05 /home/barrel-stage/application/www/assets/mobile_templet/mobile_enterprise/popup/change_option/change_option.htm 000008058 */ ?>
<script src="<?php echo $TPL_VAR["layoutCommon"]["templetSrc"]?>/js/common/minicart.js?version=<?php echo CLIENT_VERSION?>" data-url="/controller/product/loadOptionDatas/<?php echo $TPL_VAR["pid"]?>" id="devMinicartScript"></script>

<div class="br__goods-view br__cart__change"> <!-- 디자인 적용을 위한 wrap 태그 -->

    <div class="goods-info" id="devSildeMinicartArea" data-pid="<?php echo $TPL_VAR["pid"]?>" data-cart_Ix="<?php echo $TPL_VAR["cartIx"]?>" data-pcount="<?php echo $TPL_VAR["pcount"]?>">
        <div class="devForbizTpl" id="devSildeLonelyOption">
            <span id="devSildeLonelyOptionName">
                <p>{[option_name]}</p>
            </span>
        </div>
        <div class="popup-content__wrap">
            <div class="popup-content devProductContents">
                <div class="br__goods-view br__cart__change">
                    <div class="goods-info">
                        <ul class="product-list">
                            <li class="product-list__item" id="devSildeMinicartArea">
                                <dl class="product-list__group">
                                    <dt class="product-list__group-left">
                                        <figure class="product-list__thumb">
                                            <img src="<?php echo $TPL_VAR["thumb_src"]?>" alt="" />
                                        </figure>
                                    </dt>
                                    <dd class="product-list__group-right">
                                        <div class="product-list__info goods-info" data-pid="<?php echo $TPL_VAR["pid"]?>" data-cart_ix="<?php echo $TPL_VAR["cartIx"]?>" data-pcount="<?php echo $TPL_VAR["pcount"]?>">
                                            <div class="product-list__info__title"><?php echo $TPL_VAR["pname"]?></div>
<?php if($TPL_VAR["cartOptionp"]["options_text"]==''){?>
                                            <!-- 세트 상품 S -->
                                            <input type="hidden" name="cartType" class="cartType" value="set" />
                                            <div class="product-list__info__option set">
<?php if(is_array($TPL_R1=$TPL_VAR["cartOptionp"]["setData"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                                                    <div class="product-list__info__option-item">
                                                        <span class="set-tit"><?php echo $TPL_V1["name"]?> :</span>
                                                        <span class="color"><?php echo $TPL_V1["option"]?><!--</span>
                                                        <span class="size">M--></span>
                                                        <span class="count"><?php echo $TPL_V1["pcount"]?>개</span>
                                                    </div>
<?php }}?>
                                            </div>
                                            <!-- 세트 상품 E -->
<?php }else{?>
                                            <div class="product-list__info__option set">
                                                <div class="product-list__info__option-item">
                                                    <span class="color"><?php echo $TPL_VAR["cartOptionp"]["add_info"]?></span>
                                                    <span class="size"><?php echo str_replace("사이즈:","",$TPL_VAR["cartOptionp"]["options_text"])?></span>
                                                    <span class="count"><?php echo $TPL_VAR["cartOptionp"]["pcount"]?>개</span>
                                                </div>
                                            </div>
<?php }?>
                                            <dl class="goods-info__option"id="devSildeLonelyOptionName"></dl>
                                            <div class="product-list__info__price">
<?php if($TPL_VAR["discount_rate"]> 0){?><span class="product-list__info__price--discount"><?php echo $TPL_VAR["discount_rate"]?>%</span><?php }?>
<?php if($TPL_VAR["discount_rate"]> 0){?><del class="product-list__info__price--strike"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["listprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></del><?php }?>
                                                <span class="product-list__info__price--cost"><?php echo $TPL_VAR["fbUnit"]["f"]?><em><?php echo g_price($TPL_VAR["dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></span>
                                                <input type="hidden" id="dcprice" value="<?php echo $TPL_VAR["dcprice"]?>">
                                                <!-- 판매중지 / 판매예정 / 판매종료 S -->
                                                <!-- 숨김처리 -->
                                                <span class="product-list__info__price--stop" style="display: none">판매중지</span>
                                                <!-- 판매중지 / 판매예정 / 판매종료 E -->

                                                <!-- 솔드아웃 S -->
                                                <!-- 숨김처리 -->
                                                <span class="product-list__info__price--soldout" style="display: none">품절</span>
                                                <!-- 솔드아웃 E -->
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                                <div class="product-list__select goods-info__select" id="devSildeMinicartOptions" data-oprionCode="<?php echo $TPL_VAR["dOpt"]?>"></div>
                            </li>
                        </ul>
                        <div class="control">
                            <div class="control-group">
                                <div class="control-title">수량</div>
                                <ul class="option-up-down devAddOptionContents">
                                    <li><button class="down devCountDownButton"></button></li>
                                    <li><input type="text" value="<?php echo $TPL_VAR["cartOptionp"]["pcount"]?>" class="br__form-input devCount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" /></li>
                                    <li><button class="up devCountUpButton"></button></li>
                                </ul>
                                <input type="hidden" value="<?php echo $TPL_VAR["cartIx"]?>" class="cart_ix">
                            </div>
                            <!-- 수량 초과 시 노출 S -->
                            <!-- 숨김처리 -->
                            <div class="cart-item__warning" style="display: none">
                                <p class="txt-error">주문 가능한 수량은 최대 <em>999</em>개입니다.</p>
                            </div>
                            <!-- 수량 초과 시 노출 E -->
                        </div>
                        <!-- 최종 금액 S -->
                        <dl class="goods-info__total">
                            <dt>총 상품 금액</dt>
                            <dd><?php echo $TPL_VAR["fbUnit"]["f"]?><em id="total_dcprice"><?php echo g_price($TPL_VAR["cartOptionp"]["total_dcprice"])?></em><?php echo $TPL_VAR["fbUnit"]["b"]?></dd>
                        </dl>
                        <!-- 최종 금액 E -->
                    </div>
                </div>
                <div class="popup-layout__footer">
                    <button type="button" class="btn-lg btn-dark-line devCountUpdateButton">변경하기</button>
                </div>
            </div>
        </div>

    </div>

</div>