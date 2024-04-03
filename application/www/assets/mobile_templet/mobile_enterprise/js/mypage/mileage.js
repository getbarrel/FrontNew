"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
$(function () {

    // BBS List
    var mileageList = common.ajaxList();

    mileageList
        .setUseHash(true)
        .setRemoveContent(false)
        .setLoadingTpl('#devMileageLoading')
        .setListTpl('#devMileageList')
        .setEmptyTpl('#devMileageListEmpty')
        .setContainerType('div')
        .setContainer('#devMileageContent')
        .setPagination('#devPageWrap')
        .setPageNum('#devPage')
        .setForm('#devMileageForm')
        .setController('mileageList', 'mypage')
        .init(function (data) {
            mileageList.setContent(data.data.list, data.data.paging);
            $('#devTotal').text(data.data.total);
        });


    $("[devFilterState]").on('click', function () {
        $("#state").val($(this).attr('devFilterState'));
        mileageList.getPage(1);
    });

    // 검색일 설정
    $('.devDateBtn').on('click', function () {
        $('#devSdate').val($(this).data('sdate'));
        $('#devEdate').val($(this).data('edate'));
    });

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        mileageList.getPage(pageNum);
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

    $(document).on('click','.devLocationOrder', function () {
        var oid = $(this).data('oid');
        location.href = '/mypage/orderDetail?oid='+oid;
        return false;
    });

    // 검색일 설정
    $('.devSelectDate').on('click', function () {
        var sdate = $(this).data('sdate');
        var edate = $(this).data('edate');

        $('#sDate').val(sdate);
        $('#eDate').val(edate);

        $('#sDateStr').val(sdate);
        $('#eDateStr').val(edate);
    });

    //필터 접기/펴기
    $('#devFilter').on('click', function () {
        $('.mileage-inquiry').toggle();
    });

    function dateAddDel(sDate, nNum, type) {
        var yy = parseInt(sDate.substr(0, 4), 10);
        var mm = parseInt(sDate.substr(5, 2), 10);
        var dd = parseInt(sDate.substr(8), 10);
        var d = '';
        if (type == "d") {
            d = new Date(yy, mm - 1, dd + nNum);
        }else if (type == "m") {
            d = new Date(yy, mm - 1, dd + (nNum * 31));
        }else if (type == "y") {
            d = new Date(yy + nNum, mm - 1, dd);
        }

        yy = d.getFullYear();
        mm = d.getMonth() + 1; mm = (mm < 10) ? '0' + mm : mm;
        dd = d.getDate(); dd = (dd < 10) ? '0' + dd : dd;

        return '' + yy + '-' +  mm  + '-' + dd;
    }

    //조회하기
    $('#devSubmit').on('click', function () {
        var sdate = $('#sDateStr').val();
        var now = new Date();
        var year= now.getFullYear();
        var mon = (now.getMonth()+1)>9 ? ''+(now.getMonth()+1) : '0'+(now.getMonth()+1);
        var day = now.getDate()>9 ? ''+now.getDate() : '0'+now.getDate();

        var yearAgo3 = dateAddDel(year+'-'+mon+'-'+day, -3, 'y');

        var startDateArr = sdate.split('-');
        var ya3DateArr = yearAgo3.split('-');

        var startDateCompare = new Date(startDateArr[0], startDateArr[1], startDateArr[2]);
        var ya3DateCompare = new Date(ya3DateArr[0], ya3DateArr[1], ya3DateArr[2]);

        if(startDateCompare.getTime() < ya3DateCompare.getTime()) {
            alert('최근 3년 이내로 조회 가능합니다.');
            return false;
        }

        $('#devSDate').val(sdate);
        $('#devEDate').val($('#eDateStr').val());

        mileageList.getPage(1);
        $('#devFilter').click();
        $('#devComment').hide();
    });
});