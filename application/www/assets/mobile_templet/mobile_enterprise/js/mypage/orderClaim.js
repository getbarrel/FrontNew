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
common.lang.load('mypage.exchange.confirm', "교환신청을 하시겠습니까?");
common.lang.load('mypage.return.confirm', "반품신청을 하시겠습니까?");
common.lang.load('mypage.exchange.select', "{title}를 선택하세요.");
common.lang.load('mypage.exchange.reason', "{title} 사유를 입력해 주세요.");
common.lang.load('mypage.exchange.address.recent', "교환 받으실 주소를 선택해주세요.");
common.lang.load('mypage.select.quick', "배송업체를 선택해주세요.");
common.lang.load('mypage.input.invoiceno', "송장번호를 입력해주세요.");
common.lang.load('mypage.exchange.validation.select', "{title}을 1개 이상 선택해 주세요.");


var devOrderClaim = {

    //수거 배송지 리스트
    collectAddressList: false,
    //배송지 데이터
    collectAddressListData: false,
    //배송지 리스트
    orderAddressList: false,
    //배송지 데이터
    orderAddressListData: false,

    resetFormValidation: function () {
        this.apply.form.find('[' + common.validation._validationAttributeName + ']').each(function () {
            $(this).removeAttr(common.validation._validationAttributeName);
        });
    },

    apply: {
        form: $('#devClaimApplyForm'),
        formValidation: function ($form) {
            devOrderClaim.resetFormValidation();
            return common.noti.confirm($('#devNextBtn').data('claim') == 'change' ? common.lang.get('mypage.exchange.confirm') : common.lang.get('mypage.return.confirm'));
        },
        setExchangeCodeArea: function () {
            var no = 0;
            var odix = "";
            $(".devBoxOn").each(function () {
                if ($(this).is(":visible") && no == 0) {
                    odix = $(this).data("odix");
                    no++;
                }
            });
            $(".devExchangeCodeArea").each(function () {
                if ($(this).data('odix') == odix) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        },

        initChangeEvent: function () {
            var self = this;
            // 교환상품 받으실 주소 찾기 버튼
            $('#devClaim2ZipPopupButton').on('click', function () {
                common.util.zipcode.popup(function (response) {
                    $('#devClaim2Zip').val(response.zipcode);
                    $('#devClaim2Address1').val(response.address1);
                });
            });
            this.setExchangeCodeArea();
        },

        initReturnEvent: function () {
            var self = this;
            this.setExchangeCodeArea();
        },

        initChangeForm: function () {
            var url = ['orderClaim', 'change', 'apply'];
            common.inputFormat.set($('#devCmobile2,#devCmobile3'), {'number': true, 'maxLength': 4});
            // common.inputFormat.set($('#devCtel2,#devCtel3'), {'number': true, 'maxLength': 4});
            common.inputFormat.set($('#devRmobile2,#devRmobile3'), {'number': true, 'maxLength': 4});
            common.inputFormat.set($('#devRtel2,#devRtel3'), {'number': true, 'maxLength': 4});

            //구매자 주소지는 필수
            common.validation.set($('input[name=rname]'), {'required': true});          //구매자 주소지 * 성명
            common.validation.set($('input[name=rzip]'), {'required': true});           //구매자 주소지 * 우편번호1
            common.validation.set($('input[name=raddr1]'), {'required': true});         //구매자 주소지 * 주소1
            common.validation.set($('input[name=raddr2]'), {'required': true});         //구매자 주소지 * 주소2
            common.validation.set($('input[name=rmobile2]'), {'required': true});       //구매자 주소지 * 휴대전화2
            common.validation.set($('input[name=rmobile3]'), {'required': true});       //구매자 주소지 * 휴대전화3

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

        cntMinus: function (odix) {
            $(".devPcnt").each(function () {
                if ($(this).data('odix') == odix) {
                    var cnt = parseInt($(this).val()) - 1;
                    if (cnt > 0) {
                        $(this).val(cnt);
                    }
                }
            });
        },

        cntPlus: function (odix) {
            $(".devPcnt").each(function () {
                if ($(this).data('odix') == odix) {
                    var ocnt = parseInt($(this).data('ocnt'));
                    var cnt = parseInt($(this).val()) + 1;
                    if (ocnt >= cnt) {
                        $(this).val(cnt);
                    }
                }
            });
        },

        boxOnOff: function (odix) {
            var self = this;

            $(".devBoxOff").each(function () {
                if ($(this).data('odix') == odix) {
                    $(this).toggle();
                }
            });

            $(".devBoxOn").each(function (index,item) {
                if ($(this).data('odix') == odix) {
                    $(this).toggle();
                }
            });

            $(".order-claim__disable").show();
            if ($("li.devBoxOff").filter(":visible").length == 0) {
                $(".order-claim__disable").hide();
            }


            /*
            //첫번째꺼만 devClaimReasonDiv 노출
            $('.devClaimReasonDiv').css('display','none');
            $('.devClaimReasonDiv2').css('display','none');

            $('.devClaimReasonDiv').attr('disabled',false);
            $('.devClaimReasonDiv2').attr('disabled',false);
            var isChange = false;
            $(".devBoxOn").each(function (index, item) {
                if(isChange == false){
                    if(index == 0 && $(this).css('display') == 'list-item'
                        || index != 0 && ($(this).css('display') == 'block' || $(this).css('display') == '')){
                        $('.devClaimReasonDiv').eq(index).css('display','');
                        $('.devClaimReasonDiv2').eq(index).css('display','');

                        $('.devClaimReasonDiv').eq(index).attr('disabled',true);
                        $('.devClaimReasonDiv2').eq(index).attr('disabled',true);
                        isChange = true
                    }
                }
            });
            */

            // 상품 선택 체크
            if($("input[name='claim_cnt["+odix+"]']").filter(':visible').length == 1){
                $("#devOdIx"+odix).attr("checked",true);
            }else{
                $("#devOdIx"+odix).attr("checked",false);
            }

            self.setExchangeCodeArea();
        },


        // 신청시 이벤트
        initEvent: function () {
            var self = this;

            //배송지 목록 팝업 (상품 수거지 주소)
            $('#devCollectAddressListButton').on('click', function (e) {
                var self = devOrderClaim;
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
                                    var index = self.collectAddressListData.length;
                                    addressData.index = index;
                                    self.collectAddressListData[index] = addressData;
                                    self.collectAddressList.setContent(self.collectAddressListData);
                                    $('.devRecipientContents:eq(0) .devOrderAddressRadio:last').prop('checked', true).trigger('click');
                                }
                            });
                    };
                });
            });
            //배송지 목록 팝업 (교환상품 받으실 주소)
            $('#devChangeAddressListButton').on('click', function (e) {
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
                                    var index = self.orderAddressListData.length;
                                    addressData.index = index;
                                    self.orderAddressListData[index] = addressData;
                                    self.orderAddressList.setContent(self.orderAddressListData);
                                    $('.devRecipientContents:eq(0), .devOrderAddressRadio:last').prop('checked', true).trigger('click');
                                }
                            });
                    };
                });
            });


            //배송 요청사항 selectBox 변경
            $('.devDeliveryMessageSelectBox').on('change', function () {
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

            $('#devChangeAddressListContent').on('change', '.info-addr__recent__box', function () {
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

            // 상품 수거지 주소 찾기 버튼 이벤트
            $('#devClaim1ZipPopupButton').on('click', function () {
                common.util.zipcode.popup(function (response) {
                    $('#devClaim1Zip').val(response.zipcode);
                    $('#devClaim1Address1').val(response.address1);
                });
            });


            // *** 취소 수량 증가
            $('.devCntMinus').on('click', function () {
                self.cntMinus($(this).data('odix'));
            });

            // *** 취소 수량 감소
            $('.devCntPlus').on('click', function () {
                self.cntPlus($(this).data('odix'));
            });

            // *** 주문취소 신청/해제
            $(".order-claim__goods__toggle").on('click', function () {
                $("#devClaimItemSec1").show();
                self.boxOnOff($(this).data('odix'));
            });

            // *** 교환/반품 사유(selectbox) 선택시
            $(".devClaimReason").on('change', function(){
                $(".devClaimReason").val($(this).val());
            });

            // 발송 방법 선택 이벤트
            $('.devSendTypeCls').on('click', function () {
                var type = $(this).data('type');
                $('input[name=send_type]').val(type);
                // 필수 항목 처리
                self.setDeliveryAddressValidation(type);

                if (type == 1) {
                    $('#devDirectDelivery').addClass('active').show();
                    $('#devClaimAdressForm').removeClass('active').hide();
                    $('#devMethod1').addClass('active').show();
                    $('#devMethod2').removeClass('active').hide();
                } else {
                    $('#devClaimAdressForm').removeClass('active').show();
                    $('#devDirectDelivery').removeClass('active').hide();
                    $('#devMethod1').removeClass('active').hide();
                    $('#devMethod2').addClass('active').show();
                }
            });

            // 직접발송시 배송업체 정보 입력 안함 이벤트
            $('.devSelectDeliveryInfo').on('click', function () {
                var type = $(this).data('type');
                if (type == 1) {
                    $('#devSelectDeliveryInfo1').addClass('on');
                    $('#devSelectDeliveryInfo2').removeClass('on');
                    $('input[name=quick_info]').val('');
                    $('#devDeliveryInfo').addClass('active').show();
                } else {
                    $('#devSelectDeliveryInfo1').removeClass('on');
                    $('#devSelectDeliveryInfo2').addClass('on');
                    $('input[name=quick_info]').val('N');
                    $('#devDeliveryInfo').removeClass('active').hide();
                }
            });

            // 배송비 선불 착불 여부
            $('.devPayType').on('click', function () {
                var type = $(this).data('type');
                $('input[name=delivery_pay_type]').val(type);
                if ($("#devClaimReason option:selected").attr("data-type") != "S") {
                    if (type == 1) {
                        $('#devPayType1').addClass('on');
                        $('#devPayType2').removeClass('on');
                    } else {
                        $('#devPayType1').removeClass('on');
                        $('#devPayType2').addClass('on');
                    }
                } else {
                    $('#devPayType1').removeClass('on');
                    $('#devPayType2').addClass('on');
                }
            });

            // Claim사유 변경 이벤트
            $('#devClaimReason').on('change', function () {
                if ($(this).find('option:selected').data('type') == 'S') {
                    $('input[name=delivery_pay_type]').val(2);
                    $('#devPayType1').removeClass('on');
                    $('#devPayType2').addClass('on');
                } else {
                    $('input[name=delivery_pay_type]').val(1);
                    $('#devPayType1').addClass('on');
                    $('#devPayType2').removeClass('on');
                }
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


            // *** 교환 신청
            $('#devNextBtn').on('click', function () {

                var ckPass = true;
                // 필수 항목 처리
                self.setDeliveryAddressValidation($("input[name='send_type']").val());

                // 교환상품 1개 이상 선택
                if ($(".devClaimReason").filter(":visible").length == 0) {
                    common.noti.alert(common.lang.get('mypage.exchange.validation.select', {title: $("#devTitle").text()}));
                    return false;
                }

                // 교환사유 1개 이상 입력 필수
                $(".devClaimReason").filter(":visible").each(function () {
                    if ($(this).val() == '') {
                        ckPass = false;
                        common.noti.alert(common.lang.get('mypage.exchange.select', {title: $(this).attr("title")}));
                        return false;
                    }
                });

                if (ckPass) {

                    // 취소 사유 입력 1개 이상 필수
                    if ($(".devCcMsg").filter(":visible").filter(function () {return $(this).val();}).length == 0) {
                        common.noti.alert(common.lang.get('mypage.exchange.reason', {title: $("#devTitle").data("claimtypetext")}));
                        return false;
                    }

                    // 1. 직접 발송시 배송업체, 송장번호 입력 체크
                    if ($("input[name='send_type']").val() == '1' && $("#devSelectDeliveryInfo1").is(":checked")) {

                        if ($("#devQuick").val() == "") {
                            common.noti.alert(common.lang.get('mypage.select.quick'));  // 배송 업체
                            return false;
                        }

                        if ($("#devInvoiceNo").val() == "") {
                            common.noti.alert(common.lang.get('mypage.input.invoiceno')); // 송장 번호
                            return false;
                        }
                    }

                    // 2. 지정 택배
                    // 배송지 리스트 선택시
                    if ($("input[name='send_type']").val() == '2' && $("#collect_address_type1").hasClass("br__tabs__btn--active")) {
                        // 선택된 최근배송지 존재여부
                        if ($("input:radio[name='orderCAddress']").filter(":visible").filter(":checked").length == 0) {
                            common.noti.alert(common.lang.get('mypage.exchange.address.recent'));
                            return false;
                        }else{
                            self.setDeliveryAddress('collect');
                        }
                    }

                    // 3. 교환상품 받으실 주소 (공통)
                    // 배송지 리스트 선택시
                    if ($("#address_type1").hasClass("br__tabs__btn--active")) {

                        // 선택된 최근배송지 존재여부
                        if ($("input:radio[name='orderRAddress']").filter(":visible").filter(":checked").length == 0) {
                            common.noti.alert(common.lang.get('mypage.exchange.address.recent'));
                            return false;
                        }else{
                            self.setDeliveryAddress('exchange');
                        }
                    }

                    if (!common.validation.check($('#devClaimApplyForm'), 'alert', false)) {
                        return false;
                    }

                    self.form.submit();
                }
            });

            //송장번호 숫자만
            $(".devClaimDeliveryCls").on("keyup", function () {
                $(this).val($(this).val().replace(/[^0-9]/g, ""));
            });

            $("#send_type_2").on('click', function () {
                self.initCollectDelivery();
            });
        },

        // 최근 배송지 선택 처리 : (collect: 상품수거지주소), (exchange:교환상품받을주소)
        setDeliveryAddress: function(type){

            if(type == 'collect'){
                var orderAddress = $("input[name='orderCAddress']:checked");
                $("input[name='cname']").val(orderAddress.data("rname"));
                $("input[name='czip']").val(orderAddress.data("zipcode"));
                $("input[name='caddr1']").val(orderAddress.data("address1"));
                $("input[name='caddr2']").val(orderAddress.data("address2"));

                var cmobile = orderAddress.data("mobile").split('-');
                if (cmobile != '' && cmobile != undefined) {

                    $("select[name='cmobile1']").val(cmobile['0']);
                    $("input[name='cmobile2']").val(cmobile['1']);
                    $("input[name='cmobile3']").val(cmobile['2']);
                }

                $("input[name='cmsg']").val($("input[name='cmsg_list']").val());

            }else{
                var orderAddress = $("input[name='orderRAddress']:checked");
                $("input[name='rname']").val(orderAddress.data("rname"));
                $("input[name='rzip']").val(orderAddress.data("zipcode"));
                $("input[name='raddr1']").val(orderAddress.data("address1"));
                $("input[name='raddr2']").val(orderAddress.data("address2"));
                var rmobile = orderAddress.data("mobile").split('-');

                if (rmobile != '' && rmobile != undefined) {
                    $("select[name='rmobile1']").val(rmobile['0']);
                    $("input[name='rmobile2']").val(rmobile['1']);
                    $("input[name='rmobile3']").val(rmobile['2']);
                }

                $("input[name='rmsg']").val($("input[name='rmsg_list']").val());

            }
        },

        setDeliveryAddressValidation: function(send_type) {

            // 직접 발송
            if(send_type == '1'){
                common.validation.set($('input[name=cname]'), {'required': false});          //수거지 주소지 * 성명
                common.validation.set($('input[name=czip]'), {'required': false});           //수거지 주소지 * 우편번호1
                common.validation.set($('input[name=caddr1]'), {'required': false});         //수거지 주소지 * 주소1
                common.validation.set($('input[name=caddr2]'), {'required': false});         //수거지 주소지 * 주소2
                common.validation.set($('input[name=cmobile2]'), {'required': false});       //수거지 주소지 * 휴대전화2
                common.validation.set($('input[name=cmobile3]'), {'required': false});       //수거지 주소지 * 휴대전화3
            // 지정택배 발송
            }else{
                common.validation.set($('input[name=cname]'), {'required': true});          //수거지 주소지 * 성명
                common.validation.set($('input[name=czip]'), {'required': true});           //수거지 주소지 * 우편번호1
                common.validation.set($('input[name=caddr1]'), {'required': true});         //수거지 주소지 * 주소1
                common.validation.set($('input[name=caddr2]'), {'required': true});         //수거지 주소지 * 주소2
                common.validation.set($('input[name=cmobile2]'), {'required': true});       //수거지 주소지 * 휴대전화2
                common.validation.set($('input[name=cmobile3]'), {'required': true});       //수거지 주소지 * 휴대전화3
            }
        },


        // *** 교환 받을 주소: 최근배송지 조회
        initChangeDelivery: function () {
            var self = this;

            //배송지 관련 리스트
            self.orderAddressList = common.ajaxList();
            self.orderAddressList
                .setLoadingTpl('#devChangeAddressListLoading')
                .setListTpl('#devChangeAddressList')
                .setEmptyTpl('#devChangeAddressListEmpty')
                .setContainer('#devChangeAddressListContent')
                .setForm('#devChangeAddressListForm')
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
        },


        // *** 상품수거지 : 최근배송지 조회
        initCollectDelivery: function () {
            var self = devOrderClaim;

            /*if (self.collectAddressList === false) {
                //배송지 관련 리스트
                self.collectAddressList = common.ajaxList();
                self.collectAddressList
                    .setLoadingTpl('#devCollectAddressListLoading')
                    .setListTpl('#devCollectAddressList')
                    .setEmptyTpl('#devCollectAddressListEmpty')
                    .setContainer('#devCollectAddressListContent')
                    .setForm('#devCollectAddressListForm')
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
                            self.collectAddressListData = list;
                            self.collectAddressList.setContent(list);

                            $('.devOrderAddressRadio:first').prop('checked', true);
                            $('[devRecipientTypeSelect=address]').trigger('click');
                        } else {
                            $('[devRecipientTypeSelect=input]').trigger('click');
                            //배송지없으면 신규 배송지 선택만 가능하도록 처리
                            $('[devRecipientTypeSelect=address]').unbind('click');
                        }
                    });

                $("#devCollectAddressListForm").submit();
            }*/
        },


        run: function () {
            var self = this;
            // 이벤트 설정
            self.initEvent();
            if (devClaimType == 'change') {
                // 교환 전용 이벤트
                self.initChangeEvent();
                self.initChangeForm();
                if(common.langType == 'korean'){
                    self.initChangeDelivery();
                }
            } else {
                self.initReturnForm();
                self.initReturnEvent();
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

    if ($('#devInfoType').val() == '카드' || $('#devInfoType').val() == '휴대폰결제') {
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