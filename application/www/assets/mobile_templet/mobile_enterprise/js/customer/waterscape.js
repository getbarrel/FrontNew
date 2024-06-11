"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
$(function () {

    var isAjaxList = $("#isList").val();

    if (isAjaxList == 'Y') {

        var bbsList = common.ajaxList();

		// 페이지네이션 재정의
		bbsList.setContent = function (list, paging) {
            if(paging.cur_page == 1){
                this.removeContent();
            }
			//this.removeContent();
			if (list.length > 0) {
				for (var i = 0; i < list.length; i++) {
					var row = list[i];
					$(this.container).append(this.listTpl(row));
				}
				if (paging) {
					$(this.pagination).html(common.pagination.getHtml(paging));
				}
			} else {
				$(this.container).append(this.emptyTpl());
			}
		};


        bbsList
            .setContainerType('div')
            .setLoadingTpl('#devBbsLoading')
            .setListTpl('#devBbsList')
            .setEmptyTpl('#devBbsEmpty')
            .setContainer('#devBbsContent')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devBbsForm')
            .setController('noticeList', 'customer')
            .setRemoveContent(false)
            .setUseHash(true)
            .setPaginationTpl(common.boardPagination)
            .init(function (data) {
                //$('#devBbsContent').empty();
                bbsList.setContent(data.data.list, data.data.paging);
                if (data.data.searchText != "" && data.data.total == 0) {
                    $("#emptyMsg em").text(data.data.searchText);
                    $("#emptyMsg").append("에 대한 검색 결과가 없습니다.");
                } else {
                    $("#emptyMsg").text("등록된 도수수경/매장정보가 없습니다");
                }
            });
    }

    $('[devDivIx]').on('click', function (e) {
        e.preventDefault();
        var tmp = $(this).data('divix');
        $("#divIx").val(tmp);
        $("#bbsIx").val('');
        bbsList.getPage(1);
    });

    $('#devBbsContent').on('click', '[devBbsIx]', function () {
        location.href = "/customer/waterscape/read/" + $(this).attr('devBbsIx');
    });

	$("#btnSearch").click(function(){
		bbsList.getPage(1);	
	});

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        bbsList.getPage(pageNum);
    });
});