"use strict";

/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/


/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('mypage.updateDeliveryComplete.confirm', "배송완료로 상태변경하시겠습니까?"); //[공통] Alert_Confirm 정의_20180322 에 confirm 35 정의되어있지않아 임의지정함
common.lang.load('mypage.updateBuyFinalized.confirm', "구매확정으로 상태변경하시겠습니까?"); //[공통] Alert_Confirm 정의_20180322 에 정의되어있지않아 임의지정함
common.lang.load('mypage.duplicateCreek.false', "구매확정 프로세스가 진행 중 입니다.");
common.lang.load('mypage.deliveryDateCheck.false', "배송완료후 3개월 이상 경과된 운송장번호는 배송조회가 되지 않습니다.");

var orderDetail = {
    initEvent: function () {
        var self = this;

        // 배송완료
        $('#devOrderDetailContent').on('click', '.devOrderComplateBtn', function () {
            var odIx = $(this).data('odix');
            var oid = $(this).data('oid');

            common.noti.confirm(common.lang.get('mypage.updateDeliveryComplete.confirm', ''), function () {
                common.ajax(common.util.getControllerUrl('updateDeliveryComplete', 'mypage'), {odIx: odIx, oid: oid}, "", function (result) {
                    if (result.result == 'success') {
                        document.location.reload();
                    }
                });
            });
        });

        // 구매확정
        var devBuyFinalizeChk = false;
        $('#devOrderDetailContent').on('click', '.devBuyFinalizedBtn', function () {
            var odIx = $(this).data('odix');
            var oid = $(this).data('oid');

            if(devBuyFinalizeChk == false) {
                common.noti.confirm(common.lang.get('mypage.updateBuyFinalized.confirm', ''), function () {
                    common.ajax(common.util.getControllerUrl('updateBuyFinalized', 'mypage'), {
                        odIx: odIx,
                        oid: oid
                    }, function(){
                        devBuyFinalizeChk = true
                    } , function (result) {
                        if (result.result == 'success') {
                            document.location.reload();
                        }
                    });
                });
            }else{
                common.noti.alert(common.lang.get('mypage.duplicateCreek.false'));
                return false;
            }
        });

        // 주문취소
        $('#devOrderDetailContent').on('click', '.devOrderCancelBtn', function () {
            location.href = '/mypage/orderCancel?oid=' + $(this).data('oid') + '&od_ix=' + $(this).data('odix');
        });

        // 교환신청
        $('#devOrderDetailContent').on('click', '.devOrderExchangeBtn', function () {
            location.href = '/mypage/orderClaim/change/apply?oid=' + $(this).data('oid') + '&od_ix=' + $(this).data('odix');
        });

        // 반품신청
        $('#devOrderDetailContent').on('click', '.devOrderReturnBtn', function () {
            location.href = '/mypage/orderClaim/return/apply?oid=' + $(this).data('oid') + '&od_ix=' + $(this).data('odix');
        });

        // 상품후기 작성
        $('#devOrderDetailContent').on('click', '.devByFinalized', function () {
            var modal_title = '상품 후기 작성';

            if(common.langType == 'english') {
                modal_title = 'Write a review';
            }
            common.util.modal.open('ajax', modal_title, '/shop/goodsReview/' + $(this).data('pid') + '/' + $(this).data('oid') + '/' + $(this).data('odix') + '?mode=write');
        });

        // 배송추적
        $('#devOrderDetailContent').on('click', '.devDeliveryTrace', function () {
            if($(this).data('tracking_expiration')){
                common.noti.alert(common.lang.get('mypage.deliveryDateCheck.false'));
                return false;
            }
            var url = '/mypage/searchGoodsFlow/' + $(this).data('quick') + '/' + $(this).data('invoice_no');
            window.open(url);
        });

        // 전체취소
        $('#devOrderDetailContent').on('click', '.devOrderCancelAllBtn', function () {
            location.href = '/mypage/orderCancel?oid=' + $(this).data('oid');
        });

        //배송지 변경 버튼
        $('#devDeliveryChangeBtn').on('click', function () {

            var member = $(this).data('member');
            /*
                 * 회원 > /mypage/addressbookSelect/  (팝업)
                 * 비회원 > /mypage/addressbookSelectNomember/ (페이지)
            */
            if(!member) {
                var modal_title = '배송지 선택';

                if(common.langType == 'english') {
                    modal_title = 'Select destination';
                }
                common.util.modal.open('ajax', modal_title, '/mypage/addressbookSelect/' + $(this).data('oid'), '', function () {
                    devAddressBookPopObj.callbackSelect = function (deliveryIx,oid) {
                        common.ajax(
                            // 주문정보에 배송지 변경 처리 후 리로딩
                            common.util.getControllerUrl('deliveryAddressChange', 'mypage'), {deliveryIx:deliveryIx, oId:oid}, function () {
                                return deliveryIx;
                            }, function (response) {
                                if (response.result == 'success') {
                                    location.reload();
                                }else{
                                    var aleatMsg = '배송지 변경에 실패했습니다.';

                                    if(common.langType == 'english') {
                                        aleatMsg = 'fail';
                                    }
                                    alert(aleatMsg);
                                }
                            });
                    };
                });
            }else {
                location.href = '/mypage/addressbookSelectNomember/'+$(this).data('oid');
            }




        });
        $('.receipt-btn').click(function(){
            location.href='/mypage/receiptPrint?oid='+$(this).data('oid');
        });
        $('#devDeliveryRequestChangeBtn').click(function () {
            location.href = '/mypage/deliverymsgChange/' + $(this).data('oid');
        });
    },
    run: function () {
        var self = this;

        // 이벤트 바인딩
        self.initEvent();
    }
}

$(function () {
    orderDetail.run()
});