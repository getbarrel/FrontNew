/**
 * Created by forbiz on 2019-07-05.
 */
const mypage_orderClaim = () => {
    const $window = $(window);
    const $body = $('body');

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



    const mypage_orderClaim_init = () => {
        commonTabs();
    }
    mypage_orderClaim_init();
}


export default mypage_orderClaim;