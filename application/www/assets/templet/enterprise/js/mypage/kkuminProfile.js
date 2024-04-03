"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language
common.lang.load('kkumin.modify.confirm', "꾸민회원 정보를 저장하시겠습니까?");

var devKkuminModify = {
    kkuminAcceptFrom: $('#devKkuminModifyFrom'),
    formInit: function () {
        var self = this;
        common.validation.set($('.devItemInterest'), {'required': true});
        common.form.init(
            this.kkuminAcceptFrom,
            common.util.getControllerUrl('modifyKkuminMember', 'mypage'),
            function (formObj) {
                if (common.validation.check(formObj, 'alert', false) && confirm(common.lang.get('kkumin.modify.confirm'))) {
                    self.kkuminAcceptFrom.submit();
                    return true;
                } else {
                    return false;
                }
            },
            function (res) {
                if(res.result=='loginFail') {
                    alert('회원 정보가 누락 되었습니다.');
                }else if(res.result=='fail'){
                    alert('실패 되었습니다.')
                }else{
                    location.replace('/mypage/kkuminProfile');
                }
            }
        );
    },
    run: function () {
        var self = this;

        //Form init
        self.formInit();
    }
};

$(function () {

    devKkuminModify.run();


});