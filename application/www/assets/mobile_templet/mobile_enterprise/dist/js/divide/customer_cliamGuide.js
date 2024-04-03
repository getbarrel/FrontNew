/**
 * Created by frontend on 2019-07-25.
 */

const customer_cliamGuide = () => {
    const $window = $(window);

    const toggleCliam = () => {
        const $title = $('.claim__title');
        const $cont = $('.claim__content');

        $title.on('click',function(){
            const $nextCont = $(this).next();

            $title.removeClass('active');
            $cont.slideUp();

            if($nextCont.is(':visible')){
                $nextCont.slideUp();
                $(this).removeClass('active');
            }else{
                $nextCont.slideDown();
                $(this).addClass('active');
            }
        });
    }

    const customer_cliamGuide_init = () => {
        toggleCliam();
    }
    customer_cliamGuide_init();
}


export default customer_cliamGuide;