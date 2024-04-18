"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
$(function () {
    $('.accordion-header').click(function () {
        // if ($(this).hasClass('on')) {
        //     $(this).nextAll().not('.more').slideDown();
        // } else {
        //     $(this).nextAll().slideUp();
        // };
        if ($(this).hasClass('on')) {
            $(this).siblings('.accordion-body').slideDown();
        }else {
            $(this).siblings('.accordion-body').slideUp();
        }
    });

    $('.order-list-more').click(function () {
        $(this).prev('.more').toggleClass('open');
        $(this).prev('.more').slideToggle();
    });

    $('.term-content').click(function () {

        var title = $("input[name='"+this.name+"']").attr('title');
        var id = $("input[name='"+this.name+"']").attr('name');
        $('.popup-mask').fadeIn(100);
        $('.popup-mask').fadeTo("fast",0.8);
        $("#agree_title").text(title);
        $(".pop-cont-detail").hide();
        $("#"+id).show();
        $('.terms-layer-pop').css('display', 'block');
        $('#mask').css('display', 'block');
    });

    $('.terms-layer-pop #close').click(function () {
        $('.popup-mask').hide();
        $('.terms-layer-pop').css('display', 'none');
        $('#mask').css('display', 'none');
    });
})

$(function () {
    relation_checkbox($('#all_terms_check'), $('.agree-content input[type=checkbox]'));
});

function relation_checkbox($all_checkbox, $target_checkbox) {
    $all_checkbox.click(function () {
        if ($all_checkbox.is(':checked')) {
            $target_checkbox.prop("checked", true);
        } else {
            $target_checkbox.prop("checked", false);
        }
    });

    $target_checkbox.click(function () {
        if ($target_checkbox.length == $target_checkbox.filter(':checked').length) {
            $all_checkbox.prop("checked", true);
        } else {
            $all_checkbox.prop("checked", false);
        }
    });
}


/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('infoinput.paymentRequest.validation.fail.terms', "필수 약관에 동의해 주세요.");//Alert_23
common.lang.load('infoinput.cancel', "주문을 취소하시겠습니까?{common.lineBreak}주문 취소 시 장바구니 페이지로 이동됩니다.");//Confirm_05
common.lang.load('infoinput.paymentRequest.fail.overUseMileage', "보유하고 계신 {mileage} {mileageName} 이하로만 사용 가능합니다.");//Alert_117
common.lang.load('infoinput.paymentRequest.fail.littleUserMinMileage', "보유 {mileageName}가 {mileage}{mileageUnit} 이상일 경우에만 사용 가능합니다.");//Alert_25
common.lang.load('infoinput.paymentRequest.fail.overUseMaxmileagePrice', "보유 {mileageName}는 최대 {mileage}{mileageUnit}까지 사용 가능합니다.");//Alert_26
common.lang.load('infoinput.paymentRequest.fail.overUseMaxmileageRate', "보유 {mileageName}는 주문 상품 합계의 {rate}%인 {mileage}{mileageUnit}만 사용 가능합니다.");//Alert_27
common.lang.load('infoinput.paymentRequest.fail.littleBuyAmt', "주문 상품 합계가 {price}원 이상일 경우에만 {mileageName}를 사용하실 수 있습니다.");//Alert_110
common.lang.load('infoinput.paymentRequest.fail.noFormatMileage', "{mileageName}는 {unit}원 단위로 입력해 주세요.");//Alert_118
common.lang.load('infoinput.paymentRequest.fail.noProductStatusSale', "현재 구매하실 수 없는 상품이 포함되어 있습니다.{common.lineBreak}장바구니에서 다시 주문 바랍니다.");
common.lang.load('infoinput.paymentRequest.noti.paymentFree', "총 결제금액이 0원이므로 무료결제로 자동 진행됩니다.");
common.lang.load('coupon.noApply.msg', "적용된 쿠폰이 없습니다.");
common.lang.load('infoinput.paymentRequest.fail.littleBuyAmt2', "총 상품금액이 3만원 이상일 때만 사용가능합니다.");
common.lang.load('infoinput.addressBook.fail.over', "최대 10개까지 등록 가능합니다.");
common.lang.load('infoinput.freeGiftPopup.title', "구매금액별 사은품 선택");
common.lang.load('infoinput.freeGiftSelect.fail', "선택가능한 사은품이 존재합니다. 사은품을 선택해 주세요.");
common.lang.load('gift.update.count.giftItemStockCheck.alert', "{pname} 사은품은 {count}개 까지 선택 가능합니다. 다시 선택 바랍니다.");
common.lang.load('infoinput.freeGiftSoldOut.alert', "사은품이 품절되었거나 선택가능한 사은품이 존재하지 않습니다.");
common.lang.load('infoinput.freeGiftChangePrice.alert', "결제금액이 변경되어 사은품이 지급되지 않습니다.");
common.lang.load('infoinput.freeGiftCheckFail.alert', "사은품 정보가 변경되어 다시 결제 해주세요");
common.lang.load('infoinput.freeGiftCntCheckFail.alert', "사은품 지급수량이 변경되어 다시 결제 해주세요.");
common.lang.load('infoinput.freeGiftCompareFail.alert', "결제금액이 변경되어 사은품을 다시 선택해주셔야 합니다.");
common.lang.load('delivery.noCoupon.alert', "할인을 적용할 배송비가 없습니다.");

common.lang.load('coupon.productOverlapUseYn.confirm', "해당 쿠폰 사용 시 상품쿠폰 적용이 불가능합니다. 적용하시겠습니까?");
//-----set input format
//주문자 정보
common.inputFormat.set($('#devBuyerName'), {'maxLength': 20});
common.inputFormat.set($('#devOrderPassword,#devOrderPasswordCompare'), {'maxLength': 20});
if(common.langType == 'korean') {
    common.inputFormat.set($('#devBuyerMobile2,#devBuyerMobile3'), {'number': true, 'maxLength': 4});
}
common.inputFormat.set($('#devBuyerTel2,#devBuyerTel3'), {'number': true, 'maxLength': 4});
if(common.langType == 'korean') {
    common.inputFormat.set($('.devDeliveryMessage'), {'maxLength': 30});
}else {
    common.inputFormat.set($('.devDeliveryMessage'), {'maxLength': 60});
}

common.inputFormat.set($('#devBuyUnderAge'), {'selected': true});

//배송지 정보
common.inputFormat.set($('.devRecipientName'), {'maxLength': 20});
if(common.langType == 'korean') {
    common.inputFormat.set($('.devRecipientMobile2,.devRecipientMobile3'), {'number': true, 'maxLength': 4});
}
common.inputFormat.set($('.devRecipientTel2,.devRecipientTel3'), {'number': true, 'maxLength': 4});
//마일리지
common.inputFormat.set($('#devUseMileage'), {'number': true});
//-----set validation
//주문자 정보
common.validation.set($('#devBuyerName'), {'required': true});
common.validation.set($('#devBuyerEmailId,#devBuyerEmailHost'), {'required': true, 'dataFormat': 'email', 'getValueFunction': 'devInfoinputObj.getBuyerEmail'});
common.validation.set($('#devBuyerMobile1,#devBuyerMobile2,#devBuyerMobile3'), {'required': true});
common.validation.set($('#devOrderPassword'), {'required': true, 'dataFormat': 'userPassword'});
common.validation.set($('#devOrderPasswordCompare'), {'required': true, 'compare': '#devOrderPassword'});

common.validation.set($('#devBuyUnderAge'), {'required': true});
//배송지 정보
common.validation.set($('.devRecipientName'), {'required': true});
common.validation.set($('.devRecipientZip,.devRecipientAddr1,.devRecipientAddr2'), {'required': true});
common.validation.set($('.devBuyerMobile1,.devRecipientMobile2,.devRecipientMobile3'), {'required': true});

//글로벌 전용 필수
if(common.langType =='english'){
    common.validation.set($('#devCountry'), {'required': true});
    common.validation.set($('#devCity'), {'required': true});
    common.validation.set($('#devStateText'), {'required': true});
}

//약관동의
common.validation.set($('.devTerms'), {'required': true, 'requiredMessageTag': 'infoinput.paymentRequest.validation.fail.terms'});

var devInfoinputObj = {
    //결제 구분
    paymentBool: false,
    //배송지 리스트
    orderAddressList: false,
    //배송지 데이터
    orderAddressListData: false,
    //배송지 등록 갯수
    addressBookCnt: 0,

    //주문자 이메일 정보
    getBuyerEmail: function () {
        return $('#devBuyerEmailId').val().trim() + '@' + $('#devBuyerEmailHost').val().trim();
    },
    //주문자 정보
    getBuyerData: function () {
        var self = this;
        var data = {};
        data.name = $('#devBuyerName').val().trim();
        data.email = self.getBuyerEmail();
        if(common.langType == 'korean') {
            data.mobile = $('#devBuyerMobile1').val().trim() + '-' + $('#devBuyerMobile2').val().trim() + '-' + $('#devBuyerMobile3').val().trim();
        }else{
            data.mobile = $('#devBuyerMobile1').val().trim() + '-' + $('#devBuyerMobile2').val().trim();
            data.nation = $('#devBuyerMobile1 option:selected').data('nation_code');
        }
        // data.tel = $('#devBuyerTel1').val().trim() + '-' + $('#devBuyerTel2').val().trim() + '-' + $('#devBuyerTel3').val().trim();
        data.password = ($('#devOrderPassword').length > 0 ? $('#devOrderPassword').val().trim() : '');
        return data;
    },
    //배송지 선택 타입
    recipientType: 'input', //input or address
    //set 배송지 입력 타입 validation
    setInputRecipientValidation: function () {
        var self = this;
        if (self.recipientType == 'address') {
            common.validation.set($('.devRecipientName'), {});
            common.validation.set($('.devRecipientZip,.devRecipientAddr1,.devRecipientAddr2'), {});
            common.validation.set($('.devBuyerMobile1,.devRecipientMobile2,.devRecipientMobile3'), {});
            if(common.langType =='english') {
                common.validation.set($('#devCity'), {});
                common.validation.set($('#devStateText'), {});
            }
		} else if (self.recipientType == 'addressOrder') {
            common.validation.set($('.devRecipientName'), {});
            common.validation.set($('.devRecipientZip,.devRecipientAddr1,.devRecipientAddr2'), {});
            common.validation.set($('.devBuyerMobile1,.devRecipientMobile2,.devRecipientMobile3'), {});
            if(common.langType =='english') {
                common.validation.set($('#devCity'), {});
                common.validation.set($('#devStateText'), {});
            }
        } else {
            common.validation.set($('.devRecipientName'), {'required': true});
            common.validation.set($('.devRecipientZip,.devRecipientAddr1,.devRecipientAddr2'), {'required': true});
            common.validation.set($('.devBuyerMobile1,.devRecipientMobile2,.devRecipientMobile3'), {'required': true});
            if(common.langType =='english') {
                common.validation.set($('#devCity'), {'required': true});
                common.validation.set($('#devStateText'), {'required': true});
            }
        }
    },
    getCouponInfoBySelect: function ($select) {
        var cartIx = $select.attr('devCouponSelect');
        var $checkedOption = $select.find('option:selected');
        var registIx = $checkedOption.val();
        var totalCouponWithDcprice = $checkedOption.attr('devTotalCouponWithDcprice');
        var discountAmount = $checkedOption.attr('devDiscountAmount');
        var cartOverlapUseYn = $checkedOption.attr('devCartOverlapUseYn');
        var paymentMethod = $checkedOption.attr('devPaymentMethod');
        return {
            cartIx: cartIx,
            registIx: registIx,
            totalCouponWithDcprice: totalCouponWithDcprice,
            discountAmount: discountAmount,
            cartOverlapUseYn: cartOverlapUseYn,
            paymentMethod: paymentMethod
        }
    },
    getCartCouponInfoBySelect: function () {
        var $checkedOption = $('select[devCartCouponSelect]').find('option:selected');
        var registIx = $checkedOption.val();
        var totalCouponWithDcprice = $checkedOption.attr('devTotalCouponWithDcprice');
        var discountAmount = $checkedOption.attr('devDiscountAmount');
        var productOverlapUseYn = $checkedOption.attr('devProductOverlapUseYn');
        var paymentMethod = $checkedOption.attr('devPaymentMethod');
        return {
            cartIx: 'cartCoupon',
            registIx: registIx,
            totalCouponWithDcprice: totalCouponWithDcprice,
            discountAmount: discountAmount,
            productOverlapUseYn: productOverlapUseYn,
            paymentMethod: paymentMethod
        }
    },
    //배송지별 상품 정보 (복수 배송지 관련 고려)
    getRecipientListData: function () {
        var self = this;
        var datas = [];

        //배송지 선택
        var $targetConTents;
        if (forbizCsrf.isLogin) {
            if (self.recipientType == 'address') {
                var $checkAddress = $('.devRecipientContents:eq(0) .devOrderAddressRadio:checked');
                var index = $checkAddress.val();
                $targetConTents = $checkAddress.closest('.devRecipientContents');
			/*} else if (self.recipientType == 'addressOrder') {
                var $checkAddress = $('.devRecipientContents:eq(1) .devOrderAddressOrderRadio:checked');
                var index = $checkAddress.val();
                $targetConTents = $checkAddress.closest('.devRecipientContents');*/
            } else {
                $targetConTents = $('.devRecipientContents:eq(1)');
            }
        } else {
            $targetConTents = $('.devRecipientContents');
        }

        $targetConTents.each(function () {
            var data = {};
            //배송지 선택
            if (self.recipientType == 'address') {
                var addressData = self.orderAddressListData[index];
                data.name = addressData.recipient;
                data.zip = addressData.zipcode;
                data.addr1 = addressData.address1;
                data.addr2 = addressData.address2;
                data.mobile = addressData.mobile;
                data.tel = addressData.tel;
                data.addAddressBookYn = 'N';
                data.baiscAddressBookYn = 'N';

                data.country = addressData.country;
                data.city = addressData.city;
                data.state = addressData.state;
			/*} else if (self.recipientType == 'addressOrder') {
                var addressOrderData = self.orderAddressListOrderData[index];
                data.name = addressOrderData.recipient;
                data.zip = addressOrderData.zipcode;
                data.addr1 = addressOrderData.address1;
                data.addr2 = addressOrderData.address2;
                data.mobile = addressOrderData.mobile;
                data.tel = addressOrderData.tel;
                data.addAddressBookYn = 'N';
                data.baiscAddressBookYn = 'N';


                data.country = addressOrderData.country;
                data.city = addressOrderData.city;
                data.state = addressOrderData.state;*/
            } else {
                data.name = $(this).find('.devRecipientName').val().trim();
                data.zip = $(this).find('.devRecipientZip').val().trim();
                data.addr1 = $(this).find('.devRecipientAddr1').val().trim();
                data.addr2 = $(this).find('.devRecipientAddr2').val().trim();
                if(common.langType == 'korean') {
                    data.mobile = $(this).find('.devRecipientMobile1').val().trim() + '-' + $(this).find('.devRecipientMobile2').val().trim() + '-' + $(this).find('.devRecipientMobile3').val().trim();
                }else{
                    data.mobile = $(this).find('.devRecipientMobile1').val().trim() + '-' + $(this).find('.devRecipientMobile2').val().trim();

                    data.country = $(this).find('#devCountry').val();
                    data.city = $(this).find('#devCity').val();
                    data.state = $(this).find('#devStateText').val();
                }
                //data.tel = $(this).find('.devRecipientTel1').val().trim() + '-' + $(this).find('.devRecipientTel2').val().trim() + '-' + $(this).find('.devRecipientTel3').val().trim();
                data.addAddressBookYn = ($(this).find('#devAddAddressBookCheckBox:checked').length > 0 ? 'Y' : 'N');
                data.baiscAddressBookYn = ($(this).find('#devBasicAddressBookCheckBox:checked').length > 0 ? 'Y' : 'N');
            }

            data.msg_type = ($('.devDeliveryMessageIndividualCheckBox:checked').length > 0 ? 'P' : 'D'); //배송요청사항 타입(D: 배송지별 입력, P: 상품 개별입력)
            if (data.msg_type == 'P') {
                data.msg = '';
                data.product_msg = [];
                $('.devEachDeliveryMessageContents').each(function () {
                    var cart_ix = $(this).attr('devCartIx').trim();
                    var msg = $(this).find('.devDeliveryMessage').val().trim();
                    data.product_msg.push({cart_ix: cart_ix, msg: msg});
                });
            } else {
                if(common.langType=='korean'){
                    data.msg = $.trim($('.devDeliveryMessageContents .devDeliveryMessage').val());
                }else{
                    if (self.recipientType == 'address') {
                        data.msg = $.trim($('.devDeliveryMessageContents .devDeliveryMessage').val());
                    }else{
                        data.msg = $.trim($('.devDeliveryMessageContentsNew .devDeliveryMessage').val());
                    }
                }

                data.product_msg = [];
            }

            //우선 모든 상품은 하나의 배송지로 개발 처리
            data.cart_ix = self.getCartIx();
            datas.push(data);
        });
        return datas;
    },
    getCartIx: function () {
        var cartIx = common.util.getParameterByName('cartIx');
        return cartIx.split(',');
    },
    //사용 쿠폰 데이터
    useCouponData: false,
    setUseCouponData: function (data) {
        var self = this;
        self.useCouponData = data;


        self.setInputMileage(0);
        $('#devAllUseMileageCheckBox').prop('checked', false);

        self.changeOrderData();
        // 쿠폰 사용 개수 text 초기화 추가
        $("#devUseCouponCntView").text(0);
    },
    useDeliveryCouponData: false,
    setUseDeliveryCouponData: function (data) {
        var self = this;
        self.useDeliveryCouponData = data;
        $('#devAllUseMileageCheckBox').prop('checked', false);
        self.changeOrderData();

    },
    //summary data
    summaryData: false,
    //change order Data
    changeOrderData: function () {
        var self = this;
        var requestData = {};
        requestData.recipientList = self.getRecipientListData();
        requestData.coupon = self.useCouponData;
        requestData.deliveryCoupon = self.useDeliveryCouponData;
        requestData.payment = self.getPaymentData();
        common.ajax(common.util.getControllerUrl('getChangeOrderData', 'order'), requestData, (function () {
        }), (function (response) {
            if (response.result == 'success') {
                self.summaryData = response.data;
                self.changeOrderPrice();
            } else {
                common.noti.alert('error_m1');
            }
        }));
    },
    //금액 변경
    changeOrderPrice: function () {
        var self = this;
        $('[devPrice]').each(function () {
            var type = $(this).attr('devPrice');
            var price;
            if (type == 'use_cupon') { //쿠폰은 별도 처리
                var couponInfo = false;
                $.each(self.summaryData['productDiscountList'], function (i, data) {
                    if (data['type'] == 'CP') {
                        couponInfo = data;
                        return false;
                    }
                });
                if (couponInfo !== false) {
                    price = couponInfo.discount_amount;
                    $('#devUseCouponInputText').val(price);
                } else {
                    $('#devUseCouponInputText').val(0);
                }
            } else if(type == 'use_delivery_cupon'){ //배송비쿠폰
                var deliveryCouponInfo = false;
                $.each(self.summaryData['deliveryDiscountList'], function (i, data) {
                    if (data['type'] == 'DCP') {
                        deliveryCouponInfo = data;
                        return false;
                    }
                });
                if (deliveryCouponInfo !== false) {
                    price = deliveryCouponInfo.discount_amount;
                    $('#devUseDeliveryCouponInputText').val(price);
                } else {
                    $('#devUseDeliveryCouponInputText').val(0);
                }
            } else {
                price = self.summaryData[type];
            }
            if(type == "delivery_add_price"){
                if(price > 0){
                    $('[devPrice=' + type + ']').text(' + ' + common.util.numberFormat(price) + '원(도서산간)');
                }
            }else{
                $('[devPrice=' + type + ']').text(common.util.numberFormat(price));
            }
        });

        self.giftCheck(self.getCartIx(),'check');
    },
    //get 최대 입력할수 있는 마일리지
    getMaxMileage: function () {
        var couponInputVal = 0;
        if ($('#devUseCouponInputText').length > 0 && $('#devUseCouponInputText').val().length > 0) {
            couponInputVal = parseFloat($('#devUseCouponInputText').val());
        }

        var mileageTargetPrice = parseFloat($('#devAllUseMileageCheckBox').attr('devMileageTargetPrice'));
        mileageTargetPrice = common.math.sub(mileageTargetPrice, couponInputVal);

        var allUseMileage = parseFloat($('#devAllUseMileageCheckBox').attr('devAllUseMileage'));

        if (mileageTargetPrice < allUseMileage) {
            return mileageTargetPrice;
        } else {
            return allUseMileage;
        }
    },
    //get 입력 마일리지
    getInputMileage: function () {
        var $useMileage = $('#devUseMileage');
        if ($useMileage.length > 0 && $useMileage.val().length > 0) {
            return parseFloat($useMileage.val());
        } else {
            return 0;
        }
    },
    //set 입력 마일리지
    setInputMileage: function (val) {
        $('#devUseMileage').val(val);
        //$('#devUseMileageView').html(val);
    },
    //결제 정보
    getPaymentData: function () {
        var self = this;
        var data = {};
        data.method = $('.info-paytype__btn--active[devPaymentMethod]').attr('devPaymentMethod');
        data.mileage = self.getInputMileage();
        return data;
    },
    //무료결제
    paymentFree: function () {
        var self = this;
        var requestData = {};
        common.ajax(common.util.getControllerUrl('paymentFree', 'order'), requestData, '', (function (response) {
            if (response.result == 'success') {
                location.href = '/shop/paymentComplete';
            } else if (response.result == 'noSettleReady') {
                self.paymentBool = false;
                common.noti.alert('error_m2');
            } else {
                self.paymentBool = false;
                common.noti.alert('error_m3');
            }
        }));
    },
    //무통장 입금 결제
    paymentBank: function () {
        var self = this;
        var requestData = {};
        common.ajax(common.util.getControllerUrl('paymentBank', 'order'), requestData, '', (function (response) {
            if (response.result == 'success') {
                location.href = '/shop/paymentComplete';
            } else if (response.result == 'noSettleReady') {
                self.paymentBool = false;
                common.noti.alert('error_m4');
            } else {
                self.paymentBool = false;
                common.noti.alert('error_m5');
            }
        }));
    },
    //PG 결제
    paymentGateway: function (data) {
        var self = this;
        var requestData = {};
        requestData.agentType = 'M'; //M:모바일,A:APP
        requestData.method = data.payment.method;
        common.ajax(common.util.getControllerUrl('paymentGateway', 'order'), requestData, '', (function (response) {
            if (response.result == 'success') {
                //금액 조건 처리해야함
                $('#devPaymentGatewayContents').empty();
                $('#devPaymentGatewayContents').append(response.data.html);
                paymentGateway.request();
            } else if (response.result == 'noSettleReady') {
                common.noti.alert('error_m6');
            } else {
                common.noti.alert('error_m7');
            }
            self.paymentBool = false;
        }));
    },
    //공통
    commonRun: function () {
        var self = this;
        //배송 요청사항 selectBox 변경
        $(document).on('change', '.devDeliveryMessageSelectBox', function () {
            var $deliveryMessageContents = $(this).closest('.devDeliveryMessageContents,.devEachDeliveryMessageContents');
            var $deliveryMessageDirectContents = $deliveryMessageContents.find('.devDeliveryMessageDirectContents');
            var $deliveryMessage = $deliveryMessageContents.find('.devDeliveryMessage');
            var message = $(this).val();
            $deliveryMessage.val('');
            if (message == 'direct') {
                $deliveryMessageDirectContents.show();
            } else {
                $deliveryMessageDirectContents.hide();
                $deliveryMessage.val(message);
            }
            //배송 메세지 길이 이벤트 실행
            $deliveryMessage.trigger('input');
        });

        //배송 메세지 길이 체크
        $('.devDeliveryMessage').on('input', function () {
            if(common.lengType == 'korean') {
                var $deliveryMessageContents = $(this).closest('.devDeliveryMessageContents,.devEachDeliveryMessageContents');
                var devMaxLength = $(this).attr('devMaxLength');
                devMaxLength = (!common.util.isNull(devMaxLength) ? parseInt(devMaxLength) : 0);
                var length = $(this).val().length;
                if (devMaxLength > 0 && devMaxLength < $(this).val().length) {
                    length = devMaxLength;
                }
                $deliveryMessageContents.find('.devDeliveryMessageByte').text(length);
            }else {
                var $this = $(this);
                var _maxByte = $this.attr('devMaxLength'); //최대 입력 바이트 수
                var _text = $this.val();
                var _length = _text.length;
                var _totalByte = 0;
                var _checkLength = 0;
                var _char = "";
                var _valueText = "";


                for (var i = 0; i < _length; i++) {
                    _char = _text.charAt(i);

                    if (escape(_char).length > 4) {
                        _totalByte += 2; //한글2Byte
                    } else {
                        _totalByte++; //영문 등 나머지 1Byte
                    }

                    if (_totalByte <= _maxByte) {
                        _checkLength = i + 1; //return할 문자열 갯수
                    }
                }

                if (_totalByte > _maxByte) {
                    _valueText = _text.substr(0, _checkLength); //문자열 자르기
                    $this.val(_valueText);
                    _totalByte = _maxByte;
                }
                $(this).closest('.devDeliveryMessageContents,.devEachDeliveryMessageContents').find('.devDeliveryMessageByte').text(_totalByte);

            }
        });

        //배송 메세지 개별 입력
        $('.devDeliveryMessageIndividualCheckBox').click(function () {
            if ($(this).is(':checked')) {
                $('.devDeliveryMessageContents').hide();
                $('.devEachDeliveryMessageContents').show();
            } else {
                $('.devDeliveryMessageContents').show();
                $('.devEachDeliveryMessageContents').hide();
            }
        });
        //배송 주소 찾기
        $('.devRecipientZipPopupButton').click(function (e) {
            e.preventDefault();
            var $recipientZip = $(this).closest('.devRecipientContents').find('.devRecipientZip');
            var $recipientAddr1 = $(this).closest('.devRecipientContents').find('.devRecipientAddr1');
            common.util.zipcode.popup(function (response) {
                $recipientZip.val(response.zipcode);
                $recipientAddr1.val(response.address1);
                self.changeOrderData();
            });
        });
        if(common.langType=='english'){
            self.changeOrderData();
        }
        //결제 수단 변경
        $('[devPaymentMethod]').click(function (e) {
            $('[devPaymentDescription]:visible').hide();
            $('[devPaymentDescription=' + $(this).attr('devPaymentMethod') + ']').show();
        });

		$('.devTerms').click(function (e) {
			//self.changeOrderData();
		});

        $('#area-terms-All').click(function (e) {
            var checked1 = $('#area-terms-1').is(':checked');
            $('#area-terms-1').prop('checked',!checked1);

            var checked2 = $('#area-terms-2').is(':checked');
            $('#area-terms-2').prop('checked',!checked2);
        });

        //구매하기
        $('#devPaymentButton').click(function () {

            /*if($('#giftNoCheckbox').val() == "Y"){
                if(!$('#giftCheckbox').is(':checked') && !$('#giftNoCheckbox').is(':checked')){
                    alert("구매 금액별 사은품을 선택하세요.");
                    return false;
                }
            }*/

            if($('#freeGiftG').val() == "Y" && $('#G_giftUseYN').val() == "Y"){
                if(!$('input:radio[name=G_giftCheck]').is(':checked')){
                    alert("구매 금액별 사은품을 선택하세요.");
                    return false;
                }
            }

            if($('#freeGiftC').val() == "Y" && $('#C_giftUseYN').val() == "Y"){
                if(!$('input:radio[name=C_giftCheck]').is(':checked')){
                    alert("특정 카테고리 사은품을 선택하세요.");
                    return false;
                }
            }

            if($('#freeGiftP').val() == "Y" && $('#P_giftUseYN').val() == "Y"){
                if(!$('input:radio[name=P_giftCheck]').is(':checked')){
                    alert("이벤트 제품 구매시 금액별 사은품을 선택하세요.");
                    return false;
                }
            }

            if($('input[id="devBuyUnderAge"]:checked').val() == "N"){
                alert("만 14세미만은 상품구입이 불가능 합니다.");
                return false;
            }

            if(!$('#all_terms_check').is(':checked')){
                alert("필수 약관에 동의해 주세요.");
                return false;
            }

            if (!common.validation.check($('#devPaymentContents'), 'alert', false)) {
                return false;
            }

            var requestData = {};
            requestData.buyer = self.getBuyerData();
            requestData.recipientList = self.getRecipientListData();
            requestData.coupon = self.useCouponData;
            requestData.deliveryCoupon = self.useDeliveryCouponData;
            requestData.payment = self.getPaymentData();

            //사은품 증정
            var giftOrderData = [];
            var giftSelect = false;
            var giftSelectC = false;
            var giftSelectP = false;

            if($('#G_giftUseYN').val() == "Y"){
                var gPid = $("input[name='G_giftCheck']:checked").val();
                var condition = gPid.split('_');
                var giftPid = $('#G_devpid_'+condition[0]).val();
                var giftCount = $('#G_devpcount_'+condition[0]).val();
                var fgIx = $('#G_fg_ix_'+condition[0]).val();
                var freegift_condition = $('#G_freegift_condition_'+condition[0]).val();
                switch(freegift_condition){
                    case 'G':
                        giftSelect = true;
                        break;
                    case 'C':
                        giftSelectC = true;
                        break;
                    case 'P':
                        giftSelectP = true;
                        break;
                }
                //if(fgIx && freegift_condition){
                giftOrderData.push({giftPid:giftPid,giftCount:giftCount,fgIx:fgIx,freegift_condition:freegift_condition});
                /*}else{
                    giftOrderData.push({giftPid:giftPid,giftCount:giftCount,fgIx:fgIx});
                }*/
            }

            if($('#C_giftUseYN').val() == "Y"){
                var gPid = $("input[name='G_giftCheck']:checked").val();
                var condition = gPid.split('_');
                var giftPid = $('#C_devpid_'+condition[0]).val();
                var giftCount = $('#C_devpcount_'+condition[0]).val();
                var fgIx = $('#C_fg_ix_'+condition[0]).val();
                var freegift_condition = $('#C_freegift_condition_'+condition[0]).val();
                switch(freegift_condition){
                    case 'G':
                        giftSelect = true;
                        break;
                    case 'C':
                        giftSelectC = true;
                        break;
                    case 'P':
                        giftSelectP = true;
                        break;
                }
                //if(fgIx && freegift_condition){
                giftOrderData.push({giftPid:giftPid,giftCount:giftCount,fgIx:fgIx,freegift_condition:freegift_condition});
                /*}else{
                    giftOrderData.push({giftPid:giftPid,giftCount:giftCount,fgIx:fgIx});
                }*/
            }

            if($('#P_giftUseYN').val() == "Y"){
                var gPid = $("input[name='P_giftCheck']:checked").val();
                var condition = gPid.split('_');
                var giftPid = $('#P_devpid_'+condition[0]).val();
                var giftCount = $('#P_devpcount_'+condition[0]).val();
                var fgIx = $('#P_fg_ix_'+condition[0]).val();
                var freegift_condition = $('#P_freegift_condition_'+condition[0]).val();
                switch(freegift_condition){
                    case 'G':
                        giftSelect = true;
                        break;
                    case 'C':
                        giftSelectC = true;
                        break;
                    case 'P':
                        giftSelectP = true;
                        break;
                }
                //if(fgIx && freegift_condition){
                giftOrderData.push({giftPid:giftPid,giftCount:giftCount,fgIx:fgIx,freegift_condition:freegift_condition});
                /*}else{
                    giftOrderData.push({giftPid:giftPid,giftCount:giftCount,fgIx:fgIx});
                }*/
            }

            //if($('#giftNoCheckbox').is(':checked')){
            if(false){
                /*var giftPid = "";
                var giftCount = "";
                var fgIx = "";
                var freegift_condition = "G";
                switch(freegift_condition){
                    case 'G':
                        giftSelect = true;
                        break;
                    case 'C':
                        giftSelectC = true;
                        break;
                    case 'P':
                        giftSelectP = true;
                        break;
                }
                if(fgIx && freegift_condition){
                    alert("A");
                    giftOrderData.push({giftPid:giftPid,giftCount:giftCount,fgIx:fgIx,freegift_condition:freegift_condition});
                }else{
                    alert("B");
                    giftOrderData.push({giftPid:giftPid,giftCount:giftCount,fgIx:fgIx});
                }*/
            //}else{
                //장바구니 사은품 중복 노출 작업시 체크해야함
                if($('#giftNoCheckbox').val() == "Y"){
                    $(".devGiftListByOrder").find('img').each(function () {
                        var giftPid = $(this).data('devpid');
                        var giftCount = $(this).data('devpcount');
                        var fgIx = $(this).data('fg_ix');
                        var freegift_condition = $(this).data('freegift_condition');
                        switch(freegift_condition){
                            case 'G':
                                giftSelect = true;
                                break;
                            case 'C':
                                giftSelectC = true;
                                break;
                            case 'P':
                                giftSelectP = true;
                                break;
                        }
                        if(fgIx && freegift_condition){
                            giftOrderData.push({giftPid:giftPid,giftCount:giftCount,fgIx:fgIx,freegift_condition:freegift_condition});
                        }else{
                            giftOrderData.push({giftPid:giftPid,giftCount:giftCount,fgIx:fgIx});
                        }
                    });
                }

                //사은품 필수 선택 처리 [S]
                var giftRequiredBool = true;
                $('.devOrderGiftArea:visible').each(function(){
                    if($(this).find('.devOrderGiftList').children().length == 0){
                        giftRequiredBool = false;
                    }
                });
                if(giftRequiredBool === false){
                    common.noti.alert(common.lang.get('infoinput.freeGiftSelect.fail'));
                    return false;
                }
            }

            //사은품 필수 선택 처리 [E]
            /*
            if($('.devOrderGiftArea:visible').length > 0 && $('.devOrderGiftArea').css('display') != 'none' && (giftOrderData.length == 0 || ($('.devOrderGiftArea:visible').length != giftOrderData.length))){
                common.noti.alert(common.lang.get('infoinput.freeGiftSelect.fail'));
                return false;
            }
            */

            if(giftOrderData.length > 0){
                requestData.freeGiftOrder = giftOrderData;
            }
            requestData.giftSelect = giftSelect;
            requestData.giftSelectC = giftSelectC;
            requestData.giftSelectP = giftSelectP;

            if (!self.paymentBool) {
                common.ajax(common.util.getControllerUrl('paymentRequest', 'order'), requestData, (function () {
                    self.paymentBool = true;
                }), (function (response) {
                    if (response.result == 'success') {
                        //금액 비교
                        console.log(self.summaryData.payment_price + " // " + response.data.payment.payment_price)
                        if (self.summaryData.payment_price == response.data.payment.payment_price) {
                            if (response.data.payment.method == "8") {//무료결제
                                common.noti.alert(common.lang.get('infoinput.paymentRequest.noti.paymentFree'), function () {
                                    self.paymentFree();
                                });
                            } else if (response.data.payment.method == "0") { //무통장 입금
                                self.paymentBank();
                            } else {
                                self.paymentGateway(response.data);
                            }
                        } else {
                            self.paymentBool = false;
                            common.noti.alert('error_m8');
                        }
                    } else {
                        self.paymentBool = false;
                        if (response.result == 'overUseMileage') {
                            common.noti.alert(common.lang.get('infoinput.paymentRequest.fail.overUseMileage', response.data));
                        } else if (response.result == 'littleUserMinMileage') {
                            common.noti.alert(common.lang.get('infoinput.paymentRequest.fail.littleUserMinMileage', response.data));
                        } else if (response.result == 'overUseMaxmileagePrice') {
                            common.noti.alert(common.lang.get('infoinput.paymentRequest.fail.overUseMaxmileagePrice', response.data));
                        } else if (response.result == 'overUseMaxmileageRate') {
                            common.noti.alert(common.lang.get('infoinput.paymentRequest.fail.overUseMaxmileageRate', response.data));
                        } else if (response.result == 'littleBuyAmt') {
                            common.noti.alert(common.lang.get('infoinput.paymentRequest.fail.littleBuyAmt', response.data));
                            self.setInputMileage(0);
                            self.changeOrderData();
                        } else if (response.result == 'noFormatMileage') {
                            common.noti.alert(common.lang.get('infoinput.paymentRequest.fail.noFormatMileage', response.data));
                        } else if (response.result == 'noProductStatusSale') {
                            common.noti.alert(common.lang.get('infoinput.paymentRequest.fail.noProductStatusSale'), function () {
                                location.href = '/shop/cart';
                            });
                        }else if(response.result == 'selectGiftOrder'){
                            common.noti.alert(common.lang.get('infoinput.freeGiftSelect.fail'));
                        } else if(response.result == 'giftItemStockFail'){
                            common.noti.alert(common.lang.get('gift.update.count.giftItemStockCheck.alert', {count: response.data.stock, pname: response.data.pname}));
                            //$('#devOrderGiftList').empty();
                            $('.devOrderGiftList').empty();
                            $('.devOrderGift').hide();
                        }else if(response.result == 'giftItemSoldOutFail'){
                            common.noti.alert(common.lang.get('infoinput.freeGiftSoldOut.alert'));
                            //$('#devOrderGiftList').empty();
                            $('.devOrderGiftList').empty();
                            $('.devOrderGift').hide();
                        }else if(response.result == 'giftCheckFail'){
                            common.noti.alert(common.lang.get('infoinput.freeGiftCheckFail.alert'));
                            // $('#devOrderGiftList').empty();
                        }else if(response.result == 'giftCompareFail'){
                            common.noti.alert(common.lang.get('infoinput.freeGiftCompareFail.alert'));
                        }else if(response.result == 'giftCntCheckFail'){
                            common.noti.alert(common.lang.get('infoinput.freeGiftCntCheckFail.alert'))
                            $('.devOrderGift_'+response.data.freegift_condition).hide();
                            $('#devOrderGiftList_'+response.data.freegift_condition).empty();
                        }else {
                            //common.noti.alert('error');
							common.noti.alert('등록된 배송지 정보가 없습니다.');
                        }
                    }
                }));
            }
        });
        //취소하기
        $('#devPaymentCancelButton').click(function () {
            common.noti.confirm(common.lang.get('infoinput.cancel'), function () {
                location.href = '/shop/cart';
            });
        });

        $('.devGiftBox').on('click',function(){
            var freeGiftCondition = $(this).data('freegift_condition');
            var freeGiftConditionText = $(this).data('freegift_condition_text');
            self.giftCheck(self.getCartIx(),'submit',freeGiftCondition,freeGiftConditionText);
        });

        $('#devStateSelect').on('change',function(){
            $('#devStateText').val($(this).val());
        });

        $('.devNationArea').on('change',function(){
            var country = $(this).children("option:selected").data('nation_code');

            $('.devNationArea').find('[data-nation_code='+country+']').prop('selected','selected');

            if(country == 'US'){
                $('#devStateSelect option:eq(0)').prop('selected', true);
                $('#devStateSelect').show();
                $('#devStateText').hide();
            }else{
                $('#devStateText').val('');
                $('#devStateText').show();
                $('#devStateSelect').hide();
            }

        });

        // *** 이메일 서버 선택
        $('#devEmailHostSelect').change(function (e) {
            var selectValue = $(this).val();
            var $emailHost = $('#devBuyerEmailHost');
            $emailHost.val(selectValue);
            if (selectValue != '') {
                $emailHost.attr('readonly', true);
            } else {
                $emailHost.attr('readonly', false);
            }
        });

        //쿠폰 적용
        $('#devApplyCouponButton').click(function () {
            var useData = {};

            $('select[devCouponSelect]').each(function () {
                var data = self.getCouponInfoBySelect($(this));
                if (data.registIx) {
                    useData[data.cartIx.replace(/,/gi, "|")] = data.registIx;
                }

            });


            if ($('select[devCartCouponSelect]').val()) {
                useData["cart"] = $('select[devCartCouponSelect]').val();
            }

            devInfoinputObj.setUseCouponData(useData);

            //결제 수단 수정
            if (self.selectPaymentMethod != '') {
                $('.devPayTypeArea button').hide();
                $.each(self.selectPaymentMethod.split('|'), function (key, method) {
                    $('.devPayTypeArea button[devPaymentMethod=' + method + ']').show();
                });
                $('button[name=devPaymentMethod]:not(:hidden):eq(0)').trigger('click');
            } else {
                $('.devPayTypeArea button').show();
            }

            $('#devUseCouponCntView').html($(useData).length);
            $('#devCouponCancelButton').trigger('click');
        });


    },

    giftCheck:function(getCartIx,type,freeGiftCondition,freeGiftConditionText){
        if($('.devOrderGiftArea').length > 0) {
            var saleCouponPrice = 0;
            var useMileage = 0;
            if ($('#devUseCouponInputText').length > 0) {
                saleCouponPrice = $('#devUseCouponInputText').val();

                if (saleCouponPrice == '') {
                    saleCouponPrice = 0;
                }
            }

            if ($('#devUseMileage').length > 0) {
                useMileage = $('#devUseMileage').val();
                if (useMileage == '') {
                    useMileage = 0;
                }
            }

            /**
             * 사은품 선택 정보 보내서 선택된 사은품과 현재 금액대별 사은품의 정보가 일치하는지 확인하기 위한 데이터
             */
            var giftOrderData = [];
            var giftSelect = false;
            var giftSelectC = false;
            var giftSelectP = false;
            $(".devGiftListByOrder").find('img').each(function () {
                var giftPid = $(this).data('devpid');
                var giftCount = $(this).data('devpcount');
                var fgIx = $(this).data('fg_ix');
                var freegift_condition = $(this).data('freegift_condition');
                switch(freegift_condition){
                    case 'G':
                        giftSelect = true;
                        break;
                    case 'C':
                        giftSelectC = true;
                        break;
                    case 'P':
                        giftSelectP = true;
                        break;
                }
                if(fgIx && freegift_condition){
                    giftOrderData.push({giftPid:giftPid,giftCount:giftCount,fgIx:fgIx,freegift_condition:freegift_condition});
                }else{
                    giftOrderData.push({giftPid:giftPid,giftCount:giftCount,fgIx:fgIx});
                }
            });

            common.ajax(
                common.util.getControllerUrl('searchFreeGift', 'product'),
                {
                    cartIx: getCartIx,
                    saleCouponPrice: saleCouponPrice,
                    useMileage: useMileage,
                    giftOrderData: giftOrderData,
                    giftSelect: giftSelect,
                    giftSelectC: giftSelectC,
                    giftSelectP: giftSelectP
                },
                '',
                function (response) {
                    if (response.result == 'success') {
                        var data = response.data;
                        var msg = '';
                        //$('.devOrderGiftArea').hide();
                        /*var viewConditionCheck = true;
                        $('.devOrderGiftArea').each(function(){
                            var viewCondition = $(this).data('freegift_condition');
                            if(data.hasOwnProperty(viewCondition) == false){
                                $(this).hide();
                                if (type == 'submit') {
                                    viewConditionCheck = false;
                                }
                            }
                        });
                        if(viewConditionCheck == false){
                            common.noti.alert(common.lang.get('infoinput.freeGiftCheckFail.alert'));
                            return false;
                        }*/
                        $.each(data, function(key, value) {
                            if(value.result == 'success'){
                                $("#"+key+"_giftUseYN").val("Y");

                                $('.devOrderGiftArea_'+key).css("display","block");

                                const bgPid = value.giftPid;
                                const gPid = value.pid;
                                const fgIx = value.fgIx;

                                for (i = 0; i < gPid.length; i++) {
                                    $('#devOrderGiftList_'+gPid[i]+'_'+fgIx[i]+'_'+key).css('display', 'block');
                                }

                                $("input:radio[name='"+key+"_giftCheck']").prop('checked', false);

                                //장바구니 사은품 중복 노출 작업시 체크해야함
                                //$('.devOrderGiftArea_'+key).show();
                                /*$('.devOrderGiftArea_'+key).css("display","block");
                                $("#giftNoCheckbox").val("Y");*/
                                // //장바구니 사은품 중복 노출 작업시 체크해야함

                                /*if (type == 'submit') {
                                    common.util.modal.open('ajax', freeGiftConditionText, '/popup/freebieSelect?cartIx=' + getCartIx + '&saleCouponPrice=' + parseInt(saleCouponPrice) + '&useMileage=' + parseInt(useMileage)+ '&freeGiftCondition=' + freeGiftCondition, window.popupLayerFullSize)
                                }*/
                            }else if (value.result == 'changePrice') {
                                //alert($('.devOrderGiftArea_'+key).css('display'))
                                if ($('.devOrderGiftArea_'+key).css('display') != 'none' && typeof $('.devOrderGiftArea_'+key).css('display') != "undefined") {
                                    //common.noti.alert(common.lang.get('infoinput.freeGiftChangePrice.alert'));
                                    msg = common.lang.get('infoinput.freeGiftChangePrice.alert');

                                    $('.devOrderGiftArea_'+key).css("display","none");
                                    $("#"+key+"_giftUseYN").val("N");
                                    $("input:radio[name='"+key+"_giftCheck']").prop('checked', false);

                                    //장바구니 사은품 중복 노출 작업시 체크해야함
                                    /*$('.devOrderGiftArea_'+key).hide();
                                    $('.devOrderGift_'+key).hide();
                                    $('#devOrderGiftList_'+key).empty();*/
                                    //$('.devOrderGiftArea_'+key).css("display","none");
                                    //$("#giftNoCheckbox").val("N");
                                    // //장바구니 사은품 중복 노출 작업시 체크해야함
                                }
                                // return false;
                            } else if (value.result == 'giftCompareFail'){
                                // common.noti.alert(common.lang.get('infoinput.freeGiftCompareFail.alert'));

                                $("#"+key+"_giftUseYN").val("Y");

                                const bgPid = value.giftPid;
                                const fgIx = value.fgIx;
                                for (i = 0; i < bgPid.length; i++) {
                                    $('#devOrderGiftList_'+bgPid[i]+'_'+fgIx[i]+'_'+key).css('display', 'none');
                                }

                                msg = common.lang.get('infoinput.freeGiftCompareFail.alert');

                                const gPid = value.pid;
                                const eFgIx = value.eFgIx;

                                for (i = 0; i < gPid.length; i++) {
                                    $('#devOrderGiftList_'+gPid[i]+'_'+eFgIx[i]+'_'+key).css('display', 'block');
                                }

                                $("input:radio[name='"+key+"_giftCheck']").prop('checked', false);

                                //장바구니 사은품 중복 노출 작업시 체크해야함
                                /*$('.devOrderGift_'+key).hide();
                                $('#devOrderGiftList_'+key).empty();*/
                                //$('.devOrderGiftArea_'+key).css("display","none");
                                //$("#giftNoCheckbox").val("N");
                                // //장바구니 사은품 중복 노출 작업시 체크해야함
                            }else {
                                if ($('.devOrderGiftArea_'+key).css('display') != 'none' && typeof $('.devOrderGiftArea_'+key).css('display') != "undefined") {
                                    //common.noti.alert(common.lang.get('infoinput.freeGiftSoldOut.alert'));
                                    msg = common.lang.get('infoinput.freeGiftSoldOut.alert');

                                    $('.devOrderGiftArea_'+key).css("display","none");
                                    $("#"+key+"_giftUseYN").val("N");
                                    $("input:radio[name='"+key+"_giftCheck']").prop('checked', false);

                                    /*$('.devOrderGiftArea_'+key).hide();
                                    $('.devOrderGift_'+key).hide();
                                    $('#devOrderGiftList_'+key).empty();*/
                                }
                                //location.reload();
                                //return false;
                            }

                        });
                        if(msg){
                            common.noti.alert(msg);
                            return false;
                        }
                    }
                    /*
                    if (response.result == 'success') {
                        $('.devOrderGiftArea').show();
                        if (type == 'submit') {
                            common.util.modal.open('ajax', freeGiftConditionText, '/popup/freebieSelect?cartIx=' + getCartIx + '&saleCouponPrice=' + parseInt(saleCouponPrice) + '&useMileage=' + parseInt(useMileage)+ '&freeGiftCondition=' + freeGiftCondition, window.popupLayerFullSize)
                        }
                    } else if (response.result == 'changePrice') {
                        if ($('.devOrderGiftArea').css('display') != 'none') {
                            common.noti.alert(common.lang.get('infoinput.freeGiftChangePrice.alert'));
                            $('.devOrderGiftArea').hide();
                            $('.devOrderGift').hide();
                            $('#devOrderGiftList').empty();
                        }
                        return false;
                    }else if (response.result == 'giftCompareFail'){
                        common.noti.alert(common.lang.get('infoinput.freeGiftCompareFail.alert'));
                        $('.devOrderGift').hide();
                        $('#devOrderGiftList').empty();
                        return false;
                    } else {
                        if ($('.devOrderGiftArea').css('display') != 'none') {
                            common.noti.alert(common.lang.get('infoinput.freeGiftSoldOut.alert'));
                            $('.devOrderGiftArea').hide();
                            $('.devOrderGift').hide();
                            $('#devOrderGiftList').empty();
                        }
                        //location.reload();
                        return false;
                    }
                     */
                }
            );
        }
    },
    //주소 미리보기 적용
    viewMiniAddress: function(address){
        var self = this;
        //서울특별시 관악구 신림동 475 SK View 아파트
        $('#devMiniAddress').html(address);
    },
    addressBookTotal:function(){
        var self = this;
        common.ajax(
            common.util.getControllerUrl('getAddressBookCnt', 'mypage'),{
            },"",
            function (response) {
                if (response.result == 'success') {
                    self.addressBookCnt = response.data;
                }
            });
    },
    //회원
    memberRun: function () {
        var self = this;

        self.addressBookTotal();

        //배송지 타입 선택시
        $('[devRecipientTypeSelect]').on('click', function () {
            self.recipientType = $(this).attr('devRecipientTypeSelect');
            self.setInputRecipientValidation();
            //self.changeOrderData();
            var addressText;
            if(self.recipientType == 'input'){
                addressText = $('.devRecipientAddr1').val();
                self.viewMiniAddress(addressText);
            }else{
                addressText = $('input:radio[name=orderAddress]:checked').data('address1');
                self.viewMiniAddress(addressText);
            }

            //배송지 제한 수량 10건 할당 시 배송지 목록 추가 및 기본 배송지 선택 불가 처리
            if(self.addressBookCnt >= 10){
                $('#devAddAddressBookCheckBox').attr('checked',false);
                $('#devBasicAddressBookCheckBox').attr('checked',false);
            }
        });
        $('#devAddAddressBookCheckBox').on('click',function(){
            if($(this).is(':checked') == true){
                if(self.addressBookCnt >= 10){
                    common.noti.alert(common.lang.get('infoinput.addressBook.fail.over'));
                    $(this).prop('checked',false);
                }
            }
        });
        $('#devBasicAddressBookCheckBox').on('click',function(){
            if($(this).is(':checked') == true){
                if(self.addressBookCnt >= 10){
                    common.noti.alert(common.lang.get('infoinput.addressBook.fail.over'));
                    $(this).prop('checked',false);
                }
            }
        });

        //배송지 변경시
        $('#devOrderAddressListContent').on('click', '.devOrderAddressRadio', function () {

            var address = $(this).data('address1');
            self.viewMiniAddress(address);
            self.changeOrderData();
        });

		//배송지 변경시(최근배송지)
        $('#devOrderAddressListOrderContent').on('click', '.devOrderAddressOrderRadio', function () {
            self.changeOrderData();
        });

        /*/배송지 관련 리스트
        self.orderAddressList = common.ajaxList();
        self.orderAddressList
            .setLoadingTpl('#devOrderAddressListLoading')
            .setListTpl('#devOrderAddressList')
            .setEmptyTpl('#devOrderAddressListEmpty')
            .setContainer('#devOrderAddressListContent')
            .setForm('#devOrderAddressListForm')
            .setUseHash(false)
            .setContainerType('ul')
            .setController('addressList', 'order')
            .init(function (response) {
                var list = response.data.list;
                if (list.length > 0) {
                    for (var i = 0; i < list.length; i++) {
                        list[i].index = i;
                        if (list[i].type == 'B') {
                            list[i].isBasic = true;
                            self.viewMiniAddress(list[i].address1);
                        } else if (list[i].type == 'R') {
                            list[i].isRecent = true;
                        }
                    }
                    self.orderAddressListData = list;
                    self.orderAddressList.setContent(list);

                    $('.devOrderAddressRadio:first').prop('checked', true);
                    $('[devRecipientTypeSelect=address]').trigger('click');
                } else {
                    $('[devRecipientTypeSelect=input]').trigger('click');
                    //배송지없으면 신규 배송지 선택만 가능하도록 처리
                    $('[devRecipientTypeSelect=address]').unbind('click');
                    $('#devBasicAddressBookCheckBox').prop('disabled', true);
                    $('#devAddAddressBookCheckBox').prop('disabled', true);
                }
            });*/

		//배송지 관련 리스트(기본배송지)
        self.orderAddressList = common.ajaxList();
        self.orderAddressList
            .setLoadingTpl('#devOrderAddressListLoading')
            .setListTpl('#devOrderAddressList')
            .setEmptyTpl('#devOrderAddressListEmpty')
            .setContainer('#devOrderAddressListContent')
            .setForm('#devOrderAddressListForm')
            .setUseHash(false)
            .setContainerType('ul')
            .setController('addressList', 'order')
            .init(function (response) {
                var list = response.data.list;
                if (list.length > 0) {
                    for (var i = 0; i < list.length; i++) {
						list[i].index = i;
                        if(list[i].default_yn == 'Y'){
							list[i].isBasic = true;
						} else {
							list[i].isBasic = false;
						}
                    }
                    self.orderAddressListData = list;
                    self.orderAddressList.setContent(list);

					self.changeOrderData();

                    $('.devOrderAddressRadio:first').prop('checked', true);
                    $('[devRecipientTypeSelect=address]').trigger('click');
                } else {
                    $('[devRecipientTypeSelect=input]').trigger('click');
                    //배송지없으면 신규 배송지 선택만 가능하도록 처리
                    $('[devRecipientTypeSelect=address]').unbind('click');
                    $('#devBasicAddressBookCheckBox').prop('disabled', true);
                    $('#devAddAddressBookCheckBox').prop('disabled', true);
                }
            });

		//배송지 관련 리스트(최근배송지)
        /*self.orderAddressListOrder = common.ajaxList();
        self.orderAddressListOrder
            .setLoadingTpl('#devOrderAddressListOrderLoading')
            .setListTpl('#devOrderAddressListOrder')
            .setEmptyTpl('#devOrderAddressListOrderEmpty')
            .setContainer('#devOrderAddressListOrderContent')
			.setForm('#devOrderAddressListOrderForm')
            .setUseHash(false)
            .setContainerType('ul')
            .setController('addressListOrder', 'order')
            .init(function (response) {
                var list = response.data.list;
				if (list.length > 0) {
                    for (var i = 0; i < list.length; i++) {
						list[i].index = i;
                    }
					self.orderAddressListOrderData = list;
					self.orderAddressListOrder.setContent(list);
                }
            });*/

        //배송지 목록
        $('#devAddressListButton').on('click', function () {
            var modal_title = '배송지 선택';

            if(common.langType == 'english') {
                modal_title = 'Select destination';
            }
            common.util.modal.open('ajax', modal_title, '/mypage/addressbookSelect', window.popupLayerFullSize, function () {
                devAddressBookPopObj.callbackSelect = function (deliveryIx) {
                    common.ajax(
                        common.util.getControllerUrl('getAddressBook', 'order'), {deliveryIx: deliveryIx}, function () {
                            return deliveryIx;
                        }, function (response) {
                            if (response.result == 'success') {
                                var addressData = response.data;
                                //var index = self.orderAddressListData.length;
                                var index = 0;
                                addressData.index = index;
                                self.orderAddressListData[index] = addressData;
                                self.orderAddressList.setContent(self.orderAddressListData);
                                $('.devRecipientContents:eq(0) .devOrderAddressRadio:last').prop('checked', true).trigger('click');
                            }
                        });
                };
            });
        });

        //마일리지
        $('#devUseMileage').on('blur', function () {
            var maxMileage = self.getMaxMileage();
            $('#devUseMileageView').html($(this).val());
            if (self.getInputMileage() > maxMileage) {
                self.setInputMileage(maxMileage);
            }
            self.changeOrderData();

            self.chkLittleBuyAmt($('#devAllUseMileageCheckBox').attr('devTotalPrice'));
        });

        //마일리지 전체 사용
        $('#devAllUseMileageCheckBox').on('click', function () {
            console.log("A");
            var mileage = 0;
            //if ($(this).is(':checked')) {
                mileage = self.getMaxMileage();
            //}
            console.log("A : " + mileage);
            self.setInputMileage(mileage);
            self.changeOrderData();

            self.chkLittleBuyAmt($(this).attr('devTotalPrice'));
        });

        //쿠폰 적용
        $('#devUseCouponButton').click(function () {
            var modal_title = '쿠폰 적용';

            if(common.langType == 'english') {
                modal_title = 'Select coupon';
            }
            common.util.modal.open('ajax', modal_title, '/shop/couponPop', {cartIxs: self.getCartIx(), useCouponData: self.useCouponData}, window.popupLayerFullSize);
        });

        //쿠폰 적용취소
        $('#devCancelCouponButton').click(function(){
            if($('#devUseCouponInputText').val() == 0){
                common.noti.alert(common.lang.get('coupon.noApply.msg'));
                return false;
            }
            self.setUseCouponData();
        });

        //배송비쿠폰 적용
        $('#devUseDeliveryCouponButton').click(function () {
            var deliveryPrice = $('#devTotalDeliveryPrice').val();
            if(deliveryPrice > 0) {
                var modal_title = '배송비쿠폰 적용';

                if(common.langType == 'english') {
                    modal_title = 'Select Delivery coupon';
                }
                common.util.modal.open('ajax', modal_title, '/shop/couponPop', {cartIxs: self.getCartIx(), useCouponData: self.useDeliveryCouponData, couponDiv: 'D'}, window.popupLayerFullSize);
            }else{
                common.noti.alert(common.lang.get('delivery.noCoupon.alert'));
                return false;
            }
        });

        //배송비쿠폰 적용취소
        $('#devCancelDeliveryCouponButton').click(function(){
            if($('#devUseDeliveryCouponInputText').val() == 0){
                common.noti.alert(common.lang.get('coupon.noApply.msg'));
                return false;
            }
            self.setCancelDeliveryCouponData();
        });

        $('.devPayTypeArea button').click(function(){
            $('#devPayTypeView').html($(this).html());
        });

        //쿠폰 선택
        $('select[devCouponSelect]').change(function () {
            var data = self.getCouponInfoBySelect($(this));
            if (data.registIx > 0) {
                self.changeCouponText(data.cartIx, data.totalCouponWithDcprice, data.discountAmount);

                //다른 선택 사항 초기화
                $('select[devCouponSelect]:not([devCouponSelect="' + data.cartIx + '"]) option[value="' + data.registIx + '"]:selected').closest('select').each(function () {
                    $(this).val('');
                    var cartIx = $(this).attr('devCouponSelect');
                    self.changeCouponText(cartIx, 0, 0);
                });
            } else {
                self.changeCouponText(data.cartIx, 0, 0);
            }
            self.changeProductDcpriceText();
            $('[devCartDiscountAmountText]').text(0);

            var changeTotalPrice = parseFloat($('#devTotalCouponWithProductDcpriceFloat').val());
            if (self.firstInitCartCoupon || (!self.firstInitCartCoupon && $('select[devCouponSelect]').index($(this)) == $('select[devCouponSelect]').length - 1)) {
                self.initCartCoupon(changeTotalPrice);
            }
        });

        //장바구니 쿠폰 선택
        $('select[devCartCouponSelect]').change(function () {
            var data = self.getCartCouponInfoBySelect();
            if (data.totalCouponWithDcprice < 0) {
                common.noti.alert(common.lang.get('coupon.invalid.msg'));
                $('select[devcartcouponselect]').val('');
                $('.devCouponCancel').trigger('click');
                return false;
            }

            $('[devCartDiscountAmountText]').text(common.util.numberFormat(data.discountAmount));
            self.checkCartOverlapUseYn();

            var couponCheckPaymentMethodBool = true;

            if (data.registIx > 0) {
                if (data.productOverlapUseYn == 'N' && $('select[devCouponSelect] option[value!=""]:selected').length > 0) {
                    common.noti.confirm(
                        common.lang.get('coupon.productOverlapUseYn.confirm'),
                        function () {
                            //쿠폰 초기화
                            $('select[devCouponSelect] option[value!=""]:selected').closest('select').each(function () {
                                $(this).val('');
                                var cartIx = $(this).attr('devCouponSelect');
                                self.changeCouponText(cartIx, 0, 0);
                                self.checkCartOverlapUseYn($(this));
                            });

                            couponCheckPaymentMethodBool = false;
                            self.changeProductDcpriceText();
                            var changeTotalPrice = parseFloat($('#devTotalCouponWithProductDcpriceFloat').val());
                            self.firstInitCartCoupon = false;
                            $('#devSelectedCartCouponIx').val(data.registIx);
                            self.initCartCoupon(changeTotalPrice);
                            self.firstInitCartCoupon = true;
                        },
                        function () {
                            $('.devCouponCancel').trigger('click');
                        });
                }
            }
            if (couponCheckPaymentMethodBool && $("select[devCouponSelect] option[devPaymentMethod][devPaymentMethod!='']:selected").length == 0) {
                self.checkPaymentMethod();
            }
            self.changeProductDcpriceText();
            self.check_minus_check();
        });
    },
    changeProductDcpriceText: function () {
        var self = this;
        var totalDiscountAmount = 0;
        $('select[devCouponSelect]').each(function () {
            var registIx = $(this).val();

            if (registIx != '') {
                var disAmount = $(this).find('option[value="' + registIx + '"]:selected').attr('devDiscountAmount');
                if (disAmount) {
                    totalDiscountAmount = common.math.add(totalDiscountAmount, disAmount);
                }
            }
        });

        var cartDisAmount = 0;
        if ($('select[devCartCouponSelect]').val() != '') {
            cartDisAmount = $('select[devCartCouponSelect] option:selected').attr('devDiscountAmount');
        }

        var totalProductDcprice = $('#devTotalProductDcprice').val();

        var devTotalCouponWithProductDcprice = common.math.sub(totalProductDcprice, totalDiscountAmount);

        totalDiscountAmount = common.math.add(totalDiscountAmount, cartDisAmount);

        var totalProductPriceCheck = common.math.sub(totalProductDcprice, totalDiscountAmount);
        if (totalProductPriceCheck < 0) {
            common.noti.alert(common.lang.get('coupon.invalid.msg'));
            $('select[devcartcouponselect]').val('');
            return false;
        }

        $('#devTotalCouponWithProductDcpriceFloat').val(devTotalCouponWithProductDcprice);
        $('#devTotalCouponDiscountAmount').text(common.util.numberFormat(totalDiscountAmount));
        $('#devTotalCouponWithProductDcprice').text(common.util.numberFormat(common.math.sub(totalProductDcprice, totalDiscountAmount)));
    },
    initCartCoupon: function (price) {
        var self = this;
        var devTotalProductDcprice = price;
        var useData = {};
        $('select[devCouponSelect]').each(function () {
            var data = self.getCouponInfoBySelect($(this));
            if (data.registIx) {
                useData[data.cartIx.replace(/,/gi, "|")] = data.registIx;
            }
        });

        common.ajax(
            common.util.getControllerUrl('applyUserCartCouponList', 'order'),
            {
                totalProductDcprice: devTotalProductDcprice,
                cartIxs: devInfoinputObj.getCartIx(),
                coupon: useData,
                selectedCartCouponIx: self.firstInitCartCoupon ? '' : $('#devSelectedCartCouponIx').val()
            },
            '',
            function (response) {
                if (response.data) {
                    self.changeCartCoupon(response.data)
                }
            }
        );
    },
    changeCartCoupon: function (data) {
        var self = this;
        //기존 항목 제거
        $('select[devCartCouponSelect] option:not(option:eq(0))').remove();

        var optionData = "";
        $(data).each(function (i, v) {
            if (v.activeBool) {
                if (v.payment_method == null) {
                    v.payment_method = '';
                }
                if (v.isSelected) {
                    optionData += '<option value="' + v.regist_ix + '" devTotalCouponWithDcprice="' + v.total_coupon_with_dcprice + '" devDiscountAmount="' + v.discount_amount + '" devProductOverlapUseYn="' + v.overlap_use_yn + '" devPaymentMethod="' + v.payment_method + '" selected >' + v.publish_name + '</option>';
                } else {
                    optionData += '<option value="' + v.regist_ix + '" devTotalCouponWithDcprice="' + v.total_coupon_with_dcprice + '" devDiscountAmount="' + v.discount_amount + '" devProductOverlapUseYn="' + v.overlap_use_yn + '" devPaymentMethod="' + v.payment_method + '" >' + v.publish_name + '</option>';
                }
            }
        });
        $('select[devCartCouponSelect]').append(optionData);
        self.changeProductDcpriceText();
        self.checkCartOverlapUseYn();
        self.checkPaymentMethod();
    },
    checkCartOverlapUseYn: function ($target) {
        var self = this;
        var cartData = self.getCartCouponInfoBySelect();

        if (cartData.registIx > 0) {
            if (!$.isPlainObject($target)) {
                $target = $('select[devCouponSelect]');
            }
            //상품 쿠폰에 장바구니 쿠폰 사용여부 체크
            $target.each(function () {
                var data = self.getCouponInfoBySelect($(this));
                if (data.cartOverlapUseYn == 'N') {
                    $("[devCartOverlapNoText='" + data.cartIx + "']").show();
                } else {
                    $("[devCartOverlapNoText='" + data.cartIx + "']").hide();
                }
            });
        } else {
            $('[devCartOverlapNoText]').hide();
        }
    },
    selectPaymentMethod: '',
    checkPaymentMethod: function () {
        var self = this;
        var $select = $("option[devPaymentMethod][devPaymentMethod!='']:selected").closest('select');
        if ($select.length > 0) {
            if ($select.is('[devCartCouponSelect]')) {
                var data = self.getCartCouponInfoBySelect();
            } else {
                var data = self.getCouponInfoBySelect($select)
            }
            if (data.paymentMethod != '') {
                var orderMethodTextList = [];
                $.each(data.paymentMethod.split('|'), function (key, method) {
                    var text = $('.devPayTypeArea button[devPaymentMethod=' + method + ']').text();
                    if (text) {
                        orderMethodTextList.push(text);
                    }
                });
                if (self.selectPaymentMethod == '') {
                    common.noti.alert(common.lang.get('coupon.orderMethod.alert', {orderMethod: orderMethodTextList.join(', ')}));
                    self.selectPaymentMethod = data.paymentMethod;
                }
                $("option[devPaymentMethod][devPaymentMethod!='']").not($select.find('option:selected')).hide();
            } else {
                self.resetPaymentMethod();
            }
        } else {
            self.resetPaymentMethod();
        }
    },
    resetPaymentMethod: function () {
        var self = this;
        self.selectPaymentMethod = '';
        if ($("option[devPaymentMethod][devPaymentMethod!='']:selected").length == 0) {
            $("option[devPaymentMethod][devPaymentMethod!='']:hidden").show();
        }
    },
    changeCouponText: function (cartIx, totalCouponWithDcprice, discountAmount) {
        if (totalCouponWithDcprice >= 0) {
            $('[devTotalCouponWithDcpriceText="' + cartIx + '"]').text(common.util.numberFormat(totalCouponWithDcprice));
            $('[devDiscountAmountText="' + cartIx + '"]').text(common.util.numberFormat(discountAmount));
        } else {
            common.noti.alert(common.lang.get('coupon.invalid.msg'));
            $('select[devCouponSelect]').val('');
        }
    },
    chkLittleBuyAmt: function (totalPrice) {
        var self = this;
        var mileageConditionMinBuyAmt = $('#mileageConditionMinBuyAmt').val();

        var saleCouponPrice = 0;
        if ($('#devUseCouponInputText').length > 0) {
            saleCouponPrice = $('#devUseCouponInputText').val();
            if (saleCouponPrice == '') {
                saleCouponPrice = 0;
            }
        }

        if((totalPrice - saleCouponPrice) < mileageConditionMinBuyAmt) {
            common.noti.alert(common.lang.get('infoinput.paymentRequest.fail.littleBuyAmt2'));
            self.setInputMileage(0);
            self.changeOrderData();
            $('#devAllUseMileageCheckBox').prop('checked',false);
        }
    },
    //비회원
    nonMemberRun: function () {
        var self = this;
        //주문자 정보와 동일
        $('.devSameBuyerInfo').click(function () {
            var recipientContents = $(this).closest('.devRecipientContents');
            if($(this).prop( "checked" )){
                var buyer = self.getBuyerData();
                recipientContents.find('.devRecipientName').val(buyer.name);
                var mobile = buyer.mobile.split('-');
                if(common.langType=='korean') {
                    recipientContents.find('.devRecipientMobile1').val(mobile[0]);
                }else{
                    var nation = buyer.nation;
                    recipientContents.find('.devRecipientMobile1 [data-nation_code='+nation+']').prop('selected', true).closest('select').trigger('change');
                }
                recipientContents.find('.devRecipientMobile2').val(mobile[1]);
                recipientContents.find('.devRecipientMobile3').val(mobile[2]);
                // var tel = buyer.tel.split('-');
                // recipientContents.find('.devRecipientTel1').val(tel[0]);
                // recipientContents.find('.devRecipientTel2').val(tel[1]);
                // recipientContents.find('.devRecipientTel3').val(tel[2]);
            }else{
                recipientContents.find('.devRecipientName').val("");
                if(common.langType=='korean') {
                    recipientContents.find('.devRecipientMobile1').val($('select.devRecipientMobile1 option:first').val());
                }else{
                    recipientContents.find('.devRecipientMobile1 [data-nation_code=US]').prop('selected', true).closest('select').trigger('change');
                }
                recipientContents.find('.devRecipientMobile2').val("");
                recipientContents.find('.devRecipientMobile3').val("");
                recipientContents.find('.devRecipientTel1').val($('select.devRecipientTel1 option:first').val());
                recipientContents.find('.devRecipientTel2').val("");
                recipientContents.find('.devRecipientTel3').val("");
            }
        });

        $('.infoinput__toggle__btn').click(function(){
            if(!$(this).closest('.br__infoinput__buyer').find('.infoinput__toggle').hasClass('infoinput__toggle--hide')){
                var buyerName = $('#devBuyerName').val()
                var devBuyerMobile1 = $('#devBuyerMobile1').val()
                var devBuyerMobile2 = $('#devBuyerMobile2').val()
                var devBuyerMobile3 = $('#devBuyerMobile3').val()
                if(common.langType =='korean'){
                    var phone = devBuyerMobile1 + '-' + devBuyerMobile2 + '-' + devBuyerMobile3;
                }else{
                    var phone = devBuyerMobile1 + '-' + devBuyerMobile2;
                }

                $('#devMiniViewName').html(buyerName);
                $('#devMiniViewPhone').html(phone);
            }else{
                $('#devMiniViewName').html('');
                $('#devMiniViewPhone').html('');
            }
        });


        $('.devPayTypeArea button').click(function(){
            $('#devPayTypeView').html($(this).html());
        });
    }
}

$(function () {
    devInfoinputObj.commonRun();
    if (forbizCsrf.isLogin) {
        devInfoinputObj.memberRun();
    } else {
        devInfoinputObj.nonMemberRun();
    }

    $('[devPaymentMethod=1]').trigger('click');

    // 특수문자 정규식 변수(공백 미포함)
    var replaceChar = /[~!@\#$%^&*\()\-=+'\;<>\/.\`:\"\\,\[\]?|{}]/gi;

    $("#devBuyerName").on("keyup", function() {
        var x = $(this).val();
        if (x.length > 0) {
            if (x.match(replaceChar)){
                alert('특수문자는 입력 불가능합니다.');
                x = x.replace(replaceChar, "");
            }
            $(this).val(x);
        }
    });

    /*$("#giftCheckbox").on("click", function() {
        $('#giftNoCheckbox').prop('checked',false);
    });

    $("#giftNoCheckbox").on("click", function() {
        $('#giftCheckbox').prop('checked',false);
    });*/
});

function couponClose(){
    $('.popup-layout .close').trigger('click');
}

function couponClose2(){
    $('#mask').css('display', 'none');
    $('body').css({
        'position' : '',
        'margin-top' : -window.oriScroll
    });
}

function radioChk(val){
    var condition = val.split('_');

    if(condition[1] == "G"){
        $('#freeGiftG').val('O');
    }else if(condition[1] == "C"){
        $('#freeGiftC').val('O');
    }else if(condition[1] == "P"){
        $('#freeGiftP').val('O');
    }
}