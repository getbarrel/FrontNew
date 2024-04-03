"use strict";

common.lang.load('product.wish.noMember.confirm', "관심상품 등록은 로그인 시에만 가능합니다.{common.lineBreak}로그인하시겠습니까?");
common.lang.load('product.wish.noMember.complete.insert', "해당 상품이 관심 상품 목록에 추가되었습니다.{common.lineBreak}마이페이지 > 관심 상품에서 확인 가능합니다.");

var wish = {
    target: '',
    setTarget: function ($target) {
        this.target = $target;
        return this;
    },
    run: function (_pid) {
        var self = this;
        var pid = _pid ? _pid : $(self.target).attr('data-devWishBtn');
        common.ajax(common.util.getControllerUrl('wish', 'product'), {'pid': pid}, "", function (result) {
            if (result.result == 'insert') {
                $(self.target).not('.recent__goods__btn--wish').addClass('fb__wishlist__btn--active');
                common.noti.alert(common.lang.get('product.wish.noMember.complete.insert'));
            } else if (result.result == 'delete') {
                $(self.target).not('.recent__goods__btn--wish').removeClass('fb__wishlist__btn--active');

                var pathname = window.location.pathname;
                if(pathname == '/mypage/wishlist') {
                    location.reload();
                }
            } else {
                common.noti.alert('error');
            }
            return;
        });
    }
}

function goodsWish(pid, e){
	
    if (forbizCsrf.isLogin) {
        var allData = {'pid': pid};
		var icon = e.querySelector('.ico');

        common.ajax(common.util.getControllerUrl('wish', 'product'), allData, "", function (result) {
            if (result.result == 'insert') {
                $(e).toggleClass("product-box__heart--active");
				icon.classList.remove('ico-wishlist');
				icon.classList.add('ico-wishlist2');     
                alert('해당 상품이 관심 상품 목록에 추가되었습니다.\n\n마이페이지 > 관심 상품에서 확인 가능합니다.');
            } else if (result.result == 'delete') {
                $(e).removeClass("product-box__heart--active");
				icon.classList.remove('ico-wishlist2');
				icon.classList.add('ico-wishlist');

                var pathname = window.location.pathname;
                if(pathname == '/mypage/wishlist') {
                    location.reload();
                }
            } else {
                common.noti.alert('error');
            }
        })
    } else {
        if(confirm("관심상품 등록은 로그인 시에만 가능합니다.\n\n로그인하시겠습니까?")){
            var pathname = window.location.pathname;
            document.location.href = '/member/login?url=' + encodeURI(pathname);
        }
    }
}

function contentWish(ix, type, e){
	
    if (forbizCsrf.isLogin) {
        var allData = { "con_ix": ix, "type": type };
		var icon = e.querySelector('.ico');

        common.ajax(common.util.getControllerUrl('content', 'product'), allData, "", function (result) {
            if (result.result == 'insert') {
                $(e).toggleClass("product-box__heart--active");
				icon.classList.remove('ico-wishlist');
				icon.classList.add('ico-wishlist2');     
                alert('해당 상품이 관심 상품 목록에 추가되었습니다.\n\n마이페이지 > 관심 상품에서 확인 가능합니다.');
            } else if (result.result == 'delete') {
                $(e).removeClass("product-box__heart--active");
				icon.classList.remove('ico-wishlist2');
				icon.classList.add('ico-wishlist');

                var pathname = window.location.pathname;
                if(pathname == '/mypage/wishlist') {
                    location.reload();
                }
            } else {
                common.noti.alert('error');
            }
        })
    } else {
        if(confirm("관심상품 등록은 로그인 시에만 가능합니다.\n\n로그인하시겠습니까?")){
            var pathname = window.location.pathname;
            document.location.href = '/member/login?url=' + encodeURI(pathname);
        }
    }
}
//
// $(function () {
//     $('body').on('click', '[data-devWishBtn]',function (e) { //관심상품
//         e.preventDefault();
//         var pid = $($(this)).attr('data-devWishBtn');
//         if (forbizCsrf.isLogin) {
//             wish.setTarget($(this)).run();
//         } else {
//             common.noti.confirm(common.lang.get('product.wish.noMember.confirm'), function () {
//                 document.location.href = '/member/login?url=' + encodeURI('/shop/goodsView/' + pid);
//             });
//         }
//     });
// });