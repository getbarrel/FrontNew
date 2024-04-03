"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
common.lang.load('stock.common.alarm.cancel.confirm', "입고알림 신청을 취소하시겠습니까?");
common.lang.load('cart.update.count.noLogin.alert', "ID당 구매 가능한 수량이 제한되어있는 상품입니다. 로그인 후 구매해주세요.");
common.lang.load('cart.update.count.failBasicCount.alert', "최소 구매 가능 수량은 {count}개입니다.  {count}개 이상 입력해 주세요."); //Alert_103
common.lang.load('cart.update.count.failByOnePersonCount.alert', "ID당 구매 가능한 수량의 최대 {count}개를 초과하였습니다."); //Alert_102
common.lang.load('cart.update.count.failByOneMaxCount.alert',"최대 구매 가능 수량은 {count}개입니다.");
common.lang.load('cart.update.count.failStockLack.alert', "주문 가능한 재고수량은 최대 {count}개입니다. {count}개 이하로 입력해 주세요."); //Alert_104
common.lang.load('cart.update.count.failNoSale.alert', "해당 상품이 품절되었습니다."); //Alert_108
common.lang.load('cart.buy.noSelect.alert', "옵션을 선택해 주세요.");
common.lang.load('cart.update.count.failNotNumeric.alert', "숫자를 입력해주시기 바랍니다.");
var devChangeOption = {
    initMinicart: function () { //옵션 데이터 로드가 완료된 후 미니카트 관련 세팅 시작
        $.getScript($('#devMinicartScript').data('url'), function () {

            var centerMinicart = devMiniCart();
            var optionCode = $("#devSildeMinicartOptions").attr("data-oprioncode");
            centerMinicart
                .setOptionData(devOptionData)
                .setBasicCnt(allow_basic_cnt, allow_byoneperson_cnt)
                .setOptionViewType('change')
                .setContents('#devSildeMinicartArea', '#devSildeMinicartOptions', '#devSlideMinicartAddOption', '#devSildeLonelyOption', '#devSildeLonelyOptionName')
                .setBtn('.devMinicartDelete', '.devAddCart', '.devOrderDirect','.devChangeOption')
                .init();
            $('.devMinicartOptionsBox').val(optionCode);
        });
    },
    //상품 수량 검증
    verificationCount: function ($count) {
        var count = parseInt($count.val());
        var total_dcprice = count * parseInt($('#dcprice').val());

        total_dcprice = total_dcprice.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        $('#total_dcprice').html(total_dcprice);

        if (!(count > 0)) {
            $count.val(1);
        }
    },
    //상품 수량 수정
    changeCount: function (type, $count) {
        var self = this;
        var count = parseInt($count.val());
        if (type == 'down') {
            $count.val(count - 1);
        } else {
            $count.val(count + 1);
        }
        self.verificationCount($count);
    },
    run: function(){
        var self = this;

        self.initMinicart();

        //상품 수량 DOWN
        $('.devCountDownButton').click(function () {
            var $count = $(this).closest('.devProductContents, .devAddOptionContents').find('.devCount');
            self.changeCount('down', $count);
        });

        //상품 수량 UP
        $('.devCountUpButton').click(function () {
            var $count = $(this).closest('.devProductContents, .devAddOptionContents').find('.devCount');
            self.changeCount('up', $count);
        });

        //상품 수량 직접 수정
        $('.devCount').on('input', function (e) {
            self.verificationCount($(this));
        });

        //상품 수량 및 옵션 변경
        $('.devCountUpdateButton').click(function () {
            var count = $(this).closest('.devProductContents, .devAddOptionContents').find('.devCount').val();
            var cartIx = $(this).closest('.devProductContents, .devAddOptionContents').find('.cart_ix').val();
            var optVal = $(this).closest('.devProductContents, .goods-info__set__box').find('.devMinicartOptionsBox').val();
            var cartType = $(this).closest('.devProductContents').find('.cartType').val();
            console.log($(this));
            console.log(count + " // " + cartIx + " // " + optVal + " // " + cartType);
            if (!optVal) {
                common.noti.alert(common.lang.get('cart.buy.noSelect.alert'));
                return;
            } else{
                var data = {cartIx: cartIx, count: count, cartType:cartType, optVal:optVal};
                common.ajax(common.util.getControllerUrl('updateCountNew', 'cart'), data, "", function (result) {
                    if (result.result == 'success') {
                        document.location.reload();
                    }else if(result.result == 'noLogin'){
                        common.noti.alert(common.lang.get('cart.update.count.noLogin.alert'));
                    }
                    //기본 구매 수량 보다 낮은 수량 수정시
                    else if (result.result == 'failBasicCount') {
                        common.noti.alert(common.lang.get('cart.update.count.failBasicCount.alert', {count: result.data}));
                        document.location.reload();
                    }
                    //ID별 구매수량 초가시
                    else if (result.result == 'failByOnePersonCount') {
                        common.noti.alert(common.lang.get('cart.update.count.failByOnePersonCount.alert', {count: result.data}));
                        document.location.reload();
                    }
                    //최대 구매수량 초가시
                    else if (result.result == 'failByOneMaxCount'){
                        common.noti.alert(common.lang.get('cart.update.count.failByOneMaxCount.alert', {count: result.data}));
                        document.location.reload();
                    }
                    //장바구니 수량보다 재고가 많을경우
                    else if (result.result == 'failStockLack') {
                        common.noti.alert(common.lang.get('cart.update.count.failStockLack.alert', {count: result.data}));
                    }
                    //품절 되었을 경우
                    else if (result.result == 'failNoSale') {
                        common.noti.alert(common.lang.get('cart.update.count.failNoSale.alert'), function () {
                            document.location.reload();
                        });
                    } else {
                        common.noti.alert('error');
                    }
                });
            }
        });
    }
}

$(function () {
    devChangeOption.run();
});
