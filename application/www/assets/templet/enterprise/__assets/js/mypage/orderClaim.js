"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('claim.cancel.confirm.change', "교환 신청을 취소하시겠습니까?"); //Confirm_39
common.lang.load('claim.cancel.confirm.return', "반품 신청을 취소하시겠습니까?"); //Confirm_41
common.lang.load('common.validation.required.select', "{title}를 선택해 주세요.");
common.lang.load('common.validation.required.text', "{title}를 입력해 주세요."); //Alert_05
common.lang.load('mypage.exchange.confirm', "상품 교환신청을 하시겠습니까?");
common.lang.load('mypage.return.confirm', "상품 반품신청을 하시겠습니까?");

var devOrderClaim = {
    resetFormValidation: function () {
        this.apply.form.find('[' + common.validation._validationAttributeName + ']').each(function () {
            $(this).removeAttr(common.validation._validationAttributeName);
        });
    },
    apply: {
        form: $('#devClaimApplyForm'),
        formValidation: function ($form) {
            // 폼 검증을 리셋한다.
            devOrderClaim.resetFormValidation();

            common.validation.set($('#devClaimMsg'), {'required': true});
            common.validation.set($("select[name=claim_reason]"), {'required': true});

            // 배송업체정보 입력 안함 체크
            if ($('#devDcompnyApplyChk').prop('checked') === false && $('.devSendTypeCls:checked').val() == 1) {
                common.validation.set($('#devQuick,#devInvoiceNo'), {'required': true});
            }
            // 발송방법 체크
            if ($('.devSendTypeCls:checked').val() == 2) {
                common.validation.set($('#devCname'), {'required': true});
                common.validation.set($('#devClaim1Zip,#devClaim1Address1,#devClaim1Address2'), {'required': true});
                common.validation.set($('#devCmobile1,#devCmobile2,#devCmobile3'), {'required': true});
            }

            // 교환폼 검증
            if (devClaimType == 'change') {
                common.validation.set($('#devRname'), {'required': true});
                common.validation.set($('#devClaim2Zip,#devClaim2Address1,#devClaim2Address2'), {'required': true});
                common.validation.set($('#devRmobile1,#devRmobile2,#devRmobile3'), {'required': true});
            }

            if(!common.validation.check($form, 'alert', false)) {
                return false;
            }

            return common.noti.confirm($('#devNextBtn').data('claim') == 'change' ? common.lang.get('mypage.exchange.confirm') : common.lang.get('mypage.return.confirm'));
        },
        initChangeForm: function () {
            var url = ['orderClaim', 'change', 'apply'];

            common.inputFormat.set($('#devCmobile2,#devCmobile3'), {'number': true, 'maxLength': 4});
            common.inputFormat.set($('#devCtel2,#devCtel3'), {'number': true, 'maxLength': 4});
            common.inputFormat.set($('#devRmobile2,#devRmobile3'), {'number': true, 'maxLength': 4});
            common.inputFormat.set($('#devRtel2,#devRtel3'), {'number': true, 'maxLength': 4});

            common.form.init(
                this.form,
                common.util.getControllerUrl(url.join('/'), 'mypage'),
                this.formValidation,
                function (response) {
                    if (response.result == 'success') {
                        location.href = response.data.url;
                    }
                }
            );
        },
        initReturnForm: function () {
            var url = ['orderClaim', 'return', 'apply'];

            common.inputFormat.set($('#devCmobile2,#devCmobile3'), {'number': true, 'maxLength': 4});
            common.inputFormat.set($('#devCtel2,#devCtel3'), {'number': true, 'maxLength': 4});

            common.form.init(
                this.form,
                common.util.getControllerUrl(url.join('/'), 'mypage'),
                this.formValidation,
                function (response) {
                    if (response.result == 'success') {
                        location.href = response.data.url;
                    }
                }
            );
        },
        initEvent: function () {
            var self = this;

            // Claim사유 변경 이벤트
            $('#devClaimReason').on('change', function () {
                if ($(this).find('option:selected').data('type') == 'S') {
                    $('#devDpayType1').prop('checked', false).attr('disabled', true);
                    $('#devDpayType2').prop('checked', true);
                } else {
                    $('#devDpayType1').prop('checked', true).attr('disabled', false);
                    $('#devDpayType2').prop('checked', false);
                }
            });

            // Claim사유 길이 표시
            $('#devClaimMsg').on('keyup', function () {
                $('#devClaimMsgLength').text($(this).val().length);
            });

            // 직접발송시 배송업체 정보 입력 안함 이벤트
            $('#devDcompnyApplyChk').on('click', function () {
                var is_no_data = $(this).prop('checked');

                $('.devClaimDeliveryCls').each(function () {
                    $(this).attr('disabled', is_no_data);
                });
            });

            // 발송 방법 선택 이벤트
            $('.devSendTypeCls').on('click', function () {
                if ($(this).val() == 1) {
                    $('#devDirectDelivery').addClass('active').show();
                    $('#devClaimAdressForm1').removeClass('active').hide();
                    $('#devClaimAdressForm2').removeClass('active').show();
                } else {
                    $('#devClaimAdressForm1').removeClass('active').show();
                    $('#devClaimAdressForm2').removeClass('active').show();
                    $('#devDirectDelivery').removeClass('active').hide();
                }
            });

            // 상품 수거지 주소 찾기 버튼 이벤트
            $('#devClaim1ZipPopupButton').on('click', function () {
                common.util.zipcode.popup(function (response) {
                    $('#devClaim1Zip').val(response.zipcode);
                    $('#devClaim1Address1').val(response.address1);
                });
            });

            // 이전 버튼 이벤트
            $('#devPrevBtn').on('click', function () {
                if (devClaimType == 'change') {
                    var messageTag = 'claim.cancel.confirm.change';
                } else if (devClaimType == 'return') {
                    var messageTag = 'claim.cancel.confirm.return';
                }
                common.noti.confirm(common.lang.get(messageTag), historyBack);
            });

            var historyBack = function () {
                history.go(-1);
            }

            // 다음 버튼 이벤트
            $('#devNextBtn').on('click', function () {
                $(".devOdIxCls").each(function () {
                    var od_ix = $(this).val();
                    if ($(this).is(':checked') !== true) {
                        $('#devClaimCnt' + od_ix).val(0);
                    }
                });
                self.form.submit();
            });

            //송장번호 숫자만
            $(".devClaimDeliveryCls").on("keyup", function () {
                $(this).val($(this).val().replace(/[^0-9]/g, ""));
            });
        },
        initChangeEvent: function () {
            var self = this;

            // 교환상품 받으실 주소 찾기 버튼 이벤트
            $('#devClaim2ZipPopupButton').on('click', function () {
                common.util.zipcode.popup(function (response) {
                    $('#devClaim2Zip').val(response.zipcode);
                    $('#devClaim2Address1').val(response.address1);
                });
            });
        },
        run: function () {
            var self = this;

            // 이벤트 설정
            self.initEvent();
            if (devClaimType == 'change') {
                // 교환 전용 이벤트
                self.initChangeEvent();
                self.initChangeForm();
            } else {
                self.initReturnForm();
            }
        }
    },
    confirm: {
        form: $('#devClaimConfirmForm'),
        initForm: function () {
            var url = ['orderClaim', devClaimType, 'confirm'];

            if ($('#devMethod').val() == '0' || $('#devMethod').val() == '4' || $('#devMethod').val() == '9' || $('#devMethod').val() == '10') {
                common.validation.set($('#devBankCode, #devBankOwner, #devBankNumber'), {'required': true});
            }

            common.form.init(
                this.form,
                common.util.getControllerUrl(url.join('/'), 'mypage'),
                function ($form) {
                    return common.validation.check($form, 'alert', false);
                },
                function (response) {
                    if (response.result == 'success') {
                        location.href = response.data.url;
                    }
                }
            );
        },
        initCommonEvent: function () {
            var self = this;

            // 이전 버튼 이벤트
            $('#devPrevBtn').on('click', function () {
                if (devClaimType == 'change') {
                    var messageTag = 'claim.cancel.confirm.change';
                } else if (devClaimType == 'return') {
                    var messageTag = 'claim.cancel.confirm.return';
                }
                common.noti.confirm(common.lang.get(messageTag), historyBack);
            });

            var historyBack = function () {
                history.go(-1);
            }

            // 다음 버튼 이벤트
            $('#devNextBtn').on('click', function () {
                self.form.submit();
            });
        },
        run: function () {
            var self = this;

            self.initCommonEvent();
            self.initForm();
        }
    },
    complete: {
        initEvent: function () {
            $('#devFineshBtn').on('click', function () {
                location.replace('/mypage/returnHistory');
            });

            $('#devFineshOrderBtn').on('click', function () {
                location.replace('/mypage/orderHistory');
            });
        },
        run: function () {
            this.initEvent();
        }
    }
};
$(function () {
    switch (devClaimStep) {
        case 'confirm':
            devOrderClaim.confirm.run();
            break;
        case 'complete':
            devOrderClaim.complete.run();
            break;
        default:
            devOrderClaim.apply.run();
            break;

    }

    if ($('#devMethod').val() != '0' && $('#devMethod').val() != '4' && $('#devMethod').val() != '9' && $('#devMethod').val() != '10') {
        $('#devInfoBankNumber').hide();
    }

    //전체체크박스 확인
    $(".devOdIxCls").click(function () {
        var max = $(".devOdIxCls").length;
        var cnt = 0;
        $(".devOdIxCls").each(function (k, v) {
            if ($(this).prop("checked"))
                cnt++;
        });

        if (cnt >= max) {
            $("#all_check").prop("checked", true);
        } else {
            $("#all_check").prop("checked", false);
        }
    });
});
