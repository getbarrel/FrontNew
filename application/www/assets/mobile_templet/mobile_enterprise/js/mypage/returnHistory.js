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
var devReturnHistoyObj = {
    returnTpl: {},
    ajaxList: common.ajaxList(),
    initEvent: function () {
        var self = this;


		$("[devFilterState]").on('click', function () {
			$("#status").val($(this).attr('devFilterState'));
			self.ajaxList.getPage(1);
		});

        // 선택 검색
        $('#devStatus, #devSdate').on('change', function () {
            self.ajaxList.getPage(1);
        });

		// 검색일 설정
		$('.devDateBtn').on('click', function () {
			$('#devSdate').val($(this).data('sdate'));
			$('#devEdate').val($(this).data('edate'));
		});

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

        // 기간 검색
        $('#devSearch').on('click', function () {
            if($("#devStartDate").val() == ''){
                alert("검색 시작일자를 선택해주세요.");
                return false;
            }
            if($("#devEndDate").val() == ''){
                alert("검색 종료일자를 선택해주세요.");
                return false;
            }

            self.ajaxList.getPage(1);
        });

    },
    ajaxInit: function () {
        var self = this;

        // Template compile
        self.returnTpl.returnProduct = self.ajaxList.compileTpl('#devReturnProduct');
        // Template change
        $('#devOrderDetailContent').text('{[{orderDetail}]}');

        // 컨텐츠 랜더링 메소드 리매핑
        self.ajaxList.setContent = function (list, paging) {
            //마지막 페이지 또는 page가 1일때 숨김
            if(paging && (paging.cur_page == paging.last_page || paging.page_list.length <= 1)){
                this.hidePagination();
            } else {
                this.sowPagination();
            }
            //삭제옵션, 페이지 검색시 1페이지, paging 정보 없을때
            if (this.remove === true || !paging || paging.cur_page == 1) {
                this.removeContent();
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

                    // order detail
                    for (var idx = 0; idx < row.orderDetail.length; idx++) {
                        // price number_format
                        row.orderDetail[idx].pt_dcprice = common.util.numberFormat(row.orderDetail[idx].pt_dcprice);
                        row.orderDetail[idx].dcprice = common.util.numberFormat(row.orderDetail[idx].dcprice);
                        row.orderDetail[idx].listprice = common.util.numberFormat(row.orderDetail[idx].listprice);
                        row.orderDetail[idx].ea_listprice = common.util.numberFormat(row.orderDetail[idx].ea_listprice);
                        oitems.push(self.returnTpl.returnProduct(row.orderDetail[idx]));
                    }

                    row.orderDetail = oitems.join('');

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
            .setLoadingTpl('#devReturnHistoryLoading')
            .setListTpl('#devReturnHistoryList')
            .setEmptyTpl('#devReturnHistoryEmpty')
            .setContainerType('div')
            .setContainer('#devReturnHistoryContent')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devReturnHistoryForm')
            .setUseHash(true)
            .setRemoveContent(false)
            .setController('returnHistory', 'mypage')
            .init(function (data) {
                // for (var idx = 0; idx < data.data.list.length; idx++) {
                //     data.data.list[idx]['claim_date'] = data.data.list[idx]['claim_date'].replace(/-/g,".");
                // }
                self.ajaxList.setContent(data.data.list, data.data.paging);
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
    devReturnHistoyObj.run()
});
