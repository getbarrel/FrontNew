"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('coupon.download.fail', '쿠폰 다운로드에 실패하였습니다');
common.lang.load('coupon.download.success', '쿠폰이 정상적으로 다운로드 되었습니다.');
common.lang.load('coupon.download.no', '다운로드 가능한 쿠폰이 없습니다.');
common.lang.load('coupon.download.addCoupon', '쿠폰을 등록 하시겠습니까?.');

common.lang.load('coupon.regist.success', '쿠폰이 정상적으로 발급되었습니다.');
common.lang.load('coupon.regist.fail', '쿠폰번호를 잘못 입력하셨습니다. 다시 입력해 주세요.');
common.lang.load('coupon.regist.fail.termExpired', '쿠폰의 사용기간이 만료되었습니다.');
common.lang.load('coupon.regist.fail.used', '이미 사용된 쿠폰입니다.');


common.validation.set($('#devCouponNum'), {'required': true});

var devCouponList = {
    couponListAjax: false,
    init: function () {
        var self = this;
        self.couponListAjax = common.ajaxList();
        self.couponListAjax
            .setRemoveContent(false)
            .setLoadingTpl('#devListLoading')
            .setListTpl('#devListDetail')
            .setEmptyTpl('#devListEmpty')
            .setContainerType('ul')
            .setContainer('#devListContents')
            .setPagination('#devPageWrap')
            .setPageNum('#devPage')
            .setForm('#devListForm')
            .setUseHash(false)
            .setController('getUserCouponList', 'coupon')
            .init(function (response) {
                $('#devCouponCount').text(response.data.total);
                self.couponListAjax.setContent(response.data.list, response.data.paging);
            });

        $('#devPageWrap').on('click', '.devPageBtnCls', function () { // 페이징 버튼 이벤트 설정
            self.couponListAjax.getPage($(this).data('page'));
        });
    },
    initEvent: function() {
        var self = this;

        $('#devListContents').on('click','.devItemInfo',function(){
            var ix = $(this).data('ix');
            var modal_title = '쿠폰 적용대상';

            if(common.langType == 'english') {
                modal_title = 'Coupon detail';
            }
            common.util.modal.open('ajax', modal_title, '/mypage/couponDetail?regIx=' + ix);
        });

        $(document).on('click','.devUseOid',function(){
            var oid = $(this).attr('devUseOid');
            location.href='/mypage/orderDetail?oid='+oid;
            return false;
        });


    },
    run: function(){
        var self = this;

        self.init();
        self.initEvent();
    }
}

$(function(){
    devCouponList.run();

    $('[devRegistix]').click(function(){
        var modal_title = '쿠폰 적용대상';

        if(common.langType == 'english') {
            modal_title = 'Coupon detail';
        }
        common.util.modal.open('ajax', modal_title, '/mypage/couponDetail?regIx=' + $(this).attr('devRegistix'));
    });

    $('.devDownLoadCoupon').on('click', '[devPublishIx]', function () {
        var publishIx = $(this).attr('devPublishIx');
        common.ajax(common.util.getControllerUrl('downCoupon', 'product'), {publishIx: publishIx}, "", function (result) {
            if (result.result == 'success') {
                common.noti.alert(common.lang.get('coupon.download.success'));
                location.reload();
            } else {
                common.noti.alert(common.lang.get('coupon.download.fail'));
            }
        })
    });

    /*$('.devDownLoadCoupon').click(function(){

        var resultBool = true;
        if($('.devPublishIx').length > 0){
            $('.devPublishIx').each(function(){
                var publishIx = $(this).val();
                if(publishIx){
                    common.ajax(common.util.getControllerUrl('downCoupon', 'product'), {publishIx: publishIx}, "", function (result) {
                        if (result.result == 'success') {
                            resultBool = true;
                        } else {
                            resultBool = false;
                        }
                    })
                }

            })
            if(resultBool == true){
                common.noti.alert(common.lang.get('coupon.download.success'));
            }else{
                common.noti.alert(common.lang.get('coupon.download.fail'));
            }
            location.reload();
        }else{
            common.noti.alert(common.lang.get('coupon.download.no'));
        }

    });*/



    var $form = $('#devInputCoupon');
    var url = common.util.getControllerUrl('registOffLineCoupon', 'mypage');
    var beforeCallback = function ($form) {
        //alert()
        return common.validation.check($form,'alert');
    };
    var responseUrl = "";
    var successCallback = function (response) {
        if (response.result == "success") {
            if (response.data == 'success') {
                common.noti.alert(common.lang.get('coupon.regist.success'), function () {
                    location.reload();
                });
            } else {
                var msg = common.lang.get('coupon.regist.fail');
                if (response.data == 'failOverDay') {
                    msg = common.lang.get('coupon.regist.fail.termExpired');
                } else if (response.data == 'failOverlap') {
                    msg = common.lang.get('coupon.regist.fail.used');
                }
                $('#devCouponNum').val('');
                $('#devInputFail').text(msg).show();
            }
        } else {
            $('#devInputFail').show();
        }
    };
    common.form.init($form, url, beforeCallback, successCallback);

    $('#devSubmitBtn').click(function (e) {
        e.preventDefault();
        $form.submit();
    });

    //
    // $('#devSubmitBtn').click(function(){
    //     var commentSubmitBool = false;
    //     if(commentSubmitBool){
    //         alert('등록중 입니다.');
    //     } else {
    //         commentSubmitBool = true;
    //         common.noti.confirm(common.lang.get('coupon.download.addCoupon'), function () {
    //             common.ajax(common.util.getControllerUrl('addInputCoupon', 'mypage'), {
    //
    //             }, '', function (res) {
    //                 //성공일때 처리
    //
    //             });
    //         });
    //     }
    // });

});

