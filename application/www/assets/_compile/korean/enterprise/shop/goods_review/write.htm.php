<?php /* Template_ 2.2.8 2020/08/31 15:57:17 /home/barrel-stage/application/www/assets/templet/enterprise/shop/goods_review/write.htm 000009207 */ ?>
<div class="fb__goods-review-write wrap-window-popup review-popup">
    <div class="write">
        <p class="popup-title">
            <span><?php if($TPL_VAR["mode"]=='modify'){?>상품 후기 수정<?php }else{?>상품 후기 작성<?php }?></span>
            <span class="close" onclick="window.close();"></span>
        </p>

        <div class="popup-content">
            <div class="item">
                <div class="thumb">
                    <img src="<?php echo $TPL_VAR["thumb"]?>">
                </div>
                <div class="info">
                    <p class="title"><?php if($TPL_VAR["brand_name"]){?>[<?php echo $TPL_VAR["brand_name"]?>] <?php }?><?php echo $TPL_VAR["pname"]?></p>
                    <p class="option"><?php echo $TPL_VAR["option_name"]?></p>
                    <p class="date">구매일:<?php echo $TPL_VAR["buy_date"]?></p>
                </div>

            </div>

            <form id="devReviewForm" method="post" enctype="multipart/form-data">
                <input type="hidden" name="pid" value="<?php echo $TPL_VAR["pid"]?>" />
                <input type="hidden" name="oid" value="<?php echo $TPL_VAR["oid"]?>" />
                <input type="hidden" name="ode_ix" value="<?php echo $TPL_VAR["ode_ix"]?>" />
                <input type="hidden" name="bbsIx" value="<?php echo $TPL_VAR["bbsIx"]?>" />
                <input type="hidden" name="mode" id="mode" value="<?php echo $TPL_VAR["mode"]?>" />
                <table class="join-table">
                    <colgroup>
                        <col width="120px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="col"><em class="star">*</em>상품후기 유형</th>
                        <td>
                            <div class="fb__review-write__type wrap-review-type fb__wrap-radio">
                                <label class="fb__wrap-radio__label menu-normal">
                                    <input type="radio" id="nor_type" name="type" value="2" <?php if($TPL_VAR["mode"]=='modify'){?>disabled<?php }?>  <?php if($TPL_VAR["bbs_div"]=='2'){?>checked<?php }?>>
                                    <span class="fb__wrap-radio__txt">일반후기</span>
                                </label>
                                <label class="fb__wrap-radio__label menu-photo">
                                    <input type="radio" id="pri_type" name="type" value="1" <?php if($TPL_VAR["mode"]=='modify'){?>disabled<?php }?> <?php if($TPL_VAR["bbs_div"]=='1'){?>checked<?php }?>>
                                    <span class="fb__wrap-radio__txt">포토후기</span>
                                </label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th scope="col"><em class="star">*</em>상품평가</th>
                        <td>
                            <p class="valuation">
                                <input type="hidden" name="valuation_goods" class="valuation-goods" value="<?php echo $TPL_VAR["valuation_goods"]?>" id="devValuationGoods" title="상품평가">
                                <span class="star-links">
                                        <a href="#" onclick="starRate(this, 1, '#devValuationGoods');" name="star-link_1" class="star-link" >1</a>
                                        <a href="#" onclick="starRate(this, 2, '#devValuationGoods');" name="star-link_2" class="star-link" >2</a>
                                        <a href="#" onclick="starRate(this, 3, '#devValuationGoods');" name="star-link_3" class="star-link" >3</a>
                                        <a href="#" onclick="starRate(this, 4, '#devValuationGoods');" name="star-link_4" class="star-link" >4</a>
                                        <a href="#" onclick="starRate(this, 5, '#devValuationGoods');" name="star-link_5" class="star-link on">5</a>
                                    </span>
                                <img class="rating-img" src="/assets/templet/enterprise/img/common/star_s_<?php echo $TPL_VAR["valuation_goods"]?>.png" style="cursor:pointer;" alt="5" height='30px'>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col"><em class="star">*</em>배송평가</th>
                        <td>
                            <p class="valuation">
                                <input type="hidden" name="valuation_delivery" class="valuation-goods" value="<?php echo $TPL_VAR["valuation_delivery"]?>" id="devValuationDelivery" title="배송평가">
                                <span class="star-links">
                                        <a href="#" onclick="starRate(this, 1, '#devValuationDelivery');" name="star-link_1" class="star-link" >1</a>
                                        <a href="#" onclick="starRate(this, 2, '#devValuationDelivery');" name="star-link_2" class="star-link" >2</a>
                                        <a href="#" onclick="starRate(this, 3, '#devValuationDelivery');" name="star-link_3" class="star-link" >3</a>
                                        <a href="#" onclick="starRate(this, 4, '#devValuationDelivery');" name="star-link_4" class="star-link" >4</a>
                                        <a href="#" onclick="starRate(this, 5, '#devValuationDelivery');" name="star-link_5" class="star-link on">5</a>
                                    </span>
                                <img class="rating-img" src="/assets/templet/enterprise/img/common/star_s_<?php echo $TPL_VAR["valuation_delivery"]?>.png" style="cursor:pointer;" alt="<?php echo $TPL_VAR["index"]?>" height='30px'>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="col"><em class="star">*</em>제목</th>
                        <td><input type="text" name="bbs_subject" value="<?php echo $TPL_VAR["bbs_subject"]?>"></td>
                    </tr>

                    <tr>
                        <th scope="col"><em class="star">*</em>내용</th>
                        <td><textarea name="bbs_contents" placeholder="내용은 30자 이상으로 작성해 주세요." id="devBbsContents" title="내용"><?php echo $TPL_VAR["bbs_contents"]?></textarea></td>
                    </tr>
<?php if($TPL_VAR["mode"]!='modify'){?>
                    <tr id="devPhotoUpload" class="write__photo">
                        <th scope="col">
                            <em id="require">*</em>이미지 첨부
                        </th>
                        <td>
                            <div class=" wrap-file">
<?php if(is_array($TPL_R1=range( 1, 5))&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
                                <div class="write__file-wrap devFileWrap<?php echo $TPL_V1?>" id="devFileWrap<?php echo $TPL_V1?>">
<?php if($TPL_VAR["mode"]=='modify'){?>
                                    <button class="write__upload file-upload-btn" disabled></button>
                                    <input type="file" class="file-upload"  name="bbsFile<?php echo $TPL_V1?>" id="devBbsFile<?php echo $TPL_V1?>"  title="첨부파일" accept=".jpg, .jpeg, .png, .gif" disabled>
<?php }else{?>
                                    <button class="write__upload file-upload-btn"></button>
                                    <input type="file" class="file-upload"  name="bbsFile<?php echo $TPL_V1?>" id="devBbsFile<?php echo $TPL_V1?>"  title="첨부파일" accept=".jpg, .jpeg, .png, .gif">
<?php }?>
                                </div>
                                <div class="upload-img-area" id="devFileImageWrap<?php echo $TPL_V1?>" style="display:none;">
                                    <img id="devFileImage<?php echo $TPL_V1?>">
                                    <span class="upload-cancel-btn" id="devFileDeleteButton<?php echo $TPL_V1?>"></span>
                                </div>

<?php }}?>

                            </div>
                            <p class="desc" >이미지 당 30MB 이내의 이미지 파일(jpg, jpeg, gif, png)만 첨부할 수 있습니다.</p>
                        </td>
                    </tr>
<?php }?>
                    </tbody>
                </table>

                <p class="desc">
                    <?php echo trans('작성하신 상품후기는
                    <span class="fb__point-color">마이페이지 <em></em> 나의 상품 후기</span>
                    에서 확인하실 수 있습니다.')?>

                </p>

                <div class="popup-btn-area">
                    <button class="btn-default btn-dark-line" type="button" id="devReviewCancel">취소</button>
                    <button class="btn-default fb__btn-point" id="devReviewSubmit">저장</button>
                </div>
            </form>
        </div>
    </div>
</div>