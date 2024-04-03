/**
 * Created by forbiz on 2019-07-05.
 */
const mypage_mileage = () => {
    const $window = $(window);

    // months 버튼
    const changeMonths = () => {
        const $btns = $('.mileage-inquiry__form__btn');
        $btns.on('click', function() {
           $btns.removeClass('mileage-inquiry__form__btn--active');
           $(this).addClass('mileage-inquiry__form__btn--active');
        });
    }

    const mypage_mileage_init = () => {
        changeMonths();
    }
    mypage_mileage_init();
}


export default mypage_mileage;