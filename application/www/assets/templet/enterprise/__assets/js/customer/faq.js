"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
$(function () {
    var faqList = common.ajaxList();
    faqList.setContainerType('div')
        .setLoadingTpl('#devFaqLoading')
        .setListTpl('#devFaqList')
        .setEmptyTpl('#devFaqEmpty')
        .setContainer('#devFaqContent')
        .setPagination('#devPageWrap')
        .setPageNum('#devPage')
        .setForm('#devFaqForm')
        .setController('faqList', 'customer')
        .init(function (data) {
            $(".count").empty("");
            $(".count").append("<em id='keyword'></em> <em id='devTotal'></em>");

            if(data.data.sText != ""){
                $("#keyword").text(data.data.sText);
                $("#keyword").after("에 대한 검색 결과 ");

                if (data.data.total > 0) {
                    var regEx = new RegExp(data.data.sText, "gi");
                    for (var i = 0; i < data.data.list.length; i++) {
                        data.data.list[i].bbs_q = data.data.list[i].bbs_q.replace(regEx, '<strong>' + data.data.sText + '</strong>');
                    }
                }
            }

            $("#devTotal").text(data.data.total);
            $("#devTotal").before("총 ");
            $("#devTotal").after("개");

            faqList.setContent(data.data.list, data.data.paging);

            if(data.data.sText != "" && data.data.total == 0){
                $("#emptyMsg em").text(data.data.sText);
                $("#emptyMsg").append("에 대한 검색 결과가 없습니다. 궁금한 점은 1:1문의하기 게시판을 이용해 주세요.");
            }else{
                $("#emptyMsg").text("궁금한 점은 1:1문의하기 게시판을 이용해 주세요.");
            }
        });

    // FAQ 분류선택
    $('[devDivIx]').on('click', function () {

        var tmp = (this.id).split("_");
        $("#divIx").val(tmp['1']);
        $("#bbsIx").val('');
        $("#devSearchFaqText").val("");
        $("#sText").val("");

        faqList.reload();
    });

    var faqNum = -1;
    $('#devFaqContent').on('click', '.devFaqQuestion', function () {

        var idx = $('dl').index($(this).closest("dl"));
        if (faqNum != idx) {
            faqNum = idx;
            $('.devFaqAnswer').slideUp('fast');
            $(this).next('dd').slideDown();
        } else {
            $(this).next('dd').slideToggle();
        }
    });

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        $('#devPage').val(pageNum);
        faqList.getPage(pageNum);
    });
});