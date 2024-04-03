"use strict";

common.lang.load('cart.nonMbmer.payment.confirm', "{shopName} 회원입니까?{common.lineBreak}회원인 경우 로그인하기 버튼을 선택해 주세요."); //Confirm_25
common.lang.load('cart.goCart.confirm', "해당 상품이 장바구니에 담겼습니다.");
common.lang.load('cart.delete.noSelect.alert', "삭제할 상품을 선택해 주세요."); //Alert_47
common.lang.load('cart.update.count.failBasicCount.alert', "최소 구매 가능 수량은 {count}개입니다.  {count}개 이상 입력해 주세요."); //Alert_103
common.lang.load('cart.update.count.failMaxCount.alert', "최대 구매 가능 수량은 {count}개입니다."); //Alert_103
//common.lang.load('cart.update.count.failByOnePersonCount.alert', "ID당 구매 가능한 수량의 최대 {count}개를 초과하였습니다."); //Alert_102
common.lang.load('cart.update.count.failByOnePersonCount.alert', "회원 ID당 최대 구매 가능 수량은 {count}개 입니다."); //Alert_102
//common.lang.load('cart.update.count.noLogin.alert', "ID당 구매 가능한 수량이 제한되어있는 상품입니다. 로그인 후 구매해주세요.");
common.lang.load('cart.update.count.noLogin.alert', "로그인 시 구매 가능한 상품입니다.");
common.lang.load('cart.update.count.failStockLack.alert', "주문 가능한 재고수량은 최대 {count}개입니다. {count}개 이하로 입력해 주세요."); //Alert_104
common.lang.load('cart.update.count.failNoSale.alert', "해당 상품이 품절되었습니다."); //Alert_108
common.lang.load('cart.update.count.failNoSaleToReStock.confirm', "해당 상품이 품절되었습니다. 재입고 알림을 받으시겠습니까?"); //Alert_108
common.lang.load('cart.buy.noSelect.alert', "옵션을 선택해 주세요.");
common.lang.load('cart.buy.noGiftSelect.alert', "사은품을 선택해주세요.");
common.lang.load('cart.update.count.checkOrderPossible.alert', "본품을 반드시 하나 이상 구매하셔야합니다.");
common.lang.load('cart.update.count.failNotNumeric.alert', "숫자를 입력해주시기 바랍니다.");
//common.lang.load('cart.nonMber.direct.confirm', "비회원 구매를 하시겠습니까?");
common.lang.load('cart.nonMber.direct.confirm', "[회원 가입 혜택]\n즉시 사용 가능한 5,000원, 10,000원 할인쿠폰\n등급별 쿠폰, 적립, 할인 혜택\n\n회원가입 없이 구매 하시겠습니까?");

common.lang.load('cart.option.addoption.select', "추가 옵션 선택");
common.lang.load('cart.option.button.size', "사이즈");
common.lang.load('cart.option.button.color', "색상");
//함수명 앞에 _가 붙으면 내부에서 사용하는 함수

var devMiniCart = function () {
    return {
        contents: '', //옵션 셀렉트박스 전체 영역
        optionsSelectBox: 'devMinicartOptionsBox', //각 옵션 셀렉트박스
        optionsClickBox: 'devMinicartOptionsClickBox', //각 옵션 셀렉트박스
        addOptionsContents: '', //추가구성 셀렉트박스 전체 영역
        addOptionsSelectBox: 'devMinicartAddOptionsBox', //각 추가구성 셀렉트박스
        giftSelectBox: '.devGiftSelect', //각 추가구성 셀렉트박스
        choosedContents: '', //최종 선택된 옵션(미니카트 결과) 전체 영역
        choosedDetails: '', //최종 선택된 옵션 각각의 영역
        choosedTemplate: '', //최종 선택된 옵션 템플릿 사용
        lonelyTemplate: '', //최종 선택된 옵션 템플릿 사용
        price: '', //최종 선택된 옵션 각각의 가격
        totalPrice: '', //총 금액

        price_ig: '', //최종 선택된 옵션 각각의 가격
        totalPrice_ig: '', //총 금액

        deleteBtn: '',
        plusBtn: '',
        minusBtn: '',
        cntInput: '', //상품개수 컨트롤 인풋창
        controlCntBox: '',
        cartBtn: '',
        optData: [], //options
        optViewData: [], //viewOptions
        optAddData: [], //addOptions
        allowBasicCnt: 1, //최소수량
        allowByPersonCnt: 0, //아이디당 최대수량
        allowMaxCnt:0,//최대구매수량
        userBuyCnt:0,//회원구매수량
        syncObj: false, //PC 하단 옵션영역과 싱크 맞추기 위한 값
        isAdding: false, //adding
        langType: '',
        product_state: '', // 상품판매상태
        changeOptionId:'',//옵션 수정시 사용할 선택된 옵션 아이디 값
        setOptionData: function (optionData) { //데이터 세팅
            this.optData = optionData.options; //옵션별로 조합된 최종 데이터
            this.optViewData = optionData.viewOptions; //프론트 노출에 사용하기 위해 분리한 옵션 데이터
            this.optAddData = optionData.addOptions; //추가구성 데이터
            this.langType = common.langType;
            return this;
        },
        setProductState: function (product_state) {
            this.product_state = product_state;
            return this;
        },
        setOptionViewType: function (viewType) {
            this.viewType = viewType;
            return this;
        },
        setBasicCnt: function (allowBasicCnt, allowByPersonCnt,allowMaxCnt,userBuyCnt) { //최소, 아이디당 최대수량 세팅
            if (allowBasicCnt > 0) {
                this.allowBasicCnt = allowBasicCnt;
            }
            if (allowByPersonCnt > 0) {
                this.allowByPersonCnt = allowByPersonCnt;
            }
            if (allowMaxCnt > 0) {
                this.allowMaxCnt = allowMaxCnt;
            }
            if (userBuyCnt > 0) {
                this.userBuyCnt = userBuyCnt;
            }
            return this;
        },
        setContents: function (minicartArea, contents, addOptionsContents, lonelyContents, lonelyTemplate) { //각 옵션선택 영역 지정 세팅
            this.minicartArea = minicartArea;
            this.contents = contents;
            this.addOptionsContents = addOptionsContents;
            this.lonelyContents = lonelyContents;
            this.lonelyTemplate = common.ajaxList().compileTpl(lonelyTemplate); //옵션 1개일 경우 상단 옵션 선택 영역 템플릿 처리
            return this;
        },
        setChoosedContents: function (Contents, Details) { //최종 선택된 옵션 영역 지정 세팅
            this.choosedContents = Contents;
            this.choosedDetails = Details;
            this.choosedTemplate = common.ajaxList().compileTpl($(this.choosedContents).find(Details)); //최종 선택된 옵션 영역 템플릿 처리
            return this;
        },
        setControlPrice: function (total, unit) { //최종가, 각 옵션가 영역 지정 세팅
            this.totalPrice = total;
            this.price = unit;
            return this;
        },
        setControlPrice_ig: function (total, unit) { //최종가, 각 옵션가 영역 지정 세팅
            this.totalPrice_ig = total;
            this.price_ig = unit;
            return this;
        },
        setControlCntElement: function (boxId, p, m, id) { //최종 선택된 옵션개수 변경
            this.controlCntBox = boxId;
            this.plusBtn = p;
            this.minusBtn = m;
            this.cntInput = id;
            return this;
        },
        setBtn: function (deleteBtn, cartBtn, directBtn, changeBtn) {
            this.deleteBtn = deleteBtn;
            this.cartBtn = cartBtn;
            this.directBtn = directBtn;
            this.changeBtn = changeBtn;
            return this;
        },
        init: function () {
            this._makeOptionsArea(); //옵션 영역 생성
            this._makeAddOptionsArea(); //추가구성 영역 생성

            this._optionSelectEventBind(); //옵션 선택시 이벤트
            this._addOptionSelectEventBind(); //추가구성 선택시 이벤트
            this._cancelChoosedEventBind(); //미니카트에 담긴 옵션 삭제
            this._changeChoosedCntEventBind(); //미니카트 개수 플러스/마이너스

            this._addCartsEventBind(); //장바구니 / 바로구매 이벤트

            this._reStockEventBind();//재입고 알림 선택 시 이벤트
			this._reSizeEventBind();//사이즈가이드 선택 시 이벤트

            if( $('.popup-layout').is(':visible')) popup_customer_m(); //
        },
        sync: function (cartObj) {
            this.syncObj = cartObj; //상단, 하단 옵션 영역을 싱크하기 위한 작업
        },
        _reStockEventBind:function(){

            $(this.minicartArea).on('click','.devNotifyItem',function(){
                var pid = $(this).data('pid');

                if (forbizCsrf.isLogin) {
                    common.util.modal.open('ajax', '', '/popup/applyStock/'+pid, '', window.goodsAlarmCallback);
                } else {
                    common.noti.confirm(common.lang.get('product.noMember.confirm', ''), function () {
                        document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
                    });
                }

            });
        },
		_reSizeEventBind:function(){

            $(this.minicartArea).on('click','.devSizeGuide',function(){
				common.util.modal.open('ajax', '', '/shop/goodsPop/', '', window.goodsAlarmCallback);
            });
        },
        _CustomData: function (type, data) { //각 옵션(추가구성, 1개 등) 노출에 필요한 데이터 커스텀
            var self = this;

            if (type == 'only') {
                data.option_name = data.option_div;
                data.option_div_text = data.option_div;
                // data.option_div = '';
                data.option_kind = '';
                data.pid = $(self.minicartArea).data('pid');
            } else if (type == 'add') {
				//	추가옵션
                data.option_div = data.option_div;
                data.add_info_text = data.add_info;
                data.option_div_text = data.option_div;

					//	2021-01-26 최수빈 매니저 요청
					//data.option_div_text = data.add_info+" : "+data.option_div_text;
					//	//2021-01-26 최수빈 매니저 요청

				

                data.option_kind = 'a';
            } else if(type == 'button'){
                //data.option_div_text = common.lang.get("cart.option.button.size", "")+ ' : ' + data.option_div ;
                //data.add_info_text = common.lang.get("cart.option.button.color", "") + ' : ' + data.add_info;
                data.option_div_text = data.option_div ;
                data.add_info_text = data.add_info;


                data.option_kind = '';
                data.pid = $(self.minicartArea).data('pid');
            }else {
				//	세트상품
                data.option_kind = '';
                data.add_info_text = data.add_info;
                data.option_div_text = data.option_div;

					//	2021-01-26 최수빈 매니저 요청
					//data.option_div_text = data.option_div_text.replace(/,/g,'<br>');
					//	//2021-01-26 최수빈 매니저 요청

                data.pid = $(self.minicartArea).data('pid');
            }

            data.allowBasicCnt = this.allowBasicCnt;
            data.eachPrice = common.util.numberFormat(common.math.mul(this.allowBasicCnt, data.option_dcprice));
            return data;
        },
        _makeOptionsArea: function () { //옵션 셀렉트박스 생성
            var str = [];
            // if (this.optData.length == 1) { //옵션 1개일 경우 영역 노출
            //     this._makeLonelyOptionsArea();
            //     return;
            // }

            var b_origin_option_name = '';
            for (var i = 0; i < this.optViewData.length; i++) {
                var details = this.optViewData[i].optionDetailList;
                var option_name = this.optViewData[i].option_name;

					//	2021-01-26 최수빈 매니저 요청
						if(option_name == "OPTION 1") {
							option_name = "옵션 1 [필수]";
						} else if( option_name == "OPTION 2"){
							option_name = "옵션 2 [필수]";
						} else {

						}
					//	//2021-01-26 최수빈 매니저 요청



                var origin_option_name = this.optViewData[i].origin_option_name;
                var option_kind = this.optViewData[i].option_kind;
                var viewType = this.viewType;
                var option_type = this.optViewData[i].option_type;

                if(!viewType){
                    if(option_kind == 'b' && option_type == 'c'){
                        viewType = 'button';
                    } else if (option_kind == 'c' && option_type == 'd') {
                        viewType = 'codi';
                    }
                }



                var soldOutBool = false;
                for (var z = 0; z < details.length; z++) {
                    if (details[z].option_stock !== undefined && details[z].option_stock == 0) {
                        soldOutBool = true;
                    }
                }
                var pid = $(this.minicartArea).data('pid');

                if(viewType == 'button'){
                    /*str.push('<div class="goods-info__size">');
                    str.push('<h4 class="goods-info__size__title">'+option_name+'<span class="devSizeInfo"></span></h4>');
                    if(this.langType != 'english'){
                        //str.push('<button type="button" class="goods-info__size__guide">사이즈 가이드</button>');
						str.push('<button type="button" style="border-bottom:none;right:0.3rem;top:1.4rem;position:absolute;padding:0;color:#b5b5b6;font-size:1rem;line-height:1.5rem;" class="devSizeGuide">신체 사이즈 가이드</button>');
                    }
                    str.push('<ul class="goods-info__size__list  ">');
                    str.push(this._setOptionsHtml(details,viewType)); //<option> 리스트 html 생성
                    str.push('</ul>');

                    if(soldOutBool && this.langType != 'english' && this.product_state != 'end'){
                        str.push('<button type="button" class="goods-info__size__alarm devNotifyItem" data-pid="'+pid+'">입고 알림 신청</button>');
                    }
                    str.push('</div>');*/
                    str.push('<div class="goods-info__option-title">');
                    str.push('<div class="title-sm">'+option_name+'</div>');
                    str.push('</div>');
                    str.push('<div class="goods-info__option-cont">');
                    str.push('<ul class="goods-info__size__list">');
                    str.push(this._setOptionsHtml(details,viewType)); //<option> 리스트 html 생성
                    str.push('</ul>');
                    str.push('</div>');
                    if(soldOutBool && this.langType != 'english' && this.product_state != 'end'){
                        str.push('<button type="button" class="btn-md btn-dark-line goods-info__size__alarm" data-pid="'+pid+'" onclick=DownLayerJSNew("layer-restock1")>입고 알림 신청</button>');
                    }
                }else{
                    if (viewType == 'codi' && i != 0 && b_origin_option_name != origin_option_name) {
                        str.push('</div>');
                    }
                    if (viewType == 'codi' && b_origin_option_name != origin_option_name) {
					//	2021-01-26 최수빈 매니저 요청
						if(i == 0) {
	                        str.push('<div class="goods-info__set">');
						} else {
	                        str.push('<div class="goods-info__set bxbx2">');
						}

					//	//2021-01-26 최수빈 매니저 요청
                        str.push('<h4 class="goods-info__set__title">' + origin_option_name + '</h4>');
                    }
                    if (i == 0) {
                        str.push('<div class="goods-info__set__box">');
                        str.push('<select class="' + this.optionsSelectBox + '" data-index="' + i + '" data-pid="' + pid + '">');
                        str.push('<option value="">' + option_name + '</option>');
                        str.push(this._setOptionsHtml(details)); //<option> 리스트 html 생성
                        str.push('</select>');
                        str.push('</div>');
                    } else {
					//	2021-01-26 최수빈 매니저 요청
						if((i % 2) == 0) { 
	                        str.push('<div class="goods-info__set__box">');
						} else {
	                        str.push('<div class="goods-info__set__box bx2">');
						}
					//	//2021-01-26 최수빈 매니저 요청
                        str.push('<select class="' + this.optionsSelectBox + '" data-index="' + i + '" data-pid="' + pid + '" disabled>');
                        str.push('<option value="">' + option_name + '</option>');
                        str.push('</select>');
                        str.push('</div>');
                    }
                    if (viewType == 'codi' && this.optViewData.length == i + 1) {
                        str.push('</div>');
                    }
                }
                b_origin_option_name = origin_option_name;
            }
            $(this.contents).append(str.join(''));
        },
        _makeLonelyOptionsArea: function () { //옵션 1개일 경우 영역 생성
            var str = '';
            var data = this._CustomData('only', this.optData[0]);

            $(this.choosedContents).append(this.choosedTemplate(data)); //하단 개수 영역(여기에선 옵션명 미노출 180918 기획서 기준)
            $(this.choosedContents).find(this.deleteBtn).remove(); //옵션이 1개일때 삭제 버튼 삭제
            if (this.optAddData.length > 0) {
                $(this.lonelyContents).show();
                $(this.lonelyContents).append(this.lonelyTemplate(data)); //상단 옵션명 노출 영역
            }
            this._calculate();
        },
        _makeAddOptionsArea: function () { //추가구성 셀렉트박스 생성
            if (this.optAddData.length > 0) {
                var str = [];
                var addAttr = '';
                var viewType = this.viewType;
                var langType = this.langType;
                if (this.optData.length > 1 && this.optViewData.length > 1) { //1개 옵션이 아닐 경우에는 최초엔 선택불가
                    addAttr = 'disabled';
                }
                if(viewType == 'change'){
                    str.push('<ul class="goods-info__set__list">');
                }else {
                    str.push('<ul class="goods-option__list">');
                }

                for (var i = 0; i < this.optAddData.length; i++) {
                    var details = this.optAddData[i].optionDetailList;
                    var option_name = this.optAddData[i].option_name;

					//	2021-01-26 최수빈 매니저 요청
						if(option_name == "OPTION 1") {
							option_name = "옵션 1 [필수]";
						} else if( option_name == "OPTION 2"){
							option_name = "옵션 2 [필수]";
						} else {

						}
					//	//2021-01-26 최수빈 매니저 요청

                    var add_info = this.optAddData[i].add_info;
                    var images = this.optAddData[i].images;
                    var optListprice = this.optAddData[i].optionDetailList[0].option_listprice;
                    var optDcprice = this.optAddData[i].optionDetailList[0].option_dcprice;
                    var optDiscountRate = this.optAddData[i].optionDetailList[0].option_discount_rate;

                    if(viewType == 'change'){
                        str.push('<li class="goods-info__set__box">');
                        str.push('<select class="devMinicartAddOptionsBox" ' + addAttr + '>');
                        str.push('<option value="">' + option_name + '</option>');
                        str.push(this._setAddOptionsHtml(details)); //<option> 리스트 html 생성
                        str.push('</select>');
                        str.push('</li>');
                    }else{
                        str.push('<ul class="goods-option__list goods-option__list2">');
                        str.push('    <li class="goods-option__box" style="border-bottom:0px;">');
                        str.push('        <figure class="goods-option__thumb" id="devInvenImg_'+i+'">');
                        str.push('            <img src="'+images+'" alt="옵션 썸네일">');
                        str.push('        </figure>');
                        str.push('        <div class="goods-option__info">');
                        str.push('            <p class="goods-option__info__title" style="padding-bottom:7px;">' + option_name + '</p>');
                        str.push('            <p class="goods-option__info__addinfo" style="color:#a5a5a5;">' + add_info + '</p>');
                        str.push('            <p class="goods-cart__price devAddOptionPrice"></p>');
                        str.push('            <div class="product-list__info__price">');
                        if (optDiscountRate != 0){
                            str.push('                <span class="product-list__info__price--discount">' + optDiscountRate + '%</span>');
                            str.push('                <del class="product-list__info__price--strike"><em>' + optListprice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</em>원</del>');
                        }
                        str.push('                <span class="product-list__info__price--cost"><em>' + optDcprice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</em>원</span>');
                        str.push('            </div>');

                        str.push('           <div class="br__select-box">');
                        str.push('                <div class="select-box">');
                        str.push('                    <select class="devMinicartAddOptionsBox" ' + addAttr + ' data-index="' + i + '">');
                        str.push('                      <option value="">'+common.lang.get("cart.option.addoption.select", "")+'</option>');
                        str.push(this._setAddOptionsHtml(details)); //<option>
                        str.push('                    </select>');
                        str.push('               </div>');
                        str.push('            </div>');
                        str.push('        </div>');
                        str.push('    </li>');
                        str.push('</ul>');

						/*
                        if(i == 0){
                            str.push('<dl class="product-item" style="border-top:0px;margin-top:0px;">');
                        }else{
                            str.push('<dl class="product-item" style="border-top:0px;margin-top:15px;">');
                        }
                        str.push('<dt class="product-item__thumbnail-box">');
                        str.push('    <div class="product-item__thumb">');
                        str.push('        <img src="'+images+'" alt=""/>');
                        str.push('    </div>');
                        str.push('</dt>');
                        str.push('<dd class="product-item__infobox">');
                        str.push('    <div class="product-item__info">');
                        str.push('        <div class="product-item__title c-pointer">' + option_name + '</div>');
                        str.push('        <div class="product-item__option">');
                        str.push('            <span>' + add_info + '</span>');
                        str.push('        </div>');
                        str.push('        <div class="product-item__price-group">');
						if (optDiscountRate != 0){
							str.push('            <div class="product-item__price-percent">' + optDiscountRate + '%</div>');
						}
                        str.push('            <div class="product-item__price price"><em>' + optDcprice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</em>원</div>');
						if (optDiscountRate != 0){
							str.push('            <div class="product-item__noprice"><del>' + optListprice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</del>원</div>');
						}
                        str.push('        </div>');
                        str.push('        <div class="product-item__footer">');
                        str.push('            <div class="fb__form-item">');
                        str.push('                <select class="devMinicartAddOptionsBox" ' + addAttr + ' data-index="' + i + '">');
                        str.push('                    <option value="">'+common.lang.get("cart.option.addoption.select", "")+'</option>');
                        str.push(this._setAddOptionsHtml(details)); //<option>
                        str.push('                </select>');
                        str.push('            </div>');
                        str.push('        </div>');
                        str.push('    </div>');
                        str.push('</dd>');
						*/

                    }
                }
                str.push('</ul>');
                $(this.addOptionsContents).append(str.join('')).removeClass('hidden');

                $(this.addOptionsContents).on('change', '.devMinicartAddOptionsBox', function(){
                    var dcprice = $(this).children('option:selected').data('dcprice');
                    var idx = $(this).data('index');
                    var won = '원';
                    if(langType == 'english'){
                        won = 'Won';
                    }
                    //goodsView

					if(dcprice == undefined) {
	                    $('#devSlideMinicartAddOption .devAddOptionPrice').eq(idx).html("");
					} else {
	                    $('#devSlideMinicartAddOption .devAddOptionPrice').eq(idx).html("<em>"+common.util.numberFormat(dcprice)+"</em>" + won);
					}

                    //minicart
					if(dcprice == undefined) {
	                    $('#devMinicartAddOption .devAddOptionPrice').eq(idx).html("");
					} else {
	                    $('#devMinicartAddOption .devAddOptionPrice').eq(idx).html("<em>"+common.util.numberFormat(dcprice)+"</em>" + won);
					}
						
                });
            }
        },
        _optionSelectEventBind: function () { //옵션 선택시 이벤트
            var self = this;
            var langType = this.langType;
            $(self.minicartArea).find('.' + self.optionsClickBox).on('click', function () { //옵션 셀렉트박스 선택시
                $('.'+self.optionsClickBox).removeClass('goods-info__size__btn--active');
                $(this).addClass('goods-info__size__btn--active');
                var seq = parseInt($(this).data('index')); //옵션 인덱스
                $('.devSizeInfo').html($(this).data('info'));

                var division = $(this).data('division'); //옵션 구분
                self._makeClickOptionsArea(seq); //최종 선택된 옵션 추가

                if (self.syncObj) { //싱크되어야하는 값(옵션 영역)이 있을 경우
                    var $target = $(self.syncObj.minicartArea).find('.' + self.syncObj.optionsClickBox + '');
                    $($target).each(function(){
                        if($(this).data('index') == seq && $(this).data('division') == division){
                            $(self.syncObj.minicartArea).find('.' + self.syncObj.optionsClickBox).removeClass('goods-info__size__btn--active');
                            $(this).addClass('goods-info__size__btn--active');
                            self.syncObj._makeClickOptionsArea(seq); //최종 선택된 옵션 추가
                        }
                    });

                }
            });

            var previous;
            $(self.minicartArea).find('.' + self.optionsSelectBox).on('focus', function () {
                previous = $(this).val();
            }).on('change', function () { //옵션 셀렉트박스 선택시
                var seq = parseInt($(this).data('index')); //옵션 인덱스
                var division = $(this).val(); //옵션 구분
                var soldOut = $(this).find(':selected').data('soldoutbool');
                var pid = $(this).data('pid');
                var optionId = $(this).find(':selected').data('optionid');
                optionId = optionId != '' ? optionId : division;


                if(soldOut == true && langType != 'english'){
                    if(common.noti.confirm(common.lang.get('cart.update.count.failNoSaleToReStock.confirm'))){
                        if (forbizCsrf.isLogin) {
                            common.util.modal.open('ajax', '', '/popup/applyStock/'+pid+'/'+optionId, '', window.goodsAlarmCallback);
                        } else {
                            common.noti.confirm(common.lang.get('product.noMember.confirm', ''), function () {
                                document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
                            });
                        }
                    }else {
                        $(this).val(previous);
                    }
                }else{
                    self._optionEventDetail(seq, division);

                    if (self.syncObj) { //싱크되어야하는 값(옵션 영역)이 있을 경우
                        var $target = $(self.syncObj.minicartArea).find('.' + self.syncObj.optionsSelectBox + '[data-index="' + seq + '"]');
                        $target.val(division); //싱크되어야하는 옵션 영역의 셀렉트박스에 값 지정
                        self.syncObj._optionEventDetail(seq, division); //싱크되어야하는 옵션 영역 이벤트 실행
                    }
                }
            });
        },
        _optionEventDetail: function (seq, division) {
            var self = this;
            var viewType = this.viewType;
            var osb = $(self.minicartArea).find('.' + self.optionsSelectBox);
            var osbIndex = $(self.minicartArea).find('.' + self.optionsSelectBox + '[data-index="' + (seq + 1) + '"]');

            if (!self._checkLast(seq)) { //마지막 옵션인지 체크
                if (division == '') { //선택된 값이 없으면 하위옵션 전체 비활성화
                    osb.each(function () {
                        var idx = $(this).data('index');
                        if (idx > seq) { //선택된 옵션의 하위옵션 비활성화
                            $(this).val('');
                            $(this).prop('disabled', true);
                        }
                    });
                } else { //하위옵션 데이터 노출
                    osbIndex.prop('disabled', false);
                    osbIndex.html('');
                    osb.each(function () {
                        var idx = $(this).data('index');
                        if (idx > (seq + 1)) { //선택된 옵션의 하위옵션의 하위옵션 비활성화
                            $(this).val('');
                            $(this).prop('disabled', true);
                        }
                    });
                    osbIndex.append(self._setNextOptionsHtml(seq)); //하위옵션 데이터 세팅
                }
            } else {
                if(viewType != 'change'){
                    self._makeChoosedOptionsArea(); //최종 선택된 옵션 추가
                }else{
                    self._changeOptionsAres();//최종 선택된 옵션 ID 추출 위해 옵션 수정시 프로세스 추가
                }
            }
        },
        _addOptionSelectEventBind: function () { //추가구성 선택시 이벤트
            var self = this;
            var catchData = '';

            $(self.minicartArea).find('.' + self.addOptionsSelectBox).on('change', function () { //추가구성 셀렉트박스 선택시

                var selected = $(this).val();
                var seq = parseInt($(this).data('index')); //옵션 인덱스
                var optionSelected = $(this).find('option:selected').attr('data-imagedata');

                //$('#devInvenImg_'+seq+' img').attr('src',optionSelected);
                if (selected != '') {
                    self._addOptionEventDetail(selected);
                    if (self.syncObj) { //싱크되어야하는 값(옵션 영역)이 있을 경우
                        var $target = $(self.syncObj.minicartArea).find('.' + self.syncObj.addOptionsSelectBox + '[data-index="' + seq + '"]');
                        $target.val(selected); //싱크되어야하는 옵션 영역의 셀렉트박스에 값 지정
                        self.syncObj._addOptionEventDetail(selected); //싱크되어야하는 옵션 영역 이벤트 실행
                    }
                }
            });
        },
        _addOptionEventDetail: function (selected) {
            var self = this;
            var catchData = '';
            for (var i = 0; i < self.optAddData.length; i++) {
                var details = self.optAddData[i].optionDetailList;
                var grep_data = $.grep(details, function (n, i) { //해당 상품의 추가구성 데이터와 선택된 추가구성 아이디 비교하여 데이터 추출
                    return selected == n.option_id;
                });

                if (grep_data.length > 0) { //선택된 추가구성 데이터가 추출되면 catchdata에 담기
                    catchData = grep_data[0];
                    catchData.pid = self.optAddData[i].pid;
                }
            }

            var data = self._CustomData('add', catchData);
            if (self._checkSameOption(data.option_id)) { //기추가된 추가구성인지 체크 후 템플릿 추가
                $(self.choosedContents).append(self.choosedTemplate(data));
                self._calculate();
            }
        },
        _setOptionsHtml: function (data,viewType) { //셀렉트박스의 옵션 리스트 html 생성
            var self = this;
            var str = [];
            var soldOutBool;

            var selected = self._getChoosedAll();
            var previousDivision = selected[selected.length - 1];

            for (var i = 0; i < data.length; i++) {
                if (data[i].etc_data) {
                    var etc_data = data[i].etc_data[previousDivision];
                    data[i].option_stock = etc_data.option_stock;
                    data[i].option_id = etc_data.option_id;
                }

                soldOutBool = false;
                if (data[i].option_stock !== undefined && data[i].option_stock == 0) {
                    soldOutBool = true;
                }
                if(viewType == 'button'){
                    //모바일 버튼타입 일때 option_div 대신 m_option_div 사용
                    var btnOptionDiv = data[i].m_option_div.split('[');
                    btnOptionDiv = $.trim( btnOptionDiv[0] );

                    str.push('<li class="goods-info__size__box">');
                    str.push('<button type="button" data-division="' + data[i].division + '" data-index="'+ i +'"  class="goods-info__size__btn '+this.optionsClickBox +'" data-info="'+ data[i].option_div +'" ' + (soldOutBool ? 'disabled' : '') +' >' + btnOptionDiv + ' </button>');
                    str.push('</li>');
                }else{
                    if(this.langType != 'english'){
                        var optionId = data[i].option_id ? data[i].option_id : '';
                        str.push('<option value="' + data[i].division + '" data-soldOutBool="'+soldOutBool+'" data-optionId="'+optionId+'">' + (soldOutBool ? '[품절]' : '') + data[i].option_div + '</option>');
                    }else{
                        str.push('<option value="' + data[i].division + '" ' + (soldOutBool ? 'disabled' : '') + '>' + (soldOutBool ? '[out of stock]' : '') + data[i].option_div + '</option>');
                    }
                }
            }


            return str.join('');
        },
        _setNextOptionsHtml: function (seq) { //하위 셀렉트박스의 옵션리스트 html 생성
            var contents = [];
            var nextOptionName = this.optViewData[seq + 1].option_name; //하위옵션 대분류명

					//	2021-01-26 최수빈 매니저 요청
						if(nextOptionName == "OPTION 1") {
							nextOptionName = "옵션 1 [필수]";
						} else if( nextOptionName == "OPTION 2"){
							nextOptionName = "옵션 2 [필수]";
						} else {

						}
					//	//2021-01-26 최수빈 매니저 요청

            contents.push('<option value="">' + nextOptionName + '</option>');
            contents.push(this._setOptionsHtml(this._findOptionsData(seq)));

            return contents.join('');
        },
        _setAddOptionsHtml: function (data) { //추가구성 셀렉트박스의 옵션 리스트 html 생성
            var str = [];
            var soldOutBool;
            var soldOutText;
            if(this.langType != 'english'){
                soldOutText = '품절';
            } else {
                soldOutText = 'out of stock';
            }
            for (var i = 0; i < data.length; i++) {
                if (data[i].option_stock !== undefined && data[i].option_stock == 0) {
                    soldOutBool = true;
                }
                str.push('<option data-dcprice="' + data[i].option_dcprice+ '" value="' + data[i].option_id + '" data-imageData = "' + data[i].invenImage + '" ' + (soldOutBool ? 'disabled' : '') + '>' + (soldOutBool ? '[' + soldOutText + ']' : '') + data[i].option_div + '</option>');
            }
            return str.join('');
        },
        _findOptionsData: function (seq) { //devOptionData.options 에서 하위 옵션 데이터 찾기(division, option_div 추출)
            var self = this;
            var datas = [];
            var viewoptions = self.optViewData[seq + 1].optionDetailList; //viewoptions 전체 데이터
            var chooseDivision = self._getChoosedAll(); //현재 선택된 division 리스트

            $.each(self.optData, function () { //options 데이터 루프
                //위에서 선택된 로직과 동일한 옵션 데이터 처리
                var grepData = $.grep(this.division, function (n, i) {
                    return chooseDivision[i] == n;
                });
                if (chooseDivision.length == grepData.length) { //선택한 옵션 division이 하위옵션 division과 동일할 경우 노출시킬 하위 데이터에 추가
                    var nextOptionDivision = this.division[seq + 1];
                    var find = $.grep(datas, function (d) {
                        return nextOptionDivision == d.division;
                    });
                    if(find.length == 0) {
                        var optionDiv = self._findViewOptionsData(nextOptionDivision, viewoptions); //viewoptions에서 하위옵션의 옵션구분(division), 옵션명(option_div) 추출
                        if (self._checkLast(seq + 1)) {
                            //마지막 댑스일때 옵션 데이터 추가!
                            optionDiv.option_stock = this.option_stock;
                        }
                        datas.push(optionDiv);
                    }
                }
            });
            return datas;
        },
        _findViewOptionsData: function (val, array) { //devOptionData.viewOptions 에서 옵션데이터 확인. (division=옵션구분값, option_div=옵션명.)
            var self = this;
            var optionDiv = '';
            $.each(array, function () {
                if (val == this.division) {
                    optionDiv = this;
                }
            });
            return optionDiv;
        },
        _findChoosedData: function () { //optData에서 최종 선택된 옵션 데이터 찾기.
            var self = this;
            var selected = self._getChoosedAll();
            var final = '';
            $.each(self.optData, function () {
                var grep_data = $.grep(this.division, function (n, i) {
                    return selected[i] == n;
                });

                if (selected.length == grep_data.length) {
                    final = this;
                }
            });
            return final;
        },
        _getChoosedAll: function () { //선택된 최종 옵션값들.
            var datas = [];
            var self = this;
            $(self.minicartArea).find('.' + self.optionsSelectBox).each(function () {
                var val = $(this).val();
                if (val) {
                    datas.push(val);
                }
            });
            return datas;
        },
        _makeClickOptionsArea: function (seq) { //미니카트에 최종 선택된 옵션 추가
            var self = this;
            var data = this._CustomData('button', self.optData[seq]);

            if (this._checkSameOption(data.option_id)) { //이미 추가된 옵션인지 체크
                $(this.choosedContents).append(this.choosedTemplate(data));
                this._calculate();
                $(this.addOptionsContents + ' select').prop('disabled', false); //옵션 추가되면 추가구성 활성화
            }
        },
        _makeChoosedOptionsArea: function () { //미니카트에 최종 선택된 옵션 추가
            var data = this._CustomData('', this._findChoosedData());

            if (this._checkSameOption(data.option_id)) { //이미 추가된 옵션인지 체크
				//	2021-01-26 최수빈 매니저 요청
				var ig_new_data = this.choosedTemplate(data);
					ig_new_data = ig_new_data.replace(/&lt;/g,"<");
					ig_new_data = ig_new_data.replace(/&gt;/g,">");

                //$(this.choosedContents).append(this.choosedTemplate(data));
                $(this.choosedContents).append(ig_new_data);
				//	2021-01-26 최수빈 매니저 요청

                this._reset();
                this._calculate();
                $(this.addOptionsContents + ' select').prop('disabled', false); //옵션 추가되면 추가구성 활성화
            }
        },
        _changeOptionsAres: function(){
            var self = this;
            var data = this._CustomData('', this._findChoosedData());

            self.changeOptionId = data.option_id;
        },
        _checkLast: function (seq) { //선택한 옵션이 마지막 옵션인지 확인.
            var last = $(this.minicartArea).find('.' + this.optionsSelectBox).length;
            return seq == last - 1;
        },
        _checkSameOption: function (id) { //선택된 옵션이 이미 추가되어있는지 확인
            var check = $(this.minicartArea).find('[devOptid="' + id + '"]').length;
            if (check == 0) {
                return true;
            } else {
                return false;
            }
        },
        _reset: function () { //옵션 초기화
            var self = this;
            $(self.contents + ' select').each(function () {
                $(this).find('option').eq(0).prop('selected', true);

                if ($(this).data('index') != '0') {
                    $(this).prop('disabled', true);
                }
            })
        },
        _calculate: function () { //최종가 계산
            var self = this;
            var total = 0;
            $(self.choosedContents + ' ' + self.choosedDetails).each(function () { //최종 선택 영역 루프돌림
                total = common.math.add(total, $(this).find('span.price > em').html().replace(/,/gi, ""));
            });
            $(self.totalPrice).html(common.util.numberFormat(total));

			//	ig 추가
            $(self.totalPrice_ig).html(common.util.numberFormat(total));
        },
        _cancelChoosedEventBind: function () { //선택된 옵션 삭제
            var self = this;
            $(self.choosedContents).on('click', self.deleteBtn, function () {

                var id = $(this).parents('.devOptionBox').attr('devoptid');
				console.log($(this).parent('li'));
                $('[devoptid="' + id + '"]').remove();
                // $('[data-division="' + id + '"]').removeClass('goods-info__size__btn--active');
                self._calculate();
                if (self.syncObj) {
                    self.syncObj._calculate();
                }
            });
        },
        _changeChoosedCntEventBind: function () { //개수 인풋창 이벤트 바인드
            var self = this;
            $(self.choosedContents).on('click', self.plusBtn, function () {
                self._changeCount('up', $(this));
            });

            $(self.choosedContents).on('click', self.minusBtn, function () {
                self._changeCount('down', $(this));
            });

            $(self.choosedContents).on('focusout', self.cntInput, function (e) { //키업, 키다운 추가시 프론트에서 숫자 입력하는게 어려워서 포커스아웃만 이벤트 검. 예) 최소수량 2개 주문하려는수량 12개
                self._changeCount('self', $(this));
            });

            $(self.choosedContents).on('input', self.cntInput, function (e) {
                $(this).val($(this).val().replace(/[^0-9]/g, ""));
            });

        },
        _changeCount: function (type, obj) {//넘겨받은 obj로 +, - 이벤트 수행
            var self = this;
            var id = $(obj).closest(self.choosedDetails).attr('devoptid'); //이벤트가 실행된 옵션박스 아이디
            var optionBox = $(obj).closest(self.choosedDetails); //이벤트가 실행된 옵션박스

            var data = self._checkCountValidation(type, optionBox.find('input').val(), optionBox.attr('devstock')); //수정되어야할 옵션 개수
            var unitPrice = optionBox.attr('devUnit'); //해당 옵션의 판매단가
            if (type == 'self') { //숫자 수동 입력시만 alert창 호출됨. 그 외에는 강제로 숫자만 변경. 180918 기획서 기준.
                if (data.result != '') {
                    if(data.result ==  'failStockLack'){
                        common.noti.alert(common.lang.get('cart.update.count.' + data.result + '.alert', {count: data.stock_cnt}));
                    }else if(data.result ==  'failByOnePersonCount'){
                        common.noti.alert(common.lang.get('cart.update.count.' + data.result + '.alert', {count: data.allowByPersonCnt}));
                    }else{
                        common.noti.alert(common.lang.get('cart.update.count.' + data.result + '.alert', {count: data.cnt}));
                    }
                }
            }
            $('[devoptid="' + id + '"]').find('input').val(data.cnt); //개수 변경
            $('[devoptid="' + id + '"]').find(self.price).html(common.util.numberFormat(common.math.mul(data.cnt, unitPrice))); //옵션가격 계산
            self._calculate(); //전체가 계산

            if (self.syncObj) { //싱크되어야하는 옵션 영역이 있을 경우 해당 영역도 가격 재계산
                self.syncObj._calculate();
            }
        },

        _checkCountValidation: function (type, cnt, stock) { //주문개수 제한 조건 확인
            var data = {cnt: parseInt(cnt), result: ''};

            if (type == 'up') {
                if(this.allowMaxCnt && this.allowMaxCnt > 0) {
                    if(parseInt(cnt) + 1 > this.allowMaxCnt){
                        common.noti.alert(common.lang.get('cart.update.count.failMaxCount.alert', {count: this.allowMaxCnt}));
                        data.cnt = parseInt(cnt);
                        return data;
                    }else if (parseInt(cnt) + 1 > (this.allowByPersonCnt - this.userBuyCnt) && this.allowByPersonCnt > 0) { //아이디당 숫자 이하일 경우
                        common.noti.alert(common.lang.get('cart.update.count.failByOnePersonCount.alert', {count: this.allowByPersonCnt}));
                        data.cnt = parseInt(cnt);
                        return data;
                    }else if(parseInt(cnt) + 1 <= parseInt(stock)){
                        data.cnt = parseInt(cnt) + 1;
                        return data;
                    }
                }else {
                    if (parseInt(cnt) + 1 > (this.allowByPersonCnt - this.userBuyCnt) && this.allowByPersonCnt > 0 ) {
                        common.noti.alert(common.lang.get('cart.update.count.failByOnePersonCount.alert', {count: this.allowByPersonCnt}));
                        data.cnt = parseInt(cnt);
                        return data;
                    }else if (parseInt(cnt) + 1 <= parseInt(stock)) { //재고 이하일 경우
                        data.cnt = parseInt(cnt) + 1;
                        return data;
                    }
                }
            } else if (type == 'down') {
                if (parseInt(cnt) - 1 >= this.allowBasicCnt) { //최소구매숫자 이상
                    data.cnt = parseInt(cnt) - 1;
                    return data;
                }
            } else {
                if ($.isNumeric(cnt)) { //입력된 값이 숫자일 경우 아래의 구매제한
                    if(this.allowMaxCnt && this.allowMaxCnt > 0) {
                        if(parseInt(cnt) > this.allowMaxCnt){
                            common.noti.alert(common.lang.get('cart.update.count.failMaxCount.alert', {count: this.allowMaxCnt}));
                            data.cnt = parseInt(this.allowMaxCnt);
                            return data;
                        }
                        if (parseInt(cnt) < this.allowBasicCnt) { //최소구매숫자 이상
                            data.cnt = this.allowBasicCnt;
                            data.result = 'failBasicCount';
                        }
                        if (parseInt(cnt) > parseInt(stock)) { //재고수량 이상
                            // data.cnt = stock;
                            data.stock_cnt = stock;
                            data.cnt = cnt;
                            data.result = 'failStockLack';
                        }
                        if (parseInt(cnt) > (this.allowByPersonCnt - this.userBuyCnt) && this.allowByPersonCnt > 0) {
                            data.allowByPersonCnt = this.allowByPersonCnt;
                            data.cnt = this.allowByPersonCnt - this.userBuyCnt;
                            data.result = 'failByOnePersonCount';
                        }
                    }else {
                        if (parseInt(cnt) < this.allowBasicCnt) { //최소구매숫자 이상
                            data.cnt = this.allowBasicCnt;
                            data.result = 'failBasicCount';
                        }
                        if (parseInt(cnt) > parseInt(stock)) { //재고수량 이상
                            // data.cnt = stock;
                            data.stock_cnt = stock;
                            data.cnt = cnt;
                            data.result = 'failStockLack';
                        }
                        if (parseInt(cnt) > (this.allowByPersonCnt - this.userBuyCnt) && this.allowByPersonCnt > 0) {
                            data.allowByPersonCnt = this.allowByPersonCnt;
                            data.cnt = this.allowByPersonCnt - this.userBuyCnt;
                            data.result = 'failByOnePersonCount';
                        }
                    }
                } else { //입력된 값이 숫자가 아니면 최소값 강제입력. 최소, 아이디당 최대구매수량은 컨트롤러에서 세팅됨
                    data.cnt = this.allowBasicCnt;
                }
            }
            return data;
        },
        _addCartsEventBind: function () { //장바구니, 바로구매 이벤트 바인드
            var self = this;
            var viewType = this.viewType;
            $(self.cartBtn).show();
            $(document).on('click', self.cartBtn, function (e) { //장바구니
                if(viewType == 'change'){
                    self._add('C');
                }else{
                    if( !$('.br__goods-view__minicart').hasClass('br__goods-view__minicart--show') ) {
                        $('.br__goods-view__minicart').addClass('br__goods-view__minicart--show');
                    }

                    if ($(self.minicartArea).hasClass('devOpened') ) { //devOpened 클래스 여부 확인
                        self._add('C', e);
                    } else {
                        $('.br__goods-view__minicart').addClass('br__goods-view__minicart--show');
                        $(self.minicartArea).addClass('devOpened') //퍼블 영역에서 close할 경우 devOpened 클래스remove
                    }
                }

            });

            $(self.directBtn).show();
            $(document).on('click', self.directBtn, function () { //바로구매
                if ($(self.minicartArea).hasClass('devOpened') ) { //devOpened 클래스 여부 확인
                    if (forbizCsrf.isLogin) {
                        self._add('D');
                    } else {
                        common.noti.confirm(common.lang.get('cart.nonMber.direct.confirm'), function (){
                            self._add('D');
                        }, function(){
                            document.location.href = '/member/login?url=' + encodeURI(window.location.href);
                        });
                    }
                } else {
                    $('.br__goods-view__minicart').addClass('br__goods-view__minicart--show');
                    $(self.minicartArea).addClass('devOpened') //퍼블 영역에서 close할 경우 devOpened 클래스remove
                }
            });



            if (self.changeBtn) {
                var changeBtnActionFunction = function () {
                    var cartIx = $(self.minicartArea).data('cart_ix');
                    var pcount = $(self.minicartArea).data('pcount');
                    self._change(cartIx, pcount);
                }
                if (viewType == 'change') {
                    $(self.changeBtn).click(function () { //바로구매
                        changeBtnActionFunction();
                    });
                } else {
                    $(document).on('click', self.changeBtn, function () { //바로구매
                        changeBtnActionFunction();
                    });
                }
            }




				//	페이지 내 구매하기 버튼
					$(document).on('click', '.devOrderDirect_ig', function () { //바로구매
						if($(".devOrderDirect_ig").hasClass('devOpened_igchk') == true) {
							$(".devOrderDirect_ig").removeClass('devOpened_igchk');

						} else {
							$(".devOrderDirect_ig").addClass('devOpened_igchk');

								if (forbizCsrf.isLogin) {
									self._add_ig('D');
								} else {
									common.noti.confirm(common.lang.get('cart.nonMber.direct.confirm'), function (){
										self._add_ig('D');
									}, function(){
										document.location.href = '/member/login?url=' + encodeURI(window.location.href);
									});
								}
						}
					});
				//	//페이지 내 구매하기 버튼




				//	페이지 내 장바구니 버튼
					$(document).on('click', '.devAddCart_ig', function (e) { //장바구니


						   if(viewType == 'change'){
								self._add_ig('C');
							}else{
								if ($(".devAddCart_ig").hasClass('devOpened_igchk2') == true) { //devOpened_igchk2 클래스 여부 확인
									$(".devAddCart_ig").removeClass('devOpened_igchk2');
								} else {
									$(".devAddCart_ig").addClass('devOpened_igchk2');
									self._add_ig('C', e);
								}
							}

					});
				//	//페이지 내 장바구니 버튼

        },
        _change: function(cartIx,pcount){
            var self = this;
            var pid = $(self.minicartArea).data('pid');
            var cartIxArr = [];
            var viewType = this.viewType;
            var pcount = pcount;
            var optionIdArr = [];
            var addOptionIdArr = [];
            var optionCnt = $(self.minicartArea).find('.' + self.optionsSelectBox).length;

            cartIxArr.push(cartIx);

            /*
            $(self.minicartArea).find('.' + self.optionsSelectBox).each(function(){
                var optionId = $(this).find(":selected").val();
                if(optionId){
                    optionIdArr.push(optionId);
                }
            });
            */
            if(self.changeOptionId){
                optionIdArr.push(self.changeOptionId);
            }

            $(self.minicartArea).find('.' + self.addOptionsSelectBox).each(function(){
                var addOptionId = $(this).find(":selected").val();
                if(addOptionId){
                    addOptionIdArr.push(addOptionId);
                }
            });


            if (optionIdArr.length == 0) {
                console.log('a');
                common.noti.alert(common.lang.get('cart.buy.noSelect.alert'));
                return;
            } else{
                var data = []; //본품
                var addData = []; //추가구성
                var giftData = []; //사은품
                var giftSum = 1;

                var dataComponent = {pid: pid, optionId: optionIdArr.join(','), count: pcount};
                data.push(dataComponent);


                $(addOptionIdArr).each(function(i,v){
                    var addDataComponent = {pid: pid, optionId: v, count: 1};
                    addData.push(addDataComponent);
                });

                if (addData.length > 0) { //추가구성 데이터 추가하여 옵션 데이터 최종생성
                    data[0].addOptionList = addData;

                }

                var giftBoxCnt = 0; //사은품 갯수
                var giftSelectCnt = 0;//선택된 사은품 갯수
                $(self.giftSelectBox).each(function(){
                    giftBoxCnt ++;
                    if($(this).val()){
                        giftData.push($(this).val());
                        giftSelectCnt ++;
                    }
                })

                if(giftBoxCnt > 0 && (giftBoxCnt != giftSelectCnt)){
                    common.noti.alert(common.lang.get('cart.buy.noGiftSelect.alert'));
                    return;
                }

                if(giftData.length > 0){
                    $(data).each(function(i,v){
                        data[i].giftItemList = giftData;
                        data[i].giftItemCnt = v.count;
                    });
                }

                common.ajax(common.util.getControllerUrl('add', 'cart'), {data: data,viewType:viewType,cartIxArr:cartIxArr}, "", function (result) { //shop_cart 상품 데이터 추가 ajax
                    self.isAdding = false; // add complete

                    if (result.result == 'success') {
                        document.location.reload();

                    } else if (result.result == 'noLogin') {
                        common.noti.alert(common.lang.get('cart.update.count.noLogin.alert'));
                    } else if (result.result == 'failBasicCount') { //기본 구매 수량 보다 낮은 수량
                        common.noti.alert(common.lang.get('cart.update.count.failBasicCount.alert', {count: result.data}));
                    } else if (result.result == 'failByOnePersonCount') { //ID별 구매수량 초과
                        //옵션 여러개 구매시 계산이 애매하여 추후 PM 협의 필요
                        common.noti.alert(common.lang.get('cart.update.count.failByOnePersonCount.alert', {count: result.data}))
                    } else if(result.result == 'failByOneMaxCount'){ //최대 구매수량 초과
                        common.noti.alert(common.lang.get('cart.update.count.failMaxCount.alert', {count: result.data}))
                    } else if (result.result == 'failStockLack') { //재고수량 초과
                        // 장바구니 버튼 클릭, 제한 수량 수량 초과 입력시
                        common.noti.alert(common.lang.get('cart.update.count.failStockLack.alert', {count: result.data}));
                    } else if (result.result == 'failNotNumeric') { //숫자만 입력가능
                        common.noti.alert(common.lang.get('cart.update.count.failNotNumeric.alert', {count: result.data}));
                    }else {
                        common.noti.alert('error');
                    }
                });

            }

        },


        _add: function (type, divide) { //type : 바로구매 D / 장바구니 C
            var self = this;
            // var pid = $(self.minicartArea).data('pid');

            if ($(self.choosedDetails).length == 0) {
                console.log('B');
                common.noti.alert(common.lang.get('cart.buy.noSelect.alert'));
                return;
            } else {
                var data = []; //본품
                var addData = []; //추가구성
                var giftData = []; //사은품
                var giftSum = 0;
                $(self.choosedContents).find(self.choosedDetails).each(function (i) { //각 옵션박스 영역 루프
                    // if ($(this).attr('devOptionkind') != 'a') { //추가구성 외 일반 옵션 데이터 생성
                        var dataComponent = {pid: $(this).attr('devPid'), optionId: $(this).attr('devOptid'), count: $(this).find(self.cntInput).val()}
                        data.push(dataComponent);
                    // } else { //추가구성 데이터 생성
                    //     var addDataComponent = {optionId: $(this).attr('devOptid'), count: $(this).find(self.cntInput).val()}
                    //     addData.push(addDataComponent);
                    // }
                });

                /*if (data.length == 0) { //본품 주문여부 체크
                    common.noti.alert(common.lang.get('cart.update.count.checkOrderPossible.alert'));
                    return;
                }*/
                if (addData.length > 0) { //추가구성 데이터 추가하여 옵션 데이터 최종생성
                    data[0].addOptionList = addData;

                }

                var giftBoxCnt = 0; //사은품 갯수
                var giftSelectCnt = 0;//선택된 사은품 갯수
                $(self.giftSelectBox).each(function(){
                    giftBoxCnt ++;
                    if($(this).val()){
                        giftData.push($(this).val());
                        giftSelectCnt ++;
                    }
                })

                if(giftBoxCnt > 0 && (giftBoxCnt != giftSelectCnt)){
                    common.noti.alert(common.lang.get('cart.buy.noGiftSelect.alert'));
                    return;
                }

                if(giftData.length > 0){
                    $(data).each(function(i,v){
                        data[i].giftItemList = giftData;
                        data[i].giftItemCnt = v.count;
                    });

                }



                if (self.isAdding == false) {
                    self.isAdding = true; // adding
                    common.ajax(common.util.getControllerUrl('add', 'cart'), {data: data}, "", function (result) { //shop_cart 상품 데이터 추가 ajax
                        self.isAdding = false; // add complete
                        if (result.result == 'success') {
                            if (type == 'C') { //장바구니 이동
                                if(!divide.target.classList.contains("devAddCart__layerBtn")) {
                                    common.noti.confirm(common.lang.get('cart.goCart.confirm', ''), function () {
                                        document.location.href = '/shop/cart';
                                    }, function () {
                                        document.location.reload();
                                    });
                                } else {
                                    var target = document.getElementsByClassName("devAddCart__layer");
                                    target[target.length - 1].className += " devAddCart__layer--show";
                                }
                            } else { //바로구매
                                var cartIxs = result.data;
                                document.location.href = '/shop/infoInput?cartIx=' + cartIxs.join(",");
                                // 회원
                                /*if(forbizCsrf.isLogin){
                                    document.location.href = '/shop/infoInput?cartIx=' + cartIxs.join(",");
                                    // 비회원은 로그인 페이지로 (추가 개선 사항)
                                }else{
                                    document.location.href = '/member/login?url=' + encodeURI('/shop/infoInput?cartIx=' + cartIxs.join(","));
                                }*/
                            }
                        } else if (result.result == 'noLogin') {
                            common.noti.alert(common.lang.get('cart.update.count.noLogin.alert'));
                        } else if (result.result == 'failBasicCount') { //기본 구매 수량 보다 낮은 수량
                            common.noti.alert(common.lang.get('cart.update.count.failBasicCount.alert', {count: result.data}));
                        } else if (result.result == 'failByOnePersonCount') { //ID별 구매수량 초과
                            //옵션 여러개 구매시 계산이 애매하여 추후 PM 협의 필요
                            common.noti.alert(common.lang.get('cart.update.count.failByOnePersonCount.alert', {count: result.data}))
                        } else if(result.result == 'failByOneMaxCount'){
                            common.noti.alert(common.lang.get('cart.update.count.failMaxCount.alert', {count: result.data}))
                        } else if (result.result == 'failStockLack') { //재고수량 초과
                            // 장바구니 버튼 클릭, 제한 수량 수량 초과 입력시
                            common.noti.alert(common.lang.get('cart.update.count.failStockLack.alert', {count: result.data}));
                        } else if (result.result == 'failNotNumeric') { //숫자만 입력가능
                            common.noti.alert(common.lang.get('cart.update.count.failNotNumeric.alert', {count: result.data}));
                        }else {
                            common.noti.alert('error');
                        }
                    });
                }
            }
        },




        _add_ig: function (type, divide) { //type : 바로구매 D / 장바구니 C
            var self = this;
            // var pid = $(self.minicartArea).data('pid');

            if ($(self.choosedDetails).length == 0) {
                common.noti.alert(common.lang.get('cart.buy.noSelect.alert'));
                return;
            } else {
                var data = []; //본품
                var addData = []; //추가구성
                var giftData = []; //사은품
                var giftSum = 0;
                $(self.choosedContents).find(self.choosedDetails).each(function (i) { //각 옵션박스 영역 루프
                    // if ($(this).attr('devOptionkind') != 'a') { //추가구성 외 일반 옵션 데이터 생성
                        /*var dataComponent = {
							pid: $(this).attr('devPid'), 
							optionId: $(this).attr('devOptid'), 
							count: $(this).find(self.cntInput).val()
						}
                        data.push(dataComponent);*/
                    // } else { //추가구성 데이터 생성
                    //     var addDataComponent = {optionId: $(this).attr('devOptid'), count: $(this).find(self.cntInput).val()}
                    //     addData.push(addDataComponent);
                    // }
					if ($(this).attr('devOptionkind') != 'a') { //추가구성 외 일반 옵션 데이터 생성
                        var dataComponent = {
                            pid: $(this).attr('devPid'),
                            optionId: $(this).attr('devOptid'),
                            count: $(this).find(self.cntInput).val(),
							main:'y'
                        }
                        data.push(dataComponent);
                     } else { //추가구성 데이터 생성
                         var dataComponent = {
                            pid: $(this).attr('devPid'),
                            optionId: $(this).attr('devOptid'),
                            count: $(this).find(self.cntInput).val(),
							main: 'n'
                        }
                        data.push(dataComponent);
                     }
                });

                /*if (data.length == 0) { //본품 주문여부 체크
                    common.noti.alert(common.lang.get('cart.update.count.checkOrderPossible.alert'));
                    return;
                }*/
                if (addData.length > 0) { //추가구성 데이터 추가하여 옵션 데이터 최종생성
                    data[0].addOptionList = addData;

                }

                var giftBoxCnt = 0; //사은품 갯수
                var giftSelectCnt = 0;//선택된 사은품 갯수
                $(self.giftSelectBox).each(function(){
                    giftBoxCnt ++;
                    if($(this).val()){
                        giftData.push($(this).val());
                        giftSelectCnt ++;
                    }
                })

                if(giftBoxCnt > 0 && (giftBoxCnt != giftSelectCnt)){
                    common.noti.alert(common.lang.get('cart.buy.noGiftSelect.alert'));
                    return;
                }

                if(giftData.length > 0){
                    $(data).each(function(i,v){
						if(data[i].main == "y") {
							data[i].giftItemList = giftData;
							data[i].giftItemCnt = v.count;
						}
                    });

                }



                if (self.isAdding == false) {
                    self.isAdding = true; // adding
                    common.ajax(common.util.getControllerUrl('add', 'cart'), {data: data}, "", function (result) { //shop_cart 상품 데이터 추가 ajax
                        self.isAdding = false; // add complete
                        if (result.result == 'success') {
                            if (type == 'C') { //장바구니 이동
                                DownLayerJSNew('layer-cart');
                                /*if(!divide.target.classList.contains("devAddCart__layerBtn")) {
                                    common.noti.confirm(common.lang.get('cart.goCart.confirm', ''), function () {
                                        document.location.href = '/shop/cart';
                                    }, function () {
                                        document.location.reload();
                                    });
                                } else {
                                    var target = document.getElementsByClassName("devAddCart__layer");
                                    target[target.length - 1].className += " devAddCart__layer--show";
                                }*/
                            } else { //바로구매
                                var cartIxs = result.data;
                                document.location.href = '/shop/infoInput?cartIx=' + cartIxs.join(",");
                                // 회원
                                /*if(forbizCsrf.isLogin){
                                    document.location.href = '/shop/infoInput?cartIx=' + cartIxs.join(",");
                                    // 비회원은 로그인 페이지로 (추가 개선 사항)
                                }else{
                                    document.location.href = '/member/login?url=' + encodeURI('/shop/infoInput?cartIx=' + cartIxs.join(","));
                                }*/
                            }
                        } else if (result.result == 'noLogin') {
                            common.noti.alert(common.lang.get('cart.update.count.noLogin.alert'));
                        } else if (result.result == 'failBasicCount') { //기본 구매 수량 보다 낮은 수량
                            common.noti.alert(common.lang.get('cart.update.count.failBasicCount.alert', {count: result.data}));
                        } else if (result.result == 'failByOnePersonCount') { //ID별 구매수량 초과
                            //옵션 여러개 구매시 계산이 애매하여 추후 PM 협의 필요
                            common.noti.alert(common.lang.get('cart.update.count.failByOnePersonCount.alert', {count: result.data}))
                        } else if(result.result == 'failByOneMaxCount'){
                            common.noti.alert(common.lang.get('cart.update.count.failMaxCount.alert', {count: result.data}))
                        } else if (result.result == 'failStockLack') { //재고수량 초과
                            // 장바구니 버튼 클릭, 제한 수량 수량 초과 입력시
                            common.noti.alert(common.lang.get('cart.update.count.failStockLack.alert', {count: result.data}));
                        } else if (result.result == 'failNotNumeric') { //숫자만 입력가능
                            common.noti.alert(common.lang.get('cart.update.count.failNotNumeric.alert', {count: result.data}));
                        }else {
                            common.noti.alert('error');
                        }
                    });
                }
            }
        }



    }
};