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

function laundryChange(cid) {
	$.ajax({
		type: 'GET',
		url: '/customer/productPrecautions?mode=ajaxMo&cid='+cid,
		success: function(data, textStatus, request) {
			//console.log(data);
			var div_laundry = $("#laundryInfo");
			div_laundry.children().remove();
			div_laundry.append(data);
		},
		error: function(request, textStatus, error) {
			alert('세탁주의관리 항목을 불러올수 없습니다./n관리자에게 문의하세요.');
		}
	});
}

function laundryChange2(did) {
	$.ajax({
		type: 'GET',
		url: '/customer/productPrecautions?mode=ajaxMo&cid='+$("#laundryOneDepth").val()+'&did='+did,
		success: function(data, textStatus, request) {
			//console.log(data);
			var div_laundry = $("#laundryInfo");
			div_laundry.children().remove();
			div_laundry.append(data);
		},
		error: function(request, textStatus, error) {
			alert('세탁주의관리 항목을 불러올수 없습니다./n관리자에게 문의하세요.');
		}
	});
}