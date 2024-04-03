/**
 * Created by moon on 2019-08-14.
 */

$(function () {

    var isAjaxList = $("#isList").val();

    if (isAjaxList == 'Y') {

        var bbsList = common.ajaxList();


        bbsList
            .setContainer('#devMyContent')
            .setLoadingTpl('#devMyLoading')
            .setListTpl('#devMyList')
            .setEmptyTpl('#devMyListEmpty')
            .setContainerType('table')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devIrFrom')
            .setController('customBbsData', 'customer')
            .setRemoveContent(false)
            .setUseHash(false)
            .init(function (data) {
                if(data.data.total > 0){
                    for(i=0;i<data.data.list.length;i++){
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

    $('#devPageWrap').on('click', '.devPageBtnCls', function () {
        var pageNum = $(this).data('page');
        bbsList.getPage(pageNum);
    });
});