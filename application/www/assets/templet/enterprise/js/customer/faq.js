"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('faq.list.empty', "궁금한 점은 1:1문의하기 게시판을 이용해 주세요.");
common.lang.load('faq.list.notFound', "에 대한 검색 결과가 없습니다. 궁금한 점은 1:1문의하기 게시판을 이용해 주세요.");
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
            if(common.langType=='korean'){

                $("#devTotal").before("총 ");
                $("#devTotal").after("개");
            }else{
                $("#devTotal").before("Total ");
            }

            faqList.setContent(data.data.list, data.data.paging);

            if(data.data.sText != "" && data.data.total == 0){
                $("#emptyMsg em").text(data.data.sText);
                $("#emptyMsg").append(common.lang.get('faq.list.notFound'));
            }else{
                $("#emptyMsg").text(common.lang.get('faq.list.empty'));
            }
        });

    // FAQ 분류선택
    $('[devDivIx]').on('click', function () {
        $("#divIx").val($(this).data('divix'));
        $("#bbsIx").val('');
        $("#devSearchFaqText").val("");
        $("#sText").val("");
        //$('[devDivIx]').removeClass("list-menu__list--active");
        //$(this).addClass("list-menu__list--active");
        $('[devDivIx2]').removeClass("active");
		$('#devDivIx2'+$(this).data('divix')).addClass("active");

        faqList.getPage(1);
    });

    var faqNum = -1;
    $('#devFaqContent').on('click', '.devFaqQuestion', function () {
        var idx = $('dl').index($(this).closest("dl"));
        if (faqNum != idx) {
            faqNum = idx;
            $('.devFaqAnswer').slideUp('fast');
            $(this).next('dd').slideDown();
            $(this).toggleClass("fb__bbs__faq-q--open");
        } else {
            $(this).next('dd').slideToggle();
            $(this).toggleClass("fb__bbs__faq-q--open");
        }
    });

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        $('#devPage').val(pageNum);
        faqList.getPage(pageNum);
    });
});