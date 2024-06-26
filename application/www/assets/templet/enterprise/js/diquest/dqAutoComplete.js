
	var dq_searchForm = document.search_form;
	var dq_searchFormTextbox = document.getElementById("search_text").value;
	var dq_searchTextbox = document.getElementById("search_text");

	var dq_resultDivID = "auto_search_area";               //자동완성레이어 ID
	var dq_hStartTag = "<b>";                    //하이라이팅 시작 테그
	var dq_hEndTag = "</b>";                     //하이라이팅 끝 테그
	var dq_bgColor = "#D2D2D2";                  //선택빽그라운드색
	var dq_intervalTime = 500;                   //자동완성 입력대기 시간
	
	//고정값
	var dq_acResult = new Object();              //결과값
	var dq_acLine = 0;                           //자동완성 키워드 선택  위치(순번)	
	var dq_searchResultList = "";                //자동완성결과리스트	
	var dq_searchKeyword = "";	                 //검색어(한영변환안된)
	var dq_ajaxReqObj = "";                      //ajax request object

	var dq_keyStatus = 1;                        //키상태구분값
	var dq_acuse = 1;                            //자동완성사용여부
	var dq_engFlag = 0;                          //자동완성한영변환체크
	var dq_acDisplayFlag = 0;                    //자동완성 display 여부
	var dq_acArrowFlag = 0;                      //마우스이벤트용 flag	
	var dq_acArrowOpenFlag = 0;                  //마우스이벤트용 flag
	var dq_acFormFlag = 0;                       //마우스이벤트용 flag
	var dq_acListFlag = 0;                       //자동완성 레이어 펼쳐진 상태 여부
	var dq_browserType = dqc_getBrowserType();	 //브라우져타입
	var dq_keywordBak = "";                      //키워드빽업
	var dq_keywordOld = "";                      //키워드빽업
	
	dq_keywordBak = dq_keywordOld = dq_searchTextbox.value;
	
	//엔터체크
	function dq_handleEnter(event)
	{		
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode; 

		if (keyCode == 13)
		{
			//검색스크립트
			goSearch();	
			return false;
		}	
		else
		{
			return true;
		}
		return false;
	}
	
	//마우스클릭시검색
	function dq_keywordSearch(keyword)
	{
		dq_searchTextbox.value = keyword;
		dq_searchForm.submit();
	}
	
	//입력값 체크 - setTextbox
	function dq_setTextbox(flag, ev) 
	{		
		var _event; 
		var key;
				
		dq_stateChange();
		
		switch(dq_browserType)
		{
			case 1 : // IE
				_event = window.event;				
				key = _event.keyCode;
				break;
			case 2 : // Netscape
				key = ev.which;
				break;
			default :				
				key = _event.keyCode;
				break;
		}
							
		if(dq_keyStatus == 1 && flag && key != 13)
			dq_keyStatus = 2;	
	}
		
	//자동완성레이어 상태변경 - wd
	function dq_stateChange() 
	{			
		dq_searchTextbox.onclick = dq_acDisplayView;
		//dq_searchTextbox.onblur = dq_acDisplayCheck;
		document.body.onclick = dq_acDisplayCheck;				
	}
	
	//자동완성레이어 보여 주기 - req_ipc
	function dq_acDisplayView() 
 	{ 
		dq_acDisplayFlag = 1;
		dq_acFormFlag = 0;
		dq_reqAcResultShow();
 	}

	//자동완성레이어 감추기전  체크 - dis_p
 	function dq_acDisplayCheck() 
 	{
		if(dq_acDisplayFlag) 
		{ 
			dq_acDisplayFlag=0;			
			return ;
		} 
			
		if(dq_acArrowFlag)		
			return;
				
	
		if(dq_acFormFlag)
			return;
		
		dq_acDisplayHide();
	}
 	
 	//자동완성레이어 감추기 - ac_hide
 	function dq_acDisplayHide()
 	{  		
 		var resultDiv = document.getElementById(dq_resultDivID);
 		
		if(resultDiv.style.display == "none") 
			return ;
		
		dq_setDisplayStyle(0);
		dq_acListFlag = 0;
		dq_acLine = 0;
	}
 	
 	//자동완성레이어 display style 설정 - popup_ac
 	function dq_setDisplayStyle(type)
 	{	 		
 		var resultDiv = document.getElementById(dq_resultDivID);

 		if(type==0)
		{
			resultDiv.style.display = "none";
			//dq_switchImage(0);
		}
		else if(type==1)
		{
			resultDiv.style.display = "block";
			//dq_switchImage(1);
		}
		else if(type==2)
		{
			resultDiv.style.display = "none";
			//dq_switchImage(1);
		}		
 	}
 	
 	//자동완성 결과 보기 요청 - req_ac2
 	function dq_reqAcResultShow() 
	{		
 		var resultDiv = document.getElementById(dq_resultDivID);
 		
		if(dq_searchTextbox.value == "" || dq_acuse == 0)
			return ;
			
	 	if(dq_acListFlag && dq_acDisplayFlag)
	 	{ 
	 		dq_acDisplayHide();
			return;
		} 
	
		var o = dq_getAcResult();
	 	if(o && o[1][0] != "") 
	 		dq_acResultShow(o[0], o[1], o[2]);
	 	else
	 		dq_reqSearch();
 	}
 	
 	//자동완성 결과 object 리턴 - get_cc
 	function dq_getAcResult()
 	{ 
		var ke = dqc_trimSpace(dq_searchTextbox.value);
		
	 	return typeof(dq_acResult[ke])=="undefined" ? null : dq_acResult[ke];
 	} 
 	
 	//자동완성 결과 object 생성 - set_cc
 	function dq_setAcResult(aq, al)
 	{
 		dq_acResult[aq] = new Array(aq, al);
 	}
 	
 	//자동완성 결과 보기 - ac_show
 	function dq_acResultShow(aq, al)
 	{
		if(aq != dqc_trimSpace(dq_searchTextbox.value))
			dq_engFlag = 1;
 		else
			if(aq && aq != "" && aq != dqc_trimSpace(dq_searchTextbox.value)) 			
				return ;

	 	dq_searchKeyword = aq;
	 	dq_searchResultList = al;
	 	dq_printAcResult();
								
	 	if(dq_searchResultList.length)
		 	dq_acListFlag = 1;
	 	else
			dq_acListFlag = 0;
		
	 	if(dq_acListFlag)
	 	{ 
	 		dq_setAcPos(0);
			
			if(dq_browserType == 1)
				dq_searchTextbox.onkeydown = dq_acKeywordTextViewIE;
			else if(dq_browserType == 2)
				dq_searchTextbox.onkeydown = dq_acKeywordTextViewFF;
		} 
	} 
 	
 	//자동완성결과 라인 위치 지정 - set_acpos
 	function dq_setAcPos(v)
 	{
 		dq_acLine = v;
		setTimeout('dq_setAcLineBgColor();', 10);
 	}
 	
 	//자동완성레이어에 결과 출력 - print_ac
 	function dq_printAcResult() 
 	{ 
 		var resultDiv = document.getElementById(dq_resultDivID);
		if(dq_searchResultList[0] == "" ){
			resultDiv.innerHTML = dq_getAcNoResultList();
		}
	 	else{
	 		resultDiv.innerHTML = dq_getAcResultList();
		}
	 			 	
		dq_setDisplayStyle(1); //자동완성창 보여줌.
	 	
	 	setTimeout('dq_setAcLineBgColor();', 10); 		
 	}
 	
 	//자동완성 키워드 라인의 백그라운드색 설정 - set_ahl
 	function dq_setAcLineBgColor()
 	{
 		var o1, o2, qs_ac_len;
		
		if(!dq_acListFlag)
			return;
		
		qs_ac_len = dq_searchResultList.length;
	 	for(var i=0;i<qs_ac_len;i++)
	 	{
			o1 = document.getElementById('dq_ac' + (i+1));
			
			if(o1 != null)
			{			
				if((i+1) == dq_acLine)
					o1.style.backgroundColor = dq_bgColor;
				else
					o1.style.backgroundColor = '';
			}
		}
 	}
 	
 	//자동완성레이어의 선택된 키워드를 textbox에 넣어줌(IE) - ackhl
 	function dq_acKeywordTextViewIE()
	{
		var e = window.event;
		var ac, acq;
		var resultDiv = document.getElementById(dq_resultDivID);
		var qs_ac_len = dq_searchResultList.length;
		//alert("IE : "+e.keyCode);
		//showKeycode = document.getElementById("keyCode");
		//showKeycode.innerHTML = "<a href=\"javascript:;\" >IE : "+e.keyCode+"</a>";
		/*
		 keycode
		 9 : TAB
		 ENTER : 13
		 화살표 좌 : 37
		 화살표 우 : 39
		 화살표 위 : 38
		 화살표 아래 : 40
		 */
	 	if(e.keyCode==39 &&  dq_searchTextbox.value != "" )
	 		dq_reqAcResultShow();	 	 
	 	
	 	if(e.keyCode==40 || (e.keyCode==9 && !e.shiftKey))
	 	{
		 	if(!dq_acListFlag && dq_searchTextbox.value != "" )	//최근검색어 레이어와 충돌방지 위해 조건 추가
		 	{
				dq_reqAcResultShow();
			 	return;
			}
			
			if(dq_acLine < qs_ac_len && dq_searchResultList != null && dq_searchResultList[0] != '' && dq_searchTextbox.value != "" )	//최근검색어 레이어와 충돌방지 위해 조건 추가
			{
				if(dq_acLine == 0)
					dq_keywordBak = dq_searchTextbox.value;
				
				dq_acLine++;
						 
			 	ac = eval('dq_ac' + dq_acLine);
			 	acq = eval('dq_acqHidden' + dq_acLine);
			 	//alert(acq.outerText);
			 	//dq_keywordOld = dq_searchTextbox.value = acq.outerText;
			 	dq_keywordOld = dq_searchTextbox.value = acq.value;
			 	//ac.focus();
			 	dq_searchTextbox.focus() ;
			 	dq_setAcLineBgColor();
			 	e.returnValue = false;
		 	}
	 	}
	 	
	 	if( (dq_acListFlag && (e.keyCode==38 || (e.keyCode==9 && e.shiftKey))) && dq_searchTextbox.value != "")	//최근검색어 레이어와 충돌방지 위해 조건 추가
	 	{		 			 	
			if(!dq_acListFlag) 
				return;
		 
		 	if(dq_acLine <= 1)
		 	{ 
		 		dq_acDisplayHide();
			 	dq_keywordOld = dq_searchTextbox.value = dq_keywordBak;
		 	} 
		 	else
		 	{
				dq_acLine--;
							
			 	ac = eval('dq_ac'+ dq_acLine);
			 	acq = eval('dq_acqHidden' + dq_acLine);
			 	//dq_keywordOld = dq_searchTextbox.value = acq.outerText;
			 	dq_keywordOld = dq_searchTextbox.value = acq.value;
			 	//ac.focus();
			 	dq_searchTextbox.focus() ;
			 	dq_setAcLineBgColor();
			 	e.returnValue = false;
			}
		}
	}
 	
 	//자동완성레이어의 선택된 키워드를 textbox에 넣어줌(IE외 브라우져) - ackhl_ff
 	function dq_acKeywordTextViewFF(fireFoxEvent)
	{		
		var ac, acq;
		var resultDiv = document.getElementById(resultDiv);
		var qs_ac_len = dq_searchResultList.length;
		//alert("FF : "+fireFoxEvent.keyCode);
		//showKeycode = document.getElementById("keyCode");
		//showKeycode.innerHTML = "<a href=\"javascript:;\" >FF : "+fireFoxEvent.keyCode+"</a>";
		
	 	if(fireFoxEvent.keyCode==39 && dq_searchTextbox.value != "")	//최근검색어 레이어와 충돌방지 위해 조건 추가
	 		dq_reqAcResultShow();
	 		 
	 	if( (fireFoxEvent.keyCode==40 || (fireFoxEvent.keyCode==9 && !fireFoxEvent.shiftKey)) && dq_searchTextbox.value != "")	//최근검색어 레이어와 충돌방지 위해 조건 추가
	 	{			
		 	if(!dq_acListFlag)
		 	{
		 		dq_reqAcResultShow();
			 	return;
			}
			
			if(dq_acLine < qs_ac_len && dq_searchResultList != null && dq_searchResultList[0] != '' )	//최근검색어 레이어와 충돌방지 위해 조건 추가
			{ 
				if(dq_acLine == 0) 
					dq_keywordBak = dq_searchTextbox.value;
					
				dq_acLine++;
						 
			 	ac = document.getElementById('dq_ac' + dq_acLine);
			 	acq = document.getElementById('dq_acqHidden' + dq_acLine);
			 	
			 	dq_keywordOld = dq_searchTextbox.value = acq.value;
			 	//$("#dq_ac"+dq_acLine).focusin();
			 	//ac.focus();
			 	dq_searchTextbox.focus() ;
			 	dq_setAcLineBgColor();
			 	fireFoxEvent.preventDefault();
		 	}
	 	}
	 	
	 	if( (dq_acListFlag && (fireFoxEvent.keyCode==38 || (fireFoxEvent.keyCode==9 && fireFoxEvent.shiftKey))) && dq_searchTextbox.value != "")	//최근검색어 레이어와 충돌방지 위해 조건 추가
	 	{
			if(!dq_acListFlag) 
				return;
		 
		 	if(dq_acLine <= 1)
		 	{ 
		 		dq_acDisplayHide();
			 	dq_keywordOld = dq_searchTextbox.value = dq_keywordBak;
		 	} 
		 	else
		 	{
		 		dq_acLine-- ;
			 
			 	ac = document.getElementById('dq_ac' + dq_acLine);
			 	acq = document.getElementById('dq_acqHidden' + dq_acLine);
			 	
			 	dq_keywordOld = dq_searchTextbox.value = acq.value;
			 	//$("#dq_ac"+dq_acLine).focusin();
			 	//ac.focus();
			 	dq_searchTextbox.focus() ;
			 	dq_setAcLineBgColor() ;
			 	fireFoxEvent.preventDefault();
			}
		}						
	}
 	
 	//검색요청 - reqAc
 	function dq_reqSearch() 
 	{	 				
		var sv;
		var ke = dqc_trimSpace(dq_searchTextbox.value);
		
		ke = ke.replace(/ /g, "%20");
		
		while(ke.indexOf("\\") != -1)
			ke = ke.replace(/ /g, "%20").replace("\\", "");
		
		while(ke.indexOf("\'") != -1)
			ke = ke.replace(/ /g, "%20").replace("\'", "");
	 
	 	if(ke == "")
	 	{ 
	 		dq_acDisplayHide();
			return;
		} 
	 	sv = "/shop/search_autocomplete.php?q=" + encodeURIComponent(ke);
	 	dq_ajaxReqObj = dqc_getXMLHTTP();
	 	
	 	if(dq_ajaxReqObj)
	 	{ 		 		
			dq_ajaxReqObj.open("GET", sv, true);
		 	dq_ajaxReqObj.onreadystatechange = dq_acShow;
	 	} 
	 
	 	try
	 	{		 	
			dq_ajaxReqObj.send(null);
	 	}
	 	catch(e)
	 	{		
			return 0;
		} 
	}
 
 	//자동완성 결과 보기 - showAC
 	function dq_acShow() 
 	{	 		
		if(dq_acuse == 1)
	 	{		 		
			if(dq_ajaxReqObj.readyState==4 && dq_ajaxReqObj.responseText && dq_ajaxReqObj.status==200)
			{					
				eval(dq_ajaxReqObj.responseText);
				dq_setAcResult(dq_searchKeyword, dq_searchResultList);
				dq_acResultShow(dq_searchKeyword, dq_searchResultList);
			}
	 	}
	 	else
	 	{
	 		dq_setDisplayStyle(2);
	 	}
 	}
 	
 	//선택키워드저장 - set_acinput
 	function dq_setAcInput(keyword) 
 	{	 		
		if(!dq_acListFlag) 
			return;				
		
	 	dq_keywordOld = dq_searchTextbox.value = keyword;		 			 	
	 	dq_searchTextbox.focus();
	 	dq_acDisplayHide();		 
 	}
 	
 	//기능끄기 버튼을 눌렀을때 - ac_off
	function dq_acOff() 
	{		
		if(dq_searchTextbox.value == "")
			dq_setDisplayStyle(0);
		else
			dq_acDisplayHide();
	
		dq_acuse = 0;
 	}

	//화살표클릭 - show_ac
	function dq_acArrow()
	{			
		var resultDiv = document.getElementById(dq_resultDivID);
		
		if(dq_acuse == 0)
		{
			dq_keywordOld = "";
			dq_acuse = 1;		
			
			if(dq_searchTextbox.value == "")			
				resultDiv.innerHTML = dq_getAcOnNoKeyword();			
		}
		else
		{
			if(dq_searchTextbox.value == "")
				resultDiv.innerHTML = dq_getAcNoKeyword();						
		}
		
		if(dq_searchTextbox.value == "" && (resultDiv.style.display == "block"))
			dq_setDisplayStyle(0);
		else
			dq_setDisplayStyle(1);
		
		dq_acDisplayView();
		dq_searchTextbox.focus();
		dq_wi();
		
		document.body.onclick=null;
	}
	
	//검색어입력창의 자동완성 화살표를 위, 아래로 변경한다. - switch_image	
	function dq_switchImage(type)
	{			
		var arrow_obj = document.getElementById("dq_autoImg");
		var arrow_Img_obj = document.getElementById("dq_autoImgSrc");
		
		//var former_part = arrow_obj.substring(0,arrow_obj.length-6);
		
		if(type==0)
		{
			//document.getElementById("dq_autoImg").src = former_part+"Dn.gif";
			//document.getElementById("dq_autoImg").title = "자동완성 펼치기";
			arrow_obj.className = "key_btn ";
			arrow_Img_obj.src = arrow_Img_obj.src.replace("_on","_off");
		}
		else if(type==1)
		{			
			//document.getElementById("dq_autoImg").src = former_part+"Up.gif";
			//document.getElementById("dq_autoImg").title = "자동완성 닫기";
			
			arrow_obj.className = "key_btn on";
			arrow_Img_obj.src = arrow_Img_obj.src.replace("_off","_on");
		}
 	}
	
	//자동완성 레이어 mouse on
	function dq_setMouseon() 
 	{ 		
	 	dq_acFormFlag = 1;
 	}

	//자동완성 레이어 mouse out
 	function dq_setMouseoff()
 	{		
	 	dq_acFormFlag = 0;		
		dq_searchTextbox.focus();
 	}
 	
 	//자동완성 결과 코드 - get_aclist
 	function dq_getAcResultList()
 	{ 	 		 	
 		var keywordOrign = "";
 		var keywordList = null;
 		var keyword = "";
 		var location = "";
 		var keywordLength = 0;
 		var lenValue = 50;
 		var text = "";
 		var pos = 0;
 		text += "<ul>"
		//console.log(dq_searchResultList.length);
 		if(dq_searchResultList != null && dq_searchResultList.length > 0){
		 	for(var i=0;i<dq_searchResultList.length;i++)
		 	{
		 		//keywordList = dq_searchResultList[i].split("_");
		 		//location = keywordList[1];
				keyword = keywordOrign = dq_searchResultList[i];
		 		keywordLength = dqc_strlen(keywordOrign);
				
				if(keywordLength > lenValue)
					keyword = dqc_substring(keywordOrign, 0, lenValue) + "..";
				 
				if(dq_engFlag == 0)
					pos = keywordOrign.toLowerCase().indexOf(dq_searchTextbox.value.toLowerCase());
				else if(dq_engFlag == 1)
					pos = keywordOrign.toLowerCase().indexOf(dq_searchKeyword.toLowerCase());
			
				if(pos >= 0)
				{
					if(pos == 0)
					{
						if(dq_engFlag == 0)
							keyword = dqc_highlight(keyword, dq_searchTextbox.value, 0, dq_hStartTag, dq_hEndTag);
						else if(dq_engFlag == 1)
							keyword = dqc_highlight(keyword, dq_searchKeyword, 0, dq_hStartTag, dq_hEndTag);
					}
					else if(pos == keywordOrign.length - 1)
					{
						if(dq_engFlag == 0)
							keyword = dqc_highlight(keyword, dq_searchTextbox.value, -1, dq_hStartTag, dq_hEndTag);
						else if(dq_engFlag == 1)
							keyword = dqc_highlight(keyword, dq_searchKeyword, -1, dq_hStartTag, dq_hEndTag);													
					}												
					else
					{						
						if(dq_engFlag == 0)
							keyword = dqc_highlight(keyword, dq_searchTextbox.value, pos, dq_hStartTag, dq_hEndTag);
						else if(dq_engFlag == 1)
							keyword = dqc_highlight (keyword, dq_searchKeyword, pos, dq_hStartTag, dq_hEndTag);
					}
				}
				//alert(keyword);
				text += "<li><a id='dq_ac" + (i+1) + "' onmouseover=\"dq_setAcPos('" + (i+1) + "');\" onFocus=\"dq_setAcPos('" + (i+1) + "');\" onmouseout=\"dq_setAcPos(0);\"  onclick=\"dq_setAcInput('" + keywordOrign + "');\" onkeypress=\"javascript:dq_setAcInput('" + keywordOrign + "'\");>"+keyword +"</a></li>";
				//text += "<a href=\"javascript:searchKeyword('"+keywordOrign+"');\">"+keyword +  "</a>";
				//text += "</li>";
				text += "<input type=\"hidden\" id=\"dq_acqHidden" + (i+1) + "\" value=\"" + keywordOrign + "\"/>";
				
				
		 	}
 		}else{
			text += "<li>자동완성 결과가 없습니다.</li>";
		}
		text += "</ul>";
	 	return text;
	}
 	
 	function showTip(tip) 
 	{
 		if(tip==1)
 			dq_searchForm.tipShow.style.display = "block";
 		else
 			dq_searchForm.tipShow.style.display = "none";
 	}
 	//자동완성 결과 없는 경우 - get_ac0
 	function dq_getAcNoResultList() 
 	{ 	 		
 		var text = "";
 		var ment = "해당 단어로 시작하는 검색어가 없습니다.";
	 	
 		text += "<ul><li><a href=\"javascript:;\" >";
 		text += ment;
 		text += "</a></li></ul>";
 		//text += "<dl>";
		//text += "	<dt class=\"font_class_b\">기획전/이벤트</dt>";
	 	//text += "</dl>";
	 	return text;
 	}
 	
 	//자동완성 키워드 없는 경우
 	function dq_getAcNoKeyword() 
 	{ 	 		
 		var text = "";
 		var ment = "현재 자동완성 기능을 사용하고 계십니다..";
	 	
 		//text += "<div>";
 		text += "<ul><li><a href=\"javascript:;\" >";
 		text += ment;
 		text += "</a></li></ul>";
		//text += "<dl>";
		//text += "	<dt class=\"font_class_b\">기획전/이벤트</dt>";
	 	//text += "</dl>";
 		
	 	return text;
 	}
 	
 	//자동완성 복구시 키워드 없는 경우
 	function dq_getAcOnNoKeyword() 
 	{ 	 		
 		var text = "";
 		var ment = "자동완성기능이 활성화 되었습니다.";
	 	
 		
 		//text += "<div>";
 		text += "<ul><li><a href=\"javascript:;\" >";
 		text += ment;
 		text += "</a></li></ul>";
 		//text += "<dl>";
		//text += "	<dt class=\"font_class_b\">기획전/이벤트</dt>";
	 	//text += "</dl>";

	 	return text;
 	}

 	//검색박스 키워드 처리 루프 - wi()
 	function dq_wi() 
 	{	 		
		if(dq_acuse==0)
			return;
		
		var keyword = dq_searchTextbox.value;

	 	if(keyword == "" && keyword != dq_keywordOld)
	 		dq_acDisplayHide();
	 	
		if(keyword != "" && keyword != dq_keywordOld && dq_keyStatus != 1)
		{
			var o = null;
			
			o = dq_getAcResult();
			
			if(o && o[1][0] != "") 
				dq_acResultShow(o[0], o[1], o[2]);
			else
				dq_reqSearch();
		}
		
		dq_keywordOld = keyword;		
		setTimeout("dq_wi()", dq_intervalTime);
 	}
 	
	setTimeout("dq_wi()", dq_intervalTime);
