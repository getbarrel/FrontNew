"use strict";
/*--------------------------------------------------------------*
 * 퍼블 *
 *--------------------------------------------------------------*/
$(function(){
    $('.address-link').click(function(){
        common.util.popup ('/mypage/addressbook_pop.php', 800, 520, '배송지 변경');
    });

    $('.receipt-btn').click(function(){
        common.util.popup ('/mypage/receipt_print.php', 660, 1160, '결제영수증');
    });

});

/*--------------------------------------------------------------*
 * 개발 *
 *--------------------------------------------------------------*/
