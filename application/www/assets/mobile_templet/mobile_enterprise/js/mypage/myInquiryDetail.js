"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
$(function () {

    var myInquiryDetailList = common.ajaxList();


    $('#devDeleteInquiry').on('click', function(){
        myInquiryDetailList.setContainerType('div')
            .setRemoveContent(false)
            .setForm('#devMyInquiryDetailForm')
            .setUseHash(false)
            .setController('deleteArticle', 'customer')
            .init(function (data) {
                if(data) {
                    alert('1:1 문의가 삭제되었습니다.');
                    location.href = '/mypage/myInquiry';
                }else {
                    alert('1:1 문의 삭제중 오류가 발생했습니다.');
                }
            });

    });

});