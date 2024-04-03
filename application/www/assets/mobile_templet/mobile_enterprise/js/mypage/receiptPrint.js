"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
var devObj = {
    run: function () {
        $('.devCachInfo').on('click', function(){
            // 현금영수증 조회
            //http://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=cash_bill&cash_no= [현금영수증거래번호]&order_id=[주문번호]&trade_mony=[거래금액]
            var url = "http://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=cash_bill&cash_no=" + $(this).data('tid') + "&order_id=" + $(this).data('oid') + "&trade_mony=" + $(this).data('total');
            location.href=url;
        });

        $('.devCardInfo').on('click', function(){
            // 카드 매출 전표 조회
            //https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno= [NHN KCP거래번호]&order_no=[주문번호]&trade_mony=[거래금액]
            var url = "https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=" + $(this).data('tid') + "&order_no=" + $(this).data('oid') + "&trade_mony=" + $(this).data('total');
            location.href=url;
        });
    }
};

$(function () {
    devObj.run();
});