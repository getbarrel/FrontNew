"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('coupon.invalid.msg', "상품 금액 보다 쿠폰 적용 금액이 커서 쿠폰적용이 불가합니다.");
common.lang.load('coupon.productOverlapUseYn.confirm', "해당 쿠폰 사용 시 상품쿠폰 적용이 불가능합니다. 적용하시겠습니까?");
common.lang.load('coupon.orderMethod.alert', "{orderMethod}로 결제하셔야 쿠폰 적용이 가능합니다.");
common.lang.load('deliveryCoupon.invalid.msg', "배송 금액 보다 쿠폰 적용 금액이 커서 쿠폰적용이 불가합니다.");

var devCouponPopObj = {
    firstInitCartCoupon: false,
    check_minus_check: function () {
        var discount = 0;
        $(".mus").each(function (k, v) {
            discount = parseInt($(this).text());
            if (discount <= 0) {
                $(this).prev().hide();
            } else {
                $(this).prev().show();
            }
        });

        if (parseInt($("#devTotalCouponDiscountAmount").text()) <= 0) {
            $("#tot_discount").hide();
        } else {
            $("#tot_discount").show();
        }
    },
    check_select_cupon: function () {
        //일단 전체 숨김
        $('.coupon_cancel_cu').hide();
        $('.coupon_cancel_cart').hide();

        //상품 쿠폰 셀렉트 박스들을 전체 검색
        var cupon_select_opt = null;
        var cupon_select_id = null;
        $('.cupon_select').each(function (k, v) {
            cupon_select_id = $(this).data("id");
            if ($(this).find(' option:selected').val()) {
                //값이 있는 것만 취소 버튼 활성화
                $('#cupon_cancel' + cupon_select_id).show();
            }
        });

        //카트 쿠폰은 전체 취소.. 1개만 있음
        $('.coupon_cancel_cart').hide();

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
    getDeliveryCouponInfoBySelect: function () {
        var $checkedOption = $('select[devDeliveryCouponSelect]').find('option:selected');
        var registIx = $checkedOption.val();
        var totalCouponWithDcprice = $checkedOption.attr('devTotalCouponWithDcprice');
        var discountAmount = $checkedOption.attr('devDiscountAmount');
        var productOverlapUseYn = $checkedOption.attr('devProductOverlapUseYn');
        var paymentMethod = $checkedOption.attr('devPaymentMethod');
        return {
            cartIx: 'deliveryCoupon',
            registIx: registIx,
            totalCouponWithDcprice: totalCouponWithDcprice,
            discountAmount: discountAmount,
            productOverlapUseYn: productOverlapUseYn,
            paymentMethod: paymentMethod
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
    changeDeliveryPriceText: function () {
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

        var delivertDisAmount = 0;
        if ($('select[devDeliveryCouponSelect]').val() != '') {
            delivertDisAmount = $('select[devDeliveryCouponSelect] option:selected').attr('devDiscountAmount');
        }

        var totalDeliveryPrice = $('#devTotalDeliveryPrice').val();

        var devTotalCouponWithProductDcprice = common.math.sub(totalDeliveryPrice, totalDiscountAmount);

        totalDiscountAmount = common.math.add(totalDiscountAmount, delivertDisAmount);

        var totalDeliveryPriceCheck = common.math.sub(totalDeliveryPrice, totalDiscountAmount);

        if (totalDeliveryPriceCheck < 0) {
            common.noti.alert(common.lang.get('deliveryCoupon.invalid.msg'));
            $('select[devDeliveryCouponSelect]').val('');
            return false;
        }

        $('#devTotalCouponWithProductDcpriceFloat').val(devTotalCouponWithProductDcprice);
        $('#devTotalCouponDiscountAmount').text(common.util.numberFormat(totalDiscountAmount));
        $('#devTotalCouponWithProductDcprice').text(common.util.numberFormat(common.math.sub(totalDeliveryPrice, totalDiscountAmount)));
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
        $('.devCouponCancel').trigger('click');
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
    run: function () {
        var self = this;

        self.check_select_cupon();

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

        //배송비 쿠폰적용
        $('#devApplyDeliveryCouponButton').click(function () {
            var useDeliveryData = {};

            if ($('select[devDeliveryCouponSelect]').val()) {
                useDeliveryData["delivery"] = $('select[devDeliveryCouponSelect]').val();
                devInfoinputObj.setUseDeliveryCouponData(useDeliveryData)
            }

            $('#devCouponCancelButton').trigger('click');
        });

        //취소
        $('#devCouponCancelButton').click(function () {
            $('.popup-layout .close').trigger('click');
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

        //배송비 쿠폰 선택
        $('select[devDeliveryCouponSelect]').change(function () {
            var data = self.getDeliveryCouponInfoBySelect();
            if (data.totalCouponWithDcprice < 0) {
                common.noti.alert(common.lang.get('deliveryCoupon.invalid.msg'));
                $('select[devDeliveryCouponSelect]').val('');
                $('.devCouponCancel').trigger('click');
                return false;
            }

            var couponCheckPaymentMethodBool = true;

            if (couponCheckPaymentMethodBool && $("select[devCouponSelect] option[devPaymentMethod][devPaymentMethod!='']:selected").length == 0) {
                self.checkPaymentMethod();
            }
            self.changeDeliveryPriceText();
            //self.check_minus_check();
        });
    }
}

$(function () {
    devCouponPopObj.run();
    $('select[devCouponSelect]').trigger('change');
    devCouponPopObj.firstInitCartCoupon = true;
});

