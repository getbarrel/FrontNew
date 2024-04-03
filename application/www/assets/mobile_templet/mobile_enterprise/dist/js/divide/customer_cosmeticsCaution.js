/**
 * Created by frontend on 2019-07-25.
 */

const customer_cosmeticsCaution = () => {
    const $window = $(window);

    const toggleCliam = () => {
        const $title = $('.cosmetics__category__title');
        const $cont = $('.cosmetics__category__content');

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

    const cosmetics_init = () => {
        toggleCliam();
    }
    cosmetics_init();
}


export default customer_cosmeticsCaution;