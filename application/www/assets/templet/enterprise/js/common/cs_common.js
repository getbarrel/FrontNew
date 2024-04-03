"use strict";

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('search.customer.check.null', "검색어를 입력해 주세요."); // Alert_21
common.lang.load('search.customer.check.length', "검색어를 2자 이상 입력해 주세요."); // Alert_22

function searchFaq(frm) {
    
    var sText = $("#devSearchFaqText").val();

    if (sText == '') {
            common.noti.alert(common.lang.get("search.customer.check.null"));
            return false;
        } else if (sText != "" && String(sText).length < 2) {
            common.noti.alert(common.lang.get("search.customer.check.length"));
            return false;
        }
        
    document.searchFaqFrm.submit();
}