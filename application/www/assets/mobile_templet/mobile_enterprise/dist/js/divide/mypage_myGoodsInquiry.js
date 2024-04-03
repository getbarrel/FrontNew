/**
 * Created by forbiz on 2019-07-05.
 */
const mypage_myGoodsInquiry = () => {
    const $window = $(window);
    const $document= $(document);

    const mypage_myGoodsInquiry = () => {
        $('.opt__date').on('change', function() {
            const $dateBox = $('.br__myInquiry__date');
           if($(this).find('option:selected').hasClass('op__date--set')) {
               $dateBox.addClass('br__myInquiry__date--show');
           } else {
               $dateBox.removeClass('br__myInquiry__date--show');
           }
        });
    }

    const time_select = () => {
        $document.on("change", ".opt__date", function(){
            const $this = $(this);
            if ($this.val() == "timeSelect") {
                $(".br__sort__timeselect").addClass("br__sort__timeselect--show");
            } else {
                $(".br__sort__timeselect").removeClass("br__sort__timeselect--show");
            }
        });
    };

    const mypage_myGoodsInquiry_init = () => {
        time_select();
       // mypage_myGoodsInquiry();
    }
    mypage_myGoodsInquiry_init();
}


export default mypage_myGoodsInquiry;