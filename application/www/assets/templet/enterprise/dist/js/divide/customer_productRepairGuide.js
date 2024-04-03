/**
 * Created by frontend on 2019-07-26.
 */
const customer_productRepairGuide = () => {
    const $document = $(document);
    const $window =  $(window);

    const repairExPopup = () => {
        const $btn = $('.repair__list__table--btn');
        const $popup = $(".repair__list__example");
        $btn.on('click', function() {
            const src = $(this).attr('data-src');
            $popup.find('img').attr('src',src);
            $popup.addClass('repair__list__example--show');

            window.oriScroll = $(window).scrollTop();
            $('body').css({
                'position' : 'fixed',
                'margin-top' : -window.oriScroll
            });
        });
        $popup.find('button, .dimmed').on('click', function(e) {
            $popup.removeClass('repair__list__example--show');
            $popup.find('img').attr('src','');
            e.preventDefault();
            $('body').css({
                'position': '',
                'margin-top': ''
            });
            $(window).scrollTop(window.oriScroll);
        });
    };


    const customer_productRepairGuide_init = () => {
        repairExPopup();
    };

    customer_productRepairGuide_init();

}


export default customer_productRepairGuide;