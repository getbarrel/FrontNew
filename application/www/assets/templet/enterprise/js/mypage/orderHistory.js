"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

$(function () {
    $('.detail-view-btn').on('click', function () {
        $(this).parents().next('.change-product-detail').toggle();
    });
});
/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('mypage.updateDeliveryComplete.confirm', "해당 상품을 배송완료로 변경하시겠습니까?"); //[공통] Alert_Confirm 정의_20180322 에 confirm 35 정의되어있지않아 임의지정함
common.lang.load('mypage.updateBuyFinalized.confirm', "구매확정으로 상태변경하시겠습니까?"); //[공통] Alert_Confirm 정의_20180322 에 정의되어있지않아 임의지정함
common.lang.load('mypage.invalidDate.alert', "날짜 형식이 잘못되었습니다."); // 임의지정함
common.lang.load('mypage.wrongStartDate.alert', "시작일과 종료일을 다시 확인해주세요.");
common.lang.load('mypage.wrongDateRange.alert', "최대 5년 내 내역까지만 조회 가능합니다.");
common.lang.load('mypage.exchange.confirm', "상품 교환신청을 하시겠습니까?");
common.lang.load('mypage.return.confirm', "상품 반품신청을 하시겠습니까?");
common.lang.load('mypage.exchange.deny', "교환신청이 불가능한 상품입니다. 고객센터에 문의해주세요.");
common.lang.load('mypage.return.deny', "반품신청이 불가능한 상품입니다. 고객센터에 문의해주세요.");
common.lang.load('mypage.duplicateCreek.false', "구매확정 프로세스가 진행 중 입니다.");
common.lang.load('mypage.partCancelBool.confirm', "사은품이 포함되어있을경우 전체취소만 가능합니다. \n전체취소를 진행 하시겠습니까?");


var devOrderHistoyObj = {
    orderTpl: false,
    odeIx: false,
    allCancel: true,
    ajaxList: common.ajaxList(),
    isOrder: function (odeIx) {
        // 배송 정책별 묶기
        if (this.odeIx === false) {
            this.odeIx = odeIx;
        } else if (odeIx != this.odeIx) {
            this.odeIx = odeIx;
            return true;
        }

        return false;
    },
    isAllCancel: function (status) {
        this.allCancel = this.allCancel && (status == 'IC' || status == 'IR')
        return this.allCancel;
    },
    isExchange: function (status) {
        //ORDER_STATUS_EXCHANGE_ING
        return status == 'EY' || status == 'EI' || status == 'ED' || status == 'ET' || status == 'EF' || status == 'EM' || status == 'EC';
    },
    isIncomeComplate: function (status) {
        //ORDER_STATUS_INCOM_COMPLETE
        return status == 'IC';
    },
    isDeliveryComplate: function (status) {
        //ORDER_STATUS_DELIVERY_COMPLETE
        return status == 'DC';
    },
    isDeliveryIng: function (status) {
        //ORDER_STATUS_DELIVERY_ING
        return status == 'DI';
    },
    isDeleveryTrace: function (status,quick,invoice_no) {
        //ORDER_STATUS_DELIVERY_ING || ORDER_STATUS_EXCHANGE_DELIVERY
        if(status == 'DI' || status == 'DC' || status == 'BF'){
            if(quick && invoice_no){
                return true;
            }
        }
        return false;
    },
    isByFinalized: function (status, isComment) {
        //ORDER_STATUS_BUY_FINALIZED
        return status == 'BF';
    },
    exchangeDetail: function (exchangeDetailData, exKey) {
        var self = this;
        var dItems = [];
        for (var idx = 0; idx < exchangeDetailData.length; idx++) {
            exchangeDetailData[idx].pt_dcprice = common.util.numberFormat(exchangeDetailData[idx].pt_dcprice);
            exchangeDetailData[idx].dcprice = common.util.numberFormat(exchangeDetailData[idx].dcprice);
            exchangeDetailData[idx].listprice = common.util.numberFormat(exchangeDetailData[idx].listprice);
            exchangeDetailData[idx].ea_listprice = common.util.numberFormat(exchangeDetailData[idx].ea_listprice);
            exchangeDetailData[idx].isExchangeDetail = true;
            exchangeDetailData[idx].exKey = exKey;
            exchangeDetailData[idx].isDeleveryTrace = self.isDeleveryTrace(exchangeDetailData[idx].status,exchangeDetailData[idx].quick,exchangeDetailData[idx].invoice_no);
            exchangeDetailData[idx].isIncomeComplate = self.isIncomeComplate(exchangeDetailData[idx].status);
            exchangeDetailData[idx].isDeliveryIng = self.isDeliveryIng(exchangeDetailData[idx].status);
            exchangeDetailData[idx].isDeliveryComplate = self.isDeliveryComplate(exchangeDetailData[idx].status);
            exchangeDetailData[idx].isByFinalized = self.isByFinalized(exchangeDetailData[idx].status, exchangeDetailData[idx].is_comment);
            dItems.push(self.orderTpl(exchangeDetailData[idx]));
        }

        return dItems.join('');
    },
    initEvent: function () {
        var self = this;
        // 검색일 설정
        // $('.devDateBtn').on('click', function () {
        //     $('#devSdate').val($(this).data('sdate'));
        //     $('#devEdate').val($(this).data('edate'));
        // });

        // // 검색조건 리셋
        // $('#devSearchInitBtn').on('click', function () {
        //     $('.devDateBtn').removeClass('on');
        //     $('#devDateDefault').addClass('on');
        //     $('#devSdate').val($(this).data('sdate'));
        //     $('#devEdate').val($(this).data('edate'));
        //     $('#devStatus').val('all');
        //     $('#devPname').val('');
        // });

        // 페이징 버튼 이벤트 설정
		$('.devSortTab').on('click', function () {
			var selectedValue = $(this).data('status');
			 $(this).addClass("active");
			$(this).siblings().removeClass("active");
			$('#status').val(selectedValue);
            self.ajaxList.getPage(1);
        });

        // 검색
        $('#devSearchBtn').on('click', function () {
            var endDate = common.util.dates.convert($('#devEdate').val());
            var startDate = common.util.dates.convert($('#devSdate').val());
            var maxDate = common.util.dates.convert((startDate.getFullYear() + 5) + '-' + (startDate.getMonth() + 1) + '-' + startDate.getDate());
            var today = new Date();
            var dd = today.getDate();
            var Smm = today.getMonth();
            var Emm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (Smm < 10) {
                Smm = '0' + Smm;
            }
            if (Emm < 10) {
                Emm = '0' + Emm;
            }
            var resetStartDate = yyyy + '-' + Smm + '-' + dd;
            var resetEndDate = yyyy + '-' + Emm + '-' + dd;
            if (startDate != 'Invalid Date' && endDate != 'Invalid Date') {
                if (common.util.dates.compare(startDate, endDate) == 1) {
                    common.noti.alert(common.lang.get('mypage.wrongStartDate.alert'));
                    //날짜초기화
                    $('#devSdate').val(resetStartDate);
                    $('#devEdate').val(resetEndDate);
                    return false;
                } else if (common.util.dates.compare(endDate, maxDate) == 1) {
                    common.noti.alert(common.lang.get('mypage.wrongDateRange.alert'));
                    return false;
                }

                self.ajaxList.getPage(1);
            } else {
                common.noti.alert(common.lang.get('mypage.invalidDate.alert'));
            }
        });
        // 전체취소
        $('#devOrderHistoryContent').on('click', '.devOrderCancelAllBtn', function () {
            location.href = '/mypage/orderCancel?oid=' + $(this).data('oid');
        });
        // 주문취소
        $('#devOrderHistoryContent').on('click', '.devOrderCancelBtn', function () {
            var partCancelBool = $(this).data('part_cancel');
            if(partCancelBool === true){
                location.href = '/mypage/orderCancel?oid=' + $(this).data('oid') + '&od_ix=' + $(this).data('odix');
            }else{
                if(common.noti.confirm(common.lang.get('mypage.partCancelBool.confirm'))){
                    location.href = '/mypage/orderCancel?oid=' + $(this).data('oid');
                }
            }

        });
        // 배송완료
        $('#devOrderHistoryContent').on('click', '.devOrderComplateBtn', function () {
            var odIx = $(this).data('odix');
            var oid = $(this).data('oid');
            common.noti.confirm(common.lang.get('mypage.updateDeliveryComplete.confirm', ''), function () {
                common.ajax(common.util.getControllerUrl('updateDeliveryComplete', 'mypage'), {odIx: odIx, oid: oid}, "", function (result) {
                    if (result.result == 'success') {
                        document.location.reload();
                    }
                });
            });
        });
        // 교환신청
        $('#devOrderHistoryContent').on('click', '.devOrderExchangeBtn', function () {
            var exchangeable = $(this).data('functionable');
            if (exchangeable == 'N') {
                common.noti.alert(common.lang.get('mypage.exchange.deny', ''));
            } else if (common.noti.confirm(common.lang.get('mypage.exchange.confirm'))) {
                location.href = '/mypage/orderClaim/change/apply?oid=' + $(this).data('oid') + '&od_ix=' + $(this).data('odix');
            }
        });
        // 반품신청
        $('#devOrderHistoryContent').on('click', '.devOrderReturnBtn', function () {
            var returnable = $(this).data('functionable');
            if (returnable == 'N') {
                common.noti.alert(common.lang.get('mypage.return.deny', ''));
            } else if (common.noti.confirm(common.lang.get('mypage.return.confirm'))) {
                location.href = '/mypage/orderClaim/return/apply?oid=' + $(this).data('oid') + '&od_ix=' + $(this).data('odix');
            }
        });
        // 구매확정
        var devBuyFinalizeChk = false;
        $('#devOrderHistoryContent').on('click', '.devBuyFinalizedBtn', function () {
            var odIx = $(this).data('odix');
            var oid = $(this).data('oid');

            if(devBuyFinalizeChk == false){
                common.noti.confirm(common.lang.get('mypage.updateBuyFinalized.confirm', ''), function () {
                    common.ajax(common.util.getControllerUrl('updateBuyFinalized', 'mypage'), {odIx: odIx, oid: oid}
                    , function(){
                        devBuyFinalizeChk = true
                    } , function (result) {
                        if (result.result == 'success') {
                            document.location.reload();
                        }
                    });
                });
            }else{
                common.noti.alert(common.lang.get('mypage.duplicateCreek.false'));
                return false;
            }

        });
        // 상품후기 작성
        $('#devOrderHistoryContent').on('click', '.devByFinalized', function () {
            var url = '/shop/goodsReview/' + $(this).data('pid') + '/' + $(this).data('oid') + '/' + $(this).data('odeix') + '?mode=write';
            //common.util.popup(url, 800, 1000);
            common.util.popup(url, 800, 1000, '상품후기 작성', scroll);
        });
        $('#devOrderHistoryContent').on('click', '.devEcDetailToggleBtn', function () {
            var $this = $(this);
            var exkey = $this.data('exkey');
            $this.toggleClass("open");
            $('.devEcDetail' + exkey).toggle();
        });
        $('#devOrderHistoryContent').on('click', '.devInvoice', function () {
            var url = '/mypage/searchGoodsFlow/' + $(this).data('quick') + '/' + $(this).data('invoice_no');
            //common.util.popup(url, 800, 1000);
            common.util.popup(url, 800, 1000, '배송 추적', scroll);
        });
    },
    cremaTimer: null,
    cremaRecursiveCall: function () {
        var self = this;
        //console.log("[CREMA] crema.init() - EXECUTED!");
        if (typeof crema === "object") {
            setTimeout(function () {
                crema.run();
                //console.log("[CREMA] crema.run() - EXECUTED!");
                clearInterval(self.cremaTimer);
            }, 500);
        }
    },
    ajaxInit: function () {
        var self = this;
        // Template compile
        self.orderTpl = self.ajaxList.compileTpl('#devOrderDetailProduct');
        // Template change
        $('#devOrderDetailContent').text('{[{orderDetail}]}');
        // 컨텐츠 랜더링 메소드 리매핑
        self.ajaxList.setContent = function (list, paging) {
            this.removeContent();
            if (list.length > 0) {
                for (var i = 0; i < list.length; i++) {
                    var row = list[i];
                    var oitems = [];
                    // odeIx reset
                    self.odeIx = false;
                    self.allCancel = true;
                    // order detail
                    for (var idx = 0; idx < row.orderDetail.length; idx++) {
                        console.log(row.orderDetail);
                        // price number_format
                        row.orderDetail[idx].pt_dcprice = common.util.numberFormat(row.orderDetail[idx].pt_dcprice);
                        row.orderDetail[idx].dcprice = common.util.numberFormat(row.orderDetail[idx].dcprice);
                        row.orderDetail[idx].listprice = common.util.numberFormat(row.orderDetail[idx].listprice);
                        row.orderDetail[idx].ea_listprice = common.util.numberFormat(row.orderDetail[idx].ea_listprice);
                        row.orderDetail[idx].isOther = self.isOrder(row.orderDetail[idx].ode_ix);
                        row.orderDetail[idx].isExchange = self.isExchange(row.orderDetail[idx].status);
                        row.orderDetail[idx].isDeleveryTrace = self.isDeleveryTrace(row.orderDetail[idx].status);
                        row.orderDetail[idx].isIncomeComplate = self.isIncomeComplate(row.orderDetail[idx].status);

						if(row.orderDetail[idx].is_method == 9){
							row.orderDetail[idx].isMethod = true;
						} else {
							row.orderDetail[idx].isMethod = false;
						}

                        row.orderDetail[idx].isDeliveryIng = self.isDeliveryIng(row.orderDetail[idx].status);
                        row.orderDetail[idx].isDeliveryComplate = self.isDeliveryComplate(row.orderDetail[idx].status);
                        row.orderDetail[idx].isByFinalized = self.isByFinalized(row.orderDetail[idx].status, row.orderDetail[idx].is_comment);
                        row.orderDetail[idx].isExchangeToggle = (row.orderDetail[idx].exchageDetail ? true : false);
                        row.orderDetail[idx].exKey = i + '-' + idx;
                        // allCancel?
                        self.isAllCancel(row.orderDetail[idx].status);
                        oitems.push(self.orderTpl(row.orderDetail[idx]));
                        // 교환상품상세
                        if (row.orderDetail[idx].exchageDetail) {
                            oitems.push(self.exchangeDetail(row.orderDetail[idx].exchageDetail, row.orderDetail[idx].exKey));
                        }
                    }

                    row.orderDetail = oitems.join('');
                    row.isAllCancel = self.allCancel;
                    $(this.container).append(this.listTpl(row));
                }

                if (paging) {
                    $(this.pagination).html(common.pagination.getHtml(paging));
                }
            } else {
                $(this.container).append(this.emptyTpl());
            }
        };

        // 주문내역 설정
        self.ajaxList
                .setLoadingTpl('#devOrderHistoryLoading')
                .setListTpl('#devOrderHistoryList')
                .setEmptyTpl('#devOrderHistoryEmpty')
                .setContainerType('div')
                .setContainer('#devOrderHistoryContent')
                .setPagination('#devPageWrap')
                .setPageNum('#devPage')
                .setForm('#devOrderHistoryForm')
                .setGotoTop(500)
                .setUseHash(true)
                .setController('orderHistory', 'mypage')
                .init(function (data) {
                    self.ajaxList.setContent(data.data.list, data.data.paging);    
                    //크리마 오브젝트 인터벌
                    self.cremaTimer = setInterval(self.cremaRecursiveCall(), 1000);
                });
        // 페이징 버튼 이벤트 설정
        $('#devPageWrap').on('click', '.devPageBtnCls', function () {
            self.ajaxList.getPage($(this).data('page'));
        });
    },
    run: function () {
        var self = this;
		// 2023-12-08 개발필요 주석
        // 이벤트 바인딩
        self.initEvent();
        // 주문내역 초기화
        self.ajaxInit();
    }
};

$(function () {
    devOrderHistoyObj.run();
});
