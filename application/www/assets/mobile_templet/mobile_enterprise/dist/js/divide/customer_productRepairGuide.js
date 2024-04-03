/**
 * Created by frontend on 2019-07-26.
 */
const customer_productRepairGuide = () => {
    const $document = $(document);
    const $window =  $(window);

    const repairExPopup = () => {
        const $btn = $('.repair__table__btn');
        const $popup = $(".repair__example");
        $btn.on('click', function() {
            const src = $(this).attr('data-src');
            $popup.find('img').attr('src',src);
            $popup.addClass('repair__example--show');

            window.bodyScroll.fix();
        });
        $popup.find('button, .dimmed').on('click', function(e) {
            $popup.removeClass('repair__example--show');
            $popup.find('img').attr('src','');
            e.preventDefault();
            window.bodyScroll.release();
        });
    };


    const customer_productRepairGuide_init = () => {
        repairExPopup();
    };

    customer_productRepairGuide_init();

}


export default customer_productRepairGuide;