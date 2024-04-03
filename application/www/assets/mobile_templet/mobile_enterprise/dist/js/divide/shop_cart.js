/**
 * Created by forbiz on 2019-07-24.
 */
const shop_cart = () => {
    const $document = $(document);

    //option show/hide
    const goodsOptionChange = () => {
        common.lang.load('cart.option.change.title', '옵션변경');
        $document.on('click', '.cart-item__change__btn',function() {
            const pid = $(this).data('pid');
            const cartIx = $(this).data('cart_ix');
            const pcount = $(this).data('pcount');
            common.util.modal.open('ajax', common.lang.get('cart.option.change.title'), '/popup/changeOption/'+pid+'/'+encodeURIComponent(cartIx)+'/'+pcount);
        });
    }

    //배송비 추가정보
    const deliveryDesc = () => {
        $('.cart-item__result__part').on('click', '.br__delivery-desc', function(e) {
            e.stopPropagation();
            $(this).toggleClass('br__delivery-desc--show');
        });
        $('body').on('click', function() {
            $('.cart-item__result__part .br__delivery-desc').removeClass('br__delivery-desc--show');
        });

    }

    const shop_cart_init = () => {
        goodsOptionChange();
        deliveryDesc();
    }
    shop_cart_init();
}


export default shop_cart;