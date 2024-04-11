"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
//버전픽스 퍼블 요청 사항 (확인하시고 주석 지워 주셔도 됩니다.)
//1.추가구성상품관련 코딩이 없어 카트기준으로 가지고 왔습니다.
//2.배송 요청사항 비회원도 회원과 같이 되어 해서 똑같이 가지고 왔습니다.
//3.배송 요청사항 개별입력 체크박스 위치는 관련 같이 논의가 필요 합니다.
//4.카트처럼 전체 체크 relation_checkbox 함수 가지고 와서 구현 했습니다. 공통으로 두시고 함수는 삭제해주세요
//5.약관 보기 작업이 필요 합니다.

$(function () {
    if ($('.shop-total-price').length) {
        var $target = $('.shop-right-area');
        var scrollCon = function () {
            $(window).scroll(function () {
                var starH = $('.layout-section .layout-left section:eq(0)').offset().top,
                    wst = $(window).scrollTop();
                if (wst > starH) {
                    $target.addClass('sticky');
                } else {
                    $target.removeClass('sticky');
                }
                var footerPosition = $('#footer').offset().top;
                var scrollB  = footerPosition - $('.shop-right-area').height() - 100;

                if (wst > scrollB) {
                    $target.addClass('bottom');
                    console.log(scrollB);
                } else {
                    $target.removeClass('bottom');
                }

            });
        };
        scrollCon();
    }

    $('.agree-top').click(function (e) {
        if ($(this).hasClass('on')) {
            //$(this).nextAll().slideDown();
        } else {
            //$(this).nextAll().slideUp();
        }
    });
    $('.check-area input[type="checkbox"] , .check-area label').click(function (event) {
        event.stopPropagation();
    });

    var sImg = $(".gift_list ul img");
    sImg.click(function () {
        sImg.parent("li").removeClass("selected");
        $(this).parent("li").addClass("selected");
        devInfoinputObj.selectGift = $(this).data('devpid');
    });

    // $("#btnGiftList").click(function () {
    //     $(".gift_list").slideToggle();
    //     $(this).toggleClass("on");
    //     if ($(this).hasClass("on")) {
    //         $(this).children("span").text("사은품 목록 닫기")
    //     } else {
    //         $(this).children("span").text("사은품 목록 보기")
    //     }
    // });

    //약관보기 관련... css는 여기서 타겟줘서 수정
    $('.term-content').click(function () {

        var title = $("input[name='" + this.name + "']").attr('title');
        var id = $("input[name='" + this.name + "']").attr('name');
        // $('body').css({
        //     "position" : "fixed"
        // })
        // $(".popup-mask").show();
        $('.popup-mask').fadeIn(100);
        $('.popup-mask').fadeTo("fast", 0.8);
        $("#agree_title").text(title);
        $(".pop-cont-detail").hide();
        $("#" + id).show();
        // $("body").css({
        //     "overflow": "hidden"
        // })
        if(id == "terms-2"){
            $('.terms-layer-pop').css({
                "display": "block",
                "visibility": "visible",
                "opacity": "1",
                "position": "absolute",
                "z-index": "10000",
                "top": $(window).scrollTop() + ($(window).height() / 2),
                "left": '50%',
                "overflow": '',
                "height" : '',
                "width": ''
                //"margin-top": -+$('.terms-layer-pop').height() / 2,
                //"margin-left" : - + $('.terms-layer-pop').outerWidth() / 2
            })
        }else{
            $('.terms-layer-pop').css({
                "display": "block",
                "visibility": "visible",
                "opacity": "1",
                "position": "absolute",
                "z-index": "10000",
                "top": $(window).scrollTop() + ($(window).height() / 2),
                "left": '50%',
                "overflow": 'auto',
                "height" : "75%",
                "width": "80%"
                //"margin-top": -+$('.terms-layer-pop').height() / 2,
                //"margin-left" : - + $('.terms-layer-pop').outerWidth() / 2
            })
        }
        $('#mask').css('display', 'block');
    });

    $('.terms-layer-pop #close').click(function () {
        $('.popup-mask').hide();
        $('.terms-layer-pop').css('width', 'auto');
        $('#mask').css('display', 'none');
    });
});

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
common.lang.load('infoinput.paymentRequest.noti.gift', "구매금액별 사은품이 선택되지 않았습니다. 주문을 계속 진행 하시겠습니까?");
common.lang.load('coupon.noApply.msg', "적용된 쿠폰이 없습니다.");
common.lang.load('infoinput.paymentRequest.fail.littleBuyAmt2', "총 상품금액이 3만원 이상일 때만 사용가능합니다.");
common.lang.load('infoinput.addressBook.fail.over', "최대 10개까지 등록 가능합니다.");
common.lang.load('infoinput.freeGiftPopup.title', "구매금액별 사은품 선택");
common.lang.load('infoinput.freeGiftSelect.fail', "선택가능한 사은품이 존재합니다. 사은품을 선택해 주세요.");
common.lang.load('gift.update.count.giftItemStockCheck.alert', "{pname} 사은품은 {count}개 까지 선택 가능합니다. 다시 선택 바랍니다.");
common.lang.load('infoinput.freeGiftSoldOut.alert', "사은품이 품절되었거나 선택가능한 사은품이 존재하지 않습니다.");
common.lang.load('infoinput.freeGiftChangePrice.alert', "결제금액이 변경되어 사은품이 지급되지 않습니다.");
common.lang.load('infoinput.freeGiftCheckFail.alert', "사은품 정보가 변경되어 다시 결제 해주세요.");
common.lang.load('infoinput.freeGiftCntCheckFail.alert', "사은품 지급수량이 변경되어 다시 결제 해주세요.");
common.lang.load('infoinput.freeGiftCompareFail.alert', "결제금액이 변경되어 사은품을 다시 선택해주셔야 합니다.");
common.lang.load('delivery.noCoupon.alert', "할인을 적용할 배송비가 없습니다.");

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

if(common.langType == 'korean'){
    common.inputFormat.set($('.devRecipientMobile2,.devRecipientMobile3'), {'number': true, 'maxLength': 4});
}
common.inputFormat.set($('.devRecipientTel2,.devRecipientTel3'), {'number': true, 'maxLength': 4});
//마일리지
common.inputFormat.set($('#devUseMileage'), {'number': true});
//-----set validation
//주문자 정보
common.validation.set($('#devBuyerName'), {'required': true});
// common.validation.set($('#devBuyerEmailId'), {'required': true});
// common.validation.set($('#devBuyerEmailHost'), {'required': true});
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
    //배송지 선택 콜백
    deliverySelectcallback: function (deliveryIx) {
        var self = this;
        common.ajax(
            common.util.getControllerUrl('getAddressBook', 'order'),
            {deliveryIx: deliveryIx},
            function () {
                return deliveryIx;
            },
            function (response) {

                if (response.result == 'success') {
                    var addressData = response.data;
                    //var index = self.orderAddressListData.length;
                    var index = 0;
                    addressData.index = index;
                    self.orderAddressListData[index] = addressData;
                    self.orderAddressList.setContent(self.orderAddressListData);
                    //trigger에서 checked 시점이 늦어 우선 checked 처리
                    $('.devRecipientContents:eq(0) .devOrderAddressRadio:last').prop('checked', true).trigger('click');
                }
            });
    },
    //결제 구분
    paymentBool: false,
    //배송지 리스트
    orderAddressList: false,
    //배송지 데이터
    orderAddressListData: false,

    //배송지 등록 갯수
    addressBookCnt: 0,

    selectGift: false,
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
        if(common.langType == 'korean'){
            data.mobile = $('#devBuyerMobile1').val().trim() + '-' + $('#devBuyerMobile2').val().trim() + '-' + $('#devBuyerMobile3').val().trim();
        }else{
            data.mobile = $('#devBuyerMobile1').val().trim() + '-' + $('#devBuyerMobile2').val().trim();
            data.nation = $('#devBuyerMobile1 option:selected').data('nation_code');
        }

        //data.tel = $('#devBuyerTel1').val().trim() + '-' + $('#devBuyerTel2').val().trim() + '-' + $('#devBuyerTel3').val().trim();
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
                if(common.langType == 'korean'){
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

            data.msg_type = ($(this).find('.devDeliveryMessageIndividualCheckBox:checked').length > 0 ? 'P' : 'D'); //배송요청사항 타입(D: 배송지별 입력, P: 상품 개별입력)
            if (data.msg_type == 'P') {
                data.msg = '';
                data.product_msg = [];
                $(this).find('.devEachDeliveryMessageContents').each(function () {
                    var cart_ix = $(this).attr('devCartIx').trim();
                    var msg = $(this).find('.devDeliveryMessage').val().trim();
                    data.product_msg[cart_ix] = msg;
                });
            } else {
                data.msg = $(this).find('.devDeliveryMessageContents .devDeliveryMessage').val().trim();
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
        console.log("AA");
        self.useCouponData = data;
        //마일리지 초기화
        self.setInputMileage(0);
        $('#devAllUseMileageCheckBox').prop('checked', false);
        self.changeOrderData();

    },
    useDeliveryCouponData: false,
    setUseDeliveryCouponData: function (data) {
        var self = this;
        self.useDeliveryCouponData = data;
        $('#devAllUseMileageCheckBox').prop('checked', false);
        self.changeOrderData();

    },
    setCancelCouponData: function () {
        var self = this;
        console.log("BB");
        self.useCouponData = '';
        $('#devAllUseMileageCheckBox').prop('checked', false);
        self.changeOrderData();
    },
    setCancelDeliveryCouponData: function () {
        var self = this;
        self.useDeliveryCouponData = '';
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
                common.noti.alert('error_1');
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
                    $('#devCouponButtonCancel').show();
                } else {
                    $('#devUseCouponInputText').val(0);
                    $('#devCouponButtonCancel').show();
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
                    $('#devDeliveryCouponButtonCancel').show();
                } else {
                    $('#devUseDeliveryCouponInputText').val(0);
                    $('#devDeliveryCouponButtonCancel').show();
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
    },
    //결제 정보
    getPaymentData: function () {
        var self = this;
        var data = {};
        data.method = $('input[name=devPaymentMethod]:checked').val();
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
                common.noti.alert('error_2');
            } else {
                self.paymentBool = false;
                common.noti.alert('error_3');
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
                common.noti.alert('error_4');
            } else {
                self.paymentBool = false;
                common.noti.alert('error_5');
            }
        }));
    },
    //PG 결제
    paymentGateway: function (data) {
        var self = this;
        var requestData = {};
        requestData.agentType = 'W'; //W:PC
        requestData.method = data.payment.method;
        common.ajax(common.util.getControllerUrl('paymentGateway', 'order'), requestData, '', (function (response) {
            if (response.result == 'success') {
                //금액 조건 처리해야함
                $('#devPaymentGatewayContents').empty();
                $('#devPaymentGatewayContents').append(response.data.html);
                paymentGateway.request();
            } else if (response.result == 'noSettleReady') {
                common.noti.alert('error_6');
            } else {
                common.noti.alert('error_7');
            }
            self.paymentBool = false;
        }));
    },
    //공통
    commonRun: function () {
        var self = this;
        //배송 요청사항 selectBox 변경
        $('.devDeliveryMessageSelectBox').change(function () {
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
            var $recipientContents = $(this).closest('.devRecipientContents');
            if ($(this).is(':checked')) {
                $recipientContents.find('.devDeliveryMessageContents').hide();
                $recipientContents.find('.devEachDeliveryMessageContents').show();
            } else {
                $recipientContents.find('.devDeliveryMessageContents').show();
                $recipientContents.find('.devEachDeliveryMessageContents').hide();
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
        $('input[name=devPaymentMethod]').click(function (e) {
            $('[devPaymentDescription]:visible').hide();
            $('[devPaymentDescription=' + $(this).val() + ']').show();
        });

		$('.devTerms').click(function (e) {
			self.changeOrderData();
		});
        //구매하기
        $('#devPaymentButton').click(function () {

            if($('#giftNoCheckbox').val() == "Y"){
                if(!$('#giftCheckbox').is(':checked') && !$('#giftNoCheckbox').is(':checked')){
                    alert("구매 금액별 사은품을 선택하세요.");
                    return false;
                }
            }

            if($('input[id="devBuyUnderAge"]:checked').val() == "N"){
                alert("만 14세미만은 상품구입이 불가능 합니다.");
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
            if($('#giftNoCheckbox').is(':checked')){
                /*var giftPid = "55421";
                var giftCount = "1";
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
            }else{
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
                // //장바구니 사은품 중복 노출 작업시 체크해야함

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
                            common.noti.alert('error_8 ggg');
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
                        } else if(response.result == 'selectGiftOrder'){
                            common.noti.alert(common.lang.get('infoinput.freeGiftSelect.fail'));
                        }else if(response.result == 'giftItemStockFail'){
                            common.noti.alert(common.lang.get('gift.update.count.giftItemStockCheck.alert', {count: response.data.stock, pname: response.data.pname}));
                           // $('#devOrderGiftList').empty();
                            $('.devOrderGiftList').empty();
                        }else if(response.result == 'giftItemSoldOutFail'){
                            common.noti.alert(common.lang.get('infoinput.freeGiftSoldOut.alert'));
                            $('.devOrderGiftList').empty();
                            //self.changeOrderData();
                        }else if(response.result == 'giftCheckFail'){
                            common.noti.alert(common.lang.get('infoinput.freeGiftCheckFail.alert'));
                            // $('#devOrderGiftList').empty();
                            self.changeOrderData();
                        }else if(response.result == 'giftCompareFail'){
                            common.noti.alert(common.lang.get('infoinput.freeGiftCompareFail.alert'));
                        }else if(response.result == 'giftCntCheckFail'){
                            common.noti.alert(common.lang.get('infoinput.freeGiftCntCheckFail.alert'))
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
                        var viewConditionCheck = true;
                        $('.devOrderGiftArea').each(function(){
                            var viewCondition = $(this).data('freegift_condition');
                            if ($(this).css('display') != 'none' && typeof $(this).css('display') != "undefined") {
                                if (data.hasOwnProperty(viewCondition) == false) {
                                    $(this).hide();
                                    if (type == 'submit') {
                                        viewConditionCheck = false;
                                    }
                                }
                            }
                        });
                        if(viewConditionCheck == false){
                            common.noti.alert(common.lang.get('infoinput.freeGiftCheckFail.alert'));
                            return false;
                        }
                        $.each(data, function(key, value) {
                            if(value == 'success'){
                                //장바구니 사은품 중복 노출 작업시 체크해야함
                                //$('.devOrderGiftArea_'+key).show();
                                $('.devOrderGiftArea_'+key).css("display","block");
                                $("#giftNoCheckbox").val("Y");
                                // //장바구니 사은품 중복 노출 작업시 체크해야함
                                if (type == 'submit') {
                                    common.util.modal.open('ajax', freeGiftConditionText, '/popup/freebieSelect?cartIx=' + getCartIx + '&saleCouponPrice=' + parseInt(saleCouponPrice) + '&useMileage=' + parseInt(useMileage)+ '&freeGiftCondition=' + freeGiftCondition, window.popupLayerFullSize)
                                }
                            }else if (value == 'changePrice') {
                                //alert($('.devOrderGiftArea_'+key).css('display'))
                                if ($('.devOrderGiftArea_'+key).css('display') != 'none' && typeof $('.devOrderGiftArea_'+key).css('display') != "undefined") {
                                    //common.noti.alert(common.lang.get('infoinput.freeGiftChangePrice.alert'));
                                    msg = common.lang.get('infoinput.freeGiftChangePrice.alert');

                                    //장바구니 사은품 중복 노출 작업시 체크해야함
                                    /*$('.devOrderGiftArea_'+key).hide();
                                    $('.devOrderGift_'+key).hide();
                                    $('#devOrderGiftList_'+key).empty();*/
                                    $('.devOrderGiftArea_'+key).css("display","none");
                                    $("#giftNoCheckbox").val("N");
                                    // //장바구니 사은품 중복 노출 작업시 체크해야함
                                }
                               // return false;
                            } else if (value == 'giftCompareFail'){
                                // common.noti.alert(common.lang.get('infoinput.freeGiftCompareFail.alert'));
                                msg = common.lang.get('infoinput.freeGiftCompareFail.alert');

                                //장바구니 사은품 중복 노출 작업시 체크해야함
                                /*$('.devOrderGift_'+key).hide();
                                $('#devOrderGiftList_'+key).empty();*/
                                $('.devOrderGiftArea_'+key).css("display","none");
                                $("#giftNoCheckbox").val("N");
                                // //장바구니 사은품 중복 노출 작업시 체크해야함
                            }else {
                                if ($('.devOrderGiftArea_'+key).css('display') != 'none' && typeof $('.devOrderGiftArea_'+key).css('display') != "undefined") {
                                    //common.noti.alert(common.lang.get('infoinput.freeGiftSoldOut.alert'));
                                    msg = common.lang.get('infoinput.freeGiftSoldOut.alert');
                                    $('.devOrderGiftArea_'+key).hide();
                                    $('.devOrderGift_'+key).hide();
                                    $('#devOrderGiftList_'+key).empty();
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
                    } else if (response.result == 'giftCompareFail'){
                        common.noti.alert(common.lang.get('infoinput.freeGiftCompareFail.alert'));
                        $('.devOrderGift').hide();
                        $('#devOrderGiftList').empty();
                    }else {
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
			if($(this).attr('devRecipientTypeSelect') == 'addressOrder'){
				self.changeOrderData();
				$('.devOrderAddressOrderRadio:first').prop('checked', true);
			} else if($(this).attr('devRecipientTypeSelect') == 'address'){
				$('.devOrderAddressRadio:first').prop('checked', true);
			}
            self.recipientType = $(this).attr('devRecipientTypeSelect');
            self.setInputRecipientValidation();
            //self.changeOrderData();

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

        //배송지 변경시(기본배송지)
        $('#devOrderAddressListContent').on('click', '.devOrderAddressRadio', function () {
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
					//$('.devOrderAddressOrderRadio:first').prop('checked', true);
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
            common.util.popup('/mypage/addressbookSelect', 800, 510, '배송지 선택', true);
        });

        //마일리지
        $('#devUseMileage').on('blur', function () {
            var maxMileage = self.getMaxMileage();
            if (self.getInputMileage() > maxMileage) {
                self.setInputMileage(maxMileage);
            }
            self.changeOrderData();
            self.chkLittleBuyAmt($('#devAllUseMileageCheckBox').attr('devTotalPrice'));
        });

        //마일리지 전체 사용
        $('#devAllUseMileageCheckBox').on('click', function () {
            var mileage = 0;
            if ($(this).is(':checked')) {
                mileage = self.getMaxMileage();
            }
            self.setInputMileage(mileage);
            self.changeOrderData();
            self.chkLittleBuyAmt($(this).attr('devTotalPrice'));
        });

        //쿠폰 적용
        $('#devUseCouponButton').click(function () {

            var modal_title = '쿠폰 선택';

            if(common.langType == 'english') {
                modal_title = 'Select coupon';
            }
            console.log(self);
            console.log(self.getCartIx());
            common.util.modal.open('ajax', modal_title, '/shop/couponPop', {cartIxs: self.getCartIx(), useCouponData: self.useCouponData},{} ,$(this).attr("data-target"));

        });
        //쿠폰 적용취소
        $('#devCouponButtonCancel').click(function () {
            if($('#devUseCouponInputText').val() == 0){
                common.noti.alert(common.lang.get('coupon.noApply.msg'));
                return false;
            }
            self.setCancelCouponData();
        });


        //배송비쿠폰 적용
        $('#devUseDeliveryCouponButton').click(function () {
            var deliveryPrice = $('#devTotalDeliveryPrice').val();
            if(deliveryPrice > 0) {
                var modal_title = '배송비쿠폰 적용';

                if (common.langType == 'english') {
                    modal_title = 'Select Delivery coupon';
                }
                common.util.modal.open('ajax', modal_title, '/shop/couponPop', {
                    cartIxs: self.getCartIx(),
                    useCouponData: self.useDeliveryCouponData,
                    couponDiv: 'D'
                }, {}, $(this).attr("data-target"));
            }else{
                common.noti.alert(common.lang.get('delivery.noCoupon.alert'));
                return false;
            }
        });
        //배송비쿠폰 적용취소
        $('#devDeliveryCouponButtonCancel').click(function () {
            if($('#devUseDeliveryCouponInputText').val() == 0){
                common.noti.alert(common.lang.get('coupon.noApply.msg'));
                return false;
            }
            self.setCancelDeliveryCouponData();
        });

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
            return ;
        }
    },
    //비회원
    nonMemberRun: function () {
        var self = this;
        //주문자 정보와 동일
        $('.devSameBuyerInfo').click(function () {
            var recipientContents = $(this).closest('.devRecipientContents');

            if ($('.devSameBuyerInfo').prop("checked")) {
                var buyer = self.getBuyerData();
                recipientContents.find('.devRecipientName').val(buyer.name);
                var mobile = buyer.mobile.split('-');
                if(common.langType=='korean'){
                    recipientContents.find('.devRecipientMobile1').val(mobile[0]);
                }else{
                    var nation = buyer.nation;
                    recipientContents.find('.devRecipientMobile1 [data-nation_code='+nation+']').prop('selected', true).closest('select').trigger('change');
                }
                recipientContents.find('.devRecipientMobile2').val(mobile[1]);
                recipientContents.find('.devRecipientMobile3').val(mobile[2]);
               // var tel = buyer.tel.split('-');
               //  recipientContents.find('.devRecipientTel1').val(tel[0]);
               //  recipientContents.find('.devRecipientTel2').val(tel[1]);
               //  recipientContents.find('.devRecipientTel3').val(tel[2]);
            } else {
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
    }
};

//배송지 선택 IE 이슈 떄문에 POPUP open 시 opener.runCallback 자동 호출됨
function runCallback(deliveryIx) {
    devInfoinputObj.deliverySelectcallback(deliveryIx);
}

$(function () {
    devInfoinputObj.commonRun();
    if (forbizCsrf.isLogin) {
        devInfoinputObj.memberRun();
    } else {
        devInfoinputObj.nonMemberRun();
    }

    $('input[name=devPaymentMethod][value=1]').trigger('click');

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

    $("#giftCheckbox").on("click", function() {
        $('#giftNoCheckbox').prop('checked',false);
    });

    $("#giftNoCheckbox").on("click", function() {
        $('#giftCheckbox').prop('checked',false);
    });
});
