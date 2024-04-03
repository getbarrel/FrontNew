"use strict";
/*--------------------------------------------------------------*
 * 공용변수 선언 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devMyRemittanceList = {
    myRemittanceListAjax: false,
    init: function () {
        var self = this;
        self.myRemittanceListAjax = common.ajaxList();
        self.myRemittanceListAjax
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('tr')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devMyRemittanceList')
            .setUseHash(false)
            .setController('getRemittanceData', 'kkumin')
            .init(function (response) {
                console.log(response)
                self.myRemittanceListAjax.setContent(response.data.list, response.data.paging);
                // lazyload();//퍼블 레이지로드 삽입
            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.myRemittanceListAjax.getPage($(this).data('page'));
        });
    },
    initEvent: function () {
        var self = this;

        $('#devSearchSubmit').on('click',function(){
            self.myRemittanceListAjax.getPage(1);
        });
    },
    run: function () {
        var self = this;

        self.init();
        self.initEvent();
    }
}

$(function () {
    devMyRemittanceList.run();

    $('.devDateBtn').on('click', function () {
        $('#devSdate').val($(this).data('sdate'));
        $('#devEdate').val($(this).data('edate'));
    });

    $('#devExcelDown').on('click',function(){

        var frm = $('#devExcelFrm');
        $('#devExcelFrm').attr('action','/mypage/cashWithdraw/excel');
        var sDate = $('#devSdate').val();
        var eDate = $('#devEdate').val();
        var status = $('input[name=status]:checked').val();
        $('#devExcelSdate').val(sDate);
        $('#devExcelEdate').val(eDate);
        $('#devExcelStatus').val(status);
        frm.submit();

    });
});