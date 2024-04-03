"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/


/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
// common.lang.load('main.updateDeliveryComplete.confirm', "배송완료로 상태변경하시겠습니까?");
var getMainProductList = {
    mainProductListAjax: [],
    initPromotionProduct: function (group_code) {
        var self = this;
        
        if (typeof mainDisplayGroupData !== 'undefined') {
            self.mainProductListAjax[group_code] = common.moreArrayList();
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
            self.mainProductListAjax[group_code] = common.moreAjaxList();
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
                            // $('#devTotalProduct').text(common.util.numberFormat(response.data.total));
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
        const mainGoodsPage = self.mainProductListAjax;
        window.mainGoodsPage = mainGoodsPage;
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
		var icon = e.querySelector('.ico');
 console.log(icon);
        common.ajax(common.util.getControllerUrl('content', 'product'), allData, "", function (result) {
            if (result.result == 'insert') {
                $(e).toggleClass("product-box__heart--active");
				icon.classList.remove('ico-wishlist');
				icon.classList.add('ico-wishlist2');               
                alert('해당 상품이 관심 상품 목록에 추가되었습니다.\n\n마이페이지 > 관심 상품에서 확인 가능합니다.');
            } else if (result.result == 'delete') {
                $(e).removeClass("product-box__heart--active");
				icon.classList.remove('ico-wishlist2');
				icon.classList.add('ico-wishlist');
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