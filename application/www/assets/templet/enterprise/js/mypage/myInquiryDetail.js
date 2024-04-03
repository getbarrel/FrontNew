"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('qna.delete.alert', "문의 내역을 삭제 하시겠습니까?"); //Confirm_12
common.lang.load('qna.deleteComplete.alert', "1:1 문의가 삭제되었습니다.");
common.lang.load('qna.deleteFail.alert', "1:1 문의 삭제중 오류가 발생했습니다.");
$(function () {


    $('#devDeleteInquiry').on('click', function(){
        var bType = $('#devMyInquiryDetailForm #bType' ).val();
        var bbsIx = $('#devMyInquiryDetailForm #bbsIx' ).val();
        common.ajax(
            common.util.getControllerUrl('deleteArticle', 'customer'),
            {
                bType: bType , bbsIx:bbsIx
            },
            function () {
                if (confirm(common.lang.get('qna.delete.alert'))) {
                    return true;
                } else {
                    return false;
                }
            },
            function (data) {
                if (data.result == 'success') {
                    common.noti.alert(common.lang.get('qna.deleteComplete.alert'));
                    location.href = '/mypage/myInquiry';
                }else{
                    common.noti.alert(common.lang.get('qna.deleteFail.alert'));
                }
            }

        );
    });

});