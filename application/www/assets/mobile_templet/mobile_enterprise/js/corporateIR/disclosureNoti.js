"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

$('button').on('click', function () {
    if($(this).hasClass('tab--first')){
        $('.br__ir__detail--first').show();
        $('.br__ir__detail--second').hide();
    }else{
        $('.br__ir__detail--first').hide();
        $('.br__ir__detail--second').show();
    }
});
$(function () {

    var isAjaxList = $("#isList").val();

    if (isAjaxList == 'Y') {

        var bbsList = common.ajaxList();


        bbsList
            .setContainer('#devMyContent')
            .setLoadingTpl('#devMyLoading')
            .setListTpl('#devMyList')
            .setEmptyTpl('#devMyListEmpty')
            .setContainerType('li')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devIrFrom')
            .setController('customBbsData', 'customer')
            .setUseHash(true)
            .setPaginationTpl(common.boardPagination)
            .init(function (data) {

                if(data.data.total > 0){
                    for(var i=0;i<data.data.list.length;i++){
                        var temp = '';
                        data.data.list[i].existFile = false;

                        if((data.data.list[i].bbs_subject).indexOf('||') != -1){
                            temp = (data.data.list[i].bbs_subject).split("||");
                        }else if((data.data.list[i].short_subject).indexOf('||') != -1){
                            temp = (data.data.list[i].short_subject).split("||");
                        }

                        if(temp != ''){
                            data.data.list[i].bbs_subject = temp['0'];
                            data.data.list[i].short_subject = temp['0'];
                            if(temp['1'] != '배럴' && temp['1'] != 'BARREL' && temp['1'] != 'barrel'){
                                data.data.list[i].bbs_name = temp['1'];
                            }
                        }

                        if(data.data.list[i].bbs_file_1 != '') {
                            data.data.list[i].existFile = true;
                        }

                        data.data.list[i].no = data.data.total - ( data.data.paging.per_page * (data.data.paging.cur_page - 1) ) - i;
                    }
                }

                $("#devListTotal").text(data.data.total);
                bbsList.setContent(data.data.list, data.data.paging);

            });
    }

    $('#devMyContent').on('click', '[devBbsIx]', function () {
        var bbs_ix = $(this).attr('devBbsIx');
        var bType = $('#bType').val();
        location.href = "/corporateIR/disclosureNoti/"+bType+"/read/" +bbs_ix;
    });

    $('.devBoardTab').on('click',function(){
       var board = $(this).data('board');
       $('#bType').val(board);
       bbsList.getPage(1);
    });

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        bbsList.getPage(pageNum);
    });

    if($('#bType').val() == 'announce'){
        $('.devBoardTab').each(function(){
           if($(this).data('board') == 'announce'){
               $(this).addClass("br__ir__tab--active").siblings().removeClass("br__ir__tab--active");
           }
        });
    }
});