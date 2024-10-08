"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var getMainProductList = {
    mainProductListAjax: [],
    initPromotionProduct: function (group_code) {
        var self = this;
        if (typeof mainDisplayGroupData !== 'undefined') {
            self.mainProductListAjax[group_code] = common.arrayList();
            self.mainProductListAjax[group_code]
                    .setRemoveContent(false)
                    .setLoadingTpl('#devListLoading_' + group_code)
                    .setListTpl('#devListDetail_' + group_code)
                    .setEmptyTpl('#devListEmpty_' + group_code)
                    .setContainerType('ul')
                    .setContainer('#devListContents_' + group_code)
                    .setPagination('#devPageWrap_' + group_code)
                    .setPageNum('#devPage_' + group_code)
                    .setForm('#devListForm_' + group_code)
                    .setUseHash(false)
                    .setResponseData(mainDisplayGroupData[group_code])
                    .init(function (response) {
                        // 전체 상품 수
                        if (typeof response.data.list !== 'undefined' && response.data.list.length > 0) {
                            self.mainProductListAjax[group_code].setContent(response.data.list, response.data.paging);
                            lazyload();
                        } else {
                            $('.devDisplayGroup').each(function () {
                                if ($(this).data('group_code') == group_code) {
                                    $(this).hide();
                                }
                            });
                        }
                    });
        } else {
            self.mainProductListAjax[group_code] = common.ajaxList();
            self.mainProductListAjax[group_code]
                    .setRemoveContent(false)
                    .setLoadingTpl('#devListLoading_' + group_code)
                    .setListTpl('#devListDetail_' + group_code)
                    .setEmptyTpl('#devListEmpty_' + group_code)
                    .setContainerType('ul')
                    .setContainer('#devListContents_' + group_code)
                    .setPagination('#devPageWrap_' + group_code)
                    .setPageNum('#devPage_' + group_code)
                    .setForm('#devListForm_' + group_code)
                    .setUseHash(false)
                    .setController('getMainDisplayGoods', 'display')
                    .init(function (response) {
                        // 전체 상품 수
                        if (typeof response.data.list !== 'undefined' && response.data.list.length > 0) {
                            self.mainProductListAjax[group_code].setContent(response.data.list, response.data.paging);
                            lazyload();
                        } else {
                            $('.devDisplayGroup').each(function () {
                                if ($(this).data('group_code') == group_code) {
                                    $(this).hide();
                                }
                            });
                        }
                    });
        }

        $('#devPageWrap_' + group_code).on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.mainProductListAjax[group_code].getPage($(this).data('page'));

        });
    },
    initEvent: function () {
        var self = this;

    },
    run: function () {
        var self = this;

        $('.devDisplayGroup').each(function () {
            var groupCode = $(this).data('group_code');
            self.initPromotionProduct(groupCode);
        })

        self.initEvent();
    }
}


$(function () {
    getMainProductList.run();
});

function contentWish(ix, type, e){
    if (forbizCsrf.isLogin) {
        var allData = { "con_ix": ix, "type": type };
        common.ajax(common.util.getControllerUrl('content', 'product'), allData, "", function (result) {
            if (result.result == 'insert') {
                $(e).toggleClass("active");
                alert('해당 상품이 관심 상품 목록에 추가되었습니다.\n\n마이페이지 > 관심 상품에서 확인 가능합니다.');
            } else if (result.result == 'delete') {
                $(e).removeClass("active");
            } else {
                common.noti.alert('error');
            }
        })
    } else {
        if(confirm("관심상품 등록은 로그인 시에만 가능합니다.\n\n로그인하시겠습니까?")){
            document.location.href = '/member/login?url=';
        }
    }
}

function productWish(pid){
    if (forbizCsrf.isLogin) {
        if($('#wishCheckBox_'+pid).is(':checked')){
            var gubun = "N";
        }else{
            var gubun = "Y";
        }

        var allData = { "pid": pid, "type": gubun };
        common.ajax(common.util.getControllerUrl('wish', 'product'), allData, "", function (result) {
            if (result.result == 'insert') {
                //$(e).toggleClass("active");
                alert('해당 상품이 관심 상품 목록에 추가되었습니다.\n\n마이페이지 > 관심 상품에서 확인 가능합니다.');
            } else if (result.result == 'delete') {
                //$(e).removeClass("active");
            } else {
                common.noti.alert('error');
            }
        })
    } else {
        if(confirm("관심상품 등록은 로그인 시에만 가능합니다.\n\n로그인하시겠습니까?")){
            document.location.href = '/member/login?url=';
        }
    }
}