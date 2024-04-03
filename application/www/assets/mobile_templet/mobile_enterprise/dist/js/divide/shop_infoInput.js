/**
 * Created by forbiz on 2019-07-05.
 */
const shop_infoInput = () => {
    const $window = $(window);
    const $body = $('body');
    const $document = $(document);

    //결제 정보 입력 아코디언
    const foldingInfomation = () => {
        $body.on('click', '.infoinput__toggle__btn', function() {
            $(this).closest('.infoinput__toggle').toggleClass('infoinput__toggle--hide');
        })
    }
    //비회원 약관동의
    const nonmemberAgree = () => {

        if ($(".br__infoinput__non-agree").length > 0) {

            $document.on("click", ".agree-content__inner__title", function(){

                const $this = $(this);
                const $eachBox = $this.closest(".agree-content__inner");

                $eachBox
                    .toggleClass("agree-content__inner--active")
                    .find(".agree-content__inner__cont").slideToggle();

                $eachBox.siblings()
                    .removeClass("agree-content__inner--active")
                    .find(".agree-content__inner__cont").slideUp();

                //$("input[type='checkbox']").stopPropagation();

                return false;
            })
            .on('click', ".agree-content__inner__title input[type='checkbox']", function(e) {
                e.stopPropagation();
            })
        }
    }

    //상품영역 스크롤
    const goodsListScroll = () => {
        $('.info-goods__list').on('scroll', function() {
            const $this = $(this);
            const scrTop = $this.scrollTop();
            const contHeight = $('.info-goods__list > li').toArray().reduce(function(accumulator, currentValue){
                if(typeof accumulator == 'object') {
                    return $(accumulator).outerHeight() + $(currentValue).outerHeight();
                }else {
                    return accumulator + $(currentValue).outerHeight();
                }
            });
            if(scrTop >= contHeight - $this.height() ) {
                $this.css('-webkit-overflow-scrolling','unset');
                $this.scrollTop(contHeight - $this.height());
                $this.css('-webkit-overflow-scrolling','touch');
            }else if(scrTop <= 0){
                $this.css('-webkit-overflow-scrolling','unset');
                $this.scrollTop(0);
                $this.css('-webkit-overflow-scrolling','touch');
            }
        });
    }

    //결제 수단 버튼 이벤트
    const paytypeBtn = () => {
        const $btns = $('.info-paytype__btn');
        $btns.on('click', function() {
            $btns.removeClass('info-paytype__btn--active');
            $(this).addClass('info-paytype__btn--active');
        })
    }

    // 배송지정보 탭
    const commonTabs = () => {
        const $btn = $('.br__tabs__btn');
        $btn.on('click', function() {
            const $this = $(this);
            const _dataTarget = $this.data('target');
            $this.closest('.br__tabs__list').find('.br__tabs__btn').removeClass('br__tabs__btn--active');
            $this.addClass('br__tabs__btn--active');
            $this.closest('.br__tabs').find('.br__tabs__content').removeClass('br__tabs__content--show')
                .filter(function(idx, target){
                    return $(target).attr('data-target') == _dataTarget ? true : false;
                }).addClass('br__tabs__content--show');
        });
    }

    //배송비 추가정보
    const deliveryDesc = () => {
        $(document).on('click', '.br__delivery-desc', function(e) {
            e.stopPropagation();
            $(this).toggleClass('br__delivery-desc--show');
        });
        $('body').on('click', function() {
            $('.info-payment .br__delivery-desc').removeClass('br__delivery-desc--show');
        });

    }

    const coupon_pop = () => {

        const coupon_sel_cancel = () => {
            $document.on("change", ".js__couponpop__select", function(){
                const $this =$(this);
                if ( $this.val() == "" ) {
                    $this.closest(".coupon-sel__wrap-select").find(".coupon-sel__cancel")
                        .removeClass("coupon-sel__cancel--on");
                } else {
                    $this.closest(".coupon-sel__wrap-select").find(".coupon-sel__cancel")
                        .addClass("coupon-sel__cancel--on");
                }
            });
        }

        const cancel_fn = () => {
            $document.on("click", ".coupon-sel__cancel", function(){
                const $this = $(this);
                $this.closest(".coupon-sel__wrap-select").find(".js__couponpop__select").val("").trigger("change");
                $this.removeClass("coupon-sel__cancel--on");
            });
        }

        const coupon_init = () => {
            coupon_sel_cancel();
            cancel_fn();
        }

        coupon_init();

    }

    const shop_infoInput_init = () => {
        commonTabs();
        goodsListScroll();
        paytypeBtn();
        foldingInfomation();
        deliveryDesc();
        coupon_pop();
        nonmemberAgree();
    }
    shop_infoInput_init();
}


export default shop_infoInput;