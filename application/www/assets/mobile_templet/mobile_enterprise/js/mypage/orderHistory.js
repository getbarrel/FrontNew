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
common.lang.load('mypage.updateDeliveryComplete.confirm', "배송완료로 상태변경하시겠습니까?"); //[공통] Alert_Confirm 정의_20180322 에 confirm 35 정의되어있지않아 임의지정함
common.lang.load('mypage.updateBuyFinalized.confirm', "구매확정으로 상태변경하시겠습니까?"); //[공통] Alert_Confirm 정의_20180322 에 정의되어있지않아 임의지정함
common.lang.load('mypage.exchange.confirm', "상품 교환신청을 하시겠습니까?");
common.lang.load('mypage.return.confirm', "상품 반품신청을 하시겠습니까?");
common.lang.load('mypage.exchange.deny', "교환신청이 불가능한 상품입니다. 고객센터에 문의해주세요.");
common.lang.load('mypage.return.deny', "반품신청이 불가능한 상품입니다. 고객센터에 문의해주세요.");
common.lang.load('mypage.duplicateCreek.false', "구매확정 프로세스가 진행 중 입니다.");
common.lang.load('mypage.partCancelBool.confirm', "사은품이 포함되어있을경우 전체취소만 가능합니다. \n전체취소를 진행 하시겠습니까?");



var devOrderHistoyObj = {
    orderTpl: false,
    morePopupTpl: false,
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
        return status == 'IC' ;
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
        //ORDER_STATUS_INCOM_COMPLETE || ORDER_STATUS_DELIVERY_ING
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
    isMore: function (item) {
        return item.isIncomeComplate || item.isDeliveryIng || item.isDeliveryComplate || item.isByFinalized;
    },
    exchangeDetail: function (exchageDetailData, orderItemId) {
        var self = this;
        var dItems = [];

        for (var idx = 0; idx < exchageDetailData.length; idx++) {
            exchageDetailData[idx].pt_dcprice = common.util.numberFormat(exchageDetailData[idx].pt_dcprice);
            exchageDetailData[idx].dcprice = common.util.numberFormat(exchageDetailData[idx].dcprice);
            exchageDetailData[idx].listprice = common.util.numberFormat(exchageDetailData[idx].listprice);
            exchageDetailData[idx].isExchangeDetail = true;
            exchageDetailData[idx].orderItemId = orderItemId;
            exchageDetailData[idx].isDeleveryTrace = self.isDeleveryTrace(exchageDetailData[idx].status,exchageDetailData[idx].quick,exchageDetailData[idx].invoice_no);
            exchageDetailData[idx].isIncomeComplate = self.isIncomeComplate(exchageDetailData[idx].status);
            exchageDetailData[idx].isDeliveryIng = self.isDeliveryIng(exchageDetailData[idx].status);
            exchageDetailData[idx].isDeliveryComplate = self.isDeliveryComplate(exchageDetailData[idx].status);
            exchageDetailData[idx].isByFinalized = self.isByFinalized(exchageDetailData[idx].status, exchageDetailData[idx].is_comment);
            exchageDetailData[idx].isMore = self.isMore(exchageDetailData[idx]);

            dItems.push(self.orderTpl(exchageDetailData[idx]));
        }

        return dItems.join('');
    },
    initEvent: function () {
        var self = this;
		

        $('#devBtnSearch').on('click', function () {
            self.ajaxList.getPage(1);
        });

		// 검색일 설정
		/*
        $('#devBtnSearch').on('click', function () {
            $('#devEdate').val($('#devEndDate').val());
            $('#devSdate > option:checked').val($('#devStartDate').val());

            self.ajaxList.getPage(1);
        });
		*/

		$("#devSdate").datepicker({
			monthNames: ['년 1월', '년 2월', '년 3월', '년 4월', '년 5월', '년 6월', '년 7월', '년 8월', '년 9월', '년 10월', '년 11월', '년 12월'],
			dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
			showMonthAfterYear: true,
			dateFormat: 'yy-mm-dd',
			buttonImageOnly: true,
			buttonText: '달력',
			onSelect: function (dateText) {
				if ($('#devEdate').val() != '' && $('#devEdate').val() < dateText) {
					$('#devSdate').val($('#sDateDef').val());
					$('#devEdate').val($('#eDateDef').val());
					common.noti.tailMsg('devEmailId', common.lang.get("joinInput.common.validation.email.doubleCheck"));
					alert('시작일은 종료일 보다 이후일 수 없습니다.');
				}
			}
		});

		$('#devEdate').datepicker({
			monthNames: ['년 1월', '년 2월', '년 3월', '년 4월', '년 5월', '년 6월', '년 7월', '년 8월', '년 9월', '년 10월', '년 11월', '년 12월'],
			dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
			showMonthAfterYear: true,
			dateFormat: 'yy-mm-dd',
			buttonImageOnly: true,
			buttonText: '달력',
			onSelect: function (dateText) {
				if ($('#devSdate').val() != '' && $('#devSdate').val() > dateText) {
					$('#devSdate').val($('#sDateDef').val());
					$('#devEdate').val($('#eDateDef').val());
					common.noti.tailMsg('devEmailId', common.lang.get("joinInput.common.validation.email.doubleCheck"));
					alert('종료일은 시작일 보다 이전일 수 없습니다.');
				}
			}
		});

		// 검색일 설정
		$('.devDateBtn').on('click', function () {
			$('#devSdate').val($(this).data('sdate'));
			$('#devEdate').val($(this).data('edate'));
		});


        // 페이징 버튼 이벤트 설정
		$('.devSortTab').on('click', function () {
			var selectedValue = $("input[name='filterRadio']:checked").val();

			$('#status').val(selectedValue);
            self.ajaxList.getPage(1);
        });

        // 교환상세 토글
        $('#devOrderHistoryContent').on('click', '.devOrderItemToggleBtn', function () {
            $('.' + $(this).data('oitemid')).toggle();
        });

        // More button
        $('#devOrderHistoryContent').on('click', '.devMoreLinkBtn', function () {
            var orderInfo = {
                oid: $(this).data('oid'),
                od_ix: $(this).data('od_ix'),
                brand_name: $(this).data('brand_name'),
                pid: $(this).data('pid'),
                pname: $(this).data('pname'),
                pimg: $(this).data('pimg'),
                option_text: $(this).data('option_text'),
                isDeleveryTrace: $(this).data('dt'),
                isIncomeComplate: $(this).data('ic'),
                isDeliveryIng: $(this).data('di'),
                isDeliveryComplate: $(this).data('dc'),
                isByFinalized: $(this).data('bf'),
                ode_ix: $(this).data('ode_ix'),
                quick: $(this).data('quick'),
                invoice_no: $(this).data('invoice_no')
            };

            common.util.modal.open('html', '주문상태', self.morePopupTpl(orderInfo));
        });

        // 전체취소
        $('#devOrderHistoryContent').on('click', '.devOrderCancelAllBtn', function () {
            location.href = '/mypage/orderCancel?oid=' + $(this).data('oid');
        });

        // 배송완료
        $(document).on('click', '.devOrderComplateBtn', function () {
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

        // 구매확정
        var devBuyFinalizeChk = false;
        $(document).on('click', '.devBuyFinalizedBtn', function () {
            var odIx = $(this).data('odix');
            var oid = $(this).data('oid');

            if(devBuyFinalizeChk == false) {
                common.noti.confirm(common.lang.get('mypage.updateBuyFinalized.confirm', ''), function () {
                    common.ajax(common.util.getControllerUrl('updateBuyFinalized', 'mypage'), {
                        odIx: odIx,
                        oid: oid
                    }, function(){
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

        // 주문취소
        $(document).on('click', '.devOrderCancelBtn', function () {
            //사은품 포함시 부분취소 불가 처리
            var partCancelBool = $(this).data('part_cancel');
            if(partCancelBool === true){
                location.href = '/mypage/orderCancel?oid=' + $(this).data('oid') + '&od_ix=' + $(this).data('odix'); // 부분취소 일시 중지 2019-10-16 -> 부분취소 사용 재개 2020-01-08
            }else{
                if(common.noti.confirm(common.lang.get('mypage.partCancelBool.confirm'))){
                    location.href = '/mypage/orderCancel?oid=' + $(this).data('oid');
                }
            }


        });

        // 교환신청
        $(document).on('click', '.devOrderExchangeBtn', function () {
            var exchangeable = $(this).data('functionable');
            if (exchangeable == 'N') {
                common.noti.alert(common.lang.get('mypage.exchange.deny', ''));
            } else if (common.noti.confirm(common.lang.get('mypage.exchange.confirm'))) {
                location.href = '/mypage/orderClaim/change/apply?oid=' + $(this).data('oid') + '&od_ix=' + $(this).data('odix');
            }
        });
        // 반품신청
        $(document).on('click', '.devOrderReturnBtn', function () {
            var returnable = $(this).data('functionable');
            if (returnable == 'N') {
                common.noti.alert(common.lang.get('mypage.return.deny', ''));
            } else if (common.noti.confirm(common.lang.get('mypage.return.confirm'))) {
                location.href = '/mypage/orderClaim/return/apply?oid=' + $(this).data('oid') + '&od_ix=' + $(this).data('odix');
            }
        });
        // 상품후기 작성
        $(document).on('click', '.devByFinalized', function () {
            var modal_title = '상품 후기 작성';

            if(common.langType == 'english') {
                modal_title = 'Write a review';
            }
            common.util.modal.open('ajax', modal_title, '/shop/goodsReview/' + $(this).data('pid') + '/' + $(this).data('oid') + '/' + $(this).data('odix') + '?mode=write');
        });
        // 배송추적
        $(document).on('click', '.devInvoice', function () {
            var url = '/mypage/searchGoodsFlow/' + $(this).data('quick') + '/' + $(this).data('invoice_no');

            common.util.iframeModal.open('배송추적', url);
            //window.open(url);

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
        self.morePopupTpl = self.ajaxList.compileTpl('#devMorePopup');

        // Template change
        $('#devOrderDetailContent').text('{[{orderDetail}]}');

        // 컨텐츠 랜더링 메소드 리매핑
        self.ajaxList.setContent = function (list, paging) {
            //마지막 페이지 또는 page가 1일때 숨김
            if (paging && (paging.cur_page == paging.last_page || paging.page_list.length <= 1)) {
                this.hidePagination();
            } else {
                this.sowPagination();
            }
            //삭제옵션, 페이지 검색시 1페이지, paging 정보 없을때
            if (this.remove === true || !paging || paging.cur_page == 1) {
                this.removeContent();
                this.setHistoryState('response', null);
            }
            if (list.length > 0) {

                //history 정보에 sate 정보 set
                var currentState = this.getHistoryState('response');
                if (currentState != null) {
                    //list data의 키 찾기
                    var listKeyName = this.getResponseListKeyName(list);
                    this.response.data[listKeyName] = currentState.data[listKeyName].concat(list);
                }
                this.setHistoryState('response', this.response);
                //history 정보에 sate 정보 set

                for (var i = 0; i < list.length; i++) {
                    var row = list[i];
                    var oitems = [];

                    // odeIx reset
                    self.odeIx = false;
                    self.allCancel = true;

                    // order detail
                    for (var idx = 0; idx < row.orderDetail.length; idx++) {
                        // price number_format
                        row.orderDetail[idx].pt_dcprice = common.util.numberFormat(row.orderDetail[idx].pt_dcprice);
                        row.orderDetail[idx].dcprice = common.util.numberFormat(row.orderDetail[idx].dcprice);
                        row.orderDetail[idx].listprice = common.util.numberFormat(row.orderDetail[idx].listprice);
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
                        row.orderDetail[idx].isMore = self.isMore(row.orderDetail[idx]);
                        row.orderDetail[idx].orderItemId = common.crypto.md5(row.orderDetail[idx].od_ix);
                        // allCancel?
                        self.isAllCancel(row.orderDetail[idx].status);

                        oitems.push(self.orderTpl(row.orderDetail[idx]));
                        // 교환상품상세
                        if (row.orderDetail[idx].exchageDetail) {
                            oitems.push(self.exchangeDetail(row.orderDetail[idx].exchageDetail, row.orderDetail[idx].orderItemId));
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
                .setUseHash(true)
                .setRemoveContent(false)
                .setController('orderHistory', 'mypage')
                .init(function (data) {
				console.log(data.data.list);
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

        // 이벤트 바인딩
        self.initEvent();
        // 주문내역 초기화
        self.ajaxInit();
    }
};

$(function () {
    devOrderHistoyObj.run()
});
