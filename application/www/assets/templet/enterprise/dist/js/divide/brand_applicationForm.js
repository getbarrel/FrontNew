/**
 * Created by frontend on 2019-12-09.
 */

const brand_applicationForm = () => {

    const $document = $(document);

    const focusCheckArea = () => {
        $('.br__apply').on('click', '.apply__btn--check', function() {
            const _targetOffetTop = $('.inquiry-info').offset().top;
            const _headerH = $('.fb__main_nav').outerHeight();
            $('html,body').stop().animate({
               scrollTop :_targetOffetTop - _headerH
            });
            //$(window).scrollTop(_targetOffetTop);
        });
    };



    const application_init = () => {
        focusCheckArea();
    }

    application_init();

}

export default brand_applicationForm;