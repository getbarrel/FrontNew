/**
 * Created by forbiz on 2019-02-11.
 */

const shop_cart = () => {
    const $document = $(document);
    const $window = $(window);
    const delivery_desc = () => {
        const $target = $(".shop-right-area");
        $document
            .on("mouseenter mouseleave", ".js__cart__delivery-icon", function(e){
                if(e.type == "mouseenter") {
                    $target.find(".fb__cart__layer-delivery").addClass("fb__cart__layer-delivery--show");
                } else{
                    $target.find(".fb__cart__layer-delivery").removeClass("fb__cart__layer-delivery--show");
                }
            })
    }

    const option_change = () => {
        //option show/hide
        $document.on('click', '.cart-item__change__btn',function() {
            const pid = $(this).data('pid');
            const cartIx = $(this).data('cart_ix');
            const pcount = $(this).data('pcount');
            const title = $(this).data('title');
            common.util.modal.open('ajax', title, '/popup/changeOption/'+pid+'/'+encodeURIComponent(cartIx)+'/'+pcount);
        });
    }

    const changeoption_cancel = () => {
        $document.on("click", ".js__change-option__cancel", function(e){
            $(".popup-layout .close").trigger("click");
        })
    }

    const aside_fixed = () => {
        const $fixed_bar = $(".shop-right-area");

        if ($('.shop-total-price').length) {
            $window.on( "scroll", function () {
                const _target_top = $('.fb__cart__layout-section').offset().top;
                const _win_top = $window.scrollTop();
                const _footer_top = $("#footer").offset().top;

                if($(".fb__cart__item-wrap tr").length > 1) {
                    if (_win_top + $(".fb__headerTop").height() + $("#navigation").height() > _target_top) {
                        if (_win_top + $fixed_bar.height() - $(".fb__headerTop").height() + $("#navigation").height() > _footer_top ) {
                            $fixed_bar.addClass("sticky").addClass("bottom").css("top" , "");
                        } else {
                            $fixed_bar.addClass("sticky").removeClass("bottom").css("top" , $(".fb__headerTop").height() + $("#navigation").height());
                        }
                    } else {
                        $fixed_bar.removeClass("sticky").removeClass("bottom").css("top" , "");
                    }
                }
                console.log("1235");
            })
        }
    }

    const checkbox_fn = () => {

        const $all_check = $("#cart_all_check");
        const $each_check = $(".cart_product_check");

        const relation_checkbox = ($all_checkbox, $target_checkbox) => {
            $all_checkbox.click(function () {
                if ($all_checkbox.is(':checked')) {
                    $target_checkbox.prop("checked", true);
                } else {
                    $target_checkbox.prop("checked", false);
                }
            });

            $target_checkbox.click(function () {
                if ($target_checkbox.length == $target_checkbox.filter(':checked').length) {
                    $all_checkbox.prop("checked", true);
                } else {
                    $all_checkbox.prop("checked", false);
                }
            });
        }
        $each_check.each(function (i, obj) {
            relation_checkbox($all_check, $(obj).closest('.seller-box').find('.cart_product_check:enabled'));
        });

    }
    const cart_init = () => {
        delivery_desc();
        option_change();
        changeoption_cancel();
        aside_fixed();
        checkbox_fn();
    }

    cart_init();
}

export default shop_cart;