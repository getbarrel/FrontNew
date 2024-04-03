function goSearch(){	//검색입력 우측 검색이미지 클릭시 검색페이지 호출
	var searchText = $('#search_text').val();
	searchText = searchText.replace(/(^\s*)|(\s*$)/gi, "");	//앞뒤 공백제거
	var targetForm = document.search_form;
	console.log(targetForm);
	if(searchText == "") {
		alert("검색어를 입력해주세요.");
		return ;
	}
	else{
		$('#search_text').val(searchText);
		targetForm.submit();
	}
	return false;
}

function searchKeyword(keyword){	//자동완성 및 최근검색어 리스트에서 클릭시 검색페이지 호출
	$('#search_text').val(keyword);
	var targetForm = document.search_form;
	targetForm.submit();
}

// 다이퀘스트 수정
function refresh_form() { // 선택해제 버튼 클릭 시
	$("#more_price").val("");
	$("#under_price").val("");
	$("#more_text").val("");
	$("input[name=brandChkList[]]:checkbox").attr("checked", false);
	$("input[name=category_chk[]]:checkbox").attr("checked", false);
}
// 다이퀘스트 추가 - 숫자입력시 콤마 표기하기
function fnOnlyNumber(obj){
	var val = obj.value.replace(/,/g, "");
	var val2 = val.substr(0, 1);
	var val3 = val.length;
	if(val2 == 0){
		val = val.substr(1, val3);
	}
	obj.value = num_format(val);
}
function num_format(n){
	var reg = /(^[+-]?\d+)(\d{3})/;   // 정규식
	n = String(n);    //숫자 -> 문자변환
	while(reg.test(n)){
		n = n.replace(reg, "$1" + "," + "$2");
	}
	return n;
}