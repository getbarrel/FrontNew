<?php

/**
 * Description of PgForbizKcp
 * @author Hong
 */
class PgForbizKcp extends PgForbiz
{
    /**
     * ※ 주의 ※ BIN 절대 경로 입력 (bin전까지 설정)
     * @var
     */
    private $g_conf_home_dir;

    /**
     * Window 일때만 사용
     * pub.key 파일의 절대 경로 설정(파일명을 포함한 경로로 설정)
     * @var
     */
    private $g_conf_key_dir;

    /**
     * g_conf_log_dir 변수 설정
     * @var
     */
    private $g_conf_log_dir;

    /**
     * log 경로 지정
     * @var type
     */
    private $g_conf_log_path;

    /**
     * g_conf_gw_url
     * @var type
     */
    private $g_conf_gw_url;

    /**
     * g_conf_js_url
     * @var
     */
    private $g_conf_js_url;

    /**
     * 스마트폰 SOAP 통신 설정
     * @var
     */
    private $g_wsdl;

    /**
     * 사이트코드(site_cd)
     * @var
     */
    private $g_conf_site_cd;

    /**
     * 사이트키(site_key)
     * @var
     */
    private $g_conf_site_key;

    /**
     * g_conf_site_name 설정
     * @var
     */
    private $g_conf_site_name;

    /**
     * 복합과세 사용 여부
     * @var string
     */
    private $tax_use_yn;

    /**
     * 지불 데이터 셋업 (변경 불가)
     * @var
     */
    private $g_conf_log_level = "3";
    private $g_conf_gw_port = "8090";
    private $module_type = "01";

    /**
     * kcp 라이브러리 클레스
     * @var bool
     */
    private $c_PayPlus = false;

    /**
     * PC 결제 방식 맵핑 정보
     * @var array
     */
    private $methodMapping = [
        ORDER_METHOD_CARD => "100000000000"
        , ORDER_METHOD_ICHE => "010000000000"
        , ORDER_METHOD_VBANK => "001000000000"
        , ORDER_METHOD_PHONE => "000010000000"
        , ORDER_METHOD_KAKAOPAY => "100000000000"
		, ORDER_METHOD_ASCROW => "001000000000"
    ];

    /**
     * 모바일 결제 방식 맵핑 정보
     * @var array
     */
    private $methodMobileMapping = [
        ORDER_METHOD_CARD => "CARD"
        , ORDER_METHOD_ICHE => "BANK"
        , ORDER_METHOD_VBANK => "VCNT"
        , ORDER_METHOD_PHONE => "MOBX"
        , ORDER_METHOD_KAKAOPAY => "CARD"
		, ORDER_METHOD_ASCROW => "VCNT"
    ];

    /**
     * 모바일 ActionResult 맵핑 정보
     * @var array
     */
    private $methodActionResultMapping = [
        ORDER_METHOD_CARD => "card"
        , ORDER_METHOD_ICHE => "acnt"
        , ORDER_METHOD_VBANK => "vcnt"
        , ORDER_METHOD_PHONE => "mobx"
        , ORDER_METHOD_KAKAOPAY => "card"
		, ORDER_METHOD_ASCROW => "vcnt"
    ];

    /**
     * 모바일 van_code 맵핑 정보
     * @var array
     */
    private $methodVanCodeMapping = [
        ORDER_METHOD_CARD => ""
        , ORDER_METHOD_ICHE => ""
        , ORDER_METHOD_VBANK => ""
        , ORDER_METHOD_PHONE => ""
		, ORDER_METHOD_ASCROW => ""
    ];

    public function __construct($agentType)
    {
        parent::__construct($agentType);

        $this->g_conf_home_dir = __DIR__ . '/kcp/';
        $this->g_conf_key_dir = __DIR__ . '/kcp/bin/pub.key';
        $this->g_conf_site_name = ForbizConfig::getPaymentConfig('site_name', 'kcp');
        $this->tax_use_yn = ForbizConfig::getPaymentConfig('tax_use_yn', 'kcp');

        if (ForbizConfig::getPaymentConfig('service_type', 'kcp') == 'service') {
			//서버환경 = 리얼 || 사이트코드 및 사이트키 = 리얼
            $this->g_conf_gw_url = 'paygw.kcp.co.kr';
            $this->g_conf_js_url = 'https://pay.kcp.co.kr/plugin/payplus_web.jsp';
            $this->g_wsdl = $this->g_conf_home_dir . 'real_KCPPaymentService.wsdl';
            $this->g_conf_site_cd = ForbizConfig::getPaymentConfig('site_cd', 'kcp');
            $this->g_conf_site_key = ForbizConfig::getPaymentConfig('site_key', 'kcp');
        } else {
			//서버환경 = 테스트 || 사이트코드 및 사이트키 = 테스트
			
			$this->g_conf_gw_url = 'testpaygw.kcp.co.kr';
            $this->g_conf_js_url = 'https://testpay.kcp.co.kr/plugin/payplus_web.jsp';
            $this->g_wsdl = $this->g_conf_home_dir . 'KCPPaymentService.wsdl';
            $this->g_conf_site_cd = 'AO312';
            $this->g_conf_site_key = '3GnZTdJ8qgYfakX0NmvRubl__';
			
			//서버환경 = 리얼 || 사이트코드 및 사이트키 = 테스트
            /*
			$this->g_conf_gw_url = 'paygw.kcp.co.kr';
            $this->g_conf_js_url = 'https://pay.kcp.co.kr/plugin/payplus_web.jsp';
            $this->g_wsdl = $this->g_conf_home_dir . 'real_KCPPaymentService.wsdl';
            $this->g_conf_site_cd = 'A9B8X';
            $this->g_conf_site_key = '1LaYJ7K9NVoESiang45jUtd__';
			*/
        }
    }

    private function kakaopayChangeGconf()
    {
        //카카오 페이는 운영만 가능
        $this->g_conf_site_cd = 'A8P9X';
        $this->g_conf_site_key = '2cerp6Ai.tnCvn2I8LRsh04__';
    }

    public function getPaymentIncludeJavaScript(): string
    {
        if ($this->agentType == 'W') {
//        callback 함수 m_Completepayment 안내
//        ① 해당 함수는 결제 창 인증 완료 후 승인요청 처리를 위한 함수 (비동기식으로의 변경에 따른 함수 추가)
//        ② 해당 함수 명은 변경 불가
//        ③ 해당 함수의 위치는 결제 창 호출 js_url 보다 반드시 먼저 선언
//        ④ Plugin 방식의 경우 리턴 값이 json 으로 넘어옴 (표준웹의 경우 form으로 넘어옴)
            return implode('', [
                '<script>'
                , 'function m_Completepayment( FormOrJson, closeEvent ) {'
                , 'var frm = document.paymentGatewayForm;' // submit 시킬 폼데이터 지정
                , 'GetField( frm, FormOrJson );'
                , 'if( frm.res_cd.value == "0000" ) {'
                , ' frm.action = "/payment/kcp/result";'
                , ' frm.submit();'
                , '} else {'
                , ' alert( "[" + frm.res_cd.value + "] " + frm.res_msg.value );'
                , ' closeEvent();'
                , '}'
                , '}'
                , '</script>'
                , "<script type='text/javascript' src='" . $this->g_conf_js_url . "'></script>"
            ]);
        } else {
            return implode('', [
                '<script>'
                , 'function call_pay_form() {'
                , 'var v_frm = document.paymentGatewayForm;' // submit 시킬 폼데이터 지정
                , 'if (v_frm.approvalKeyResCD.value != "0000") {'
                , 'alert(v_frm.approvalKeyresMsg.value);'
                , 'return false;'
                , '}'
                , 'var PayUrl = v_frm.PayUrl.value;'
                , 'v_frm.action = PayUrl.substring(0, PayUrl.lastIndexOf("/")) + "/jsp/encodingFilter/encodingFilter.jsp";'
                , ' if (v_frm.Ret_URL.value == "") {'
                , ' alert("연동시 Ret_URL을 반드시 설정하셔야 됩니다.");'
                , ' return false;'
                , '} else {'
                , ' v_frm.submit();'
                , '}'
                , '}'
                , '</script>'
            ]);
        }
    }

    public function getPaymentRequestJavaScript(): string
    {
        if ($this->agentType == 'W') {
            return implode('', [
                'try {'
                , 'KCP_Pay_Execute(document.paymentGatewayForm);'
                , '} catch (e) {'
                , '}'
            ]);
        } else {
            return 'call_pay_form()';
        }
    }

    public function getPaymentRequestData(PgForbizPaymentData $paymentData): array
    {
        $data = [];
        $paymentData->amt = f_decimal($paymentData->amt)->toInt();

		$turn = 1;
		foreach($paymentData->goodsList as $key => $val){
			if($turn == count($paymentData->goodsList)){
				$data['good_info'] = $data['good_info']."seq=".$turn.chr(31)."ordr_numb=".$val['pid'].chr(31)."good_name=".$val['pname'].chr(31)."good_cntx=".$val['pcnt'].chr(31)."good_amtx=".round($val['pt_dcprice'],0);
			} else {
				if($turn == 1){
					$data['good_info'] = "seq=".$turn.chr(31)."ordr_numb=".$val['pid'].chr(31)."good_name=".$val['pname'].chr(31)."good_cntx=".$val['pcnt'].chr(31)."good_amtx=".round($val['pt_dcprice'],0).chr(30);
				} else {
					$data['good_info'] = $data['good_info']."seq=".$turn.chr(31)."ordr_numb=".$val['pid'].chr(31)."good_name=".$val['pname'].chr(31)."good_cntx=".$val['pcnt'].chr(31)."good_amtx=".round($val['pt_dcprice'],0).chr(30);
				}
			}
			$turn++;
		}
        //카카오 페이 설정
        if ($paymentData->method == ORDER_METHOD_KAKAOPAY) {
            $this->kakaopayChangeGconf();
            $data['kakaopay_direct'] = "Y";
        }

        if ($this->agentType == 'W') {
            //가맹점 필수 정보 설정
            $data['req_tx'] = 'pay';// 요청종류 : 승인(pay)/취소,매입(mod) 요청시 사용
            $data['site_name'] = $this->g_conf_site_name; //상점이름(영문으로 작성권장)
            $data['site_cd'] = $this->g_conf_site_cd; //상점코드
            $data['currency'] = 'WON'; //화폐단위 원화 : WON / 달러 : USD
			
			if($paymentData->method == 9){
				$data['escw_used'] = 'Y'; //에스크로 사용 여부 : 반드시 Y 로 설정
				$data['pay_mod'] = 'Y'; //에스크로 결제처리 모드 : 에스크로: Y, 일반: N, KCP 설정 조건: O
				$data['deli_term'] = '07'; //예상되는 배송 소요 일을 입력 반드시 형식을 2자리(일자)의 숫자로 입력
				$data['bask_cntx'] = $paymentData->goodsCount; //장바구니에 담겨있는 상품의 개수 장바구니의 상품 개수는 반드시 40개 이하
			}


            //주문 정보 입력
            $data['ordr_idxx'] = $paymentData->oid; //상점 관리 주문번호
            $data['pay_method'] = $this->getPayMethod($paymentData->method); //결제수단코드 신용카드, 계좌이체, 가상계좌를 하나의 결제 창에 같이 나타나게 하는 경우의 pay_method 는 ‘111000000000’ 로 설정
			$data['methodNum'] = $paymentData->method; 
            $data['good_name'] = $paymentData->goodsName; //상품명
            $data['good_mny'] = $paymentData->amt; //주문요청금액
            $data['buyr_name'] = $paymentData->buyerName; //주문자 이름
            $data['buyr_mail'] = $paymentData->buyerEmail; //주문자 이메일
            $data['buyr_tel1'] = ''; //주문자 전화번호
            $data['buyr_tel2'] = $paymentData->buyerMobile; //주문자 휴대폰번호
            $data['shop_user_id'] = $paymentData->buyerId; //쇼핑몰회원ID

            //표준웹 필수 정보(변경 불가)
            $data['module_type'] = $this->module_type;
            $data['res_cd'] = '';
            $data['res_msg'] = '';
            $data['enc_info'] = '';
            $data['enc_data'] = '';
            $data['ret_pay_method'] = '';
            $data['tran_cd'] = '';
            $data['use_pay_method'] = '';

            //주문정보 검증 관련 정보 : 표준웹 에서 설정하는 정보입니다
            $data['ordr_chk'] = '';

            //현금영수증 관련 정보 : 표준웹 에서 설정하는 정보입니다
            $data['cash_yn'] = '';
            $data['cash_tr_code'] = '';
            $data['cash_id_info'] = '';
            $data['good_expr'] = '0'; //제공 기간 설정 0:일회성 1:기간설정(ex 1:2012010120120131)

            //신용카드 옵션
            $data['quotaopt'] = '12'; //50,000원 이상 거래에 대한 할부 옵션. 기본값은 12개월. 0~12의 값을 설정하면 결제 창에 할부 개월 수가 최대값까지 표기됨
//            $data['kcp_noint'] = ''; //무이자할부 표시기능“” : 상점관리자 설정에 따름“Y” : kcp_noint_quota 값에 따라 무이자표시(단, 상점관리자에 설정이 되어야 함)“N” : 상점관리자 값을 무시하고 일반할부로 처리됨
//            $data['kcp_noint_quota'] = ''; //무이자할부 표시기능이 Y 일 경우 무이자 설정 값을 결제창에 표기 무이자 설정은 카드사 별로 설정 가능
//            $data['used_card_YN'] = ''; //결제 요청 시 원하는 신용카드사 확인 해당 변수 값을 Y로 설정 후 used_card 변수 값에 원하는 신용카드사의 코드를 입력하면 입력한 신용카드사만 결제창에 노출
//            $data['used_card'] = ''; //used_card_YN 변수 값을 Y로 설정한 후 사용하길 원하는 신용카드사의 코드 입력
//            $data['fix_inst'] = ''; //결제금액이 50,000원 이상일 경우 결제 창에서 선택 할 수 있는 할부 개월 수를 0~12 의 값 중 하나로 고정
//            $data['used_card_CCXX'] = 'Y'; //해외카드 구분하는 파라미터 입니다.(해외비자, 해외마스터, 해외JCB로 구분하여 표시)
//            $data['save_ocb'] = 'Y'; //신용카드 결제시 OK캐쉬백 적립 여부를 묻는 창을 설정하는 파라미터 입니다. 포인트 가맹점의 경우에만 창이 보여집니다.

            //가상계좌 옵션
//            $data['wish_vbank_list'] = ''; //NHN KCP에서 제공하는 은행 중 가맹점이 원하는 은행을 선택할 수 있음
            $data['vcnt_expire_term'] = ceil((strtotime($paymentData->vbankExpirationDate) - time()) / 60 / 60 / 24); //가상계좌 유효기간 설정
//            $data['vcnt_expire_term_time'] = ''; //가상계좌 유효시간 설정. vcnt_expire_term과 부수적으로 설정되는 변수 HHMMSS형식으로 입력하시기 바랍니다. 설정을 안하시는경우 기본적으로 23시59분59초가 세팅이 됩니다

            //휴대폰 옵션
//            $data['hp_apply_yn'] = ''; //원하는 통신사만 노출시킬 수 있음 변수 값을 Y로 설정한 후 hp_commid 변수의값에 통신사 코드를 입력하면 결제창에 해당통신사만 노출됨
//            $data['hp_commid'] = ''; //하나의 통신사만 설정 가능

//            포인트 옵션
//            $data['complex_pnt_yn'] = ''; //포인트 결제 시 결제 금액의 일부를 신용카드 결제와 함께 사용 가능 complex_pnt_yn 을 ‘N’으로 설정하면 포인트로만 결제 이루어짐
//            $data['pt_memcorp_cd'] = ''; //베네피아(SK M&C)에서 발급한 회원소속사코드로 베네피아 복지포인트를 사용한다면 필수로처리

            //현금영수증 옵션
//            $data['disp_tax_yn'] = ''; //계좌이체, 가상계좌를 이용한 현금 결제 시 결제 금액이 1원 이상인 경우, 결제 창에 현금영수증 등록여부를 보여줌 현금영수증 자동등록을 원할 경우 해당 변수를 Y 로 설정. 가상계좌의 경우 입금 완료 후 현금영수증 등록됨 Y : 소득공제용, 지출증빙용 노출 N : 현금영수증 숨기기 R : 소득공제용만 노출 E : 지출증빙용만 노출

            //옵션
//            $data['site_logo'] = ''; //결제 창 왼쪽 상단에 가맹점 사이트의 로고를 띄움. 업체의 로고가 있는 URL을 정확히 입력해야 하며 해당 변수 생략 시에는 로고가 뜨지않고 site_name 값이 표시됨 로고 파일은 GIF, JPG 파일만 지원 최대 사이즈 : 150 X 50 미만 이미지 파일을 150 X 50 이상으로 설정 시 site_name 값이 표시됨
//            $data['eng_flag'] = ''; //결제 창 한글/영문 변환 신용카드, 계좌이체, 가상계좌, 휴대폰소액결제에 적용
//            $data['skin_indx'] = ''; //결제 창 스킨 변경. 1~11까지 설정 가능
//            $data['good_cd'] = ''; //상품코드 : 주문상품명으로 구분이 어려운 경우 상품군을 따로 구분하여 처리할 수 있는 옵션기능
//            $data['kcp_pay_title'] = ''; //결제창의 상단문구를 변경할 수 있는 파라미터 입니다.
            //※ tax_flag 변수 추가 안내 사항
            //① NHN KCP 운영팀(1544 - 8660)으로 복합과세 신청이 된, 복합과세 전용 사이트코드로 계약한 가맹점에만 해당 (스마트폰의 경우 신서버 smpay 모듈에만 적용)
            //② 상품별이 아니라 금액으로 구분하여 요청
            //③ 복합과세 구분 파라미터를 보내지 않으면 기본적으로 과세 금액으로 처리되니 복합과세로 처리를 원하시면 반드시 tax_flag, tax_mny, free_mny, vat_mny 값을 전송
            //④ 복합과세 이용 시 OCB 포인트 사용 및 적립, 베네피아 복지포인트 사용을 신용카드와 함께 진행할 경우 복합과세로 처리되지 않으니 유의
            if ($this->tax_use_yn == 'Y') {
                $data['tax_flag'] = 'TG03'; //복합 과세 구문 TG01 : 과세 TG02 : 비과세 TG03 : 복합과세
                $data['comm_tax_mny'] = round($paymentData->taxAmt / 1.1); //과세 승인금액 (공급가액) 과세 금액에 해당하는 공급가액 설정 과세 금액 = good_mny / 1.1
                $data['comm_free_mny'] = $paymentData->taxExAmt; //비과세 승인금액 비과세 금액에 해당하는 공급가액 설정 비과세 금액 = good_mny – 과세금액 – 부가가치세
                $data['comm_vat_mny'] = ($paymentData->taxAmt - $data['comm_tax_mny']); //부가가치세 부가가치세는 과세금액 공금가액의 10 % 부가가치세 = good_mny – 과세금액
            }
        } else {

            //인코딩 설정
            $data['encoding_trans'] = 'UTF-8'; //인코딩 네임은 대문자

            //주문정보
            $data['ordr_idxx'] = $paymentData->oid; //상점 관리 주문번호
            $data['pay_method'] = $this->getMobilePayMethod($paymentData->method);
            $data['ActionResult'] = $this->getActionResult($paymentData->method);
            $data['good_name'] = $paymentData->goodsName; //상품명
            $data['van_code'] = $this->getVanCode($paymentData->method);
            $data['good_mny'] = $paymentData->amt; //결제 금액
            $data['buyr_name'] = $paymentData->buyerName; //주문자명
            $data['buyr_mail'] = $paymentData->buyerEmail; //주문자 이메일
            $data['buyr_tel1'] = ''; //주문자 전화번호
            $data['buyr_tel2'] = $paymentData->buyerMobile; //주문자 휴대폰번호
            $data['shop_user_id'] = $paymentData->buyerId; //쇼핑몰에서 관리하는 회원 ID 유니크한 값으로 입력

            //에스크로 옵션
			$data['escw_used'] = 'N';
			if($paymentData->method == 9){
				$data['escw_used'] = 'Y'; //에스크로 사용 여부 : 반드시 Y 로 설정
				$data['pay_mod'] = 'Y'; //에스크로 결제처리 모드 : 에스크로: Y, 일반: N, KCP 설정 조건: O
				$data['deli_term'] = '07'; //예상되는 배송 소요 일을 입력 반드시 형식을 2자리(일자)의 숫자로 입력
				$data['bask_cntx'] = $paymentData->goodsCount; //장바구니에 담겨있는 상품의 개수 장바구니의 상품 개수는 반드시 40개 이하
			}

            //필수 정보
            $data['req_tx'] = 'pay';// 요청종류 : 승인(pay)/취소,매입(mod) 요청시 사용
            $data['shop_name'] = $this->g_conf_site_name; //상점이름(영문으로 작성권장)
            $data['site_cd'] = $this->g_conf_site_cd; //상점코드
            $data['Ret_URL'] = HTTP_PROTOCOL . FORBIZ_HOST . '/payment/kcp/result';
            $data['param_opt_1'] = ''; //NHN KCP 기본 파라미터 외 업체 추가 파라미터
            $data['param_opt_2'] = ''; //NHN KCP 기본 파라미터 외 업체 추가 파라미터
            $data['param_opt_3'] = $paymentData->method; //NHN KCP 기본 파라미터 외 업체 추가 파라미터
            $data['currency'] = '410'; //거래 화폐 단위 원화 : 410
            $keyResponse = $this->getApprovalKey($data);
            $data['approvalKeyResCD'] = $keyResponse['resCD'];
            $data['approvalKeyresMsg'] = $keyResponse['resMsg'];
            $data['approval_key'] = $keyResponse['approvalKey'];//거래인증 코드 (수정불가
            $data['PayUrl'] = $keyResponse['payUrl']; //approval_key.js 를 통해 리턴 받은 결제 창 호출 주소. 전달 받은 값 그대로 요청

            if (getAppType()) {
                $data['AppUrl'] = APP_SCHEME;
            }

            //신용카드 옵션
            $data['quotaopt'] = '12'; //50,000원 이상 거래에 대한 할부 옵션. 기본값은 12개월. 0~12의 값을 설정하면 결제 창에 할부 개월 수가 최대값까지 표기됨
//            $data['kcp_noint'] = ''; //무이자할부 표시기능“” : 상점관리자 설정에 따름“Y” : kcp_noint_quota 값에 따라 무이자표시(단, 상점관리자에 설정이 되어야 함)“N” : 상점관리자 값을 무시하고 일반할부로 처리됨
//            $data['kcp_noint_quota'] = ''; //무이자할부 표시기능이 Y 일 경우 무이자 설정 값을 결제창에 표기 무이자 설정은 카드사 별로 설정 가능
//            $data['used_card'] = ''; //used_card_YN 변수 값을 Y로 설정한 후 사용하길 원하는 신용카드사의 코드 입력

            //가상계좌 옵션
            $data['ipgm_date'] = $paymentData->vbankExpirationDate; //발급된 가상계좌에 입금할 예정일 입력 (포맷 : yymmdd 또는 yyyymmddhhMMss) 예 : 20170111 또는 20170111235959
//            $data['used_bank'] = ''; //NHN KCP에서 제공하는 은행 중 가맹점이 원하는 은행을 선택

            //휴대폰 옵션
//            $data['hp_apply_yn'] = ''; //원하는 통신사만 노출시킬 수 있음 변수 값을 Y로 설정한 후 hp_comm_id 변수의 값에 통신사 코드를 입력하면 결제창에 해당 통신사만 노출됨
//            $data['hp_comm_id'] = ''; //하나의 통신사만 설정 가능

            //현금영수증 옵션
//            $data['disp_tax_yn'] = ''; //계좌이체, 가상계좌를 이용한 현금 결제 시 결제 금액이 1원 이상인 경우, 결제 창에 현금영수증 등록여부를 보여줌 현금영수증 자동등록을 원할 경우 해당 변수를 Y 로 설정. 가상계좌의 경우 입금 완료 후 현금 영수증 등록됨 Y : 소득공제용, 지출증빙용 노출 N : 현금영수증 숨기기 R : 소득공제용만 노출 E : 지출증빙용만 노출

            //복함과세 옵션
            //※ tax_flag 변수 추가 안내 사항
            //① NHN KCP 운영팀(1544 - 8660)으로 복합과세 신청이 된, 복합과세 전용 사이트코드로 계약한 가맹점에만 해당 (스마트폰의 경우 신서버 smpay 모듈에만 적용)
            //② 상품별이 아니라 금액으로 구분하여 요청
            //③ 복합과세 구분 파라미터를 보내지 않으면 기본적으로 과세 금액으로 처리되니 복합과세로 처리를 원하시면 반드시 tax_flag, tax_mny, free_mny, vat_mny 값을 전송
            //④ 복합과세 이용 시 OCB 포인트 사용 및 적립, 베네피아 복지포인트 사용을 신용카드와 함께 진행할 경우 복합과세로 처리되지 않으니 유의
            if ($this->tax_use_yn == 'Y') {
                $data['tax_flag'] = 'TG03'; //복합 과세 구문 TG01 : 과세 TG02 : 비과세 TG03 : 복합과세
                $data['comm_tax_mny'] = round($paymentData->taxAmt / 1.1); //과세 승인금액 (공급가액) 과세 금액에 해당하는 공급가액 설정 과세 금액 = good_mny / 1.1
                $data['comm_free_mny'] = $paymentData->taxExAmt; //비과세 승인금액 비과세 금액에 해당하는 공급가액 설정 비과세 금액 = good_mny – 과세금액 – 부가가치세
                $data['comm_vat_mny'] = ($paymentData->taxAmt - $data['comm_tax_mny']); //부가가치세 부가가치세는 과세금액 공금가액의 10 % 부가가치세 = good_mny – 과세금액
            }
        }

        return $data;
    }

    public function doApply($data)
    {
        //카카오 페이 설정
        if ($data['method'] == ORDER_METHOD_KAKAOPAY) {
            $this->kakaopayChangeGconf();
        }
        $this->g_conf_log_path = $data['logPath'];

        $this->loadPayPlus();

        $this->c_PayPlus->mf_set_encx_data($data["enc_data"], $data["enc_info"]);
        $this->c_PayPlus->mf_set_ordr_data("mony", $data['mony']);

        $this->odPayPlus($data['tran_cd'], $data['oid']);

        return $this->c_PayPlus;
    }

    public function doCancel(PgForbizCancelData $cancelData, PgForbizResponseData $responseData): PgForbizResponseData
    {
        //카카오 페이 설정
        if ($cancelData->method == ORDER_METHOD_KAKAOPAY) {
            $this->kakaopayChangeGconf();
        }

        $this->g_conf_log_path = $cancelData->logPath;

        $this->loadPayPlus();

        $this->c_PayPlus->mf_set_modx_data("tno", $cancelData->tid);  // KCP 원거래 거래번호
        $this->c_PayPlus->mf_set_modx_data("mod_ip", $this->input->server("REMOTE_ADDR"));  // 변경 요청자 IP
        $this->c_PayPlus->mf_set_modx_data("mod_desc", '');  // 변경 사유


        if ($cancelData->isPartial) {
            $this->c_PayPlus->mf_set_modx_data("mod_type", "STPC");  // 부분취소 STPC
            $this->c_PayPlus->mf_set_modx_data("mod_mny", $cancelData->amt); // 취소요청 금액
            $this->c_PayPlus->mf_set_modx_data("rem_mny", ($cancelData->amt + $cancelData->expectedRestAmt)); // 부분취소 이전에 남은 금액
            if ($this->tax_use_yn == 'Y') {
                $this->c_PayPlus->mf_set_modx_data("tax_flag", "TG03");  // 복합과세 거래 구분 값입니다. (복합과세)

                $mod_tax_mny = round($cancelData->taxAmt / 1.1);
                $this->c_PayPlus->mf_set_modx_data("mod_tax_mny", (string)$mod_tax_mny);  // 공급가 부분취소 요청금액(복합과세)
                $this->c_PayPlus->mf_set_modx_data("mod_vat_mny", (string)($cancelData->taxAmt - $mod_tax_mny));  // 부가세 부분취소 요청금액 (복합과세)
                $this->c_PayPlus->mf_set_modx_data("mod_free_mny", (string)$cancelData->taxExAmt);  // 비과세 부분취소 요청금액 (복합과세)
            }
        } else {
            $this->c_PayPlus->mf_set_modx_data("mod_type", "STSC");  // 전체취소 STSC
        }

        $this->odPayPlus("00200000", $cancelData->oid);

        if ($this->c_PayPlus->m_res_cd == '0000') {
            $responseData->result = true;
        } else {
            $responseData->result = false;
            $responseData->message = $this->c_PayPlus->m_res_msg;
        }
        return $responseData;
    }

    public function getMethod($payMethod)
    {
        return array_search($payMethod, $this->methodMapping) ?? '';
    }

    private function getPayMethod($method)
    {
        return $this->methodMapping[$method] ?? '';
    }

    private function getMobilePayMethod($method)
    {
        return $this->methodMobileMapping[$method] ?? '';
    }

    private function getActionResult($method)
    {
        return $this->methodActionResultMapping[$method] ?? '';
    }

    private function getVanCode($method)
    {
        return $this->methodVanCodeMapping[$method] ?? '';
    }

    private function getApprovalKey($data)
    {
        require_once __DIR__ . "/kcp/KCPComLibrary.php";

        // 쇼핑몰 페이지에 맞는 문자셋을 지정해 주세요.
        $charSetType = "utf-8";             // UTF-8인 경우 "utf-8"로 설정

        $siteCode = $this->g_conf_site_cd;
        $orderID = $data['ordr_idxx'];
        $paymentMethod = $data['pay_method'];
        $escrow = ($data["escw_used"] == "Y") ? true : false;
        $productName = $data["good_name"];

        // 아래 두값은 POST된 값을 사용하지 않고 서버에 SESSION에 저장된 값을 사용하여야 함.
        $paymentAmount = $data["good_mny"]; // 결제 금액
        $returnUrl = $data["Ret_URL"];

        // Access Credential 설정
        $accessLicense = "";
        $signature = "";
        $timestamp = "";

        // Base Request Type 설정
        $detailLevel = "0";
        $requestApp = "WEB";
        $requestID = $orderID;
        $userAgent = $this->input->server("HTTP_USER_AGENT");
        $version = "0.1";

        try {
            $payService = new PayService($this->g_wsdl);

            $payService->setCharSet($charSetType);

            $payService->setAccessCredentialType($accessLicense, $signature, $timestamp);
            $payService->setBaseRequestType($detailLevel, $requestApp, $requestID, $userAgent, $version);
            $payService->setApproveReq($escrow, $orderID, $paymentAmount, $paymentMethod, $productName, $returnUrl, $siteCode);

            $approveRes = $payService->approve();

            $resCD = $payService->resCD;
            $approvalKey = $approveRes->approvalKey;
            $payUrl = $approveRes->payUrl;
            $resMsg = $payService->resMsg;
        } catch (SoapFault $ex) {
            $resCD = '95XX';
            $approvalKey = '';
            $payUrl = '';
            $resMsg = '연동 오류 (PHP SOAP 모듈 설치 필요)';
        }
        return [
            'resCD' => $resCD
            , 'approvalKey' => $approvalKey
            , 'payUrl' => $payUrl
            , 'resMsg' => $resMsg
        ];
    }

    private function loadPayPlus()
    {
        if ($this->c_PayPlus === false) {
            if (is_windows()) {
                require_once __DIR__ . "/kcp/windows/pp_cli_hub_lib.php";
            } else {
                require_once __DIR__ . "/kcp/linux/pp_cli_hub_lib.php";
            }
            $this->c_PayPlus = new C_PP_CLI;
        }
        $this->c_PayPlus->mf_clear();
    }

    private function odPayPlus($tran_cd, $ordr_idxx)
    {
        if (is_windows()) {
            $this->c_PayPlus->mf_do_tx("", $this->g_conf_home_dir, $this->g_conf_site_cd, $this->g_conf_site_key, $tran_cd, "",
                $this->g_conf_gw_url, $this->g_conf_gw_port, "payplus_cli_slib", $ordr_idxx,
                $this->input->server("REMOTE_ADDR"), $this->g_conf_log_level, 0, 0, $this->g_conf_key_dir, $this->g_conf_log_path); // 응답 전문 처리
        } else {
            $this->c_PayPlus->mf_do_tx("", $this->g_conf_home_dir, $this->g_conf_site_cd, $this->g_conf_site_key, $tran_cd, "",
                $this->g_conf_gw_url, $this->g_conf_gw_port, "payplus_cli_slib", $ordr_idxx,
                $this->input->server("REMOTE_ADDR"), $this->g_conf_log_level, 0, 0, $this->g_conf_log_path); // 응답 전문 처리
        }

        //인코딩 변환
        foreach ($this->c_PayPlus->m_res_data as $key => $val) {
            $this->c_PayPlus->m_res_data[$key] = iconv('EUC-KR', 'UTF-8', $val);
        }
        //결과 값도 변경
        $this->c_PayPlus->m_res_cd = $this->c_PayPlus->m_res_data["res_cd"];
        $this->c_PayPlus->m_res_msg = $this->c_PayPlus->m_res_data["res_msg"];
    }
}
