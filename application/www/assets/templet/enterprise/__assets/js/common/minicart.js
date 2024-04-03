"use strict";

common.lang.load('cart.nonMbmer.payment.confirm', "{shopName} 회원입니까?{common.lineBreak}회원인 경우 로그인하기 버튼을 선택해 주세요."); //Confirm_25
common.lang.load('cart.goCart.confirm', "해당 상품이 장바구니에 담겼습니다.");
common.lang.load('cart.delete.noSelect.alert', "삭제할 상품을 선택해 주세요."); //Alert_47
common.lang.load('cart.update.count.failBasicCount.alert', "최소 구매 가능 수량은 {count}개입니다.  {count}개 이상 입력해 주세요."); //Alert_103
common.lang.load('cart.update.count.failByOnePersonCount.alert', "ID당 구매 가능한 수량은 최대 {count}개입니다. {count}개 이하로 입력해 주세요."); //Alert_102
common.lang.load('cart.update.count.failStockLack.alert', "주문 가능한 재고수량은 최대 {count}개입니다. {count}개 이하로 입력해 주세요."); //Alert_104
common.lang.load('cart.update.count.failNoSale.alert', "해당 상품이 품절되었습니다."); //Alert_108
common.lang.load('cart.buy.noSelect.alert', "옵션을 선택해 주세요.");
common.lang.load('cart.update.count.checkOrderPossible.alert', "본품을 반드시 하나 이상 구매하셔야합니다.");
common.lang.load('cart.update.count.failNotNumeric.alert', "숫자를 입력해주시기 바랍니다.");
common.lang.load('cart.nonMber.direct.confirm', "비회원 구매를 하시겠습니까?");

//함수명 앞에 _가 붙으면 내부에서 사용하는 함수

var devMiniCart = function () {
    return {
        contents: '', //옵션 셀렉트박스 전체 영역
        optionsSelectBox: 'devMinicartOptionsBox', //각 옵션 셀렉트박스
        addOptionsContents: '', //추가구성 셀렉트박스 전체 영역
        addOptionsSelectBox: 'devMinicartAddOptionsBox', //각 추가구성 셀렉트박스
        choosedContents: '', //최종 선택된 옵션(미니카트 결과) 전체 영역
        choosedDetails: '', //최종 선택된 옵션 각각의 영역
        choosedTemplate: '', //최종 선택된 옵션 템플릿 사용
        lonelyTemplate: '', //최종 선택된 옵션 템플릿 사용
        price: '', //최종 선택된 옵션 각각의 가격
        totalPrice: '', //총 금액
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
        syncObj: false, //PC 하단 옵션영역과 싱크 맞추기 위한 값
        isAdding: false, //추가중 태그
        setOptionData: function (optionData) { //데이터 세팅
            this.optData = optionData.options; //옵션별로 조합된 최종 데이터
            this.optViewData = optionData.viewOptions; //프론트 노출에 사용하기 위해 분리한 옵션 데이터
            this.optAddData = optionData.addOptions; //추가구성 데이터
            return this;
        },
        setBasicCnt: function (allowBasicCnt, allowByPersonCnt) { //최소, 아이디당 최대수량 세팅
            if (allowBasicCnt > 0) {
                this.allowBasicCnt = allowBasicCnt;
            }
            if (allowByPersonCnt > 0) {
                this.allowByPersonCnt = allowByPersonCnt;
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
        setControlCntElement: function (boxId, p, m, id) { //최종 선택된 옵션개수 변경
            this.controlCntBox = boxId;
            this.plusBtn = p;
            this.minusBtn = m;
            this.cntInput = id;
            return this;
        },
        setBtn: function (deleteBtn, cartBtn, directBtn) {
            this.deleteBtn = deleteBtn;
            this.cartBtn = cartBtn;
            this.directBtn = directBtn;
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
        },
        sync: function (cartObj) {
            this.syncObj = cartObj; //상단, 하단 옵션 영역을 싱크하기 위한 작업
        },
        _CustomData: function (type, data) { //각 옵션(추가구성, 1개 등) 노출에 필요한 데이터 커스텀
            if (type == 'only') {
                data.option_name = data.option_div;
                //data.option_div = '';
                data.option_kind = '';
            } else if (type == 'add') {
                data.option_div = data.option_div;
                data.option_kind = 'a';
            } else {
                data.option_kind = '';
            }

            data.allowBasicCnt = this.allowBasicCnt;
            data.eachPrice = common.util.numberFormat(this.allowBasicCnt * data.option_dcprice);
            return data;
        },
        _makeOptionsArea: function () { //옵션 셀렉트박스 생성
            if (this.optData.length == 1) { //옵션 1개일 경우 영역 노출
                this._makeLonelyOptionsArea();
            } else {
                var str = [];

                for (var i = 0; i < this.optViewData.length; i++) {
                    var details = this.optViewData[i].optionDetailList;
                    var option_name = this.optViewData[i].option_name;

                    if (i == 0) {
                        str.push('<select class="' + this.optionsSelectBox + '" data-index=' + i + '>');
                        str.push('<option value="">' + option_name + '</option>');
                        str.push(this._setOptionsHtml(details)); //<option> 리스트 html 생성
                        str.push('</select>');
                    } else {
                        str.push('<select class="' + this.optionsSelectBox + '" data-index=' + i + ' disabled>');
                        str.push('<option value="">' + option_name + '</option>');
                        str.push('</select>');
                    }
                }
                $(this.contents).append(str.join(''));
            }
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
                if (this.optData.length > 1 && this.optViewData.length > 1) { //1개 옵션이 아닐 경우에는 최초엔 선택불가
                    addAttr = 'disabled';
                }
                for (var i = 0; i < this.optAddData.length; i++) {
                    var details = this.optAddData[i].optionDetailList;
                    var option_name = this.optAddData[i].option_name;
                    str.push('<select class="devMinicartAddOptionsBox" ' + addAttr + ' data-index="' + i + '">');
                    str.push('<option value="">' + option_name + '</option>');
                    str.push(this._setAddOptionsHtml(details)); //<option> 리스트 html 생성
                    str.push('</select>');
                }
                $(this.addOptionsContents).append(str.join('')).removeClass('hidden');
            }
        },
        _optionSelectEventBind: function () { //옵션 선택시 이벤트 바인드
            var self = this;
            $(self.minicartArea).find('.' + self.optionsSelectBox).on('change', function () { //옵션 셀렉트박스 선택시
                var seq = parseInt($(this).data('index')); //옵션 인덱스
                var division = $(this).val(); //옵션 구분

                self._optionEventDetail(seq, division);
                if (self.syncObj) { //싱크되어야하는 값(옵션 영역)이 있을 경우
                    var $target = $(self.syncObj.minicartArea).find('.' + self.syncObj.optionsSelectBox + '[data-index="' + seq + '"]');
                    $target.val(division); //싱크되어야하는 옵션 영역의 셀렉트박스에 값 지정
                    self.syncObj._optionEventDetail(seq, division); //싱크되어야하는 옵션 영역 이벤트 실행
                }
            });
        },
        _optionEventDetail: function (seq, division) { //옵션 선택시 이벤트
            var self = this;
            var osb = $(self.minicartArea).find('.' + self.optionsSelectBox);
            var osbIndex = $(self.minicartArea).find('.' + self.optionsSelectBox + '[data-index="' + (seq + 1) + '"]');

            if (!self._checkLast(seq)) { //마지막 옵션인지 체크
                if (division == '') { //선택된 값이 없으면 하위옵션 전체 비활성화
                    osb.each(function () {
                        var idx = $(this).data('index');
                        if (idx > seq) { //선택된 옵션의 하위옵션 비활성화
                            $(this).prop('disabled', true);
                        }
                    });
                } else { //하위옵션 데이터 노출
                    osbIndex.prop('disabled', false);
                    osbIndex.empty();
                    osbIndex.append(self._setNextOptionsHtml(seq)); //하위옵션 데이터 세팅

                    osb.each(function () {
                        var idx = $(this).data('index');
                        if (idx > (seq + 1)) { //선택된 옵션의 하위옵션의 하위옵션 비활성화
                            $(this).prop('disabled', true);
                        }
                    });
                }
            } else {
                self._makeChoosedOptionsArea(); //최종 선택된 옵션 추가
            }
        },
        _addOptionSelectEventBind: function () { //추가구성 선택시 이벤트 바인드
            var self = this;
            $(self.minicartArea).find('.' + self.addOptionsSelectBox).on('change', function () { //추가구성 셀렉트박스 선택시
                var seq = parseInt($(this).data('index')); //옵션 인덱스
                var selected = $(this).val();

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
        _addOptionEventDetail: function (selected) { //추가구성 선택시 이벤트
            var self = this;
            var catchData = '';
            for (var i = 0; i < self.optAddData.length; i++) {
                var details = self.optAddData[i].optionDetailList;
                var grep_data = $.grep(details, function (n, i) { //해당 상품의 추가구성 데이터와 선택된 추가구성 아이디 비교하여 데이터 추출
                    return selected == n.option_id;
                });

                if (grep_data.length > 0) { //선택된 추가구성 데이터가 추출되면 catchdata에 담기
                    catchData = grep_data[0];
                }
            }

            var data = self._CustomData('add', catchData);
            if (self._checkSameOption(data.option_id)) { //기추가된 추가구성인지 체크 후 템플릿 추가
                $(self.choosedContents).append(self.choosedTemplate(data));
                self._calculate();
            }
        },
        _setOptionsHtml: function (data) { //셀렉트박스의 옵션 리스트 html 생성
            var str = [];
            var soldOutBool;
            for (var i = 0; i < data.length; i++) {
                soldOutBool = false;
                if (data[i].option_stock !== undefined && data[i].option_stock == 0) {
                    soldOutBool = true;
                }
                str.push('<option value="' + data[i].division + '" ' + (soldOutBool ? 'disabled' : '') + '>' + (soldOutBool ? '[품절]' : '') + data[i].option_div + '</option>');
            }
            return str.join('');
        },
        _setNextOptionsHtml: function (seq) { //하위 셀렉트박스의 옵션리스트 html 생성
            var contents = [];
            var nextOptionName = this.optViewData[seq + 1].option_name; //하위옵션 대분류명

            contents.push('<option value="">' + nextOptionName + '</option>');
            contents.push(this._setOptionsHtml(this._findOptionsData(seq)));

            return contents.join('');
        },
        _setAddOptionsHtml: function (data) { //추가구성 셀렉트박스의 옵션 리스트 html 생성
            var str = [];
            for (var i = 0; i < data.length; i++) {
                str.push('<option value="' + data[i].option_id + '">' + data[i].option_div + '</option>');
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
                    var optionDiv = self._findViewOptionsData(nextOptionDivision, viewoptions); //viewoptions에서 하위옵션의 옵션구분(division), 옵션명(option_div) 추출
                    if (self._checkLast(seq + 1)) {
                        //마지막 댑스일때 옵션 데이터 추가!
                        optionDiv.option_stock = this.option_stock;
                    }
                    datas.push(optionDiv);
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
        _makeChoosedOptionsArea: function () { //미니카트에 최종 선택된 옵션 추가
            var data = this._CustomData('', this._findChoosedData());

            if (this._checkSameOption(data.option_id)) { //이미 추가된 옵션인지 체크
                $(this.choosedContents).prepend(this.choosedTemplate(data));

                this._reset();
                this._calculate();

                $(this.addOptionsContents + ' select').prop('disabled', false); //옵션 추가되면 추가구성 활성화
            }
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

                if ($(this).index() > 0) {
                    $(this).prop('disabled', true);
                }
            })
        },
        _calculate: function () { //최종가 계산
            var self = this;
            var total = 0;
            $(self.choosedContents + ' ' + self.choosedDetails).each(function () { //최종 선택 영역 루프돌림
                total = total + parseInt($(this).find('div.price > em').html().replace(/,/gi, ""));
            });
            $(self.totalPrice).html(common.util.numberFormat(total));
        },
        _cancelChoosedEventBind: function () { //선택된 옵션 삭제
            var self = this;
            $(self.choosedContents).on('click', self.deleteBtn, function () {
                var id = $(this).parent().attr('devoptid');
                $('[devoptid="' + id + '"]').remove();
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
        },
        _changeCount: function (type, obj) {//넘겨받은 obj로 +, - 이벤트 수행
            var self = this;
            var id = $(obj).closest(this.choosedDetails).attr('devoptid'); //이벤트가 실행된 옵션박스 아이디. 상단, 하단 옵션 영역의 선택된 옵션 영역 데이터 변경에 사용됨
            var optionBox = $(obj).closest(this.choosedDetails); //이벤트가 실행된 옵션박스
            var data = this._checkCountValidation(type, optionBox.find('input').val(), optionBox.attr('devstock')); //수정되어야할 옵션 개수
            var unitPrice = parseInt(optionBox.attr('devUnit')); //해당 옵션의 판매단가
            if (type == 'self') { //숫자 수동 입력시만 alert창 호출됨. 그 외에는 강제로 숫자만 변경. 180918 기획서 기준.
                if (data.result != '') {
                    common.noti.alert(common.lang.get('cart.update.count.' + data.result + '.alert', {count: data.cnt}));
                }
            }
            $('[devoptid="' + id + '"]').find('input').val(data.cnt); //개수 변경
            $('[devoptid="' + id + '"]').find(this.price).html(common.util.numberFormat(data.cnt * unitPrice)); //옵션가격 계산
            this._calculate(); //전체가 계산

            if (self.syncObj) { //싱크되어야하는 옵션 영역이 있을 경우 해당 영역도 가격 재계산
                self.syncObj._calculate();
            }
        },
        _checkCountValidation: function (type, cnt, stock) { //주문개수 제한 조건 확인
            var data = {cnt: parseInt(cnt), result: ''};

            if (type == 'up') {
                if (parseInt(cnt) + 1 <= parseInt(stock)) { //재고 이하일 경우
                    data.cnt = parseInt(cnt) + 1;
                    return data;
                } else if (parseInt(cnt) + 1 <= this.allowByPersonCnt && this.allowByPersonCnt > 0) { //아이디당 숫자 이하일 경우
                    data.cnt = parseInt(cnt) + 1;
                    return data;
                }
            } else if (type == 'down') {
                if (parseInt(cnt) - 1 >= this.allowBasicCnt) { //최소구매숫자 이상
                    data.cnt = parseInt(cnt) - 1;
                    return data;
                }
            } else {
                if ($.isNumeric(cnt)) { //입력된 값이 숫자일 경우 아래의 구매제한
                    if (parseInt(cnt) < this.allowBasicCnt) { //최소구매숫자 이상
                        data.cnt = this.allowBasicCnt;
                        data.result = 'failBasicCount';
                    }
                    if (parseInt(cnt) > parseInt(stock)) { //재고수량 이상
                        data.cnt = stock;
                        data.result = 'failStockLack';
                    }
                    if (parseInt(cnt) > this.allowByPersonCnt && this.allowByPersonCnt > 0) {
                        //옵션 여러개 넘길시 숫자 계산이 애매하여 PM 협의필요
                    }
                } else { //입력된 값이 숫자가 아니면 최소값 강제입력. 최소, 아이디당 최대구매수량은 컨트롤러에서 세팅됨
                    data.cnt = this.allowBasicCnt;
                }
            }
            return data;
        },
        _addCartsEventBind: function () { //장바구니, 바로구매 이벤트 바인드
            var self = this;
            $(self.cartBtn).show();
            $(document).on('click', self.cartBtn, function () { //장바구니
                self._add('C');
            });

            $(self.directBtn).show();
            $(document).on('click', self.directBtn, function () { //바로구매
                if (forbizCsrf.isLogin) {
                    self._add('D');
                } else {
                    common.noti.confirm(common.lang.get('cart.nonMber.direct.confirm'), function (){
                        self._add('D');
                    });
                }
            });
        },
        _add: function (type) { //type : 바로구매 D / 장바구니 C
            var self = this;
            var pid = $(self.minicartArea).data('pid');

            if ($(self.minicartArea).find(self.choosedDetails).length == 0) {
                common.noti.alert(common.lang.get('cart.buy.noSelect.alert'));
                return;
            } else {
                var data = []; //본품
                var addData = []; //추가구성
                $(self.choosedContents).find(self.choosedDetails).each(function () { //각 옵션박스 영역 루프
                    if ($(this).attr('devOptionkind') != 'a') { //추가구성 외 일반 옵션 데이터 생성
                        var dataComponent = {pid: pid, optionId: $(this).attr('devOptid'), count: $(this).find(self.cntInput).val()}
                        data.push(dataComponent);
                    } else { //추가구성 데이터 생성
                        var addDataComponent = {optionId: $(this).attr('devOptid'), count: $(this).find(self.cntInput).val()}
                        addData.push(addDataComponent);
                    }
                });

                if (data.length == 0) { //본품 주문여부 체크
                    common.noti.alert(common.lang.get('cart.update.count.checkOrderPossible.alert'));
                    return;
                }
                if (addData.length > 0) { //추가구성 데이터 추가하여 옵션 데이터 최종생성
                    data[0].addOptionList = addData;
                }

                if (self.isAdding == false) {
                    self.isAdding = true; // adding
                    common.ajax(common.util.getControllerUrl('add', 'cart'), {data: data}, "", function (result) { //shop_cart 상품 데이터 추가 ajax
                        self.isAdding = false; // add complete
                        if (result.result == 'success') {
                            if (type == 'C') { //장바구니 이동
                                common.noti.confirm(common.lang.get('cart.goCart.confirm', ''),
                                    function () {
                                        document.location.href = '/shop/cart';
                                    },
                                    function () {
                                        window.location.reload();
                                    });
                            } else { //바로구매
                                var cartIxs = result.data;
                                document.location.href = '/shop/infoInput?cartIx=' + cartIxs.join(",");
                            }
                        } else if (result.result == 'failBasicCount') { //기본 구매 수량 보다 낮은 수량
                            common.noti.alert(common.lang.get('cart.update.count.failBasicCount.alert', {count: result.data}));
                        } else if (result.result == 'failByOnePersonCount') { //ID별 구매수량 초과
                            //옵션 여러개 구매시 계산이 애매하여 추후 PM 협의 필요
                        } else if (result.result == 'failStockLack') { //재고수량 초과
                            common.noti.alert(common.lang.get('cart.update.count.failStockLack.alert', {count: result.data}));
                        } else if (result.result == 'failNotNumeric') { //숫자만 입력가능
                            common.noti.alert(common.lang.get('cart.update.count.failNotNumeric.alert', {count: result.data}));
                        } else {
                            common.noti.alert('error');
                        }
                    });
                }
            }
        }
    }
};