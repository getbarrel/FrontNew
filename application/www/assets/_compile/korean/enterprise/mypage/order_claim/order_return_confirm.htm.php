<?php /* Template_ 2.2.8 2020/08/31 15:57:16 /home/barrel-stage/application/www/assets/templet/enterprise/mypage/order_claim/order_return_confirm.htm 000029577 */ ?>
<div class="wrap-mypage wrap-order-claim">
    <ul class="claim-step mat50">
        <li class="on">교환정보 입력</li>
        <li>교환정보 확인</li>
        <li>교환신청 완료</li>
    </ul>

    <h1>상품 교환신청</h1>


    <!--교환신청완료일때 보이지않음 S-->
    <div class="desc">
        <p>교환 신청하기 전 원활한 서비스를 위해 관련 내용을 협의 후 처리해 주셔야 합니다.</p>
        <p>구매자 귀책 사유인 경우 추가 배송비가 발생할 수 있으며 판매자 귀책 사유인 경우에는 추가 배송비가 발생하지 않습니다.</p>
        <p>판매자와 협의 없이 신청 시에는 교환 처리가 되지 않을 수 있습니다.(상품에 따라 반품/교환 처리가 불가능한 상품이 있습니다.)</p>
    </div>
    <!--교환신청완료일때 보이지않음 E -->

    <div class="order-number-box">
        <span class="tit">주문번호</span>
        <span class="order-num">201712271238-0000001</span>
        <span class="tit">주문일자</span>
        <span class="order-date">2018-06-05</span>
    </div>


    <!--교환정보 입력 S -->
    <section>
        <table class="table-default order-table">
            <colgroup>
                <col width="40px"/>
                <col width="*"/>
                <col width="100px"/>
                <col width="100px"/>
                <col width="100px"/>
            </colgroup>
            <thead>
            <th><input type="checkbox"></th>
            <th>상품명/옵션</th>
            <th>주문수량</th>
            <th>취소수량</th>
            <th>결제금액</th>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input type="checkbox">
                </td>
                <td>
                    <a href="#">
                        <div class="thumb">
                            <img src="<?php echo $TPL_VAR["templet_src"]?>/img/sample/sample_90.jpg">
                        </div>
                        <div class="info">
                            <p class="title">[브랜드명] 우리지역 시금치 200g</p>
                            <p class="option">흙당근 10kg</p>
                        </div>
                    </a>
                </td>

                <td><em>1</em>개</td>

                <td>
                    <select>
                        <option>1</option>
                    </select>
                </td>

                <td class="price"><em>19,000</em>원</td>

            </tr>
            <tr>
                <td>
                    <input type="checkbox">
                </td>
                <td>
                    <a href="#">
                        <div class="thumb">
                            <img src="<?php echo $TPL_VAR["templet_src"]?>/img/sample/sample_90.jpg">
                        </div>
                        <div class="info">
                            <p class="title">[브랜드명] 우리지역 시금치 200g</p>
                            <p class="option">흙당근 10kg</p>
                        </div>
                    </a>
                </td>

                <td><em>1</em>개</td>

                <td>
                    <select>
                        <option>1</option>
                    </select>
                </td>

                <td class="price"><em>19,000</em>원</td>

            </tr>
            </tbody>
        </table>
        <div class="delivery-area">
            <span>배송비 <em>2,500원</em> (<em>50,000</em> 이상 구매 시 무료 배송)</span>
        </div>
    </section>

    <section>
        <table class="join-table type02 table-reason">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tbody>
            <tr>
                <th><em>*</em>교환사유</th>
                <td>
                    <select>
                        <option>교환사유 선택</option>
                    </select>
                    <textarea placeholder="교환사유를 입력해 주세요." onkeyup="onkeylengthMax(this, 200, 'msg_byte');" maxlength="100"></textarea>
                    <div class="counting">
                        <span><em id="msg_byte">0</em>/100 자</span>
                    </div>
                </td>
            </tr>
            </tbody>

        </table>
    </section>

    <section>
        <h1>교환방법</h1>
        <table class="join-table type02 cancel-table method">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tbody><tr>
                <th><em>*</em>교환 발송 방법</th>
                <td>
                    <div>
                        <input type="radio" name="send_type" id="send_type_1" checked><label for="send_type_1">직접발송 <span>(구매자께서 개별로 상품을 이미 발송한 경우)</span></label>
                    </div>
                    <div class="mat10">
                        <input type="radio" name="send_type" id="send_type_2"><label for="send_type_2">지정택배 방문요청 <span>(판매사와 계약된 택배업체에서 방문수령 수거)</span></label>
                    </div>
                </td>
            </tr>

            <!--직접발송 선택시-->
            <tr class="delivery-info active" method0>
                <th>교환 발송 정보</th>
                <td>
                    <div>
                        <select>
                            <option>배송업체 선택</option>
                        </select>
                        <input type="text" placeholder="송장번호 입력">

                        <input type="checkbox" id=""><label for="">배송업체 정보 입력 안함</label>
                    </div>

                    <div class="mat10">
                        상품발송 시 배송비
                        <span class="radio-area mal10"><input type="radio"><label>선불</label></span>
                        <span class="radio-area"><input type="radio"><label>착불</label></span>
                    </div>

                    <p class="sub-desc">* 교환 발송 정보를 입력하시면 더욱 신속하고 정확한 처리가 이루어질 수 있습니다.</p>
                </td>
            </tr>
            <!--//-->

            <!--지정택배 선택시-->
            <tr method1>
                <th>상품 수거지 주소</th>
                <td>
                    <table>
                        <colgroup>
                            <col width="110px"/>
                            <col width="*"/>
                        </colgroup>
                        <tr>
                            <th><em>*</em>성명</th>
                            <td><input type="text" style="width:250px;"></td>
                        </tr>
                        <tr>
                            <th><em>*</em>주소</th>
                            <td>
                                <div class="form-info-wrap" style="width:500px">
                                    <input type="text" class="dim" name="zip" id="devZip" style="width:140px;" readonly>
                                    <button class="btn-default btn-dark" id="devZipPopupButton">주소찾기</button>
                                    <input type="text" class="dim mat10" name="addr1" id="devAddress1" style="width:500px;" readonly>
                                    <input type="text" class="mat10" style="width:500px;" name="addr2">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><em>*</em>휴대폰 번호</th>
                            <td>
                                <div class="selectWrap">
<?php if($TPL_VAR["explodePcs"][ 0]!=''){?>
                                    <input type="number" name="pcs1" id="devPcs1" value="<?php echo $TPL_VAR["explodePcs"][ 0]?>" title="휴대폰번호" readonly>
<?php }else{?>
                                    <select name="pcs1"  id="devPcs1">
                                        <option value="010" <?php if($TPL_VAR["explodePcs"][ 0]=="010"){?>selcted<?php }?>>010</option>
                                        <option value="011" <?php if($TPL_VAR["explodePcs"][ 0]=="011"){?>selcted<?php }?>>011</option>
                                        <option value="016" <?php if($TPL_VAR["explodePcs"][ 0]=="016"){?>selcted<?php }?>>016</option>
                                        <option value="017" <?php if($TPL_VAR["explodePcs"][ 0]=="017"){?>selcted<?php }?>>017</option>
                                        <option value="018" <?php if($TPL_VAR["explodePcs"][ 0]=="018"){?>selcted<?php }?>>018</option>
                                        <option value="019" <?php if($TPL_VAR["explodePcs"][ 0]=="019"){?>selcted<?php }?>>019</option>
                                    </select>
<?php }?>
                                    <span class="hyphen">-</span>
                                    <input type="number" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["explodePcs"][ 1]?>" title="휴대폰번호" <?php if($TPL_VAR["explodePcs"][ 1]!=''){?>readonly<?php }?>>
                                    <span class="hyphen">-</span>
                                    <input type="number"  name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["explodePcs"][ 2]?>" title="휴대폰번호" <?php if($TPL_VAR["explodePcs"][ 2]!=''){?>readonly<?php }?>>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>전화번호</th>
                            <td>
                                <div class="selectWrap">
                                    <select name="tel1">
                                        <option value="02">02</option>
                                        <option value="031">031</option>
                                        <option value="032">032</option>
                                        <option value="041">041</option>
                                        <option value="042">042</option>
                                        <option value="043">043</option>
                                        <option value="051">051</option>
                                        <option value="052">052</option>
                                        <option value="053">053</option>
                                        <option value="054">054</option>
                                        <option value="055">055</option>
                                        <option value="061">061</option>
                                        <option value="062">062</option>
                                        <option value="063">063</option>
                                        <option value="064">064</option>
                                        <option value="070">070</option>
                                        <option value="080">080</option>
                                        <option value="090">090</option>
                                    </select>
                                    <span class="hyphen">-</span>
                                    <input type="text" name="tel2" id="devTel2" title="전화번호 가운데자리입력">
                                    <span class="hyphen">-</span>
                                    <input type="text" name="tel3" id="devTel3" title="전화번호 끝자리 입력">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>배송요청사항</th>
                            <td><input type="text" style="width:500px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!--//-->

            <!--반품일땐 보이지 않음-->
            <tr>
                <th>교환상품 받으실 주소<br>
                    <span>(구매자 주소지)</span>
                </th>
                <td>
                    <table>
                        <colgroup>
                            <col width="110px"/>
                            <col width="*"/>
                        </colgroup>
                        <tr>
                            <th><em>*</em>성명</th>
                            <td><input type="text" style="width:250px;"></td>
                        </tr>
                        <tr>
                            <th><em>*</em>주소</th>
                            <td>
                                <div class="form-info-wrap" style="width:500px">
                                    <input type="text" class="dim" name="zip" id="devZip" style="width:140px;" readonly>
                                    <button class="btn-default btn-dark" id="devZipPopupButton">주소찾기</button>
                                    <input type="text" class="dim mat10" name="addr1" id="devAddress1" style="width:500px;" readonly>
                                    <input type="text" class="mat10" style="width:500px;" name="addr2">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><em>*</em>휴대폰 번호</th>
                            <td>
                                <div class="selectWrap">
<?php if($TPL_VAR["explodePcs"][ 0]!=''){?>
                                    <input type="number" name="pcs1" id="devPcs1" value="<?php echo $TPL_VAR["explodePcs"][ 0]?>" title="휴대폰번호" readonly>
<?php }else{?>
                                    <select name="pcs1"  id="devPcs1">
                                        <option value="010" <?php if($TPL_VAR["explodePcs"][ 0]=="010"){?>selcted<?php }?>>010</option>
                                        <option value="011" <?php if($TPL_VAR["explodePcs"][ 0]=="011"){?>selcted<?php }?>>011</option>
                                        <option value="016" <?php if($TPL_VAR["explodePcs"][ 0]=="016"){?>selcted<?php }?>>016</option>
                                        <option value="017" <?php if($TPL_VAR["explodePcs"][ 0]=="017"){?>selcted<?php }?>>017</option>
                                        <option value="018" <?php if($TPL_VAR["explodePcs"][ 0]=="018"){?>selcted<?php }?>>018</option>
                                        <option value="019" <?php if($TPL_VAR["explodePcs"][ 0]=="019"){?>selcted<?php }?>>019</option>
                                    </select>
<?php }?>
                                    <span class="hyphen">-</span>
                                    <input type="number" name="pcs2" id="devPcs2" value="<?php echo $TPL_VAR["explodePcs"][ 1]?>" title="휴대폰번호" <?php if($TPL_VAR["explodePcs"][ 1]!=''){?>readonly<?php }?>>
                                    <span class="hyphen">-</span>
                                    <input type="number"  name="pcs3" id="devPcs3" value="<?php echo $TPL_VAR["explodePcs"][ 2]?>" title="휴대폰번호" <?php if($TPL_VAR["explodePcs"][ 2]!=''){?>readonly<?php }?>>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>전화번호</th>
                            <td>
                                <div class="selectWrap">
                                    <select name="tel1">
                                        <option value="02">02</option>
                                        <option value="031">031</option>
                                        <option value="032">032</option>
                                        <option value="041">041</option>
                                        <option value="042">042</option>
                                        <option value="043">043</option>
                                        <option value="051">051</option>
                                        <option value="052">052</option>
                                        <option value="053">053</option>
                                        <option value="054">054</option>
                                        <option value="055">055</option>
                                        <option value="061">061</option>
                                        <option value="062">062</option>
                                        <option value="063">063</option>
                                        <option value="064">064</option>
                                        <option value="070">070</option>
                                        <option value="080">080</option>
                                        <option value="090">090</option>
                                    </select>
                                    <span class="hyphen">-</span>
                                    <input type="text" name="tel2" id="devTel2" title="전화번호 가운데자리입력">
                                    <span class="hyphen">-</span>
                                    <input type="text" name="tel3" id="devTel3" title="전화번호 끝자리 입력">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>배송요청사항</th>
                            <td><input type="text" style="width:500px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!--//-->

            </tbody>
        </table>
    </section>
    <!--교환정보 입력 E -->


    <!--교환정보확인 S-->
    <section>
        <table class="table-default order-table">
            <colgroup>
                <col width="*"/>
                <col width="100px"/>
                <col width="100px"/>
                <col width="100px"/>
            </colgroup>
            <thead>
            <th>상품명/옵션</th>
            <th>주문수량</th>
            <th>교환수량</th>
            <th>결제금액</th>
            </thead>
            <tbody>
            <tr>
                <td>
                    <a href="#">
                        <div class="thumb">
                            <img src="<?php echo $TPL_VAR["templet_src"]?>/img/sample/sample_90.jpg">
                        </div>
                        <div class="info">
                            <p class="title">[브랜드명] 우리지역 시금치 200g</p>
                            <p class="option">흙당근 10kg</p>
                        </div>
                    </a>
                </td>
                <td><em>3</em>개</td>
                <td><em>1</em>개</td>
                <td class="price"><em>19,000</em>원</td>
            </tr>
            </tbody>
        </table>
        <div class="delivery-area">
            <span>배송비 <em>2,500원</em> (<em>50,000</em> 이상 구매 시 무료 배송)</span>
        </div>
    </section>

    <section>
        <table class="join-table type02 cancel-table">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tbody><tr>
                <th rowspan="2">교환사유</th>
                <td>기타(구매자 책임)</td>
            </tr>
            <tr>
                <td>사이즈를 교환하고 싶어요. 교환해 주세요.</td>
            </tr>
            </tbody></table>
    </section>

    <section>
        <h1>교환방법</h1>
        <table class="join-table type02 cancel-table method">
            <colgroup>
                <col width="180px">
                <col width="*">
            </colgroup>
            <tbody>
            <tr>
                <th>교환 발송 방법</th>
                <td>
                    직접발송<span>(구매자께서 새별로 상품을 이미 발송한 경우)</span>
                </td>
            </tr>
            <!--직접발송일때-->
            <tr>
                <th>교환 발송 정보</th>
                <td>
                    우체국 택배 <span>(송장번호:12312312313)</span> <br>
                    상품 발송 시 배송비 <span>선불</span>
                </td>
            </tr>
            <!--//-->

            <!--지정택배일때-->
            <tr>
                <th rowspan="5">상품 수거지 주소</th>
                <td>
                    <dl>
                        <dt>성명</dt>
                        <dd>홍길동</dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>주소</dt>
                        <dd>06744 서울특별시 서초구 바우뫼로37길 56(양재동, 건영빌딩) 2층 포비즈코리아</dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>휴대폰 번호</dt>
                        <dd><em>010-4153-4545</em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>전화번호</dt>
                        <dd><em>02-4153-4545</em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>배송요청사항</dt>
                        <dd></dd>
                    </dl>
                </td>
            </tr>
            <!--//-->
            <tr>
                <th rowspan="5">교환상품 받으실 주소<br>
                    <span>(구매자 주소지)</span>
                </th>
                <td>
                    <dl>
                        <dt>성명</dt>
                        <dd>홍길동</dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>주소</dt>
                        <dd>06744 서울특별시 서초구 바우뫼로37길 56(양재동, 건영빌딩) 2층 포비즈코리아</dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>휴대폰 번호</dt>
                        <dd><em>010-4153-4545</em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>전화번호</dt>
                        <dd><em>02-4153-4545</em></dd>
                    </dl>
                </td>
            </tr>
            <tr>
                <td>
                    <dl>
                        <dt>배송요청사항</dt>
                        <dd></dd>
                    </dl>
                </td>
            </tr>
            </tbody>
        </table>
    </section>

    <!--교환일 때-->
    <section>
        <h1>변동내역</h1>
        <div class="change-list">
            <div class="first">
                <dl>
                    <dt>교환신청 상품 총 금액</dt>
                    <dd><em>18,000</em>원</dd>
                </dl>
                <dl>
                    <dt>교환 배송비</dt>
                    <dd><em>2,500</em>원</dd>
                </dl>
            </div>
            <div class="last">
                <dl>
                    <dt>추가 결제 예정 금액</dt>
                    <dd><em>2,500</em>원</dd>
                </dl>
            </div>
        </div>
        <div class="desc">
            교환 배송비는 판매자가 교환상품 최종 승인 후 변경될 수 있습니다.
        </div>
    </section>
    <!--//-->

    <!--반품일 떄 -->
    <section>
        <h1>환불내역</h1>
        <div class="refund-list">
            <div class="clearfix">
                <div class="col">
                    <div class="row-top">
                        <p class="tit">취소신청 상품 총 금액</p>
                        <p class="price"><em>34,300</em>원</p>
                    </div>
                    <div class="row-bottom">
                        <dl>
                            <dt>취소상품 총 금액</dt>
                            <dd><em>38,000</em>원</dd>
                        </dl>
                        <dl>
                            <dt>취소상품 총 배송비</dt>
                            <dd><em>0</em>원</dd>
                        </dl>
                        <dl>
                            <dt>취소상품 총 할인금액</dt>
                            <dd><em>-3,700</em>원</dd>
                        </dl>
                        <dl class="disc-list first">
                            <dt>즉시할인</dt>
                            <dd><em>1,000</em>원</dd>
                        </dl>
                        <dl class="disc-list">
                            <dt>기획할인</dt>
                            <dd><em>1,500</em>원</dd>
                        </dl>
                        <dl class="disc-list">
                            <dt>쿠폰할인</dt>
                            <dd><em>1,000</em>원</dd>
                        </dl>
                        <dl class="disc-list">
                            <dt>마일리지 사용</dt>
                            <dd><em>200</em>원</dd>
                        </dl>
                    </div>
                </div>
                <div class="col">
                    <div class="row-top">
                        <p class="tit">환불금액 차감내역</p>
                        <p class="price"><em>0</em>원</p>
                    </div>
                    <div class="row-bottom">
                        <dl>
                            <dt>주문취소 배송비</dt>
                            <dd><em>0</em>원</dd>
                        </dl>
                    </div>
                </div>
                <div class="col">
                    <div class="row-top">
                        <p class="tit">환불 예정 금액</p>
                        <p class="price fb__point-color"><em>34,300</em>원</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <dl>
                    <dt>결제수단(상품 구매 시)</dt>
                    <dd>가상계좌</dd>
                </dl>
                <dl>
                    <dt>환불수단</dt>
                    <dd>우리은행 / 100**********</dd>
                </dl>
            </div>
        </div>
        <div class="desc">
            결제수단 중 신용카드 및 실시간 계좌이체는 자동 환불 처리되며 기타 결제수단을 통해 결제하신 고객님은 환불계좌에 등록된 계좌로 송금 처리됩니다.<br>
            결제 시 사용한 쿠폰 및 마일리지는 내부정책에 따라 취소신청 완료 후 환불됩니다.
        </div>
    </section>
    <!--//-->

    <!--교환정보확인 E-->

    <section>
        <div class="wrap-btn-area">
            <button class="btn-lg btn-dark">이전</button>
            <button class="btn-lg fb__btn-point">다음</button>
        </div>
    </section>


    <!--교환신청 완료 S -->
    <div class="wrap-claim-complete">
        <h2>주문상품의 <span>교환신청이 완료</span>되었습니다.</h2>
        <p class="desc">교환처리 현황은 <span>마이페이지 <em></em> 취소/교환/반품 조회</span>에서 확인하실 수 있습니다.</p>
    </div>

    <section>
        <table class="table-default order-table claim-complete">
            <colgroup>
                <col width="*"/>
                <col width="100px"/>
                <col width="100px"/>
                <col width="100px"/>
            </colgroup>
            <thead>
            <th>상품명/옵션</th>
            <th>주문수량</th>
            <th>교환수량</th>
            <th>결제금액</th>
            </thead>
            <tbody>
            <tr>
                <td>
                    <a href="#">
                        <div class="thumb">
                            <img src="<?php echo $TPL_VAR["templet_src"]?>/img/sample/sample_90.jpg">
                        </div>
                        <div class="info">
                            <p class="title">[브랜드명] 우리지역 시금치 200g</p>
                            <p class="option">흙당근 10kg</p>
                        </div>
                    </a>
                </td>
                <td><em>3</em>개</td>
                <td><em>1</em>개</td>
                <td class="price"><em>19,000</em>원</td>
            </tr>
            </tbody>
        </table>
    </section>

    <section>
        <div class="wrap-btn-area">
            <button class="btn-lg fb__btn-point">확인</button>
        </div>
    </section>
    <!--교환신청 완료 E -->
</div>