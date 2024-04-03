<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/coupon/coupon_bak.htm 000007734 */ 
$TPL_coupons_1=empty($TPL_VAR["coupons"])||!is_array($TPL_VAR["coupons"])?0:count($TPL_VAR["coupons"]);
$TPL_usedCoupons_1=empty($TPL_VAR["usedCoupons"])||!is_array($TPL_VAR["usedCoupons"])?0:count($TPL_VAR["usedCoupons"]);?>
<?php $this->print_("mypage_top",$TPL_SCP,1);?>


<div class="fb__mypage wrap-mypage">
<?php if(false){?>
    <section>
        <h1>나의 쿠폰</h1>
        <div class="wrap-coupon-reg">
            <form>
                <p class="tit">쿠폰 등록하기</p>
                <input type="text" placeholder="하이픈(-)없이 숫자만 입력해 주세요.">
                <input type="submit" class="btn-default btn-point" value="등록">
            </form>
            <p class="desc">오프라인 쿠폰, 메일, 모바일 등에서 받으신 쿠폰 번호를 입력해서 등록하실 수 있습니다.</p>
        </div>

    </section>
<?php }?>
    <section class="mypage-coupon">
        <h2  class="fb__mypage__title">Coupon history</h2>
        <div class="tab-control">
            <ul class="tab-link">
                <li class="active"><a href="#tab1">Available</a></li>
                <li class=""><a href="#tab2">Used Coupon(s)</a></li>
            </ul>
            <div class="tab-contents">
                <div id="tab1" class="tab active">
                    <table class="table-default coupon-table">
                        <colgroup>
                            <col width="*">
                            <col width="14%">
                            <col width="14%">
                            <col width="23%">
                            <col width="14%">
                        </colgroup>
                        <thead>
                        <th>Coupon name</th>
                        <th>Discount/discount rate</th>
                        <th>the valid period</th>
                        <th>Terms of use</th>
                        <th>Applicable target</th>
                        </thead>
                        <tbody>
<?php if($TPL_coupons_1){foreach($TPL_VAR["coupons"] as $TPL_V1){?>
                        <tr>
                            <td class="txt-l"><strong><?php if($TPL_V1["cupon_use_div"]=='G'){?>[웹전용] <?php }elseif($TPL_V1["cupon_use_div"]=='M'){?>[모바일전용] <?php }else{?><?php }?><?php echo $TPL_V1["publish_name"]?></strong></td>
                            <td class="point"><span><?php echo number_format($TPL_V1["cupon_sale_value"])?></span><?php if($TPL_V1["cupon_sale_type"]=='1'){?>%<?php }elseif($TPL_V1["cupon_sale_type"]=='2'){?>원<?php }?></td>
                            <td>
<?php if($TPL_V1["use_date_limit"]>'3000-12-31 00:00:00'||$TPL_V1["use_date_type"]=='9'){?>
                                무기한
<?php }elseif($TPL_V1["use_date_type"]=='2'){?>
                                <?php echo substr($TPL_V1["regist_start"], 0, 10)?> <BR> ~ <?php echo substr($TPL_V1["regist_end"], 0, 10)?>

<?php }elseif($TPL_V1["use_date_type"]=='1'){?>
                                <?php echo substr($TPL_V1["regdate"], 0, 10)?> <BR> ~ <?php echo substr($TPL_V1["publish_limit_date"], 0, 10)?>

<?php }else{?>
                                <?php echo substr($TPL_V1["use_sdate"], 0, 10)?> <BR> ~ <?php echo substr($TPL_V1["use_edate"], 0, 10)?>

<?php }?>
                            </td>
                            <td>
<?php if($TPL_V1["publish_condition_price"]>'0'){?>
                                <?php echo number_format($TPL_V1["publish_condition_price"])?>Purchase more than
<?php }else{?>
                                No constraints
<?php }?>
                            </td>
                            <td>
<?php if($TPL_V1["use_product_type"]=='1'){?>
                                Apply all products
<?php }else{?>
                                <a href="javascript:void(0)" class="btn-apply-item" devRegistix="<?php echo $TPL_V1["regist_ix"]?>"">Confirm applied products</a>
<?php }?>
                            </td>
                        </tr>
<?php }}else{?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-content">
                                    <p>There are no coupon lists.</p>
                                </div>
                            </td>
                        </tr>
<?php }?>
                        </tbody>
                    </table>
                </div>
                <div id="tab2" class="tab">
                    <table class="table-default coupon-table">
                        <colgroup>
                            <col width="*">
                            <col width="15%">
                            <col width="14%">
                            <col width="18%">
                            <col width="12%">
                            <col width="14%">
                        </colgroup>
                        <thead>
                        <th>Coupon name</th>
                        <th>Discount/discount rate</th>
                        <th>the valid period</th>
                        <th>Terms of use</th>
                        <th>whether to use</th>
                        <th>Applicable target</th>
                        </thead>
                        <tbody>
<?php if($TPL_usedCoupons_1){foreach($TPL_VAR["usedCoupons"] as $TPL_V1){?>
                        <tr>
                            <td class="txt-l"><strong><?php if($TPL_V1["cupon_use_div"]=='G'){?>[웹전용] <?php }elseif($TPL_V1["cupon_use_div"]=='M'){?>[모바일전용] <?php }else{?><?php }?><?php echo $TPL_V1["publish_name"]?></strong></td>
                            <td class="point"><span><?php echo number_format($TPL_V1["cupon_sale_value"])?></span><?php if($TPL_V1["cupon_sale_type"]=='1'){?>%<?php }elseif($TPL_V1["cupon_sale_type"]=='2'){?>원<?php }?></td>
                            <td>
<?php if($TPL_V1["use_date_limit"]>'3000-12-31 00:00:00'||$TPL_V1["use_date_type"]=='9'){?>
                                an indefinite period
<?php }else{?>
                                <?php echo substr($TPL_V1["use_sdate"], 0, 10)?> <br>~<?php echo substr($TPL_V1["use_edate"], 0, 10)?>

<?php }?>
                            </td>
                            <td>
<?php if($TPL_V1["publish_condition_price"]>'0'){?>
                                <?php echo number_format($TPL_V1["publish_condition_price"])?>원 이상 구매시
<?php }else{?>
                                No constraints
<?php }?>
                            </td>
                            <td>
<?php if($TPL_V1["use_yn"]=='1'){?>
                                Used
<?php }else{?>
                                Expiration
<?php }?>
                            </td>
                            <td>
<?php if($TPL_V1["use_product_type"]=='1'){?>
                                Apply all products
<?php }else{?>
                                <a href="javascript:void(0)" class="btn-apply-item" devRegistix="<?php echo $TPL_V1["regist_ix"]?>">Confirm applied products</a>
<?php }?>
                            </td>
                        </tr>
<?php }}else{?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-content">
                                    <p>There are no coupon lists.</p>
                                </div>
                            </td>
                        </tr>
<?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>