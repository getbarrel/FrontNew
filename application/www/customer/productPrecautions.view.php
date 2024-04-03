<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$view = getForbizView();

if($_REQUEST['mode'] == ""){
	$view->define('customerTop', 'customer/index/customer_top.htm');

	//$view->define('content', 'customer/product_precautions/product_precautions_content.htm');
	$productModel = $view->import('model.mall.product');

	$laundryOneDepth	= $productModel->getLaundryList(0, '');
	$laundryTwoDepth	= $productModel->getLaundryList(1, substr($laundryOneDepth[0]['cid'],0,3));

	$o = 0;
	foreach($laundryTwoDepth as $twoValue){
		$laundry[$o]['cid']			= $twoValue['cid'];
		$laundry[$o]['title']		= $twoValue['title'];
		$laundry[$o]['title_en']	= $twoValue['title_en'];

		$laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));

		$laundry[$o]['firstCid'] = $laundryThreeDepth[0]['cid'];
		$t = 0;
		foreach($laundryThreeDepth as $threeValue){
			$laundry[$o]['three'][$t]['cid']		= $threeValue['cid'];
			$laundry[$o]['three'][$t]['title']		= $threeValue['title'];
			$laundry[$o]['three'][$t]['title_en']	= $threeValue['title_en'];

			$laundryFourDepth	= $productModel->getLaundryList(3, substr($threeValue['cid'],0,9));

			if($o == 0 && $t == 0){
				$laundryThreeFirst = $threeValue['cid'];
			}

			$f = 0;
			foreach($laundryFourDepth as $fourValue){
				if($fourValue['title'] == "중성세제") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "01";
				}else if($fourValue['title'] == "수돗물 세탁") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "02";
				}else if($fourValue['title'] == "건조기 금지") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "03";
				}else if($fourValue['title'] == "미끄럼틀 금지") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "04";
				}else if($fourValue['title'] == "트렁크 금지") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "05";
				}else if($fourValue['title'] == "모래끼임") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "06";
				}else if($fourValue['title'] == "오일") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "07";
				}else if($fourValue['title'] == "흙탕물 주의") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "08";
				}else if($fourValue['title'] == "보관 시") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "09";
				}else if($fourValue['title'] == "보관시") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "09";
				}else if($fourValue['title'] == "네오프렌 세척") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "10";
				}else if($fourValue['title'] == "세제 금지") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "11";
				}else if($fourValue['title'] == "직사광선 주의") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "12";
				}else if($fourValue['title'] == "날카로움 주의") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "13";
				}else if($fourValue['title'] == "손바닥 사용") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "14";
				}else if($fourValue['title'] == "옷걸이 건조") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "15";
				}else if($fourValue['title'] == "네오프렌 보관 시") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "16";
				}else if($fourValue['title'] == "표백제 금지") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "17";
				}else if($fourValue['title'] == "세탁망") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "18";
				}else if($fourValue['title'] == "다리미 사용 금지") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "19";
				}else if($fourValue['title'] == "건조 시") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "20";
				}else if($fourValue['title'] == "단독 손세탁") {
					$laundry[$o]['three'][$t]['four'][$f]['cnt']			= "21";
				}
			
				$laundry[$o]['three'][$t]['four'][$f]['cid']			= $fourValue['cid'];
				$laundry[$o]['three'][$t]['four'][$f]['title']			= $fourValue['title'];
				$laundry[$o]['three'][$t]['four'][$f]['contents']		= "<P>".str_replace(".",".</P><P>",$fourValue['contents'])."</P>";
				$laundry[$o]['three'][$t]['four'][$f]['title_en']		= $fourValue['title_en'];
				$laundry[$o]['three'][$t]['four'][$f]['contents_en']	= "<P>".str_replace(".",".</P><P>",$fourValue['contents_en'])."</P>";

				$f++;
			}
			$t++;
		}
		$o++;
	}

	$view->assign('laundryOneDepth', $laundryOneDepth);
	$view->assign('laundryTwoFirst', $laundryTwoDepth[0]['cid']);
	$view->assign('laundry', $laundry);

	echo $view->loadLayout();
} else if($_REQUEST['mode'] == "ajaxPc"){
	$productModel = $view->import('model.mall.product');

	$laundryOneDepth	= $productModel->getLaundryList(0, '');


	$laundryInfo .= "<div class='wash__category'>";

	$laundryInfo .= "	<div class='wash__category-item'>";
	$laundryInfo .= "		<div class='wash__category-title'>카테고리 선택</div>";
	$laundryInfo .= "		<div class='wash__category-select'>";
	$laundryInfo .= "			<label for='' class='hide'>카테고리 선택</label>";
	$laundryInfo .= "			<select name='laundryOneDepth' id='laundryOneDepth' onchange='laundryChange(this.value)'>";
	foreach($laundryOneDepth as $oneValue){
		$selected = "";
		if($oneValue['cid'] == $_REQUEST['cid']){
			$selected = "selected";
		}
		if(BASIC_LANGUAGE == "korean"){
			$laundryInfo .= "<option value='".$oneValue['cid']."' ".$selected.">".$oneValue['title']."</option>";
		} else {
			$laundryInfo .= "<option value='".$oneValue['cid']."' ".$selected.">".$oneValue['title_en']."</option>";
		}
	}
	$laundryInfo .= "			</select>";
	$laundryInfo .= "		</div>";
	$laundryInfo .= "	</div>";
	
	$laundryTwoDepth	= $productModel->getLaundryList(1, substr($_REQUEST['cid'],0,3));
	$o = 0;

	$laundryInfo .= "	<div class='wash__category-item'>";
	$laundryInfo .= "		<div class='wash__category-title'>상세 아이템 선택</div>";
	$laundryInfo .= "		<div class='wash__category-select'>";
	$laundryInfo .= "			<label for='' class='hide'>상세 아이템 선택</label>";

	$laundryInfo .= "			<select name='laundryOneDepth' id='laundryOneDepth' onchange='laundryChange2(this.value)'>";
	foreach($laundryTwoDepth as $twoValue){
		$selected2 = "";
		if($twoValue['cid'] == $_REQUEST['did']){
			$selected2 = "selected";
		}
		if($o == 0) {
			$selected2 = "selected";
		}
		if(BASIC_LANGUAGE == "korean"){
			$laundryInfo .= "<option value='".$twoValue['cid']."' ".$selected2.">".$twoValue['title']."</option>";
		} else {
			$laundryInfo .= "<option value='".$twoValue['cid']."' ".$selected2.">".$twoValue['title_en']."</option>";
		}
		$o++;
	}
	$laundryInfo .= "			</select>";
	$laundryInfo .= "		</div>";
	$laundryInfo .= "	</div>";
	$laundryInfo .= "</div>";

	if($_REQUEST['did'] != "") {
		$laundryThreeDepth	= $productModel->getLaundryList(2, substr($_REQUEST['did'],0,6));
	}else{
		$laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));
	}
	$t = 0;

	$laundryInfo .= "<div class='wash__contents'>";

	$laundryInfo .= "	<section class='wash__contents__category wash__contents__category--show'>";
	foreach($laundryThreeDepth as $threeValue){
		$laundryInfo .= "		<div class='contents__box'>";
		$laundryInfo .= "			<div class='contents__box-title'>";
		$laundryInfo .= "				<div class='title-sm'>";
		if(BASIC_LANGUAGE == "korean"){
			$laundryInfo .= $threeValue['title'];
		} else {
			$laundryInfo .= $threeValue['title_en'];
		}
		$laundryInfo .= "					</div>";
		$laundryInfo .= "				</div>";

		$laundryFourDepth	= $productModel->getLaundryList(3, substr($threeValue['cid'],0,9));
		$f = 0;

		$laundryInfo .= "<div class='contents__list'>";
		foreach($laundryFourDepth as $fourValue){
			if($fourValue['title'] == "중성세제") {
				$imgCnt			= "01";
			}else if($fourValue['title'] == "수돗물 세탁") {
				$imgCnt			= "02";
			}else if($fourValue['title'] == "건조기 금지") {
				$imgCnt			= "03";
			}else if($fourValue['title'] == "미끄럼틀 금지") {
				$imgCnt			= "04";
			}else if($fourValue['title'] == "트렁크 금지") {
				$imgCnt			= "05";
			}else if($fourValue['title'] == "모래끼임") {
				$imgCnt			= "06";
			}else if($fourValue['title'] == "오일") {
				$imgCnt			= "07";
			}else if($fourValue['title'] == "흙탕물 주의") {
				$imgCnt			= "08";
			}else if($fourValue['title'] == "보관 시") {
				$imgCnt			= "09";
			}else if($fourValue['title'] == "네오프렌 세척") {
				$imgCnt			= "37";
			}else if($fourValue['title'] == "세제 금지") {
				$imgCnt			= "11";
			}else if($fourValue['title'] == "직사광선 주의") {
				$imgCnt			= "12";
			}else if($fourValue['title'] == "날카로움 주의") {
				$imgCnt			= "13";
			}else if($fourValue['title'] == "손바닥 사용") {
				$imgCnt			= "14";
			}else if($fourValue['title'] == "옷걸이 건조") {
				$imgCnt			= "38";
			}else if($fourValue['title'] == "네오프렌 보관 시") {
				$imgCnt			= "39";
			}else if($fourValue['title'] == "표백제 금지") {
				$imgCnt			= "17";
			}else if($fourValue['title'] == "세탁망") {
				$imgCnt			= "18";
			}else if($fourValue['title'] == "다리미 사용 금지") {
				$imgCnt			= "19";
			}else if($fourValue['title'] == "건조 시") {
				$imgCnt			= "20";
			}else if($fourValue['title'] == "단독 손세탁") {
				$imgCnt			= "21";
			}else if($fourValue['title'] == "생활 방수") {
				$imgCnt			= "22";
			}else if($fourValue['title'] == "미지근한 온도") {
				$imgCnt			= "23";
			}else if($fourValue['title'] == "비틀기 금지") {
				$imgCnt			= "24";
			}else if($fourValue['title'] == "드라이클리닝 및 건조기 금지") {
				$imgCnt			= "25";
			}else if($fourValue['title'] == "충격 주의") {
				$imgCnt			= "26";
			}else if($fourValue['title'] == "화기 주의") {
				$imgCnt			= "27";
			}else if($fourValue['title'] == "수중 사용 금지") {
				$imgCnt			= "28";
			}else if($fourValue['title'] == "수경 세척 시") {
				$imgCnt			= "29";
			}else if($fourValue['title'] == "별도 사용 금지") {
				$imgCnt			= "30";
			}else if($fourValue['title'] == "올 관리") {
				$imgCnt			= "31";
			}else if($fourValue['title'] == "접촉 주의") {
				$imgCnt			= "14";
			}else if($fourValue['title'] == "유기 용액") {
				$imgCnt			= "07";
			}else if($fourValue['title'] == "유분 주의") {
				$imgCnt			= "07";
			}else if($fourValue['title'] == "안티포그액") {
				$imgCnt			= "30";
			}else if($fourValue['title'] == "렌즈 접촉 주의") {
				$imgCnt			= "14";
			}else if($fourValue['title'] == "중성 세제") {
				$imgCnt			= "01";
			}else if($fourValue['title'] == "오염주의") {
				$imgCnt			= "08";
			}else if($fourValue['title'] == "오염 주의") {
				$imgCnt			= "08";
			}else if($fourValue['title'] == "단독세탁") {
				$imgCnt			= "21";
			}else if($fourValue['title'] == "탈수기 및 건조기 금지") {
				$imgCnt			= "03";
			}else if($fourValue['title'] == "착용 시") {
				$imgCnt			= "32";
			}else if($fourValue['title'] == "30kg이하 사용 주의") {
				$imgCnt			= "33";
			}else if($fourValue['title'] == "어린이와 함께 사용 시") {
				$imgCnt			= "34";
			}else if($fourValue['title'] == "인명 구조 주의") {
				$imgCnt			= "35";
			}else if($fourValue['title'] == "인명구조 사용금지") {
				$imgCnt			= "35";
			}else if($fourValue['title'] == "강한 물살 주의") {
				$imgCnt			= "36";
			}else if($fourValue['title'] == "세탁 시") {
				$imgCnt			= "21";
			}else if($fourValue['title'] == "화장품이 묻었을 때") {
				$imgCnt			= "40";
			}else if($fourValue['title'] == "브라패드") {
				$imgCnt			= "01";
			}else if($fourValue['title'] == "조류 주의") {
				$imgCnt			= "28";
			}else if($fourValue['title'] == "보관 주의") {
				$imgCnt			= "09";
			}else if($fourValue['title'] == "아이가 사용 시") {
				$imgCnt			= "34";
			}else if($fourValue['title'] == "세척 방법") {
				$imgCnt			= "21";
			}else if($fourValue['title'] == "변형 주의") {
				$imgCnt			= "14";
			}else if($fourValue['title'] == "세탁 금지") {
				$imgCnt			= "25";
			}else{
				$imgCnt			= "0";
			}

			$laundryInfo .= "	<dl class='contents__item'>";
			$laundryInfo .= "		<dt class='contents__item-img'>";
			$laundryInfo .= "			<img src='/assets/templet/enterprise/assets/img/img_product_precautions".$imgCnt.".png' alt='".$fourValue['title']."' />";
			$laundryInfo .= "		</dt>";
			$laundryInfo .= "		<dd class='contents__item-cont'>";
			$laundryInfo .= "			<div class='contents__subtitle'>";
			if(BASIC_LANGUAGE == "korean"){
				$laundryInfo .= $fourValue['title'];
			} else {
				$laundryInfo .= $fourValue['title_en'];
			}

			$laundryInfo .= "			</div>";
			$laundryInfo .= "			<div class='contents__summary'>";
			if(BASIC_LANGUAGE == "korean"){
				$laundryInfo .= "<P>".str_replace(".",".</P><P>",$fourValue['contents'])."</P>";
			} else {
				$laundryInfo .= "<P>".str_replace(".",".</P><P>",$fourValue['contents_en'])."</P>";
			}
			$laundryInfo .= "			</div>";
			$laundryInfo .= "		</dd>";
			$laundryInfo .= "	</dl>";

			$f++;
		}
		$laundryInfo .= "</div>";
		$laundryInfo .= "</div>";
		$t++;
	}
	$laundryInfo .= "	</section>";


	$laundryInfo .= "</div>";

	echo $laundryInfo;
} else if($_REQUEST['mode'] == "ajaxMo"){
	$productModel = $view->import('model.mall.product');

	$laundryOneDepth	= $productModel->getLaundryList(0, '');

	$laundryInfo .= "<div class='wash__select'>";
	$laundryInfo .= "<div class='wash__select-item'>";
	$laundryInfo .= "<div class='br__form-item'>";
	$laundryInfo .= "<label for='' class='hidden'>카테고리 선택</label>";
	$laundryInfo .= "<select class='br__form-select' name='laundryOneDepth' id='laundryOneDepth' onchange='laundryChange(this.value)'>";
	foreach($laundryOneDepth as $oneValue){
		$selected = "";
		if($oneValue['cid'] == $_REQUEST['cid']){
			$selected = "selected";
		}
		if(BASIC_LANGUAGE == "korean"){
			$laundryInfo .= "<option value='".$oneValue['cid']."' ".$selected.">".$oneValue['title']."</option>";
		} else {
			$laundryInfo .= "<option value='".$oneValue['cid']."' ".$selected.">".$oneValue['title_en']."</option>";
		}
	}
	$laundryInfo .= "</select>";	
	$laundryInfo .= "</div>";
	$laundryInfo .= "</div>";

	$laundryTwoDepth	= $productModel->getLaundryList(1, substr($_REQUEST['cid'],0,3));
	$o = 0;

	$laundryInfo .= "<div class='wash__select-item'>";
	$laundryInfo .= "<div class='br__form-item'>";
	$laundryInfo .= "<label for='' class='hidden'>상세 아이템 선택</label>";
	$laundryInfo .= "<select name='laundryTwoDepth' id='laundryTwoDepth' onchange='laundryChange2(this.value)'>";
	foreach($laundryTwoDepth as $twoValue){
		$selected2 = "";
		if($twoValue['cid'] == $_REQUEST['did']){
			$selected2 = "selected";
		}

		if(BASIC_LANGUAGE == "korean"){
			$laundryInfo .= "<option value='".$twoValue['cid']."' ".$selected2.">".$twoValue['title']."</option>";
		} else {
			$laundryInfo .= "<option value='".$twoValue['cid']."' ".$selected2.">".$twoValue['title_en']."</option>";
		}
	}				
	$laundryInfo .= "</select>";	
	$laundryInfo .= "</div>";
	$laundryInfo .= "</div>";	
	$laundryInfo .= "</div>";			
						
	if($_REQUEST['did'] != "") {
		$laundryThreeDepth	= $productModel->getLaundryList(2, substr($_REQUEST['did'],0,6));
	}else{
		$laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));
	}
	$t = 0;

	$laundryInfo .= "<div class='wash__contents'>";
	$o = 0;

	foreach($laundryTwoDepth as $twoValue){
		if($o == 0) {
			$laundryInfo .= "<section class='wash__contents__category wash__contents__category--show wash__contents-".$twoValue['cid']."'>";
		} else {
			$laundryInfo .= "<section class='wash__contents__category wash__contents-".$twoValue['cid']."'>";
		}
		$laundryInfo .= "<div class='br-tab__wrap'>";
		$laundryInfo .= "<div class='br-tab__nav'>";
		$laundryInfo .= "<ul>";

		if($_REQUEST['did'] != "") {
			$laundryThreeDepth	= $productModel->getLaundryList(2, substr($_REQUEST['did'],0,6));
		}else{
			$laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));
		}


		$t = 0;
		foreach($laundryThreeDepth as $threeValue){
			if($t == 0){
				$laundryInfo .= "<li id='tab1' class='active'><a href='javascript:void(0);' onClick='checkTab(".$t.")'>";
			} else {
				$laundryInfo .= "<li id='tab2'><a href='javascript:void(0);' onClick='checkTab(".$t.")'>";
			}
			if(BASIC_LANGUAGE == "korean"){
				$laundryInfo .= $threeValue['title']."</a></li>";
			} else {
				$laundryInfo .= $threeValue['title_en']."</a></li>";
			}
			$t++;
		}
		$laundryInfo .= "</ul>";
		$laundryInfo .= "</div>";

		$laundryInfo .= "<div class='br-tab__contents-wrap'>";
		$t = 0;
	
		foreach($laundryThreeDepth as $threeValue){
			if($t == 0){
				$laundryInfo .= "<div id='content1' class='br-tab__contents active'>";
			} else {
				$laundryInfo .= "<div id='content2' class='br-tab__contents'>";
			}
			$laundryInfo .= "<div class='contents__list'>";
			
			$laundryFourDepth	= $productModel->getLaundryList(3, substr($threeValue['cid'],0,9));
			
			$f = 0;
			foreach($laundryFourDepth as $fourValue){
				if($fourValue['title'] == "중성세제") {
					$imgCnt			= "01";
				}else if($fourValue['title'] == "수돗물 세탁") {
					$imgCnt			= "02";
				}else if($fourValue['title'] == "건조기 금지") {
					$imgCnt			= "03";
				}else if($fourValue['title'] == "미끄럼틀 금지") {
					$imgCnt			= "04";
				}else if($fourValue['title'] == "트렁크 금지") {
					$imgCnt			= "05";
				}else if($fourValue['title'] == "모래끼임") {
					$imgCnt			= "06";
				}else if($fourValue['title'] == "오일") {
					$imgCnt			= "07";
				}else if($fourValue['title'] == "흙탕물 주의") {
					$imgCnt			= "08";
				}else if($fourValue['title'] == "보관 시") {
					$imgCnt			= "09";
				}else if($fourValue['title'] == "네오프렌 세척") {
					$imgCnt			= "37";
				}else if($fourValue['title'] == "세제 금지") {
					$imgCnt			= "11";
				}else if($fourValue['title'] == "직사광선 주의") {
					$imgCnt			= "12";
				}else if($fourValue['title'] == "날카로움 주의") {
					$imgCnt			= "13";
				}else if($fourValue['title'] == "손바닥 사용") {
					$imgCnt			= "14";
				}else if($fourValue['title'] == "옷걸이 건조") {
					$imgCnt			= "38";
				}else if($fourValue['title'] == "네오프렌 보관 시") {
					$imgCnt			= "39";
				}else if($fourValue['title'] == "표백제 금지") {
					$imgCnt			= "17";
				}else if($fourValue['title'] == "세탁망") {
					$imgCnt			= "18";
				}else if($fourValue['title'] == "다리미 사용 금지") {
					$imgCnt			= "19";
				}else if($fourValue['title'] == "건조 시") {
					$imgCnt			= "20";
				}else if($fourValue['title'] == "단독 손세탁") {
					$imgCnt			= "21";
				}else if($fourValue['title'] == "생활 방수") {
					$imgCnt			= "22";
				}else if($fourValue['title'] == "미지근한 온도") {
					$imgCnt			= "23";
				}else if($fourValue['title'] == "비틀기 금지") {
					$imgCnt			= "24";
				}else if($fourValue['title'] == "드라이클리닝 및 건조기 금지") {
					$imgCnt			= "25";
				}else if($fourValue['title'] == "충격 주의") {
					$imgCnt			= "26";
				}else if($fourValue['title'] == "화기 주의") {
					$imgCnt			= "27";
				}else if($fourValue['title'] == "수중 사용 금지") {
					$imgCnt			= "28";
				}else if($fourValue['title'] == "수경 세척 시") {
					$imgCnt			= "29";
				}else if($fourValue['title'] == "별도 사용 금지") {
					$imgCnt			= "30";
				}else if($fourValue['title'] == "올 관리") {
					$imgCnt			= "31";
				}else if($fourValue['title'] == "접촉 주의") {
					$imgCnt			= "14";
				}else if($fourValue['title'] == "유기 용액") {
					$imgCnt			= "07";
				}else if($fourValue['title'] == "유분 주의") {
					$imgCnt			= "07";
				}else if($fourValue['title'] == "안티포그액") {
					$imgCnt			= "30";
				}else if($fourValue['title'] == "렌즈 접촉 주의") {
					$imgCnt			= "14";
				}else if($fourValue['title'] == "중성 세제") {
					$imgCnt			= "01";
				}else if($fourValue['title'] == "오염주의") {
					$imgCnt			= "08";
				}else if($fourValue['title'] == "오염 주의") {
					$imgCnt			= "08";
				}else if($fourValue['title'] == "단독세탁") {
					$imgCnt			= "21";
				}else if($fourValue['title'] == "탈수기 및 건조기 금지") {
					$imgCnt			= "03";
				}else if($fourValue['title'] == "착용 시") {
					$imgCnt			= "32";
				}else if($fourValue['title'] == "30kg이하 사용 주의") {
					$imgCnt			= "33";
				}else if($fourValue['title'] == "어린이와 함께 사용 시") {
					$imgCnt			= "34";
				}else if($fourValue['title'] == "인명 구조 주의") {
					$imgCnt			= "35";
				}else if($fourValue['title'] == "세탁 시") {
					$imgCnt			= "21";
				}else if($fourValue['title'] == "화장품이 묻었을 때") {
					$imgCnt			= "40";
				}else if($fourValue['title'] == "브라패드") {
					$imgCnt			= "01";
				}else if($fourValue['title'] == "조류 주의") {
					$imgCnt			= "28";
				}else if($fourValue['title'] == "보관 주의") {
					$imgCnt			= "09";
				}else if($fourValue['title'] == "아이가 사용 시") {
					$imgCnt			= "34";
				}else if($fourValue['title'] == "세척 방법") {
					$imgCnt			= "21";
				}else if($fourValue['title'] == "변형 주의") {
					$imgCnt			= "14";
				}else if($fourValue['title'] == "세탁 금지") {
					$imgCnt			= "25";
				}else{
					$imgCnt			= "0";
				}

				$laundryInfo .= "	<dl class='contents__item'>";
				$laundryInfo .= "		<dt class='contents__item-img'>";
				$laundryInfo .= "			<img src='/assets/templet/enterprise/assets/img/img_product_precautions".$imgCnt.".png' alt='".$fourValue['title']."' />";
				$laundryInfo .= "		</dt>";
				$laundryInfo .= "		<dd class='contents__item-cont'>";
				$laundryInfo .= "			<div class='contents__subtitle'>";
				if(BASIC_LANGUAGE == "korean"){
					$laundryInfo .= $fourValue['title'];
				} else {
					$laundryInfo .= $fourValue['title_en'];
				}

				$laundryInfo .= "			</div>";
				$laundryInfo .= "			<div class='contents__summary'>";
				if(BASIC_LANGUAGE == "korean"){
					$laundryInfo .= "<P>".str_replace(".",".</P><P>",$fourValue['contents'])."</P>";
				} else {
					$laundryInfo .= "<P>".str_replace(".",".</P><P>",$fourValue['contents_en'])."</P>";
				}
				$laundryInfo .= "			</div>";
				$laundryInfo .= "		</dd>";
				$laundryInfo .= "	</dl>";

				$f++;
			}
			$laundryInfo .= "</div>";
			$laundryInfo .= "</div>";
			$t++;
		}

		$laundryInfo .= "</div>";
		$laundryInfo .= "</section>";
		$o++;
	}

	$laundryInfo .= "</div>";

	echo $laundryInfo;
}else if($_REQUEST['mode'] == "ajaxPcNew"){
    $productModel = $view->import('model.mall.product');

    $laundryOneDepth	= $productModel->getLaundryList(0, '');
    $laundryInfo .= "<div class='side-popup__content'>";
    $laundryInfo .= "    <div class='wash-wrap'>";
    $laundryInfo .= "        <div class='fb__form-group'>";
    $laundryInfo .= "            <div class='fb__form-item'>";
    $laundryInfo .= "                <label for='' class='hide'>카테고리1</label>";
    $laundryInfo .= "                <select class='fb__form-select' onchange='laundryChange(this.value)'>";
    foreach($laundryOneDepth as $oneValue){
        $selected = "";
        if($oneValue['cid'] == $_REQUEST['cid']){
            $selected = "selected";
        }

        if(BASIC_LANGUAGE == "korean"){
            $laundryInfo .= "           <option value='".$oneValue['cid']."' ".$selected.">".$oneValue['title']."</option>";
        } else {
            $laundryInfo .= "           <option value='".$oneValue['cid']."' ".$selected.">".$oneValue['title_en']."</option>";
        }
    }
    $laundryInfo .= "                </select>";
    $laundryInfo .= "            </div>";

    $laundryTwoDepth	= $productModel->getLaundryList(1, substr($_REQUEST['cid'],0,3));

    $laundryInfo .= "            <div class='fb__form-item'>";
    $laundryInfo .= "                <label for='' class='hide'>카테고리2</label>";
    $laundryInfo .= "                <select class='fb__form-select' onchange='laundryTwoChange(this.value)'>";

    foreach($laundryTwoDepth as $twoValue){
        if(BASIC_LANGUAGE == "korean"){
            $laundryInfo .= "           <option value='".$twoValue['cid']."'>".$twoValue['title']."</option>";
        } else {
            $laundryInfo .= "           <option value='".$twoValue['cid']."'>".$twoValue['title_en']."</option>";
        }
    }

    $laundryInfo .= "                </select>";
    $laundryInfo .= "                <input type='hidden' id='laundryTwoDepthOld' value='".$laundryTwoDepth[0]['cid']."'>";
    $laundryInfo .= "            </div>";
    $laundryInfo .= "        </div>";
    $laundryInfo .= "        <div class='fb-tab__wrap fb-tab__col'>";
	$laundryInfo .= "            <div class='fb-tab__nav'>";
	$laundryInfo .= "                <ul>";
	$laundryInfo .= "                    <li class='active' id='laundryOneTab'>";
	$laundryInfo .= "                        <a href='javascript:void(0);' onclick='laundryTab(1)'>세탁 방법</a>";
	$laundryInfo .= "                    </li>";
	$laundryInfo .= "                    <li id='laundryTwoTab'>";
	$laundryInfo .= "                        <a href='javascript:void(0);' onclick='laundryTab(2)'>보관 및 주의사항</a>";
	$laundryInfo .= "                    </li>";
	$laundryInfo .= "                </ul>";
	$laundryInfo .= "            </div>";

    $laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));

    $laundryInfo .= "            <div class='fb-tab__contents-wrap'>";
    $laundryInfo .= "                <div class='fb-tab__contents active' id='laundryOneContent'>";
    $laundryInfo .= "                    <div class='contents__box'>";

    $o = 0;
    foreach($laundryTwoDepth as $twoValue){
        if($o == 0) {
            $laundryInfo .= "<div class='contents__list' id='oneLaundry-".$twoValue['cid']."' style='display:block;'>";
        }else{
            $laundryInfo .= "<div class='contents__list' id='oneLaundry-".$twoValue['cid']."' style='display:none;'>";
        }

        $laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));

        $t = 0;
        foreach($laundryThreeDepth as $threeValue){
            if($t == 0){

                $laundryFourDepth	= $productModel->getLaundryList(3, substr($threeValue['cid'],0,9));

                foreach($laundryFourDepth as $fourValue){
					if($fourValue['title'] == "중성세제") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "수돗물 세탁") {
						$imgCnt			= "02";
					}else if($fourValue['title'] == "건조기 금지") {
						$imgCnt			= "03";
					}else if($fourValue['title'] == "미끄럼틀 금지") {
						$imgCnt			= "04";
					}else if($fourValue['title'] == "트렁크 금지") {
						$imgCnt			= "05";
					}else if($fourValue['title'] == "모래끼임") {
						$imgCnt			= "06";
					}else if($fourValue['title'] == "오일") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "흙탕물 주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "보관 시") {
						$imgCnt			= "09";
					}else if($fourValue['title'] == "네오프렌 세척") {
						$imgCnt			= "37";
					}else if($fourValue['title'] == "세제 금지") {
						$imgCnt			= "11";
					}else if($fourValue['title'] == "직사광선 주의") {
						$imgCnt			= "12";
					}else if($fourValue['title'] == "날카로움 주의") {
						$imgCnt			= "13";
					}else if($fourValue['title'] == "손바닥 사용") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "옷걸이 건조") {
						$imgCnt			= "38";
					}else if($fourValue['title'] == "네오프렌 보관 시") {
						$imgCnt			= "39";
					}else if($fourValue['title'] == "표백제 금지") {
						$imgCnt			= "17";
					}else if($fourValue['title'] == "세탁망") {
						$imgCnt			= "18";
					}else if($fourValue['title'] == "다리미 사용 금지") {
						$imgCnt			= "19";
					}else if($fourValue['title'] == "건조 시") {
						$imgCnt			= "20";
					}else if($fourValue['title'] == "단독 손세탁") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "생활 방수") {
						$imgCnt			= "22";
					}else if($fourValue['title'] == "미지근한 온도") {
						$imgCnt			= "23";
					}else if($fourValue['title'] == "비틀기 금지") {
						$imgCnt			= "24";
					}else if($fourValue['title'] == "드라이클리닝 및 건조기 금지") {
						$imgCnt			= "25";
					}else if($fourValue['title'] == "충격 주의") {
						$imgCnt			= "26";
					}else if($fourValue['title'] == "화기 주의") {
						$imgCnt			= "27";
					}else if($fourValue['title'] == "수중 사용 금지") {
						$imgCnt			= "28";
					}else if($fourValue['title'] == "수경 세척 시") {
						$imgCnt			= "29";
					}else if($fourValue['title'] == "별도 사용 금지") {
						$imgCnt			= "30";
					}else if($fourValue['title'] == "올 관리") {
						$imgCnt			= "31";
					}else if($fourValue['title'] == "접촉 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "유기 용액") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "유분 주의") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "안티포그액") {
						$imgCnt			= "30";
					}else if($fourValue['title'] == "렌즈 접촉 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "중성 세제") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "오염주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "오염 주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "단독세탁") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "탈수기 및 건조기 금지") {
						$imgCnt			= "03";
					}else if($fourValue['title'] == "착용 시") {
						$imgCnt			= "32";
					}else if($fourValue['title'] == "30kg이하 사용 주의") {
						$imgCnt			= "33";
					}else if($fourValue['title'] == "어린이와 함께 사용 시") {
						$imgCnt			= "34";
					}else if($fourValue['title'] == "인명 구조 주의") {
						$imgCnt			= "35";
					}else if($fourValue['title'] == "인명구조 사용금지") {
						$imgCnt			= "35";
					}else if($fourValue['title'] == "강한 물살 주의") {
						$imgCnt			= "36";
					}else if($fourValue['title'] == "세탁 시") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "화장품이 묻었을 때") {
						$imgCnt			= "40";
					}else if($fourValue['title'] == "브라패드") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "조류 주의") {
						$imgCnt			= "28";
					}else if($fourValue['title'] == "보관 주의") {
						$imgCnt			= "09";
					}else if($fourValue['title'] == "아이가 사용 시") {
						$imgCnt			= "34";
					}else if($fourValue['title'] == "세척 방법") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "변형 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "세탁 금지") {
						$imgCnt			= "25";
					}else{
						$imgCnt			= "0";
					}

                    $laundryInfo .= "    <dl class='contents__item'>";
                    $laundryInfo .= "        <dt class='contents__item-img'>";
                    $laundryInfo .= "            <img src='/assets/templet/enterprise/assets/img/img_product_precautions".$imgCnt.".png' alt=''".$fourValue['title']."' />";
                    $laundryInfo .= "        </dt>";
                    $laundryInfo .= "        <dd class='contents__item-cont'>";
                    $laundryInfo .= "            <div class='contents__subtitle'>".$fourValue['title']."</div>";
                    $laundryInfo .= "            <div class='contents__summary'>";
                    $laundryInfo .= "                <p>".$fourValue['contents']."</p>";
                    $laundryInfo .= "            </div>";
                    $laundryInfo .= "        </dd>";
                    $laundryInfo .= "    </dl>";
                }
            }
            $t++;
        }
            $laundryInfo .= "</div>";
        $o++;
    }
    $laundryInfo .= "                    </div>";
    $laundryInfo .= "                </div>";
    $laundryInfo .= "                <div class='fb-tab__contents' id='laundryTwoContent'>";
    $laundryInfo .= "                    <div class='contents__box'>";

    $o = 0;
    foreach($laundryTwoDepth as $twoValue){
        if($o == 0) {
            $laundryInfo .= "<div class='contents__list' id='oneLaundry-".$twoValue['cid']."' style='display:block;'>";
        }else{
            $laundryInfo .= "<div class='contents__list' id='oneLaundry-".$twoValue['cid']."' style='display:none;'>";
        }

        $laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));

        $t = 0;
        foreach($laundryThreeDepth as $threeValue){
            if($t == 1){

                $laundryFourDepth	= $productModel->getLaundryList(3, substr($threeValue['cid'],0,9));

                foreach($laundryFourDepth as $fourValue){
					if($fourValue['title'] == "중성세제") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "수돗물 세탁") {
						$imgCnt			= "02";
					}else if($fourValue['title'] == "건조기 금지") {
						$imgCnt			= "03";
					}else if($fourValue['title'] == "미끄럼틀 금지") {
						$imgCnt			= "04";
					}else if($fourValue['title'] == "트렁크 금지") {
						$imgCnt			= "05";
					}else if($fourValue['title'] == "모래끼임") {
						$imgCnt			= "06";
					}else if($fourValue['title'] == "오일") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "흙탕물 주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "보관 시") {
						$imgCnt			= "09";
					}else if($fourValue['title'] == "네오프렌 세척") {
						$imgCnt			= "37";
					}else if($fourValue['title'] == "세제 금지") {
						$imgCnt			= "11";
					}else if($fourValue['title'] == "직사광선 주의") {
						$imgCnt			= "12";
					}else if($fourValue['title'] == "날카로움 주의") {
						$imgCnt			= "13";
					}else if($fourValue['title'] == "손바닥 사용") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "옷걸이 건조") {
						$imgCnt			= "38";
					}else if($fourValue['title'] == "네오프렌 보관 시") {
						$imgCnt			= "39";
					}else if($fourValue['title'] == "표백제 금지") {
						$imgCnt			= "17";
					}else if($fourValue['title'] == "세탁망") {
						$imgCnt			= "18";
					}else if($fourValue['title'] == "다리미 사용 금지") {
						$imgCnt			= "19";
					}else if($fourValue['title'] == "건조 시") {
						$imgCnt			= "20";
					}else if($fourValue['title'] == "단독 손세탁") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "생활 방수") {
						$imgCnt			= "22";
					}else if($fourValue['title'] == "미지근한 온도") {
						$imgCnt			= "23";
					}else if($fourValue['title'] == "비틀기 금지") {
						$imgCnt			= "24";
					}else if($fourValue['title'] == "드라이클리닝 및 건조기 금지") {
						$imgCnt			= "25";
					}else if($fourValue['title'] == "충격 주의") {
						$imgCnt			= "26";
					}else if($fourValue['title'] == "화기 주의") {
						$imgCnt			= "27";
					}else if($fourValue['title'] == "수중 사용 금지") {
						$imgCnt			= "28";
					}else if($fourValue['title'] == "수경 세척 시") {
						$imgCnt			= "29";
					}else if($fourValue['title'] == "별도 사용 금지") {
						$imgCnt			= "30";
					}else if($fourValue['title'] == "올 관리") {
						$imgCnt			= "31";
					}else if($fourValue['title'] == "접촉 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "유기 용액") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "유분 주의") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "안티포그액") {
						$imgCnt			= "30";
					}else if($fourValue['title'] == "렌즈 접촉 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "중성 세제") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "오염주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "오염 주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "단독세탁") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "탈수기 및 건조기 금지") {
						$imgCnt			= "03";
					}else if($fourValue['title'] == "착용 시") {
						$imgCnt			= "32";
					}else if($fourValue['title'] == "30kg이하 사용 주의") {
						$imgCnt			= "33";
					}else if($fourValue['title'] == "어린이와 함께 사용 시") {
						$imgCnt			= "34";
					}else if($fourValue['title'] == "인명 구조 주의") {
						$imgCnt			= "35";
					}else if($fourValue['title'] == "인명구조 사용금지") {
						$imgCnt			= "35";
					}else if($fourValue['title'] == "강한 물살 주의") {
						$imgCnt			= "36";
					}else if($fourValue['title'] == "세탁 시") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "화장품이 묻었을 때") {
						$imgCnt			= "40";
					}else if($fourValue['title'] == "브라패드") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "조류 주의") {
						$imgCnt			= "28";
					}else if($fourValue['title'] == "보관 주의") {
						$imgCnt			= "09";
					}else if($fourValue['title'] == "아이가 사용 시") {
						$imgCnt			= "34";
					}else if($fourValue['title'] == "세척 방법") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "변형 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "세탁 금지") {
						$imgCnt			= "25";
					}else{
						$imgCnt			= "0";
					}

                    $laundryInfo .= "    <dl class='contents__item'>";
                    $laundryInfo .= "        <dt class='contents__item-img'>";
                    $laundryInfo .= "            <img src='/assets/templet/enterprise/assets/img/img_product_precautions".$imgCnt.".png' alt=''".$fourValue['title']."' />";
                    $laundryInfo .= "        </dt>";
                    $laundryInfo .= "        <dd class='contents__item-cont'>";
                    $laundryInfo .= "            <div class='contents__subtitle'>".$fourValue['title']."</div>";
                    $laundryInfo .= "            <div class='contents__summary'>";
                    $laundryInfo .= "                <p>".$fourValue['contents']."</p>";
                    $laundryInfo .= "            </div>";
                    $laundryInfo .= "        </dd>";
                    $laundryInfo .= "    </dl>";
                }
            }
            $t++;
        }
        $laundryInfo .= "</div>";
        $o++;
    }
    $laundryInfo .= "                    </div>";
    $laundryInfo .= "                </div>";
    $laundryInfo .= "            </div>";
    $laundryInfo .= "        </div>";
    $laundryInfo .= "    </div>";
    $laundryInfo .= "</div>";

    echo $laundryInfo;

}else if($_REQUEST['mode'] == "ajaxMoNew"){
    $productModel = $view->import('model.mall.product');

    $laundryOneDepth	= $productModel->getLaundryList(0, '');
    $laundryInfo .= "<div class='popup-content'>";
    $laundryInfo .= "    <div class='wash'>";
    $laundryInfo .= "        <div class='wash__select'>";
    $laundryInfo .= "            <div class='wash__select-item'>";
    $laundryInfo .= "                <div class='br__form-item'>";
    $laundryInfo .= "                    <label for='' class='hidden'>카테고리 선택</label>";
    $laundryInfo .= "                    <select class='fb__form-select' onchange='laundryChange(this.value)'>";
    foreach($laundryOneDepth as $oneValue){
        $selected = "";
        if($oneValue['cid'] == $_REQUEST['cid']){
            $selected = "selected";
        }

        if(BASIC_LANGUAGE == "korean"){
            $laundryInfo .= "               <option value='".$oneValue['cid']."' ".$selected.">".$oneValue['title']."</option>";
        } else {
            $laundryInfo .= "               <option value='".$oneValue['cid']."' ".$selected.">".$oneValue['title_en']."</option>";
        }
    }
    $laundryInfo .= "                    </select>";
    $laundryInfo .= "                </div>";
    $laundryInfo .= "            </div>";

    $laundryTwoDepth	= $productModel->getLaundryList(1, substr($_REQUEST['cid'],0,3));
    $laundryInfo .= "            <div class='wash__select'>";
    $laundryInfo .= "                <div class='fb__form-item'>";
    $laundryInfo .= "                    <label for='' class='hidden'>상세 아이템 선택</label>";
    $laundryInfo .= "                    <select class='fb__form-select' onchange='laundryTwoChange(this.value)'>";

    foreach($laundryTwoDepth as $twoValue){
        if(BASIC_LANGUAGE == "korean"){
            $laundryInfo .= "               <option value='".$twoValue['cid']."'>".$twoValue['title']."</option>";
        } else {
            $laundryInfo .= "               <option value='".$twoValue['cid']."'>".$twoValue['title_en']."</option>";
        }
    }

    $laundryInfo .= "                    </select>";
    $laundryInfo .= "                   <input type='hidden' id='laundryTwoDepthOld' value='".$laundryTwoDepth[0]['cid']."'>";
    $laundryInfo .= "                </div>";
    $laundryInfo .= "            </div>";
    $laundryInfo .= "        </div>";
    $laundryInfo .= "        <div class='wash__contents'>";
    $laundryInfo .= "            <section class='wash__contents__category wash__contents__category--show'>";
    $laundryInfo .= "                <div class='br-tab__wrap'>";
    $laundryInfo .= "                    <div class='br-tab__nav'>";
    $laundryInfo .= "                        <ul>";
    $laundryInfo .= "                            <li class='active' id='laundryOneTab'>";
    $laundryInfo .= "                                <a href='javascript:void(0);' onclick='laundryTab(1)'>세탁 방법</a>";
    $laundryInfo .= "                            </li>";
    $laundryInfo .= "                            <li id='laundryTwoTab'>";
    $laundryInfo .= "                                <a href='javascript:void(0);' onclick='laundryTab(2)'>보관 및 주의사항</a>";
    $laundryInfo .= "                            </li>";
    $laundryInfo .= "                        </ul>";
    $laundryInfo .= "                    </div>";

    $laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));

    $laundryInfo .= "                    <div class='br-tab__contents-wrap'>";
    $laundryInfo .= "                        <div class='br-tab__contents active' id='laundryOneContent'>";

    $o = 0;
    foreach($laundryTwoDepth as $twoValue){
        if($o == 0) {
            $laundryInfo .= "<div class='contents__list' id='oneLaundry-".$twoValue['cid']."' style='display:block;'>";
        }else{
            $laundryInfo .= "<div class='contents__list' id='oneLaundry-".$twoValue['cid']."' style='display:none;'>";
        }

        $laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));

        $t = 0;
        foreach($laundryThreeDepth as $threeValue){
            if($t == 0){

                $laundryFourDepth	= $productModel->getLaundryList(3, substr($threeValue['cid'],0,9));

                foreach($laundryFourDepth as $fourValue){
					if($fourValue['title'] == "중성세제") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "수돗물 세탁") {
						$imgCnt			= "02";
					}else if($fourValue['title'] == "건조기 금지") {
						$imgCnt			= "03";
					}else if($fourValue['title'] == "미끄럼틀 금지") {
						$imgCnt			= "04";
					}else if($fourValue['title'] == "트렁크 금지") {
						$imgCnt			= "05";
					}else if($fourValue['title'] == "모래끼임") {
						$imgCnt			= "06";
					}else if($fourValue['title'] == "오일") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "흙탕물 주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "보관 시") {
						$imgCnt			= "09";
					}else if($fourValue['title'] == "네오프렌 세척") {
						$imgCnt			= "37";
					}else if($fourValue['title'] == "세제 금지") {
						$imgCnt			= "11";
					}else if($fourValue['title'] == "직사광선 주의") {
						$imgCnt			= "12";
					}else if($fourValue['title'] == "날카로움 주의") {
						$imgCnt			= "13";
					}else if($fourValue['title'] == "손바닥 사용") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "옷걸이 건조") {
						$imgCnt			= "38";
					}else if($fourValue['title'] == "네오프렌 보관 시") {
						$imgCnt			= "39";
					}else if($fourValue['title'] == "표백제 금지") {
						$imgCnt			= "17";
					}else if($fourValue['title'] == "세탁망") {
						$imgCnt			= "18";
					}else if($fourValue['title'] == "다리미 사용 금지") {
						$imgCnt			= "19";
					}else if($fourValue['title'] == "건조 시") {
						$imgCnt			= "20";
					}else if($fourValue['title'] == "단독 손세탁") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "생활 방수") {
						$imgCnt			= "22";
					}else if($fourValue['title'] == "미지근한 온도") {
						$imgCnt			= "23";
					}else if($fourValue['title'] == "비틀기 금지") {
						$imgCnt			= "24";
					}else if($fourValue['title'] == "드라이클리닝 및 건조기 금지") {
						$imgCnt			= "25";
					}else if($fourValue['title'] == "충격 주의") {
						$imgCnt			= "26";
					}else if($fourValue['title'] == "화기 주의") {
						$imgCnt			= "27";
					}else if($fourValue['title'] == "수중 사용 금지") {
						$imgCnt			= "28";
					}else if($fourValue['title'] == "수경 세척 시") {
						$imgCnt			= "29";
					}else if($fourValue['title'] == "별도 사용 금지") {
						$imgCnt			= "30";
					}else if($fourValue['title'] == "올 관리") {
						$imgCnt			= "31";
					}else if($fourValue['title'] == "접촉 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "유기 용액") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "유분 주의") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "안티포그액") {
						$imgCnt			= "30";
					}else if($fourValue['title'] == "렌즈 접촉 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "중성 세제") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "오염주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "오염 주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "단독세탁") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "탈수기 및 건조기 금지") {
						$imgCnt			= "03";
					}else if($fourValue['title'] == "착용 시") {
						$imgCnt			= "32";
					}else if($fourValue['title'] == "30kg이하 사용 주의") {
						$imgCnt			= "33";
					}else if($fourValue['title'] == "어린이와 함께 사용 시") {
						$imgCnt			= "34";
					}else if($fourValue['title'] == "인명 구조 주의") {
						$imgCnt			= "35";
					}else if($fourValue['title'] == "인명구조 사용금지") {
						$imgCnt			= "35";
					}else if($fourValue['title'] == "강한 물살 주의") {
						$imgCnt			= "36";
					}else if($fourValue['title'] == "세탁 시") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "화장품이 묻었을 때") {
						$imgCnt			= "40";
					}else if($fourValue['title'] == "브라패드") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "조류 주의") {
						$imgCnt			= "28";
					}else if($fourValue['title'] == "보관 주의") {
						$imgCnt			= "09";
					}else if($fourValue['title'] == "아이가 사용 시") {
						$imgCnt			= "34";
					}else if($fourValue['title'] == "세척 방법") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "변형 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "세탁 금지") {
						$imgCnt			= "25";
					}else{
						$imgCnt			= "0";
					}

                    $laundryInfo .= "    <dl class='contents__item'>";
                    $laundryInfo .= "        <dt class='contents__item-img'>";
                    $laundryInfo .= "            <img src='/assets/templet/enterprise/assets/img/img_product_precautions".$imgCnt.".png' alt=''".$fourValue['title']."' />";
                    $laundryInfo .= "        </dt>";
                    $laundryInfo .= "        <dd class='contents__item-cont'>";
                    $laundryInfo .= "            <div class='contents__subtitle'>".$fourValue['title']."</div>";
                    $laundryInfo .= "            <div class='contents__summary'>";
                    $laundryInfo .= "                <p>".$fourValue['contents']."</p>";
                    $laundryInfo .= "            </div>";
                    $laundryInfo .= "        </dd>";
                    $laundryInfo .= "    </dl>";
                }
            }
            $t++;
        }
        $laundryInfo .= "</div>";
        $o++;
    }
    $laundryInfo .= "                    </div>";
    $laundryInfo .= "                </div>";
    $laundryInfo .= "                <div class='fb-tab__contents' id='laundryTwoContent'>";
    $laundryInfo .= "                    <div class='contents__box'>";

    $o = 0;
    foreach($laundryTwoDepth as $twoValue){
        if($o == 0) {
            $laundryInfo .= "<div class='contents__list' id='oneLaundry-".$twoValue['cid']."' style='display:block;'>";
        }else{
            $laundryInfo .= "<div class='contents__list' id='oneLaundry-".$twoValue['cid']."' style='display:none;'>";
        }

        $laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));

        $t = 0;
        foreach($laundryThreeDepth as $threeValue){
            if($t == 1){

                $laundryFourDepth	= $productModel->getLaundryList(3, substr($threeValue['cid'],0,9));

                foreach($laundryFourDepth as $fourValue){
					if($fourValue['title'] == "중성세제") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "수돗물 세탁") {
						$imgCnt			= "02";
					}else if($fourValue['title'] == "건조기 금지") {
						$imgCnt			= "03";
					}else if($fourValue['title'] == "미끄럼틀 금지") {
						$imgCnt			= "04";
					}else if($fourValue['title'] == "트렁크 금지") {
						$imgCnt			= "05";
					}else if($fourValue['title'] == "모래끼임") {
						$imgCnt			= "06";
					}else if($fourValue['title'] == "오일") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "흙탕물 주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "보관 시") {
						$imgCnt			= "09";
					}else if($fourValue['title'] == "네오프렌 세척") {
						$imgCnt			= "37";
					}else if($fourValue['title'] == "세제 금지") {
						$imgCnt			= "11";
					}else if($fourValue['title'] == "직사광선 주의") {
						$imgCnt			= "12";
					}else if($fourValue['title'] == "날카로움 주의") {
						$imgCnt			= "13";
					}else if($fourValue['title'] == "손바닥 사용") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "옷걸이 건조") {
						$imgCnt			= "38";
					}else if($fourValue['title'] == "네오프렌 보관 시") {
						$imgCnt			= "39";
					}else if($fourValue['title'] == "표백제 금지") {
						$imgCnt			= "17";
					}else if($fourValue['title'] == "세탁망") {
						$imgCnt			= "18";
					}else if($fourValue['title'] == "다리미 사용 금지") {
						$imgCnt			= "19";
					}else if($fourValue['title'] == "건조 시") {
						$imgCnt			= "20";
					}else if($fourValue['title'] == "단독 손세탁") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "생활 방수") {
						$imgCnt			= "22";
					}else if($fourValue['title'] == "미지근한 온도") {
						$imgCnt			= "23";
					}else if($fourValue['title'] == "비틀기 금지") {
						$imgCnt			= "24";
					}else if($fourValue['title'] == "드라이클리닝 및 건조기 금지") {
						$imgCnt			= "25";
					}else if($fourValue['title'] == "충격 주의") {
						$imgCnt			= "26";
					}else if($fourValue['title'] == "화기 주의") {
						$imgCnt			= "27";
					}else if($fourValue['title'] == "수중 사용 금지") {
						$imgCnt			= "28";
					}else if($fourValue['title'] == "수경 세척 시") {
						$imgCnt			= "29";
					}else if($fourValue['title'] == "별도 사용 금지") {
						$imgCnt			= "30";
					}else if($fourValue['title'] == "올 관리") {
						$imgCnt			= "31";
					}else if($fourValue['title'] == "접촉 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "유기 용액") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "유분 주의") {
						$imgCnt			= "07";
					}else if($fourValue['title'] == "안티포그액") {
						$imgCnt			= "30";
					}else if($fourValue['title'] == "렌즈 접촉 주의") {
						$imgCnt			= "14";
					}else if($fourValue['title'] == "중성 세제") {
						$imgCnt			= "01";
					}else if($fourValue['title'] == "오염주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "오염 주의") {
						$imgCnt			= "08";
					}else if($fourValue['title'] == "단독세탁") {
						$imgCnt			= "21";
					}else if($fourValue['title'] == "탈수기 및 건조기 금지") {
						$imgCnt			= "03";
					}else if($fourValue['title'] == "착용 시") {
						$imgCnt			= "32";
					}else if($fourValue['title'] == "30kg이하 사용 주의") {
						$imgCnt			= "33";
					}else if($fourValue['title'] == "어린이와 함께 사용 시") {
						$imgCnt			= "34";
					}else if($fourValue['title'] == "인명 구조 주의") {
						$imgCnt			= "35";
					}else if($fourValue['title'] == "인명구조 사용금지") {
						$imgCnt			= "35";
					}else if($fourValue['title'] == "강한 물살 주의") {
						$imgCnt			= "36";
					}else{
						$imgCnt			= "0";
					}

                    $laundryInfo .= "    <dl class='contents__item'>";
                    $laundryInfo .= "        <dt class='contents__item-img'>";
                    $laundryInfo .= "            <img src='/assets/templet/enterprise/assets/img/img_product_precautions".$imgCnt.".png' alt=''".$fourValue['title']."' />";
                    $laundryInfo .= "        </dt>";
                    $laundryInfo .= "        <dd class='contents__item-cont'>";
                    $laundryInfo .= "            <div class='contents__subtitle'>".$fourValue['title']."</div>";
                    $laundryInfo .= "            <div class='contents__summary'>";
                    $laundryInfo .= "                <p>".$fourValue['contents']."</p>";
                    $laundryInfo .= "            </div>";
                    $laundryInfo .= "        </dd>";
                    $laundryInfo .= "    </dl>";
                }
            }
            $t++;
        }
        $laundryInfo .= "</div>";
        $o++;
    }
    $laundryInfo .= "                    </div>";
    $laundryInfo .= "                </div>";
    $laundryInfo .= "            </div>";
    $laundryInfo .= "        </div>";
    $laundryInfo .= "    </div>";
    $laundryInfo .= "</div>";

    echo $laundryInfo;
}