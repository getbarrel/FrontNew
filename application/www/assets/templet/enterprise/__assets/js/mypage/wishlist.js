"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('wishlist.delete.confirm', "선택한 상품을 삭제하시겠습니까?"); //Confirm_12
common.lang.load('wishlist.delete.alert', "삭제할 상품을 선택해 주세요."); //Confirm_12
common.lang.load('wishlist.sdate.wrong', "시작일은 종료일 보다 이후일 수 없습니다.");


var devWishListObj = {
    myWishList: common.ajaxList(),
    initAjaxList: function () {
        var self = this;

        self.myWishList.setContainerType('div')
            .setContainer('#devMyWishContent')
            .setEmptyTpl('#devMyWishEmpty')
            .setLoadingTpl('#devMyWishLoading')
            .setListTpl('#devMyWishList')
            .setForm('#devMyWishForm')
            .setController('myWishList', 'mypage')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .init(function (response) {

                // 상품 상태 sale:판매, soldout:일시품절, stop:판매중지
                if (response.data.list.length > 0) {
                    $("#devTopButton").show();
                } else {
                    $("#devTopButton").hide();
                }

                self.myWishList.setContent(response.data.list, response.data.paging);
            });
    },
    initEvent: function () {
        var self = this;

        $('#devPageWrap').on('click', '.devPageBtnCls', function () {
            var pageNum = $(this).data('page');
            self.myWishList.getPage(pageNum);
        });

        // 검색일 설정
        $('.devDateBtn').on('click', function () {
            $('#devSdate').val($(this).data('sdate'));
            $('#devEdate').val($(this).data('edate'));
        });

        $("#devSdate").datepicker({
            monthNames: ['년 1월', '년 2월', '년 3월', '년 4월', '년 5월', '년 6월', '년 7월', '년 8월', '년 9월', '년 10월', '년 11월', '년 12월'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            showMonthAfterYear: true,
            dateFormat: 'yy-mm-dd',
            buttonImageOnly: true,
            buttonText: '달력',
            onSelect: function (dateText) {
                if ($('#devEdate').val() != '' && $('#devEdate').val() < dateText) {
                    $('#devSdate').val($('#sDateDef').val());
                    $('#devEdate').val($('#eDateDef').val());
                    common.noti.tailMsg('devEmailId', common.lang.get("joinInput.common.validation.email.doubleCheck"));
                    alert('시작일은 종료일 보다 이후일 수 없습니다.');
                }
            }
        });

        $('#devEdate').datepicker({
            monthNames: ['년 1월', '년 2월', '년 3월', '년 4월', '년 5월', '년 6월', '년 7월', '년 8월', '년 9월', '년 10월', '년 11월', '년 12월'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            showMonthAfterYear: true,
            dateFormat: 'yy-mm-dd',
            buttonImageOnly: true,
            buttonText: '달력',
            onSelect: function (dateText) {
                if ($('#devSdate').val() != '' && $('#devSdate').val() > dateText) {
                    $('#devSdate').val($('#sDateDef').val());
                    $('#devEdate').val($('#eDateDef').val());
                    common.noti.tailMsg('devEmailId', common.lang.get("joinInput.common.validation.email.doubleCheck"));
                    alert('종료일은 시작일 보다 이전일 수 없습니다.');
                }
            }
        });

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