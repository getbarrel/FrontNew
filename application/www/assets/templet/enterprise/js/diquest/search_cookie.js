function setSearchCookie( cookieName, cookieValue)
{
	var ex = getSearchCookie( cookieName );
	cookieValue = trimKeyword(cookieValue);
	var isExist = ex.indexOf(cookieValue+"|;|");
	if(isExist != -1){	//중복되는 키워드 제거
		ex = ex.replace(cookieValue+"|;|","");
	}
	var cookieLength = 10;	//쿠키에 10개까지 저장
	//alert(ex);
	//var re = /[~!@\#$%^&*\()\=+|\\/:;?"<>']/gi;
	//cookieValue = cookieValue.replace(re, "");
	ex = cookieValue + "|;|" + ex;
	var strArray = ex.split("|;|");	
	var output = "";
	
	for(var i=0;i < strArray.length && i< cookieLength;i++){
		if(strArray[i] != ""){
			output = output + strArray[i] + "|;|";
		}				
	}	
	//document.cookie = cookieName + "=" + escape( output ) + ";";
	var cookie =document.cookie;
	var ExpDate = new Date();
	ExpDate.setTime(ExpDate.getTime() + 1000*60*60*24);	//쿠키 만료일 (하루)

	startIndex = cookie.indexOf( cookieName );
	endIndex = cookie.indexOf( ";", startIndex );
	var cookieReplace = cookie.substring(0,startIndex)+cookie.substring(endIndex+1,cookie.length);
	cookieReplace = cookieReplace.replace(" ","");
	document.cookie = cookieName + "=" + escape( output ).replace("undefined","") + "; path=/;expires=" + ExpDate.toGMTString() + ";";
	//document.cookie = cookie.substring(0,startIndex)+cookieName + "=" + escape( output ) + ";"+cookie.substring(endIndex+1,cookie.length);;
}
function strCheck(str,array){
	for(var i=0;i<array.length;i++){
		if(str==array[i]){
			return i;
		}
	}
	return -1;
}
function delSearchCookieAll(cookieName){	//최근검색어 전체삭제
	var ExpDate = new Date();
	ExpDate.setTime(ExpDate.getTime() + 1000*60*60*24);	//쿠키 만료일 (하루)
	document.cookie = cookieName + "=" + "; path=/;expires=" + ExpDate.toGMTString() + ";";

	var targetDiv = document.getElementById("search_cookie");
	var str2="<p class=\"tit font_class_b\">최근검색어</p>\n";
	str2 = str2 + "<ol>\n";
	str2 = str2 + "</ol>\n";
	str2 = str2 + "<p class=\"del\"><a href=\"javascript:delSearchCookieAll('searchQuery');\">기록삭제</a></p>\n";
	targetDiv.innerHTML=str2;

}
function delSearchCookie(cookieName,cookieVal){
	var ex = getSearchCookie(cookieName);
	ex = ex.replace(cookieVal+"|;|","");
	var ExpDate = new Date();
	ExpDate.setTime(ExpDate.getTime() + 1000*60*60*24);	//쿠키 만료일 (하루)
	document.cookie = cookieName + "=" + escape( ex ) + "; path=/;expires=" + ExpDate.toGMTString() + ";";
}
function getSearchCookie( cookieName ){	
	var cookie = document.cookie;
	
	if( cookie.length > 0 )	{
		// 해당 쿠키명이 존재하는지 검색한 후 존재하면 위치를 리턴.
		startIndex = cookie.indexOf( cookieName );
		if( startIndex != -1 )	{
			startIndex += cookieName.length;
	
			endIndex = cookie.indexOf( ";", startIndex );
	
			if( endIndex == -1) endIndex = cookie.length;
	
			return unescape( cookie.substring( startIndex + 1, endIndex ) );
		}
		else	{
			return "";
		}
	}
	else	{
		return "";
	}
}

function deleteKeyword(keyword){
	cookieName = "searchQuery";
	var ex = getSearchCookie( cookieName );
	var isExist = ex.indexOf(keyword+"|;|");
	if(isExist != -1){	// 키워드 제거
		ex = ex.replace(keyword+"|;|","");
	}
		
	document.cookie = cookieName + "=" + escape( ex ) + "; path=/";
	var cookieLength = 10;	//쿠키에 10개까지 저장
	var str=getSearchCookie("searchQuery");
	var str2="<ul>";
	var targetDiv = document.getElementById("searchQuery");
	var allCookies=str.split('|;|');
	if(str != ""){								
		for (var i=0;i < allCookies.length && i < cookieLength;i++){
			if(allCookies[i] != ""){
				//var re = /[~!@\#$%^&*\()\=+|\\/:;?"<>']/gi;
				//allCookies[i] = allCookies[i].replace(re, "");
				str2=str2+"<li><a href=\"javascript:searchKeyword('"+allCookies[i]+"');\">"+allCookies[i]+"</a>\n<a href=\"javascript:deleteKeyword('"+allCookies[i]+"');\"class=\"btn_del\" ><img src=\"/Resource_new/image/sub/search/btn_delte_findwrod.gif\" alt=\"검색어 삭제\" /></a></li>";
			}
		}
		str2=str2+"</ul>";
		targetDiv.innerHTML=str2;
	} 
	
	if(allCookies.length == 1) {								
		targetDiv.innerHTML = "";
	}
}

function trimKeyword(str){
	return str.replace(/(^\s*)|(\s*$)/gi, "");
}