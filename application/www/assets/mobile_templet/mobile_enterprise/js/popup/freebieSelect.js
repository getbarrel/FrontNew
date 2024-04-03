"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/

common.lang.load('gift.update.count.failStockLack.alert', "선택 가능한 사은품 수량은 최대 {count}개입니다. {count}개 이하로 입력해 주세요."); //Alert_104
common.lang.load('gift.update.count.failOverCnt.alert', "선택 가능한 사은품 수량은 최대 {count}개입니다. {count}개 이하로 입력해 주세요."); //Alert_104
common.lang.load('gift.update.count.giftStockCheck.alert', "해당사은품 재고는 {count}개 까지 선택 가능합니다.");
common.lang.load('gift.update.count.giftItemStockCheck.alert', "{pname} 사은품은 {count}개 까지 선택 가능합니다. 다시 선택 바랍니다.");
common.lang.load('gift.update.count.giftItemSoldOut.alert', "{pname} 사은품은 품절 되었습니다. 다시 선택 바랍니다.");
common.lang.load('gift.not.select.text',"사은품 선택 안함");

var devGiftSelect = {
    init: function () {
        this._eventBind();
        this._changeCountBind();
    },
    _eventBind: function(){
        $('.devSubmit').on('click',function(){

            var cartIx = $('#cart_ix').val();
            var gift_title = $('#gift_title').val();
            var freegift_condition = $(this).data('freegift_condition');
            var giftData = [];

            $('.devGiftList').each(function(){
                var cnt = $(this).find('.devMinicartPrdCnt').val();
                var img = $(this).find('img').attr('src');
                var pname = $(this).find('img').attr('alt');
                var pid = $(this).data('pid');
                var fg_ix = $(this).data('fg_ix');
                var freegift_condition = $(this).data('freegift_condition');
                if(cnt > 0 && pid){
                    giftData.push({pid : pid,cnt : cnt,img : img,pname : pname,fg_ix : fg_ix,freegift_condition : freegift_condition});
                }
            });
            if(giftData.length > 0){
                common.ajax(
                    common.util.getControllerUrl('checkGiftItemStock', 'order'),
                    {
                        giftData: giftData
                    },
                    '',
                    function (response) {
                        if (response.result == 'success') {
                            if(response.data.giftStockBool == false){
                                if(response.data.status == 'sale'){
                                    common.noti.alert(common.lang.get('gift.update.count.giftItemStockCheck.alert', {count: response.data.stock, pname: response.data.pname}));
                                }else{
                                    common.noti.alert(common.lang.get('gift.update.count.giftItemSoldOut.alert', {pname: response.data.pname}));
                                }

                                // $('.popup-layout').find('.close').trigger('click');
                                // $('#devOrderGiftList').empty();
                                // $('.devOrderGift').hide();
                                location.reload();
                                return;
                            }else{
                                var giftHtml = "";
                                $('.devOrderGift_'+freegift_condition).show();
                                $(giftData).each(function(i,v){
                                    giftHtml +='<div class="info-goods__freebie__box devGiftListByOrder">';
                                    giftHtml +='<div class="info-goods__freebie__thumb">';
                                    giftHtml +='<figure>';
                                    giftHtml +='<img src="'+v.img+'" alt="'+v.pname+'" data-devpid="'+v.pid+'" data-devpcount="'+v.cnt+'" data-fg_ix="'+v.fg_ix+'" data-freegift_condition="'+freegift_condition+'">';
                                    giftHtml +='</figure>';
                                    giftHtml +='</div>';
                                    giftHtml +='<div class="info-goods__freebie__info">';
                                    giftHtml +='<p class="info-goods__freebie__text">'+v.pname+' / '+v.cnt+'개</p>';
                                    giftHtml +='</div>';
                                    giftHtml +='</div>';
                                });
                                $('#devOrderGiftList_'+freegift_condition).html(giftHtml);
                                $('.popup-layout').find('.close').trigger('click');
                            }
                        } else {
                            alert('system error')
                        }
                    }
                );

            }


            // common.ajax(
            //     common.util.getControllerUrl('insertGiftItem', 'cart'),
            //     {
            //         giftData: giftData,
            //         cartIx: cartIx
            //     },
            //     '',
            //     function (response) {
            //         if (response.result == 'success') {
            //             location.reload();
            //         } else {
            //             alert('system error')
            //         }
            //     }
            // );
        });

        $('.devNoChoice').on('click',function(){
            var giftHtml = "";
            var imgSrc = $(this).data('src');
            var freegift_condition = $(this).data('freegift_condition');
            $('.devOrderGift_'+freegift_condition).show();

            giftHtml +='<div class="info-goods__freebie__box devGiftListByOrder">';
            giftHtml +='<div class="info-goods__freebie__thumb">';
            giftHtml +='<figure>';
            giftHtml +='<img src="'+imgSrc+'/images/common/icon_no-freebie_mo.png" alt="" data-freegift_condition="'+freegift_condition+'">';
            giftHtml +='</figure>';
            giftHtml +='</div>';
            giftHtml +='<div class="info-goods__freebie__info">';
            giftHtml +='<p class="info-goods__freebie__text">'+common.lang.get('gift.not.select.text')+'</p>';
            giftHtml +='</div>';
            giftHtml +='</div>';

            $('#devOrderGiftList_'+freegift_condition).html(giftHtml);
            $('.popup-layout').find('.close').trigger('click');
        });
    },
    _changeCountBind: function(){
        var self = this;
        $('.devCntPlus').on('click', function () {
            self._changeCount('up', $(this));
        });

        $('.devCntMinus').on('click', function () {
            self._changeCount('down', $(this));
        });

        $('.devMinicartPrdCnt').on('focusout', function () {
            self._changeCount('self', $(this));
        });
    },
    _changeCount: function (type, obj) {//넘겨받은 obj로 +, - 이벤트 수행
        var self = this;
        var optionBox = $(obj).closest('.devControlCntBox'); //이벤트가 실행된 옵션박스
        var checkAllCnt = 0;
        var inputCnt = 0;
        $('.devMinicartPrdCnt').each(function(){
            checkAllCnt += parseInt($(this).val());
        });
        var data = this._checkCountValidation(type, optionBox.find('input').val(), optionBox.attr('devGiftCnt'),checkAllCnt);

        if (type == 'self') { //숫자 수동 입력시만 alert창 호출됨. 그 외에는 강제로 숫자만 변경. 180918 기획서 기준.
            if (data.result != '') {
                common.noti.alert(common.lang.get('gift.update.count.' + data.result + '.alert', {count: data.cnt}));
                data.cnt = 0;
            }
        }
        optionBox.find('input').val(data.cnt); //개수 변경

        //사은품 재고 체크
        var prdStock = parseInt(optionBox.attr('devGiftStock'));
        var selectStock = parseInt(optionBox.find('.devMinicartPrdCnt').val());

        if(prdStock < selectStock){
            common.noti.alert(common.lang.get('gift.update.count.giftStockCheck.alert', {count: prdStock}));
            optionBox.find('input').val(prdStock); //개수 변경
        }


        $('.devMinicartPrdCnt').each(function(){
            inputCnt += parseInt($(this).val());
        });
        $('#devSelectCnt').html(inputCnt);

    },
    _checkCountValidation: function (type, cnt, maxCnt, totalCnt) { //주문개수 제한 조건 확인
        var data = {cnt: parseInt(cnt), result: ''};

        if (type == 'up') {
            if(totalCnt >= maxCnt){
                data.cnt = parseInt(cnt);
                data.result = 'failOverCnt';
                return data;
            }else{
                if (parseInt(cnt) + 1 <= parseInt(maxCnt)) { //
                    data.cnt = parseInt(cnt) + 1;
                    return data;
                }
            }

        } else if (type == 'down') {
            if (parseInt(cnt) - 1 >= 0) { //최소구매숫자 이상
                data.cnt = parseInt(cnt) - 1;
                return data;
            }
        } else {
            if ($.isNumeric(cnt)) { //입력된 값이 숫자일 경우 아래의 구매제한
                if (parseInt(cnt) < 0) { //최소구매숫자 이상
                    data.cnt = 0;
                    data.result = '';
                }
                if (parseInt(cnt) > parseInt(maxCnt)) { //재고수량 이상
                    data.cnt = maxCnt;
                    data.result = 'failStockLack';
                }
            } else { //입력된 값이 숫자가 아니면 최소값 강제입력. 최소, 아이디당 최대구매수량은 컨트롤러에서 세팅됨
                data.cnt = 0;
            }
        }
        return data;
    },
    run: function(){
        var self = this;
        self.init();
    }
}


$(function () {
    devGiftSelect.run();
});