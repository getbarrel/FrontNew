"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('wishlist.delete.confirm', "선택한 상품을 삭제하시겠습니까?"); //Confirm_12
common.lang.load('wishlist.delete.alert', "삭제할 상품을 선택해 주세요."); //Confirm_12


var devWishListObj = {
    myWishList: common.ajaxList(),
    initAjaxList: function () {
        var self = this;

        self.myWishList.setContainerType('li')
            .setUseHash(true)
            .setRemoveContent(false)
            .setContainer('#devMyWishContent')
            .setEmptyTpl('#devMyWishEmpty')
            .setLoadingTpl('#devMyWishLoading')
            .setListTpl('#devMyWishList')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devMyWishForm')
            .setController('myWishList', 'mypage')
            .init(function (data) {
                // 상품 상태 sale:판매, soldout:일시품절, stop:판매중지
                if (data.data.list.length > 0) {
                    $("#devTopButton").show();
                }else{
                    $("#devTopButton").hide();
                }
                self.myWishList.setContent(data.data.list, data.data.paging);
                $('#devTotal').html(data.data.total);
            });

            $('#devPageWrap').on('click', '.devPageBtnCls', function () {
                var pageNum = $(this).data('page');
                self.myWishList.getPage(pageNum);
            });
    },
    initEvent: function () {
        var self = this;

        // 관심상품 일괄삭제
        $('#devBtnDelWish').on('click', function () {

            var searchIDs = $("#devMyWishContent input:checkbox:checked").map(function () {
                return $(this).val();
            }).get();

            if (searchIDs == "") {
                common.noti.alert(common.lang.get("wishlist.delete.alert"));
                return false;
            } else {

                if (common.noti.confirm(common.lang.get('wishlist.delete.confirm'))) {
                    common.ajax(
                        common.util.getControllerUrl('deleteMyWishList', 'mypage'),
                        {wishList: searchIDs},
                        function () {},
                        function (response) {
                            if (response.result == "success") {
                                self.myWishList.reload();
                            } else {
                                common.noti.alert('system error');
                            }
                        }
                    );
                }
            }
        });

    },
    run: function () {
        this.initAjaxList();
        this.initEvent();
    }
}

$(function () {
    devWishListObj.run();
});

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