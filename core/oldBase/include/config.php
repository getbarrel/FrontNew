<?php
// 상품 DB 컬럼 정보 입니다.
$image_hosting_type       = "local"; // lib.function.php, legacy.helper.php 사용중

$shop_product_type  = array("0", "1", "2", "3", "7", "8", "9", "88", "99", "12", "77"); // option.lib.php, legacy.helper.php, global_util.php, lib.function.php 사용중
$sns_product_type   = array("4", "5", "6", "21", "31"); // global_util.php, lib.function.php 사용중


// lib.function.php 사용중
$_DISCOUNT_TYPE["DI"]  = "즉시할인";
$_DISCOUNT_TYPE["MC"]  = "복수할인";
$_DISCOUNT_TYPE["MG"]  = "회원그룹할인";
$_DISCOUNT_TYPE["C"]   = "카테고리할인";
$_DISCOUNT_TYPE["GP"]  = "기획할인";
$_DISCOUNT_TYPE["SP"]  = "특별할인";
$_DISCOUNT_TYPE["CP"]  = "쿠폰할인";
$_DISCOUNT_TYPE["SCP"] = "중복쿠폰할인";
$_DISCOUNT_TYPE["M"]   = "모바일할인";
$_DISCOUNT_TYPE["APP"] = "APP할인";
$_DISCOUNT_TYPE["E"]   = "에누리";
$_DISCOUNT_TYPE["DCP"] = "배송쿠폰";
$_DISCOUNT_TYPE["DE"]  = "배송에누리";

//입금예정->취소요청(프론트)
// global_util.php 사용중
$order_select_status_div["F"]["IR"]["CA"]["DPB"]  = array("type" => "N", "title" => "다른상품구매");
$order_select_status_div["F"]["IR"]["CA"]["NB"]   = array("type" => "N", "title" => "구매의사없음");
$order_select_status_div["F"]["IR"]["CA"]["PIE"]  = array("type" => "N", "title" => "상품정보틀림");
$order_select_status_div["F"]["IR"]["CA"]["ETCB"] = array("type" => "N", "title" => "기타(구매자책임)");

//입금예정->취소요청(관리자)
$order_select_status_div["A"]["IR"]["CA"]["DPB"]  = array("type" => "N", "title" => "다른상품구매");
$order_select_status_div["A"]["IR"]["CA"]["NB"]   = array("type" => "N", "title" => "구매의사없음/변심");
$order_select_status_div["A"]["IR"]["CA"]["DD"]   = array("type" => "N", "title" => "배송처리늦음/지연");
$order_select_status_div["A"]["IR"]["CA"]["PIE"]  = array("type" => "N", "title" => "상품정보틀림");
$order_select_status_div["A"]["IR"]["CA"]["PSL"]  = array("type" => "S", "title" => "상품재고부족");
$order_select_status_div["A"]["IR"]["CA"]["PSO"]  = array("type" => "S", "title" => "상품품절");
$order_select_status_div["A"]["IR"]["CA"]["ETCB"] = array("type" => "B", "title" => "기타(구매자책임)");
$order_select_status_div["A"]["IR"]["CA"]["ETCS"] = array("type" => "S", "title" => "기타(판매자책임)");
$order_select_status_div["A"]["IR"]["CA"]["SYS"]  = array("type" => "N", "title" => "시스템자동취소");

//입금완료->취소요청(프론트)
$order_select_status_div["F"]["IC"]["CA"]["DPB"]  = array("type" => "B", "title" => "다른상품구매"); //다른상품구매
$order_select_status_div["F"]["IC"]["CA"]["NB"]   = array("type" => "B", "title" => "구매의사없음/변심"); //구매의사없음/변심
$order_select_status_div["F"]["IC"]["CA"]["DD"]   = array("type" => "S", "title" => "배송처리늦음/지연"); //배송처리늦음/지연
$order_select_status_div["F"]["IC"]["CA"]["PIE"]  = array("type" => "S", "title" => "상품정보틀림"); //상품정보틀림
$order_select_status_div["F"]["IC"]["CA"]["ETCB"] = array("type" => "B", "title" => "기타(구매자책임)"); //기타(구매자책임)
$order_select_status_div["F"]["IC"]["CA"]["ETCS"] = array("type" => "S", "title" => "기타(판매자책임)"); //기타(판매자책임)
//입금완료->취소요청(관리자)
$order_select_status_div["A"]["IC"]["CA"]["DPB"]  = array("type" => "B", "title" => "다른상품구매");
$order_select_status_div["A"]["IC"]["CA"]["NB"]   = array("type" => "B", "title" => "구매의사없음/변심");
$order_select_status_div["A"]["IC"]["CA"]["DD"]   = array("type" => "S", "title" => "배송처리늦음/지연");
$order_select_status_div["A"]["IC"]["CA"]["PIE"]  = array("type" => "S", "title" => "상품정보틀림");
$order_select_status_div["A"]["IC"]["CA"]["PSL"]  = array("type" => "S", "title" => "상품재고부족");
$order_select_status_div["A"]["IC"]["CA"]["PSO"]  = array("type" => "S", "title" => "상품품절");
$order_select_status_div["A"]["IC"]["CA"]["ETCB"] = array("type" => "B", "title" => "기타(구매자책임)");
$order_select_status_div["A"]["IC"]["CA"]["ETCS"] = array("type" => "S", "title" => "기타(판매자책임)");
$order_select_status_div["A"]["IC"]["CA"]["SYS"]  = array("type" => "N", "title" => "시스템자동취소");

//발주확인->취소요청(프론트)
$order_select_status_div["F"]["DR"]["CA"]["DPB"]  = array("type" => "B", "title" => "다른상품구매");
$order_select_status_div["F"]["DR"]["CA"]["NB"]   = array("type" => "B", "title" => "구매의사없음/변심");
$order_select_status_div["F"]["DR"]["CA"]["DD"]   = array("type" => "S", "title" => "배송처리늦음/지연");
$order_select_status_div["F"]["DR"]["CA"]["PIE"]  = array("type" => "S", "title" => "상품정보틀림");
$order_select_status_div["F"]["DR"]["CA"]["ETCB"] = array("type" => "B", "title" => "기타(구매자책임)");
$order_select_status_div["F"]["DR"]["CA"]["ETCS"] = array("type" => "S", "title" => "기타(판매자책임)");

//발주확인->취소요청(관리자)
$order_select_status_div["A"]["DR"]["CA"]["DPB"]  = array("type" => "B", "title" => "다른상품구매");
$order_select_status_div["A"]["DR"]["CA"]["NB"]   = array("type" => "B", "title" => "구매의사없음/변심");
$order_select_status_div["A"]["DR"]["CA"]["DD"]   = array("type" => "S", "title" => "배송처리늦음/지연");
$order_select_status_div["A"]["DR"]["CA"]["PIE"]  = array("type" => "S", "title" => "상품정보틀림");
$order_select_status_div["A"]["DR"]["CA"]["PSL"]  = array("type" => "S", "title" => "상품재고부족");
$order_select_status_div["A"]["DR"]["CA"]["PSO"]  = array("type" => "S", "title" => "상품품절");
$order_select_status_div["A"]["DR"]["CA"]["ETCB"] = array("type" => "B", "title" => "기타(구매자책임)");
$order_select_status_div["A"]["DR"]["CA"]["ETCS"] = array("type" => "S", "title" => "기타(판매자책임)");

//취소요청->취소거부(관리자)
$order_select_status_div["A"]["CA"]["CD"]["MCC"] = array("type" => "N", "title" => "주문제작 취소불가");
$order_select_status_div["A"]["CA"]["CD"]["NCP"] = array("type" => "N", "title" => "취소불가상품(상품페이지참조)");
$order_select_status_div["A"]["CA"]["CD"]["DR"]  = array("type" => "N", "title" => "포장완료/배송대기");
$order_select_status_div["A"]["CA"]["CD"]["ETC"] = array("type" => "N", "title" => "기타");

//배송지연(관리자)
$order_select_status_div["A"]["DD"]["DD"]["STS"] = array("type" => "N", "title" => "단기재고부족");
$order_select_status_div["A"]["DD"]["DD"]["OG"]  = array("type" => "N", "title" => "주문폭주로인한 작업지연");
$order_select_status_div["A"]["DD"]["DD"]["OMI"] = array("type" => "N", "title" => "주문제작 중");
$order_select_status_div["A"]["DD"]["DD"]["BA"]  = array("type" => "N", "title" => "고객요청");
$order_select_status_div["A"]["DD"]["DD"]["ETC"] = array("type" => "N", "title" => "기타");

//배송지연->취소신청(프론트)
$order_select_status_div["F"]["DD"]["CA"]["DPB"]  = array("type" => "B", "title" => "다른상품구매");
$order_select_status_div["F"]["DD"]["CA"]["NB"]   = array("type" => "B", "title" => "구매의사없음/변심");
$order_select_status_div["F"]["DD"]["CA"]["DD"]   = array("type" => "S", "title" => "배송처리늦음/지연");
$order_select_status_div["F"]["DD"]["CA"]["PIE"]  = array("type" => "S", "title" => "상품정보틀림");
$order_select_status_div["F"]["DD"]["CA"]["ETCB"] = array("type" => "B", "title" => "기타(구매자책임)");
$order_select_status_div["F"]["DD"]["CA"]["ETCS"] = array("type" => "S", "title" => "기타(판매자책임)");

//배송지연->취소요청(관리자)
$order_select_status_div["A"]["DD"]["CA"]["DPB"]  = array("type" => "B", "title" => "다른상품구매");
$order_select_status_div["A"]["DD"]["CA"]["NB"]   = array("type" => "B", "title" => "구매의사없음/변심");
$order_select_status_div["A"]["DD"]["CA"]["DD"]   = array("type" => "S", "title" => "배송처리늦음/지연");
$order_select_status_div["A"]["DD"]["CA"]["PIE"]  = array("type" => "S", "title" => "상품정보틀림");
$order_select_status_div["A"]["DD"]["CA"]["PSL"]  = array("type" => "S", "title" => "상품재고부족");
$order_select_status_div["A"]["DD"]["CA"]["PSO"]  = array("type" => "S", "title" => "상품품절");
$order_select_status_div["A"]["DD"]["CA"]["ETCB"] = array("type" => "B", "title" => "기타(구매자책임)");
$order_select_status_div["A"]["DD"]["CA"]["ETCS"] = array("type" => "S", "title" => "기타(판매자책임)");

//배송완료->교환요청(프론트)
$order_select_status_div["F"]["DC"]["EA"]["OCF"]  = array("type" => "B", "title" => "사이즈,색상잘못선택");
$order_select_status_div["F"]["DC"]["EA"]["PD"]   = array("type" => "S", "title" => "배송상품 파손/하자");
$order_select_status_div["F"]["DC"]["EA"]["DE"]   = array("type" => "S", "title" => "배송상품 오배송");
$order_select_status_div["F"]["DC"]["EA"]["PNT"]  = array("type" => "S", "title" => "상품미도착");
$order_select_status_div["F"]["DC"]["EA"]["PIE"]  = array("type" => "S", "title" => "상품정보 틀림");
$order_select_status_div["F"]["DC"]["EA"]["ETCB"] = array("type" => "B", "title" => "기타(구매자책임)");
$order_select_status_div["F"]["DC"]["EA"]["ETCS"] = array("type" => "S", "title" => "기타(판매자책임)");

//배송완료->교환요청(관리자)
$order_select_status_div["A"]["DC"]["EA"]["OCF"]  = array("type" => "B", "title" => "사이즈,색상잘못선택");
$order_select_status_div["A"]["DC"]["EA"]["PD"]   = array("type" => "S", "title" => "배송상품 파손/하자");
$order_select_status_div["A"]["DC"]["EA"]["DE"]   = array("type" => "S", "title" => "배송상품 오배송");
$order_select_status_div["A"]["DC"]["EA"]["PNT"]  = array("type" => "S", "title" => "상품미도착");
$order_select_status_div["A"]["DC"]["EA"]["PIE"]  = array("type" => "S", "title" => "상품정보 틀림");
$order_select_status_div["A"]["DC"]["EA"]["ETCB"] = array("type" => "B", "title" => "기타(구매자책임)");
$order_select_status_div["A"]["DC"]["EA"]["ETCS"] = array("type" => "S", "title" => "기타(판매자책임)");

//교환거부(관리자)
$order_select_status_div["A"]["EY"]["EY"]["MPNE"] = array("type" => "N", "title" => "주문제작상품으로 교환불가");
$order_select_status_div["A"]["EY"]["EY"]["NEP"]  = array("type" => "N", "title" => "교환불가상품(상세페이지참조)");
$order_select_status_div["A"]["EY"]["EY"]["ETC"]  = array("type" => "N", "title" => "기타");

//교환보류(관리자)
$order_select_status_div["A"]["EF"]["EF"]["NRA"]  = array("type" => "N", "title" => "반품상품 미입고");
$order_select_status_div["A"]["EF"]["EF"]["NRDP"] = array("type" => "N", "title" => "반품배송비 미동봉");
$order_select_status_div["A"]["EF"]["EF"]["RPD"]  = array("type" => "N", "title" => "반품상품 훼손/파손");
$order_select_status_div["A"]["EF"]["EF"]["RPPD"] = array("type" => "N", "title" => "반품상품포장 훼손/파손");
$order_select_status_div["A"]["EF"]["EF"]["ETC"]  = array("type" => "N", "title" => "기타");

//교환불가(관리자)
$order_select_status_div["A"]["EM"]["EM"]["RPD"]  = array("type" => "N", "title" => "반품상품 훼손/파손");
$order_select_status_div["A"]["EM"]["EM"]["RPPD"] = array("type" => "N", "title" => "반품상품포장 훼손/파손");
$order_select_status_div["A"]["EM"]["EM"]["BNC"]  = array("type" => "N", "title" => "구매자 연락되지 않음");


//배송완료->반품요청(프론트)
$order_select_status_div["F"]["DC"]["RA"]["OCF"]  = array("type" => "B", "title" => "사이즈,색상잘못선택");
$order_select_status_div["F"]["DC"]["RA"]["PD"]   = array("type" => "S", "title" => "배송상품 파손/하자");
$order_select_status_div["F"]["DC"]["RA"]["DE"]   = array("type" => "S", "title" => "배송상품 오배송");
$order_select_status_div["F"]["DC"]["RA"]["PNT"]  = array("type" => "S", "title" => "상품미도착");
$order_select_status_div["F"]["DC"]["RA"]["PIE"]  = array("type" => "S", "title" => "상품정보 틀림");
$order_select_status_div["F"]["DC"]["RA"]["ETCB"] = array("type" => "B", "title" => "기타(구매자책임)");
$order_select_status_div["F"]["DC"]["RA"]["ETCS"] = array("type" => "S", "title" => "기타(판매자책임)");

//배송완료->반품요청(관리자)
$order_select_status_div["A"]["DC"]["RA"]["OCF"]  = array("type" => "B", "title" => "사이즈,색상잘못선택");
$order_select_status_div["A"]["DC"]["RA"]["PD"]   = array("type" => "S", "title" => "배송상품 파손/하자");
$order_select_status_div["A"]["DC"]["RA"]["DE"]   = array("type" => "S", "title" => "배송상품 오배송");
$order_select_status_div["A"]["DC"]["RA"]["PNT"]  = array("type" => "S", "title" => "상품미도착");
$order_select_status_div["A"]["DC"]["RA"]["PIE"]  = array("type" => "S", "title" => "상품정보 틀림");
$order_select_status_div["A"]["DC"]["RA"]["ETCB"] = array("type" => "B", "title" => "기타(구매자책임)");
$order_select_status_div["A"]["DC"]["RA"]["ETCS"] = array("type" => "S", "title" => "기타(판매자책임)");

//반품거부(관리자)
$order_select_status_div["A"]["RY"]["RY"]["MPNE"] = array("type" => "N", "title" => "주문제작상품으로 교환불가");
$order_select_status_div["A"]["RY"]["RY"]["NEP"]  = array("type" => "N", "title" => "교환불가상품(상세페이지참조)");
$order_select_status_div["A"]["RY"]["RY"]["ETC"]  = array("type" => "N", "title" => "기타");

//반품보류(관리자)
$order_select_status_div["A"]["RF"]["RF"]["NRA"]  = array("type" => "N", "title" => "반품상품 미입고");
$order_select_status_div["A"]["RF"]["RF"]["NRDP"] = array("type" => "N", "title" => "반품배송비 미동봉");
$order_select_status_div["A"]["RF"]["RF"]["RPD"]  = array("type" => "N", "title" => "반품상품 훼손/파손");
$order_select_status_div["A"]["RF"]["RF"]["RPPD"] = array("type" => "N", "title" => "반품상품포장 훼손/파손");
$order_select_status_div["A"]["RF"]["RF"]["ETC"]  = array("type" => "N", "title" => "기타");

//반품불가(관리자)
$order_select_status_div["A"]["RM"]["RM"]["RPD"]  = array("type" => "N", "title" => "반품상품 훼손/파손");
$order_select_status_div["A"]["RM"]["RM"]["RPPD"] = array("type" => "N", "title" => "반품상품포장 훼손/파손");
$order_select_status_div["A"]["RM"]["RM"]["BNC"]  = array("type" => "N", "title" => "구매자 연락되지 않음");

// bootFunction.php, legacy.bootLangSet.helper.php,
$FRONT_LANGUAGE["korea"]     = array("code" => "korean", "name" => "한국어");
$FRONT_LANGUAGE["english"]   = array("code" => "english", "name" => "영어");
$FRONT_LANGUAGE["chinese"]   = array("code" => "chinese", "name" => "중국어");
$FRONT_LANGUAGE["japan"]     = array("code" => "japan", "name" => "일본어");
$FRONT_LANGUAGE["taiwanese"] = array("code" => "taiwanese", "name" => "대만어");
$FRONT_LANGUAGE["russian"]   = array("code" => "russian", "name" => "러시아어");
