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
    if ($('.cart-total-price').length) {
        var $target = $('.cart-right-area');
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
                var scrollB  = footerPosition - $('.cart-right-area').height() - 100;

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
            $(this).nextAll().slideDown();
        } else {
            $(this).nextAll().slideUp();
        }
    });
    $('.check-area input[type="checkbox"] , .check-area label').click(function (event) {
        event.stopPropagation();
    });

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
        $("body").css({
            "overflow": "hidden"
        })
        $('.terms-layer-pop').css({
            "visibility": "visible",
            "opacity": "1",
            "position": "absolute",
            "z-index": "10000",
            "top": $(window).scrollTop() + ($(window).height() / 2),
            "left": "",
            "width": "100%",
            "margin-top": -+$('.terms-layer-pop').height() / 2,
        })
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
common.lang.load('infoinput.paymentRequest.noti.paymentFree', "총 결제금액이 0원이므로 무료결제로 자동 진행됩니다.");

//-----set input format
//주문자 정보
common.inputFormat.set($('#devBuyerName'), {'maxLength': 20});
common.inputFormat.set($('#devOrderPassword,#devOrderPasswordCompare'), {'maxLength': 20});
common.inputFormat.set($('#devBuyerMobile2,#devBuyerMobile3'), {'number': true, 'maxLength': 4});
common.inputFormat.set($('#devBuyerTel2,#devBuyerTel3'), {'number': true, 'maxLength': 4});
common.inputFormat.set($('.devDeliveryMessage'), {'maxLength': 30});
//배송지 정보
common.inputFormat.set($('.devRecipientName'), {'maxLength': 20});
common.inputFormat.set($('.devRecipientMobile2,.devRecipientMobile3'), {'number': true, 'maxLength': 4});
common.inputFormat.set($('.devRecipientTel2,.devRecipientTel3'), {'number': true, 'maxLength': 4});
//마일리지
common.inputFormat.set($('#devUseMileage'), {'number': true});
//-----set validation
//주문자 정보
common.validation.set($('#devBuyerName'), {'required': true});
common.validation.set($('#devBuyerEmail'), {'required': true, 'dataFormat': 'email'});
common.validation.set($('#devBuyerMobile1,#devBuyerMobile2,#devBuyerMobile3'), {'required': true});
common.validation.set($('#devOrderPassword'), {'required': true, 'dataFormat': 'userPassword'});
common.validation.set($('#devOrderPasswordCompare'), {'required': true, 'compare': '#devOrderPassword'});
//배송지 정보
common.validation.set($('.devRecipientName'), {'required': true});
common.validation.set($('.devRecipientZip,.devRecipientAddr1,.devRecipientAddr2'), {'required': true});
common.validation.set($('.devBuyerMobile1,.devRecipientMobile2,.devRecipientMobile3'), {'required': true});
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
                    var index = self.orderAddressListData.length;
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
    //주문자 정보
    getBuyerData: function () {
        var data = {};
        data.name = $('#devBuyerName').val().trim();
        data.email = $('#devBuyerEmail').val().trim();
        data.mobile = $('#devBuyerMobile1').val().trim() + '-' + $('#devBuyerMobile2').val().trim() + '-' + $('#devBuyerMobile3').val().trim();
        data.tel = $('#devBuyerTel1').val().trim() + '-' + $('#devBuyerTel2').val().trim() + '-' + $('#devBuyerTel3').val().trim();
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
        } else {
            common.validation.set($('.devRecipientName'), {'required': true});
            common.validation.set($('.devRecipientZip,.devRecipientAddr1,.devRecipientAddr2'), {'required': true});
            common.validation.set($('.devBuyerMobile1,.devRecipientMobile2,.devRecipientMobile3'), {'required': true});
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
            } else {
                data.name = $(this).find('.devRecipientName').val().trim();
                data.zip = $(this).find('.devRecipientZip').val().trim();
                data.addr1 = $(this).find('.devRecipientAddr1').val().trim();
                data.addr2 = $(this).find('.devRecipientAddr2').val().trim();
                data.mobile = $(this).find('.devRecipientMobile1').val().trim() + '-' + $(this).find('.devRecipientMobile2').val().trim() + '-' + $(this).find('.devRecipientMobile3').val().trim();
                data.tel = $(this).find('.devRecipientTel1').val().trim() + '-' + $(this).find('.devRecipientTel2').val().trim() + '-' + $(this).find('.devRecipientTel3').val().trim();
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
                    data.product_msg.push({cart_ix: cart_ix, msg: msg});
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
        self.useCouponData = data;
        //마일리지 초기화
        self.setInputMileage(0);
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
        requestData.payment = self.getPaymentData();
        common.ajax(common.util.getControllerUrl('getChangeOrderData', 'order'), requestData, (function () {
        }), (function (response) {
            if (response.result == 'success') {
                self.summaryData = response.data;
                self.changeOrderPrice();
            } else {
                common.noti.alert('error');
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
            } else {
                price = self.summaryData[type];
            }
            $('[devPrice=' + type + ']').text(common.util.numberFormat(price));
        });
    },
    //get 최대 입력할수 있는 마일리지
    getMaxMileage: function () {
        var couponInputVal = 0;
        if ($('#devUseCouponInputText').val().length > 0) {
            couponInputVal = parseInt($('#devUseCouponInputText').val());
        }

        var mileageTargetPrice = parseInt($('#devAllUseMileageCheckBox').attr('devMileageTargetPrice'));
        mileageTargetPrice -= couponInputVal;

        var allUseMileage = parseInt($('#devAllUseMileageCheckBox').attr('devAllUseMileage'));

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
            return parseInt($useMileage.val());
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
                common.noti.alert('error');
            } else {
                self.paymentBool = false;
                common.noti.alert('error');
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
                common.noti.alert('error');
            } else {
                self.paymentBool = false;
                common.noti.alert('error');
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
                common.noti.alert('error');
            } else {
                common.noti.alert('error');
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
            var $deliveryMessageContents = $(this).closest('.devDeliveryMessageContents,.devEachDeliveryMessageContents');
            var devMaxLength = $(this).attr('devMaxLength');
            devMaxLength = (!common.util.isNull(devMaxLength) ? parseInt(devMaxLength) : 0);
            var length = $(this).val().length;
            if (devMaxLength > 0 && devMaxLength < $(this).val().length) {
                length = devMaxLength;
            }
            $deliveryMessageContents.find('.devDeliveryMessageByte').text(length);
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
        //결제 수단 변경
        $('input[name=devPaymentMethod]').click(function (e) {
            $('[devPaymentDescription]:visible').hide();
            $('[devPaymentDescription=' + $(this).val() + ']').show();
        });
        //구매하기
        $('#devPaymentButton').click(function () {
            if (!common.validation.check($('#devPaymentContents'), 'alert', false)) {
                return false;
            }

            var requestData = {};
            requestData.buyer = self.getBuyerData();
            requestData.recipientList = self.getRecipientListData();
            requestData.coupon = self.useCouponData;
            requestData.payment = self.getPaymentData();
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
                            common.noti.alert('error');
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
                        } else if (response.result == 'noFormatMileage') {
                            common.noti.alert(common.lang.get('infoinput.paymentRequest.fail.noFormatMileage', response.data));
                        } else {
                            common.noti.alert('error');
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
    },
    //회원
    memberRun: function () {
        var self = this;

        //배송지 타입 선택시
        $('[devRecipientTypeSelect]').on('click', function () {
            self.recipientType = $(this).attr('devRecipientTypeSelect');
            self.setInputRecipientValidation();
            self.changeOrderData();
        });

        //배송지 변경시
        $('#devOrderAddressListContent').on('click', '.devOrderAddressRadio', function () {
            self.changeOrderData();
        });

        //배송지 관련 리스트
        self.orderAddressList = common.ajaxList();
        self.orderAddressList
                .setLoadingTpl('#devOrderAddressListLoading')
                .setListTpl('#devOrderAddressList')
                .setEmptyTpl('#devOrderAddressListEmpty')
                .setContainer('#devOrderAddressListContent')
                .setForm('#devOrderAddressListForm')
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
                    }
                });

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
        });

        //마일리지 전체 사용
        $('#devAllUseMileageCheckBox').on('click', function () {
            var mileage = 0;
            if ($(this).is(':checked')) {
                mileage = self.getMaxMileage();
            }
            self.setInputMileage(mileage);
            self.changeOrderData();
        });

        //쿠폰 적용
        $('#devUseCouponButton').click(function () {
            common.util.modal.open('ajax', '쿠폰 적용', '/shop/couponPop', {cartIxs: self.getCartIx(), useCouponData: self.useCouponData});
        });
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
                recipientContents.find('.devRecipientMobile1').val(mobile[0]);
                recipientContents.find('.devRecipientMobile2').val(mobile[1]);
                recipientContents.find('.devRecipientMobile3').val(mobile[2]);
                var tel = buyer.tel.split('-');
                recipientContents.find('.devRecipientTel1').val(tel[0]);
                recipientContents.find('.devRecipientTel2').val(tel[1]);
                recipientContents.find('.devRecipientTel3').val(tel[2]);
            } else {
                recipientContents.find('.devRecipientName').val("");
                recipientContents.find('.devRecipientMobile1').val($('select.devRecipientMobile1 option:first').val());
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
});
