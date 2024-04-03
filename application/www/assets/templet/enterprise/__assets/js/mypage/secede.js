"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
$(function () {
    //-----load language
    common.lang.load('secede.common.withdraw.cancel', "탈퇴신청을 취소하시겠습니까?");
    common.lang.load('secede.common.withdraw.confirm', '{shopName} 사이트에서 탈퇴 하시겠습니까?');
    common.lang.load('secede.common.withdraw.success', '탈퇴가 완료되었습니다.');
    common.lang.load('secede.common.validation.reason', '탈퇴사유를 선택해 주세요.');
    common.lang.load('secede.common.withdraw.has.order', '현재 거래 진행 건이 있으므로 회원탈퇴가 불가능 합니다.');

    //-----set input format
    //-----set validation
    common.validation.set($('#devWithdrawReason'), {'required': true , 'requiredMessageTag' : 'secede.common.validation.reason'});
    //-----set event
    // 회원탈퇴 폼 
    common.form.init(
        $('#devSecedeForm'), // Form
        common.util.getControllerUrl('withdraw', 'member'), // Controller name
        function (formObj) {
            var ret = common.validation.check(formObj, 'alert', false);

            // Form validation
            return ret && common.noti.confirm(common.lang.get('secede.common.withdraw.confirm', {shopName: formObj.data('shopname')}));
        },
        function (res) {
            if (res.result == 'success') {
                common.noti.alert(common.lang.get('secede.common.withdraw.success'));
                location.replace('/');
            } else if(res.result == 'hasOrder') {
                common.noti.alert(common.lang.get('secede.common.withdraw.has.order'));
            } else if(res.result == 'invalidwithdrawCode') {
                location.reload();
            } else {
                console.log(res);
            }
        }
    );

    $('#devSecedeCancel').on('click', function () {
        common.noti.confirm(common.lang.get('secede.common.withdraw.cancel'), function () {
            location.href = '/mypage';
        });
    });
});