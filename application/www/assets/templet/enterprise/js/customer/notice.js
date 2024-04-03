"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

common.lang.load('bbsList.search.count', "에 대한 검색 결과");
common.lang.load('bbsList.search.empty', "에 대한 검색 결과가 없습니다.");
common.lang.load('bbsList.notice.empty', "등록된 공지사항이 없습니다.");
$(function () {

    var isAjaxList = $("#isAjaxList").val();

    if (isAjaxList == 'undefined' || isAjaxList != 'N') {

        var bbsList = common.ajaxList();

        bbsList.setContent = function (list, paging, total, searchText) {
            this.removeContent();
            if (list.length > 0) {
                for (var i = 0; i < list.length; i++) {
                    var row = list[i];
                    if(searchText != "") {
                        var regex = new RegExp(searchText, 'gi');
                        var _addclass = "search-point"
                        row.short_subject = row.short_subject.replace(regex, "<em class='"+_addclass+"'>"+searchText+"</em>");
                    }
                    $(this.container).append(this.listTpl(row));
                }

                if(total == 0) {
                    $(this.container).append(this.emptyTpl());
                }

                if (paging) {
                    $(this.pagination).html(common.pagination.getHtml(paging));
                }
            } else {
                $(this.container).append(this.emptyTpl());
            }
        };
        bbsList.setLoadingTpl('#devBbsLoading')
                .setListTpl('#devBbsList')
                .setEmptyTpl('#devBbsListEmpty')
                .setContainerType('div')
                .setContainer('#devBbsContent')
                .setPagination('#devPageWrap')
                .setPageNum('#devPage')
                .setForm('#devBbsForm')
                .setController('mixedNoticeList', 'customer')
                .setGotoTop(200)
                .init(function (data) {
                    var searchText = $('#searchText').val();

                    if (!(data.data.list).isNull && !(data.data.paging).isNull) {
                        var c = data.data.paging.cur_page;
                        var p = data.data.paging.per_page;
                        var t = data.data.total;
                        var no = t - (p * (c - 1));
                        for (var i = 0; i < (data.data.list).length; i++) {
                            data.data.list[i].idx = no;
                            no--;
                        }
                    }

                    $(".count").empty("");
                    $(".count").append("<em id='keyword'></em> <em id='devTotal'></em>");

                    if (searchText != "" && common.langType == 'korean') {
                        $("#keyword").text(searchText);
                        $("#keyword").after("에 대한 검색 결과 ");
                    }

                    $("#devTotal").text(data.data.total - data.data.noticeTotal);
                    if(common.langType == 'korean'){
                        $("#devTotal").before("총 ");
                        $("#devTotal").after("개");
                    }else{
                        $("#devTotal").before("Total ");
                        $("#devTotal").after("");
                    }

                    bbsList.setContent(data.data.list, data.data.paging, data.data.total - data.data.noticeTotal, searchText);

                    if (searchText != "" && data.data.total - data.data.noticeTotal == 0) {
                        if(common.langType == 'korean'){
                            $("#emptyMsg em").text(searchText);
                        }
                        $("#emptyMsg").append(common.lang.get("bbsList.search.empty"));
                    } else {
                        $("#emptyMsg").text(common.lang.get("bbsList.notice.empty"));
                    }
                });
    }

    $('#devBbsContent').on('click', '[devBbsIx]', function () {
        location.href = "/customer/notice/read/" + $(this).attr('devBbsIx');
    });

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        bbsList.getPage(pageNum);
    });

    $("#btnSearch").click(function(){
		$("#devBbsForm").submit();
		/*
        if($("#searchText").val() == ""){
            alert("검색어를 입력해 주세요.");
        }else{
            $("#devBbsForm").submit();
        }
		*/
    });

});