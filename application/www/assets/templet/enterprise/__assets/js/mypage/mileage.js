"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('mypage.invalidDate.alert', "날짜 형식이 잘못되었습니다.");
common.lang.load('mypage.wrongStartDate.alert', "시작일은 종료일 보다 이후일 수 없습니다.");
common.lang.load('mypage.wrongDateRange.alert', "최대 5년 내 내역까지만 조회 가능합니다.");

$(function () {

    // BBS List
    var mileageList = common.ajaxList();

    mileageList
        .setLoadingTpl('#devMileageLoading')
        .setListTpl('#devMileageList')
        .setEmptyTpl('#devMileageListEmpty')
        .setContainerType('table')
        .setContainer('#devMileageContent')
        .setPagination('#devPageWrap')
        .setPageNum('#devPage')
        .setForm('#devMileageForm')
        .setController('mileageList', 'mypage')
        .init(function (data) {
            mileageList.setContent(data.data.list, data.data.paging);
        });


    $("[devFilterState]").on('click', function () {
        $("#state").val($(this).attr('devFilterState'));
        mileageList.getPage(1);
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

            mileageList.getPage(1);
        } else {
            common.noti.alert(common.lang.get('mypage.invalidDate.alert'));
        }
    });

    // 검색일 설정
    $('.devDateBtn').on('click', function () {
        $('#devSdate').val($(this).data('sdate'));
        $('#devEdate').val($(this).data('edate'));
    });

    $('#devBtnReset').on('click', function () {
        $("#devSdate").val($("#sDateDef").val());
        $("#devEdate").val($("#eDateDef").val());
        $(".jq-radio a").removeClass("on");
        $("#devDateDefault").addClass("on");
    });

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        mileageList.getPage(pageNum);
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


});