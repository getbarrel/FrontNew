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
				$laundry[$o]['three'][$t]['four'][$f]['cid']			= $fourValue['cid'];
				$laundry[$o]['three'][$t]['four'][$f]['title']			= $fourValue['title'];
				$laundry[$o]['three'][$t]['four'][$f]['contents']		= $fourValue['contents'];
				$laundry[$o]['three'][$t]['four'][$f]['title_en']		= $fourValue['title_en'];
				$laundry[$o]['three'][$t]['four'][$f]['contents_en']	= $fourValue['contents_en'];

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

	if(BASIC_LANGUAGE == "korean"){
		$laundryInfo .= "<div class='wash_sub_txt'>".$laundryOneDepth[0]['category']."</div>";
	} else {
		$laundryInfo .= "<div class='wash_sub_txt'>Please select a category.</div>";
	}
	$laundryInfo .= "<nav class='wash__category'>";
	$laundryInfo .= "<span class='wash_select'>";
	$laundryInfo .= "<select name='laundryOneDepth' onchange='laundryChange(this.value)'>";

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
	$laundryInfo .= "</span>";
	$laundryInfo .= "<ul>";

	$laundryTwoDepth	= $productModel->getLaundryList(1, substr($_REQUEST['cid'],0,3));

	$o = 0;
	foreach($laundryTwoDepth as $twoValue){
		$laundryInfo .= "<li>";
		if($o == 0) {
			$laundryInfo .= "<a href='#' data-target='".$twoValue['cid']."' class='wash__category-link wash__category-link--active'>";
		} else {
			$laundryInfo .= "<a href='#' data-target='".$twoValue['cid']."' class='wash__category-link'>";
		}

		if(BASIC_LANGUAGE == "korean"){
			$laundryInfo .= $twoValue['title'];
		} else {
			$laundryInfo .= $twoValue['title_en'];
		}
		$laundryInfo .= "</a>";
		$laundryInfo .= "</li>";
		$o++;
	}
	$laundryInfo .= "</ul>";
	$laundryInfo .= "</nav>";
	$laundryInfo .= "<div class='wash__contents'>";

	$o = 0;
	foreach($laundryTwoDepth as $twoValue){
		if($o == 0) {
			$laundryInfo .= "<section class='wash__contents__category wash__contents__category--show wash__contents-".$twoValue['cid']."'>";
		} else {
			$laundryInfo .= "<section class='wash__contents__category wash__contents-".$twoValue['cid']."'>";
		}
		$laundryInfo .= "<div class='contents'>";
		$laundryInfo .= "<h3 class='contents__title'>";
		if(BASIC_LANGUAGE == "korean"){
			$laundryInfo .= $twoValue['title'];
		} else {
			$laundryInfo .= $twoValue['title_en'];
		}
		$laundryInfo .= "</h3>";
		$laundryInfo .= "</div>";
		$laundryInfo .= "<div class='contents__box'>";

		$laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));

		$t = 0;
		foreach($laundryThreeDepth as $threeValue){
			if($t == 0){
				$laundryInfo .= "<ul class='contents__box-wash contents__box-detail contents__box-detail--show'>";
			} else {
				$laundryInfo .= "<ul class='contents__box-precaution contents__box-detail'>";
			}
			$laundryInfo .= "<li>";
			if(BASIC_LANGUAGE == "korean"){
				$laundryInfo .= "<h3 class='contents__box__subtitle'>".$threeValue['title']."</h3>";
			} else {
				$laundryInfo .= "<h3 class='contents__box__subtitle'>".$threeValue['title_en']."</h3>";
			}
			$laundryInfo .= "</li>";
			$laundryInfo .= "</ul>";

			$laundryFourDepth	= $productModel->getLaundryList(3, substr($threeValue['cid'],0,9));

			$f = 0;
			foreach($laundryFourDepth as $fourValue){

				$laundryInfo .= "<li class='contents__list'>";
				$laundryInfo .= "<h4 class='contents__subtitle'>";
				if(BASIC_LANGUAGE == "korean"){
					$laundryInfo .= $fourValue['title'];
				} else {
					$laundryInfo .= $fourValue['title_en'];
				}
				$laundryInfo .= "</h4>";
				$laundryInfo .= "<div class='contents__summary'>";
				$laundryInfo .= "<ul>";
				if(BASIC_LANGUAGE == "korean"){
					$laundryInfo .= "<li>".$fourValue['contents']."</li>";
				} else {
					$laundryInfo .= "<li>".$fourValue['contents_en']."</li>";
				}
				$laundryInfo .= "</ul>";
				$laundryInfo .= "</div>";
				$laundryInfo .= "</li>";

				$f++;
			}
			$t++;
		}
		$laundryInfo .= "</div>";
		$laundryInfo .= "</section>";
		$o++;
	}
	$laundryInfo .= "</div>";

	echo $laundryInfo;
} else if($_REQUEST['mode'] == "ajaxMo"){
	$productModel = $view->import('model.mall.product');

	$laundryOneDepth	= $productModel->getLaundryList(0, '');

	$laundryInfo .= "<div class='wash_select'>";
	$laundryInfo .= "	<select name='laundryOneDepth' onchange='laundryChange(this.value)'>";
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
	$laundryInfo .= "	</select>";
	if(BASIC_LANGUAGE == "korean"){
		$laundryInfo .= "	<p class='wash_sub_txt'>".$laundryOneDepth[0]['category']."</p>";
	} else {
		$laundryInfo .= "	<p class='wash_sub_txt'>Please select a category.</p>";
	}
	$laundryInfo .= "</div>";

	$laundryTwoDepth	= $productModel->getLaundryList(1, substr($_REQUEST['cid'],0,3));

	$o = 0;

	$laundryInfo .= "<nav class='wash__category'>";
	foreach($laundryTwoDepth as $twoValue){
		if($o == 0) {
			$laundryInfo .= "		<a href='javascript:void(0);' data-target='".$twoValue['cid']."' class='wash__category-link wash__category-link--active'>";
		} else {
			$laundryInfo .= "		<a href='javascript:void(0);' data-target='".$twoValue['cid']."' class='wash__category-link'>";
		}
		if(BASIC_LANGUAGE == "korean"){
			$laundryInfo .= $twoValue['title'];
		} else {
			$laundryInfo .= $twoValue['title_en'];
		}
		$laundryInfo .= "		</a>";
		$o++;
	}
	$laundryInfo .= "</nav>";

	$laundryInfo .= "<div class='wash__contents'>";
	$o = 0;
	foreach($laundryTwoDepth as $twoValue){
		if($o == 0) {
			$laundryInfo .= "		<section class='wash__contents__category wash__contents__category--show wash__contents-".$twoValue['cid']."'>";
		} else {
			$laundryInfo .= "		<section class='wash__contents__category wash__contents-".$twoValue['cid']."'>";
		}
		$laundryInfo .= "			<div class='contents'>";
		$laundryInfo .= "				<h3 class='contents__title'>";
		if(BASIC_LANGUAGE == "korean"){
			$laundryInfo .= $twoValue['title'];
		} else {
			$laundryInfo .= $twoValue['title_en'];
		}
		$laundryInfo .= "				</h3>";
		$laundryInfo .= "				<nav class='contents__tab'>";
		
		$laundryThreeDepth	= $productModel->getLaundryList(2, substr($twoValue['cid'],0,6));

		$t = 0;
		foreach($laundryThreeDepth as $threeValue){
			if($t == 0){
				$laundryInfo .= "			<a href='javascript:void(0);' data-target='wash' class='contents__tab-link contents__tab-link--active'>";
			} else {
				$laundryInfo .= "			<a href='javascript:void(0);' data-target='precaution' class='contents__tab-link'>";
			}
			if(BASIC_LANGUAGE == "korean"){
				$laundryInfo .= "				<h3 class='contents__box__subtitle'>".$threeValue['title']."</h3>";
			} else {
				$laundryInfo .= "				<h3 class='contents__box__subtitle'>".$threeValue['title_en']."</h3>";
			}
			$laundryInfo .= "				</a>";
			$t++;
		}
		$laundryInfo .= "				</nav>";

		$laundryInfo .= "				<div class='contents__box'>";
		$t = 0;
		foreach($laundryThreeDepth as $threeValue){
			if($t == 0){
				$laundryInfo .= "			<ul class='contents__box-wash contents__box-detail contents__box-detail--show'>";
			} else {
				$laundryInfo .= "			<ul class='contents__box-precaution contents__box-detail'>";
			}

			$laundryFourDepth	= $productModel->getLaundryList(3, substr($threeValue['cid'],0,9));
			
			$f = 0;
			foreach($laundryFourDepth as $fourValue){
				$laundryInfo .= "				<li class='contents__list'>";
				$laundryInfo .= "					<h4 class='contents__subtitle'>";
				if(BASIC_LANGUAGE == "korean"){
					$laundryInfo .= $fourValue['title'];
				} else {
					$laundryInfo .= $fourValue['title_en'];
				}
				$laundryInfo .= "					</h4>";
				$laundryInfo .= "					<div class='contents__summary'>";
				$laundryInfo .= "						<ul>";
				$laundryInfo .= "							<li align='left'>";
				if(BASIC_LANGUAGE == "korean"){
					$laundryInfo .= $fourValue['contents'];
				} else {
					$laundryInfo .= $fourValue['contents_en'];
				}
				$laundryInfo .= "							</li>";
				$laundryInfo .= "						</ul>";
				$laundryInfo .= "					</div>";
				$laundryInfo .= "				</li>";
				$f++;
			}
			$laundryInfo .= "				</ul>";
			$t++;
		}
		$laundryInfo .= "				</div>";
		$laundryInfo .= "			</div>";
		$laundryInfo .= "		</section>";
		$o++;
	}
	$laundryInfo .= "</div>";

	echo $laundryInfo;
}