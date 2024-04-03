"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
$(function () {
    //var $document = $(document);
    //$document.on("click", ".detail-link", function() {
    //    var requestData = {};
    //    requestData['bbs_ix'] = $(this).attr('devbbsix');
    //    common.util.modal.open('ajax', '상품 문의 내역', '/mypage/my_goods_inquiry_detail.php',requestData);
    //});
    // $('.detail-link').click(function () {
    //     alert();
    //     common.util.modal.open('ajax', '상품 문의 내역', '/mypage/my_goods_inquiry_detail.php');
    // });
});

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('mypage.invalidDate.alert', "날짜 형식이 잘못되었습니다.");
common.lang.load('mypage.wrongStartDate.alert', "시작일은 종료일 보다 이후일 수 없습니다.");
common.lang.load('mypage.wrongDateRange.alert', "최대 5년 내 내역까지만 조회 가능합니다.");

$(function () {

    var myGoodsInquiryList = common.ajaxList();
    myGoodsInquiryList
        .setContainer('#devMyContent')
        .setLoadingTpl('#devMyLoading')
        .setListTpl('#devMyList')
        .setEmptyTpl('#devMyListEmpty')
        .setContainerType('div')
        .setPagination('#devPageWrap')
        .setPageNum('#devPage')
        .setForm('#devMyGoodsInquiryForm')
        .setController('myGoodsInquiryList', 'mypage')
        .init(function (data) {
			/*
            $("#devTotal").text(data.data.total);

            if ((data.data.list).length > 0) {
                for (var i = 0; i < (data.data.list).length; i++) {
                    if (data.data.list[i].bbs_re_cnt > 0) {
                        data.data.list[i].res_status = "답변완료";
                    } else {
                        data.data.list[i].res_status = "답변대기";
                    }
                }
            }
			*/
            myGoodsInquiryList.setContent(data.data.list, data.data.paging);
        });


    $("[devFilterState]").on('click', function () {
        $("#state").val($(this).attr('devFilterState'));
		console.log($(this).attr('devFilterState'));
			$(".fb-tab__nav ul li").removeClass("active");
		if ($(this).attr('devFilterState') == "N"){
			$("#tab02").addClass("active");
		}else if ($(this).attr('devFilterState') == "Y"){
			$("#tab03").addClass("active");
		}else{
			$("#tab01").addClass("active");
		}
        myGoodsInquiryList.getPage(1);
    });

    $('#devBtnSearch').on('click', function () {
        var endDate = common.util.dates.convert($('#devEdate').val());
        var startDate = common.util.dates.convert($('#devSdate').val());
        var maxDate = common.util.dates.convert((startDate.getFullYear() + 5) + '-' + (startDate.getMonth() + 1) + '-' + startDate.getDate());

        if (startDate != 'Invalid Date' && endDate != 'Invalid Date') {
            if (common.util.dates.compare(startDate, endDate) == 1) {
                common.noti.alert(common.lang.get('mypage.wrongStartDate.alert'));
                return false;
            } else if (common.util.dates.compare(endDate, maxDate) == 1) {
                common.noti.alert(common.lang.get('mypage.wrongDateRange.alert'));
                return false;
            }
            myGoodsInquiryList.getPage(1);
        } else {
            common.noti.alert(common.lang.get('mypage.invalidDate.alert'));
        }
    });

    $('#devBtnReset').on('click', function () {
        $("#devSdate").val($("#sDateDef").val());
        $("#devEdate").val($("#eDateDef").val());
        $(".jq-radio a").removeClass("on");
        $("#devDateDefault").addClass("on");
        $("#devDivInfo").prop('selectedIndex', 0);
    });

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        myGoodsInquiryList.getPage(pageNum);
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
                var alert_msg = '시작일은 종료일 보다 이후일 수 없습니다.';

                if(common.langType == 'english') {
                    alert_msg = 'Try again';
                }
                common.noti.tailMsg('devEmailId', common.lang.get("joinInput.common.validation.email.doubleCheck"));
                var alert_msg = '시작일은 종료일 보다 이후일 수 없습니다.';

                if(common.langType == 'english') {
                    alert_msg = 'Try again';
                }
                alert(alert_msg);
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
                var alert_msg = '종료일은 시작일 보다 이전일 수 없습니다.';

                if(common.langType == 'english') {
                    alert_msg = 'Try again';
                }
                common.noti.tailMsg('devEmailId', common.lang.get("joinInput.common.validation.email.doubleCheck"));
                var alert_msg = '종료일은 시작일 보다 이전일 수 없습니다.';

                if(common.langType == 'english') {
                    alert_msg = 'Try again';
                }
                alert(alert_msg);
            }
        }
    });

    // 팝업
    $('#devMyContent').on('click', '[devBbsIx]', function () {
        var bbs_ix = $(this).attr('devBbsIx');
        if(common.langType=='korean'){
            common.util.modal.open('ajax', '상품 Q&A', '/mypage/myGoodsInquiryDetail/'+bbs_ix, '');
        }else{
            common.util.modal.open('ajax', 'Customer Q&A', '/mypage/myGoodsInquiryDetail/'+bbs_ix, '');
        }

    });

});