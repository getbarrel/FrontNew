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
var joinTypeVal;
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
        if(joinTypeVal == 'B'){
            location.href = '/member/authentication';
        }else if(joinTypeVal == 'C') {
            location.href = '/member/authentication';
        }

    } else {
        common.noti.alert("system error");
    }
};

function joinSelectType(joinType) {
    joinTypeVal = joinType;
    common.ajax(common.util.getControllerUrl('joinSelectType', 'member'), {'joinType': joinType}, "", joinSelectResponse);
}