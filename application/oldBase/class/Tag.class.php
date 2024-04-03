<?php

class Tag {

    var $user_info;
    var $m_errorName;
    var $file;
    var $userID;  // 사용자 아이디
    var $siteID;  // 업체아이디 
    var $data_root;  // data root
    var $email;  // email
    var $shoppingStep; // 구매스텝
    var $products;  //상품 리스트	
    var $index;
    var $return_value;
    var $product;
    var $memberRegStep;
    var $gender;  // 사용자 성별	
    var $mobile;  // 핸드폰
    var $birthYear; // 생년 //4자리
//	var $zip;		// 지역
    var $logStoryUrl;
    var $data0;  // 확장필드0
    var $data1;
    var $data2;
    var $data3;
    var $data4;
    var $data5;
    var $data6;
    var $data7;
    var $data8;
    var $data9;  // 확장필드9

    function __construct() {
        $this->user_info = "";
        $this->m_errorName = "";
        $this->file = "";
        $this->userID = "-";
        $this->siteID = "";
        $this->data_root = "";
        $this->email = "-";
        $this->index = 0;
        $this->shoppingStep = SHOPPING_NONE;
        $this->memberRegStep = "";
        $this->gender = "2";  // 사용자 성별	
        $this->mobile = "-";  // 핸드폰
        $this->birthYear = "-"; // 생년 //4자리
        $this->zip = "-";  // 지역
        $this->logStoryUrl = ""; //로그 데이터 수집 URL
        $this->data0 = "-";  // 확장필드0
        $this->data1 = "-";
        $this->data2 = "-";
        $this->data3 = "-";
        $this->data4 = "-";
        $this->data5 = "-";
        $this->data6 = "-";
        $this->data7 = "-";
        $this->data8 = "-";
        $this->data9 = "-";
    }

    function CheckDefult($vSpace, $defValue) {
        if ($vSpace == "") {
            return $defValue;
        } else {
            return $vSpace;
        }
    }

    function ToTagString() {


        $this->userID = $this->CheckDefult($this->userID, "-");
        $this->email = $this->CheckDefult($this->email, "-");
        $this->gender = $this->CheckDefult($this->gender, 2);  // 사용자 성별	
        $this->mobile = $this->CheckDefult($this->mobile, "-");  // 핸드폰
        $this->birthYear = $this->CheckDefult($this->birthYear, "-"); // 생년 //4자리
        $this->zip = $this->CheckDefult($this->zip, "-"); // 지역
        $this->logStoryUrl = $this->CheckDefult($this->logStoryUrl, "-"); // 지역
        $this->data0 = $this->CheckDefult($this->data0, "-");  // 확장필드0
        $this->data1 = $this->CheckDefult($this->data1, "-");
        $this->data2 = $this->CheckDefult($this->data2, "-");
        $this->data3 = $this->CheckDefult($this->data3, "-");
        $this->data4 = $this->CheckDefult($this->data4, "-");
        $this->data5 = $this->CheckDefult($this->data5, "-");
        $this->data6 = $this->CheckDefult($this->data6, "-");
        $this->data7 = $this->CheckDefult($this->data7, "-");
        $this->data8 = $this->CheckDefult($this->data8, "-");
        $this->data9 = $this->CheckDefult($this->data9, "-");

        $this->user_info = $this->userID . "|" . $this->email . "|" . $this->mobile . "|" . $this->gender . "|" . $this->birthYear . "|" . $this->zip . "|" . $this->data0 . "|" . $this->data1 . "|" . $this->data2 . "|" . $this->data3 . "|" . $this->data4 . "|" . $this->data5 . "|" . $this->data6 . "|" . $this->data7 . "|" . $this->data8 . "|" . $this->data9;
        //	$this->user_info = $this->userID ."|". $this->email ;    // 바뀌기전 데이터
        $this->logStoryUrl = ForbizConfig::getMallConfig('logstory_url');

        if ((is_Numeric($this->gender) == false) || (int) ($this->gender) > 2) {
            $this->m_errorName = "사용자 성별은 0(여자) 1(남자) 2(모름) 으로 입력해야 합니다. gender= " . $this->gender;
            $this->ErrorName();
            return false;
        }

        if ($this->birthYear != "-") {
            if (strLen($this->birthYear) != "4" || is_numeric($this->birthYear) == false) {
                $this->m_errorName = " 사용자 생년은 숫자4자리이어야 합니다. 1975(o), 75(x), 75년생(x) birthYear= " . $this->birthYear;
                $this->ErrorName();
                return false;
            }
        }

        if (strstr($this->zip, "-") == false) {
            $this->m_errorName = "우편번호는 xxx-xxx 형태로 작성을 해야 합니다. zip=" . $this->zip;
            $this->ErrorName();
            return false;
        }

        if ($this->file == "") {
            $this->m_errorName = "스크립트의 이름이 지정되지 않았습니다.";
            $this->ErrorName();
            return false;
        }

        if (($this->shoppingStep < SHOPPING_NONE) || ($this->shoppingStep > SHOPPING_DONE)) {
            $this->m_errorName = "구매스텝의 값이 비정상적입니다. shoppingStep=" . $this->shoppingStep;
            $this->ErrorName();
            return false;
        }

        if (!empty($this->product) && count($this->product) > 0) {
            if (($this->shoppingStep <= SHOPPING_NONE) || ($this->shoppingStep > SHOPPING_DONE)) {
                $this->m_errorName = "상품항목수 : " . count($this->product) . ", 구매스텝의 값이 정의되지 않았습니다. shoppingStep=" . $this->shoppingStep;
                $this->ErrorName();
                return false;
            }
        }



        if ($this->shoppingStep == SHOPPING_NONE) {
            // 상품조회, 구매스텝을 제외한 일반 페이지들이다.
            if ($this->memberRegStep != "") {
                return $this->TagWrite($this->user_info . "|" . $this->memberRegStep);
            } else {
                //$this->TagWrite($this->user_info."|-");
                return $this->TagWrite($this->user_info);     // 바뀌기전 ...
            }
        } else {
            if ($this->memberRegStep != "") {

                return $this->TagWrite($this->user_info . "|" . $this->memberRegStep);
            }
        }


        if (count($this->product) == 0) {
            $this->m_errorName = "상품에 대한 정보가 없습니다.";
            $this->ErrorName();
            return false;
        }

        $return_value = $this->user_info . "|" . $this->shoppingStep;

        for ($i = 0; $i <= count($this->product) - 1; $i++) {

            if ($this->product[$i] < 0) {
                $this->m_errorName = "가격과 수량의 값이 비정상적입니다. price=" . $this->product[$i]["price"] . ", quantity=" . $this->product[$i]["quantity"];
                $this->ErrorName();
                return "";
                break;
            }
            $return_value .= $this->product[$i];
        }


        if ($this->m_errorName == "") {
            return $this->TagWrite($return_value);
        }

        return false;
    }

    function CreateProduct($name, $path, $price, $quantity) {
        if ($quantity < 1) {
            $this->m_errorName = "수량이 0보다 작습니다.";
            $this->ErrorName();
            return false;
        }
        if ($price < -1) {
            $this->m_errorName = "가격이 \"-\" 입니다.";
            $this->ErrorName();
            return false;
        }


        $this->product[$this->index] = "|" . strip_tags($path) . ">" . strip_tags(ltrim(rtrim($name))) . "|" . $price . "|" . $quantity;
        $this->index = $this->index + 1;
    }

    function TagWrite($strVal) {
        $return_string = "<script language=\"javascript\" src=\"" . $this->file . "\"></script>\n";
        $return_string .= "<script language=\"javascript\">\n";
        if(defined('SEJONG_WALLAVU') || defined('BARREL_SHOPPING')) {
            $return_string .= "	SetSalesAnalysisTag(\"" . $strVal . "\",'" . $this->siteID . "','" . $this->data_root . "','".$this->logStoryUrl."');\n";
        } else {
            $return_string .= "<!--\n";
            $return_string .= "	SetSalesAnalysisTag(\"" . $strVal . "\",'" . $this->siteID . "','" . $this->data_root . "');\n";
            $return_string .= "// -->\n";
        }

        $return_string .= "</script>\n";

        return ($return_string);
        //echo ($return_string);
    }

    function ErrorName() {
        echo("<!-forBiz SalesAnalysis Tag Error Message :" . $this->m_errorName . "-->");
    }

}
