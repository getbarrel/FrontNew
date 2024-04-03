"use strict";

common.lang.load('product.wish.noMember.confirm', "관심상품 등록은 로그인 시에만 가능합니다.{common.lineBreak}로그인하시겠습니까?");
common.lang.load('product.wish.noMember.complete.insert', "해당 상품이 관심 상품 목록에 추가되었습니다.{common.lineBreak}마이페이지 > 관심 상품에서 확인 가능합니다.");

var wish = {
    target: '',
    setTarget: function ($target) {
        this.target = $target;
        return this;
    },
    run: function () {
        var self = this;
        var pid = $(self.target).attr('devWishBtn');
        common.ajax(common.util.getControllerUrl('wish', 'product'), {'pid': pid}, "", function (result) {
            if (result.result == 'insert') {
                $(self.target).addClass('on');
                common.noti.alert(common.lang.get('product.wish.noMember.complete.insert'));
            } else if (result.result == 'delete') {
                $(self.target).removeClass('on');
            } else {
                common.noti.alert('error');
            }
            return;
        });
    }
}

$(function () {
    $('body').on('click', '[devWishBtn]',function (e) { //관심상품
        e.preventDefault();
        var pid = $($(this)).attr('devWishBtn');
        
        if (forbizCsrf.isLogin) {
            wish.setTarget($(this)).run();
        } else {
            common.noti.confirm(common.lang.get('product.wish.noMember.confirm'), function () {
                document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
            });
        }
    });
});