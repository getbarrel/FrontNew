/**
 * Created by forbiz on 2019-07-04.
 */
const mypage_returnHistory = () => {
    const $document = $(document);
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

    const time_select = () => {
        $document.on("change", ".js__sDate", function(){
            const $this = $(this);
            if ($this.val() == "timeSelect") {
                $(".br__sort__timeselect").addClass("br__sort__timeselect--show");
            } else {
                $(".br__sort__timeselect").removeClass("br__sort__timeselect--show");
            }
        });
    }

    const return_init = () => {
        toggleCliam();
        time_select();
    }

    return_init();


}
export default mypage_returnHistory;