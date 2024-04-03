"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
//-----load language

//-----set input format

//-----set validation

//-----일반회원
$('#devBasicJoinButton').click(function (e) {
    e.preventDefault();
    joinSelectType('B');
});

//-----기업회원
$('#devCompanyJoinButton').click(function (e) {
    e.preventDefault();
    joinSelectType('C');
});

var joinSelectResponse = function (response) {
    if (response.result == "success") {
        location.href = '/member/authentication';
    } else {
        common.noti.alert("system error");
    }
};

function joinSelectType(joinType) {
    common.ajax(common.util.getControllerUrl('joinSelectType', 'member'), {'joinType': joinType}, "", joinSelectResponse);
}