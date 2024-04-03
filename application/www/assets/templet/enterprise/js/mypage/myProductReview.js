"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('myProductReview.delete.confirm', "상품 후기를 삭제하시겠습니까?"); //Confirm_34
common.lang.load('mypage.invalidDate.alert', "날짜 형식이 잘못되었습니다.");
common.lang.load('mypage.wrongStartDate.alert', "시작일은 종료일 보다 이후일 수 없습니다.");
common.lang.load('mypage.wrongDateRange.alert', "최대 5년 내 내역까지만 조회 가능합니다.");

$(function () {

    // REVIEW List
    var myReviewList = common.ajaxList();

    myReviewList
            .setLoadingTpl('#devMyReviewLoading')
            .setListTpl('#devMyReviewList')
            .setEmptyTpl('#devMyReviewListEmpty')
            .setContainerType('table')
            .setContainer('#devMyReviewContent')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devMyReviewForm')
            .setController('myReviewList', 'mypage')
            .init(function (data) {
                $("#devTotal").text(data.data.total);
                console.log(data);
                myReviewList.setContent(data.data.list, data.data.paging);
            });


    $("[id^=mltab_]").on('click', function () {
        var tmp = (this.id).split("_");
        $("#devState").val(tmp['1']);
        myReviewList.getPage(1);
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
            myReviewList.getPage(1);
        } else {
            common.noti.alert(common.lang.get('mypage.invalidDate.alert'));
        }
    });

    $('#devBtnReset').on('click', function () {
        $("#devSdate").val($("#sDateDef").val());
        $("#devEdate").val($("#eDateDef").val());
        $(".jq-radio a").removeClass("on");
        $("#devDateDefault").addClass("on");
    });

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        $('#devPage').val(pageNum);
        myReviewList.getPage(pageNum);
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

    // 후기 수정
    $('#devMyReviewContent').on('click', '.devReviewModifyBtnCls', function () {
        //common.util.modal.open('ajax', '상품 후기 내역', '/shop/reviewDetail.php?mode=read');
        common.util.popup('/shop/myProductReviewPop?mode=modify&bbsIx=' + $(this).data('bbsidx'), 720, 870, '상품 후기 수정');
    });

    // 후기 상세 
    $('#devMyReviewContent').on('click', '.txt-area', function () {
        common.util.popup('/shop/myProductReviewPop?mode=read&bbsIx=' + $(this).data('bbsix'), 720, 870, '상품 후기 내역');
    });

    var $form1 = $('#devForm1');
    var url = common.util.getControllerUrl('deleteMyProductReview', 'mypage');
    var beforeCallback = function ($form1) {
        return true;
    };
    var successCallback = function (response) {
        if (response.result == "success") {
            myReviewList.reload();
            //document.location.reload();
        } else {
            common.noti.alert('system error');
        }
    };

    common.form.init($form1, url, beforeCallback, successCallback);

    $('#devMyReviewContent').on('click', '.devReviewDeleteBtnCls', function () {
        if (common.noti.confirm(common.lang.get('myProductReview.delete.confirm'))) {
            $("#bbsIx").val($(this).data('bbsix'));
            $form1.submit();
        }
    });
});