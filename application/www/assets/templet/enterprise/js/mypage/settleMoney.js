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
var devMyAccountList = {
    myAccountListAjax: false,
    init: function () {
        var self = this;
        self.myAccountListAjax = common.ajaxList();
        self.myAccountListAjax
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('tr')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devMyAccountList')
            .setUseHash(false)
            .setController('getAccountData', 'kkumin')
            .init(function (response) {
                console.log(response)
                self.myAccountListAjax.setContent(response.data.list, response.data.paging);
                // lazyload();//퍼블 레이지로드 삽입
            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.myAccountListAjax.getPage($(this).data('page'));
        });
    },
    initEvent: function () {
        var self = this;

        $('#devSearchSubmit').on('click',function(){
            self.myAccountListAjax.getPage(1);
        });
    },
    run: function () {
        var self = this;

        self.init();
        self.initEvent();
    }
}

$(function () {
    devMyAccountList.run();

    $('.devDateBtn').on('click', function () {
        $('#devSdate').val($(this).data('sdate'));
        $('#devEdate').val($(this).data('edate'));
    });

    $('#devExcelDown').on('click',function(){

        var frm = $('#devExcelFrm');
        $('#devExcelFrm').attr('action','/mypage/settleMoney/excel');
        var sDate = $('#devSdate').val();
        var eDate = $('#devEdate').val();
        var status = $('input[name=status]:checked').val();
        var search_type = $('select[name=search_type]:selected').val();
        var search_text = $('select[name=search_text]').val();
        $('#devExcelSdate').val(sDate);
        $('#devExcelEdate').val(eDate);
        $('#devExcelStatus').val(status);
        $('#devExcelSearchType').val(search_type);
        $('#devExcelSearchText').val(search_text);
        frm.submit();

    });
});